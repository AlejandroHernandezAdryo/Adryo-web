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

    // date_default_timezone_set('America/Chihuahua');
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
        $this->loadModel('LogValidation');
        $this->LogValidation->Behaviors->load('Containable');
        $this->Validation->Behaviors->load('Containable');
        if ($this->request->is('post')) {

            $this->Validation->create();
            $this->request->data['Validation']['id']              = null;
            $this->request->data['Validation']['user_id']         = $this->request->data['Validations']['user_id'];
            $this->request->data['Validation']['cuenta_id']       = $this->request->data['Validations']['cuenta_id'];
            // $this->request->data['Validation']['orden']           = $this->request->data['Validations']['orden'];    
            $this->request->data['Validation']['progreso']        = 0;        
            $this->request->data['Validation']['etapa_id']        = $this->request->data['Validations']['etapa_inicio'];
            $this->request->data['Validation']['fecha_create']    = date('Y-m-d');
            $this->request->data['Validation']['status']          = 0;
            $this->request->data['Validation']['description']     = 'creado';
            $this->request->data['Validation']['validacion_name'] = $this->request->data['Validations']['name_proceso'];
            if ( $this->Validation->save($this->request->data['Validation']) ) {

                $this->LogValidation->create();
                $this->request->data['LogValidation']['id']                = null;
                $this->request->data['LogValidation']['validacion_id']     =$this->Validation->getInsertID() ;
                $this->request->data['LogValidation']['status']            = 1;   
                $this->request->data['LogValidation']['user_validation']   = $this->Session->read('CuentaUsuario.User.id');
                $this->request->data['LogValidation']['description']       = 'creado';   
                $this->request->data['LogValidation']['fecha_validation']  =  date('Y-m-d');   
                $this->LogValidation->save($this->request->data['LogValidation']) ;   
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
        if ($this->request->is('post')) {

            $cuenta_id=$this->request->data['cuenta_id'];
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
                    'contain' => false
                ));
                $reponse_[$i]['id']=$value['Validation']['id'];
                $response[$i]['nuevo']            =//array(
                    // 'agregar' => "<a onclick= 'uploadFac(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-edit'> </i> </a>",
                    "<a href='".Router::url(array('controller'=>'desarrollos', 'action'=>'add_tarea', $reponse_[$i]['id']))."' class='pointer'> <i class='fa fa-add'></i> </a>";
                    // "<a onclick= 'uploadFac(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-add'></i> </a>";
                // ); 
                $response[$i]['edit']= "<a onclick= 'uploadFac(".$reponse_[$i]['id'].")' class='pointer'> <i class='fa fa-edit'> </i> </a>";
                $response[$i]['user']            = $user['User']['nombre_completo'];
                $response[$i]['etapa_id']        = $value['Validation']['etapa_id'];
                $response[$i]['validacion_name'] = $value['Validation']['validacion_name'];
                if ( $value['Validation']['status']==0) {
                    $response[$i]['status']          ="<a onclick= 'activarDesactivar(".$reponse_[$i]['id'].")' class='pointer'> <p style='color:#C22419'>Inactivo </p></a>";
                }else {
                    $response[$i]['status']          ="<a onclick= 'activarDesactivar(".$reponse_[$i]['id'].")' class='pointer'> <p style='color:#3DAE07'>Activo </p></a>";
                    
                }
                // $response[$i]['orden']        = $value['Validation']['orden'];
                $response[$i]['progreso']        = $value['Validation']['progreso'];
                // }
                $json[$count]=array(
                    $response[$i]['nuevo'],
                    $response[$i]['edit'],
                    $response[$i]['user'],  
                    $response[$i]['etapa_id'],
                    $response[$i]['validacion_name'],             
                    $response[$i]['status'],
                    // $response[$i]['orden'],

                    $response[$i]['progreso'],
                );
                $i++;
                $count++;
            }
        }else {
            $json = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }

        echo json_encode( $json , true );          
		exit();
		$this->autoRender = false;
    }
    /**
     * 
     * 
    */
    function activar_desactivar(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Validation');
        $this->loadModel('SubValidation');
        $this->loadModel('LogValidation');
        $this->LogValidation->Behaviors->load('Containable');
        $this->SubValidation->Behaviors->load('Containable');
        $this->Validation->Behaviors->load('Containable');
        if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
            $search=$this->request->data['validacionId'];
            $validation = $this->Validation->find('first',array(
                'conditions' => array(
                    'Validation.id' => $search,
                ),
                'contain' => false
            ));
            $validation_ = $this->Validation->find('count',array(
                'conditions' => array(
                    'Validation.cuenta_id' => $this->Session->read('CuentaUsuario.Cuenta.id' ),
                    'Validation.status' => 1,
                    'Validation.id !=' => $search,
                    'Validation.etapa_id' => $validation['Validation']['etapa_id'],
                ),
                'contain' => false
            ));
            $sub_validation=$this->SubValidation->find('count',array(
                'conditions' => array(
                    'SubValidation.validacion_id' => $search,
                ),
                'contain' => false
            ));
            if ($validation_ == 0 ) {
                if ( $sub_validation > 0 ) {
                    $logvalidation=$this->LogValidation->find('first',array(
                        'conditions' => array(
                            'LogValidation.validacion_id' => $search,
                            'LogValidation.status' => 1,
                        ),
                        'fields'     => array(
                            'LogValidation.id',
                            'LogValidation.status',
                        ),
                        'contain' => false
                    ));
                    if ($validation['Validation']['status']==1) {
                        $this->request->data['Validation']['id']              = $search;
                        $this->request->data['Validation']['status']          = 0;
                        
                        if ( $this->Validation->save($this->request->data['Validation']) ) {
        
                            $this->request->data['LogValidation']['id']                = $logvalidation['LogValidation']['id'];
                            $this->request->data['LogValidation']['status']            = 0;   
                            // $this->request->data['LogValidation']['user_validation']   = $this->Session->read('CuentaUsuario.User.id');
        
                            if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                                $this->LogValidation->create();
                                $this->request->data['LogValidation']['id']                = null;
                                $this->request->data['LogValidation']['validacion_id']     =$search;
                                $this->request->data['LogValidation']['status']            = 1;   
                                $this->request->data['LogValidation']['user_validation']   =$this->Session->read('CuentaUsuario.User.id');
                                $this->request->data['LogValidation']['description']       = 'desactivado';   
                                $this->request->data['LogValidation']['fecha_validation']  =  date('Y-m-d');   
                                if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                                    $response = array(
                                        'Ok' => true,
                                        'mensaje' => 'Se Desactivo la tarea'
                                    );
                                }  
                                
                            }                    
            
                        }
                    }else {
                        $this->request->data['Validation']['id']              = $search;
                        // $this->request->data['Validation']['fecha_create']    = date('Y-m-d');
                        $this->request->data['Validation']['status']          = 1;
                        if ( $this->Validation->save($this->request->data['Validation']) ) {
        
                            $this->request->data['LogValidation']['id']                =  $logvalidation['LogValidation']['id'];
                            $this->request->data['LogValidation']['status']            = 0;   
                            // $this->request->data['LogValidation']['user_validation']   = $this->Session->read('CuentaUsuario.User.id');
                            if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                                $this->LogValidation->create();
                                $this->request->data['LogValidation']['id']                = null;
                                $this->request->data['LogValidation']['validacion_id']     =$search;
                                $this->request->data['LogValidation']['status']            = 1;   
                                $this->request->data['LogValidation']['user_validation']   =$this->Session->read('CuentaUsuario.User.id');
                                $this->request->data['LogValidation']['description']       = 'activo';   
                                $this->request->data['LogValidation']['fecha_validation']  =  date('Y-m-d');   
                                if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                                    $response = array(
                                        'Ok' => true,
                                        'mensaje' => 'Se Activo la tarea'
                                    );
                                }
                                    
                            }
                        }
                    }
                
                }else{

                    $response = array(
                        'Ok' => true,
                        'mensaje' => 'no se puede activar esta que tenga una tarea'
                    );
                }
            }else{

                $response = array(
                    'Ok' => true,
                    'mensaje' => 'no se puede activar por que ya tienes un porcesos activo'
                );
            }

            
        }
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');
        echo json_encode( $validation_ , true );          
		exit();
		$this->autoRender = false;
    }
    /**
     * 
     * 
    */
    function view_edit_validacion(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Validation');
        $this->Validation->Behaviors->load('Containable');
        $i=0;
        if ( $this->request->is('post') ) {
            $search=$this->request->data['valiadacion_id'];
            $validation=$this->Validation->find('all',array(
                'conditions' => array(
                    'Validation.id' => $search,
                ),
                'contain' => false
            ));
            foreach ($validation as $value) {
                $reponse[$i]['nombre']=$value['Validation']['validacion_name'];
                $reponse[$i]['etapa_id']=$value['Validation']['etapa_id'];
                $reponse[$i]['id']=$value['Validation']['id'];
                $reponse[$i]['status']=$value['Validation']['status'];
                $i++;
            }
        }
        echo json_encode( $reponse , true );          
		exit();
		$this->autoRender = false;
    }
    /***
     * 
     * 
    */
    function edit_validacion(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Validation');
        $this->loadModel('LogValidation');
        $this->LogValidation->Behaviors->load('Containable');
        $this->Validation->Behaviors->load('Containable');
        if ( $this->request->is('post') ){
            $logvalidation=$this->LogValidation->find('first',array(
                'conditions' => array(
                    'LogValidation.validacion_id' => $this->request->data['EditValidacions']['validacion_id'],
                    'LogValidation.status' => 1,
                ),
                'fields'     => array(
                    'LogValidation.id',
                    'LogValidation.status',
                  ),
                'contain' => false
            ));
            $this->request->data['Validation']['id']              = $this->request->data['EditValidacions']['validacion_id'];
            $this->request->data['Validation']['validacion_name'] = $this->request->data['EditValidacions']['nombre'];
            $this->request->data['Validation']['etapa_id'] = $this->request->data['EditValidacions']['etapa_inicio'];
            $this->request->data['Validation']['status']          =  $this->request->data['EditValidacions']['status'];
          
            if ( $this->Validation->save($this->request->data['Validation']) ) {

                if ( $this->request->data['EditValidacions']['status']==1) {
                    $this->request->data['LogValidation']['id']                = $logvalidation['LogValidation']['id'];
                    $this->request->data['LogValidation']['status']            = 0;   
                    // $this->request->data['LogValidation']['user_validation']   = $this->Session->read('CuentaUsuario.User.id');

                    if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                        $this->LogValidation->create();
                        $this->request->data['LogValidation']['id']                = null;
                        $this->request->data['LogValidation']['validacion_id']     = $this->request->data['EditValidacions']['validacion_id'];
                        $this->request->data['LogValidation']['status']            = 1;   
                        $this->request->data['LogValidation']['user_validation']   =$this->Session->read('CuentaUsuario.User.id');
                        $this->request->data['LogValidation']['description']       = 'edicion';   
                        $this->request->data['LogValidation']['fecha_validation']  =  date('Y-m-d');   
                        if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                            $response = array(
                                'Ok' => true,
                                'mensaje' => 'Se Edito la Tarea'
                            );
                        }
                        
                    }
                }else {
                    $this->request->data['LogValidation']['id']                = $logvalidation['LogValidation']['id'];
                    $this->request->data['LogValidation']['status']            = 0;   
                    // $this->request->data['LogValidation']['user_validation']   = $this->Session->read('CuentaUsuario.User.id');

                    if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                        $this->LogValidation->create();
                        $this->request->data['LogValidation']['id']                = null;
                        $this->request->data['LogValidation']['validacion_id']     = $this->request->data['EditValidacions']['validacion_id'];
                        $this->request->data['LogValidation']['status']            = 1;   
                        $this->request->data['LogValidation']['user_validation']   =$this->Session->read('CuentaUsuario.User.id');
                        $this->request->data['LogValidation']['description']       = 'edicion';   
                        $this->request->data['LogValidation']['fecha_validation']  =  date('Y-m-d');   
                        if ( $this->LogValidation->save($this->request->data['LogValidation']) ){
                            $response = array(
                                'Ok' => true,
                                'mensaje' => 'Se Edito la Tarea'
                            );
                        }
                    }
                }

            }else {
                $response = array(
                    'Ok' => true,
                    'mensaje' => 'Intente De nuevo'
                );
            }

        }
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');
        echo json_encode( $response , true );          
		exit();
		$this->autoRender = false;
    }
    /***
     * 
     * 
    */
    function verificar(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Validation');
        $this->loadModel('ClienteValidation');
        $this->ClienteValidation->Behaviors->load('Containable');
        $this->Validation->Behaviors->load('Containable');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $i=0;
        // $response= arra();
        if ( $this->request->is('post') ){
            $search_cliente= $this->Cliente->find('first', array( 
                'conditions'=>array(
                    'Cliente.id'=>$this->request->data['cliente'],
                ),
                'fields' => array(
                    'Cliente.etapa',
                ),
                'contain' => false
            ));
            if ($search_cliente['Cliente']['etapa']>=5) {
                if ($search_cliente['Cliente']['etapa']==5) {
                    $search_validation=$this->Validation->find('all',array(
                        'conditions'=>array(
                            'Validation.cuenta_id' =>  $this->request->data['cuenta_id'],
                            'Validation.etapa_id' =>  5,
                            'Validation.status' =>  1,
                            'Validation.orden' =>  1,
                        ),
                        'contain' => false
                    ));
                }
                if ($search_cliente['Cliente']['etapa']==6) {
                    $search_validation=$this->Validation->find('all',array(
                        'conditions'=>array(
                            'Validation.cuenta_id' =>  $this->request->data['cuenta_id'],
                            'Validation.etapa_id' =>  6,
                            'Validation.status' =>  1,
                            'Validation.orden' =>  1,
                        ),
                        'contain' => false
                    ));
                }
                if ($search_cliente['Cliente']['etapa']==7) {
                    $search_validation=$this->Validation->find('all',array(
                        'conditions'=>array(
                            'Validation.cuenta_id' =>  $this->request->data['cuenta_id'],
                            'Validation.etapa_id' =>  7,
                            'Validation.status' =>  1,
                            'Validation.orden' =>  1,
                        ),
                        'contain' => false
                    ));
                }
               
                foreach ($search_validation as  $value) {
                    
                    $cliente_validacion=$this->ClienteValidation->find('first',array(
                        'conditions'=>array(
                            'ClienteValidation.cliente_id' =>  $this->request->data['cliente'],
                            'ClienteValidation.validacion_id' => $value['Validation']['id'],
                          
                        ),
                        'fields' => array(
                            'ClienteValidation.validacion_id',
                        ),
                        'contain' => false
                    ));
                    if ( $value['Validation']['id'] ==  $cliente_validacion['ClienteValidation']['validacion_id'] ) {
                        $response[$i]['valiacion_id']=0;
                    }else{
                        $response[$i]['valiacion_id']=$value['Validation']['id'];
                        $response[$i]['valiacion_etapa']=$value['Validation']['etapa_id'];
                        $response[$i]['cliente']=$search_cliente['Cliente']['etapa'];
                        $response[$i]['nombre']=$value['Validation']['validacion_name'];
                        $i++;
                    }
                }
            }
            
        
        }
        echo json_encode( $response , true );          
		exit();
		$this->autoRender = false;
    }
}