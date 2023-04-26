<?php
App::uses('AppController', 'Controller');
/**
 * ParamConfigs Controller
 *
 * @property ParamConfig $ParamConfig
 * @property PaginatorComponent $Paginator
 */
class ParamconfigsController extends AppController {

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
		$this->layout = 'bos';
                if ($this->request->is('post')) {
                    $this->ParamConfig->create();
                    if ($this->ParamConfig->save($this->request->data)){
                        $this->Session->setFlash(__('El tipo de cliente ha sido guardado exitosamente'));
                        return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash(__('No se pudo guardar el registro. Inténtalo de nuevo'));
                    }
                }else{
                    $this->set('etapas',$this->ParamConfig->find('all',array(
                        'conditions'=>array(
                            'ParamConfig.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
                }
	}
	
	
	/**
	 * view method
	 *	via ajax
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view( $id = null ) {
		header('Content-type: application/json charset=utf-8');

		$parametros = $this->ParamConfig->find('first', array('conditions' => array('ParamConfig.' . $this->ParamConfig->primaryKey => $id), 'contain' => false ));
		echo json_encode( $parametros, true );
		$this->autoRender = false;
	}

	/**
	 * add method
	 *	
	 * @return void
	 */
	public function add() {
		$this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->ParamConfig->create();
			if ($this->ParamConfig->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'index'));
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
                //$this->layout = 'bos';
		if (!$this->ParamConfig->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ParamConfig->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ParamConfig.' . $this->ParamConfig->primaryKey => $id));
			$this->request->data = $this->ParamConfig->find('first', $options);
		}
	}
        
  	public function parametros() {
    	//$this->layout = 'bos';
		if ($this->request->is(array('post', 'put'))) {
        	$this->request->data['Paramconfig']['id'] = $this->Session->read('CuentaUsuario.Cuenta.paramconfig_id');
			
			if ($this->request->data['Paramconfig']['seleccion'] == 1){
								
				$this->request->data['Paramconfig']['llamadas'] = 3;
				$this->request->data['Paramconfig']['emails']   = 2;
				$this->request->data['Paramconfig']['visitas']  = 5;

			}
			if ( $this->Paramconfig->save($this->request->data) ) {
				
				$this->Session->setFlash('', 'default', array(), 'success');
        		$this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
				$this->update_session_vars();

				$this->redirect(array('controller' => 'users','action'=>'parametros_mail_config'));

			} else {

				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));

			}
			
		} else {
			$options = array('conditions' => array('ParamConfig.' . $this->ParamConfig->primaryKey => $id));
			$this->request->data = $this->ParamConfig->find('first', $options);
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
		$this->ParamConfig->id = $id;
		if (!$this->ParamConfig->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ParamConfig->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
    public function delete_config($id = null) {
		$this->ParamConfig->id = $id;
		if (!$this->ParamConfig->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ParamConfig->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'diccionarios','controller'=>'users'));
	}

	/* ---------------------- update user session variables --------------------- */
	public function update_session_vars(){
		$this->loadModel('CuentasUser');
		$this->Session->write('CuentaUsuario',$this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$this->Session->read('Auth.User.id')))));
		
		$this->loadModel('Group');
		$this->Session->write('Permisos',$this->Group->find('first',array('conditions'=>array('Group.id'=>$this->Session->read('CuentaUsuario.CuentasUser.group_id')))));
		
		$this->loadModel('Paramconfig');
		$this->Session->write('Parametros',$this->Paramconfig->find('first',array('conditions'=>array('Paramconfig.id'=>$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')))));
		
		$this->loadModel('Cliente');
		$this->Session->write('clundef',$this->Cliente->find('count',array('conditions'=>array('Cliente.user_id IS NULL', 'Cliente.cuenta_id'=> $this->Session->read('CuentaUsuario.Cuenta.id')))));
	
		$this->loadModel('Factura');
		$this->Session->write('facturas_por_autorizar',$this->Factura->find('count',array('conditions'=>array('Factura.aut_pendiente'=> $this->Session->read('Auth.User.id')))));

	}

}
