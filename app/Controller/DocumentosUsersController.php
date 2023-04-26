<?php
App::uses('AppController', 'Controller');
/**
 * DocumentosUsers Controller
 *
 * @property DocumentosUser $DocumentosUser
 * @property PaginatorComponent $Paginator
 */
class DocumentosUsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('DocumentosUser', 'Cliente');

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
		$this->DocumentosUser->recursive = 0;
		$this->set('documentosUsers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DocumentosUser->exists($id)) {
			throw new NotFoundException(__('Invalid documentos user'));
		}
		$options = array('conditions' => array('DocumentosUser.' . $this->DocumentosUser->primaryKey => $id));
		$this->set('documentosUser', $this->DocumentosUser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DocumentosUser->create();
			if ($this->DocumentosUser->save($this->request->data)) {
				$this->Session->setFlash(__('The documentos user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The documentos user could not be saved. Please, try again.'));
			}
		}
		$users = $this->DocumentosUser->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DocumentosUser->exists($id)) {
			throw new NotFoundException(__('Invalid documentos user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DocumentosUser->save($this->request->data)) {
				$this->Session->setFlash(__('The documentos user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The documentos user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DocumentosUser.' . $this->DocumentosUser->primaryKey => $id));
			$this->request->data = $this->DocumentosUser->find('first', $options);
		}
		$users = $this->DocumentosUser->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DocumentosUser->id = $id;
		if (!$this->DocumentosUser->exists()) {
			throw new NotFoundException(__('Invalid documentos user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DocumentosUser->delete()) {
			$this->Session->setFlash(__('The documentos user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The documentos user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
