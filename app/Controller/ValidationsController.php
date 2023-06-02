<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property Validation $Validation
 * @property PaginatorComponent $Paginator
 */
class ValidationsController extends AppController {


    public $components = array('Paginator' );


    public $uses = array(
            'Cliente','Inmueble','Desarrollo',
            'User',
            'Venta','Transaccion', 'Factura','MailConfig', 'Paramconfig', 'Cuenta', 'Cotizacion'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }
    /***
     * 
     * 
     */
    function add(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Validation');
        $this->Validation->Behaviors->load('Containable');
        if ($this->request->is('post')) {

            $this->Validation->create();
            $this->request->data['Validation']['id']              = null;
            $this->request->data['Validation']['user_id']         = $this->request->data['Validations']['user_id'];
            $this->request->data['Validation']['cuenta_id']       = $this->request->data['Validations']['cuenta_id'];
            $this->request->data['Validation']['etapa_id']        = $this->request->data['Validations']['proceso'];
            $this->request->data['Validation']['fecha_create']    = date('Y-m-d');
            $this->request->data['Validation']['status']          = 0;
            $this->request->data['Validation']['validacion_name'] = $this->request->data['Validations']['nombre'];
            if ( $this->Validation->save($this->request->data['Validation']) ) {

                $response = array(
                    'Ok' => true,
                    'mensaje' => 'Se creo la tarea '
                );

            }else {
                $response = array(
                    'Ok' => false,
                    'mensaje' => 'No se pudo actualizar el pago'
                );
            }
            // $response=$this->request->data['Validations']['user_id'];
            // $response=$this->request->data['Validations']['cuenta_id'];
        }else {
            $response = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');
        echo json_encode( $response , true );          
		exit();
		$this->autoRender = false;
    }


}