<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class CategoriasController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    public $uses = array(
        'Categoria',
        'Banco',
        'Desarrollo',
        'CuentaBancariaDesarrollo',
    );


    /***************************************************
    *
    *   Agregar nuevas cuentas
    *
    *   Agregamos desde diccionario de facturas y desde
    *   configuración del desarrollo.
    *   
    ***************************************************/
    public function add(){

        if ($this->request->is(array('post', 'put'))) {
            $this->loadModel('DicFactura');
                                 $dic_factura              = $this->DicFactura->read(null,$this->request->data['Categoria']['dic_factura_id']);
            $this->request->data['Categoria']['cuenta_id'] = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
            $this->request->data['Categoria']['nombre']    = $dic_factura['DicFactura']['nombre']."->".$this->request->data['Categoria']['nombre'];
            $this->Categoria->create();
            $this->Categoria->save($this->request->data);
            
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Se ha creado correctamente la categoria.', 'default', array(), 'm_success');

            // Redirect To a las paginas de la cual se agregan

            switch ($this->request->data['Categoria']['redirectTo']) {
                case 1:
                        $redirectTo = array('controller'=>'desarrollos','action'=>'configuracion',$this->request->data['Categoria']['desarrollo_id']);
                    break;

                case 2:
                        $redirectTo = array('controller'=>'users','action'=>'diccionarios_config');
                    break;
                
                case 3:
                        $redirectTo = array('controller'=>'facturas','action'=>'config_autorizacion');
                    break;
                
                default:
                    $redirectTo = array('controller'=>'desarrollos','action'=>'configuracion',$this->request->data['Categoria']['desarrollo_id']);
                    break;
            }

            $this->redirect( $redirectTo );
        }
    }

    /***************************************************
    *
    *   Eliminar cuentas.
    *
    ***************************************************/
    function delete($id = null) {
        if ($this->Categoria->delete($id)) {
            $this->Session->setFlash(__('La categoría se ha eliminado exitosamente', true), 'default' ,array('class'=>'mensaje_exito'));
            $this->redirect(array('action'=>'config_autorizacion','controller'=>'facturas'));
        }
        }
        

}

?>