<?php
App::uses('AppController', 'Controller');
/**
 * DicEtapas Controller
 *
 * @property DicEtapa $DicEtapa
 * @property PaginatorComponent $Paginator
 */
class DicEtapasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('get_etapas_all'));
	}        
/**
 * index method
 *
 * @return void
 */
	
	public function index() {
		$this->layout = 'bos';
                if ($this->request->is('post')) {
                    $this->DicEtapa->create();
                    if ($this->DicEtapa->save($this->request->data)){
						$this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('El tipo de cliente ha sido guardado exitosamente.', 'default', array(), 'm_success');
                        return $this->redirect(array('action' => 'index'));
                    }else{
						$this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
                    }
                }else{
                    $this->set('etapas',$this->DicEtapa->find('all',array(
                        'conditions'=>array(
                            'DicEtapa.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
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
		$options = array('conditions' => array('DicEtapa.' . $this->DicEtapa->primaryKey => $id));
		$this->set('opcionador', $this->DicEtapa->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicEtapa->create();
			if ($this->DicEtapa->save($this->request->data)) {
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
			$this->DicEtapa->create();
			if ($this->DicEtapa->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users',2));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
			}
		}
	}
        
        public function add_config_C() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicEtapa->create();
			if ($this->DicEtapa->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',2));
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
			if ($this->DicEtapa->save($this->request->data)) {
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
		$this->DicEtapa->id = $id;
		if (!$this->DicEtapa->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicEtapa->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->DicEtapa->id = $id;
		if (!$this->DicEtapa->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicEtapa->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}




	public function get_etapas_all( $cuenta_id ){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS");
		$this->layout = null;
		$new_array_dic_etapas = [];

		$etapas = $this->DicEtapa->find('all',array('recursive'=>-1,'fields'=>array('id', 'etapa'),'order'=>'DicEtapa.etapa ASC','conditions'=>array('DicEtapa.cuenta_id'=>$cuenta_id)));

		for($s = 0; $s < count($etapas); $s++ ){
			$new_array_dic_etapas[$s] = array(
			  "id"              => $etapas[$s]['DicEtapa']['id'],
			  "etapa"  => $etapas[$s]['DicEtapa']['etapa'],
			);
		}

		echo(json_encode($new_array_dic_etapas));
		// print_r($new_array_dic_etapas);
		$this->autoRender = false;

	}
}

