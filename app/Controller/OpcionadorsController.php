<?php
App::uses('AppController', 'Controller');
/**
 * Opcionadors Controller
 *
 * @property Opcionador $Opcionador
 * @property PaginatorComponent $Paginator
 */
class OpcionadorsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('Opcionador','Cliente');
	
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
	
	public function index() {
		$this->layout = 'bos';
		$this->Opcionador->recursive = 0;
		$this->set('opcionadors', $this->Paginator->paginate());
	}
	
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
                $this->layout = 'bos';
		if (!$this->Opcionador->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$options = array('conditions' => array('Opcionador.' . $this->Opcionador->primaryKey => $id));
		$this->set('opcionador', $this->Opcionador->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->request->data['Opcionador']['password']= $this->Auth->password($this->request->data['Opcionador']['password']);
			$this->Opcionador->create();
			if ($this->Opcionador->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
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
                $this->layout = 'bos';
		if (!$this->Opcionador->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Opcionador->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Opcionador.' . $this->Opcionador->primaryKey => $id));
			$this->request->data = $this->Opcionador->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Opcionador->id = $id;
		if (!$this->Opcionador->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Opcionador->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
