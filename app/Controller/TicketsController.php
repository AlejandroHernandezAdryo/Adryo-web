<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class TicketsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('Ticket','Desarrollo','Inmueble','Cliente');

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
        }
/**
 * index method
 *
 * @return void
 */
	public function index_cliente() {
		$this->Ticket->recursive = 0;
                $this->Paginator->settings = array('conditions'=>array('Ticket.user_id'=>$this->Session->read('Auth.User.id')));
		$this->set('tickets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ticket->exists($id)) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		$options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $id));
		$this->set('ticket', $this->Ticket->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add_desarrollo($id_desarrollo = null) {
                $this->layout='cliente';
		if ($this->request->is('post')) {
			$this->Ticket->create();
			if ($this->Ticket->save($this->request->data)) {
                                $mensaje = $this->request->data['Ticket']['mensaje'];
                                $ticket_id = $this->Ticket->getInsertID();
                                $user_id = $this->request->data['Ticket']['user_id'];
                                $this->Ticket->query("INSERT INTO respuestas_tickets VALUES (0,$user_id,'".$mensaje."',$ticket_id)");
                                $this->Session->setFlash(__('El ticket ha sido guardado exitosamente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'index_cliente','controller'=>'tickets'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		}
		$this->set('desarrollo',$this->Desarrollo->read(null,$id_desarrollo));
	}
        
        public function add_propiedad($id_propiedad = null) {
                $this->layout='cliente';
		if ($this->request->is('post')) {
			$this->Ticket->create();
			if ($this->Ticket->save($this->request->data)) {
                                $mensaje = $this->request->data['Ticket']['mensaje'];
                                $ticket_id = $this->Ticket->getInsertID();
                                $user_id = $this->request->data['Ticket']['user_id'];
                                $this->Ticket->query("INSERT INTO respuestas_tickets VALUES (0,$user_id,'".$mensaje."',$ticket_id)");
                                $this->Session->setFlash(__('El ticket ha sido guardado exitosamente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Ticket']['cliente_id']));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		}
		$this->set('propiedad',$this->Inmueble->read(null,$id_propiedad));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ticket->exists($id)) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $id));
			$this->request->data = $this->Ticket->find('first', $options);
		}
		$users = $this->Ticket->User->find('list');
		$leads = $this->Ticket->Lead->find('list');
		$this->set(compact('users', 'leads'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ticket->delete()) {
			$this->Session->setFlash(__('The ticket has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ticket could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}

