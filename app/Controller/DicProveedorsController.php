<?php
App::uses('AppController', 'Controller');
/**
 * Aportacions Controller
 *
 * @property Aportacion $Aportacion
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DicProveedorsController extends AppController {

	public $cuenta_id;
    public function beforeFilter() {
        parent::beforeFilter();
		$this->cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }

	public $components = array('Paginator', 'Session');
    public $uses = array(
    	'DicProveedor',
    );

	public function add(){
		if ($this->request->is('post')) {
			$this->DicProveedor->create();
			if ($this->DicProveedor->save($this->request->data)) {
				$this->Session->setFlash(__('The opcionador has been saved.'));
			} else {
				$this->Session->setFlash(__('The opcionador could not be saved. Please, try again.'));
			}
			return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',6));
		}
	}

	public function delete($id = null){
		$this->DicProveedor->id = $id;
		if (!$this->DicProveedor->exists()) {
			throw new NotFoundException(__('Invalid proveedor'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicProveedor->delete()) {
			$this->Session->setFlash(__('The proveedor has been deleted.'));
		} else {
			$this->Session->setFlash(__('The proveedor could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}

}
