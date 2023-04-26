<?php
App::uses('AppController', 'Controller');
/**
 * DicTipoAnuncios Controller
 *
 * @property DicTipoAnuncio $DicTipoAnuncio
 * @property PaginatorComponent $Paginator
 */
class DicTipoAnunciosController extends AppController {

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
                    $this->DicTipoAnuncio->create();
                    if ($this->DicTipoAnuncio->save($this->request->data)){
                        $this->Session->setFlash(__('El tipo de anuncio ha sido guardado exitosamente'));
                        return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash(__('No se pudo guardar el registro. Inténtalo de nuevo'));
                    }
                }else{
                    $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('all',array(
                        'conditions'=>array(
                            'DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
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
		if (!$this->DicTipoCliente->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$options = array('conditions' => array('DicTipoAnuncio.' . $this->DicTipoAnuncio->primaryKey => $id));
		$this->set('opcionador', $this->DicTipoAnuncio->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoAnuncio->create();
			if ($this->DicTipoAnuncio->save($this->request->data)) {
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
			$this->DicTipoAnuncio->create();
			if ($this->DicTipoAnuncio->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			}
		}
	}
        
        public function add_config_c() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoAnuncio->create();
			if ($this->DicTipoAnuncio->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',4));
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
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DicTipoAnuncio->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			}
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
		$this->DicTipoAnuncio->id = $id;
		if (!$this->DicTipoAnuncio->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicTipoAnuncio->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->DicTipoAnuncio->id = $id;
		if (!$this->DicTipoAnuncio->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicTipoAnuncio->delete()) {
			
			$mensaje = 'Se ha eliminado correctamente el tipo de anuncio.';

		} else {
			$mensaje = 'Hubo un error al intentar eliminar el tipo de anuncio, favor de intentarlo nuevamente, gracias.';
		}

		$this->Session->setFlash('', 'default', array(), 'success');
		$this->Session->setFlash($mensaje, 'default', array(), 'm_success');

		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}
        
        
        
                }
