<?php
    App::uses('AppController', 'Controller');

    class ConexionesExternsController extends AppController {

        public $uses = array(

            'ConexionesExtern','Cliente','Inmueble','Agenda','Lead','Opcionador','Desarrollo',
            'User','Contacto','Event','DicTipoCliente','DicEtapa',
            'DicLineaContacto','LogCliente','DicTipoPropiedad','LogDesarrollo','LogInmueble','Mailconfig',
            'Venta','Transaccion', 'Factura','MailConfig', 'Paramconfig', 'Cuenta', 'CuentasUser', 'Cp', 'DicRazonInactivacion', 'DicEmbudoVenta', 'LogClientesEtapa', 'Cotizacion'
    );
        /* --------------------------------------------------------------------------
        * Metodo para agregar conexiones.
        * AKA SaaK 12-Sep-2022.
        * Por el momento esta optimizado para la conexión con Mappen.
        -------------------------------------------------------------------------- */
        public function addMappen(){
            sleep(2);
            $response = [];
            // Asignamos el vaalor que debe tener el request
            $this->request->data['ConexionesExtern'] = $this->request->data['AddConexionesExtern'];
            // Step 3.- Si NO existe la conexion guardamos una nueva.
            // Step 3.- Vamos a poner el formulario
            
            // Step 1.- Validar que la conexion no exista en la base de datos.
            if( $this->request->is('post') ){
                
                $search = $this->ConexionesExtern->find('first', array(
                    'conditions' => array(
                        'ConexionesExtern.cuenta_id'    => $this->Session->read('CuentaUsuario.Cuenta.id'),
                        'ConexionesExtern.key_exterior' => $this->request->data['ConexionesExtern']['key_exterior']
                    )
                ));
                    
                    
                // Step 2.- Si existe la conexión hay que editarla.
                if( count($search) > 0 ){ // Editamos la conexión existente.
                    
                    $this->request->data['ConexionesExtern']['status']            = 1;
                    $this->ConexionesExtern->save($this->request->data);
                    $response['message'] = 'Se ha vinculado correctamente.';
                    $response['flag']     = true;

                }else{ // Guardamos la nueva conexión.

                    $this->ConexionesExtern->create();
                    $this->request->data['ConexionesExtern']['cuenta_id']         = $this->Session->read('CuentaUsuario.Cuenta.id');
                    $this->request->data['ConexionesExtern']['end_point']         = $this->request->data['ConexionesExtern']['end_point'];
                    $this->request->data['ConexionesExtern']['fecha_vinculacion'] = date('Y-m-d');
                    $this->request->data['ConexionesExtern']['id_externo']        = uniqid();
                    $this->request->data['ConexionesExtern']['nombre_externo']    = 'Mappen';
                    $this->request->data['ConexionesExtern']['key_exterior']      = $this->request->data['ConexionesExtern']['key_exterior'];
                    $this->request->data['ConexionesExtern']['status']            = 1;
                    $this->ConexionesExtern->save($this->request->data);

                    $response['message'] = 'Se ha guardado correctamente la conexión.';
                    $response['flag']     = true;

                }

            }
            
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash($response['message'], 'default', array(), 'm_success'); // Mensaje

            echo json_encode( $response , true );
            $this->autoRender = false;

        }

        /* --------------------------------------------------------------------------
        * Metodo para deshabilitar la conexión con Mappen.
        * AKA SaaK 12-Sep-2022.
        * Por el momento esta optimizado para la conexión con Mappen.
        -------------------------------------------------------------------------- */
        public function disabled(){
            sleep(2);
            $response = array(
                'message' => "Ocurrioo un problema favor de reportarlo con el administrador",
                'flag'    => false

            );

            if( $this->request->is('post') ){
                
                $this->request->data['ConexionesExtern']['id']     = $this->request->data['DisabledConexionesExtern']['id'];
                $this->request->data['ConexionesExtern']['status'] = 0;
                
                if($this->ConexionesExtern->save($this->request->data)){
                    $response['message'] = 'Se ha desvinculado correctamente.';
                    $response['flag'] = true;
                }

            }

            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash($response['message'], 'default', array(), 'm_success');

            echo json_encode( $response , true );
            $this->autoRender = false;

        }
        /**
         * 
         * 
         * 
        */
        function facebook_tokens(){
            header('Content-type: application/json; charset=utf-8');
            $this->ConexionesExtern->Behaviors->load('Containable');
            $response=array();

            if( $this->request->is('post') ){
                $token= $this->request->data['token'];
                $nombre_desarrollo= $this->request->data['desarrollo_name'];
                $cuenta_id= $this->request->data['cuenta_id'];
                $search=$this->ConexionesExtern->find('all',
                    array(
                        'conditions'=>array(     
                            'ConexionesExtern.cuenta_id' => $cuenta_id,
                        ),
                        'fields' => array(
                            'ConexionesExtern.cuenta_id',
                        ),
                        'contain' => false 
                        )
                );
                // Step 2.- Si existe la conexión hay que editarla.
                if( $search[0]['ConexionesExtern']['cuenta_id']== $cuenta_id ){ // Editamos la conexión existente.

                    // $this->ConexionesExtern->query(
                    //     "UPDATE conexiones_externs 
                    //     SET cuenta_id = $cuenta_id, 
                    //     key_exterior=$token,
                    //     nombre_externo='Actualizado' ,
                    //     nombre= $nombre_desarrollo,
                    //     WHERE cliente_id = $cliente_id "
                    // );
                    
                    // $this->request->data['ConexionesExtern']['cuenta_id']         = $cuenta_id;
                    // $this->request->data['ConexionesExtern']['key_exterior']      = $token;
                    // $this->request->data['ConexionesExtern']['id_externo']        = uniqid();
                    // $this->request->data['ConexionesExtern']['nombre_externo']    = 'Actualizado';
                    // $this->request->data['ConexionesExtern']['nombre']            = $nombre_desarrollo;
                    // $this->request->data['ConexionesExtern']['fecha_vinculacion'] = date('Y-m-d H: i: s');
                    // $this->request->data['ConexionesExtern']['status']            = 1;
                    // $this->ConexionesExtern->save($this->request->data);

                }else{ // Guardamos la nueva conexión.

                    $this->ConexionesExtern->create();
                    $this->request->data['ConexionesExtern']['cuenta_id']         = null;
                    $this->request->data['ConexionesExtern']['end_point']         = null;
                    $this->request->data['ConexionesExtern']['fecha_vinculacion'] = date('Y-m-d');
                    $this->request->data['ConexionesExtern']['id_externo']        = uniqid();
                    $this->request->data['ConexionesExtern']['nombre_externo']    = 'facebook';
                    $this->request->data['ConexionesExtern']['nombre']            = $nombre_desarrollo;
                    $this->request->data['ConexionesExtern']['key_exterior']      = $token;
                    $this->request->data['ConexionesExtern']['status']            = 1;
                    $this->ConexionesExtern->save($this->request->data['ConexionesExtern']);

                    $response['message'] = 'Se ha guardado correctamente la conexión.';
                    $response['flag']     = true;

                }


                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash($response['message'], 'default', array(), 'm_success'); // Mensaje
                echo json_encode( $search , true );
                exit();
                $this->autoRender = false;

            }

        }
        /**
         * 
         * 
         * 
        */
        function limpiesa(){
            header('Content-type: application/json; charset=utf-8');
            $this->loadModel('Desarrollo');
            $this->Desarrollo->Behaviors->load('Containable');
            $i=0;
            $clientes=$this->request->data['clientes'];
            $response=array();
            $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
            $search_desarrolo=$clientes['clientes'][0][0]['values'];
            $desarrollos = $this->Desarrollo->find('list',array(
                'conditions'=>array(
                        'Desarrollo.cuenta_id IN('.$cuenta_id.')'
                    ),
                    'fields'=>array(
                        'id'
                    ),
                    'contain'=>false
                )
            );
            foreach ($desarrollos as  $desarrollo) {
                if ($desarrollo == $search_desarrolo[0]) {
                    foreach ($clientes as $cliente) {
                        foreach ($cliente as $value) {

                            $response[$i]['dasarrollo']=$value[0]['values'][0];
                            $response[$i]['nombre']=$value[1]['values'][0];
                            $response[$i]['email']=$value[2]['values'][0];
                            $response[$i]['phon']=$value[3]['values'][0];

                            // $response[$i]['email'] = ( !strstr($value[1]['values'][0], '@') ? $value[1]['values'][0]  : !strstr($value[2]['values'][0], '@') ? $value[2]['values'][0] :  !strstr($value[3]['values'][0], '@') ? $value[3]['values'][0] );



                            // if ( !strstr( $value[1]['values'][0], '@' ) ) {
                            //     $response[$i]['email']=$value[1]['values'][0];
                            //     $response[$i]['nombre']=$value[2]['values'][0];
                            // }  else{

                            //     $response[$i]['nombre']=$value[1]['values'][0];
                            // }  
                            // if ( !strstr( $value[2]['values'][0], '@' ) ) {
                                
                            //     $response[$i]['phon']=$value[2]['values'][0];
                            //     $response[$i]['email']=$value[3]['values'][0];

                            // }else {
                                
                            //     $response[$i]['phon']=$value[3]['values'][0];
                            //     $response[$i]['email']=$value[2]['values'][0];

                            // }
                            $i++;

                        }
                    }
                }
            }
            $i=0;
            if ( !empty($response) ) {
                foreach ($response as  $value) {
                    $params_cliente[$i][implode((array_keys($this->is_validate( $value['nombre'] ))))] = implode($this->is_validate( $value['nombre'] ));
                    $params_cliente[$i][implode((array_keys($this->is_validate( $value['phon'] ))))]   = implode($this->is_validate( $value['phon'] ));
                    $params_cliente[$i][implode((array_keys($this->is_validate( $value['email'] ))))]  = implode($this->is_validate( $value['email'] ));
                    $params_cliente[$i]['telefono2']                                           = '';
                    $params_cliente[$i]['telefono3']                                           = '';
                    $params_cliente[$i]['tipo_cliente']                                        = 1;
                    $params_cliente[$i]['propiedades_interes']                                 = 'D'.$value['dasarrollo'];
                    $params_cliente[$i]['forma_contacto']                                      = 43;
                    $params_cliente[$i]['comentario']                                          = 'Agregado desde facebook';
                    $params_cliente[$i]['asesor_id']                                           = '';

                    $params_user[$i] = array(
                        'user_id'              => 1,
                        'cuenta_id'            => $cuenta_id,
                        'notificacion_1er_seg' => $this->Session->read('Parametros.Paramconfig.not_1er_seg_clientes'),
                    );
                    
                    $roberto[$i]= $this->add_cliente(  $params_cliente[$i], $params_user[$i]);
                  
                    $i++;                    
                }
            } 
            $i=0;
     

            // foreach ($params_cliente as  $value) {     

            //     $this->add_cliente(  $value, $params_user[$i]);
            //     $i++;
            // }
            echo json_encode( $roberto , true );
            exit();
            $this->autoRender = false;
        }

            
        /**
         * 
         * 
        */
        public function is_validate( $campo ){

            $response = array(
                'nombre' => $campo
            );

            if( strstr( $campo, '@' ) ){
                $response = array(
                    'correo_electronico' => $campo
                );
            }

            if( is_numeric( $campo ) ){
                $response = array(
                    'telefono1' => substr($campo,-10),
                );
            }

            return $response;
            $this->autoRender = false;
        }
        /**
         * Metodo para agregar un cliente. 
         * Esta pensando en forma de objeto para reutilizarlo para la app.
         * Se agrega el 9no paso para agregar el log del cliente.
         * Cambio el 29 Sep 2022 AKA - Saak.
         * 
        */
        function add_cliente( $params_cliente = null, $params_user = null ){
            date_default_timezone_set('America/Mexico_City');

            $this->Inmueble->Behaviors->load('Containable');
            $this->Desarrollo->Behaviors->load('Containable');
            $this->DicLineaContacto->Behaviors->load('Containable');
            $this->Cliente->Behaviors->load('Containable');
            $cliente_id =0;
            $data_add_prospeccion = array();
            $inmueble_interesado   = 0;   // Varibale para guardar los id's inmuebles interesados.
            $desarrollo_interesado = 0;   // Variable para guardar los id's de los desarrollos interesados
            $conditions_cliente    = [];
            $nombre_prop_interes   = [];
            
            // Paso 1.- Revisar si se dara de alta por correo o telefono.
            if( $params_cliente['correo_electronico'] != '' &&  $params_cliente['telefono1'] != ''){
            
                $conditions_cliente = array( 
                    'and' => array(
                    'Cliente.cuenta_id'          => $params_user['cuenta_id'],
                    ),
                    'or' => array(
                    'Cliente.telefono1'          => $params_cliente['telefono1'],
                    'Cliente.correo_electronico' => $params_cliente['correo_electronico'],
                    ) 
                );

                // Seteo de variables para guardarlos en la bd
                $data_3_cliente = array(
                    'correo_electronico' => $params_cliente['correo_electronico'],
                    'telefono1'          => $params_cliente['telefono1']
                );

            }else if( $params_cliente['correo_electronico'] != '' ){
            
                $conditions_cliente = array(
                    'Cliente.correo_electronico' => $params_cliente['correo_electronico'],
                    'Cliente.cuenta_id'          => $params_user['cuenta_id']
                );
                
                // Seteo de variables para guardarlos en la bd
                $data_3_cliente = array(
                    'correo_electronico' => $params_cliente['correo_electronico'],
                    'telefono1' => 'Sin teléfono'
                );

            }else if( $params_cliente['telefono1'] != '' ){
            
                $conditions_cliente = array(
                    'Cliente.telefono1' => $params_cliente['telefono1'],
                    'Cliente.cuenta_id' => $params_user['cuenta_id']
                );

                // Seteo de variables para guardarlos en la bd
                $data_3_cliente = array(
                    'telefono1'          => $params_cliente['telefono1'],
                    'correo_electronico' => 'Sin correo'
                );

            }

            // Paso 2.- Revisar si existe el cliente.
            $cliente = $this->Cliente->find('first', array( 'conditions' => $conditions_cliente, 'fields'=>'id','contain' => false  ) ); // Consulta del cliente en la bd.

            if(  empty($cliente)){ // No existe el cliente, GUARDAR

                // Paso 3.- Seteo de variables para guardar los datos.
                // Si existe una asignacion de asesor al cliente, se registra la fecha de asignacion y la fecha de ultima edición.
                if( !empty( $params_cliente['asesor_id'] ) ){
                    $this->request->data['Cliente']['asignado']   = date('Y-m-d H:i:s');
                    $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:i:s');
                }
            
                $this->request->data['Cliente']['created']               = date('Y-m-d H:i:s');
                $this->request->data['Cliente']['nombre']                = $params_cliente['nombre'];
                $this->request->data['Cliente']['correo_electronico']    = $data_3_cliente['correo_electronico'];
                $this->request->data['Cliente']['telefono1']             = $data_3_cliente['telefono1'];
                $this->request->data['Cliente']['dic_tipo_cliente_id']   = $params_cliente['tipo_cliente'];
                $this->request->data['Cliente']['status']                = 'Activo';
                $this->request->data['Cliente']['etapa_comercial']       = 'CRM';
                $this->request->data['Cliente']['etapa']                 = 1;
                $this->request->data['Cliente']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
                $this->request->data['Cliente']['cuenta_id']             = $params_user['cuenta_id'];
                $this->request->data['Cliente']['comentarios']           = $params_cliente['comentario'];
                $this->request->data['Cliente']['user_id']               = $params_cliente['asesor_id'];
                $this->Cliente->create();
                // $this->Cliente->save( $this->request->data);
                // 4.- Salvado del cliente.
                if ( $this->Cliente->save( $this->request->data ) ) {

                    $cliente_id = $this->Cliente->getInsertID(); // Guarda en la variable el id del cliente salvado.
                    
                    // Paso 5.- Guardar en log del cliente y el seguimiento rapido, que se ha creado el cliente.
                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         =  uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
                    $this->request->data['LogCliente']['user_id']    = $params_user['user_id'];
                    $this->request->data['LogCliente']['mensaje']    = "Cliente creado desde facebook";
                    $this->request->data['LogCliente']['accion']     = 1;
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data['LogCliente']);
                    
                    // Paso 6 guardar en la tabla de  desarrollos, dependiendo cual sea el id de la propiedad que se intereso.
      
                    $desarrollo_id                                         = substr($params_cliente['propiedades_interes'], 1);

                    $this->LogDesarrollo->create();
                    $this->request->data['LogDesarrollo']['mensaje']       = "Envío de desarrollo a cliente desde facebook: ".$params_cliente['nombre'];
                    $this->request->data['LogDesarrollo']['usuario_id']    = $params_user['user_id'];
                    $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
                    $this->request->data['LogDesarrollo']['accion']        = 5;
                    $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_id;
                    $this->LogDesarrollo->save($this->request->data);
                    
                    
                    $this->Lead->create();
                    $this->request->data['Lead']['cliente_id']            = $cliente_id;
                    $this->request->data['Lead']['status']                = 'Abierto';
                    $this->request->data['Lead']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
                    $this->request->data['Lead']['desarrollo_id']         = $desarrollo_id;
                    $this->request->data['Lead']['tipo_lead']             = 1;
                    $this->request->data['Lead']['fecha']                 = date('Y-m-d h:i:s');
                    $this->Lead->save($this->request->data);

                    $desarrollo_interesado = $desarrollo_id;

                    // Sacamos los parametros del interes del cliente de la propiedad seleccionada.
                    $desarrollo = $this->Desarrollo->find('first',
                        array(
                        'conditions' => array( 'Desarrollo.id' => $desarrollo_id ),
                        'fields'     => array(
                            'Desarrollo.nombre',
                            'Desarrollo.ciudad',
                            'Desarrollo.delegacion',
                            'Desarrollo.colonia'
                        ),
                        'contain'    => false
                        )
                    );

                    $nombre_prop_interes = $desarrollo['Desarrollo']['nombre'];
                    // $data=null;
                    // Se agrega el guardar la informacion de la propiedad en el interes del cliente.
                    $data_add_prospeccion = array(
                        'cliente_id'                 => $cliente_id,
                        'user_id'                    => $params_user['user_id'],
                        'operacion_prospeccion'      => 'Venta (Entrega Inmediata)',
                        'tipo_propiedad_prospeccion' => 'Departamento',
                        'ciudad_prospeccion'         => $desarrollo['Desarrollo']['delegacion'],
                        'estado_prospeccion'         => $desarrollo['Desarrollo']['ciudad'],
                        'colonia_prospeccion'        => $desarrollo['Desarrollo']['colonia'],
                        'zona_prospeccion'           => '',
                    );
                    // $data=$data_add_prospeccion;
                    // $this->editInformacionProspeccion( $data );
                    

                    $dic_linea_contacto = $this->DicLineaContacto->find('first',
                        array(
                            'conditions' => array( 'DicLineaContacto.id' => $params_cliente['forma_contacto'] ),
                            'fields'     => 'DicLineaContacto.linea_contacto',
                            'contain'    => false
                        )
                    );

                    $forma_contacto = $dic_linea_contacto['DicLineaContacto']['linea_contacto'];

                    // Registrar Seguimiento Rápido
                    $this->Agenda->create();
                    $this->request->data['Agenda']['user_id']        = $params_user['user_id'];
                    $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
                    $this->request->data['Agenda']['mensaje']        = "Cliente creado por usuario ".$asesor['User']['nombre_completo']." solicita información de ".$nombre_prop_interes." vía FACEBOOK";
                    $this->request->data['Agenda']['cliente_id']     = $cliente_id;
                    $this->Agenda->save($this->request->data);

                    // // Paso 7.- Actualizar el registro del cliente, con el id del desarrollo o el inmueble de interes.
                    $this->Cliente->query("UPDATE clientes SET desarrollo_id = $desarrollo_interesado, inmueble_id = null  WHERE id = $cliente_id ");

                    // Paso 8.- Notificacion por correo a Asesor y a Gerentes de la creación y asignación de un nuevo cliente.
                    // $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE cliente_id = $cliente_id)")));
                   

                    $usuario     = $this->User->read(null, $params_user['asesor_id']);
                    //$usuario     = $this->User->read(null, 447);
                    
                    $cuenta      = $this->Cuenta->findFirstById( $params_user['cuenta_id']);
                    $mailconfig  = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id'] );
                    $paramconfig = $this->Paramconfig->findFirstById( $cuenta['Cuenta']['paramconfig_id'] );
                
                    // Paso 9.- Guardamos en el log de cliente de las etapas, la entrada numero 1 para el embudo de clientes.
                    // Se agrega como primer entrada en el log la etapa 1 del cliente de forma automatica.
                    $this->LogClientesEtapa->create();
                    $this->request->data['LogClientesEtapa']['cliente_id']   = $cliente_id;
                    $this->request->data['LogClientesEtapa']['fecha']        = date('Y-m-d H:i:s');
                    $this->request->data['LogClientesEtapa']['etapa']        = 1;
                    $this->request->data['LogClientesEtapa']['desarrollo_id'] = $desarrollo_id;
                    $this->request->data['LogClientesEtapa']['inmuble_id']   = 0;
                    $this->request->data['LogClientesEtapa']['status']       = 'Activo';
                    $this->request->data['LogClientesEtapa']['user_id']      = $params_user['user_id'];
                    $this->LogClientesEtapa->save($this->request->data);


                    
                    $respuesta = array(
                        'respuesta'   => 'Se ha guardado correctamente el cliente.',
                        'bandera'     => true,
                        'cliente_id'  =>  $cliente_id
                    );

                }
               
                
            }else{ // El cliente existe, NO se guarda
            
                $respuesta = array(
                    'respuesta' => 'El cliente ya existe en la base de datos, favor de revisarlo.',
                    'bandera'   => false,
                    'cliente_id'  => $cliente['Cliente']['id']
                );

            }
            
            return $respuesta;

        }
        /* ------------------ Edicion de informacion de prospeccion ----------------- */

        function editInformacionProspeccion( $data ){    
            $this->request->data['Cliente']['id'] = $data['cliente_id'];
            unset($this->request->data['Cliente']['comentarios']);
            unset($this->request->data['Cliente']['etapa']);

            $this->Agenda->create();
            $mensaje = "Se actualiza la información del perfil del cliente: ";
            
            if ( !empty( $data['operacion_prospeccion'] ) ){
            $mensaje = $mensaje.$data['operacion_prospeccion']."/ "; 
            $this->request->data['Cliente']['operacion_prospeccion'] = $data['operacion_prospeccion'];
            }
            if ( !empty( $data['precio_min_prospeccion'] ) ){
            $mensaje = $mensaje."$ de: ".$data['precio_min_prospeccion']." "; 
            $this->request->data['Cliente']['precio_min_prospeccion'] = $data['precio_min_prospeccion'];
            }
            if ( !empty( $data['precio_max_prospeccion'] ) ){
            $mensaje = $mensaje."a: ".$data['precio_max_prospeccion']." MDP / ";
            $this->request->data['Cliente']['precio_max_prospeccion'] = $data['precio_max_prospeccion'] ;
            }
            if ( !empty( $data['forma_pago_prospeccion'] ) ){
            $mensaje = $mensaje.$data['forma_pago_prospeccion']."/ ";
            $this->request->data['Cliente']['forma_pago_prospeccion'] = $data['forma_pago_prospeccion'] ;
            }

            if ( !empty( $data['tipo_propiedad_prospeccion'] ) ){
            $mensaje = $mensaje.$data['tipo_propiedad_prospeccion']."/ ";
            $this->request->data['Cliente']['tipo_propiedad_prospeccion'] = $data['tipo_propiedad_prospeccion'] ;
            }
            if ( !empty( $data['metros_min_prospeccion'] ) ){
            $mensaje = $mensaje."De: ".$data['metros_min_prospeccion']."M2 ";
            $this->request->data['Cliente']['metros_min_prospeccion'] = $data['metros_min_prospeccion'] ;
            }
            if ( !empty( $data['metros_max_prospeccion'] ) ){
            $mensaje = $mensaje."a: ".$data['metros_max_prospeccion']."M2/ ";
            $this->request->data['Cliente']['metros_max_prospeccion'] = $data['metros_max_prospeccion'] ;
            }
            if ( !empty( $data['hab_prospeccion'] ) ){
            $mensaje = $mensaje.$data['hab_prospeccion']."R/ ";
            $this->request->data['Cliente']['hab_prospeccion'] = $data['hab_prospeccion'] ;
            }
            if ( !empty( $data['banios_prospeccion'] ) ){
            $mensaje = $mensaje.$data['banios_prospeccion']."B/ ";
            $this->request->data['Cliente']['banios_prospeccion'] = $data['banios_prospeccion'] ;
            }
            if ( !empty( $data['estacionamientos_prospeccion'] ) ){
            $mensaje = $mensaje.$data['estacionamientos_prospeccion']."E/ ";
            $this->request->data['Cliente']['estacionamientos_prospeccion'] = $data['estacionamientos_prospeccion'] ;
            }
            if ( !empty( $data['amenidades_prospeccion_arreglo'] ) ){
            $amenidades         = "";
            $amenidades_mensaje = "";
            foreach($data['amenidades_prospeccion_arreglo'] as $amenidad):
                $amenidades         = $amenidades.$amenidad.",";
                $amenidades_mensaje = $amenidades_mensaje.$amenidad.", ";
            endforeach;
            $mensaje = $mensaje.$amenidades_mensaje."/ ";
            $this->request->data['Cliente']['amenidades_prospeccion'] = $amenidades;
            }
            
            if ($data['ciudad_prospeccion']!=""){
            $mensaje = $mensaje.$data['estado_prospeccion'].", ".$data['ciudad_prospeccion'].", ".$data['colonia_prospeccion'].", ";
            $this->request->data['Cliente']['estado_prospeccion']  = $data['estado_prospeccion'] ;
            $this->request->data['Cliente']['ciudad_prospeccion']  = $data['ciudad_prospeccion'] ;
            $this->request->data['Cliente']['colonia_prospeccion'] = $data['colonia_prospeccion'] ;
            }

            if ($data['zona_prospeccion']!=""){
            $mensaje = $mensaje.$data['zona_prospeccion'].".";
            $this->request->data['Cliente']['zona_prospeccion'] = $data['zona_prospeccion'] ;
            }
            
            $this->request->data['Agenda']['user_id']    = $data['user_id'];
            $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje']    = $mensaje;
            $this->request->data['Agenda']['cliente_id'] = $data['cliente_id'];
            $this->Agenda->save($this->request->data);



            if ($this->Cliente->save($this->request->data)) {
            $mensaje = 'La información de prospección del cliente se ha guardado exitosamente.';
            $bandera = true;
            }else{
            $mensaje = 'Hubo un error en el metodo de editInformacionProspeccion.';
            $bandera = false;
            }

            $response = array(
            'bandera' => $bandera,
            'mensaje' => $mensaje
            );

            return $response;

        }
        /***
         * 
         * 
        */
        function busqueda_token(){
            header('Content-type: application/json; charset=utf-8');
            $this->ConexionesExtern->Behaviors->load('Containable');
            $response='';
            // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
            $cuenta_id=$this->request->data['cuenta_id'];
            $search=$this->ConexionesExtern->find('all',
                array(
                    'conditions'=>array(     
                        'ConexionesExtern.cuenta_id' => $cuenta_id,
                      ),
                      'fields' => array(
                        'ConexionesExtern.key_exterior',
                      ),
                      'contain' => false 
                    )
            );
            $response= $search[0]['ConexionesExtern']['key_exterior'];
            echo json_encode( $response , true );
            exit();
            $this->autoRender = false;
        }
    }
?>