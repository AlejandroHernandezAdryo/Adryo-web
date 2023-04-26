<?php
App::uses('AppController', 'Controller');
/**
 * DicUbicacionAnuncios Controller
 *
 * @property DicUbicacionAnuncio $DicUbicacionAnuncio
 * @property PaginatorComponent $Paginator
 */
class DicUbicacionAnunciosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
        
/**
 * index method
 *
 * @return void
 */
	
	public function index() {
		//$this->layout = 'bos';
                if ($this->request->is('post')) {
                    $this->DicUbicacionAnuncio->create();
                    if ($this->DicUbicacionAnuncio->save($this->request->data)){
                        $this->Session->setFlash(__('La ubiación del anuncio ha sido guardado exitosamente'));
                        return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash(__('No se pudo guardar el registro. Inténtalo de nuevo'));
                    }
                }else{
                    $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('all',array(
                        'conditions'=>array(
                            'DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
                }
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
		if (!$this->DicUbicacionAnuncio->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$options = array('conditions' => array('DicUbicacionAnuncio.' . $this->DicUbicacionAnuncio->primaryKey => $id));
		$this->set('opcionador', $this->DicUbicacionAnuncio->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->request->data['DicUbicacionAnuncio']['password']= $this->Auth->password($this->request->data['DicUbicacionAnuncio']['password']);
			$this->DicUbicacionAnuncio->create();
			if ($this->DicUbicacionAnuncio->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
		}
	}
        
        public function add_config() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicUbicacionAnuncio->create();
			if ($this->DicUbicacionAnuncio->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users',5));
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
		if (!$this->DicUbicacionAnuncio->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DicUbicacionAnuncio->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DicUbicacionAnuncio.' . $this->DicUbicacionAnuncio->primaryKey => $id));
			$this->request->data = $this->DicUbicacionAnuncio->find('first', $options);
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
		$this->DicUbicacionAnuncio->id = $id;
		if (!$this->DicUbicacionAnuncio->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicUbicacionAnuncio->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->DicUbicacionAnuncio->id = $id;
		if (!$this->DicUbicacionAnuncio->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicUbicacionAnuncio->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'diccionarios','controller'=>'users'));
	}
                }
