<?php
App::uses('AppController', 'Controller');
/**
 * Mailconfigs Controller
 *
 * @property Mailconfig $Mailconfig
 * @property PaginatorComponent $Paginator
 */
class MailconfigsController extends AppController {

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
                    $this->Mailconfig->create();
                    if ($this->Mailconfig->save($this->request->data)){
                        $this->Session->setFlash(__('El tipo de cliente ha sido guardado exitosamente'));
                        return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash(__('No se pudo guardar el registro. Inténtalo de nuevo'));
                    }
                }else{
                    $this->set('etapas',$this->Mailconfig->find('all',array(
                        'conditions'=>array(
                            'Mailconfig.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
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
		$options = array('conditions' => array('Mailconfig.' . $this->Mailconfig->primaryKey => $id));
		$this->set('opcionador', $this->Mailconfig->find('first', $options));
		
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->Mailconfig->create();
			if ($this->Mailconfig->save($this->request->data)) {
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
			$this->request->data['Mailconfig']['password']= $this->Auth->password($this->request->data['Mailconfig']['password']);
			$this->Mailconfig->create();
			if ($this->Mailconfig->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users'));
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
                $this->loadModel('Paramconfig');
                //$this->layout = 'bos';
		if (!$this->Mailconfig->exists($id)) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Mailconfig->save($this->request->data)) {
                            
                                $this->request->data['Paramconfig']['id'] = $this->Session->read('CuentaUsuario.Cuenta.paramconfig_id');
                                $this->request->data['Paramconfig']['mr'] = $this->request->data['Mailconfig']['mr'];
                //                $this->request->data['Paramconfig']['to_mr'] = $this->request->data['User']['to_mr'];
                                $this->request->data['Paramconfig']['cc_mr'] = $this->request->data['Mailconfig']['cc_mr'];
                //                $this->request->data['Paramconfig']['cco_mr'] = $this->request->data['User']['cco_mr'];
                                $this->request->data['Paramconfig']['mep'] = $this->request->data['Mailconfig']['mep'];
                                $this->request->data['Paramconfig']['cc_mep'] = $this->request->data['Mailconfig']['cc_mep'];
                                $this->request->data['Paramconfig']['cco_mep'] = $this->request->data['Mailconfig']['cco_mep'];
                                $this->request->data['Paramconfig']['ma'] = $this->request->data['Mailconfig']['ma'];
                //                $this->request->data['Paramconfig']['cc_ma'] = $this->request->data['User']['cc_ma'];
                //                $this->request->data['Paramconfig']['cco_ma'] = $this->request->data['User']['cco_ma'];
                //                $this->request->data['Paramconfig']['sla_atrasados'] = $this->request->data['User']['sla_atrasados'];
                //                $this->request->data['Paramconfig']['sla_no_atendidos'] = $this->request->data['User']['sla_no_atendidos'];
                //                $this->request->data['Paramconfig']['llamadas'] = $this->request->data['User']['llamadas'];
                //                $this->request->data['Paramconfig']['emails'] = $this->request->data['User']['emails'];
                //                $this->request->data['Paramconfig']['visitas'] = $this->request->data['User']['visitas'];
                                $this->Paramconfig->create();
                                $this->Paramconfig->save($this->request->data);
				$this->Session->setFlash(__('The opcionador has been saved.'));
				return $this->redirect(array('action' => 'diccionarios','controller'=>'users'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Mailconfig.' . $this->Mailconfig->primaryKey => $id));
			$this->request->data = $this->Mailconfig->find('first', $options);
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
		$this->Mailconfig->id = $id;
		if (!$this->Mailconfig->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Mailconfig->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_config($id = null) {
		$this->Mailconfig->id = $id;
		if (!$this->Mailconfig->exists()) {
			throw new NotFoundException(__('Invalid opcionador'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Mailconfig->delete()) {
			$this->Session->setFlash(__('The opcionador has been deleted.'));
		} else {
			$this->Session->setFlash(__('The opcionador could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'diccionarios','controller'=>'users'));
	}
                }
