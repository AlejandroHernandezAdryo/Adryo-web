<?php
App::uses('AppController', 'Controller');
/**
 * Agendas Controller
 *
 * @property Agenda $Agenda
 * @property PaginatorComponent $Paginator
 */
class EventsController extends AppController {


// Return para los eventos 0 => calendario, 1=> clientes/view, 2=> dashboard
// 0=> Cita, 1=> Visita, 2=> Llamada, 3=> Correo, 4=> Reactivacion - Events
// 1 => Creación, 2 => Edición, 3 => Mail, 4 => Llamada, 5 => Cita, 6 => Mensaje, 7 => Generación de Lead 8 => Borrado de venta, 9 => Reactivación, 10=>Visita - LogCliente
// 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogInmueble
// 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogDesarrollo

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
         public $uses = array('Event','User','Cliente','Inmueble','Desarrollo','LogCliente','LogInmueble','LogDesarrollo', 'Lead','Agenda', 'DesarrolloInmueble');
         
         public function beforeFilter() {
            parent::beforeFilter();
            if ($this->Session->read('CuentaUsuario.Cuenta.id'!= NULL)) {
                $this->Session->write(
                  'clundef',
                  $this->Cliente->find(
                    'count',array(
                      'conditions'=>array(
                        'AND'=>array(
                          'Cliente.user_id IS NULL'
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
            $this->Auth->allow('index', 'get_add', 'get_events_user', 'cron_reactivacion_automatica_clientes');
        }

/**
 * index method
 *
 * @return void
 */
	public function index() {
        date_default_timezone_set('America/Mexico_City');
        $this->loadModel('Mailconfig');
        $this->User->Behaviors->load('Containable');
        $eventos = $this->Event->find('all',
            array(
                'conditions'=>array(
                    'and'=>array(
                        'Event.tipo_tarea' => array(0,2,3),
                        'Event.status <= ' => 1
                    ),
                    'or'=>array(
                        'Event.recordatorio_1 LIKE "'.date('Y-m-d H:i').'%"',
                        'Event.recordatorio_2 LIKE "'.date('Y-m-d H:i').'%"'
                    )
                ),
                'fields' => array(
                    'Event.id',
                    'Event.cliente_id',
                    'Event.user_id',
                    'Event.nombre_evento',
                    'Event.direccion',
                    'Event.fecha_inicio',
                    'User.id',
                    'User.nombre_completo',
                    'User.foto',
                    'User.correo_electronico',
                    'Cliente.nombre'
                ),
            )
        );

        $this->set('eventos', $eventos);
        $meses_esp = array( '01'=> 'Enero', '02'=> 'Febrero', '03'=> 'Marzo', '04'=> 'Abril', '05'=> 'Marzo', '06'=> 'Junio', '07'=> 'Julio', '08'=> 'Agosto', '09'=> 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        foreach ($eventos as $evento){
            echo "Mandaremos mensaje al usuario ".$evento['User']['correo_electronico'];
            $this->Email = new CakeEmail();
            $this->Email->config(array(
                    'host'      => 'mail.bosinmobiliaria.com',
                    'port'      => 587,
                    'username'  => 'sistemabos@bosinmobiliaria.com',
                    'password'  => 'Sistema.2018',
                    'transport' => 'Smtp'
                )
            );
            $this->Email->emailFormat('html');
            $this->Email->template('recordatorio','layoutinmomail');
            $this->Email->from(array('notificaciones@adryo.com.mx'=>'Próximo evento'));
            $this->Email->to($evento['User']['correo_electronico']);
            $this->Email->subject('Próximo evento');
            $this->Email->viewVars(array('evento'=>$evento, 'meses_esp'=>$meses_esp));
            $this->Email->send();
        }

        $this->autoRender = false;
	}
        
        public function enviar(){
            
            $eventos = $this->Event->find('all', array('conditions'=>array('recordatorio_1 LIKE "'.date('Y-m-d H:i').'%"')));
            //$eventos = $this->Event->find('all', array('conditions'=>array('Event.id'=>95)));
            foreach ($eventos as $evento):
                $this->Email = new CakeEmail();
                $this->Email->config(array(
                                'host'      => 'ssl://lpmail01.lunariffic.com',
                                'port'      => 465,
                                'username'  => 'sistemabos@bosinmobiliaria.mx',
                                'password'  => 'Sistema.2016',
                                'transport' => 'Smtp'
                            )
                    );
                $this->Email->emailFormat('html');
                $this->Email->template('recordatorio','bosemail');
                $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
                $this->Email->to($evento['User']['correo_electronico']);
                $this->Email->subject('Recordatorio de Evento');
                $this->Email->viewVars(array('evento'=>$evento));
                $this->Email->send();
            endforeach;
            
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$options = array('conditions' => array('Agenda.' . $this->Agenda->primaryKey => $id));
		$this->set('agenda', $this->Agenda->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */

    /*---------------------------------------------------------------------------------------------
    |   Metodo que sirve para crear eventos desde cualquier vista segun - AKA "SaaK"
    |
    |   Pasos para un alta existosa de evento.
    |   1.- Definir la zona horaria de mexico.
    |   2.- Setear las fechas de inicio, fecha final, recordatorio 1, recordatorio 2.
    |   3.- Guardar el evento.
    |       3.1.- Es importante saber cual es el tipo del evento con el cual se crea. (Esto no esta programado).
    |       3.2.- Hacer compatible el evento con la tabla de log de propiedades e inmuebles.
    |   4.- Guardar en el log del cliente.
    |   5.- Guardar en la agenda.
    |   6.- Guardar el log de la propiedad segun la seleccion del evento es decir si se relaciona a un desarrollo o
    |       una propiedad.
    |
    |   NOTA: Desde donde se puede crear un evento (ALTA, BAJA, CAMBIO).
    |           Vista del cliente (A,B,C)
    |           Vista del desarrollo (A,B,C)
    |           Vista de la propiedad (A,B,C)
    |           Vista desde la propiedad (Corretaje), (A,B,C)
    |           Vista desde el calendario (A,B,C)
    ---------------------------------------------------------------------------------------------*/

	public function add() {
            if ($this->request->is('post')) {
                $cliente_id    = $this->request->data['Event']['cliente_id'];
                $recordatorio  = "";
                $recordatorio2 = "";
                $inicio        = $this->request->data['Event']['fechaInicial']." ".$this->request->data['Event']['horaInicial'].":".$this->request->data['Event']['minutoInicial'].":00";
                $this->request->data['Event']['fecha_inicio'] = date("Y-m-d H:i:s",strtotime($inicio));

                if (!empty($this->request->data['Event']['recordatorio_1'])){
                    switch ($this->request->data['Event']['recordatorio_1']){
                        case 1:
                            $recordatorio = date("Y-m-d H:i:s",strtotime(strtotime($inicio)));
                            break;
                        case 2:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                            break;
                        case 3:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                            break;
                        case 4:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                            break;
                        case 5:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                            break;
                        case 6:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                            break;
                        case 7:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                            break;
                        case 8:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                            break;
                        case 9:
                            $recordatorio = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                            break;

                    }
                }else{
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                }

                if(!empty($this->request->data['Event']['recordatorio_2'])){
                    switch ($this->request->data['Event']['recordatorio_2']){
                        case 1:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime(strtotime($inicio)));
                            break;
                        case 2:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                            break;
                        case 3:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                            break;
                        case 4:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                            break;
                        case 5:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                            break;
                        case 6:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                            break;
                        case 7:
                            $recordatorio22 = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                            break;
                        case 8:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                            break;
                        case 9:
                            $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                            break;

                    }
                }

                $timestamp = date('Y-m-d h:i:s');
                $tipo_tarea = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita', 4=>'Reactivación');
                $this->Event->create();
                $this->request->data['Event']['recordatorio_1'] = $recordatorio;
                $this->request->data['Event']['recordatorio_2'] = $recordatorio2;
                $this->request->data['Event']['status']         = 1;

               if ($this->Event->save($this->request->data)) {
                   $event_id = $this->Event->getInsertID();


                    if( $this->request->data['Event']['inmueble_id'] != 0 ){
                        $interes = $this->Inmueble->find('first', array('conditions'=>array('Inmueble.id' => $this->request->data['Event']['inmueble_id']), 'fields' => array('Inmueble.titulo')));
                        $interes_nombre = $interes['Inmueble']['titulo'];
                        $desarrollo_inmueble = $this->DesarrolloInmueble->findByInmuebleId($this->request->data['Event']['inmueble_id']);
                    }

                    if( $this->request->data['Event']['desarrollo_id'] != 0){
                        
                        $interes = $this->Desarrollo->find('first', array('conditions'=>array('Desarrollo.id' => $this->request->data['Event']['desarrollo_id']), 'fields' => array('Desarrollo.nombre')));
                        $interes_nombre = $interes['Desarrollo']['nombre'];
                    }


                    // 0=> Cita, 1=> Visita, 2=> Llamada, 3=> Correo, 4=> Reactivacion - Event
                    // 1 => Creación, 2 => Edición, 3 => Mail, 4 => Llamada, 5 => Cita, 6 => Mensaje, 7 => Generación de Lead 8 => Borrado de venta, 9 => Reactivación, 10=>Visita - LogCliente
                    // 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita - LogInmueble
                    // 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita - LogDesarrollo

                    switch($this->request->data['Event']['tipo_tarea']){
                        case 0: // 0=>Cita
                            $accionLogCliente    = 5;
                            $accionLogInmueble   = 6;
                            $accionLogDesarrollo = 6;
                            $mensaje             = 'Cita creada para el día '.date("Y-m-d H:i:s",strtotime($inicio)).' en '.$interes_nombre;
                        break;
                        case 1: // 1=> Visita
                            $accionLogCliente    = 10;
                            $accionLogInmueble   = 7;
                            $accionLogDesarrollo = 7;
                            $mensaje             = 'Visita creada para el día '.date("Y-m-d H:i:s",strtotime($inicio)).' en '.$interes_nombre;
                        break;
                        case 2: // 2=>Llamada,
                            $accionLogCliente    = 4;
                            $accionLogInmueble   = 4;
                            $accionLogDesarrollo = 4;
                            $mensaje             = 'Llamada programada para el día '.date("Y-m-d H:i:s",strtotime($inicio));
                        break;
                        case 3: // 3=> Correo
                            $accionLogCliente    = 3;
                            $accionLogInmueble   = 5;
                            $accionLogDesarrollo = 5;
                            $mensaje             = 'Correo programado para el día '.date("Y-m-d H:i:s",strtotime($inicio));
                        break;
                        case 4: // 4=> Reactivacion
                            $accionLogCliente    = 9;
                            $accionLogInmueble   = 6;
                            $accionLogDesarrollo = 6;
                            $mensaje             = 'Reactivación automática para el día '.date("Y-m-d H:i:s",strtotime($inicio));
                        break;
                        default: // 0=> default
                            $accionLogCliente    = 2;
                            $accionLogInmueble   = 2;
                            $accionLogDesarrollo = 2;
                            $mensaje             = '';
                        break;
                    }

                    if( $this->request->data['Event']['inmueble_id'] != 0 ){

                        if( empty( $desarrollo_inmueble ) ) {
                            
                            $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_inmueble['DesarrolloInmueble']['desarrollo_id'];
                            $this->request->data['LogDesarrollo']['mensaje']       = $mensaje;
                            $this->request->data['LogDesarrollo']['usuario_id']    = $this->Session->read('Auth.User.id');
                            $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
                            $this->request->data['LogDesarrollo']['accion']        = $accionLogDesarrollo;
                            $this->request->data['LogDesarrollo']['event_id']      = $event_id;
                            $this->LogDesarrollo->create();
                            $this->LogDesarrollo->save($this->request->data);

                        }

                        $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                        $this->request->data['LogInmueble']['mensaje']     = $mensaje;
                        $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
                        $this->request->data['LogInmueble']['fecha']       = date('d/M/Y H:i:s');
                        $this->request->data['LogInmueble']['accion']      = $accionLogInmueble;
                        $this->request->data['LogInmueble']['event_id']    = $event_id;
                        $this->LogInmueble->create();
                        $this->LogInmueble->save($this->request->data);

                    }

                    if( $this->request->data['Event']['desarrollo_id'] != 0 ){
                        
                        $this->request->data['LogDesarrollo']['desarrollo_id'] = $this->request->data['Event']['desarrollo_id'];
                        $this->request->data['LogDesarrollo']['mensaje']       = $mensaje;
                        $this->request->data['LogDesarrollo']['usuario_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
                        $this->request->data['LogDesarrollo']['accion']        = $accionLogDesarrollo;
                        $this->request->data['LogDesarrollo']['event_id']      = $event_id;
                        $this->LogDesarrollo->create();
                        $this->LogDesarrollo->save($this->request->data);

                    }
                    
                    if( $this->request->data['Event']['cliente_id'] != 0 ){
                        
                        $this->LogCliente->create();
                        $this->request->data['LogCliente']['id']         = uniqid();
                        $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Event']['cliente_id'];
                        $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['LogCliente']['mensaje']    = $mensaje;
                        $this->request->data['LogCliente']['accion']     = $accionLogCliente;
                        $this->request->data['LogCliente']['datetime']   = $timestamp;
                        $this->request->data['LogCliente']['event_id']   = $event_id;
                        $this->LogCliente->save($this->request->data);
                        
                        $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = $cliente_id");
                        
                        $this->Agenda->create();
                        $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['Agenda']['fecha']      = $timestamp;
                        $this->request->data['Agenda']['mensaje']    = $mensaje;
                        $this->request->data['Agenda']['cliente_id'] = $this->request->data['Event']['cliente_id'];
                        $this->Agenda->save($this->request->data);

                    }


                    $this->Session->setFlash('', 'default', array(), 'success');
                    $this->Session->setFlash('Se ha agregado exitosamente el evento.', 'default', array(), 'm_success');
                } else {
                    $this->Session->setFlash('', 'default', array(), 'success');
                    $this->Session->setFlash('No se ha podido guardar el evento correctamente, favor de intentarlo de nuevo, gracias.', 'default', array(), 'm_success');
                }

                if (isset($this->request->data['Event']['return'])){
                    switch ($this->request->data['Event']['return']):
                        case 6:
                            $redirect = array('action' => 'view','controller'=>'clientes',$cliente_id);
                        break;
                        default:
                            $redirect = array('action' => 'calendar','controller'=>'users');
                        break;
                    endswitch;
                }else{
                    $redirect = array('action' => 'calendar','controller'=>'users');
                }
                
                $this->redirect($redirect);
		}
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit() {
		if ($this->request->is('post')) {
                    
                    /*
                     array(13) { 
                     *  ["nombre_evento"]=> string(16) "Evento de prueba" 
                     *  ["direccion"]=> string(15) "Lugar de prueba" 
                     *  ["fi"]=> string(10) "11-07-2017" 
                     *  ["hi"]=> string(2) "18" 
                     *  ["mi"]=> string(1) "0" 
                     *  ["ff"]=> string(10) "12-07-2017" 
                     *  ["hf"]=> string(2) "10" 
                     *  ["mf"]=> string(2) "20" 
                     *  ["recordatorio_1"]=> string(1) "1" 
                     *  ["recordatorio_2"]=> string(1) "2" 
                     *  ["cliente_id"]=> string(4) "1610" 
                     *  ["desarrollo_id"]=> string(2) "40" 
                     *  ["inmueble_id"]=> string(1) "6" }
                     */
                        $recordatorio = "";
                        $recordatorio2 = "";
                        
                        $inicio = $this->request->data['Event']['fi']." ".$this->request->data['Event']['hi'].":".$this->request->data['Event']['mi'].":00";
                        $fin = $this->request->data['Event']['ff']." ".$this->request->data['Event']['hf'].":".$this->request->data['Event']['mf'].":00";
                        $this->request->data['Event']['fecha_inicio']= date("Y-m-d H:i:s",strtotime($inicio));
                        $this->request->data['Event']['fecha_fin']= date("Y-m-d H:i:s",strtotime($fin));
                        
                        if (!empty($this->request->data['Event']['recordatorio_1'])){
                            switch ($this->request->data['Event']['recordatorio_1']){
                                case 1:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime(strtotime($inicio)));
                                    break;
                                case 2:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                                    break;
                                case 3:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                                    break;
                                case 4:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                                    break;
                                case 5:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                                    break;
                                case 6:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                                    break;
                                case 7:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                                    break;
                                case 8:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                                    break;
                                case 9:
                                    $recordatorio = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                                    break;

                            }
                        }
                        if(!empty($this->request->data['Event']['recordatorio_2'])){
                            switch ($this->request->data['Event']['recordatorio_1']){
                                case 1:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime(strtotime($inicio)));
                                    break;
                                case 2:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                                    break;
                                case 3:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                                    break;
                                case 4:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                                    break;
                                case 5:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                                    break;
                                case 6:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                                    break;
                                case 7:
                                    $recordatorio22 = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                                    break;
                                case 8:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                                    break;
                                case 9:
                                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                                    break;

                            }
                        }
                        
                        $this->request->data['Event']['user_id']        = $this->Session->read('Auth.User.id');
                        $this->request->data['Event']['recordatorio_1'] = $recordatorio;
                        $this->request->data['Event']['recordatorio_2'] = $recordatorio2;
                        $this->request->data['Event']['status']         = 1;
			            $this->Event->create();
                        
                        if ($this->Event->save($this->request->data)) {
                                if($this->request->data['Event']['cliente_id']!=""){
                                    $this->LogCliente->create();
                                    $this->request->data['LogCliente']['id']         = uniqid();
                                    $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Event']['cliente_id'];
                                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogCliente']['mensaje']    = "Evento de cliente modificado";
                                    $this->request->data['LogCliente']['accion']     = $this->request->data['Event']['color'];
                                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                                    $this->LogCliente->save($this->request->data);
                                }
                                if($this->request->data['Event']['inmueble_id']!=""){
                                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                                    $this->request->data['LogInmueble']['mensaje']     = "Evento modificado";
                                    $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
                                    $this->request->data['LogInmueble']['accion']      = $this->request->data['Event']['color'];
                                    $this->LogInmueble->create();
                                    $this->LogInmueble->save($this->request->data);
                                    
                                }
                                if($this->request->data['Event']['desarrollo_id']!=""){
                                    $this->request->data['LogDesarrollo']['desarrollo_id'] = $this->request->data['Event']['desarrollo_id'];
                                    $this->request->data['LogDesarrollo']['mensaje']       = "Evento modificado";
                                    $this->request->data['LogDesarrollo']['usuario_id']    = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
                                    $this->request->data['LogDesarrollo']['accion']        = $this->request->data['Event']['color'];
                                    $this->LogDesarrollo->create();
                                    $this->LogDesarrollo->save($this->request->data);
                                    
                                }
                                $this->Session->setFlash(__('El evento ha sido modificado exitosamente'));
				return $this->redirect(array('action' => 'calendar','controller'=>'users'));
			} else {
				$this->Session->setFlash(__('The agenda could not be saved. Please, try again.'));
			}
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
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('El evento ha sido eliminado exitosamente'),'default',array('class'=>'success'));
		} else {
			$this->Session->setFlash(__('El evento no pudo ser eliminado. Intenta de nuevo'),'default',array('class'=>'error'));
		}
		return $this->redirect(array('action' => 'calendar','controller'=>'users'));
	}
        
        public function cerrar($id = null, $status = null){
            $this->Event->query("UPDATE events SET status = $status WHERE id = $id");
            return $this->redirect(array('action' => 'dashboard','controller'=>'users'));
        }
        


    public function add_check_lead(){
        
        if ($this->request->is('post')) {


            $recordatorio = "";
            $recordatorio2 = "";
            
            $inicio = $this->request->data['Event']['fi']." ".$this->request->data['Event']['hi'].":".$this->request->data['Event']['mi'].":00";
            $fin = $this->request->data['Event']['ff']." ".$this->request->data['Event']['hf'].":".$this->request->data['Event']['mf'].":00";
            $this->request->data['Event']['fecha_inicio']= date("Y-m-d H:i:s",strtotime($inicio));
            $this->request->data['Event']['fecha_fin']= date("Y-m-d H:i:s",strtotime($fin));
            
            if (!empty($this->request->data['Event']['recordatorio_1'])){
                switch ($this->request->data['Event']['recordatorio_1']){
                    case 1:
                        $recordatorio = date("Y-m-d H:i:s",strtotime(strtotime($inicio)));
                        break;
                    case 2:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                        break;
                    case 3:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                        break;
                    case 4:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                        break;
                    case 5:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                        break;
                    case 6:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                        break;
                    case 7:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                        break;
                    case 8:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                        break;
                    case 9:
                        $recordatorio = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                        break;

                } // End switch recordatorio 1
            } // End if empty recordarorio 1

            if(!empty($this->request->data['Event']['recordatorio_2'])){
                switch ($this->request->data['Event']['recordatorio_1']){
                    case 1:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime(strtotime($inicio)));
                        break;
                    case 2:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                        break;
                    case 3:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                        break;
                    case 4:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                        break;
                    case 5:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                        break;
                    case 6:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                        break;
                    case 7:
                        $recordatorio22 = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                        break;
                    case 8:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                        break;
                    case 9:
                        $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                        break;

                } // End switch recordatorio 2
            } // End if empty recordarorio 2

            $this->request->data['Event']['user_id']        = $this->Session->read('Auth.User.id');
            $this->request->data['Event']['cuenta_id']      = $this->Session->read('CuentaUsuario.Cuenta.id');
            $this->request->data['Event']['recordatorio_1'] = $recordatorio;
            $this->request->data['Event']['recordatorio_2'] = $recordatorio2;
            $this->request->data['Event']['status']         = 1;
            $this->Event->create();


            if ($this->Event->save($this->request->data)) {
                if($this->request->data['Event']['cliente_id']!=""){
                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         = uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Event']['cliente_id'];
                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['mensaje']    = "Evento del cliente creado";
                    // $this->request->data['LogCliente']['accion']  = '1';
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);
                }
                if($this->request->data['Event']['inmueble_id']!=""){
                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                    $this->request->data['LogInmueble']['mensaje']     = "Evento asignado";
                    $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
                    $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
                    $this->request->data['LogInmueble']['accion']      = $this->request->data['Event']['color'];
                    $this->LogInmueble->create();
                    $this->LogInmueble->save($this->request->data);
                    
                }

                $leads = $this->Lead->find('count',
                                        array(
                                            'conditions'=>array(
                                                'Lead.cliente_id'=>$this->request->data['Event']['cliente_id'],
                                                'Lead.inmueble_id '=>$this->request->data['Event']['inmueble_id']
                                            )
                                        ));

                if ($leads <= 0) {

                    $this->request->data['Lead']['cliente_id']  = $this->request->data['Event']['cliente_id'];
                    $this->request->data['Lead']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                    $this->request->data['Lead']['status']      = "Abierto";
                    $this->Lead->create();
                    $this->Lead->save($this->request->data);

                    // $this->Lead->query("INSERT INTO leads VALUES(0,$this->Session->read('Auth.User.id'),$this->request->data['Event']['inmueble_id'],'Abierto','',null)");
                }

                $this->Session->setFlash(__('El evento ha sido creado exitosamente'));
                return $this->redirect(array('action' => 'calendar','controller'=>'users'));
            } else {
                $this->Session->setFlash(__('The agenda could not be saved. Please, try again.'));
            }
            
        }

    }

    public function get_add( $user_id = null, $cuenta_id = null ) {
        date_default_timezone_set('America/Mexico_City');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
        $this->layout = null;

        // $data_event = array(
        //     'cliente_id' => "23843",
        //     'cuenta_id' => "1",
        //     'desarrollo_id' => "",
        //     'fecha_inicio' => "2020-06-15 15:37:00",
        //     'inmueble_id' => "",
        //     'recordatorio1' => "1",
        //     'recordatorio2' => "3",
        //     'status_evento' => 0,
        //     'tipo_evento' => "0",
        //     'tipo_tarea' => "3",
        //     'user_id' => "447",
        // );

        $data_event = array(
            "cliente_id"        => $this->request->data['clienteId'],
            "user_id"           => $this->request->data['asesorId'],
            "fecha_inicio"      => substr($this->request->data['fechaInicio'], 0, 10).' '.substr($this->request->data['fechaInicio'], 11,-13).':00',
            "inmueble_id"       => $this->request->data['propiedadId'],
            "desarrollo_id"     => $this->request->data['desarrolloId'],
            "recordatorio1"     => $this->request->data['recordatorio1'],
            "recordatorio2"     => $this->request->data['recordatorio2'],
            "tipo_evento"       => '0',
            "tipo_tarea"        => $this->request->data['tipoEvento'],
            "status_evento"            => 0,
            "cuenta_id"         => $cuenta_id,
        );

        $save_event = $this->add_evento( $data_event );

        // print_r( $save_event );
        echo json_encode( $save_event , true );
        $this->autoRender = false;
    }


    public function get_events_user( $cuenta_id = null, $user_id = null ){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
        $this->layout = null;

        $this->Event->Behaviors->load('Containable');
        $events = $this->Event->find('all', array(
            //'recursive' => 1,
            'fields'=>array(
                'Event.fecha_inicio','Event.tipo_tarea'
            ),
            'conditions' => array(
                //'Event.cuenta_id' => $cuenta_id,
                'Event.user_id'   => $user_id
            ),
            'contain' => array(
                'Cliente'=>array(
                    'fields'=>array(
                        'nombre'
                    )
                )
            ),
        ));
        //echo var_dump($events);

        $s = 0;
        $data_evento = [];
        $tipo_tarea = array(''=>'', 0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita', 4=>'Reactivación');
        foreach( $events as $evento ){

            // Setear la fecha para dia y mes.

            // Dia
            // if( date('j', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $dia = '0o'.date('j', strtotime( $evento['Event']['fecha_inicio'] ));
            // }else{
            //     $dia = date('j', strtotime( $evento['Event']['fecha_inicio'] ));
            // }

            // if( date('n', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $mes = '0o'.date('n', strtotime( $evento['Event']['fecha_inicio'] ));
            // }else{
            //     $mes = date('n', strtotime( $evento['Event']['fecha_inicio'] ));
            // }

            // if( date('g', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $hora = '0o'.date('g', strtotime( $evento['Event']['fecha_inicio'] ));
            // }else{
            //     $hora = date('g', strtotime( $evento['Event']['fecha_inicio'] ));
            // }

            // if( date('m', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $minuto = '0o'.substr(date('m', strtotime( $evento['Event']['fecha_inicio'] )), -1);
            // }else{
            //     $minuto = date('m', strtotime( $evento['Event']['fecha_inicio'] ));
            // }


            // $fecha_inicio = date('Y', strtotime($evento['Event']['fecha_inicio'])).', '.$mes.', '.$dia.', '.$hora.', '.$minuto.', 0o0';
            //$fecha_inicio = date('Y-m-d H:i:s', strtotime($evento['Event']['fecha_inicio']));
            
            switch($evento['Event']['tipo_tarea']){
                case 0: // 0=>Cita
                    $tipo_where = 'con';
                break;
                case 1: // 1=> Visita
                    $tipo_where = 'con';
                break;
                case 2: // 2=>Llamada,
                    $tipo_where = 'a';
                break;
                case 3: // 3=> Correo
                    $tipo_where = 'para';
                break;
                case 4: // 4=> Reactivacion
                    $tipo_where = 'de';
                break;
                default: // 0=> default
                $tipo_where = '';
                break;
            }
            

            $data_evento[$s] = array(
                'title'     => $tipo_tarea[$evento['Event']['tipo_tarea']].' '.$tipo_where.' '.$evento['Cliente']['nombre'],
                'startTime' => '2020-06-05 14:00:00',
                'endTime'   => '2020-06-05 14:00:00',
                'allDay'    => false
            );
            $s++;
        }

        echo json_encode( $data_evento, true );
        $this->autoRender = false;    

    }

    
    public function abk_get_events_user( $cuenta_id = null, $user_id = null ) {
        $this->Event->Behaviors->load('Containable');
        date_default_timezone_set('America/Mexico_City');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
        $this->layout = null;

        $events = $this->Event->find('all', array(
            //'recursive' => 1,
            'fields'=>array(
                'Event.fecha_inicio','Event.tipo_tarea'
            ),
            'conditions' => array(
                //'Event.cuenta_id' => $cuenta_id,
                'Event.user_id'   => $user_id
            ),
            'contain' => array(
                'Cliente'=>array(
                    'fields'=>array(
                        'nombre'
                    )
                )
            ),
        ));

        // $s = 0;
        // $eventCustom = array('titulo' => 'titulo', 'startTime' => date('Y-m-d'), 'endTime'=>date('Y-m-d'));
        // date("D M d Y H:i:s  \G\M\TO")

        // $resp = array(
        //     'Ok' => true,
        //     'mensaje' => $eventCustom
        // );

        // echo json_encode($eventCustom, true );
        $s = 0;
        $data_evento = [];
        $tipo_tarea = array(''=>'', 0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita', 4=>'Reactivación');
        foreach( $events as $evento ){

            // Setear la fecha para dia y mes.

            // Dia
            // if( date('j', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $dia = '0o'.date('j', strtotime( $evento['Event']['fecha_inicio'] ));
            // }else{
            //     $dia = date('j', strtotime( $evento['Event']['fecha_inicio'] ));
            // }

            // if( date('n', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $mes = '0o'.date('n', strtotime( $evento['Event']['fecha_inicio'] ));
            // }else{
            //     $mes = date('n', strtotime( $evento['Event']['fecha_inicio'] ));
            // }

            // if( date('g', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $hora = '0o'.date('g', strtotime( $evento['Event']['fecha_inicio'] ));
            // }else{
            //     $hora = date('g', strtotime( $evento['Event']['fecha_inicio'] ));
            // }

            // if( date('m', strtotime( $evento['Event']['fecha_inicio'] )) <= 9 ){
            //     $minuto = '0o'.substr(date('m', strtotime( $evento['Event']['fecha_inicio'] )), -1);
            // }else{
            //     $minuto = date('m', strtotime( $evento['Event']['fecha_inicio'] ));
            // }


            // $fecha_inicio = date('Y', strtotime($evento['Event']['fecha_inicio'])).', '.$mes.', '.$dia.', '.$hora.', '.$minuto.', 0o0';
            //$fecha_inicio = date('Y-m-d H:i:s', strtotime($evento['Event']['fecha_inicio']));
            
            switch($evento['Event']['tipo_tarea']){
                case 0: // 0=>Cita
                    $tipo_where = 'con';
                break;
                case 1: // 1=> Visita
                    $tipo_where = 'con';
                break;
                case 2: // 2=>Llamada,
                    $tipo_where = 'a';
                break;
                case 3: // 3=> Correo
                    $tipo_where = 'para';
                break;
                case 4: // 4=> Reactivacion
                    $tipo_where = 'de';
                break;
                default: // 0=> default
                $tipo_where = '';
                break;
            }
            

            $data_evento[$s] = array(
                'title'     => $evento['Event']['tipo_tarea'].' '.$tipo_where.' '.$evento['Cliente']['nombre'],
                'startTime' => $evento['Event']['fecha_inicio'],
                'endTime'   => $evento['Event']['fecha_inicio'],
                'allDay'    => false
            );
            $s++;
        }

        echo json_encode( $data_evento, true );
        $this->autoRender = false;
    }





    public function cron_reactivacion_automatica_clientes() {
        $this->layout = null;
  
        $eventos = $this->Event->find('all',
            array(
                'conditions'=>array(
                    'and' => array(
                        'Event.tipo_tarea' => 4,
                        'Event.recordatorio_1 >=' => date('Y-m-d 00:00:00'),
                        'Event.recordatorio_1 <=' => date('Y-m-d 23:59:59'),
                    )
                ),
                'fields' => array(
                    'User.id',
                    'User.nombre_completo',
                    'Cliente.id',
                    'Cliente.nombre'
                ),
            )
        );

        // Vamos a reactivar los clientes obtenidos de la consulta anterior.
        foreach( $eventos as $cliente ){
            
            $this->request->data['Cliente']['id']        = $cliente['Cliente']['id'];
            $this->request->data['Cliente']['status']    = 'Activo';
            $this->request->data['Cliente']['last_edit'] = date('Y-m-d H:i:s');
            $this->Cliente->save($this->request->data);

            // Avisamos al log
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
            $this->request->data['LogCliente']['user_id']    = $cliente['User']['id'];
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
            $this->request->data['LogCliente']['accion']     = 2;
            $this->request->data['LogCliente']['mensaje']    = "Se reactivo el cliente el día ".date('d-m-Y')." de forma automatica." ;
            $this->LogCliente->save($this->request->data);

            // Seguimiento rapido
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id']    = $cliente['User']['id'];
            $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje']    = "Se reactivo el cliente el día ".date('d-m-Y')." de forma automatica." ;
            $this->request->data['Agenda']['cliente_id'] = $cliente['Cliente']['id'];
            $this->Agenda->save($this->request->data);


            $this->Email = new CakeEmail();
            $this->Email->config(array(
                    'host'      => 'mail.bosinmobiliaria.com',
                    'port'      => 587,
                    'username'  => 'sistemabos@bosinmobiliaria.com',
                    'password'  => 'Sistema.2018',
                    'transport' => 'Smtp'
                )
            );
            $this->Email->emailFormat('html');
            $this->Email->template('recordatorio','layoutinmomail');
            $this->Email->from(array('notificaciones@adryo.com.mx'=>'Reactivación automatica de cliente'));
            $this->Email->to($evento['User']['correo_electronico']);
            $this->Email->subject('Reactivación automatica de cliente');
            $this->Email->viewVars(array('evento'=>$evento, 'meses_esp'=>$meses_esp));
            $this->Email->send();
        }

        $this->autoRender = false;
    }




    function status() {

        $this->request->data['Event']['id']             = $this->request->data['Event']['evento_id'];
        $this->request->data['Event']['status']         = $this->request->data['Event']['status'];

        // Paso 1 = Buscar el id del evento.
        $event = $this->Event->find('first', array('conditions' => array('Event.id' => $this->request->data['Event']['evento_id']), 'recursive' => -1));

        // Paso 2 saber si el evento es cita y el evento se confirma, cambiarlo a visita.
        if( $event['Event']['tipo_tarea'] == 0 && $this->request->data['Event']['status'] == 1 ) {

            $this->request->data['Event']['tipo_tarea'] = 1;
            $this->Event->query("UPDATE log_clientes SET accion = 10 WHERE event_id = ".$event['Event']['id'].";");

            if( $event['Event']['inmueble_id'] != 0 && $event['Event']['desarrollo_id'] != 0 ){ // Evento para un inmueble de un desarrollo.

                $this->Event->query("UPDATE log_desarrollos SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");
                $this->Event->query("UPDATE log_inmuebles SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");

            }elseif( $event['Event']['desarrollo_id'] != 0 ){ // En caso de que se halla seleccionado un inmueble

                $this->Event->query("UPDATE log_desarrollos SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");
            
            }elseif( $event['Event']['inmueble_id'] != 0 ){ // En caso de que se halla seleccionado un inmueble

                $this->Event->query("UPDATE log_inmuebles SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");
            
            }

        }

        switch ($this->request->data['Event']['return']){
            case 1:
                $redirect = array('action' => 'calendar','controller'=>'users');
            break;
            case 2:
                $redirect = array('action' => 'dashboard','controller'=>'users');
            break;
            case 3:
                $redirect = array('action' => 'view','controller'=>'inmuebles', $this->request->data['Event']['param_return'] );
            break;
            case 4:
                $redirect = array('action' => 'view','controller'=>'desarrollos', $this->request->data['Event']['param_return'] );
            break;
            case 5:
                $redirect = array('action' => 'view','controller'=>'users', $this->request->data['Event']['param_return'] );
            break;
            case 6:
                $redirect = array('action' => 'view','controller'=>'clientes', $this->request->data['Event']['param_return'] );
            break;
            default:
                $redirect = array('action' => 'calendar','controller'=>'users');
            break;
        }

        $this->Event->save($this->request->data);
        
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash('El cambio se ha realizado exitosamente.', 'default', array(), 'm_success'); // Mensaje
        $this->redirect($redirect);
        
        $this->autoRender = false; 

    } // Fin function status



    function search() {

        $this->Event->Behaviors->load('Containable');          
        $asesores    = '';
        $clientes    = [];
        $desarrollos = [];
        $inmuebles   = [];
        $eventos     = [];
        $data_evento = [];
        $s = 0;


        $fecha_inicial = date('Y').'01-01 00:00:00';
        $fecha_fianl   = date('Y').'12-31 59:59:59';
        $limpieza = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
        $tipo_tarea = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
        $tipo_tarea_icon = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'send' );
        $remitente = '';
        $color = '#7699D3';
        $recordatorios = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');

        if ( $this->Session->read('Permisos.Group.call') == 1 ) {
            // Todos los asesores
            $asesores = $this->User->find('list', array(
              'conditions' => array(
                // 'User.status' => 1,
                // 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'User.id' => $this->request->data['Event']['asesor_id']
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

            $eventos = $this->Event->find('all', array(
              'conditions' => array(
                'Event.tipo_evento' => 1,
                'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
              ),
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


          }elseif( !empty($this->Session->read('Desarrollador')) ){ // Fin de condicion para gerentes y super admin.
            $asesores = $this->User->find('list', array(
              'conditions' => array(
                'User.status' => 1,
                'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id = '.$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id').')'
              ),
              'order' => 'User.nombre_completo ASC'
            ));

            $clientes = $this->Cliente->find('list', array(
              'conditions' => array(
                'Cliente.status'     => 'Activo',
                'Cliente.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Cliente.user_id <>' => '',
                'Desarrollo.id'      => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
              ),
              'order' => 'Cliente.nombre ASC'
            ));

            $desarrollos = $this->Desarrollo->find('list', array(
              'conditions' => array(
                'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Desarrollo.id'        => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
              ),
              'order' => 'Desarrollo.nombre ASC'
            ));

            $inmuebles = $this->Inmueble->find('list', array(
              'conditions' => array(
                'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Inmueble.id'        => '(Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id').')'
              ),
              'order' => 'Inmueble.titulo ASC'
            ));

            $eventos = $this->Event->find('all', array(
              'conditions' => array(
                'Event.tipo_evento'   => 1,
                'Event.cuenta_id'     => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Event.desarrollo_id' => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
                'Event.inmueble_id'   => '(Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id').')',
              ),
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

          }else{ // Fin de condicion para desarrollador
            $clientes = $this->Cliente->find('list', array(
              'conditions' => array(
                'Cliente.status'    => 'Activo',
                'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') ,
                'Cliente.user_id'   => $this->Session->read('Auth.User.id'),
              ),
              'order' => 'Cliente.nombre ASC'
            ));

            $desarrollos = $this->Desarrollo->find('list', array(
              'conditions' => array(
                'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Desarrollo.visible'   => 1,
              ),
              'order' => 'Desarrollo.nombre ASC'
            ));

            $inmuebles = $this->Inmueble->find('list', array(
              'conditions' => array(
                'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Inmueble.liberada'  => 1,
                'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
              ),
              'order' => 'Inmueble.titulo ASC'
            ));
            
            $eventos = $this->Event->find('all', array(
              'conditions' => array(
                'Event.tipo_evento' => 1,
                'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Event.user_id'     => $this->Session->read('Auth.User.id'),
              ),
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

          } // Fin de condicion para asesor


          // Vamos a hacer el arreglo para solo hacer el foreach en la vista.
          foreach( $eventos as $evento ) {

            switch ($evento['Event']['tipo_tarea']) {
              case 0:
                $remitente = 'para';
                $color = '#7699D3';
              break;
              case 1:
                $remitente = 'de';
                $color = '#A3BEE9';
              break;
              case 2:
                $remitente = 'a';
                $color = '#7699D3';
              break;
              case 3:
                $remitente = 'para';
                $color = '#7699D3';
              break;
            }

            if( $evento['Event']['status'] == 2){
              $color = '#F04A42';
            }
            

            if( isset($evento['Desarrollo']['nombre']) ){
              $nombre_ubicacion = strtoupper($evento['Desarrollo']['nombre']);
              $url_ubicacion    = '../desarrollos/view/'.$evento['Desarrollo']['id'];
            }else{
              $nombre_ubicacion = strtoupper($evento['Inmueble']['titulo']);
              $url_ubicacion    = '../inmuebles/view/'.$evento['Inmueble']['id'];
            }

            $s++;
            $data_eventos[$s]['titulo']       = strtoupper($evento['Cliente']['nombre']);
            $data_eventos[$s]['fecha_inicio'] = date('Y-m-d', strtotime($evento['Event']['fecha_inicio'])).'T'.date('H:i:s', strtotime($evento['Event']['fecha_inicio']));
            $data_eventos[$s]['color']        = $color;
            $data_eventos[$s]['textColor']    = '#FFF';
            $data_eventos[$s]['icon']         = $tipo_tarea_icon[$evento['Event']['tipo_tarea']];
            $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."')";
            
          }
          
          
          // Podemos setear el evento para mostrar el calendario limpio
          $this->set(compact('asesores'));
          $this->set(compact('clientes'));
          $this->set(compact('desarrollos'));
          $this->set(compact('inmuebles'));
          $this->set(compact('eventos'));
          $this->set(compact('data_eventos'));
          $this->set(compact('tipo_tarea'));
          $this->set(compact('recordatorios'));
          // $this->set('tipo_tarea', sort($tipo_tarea));

          $this->redirect(array('action' => 'calendar','controller'=>'users'));

        // print_r($this->request->data);
        // $this->autoRender = false; 
    }



    public function eventos_proximos() {
        $fecha_inicial       = date('Y').'01-01 00:00:00';
        $fecha_fianl         = date('Y').'12-31 59:59:59';
        
        $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
        $tipo_tarea          = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 4=>'Reactivación', 1=>'Visita');
        $tipo_tarea_opciones = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita');
        $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'home', 'child' );
        $remitente           = '';
        $color               = '#AEE9EA';
        $textColor           = '#2f2f2f';
        $recordatorios       = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes');
        $status              = array(0=> 'Creado(s)', 2=>'Cancelado(s)');

        $eventos = $this->Event->find('all', array(
            'conditions' => array(
            'Event.tipo_evento' => 1,
            'Event.status'      => array('0', '1'),
            'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
            ),
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
    }


    public function add_evento( $data_event ){

        // Paso 1.- vamos a setear el recordatorio 1, si es que esta inicializado.
        $timestamp  = date('Y-m-d h:i:s');
        $tipo_tarea = array(0=>'Cita', 3 => 'Correo', 2=>'Llamada', 1=>'Visita', 4=>'Reactivación');
        $inicio     = $data_event['fecha_inicio'];
        
        // Recordatorio 1
        if (!empty($data_event['recordatorio1'])){
            switch ($data_event['recordatorio1']){
                case 1:
                    $recordatorio = date("Y-m-d H:i:s",strtotime($inicio));
                    break;
                case 2:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
                    break;
                case 3:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-30 minute',strtotime($inicio)));
                    break;
                case 4:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-1 hour',strtotime($inicio)));
                    break;
                case 5:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-2 hour',strtotime($inicio)));
                    break;
                case 6:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-6 hour',strtotime($inicio)));
                    break;
                case 7:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                    break;
                case 8:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                    break;
                case 9:
                    $recordatorio = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                    break;

            }
        }else{
            $recordatorio = date("Y-m-d H:i:s",strtotime('-15 minute',strtotime($inicio)));
        }

        // Recordatorio 2
        if(!empty($data_event['recordatorio2'])){
            switch ($data_event['recordatorio1']){
                case 1:
                    $recordatorio2 = $inicio;
                    break;
                case 2:
                    $recordatorio2 = strtotime('-15 minute',strtotime($inicio));
                    break;
                case 3:
                    $recordatorio2 = strtotime('-30 minute',strtotime($inicio));
                    break;
                case 4:
                    $recordatorio2 = strtotime('-1 hour',strtotime($inicio));
                    break;
                case 5:
                    $recordatorio2 = strtotime('-2 hour',strtotime($inicio));
                    break;
                case 6:
                    $recordatorio2 = strtotime('-6 hour',strtotime($inicio));
                    break;
                case 7:
                    $recordatorio22 = strtotime('-12 hour',strtotime($inicio));
                    break;
                case 8:
                    $recordatorio2 = strtotime('-1 day',strtotime($inicio));
                    break;
                case 9:
                    $recordatorio2 = strtotime('-2 day',strtotime($inicio));
                    break;

            }
            $this->request->data['Event']['recordatorio_2'] = $recordatorio2;
        }

        // Save evento
        $this->Event->create();
        $this->request->data['Event']['cliente_id']     = $data_event['cliente_id'];
        $this->request->data['Event']['user_id']        = $data_event['user_id'];
        $this->request->data['Event']['nombre_evento']  = $tipo_tarea[$data_event['tipo_tarea']];
        $this->request->data['Event']['fecha_inicio']   = $inicio;
        $this->request->data['Event']['inmueble_id']    = $data_event['inmueble_id'];
        $this->request->data['Event']['desarrollo_id']  = $data_event['desarrollo_id'];
        $this->request->data['Event']['recordatorio_1'] = $recordatorio;
        $this->request->data['Event']['tipo_evento']    = $data_event['tipo_evento']; // Evento manual
        $this->request->data['Event']['tipo_tarea']     = $data_event['tipo_tarea'];
        $this->request->data['Event']['status']         = $data_event['status_evento']; // Status del evento
        $this->request->data['Event']['cuenta_id']      = $data_event['cuenta_id'];

        if ( $this->Event->save($this->request->data) ) {
            $event_id = $this->Event->getInsertID();

            if( $data_event['inmueble_id'] != 0 ){
                $interes = $this->Inmueble->find('first', array('conditions'=>array('Inmueble.id' => $data_event['inmueble_id']), 'fields' => array('Inmueble.titulo')));
                $interes_nombre = $interes['Inmueble']['titulo'];
                $desarrollo_inmueble = $this->DesarrolloInmueble->findByInmuebleId($data_event['inmueble_id']);
            }

            if( $data_event['desarrollo_id'] != 0){
                
                $interes = $this->Desarrollo->find('first', array('conditions'=>array('Desarrollo.id' => $data_event['desarrollo_id']), 'fields' => array('Desarrollo.nombre')));
                $interes_nombre = $interes['Desarrollo']['nombre'];
            }

            switch($data_event['tipo_tarea']){
                case 0: // 0=>Cita
                    $accionLogCliente    = 5;
                    $accionLogInmueble   = 6;
                    $accionLogDesarrollo = 6;
                    $mensaje             = 'Cita creada para el día '.date("Y-m-d H:i:s",strtotime($inicio)).' en '.$interes_nombre;
                break;
                case 1: // 1=> Visita
                    $accionLogCliente    = 10;
                    $accionLogInmueble   = 7;
                    $accionLogDesarrollo = 7;
                    $mensaje             = 'Visita creada para el día '.date("Y-m-d H:i:s",strtotime($inicio)).' en '.$interes_nombre;
                break;
                case 2: // 2=>Llamada,
                    $accionLogCliente    = 4;
                    $accionLogInmueble   = 4;
                    $accionLogDesarrollo = 4;
                    $mensaje             = 'Llamada programada para el día '.date("Y-m-d H:i:s",strtotime($inicio));
                break;
                case 3: // 3=> Correo
                    $accionLogCliente    = 3;
                    $accionLogInmueble   = 5;
                    $accionLogDesarrollo = 5;
                    $mensaje             = 'Correo programado para el día '.date("Y-m-d H:i:s",strtotime($inicio));
                break;
                case 4: // 4=> Reactivacion
                    $accionLogCliente    = 9;
                    $accionLogInmueble   = 6;
                    $accionLogDesarrollo = 6;
                    $mensaje             = 'Reactivación automática para el día '.date("Y-m-d H:i:s",strtotime($inicio));
                break;
                default: // 0=> default
                    $accionLogCliente    = 2;
                    $accionLogInmueble   = 2;
                    $accionLogDesarrollo = 2;
                    $mensaje             = '';
                break;
            }

            if( $data_event['inmueble_id'] != 0 ){

                if( empty( $desarrollo_inmueble ) ) {
                    
                    $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_inmueble['DesarrolloInmueble']['desarrollo_id'];
                    $this->request->data['LogDesarrollo']['mensaje']       = $mensaje;
                    $this->request->data['LogDesarrollo']['usuario_id']    = $data_event['user_id'];
                    $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
                    $this->request->data['LogDesarrollo']['accion']        = $accionLogDesarrollo;
                    $this->request->data['LogDesarrollo']['event_id']      = $event_id;
                    $this->LogDesarrollo->create();
                    $this->LogDesarrollo->save($this->request->data);

                }

                $this->request->data['LogInmueble']['inmueble_id'] = $data_event['inmueble_id'];
                $this->request->data['LogInmueble']['mensaje']     = $mensaje;
                $this->request->data['LogInmueble']['usuario_id']  = $data_event['user_id'];
                $this->request->data['LogInmueble']['fecha']       = date('d/M/Y H:i:s');
                $this->request->data['LogInmueble']['accion']      = $accionLogInmueble;
                $this->request->data['LogInmueble']['event_id']    = $event_id;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);

            }

            if( $data_event['desarrollo_id'] != 0 ){
                
                $this->request->data['LogDesarrollo']['desarrollo_id'] = $data_event['desarrollo_id'];
                $this->request->data['LogDesarrollo']['mensaje']       = $mensaje;
                $this->request->data['LogDesarrollo']['usuario_id']    = $data_event['user_id'];
                $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
                $this->request->data['LogDesarrollo']['accion']        = $accionLogDesarrollo;
                $this->request->data['LogDesarrollo']['event_id']      = $event_id;
                $this->LogDesarrollo->create();
                $this->LogDesarrollo->save($this->request->data);

            }

            if( $data_event['cliente_id'] != 0 ){
                
                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']         = uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $data_event['cliente_id'];
                $this->request->data['LogCliente']['user_id']    = $data_event['user_id'];
                $this->request->data['LogCliente']['mensaje']    = $mensaje;
                $this->request->data['LogCliente']['accion']     = $accionLogCliente;
                $this->request->data['LogCliente']['datetime']   = $timestamp;
                $this->request->data['LogCliente']['event_id']   = $event_id;
                $this->LogCliente->save($this->request->data);
                
                $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = ".$data_event['cliente_id'].";");
                
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']    = $data_event['user_id'];
                $this->request->data['Agenda']['fecha']      = $timestamp;
                $this->request->data['Agenda']['mensaje']    = $mensaje;
                $this->request->data['Agenda']['cliente_id'] = $data_event['cliente_id'];
                $this->Agenda->save($this->request->data);

            }

            $respuesta = array(
                'bandera' => true,
                'mensaje' => 'Se ha agregado exitosamente el evento.'
            );


        }else{
            
            $respuesta = array(
                'bandera' => true,
                'mensaje' => 'No se ha podido guardar el evento correctamente, favor de intentarlo de nuevo, gracias.'
            );

        }

        // $respuesta = array(
        //     'bandera' => true,
        //     'mensaje' => 'Fecha inicio: '.$inicio.' recordatorio: '.$recordatorio
        // );
        

        return $respuesta;
        
    }


}
?>
