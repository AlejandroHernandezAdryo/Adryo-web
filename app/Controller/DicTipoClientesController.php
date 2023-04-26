<?php
App::uses('AppController', 'Controller');
/**
 * DicTipoClientes Controller
 *
 * @property DicTipoCliente $DicTipoCliente
 * @property PaginatorComponent $Paginator 
 */
class DicTipoClientesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('get_tipo_cliente_all'));
	}        
        
/**
 * index method
 *
 * @return void
 */
	
	public function index() {
		$this->layout = 'bos';
                if ($this->request->is('post')) {
                    $this->DicTipoCliente->create();
                    if ($this->DicTipoCliente->save($this->request->data)){
                        $this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('El tipo de cliente ha sido guardado exitosamente.', 'default', array(), 'm_success');
                        return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('No se ha podido guardar el registro correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
                    }
                }else{
                    $this->set('tipo_clientes',$this->DicTipoCliente->find('all',array(
                        'conditions'=>array(
                            'DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
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
		$options = array('conditions' => array('DicTipoCliente.' . $this->DicTipoCliente->primaryKey => $id));
		$this->set('opcionador', $this->DicTipoCliente->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->request->data['DicTipoCliente']['password']= $this->Auth->password($this->request->data['DicTipoCliente']['password']);
			$this->DicTipoCliente->create();
			if ($this->DicTipoCliente->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se ha guardado correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se ha podido guardar correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
			}
		}
	}
        
        public function add_config() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoCliente->create();
			if ($this->DicTipoCliente->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado correctamente los cambios, gracias.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users',1));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se ha podido guardar correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
			}
		}
	}
        
        public function add_config_c() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicTipoCliente->create();
			if ($this->DicTipoCliente->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado correctamente los cambios, gracias.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',1));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se ha podido guardar correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
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
	public function edit() {
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DicTipoCliente->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado correctamente los cambios, gracias.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se ha podido guardar correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			}
		} else {
			$options = array('conditions' => array('DicTipoCliente.' . $this->DicTipoCliente->primaryKey => $id));
			$this->request->data = $this->DicTipoCliente->find('first', $options);
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
		$this->DicTipoCliente->id = $id;
		if (!$this->DicTipoCliente->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicTipoCliente->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->DicTipoCliente->id = $id;
		if (!$this->DicTipoCliente->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicTipoCliente->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}


	public function get_tipo_cliente_all( $cuenta_id ){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS");
		$this->layout = null;
		
		$tipos_cliente = $this->DicTipoCliente->find('all',array('fields'=>array('id', 'tipo_cliente'),'order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$cuenta_id)));
		
		for($s = 0; $s < count($tipos_cliente); $s++ ){
			$new_array_dic_tipo_cliente[$s] = array(
			  "id"           => $tipos_cliente[$s]['DicTipoCliente']['id'],
			  "tipo_cliente" => $tipos_cliente[$s]['DicTipoCliente']['tipo_cliente'],
			);
		}

		echo(json_encode($new_array_dic_tipo_cliente));
		$this->autoRender = false;

	}
}
