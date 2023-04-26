<?php
App::uses('AppController', 'Controller');
/**
 * DesarrolloInmuebles Controller
 *
 * @property DesarrolloInmueble $DesarrolloInmueble
 * @property PaginatorComponent $Paginator
 */
class DesarrolloInmueblesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('DesarrolloInmueble', 'Cliente');
        
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
		$this->DesarrolloInmueble->recursive = 0;
		$this->set('desarrolloInmuebles', $this->Paginator->paginate());
	}
        
        

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DesarrolloInmueble->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo inmueble'));
		}
		$options = array('conditions' => array('DesarrolloInmueble.' . $this->DesarrolloInmueble->primaryKey => $id));
		$this->set('desarrolloInmueble', $this->DesarrolloInmueble->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DesarrolloInmueble->create();
			if ($this->DesarrolloInmueble->save($this->request->data)) {
				$this->Session->setFlash(__('The desarrollo inmueble has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The desarrollo inmueble could not be saved. Please, try again.'));
			}
		}
		$desarrollos = $this->DesarrolloInmueble->Desarrollo->find('list');
		$inmuebles = $this->DesarrolloInmueble->Inmueble->find('list');
		$this->set(compact('desarrollos', 'inmuebles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DesarrolloInmueble->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo inmueble'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DesarrolloInmueble->save($this->request->data)) {
				$this->Session->setFlash(__('The desarrollo inmueble has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The desarrollo inmueble could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DesarrolloInmueble.' . $this->DesarrolloInmueble->primaryKey => $id));
			$this->request->data = $this->DesarrolloInmueble->find('first', $options);
		}
		$desarrollos = $this->DesarrolloInmueble->Desarrollo->find('list');
		$inmuebles = $this->DesarrolloInmueble->Inmueble->find('list');
		$this->set(compact('desarrollos', 'inmuebles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DesarrolloInmueble->id = $id;
		if (!$this->DesarrolloInmueble->exists()) {
			throw new NotFoundException(__('Invalid desarrollo inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DesarrolloInmueble->delete()) {
			$this->Session->setFlash(__('The desarrollo inmueble has been deleted.'));
		} else {
			$this->Session->setFlash(__('The desarrollo inmueble could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
