<?php
App::uses('AppController', 'Controller');

class DicRazonInactivacionsController extends AppController {

    public $uses = array('DicRazonInactivacion', 'LogCliente');
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function add_dic_config(){

        $this->DicRazonInactivacion->create();
        
        if ($this->DicRazonInactivacion->save($this->request->data)) {
            $mensaje = 'Se han guardado los cambios correctamente.';
        } else {
            $mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
        }

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->redirect(array('controller' => 'users', 'action' => 'diccionarios_config'));
    }

    public function edit() {
        $this->request->onlyAllow('post', 'delete');
        $diccionario_id = $this->request->data['DicRazonInactivacion']['id'];

        if ($this->DicRazonInactivacion->save($this->request->data)) {
            $mensaje = 'Se han guardado los cambios correctamente.';
        } else {
            $mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
        }
        
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->redirect(array('controller' => 'users', 'action' => 'diccionarios_config'));

    }

    public function delete ( $id = null ) {
        $this->DicRazonInactivacion->id = $id;
		if (!$this->DicRazonInactivacion->exists()) {
			throw new NotFoundException(__('Invalid proveedor'));
		}
		$this->request->onlyAllow('post', 'delete');
        $data_validate = $this->LogCliente->find('count', array( 'conditions' => array( 'LogCliente.dic_razon_inactivacion_id' => $id ) ) );

        
        if( $data_validate == 0 ){

            if ($this->DicRazonInactivacion->delete()) {
                $mensaje = 'Se ha eliminado correctamente el registro del diccionario.';
            } else {
                $mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
            }

        }else {

            $mensaje = "No se puede eliminar esta razon de diccionario, hay clientes relacionados a el.";

        }

		$this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->redirect(array('controller' => 'users', 'action' => 'diccionarios_config'));
    }

    public function validate_diccionari() {
        $data_validate = $this->LogCliente->find('count', array( 'conditions' => array( 'LogCliente.dic_razon_inactivacion_id' => $diccionario_id ) ) );

        if( $data_validate > 0 ){
            $mensaje = "La razón de inactivación actual tiene clientes relacionados, podria tener repercusiones en las graficas relacionadas. ";
        }
    }


}
