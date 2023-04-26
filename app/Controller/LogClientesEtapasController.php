<?php
App::uses('AppController', 'Controller');

class LogClientesEtapasController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator');
    public $uses = array('Agenda','Cliente','User', 'LogClientesEtapa', 'Cuenta', 'OperacionesInmueble', 'DicEmbudoVenta', 'Inmueble');
    
    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow(array('get_list_etapa', 'clientes_activos_etapa_by_ajax'));

    }

    // Agregar nuevo log del cliente por cada etapa.
	public function add() {
		
	}

    /**
     * 
     * Metodo para consultar la etapa 1 de los clientes atraves de un post,
     * mediante ajax.
     * 29 Sep 2022 - AKA SaaK
     * SSe dejaa pendiente el filtro por el rango de fechas.
    */
    public function get_list_etapa(){
        $this->Cliente->Behaviors->load('Containable');
        $this->Cuenta->Behaviors->load('Containable');
        $clientes          = [];
        $response          = [];
        $and               = [];
        $i                 = 0;
        $date_current      = '';
        $date_oportunos    = '';
        $date_tardios      = '';
        $date_no_atendidos = '';
        $oportunos         = 0;
        $tardios           = 0;
        $no_atendidos      = 0;
        $por_reasignar     = 0;
        $etapa             = 0;

        if( $this->request->is('post') ){
            
            $param = $this->Cuenta->find('first',array(
                'conditions'=>array(
                'Cuenta.id'=>$this->request->data['cuenta_id'],        
                ),
                'fields' => array(
                'Cuenta.paramconfig_id',
                ),
                'contain' => array(
                'Parametros' => array(
                    'fields' => array(
                    'sla_oportuna',
                    'sla_atrasados',
                    'sla_no_atendidos',
                    )
                ),
                )
            ));

            $list_propiedades = $this->Inmueble->find('list', array('conditions' => array('Inmueble.cuenta_id' => $this->request->data['cuenta_id'])));

            $date_current      = date('Y-m-d');
            $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $param['Parametros']['sla_oportuna'], date('Y')));
            $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $param['Parametros']['sla_atrasados'], date('Y')));
            $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $param['Parametros']['sla_no_atendidos'], date('Y')));

            // $data = array(
            //     'cuenta_id'     => 178,
            //     'etapa'         => 1,
            //     'nombre'        => '',
            //     'user_id'       => '',
            //     'desarrollo_id' => 237,
            //     'rango_fechas'  => '07/06/2022 - 08/01/2023'
            // );

            $clientes = $this->log_etapas_embudo_ventas( $this->request->data );

            foreach( $clientes as $cliente ){

                if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) {
                    $at = 'OP'; $name_at = "oportuno"; $class_at = "oportuno"; $class_filter = 'oportuno_filter_'.$cliente['Cliente']['etapa'];
                    $oportunos ++;
                }
                elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){
                    $at = 'TA'; $name_at = "tardio"; $class_at = "tardio"; $class_filter = 'tardio_filter_'.$cliente['Cliente']['etapa'];
                    $tardios ++;
                }
                elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){
                    $at = 'NA'; $name_at = "noatendido"; $class_at = "noatendido"; $class_filter = 'noatendido_filter_'.$cliente['Cliente']['etapa'];
                    $no_atendidos ++;
                }
                elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){
                    $at = 'PR'; $name_at = "reasignar"; $class_at = "reasignar"; $class_filter = 'reasignar_filter_'.$cliente['Cliente']['etapa'];
                    $por_reasignar ++;
                }
                else{
                    $at = 'PR'; $name_at = "reasignar"; $class_at = "chip_bg_reasignar"; $class_filter = "reasignar_filter_";
                }

                $clientes[$i]['Cliente']['created']                  = date('d-m-Y', strtotime($cliente['Cliente']['created']));
                $clientes[$i]['Cliente']['last_edit']                = date('d-m-Y', strtotime($cliente['Cliente']['last_edit']));
                $clientes[$i]['Cliente']['estatus_atencion']         = $at;
                $clientes[$i]['Cliente']['class']                    = $class_at;
                $clientes[$i]['Cliente']['class_pleca']              = $name_at;
                $clientes[$i]['Cliente']['class_filter']             = $class_filter;
                $clientes[$i]['LogClientesEtapa']['fecha']           = date('d-m-Y', strtotime($cliente['Cliente']['fecha_cambio_etapa']));

                $clientes[$i]['LogClientesEtapa']['propieades_show'] = (empty($cliente['Desarrollo']['nombre']) ? '' : $cliente['Desarrollo']['nombre']).(empty($cliente['Inmueble']['referencia']) ? '' : $cliente['Inmueble']['referencia']);

                if( $cliente['Cliente']['etapa'] >= 6 ){
                    if( !empty( $cliente['MisOperaciones']['inmueble_id'] ) ){
                        $clientes[$i]['LogClientesEtapa']['propieades_show'] = 'Sin propiedad id';
                    }else{
                        $clientes[$i]['LogClientesEtapa']['propieades_show'] = $list_propiedades[$cliente['MisOperaciones'][0]['inmueble_id']];
                    }
                }

                $i++;
            }
        }

        // if( $this->request->is('post') ){
        //     $clientes = $this->request->data;
        // }

        $response = array(
            'clientes'      => $clientes,
            'oportunos'     => $oportunos,
            'tardios'       => $tardios,
            'no_atendidos'  => $no_atendidos,
            'por_reasignar' => $por_reasignar,
        );

        echo json_encode( $response );
        $this->autoRender = false;
    }

    /* ---------- Metodo para consulta de clientes del embudo de ventas --------- */
    /** 
     * El mamalon
     * AKA SaaK
     * 10 Ene 2023
     * Campos obligatorios: cuenta_id, etapa, Cliente.Activo, LogCliente.Activo *
     * Campos opcionales: nombre, user_id, desarrollo_id, rango_fechas
    */

    public function log_etapas_embudo_ventas( $data = null ){
        // Variables
            $this->Cliente->Behaviors->load('Containable');
            $this->Cuenta->Behaviors->load('Containable');

            $clientes          = [];
            $response          = [];
            $and               = [];
            $or                = [];
            $i                 = 0;
            $date_current      = '';
            $date_oportunos    = '';
            $date_tardios      = '';
            $date_no_atendidos = '';
            $oportunos         = 0;
            $tardios           = 0;
            $no_atendidos      = 0;
            $por_reasignar     = 0;
            $etapa             = 0;
        // End Variables

        // Step 1.- Tomar los parametros para calcular el estatus de atención
        $param = $this->Cuenta->find('first',array(
            'conditions'=>array(
            'Cuenta.id'=>$data['cuenta_id'],        
            ),
            'fields' => array(
            'Cuenta.paramconfig_id',
            ),
            'contain' => array(
            'Parametros' => array(
                'fields' => array(
                'sla_oportuna',
                'sla_atrasados',
                'sla_no_atendidos',
                )
            ),
            )
        ));

        // Step 2.- Filtros disponibles para el query
            // * Obligatorios
            array_push($and, array('Cliente.cuenta_id'          => $data['cuenta_id'] ));                                       // Por cuenta.
            array_push($and, array('Cliente.status'             => 'Activo' ));                                                 // Por estatus de cliente.
            array_push($and, array('Cliente.etapa'              => $data['etapa'] ));                                           // Por etapa.
            // array_push($and, array('Cliente.status'             => 'Activo' ));                                                 // Por estatus de etapa.

            // Opcionales.
            if( !empty($data['nombre']) ){ array_push($and, array('Cliente.nombre LIKE "%'.$data['nombre'].'%"')); }            // Nombre de cliente
            if( !empty($data['user_id']) ){ array_push($and, array('Cliente.user_id' => $data['user_id'])); }else{ array_push($and, array('Cliente.user_id IS NOT NULL ' )); }                   // Asesor
            
            if( !empty($data['desarrollo_id']) ){                                                                               // Desarrollo_id
                array_push($or,
                    array(
                        'Cliente.desarrollo_id' => $data['desarrollo_id'],
                    )
                );
            }

            if( !empty($data['rango_fechas']) ) {                                                                                        // Rango de fechas
                $fecha_ini = substr($data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d HⓂ️s',  strtotime($fecha_ini));
                $ff = date('Y-m-d HⓂ️s',  strtotime($fecha_fin));
    
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
                }
                array_push($and, $cond_rangos);
    
            }
        // End step 2.

        $condiciones = array(
            'AND' => $and,
            'OR'  => $or
            );

        // Step 3.- Consulta a la base de datos.
        $clientes = $this->Cliente->find('all',
            array(
                'conditions' => $condiciones,
                'order'   => 'Cliente.nombre ASC',
                'fields' => array(
                    'Cliente.id',
                    'Cliente.nombre',
                    'Cliente.created',
                    'Cliente.last_edit',
                    'Cliente.fecha_cambio_etapa',
                    'Cliente.etapa',
                    'Cliente.correo_electronico',
                    'Cliente.telefono1',
                ),
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'nombre_completo'
                        )
                    ),
                    'Desarrollo' => array(
                        'fields' => array(
                            'nombre'
                        )
                    ),
                    'Inmueble' => array(
                        'fields' => array(
                            'referencia'
                        )
                    ),
                    'MisOperaciones' => array(
                        'fields' => array(
                            'inmueble_id',
                        ),
                        'order' => array( 'id' => 'DESC'),
                        'limit' => 1
                    ),
                    'Lead' => array(
                        'fields' => array(
                            'desarrollo_id',
                            'inmueble_id',
                        )
                    )
                ),
                // 'limit' => 10
            )
        );


        return $clientes;


    }

    /* -------------- Metodo grafica clientes_activos_etapa_by_ajax ------------- */
    public function clientes_activos_etapa_by_ajax(){
        $response = [];

        if( $this->request->is('post') ){

            $etapa_1 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 1 ), 'contain' => false, 'fields' => array('nombre') ));
            $etapa_2 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 2 ), 'contain' => false, 'fields' => array('nombre') ));
            $etapa_3 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 3 ), 'contain' => false, 'fields' => array('nombre') ));
            $etapa_4 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 4 ), 'contain' => false, 'fields' => array('nombre') ));
            $etapa_5 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 5 ), 'contain' => false, 'fields' => array('nombre') ));
            $etapa_6 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 6 ), 'contain' => false, 'fields' => array('nombre') ));
            $etapa_7 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->request->data['cuenta_id'], 'orden' => 7 ), 'contain' => false, 'fields' => array('nombre') ));

            $response = array(
                '0' => array(
                  'estado'   =>  $etapa_7['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 7, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                ),
                '1' => array(
                  'estado'   => $etapa_6['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 6, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                ),
                '2' => array(
                  'estado'   => $etapa_5['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 5, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                ),
                '3' => array(
                  'estado'   =>$etapa_4['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 4, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                ),
                '4' => array(
                  'estado'   =>  $etapa_3['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 3, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                ),
                '5' => array(
                  'estado'   => $etapa_2['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 2, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                ),
                
                '6' => array(
                  'estado'   => $etapa_1['DicEmbudoVenta']['nombre'],
                  'cantidad' => count($this->log_etapas_embudo_ventas( array( 'cuenta_id' => $this->request->data['cuenta_id'], 'desarrollo_id' => substr($this->request->data['desarrollo_id'], 1,3), 'etapa' => 1, 'rango_fechas' => $this->request->data['rango_fechas']) )),
                  //'color'    => '#ceeefd'
                ),
            );
        }

        
        echo json_encode( $response );
        exit();

        $this->autoRender = false;

    }

    /**
     * 
     * SAAK - 25 oct 2022.
     * 1.- Validacion de etapas 1 a la 5 fecha de creación.
     * 2.- Los clientes que tengan etapa 6 o 7, ya no se debera registrar en el embudo de ventas actual.
     * 3.- Para las etapas 6 y 7 tenemos que consultar la fecha en la que se realizo la venta para esa ponerla en el cambio de etapas.
     * 4.- Validar que no tengamos el registro en la tabla de log clientes etapas.
     * 
    */
    function list_new_clientes_etapas($cuanta_id=null){
        $this->layout = 'blank';
        $encontrados  = [];
        $etapaEnVenta = 0;
        $this->Cliente->Behaviors->load('Containable');

        $data = array(
            'cuenta_id' =>$cuanta_id
        );

        $clientes = $this->Cliente->find('all', array(
            'conditions' => array(
                'Cliente.cuenta_id' => $data['cuenta_id'],
                'Cliente.status'    => 'Activo',
                'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$data['cuenta_id'].')',
                'Cliente.etapa <= ' => '5'
            ),
            'contain' => false,
                'fields'    => array(
                'Cliente.id',
                'Cliente.nombre',
                'Cliente.created',
                'Cliente.etapa',
                'Cliente.status',
                'Cliente.desarrollo_id',
                'Cliente.inmueble_id',
                'Cliente.user_id',
            ),
        ));

        foreach( $clientes as $clienteEtapa ){
            // Validar que el id no se encuentre ya registrado.
            $clienteRegistrado = $this->LogClientesEtapa->find('first', array(
                'conditions' => array(
                    'LogClientesEtapa.cliente_id' => $clienteEtapa['Cliente']['id']
                ),
                'order' => array('LogClientesEtapa.status' => 'ASC')
            ));

            if( empty( $clienteRegistrado ) ){
                
                $this->LogClientesEtapa->create();
                $this->request->data['LogClientesEtapa']['id']            = null;
                $this->request->data['LogClientesEtapa']['cliente_id']    = $clienteEtapa['Cliente']['id'];
                $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s', strtotime( $clienteEtapa['Cliente']['created'] ));
                $this->request->data['LogClientesEtapa']['etapa']         = $clienteEtapa['Cliente']['etapa'];
                $this->request->data['LogClientesEtapa']['desarrollo_id'] = ( (empty($clienteEtapa['Cliente']['desarrollo_id']) ? 0 : $clienteEtapa['Cliente']['desarrollo_id']) );
                $this->request->data['LogClientesEtapa']['inmuble_id']    = ( (empty($clienteEtapa['Cliente']['inmueble_id']) ? 0 : $clienteEtapa['Cliente']['inmueble_id']) );
                $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                $this->request->data['LogClientesEtapa']['user_id']       = $clienteEtapa['Cliente']['user_id'];

                if( $this->LogClientesEtapa->save($this->request->data) ){
                    // array_push($encontrados, array(
                    //     'Validacion' => 'El cliente se registro correctamente en la tabla de LogClientesEtapa',
                    //     'idCliente'  => $clienteEtapa['Cliente']['id'],
                    //     'nombre'     => $clienteEtapa['Cliente']['nombre'],
                    //     'etapa'      => $clienteEtapa['Cliente']['etapa'],
                    //     'status'     => $clienteEtapa['Cliente']['status'],
                    // ));
                }else{
                    array_push($encontrados, array(
                        'Validacion' => 'No se registro el cliente en la tabla de LogClientesEtapa',
                        'idCliente'  => $clienteEtapa['Cliente']['id'],
                        'nombre'     => $clienteEtapa['Cliente']['nombre'],
                        'etapa'      => $clienteEtapa['Cliente']['etapa'],
                        'status'     => $clienteEtapa['Cliente']['status'],
                    ));
                }


            }else{


                // Validar, en que tapa se encuentra ese cliente, si se encuentra en una etapa posterior a la 
                // y se debe tener un registro de la venta, si no lo tiene eliminamos el registro de de logClientesEtapa
                // y lo hacemos el nuevo registro con la etapa que se muestra en el cliente.
                //             SI
                // el cliente si tiene registro de la venta, se revisa la venta o el apartado y se le asigna el registro con la
                // fecha de cambio de etapa, en caso de que sea apartado o venta.

                $clienteVenta = $this->OperacionesInmueble->find('first', array(
                    'conditions' => array(
                        'OperacionesInmueble.cliente_id' => $clienteEtapa['Cliente']['id'],
                        'OperacionesInmueble.status'     => 'Activo'
                    ),
                    'fields' => array(
                        'OperacionesInmueble.id',
                        'OperacionesInmueble.cliente_id',
                        'OperacionesInmueble.fecha',
                        'OperacionesInmueble.tipo_operacion',
                        'OperacionesInmueble.cliente_id',
                        'OperacionesInmueble.user_id',
                        'OperacionesInmueble.inmueble_id',
                        'OperacionesInmueble.status',
                    )
                ));

                if( !empty( $clienteVenta ) ){

                    switch( $clienteVenta['OperacionesInmueble']['tipo_operacion'] ){
                        case 2: // Apartado
                            $etapaEnVenta = 6;
                            break;
                        case 3: // Apartado
                            $etapaEnVenta = 6;
                            break;
                        default:
                            $etapaEnVenta = 00;
                            break;
                    }

                    $this->request->data['LogClientesEtapa']['id']            = null;
                    $this->request->data['LogClientesEtapa']['cliente_id']    = $clienteVenta['OperacionesInmueble']['cliente_id'];
                    $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d', strtotime( $clienteVenta['OperacionesInmueble']['fecha'] )).' 00:00:00';
                    $this->request->data['LogClientesEtapa']['etapa']         = $etapaEnVenta;
                    $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
                    $this->request->data['LogClientesEtapa']['inmuble_id']    = $clienteVenta['OperacionesInmueble']['inmueble_id'];
                    $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                    $this->request->data['LogClientesEtapa']['user_id']       = $clienteVenta['OperacionesInmueble']['user_id'];
                    $this->LogClientesEtapa->save();


                    if( $this->LogClientesEtapa->save() ){
                        array_push($encontrados, array(
                            'Validacion'  => 'Tuvo problemas al registrar en el logClientesEtapa pero si esta su registro en la tabla de OperacionesInmueble',
                            'operacionId' => $clienteVenta['OperacionesInmueble']['id'],
                            'idCliente'   => $clienteVenta['OperacionesInmueble']['cliente_id'],
                            'etapa'       => $etapaEnVenta,
                            'status'      => $clienteVenta['OperacionesInmueble']['status'],
                        ));
                    }


                }else{

                    // Si esta en el log de clientes pero no tiene venta, ni apartado, se regresara a la etapa 5, junto con la correccion de etapa.
                    $etapasCliente = $this->LogClientesEtapa->find('all', array(
                        'conditions' => array(
                            'LogClientesEtapa.cliente_id' => $clienteEtapa['Cliente']['id']
                        )
                    ));

                    foreach( $etapasCliente as $logEtapasCliente ){
                        $this->LogClientesEtapa->query("DELETE FROM log_clientes_etapas WHERE cliente_id = ".$logEtapasCliente['LogClientesEtapa']['cliente_id']."");
                    }
                    
                    $this->request->data['LogClientesEtapa']['id']            = null;
                    $this->request->data['LogClientesEtapa']['cliente_id']    = $clienteEtapa['Cliente']['id'];
                    $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d', strtotime( $clienteEtapa['Cliente']['created'] )).' 00:00:00';
                    $this->request->data['LogClientesEtapa']['etapa']         = 5;
                    $this->request->data['LogClientesEtapa']['desarrollo_id'] = $clienteEtapa['Cliente']['desarrollo_id'];
                    $this->request->data['LogClientesEtapa']['inmuble_id']    = $clienteEtapa['Cliente']['inmueble_id'];
                    $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                    $this->request->data['LogClientesEtapa']['user_id']       = $clienteEtapa['Cliente']['user_id'];
                    
                    if( $this->LogClientesEtapa->save() ){
                        array_push($encontrados, array(
                            'Validacion' => 'No encontrado en la tabla de operaciones. pero tiene registro en la tabla de logClientesEtapa pero no se pudo agregar a LogClientesEtapa por alguna extraña razón',
                            'idCliente'  => $clienteEtapa['Cliente']['id'],
                            'nombre'     => $clienteEtapa['Cliente']['nombre'],
                            'etapa'      => $clienteEtapa['Cliente']['etapa'],
                            'status'     => $clienteEtapa['Cliente']['status'],
                        ));
                    }

                    
                }

            }


        }
        
        echo count( $encontrados );
        echo "<pre>";
            print_r( $encontrados );
        echo "</pre>";

        $this->autoRender = false;


    }
    /**
     * Aka - RogueOne
     * Fecha: 13/feb/2022
     * corraccion de los inmuhebles sin desarrollo solo con la etapa 6 y 7 
    */
    function log_cliente_desarrollo_id(){
        $this->loadModel('Desarrollo');
        $this->loadModel('DesarrolloInmueble');
        $this->LogClientesEtapa->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $response = [];
        $etapa=0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $clientes_id=$this->LogClientesEtapa->find('all',array(
            'conditions'=>array(
                'LogClientesEtapa.etapa ' =>$etapa,
                'LogClientesEtapa.desarrollo_id' =>0,
            ),
            'fields' => array(
                'LogClientesEtapa.id',
                'LogClientesEtapa.cliente_id',
                'LogClientesEtapa.desarrollo_id',
                'LogClientesEtapa.inmuble_id',
            ),
            'contain' => false 
            )
        );
        $i=0;
        foreach ($clientes_id as  $value) {
            $search_desarrollo_id=$this->DesarrolloInmueble->find('first',array(
                'conditions'=>array(
                    'DesarrolloInmueble.inmueble_id'=>$value['LogClientesEtapa']['inmuble_id']
                ),
                'fields' => array(
                    'DesarrolloInmueble.desarrollo_id'
                ),
                'contain' => false 
                )
            );
            $response[$i]['seguarda']=$value['LogClientesEtapa']['id'];
            $response[$i]['notiene']=$value['LogClientesEtapa']['desarrollo_id'];
            $response[$i]['poreste']=$search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
            $i++;
            // $this->request->data['LogClientesEtapa']['id']            = $value['LogClientesEtapa']['id'];
            // $this->request->data['LogClientesEtapa']['desarrollo_id'] = $search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
            // $this->LogClientesEtapa->save($this->request->data);


            if ($search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'] != null) {

                $query = $this->LogClientesEtapa->query(
                    "update log_clientes_etapas 
                    SET log_clientes_etapas.desarrollo_id = ".$search_desarrollo_id['DesarrolloInmueble']['desarrollo_id']."
                    WHERE log_clientes_etapas.id = ".$value['LogClientesEtapa']['id']."
                    AND log_clientes_etapas.etapa= ".$etapa."
                    AND log_clientes_etapas.cliente_id= ".$value['LogClientesEtapa']['cliente_id'].";"
                );
            }

        }

        echo json_encode( $response );
        exit();

        $this->autoRender = false;

    }




}
