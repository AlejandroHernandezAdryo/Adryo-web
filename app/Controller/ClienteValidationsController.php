<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * 
 *
 * @property ClienteValidations $ClienteValidations
 * @property PaginatorComponent $Paginator
 */
class ClienteValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }
    /**
     * 
     */
    function cliente_entra_validacion(){
        // date_default_timezone_set('America/Chihuahua');
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('ClienteValidation');
        $this->loadModel('Agenda');
        $this->ClienteValidation->Behaviors->load('Containable');
        
        if ( $this->request->is('post') ){
            $this->ClienteValidation->create();
            $this->request->data['ClienteValidation']['id']            = null;
            $this->request->data['ClienteValidation']['validacion_id'] = $this->request->data['ValidacionCliente']['validacion_id'];
            $this->request->data['ClienteValidation']['cliente_id']    = $this->request->data['ValidacionCliente']['cliente_id'];
            $this->request->data['ClienteValidation']['progreso']      = 0;        
            $this->request->data['ClienteValidation']['cuenta_id']     = $this->request->data['ValidacionCliente']['cuenta_id'];
            $this->request->data['ClienteValidation']['status']        = 0;
            $this->request->data['ClienteValidation']['description']   = 'creado';
            if ( $this->ClienteValidation->save($this->request->data['ClienteValidation']) ) {
                $this->request->data['Agenda']['cliente_id'] = $this->request->data['ValidacionCliente']['cliente_id'] ;
                $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id') ;
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H: i: s');
                $this->request->data['Agenda']['mensaje']    = "El cliente entro a validacion de la etapa".$this->request->data['ValidacionCliente']['etapa'] ;
                $this->Agenda->create();
                $this->Agenda->save($this->request->data);
                $response = array(
                    'Ok' => true,
                    'mensaje' => 'Se Guardo el cliente en validaciones'
                );
            }else {
                $response = array(
                    'Ok' => false,
                    'mensaje' => 'No se pudo Guardar'
                );
            }
            
        }else {
            $response = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');
        echo json_encode( $response , true );          
        // echo json_encode( $this->request->data , true );          
		exit();
		$this->autoRender = false;
    }   
    /**
     * 
     * 
    */
    function view_validacion_cliente(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('ClienteValidation');
        $this->loadModel('Validation');
        $this->loadModel('Cliente');
        $this->loadModel('User');
        $this->User->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $this->ClienteValidation->Behaviors->load('Containable');
        $this->Validation->Behaviors->load('Containable');
        $i=0;
        $count=0;
        if ($this->request->is('post')) {
            $cuenta_id=$this->request->data['cuenta_id'];
            // $cuenta_id=179;
            $search=$this->ClienteValidation->find('all',array(
                'conditions'=>array(
                    'ClienteValidation.cuenta_id' =>  $cuenta_id,
                ),
                'contain' => false
            ));
            foreach ($search as $value) {
                $search_cliente= $this->Cliente->find('first', array( 
                    'conditions'=>array(
                        'Cliente.id'=>$value['ClienteValidation']['cliente_id'],
                    ),
                    'fields' => array(
                        'Cliente.user_id',
                        'Cliente.nombre',
                        'Cliente.id',
                        'Cliente.etapa',
                    ),
                    'contain' => false
                ));
                $user=$this->User->find('first',array(
                    'conditions'=>array(
                        'User.id' =>  $search_cliente['Cliente']['user_id'],
                    ),
                    'fields' => array(
                        'User.id',
                        'User.nombre_completo',
                    ),
                    'contain' => false
                ));
                $reponse_[$i]['cliente_id']=$search_cliente['Cliente']['id'];
                $reponse_[$i]['nuevo'] ="<a href='".Router::url(array('controller'=>'desarrollos', 'action'=>'inicio_proceso', $reponse_[$i]['cliente_id']))."' class='pointer'> <i class='fa fa-eye'></i> </a>"; 
                $reponse_[$i]['nombre_cliente']=$search_cliente['Cliente']['nombre'];
                $reponse_[$i]['user']            = $user['User']['nombre_completo'];
                $reponse_[$i]['etapa_id']        = $search_cliente['Cliente']['etapa'];
                // class="fa fa-eye"
                if ( $value['ClienteValidation']['status']==0) {
                    $reponse_[$i]['status']        = "<p style='color:#C22419'> Rechazado </p></a>";;
                }elseif ($value['ClienteValidation']['status']==1) {
                    $reponse_[$i]['status']        = "<p style='color:#3DAE07'>En proceso </p></a>";
                } 
                $json[$count]=array(
                    $reponse_[$i]['nuevo'],
                    $reponse_[$i]['nombre_cliente'],
                    $reponse_[$i]['user'],  
                    $reponse_[$i]['etapa_id'],
                    $reponse_[$i]['validacion_name'],             
                    $reponse_[$i]['status'],
                );
                $i++;
                $count++;
            }
        }  else {
            $json = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        } 
        
        echo json_encode( $json , true );          
        exit();
        $this->autoRender = false;
    }
}