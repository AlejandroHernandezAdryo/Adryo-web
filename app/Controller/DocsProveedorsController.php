<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class DocsProveedorsController extends AppController {
    
    public $cuenta_id;
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }
    public $uses = array(
        'Proveedor',
        'DocsProveedor',
    );

    /***************************************************
    *
    *   Agregar documentos al proveedor.
    *
    ***************************************************/
    public function add($proveedor_id = null){
        mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/proveedores/".$proveedor_id,0777);
        
        if ($this->request->data['DocsProveedor']['docs'][0]['name']!="") {
            foreach ($this->request->data['DocsProveedor']['docs'] as $documento) {
                $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/proveedores/".$proveedor_id."/".$documento['name'];
                move_uploaded_file($documento['tmp_name'],$filename);
                $nombre = $documento['name'];
                $ruta = "/files/cuentas/".$this->cuenta_id."/proveedores/".$proveedor_id."/".$documento['name'];
                $this->DocsProveedor->query("INSERT INTO docs_proveedors VALUES (0,'".$ruta."','1', ".$proveedor_id.",'".$nombre."')");
            }

            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se han subido correctamente los archivos.', 'default', array(), 'm_success'); // Mensaje

            switch ($this->request->data['DocsProveedor']['redirect']) {
                case 0:
                    $redirect = array('controller'=>'proveedors','action'=>'edit', $proveedor_id);
                    break;
                case 1:
                    $redirect = array('controller'=>'proveedors','action'=>'view', $proveedor_id);
                    break;
                default:
                    $redirect = array('controller'=>'proveedors','action'=>'edit', $proveedor_id);
                    break;
            }
            $this->redirect($redirect);
        }

    }

    public function delete(){
        // print_r($this->request->data['DocDelete']['id']);
        $documento_id = $this->request->data['DocDelete']['id'];
        if ($this->DocsProveedor->delete($documento_id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha eliminado exitosamente el documento.', 'default', array(), 'm_success'); // 
            switch ($this->request->data['DocDelete']['redirect']) {
                case 0:
                    $redirect = array('controller'=>'proveedors','action'=>'edit', $this->request->data['DocDelete']['proveedor_id']);
                    break;
                case 1:
                    $redirect = array('controller'=>'proveedors','action'=>'view', $this->request->data['DocDelete']['proveedor_id']);
                    break;
                default:
                    $redirect = array('controller'=>'proveedors','action'=>'edit', $this->request->data['DocDelete']['proveedor_id']);
                    break;
            }
            $this->redirect($redirect);
        }else{
            $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
            $this->Session->setFlash('No se ha podido eliminar el documento, intentelo nuevamente.', 'default', array(), 'm_error'); // 
            switch ($this->request->data['DocDelete']['redirect']) {
                case 0:
                    $redirect = array('controller'=>'proveedors','action'=>'edit', $this->request->data['DocDelete']['proveedor_id']);
                    break;
                case 1:
                    $redirect = array('controller'=>'proveedors','action'=>'view', $this->request->data['DocDelete']['proveedor_id']);
                    break;
                default:
                    $redirect = array('controller'=>'proveedors','action'=>'edit', $this->request->data['DocDelete']['proveedor_id']);
                    break;
            }
            $this->redirect($redirect);
        }
    }
}

?>