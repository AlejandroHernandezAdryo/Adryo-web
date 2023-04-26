<?php
App::uses('AppController', 'Controller');
/**
 * Aportacions Controller
 *
 * @property Aportacion $Aportacion
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DicFacturasController extends AppController {

	public $cuenta_id;
    public function beforeFilter() {
        parent::beforeFilter();
		$this->cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }

	public $components = array('Paginator', 'Session');
    public $uses = array(
    	'DicFactura',
    );

	public function add(){
		if ($this->request->is('post')) {
			$this->DicFactura->create();
			if ($this->DicFactura->save($this->request->data)) {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('Se han guardado los cambios correctamente.', 'default', array(), 'm_success');
			} else {
				$this->Session->setFlash('', 'default', array(), 'success');
				$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
			}
			return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users',6));
		}
	}

	public function delete($id = null){
		$this->DicFactura->id = $id;
		if (!$this->DicFactura->exists()) {
			throw new NotFoundException(__('Invalid proveedor'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicFactura->delete()) {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('Se ha eliminado correctamente el registro del diccionario.', 'default', array(), 'm_success');
		} else {
			$this->Session->setFlash('', 'default', array(), 'success');
			$this->Session->setFlash('No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
		}
		return $this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));
	}

	public function edit($id = null){
		
		$this->request->onlyAllow('post', 'delete');
		if ($this->DicFactura->save($this->request->data)) {
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
