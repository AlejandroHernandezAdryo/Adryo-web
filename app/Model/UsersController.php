<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */



class UsersController extends AppController {

	public $components = array('Paginator');
  public $uses = array(
    'User',
    'Cliente',
    'Inmueble',
    'Desarrollo',
    'Event',
    'Agenda',
    'Asignacion',
    'Lead',
    'Mensaje',
    'Cuenta',
    'Group',
    'GruposUsuariosUser',
    'CuentasUser',
    'Precio',
    'LogInmueble',
    'LogCliente',
    'Venta',
    'DicLineaContacto',
    'DesarrollosUser', // Tabla de desarrolladores.
    'DesarrolloInmueble',
    'ClientesVentasDicContacto',
    'UserCliente',
    'DicTipoCliente',
    'DicEtapa',
    'DicTipoAnuncio',
    'DicUbicacionAnuncio',
    'DicTipoPropiedad',
    'DicProveedor',
    'DicFactura',
    'DicRazonInactivacion',
    'Categoria',
    'Mailconfig'
  );
	
  public function beforeFilter() {
      parent::beforeFilter();
      $this->Session->write('CuentaUsuario',$this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$this->Session->read('Auth.User.id')))));
      $this->Auth->allow(array('solicitar_prueba','recordatorios', 'login_app', 'get_all_users'));
  }
