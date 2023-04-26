<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class DocsClientesExternosController extends AppController {
    
    public $cuenta_id;
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }
    public $uses = array(
        'DocsClientesExterno',
        'ClientesExterno',
        'DocsProveedor',
    );

    /***************************************************
    *
    *   Agregar documentos al proveedor.
    *
    ***************************************************/
    public function add($cliente_id = null){
        //mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/clientes_externos/".$proveedor_id,0777);
        
        if ($this->request->data['DocsClientesExternos']['docs'][0]['name']!="") {
            foreach ($this->request->data['DocsClientesExternos']['docs'] as $documento) {
                $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/clientes_externos/".$cliente_id."/".$documento['name'];
                move_uploaded_file($documento['tmp_name'],$filename);
                $nombre = $documento['name'];
                $ruta = "/files/cuentas/".$this->cuenta_id."/clientes_externos/".$cliente_id."/".$documento['name'];
                $this->DocsClientesExterno->query("INSERT INTO docs_clientes_externos VALUES (0,'".$ruta."','1', ".$cliente_id.",'".$nombre."')");
            }

            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se han subido correctamente los archivos.', 'default', array(), 'm_success'); // Mensaje

            switch ($this->request->data['DocsClientesExternos']['redirect']) {
                case 0:
                    $redirect = array('controller'=>'clientes_externos','action'=>'edit', $cliente_id);
                    break;
            }
            $this->redirect($redirect);
        }

    }

    public function delete(){
        // print_r($this->request->data['DocDelete']['id']);
        $documento_id = $this->request->data['DocDelete']['id'];
        if ($this->DocsClientesExterno->delete($documento_id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha eliminado exitosamente el documento.', 'default', array(), 'm_success'); // 
            switch ($this->request->data['DocDelete']['redirect']) {
                case 0:
                    $redirect = array('controller'=>'ClientesExternos','action'=>'edit', $this->request->data['DocDelete']['clientes_externo_id']);
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