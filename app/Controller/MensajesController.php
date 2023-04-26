<?php
App::uses('AppController', 'Controller');
/**
 * Agendas Controller
 *
 * @property Agenda $Agenda
 * @property PaginatorComponent $Paginator
 */
class MensajesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('Mensaje','User','Cliente','Inmueble','Desarrollo');
         
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
             $this->Auth->allow('index');
        }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('eventos',$this->Event->find('all', array('conditions'=>array('or'=>array('recordatorio_1 LIKE "'.date('Y-m-d H:i').'%"','recordatorio_2 LIKE "'.date('Y-m-d H:i').'%"')))));
                
            //$eventos = $this->Event->find('all', array('conditions'=>array('Event.id'=>95)));
            $this->set('eventos',$eventos);
            foreach ($eventos as $evento):
                $this->Email = new CakeEmail();
                $this->Email->config(array(
                            'host' => 'ssl://lpmail01.lunariffic.com',
                            'port' => 465,
                            'username' => 'sistemabos@bosinmobiliaria.mx',
                            'password' => 'Sistema.2016',
                            'transport' => 'Smtp'
                            )
                    );
                $this->Email->emailFormat('html');
                $this->Email->template('recordatorio','bosemail');
                $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
                $this->Email->to($evento['To']['correo_electronico']);
                $this->Email->subject('Recordatorio de Evento');
                $this->Email->viewVars(array('evento'=>$evento));
                $this->Email->send();
            endforeach;
	}
        
        public function enviar(){
            
            //$eventos = $this->Event->find('all', array('conditions'=>array('recordatorio_1 LIKE "'.date('Y-m-d H:i').'%"')));
            $eventos = $this->Event->find('all', array('conditions'=>array('Event.id'=>95)));
            foreach ($eventos as $evento):
                $this->Email = new CakeEmail();
                $this->Email->config(array(
                            'host' => 'ssl://lpmail01.lunariffic.com',
                            'port' => 465,
                            'username' => 'sistemabos@bosinmobiliaria.mx',
                            'password' => 'Sistema.2016',
                            'transport' => 'Smtp'
                            )
                    );
                $this->Email->emailFormat('html');
                $this->Email->template('recordatorio','bosemail');
                $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
                $this->Email->to($evento['User']['correo_electronico']);
                $this->Email->subject('Recordatorio de Evento');
                $this->Email->viewVars(array('evento'=>$evento));
                $this->Email->send();
            endforeach;
            
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
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
      $this->request->data['Mensaje']['creation_date']   = date('Y-m-d');
      $this->request->data['Mensaje']['created_by']      = $this->Session->read('Auth.User.id');
      $this->request->data['Mensaje']['cuenta_id']       = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
      $this->request->data['Mensaje']['expiration_date'] = date("Y-m-d",strtotime($this->request->data['Mensaje']['ff']));
      
      $this->Mensaje->create();
      if ($this->Mensaje->save($this->request->data)) {
          $this->Session->setFlash('Se ha guardado correctamente el mensaje.', 'default', array(), 'm_success'); // Mensaje
      } else {
        $this->Session->setFlash('No se ha podido guardar el mensaje, favor de intentarlo nuevamente.', 'default', array(), 'm_success'); // Mensaje
      }
      
      $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
      return $this->redirect(array('action' => 'dashboard','controller'=>'users'));
    }
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
            $this->layout= 'calendar';
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		if ($this->request->is(array('post', 'put'))) {
                    //$this->request->data['Event']['hr_i'] = $this->request->data['Event']['hr_i']['hour'];
                    //$this->request->data['Event']['hr_i'] = $this->request->data['Event']['min_i']['min_i'];
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('El evento se ha modificado exitosa,ente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'calendar','controller'=>'users'));
			} else {
				$this->Session->setFlash(__('The agenda could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		
                }
		$this->set('inmuebles',$this->Inmueble->find('list'));
                    $this->set('desarrollos',$this->Desarrollo->find('list'));
                    $this->set(compact('clientes'));
                    $this->set('users',$this->User->find('list'));
                    $this->set('event',$this->Event->read(null,$id));
                    $this->set('eventos',$this->Event->find('all',array('conditions'=>array('Event.to'=>$this->Session->read('Auth.User.id')))));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete_desarrollo($id = null,$desarrollo = null) {
		$this->Mensaje->id = $id;
		if (!$this->Mensaje->exists()) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Mensaje->delete()) {
			$this->Session->setFlash(__('El mensaje ha sido eliminado exitosamente'),'default',array('class'=>'success'));
		} else {
			$this->Session->setFlash(__('El mensaje no pudo ser eliminado. Intenta de nuevo'),'default',array('class'=>'error'));
		}
		return $this->redirect(array('action' => 'view','controller'=>'desarrollos',$desarrollo));
	}
        
        public function delete_propiedades($id = null,$propiedad = null) {
		$this->Mensaje->id = $id;
		if (!$this->Mensaje->exists()) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Mensaje->delete()) {
			$this->Session->setFlash(__('El mensaje ha sido eliminado exitosamente'),'default',array('class'=>'success'));
		} else {
			$this->Session->setFlash(__('El mensaje no pudo ser eliminado. Intenta de nuevo'),'default',array('class'=>'error'));
		}
		return $this->redirect(array('action' => 'view','controller'=>'inmuebles',$propiedad));
	}
        
                }
?>
