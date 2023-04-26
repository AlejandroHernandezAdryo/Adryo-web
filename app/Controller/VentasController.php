<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class VentasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
/**
 * index method
 *
 * @return void
 */
	
    public function add(){
        date_default_timezone_set('America/Mexico_City');
        $this->loadModel('Inmueble');

            if ($this->request->is('post')){
            $timestamp=date('Y-m-d H:i:s');
            $this->request->data['Venta']['fecha']          = date('Y-m-d H:i:s', strtotime($this->request->data['Venta']['fecha_venta']));
            $this->request->data['Venta']['cuenta_id']      = $this->Session->read('CuentaUsuario.Cuenta.id');
            $this->request->data['Venta']['tipo_operacion'] = $this->request->data['Venta']['operacion'];
            $this->Venta->create();
            $this->Venta->save($this->request->data);
            $venta_id = $this->Venta->getInsertID();

            $this->Venta->query("UPDATE inmuebles SET vendido = 1, liberada = ".$this->request->data['Venta']['liberada']." WHERE id = ".$this->request->data['Venta']['inmueble_id']);
            
                
            $this->loadModel('LogInmueble');
            $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Venta']['inmueble_id'];
            $this->request->data['LogInmueble']['mensaje']     = "Se cierra Inmueble como vendido";
            $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
            $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s', strtotime($this->request->data['Venta']['fecha_venta']));
            $this->request->data['LogInmueble']['accion']      = 3;
            $this->LogInmueble->create();
            $this->LogInmueble->save($this->request->data);
            
            $inmueble = $this->Inmueble->find('first',array('conditions'=>array('Inmueble.id'=>$this->request->data['Venta']['inmueble_id'])));
            if ($this->request->data['Venta']['precio_cerrado']!=$inmueble['Inmueble']['precio'] || $this->request->data['Venta']['precio_cerrado']!=$inmueble['Inmueble']['precio_2']){
                $this->loadModel('Precio');
                $this->request->data['Precio']['inmueble_id'] = $this->request->data['Venta']['inmueble_id'];
                $this->request->data['Precio']['precio']      = $this->request->data['Venta']['precio_cerrado'];
                $this->request->data['Precio']['fecha']       = date('Y-m-d H:i:s', strtotime($this->request->data['Venta']['fecha_venta']));
                $this->request->data['Precio']['user_id']     = $this->Session->read('Auth.User.id');
                $this->Precio->create();
                $this->Precio->save($this->request->data);
            }
            
            $this->loadModel('LogCliente');
            $this->loadModel('Cliente');
            $this->LogCliente->create();
            $cliente = $this->Cliente->read(null,$this->request->data['Venta']['cliente_id']);
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Venta']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s', strtotime($this->request->data['Venta']['fecha_venta']));
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['mensaje']    = "Cliente ".$cliente['Cliente']['nombre']." realiza cierre de propiedad ".$inmueble['Inmueble']['referencia']." el ".date('Y-m-d H:i:s', strtotime($this->request->data['Venta']['fecha_venta']));
            $this->LogCliente->save($this->request->data);
            
            $this->loadModel('Agenda');
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']   = $timestamp;
            $this->request->data['Agenda']['mensaje'] = "Cliente ".$cliente['Cliente']['nombre']." realiza cierre de propiedad ".$inmueble['Inmueble']['referencia']." el ".$timestamp;
            $this->request->data['Agenda']['cliente_id']=$this->request->data['Venta']['cliente_id'];
            $cliente_id = $this->request->data['Venta']['cliente_id'];
            $this->Agenda->save($this->request->data);

            
            // Step 8 redirigir a la url de origen 1=> inmuebles/view_tipo, 2=> inmuebles/view

            // Provisionalmente se tomara en cuenta para saber a donde mandar si es que hay que hacer una factura para la venta de la propiedad.
            switch ($this->request->data['Venta']['retorno2']) {
                case 1:
                    $redirect = array('controller' => 'facturas','action'=>'add_factura_cliente',$venta_id);
                    break;
                default:
                    switch ($this->request->data['Venta']['retorno']) {
                        case 1:
                            $redirect = array('action' => 'view_tipo','controller'=>'inmuebles',$this->request->data['Venta']['inmueble_id'], $this->request->data['Venta']['desarrollo_id']);
                            break;
                        case 2:
                            $redirect = array('action' => 'view','controller'=>'inmuebles',$this->request->data['Venta']['inmueble_id']);
                            break;
                    }
                break;
            }


                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Se ha registrado exitosamente la venta del inmueble.', 'default', array(), 'm_success');
                $this->redirect($redirect);

            }
    }


    /*********************************************************************
    *   
    *   -Quitarle el icono de vendido a la propiedad cancelada y esa 
    *   unidad pasa a status borrador
    *   -Se tiene que registrar un log en la agenda con la leyenda
    *   "El usuario xxxx(admin) elimino la venta de la propiedad 
    *   xxxx(nombre de la propiedad) el dia (d-m-Y H:m:s)"
    *   -Se tiene que crear un LogInmueble de que se ha eliminado la venta
    *   de la propiedad con la leyenda "Se elimina venta por xxxx(admin)"
    *   el dia (dm-Y H:m:s)
    *   -Cambiar el estatus del cliente como Activo y temperatura tibia
    *   -Se tiene que eliminar en venta.
    *
    *********************************************************************/

    public function delete_sale(){
        $this->request->onlyAllow('post', 'delete');

        // Definición de variables
        $id = $this->request->data['Venta']['id'];

        // step 1 - Consultamos la venta para tomar los id que necesitamos
        $venta = $this->Venta->find('first', array('conditions' => array('Venta.'.$this->Venta->primaryKey => $id), 'recursive' => 2));

        // Step 2 - Actualizar el estatus de la propiedad como borrador
        $this->loadModel('Inmueble');
        $this->request->data['Inmueble']['id']       = $venta['Venta']['inmueble_id'];
        $this->request->data['Inmueble']['liberada'] = 0;
        $this->request->data['Inmueble']['vendido']  = 0;
        $this->Inmueble->save($this->request->data['Inmueble']);
        // $this->Inmueble->query("UPDATE inmuebles SET liberada = 0 WHERE id = ".$venta['Venta']['inmueble_id']);

        // Step 3 Guardar registro en la agenda para saber quien, que y cuando elimino la venta
        $this->loadModel('Agenda');
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:m:s');
        $this->request->data['Agenda']['mensaje']    = "El usuario ".$this->Session->read('Auth.User.nombre_completo')." elimino la venta de la propiedad ".$venta['Inmueble']['titulo']." el dia ".date('d-m-Y H:m:s');
        $this->request->data['Agenda']['cliente_id'] = $venta['Venta']['cliente_id'];
        $this->Agenda->save($this->request->data['Agenda']);

        // Step 4 - Guardar registro en el log del inmueble para saber quien y cuadno elimino la venta
        $this->loadModel('LogInmueble');
        $this->request->data['LogInmueble']['inmueble_id'] = $venta['Venta']['inmueble_id'];
        $this->request->data['LogInmueble']['mensaje']     = "Se elimina venta por ".$this->Session->read('Auth.User.nombre_completo')." el dia ".date('d-m-Y H:m:s');
        $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
        $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
        $this->request->data['LogInmueble']['accion']      = 3;
        $this->LogInmueble->create();
        $this->LogInmueble->save($this->request->data['LogInmueble']);

        // Step 5 - Guardar registro en el log del asesor para ponerlo en la bitacora
        $this->loadModel('LogCliente');
        $this->request->data['LogCliente']['id']         = uniqid();
        $this->request->data['LogCliente']['mensaje']    = "Se elimina venta por ".$this->Session->read('Auth.User.nombre_completo')." para el asesor ".$venta['User']['nombre_completo']." del cliente ";
        $this->request->data['LogCliente']['user_id']    = $venta['Venta']['user_id'];
        $this->request->data['LogCliente']['cliente_id'] = $venta['Venta']['cliente_id'];
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
        $this->request->data['LogCliente']['accion']     = 8;
        $this->LogCliente->create();
        $this->LogCliente->save($this->request->data['LogCliente']);

        // Step 6 - Cambiar la temperatura y el estatus del cliente que tenia registrada la venta
        $this->loadModel('Cliente');
        $this->request->data['Cliente']['id']          = $venta['Venta']['cliente_id'];
        $this->request->data['Cliente']['last_edit']   = date('Y-m-d H:m:s');
        $this->request->data['Cliente']['status']      = 'Activo';
        $this->request->data['Cliente']['temperatura'] = 2;
        $this->Cliente->save($this->request->data['Cliente']);

        // Step 7 - Eliminar la venta
        $this->Venta->id = $id;
        $this->Venta->delete();

        // Step 8 redirigir a la url de origen 1=> inmuebles/view_tipo, 2=> inmuebles/view
        // switch ($this->request->data['Venta']['retorno']) {
        //     case 1:
        //         $redirect = array('action' => 'view_tipo','controller'=>'inmuebles',$this->request->data['Venta']['inmueble_id'], $this->request->data['Venta']['desarrollo_id']);
        //         break;
        //     case 2:
        //         $redirect = array('action' => 'view','controller'=>'inmuebles',$this->request->data['Venta']['inmueble_id']);
        //         break;
        // }

        $this->loadModel('DesarrolloInmueble');
        $this->DesarrolloInmueble->Behaviors->load('Containable');

        $desarrollo = $this->DesarrolloInmueble->find('first', array(
            'fields'     => array(
                'Desarrollos.cuenta_id',
                'Desarrollos.horario_contacto'
            ),
            'contain'    => 'Desarrollos',
            'conditions' => array('DesarrolloInmueble.inmueble_id' => $id)
        ));

        $redirect = array('action' => 'view','controller'=>'inmuebles',$this->request->data['Venta']['inmueble_id']);

        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash('La venta se a eliminado de forma exitosa', 'default', array(), 'm_success'); // Mensaje
        $this->redirect($redirect);
    }


    public function sale_list(){
        $this->Venta->Behaviors->load('Containable');

        if (!empty($this->Session->read('Desarrollador'))) {

            $this->set('ventas_generales',
                $this->Venta->find('all',
                    array(
                        'conditions' => array(
                            'Venta.inmueble_id in (Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ('.implode(',', $this->Session->read('Desarrollos') ).'))'
                        ),
                        'fields' => array(
                            'tipo_operacion',
                            'fecha',
                            'precio_cerrado',
                            'id'
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
                                    'nombre'
                                ),
                                'DicLineaContacto' => array(
                                    'fields' => 'linea_contacto'
                                )
                            ),
                            'User' => array(
                                'fields' => array(
                                    'id',
                                    'nombre_completo'
                                )
                            ),
                            'Facturas'
                        )
                    )
                )
            );
            
        }else{
            $this->set('ventas_generales',
                $this->Venta->find('all',
                    array(
                        'conditions' => array(
                            'Venta.cuenta_id' => $this->Session->read('CuentaUsuario.Cuenta.id')
                        ),
                        'fields' => array(
                            'tipo_operacion',
                            'fecha',
                            'precio_cerrado',
                            'id'
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
                                    'nombre'
                                ),
                                'DicLineaContacto' => array(
                                    'fields' => 'linea_contacto'
                                )
                            ),
                            'User' => array(
                                'fields' => array(
                                    'id',
                                    'nombre_completo'
                                )
                            ),
                            'Facturas'
                        )
                    )
                )
            );

        }
    }

    /**
    *esta funcion alimenta la grafica de ventas por asesor 
    *lo hace por los filtros del id del desarrollo, fechas, cuenta
    * AKA RogueOne  
    */
    function grafica_ventas_asesores(){
        header('Content-type: application/json; charset=utf-8');  
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('User');
        $this->User->Behaviors->load('Containable');  
        $this->OperacionesInmueble->Behaviors->load('Containable');  
        $fecha_ini               = '';
        $fecha_fin               = '';
        $desarrollo_id           = 0;
        $i=0;
        $ventas_asesores_arreglo = array();
        if ($this->request->is('post')) {
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            $ventas=$this->OperacionesInmueble->query(
                "SELECT operaciones_inmuebles.user_id, operaciones_inmuebles.precio_unidad FROM operaciones_inmuebles 
                WHERE  fecha >= '$fi' 
                AND fecha <= '$ff'
                AND tipo_operacion=3
                AND operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id 
                FROM desarrollo_inmuebles 
                WHERE desarrollo_id =$desarrollo_id) ;"
            );
            $asesores=$this->User->query(
                "SELECT users.id, users.nombre_completo FROM users"
            );
        $i=0;
        $ventas_asesores_arreglo=array();
        foreach ($asesores as $value) {
            foreach ($ventas as $venta) {
                if ( $value['users']['id']== $venta['operaciones_inmuebles']['user_id']) {
                    $arreglo[$i]['users']=$value['users']['nombre_completo'];
                    $arreglo[$i]['precio_unidad'] += $venta['operaciones_inmuebles']['precio_unidad'];
                    $arreglo[$i]['unidad'] ++;
                }
            }
            $i++;
        }
        
            $i=0;
            foreach ($arreglo as  $value) {
                $ventas_asesores_arreglo[$i]['venta_q'] =  $value['unidad'];
                $ventas_asesores_arreglo[$i]['asesor']  =  $value['users'];
                $ventas_asesores_arreglo[$i]['venta_v'] =  $value['precio_unidad'];
                $i++;
            }
        }

        if (empty($ventas_asesores_arreglo)) {
            $ventas_asesores_arreglo[$i]['venta_q'] = 0;
            $ventas_asesores_arreglo[$i]['asesor'] = "no";
            $ventas_asesores_arreglo[$i]['venta_v'] = 0;
        }
        echo json_encode( $ventas_asesores_arreglo, true );
        exit();
        $this->autoRender = false;
    }  
    
    /***
    * 
    * 
    *  
    * 
    */
    function tabla_ventas(){
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('Desarrollo');
        
        $this->OperacionesInmueble->Behaviors->load('Containable');
        header('Content-type: application/json; charset=utf-8');

        $fecha_ini     = '';
        $fecha_fin     = '';
        $desarrollo_id = 0;
        $cuenta_id     = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $i             = 0;
        $ventas        = [];
        $response      = [];
        $limpieza      = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "�");

        $search_desarollo=$this->Desarrollo->find('list',array(
            'conditions'=>array(
              'Desarrollo.cuenta_id'=> $cuenta_id, 
            ), 
            'fields'=>array(
              'id',
              'nombre',
            ),
            'contain' => false 
        ));
        
        if ($this->request->is('post')) {
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("OperacionesInmueble.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array('OperacionesInmueble.fecha BETWEEN ? AND ?'=> array($fi, $ff));
                }    
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }  
            $totalventa=0;
            $ventas = $this->OperacionesInmueble->find('all',
                array(
                    'conditions' => array(
                        'OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')',
                        'OperacionesInmueble.tipo_operacion' => 3,
                        $cond_rangos,
                    ),'fields' => array(
                        'tipo_operacion',
                        'fecha',
                        'precio_unidad',
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
                                'inmueble_id',
                                'desarrollo_id'
                            ),
                            'DicLineaContacto' => array(
                                'fields' => 'linea_contacto'
                            )
                        ),
                        'User' => array(
                            'fields' => array(
                                'id',
                                'nombre_completo'
                            )
                        ),
                    ),
                    'order'   => 'OperacionesInmueble.fecha DESC',
                ) 
            );
            foreach( $ventas as $venta ){
                if ($venta['OperacionesInmueble']['tipo_operacion']==3) {
                    $robert[$i]['tipo']='Venta';
                    
                }else{
                    $robert[$i]['tipo']=$venta['OperacionesInmueble']['tipo_operacion'];
                }
                
                $robert[$i]['desarrollo_origen'] = $search_desarollo[$venta['Cliente']['desarrollo_id']]; // Campo de desarrollo de origen AKA SaaK 31-Mar-2023

                $robert[$i]['titulo']= "<a href='".Router::url('/inmuebles/view_tipo/'.$venta['Inmueble']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Inmueble']['referencia']))."</a>";
                $robert[$i]['nombre']= "<a href='".Router::url('/clientes/view/'.$venta['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Cliente']['nombre']))."</a>";
                $robert[$i]['asesor']= "<a href='".Router::url('/clientes/view/'.$venta['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['User']['nombre_completo']))."</a>";
                $robert[$i]['contacto']=$venta['Cliente']['DicLineaContacto']['linea_contacto'];   
                $robert[$i]['fecha']=date('Y-m-d', strtotime($venta['OperacionesInmueble']['fecha']));
                $robert[$i]['precio']= '$'.number_format($venta['OperacionesInmueble']['precio_unidad'], 2);
                $totalventa += $venta['OperacionesInmueble']['precio_unidad'];
                $robert[$i]['total']= '$'.number_format($totalventa, 2);
                $i++;
            }
        }
        echo json_encode($robert, true);
        exit();
        $this->autoRender = false;
    } 
    /**
     * function para la tabla de apartados 
     ** AKA RogueOne 
     * 
     * 
    */
    function tabla_apartados(){
        $this->loadModel('OperacionesInmueble');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        header('Content-type: application/json; charset=utf-8');
        $and           = [];
        $or            = [];
        $fecha_ini     = '';
        $fecha_fin     = '';
        $desarrollo_id = 0;
        $cuenta_id     = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $i             = 0;
        $apartados        = [];
        $response      = [];
        $limpieza      = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "�");
        
        if ($this->request->is('post')) {
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("OperacionesInmueble.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array('OperacionesInmueble.fecha BETWEEN ? AND ?'=> array($fi, $ff));
                }    
                array_push($and, $cond_rangos);
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
                array_push($and, array('OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')',));
            }  
            if( !empty( $this->request->data['user_id'] ) ){
                array_push($and, array('OperacionesInmueble.user_id' => $this->request->data['user_id'] ));
            }
            $condiciones = array(
                'AND' => $and,
                'OR'  => $or
            );
            $apartados = $this->OperacionesInmueble->find('all',
                array(
                    'conditions' => array(
                        // 'OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')',
                        'OperacionesInmueble.tipo_operacion' => 2,
                        $condiciones,
                    ),'fields' => array(
                        'tipo_operacion',
                        'fecha',
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
                                'nombre'
                            ),
                            'DicLineaContacto' => array(
                                'fields' => 'linea_contacto'
                            )
                        ),
                        'User' => array(
                            'fields' => array(
                                'id',
                                'nombre_completo'
                            )
                        ),
                    ),
                    'order'   => 'OperacionesInmueble.fecha DESC',
                ) 
            );
            $totalventa=0;
            foreach( $apartados as $venta ){
                if ($venta['OperacionesInmueble']['tipo_operacion']==2) {
                    $response[$i]['tipo']='Apartado';
                    
                }else{
                    $response[$i]['tipo']=$venta['OperacionesInmueble']['tipo_operacion'];
                }
                // $response[$i]['tipo']=$venta['OperacionesInmueble']['tipo_operacion'];
                $response[$i]['titulo']= "<a href='".Router::url('/inmuebles/view/'.$venta['Inmueble']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Inmueble']['referencia']))."</a>";
                $response[$i]['nombre']= "<a href='".Router::url('/clientes/view/'.$venta['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Cliente']['nombre']))."</a>";
                $response[$i]['asesor']= "<a href='".Router::url('/clientes/view/'.$venta['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['User']['nombre_completo']))."</a>";
                $response[$i]['contacto']=$venta['Cliente']['DicLineaContacto']['linea_contacto'];   
                $response[$i]['fecha']=date('Y-m-d', strtotime($venta['OperacionesInmueble']['fecha']));
                $response[$i]['precio']= '$'.number_format($venta['OperacionesInmueble']['precio_cierre'], 2);
                $totalventa += ( empty($venta['OperacionesInmueble']['precio_cierre']) ? 0 : $venta['OperacionesInmueble']['precio_cierre'] );
                // ( empty($totalventa) ? 0 :$totalventa  )
                $response[$i]['total']= '$'.number_format(( $totalventa==null ? 0 :$totalventa  ), 2);
                $i++;
            }
        }
        // $fi='2022-07-01 00:00:00';
        // $ff='2022-08-08 23:59:59';
        // $desarrollo_id=246;
        // $user_id=246;
        // $cond_rangos = array('OperacionesInmueble.fecha BETWEEN ? AND ?'=> array($fi, $ff));
        // $apartados = $this->OperacionesInmueble->find('all',
        //     array(
        //         'conditions' => array(
        //             // 'OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')',
        //             'OperacionesInmueble.tipo_operacion' => 2,
        //             $condiciones,
        //         ),'fields' => array(
        //             'tipo_operacion',
        //             'fecha',
        //             'precio_unidad',
        //         ),
        //         'contain' => array(
        //             'Inmueble' => array(
        //                 'fields' => array(
        //                     'id',
        //                     'referencia'
        //                 )
        //             ),
        //             'Cliente' => array(
        //                 'fields' => array(
        //                     'id',
        //                     'nombre'
        //                 ),
        //                 'DicLineaContacto' => array(
        //                     'fields' => 'linea_contacto'
        //                 )
        //             ),
        //             'User' => array(
        //                 'fields' => array(
        //                     'id',
        //                     'nombre_completo'
        //                 )
        //             ),
        //         ),
        //         'order'   => 'OperacionesInmueble.fecha DESC',
        //     ) 
        // );
        // // $apartados = $this->OperacionesInmueble->find('all',
        // //     array(
        // //         'conditions' => array(
        // //             'OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$user_id.')',
        // //             'OperacionesInmueble.tipo_operacion'=>2,
        // //             $cond_rangos,
        // //         ),'fields' => array(
        // //             'tipo_operacion',
        // //             'fecha',
        // //             'precio_cierre',
        // //         ),
        // //         'contain' => array(
        // //             'Inmueble' => array(
        // //                 'fields' => array(
        // //                     'id',
        // //                     'referencia'
        // //                 )
        // //             ),
        // //             'Cliente' => array(
        // //                 'fields' => array(
        // //                     'id',
        // //                     'nombre'
        // //                 ),
        // //                 'DicLineaContacto' => array(
        // //                     'fields' => 'linea_contacto'
        // //                 )
        // //             ),
        // //             'User' => array(
        // //                 'fields' => array(
        // //                     'id',
        // //                     'nombre_completo'
        // //                 )
        // //             ),
        // //         )
        // //     ) 
        // // );
        // foreach( $apartados as $venta ){
        //     $response[$i]['tipo']=$venta['OperacionesInmueble']['tipo_operacion'];
        //     $response[$i]['titulo']= "<a href='".Router::url('/inmuebles/view/'.$venta['Inmueble']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Inmueble']['referencia']))."</a>";
        //     $response[$i]['nombre']= "<a href='".Router::url('/clientes/view/'.$venta['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Cliente']['nombre']))."</a>";
        //     $response[$i]['asesor']= "<a href='".Router::url('/clientes/view/'.$venta['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['User']['nombre_completo']))."</a>";
        //     $response[$i]['contacto']=$venta['Cliente']['DicLineaContacto']['linea_contacto'];   
        //     $response[$i]['fecha']=date('Y-m-d', strtotime($venta['OperacionesInmueble']['fecha']));
        //     $response[$i]['precio']= '$'.number_format($venta['OperacionesInmueble']['precio_cierre'], 2);
        //     $totalventa += $venta['OperacionesInmueble']['precio_cierre'];
        //     $response[$i]['total']= '$'.number_format($totalventa, 2);
        //     $i++;
        // }
        echo json_encode($response, true);
        exit();
        $this->autoRender = false;
    } 
    /**
     * 
     *function para el listado de apartados
     * fecha inicio:2022_26_26
     * AKA RogueOne
     *
    */
    function listado_apartados(){
        $this->loadModel('OperacionesInmueble');
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        header('Content-type: application/json; charset=utf-8');
        $and           = [];
        $or            = [];
        $fecha_ini     = '';
        $fecha_fin     = '';
        $desarrollo_id = 0;
        $i             = 0;
        $apartados        = [];
        $response      = [];
        $limpieza      = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "�");
        $search_desarollo=$this->Desarrollo->find('all',array(
            'conditions'=>array(
              'Desarrollo.cuenta_id'=> $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 
            ), 
            'fields'=>array(
              'nombre',
              'id',
            ),
            'contain' => false 
        ));
        $this->set(compact('search_desarollo'));
        if ($this->request->is('post')) {

            if( !empty( $this->request->data['cuenta_id'] ) ){
                $cuenta_id= $this->request->data['cuenta_id'];
                $desarrollo_id=$this->Desarrollo->find('all',array(
                    'conditions'=>array(
                        'Desarrollo.cuenta_id' =>$cuenta_id,
                      ),
                      'fields' => array(
                          'Desarrollo.id',
                      ),
                      'contain' => false 
                ));
                foreach ($desarrollo_id as $id) {
                    $desarrollo=$desarrollo.$id['Desarrollo']['id'].',';
                }
                $desarrollo = substr($desarrollo,0,-1);
                array_push($and, array('OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ('.$desarrollo.'))',));


            }
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("OperacionesInmueble.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array('OperacionesInmueble.fecha BETWEEN ? AND ?'=> array($fi, $ff));
                }    
                array_push($and, $cond_rangos);
            }
            if( !empty($this->request->data['dia']) ){
                $fecha_ini = $this->request->data['rango_fechas'].' 00:00:00';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $cond_rangos = array('OperacionesInmueble.vigencia_operacion >='=> $fi);    
                array_push($and, $cond_rangos);
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
                array_push($and, array('OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')',));
            }  
            if( !empty( $this->request->data['user_id'] ) ){
                array_push($and, array('OperacionesInmueble.user_id' => $this->request->data['user_id'] ));
            }
            $condiciones = array(
                'AND' => $and,
            );
            $apartados = $this->OperacionesInmueble->find('all',
                array(
                    'conditions' => array(
                        'OperacionesInmueble.tipo_operacion' => 2,
                        $condiciones,
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
                                'nombre'
                            ),
                            'DicLineaContacto' => array(
                                'fields' => 'linea_contacto'
                            )
                        ),
                        'User' => array(
                            'fields' => array(
                                'id',
                                'nombre_completo'
                            )
                        ),
                    ),
                    'order'   => 'OperacionesInmueble.fecha DESC',
                ) 
            );
            $totalventa=0;
            $count=0;

            foreach( $apartados as $venta ){
                if ($venta['OperacionesInmueble']['tipo_operacion']==2) {
                    $response[$i]['tipo']='Apartado';
                    
                }else{
                    $response[$i]['tipo']=$venta['OperacionesInmueble']['tipo_operacion'];
                }
                // $response[$i]['tipo']=$venta['OperacionesInmueble']['tipo_operacion'];
                $response[$i]['titulo']= "<a href='".Router::url('/inmuebles/view/'.$venta['Inmueble']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Inmueble']['referencia']))."</a>";
                $response[$i]['nombre']= "<a href='".Router::url('/clientes/view/'.$venta['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Cliente']['nombre']))."</a>";
                $response[$i]['asesor']= "<a href='".Router::url('/clientes/view/'.$venta['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['User']['nombre_completo']))."</a>";
                $response[$i]['contacto']=$venta['Cliente']['DicLineaContacto']['linea_contacto'];   
                $response[$i]['fecha']=date('Y-m-d', strtotime($venta['OperacionesInmueble']['fecha']));
                $response[$i]['vigencia']=date('Y-m-d', strtotime($venta['OperacionesInmueble']['vigencia_operacion']));
                $response[$i]['precio']= '$'.number_format($venta['OperacionesInmueble']['precio_cierre'], 2);
                $totalventa += $venta['OperacionesInmueble']['precio_cierre'];
                $response[$i]['total']= '$'.number_format($totalventa, 2);
                $clientes_json[$count] = array(
                    $response[$i]['tipo'],
                    "<a href='".Router::url('/inmuebles/view/'.$venta['Inmueble']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Inmueble']['referencia']))."</a>",
                    "<a href='".Router::url('/clientes/view/'.$venta['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['Cliente']['nombre']))."</a>",
                    $venta['Cliente']['DicLineaContacto']['linea_contacto'],
                    "<a href='".Router::url('/clientes/view/'.$venta['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $venta['User']['nombre_completo']))."</a>",
                    date('Y-m-d', strtotime($venta['OperacionesInmueble']['fecha'])),
                    date('Y-m-d', strtotime($venta['OperacionesInmueble']['vigencia_operacion'])),
                    
                    $response[$i]['total'],
                    
                );
                $i++;

                $count++;

            }
            echo json_encode($clientes_json, true);
            exit();
        }
    }   


        
       
}

