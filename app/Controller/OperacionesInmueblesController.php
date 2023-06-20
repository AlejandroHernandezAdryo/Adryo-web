<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
/**
 * OperacionesInmuebles Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class OperacionesInmueblesController extends AppController {

    /**
     * Components
     *
     * @var array
     */

	public $components = array('Paginator');
    public $uses = array('OperacionesInmueble', 'Inmueble', 'LogInmueble', 'LogCliente', 'Cliente', 'Agenda', 'DocsCliente', 'Venta', 'LogClientesEtapa', 'DesarrolloInmueble');
    public $cuenta_id;
    public $iDCorporativo;
    public $endPoint;
    public $idCRM;
    public $status_inmueble = [];

    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $this->status_inmueble = array(
            0 => 'Bloqueado',
            1 => 'Libres / En venta',
            2 => 'Apartado / Reservado',
            3 => 'Vendido / Contrato',
            4 => 'Escriturado',
            5 => 'Baja'
        );

        // Parametros para consumir la api de Mappen
        $this->endPoint      = "https://us-central1-inmoviliarias-hmmx.cloudfunctions.net/mpSincronizarUnidad";
        $this->iDCorporativo = "Acciona";

        // Paginas fuera de login
        $this->Auth->allow(array('cancelacion'));
    }

    /* -------------------------------------------------------------------------- */
    /*                       Metodo para actulizar en Mappen                      */
    /* -------------------------------------------------------------------------- */
    function updateDataInmueblesMappen( $new_precio = null, $property_status = null, $idInmueble = null ){
        $HttpSocket = new HttpSocket();
        
        $response = $HttpSocket->put($this->endPoint, array('idCRM' => $idInmueble, 'idCorporativo' => $this->iDCorporativo, 'precio' => $new_precio, 'status' => $property_status));
    
        echo $response;
        $this->autoRender = false;
    
    }

    public function add_reserva(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $save    = [];
        
        if ($this->request->is('post')){
            
            $mensaje     = '';
            $inmueble_id = $this->request->data['ProcesoInmuebles']['inmueble_id'];
            $inmueble    = $this->Inmueble->find('first',array('conditions'=>array('Inmueble.id'=>$inmueble_id)));
            $cliente     = $this->Cliente->read(null,$this->request->data['ProcesoInmuebles']['cliente_id']);
            $timestamp   = date('Y-m-d H:i:s');
            $search_desarrollo_id=$this->DesarrolloInmueble->find('first',array(
                'conditions'=>array(
                    'DesarrolloInmueble.inmueble_id'=>$inmueble_id
                ),
                'fields' => array(
                    'DesarrolloInmueble.desarrollo_id'
                ),
                'contain' => false 
                )
            );
    
            // // Alta de archivos.
            $dataDocsCliente = array(
                'cuenta_id'      => $this->cuenta_id,
                'documento'      => '',
                'tipo_documento' => '',
                'comentarios'    => '',
                'user_id'        => $this->Session->read('Auth.User.id'),
                'inmueble_id'    => $inmueble_id,
                'cliente_id'     => $cliente['Cliente']['id']
            );
    
            $this->request->data['OperacionesInmueble']['tipo_operacion']     = $this->request->data['ProcesoInmuebles']['tipo_operacion'];
            $this->request->data['OperacionesInmueble']['precio_unidad']      = $this->request->data['ProcesoInmuebles']['precio_unidad'];
            $this->request->data['OperacionesInmueble']['precio_cierre']      = $this->request->data['ProcesoInmuebles']['monto_reserva'];
            $this->request->data['OperacionesInmueble']['fecha']              = date('Y-m-d', strtotime($this->request->data['ProcesoInmuebles']['fecha_reserva']));
            $this->request->data['OperacionesInmueble']['cliente_id']         = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->request->data['OperacionesInmueble']['user_id']            = $this->request->data['ProcesoInmuebles']['user_id'];
            $this->request->data['OperacionesInmueble']['vigencia_operacion'] = date('Y-m-d', strtotime($this->request->data['ProcesoInmuebles']['vigencia_reserva']));
            $this->request->data['OperacionesInmueble']['cotizacion_id']      = $this->request->data['ProcesoInmuebles']['cotizacion_id'];
            $this->request->data['OperacionesInmueble']['inmueble_id']        = $inmueble_id;
            $this->request->data['OperacionesInmueble']['status']             = 'Activo';
            $this->OperacionesInmueble->save($this->request->data);
            $operacion_id = $this->OperacionesInmueble->getInsertID();
            
            $this->OperacionesInmueble->query("UPDATE inmuebles SET liberada = ".$this->request->data['ProcesoInmuebles']['tipo_operacion']." WHERE id = ".$inmueble_id);
    
            // Hacer el cambio de la etapa en automati a etapa 6 del cliente.
            // $query = $this->OperacionesInmueble->query("update clientes SET clientes.etapa = 6 WHERE clientes.id = ".$this->request->data['ProcesoInmuebles']['cliente_id'].";");
            
            $cliente_id_etapa= $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->request->data['Cliente']['id']                 =$cliente_id_etapa;
            $this->request->data['Cliente']['last_edit']          = date('Y-m-d H:i:s');
            $this->request->data['Cliente']['etapa']              = 6;
            // $this->request->data['Cliente']['inmueble_id']        = $inmueble_id;
            //rogueEtapaFecha
            $this->request->data['Cliente']['fecha_cambio_etapa'] = date('Y-m-d');
            $this->Cliente->save($this->request->data);
            
            // Cambio de etapa.
            $etapas_cliente = $this->LogClientesEtapa->find('all', array(
                'conditions' => array(
                    'LogClientesEtapa.cliente_id' => $this->request->data['ProcesoInmuebles']['cliente_id'],
                    'LogClientesEtapa.status'     => 'Activo'
                )
            ));
    
            // Todas las etapas del cliente que hay pasan a ser inactivas.
            foreach( $etapas_cliente as $etapa_cliente ){
                $this->request->data['LogClientesEtapa']['id']        = $etapa_cliente['LogClientesEtapa']['id'];
                $this->request->data['LogClientesEtapa']['status']       = 'Inactivo';
                $this->LogClientesEtapa->save($this->request->data);
            }
    
            // Creamos el registro de la nueva etapa.
            $this->LogClientesEtapa->create();
            $this->request->data['LogClientesEtapa']['id']            = null;
            $this->request->data['LogClientesEtapa']['cliente_id']    = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d', strtotime($this->request->data['ProcesoInmuebles']['fecha_reserva']));
            $this->request->data['LogClientesEtapa']['etapa']         = 6;
            $this->request->data['LogClientesEtapa']['desarrollo_id'] = $search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
            // $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
            $this->request->data['LogClientesEtapa']['inmuble_id']    = $inmueble_id;
            $this->request->data['LogClientesEtapa']['status']        = 'Activo';
            $this->request->data['LogClientesEtapa']['user_id']       = $this->Session->read('Auth.User.id');
            $this->LogClientesEtapa->save($this->request->data);
    
    
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         = uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
            $this->LogCliente->save($this->request->data);
    
            $this->request->data['Agenda']['user_id']        = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje']        = 'El cliente cambia automáticamente a etapa 6 por: "Registrar un apartado" de la unidad '.$inmueble['Inmueble']['referencia'].' el '.date('d-m-Y H:i:s');
            $this->request->data['Agenda']['cliente_id']     = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->Agenda->save($this->request->data);
    
            
            $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
            $this->request->data['LogInmueble']['mensaje']     = "Se aparta el inmuebele";
            $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
            $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmuebles']['fecha_reserva']));
            $this->request->data['LogInmueble']['accion']      = 2;
            $this->request->data['LogInmueble']['status']      = $this->request->data['ProcesoInmuebles']['tipo_operacion'];
            $this->LogInmueble->create();
            $this->LogInmueble->save($this->request->data);
            
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmuebles']['fecha_reserva']));
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['mensaje']    = "Cliente ".$cliente['Cliente']['nombre']." realiza apartado de ".$inmueble['Inmueble']['referencia']." el ".date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmuebles']['fecha_reserva']));
            $this->LogCliente->save($this->request->data);
            
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']   = $timestamp;
            $this->request->data['Agenda']['mensaje'] = "Cliente ".$cliente['Cliente']['nombre']." realiza apartado de ".$inmueble['Inmueble']['referencia']." el ".$timestamp;
            $this->request->data['Agenda']['cliente_id']=$this->request->data['ProcesoInmuebles']['cliente_id'];
            $cliente_id = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->Agenda->save($this->request->data);
    
            // Se cambian las variables segun el documento
            if( !empty($this->request->data['ProcesoInmuebles']['archivos_reserva']) ){
                foreach( $this->request->data['ProcesoInmuebles']['archivos_reserva'] as $file){
                                    $archivo           = $file[key($file)];
                    $dataDocsCliente['documento']      = '';
                    $dataDocsCliente['tipo_documento'] = key($file);
                    $dataDocsCliente['comentarios']    = "Documento de soporte para el apartado del inmueble";
                    $dataDocsCliente['operacion_id']   = $operacion_id;
                    $this->carga_archivo( $archivo, $dataDocsCliente );
                
                }
            }
    
            // Vamos a actualizar el precio y el estatus
            $this->updateDataInmueblesMappen($this->request->data['ProcesoInmuebles']['precio_unidad'], $this->request->data['ProcesoInmuebles']['tipo_operacion'], $inmueble_id);

            // $new_precio ,$property_status ,$idInmueble
    
    
            $save = array(
                'mensaje' => 'Se ha guardado correctamente el apartado de la propiedad.',
                'bandera' => false
            );
    
        }
        
        echo json_encode($save);
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash( $save['mensaje'] , 'default', array(), 'm_success');
    
        exit();        
        $this->autoRender = false;
    }
    
    public function add_venta(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $save    = [];
        
        if ($this->request->is('post')){
            
            $mensaje     = '';
            $inmueble_id = $this->request->data['ProcesoInmueblesVenta']['inmueble_id'];
            $inmueble    = $this->Inmueble->find('first',array('conditions'=>array('Inmueble.id'=>$inmueble_id)));
            $cliente     = $this->Cliente->read(null,$this->request->data['ProcesoInmueblesVenta']['cliente_id']);
            $timestamp   = date('Y-m-d H:i:s');
            $search_desarrollo_id=$this->DesarrolloInmueble->find('first',array(
                'conditions'=>array(
                    'DesarrolloInmueble.inmueble_id'=>$inmueble_id
                ),
                'fields' => array(
                    'DesarrolloInmueble.desarrollo_id'
                ),
                'contain' => false 
                )
            );
            // Alta de archivos.
            $dataDocsCliente = array(
                'cuenta_id'      => $this->cuenta_id,
                'documento'      => '',
                'tipo_documento' => '',
                'comentarios'    => '',
                'user_id'        => $this->Session->read('Auth.User.id'),
                'inmueble_id'    => $inmueble_id,
                'cliente_id'     => $cliente['Cliente']['id']
            );
    
            $this->request->data['OperacionesInmueble']['tipo_operacion']     = $this->request->data['ProcesoInmueblesVenta']['tipo_operacion'];
            $this->request->data['OperacionesInmueble']['precio_unidad']      = $this->request->data['ProcesoInmueblesVenta']['precio_unidad'];
            $this->request->data['OperacionesInmueble']['precio_cierre']      = $this->request->data['ProcesoInmueblesVenta']['monto_venta'];
            $this->request->data['OperacionesInmueble']['fecha']              = date('Y-m-d', strtotime($this->request->data['ProcesoInmueblesVenta']['fecha_venta']));
            $this->request->data['OperacionesInmueble']['cliente_id']         = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->request->data['OperacionesInmueble']['user_id']            = $this->request->data['ProcesoInmueblesVenta']['user_id'];
            $this->request->data['OperacionesInmueble']['vigencia_operacion'] = date('Y-m-d', strtotime($this->request->data['ProcesoInmueblesVenta']['vigencia_venta']));
            $this->request->data['OperacionesInmueble']['inmueble_id']        = $inmueble_id;
            $this->request->data['OperacionesInmueble']['status']             = 'Activo';
            $this->request->data['OperacionesInmueble']['cotizacion_id']      = $this->request->data['ProcesoInmueblesVenta']['cotizacion_id'];
            $this->OperacionesInmueble->save($this->request->data);
            $operacion_id = $this->OperacionesInmueble->getInsertID();
    
            // Guardamos en la tabla de ventas, cuando nos centremos en las graficas devemos de cambiar los datos para la tabla de operacionesInmueble
            $this->request->data['Venta']['fecha']          = date('Y-m-d', strtotime($this->request->data['ProcesoInmueblesVenta']['fecha_venta']));
            $this->request->data['Venta']['user_id']        = $this->request->data['ProcesoInmueblesVenta']['user_id'];
            $this->request->data['Venta']['inmueble_id']    = $inmueble_id;
            $this->request->data['Venta']['precio_cerrado'] = $this->request->data['ProcesoInmueblesVenta']['precio_unidad'];
            $this->request->data['Venta']['tipo_operacion'] = 'Venta';
            $this->request->data['Venta']['cliente_id']     = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->request->data['Venta']['cuenta_id']      = $this->cuenta_id;
            $this->Venta->save($this->request->data);
            
            // Para la venta se debe actualizar el campo de precio
            $this->OperacionesInmueble->query("UPDATE inmuebles SET liberada = ".$this->request->data['ProcesoInmueblesVenta']['tipo_operacion']." WHERE id = ".$inmueble_id);
            
            $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
            $this->request->data['LogInmueble']['mensaje']     = "Se vende el inmuebele";
            $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
            $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmueblesVenta']['fecha_venta']));
            $this->request->data['LogInmueble']['accion']      = 2;
            $this->request->data['LogInmueble']['status']      = $this->request->data['ProcesoInmueblesVenta']['tipo_operacion'];
            $this->LogInmueble->create();
            $this->LogInmueble->save($this->request->data);
            
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmueblesVenta']['fecha_venta']));
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['mensaje']    = "Cliente ".$cliente['Cliente']['nombre']." realiza compra de ".$inmueble['Inmueble']['referencia']." el ".date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmueblesVenta']['fecha_venta']));
            $this->LogCliente->save($this->request->data);
            
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']   = $timestamp;
            $this->request->data['Agenda']['mensaje'] = "Cliente ".$cliente['Cliente']['nombre']." realiza compra de ".$inmueble['Inmueble']['referencia']." el ".$timestamp;
            $this->request->data['Agenda']['cliente_id']=$this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $cliente_id = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->Agenda->save($this->request->data);
    
            // Hacer el cambio de la etapa en automati a etapa 6 del cliente.
            // $query = $this->OperacionesInmueble->query("update clientes SET clientes.etapa = 7 WHERE clientes.id = ".$this->request->data['ProcesoInmueblesVenta']['cliente_id'].";");

            $cliente_id_etapa= $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->request->data['Cliente']['id']                 =$cliente_id_etapa;
            $this->request->data['Cliente']['last_edit']          = date('Y-m-d H:i:s');
            $this->request->data['Cliente']['etapa']              = 7;
            // $this->request->data['Cliente']['inmueble_id']        = $inmueble_id;
            //rogueEtapaFecha
            $this->request->data['Cliente']['fecha_cambio_etapa'] = date('Y-m-d');
            $this->Cliente->save($this->request->data);
            
            $this->updateDataInmueblesMappen($this->request->data['ProcesoInmueblesVenta']['precio_unidad'], $this->request->data['ProcesoInmueblesVenta']['tipo_operacion'], $inmueble_id);
    
            // Cambio de etapa.
            $etapas_cliente = $this->LogClientesEtapa->find('all', array(
                'conditions' => array(
                    'LogClientesEtapa.cliente_id' => $this->request->data['ProcesoInmueblesVenta']['cliente_id'],
                    'LogClientesEtapa.status'     => 'Activo'
                )
            ));
    
            // Todas las etapas del cliente que hay pasan a ser inactivas.
            foreach( $etapas_cliente as $etapa_cliente ){
                $this->request->data['LogClientesEtapa']['id']        = $etapa_cliente['LogClientesEtapa']['id'];
                $this->request->data['LogClientesEtapa']['status']       = 'Inactivo';
                $this->LogClientesEtapa->save($this->request->data);
            }
    
            // Creamos el registro de la nueva etapa. 
            $this->LogClientesEtapa->create();
            $this->request->data['LogClientesEtapa']['id']            = null;
            $this->request->data['LogClientesEtapa']['cliente_id']    = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d', strtotime($this->request->data['ProcesoInmueblesVenta']['fecha_venta']));
            $this->request->data['LogClientesEtapa']['etapa']         = 7;
            $this->request->data['LogClientesEtapa']['desarrollo_id'] = $search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
            // $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
            $this->request->data['LogClientesEtapa']['inmuble_id']    = $inmueble_id;
            $this->request->data['LogClientesEtapa']['status']        = 'Activo';
            $this->request->data['LogClientesEtapa']['user_id']       = $this->Session->read('Auth.User.id');
            $this->LogClientesEtapa->save($this->request->data);
    
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         = uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
            $this->LogCliente->save($this->request->data);
    
            $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje'] = 'El cliente cambia automáticamente a etapa  por: Registrar una venta de la unidad '.$inmueble['Inmueble']['referencia'].' el '.date('d-m-Y H:i:s');
            $this->request->data['Agenda']['cliente_id'] = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->Agenda->save($this->request->data);
    
            // Agregamos el precio con el que compro, guardado el precio de listado de la propiedad
    
    
    
            if( !empty($this->request->data['ProcesoInmueblesVenta']['archivos_venta']) ){
                foreach( $this->request->data['ProcesoInmueblesVenta']['archivos_venta'] as $file){
                                    $archivo           = $file[key($file)];
                    $dataDocsCliente['documento']      = '';
                    $dataDocsCliente['tipo_documento'] = key($file);
                    $dataDocsCliente['comentarios']    = "Documento de soporte para la venta del inmueble";
                    $dataDocsCliente['operacion_id']   = $operacion_id;
                    $this->carga_archivo( $archivo, $dataDocsCliente );
                
                }
    
            }
            
            $save = array(
                'mensaje' => 'Se ha guardado correctamente la operación.',
                'bandera' => false
            );
    
        }
        
        echo json_encode($save);
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash( $save['mensaje'] , 'default', array(), 'm_success');
    
        exit();        
        $this->autoRender = false;
    }

    public function add_escrituracion(){
        header('Content-type: application/json; charset=utf-8');
        $save    = [];
        
        if ($this->request->is('post')){
            
            $mensaje     = '';
            $inmueble_id = $this->request->data['ProcesoInmueblesEscrituracion']['inmueble_id'];
            $inmueble    = $this->Inmueble->find('first',array('conditions'=>array('Inmueble.id'=>$inmueble_id)));
            $cliente     = $this->Cliente->read(null,$this->request->data['ProcesoInmueblesEscrituracion']['cliente_id']);
            $timestamp   = date('Y-m-d H:i:s');
    
            // Alta de archivos.
            $dataDocsCliente = array(
                'cuenta_id'      => $this->cuenta_id,
                'documento'      => '',
                'tipo_documento' => '',
                'comentarios'    => '',
                'user_id'        => $this->Session->read('Auth.User.id'),
                'inmueble_id'    => $inmueble_id,
                'cliente_id'     => $cliente['Cliente']['id']
            );
    
            $this->request->data['OperacionesInmueble']['tipo_operacion']     = $this->request->data['ProcesoInmueblesEscrituracion']['tipo_operacion'];
            $this->request->data['OperacionesInmueble']['precio_unidad']      = $this->request->data['ProcesoInmueblesEscrituracion']['precio_unidad'];
            $this->request->data['OperacionesInmueble']['precio_cierre']      = $this->request->data['ProcesoInmueblesEscrituracion']['monto_escrituracion'];
            $this->request->data['OperacionesInmueble']['fecha']              = date('Y-m-d', strtotime($this->request->data['ProcesoInmueblesEscrituracion']['fecha_escrituracion']));
            $this->request->data['OperacionesInmueble']['cliente_id']         = $this->request->data['ProcesoInmueblesEscrituracion']['cliente_id'];
            $this->request->data['OperacionesInmueble']['user_id']            = $this->request->data['ProcesoInmueblesEscrituracion']['user_id'];
            $this->request->data['OperacionesInmueble']['inmueble_id']        = $inmueble_id;
            $this->request->data['OperacionesInmueble']['status']             = 'Activo';
            $this->OperacionesInmueble->save($this->request->data);
            $operacion_id = $this->OperacionesInmueble->getInsertID();
            
            $this->OperacionesInmueble->query("UPDATE inmuebles SET liberada = ".$this->request->data['ProcesoInmueblesEscrituracion']['tipo_operacion']." WHERE id = ".$inmueble_id);
            
            $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
            $this->request->data['LogInmueble']['mensaje']     = "Se escritura el inmuebele";
            $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
            $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmueblesEscrituracion']['fecha_escrituracion']));
            $this->request->data['LogInmueble']['accion']      = 2;
            $this->request->data['LogInmueble']['status']      = $this->request->data['ProcesoInmueblesEscrituracion']['tipo_operacion'];
            $this->LogInmueble->create();
            $this->LogInmueble->save($this->request->data);
            
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['ProcesoInmueblesEscrituracion']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmueblesEscrituracion']['fecha_escrituracion']));
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['mensaje']    = "Cliente ".$cliente['Cliente']['nombre']." realiza compra de ".$inmueble['Inmueble']['referencia']." el ".date('Y-m-d H:i:s', strtotime($this->request->data['ProcesoInmueblesEscrituracion']['fecha_escrituracion']));
            $this->LogCliente->save($this->request->data);
            
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']   = $timestamp;
            $this->request->data['Agenda']['mensaje'] = "Cliente ".$cliente['Cliente']['nombre']." realiza escrituración de ".$inmueble['Inmueble']['referencia']." el ".$timestamp;
            $this->request->data['Agenda']['cliente_id']=$this->request->data['ProcesoInmueblesEscrituracion']['cliente_id'];
    
            $cliente_id = $this->request->data['ProcesoInmueblesEscrituracion']['cliente_id'];
            $this->Agenda->save($this->request->data);

            if( !empty($this->request->data['ProcesoInmueblesEscrituracion']['archivos_escrituracion']) ){
                foreach( $this->request->data['ProcesoInmueblesEscrituracion']['archivos_escrituracion'] as $file){
                                    $archivo           = $file[key($file)];
                    $dataDocsCliente['documento']      = '';
                    $dataDocsCliente['tipo_documento'] = key($file);
                    $dataDocsCliente['comentarios']    = "Documento de soporte para la escrituración del inmueble";
                    $dataDocsCliente['operacion_id']   = $operacion_id;
                    $this->carga_archivo( $archivo, $dataDocsCliente );
                
                }

            }
    
            $save = array(
                'mensaje' => 'Se ha guardado correctamente la operación.',
                'bandera' => false
            );
    
        }
        
        echo json_encode($save);
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash( $save['mensaje'] , 'default', array(), 'm_success');
    
        exit();        
        $this->autoRender = false;
    }

    function carga_archivo( $archivo, $data ){

        $bandera = true;
        $mensaje = '';
        /** ---------------------------------- Hola ------------------------------------
         * 
         * Comprobacion de que una carpeta existe para el almacenamiento de los archivos de los clientes.
         * Este proceso es nuevo, por eso se crea desde aqui.
         * SaaK - Alejandro Hernandez 01-02-2022
         * 
         */
        $path = getcwd()."/files/cuentas/".$data['cuenta_id']."/clientes/";
        if (!is_dir($path)) {
            mkdir(getcwd()."/files/cuentas/".$data['cuenta_id']."/clientes/",0777);
        }

        if (isset($archivo) && $archivo['name']!=""){
                
            $unitario = $archivo;
            $filename = getcwd()."/files/cuentas/".$data['cuenta_id']."/clientes/".$unitario['name'];
            move_uploaded_file($unitario['tmp_name'],$filename);
            $ruta = "/files/cuentas/".$data['cuenta_id']."/clientes/".$unitario['name'];
            
            $this->DocsCliente->create();
            $this->request->data['DocsCliente']['documento']      = $data['documento'];
            $this->request->data['DocsCliente']['ruta']           = $ruta;
            $this->request->data['DocsCliente']['tipo_documento'] = $data['tipo_documento'];
            $this->request->data['DocsCliente']['comentarios']    = $data['comentarios'];
            $this->request->data['DocsCliente']['user_id']        = $data['user_id'];
            $this->request->data['DocsCliente']['inmueble_id']    = $data['inmueble_id'];
            $this->request->data['DocsCliente']['cliente_id']     = $data['cliente_id'];
            $this->request->data['DocsCliente']['operacion_id']   = $data['operacion_id'];
            
            if( $this->DocsCliente->save($this->request->data) ){
                $mensaje = 'Se guardo correctamente el documento.';
            }else{
                $bandera = false;
                $mensaje = 'Ocurrio un problema al guardar el documento.';
            }

        }

        $save = array(
            'bandera' => $bandera,
            'mensaje' => $mensaje
        );

        
        $this->autoRender = false;
        return $save;

    }

    /* ----------------- Listado de las operaciones por cliente ----------------- */
    public function list_user( $cliente_id = null ){
        $this->OperacionesInmueble->Behaviors->load('Containable');
        header('Content-type: application/json; charset=utf-8');
        $i                  = 0;
        $response['data']   = [];
        $documentos         = '';

        $operaciones_cliente = $this->OperacionesInmueble->find('all',
            array(
                'conditions' => array( 'cliente_id' => $cliente_id ),
                'contain'    => array(
                    'User' => array(
                        'fields' => array(
                            'User.nombre_completo'
                        ),
                    ),
                    'Inmueble' => array(
                        'fields' => array(
                            'Inmueble.referencia'
                        ),
                    ),
                    'Documentos' => array(
                        'fields' => array(
                            'Documentos.ruta',
                            'Documentos.comentarios',
                            'Documentos.tipo_documento',
                        ),
                    ),
                ),
                'fields'     => array(
                    'OperacionesInmueble.id',
                    'OperacionesInmueble.tipo_operacion',
                    'OperacionesInmueble.precio_unidad',
                    'OperacionesInmueble.precio_cierre',
                    'OperacionesInmueble.fecha',
                    'OperacionesInmueble.vigencia_operacion',
                    'OperacionesInmueble.inmueble_id',
                ),
                'order' => array(
                    'OperacionesInmueble.inmueble_id' => 'ASC'
                ),
            )
        );
        
        foreach( $operaciones_cliente as $operacion ){
                        
        }

        // echo json_encode( $response );
        // exit();
        echo "<pre>";
        print_r ( $response );
        echo "</pre>";
        $this->autoRender = false;

    }

    /* ----------- Metodo para eliminar una operacion de una propiedad ---------- */
    /**
     * Alejandro Hernande. AKA SAAK.
     */
    public function delete(){
        $this->Inmueble->Behaviors->load('Containable');
        header('Content-type: application/json; charset=utf-8');
        $save    = [];

        if ($this->request->is('post')){
            
            // Tipo de proceso
            $cliente_id   = $this->request->data['DeleteOperacionesInmueble']['clienteId'];
            $user_id      = $this->Session->read('Auth.User.id');
            $current_date = date('d-m-Y');
            
            // Cambiar el estatus de la operacion del inmueble
            $inmueble    = $this->Inmueble->find('first',
                array(
                    'conditions' => array( 'Inmueble.id' => $this->request->data['DeleteOperacionesInmueble']['inmueble_id'] ),
                    'fields'     => array( 'id', 'titulo', 'liberada' ),
                    'contain'    => false
                )
            );

            $mensaje = "Se ha eliminado la operacion ".$this->status_inmueble[ $inmueble['Inmueble']['liberada'] ]." de la propiedad ".$inmueble['Inmueble']['titulo']." por el asesor ".$this->Session->read('Auth.User.nombre_completo') ;

            // 1.- Actualizar el valor de liberada.
            $this->request->data['Inmueble']['id']       = $this->request->data['DeleteOperacionesInmueble']['inmueble_id'];
            $this->request->data['Inmueble']['liberada'] = $inmueble['Inmueble']['liberada'] - 1;
            $this->Inmueble->save($this->request->data);


            // 2.- Agregar el log de inmuebles
            
            // 3.- Agregar al log de clientes.
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id']        = $user_id;
            $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje']        = $mensaje;
            $this->request->data['Agenda']['cliente_id']     = $cliente_id;
            $this->Agenda->save($this->request->data);

            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
            $this->request->data['LogCliente']['user_id']    = $user_id;
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['mensaje']    = $mensaje;
            $this->LogCliente->save($this->request->data);

            // 4.- Eliminar el registro de la operacion.
            $this->request->onlyAllow('post', 'delete');
            $this->OperacionesInmueble->id = $this->request->data['DeleteOperacionesInmueble']['operacionId'];
            $this->OperacionesInmueble->delete();

            $save = array(
                'data'     => $this->request->data,
                'inmueble' => $inmueble
            );

    
        }
        
        echo json_encode($save);
        // $this->Session->setFlash('', 'default', array(), 'success');
        // $this->Session->setFlash( $save['mensaje'] , 'default', array(), 'm_success');

        exit();        
        $this->autoRender = false;
    }

    /* ----------- Metodo para guardar la cancelacion de la operacion ---------- */
    /**
     * 
     *  AKA ROGUEONE.
     * 1.- Se agrega vinculación con la plataforma de mappen - AKA SaaK 12 Sep 2022
     * 2.- Se hace modificacion: Si cancela Escrituracion o venta, se cancelan todas
     * las operaciones anteriores. - AKA SaaK 03 Oct 2022
     * 
     * Operaciones: 
     * 1.- Desactivar la operacion del inmueble.
     *  Si hay un apartado, se cancela el apartado.
     *  Si hay una venta, se cancela la venta y el apartado.
     * 2.- Se debe cambiar la etapa del cliente a etapa 5, clientes y logEtapasClientes.
     * 3.- Se guarda el motivo de cancelación de la etapa.
     * 4.- Se guarda el seguimiento del cliente.
     */
     /* -------------------------------- Apartado -------------------------------- */
    // OperacionesInmueble
    // LogClientesEtapa
    // LogCliente
    // Agenda
    // LogInmueble

    /* ---------------------------------- Venta --------------------------------- */
    // OperacionesInmueble
    // LogClientesEtapa
    // LogCliente
    // Agenda
    // LogInmueble
    // Venta

    function cancelacion(){
        $this->OperacionesInmueble->Behaviors->load('Containable');

        $response = [];

        if($this->request->is('post')){

            $operacion = $this->OperacionesInmueble->find('first', array(
                'conditions' => array(
                    'OperacionesInmueble.id' => $this->request->data['operacion_id']
                ),
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'id',
                            'nombre_completo'
                        )
                    ),
                    'Inmueble' => array(
                        'fields' => array(
                            'id',
                            'referencia',
                            'liberada',
                        )
                    ),
                    'Cliente' => array(
                        'fields' => array(
                            'id',
                            'nombre'
                        )
                    ),
                )
            ));
            $cliente              = $operacion['Cliente'];
            $user                 = $operacion['User'];
            $inmueble             = $operacion['Inmueble'];
            $search_desarrollo_id = $this->DesarrolloInmueble->find('first',array(
                'conditions'=>array(
                    'DesarrolloInmueble.inmueble_id' => $inmueble['id']
                ),
                'fields' => array(
                    'DesarrolloInmueble.desarrollo_id'
                ),
                'contain' => false
                )
            );
            $flag                 = false;
            $cantidad_operaciones = 'operacion';

            /* ------------------------ Cancelacion de operacion ------------------------ */
            // Si es venta, se cancela el apartado tambien.
            if( $operacion['OperacionesInmueble']['tipo_operacion'] == 3 OR $operacion['OperacionesInmueble']['tipo_operacion'] == 4 ){
                $cantidad_operaciones = 'operaciones';
                $operaciones = $this->OperacionesInmueble->find('all', array(
                    'conditions' => array(
                        'OperacionesInmueble.inmueble_id' => $operacion['OperacionesInmueble']['inmueble_id']
                    ),
                    'contain' => false
                ));

                foreach( $operaciones as $operacion ){
                    
                    $this->request->data['OperacionesInmueble']['id']                 = $operacion['OperacionesInmueble']['id'];
                    $this->request->data['OperacionesInmueble']['dic_cancelacion_id'] = $this->request->data['dic_cancelacion_id'];
                    $this->request->data['OperacionesInmueble']['status']             = 'Inactivo';
                    if($this->OperacionesInmueble->save($this->request->data['OperacionesInmueble'])){
                        $flag = true;
                    }else{
                        $flag = false;
                    }

                }

            }else{
                
                $this->request->data['OperacionesInmueble']['id']                 = $operacion['OperacionesInmueble']['id'];
                $this->request->data['OperacionesInmueble']['dic_cancelacion_id'] = $this->request->data['dic_cancelacion_id'];
                $this->request->data['OperacionesInmueble']['status']             = 'Inactivo';
                if($this->OperacionesInmueble->save($this->request->data['OperacionesInmueble'])){
                    $flag = true;
                }

            }


            if( $flag == true ){
                
                $response['message'] = 'Se ha cancelado correctamente la operación';

                /* ---------- Agregamos el log del cliente y cambiamos de etapa a 5 --------- */
                $this->LogClientesEtapa->create();
                $this->request->data['LogClientesEtapa']['id']            = null;
                $this->request->data['LogClientesEtapa']['cliente_id']    = $cliente['id'];
                $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d');
                $this->request->data['LogClientesEtapa']['etapa']         = 5;
                $this->request->data['LogClientesEtapa']['desarrollo_id'] = $search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
                $this->request->data['LogClientesEtapa']['inmuble_id']    = $inmueble['id'];
                $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                $this->request->data['LogClientesEtapa']['user_id']       = $user['id'];
                $this->LogClientesEtapa->save($this->request->data['LogClientesEtapa']);

                /* ------- Actualización del cliente etapa y fecha de cambio de etapa. ------ */
                $this->request->data['Cliente']['id']                 = $cliente['id'];
                $this->request->data['Cliente']['etapa']              = 5;
                $this->request->data['Cliente']['fecha_cambio_etapa'] = date('Y-m-d');
                $this->request->data['Cliente']['last_edit']          = date('Y-m-d H:i:s');
                $this->Cliente->save($this->request->data['Cliente']);

                /* --- Agregamos en el log del cliente el cambio de etapa y la cancelación -- */
                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']         =  uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $cliente['id'];
                $this->request->data['LogCliente']['user_id']    = $user['id'];
                $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
                $this->request->data['LogCliente']['accion']     = 2;
                $this->request->data['LogCliente']['mensaje']    = "Se ha cancelado la ".$cantidad_operaciones." del inmueble ".$inmueble['referencia'].", se cambio automaticamente a la etapa 5 y la propiedad pasa a ser bloqueada. ";
                $this->LogCliente->save($this->request->data['LogCliente']);

                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']        = $user['id'];
                $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']        = "Se ha cancelado la ".$cantidad_operaciones." del inmueble ".$inmueble['referencia'].", se cambio automaticamente a la etapa 5 y la propiedad pasa a ser bloqueada. ";
                $this->request->data['Agenda']['cliente_id']     = $cliente['id'];
                $this->Agenda->save($this->request->data);

                $this->request->data['LogInmueble']['inmueble_id'] = $inmueble['id'];
                $this->request->data['LogInmueble']['mensaje']     = "Se cancela la ".$cantidad_operaciones." del inmueble";
                $this->request->data['LogInmueble']['usuario_id']  = $user['id'];
                $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
                $this->request->data['LogInmueble']['accion']      = 2;
                $this->request->data['LogInmueble']['status']      = 0;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);

                // 1.- Actualizar el valor de liberada.
                $this->request->data['Inmueble']['id']       = $inmueble['id'];
                $this->request->data['Inmueble']['liberada'] = 0;
                $this->Inmueble->save($this->request->data);






            }






            // Vamos a sacar el id, nombre del cliente.
            // Vamos a sacar el id, referencia de la propiedad.
            // Vamos a sacar la venta de la propiedad.
            
            $response['data']      = $operacion;


        }
    
        echo json_encode( $response );
        exit();

        $this->autoRender = false;

    }


    /**
     * 
     * 
     * 
    */
    function motivo_cancelacion_apartado(){

        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Diccionario'); 
        $this->loadModel('DesarrolloInmueble'); 
        $this->DesarrolloInmueble->Behaviors->load('Containable'); 
        $this->Diccionario->Behaviors->load('Containable'); 
        // $this->Desarrollo->Behaviors->load('Containable'); 
        $response                      = [];
        $cancelaciones=array();
        $fecha_ini                     = '';
        $fecha_fin                     = '';
        $i                             = 0;
        $id_inmueble='';
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');

        if($this->request->is('post')){

            $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin)); 
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            $cancelaciones=$this->OperacionesInmueble->query(
                "SELECT COUNT(*)AS cancelados,dic_cancelacion_id
                FROM operaciones_inmuebles 
                WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
                AND operaciones_inmuebles.fecha >='$fi' 
                AND operaciones_inmuebles.fecha <='$ff'
                AND tipo_operacion=2
                AND dic_cancelacion_id <> ''
                GROUP BY dic_cancelacion_id;"
            );
            $dic_cancelacion=$this->Diccionario->find('all',
                array(
                    'conditions'=>array(     
                        'Diccionario.cuenta_id' => $cuenta_id,
                        'Diccionario.sub_directorio LIKE' =>  "%dic_aparrtado%",
    
                    ),
                    'fields' => array(
                        'Diccionario.id',
                        'Diccionario.descripcion',
                    ),
                    'contain' => false 
                )
            );
            foreach ($dic_cancelacion as $dic_can) {
                foreach ($cancelaciones as $cancelacion) {
                    if ($dic_can['Diccionario']['id'] == $cancelacion['operaciones_inmuebles']['dic_cancelacion_id']) {
                        $motivo_row[$i]['motivo']=$dic_can['Diccionario']['descripcion'];
                        $motivo_row[$i]['cantidad']=$cancelacion[0]['cancelados'];
                    }
                }
                $i++;
            }
            $i=0;
            foreach ($motivo_row as $value) {
            // ( empty($value['cantidad'] ) ? 0  :  $value['cantidad'] )
                $response[$i]['motivo']=( empty($value['motivo'] ) ? 0  :  $value['motivo'] );
                $response[$i]['cantidad']=( empty($value['cantidad'] ) ? 0  :  $value['cantidad'] );
                $i++;
            }
        }
        
        if (empty($response)) {
            $response[$i]['motivo']='sin cacelacion';
            $response[$i]['cantidad']=0;
        }

        echo json_encode( $response , true );
        exit();
        $this->autoRender = false;

    }
    /**
     * 
     * 
     * 
    */
    function ventas_apartados_cancelaciones(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Diccionario'); 
        $this->loadModel('DesarrolloInmueble'); 
        $this->loadModel('Desarrollo'); 
        $this->DesarrolloInmueble->Behaviors->load('Containable'); 
        $this->Diccionario->Behaviors->load('Containable'); 
        $this->Desarrollo->Behaviors->load('Containable'); 
        $response                      = [];
        $id_propiedades                      = [];
        $cancelaciones=array();
        $fecha_ini                     = '';
        $fecha_fin                     = '';
        $i                             = 0;
        $id_inmueble='';
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if($this->request->is('post')){
            $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin)); 
                $vigente=date('Y-m-d H:i:s');
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
                $ventas= $this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS ven , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND tipo_operacion=3
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                $apartados=$this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS apartados , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
                    -- AND operaciones_inmuebles.vigencia_operacion >='$vigente' 
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND dic_cancelacion_id Is NULL
                    AND tipo_operacion=2
                    -- AND dic_cancelacion_id > ''
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                $cancelacion=$this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS cancelados , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND tipo_operacion=2
                    AND dic_cancelacion_id <> ''
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                // $apartados_vigentes=$this->OperacionesInmueble->query(
                //     "SELECT COUNT(*)AS apartados , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                //     FROM operaciones_inmuebles 
                //     WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
                //     AND operaciones_inmuebles.vigencia_operacion >='$vigente' 
                //     AND dic_cancelacion_id IS NULL
                //     AND tipo_operacion=2
                //     GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                // );

            }
            if( !empty( $this->request->data['user_id'] ) ){
                $user_id= $this->request->data['user_id'];
                $ventas= $this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS ven , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.user_id =$user_id
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND tipo_operacion=3
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                $apartados=$this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS apartados , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.user_id =$user_id
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND dic_cancelacion_id IS NULL
                    AND tipo_operacion=2
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                $cancelacion=$this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS cancelados , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.user_id =$user_id
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND tipo_operacion=2
                    AND dic_cancelacion_id <> ''
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                $apartados_vigentes=$this->OperacionesInmueble->query(
                    "SELECT COUNT(*)AS apartados , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.user_id =$user_id
                    AND operaciones_inmuebles.vigencia_operacion >='$vigente' 
                    AND dic_cancelacion_id IS NULL
                    AND tipo_operacion=2
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
                
            }
           
            $periodos = $this->getPeriodosArreglo($fi,$ff);
            foreach ($periodos as $key=> $periodo) {
                foreach ($ventas as $venta) {
                    if ($venta[0]['fecha']==$key) {
                        $ventas_cancelacion_vijentes[$i]['periodo']=$periodo;
                        $ventas_cancelacion_vijentes[$i]['ventas']=$venta[0]['ven'];
                        $ventas_cancelacion_vijentes[$i]['apartado']=0;
                        $ventas_cancelacion_vijentes[$i]['cancelaciones']=0;
                    }
                }
                foreach ($apartados as $apartado) {
                    if ($apartado[0]['fecha']==$key) {
                        $ventas_cancelacion_vijentes[$i]['periodo']=$periodo;
                        if ($ventas_cancelacion_vijentes[$i]['ventas']==0) {
                            $ventas_cancelacion_vijentes[$i]['ventas']=0;
                        }
                        if ($ventas_cancelacion_vijentes[$i]['cancelaciones']==0) {
                            $ventas_cancelacion_vijentes[$i]['cancelaciones']=0;
                        }
                        $ventas_cancelacion_vijentes[$i]['apartado']=$apartado[0]['apartados'];
    
                    }
                }
                foreach ($cancelacion as $can) {
                    if ($can[0]['fecha']==$key) {
                        $ventas_cancelacion_vijentes[$i]['periodo']=$periodo;
                        if ($ventas_cancelacion_vijentes[$i]['ventas']==0) {
                            $ventas_cancelacion_vijentes[$i]['ventas']=0;
                        }
                        if ($ventas_cancelacion_vijentes[$i]['apartado']==0) {
                            $ventas_cancelacion_vijentes[$i]['apartado']=0;
                        }
                        $ventas_cancelacion_vijentes[$i]['cancelaciones']=$can[0]['cancelados'];
                    }
                }
                // foreach ($apartados_vigentes as $vigentes) {
                //     if ($vigentes[0]['fecha']==$key) {
                //         $ventas_cancelacion_vijentes[$i]['periodo']=$periodo;
                //         if ($ventas_cancelacion_vijentes[$i]['ventas']==0) {
                //             $ventas_cancelacion_vijentes[$i]['ventas']=0;
                //         }
                //         if ($ventas_cancelacion_vijentes[$i]['apartado']==0) {
                //             $ventas_cancelacion_vijentes[$i]['apartado']=0;
                //         }
                //         if ($ventas_cancelacion_vijentes[$i]['cancelaciones']==0) {
                //             $ventas_cancelacion_vijentes[$i]['cancelaciones']=0;
                //         }
                //         $ventas_cancelacion_vijentes[$i]['apartodvijentes']=$vigentes[0]['apartados'];
                //     }
                // }
                // 0: {apartados: '1', fecha: '2023-03'}
                $i++;
            }
            $i=0;
            //( empty($value['cancelaciones'] ) ? 0  :  $value['cancelaciones'] )
            foreach ($ventas_cancelacion_vijentes as  $value) {
                $response[$i]['periodo']=( empty($value['periodo'] ) ? 0  :  $value['periodo'] );
                $response[$i]['ventas']=( empty($value['ventas'] ) ? 0  :  $value['ventas'] );
                $response[$i]['apartado']=( empty($value['apartado'] ) ? 0  :  $value['apartado'] );
                $response[$i]['cancelaciones']=( empty($value['cancelaciones'] ) ? 0  :  $value['cancelaciones'] );
                $response[$i]['apartodvijentes']=( empty($value['apartodvijentes'] ) ? 0  :  $value['apartodvijentes'] );
                $i++;
            }

        }
        // $fi='2022-01-01 00:00:00';
        // $ff='2022-11-11 23:59:59';
        // $vigente=date('Y-m-d H:i:s');   
        // $desarrollo_id=246;
        // $user_id=246;
        if (empty($response)) {
            $response[$i]['periodo']='sin informacion';
            $response[$i]['ventas']=0;
            $response[$i]['apartado']=0;
            $response[$i]['cancelaciones']=0;
            $response[$i]['apartodvijentes']=0;
            $i++;
        }
        echo json_encode( $response , true );
        exit();
        $this->autoRender = false;
    }
    /**
     * 
     * 
    */
    public function getPeriodosArreglo($fecha_inicial = null, $fecha_final = null){
        $ano_inicial = date('Y',strtotime($fecha_inicial));
        $ano_final = date('Y',strtotime($fecha_final));
        $mes_arranque = intval(date('m',strtotime($fecha_inicial)));
        $mes_final =  intval(date('m',strtotime($fecha_final)));
    
        $periodos = array();
        $tope = 12;
        for($i=$ano_inicial ; $i<= $ano_final; $i++){
          if($i==$ano_final){
            $tope = $mes_final;
          }
          for($x = $mes_arranque; $x<=$tope; $x++){
            $mes = ($x<10 ? "0".$x : $x);
            $periodos[$i."-".$mes] = $mes."-".$i;
          }
          $mes_arranque = 1;
        }
    
        //$this->set('periodos',$periodos);
        return $periodos;
    
    }

    /**
     * Metodo para agregar ventas de forma masiva atraves de csv.
     * AKA SAAK 27/feb/2023
    */
    public function add_ventas_masivas(){
        $this->loadModel('Cliente');
        $this->loadModel('User');
        $this->loadModel('Inmueble');
        



        $response['data']    = [];
        $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
        $clientes  = $this->Cliente->find('list', array('conditions' => array('Cliente.cuenta_id' => $cuenta_id )));
        $agentes   = $this->User->find('list',array('order'=>array('User.status DESC', 'User.nombre_completo ASC'),'conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE  cuenta_id = '.$cuenta_id.')')));
        $inmuebles = $this->Inmueble->find('list', array('conditions' => array('Inmueble.cuenta_id' => $cuenta_id)));

        $this->set(compact('clientes', 'agentes', 'inmuebles'));
        

        if ($this->request->is('post')){

            $file     = $this->request->data['OperacionesCSV']['file']['tmp_name'];
            $response['data'] = file($file);

            $i = 0;

        }

        $this->set(compact ('response') );

    }

    public function f_add_venta(){

		header('Content-type: application/json; charset=utf-8');
		$this->loadModel('DesarrolloInmueble');
		$this->loadModel('Cliente');
		$this->loadModel('OperacionesInmueble');
		$this->loadModel('LogClientesEtapa');
		$this->loadModel('Lead');
		$this->loadModel('Agenda');
		$this->loadModel('Venta');

		$this->DesarrolloInmueble->Behaviors->load('Containable');
		$this->Cliente->Behaviors->load('Containable');
        $response      = [];
        $i             = 0;
        $desarrollo_id = 0;

        if ($this->request->is('post')){

			foreach( $this->request->data['Operaciones'] as $operacion ){

				$desarrollo_id = $this->DesarrolloInmueble->find('first', array(
					'conditions' => array(
						'DesarrolloInmueble.inmueble_id' => $operacion['inmueble_id'],
					),
					'fields' => array(
						'desarrollo_id',
					),
					'contain' => false
				));

				$cuenta_id = $this->Cliente->find('first', array(
					'conditions' => array(
					    'Cliente.id' => $operacion['cliente_id'],
					),
					'fields' => array(
					    'Cliente.cuenta_id',
                         'Cliente.nombre',
                         'Cliente.status',
					),
					'contain' => false
				));

                $inmueble_name = $this->DesarrolloInmueble->find('first', array(
					'conditions' => array(
					    'DesarrolloInmueble.inmueble_id' => $operacion['Inmueble_id'],
					),
					'fields' => array(
                         'DesarrolloInmueble.referencia',
					),
					'contain' => false
				));

				$fecha = date('Y-m-d H:i:s',  strtotime($operacion['fecha']));


				$this->OperacionesInmueble->create();
				$this->request->data['OperacionesInmueble']['id']                 = null;
				$this->request->data['OperacionesInmueble']['tipo_operacion']     = $operacion['tipo_operacion'];
				$this->request->data['OperacionesInmueble']['precio_unidad']      = $operacion['precio_unidad'];
				$this->request->data['OperacionesInmueble']['precio_cierre']      = $operacion['precio_cierre'];
				$this->request->data['OperacionesInmueble']['fecha']              = $fecha;
				$this->request->data['OperacionesInmueble']['cliente_id']         = $operacion['cliente_id'];
				$this->request->data['OperacionesInmueble']['user_id']            = $operacion['user_id'];
				$this->request->data['OperacionesInmueble']['vigencia_operacion'] = $operacion['vigencia_operacion'];
				$this->request->data['OperacionesInmueble']['inmueble_id']        = $operacion['inmueble_id'];
				$this->request->data['OperacionesInmueble']['status']             = 'Activo';
				$this->request->data['OperacionesInmueble']['dic_cancelacion_id'] = null;
				$this->request->data['OperacionesInmueble']['cotizacion_id']      = null;

				if ($this->OperacionesInmueble->save($this->request->data)) {

                    /* ----------- Deshabilitar las demas etapas que tenga el cliente. ---------- */

					$this->LogClientesEtapa->create();
					$this->request->data['LogClientesEtapa']['id']            = null;
					$this->request->data['LogClientesEtapa']['cliente_id']    = $operacion['cliente_id'];
					$this->request->data['LogClientesEtapa']['fecha']         = $fecha;
					$this->request->data['LogClientesEtapa']['etapa']         = 7;
					$this->request->data['LogClientesEtapa']['desarrollo_id'] = $desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
					$this->request->data['LogClientesEtapa']['inmuble_id']   = $operacion['inmueble_id'];
					$this->request->data['LogClientesEtapa']['status']        = 'Activo';
					$this->request->data['LogClientesEtapa']['user_id']       = $operacion['user_id'];

					if ($this->LogClientesEtapa->save($this->request->data)) {

						$this->Lead->create();
						$this->request->data['Lead']['id']                    = null;
						$this->request->data['Lead']['cliente_id']            = $operacion['cliente_id'];
						$this->request->data['Lead']['fecha']                 = $fecha;
						$this->request->data['Lead']['dic_linea_contacto_id'] = 0;
						$this->request->data['Lead']['desarrollo_id']         = $desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
						$this->request->data['Lead']['inmueble_id']           = $operacion['inmueble_id'];
						$this->request->data['Lead']['status']                = 'Cerrado';

						if ($this->Lead->save($this->request->data)) {

							$this->request->data['Cliente']['id']        = $operacion['cliente_id'];
                            if ($this->Lead->save($cuenta_id['Cliente']['status']) != 'Activo') {
                                $this->request->data['Cliente']['status'] = 'Activo';
                            }
							$this->request->data['Cliente']['last_edit'] = $fecha;
							$this->request->data['Cliente']['etapa']     = 7;

							if ($this->Cliente->save($this->request->data)) {

								$this->request->data['Inmueble']['id']        = $operacion['inmueble_id'];
								$this->request->data['Inmueble']['etapa']     = 7;

								if ($this->Inmueble->save($this->request->data)) {

									$this->Agenda->create();
									$this->request->data['Agenda']['id']         = null;
									$this->request->data['Agenda']['user_id']    = $operacion['user_id'];
									$this->request->data['Agenda']['lead_id']    = 0;
									$this->request->data['Agenda']['fecha']      = $fecha;
									$this->request->data['Agenda']['mensaje']    = 'El cliente'.$cuenta_id['Cliente']['nombre'].'realizo la compra del inmueble'.$inmueble_name['DesarrolloInmueble']['referencia'];
									$this->request->data['Agenda']['cliente_id'] = $operacion['cliente_id'];

									if ($this->Agenda->save($this->request->data)) {

										$this->Venta->create();
										$this->request->data['Venta']['id']         = null;
										$this->request->data['Venta']['user_id']    		= $operacion['user_id'];
										$this->request->data['Venta']['fecha']      		= $fecha;
										$this->request->data['Venta']['precio_cerrado']    		= $operacion['precio_cierre'];
										$this->request->data['Venta']['cliente_id'] 			= $operacion['cliente_id'];
										$this->request->data['Venta']['inmueble_id']         = $operacion['inmueble_id'];
										$this->request->data['Venta']['cuenta_id']           = $cuenta_id['Cliente']['cuenta_id'];
										$this->request->data['Venta']['tipo_operacion']      = 'Venta';
										$this->Venta->save($this->request->data);

									}
								}

							}
						}
					}
				}

				$add = 'Se creo la operacion del cliente: '.$operacion['cliente_id'];

				$i++;
			}
			$response['data']          = $this->request->data;
			$response['desarrollo_id'] = $desarrollo_id;
			$response['cuenta_id'] = $cuenta_id;
        }

        // echo json_encode ( $add );
        echo json_encode ( $response );
        exit();
        $this->autoRender = false;
    }
    
}
