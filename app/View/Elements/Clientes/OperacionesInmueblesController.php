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
    public $uses = array('OperacionesInmueble', 'Inmueble', 'LogInmueble', 'LogCliente', 'Cliente', 'Agenda', 'DocsCliente', 'Venta', 'LogClientesEtapa');
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
    }

    public function add_reserva(){
        header('Content-type: application/json; charset=utf-8');
        $save    = [];
        
        if ($this->request->is('post')){
            
            $mensaje     = '';
            $inmueble_id = $this->request->data['ProcesoInmuebles']['inmueble_id'];
            $inmueble    = $this->Inmueble->find('first',array('conditions'=>array('Inmueble.id'=>$inmueble_id)));
            $cliente     = $this->Cliente->read(null,$this->request->data['ProcesoInmuebles']['cliente_id']);
            $timestamp   = date('Y-m-d H:i:s');

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
            $query = $this->OperacionesInmueble->query("update clientes SET clientes.etapa = 6 WHERE clientes.id = ".$this->request->data['ProcesoInmuebles']['cliente_id'].";");

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
            $this->request->data['LogClientesEtapa']['id']           = null;
            $this->request->data['LogClientesEtapa']['cliente_id']   = $this->request->data['ProcesoInmuebles']['cliente_id'];
            $this->request->data['LogClientesEtapa']['fecha']        = date('Y-m-d H:i:s');
            $this->request->data['LogClientesEtapa']['etapa']        = 6;
            $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
            $this->request->data['LogClientesEtapa']['inmuble_id']   = $inmueble_id;
            $this->request->data['LogClientesEtapa']['status']       = 'Activo';
            $this->request->data['LogClientesEtapa']['user_id']      = $this->Session->read('Auth.User.id');
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
            $this->request->data['Agenda']['mensaje']        = 'Se realiza cambio a etapa 6, el cliente solicita el apartado de '.$inmueble['Inmueble']['referencia'].'.';
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
            // $this->updateDataInmueblesMappen($this->request->data['ProcesoInmuebles']['precio_unidad'], $this->request->data['ProcesoInmuebles']['tipo_operacion'], $inmueble_id);
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
        $save    = [];
        
        if ($this->request->is('post')){
            
            $mensaje     = '';
            $inmueble_id = $this->request->data['ProcesoInmueblesVenta']['inmueble_id'];
            $inmueble    = $this->Inmueble->find('first',array('conditions'=>array('Inmueble.id'=>$inmueble_id)));
            $cliente     = $this->Cliente->read(null,$this->request->data['ProcesoInmueblesVenta']['cliente_id']);
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
            $query = $this->OperacionesInmueble->query("update clientes SET clientes.etapa = 7 WHERE clientes.id = ".$this->request->data['ProcesoInmueblesVenta']['cliente_id'].";");
            // $this->updateDataInmueblesMappen($this->request->data['ProcesoInmueblesVenta']['precio_unidad'], $this->request->data['ProcesoInmueblesVenta']['tipo_operacion'], $inmueble_id);

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
            $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
            $this->request->data['LogClientesEtapa']['etapa']         = 7;
            $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
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
            $this->request->data['Agenda']['mensaje']    = 'Se realiza cambio a etapa 7, el cliente compra la propiedad '.$inmueble['Inmueble']['referencia'].'.';
            $this->request->data['Agenda']['cliente_id'] = $this->request->data['ProcesoInmueblesVenta']['cliente_id'];
            $this->Agenda->save($this->request->data);



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
     */
    function cancelacion_save(){
        $this->Inmueble->Behaviors->load('Containable');
        header('Content-type: application/json; charset=utf-8');
        $save    = [];
        
        if ($this->request->is('post')){

            sleep(2);

            $this->request->data['OperacionesInmueble']['dic_cancelacion_id'] = $this->request->data['OperacionCancelar']['tipo_operacion'];
            $this->request->data['OperacionesInmueble']['inmuebleId']         = $this->request->data['OperacionCancelar']['inmueble_id'];
            $this->request->data['OperacionesInmueble']['clienteId']          = $this->request->data['OperacionCancelar']['cliente_id'];
            
            // Tipo de proceso
            $tipo_operacion = $this->request->data['OperacionesInmueble']['dic_cancelacion_id'];
            $cliente_id     = $this->request->data['OperacionesInmueble']['clienteId'];
            $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
            $user_id        = $this->Session->read('Auth.User.id');
            $current_date   = date('d-m-Y');
            
            // Cambiar el estatus de la operacion del inmueble
            $inmueble    = $this->Inmueble->find('first',
                array(
                    'conditions' => array( 'Inmueble.id' => $this->request->data['OperacionesInmueble']['inmuebleId'] ),
                    'fields'     => array( 'id', 'titulo', 'liberada' ),
                    'contain'    => false
                )
            );

            // Hacer el cambio de la etapa en automati a etapa 6 del cliente.
            $query = $this->OperacionesInmueble->query("update clientes SET clientes.etapa = 4 WHERE clientes.id = ".$this->request->data['OperacionCancelar']['cliente_id'].";");
            // $this->updateDataInmueblesMappen('', 1, $this->request->data['OperacionesInmueble']['inmuebleId'] );
            // $new_precio = null, $property_status = null, $idInmueble = null

            $etapas_cliente = $this->LogClientesEtapa->find('all', array(
                'conditions' => array(
                    'LogClientesEtapa.cliente_id' => $this->request->data['OperacionCancelar']['cliente_id'],
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
            $this->request->data['LogClientesEtapa']['cliente_id']    = $this->request->data['OperacionCancelar']['cliente_id'];
            $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
            $this->request->data['LogClientesEtapa']['etapa']         = 4;
            $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
            $this->request->data['LogClientesEtapa']['inmuble_id']    = $this->request->data['OperacionesInmueble']['inmuebleId'];
            $this->request->data['LogClientesEtapa']['status']        = 'Activo';
            $this->request->data['LogClientesEtapa']['user_id']       = $this->Session->read('Auth.User.id');
            $this->LogClientesEtapa->save($this->request->data);


            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         = uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['OperacionCancelar']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
            $this->LogCliente->save($this->request->data);

            $mensaje = "Se cancelo la operacion de la propiedad ".$inmueble['Inmueble']['titulo']." por el asesor ".$this->Session->read('Auth.User.nombre_completo') ;

            // 1.- Actualizar el valor de liberada.
            $this->request->data['Inmueble']['id']       = $this->request->data['OperacionesInmueble']['inmuebleId'];
            $this->request->data['Inmueble']['liberada'] = 1;
            $this->Inmueble->save($this->request->data);

            // Hacer el recorrido de las operaciones para dejarlas como canceladas en automatico.


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

            //save dic_cancelacion_id

            $operaciones = $this->OperacionesInmueble->find('all', array(
                'conditions' => array(
                    'OperacionesInmueble.inmueble_id' => $this->request->data['OperacionesInmueble']['inmuebleId']
                ),
            ));

            foreach( $operaciones as $operacion ){
                
                $this->request->data['OperacionesInmueble']['id']                 = $operacion['OperacionesInmueble']['id'];
                $this->request->data['OperacionesInmueble']['dic_cancelacion_id'] = $this->request->data['OperacionCancelar']['opciones_cancelacion'];
                $this->request->data['OperacionesInmueble']['status']             = 'Cancelada';
                $this->OperacionesInmueble->save( $this->request->data['OperacionesInmueble'] );

            }


            $save = array(
                'data'     => $this->request->data,
                'inmueble' => $inmueble
            );

    
        }
        
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash( 'Se cancelo correctamente la operación.' , 'default', array(), 'm_success');
        echo json_encode($save);

        exit();           
        $this->autoRender = false;
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


    function updateDataInmuebles(){
        $HttpSocket = new HttpSocket();
        $response = $HttpSocket->put('https://us-central1-inmoviliarias-hmmx.cloudfunctions.net/mpSincronizarUnidad', array('idCRM' => 6870, 'idCorporativo' => 'Acciona', 'precio' => 4449600, 'status' => '1'));
    
        echo $response;
        $this->autoRender = false;
    
    }



    
}

