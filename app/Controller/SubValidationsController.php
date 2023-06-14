<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property SubValidations $SubValidations
 * @property PaginatorComponent $Paginator
 */
class SubValidationsController extends AppController {


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
    /**
     * 
     * 
    */
    function add(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('User');
        $this->loadModel('SubValidation');
        $this->User->Behaviors->load('Containable');
        $this->SubValidation->Behaviors->load('Containable');
        if ($this->request->is('post')) {

            $this->SubValidation->create();
            $this->request->data['SubValidation']['id']              = null;
            $this->request->data['SubValidation']['user_create']         = $this->request->data['SubValidation']['user_id'];
            $this->request->data['SubValidation']['cuenta_id']       = $this->request->data['SubValidation']['cuenta_id'];
            $this->request->data['SubValidation']['validacion_id']        = $this->request->data['SubValidation']['validation_id'];
            $this->request->data['SubValidation']['fecha_create']    = date('Y-m-d');
            $this->request->data['SubValidation']['status']          =  $this->request->data['SubValidation']['status'];
            $this->request->data['SubValidation']['orden']          =  $this->request->data['SubValidation']['orden'];
            $this->request->data['SubValidation']['rol_asignado'] = $this->request->data['SubValidation']['rol'];
            $this->request->data['SubValidation']['subvalidation_name'] = $this->request->data['SubValidation']['subnombre'];
            if ( $this->SubValidation->save($this->request->data['SubValidation']) ) {

                $response = array(
                    'Ok' => true,
                    'mensaje' => 'Se creo la tarea'
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
        echo json_encode($response, true );          
		exit();
		$this->autoRender = false;
    }
    /**
     * 
     * 
    */
    function view(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('User');
        $this->loadModel('SubValidation');
        $this->loadModel('Validation');
        $this->Validation->Behaviors->load('Containable');
        $this->SubValidation->Behaviors->load('Containable');
        $this->User->Behaviors->load('Containable');
        $i=0;
        $count=0;
        if ($this->request->is('post')) {

            $id=$this->request->data['id'];
            $search=$this->SubValidation->find('all',array(
                'conditions'=>array(
                    'SubValidation.validacion_id' =>  $id,
                ),
                'contain' => false
            ));
            foreach ($search as $value) {

                $validation=$this->Validation->find('first',array(
                    'conditions' => array(
                        'Validation.id' => $value['SubValidation']['validacion_id'],
                    ),
                    'contain' => false
                ));
                $reponse_[$i]['id']=$value['SubValidation']['id'];
                $response[$i]['edit']= "<a onclick= 'edit(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-edit'> </i> </a>";
                $response[$i]['eliminar']= "<a onclick= 'eliminar(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-trash'> </i> </a>";
                $response[$i]['etapa_id']        = $validation['Validation']['etapa_id'];
                $response[$i]['validacion']        = $validation['Validation']['validacion_name'];
                $response[$i]['validacion_tarea'] = $value['SubValidation']['subvalidation_name'];
                $response[$i]['orden'] = $value['SubValidation']['orden'];
                $json[$count]=array(
                    $response[$i]['edit'],
                    $response[$i]['eliminar']  ,            
                    $response[$i]['validacion'],           
                    $response[$i]['etapa_id']  , 
                    $response[$i]['validacion_tarea'],                    
                    $response[$i]['orden'],
                );
                $i++;
                $count++;
            }
        }else {
            $response = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }
        echo json_encode($json, true );          
		exit();
		$this->autoRender = false;
    }



}