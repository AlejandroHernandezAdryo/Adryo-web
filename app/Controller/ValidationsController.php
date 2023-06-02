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
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');
        echo json_encode( $response , true );          
		exit();
		$this->autoRender = false;
    }
    /*** *
     * 
     * 
     * 
    */
    function view(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('User');
        $this->loadModel('Validation');
        $this->User->Behaviors->load('Containable');
        $this->Validation->Behaviors->load('Containable');
        $i=0;
        $count=0;
        $cuenta_id=179;
        $search=$this->Validation->find('all',array(
            'conditions'=>array(
                'Validation.cuenta_id' =>  $cuenta_id,
            ),
            'contain' => false
        ));
        foreach ($search as $value) {
        
            $user=$this->User->find('first',array(
                'conditions'=>array(
                    'User.id' =>  $value['Validation']['user_id'],
                ),
                'fields' => array(
                    'User.nombre_completo',
                ),
                'contain' => false
            ));
            $reponse_[$i]['id']=$value['Validation']['id'];
            $response[$i]['edit']            =//array(
                // 'agregar' => "<a onclick= 'uploadFac(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-edit'> </i> </a>",
                "<a onclick= 'uploadFac(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-add'></i> </a>";
           // ); 
            $response[$i]['user']            = $user['User']['nombre_completo'];
            $response[$i]['validacion_name'] = $value['Validation']['validacion_name'];
            if ( $value['Validation']['status']==0) {
                $response[$i]['status']          ='Inactivo';
            }else {
                $response[$i]['status']          ='Activo';
                
            }
            $response[$i]['etapa_id']        = $value['Validation']['etapa_id'];
            // }
            $json[$count]=array(
                $response[$i]['edit'],
                $response[$i]['validacion_name'],           
                $response[$i]['user']  , 
                $response[$i]['etapa_id']  ,            
                $response[$i]['status'],
            );
            $i++;
            $count++;
        }
        echo json_encode( $json , true );          
		exit();
		$this->autoRender = false;
    }

}