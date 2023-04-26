<?php
App::uses('AppController', 'Controller');
/**
 * DicLineaContactos Controller
 *
 * @property DicLineaContacto $DicLineaContacto
 * @property PaginatorComponent $Paginator
 */
class DicLineaContactosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('get_liena_contactos_all', 'get_lineas_contacto'));

	}
        
        
/**
 * index method
 *
 * @return void
 */
	
	public function index() {
		$this->layout = 'bos';
                if ($this->request->is('post')) {
                    $this->DicLineaContacto->create();
                    if ($this->DicLineaContacto->save($this->request->data)){
                        $this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('El tipo de cliente ha sido guardado exitosamente.', 'default', array(), 'm_success');
                        return $this->redirect(array('action' => 'index'));
                    }else{
						$this->Session->setFlash('', 'default', array(), 'success');
						$this->Session->setFlash('No se pudo guardar el registro. Inténtalo de nuevo.', 'default', array(), 'm_success');
                    }
                }else{
                    $this->set('linea_contactos',$this->DicLineaContacto->find('all',array(
                        'conditions'=>array(
                            'DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
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
		if (!$this->DicLineaContacto->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$options = array('conditions' => array('DicLineaContacto.' . $this->DicLineaContacto->primaryKey => $id));
		$this->set('opcionador', $this->DicLineaContacto->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicLineaContacto->create();
			if ($this->DicLineaContacto->save($this->request->data)) {
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
			$this->DicLineaContacto->create();
			if ($this->DicLineaContacto->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se ha guardado correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users',3));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se ha podido guardar correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
			}
		}
	}
        
        public function add_config_c() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->DicLineaContacto->create();
			if ($this->DicLineaContacto->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se ha guardado correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',3));
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
	public function edit($id = null) {
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DicLineaContacto->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se ha guardado correctamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se ha podido guardar correctamente, favor de intentarlo nuevamente.', 'default', array(), 'm_success');
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
		$this->DicLineaContacto->id = $id;
		if (!$this->DicLineaContacto->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicLineaContacto->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->DicLineaContacto->id = $id;
		if (!$this->DicLineaContacto->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicLineaContacto->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}

	public function get_liena_contactos_all( $cuenta_id ){
		$this->layout = null;

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS");
	  
		$lineas_contacto = $this->DicLineaContacto->find('all',array('recursive' => -1,'fields'=>array(),'order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$cuenta_id)));

		for($s = 0; $s < count($lineas_contacto); $s++ ){
			$new_array_lineas_contacto[$s] = array(
			  "id"              => $lineas_contacto[$s]['DicLineaContacto']['id'],
			  "linea_contacto"  => $lineas_contacto[$s]['DicLineaContacto']['linea_contacto'],
			);
		}

		echo json_encode($new_array_lineas_contacto, true);
		// print_r($new_array_lineas_contacto);
		$this->autoRender = false;

		  
	}
		/**
	 * esta es una api la cual consulta por medio de la cuenta los id's y los medio tanbien sirve para mappen 
	 * 
	 * 
	 */
	function get_lineas_contacto(){
        header('Content-type: application/json; charset=utf-8');
        $this->DicLineaContacto->Behaviors->load('Containable');
		$cuenta_id=0;
		$lineas_contacto= array();
		$response=array();
		$i=0;
		if($this->request->is('post')){
			$cuenta_id=$this->request->data['cuenta_id'];
			$lineas_contacto = $this->DicLineaContacto->find('all',
				array(
					'conditions'=>array('DicLineaContacto.cuenta_id'=>$cuenta_id),
					'fields' => array(
						'DicLineaContacto.id',
						'DicLineaContacto.linea_contacto',
					  ),
					  'contain' => false 
				)
			);
			foreach ($lineas_contacto as $value) {
				$response[$i]['id']=$value['DicLineaContacto']['id'];
				$response[$i]['linea']=$value['DicLineaContacto']['linea_contacto'];
				$i++;
			}
			
		}
		echo json_encode($response, true);
		$this->autoRender = false;

		  
	}


}
