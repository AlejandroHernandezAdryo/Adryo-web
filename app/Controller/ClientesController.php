<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController {

  // 0=> Cita, 1=> Visita, 2=> Llamada, 3=> Correo, 4=> Reactivacion - Events
  // 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogInmueble
  // 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogDesarrollo

  public $cuenta_id;
  var $opciones_venta = array('Preventa'=>'Preventa','Venta (Entrega Inmediata)'=>'Venta (Entrega Inmediata)','Renta'=>'Renta','Venta / Renta' =>'Venta / Renta');
  var $opciones_minimos = array( '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '+5' => '+5' );

  public $log_cliente_accions = array(
    1  => 'Creación',
    2  => 'Edición',
    3  => 'Mail',
    4  => 'Llamada',
    5  => 'Cita',
    6  => 'Mensaje',
    7  => 'Generación de Lead',
    8  => 'Borrado de venta',
    9  => 'Inactivación definitiva',
    10 => 'Inactivación temporal',
    11 => 'WhatsApp'
  );
  var $opciones_formas_pago = array(
    'Recursos Propios' => 'Recursos Propios', 'Crédito Bancario' => 'Crédito Bancario', 'FOVISSSTE' => 'FOVISSSTE', 'INFONAVIT' => 'INFONAVIT', 'COFINAVIT' => 'COFINAVIT', 'FOVISSSTE + BANCO' => 'FOVISSSTE + BANCO'
  );
  var $opciones_amenidades = array(
    'Centros Comerciales Cercanos' => 'Centros Comerciales Cercanos', 'Escuelas' => 'Escuelas', 'Plazas Comerciales' => 'Plazas  Comerciales', 'Frente a Parque' => 'Frente a Parque', 'Parques Cercanos' => 'Parques Cercanos', 'Alberca descubierta' => 'Alberca descubierta', 'Alberca Techada' => 'Alberca Techada', 'Área de Cine' => 'Área de Cine', 'Área de Juegos' => 'Área de Juegos', 'Área de Juegos Infantiles' => 'Área de Juegos Infantiles', 'Área para fumadores' => 'Área para fumadores', 'Áreas Verdes' => 'Áreas Verdes', 'Asador' => 'Asador', 'Desayunador / Antecomedor' => 'Desayunador / Antecomedor', 'Campo de Golf' => 'Campo de Golf', 'Cancha de Paddle' => 'Cancha de Paddle', 'Cancha de Squash' => 'Cancha de Squash', 'Cancha de Tenis' => 'Cancha de Tenis', 'Cantina / Cava' => 'Cantina / Cava', 'Carril de Nado' => 'Carril de Nado', 'Cocina Integral' => 'Cocina Integral', 'Closet de Blancos' => 'Closet de Blancos', 'Restaurante' => 'Restaurante', 'Fire Pit' => 'Fire Pit', 'Gimnasio' => 'Gimnasio', 'Jacuzzi' => 'Jacuzzi', 'Living' => 'Living', 'Lobby' => 'Lobby', 'Mesa de Boliche' => 'Mesa de Boliche', 'Patio de Servicio' => 'Patio de Servicio', 'Pista de Jogging' => 'Pista de Jogging', 'Play Room / Cuarto de Juegos' => 'Play Room / Cuarto de Juegos', 'Vapor' => 'Vapor', 'Roof Garden' => 'Roof Garden', 'Sala de TV' => 'Sala de TV', 'Salón de Juegos' => 'Salón de Juegos', 'Salón de usos múltiples' => 'Salón de usos múltiples', 'Sauna' => 'Sauna', 'Spa' => 'Spa', 'Sky Garden' => 'Sky Garden', 'Tina de Hidromasaje' => 'Tina de Hidromasaje', 'Business Center' => 'Business Center', 'Cafetería' => 'Cafetería', 'Acceso de discapacitados' => 'Acceso de discapacitados', 'Agua Corriente' => 'Agua Corriente', 'Amueblado' => 'Amueblado', 'Acceso Internet / WiFi' => 'Acceso Internet / WiFi', 'Acceso para Tercera Edad' => 'Acceso para Tercera Edad', 'Aire Acondicionado' => 'Aire Acondicionado', 'Bodega' => 'Bodega', 'Boiler / Calentador de Agua'  => 'Boiler / Calentador de Agua', 'Calefacción' => 'Calefacción', 'CCTV' => 'CCTV', 'Cisterna' => 'Cisterna', 'Conmutador' => 'Conmutador', 'Edificio Inteligente' => 'Edificio Inteligente', 'Edificio LEED' => 'Edificio LEED', 'Elevadores' => 'Elevadores', 'Estacionamiento de visitas'   => 'Estacionamiento de visitas', 'Interfón' => 'Interfón', 'Gas LP' => 'Gas LP', 'Gas Natural' => 'Gas Natural', 'Lavavajillas' => 'Lavavajillas', 'Lavanderia' => 'Lavanderia', 'Línea Telefónica' => 'Línea Telefónica', 'Locales Comerciales' => 'Locales Comerciales', 'Permite Mascotas' => 'Permite Mascotas', 'Planta de Emergencia' => 'Planta de Emergencia', 'Portón Eléctrico' => 'Portón Eléctrico', 'Refrigerador' => 'Refrigerador', 'Sistema Contra Incendios' => 'Sistema Contra Incendios', 'Sistema de Seguridad' => 'Sistema de Seguridad', 'Valet Parking' => 'Valet Parking', 'Vigilancia / Seguridad' => 'Vigilancia / Seguridad', 'Cisterna' => 'Cisterna', 'Área de Lavado' => 'Área de Lavado', 'Iluminación Natural' => 'Iluminación Natural', 'Ventilación Natural' => 'Ventilación Natural'
  );

  
  /* -------------------------------------------------------------------------- */
  /*                             Variables globales                             */
  /* -------------------------------------------------------------------------- */
  var $etapas_cliente = array( 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '' );
  public $components = array('Paginator' );


  public $uses = array(
          'Cliente','Inmueble','Agenda','Lead','Opcionador','Desarrollo',
          'User','Contacto','Event','DicTipoCliente','DicEtapa',
          'DicLineaContacto','LogCliente','DicTipoPropiedad','LogDesarrollo','LogInmueble','Mailconfig',
          'Venta','Transaccion', 'Factura','MailConfig', 'Paramconfig', 'Cuenta', 'CuentasUser', 'Cp', 'DicRazonInactivacion', 'DicEmbudoVenta', 'LogClientesEtapa', 'Cotizacion'
  );

  public function beforeFilter() {
      parent::beforeFilter();

      if ($this->Session->read('CuentaUsuario.Cuenta.id'!= NULL)) {
        $this->Session->write(
          'clundef',
          $this->Cliente->find(
            'count',array(
              'conditions'=>array(
                'AND'=>array(
                  'Cliente.user_id IS NULL',
                  'Cliente.status' => 'Activo'
                ),
                'OR'=>array(
                  'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
                  "Cliente.desarrollo_id IN (SELECT id FROM desarrollos WHERE comercializador_id = ".$this->Session->read('CuentaUsuario.Cuenta.id').")"
                )
              )
            )
          )
        );
      }
      
      $this->Auth->allow(array('eliminar_duplic_alex' , 'reactivar','get_clientes', 'get_clientes_detalle', 'get_log_cliente', 'get_lead_cliente_desarrollo', 'get_lead_cliente_inmueble','get_agenda_cliente', 'clientes_params', 'get_cliente_update', 'get_llamdas_cliente', 'get_add_cliente', 'get_options_props', 'get_status_update', 'get_cambio_temp','add_cliente','validar_linea_contacto', 'set_cambio_estado', 'get_pipeline', 'get_filtro_pipeline', 'filtro_pipeline','getLeadsFacebook','add_cliente_api','showFacebookLeads','add_cliente_fb_api', 'get_cliente_info', 'get_list_etapas', 'get_clientes_info', 'listado_clientes_app', 'set_add_clientes', 'conqr', 'add_cliente_etapa'));

      $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');

      $etapa_1 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 1 ), 'contain' => false, 'fields' => array('nombre') ));
      $etapa_2 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 2 ), 'contain' => false, 'fields' => array('nombre') ));
      $etapa_3 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 3 ), 'contain' => false, 'fields' => array('nombre') ));
      $etapa_4 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 4 ), 'contain' => false, 'fields' => array('nombre') ));
      $etapa_5 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 5 ), 'contain' => false, 'fields' => array('nombre') ));
      $etapa_6 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 6 ), 'contain' => false, 'fields' => array('nombre') ));
      $etapa_7 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $this->cuenta_id, 'orden' => 7 ), 'contain' => false, 'fields' => array('nombre') ));

      // Variables para el nombre de las etapas.
      $this->etapas_cliente[1] = ( !empty($etapa_1['DicEmbudoVenta']['nombre']) ? $etapa_1['DicEmbudoVenta']['nombre'] : '' );
      $this->etapas_cliente[2] = ( !empty($etapa_2['DicEmbudoVenta']['nombre']) ? $etapa_2['DicEmbudoVenta']['nombre'] : '' );
      $this->etapas_cliente[3] = ( !empty($etapa_3['DicEmbudoVenta']['nombre']) ? $etapa_3['DicEmbudoVenta']['nombre'] : '' );
      $this->etapas_cliente[4] = ( !empty($etapa_4['DicEmbudoVenta']['nombre']) ? $etapa_4['DicEmbudoVenta']['nombre'] : '' );
      $this->etapas_cliente[5] = ( !empty($etapa_5['DicEmbudoVenta']['nombre']) ? $etapa_5['DicEmbudoVenta']['nombre'] : '' );
      $this->etapas_cliente[6] = ( !empty($etapa_6['DicEmbudoVenta']['nombre']) ? $etapa_6['DicEmbudoVenta']['nombre'] : '' );
      $this->etapas_cliente[7] = ( !empty($etapa_7['DicEmbudoVenta']['nombre']) ? $etapa_7['DicEmbudoVenta']['nombre'] : '' );



  }
    
  public function cambio_temp(){
            $this->request->data['Cliente']['id']          =  $this->request->data['Cliente']['id'];
            $this->request->data['Cliente']['temperatura'] = $this->request->data['Cliente']['temperatura'];
            $this->Cliente->save($this->request->data);
            $cliente_id = $this->request->data['Cliente']['id'];
            $cliente    = $this->Cliente->read(null,$this->request->data['Cliente']['id']);
            $temp = array(1=>'Frio',2=>'Tibio',3=>'Caliente',4=>'Venta');
            $timestamp = date('Y-m-d H:i:s');
                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']         =  uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Cliente']['id'];
                $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                $this->request->data['LogCliente']['datetime']   = $timestamp;
                $this->request->data['LogCliente']['accion']     = 2;
                $this->request->data['LogCliente']['mensaje']    = "Cliente ".$cliente['Cliente']['nombre']." modifica a temperatura ".$temp[$this->request->data['Cliente']['temperatura']]." el ".date('Y-m-d H:i:s');
                $this->LogCliente->save($this->request->data);
                

                $this->Event->create();
                $this->request->data['Event']['cliente_id']    = $cliente['Cliente']['id'];
                $this->request->data['Event']['user_id']       = $this->Session->read('Auth.User.id');
                $this->request->data['Event']['fecha_inicio']  = date('Y-m-d H:i:s');
                $this->request->data['Event']['fecha_fin']     = $timestamp;
                $this->request->data['Event']['accion']        = 2;
                $this->request->data['Event']['nombre_evento'] = "Cliente ".$cliente['Cliente']['nombre']." modifica a temperatura ".$temp[$this->request->data['Cliente']['temperatura']]." el ".date('Y-m-d H:i:s');;
                $this->Event->save($this->request->data);

                //Registrar Seguimiento Rápido
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                $this->request->data['Agenda']['fecha']      = $timestamp;
                $this->request->data['Agenda']['mensaje']    = "Se modifica la temperatura del cliente a ".$temp[$this->request->data['Cliente']['temperatura']];
                $this->request->data['Agenda']['cliente_id'] = $cliente['Cliente']['id'];
                $this->Agenda->save($this->request->data);

                $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = $cliente_id");
            
            
            // $this->Session->setFlash(__('Se ha cambiado exitosamente la temperatura del cliente.'),'default',array('class'=>'mensaje_exito'));
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha cambiado exitosamente la temperatura del cliente.', 'default', array(), 'm_success'); // Mensaje
            $this->redirect(array('action' => 'view/'.$this->request->data['Cliente']['id']));
  }
 
  /*******************************************************************************
  *
  *   13-02-2019 -    Se modifica la consulta para que sea mas rapida de desplegar
  *                   en la vista - AKA "SaaK";
  ******************************************************************************/
  public function index($tipo = null) {
           
          $tipos_cliente            = [];
          $linea_contactos          = [];
          $users                    = [];
          $list_inmuebles           = [];
          $list_desarrollos         = [];

          $estados                  = array( 1 => 'Interés Preliminar', 2 => 'Comunicación Abierta', 3 => 'Precalificación', 4 => 'Visita', 5 => 'Análisis de Opciones', 6 => 'Validación de Recursos', 7 => 'Cierre');
          
          $status_atencion_clientes = array(0 => 'Oportuna', 1 => 'Tardia',2 => 'No atendido', 3 => 'Por reasignar');
          
          $tipos_cliente            = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
          
          $linea_contactos          = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
          
          $users                    = $this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));
          
          $etapa_clientes           = $this->DicEtapa->find('list',array('conditions' => array('cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')),'order' => array('etapa' => 'ASC')));

          // list_des_prop es un listado de propiedades, se manda el id de grupo de permisos y el id de la cuenta
          $list_des_prop    = $this->list_des_pro( $this->Session->read('Permisos.Group.id'), $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') );
          $list_desarrollos = $list_des_prop['list_desarrollos'];
          $list_inmuebles   = $list_des_prop['list_inmuebles'];
          
          $this->set(compact(
            'estados',
            'tipos_cliente',
            'linea_contactos',
            'users',
            'status_atencion_clientes',
            'list_desarrollos',
            'list_inmuebles',
            'etapa_clientes'
          ));

  }
        
  public function norevisados($id = null){
      if ($this->Session->read('Auth.User.group_id')==5){
              return $this->redirect(array('action' => 'mysession','controller'=>'users'));
      }
      $this->layout = 'bos';
      $this->Cliente->recursive = 0;
      $this->Paginator->settings = array('order'=>'Cliente.id DESC','conditions'=>array('Cliente.first_edit'=>NULL,
                          'Cliente.user_id'=>$id));
      $this->set('clientes', $this->Paginator->paginate());
  }
  
  public function sinseguimiento($id = null){
      if ($this->Session->read('Auth.User.group_id')==5){
              return $this->redirect(array('action' => 'mysession','controller'=>'users'));
      }
      $this->layout = 'bos';
      $this->Cliente->recursive = 0;
      $this->Paginator->settings = array('conditions'=>array('Cliente.last_edit < NOW() - INTERVAL 5 DAY',
                          'Cliente.user_id'=>$id));
      $this->set('clientes', $this->Paginator->paginate());
  }
        
  public function no_atendidos() {
        $this->layout='bos';
        if ($this->request->is('post')) {
                $this->Cliente->recursive = 0;
                $conditions = array();
                $usuarios = array();
                $variable = $this->request->data['Cliente']['campo'];
                $user_id = $this->request->data['Cliente']['user'];
                if (!empty($variable)){
                $conditions = array(
                    'Cliente.nombre LIKE "%'.$variable.'%"',
                    'Cliente.apellido_paterno LIKE "%'.$variable.'%"',
                    'Cliente.apellido_materno LIKE "%'.$variable.'%"',
                    'Cliente.correo_electronico LIKE "%'.$variable.'%"',
                    'Cliente.first_edit'=>NULL
                        );
                }
                if(!empty($user_id)){
                    $usuarios = array('Cliente.user_id'=>$user_id);
                }
                if ($this->Session->read('Auth.User.Group.cown')==1 && $this->Session->read('Auth.User.Group.call')==0){
                    $cond2 = array('Cliente.first_edit'=>NULL,'Cliente.user_id'=>$this->Session->read('Auth.User.id'));
                    $this->Paginator->settings = array('order'=>'Cliente.id DESC','conditions'=> array($cond2,'or'=>$conditions));
                }
                $this->Paginator->settings = array('order'=>'Cliente.id DESC','conditions'=>array($usuarios,'or' => $conditions));
                $this->set('clientes', $this->Paginator->paginate());
                $this->set('users',$this->Cliente->User->find('list'));
            }else{
                $this->Paginator->settings = array(
                    'recursive'=>0,
                    'order'=>'Cliente.created ASC',
                    'conditions'=>array(
                        'Cliente.first_edit'=>NULL
                        )
                    );
                $this->set('clientes',$this->Paginator->paginate());
                $this->set('users',$this->Cliente->User->find('list'));
            }
                
        
  }
    
  public function sendmail(){
          $this->layout='bos';
          if ($this->request->is('post')) {
              
          }else{
              $tipo_viviendas = $this->Contacto->find('all',array('fields'=>'DISTINCT tipo_vivienda','order'=>'tipo_vivienda ASC'));
              $tipo_operaciones = $this->Contacto->find('all',array('fields'=>'DISTINCT tipo_operacion','order'=>'tipo_operacion ASC'));
              $zonas = $this->Contacto->find('all',array('fields'=>'DISTINCT zona','order'=>'zona ASC'));
              $this->set(compact('tipo_viviendas','tipo_operaciones','zonas'));
          }
          
  }

  public function view($id = null) {
    $this->Cliente->Behaviors->load('Containable');
    $this->Event->Behaviors->load('Containable');
    $this->loadModel('LogCliente');
    $this->loadModel('Propiedades');
    $this->Lead->Behaviors->load('Containable');


    /* ---------- Opciones para la inactivacion de cliente definitiva. ---------- */
    $this->set('motivos_inactivo_definitivo',$this->DicRazonInactivacion->find('list',array(
      'conditions'=>array(
          'DicRazonInactivacion.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'DicRazonInactivacion.tabla'      => 'clientes',
          'DicRazonInactivacion.tipo_razon' => '1',
      ),
      'fields' => array('razon', 'razon'),
      'contain' => false
    )));

    /* ------------ Opciones para la inactivacion de cliente temporal ----------- */
    $this->set('motivos_inactivo_temporal',$this->DicRazonInactivacion->find('list',array(
      'conditions'=>array(
          'DicRazonInactivacion.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'DicRazonInactivacion.tabla'      => 'clientes',
          'DicRazonInactivacion.tipo_razon' => '2',
      ),
      'fields' => array('razon', 'razon'),
      'contain' => false
    )));

    // La definicion de las etapas las tomas de la variable global.
    $this->set('etapas_clientes',$this->etapas_cliente);

    $cliente = $this->Cliente->find('first',
      array(
        'conditions' => array(
          'Cliente.' . $this->Cliente->primaryKey => $id
        ),
        'contain' => array(

          'User',
          'Inmueble',
          'Desarrollo',
          'DicTipoCliente',
          'DicEtapa',
          'DicLineaContacto',
          'Lead',
          'Agenda',
          'Top5',
          'LogCliente',
          'Facturas',
          'Cotizaciones' => array(
            'Inmueble' => array(
              'fields' => array(
                'liberada',
                'referencia',
              )
            )
          ),
          'MisOperaciones' => array(
            'Documentos' => array(
              'tipo_documento',
              'ruta'
            ),
            'Inmueble' => array(
              'fields' => array(
                'referencia',
                'titulo',
                'id',
                'precio'
              ),
              'FotoInmueble'
            ),
            'Cliente' => array( 
              'fields' => array( 
                'Cliente.nombre', 
                'Cliente.id', 
                ) 
              ),
            'User' => array( 
              'fields' => array( 
                'User.nombre_completo', 
                'User.id', 
                ) 
            ),
            'Cotizacion',
          ),
        )
      )
    );
    

    //Se agrega esta búsqueda de estados para normalizar con base en la tabla de CP
    $this->loadModel('Cp');
    $this->Cp->Behaviors->load('Containable');
    $cps = $this->Cp->find(
      'all',
      array(
        'fields'=>array(
          'DISTINCT(estado) as estado'
        ),
        'contain'=>false
      )
    );
    $estados = array();
    foreach($cps as $cp):
      $estados[$cp['Cp']['estado']] = $cp['Cp']['estado'];
    endforeach;
    $this->set('estados',$estados);

    $municipios = $this->Cp->find(
      'list',
      array(
          'fields'=>array(
              'Cp.municipio','Cp.municipio'
          ),
          'conditions'=>array(
              'Cp.estado'=>$cliente['Cliente']['estado_prospeccion']
          ),
          'order'=>'Cp.municipio ASC'
      )
    );

    $this->set('municipios',$municipios);

    $colonias = $this->Cp->find(
      'list',
      array(
          'fields'=>array(
              'Cp.colonia','Cp.colonia'
          ),
          'conditions'=>array(
              'Cp.estado'=>$cliente['Cliente']['estado_prospeccion'],
              'Cp.municipio'=>$cliente['Cliente']['ciudad_prospeccion']
          ),
          'order'=>'Cp.colonia ASC'
      )
    );

    $this->set('colonias',$colonias);
    //Fin de Actualización

    // Validación para los clientes que no les corresponde el asesor.
    if( $this->Session->read('Auth.User.id') != $cliente['Cliente']['user_id'] AND $this->Session->read('Permisos.Group.call') != 1){

      $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
      $this->Session->setFlash( 'No tienes acceso a este cliente, por tu atención gracias.' , 'default', array(), 'm_success');
      $this->redirect(array('action' => 'index'));

    }
    

    $asesores    = '';
    $clientes    = [];
    $desarrollos = [];
    $inmuebles   = [];
    $eventos     = [];
    $data_evento = [];
    $s           = 0;
    $hours       = [];
    $minutos     = [];
    $desarrollos_opciones = [];
    $inmuebles_opciones = [];


    $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
    $tipo_tarea          = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 4=>'Reactivación', 1=>'Visita');
    $tipo_tarea_opciones = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
    $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'home', 'child' );
    $remitente           = '';
    $color               = '#AEE9EA';
    $textColor           = '#2f2f2f';
    $recordatorios       = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');
    $status              = array(0=> 'Creado(s)', 2=>'Cancelado(s)');
    
    for($i=7;$i<=22;$i++){
      $hours[str_pad($i,2,'0',STR_PAD_LEFT)] =  str_pad($i,2,'0',STR_PAD_LEFT);
    }
    
    for( $i = 0; $i < 60; $i += 5 ){
      $minutos[str_pad($i,2,'0',STR_PAD_LEFT)] =  str_pad($i,2,'0',STR_PAD_LEFT);
    }

    // Hacer listado de los inmuebles
    $this->set('propiedades', $this->Inmueble->find('list', array('conditions'=>array(
        'Inmueble.id IN (SELECT inmueble_id FROM ventas WHERE ventas.cliente_id = '.$id.')'
    ))));

    // Categorias para la factura
    $this->set('categorias', array('Bancos'));

    $leads = 
      $this->Lead->find(
        'all',
        array(
          'fields'=>array(
            'status','id','cliente_id','inmueble_id'
          ),
          'recursive'=>2,
          'contain'=>array(
            'Inmueble'=>array(
              'fields'=>array(
                'id',
                'titulo',
                'precio',
                'construccion',
                'terreno',
                'construccion_no_habitable',
                'estacionamiento_techado',
                'estacionamiento_descubierto',
                'banos',
                'medio_banos',
                'recamaras',
                'liberada',
                'referencia',
              ),
              'FotoInmueble'=>array(
                'limit'=>1,
                'fields'=>array(
                  'ruta'
                )
              )
            ),
          ),
          'conditions'=>array(
            'Lead.cliente_id'=>$id,
            'Lead.inmueble_id != '=> ""
          ),
          'order' => array('Lead.id' => 'DESC'),
          'group' => 'Lead.inmueble_id'
        )
      );
    
    $this->Lead->Behaviors->load('Containable');

    $promedio_venta = 0;
    $construidos = 0;
    $terreno = 0;
    $i = 0;
    $tipo = "";
    $where = array(
            'Inmueble.liberada'=>1,
            'Inmueble.id NOT IN (SELECT inmueble_id FROM leads WHERE cliente_id = '.$id.')',
            'Inmueble.precio BETWEEN '.$promedio_venta*.9.' AND '. $promedio_venta*1.1
      );
    foreach ($leads as $lead):
        $promedio_venta += floatVal($lead['Inmueble']['precio']);
        if (!empty($lead['Inmueble']['dic_tipo_propiedad_id'])){
            $tipo = $tipo.strval($lead['Inmueble']['dic_tipo_propiedad_id']).",";
        }
        $construidos += floatVal($lead['Inmueble']['construccion']);
        $terreno = $construidos + floatVal($lead['Inmueble']['terreno']);
        $i++;
    endforeach;
    
    if ($tipo != ""){
        array_push($where, 'Inmueble.dic_tipo_propiedad_id IN('.substr($tipo, 0, -1) .')');
    }

    $promedio_venta = ($i==0 ? floatVal($promedio_venta) : floatVal($promedio_venta/$i));
    
    $this->set(compact('cliente'));
    $this->set('agendas',$this->Agenda->find('all', array('order'=>'Agenda.id DESC','conditions'=>array('Agenda.cliente_id'=>$id))));
    $this->set('leads',$leads);
    // $this->set('sugeridas',$this->Inmueble->find('all',array(
    //     'limit'=>10,
    //     'conditions'=>$where,
    // )));
    
    $this->set(
      'desarrollos',
      $this->Lead->find(
        'all',
        array(
          'fields'=>array(
            'status','id','cliente_id','desarrollo_id'
          ),
          'recursive'=>2,
          'contain'=>array(
            'Desarrollo'=>array(
              'fields'=>array(
                'id','nombre','m2_low','m2_top','est_low','est_top','banio_low','banio_top','rec_low','rec_top'
              ),
              'FotoDesarrollo'=>array(
                'limit'=>1,
                'fields'=>array(
                  'ruta'
                )
              )
            ),
          ),
          'conditions'=>array(
            'Lead.cliente_id'=>$id,
            'Lead.desarrollo_id != '=> ""
          ),
          'order' => 'Lead.id DESC',
          'group' => 'Lead.desarrollo_id'
        )
      )
    );
    
    $llaves_desarrollo = array();
    $valores_desarrollo = array();
    $desarrollos = $this->Desarrollo->FotoDesarrollo->find('all',array('fields'=>array('FotoDesarrollo.desarrollo_id, FotoDesarrollo.ruta'),'conditions'=>array('FotoDesarrollo.desarrollo_id IN (SELECT desarrollo_id FROM leads WHERE cliente_id ='.$id.')')));
    foreach ($desarrollos as $desarrollo):
        array_push($llaves_desarrollo, $desarrollo['FotoDesarrollo']['desarrollo_id']);
        array_push($valores_desarrollo, $desarrollo['FotoDesarrollo']['ruta']);
        
    endforeach; 
    $arreglo_desarrollo=array_combine($llaves_desarrollo,$valores_desarrollo);
    $this->set('fotos_desarrollos',$arreglo_desarrollo);
    
    $llaves_inmueble = array();
    $valores_inmueble = array();
    $inmuebles = $this->Inmueble->FotoInmueble->find('all',array('fields'=>array('FotoInmueble.inmueble_id, FotoInmueble.ruta'),'conditions'=>array('FotoInmueble.inmueble_id IN (SELECT inmueble_id FROM leads WHERE cliente_id ='.$id.')')));
    foreach ($inmuebles as $inmueble):
        array_push($llaves_inmueble, $inmueble['FotoInmueble']['inmueble_id']);
        array_push($valores_inmueble, $inmueble['FotoInmueble']['ruta']);
    endforeach; 
    $arreglo_inmuebles=array_combine($llaves_inmueble,$valores_inmueble);
    $this->set('fotos_inmuebles',$arreglo_inmuebles);
    
    // Listado de inmuebles para agregar como leads
    $this->set('lista_inmuebles',$this->Inmueble->find('list',array('order'=>'Inmueble.referencia ASC','conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));

    // Agregar validación para que solo se visualice los desarrollos conforme a los que tienen permisos.
    $this->set('logs',$this->LogCliente->find('all',array('order'=>'LogCliente.id DESC','conditions'=>array('LogCliente.cliente_id'=>$id))));
    
    // Indicadores de emails, citas y visitas, llamadas, principalmente se toma del log de clietnes
    // $this->set('citas',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion'=> 5 ))));

    // Indicadores de seguimiento se tomara de los eventos.
    $this->set('citas',$this->Event->find('count',array('conditions'=>array('Event.cliente_id'=>$id,'Event.tipo_tarea'=> 0, 'Event.status' => 1 ))));
    $this->set('visitas',$this->Event->find('count',array('conditions'=>array('Event.cliente_id'=>$id,'Event.tipo_tarea'=> 1, 'Event.status' => 1 ))));
    $this->set('llamadas',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion' => 4, 'LogCliente.event_id IS NULL'))));
    $this->set('mails',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion' => 3, 'LogCliente.event_id IS NULL'))));
    
    $this->set('whatsapp',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion' => 11, 'LogCliente.event_id IS NULL'))));
    $tipo_propiedad = $this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));

    $this->set('tipo_propiedad', $tipo_propiedad);
    $this->set('all_desarrollos',$this->Desarrollo->find('list',array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
    $list_facturas = $this->Factura->find('list', array('conditions'=>array('Factura.cliente_id'=>$id)));
    $this->set(compact('list_facturas'));
    $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));

    if ( $this->Session->read('Permisos.Group.call') == 1 ) { // SuperAdmin y Gerentes
          
      $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')');
      $condiciones_clientes    = array('Cliente.id' => $id);
    
    } elseif( !empty($this->Session->read('Desarrollador')) ){ // Desarrolladores.

      // $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')', 'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id = '.$this->Session->read('Desarrollos').')');
      
      $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')', 'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id IN ('.implode(',', $this->Session->read('Desarrollos') ).'))');
      
      $condiciones_clientes    = array('Cliente.id' => $id);
    
    } else{ // Asesores
      $condiciones_asesores    = array('User.id' => $this->Session->read('Auth.User.id'));
      $condiciones_clientes    = array('Cliente.id' => $id);
    }

    $asesores = $this->User->find('list', array(
      'conditions' => $condiciones_asesores,
      'order' => 'User.nombre_completo ASC'
    ));

    $clientes = $this->Cliente->find('list', array(
      'conditions' => $condiciones_clientes,
      'order' => 'Cliente.nombre ASC'
    ));



      $fecha_inicial       = date('Y').'01-01 00:00:00';
      $fecha_fianl         = date('Y').'12-31 59:59:59';
      $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
      $tipo_tarea          = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 4=>'Reactivación', 1=>'Visita');
      $tipo_tarea_opciones = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
      $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'check-circle', 'child' );
      $remitente           = '';
      $color               = '#AEE9EA';
      $textColor           = '#2f2f2f';
      $recordatorios       = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');
      $status              = array(0=> 'Creado(s)', 2=>'Cancelado(s)');
      

      $eventos = $this->Event->find('all',
      array(
          'recursive' => -0,
          'conditions' => array(
              'Event.status'      => 1,
              'Event.tipo_evento' => 1,
              'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Event.fecha_inicio >= CURDATE()',
              'Event.fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)',
              'Event.cliente_id'  => $id
          ),
          'order' => 'Event.fecha_inicio DESC'
      ));


      $data_eventos = [];
      $s = 0;
      // Vamos a setear los eventos de forma correcta para mandar a llamar a la vista lo menos cargada posible
      foreach( $eventos as $evento ) {

      switch ($evento['Event']['tipo_tarea']) {
          case 0:
          $remitente = 'para';
          $color = '#AEE9EA';
          break;
          case 1:
          $remitente = 'de';
          $color = '#7CC3C4';
          break;
          case 2:
          $remitente = 'a';
          $color = '#7AABF9';
          break;
          case 3:
          $remitente = 'para';
          $color = '#F0D38A';
          break;
          case 4:
          $remitente = 'de';
          $color = '#ffe048';
          break;
      }

      
      if( $evento['Event']['status'] == 2) {
          $color = '#2f2f2f';
          $textColor = '#fff';
      }

      if( isset($evento['Desarrollo']['nombre']) ){
          $nombre_ubicacion = strtoupper($evento['Desarrollo']['nombre']);
          $url_ubicacion    = Router::url(array("controller" => "desarrollos", "action" => "view", $evento['Desarrollo']['id']));
      }else{
          $nombre_ubicacion = strtoupper($evento['Inmueble']['titulo']);
          $url_ubicacion    = Router::url(array("controller" => "inmuebles", "action" => "view", $evento['Inmueble']['id']));
      }

      $s++;
      $data_eventos[$s]['titulo']              = strtoupper($evento['Cliente']['nombre']);
      $data_eventos[$s]['fecha_inicio']        = date('Y-m-d', strtotime($evento['Event']['fecha_inicio'])).'T'.date('H:i:s', strtotime($evento['Event']['fecha_inicio']));
      $data_eventos[$s]['color']               = $color;
      $data_eventos[$s]['textColor']           = $textColor;
      $data_eventos[$s]['icon']                = $tipo_tarea_icon[$evento['Event']['tipo_tarea']];
      $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s a', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))."','".date('H', strtotime($evento['Event']['fecha_inicio']))."','".date('i a', strtotime($evento['Event']['fecha_inicio']))."','".$evento['Event']['desarrollo_id']."','".$evento['Event']['inmueble_id']."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_1']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_1']))."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_2']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_2']))."','".$evento['Event']['opt_recordatorio_1']."','".$evento['Event']['opt_recordatorio_2']."')";
      $data_eventos[$s]['fecha_inicio_format'] = date('d/m/Y \a \l\a\s H:i', strtotime($evento['Event']['fecha_inicio']));
      $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
      $data_eventos[$s]['status']              = $evento['Event']['status'];
      $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
      $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
      $data_eventos[$s]['id_evento']           = $evento['Event']['id'];

      
      }

      $this->set('eventos', $data_eventos);

    
    $motivos = array(
      'Por Baja del asesor'      => 'Por Baja del asesor',
      'Cliente sin Atención'     => 'Cliente sin Atención',
      'Por petición del cliente' => 'Por petición del cliente',
      'Por Proceso Comercial'    => 'Por Proceso Comercial',
      'Error de asignación'      => 'Error de asignación',
    );
    $this->set(compact('motivos'));

    //Traer los motivos de cancelación de citas
    $this->loadModel('Diccionario');
    $this->set(
        'motivos_citas_canceladas',
        $this->Diccionario->find(
            'list',
            array(
                'fields'=>array(
                    'Diccionario.descripcion','Diccionario.descripcion'
                ),
                'conditions'=>array(
                    'Diccionario.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Diccionario.sub_directorio'=>'dic_citas_canceladas'
                )
            )
        )
    );

    // Podemos setear el evento para mostrar el calendario limpio
    $this->set(compact('asesores'));
    $this->set(compact('clientes'));
    $this->set(compact('desarrollos_opciones'));
    //$this->set(compact('all_desarrollos'));
    $this->set(compact('inmuebles_opciones'));
    $this->set(compact('tipo_tarea'));
    $this->set(compact('tipo_tarea_opciones'));
    $this->set(compact('recordatorios'));
    $this->set(compact('status'));
    $this->set(compact('hours'));
    $this->set(compact('minutos'));
    $this->set('return', 6);
    $this->set('param_return', $id);

    $propiedades_text = array();
    foreach($tipo_propiedad as $tipo):
        $propiedades_text[$tipo] = $tipo;
    endforeach;

    // Variables para prospeccion
    $this->set( array('opciones_venta' => $this->opciones_venta, 'opciones_formas_pago' => $this->opciones_formas_pago, 'opciones_minimos' => $this->opciones_minimos, 'opciones_amenidades'=> $this->opciones_amenidades, 'propiedades_text' => $propiedades_text) );

    //Traer los motivos de cancelación de citas
    $this->loadModel('Diccionario');
    $this->set(
        'motivos_citas_canceladas',
        $this->Diccionario->find(
            'list',
            array(
                'fields'=>array(
                    'Diccionario.descripcion','Diccionario.descripcion'
                ),
                'conditions'=>array(
                    'Diccionario.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Diccionario.sub_directorio'=>'dic_citas_canceladas'
                )
            )
        )
    );

  }

  public function add() {
    $this->Inmueble->Behaviors->load('Containable');
    $this->Desarrollo->Behaviors->load('Containable');
    $this->CuentasUser->Behaviors->load('Containable');
    $this->DicTipoCliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');

      
    if ($this->request->is(array('post', 'put'))) {
      
      $status = $this->request->data['Cliente']['status'];

      if( !empty($this->request->data['Cliente']['id']) ) {

        $this->request->data['Cliente']['status']    = 'Activo';
        $this->request->data['Cliente']['last_edit'] = date('Y-m-d H:i:s');

        if($this->Cliente->save($this->request->data)){

          // Funcion para el reingreso al sistema del cliente.
          $reactivacion = $this->client_reentry(
            $this->request->data['Cliente']['id'],
            $this->request->data['Cliente']['user_id'],
            $this->request->data['Cliente']['Propiedades'],
            $this->request->data['Cliente']['nombre'],
            $this->request->data['Cliente']['dic_linea_contacto_id'],
            $status,
            $this->request->data['Cliente']['user_id_hidden']
          );

          $this->validar_linea_contacto(
            $this->request->data['Cliente']['id'],
            $this->request->data['Cliente']['user_id'],
            $this->request->data['Cliente']['cuenta_id'],
            $this->request->data['Cliente']['dic_linea_contacto_id'],
            $this->request->data['Cliente']['Propiedades']
          );
          
          $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
          $this->Session->setFlash( 'Se ha guardado correctamente el cliente' , 'default', array(), 'm_success');


          // Si eres dueño del cliente o tu rol es superAdmin te manda a la vista del cliente, si no, te manda al listado de clientes.
          if( $this->Session->read('Permisos.Group.id') <= 2 OR $this->Session->read('Auth.User.id') == $this->request->data['Cliente']['user_id'] ){
            $redirect = array('action'=> 'view', 'controller' => 'clientes', $this->request->data['Cliente']['id']);
          }else {
            $redirect = array('action'=> 'index', 'controller' => 'clientes');
          }

        }


      }else {
        
        $params_cliente = array(
          'nombre'              => $this->request->data['Cliente']['nombre'],
          'correo_electronico'  => $this->request->data['Cliente']['correo_electronico'],
          'telefono1'           => $this->request->data['Cliente']['telefono1'],
          'telefono2'           => '',
          'telefono3'           => '',
          'tipo_cliente'        => $this->request->data['Cliente']['dic_tipo_cliente_id'],
          'propiedades_interes' => $this->request->data['Cliente']['Propiedades'],
          'forma_contacto'      => $this->request->data['Cliente']['dic_linea_contacto_id'],
          'comentario'          => '',
          'asesor_id'           => $this->request->data['Cliente']['user_id'],
          'created'           => ( !empty($this->request->data['Cliente']['created']) ? date('Y-m-d', strtotime($this->request->data['Cliente']['created'])) : null ),
        );
    
        $params_user = array(
          'user_id'              => $this->Session->read('Auth.User.id'),
          'cuenta_id'            => $this->request->data['Cliente']['cuenta_id'],
          'notificacion_1er_seg' => $this->Session->read('Parametros.Paramconfig.not_1er_seg_clientes'),
        );
    
        $save_client = $this->add_cliente( $params_cliente, $params_user );
        $this->validar_linea_contacto($save_client['cliente_id'],$params_user['user_id'],$params_user['cuenta_id'],$this->request->data['Cliente']['dic_linea_contacto_id'],$this->request->data['Cliente']['Propiedades']);
        
        if( $save_client['bandera'] == 1 ){

          $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
          $this->Session->setFlash( $save_client['respuesta'] , 'default', array(), 'm_success');
          $redirect = array('action'=> 'view', 'controller' => 'clientes', $save_client['cliente_id']);

        }else{
          $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
          $this->Session->setFlash($save_client['respuesta'], 'default', array(), 'm_error'); // Mensaje
          // $redirect = array('action'=> 'view', 'controller' => 'clientes', $save_client['cliente_id']);
          $redirect = array('action'=> 'index', 'controller' => 'clientes');

        }
      }

      $this->redirect( $redirect );
    }

    $inmuebles   = [];
    $conditions  = [];
    $restrigidos = 0;

    $list_users = $this->CuentasUser->find('list',
      array(
        'fields'     => array( 'User.id', 'User.nombre_completo' ),
        'conditions' => array( 'CuentasUser.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') ),
        'contain'    => array( 'User' ),
        'order'      => array('User.nombre_completo' => 'ASC')
      )
    );

    $restrigidos = $this->Desarrollo->find('count',array('conditions' => array('Desarrollo.id IN (SELECT desarrollo_id FROM desarrollos_users WHERE user_id = '.$this->Session->read('Auth.User.id').')')));

    if ($this->Session->read('CuentaUsuario.CuentasUser.group_id') == 3 && $restrigidos > 0){
      $conditions =   array('Desarrollo.id IN (SELECT desarrollo_id FROM desarrollos_users WHERE user_id = '.$this->Session->read('Auth.User.id').')', 'Desarrollo.visible' => 1);
    }else{

      $conditions = array(
        'OR' => array(
          'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
        ), 
        'AND' => array(
          'Desarrollo.is_private' => 0,
          'Desarrollo.visible' => 1
        )

      );

      $list_inmuebles = $this->Inmueble->find('all',
        array(
          'fields'     => array(
            'id','titulo'
          ),
        'contain'    => false,
        'order'      => 'Inmueble.titulo ASC',
        'conditions' => array(
          'Inmueble.liberada'  => 1,
          'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)','Inmueble.liberada IN (1,2,3)'
        )
        )
      );
    }

    $list_desarrollos = $this->Desarrollo->find(
      'all',array(
        'fields'  => array(
        'id','nombre'
        ),
        'contain' => false,
        'order'      => 'Desarrollo.nombre ASC',
        'conditions' => $conditions
      )
    );

    $list_tipos_cliente = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
    $list_linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));

    $this->set(compact('list_users', 'list_desarrollos', 'list_inmuebles', 'list_tipos_cliente', 'list_linea_contactos' ));
    
              
  }

  public function validar_linea_contacto($cliente_id = null, $user_id = null,$cuenta_id,$linea_contacto_id = null, $prop_interes = null){
    $this->loadModel('DicLineaContacto');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $linea_contacto = $this->DicLineaContacto->find(
      'first',
      array(
        'contain'=>false,
        'fields'=>array(
          'etapa_embudo'
        ),
        'conditions'=>array(
          'DicLineaContacto.id'=>$linea_contacto_id
        )
      )
    );

    //Validar Propiedad de Interés
    $inmueble_id = 0;
    $desarrollo_id = 0;
    if (substr($prop_interes, 0, 1) == "E" || substr($prop_interes, 0, 1) == "P"){ // La propiedad de interes es un inmueble
      $inmueble_id = substr($prop_interes, 1);
    }else{ // En caso de que la propiedad de interes sea un desarrollo
      $desarrollo_id  = substr($prop_interes, 1);
    }

    switch($linea_contacto['DicLineaContacto']['etapa_embudo']){
      case(4):
        App::import('Controller','Events');
        $evento = new EventsController;

        $data_event1 = array(
          "cliente_id"        => $cliente_id,
          "user_id"           => $user_id,
          "fecha_inicio"      => date('Y-m-d H:i:s'),
          "inmueble_id"       => $inmueble_id,
          "desarrollo_id"     => $desarrollo_id,
          "recordatorio1"     => null,
          "recordatorio2"     => null,
          "tipo_evento"       => '1',
          "tipo_tarea"        => 1,
          "status_evento"     => 1,
          "cuenta_id"         => $cuenta_id,
      );
      $save_event = $evento->add_evento($data_event1);
      $this->Cliente->query("UPDATE clientes SET etapa = ".$linea_contacto['DicLineaContacto']['etapa_embudo']." WHERE id = $cliente_id");
      break;
    }


    return null;
    $this->autoRender = false; 
  }

  public function client_reentry( $cliente_id = null, $user_id = null, $prop_interes = null, $nombre_cliente = null, $dic_forma_contacto_id = null, $pre_status = null, $prev_user = null ){
    date_default_timezone_set('America/Mexico_City');
    $this->User->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');

    $inmueble       = [];
    $desarrollo     = [];
    $user           = $this->User->find('first', array( 'conditions' => array('id' => $user_id ), 'contain' => false ));
    $linea_contacto = $this->DicLineaContacto->find('first', array('conditions' => array('DicLineaContacto.id' => $dic_forma_contacto_id), 'fields' => 'linea_contacto', 'contain' => false ));
    $cliente        = $this->Cliente->findFirstById( $cliente_id );
    $user_id_reentry= $this->Cliente->find( 'first',  
      array(
        'conditions' => array('Cliente.id' => $cliente_id),
        'fields' => 'Cliente.user_id', 
        'contain' => false
      ) 
    );
    // Se guarda en el log de cliente mostrando que ya existe pero entro por otro medio
    $this->LogCliente->create();
    $this->request->data['LogCliente']['id']         =  uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
    $this->request->data['LogCliente']['user_id']    = $user_id;
    $this->request->data['LogCliente']['mensaje']    = "Cliente actualizado, reingreso al sistema.";
    $this->request->data['LogCliente']['accion']     = 1;
    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
    $this->LogCliente->save($this->request->data);

    if( $pre_status == 'Inactivo' ){
      $leyenda_log = "Se activa el cliente y se reasigna al asesor: ".$user['User']['nombre_completo'].". Se envía ";
    }elseif($pre_status == 'Inactivo temporal') {
      $leyenda_log = "Se activa el cliente. Se envía ";
    }else {
      $leyenda_log = "Se envía ";
    }
    
    // Se guarda un nuevo lead de venta, del cliente que ya existe.
    if (substr($prop_interes, 0, 1) == "E" || substr($prop_interes, 0, 1) == "P"){
      
      $inmueble_id = substr($prop_interes, 1);
      $inmueble    = $this->Inmueble->find('all', array('conditions' => array('Inmueble.id' => $inmueble_id), 'containe' => false));

      $this->request->data['LogInmueble']['mensaje']     = "Envío de propiedad a cliente: ".$nombre_cliente;
      $this->request->data['LogInmueble']['usuario_id']  = $user_id;
      $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
      $this->request->data['LogInmueble']['accion']      = 5;
      $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
      $this->LogInmueble->create();
      $this->LogInmueble->save($this->request->data);

      $this->request->data['Lead']['cliente_id']            = $cliente_id;
      $this->request->data['Lead']['status']                = 'Abierto';
      $this->request->data['Lead']['dic_linea_contacto_id'] = $dic_forma_contacto_id;
      $this->request->data['Lead']['inmueble_id']           = $inmueble_id;
      $this->request->data['Lead']['status']                = 'Aprobado';
      $this->request->data['Lead']['tipo_lead']             = 2;
      $this->request->data['Lead']['user_id']               = $user_id_reentry['Cliente']['user_id'];
      $this->request->data['Lead']['fecha']                 = date('Y-m-d h:i:s');
      $this->Lead->create();
      $this->Lead->save($this->request->data);

      // Registrar Seguimiento Rápido
      $this->Agenda->create();
      $this->request->data['Agenda']['user_id']        = $user_id;
      $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
      $this->request->data['Agenda']['mensaje']        = $leyenda_log."la propiedad ".$inmueble[0]['Inmueble']['titulo']." solicitado vía ".$linea_contacto['DicLineaContacto']['linea_contacto']." por intento de registro duplicado.";
      $this->request->data['Agenda']['cliente_id']     = $cliente_id;
      $this->Agenda->save($this->request->data);
      $inmueble_interesado = $inmueble_id;

      $this->request->data['Cliente']['id']            = $cliente_id;
      $this->request->data['Cliente']['inmueble_id']   = $inmueble_id;
      $this->request->data['Cliente']['desarrollo_id'] = '';
      $this->Cliente->save($this->request->data);

    }else{ // En caso de que la propiedad de interes sea un desarrollo
      
      $desarrollo_id = substr($prop_interes, 1);
      $desarrollo    = $this->Desarrollo->find('all', array('conditions' => array('Desarrollo.id' => $desarrollo_id), 'containe' => false));

      // Se agrega el guardar la informacion de la propiedad en el interes del cliente.
      $data_add_prospeccion = array(
        'cliente_id'                 => $cliente_id,
        'user_id'                    => $user_id,
        'operacion_prospeccion'      => 'Venta (Entrega Inmediata)',
        'tipo_propiedad_prospeccion' => 'Departamento',
        'ciudad_prospeccion'         => $desarrollo['Desarrollo']['delegacionudad'],
        'estado_prospeccion'         => $desarrollo['Desarrollo']['ciudad'],
        'colonia_prospeccion'        => $desarrollo['Desarrollo']['colonia'],
        'zona_prospeccion'           => '',
      );
      $this->editInformacionProspeccion( $data_add_prospeccion );

      $this->request->data['LogDesarrollo']['mensaje']       = "Envío de desarrollo a cliente: ".$nombre_cliente;
      $this->request->data['LogDesarrollo']['usuario_id']    = $user_id;
      $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
      $this->request->data['LogDesarrollo']['accion']        = 5;
      $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_id;
      $this->LogDesarrollo->create();
      $this->LogDesarrollo->save($this->request->data);

      $this->request->data['Lead']['cliente_id']            = $cliente_id;
      $this->request->data['Lead']['status']                = 'Abierto';
      $this->request->data['Lead']['dic_linea_contacto_id'] = $dic_forma_contacto_id;
      $this->request->data['Lead']['desarrollo_id']         = $desarrollo_id;
      $this->request->data['Lead']['status']                = 'Aprobado';
      $this->request->data['Lead']['tipo_lead']             = 2;
      $this->request->data['Lead']['user_id']               = $user_id_reentry['Cliente']['user_id'];
      $this->request->data['Lead']['fecha']                 = date('Y-m-d h:i:s');

      
      $this->Lead->create();
      $this->Lead->save($this->request->data);

      // Registrar Seguimiento Rápido
      $this->Agenda->create();
      $this->request->data['Agenda']['user_id']        = $user_id;
      $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
      $this->request->data['Agenda']['mensaje']        = $leyenda_log."el desarrollo ".$desarrollo[0]['Desarrollo']['nombre']." solicitado vía ".$linea_contacto['DicLineaContacto']['linea_contacto']." por intento de registro duplicado.";
      $this->request->data['Agenda']['cliente_id']     = $cliente_id;
      $this->Agenda->save($this->request->data);
      $desarrollo_interesado = $desarrollo_id;

      $this->request->data['Cliente']['id']            = $cliente_id;
      $this->request->data['Cliente']['inmueble_id']   = '';
      $this->request->data['Cliente']['desarrollo_id'] = $desarrollo_id;
      $this->Cliente->save($this->request->data);
      
    }

    /* ----------------------------- Notificaciones ----------------------------- */
    $cuenta      = $this->Cuenta->findFirstById( $this->Session->read('CuentaUsuario.Cuenta.id') );
    $mailconfig  = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id'] );
    $paramconfig = $this->Paramconfig->findFirstById( $cuenta['Cuenta']['paramconfig_id'] );
    

    // Condición si el cliente tiene correo.
    if( $cliente['Cliente']['correo_electronico'] != 'Sin correo' ){

      if ( $paramconfig['Paramconfig']['mep'] == 1 ){
        $this->Email = new CakeEmail();
        $this->Email->config(array(
            'host'      => $mailconfig['Mailconfig']['smtp'],
            'port'      => $mailconfig['Mailconfig']['puerto'],
            'username'  => $mailconfig['Mailconfig']['usuario'],
            'password'  => $mailconfig['Mailconfig']['password'],
            'transport' => 'Smtp'
            )
        );
        $this->Email->emailFormat('html');
        $this->Email->template('emailacliente','layoutinmomail');
        $this->Email->from(array($user['User']['correo_electronico'] => $user['User']['nombre_completo']));
        $this->Email->to($cliente['Cliente']['correo_electronico']);
        
        if ( $paramconfig['Paramconfig']['cc_a_c'] != ""){
            $emails = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
            $arreglo_emails = array();
            if (sizeof($emails)>0){
                foreach($emails as $email):
                    $arreglo_emails[$email] = $email;
                endforeach;
            }else{
                $arreglo_emails[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
            }
            $this->Email->bcc( $arreglo_emails );
        }
        
        $this->Email->subject($paramconfig['Paramconfig']['smessage_new_client']);
        $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$inmueble, 'desarrollos'=>$desarrollo,'usuario'=>$user,'body_message'=> $paramconfig['Paramconfig']['bmessage_new_client'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
        $this->Email->send();

        if ( sizeof($inmueble) > 0 ) {
            $info = $inmueble[0]['Inmueble']['referencia'];
        }else{
            $info = $desarrollo[0]['Desarrollo']['nombre'];
        }

        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         = uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
        $this->request->data['LogCliente']['user_id']    = $user_id;
        $this->request->data['LogCliente']['mensaje']    = "Email enviado con la información de ".$info;
        $this->request->data['LogCliente']['accion']     = 3;
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
        $this->LogCliente->save($this->request->data);
      }

      /* ---------- Reasignacion de cliente, notificación al nuevo asesor --------- */
      if( $pre_status == 'Inactivo' ){
        $this->loadModel('Reasignacion');

        $this->request->data['Reasignacion']['cliente_id']      = $cliente_id;
        $this->request->data['Reasignacion']['asesor_original'] = $prev_user;
        $this->request->data['Reasignacion']['asesor_nuevo']    = $cliente['Cliente']['user_id'];
        $this->request->data['Reasignacion']['fecha']           = date('Y-m-d H:i:s');
        $this->request->data['Reasignacion']['motivo_cambio']   = "Reingreso de cliente.";
        $this->request->data['Reasignacion']['user_id']         = $this->Session->read('Auth.User.id');

        if ($this->Reasignacion->save()){

          $this->Agenda->create();
          $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
          $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
          $this->request->data['Agenda']['mensaje']    = "El cliente ha sido reasignado por la siguiente razón: Reingreso de cliente.";
          $this->request->data['Agenda']['cliente_id'] = $cliente['Cliente']['id'];
          $this->Agenda->save($this->request->data);

          $this->Inmueble->Behaviors->load('Containable');
          $propiedades = $this->Inmueble->find(
            'all',
            array(
              'fields'=>array(
                'id','referencia'
              ),
              'contain'=>array(
                'FotoInmueble'
              ),
              'conditions'=>array(
                "Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE cliente_id = ".$cliente['Cliente']['id'].")"
              )
            )
          );
          
          $this->Desarrollo->Behaviors->load('Containable');
          $desarrollos = $this->Desarrollo->find(
            'all',
            array(
              'fields'=>array(
                'id','nombre'
              ),
              'contain'=>array(
                'FotoDesarrollo'
              ),
              'recursive'=>2,
              'conditions'=>array(
                "Desarrollo.id IN (SELECT leads.desarrollo_id FROM leads WHERE cliente_id = ".$cliente['Cliente']['id'].")"
              )
            )
          );

          $this->User->Behaviors->load('Containable');
          $usuario = $this->User->find(
            'first',
            array(
              'conditions'=>array(
                'User.id'=>$cliente['Cliente']['user_id']
              ),
              'fields'=>array(
                'id','nombre_completo','correo_electronico'
              ),
              'contain'=>false
            )
          );

          $this->Cliente->Behaviors->load('Containable');
          $cliente = $this->Cliente->find(
            'first',
            array(
              'conditions'=>array(
                'Cliente.id'=>$cliente['Cliente']['id']
              ),
              'fields'=>array(
                'id','nombre','created','telefono1','telefono2','correo_electronico','dic_linea_contacto_id'
              ),
              'contain'=>array(
                'DicLineaContacto'=>array(
                  'fields'=>array(
                    'linea_contacto','id'
                  )
                )
              )
            )
          );

          $this->Email = new CakeEmail();
          $this->Email->config(array(
              'host'      => $mailconfig['Mailconfig']['smtp'],
              'port'      => $mailconfig['Mailconfig']['puerto'],
              'username'  => $mailconfig['Mailconfig']['usuario'],
              'password'  => $mailconfig['Mailconfig']['password'],
              'transport' => 'Smtp'
              )
          );
          $this->Email->emailFormat('html');
          $this->Email->template('emailaasesor','layoutinmomail');
          $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
          $this->Email->to($usuario['User']['correo_electronico']);
          $this->Email->subject('Nuevo cliente asignado');
          $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
          $this->Email->send();
        }
      }
    }
    return true;
  }

  public function edit($id = null) {
        
    $cliente = $this->Cliente->read(null, $id);
    if ($this->request->is(array('post', 'put'))) {
      
      // Definición para colocar el correo y teléfono en la db - SaaK

      if( $this->request->data['Cliente']['correo_electronico'] != '' AND  $this->request->data['Cliente']['telefono1'] != ''){
      
        // Seteo de variables para guardarlos en la bd
        $this->request->data['Cliente']['correo_electronico'] = $this->request->data['Cliente']['correo_electronico'];
        $this->request->data['Cliente']['telefono1']          = $this->request->data['Cliente']['telefono1'];
  
      }elseif( $this->request->data['Cliente']['correo_electronico'] != '' ){
        
        // Seteo de variables para guardarlos en la bd
        $this->request->data['Cliente']['correo_electronico'] = $this->request->data['Cliente']['correo_electronico'];
        $this->request->data['Cliente']['telefono1']          = 'Sin teléfono';
  
      }else{
        
        // Seteo de variables para guardarlos en la bd
        $this->request->data['Cliente']['correo_electronico'] = 'Sin correo';
        $this->request->data['Cliente']['telefono1']          = $this->request->data['Cliente']['telefono1'];
  
      }

      if ($cliente['Cliente']['first_edit']==""){
        
        $this->request->data['Cliente']['first_edit'] = date('Y-m-d H:i:s');
                            
        $cliente = $this->Cliente->read(null,$id);
        $usuario = $this->User->read(null,$this->Session->read('Auth.User.id'));
        $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
        $this->Email = new CakeEmail();
        $this->Email->config(array(
                    'host' => $mailconfig['Mailconfig']['smtp'],
                    'port' => $mailconfig['Mailconfig']['puerto'],
                    'username' => $mailconfig['Mailconfig']['usuario'],
                    'password' => $mailconfig['Mailconfig']['password'],
                    'transport' => 'Smtp'
                    )
            );
        $this->Email->emailFormat('html');
        $this->Email->template('notificacioncliente','layoutinmomail');
        $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
        $this->Email->to($this->Session->read('Parametros.Paramconfig.to_mr'));
        $this->Email->subject('Primer seguimiento realizado');
        $this->Email->viewVars(array('cliente' => $cliente,'usuario'=>$usuario));
        //$this->Email->send();
        
        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']=  uniqid();
        $this->request->data['LogCliente']['cliente_id']=$id;
        $this->request->data['LogCliente']['user_id']=$this->Session->read('Auth.User.id');
        $this->request->data['LogCliente']['mensaje']="Primer seguimiento";
        $this->request->data['LogCliente']['accion']=2;
        $this->request->data['LogCliente']['datetime']=date('Y-m-d h:i:s');
        $this->LogCliente->save($this->request->data);
      }
      
      $this->request->data['Cliente']['last_edit'] = date('Y-m-d H:i:s');
                
                
      $this->LogCliente->create();
      $this->request->data['LogCliente']['id']         =  uniqid();
      $this->request->data['LogCliente']['cliente_id'] = $id;
      $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
      $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
      $this->request->data['LogCliente']['accion']     = 2;
      $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
      $this->LogCliente->save($this->request->data);
                
      if ($this->Cliente->save($this->request->data)) {

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('Los cambios del cliente se han guardado exitosamente.', 'default', array(), 'm_success');
        return $this->redirect(array('action' => 'view',$id));

      } else {

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('No se ha podido guardar correctamente los cambios, <br> favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');

      }
    } else {
        $options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
        $cliente = $this->Cliente->find('first', $options);
        $this->request->data = $cliente;
        
        $users = $this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.Cuenta.id').")")));
        $desarrollos=$this->Desarrollo->find('list',array('order'=>'Desarrollo.nombre ASC'));
        $inmuebles = $this->Inmueble->find('list',array('order'=>'Inmueble.titulo ASC','conditions'=>array('Inmueble.liberada'=>1)));
        $tipos_cliente = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $etapas = $this->DicEtapa->find('list',array('order'=>'DicEtapa.etapa ASC','conditions'=>array('DicEtapa.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $this->set(compact('users'));
        $this->set(compact('desarrollos'));
        $this->set(compact('inmuebles'));
        // $this->set(compact('descontinuados'));
        $this->set(compact('tipos_cliente'));
        $this->set(compact('linea_contactos'));
        $this->set(compact('etapas'));
        $this->set('cliente',$this->Cliente->read(null,$id));
                    
    }

  }

  /* ------- Edicion de prospeccion y actualizacion de etapa del cliente ------ */
  /**
   * Este metodo tiene la funcionalidad de cambiar la etapa del cliente, haciendo
   * validaciones si se hizo el cambio de información de prospección o no.
   * En el cambio de etapa se deben realizar validaciones las cuales son:
   * 1.- Existen bloqueos para los cambios de etapa.
   * 2.- Solo se pueden hacer aciendo los metodos existentes y obligatorios.
  */
  public function editProspeccion() {

    header('Content-type: application/json charset=utf-8');
    $bandera = true;
    $mensaje = '';

    if ($this->request->is(array('post', 'put'))) {
      
      // Paso 1.- Identificar cuales son los cambios en el cliente.
      // Solo hace el cambio de etapa
      if( $this->request->data['Cliente']['cambio_etapa'] == 1 ){
        $dataEtapaCliente = array(
          'cliente_id'        => $this->request->data['Cliente']['id'],
          'user_id'           => $this->Session->read('Auth.User.id'),
          'cliente_etapa'     => $this->request->data['Cliente']['etapa'],
          'clienteComentario' => $this->request->data['Cliente']['comentarios']
        );
        $save_edit_etapa = $this->editEtapa($dataEtapaCliente);
        $mensaje .= ' '.$save_edit_etapa['mensaje'];
        $bandera  = $save_edit_etapa['bandera'];
      }
      
      // Solo hace la actualización de los datos de prospeccion
      if( $this->request->data['Cliente']['edit_prospeccion'] == 1){
        $dataInformacionProspeccion = array(
          'cliente_id'                     => $this->request->data['Cliente']['id'],
          'user_id'                        => $this->Session->read('Auth.User.id'),
          'operacion_prospeccion'          => $this->request->data['Cliente']['operacion_prospeccion'],
          'precio_min_prospeccion'         => $this->request->data['Cliente']['precio_min_prospeccion'],
          'precio_max_prospeccion'         => $this->request->data['Cliente']['precio_max_prospeccion'],
          'forma_pago_prospeccion'         => $this->request->data['Cliente']['forma_pago_prospeccion'],
          'tipo_propiedad_prospeccion'     => $this->request->data['Cliente']['tipo_propiedad_prospeccion'],
          'metros_min_prospeccion'         => $this->request->data['Cliente']['metros_min_prospeccion'],
          'metros_max_prospeccion'         => $this->request->data['Cliente']['metros_max_prospeccion'],
          'hab_prospeccion'                => $this->request->data['Cliente']['hab_prospeccion'],
          'banios_prospeccion'             => $this->request->data['Cliente']['banios_prospeccion'],
          'estacionamientos_prospeccion'   => $this->request->data['Cliente']['estacionamientos_prospeccion'],
          'amenidades_prospeccion_arreglo' => $this->request->data['Cliente']['amenidades_prospeccion_arreglo'],
          'ciudad_prospeccion'             => $this->request->data['Cliente']['ciudad_prospeccion'],
          'estado_prospeccion'             => $this->request->data['Cliente']['estado_prospeccion'],
          'colonia_prospeccion'            => $this->request->data['Cliente']['colonia_prospeccion'],
          'zona_prospeccion'               => $this->request->data['Cliente']['zona_prospeccion'],
        );
        $save_edit_prospeccion = $this->editInformacionProspeccion( $dataInformacionProspeccion );
        $mensaje .= ' '.$save_edit_prospeccion['mensaje'];
        $bandera  = $save_edit_prospeccion['bandera'];
      }
  
    }

    // Paso 2.- Retornar la respuesta de los metodos.
    $response = array(
      'bander'  => $bandera,
      'mensaje' => $mensaje
    );
    
    $this->Session->setFlash('', 'default', array(), 'success');
    $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success');

    // Paso 3.- Redireccion.
    echo json_encode( $response );
    exit();
    $this->autoRender = false;

  }

  /* ---------------------- Cambio de etapa del cliente. ---------------------- */
  function editEtapa( $data = null ){
    $flag = false;
    
    // Etapa actual y etapa anterior.
    // Validaciones de etapa
    // 1.- El cliente solo puede pasar de etapa 1 a 2 de forma manual
    if( ($data['cliente_etapa'] - 1) == 1 ){

      $cliente_etapa = $this->LogClientesEtapa->find('first',
        array(
          'conditions' => array(
            'LogClientesEtapa.etapa'      => 1,
            'LogClientesEtapa.status'     => 'Activo',
            'LogClientesEtapa.cliente_id' => $data['cliente_id'],
          )
        )
      );

      if( !empty($cliente_etapa) ){
          // Pasamos la etapa 1 a desactivar.
          $this->request->data['LogClientesEtapa']['id']     = $cliente_etapa['LogClientesEtapa']['id'];
          $this->request->data['LogClientesEtapa']['status'] = 'Inactivo';

          $this->LogClientesEtapa->save($this->request->data);
      }
      $flag = true;
    }

    // El cliente puede pasar a etapa 3 de forma manual
    if( ($data['cliente_etapa'] - 1) == 2 ){

      $cliente_etapa = $this->LogClientesEtapa->find('first',
        array(
          'conditions' => array(
            'LogClientesEtapa.etapa'      => 2,
            'LogClientesEtapa.status'     => 'Activo',
            'LogClientesEtapa.cliente_id' => $data['cliente_id'],
          )
        )
      );

      if( !empty($cliente_etapa) ){
          // Pasamos la etapa 1 a desactivar.
          $this->request->data['LogClientesEtapa']['id']     = $cliente_etapa['LogClientesEtapa']['id'];
          $this->request->data['LogClientesEtapa']['status'] = 'Inactivo';

          $this->LogClientesEtapa->save($this->request->data);
      }
      $flag = true;
    }

    // El cliente puede pasar a etapa 4 de forma manual
    if( ($data['cliente_etapa'] - 1) == 4 ){

      $cliente_etapa = $this->LogClientesEtapa->find('first',
        array(
          'conditions' => array(
            'LogClientesEtapa.etapa'      => 4,
            'LogClientesEtapa.status'     => 'Activo',
            'LogClientesEtapa.cliente_id' => $data['cliente_id'],
          )
        )
      );

      if( !empty($cliente_etapa) ){
          // Pasamos la etapa 4 a desactivar.
          $this->request->data['LogClientesEtapa']['id']     = $cliente_etapa['LogClientesEtapa']['id'];
          $this->request->data['LogClientesEtapa']['status'] = 'Inactivo';

          $this->LogClientesEtapa->save($this->request->data);
      }
      $flag = true;
    }




    if( $flag == true ){
      
      $this->LogCliente->create();
      $this->request->data['LogCliente']['id']         = uniqid();
      $this->request->data['LogCliente']['cliente_id'] = $data['cliente_id'];
      $this->request->data['LogCliente']['user_id']    = $data['user_id'];
      $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
      $this->request->data['LogCliente']['accion']     = 2;
      $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
      $this->LogCliente->save($this->request->data);

      if( ($data['cliente_etapa'] - 1) == 1 ){
        $mensajeAgenda = 'El cliente cambia manualmente 2.- '.$this->etapas_cliente[$data['cliente_etapa']].' por la siguiente razón: '.$data['clienteComentario'];
      }elseif ( ($data['cliente_etapa'] - 1) == 2 ){
        $mensajeAgenda = 'El cliente cambia manualmente a etapa 3.-'.$this->etapas_cliente[$data['cliente_etapa']].', bajo reponsabilidad del usuario, por la siguiente razón: '.$data['clienteComentario'];
      }elseif ( ($data['cliente_etapa'] - 1) == 4 ){
        $mensajeAgenda = 'El cliente cambia manualmente a etapa 5.-'.$this->etapas_cliente[$data['cliente_etapa']].' "bajo responsabilidad del  usuario", por la siguiente razón: '.$data['clienteComentario'].'. '.date('d-m-Y h:i:s');
      }else{
        $mensajeAgenda = '';
      }
      
      $this->request->data['Agenda']['user_id']        = $data['user_id'];
      $this->request->data['Agenda']['mensaje']        = $mensajeAgenda;
      $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
      $this->request->data['Agenda']['cliente_id']     = $data['cliente_id'];
      $this->Agenda->save($this->request->data);
  
      // Guardar la informacion del cliente, de cambio de etapa y del ult seguimiento.
      $this->request->data['Cliente']['id']          = $data['cliente_id'];
      $this->request->data['Cliente']['comentarios'] = $data['clienteComentario'];
      $this->request->data['Cliente']['etapa']       = $data['cliente_etapa'];
      $this->request->data['Cliente']['last_edit']   = date('Y-m-d H:i:s');
      //rogueEtapaFecha
      $this->request->data['Cliente']['fecha_cambio_etapa'] = date('Y-m-d');

      if( !empty($cliente_etapa) ){
        // Insercion de la etapa.
        $this->LogClientesEtapa->create();
        $this->request->data['LogClientesEtapa']['id']            = null;
        $this->request->data['LogClientesEtapa']['cliente_id']    = $data['cliente_id'];
        $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
        $this->request->data['LogClientesEtapa']['etapa']         = $data['cliente_etapa'];
        $this->request->data['LogClientesEtapa']['desarrollo_id'] = $cliente_etapa['LogClientesEtapa']['desarrollo_id'];
        $this->request->data['LogClientesEtapa']['inmuble_id']    = $cliente_etapa['LogClientesEtapa']['inmuble_id'];
        $this->request->data['LogClientesEtapa']['status']        = 'Activo';
        $this->request->data['LogClientesEtapa']['user_id']       = $data['user_id'];
        $this->LogClientesEtapa->save($this->request->data);
      }else{

        $cliente = $this->Cliente->find('first', array('conditions' => array('Cliente.id' => $data['cliente_id'] )) );
        // Insercion de la etapa.
        $this->LogClientesEtapa->create();
        $this->request->data['LogClientesEtapa']['id']            = null;
        $this->request->data['LogClientesEtapa']['cliente_id']    = $data['cliente_id'];
        $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
        $this->request->data['LogClientesEtapa']['etapa']         = $data['cliente_etapa'];
        $this->request->data['LogClientesEtapa']['desarrollo_id'] = ( (empty($cliente['Cliente']['desarrollo_id']) ? 0 : $cliente['Cliente']['desarrollo_id']) );
        $this->request->data['LogClientesEtapa']['inmuble_id']    = ( (empty($cliente['Cliente']['inmueble_id']) ? 0 : $cliente['Cliente']['inmueble_id']) );
        $this->request->data['LogClientesEtapa']['status']        = 'Activo';
        $this->request->data['LogClientesEtapa']['user_id']       = $data['user_id'];
        $this->LogClientesEtapa->save($this->request->data);
      }


  
      if ($this->Cliente->save($this->request->data)) {
        $mensaje = 'El cambio de etapa del cliente ha sido exitoso.';
        $bandera = true;
      }else{
        $mensaje = 'Fallo en el metodo de editEtapa.';
        $bandera = false;
      }
    }else{
      $mensaje = 'Ocurrio un error al intentar cambiar de etapa.';
      $bandera = true;
    }
    
    $response = array(
      'bandera' => $bandera,
      'mensaje' => $mensaje
    );

    return $response;

  }

  /* ------------------ Edicion de informacion de prospeccion ----------------- */
  function editInformacionProspeccion( $data = null ){
    
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

  /**
   * Este metodo valida la etapa en la que se encuentra el cliente,
   * dependiendo de en que etapa se encuentre deja cambiarla o regresa
   * a su validacion correspondinete
   * 
   * AKA SaaK - 16/Oct/2022
   *  
  */
  
  function validateEtapa(){
    
    // Si el cliente tiene una etapa mayo a 1 y no tiene el log de la etapa, crea el valor de la etapa 1 en el log con la fecha de creación del cliente.
    // Si el cliente tiene etapa 2 y no tiene log, crea un registro con la etapa en la que se encuentra y con fecha de cambio de etapa del ultimo seguimiento.
    // No hay forma de pasar de la etapa 1 a las demas, si no se tiene el registro de la etapa 2.





  }




  public function editNivelInteres($idCliente = null, $nivel = null){
      if (!$idCliente) {
        $this->Session->setFlash(__('Cliente inválido', true));
        $this->redirect(array('action'=>'index'));
      }else{
        $cliente = array(
          'id'=>$idCliente,
          'nivel_interes_prospeccion'=>$nivel
        );
        if($this->Cliente->save($cliente)){

          $interes = array(
            1 => 'Bajo',
            2 => 'Medio',
            3 => 'Alto',
          );
          $this->request->data['Agenda']['user_id']        = $this->Session->read('Auth.User.id');
          $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
          $this->request->data['Agenda']['mensaje']        = "Se registra nivel del interés del cliente: ".$interes[$nivel];
          $this->request->data['Agenda']['cliente_id']     = $idCliente;
          $this->Agenda->save($this->request->data);

          $this->Session->setFlash('', 'default', array(), 'success');
          $this->Session->setFlash('El nivel de Interés del cliente se ha guardado exitosamente.', 'default', array(), 'm_success');
          return $this->redirect(array('action' => 'view',$idCliente));
        }
      }
  }

  public function getCiudades(){

    $this->loadModel('Cp');
    $ciudades = array();
    if (isset($this->request['data']['estado'])) {
        $ciudades = $this->Cp->find(
            'list',
            array(
                'fields'=>array(
                    'Cp.municipio','Cp.municipio'
                ),
                'conditions'=>array(
                    'Cp.estado'=>$this->request['data']['estado']
                ),
                'order'=>'Cp.municipio ASC'
            )
        );
    }

    header('Content-Type: application/json');
    echo json_encode($ciudades);
    exit();
  }

  public function getColonias(){

    $this->loadModel('Cp');
    $colonias = array();
    if (isset($this->request['data']['estado']) && isset($this->request['data']['ciudad'])) {
        $colonias = $this->Cp->find(
            'list',
            array(
                'fields'=>array(
                    'Cp.colonia','Cp.colonia'
                ),
                'conditions'=>array(
                    'Cp.estado'=>$this->request['data']['estado'],
                    'Cp.municipio'=>$this->request['data']['ciudad'],
                ),
                'order'=>'Cp.colonia ASC'
            )
        );
    }

    header('Content-Type: application/json');
    echo json_encode($colonias);
    exit();
  }

  public function reasignar(){
    $this->User->Behaviors->load('Containable');

    if ($this->request->is('post')){
      $this->loadModel('Reasignacion');
      $reasignacion = array(
        'cliente_id'      => $this->request->data['Cliente']['cliente_id'],
        'asesor_original' => $this->request->data['Cliente']['asesor_original'],
        'asesor_nuevo'    => $this->request->data['Cliente']['asesor_id'],
        'fecha'           => date('Y-m-d H:i:s'),
        'motivo_cambio'   => $this->request->data['Cliente']['motivo'],
        'user_id'         => $this->Session->read('Auth.User.id')
      );

      // Paso 1.- Guardar el nombre del asesor anterior y el siguiente para la creacion del seguimiento rapido.
      $previous_agent = $this->User->find('first', array(
        'conditions' => array('User.id' => $this->request->data['Cliente']['asesor_original']),
        'fields'     => array('User.nombre_completo'),
        'contain'    => false
      ));

      $next_agent = $this->User->find('first', array(
        'conditions' => array('User.id' => $this->request->data['Cliente']['asesor_id']),
        'fields'     => array('User.nombre_completo'),
        'contain'    => false
      ));


      if ($this->Reasignacion->save($reasignacion)){

        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']    = "El cliente ha sido reasignado del agente ".$previous_agent['User']['nombre_completo']." a ".$next_agent['User']['nombre_completo']." por la siguiente razón: ".$this->request->data['Cliente']['motivo'];
        $this->request->data['Agenda']['cliente_id'] = $this->request->data['Cliente']['cliente_id'];
        $this->Agenda->save($this->request->data);

        $this->Cliente->query("UPDATE clientes SET user_id = ".$this->request->data['Cliente']['asesor_id'].", last_edit = '".date('Y-m-d H:i:s')."' WHERE id = ".$this->request->data['Cliente']['cliente_id']);

        $this->Inmueble->Behaviors->load('Containable');
        $propiedades = $this->Inmueble->find(
          'all',
          array(
            'fields'=>array(
              'id','referencia'
            ),
            'contain'=>array(
              'FotoInmueble'
            ),
            'conditions'=>array(
              "Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE cliente_id = ".$this->request->data['Cliente']['cliente_id'].")"
            )
          )
        );
        
        $this->Desarrollo->Behaviors->load('Containable');
        $desarrollos = $this->Desarrollo->find(
          'all',
          array(
            'fields'=>array(
              'id','nombre'
            ),
            'contain'=>array(
              'FotoDesarrollo'
            ),
            'recursive'=>2,
            'conditions'=>array(
              "Desarrollo.id IN (SELECT leads.desarrollo_id FROM leads WHERE cliente_id = ".$this->request->data['Cliente']['cliente_id'].")"
            )
          )
        );

        $this->loadModel('User');
        $this->User->Behaviors->load('Containable');
        $usuario = $this->User->find(
          'first',
          array(
            'conditions'=>array(
              'User.id'=>$this->request->data['Cliente']['asesor_id']
            ),
            'fields'=>array(
              'id','nombre_completo','correo_electronico'
            ),
            'contain'=>false
          )
        );

        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $cliente = $this->Cliente->find(
          'first',
          array(
            'conditions'=>array(
              'Cliente.id'=>$this->request->data['Cliente']['cliente_id']
            ),
            'fields'=>array(
              'id','nombre','created','telefono1','telefono2','correo_electronico','dic_linea_contacto_id'
            ),
            'contain'=>array(
              'DicLineaContacto'=>array(
                'fields'=>array(
                  'linea_contacto','id'
                )
              )
            )
          )
        );

        $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
        $this->Email = new CakeEmail();
        $this->Email->config(array(
            'host' => $mailconfig['Mailconfig']['smtp'],
            'port' => $mailconfig['Mailconfig']['puerto'],
            'username' => $mailconfig['Mailconfig']['usuario'],
            'password' => $mailconfig['Mailconfig']['password'],
            'transport' => 'Smtp'
            )
        );
        $this->Email->emailFormat('html');
        $this->Email->template('emailaasesor','layoutinmomail');
        $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
        $this->Email->to($usuario['User']['correo_electronico']);
        $this->Email->subject('Nuevo cliente asignado');
        $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
        $this->Email->send();

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('Se ha reasignado el cliente al nuevo asesor.', 'default', array(), 'm_success');
        return $this->redirect(array('action' => 'view',$this->request->data['Cliente']['cliente_id']));
      }
    }

  }  
        
  public function asignar($id = null) {
        //$this->layout= 'bos';
                $this->loadModel('Paramconfig');
        if (!$this->Cliente->exists($id)) {
            throw new NotFoundException(__('Invalid cliente'));
        }
        if ($this->request->is(array('post', 'put'))) {
                            $timestamp                                    = date('Y-m-d H:i:s');
                            $this->request->data['Cliente']['asignado']   = $timestamp;
                            $this->request->data['Cliente']['first_edit'] = $timestamp;
                            $this->request->data['Cliente']['last_edit']  = $timestamp;
                            $cliente                                      = $this->Cliente->read(null,$this->request->data['Cliente']['cliente_id']);
                            $cliente_id                                   = $this->request->data['Cliente']['cliente_id'];
                            $this->request->data['Cliente']['id']         = $this->request->data['Cliente']['cliente_id'];
                            $usuario                                      = $this->User->read(null,$this->request->data['Cliente']['user_id']);
                            $mailconfig                                   = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                            $paramconfig                                  = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));
                        //Crear evento de reactivacion
                        if ($this->Cliente->save($this->request->data)) {
                            
                                //Registrar Seguimiento Rápido
                                $this->Agenda->create();
                                $this->request->data['Agenda']['user_id']=$this->Session->read('Auth.User.id');
                                $this->request->data['Agenda']['fecha']=date('Y-m-d H:i:s');
                                $this->request->data['Agenda']['mensaje']="Cliente asignado a ".$usuario['User']['nombre_completo'];
                                $this->request->data['Agenda']['cliente_id']=$cliente_id;
                                $this->Agenda->save($this->request->data);
                                
                                $this->Inmueble->Behaviors->load('Containable');
                                $propiedades = $this->Inmueble->find(
                                  'all',
                                  array(
                                    'fields'=>array(
                                      'id','referencia'
                                    ),
                                    'contain'=>array(
                                      'FotoInmueble'
                                    ),
                                    'conditions'=>array(
                                      "Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE cliente_id = $cliente_id)"
                                    )
                                  )
                                );
                                
                                $this->Desarrollo->Behaviors->load('Containable');
                                $desarrollos = $this->Desarrollo->find(
                                  'all',
                                  array(
                                    'fields'=>array(
                                      'id','nombre'
                                    ),
                                    'contain'=>array(
                                      'FotoDesarrollo'
                                    ),
                                    'recursive'=>2,
                                    'conditions'=>array(
                                      "Desarrollo.id IN (SELECT leads.desarrollo_id FROM leads WHERE cliente_id = $cliente_id)"
                                    )
                                  )
                                );
                                
                                // if (!empty($cliente['Cliente']['correo_electronico'])){
                                if ($cliente['Cliente']['correo_electronico'] != 'Sin correo'){
                                    
                                        $this->Email = new CakeEmail(); 
                                        $this->Email->config(array(
                                                'host' => $mailconfig['Mailconfig']['smtp'],
                                                'port' => $mailconfig['Mailconfig']['puerto'],
                                                'username' => $mailconfig['Mailconfig']['usuario'],
                                                'password' => $mailconfig['Mailconfig']['password'],
                                                'transport' => 'Smtp'
                                                )
                                            );
                                        
                                        $arreglo_emails = array();
                                        if ($paramconfig['Paramconfig']['cc_a_c']!=""){
                                                $emails = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                                                
                                                if (sizeof($emails)>0){
                                                    foreach($emails as $email):
                                                        $arreglo_emails[$email] = $email;
                                                    endforeach;
                                                }else{
                                                    $arreglo_emails[$paramconfig['Paramconfig']['cc_ac_']] = $paramconfig['Paramconfig']['cc_a_c'];
                                                }
                                                
                                        }
                                        $arreglo_emails[$usuario['User']['correo_electronico']] = $usuario['User']['correo_electronico'];
                                        $this->Email->bcc( $arreglo_emails );
                                        
                                        $this->Email->emailFormat('html');
                                        $this->Email->template('emailacliente','layoutinmomail');
                                        $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                                        $this->Email->to($cliente['Cliente']['correo_electronico']);
                                        $this->Email->subject($paramconfig['Paramconfig']['smessage_new_client']);
                                        // $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
                                        $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_new_client'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                                        $this->Email->send();
                                        
                                       
                                        $this->Email = new CakeEmail();
                                            $this->Email->config(array(
                                                'host' => $mailconfig['Mailconfig']['smtp'],
                                                'port' => $mailconfig['Mailconfig']['puerto'],
                                                'username' => $mailconfig['Mailconfig']['usuario'],
                                                'password' => $mailconfig['Mailconfig']['password'],
                                                'transport' => 'Smtp'
                                                )
                                                );
                                            $this->Email->to(array($usuario['User']['correo_electronico']=>$usuario['User']['correo_electronico']));
                                            if ($paramconfig['Paramconfig']['asignacion_c_a']!=""){
                                                $emails2 = explode( ",", $paramconfig['Paramconfig']['asignacion_c_a'] );
                                                $arreglo_emails2 = array();
                                                if (sizeof($emails2)>0){
                                                    foreach($emails2 as $email):
                                                        $arreglo_emails2[$email] = $email;
                                                    endforeach;
                                                }else{
                                                    $arreglo_emails2[$paramconfig['Paramconfig']['asignacion_c_a']] = $paramconfig['Paramconfig']['asignacion_c_a'];
                                                }
                                                $this->Email->bcc($arreglo_emails2);
                                            }
                                            $this->Email->emailFormat('html');
                                            $this->Email->template('emailaasesor','layoutinmomail');
                                            $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
                                            
                                            $this->Email->subject('Nuevo cliente asignado');
                                            $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
                                            $this->Email->send();
                                            //echo var_dump($this->Email);
                                     
                                            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                                            $this->Session->setFlash('Se ha asignado el cliente al asesor de manera exitosa.', 'default', array(), 'm_success');
                                    }else{
                                        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                                        $this->Session->setFlash('Se ha asignado correctamente el asesor, sin embargo el cliente NO recibirá notificación, porque no cuenta con correo electrónico registrado.', 'default', array(), 'm_success');
                                    }
                                    
                return $this->redirect(array('action' => 'index'));
            } 
                        else {
                $this->Session->setFlash(__('The cliente could not be saved. Please, try again.'));
            }
        } else {
            $this->set('cliente',$this->Cliente->read(null,$id));
                        $this->set('leads',$this->Lead->find('all',array('recursive'=>2,'conditions'=>array('Cliente.id'=>$id,'Lead.inmueble_id !='=>null))));
                        $this->set('desarrollos',$this->Lead->find('all',array('recursive'=>2,'conditions'=>array('Cliente.id'=>$id,'Lead.desarrollo_id !='=>""))));
                        $this->set('users',$this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'))));
        }
        
  }

  public function delete($id = null, $ruta=null) {
        $this->Cliente->id = $id;
        if (!$this->Cliente->exists()) {
            throw new NotFoundException(__('Invalid cliente'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Cliente->delete()) {
          $this->Cliente->query("DELETE FROM leads WHERE cliente_id = $id");
          $this->Cliente->query("DELETE FROM reasignacions WHERE cliente_id = $id");
          $this->Cliente->query("DELETE FROM log_clientes WHERE cliente_id = $id");
          $this->Cliente->query("DELETE FROM agendas WHERE cliente_id = $id");
          $this->Cliente->query("DELETE FROM events WHERE cliente_id = $id");
          $this->Cliente->query("DELETE FROM log_clientes_etapas WHERE cliente_id = $id");

          $this->Session->setFlash(__('El cliente ha sido eliminado exitosamente'),'default',array('class'=>'mensaje_exito'));
          return $this->redirect(array('action' => 'index'));
                        
        } else {
            $this->Session->setFlash(__('The cliente could not be deleted. Please, try again.'),'default',array('class'=>'mensaje_error'));
        }
                if ($ruta == 2){
                    return $this->redirect(array('action' => 'sinasignar'));
                }
  }

 

  /***
   * 02/02/2023 
   * aka rogueOne
   * problema tarda en cargar la vista 
   * se hace el canbio de consulta
   * 
  */
  public function sinasignar() {
    $this->Cliente->Behaviors->load('Containable');
    $clientes = $this->Cliente->find('all', array(
      'conditions' => array(
        'AND'=>array(
          'Cliente.user_id IS NULL',
          'Cliente.status' => 'Activo'
        ),
        'OR'=>array(
          'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
          "Cliente.desarrollo_id IN (SELECT id FROM desarrollos WHERE comercializador_id = ".$this->Session->read('CuentaUsuario.Cuenta.id').")"
        ),
      ),
      'fields' => array(
          'id',
          'correo_electronico',
          'nombre',
          'telefono1',
          'status',
          'etapa',
          'created',
      ),
      'contain' => array(
        'DicTipoCliente' => array(
          'fields' => 'tipo_cliente'
        ),
        'DicEtapa' => array(
          'fields' => 'etapa'
        ),
        'Inmueble' => array(
          'fields' => array(
            'titulo'
          )
        ),
        'Desarrollo' => array(
          'fields' => 'nombre'
        ),
        ),
      )
    );
    $this->set('clientes', $clientes);
    $this->set('users',$this->Cliente->User->find('list'));
  }
        
  public function enviarmail(){
      $this->Email = new CakeEmail();
      $this->Email->config(array(
                  'host' => 'ssl://lpmail01.lunariffic.com',
                  'port' => 465,
                  'username' => 'sistemabos@bosinmobiliaria.mx',
                  'password' => 'Sistema.2016',
                  'transport' => 'Smtp'
                  )
          );
      $this->Email->emailFormat('html');
      $this->Email->template('pruebamail','layoutinmomail');
      $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
      $this->Email->to('cesari.pineda@gmail.com');
      $this->Email->subject('Prueba de Correo');
      //$this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
      $this->Email->send();
  }
  
  function mail_callcenter(){
      $this->layout = 'blank';
      $this->set('propiedades', $this->Inmueble->find('all',array('limit'=>5)));
      $this->set('desarrollos',$this->Desarrollo->find('all'));
      $this->set('cliente',$this->Cliente->read(null,3584));
      $this->set('usuario',$this->User->read(null,$this->Session->read('Auth.User.id')));
              
  }
  
  public function registrar_llamada( $cliente_id = null ){
      //$cliente = $this->Cliente->findAllById( $cliente_id );

      if ( $this->request->data['Cliente']['mensaje'] != '' ) { $mensaje = 'Se realizó llamada a cliente: '.$this->request->data['Cliente']['mensaje']; }
      else{ $mensaje = 'Se realizó llamada a cliente'; }

      $this->LogCliente->create();
      $this->request->data['LogCliente']['id']         =  uniqid();
      $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
      $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
      $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
      $this->request->data['LogCliente']['accion']     = 4;
      $this->request->data['LogCliente']['mensaje']    = $mensaje;
      $this->LogCliente->save($this->request->data);
      
      
      //Registrar Seguimiento Rápido
      $this->Agenda->create();
      $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
      $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
      $this->request->data['Agenda']['mensaje']    = $mensaje;
      $this->request->data['Agenda']['cliente_id'] = $cliente_id;
      $this->Agenda->save($this->request->data);

      $this->Cliente->query("UPDATE clientes SET last_edit = '".date('Y-m-d H:i:s')."' WHERE id = $cliente_id");
      
      $this->Session->setFlash('', 'default', array(), 'success');
      $this->Session->setFlash('Se ha registrado una llamada al cliente.', 'default', array(), 'm_success'); // Mensaje
      $this->redirect( array( 'action' => 'view',$cliente_id ) );
  }
  
  /* -------------------------------------------------------------------------- */
  /*              Envio de mensajes por correo al cliente vía Ajax.             */
  /* -------------------------------------------------------------------------- */
  public function send_correo(){
    header('Content-type: application/json charset=utf-8');
    $timestamp = date('Y-m-d H:i:s');
    
    if ($this->request->is(array('post', 'put'))) {

      $response['contenido'] = $this->request->data;

      $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
      $cliente_id = $this->request->data['Cliente']['cliente_id'];
      $cliente    = $this->Cliente->read(null,$cliente_id);
      $usuario    = $this->User->read(null, $this->Session->read('Auth.User.id'));

      $this->Email = new CakeEmail();
      $this->Email->config(array(
          'host'      => $mailconfig['Mailconfig']['smtp'],
          'port'      => $mailconfig['Mailconfig']['puerto'],
          'username'  => $mailconfig['Mailconfig']['usuario'],
          'password'  => $mailconfig['Mailconfig']['password'],
          'transport' => 'Smtp'
          )
      );

      $this->Email->emailFormat('html');
      $this->Email->template('emailgeneral','layoutinmomail');
      $this->Email->from(array($this->Session->read('Auth.User.correo_electronico')=>$this->Session->read('Auth.User.nombre_completo')));
      $this->Email->to($cliente['Cliente']['correo_electronico']);
      // $this->Email->attachments($this->request->data['Cliente']['adjunto']['tmp_name']);

      $this->Email->attachments(array(
        $this->request->data['Cliente']['adjunto']['name'] => array(
              'file'     => $this->request->data['Cliente']['adjunto']['tmp_name'],
              'mimetype' => $this->request->data['Cliente']['adjunto']['type'],
          )
      ));

      if ($this->request->data['Cliente']['cc'] != ""){
        $this->Email->cc(explode(',', $this->request->data['Cliente']['cc']));
      }

      if ($this->request->data['Cliente']['bcc'] != ""){
        $this->Email->bcc(explode(',', $this->request->data['Cliente']['bcc']));
      }

      $this->Email->subject($this->request->data['Cliente']['asunto']);
      $this->Email->viewVars(array('contenido'=>$this->request->data['Cliente']['contenido'], 'cliente'=>$cliente, 'usuario'=>$usuario));
      
      if( $this->Email->send() ){
        
        // Mensaje de respuesta.
        $response['mensaje'] = 'Se ha enviado el correo correctamente.';
        
        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         =  uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Cliente']['cliente_id'];
        $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
        $this->request->data['LogCliente']['accion']     = 3;
        $this->request->data['LogCliente']['mensaje']    = "Email a cliente ".$cliente['Cliente']['nombre']." a las ".date('Y-m-d H:i:s');
        $this->LogCliente->save($this->request->data);

        
        //Registrar Seguimiento Rápido
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']=$this->Session->read('Auth.User.id');
        $this->request->data['Agenda']['fecha']=$timestamp;
        $this->request->data['Agenda']['mensaje']="Se envía correo electrónico a cliente";
        $this->request->data['Agenda']['cliente_id']=$cliente_id;
        $this->Agenda->save($this->request->data);
        $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = $cliente_id");

      }else{
        
        // Mensaje de respuesta.
        $response['mensaje'] = 'Ocurrio un problema en el envio del correo, favor de intentarlo nuevamente, gracias.';

      }

      $this->Session->setFlash('', 'default', array(), 'success');
      $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success'); // Mensaje

    }

    echo json_encode( $response );
    $this->autoRender = false; 
      
  }
  
  public function log_clientes($accion = null, $cliente_id = null){
      $listLogCliente = [];
      $cliente = $this->Cliente->find('first', array('conditions'=>array('Cliente.id'=>$cliente_id), 'recursive'=>0, 'fields'=>array('nombre')));
      $accionLogCliente = array(3 => 'Mail', 4 => 'Llamada', 5 => 'Cita', 10=>'Visita');
      $accionLogClienteHeader = array(3 => 'Mail(s)', 4 => 'Llamada(s)', 5 => 'Cita(s)', 10=>'Visita(s)');

      $header_cliente = "<a href='".Router::url(array('controller'=>'clientes', 'action'=>'view', $cliente_id))."'>".$accionLogClienteHeader[$accion].' de '.$cliente['Cliente']['nombre']."</a>";

      $logCliente = $this->LogCliente->find('all',
          array(
              'conditions'=>array(
                  'LogCliente.accion' => $accion,
                  'LogCliente.cliente_id' => $cliente_id
              ),
              'fields' => array(
                  'LogCliente.id',
                  'LogCliente.cliente_id',
                  'LogCliente.user_id',
                  'LogCliente.datetime',
                  'LogCliente.accion',
                  'LogCliente.mensaje',
                  'User.id',
                  'User.nombre_completo',
                  'Cliente.nombre',
              ),
              'order' => array(
                  'LogCliente.datetime' => 'DESC'
              )
          )
      );

      for ($i=0; $i < count($logCliente); $i++) { 
          $listLogCliente[$i] = 
          "'<a href=".Router::url(array('controller'=>'clientes', 'action'=>'view', $logCliente[$i]['LogCliente']['cliente_id']))." class=pointer>".$logCliente[$i]['Cliente']['nombre']."</a>','".date('d-M-Y H:i', strtotime($logCliente[$i]['LogCliente']['datetime']))."','".$accionLogCliente[$logCliente[$i]['LogCliente']['accion']]."','".$logCliente[$i]['LogCliente']['mensaje']."','<a href=".Router::url(array('controller'=>'users', 'action'=>'view', $logCliente[$i]['User']['id']))." class=pointer>".$logCliente[$i]['User']['nombre_completo']."</a>'";
      }

      $this->set(compact('header_cliente'));
      $this->set(compact('listLogCliente'));


  }
        
  public function update_status($cliente_id = null){
      if ($this->request->is('post')) {
          $timestamp = date('Y-m-d H:i:s');
          $leyenda="";
          $motivo = "";
          switch($this->request->data['Status']['status']){
              case('Activo'):
                  $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus activo ";
                  break;
              
              case('Inactivo temporal'):
                  $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus inactivo temporal por motivo: ".$this->request->data['Status']['motivo']." y pide recontacto el ".$this->request->data['Status']['recordatorio_reactivacion'];
                  $this->request->data['Cliente']['temperatura']    = 2;
                  break;
              
              case('Inactivo');
                      $motivo = $this->request->data['Status']['motivo_2'];
                  $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus inactivo definitivo por motivo: ".$motivo;
                  $this->request->data['Cliente']['temperatura']    = 1;
                  break;

              case('Activo venta');
                  $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus activo venta ";
                  break;
          }

          // Cambiar el estatus al cliente
          $this->request->data['Cliente']['id']        = $cliente_id;
          $this->request->data['Cliente']['status']    = $this->request->data['Status']['status'];
          $this->request->data['Cliente']['last_edit'] = $timestamp;
          $this->Cliente->save($this->request->data);

          // Aviso en el log
          $this->LogCliente->create();
          $this->request->data['LogCliente']['id']         =  uniqid();
          $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
          $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
          $this->request->data['LogCliente']['datetime']   = $timestamp;
          $this->request->data['LogCliente']['accion']     = 2;
          $this->request->data['LogCliente']['mensaje']    = $leyenda;
          $this->LogCliente->save($this->request->data);

          $this->LogCliente->create();
          $this->request->data['LogCliente']['id']         =  uniqid();
          $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
          $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
          $this->request->data['LogCliente']['datetime']   = $timestamp;
          $this->request->data['LogCliente']['accion']     = 2;
          $this->request->data['LogCliente']['mensaje']    = "Se actualizo el estatus del cliente ".$this->request->data['Status']['nombre_cliente']." el ".date('Y-m-d H:i:s');
          $this->LogCliente->save($this->request->data);

          if ($this->request->data['Status']['status']=="Inactivo temporal"){
          // Eventos
              $this->Event->create();
              $this->request->data['Event']['cliente_id']     = $cliente_id;
              $this->request->data['Event']['user_id']        = $this->Session->read('Auth.User.id');
              $this->request->data['Event']['fecha_inicio']   = date('Y-m-d H:i:s', strtotime($this->request->data['Status']['recordatorio_reactivacion']." 10:00:00"));
              $this->request->data['Event']['recordatorio_1'] = date('Y-m-d H:i:s', strtotime($this->request->data['Status']['recordatorio_reactivacion']." 10:15:00"));
              $this->request->data['Event']['tipo_evento']    = 0;
              $this->request->data['Event']['status']         = 0;
              $this->request->data['Event']['tipo_tarea']     = 4;
              $this->request->data['Event']['cuenta_id']      = $this->Session->read('CuentaUsuario.Cuenta.id');
              $this->Event->save($this->request->data);
          }
      
          //Registrar Seguimiento Rápido
          $this->Agenda->create();
          $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
          $this->request->data['Agenda']['fecha']      = $timestamp;
          $this->request->data['Agenda']['mensaje']    = $leyenda;
          $this->request->data['Agenda']['cliente_id'] = $cliente_id;
          $this->Agenda->save($this->request->data);

          $this->Session->setFlash('', 'default', array(), 'success');
          $this->Session->setFlash('Se ha actualizado el estatus del cliente satisfactoriamente.', 'default', array(), 'm_success'); // Mensaje
          $this->redirect(array('action' => 'view', $cliente_id));
      }
  }

  public function delete_master(){
    /*--------------------------------------------------------------------------------
    *
    *   14-02-2019 -    Funcion para eliminar cliente - AKA "SaaK";
    *   24-08-2020 -    Se cambian los procesos, primero se eliminan los registros
    *   del cliente en las tablas en donde se guarda un seguimiento de el y al final
    *   se elimina el cliente.
    *
    --------------------------------------------------------------------------------*/

      $this->request->onlyAllow('post', 'delete');
      $cliente_id = $this->request->data['Cliente']['id'];
      $this->Cliente->id = $this->request->data['Cliente']['id'];

      if (!$this->Cliente->exists()) {
          $this->Session->setFlash('', 'default', array(), 'success');
          $this->Session->setFlash('No se ha podido eliminar el cliente, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
      }

      // Registro en el usuario que elimina que ha eliminado a ese cliente.
      $cliente = $this->Cliente->find('first', array( 'conditions' => array('Cliente.id' => $cliente_id) ) );

      $this->Agenda->create();
      $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
      $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
      $this->request->data['Agenda']['mensaje']    = "El cliente ".$cliente['Cliente']['nombre']." fue eliminado por el usuario ".$this->Session->read('Auth.User.nombre_completo');
      $this->request->data['Agenda']['cliente_id'] = $cliente_id;
      $this->Agenda->save($this->request->data);

      
      // $this->Cliente->query("DELETE FROM log_inmuebles WHERE log_inmuebles.inmueble_id IN (SELECT events.inmueble_id FROM events WHERE events.cliente_id = $cliente_id)");
      // $this->Cliente->query("DELETE FROM log_desarrollos WHERE log_desarrollos.desarrollo_id IN (SELECT events.desarrollo_id FROM events WHERE events.cliente_id = $cliente_id)");

      $this->Cliente->query("DELETE FROM leads WHERE cliente_id = $cliente_id");
      $this->Cliente->query("DELETE FROM events WHERE cliente_id = $cliente_id");
      $this->Cliente->query("DELETE FROM log_clientes WHERE cliente_id = $cliente_id");
      $this->Cliente->query("DELETE FROM log_clientes_etapas WHERE cliente_id = $cliente_id");

      // Eliminzación del clinete en la tabla clientes.
      if( $this->Cliente->delete() ) {

          $this->Session->setFlash('', 'default', array(), 'success');
          $this->Session->setFlash('El cliente ha sido eliminado exitosamente.', 'default', array(), 'm_success');

      }else {

          $this->Session->setFlash('', 'default', array(), 'success');
          $this->Session->setFlash('No se ha podido eliminar el clinete, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');

      }


      
      switch ($this->request->data['Cliente']['redirect']) {
          case 1:
              $redirect = array('action' => 'index');
              break;
          
          case 2:
              $redirect = array('action' => 'sinasignar');
              break;
          case 3:
              $redirect = array('action' => 'lista_terceros');
              break;
      }
      
      $this->redirect($redirect);
  }

  public function lista_terceros(){
    /**********************************************************
    *
    * Listado de otros clienes.
    *
    **********************************************************/

      $this->set('lista_terceros', $this->Cliente->find('all', array('recursive'=>-1, 'conditions'=>array('Cliente.tercero'=>1, 'Cliente.status'=>'Activo'))));
  }

  public function add_tercero(){
      if ($this->request->is(array('post', 'put'))) {
          // Agregar validacion de cliente.
          $emailLimpio = trim($this->request->data['Cliente']['correo_electronico']," ");
          $telefonoLimpio = trim($this->request->data['Cliente']['telefono1']," ");

          // Paso 1 Consultar que el usuario no exista si hay correo electronico y teléfono.
          if (!empty($this->request->data['Cliente']['correo_electronico']) && !empty($this->request->data['Cliente']['telefono1'])) {
              $cliente_db = $this->Cliente->query("
                  SELECT * FROM `inmosystem`.`clientes` AS `Cliente` WHERE
                  `Cliente`.`correo_electronico` = '".$emailLimpio."'
                  OR `Cliente`.`telefono1`       = '".$telefonoLimpio."'
                  AND `Cliente`.`cuenta_id`      = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."
                  LIMIT 1

              ");
          }elseif (!empty($this->request->data['Cliente']['correo_electronico'])) {
              $cliente_db = $this->Cliente->query("
                  SELECT * FROM `inmosystem`.`clientes` AS `Cliente` WHERE
                  `Cliente`.`correo_electronico` = '".$emailLimpio."'
                  AND `Cliente`.`cuenta_id`      = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."
                  LIMIT 1

              ");
          }elseif (!empty($this->request->data['Cliente']['telefono1'])) {
              $cliente_db = $this->Cliente->query("
                  SELECT * FROM `inmosystem`.`clientes` AS `Cliente` WHERE
                  `Cliente`.`telefono1`       = '".$telefonoLimpio."'
                  AND `Cliente`.`cuenta_id`      = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."
                  LIMIT 1

              ");

          }

          if (sizeof($cliente_db) == 0) {
              $this->Cliente->create();
              if ($this->Cliente->save($this->request->data)) {
                  $cliente_id = $this->Cliente->getInsertID();
                  $this->LogCliente->create();
                  $this->request->data['LogCliente']['id']         =  uniqid();
                  $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
                  $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                  $this->request->data['LogCliente']['mensaje']    = "Cliente creado";
                  $this->request->data['LogCliente']['accion']     = 1;
                  $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                  $this->LogCliente->save($this->request->data);
                  
                  //Registrar Seguimiento Rápido
                  $this->Agenda->create();
                  $this->request->data['Agenda']['user_id']        = $this->Session->read('Auth.User.id');
                  $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
                  $this->request->data['Agenda']['mensaje']        = "Cliente creado por usuario ".$this->Session->read('Auth.User.nombre_completo');
                  $this->request->data['Agenda']['cliente_id']     = $cliente_id;
                  $this->Agenda->save($this->request->data);

                  $this->Session->setFlash('', 'default', array(), 'success');
                  $this->Session->setFlash('Se guardo exitosamente el nuevo cliente.', 'default', array(), 'm_success');
                  $redirect = array('action' => 'view_tercero', $cliente_id);
              }else{
                  $this->Session->setFlash('', 'default', array(), 'error');
                  $this->Session->setFlash('No se guardo el nuevo cliente, favor de intentarlo nuevamente.', 'default', array(), 'm_error');
                  $redirect = array('action' => 'lista_terceros');
              }
          }else{
              $this->Session->setFlash('', 'default', array(), 'error');
              $this->Session->setFlash('El cliente ya existe en la base de datos, favor de intentar nuevamente.', 'default', array(), 'm_error');
              $redirect = array('action' => 'lista_terceros');
          }

          $this->redirect($redirect);
      }
  }

  public function view_tercero($cliente_id = null){
      $cliente = $this->Cliente->read(null, $cliente_id);

      // Hacer listado de los inmuebles
      $this->set('propiedades', $this->Inmueble->find('list', array('conditions'=>array(
          'Inmueble.id IN (SELECT inmueble_id FROM ventas WHERE ventas.cliente_id = '.$cliente_id.')'
      ))));

      // Categorias para la factura
      $this->set('categorias', array('Bancos'));
      $leads = $this->Lead->find('all',array('recursive'=>2,'conditions'=>array('Cliente.id'=>$cliente_id,'Lead.inmueble_id !='=>null)));
      $promedio_venta = 0;
      $construidos = 0;
      $terreno = 0;
      $i = 0;
      $tipo = "";
      $where = array(
              'Inmueble.liberada'=>1,
              'Inmueble.id NOT IN (SELECT inmueble_id FROM leads WHERE cliente_id = '.$cliente_id.')',
              'Inmueble.precio BETWEEN '.$promedio_venta*.9.' AND '. $promedio_venta*1.1
        );
      foreach ($leads as $lead):
          $promedio_venta += floatVal($lead['Inmueble']['precio']);
          if (!empty($lead['Inmueble']['dic_tipo_propiedad_id'])){
              $tipo = $tipo.strval($lead['Inmueble']['dic_tipo_propiedad_id']).",";
          }
          $construidos += floatVal($lead['Inmueble']['construccion']);
          $terreno = $construidos + floatVal($lead['Inmueble']['terreno']);
          $i++;
      endforeach;
      
      if ($tipo != ""){
          array_push($where, 'Inmueble.dic_tipo_propiedad_id IN('.substr($tipo, 0, -1) .')');
      }

      $promedio_venta = ($i==0 ? floatVal($promedio_venta) : floatVal($promedio_venta/$i));
      
      $options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $cliente_id));
      $this->set('cliente', $this->Cliente->find('first', $options));
      $this->set('agendas',$this->Agenda->find('all', array('order'=>'Agenda.id DESC','conditions'=>array('Agenda.cliente_id'=>$cliente_id))));
      $this->set('leads',$leads);
      $this->set('sugeridas',$this->Inmueble->find('all',array(
          'limit'=>10,
          'conditions'=>$where,
      )));
      $this->set('desarrollos',$this->Lead->find('all',array('recursive'=>2,'conditions'=>array('Cliente.id'=>$cliente_id,'Lead.desarrollo_id !='=>""))));
      
      $llaves_desarrollo = array();
      $valores_desarrollo = array();
      $desarrollos = $this->Desarrollo->FotoDesarrollo->find('all',array('fields'=>array('FotoDesarrollo.desarrollo_id, FotoDesarrollo.ruta'),'conditions'=>array('FotoDesarrollo.desarrollo_id IN (SELECT desarrollo_id FROM leads WHERE cliente_id ='.$cliente_id.')')));
      foreach ($desarrollos as $desarrollo):
          array_push($llaves_desarrollo, $desarrollo['FotoDesarrollo']['desarrollo_id']);
          array_push($valores_desarrollo, $desarrollo['FotoDesarrollo']['ruta']);
          
      endforeach; 
      $arreglo_desarrollo=array_combine($llaves_desarrollo,$valores_desarrollo);
      $this->set('fotos_desarrollos',$arreglo_desarrollo);
      
      
      $this->set('logs',$this->LogCliente->find('all',array('order'=>'LogCliente.id DESC','conditions'=>array('LogCliente.cliente_id'=>$cliente_id))));
      
      $this->set('llamadas',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$cliente_id,'LogCliente.accion'=>4))));
      $this->set('mails',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$cliente_id,'LogCliente.accion'=>3))));
      $this->set('visitas',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$cliente_id,'LogCliente.accion'=>5))));
      
      $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
      $this->set('all_desarrollos',$this->Desarrollo->find('list',array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
      /*$pagos_facturas = $this->Transaccion->find('all', array('conditions'=>array('Transaccion.factura_id IN (select facturas.id from facturas where facturas.cliente_id = '.$cliente_id.')')));*/
      $list_facturas = $this->Factura->find('list', array('conditions'=>array('Factura.cliente_id'=>$cliente_id)));
      /*$this->set(compact('pagos_facturas'));*/
      $this->set(compact('list_facturas'));
      $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));
  }

  public function reporte_clientes_status_general(){
    //$this->layout = 'blank';

    // Inicialización de Variables
    $cuenta_id         = $this->Session->read('CuentaUsuario.Cuenta.id');
    $date_current      = date('Y-m-d');
    $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

    // Fecha del post
    $month     = date('Y-m');
    $aux       = date('Y-m-d', strtotime("{$month} + 1 month"));
    $fecha_ini = '01-01-'.date('Y');
    $fecha_fin = date('d-m-Y', strtotime("{$aux} - 1 day"));

    // Vars clientes cuenta
    $data_clientes_temp     = array('frios'=>0, 'tibios'=>0, 'calientes'=>0, 'ventas'=>0);
    $data_clientes_status   = array('activos'=>0, 'inactivos_temp'=>0, 'ventas'=>0, 'inactivos_def'=>0);
    $data_clientes_atencion = array('oportunos'=>0, 'tardios'=>0, 'no_atendidos'=>0, 'por_reasignar'=>0, 'inactivos_temp'=>0);
    // Origenes de ventas y clientes
    $countVentasOrigen      = 0;
    
    // Variables contactos ventas y gasto
    $meses = array();
    $arreglo_cm = array();
    $ventas_mes = array();
    $arreglo_inversionm = array();

    // Variable para meta de venta
    $tot_venta_mes               = 0;

    //  Calculo de meta p1
    $rows_meta_mes = $this->Desarrollo->find('all',
      array(
        'fields'     => array('Desarrollo.meta_mensual'),
        'recursive'  => -1,
        'conditions' => array(
          'Desarrollo.cuenta_id' => $cuenta_id
        )
      )
    );
    foreach ($rows_meta_mes as $metas) {
      $tot_venta_mes += $metas['Desarrollo']['meta_mensual'];
    }

    // Origen de clientes
    $arregloCV = array();
    $countClientesOrigen    = 0;



    if ($this->request->is(array('post', 'put'))) {
      $rango          = $this->request->data['User']['rango_fechas'];;

      $fecha_ini = substr($rango, 0,10).' 00:00:00';
      $fecha_fin = substr($rango, -10).' 23:59:59';
      $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
      $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));


      // Total de clientes activos
      $row_clientes_activos = $this->Cliente->find('all',array('recursive'=> -1,'conditions'=>array('Cliente.cuenta_id'=>$cuenta_id, 'Cliente.user_id <>' => '', 'Cliente.created >='=>date('Y-m-d', strtotime($fi)), 'Cliente.created <='=>date('Y-m-d', strtotime($ff)))));

      // Grafica de ventas vs ventas del mes
      $grafica_ventas = $this->User->query("SELECT concat(YEAR(fecha),'/',MONTH(fecha)) as mes, sum(precio_cerrado)FROM ventas WHERE cuenta_id =".$cuenta_id." AND fecha >= '".date('Y-m-d', strtotime($fi))."' AND fecha <= '".date('Y-m-d', strtotime($ff))."' group by mes ORDER BY mes ASC;");

      // Origen de clientes
      $grafica_origen_clientes_ventas_mes = $this->Cliente->query(
      "
        SELECT
          clientes.dic_linea_contacto_id, COUNT(clientes.id) AS cliente_linea,
          dic_linea_contactos.linea_contacto
        FROM clientes
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE clientes.`status` IN ('Activo')
        AND clientes.cuenta_id = ".$cuenta_id."
        AND clientes.user_id <> ''
        AND clientes.created >= '".date('Y-m-d', strtotime($fi))."'
        AND clientes.created <= '".date('Y-m-d', strtotime($ff))."'
        GROUP BY clientes.dic_linea_contacto_id
      "
      );

      $grafica_origen_ventas_mes = $this->Cliente->query(
      "
        SELECT 
          dic_linea_contactos.id, dic_linea_contactos.linea_contacto,
          COUNT(*) AS ventas_contacto
        FROM ventas
        INNER JOIN clientes
        ON clientes.id = ventas.cliente_id
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE
        ventas.fecha >= '".date('Y-m-d', strtotime($fi))."'
        AND ventas.fecha <= ".date('Y-m-d', strtotime($ff))."
        AND ventas.cuenta_id = ".$cuenta_id."
        AND ventas.tipo_operacion = 'Venta'
      "
      );

      $contactos_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(created),"-",MONTH(created),"-",DAY(created)),"%b %Y") as creado, count(*) as contactos FROM clientes WHERE clientes.cuenta_id ='.$cuenta_id.' AND created >= "'.date('Y-m-d', strtotime($fi)).'" AND created <= "'.date('Y-m-d', strtotime($ff)).'" AND clientes.`status` IN ("Activo") GROUP BY creado ORDER BY "creado" DESC;');
    
      $ventas_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha),"-",MONTH(fecha),"-",DAY(fecha)),"%b %Y") as mes_venta, count(*) FROM ventas WHERE ventas.cuenta_id ='.$cuenta_id.' AND fecha >= "'.date('Y-m-d', strtotime($fi)).'" AND fecha <= "'.date('Y-m-d', strtotime($ff)).'" AND ventas.tipo_operacion = "Venta" AND ventas.cuenta_id = '.$cuenta_id.' GROUP BY mes_venta ORDER BY "mes_venta" DESC;');
      
      $inversion_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha_fin),"-",MONTH(fecha_fin),"-",DAY(fecha_fin)),"%b %Y") as mes_inversion, sum(inversion_prevista) FROM publicidads WHERE publicidads.cuenta_id ='.$cuenta_id.' AND YEAR(fecha_fin) = YEAR(NOW())  GROUP BY mes_inversion ORDER BY "mes_inversion" DESC;');

    }else{
      // Total de clientes activos
      $row_clientes_activos = $this->Cliente->find('all',array('recursive'=> -1,'conditions'=>array('Cliente.cuenta_id'=>$cuenta_id, 'Cliente.user_id <>' => '', 'Cliente.created >='=>date('Y-m-d', strtotime($fecha_ini)), 'Cliente.created <='=>date('Y-m-d', strtotime($fecha_fin)))));

      // Grafica de ventas vs ventas del mes
      $grafica_ventas = $this->User->query("SELECT concat(YEAR(fecha),'/',MONTH(fecha)) as mes, sum(precio_cerrado)FROM ventas WHERE cuenta_id =".$cuenta_id." AND fecha >= '".date('Y-m-d', strtotime($fecha_ini))."' AND fecha <= '".date('Y-m-d', strtotime($fecha_fin))."' group by mes ORDER BY mes ASC;");

      // Origen de clientes
      $grafica_origen_clientes_ventas_mes = $this->Cliente->query(
      "
        SELECT
          clientes.dic_linea_contacto_id, COUNT(clientes.id) AS cliente_linea,
          dic_linea_contactos.linea_contacto
        FROM clientes
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE clientes.`status` = 'Activo'
        AND clientes.cuenta_id = ".$cuenta_id."
        AND clientes.user_id <> ''
        AND clientes.created >= '".date('Y-m-d H:i:s', strtotime($fecha_ini.' 00:00:00'))."'
        AND clientes.created <= '".date('Y-m-d H:i:s', strtotime($fecha_fin.' 23:59:59'))."'
        GROUP BY clientes.dic_linea_contacto_id
      "
      );

      $grafica_origen_ventas_mes = $this->Cliente->query(
      "
        SELECT 
          dic_linea_contactos.id, dic_linea_contactos.linea_contacto,
          COUNT(*) AS ventas_contacto
        FROM ventas
        INNER JOIN clientes
        ON clientes.id = ventas.cliente_id
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE
        ventas.fecha >= '".date('Y-m-d', strtotime($fecha_ini))."'
        AND ventas.fecha <= '".date('Y-m-d', strtotime($fecha_fin))."'
        AND ventas.cuenta_id = ".$cuenta_id."
        AND ventas.tipo_operacion = 'Venta'
      "
      );

      $contactos_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(created),"-",MONTH(created),"-",DAY(created)),"%b %Y") as creado, count(*) as contactos FROM clientes WHERE clientes.cuenta_id ='.$cuenta_id.' AND created >= "'.date('Y-m-d', strtotime($fecha_ini)).'" AND created <= "'.date('Y-m-d', strtotime($fecha_fin)).'" AND clientes.`status` IN ("Activo") GROUP BY creado ORDER BY "creado" DESC;');
    
      $ventas_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha),"-",MONTH(fecha),"-",DAY(fecha)),"%b %Y") as mes_venta, count(*) FROM ventas WHERE ventas.cuenta_id ='.$cuenta_id.' AND fecha >= "'.date('Y-m-d', strtotime($fecha_ini)).'" AND fecha <= "'.date('Y-m-d', strtotime($fecha_fin)).'" AND ventas.tipo_operacion = "Venta" AND ventas.cuenta_id = '.$cuenta_id.' GROUP BY mes_venta ORDER BY "mes_venta" DESC;');
      
      $inversion_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha_fin),"-",MONTH(fecha_fin),"-",DAY(fecha_fin)),"%b %Y") as mes_inversion, sum(inversion_prevista) FROM publicidads WHERE publicidads.cuenta_id ='.$cuenta_id.' AND YEAR(fecha_fin) = YEAR(NOW())  GROUP BY mes_inversion ORDER BY "mes_inversion" DESC;');
      
    }

    // foreach para los clientes.
    foreach ($row_clientes_activos as $clientes) {
      switch ($clientes['Cliente']['status']) {
        case 'Activo':
          switch ($clientes['Cliente']['temperatura']) {
            case 1:
              $data_clientes_temp['frios'] ++;
              break;
            case 2:
              $data_clientes_temp['tibios'] ++;
              break;
            case 3:
              $data_clientes_temp['calientes'] ++;
              break;
          };
          $data_clientes_status['activos'] ++;

          if ($clientes['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_oportunos) {$data_clientes_atencion['oportunos']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$data_clientes_atencion['tardios']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$data_clientes_atencion['no_atendidos']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $clientes['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$data_clientes_atencion['por_reasignar']++;}
          else{$data_clientes_atencion['por_reasignar']++;}

        break;
        case 'Activo venta':
          $data_clientes_status['ventas'] ++;
        break;
        case 'Inactivo temporal':
          $data_clientes_status['inactivos_temp'] ++;
          $data_clientes_atencion['inactivos_temp'] ++;
        break;
        case 'Inactivo':
          $data_clientes_status['inactivos_def'] ++;
        break;
      };
    }

    // Origen de clientes / ventas
    foreach ($grafica_origen_clientes_ventas_mes as $clientes_contacto) {
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['id'] = $clientes_contacto['clientes']['dic_linea_contacto_id'];
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['count(clientes)'] = $clientes_contacto['0']['cliente_linea'];
      $countClientesOrigen = $clientes_contacto['0']['cliente_linea'] + $countClientesOrigen;
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['nombre_linea'] = $clientes_contacto['dic_linea_contactos']['linea_contacto'];
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['count(ventas)'] = 0;
    }
    foreach ($grafica_origen_ventas_mes as $ventas_contacto) {
      // if ($ventas_contacto['dic_linea_contactos']['id'] != '') {
      if ( empty( $ventas_contacto['dic_linea_contactos']['id'] ) ) {
          $arregloCV[$ventas_contacto['dic_linea_contactos']['id']]['LineaContacto']['count(ventas)'] = $ventas_contacto[0]['ventas_contacto'];
          $countVentasOrigen = $ventas_contacto[0]['ventas_contacto'] + $countVentasOrigen;
      }
    }

    // Histórico de contactos/ventas/gasto
    foreach($contactos_mes as $cm){
      array_push($meses,$cm[0]['creado']);
      $arreglo_cm[$cm[0]['creado']] = $cm[0]['contactos'];
    };
    foreach($ventas_mes as $venta_mes){
      $arreglo_ventasm[$venta_mes[0]['mes_venta']] = $venta_mes[0]['count(*)'];
    };
    foreach($inversion_mes as $inv_mes){
      $arreglo_inversionm[$inv_mes[0]['mes_inversion']] = $inv_mes[0]['sum(inversion_prevista)'];
    };


    $this->set(compact('fecha_ini'));
    $this->set(compact('fecha_fin'));

    $this->set('meses_esp', array('01'  => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre')); // Meses en español
    // Variables de clientes
    $this->set('sum_temp', $data_clientes_temp['frios'] + $data_clientes_temp['tibios'] + $data_clientes_temp['calientes'] + $data_clientes_temp['ventas']);
    $this->set(compact('data_clientes_temp'));
    $this->set(compact('data_clientes_status'));
    $this->set(compact('data_clientes_atencion'));
    // Origenes de ventas y clientes

    // Variable para metas vs ventas por mes
    $this->set('meta_mes', $tot_venta_mes);
    $this->set('ventas_grafica', $grafica_ventas);
    $this->set('maximo', 0);

    // Variables para origen de clientes
    $this->set(compact('countClientesOrigen'));
    $this->set(compact('arregloCV'));
    $this->set(compact('countVentasOrigen'));

    // Histórico de contactos/ventas/gasto
    $this->set(compact('meses'));
    $this->set(compact('arreglo_cm'));
    $this->set(compact('ventas_mes'));
    $this->set(compact('arreglo_ventasm'));
    $this->set(compact('arreglo_inversionm'));
  }

  public function reportes_asesores(){
    $this->layout = 'blank';

    // Inicialización de Variables
    $cuenta_id         = $this->Session->read('CuentaUsuario.Cuenta.id');
    $date_current      = date('Y-m-d');
    $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

    // Fecha del post
    $month     = date('Y-m');
    $aux       = date('Y-m-d', strtotime("{$month} + 1 month"));
    $fecha_ini = '01-01-'.date('Y');
    $fecha_fin = date('d-m-Y', strtotime("{$aux} - 1 day"));

    // Vars clientes cuenta
    $data_clientes_temp     = array('frios'=>0, 'tibios'=>0, 'calientes'=>0, 'ventas'=>0);
    $data_clientes_status   = array('activos'=>0, 'inactivos_temp'=>0, 'ventas'=>0, 'inactivos_def'=>0);
    $data_clientes_atencion = array('oportunos'=>0, 'tardios'=>0, 'no_atendidos'=>0, 'por_reasignar'=>0, 'inactivos_temp'=>0);
    // Origenes de ventas y clientes
    $countVentasOrigen      = 0;
    
    // Variables contactos ventas y gasto
    $meses = array();
    $arreglo_cm = array();
    $ventas_mes = array();
    $arreglo_inversionm = array();

    // Variable para meta de venta
    $tot_venta_mes               = 0;

    //  Calculo de meta p1
    $rows_meta_mes = $this->Desarrollo->find('all',
      array(
        'fields'     => array('Desarrollo.meta_mensual'),
        'recursive'  => -1,
        'conditions' => array(
          'Desarrollo.cuenta_id' => $cuenta_id
        )
      )
    );
    foreach ($rows_meta_mes as $metas) {
      $tot_venta_mes += $metas['Desarrollo']['meta_mensual'];
    }

    // Origen de clientes
    $arregloCV = array();
    $countClientesOrigen    = 0;



    if ($this->request->is(array('post', 'put'))) {
      $rango          = $this->request->data['User']['rango_fechas'];;

      $fecha_ini = substr($rango, 0,10).' 00:00:00';
      $fecha_fin = substr($rango, -10).' 23:59:59';
      $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
      $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));


      // Total de clientes activos
      $row_clientes_activos = $this->Cliente->find('all',array('recursive'=> -1,'conditions'=>array('Cliente.cuenta_id'=>$cuenta_id, 'Cliente.user_id <>' => '', 'Cliente.created >='=>date('Y-m-d', strtotime($fi)), 'Cliente.created <='=>date('Y-m-d', strtotime($ff)))));

      // Grafica de ventas vs ventas del mes
      $grafica_ventas = $this->User->query("SELECT concat(YEAR(fecha),'/',MONTH(fecha)) as mes, sum(precio_cerrado)FROM ventas WHERE cuenta_id =".$cuenta_id." AND fecha >= '".date('Y-m-d', strtotime($fi))."' AND fecha <= '".date('Y-m-d', strtotime($ff))."' group by mes ORDER BY mes ASC;");

      // Origen de clientes
      $grafica_origen_clientes_ventas_mes = $this->Cliente->query(
      "
        SELECT
          clientes.dic_linea_contacto_id, COUNT(clientes.id) AS cliente_linea,
          dic_linea_contactos.linea_contacto
        FROM clientes
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE clientes.`status` IN ('Activo')
        AND clientes.cuenta_id = ".$cuenta_id."
        AND clientes.user_id <> ''
        AND clientes.created >= '".date('Y-m-d', strtotime($fi))."'
        AND clientes.created <= '".date('Y-m-d', strtotime($ff))."'
        GROUP BY clientes.dic_linea_contacto_id
      "
      );

      $grafica_origen_ventas_mes = $this->Cliente->query(
      "
        SELECT 
          dic_linea_contactos.id, dic_linea_contactos.linea_contacto,
          COUNT(*) AS ventas_contacto
        FROM ventas
        INNER JOIN clientes
        ON clientes.id = ventas.cliente_id
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE
        ventas.fecha >= '".date('Y-m-d', strtotime($fi))."'
        AND ventas.fecha <= ".date('Y-m-d', strtotime($ff))."
        AND ventas.cuenta_id = ".$cuenta_id."
        AND ventas.tipo_operacion = 'Venta'
      "
      );

      $contactos_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(created),"-",MONTH(created),"-",DAY(created)),"%b %Y") as creado, count(*) as contactos FROM clientes WHERE clientes.cuenta_id ='.$cuenta_id.' AND created >= "'.date('Y-m-d', strtotime($fi)).'" AND created <= "'.date('Y-m-d', strtotime($ff)).'" AND clientes.`status` IN ("Activo") GROUP BY creado ORDER BY "creado" DESC;');
    
      $ventas_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha),"-",MONTH(fecha),"-",DAY(fecha)),"%b %Y") as mes_venta, count(*) FROM ventas WHERE ventas.cuenta_id ='.$cuenta_id.' AND fecha >= "'.date('Y-m-d', strtotime($fi)).'" AND fecha <= "'.date('Y-m-d', strtotime($ff)).'" AND ventas.tipo_operacion = "Venta" AND ventas.cuenta_id = '.$cuenta_id.' GROUP BY mes_venta ORDER BY "mes_venta" DESC;');
      
      $inversion_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha_fin),"-",MONTH(fecha_fin),"-",DAY(fecha_fin)),"%b %Y") as mes_inversion, sum(inversion_prevista) FROM publicidads WHERE publicidads.cuenta_id ='.$cuenta_id.' AND YEAR(fecha_fin) = YEAR(NOW())  GROUP BY mes_inversion ORDER BY "mes_inversion" DESC;');

    }else{
      // Total de clientes activos
      $row_clientes_activos = $this->Cliente->find('all',array('recursive'=> -1,'conditions'=>array('Cliente.cuenta_id'=>$cuenta_id, 'Cliente.user_id <>' => '', 'Cliente.created >='=>date('Y-m-d', strtotime($fecha_ini)), 'Cliente.created <='=>date('Y-m-d', strtotime($fecha_fin)))));

      // Grafica de ventas vs ventas del mes
      $grafica_ventas = $this->User->query("SELECT concat(YEAR(fecha),'/',MONTH(fecha)) as mes, sum(precio_cerrado)FROM ventas WHERE cuenta_id =".$cuenta_id." AND fecha >= '".date('Y-m-d', strtotime($fecha_ini))."' AND fecha <= '".date('Y-m-d', strtotime($fecha_fin))."' group by mes ORDER BY mes ASC;");

      // Origen de clientes
      $grafica_origen_clientes_ventas_mes = $this->Cliente->query(
      "
        SELECT
          clientes.dic_linea_contacto_id, COUNT(clientes.id) AS cliente_linea,
          dic_linea_contactos.linea_contacto
        FROM clientes
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE clientes.`status` = 'Activo'
        AND clientes.cuenta_id = ".$cuenta_id."
        AND clientes.user_id <> ''
        AND clientes.created >= '".date('Y-m-d H:i:s', strtotime($fecha_ini.' 00:00:00'))."'
        AND clientes.created <= '".date('Y-m-d H:i:s', strtotime($fecha_fin.' 23:59:59'))."'
        GROUP BY clientes.dic_linea_contacto_id
      "
      );

      $grafica_origen_ventas_mes = $this->Cliente->query(
      "
        SELECT 
          dic_linea_contactos.id, dic_linea_contactos.linea_contacto,
          COUNT(*) AS ventas_contacto
        FROM ventas
        INNER JOIN clientes
        ON clientes.id = ventas.cliente_id
        INNER JOIN dic_linea_contactos
        ON dic_linea_contactos.id = clientes.dic_linea_contacto_id
        WHERE
        ventas.fecha >= '".date('Y-m-d', strtotime($fecha_ini))."'
        AND ventas.fecha <= '".date('Y-m-d', strtotime($fecha_fin))."'
        AND ventas.cuenta_id = ".$cuenta_id."
        AND ventas.tipo_operacion = 'Venta'
      "
      );

      $contactos_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(created),"-",MONTH(created),"-",DAY(created)),"%b %Y") as creado, count(*) as contactos FROM clientes WHERE clientes.cuenta_id ='.$cuenta_id.' AND created >= "'.date('Y-m-d', strtotime($fecha_ini)).'" AND created <= "'.date('Y-m-d', strtotime($fecha_fin)).'" AND clientes.`status` IN ("Activo") GROUP BY creado ORDER BY "creado" DESC;');
    
      $ventas_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha),"-",MONTH(fecha),"-",DAY(fecha)),"%b %Y") as mes_venta, count(*) FROM ventas WHERE ventas.cuenta_id ='.$cuenta_id.' AND fecha >= "'.date('Y-m-d', strtotime($fecha_ini)).'" AND fecha <= "'.date('Y-m-d', strtotime($fecha_fin)).'" AND ventas.tipo_operacion = "Venta" AND ventas.cuenta_id = '.$cuenta_id.' GROUP BY mes_venta ORDER BY "mes_venta" DESC;');
      
      $inversion_mes = $this->Cliente->query('SELECT DATE_FORMAT(CONCAT(YEAR(fecha_fin),"-",MONTH(fecha_fin),"-",DAY(fecha_fin)),"%b %Y") as mes_inversion, sum(inversion_prevista) FROM publicidads WHERE publicidads.cuenta_id ='.$cuenta_id.' AND YEAR(fecha_fin) = YEAR(NOW())  GROUP BY mes_inversion ORDER BY "mes_inversion" DESC;');
    }

    // foreach para los clientes.
    foreach ($row_clientes_activos as $clientes) {
      switch ($clientes['Cliente']['status']) {
        case 'Activo':
          switch ($clientes['Cliente']['temperatura']) {
            case 1:
              $data_clientes_temp['frios'] ++;
              break;
            case 2:
              $data_clientes_temp['tibios'] ++;
              break;
            case 3:
              $data_clientes_temp['calientes'] ++;
              break;
          };
          $data_clientes_status['activos'] ++;

          if ($clientes['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_oportunos) {$data_clientes_atencion['oportunos']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$data_clientes_atencion['tardios']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$data_clientes_atencion['no_atendidos']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $clientes['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$data_clientes_atencion['por_reasignar']++;}
          else{$data_clientes_atencion['por_reasignar']++;}

        break;
        case 'Activo venta':
          $data_clientes_status['ventas'] ++;
        break;
        case 'Inactivo temporal':
          $data_clientes_status['inactivos_temp'] ++;
          $data_clientes_atencion['inactivos_temp'] ++;
        break;
        case 'Inactivo':
          $data_clientes_status['inactivos_def'] ++;
        break;
      };
    }

    // Origen de clientes / ventas
    foreach ($grafica_origen_clientes_ventas_mes as $clientes_contacto) {
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['id'] = $clientes_contacto['clientes']['dic_linea_contacto_id'];
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['count(clientes)'] = $clientes_contacto['0']['cliente_linea'];
      $countClientesOrigen = $clientes_contacto['0']['cliente_linea'] + $countClientesOrigen;
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['nombre_linea'] = $clientes_contacto['dic_linea_contactos']['linea_contacto'];
      $arregloCV[$clientes_contacto['clientes']['dic_linea_contacto_id']]['LineaContacto']['count(ventas)'] = 0;
    }
    foreach ($grafica_origen_ventas_mes as $ventas_contacto) {
      if ($ventas_contacto['dic_linea_contactos']['id'] != '') {
          $arregloCV[$ventas_contacto['dic_linea_contactos']['id']]['LineaContacto']['count(ventas)'] = $ventas_contacto[0]['ventas_contacto'];
          $countVentasOrigen = $ventas_contacto[0]['ventas_contacto'] + $countVentasOrigen;
      }
    }

    // Histórico de contactos/ventas/gasto
    foreach($contactos_mes as $cm){
      array_push($meses,$cm[0]['creado']);
      $arreglo_cm[$cm[0]['creado']] = $cm[0]['contactos'];
    };
    foreach($ventas_mes as $venta_mes){
      $arreglo_ventasm[$venta_mes[0]['mes_venta']] = $venta_mes[0]['count(*)'];
    };
    foreach($inversion_mes as $inv_mes){
      $arreglo_inversionm[$inv_mes[0]['mes_inversion']] = $inv_mes[0]['sum(inversion_prevista)'];
    };


    $this->set(compact('fecha_ini'));
    $this->set(compact('fecha_fin'));

    $this->set('meses_esp', array('01'  => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre')); // Meses en español
    // Variables de clientes
    $this->set('sum_temp', $data_clientes_temp['frios'] + $data_clientes_temp['tibios'] + $data_clientes_temp['calientes'] + $data_clientes_temp['ventas']);
    $this->set(compact('data_clientes_temp'));
    $this->set(compact('data_clientes_status'));
    $this->set(compact('data_clientes_atencion'));
    // Origenes de ventas y clientes

    // Variable para metas vs ventas por mes
    $this->set('meta_mes', $tot_venta_mes);
    $this->set('ventas_grafica', $grafica_ventas);
    $this->set('maximo', 0);

    // Variables para origen de clientes
    $this->set(compact('countClientesOrigen'));
    $this->set(compact('arregloCV'));
    $this->set(compact('countVentasOrigen'));

    // Histórico de contactos/ventas/gasto
    $this->set(compact('meses'));
    $this->set(compact('arreglo_cm'));
    $this->set(compact('ventas_mes'));
    $this->set(compact('arreglo_ventasm'));
    $this->set(compact('arreglo_inversionm'));
  }

  public function pdf_clientes_status_general(){
      $month     = date('Y-m');
      $aux       = date('Y-m-d', strtotime("{$month} + 1 month"));
      $fecha_ini = '01-01-'.date('Y');
      $fecha_fin = date('d-m-Y', strtotime("{$aux} - 1 day"));
      if ($this->request->is('post')) {
          
      }
      $this->set(compact('fecha_ini'));
      $this->set(compact('fecha_fin'));
      $params = array(
          'download'         => false,
          'name'             => 'example.pdf',
          'paperOrientation' => 'portrait',
          'paperSize'        => 'letter',
          
      );
  }

  public function reporte_c1(){
        setlocale(LC_TIME, "spanish");

        $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $fecha_inicio   = '2020-01-01';
        $fecha_final    = date('Y-m-d');
        $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
        $periodo_reporte     = utf8_encode(strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_inicio)))).' al '.strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_final)))));


        if ( $this->request->is(array('post', 'put')) ) {
            $rango          = $this->request->data['User']['rango_fechas'];;

            $fecha_ini = substr($rango, 0,10).' 00:00:00';
            $fecha_fin = substr($rango, -10).' 23:59:59';
            $fi = date('Y-m-d',  strtotime($fecha_ini));
            $ff = date('Y-m-d',  strtotime($fecha_fin));
            $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fi)).' AL '.date('d-m-Y', strtotime($ff));
            $periodo_reporte     = utf8_encode(strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fi)))).' al '.strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($ff)))));

            // Total de clietnes.
            $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff'");
            // Clientes separado por estatus.
            $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND desarrollo_id = 68 GROUP BY status");

            // Grafica de temperatura de clientes.
            $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' GROUP BY etapa;");


            /************************************************* Grafica de atencion de clientes ********************************************************************/
            //Indicador de clientes con estatus Oportunos
            $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");

            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".($this->Session->read('Parametros.Paramconfig.sla_oportuna') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");

            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No atentidos (De ".($this->Session->read('Parametros.Paramconfig.sla_atrasados') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");

            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".($this->Session->read('Parametros.Paramconfig.sla_no_atendidos') + 1)." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");

            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin Asignar' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fi' AND created <= '$ff'");

            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];


            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM leads, dic_linea_contactos WHERE leads.cliente_id IN (SELECT id FROM clientes WHERE clientes.cuenta_id = $cuenta_id) AND leads.dic_linea_contacto_id IS NOT NULL AND leads.fecha >= '$fi' AND leads.fecha <= '$ff' AND leads.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");

            $ventas_linea_contacto_arreglo = array();
            $i=0;
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id AND dic_linea_contactos.cuenta_id = $cuenta_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

            $visitas_linea_contacto_arreglo = array();
            foreach($clientes_lineas as $linea):
                $ventas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
                $ventas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
                $ventas_linea_contacto_arreglo[$i]['ventas'] = 0;
                $ventas_linea_contacto_arreglo[$i]['inversion'] = 0;
                foreach($venta_linea_contacto as $venta):
                    if ($venta['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                        $ventas_linea_contacto_arreglo[$i]['ventas'] = $venta[0]['ventas'];
                    }
                endforeach;
                foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                    if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                        $ventas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                    }
                endforeach;
                $i++;
            endforeach;

            /************************************************* Se adiciona estan variables para el grafico de CONTACTOS POR MEDIO DE PROMOCIÓN VS VISITAS
             *  Las demas variables para el grafico se toman de la grafica anterior.
             *  ********************************************************************/
            $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

            $visitas_linea_contacto_arreglo = array();
            $i=0;
            foreach($clientes_lineas as $linea):
                $visitas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
                $visitas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
                $visitas_linea_contacto_arreglo[$i]['visitas'] = 0;
                $visitas_linea_contacto_arreglo[$i]['inversion'] = 0;
                foreach($visitas_linea_contacto as $visita):
                    if ($visita['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                        $visitas_linea_contacto_arreglo[$i]['visitas'] = $visita[0]['visitas'];
                    }
                endforeach;
                foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                    if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                        $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                    }
                endforeach;
                $i++;
            endforeach;

            /************************************************* Grafica de Relación de Inactivación de Clientes ********************************************************************/
            //$temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' AND clientes.desarrollo_id = $desarrollo_id GROUP BY etapa;");

            $inactivos_definitivos_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus inactivo definitivo por motivo:%' GROUP BY cliente_id");
            $inactivos_distribucion = array();
            foreach ($inactivos_definitivos_raw as $inactivo):
                $razon = explode(':',$inactivo['agendas']['mensaje'])[1];
                $valor = isset($inactivos_distribucion[$razon]) ? $inactivos_distribucion[$razon] :0;
                $inactivos_distribucion[$razon] = $valor +1;
            endforeach;
            $this->set(compact('inactivos_distribucion'));

            $inactivos_temporales_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND status = 'Inactivo Temporal') AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo:%' GROUP BY cliente_id");
            $inactivos_temporal_distribucion = array();
            $inactivos_temporal_distribucion['Solicitó contactarlo tiempo después'] = 0;
            foreach ($inactivos_temporales_raw as $inactivo):
                $razon = explode(':',$inactivo['agendas']['mensaje'])[1];
                if (strpos($razon,"contactarlo")!== false){
                    $valor = $inactivos_temporal_distribucion['Solicitó contactarlo tiempo después'];
                    $inactivos_temporal_distribucion['Solicitó contactarlo tiempo después'] = $valor +1;
                }else{
                    $razon1 = substr($razon,0,-14);
                    $valor = isset($inactivos_temporal_distribucion[$razon1]) ? $inactivos_temporal_distribucion[$razon1] :0;
                    $inactivos_temporal_distribucion[$razon1] = $valor +1;
                }
            endforeach;
            $this->set(compact('inactivos_temporal_distribucion'));

            /************************************************* Grafica de Relación de Cancelación de Citas ********************************************************************/

            $cancelaciones_raw = $this->Cliente->query("SELECT motivo_cancelacion, COUNT(*) AS sumatoria FROM events WHERE  cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id ) AND motivo_cancelacion IS NOT NULL  AND fecha_inicio >= '$fi' AND fecha_inicio <= '$ff'  GROUP BY motivo_cancelacion");

            $this->set(compact('cancelaciones_raw'));

            /************************************************* Grafica de DISTRIBUCION DE CLIENTES POR DESARROLLOS POR ASESOR ********************************************************************/

            $clientes_asignados_desarrollos = $this->Cliente->query("SELECT COUNT(*) AS clientes, desarrollos.nombre FROM clientes,desarrollos WHERE desarrollos.id = clientes.desarrollo_id AND clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' GROUP BY desarrollos.nombre ORDER BY clientes DESC;");
            $this->set('clientes_asignados_desarrollos',$clientes_asignados_desarrollos);


        }else{

            // Total de clietnes.
            $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
            // Clientes separado por estatus.
            $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' GROUP BY status");

            // Grafica de temperatura de clientes.
            $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fecha_inicio."' AND created <= '".$fecha_final."' AND status = 'Activo' GROUP BY etapa;");


            /************************************************* Grafica de atencion de clientes ********************************************************************/

            //Indicador de clientes con estatus Oportunos
            $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".($this->Session->read('Parametros.Paramconfig.sla_oportuna') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'Atrasados (De ".($this->Session->read('Parametros.Paramconfig.sla_atrasados') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".($this->Session->read('Parametros.Paramconfig.sla_no_atendidos') + 1)." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin seguimiento' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fecha_inicio' AND  ventas.fecha <= '$fecha_final' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");

            $ventas_linea_contacto_arreglo = array();
            $i=0;
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND publicidads.cuenta_id = $cuenta_id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

            $this->set(compact('clientes_lineas'));
            $this->set(compact('inversion_publicidad'));
            $visitas_linea_contacto_arreglo = array();
            foreach($clientes_lineas as $linea):
                $ventas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
                $ventas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
                $ventas_linea_contacto_arreglo[$i]['ventas'] = 0;
                $ventas_linea_contacto_arreglo[$i]['inversion'] = 10;
                foreach($venta_linea_contacto as $venta):
                    if ($venta['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                        $ventas_linea_contacto_arreglo[$i]['ventas'] = $venta[0]['ventas'];
                    }
                endforeach;
                foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                    if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                        $ventas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                    }
                endforeach;
                $i++;
            endforeach;


            /************************************************* Se adiciona estan variables para el grafico de CONTACTOS POR MEDIO DE PROMOCIÓN VS VISITAS
             *  Las demas variables para el grafico se toman de la grafica anterior.
             *  ********************************************************************/
            $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fecha_inicio' AND  events.fecha_inicio <= '$fecha_final' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

            $i=0;
            foreach($clientes_lineas as $linea):
                $visitas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
                $visitas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
                $visitas_linea_contacto_arreglo[$i]['visitas'] = 0;
                $visitas_linea_contacto_arreglo[$i]['inversion'] = 0;
                foreach($visitas_linea_contacto as $visita):
                    if ($visita['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                        $visitas_linea_contacto_arreglo[$i]['visitas'] = $visita[0]['visitas'];
                    }
                endforeach;
                foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                    if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                        $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                    }
                endforeach;
                $i++;
            endforeach;

        }





        // Variables globales.
        $this->set(compact('fecha_inicio'));
        $this->set(compact('fecha_final'));
        $this->set(compact('periodo_tiempo'));
        $this->set(compact('periodo_reporte'));

        // Variable para grafica de estatus de clientes.
        $this->set(compact('total_clientes_anuales'));
        $this->set(compact('clientes_anuales'));

        // Variables de grafica de temperatura de clientes.
        $this->set(compact('temperatura_clientes'));

        // Variables de atencion de clientes.
        $this->set(compact('clientes_oportunos'));
        $this->set(compact('clientes_tardia'));
        $this->set(compact('clientes_atrasados'));
        $this->set(compact('clientes_reasignar'));
        $this->set(compact('clientes_sin_seguimiento'));
        $this->set(compact('sum_clientes_atencion'));

        // Variables grafica de clientes con linea de contacto.
        $this->set(compact('clientes_lineas'));
        $this->set(compact('total_clientes_lineas'));
        $this->set(compact('ventas_linea_contacto_arreglo'));

        //Variable para el número de visitas por linea de contacto
        $this->set(compact('visitas_linea_contacto_arreglo'));

        // $this->autoRender = false;
  }
  
  public function get_clientes($cuenta_id = null, $user_id = null, $tipo_listado = null ){
    $this->User->Behaviors->load('Containable');
    $this->layout = null;


    if( $tipo_listado == 1 ) {
      $order = array('Cliente.created' => 'DESC');
    }else{
      $order = array('Cliente.created' => 'DESC');
    }


    // Condiciones para los super admin y asesores.
    $user = $this->User->find('first', array(
      'conditions' => array(
        'id' => $user_id
      ),
      'contain' => array(
        'Rol'
      ),
      'fields' => array(
        'User.id',
        'User.nombre_completo'
      )
    ));

    if( $user['Rol'][0]['cuentas_users']['group_id'] == 1 OR $user['Rol'][0]['cuentas_users']['group_id'] == 2 ){
      
      $db_clientes = $this->Cliente->find('all',
          array(
              'conditions' => array(
                  'OR'=>array(
                      'Cliente.cuenta_id'     => $cuenta_id,
                      "Cliente.id IN (SELECT id FROM clientes WHERE desarrollo_id IN(SELECT id FROM desarrollos WHERE comercializador_id = $cuenta_id ))"
                  )
              ),
              'recursive' => 0,
              'fields'    => array(
                  'Cliente.id',
                  'Cliente.nombre',
                  'Cliente.temperatura',
                  'Cliente.correo_electronico',
                  'Cliente.telefono1',
                  'Cliente.status',
                  'Inmueble.titulo',
                  'Desarrollo.nombre',
              ),
              'order' => $order,
              'limit' => 200
          )
      );

    }else{
      $db_clientes = $this->Cliente->find('all',
          array(
              'conditions' => array(
                  'Cliente.user_id'   => $user_id,
                  'Cliente.cuenta_id' => $cuenta_id,
                  'Cliente.status'    => array('Activo', 'Inactivo temporal', 'Activo venta')
              ),
              'recursive' => 0,
              'fields'    => array(
                  'Cliente.id',
                  'Cliente.nombre',
                  'Cliente.temperatura',
                  'Cliente.correo_electronico',
                  'Cliente.telefono1',
                  'Cliente.status',
                  'Inmueble.titulo',
                  'Desarrollo.nombre',
              ),
              'order' => $order
          )
      );
    }

    // Limpieza de los resultados
    for($i = 0; $i < count($db_clientes); $i++){
      switch($db_clientes[$i]['Cliente']['temperatura']){
        case 1:
            $db_temp = "Frio";
          break;
        case 2:
          $db_temp = "Tibio";
          break;
        case 3:
          $db_temp = "Caliente";
          break;
      };

      $clientes[$i] = array(
        "id"                 => $db_clientes[$i]['Cliente']['id'],
        "nombre"             => $db_clientes[$i]['Cliente']['nombre'],
        "correo_electronico" => $db_clientes[$i]['Cliente']['correo_electronico'],
        "status"             => $db_clientes[$i]['Cliente']['status'],
        "telefono1"          => str_replace(array("(", ")"," ", "-"), "", $db_clientes[$i]['Cliente']['telefono1']),
        "temperatura"        => $db_temp,
        "inmueble"         => $db_clientes[$i]['Inmueble']['titulo'],
        "desarrollo"         => $db_clientes[$i]['Desarrollo']['nombre'],
      );
    }

    if( !empty( $clientes) ) {
      $resp = $clientes;
    }else{
      $resp = '';
    }

    echo json_encode($resp, true);
    $this->autoRender = false; 

  }

  public function get_clientes_detalle( $cliente_id = null ){

    $this->layout = null;

    $db_cliente = $this->Cliente->find( 'first', array('conditions'=>array( 'Cliente.id'=>$cliente_id ) ) );
    
    $estados = array(
      1=>'Interés Preliminar',
      2=>'Comunicación Abierta',
      3=>'Precalificación',
      4=>'Visita',
      5=>'Análisis de Opciones',
      6=>'Validación de Recursos',
      7=>'Cierre' 
    );

    $estilos =array(
      1=>'#ceeefd',
      2=>'#6bc7f2',
      3=>'#f4e6c5',
      4=>'#f0ce7e',
      5=>'#f08551',
      6=>'#ee5003',
      7=>'#3ed21f' 
    );

    $cliente = array(
    'id'                       => $db_cliente['Cliente']['id'],
    'nombre'                   => $db_cliente['Cliente']['nombre'],
    'correo_electronico'       => $db_cliente['Cliente']['correo_electronico'],
    'telefono1'                => $db_cliente['Cliente']['telefono1'],
    'telefono2'                => $db_cliente['Cliente']['telefono2'],
    'telefono3'                => $db_cliente['Cliente']['telefono3'],
    'dic_tipo_cliente_id'      => $db_cliente['Cliente']['dic_tipo_cliente_id'],
    'dic_etapa_id'             => $db_cliente['Cliente']['dic_etapa_id'],
    'inmueble_id'              => $db_cliente['Cliente']['inmueble_id'],
    'desarrollo_id'            => $db_cliente['Cliente']['desarrollo_id'],
    'dic_linea_contacto_id'    => $db_cliente['Cliente']['dic_linea_contacto_id'],
    'user_id'                  => $db_cliente['Cliente']['user_id'],
    'status'                   => $db_cliente['Cliente']['status'],
    'last_edit'                => $db_cliente['Cliente']['last_edit'],
    'etapa'                    => $estados[$db_cliente['Cliente']['etapa']],
    'id_etapa'                 => $db_cliente['Cliente']['etapa'],
    'estilo_etapa'             => $estilos[$db_cliente['Cliente']['etapa']],
    'comentario'               => $db_cliente['Cliente']['comentarios'],
    'user_id'                  => $db_cliente['User']['id'],
    'user_nombre'              => $db_cliente['User']['nombre_completo'],
    'inmueble_titulo'          => $db_cliente['Inmueble']['titulo'],
    'desarrollo_nombre'        => $db_cliente['Desarrollo']['nombre'],
    'dic_tipo_cliente'         => $db_cliente['DicTipoCliente']['tipo_cliente'],
    'dic_linea_contacto'       => $db_cliente['DicLineaContacto']['linea_contacto'],
    'first_edit'               => $db_cliente['Cliente']['first_edit']
    );

    echo json_encode($cliente, true);
    $this->autoRender = false; 
  }

  public function get_agenda_cliente( $cliente_id = null ){

    $this->layout = null;
  
    $db_agenda = $this->Agenda->find('all', array(
                    'order'=>'Agenda.id DESC',
                    'conditions'=>array(
                      'Agenda.cliente_id'=>$cliente_id
                    ),
                    'fields' => array(
                      'Agenda.id',
                      'Agenda.fecha',
                      'Agenda.mensaje',
                      'User.id',
                      'User.nombre_completo',
                      'User.foto'
                    )
                  ));

    echo json_encode($db_agenda, true);
    $this->autoRender = false; 
  }

  public function get_log_cliente( $cliente_id = null ){

		$this->layout = null;

		$db_log_cliente = $this->LogCliente->query('
			SELECT
			log_clientes.mensaje,
			log_clientes.datetime,
			log_clientes.accion,
			users.id,
			users.nombre_completo,
			users.foto
			FROM log_clientes
			INNER JOIN users
			ON users.id = log_clientes.user_id
			WHERE log_clientes.cliente_id = '.$cliente_id.'
      ORDER BY log_clientes.id DESC ;');
    

    for($s = 0; $s < count($db_log_cliente); $s++){
      $log_cliente[$s] = array(
        "mensaje"   => $db_log_cliente[$s]['log_clientes']['mensaje'],
        "datetime"  => $db_log_cliente[$s]['log_clientes']['datetime'],
        "accion"    => $db_log_cliente[$s]['log_clientes']['accion'],
        "user_id"   => $db_log_cliente[$s]['users']['id'],
        "user_name" => $db_log_cliente[$s]['users']['nombre_completo'],
        "user_foto" => Router::url($db_log_cliente[$s]['users']['foto'], true)
      );
    }

		  echo json_encode($log_cliente, true); 
      // print_r($log_cliente);
      $this->autoRender = false;
  }

  public function get_lead_cliente_desarrollo( $cliente_id ){
    $this->Lead->Behaviors->load('Containable');

    $this->layout = null;
    
    $db_leads_cliente = $this->Lead->find('all',array('recursive'=>2, 'conditions'=>array( 'Cliente.id' => $cliente_id,'Lead.desarrollo_id !='=>"" ) ));

    // foreach ($db_leads_cliente as $leads) {
      for( $s = 0; $s < count($db_leads_cliente); $s++){
      
        if (isset($db_leads_cliente[$s]['Desarrollo']['FotoDesarrollo'][0])) {
        $imagen_desarrollo = $db_leads_cliente[$s]['Desarrollo']['FotoDesarrollo'][0]['ruta'];
      }else{
        $imagen_desarrollo = '';
      }


        $new_array_desarrollo[$s] = array(
          "nombre"           => $db_leads_cliente[$s]['Desarrollo']['nombre'],
          "id"               => $db_leads_cliente[$s]['Desarrollo']['id'],
          "m2_low"           => $db_leads_cliente[$s]['Desarrollo']['m2_low'],
          "m2_top"           => $db_leads_cliente[$s]['Desarrollo']['m2_top'],
          "est_low"          => $db_leads_cliente[$s]['Desarrollo']['est_low'],
          "est_top"          => $db_leads_cliente[$s]['Desarrollo']['est_top'],
          "banio_low"        => $db_leads_cliente[$s]['Desarrollo']['banio_low'],
          "banio_top"        => $db_leads_cliente[$s]['Desarrollo']['banio_top'],
          "rec_low"          => $db_leads_cliente[$s]['Desarrollo']['rec_low'],
          "rec_top"          => $db_leads_cliente[$s]['Desarrollo']['rec_top'],
          "tipo_desarrollo"  => $db_leads_cliente[$s]['Desarrollo']['tipo_desarrollo'],
          "torres"           => $db_leads_cliente[$s]['Desarrollo']['torres'],
          "unidades_totales" => $db_leads_cliente[$s]['Desarrollo']['unidades_totales'],
          "fecha_entrega"    => $db_leads_cliente[$s]['Desarrollo']['fecha_entrega'],
          "colonia"          => $db_leads_cliente[$s]['Desarrollo']['colonia'],
          "foto"             => Router::url($imagen_desarrollo, true)
        );
      
    }


    if( !empty( $new_array_desarrollo) ) {
      $resp = $new_array_desarrollo;
    }else{
      $resp = '';
    }
    
    echo json_encode($resp, true);
    $this->autoRender = false; 

  }

  public function get_lead_cliente_inmueble( $cliente_id ){
    $this->Lead->Behaviors->load('Containable');

    $this->layout = null;
    
    $db_leads_cliente = $this->Lead->find('all',array('recursive'=>2, 'conditions'=>array( 'Cliente.id' => $cliente_id,'Lead.inmueble_id !='=>"" ) ));

    // foreach ($db_leads_cliente as $leads) {
      for( $s = 0; $s < count($db_leads_cliente); $s++){
      
      if (isset($db_leads_cliente[$s]['Inmueble']['FotoInmueble'][0])) {
        $imagen_inmueble = $db_leads_cliente[$s]['Inmueble']['FotoInmueble'][0]['ruta'];
      }else{
        $imagen_inmueble = '';
      }

      
      $new_array_inmueble[$s] = array(
        "id"                          => $db_leads_cliente[$s]['Inmueble']['id'],
        "premium"                     => $db_leads_cliente[$s]['Inmueble']['premium'],
        "titulo"                      => $db_leads_cliente[$s]['Inmueble']['titulo'],
        "construccion"                => $db_leads_cliente[$s]['Inmueble']['construccion'],
        "recamaras"                   => $db_leads_cliente[$s]['Inmueble']['recamaras'],
        "banos"                       => $db_leads_cliente[$s]['Inmueble']['banos'],
        "estacionamiento_descubierto" => $db_leads_cliente[$s]['Inmueble']['estacionamiento_descubierto'],
        "dic_tipo_propiedad_id"       => $db_leads_cliente[$s]['Inmueble']['dic_tipo_propiedad_id'],
        "venta_renta"                 => $db_leads_cliente[$s]['Inmueble']['venta_renta'],
        "precio"                      => $db_leads_cliente[$s]['Inmueble']['precio'],
        "precio_2"                    => $db_leads_cliente[$s]['Inmueble']['precio_2'],
        "exclusiva"                   => $db_leads_cliente[$s]['Inmueble']['exclusiva'],
        "colonia"                     => $db_leads_cliente[$s]['Inmueble']['colonia'],
        "ciudad"                      => $db_leads_cliente[$s]['Inmueble']['ciudad'],
        "foto"                        => $imagen_inmueble
      );
      
    }

    if( !empty( $new_array_inmueble) ) {
      $resp = $new_array_inmueble;
    }else{
      $resp = '';
    }
    
    echo json_encode($resp, true);
    $this->autoRender = false; 


  }

  public function clientes_params( $cuenta_id ){
    $this->layout = null;

    $users = $this->Cliente->User->find('all',array('recursive'=>-1,'fields'=>array('User.id', 'User.nombre_completo'),'order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$cuenta_id.")")));
    $desarrollos=$this->Desarrollo->find('list',array('order'=>'Desarrollo.nombre ASC'));
    $inmuebles = $this->Inmueble->find('list',array('order'=>'Inmueble.titulo ASC','conditions'=>array('Inmueble.liberada'=>1)));
    $tipos_cliente = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$cuenta_id)));
    $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$cuenta_id)));
    $etapas = $this->DicEtapa->find('list',array('order'=>'DicEtapa.etapa ASC','conditions'=>array('DicEtapa.cuenta_id'=>$cuenta_id)));

    // Foreach para los parametros en un solo arreglo.

    // for( $s = 0; $s < count($users) $s++ ){
      $new_array_params['Users']          = $users;
      $new_array_params['Desarrollos']    = $desarrollos;
      $new_array_params['Inmuebles']      = $inmuebles;
      $new_array_params['TipoCliente']    = $tipos_cliente;
      $new_array_params['LineaContactos'] = $linea_contactos;
      $new_array_params['Etapas']         = $etapas;
    // }

    for($s = 0; $s < count($users); $s++ ){
      $new_array_users[$s] = array(
        "id"              => $users[$s]['User']['id'],
        "nombre_completo" => $users[$s]['User']['nombre_completo'],
      );
    }
    // foreach( $users as $users_list){
    //   echo $users_list['User']['id'];
    //   echo $users_list['User']['nombre_completo'];
    // }
    // print_r($new_array_users);
    echo(json_encode($new_array_users));

  }

  public function get_options_props( $cuenta_id = null ) {
    $this->layout = null;

    $this->Desarrollo->Behaviors->load('Containable');
    $desarrollos=$this->Desarrollo->find(
      'all',array(
        'fields' => array(
          'id',
          'nombre'
        ),
          'containable'=>false,
          'order'      => 'Desarrollo.nombre ASC',
          'conditions' => array(
            'AND'=>array(
              'visible'   => 1,
            ),
            'OR'=>array(
                'Desarrollo.cuenta_id' => $cuenta_id,
                'Desarrollo.comercializador_id' => $cuenta_id,
            ),
          )
      )
    );

    $this->Inmueble->Behaviors->load('Containable');
    $inmuebles = $this->Inmueble->find(
      'all',
      array(
        'fields'=> array(
          'id', 'titulo'
        ),
        'contain'=>false,
        'order'=>'Inmueble.titulo ASC',
        'conditions'=>array(
          'Inmueble.liberada'=>1,
          'Inmueble.cuenta_id'=>$cuenta_id,
          'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)','Inmueble.liberada IN (1,2,3)'
        )
      )
    );

    $s = 0;

    foreach( $desarrollos as $desarrollo ) {
      $new_array_list[$s] = array(
        "id"        => 'D'.$desarrollo['Desarrollo']['id'],
        "propiedad" => 'D -'.$desarrollo['Desarrollo']['nombre'],
      );
      $s++;
    }

    foreach( $inmuebles as $inmueble ) {
      array_push( $new_array_list, array( "id" => 'P'.$inmueble['Inmueble']['id'], "propiedad" => 'I -'.$inmueble['Inmueble']['titulo']) );
    }

    if( !empty( $new_array_list) ) {
      $resp = $new_array_list;
    }else{
      $resp = '';
    }
    
    echo json_encode($resp, true);
    $this->autoRender = false; 

  }

  public function get_status_update( $user_id = null, $cuenta_id = null ) {
    $this->layout = null;


    $timestamp = date('Y-m-d H:i:s');
    $leyenda   = "";
    $motivo    = "";
    $cliente_id = $this->request->data['clienteId'];

    switch($this->request->data['status']){
        case('Activo'):
            $leyenda = "Cliente ".$this->request->data['clienteNombre']." pasa a estatus activo ";
            break;
        
        case('Inactivo temporal'):
            $leyenda = "Cliente ".$this->request->data['clienteNombre']." pasa a estatus inactivo temporal por motivo: ".$this->request->data['motivo']." y pide recontacto el ".$this->request->data['recordatorio'];
            $this->request->data['Cliente']['temperatura']    = 2;
            break;
        
        case('Inactivo');
            $leyenda = "Cliente ".$this->request->data['clienteNombre']." pasa a estatus inactivo definitivo por motivo: ".$this->request->data['motivo'];
            $this->request->data['Cliente']['temperatura']    = 1;
            break;

        case('Activo venta');
            $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus activo venta ";
            break;
    }

    // Cambiar el estatus al cliente
    $this->request->data['Cliente']['id']        = $cliente_id;
    $this->request->data['Cliente']['status']    = $this->request->data['status']; 
    $this->request->data['Cliente']['last_edit'] = $timestamp;
    // $this->Cliente->save($this->request->data);

    // Aviso en el log
    $this->LogCliente->create();
    $this->request->data['LogCliente']['id']         = uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
    $this->request->data['LogCliente']['user_id']    = $user_id;
    $this->request->data['LogCliente']['datetime']   = $timestamp;
    $this->request->data['LogCliente']['accion']     = 2;
    $this->request->data['LogCliente']['mensaje']    = $leyenda;
    $this->LogCliente->save($this->request->data);

    $this->LogCliente->create();
    $this->request->data['LogCliente']['id']         =  uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
    $this->request->data['LogCliente']['user_id']    = $user_id;
    $this->request->data['LogCliente']['datetime']   = $timestamp;
    $this->request->data['LogCliente']['accion']     = 2;
    $this->request->data['LogCliente']['mensaje']    = "Se actualizo el estatus del cliente ".$this->request->data['clienteNombre']." el ".date('Y-m-d H:i:s');
    $this->LogCliente->save($this->request->data);

    if ($this->request->data['status'] == "Inactivo temporal"){
        // Eventos
        $this->Event->create();
        $this->request->data['Event']['cliente_id']     = $cliente_id;
        $this->request->data['Event']['user_id']        = $user_id;
        $this->request->data['Event']['fecha_inicio']   = date('Y-m-d H:i:s', strtotime($this->request->data['recordatorio']." 10:00:00"));
        $this->request->data['Event']['recordatorio_1'] = date('Y-m-d H:i:s', strtotime($this->request->data['recordatorio']." 10:00:00"));
        $this->request->data['Event']['fecha_fin']      = date('Y-m-d H:i:s', strtotime($this->request->data['recordatorio']." 11:00:00"));
        $this->request->data['Event']['accion']         = 2;
        $this->request->data['Event']['cuenta_id']      = $cuenta_id;
        $this->request->data['Event']['nombre_evento']  = "Reactivacion automatica del cliente ".$this->request->data['clienteNombre']." para el día ".date('Y-m-d H:i:s', strtotime($this->request->data['recordatorio']." 10:00:00"));
        $this->Event->save($this->request->data);
    }

    //Registrar Seguimiento Rápido
    $this->Agenda->create();
    $this->request->data['Agenda']['user_id']    = $user_id;
    $this->request->data['Agenda']['fecha']      = $timestamp;
    $this->request->data['Agenda']['mensaje']    = $leyenda;
    $this->request->data['Agenda']['cliente_id'] = $cliente_id;
    $this->Agenda->save($this->request->data);

    if( $this->Cliente->save($this->request->data)) {
      $resp = array(
        'Ok' => true,
        'mensaje' => 'El estatus se ha cambiado correctamente'
      );
    }else{
      $resp = array(
        'Ok' => false,
        'mensaje' => 'No se ha podido actualizar el estatus del cliente'
      );
    }

    
    echo json_encode($resp, true);
    $this->autoRender = false; 

  }

  function get_cambio_temp( $user_id = null ){
      $this->layout = null;

      $cliente_id = $this->request->data['clienteId'];
      $temp       = array(1=>'Frio',2=>'Tibio',3=>'Caliente',4=>'Venta');
      $timestamp  = date('Y-m-d H:i:s');

      $this->request->data['Cliente']['id']          =  $cliente_id;
      $this->request->data['Cliente']['temperatura'] = $this->request->data['temperatura'];
      // $this->Cliente->save($this->request->data);
      
      $this->LogCliente->create();
      $this->request->data['LogCliente']['id']         =  uniqid();
      $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
      $this->request->data['LogCliente']['user_id']    = $user_id;
      $this->request->data['LogCliente']['datetime']   = $timestamp;
      $this->request->data['LogCliente']['accion']     = 2;
      $this->request->data['LogCliente']['mensaje']    = "Cliente ".$this->request->data['clienteNombre']." modifica a temperatura ".$temp[$this->request->data['temperatura']]." el ".date('Y-m-d H:i:s');
      $this->LogCliente->save($this->request->data);
      

      $this->Event->create();
      $this->request->data['Event']['cliente_id']    = $cliente_id;
      $this->request->data['Event']['user_id']       = $user_id;
      $this->request->data['Event']['fecha_inicio']  = date('Y-m-d H:i:s');
      $this->request->data['Event']['fecha_fin']     = $timestamp;
      $this->request->data['Event']['accion']        = 2;
      $this->request->data['Event']['nombre_evento'] = "Cliente ".$this->request->data['clienteNombre']." modifica a temperatura ".$temp[$this->request->data['temperatura']]." el ".date('Y-m-d H:i:s');;
      $this->Event->save($this->request->data);

      //Registrar Seguimiento Rápido
      $this->Agenda->create();
      $this->request->data['Agenda']['user_id']    = $user_id;
      $this->request->data['Agenda']['fecha']      = $timestamp;
      $this->request->data['Agenda']['mensaje']    = "Se modifica la temperatura del cliente a ".$temp[$this->request->data['temperatura']];
      $this->request->data['Agenda']['cliente_id'] = $cliente_id;
      $this->Agenda->save($this->request->data);

      $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = $cliente_id");

      if ($this->Cliente->save($this->request->data) ) {
        $resp = array(
          'Ok' => true,
          'mensaje' => 'Se guardo correctamente la información.'
        );
      }else {
        $resp = array(
          'Ok' => false,
          'mensaje' => 'No se ha guardado la información, favor de intentarlo nuevamente.'
        );
      }

      
      echo json_encode($resp, true);
      $this->autoRender = false; 
      
      
  }

  public function get_add_cliente( $user_id = null, $cuenta_id = null ){
    $this->layout = null;

    $params_cliente = array(
      'nombre'              => $this->request->data['nombre'],
      'correo_electronico'  => $this->request->data['correoElectronico'],
      'telefono1'           => $this->request->data['telefono1'],
      'telefono2'           => $this->request->data['telefono2'],
      'telefono3'           => $this->request->data['telefono3'],
      'tipo_cliente'        => $this->request->data['dicTipoClienteId'],
      
      'propiedades_interes' => $this->request->data['propInteres'],
      'forma_contacto'      => $this->request->data['dicLineaContactoId'],
      'comentario'          => $this->request->data['comentario'],
      'asesor_id'           => $this->request->data['userId'],
    );

    $params_user = array(
      'user_id'              => $user_id,
      'cuenta_id'            => $cuenta_id,
      'notificacion_1er_seg' => $this->Session->read('Parametros.Paramconfig.not_1er_seg_clientes'),
    );

    $save_client = $this->add_cliente( $params_cliente, $params_user );
    $this->validar_linea_contacto($save_client['cliente_id'],$params_user['user_id'],$params_user['cuenta_id'],$this->request->data['dicLineaContactoId'],$this->request->data['propInteres']);
    
    if( $save_client['bandera'] == 1 ){
      $resp = array(
        'Ok' => true,
        'mensaje' => $save_client['respuesta']
      );
    }else{
      $resp = array(
        'Ok' => false,
        'mensaje' => $save_client['respuesta']
      );
    }
    
    
    echo json_encode($resp, true);
    $this->autoRender = False;


  }

  /**
   * 
   * Metodo para agregar un cliente. 
   * Esta pensando en forma de objeto para reutilizarlo para la app.
   * Se agrega el 9no paso para agregar el log del cliente.
   * Cambio el 29 Sep 2022 AKA - Saak.
   * Cambio el 17 Abril 2023 AKA - SaaK: Se agrego la limpieza del campo de telefono a 10 digitos.
   * Agrega un if para traer el cambio de etapa desde los set AKA RogueOne 20 Abril 2023
   * 
  */
  function add_cliente( $params_cliente = null, $params_user = null ){
    date_default_timezone_set('America/Mexico_City');

    $this->Inmueble->Behaviors->load('Containable');
    $this->Desarrollo->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');

    $inmueble_interesado   = 0;   // Varibale para guardar los id's inmuebles interesados.
    $desarrollo_interesado = 0;   // Variable para guardar los id's de los desarrollos interesados
    $conditions_cliente    = [];
    $nombre_prop_interes   = [];


    // Condicion agregada para limpiar el telefono de los 10 digitos AKA SAAK 17 abril 2023
    // Eliminar espacios en blanco
    $cadenaSinEspacios = str_replace(' ', '', $params_cliente['telefono1']);

    // Obtener los �ltimos 10 caracteres
    $params_cliente['telefono1'] = substr($cadenaSinEspacios, -10);

    
    // Paso 1.- Revisar si se dara de alta por correo o telefono.
    if( $params_cliente['correo_electronico'] != '' AND  $params_cliente['telefono1'] != ''){
      
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

    }elseif( $params_cliente['correo_electronico'] != '' ){
      
      $conditions_cliente = array(
        'Cliente.correo_electronico' => $params_cliente['correo_electronico'],
        'Cliente.cuenta_id'          => $params_user['cuenta_id']
      );
      
      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'correo_electronico' => $params_cliente['correo_electronico'],
        'telefono1' => 'Sin teléfono'
      );

    }else{
      
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
    $cliente = $this->Cliente->find('first', array( 'conditions' => $conditions_cliente ) ); // Consulta del cliente en la bd.

    if( empty( $cliente ) ){ // No existe el cliente, GUARDAR

      // Paso 3.- Seteo de variables para guardar los datos.
      // Si existe una asignacion de asesor al cliente, se registra la fecha de asignacion y la fecha de ultima edición.
      if( !empty( $params_cliente['asesor_id'] ) ){
        $this->request->data['Cliente']['asignado']   = date('Y-m-d H:i:s');
        $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:i:s');
      }
      
      // Si la fecha esta definida en el formulario la asignamos con la variable, si no, la tomamos de la fecha actual en el sistema.
      $this->request->data['Cliente']['created'] = date('Y-m-d H:i:s');
      if( !empty( $params_cliente['created'] ) ){
        $this->request->data['Cliente']['created'] = $params_cliente['created'];
      }
      $this->request->data['Cliente']['etapa']                 = 1;
      if ( !empty ($params_cliente['etapa'])) {
        $this->request->data['Cliente']['etapa']                 = $params_cliente['etapa'];

      }
      $this->request->data['Cliente']['nombre']                = $params_cliente['nombre'];
      $this->request->data['Cliente']['correo_electronico']    = $data_3_cliente['correo_electronico'];
      $this->request->data['Cliente']['telefono1']             = $data_3_cliente['telefono1'];
      $this->request->data['Cliente']['dic_tipo_cliente_id']   = $params_cliente['tipo_cliente'];
      $this->request->data['Cliente']['status']                = 'Activo';
      $this->request->data['Cliente']['etapa_comercial']       = 'CRM';  
      $this->request->data['Cliente']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
      $this->request->data['Cliente']['cuenta_id']             = $params_user['cuenta_id'];
      $this->request->data['Cliente']['comentarios']           = $params_cliente['comentario'];
      $this->request->data['Cliente']['user_id']               = $params_cliente['asesor_id'];
      $this->request->data['Cliente']['fecha_cambio_etapa']    = date('Y-m-d');
      //rogueEtapaFecha
      $this->Cliente->create();

      // 4.- Salvado del cliente.
      if ( $this->Cliente->save( $this->request->data ) ) {


        $cliente_id = $this->Cliente->getInsertID(); // Guarda en la variable el id del cliente salvado.

        // Consulta de los datos de quien registra al cliente.
        $asesor = $this->User->find('first', array( 'conditions' => array('id' => $params_user['user_id'] ) ) ); // Consulta del asesor en la bd.
        // Se agrega la consulta para la información del cliente.
        $cliente = $this->Cliente->find('first', array( 'conditions' => array('Cliente.id' => $cliente_id) ) ); // Consulta del cliente en la bd.

        // Paso 5.- Guardar en log del cliente y el seguimiento rapido, que se ha creado el cliente.
        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         =  uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
        $this->request->data['LogCliente']['user_id']    = $params_user['user_id'];
        $this->request->data['LogCliente']['mensaje']    = "Cliente creado";
        $this->request->data['LogCliente']['accion']     = 1;
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
        $this->LogCliente->save($this->request->data);
        
        // Paso 6 guardar en la tabla de inmuebles o desarrollos, dependiendo cual sea el id de la propiedad que se intereso.
        if (substr($params_cliente['propiedades_interes'], 0, 1) == "E" || substr($params_cliente['propiedades_interes'], 0, 1) == "P"){ // La propiedad de interes es un inmueble
            
            $inmueble_id = substr($params_cliente['propiedades_interes'], 1);
            $this->request->data['LogInmueble']['mensaje']     = "Envío de propiedad a cliente: ".$params_cliente['nombre'];
            $this->request->data['LogInmueble']['usuario_id']  = $params_user['user_id'];
            $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
            $this->request->data['LogInmueble']['accion']      = 5;
            $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
            $this->LogInmueble->create();
            $this->LogInmueble->save($this->request->data);
            // $this->Lead->query("INSERT INTO leads VALUES(0,$cliente_id,$inmueble_id,'Abierto','',null,0)");

            $this->request->data['Lead']['cliente_id']            = $cliente_id;
            $this->request->data['Lead']['status']                = 'Abierto';
            $this->request->data['Lead']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
            $this->request->data['Lead']['inmueble_id']           = $inmueble_id;
            $this->request->data['Lead']['tipo_lead']             = 1;
            $this->request->data['Lead']['user_id']               = $params_cliente['asesor_id'];
            $this->request->data['Lead']['fecha']                 = date('Y-m-d h:i:s');
            $this->Lead->create();
            $this->Lead->save($this->request->data);

            $inmueble_interesado = $inmueble_id;

            $inmueble = $this->Inmueble->find('first',
              array(
                'conditions' => array( 'Inmueble.id' => $inmueble_id ),
                'fields'     => 'Inmueble.titulo',
                'contain'    => false
              )
            );

            $nombre_prop_interes = $inmueble['Inmueble']['titulo'];
            

        }else{ // En caso de que la propiedad de interes sea un desarrollo
            
          $desarrollo_id                                         = substr($params_cliente['propiedades_interes'], 1);
          $this->request->data['LogDesarrollo']['mensaje']       = "Envío de desarrollo a cliente: ".$params_cliente['nombre'];
          $this->request->data['LogDesarrollo']['usuario_id']    = $params_user['user_id'];
          $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
          $this->request->data['LogDesarrollo']['accion']        = 5;
          $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_id;
          $this->LogDesarrollo->create();
          $this->LogDesarrollo->save($this->request->data);
          // $this->Lead->query("INSERT INTO leads VALUES(0,$cliente_id,null,'Abierto','',$desarrollo_id,0)");

          $this->request->data['Lead']['cliente_id']            = $cliente_id;
          $this->request->data['Lead']['status']                = 'Abierto';
          $this->request->data['Lead']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
          $this->request->data['Lead']['desarrollo_id']         = $desarrollo_id;
          $this->request->data['Lead']['tipo_lead']             = 1;
          $this->request->data['Lead']['user_id']               = $params_cliente['asesor_id'];
          $this->request->data['Lead']['fecha']                 = date('Y-m-d h:i:s');
          $this->Lead->create();
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
          $this->editInformacionProspeccion( $data_add_prospeccion );
          
        }

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
        $this->request->data['Agenda']['mensaje']        = "Cliente creado por usuario ".$asesor['User']['nombre_completo']." solicita información de ".$nombre_prop_interes." vía ".$forma_contacto.".";
        $this->request->data['Agenda']['cliente_id']     = $cliente_id;
        $this->Agenda->save($this->request->data);

        // Paso 7.- Actualizar el registro del cliente, con el id del desarrollo o el inmueble de interes.
        $this->Cliente->query("UPDATE clientes SET desarrollo_id = $desarrollo_interesado, inmueble_id = $inmueble_interesado WHERE id = $cliente_id ");

        // Paso 8.- Notificacion por correo a Asesor y a Gerentes de la creación y asignación de un nuevo cliente.
        $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE cliente_id = $cliente_id)")));
        $desarrollos = $this->Desarrollo->find('all',array('conditions'=>array("Desarrollo.id IN (SELECT leads.desarrollo_id FROM leads WHERE cliente_id = $cliente_id)")));

        $usuario     = $this->User->read(null, $params_cliente['asesor_id']);
        //$usuario     = $this->User->read(null, 447);
        $cuenta      = $this->Cuenta->findFirstById( $params_user['cuenta_id']);
        $mailconfig  = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id'] );
        $paramconfig = $this->Paramconfig->findFirstById( $cuenta['Cuenta']['paramconfig_id'] );

        if (!empty($this->request->data['Cliente']['user_id'])){
          
          // Validacion de notificacion de primero seguimiento a clientes.
          if( $params_user['notificacion_1er_seg'] == 1 ){
            
            if ($data_3_cliente['correo_electronico'] != 'Sin correo'){
              if ( $paramconfig['Paramconfig']['mep'] == 1 ){
                  $this->Email = new CakeEmail();
                  $this->Email->config(array(
                      'host'      => $mailconfig['Mailconfig']['smtp'],
                      'port'      => $mailconfig['Mailconfig']['puerto'],
                      'username'  => $mailconfig['Mailconfig']['usuario'],
                      'password'  => $mailconfig['Mailconfig']['password'],
                      'transport' => 'Smtp'
                      )
                  );
                  $this->Email->emailFormat('html');
                  $this->Email->template('emailacliente','layoutinmomail');
                  $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                  //$this->Email->from('notificaciones@adryo.com.mx');
                  $this->Email->to($data_3_cliente['correo_electronico']);
                  
                  if ( $paramconfig['Paramconfig']['cc_a_c'] != ""){
                      $emails = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                      $arreglo_emails = array();
                      if (sizeof($emails)>0){
                          foreach($emails as $email):
                              $arreglo_emails[$email] = $email;
                          endforeach;
                      }else{
                          $arreglo_emails[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                      }
                      $this->Email->bcc( $arreglo_emails );
                  }
                  
                  $this->Email->subject($paramconfig['Paramconfig']['smessage_new_client']);
                  $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_new_client'], 'rds_sociales' => $cuenta ));
                  $this->Email->send();
  
                  if ( sizeof($propiedades) > 0 ) {
                      $info = $propiedades[0]['Inmueble']['referencia'];
                  }else{
                      $info = $desarrollos[0]['Desarrollo']['nombre'];
                  }
  
                  $this->LogCliente->create();
                  $this->request->data['LogCliente']['id']         = uniqid();
                  $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
                  $this->request->data['LogCliente']['user_id']    = $params_user['user_id'];
                  $this->request->data['LogCliente']['mensaje']    = "Email enviado con la información de ".$info;
                  $this->request->data['LogCliente']['accion']     = 3;
                  $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                  $this->LogCliente->save($this->request->data);
                }
            }

          }

          //Enviar mail a asesor
          if ( $paramconfig['Paramconfig']['ma'] ==1 ){
            if ( !empty($params_cliente['asesor_id']) && $params_cliente['asesor_id'] != $params_user['user_id'] ){
                $this->Email = new CakeEmail();
                $this->Email->config(array(
                    'host'      => $mailconfig['Mailconfig']['smtp'],
                    'port'      => $mailconfig['Mailconfig']['puerto'],
                    'username'  => $mailconfig['Mailconfig']['usuario'],
                    'password'  => $mailconfig['Mailconfig']['password'],
                    'transport' => 'Smtp'
                    )
                );
                $this->Email->emailFormat('html');
                $this->Email->template('emailaasesor','layoutinmomail');
                $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
                $this->Email->to($usuario['User']['correo_electronico']);

                if ( $paramconfig['Paramconfig']['asignacion_c_a'] != "" ){
                  $emails_c_a = explode( ",", $paramconfig['Paramconfig']['asignacion_c_a'] );
                  $arreglo_emails_c_a = array();
                  if (sizeof($emails_c_a)>0){
                      foreach($emails_c_a as $email_c_a):
                          $arreglo_emails_c_a[$email_c_a] = $email_c_a;
                      endforeach;
                  }else{
                      $arreglo_emails_c_a[$paramconfig['Paramconfig']['asignacion_c_a']] = $paramconfig['Paramconfig']['asignacion_c_a'];
                  }
                  $this->Email->bcc( $arreglo_emails_c_a );
                }

                $this->Email->subject('Nuevo cliente asignado');
                $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
                  
                $this->Email->send();
            }
          }
        }

        // Notificacion a Gerentes y SuperAdmin's
        // Se quita la notificacion a super admins porque el proceso para las notificaciones se hara por las mañanas con un cronjob

        // Paso 9.- Guardamos en el log de cliente de las etapas, la entrada numero 1 para el embudo de clientes.
        // Se agrega como primer entrada en el log la etapa 1 del cliente de forma automatica.
        $this->LogClientesEtapa->create();
        $this->request->data['LogClientesEtapa']['cliente_id']   = $cliente_id;
        $this->request->data['LogClientesEtapa']['fecha']        = date('Y-m-d H:i:s');
        $this->request->data['LogClientesEtapa']['etapa']        = 1;
        $this->request->data['LogClientesEtapa']['desarrollo_id'] = $desarrollo_interesado;
        $this->request->data['LogClientesEtapa']['inmuble_id']   = $inmueble_interesado;
        $this->request->data['LogClientesEtapa']['status']       = 'Activo';
        $this->request->data['LogClientesEtapa']['user_id']      = $params_user['user_id'];
        $this->LogClientesEtapa->save($this->request->data);


        
        $respuesta = array(
          'respuesta'   => 'Se ha guardado correctamente el cliente.',
          'bandera'     => true,
          'cliente_id'  => $cliente_id
        );

      }else{
        
        // No se hizo el registro en la tabla de clientes.
        $respuesta = array(
          'respuesta'   => 'El cliente NO se ha podido guardar en la tabla de clientes, favor de intentarlo nuevamente, Gracias.',
          'bandera'     => false,
          'cliente_id'  => 0
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

  /* ----------------- Actualizacion de clientes desde la app ----------------- */
  public function get_cliente_update( $user_id = null, $cuenta_id = null ) {

    $this->layout = null;

    $params_cliente = array(
      'cliente_id'          => $this->request->data['clienteId'],
      'nombre'              => $this->request->data['nombre'],
      'correo_electronico'  => $this->request->data['correoElectronico'],
      'telefono1'           => $this->request->data['telefono1'],
      'telefono2'           => $this->request->data['telefono2'],
      'telefono3'           => $this->request->data['telefono3'],
      'tipo_cliente'        => $this->request->data['dicTipoClienteId'],
      'etapa_cliente'       => $this->request->data['dicEtapaId'],
      'forma_contacto'      => $this->request->data['dicLineaContactoId'],
      'comentario'          => $this->request->data['comentario'],
      'asesor_id'           => $this->request->data['userId'],
      'temperatura'         => $this->request->data['temperatura'],
    );

    $params_user = array(
      'user_id'   => $user_id,
      'cuenta_id' => $cuenta_id
    );

    $update = $this->cliente_update( $params_cliente, $params_user );

    echo json_encode ( $update, true );
    $this->autoRender = False;
  }

  function cliente_update( $params_cliente = null, $params_user = null ){
    // Consultar el cliente
    $cliente     = $this->Cliente->read(null, $params_cliente['cliente_id'] );
    $cuenta      = $this->Cuenta->findFirstById( $params_user['cuenta_id']);
    $mailconfig  = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id'] );
    $paramconfig = $this->Paramconfig->findFirstById( $cuenta['Cuenta']['paramconfig_id'] );
    $usuario     = $this->User->read(null,$params_user['user_id']);

    // Definicion de variables segun si estan vacios los campos de telefono y correo.
    if( $params_cliente['correo_electronico'] != '' AND  $params_cliente['telefono1'] != ''){
      
      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'correo_electronico' => $params_cliente['correo_electronico'],
        'telefono1'          => $params_cliente['telefono1']
      );

    }elseif( $params_cliente['correo_electronico'] != '' ){
      
      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'correo_electronico' => $params_cliente['correo_electronico'],
        'telefono1' => 'Sin teléfono'
      );

    }else{
      
      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'telefono1'          => $params_cliente['telefono1'],
        'correo_electronico' => 'Sin correo'
      );

    }

    // Si es su primer seguimiento


    if ($cliente['Cliente']['first_edit'] == ""){
      $this->request->data['Cliente']['first_edit'] = date('Y-m-d H:i:s');
      
      $this->Email = new CakeEmail();
      $this->Email->config(array(
          'host'      => $mailconfig['Mailconfig']['smtp'],
          'port'      => $mailconfig['Mailconfig']['puerto'],
          'username'  => $mailconfig['Mailconfig']['usuario'],
          'password'  => $mailconfig['Mailconfig']['password'],
          'transport' => 'Smtp'
        )
      );

      $this->Email->emailFormat('html');
      $this->Email->template('notificacioncliente','layoutinmomail');
      $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
      $this->Email->to($this->Session->read('Parametros.Paramconfig.to_mr'));
      $this->Email->subject('Primer seguimiento realizado');
      $this->Email->viewVars(array('cliente' => $cliente,'usuario'=>$usuario));
      //$this->Email->send();
      
      $this->LogCliente->create();
      $this->request->data['LogCliente']['id']         = uniqid();
      $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
      $this->request->data['LogCliente']['user_id']    = $params_user['user_id'];
      $this->request->data['LogCliente']['mensaje']    = "Primer seguimiento";
      $this->request->data['LogCliente']['accion']     = 2;
      $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
      $this->LogCliente->save($this->request->data);
    }

    $this->request->data['Cliente']['last_edit'] = date('Y-m-d H:i:s');

    // Log del cliente
    $this->LogCliente->create();
    $this->request->data['LogCliente']['id']         = uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $params_cliente['cliente_id'];
    $this->request->data['LogCliente']['user_id']    = $params_user['user_id'];
    $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
    $this->request->data['LogCliente']['accion']     = 2;
    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
    $this->LogCliente->save($this->request->data);
    
    // Save cliente.
    $this->request->data['Cliente']['id']                    = $params_cliente['cliente_id'];
    $this->request->data['Cliente']['nombre']                = $params_cliente['nombre'];
    $this->request->data['Cliente']['correo_electronico']    = $data_3_cliente['correo_electronico'];
    $this->request->data['Cliente']['telefono1']             = $data_3_cliente['telefono1'];
    $this->request->data['Cliente']['telefono2']             = $params_cliente['telefono2'];
    $this->request->data['Cliente']['telefono3']             = $params_cliente['telefono3'];
    $this->request->data['Cliente']['dic_tipo_cliente_id']   = $params_cliente['tipo_cliente'];
    $this->request->data['Cliente']['dic_etapa_id']          = $params_cliente['etapa_cliente'];
    $this->request->data['Cliente']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
    $this->request->data['Cliente']['comentarios']           = $params_cliente['comentario'];
    $this->request->data['Cliente']['user_id']               = $params_cliente['asesor_id'];
    $this->request->data['Cliente']['temperatura']           = $params_cliente['temperatura'];

    if ( $this->Cliente->save($this->request->data) ) {
      
      $respuesta = array(
        'respuesta' => 'Se han guardado los cambios correctamente.',
        'bandera'   => true
      );

    }else{
      $respuesta = array(
        'respuesta' => 'El cliente no se ha podido guardar, favor de intentarlo nuevamente',
        'bandera'   => false
      );
    }


    

    return $respuesta;

  }

  public function get_llamdas_cliente( ){
    $this->layout = null;
    $cliente_id   = $this->request->data['clienteId'];
    $user_id      = $this->request->data['userId'];
    $cuenta_id    = $this->request->data['cuentaId'];

    $cliente = $this->Cliente->findAllById( $cliente_id );


    if ( $this->request->data['mensaje'] != '' ) { $mensaje = 'Se realizó llamada a cliente: '.$this->request->data['mensaje']; }
    else{ $mensaje = 'Se realizo llamada a cliente'; }

    $this->LogCliente->create();
    $this->request->data['LogCliente']['id']         =  uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
    $this->request->data['LogCliente']['user_id']    = $user_id;
    $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
    $this->request->data['LogCliente']['accion']     = 4;
    $this->request->data['LogCliente']['mensaje']    = $mensaje;
    $this->LogCliente->save($this->request->data);
    
    
    //Registrar Seguimiento Rápido
    $this->Agenda->create();
    $this->request->data['Agenda']['user_id']    = $user_id;
    $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
    $this->request->data['Agenda']['mensaje']    = $mensaje;
    $this->request->data['Agenda']['cliente_id'] = $cliente_id;
    $this->Agenda->save($this->request->data);

    $this->Cliente->query("UPDATE clientes SET last_edit = '".date('Y-m-d H:i:s')."' WHERE id = $cliente_id");
    
    $respuesta = array(
      'bandera' => true,
      'mensaje' => 'Se ha registrado correctamente la llamada.'
    );
    
    echo json_encode( $respuesta );
    $this->autoRender = false;

  }

  // public function pipeline(){
  //   /* -------------------------------------------------------------------------- */
  //   /*                             Grupos de usuarios                             */
  //   /*  1 => Superadmin                                                           */
  //   /*  2 => Gerente                                                              */
  //   /*  3 => Asesor                                                               */
  //   /*  4 => Auxiliar                                                             */
  //   /*  5 => Cliente desarrollador                                                */
  //   /*  6 => Gerente Aux                                                          */
  //   /* -------------------------------------------------------------------------- */

  //   $this->set('etapas', $this->etapas_cliente);


  //   $this->Cliente->Behaviors->load('Containable');
  //   $conditions_e1 = array();
  //   $conditions_e2 = array();
  //   $conditions_e3 = array();
  //   $conditions_e4 = array();
  //   $conditions_e5 = array();
  //   $conditions_e6 = array();
  //   $conditions_e7 = array();
  //   $condicion_desarrollos = array();

  //   // Agregar condicion para mostrar clientes de desarrolladores.
    
  //   // Alejandro Hernandez AKA SaaK
  //   if ( $this->Session->read('Permisos.Group.id') == 5 ) {

  //   }
    
  //   $contain_cliente = array(
  //     'User'=>array(
  //       'fields'=>array(
  //         'nombre_completo'
  //       )
  //     ),
  //     'Inmueble'=>array(
  //       'fields'=>array(
  //         'titulo'
  //       )
  //     ),
  //     'Desarrollo'=>array(
  //       'fields'=>array(
  //         'nombre','id'
  //       ),
  //     ),
  //     'Lead'=>array(
  //       'conditions'=>array(
  //         'Lead.status'=>'Aprobado'
  //       ),
  //       'Desarrollo'=>array(
  //         'fields'=>array('nombre','id')
  //       ),
  //       'Inmueble'=>array(
  //         'fields'=>'titulo'
  //       ),
  //     ),
  //   );

  //   $fields_clientes = array(
  //     'id',
  //     'nombre',
  //     'last_edit',
  //   );

  //   if($this->request->is('post')){

  //     if ( $this->request->data['Cliente']['asesor_id'] == "" && $this->request->data['Cliente']['desarrollo_id'] == "" && $this->request->data['Cliente']['nombre_cliente'] == "" ){

  //       $this->redirect(array('action' => 'pipeline'));  

  //     }else{
        
  //       $conditions_e1 = array('Cliente.status'        => array('Activo'),);
  //       $conditions_e2 = array('Cliente.status'        => array('Activo'),);
  //       $conditions_e3 = array('Cliente.status'        => array('Activo'),);
  //       $conditions_e4 = array('Cliente.status'        => array('Activo'),);
  //       $conditions_e5 = array('Cliente.status'        => array('Activo'),);
  //       $conditions_e6 = array('Cliente.status'        => array('Activo'),);
  //       $conditions_e7 = array('Cliente.status'        => array('Activo'),);

        
  //       if ( $this->request->data['Cliente']['asesor_id'] != "" ){

  //         array_push($conditions_e1,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
  //         array_push($conditions_e2,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
  //         array_push($conditions_e3,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
  //         array_push($conditions_e4,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
  //         array_push($conditions_e5,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
  //         array_push($conditions_e6,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
  //         array_push($conditions_e7,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);

  //       }else {
          
  //         array_push($conditions_e1,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e2,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e3,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e4,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e5,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e6,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e7,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);

  //       }

  //       if ( $this->request->data['Cliente']['desarrollo_id'] != "" ){

  //         array_push($conditions_e1,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
  //         array_push($conditions_e2,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
  //         array_push($conditions_e3,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
  //         array_push($conditions_e4,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
  //         array_push($conditions_e5,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
  //         array_push($conditions_e6,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
  //         array_push($conditions_e7,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          
  //         $this->set('desarrollo_id',$this->request->data['Cliente']['desarrollo_id']);

  //         if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5) {
            
  //           $condicion_desarrollos = array(
  //             'Desarrollo.id'         => $this->Session->read('Desarrollos')
  //           );
            
  //         }


  //       }else {
          
  //         if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5) {
            
  //           $condicion_desarrollos = array(
  //             'Desarrollo.id'         => $this->Session->read('Desarrollos')
  //           );
            
  //           array_push($conditions_e1,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
  //           array_push($conditions_e2,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
  //           array_push($conditions_e3,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
  //           array_push($conditions_e4,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
  //           array_push($conditions_e5,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
  //           array_push($conditions_e6,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
  //           array_push($conditions_e7,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);

  //         }else {

  //           array_push($conditions_e1,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //           array_push($conditions_e2,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //           array_push($conditions_e3,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //           array_push($conditions_e4,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //           array_push($conditions_e5,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //           array_push($conditions_e6,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //           array_push($conditions_e7,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);

  //         }


  //       }

  //       if ( $this->request->data['Cliente']['nombre_cliente'] != "" ){

  //         array_push($conditions_e1,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
  //         array_push($conditions_e2,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
  //         array_push($conditions_e3,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
  //         array_push($conditions_e4,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
  //         array_push($conditions_e5,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
  //         array_push($conditions_e6,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
  //         array_push($conditions_e7,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);

  //       }else {

  //         array_push($conditions_e1,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e2,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e3,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e4,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e5,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e6,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
  //         array_push($conditions_e7,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);

  //       }

  //       array_push($conditions_e1,['Cliente.etapa'=>1]);
  //       array_push($conditions_e2,['Cliente.etapa'=>2]);
  //       array_push($conditions_e3,['Cliente.etapa'=>3]);
  //       array_push($conditions_e4,['Cliente.etapa'=>4]);
  //       array_push($conditions_e5,['Cliente.etapa'=>5]);
  //       array_push($conditions_e6,['Cliente.etapa'=>6]);
  //       array_push($conditions_e7,['Cliente.etapa'=>7]);
        
        
  //     }

  //   }else{

  //     switch($this->Session->read('CuentaUsuario.CuentasUser.group_id')):
  //       case(3):
  //         $conditions_e1 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 1
  //         );
  //         $conditions_e2 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 2
  //         );
  //         $conditions_e3 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 3
  //         );
  //         $conditions_e4 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 4
  //         );
  //         $conditions_e5 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 5
  //         );
  //         $conditions_e6 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 6
  //         );
  //         $conditions_e7 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
  //           'Cliente.etapa' => 7
  //         );
  //       break;


  //       case(5):
  //         $conditions_e1 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 1
  //         );
  //         $conditions_e2 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 2
  //         );
  //         $conditions_e3 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 3
  //         );
  //         $conditions_e4 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 4
  //         );
  //         $conditions_e5 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 5
  //         );
  //         $conditions_e6 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 6
  //         );
  //         $conditions_e7 = array(
  //           'Cliente.status'        => array('Activo'),
  //           'Cliente.user_id <>'    => '',
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos'),
  //           'Cliente.etapa' => 7
  //         );

  //         $condicion_desarrollos = array(
  //           'Desarrollo.id'         => $this->Session->read('Desarrollos')
  //         );

  //       break;


  //       case(6):
  //         $conditions_e1 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>1
  //               ),
  //         );
  //         $conditions_e2 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>2
  //               ),
  //         );
  //         $conditions_e3 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>3
  //               ),
  //         );
  //         $conditions_e4 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>4
  //               ),
  //         );
  //         $conditions_e5 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>5
  //               ),
  //         );
  //         $conditions_e6 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>6
  //               ),
  //         );
  //         $conditions_e7 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
  //               'Cliente.etapa'=>7
  //               ),
  //         );
  //       break;
  //       default:
  //         $conditions_e1 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.etapa'=>1
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );
  //         $conditions_e2 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.etapa'=>2
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );
  //         $conditions_e3 = array(
  //           'AND'=>array(
  //               'Cliente.status' => array('Activo'),
  //               'Cliente.etapa'  => 3
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );
  //         $conditions_e4 = array(
  //           'AND'=>array(
  //               'Cliente.status' => array('Activo'),
  //               'Cliente.etapa'  => 4
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );
  //         $conditions_e5 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.etapa'=>5
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );
  //         $conditions_e6 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.etapa'=>6
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );
  //         $conditions_e7 = array(
  //           'AND'=>array(
  //               'Cliente.status'        => array('Activo'),
  //               'Cliente.etapa'=>7
  //               ),
  //           'OR'=>array(
  //               'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
  //               'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           )
  //         );

  //         $condicion_desarrollos = array(
  //           'OR' => array(
  //             'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //             'Desarrollo.cuenta_id'          => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
  //           ), 
  //           'AND' => array(
  //             'Desarrollo.is_private' => 0
  //           )
  //         );

  //       break;
  //     endswitch;
  //   }

  //   $this->set('clientes_e1',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e1,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
  //   $this->set('clientes_e2',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e2,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
  //   $this->set('clientes_e3',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e3,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
  //   $this->set('clientes_e4',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e4,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
  //   $this->set('clientes_e5',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e5,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
  //   $this->set('clientes_e6',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e6,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
  //   $this->set('clientes_e7',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e7,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));

    
  //   $users  = $this->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.status'=>1,'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));
    
  //   $this->set('users',$users);

  //   $desarrollos = $this->Desarrollo->find(
  //     'list',
  //     array(
  //         'conditions'=> $condicion_desarrollos,
  //         'order' => 'Desarrollo.nombre'
  //       )
  //   );

  //   $this->set('desarrollos',$desarrollos);

  //   $tipo_propiedad = $this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));

  //   $propiedades_text = array();
  //   foreach($tipo_propiedad as $tipo):
  //       $propiedades_text[$tipo] = $tipo;
  //   endforeach;

  //   // Variables para prospeccion
  //   $this->set( array('opciones_venta' => $this->opciones_venta, 'opciones_formas_pago' => $this->opciones_formas_pago, 'opciones_minimos' => $this->opciones_minimos, 'opciones_amenidades'=> $this->opciones_amenidades, 'propiedades_text' => $propiedades_text) );
    
  // }

  public function pipeline(){

    $condicion_desarrollos = array(
      'OR' => array(
        'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
        'Desarrollo.cuenta_id'          => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
      ), 
      'AND' => array(
        'Desarrollo.is_private' => 0
      )
    );

    $desarrollos = $this->Desarrollo->find(
      'list',
      array(
          'conditions'=> $condicion_desarrollos,
          'order' => 'Desarrollo.nombre'
        )
    );

    $users  = $this->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.status'=>1,'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));
    
    $this->set(compact('desarrollos', 'users'));

  }

  /**
   * Metodo para traer el listado de las cuentas, solo los nombres
  */
  public function get_list_etapas( $cuenta_id = null ){
    $response = [];

    $etapa_1 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 1 ), 'contain' => false, 'fields' => array('nombre') ));
    $etapa_2 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 2 ), 'contain' => false, 'fields' => array('nombre') ));
    $etapa_3 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 3 ), 'contain' => false, 'fields' => array('nombre') ));
    $etapa_4 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 4 ), 'contain' => false, 'fields' => array('nombre') ));
    $etapa_5 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 5 ), 'contain' => false, 'fields' => array('nombre') ));
    $etapa_6 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 6 ), 'contain' => false, 'fields' => array('nombre') ));
    $etapa_7 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 7 ), 'contain' => false, 'fields' => array('nombre') ));

    // Variables para el nombre de las etapas.
    $response[1] = ( !empty($etapa_1['DicEmbudoVenta']['nombre']) ? $etapa_1['DicEmbudoVenta']['nombre'] : '' );
    $response[2] = ( !empty($etapa_2['DicEmbudoVenta']['nombre']) ? $etapa_2['DicEmbudoVenta']['nombre'] : '' );
    $response[3] = ( !empty($etapa_3['DicEmbudoVenta']['nombre']) ? $etapa_3['DicEmbudoVenta']['nombre'] : '' );
    $response[4] = ( !empty($etapa_4['DicEmbudoVenta']['nombre']) ? $etapa_4['DicEmbudoVenta']['nombre'] : '' );
    $response[5] = ( !empty($etapa_5['DicEmbudoVenta']['nombre']) ? $etapa_5['DicEmbudoVenta']['nombre'] : '' );
    $response[6] = ( !empty($etapa_6['DicEmbudoVenta']['nombre']) ? $etapa_6['DicEmbudoVenta']['nombre'] : '' );
    $response[7] = ( !empty($etapa_7['DicEmbudoVenta']['nombre']) ? $etapa_7['DicEmbudoVenta']['nombre'] : '' );

    echo json_encode( $response, true );
    $this->autoRender = false;

  }

  public function cambiarEstadoPipeline(){

    if ($this->request->is('post')){
      $estados = array(
        1=>'Interés Preliminar',
        2=>'Comunicación Abierta',
        3=>'Precalificación',
        4=>'Cita / Visita',
        5=>'Consideración',
        6=>'Validación de Recursos',
        7=>'Cierre' 
      );
      $timestamp = date('Y-m-d H:i:s');
      $agenda = [
        'fecha'      => $timestamp,
        'user_id'    => $this->Session->read('Auth.User.id'),
        'mensaje'    => 'El cliente se mueve a '.$estados[$this->request->data['Cliente']['nuevo_status']].' por la siguiente razón: '.$this->request->data['Cliente']['comentarios'],
        'cliente_id' => $this->request->data['Cliente']['id']
      ];
      
      $this->Agenda->save($agenda);
      $this->Agenda->query("UPDATE clientes SET comentarios= '".$agenda['mensaje']."', etapa = ".$this->request->data['Cliente']['nuevo_status'].",last_edit = '$timestamp' WHERE id = ".$this->request->data['Cliente']['id']);

      if( $this->request->data['Cliente']['cambiaForma'] == 1 ){
        $this->request->data['Cliente']['last_edit'] = date('Y-m-d H:i:s');
                
        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         =  uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Cliente']['id'];
        $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
        $this->request->data['LogCliente']['mensaje']    = "Cliente modificado";
        $this->request->data['LogCliente']['accion']     = 2;
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
        $this->LogCliente->save($this->request->data);

        $this->Agenda->create();
        $mensaje = "Se actualiza la información del perfil del cliente: ";
        
        if ($this->request->data['Cliente']['operacion_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['operacion_prospeccion']."/ ";
        }
        if ($this->request->data['Cliente']['precio_min_prospeccion']!=""){
          $mensaje = $mensaje."$ de: ".$this->request->data['Cliente']['precio_min_prospeccion']." ";
        }
        if ($this->request->data['Cliente']['precio_max_prospeccion']!=""){
          $mensaje = $mensaje."a: ".$this->request->data['Cliente']['precio_max_prospeccion']."/ ";
        }
        if ($this->request->data['Cliente']['forma_pago_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['forma_pago_prospeccion']."/ ";
        }

        if ($this->request->data['Cliente']['tipo_propiedad_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['tipo_propiedad_prospeccion']."/ ";
        }
        if ($this->request->data['Cliente']['operacion_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['operacion_prospeccion']."/ ";
        }
        if ($this->request->data['Cliente']['metros_min_prospeccion']!=""){
          $mensaje = $mensaje."De: ".$this->request->data['Cliente']['metros_min_prospeccion']."M2 ";
        }
        if ($this->request->data['Cliente']['metros_max_prospeccion']!=""){
          $mensaje = $mensaje."a: ".$this->request->data['Cliente']['metros_max_prospeccion']."M2/ ";
        }
        if ($this->request->data['Cliente']['hab_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['hab_prospeccion']."R/ ";
        }
        if ($this->request->data['Cliente']['banios_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['hab_prospeccion']."B/ ";
        }
        if ($this->request->data['Cliente']['estacionamientos_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['hab_prospeccion']."E/ ";
        }
        if ($this->request->data['Cliente']['amenidades_prospeccion_arreglo']!=""){
          $amenidades = "";
          foreach($this->request->data['Cliente']['amenidades_prospeccion_arreglo'] as $amenidad):
            $amenidades = $amenidades.$amenidad.",";
          endforeach;
          $mensaje = $mensaje.$amenidades."/ ";
          $this->request->data['Cliente']['amenidades_prospeccion'] = $amenidades;
        }
        if ($this->request->data['Cliente']['ciudad_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['estado_prospeccion'].",".$this->request->data['Cliente']['ciudad_prospeccion'].",".$this->request->data['Cliente']['colonia_prospeccion'].", ";
        }

        if ($this->request->data['Cliente']['zona_prospeccion']!=""){
          $mensaje = $mensaje.$this->request->data['Cliente']['zona_prospeccion'].".";
        }
        
        $this->request->data['Agenda']['user_id']        = $this->Session->read('Auth.User.id');
        $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']        = $mensaje;
        $this->request->data['Agenda']['cliente_id']     = $this->request->data['Cliente']['id'];
        $this->Agenda->save($this->request->data);
      }

      if ($this->Cliente->save($this->request->data)){
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('Se ha actualizado el estatus del cliente satisfactoriamente.', 'default', array(), 'm_success');

        switch($this->request->data['Cliente']['url']){
          case(1): //Proviene del Pipeline
            $this->redirect(array('action' => 'pipeline'));
          break;
          case(2)://Proviene de la vista del cliente
            $this->redirect(array('action' => 'view',$this->request->data['Cliente']['id']));
          break;
        }
      }
      
    }

  }
  
  public function set_cambio_estado( $user_id = null ) {
    $timestamp = date('Y-m-d H:i:s');

    if ($this->request->is('post')){

      $estados = array(
        1=>'Interés Preliminar',
        2=>'Comunicación Abierta',
        3=>'Precalificación',
        4=>'Cita / Visita',
        5=>'Consideración',
        6=>'Validación de Recursos',
        7=>'Cierre' 
      );
      $nuevo_estado = $this->request->data['estado'] + 1;

      
      $agenda = [
        'fecha'      => $timestamp,
        'user_id'    => $user_id,
        'mensaje'    => 'El cliente se mueve a '.$estados[$nuevo_estado].' por la siguiente razón: '.$this->request->data['comentarios'],
        'cliente_id' => $this->request->data['clienteId']
      ];
      
      $this->Agenda->save($agenda);
      $this->Agenda->query("UPDATE clientes SET comentarios= '".$agenda['mensaje']."', etapa = ".$nuevo_estado.",last_edit = '$timestamp' WHERE id = ".$this->request->data['clienteId']);

      $respuesta = array(
        'bandera'     => true,
        'respuesta'   => 'Se ha guardado correctamente el cliente.'
      );

    }


    echo json_encode($respuesta, true);
    $this->autoRender = false; 

  }

  public function get_pipeline( $user_id = null, $tipo_clientes = null ) {
    $s        = 0;
    $clientes_new = [];
    $propiedad = '';

    $data = array(
      'user_id'       => $user_id,
      'tipo_clientes' => $tipo_clientes
    );

    $clientes = $this->listado_pipeline( $data );

    foreach( $clientes['datos'] as $cliente ) {

      $propiedad = $cliente['Inmueble']['titulo'];
      $propiedad .= ', '.$cliente['Desarrollo']['nombre'];


      if( !empty( $cliente['Lead'] ) ) {

        foreach( $cliente['Lead'] as $p_interes ) {
          
          if( !empty( $p_interes['Inmueble']['titulo'] ) ) {
            $propiedad = $p_interes['Inmueble']['titulo'];
            // echo $propiedad;
          }

          if( !empty( $p_interes['Desarrollo'] ) ) {
            $propiedad .= ', '.$p_interes['Desarrollo']['nombre'];
          }

        }

      }

      $clientes_new[$s] = array(
        'nombre_cliente' => $cliente['Cliente']['nombre'],
        'cliente_id'     => $cliente['Cliente']['id'],
        'last_edit'      => $cliente['Cliente']['last_edit'],
        'nombre_asesor'  => $cliente['User']['nombre_completo'],
        'asesor_id'      => $cliente['User']['id'],
        'propiedad'      => $propiedad,
      );

      $s++;
      
    }

    // print_r( $clientes_new );
    echo json_encode( $clientes_new, true );
    $this->autoRender = false;

  }

  public function listado_pipeline( $data = false ) {
    $this->User->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');

    // Condiciones para los super admin y asesores.
    $user = $this->User->find('first', array(
      'conditions' => array(
        'id' => $data['user_id']
      ),
      'contain' => array(
        'Rol'
      ),
      'fields' => array(
        'User.id',
        'User.nombre_completo'
      )
    ));

    $cuenta = $this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$data['user_id'])));

    /* ---------------- Parametros de busqueda para los clientes. --------------- */

    $contain_cliente = array(
      'User'=>array(
        'fields'=>array(
          'nombre_completo'
        )
      ),
      'Inmueble'=>array(
        'fields'=>array(
          'titulo'
        )
      ),
      'Desarrollo'=>array(
        'fields'=>array(
          'nombre'
        ),
      ),
      'Lead'=>array(
        'conditions'=>array(
          'Lead.status'=>'Aprobado'
        ),
        'Desarrollo'=>array(
          'fields'=>'nombre'
        ),
        'Inmueble'=>array(
          'fields'=>'titulo'
        ),
      ),
    );

    $fields_clientes = array(
      'id',
      'nombre',
      'last_edit',
    );


    // switch($user['Rol'][0]['cuentas_users']['group_id']):
    //   case(3):
    //     $conditions_e1 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 1
    //     );
    //     $conditions_e2 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 2
    //     );
    //     $conditions_e3 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 3
    //     );
    //     $conditions_e4 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 4
    //     );
    //     $conditions_e5 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 5
    //     );
    //     $conditions_e6 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 6
    //     );
    //     $conditions_e7 = array(
    //       'Cliente.status'  => array('Activo'),
    //       'Cliente.user_id' => $user['User']['id'],
    //       'Cliente.etapa'   => 7
    //     );
    //   break;


    //   // case(5):
    //   //   $conditions_e1 = array(
    //   //     'Cliente.status'     => array('Activo'),
    //   //     'Cliente.user_id <>' => '',
    //   //     'Desarrollo.id'      => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa'      => 1
    //   //   );
    //   //   $conditions_e2 = array(
    //   //     'Cliente.status'        => array('Activo'),
    //   //     'Cliente.user_id <>'    => '',
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa' => 2
    //   //   );
    //   //   $conditions_e3 = array(
    //   //     'Cliente.status'        => array('Activo'),
    //   //     'Cliente.user_id <>'    => '',
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa' => 3
    //   //   );
    //   //   $conditions_e4 = array(
    //   //     'Cliente.status'        => array('Activo'),
    //   //     'Cliente.user_id <>'    => '',
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa' => 4
    //   //   );
    //   //   $conditions_e5 = array(
    //   //     'Cliente.status'        => array('Activo'),
    //   //     'Cliente.user_id <>'    => '',
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa' => 5
    //   //   );
    //   //   $conditions_e6 = array(
    //   //     'Cliente.status'        => array('Activo'),
    //   //     'Cliente.user_id <>'    => '',
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa' => 6
    //   //   );
    //   //   $conditions_e7 = array(
    //   //     'Cliente.status'        => array('Activo'),
    //   //     'Cliente.user_id <>'    => '',
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos'),
    //   //     'Cliente.etapa' => 7
    //   //   );

    //   //   $condicion_desarrollos = array(
    //   //     'Desarrollo.id'         => $this->Session->read('Desarrollos')
    //   //   );

    //   // break;


    //   case(6):
    //     $conditions_e1 = array(
    //       'AND'=>array(
    //           'Cliente.status' => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa' => 1
    //           ),
    //     );
    //     $conditions_e2 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa'=>2
    //           ),
    //     );
    //     $conditions_e3 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa'=>3
    //           ),
    //     );
    //     $conditions_e4 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa'=>4
    //           ),
    //     );
    //     $conditions_e5 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa'=>5
    //           ),
    //     );
    //     $conditions_e6 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa'=>6
    //           ),
    //     );
    //     $conditions_e7 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
    //           'Cliente.etapa'=>7
    //           ),
    //     );
    //   break;
    //   default:
    //     $conditions_e1 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.etapa'=>1
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );
    //     $conditions_e2 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.etapa'=>2
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );
    //     $conditions_e3 = array(
    //       'AND'=>array(
    //           'Cliente.status' => array('Activo'),
    //           'Cliente.etapa'  => 3
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );
    //     $conditions_e4 = array(
    //       'AND'=>array(
    //           'Cliente.status' => array('Activo'),
    //           'Cliente.etapa'  => 4
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );
    //     $conditions_e5 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.etapa'=>5
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );
    //     $conditions_e6 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.etapa'=>6
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );
    //     $conditions_e7 = array(
    //       'AND'=>array(
    //           'Cliente.status'        => array('Activo'),
    //           'Cliente.etapa'=>7
    //           ),
    //       'OR'=>array(
    //           'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
    //           'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
    //       )
    //     );

    //     $condicion_desarrollos = array(
    //       'OR' => array(
    //         'Desarrollo.comercializador_id' => $user['Rol'][0]['cuenta_id'],
    //         'Desarrollo.cuenta_id'          => $user['Rol'][0]['cuenta_id'],
    //       ), 
    //       'AND' => array(
    //         'Desarrollo.is_private' => 0
    //       )
    //     );

    //   break;
    // endswitch;

    // $cuenta_id = 178;
    $cuenta_id = $cuenta['Cuenta']['id'];
    
    $conditions_e1 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 1,
          'Cliente.user_id' => $data['user_id']
      ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$cuenta_id,
      )
    );

    $conditions_e2 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 2,
          'Cliente.user_id' => $data['user_id']
          ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$cuenta_id,
      )
    );

    $conditions_e3 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 3,
          'Cliente.user_id' => $data['user_id']
          ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$cuenta_id,
      )
    );

    $conditions_e4 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 4,
          'Cliente.user_id' => $data['user_id']
          ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$cuenta_id,
      )
    );

    $conditions_e5 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 5,
          'Cliente.user_id' => $data['user_id']
          ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$cuenta_id,
      )
    );

    $conditions_e6 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 6,
          'Cliente.user_id' => $data['user_id']
          ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$cuenta_id,
      )
    );

    $conditions_e7 = array(
      'AND'=>array(
          'Cliente.status'  => array('Activo'),
          'Cliente.etapa'   => 7,
          'Cliente.user_id' => $data['user_id']
          ),
      'OR'=>array(
          'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$cuenta_id.')',
          'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
      )
    );




    switch( $data['tipo_clientes'] ) {

      case( 1 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e1,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;
      case( 2 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e2,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;
      case( 3 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e3,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;
      case( 4 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e4,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;
      case( 5 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e5,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;
      case( 6 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e6,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;
      case( 7 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e7,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes));
      break;

    }

    $respuesta = array(
      'mensaje' => 'Estos son los resultados de su consulta',
      'datos'   => $clientes,
      'bandera' => true,
      'data'    => $data,
      'cuenta' => $cuenta_id
    );

    return $respuesta;
    $this->autoRender = false;

  }

  public function get_filtro_pipeline( $asesorId = null, $cuentaId = null, $desarrolloId = null, $nombreCliente = null, $idEtapa = null ) {
    $s = 0;
    $data = array(
      'asesor_id'      => $asesorId,
      'cuenta_id'      => $cuentaId,
      'desarrollo_id'  => $desarrolloId,
      'nombre_cliente' => $nombreCliente,
      'etapa_id'       => $idEtapa
    );
    
    // Con nombre del cliente.
    // $data = array(
    //   'asesor_id'      => "447",
    //   'cuenta_id'      => "1",
    //   'desarrollo_id'  => null,
    //   'etapa_id'       => "2",
    //   'nombre_cliente' => "Abigail",
    // );

    // Solo con el id del desarrollo
    // $data = array(
    //   'asesor_id'      => "447",
    //   'cuenta_id'      => "1",
    //   'desarrollo_id'  => "210",
    //   'etapa_id'       => "2",
    //   'nombre_cliente' => null
    // );

    // Con los dos
    // $data = array(
    //   'asesor_id'      => "447",
    //   'cuenta_id'      => "1",
    //   'desarrollo_id'  => "210",
    //   'etapa_id'       => "2",
    //   'nombre_cliente' => "5586786933"
    // );



    $clientes = $this->filtro_pipeline( $data );

    foreach( $clientes['datos'] as $cliente ) {

      $propiedad = $cliente['Inmueble']['titulo'];
      $propiedad .= ', '.$cliente['Desarrollo']['nombre'];


      if( !empty( $cliente['Lead'] ) ) {

        foreach( $cliente['Lead'] as $p_interes ) {
          
          if( !empty( $p_interes['Inmueble']['titulo'] ) ) {
            $propiedad = $p_interes['Inmueble']['titulo'];
            // echo $propiedad;
          }

          if( !empty( $p_interes['Desarrollo'] ) ) {
            $propiedad .= ', '.$p_interes['Desarrollo']['nombre'];
          }

        }

      }

      $clientes_new[$s] = array(
        'nombre_cliente' => $cliente['Cliente']['nombre'],
        'cliente_id'     => $cliente['Cliente']['id'],
        'last_edit'      => $cliente['Cliente']['last_edit'],
        'nombre_asesor'  => $cliente['User']['nombre_completo'],
        'asesor_id'      => $cliente['User']['id'],
        'propiedad'      => $propiedad,
      );

      $s++;
      
    }

    // print_r( $data );
    echo json_encode( $clientes_new, true );
    $this->autoRender = false;

  }

  public function filtro_pipeline( $data = null ) {
    $this->Cliente->Behaviors->load('Containable');
    
    $clientes = [];
    $conditions_and_e1 = [];
    $conditions_and_e2 = [];
    $conditions_and_e3 = [];
    $conditions_and_e4 = [];
    $conditions_and_e5 = [];
    $conditions_and_e6 = [];
    $conditions_and_e7 = [];
    
    $conditions_or_e1 = [];
    $conditions_or_e2 = [];
    $conditions_or_e3 = [];
    $conditions_or_e4 = [];
    $conditions_or_e5 = [];
    $conditions_or_e6 = [];
    $conditions_or_e7 = [];

    $contain_cliente = array(
      'User'=>array(
        'fields'=>array(
          'nombre_completo'
        )
      ),
      'Inmueble'=>array(
        'fields'=>array(
          'titulo'
        )
      ),
      'Desarrollo'=>array(
        'fields'=>array(
          'nombre'
        ),
      ),
      'Lead'=>array(
        'conditions'=>array(
          'Lead.status'=>'Aprobado'
        ),
        'Desarrollo'=>array(
          'fields'=>'nombre'
        ),
        'Inmueble'=>array(
          'fields'=>'titulo'
        ),
      ),
    );

    $fields_clientes = array(
      'id',
      'nombre',
      'last_edit',
      'telefono1',
      'correo_electronico',
    );


      $conditions_and_e1 = array('Cliente.status'        => array('Activo'),);
      $conditions_and_e2 = array('Cliente.status'        => array('Activo'),);
      $conditions_and_e3 = array('Cliente.status'        => array('Activo'),);
      $conditions_and_e4 = array('Cliente.status'        => array('Activo'),);
      $conditions_and_e5 = array('Cliente.status'        => array('Activo'),);
      $conditions_and_e6 = array('Cliente.status'        => array('Activo'),);
      $conditions_and_e7 = array('Cliente.status'        => array('Activo'),);


      if ( $data['asesor_id'] != "" ){

        array_push($conditions_and_e1,['Cliente.user_id'=>$data['asesor_id']]);
        array_push($conditions_and_e2,['Cliente.user_id'=>$data['asesor_id']]);
        array_push($conditions_and_e3,['Cliente.user_id'=>$data['asesor_id']]);
        array_push($conditions_and_e4,['Cliente.user_id'=>$data['asesor_id']]);
        array_push($conditions_and_e5,['Cliente.user_id'=>$data['asesor_id']]);
        array_push($conditions_and_e6,['Cliente.user_id'=>$data['asesor_id']]);
        array_push($conditions_and_e7,['Cliente.user_id'=>$data['asesor_id']]);

      }else {
        
        array_push($conditions_and_e1,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e2,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e3,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e4,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e5,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e6,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e7,['Cliente.cuenta_id' => $data['cuenta_id']]);

      }


      if ( $data['desarrollo_id'] != "" OR isset( $data['desarrollo_id'] ) ){

        array_push($conditions_or_e1,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);
        array_push($conditions_or_e2,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);
        array_push($conditions_or_e3,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);
        array_push($conditions_or_e4,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);
        array_push($conditions_or_e5,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);
        array_push($conditions_or_e6,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);
        array_push($conditions_or_e7,['Cliente.desarrollo_id'=>$data['desarrollo_id']]);

      }else {

        // if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5) {
          
          // array_push($conditions_e1,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
          // array_push($conditions_e2,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
          // array_push($conditions_e3,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
          // array_push($conditions_e4,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
          // array_push($conditions_e5,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
          // array_push($conditions_e6,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
          // array_push($conditions_e7,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);

        // }else {

          array_push($conditions_and_e1,['Cliente.cuenta_id' => $data['cuenta_id']]);
          array_push($conditions_and_e2,['Cliente.cuenta_id' => $data['cuenta_id']]);
          array_push($conditions_and_e3,['Cliente.cuenta_id' => $data['cuenta_id']]);
          array_push($conditions_and_e4,['Cliente.cuenta_id' => $data['cuenta_id']]);
          array_push($conditions_and_e5,['Cliente.cuenta_id' => $data['cuenta_id']]);
          array_push($conditions_and_e6,['Cliente.cuenta_id' => $data['cuenta_id']]);
          array_push($conditions_and_e7,['Cliente.cuenta_id' => $data['cuenta_id']]);

        // }


      }


      if ( $data['nombre_cliente'] != "" OR isset( $data['nombre_cliente'] ) ){

        array_push($conditions_or_e1,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e2,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e3,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e4,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e5,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e6,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e7,['Cliente.nombre LIKE "%'.$data['nombre_cliente'].'%"']);

        array_push($conditions_or_e1,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e2,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e3,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e4,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e5,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e6,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e7,['Cliente.telefono1 LIKE "%'.$data['nombre_cliente'].'%"']);

        array_push($conditions_or_e1,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e2,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e3,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e4,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e5,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e6,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);
        array_push($conditions_or_e7,['Cliente.correo_electronico LIKE "%'.$data['nombre_cliente'].'%"']);

      }else {

        array_push($conditions_and_e1,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e2,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e3,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e4,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e5,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e6,['Cliente.cuenta_id' => $data['cuenta_id']]);
        array_push($conditions_and_e7,['Cliente.cuenta_id' => $data['cuenta_id']]);

      }

      array_push($conditions_and_e1,['Cliente.etapa'=>1]);
      array_push($conditions_and_e2,['Cliente.etapa'=>2]);
      array_push($conditions_and_e3,['Cliente.etapa'=>3]);
      array_push($conditions_and_e4,['Cliente.etapa'=>4]);
      array_push($conditions_and_e5,['Cliente.etapa'=>5]);
      array_push($conditions_and_e6,['Cliente.etapa'=>6]);
      array_push($conditions_and_e7,['Cliente.etapa'=>7]);


      switch( $data['etapa_id'] ){

        case( 1 ):
          $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e1, 'OR' => $conditions_or_e1),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;
        case( 2 ):
          $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e2, 'OR' => $conditions_or_e2),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;
        case( 3 ):
          $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e3, 'OR' => $conditions_or_e3),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;
        case( 4 ):
          $clientes= $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e4, 'OR' => $conditions_or_e4),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;
        case( 5 ):
          $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e5, 'OR' => $conditions_or_e5),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;
        case( 6 ):
          $clients = $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e6, 'OR' => $conditions_or_e6),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;
        case( 7 ):
          $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => array('AND' => $conditions_and_e7, 'OR' => $conditions_or_e7),'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,));
        break;

      }



    $respuesta = array(
      'mensaje' => 'Estos son los resultados de su consulta',
      'datos'   => $clientes,
      'bandera' => true
    );

    // print_r( $clientes );
    return $respuesta;
    $this->autoRender = false;



  }
  
  public function getLeadsFacebook(){
    // $connection = curl_init();
    // curl_setopt($connection, CURLOPT_URL, "http://localhost:5000/getleads/0");
    // curl_setopt($connection, CURLOPT_HEADER, 0);
	  // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    // $contenido = curl_exec($connection);
	  // curl_close($connection);

    $this->Desarrollo->Behaviors->load('Containable');
    $desarrollos = $this->Desarrollo->find(
      'all',
      array(
        'fields'=>array(
          'id','cuenta_id'
        ),
        'contain'=>false
      )
    );

    $arreglo_cuentas = array();
    foreach($desarrollos as $desarrollo):
      $arreglo_cuentas[$desarrollo['Desarrollo']['id']] = $desarrollo['Desarrollo']['cuenta_id'];
    endforeach;

    //$this->set('arreglo_desarrollos',$arreglo_cuentas);

    $HttpSocket = new HttpSocket();
    $response = $HttpSocket->get('http://localhost:5000/getleads/0');
    $respuesta =json_decode($response,true);
    $this->set('respuesta',$respuesta);
    foreach($respuesta as $forma): //Recorre todas las formas de Facebook del usuario
        foreach($forma['leads']['data'] as $lead): //Recorre cada lead de cada forma
          $carga = false;
          $cliente = array();
          foreach ($lead['field_data'] as $campo):
            if ($campo['name']=='adryo_desarrollo_id'){
              $cliente['cuenta_id'] = $arreglo_cuentas[$campo['values'][0]];
              $cliente['desarrollo_id'] = $campo['values'][0];
              $carga = true;
            }
            if ($campo['name'] == 'full_name' || $campo['name'] == 'nombre_y_apellidos' || $campo['name'] == 'nombre_completo' || $campo['name'] == 'nombre_cliente'){
              $cliente['nombre_cliente'] = $campo['values'][0];
            }
            if ($campo['name'] == 'email' || $campo['name'] == 'correo_electrónico'  || $campo['name'] == 'correo_cliente'){
              $cliente['email'] = $campo['values'][0];
            }
            if ($campo['name'] == 'número_de_teléfono' || $campo['name'] == 'numero_de_teléfono' || $campo['name'] == 'phone_number' || $campo['name'] == 'numero de teléfono' || $campo['name'] == 'telefono_cliente'){
              $cliente['telefono'] = $campo['values'][0];
            }
          endforeach;


            if ($carga){
              $params_cliente = array( //Cargamos Datos
                'nombre'              => $cliente['nombre_cliente'],
                'correo_electronico'  => $cliente['email'],
                'telefono1'           => substr($cliente['telefono'],-10),
                'telefono2'           => '',
                'telefono3'           => '',
                'tipo_cliente'        => 1,
                'propiedades_interes' => 'D'.$cliente['desarrollo_id'],
                'forma_contacto'      => 43,
                'comentario'          => '',
                'asesor_id'           => '',
              );
  
              $params_user = array(
                'user_id'              => 1,
                'cuenta_id'            => $cliente['cuenta_id'],
                'notificacion_1er_seg' => $this->Session->read('Parametros.Paramconfig.not_1er_seg_clientes'),
              );
  
              $this->add_cliente( $params_cliente, $params_user );
  
              // echo var_dump($params_cliente);
              // echo var_dump($params_user);
            }
        endforeach;
    endforeach;
    return null;
    $this->autoRender = false; 
  }

  function validate_user() {
    $this->Cliente->Behaviors->load('Containable');

    $flag    = false;
    $cliente = [];

    if( $this->request->data['email_search'] != '' AND  $this->request->data['telefono_search'] != ''){
      
      $conditions_cliente = array( 
        'and' => array(
          'Cliente.cuenta_id'          => $this->request->data['cuenta_id'],
        ),
        'or' => array(
          'Cliente.telefono1'          => $this->request->data['telefono_search'],
          'Cliente.correo_electronico' => $this->request->data['email_search'],
        ) 
      );

      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'correo_electronico' => $this->request->data['email_search'],
        'telefono1'          => $this->request->data['telefono_search']
      );

    }elseif( $this->request->data['email_search'] != '' ){
      
      $conditions_cliente = array(
        'Cliente.correo_electronico' => $this->request->data['email_search'],
        'Cliente.cuenta_id'          => $this->request->data['cuenta_id']
      );
      
      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'correo_electronico' => $this->request->data['email_search'],
        'telefono1' => 'Sin teléfono'
      );

    }else{
      
      $conditions_cliente = array(
        'Cliente.telefono1' => $this->request->data['telefono_search'],
        'Cliente.cuenta_id' => $this->request->data['cuenta_id']
      );

      // Seteo de variables para guardarlos en la bd
      $data_3_cliente = array(
        'telefono1'          => $this->request->data['telefono_search'],
        'correo_electronico' => 'Sin correo'
      );

    }
    
    $cliente = $this->Cliente->find('first', array(
      'conditions' => $conditions_cliente,
      'fields'     => array(
        'Cliente.id',
        'Cliente.nombre',
        'Cliente.correo_electronico',
        'Cliente.telefono1',
        'Cliente.comentarios',
        'Cliente.dic_linea_contacto_id',
        'Cliente.user_id',
        'Cliente.inmueble_id',
        'Cliente.desarrollo_id',
        'Cliente.status',
      ),
      'contain' => array(
        'User' => array(
          'fields' => 'User.nombre_completo'
        ),
        'Inmueble' => array(
          'fields' => 'titulo'
        ),
        'Desarrollo' => array(
          'fields' => 'nombre'
        ),
        'DicLineaContacto' => array(
          'fields' => 'linea_contacto'
        )
      )
    ));

    if( !empty($cliente) ){
      $flag = true;
    }

    $response = array(
      $cliente,
      'flag' => $flag,
      'respuesta' => 'Hola como estas, desde controlador'
    );

    echo json_encode($response);
    $this->autoRender = false;
  }

  /* ------------------ Listado de desarrollos y propiedades ------------------ */
	public function list_des_pro( $group_id = null, $cuenta_id = null ) {
		$list_inmuebles   = [];
		$list_desarrollos = [];

		switch( $group_id ){
			case 5: // Opción para desarrollador

				$list_desarrollos = $this->Desarrollo->find('list', array(
					'conditions'=>array(
						'Desarrollo.id' => $this->Session->read('Desarrollos')
					)
				));

				break;
			case 3: // Opcion para Asesores

				$list_desarrollos = $this->Desarrollo->find('list', array(
                    'conditions' => array(
						'OR' 	 => array(
							'Desarrollo.comercializador_id' => $cuenta_id,
							'Desarrollo.cuenta_id'          => $cuenta_id,
						), 
						'AND' 	 => array(
							'Desarrollo.is_private' => 0
						)
					),
					'order' => array('Desarrollo.nombre ASC')
				));

				$list_inmuebles = $this->Inmueble->find('list', array(
					'conditions' => array(
					'Inmueble.cuenta_id' 	=> $cuenta_id,
					'Inmueble.liberada' 	=> 1,
					'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
					),
					'order' 				=> 'Inmueble.titulo ASC'
				));
				
				break;
			default: // Opción para Gerentes y superAdmins
				$list_desarrollos = $this->Desarrollo->find('list', array(
					'conditions' => array(
					'OR' 		 => array(
						'Desarrollo.comercializador_id' => $cuenta_id,
						'Desarrollo.cuenta_id'          => $cuenta_id,
					), 
					'AND' 		 => array(
						'Desarrollo.is_private'=>0
						)

					),
					'order' => 'Desarrollo.nombre ASC'
				));

				$list_inmuebles = $this->Inmueble->find('list', array(
					'conditions' => array(
					'Inmueble.cuenta_id' => $cuenta_id,
					'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
					),
					'order' => 'Inmueble.titulo ASC'
				));

				break;
		}

		$propiedades = array(
			'list_inmuebles'   => $list_inmuebles,
			'list_desarrollos' => $list_desarrollos
		);
		return $propiedades;
	}

  public function listado_clientes( $data = null ) {
    $this->loadModel('LogClientesEtapa');
    $this->layout = 'blank';
    $this->Cliente->Behaviors->load('Containable');
    $or  = [];
    $and = [];

    // $data = array(
    //   'Cliente' => array(
    //     // 'asesor'             => "447",
    //     // 'correo_electronico' => "saak.hg.pv@gmail.com",
    //     // 'desarrollo_id'      => "68",
    //     // 'estatus_cliente'    => "Activo",
    //     // 'etapa_cliente'      => "4",
    //     // 'forma_contacto'     => "43",
    //     // 'inmueble_id'        => "3345",
    //     // 'nombre'             => "Alejandro Hernandez",
    //     // 'status_atencion'    => "0",
    //     // 'telefono'           => "5586786933",
    //     // 'tipos_clientes'     => "1"
    //   ),
    //   'date_created' => "04/01/2021 - 04/30/2021",
    //   // 'date_last_edit' => "01/01/2021 - 02/23/2021"

    // );
    // $this->request->data = $data;


    if( !empty( $data ) ){

      /* ------------------------------ Validaciones ------------------------------ */
      // Desarrollador.
      // Asesor.
      // Gerente.
      // SuperAdmin.

      if($this->Session->read('Permisos.Group.call') == 1){
        array_push($and,
          array(
            'Cliente.user_id <>' => ''
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      }elseif($this->Session->read('Permisos.Group.cown') == 1){
        array_push($and,
          array(
            'Cliente.user_id' => $this->Session->read('Auth.User.id')
          )
        );
      }


      // En caso de estar limpios los filtros.
      if( !empty($data['Cliente']['nombre']) ){ array_push($and, array('Cliente.nombre LIKE "%'.$data['Cliente']['nombre'].'%"')); }
      if( !empty($data['Cliente']['correo_electronico']) ){ array_push($and, array('Cliente.correo_electronico' => $data['Cliente']['correo_electronico'])); }
      if( !empty($data['Cliente']['telefono']) ){ array_push($and, array('Cliente.telefono1' => $data['Cliente']['telefono'])); }
      if( !empty($data['Cliente']['estatus_cliente']) ){ 
        array_push($and, array('Cliente.status' => $data['Cliente']['estatus_cliente'] )); 
      }
      else{
        array_push($and, array('Cliente.status' => array('Activo', 'Inactivo temporal')));
      }
      if( !empty($data['Cliente']['tipos_clientes']) ){ array_push($and, array('Cliente.dic_tipo_cliente_id' => $data['Cliente']['tipos_clientes'] )); }
      if( !empty($data['Cliente']['etapa_cliente']) ){ array_push($and, array('Cliente.etapa' => $data['Cliente']['etapa_cliente'] )); }
      if( !empty($data['Cliente']['forma_contacto']) ){ array_push($and, array('Cliente.dic_linea_contacto_id' => $data['Cliente']['forma_contacto'] )); }
      if( !empty($data['Cliente']['asesor']) ){ array_push($and, array('Cliente.user_id' => $data['Cliente']['asesor'] )); }
      if( !empty($data['Cliente']['inmueble_id']) ){ array_push($and, array('Cliente.inmueble_id' => $data['Cliente']['inmueble_id'] )); }
      if( !empty($data['Cliente']['desarrollo_id']) ){ array_push($and, array('Cliente.desarrollo_id' => $data['Cliente']['desarrollo_id'] )); }

      if( !empty($data['Cliente']['status_atencion']) ){
        switch($data['Cliente']['status_atencion']){
          case 0: // Oportuna
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
          break;
          case 1: //Tardía
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY)","last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
          break;
          case 2: //No Atendidos
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY)","Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY)");
          break;
          case 3://Por Reasignar
            $cond_atencion = array("Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY)");
          break;
          default:
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
          break;
        }
        array_push($and, $cond_atencion);
      }

      if( !empty($this->request->data['date_created']) ){
        $fecha_ini = substr($this->request->data['date_created'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['date_created'], -10).' 23:59:59';
        $fi = date('Y-m-d H:m:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:m:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }

      if( !empty($this->request->data['date_last_edit']) ){
        $fecha_ini = substr($this->request->data['date_last_edit'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['date_last_edit'], -10).' 23:59:59';
        $fi = date('Y-m-d',  strtotime($fecha_ini));
        $ff = date('Y-m-d',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.last_edit LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.last_edit BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }
      if (!empty($this->request->data['date_etapa']) ) {
        $fecha_ini = substr($this->request->data['date_etapa'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['date_etapa'], -10).' 23:59:59';
        $fi = date('Y-m-d',  strtotime($fecha_ini));
        $ff = date('Y-m-d',  strtotime($fecha_fin));
        if ($fi == $ff){
          //rogue
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }


      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );

    }else {

      if($this->Session->read('Permisos.Group.call') == 1){
        
        array_push($and,
          array(
            'Cliente.status'  => array('Activo', 'Inactivo temporal'),
            'Cliente.user_id <>' => ''
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );

      }elseif($this->Session->read('Permisos.Group.cown') == 1){
        array_push($and,
          array(
            'Cliente.status'  => array('Activo', 'Inactivo temporal'),
            'Cliente.user_id' => $this->Session->read('Auth.User.id')
          )
        );
      }

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );

    }

    $clientes = $this->Cliente->find('all',
      array(
          'conditions' => $condiciones,
          'contain' => array(
            'User'             => array('fields' => array('id', 'nombre_completo') ),
            'DicLineaContacto' => array('fields' => array('linea_contacto')),
            'Inmueble'         => array('fields' => array('titulo')),
            'Desarrollo'       => array('fields' => array('nombre')),
          ),
          'fields'    => array(
            'Cliente.id',
            'Cliente.etapa',
            'Cliente.last_edit',
            'Cliente.nombre',
            'Cliente.created',
            'Cliente.status',
            'Cliente.last_edit',
            'Cliente.correo_electronico',
            'Cliente.telefono1',
          
          ),
          'order' => 'Cliente.created DESC',

      )
    );
    
    return $clientes;
    $this->autoRender = false;
    // $this->set(compact('clientes'));
  }

  public function listado_clientes_json(){
    header("Content-Type: application/json; charset=utf-8");

    $clientes_json = [];
    $count         = 0;
    $limpieza      = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "�");

    $date_current      = date('Y-m-d');
    $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

    if( $this->request->is('post') ){
    
      $clientes = $this->listado_clientes( $this->request->data );

    }else {

      $clientes = $this->listado_clientes();

    }


    // foreach( $clientes as $cliente ) {

    //   if( $cliente['Cliente']['etapa'] == 1 ){ $c_etapa = 'estado1'; }
    //   elseif( $cliente['Cliente']['etapa'] == 2 ){ $c_etapa = 'estado2'; }
    //   elseif( $cliente['Cliente']['etapa'] == 3 ){ $c_etapa = 'estado3'; }
    //   elseif( $cliente['Cliente']['etapa'] == 4 ){ $c_etapa = 'estado4'; }
    //   elseif( $cliente['Cliente']['etapa'] == 5 ){ $c_etapa = 'estado5'; }
    //   elseif( $cliente['Cliente']['etapa'] == 6 ){ $c_etapa = 'estado6'; }
    //   elseif( $cliente['Cliente']['etapa'] == 7 ){ $c_etapa = 'estado7'; }
    //   else{$c_etapa = 'estado1'; }


    //   if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
    //   elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
    //   elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
    //   elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
    //   else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}


    //   if( $cliente['Cliente']['status'] == 'Activo' ){
    //     $cliente['Cliente']['status'] = 'A';
    //     $cliente['Cliente']['status_color'] = 'bgClienteA';
    //   }elseif( $cliente['Cliente']['status'] == 'Inactivo' ){
    //     $cliente['Cliente']['status'] = 'ID';
    //     $cliente['Cliente']['status_color'] = 'bgClienteID';
    //   }else {
    //     $cliente['Cliente']['status'] = 'IT';
    //     $cliente['Cliente']['status_color'] = 'bgClienteIT';
    //   }

    //   $clientes_json[$count] = array(
    //     "<small class='chip ".$cliente['Cliente']['status_color']."'>".$cliente['Cliente']['status']."<small>",
    //     "<small class='chip ".$c_etapa."'>".$cliente['Cliente']['etapa']."<small>",
    //     "<small class='chip ".$class_at."'>".$at."<small>",
    //     $cliente['Cliente']['id'],
    //     "<a href='".Router::url('/clientes/view/'.$cliente['Cliente']['id'], true)."' target='Blank' class='underline'>".rtrim(str_replace( $limpieza, "", $cliente['Cliente']['nombre']))."</a>",
    //     rtrim(str_replace( $limpieza, "", $cliente['Inmueble']['titulo'])).' '.rtrim(str_replace( $limpieza, "", $cliente['Desarrollo']['nombre'])),
    //     rtrim(str_replace($limpieza, "", $cliente['DicLineaContacto']['linea_contacto'])),

    //     rtrim(str_replace($limpieza, "", $cliente['Cliente']['correo_electronico'])),
    //     rtrim(str_replace($limpieza, "", substr($cliente['Cliente']['telefono1'], -10))),

    //     date('Y-m-d', strtotime($cliente['Cliente']['created'])),
    //     date('Y-m-d', strtotime($cliente['Cliente']['last_edit'])),
    //     "<a href='".Router::url('/users/view/'.$cliente['User']['id'], true)."' target='Blank' class='underline'>".rtrim(str_replace( $limpieza, "", $cliente['User']['nombre_completo']))."</a>",
    //     "<i class='fa fa-eye pointer' onclick=modal_comentario(".$cliente['Cliente']['id'].")></i>",
    //   );

    //   if( $this->Session->read('Permisos.Group.ce') == 1 ){
    //     array_push( $clientes_json[$count], "<a href='".Router::url('/clientes/edit/'.$cliente['Cliente']['id'], true)."' target='Blank'><i class='fa fa-edit'></i> </a>");
    //   }

    //   if( $this->Session->read('Permisos.Group.cd') == 1 ){
    //     array_push( $clientes_json[$count], "<i class='fa fa-trash pointer' onclick=ClienteDelete(".$cliente['Cliente']['id'].")></i>");
    //   }


    //   $count++;

    // }
    foreach( $clientes as $cliente ) {

      if( $cliente['Cliente']['etapa'] == 1 ){ $c_etapa = 'estado1'; }
      elseif( $cliente['Cliente']['etapa'] == 2 ){ $c_etapa = 'estado2'; }
      elseif( $cliente['Cliente']['etapa'] == 3 ){ $c_etapa = 'estado3'; }
      elseif( $cliente['Cliente']['etapa'] == 4 ){ $c_etapa = 'estado4'; }
      elseif( $cliente['Cliente']['etapa'] == 5 ){ $c_etapa = 'estado5'; }
      elseif( $cliente['Cliente']['etapa'] == 6 ){ $c_etapa = 'estado6'; }
      elseif( $cliente['Cliente']['etapa'] == 7 ){ $c_etapa = 'estado7'; }
      else{$c_etapa = 'estado1'; }


      if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
      elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
      elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
      elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
      else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}


      if( $cliente['Cliente']['status'] == 'Activo' ){
        $cliente['Cliente']['status'] = 'A';
        $cliente['Cliente']['status_color'] = 'bgClienteA';
      }elseif( $cliente['Cliente']['status'] == 'Inactivo' ){
        $cliente['Cliente']['status'] = 'ID';
        $cliente['Cliente']['status_color'] = 'bgClienteID';
      }else {
        $cliente['Cliente']['status'] = 'IT';
        $cliente['Cliente']['status_color'] = 'bgClienteIT';
      }
      
      $clientes_json[$count] = array(
        "<small class='chip ".$cliente['Cliente']['status_color']."'>".$cliente['Cliente']['status']."<small>",
        "<small class='chip ".$c_etapa."'>".$cliente['Cliente']['etapa']."<small>",
        "<small class='chip ".$class_at."'>".$at."<small>",
        $cliente['Cliente']['id'],
        "<a href='".Router::url('/clientes/view/'.$cliente['Cliente']['id'], true)."' target='Blank' class='underline'>".mb_strtoupper(str_replace( $limpieza, "", $cliente['Cliente']['nombre']))."</a>",
        mb_strtoupper(str_replace( $limpieza, "", $cliente['Inmueble']['titulo'])).' '.mb_strtoupper(str_replace( $limpieza, "", $cliente['Desarrollo']['nombre'])),
        rtrim(str_replace($limpieza, "", $cliente['DicLineaContacto']['linea_contacto'])),

        rtrim(str_replace($limpieza, "", $cliente['Cliente']['correo_electronico'])),
        mb_strtoupper(str_replace($limpieza, "", substr($cliente['Cliente']['telefono1'], -10))),

        date('Y-m-d', strtotime($cliente['Cliente']['created'])),
        date('Y-m-d', strtotime($cliente['Cliente']['last_edit'])),
        "<a href='".Router::url('/users/view/'.$cliente['User']['id'], true)."' target='Blank' class='underline'>".rtrim(str_replace( $limpieza, "", $cliente['User']['nombre_completo']))."</a>",
        "<i class='fa fa-eye pointer' onclick=modal_comentario(".$cliente['Cliente']['id'].")></i>",
      );

      if( $this->Session->read('Permisos.Group.ce') == 1 ){
        array_push( $clientes_json[$count], "<a href='".Router::url('/clientes/edit/'.$cliente['Cliente']['id'], true)."' target='Blank'><i class='fa fa-edit'></i> </a>");
      }

      if( $this->Session->read('Permisos.Group.cd') == 1 ){
        array_push( $clientes_json[$count], "<i class='fa fa-trash pointer' onclick=ClienteDelete(".$cliente['Cliente']['id'].")></i>");
      }


      $count++;

    }

    
    $json = json_encode( $clientes_json, true );
    if ($json){
      echo $json;
    }else{
      echo json_last_error_msg();
    }
    exit();

    $this->autoRender = false;

  }

  /* ------------------------ PopUp detalle de clientes ----------------------- */
  public function detalle_comentario( $cliente_id = null ) {
    header('Content-type: application/json charset=utf-8');

    $this->Cliente->Behaviors->load('Containable');

    $cliente = $this->Cliente->find('first', 
      array(
        'conditions' => array('Cliente.id' => $cliente_id ),
        'fields' => array('Cliente.comentarios', 'Cliente.telefono1', 'Cliente.correo_electronico', 'Cliente.last_edit', 'Cliente.status'),
        'contain' => array('Top5')
      )
    );

    $comentarios = '<ol class="list-number">';
    foreach( $cliente['Top5'] as $seguimiento ) {
      $comentarios .= '<li>'.$seguimiento['mensaje'].'</li>';
    }
    $comentarios .= '</ol>';

    $response['comentario_completo']  = ( $cliente['Cliente']['comentarios'] != '' ? $cliente['Cliente']['comentarios'] : '"Sin comentario"' );
    $response['ultimos_seguimientos'] = $comentarios;
    $response['telefono']             = $cliente['Cliente']['telefono1'];
    $response['correo']               = $cliente['Cliente']['correo_electronico'];
    $response['last_edit']            = date('Y-m-d', strtotime($cliente['Cliente']['last_edit']));
    $response['status']               = $cliente['Cliente']['status'];
    $response['bandera']              = true;
      
    echo json_encode( $response );
    exit();

    $this->autoRender = false;
  }

  /* ----------------------- Data Prospection of client ----------------------- */
  function data_prospection_client ( ) {
    header('Content-type: application/json charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');

    $cliente = $this->Cliente->find('first', array(
      'conditions' => array('id' => $this->request->data['Cliente']['cliente_id']),
      'fields'     => array(
        'Cliente.id',
        'Cliente.etapa',
        'Cliente.operacion_prospeccion',
        'Cliente.tipo_propiedad_prospeccion',
        'Cliente.metros_min_prospeccion',
        'Cliente.metros_max_prospeccion',
        'Cliente.precio_min_prospeccion',
        'Cliente.precio_max_prospeccion',
        'Cliente.forma_pago_prospeccion',
        'Cliente.hab_prospeccion',
        'Cliente.banios_prospeccion',
        'Cliente.estacionamientos_prospeccion',
        'Cliente.amenidades_prospeccion',
        'Cliente.nivel_interes_prospeccion',
        'Cliente.estado_prospeccion',
        'Cliente.ciudad_prospeccion',
        'Cliente.colonia_prospeccion',
        'Cliente.zona_prospeccion',
        'Cliente.comentarios',
      ),
      'contain'    => false
    ));

    $response = array(
      'data'    => $cliente,
      'mensaje' => 'Metodo de validacion desde ClientesController'
    );

    echo json_encode( $response );
    exit();

    $this->autoRender = false;

  }

  /** COMIENZAN LAS FUNCIONES PARA APIS EXTERNAS */

  public function add_cliente_api() {
    $this->CuentasUser->Behaviors->load('Containable');
    $this->Cuenta->Behaviors->load('Containable');

    header('Content-type: application/json charset=utf-8');
    $respuesta = array();
    if ($this->request->is(array('post', 'put'))) {
        if ($this->request->data['token']==""){
            $respuesta['code']='200';
            $respuesta['mensaje']='Falta Información de TOKEN';
        }else{
          if ($this->request->data['nombre']=="" || $this->request->data['tipo_cliente']=="" || $this->request->data['desarrollo']=="" || $this->request->data['linea_contacto']==""){
            $respuesta['code']='201';
            $respuesta['mensaje']='Faltan datos mínimos para el alta de cliente (Nombre, Tipo de Cliente, Desarrollo y/o Línea de Contacto)';
          }else{
            $params_cliente = array(
              'nombre'              => $this->request->data['nombre'],
              'correo_electronico'  => $this->request->data['correo_electronico'],
              'telefono1'           => $this->request->data['telefono1'],
              'telefono2'           => $this->request->data['telefono2'],
              'telefono3'           => $this->request->data['telefono3'],
              'tipo_cliente'        => $this->request->data['tipo_cliente'],
              'propiedades_interes' => "D".$this->request->data['desarrollo'],
              'forma_contacto'      => $this->request->data['linea_contacto'],
              'comentario'          => '',
              'asesor_id'           => $this->request->data['asesor_id'],
            );
    
            $cuenta = $this->Cuenta->find(
              'first',
              array(
                'conditions'=>array(
                  'Cuenta.unique_id'=>$this->request->data['token']
                ),
                'fields'=>array(
                  'id','paramconfig_id'
                ),
                'contain'=>array(
                  'Parametros'=>array(
                    'fields'=>array(
                      'not_1er_seg_clientes','id'
                    )
                  )
                )
              )
            );

            if ($cuenta['Cuenta']['id']==NULL){
              $respuesta['code']='203';
              $respuesta['mensaje']='Error en Autenticación';
            }else{
              if ($this->request->data['asesor_id']==""){
                $user_central = $this->CuentasUser->find(
                  'first',
                  array(
                    'conditions'=>array(
                      'CuentasUser.cuenta_id'=>$cuenta['Cuenta']['id'],
                      'CuentasUser.group_id'=>1
                    ),
                    'fields'=>array(
                      'user_id'
                    ),
                    'contain'=>false
                  )
                );
              }else{
                $user_central['CuentasUser']['user_id']=$this->request->data['asesor_id'];
              }
      
              
          
              $params_user = array(
                'user_id'              => $user_central['CuentasUser']['user_id'],
                'cuenta_id'            => $cuenta['Cuenta']['id'],
                'notificacion_1er_seg' => $cuenta['Parametros']['not_1er_seg_clientes'],
              );
      
              $this->set('params_cliente',$params_cliente);
              $this->set('params_user',$params_user);
          
              $save_client = $this->add_cliente( $params_cliente, $params_user );
              $this->validar_linea_contacto($save_client['cliente_id'],$params_user['user_id'],$params_user['cuenta_id'],$this->request->data['linea_contacto'],$this->request->data['desarrollo']);
              
              if( $save_client['bandera'] == 1 ){
                $respuesta['code']='100';
                $respuesta['mensaje']=$save_client['respuesta'];
              }else{
                $respuesta['code']='202';
                $respuesta['mensaje']=$save_client['respuesta'];
              }
            }
          } 
        }
        echo json_encode($respuesta);
        exit();
    }
  }

  public function add_cliente_fb_api() {
    $this->layout='print';
    $this->CuentasUser->Behaviors->load('Containable');
    $this->Cuenta->Behaviors->load('Containable');
    $this->Desarrollo->Behaviors->load('Containable');

    $tipos_clientes = array(
      '1'=>1,
      '7'=>30,
      '178'=>691
    );

    $formas_contacto = array(
      '1'=>43,
      '7'=>152,
      '178'=>1706
    );
    

    header('Content-type: application/json charset=utf-8');
    $respuesta = array();
    if ($this->request->is(array('post', 'put'))) {
      if ($this->request->data['nombre']=="" || $this->request->data['desarrollo']==""){
        $respuesta['code']='201';
        $respuesta['mensaje']='Faltan datos mínimos para el alta de cliente (Nombre, Desarrollo)';
      }else{

        $cuenta_id = $this->Desarrollo->find(
          'first',
          array(
            'fields'=>array(
              'cuenta_id'
            ),
            'contain'=>false,
            'conditions'=>array(
              'Desarrollo.id'=>$this->request->data['desarrollo']
            )
          )
        );

        if (!empty($cuenta_id)){
          $params_cliente = array(
            'nombre'              => $this->request->data['nombre'],
            'correo_electronico'  => $this->request->data['correo_electronico'],
            'telefono1'           => $this->request->data['telefono1'],
            'telefono2'           => "",
            'telefono3'           => "",
            'tipo_cliente'        => $tipos_clientes[$cuenta_id['Desarrollo']['cuenta_id']],
            'propiedades_interes' => "D".$this->request->data['desarrollo'],
            'forma_contacto'      => $formas_contacto[$cuenta_id['Desarrollo']['cuenta_id']],
            'comentario'          => '',
            'asesor_id'           => "",
          );
  
          $cuenta = $this->Cuenta->find(
            'first',
            array(
              'conditions'=>array(
                'Cuenta.id'=>$cuenta_id['Desarrollo']['cuenta_id']
              ),
              'fields'=>array(
                'id','paramconfig_id'
              ),
              'contain'=>array(
                'Parametros'=>array(
                  'fields'=>array(
                    'not_1er_seg_clientes','id'
                  )
                )
              )
            )
          );
  
          if ($cuenta['Cuenta']['id']==NULL){
            $respuesta['code']='203';
            $respuesta['mensaje']='Error en Autenticación';
          }else{
            
            $user_central['CuentasUser']['user_id']=1;
            $params_user = array(
              'user_id'              => $user_central['CuentasUser']['user_id'],
              'cuenta_id'            => $cuenta['Cuenta']['id'],
              'notificacion_1er_seg' => $cuenta['Parametros']['not_1er_seg_clientes'],
            );
    
            $this->set('params_cliente',$params_cliente);
            $this->set('params_user',$params_user);
        
            $save_client = $this->add_cliente( $params_cliente, $params_user );
            $this->validar_linea_contacto($save_client['cliente_id'],$params_user['user_id'],$params_user['cuenta_id'],$formas_contacto[$cuenta_id['Desarrollo']['cuenta_id']],$this->request->data['desarrollo']);
            
            if( $save_client['bandera'] == 1 ){
              $respuesta['code']='100';
              $respuesta['mensaje']=$save_client['respuesta'];
            }else{
              $respuesta['code']='202';
              $respuesta['mensaje']=$save_client['respuesta'];
            }
          }
        }else{
          $respuesta['code']='204';
          $respuesta['mensaje']='No existe una cuenta relacionada';
        }
      } 
        echo json_encode($respuesta);
        exit();
    }
    $this->autoRender = false;
  }

  public function showFacebookLeads($days=null){
    //$this->layout = 'print';
    shell_exec(escapeshellcmd('python3.8 /var/www/html/app/webroot/scripts_python/fbtoken.py'));
  }

  /* -------- Esta funcion agrega en seguimiento rápido el envío de wa -------- */
  public function add_whatsapp(){
    
              $response  = [];
    $response['mensaje'] = 'Se ha guardado correctamente el seguimiento rápido';
    $response['bandera'] = true;

    $data = array(
      'mensaje'            => $this->request->data['mensaje'],
      'log_cliente_accion' => $this->request->data['accion'],
      'cliente_id'         => $this->request->data['cliente_id'],
      'user_id'            => $this->Session->read('Auth.User.id'),
    );
    
    $response_seguimiento = $this->add_seguimiento_rapido( $data );
    if( $response_seguimiento['bandera'] == false ){
      $response['mensaje'] = $response_seguimiento['mensaje'];
      $response['bandera'] = $response_seguimiento['bandera'];
    }


    // Si esta definido el id de la cotizacion marcar la cotizacion como enviada.
    if( !empty($this->request->data['cotizacion_id']) ){
      $cotizacion_id = $this->request->data['cotizacion_id'];
      $cotizacion = $this->Cotizacion->findFirstById($cotizacion_id);

      if( $cotizacion['Cotizacion']['status'] <= 1 ){
        $this->request->data['Cotizacion']['id']      = $cotizacion_id;
        $this->request->data['Cotizacion']['status'] = 2;
        $this->Cotizacion->save( $this->request->data );
      }

    }

    $this->Session->setFlash('', 'default', array(), 'success');
    $this->Session->setFlash($this->request->data['mensaje'], 'default', array(), 'm_success');

    echo json_encode( $response, true );

    $this->autoRender = false;

  }

  /* ---------- Esta funcion agrega en seguimiento rapido error de wa --------- */
  public function error_send_whatsapp(){

    $response  = [];
    $response['mensaje'] = 'Se ha guardado correctamente el seguimiento rápido';
    $response['bandera'] = true;

    $data = array(
      'mensaje'            => $this->request->data['mensaje'],
      'log_cliente_accion' => $this->request->data['accion'],
      'cliente_id'         => $this->request->data['cliente_id'],
      'user_id'            => $this->Session->read('Auth.User.id'),
    );
    
    $response_seguimiento = $this->add_seguimiento_rapido( $data );
    if( $response_seguimiento['bandera'] == false ){
      $response['mensaje'] = $response_seguimiento['mensaje'];
      $response['bandera'] = $response_seguimiento['bandera'];
    }

    $this->Session->setFlash('', 'default', array(), 'success');
    $this->Session->setFlash('Se ha guardado correctamente en seguimiento el motivo de error.', 'default', array(), 'm_success');

    echo json_encode( $response, true );

    $this->autoRender = false;

  }

  /* ----------------- Agregar seguimiento rapido del cliente ----------------- */
  /**
   * 
   * Esta funcion esta destinada pra guardar en seguimiento rapido de una forma 
   * sencilla. Guarda el tipo de accion, y el mensaje.
   * Adicional a eso impacta en los indicadores correspondientes en la vista del
   * cliente.
   * AKA SaaK
   * 
   */
  public function add_seguimiento_rapido( $data ){
              $response  = [];
    $response['mensaje'] = 'Se ha creado exitosamnte el seguimiento rapido';
    $response['bandera'] = true;
    
    $this->LogCliente->create();
    $this->request->data['LogCliente']['id']         =  uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $data['cliente_id'];
    $this->request->data['LogCliente']['user_id']    = $data['user_id'];
    $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
    $this->request->data['LogCliente']['accion']     = $data['log_cliente_accion'];
    $this->request->data['LogCliente']['mensaje']    = $data['mensaje'];
    if( !$this->LogCliente->save($this->request->data) ){
      $response['mensaje'] = 'Ocurrio un problema al guardar logCliente';
      $response['bandera'] = false;
    }


    //Registrar Seguimiento Rápido
    $this->Agenda->create();
    $this->request->data['Agenda']['user_id']    = $data['user_id'];
    $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
    $this->request->data['Agenda']['mensaje']    = $data['mensaje'];
    $this->request->data['Agenda']['cliente_id'] = $data['cliente_id'];
    if( !$this->Agenda->save($this->request->data) ){
      $response['mensaje']  .= ' <br> Ocurrio un problema al guardar Agenda';
      $response['bandera']   = false;
    }

    $this->Cliente->query("UPDATE clientes SET last_edit = '".date('Y-m-d H:i:s')."' WHERE id = ".$data['cliente_id']."");
    
    return $response;

  }


  /**
   * 
   * 
   * 10/05/2022 - AKA (rogueOne).
   * Este metodo trae los datos para la alimencacion de la grafica de etapas de clientes activos.
   * Filtrados por fecha, cuenta.
   * Los valores seteados son acorde a como los pide la grafica.
   * 
   */

  function get_fecha_reporte_inicial(){
    setlocale(LC_TIME, "spanish");
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');

    if ( $this->request->is(array('post', 'put')) ) {
        $rango                 = $this->request->data['rango_fechas'];

        $fecha_ini       = substr($rango, 0,10);
        $fecha_fin       = substr($rango, -10);
        $periodo_reporte = utf8_encode(strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_ini)))).' al '.strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_fin)))));

    }

    echo json_encode($periodo_reporte, true);
    exit();
    $this->autoRender = false;
  }

  function get_grafica_etapas_clientes(){
    setlocale(LC_TIME, "spanish");
    $this->DicEmbudoVenta->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');

    $etapa_cliente = array();
    $fecha_final   = date('Y-m-d');
    $fecha_inicio  = '2020-01-01';
    $cuenta_id     = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');    
    $data = $this->DicEmbudoVenta->find('all',array('conditions' => array('DicEmbudoVenta.cuenta_id' => $cuenta_id),'fields' => array( 'DicEmbudoVenta.nombre','DicEmbudoVenta.orden',),'contain' => false));
    $search = $this->Cliente->find('all', array( 'conditions' => array( 'Cliente.cuenta_id' => $cuenta_id, 'Cliente.created >=' => $fecha_inicio, 'Cliente.created <=' => $fecha_final, 'Cliente.status' => 'Activo' ), 'fields' => array( 'Cliente.etapa' ), 'group' => 'Cliente.etapa', 'contain' => false ) );
    
    $i      = 1;
    $etapa= array(1=>0, 2=>0, 3=>0, 4=>0,5=>0,6=>0,7=>0);      
    foreach($search as $value):
      if($value['Cliente']['etapa'] ==  $data[0]['DicEmbudoVenta']['orden']){
        $etapa[1]++;
      }
      if($value['Cliente']['etapa'] == $data[1]['DicEmbudoVenta']['orden']){
        $etapa[2]++;
      }
      if($value['Cliente']['etapa'] == $data[2]['DicEmbudoVenta']['orden']){
        $etapa[3]++;
      }
      if($value['Cliente']['etapa'] == $data[3]['DicEmbudoVenta']['orden']){
        $etapa[4]++;
      }
      if($value['Cliente']['etapa'] == $data[4]['DicEmbudoVenta']['orden']){
        $etapa[5]++;
      }
      if($value['Cliente']['etapa'] == $data[5]['DicEmbudoVenta']['orden']){
        $etapa[6]++;
      }
      if($value['Cliente']['etapa'] == $data[6]['DicEmbudoVenta']['orden']){
        $etapa[7]++;
      }
    endforeach;
    $e_c=array();
    foreach ($data as $value):
      $e_c[$i]['e'] = $value['DicEmbudoVenta']['nombre'];
      $e_c[$i]['c'] = $etapa[$i];
      $i++;
    endforeach;
    $in=0;
    $i=0;
    $etapa_cliente=array();
    foreach ($e_c as $value) {
      $in=$value;
      $etapa_cliente[$i]['etapa'] = $value['e'];
      $etapa_cliente[$i]['cantidad'] = $value['c'];
      $i++; 
    }
      echo json_encode($etapa_cliente, true);
      exit();
    $this->autoRender = false;
  }

  function get_visitas_linea_contacto_arregloR(){
    setlocale(LC_TIME, "spanish");
  
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    $fecha_inicio   = '2020-01-01';
    $fecha_final    = date('Y-m-d');
  
    if ( $this->request->is(array('post', 'put')) ) {
        $rango                 = $this->request->data['User']['rango_fechas'];;
        $fecha_ini             = substr($rango, 0,10).' 00: 00: 00';
        $fecha_fin             = substr($rango, -10).' 23 : 59: 59';
        $fi                    = date('Y-m-d',  strtotime($fecha_ini));
        $ff                    = date('Y-m-d',  strtotime($fecha_fin));
       $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");
  
        $visitas_linea_contacto_arreglo = array();
        $i=0;
        foreach($clientes_lineas as $linea):
            $visitas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
            $visitas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
            $visitas_linea_contacto_arreglo[$i]['visitas'] = 0;
            $visitas_linea_contacto_arreglo[$i]['inversion'] = 0;
            foreach($visitas_linea_contacto as $visita):
                if ($visita['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                    $visitas_linea_contacto_arreglo[$i]['visitas'] = $visita[0]['visitas'];
                }
            endforeach;
            foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                    $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                }
            endforeach;
            $i++;
        endforeach;
    }else{
  
        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
        $i=0;
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND publicidads.cuenta_id = $cuenta_id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto";
        $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);
  
        /************************************************* Se adiciona estan variables para el grafico de CONTACTOS POR MEDIO DE PROMOCIÓN VS VISITAS
         *  Las demas variables para el grafico se toman de la grafica anterior.
         *  ********************************************************************/
        $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fecha_inicio' AND  events.fecha_inicio <= '$fecha_final' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");
        $i=0;
        foreach($clientes_lineas as $linea):
            $visitas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
            $visitas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
            $visitas_linea_contacto_arreglo[$i]['visitas'] = 0;
            $visitas_linea_contacto_arreglo[$i]['inversion'] = 0;
            foreach($visitas_linea_contacto as $visita):
                if ($visita['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                    $visitas_linea_contacto_arreglo[$i]['visitas'] = $visita[0]['visitas'];
                }
            endforeach;
            foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                    $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                }
            endforeach;
            $i++;
        endforeach;
  
    }
    echo json_encode($visitas_linea_contacto_arreglo, true);
    exit();
    $this->autoRender = false;
  }

  function get_ventas_linea_contacto_arregloR(){
    setlocale(LC_TIME, "spanish");
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    $fecha_inicio   = '2020-01-01';
    $fecha_final    = date('Y-m-d');
    $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
    $dataCharDate = array();
    if ( $this->request->is(array('post')) ) {
        $rango          = $this->request->data['rango_fechas'];;
        $fecha_ini = substr($rango, 0,10).' 00:00:00';
        $fecha_fin = substr($rango, -10).' 23:59:59';
        $fi = date('Y-m-d',  strtotime($fecha_ini));
        $ff = date('Y-m-d',  strtotime($fecha_fin));
        $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM leads, dic_linea_contactos WHERE leads.cliente_id IN (SELECT id FROM clientes WHERE clientes.cuenta_id = $cuenta_id) AND leads.dic_linea_contacto_id IS NOT NULL AND leads.fecha >= '$fi' AND leads.fecha <= '$ff' AND leads.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");
  
        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
  
        $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
  
        $ventas_linea_contacto_arreglo = array();
        $i=0;
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id AND dic_linea_contactos.cuenta_id = $cuenta_id GROUP BY linea_contacto;";
        $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);
  
  
        foreach($clientes_lineas as $linea):
            $ventas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
            $ventas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
            $ventas_linea_contacto_arreglo[$i]['ventas'] = 0;
            $ventas_linea_contacto_arreglo[$i]['inversion'] = 0;
            foreach($venta_linea_contacto as $venta):
                if ($venta['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                    $ventas_linea_contacto_arreglo[$i]['ventas'] = $venta[0]['ventas'];
                }
            endforeach;
            foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                    $ventas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                }
            endforeach;
            $i++;
        endforeach;
  
       
      }else{
        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
  
        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
  
        $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fecha_inicio' AND  ventas.fecha <= '$fecha_final' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
  
        $ventas_linea_contacto_arreglo = array();
        $i=0;
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND publicidads.cuenta_id = $cuenta_id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto";
        $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);
  
    
        foreach($clientes_lineas as $linea):
            $ventas_linea_contacto_arreglo[$i]['canal'] = $linea['dic_linea_contactos']['canal'];
            $ventas_linea_contacto_arreglo[$i]['cantidad'] = $linea[0]['registros'];
            $ventas_linea_contacto_arreglo[$i]['ventas'] = 0;
            $ventas_linea_contacto_arreglo[$i]['inversion'] = 10;
            foreach($venta_linea_contacto as $venta):
                if ($venta['dic_linea_contactos']['canal']==$linea['dic_linea_contactos']['canal']){
                    $ventas_linea_contacto_arreglo[$i]['ventas'] = $venta[0]['ventas'];
                }
            endforeach;
            foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                    $ventas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];
                }
            endforeach;
            $i++;
        endforeach;
    }
    echo json_encode($ventas_linea_contacto_arreglo, true);
    exit();
    $this->autoRender = false;
  
  }

  function get_clientes_statusR(){
    //header('Content-Type: application/json');
    //$this->layout = null;
    $cuenta_id         = $this->Session->read('CuentaUsuario.Cuenta.id');
    $date_current      = date('Y-m-d');
    $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));
  
    $month     = date('Y-m');
    $aux       = date('Y-m-d', strtotime("{$month} + 1 month"));
    $fecha_ini = '01-01-'.date('Y');
    $fecha_fin = date('d-m-Y', strtotime("{$aux} - 1 day"));
  
    $data_clientes_temp     = array('frios'=>0, 'tibios'=>0, 'calientes'=>0, 'ventas'=>0);
    $data_clientes_status   = array('activos'=>0, 'inactivos_temp'=>0, 'ventas'=>0, 'inactivos_def'=>0);
    //roberto
    $data_clientes_atencion = array('oportunos'=>0, 'tardios'=>0, 'no_atendidos'=>0, 'por_reasignar'=>0, 'inactivos_temp'=>0);
    if ($this->request->is(array('post', 'put'))) {
      $rango          = $this->request->data['User']['rango_fechas'];;
  
      $fecha_ini = substr($rango, 0,10).' 00:00:00';
      $fecha_fin = substr($rango, -10).' 23:59:59';
      $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
      $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
  
      // Total de clientes activos
      $row_clientes_activos = $this->Cliente->find('all',array('recursive'=> -1,'conditions'=>array('Cliente.cuenta_id'=>$cuenta_id, 'Cliente.user_id <>' => '', 'Cliente.created >='=>date('Y-m-d', strtotime($fi)), 'Cliente.created <='=>date('Y-m-d', strtotime($ff)))));
    }else{
      // Total de clientes activos
      $row_clientes_activos = $this->Cliente->find('all',array('recursive'=> -1,'conditions'=>array('Cliente.cuenta_id'=>$cuenta_id, 'Cliente.user_id <>' => '', 'Cliente.created >='=>date('Y-m-d', strtotime($fecha_ini)), 'Cliente.created <='=>date('Y-m-d', strtotime($fecha_fin)))));
  
   }
   $i=o;
    foreach ($row_clientes_activos as $clientes) {
      switch ($clientes['Cliente']['status']) {
        case 'Activo':
          switch ($clientes['Cliente']['temperatura']) {
            case 1:
              $data_clientes_temp['frios'] ++;
              break;
            case 2:
              $data_clientes_temp['tibios'] ++;
              break;
            case 3:
              $data_clientes_temp['calientes'] ++;
              break;
          };
          $data_clientes_status['activos'] ++;
  
          if ($clientes['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_oportunos) {$data_clientes_atencion['oportunos']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$data_clientes_atencion['tardios']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $clientes['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$data_clientes_atencion['no_atendidos']++;}
          elseif($clientes['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $clientes['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$data_clientes_atencion['por_reasignar']++;}
          else{$data_clientes_atencion['por_reasignar']++;}
  
        break;
        case 'Activo venta':
          $data_clientes_status['ventas'] ++;
        break;
        case 'Inactivo temporal':
          $data_clientes_status['inactivos_temp'] ++;
          $data_clientes_atencion['inactivos_temp'] ++;
        break;
        case 'Inactivo':
          $data_clientes_status['inactivos_def'] ++;
        break;
      };
    }
    $status_cliente=array();
    $i=0;
    foreach ($data_clientes_atencion as $key => $value):
      $status_cliente[$i]['status'] = $key;
      $status_cliente[$i]['cantidad'] = $value;
      $i++;
    endforeach;
    echo json_encode($status_cliente, true);
    exit();
    $this->autoRender = false;
  }

  function get_grafica_status_ac(){
    $this->Cliente->Behaviors->load('Containable');
    setlocale(LC_TIME, "spanish");
        $cuenta_id    = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $fecha_inicio = '2020-01-01';
        $fecha_final  = date('Y-m-d');
        $d            = array('activos'=>0, 'inectivos'=>0,'inactivos_temporal'=>0);
        $data_status  = array(0=>'Activo',1=>'Inectivo', 2=>'Inactivo temporal');
       
        if ( $this->request->is(array('post', 'put')) ) {
            $rango     = $this->request->data['User']['rango_fechas'];
            $fecha_ini = substr($rango, 0,10).' 00:00:00';
            $fecha_fin = substr($rango, -10).' 23:59:59';
            $fi        = date('Y-m-d',  strtotime($fecha_ini));
            $ff        = date('Y-m-d',  strtotime($fecha_fin));
            $search    = $this->Cliente->find('count', array( 'conditions' => array('Cliente.cuenta_id' => $cuenta_id,'Cliente.created >=' => $fi,'Cliente.created <=' => $ff,),'fields' => array('Cliente.status'),'contain' => false ) );
            
         }else{
            $search = $this->Cliente->find('all',array('conditions' => array('Cliente.cuenta_id' => $cuenta_id,'Cliente.created >=' => $fecha_inicio,'Cliente.created <=' => $fecha_final,),'fields' => array('Cliente.status'),'contain' => false));
            $i      = 0;
            foreach($search as $value): 
              if($value['Cliente']['status']==$data_status[0]){
                $status[0]++;
              }
              if($value['Cliente']['status']==$data_status[1]){
                $status[1]++;
              }
              if($value['Cliente']['status']==null or $value[2]==$data_status[1]){
                $status[2]++;
              }
            endforeach;
            $status_cliente=array();
            foreach ($d as $key=>$value):
              $status_cliente[$i]['status']   = $key;
              if ($status[$i]== null) {
                $status_cliente[$i]['cantidad'] = 0;  
              }else{

                $status_cliente[$i]['cantidad'] = $status[$i];
              }
              $i++;
            endforeach;
          }
        echo json_encode($status_cliente, true);
        exit();
      $this->autoRender = false;
  }

  function get_grafica_cliente_inectivacion_definitiva(){
    setlocale(LC_TIME, "spanish");
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    $fecha_inicio   = '2020-01-01';
    $fecha_final    = date('Y-m-d');
    $fecha_ini = substr($rango, 0,10).' 00:00:00';
    $fecha_fin = substr($rango, -10).' 23:59:59';
    $fi = date('Y-m-d',  strtotime($fecha_ini));
    $ff = date('Y-m-d',  strtotime($fecha_fin));
    //$inactivos_definitivos_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus inactivo definitivo por motivo:%' GROUP BY cliente_id");
    
    $inactivos_definitivos_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus inactivo definitivo por motivo:%' GROUP BY cliente_id");
    $inactivos_distribucion = array();
    if (empty($inactivos_definitivos_raw)) {
      $inactivos_distribucion['razon']='no hay info';
      $inactivos_distribucion['cantidad']=100;
      echo json_encode($inactivos_distribucion, true);
    }else {
      foreach ($inactivos_definitivos_raw as $inactivo):
        $razon = explode(':',$inactivo['agendas']['mensaje'])[1];
        $valor = isset($inactivos_distribucion[$razon]) ? $inactivos_distribucion[$razon] :0;
        $inactivos_distribucion[$razon] = $valor +1;
      endforeach;
      $i=0;
      $inectivos_definitivos_c=array();
      foreach($inactivos_distribucion as $key => $value){
        $inectivos_definitivos_c[$i]['razon']=$key;
        $inectivos_definitivos_c[$i]['cantidad']=$value;
        $i++;
      }    
      echo json_encode($inectivos_definitivos_c, true);
    } 
    //$this->set(compact('inactivos_distribucion'));
    exit();
    $this->autoRender = false;
  }

  function get_grafica_cliente_inectivacion_temporales(){
    setlocale(LC_TIME, "spanish");
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    $fecha_inicio   = '2020-01-01';
    $fecha_final    = date('Y-m-d');
    $fecha_ini = substr($rango, 0,10).' 00:00:00';
    $fecha_fin = substr($rango, -10).' 23:59:59';
    $fi = date('Y-m-d',  strtotime($fecha_ini));
    $ff = date('Y-m-d',  strtotime($fecha_fin));
    $inactivos_temporales_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND status = 'Inactivo Temporal') AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo:%' GROUP BY cliente_id");
    $inactivos_temporal_distribucion = array();
    if(empty($inactivos_temporales_raw)) {
      $inactivos_temporal_distribucion['razon']='no hay info';
      $inactivos_temporal_distribucion['cantidad']=100;
      echo json_encode($inactivos_temporal_distribucion, true);
    }else{
      $inactivos_temporal_distribucion['Solicitó contactarlo tiempo después'] = 0;
      foreach ($inactivos_temporales_raw as $inactivo):
          $razon = explode(':',$inactivo['agendas']['mensaje'])[1];
          if (strpos($razon,"contactarlo")!== false){
              $valor = $inactivos_temporal_distribucion['Solicitó contactarlo tiempo después'];
              $inactivos_temporal_distribucion['Solicitó contactarlo tiempo después'] = $valor +1;
          }else{
              $razon1 = substr($razon,0,-14);
              $valor = isset($inactivos_temporal_distribucion[$razon1]) ? $inactivos_temporal_distribucion[$razon1] :0;
              $inactivos_temporal_distribucion[$razon1] = $valor +1;
          }
        endforeach;
        $i=0;
        $inactivos_temporales=array();
        foreach($inactivos_temporal_distribucion as $key => $value){
          $inactivos_temporales[$i]['razon']=$key;
          $inactivos_temporales[$i]['cantidad']=$value;
          $i++;
        }
        echo json_encode($inactivos_temporales, true);
    }
    exit();
    $this->autoRender = false;
  }

  function get_grafica_cancelacion(){
    setlocale(LC_TIME, "spanish");
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    $fecha_inicio   = '2020-01-01';
    $fecha_final    = date('Y-m-d');
    $fecha_ini = substr($rango, 0,10).' 00:00:00';
    $fecha_fin = substr($rango, -10).' 23:59:59';
    $fi = date('Y-m-d',  strtotime($fecha_ini));
    $ff = date('Y-m-d',  strtotime($fecha_fin));
           
    $cancelaciones_raw = $this->Cliente->query("SELECT motivo_cancelacion, COUNT(*) AS sumatoria FROM events WHERE  cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id ) AND motivo_cancelacion IS NOT NULL  AND fecha_inicio >= '$fi' AND fecha_inicio <= '$ff'  GROUP BY motivo_cancelacion");
    $cancelacion_distribucion = array();
    if (empty($cancelaciones_raw)) {
      $cancelacion_distribucion['razon']='no hay info';
      $cancelacion_distribucion['cantidad']=100;
      echo json_encode($cancelacion_distribucion, true);
    }else {
      foreach ($cancelaciones_raw as $inactivo):
        $razon = explode(':',$inactivo['agendas']['mensaje'])[1];
        $valor = isset($cancelacion_distribucion[$razon]) ? $cancelacion_distribucion[$razon] :0;
        $cancelacion_distribucion[$razon] = $valor +1;
      endforeach;
      $i=0;
      $cancelacion_cliente=array();
      foreach($cancelacion_distribucion as $key => $value){
        $cancelacion_cliente[$i]['razon']=$key;
        $cancelacion_cliente[$i]['cantidad']=$value;
        $i++;
      }    
      echo json_encode($cancelacion_cliente, true);
    } 

    exit();
    $this->autoRender = false;

  }

  /************************************************* Grafica de DISTRIBUCION DE CLIENTES POR DESARROLLOS POR ASESOR 
  $clientes_asignados_desarrollos = $this->Cliente->query("SELECT COUNT(*) AS clientes, desarrollos.nombre FROM clientes,desarrollos WHERE desarrollos.id = clientes.desarrollo_id AND clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' GROUP BY desarrollos.nombre ORDER BY clientes DESC;");
  $this->set('clientes_asignados_desarrollos',$clientes_asignados_desarrollos);
  **/


  /**
  *funcion para alimentar la grafica de estatusa de los clientes 
  *activos, inactivos temporales, inactivos definitivos, por medio de id del desarrollo,
  *id del asesor, fechas y cuenta  
  * AKA RogueOne
  */

  function grafica_clientes_estatus(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $clientes_activos              = 0;
    $clientes_inactivos            = 0;
    $clientes_inactivos_temporales = 0;
    $condiciones                   = [];
    $fecha_ini                     = '';
    $fecha_fin                     = '';
    $and                           = [];
    $or                            = [];
    $desarrollo_id                 = 0;
    $response =array();
    $i=0;

    if ($this->request->is('post')) {
      // Filttros base
        array_push($and,
          array(
            'Cliente.user_id <>'    => '',
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      // Fin de filtros base

      // Condicion para el rango de fechas
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }

      // Condicion para el desarrollo id.
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $substr_desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' => $substr_desarrollo_id ));
      }

      // Condicion para el asesor id.
      if( !empty( $this->request->data['user_id'] ) ){
        array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
      }

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );

      $clientes_activos = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'AND' => array(
              'Cliente.status'      => 'Activo',
              $condiciones
            )
          )
        )
          // array(
          //   'conditions' => array(
          //     'Cliente.status'        => 'Activo',
          //     $condiciones
          //   )
          // )
      );
      
      $clientes_inactivos = $this->Cliente->find('count',
          array(
            'conditions' => array(
              'AND' => array(
                'Cliente.status'      => 'Inactivo',
                $condiciones
              )
            )
          )
      );
  
      $clientes_inactivos_temporales = $this->Cliente->find('count',
          array(
            'conditions' => array(
              'AND' => array(
                'Cliente.status'      => 'Inactivo temporal',
                $condiciones
              )
            )
          )
      );

    }
    
  
      $response = array(
        '0' => array(
          'estado'   => 'Activos',
          'cantidad' => $clientes_activos,
          //'color'    => '#BF9000'
        ),
        '1' => array(
          'estado'   => 'Inactivos temporal',
          'cantidad' => $clientes_inactivos_temporales,
          //'color'    => '#7F6000'
        ),
        '2' => array(
          'estado'   => 'Inactivos definitivo',
          'cantidad' => $clientes_inactivos,
          //'color'    => '#3D3D3D'
        )
      );
    
    

    echo json_encode( $response , true );
    $this->autoRender = false;    

  }
  /**
  * funcion para alimentar la frafica de la atencion de los clientes activos, 
  * por medio de id del desarrollo,
  * id del asesor, fechas y cuenta 
  * AKA RogueOne
  *   
  * 
  */

  function grafica_clientes_atencion(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $clientes_oportunos         = 0;
    $clientes_tardia            = 0;
    $clientes_atrasados         = 0;
    $clientes_reasignar         = 0;
    $clientes_sin_seguimiento   = 0;
    $condiciones                = [];
    $fecha_ini                  = '';
    $fecha_fin                  = '';
    $and                        = [];
    $or                         = [];
    $cond_atencion_tardia       = 0;
    $cond_atencion_no_atendidos = 0;
    $cond_atencion_reasignar    = 0;
    $cond_atencion              = 0;
    if ($this->request->is('post')) {
      // Filttros base
        array_push($and,
          array(
            'Cliente.user_id <>'    => '',
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      // Fin de filtros base

      // Condicion para el rango de fechas
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }

      // Condicion para el desarrollo id.
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $substr_desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' => $substr_desarrollo_id ));
      }

      // Condicion para el asesor id.
      if( !empty( $this->request->data['user_id'] ) ){
        array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
      }
      $cond_atencion_aportuna = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
      $cond_atencion_tardia = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY)","last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
      $cond_atencion_no_atendidos = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY)","Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY)");
      $cond_atencion_reasignar = array("Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY)"); 
      $cond_atencion_sin_asignar = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );
      $clientes_oportunos = $this->Cliente->find('count',
          array(
            'conditions' => array(
              'Cliente.status'        => 'Activo',
              $cond_atencion_aportuna,
              $condiciones
            )
          )
      );
      $clientes_tardia= $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'        => 'Activo',
            $cond_atencion_tardia,
            $condiciones
          )
        )
      );
      $clientes_atrasados=  $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'        => 'Activo',
            $cond_atencion_no_atendidos,
            $condiciones
          )
        )
      );
      $clientes_reasignar= $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'        => 'Activo',
            $cond_atencion_reasignar,
            $condiciones
          )
        )
      );
      $clientes_sin_seguimiento= $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'        => 'Activo',
            $cond_atencion_sin_asignar,
            $condiciones
          )
        )
      );
    }
    $aportunos =("Oportunos(1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")");
    $tardia=("Tardios ( De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")");
    $no_atendidos=("No atendidos(".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a " .$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")");
    $reasignar=("Por reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atencion)");
    
      $response = array(
        '0' => array(
          'estado'   => $aportunos,
          'cantidad' => $clientes_oportunos,
          //'color'    => '#1f4e79'
        ),
        '1' => array(
          'estado'   => $tardia,
          'cantidad' => $clientes_tardia,
          //'color'    => '#7030a0'
        ),
        '2' => array(
          'estado'   =>  $no_atendidos,
          'cantidad' => $clientes_atrasados,
          //'color'    => '#da19ca'
        ),
        '3' => array(
          'estado'   => $reasignar,
          'cantidad' => $clientes_reasignar,
          //'color'    => '#7f7f7f'
        ),
        // '4' => array(
        //   'estado'   => 'Sin asignar',
        //   'cantidad' => $clientes_sin_seguimiento,
        //   //'color'    => '#7f7f7f'
        // )
      );
    
    //$cond_atencion_sin_asignar = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");

    echo json_encode( $response , true );
    exit();
    $this->autoRender = false;    

  }
  
  /**
  * funcion para alimentar la grafica de 
  * motivo de inactivacion definitiva
  * AKA RogueOne
  */
  function  grafica_motivo_inactivo_definitivo(){
    // header('Content-type: application/json; charset=utf-8');

    $this->Cliente->Behaviors->load('Containable');
    $this->Agenda->Behaviors->load('Containable');
    $condiciones                   = [];
    $fecha_ini                     = '';
    $fecha_fin                     = '';
    $and                           = [];
    $or                            = [];
    $desarrollo_id                 = 0;
    $inactivos_definitivos=array();
    $respuesta_metodo = false;

    if ($this->request->is('post')) {
      // Filttros base
        array_push($and,
          array(
            'Cliente.user_id <>'    => '',
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      // Fin de filtros base

      // Condicion para el rango de fechas
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
            $cond_rangos = array("Agenda.fecha LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
            $rengoagenda = array("Agenda.fecha BETWEEN ? AND ?" => array($fi, $ff));

        }
        array_push($and, $cond_rangos);
      }

      // Condicion para el desarrollo id.
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $substr_desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' => $substr_desarrollo_id ));
      }

      // Condicion para el asesor id.
      if( !empty( $this->request->data['user_id'] ) ){
        array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
      }

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );
      //
      // $clientes_inactivos = $this->Cliente->find('count',
      //   array(
      //     'conditions' => array(
      //       'AND' => array(
      //         'Cliente.status'      => 'Inactivo',
      //         $condiciones
      //       )
      //     ),
      //     'fields' => array(
      //       'Cliente.id',
      //     ),
      //     'order'=>'Cliente.id DESC',
      //     'contain' => false 
      //   )
      // );
      // $ajendas_motivo=$this->Agenda->find('count',array(
      //   'conditions'=>array(     
      //     'Agenda.mensaje LIKE' => '%pasa a estatus inactivo definitivo por motivo:%',
      //     //'Agenda.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
      //   ),
      //   'fields' => array(
      //     'Agenda.cliente_id',
      //   ),
      //   'group' => 'Agenda.cliente_id',
      //   'order'=>'Agenda.cliente_id DESC',
      //   'contain' => false 
      //   )
      // );
      // if ($clientes_inactivos != $ajendas_motivo) {
      //   $this->id_no_encontrado_inactivo_definitivo($condiciones);
      // }
      $clientes_inactivos = $this->Cliente->find('all',
          array(
            'conditions' => array(
              'AND' => array(
                'Cliente.status' => 'Inactivo',
                $condiciones
              )
            ),
            'fields' => array(
              'Cliente.id',
            ),
            'order'   => 'Cliente.id DESC',
            'contain' => false
          )
      );
      $ajendas_motivo=$this->Agenda->find('all',array(
          'conditions'=>array(     
            'Agenda.mensaje LIKE' => '%pasa a estatus inactivo definitivo por motivo:%',
            //'Agenda.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
            //'Agenda.fecha'=>,
            // $rengoagenda,
          ),
          'fields' => array(
            'Agenda.cliente_id',
            'Agenda.mensaje'
          ),
          'group'   => 'Agenda.cliente_id',
          'order'   => 'Agenda.cliente_id DESC',
          'contain' => false
          )
      );
      $i=0;
      $inactivos_definitivos=array();
      foreach ($ajendas_motivo as $valueA) {
        foreach ($clientes_inactivos as $valueC) {
          if ($valueC['Cliente']['id']==$valueA['Agenda']['cliente_id']) {
            $inactivos_definitivos[$i]['id']=$valueA['Agenda']['cliente_id'];
            $inactivos_definitivos[$i]['mensaje']=$valueA['Agenda']['mensaje'];
            $i++;
          }
        }
      }
      $i=0;
      $inactivos_distribucion = array();
      foreach ($inactivos_definitivos as $inactivo):
        $razon = explode(':',$inactivo['mensaje'])[1];
        $valor = isset($inactivos_distribucion[$razon]) ? $inactivos_distribucion[$razon] :0;
        $inactivos_distribucion[$razon] = $valor +1;
        $i++;
      endforeach;
      $inactivos_definitivos=[];
      $i=0;
      foreach ($inactivos_distribucion as $key => $value) {
        $inactivos_definitivos[$i]['motivo']=$key;
        $inactivos_definitivos[$i]['cantidad']=$value;
        $i++;
      }
    }
    if (empty($inactivos_definitivos)) {
      $inactivos_definitivos[$i]['motivo']='Sin información';
      $inactivos_definitivos[$i]['cantidad']=100;
    }
    echo json_encode( $inactivos_definitivos , true );
    exit();
    $this->autoRender = false;         
  }
  
  /**
  * 
  *funcion para alimentar la grafica de 
  * motivo de inactivacion temporales
  * AKA RogueOne
  *
  */
  function grafica_motivo_inactivo_temporal(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $this->Agenda->Behaviors->load('Containable');
    $clientes_inactivos_temporales=[];
    $condiciones                   = [];
    $fecha_ini                     = '';
    $fecha_fin                     = '';
    $and                           = [];
    $or                            = [];
    if ($this->request->is('post')) {
      // Filttros base
        array_push($and,
          array(
            'Cliente.user_id <>'    => '',
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      // Fin de filtros base

      // Condicion para el rango de fechas
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
            $cond_rangos = array("Agenda.fecha LIKE '".$fi."%'");
        }else{
            $rengoagenda = array("Agenda.fecha BETWEEN ? AND ?" => array($fi, $ff));
            $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }

      // Condicion para el desarrollo id.
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $substr_desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' => $substr_desarrollo_id ));
      }

      // Condicion para el asesor id.
      if( !empty( $this->request->data['user_id'] ) ){
        array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
      }

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );
      // $clientes_inactivos_temporales = $this->Cliente->find('count',
      //   array(
      //     'conditions' => array(
      //       'AND' => array(
      //         'Cliente.status'      => 'Inactivo temporal',
      //         $condiciones
      //       )
      //     ),
      //     'fields' => array(
      //       'Cliente.id',
      //     ),
      //     'contain' => false 
      //   )
      // );
      // $ajendas_motivo=$this->Agenda->find('count',array(
      //   'conditions'=>array(     
      //     'Agenda.mensaje LIKE' => '%pasa a estatus inactivo temporal por motivo:%',
      //     //'Agenda.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
      //   ),
      //   'fields' => array(
      //     'Agenda.cliente_id',
      //   ),
      //   'group' => 'Agenda.cliente_id',
      //   'contain' => false 
      //   )
      // );
      // if($clientes_inactivos_temporales != $ajendas_motivo){
      //   $this->id_no_encontrado_inactivo_temporal($condiciones);
      // }
      $clientes_inactivos_temporales = $this->Cliente->find('all',
        array(
          'conditions' => array(
            'AND' => array(
              'Cliente.status' => 'Inactivo temporal',
              $condiciones
            )
          ),
          'fields' => array(
            'Cliente.id',
          ),
          'contain' => false 
        )
      );
      $ajendas_motivo=$this->Agenda->find('all',array(
        'conditions'=>array(     
          'Agenda.mensaje LIKE' => '%pasa a estatus inactivo temporal por motivo:%',
          //'Agenda.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
          
        ),
        'fields' => array(
          'Agenda.cliente_id',
          'Agenda.mensaje'
        ),
        'group' => 'Agenda.cliente_id',
        'contain' => false 
        )
      );  
      $inactivos_temporales_raw=array();
      $i=0;
      foreach ($ajendas_motivo as $valueA) {
        foreach ($clientes_inactivos_temporales as $valueC) {
          if( $valueC['Cliente']['id']==$valueA['Agenda']['cliente_id']){
            $inactivos_temporales_raw[$i]['id']=$valueA['Agenda']['cliente_id'];
            $inactivos_temporales_raw[$i]['mensaje']= substr($valueA['Agenda']['mensaje'],0,-31);
          // $inactivos_temporales_raw[$i]['mensaje']= $valueA['Agenda']['mensaje'];

            $i++;
          }
        }  
      }
      $inactivos_temporal_distribucion = array();
      foreach ($inactivos_temporales_raw as $inactivo):
        $razon = explode(':',$inactivo['mensaje'])[1];
        if (stristr("$razon", "Solicitó contactarlo") || stristr("$razon", "y pide")) {
          $razon="Solicitó contactarlo tiempo despues";
        }
        
        $valor = isset($inactivos_temporal_distribucion[$razon]) ? $inactivos_temporal_distribucion[$razon] :0;
        $inactivos_temporal_distribucion[$razon] = $valor +1;
      endforeach;
      $inactivos_temporales=[];
      $i=0;
      foreach ($inactivos_temporal_distribucion as $key => $value) {
        $inactivos_temporales[$i]['motivo']=$key;
        $inactivos_temporales[$i]['cantidad']=$value;
        $i++;
      }
    }
    if (empty($inactivos_temporales)) {
      $inactivos_temporales[$i]['motivo']='Sin información';
      $inactivos_temporales[$i]['cantidad']=100;
    }
    echo json_encode( $inactivos_temporales , true );
    $this->autoRender = false; 
  }
  
  /**
  * esta funcion se crea para tener msj para acomplatar los clientes
  * que estan inactivos definitivos ya que no se les agrego un msj
  *de inactivacion 
  * AKA RogueOne
  */
  public function id_no_encontrado_inactivo_definitivo( $condiciones = null ){
    $this->Cliente->Behaviors->load('Containable');
    $this->Agenda->Behaviors->load('Containable');
    $response = true;

    $clientes_inactivosR = $this->Cliente->find('list',
      array(
        'conditions' => array(             
          'Cliente.status'      => 'Inactivo',
          $condiciones
        ),
        'fields' => array(
          'Cliente.id',
          ),
        'order'=>'Cliente.id DESC',
        'contain' => false 
      )
    );

    $ajendas_motivo=$this->Agenda->find('list',
        array(
          'conditions'=>array(     
            'Agenda.mensaje LIKE' => '%pasa a estatus inactivo definitivo por motivo:%',
            //'Agenda.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
          ),
          'fields' => array(
            'Agenda.cliente_id',
          ),
          'group' => 'Agenda.cliente_id',
          'order'=>'Agenda.cliente_id DESC',
          'contain' => false 
        )
    );

    foreach ( $clientes_inactivosR as $valueC ) {

      if( array_search($valueC , $ajendas_motivo) == false ){
        
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']    = 'pasa a estatus inactivo definitivo por motivo: No le interesa ninguna de las propiedades';
        $this->request->data['Agenda']['cliente_id'] = $valueC;
        
        if( !$this->Agenda->save($this->request->data) ){
          $response = false; 
        }

      }

    }

    return $response;
    $this->autoRender = false; 
  }
  /**
  * esta funcion crea msj para los clientes que no tengan 
  * msj de inactivacion temporal 
  * AKA RogueOne
  */
  public function id_no_encontrado_inactivo_temporal($condiciones){
    $clientes_temporalesR = $this->Cliente->find('list',
      array(
        'conditions' => array(             
          'Cliente.status'      => 'Inactivo temporal',
          $condiciones
        ),
        'fields' => array(
          'Cliente.id',
          ),
        'order'=>'Cliente.id DESC',
        'contain' => false 
      )
    );
    $ajendas_motivo=$this->Agenda->find('list',array(
      'conditions'=>array(     
        'Agenda.mensaje LIKE' => '%pasa a estatus inactivo temporal por motivo:%',
       // 'Agenda.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
      ),
      'fields' => array(
        'Agenda.cliente_id',
      ),
      'group' => 'Agenda.cliente_id',
      'order'=>'Agenda.cliente_id DESC',
      'contain' => false  
      )
    );
    foreach ($clientes_temporalesR as $valueC) {
      if(array_search($valueC,$ajendas_motivo)==false){
        $this->Agenda->create();
        $this->request->data['Agenda']['mensaje']='pasa a estatus inactivo temporal por motivo:Solicitó contactarlo tiempo después y pide reconectaco el 06/09/2022';
        $this->request->data['Agenda']['cliente_id']=$valueC;
        $this->request->data['Agenda']['fecha']=date('Y-m-d H:i:s');
        $this->request->data['Agenda']['user_id']=1;
        $this->Agenda->save($this->request->data['Agenda']);
      }
    }
    $this->autoRender = false; 
  }

  /***
   * 
   * Muestra la información de los clientes.
   * 19/Dic/2022
   * AKA - Roberto
  */
  function get_clientes_info(){
    header("Content-Type: application/json; charset=utf-8");
    $this->loadModel('Cuenta');
    $this->Cuenta->Behaviors->load('Containable');
    $clientes_json = [];
    $count         = 0;
    $limpieza      = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "�");

    if ($this->request->is('post')) {

      $cuenta_id = $this->request->data['cuenta_id'];
      $param=$this->Cuenta->find('first',array(
        'conditions'=>array(
          'Cuenta.id'=>$cuenta_id,        
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
      $date_current      = date('Y-m-d');
      $date_oportunos    = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') - $param['Parametros']['sla_oportuna'], date('Y')));
      $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') -$param['Parametros']['sla_atrasados'], date('Y')));
      $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $param['Parametros']['sla_no_atendidos'], date('Y')));
      
      
      $this->request->data['Cliente']                       = $this->request->data;
      $this->request->data['Cliente']['asesor']             = $this->request->data['id'];                  // Esta variable eta definida para que funcione con el asesor id que nos va a traer los clientes.
      $this->request->data['Cliente']['cuenta_id']          = $this->request->data['cuenta_id'];           // Esta variable eta definida para que funcione con el asesor id que nos va a traer los clientes.
      $this->request->data['Cliente']['desarrollo_id']      = $this->request->data['desarrollo_id'];
      $this->request->data['Cliente']['nombre']             = $this->request->data['nombre'];
      $this->request->data['Cliente']['correo_electronico'] = $this->request->data['correo_electronico'];
      $this->request->data['Cliente']['email_id']           = $this->request->data['email_id'];
      $this->request->data['Cliente']['etapa_cliente']      = $this->request->data['etapa_cliente'];
      $this->request->data['Cliente']['status_atencion']    = $this->request->data['status_atencion'];
    
      $clientes = $this->listado_clientes_app( $this->request->data, 15 );

      foreach( $clientes as $cliente ) {
  
        if( $cliente['Cliente']['etapa'] == 1 )    { $c_etapa = '#'; }
        elseif( $cliente['Cliente']['etapa'] == 2 ){ $c_etapa = '#'; }
        elseif( $cliente['Cliente']['etapa'] == 3 ){ $c_etapa = '#'; }
        elseif( $cliente['Cliente']['etapa'] == 4 ){ $c_etapa = '#'; }
        elseif( $cliente['Cliente']['etapa'] == 5 ){ $c_etapa = '#'; }
        elseif( $cliente['Cliente']['etapa'] == 6 ){ $c_etapa = '#'; }
        elseif( $cliente['Cliente']['etapa'] == 7 ){ $c_etapa = '#'; }
        else{$c_etapa = 'estado1'; }
  
        if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
        elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
        elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
        elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
        else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
  
  
        if( $cliente['Cliente']['status'] == 'Activo' ){
          $cliente['Cliente']['status'] = 'Activo';
          $cliente['Cliente']['status_color'] = '#';
          }elseif( $cliente['Cliente']['status'] == 'Inactivo' ){
          $cliente['Cliente']['status'] = 'Inactivo Definitivo';
          $cliente['Cliente']['status_color'] = '#';
          }else {
          $cliente['Cliente']['status'] = 'Inactivo Temporal';
          $cliente['Cliente']['status_color'] = '#';
        }
  
        $clientes_json[$count]['id'] = rtrim(str_replace( $limpieza, "", $cliente['Cliente']['id']));
        $clientes_json[$count]['nombre'] = rtrim(str_replace( $limpieza, "", $cliente['Cliente']['nombre']));
        $clientes_json[$count]['correo'] = rtrim(str_replace( $limpieza, "", $cliente['Cliente']['correo_electronico']));
        $clientes_json[$count]['comentarios'] = rtrim(str_replace( $limpieza, "", $cliente['Cliente']['comentarios']));
        $clientes_json[$count]['linea_contacto'] = rtrim(str_replace($limpieza, "", $cliente['DicLineaContacto']['linea_contacto']));
        $clientes_json[$count]['telefono1'] =rtrim(str_replace($limpieza, "", $cliente['Cliente']['telefono1']));
        // $clientes_json[$count]['name_at'] = $name_at;
        // $clientes_json[$count]['status'] ="<small class='chip ".$cliente['Cliente']['status_color']."'>".$cliente['Cliente']['status']."<small>";
        // $clientes_json[$count]['etapa'] = "<small class='chip ".$c_etapa."'>".$cliente['Cliente']['etapa']."<small>";
        $clientes_json[$count]['desarollo'] =rtrim(str_replace( $limpieza, "", $cliente['Desarrollo']['nombre']));
        $clientes_json[$count]['User'] =rtrim(str_replace( $limpieza, "", $cliente['User']['nombre_completo']));
        $clientes_json[$count]['inmueble'] = rtrim(str_replace( $limpieza, "", $cliente['Inmueble']['titulo']));
        // $clientes_json[$count]['created'] =date('Y-m-d', strtotime($cliente['Cliente']['created']));
        $clientes_json[$count]['last_edit'] =  date('Y-m-d', strtotime($cliente['Cliente']['last_edit']));       
        $count++;
      }

    }


    // echo json_encode($param , true);
    $json = json_encode( $clientes_json, true );
    if ($json){
      echo $json;
    }else{
      echo json_last_error_msg();
    }
    exit();

    $this->autoRender = false;
  }

  public function listado_clientes_app( $data = null ) {
    $this->layout = 'blank';
    $this->loadModel('Cuenta');
    $this->Cuenta->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    $or  = [];
    $and = [];

    // $data = array(
    //   'Cliente' => array(
    //     // 'asesor'             => "447",
    //     // 'correo_electronico' => "saak.hg.pv@gmail.com",
    //     // 'desarrollo_id'      => "68",
    //     // 'estatus_cliente'    => "Activo",
    //     // 'etapa_cliente'      => "4",
    //     // 'forma_contacto'     => "43",
    //     // 'inmueble_id'        => "3345",
    //     // 'nombre'             => "Alejandro Hernandez",
    //     // 'status_atencion'    => "0",
    //     // 'telefono'           => "5586786933",
    //     // 'tipos_clientes'     => "1"
    //   ),
    //   'date_created' => "04/01/2021 - 04/30/2021",
    //   // 'date_last_edit' => "01/01/2021 - 02/23/2021"

    // );
    // $this->request->data = $data;


    if( !empty( $data ) ){

      /* ------------------------------ Validaciones ------------------------------ */
      // Desarrollador.
      // Asesor.
      // Gerente.
      // SuperAdmin.
      $cuenta_id=$this->request->data['Cliente']['cuenta_id'];
      if($this->Session->read('Permisos.Group.call') == 1){
        array_push($and,
          array(
            'Cliente.user_id <>' => ''
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' =>$cuenta_id,
            // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      }elseif($this->Session->read('Permisos.Group.cown') == 1){
        array_push($and,
          array(
            'Cliente.user_id' => $this->Session->read('Auth.User.id')
          )
        );
      }
      $cond_atencion=array();
      // $cuenta_id=$this->request->data['Cliente']['cuenta_id'];
      
      $param=$this->Cuenta->find('first',array(
        'conditions'=>array(
          'Cuenta.id'=>$cuenta_id,        
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
      /**
       * para mapen el solo manda el correo 
       */
      if( !empty($data['Cliente']['email_id']) ){ 
        $usuario = $this->CuentasUser->find('first', array('conditions'=>array('User.correo_electronico'=>$data['Cliente']['email_id']), 'fields' => array('User.id', 'User.correo_electronico'), 'contain' => false)); 
        array_push($and,array('Cliente.user_id' =>$usuario['User']['id']));
      }
      // En caso de estar limpios los filtros.
      if( !empty($data['Cliente']['cuenta_id']) ){ array_push($and, array('Cliente.cuenta_id' => $data['Cliente']['cuenta_id'] )); }
      if( !empty($data['Cliente']['nombre']) ){ array_push($and, array('Cliente.nombre LIKE "%'.$data['Cliente']['nombre'].'%"')); }
      if( !empty($data['Cliente']['correo_electronico']) ){ array_push($and, array('Cliente.correo_electronico' => $data['Cliente']['correo_electronico'])); }
      if( !empty($data['Cliente']['telefono']) ){ array_push($and, array('Cliente.telefono1' => $data['Cliente']['telefono'])); }
      if( !empty($data['Cliente']['estatus_cliente']) ){ array_push($and, array('Cliente.status' => $data['Cliente']['estatus_cliente'] )); }else{array_push($and, array('Cliente.status' => array('Activo', 'Inactivo temporal')));}
      if( !empty($data['Cliente']['tipos_clientes']) ){ array_push($and, array('Cliente.dic_tipo_cliente_id' => $data['Cliente']['tipos_clientes'] )); }
      if( !empty($data['Cliente']['etapa_cliente']) ){ array_push($and, array('Cliente.etapa' => $data['Cliente']['etapa_cliente'] )); }
      if( !empty($data['Cliente']['forma_contacto']) ){ array_push($and, array('Cliente.dic_linea_contacto_id' => $data['Cliente']['forma_contacto'] )); }
      if( !empty($data['Cliente']['asesor']) ){ array_push($and, array('Cliente.user_id' => $data['Cliente']['asesor'] )); }
      if( !empty($data['Cliente']['inmueble_id']) ){ array_push($and, array('Cliente.inmueble_id' => $data['Cliente']['inmueble_id'] )); }
      if( !empty($data['Cliente']['desarrollo_id']) ){ array_push($and, array('Cliente.desarrollo_id' => $data['Cliente']['desarrollo_id'] )); }
      //     $cond_atencion_oportuna =intval($param['Parametros']['sla_oportuna']);  
      //     $cond_atencion_tardia = intval($param['Parametros']['sla_atrasados']);
      //     $cond_atencion_no_atendidos =intval($param['Parametros']['sla_no_atendidos']); 
      if( !empty($data['status_atencion'] )){
        switch($data['status_atencion']){
          case 0: // Oportuna son mamadas
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_oportuna']." DAY)");
          break;
          case 1: //Tardía
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_atrasados']." DAY)","last_edit < DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_oportuna']." DAY)");
          break;
          case 2: //No Atendidos
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_no_atendidos']." DAY)","Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_atrasados']." DAY)");
          break;
          case 3://Por Reasignar
            $cond_atencion = array("Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_no_atendidos']." DAY)");
          break;
          default:
            $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$param['Parametros']['sla_oportuna']." DAY)");
          break;
        }
        array_push($and, $cond_atencion);
      }

      if( !empty($this->request->data['date_created']) ){
        $fecha_ini = substr($this->request->data['date_created'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['date_created'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }

      if( !empty($this->request->data['date_last_edit']) ){
        $fecha_ini = substr($this->request->data['date_last_edit'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['date_last_edit'], -10).' 23:59:59';
        $fi = date('Y-m-d',  strtotime($fecha_ini));
        $ff = date('Y-m-d',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }


      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );

    }else {

      if($this->Session->read('Permisos.Group.call') == 1){
        
        array_push($and,
          array(
            'Cliente.status'  => array('Activo', 'Inactivo temporal'),
            'Cliente.user_id <>' => ''
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $cuenta_id,
            // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );

      }elseif($this->Session->read('Permisos.Group.cown') == 1){
        array_push($and,
          array(
            'Cliente.status'  => array('Activo', 'Inactivo temporal'),
            // 'Cliente.user_id' => $this->Session->read('Auth.User.id')
          )
        );
      }

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );

    }

    $clientes = $this->Cliente->find('all',
      array(
          'conditions' => $condiciones,
          'contain' => array(
            'User'             => array('fields' => array('id', 'nombre_completo') ),
            'DicLineaContacto' => array('fields' => array('linea_contacto')),
            'Inmueble'         => array('fields' => array('titulo')),
            'Desarrollo'       => array('fields' => array('nombre')),
          ),
          'fields'    => array(
            'Cliente.id',
            'Cliente.etapa',
            'Cliente.last_edit',
            'Cliente.nombre',
            'Cliente.created',
            'Cliente.status',
            'Cliente.last_edit',
            'Cliente.correo_electronico',
            'Cliente.telefono1',
            'Cliente.comentarios',
          
          ),
          'order' => 'Cliente.created DESC',

      )
    );
    
    return $clientes;
    $this->autoRender = false;
    // $this->set(compact('clientes'));

  }


  /** 
   * 
   * Metodo para agregar clientes de forma externa a Adryo.
   * Aka - RogueOne
   * Fecha: 19/Dic/2022
   * Se agrega cadena limpieza a 10 digitos del campo de télefono AKA 47mm 31-Mar-20223
  */
  // Agregar cliente de forma externa
  public function set_add_clientes(){
    $params_cliente = [];
    $response       = [];
    $user_id        = '';
		$telefono_			= '';
    if ($this->request->is('post')) {

      // Buscamos el id del asesor por medio del email
      if( !empty($this->request->data['email_user']) ){
        $user = $this->CuentasUser->find('first', array('conditions'=>array('User.correo_electronico'=>$this->request->data['email_user'])));
        $user_id = $user['User']['id'];
      }

			$telefono_ = $this->request->data['telefono1'];
			 // Eliminar espacios en blanco
			$cadenaSinEspacios = str_replace(' ', '', $telefono_);

			// Obtener los �ltimos 10 caracteres
			$phone = substr($cadenaSinEspacios, -10);

      $params_cliente = array(
        'nombre'              => $this->request->data['nombre'],
        'correo_electronico'  => $this->request->data['correo_electronico'],
        'telefono1'           => $phone,
        'telefono2'           => '',
        'telefono3'           => '',
        'tipo_cliente'        => $this->request->data['dic_tipo_cliente_id'],
        'propiedades_interes' => 'D'.$this->request->data['propiedad_id'],
        'forma_contacto'      => $this->request->data['dic_linea_contacto_id'],
        'comentario'          => '',
        'asesor_id'           => $user_id,
        'created'             => null,
      );

      $params_user = array(
        'user_id'              => 1,
        'cuenta_id'            => $this->request->data['cuenta_id'],
        'notificacion_1er_seg' => 1,
      );

      $save_client = $this->add_cliente( $params_cliente, $params_user );
      // $this->validar_linea_contacto($save_client['cliente_id'],$params_user['user_id'],$params_user['cuenta_id'],$this->request->data['dic_linea_contacto_id'],$this->request->data['propiedad_id']);

      if( $save_client['bandera'] == 1 ){
        $response['flag'] = true;
        $response['message'] = 'Se a guardado correctamente el cliente';

      }else{

        $response['flag'] = $save_client['bandera'];
        $response['message'] = $save_client['respuesta'];

      }

      // echo json_encode( $response );
      // $this->autoRender = false;

    }

    echo json_encode( $response );
    $this->autoRender = false;



  }

  /***
   * 
   * 
   * 
   */
  function clientes_mes_das(){
    header("Content-Type: application/json; charset=utf-8");
    $this->Cliente->Behaviors->load('Containable');
    $data='perra';
    $i=0;
    if ($this->request->is('post')) {
      $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
      $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
      $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
      $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
      if( !empty($this->request->data['rango_fechas']) ){
          if ($fi == $ff){
              $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
          }else{
              $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
          }
      }
      if( !empty( $this->request->data['cuenta_id'] ) ){
        $cuenta_id= $this->request->data['cuenta_id'];
      }
      $leads=$this->Cliente->find('all',array(
          'conditions'=>array(
              'Cliente.cuenta_id' =>$cuenta_id,
              'Cliente.dic_linea_contacto_id <>'    => '',
              'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
              'Cliente.user_id <>'    => '',
            $cond_rangos,
            ),
            'fields' => array(
                'COUNT(Cliente.dic_linea_contacto_id) as lead',
                'Cliente.dic_linea_contacto_id'
            ),
            'group' =>'Cliente.dic_linea_contacto_id',
            'order'   => 'Cliente.dic_linea_contacto_id ASC',
            'contain' => false 
          )
      );
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
            'conditions'=>array(     
              'DicLineaContacto.cuenta_id' => $cuenta_id,
            ),
            'fields' => array(
              'DicLineaContacto.id',
              'DicLineaContacto.linea_contacto',
            ),
            'contain' => false 
            )
      );
      foreach ($dic_linea_contacto as $value_dic) {
        foreach ($leads as  $value_lead) {
            if ($value_dic['DicLineaContacto']['id']==$value_lead['Cliente']['dic_linea_contacto_id']) {
                $arreglo_clientes[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                $arreglo_clientes[$i]['leads']     = $value_lead[0]['lead'];
            }
        }
        $i++;
      }  
      $i=0;
      foreach ($arreglo_clientes as $value) {
        $clientes_mes[$i]['medio']     = $value['medio'];
        $clientes_mes[$i]['leads']     = $value['leads'];
        $i++;
      }
    }  
    if (empty($clientes_mes)) {
      $clientes_mes[$i]['medio']="medio";
      $clientes_mes[$i]['leads']=0;
    }
    echo json_encode( $clientes_mes, true );
    exit();
    $this->autoRender = false; 
  }

  /***
   * 
   * 
   * 
  */
  function clientes_ventas_inversion_dash(){
    $this->loadModel('Publicidad');
    $this->loadModel('DicLineaContacto');
    $this->loadModel('Venta');
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->load('Containable');
    $this->Venta->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $this->Publicidad->Behaviors->load('Containable');
    $leads_ventas =array();
    if ($this->request->is('post')) {
      $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
      $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
      $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
      $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
      if( !empty($this->request->data['rango_fechas']) ){
          if ($fi == $ff){
              // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
              $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
              $cond_rangos_ventas = array("Venta.fecha LIKE '".$fi."%'");
              $cond_rangos = array("Cliente.created LIKE '".$fi."%'");

          }else{
              // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
              $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
              $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
              $cond_rangos_ventas=array("Venta.fecha BETWEEN ? AND ?" => array($fi, $ff));
          }
      }
      if( !empty( $this->request->data['cuenta_id'] ) ){
        $cuenta_id= $this->request->data['cuenta_id'];
      }
      $search_inmueble=$this->Desarrollo->find('all',
        array(
            'conditions' => array('Desarrollo.cuenta_id' => $cuenta_id ),
            'fields' => array(
                'Desarrollo.id',
            ),
            'contain' => false
        )
      );
      foreach ($search_inmueble as  $value) {
        $desarrollos_id = $desarrollos_id.$value['Desarrollo']['id']."," ;
      }
      $desarrollos_id = substr($desarrollos_id,0,-1); 
      // $leads=$this->Lead->find('all',array(
      //   'conditions'=>array(
      //       'Lead.desarrollo_id IN ('.$desarrollos_id.')',
      //       'Lead.dic_linea_contacto_id <>'    => '',
      //       $cond_rangos,
      //     ), 
      //     'fields' => array(
      //       'COUNT(Lead.dic_linea_contacto_id) as lead',
      //       'Lead.dic_linea_contacto_id'
      //   ),
      //   'group'   =>'Lead.dic_linea_contacto_id',
      //   'order'   => 'Lead.dic_linea_contacto_id ASC',
      //   'contain' => false 
      //   )
      // );
      $leads=$this->Cliente->find('all',array(
          'conditions'=>array(
              'Cliente.cuenta_id' =>$cuenta_id,
              'Cliente.dic_linea_contacto_id <>'    => '',
              'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
              'Cliente.user_id <>'    => '',
            $cond_rangos,
            ),
            'fields' => array(
                'COUNT(Cliente.dic_linea_contacto_id) as lead',
                'Cliente.dic_linea_contacto_id'
            ),
            'group' =>'Cliente.dic_linea_contacto_id',
            'order'   => 'Cliente.dic_linea_contacto_id ASC',
            'contain' => false 
          )
      );
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(     
          'DicLineaContacto.cuenta_id' => $cuenta_id,
        ),
        'fields' => array(
          'DicLineaContacto.id',
          'DicLineaContacto.linea_contacto',
        ),
        'contain' => false 
        )
      );
      $inversion=$this->User->query(
          "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
          FROM publicidads, dic_linea_contactos
          WHERE publicidads.cuenta_id=$cuenta_id
          AND publicidads.fecha_inicio >= '$fi'
          AND  publicidads.fecha_inicio <= '$ff'
          AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
          GROUP BY linea_contacto;"
      );    
      $ventas= $this->User->query(
            "SELECT COUNT(clientes.dic_linea_contacto_id) AS venta ,clientes.dic_linea_contacto_id
            FROM ventas, clientes
            WHERE ventas.cuenta_id = $cuenta_id
            AND clientes.id = ventas.cliente_id
            AND  ventas.fecha >= '$fi' 
            AND  ventas.fecha <= '$ff'
            GROUP BY clientes.dic_linea_contacto_id;"
      );
      $arreglo_ventas=array();
      $i=0;
      foreach ($dic_linea_contacto as $value_dic) {
            foreach ($leads as  $value_lead) {
                if ($value_dic['DicLineaContacto']['id']==$value_lead['Cliente']['dic_linea_contacto_id']) {
                    $arreglo_ventas[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                    $arreglo_ventas[$i]['leads']     = $value_lead[0]['lead'];
                    $arreglo_ventas[$i]['inversion'] = 0;
                    $arreglo_ventas[$i]['ventas']    = 0;
                }
            }
            foreach ($inversion as $value_inv) {
                if ($value_dic['DicLineaContacto']['id']==$value_inv['dic_linea_contactos']['id']) {
                    $arreglo_ventas[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                    $arreglo_ventas[$i]['inversion'] = $value_inv[0]['inversion'];
                    if ( $arreglo_ventas[$i]['leads'] == 0) {
                        $arreglo_ventas[$i]['leads'] = 0;
                    }

                }
            }
            foreach ($ventas as $value_eve) {
                if ($value_dic['DicLineaContacto']['id']==$value_eve['clientes']['dic_linea_contacto_id']) {
                    //$array_leads[$i]['id']=$value_dic['DicLineaContacto']['id'];
                    $arreglo_ventas[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                    if ( $arreglo_ventas[$i]['leads'] == 0) {
                        $arreglo_ventas[$i]['leads'] = 0;
                    }
                    if (  $arreglo_ventas[$i]['inversion']==0) {
                        $arreglo_ventas[$i]['inversion']=0;
                    }
                   
                    $arreglo_ventas[$i]['ventas']= $value_eve[0]['venta'];
                }
            }
            $i++;
            //{"DicLineaContacto":{"id":"1","linea_contacto":"Brochure"}
            //"0":{"lead":"1"},"Lead":{"dic_linea_contacto_id":"2"}
            //{"0":{"venta":"1"},"clientes":{"dic_linea_contacto_id":"4"}
            //{"Publicidad":{"inversion_prevista":"6500","dic_linea_contacto_id":"36"}
      }
      $i=0;
      $leads_ventas=array();
      foreach ($arreglo_ventas as $value) {
          $leads_ventas[$i]['medio']     = $value['medio'];
          $leads_ventas[$i]['leads']     = $value['leads'];
          $leads_ventas[$i]['inversion'] = $value['inversion'];
          $leads_ventas[$i]['ventas']    = ( empty($value['ventas']) ? 0 : $value['ventas'] );
          $i++;
      }
      
    }
    if (empty($leads_ventas)) {
        $leads_ventas[$i]['medio']     = "medio";
        $leads_ventas[$i]['leads']     = 0;
        $leads_ventas[$i]['inversion'] = 0;
        $leads_ventas[$i]['ventas']    = 0;
    }
    echo json_encode( $leads_ventas, true );
    exit();
    $this->autoRender = false; 
  }

  /***
  * 
  * 
  * 
  */
  function clientes_visitas_linea_dash(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('Publicidad');
    $this->loadModel('DicLineaContacto');
    $this->loadModel('Lead');
    $this->loadModel('Event');
    $this->Lead->Behaviors->load('Containable');
    $this->Event->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $this->Publicidad->Behaviors->load('Containable');
    $i=0;
    $arreglo_leads_visitas=array();

    if ($this->request->is('post')) {
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if( !empty($this->request->data['rango_fechas']) ){
            if ($fi == $ff){
                // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
                $cond_rangos_ventas = array("Event.fecha_inicio LIKE '".$fi."%'");

            }else{
                // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos_event=array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
            }
        }
        if( !empty( $this->request->data['cuenta_id'] ) ){
          $cuenta_id= $this->request->data['cuenta_id'];
        }
        $leads=array();
        $i=0;
        $aux=0;
        $leads=$this->Cliente->find('all',array(
          'conditions'=>array(
              'Cliente.cuenta_id' =>$cuenta_id,
              'Cliente.dic_linea_contacto_id <>'    => '',
              'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
              'Cliente.user_id <>'    => '',
              $cond_rangos,
            ),
            'fields' => array(
                'COUNT(Cliente.dic_linea_contacto_id) as lead',
                'Cliente.dic_linea_contacto_id'
            ),
            'group' =>'Cliente.dic_linea_contacto_id',
            'order'   => 'Cliente.dic_linea_contacto_id ASC',
            'contain' => false 
          )
        );
        $search_inmueble=$this->Desarrollo->find('all',
          array(
              'conditions' => array('Desarrollo.cuenta_id' => $cuenta_id ),
              'fields' => array(
                  'Desarrollo.id',
              ),
              'contain' => false
          )
        );
        foreach ($search_inmueble as  $value) {
          $desarrollos_id = $desarrollos_id.$value['Desarrollo']['id']."," ;
        }
        $desarrollos_id = substr($desarrollos_id,0,-1); 
        // $leads=$this->Lead->find('all',array(
        //   'conditions'=>array(
        //       'Lead.desarrollo_id IN ('.$desarrollos_id.')',
        //       'Lead.dic_linea_contacto_id <>'    => '',
        //       $cond_rangos,
        //     ), 
        //     'fields' => array(
        //       'COUNT(Lead.dic_linea_contacto_id) as lead',
        //       'Lead.dic_linea_contacto_id'
        //   ),
        //   'group'   =>'Lead.dic_linea_contacto_id',
        //   'order'   => 'Lead.dic_linea_contacto_id ASC',
        //   'contain' => false 
        //   )
        // );
        $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
            'conditions'=>array(     
              'DicLineaContacto.cuenta_id' => $cuenta_id,
            ),
            'fields' => array(
              'DicLineaContacto.id',
              'DicLineaContacto.linea_contacto',
            ),
            'contain' => false 
            )
        );
        $inversion=$this->User->query(
            "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
            FROM publicidads, dic_linea_contactos
            WHERE publicidads.cuenta_id=$cuenta_id
            AND publicidads.fecha_inicio >= '$fi'
            AND  publicidads.fecha_inicio <= '$ff'
            AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
            GROUP BY linea_contacto;"
        );
        $events= $this->Event->query(
            "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
            ,clientes.dic_linea_contacto_id
            FROM events, clientes,  dic_linea_contactos
            WHERE events.cuenta_id = $cuenta_id
            AND clientes.id =  events.cliente_id
            AND events.tipo_tarea =1
            AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
            AND  events.fecha_inicio >= '$fi' 
            AND  events.fecha_inicio <= '$ff'
            GROUP BY clientes.dic_linea_contacto_id;"
        );
        $i=0;
        foreach ($dic_linea_contacto as $value_dic) {
          if ( $value_dic['DicLineaContacto']['linea_contacto'] != null ) {
          
            foreach ($leads as $lead) {
              if ($value_dic['DicLineaContacto']['id'] == $lead['Cliente']['dic_linea_contacto_id']) {
                $leads[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                $leads[$i]['leads']=$lead[0]['lead'];
                $leads[$i]['inversion']=0;
                $leads[$i]['visita']=0;
              }
            }//0: {lead: '29'}Cliente: {dic_linea_contacto_id: '1706'}
            foreach ($inversion as $inver) {
              if ($value_dic['DicLineaContacto']['id']==$inver['dic_linea_contactos']['id']) {
                $leads[$i]['medio'] = $value_dic['DicLineaContacto']['linea_contacto'];
                    if ( $leads[$i]['leads'] == 0) {
                      $leads[$i]['leads'] = 0;
                    }
                    $leads[$i]['inversion'] = $inver[0]['inversion'];
                    
                  }
                }
                foreach ($events as $value_eve) {
                  if ($value_dic['DicLineaContacto']['id']==$value_eve['clientes']['dic_linea_contacto_id']) {
                    $leads[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                    if ( $leads[$i]['leads'] == 0) {
                      $leads[$i]['leads'] = 0;
                    }
                    if (  $leads[$i]['inversion']==0) {
                      $leads[$i]['inversion']=0;
                    }
                    
                    $leads[$i]['visita']= $value_eve[0]['visita'];
                  }
                }
                $i++;
          }
        }
        $i=0;
        $arreglo_leads_visitas=array();
        foreach ($leads as  $value) {
            if ($value['medio'] != null ) {
              # code...
              $arreglo_leads_visitas[$i]['medio']     = ( empty($value['medio']) ? 0 : $value['medio'] );
              $arreglo_leads_visitas[$i]['leads']     = ( empty($value['leads']) ? 0 : $value['leads'] );
              $arreglo_leads_visitas[$i]['inversion'] = ( empty($value['inversion']) ? 0 : $value['inversion'] );
              $arreglo_leads_visitas[$i]['visitas']   = ( empty($value['visita']) ? 0 : $value['visita'] );
              $i++;
            }
        }
    }
   
    if (empty($arreglo_leads_visitas)) {

        $arreglo_leads_visitas[$i]['leads']     = 0;
        $arreglo_leads_visitas[$i]['medio']     = "medio";
        $arreglo_leads_visitas[$i]['inversion'] = 0;
        $arreglo_leads_visitas[$i]['visitas']   = 0;

    }
   
    echo json_encode( $arreglo_leads_visitas , true );
    exit();
    $this->autoRender = false;
  } 

  /**
   * 
   * 
   * 
  */
  function asignacion_clientes_asesor(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $response=array();
    $i=0;
    if ($this->request->is('post')) {
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
      }
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id=$this->request->data['user_id'] ;
      }
      $clientes_asignados = $this->Cliente->query(
        "SELECT COUNT(*) AS asignados, DATE_FORMAT(clientes.created,'%m-%Y') As fecha
        FROM clientes 
        WHERE user_id = $user_id 
        AND created >= '$fi' 
        AND created <= '$ff' 
        GROUP BY fecha;"
      );
      foreach ($clientes_asignados as $value) {
        $response[$i]['asignados']=$value[0]['asignados'];
        $response[$i]['fecha']=$value[0]['fecha'];
        $i++;
      }
      // [{"asignados":"1","fecha":"2022-03"}]
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
  function asignacion_clientes_asesor_desarrollo(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $response=array();
    $i=0;
    if ($this->request->is('post')) {
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
      }
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id=$this->request->data['user_id'] ;
      }
      $clientes_asignados_desarrollos = $this->Cliente->query(
        "SELECT COUNT(*) AS clientes, desarrollos.nombre 
        FROM clientes,desarrollos 
        WHERE desarrollos.id = clientes.desarrollo_id 
        AND clientes.user_id = $user_id 
        AND clientes.created >= '$fi' 
        AND clientes.created <= '$ff' 
        GROUP BY clientes.desarrollo_id 
        ORDER BY clientes DESC;"
      );
      foreach ($clientes_asignados_desarrollos as $value) {
        $response[$i]['asignados']=$value[0]['clientes'];
        $response[$i]['desarrollos']=$value['desarrollos']['nombre'];
        $i++;
      }
      // [{"0":{"clientes":"65"},"desarrollos":{"nombre":"NOVA SAN ANGEL"}}]
    }
    // $fi='2021-10-01 00:00:00';
    // $ff='2022-10-21 23:59:59';
    // $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
    // $user_id=630;
    // $clientes_asignados_desarrollos = $this->Cliente->query(
    //   "SELECT COUNT(*) AS clientes, desarrollos.nombre 
    //   FROM clientes,desarrollos 
    //   WHERE desarrollos.id = clientes.desarrollo_id 
    //   AND clientes.user_id = $user_id 
    //   AND clientes.created >= '$fi' 
    //   AND clientes.created <= '$ff' 
    //   GROUP BY clientes.desarrollo_id 
    //   ORDER BY clientes DESC;"
    // );
    if (empty($response)) {
      $response[$i]['asignados']=0;
      $response[$i]['desarrollos']='sin informacion';
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
  function asiganacion_reasignacion(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $response=array();
    $response_a_r=array();
    $i=0;
    if ($this->request->is('post')) {
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
      }
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id=$this->request->data['user_id'] ;
      }
      $periodos = $this->getPeriodosArreglo($fi,$ff);

      $clientes_asignados = $this->Cliente->query(
        "SELECT COUNT(*) AS asignados, DATE_FORMAT(clientes.created,'%m-%Y') As fecha
        FROM clientes 
        WHERE user_id = $user_id 
        AND created >= '$fi' 
        AND created <= '$ff' 
        GROUP BY fecha;"
      );
      $asignados_tedieron = $this->Cliente->query(
        "SELECT COUNT(*) AS asignados, DATE_FORMAT(reasignacions.fecha,'%m-%Y') As periodo
        FROM reasignacions 
        WHERE asesor_nuevo = $user_id 
        AND fecha >= '$fi' 
        AND fecha <= '$ff'
        GROUP BY periodo"
      );
      $reasignados_tequitaron = $this->Cliente->query(
        "SELECT COUNT(*) AS reasignados, DATE_FORMAT(reasignacions.fecha,'%m-%Y') As periodo
        FROM reasignacions 
        WHERE asesor_original = $user_id 
        AND fecha >= '$fi' 
        AND fecha <= '$ff'
        GROUP BY periodo"
      );
      foreach ($periodos as $key => $value) {
        foreach ($clientes_asignados as  $cliente) {
          if ($cliente[0]['fecha']==$value) {
            $response[$i]['periodo']=$value;
            $response[$i]['clientes']=$cliente[0]['asignados'];
            $response[$i]['tedieron']=0;
            $response[$i]['tequitaron']=0;
          }
        foreach ($asignados_tedieron as  $tedieron) {
          if ($tedieron[0]['periodo']==$value) {
            $response[$i]['periodo']=$value;
            if ($response[$i]['clientes'] == 0) {
              $response[$i]['clientes']=0;
            }
            $response[$i]['tedieron']=$tedieron[0]['asignados'];
          }
        }
        foreach ($reasignados_tequitaron as  $tequitaron) {
          if ($tequitaron[0]['periodo']==$value) {
            $response[$i]['periodo']=$value;
            if ($response[$i]['clientes'] == 0) {
              $response[$i]['clientes']=0;
            }
            if ($response[$i]['tedieron'] == 0) {
              $response[$i]['tedieron']=0;
            }
            $response[$i]['tequitaron']=$tequitaron[0]['reasignados'];
          }
        }

        }
        $i++;
      }
      $i=0;
      foreach ($response as  $value) {
        $response_a_r[$i]['periodo']=$value['periodo'];
        $response_a_r[$i]['clientes']=$value['clientes'];
        $response_a_r[$i]['tedieron']=$value['tedieron'];
        $response_a_r[$i]['tequitaron']=$value['tequitaron'];
        $response_a_r[$i]['totales']=$value['clientes'] + $value['tedieron']
        - $value['tequitaron'];
        $i++;
      }
    }
    // $fi='2021-10-01 00:00:00';
    // $ff='2022-10-21 23:59:59';
    // $user_id=630;
    // $periodos = $this->getPeriodosArreglo($fi,$ff);

    // $clientes_asignados = $this->Cliente->query(
    //   "SELECT COUNT(*) AS asignados, DATE_FORMAT(clientes.created,'%m-%Y') As fecha
    //   FROM clientes 
    //   WHERE user_id = $user_id 
    //   AND created >= '$fi' 
    //   AND created <= '$ff' 
    //   GROUP BY fecha;"
    // );
    // $asignados_tedieron = $this->Cliente->query(
    //   "SELECT COUNT(*) AS asignados, DATE_FORMAT(reasignacions.fecha,'%m-%Y') As periodo
    //   FROM reasignacions 
    //   WHERE asesor_nuevo = $user_id 
    //   AND fecha >= '$fi' 
    //   AND fecha <= '$ff'
    //   GROUP BY periodo"
    // );
    // $reasignados_tequitaron = $this->Cliente->query(
    //   "SELECT COUNT(*) AS reasignados, DATE_FORMAT(reasignacions.fecha,'%m-%Y') As periodo
    //   FROM reasignacions 
    //   WHERE asesor_original = $user_id 
    //   AND fecha >= '$fi' 
    //   AND fecha <= '$ff'
    //   GROUP BY periodo"
    // );
    // foreach ($periodos as $key => $value) {
    //   foreach ($clientes_asignados as  $cliente) {
    //     if ($cliente[0]['fecha']==$value) {
    //       $response[$i]['periodo']=$value;
    //       $response[$i]['clientes']=$cliente[0]['asignados'];
    //       $response[$i]['tedieron']=0;
    //       $response[$i]['tequitaron']=0;
    //     }
    //   foreach ($asignados_tedieron as  $tedieron) {
    //     if ($tedieron[0]['periodo']==$value) {
    //       $response[$i]['periodo']=$value;
    //       if ($response[$i]['clientes'] == 0) {
    //         $response[$i]['clientes']=0;
    //       }
    //       $response[$i]['tedieron']=$tedieron[0]['asignados'];
    //     }
    //   }
    //   foreach ($reasignados_tequitaron as  $tequitaron) {
    //     if ($tequitaron[0]['periodo']==$value) {
    //       $response[$i]['periodo']=$value;
    //       if ($response[$i]['clientes'] == 0) {
    //         $response[$i]['clientes']=0;
    //       }
    //       if ($response[$i]['tedieron'] == 0) {
    //         $response[$i]['tedieron']=0;
    //       }
    //       $response[$i]['tequitaron']=$tequitaron[0]['reasignados'];
    //     }
    //   }

    //   }
    //   $i++;
    // }
    // $i=0;
    // foreach ($response as  $value) {
    //   $response_a_r[$i]['periodo']=$value['periodo'];
    //   $response_a_r[$i]['clientes']=$value['clientes'];
    //   $response_a_r[$i]['tedieron']=$value['tedieron'];
    //   $response_a_r[$i]['tequitaron']=$value['tequitaron'];
    //   $response_a_r[$i]['totales']=$value['clientes'] + $value['tedieron']
    //    - $value['tequitaron'];
    //   $i++;
    // }

    if (empty($response_a_r)) {
      $response_a_r[$i]['periodo']    = 0;
      $response_a_r[$i]['clientes']   = 'sin informacion';
      $response_a_r[$i]['tedieron']   = 'sin informacion';
      $response_a_r[$i]['tequitaron'] = 'sin informacion';
      $response_a_r[$i]['totales']    = 'sin informacion';
    }
    // {"asignados":"1","fecha":"03-2022"}
    // {"asignados":"1","periodo":"05-2022"
    //"reasignados":"2","periodo":"05-2022" 
    echo json_encode( $response_a_r , true );
    exit();
    $this->autoRender = false;
  }

  /**
   * 
   * 
  */
  function motivos_reasignaciones(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('Reasignacion');
    $this->Reasignacion->Behaviors->load('Containable');
    $response=array();
    $i=0;
    if ($this->request->is('post')) {
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
      }
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id=$this->request->data['user_id'] ;
      }
      $motivos_reasignaciones = $this->User->query(
        "SELECT COUNT(*) AS reasignaciones, motivo_cambio 
        FROM reasignacions 
        WHERE (asesor_original = $user_id OR asesor_nuevo = $user_id) 
        AND motivo_cambio IS NOT NULL 
        AND fecha >= '$fi' 
        AND fecha <= '$ff' 
        GROUP BY motivo_cambio;"
      );
      foreach ($motivos_reasignaciones as  $value) {
        $response[$i]['cantidad']=$value[0]['reasignaciones'];
        $response[$i]['motivo']=$value['reasignacions']['motivo_cambio'];
        // $response[$i]['']=$value[0][''];
        // $response[$i]['']=$value[0][''];
        $i++;
      }
    }
    // $response=array();
    // $i=0;
    // $fi='2021-10-01 00:00:00';
    // $ff='2022-10-21 23:59:59';
    // $user_id=630;
    // $motivos_reasignaciones = $this->User->query(
    //   "SELECT COUNT(*) AS reasignaciones, motivo_cambio 
    //   FROM reasignacions 
    //   WHERE (asesor_original = $user_id OR asesor_nuevo = $user_id) 
    //   AND motivo_cambio IS NOT NULL 
    //   AND fecha >= '$fi' 
    //   AND fecha <= '$ff' 
    //   GROUP BY motivo_cambio;"
    // );
    // foreach ($motivos_reasignaciones as  $value) {
    //   $response[$i]['cantidad']=$value[0]['reasignaciones'];
    //   $response[$i]['motivo']=$value['reasignacions']['motivo_cambio'];
    //   // $response[$i]['']=$value[0][''];
    //   // $response[$i]['']=$value[0][''];
    //   $i++;
    // }
    if (empty($response)) {
      $response[$i]['cantidad']    = 100;
      $response[$i]['motivo']   = 'sin informacion';
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
   * 
   * 
   * 
  */
  function medios_clientes_definitivos(){
    header('Content-type: application/json; charset=utf-8');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $response    = [];
    $fecha_ini   = '';
    $fecha_fin   = '';
    $i           = 0;
    $and         = [];
    $or          = [];
    $condiciones = array();
    if($this->request->is('post')){
      
      $cuenta_id=$this->request->data['cuenta_id'];
       // Filttros base
      array_push($and,
        array(
          'Cliente.user_id <>'    => '',
        )
      );
     
     array_push($or,
      array(
        'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
        'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
      )
     );
      // Fin de filtros base

      // Condicion para el rango de fechas
     
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
        }else{
            $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
      }

      // Condicion para el desarrollo id.
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' => $desarrollo_id ));
      }

      // Condicion para el asesor id.
      if( !empty( $this->request->data['user_id'] ) ){
        array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
      }

      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      ); 
      $clientes_totales=$this->Cliente->find('all',array(
        'conditions'=>array(
            'Cliente.dic_linea_contacto_id <>'    => '',
            $condiciones
        ),
        'fields' => array(
            'COUNT(Cliente.dic_linea_contacto_id) as clientes',
            'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
        )
      );
      $clientes_activos=$this->Cliente->find('all',array(
        'conditions'=>array(
            'Cliente.status'      => 'Activo',
            'Cliente.dic_linea_contacto_id <>'    => '',
            $condiciones
        ),
        'fields' => array(
            'COUNT(Cliente.dic_linea_contacto_id) as activo',
            'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
        )
      );
      $clientes_inactivos_temporales=$this->Cliente->find('all',array(
        'conditions'=>array(
            'Cliente.status'      => 'Inactivo temporal',
            'Cliente.dic_linea_contacto_id <>'    => '',
            $condiciones
        ),
        'fields' => array(
            'COUNT(Cliente.dic_linea_contacto_id) as temporal',
            'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
        )
      );
      $clientes_inactivos=$this->Cliente->find('all',array(
        'conditions'=>array(
            'Cliente.status'      => 'Inactivo',
            'Cliente.dic_linea_contacto_id <>'    => '',
            $condiciones
        ),
        'fields' => array(
            'COUNT(Cliente.dic_linea_contacto_id) as inactivo',
            'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
        )
      );
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(     
          'DicLineaContacto.cuenta_id' => $cuenta_id,
        ),
        'fields' => array(
          'DicLineaContacto.id',
          'DicLineaContacto.linea_contacto',
        ),
        'contain' => false 
        )
      );

      foreach ($dic_linea_contacto as  $dic) {
        foreach ($clientes_totales as $total) {
          if ($dic['DicLineaContacto']['id']==$total['Cliente']['dic_linea_contacto_id']) {
            $clientes[$i]['medio']    = $dic['DicLineaContacto']['linea_contacto'];
            $clientes[$i]['total']    = $total[0]['clientes'];
            $clientes[$i]['activos']  = 0;
            $clientes[$i]['temporal'] = 0;
            $clientes[$i]['inactivo'] = 0;
          }
        }
        foreach ($clientes_activos as $activo) {
          if ($dic['DicLineaContacto']['id']==$activo['Cliente']['dic_linea_contacto_id']) {
            $clientes[$i]['medio'] = $dic['DicLineaContacto']['linea_contacto'];
            if ($clientes[$i]['total']== 0) {
              $clientes[$i]['total'] =0 ;
            }
            $clientes[$i]['activos']= $activo[0]['activo'];
          }
        }
        foreach ($clientes_inactivos_temporales as $temporale) {
          if ($dic['DicLineaContacto']['id']==$temporale['Cliente']['dic_linea_contacto_id']) {
            $clientes[$i]['medio'] = $dic['DicLineaContacto']['linea_contacto'];
            if ($clientes[$i]['total']== 0) {
              $clientes[$i]['total'] =0; 
            }
            if ($clientes[$i]['activos']== 0) {
              $clientes[$i]['activos'] =0 ;
            }
            $clientes[$i]['temporal']=$temporale[0]['temporal'];
          }
        }
        foreach ($clientes_inactivos as $inactivo) {
          if ($dic['DicLineaContacto']['id']==$inactivo['Cliente']['dic_linea_contacto_id']) {
            $clientes[$i]['medio'] = $dic['DicLineaContacto']['linea_contacto'];
            if ($clientes[$i]['total']== 0) {
              $clientes[$i]['total'] =0 ;
            }
            if ($clientes[$i]['activos']== 0) {
              $clientes[$i]['activos'] =0 ;
            }
            if ($clientes[$i]['temporal']== 0) {
              $clientes[$i]['temporal'] =0 ;
            }
            $clientes[$i]['inactivo']=$inactivo[0]['inactivo'];
          }
        }
        $i++;
      }
      $i=0;
      // ( empty($value['inactivo']) ? 0  :  $value['inactivo'] )
      foreach ($clientes as $value) {
        $response[$i]['medio']    = $value['medio'];
        $response[$i]['total']    =  ( empty($value['total']) ? 0  :  $value['total'] );
        $response[$i]['activos']  = ( empty($value['activos']) ? 0  :  $value['activos'] );
        $response[$i]['temporal'] = ( empty($value['temporal']) ? 0  :  $value['temporal'] );
        $response[$i]['inactivo'] = ( empty($value['inactivo']) ? 0  :  $value['inactivo'] );
        $i++;
      }
    }
    
    if (empty($response)) {
      $response[$i]['medio']    = 'sin informacion';
      $response[$i]['total']    = 0;
      $response[$i]['activos']  = 0;
      $response[$i]['temporal'] = 0;
      $response[$i]['inactivo'] = 0;
      
    }
    echo json_encode( $response , true );
    exit();
    $this->autoRender = false;
  }

  /**
   * 
   * 
  */
  function medios_clientes_ventas_ventas(){
    header('Content-type: application/json; charset=utf-8');
		$this->loadModel('Venta');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $response    = [];
    $fecha_ini   = '';
    $fecha_fin   = '';
    $i           = 0;
    $and         = [];
    $or          = [];
    $condiciones = array();
    $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    if($this->request->is('post')){
      $cuenta_id=$this->request->data['cuenta_id'];
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
          $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");

        }else{
          $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));

        } 
      }
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' =>$desarrollo_id));
        $ventas=$this->User->query(
          "SELECT  COUNT(clientes.dic_linea_contacto_id) AS venta ,clientes.dic_linea_contacto_id
          FROM operaciones_inmuebles, clientes
          WHERE operaciones_inmuebles.fecha >= '$fi' 
          AND operaciones_inmuebles.fecha <= '$ff' 
          AND operaciones_inmuebles.tipo_operacion=3
          AND clientes.id = operaciones_inmuebles.cliente_id
          AND operaciones_inmuebles.dic_cancelacion_id is null
          AND operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)
          GROUP BY  clientes.dic_linea_contacto_id;"
        );
        $visitas= $this->Event->query(
          "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
          ,clientes.dic_linea_contacto_id
          FROM events, clientes,  dic_linea_contactos
          WHERE events.desarrollo_id = $desarrollo_id
          and events.cuenta_id = $cuenta_id
          AND clientes.id =  events.cliente_id
          AND events.tipo_tarea =1
          AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
          AND  events.fecha_inicio >= '$fi' 
          AND  events.fecha_inicio <= '$ff'
          GROUP BY clientes.dic_linea_contacto_id;"
        );
        $citas= $this->Event->query(
          "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas, clientes.dic_linea_contacto_id
          FROM events, clientes
          WHERE events.desarrollo_id =$desarrollo_id 
          and events.cuenta_id = $cuenta_id
          AND clientes.id =  events.cliente_id
          AND events.tipo_tarea =0
          AND  events.fecha_inicio >= '$fi' 
          AND  events.fecha_inicio <= '$ff'
          GROUP BY clientes.dic_linea_contacto_id;"
        );
      }  
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id= $this->request->data['user_id'];
        array_push($and, array('Cliente.user_id' => $user_id,));
        $ventas=$this->User->query(
          "SELECT  COUNT(clientes.dic_linea_contacto_id) AS venta ,clientes.dic_linea_contacto_id
          FROM operaciones_inmuebles, clientes
          WHERE operaciones_inmuebles.fecha >= '$fi' 
          AND operaciones_inmuebles.fecha <= '$ff' 
          AND operaciones_inmuebles.tipo_operacion=3
          AND operaciones_inmuebles.user_id=$user_id
          AND clientes.id = operaciones_inmuebles.cliente_id
          AND operaciones_inmuebles.dic_cancelacion_id is null
          GROUP BY  clientes.dic_linea_contacto_id;"
        );
        $visitas= $this->Event->query(
          "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
          ,clientes.dic_linea_contacto_id
          FROM events, clientes,  dic_linea_contactos
          WHERE events.user_id = $user_id
          and events.cuenta_id = $cuenta_id
          AND clientes.id =  events.cliente_id
          AND events.tipo_tarea =1
          AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
          AND  events.fecha_inicio >= '$fi' 
          AND  events.fecha_inicio <= '$ff'
          GROUP BY clientes.dic_linea_contacto_id;"
        );
      }
      $clientes=$this->Cliente->find('all',array(
        'conditions'=>array(
            'Cliente.desarrollo_id' =>$desarrollo_id,
            'Cliente.dic_linea_contacto_id <>'    => '',
            'Cliente.cuenta_id' => $cuenta_id,
            'Cliente.user_id <>'    => '',
          $cond_rangos,
          ),
          'fields' => array(
              'COUNT(Cliente.dic_linea_contacto_id) as lead',
              'Cliente.dic_linea_contacto_id'
          ),
          'group' =>'Cliente.dic_linea_contacto_id',
          'order'   => 'Cliente.dic_linea_contacto_id ASC',
          'contain' => false 
        )
      );
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(     
          'DicLineaContacto.cuenta_id' => $cuenta_id,
        ),
        'fields' => array(
          'DicLineaContacto.id',
          'DicLineaContacto.linea_contacto',
        ),
        'contain' => false 
        )
      );
      // $leads=$this->Lead->find('all',array(
      //   'conditions'=>array(
      //       'Lead.desarrollo_id' =>$desarrollo_id,
      //       'Lead.dic_linea_contacto_id <>'    => '',
      //       $cond_rangos,
      //     ),
      //     'fields' => array(
      //         'COUNT(Lead.dic_linea_contacto_id) as lead',
      //         'Lead.dic_linea_contacto_id'
      //     ),
      //     'group'   =>'Lead.dic_linea_contacto_id',
      //     'order'   => 'Lead.dic_linea_contacto_id ASC',
      //     'contain' => false 
      //   )
      // );
     
      foreach ($dic_linea_contacto as $linea) {
        foreach ( $clientes as $lead ) {
          if ( $linea['DicLineaContacto']['id'] == $lead['Cliente']['dic_linea_contacto_id'] ) {
            $clientes_ventas_visistas[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            $clientes_ventas_visistas[$i]['clientes']=$lead[0]['lead'];
            $clientes_ventas_visistas[$i]['citas']=0;
            $clientes_ventas_visistas[$i]['visitas']=0;
            $clientes_ventas_visistas[$i]['ventas']=0;
          }
        }
        foreach ($visitas as $visita) {
          if ( $linea['DicLineaContacto']['id'] == $visita['clientes']['dic_linea_contacto_id'] ) {
            $clientes_ventas_visistas[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            if (  $clientes_ventas_visistas[$i]['clientes']==0) {
              $clientes_ventas_visistas[$i]['clientes']=0;
            }
            $clientes_ventas_visistas[$i]['visitas']=$visita[0]['visita'];
          }
            
        }
        foreach ($ventas as  $venta) {
          if ( $linea['DicLineaContacto']['id'] == $venta['clientes']['dic_linea_contacto_id'] ) {
            $clientes_ventas_visistas[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            if (  $clientes_ventas_visistas[$i]['clientes']==0) {
              $clientes_ventas_visistas[$i]['clientes']=0;
            }
            if (  $clientes_ventas_visistas[$i]['visitas']==0) {
              $clientes_ventas_visistas[$i]['visitas']=0;
            }
            $clientes_ventas_visistas[$i]['ventas']=$venta[0]['venta'] ;
          }
        }
        foreach ($citas as  $cita) {
          if ( $linea['DicLineaContacto']['id'] == $cita['clientes']['dic_linea_contacto_id'] ) {
            $clientes_ventas_visistas[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            if (  $clientes_ventas_visistas[$i]['clientes']==0) {
              $clientes_ventas_visistas[$i]['clientes']=0;
            }
            if (  $clientes_ventas_visistas[$i]['visitas']==0) {
              $clientes_ventas_visistas[$i]['visitas']=0;
            }
            if (  $clientes_ventas_visistas[$i]['ventas']==0) {
              $clientes_ventas_visistas[$i]['ventas']=0;
            }
            $clientes_ventas_visistas[$i]['citas']=$cita[0]['citas'] ;
          }
        }
        // 0{citas: '1'}clientes{dic_linea_contacto_id: '1708'}
        $i++;
      }
      $i=0;
      foreach ($clientes_ventas_visistas as $value) {
        $response[$i]['medio']    = $value['medio'];
        $response[$i]['clientes'] = ( empty($value['clientes'] ) ? 0: $value['clientes'] );
        $response[$i]['citas']  = ( empty($value['citas'] ) ? 0 : $value['citas'] );
        $response[$i]['visitas']  = ( empty($value['visitas'] ) ? 0 : $value['visitas'] );
        $response[$i]['ventas']   = ( empty($value['ventas'] ) ? 0  :  $value['ventas'] );
        $i++;
      }

    }
    if (empty($response)) {
      $response[$i]['medio']    = 'sin informacion';
      $response[$i]['clientes']    = 0;
      $response[$i]['citas']    = 0;
      $response[$i]['visitas']    = 0;
      $response[$i]['ventas']    = 0;
      
    }
    echo json_encode( $response , true );
    exit();
    $this->autoRender = false;
  }

  /**
   * 
   * 
  */
  function medios_cliente_indefinidos_mk(){
    header('Content-type: application/json; charset=utf-8');
		$this->loadModel('Lead');
    $this->Lead->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $response    = [];
    $fecha_ini   = '';
    $fecha_fin   = '';
    $i           = 0;
    $and         = [];
    $or          = [];
    $condiciones = array();
    if($this->request->is('post')){
      array_push($and,
        array(
          'Cliente.user_id <>'    => '',
        )
      );
    
      array_push($or,
        array(
          'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
        )
      );
      
      $cuenta_id=$this->request->data['cuenta_id'];
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
          $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
          $cond_leads = array("Lead.fecha LIKE '".$fi."%'");
        }else{
          $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
          $cond_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
        }  
        array_push($and, $cond_rangos);
      }
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        foreach($this->request->data['desarrollo_id'] as $seleccion){
          if(substr($seleccion,0,1)=="D"){
              $desarrollos_id = $desarrollos_id.substr($seleccion,1).",";
          }else{
              $cluster = $this->Cluster->find('first',
                  array(
                      'fields'=>array(
                          'id'
                      ),
                      'contain'=>array(
                          'Desarrollos'=>array(
                              'fields'=>array(
                                  'cluster_id','desarrollo_id'
                              )
                          )
                      )
                  )
              );
              foreach($cluster['Desarollos'] as $desarrollo){
                  $desarrollos_id = $desarrollos_id.$desarrollo['desarrollo_id'].",";
              }
          }
        }
        $desarrollos_id = substr($desarrollos_id,0,-1);
      }  
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id= $this->request->data['user_id'];
      }
      if( !empty( $this->request->data['medio_id'] ) ){
        foreach($this->request->data['medio_id'] as $medio){
          $medios_id = $medios_id.$medio.",";
        } 
        $medios_id = substr($medios_id,0,-1);
      }
      $condiciones = array(
        'OR'  => $or
      );
      // $clientes=$this->Cliente->find('all',array(
      //   'conditions'=>array(
      //       'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
      //       'Cliente.dic_linea_contacto_id <>'    => '',
      //       'Cliente.cuenta_id' => $cuenta_id,
      //       'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
      //       'Cliente.user_id <>'    => '',
      //       $cond_rangos,
      //   ),
      //   'fields' => array(
      //     'COUNT(Cliente.dic_linea_contacto_id) as lead',
      //     'Cliente.dic_linea_contacto_id'
      //   ),
      //   'group' =>'Cliente.dic_linea_contacto_id',
      //   'order'   => 'Cliente.dic_linea_contacto_id ASC',
      //   'contain' => false 
      // ));
      $leads=$this->Lead->find('all',array(
        'conditions'=>array(
            'Lead.desarrollo_id IN ('.$desarrollos_id.')',
            'Lead.dic_linea_contacto_id <>'    => '',
            'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
            $cond_leads,
          ), 
          'fields' => array(
            'COUNT(Lead.dic_linea_contacto_id) as lead',
            'Lead.dic_linea_contacto_id'
        ),
        'group'   =>'Lead.dic_linea_contacto_id',
        'order'   => 'Lead.dic_linea_contacto_id ASC',
        'contain' => false 
        )
    );
      $inactivos=$this->Cliente->find('all',array(
        'conditions'=>array(
          'Cliente.status'      => 'Inactivo',
            'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
            'Cliente.dic_linea_contacto_id <>'    => '',
            'Cliente.cuenta_id' => $cuenta_id,
            'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
            'Cliente.user_id <>'    => '',
            $cond_rangos,
        ),
        'fields' => array(
          'COUNT(Cliente.dic_linea_contacto_id) as lead',
          'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
      ));
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(     
          'DicLineaContacto.cuenta_id' => $cuenta_id,
        ),
        'fields' => array(
          'DicLineaContacto.id',
          'DicLineaContacto.linea_contacto',
        ),
        'contain' => false 
      ));
      foreach ( $dic_linea_contacto as $linea ) {
        foreach ( $leads as $lead ) {
          if ($linea['DicLineaContacto']['id'] == $lead['Lead']['dic_linea_contacto_id']) {
            $cliente_inactivos[$i]['medio']     = $linea['DicLineaContacto']['linea_contacto'];
            $cliente_inactivos[$i]['clientes']  = $lead[0]['lead'];
            $cliente_inactivos[$i]['inactivos'] = 0;
          }
        }
        foreach ($inactivos as $inactivo) {
          if ($linea['DicLineaContacto']['id'] == $inactivo['Cliente']['dic_linea_contacto_id']) {
            $cliente_inactivos[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            if ($cliente_inactivos[$i]['clientes']==0) {
              $cliente_inactivos[$i]['clientes']=0;
            }
            $cliente_inactivos[$i]['inactivos']=$inactivo[0]['lead'];
          }
        }
        $i++;
      }
      $i=0;
      foreach ($cliente_inactivos as $value) {
        $response[$i]['medio']     = $value['medio'];
        $response[$i]['clientes']  = ( empty($value['clientes'] ) ? 0: $value['clientes'] );
        $response[$i]['inactivos'] = ( empty($value['inactivos'] ) ? 0: $value['inactivos'] );
        $i++;
      }
      //0: {lead: '40'}Cliente: {dic_linea_contacto_id: '1706'}
      //0: {lead: '30'}Cliente: {dic_linea_contacto_id: '1706'}
      // DicLineaContacto: {id: '1706', linea_contacto: 'Facebook'}
    }
    if (empty($response)) {
      $response[$i]['medio']    = 'sin informacion';
      $response[$i]['clientes']    = 0;
      $response[$i]['inactivos']    = 0;
      
    }
    echo json_encode( $response , true );
    exit();
    $this->autoRender = false;

  }
  /**
   * 
   * 
  */
  function medios_leads_cliente_activos_mk(){
    header('Content-type: application/json; charset=utf-8');
		$this->loadModel('Lead');
    $this->Lead->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $response    = [];
    $search   = '';
    $fecha_ini   = '';
    $fecha_fin   = '';
    $i           = 0;
    $and         = [];
    $or          = [];
    $condiciones = array();
    if($this->request->is('post')){
      array_push($and,
        array(
          'Cliente.user_id <>'    => '',
        )
      );
    
      array_push($or,
        array(
          'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
        )
      );
      
      $cuenta_id=$this->request->data['cuenta_id'];
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
          $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
          $cond_leads = array("Lead.fecha LIKE '".$fi."%'");
        }else{
          $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
          $cond_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
        }  
        array_push($and, $cond_rangos);
      }
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        foreach($this->request->data['desarrollo_id'] as $seleccion){
          if(substr($seleccion,0,1)=="D"){
              $desarrollos_id = $desarrollos_id.substr($seleccion,1).",";
          }else{
              $cluster = $this->Cluster->find('first',
                  array(
                      'fields'=>array(
                          'id'
                      ),
                      'contain'=>array(
                          'Desarrollos'=>array(
                              'fields'=>array(
                                  'cluster_id','desarrollo_id'
                              )
                          )
                      )
                  )
              );
              foreach($cluster['Desarollos'] as $desarrollo){
                  $desarrollos_id = $desarrollos_id.$desarrollo['desarrollo_id'].",";
              }
          }
        }
        $desarrollos_id = substr($desarrollos_id,0,-1);
      }  
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id= $this->request->data['user_id'];
      }
      if( !empty( $this->request->data['medio_id'] ) ){
        foreach($this->request->data['medio_id'] as $medio){
          $medios_id = $medios_id.$medio.",";
        } 
        $medios_id = substr($medios_id,0,-1);
      }
      $condiciones = array(
        'OR'  => $or
      );
      $leads=$this->Lead->find('all',array(
        'conditions'=>array(
            'Lead.desarrollo_id IN ('.$desarrollos_id.')',
            'Lead.dic_linea_contacto_id <>'    => '',
            'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
            $cond_leads,
          ), 
          'fields' => array(
            'COUNT(Lead.dic_linea_contacto_id) as lead',
            'Lead.dic_linea_contacto_id'
        ),
        'group'   =>'Lead.dic_linea_contacto_id',
        'order'   => 'Lead.dic_linea_contacto_id ASC',
        'contain' => false 
        )
      );
      $leads_id_clientes=$this->Lead->find('all',array(
        'conditions'=>array(
            'Lead.desarrollo_id IN ('.$desarrollos_id.')',
            'Lead.dic_linea_contacto_id <>'    => '',
            'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
            $cond_leads,
          ), 
          'fields' => array(
            'Lead.cliente_id'
        ),
        'contain' => false 
        )
      );
      foreach ($leads_id_clientes as $value) {
          $search = $search.$value['Lead']['cliente_id'].",";
      }
      $search = substr($search,0,-1);
      $activos=$this->Cliente->find('all',array(
        'conditions'=>array(
          'Cliente.status'      => 'Activo',
            'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
            'Cliente.id IN ('.$search.')',
            'Cliente.dic_linea_contacto_id <>'    => '',
            'Cliente.cuenta_id' => $cuenta_id,
            'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
            'Cliente.user_id <>'    => '',
            $cond_rangos,
        ),
        'fields' => array(
          'COUNT(Cliente.dic_linea_contacto_id) as lead',
          'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
      ));
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(     
          'DicLineaContacto.cuenta_id' => $cuenta_id,
        ),
        'fields' => array(
          'DicLineaContacto.id',
          'DicLineaContacto.linea_contacto',
        ),
        'contain' => false 
      ));
      foreach ( $dic_linea_contacto as $linea ) {
        foreach ( $leads as $lead ) {
          if ($linea['DicLineaContacto']['id'] == $lead['Lead']['dic_linea_contacto_id']) {
            $leads_activos[$i]['medio']     = $linea['DicLineaContacto']['linea_contacto'];
            $leads_activos[$i]['leads']  = $lead[0]['lead'];
            $leads_activos[$i]['activos'] = 0;
          }
        }
        foreach ($activos as $activo) {
          if ($linea['DicLineaContacto']['id'] == $activo['Cliente']['dic_linea_contacto_id']) {
            $leads_activos[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            if ($leads_activos[$i]['leads']==0) {
              $leads_activos[$i]['leads']=0;
            }
            $leads_activos[$i]['activos']=$activo[0]['lead'];
          }
        }
        $i++;
      }
      $i=0;
      // ( empty($value['activos'] ) ? 0: $value['activos'] )

      foreach ($leads_activos as $value) {
        $response[$i]['medio']   = $value['medio'];
        $response[$i]['leads']   = ( empty($value['leads'] ) ? 0: $value['leads'] );
        $response[$i]['activos'] = ( empty($value['activos'] ) ? 0: $value['activos'] );
        $i++;
      }
    }
    if (empty($response)) {
      $response[$i]['medio']    = 'sin informacion';
      $response[$i]['clientes']    = 0;
      $response[$i]['activos']    = 0;
      
    }
    echo json_encode( $response , true );
    exit();
    $this->autoRender = false;

  }
  /**
   * 
   * 
  */
  function medios_leads_cliente_temporales_mk(){
    header('Content-type: application/json; charset=utf-8');
		$this->loadModel('Lead');
    $this->Lead->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $response    = [];
    $fecha_ini   = '';
    $fecha_fin   = '';
    $i           = 0;
    $and         = [];
    $or          = [];
    $condiciones = array();
    if($this->request->is('post')){
      array_push($and,
        array(
          'Cliente.user_id <>'    => '',
        )
      );
    
      array_push($or,
        array(
          'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
        )
      );
      
      $cuenta_id=$this->request->data['cuenta_id'];
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
          $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
          $cond_leads = array("Lead.fecha LIKE '".$fi."%'");
        }else{
          $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
          $cond_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
        }  
        array_push($and, $cond_rangos);
      }
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        foreach($this->request->data['desarrollo_id'] as $seleccion){
          if(substr($seleccion,0,1)=="D"){
              $desarrollos_id = $desarrollos_id.substr($seleccion,1).",";
          }else{
              $cluster = $this->Cluster->find('first',
                  array(
                      'fields'=>array(
                          'id'
                      ),
                      'contain'=>array(
                          'Desarrollos'=>array(
                              'fields'=>array(
                                  'cluster_id','desarrollo_id'
                              )
                          )
                      )
                  )
              );
              foreach($cluster['Desarollos'] as $desarrollo){
                  $desarrollos_id = $desarrollos_id.$desarrollo['desarrollo_id'].",";
              }
          }
        }
        $desarrollos_id = substr($desarrollos_id,0,-1);
      }  
      if( !empty( $this->request->data['user_id'] ) ){
        $user_id= $this->request->data['user_id'];
      }
      if( !empty( $this->request->data['medio_id'] ) ){
        foreach($this->request->data['medio_id'] as $medio){
          $medios_id = $medios_id.$medio.",";
        } 
        $medios_id = substr($medios_id,0,-1);
      }
      $condiciones = array(
        'OR'  => $or
      );
      $leads=$this->Lead->find('all',array(
        'conditions'=>array(
            'Lead.desarrollo_id IN ('.$desarrollos_id.')',
            'Lead.dic_linea_contacto_id <>'    => '',
            'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
            $cond_leads,
          ), 
          'fields' => array(
            'COUNT(Lead.dic_linea_contacto_id) as lead',
            'Lead.dic_linea_contacto_id'
        ),
        'group'   =>'Lead.dic_linea_contacto_id',
        'order'   => 'Lead.dic_linea_contacto_id ASC',
        'contain' => false 
        )
      );
      $temporales=$this->Cliente->find('all',array(
        'conditions'=>array(
          'Cliente.status'      => 'Inactivo temporal',
            'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
            'Cliente.dic_linea_contacto_id <>'    => '',
            'Cliente.cuenta_id' => $cuenta_id,
            'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
            'Cliente.user_id <>'    => '',
            $cond_rangos,
        ),
        'fields' => array(
          'COUNT(Cliente.dic_linea_contacto_id) as lead',
          'Cliente.dic_linea_contacto_id'
        ),
        'group' =>'Cliente.dic_linea_contacto_id',
        'order'   => 'Cliente.dic_linea_contacto_id ASC',
        'contain' => false 
      ));
      $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(     
          'DicLineaContacto.cuenta_id' => $cuenta_id,
        ),
        'fields' => array(
          'DicLineaContacto.id',
          'DicLineaContacto.linea_contacto',
        ),
        'contain' => false 
      ));
      foreach ( $dic_linea_contacto as $linea ) {
        foreach ( $leads as $lead ) {
          if ($linea['DicLineaContacto']['id'] == $lead['Lead']['dic_linea_contacto_id']) {
            $leads_temporales[$i]['medio']     = $linea['DicLineaContacto']['linea_contacto'];
            $leads_temporales[$i]['leads']  = $lead[0]['lead'];
            $leads_temporales[$i]['temporales'] = 0;
          }
        }
        foreach ($temporales as $temporale) {
          if ($linea['DicLineaContacto']['id'] == $temporale['Cliente']['dic_linea_contacto_id']) {
            $leads_temporales[$i]['medio']=$linea['DicLineaContacto']['linea_contacto'];
            if ($leads_temporales[$i]['leads']==0) {
              $leads_temporales[$i]['leads']=0;
            }
            $leads_temporales[$i]['temporales']=$temporale[0]['lead'];
          }
        }
        $i++;
      }
      $i=0;
      // ( empty($value['temporales'] ) ? 0: $value['temporales'] )

      foreach ($leads_temporales as $value) {
        $response[$i]['medio']      = $value['medio'];
        $response[$i]['leads']      = ( empty($value['leads'] ) ? 0: $value['leads'] );
        $response[$i]['temporales'] = ( empty($value['temporales'] ) ? 0: $value['temporales'] );
        $i++;
      }
    }
    if (empty($response)) {
      $response[$i]['medio']    = 'sin informacion';
      $response[$i]['clientes']    = 0;
      $response[$i]['temporales']    = 0;
      
    }
    echo json_encode( $response , true );
    exit();
    $this->autoRender = false;

  }

  // Para el embudo de ventas
  function grafica_clintes_etapa(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('DesarrolloInmueble');
    $this->loadModel('OperacionesInmueble');
    $this->Desarrollo->Behaviors->load('Containable');
    $this->OperacionesInmueble->Behaviors->load('Containable');
    $this->DesarrolloInmueble->Behaviors->load('Containable');
    $condiciones                = [];
    $fecha_ini                  = '';
    $fecha_fin                  = '';
    $and                        = [];
    $logand                        = [];
    $or                         = [];
    $inmuebles=[];
    $inmuebles_id='';
    $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    // $cuenta_id= $this->request->data['cuenta_id'];
    if ($this->request->is('post')) {
      // Filttros base
        array_push($and,
          array(
            'Cliente.user_id <>'    => '',
          )
        );
        
        array_push($or,
          array(
            'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
          )
        );
      // Fin de filtros base

      // Condicion para el rango de fechas
      if( !empty($this->request->data['rango_fechas']) ){
        $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
        $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
        $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
        $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
        if ($fi == $ff){
            $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
            $cond_log    = array("LogClientesEtapa.fecha LIKE '".$fi."%'");
        }else{
          $cond_log    = array("LogClientesEtapa.fecha BETWEEN ? AND ?" => array($fi, $ff));
          $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?"        => array($fi, $ff));
        }
        array_push($and, $cond_rangos);
        array_push($logand, $cond_log);
      }

      // Condicion para el desarrollo id.
      if( !empty( $this->request->data['desarrollo_id'] ) ){
        $substr_desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
        array_push($and, array('Cliente.desarrollo_id' => $substr_desarrollo_id ));
        array_push($logand, array('LogClientesEtapa.desarrollo_id'=>$substr_desarrollo_id,));
        $desarrollos=$this->Desarrollo->find('all',array(
          'conditions'=>array(
              'Desarrollo.id !='=> $substr_desarrollo_id,
              'Desarrollo.cuenta_id'=>$cuenta_id,        
          ),
          'fields'=>array(
              'id'
          ),
          'contain'=>false
        ));
        foreach ($desarrollos as  $value) {
          $id=$id.$value['Desarrollo']['id'].",";
        }
        $id = substr($id,0,-1);
        $clientes_etapa7=$this->Cliente->query(
          "SELECT COUNT(*) AS etapa7 FROM clientes, operaciones_inmuebles
          WHERE clientes.desarrollo_id=$substr_desarrollo_id
          AND operaciones_inmuebles.cliente_id=clientes.id
          AND operaciones_inmuebles.fecha>= '$fi'
          AND operaciones_inmuebles.fecha<= '$ff'
          AND operaciones_inmuebles.tipo_operacion=3
          AND operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id=$substr_desarrollo_id ) ;
          "
        );
        $clientes_estapa7_1=$this->Cliente->query(
          "SELECT COUNT(*) AS etapa7 FROM clientes, operaciones_inmuebles
          WHERE clientes.desarrollo_id=$substr_desarrollo_id
          AND operaciones_inmuebles.cliente_id=clientes.id
          AND operaciones_inmuebles.cliente_id=clientes.id
          AND operaciones_inmuebles.fecha>= '$fi'
          AND operaciones_inmuebles.fecha<= '$ff'
          AND operaciones_inmuebles.tipo_operacion=3
          AND operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($id) ) ;
          "
        );

      }

      // Condicion para el asesor id.
      if( !empty( $this->request->data['user_id'] ) ){
        $user= $this->request->data['user_id'];
        array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
        array_push($logand, array('Cliente.user_id' => $this->request->data['user_id'] ));
      }
      $condiciones = array(
        'AND' => $and,
        'OR'  => $or
      );
      if (empty( $this->request->data['desarrollo_id'] )) {
          $clientes_etapa7 = $this->Cliente->find('count',
            array(
              'conditions' => array(
                'Cliente.status'=> 'Activo',
                'Cliente.etapa'=>7,
                $condiciones
              )
            )
        );
      }
      $clientes_etapa1 = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'=> 'Activo',
            'Cliente.etapa'=>1,
            $condiciones
          )
        )
      );
      $clientes_etapa2 = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'=> 'Activo',
            'Cliente.etapa'=>2,
            $condiciones
          )
        )
      );
      $clientes_etapa3 = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'=> 'Activo',
            'Cliente.etapa'=>3,
            $condiciones
          )
        )
      );
      $clientes_etapa4 = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'=> 'Activo',
            'Cliente.etapa'=>4,
            $condiciones
          )
        )
      );
      $clientes_etapa5 = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'=> 'Activo',
            'Cliente.etapa'=>5,
            $condiciones
          )
        )
      );
      $clientes_etapa6 = $this->Cliente->find('count',
        array(
          'conditions' => array(
            'Cliente.status'=> 'Activo',
            'Cliente.etapa'=>6,
            $condiciones
          )
        )
      );
      
      
      

    }
    $etapa_1 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 1 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_2 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 2 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_3 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 3 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_4 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 4 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_5 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 5 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_6 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 6 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_7 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 7 ), 'contain' => false, 'fields' => array('nombre') ));
		// 
      // $fi='2022-02-01 00:00:00';
      // $ff='2022-10-30 23:59:59';
      // $cond_rangos = array("LogClientesEtapa.fecha BETWEEN ? AND ?" => array($fi, $ff));
      // array_push($and, $cond_rangos);
      
      // $substr_desarrollo_id = 237;
      // array_push($and, array('LogClientesEtapa.desarrollo_id' => $substr_desarrollo_id ));
      // $inmuebles= $this->DesarrolloInmueble->find('list', array(
      //   'conditions' => array(
      //     'DesarrolloInmueble.desarrollo_id'=> $substr_desarrollo_id,
      //   ),
      //   'fields' => array(
      //     'inmueble_id',
      //   ),
      // ));
      // foreach($inmuebles as $inmueble){
      //   $inmuebles_id = $inmuebles_id.$inmueble.",";
      // } 
      // $inmuebles_id = substr($inmuebles_id,0,-1);
      // array_push($and, array('LogClientesEtapa.inmuble_id IN ('.$inmuebles_id.')'));
      // $user=630;
      // array_push($and, array('LogClientesEtapa.user_id' =>$user /$this->request->data['user_id']/ ));
      // $condiciones = array(
      //   'AND' => $and,
      //   'OR'  => $or
      // );  
      // $clientes_etapa1 = $this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>1,
      //       $condiciones
      //     )
      //   )
      // );
      // $clientes_etapa2 = $this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>2,
      //       $condiciones
      //     )
      //   )
      // );
      // $clientes_etapa3 =$this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>3,
      //       $condiciones
      //     )
      //   )
      // );
      // $clientes_etapa4 = $this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>4,
      //       $condiciones
      //     )
      //   )
      // );
      // $clientes_etapa5 = $this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>5,
      //       $condiciones
      //     )
      //   )
      // );
      // $clientes_etapa6 = $this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>6,
      //       $condiciones
      //     )
      //   )
      // );
      // $clientes_etapa7 = $this->LogClientesEtapa->find('count',
      //   array(
      //     'conditions' => array(
      //       'LogClientesEtapa.status'=> 'Activo',
      //       'LogClientesEtapa.etapa'=>7,
      //       $condiciones
      //     )
      //   )
      // );
    // 

    if (empty( $this->request->data['desarrollo_id'] )) {
      $response = array(
          '0' => array(
            'estado'   =>  $etapa_7['DicEmbudoVenta']['nombre'],
            'cantidad' => $clientes_etapa7
          ),
        // else {
        
          // '0' => array(
          //   'estado'   =>  $etapa_7['DicEmbudoVenta']['nombre'],
          //   'cantidad' => intval($clientes_etapa7[0][0]['etapa7']),
          //   'cantidad7' => intval($clientes_estapa7_1[0][0]['etapa7']),
          //   //'color'    => '#3ed21f'
          // ),
        // }
        '1' => array(
          'estado'   => $etapa_6['DicEmbudoVenta']['nombre'],
          'cantidad' => $clientes_etapa6,
          //'color'    => '#ee5003'
        ),
        '2' => array(
          'estado'   => $etapa_5['DicEmbudoVenta']['nombre'],
          'cantidad' => $clientes_etapa5,
          //'color'    => '#f08551'
        ),
        '3' => array(
          'estado'   =>$etapa_4['DicEmbudoVenta']['nombre'],
          'cantidad' => $clientes_etapa4,
          //'color'    => '#f0ce7e'
        ),
        '4' => array(
          'estado'   =>  $etapa_3['DicEmbudoVenta']['nombre'],
          'cantidad' => $clientes_etapa3,
          //'color'    => '#f4e6c5'
        ),
        '5' => array(
          'estado'   => $etapa_2['DicEmbudoVenta']['nombre'],
          'cantidad' => $clientes_etapa2,
          //'color'    => '#6bc7f2'
        ),
        
        '6' => array(
          'estado'   => $etapa_1['DicEmbudoVenta']['nombre'],
          'cantidad' => $clientes_etapa1,
          //'color'    => '#ceeefd'
        ),
      );
    }else {
      $response = array(
        '0' => array(
          'estado'   =>  $etapa_7['DicEmbudoVenta']['nombre'],
          'cantidad' => intval($clientes_etapa7[0][0]['etapa7']),
          'cantidad7' => intval($clientes_estapa7_1[0][0]['etapa7']),
          //'color'    => '#3ed21f'
        ),

      '1' => array(
        'estado'   => $etapa_6['DicEmbudoVenta']['nombre'],
        'cantidad' => $clientes_etapa6,
        //'color'    => '#ee5003'
      ),
      '2' => array(
        'estado'   => $etapa_5['DicEmbudoVenta']['nombre'],
        'cantidad' => $clientes_etapa5,
        //'color'    => '#f08551'
      ),
      '3' => array(
        'estado'   =>$etapa_4['DicEmbudoVenta']['nombre'],
        'cantidad' => $clientes_etapa4,
        //'color'    => '#f0ce7e'
      ),
      '4' => array(
        'estado'   =>  $etapa_3['DicEmbudoVenta']['nombre'],
        'cantidad' => $clientes_etapa3,
        //'color'    => '#f4e6c5'
      ),
      '5' => array(
        'estado'   => $etapa_2['DicEmbudoVenta']['nombre'],
        'cantidad' => $clientes_etapa2,
        //'color'    => '#6bc7f2'
      ),
      
      '6' => array(
        'estado'   => $etapa_1['DicEmbudoVenta']['nombre'],
        'cantidad' => $clientes_etapa1,
        //'color'    => '#ceeefd'
      ),
    );
    }

    // 0: {etapa7: '2'}
    if (empty($response)) {
      $response[0]['estado']   = ' No tienes datos';
      $response[0]['cantidad'] = 0;
    }
    echo json_encode( $response, true );
    exit();
    $this->autoRender = false; 

  }

    /**
   * 
   * homogenizacion del log cliente 
   * en este parte del codigo se intentera pasar los clientes de la tabla de clientes hacia el log etapa para tener los clientes 
   * 
  */
  function homogenizacion(){
    $this->loadModel('Desarrollo');
    $this->Cliente->Behaviors->load('Containable');
    $this->LogClientesEtapa->Behaviors->load('Containable');
    $this->Desarrollo->Behaviors->load('Containable');
    $etapaActualizada=[];
    $desarrollo='';
    $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
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
    //estapa de la 1 a la 5 llenado con el log
    $clientes_log=$this->Cliente->query(
      "SELECT *, DATE_FORMAT(log_clientes_etapas.fecha,'%Y-%m-%d') as fecha_rogue
        from log_clientes_etapas
        WHERE log_clientes_etapas.desarrollo_id IN ($desarrollo)
        AND log_clientes_etapas.status='Activo'
        AND log_clientes_etapas.etapa < 6
        ORDER BY log_clientes_etapas.desarrollo_id ASC 
      "
    );
    $i=0;
    foreach ($clientes_log as $value) {
      $clientes = $this->Cliente->find('all',
        array(
          'conditions' => array(
            'Cliente.id'=> $value['log_clientes_etapas']['cliente_id'],
            'Cliente.etapa <'=> 6,
          ),
          'fields' => array(
            'Cliente.id',
            'Cliente.created',
            'Cliente.etapa',
            'Cliente.fecha_cambio_etapa',
          ),
          'contain' => false 
        )
      );
      if ($clientes != null ) {
        $etapaActualizada[$i]['fecha'] = $value[0]['fecha_rogue'];
        $etapaActualizada[$i]['id']    = $value['log_clientes_etapas']['cliente_id'];
        $etapaActualizada[$i]['etapa'] = $clientes[0]['Cliente']['etapa'];
        $id=$value['log_clientes_etapas']['cliente_id'];
        // $this->Cliente->query("UPDATE clientes SET clientes.fecha_cambio_etapa ='".$value[0]['fecha_rogue']."' WHERE clientes.id =  $id");
      
        $this->request->data['Cliente']['id']                 = $value['log_clientes_etapas']['cliente_id'];
        $this->request->data['Cliente']['fecha_cambio_etapa'] =$value[0]['fecha_rogue'];
        $this->Cliente->save($this->request->data['Cliente']); 
        $i++;

      }
    }
    //etapa 6 se llena con la fecha de la operacion 
    $clientes_etapa_6=$this->Cliente->find('all',array(
      'conditions' => array(
        'Cliente.etapa '=> 6,
        'Cliente.cuenta_id '=> $cuenta_id,
      ),
      'fields' => array(
        'Cliente.id',
        'Cliente.created',
        'Cliente.etapa',
      ),
      'contain' => false 
    ));
    $i=0;
    foreach ($clientes_etapa_6 as $value) {
      $operaciones=$this->Cliente->query(
        "SELECT *,DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m-%d') as fecha_operacion FROM operaciones_inmuebles
        WHERE operaciones_inmuebles.cliente_id=".$value['Cliente']['id']."
        AND operaciones_inmuebles.tipo_operacion=2
        "
      );
      $operacion[$i]['id']=$value['Cliente']['id'];
      $operacion[$i]['fecha']=$operaciones[0][0]['fecha_operacion'];
      $i++;
       $this->request->data['Cliente']['id']                 = $value['Cliente']['id'];
        $this->request->data['Cliente']['fecha_cambio_etapa'] =$operaciones[0][0]['fecha_operacion'];
        $this->Cliente->save($this->request->data['Cliente']); 
    }
    //etapa 7 se llana con la fecha de la operacion de l aventa
    $cliente_etapa_7=$this->Cliente->find('all',array(
      'conditions' => array(
        'Cliente.etapa '=> 7,
        'Cliente.cuenta_id '=> $cuenta_id,
      ),
      'fields' => array(
        'Cliente.id',
        'Cliente.created',
        'Cliente.etapa',
      ),
      'contain' => false 
    ));
    $i=0;
    foreach ($cliente_etapa_7 as $value) {
      
      $id=$value['Cliente']['id'];
      $ventas=$this->Cliente->query(
        "SELECT *,DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m-%d') as fecha_venta FROM operaciones_inmuebles
        WHERE operaciones_inmuebles.cliente_id = $id
        AND operaciones_inmuebles.tipo_operacion=3
        "
      );
      $venta[$i]['id']=$value['Cliente']['id'];
      $venta[$i]['fecha']=$ventas[0][0]['fecha_venta'];
      $fecha = $ventas[0][0]['fecha_venta'];
      $this->request->data['Cliente']['id']                 = $id;
      $this->request->data['Cliente']['fecha_cambio_etapa'] =$fecha;
      $this->Cliente->save($this->request->data['Cliente']);
      $i++;
    }
    $i=0;
    $clientes_inactivos=$this->Cliente->query(
      "SELECT clientes.id, clientes.last_edit,clientes.fecha_cambio_etapa,  DATE_FORMAT(clientes.last_edit,'%Y-%m-%d') as fecha
        from clientes
        WHERE clientes.cuenta_id=$cuenta_id
        AND clientes.fecha_cambio_etapa IS NULL 
        AND clientes.status='Inactivo'
        "
    );
    foreach ($clientes_inactivos as  $value) {
      $etapaActualizada_cliente[$i]['fecha'] = $value[0]['fecha'];
      $etapaActualizada_cliente[$i]['id']    = $value['clientes']['id'];
      $i++;
      $id=$value['clientes']['id'];
      $this->Cliente->query("UPDATE clientes SET clientes.fecha_cambio_etapa ='".$value[0]['fecha']."' WHERE clientes.id =  $id");
    }
    $i=0;

    $clientes_temporales=$this->Cliente->query(
      "SELECT clientes.id, clientes.last_edit,clientes.fecha_cambio_etapa,  DATE_FORMAT(clientes.last_edit,'%Y-%m-%d') as fecha_tempo
        from clientes
        WHERE clientes.cuenta_id=$cuenta_id
        AND clientes.fecha_cambio_etapa IS NULL 
        AND clientes.status='Inactivo temporal'
      "
    );
    foreach ($clientes_temporales as $value) {
      $temporales[$i]['fecha']=$value[0]['fecha_tempo'];
      $temporales[$i]['id']=$value['clientes']['id'];
      $id=$value['clientes']['id'];
      $this->Cliente->query("UPDATE clientes SET clientes.fecha_cambio_etapa ='".$value[0]['fecha_tempo']."' WHERE clientes.id =  $id");
      $i++;
    }
    $i=0;
    $clientes_activos=$this->Cliente->query(
      "SELECT clientes.id, clientes.last_edit,clientes.fecha_cambio_etapa,  DATE_FORMAT(clientes.last_edit,'%Y-%m-%d') as fecha_activo
        from clientes
        WHERE clientes.cuenta_id=$cuenta_id
        AND clientes.fecha_cambio_etapa IS NULL 
        AND clientes.status='Activo'
      "
    );
    foreach ($clientes_activos as $value) {
      $id=$value['clientes']['id'];
      $this->Cliente->query("UPDATE clientes SET clientes.fecha_cambio_etapa ='".$value[0]['fecha_activo']."' WHERE clientes.id =  $id");
    }
    echo json_encode( $venta, true );
    exit();
    $this->autoRender = false;
  }
  /***
     *
     * rogue
		 * E=MC
  */
  function eliminar_duplic_alex(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('Lead');
    $this->loadModel('Desarrollo');
    $this->loadModel('Cliente');
    $this->loadModel('DicLineaContacto');
    $this->Cliente->Behaviors->load('Containable');
    $this->DicLineaContacto->Behaviors->load('Containable');
    $this->Desarrollo->Behaviors->load('Containable');
    $this->Lead->Behaviors->load('Containable');

    if ($this->request->is('post')) {

      $cuenta_id= $this->request->data['cuenta_id'];

      $desarrollo_id=$this->Desarrollo->find('all',array(
        'conditions'=>array(
          'Desarrollo.cuenta_id' =>$cuenta_id,
          ),
          'fields' => array(
              'Desarrollo.id',
          ),
          'contain' => false
        )
      );

      $dic_linea_contacto_f=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(
        'DicLineaContacto.cuenta_id' => $cuenta_id,
        'DicLineaContacto.linea_contacto LIKE' =>  "%Facebook%",

        ),
        'fields' => array(
        'DicLineaContacto.id',
        'DicLineaContacto.linea_contacto',
        ),
        'contain' => false
        )
      );

      $dic_linea_contacto_i=$this->DicLineaContacto->find('all',array(
        'conditions'=>array(
        'DicLineaContacto.cuenta_id' => $cuenta_id,
        'DicLineaContacto.linea_contacto LIKE' =>  "%Instagram%",

        ),
        'fields' => array(
        'DicLineaContacto.id',
        'DicLineaContacto.linea_contacto',
        ),
        'contain' => false
        )
      );

      $clientes_=$this->Cliente->find('all',array(
        'conditions'=>array(
            'Cliente.dic_linea_contacto_id' => $dic_linea_contacto_f[0]['DicLineaContacto']['id'],
            'Cliente.user_id =' => null,
            'Cliente.status' => 'Inactivo',
            'Cliente.nombre' => 'Alejandro',
          ),
          'fields' => array(
            'Cliente.id',
            'Cliente.dic_linea_contacto_id',
            'Cliente.desarrollo_id',
            'Cliente.user_id',
            'Cliente.status',
            'Cliente.nombre',
        ),
        'contain' => false
      ));


      foreach ($clientes_ as $value_) {
        $leads=$this->Lead->find('all',array(
          'conditions'=>array(
              'Lead.cliente_id' => $value_['Cliente']['id']
            ),
            'fields' => array(
              'Lead.id',
              'Lead.cliente_id',
              'Lead.dic_linea_contacto_id',
              'Lead.desarrollo_id',
              'Lead.status'
          ),
          'contain' => false
        ));
        foreach ($leads as $value) {
          $idLead = $value['Lead']['cliente_id'];
          $this->Lead->query("DELETE FROM leads WHERE cliente_id =".$idLead."");
        }
        $idCliente = $value_['Cliente']['id'];
        $this->Cliente->query("DELETE FROM clientes WHERE id = ".$idCliente."");
      }



      $response = array(
        'Ok' => true,
        'mensaje' => 	'Duplicados Alejandro eliminados con exito'
      );

    } else {

        $response = array(
          'Ok' => false,
          'mensaje' => 'Hubo un error intente nuevamente'
        );

    }

    echo json_encode( $response, true );
    exit();
    $this->autoRender = false;
  }

  /**
   * 
   * 
   * 
  */
  function conqr(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('Cliente');
    $this->loadModel('DicTipoCliente');
    $this->DicTipoCliente->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
      $phone   = '';
      $user_id = '';
      
      if( !empty($this->request->data['email_user']) ){
        $user = $this->CuentasUser->find('first', array('conditions'=>array('User.correo_electronico'=>$this->request->data['email_user'])));
        $user_id = $user['User']['id'];
      }
        $telefono_ = $this->request->data['telefono1'];
        // Eliminar espacios en blanco
        $cadenaSinEspacios = str_replace(' ', '', $telefono_);

        // Obtener los �ltimos 10 caracteres
        $phone = substr($cadenaSinEspacios, -10);
        $tipo_cliente=$this->DicTipoCliente->find('first',array(
          'conditions'=>array(
              'DicTipoCliente.cuenta_id' => $this->request->data['cuenta_id'],
              'DicTipoCliente.tipo_cliente LIKE' => "%Final%",
              
            ),
            'fields' => array(
                'DicTipoCliente.id'
            ),
            'contain' => false 
          )
        );
        $params_cliente = array(
          'nombre'              => $this->request->data['nombre'],
          'correo_electronico'  => $this->request->data['correo_electronico'],
          'telefono1'           => $phone,
          'telefono2'           => '',
          'telefono3'           => '',
          'tipo_cliente'        => null,
          'propiedades_interes' => 'D'.$this->request->data['propiedad_id'],
          'forma_contacto'      => $this->request->data['dic_linea_contacto_id'],
          'comentario'          => '',
          'asesor_id'           => $user_id,
          'created'             => null,
          'api_key'             => $this->request->data['api_key'],
          'etapa'               => $this->request->data['etapa'],
        );

        $params_user = array(
          'user_id'              => ( !empty($this->request->data['email_user']) ? $user_id : 1 ),
          'cuenta_id'            => $this->request->data['cuenta_id'],
          'notificacion_1er_seg' => 0,
        );

        $save_client = $this->add_cliente( $params_cliente, $params_user );
        if( $save_client['bandera'] == 1 ){

            $this->request->data['Cliente']['id']                     = $save_client['cliente_id'];
            $this->request->data['Cliente']['banios_prospeccion']     = $this->request->data['banios'];
            $this->request->data['Cliente']['hab_prospeccion']        = $this->request->data['hab_prospeccion'];
            $this->request->data['Cliente']['precio_min_prospeccion'] = $this->request->data['precio_min'];
            $this->request->data['Cliente']['precio_max_prospeccion'] = $this->request->data['precio_max'];
            $this->request->data['Cliente']['forma_pago_prospeccion'] = $this->request->data['forma_pago'];
            $this->request->data['Cliente']['comentarios']            = $this->request->data['mensaje'];
            $this->Cliente->save($this->request->data);

            $this->Agenda->create();
            $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje']        = $this->request->data['mensaje'];
            $this->request->data['Agenda']['cliente_id']     = $cliente['Cliente']['id'];
            $this->Agenda->save($this->request->data);
          // }

        
        }else{
            $save_client;
        }
    }else {
        $response = array(
          'Ok' => false,
          'mensaje' => 'Hubo un error intente nuevamente'
        );
    }

    echo json_encode( $save_client, true );
    exit();
    $this->autoRender = false;
  }

  /**
   * Aka RogueOne
   * Funcion para alta de clientes con etapas definidas en post.
   * 
  */
  function add_cliente_etapa(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('Cliente');
    $this->loadModel('DicTipoCliente');
    $this->DicTipoCliente->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    if ( $this->request->is('post') && $this->request->data['api_key'] != null ) {
      $phone   = '';
      $user_id = '';
      
      if( !empty($this->request->data['email_user']) ){
        $user = $this->CuentasUser->find('first', array('conditions'=>array('User.correo_electronico'=>$this->request->data['email_user'])));
        $user_id = $user['User']['id'];
      }

      if( !empty($this->request->data['telefono1']) ){
        
        $telefono_ = $this->request->data['telefono1'];
        // Eliminar espacios en blanco
        $cadenaSinEspacios = str_replace(' ', '', $telefono_);
  
        // Obtener los �ltimos 10 caracteres
        $phone = substr($cadenaSinEspacios, -10);
      }
      
      
      $params_cliente = array(
        'nombre'              => $this->request->data['nombre'],
        'correo_electronico'  => $this->request->data['correo_electronico'],
        'telefono1'           => $phone,
        'telefono2'           => '',
        'telefono3'           => '',
        'tipo_cliente'        => null,
        'propiedades_interes' => 'D'.$this->request->data['propiedad_id'],
        'forma_contacto'      => $this->request->data['dic_linea_contacto_id'],
        'comentario'          => '',
        'asesor_id'           => $user_id,
        'created'             => null,
        'api_key'             => $this->request->data['api_key'],
        'etapa'               => $this->request->data['etapa'],
      );

      $params_user = array(
        'user_id'              => ( !empty($this->request->data['email_user']) ? $user_id : 1 ),
        'cuenta_id'            => $this->request->data['cuenta_id'],
        'notificacion_1er_seg' => 0,
      );

        $save_client = $this->add_cliente( $params_cliente, $params_user );
    }else {
        $response = array(
          'Ok' => false,
          'mensaje' => 'Hubo un error intente nuevamente'
        );
    }

    echo json_encode( $save_client, true );
    exit();
    $this->autoRender = false;
  }


  /***
   * 
   * 
   * 
   * 
  */
  function f_add_Cliente(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('DesarrolloInmueble');
    $this->loadModel('Cliente');
    $this->loadModel('OperacionesInmueble');
    $this->loadModel('LogClientesEtapa');
    $this->loadModel('Lead');
    $this->loadModel('Agenda');
    $this->loadModel('Venta');
    $this->Cliente->Behaviors->load('Containable');
    $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
    $i=0;

    if ($this->request->is('post')){

      foreach( $this->request->data['Cliente'] as $cliente ){
        
        $phone   = '';
        $user_id   = '';
        if( !empty($cliente['telefono1']) ){

          $telefono = $this->request->data['telefono1'];
          // Eliminar espacios en blanco
          $cadenaSinEspacios = str_replace(' ', '', $telefono);

          // Obtener los �ltimos 10 caracteres
          $phone = substr($cadenaSinEspacios, -10);
        }



        $params_cliente = array(
          'nombre'              => $cliente['nombre'],
          'correo_electronico'  => $cliente['correo'],
          'telefono1'           => $phone,
          'telefono2'           => '',
          'telefono3'           => '',
          'tipo_cliente'        => $cliente['tipo'],
          'propiedades_interes' => 'D'.$cliente['desarollo'],
          'forma_contacto'      => $cliente['medio'],
          'comentario'          => 'Agregado masivamente',
          'asesor_id'           => null,
          'created'             => date('Y-m-d', strtotime($cliente['fecha'])),
          'api_key'             => null,
          'etapa'               => null,
        );
  
        $params_user = array(
          'user_id'              => 1,
          'cuenta_id'            => $cuenta_id,
          'notificacion_1er_seg' => 0,
        );

        // Paso 1.- Revisar si se dara de alta por correo o telefono.
        if( $params_cliente['correo_electronico'] != '' AND  $params_cliente['telefono1'] != ''){
          
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

        }elseif( $params_cliente['correo_electronico'] != '' ){
          
          $conditions_cliente = array(
            'Cliente.correo_electronico' => $params_cliente['correo_electronico'],
            'Cliente.cuenta_id'          => $params_user['cuenta_id']
          );
          
          // Seteo de variables para guardarlos en la bd
          $data_3_cliente = array(
            'correo_electronico' => $params_cliente['correo_electronico'],
            'telefono1' => 'Sin teléfono'
          );

        }else{
          
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
        $cliente_ = $this->Cliente->find('count', array( 'conditions' => $conditions_cliente ) ); // Consulta del cliente en la bd.

        if(  $cliente_ == 0 ){ // No existe el cliente, GUARDA
          
          $this->Cliente->create();
          $this->request->data['Cliente']['id']                = null;
          $this->request->data['Cliente']['nombre']                = $params_cliente['nombre'];
          $this->request->data['Cliente']['correo_electronico']    = $params_cliente['correo_electronico'];
          $this->request->data['Cliente']['telefono1']             = $params_cliente['telefono1'];
          $this->request->data['Cliente']['dic_tipo_cliente_id']   = $params_cliente['tipo_cliente'];
          $this->request->data['Cliente']['status']                = 'Activo';
          $this->request->data['Cliente']['etapa_comercial']       = 'CRM';  
          $this->request->data['Cliente']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
          $this->request->data['Cliente']['cuenta_id']             = $params_user['cuenta_id'];
          $this->request->data['Cliente']['comentarios']           = $params_cliente['comentario'];
          $this->request->data['Cliente']['desarrollo_id']         = substr($params_cliente['propiedades_interes'], 1);
          $this->request->data['Cliente']['user_id']               = $params_cliente['asesor_id'];
          $this->request->data['Cliente']['created']               = $params_cliente['created'];
          $this->request->data['Cliente']['fecha_cambio_etapa']    = date('Y-m-d');
          //rogueEtapaFecha
          $this->Cliente->save( $this->request->data);
          $cliente_id = $this->Cliente->getInsertID(); 

          if( $cliente_id != null){
            
           // Guarda en la variable el id del cliente salvado.
           
            $this->Lead->create(); 
            $this->request->data['Lead']['cliente_id']            = $cliente_id;
            $this->request->data['Lead']['status']                = 'Abierto';
            $this->request->data['Lead']['dic_linea_contacto_id'] = $params_cliente['forma_contacto'];
            $this->request->data['Lead']['desarrollo_id']         = $desarrollo_id;
            $this->request->data['Lead']['tipo_lead']             = 1;
            $this->request->data['Lead']['user_id']               = $params_cliente['asesor_id'];
            $this->request->data['Lead']['fecha']                 = $params_cliente['created'];
          
            if( $this->Lead->save($this->request->data)){

              $save_client[$i] = $cliente_id;
            
            }
          }


        }else{
          $cliente_du = $this->Cliente->find('first', array( 
            'conditions' => $conditions_cliente,
            'fields' => array(
              'Cliente.id',
            ),
            'contain' => false
          ));
          $this->request->data['Cliente']['id']         =  $cliente_du['Cliente']['id'];
          $this->request->data['Cliente']['comentarios'] = $params_cliente['comentario'];
          $this->Cliente->save($this->request->data);
          $save_client[$i] = 'No se guardo el cliente, es duplicado '.$cliente_du['Cliente']['id']. ' busca';
        }
        
        $i++;
      } // End foreach
    }
    $respuesta=[];
    echo json_encode ( $save_client );

    exit();
    $this->autoRender = false;
  }


  /***
   * 
   * 
  */
  function add_clientes_masivos(){
    $this->loadModel('DicTipoCliente');

    $this->Desarrollo->Behaviors->load('Containable');
    $this->DicTipoCliente->Behaviors->load('Containable');
    $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
    $desarrollos = $this->Desarrollo->find('list',array(
      'conditions'=>array("Desarrollo.cuenta_id" => $cuenta_id),
      'fields' => array(
        'Desarrollo.id',
        'Desarrollo.nombre',
      ),
        'contain' => false
      )
    );
    $dic_linea_contacto=$this->DicLineaContacto->find('list',array(
      'conditions'=>array(
        'DicLineaContacto.cuenta_id' => $cuenta_id,
        'DicLineaContacto.linea_contacto LIKE "%Facebook%"',
      ),
      'fields' => array(
        'DicLineaContacto.id',
        'DicLineaContacto.linea_contacto',
      ),
      'contain' => false
      )
    );
    $tipo_cliente=$this->DicTipoCliente->find('list',array(
      'conditions'=>array(
        'DicTipoCliente.cuenta_id' => $cuenta_id,
        'DicTipoCliente.tipo_cliente LIKE "%Final%"',
      ),
      'fields' => array(
        'DicTipoCliente.id',
        // 'DicTipoCliente.tipo_cliente',
      ),
      'contain' => false
      )
    );
    $this->set(compact('desarrollos', 'cuenta_id','dic_linea_contacto','tipo_cliente'));
    $response['data']    = [];
    if ($this->request->is('post')){

      $file     = $this->request->data['OperacionesCSV']['file']['tmp_name'];
      $response['data'] = file($file);

      $i = 0;

    }
    $this->set(compact ('response') );
  }

  /**
   * 
   * 
  */
  function logs_save_masivo(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('DesarrolloInmueble');
    $this->loadModel('Cliente');
    $this->loadModel('OperacionesInmueble');
    $this->loadModel('LogClientesEtapa');
    $this->loadModel('Lead');
    $this->loadModel('Agenda');
    $this->loadModel('Venta');
    $this->Cliente->Behaviors->load('Containable');
    $this->LogClientesEtapa->Behaviors->load('Containable');
    $this->LogCliente->Behaviors->load('Containable');
    $this->Agenda->Behaviors->load('Containable');
    $clientes_sin_seguimiento = $this->Cliente->find('all', array( 
      'conditions'=>array(
        'Cliente.comentarios LIKE "%Agregado masivamente%" ',
      ),
      'fields' => array(
        'Cliente.id',
        'Cliente.desarrollo_id',
        'Cliente.created',
      ),
      'contain' => false
    ));
    foreach ($clientes_sin_seguimiento as  $value) {
      $this->LogCliente->create();
      $this->request->data['LogCliente']['id']         =  uniqid();
      $this->request->data['LogCliente']['cliente_id'] = $value['Cliente']['id'];
      $this->request->data['LogCliente']['user_id']    = '';
      $this->request->data['LogCliente']['mensaje']    = "Cliente creado";
      $this->request->data['LogCliente']['accion']     = 1;
      $this->request->data['LogCliente']['datetime']   = $value['Cliente']['created'];
      $this->LogCliente->save($this->request->data);
      //Registrar Seguimiento Rápido
      $this->Agenda->create();
      $this->request->data['Agenda']['user_id']        = 1;
      $this->request->data['Agenda']['fecha']          = $value['Cliente']['created'];
      $this->request->data['Agenda']['mensaje']        = "Cliente creado de forma masiva con line de contacto Facebook";
      $this->request->data['Agenda']['cliente_id']     = $value['Cliente']['id'];
      $this->Agenda->save($this->request->data);

      //$this->Cliente->query("UPDATE clientes SET desarrollo_id = $value['Cliente']['desarrollo_id'] WHERE id = $value['Cliente']['id'] ");
      
      $this->LogClientesEtapa->create();
      $this->request->data['LogClientesEtapa']['cliente_id']   = $value['Cliente']['id'];
      $this->request->data['LogClientesEtapa']['fecha']        = $value['Cliente']['created'];
      $this->request->data['LogClientesEtapa']['etapa']        = 1;
      $this->request->data['LogClientesEtapa']['desarrollo_id'] = $value['Cliente']['desarrollo_id'];
      $this->request->data['LogClientesEtapa']['inmuble_id']   = 0;
      $this->request->data['LogClientesEtapa']['status']       = 'Activo';
      $this->request->data['LogClientesEtapa']['user_id']      = $value['Cliente']['user_id'];
      $this->LogClientesEtapa->save($this->request->data);
    }
   
    echo json_encode ( $clientes_sin_seguimiento );
    exit();
    $this->autoRender = false;
  }
  /**
   * 
   * 
  */
  function borrado_cliente(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('Cliente');
    $this->loadModel('OperacionesInmueble');
    $this->loadModel('Inmueble');
    $this->loadModel('Venta');
    $this->Venta->Behaviors->load('Containable');
    $this->Cliente->Behaviors->load('Containable');
    $this->Lead->Behaviors->load('Containable');
    $this->OperacionesInmueble->Behaviors->load('Containable');
    $this->Inmueble->Behaviors->load('Containable');
    $response = [];
    $response = array(
      'Ok' => true,
      'mensaje' => 	'listo'
    );
    if($this->request->is('post')) {
      $cliente_id = $this->request->data['cliente_id'];

      $clientes = $this->Lead->find('all',
        array(
          'conditions' => array(
              'Lead.cliente_id' => $cliente_id ,
          ),
          'fields' => array(
            'Lead.id',
            'Lead.cliente_id',
          ),
          'contain' => false 
        )
      );
      $operaciones = $this->OperacionesInmueble->find('all',
        array(
            'conditions' => array(
                'OperacionesInmueble.cliente_id' => $cliente_id,
            ),'fields' => array(
                'id',
                'inmueble_id',
            ),
            'contain' => false 
        ) 
      );
      $inmueble_info=$this->Inmueble->find('first',array(
        'conditions'=>array(
            'Inmueble.id'=> $operaciones[0]['OperacionesInmueble']['inmueble_id'], 
        ),
        'fields'=>array(
            'id',
            'liberada',
            // 'niveles_totales',
        ), 
        'contain' => false
      ));
      $venta=$this->Venta->find('first',array(
        'conditions'=>array(
          'Venta.cliente_id'=> $cliente_id, 
        ),
        'fields'=>array(
            'id',
            // 'niveles_totales',
        ), 
        'contain' => false
      ));
      if (!empty($clientes)) {
        $this->Cliente->id= $cliente_id;
        $this->Cliente->delete();
        foreach ($clientes as  $value) {
          $this->Lead->id            = $value['Lead']['id'];
          $this->Lead->delete();
        }
        $response = array(
          'Ok' => true,
          'mensaje' => 	'se borro leads'
        );
      }else {
        $response = array(
          'Ok' => false,
          'mensaje' => 	'no se borraron leads'
        );
      }
      if (!empty($operaciones)) {
        foreach ($operaciones as $value) {
          $this->OperacionesInmueble->id            = $value['OperacionesInmueble']['id'];
          $this->OperacionesInmueble->delete();
        }
        $this->request->data['Inmueble']['id']    = $inmueble_info['Inmueble']['id'];
        $this->request->data['Inmueble']['liberada']       = 1;
        $this->Inmueble->save($this->request->data);
        $response = array(
          'Ok' => true,
          'mensaje' => 	'se borro operaciones y se actualizo inmueble'
        );
      }else {
        $response = array(
          'Ok' => false,
          'mensaje' => 	'no se borarron operaciones '
        );
      }
      if (!empty($venta)) {
        $this->Venta->id            = $venta['Venta']['id'];
        $this->Venta->delete();
        $response = array(
          'Ok' => true,
          'mensaje' => 	'se borro venta'
        );
      }else {
        $response = array(
          'Ok' => false,
          'mensaje' => 	'no se borarron venta'
        );
      }
    }else {
      $response = array(
        'Ok' => false,
        'mensaje' => 	'intente de nuevo'
      );
    }
    


    echo json_encode ( $response );
    exit();
    $this->autoRender = false;

  }
  


}
