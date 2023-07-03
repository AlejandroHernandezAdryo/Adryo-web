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
// 1 => Creación, 2 => Edición, 3 => Mail, 4 => Llamada, 5 => Cita, 6 => Mensaje, 7 => Generación de Lead 8 => Borrado de venta, 9 => Reactivación, 10=>Visita, 11=>Visita - LogCliente
// 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogInmueble
// 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogDesarrollo

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
         public $uses = array('Event','User','Cliente','Inmueble','Desarrollo','LogCliente','LogInmueble','LogDesarrollo', 'Lead','Agenda', 'DesarrolloInmueble', 'LogClientesEtapa');
         
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
            $this->Auth->allow('index', 'get_add', 'get_events_user', 'cron_reactivacion_automatica_clientes','get_events_user_ios', 'correcion_inmuebles_events');
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
            $desarrollo_id  = 0;
            $inmueble_id    = 0;

            if( isset( $this->request->data['FormCreateEvent']['desarrollo_id'] ) ) {
                $desarrollo_id = $this->request->data['FormCreateEvent']['desarrollo_id'];
            }

            if( isset( $this->request->data['FormCreateEvent']['inmueble_id'] ) ) {
                $inmueble_id = $this->request->data['FormCreateEvent']['inmueble_id'];
            }

            $fecha_inicio = date('Y-m-d', strtotime ( $this->request->data['FormCreateEvent']['fechaInicial'] )).' '.$this->request->data['FormCreateEvent']['horaInicial'].':'.$this->request->data['FormCreateEvent']['minutoInicial'].':00';

            $data_event = array(
                "cliente_id"        => $this->request->data['FormCreateEvent']['cliente_id'],
                "user_id"           => $this->request->data['FormCreateEvent']['user_id'],
                "fecha_inicio"      => $fecha_inicio,
                "inmueble_id"       => $inmueble_id,
                "desarrollo_id"     => $desarrollo_id,
                "recordatorio1"     => $this->request->data['FormCreateEvent']['recordatorio_1'],
                "recordatorio2"     => $this->request->data['FormCreateEvent']['recordatorio_2'],
                "tipo_evento"       => '1',
                "tipo_tarea"        => $this->request->data['FormCreateEvent']['tipo_tarea'],
                "status_evento"     => 1,
                "cuenta_id"         => $this->Session->read('CuentaUsuario.Cuenta.id'),
            );
            $save_event = $this->add_evento( $data_event );

            if( $save_event['bandera'] == 1 ) {
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash($save_event['mensaje'], 'default', array(), 'm_success');
            }else {
                $this->Session->setFlash('', 'default', array(), 'error');
                $this->Session->setFlash($save_event['mensaje'], 'default', array(), 'm_error');
            }
            
            
            switch ($this->request->data['FormCreateEvent']['return']) {
                case 6:
                    $redirect = array('action' => 'view', 'controller' => 'clientes', $this->request->data['FormCreateEvent']['cliente_id']);
                    break;
                
                default:
                    $redirect = array('action' => 'calendar', 'controller' => 'users');
                    break;
            }
            $this->redirect( $redirect );
            $this->autoRender = false;
             
		}
    }
    
    public function edit() {

        $params_evento = array(
            "event_id"     => $this->request->data['FormEditEvent']['evento_id'],
            "fecha_inicio" => date( 'Y-m-d', strtotime( $this->request->data['FormEditEvent']['fechaInicial'] ) ).' '.$this->request->data['FormEditEvent']['horaInicial'].':'.$this->request->data['FormEditEvent']['minutoInicial'].':00',
            "user_id"      => $this->request->data['FormEditEvent']['user_id'],
            "fecha_origen" => $this->request->data['FormEditEvent']['fecha_origen'],
            "cliente_id"   => $this->request->data['FormEditEvent']['cliente_id'],
            "recordatorio1"   => $this->request->data['FormEditEvent']['recordatorio_1'],
            "recordatorio2"   => $this->request->data['FormEditEvent']['recordatorio_2'],

        );

        $params_user = array(
            'user_id'   => $this->Session->read('Auth.User.id'),
            'cuenta_id' => $this->Session->read('CuentaUsuario.Cuenta.id')
        );

        $save_event = $this->edit_evento( $params_evento, $params_user );

        if( $save_event['bandera'] == 1 ) {
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash($save_event['mensaje'], 'default', array(), 'm_success');
        }else {
            $this->Session->setFlash('', 'default', array(), 'error');
            $this->Session->setFlash($save_event['mensaje'], 'default', array(), 'm_error');
        }

        switch ($this->request->data['FormEditEvent']['return']) {
            case 6: // Regresar al cliente.
                $redirect = array('action' => 'view', 'controller' => 'clientes', $this->request->data['FormEditEvent']['cliente_id']);
                break;
            
            default: // Por defecto, regresar al calendario.
                $redirect = array('action' => 'calendar', 'controller' => 'users');
                break;
        }
        
        $this->redirect( $redirect );

    }

    // Funcion para la edicion de eventos.
    public function edit_evento ( $data_event = null, $params_user = null ) {
        $timestamp  = date('Y-m-d h:i:s');
        $inicio     = $data_event['fecha_inicio'];
        
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
        if( !empty( $data_event['recordatorio2'] ) ) {
            switch ( $data_event['recordatorio2'] ) {
                case 1:
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime($inicio));
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
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                    break;
                case 8:
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                    break;
                case 9:
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                    break;

            }
            $this->request->data['Event']['recordatorio_2'] = $recordatorio2;
        }

        $this->request->data['Event']['id']                     = $data_event['event_id'];
        $this->request->data['Event']['fecha_inicio']           = $data_event['fecha_inicio'];
        $this->request->data['Event']['user_id']                = $data_event['user_id'];
        $this->request->data['Event']['recordatorio_1']         = $recordatorio;
        $this->request->data['Event']['recordatorio_2']         = $recordatorio2;
        $this->request->data['Event']['opt_recordatorio_1']     = $data_event['recordatorio1'];
        $this->request->data['Event']['opt_recordatorio_2']     = $data_event['recordatorio2'];

        // Agregar historico del evento.
        $accionLogCliente    = 9;
        $mensaje = 'Cita modificada del día '.date('d/m/Y \a \l\a\s H:i', strtotime($data_event['fecha_origen'])).' al <strong>'.date('d/m/Y \a \l\a\s H:i', strtotime($data_event['fecha_inicio'])).'</strong>';

        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         = uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $data_event['cliente_id'];
        $this->request->data['LogCliente']['user_id']    = $params_user['user_id'];
        $this->request->data['LogCliente']['mensaje']    = $mensaje;
        $this->request->data['LogCliente']['accion']     = $accionLogCliente;
        $this->request->data['LogCliente']['datetime']   = $timestamp;
        $this->request->data['LogCliente']['event_id']   = $data_event['event_id'];
        $this->LogCliente->save($this->request->data);
        
        $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = ".$data_event['cliente_id'].";");
        
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $params_user['user_id'];
        $this->request->data['Agenda']['fecha']      = $timestamp;
        $this->request->data['Agenda']['mensaje']    = $mensaje;
        $this->request->data['Agenda']['cliente_id'] = $data_event['cliente_id'];
        $this->Agenda->save($this->request->data);


        
        if( $this->Event->save($this->request->data) ) {
        
            $respuesta = array(
                'bandera' => true,
                'mensaje' => 'Se ha cambiado correctamente el evento.'
            );
        }else {

            $respuesta = array(
                'bandera' => false,
                'mensaje' => 'No se ha podido guardar el evento correctamente, favor de intentarlo de nuevo, gracias.'
            );

        }

        
        return $respuesta;
        $this->autoRender = false;

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
        $this->layout = null;

        $data_event = array(
            "cliente_id"        => $this->request->data['clienteId'],
            "user_id"           => $this->request->data['asesorId'],
            "fecha_inicio"      => $this->request->data['fechaInicio'],
            "inmueble_id"       => $this->request->data['propiedadId'],
            "desarrollo_id"     => $this->request->data['desarrolloId'],
            "recordatorio1"     => $this->request->data['recordatorio1'],
            "recordatorio2"     => $this->request->data['recordatorio2'],
            "tipo_evento"       => '1',
            "tipo_tarea"        => $this->request->data['tipoEvento'],
            "status_evento"     => 1,
            "cuenta_id"         => $cuenta_id,
        );

        $save_event = $this->add_evento( $data_event );

        // print_r( $save_event );
        echo json_encode( $save_event , true );
        $this->autoRender = false;
    }


    public function get_events_user( $cuenta_id = null, $user_id = null ){
        $this->layout = null;

        $this->Event->Behaviors->load('Containable');
        $events = $this->Event->find('all', array(
            //'recursive' => 1,
            'fields'=>array(
                'Event.fecha_inicio','Event.tipo_tarea'
            ),
            'conditions' => array(
                //'Event.cuenta_id' => $cuenta_id,
                'Event.user_id'   => $user_id,
                'Event.tipo_evento IS NOT NULL' 
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
                'startTime' => date("Y-m-d\TH:i:s",strtotime($evento['Event']['fecha_inicio'])),
                'endTime'   => date("Y-m-d\TH:i:s",strtotime($evento['Event']['fecha_inicio'])), 
                'allDay'    => false
            );
            $s++;
        }

        echo json_encode( $data_evento, true );
        $this->autoRender = false;    

    }

    public function get_events_user_ios( $cuenta_id = null, $user_id = null ){
        $this->layout = null;

        $this->Event->Behaviors->load('Containable');
        $events = $this->Event->find('all', array(
            //'recursive' => 1,
            'fields'=>array(
                'Event.fecha_inicio','Event.tipo_tarea'
            ),
            'conditions' => array(
                //'Event.cuenta_id' => $cuenta_id,
                'Event.user_id'   => $user_id,
                'Event.tipo_evento IS NOT NULL' 
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
                'startTime' => date("Y-m-d\TH:i:s",strtotime($evento['Event']['fecha_inicio'])),
                'endTime'   => date("Y-m-d\TH:i:s",strtotime($evento['Event']['fecha_inicio'])), 
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
        //$this->layout = null;

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
                    'User.correo_electronico',
                    'Cliente.id',
                    'Cliente.nombre',
                    'Cliente.status'
                ),
            )
        );

        $this->set('eventos',$eventos);

        //$asesor = 0;
        foreach($eventos as $evento):

            // Si el cliente se encuentra inactivo definitvo no debe de hacer alguna accion
            if( $evento['Cliente']['status'] != 'Inactivo' ){

                //Cada cliente se reactiva
                $this->request->data['Cliente']['id']        = $evento['Cliente']['id'];
                $this->request->data['Cliente']['status']    = 'Activo';
                $this->request->data['Cliente']['last_edit'] = date('Y-m-d H:i:s');
                $this->Cliente->create();
                $this->Cliente->save($this->request->data);
                
                //Avisamos al log
                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']         =  uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $evento['Cliente']['id'];
                $this->request->data['LogCliente']['user_id']    = $evento['User']['id'];
                $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
                $this->request->data['LogCliente']['accion']     = 2;
                $this->request->data['LogCliente']['mensaje']    = "Se reactivó el cliente el día ".date('d-m-Y')." de forma automática." ;
                $this->LogCliente->create();
                $this->LogCliente->save($this->request->data);
    
                //Seguimiento rapido
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']    = $evento['User']['id'];
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']    = "Se reactivó el cliente el día ".date('d-m-Y')." de forma automática." ;
                $this->request->data['Agenda']['cliente_id'] = $evento['Cliente']['id'];
                $this->Agenda->create();
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
                $this->Email->template('reactivacion','layoutinmomail');
                $this->Email->from(array('notificaciones@adryo.com.mx'=>'Reactivación automática de cliente'));
                //$this->Email->to($evento['User']['correo_electronico']);
                $this->Email->to($evento['User']['correo_electronico']);
                $this->Email->to('cesari.pineda@outlook.com');
                $this->Email->subject('Reactivación automática de cliente');
                $this->Email->viewVars(array('cliente'=>$evento['Cliente']['nombre'],'cliente_id'=>$evento['Cliente']['id'],'usuario'=>$evento['User']['nombre_completo']));
                $this->Email->send();
            }
        endforeach;
    }

    //robertoCambio
    function status() {
        $this->Cliente->Behaviors->load('Containable');$this->LogClientesEtapa->Behaviors->load('Containable');
        $this->loadModel('LogClientesEtapa');
        $this->loadModel('Cliente');
        $log_cliente_etapa=array();
        $timestamp = date('Y-m-d h:i:s');
        $this->request->data['Event']['id']             = $this->request->data['formUpdateEvent']['evento_id'];
        $this->request->data['Event']['status']         = $this->request->data['formUpdateEvent']['status'];

        // Paso 1 = Buscar el id del evento.
        $event = $this->Event->find('first', array('conditions' => array('Event.id' => $this->request->data['formUpdateEvent']['evento_id']), 'recursive' => -1));

        // Paso 2 saber si el evento es cita y el evento se confirma, cambiarlo a visita.
        if( $event['Event']['tipo_tarea'] == 0 && $this->request->data['formUpdateEvent']['status'] == 1 ) {

            $this->request->data['Event']['tipo_tarea'] = 1;
            
            //cambiar de estatus el cliente para confirmar cita.

            // Hacer validación del cliente que si se encuentra en una etapa mayot a 4 no se hace el cambio a un retroceso.
            $cliente = $this->Cliente->find('first', array(
                'contain' => false,
                'conditions' => array(
                    'Cliente.id' => $event['Event']['cliente_id']
                )
            ));
            if( $cliente['Cliente']['etapa'] < 4 ) {

                // $this->Event->query("UPDATE clientes SET etapa = 4 WHERE id = ".$event['Event']['cliente_id']);
                $fecha= date('Y-m-d H:i:s');
                $this->request->data['Cliente']['id']        = $event['Event']['cliente_id'];
                $this->request->data['Cliente']['last_edit'] = $fecha;
                $this->request->data['Cliente']['etapa']     = 4;
                //rogueEtapaFecha
                $this->request->data['Cliente']['fecha_cambio_etapa'] =  date('Y-m-d');
                $this->Cliente->save($this->request->data); 
                //yo buscar en el log etapa a ese clientes y continuar con su asesor en caso de que alguien mas sea el que confirme o guia a clientes en el desarrollo
                // $search_Cliente=$this-> se busca la info para que continue con la informacion y no pase nada 
                // $this->Event->query("UPDATE clientes SET etapa = 4 WHERE id = ".$event['Event']['cliente_id']);
                
            }


            $this->Event->query("UPDATE log_clientes SET accion = 10 WHERE event_id = ".$event['Event']['id'].";");

            // Crear nuevo registro para el seguimiento rapido.
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         = uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $event['Event']['cliente_id'];
            $this->request->data['LogCliente']['user_id']    = $event['Event']['user_id'];
            $this->request->data['LogCliente']['mensaje']    = "La cita del día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio']))." ha pasado a ser una visita";
            $this->request->data['LogCliente']['accion']     = 5;
            $this->request->data['LogCliente']['datetime']   = $timestamp;
            $this->request->data['LogCliente']['event_id']   = $event['Event']['id'];
            $this->LogCliente->save($this->request->data);
            
            $mensaje='El cliente se mueve a Cita / Visita por la siguiente razón: Se confirma la cita programada con el cliente';

            $this->Cliente->query("UPDATE clientes SET comentarios = '$mensaje',last_edit = '$timestamp' WHERE id = ".$event['Event']['cliente_id'].";");
            
            // La cita se convierte en visita.
            $this->Event->query("UPDATE events SET nombre_evento = 'Visita', tipo_tarea = 1 WHERE id = ".$event['Event']['id'].";");
            
            
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id']    = $event['Event']['user_id'];
            $this->request->data['Agenda']['fecha']      = $timestamp;
            $this->request->data['Agenda']['mensaje']    = "La cita del día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio']))." ha pasado a ser una visita";
            $this->request->data['Agenda']['cliente_id'] = $event['Event']['cliente_id'];
            $this->Agenda->save($this->request->data);

            if( $event['Event']['inmueble_id'] != 0 && $event['Event']['desarrollo_id'] != 0 ){ // Evento para un inmueble de un desarrollo.

                $this->Event->query("UPDATE log_desarrollos SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");
                $this->Event->query("UPDATE log_inmuebles SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");

            }elseif( $event['Event']['desarrollo_id'] != 0 ){ // En caso de que se halla seleccionado un inmueble

                $this->Event->query("UPDATE log_desarrollos SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");
            
            }elseif( $event['Event']['inmueble_id'] != 0 ){ // En caso de que se halla seleccionado un inmueble

                $this->Event->query("UPDATE log_inmuebles SET accion = 7 WHERE event_id = ".$event['Event']['id'].";");
            
            }

            $mensaje_confirmacion = "La cita del día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio']))." ha pasado a ser una visita";

            // Aqui se debe de validar que la cita pasa a visita y se cambia en automatico el cliente de etapa a 4.
            // Cambio de etapa. esto esta mal  lo tengo que pensar 
            $log_cliente_etapa=$this->LogClientesEtapa->find('first',
                array(      
                    'conditions'=>array(
                        'LogClientesEtapa.cliente_id '=>$event['Event']['cliente_id'],
                        'LogClientesEtapa.status '=>'Activo',

                    ),
                    'fields'=>array(
                        'LogClientesEtapa.etapa ',
                        'LogClientesEtapa.id ',
                    ),

                    'contain'=>false
                )
            );
            if( $log_cliente_etapa['LogClientesEtapa']['etapa'] < 4 ) {

                $etapas_cliente = $this->LogClientesEtapa->find('all', array(
                    'conditions' => array(
                        'LogClientesEtapa.cliente_id' => $event['Event']['cliente_id'],
                        // 'LogClientesEtapa.status'     => 'Activo'
                        )
                ));
                    
                    // Todas las etapas del cliente que hay pasan a ser inactivas.
                foreach( $etapas_cliente as $etapa_cliente ){
                    $this->request->data['LogClientesEtapa']['id']        = $etapa_cliente['LogClientesEtapa']['id'];
                    $this->request->data['LogClientesEtapa']['status']       = 'Inactivo';
                    $this->LogClientesEtapa->save($this->request->data);
                }
            // }

            // Creamos el registro de la nueva etapa.
            //aqui hace falta la validacion de que si esta en otra etapa no lo baje desde la etapa 6 y 7  $event['Event']['cliente_id']
            // if( $log_cliente_etapa['LogClientesEtapa']['etapa']< 4 ) {
                $this->LogClientesEtapa->create();
                $this->request->data['LogClientesEtapa']['id']            = null;
                $this->request->data['LogClientesEtapa']['cliente_id']    = $event['Event']['cliente_id'];
                $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
                $this->request->data['LogClientesEtapa']['etapa']         = 4;
                $this->request->data['LogClientesEtapa']['desarrollo_id'] = ( empty($cliente['Cliente']['desarrollo_id']) ? 0 : $cliente['Cliente']['desarrollo_id'] );
                $this->request->data['LogClientesEtapa']['inmuble_id']    = ( empty($cliente['Cliente']['inmueble_id']) ? 0 : $cliente['Cliente']['inmueble_id'] );
                $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                $this->request->data['LogClientesEtapa']['user_id']       =  $cliente['Cliente']['user_id'];
                $this->LogClientesEtapa->save($this->request->data);
                
                $this->request->data['Agenda']['user_id']    = $event['Event']['user_id'];
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']    = "Se realiza cambio a etapa 4, el cliente valida la cita generada el día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio'])).".";
                $this->request->data['Agenda']['cliente_id'] = $event['Event']['cliente_id'];
                $this->Agenda->save($this->request->data);
            }else {

                $this->Event->query("UPDATE log_clientes_etapas SET  status='Activo'  WHERE id = ".$log_cliente_etapa['LogClientesEtapa']['id'].";");

                $this->request->data['Agenda']['user_id']    = $event['Event']['user_id'];
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                // $this->request->data['Agenda']['mensaje']    = "El cliente valida la cita generada el día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio'])).".";
                $this->request->data['Agenda']['mensaje']    = 'El cliente cambia automáticamente a etapa 4 por: "confirmación de la cita en visita".';
                $this->request->data['Agenda']['cliente_id'] = $event['Event']['cliente_id'];
                $this->Agenda->save($this->request->data);
            }


        }else {

            if ( $this->request->data['formUpdateEvent']['status'] == 2 ) {

                $this->request->data['Event']['motivo_cancelacion']         = $this->request->data['formUpdateEvent']['motivo_cancelacion'];

                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']         = uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $event['Event']['cliente_id'];
                $this->request->data['LogCliente']['user_id']    = $event['Event']['user_id'];
                $this->request->data['LogCliente']['mensaje']    = "La cita del día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio']))." se ha cancelado";
                $this->request->data['LogCliente']['accion']     = 10;
                $this->request->data['LogCliente']['datetime']   = $timestamp;
                $this->request->data['LogCliente']['event_id']   = $event['Event']['id'];
                $this->LogCliente->save($this->request->data);
                
                $this->Cliente->query("UPDATE clientes SET last_edit = ' $timestamp' WHERE id = ".$event['Event']['cliente_id'].";");
                
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']    = $event['Event']['user_id'];
                $this->request->data['Agenda']['fecha']      = $timestamp;
                $this->request->data['Agenda']['mensaje']    = "La cita del día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio']))." se ha cancelado";
                $this->request->data['Agenda']['cliente_id'] = $event['Event']['cliente_id'];
                $this->Agenda->save($this->request->data);

                $mensaje_confirmacion = "La cita del día ".date('d/m/Y \a \l\a\s H:i', strtotime($event['Event']['fecha_inicio']))." se ha cancelado";

            }

        }

        switch ($this->request->data['formUpdateEvent']['return']){
            case 1:
                $redirect = array('action' => 'calendar','controller'=>'users');
            break;
            case 2:
                $redirect = array('action' => 'dashboard','controller'=>'users');
            break;
            case 3:
                $redirect = array('action' => 'view','controller'=>'inmuebles', $event['Event']['inmueble_id'] );
            break;
            case 4:
                $redirect = array('action' => 'view','controller'=>'desarrollos', $event['Event']['desarrollo_id'] );
            break;
            case 5:
                $redirect = array('action' => 'view','controller'=>'users', $event['Event']['user_id'] );
            break;
            case 6:
                $redirect = array('action' => 'view','controller'=>'clientes', $event['Event']['cliente_id'] );
            break;
            default:
                $redirect = array('action' => 'calendar','controller'=>'users');
            break;
        }

        $this->Event->save($this->request->data);
        
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash($mensaje_confirmacion, 'default', array(), 'm_success'); // Mensaje
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
                'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id = '.$this->Session->read('Desarrollos').')'
              ),
              'order' => 'User.nombre_completo ASC'
            ));

            $clientes = $this->Cliente->find('list', array(
              'conditions' => array(
                'Cliente.status'     => 'Activo',
                'Cliente.cuenta_id'  => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Cliente.user_id <>' => '',
                'Desarrollo.id'      => $this->Session->read('Desarrollos'),
              ),
              'order' => 'Cliente.nombre ASC'
            ));

            $desarrollos = $this->Desarrollo->find('list', array(
              'conditions' => array(
                'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Desarrollo.id'        => $this->Session->read('Desarrollos'),
              ),
              'order' => 'Desarrollo.nombre ASC'
            ));

            $inmuebles = $this->Inmueble->find('list', array(
              'conditions' => array(
                'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Inmueble.id'        => '(Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$this->Session->read('Desarrollos').')'
              ),
              'order' => 'Inmueble.titulo ASC'
            ));

            $eventos = $this->Event->find('all', array(
              'conditions' => array(
                'Event.tipo_evento'   => 1,
                'Event.cuenta_id'     => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Event.desarrollo_id' => $this->Session->read('Desarrollos'),
                'Event.inmueble_id'   => '(Select inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$this->Session->read('Desarrollos').')',
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
            $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('h:i:s a', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))."','".date('h', strtotime($evento['Event']['fecha_inicio']))."','".date('i a', strtotime($evento['Event']['fecha_inicio']))."','".$evento['Event']['desarrollo_id']."','".$evento['Event']['inmueble_id']."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_1']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_1']))."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_2']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_2']))."','".$evento['Event']['opt_recordatorio_1']."','".$evento['Event']['opt_recordatorio_2']."')";
            
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
        $tipo_tarea_icon     = array(0=>'home', 3 => 'envelope',  2=>'phone', 1=>'check-circle', 'child' );
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
            $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('h:i:s a', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))."','".date('h', strtotime($evento['Event']['fecha_inicio']))."','".date('i a', strtotime($evento['Event']['fecha_inicio']))."','".$evento['Event']['desarrollo_id']."','".$evento['Event']['inmueble_id']."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_1']))." ".date('h:i:s', strtotime($evento['Event']['recordatorio_1']))."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_2']))." ".date('h:i:s', strtotime($evento['Event']['recordatorio_2']))."','".$evento['Event']['opt_recordatorio_1']."','".$evento['Event']['opt_recordatorio_2']."')";
            $data_eventos[$s]['fecha_inicio_format'] = date('d/M/Y \a \l\a\s h:i', strtotime($evento['Event']['fecha_inicio']));
            $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
            $data_eventos[$s]['status']              = $evento['Event']['status'];
            $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
            $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
            $data_eventos[$s]['id_evento']           = $evento['Event']['id'];
        }
    }

    public function add_evento( $data_event = null ){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DesarrolloInmueble');
        $this->Cliente->Behaviors->load('Containable');
        $this->loadModel('Cliente');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
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
        if( !empty( $data_event['recordatorio2'] ) ) {
            switch ( $data_event['recordatorio2'] ) {
                case 1:
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime($inicio));
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
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-12 hour',strtotime($inicio)));
                    break;
                case 8:
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($inicio)));
                    break;
                case 9:
                    $recordatorio2 = date("Y-m-d H:i:s",strtotime('-2 day',strtotime($inicio)));
                    break;

            }
            $this->request->data['Event']['recordatorio_2'] = $recordatorio2;
        }
        /**
         * se agrega los eventos si no contiene id de desarrollo RogueOne
         */
        if ($data_event['desarrollo_id']==0) {
            $inmueble_id =$data_event['inmueble_id'];
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
            $this->Event->create();
            $this->request->data['Event']['cliente_id']                 = $data_event['cliente_id'];
            $this->request->data['Event']['user_id']                    = $data_event['user_id'];
            $this->request->data['Event']['nombre_evento']              = $tipo_tarea[$data_event['tipo_tarea']];
            $this->request->data['Event']['fecha_inicio']               = $inicio;
            $this->request->data['Event']['inmueble_id']                = $data_event['inmueble_id'];
            $this->request->data['Event']['desarrollo_id']              = $search_desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
            $this->request->data['Event']['recordatorio_1']             = $recordatorio;
            $this->request->data['Event']['tipo_evento']                = $data_event['tipo_evento']; // Evento manual
            $this->request->data['Event']['tipo_tarea']                 = $data_event['tipo_tarea'];
            $this->request->data['Event']['status']                     = $data_event['status_evento']; // Status del evento
            $this->request->data['Event']['cuenta_id']                  = $data_event['cuenta_id'];
            $this->request->data['Event']['opt_recordatorio_1']         = $data_event['recordatorio1'];
            $this->request->data['Event']['opt_recordatorio_2']         = $data_event['recordatorio2'];

            if ( $this->Event->save($this->request->data) ) {
                $event_id = $this->Event->getInsertID();
                $meses_esp = array( '01'=> 'Enero', '02'=> 'Febrero', '03'=> 'Marzo', '04'=> 'Abril', '05'=> 'Marzo', '06'=> 'Junio', '07'=> 'Julio', '08'=> 'Agosto', '09'=> 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
                $evento_=$this->Event->find('first',array(
                    'conditions'=>array(
                      'Event.id'=>$event_id
                    ),
                    'contain' => false 
                    )
                  );
           
                if (  $data_event['tipo_evento'] == 0)  {
                    $cliente = $this->Cliente->read(null,$data_event['cliente_id']);
                     $this->loadModel('Mailconfig');
                    $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                    //$cliente = $this->Cliente->read(null,$this->request->data['Agenda']['cliente_id']);
                    $usuario = $this->User->read(null, $data_event['user_id']);
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
                    $this->Email->template('asesoria','layoutinmomail');
                    //$this->Email->template('emailaasesor','layoutinmomail');
                    $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->subject('Notificación para seguimiento de cliente');
                    $this->Email->viewVars(array('asesor'=>$usuario,'comentarios'=>'sincomentarios','cliente' => $cliente,'fecha'=>date("d/M/Y H:i:s")));
                    $this->Email->send();
                }
                
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
                        $mensaje             = 'Cita creada para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio)).' en '.$interes_nombre;
                    break;
                    case 1: // 1=> Visita
                        $accionLogCliente    = 10;
                        $accionLogInmueble   = 7;
                        $accionLogDesarrollo = 7;
                        $mensaje             = 'Visita creada para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio)).' en '.$interes_nombre;
                    break;
                    case 2: // 2=>Llamada,
                        $accionLogCliente    = 4;
                        $accionLogInmueble   = 4;
                        $accionLogDesarrollo = 4;
                        $mensaje             = 'Llamada programada para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio));
                    break;
                    case 3: // 3=> Correo
                        $accionLogCliente    = 3;
                        $accionLogInmueble   = 5;
                        $accionLogDesarrollo = 5;
                        $mensaje             = 'Correo programado para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio));
                    break;
                    case 4: // 4=> Reactivacion
                        $accionLogCliente    = 9;
                        $accionLogInmueble   = 6;
                        $accionLogDesarrollo = 6;
                        $mensaje             = 'Reactivación automática para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio));
                    break;
                    default: // 0=> default
                        $accionLogCliente    = 2;
                        $accionLogInmueble   = 2;
                        $accionLogDesarrollo = 2;
                        $mensaje             = '';
                    break;
                }

                if( $data_event['inmueble_id'] != 0 ){

                    if( isset( $desarrollo_inmueble['DesarrolloInmueble'] ) ) {
                        
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
                    $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:m:i');;
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

                // if( $data_event['tipo_tarea'] == 0 OR $data_event['tipo_tarea'] == 1 ){
                    
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

                // Agregaremos el cambiar de etapa 2 a 3 de forma automcatica cuando se genera un evento de cita para el cliente.
                if( $data_event['tipo_tarea'] == 0){
                    $cliente = $this->Cliente->read(null,$data_event['cliente_id']);
                    
                    if( $cliente['Cliente']['etapa'] == 2 ){
                        $this->request->data['Cliente']['etapa']  = 3;
        
                        $cliente_etapa = $this->LogClientesEtapa->find('first',
                            array(
                                'conditions' => array(
                                    'LogClientesEtapa.etapa'      => 2,
                                    'LogClientesEtapa.status'     => 'Activo',
                                    'LogClientesEtapa.cliente_id' => $data_event['cliente_id'],
                                )
                            )
                        );

                        if( !empty( $cliente_etapa ) ){
                            
                            // Pasamos la etapa 1 a desactivar.
                            $this->request->data['LogClientesEtapa']['id']     = $cliente_etapa['LogClientesEtapa']['id'];
                            $this->request->data['LogClientesEtapa']['status'] = 'Inactivo';
                            
                            if( $this->LogClientesEtapa->save($this->request->data) ){
                                
                                // Consultamos el log de clientes de la etapa 1, la desactivamos y registramos la numero 2
                                $this->LogClientesEtapa->create();
                                $this->request->data['LogClientesEtapa']['id']           = null;
                                $this->request->data['LogClientesEtapa']['cliente_id']   = $data_event['cliente_id'];
                                $this->request->data['LogClientesEtapa']['fecha']        = date('Y-m-d H:i:s');
                                $this->request->data['LogClientesEtapa']['etapa']        = 3;
                                $this->request->data['LogClientesEtapa']['desarrollo_id'] = $cliente_etapa['LogClientesEtapa']['desarrollo_id'];
                                $this->request->data['LogClientesEtapa']['inmuble_id']   = $cliente_etapa['LogClientesEtapa']['inmuble_id'];
                                $this->request->data['LogClientesEtapa']['status']       = 'Activo';
                                $this->request->data['LogClientesEtapa']['user_id']      = $data_event['user_id'];
                                $this->LogClientesEtapa->save($this->request->data);
            
                                //Registrar Seguimiento Rápido para el cambio de etapa automatico
                                $this->Agenda->create();
                                $this->request->data['Agenda']['user_id']    = $data_event['user_id'];
                                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                                $this->request->data['Agenda']['mensaje']    = "El cliente cambia automáticamente a etapa 3 por: Registro de una cita para el día ".date("d/m/Y \a \l\a\s H:i",strtotime($inicio))." en ".$interes_nombre;
                                $this->request->data['Agenda']['cliente_id'] = $data_event['cliente_id'];
                                $this->Agenda->save($this->request->data);
            
                            }
            
                            // Registrar ultimo seguimiento
                            $this->request->data['Cliente']['id']         = $data_event['cliente_id'];
                            $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                            //rogueEtapaFecha
                            $this->request->data['Cliente']['fecha_cambio_etapa'] =  date('Y-m-d');
                            $this->Cliente->save($this->request->data);

                        }
        
                    }
                }

                // }

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
        }else {
            // Save evento
            
            $this->Event->create();
            $this->request->data['Event']['cliente_id']                 = $data_event['cliente_id'];
            $this->request->data['Event']['user_id']                    = $data_event['user_id'];
            $this->request->data['Event']['nombre_evento']              = $tipo_tarea[$data_event['tipo_tarea']];
            $this->request->data['Event']['fecha_inicio']               = $inicio;
            $this->request->data['Event']['inmueble_id']                = $data_event['inmueble_id'];
            $this->request->data['Event']['desarrollo_id']              = $data_event['desarrollo_id'];
            $this->request->data['Event']['recordatorio_1']             = $recordatorio;
            $this->request->data['Event']['tipo_evento']                = $data_event['tipo_evento']; // Evento manual
            $this->request->data['Event']['tipo_tarea']                 = $data_event['tipo_tarea'];
            $this->request->data['Event']['status']                     = $data_event['status_evento']; // Status del evento
            $this->request->data['Event']['cuenta_id']                  = $data_event['cuenta_id'];
            $this->request->data['Event']['opt_recordatorio_1']         = $data_event['recordatorio1'];
            $this->request->data['Event']['opt_recordatorio_2']         = $data_event['recordatorio2'];

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
                        $mensaje             = 'Cita creada para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio)).' en '.$interes_nombre;
                    break;
                    case 1: // 1=> Visita
                        $accionLogCliente    = 10;
                        $accionLogInmueble   = 7;
                        $accionLogDesarrollo = 7;
                        $mensaje             = 'Visita creada para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio)).' en '.$interes_nombre;
                    break;
                    case 2: // 2=>Llamada,
                        $accionLogCliente    = 4;
                        $accionLogInmueble   = 4;
                        $accionLogDesarrollo = 4;
                        $mensaje             = 'Llamada programada para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio));
                    break;
                    case 3: // 3=> Correo
                        $accionLogCliente    = 3;
                        $accionLogInmueble   = 5;
                        $accionLogDesarrollo = 5;
                        $mensaje             = 'Correo programado para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio));
                    break;
                    case 4: // 4=> Reactivacion
                        $accionLogCliente    = 9;
                        $accionLogInmueble   = 6;
                        $accionLogDesarrollo = 6;
                        $mensaje             = 'Reactivación automática para el día '.date("d/m/Y \a \l\a\s H:i",strtotime($inicio));
                    break;
                    default: // 0=> default
                        $accionLogCliente    = 2;
                        $accionLogInmueble   = 2;
                        $accionLogDesarrollo = 2;
                        $mensaje             = '';
                    break;
                }

                if( $data_event['inmueble_id'] != 0 ){

                    if( isset( $desarrollo_inmueble['DesarrolloInmueble'] ) ) {
                        
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
                    $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:m:i');;
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

                // if( $data_event['tipo_tarea'] == 0 OR $data_event['tipo_tarea'] == 1 ){
                    
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

                // Agregaremos el cambiar de etapa 2 a 3 de forma automcatica cuando se genera un evento de cita para el cliente.
                if( $data_event['tipo_tarea'] == 0){
                    $cliente = $this->Cliente->read(null,$data_event['cliente_id']);
                    
                    if( $cliente['Cliente']['etapa'] == 2 ){
                        $this->request->data['Cliente']['etapa']  = 3;
                            
                        $cliente_etapa = $this->LogClientesEtapa->find('first',
                            array(
                                'conditions' => array(
                                    'LogClientesEtapa.etapa'      => 2,
                                    'LogClientesEtapa.status'     => 'Activo',
                                    'LogClientesEtapa.cliente_id' => $data_event['cliente_id'],
                                )
                            )
                        );

                        if( !empty( $cliente_etapa ) ){
                            
                            // Pasamos la etapa 1 a desactivar.
                            $this->request->data['LogClientesEtapa']['id']     = $cliente_etapa['LogClientesEtapa']['id'];
                            $this->request->data['LogClientesEtapa']['status'] = 'Inactivo';
                            
                            if( $this->LogClientesEtapa->save($this->request->data) ){
                                
                                // Consultamos el log de clientes de la etapa 1, la desactivamos y registramos la numero 2
                                $this->LogClientesEtapa->create();
                                $this->request->data['LogClientesEtapa']['id']           = null;
                                $this->request->data['LogClientesEtapa']['cliente_id']   = $data_event['cliente_id'];
                                $this->request->data['LogClientesEtapa']['fecha']        = date('Y-m-d H:i:s');
                                $this->request->data['LogClientesEtapa']['etapa']        = 3;
                                $this->request->data['LogClientesEtapa']['desarrollo_id'] = $cliente_etapa['LogClientesEtapa']['desarrollo_id'];
                                $this->request->data['LogClientesEtapa']['inmuble_id']   = $cliente_etapa['LogClientesEtapa']['inmuble_id'];
                                $this->request->data['LogClientesEtapa']['status']       = 'Activo';
                                $this->request->data['LogClientesEtapa']['user_id']      = $data_event['user_id'];
                                $this->LogClientesEtapa->save($this->request->data);
            
                                //Registrar Seguimiento Rápido para el cambio de etapa automatico
                                $this->Agenda->create();
                                $this->request->data['Agenda']['user_id']    = $data_event['user_id'];
                                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                                $this->request->data['Agenda']['mensaje']    = "El cliente cambia automáticamente a etapa 3 por: Registro de una cita para el día ".date("d/m/Y \a \l\a\s H:i",strtotime($inicio))." en ".$interes_nombre;
                                $this->request->data['Agenda']['cliente_id'] = $data_event['cliente_id'];
                                $this->Agenda->save($this->request->data);
            
                            }
            
                            // Registrar ultimo seguimiento
                            $this->request->data['Cliente']['id']         = $data_event['cliente_id'];
                            $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                             //rogueEtapaFecha
                             $this->request->data['Cliente']['fecha_cambio_etapa'] =  date('Y-m-d');
                            $this->Cliente->save($this->request->data);

                        }
        
                    }
                }


                // }

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
        }
        if (  $data_event['tipo_tarea'] == 0)  {
            $this->loadModel('Mailconfig');
            $this->loadModel('User');
            $this->Mailconfig->Behaviors->load('Containable');
            $this->User->Behaviors->load('Containable');
            $cliente = $this->Cliente->read(null,$data_event['cliente_id']);
            $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
            //$cliente = $this->Cliente->read(null,$this->request->data['Agenda']['cliente_id']);
            $usuario = $this->User->read(null, $data_event['user_id']);
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
            $this->Email->template('emailclientecita','layoutinmomail');
            //$this->Email->template('emailaasesor','layoutinmomail');
            $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
            $this->Email->to($cliente['Cliente']['correo_electronico']);
            $this->Email->subject('Confirmación de Cita');
            $this->Email->viewVars(array('asesor'=>$usuario,'comentarios'=>'sincomentarios','cliente' => $cliente,'fecha'=>date("d/M/Y H:i:s")));
            $this->Email->send();
        }
        return $respuesta;
    }

    /**
    * esta funcion es para alimentar la grafica de 
    * citas canceladas, por los filtros de id de desarrollo, fechas y cuenta  
    * 
    */
    function  grafica_cita_cancelada(){
        header('Content-type: application/json; charset=utf-8');
        $this->Event->Behaviors->load('Containable');
        $fecha_ini         = '';
        $fecha_fin         = '';
        $and               = [];
        $or                = [];
        $cancelaciones_raw = [];
        $motivo_cancelacion=[];
        $condiciones =[];
        $desarrollo_id=0;
        $i=0;
        if ($this->request->is('post')) {
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
            if ($fi == $ff){
                $cond_rangos = array("Event.fecha_inicio LIKE '".$fi."%'");
                }else{
                $cond_rangos = array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
            }
            
            // Condicion para el desarrollo id.
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            $cancelacion= $this->Event->find('count',array(
                'conditions'=>array(   
                        'Event.motivo_cancelacion <>' => '',
                        'Event.desarrollo_id' =>$desarrollo_id,
                        $cond_rangos,
                    ),
                    'fields' => array(
                        'Event.motivo_cancelacion',
                    ),
                    'contain' => false 
                )
            );
            $cancelaciones_raw = $this->Desarrollo->query(
                "SELECT motivo_cancelacion, COUNT(*) AS sumatoria 
                FROM events
                WHERE  desarrollo_id IN ($desarrollo_id ) 
                AND motivo_cancelacion IS NOT NULL  
                AND fecha_inicio >= '$fi' 
                AND fecha_inicio <= '$ff' 
                AND status= 2  
                GROUP BY motivo_cancelacion
                "
            );
         
            foreach ($cancelaciones_raw as  $value) {
                $motivo_cancelacion[$i]['motivo']=$value['events']['motivo_cancelacion'];
                $motivo_cancelacion[$i]['cantidad']=$value[0]['sumatoria'];
                $i++;
            }
        }
        if (empty($motivo_cancelacion)) {
            $motivo_cancelacion[$i]['motivo']='sin informacion';
            $motivo_cancelacion[$i]['cantidad']=100;
        }
        echo json_encode( $motivo_cancelacion, true );
        $this->autoRender = false; 
    }

    /***
     * 
     * 
     * 
    */
    function card_periodo(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Lead');
        $this->Cliente->Behaviors->load('Containable');
        $this->Lead->Behaviors->load('Containable');
        $response=array();
        $desarrollo_id =0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if ($this->request->is('post')) {
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
            if ($fi == $ff){
                $cond_rangos_eventas = array("Event.fecha_inicio LIKE '".$fi."%'");
                $cond_rangos = array("Cliente.created '".$fi."%'");
                $cond_rangos_emails = array("LogDesarrollo.fecha '".$fi."%'");
                $cond_rangos_leads = array("Lead.fecha LIKE '".$fi."%'");


            }else{
                $cond_rangos_eventas = array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos_emails = array("LogDesarrollo.fecha BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));

            }
            // Condicion para el desarrollo id.
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            // $clientes=$this->Cliente->find('count',array(
            //     'conditions'=>array(
            //         'Cliente.desarrollo_id' =>$desarrollo_id,
            //         'Cliente.dic_linea_contacto_id <>'    => '',
            //         'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            //         'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
            //         'Cliente.user_id <>'    => '',
            //       $cond_rangos,
            //       ),
            //     )
            // );
            $leads=$this->Lead->find('count',array(
                'conditions'=>array(
                    'Lead..desarrollo_id' =>$desarrollo_id,
                    'Lead.dic_linea_contacto_id <>'    => '',
                    $cond_rangos_leads,
                  ), 
                'contain' => false 
                )
            );
            $citas=$this->Event->find('count',array(
                'conditions'=>array(   
                       
                        'Event.desarrollo_id' =>$desarrollo_id,
                        'Event.tipo_tarea' =>0,
                        $cond_rangos_eventas,
                    ), 
                )
            );
            $visitas=$this->Event->find('count',array(
                'conditions'=>array(   
                        'Event.desarrollo_id' =>$desarrollo_id,
                        'Event.tipo_tarea'      => 1,
                        $cond_rangos_eventas,
                    ),
                )
            );
            $emails=$this->LogDesarrollo->find('count',array(
                'conditions'=>array(
                    'LogDesarrollo.desarrollo_id'=>$desarrollo_id,
                    'LogDesarrollo.accion'=>5,
                    $cond_rangos_emails
                    )
                )
            );
        }
        
        // $leads=$this->Cliente->find('count',array(
        //     'conditions'=>array(
        //       'Cliente.desarrollo_id' =>$desarrollo_id,
        //       'Cliente.dic_linea_contacto_id <>'    => '',
        //       $cond_rangos,
        //       ),
        //     )
        // );
        // $citas=$this->Event->find('count',array(
        //     'conditions'=>array(   
        //             'Event.motivo_cancelacion <>' => '',
        //             'Event.desarrollo_id' =>$desarrollo_id,
        //             'Event.tipo_tarea' =>0,
        //             $cond_rangos_eventas,
        //         ), 
        //     )
        // );
        // $visitas=$this->Event->find('count',array(
        //     'conditions'=>array(   
        //             'Event.motivo_cancelacion <>' => '',
        //             'Event.desarrollo_id' =>$desarrollo_id,
        //             'Event.status'      => 1,
        //             'Event.tipo_evento' => 1,
        //             $cond_rangos_eventas,
        //         ),
        //     )
        // );
        // $visitas= $this->Event->query(
        //     "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
        //     FROM events, clientes,  dic_linea_contactos
        //     WHERE events.desarrollo_id = $desarrollo_id
        //     and events.cuenta_id = $cuenta_id
        //     AND clientes.id =  events.cliente_id
        //     AND events.tipo_tarea =1
        //     AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
        //     AND  events.fecha_inicio >= '$fi' 
        //     AND  events.fecha_inicio <= '$ff'"
        // );
        // $emails=$this->LogDesarrollo->find('count',array(
        //     'conditions'=>array(
        //         'LogDesarrollo.desarrollo_id'=>$desarrollo_id,
        //         'LogDesarrollo.accion'=>5,
        //         $cond_rangos_emails
        //         )
        //     )
        // )
        $response=array(
            '0' => array(
                'elemento'=>'leds',
                'cantidad'=>$leads
            ),
            '1' => array(
                'elemento'=>'citas',
                'cantidad'=>$citas
            ),
            '2' => array(
                'elemento'=>'visitas',
                'cantidad'=>$visitas
            ),
            '3' => array(
                'elemento'=>'emails',
                'cantidad'=>$emails
            )
        );
        echo json_encode( $response, true );
        $this->autoRender = false; 
    }
    /***
     * 
     * 
     * 
    */
    function card_historico(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Lead');
        $this->Lead->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $response=array();
        $desarrollo_id =0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if ($this->request->is('post')) {
            $fi='2000-01-01 00:00:00';
            $ff=date('Y-m-d H:i:s');   
            if ($fi == $ff){
                $cond_rangos_eventas = array("Event.fecha_inicio LIKE '".$fi."%'");
                $cond_rangos = array("Cliente.created '".$fi."%'");
                $cond_rangos_emails = array("LogDesarrollo.fecha '".$fi."%'");
                $cond_rangos_leads = array("Lead.fecha LIKE '".$fi."%'");

            }else{
                $cond_rangos_eventas = array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos_emails = array("LogDesarrollo.fecha BETWEEN ? AND ?" => array($fi, $ff));
                $cond_rangos_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
            }
            // Condicion para el desarrollo id.
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            // $clientes=$this->Cliente->find('count',array(
            //     'conditions'=>array(
            //       'Cliente.desarrollo_id' =>$desarrollo_id,
            //       'Cliente.dic_linea_contacto_id <>'    => '',
            //       'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            //       'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
            //       'Cliente.user_id <>'    => '',
            //       $cond_rangos,
            //       ),
            //     )
            // );
            $leads=$this->Lead->find('count',array(
                'conditions'=>array(
                    'Lead..desarrollo_id' =>$desarrollo_id,
                    'Lead.dic_linea_contacto_id <>'    => '',
                    $cond_rangos_leads,
                  ), 
                'contain' => false 
                )
            );
            $citas=$this->Event->find('count',array(
                'conditions'=>array(   
                        
                        'Event.desarrollo_id' =>$desarrollo_id,
                        'Event.tipo_tarea' =>0,
                        $cond_rangos_eventas,
                    ), 
                )
            );
            $visitas=$this->Event->find('count',array(
                'conditions'=>array(   
                        'Event.desarrollo_id' =>$desarrollo_id,
                        'Event.tipo_tarea'      => 1,
                        $cond_rangos_eventas,
                    ),
                )
            );
            $emails=$this->LogDesarrollo->find('count',array(
                'conditions'=>array(
                    'LogDesarrollo.desarrollo_id'=>$desarrollo_id,
                    'LogDesarrollo.accion'=>5,
                    $cond_rangos_emails
                    )
                )
            );
        }
        $response=array(
            '0' => array(
                'elemento'=>'leds',
                'cantidad'=>$leads
            ),
            '1' => array(
                'elemento'=>'citas',
                'cantidad'=>$citas
            ),
            '2' => array(
                'elemento'=>'visitas',
                'cantidad'=>$visitas
            ),
            '3' => array(
                'elemento'=>'emails',
                'cantidad'=>$emails
            ),
            '4' => array(
                'elemento'=>'fechas',
                'cantidad'=> [$fi='01-01-2000',$ff=date('d-m-Y')] 
            )
        );
        echo json_encode( $response, true );
        $this->autoRender = false;
    }
    /**
    * 
    * 
    * 
    */
    function citas_visitas_cancalaciones(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Event');
        $this->loadModel('DicLineaContacto');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $fecha_ini          = '';
        $fecha_fin          = '';
        $and                = [];
        $or                 = [];
        $cancelaciones_raw  = [];
        $motivo_cancelacion = [];
        $condiciones        = [];
        $citas              = [];
        $visitas            = [];
        $arreglo_a          = [];
        $desarrollo_id      = 0;
        $cuenta_id          = 0;
        $i= 0;
        $visita_algo=0;
        $visita_pase=0;
        $response=array();
        if ($this->request->is('post')) {
            $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){ 
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
                $ffc = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
                if ($fi == $ff){
                $cond_rangos = array("Event.fecha_inicio LIKE '".$fi."%'");
                }else{
                $cond_rangos = array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                }
                array_push($and, $cond_rangos);
                $vigente=date('Y-m-d H:i:s');   
                if ( date( 'Y-m-d', strtotime  ($ffc)) ==  date( 'Y-m-d', strtotime  ($vigente)) or $ff > $vigente) {
                    $ffc=$vigente;
                } 

            }
            
            // Condicion para el desarrollo id.
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
                array_push($and, array('Event.desarrollo_id' => $desarrollo_id ));
                $visitas= $this->Event->query(
                    "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita,clientes.dic_linea_contacto_id
                    FROM events, clientes,  dic_linea_contactos
                    WHERE events.desarrollo_id IN ($desarrollo_id) 
                    and events.cuenta_id = $cuenta_id
                    AND clientes.id =  events.cliente_id
                    AND events.tipo_tarea =1
                    AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                    AND  events.fecha_inicio >= '$fi' 
                    AND  events.fecha_inicio <= '$ff'
                    GROUP BY clientes.dic_linea_contacto_id;"
                );
                $citas= $this->Event->query(
                    "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas
                    FROM events, clientes,  dic_linea_contactos
                    WHERE events.desarrollo_id IN ($desarrollo_id) 
                    and events.cuenta_id = $cuenta_id
                    and events.status = 1
                    AND clientes.id =  events.cliente_id
                    AND events.tipo_tarea =0
                    AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                    AND  events.fecha_inicio >= '$fi' 
                    AND  events.fecha_inicio <= '$ffc';"
                );
                $citas_vigantes= $this->Event->query(
                    "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas
                    FROM events, clientes,  dic_linea_contactos
                    WHERE events.desarrollo_id IN ($desarrollo_id) 
                    and events.cuenta_id = $cuenta_id
                    AND clientes.id =  events.cliente_id
                    AND events.tipo_tarea =0
                    AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                    -- AND  events.fecha_inicio > '$fi' 
                    AND  events.fecha_inicio >'$vigente'
                    ;"
                );
                $nombre=$this->Desarrollo->find('first',array(
                    'conditions'=>array(
                        'Desarrollo.id'=>$desarrollo_id,        
                    ),
                    'fields'=>array(
                        'nombre',
                    ),
                    'contain'=>false
                ));
            }

            // Condicion para el asesor id.
            if( !empty( $this->request->data['user_id'] ) ){
                $user_id=$this->request->data['user_id'];
                array_push($and, array('Event.user_id' => $user_id ));
                $visitas= $this->Event->query(
                    "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita,clientes.dic_linea_contacto_id
                    FROM events, clientes,  dic_linea_contactos
                    WHERE events.user_id IN ($user_id) 
                    AND clientes.id =  events.cliente_id
                    AND events.tipo_tarea =1
                    AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                    AND  events.fecha_inicio >= '$fi' 
                    AND  events.fecha_inicio <= '$ff'
                    GROUP BY clientes.dic_linea_contacto_id;"
                );
                $citas= $this->Event->query(
                    "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas
                    FROM events, clientes,  dic_linea_contactos
                    WHERE events.user_id IN ($user_id) 
                    AND clientes.id =  events.cliente_id
                    AND events.tipo_tarea =0
                    AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                    AND  events.fecha_inicio >= '$fi' 
                    AND  events.fecha_inicio <= '$ff'
                    ;"
                );
                $citas_vigantes= $this->Event->query(
                    "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas
                    FROM events, clientes,  dic_linea_contactos
                    WHERE events.user_id IN ($user_id) 
                    AND clientes.id =  events.cliente_id
                    AND events.tipo_tarea =0
                    AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                    -- AND  events.fecha_inicio > '$fi' 
                    AND  events.fecha_inicio >='$vigente'
                    ;"
                );
            }
            $condiciones = array(
                'AND' => $and,
                'OR'  => $or
            );
            $cancelaciones_raw=$this->Event->find('count',array(
                'conditions'=>array(   
                'Event.tipo_tarea'=>0,
                'Event.status'=>2,
                $condiciones
                ),
                'contain' => false 
            ));
            $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
                'conditions'=>array(     
                'DicLineaContacto.cuenta_id' => $cuenta_id,
                'DicLineaContacto.linea_contacto LIKE' =>  "%showroom%",
        
                ),
                'fields' => array(
                'DicLineaContacto.id',
                'DicLineaContacto.linea_contacto',
                ),
                'contain' => false 
                )
            );
            foreach ($visitas as $visita) {
                foreach ($dic_linea_contacto as $value) {
                    if ($value['DicLineaContacto']['id']== $visita['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$value['DicLineaContacto']['linea_contacto'];
                        $arreglo[$i]['visitas']=$visita[0]['visita'];
                    }
                    else{
                        $visita_algo += $visita[0]['visita'];
                        $aunx=$visita;;
                    }
        
                }
                if ($dic_linea_contacto==null) {
                    $visita_algo += $visita[0]['visita'];
                }
                $i++;
            }
            $i=0; 
            foreach ($arreglo as $value) {
                $arreglo_a[$i]['medio']= $value['medio'];
                $arreglo_a[$i]['visitas']= $value['visitas'];
                $i++;
            }
        }  
        $i= 0;
        foreach ($nombre as $value) {
            $response[$i]['nombre']= $nombre['Desarrollo']['nombre'];
            $response[$i]['citas_canceladas']=  ( empty( $cancelaciones_raw ) ? 0  :   $cancelaciones_raw );
            $response[$i]['citas_vencidas']= ( empty(  $citas[0][0]['citas'] ) ? 0  :    $citas[0][0]['citas'] );
            $response[$i]['citas_vigantes']=( empty(  $citas_vigantes[0][0]['citas'] ) ? 0  :    $citas_vigantes[0][0]['citas'] );
            $response[$i]['visitas']= ( empty( $visita_algo ) ? 0  :   $visita_algo );
            $response[$i]['visitas_showRoom']= ( empty( $arreglo_a[0]['visitas'] ) ? 0  :   $arreglo_a[0]['visitas'] );
        } 
        if (empty($response)) {
            $response[$i]['medio']            = 'sin informacion';
            $response[$i]['citas_vencidas']   = 0;
            $response[$i]['citas_canceladas'] = 0;
            $response[$i]['citas_vigantes']   = 0;
            $response[$i]['visitas']          = 0;
            $response[$i]['visitas_showRoom'] = 0;
            
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
    function medio_citas_visitas(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Event');
        $this->loadModel('DicLineaContacto');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $fecha_ini          = '';
        $fecha_fin          = '';
        $and                = [];
        $or                 = [];
        $cancelaciones_raw  = [];
        $motivo_cancelacion = [];
        $condiciones        = [];
        $citas              = [];
        $visitas            = [];
        $arreglo_a          = [];
        $desarrollo_id      = 0;
        $cuenta_id          = 0;
        $i= 0;
        $visita_algo=0;
        $visita_pase=0;
        $response=array();
        $medios_id ='';
        $desarrollos_id ='';
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        // AND clientes.dic_linea_contacto_id IN ($medios_id) 
        if ($this->request->is('post')) {
            // $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){ 
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
                $ffc = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
                $vigente=date('Y-m-d H:i:s');   
                if ( date( 'Y-m-d', strtotime  ($ffc)) ==  date( 'Y-m-d', strtotime  ($vigente)) or $ff > $vigente) {
                    $ffc=$vigente;
                }
            }
            
            // Condicion para el desarrollo id.
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
            if( !empty( $this->request->data['medio_id'] ) ){
                foreach($this->request->data['medio_id'] as $medio){
                  $medios_id = $medios_id.$medio.",";
                } 
                $medios_id = substr($medios_id,0,-1);
            }
            $cancelaciones=$this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas_cancelada,clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND events.tipo_tarea =0
                AND events.status =2
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio <= '$ff'
                GROUP BY clientes.dic_linea_contacto_id"   
            );
            $citas_vigantes= $this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas_vigentes,clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND events.tipo_tarea =0
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND  events.fecha_inicio >'$vigente'
                GROUP BY clientes.dic_linea_contacto_id
                ;"
            );
            $citas_totales= $this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas, clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollo_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND events.tipo_tarea =0
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio < '$vigente'
                GROUP BY clientes.dic_linea_contacto_id;"
            );

            $citas= $this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS citas, clientes.dic_linea_contacto_id
                FROM events, clientes
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND events.tipo_tarea =0
                and events.status = 1
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio <= '$ffc'
                GROUP BY clientes.dic_linea_contacto_id;"
            );

            $visitas= $this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
                ,clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND dic_linea_contactos.id IN ($medios_id)
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND events.tipo_tarea =1
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio <= '$ff'
                GROUP BY clientes.dic_linea_contacto_id;"
            );

            $dic_linea_contacto=$this->DicLineaContacto->find('all',array(
              'conditions'=>array(     
                'DicLineaContacto.cuenta_id' => $cuenta_id,
                // 'DicLineaContacto.linea_contacto LIKE' =>  "%showroom%",
    
              ),
              'fields' => array(
                'DicLineaContacto.id',
                'DicLineaContacto.linea_contacto',
              ),
              'contain' => false 
              )
            );

            foreach ($dic_linea_contacto as $linea) {
                foreach ($citas as $cita) {
                    if ( $linea['DicLineaContacto']['id'] == $cita['clientes']['dic_linea_contacto_id'] ) {
    
                        $citas_visitas_medio[$i]['medio']            = $linea['DicLineaContacto']['linea_contacto'];
                        $citas_visitas_medio[$i]['citas']            = $cita[0]['citas'];
                        $citas_visitas_medio[$i]['citas_vigentes']   = 0;
                        $citas_visitas_medio[$i]['citas_canceladas'] = 0;
                        $citas_visitas_medio[$i]['visitas']          = 0;
                        $citas_visitas_medio[$i]['citas_totales']          = 0;
                    }
                }
                foreach ($citas_vigantes as $vigante) {
                    if ( $linea['DicLineaContacto']['id'] == $vigante['clientes']['dic_linea_contacto_id'] ) {
                        $citas_visitas_medio[$i]['medio'] = $linea['DicLineaContacto']['linea_contacto'];
                        if ( $citas_visitas_medio[$i]['citas'] == 0 ) {
                            $citas_visitas_medio[$i]['citas'] = 0; 
                        }
                        $citas_visitas_medio[$i]['citas_vigentes'] = $vigante[0]['citas_vigentes'];
    
                    }
                }
                foreach ($cancelaciones as  $cancelacion) {
                    if ( $linea['DicLineaContacto']['id'] == $cancelacion['clientes']['dic_linea_contacto_id'] ) {
    
                        $citas_visitas_medio[$i]['medio'] = $linea['DicLineaContacto']['linea_contacto'];
                        if ( $citas_visitas_medio[$i]['citas'] == 0 ) {
                            $citas_visitas_medio[$i]['citas'] = 0; 
                        }
                        if ( $citas_visitas_medio[$i]['citas_vigentes'] == 0 ) {
                            $citas_visitas_medio[$i]['citas_vigentes'] = 0; 
                        }
                        $citas_visitas_medio[$i]['citas_canceladas'] = $cancelacion[0]['citas_cancelada'];
    
                    }        
                }
                foreach ($visitas as $visita) {
    
                    if ( $linea['DicLineaContacto']['id'] == $visita['clientes']['dic_linea_contacto_id'] ) {
    
                        $citas_visitas_medio[$i]['medio'] = $linea['DicLineaContacto']['linea_contacto'];
                        if ( $citas_visitas_medio[$i]['citas'] == 0 ) {
                            $citas_visitas_medio[$i]['citas'] = 0; 
                        }
                        if ( $citas_visitas_medio[$i]['citas_vigentes'] == 0 ) {
                            $citas_visitas_medio[$i]['citas_vigentes'] = 0; 
                        }
                        if ( $citas_visitas_medio[$i]['citas_canceladas'] == 0 ) {
                            $citas_visitas_medio[$i]['citas_canceladas'] = 0; 
                        }
                        $citas_visitas_medio[$i]['visitas'] =  $visita[0]['visita'];
                    }
                    
                }
                foreach ($citas_totales as  $totale) {
                    if ( $linea['DicLineaContacto']['id'] == $totale['clientes']['dic_linea_contacto_id'] ) {
                        $citas_visitas_medio[$i]['medio'] = $linea['DicLineaContacto']['linea_contacto'];
                        if ( $citas_visitas_medio[$i]['citas'] == 0 ) {
                            $citas_visitas_medio[$i]['citas'] = 0; 
                        }
                        if ( $citas_visitas_medio[$i]['citas_vigentes'] == 0 ) {
                            $citas_visitas_medio[$i]['citas_vigentes'] = 0; 
                        }
                        if ( $citas_visitas_medio[$i]['citas_canceladas'] == 0 ) {
                            $citas_visitas_medio[$i]['citas_canceladas'] = 0; 
                        }
                        if ( $citas_visitas_medio[$i]['visitas'] == 0 ) {
                            $citas_visitas_medio[$i]['visitas'] = 0; 
                        }
                        $citas_visitas_medio[$i]['citas_totales'] =  $totale[0]['citas'];

                    }
                }
                $i++;
            }
            $i=0;
            foreach ($citas_visitas_medio as $value) {
                
                $response[$i]['medio']            = $value['medio'];
                $response[$i]['citas']            = ( empty(  $value['citas'] ) ? 0           : $value['citas'] );
                $response[$i]['citas_vigentes']   = ( empty(  $value['citas_vigentes'] ) ? 0  : $value['citas_vigentes'] );
                $response[$i]['citas_canceladas'] = ( empty(  $value['citas_canceladas'] ) ? 0: $value['citas_canceladas'] );
                $response[$i]['visitas']          = ( empty(  $value['visitas'] ) ? 0  :    $value['visitas'] );
                $response[$i]['citas_totales']    = ( empty(  $value['citas_totales'] ) ? 0  :    $value['citas_totales'] );
                $i++;
    
            }
        }
        if (empty($response)) {

            $response[$i]['medio']            = 'sin informacion';
            $response[$i]['citas']            = 0;
            $response[$i]['citas_canceladas'] = 0;
            $response[$i]['citas_vigantes']   = 0;
            $response[$i]['visitas']          = 0;
            $response[$i]['citas_totales']          = 0;
            
        }
        echo json_encode( $response, true );
        exit();
        $this->autoRender = false;
    }

    /* -------------------------------------------------------------------------- */
    /*                  Metodo para correccion de desarrollos_id                  */
    /* -------------------------------------------------------------------------- */
    function correcion_inmuebles_events(){
        $this->Event->Behaviors->load('Containable');
        
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        // $cuenta_id = 178;

        // Query para traer los id de inmueble que No tiene desarrollo_id
        $inmuebles_ids = $this->Event->find('all', array(
            'conditions' => array(
                'Event.desarrollo_id' => 0,
                'Event.tipo_tarea'    => 1,
                'Event.cuenta_id'     => $cuenta_id,
            ),
            'fields' => array(
                'Event.id',
                'Event.inmueble_id',

            ),
            'contain' => false
        ));

        $i = 0;
        foreach( $inmuebles_ids as $inmueble_id ){

            // Voy a buscar si el id del inmueble pertence a un id de desarrollo.
            // Si tiene pertenece a un desarrollo, agrego el id del desarrollo al registro de evento.
            // Si no pertenece a ningun desarrollo, lo dejamos en 0

            $desarrollo_id = $this->DesarrolloInmueble->find('first', array(
                'conditions' => array(
                    'DesarrolloInmueble.inmueble_id' => $inmueble_id['Event']['inmueble_id']
                ),
                'fields' => array(
                    'DesarrolloInmueble.desarrollo_id'
                )
            ));


            if( !empty( $desarrollo_id ) ){
                
                // Aqui tenemos que hacer la actualizacion del evento
                $this->request->data['Event']['id']         = $inmueble_id['Event']['id'];
                $this->request->data['Event']['desarrollo_id'] = $desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
                if($this->Event->save($this->request->data)){
                    $i++;
                    echo $i.".- Yehi...!! lo guardamos <br>";
                }else{
                    echo "Nel, no guardamos raza ERROR id_inmueble = ".$inmueble_id['Event']['inmueble_id']." <br>";
                }

            }else{
                echo "No hay nada que actualizar.... <br>";
            }

        }
        
        echo "<pre>";
            echo print_r( $inmuebles_ids );
        echo "</pre>";

        $this->autoRender = false;

    }

    /**
     * Aka - RogueOne
     * Fecha: 19/Dic/2022
     * en esta función se consulta por desarrollo(s) las razonas de cancelacion de las citas es para el reporte de medios de promación 
    */
    function motivio_cancelacion_mk(){
        header('Content-type: application/json; charset=utf-8');
        $this->Event->Behaviors->load('Containable');
        $fecha_ini          = '';
        $fecha_fin          = '';
        $desarrollos_id     = '';
        $medios_id          = '';
        $and                = [];
        $or                 = [];
        $cuenta_id          = 0;
        $i= 0;
        $response=array();
        if ($this->request->is('post')) {
            $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                  $cond_rangos = array("Event.fecha_inicio LIKE '".$fi."%'");
        
                }else{
                  $cond_rangos = array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
        
                } 
            }
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
            $cancelaciones_ro= $this->Event->find('all',
                array(      
                    'conditions'=>array(
                        'Event.desarrollo_id IN ('.$desarrollos_id.')',
                        'Event.tipo_tarea'=>0,
                        'Event.status'=>2,
                        $cond_rangos
                    ),
                    'fields'=>array(
                        'motivo_cancelacion',
                        'COUNT(Event.motivo_cancelacion) as motivo',
                    ),
                    'group'   =>'Event.motivo_cancelacion',

                    'contain'=>false
                )
            ); 
            foreach ($cancelaciones_ro as  $value) {
                $response[$i]['motivo']=$value['Event']['motivo_cancelacion'];
                $response[$i]['cantidad']=$value[0]['motivo'];
                $i++;
            }
        }
        $i=0;
        if (empty($response)) {
            $response[$i]['motivo']='sin informacion'; 
            $response[$i]['cantidad']= 0; 
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
    function citas_cancelacion_grupo(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('User');
        $this->Event->Behaviors->load('Containable');
        $this->User->Behaviors->load('Containable');
        $fecha_ini         = '';
        $fecha_fin         = '';
        $response               = [];
        $and               = [];
        $or                = [];
        $cancelaciones_raw = [];
        $motivo_cancelacion=[];
        $condiciones =[];
        $user_id=0;
        $i=0;
        if ($this->request->is('post')) {
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));    
            if ($fi == $ff){
                $cond_rangos = array("Event.fecha_inicio LIKE '".$fi."%'");
                }else{
                $cond_rangos = array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
            }
            foreach ($this->request->data['user_id'] as $user){
                $user_id = $user_id.$user.",";
            }
            $user_id = substr($user_id,0,-1);
            $cancelaciones_raw= $this->Event->find('all',array(
                'conditions'=>array(   
                        'Event.motivo_cancelacion <>' => '',
                        'Event.status' =>  2,
                        'Event.tipo_tarea' => 0,
                        'Event.user_id IN ('.$user_id.')',
                        $cond_rangos,
                    ),
                    'fields' => array(
                        'Event.motivo_cancelacion',
                        'COUNT(Event.motivo_cancelacion) as motivo',
                    ),
                    'group' =>'Event.motivo_cancelacion',
                    'contain' => false 
                )
            );
            foreach ($cancelaciones_raw as $value) {
                $response[$i]['cantidad']=$value[0]['motivo'];
                $response[$i]['motivo']=$value['Event']['motivo_cancelacion'];
                $i++;
            }
        }
        echo json_encode( $response, true );
        exit();
        $this->autoRender = false;
    }


}
?>
