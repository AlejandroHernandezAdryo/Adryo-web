<?php
App::uses('AppController', 'Controller');
/**
 * FotoDesarrollos Controller
 *
 * @property FotoDesarrollo $FotoDesarrollo
 * @property PaginatorComponent $Paginator
 */
class FotoDesarrollosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('FotoDesarrollo','Cliente');
        
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
		$this->FotoDesarrollo->recursive = 0;
		$this->set('fotoDesarrollos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FotoDesarrollo->exists($id)) {
			throw new NotFoundException(__('Invalid foto desarrollo'));
		}
		$options = array('conditions' => array('FotoDesarrollo.' . $this->FotoDesarrollo->primaryKey => $id));
		$this->set('fotoDesarrollo', $this->FotoDesarrollo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FotoDesarrollo->create();
			if ($this->FotoDesarrollo->save($this->request->data)) {
				$this->Session->setFlash(__('The foto desarrollo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The foto desarrollo could not be saved. Please, try again.'));
			}
		}
		$desarrollos = $this->FotoDesarrollo->Desarrollo->find('list');
		$this->set(compact('desarrollos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FotoDesarrollo->exists($id)) {
			throw new NotFoundException(__('Invalid foto desarrollo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FotoDesarrollo->save($this->request->data)) {
				$this->Session->setFlash(__('The foto desarrollo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The foto desarrollo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('FotoDesarrollo.' . $this->FotoDesarrollo->primaryKey => $id));
			$this->request->data = $this->FotoDesarrollo->find('first', $options);
		}
		$desarrollos = $this->FotoDesarrollo->Desarrollo->find('list');
		$this->set(compact('desarrollos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FotoDesarrollo->id = $id;
		if (!$this->FotoDesarrollo->exists()) {
			throw new NotFoundException(__('Invalid foto desarrollo'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FotoDesarrollo->delete()) {
			$this->Session->setFlash(__('The foto desarrollo has been deleted.'));
		} else {
			$this->Session->setFlash(__('The foto desarrollo could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
