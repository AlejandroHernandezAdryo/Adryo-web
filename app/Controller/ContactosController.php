<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class ContactosController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function add(){
        if ($this->request->is(array('post', 'put'))) {
            $this->Contacto->create();
            if (!empty($this->request->data['Contacto']['cumpleanos'])) {
                $this->request->data['Contacto']['cumpleanos'] = date('Y-m-d', strtotime($this->request->data['Contacto']['cumpleanos']));
            }else{
                $this->request->data['Contacto']['cumpleanos'] = '';
            }
            
            $this->Contacto->save($this->request->data);
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Se ha guardado correctamente al proveedor.', 'default', array(), 'm_success');
            switch ($this->request->data['Contacto']['url']) {
                case 3:
                    $redirect = array('controller'=>'proveedors','action' => 'edit', $this->request->data['Contacto']['proveedor_id']);
                    break;
                default:
                    $redirect = array('controller'=>'proveedors','action' => 'index');
                    break;
            }
            $this->redirect($redirect);
        }
    }

    /*******************************
    *
    *   Eliminar contacto
    *   SaaK
    *******************************/
    public function delete(){
        $id = $this->request->data['ContactoDelete']['id'];
        if (!$id) {
            $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
            $this->Session->setFlash('Contacto invalido.', 'default', array(), 'm_error'); // 
            $this->redirect(array('controller' => 'proveedors', 'action' => 'edit', $this->request->data['ContactoDelete']['proveedor_id']));
        }
        if ($this->Contacto->delete($id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha eliminado exitosamente el contacto.', 'default', array(), 'm_success'); // 
            $this->redirect(array('controller' => 'proveedors', 'action' => 'edit', $this->request->data['ContactoDelete']['proveedor_id']));
        }
        $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
        $this->Session->setFlash('No se ha podido eliminar el proveedor, intentelo nuevamente.', 'default', array(), 'm_error'); // 
        $this->redirect(array('controller' => 'proveedors', 'action' => 'edit', $this->request->data['ContactoDelete']['proveedor_id']));
    }
}

?>