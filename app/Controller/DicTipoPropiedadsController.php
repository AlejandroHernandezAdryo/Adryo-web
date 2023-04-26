<?php
App::uses('AppController', 'Controller');
/**
 * DicTipoPropiedads Controller
 *
 * @property DicTipoPropiedad $DicTipoPropiedad
 * @property PaginatorComponent $Paginator
 */
class DicTipoPropiedadsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('get_list_propiedades');
	}

        
/**
 * index method
 *
 * @return void
 */
	
	public function index() {
		//$this->layout = 'bos';
                if ($this->request->is('post')) {
                    $this->DicTipoPropiedad->create();
                    if ($this->DicTipoPropiedad->save($this->request->data)){
						$this->Session->setFlash(__('El tipo de propiedad ha sido guardado exitosamente'));
						$this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('El tipo de propiedad ha sido guardado exitosamente.', 'default', array(), 'm_success');
                        return $this->redirect(array('action' => 'index'));
                    }else{
						$this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('No se pudo guardar el registro. Inténtalo de nuevo.', 'default', array(), 'm_success');
                    }
                }else{
                    $this->set('tipo_propiedads',$this->DicTipoPropiedad->find('all',array(
                        'conditions'=>array(
                            'DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
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
		if (!$this->DicTipoPropiedad->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$options = array('conditions' => array('DicTipoPropiedad.' . $this->DicTipoPropiedad->primaryKey => $id));
		$this->set('opcionador', $this->DicTipoPropiedad->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoPropiedad->create();
			if ($this->DicTipoPropiedad->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
			}
		}
	}
        
        public function add_config() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoPropiedad->create();
			if ($this->DicTipoPropiedad->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users',6));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
			}
		}
	}
        
        public function add_config_c() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoPropiedad->create();
			if ($this->DicTipoPropiedad->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',6));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
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
			if ($this->DicTipoPropiedad->save($this->request->data)) {
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
		$this->DicTipoPropiedad->id = $id;
		if (!$this->DicTipoPropiedad->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicTipoPropiedad->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->DicTipoPropiedad->id = $id;
		if (!$this->DicTipoPropiedad->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicTipoPropiedad->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}

	public function get_list_propiedades( $cuenta_id = null ) {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Credentials: true');
		header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
		header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
	  
		$this->layout = false;

		$dic_tipo_propiedades = $this->DicTipoPropiedad->find('all',
			array(
				'conditions' => array(
					'DicTipoPropiedad.cuenta_id' => $cuenta_id
				)
			)
		);
		
		echo json_encode( $dic_tipo_propiedades, true );
		$this->autoRender = false;
	}
}