/**
 * index method
 *
 * @return void
 * 
 
 */
      

        public function proximos_eventos($user_id = null, $cliente_id = null, $desarrollo_id = null, $inmueble_id = null, $tipo_tarea = null, $status = null, $cuenta_id = null) {


          $this->Event->Behaviors->load('Containable');          
          $eventos     = [];
          $data_evento = [];
          $s = 0;


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


          $asesores = $this->User->find('list', array(
              'conditions' => array(
                'User.status' => 1,
                'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
              ),
              'order' => 'User.nombre_completo ASC'
            ));
            
            $clientes = $this->Cliente->find('list', array(
              'conditions' => array(
                'Cliente.status'     => 'Activo',
                'Cliente.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Cliente.user_id <>' => '',
              ),
              'order' => 'Cliente.nombre ASC'
            ));

            $desarrollos = $this->Desarrollo->find('list', array(
              'conditions' => array(
                'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              ),
              'order' => 'Desarrollo.nombre ASC'
            ));

            $inmuebles = $this->Inmueble->find('list', array(
              'conditions' => array(
                'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
              ),
              'order' => 'Inmueble.titulo ASC'
            ));

            $condiciones = array(
              'Event.tipo_evento' => 1,
              'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            );

            if ( !empty( $user_id ) ){
              array_push($condiciones, array('Event.user_id'    => $user_id));
            }

            if ( !empty( $cliente_id ) ){
              array_push($condiciones, array('Event.cliente_id'    => $cliente_id));
            }

            if ( !empty( $desarrollo_id ) ){
              array_push($condiciones, array('Event.desarrollo_id'    => $desarrollo_id));
            }

            if ( !empty( $inmueble_id ) ){
              array_push($condiciones, array('Event.inmueble_id'    => $inmueble_id));
            }

            if ( !empty( $tipo_tarea ) ){
              array_push($condiciones, array('Event.tipo_tarea'    => $tipo_tarea));
              
              // Condicion para el tipo de tarea igual a 4 y filtrar las reactivaciones automaticas.
              if($tipo_tarea == 4) {
                $condiciones = array(
                  'Event.tipo_evento' => 0,
                  'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                );
              }

            }

            if ( !empty( $status ) ){
              array_push($condiciones, array('Event.status'    => $status));
            }

            $eventos = $this->Event->find('all', array(
              'conditions' => $condiciones,
              'contain' => array(
                'User' => array(
                  'fields' => array(
                      'User.id',
                      'User.nombre_completo',
                      'User.correo_electronico',
                  )
                ),
                'Inmueble' => array(
                    'fields' => array(
                        'Inmueble.id',
                        'Inmueble.titulo'
                    )
                ),
                'Desarrollo' => array(
                    'fields' => array(
                        'Desarrollo.id',
                        'Desarrollo.nombre'
                    )
                ),
                'Cliente' => array(
                    'fields' => array(
                        'Cliente.id',
                        'Cliente.nombre'
                    )
                )
              )
            ));

            return $eventos;
        }







  function cambio_temp(){
    $cliente_id = $this->request->data['Users']['id'];  
  }   
        
	public function mysession($id_usuario = null){
            $this->layout='cliente';
            if (isset($id_usuario) && $this->Session->read('Auth.User.group_id')< 3){
                $todos = $this->Asignacion->find('all',array('recursive'=>2,'conditions'=>array('Asignacion.user_id'=>$id_usuario)));
            }else{
                $todos = $this->Asignacion->find('all',array('recursive'=>2,'conditions'=>array('Asignacion.user_id'=>$this->Session->read('Auth.User.id'))));
            }
            $desarrollos = array();
            $inmuebles = array();
            foreach ($todos as $registro):
                if (empty($registro['Desarrollo']['id']==null)){
                    array_push($desarrollos,$registro['Desarrollo']);
                    
                }
                if (empty($registro['Inmueble']['id']==null)){
                    array_push($inmuebles,$registro['Inmueble']);
                    
                }
            endforeach;
            
            $this->set('todos',$todos);
            $this->set('propiedades',$inmuebles);
            $this->set('desarrollos',$desarrollos);
            
        }
        
        
        public function notas(){
            
            $users_cuentas_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
            $nota = $this->request->data['User']['texto'];
            $this->CuentasUser->create();
            $this->request->data['CuentasUser']['id']=$users_cuentas_id;
            $this->request->data['CuentasUser']['notas'] = $nota;
            
            if ($this->CuentasUser->save($this->request->data)){
               $this->Session->write('CuentaUsuario.CuentasUser.notas', $nota);
               $this->Session->setFlash(__('Tus notas se han guardado exitosamente'),'default',array('class'=>'mensaje_exito'));
               return $this->redirect(array('action' => 'dashboard'));     
            }
            
            
        }
        
        
  /*********************************************************************
  * Ultima edición
  * 25/02/2019 - AKA "SaaK" Alejandro Hernández
  * 14/04/2020 - AKA "SaaK"
  * Modificacion en consulta para datos de las graficas.
  * 
  *********************************************************************/
  public function dashboard(){
    setlocale(LC_TIME, "spanish");
    $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    
    $mes_inicio = $this->Session->read('CuentaUsuario.Cuenta.fecha_creacion');
    $mes_final  = date('Y-m-31');
    $periodo_tiempo_mes = 'INFORMACIÓN ACUMULADA DEL '.date('d-m-Y', strtotime($mes_inicio)).' AL '.date('d-m-Y', strtotime($mes_final));
    
    $mes_actual     = ucwords(strftime("%B de %Y", strtotime(date("d-m-Y", strtotime(date('Ymd'))))));
    $anio_actual    = date('Y');
    $fecha_inicio   = $this->Session->read('CuentaUsuario.Cuenta.fecha_creacion');
    $fecha_final    = date('Y-m-31');
    $periodo_tiempo = 'INFORMACIÓN ACUMULADA DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));

    // Variables para la asignacion de eventos
    $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
    $tipo_tarea          = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 4=>'Reactivación', 1=>'Visita');
    $tipo_tarea_opciones = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
    $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'check-circle', 'child' );
    $remitente           = '';
    $color               = '#AEE9EA';
    $textColor           = '#2f2f2f';
    $recordatorios       = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');
    $status              = array(0=> 'Creado(s)', 2=>'Cancelado(s)');


    //KPI's para indicadores de eventos
    // Indicadores de emails, citas y visitas, llamadas.
      $this->set('mails',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id)",'LogCliente.accion'=>3))));
      $this->set('citas',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id)",'LogCliente.accion'=> 5 ))));
      $this->set('visitas',$this->Event->find('count',array('conditions'=>array("Event.cuenta_id" =>$cuenta_id,'Event.tipo_tarea'=> 1, 'Event.fecha_inicio >=' => $fecha_inicio, 'Event.fecha_inicio <='=>$fecha_final))));
      $this->set('llamadas',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = $cuenta_id)",'LogCliente.accion'=>4))));

    // Info usuario - indicador mensual
    $user = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('Auth.User.id')), 'fields' => array('User.id', 'User.nombre_completo', 'User.last_login'), 'recursive' => 0));

    // Objetivo de venta mensual
    $objetivo_venta_mensual = $this->User->query("SELECT * FROM objetivos_ventas_cuentas WHERE objetivos_ventas_cuentas.cuenta_id = $cuenta_id ORDER BY objetivos_ventas_cuentas.fecha DESC LIMIT 1");

    // Condicion si no tiene objetivo de venta del mes actual
    if( empty($objetivo_venta_mensual) ){
      $objetivo_venta_mensual[0]['objetivos_ventas_cuentas']['monto'] = 0;
    }

    // Total de clientes mensuales
    $total_clientes_mensuales = $this->User->query("SELECT count(*) as total_clientes FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$mes_inicio' AND created <= '$mes_final';");
    
    // Total de clientes mensuales, separados por estatus.
    $clientes_mensuales = $this->User->query("SELECT COUNT(clientes.status) AS total, clientes.`status` FROM clientes WHERE clientes.cuenta_id = $cuenta_id AND created >= '$mes_inicio' AND created <= '$mes_final' GROUP BY clientes.`status`;");

    // Unidades vendias mensuales y suma total del monto vendido
    $unidades_monto_venta_mensual = $this->User->query("SELECT COUNT(ventas.id) AS total_ventas, SUM(ventas.precio_cerrado) AS monto_venta FROM ventas WHERE ventas.cuenta_id = $cuenta_id AND ventas.tipo_operacion = 'Venta' AND ventas.fecha >= '$mes_inicio' AND ventas.fecha <= '$mes_final'");

    /*************************************************Consultas indicadores anuales********************************************************************/

    $objetivo_venta_anual = $this->User->query("SELECT SUM(objetivos_ventas_cuentas.monto) AS meta_venta_anual FROM objetivos_ventas_cuentas WHERE objetivos_ventas_cuentas.cuenta_id = $cuenta_id;");

    $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

    $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' GROUP BY status");

    // Unidades vendias mensuales y suma total del monto vendido
    $unidades_monto_venta_anuales = $this->User->query("SELECT COUNT(ventas.id) AS total_ventas, SUM(ventas.precio_cerrado) AS monto_venta FROM ventas WHERE ventas.cuenta_id = $cuenta_id AND ventas.tipo_operacion = 'Venta' AND ventas.fecha >= '$fecha_inicio' AND ventas.fecha <= '$fecha_final'");
    
    $clientes_venta_anuales = $this->User->query("SELECT COUNT(DISTINCT ventas.cliente_id) AS total_clientes FROM ventas WHERE ventas.cuenta_id = $cuenta_id AND ventas.tipo_operacion = 'Venta' AND fecha >= '$fecha_inicio' AND fecha <= '$fecha_final';");
    
    
    /*************************************************Consultas tarjetas de KPI históricos********************************************************************/
    $corretaje_libre_q = $this->Inmueble->find(
            'count',
            array(
                'conditions'=>array(
                    'Inmueble.cuenta_id'=>$cuenta_id,
                    'Inmueble.liberada'=>1,
                    'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
                    )
                )
            );
    $this->set(compact('corretaje_libre_q'));
    
    $corretaje_libre_v = $this->Inmueble->find(
            'all',
            array(
                'fields'=>'SUM(Inmueble.precio) AS libre_corretaje_v',
                'conditions'=>array(
                    'Inmueble.cuenta_id'=>$cuenta_id,
                    'Inmueble.liberada'=>1,
                    'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
                    )
                )
            );
    $this->set(compact('corretaje_libre_v'));
    
    $desarrollos_libre_q = $this->Desarrollo->find(
            'count',
            array(
                'conditions'=>array(
                    'AND'=>array(
                        'Desarrollo.visible'=>1,
                    ),
                    'OR'=>array(
                        'Desarrollo.cuenta_id'=>$cuenta_id,
                        'Desarrollo.comercializador_id'=>$cuenta_id
                    )
                )
            )
    );
    $this->set(compact('desarrollos_libre_q'));
    
    $unidades_libre_q = $this->Inmueble->find(
            'count',
            array(
                'conditions'=>array(
                    'Inmueble.liberada'=>1,
                    "Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN(SELECT id FROM desarrollos WHERE cuenta_id = $cuenta_id OR comercializador_id = $cuenta_id))"
                    )
                )
            );
    $this->set(compact('unidades_libre_q'));
    
    $unidades_libre_v = $this->Inmueble->find(
            'all',
            array(
                'fields'=>'SUM(Inmueble.precio) AS libre_corretaje_v',
                'conditions'=>array(
                    'Inmueble.liberada'=>1,
                    "Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN(SELECT id FROM desarrollos WHERE cuenta_id = $cuenta_id OR comercializador_id = $cuenta_id))"                    )
                )
            );
    $this->set(compact('unidades_libre_v'));
    
    //$unidades_monto_venta_anuales = $this->User->query("SELECT COUNT(ventas.id) AS total_ventas, SUM(ventas.precio_cerrado) AS monto_venta FROM ventas WHERE ventas.cuenta_id = $cuenta_id AND ventas.tipo_operacion = 'Venta' AND ventas.fecha >= '$fecha_inicio' AND ventas.fecha <= '$fecha_final'");
    
    /************************************************* Grafica de temperatura de clientes ********************************************************************/
    $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id."  AND created >= '".$fecha_inicio."' AND created <= '".$fecha_final."' AND status = 'Activo' GROUP BY etapa;");

    /************************************************* Grafica de atencion de clientes ********************************************************************/

    //Indicador de clientes con estatus Oportunos
    $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
        
    //Indicador de clientes con estatus Oportunos tardíos
    $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
    
    //Indicador de clientes con estatus No Antendidos
    $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No Atendidos (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
    
    //Indicador de clientes con estatus Por Reasignar
    $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
    
    //Indicador de clientes con estatus Sin Asignar
    $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin Asignar' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fecha_inicio' AND created <= '$fecha_final'");

    // Suma de los clientes de atencion
    $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

    /************************************************* Mensajes gerenciales y proximos eventos ********************************************************************/
    $mensajes_gerenciales = $this->Mensaje->find('all',array('conditions'=>array('Mensaje.expiration_date >= NOW()','Mensaje.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));

    $condiciones_eventos = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),'Event.fecha_inicio >= CURDATE()', 'Event.fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)');

    // Eventos
    $eventos = $this->Event->find('all', array(
      'conditions' => $condiciones_eventos,
      'order' => array('Event.fecha_inicio' => 'DESC'),
      'contain' => array(
        'User' => array(
          'fields' => array(
              'User.id',
              'User.nombre_completo',
              'User.correo_electronico',
          )
        ),
        'Inmueble' => array(
            'fields' => array(
                'Inmueble.id',
                'Inmueble.titulo'
            )
        ),
        'Desarrollo' => array(
            'fields' => array(
                'Desarrollo.id',
                'Desarrollo.nombre'
            )
        ),
        'Cliente' => array(
            'fields' => array(
                'Cliente.id',
                'Cliente.nombre'
            )
        )
      )
    ));

    $data_eventos = [];
    $s = 0;
    // Vamos a setear los eventos de forma correcta para mandar a llamar a la vista lo menos cargada posible
    foreach( $eventos as $evento ) {

      switch ($evento['Event']['tipo_tarea']) {
        case 0: // Cita
          $remitente = 'para';
          $color = '#AEE9EA';
        break;
        case 1: // Visita
          $remitente = 'de';
          $color = '#7CC3C4';
        break;
        case 2: //Llamada
          $remitente = 'a';
          $color = '#7AABF9';
        break;
        case 3: // Correo
          $remitente = 'para';
          $color = '#F0D38A';
        break;
        case 4: // Reactivacion
          $remitente = 'de';
          $color = '#ffe048';
        break;
      }

      
      if( $evento['Event']['status'] == 2) {
        $color = '#2f2f2f';
        $textColor = '#fff';
      }else {
        $textColor = '#2f2f2f';
      }

      if( isset($evento['Desarrollo']['nombre']) ){
        $nombre_ubicacion = strtoupper($evento['Desarrollo']['nombre']);
        $url_ubicacion    = '../desarrollos/view/'.$evento['Desarrollo']['id'];
      }else{
        $nombre_ubicacion = strtoupper($evento['Inmueble']['titulo']);
        $url_ubicacion    = '../inmuebles/view/'.$evento['Inmueble']['id'];
      }

      $s++;
      $data_eventos[$s]['titulo']              = strtoupper($evento['Cliente']['nombre']);
      $data_eventos[$s]['fecha_inicio']        = date('Y-m-d', strtotime($evento['Event']['fecha_inicio'])).'T'.date('H:i:s', strtotime($evento['Event']['fecha_inicio']));
      $data_eventos[$s]['color']               = $color;
      $data_eventos[$s]['textColor']           = $textColor;
      $data_eventos[$s]['icon']                = $tipo_tarea_icon[$evento['Event']['tipo_tarea']];
      $data_eventos[$s]['url']                 = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."')";
      $data_eventos[$s]['fecha_inicio_format'] = date('d/M/Y \a \l\a\s H:i', strtotime($evento['Event']['fecha_inicio']));
      $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
      $data_eventos[$s]['status']              = $evento['Event']['status'];
      $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
      $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
      $data_eventos[$s]['id_evento']           = $evento['Event']['id'];
    }

    /************************************************* Desarrollos y propiedades nuevas ********************************************************************/
    $desarrollos_nuevos = $this->Desarrollo->find('all', array('fields'=>array('Desarrollo.nombre','Desarrollo.m2_low','Desarrollo.m2_top','Desarrollo.rec_low','Desarrollo.rec_top','Desarrollo.banio_low','Desarrollo.banio_top','Desarrollo.est_low','Desarrollo.est_top'), 'conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Desarrollo.fecha_alta >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)'),'limit'=>6));

    $propiedades_nuevas = $this->Inmueble->query("SELECT inmuebles.titulo, inmuebles.id, foto_inmuebles.ruta, inmuebles.construccion, inmuebles.construccion_no_habitable, inmuebles.recamaras, inmuebles.banos, inmuebles.medio_banos, inmuebles.estacionamiento_techado, inmuebles.estacionamiento_descubierto, foto_inmuebles.orden FROM  inmuebles INNER JOIN foto_inmuebles WHERE inmuebles.cuenta_id = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')." AND fecha >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)  AND inmuebles.liberada = 1 AND foto_inmuebles.orden = 1 AND inmuebles.id NOT IN(SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles)
    ORDER BY foto_inmuebles.orden ASC  LIMIT 6;");

    /************************************************* Tabla de cambio de precios ********************************************************************/
    $precios_inmuebles = $this->Inmueble->find('all',array('limit'=>5,'conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),'Inmueble.id IN (SELECT inmueble_id FROM precios GROUP BY inmueble_id HAVING count(id) > 1 ORDER BY precios.id DESC)')));

    /************************************************* Ubicaciones para mapeo de desarrollos ********************************************************************/
    $ubicaciones_d = $this->Desarrollo->find('all',array('conditions'=>array('Desarrollo.google_maps !='=>'', 'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));

    /************************************************* Grafica de clientes con linea de contacto (Mes) ********************************************************************/
    $clientes_lineas_mes = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$mes_inicio' AND clientes.created <= '$mes_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

    $total_clientes_lineas_mes = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$mes_inicio' AND clientes.created <= '$mes_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

    /************************************************* Grafica de clientes con linea de contacto (Acumulado) *****************************************************************/
    $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

    $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

    $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fecha_inicio' AND  ventas.fecha <= '$fecha_final' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
    $ventas_linea_contacto_arreglo = array();
    $i=0;

    //Para el acumulado de inversión
    $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
    
    /************************************************* Grafica de visitas con linea de contacto (Acumulado) *****************************************************************/
    //$clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

    //$total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

    $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fecha_inicio' AND  events.fecha_inicio <= '$fecha_final' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");
    
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
    
    
    /************************************************* Grafica de ventas con linea de contacto ********************************************************************/
    

    $total_venta_linea_contacto = $this->User->query("SELECT SUM(ventas.precio_cerrado) AS venta_total FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id AND  ventas.fecha >= '$fecha_inicio' AND  ventas.fecha <= '$fecha_final' ;");

    /************************************************* Grafica de numero de ventas con linea de contacto ********************************************************************/
    $n_ventas_contacto = $this->User->query("SELECT COUNT(*) AS n_contacto, clientes.dic_linea_contacto_id, dic_linea_contactos.linea_contacto FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND ventas.tipo_operacion = 'Venta' AND fecha >= '$fecha_inicio' AND fecha <= '$fecha_final' AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id GROUP BY dic_linea_contactos.linea_contacto ORDER BY dic_linea_contactos.linea_contacto;");

    $total_ventas_unidades = $this->User->query("SELECT COUNT(ventas.id) AS total_ventas FROM ventas WHERE ventas.cuenta_id = $cuenta_id AND ventas.tipo_operacion = 'Venta' AND ventas.fecha >= '$fecha_inicio' AND ventas.fecha <= '$fecha_final'");


    /************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
    $this->Desarrollo->Behaviors->load('Containable');
    $desarrollos_list = $this->Desarrollo->find(
      'all',
      array(
        'conditions'=>array(
          'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id')
        ),
        'fields'=>array('id'),
        'contain'=>false
      )
    );  
    $desarrollo_str = '';
      foreach($desarrollos_list as $desarrollo):
          $desarrollo_str =$desarrollo_str.$desarrollo['Desarrollo']['id'].",";
      endforeach;

      $desarrollo_id = substr($desarrollo_str,0,-1);

      $fi = $this->Session->read('CuentaUsuario.Cuenta.fecha_creacion');
      $ff = date('Y-m-31');

    $query = "SELECT 
    COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
    IFNULL((SELECT SUM(unidades) FROM objetivos_ventas_desarrollos WHERE fecha < DATE(CONCAT(periodo,'-01')) AND fin > DATE(CONCAT(periodo,'-01')) AND desarrollo_id IN ($desarrollo_id)),1) AS objetivo_ventas
        FROM 
            ventas
        WHERE 
            ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollo_id)) AND
            ventas.fecha <= '$ff' AND
            ventas.fecha >= '$fi'
        GROUP BY periodo
        ORDER BY periodo";

    $ventas_vs_metas = $this->Desarrollo->query($query);
    //Armar el arreglo para poder consultarlo con únicamente las ventas
    $arreglo_ventas = array();
    foreach($ventas_vs_metas as $venta):
        $arreglo_ventas[$venta[0]['periodo']]['objetivo_ventas']=$venta[0]['objetivo_ventas'];
        $arreglo_ventas[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
    endforeach;
    $kpi_inicial = $ventas_vs_metas[0][0]['objetivo_ventas'];
    // Variables de ventas vs metas por mes.
    //$this->set(compact('arreglo_ventas'));
    //$this->set(compact('ventas_vs_metas'));

    $intervalo_meses = abs(strtotime($fi)-strtotime($ff));
    $meses = floor($intervalo_meses/60/60/24/30);
    $this->set('meses',$meses);
    $meses_array = array();
    $primer_mes = date('m',strtotime($fi));
    $primer_anio = date('Y',strtotime($fi));
    for($i=0;$i<$meses; $i++){
        $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
        $meses_array[$i][0]['objetivo_ventas'] = isset($arreglo_ventas[$periodo]['objetivo_ventas'])?$arreglo_ventas[$periodo]['objetivo_ventas']:$kpi_inicial;
        if(isset($arreglo_ventas[$periodo]['objetivo_ventas'])){
            $kpi_inicial = $arreglo_ventas[$periodo]['objetivo_ventas'];
        }
        $meses_array[$i][0]['periodo'] = $periodo;
        $meses_array[$i][0]['venta_mes'] = isset($arreglo_ventas[$periodo]['venta_mes'])?$arreglo_ventas[$periodo]['venta_mes']:0;
        $primer_mes++;
        if ($primer_mes == 13){
            $primer_mes = 1;
            $primer_anio ++;
        }
    }
    $this->set('ventas_vs_metas',$meses_array);

    //SACAR EL OBJETIVO DE VENTAS EN MONTO

    $query2 = "SELECT 
    SUM(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
    IFNULL((SELECT SUM(monto) FROM objetivos_ventas_desarrollos WHERE fecha < DATE(CONCAT(periodo,'-01')) AND fin > DATE(CONCAT(periodo,'-01')) AND desarrollo_id IN ($desarrollo_id)),1) AS objetivo_ventas
        FROM 
            ventas
        WHERE 
            ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id)) AND
            ventas.fecha <= '$ff' AND
            ventas.fecha >= '$fi'
        GROUP BY periodo
        ORDER BY periodo";

    $ventas_vs_metas_2 = $this->Desarrollo->query($query2);
    //Armar el arreglo para poder consultarlo con únicamente las ventas
    $arreglo_ventas_2 = array();
    foreach($ventas_vs_metas_2 as $venta):
        $arreglo_ventas_2[$venta[0]['periodo']]['objetivo_ventas']=$venta[0]['objetivo_ventas'];
        $arreglo_ventas_2[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
    endforeach;
    $kpi_inicial_2 = $ventas_vs_metas_2[0][0]['objetivo_ventas'];
    // Variables de ventas vs metas por mes.
    //$this->set(compact('arreglo_ventas_2'));
    //$this->set(compact('ventas_vs_metas'));

    
    $meses_array_2 = array();
    $primer_mes = date('m',strtotime($fi));
    $primer_anio = date('Y',strtotime($fi));
    for($i=0;$i<$meses; $i++){
        $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
        $meses_array_2[$i][0]['objetivo_ventas'] = isset($arreglo_ventas_2[$periodo]['objetivo_ventas'])?$arreglo_ventas_2[$periodo]['objetivo_ventas']:$kpi_inicial_2;
        if(isset($arreglo_ventas_2[$periodo]['objetivo_ventas'])){
            $kpi_inicial_2 = $arreglo_ventas_2[$periodo]['objetivo_ventas'];
        }
        $meses_array_2[$i][0]['periodo'] = $periodo;
        $meses_array_2[$i][0]['venta_mes'] = isset($arreglo_ventas_2[$periodo]['venta_mes'])?$arreglo_ventas_2[$periodo]['venta_mes']:0;
        $primer_mes++;
        if ($primer_mes == 13){
            $primer_mes = 1;
            $primer_anio ++;
        }
    }
    $this->set('ventas_vs_metas_2',$meses_array_2);

    // Definicion de variables globales, mes actual, año actual, leyenda de periodo para graficas.
    $this->set(compact('user'));
    $this->set(compact('mes_actual'));
    $this->set(compact('anio_actual'));
    $this->set(compact('periodo_tiempo'));
    $this->set(compact('periodo_tiempo_mes'));

    // Variables de indicador mensual
    $this->set(compact('objetivo_venta_mensual')); //Esta variable se usa para la grafica de ventas vs meta del mes
    $this->set(compact('total_clientes_mensuales'));
    $this->set(compact('clientes_mensuales'));
    $this->set(compact('unidades_monto_venta_mensual')); //Esta variable se usa para la grafica de ventas vs meta del mes

    // Variables de indicadores anuales
    $this->set(compact('objetivo_venta_anual'));
    $this->set(compact('total_clientes_anuales')); // Esta variable se ocupara en la grafica de estatus de clientes
    $this->set(compact('clientes_anuales')); // Esta variable se ocupara en la grafica de estatus de clientes
    $this->set(compact('clientes_venta_anuales'));
    $this->set(compact('unidades_monto_venta_anuales'));

    // Variables para temperatura de clientes
    $this->set(compact('temperatura_clientes'));

    // Variables de atencion de clientes.
    $this->set(compact('clientes_oportunos'));
    $this->set(compact('clientes_tardia'));
    $this->set(compact('clientes_atrasados'));
    $this->set(compact('clientes_reasignar'));
    $this->set(compact('clientes_sin_seguimiento'));
    $this->set(compact('sum_clientes_atencion'));

    // Variables de mensajes gerenciales y proximos eventos.
    $this->set(compact('mensajes_gerenciales'));
    $this->set('eventos', $data_eventos);
    $this->set('param_return', 0);
    $this->set('return', 2);
    
    // Variables para mostrar propiedades y desarrollos nuevos.
    $this->set(compact('desarrollos_nuevos'));
    $this->set(compact('propiedades_nuevas'));

    // Variable de tabla de cambio de precios.
    $this->set(compact('precios_inmuebles'));
    
    // Variable del mapeo de desarrollos.
    $this->set(compact('ubicaciones_d'));

    // Variables grafica de clientes con linea de contacto (Mensual).
    $this->set(compact('clientes_lineas_mes'));
    $this->set(compact('total_clientes_lineas_mes'));    

    // Variables grafica de clientes con linea de contacto.
    $this->set(compact('clientes_lineas'));
    $this->set(compact('total_clientes_lineas'));
    $this->set(compact('ventas_linea_contacto_arreglo'));
    // Variables para grafica de $ ventas vs linea de contacto
    $this->set(compact('venta_linea_contacto'));
    $this->set(compact('total_venta_linea_contacto'));

    // Variable para el numero de ventas con linea de contacto
    $this->set(compact('n_ventas_contacto'));
    $this->set(compact('total_ventas_unidades'));

    // Variables de ventas vs metas por mes.
    $this->set(compact('ventas_vs_metas'));
    
    //Variable para el número de visitas por linea de contacto
    $this->set(compact('visitas_linea_contacto_arreglo'));
    

    // print_r( $n_ventas_contacto );
    // $this->autoRender = false; 

  }

        


        
  public function password($id = null){
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
            //Completar Información de Usuario
            
            if ($this->request->data['User']['password'] != $this->request->data['User']['password2']) {
                $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
                $this->Session->setFlash('Las contraseñas no coinciden.', 'default', array(), 'm_error'); // Mensaje
                $this->redirect(array('action' => 'password', $id));
            }else{
                $this->request->data['User']['id']       = $id;
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success'); // Mensaje
                    $this->redirect(array('action' => 'index'));
                }else{
                    $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
                    $this->Session->setFlash('Ha ocurrido un error, favor de intentarlo nuevamente. Gracias.', 'default', array(), 'm_error'); // Mensaje
                    $this->redirect(array('action' => 'password', $id));
                }
            }

		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
                        $this->set('nombre',$this->request->data['User']['nombre_completo']);
		}
        }
        
        public function upload(){
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
            if ($this->request->is('post')){
                $id = $this->request->data['User']['id'];
                foreach($this->request->data['User']['archivo'] as $unitario):
                    $filename = getcwd()."/files/users/".$id."/".$unitario['name'];
                    move_uploaded_file($unitario['tmp_name'],$filename);
                endforeach;
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'documents'));    
            }
        }
	
	public function login() {
    date_default_timezone_set('America/Mexico_City');
    $this->Desarrollo->Behaviors->load('Containable');
    $this->loadModel('CuentasUser');
    $this->loadModel('Paramconfig');
    $this->layout = 'login';
    $var_desarrollos = [];
    $s = 0;
    
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
          
			    $this->Session->write('CuentaUsuario',$this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$this->Session->read('Auth.User.id')))));

          $this->Session->write('Permisos',$this->Group->find('first',array('conditions'=>array('Group.id'=>$this->Session->read('CuentaUsuario.CuentasUser.group_id')))));
          
          $this->Session->write('Parametros',$this->Paramconfig->find('first',array('conditions'=>array('Paramconfig.id'=>$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')))));
          
          $this->Session->write('clundef',$this->Cliente->find('count',array('conditions'=>array('Cliente.user_id IS NULL', 'Cliente.cuenta_id'=> $this->Session->read('CuentaUsuario.Cuenta.id')))));

          $this->loadModel('Factura');
          $this->Session->write('facturas_por_autorizar',$this->Factura->find('count',array('conditions'=>array('Factura.aut_pendiente'=> $this->Session->read('Auth.User.id')))));

          $date = date('Y-m-d H:m:i');
          $user_id = $this->Session->read('Auth.User.id');
          $this->User->query("UPDATE users SET last_login = '$date' WHERE id= $user_id");
              

          // Condicion para cookies de password y usuario.
          if ($this->request->data['User']['recordar'] == true) {
              setcookie("remm", $this->request->data['User']['recordar']);  // Cookie Usuario.
              setcookie("name", $this->request->data['User']['correo_electronico']);     // Cookie Usuario.
              setcookie("pass", $this->request->data['User']['password']);  // Cookie Contraseña
          }else{
              setcookie("remm", '0'); // Cookie Usuario
              setcookie("name", '');  // Cookie Usuario
              setcookie("pass", '');  // Cookie Contraseña
          }

			    if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')=="5"){
            $desarrollador =  
              $this->DesarrollosUser->find('all',
                array(
                  'contain'=> false,
                  'conditions' => array(
                    'DesarrollosUser.user_id' => $this->Session->read('Auth.User.id')
                  ),
                  'fields'=>array(
                    'Desarrollo.logotipo',
                    'DesarrollosUser.id',
                    'DesarrollosUser.desarrollo_id',
                    'DesarrollosUser.user_id',
                  ),
                  'contain' => array(
                    'User' => array(
                      'fields' => array(
                        'User.id',
                        'User.nombre_completo',
                        'User.foto',
                        'User.telefono1',
                        'User.telefono2',
                        'User.curp',
                        'User.rfc',
                        'User.created',
                        'User.last_login',
                        'User.foto',
                        'User.foto',
                      )
                    )
                  )
                )
              ); 
            $this->Session->write('Desarrollador', $desarrollador);

            /* Variable de sesión para la consulta de uno o mas desarrollos */
            foreach( $desarrollador as $desarrollo) {
              $var_desarrollos[$s] = $desarrollo['DesarrollosUser']['desarrollo_id'];
              $s++;
            }
            $this->Session->write('Desarrollos', $var_desarrollos);

            return $this->redirect(array('action' => 'index','controller'=>'desarrollos'));
            
			    }else{

                    // $date = date('Y-m-d H:m:i');
                    // $user_id = $this->Session->read('Auth.User.id');
                    // $this->User->query("UPDATE users SET last_login = '$date' WHERE id= $user_id");
                    // print_r($desarrollador);
                    if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')<3){
                      return $this->redirect(array('action'=>'dashboard'));
                    }else{
                      return $this->redirect(array('action'=>'index','controller'=>'clientes'));
                    }
                    // return $this->redirect($this->Auth->redirect());
    
                                /*if ($this->Session->read('Auth.User.last_login')==null){
                                    return $this->redirect(array('controller'=>'users','action'=>'informacion_personal_inicial'));
                                }else{
                                    switch ($this->Session->read('CuentaUsuario.CuentasUser.last_step')){
                                        case(0):
                                            return $this->redirect(array('controller'=>'users','action'=>'informacion_personal'));
                                            break;
                                        case(1):
                                            return $this->redirect(array('controller'=>'users','action'=>'informacion_empresa'));
                                            break;
                                        case(2):
                                            return $this->redirect(array('controller'=>'users','action'=>'parametros_mail'));
                                            break;
                                        case(3):
                                            return $this->redirect(array('controller'=>'users','action'=>'diccionarios'));
                                            break;
                                        case(4):
                                            return $this->redirect(array('controller'=>'users','action'=>'calificacion_cliente'));
                                            break;
                                        default:
                                            return $this->redirect($this->Auth->redirect());
                                            break;
                                    }
                                    
                                }*/
    			}
    			// $this->Session->setFlash('Correo o usuario inválido. Inténtalo de nuevo');
                $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
                $this->Session->setFlash('Correo o usuario inválido.', 'default', array(), 'm_error'); // Mensaje
			}
		}
	}
        
        public function documents(){
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
            $this->layout = 'bos';
        }
	
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
	public function test(){
		$this->layout='bos';
	}
	
	public function index() {
    if ( $this->Session->read('Auth.User.group_id') == 5 ){
      return $this->redirect(array('action' => 'mysession','controller'=>'users'));
    }
    
    $this->CuentasUser->Behaviors->load('Containable');
    $users = $this->CuentasUser->find('all',
      array(
        'fields' => array(
          'cuenta_id',
          'finanzas',
        ),
        'conditions' => array(
          'Cuenta.id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
        ),
        'contain' => array(
          'User' => array(
            'fields' => array(
              'User.id',
              'User.correo_electronico',
              'User.nombre_completo',
              'User.status',
              'User.telefono1',
            )
          ),
          'Cuenta' => array(
            'fields' => 'id'
          ),
          'Grupo' => array(
            'fields' => array(
              'nombre'
            )
          )
        )
      )
    );
    $boleano = array('1' => 'Con acceso', '0' => 'Sin acceso');

    $this->set(compact('users', 'boleano'));

	}
        
public function asesores() {
  $this->User->Behaviors->load('Containable');

  $user_custom = array();
  $data_clientes_atencion      = array('oportunos'=>0, 'tardios'=>0, 'no_atendidos'=>0, 'por_reasignar'=>0, 'inactivos_temp'=>0);
  $date_current                = date('Y-m-d');
  $date_oportunos              = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
  $date_tardios                = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
  $date_no_atendidos           = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

  // Condicion para desarrolladores y cuenta normal.

  if (!empty($this->Session->read('Desarrollador'))) {
    $users = $this->User->find('all',
      array(
        'order'=>array('User.status DESC', 'User.nombre_completo ASC'),
        'conditions'=>array(
          'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').' AND group_id <> 5)',
          'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id IN ('.implode(',', $this->Session->read('Desarrollos') ).'))'
        ),
        'fields'=>array('id', 'nombre_completo', 'foto', 'correo_electronico', 'status'),
        'contain' => array(
          'Cliente'=>array('fields'=>array('created', 'status', 'last_edit'),
            'conditions'=>array('desarrollo_id'=>$this->Session->read('Desarrollos'))
          )
        )
      )
    );
  }else{
    $this->set('desarrollos',$this->Desarrollo->find('list',array(
      'conditions'=>array(
        'OR'=>array(
          'Desarrollo.cuenta_id'=> $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Desarrollo.id IN (SELECT id FROM desarrollos WHERE comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
        )
      )
    )));
    $users = $this->User->find('all',array('order'=>array('User.status DESC', 'User.nombre_completo ASC'),'conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE  /*group_id IN (2,3) AND*/ cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'), 'fields'=>array('id', 'nombre_completo', 'foto', 'correo_electronico', 'status'),'contain' => array('Cliente'=>array('fields'=>array('created', 'status', 'last_edit')))));
  }
  
  // Vamos a armar el arreglo para los asesores.
  foreach ($users as $user) {
    $users_custom[$user['User']['id']]['id']                 = $user['User']['id'];
    $users_custom[$user['User']['id']]['nombre_completo']    = $user['User']['nombre_completo'];
    $users_custom[$user['User']['id']]['foto']               = $user['User']['foto'];
    $users_custom[$user['User']['id']]['correo_electronico'] = $user['User']['correo_electronico'];
    $users_custom[$user['User']['id']]['status']             = $user['User']['status'];

    foreach ($user['Cliente'] as $clientes) {
      // echo date('Y', strtotime($clientes['created']))."<br>";
      if (date('Y', strtotime($clientes['created'])) == date('Y') && $clientes['status'] === 'Activo') {
        if ($clientes['last_edit'] <= $date_current.' 23:59:59' && $clientes['last_edit'] >= $date_oportunos) {$data_clientes_atencion['oportunos']++;}
        elseif($clientes['last_edit'] < $date_oportunos.' 23:59:59' && $clientes['last_edit'] >= $date_tardios.' 00:00:00'){$data_clientes_atencion['tardios']++;}
        elseif($clientes['last_edit'] < $date_tardios.' 23:59:59' && $clientes['last_edit'] >= $date_no_atendidos.' 00:00:00'){$data_clientes_atencion['no_atendidos']++;}
        elseif($clientes['last_edit'] < $date_no_atendidos.' 23:59:59' && $clientes['last_edit'] >= '0000-00-00 00:00:00'){$data_clientes_atencion['por_reasignar']++;}
        else{$data_clientes_atencion['por_reasignar']++;}
      }
    } // Fin del foreach de clientes.
    $users_custom[$user['User']['id']]['oportunos']     = $data_clientes_atencion['oportunos'];
    $users_custom[$user['User']['id']]['tardios']       = $data_clientes_atencion['tardios'];
    $users_custom[$user['User']['id']]['no_atendidos']  = $data_clientes_atencion['no_atendidos']; 
    $users_custom[$user['User']['id']]['por_reasignar'] = $data_clientes_atencion['por_reasignar'];

    $data_clientes_atencion['oportunos']     = 0;
    $data_clientes_atencion['tardios']       = 0;
    $data_clientes_atencion['no_atendidos']  = 0;
    $data_clientes_atencion['por_reasignar'] = 0;
  } // Fin del foreach de usuarios.

  // print_r($users_custom);
  $this->set('users_custom', $users_custom);
}
        
        public function list_clientes() {
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
		$this->layout = 'bos';
		$this->User->recursive = 0;
                $this->Paginator->settings = array('conditions'=>array('User.group_id'=>5));
		$this->set('users', $this->Paginator->paginate());
	}
	
	public function mailbox(){
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
		$this->layout='bos';
	}
	
	public function compose(){
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
		$this->layout ='bos';
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function view($user_id = null) {
  $meses_format = array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');
  
  $count_ventas_mes  = 0;
  $monto_ventas_mes  = 0;
  $q_ventas_mes      = 0;

  // Variables de ventas acumulado al año.
  $monto_ventas_acumulado = 0;
  $q_ventas_acumulado     = 0;

  // Variable para las fecha de las graficas.
  $periodo_tiempo = 'Datos acumulados del asesor.';
  
  // Variables para los clientes mensuales.
  $user['User']['ClientesMes']['QActivos']       = 0;
  $user['User']['ClientesMes']['QInactivosTemp'] = 0;
  $user['User']['ClientesMes']['QInactivosDef']  = 0;
        $q_clientes_activo_mensual               = 0;
        $q_clientes_inactivo_temporal_mensual    = 0;
        $q_clientes_inactivo_definitivo_mensual  = 0;

  // Variables para clientes acumulador
  $user['User']['ClientesAcumulado']['QActivos']             = 0;
  $user['User']['ClientesAcumulado']['QInactivosTemp']       = 0;
  $user['User']['ClientesAcumulado']['QInactivosDef']        = 0;
        $q_clientes_activo_acumulados              = 0;
        $q_clientes_inactivo_temporal_acumulados   = 0;
        $q_clientes_inactivo_definitivo_acumulados = 0;

  // Variable para grafica de estatus de clientes.
  $total_clientes_anuales[0][0]['total_clientes_anuales'] = 0;

  $contador_clientes_anuales = 0;
  

  $date_current         = date('Y-m-d');
  $view_tot_monto_venta = 0;

  $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
  $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
  $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

  $etapas_embudo = array( 1 => 'Interés Preliminar', 2 => 'Comunicación Abierta', 3 => 'Precalificación', 4 => 'Visita', 5 => 'Análisis de Opciones', 6 => 'Validación de Recursos', 7 => 'Cierre');
  

  $this->CuentasUser->Behaviors->load('Containable');
  $this->LogCliente->Behaviors->load('Containable');

  $user = $this->CuentasUser->find('first',
    array(
      'fields'     => array( 'cuenta_id', 'finanzas', 'opcionador', 'puesto', 'unidad_venta', 'ventas_mensuales' ),
      'conditions' => array( 'User.id' => $user_id ),
      'contain'    => array(
        'User' => array(
          'fields'    => array( 'User.id', 'User.correo_electronico', 'User.nombre_completo', 'User.status', 'User.telefono1', 'User.telefono2', 'User.created', 'User.last_login', 'User.foto' ),
          'Cliente'   => array(
            'fields'  => array(
              'temperatura',
              'last_edit',
              'nombre',
              'id',
              'created',
              'etapa',
              'status',
            ),
            'Desarrollo' => array(
              'fields' => array(
                'nombre'
              )
            ),
            'Inmueble' => array(
              'fields' => array(
                'titulo'
              )
            )
          ),
          'Venta' => array(
            'fields' => array(
              'tipo_operacion',
              'fecha',
              'precio_cerrado',
            ),
            'Cliente' => array(
              'fields' => array(
                'nombre',
                'id'
              )
            ),
            'Inmueble' => array(
              'fields' => array(
                'titulo',
                'id',
              )
            ),
          ),
          'VentaMes'
        ),
        'Cuenta' => array(
          'fields' => 'id'
        ),
        'Grupo' => array(
          'fields' => array(
            'nombre'
          )
        )
      )
    )
  );

  /* ---------------------- Ventas del mes y acumulados. ---------------------- */
  foreach( $user['User']['Venta'] as $venta ){
    
    // Condicion extrae ventas mes.
    if( date('Y-m', strtotime($venta['fecha'])) == date('Y-m') ){
      $user['User']['VentaMes'][$count_ventas_mes] = $venta;
      $count_ventas_mes ++;
      $monto_ventas_mes += $venta['precio_cerrado'];
    }
    
    $monto_ventas_acumulado += $venta['precio_cerrado'];

  }
  $q_ventas_mes       = count($user['User']['VentaMes']);
  $q_ventas_acumulado = count($user['User']['Venta']);


  /* -------------------------------- Clientes -------------------------------- */
  foreach( $user['User']['Cliente'] as $cliente ){
    
    // Clientes del mes
    if( date('Y-m', strtotime($cliente['created'])) == date('Y-m') ){

      // Extraer por status
      switch($cliente['status']) {
        case ('Activo'):
          $q_clientes_activo_mensual ++;
          break;
        case('Inactivo temporal'):
          $q_clientes_inactivo_temporal_mensual ++;
          break;
        case('Inactivo'):
          $q_clientes_inactivo_definitivo_mensual ++;
          break;
      }

    } // Fin de condición para clientes del mes

    // Extraer por status
    switch($cliente['status']) {
      case ('Activo'):
        $q_clientes_activo_acumulados ++;
        
        // Variable para gráfica de estatus de clientes.
        $clientes_anuales[0]['clientes']['status'] = $cliente['status'];
        $clientes_anuales[0][0]['total_clientes'] = $q_clientes_activo_acumulados;

        // Variables para gráfica de estatus de atención de clientes.

        if ($cliente['last_edit'] <= $date_current.' 23:59:59' && $cliente['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
        elseif($cliente['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
        elseif($cliente['last_edit'] < $date_tardios.' 23:59:59' && $cliente['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
        elseif($cliente['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
        else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}


        break;

      case('Inactivo temporal'):
        $q_clientes_inactivo_temporal_acumulados ++;
        
        // Variable para gráfica de estatus de clientes.
        $clientes_anuales[1]['clientes']['status'] = $cliente['status'];
        $clientes_anuales[1][0]['total_clientes'] = $q_clientes_inactivo_temporal_acumulados;
        break;

      case('Inactivo'):
        $q_clientes_inactivo_definitivo_acumulados ++;
        
        // Variable para gráfica de estatus de clientes.
        $clientes_anuales[2]['clientes']['status'] = $cliente['status'];
        $clientes_anuales[2][0]['total_clientes'] = $q_clientes_inactivo_definitivo_acumulados;
        break;
    }

    $total_clientes_anuales[0][0]['total_clientes_anuales'] ++;

  }
  sort($clientes_anuales); // Ordenamos el array, en la grafica se desacomoda - Estatus de atencion de clientes.

  
  /* ------ Variables para la grafica de estatus de atentión a clientes. ------ */
  $clientes_atencion        = $this->estatus_atencion_clientes( $user['CuentasUser']['cuenta_id'], $user_id);
  $clientes_oportunos       = $clientes_atencion['clientes_oportunos'];
  $clientes_tardia          = $clientes_atencion['clientes_tardia'];
  $clientes_atrasados       = $clientes_atencion['clientes_atrasados'];
  $clientes_reasignar       = $clientes_atencion['clientes_reasignar'];
  $clientes_sin_seguimiento = $clientes_atencion['clientes_sin_seguimiento'];
  $sum_clientes_atencion    = $clientes_atencion['sum_clientes_atencion'];

  // Variables para la gráfica de contactos por medio de promosion vs ventas
  $medios_vs_ventas = $this->contactos_medio_promosion_vs_ventas($user['CuentasUser']['cuenta_id'], $user_id);
  $ventas_linea_contacto_arreglo = $medios_vs_ventas['ventas_linea_contacto_arreglo'];
  $total_clientes_lineas         = $medios_vs_ventas['total_clientes_lineas'];

  $user['User']['ClientesMes']['QActivos']       = $q_clientes_activo_mensual;
  $user['User']['ClientesMes']['QInactivosTemp'] = $q_clientes_inactivo_temporal_mensual;
  $user['User']['ClientesMes']['QInactivosDef']  = $q_clientes_inactivo_definitivo_mensual;

  $user['User']['ClientesAcumulado']['QActivos']       = $q_clientes_activo_acumulados;
  $user['User']['ClientesAcumulado']['QInactivosTemp'] = $q_clientes_inactivo_temporal_acumulados;
  $user['User']['ClientesAcumulado']['QInactivosDef']  = $q_clientes_inactivo_definitivo_acumulados;

  /* ----------------------- Log de clientes del asesor ----------------------- */
  $logs = $this->LogCliente->find('all',
    array(
      'fields'     => array(
        'accion',
        'mensaje',
        'datetime'
      ),
      'limit'      => 10,
      'conditions' => array(
        'LogCliente.user_id' => $user_id
      ),
      'order'      => 'LogCliente.id DESC',
      'contain'    => array(
        'Cliente' => array(
          'fields' => array(
            'nombre'
          )
        ),
        'User'    => array(
          'fields' => array(
            'nombre_completo'
          )
        )
      )
    )
  );


  /* --------------------------- Seteo de variables. -------------------------- */
  $this->set(compact('user', 'meses_format', 'view_tot_monto_venta', 'periodo_tiempo', 'date_current', 'date_oportunos', 'date_tardios', 'date_no_atendidos', 'etapas_embudo'));

  /* ------------- Variables para el indicador mensual y acumulado ------------ */
  $this->set(compact('q_ventas_mes', 'monto_ventas_mes', 'monto_ventas_acumulado', 'q_ventas_acumulado'));

  /* ------------- Variables para grafica de estatus de clientes. ------------- */
  $this->set(compact('total_clientes_anuales', 'clientes_anuales'));

  /* ----------- Variables para la grafica de atencion de clientes. ----------- */
  $this->set(compact( 'clientes_oportunos', 'clientes_tardia', 'clientes_atrasados', 'clientes_reasignar', 'clientes_sin_seguimiento', 'sum_clientes_atencion'));

  /* ------------- Variable para la gráfica de etapas de clientes. ------------ */
  $this->set('temperatura_clientes', $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$user['CuentasUser']['cuenta_id']." AND status = 'Activo' GROUP BY etapa;"));

  /* ---------- Seteo de variable para el log de clientes del asesor. --------- */
  $this->set(compact('logs'));

  /* -------- Seteo de la variable para la gráfica de medios_vs_ventas -------- */
  $this->set(compact('ventas_linea_contacto_arreglo', 'total_clientes_lineas'));
  
/************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
  $query = "SELECT 
  COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo
      FROM 
          ventas
      WHERE 
          ventas.user_id = $user_id
      GROUP BY periodo
      ORDER BY periodo";

  $ventas_vs_metas = $this->User->query($query);
  //Armar el arreglo para poder consultarlo con únicamente las ventas
  $arreglo_ventas = array();
  foreach($ventas_vs_metas as $venta):
      $arreglo_ventas[$venta[0]['periodo']][0]['periodo'] = $venta[0]['periodo'];
      $arreglo_ventas[$venta[0]['periodo']][0]['objetivo_ventas'] = 1;
      $arreglo_ventas[$venta[0]['periodo']][0]['venta_mes']=$venta[0]['venta_mes'];
  endforeach;
  $kpi_inicial = $user['CuentasUser']['unidad_venta'];
  // Variables de ventas vs metas por mes.
  //$this->set(compact('arreglo_ventas'));
  $this->set('ventas_vs_metas',$arreglo_ventas);

  //SACAR EL OBJETIVO DE VENTAS EN MONTO

  $query2 = "SELECT SUM(ventas.precio_cerrado) AS venta_mes, DATE_FORMAT(ventas.fecha,'%Y-%m') AS periodo,
	cuentas_users.ventas_mensuales as objetivo_ventas
FROM ventas, cuentas_users WHERE ventas.user_id = $user_id AND cuentas_users.user_id = ventas.user_id GROUP BY periodo;";

  $ventas_vs_metas_2 = $this->Desarrollo->query($query2);
  //Armar el arreglo para poder consultarlo con únicamente las ventas
  $arreglo_ventas_2 = array();
  foreach($ventas_vs_metas_2 as $venta):
      $arreglo_ventas_2[$venta[0]['periodo']]['objetivo_ventas']=$user['CuentasUser']['ventas_mensuales'];
      $arreglo_ventas_2[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
  endforeach;
  $kpi_inicial_2 = $user['CuentasUser']['ventas_mensuales'];
  // Variables de ventas vs metas por mes.
  //$this->set(compact('arreglo_ventas_2'));
  $this->set(compact('ventas_vs_metas_2'));

  $eventos = $this->proximos_eventos_15_dias($user_id);
  $this->set(compact('eventos'));



}
/**
 * add method
 *
 * @return void
 */
	public function add() {
                if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
                if ($this->request->is('post')) {
//                    echo var_dump($this->request->data['User']);
//                    echo var_dump(explode(".", $this->request->data['User']['foto']['name']));
                        $foto = $this->request->data['User']['foto'];
                        $this->request->data['User']['foto'] = "user_no_photo.png";
//                        if (isset($foto['name'])){
//                            $foto = $this->request->data['User']['foto'];
//                            $this->request->data['User']['foto'] =  "";
//                        }
                    $this->request->data['User']['password']= $this->Auth->password($this->request->data['User']['password']);
                                      $this->request->data['User']['created']=date('Y-m-d H:i:s');
                    $this->User->create();
                    if ($this->User->save($this->request->data)) {
                                  $id = $this->User->getInsertID();
                    
                    $this->CuentasUser->create();
                    $this->request->data['CuentasUser']['cuenta_id'] = $this->request->data['User']['cuenta_id'];
                    $this->request->data['CuentasUser']['user_id']   = $id;
                    $this->request->data['CuentasUser']['last_step'] = 1;

                    if (isset($this->request->data['User']['cerrador'])){
                      $this->request->data['CuentasUser']['cerrador']    = $this->request->data['User']['cerrador'];
                    }
                    
                    $this->request->data['CuentasUser']['group_id']   = $this->request->data['User']['group_id'];
                    $this->request->data['CuentasUser']['activo']     = 1;
                    $this->request->data['CuentasUser']['opcionador'] = $this->request->data['User']['opcionador'];
                    $this->CuentasUser->save($this->request->data);
                    
                    //Si recibe desarrollos, se crea la tabla
                    if(isset($this->request->data['User']['desarrollos'])&&$this->request->data['User']['desarrollos']!=""){
                      foreach($this->request->data['User']['desarrollos'] as $desarrollo):
                        $this->User->query("INSERT INTO desarrollos_users VALUES(0,$desarrollo,$id)");
                      endforeach;
                    }

                    if (isset($foto['name'])){
                        $unitario = $foto;
                        $nombre = explode(".", $unitario['name']);
                        $nombre_final = uniqid().".".$nombre[1];
                        // $nombre_final = $unitario['name'];
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/users/".$nombre_final;
                        move_uploaded_file($unitario['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/users/".$nombre_final;
                        $this->request->data['User']['foto'] = $ruta;
                        $this->request->data['User']['id'] = $id;
                        $this->User->save($this->request->data);
                    }
                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('El usuario ha sido creado exitosamente.', 'default', array(), 'm_success'); // Mensaje
                    if (isset($this->request->data['User']['regresar'])){
                        return $this->redirect(array('action' => 'asesores','controller'=>'users'));
                    }else{
                        
                        return $this->redirect(array('action' => 'index'));
                    }
				
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
                $this->set('groups',$this->Group->find('list'));
	}
        
        public function add_cliente() {
                if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
                $this->layout = 'bos';
		if ($this->request->is('post')) {
			$this->request->data['User']['password']= $this->Auth->password($this->request->data['User']['password']);
			$this->User->create();
			if ($this->User->save($this->request->data)) {
                                $this->request->data['Asignacion']['user_id']=$this->User->getInsertID();
                                if (!empty($this->request->data['User']['desarrollo_id'])){
                                    $this->request->data['Asignacion']['desarrollo_id'] = $this->request->data['User']['desarrollo_id'];
                                }
                                if (!empty($this->request->data['User']['inmueble_id'])){
                                    $this->request->data['Asignacion']['inmueble_id'] = $this->request->data['User']['inmueble_id'];
                                }
                                $this->Asignacion->save($this->request->data);
				$this->Session->setFlash(__('El usuario ha sido creado exitosamente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'list_clientes'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
                $this->set('inmuebles',$this->Inmueble->find('list',array('conditions'=>array('Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'))));
                $this->set('desarrollos',$this->Desarrollo->find('list'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
    if ($this->Session->read('Permisos.Group.ue') !=1 ) {
      $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
      $this->Session->setFlash('No esta autorizado para usar este modulo, por su comprensión, gracias.', 'default', array(), 'm_error'); // Mensaje
      $this->redirect(array('action'=>'asesores'));
    }
                $this->loadModel('CuentasUser');
                $this->loadModel('Paramconfig');
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
        $usuario = $this->User->read(null,$id);
        $this->set('usuario_foto', $usuario['User']['foto']);
        if ($this->request->is(array('post', 'put'))) {
                    if (isset($this->request->data['User']['foto']) && $this->request->data['User']['foto']['name']!=""){
                        $unitario = $this->request->data['User']['foto'];
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/users/".$unitario['name'];
                        move_uploaded_file($unitario['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/users/".$unitario['name'];
                        $this->request->data['User']['foto'] = $ruta;
                        
                    }else{
                        $this->request->data['User']['foto'] = $usuario['User']['foto'];
                    }
                        
                        $this->User->save($this->request->data);
                        $id = $this->request->data['User']['id'];
                        if (isset($this->request->data['User']['cuentas_user_id']) && isset($this->request->data['User']['cuentas_user_id'])){
                            $this->request->data['CuentasUser']['id']=$this->request->data['User']['cuentas_user_id'];
                            $this->request->data['CuentasUser']['group_id']=$this->request->data['User']['group_id'];
                            $this->request->data['CuentasUser']['puesto']=$this->request->data['User']['puesto'];
                            $this->request->data['CuentasUser']['opcionador']=$this->request->data['User']['opcionador'];
                            $this->request->data['CuentasUser']['finanzas']=$this->request->data['User']['finanzas'];
                            $this->CuentasUser->save($this->request->data);
                        }
                        
                        if (isset($this->request->data['User']['ventas_mensuales']) && isset($this->request->data['User']['unidad_venta'])){
                            
                            if ($this->request->data['User']['ventas_mensuales']!="" && $this->request->data['User']['unidad_venta']!=""){
                            $monto = $this->request->data['User']['ventas_mensuales'];
                            $forma = $this->request->data['User']['unidad_venta'];
                            $this->User->query("UPDATE cuentas_users SET ventas_mensuales = $monto, unidad_venta = $forma WHERE user_id = $id");
                            
                            }else{
                                $this->User->query("UPDATE cuentas_users SET ventas_mensuales = 0, unidad_venta = NULL WHERE user_id = $id");
                            }
                        }

                        // vamos a actualizar las sesiones solo si el usuario que edita es el mismo que la sesion
                        if ($id == $this->Session->read('Auth.User.id')) {
                            $this->Session->write('CuentaUsuario',$this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$this->Session->read('Auth.User.id')))));
                            $this->Session->write('Permisos',$this->Group->find('first',array('conditions'=>array('Group.id'=>$this->Session->read('CuentaUsuario.CuentasUser.group_id')))));
                            $this->Session->write('Parametros',$this->Paramconfig->find('first',array('conditions'=>array('Paramconfig.id'=>$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')))));
                        }
            
                        
                        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                        $this->Session->setFlash('Se han guardado los cambios del usuario exitosamente.', 'default', array(), 'm_success'); // Mensaje
                        switch ($this->request->data['User']['return']):
                            case(1):
                                return $this->redirect(array('action' => 'view',$this->request->data['User']['id']));
                            break;
                            
                            case(2):
                                return $this->redirect(array('action' => 'index'));
                            break;
                        endswitch;
                        
                    //echo var_dump($this->request->data['User']);
		} 
                
                else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                        $usuario = $this->User->find('first', $options);
			$this->request->data = $usuario;
                        //$this->set('usuario',$usuario);                      
                        $this->set('cuentas_users',$this->CuentasUser->findByCuentaIdAndUserId($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),$usuario['User']['id']));
                        $this->set('groups',$this->Group->find('list'));
		}
	}
        
        public function edit_cliente($id = null) {
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            $this->layout = 'bos';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
                       if ($this->User->save($this->request->data)) {
                                
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
                        $this->set('groups',$this->User->Group->find('list',array('order'=>'nombre ASC')));
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
    if ($this->Session->read('Auth.User.group_id')==5){
        return $this->redirect(array('action' => 'mysession','controller'=>'users'));
    }
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function add_event(){
            if ($this->request->is('post')) {
                $inicio = substr($this->request->data['User']['horario'],0,19);
                $fin = substr($this->request->data['User']['horario'],21);
                $fecha = date("Y-m-d H:i:s",strtotime($inicio));
                $recordatorio = date("Y-m-d H:i:s",strtotime($inicio));
                $recordatorio2 = date("Y-m-d H:i:s",strtotime($inicio));
                //array(1=>'15 min antes',2=>'30 min antes',3 =>'1 hr antes',4=>'2 hr antes', 5=>'6 hr antes', 6 =>'12 hr antes', 7=>'1 día antes' , 8=>'2 días antes')
                //echo "Inicio: ".date("Y-m-d H:i:s",strtotime($inicio))."//Fin: ".date("Y-m-d H:i:s",strtotime($fin));
                $this->request->data['Event']['user_id']= $this->Session->read('Auth.User.id');
                $this->request->data['Event']['cliente_id']= $this->request->data['User']['cliente_id'];
                $this->request->data['Event']['nombre_evento']= $this->request->data['User']['nombre_evento'];
                $this->request->data['Event']['fecha_inicio']= date("Y-m-d H:i:s",strtotime($inicio));
                $this->request->data['Event']['fecha_fin']= date("Y-m-d H:i:s",strtotime($fin));
                $this->request->data['Event']['direccion']= $this->request->data['User']['direccion'];
                $this->request->data['Event']['coordenadas']= $this->request->data['User']['coordenadas'];
                $this->request->data['Event']['inmueble_id']= $this->request->data['User']['inmueble_id'];
                $this->request->data['Event']['desarrollo_id']= $this->request->data['User']['desarrollo_id'];
                $this->request->data['Event']['comentarios']= $this->request->data['User']['comentarios'];
                switch ($this->request->data['User']['recordatorio_1']){
                    case 1:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($fecha)));
                        break;
                    case 2:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($fecha)));
                        break;
                    case 3:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($fecha)));
                        break;
                    case 4:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($fecha)));
                        break;
                    case 5:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($fecha)));
                        break;
                    case 6:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($fecha)));
                        break;
                    case 7:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($fecha)));
                        break;
                    case 8:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($fecha)));
                        break;
                    
                }
                switch ($this->request->data['User']['recordatorio_2']){
                    case 1:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($fecha)));
                        break;
                    case 2:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($fecha)));
                        break;
                    case 3:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($fecha)));
                        break;
                    case 4:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($fecha)));
                        break;
                    case 5:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($fecha)));
                        break;
                    case 6:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($fecha)));
                        break;
                    case 7:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($fecha)));
                        break;
                    case 8:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($fecha)));
                        break;
                    
                }
                $this->request->data['Event']['recordatorio_1']= $recordatorio;
                $this->request->data['Event']['recordatorio_2']= $recordatorio2;
                $this->request->data['Event']['to'] = (empty($this->request->data['User']['to']) ? $this->Session->read('Auth.User.id') : $this->request->data['User']['to']);
                
                if ($this->request->data['User']['cliente_id'] != null){
                    $cliente = $this->Cliente->find('first',array('conditions'=>array('Cliente.id'=>$this->request->data['User']['cliente_id'])));
                }
                
                $usuario = $this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['Event']['to'])));
                $cc = array();
                        
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
                            
                            if ($this->request->data['User']['asesores']==1){
                                $asesores = $this->User->find('list',array('conditions'=>array('User.group_id'=>3)));
                                //echo var_dump($asesores);
                                foreach($asesores as $key => $value)
                                {
                                   $this->Event->create();
                                   $this->request->data['Event']['to'] = $key;
                                   $this->Event->save($this->request->data);
                                }
                                //return $this->redirect(array('action' => 'calendar','controller'=>'users'));
                            }
                            if ($this->request->data['User']['gerentes']==1){
                                $gerentes = $this->User->find('list',array('conditions'=>array('User.group_id'=>2)));
                                //echo var_dump($asesores);
                                foreach($gerentes as $key => $value)
                                {
                                   $this->Event->create();
                                   $this->request->data['Event']['to'] = $key;
                                   $this->Event->save($this->request->data);
                                }
                                //return $this->redirect(array('action' => 'calendar','controller'=>'users'));
                            }
                            
                            if ($this->request->data['User']['cliente_id']>0 || !empty($this->request->data['User']['cliente_id'])){
                                $this->Agenda->create();
                                $this->request->data['Agenda']['user_id'] = $this->Session->read("Auth.User.id");
                                $this->request->data['Agenda']['fecha'] = date("Y-m-d H:i:s");
                                $this->request->data['Agenda']['mensaje'] = "Se ha creado el evento ".
                                        $this->request->data['Event']['nombre_evento']
                                        ." para el día ".$this->request->data['Event']['fecha_inicio'];
                                if (!empty($this->request->data['User']['inmueble_id'])){
                                   
                                    $inmueble = $this->Inmueble->read(null,$this->request->data['User']['inmueble_id']);
                                    $this->request->data['Agenda']['mensaje'] = $this->request->data['Agenda']['mensaje']." en la propiedad ".$inmueble['Inmueble']['titulo'];
                                }
                                if (!empty($this->request->data['User']['desarrollo_id'])){
                                    $desarrollo = $this->Desarrollo->read(null,$this->request->data['User']['desarrollo_id']);
                                    $this->request->data['Agenda']['mensaje'] = $this->request->data['Agenda']['mensaje']." en el desarrollo  ".$desarrollo['Desarrollo']['nombre'];
                                }
                                $this->request->data['Agenda']['cliente_id'] = $this->request->data['User']['cliente_id'];
                                
                                $this->Agenda->save($this->request->data);
                                
                                //Enviar mail a agente
                                    $to = array($usuario['User']['correo_electronico']);
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
                                    $this->Email->template('calendario','bosemail');
                                    $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
                                    if ($this->request->data['User']['asesores']==1){
                                        array_merge($to,$asesores);
                                    }
                                    if ($this->request->data['User']['gerentes']==1){
                                        array_merge($to,$gerentes);
                                    }
                                    $this->Email->to($to);
                                    if (!empty($this->request->data['User']['inmueble_id'])){
                                        $this->Email->cc('inmuebles@bosinmobiliaria.com.mx');
                                    }
                                    if (!empty($this->request->data['User']['desarrollo_id'])){
                                        $this->Email->cc('desarrollos@bosinmobiliaria.com.mx');
                                    }
                                    $this->Email->subject('Evento creado');
                                    $this->Email->viewVars(array('asesor'=>$usuario,'comentarios'=>$this->request->data['User']['comentarios'],'cliente' => $cliente,'propiedad'=>$inmueble, 'desarrollo'=>$desarrollo,'fecha'=>date("d/M/Y H:i:s",strtotime($inicio)),'evento'=>$this->request->data['Event']['nombre_evento']));
                                    $this->Email->send();
                                
                               
                            }  
				$this->Session->setFlash(__('El evento ha sido registrado exitosamente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'calendar'));
                                
			} else {
				$this->Session->setFlash(__('El evento no pudo ser registrado. Intenta de nuevo'),'default',array('class'=>'error'));
			}
            }
        }

        



        /* Funcion para consulta de eventos en calendario segun usuario. */
        public function calendar(){
          $this->Event->Behaviors->load('Containable');
          $asesores        = '';
          $clientes        = [];
          $desarrollos     = [];
          $inmuebles       = [];
          $eventos         = [];
          $data_evento     = [];
          $s               = 0;
          $hours           = [];
          $minutos         = [];
          $data_eventos    = [];
          $opt_desarrollos = [];
          $opt_inmuebles   = [];


          $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
          $tipo_tarea          = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 4=>'Reactivación', 1=>'Visita');
          $tipo_tarea_opciones = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
          $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'check-circle', 'child' );
          $remitente           = '';
          $color               = '#AEE9EA';
          $textColor           = '#2f2f2f';
          $recordatorios       = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');
          $status              = array(0=> 'Creado(s)', 2=>'Cancelado(s)');

          if ( $this->Session->read('Permisos.Group.call') == 1 ) { // SuperAdmin y Gerentes
            
            $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')');
            
            // $condiciones_clientes    = array('Cliente.status' => 'Activo', 'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Cliente.user_id <>' => '');

            $condiciones_clientes = array(
              'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id <>'    => ''
                ),
              'OR'=>array(
                  'Cliente.cuenta_id'     => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                  'Cliente.id IN (SELECT id FROM clientes WHERE desarrollo_id IN(SELECT id FROM desarrollos WHERE comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."))",
                  'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
              )
            );


            $condiciones_eventos     = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'));
          
          } elseif( $this->Session->read('Permisos.Group.id') == 5 ){ // Desarrolladores.
            
            $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')', 'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id IN ('.implode(',', $this->Session->read('Desarrollos') ).'))');
            
            $condiciones_clientes    = array('Cliente.status' => 'Activo', 'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Cliente.user_id <>' => '', 'Cliente.desarrollo_id' => $this->Session->read('Desarrollos'));

            $condiciones_eventos     = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Event.desarrollo_id' => $this->Session->read('Desarrollos'), 'Event.inmueble_id'   => '(Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ('.implode(',', $this->Session->read('Desarrollos') ).'))');

            // Condición para el campo de desarrollos en el filtro del calendario.
            $opt_desarrollos = $this->Desarrollo->find('list', array(
              'conditions' => array(
                'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Desarrollo.id'        => $this->Session->read('Desarrollos')
              ),
              'order' => 'Desarrollo.nombre ASC'
            ));

          
          } else{ // Asesores
            $condiciones_asesores    = array('User.id' => $this->Session->read('Auth.User.id'));
            
            $condiciones_clientes    = array('Cliente.status' => 'Activo', 'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') , 'Cliente.user_id'   => $this->Session->read('Auth.User.id'));


            $condiciones_eventos     = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Event.user_id'     => $this->Session->read('Auth.User.id'));
          }


          $asesores = $this->User->find('list', array(
            'conditions' => $condiciones_asesores,
            'order' => 'User.nombre_completo ASC'
          ));

          $clientes = $this->Cliente->find('list', array(
            'conditions' => $condiciones_clientes,
            'order' => 'Cliente.nombre ASC'
          ));
          
          $opt_desarrollos = $this->Desarrollo->find('list', array(
            'conditions' => array(
              'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Desarrollo.visible' => 1
            ),
            'order' => 'Desarrollo.nombre ASC'
          ));

          $opt_inmuebles = $this->Inmueble->find('list', array(
            'conditions' => array(
              'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)',
              'Inmueble.liberada' => 1
            ),
            'order' => 'Inmueble.titulo ASC'
          ));
          
          for($i=7;$i<=22;$i++){
            $hours[str_pad($i,2,'0',STR_PAD_LEFT)] =  str_pad($i,2,'0',STR_PAD_LEFT);
          }
          
          for( $i = 0; $i < 60; $i += 5 ){
            $minutos[str_pad($i,2,'0',STR_PAD_LEFT)] =  str_pad($i,2,'0',STR_PAD_LEFT);
          }

          if ($this->request->is('post')) {

            if( $this->Session->read('Permisos.Group.id') == 5 ) {
              
              // Condición para el campo de desarrollos en el filtro del calendario.
              $opt_desarrollos = $this->Desarrollo->find('list', array(
                'conditions' => array(
                  'Desarrollo.id'        => $this->Session->read('Desarrollos')
                ),
                'order' => 'Desarrollo.nombre ASC'
              ));

            }
            
            $condiciones_eventos = array(
              'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            );

            if ( !empty( $this->request->data['Event']['asesor_id'] ) ){
              array_push($condiciones_eventos, array('Event.user_id'    => $this->request->data['Event']['asesor_id']));
            }

            if ( $this->request->data['Event']['cliente_id'] != 0 ){
              array_push($condiciones_eventos, array('Event.cliente_id'    => $this->request->data['Event']['cliente_id']));
            }

            if ( $this->request->data['Event']['desarrollo_id'] != 0 ){
              array_push($condiciones_eventos, array('Event.desarrollo_id'    => $this->request->data['Event']['desarrollo_id']));
            }else {

              if( $this->Session->read('Permisos.Group.id') == 5 ) {
              
                array_push($condiciones_eventos, array('Event.desarrollo_id'    => $this->Session->read('Desarrollos') ));
  
              }

            }

            if ( $this->request->data['Event']['inmueble_id'] != 0 ){
              array_push($condiciones_eventos, array('Event.inmueble_id'    => $this->request->data['Event']['inmueble_id']));
            }

            if ( $this->request->data['Event']['tipo_tarea'] != '' ){
              
              if($this->request->data['Event']['tipo_tarea'] == 4) {
                $condiciones_eventos = array(
                  'Event.tipo_evento' => 0,
                  'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                  'Event.tipo_tarea'  => $this->request->data['Event']['tipo_tarea']
                );
              }else{
                array_push($condiciones_eventos, array('Event.tipo_tarea'    => $this->request->data['Event']['tipo_tarea']));
              }

            }else {
              array_push($condiciones_eventos, array('Event.tipo_evento'    => 1 ));
            }

            if ( !empty( $this->request->data['Event']['status'] ) ){
              array_push($condiciones_eventos, array('Event.status'    => $this->request->data['Event']['status']));
            }

            $eventos = $this->Event->find('all', array(
              'conditions' => $condiciones_eventos,
              'contain' => array(
                'User' => array(
                  'fields' => array(
                      'User.id',
                      'User.nombre_completo',
                      'User.correo_electronico',
                  )
                ),
                'Inmueble' => array(
                    'fields' => array(
                        'Inmueble.id',
                        'Inmueble.titulo'
                    )
                ),
                'Desarrollo' => array(
                    'fields' => array(
                        'Desarrollo.id',
                        'Desarrollo.nombre'
                    )
                ),
                'Cliente' => array(
                    'fields' => array(
                        'Cliente.id',
                        'Cliente.nombre'
                    )
                )
              )
            ));

            if( empty($eventos) ){


              if ( $this->Session->read('Permisos.Group.call') == 1 ) { // SuperAdmin y Gerentes
                $condiciones_eventos     = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'));
              
              } elseif( !empty($this->Session->read('Desarrollador')) ){ // Desarrolladores.
                $condiciones_eventos     = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Event.desarrollo_id' => $this->Session->read('Desarrollos'), 'Event.inmueble_id'   => '(Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$this->Session->read('Desarrollos').')');
              
              } else{ // Asesores
                $condiciones_eventos     = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'), 'Event.user_id'     => $this->Session->read('Auth.User.id'));
              }

              $eventos = $this->Event->find('all', array(
                'conditions' => $condiciones_eventos,
                'contain' => array(
                  'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.nombre_completo',
                        'User.correo_electronico',
                    )
                  ),
                  'Inmueble' => array(
                      'fields' => array(
                          'Inmueble.id',
                          'Inmueble.titulo'
                      )
                  ),
                  'Desarrollo' => array(
                      'fields' => array(
                          'Desarrollo.id',
                          'Desarrollo.nombre'
                      )
                  ),
                  'Cliente' => array(
                      'fields' => array(
                          'Cliente.id',
                          'Cliente.nombre'
                      )
                  )
                )
              ));

              $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
              $this->Session->setFlash('No se han encontrado resultados con estos filtros, intentarlo nuevamente.', 'default', array(), 'm_success'); // Mensaje

            }


            foreach( $eventos as $evento ) {

              switch ($evento['Event']['tipo_tarea']) {
                case 0: // Cita
                  $remitente = 'para';
                  $color = '#AEE9EA';
                break;
                case 1: // Visita
                  $remitente = 'de';
                  $color = '#7CC3C4';
                break;
                case 2: //Llamada
                  $remitente = 'a';
                  $color = '#7AABF9';
                break;
                case 3: // Correo
                  $remitente = 'para';
                  $color = '#F0D38A';
                break;
                case 4: // Reactivacion
                  $remitente = 'de';
                  $color = '#ffe048';
                break;
              }
  
              if( $evento['Event']['status'] == 2) {
                $color = '#2f2f2f';
                $textColor = '#fff';
              }else {
                $textColor = '#2f2f2f';
              }
              
  
              if( isset($evento['Desarrollo']['nombre']) ){
                $nombre_ubicacion = strtoupper(rtrim(str_replace($limpieza, "", $evento['Desarrollo']['nombre'])));
                $url_ubicacion    = '../desarrollos/view/'.$evento['Desarrollo']['id'];
              }else{
                $nombre_ubicacion = strtoupper(rtrim(str_replace($limpieza, "", $evento['Inmueble']['titulo'])));
                $url_ubicacion    = '../inmuebles/view/'.$evento['Inmueble']['id'];
              }
  
              $s++;
              $data_eventos[$s]['titulo']       = strtoupper($evento['Cliente']['nombre']);
              $data_eventos[$s]['fecha_inicio'] = date('Y-m-d', strtotime($evento['Event']['fecha_inicio'])).'T'.date('H:i:s', strtotime($evento['Event']['fecha_inicio']));
              $data_eventos[$s]['color']        = $color;
              $data_eventos[$s]['textColor']    = $textColor;
              $data_eventos[$s]['icon']         = $tipo_tarea_icon[$evento['Event']['tipo_tarea']];
              
              $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))."','".date('H', strtotime($evento['Event']['fecha_inicio']))."','".date('i', strtotime($evento['Event']['fecha_inicio']))."','".$evento['Event']['desarrollo_id']."','".$evento['Event']['inmueble_id']."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_1']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_1']))."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_2']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_2']))."','".$evento['Event']['opt_recordatorio_1']."','".$evento['Event']['opt_recordatorio_2']."')";
              
            }

            $this->set(compact('data_eventos'));

          }else { // Fin del post

            $eventos = $this->Event->find('all', array(
              'conditions' => $condiciones_eventos,
              'contain' => array(
                'User' => array(
                  'fields' => array(
                      'User.id',
                      'User.nombre_completo',
                      'User.correo_electronico',
                  )
                ),
                'Inmueble' => array(
                    'fields' => array(
                        'Inmueble.id',
                        'Inmueble.titulo'
                    )
                ),
                'Desarrollo' => array(
                    'fields' => array(
                        'Desarrollo.id',
                        'Desarrollo.nombre'
                    )
                ),
                'Cliente' => array(
                    'fields' => array(
                        'Cliente.id',
                        'Cliente.nombre'
                    )
                )
              )
            ));

            foreach( $eventos as $evento ) {

              switch ($evento['Event']['tipo_tarea']) {
                case 0: // Cita
                  $remitente = 'para';
                  $color = '#AEE9EA';
                break;
                case 1: // Visita
                  $remitente = 'de';
                  $color = '#7CC3C4';
                break;
                case 2: //Llamada
                  $remitente = 'a';
                  $color = '#7AABF9';
                break;
                case 3: // Correo
                  $remitente = 'para';
                  $color = '#F0D38A';
                break;
                case 4: // Reactivacion
                  $remitente = 'de';
                  $color = '#ffe048';
                break;
              }

              if( $evento['Event']['status'] == 2) {
                $color = '#2f2f2f';
                $textColor = '#fff';
              }else {
                $textColor = '#2f2f2f';
              }
              

              if( isset($evento['Desarrollo']['nombre']) ){
                $nombre_ubicacion = strtoupper(rtrim(str_replace($limpieza, "", $evento['Desarrollo']['nombre'])));
                $url_ubicacion    = '../desarrollos/view/'.$evento['Desarrollo']['id'];
              }else{
                $nombre_ubicacion = strtoupper(rtrim(str_replace($limpieza, "", $evento['Inmueble']['titulo'])));
                $url_ubicacion    = '../inmuebles/view/'.$evento['Inmueble']['id'];
              }

              $s++;
              $data_eventos[$s]['titulo']       = strtoupper($evento['Cliente']['nombre']);
              $data_eventos[$s]['fecha_inicio'] = date('Y-m-d', strtotime($evento['Event']['fecha_inicio'])).'T'.date('H:i:s', strtotime($evento['Event']['fecha_inicio']));
              $data_eventos[$s]['color']        = $color;
              $data_eventos[$s]['textColor']    = $textColor;
              $data_eventos[$s]['icon']         = $tipo_tarea_icon[$evento['Event']['tipo_tarea']];
              $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))."','".date('H', strtotime($evento['Event']['fecha_inicio']))."','".date('i', strtotime($evento['Event']['fecha_inicio']))."','".$evento['Event']['desarrollo_id']."','".$evento['Event']['inmueble_id']."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_1']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_1']))."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_2']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_2']))."','".$evento['Event']['opt_recordatorio_1']."','".$evento['Event']['opt_recordatorio_2']."')";
              
            }
            $this->set(compact('data_eventos'));

            if( $this->Session->read('Permisos.Group.id') == 5 ) {
              
              // Condición para el campo de desarrollos en el filtro del calendario.
              $opt_desarrollos = $this->Desarrollo->find('list', array(
                'conditions' => array(
                  'Desarrollo.id'        => $this->Session->read('Desarrollos')
                ),
                'order' => 'Desarrollo.nombre ASC'
              ));

            }
          }

          // Podemos setear el evento para mostrar el calendario limpio
          $this->set(compact('asesores'));
          $this->set(compact('clientes'));
          $this->set(compact('opt_desarrollos'));
          $this->set(compact('opt_inmuebles'));
          $this->set(compact('eventos'));
          $this->set(compact('tipo_tarea'));
          $this->set(compact('tipo_tarea_opciones'));
          $this->set(compact('recordatorios'));
          $this->set(compact('status'));
          $this->set(compact('hours'));
          $this->set(compact('minutos'));
          $this->set(compact('data_eventos'));
          $this->set('param_return', 0);
          $this->set('return', 0);
          

          // $this->autoRender = false; 

        } // Fin de la funcion calendar










        
        public function calendar_cliente(){
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            $this->loadModel('Cliente');
            $cliente = "";
            $inmueble = "";
            $desarrollo = "";
            $this->layout = 'calendar';
            if ($this->request->is('post')) {
                $inicio = substr($this->request->data['User']['horario'],0,19);
                $fin = substr($this->request->data['User']['horario'],21);
                //echo "Inicio: ".date("Y-m-d H:i:s",strtotime($inicio))."//Fin: ".date("Y-m-d H:i:s",strtotime($fin));
                $this->request->data['Event']['user_id']= $this->Session->read('Auth.User.id');
                $this->request->data['Event']['cliente_id']= $this->request->data['User']['cliente_id'];
                $this->request->data['Event']['nombre_evento']= $this->request->data['User']['nombre_evento'];
                $this->request->data['Event']['fecha_inicio']= date("Y-m-d H:i:s",strtotime($inicio));
                $this->request->data['Event']['fecha_fin']= date("Y-m-d H:i:s",strtotime($fin));
                $this->request->data['Event']['direccion']= $this->request->data['User']['direccion'];
                $this->request->data['Event']['coordenadas']= $this->request->data['User']['coordenadas'];
                $this->request->data['Event']['inmueble_id']= $this->request->data['User']['inmueble_id'];
                $this->request->data['Event']['desarrollo_id']= $this->request->data['User']['desarrollo_id'];
                $this->request->data['Event']['comentarios']= $this->request->data['User']['comentarios'];
                $this->request->data['Event']['recordatorio_1']= $this->request->data['User']['recordatorio_1'];
                $this->request->data['Event']['recordatorio_2']= $this->request->data['User']['recordatorio_2'];
                $this->request->data['Event']['to'] = (empty($this->request->data['User']['to']) ? $this->Session->read('Auth.User.id') : $this->request->data['User']['to']);
                
                if ($this->request->data['User']['cliente_id'] != null){
                    $cliente = $this->Cliente->find('first',array('conditions'=>array('Cliente.id'=>$this->request->data['User']['cliente_id'])));
                }
                
                $usuario = $this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['Event']['user_id'])));
                $cc = array();
                        
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
                            if ($this->request->data['User']['cliente_id']>0 || !empty($this->request->data['User']['cliente_id'])){
                                $this->Agenda->create();
                                $this->request->data['Agenda']['user_id'] = $this->Session->read("Auth.User.id");
                                $this->request->data['Agenda']['fecha'] = date("Y-m-d H:i:s");
                                $this->request->data['Agenda']['mensaje'] = "Se ha creado el evento ".
                                        $this->request->data['Event']['nombre_evento']
                                        ." para el día ".$this->request->data['Event']['fecha_inicio'];
                                if (!empty($this->request->data['User']['inmueble_id'])){
                                   
                                    $inmueble = $this->Inmueble->read(null,$this->request->data['User']['inmueble_id']);
                                    $this->request->data['Agenda']['mensaje'] = $this->request->data['Agenda']['mensaje']." en la propiedad ".$inmueble['Inmueble']['titulo'];
                                }
                                if (!empty($this->request->data['User']['desarrollo_id'])){
                                    $desarrollo = $this->Desarrollo->read(null,$this->request->data['User']['desarrollo_id']);
                                    $this->request->data['Agenda']['mensaje'] = $this->request->data['Agenda']['mensaje']." en el desarrollo  ".$desarrollo['Desarrollo']['nombre'];
                                }
                                $this->request->data['Agenda']['cliente_id'] = $this->request->data['User']['cliente_id'];
                                
                                $this->Agenda->save($this->request->data);
                                
                                //Enviar mail a agente
                                
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
                                    $this->Email->template('calendario','bosemail');
                                    $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
                                    $this->Email->to($usuario['User']['correo_electronico']);
                                    if (!empty($this->request->data['User']['inmueble_id'])){
                                        $this->Email->cc('inmuebles@bosinmobiliaria.com.mx');
                                    }
                                    if (!empty($this->request->data['User']['desarrollo_id'])){
                                        $this->Email->cc('desarrollos@bosinmobiliaria.com.mx');
                                    }
                                    $this->Email->subject('Evento creado');
                                    $this->Email->viewVars(array('asesor'=>$usuario,'comentarios'=>$this->request->data['User']['comentarios'],'cliente' => $cliente,'propiedad'=>$inmueble, 'desarrollo'=>$desarrollo,'fecha'=>date("d/M/Y H:i:s",strtotime($inicio)),'evento'=>$this->request->data['Event']['nombre_evento']));
                                    $this->Email->send();
                                
                                
                            }  
				$this->Session->setFlash(__('El evento ha sido registrado exitosamente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['User']['cliente_id']));
                                
			} else {
				$this->Session->setFlash(__('El evento no pudo ser registrado. Intenta de nuevo'),'default',array('class'=>'error'));
			}
                        
            }else{
                if ($this->Session->read('Auth.User.Group.cown')==1 && $this->Session->read('Auth.User.Group.call')==0){
                        $clientes = $this->Cliente->find('list',array('fields'=>array('Cliente.id','Cliente.nombre'),'order'=>'Cliente.nombre ASC','conditions'=>array('Cliente.etapa_comercial'=>'CRM','Cliente.user_id'=>$this->Session->read('Auth.User.id'))));
                    }else{
                        $clientes = $this->Cliente->find('list',array('fields'=>array('Cliente.id','Cliente.nombre'),'order'=>'Cliente.nombre ASC','conditions'=>array('Cliente.etapa_comercial'=>'CRM')));
                        
                    }
                    $this->set('inmuebles',$this->Inmueble->find('list'));
                    $this->set('desarrollos',$this->Desarrollo->find('list'));
                    $this->set(compact('clientes'));
                    $this->set('users',$this->User->find('list'));
                    
                    $this->set('eventos',$this->Event->find('all',array('conditions'=>array('Event.to'=>$this->Session->read('Auth.User.id')))));
            }
        }
        
        public function add_propiedad($id = null) {
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
                $this->layout = 'bos';
		if ($this->request->is('post')) {
                    $this->request->data['Asignacion']['user_id'] = $this->request->data['User']['cliente_id'];
                    $this->request->data['Asignacion']['desarrollo_id'] = $this->request->data['User']['desarrollo_id'];
                    $this->request->data['Asignacion']['inmueble_id'] = $this->request->data['User']['inmueble_id'];
                    $this->Asignacion->create();
                    $this->Asignacion->save($this->request->data);
                    $this->Session->setFlash(__('Se ha asignado exitosamente la propiedad al cliente'),'default',array('class'=>'success'));
                    return $this->redirect(array('action' => 'users','controller'=>'list_clientes'));
                }
		$this->set('cliente',$this->User->read(null,$id));
                $this->set('inmuebles',$this->Inmueble->find('list',array('conditions'=>array('Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'))));
                $this->set('desarrollos',$this->Desarrollo->find('list'));
	}
                
        public function first_steps_bak(){
            if ($this->request->is('post')) {
                //echo var_dump($this->request->data);
//              echo var_dump($this->Session->read());
                $this->loadModel('Paramconfig');
                $this->loadModel('Mailconfig');
                
                //Completar Información de Usuario
                $this->request->data['User']['id'] = $this->Session->read('Auth.User.id');
                $this->request->data['User']['nombre'] = $this->request->data['nombre'];
                $this->request->data['User']['correo_electronico'] = $this->request->data['email'];
                $this->request->data['User']['telefono1'] = $this->request->data['telefono1'];
                $this->request->data['User']['telefono2'] = $this->request->data['telefono2'];
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['password']);
                $ruta = "";
                if ($this->request->data['User']['profile_picture']['name']!=null){
			$filename = getcwd()."/files/users/".$this->Session->read('Auth.User.id')."/".$this->request->data['User']['profile_picture']['name'];
			move_uploaded_file($this->request->data['User']['profile_picture']['tmp_name'],$filename);
			$ruta = "/files/users/".$this->Session->read('Auth.User.id')."/".$this->request->data['User']['profile_picture']['name'];
                }
                $this->request->data['User']['foto'] = $ruta;
                $this->request->data['User']['last_login'] = date('Y-m-d H:i:s');
                $this->User->create();
                $this->User->save($this->request->data);
                
                //Crear parámetros
                $this->request->data['Paramconfig']['mr'] = $this->request->data['User']['mr'];
                $this->request->data['Paramconfig']['to_mr'] = $this->request->data['User']['to_mr'];
                $this->request->data['Paramconfig']['cc_mr'] = $this->request->data['User']['cc_mr'];
                $this->request->data['Paramconfig']['cco_mr'] = $this->request->data['User']['cco_mr'];
                $this->request->data['Paramconfig']['mep'] = $this->request->data['User']['mep'];
                $this->request->data['Paramconfig']['cc_mep'] = $this->request->data['User']['cc_mep'];
                $this->request->data['Paramconfig']['cco_mep'] = $this->request->data['User']['cco_mep'];
                $this->request->data['Paramconfig']['ma'] = $this->request->data['User']['ma'];
                $this->request->data['Paramconfig']['cc_ma'] = $this->request->data['User']['cc_ma'];
                $this->request->data['Paramconfig']['cco_ma'] = $this->request->data['User']['cco_ma'];
                $this->request->data['Paramconfig']['sla_atrasados'] = $this->request->data['User']['sla_atrasados'];
                $this->request->data['Paramconfig']['sla_no_atendidos'] = $this->request->data['User']['sla_no_atendidos'];
                $this->request->data['Paramconfig']['llamadas'] = $this->request->data['User']['llamadas'];
                $this->request->data['Paramconfig']['emails'] = $this->request->data['User']['emails'];
                $this->request->data['Paramconfig']['visitas'] = $this->request->data['User']['visitas'];
                $this->Paramconfig->create();
                $this->Paramconfig->save($this->request->data);
                debug($this->Paramconfig->validationErrors);
                $idParamConfig = $this->Paramconfig->getInsertId();
//                
//                //Crear Parámetros de mail
                $this->request->data['Mailconfig']['smtp'] = $this->request->data['User']['smtp'];
                $this->request->data['Mailconfig']['usuario'] = $this->request->data['User']['usuario_mail'];
                $this->request->data['Mailconfig']['password'] = $this->request->data['User']['password_mail'];
                $this->request->data['Mailconfig']['puerto'] = $this->request->data['User']['puerto_mail'];
                $this->Mailconfig->create();
                $this->Mailconfig->save($this->request->data);
                debug($this->Mailconfig->validationErrors);
                $idMailconfig = $this->Mailconfig->getInsertID();
                  
//                //Update Cuenta
                  
                $this->request->data['Cuenta']['id'] = $this->Session->read('CuentaUsuario.Cuenta.id');
                $this->request->data['Cuenta']['razon_social'] = $this->request->data['razon_social'];
                $this->request->data['Cuenta']['rfc'] = $this->request->data['rfc'];
                $this->request->data['Cuenta']['direccion'] = $this->request->data['direccion_fiscal'];
                $this->request->data['Cuenta']['telefono_1'] = $this->request->data['telefono_empresa_1'];
                $this->request->data['Cuenta']['telefono_2'] = $this->request->data['telefono_empresa_2'];
                $this->request->data['Cuenta']['pagina_web'] = $this->request->data['pagina_web'];
                $this->request->data['Cuenta']['correo_contacto'] = $this->request->data['correo_contacto'];
                $this->request->data['Cuenta']['nombre_comercial'] = $this->request->data['nombre_comercial'];
                $this->request->data['Cuenta']['paramconfig_id'] = $idParamConfig;
                $this->request->data['Cuenta']['mailconfig_id'] = $idMailconfig;
                $logo = "";
                if ($this->request->data['User']['logo']['name']!=null){
			$filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/generales/".$this->request->data['User']['logo']['name'];
			move_uploaded_file($this->request->data['User']['logo']['tmp_name'],$filename);
			$logo = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/generales/".$this->request->data['User']['logo']['name'];
                }
                $this->request->data['Cuenta']['logo'] = $logo;
                $this->Cuenta->create();
                $this->Cuenta->save($this->request->data);
                debug($this->Cuenta->validationErrors);
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                return $this->redirect(array('controller' => 'clientes','action'=>'index'));
                //echo var_dump($this->request->data);
            }
        }
        public function informacion_personal(){
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['User']['id'] = $this->Session->read('Auth.User.id');
                $this->request->data['User']['nombre'] = $this->request->data['nombre'];
                $this->request->data['User']['correo_electronico'] = $this->request->data['email'];
                $this->request->data['User']['telefono1'] = $this->request->data['telefono1'];
                $this->request->data['User']['telefono2'] = $this->request->data['telefono2'];
                $this->request->data['User']['last_login'] = date('Y-m-d H:i:s');
                $this->User->create();
                $this->User->save($this->request->data);
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                return $this->redirect(array('controller' => 'users','action'=>'informacion_empresa'));
                //echo var_dump($this->request->data);
            }
        }
        
        public function informacion_personal_inicial(){
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['User']['id'] = $this->Session->read('Auth.User.id');
                $this->request->data['User']['nombre'] = $this->request->data['nombre'];
                $this->request->data['User']['correo_electronico'] = $this->request->data['email'];
                $this->request->data['User']['telefono1'] = $this->request->data['telefono1'];
                $this->request->data['User']['telefono2'] = $this->request->data['telefono2'];
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['password']);
                $ruta = "";
                if ($this->request->data['User']['profile_picture']['name']!=null){
			$filename = getcwd()."/files/users/".$this->Session->read('Auth.User.id')."/".$this->request->data['User']['profile_picture']['name'];
			move_uploaded_file($this->request->data['User']['profile_picture']['tmp_name'],$filename);
			$ruta = "/files/users/".$this->Session->read('Auth.User.id')."/".$this->request->data['User']['profile_picture']['name'];
                }
                $this->request->data['User']['foto'] = $ruta;
                $this->request->data['User']['last_login'] = date('Y-m-d H:i:s');
                $this->User->create();
                $this->User->save($this->request->data);
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                $this->User->query("UPDATE cuentas_users SET last_step = 1 WHERE id = $cuentas_user_id");
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                return $this->redirect(array('controller' => 'users','action'=>'informacion_empresa'));
                //echo var_dump($this->request->data);
            }
        }
        
        public function change_password(){
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['User']['id']       = $this->Session->read('Auth.User.id');
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['password']);

                $this->User->save($this->request->data);


                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success'); // Mensaje
                $this->redirect(array('controller' => 'users','action'=>'change_password'));
                //echo var_dump($this->request->data);
            }
        }
        
        public function informacion_empresa(){
            
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['Cuenta']['id'] = $this->Session->read('CuentaUsuario.Cuenta.id');
                $this->request->data['Cuenta']['razon_social'] = $this->request->data['razon_social'];
                $this->request->data['Cuenta']['rfc'] = $this->request->data['rfc'];
                $this->request->data['Cuenta']['direccion'] = $this->request->data['direccion_fiscal'];
                $this->request->data['Cuenta']['telefono_1'] = $this->request->data['telefono_empresa_1'];
                $this->request->data['Cuenta']['telefono_2'] = $this->request->data['telefono_empresa_2'];
                $this->request->data['Cuenta']['pagina_web'] = $this->request->data['pagina_web'];
                $this->request->data['Cuenta']['correo_contacto'] = $this->request->data['correo_contacto'];
                $this->request->data['Cuenta']['nombre_comercial'] = $this->request->data['nombre_comercial'];
                $logo = "";
                if ($this->request->data['User']['logo']['name']!=null){
			$filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/generales/".$this->request->data['User']['logo']['name'];
			move_uploaded_file($this->request->data['User']['logo']['tmp_name'],$filename);
			$logo = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/generales/".$this->request->data['User']['logo']['name'];
                }
                $this->request->data['Cuenta']['logo'] = $logo;
                $this->Cuenta->create();
                $this->Cuenta->save($this->request->data);
                
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                $this->User->query("UPDATE cuentas_users SET last_step = 2 WHERE id = $cuentas_user_id");
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                return $this->redirect(array('controller' => 'users','action'=>'parametros_mail'));
                //echo var_dump($this->request->data);
            }
        }
        
        public function parametros_mail(){
            $this->loadModel('Mailconfig');
            $this->loadModel('Paramconfig');
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['Mailconfig']['id'] = $this->Session->read('CuentaUsuario.Cuenta.mailconfig_id');
                //configuracion Gmail
                if (strpos($this->request->data['User']['cuenta_correo'],"@gmail.com")){
                    $this->request->data['Mailconfig']['smtp'] = "ssl://smtp.gmail.com";
                    $this->request->data['Mailconfig']['usuario'] = $this->request->data['User']['cuenta_correo'];
                    $this->request->data['Mailconfig']['cuenta_correo'] = $this->request->data['User']['cuenta_correo'];
                    $this->request->data['Mailconfig']['password'] = $this->request->data['User']['password_mail'];
                    $this->request->data['Mailconfig']['puerto'] = "465";
                
                }else{
                    $this->request->data['Mailconfig']['cuenta_correo'] = $this->request->data['User']['cuenta_correo'];
                    $this->request->data['Mailconfig']['smtp'] = $this->request->data['User']['smtp'];
                    $this->request->data['Mailconfig']['usuario'] = $this->request->data['User']['usuario_mail'];
                    $this->request->data['Mailconfig']['password'] = $this->request->data['User']['password_mail'];
                    $this->request->data['Mailconfig']['puerto'] = $this->request->data['User']['puerto_mail'];
                }
                $this->Mailconfig->create();
                $this->Mailconfig->save($this->request->data);
                
                $idMailconfig = $this->Mailconfig->getInsertID();
                
                $this->request->data['Paramconfig']['id'] = $this->Session->read('CuentaUsuario.Cuenta.paramconfig_id');
                $this->request->data['Paramconfig']['mr'] = $this->request->data['User']['mr'];
//                $this->request->data['Paramconfig']['to_mr'] = $this->request->data['User']['to_mr'];
                $this->request->data['Paramconfig']['cc_mr'] = $this->request->data['User']['cc_mr'];
//                $this->request->data['Paramconfig']['cco_mr'] = $this->request->data['User']['cco_mr'];
                $this->request->data['Paramconfig']['mep'] = $this->request->data['User']['mep'];
                $this->request->data['Paramconfig']['cc_mep'] = $this->request->data['User']['cc_mep'];
                $this->request->data['Paramconfig']['cco_mep'] = $this->request->data['User']['cco_mep'];
                $this->request->data['Paramconfig']['ma'] = $this->request->data['User']['ma'];
//                $this->request->data['Paramconfig']['cc_ma'] = $this->request->data['User']['cc_ma'];
//                $this->request->data['Paramconfig']['cco_ma'] = $this->request->data['User']['cco_ma'];
//                $this->request->data['Paramconfig']['sla_atrasados'] = $this->request->data['User']['sla_atrasados'];
//                $this->request->data['Paramconfig']['sla_no_atendidos'] = $this->request->data['User']['sla_no_atendidos'];
//                $this->request->data['Paramconfig']['llamadas'] = $this->request->data['User']['llamadas'];
//                $this->request->data['Paramconfig']['emails'] = $this->request->data['User']['emails'];
//                $this->request->data['Paramconfig']['visitas'] = $this->request->data['User']['visitas'];
                $this->Paramconfig->create();
                $this->Paramconfig->save($this->request->data);
                
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                $this->User->query("UPDATE cuentas_users SET last_step = 3 WHERE id = $cuentas_user_id");
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                
                return $this->redirect(array('controller' => 'users','action'=>'diccionarios',$idParamConfig));
                //echo var_dump($this->request->data);
            }else{
                $this->set('parametros_mail',$this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id')));
                $this->set('parametros_generales',$this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')));
            }
        }
        

  // Funcion para los parametros de confiuración de la cuenta y para las notificaciones.
  public function parametros_mail_config(){
    $this->loadModel('Mailconfig');
    $this->loadModel('Paramconfig');
    if ($this->request->is('post')) {

    	// Paso 1.- Guardar la configuración de salidade correos.
    	$this->request->data['Mailconfig']['id'] = $this->request->data['Parametros']['mail_config_id'];

      // Paso2.- Completar Información de Usuario
      	// Cconfiguracion Gmail.
      // if ( strpos( $this->request->data['Parametros']['correo_contacto'],"@gmail.com" ) ) {
      //     $this->request->data['Mailconfig']['smtp']          = "ssl://smtp.gmail.com";
      //     $this->request->data['Mailconfig']['usuario']       = $this->request->data['Parametros']['correo_contacto'];
      //     $this->request->data['Mailconfig']['cuenta_correo'] = $this->request->data['Parametros']['correo_contacto'];
      //     $this->request->data['Mailconfig']['password']      = $this->request->data['Parametros']['password'];
      //     $this->request->data['Mailconfig']['puerto']        = "465";
      
      // } 
      // 	// Configuracion de Hotmail.
      // 	elseif( strpos( $this->request->data['Parametros']['correo_contacto'],"@hotmail.com" ) ) {
      //     $this->request->data['Mailconfig']['smtp']          = "ssl://mail.hotmail.com";
      //     $this->request->data['Mailconfig']['usuario']       = $this->request->data['Parametros']['correo_contacto'];
      //     $this->request->data['Mailconfig']['cuenta_correo'] = $this->request->data['Parametros']['correo_contacto'];
      //     $this->request->data['Mailconfig']['password']      = $this->request->data['Parametros']['password'];
      //     $this->request->data['Mailconfig']['puerto']        = "465";
      // } 
      // 	// Configuración Tadicional.
      // 	else {
      //     $this->request->data['Mailconfig']['cuenta_correo'] = $this->request->data['Parametros']['correo_contacto'];
      //     $this->request->data['Mailconfig']['smtp']          = $this->request->data['Parametros']['smtp'];
      //     // El usuario de la cuenta podria cambiar segun lainformación proporcionada - SAAK.
      //     $this->request->data['Mailconfig']['usuario']       = $this->request->data['Parametros']['correo_contacto'];
      //     $this->request->data['Mailconfig']['password']      = $this->request->data['Parametros']['password'];
      //     $this->request->data['Mailconfig']['puerto']        = $this->request->data['Parametros']['puerto'];
      // }
			
			// Salvar la información.      
      // $this->Mailconfig->save($this->request->data);
      

      // Paso 3.- Configuracion de las cuentas de notificaciones de nuevos usuarios.
      // 1.- Direcciones de correo para notificar un registro de nuevo cliente en sistema
      // 2.- Direcciones de correo para recibir copia de la asignación de un cliente a un asesor
      // 3.- Direcciones de correo para recibir copia de mails enviados por un asesor a un cliente

			$this->request->data['Paramconfig']['id']             = $this->Session->read('CuentaUsuario.Cuenta.paramconfig_id');
			$this->request->data['Paramconfig']['nuevo_cliente']  = $this->request->data['Parametros']['nClientes'];
			$this->request->data['Paramconfig']['asignacion_c_a'] = $this->request->data['Parametros']['ccAsignacion'];
			$this->request->data['Paramconfig']['cc_a_c']         = $this->request->data['Parametros']['ccAsesorAClientes'];
			$this->Paramconfig->save($this->request->data);

      
      $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
      $this->User->query("UPDATE cuentas_users SET last_step = 3 WHERE id = $cuentas_user_id");
      
      $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
      $this->Session->setFlash('La información se ha guardado exitosamente.', 'default', array(), 'm_success'); // Mensaje
      $this->redirect(array('controller' => 'cuentas','action'=>'view'));

	  }else{
      $this->set('parametros_mail',$this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id')));
      $this->set('parametros_generales',$this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')));
	  }
  }
              
        public function calificacion_clientes($idParamConfig = null){
            $this->loadModel('Mailconfig');
            $this->loadModel('Paramconfig');
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['Mailconfig']['smtp'] = $this->request->data['User']['smtp'];
                $this->request->data['Mailconfig']['usuario'] = $this->request->data['User']['usuario_mail'];
                $this->request->data['Mailconfig']['password'] = $this->request->data['User']['password_mail'];
                $this->request->data['Mailconfig']['puerto'] = $this->request->data['User']['puerto_mail'];
                $this->Mailconfig->create();
                $this->Mailconfig->save($this->request->data);
                debug($this->Mailconfig->validationErrors);
                $idMailconfig = $this->Mailconfig->getInsertID();
                
                $id = $this->Session->read('CuentaUsuario.Cuenta.id');
                $this->User->query("UPDATE cuentas SET mailconfig_id = $idMailconfig WHERE id = $id");
                
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                $this->User->query("UPDATE cuentas_users SET last_step = 5 WHERE id = $cuentas_user_id");
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                return $this->redirect(array('controller' => 'users','action'=>'parametros_mail'));
                //echo var_dump($this->request->data);
            }else{
                if (isset($idParamConfig)){
                    $this->set('param',$this->Paramconfig->read(null,$idParamConfig));
                }
            }
        }
        
        public function parametrizacion(){
            $this->loadModel('Mailconfig');
            $this->loadModel('Paramconfig');
            if ($this->request->is('post')) {
                //Completar Información de Usuario
                $this->request->data['Mailconfig']['smtp'] = $this->request->data['User']['smtp'];
                $this->request->data['Mailconfig']['usuario'] = $this->request->data['User']['usuario_mail'];
                $this->request->data['Mailconfig']['password'] = $this->request->data['User']['password_mail'];
                $this->request->data['Mailconfig']['puerto'] = $this->request->data['User']['puerto_mail'];
                $this->Mailconfig->create();
                $this->Mailconfig->save($this->request->data);
                debug($this->Mailconfig->validationErrors);
                $idMailconfig = $this->Mailconfig->getInsertID();
                
                $id = $this->Session->read('CuentaUsuario.Cuenta.id');
                $this->User->query("UPDATE cuentas SET mailconfig_id = $idMailconfig WHERE id = $id");
                
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                $this->User->query("UPDATE cuentas_users SET last_step = 5 WHERE id = $cuentas_user_id");
                
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');
                
                return $this->redirect(array('controller' => 'users','action'=>'parametrizacion'));
                //echo var_dump($this->request->data);
            }else{
                $this->set('param',$this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')));
            }
        }
        
        public function diccionarios($tab = null){
            
            if ($this->request->is('post')){
                $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
                $this->User->query("UPDATE cuentas_users SET last_step = 1 WHERE id = $cuentas_user_id");
                return $this->redirect(array('controller' => 'clientes','action'=>'index'));
            }
            $this->set('tipo_clientes',$this->DicTipoCliente->find('all',array(
                'conditions'=>array(
                    'DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                )
            )));
            $this->set('etapas',$this->DicEtapa->find('all',array(
                        'conditions'=>array(
                            'DicEtapa.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
            $this->set('linea_contactos',$this->DicLineaContacto->find('all',array(
                        'conditions'=>array(
                            'DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
            $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('all',array(
                        'conditions'=>array(
                            'DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
            $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('all',array(
                        'conditions'=>array(
                            'DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
            $this->set('tipo_propiedads',$this->DicTipoPropiedad->find('all',array(
                        'conditions'=>array(
                            'DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                        )
                    )));
            if (isset($tab)){
                $this->set('tab',$tab);
            }
            //return $this->redirect(array('controller' => 'users','action'=>'calificacion_clientes',$idParamConfig));
        }
        
        public function diccionarios_config($tab = null){
            
          if ($this->request->is('post')){
              $cuentas_user_id = $this->Session->read('CuentaUsuario.CuentasUser.id');
              $this->User->query("UPDATE cuentas_users SET last_step = 1 WHERE id = $cuentas_user_id");
              return $this->redirect(array('controller' => 'clientes','action'=>'index'));
          }

          $this->set('tipo_clientes',$this->DicTipoCliente->find('all',array(
              'conditions'=>array(
                  'DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              )
          )));

          $this->set('linea_contactos',$this->DicLineaContacto->find('all',array(
              'conditions'=>array(
                  'DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              )
          )));

          $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('all',array(
              'conditions'=>array(
                  'DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              )
          )));

          $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('all',array(
              'conditions'=>array(
                  'DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              )
          )));

          $this->set('tipo_propiedads',$this->DicTipoPropiedad->find('all',array(
              'conditions'=>array(
                  'DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              )
          )));  

          $this->set('tipo_proveedores',$this->DicProveedor->find('all',array(
              'conditions'=>array(
                  'DicProveedor.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              )
          )));

          $this->set('tipo_facturas',$this->DicFactura->find('all',array(
              'conditions'=>array(
                  'DicFactura.cuenta_id'=> $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              ),
              'contain' => false
          )));

          
          $this->set('razon_inactivacion_def_clientes',$this->DicRazonInactivacion->find('all',array(
            'conditions'=>array(
                'DicRazonInactivacion.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'DicRazonInactivacion.tabla'      => 'clientes',
                'DicRazonInactivacion.tipo_razon' => '1',
            ),
            'contain' => false
          )));

          $this->set('razon_inactivacion_temp_clientes',$this->DicRazonInactivacion->find('all',array(
            'conditions'=>array(
                'DicRazonInactivacion.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'DicRazonInactivacion.tabla'      => 'clientes',
                'DicRazonInactivacion.tipo_razon' => '2',
            ),
            'contain' => false
          )));



        }
        
          /**
         * Procesos Alex
         */
        
        public function inbox(){
        $data = array(
            'email' => array(
                'hostname' => '{'.$this->Session->Read('Auth.User.email_hostname').':'.$this->Session->Read('Auth.User.email_port').'/imap/ssl/novalidate-cert}INBOX',
                'username' => $this->Session->Read('Auth.User.email_username'),
                'password' => $this->Session->Read('Auth.User.email_password')
                )
            );
        $mbox = imap_open($data['email']['hostname'], $data['email']['username'], $data['email']['password']) or die ('No se pudo establecer conexión al servidor: ' . imap_last_error());
        $MC = imap_check($mbox);
        $result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
        $array_result = json_decode(json_encode($result), True);
        $overview = array_reverse($array_result);
        imap_close($mbox);

        $this->set('overview', $overview);
    }

    public function view_message($id = null){
        $data = array(
            'email' => array(
                'hostname' => '{'.$this->Session->Read('Auth.User.email_hostname').':'.$this->Session->Read('Auth.User.email_port').'/imap/ssl/novalidate-cert}INBOX',
                'username' => $this->Session->Read('Auth.User.email_username'),
                'password' => $this->Session->Read('Auth.User.email_password')    
                
                )
            );
        $mbox = imap_open($data['email']['hostname'], $data['email']['username'], $data['email']['password']) or die ('No se pudo establecer conexión al servidor: ' . imap_last_error());
        $MC = imap_check($mbox);
        $header_info = imap_headerinfo($mbox, $id, 0);
        $header_array = json_decode(json_encode($header_info), True);

        // Body
        $structure = imap_fetchstructure($mbox, $id, 0);

        if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
            $part = $structure->parts[1];
            $message = imap_fetchbody($mbox,$id,2);

            if($part->encoding == 3) {
                $message = imap_base64($message);
            } else if($part->encoding == 1) {
                $message = imap_8bit($message);
            } else {
                $message = imap_qprint($message);
            }
        }


        $data = array(
                    'header'=>array(
                        'date'=> date('d-M-Y H:m:s',strtotime($header_array['date'])),
                        'subject'=>$header_array['subject'],
                        'fromAddress' => $header_array['fromaddress'],
                        'fromMail' => $header_array['from'][0]['mailbox'].'@'.$header_array['from'][0]['host']
                    ),
                    'body'=>$message,
                );



        // Json decode
        // echo "<pre style='background-color: #fff !important;'>";
        //     print_r($body_info);
        // echo "</pre>";

        // echo "<pre style='background-color: #fff !important;'>";
        //     print_r($data);
        // echo "</pre>";
        $this->set('inbox', $data);
        $this->set('id', $id);

    }


    public function enviar_email(){
        if ($this->request->is('post')) {

            // Estructura del correo para enviar, respetando los estilos del email reenviado
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>
            <body>
                '.$this->request->data['User']['mensaje'].'
            </body>
            </html>';



            $this->Email = new CakeEmail();
            $this->Email->config(array(
                'host' => $this->Session->Read('Auth.User.smtp_host'),
                'port' => $this->Session->Read('Auth.User.smtp_port'),
                'username' => $this->Session->Read('Auth.User.email_username'),
                'password' => $this->Session->Read('Auth.User.email_password'),
                'transport' => 'Smtp'
                )
            );
            $this->Email->emailFormat('html');
            $this->Email->from(array('alejandro@saak-technology.com.mx'=>'Alejandro Hernandez'));
            $this->Email->to($this->request->data['User']['para']);
            $this->Email->subject($this->request->data['User']['subject']);
            $this->Email->send($html);


            // Validar si el email se encuentra dentro del listado de clientes
            $cliente = $this->Cliente->find('first',array('conditions'=>array('Cliente.correo_electronico'=>$this->request->data['User']['para'])));
            
            if (!empty($cliente)) {
                /*echo "<pre>";
                    print_r($cliente);
                echo "</pre>";*/
                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']            = uniqid();
                $this->request->data['LogCliente']['cliente_id']    = $cliente['Cliente']['id'];
                $this->request->data['LogCliente']['user_id']       = $this->Session->read('Auth.User.id');
                $this->request->data['LogCliente']['mensaje']       = "Email enviado";
                $this->request->data['LogCliente']['accion']        = 3;
                $this->request->data['LogCliente']['datetime']      = date('Y-m-d h:i:s');
                $this->LogCliente->save($this->request->data);
            }

            $this->Session->setFlash(__('Se ha enviado el email, correctamente'),'default',array('class'=>'success'));
            $this->redirect(array('action' => 'inbox'));

        }
    }
    
    public function solicitar_prueba(){
        if ($this->request->is('post')) {
            
            $html = "<p>Nombre Empresa: ".$this->request->data['User']['nombre_empresa']."</p>".
                    "<p>Nombre: ".$this->request->data['User']['nombre']."</p>".
                    "<p>Email: ".$this->request->data['User']['email']."</p>".
                    "<p>Teléfono: ".$this->request->data['User']['telefono']."</p>".
                    "<p>Horario de Contacto: ".$this->request->data['User']['horario_contacto']."</p>".
                    "<p>Número de empleados: ".$this->request->data['User']['empleados']."</p>".
                    "<p>Giro: ".$this->request->data['User']['giro']."</p>".
            
            $this->Email = new CakeEmail();
            $this->Email->config(array(
                'host' => 'mail.bosinmobiliaria.com',
                'port' => 587,
                'username' => 'sistemabos@bosinmobiliaria.com',
                'password' => 'Sistema.2018',
                'transport' => 'Smtp'
                )
            );
            $this->Email->emailFormat('html');
            $this->Email->from(array('contacto@inmosystem.com.mx'=>'Formulario prueba Inmo System'));
            $this->Email->to('cesar@aigel.com.mx');
            $this->Email->subject('Solicitud de prueba Inmo System');
            $this->Email->send($html);
            $this->Session->setFlash(__('Gracias por solicitar una prueba. Un ejecutivo se pondrá en contacto lo más pronto posible'),'default',array('class'=>'success'));
            $this->redirect(array('action' => 'solicita_prueba','controller'=>'pages'));
        }
        
    }


    /***************************************************************
    *
    *   Funcion que desabilita al usuario, No lo elimina.
    *   AKA "SaaK" al 21-05-2019
    *
    ***************************************************************/
    public function disabled($user_id){
      if (!$this->User->exists($user_id)) {
        throw new NotFoundException(__('Invalid user'));
      }
      $this->request->onlyAllow('post', 'delete');
      
      $this->request->data['User']['id']     = $user_id;
      $this->request->data['User']['status'] = 0;
      $this->User->save($this->request->data);
      $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
      $this->Session->setFlash('El usuario se a deshabilitado exitosamente.', 'default', array(), 'm_success'); // Mensaje
      return $this->redirect(array('action'=>'asesores'));

    }

    public function test009(){
      $this->User->Behaviors->load('Containable');
      $var_test = $this->User->find('all', array('conditions'=>array('id'=>110), 'fields'=>array('User.nombre_completo'), 'contain' => array('VentaSum', 'Cliente'=>array('fields'=>array('nombre','correo_electronico')))));
      $this->set(compact('var_test'));
    }
    
    public function reportes_gerenciales(){
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
    
    public function reporte_a1(){
      date_default_timezone_set('America/Mexico_City');

      $desarrollos_asignados  = [];
      $interesados            = 0;
      $citas                  = 0;
      $visitas                = 0;
      $mails                  = 0;
      $interesados_acumulados = 0;
      $citas_acumuladas       = 0;
      $visitas_acumuladas     = 0;
      $mails_acumuladas       = 0;
      $clientes_asignados     = 0;
      $cuenta_id              = $this->Session->read('CuentaUsuario.Cuenta.id');
      $date_current           = date('Y-m-d');
      $lista_ventas           = [];
      $asesor                 = 0;
      $fecha_inicio           = date('Y-01-01');
      $fecha_final            = date('Y-m-d');
      $periodo_reporte        = utf8_encode(strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_inicio)))).' al '.strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_final)))));
      $periodo_reporte        = ucwords(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_inicio)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_final)))));
      $periodo_tiempo         = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
      $fecha_ini              = $fecha_inicio;
      $fecha_fin              = $fecha_final;
      $user_id                = $this->Session->read('Auth.User.id');

      $this->set('users', $this->User->find('list',
        array('order' => 'nombre_completo ASC',
              'conditions' => 
                array(
                  "User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = $cuenta_id)"
                )
        )
      ));
      
      if ( $this->request->is(array('post', 'put')) ) {
        $rango     = $this->request->data['User']['rango_fechas'];
        $user_id   = $this->request->data['User']['user_id'];
        $fecha_ini = substr($rango, 0,10).' 00:00:00';
        $fecha_fin = substr($rango, -10).' 23:59:59';
        $fi        = date('Y-m-d',  strtotime($fecha_ini));
        $ff        = date('Y-m-d',  strtotime($fecha_fin));
        $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fi)).' AL '.date('d-m-Y', strtotime($ff));
        $periodo_reporte     = utf8_encode(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fi)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($ff)))));
        $fecha_final = $ff;

        $asesor = $this->User->read(null,$user_id);

        // Total de clientes
        $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE user_id = $user_id AND cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff'");
        // Clientes separados por estatus
        $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE user_id = $user_id AND cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' GROUP BY status");

        //Contador de número de desarrollos
        $this->set('desarrollos_asignados',$this->User->query("SELECT COUNT(DISTINCT(desarrollo_id)) AS asignados FROM clientes WHERE user_id = $user_id"));

        // Indicadores de emails, citas y visitas, llamadas.
        $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Cliente.user_id'=>$user_id,'Cliente.created >='=>$fi,'Cliente.created <='=>$ff))));
        $this->set('mails',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id)",'LogCliente.accion'=>3, 'LogCliente.datetime <='=>$ff, 'LogCliente.datetime >='=> $fi))));
        $this->set('citas',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id)",'LogCliente.accion'=> 5, 'LogCliente.datetime <='=>$ff, 'LogCliente.datetime >='=> $fi ))));
        $this->set('visitas',$this->Event->find('count',array('conditions'=>array("Event.user_id" =>$user_id,'Event.tipo_tarea'=> 1, 'Event.fecha_inicio <=' => $ff))));
        
        $this->set('interesados_acumulados',$this->Lead->find('count',array('conditions'=>array('Cliente.user_id'=>$user_id))));
        $this->set('mails_acumuladas',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id)",'LogCliente.accion'=>3))));
        $this->set('citas_acumuladas',$this->LogCliente->find('count',array('conditions'=>array("LogCliente.cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id)",'LogCliente.accion'=> 5))));
        $this->set('visitas_acumuladas',$this->Event->find('count',array('conditions'=>array("Event.user_id" =>$user_id,'Event.tipo_tarea'=> 1))));
        
        /************************************************* Grafica de temperatura de clientes ********************************************************************/
        $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' GROUP BY etapa;");

        /************************************************* Grafica de Relación de Inactivación de Clientes ********************************************************************/
        //$temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' AND clientes.desarrollo_id = $desarrollo_id GROUP BY etapa;");

        $op_uno = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No le interesa ninguna de las propiedades%'");
        $op_dos = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No responde correo ni tel%'");
        $op_tres = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: Compr%'");
        $op_cuatro = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: Declin%'");
        $op_cinco = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: Cliente Molesto por falta de seguimiento%'");
        $op_seis = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No tiene presupuesto%'");
        $op_siete = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No solicit%'");
        
        $inactivos_distribucion = array();
            $inactivos_distribucion[0] = array(
                'label' => 'No le interesa ninguna propiedad',
                'cantidad'=> $op_uno[0][0]['COUNT(*)']
            );
            $inactivos_distribucion[1] = array(
                'label' => 'No responde teléfono ni correo',
                'cantidad'=> $op_dos[0][0]['COUNT(*)']
            );
            $inactivos_distribucion[2] = array(
                'label' => 'Compró / Rentó en otro lugar',
                'cantidad'=> $op_tres[0][0]['COUNT(*)']
            );
            $inactivos_distribucion[3] = array(
                'label' => 'Declinó su interés de compra',
                'cantidad'=> $op_cuatro[0][0]['COUNT(*)']
            );
            $inactivos_distribucion[4] = array(
                'label' => 'Cliente molesto por falta de seguimiento',
                'cantidad'=> $op_cinco[0][0]['COUNT(*)']
            );
            $inactivos_distribucion[5] = array(
                'label' => 'No tiene presupuesto',
                'cantidad'=> $op_seis[0][0]['COUNT(*)']
            );
            $inactivos_distribucion[6] = array(
                'label' => 'No solicitó información',
                'cantidad'=> $op_siete[0][0]['COUNT(*)']
            );
        $this->set(compact('inactivos_distribucion'));

        $op_uno = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal') AND mensaje LIKE '%pasa a estatus baja temporal por motivo: Solicit%'");
        $op_dos = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal') AND mensaje LIKE '%pasa a estatus baja temporal por motivo: Le interesa comprar /rentar%'");
        $op_tres = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal') AND mensaje LIKE '%pasa a estatus baja temporal por motivo: Debe consultar con sus familiares%'");
        $op_cuatro = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE user_id = $user_id AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal') AND mensaje LIKE '%pasa a estatus baja temporal por motivo: Sale de viaje, a su regreso%'");
        
        $inactivos_temporal_distribucion = array();
        $inactivos_temporal_distribucion[0] = array(
            'label' => 'Solicitó contactarlo tiempo después',
            'cantidad'=> $op_uno[0][0]['COUNT(*)']
        );
        $inactivos_temporal_distribucion[1] = array(
            'label' => 'Le interesa comprar /rentar pero va a postergar la decisión.',
            'cantidad'=> $op_dos[0][0]['COUNT(*)']
        );
        $inactivos_temporal_distribucion[2] = array(
            'label' => 'Debe consultar con sus familiares, define después.',
            'cantidad'=> $op_tres[0][0]['COUNT(*)']
        );
        $inactivos_temporal_distribucion[3] = array(
            'label' => 'Sale de viaje, a su regreso pidió contactarlo.',
            'cantidad'=> $op_cuatro[0][0]['COUNT(*)']
        );

        $this->set(compact('inactivos_temporal_distribucion'));

        /************************************************* Grafica de atencion de clientes ********************************************************************/

        //Indicador de clientes con estatus Oportunos
        $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
            
        //Indicador de clientes con estatus Oportunos tardíos
        $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
        
        //Indicador de clientes con estatus Seguimiento Atrasado
        $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No Atendidos (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
        
        //Indicador de clientes con estatus Por Reasignar
        $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
        
        //Indicador de clientes con estatus Sin Seguimiento
        $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin Asginar' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fi' AND created <= '$ff'");

        // Suma de los clientes de atencion
        $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];


        /************************************************* Grafica de asignaciones por mes ********************************************************************/

        $clientes_asignados = $this->Cliente->query("SELECT COUNT(*) AS asignados, CONCAT(YEAR(created),'-',LPAD(MONTH(created),2,'0')) AS periodo FROM clientes WHERE user_id = $user_id AND created >= '$fi' AND created <= '$ff' GROUP BY periodo;");
        $this->set('clientes_asignados',$clientes_asignados);

        /************************************************* Grafica de DISTRIBUCION DE CLIENTES POR DESARROLLOS POR ASESOR ********************************************************************/

        $clientes_asignados_desarrollos = $this->Cliente->query("SELECT COUNT(*) AS clientes, desarrollos.nombre FROM clientes,desarrollos WHERE desarrollos.id = clientes.desarrollo_id AND clientes.user_id = $user_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' GROUP BY clientes.desarrollo_id ORDER BY clientes DESC;");
        $this->set('clientes_asignados_desarrollos',$clientes_asignados_desarrollos);

        /************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
        $query = "SELECT 
        COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo
            FROM 
                ventas
            WHERE 
                ventas.user_id = $user_id AND
                ventas.fecha <= '$ff' AND
                ventas.fecha >= '$fi'
            GROUP BY periodo
            ORDER BY periodo";
    
        $ventas_vs_metas = $this->User->query($query);
        //Armar el arreglo para poder consultarlo con únicamente las ventas
        $arreglo_ventas = array();
        foreach($ventas_vs_metas as $venta):
            $arreglo_ventas[$venta[0]['periodo']]['objetivo_ventas']=$asesor['Rol'][0]['cuentas_users']['unidad_venta'];
            $arreglo_ventas[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
        endforeach;
        $kpi_inicial = $asesor['Rol'][0]['cuentas_users']['unidad_venta'];
        // Variables de ventas vs metas por mes.
        //$this->set(compact('arreglo_ventas'));
        //$this->set(compact('ventas_vs_metas'));

        $intervalo_meses = abs(strtotime($fi)-strtotime($ff));
        $meses = floor($intervalo_meses/60/60/24/30);
        $this->set('meses',$meses);
        $meses_array = array();
        $primer_mes = date('m',strtotime($fi));
        $primer_anio = date('Y',strtotime($fi));
        for($i=0;$i<$meses; $i++){
            $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
            $meses_array[$i][0]['objetivo_ventas'] = isset($arreglo_ventas[$periodo]['objetivo_ventas'])?$arreglo_ventas[$periodo]['objetivo_ventas']:$kpi_inicial;
            if(isset($arreglo_ventas[$periodo]['objetivo_ventas'])){
                $kpi_inicial = $arreglo_ventas[$periodo]['objetivo_ventas'];
            }
            $meses_array[$i][0]['periodo'] = $periodo;
            $meses_array[$i][0]['venta_mes'] = isset($arreglo_ventas[$periodo]['venta_mes'])?$arreglo_ventas[$periodo]['venta_mes']:0;
            $primer_mes++;
            if ($primer_mes == 13){
                $primer_mes = 1;
                $primer_anio ++;
            }
        }
        $this->set('ventas_vs_metas',$meses_array);

        //SACAR EL OBJETIVO DE VENTAS EN MONTO

        $query2 = "SELECT 
        SUM(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo        
            FROM 
                ventas
            WHERE 
                ventas.user_id = $user_id AND
                ventas.fecha <= '$ff' AND
                ventas.fecha >= '$fi'
            GROUP BY periodo
            ORDER BY periodo";
    
        $ventas_vs_metas_2 = $this->Desarrollo->query($query2);
        //Armar el arreglo para poder consultarlo con únicamente las ventas
        $arreglo_ventas_2 = array();
        foreach($ventas_vs_metas_2 as $venta):
            $arreglo_ventas_2[$venta[0]['periodo']]['objetivo_ventas']=$asesor['Rol'][0]['cuentas_users']['ventas_mensuales'];
            $arreglo_ventas_2[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
        endforeach;
        $kpi_inicial_2 = $asesor['Rol'][0]['cuentas_users']['ventas_mensuales'];
        // Variables de ventas vs metas por mes.
        //$this->set(compact('arreglo_ventas_2'));
        //$this->set(compact('ventas_vs_metas'));

        
        $meses_array_2 = array();
        $primer_mes = date('m',strtotime($fi));
        $primer_anio = date('Y',strtotime($fi));
        for($i=0;$i<$meses; $i++){
            $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
            $meses_array_2[$i][0]['objetivo_ventas'] = isset($arreglo_ventas_2[$periodo]['objetivo_ventas'])?$arreglo_ventas_2[$periodo]['objetivo_ventas']:$kpi_inicial_2;
            if(isset($arreglo_ventas_2[$periodo]['objetivo_ventas'])){
                $kpi_inicial_2 = $arreglo_ventas_2[$periodo]['objetivo_ventas'];
            }
            $meses_array_2[$i][0]['periodo'] = $periodo;
            $meses_array_2[$i][0]['venta_mes'] = isset($arreglo_ventas_2[$periodo]['venta_mes'])?$arreglo_ventas_2[$periodo]['venta_mes']:0;
            $primer_mes++;
            if ($primer_mes == 13){
                $primer_mes = 1;
                $primer_anio ++;
            }
        }
        $this->set('ventas_vs_metas_2',$meses_array_2);
        
        $intervalo_meses = abs(strtotime($fi)-strtotime($ff));
        $meses = floor($intervalo_meses/60/60/24/30);
        $this->set('meses',$meses);
        $meses_array = array();
        $primer_mes = date('m',strtotime($fi));
        $primer_anio = date('Y',strtotime($fi));
        for($i=0;$i<$meses; $i++){
            $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
            $meses_array[$i][0]['periodo'] = $periodo;
            $meses_array[$i][0]['venta_mes_q'] = isset($arreglo_ventas[$periodo]['venta_mes'])?$arreglo_ventas[$periodo]['venta_mes']:0;
            $meses_array[$i][0]['venta_mes_dinero'] = isset($arreglo_ventas_2[$periodo]['venta_mes'])?$arreglo_ventas_2[$periodo]['venta_mes']:0;
            $primer_mes++;
            if ($primer_mes == 13){
                $primer_mes = 1;
                $primer_anio ++;
            }
        }
        $this->set('ventas_vs_ventas',$meses_array);

        /************************************************* Grafica de ventas vs visitas *****************************************************************/

        $visitas_por_periodo = $this->User->query("SELECT	COUNT(*) AS visitas, CONCAT(YEAR(events.fecha_inicio),'-',LPAD(MONTH(events.fecha_inicio),2,'0')) AS periodo FROM events WHERE  tipo_tarea = 1 AND events.user_id = $user_id AND events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY periodo;");
        $visitas_periodo = array();
        foreach($visitas_por_periodo as $periodo):
            $visitas_periodo[$periodo[0]['periodo']] = $periodo[0]['visitas'];
        endforeach;
        $intervalo_meses = abs(strtotime($fi)-strtotime($ff));
        $meses = floor($intervalo_meses/60/60/24/30);
        $this->set('meses',$meses);
        $meses_array = array();
        $cv_array = array();//Usar solo si se va a agregar la gráfica de Contactos VS Visitas
        $primer_mes = date('m',strtotime($fi));
        $primer_anio = date('Y',strtotime($fi));
        for($i=0;$i<$meses; $i++){
            $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
            $meses_array[$i][0]['periodo'] = $periodo;
            $meses_array[$i][0]['venta_mes_q'] = isset($arreglo_ventas[$periodo]['venta_mes'])?$arreglo_ventas[$periodo]['venta_mes']:0;
            $meses_array[$i][0]['visitas'] = isset($visitas_periodo[$periodo])?$visitas_periodo[$periodo]:0;

            //Esta sección es solo para grafica de contactos VS Visitas
              $cv_array[$i]['periodo'] = $periodo;
              $cv_array[$i]['visitas'] = isset($visitas_periodo[$periodo])?$visitas_periodo[$periodo]:0;
              foreach($clientes_asignados as $c1):
                if ($c1[0]['periodo']==$periodo){
                  $cv_array[$i]['contactos'] = isset($c1[0]['asignados'])?$c1[0]['asignados']:0;
                }
              endforeach;              
            //FIN DE sección es solo para grafica de contactos VS Visitas

            $primer_mes++;
            if ($primer_mes == 13){
                $primer_mes = 1;
                $primer_anio ++;
            }
        }
        $this->set('ventas_vs_visitas',$meses_array);
        //Solo aplica para grafica de visitas vs contactos
        $this->set('contactos_vs_visitas',$cv_array);

        /************************************************* Grafica de clientes asignados y reasignados *****************************************************************/

        $asignados = $this->User->query("SELECT COUNT(*) AS asignados, CONCAT(YEAR(fecha),'-',LPAD(MONTH(fecha),2,'0')) AS periodo FROM reasignacions WHERE asesor_nuevo = $user_id AND fecha BETWEEN '$fi' AND '$ff' GROUP BY periodo");
        $reasignados = $this->User->query("SELECT COUNT(*) AS reasignados, CONCAT(YEAR(fecha),'-',LPAD(MONTH(fecha),2,'0')) AS periodo FROM reasignacions WHERE asesor_original = $user_id AND fecha BETWEEN '$fi' AND '$ff' GROUP BY periodo");

        $arreglo_asignados_reasignados = array();
        foreach($asignados as $asignado):
            $arreglo_asignados_reasignados[$asignado[0]['periodo']]['asignado'] = $asignado[0]['asignados'];
        endforeach;

        foreach($reasignados as $reasignado):
          $arreglo_asignados_reasignados[$reasignado[0]['periodo']]['reasignado'] = $reasignado[0]['reasignados'];
        endforeach;

        $intervalo_meses = abs(strtotime($fi)-strtotime($ff));
        $meses = floor($intervalo_meses/60/60/24/30);
        
        $meses_asignados_array = array();
        $primer_mes = date('m',strtotime($fi));
        $primer_anio = date('Y',strtotime($fi));
        for($i=0;$i<$meses; $i++){
            $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
            $meses_asignados_array[$i]['periodo'] = $periodo;
            $meses_asignados_array[$i]['asignados'] = isset($arreglo_asignados_reasignados[$periodo]['asignado'])?$arreglo_asignados_reasignados[$periodo]['asignado']:0;
            $meses_asignados_array[$i]['reasignados'] = isset($arreglo_asignados_reasignados[$periodo]['reasignado'])?$arreglo_asignados_reasignados[$periodo]['reasignado']:0;
            $meses_asignados_array[$i]['asignados_actuales'] = isset($clientes_asignados[$i][0]['asignados'])?$clientes_asignados[$i][0]['asignados']:0;

            $primer_mes++;
            if ($primer_mes == 13){
                $primer_mes = 1;
                $primer_anio ++;
            }
        }
        $this->set('asingados_reasignados',$meses_asignados_array);

        /************************************************* Grafica de motivos de reasignaciones *****************************************************************/
        
        $motivos_reasignaciones = $this->User->query("SELECT COUNT(*) AS reasignaciones, motivo_cambio FROM reasignacions WHERE asesor_original = $user_id OR asesor_nuevo = $user_id AND motivo_cambio IS NOT NULL AND fecha BETWEEN '$fi' AND '$ff' GROUP BY motivo_cambio;");
        $this->set(compact('motivos_reasignaciones'));

        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE user_id = $user_id AND clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE user_id = $user_id AND clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

        $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.user_id = $user_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
        $ventas_linea_contacto_arreglo = array();
        $i=0;
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                  $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];    
              }
            endforeach;
            $i++;
        endforeach;


        /************************************************* Listado de ventas ********************************************************************/
        $lista_ventas = $this->Venta->find('all',array('conditions'=>array('Venta.fecha >=' => $fi, 'Venta.fecha <='=> $ff, 'Venta.user_id' => $user_id)));
        
        /************************************************* Objetivos de ventas del periodo ********************************************************************/
        $ventas_vs_metas = $this->User->query("
            SELECT 
                SUM(precio_cerrado) AS ventas_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo, ventas_mensuales AS monto 
            FROM 
                ventas, cuentas_users
            WHERE 
                ventas.user_id = $user_id AND
                cuentas_users.user_id = $user_id AND
                ventas.fecha >= '".$fi."' AND
                ventas.fecha <= '".$ff."'
            GROUP BY periodo;"
        );
        
        
      }else{

        $asesor = $this->User->find('first', array('order' => 'nombre_completo ASC',
          'conditions' => 
            array(
              "User.status" => 1,
              "User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = $cuenta_id)"
            )
          )
        );
        $user_id = $asesor['User']['id'];
        
        // Total de clientes
        $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id");
        // Clientes separados por estatus
        $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id GROUP BY status");

        /************************************************* Grafica de temperatura de clientes ********************************************************************/
        $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fecha_inicio."' AND created <= '".$fecha_final."' AND status = 'Activo' AND user_id = $user_id GROUP BY etapa;");

        /************************************************* Grafica de atencion de clientes ********************************************************************/

        //Indicador de clientes con estatus Oportunos
        $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id ");
            
        //Indicador de clientes con estatus Oportunos tardíos
        $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id ");
        
        //Indicador de clientes con estatus Seguimiento Atrasado
        $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'Atrasados (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id ");
        
        //Indicador de clientes con estatus Por Reasignar
        $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id ");
        
        //Indicador de clientes con estatus Sin Seguimiento
        $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin seguimiento' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND user_id = $user_id ");

        // Suma de los clientes de atencion
        $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.status = 'Activo' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id AND user_id = $user_id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.status = 'Activo' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id AND user_id = $user_id; ");

        $venta_linea_contacto = $this->User->query("SELECT SUM(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND 'Venta.user_id' = $user_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fecha_inicio' AND  ventas.fecha <= '$fecha_final' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
        $ventas_linea_contacto_arreglo = array();
        $i=0;

        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                  $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];    
              }
          endforeach;
            $i++;
        endforeach;


        /************************************************* Listado de ventas ********************************************************************/
        $lista_ventas = $this->Venta->find('all',array('conditions'=>array('Venta.fecha >=' => $fecha_inicio, 'Venta.fecha <='=> $fecha_final, 'Venta.user_id' => $user_id)));

        
        
      }


      // Variables globales
      $this->set(compact('cuenta_id'));
      $this->set(compact('date_current'));
      $this->set(compact('lista_ventas'));
      $this->set(compact('asesor'));
      $this->set(compact('fecha_inicio'));
      $this->set(compact('fecha_final'));
      $this->set(compact('periodo_tiempo'));
      $this->set(compact('periodo_reporte'));

      // Variables de grafica de estatus de clientes.
      $this->set(compact('total_clientes_anuales'));
      $this->set(compact('clientes_anuales'));

      // Variable de grafica de temperatura de clientes.
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
      

      // Variable de listado de ventas.
      $this->set(compact('lista_ventas'));
      
      $this->set(compact('desarrollos_asignados'));
      
      // Variables de tarjetas de indicadores de desempeño
      // $this->set(compact('interesados'));
      // $this->set(compact('citas'));
      // $this->set(compact('visitas'));
      // $this->set(compact('mails'));
      
      // $this->set(compact('interesados_acumulados'));
      // $this->set(compact('citas_acumuladas'));
      // $this->set(compact('visitas_acumuladas'));
      // $this->set(compact('mails_acumuladas'));
      // $this->set(compact('clientes_asignados'));
            
    }


          public function login_app(){
             $this->layout = null;
            
            // $usuario = $this->User->find('first', array('conditions'=>array('User.correo_electronico'=>$this->request->data['email'], 'User.password'=>$this->Auth->password($this->request->data['password']))));
            $usuario = $this->CuentasUser->find('first', array('conditions'=>array('User.correo_electronico'=>$this->request->data['email'], 'User.password'=>$this->Auth->password($this->request->data['password']))));
      
            if(!empty($usuario)){
      
              $resp = array(
                'Ok' => true,
                'user_id' => $usuario['User']['id'],
                'cuenta_id' => $usuario['Cuenta']['id'],
                'cuenta_logo' => $usuario['Cuenta']['logo']
              );
            }else{
              $resp = array(
                'Ok' => false,
                'mensaje' => 'El usuario o la contraseña no son correctos'
              );
            }
            echo json_encode($resp, true);
            $this->autoRender = false;
          }
      
      
          public function get_all_users( $cuenta_id = null, $user_id = null ){
            $this->layout = null;

            // Condiciones para los super admin y asesores.
            $user = $this->User->find('first', array(
                'conditions' => array(
                  'id'     => $user_id,
                  'status' => 1
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
                $condiciones = array(
                  'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$cuenta_id.")",
                  'status' => 1
                );

            }else{
                $condiciones = array(
                  'User.id' => $user_id
                );
            }

      
            $users = $this->Cliente->User->find('all',
              array(
                'recursive' => -1,
                'fields' => array(
                  'User.id',
                  'User.nombre_completo'
                ),
                'order'=>
                'User.nombre_completo ASC',
                'conditions' => $condiciones
              )
            );
      
            for($s = 0; $s < count($users); $s++ ){
              $new_array_users[$s] = array(
                "id"              => $users[$s]['User']['id'],
                "nombre_completo" => $users[$s]['User']['nombre_completo'],
              );
            }
            echo(json_encode($new_array_users));
            $this->autoRender = false;
      
          }



          // Prueba para mandar a llamar a una vista externa a la carpeta.
          public function eventos() {
            

            $this->set('eventos', array());

          }


          public function token() {

            $app_id              = '10660157517216';
            $secret_key          = '60tk7ACHk3IKYYqdcwJDQNiCjcq4IsfD';
            $categoria_inmuebles = 'MLA1459';
            $redirect_url        = 'http://localhost/_adryo/users/required_token';

            $respuesta = [];
            $this->redirect('http://auth.mercadolibre.com/authorization?response_type=code&client_id='.$app_id.'&redirect_uri='.$redirect_url.'');
          
          }

          public function required_token() {
            
            if( $this->params['url']['code'] ) {
              $respuesta = array(
                'flag'  => true,
                'token' => $this->params['url']['code']
              );
            }else {
              $respuesta = array(
                'flag'  => false,
                'token' => ''
              );
            }

            print_r ($respuesta);
            $this->autoRender = false;

          }



          public function test_query () {
            $this->Precio->Behaviors->load('Containable');

            $propiedades = $this->Inmueble->find('all',array('limit'=>5,'conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),'Inmueble.id IN (SELECT inmueble_id FROM precios GROUP BY inmueble_id HAVING count(id) > 1 ORDER BY precios.id DESC)')));

            $s = $this->Precio->find('all', array(
              'contain' => false,
              'fields' => array(
                'fecha',
                'precio',
                'inmueble_id'
              ),
              'conditions' => array(
                'inmueble_id IN (SELECT id FROM inmuebles WHERE inmuebles.cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Precio.fecha >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)'
              )
            ));
            
            print_r( $s );
            $this->autoRender = false;
          }


          public function test_mail() {
            $usuario    = $this->User->read(null,$this->Session->read('Auth.User.id'));
            $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));

            $this->Email = new CakeEmail();
            $this->Email->config(array(
                'host'      => $mailconfig['Mailconfig']['smtp'],
                'port'      => $mailconfig['Mailconfig']['puerto'],
                'username'  => $mailconfig['Mailconfig']['usuario'],
                'password'  => $mailconfig['Mailconfig']['password'],
                'transport' => 'Smtp',
                'tls'       => true
                )
            );

            $this->Email->emailFormat('html');
            $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
            $this->Email->to(array('alejandro@aigel.com.mx', 'cesar@aigel.com.mx', 'saak.hg.pv@gmail.com'));
            $this->Email->subject('Prueba de correo');
            $this->Email->send("Prueba de correo");

            $this->autoRender = false;

          }

          public function estatus_atencion_clientes($cuenta_id = null, $user_id = null, $fecha_inicial = null, $fecha_final = null ){

            $periodo_inicial = '';
            $periodo_final   = '';
        
            if( $fecha_inicial != null ){
              $periodo_inicial = " AND created >= '$fecha_inicial' ";
            }
            if( $fecha_final != null ){
              $periodo_final = " AND created <= '$fecha_final'";
            }
        
            $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' ".$periodo_inicial.$periodo_final."");
                    
            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' ".$periodo_inicial.$periodo_final."");
            
            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No Atendidos (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' ".$periodo_inicial.$periodo_final."");
            
            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' ".$periodo_inicial.$periodo_final."");
            
            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin Asginar' as status FROM clientes WHERE user_id = $user_id AND cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL ".$periodo_inicial.$periodo_final."");
        
            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];
        
            $datos = array(
              'clientes_oportunos'       => $clientes_oportunos,
              'clientes_tardia'          => $clientes_tardia,
              'clientes_atrasados'       => $clientes_atrasados,
              'clientes_reasignar'       => $clientes_reasignar,
              'clientes_sin_seguimiento' => $clientes_sin_seguimiento,
              'sum_clientes_atencion'    => $sum_clientes_atencion,
            );
        
            return $datos;
        
          }
        
          /* ------ Funsión para la gráfica de por medio de promoción vs ventas. ------ */
          function contactos_medio_promosion_vs_ventas( $cuenta_id = null, $user_id = null, $fecha_inicial = null, $fecha_final = null ) {
            $resultado                  = [];
            $periodo_inicial            = '';
            $periodo_final              = '';
            $periodo_inicial_ventas     = '';
            $periodo_inicial_publicidad = '';
            $periodo_final_ventas       = '';
            $periodo_final_publicidad   = '';
            $i                          = 0;
        
            if( $fecha_inicial != null ){
              $periodo_inicial = "AND clientes.created >= '$fecha_inicial'";
              $periodo_inicial_ventas = " AND  ventas.fecha >= '$fecha_inicial' ";
              $periodo_inicial_publicidad = " publicidads.fecha_inicio >= '$fecha_inicial' ";
            }
            if( $fecha_final != null ){
              $periodo_final = " AND clientes.created <= '$fecha_final'";
              $periodo_final_ventas = " AND  ventas.fecha <= '$fecha_final' ";
              $periodo_final_publicidad = " AND  publicidads.fecha_inicio <= '$fecha_final' AND ";
            }
        
        
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE user_id = $user_id AND clientes.cuenta_id = $cuenta_id ".$periodo_inicial." ".$periodo_final."  AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
        
            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE user_id = $user_id AND clientes.cuenta_id = $cuenta_id ".$periodo_inicial." ".$periodo_final." AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
        
            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.user_id = $user_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id ".$periodo_inicial_ventas." ".$periodo_final_ventas." GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
        
            $ventas_linea_contacto_arreglo = array();
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE ".$periodo_inicial_publicidad." ".$periodo_final_publicidad." dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);
        
            foreach($clientes_lineas as $linea):
                $ventas_linea_contacto_arreglo[$i]['canal']     = $linea['dic_linea_contactos']['canal'];
                $ventas_linea_contacto_arreglo[$i]['cantidad']  = $linea[0]['registros'];
                $ventas_linea_contacto_arreglo[$i]['ventas']    = 0;
                $ventas_linea_contacto_arreglo[$i]['inversion'] = 0;
                foreach($venta_linea_contacto as $venta):
                    if ($venta['dic_linea_contactos']['canal'] == $linea['dic_linea_contactos']['canal']){
                        $ventas_linea_contacto_arreglo[$i]['ventas'] = $venta[0]['ventas'];
                    }
                endforeach;
                foreach($inversion_publicidad as $inversion): //Comparar las inversiones
                  if ($inversion['dic_linea_contactos']['linea_contacto'] == $linea['dic_linea_contactos']['canal']){
                      $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];    
                  }
                endforeach;
                $i++;
            endforeach;
            
            $resultado = array(
              'ventas_linea_contacto_arreglo' => $ventas_linea_contacto_arreglo,
              'total_clientes_lineas'         => $total_clientes_lineas
            );
        
            return $resultado;
          }

          public function proximos_eventos_15_dias($user_id) {
            $this->Event->Behaviors->load('Containable');
            $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
            $tipo_tarea          = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 4=>'Reactivación', 1=>'Visita');
            $tipo_tarea_opciones = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
            $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'check-circle', 'child' );
            $remitente           = '';
            $color               = '#AEE9EA';
            $textColor           = '#2f2f2f';
            $recordatorios       = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');
            $status              = array(0=> 'Creado(s)', 2=>'Cancelado(s)');

            $condiciones_eventos = array('Event.tipo_evento' => 1, 'Event.status' => array('0', '1'), 'Event.user_id' => $user_id,'Event.fecha_inicio >= CURDATE()', 'Event.fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)');
        
            // Eventos
            $eventos = $this->Event->find('all', array(
              'conditions' => $condiciones_eventos,
              'order' => array('Event.fecha_inicio' => 'DESC'),
              'contain' => array(
                'User' => array(
                  'fields' => array(
                      'User.id',
                      'User.nombre_completo',
                      'User.correo_electronico',
                  )
                ),
                'Inmueble' => array(
                    'fields' => array(
                        'Inmueble.id',
                        'Inmueble.titulo'
                    )
                ),
                'Desarrollo' => array(
                    'fields' => array(
                        'Desarrollo.id',
                        'Desarrollo.nombre'
                    )
                ),
                'Cliente' => array(
                    'fields' => array(
                        'Cliente.id',
                        'Cliente.nombre'
                    )
                )
              )
            ));
        
            $data_eventos = [];
            $s = 0;
            // Vamos a setear los eventos de forma correcta para mandar a llamar a la vista lo menos cargada posible
            foreach( $eventos as $evento ) {
        
              switch ($evento['Event']['tipo_tarea']) {
                case 0: // Cita
                  $remitente = 'para';
                  $color = '#AEE9EA';
                break;
                case 1: // Visita
                  $remitente = 'de';
                  $color = '#7CC3C4';
                break;
                case 2: //Llamada
                  $remitente = 'a';
                  $color = '#7AABF9';
                break;
                case 3: // Correo
                  $remitente = 'para';
                  $color = '#F0D38A';
                break;
                case 4: // Reactivacion
                  $remitente = 'de';
                  $color = '#ffe048';
                break;
              }
        
              
              if( $evento['Event']['status'] == 2) {
                $color = '#2f2f2f';
                $textColor = '#fff';
              }else {
                $textColor = '#2f2f2f';
              }
        
              if( isset($evento['Desarrollo']['nombre']) ){
                $nombre_ubicacion = strtoupper($evento['Desarrollo']['nombre']);
                $url_ubicacion    = '../desarrollos/view/'.$evento['Desarrollo']['id'];
              }else{
                $nombre_ubicacion = strtoupper($evento['Inmueble']['titulo']);
                $url_ubicacion    = '../inmuebles/view/'.$evento['Inmueble']['id'];
              }
        
              $s++;
              $data_eventos[$s]['titulo']              = strtoupper($evento['Cliente']['nombre']);
              $data_eventos[$s]['fecha_inicio']        = date('Y-m-d', strtotime($evento['Event']['fecha_inicio'])).'T'.date('H:i:s', strtotime($evento['Event']['fecha_inicio']));
              $data_eventos[$s]['color']               = $color;
              $data_eventos[$s]['textColor']           = $textColor;
              $data_eventos[$s]['icon']                = $tipo_tarea_icon[$evento['Event']['tipo_tarea']];
              $data_eventos[$s]['url']                 = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."')";
              $data_eventos[$s]['fecha_inicio_format'] = date('d/M/Y \a \l\a\s H:i', strtotime($evento['Event']['fecha_inicio']));
              $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
              $data_eventos[$s]['status']              = $evento['Event']['status'];
              $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
              $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
              $data_eventos[$s]['id_evento']           = $evento['Event']['id'];
            }
        
            return $data_eventos;
        
          }


  /* --------------- Function To consult user data (for editing) -------------- */
  public function user_view( $user_id = null ){
    $this->CuentasUser->Behaviors->load('Containable');
    header('Content-type: application/json charset=utf-8');

    $user = $this->CuentasUser->find('first',
      array(
        'fields' => array(
          'finanzas',
          'unidad_venta',
          'ventas_mensuales',
          'puesto'
        ),
        'conditions' => array(
          'User.id' => $user_id
        ),
        'contain' => array(
          'User' => array(
            'fields' => array(
              'User.id',
              'User.correo_electronico',
              'User.nombre_completo',
              'User.status',
              'User.telefono1',
              'User.foto',
            )
          ),
          'Cuenta' => array(
            'fields' => 'id'
          ),
          'Grupo' => array(
            'fields' => array(
              'id'
            )
          )
        )
      )
    );
    
    echo json_encode( $user );
    exit();

    $this->autoRender = false;
  }

}
