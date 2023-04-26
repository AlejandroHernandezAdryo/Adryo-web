<?php
App::uses('AppController', 'Controller');
/**
 * FotoInmuebles Controller
 *
 * @property FotoInmueble $FotoInmueble
 * @property PaginatorComponent $Paginator
 */
class FotoInmueblesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('FotoInmueble','Cliente');
        
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
		$this->FotoInmueble->recursive = 0;
		$this->set('fotoInmuebles', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FotoInmueble->exists($id)) {
			throw new NotFoundException(__('Invalid foto inmueble'));
		}
		$options = array('conditions' => array('FotoInmueble.' . $this->FotoInmueble->primaryKey => $id));
		$this->set('fotoInmueble', $this->FotoInmueble->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FotoInmueble->create();
			if ($this->FotoInmueble->save($this->request->data)) {
				$this->Session->setFlash(__('The foto inmueble has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The foto inmueble could not be saved. Please, try again.'));
			}
		}
		$inmuebles = $this->FotoInmueble->Inmueble->find('list');
		$this->set(compact('inmuebles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FotoInmueble->exists($id)) {
			throw new NotFoundException(__('Invalid foto inmueble'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FotoInmueble->save($this->request->data)) {
				$this->Session->setFlash(__('The foto inmueble has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The foto inmueble could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('FotoInmueble.' . $this->FotoInmueble->primaryKey => $id));
			$this->request->data = $this->FotoInmueble->find('first', $options);
		}
		$inmuebles = $this->FotoInmueble->Inmueble->find('list');
		$this->set(compact('inmuebles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FotoInmueble->id = $id;
		if (!$this->FotoInmueble->exists()) {
			throw new NotFoundException(__('Invalid foto inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FotoInmueble->delete()) {
			$this->Session->setFlash(__('The foto inmueble has been deleted.'));
		} else {
			$this->Session->setFlash(__('The foto inmueble could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
