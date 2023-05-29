<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property LogPago $LogPago
 * @property PaginatorComponent $Paginator
 */
class LogPagosController extends AppController {


    public $components = array('Paginator' );


    public $uses = array(
            'Cliente','Inmueble','Desarrollo',
            'User',
            'Venta','Transaccion', 'Factura','MailConfig', 'Paramconfig', 'Cuenta', 'Cotizacion'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('view_datos_cliente','pago_mes_cliente_','log_pago_lleno'));
      
    }
    /**
     * 
     * 
     * 
     * 
    */
    function log_pago_lleno(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Cotizacion');
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('LogPago');
        $this->loadModel('Cliente');
        $this->loadModel('PagosPrincipale');
        $this->PagosPrincipale->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $this->LogPago->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        $this->Cotizacion->Behaviors->load('Containable');
        if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
            $response=[];
            $meses=0;
            // $cuenta_id = 179;
            if (!empty( $this->request->data['cuenta_id'])) {
                $cuenta_id = $this->request->data['cuenta_id'];
    
                $operaciones=$this->OperacionesInmueble->find('all',array(
                    'conditions'=>array(
                        'OperacionesInmueble.cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = '.$cuenta_id.')',
                        'OperacionesInmueble.tipo_operacion' => 3,
                    ),
                    
                    'contain' => false
                ));
            }
            if (!empty( $this->request->data['cliente_id'])) {
                $cliente_id = $this->request->data['cliente_id'];
                $cliente=$this->Cliente->find('first',array(
                    'conditions'=>array(
                      'Cliente.id' => $this->request->data['cliente_id']
                    ),
                    'fields' => array(
                      'Cliente.cuenta_id',  
                    ),
                    'contain' => false
                )); 
                $cuenta_id=$cliente['Cliente']['cuenta_id'];
                $operaciones=$this->OperacionesInmueble->find('all',array(
                    'conditions'=>array(
                        'OperacionesInmueble.cliente_id ' => $cliente_id,
                        'OperacionesInmueble.tipo_operacion' => 3,
                    ),
                    
                    'contain' => false
                ));
            }

            $i = 0;
            foreach ($operaciones as  $operacion) {
                $cotizacion=$this->Cotizacion->find('first',array(
                    'conditions'=>array(
                        'Cotizacion.id' => $operacion['OperacionesInmueble']['cotizacion_id'],
                        'Cotizacion.status' => 3,
                        'Cotizacion.status_asesor' => 1,
                    ),
                    
                    'contain' => false
                ));
                $meses=(int)$cotizacion['Cotizacion']['meses'];
                $val=1;
                $inicio=$operacion['OperacionesInmueble']['fecha'];
                $fecha_inicio= strtotime($val.' month',strtotime($inicio));
                $fecha_inicio= date('Y-m-d',$fecha_inicio);
                $fecha= strtotime($meses.' month',strtotime($inicio));
                $fecha= date('Y-m-d',$fecha);
                $periodos = $this->getPeriodosArreglo($fecha_inicio,$fecha);
                
                $desarollo_id= $this->DesarrolloInmueble->find('first', array(
                    'conditions' => array(
                        'DesarrolloInmueble.inmueble_id'=> $operacion['OperacionesInmueble']['inmueble_id'],
                    ),
                    'fields' => array(
                        'desarrollo_id',
                        'referencia',
                    ),
                ));
                if ( $cotizacion['Cotizacion']['financiamiento'] < 100 ) {
                    if ($meses<1 || $meses==null) {
                        $mensualidades=( $cotizacion['Cotizacion']['financiamiento'] * $cotizacion['Cotizacion']['precio_final'] );
                        $financiamiento=( $cotizacion['Cotizacion']['financiamiento'] * $cotizacion['Cotizacion']['precio_final'] );
                    }else{
                        $mensualidades= ( (( $cotizacion['Cotizacion']['financiamiento'] * $cotizacion['Cotizacion']['precio_final'] ) / 100) / ($meses));
                        $financiamiento=( ($cotizacion['Cotizacion']['financiamiento'] * $cotizacion['Cotizacion']['precio_final']) / 100 );

                    }
                    
                }else {
                    if ($meses < 1 || $meses==null) {
                        $mensualidades=$cotizacion['Cotizacion']['financiamiento'];
                        $financiamiento=$cotizacion['Cotizacion']['financiamiento'];
                    }else{
                        $mensualidades =( $cotizacion['Cotizacion']['financiamiento'] / $meses);
                        $financiamiento=$cotizacion['Cotizacion']['financiamiento'];
                    }
                }
                
                
                $p = 1;
                $i = 0;
                // $response[$i]['coti']= $cotizacion;
                // $i++;
                $log_pgo=$this->LogPago->find('all', array(
                    'conditions' => array(
                        'LogPago.operaciones_inmueble_id'=> $operacion['OperacionesInmueble']['id'],
                    ),
                ));
                $pagos_principal=$this->PagosPrincipale->find('all', array(
                    'conditions' => array(
                        'PagosPrincipale.cotizacion_id'=> $cotizacion['Cotizacion']['id'],
                    ),
                ));
                if ($pagos_principal==null) {
                    if ( $cotizacion['Cotizacion']['apartado'] < 100 ) {
                        if ($cotizacion['Cotizacion']['apartado']==0) {
                            $apartado=0;
                        }else{
                            $apartado= ( (( $cotizacion['Cotizacion']['apartado'] * $cotizacion['Cotizacion']['precio_final'] ) / 100));    
                        }
                        
                    }else {
                        if ($cotizacion['Cotizacion']['apartado']==0) {
                            $apartado=0;
                        }else{
                            $apartado= ( $cotizacion['Cotizacion']['apartado']);    
                        }
                    }
                    $this->PagosPrincipale->create();
                    $this->request->data['PagosPrincipale']['id']            = null;
                    $this->request->data['PagosPrincipale']['cliente_id']    = $operacion['OperacionesInmueble']['cliente_id'];
                    $this->request->data['PagosPrincipale']['cotizacion_id'] = $cotizacion['Cotizacion']['id'];
                    $this->request->data['PagosPrincipale']['user_id']       = $operacion['OperacionesInmueble']['user_id'];
                    $this->request->data['PagosPrincipale']['cuenta_id']     =  $cuenta_id;
                    $this->request->data['PagosPrincipale']['fecha_pago']    = null;
                    $this->request->data['PagosPrincipale']['tipo_pago']     = 0;
                    $this->request->data['PagosPrincipale']['monto']         = $apartado;
                    $this->request->data['PagosPrincipale']['status']        = 0;
                    $this->request->data['PagosPrincipale']['nota']          = null;
                    $this->request->data['PagosPrincipale']['desarrollo_id'] = $desarollo_id['DesarrolloInmueble']['desarrollo_id'];
                    $this->request->data['PagosPrincipale']['inmueble_id']   = $cotizacion['Cotizacion']['inmueble_id'];
                    $this->request->data['PagosPrincipale']['validation_id'] = null;
                    if ($this->PagosPrincipale->save($this->request->data)){
                            
                        $response_ = array(
                            'Ok' => false,
                            'mensaje0' => 'se actualizo la base de datos PagosPrincipale 0'
                        );
                    }
                    if ( $cotizacion['Cotizacion']['contrato'] < 100 ) {
                        if ($cotizacion['Cotizacion']['contrato']==0) {
                            $contrato=0;
                        }else{
                            $contrato= ( (( $cotizacion['Cotizacion']['contrato'] * $cotizacion['Cotizacion']['precio_final'] ) / 100));    
                        }
                        
                    }else {
                        if ($cotizacion['Cotizacion']['contrato']==0) {
                            $contrato=0;
                        }else{
                            $contrato= ( $cotizacion['Cotizacion']['contrato']);    
                        }
                    }
                    $this->PagosPrincipale->create();
                    $this->request->data['PagosPrincipale']['id']            = null;
                    $this->request->data['PagosPrincipale']['cliente_id']    = $operacion['OperacionesInmueble']['cliente_id'];
                    $this->request->data['PagosPrincipale']['cotizacion_id'] = $cotizacion['Cotizacion']['id'];
                    $this->request->data['PagosPrincipale']['user_id']       = $operacion['OperacionesInmueble']['user_id'];
                    $this->request->data['PagosPrincipale']['cuenta_id']     =  $cuenta_id;
                    $this->request->data['PagosPrincipale']['fecha_pago']    = null;
                    $this->request->data['PagosPrincipale']['tipo_pago']     = 1;
                    $this->request->data['PagosPrincipale']['monto']         = $contrato;
                    $this->request->data['PagosPrincipale']['status']        = 0;
                    $this->request->data['PagosPrincipale']['nota']          = null;
                    $this->request->data['PagosPrincipale']['desarrollo_id'] = $desarollo_id['DesarrolloInmueble']['desarrollo_id'];
                    $this->request->data['PagosPrincipale']['inmueble_id']   = $cotizacion['Cotizacion']['inmueble_id'];
                    $this->request->data['PagosPrincipale']['validation_id'] = null;
                    if ($this->PagosPrincipale->save($this->request->data)){
                            
                        $response_ = array(
                            'Ok' => false,
                            'mensaje1' => 'se actualizo la base de datos PagosPrincipale 1'
                        );
                    }
                    if ( $cotizacion['Cotizacion']['escrituracion'] < 100 ) {
                        if ($cotizacion['Cotizacion']['escrituracion']==0) {
                            $escrituracion=0;
                        }else{
                            $escrituracion= ( (( $cotizacion['Cotizacion']['escrituracion'] * $cotizacion['Cotizacion']['precio_final'] ) / 100));    
                        }
                        
                    }else {
                        if ($cotizacion['Cotizacion']['escrituracion']==0) {
                            $escrituracion=0;
                        }else{
                            $escrituracion= ( $cotizacion['Cotizacion']['escrituracion']);    
                        }
                    }
                    $this->PagosPrincipale->create();
                    $this->request->data['PagosPrincipale']['id']            = null;
                    $this->request->data['PagosPrincipale']['cliente_id']    = $operacion['OperacionesInmueble']['cliente_id'];
                    $this->request->data['PagosPrincipale']['cotizacion_id'] = $cotizacion['Cotizacion']['id'];
                    $this->request->data['PagosPrincipale']['user_id']       = $operacion['OperacionesInmueble']['user_id'];
                    $this->request->data['PagosPrincipale']['cuenta_id']     =  $cuenta_id;
                    $this->request->data['PagosPrincipale']['fecha_pago']    = null;
                    $this->request->data['PagosPrincipale']['tipo_pago']     = 2;
                    $this->request->data['PagosPrincipale']['monto']         = $escrituracion;
                    $this->request->data['PagosPrincipale']['status']        = 0;
                    $this->request->data['PagosPrincipale']['nota']          = null;
                    $this->request->data['PagosPrincipale']['desarrollo_id'] = $desarollo_id['DesarrolloInmueble']['desarrollo_id'];
                    $this->request->data['PagosPrincipale']['inmueble_id']   = $cotizacion['Cotizacion']['inmueble_id'];
                    $this->request->data['PagosPrincipale']['validation_id'] = null;
                    if ($this->PagosPrincipale->save($this->request->data)){
                            
                        $response_ = array(
                            'Ok' => false,
                            'mensaje2' => 'se actualizo la base de datos PagosPrincipale 1'
                        );
                    }
                }
                if ( $log_pgo == null) {

                    foreach ($periodos as $key => $value) {
                    
                        $this->LogPago->create();
                        $this->request->data['LogPago']['id']                      = null;
                        $this->request->data['LogPago']['cliente_id']              = $operacion['OperacionesInmueble']['cliente_id'];
                        $this->request->data['LogPago']['monto_financiamiento']    = $financiamiento;
                        $this->request->data['LogPago']['fecha_pago']              = null;
                        $this->request->data['LogPago']['fecha_programada']        = $key;
                        $this->request->data['LogPago']['monto_programado']        = $mensualidades;
                        $this->request->data['LogPago']['monto_pagado']            = 0;
                        $this->request->data['LogPago']['monto_total']             = 0;
                        $this->request->data['LogPago']['valor_unidad']            = $cotizacion['Cotizacion']['precio_final'];
                        $this->request->data['LogPago']['status']                  = 'Pendiente';
                        $this->request->data['LogPago']['folio']                   = uniqid();  
                        $this->request->data['LogPago']['cotizacion_id']           = $cotizacion['Cotizacion']['id'];
                        $this->request->data['LogPago']['comprobante']             = null;
                        $this->request->data['LogPago']['interes']                 = 0;
                        $this->request->data['LogPago']['monto_adelantado']        = 0;
                        $this->request->data['LogPago']['operaciones_inmueble_id'] = $operacion['OperacionesInmueble']['id'];
                        $this->request->data['LogPago']['user_id']                 = $operacion['OperacionesInmueble']['user_id'];
                        $this->request->data['LogPago']['cuenta_id']               = $cuenta_id;
                        $this->request->data['LogPago']['mes']                     = $p;
                        $this->request->data['LogPago']['desarrollo_id']           = $desarollo_id['DesarrolloInmueble']['desarrollo_id'];
                        $this->request->data['LogPago']['inmueble_id']             =  $cotizacion['Cotizacion']['inmueble_id'];
                        $this->request->data['LogPago']['referencia']              = $desarollo_id['DesarrolloInmueble']['referencia'] ;
        
                        // $response[$i]['cliente_id'] = $operacion['OperacionesInmueble']['cliente_id']                                                     ;
                        // $response[$i]['fecha_pago'] = null                                                     ;
                        // $response[$i]['fecha_programada'] = $key                                        ;
                        // $response[$i]['monto_programado'] = $mensualidades                                               ;
                        // $response[$i]['monto_pagado'] = 0                                                                        ;
                        // $response[$i]['monto_total'] = 0                                                                        ;
                        // $response[$i]['valor_unidad'] = $operacion['OperacionesInmueble']['precio_cierre']                       ;
                        // $response[$i]['status'] = 'Pendiente'                                                              ;
                        // $response[$i]['folio'] = uniqid();                  
                        // $response[$i]['cotizacion_id'] = $cotizacion['Cotizacion']['id']                                          ;
                        // $response[$i]['comprobante'] = null                                                                     ;
                        // $response[$i]['interes'] = 0                                                                        ;
                        // $response[$i]['monto_adelantado'] = 0                                                                        ;
                        // $response[$i]['operaciones_inmueble_id'] = $operacion['OperacionesInmueble']['id'];
                        // $response[$i]['user_id'] = $operacion['OperacionesInmueble']['user_id']                             ;
                        // $response[$i]['cuenta_id'] = $cuenta_id                        ;
                        // $response[$i]['mes'] = $p                          ;
                        // $response[$i]['desarollo_id'] = $desarollo_id['DesarrolloInmueble']['desarrollo_id']                     ;
                        // $response[$i]['referencia'] = $desarollo_id['DesarrolloInmueble']['referencia']                ;
                        // $response[$i]['f'] = $financiamiento                ;
                        $p++;
                        // $i++;
                        if ($this->LogPago->save($this->request->data)){
                            
                            $log = $this->LogPago->getInsertID();
                            $response_ = array(
                                'Ok' => false,
                                'mensajelog' => 'se actualizo la base de datos '
                            );
                        }
                    }
                }else {
                    $response_ = array(
                        'Ok' => false,
                        'mensaje' => 'ya existe un proceso gracias'
                    );
                }
                
            }
        } else {
            $response_ = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }

        echo json_encode( $response_, true );          
		exit();
		$this->autoRender = false;
    }
    /***
     * 
     * 
     * 
    */
    function view_datos_cliente(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Cliente');
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
            $cliente = $this->OperacionesInmueble->find('all',
                array(
                    'conditions' => array(
                        'OperacionesInmueble.cliente_id' => $this->request->data['cliente_id'],
                        'OperacionesInmueble.tipo_operacion' => 3,
                    ),'fields' => array(
                        'tipo_operacion',
                        'fecha',
                        'vigencia_operacion',
                        'precio_cierre',
                    ),
                    'contain' => array(
                        'Inmueble' => array(
                            'fields' => array(
                                'id',
                                'referencia'
                            )
                        ),
                        'Cliente' => array(
                            'fields' => array(
                                'id',
                                'nombre',
                                'correo_electronico',
                                'telefono1',
                                'telefono1',
                            )
                        ),
                        'User' => array(
                            'fields' => array(
                                'id',
                                'nombre_completo'
                            )
                        ),
                        'Cotizacion' => array(
                            'fields' => array(
                                'id',
                                'financiamiento',
                                'apartado',
                                'contrato',
                                'escrituracion',
                                'meses',
                                'precio_final',
                            )
                        ),
                        'LogPago' => array(

                        ),
                    ),
                    'order'   => 'OperacionesInmueble.fecha DESC',
                ) 
            );
            $desarollo_id= $this->DesarrolloInmueble->find('first', array(
                'conditions' => array(
                    'DesarrolloInmueble.inmueble_id'=> $cliente[0]['Inmueble']['id'],
                ),
                'fields' => array(
                    'desarrollo_id',
                    'referencia',
                ),
            ));
            $desarollo=$this->Desarrollo->find('first', array(
                'conditions' => array(
                    'Desarrollo.id'=> $desarollo_id['DesarrolloInmueble']['desarrollo_id'],
                ),
                'fields' => array(
                    'id',
                    'nombre',
                    'logotipo',
                ),
                'contain' => false

            ));
            if ( $cliente[0]['Cotizacion']['financiamiento'] < 100 ) {
                $mesualidades=( ($cliente[0]['Cotizacion']['financiamiento'] * $cliente[0]['Cotizacion']['precio_final']) / $cliente[0]['Cotizacion']['meses']);
            
            }else {
                $mesualidades=($cliente[0]['Cotizacion']['financiamiento']/$cliente[0]['Cotizacion']['meses']);
            }
            if ($cliente[0]['Cotizacion']['escrituracion'] < 100 ) {
                $escrituracion=( ($cliente[0]['Cotizacion']['escrituracion'] * $cliente[0]['Cotizacion']['precio_final']) / 100 );
            }else{
                $escrituracion=$cliente[0]['Cotizacion']['escrituracion'];

            }
            if ($cliente[0]['Cotizacion']['contrato'] < 100 ) {
                $contrato=( ($cliente[0]['Cotizacion']['contrato'] * $cliente[0]['Cotizacion']['precio_final']) / 100 );
            }else{
                $contrato=$cliente[0]['Cotizacion']['contrato'];

            }
            $i=0;
            $j=0;
            foreach ($cliente as $value) {
                $reponse_[$i]['cliente']['id']                 = $value['Cliente']['id'];
                $reponse_[$i]['cliente']['nombre']             = $value['Cliente']['nombre'];
                $reponse_[$i]['cliente']['correo_electronico'] = $value['Cliente']['correo_electronico'];
                $reponse_[$i]['cliente']['telefono1']          = $value['Cliente']['telefono1'];
                $reponse_[$i]['cliente']['referencia']         = $value['Inmueble']['referencia'];
                $reponse_[$i]['cliente']['logo']               = Router::url($desarollo['Desarrollo']['logotipo'],true) ;
                $reponse_[$i]['cliente']['financiamiento']     = $value['Cotizacion']['financiamiento'];
                $reponse_[$i]['cliente']['apartado']           = $value['Cotizacion']['apartado'];
                $reponse_[$i]['cliente']['contrato']           = $contrato;
                $reponse_[$i]['cliente']['meses']              = $value['Cotizacion']['meses'];
                $reponse_[$i]['cliente']['escrituracion']      = $escrituracion;
                $reponse_[$i]['cliente']['precio_cierre']      = round($value['Cotizacion']['precio_final'],2);
                $reponse_[$i]['cliente']['fecha']              = $value['OperacionesInmueble']['fecha'];
                $reponse_[$i]['cliente']['user_nombre']        = $value['User']['nombre_completo'];
                // $reponse_[$i]['cliente']['totalpagado']        = $value[0]['LogPago']['monto_total_pagado'];

                $reponse_[$i]['cliente']['mensualidad']        = round($mesualidades,2);
                foreach ($value['LogPago'] as $pagos) {
                    $reponse_[$i]['pagos'][$j]['id']               = $pagos['id'];
                    $reponse_[$i]['pagos'][$j]['fecha']            = $pagos['fecha_programada'];
                    $reponse_[$i]['pagos'][$j]['monto_programado'] = round($pagos['monto_programado'],2);
                    $reponse_[$i]['pagos'][$j]['referencia']       = $pagos['referencia'];
                    $reponse_[$i]['pagos'][$j]['mes']              = $pagos['mes'];
                    $reponse_[$i]['pagos'][$j]['status']           = $pagos['status'];
                    $reponse_[$i]['pagos'][$j]['comprobante']      = $pagos['comprobante'];
                    $reponse_[$i]['pagos'][$j]['fecha_pago']       = $pagos['fecha_pago'];
                    if ( $pagos['monto_total_pagado']==null) {
                        $reponse_[$i]['cliente']['totalpagado']               = 'sin pagos';
                        
                    }else {
                        $reponse_[$i]['cliente']['totalpagado']               = $pagos['monto_total_pagado'];
                        
                    }
                    $j++;
                }
                $i++;
            }
            $i=0;
            $res = array(
                'Ok' => true,
                'respuesta' => $cliente
            );

        } else {
            $res = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }
        echo json_encode( $res , true );          
		exit();
		$this->autoRender = false;
    }
    /**
     * 
     * 
     */
    function pagos_log(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Cliente');
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
            $cliente = $this->OperacionesInmueble->find('all',
                array(
                    'conditions' => array(
                        'OperacionesInmueble.cliente_id' => $this->request->data['cliente_id'],
                        'OperacionesInmueble.tipo_operacion' => 3,
                    ),'fields' => array(
                        'tipo_operacion',
                        'fecha',
                        'vigencia_operacion',
                        'precio_cierre',
                    ),
                    'contain' => array(
                        'Inmueble' => array(
                            'fields' => array(
                                'id',
                                'referencia'
                            )
                        ),
                        'Cliente' => array(
                            'fields' => array(
                                'id',
                                'nombre',
                                'correo_electronico',
                                'telefono1',
                                'telefono1',
                            )
                        ),
                        'User' => array(
                            'fields' => array(
                                'id',
                                'nombre_completo'
                            )
                        ),
                        'Cotizacion' => array(
                            'fields' => array(
                                'id',
                                'financiamiento',
                                'apartado',
                                'contrato',
                                'escrituracion',
                                'meses',
                                'precio_final',
                            )
                        ),
                        'LogPago' => array(

                        ),
                    ),
                    'order'   => 'OperacionesInmueble.fecha DESC',
                ) 
            );
            $desarollo_id= $this->DesarrolloInmueble->find('first', array(
                'conditions' => array(
                    'DesarrolloInmueble.inmueble_id'=> $cliente[0]['Inmueble']['id'],
                ),
                'fields' => array(
                    'desarrollo_id',
                    'referencia',
                ),
            ));
            $desarollo=$this->Desarrollo->find('first', array(
                'conditions' => array(
                    'Desarrollo.id'=> $desarollo_id['DesarrolloInmueble']['desarrollo_id'],
                ),
                'fields' => array(
                    'id',
                    'nombre',
                    'logotipo',
                ),
                'contain' => false

            ));
            $i=0;
            $count=0;
            foreach ($cliente[0]['LogPago']as $pagos) {
                $reponse_[$i]['id']               = $pagos['id'];
                $reponse_[$i]['fecha']            = $pagos['fecha_programada'];
                $reponse_[$i]['monto_programado'] = round($pagos['monto_programado'],2);
                $reponse_[$i]['referencia']       = $pagos['referencia'];
                $reponse_[$i]['mes']              = $pagos['mes'];
                $reponse_[$i]['status']           = $pagos['status'];
                if ($pagos['comprobante']==null) {
                    $reponse_[$i]['comprobante'] ='falta'  ;
                }else {
                    $reponse_[$i]['comprobante']      = $pagos['comprobante'];
                }
                if ($pagos['fecha_pago']==null) {

                    $reponse_[$i]['fecha_pago']       = 'sin registro';
                
                }else {
                    $reponse_[$i]['fecha_pago']       = $pagos['fecha_pago'];
                }
                if ($pagos['fecha']==null) {

                    $reponse_[$i]['fecha']       =  $pagos['fecha_programada'];
                
                }else {
                    $reponse_[$i]['fecha']       =  $pagos['fecha_programada'];
                }
                $reponse_[$i]['carlos']       =  'roberto puto';
                $clientes_json[$count] = array(
                    $reponse_[$i]['id'],
                    $reponse_[$i]['comprobante']  ,   
                    $reponse_[$i]['referencia'] ,     
                    $reponse_[$i]['fecha'],           
                    $reponse_[$i]['mes']  ,           
                    $reponse_[$i]['monto_programado'],
                    $reponse_[$i]['fecha']    ,  
                    $reponse_[$i]['status'] ,      
                    $reponse_[$i]['fecha_pago'],   
                    // "<a href='".Router::url('/inmuebles/view/'.$venta['Inmueble']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Inmueble']['referencia']))."</a>",
                    // "<a href='".Router::url('/clientes/view/'.$venta['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Cliente']['nombre']))."</a>",
                    // $venta['Cliente']['DicLineaContacto']['linea_contacto'],
                    // "<a href='".Router::url('/clientes/view/'.$venta['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['User']['nombre_completo']))."</a>",
                    // date('Y-m-d', strtotime($venta['OperacionesInmueble']['fecha'])),
                    // date('Y-m-d', strtotime($venta['OperacionesInmueble']['vigencia_operacion'])),
                    
                    // $response[$i]['total'],
                    
                );
                $count++;
                $i++;

            }
            echo json_encode( $clientes_json , true );          
		exit();
		$this->autoRender = false;
        } 
    }
    /***
     * 
     * 
     * 
     */
    function historico_pagos(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Cliente');
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('Desarrollo');
        $this->loadModel('PagosPrincipale');
        $this->PagosPrincipale->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $i=0;
        $count=0;
        if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
            $cliente=58104;
        
            $view=$this->PagosPrincipale->find('all',array(
                'conditions' => array(
                    'PagosPrincipale.cliente_id'=> $cliente,
                ),
                'contain' => false
            ));
            foreach ($view as  $value) {
                $inmueble= $this->DesarrolloInmueble->find('first', array(
                    'conditions' => array(
                        'DesarrolloInmueble.inmueble_id'=> $value['PagosPrincipale']['inmueble_id'],
                    ),
                    'fields' => array(
                        'desarrollo_id',
                        'referencia',
                    ),
                ));
                if ($value['PagosPrincipale']['tipo_pago'] ==0) {
    
                    $reponse[$i]['tipo']='Apartado de la propiedad '.$inmueble['DesarrolloInmueble']['referencia'];
                }
                elseif ($value['PagosPrincipale']['tipo_pago'] ==1) {
    
                    $reponse[$i]['tipo']='contrato de la propiedad '.$inmueble['DesarrolloInmueble']['referencia'];
                }else {
                    $reponse[$i]['tipo']='escrituracion de la propiedad '.$inmueble['DesarrolloInmueble']['referencia'];
                    
                }
                if ($value['PagosPrincipale']['status']==0) {
    
                    $reponse[$i]['status']='sin pago';
                }else {
    
                    $reponse[$i]['status']='pagado';
                    
                }
                if ($value['PagosPrincipale']['fecha_pago']==null) {
    
                    $reponse[$i]['fecha']='sin fecha ';
    
                }else {
                    $reponse[$i]['fecha']=$value['PagosPrincipale']['fecha_pago'];
                    
                }
                if ($value['PagosPrincipale']['comprobante']!= null) {
                    
                    $reponse[$i]['comprobante']=$value['PagosPrincipale']['comprobante'];
                }else{
                    $reponse[$i]['comprobante']='sin comprobante';
                }
                $reponse[$i]['monto']=$value['PagosPrincipale']['monto'];
                $reponse[$i]['id']=$i;
                $reponse_json[$count]=array(
                    // $reponse[$i]['id'],
                    $reponse[$i]['tipo'],
                    $reponse[$i]['status']  , 
                    $reponse[$i]['fecha'],           
                    $reponse[$i]['comprobante'],
                    $reponse[$i]['monto']  ,            
                );
                $i++;
                $count++;
            }
        }else {
            $reponse_json = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
        }
       
        echo json_encode( $reponse_json , true );          
		exit();
		$this->autoRender = false;
    }
    /**
     * 
     * 
     * 
    */
    public function getPeriodosArreglo($fecha_inicial = null, $fecha_final = null){
        $ano_inicial = date('Y',strtotime($fecha_inicial));
        $ano_final = date('Y',strtotime($fecha_final));
        $mes_arranque = intval(date('m',strtotime($fecha_inicial)));
        $mes_final =  intval(date('m',strtotime($fecha_final)));

        $dia_arranque = intval(date('d',strtotime($fecha_inicial)));
        $dis_final =  intval(date('d',strtotime($fecha_final)));
    
        $periodos = array();
        $tope = 12;
        for($i=$ano_inicial ; $i<= $ano_final; $i++){
            if($i==$ano_final){
                $tope = $mes_final;
            }
            for($x = $mes_arranque; $x<=$tope; $x++){
                $mes = ($x<10 ? "0".$x : $x);
                $periodos[$i."-".$mes.'-'.$dis_final] = $dis_final.'-'.$mes."-".$i;
            }
            $mes_arranque = 1;
        }
    
        //$this->set('periodos',$periodos);
        return $periodos;
    
    }
     /***
     * 
     * 
     * 
    */
    function pago_mes_cliente_(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('LogPago');
        $this->LogPago->Behaviors->load('Containable');

        if ($this->request->is('post')) {
                
            $id = $this->request->data['id_pago'];
            $file= $this->request->data['Image'];
            $sinvocales = substr ($file,12);
            mkdir(getcwd()."/img/pagos/".$id,0777);           
            $operacion=$this->LogPago->find('first',array(
                'conditions'=>array(
                    'LogPago.id' =>  $id,
                ),
                'fields' => array(
                    'LogPago.operaciones_inmueble_id',
                    'LogPago.monto_programado',
                ),
                'contain' => false
            ));
            $this->request->data['LogPago']['id']          = $id;
            // if ($this->request->data['LogPago']['imagen'] != null ) {
            //     $filename = getcwd()."/img/pagos/".$operacion['LogPago']['operaciones_inmueble_id']."".$sinvocales;
            //     move_uploaded_file('pagos',$filename);
            //     $ruta = "/img/pagos/".$operacion['LogPago']['operaciones_inmueble_id']."/".$sinvocales;
            //     $this->request->data['LogPago']['comprobante'] =$ruta;

            // }
            if ($this->request->data['Image'] != null ) {
                $filename = getcwd()."/img/pagos/".$operacion['LogPago']['operaciones_inmueble_id']."/".$sinvocales;
                move_uploaded_file($filename, 'pagos');
                $ruta = "/img/pagos/".$operacion['LogPago']['operaciones_inmueble_id']."/".$sinvocales;
                $this->request->data['LogPago']['comprobante'] =$ruta;

            }
            
            
            if ($this->request->data['LogPago']['pago'] > $operacion['LogPago']['monto_programado']) {
                $resto = ($operacion['LogPago']['monto_programado']) - ($this->request->data['LogPago']['pago']);
                $this->request->data['LogPago']['monto_adelantado'];
            }


            if ( $this->LogPago->save($this->request->data['LogPago']) ) {

                $response = array(
                    'Ok' => true,
                    'mensaje' => 'Pago actualizado con éxito'
                );

            }else {
                $response = array(
                    'Ok' => false,
                    'mensaje' => 'No se pudo actualizar el pago'
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
        echo json_encode( $response, true );          
		exit();
		$this->autoRender = false;
    }



}