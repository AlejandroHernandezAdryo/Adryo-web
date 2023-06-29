<?php
App::uses('AppController', 'Controller');
/**
 * Agendas Controller
 *
 * @property Agenda $Agenda
 * @property PaginatorComponent $Paginator
 */
class AgendasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('Agenda','Cliente','User');
        
        public function beforeFilter() {
            parent::beforeFilter();
			if ($this->Session->read('CuentaUsuario.Cuenta.id'!= NULL)) {
				$this->Session->write(
				  'clundef',
				  $this->Cliente->find(
					'count',array(
					  'conditions'=>array(
						'AND'=>array(
						  'Cliente.user_id IS NULL'
						),
						'OR'=>array(
						  'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
						  "Cliente.desarrollo_id IN (SELECT id FROM desarrollos WHERE comercializador_id = ".$this->Session->read('CuentaUsuario.Cuenta.id').")"
						)
					  )
					)
				  )
				);
			  }
			$this->Auth->allow(array('get_add'));
        }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Agenda->recursive = 0;
		$this->set('agendas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Agenda->exists($id)) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$options = array('conditions' => array('Agenda.' . $this->Agenda->primaryKey => $id));
		$this->set('agenda', $this->Agenda->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Agenda->create();
                        $timestamp = date('Y-m-d H:i:s');
                        $this->request->data['Agenda']['fecha']=$timestamp ;
						if ($this->Agenda->save($this->request->data)) {
                            
                            $this->Agenda->query("UPDATE clientes SET last_edit = '$timestamp' WHERE id = ".$this->request->data['Agenda']['cliente_id']);
                                
                            if ($this->request->data['Agenda']['asesoria']==1){
								$this->loadModel('Mailconfig');
                                $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                                $cliente = $this->Cliente->read(null,$this->request->data['Agenda']['cliente_id']);
                                $usuario = $this->User->read(null, $this->request->data['Agenda']['user_id']);
								$this->Email = new CakeEmail();
                                $this->Email->config(array(
                                    'host'      => $mailconfig['Mailconfig']['smtp'],
                                    'port'      => $mailconfig['Mailconfig']['puerto'],
                                    'username'  => $mailconfig['Mailconfig']['usuario'],
                                    'password'  => $mailconfig['Mailconfig']['password'],
                                    'transport' => 'Smtp'
                                    )
                                );
								$this->Email->emailFormat('html');
								$this->Email->template('asesoria','layoutinmomail');
                                //$this->Email->template('emailaasesor','layoutinmomail');
                                $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
								$this->Email->to($cliente['User']['correo_electronico']);
								$this->Email->subject('Notificación para seguimiento de cliente');
								$this->Email->viewVars(array('asesor'=>$usuario,'comentarios'=>$this->request->data['Agenda']['mensaje'],'cliente' => $cliente,'fecha'=>date("d/M/Y H:i:s")));
                                $this->Email->send();
								
                            }
								$this->Session->setFlash('', 'default', array(), 'success');
								$this->Session->setFlash('El seguimiento rápido se ha guardado exitosamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Agenda']['cliente_id']));
			} else {
				// $this->Session->setFlash(__('The agenda could not be saved. Please, try again.'));
			}
		}
		$users = $this->Agenda->User->find('list');
		$leads = $this->Agenda->Lead->find('list');
		$this->set(compact('users', 'leads'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($cliente_id = null) {

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Agenda']['id']            = $this->request->data['agendaEdicion']['id_seguimiento'];
			$this->request->data['Agenda']['mensaje']       = $this->request->data['agendaEdicion']['mensaje'];
			$this->request->data['Agenda']['fecha_edicion'] = date('Y-m-d H:m:i');
			$this->Agenda->save($this->request->data);
		}

		$this->redirect(array('controller' => 'clientes', 'action' => 'view', $cliente_id));

	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($cliente_id = null) {

		$this->request->onlyAllow('post', 'delete');
        $agenda_id = $this->request->data['agendaEliminar']['id_seguimiento'];
        $this->Agenda->id = $this->request->data['agendaEliminar']['id_seguimiento'];

        if (!$this->Agenda->exists()) {
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('No se ha podido eliminar el seguimiento, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
        }

		if( $this->Agenda->delete() ) {

            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('El seguimiento se ha eliminado exitosamente.', 'default', array(), 'm_success');

        }else {

            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Hubo un error al intentar eliminar el seguimiento.', 'default', array(), 'm_success');

        }
		$this->redirect(array('controller' => 'clientes', 'action' => 'view', $cliente_id));
	}

	public function get_add( $user_id = null ) {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
		header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		$this->layout = null;
		$timestamp = date('Y-m-d H:i:s');

	  
		$cliente_id = $this->request->data['clienteId'];
		$mensaje = $this->request->data['mensaje'];
		//$cliente_id = 25027;
		//$mensaje = "Mensaje forzado desde controlador";
		$this->request->data['Agenda']=array();
		$this->request->data['Agenda']['cliente_id'] = $cliente_id;
		$this->request->data['Agenda']['lead_id']    = 0;
		$this->request->data['Agenda']['mensaje']    = $mensaje;
		$this->request->data['Agenda']['fecha']      = $timestamp;
		$this->request->data['Agenda']['user_id']    = $user_id;
		//$this->Agenda->create();
		if ($this->Agenda->save($this->request->data['Agenda'])) {
						
			$this->Agenda->query("UPDATE clientes SET last_edit = '$timestamp' WHERE id = $cliente_id");
				
			$resp = array(
				'Ok' => true,
				'mensaje' => 'Se guardo correctamente la informacion.'
			);
		} else {
			$resp = array(
				'Ok' => false,
				'mensaje' => 'No se ha guardado la informacion, favor de intentarlo nuevamente.'
			);
		}
		echo json_encode($resp, true);
		$this->autoRender = false; 
	}

}
