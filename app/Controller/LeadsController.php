<?php
App::uses('AppController', 'Controller');
/**
 * Leads Controller
 *
 * @property Lead $Lead
 * @property PaginatorComponent $Paginator
 */
class LeadsController extends AppController {

/**
 * Components
 *
 * @var array
 * 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogInmueble
 * 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogDesarrollo
 */
	public $components = array('Paginator');
	public $uses = array('Lead','Inmueble','Cliente','User','Desarrollo','LogInmueble','LogDesarrollo','LogCliente','Agenda','Mailconfig', 'Cuenta',
    'Paramconfig', 'DesarrolloInmueble', 'LogClientesEtapa');
        
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
            $this->Auth->allow('homodic','get_options_desarrollos','get_options_inmuebles', 'set_add_inmueble', 'set_add_desarrollo_all', 'get_add_inmueble', 'asignacion_lead', 'inmueble_asig');
    }
    /**
     * index method
     *
     * @return void
     */
	public function index() {
		$this->Lead->recursive = 0;
		$this->set('leads', $this->Paginator->paginate());
	}

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function view($id = null) {
		if (!$this->Lead->exists($id)) {
			throw new NotFoundException(__('Invalid lead'));
		}
		$options = array('conditions' => array('Lead.' . $this->Lead->primaryKey => $id));
		$this->set('lead', $this->Lead->find('first', $options));
	}

    /**
     * add method
     *
     * @return void
     */
	public function add() {
		if ($this->request->is('post')) {
                        
            $this->loadModel('Paramconfig');
            $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));
			$condiciones = array('liberada'=>1);
                        
                        if (isset($this->request->data['Lead']['desarrollo_id'])){
                            $desarrollo = $this->Desarrollo->read(null,$this->request->data['Lead']['desarrollo_id']);
                            $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);
                            $usuario = $this->User->read(null,$cliente['Cliente']['user_id']);
                            $existe = $this->Lead->find('first',array('conditions'=>array(
                                'Lead.desarrollo_id'=>$this->request->data['Lead']['desarrollo_id'],
                                'Lead.cliente_id'=>$this->request->data['Lead']['cliente_id']
                                    )));
                            if (empty($existe)){
                                $this->request->data['Lead']['status']="Abierto";
                                $this->Lead->create();
                                $this->Lead->save($this->request->data);
                                $this->LogCliente->create();
                                $this->request->data['LogCliente']['id']=  uniqid();
                                $this->request->data['LogCliente']['cliente_id']=$this->request->data['Lead']['cliente_id'];
                                $this->request->data['LogCliente']['user_id']=$this->Session->read('Auth.User.id');
                                $this->request->data['LogCliente']['mensaje']="Generación de Lead";
                                $this->request->data['LogCliente']['accion']=7;
                                $this->request->data['LogCliente']['datetime']=date('Y-m-d h:i:s');
                                $this->LogCliente->save($this->request->data);


                            }
                            
                            $this->Email = new CakeEmail();
                            $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
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
                                $this->Email->cc($arreglo_emails2);
                            }
                            $this->Email->to($cliente['Cliente']['correo_electronico']);
                            $this->Email->subject('Propiedades que te pueden interesar BOS Inmobiliaria');
                            $this->Email->config(array(
                                        'host' => $mailconfig['Mailconfig']['smtp'],
                                        'port' => $mailconfig['Mailconfig']['puerto'],
                                        'username' => $mailconfig['Mailconfig']['usuario'],
                                        'password' => $mailconfig['Mailconfig']['password'],
                                        'transport' => 'Smtp'
                                        )
                                    );
                            $this->Email->emailFormat('html');
                            
                            // $this->Email->viewVars(array('cliente' => $cliente,'desarrollos'=>$desarrollo, 'usuario'=>$usuario));
                            $this->Email->viewVars(array('cliente' => $cliente, 'desarrollos'=>$desarrollo,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_new_client'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                            
                            $this->Email->template('emailacliente','layoutinmomail');
                            $this->Email->send();
                            $this->Session->setFlash(__('Se ha creado la asignación de propiedades para el cliente'),'default',array('class'=>'success'));
                            return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                            
                            $this->request->data['LogDesarrollo']['desarrollo_id'] = $this->request->data['Lead']['desarrollo_id'];
                            $this->request->data['LogDesarrollo']['mensaje'] = "Asignación a cliente: ".$cliente['Cliente']['nombre'];
                            $this->request->data['LogDesarrollo']['usuario_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['LogDesarrollo']['fecha'] = date('Y-m-d');
                            $this->request->data['LogDesarrollo']['accion'] = 8;
                            $this->LogDesarrollo->create();
                            $this->LogDesarrollo->save($this->request->data);
                        }else{
                            // $condiciones = array('Inmueble.liberada' => 1, 'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.Cuenta.id'), 'Inmueble.id NOT IN' => '(Select inmueble_id FROM desarrollo_inmuebles)');

                            $condiciones = array('Inmueble.liberada'=>1,'Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'), 'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)');

                            if (!empty($this->request->data['Lead']['tipo_propiedad'])) array_push($condiciones, array('dic_tipo_propiedad_id'=>$this->request->data['Lead']['tipo_propiedad']));  
                            if (!empty($this->request->data['Lead']['venta_renta'])) array_push($condiciones, array('venta_renta'=>$this->request->data['Lead']['venta_renta']));
                            if (!empty($this->request->data['Lead']['colonia'])) array_push($condiciones, array('colonia LIKE' => '%'.$this->request->data['Lead']['colonia'].'%' ));
                            if (!empty($this->request->data['Lead']['delegacion'])) array_push($condiciones, array('delegacion'=> '%'.$this->request->data['Lead']['delegacion'].'%'));
                            if (!empty($this->request->data['Lead']['ciudad'])) array_push($condiciones, array('ciudad'=> '%'.$this->request->data['Lead']['ciudad'].'%'));
                            if (!empty($this->request->data['Lead']['estado_ubicacion'])) array_push($condiciones, array('estado_ubicacion'=>'%'.$this->request->data['Lead']['estado_ubicacion'].'%'));
                            if (!empty($this->request->data['Lead']['precio_min'])) array_push($condiciones, array('precio >='=>$this->request->data['Lead']['precio_min']));
                            if (!empty($this->request->data['Lead']['precio_max'])) array_push($condiciones, array('precio <='=>$this->request->data['Lead']['precio_max']));
                            if (!empty($this->request->data['Lead']['edad_min'])) array_push($condiciones, array('edad >='=>$this->request->data['Lead']['edad_min']));
                            if (!empty($this->request->data['Lead']['edad_max'])) array_push($condiciones, array('edad <='=>$this->request->data['Lead']['edad_max']));
                            if (!empty($this->request->data['Lead']['terreno'])) array_push($condiciones, array('terreno'=>$this->request->data['Lead']['terreno']));
                            if (!empty($this->request->data['Lead']['construccion_min'])) array_push($condiciones, array('construccion >='=>$this->request->data['Lead']['construccion_min']));
                            if (!empty($this->request->data['Lead']['construccion_max'])) array_push($condiciones, array('construccion <='=>$this->request->data['Lead']['construccion_max']));
                            if (!empty($this->request->data['Lead']['recamaras'])) array_push($condiciones, array('recamaras >='=>$this->request->data['Lead']['recamaras']));
                            if (!empty($this->request->data['Lead']['banos'])) array_push($condiciones, array('banos >='=>$this->request->data['Lead']['banos']));
                            if (!empty($this->request->data['Lead']['estacionamiento_descubierto'])) array_push($condiciones, array('estacionamiento_descubierto >='=>$this->request->data['Lead']['estacionamiento_descubierto']));

                            $this->set('propiedades',$this->Inmueble->find('all',array('conditions'=>$condiciones,'order'=>'precio ASC')));
                            
                            
                        }
                        $this->set('cliente_id',$this->request->data['Lead']['cliente_id']);
			//$this->Inmueble->find('all',array('conditions'=>$condiciones));
		}
		
	}
	
    /**
     * Se cambia el body message del correo. AKA SaaK 03/ene/2023
    */
	public function asignar(){
        $this->Inmueble->Behaviors->load('Containable');

		$this->layout = 'bos';
		if ($this->request->is('post')) {
            //echo var_dump($this->request->data['Lead']);
            $this->loadModel('Mailconfig');
            $this->loadModel('Paramconfig');
            $arreglo="";
            $arreglo_desarrollos="";
            $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);

            for($i=1;$i<$this->request->data['Lead']['contador'];$i++){

                // Titulo de la propiedad.
                $inmueble = $this->Inmueble->find('first',
                    array(
                        'conditions' => array( 'id' => $this->request->data['Lead']['inmueble_id'.$i] ),
                        'fields'     => array('titulo'),
                        'contain'    => false
                    )
                );
                
                if (isset($this->request->data['Lead']['seleccionar'.$i])&&$this->request->data['Lead']['seleccionar'.$i]==1){
                    
                    if (isset($this->request->data['Lead']['inmueble_id'.$i])){
                        $arreglo = $arreglo.$this->request->data['Lead']['inmueble_id'.$i].",";
                        $this->request->data['Lead']['inmueble_id']        = $this->request->data['Lead']['inmueble_id'.$i];
                        $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Lead']['inmueble_id'];
                        $this->request->data['LogInmueble']['mensaje']     = "Asignación a cliente:". $cliente['Cliente']['nombre'];
                        $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
                        $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
                        $this->request->data['LogInmueble']['accion']      = 9;
                        $this->LogInmueble->create();
                        $this->LogInmueble->save($this->request->data);
                    }

                    $existe = $this->Lead->find('first',array('conditions'=>array(
                        'Lead.inmueble_id' => $this->request->data['Lead']['inmueble_id'],
                        'Lead.cliente_id'  => $this->request->data['Lead']['cliente_id']
                    )));

                    if (empty($existe)){
                        $this->Lead->create();
                        $this->Lead->save($this->request->data);


                        $this->LogCliente->create();
                        $this->request->data['LogCliente']['id']         =  uniqid();
                        $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Lead']['cliente_id'];
                        $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['LogCliente']['mensaje']    = "Generación de Lead";
                        $this->request->data['LogCliente']['accion']     = 7;
                        $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                        $this->LogCliente->save($this->request->data);


                    }
                                        
                    //Registrar Seguimiento Rápido
                    $this->Agenda->create();
                    $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                    $this->request->data['Agenda']['mensaje']    = "Envío de propiedad ".$inmueble['Inmueble']['titulo'];
                    $this->request->data['Agenda']['cliente_id'] = $this->request->data['Lead']['cliente_id'];
                    $this->Agenda->save($this->request->data);


                    // Se agregara el cambio de etapa automatico.
                    // Pasa a etapa 3 si el viene de la etapa 2.
                    // Si esta en una etapa superior a 2, no avanza de etapa, se queda donde esta.
                    
                    if( $cliente['Cliente']['etapa'] == 2 ){
                        $this->request->data['Cliente']['etapa']  = 3;

                        $cliente_etapa = $this->LogClientesEtapa->find('first',
                            array(
                                'conditions' => array(
                                    'LogClientesEtapa.etapa'      => 2,
                                    'LogClientesEtapa.status'     => 'Activo',
                                    'LogClientesEtapa.cliente_id' => $this->request->data['Lead']['cliente_id'],
                                )
                            )
                        );

                        // Si existe el registro de la etapa 2 la pasamos a la etapa 3
                        if( !empty($cliente_etapa) ){
                            // Pasamos la etapa 1 a desactivar.
                            $this->request->data['LogClientesEtapa']['id']     = $cliente_etapa['LogClientesEtapa']['id'];
                            $this->request->data['LogClientesEtapa']['status'] = 'Inactivo';
    
                            if( $this->LogClientesEtapa->save($this->request->data) ){
                                
                                // Consultamos el log de clientes de la etapa 1, la desactivamos y registramos la numero 2
                                $this->LogClientesEtapa->create();
                                $this->request->data['LogClientesEtapa']['id']           = null;
                                $this->request->data['LogClientesEtapa']['cliente_id']   = $this->request->data['Lead']['cliente_id'];
                                $this->request->data['LogClientesEtapa']['fecha']        = date('Y-m-d H:i:s');
                                $this->request->data['LogClientesEtapa']['etapa']        = 3;
                                $this->request->data['LogClientesEtapa']['desarrollo_id'] = $cliente_etapa['LogClientesEtapa']['desarrollo_id'];
                                $this->request->data['LogClientesEtapa']['inmuble_id']   = $cliente_etapa['LogClientesEtapa']['inmuble_id'];
                                $this->request->data['LogClientesEtapa']['status']       = 'Activo';
                                $this->request->data['LogClientesEtapa']['user_id']      = $this->Session->read('Auth.User.id');
                                $this->LogClientesEtapa->save($this->request->data);
    
                                //Registrar Seguimiento Rápido para el cambio de etapa automatico
                                $this->Agenda->create();
                                $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                                
                                // $this->request->data['Agenda']['mensaje']    = "Se envía la propiedad ".$inmueble['Inmueble']['titulo'].", generando el cambio automático a la etapa 3 ";
                                
                                $this->request->data['Agenda']['mensaje']    = "El cliente cambia automáticamente a etapa 3 por: Envío de ".$inmueble['Inmueble']['titulo']." el ".date("d/m/Y \a \l\a\s H:i");

                                

                                $this->request->data['Agenda']['cliente_id'] = $this->request->data['Lead']['cliente_id'];
                                $this->Agenda->save($this->request->data);
    
                            }
                        }

                    }

                    // Registrar ultimo seguimiento
                    $this->request->data['Cliente']['id']         = $this->request->data['Lead']['cliente_id'];
                    $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                    //rogueEtapaFecha
                    $this->request->data['Cliente']['fecha_cambio_etapa'] = date('Y-m-d');
                    $this->Cliente->save($this->request->data);



				}
                

			}
                        
            $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);
            $usuario = $this->User->read(null,$cliente['Cliente']['user_id']);
            
            if ($arreglo!="" || $arreglo_desarrollos!=""){
                $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id IN (".  substr($arreglo,0, -1).")")));

                $this->Lead->query("UPDATE clientes SET last_edit = NOW() WHERE id = ".$this->request->data['Lead']['cliente_id']);
                $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));
                if ($cliente['Cliente']['correo_electronico'] != 'Sin correo'){
                    $this->Email = new CakeEmail();
                    $this->Email->config(array(
                                    'host'      => $mailconfig['Mailconfig']['smtp'],
                                    'port'      => $mailconfig['Mailconfig']['puerto'],
                                    'username'  => $mailconfig['Mailconfig']['usuario'],
                                    'password'  => $mailconfig['Mailconfig']['password'],
                                    'transport' => 'Smtp'
                                    )
                                );
                    if ($paramconfig['Paramconfig']['cc_a_c']!=""){
                        $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                        $arreglo_emails2 = array();
                        if (sizeof($emails2)>0){
                            foreach($emails2 as $email):
                                $arreglo_emails2[$email] = $email;
                            endforeach;
                        }else{
                            $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                        }
                        $this->Email->cc($arreglo_emails2);
                    }
                    $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->subject($paramconfig['Paramconfig']['smessage_new_propiedad']);
                    $this->Email->emailFormat('html');
                    
                    if (isset($desarrollos)){
                        $this->Email->viewVars(array('cliente' => $cliente, 'desarrollos'=>$desarrollo,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_seg_cliente_inmuebles'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                    }
                    if (isset($propiedades)){
                        $this->Email->viewVars(array('cliente' => $cliente, 'propiedades'=>$propiedades,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_seg_cliente_inmuebles'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                    }


                    $this->Email->template('emailacliente','layoutinmomail');
                    $this->Email->send();

                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         = uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['mensaje']    = "Envío de propiedad";
                    $this->request->data['LogCliente']['accion']     = 3;
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);

                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Se ha asignado exitosamente la(s) propiedad(es).', 'default', array(), 'm_success');
                    return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                }else{
                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Se ha asignado correctamente la propiedad/unidad, sin embargo el cliente NO recibirá notificación, porque no cuenta con correo electrónico registrado.', 'default', array(), 'm_success');
                    return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                }

            }else{
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Es necesario seleccionar una propiedad.', 'default', array(), 'm_success');
                return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
            }
            
		}
	}
    
    /**
     * Se cambia el body message del correo. AKA SaaK 03/ene/2023
    */
    public function add_desarrollo(){
        date_default_timezone_set('America/Chihuahua');
        //$this->layout = 'bos';
        $this->loadModel('Inmueble');
        $this->loadModel('Cliente');
        $this->loadModel('Desarrollo');
        $this->loadModel('Mailconfig');
        $this->loadModel('Paramconfig');
        $this->loadModel('User');
        $this->loadModel('Agenda');
        $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));

        if ($this->request->is('post')) {
            $desarrollo_id = $this->request->data['Lead']['desarrollo_id'];

            if ($this->request->data['Lead']['all'] == 1 ){
                $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);
                $desarrollos = $this->Desarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$desarrollo_id)));
                $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                $usuario = $this->User->read(null,$this->Session->read('Auth.User.id'));
                $asesor = $this->User->read(null,$cliente['User']['id']);

                // Registrar ultimo seguimiento
                $this->request->data['Cliente']['id']         = $this->request->data['Lead']['cliente_id'];
                $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                $this->Cliente->save($this->request->data);

                
                $lead_existe = $this->Lead->find('first',array('conditions'=>array('Lead.desarrollo_id'=>$desarrollo_id,'Lead.cliente_id'=>$cliente['Cliente']['id'])));
                if (empty($lead_existe)){
                    $this->request->data['Lead']['cliente_id'] = $cliente['Cliente']['id'];
                    $this->request->data['Lead']['status'] = "Abierto";
                    $this->request->data['Lead']['desarrollo_id'] = $desarrollo_id;
                    $this->Lead->save($this->request->data);
                }
                
                //Registrar Seguimiento Rápido
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']=$this->Session->read('Auth.User.id');
                $this->request->data['Agenda']['fecha']=date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']="Se envía Desarrollo ".$desarrollos[0]['Desarrollo']['nombre'];
                $this->request->data['Agenda']['cliente_id']=$cliente['Cliente']['id'];
                $this->Agenda->save($this->request->data);

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
                    if ($desarrollos[0]['Desarrollo']['brochure']!=""){
                        $this->Email->attachments(getcwd().$desarrollos[0]['Desarrollo']['brochure']);
                                    
                    }
                    
                    if ($paramconfig['Paramconfig']['cc_a_c']!=""){
                        $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                        $arreglo_emails2 = array();
                        if (sizeof($emails2)>0){
                            foreach($emails2 as $email):
                                $arreglo_emails2[$email] = $email;
                            endforeach;
                        }else{
                            $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                        }
                        $this->Email->cc($arreglo_emails2);
                    }
                    
                    $this->Email->from(array($cliente['User']['correo_electronico'] => $cliente['User']['nombre_completo']));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->subject($paramconfig['Paramconfig']['smessage_new_desarrollo']);
                    $this->Email->emailFormat('html');                       
                    $this->Email->viewVars(array('cliente' => $cliente, 'desarrollos'=>$desarrollos,'usuario'=>$asesor,'body_message'=> $paramconfig['Paramconfig']['bmessage_seg_cliente_desarrollo'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                    
                    
                    $this->Email->template('emailacliente','layoutinmomail');
                    $this->Email->send();

                    // Creación de log cliente del envio de un correo - "SaaK" 03/06/2019
                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         = uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['mensaje']    = "Envío de desarrollo";
                    $this->request->data['LogCliente']['accion']     = 3;
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);


                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Se ha enviado un desarrollo al cliente.', 'default', array(), 'm_success');
                }else{
                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Se ha asignado correctamente la propiedad/unidad, sin embargo el cliente NO recibirá notificación, porque no cuenta con correo electrónico registrado.', 'default', array(), 'm_success');
                }
                return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
            }else{
                //echo var_dump($this->request->data['Lead']);
                if ($this->Session->read('Permisos.Group.id')==1) {
                    $this->set('propiedades',$this->Inmueble->find('all',array('order'=>'Inmueble.referencia ASC','conditions'=>array("Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)"))));
                }else{
                    $this->set('propiedades',$this->Inmueble->find('all',array('order'=>'Inmueble.referencia ASC','conditions'=>array("Inmueble.liberada"=>1, "Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)"))));
                }
                $this->set('cliente_id',$this->request->data['Lead']['cliente_id']);
            }
        }
        
        $status_inmueble = array(
            0 => 'No liberada',
            1 => 'Libre',
            2 => 'Reserva',
            3 => 'Contrato',
            4 => 'Escrituacion',
            5 => 'Baja'
        );

        $this->set(compact('status_inmueble'));
            
    }
        
    public function enviar($cliente_id = null){
        $this->loadModel('Paramconfig');
        $this->loadModel('Agenda');
        $this->loadModel('Cliente');

        $array_inmuebles = [];


        if( $this->request->is('post') ) {

            // Paso 1
            $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
            $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));

            if( !empty($this->request->data['request->data']['Lead']) ) {
                foreach( $this->request->data['request->data']['Lead'] as $leads ){
                    
                    // Paso 2
                    if( isset( $leads['check']) ) {
                        
                        // Paso 3
                        array_push($array_inmuebles, $leads['id']);
                        
                        // Paso 4
                        $this->request->data['Lead']['inmueble_id'] = $leads['id'];

                        // Paso 5
                        $this->request->data['LogInmueble']['inmueble_id'] = $leads['id'];
                        $this->request->data['LogInmueble']['mensaje']       = "Reenvío de Desarrollo";
                        $this->request->data['LogInmueble']['usuario_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['LogInmueble']['fecha']         = date('Y-m-d H:i:s');
                        $this->request->data['LogInmueble']['accion']        = 3;
                        $this->LogInmueble->create();
                        $this->LogInmueble->save($this->request->data);

                        // Paso 6
                        $this->Agenda->create();
                        $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                        $this->request->data['Agenda']['mensaje']    = "Se reenvían desarrollos a cliente";
                        $this->request->data['Agenda']['cliente_id'] = $this->request->data['Lead']['cliente_id'];
                        $this->Agenda->save($this->request->data);
                        
                    }
                }

                // Paso 7
                $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);
                $usuario = $this->User->read(null, $this->request->data['Lead']['user_id']);

                // Paso 8
                if( count($array_inmuebles) > 0 ) {

                    $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id " => $array_inmuebles )));
                    
                    $this->request->data['Cliente']['id']         = $this->request->data['Lead']['cliente_id'];
                    $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                    $this->Cliente->save($this->request->data);

                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         = uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['mensaje']    = "Reenvío de mail";
                    $this->request->data['LogCliente']['accion']     = 3;
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);
                    

                    $this->Email = new CakeEmail();
                    $this->Email->config(array(
                        'host' => $mailconfig['Mailconfig']['smtp'],
                        'port' => $mailconfig['Mailconfig']['puerto'],
                        'username' => $mailconfig['Mailconfig']['usuario'],
                        'password' => $mailconfig['Mailconfig']['password'],
                        'transport' => 'Smtp'
                        )
                    );

                    if ($paramconfig['Paramconfig']['cc_a_c'] != ""){
                        $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                        $arreglo_emails2 = array();
                        if (sizeof($emails2) > 0){
                            foreach($emails2 as $email):
                                $arreglo_emails2[$email] = $email;
                            endforeach;
                        }else{
                            $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                        }
                        $this->Email->cc($arreglo_emails2);
                    }
                    $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->subject($paramconfig['Paramconfig']['smessage_new_client']);
                    $this->Email->emailFormat('html');
                    $this->Email->viewVars(array('cliente' => $cliente, 'propiedades'=>$propiedades,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_seg_cliente_inmuebles'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                    $this->Email->template('emailacliente','layoutinmomail');
                    $this->Email->send();

                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Se ha reenviado la propiedad seleccionado.', 'default', array(), 'm_success');
                    return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                }else {
                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Es necesario seleccionar una propiedad.', 'default', array(), 'm_success');
                    return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                }
            }else{
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Es necesario seleccionar una propiedad.', 'default', array(), 'm_success');
                return $this->redirect(array('action' => 'view','controller'=>'clientes', $cliente_id));
            }

        } // Terminando post
        $this->autoRender = false;
    } // Fin de la funcion enviar propiedades

    
    /* ------------- DEFINICIÓN DE PROCESO PARA EL REENVIO DE PROPIEDADES AL CLIENTE -------------
        AKA:SaaK 05/03/2020
        
        1.- Tomar las configuraciones de paramconfig y mailconfig
        2.- Validar que se halla seleccionado algun desarrollo en el formulario.
        3.- Guardar en un arreglo los desarrollos seleccionados.
        4.- Guardar en Lead el desarrollo_id
        5.- Guardar en log_desarrollo.
        6.- Guardar en agenda.
        7.- Fuara del foreach consultar el cliente y el usuario.
        8.- Validamos el arreglo de desarrollos
            Si ()
                8.1.- Buscamos todos los desarrollos seleccionados
                8.2.- Actualizamos el last_edit del cliente. 
                8.3.- Enviamos los correos con los desarrollos seleccionados
                8.4.- Creamos log_cliente
                8.5.- Volvemos a la vista del cliente.
            No ()
                Volvemos a la pantalla pidiendo que se seleccione al menos un desarrollo
    */
    public function enviar_desarrollos($cliente_id = null){
        $this->loadModel('Paramconfig');
        $this->loadModel('Agenda');
        $this->loadModel('Cliente');

        $array_desarrollos = [];


        if( $this->request->is('post') ) {

            // Paso 1
            $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
            $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));

            if( !empty($this->request->data['request->data']['Lead']) ) {

                foreach( $this->request->data['request->data']['Lead'] as $leads ){
                
                    // Paso 2
                    if( isset( $leads['check']) ) {
                        
                        // Paso 3
                        array_push($array_desarrollos, $leads['id']);
                        
                        // Paso 4
                        $this->request->data['Lead']['desarrollo_id'] = $leads['id'];

                        // Paso 5
                        $this->request->data['LogDesarrollo']['desarrollo_id'] = $leads['id'];
                        $this->request->data['LogDesarrollo']['mensaje']       = "Reenvío de Desarrollo";
                        $this->request->data['LogDesarrollo']['usuario_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d H:i:s');
                        $this->request->data['LogDesarrollo']['accion']        = 5;
                        $this->LogDesarrollo->create();
                        $this->LogDesarrollo->save($this->request->data);

                        // Paso 6
                        $this->Agenda->create();
                        $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                        $this->request->data['Agenda']['mensaje']    = "Se reenvían desarrollos a cliente";
                        $this->request->data['Agenda']['cliente_id'] = $this->request->data['Lead']['cliente_id'];
                        $this->Agenda->save($this->request->data);
                        
                    }
                }

                // Paso 7
                $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);
                $usuario = $this->User->read(null, $this->request->data['Lead']['user_id']);

                // Paso 8
                if( count($array_desarrollos) > 0 ) {

                    $desarrollos = $this->Desarrollo->find('all',array('conditions'=>array("Desarrollo.id " => $array_desarrollos )));
                    
                    $this->request->data['Cliente']['id']         = $this->request->data['Lead']['cliente_id'];
                    $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                    $this->Cliente->save($this->request->data);

                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         = uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['mensaje']    = "Reenvío de mail";
                    $this->request->data['LogCliente']['accion']     = 3;
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);
                    

                    $this->Email = new CakeEmail();
                    $this->Email->config(array(
                        'host' => $mailconfig['Mailconfig']['smtp'],
                        'port' => $mailconfig['Mailconfig']['puerto'],
                        'username' => $mailconfig['Mailconfig']['usuario'],
                        'password' => $mailconfig['Mailconfig']['password'],
                        'transport' => 'Smtp'
                        )
                    );

                    if ($paramconfig['Paramconfig']['cc_a_c'] != ""){
                        $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                        $arreglo_emails2 = array();
                        if (sizeof($emails2) > 0){
                            foreach($emails2 as $email):
                                $arreglo_emails2[$email] = $email;
                            endforeach;
                        }else{
                            $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                        }
                        $this->Email->cc($arreglo_emails2);
                    }
                    $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->subject($paramconfig['Paramconfig']['smessage_new_desarrollo']);
                    $this->Email->emailFormat('html');
                    $this->Email->viewVars(array('cliente' => $cliente, 'desarrollos'=>$desarrollos,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_seg_cliente_desarrollo'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));

                    $this->Email->template('emailaclientedesarrollos','layoutinmomail');
                    $this->Email->send();

                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Se ha reenviado el desarrollo seleccionado.', 'default', array(), 'm_success');
                    return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                }else {
                    $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                    $this->Session->setFlash('Es necesario seleccionar un desarrollo.', 'default', array(), 'm_success');
                    return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Lead']['cliente_id']));
                }

            }else {
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Es necesario seleccionar un desarrollo.', 'default', array(), 'm_success');
                return $this->redirect(array('action' => 'view','controller'=>'clientes', $cliente_id));
            }
            

        } // Terminando post
        $this->autoRender = false;

    } // Fin del metodo de enviar_desarrollos

        
    public function enviar_departamentos(){
        $this->loadModel('Paramconfig');
        $this->layout= 'bos';
            if ($this->request->is('post')) {
                $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));
                $arreglo="";
                    for($i=1;$i<$this->request->data['Lead']['contador'];$i++){
            if ($this->request->data['Lead']['seleccionar'.$i]==1){
                                    if (isset($this->request->data['Lead']['inmueble_id'.$i])){
                                        $arreglo = $arreglo.$this->request->data['Lead']['inmueble_id'.$i].",";
                                        $this->request->data['Lead']['inmueble_id']=$this->request->data['Lead']['inmueble_id'.$i];
                                    }
                                    
                                    
            }
        }
                    // $cliente = $this->Cliente->read(null,$this->request->data['Lead']['cliente_id']);
                    $usuario = $this->User->read(null,$this->Session->read('Auth.User.id'));
                    $desarrollo = $this->Desarrollo->read(null, $this->request->data['Lead']['desarrollo_id']);
                    
                    if ($arreglo!=""){
                        
                        $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id IN (".  substr($arreglo,0, -1).")")));
                    }
                    
                    
                    foreach ($this->request->data['Lead']['cliente_id'] as $cliente_id):
                        foreach ($propiedades as $propiedad):
                            $this->Lead->create();
                            $this->request->data['Lead']['inmueble_id']=  $propiedad['Inmueble']['id'];
                            //$this->request->data['Lead']['inmueble_id']="";
                            $this->request->data['Lead']['cliente_id']=$cliente_id;
                            $this->request->data['Lead']['status']="Abierto";
                            $this->Lead->save($this->request->data);
                            $this->Lead->clear();
                        //echo "Guardó Lead Desarrolo";
                            $this->Lead->query("UPDATE clientes SET last_edit = NOW() WHERE id = $cliente_id");
                            
                            $this->LogInmueble->create();
                            $this->request->data['LogInmueble']['inmueble_id'] = $propiedad['Inmueble']['id'];
                            $this->request->data['LogInmueble']['mensaje'] = "Envío de correo a cliente";
                            $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['LogInmueble']['fecha'] = date('Y-m-d H:i:s');
                            $this->request->data['LogInmueble']['accion'] = 5;
                            $this->LogInmueble->save($this->request->data);
                            
                            $this->LogCliente->create();
                            $this->request->data['LogCliente']['id'] = uniqid();
                            $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
                            $this->request->data['LogCliente']['mensaje'] = "Envío de propiedad a cliente";
                            $this->request->data['LogCliente']['usuario_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['LogCliente']['datetime'] = date('Y-m-d H:i:s');
                            $this->request->data['LogCliente']['accion'] = 5;
                            $this->LogCliente->save($this->request->data);
                            
                        endforeach;
                            $cliente = $this->Cliente->read(null,$cliente_id);
                            $this->Email = new CakeEmail();
                            $this->Email->config(array(
                                    'host' => $mailconfig['Mailconfig']['smtp'],
                                    'port' => $mailconfig['Mailconfig']['puerto'],
                                    'username' => $mailconfig['Mailconfig']['usuario'],
                                    'password' => $mailconfig['Mailconfig']['password'],
                                    'transport' => 'Smtp'
                                    )
                                );
                            if ($paramconfig['Paramconfig']['cc_a_c']!=""){
                            $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                            $arreglo_emails2 = array();
                            if (sizeof($emails2)>0){
                                foreach($emails2 as $email):
                                    $arreglo_emails2[$email] = $email;
                                endforeach;
                            }else{
                                $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                            }
                            $this->Email->cc($arreglo_emails2);
                        }
                            $this->Email->from(array($this->Session->read('Auth.User.correo_electronico') => $this->Session->read('Auth.User.correo_electronico')));
                            $this->Email->to($cliente['Cliente']['correo_electronico']);
                            $this->Email->subject('Listado de departamentos BOS Inmobiliaria');
                            $this->Email->emailFormat('html');
                            if (isset($propiedades)){
                                $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades,'desarrollo'=>$desarrollo, 'usuario'=>$usuario));
                            }
                            $this->Email->template('emailaclientedeptos','layoutinmomail');
                            $this->Email->send();
                            
                            $this->LogDesarrollo->create();
                            $this->request->data['LogDesarrollo']['desarrollo_id'] = $this->request->data['Lead']['desarrollo_id'];
                            $this->request->data['LogDesarrollo']['mensaje'] = "Envío de desarrollo a cliente";
                            $this->request->data['LogDesarrollo']['usuario_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['LogDesarrollo']['fecha'] = date('Y-m-d H:i:s');
                            $this->request->data['LogDesarrollo']['accion'] = 5;
                            $this->LogDesarrollo->save($this->request->data);
                            
                        endforeach;
                    
                    
        $this->Session->setFlash(__('Se han enviado las propiedades al cliente'),'default',array('class'=>'success'));
        return $this->redirect(array('action' => 'view','controller'=>'desarrollos',$this->request->data['Lead']['desarrollo_id']));
            }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function edit($id = null) {
		if (!$this->Lead->exists($id)) {
			throw new NotFoundException(__('Invalid lead'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Lead->save($this->request->data)) {
				$this->Session->setFlash(__('The lead has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lead could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lead.' . $this->Lead->primaryKey => $id));
			$this->request->data = $this->Lead->find('first', $options);
		}
		$clientes = $this->Lead->Cliente->find('list');
		$inmuebles = $this->Lead->Inmueble->find('list');
		$this->set(compact('clientes', 'inmuebles'));
	}

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function delete($id = null) {
		$this->Lead->id = $id;
		if (!$this->Lead->exists()) {
			throw new NotFoundException(__('Invalid lead'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lead->delete()) {
			$this->Session->setFlash(__('The lead has been deleted.'));
		} else {
			$this->Session->setFlash(__('The lead could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
    public function status($id = null, $status= null, $cliente = null) {
		$this->Lead->query("UPDATE leads SET transferido =null, status ='".$status."' WHERE id = $id");
		return $this->redirect(array('controller'=>'clientes','action' => 'view', $cliente));
    }
    
    public function transferir_cerrador($id = null){
        $this->Lead->Behaviors->load('Containable');
        $lead = $this->Lead->find(
            'first',
            array(
                'fields'=>array('cliente_id'),
                'contain'=>false,
                'conditions'=>array('Lead.id'=>$id)
            )
        );
        $this->Lead->query("UPDATE leads SET transferido = 1 WHERE id = $id");
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash('Has comenzado el proceso de venta para este cliente. El cerrador podrá ver el seguimiento y cerrar la transacción', 'default', array(), 'm_success'); // Mensaje
        return $this->redirect(array('action' => 'view','controller'=>'clientes',$lead['Lead']['cliente_id']));
    }
    
    function get_options_desarrollos( $cliente_id = null ) {
        
        $condiciones_desarrollos = array('Desarrollo.id IN (SELECT leads.desarrollo_id FROM leads WHERE leads.cliente_id = '.$cliente_id.' AND leads.desarrollo_id IS NOT NULL )');
        
        $resp = $this->Desarrollo->find('list', array(
            'conditions' => $condiciones_desarrollos,
            'order' => 'Desarrollo.nombre ASC',
            'fields' => array('Desarrollo.id', 'Desarrollo.nombre'),
        ));

        echo json_encode($resp, true);
        $this->autoRender = false;

    }

    function get_options_inmuebles( $cliente_id = null ) {
        
        $condiciones_inmuebles   = array('Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE leads.cliente_id = '.$cliente_id.' AND leads.inmueble_id IS NOT NULL)');
        
        $resp = $this->Inmueble->find('list', array(
            'conditions' => $condiciones_inmuebles,
            'order' => 'Inmueble.titulo ASC'
          ));

        echo json_encode($resp, true);
        $this->autoRender = false;

    }

    function set_add_inmueble( $cuenta_id = null, $cliente_id = null, $user_id = null ){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

        $this->layout = null;
        
        $data_asignacion = array(
            'cliente_id'  => $cliente_id,
            'cuenta_id'   => $cuenta_id,
            'user_id'     => $user_id,
            'propiedades' => $this->request->data['arregloInmuebles']
        );
        
        $save_inmueble_lead = $this->asignacion_lead( $data_asignacion );
        echo json_encode( $save_inmueble_lead );

        $this->autoRender = false;
    }

    // Envio del desarrollo completo al cliente desde la app
    function set_add_desarrollo_all( $cuenta_id = null, $user_id = null, $desarrollo_id = null, $cliente_id = null ){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

        $this->layout = null;
        
        $cliente     = $this->Cliente->read(null, $cliente_id);
        $usuario     = $this->User->read(null, $user_id);
        $cuenta      = $this->Cuenta->findFirstById( $cuenta_id);
        $mailconfig  = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id'] );
        $paramconfig = $this->Paramconfig->findFirstById( $cuenta['Cuenta']['paramconfig_id'] );
        $desarrollos = $this->Desarrollo->find('all',array('conditions'=>array("Desarrollo.id " => $desarrollo_id )));

        $lead_existe = $this->Lead->find('first',array('conditions'=>array('Lead.desarrollo_id' => $desarrollo_id, 'Lead.cliente_id'=>$cliente_id)));

        if( empty ( $lead_existe ) ) {
            
            $this->Lead->create();
            $this->request->data['Lead']['desarrollo_id'] = $desarrollo_id;
            $this->request->data['Lead']['cliente_id']    = $cliente['Cliente']['id'];
            $this->request->data['Lead']['status']        = 'Abierto';
            $this->Lead->save($this->request->data);

        }


        // Se guarda en el log del inmueble que se le asigno un cliente.
        $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_id;
        $this->request->data['LogDesarrollo']['mensaje']     = "Envío de desarrollo a cliente:". $cliente['Cliente']['nombre'];
        $this->request->data['LogDesarrollo']['usuario_id']  = $usuario['User']['id'];
        $this->request->data['LogDesarrollo']['fecha']       = date('Y-m-d H:i:s');
        $this->request->data['LogDesarrollo']['accion']      = 5;
        $this->LogDesarrollo->create();
        $this->LogDesarrollo->save($this->request->data);

        // Se guarda en el log del cliente.
        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         =  uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
        $this->request->data['LogCliente']['user_id']    = $usuario['User']['id'];
        $this->request->data['LogCliente']['mensaje']    = "Generación de Lead";
        $this->request->data['LogCliente']['accion']     = 7;
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
        $this->LogCliente->save($this->request->data);

        // Se guarda en el seguimiento rapido.
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $usuario['User']['id'];
        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']    = "Envío de desarrollo";
        $this->request->data['Agenda']['cliente_id'] = $cliente['Cliente']['id'];
        $this->Agenda->save($this->request->data);

        
        $this->Lead->query("UPDATE clientes SET last_edit = NOW() WHERE id = ".$cliente['Cliente']['id']);

        if ($cliente['Cliente']['correo_electronico'] != 'Sin correo'){
            $this->Email = new CakeEmail();
            $this->Email->config(array(
                            'host'      => $mailconfig['Mailconfig']['smtp'],
                            'port'      => $mailconfig['Mailconfig']['puerto'],
                            'username'  => $mailconfig['Mailconfig']['usuario'],
                            'password'  => $mailconfig['Mailconfig']['password'],
                            'transport' => 'Smtp'
                            )
                        );
            if ($paramconfig['Paramconfig']['cc_a_c']!=""){
                $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                $arreglo_emails2 = array();
                if (sizeof($emails2)>0){
                    foreach($emails2 as $email):
                        $arreglo_emails2[$email] = $email;
                    endforeach;
                }else{
                    $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                }
                $this->Email->cc($arreglo_emails2);
            }

            $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
            $this->Email->to($cliente['Cliente']['correo_electronico']);
            $this->Email->subject('Propiedades que te pueden interesar '.$cuenta['Cuenta']['nombre_comercial']);
            $this->Email->emailFormat('html');
            $this->Email->viewVars(array('cliente' => $cliente, 'desarrollos'=>$desarrollos,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_new_client'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
            $this->Email->template('emailacliente','layoutinmomail');
            $this->Email->send();

            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         = uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
            $this->request->data['LogCliente']['user_id']    = $usuario['User']['id'];
            $this->request->data['LogCliente']['mensaje']    = "Envío de desarrollo";
            $this->request->data['LogCliente']['accion']     = 3;
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
            $this->LogCliente->save($this->request->data);

            $respuesta = array(
                'Ok' => true,
                'mensaje' => 'Se ha asignado exitosamente el desarrollo.'
            );

        }else{
            $respuesta = array(
                'Ok' => true,
                'mensaje' => 'Se ha asignado correctamente el desarrollo, sin embargo el cliente NO recibirá notificación, porque no cuenta con correo electrónico registrado.'
            );
        }

        echo json_encode( $respuesta );
        $this->autoRender = false;

    }


    // Funsion para la asignacion de propiedades para el cliente.
    public function asignacion_lead( $data = null ){
        // Hacer el foreach de los id de la propiedad seleccionada.

        // $data = array(
        //     'cliente_id'  => "25878",
        //     'cuenta_id'   => "1",
        //     'user_id'     => "447",
        //     'propiedades' => "183"
        // );

        if( $data['propiedades'] != '' ) {
            
            $cliente = $this->Cliente->read(null, $data['cliente_id']);
            $usuario = $this->User->read(null, $data['user_id']);
            $cuenta      = $this->Cuenta->findFirstById( $data['cuenta_id']);
            $mailconfig  = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id'] );
            $paramconfig = $this->Paramconfig->findFirstById( $cuenta['Cuenta']['paramconfig_id'] );
            $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id IN (".$data['propiedades'].")")));
            $desarrollo_inmuebles = $this->DesarrolloInmueble->find('all',array('conditions'=>array("DesarrolloInmueble.inmueble_id IN (".$data['propiedades'].")")));

            
            
            // Hacer validación para saber si existe el desarrollo en el lead de venta.
            if( !empty( $desarrollo_inmuebles ) ){

                $lead_existe = $this->Lead->find('first',array('conditions'=>array('Lead.desarrollo_id' => $desarrollo_inmuebles[0]['DesarrolloInmueble']['desarrollo_id'], 'Lead.cliente_id'=>$cliente['Cliente']['id'])));

                if( empty ( $lead_existe ) ) {
                    
                    $this->Lead->create();
                    $this->request->data['Lead']['desarrollo_id'] = $desarrollo_inmuebles[0]['DesarrolloInmueble']['desarrollo_id'];
                    $this->request->data['Lead']['cliente_id']    = $cliente['Cliente']['id'];
                    $this->request->data['Lead']['status']        = 'Abierto';
                    $this->Lead->save($this->request->data);

                }
            }



            foreach( explode(',', $data['propiedades']) as $inmueble ) {

                // Validacion, si existe el lead de la propiedad no se genera doble ves.
                $existe = $this->Lead->find('first',array('conditions'=>array(
                    'Lead.inmueble_id' => $inmueble,
                    'Lead.cliente_id'  => $cliente['Cliente']['id']
                )));

                if ( empty( $existe ) ){
                    
                    // Validacion si el inmueble seleccionado forma parte de algun desarrollo.
                    if( empty( $desarrollo_inmuebles ) ){
                        $this->request->data['Lead']['desarrollo_id']  = $cliente['Cliente']['id'];
                    }

                    // Se guarda el lead
                    $this->Lead->create();
                    $this->request->data['Lead']['cliente_id']    = $cliente['Cliente']['id'];
                    $this->request->data['Lead']['inmueble_id']   = $inmueble;
                    $this->request->data['Lead']['status']        = 'Abierto';
                    $this->request->data['Lead']['desarrollo_id'] = NULL;
                    $this->Lead->save($this->request->data);

                }

    
                // Se guarda en el log del inmueble que se le asigno un cliente.
                $this->request->data['LogInmueble']['inmueble_id'] = $inmueble;
                $this->request->data['LogInmueble']['mensaje']     = "Asignación a cliente:". $cliente['Cliente']['nombre'];
                $this->request->data['LogInmueble']['usuario_id']  = $data['user_id'];
                $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
                $this->request->data['LogInmueble']['accion']      = 9;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);
    
                // Se guarda en el log del cliente.
                $this->LogCliente->create();
                $this->request->data['LogCliente']['id']         =  uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
                $this->request->data['LogCliente']['user_id']    = $data['user_id'];
                $this->request->data['LogCliente']['mensaje']    = "Generación de Lead";
                $this->request->data['LogCliente']['accion']     = 7;
                $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                $this->LogCliente->save($this->request->data);
    
                // Se guarda en el seguimiento rapido.
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']    = $data['user_id'];
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']    = "Envío de propiedades adicionales";
                $this->request->data['Agenda']['cliente_id'] = $cliente['Cliente']['id'];
                $this->Agenda->save($this->request->data);
    
                
                $this->Lead->query("UPDATE clientes SET last_edit = NOW() WHERE id = ".$cliente['Cliente']['id']);
    
                if ($cliente['Cliente']['correo_electronico'] != 'Sin correo'){
                    $this->Email = new CakeEmail();
                    $this->Email->config(array(
                                    'host'      => $mailconfig['Mailconfig']['smtp'],
                                    'port'      => $mailconfig['Mailconfig']['puerto'],
                                    'username'  => $mailconfig['Mailconfig']['usuario'],
                                    'password'  => $mailconfig['Mailconfig']['password'],
                                    'transport' => 'Smtp'
                                    )
                                );
                    if ($paramconfig['Paramconfig']['cc_a_c']!=""){
                        $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                        $arreglo_emails2 = array();
                        if (sizeof($emails2)>0){
                            foreach($emails2 as $email):
                                $arreglo_emails2[$email] = $email;
                            endforeach;
                        }else{
                            $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                        }
                        $this->Email->cc($arreglo_emails2);
                    }
    
                    $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->subject('Propiedades que te pueden interesar '.$cuenta['Cuenta']['nombre_comercial']);
                    $this->Email->emailFormat('html');
                    
                    if (isset($propiedades)){
                        $this->Email->viewVars(array('cliente' => $cliente, 'propiedades'=>$propiedades,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_new_client'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
                    }
    
                    $this->Email->template('emailacliente','layoutinmomail');
                    $this->Email->send();
    
                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         = uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
                    $this->request->data['LogCliente']['user_id']    = $usuario['User']['id'];
                    $this->request->data['LogCliente']['mensaje']    = "Envío de propiedad";
                    $this->request->data['LogCliente']['accion']     = 3;
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);
    
                    $respuesta = array(
                        'bandera' => true,
                        'mensaje' => 'Se ha asignado exitosamente la(s) propiedad(es).'
                    );
    
                }else{
                    $respuesta = array(
                        'bandera' => true,
                        'mensaje' => 'Se ha asignado correctamente la propiedad/unidad, sin embargo el cliente NO recibirá notificación, porque no cuenta con correo electrónico registrado.'
                    );
                }
            }

        }else {
            $respuesta = array(
                'bandera' => false,
                'mensaje' => 'Es necesario seleccionar al menos una propiedad.'
            );
        }

        
        return $respuesta;
        $this->autoRender = false;
        
    }

    public function get_add_inmueble( $cuenta_id = null ) {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

        // banios: "2"
        // ciudad: "Ciudad de prueba"
        // colonia: "Colonia de prueba"
        // construccionMax: "1215"
        // construccionMin: "1250"
        // delegacion: "Municipio de prueba"
        // edadMax: "5"
        // edadMin: "10"
        // estacionamiento: ""
        // estado: "Estado de prueba"
        // precioMax: "400"
        // precioMin: "50000000"
        // recamaras: "1231"
        // rentaVenta: "Renta/Venta"
        // terrenoMin: "1315"
        // tipoPropiedad: "5"

        $condiciones = array('Inmueble.liberada'=>1,'Inmueble.cuenta_id'=>$cuenta_id, 'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)');

        if (!empty($this->request->data['tipoPropiedad'])) array_push($condiciones, array('dic_tipo_propiedad_id'=>$this->request->data['tipoPropiedad']));  
        if (!empty($this->request->data['rentaVenta'])) array_push($condiciones, array('venta_renta'=>$this->request->data['rentaVenta']));
        if (!empty($this->request->data['colonia'])) array_push($condiciones, array('colonia LIKE' => '%'.$this->request->data['colonia'].'%' ));
        if (!empty($this->request->data['delegacion'])) array_push($condiciones, array('delegacion'=> '%'.$this->request->data['delegacion'].'%'));
        if (!empty($this->request->data['ciudad'])) array_push($condiciones, array('ciudad'=> '%'.$this->request->data['ciudad'].'%'));
        if (!empty($this->request->data['estado'])) array_push($condiciones, array('estado_ubicacion'=>'%'.$this->request->data['estado'].'%'));
        if (!empty($this->request->data['precioMin'])) array_push($condiciones, array('precio >='=>$this->request->data['precioMin']));
        if (!empty($this->request->data['precioMax'])) array_push($condiciones, array('precio <='=>$this->request->data['precioMax']));
        if (!empty($this->request->data['edadMin'])) array_push($condiciones, array('edad >='=>$this->request->data['edadMin']));
        if (!empty($this->request->data['edadMax'])) array_push($condiciones, array('edad <='=>$this->request->data['edadMax']));
        if (!empty($this->request->data['terrenoMin'])) array_push($condiciones, array('terreno'=>$this->request->data['terrenoMin']));
        if (!empty($this->request->data['construccionMin'])) array_push($condiciones, array('construccion >='=>$this->request->data['construccionMin']));
        if (!empty($this->request->data['construccionMax'])) array_push($condiciones, array('construccion <='=>$this->request->data['construccionMax']));
        if (!empty($this->request->data['recamaras'])) array_push($condiciones, array('recamaras >='=>$this->request->data['recamaras']));
        if (!empty($this->request->data['banios'])) array_push($condiciones, array('banos >='=>$this->request->data['banios']));
        if (!empty($this->request->data['estacionamiento'])) array_push($condiciones, array('estacionamiento_descubierto >='=>$this->request->data['estacionamiento']));

        $propiedades = $this->Inmueble->find('all',array('conditions'=>$condiciones,'order'=>'precio ASC'));
        

        $this->layout = false;

        $respuesta = array(
            'Ok' => true,
            'mensaje' => $propiedades
        );

        // print_r( $respuesta );
        echo json_encode( $respuesta );

        $this->autoRender = false;

    }

    /**
    * esta funcion alimenta la grafica de leads, ventas e inversion del medio del desarrollo,
    * lo hace por los filtros id del desarrollo, fechas y cuenta 
    * AKA RogueOne
    */
    function grafica_ventas_linea_contacto(){
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Venta');
        $this->loadModel('Lead');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->Lead->Behaviors->load('Containable');
        $this->Venta->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $and = [];
        $or  = [];
        if ($this->request->is('post')) {
            $cuenta_id= $this->request->data['cuenta_id'];
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty($this->request->data['rango_fechas']) ){
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
                    // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
                    $cond_rangos_ventas = array("Venta.fecha LIKE '".$fi."%'");

                }else{
                    // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_ventas=array("Venta.fecha BETWEEN ? AND ?" => array($fi, $ff));
                }
            }
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
            $clientes=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.desarrollo_id' =>$desarrollo_id,
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    // 'Cliente.cuenta_id' => $cuenta_id,
                    // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
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
            // $leads=$this->Lead->find('all',array(
            //     'conditions'=>array(
            //         'Lead.desarrollo_id' =>$desarrollo_id,
            //         'Lead.dic_linea_contacto_id <>'    => '',
            //         $cond_rangos,
            //       ),
            //       'fields' => array(
            //           'COUNT(Lead.dic_linea_contacto_id) as lead',
            //           'Lead.dic_linea_contacto_id'
            //       ),
            //       'group'   =>'Lead.dic_linea_contacto_id',
            //       'order'   => 'Lead.dic_linea_contacto_id ASC',
            //       'contain' => false 
            //     )
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
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );    
            $ventas= $this->User->query(
                  "SELECT COUNT(clientes.dic_linea_contacto_id) AS venta ,clientes.dic_linea_contacto_id
                  FROM ventas, clientes
                  WHERE ventas.inmueble_id in( select inmueble_id from desarrollo_inmuebles where desarrollo_id = '$desarrollo_id')
                  and ventas.cuenta_id = $cuenta_id
                  AND clientes.id = ventas.cliente_id
                  AND  ventas.fecha >= '$fi' 
                  AND  ventas.fecha <= '$ff'
                  GROUP BY clientes.dic_linea_contacto_id;"
            );
            $arreglo_ventas=array();
            $i=0;
            foreach ($dic_linea_contacto as $value_dic) {
                  foreach ($clientes as  $value_lead) {
                      if ($value_dic['DicLineaContacto']['id']==$value_lead['Cliente']['dic_linea_contacto_id']) {
                          $arreglo_ventas[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                          $arreglo_ventas[$i]['leads']     = $value_lead[0]['lead'];
                          $arreglo_ventas[$i]['inversion'] = 0;
                          $arreglo_ventas[$i]['ventas']    = 0;
                      }
                  }
                //   {"0":{"lead":"159"},"Lead":{"dic_linea_contacto_id":"1706"}
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
            $leads_ventas[$i]['medio']="medio";
            $leads_ventas[$i]['leads']=0;
            $leads_ventas[$i]['inversion']=0;
            $leads_ventas[$i]['ventas']=0;
        }
        // $fi='2022-01-01 00:00:00';
        // $ff='2022-11-11 23:59:59';
        // $desarrollo_id=246;
        // $cond_rangos = array('Lead.fecha BETWEEN ? AND ?'=> array($fi, $ff));
        // $leads=$this->Lead->find('all',array(
        //     'conditions'=>array(
        //         'Lead.desarrollo_id' =>$desarrollo_id,
        //         'Lead.dic_linea_contacto_id <>'    => '',
        //         // 'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
        //         // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
        //         // 'Cliente.user_id <>'    => '',
        //         $cond_rangos,
        //       ),
        //       'fields' => array(
        //           'COUNT(Lead.dic_linea_contacto_id) as lead',
        //           'Lead.dic_linea_contacto_id'
        //       ),
        //       'group' =>'Lead.dic_linea_contacto_id',
        //       'order'   => 'Lead.dic_linea_contacto_id ASC',
        //       'contain' => false 
        //     )
        // );
        echo json_encode( $leads_ventas, true );
        exit();
        $this->autoRender = false;
    }

    /**
    * esta funcion alimenta la grafica de leads, visitas e inversion del medio del desarrollo,
    * lo hace por los filtros id del desarrollo, fechas y cuenta 
    * AKA RogueOne
    */
    function grafica_visitas_linea_contacto(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Cliente');
        $this->loadModel('Event');
        $this->Event->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        $i=0;
        $arreglo_leads_visitas=array();
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if ($this->request->is('post')) {
            $cuenta_id= $this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
                    // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
                    $cond_rangos_ventas = array("Event.fecha_inicio LIKE '".$fi."%'");

                }else{
                    // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_event=array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                }
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            $leads=array();
            $i=0;
            $aux=0;
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
            // $leads_clien=$this->Lead->find('all',array(
            //     'conditions'=>array(
            //         'Lead.desarrollo_id' =>$desarrollo_id,
            //         'Lead.dic_linea_contacto_id <>'    => '',
            //         $cond_rangos,
            //       ),
            //       'fields' => array(
            //           'COUNT(Lead.dic_linea_contacto_id) as lead',
            //           'Lead.dic_linea_contacto_id'
            //       ),
            //       'group' =>'Lead.dic_linea_contacto_id',
            //       'order'   => 'Lead.dic_linea_contacto_id ASC',
            //       'contain' => false 
            //     )
            // );
            $clientes=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.desarrollo_id' =>$desarrollo_id,
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    'Cliente.cuenta_id' => $cuenta_id,
                    // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
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
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $events= $this->Event->query(
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
            foreach ($dic_linea_contacto as $value_dic) {
                foreach ($clientes as $lead) {
                    if ($value_dic['DicLineaContacto']['id'] == $lead['Cliente']['dic_linea_contacto_id']) {
                        $leads[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                        $leads[$i]['leads']=$lead[0]['lead'];
                        $leads[$i]['inversion']=0;
                        $leads[$i]['visita']=0;
                    }
                }  //   {"0":{"lead":"159"},"Lead":{"dic_linea_contacto_id":"1706"}
                foreach ($inversion as $inver) {
                    if ($value_dic['DicLineaContacto']['id']==$inver['dic_linea_contactos']['id']) {
                        $leads[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $leads[$i]['inversion'] = $inver[0]['inversion'];
                        if ( $leads[$i]['leads'] == 0) {
                            $leads[$i]['leads'] = 0;
                        }
    
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
                // foreach ($events_inmuble as $value) {
                //     if ($value_dic['DicLineaContacto']['id']==$value['clientes']['dic_linea_contacto_id']) {
                //         $leads[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                //         if ( $leads[$i]['leads'] == 0) {
                //             $leads[$i]['leads'] = 0;
                //         }
                //         if (  $leads[$i]['inversion']==0) {
                //             $leads[$i]['inversion']=0;
                //         }
                       
                //         $leads[$i]['visita'] += $value[0]['visita'];
                //     }
                // }
                $i++;
            }
            $i=0;
            $arreglo_leads_visitas=array();
            foreach ($leads as  $value) {
                
                $arreglo_leads_visitas[$i]['medio']     = $value['medio'];
                $arreglo_leads_visitas[$i]['leads']     = ( empty($value['leads']) ? 0 : $value['leads'] );
                $arreglo_leads_visitas[$i]['inversion'] = ( empty($value['inversion']) ? 0 : $value['inversion'] );
                $arreglo_leads_visitas[$i]['visitas']   = ( empty($value['visita']) ? 0 : $value['visita'] );
                $i++;
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
     * 
    */
    function grafica_definitivos_linea_contacto(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        $clientes_activos              = 0;
        $clientes_inactivos            = 0;
        $clientes_inactivos_temporales = 0;
        $condiciones                   = [];
        $fecha_ini                     = '';
        $fecha_fin                     = '';
        $and                           = [];
        $or                            = [];
        $desarrollo_id                 = 0;
        $leads_inactivos=array();
        $i=0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
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
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty($this->request->data['rango_fechas']) ){
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
            $clientes_inactivos=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.status'      => 'Inactivo',
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    $condiciones
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
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $arreglo_leads_inactivos=array();
            $i=0;
            foreach ($dic_linea_contacto as $value_dic) {
                foreach ($clientes_inactivos as  $value_lead) {
                    if ($value_dic['DicLineaContacto']['id']==$value_lead['Cliente']['dic_linea_contacto_id']) {
                        $arreglo_leads_inactivos[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $arreglo_leads_inactivos[$i]['leads']     = $value_lead[0]['lead'];
                        $arreglo_leads_inactivos[$i]['inversion'] = 0;
                    }
                }
                foreach ($inversion as $value_inv) {
                    if ($value_dic['DicLineaContacto']['id']==$value_inv['dic_linea_contactos']['id']) {
                        $arreglo_leads_inactivos[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $arreglo_leads_inactivos[$i]['inversion'] = $value_inv[0]['inversion'];
                        if ( $arreglo_leads_inactivos[$i]['leads'] == 0) {
                            $arreglo_leads_inactivos[$i]['leads'] = 0;
                        }
                    }
                  }
                $i++;
            }
            //DicLineaContacto: {id: '87', linea_contacto: 'Sitio Web'}
            //0: {lead: '126', Cliente: {dic_linea_contacto_id: '87'}
            //0: {inversion: '6000', dic_linea_contactos: {id: '43'}
            $i=0; 
            foreach ($arreglo_leads_inactivos as $value) {
                $leads_inactivos[$i]['medio']=$value['medio'];
                $leads_inactivos[$i]['leads']=$value['leads'];
                $leads_inactivos[$i]['inversion']=$value['inversion'];
                $i++;
            }
        }
        if (empty($leads_inactivos)) {
            $leads_inactivos[$i]['medio']="medio";
            $leads_inactivos[$i]['leads']=0;
            $leads_inactivos[$i]['inversion']=0;
        }
        
        echo json_encode( $leads_inactivos , true );
        $this->autoRender = false;  
    }

    /*****
     * 
     * 
     * 
     */
    function grafica_temporales_linea_contacto(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        $clientes_inactivos_temporales = 0;
        $condiciones                   = [];
        $fecha_ini                     = '';
        $fecha_fin                     = '';
        $and                           = [];
        $or                            = [];
        $desarrollo_id                 = 0;
        $leads_temporal=array();
        $i=0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
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
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty($this->request->data['rango_fechas']) ){
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
            $clientes_inactivos_temporales=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.status'      => 'Inactivo temporal',
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    $condiciones
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
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $arreglo_leads_temporales=array();
            $i=0;
            foreach ($dic_linea_contacto as $value_dic) {
                foreach ($clientes_inactivos_temporales as  $value_lead) {
                    if ($value_dic['DicLineaContacto']['id']==$value_lead['Cliente']['dic_linea_contacto_id']) {
                        $arreglo_leads_temporales[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $arreglo_leads_temporales[$i]['leads']     = $value_lead[0]['lead'];
                        $arreglo_leads_temporales[$i]['inversion'] = 0;
                    }
                }
                foreach ($inversion as $value_inv) {
                    if ($value_dic['DicLineaContacto']['id']==$value_inv['dic_linea_contactos']['id']) {
                        $arreglo_leads_temporales[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $arreglo_leads_temporales[$i]['inversion'] = $value_inv[0]['inversion'];
                        if ( $arreglo_leads_temporales[$i]['leads'] == 0) {
                            $arreglo_leads_temporales[$i]['leads'] = 0;
                        }
                    }
                  }
                $i++;
            }
            //DicLineaContacto: {id: '87', linea_contacto: 'Sitio Web'}
            //0: {lead: '126', Cliente: {dic_linea_contacto_id: '87'}
            //0: {inversion: '6000', dic_linea_contactos: {id: '43'}
            $i=0; 
            foreach ($arreglo_leads_temporales as $value) {
                $leads_temporal[$i]['medio']=$value['medio'];
                $leads_temporal[$i]['leads']=$value['leads'];
                $leads_temporal[$i]['inversion']=$value['inversion'];
                $i++;
            }
        }
        if (empty($leads_temporal)) {
            $leads_temporal[$i]['medio']="medio";
            $leads_temporal[$i]['leads']=0;
            $leads_temporal[$i]['inversion']=0;
        }
        
        echo json_encode( $leads_temporal , true );
        $this->autoRender = false;  
    }
    /***
     * 
     * 
    */

    function grafica_activos_linea_contacto(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        $clientes_activos = 0;
        $condiciones                   = [];
        $fecha_ini                     = '';
        $fecha_fin                     = '';
        $and                           = [];
        $or                            = [];
        $desarrollo_id                 = 0;
        $leads_inactivos=array();
        $i=0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
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
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty($this->request->data['rango_fechas']) ){
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
            $clientes_activos=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.status'      => 'Activo',
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    $condiciones
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
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $arreglo_leads_activo=array();
            $i=0;
            foreach ($dic_linea_contacto as $value_dic) {
                foreach ($clientes_activos as  $value_lead) {
                    if ($value_dic['DicLineaContacto']['id']==$value_lead['Cliente']['dic_linea_contacto_id']) {
                        $arreglo_leads_activo[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $arreglo_leads_activo[$i]['leads']     = $value_lead[0]['lead'];
                        $arreglo_leads_activo[$i]['inversion'] = 0;
                    }
                }
                foreach ($inversion as $value_inv) {
                    if ($value_dic['DicLineaContacto']['id']==$value_inv['dic_linea_contactos']['id']) {
                        $arreglo_leads_activo[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $arreglo_leads_activo[$i]['inversion'] = $value_inv[0]['inversion'];
                        if ( $arreglo_leads_activo[$i]['leads'] == 0) {
                            $arreglo_leads_activo[$i]['leads'] = 0;
                        }
                    }
                  }
                $i++;
            }
            //DicLineaContacto: {id: '87', linea_contacto: 'Sitio Web'}
            //0: {lead: '126', Cliente: {dic_linea_contacto_id: '87'}
            //0: {inversion: '6000', dic_linea_contactos: {id: '43'}
            $i=0; 
            foreach ($arreglo_leads_activo as $value) {
                $leads_activo[$i]['medio']=$value['medio'];
                $leads_activo[$i]['leads']=$value['leads'];
                $leads_activo[$i]['inversion']=$value['inversion'];
                $i++;
            }
        }
        if (empty($leads_activo)) {
            $leads_activo[$i]['medio']="medio";
            $leads_activo[$i]['leads']=0;
            $leads_activo[$i]['inversion']=0;
        }
        
        echo json_encode( $leads_activo , true );
        $this->autoRender = false;  
    }
    /**
    * 
    * 
    * 
    * 
    */
    function grafica_ventas_leads_desarrollos(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Venta');
        $this->Venta->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
        $desarrollos_id ="";
        $medios_id      = "";
        $fecha_ini      = 0;
        $fecha_fin      = 0;
        $arreglo=array();
        $i=0;
        $leads=array();
        $dic_linea_contacto=array();
        $arreglo=array();
        $i=0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            $leads=$this->Lead->find('all',array(
                'conditions'=>array(
                    'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                    'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                    $cond_rangos,
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
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
                AND publicidads.dic_linea_contacto_id IN ($medios_id) 
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $ventas = $this->Venta->query(
                "SELECT COUNT(*)AS venta, clientes.dic_linea_contacto_id
                FROM operaciones_inmuebles, clientes
                WHERE operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))
                AND operaciones_inmuebles.fecha >='$fi' 
                AND operaciones_inmuebles.fecha <='$ff'
                AND operaciones_inmuebles.cliente_id=clientes.id
                AND tipo_operacion=3
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                GROUP BY clientes.dic_linea_contacto_id;"
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
            foreach ($dic_linea_contacto as $dic) {
                
                foreach ($leads as $lead) {
                    if ($lead['Lead']['dic_linea_contacto_id']==$dic['DicLineaContacto']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        $arreglo[$i]['leads']=$lead[0]['lead'];
                        $arreglo[$i]['inversion']=0;
                        $arreglo[$i]['ventas']=0;
                    }
                }
                foreach ($inversion as $inv) {
                    if ($dic['DicLineaContacto']['id']== $inv['dic_linea_contactos']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];

                        if ($arreglo[$i]['leads']==0) {
                            $arreglo[$i]['leads']=0;
                        }
                        $arreglo[$i]['inversion']=$inv[0]['inversion'];
                    }
                }
                foreach ($ventas as $venta) {
                    if ($dic['DicLineaContacto']['id']== $venta['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];

                        if ($arreglo[$i]['leads']==0) {
                            $arreglo[$i]['leads']=0;
                        }    
                        if ($arreglo[$i]['inversion']==0) {
                            $arreglo[$i]['inversion']=0;
                        }
                        
                        $arreglo[$i]['ventas']=$venta[0]['venta'];
                    }
                }

                $i++;
            }
            $i=0;
            foreach ($arreglo as $value) {
                $arreglo_ventas[$i]['medio']=$value['medio'];
                $arreglo_ventas[$i]['leads']=( empty($value['leads']) ? 0 : $value['leads'] );
                $arreglo_ventas[$i]['inversion']=( empty($value['inversion']) ? 0 : $value['inversion'] );
                $arreglo_ventas[$i]['ventas']=( empty($value['ventas']) ? 0 : $value['ventas'] );
                $i++;
            }
        }
        if(empty($arreglo_ventas)) {
            $arreglo_ventas[$i]['medio']=0;
            $arreglo_ventas[$i]['leads']=0;
            $arreglo_ventas[$i]['inversion']=0;
            $arreglo_ventas[$i]['ventas']=0;
            $i++;
        }
        echo json_encode( $arreglo_ventas , true );
        exit();
        $this->autoRender = false;
    }

    /**
     * 
     * 
     * 
    */
    function indicadores_periodo_seleccionado(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
		$this->loadModel('Venta');
        $this->loadModel('Desarrollo');
        $this->loadModel('operaciones_inmuebles');
        $this->operaciones_inmuebles->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->Venta->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');    
        $desarrollos_id = "";
        $medios_id      = "";
        $periodos       = [];
        $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $response       =[];
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                  }else{
                    $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            $periodos = $this->getPeriodosArreglo($fi,$ff);
            $meses=sizeof($periodos);
            $leads=$this->Lead->find('count',array(
                'conditions'=>array(
                    'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                    'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                    $cond_rangos,
                  ),
                  'contain' => false 
                )
            );
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
                AND publicidads.dic_linea_contacto_id IN ($medios_id) 
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                ;"
            );
            $ventas_unidadade_monto = $this->Venta->query(
                "SELECT COUNT(*)AS venta,SUM(precio_unidad)AS monto 
                FROM operaciones_inmuebles, clientes
                WHERE operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))
                AND operaciones_inmuebles.fecha >='$fi' 
                AND operaciones_inmuebles.fecha <='$ff'
                AND operaciones_inmuebles.cliente_id=clientes.id
                AND tipo_operacion=3
                AND clientes.dic_linea_contacto_id IN ($medios_id) ;"
            );
            if ( $leads==0) {
                $leads=1;
            }
            $response=array(
                '0' => array(
                    'leads'            => $leads,
                    'inversion'        => '$'.number_format( $inversion[0][0]['inversion'], 2),
                    'inversio_mensual' => '$'.number_format( $inversion[0][0]['inversion']/$meses, 2),
                    'promedio_leads'   => number_format( $leads/$meses,0),
                    'costo_leads'      => '$'.number_format( $inversion[0][0]['inversion']/$leads, 2),
                    'ventas_unidades'  => $ventas_unidadade_monto[0][0]['venta'],
                    'ventas_monto'     => '$'.number_format($ventas_unidadade_monto[0][0]['monto'],2),
                ),
            );        
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
    function indicadores_historico_seleccionado(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
		$this->loadModel('Venta');
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->Venta->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');    
        $desarrollos_id = "";
        $medios_id      = "";
        $periodos       = [];
        $cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $response       =[];
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fi='2000-01-01 00:00:00';
                $ff=date('Y-m-d H:i:s'); 
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            $periodos = $this->getPeriodosArreglo($fi,$ff);
            $meses=sizeof($periodos);
            $leads=$this->Cliente->find('count',array(
                'conditions'=>array(
                        'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
                        'Cliente.dic_linea_contacto_id <>'    => '',
                        'Cliente.cuenta_id' => $cuenta_id,
                        'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
                        'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
                        'Cliente.user_id <>'    => '',
                        $cond_rangos,
                    ),
                )
            );
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
                AND publicidads.dic_linea_contacto_id IN ($medios_id) 
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                ;"
            );
            $ventas_unidadade_monto = $this->Venta->query(
                "SELECT COUNT(*)AS venta,SUM(precio_unidads)AS monto 
                FROM operaciones_inmuebles, clientes
                WHERE operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))
                AND operaciones_inmuebles.fecha >='$fi' 
                AND operaciones_inmuebles.fecha <='$ff'
                AND operaciones_inmuebles.cliente_id=clientes.id
                AND tipo_operacion=3
                AND clientes.dic_linea_contacto_id IN ($medios_id) ;"
            );
           
            if ( $leads==0) {
                $leads=1;
            }
            $response=array(
                '0' => array(
                    'leads'   => $leads,
                    'inversion' =>'$'.number_format( $inversion[0][0]['inversion'], 2),
                    'costo_leads'=>'$'.number_format( $inversion[0][0]['inversion']/$leads, 2) ,
                    'ventas_unidades' => $ventas_unidadade_monto[0][0]['venta'], 
                    'ventas_monto' =>'$'. number_format($ventas_unidadade_monto[0][0]['monto'],2), 
                ),
            );

        }    
        echo json_encode( $response , true );
        exit();
        $this->autoRender = false;
    }

    /***
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

    /***
     * 
     * 
     * 
     * 
     */
    function get_detalles_inversion_leads_costos(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
		$this->loadModel('Venta');
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->Venta->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');    
        $desarrollos_id ="";
        $medios_id="";
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            $desarrollos = $this->Desarrollo->find('all',array(
                'conditions'=>array(
                        'Desarrollo.id IN('.$desarrollos_id.')'
                    ),
                    'fields'=>array(
                        'nombre',
                        'id'
                    ),
                    'contain'=>false
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
            $arreglo="";
            foreach ($dic_linea_contacto as $value) {
                foreach($this->request->data['medio_id'] as $medio){
                    if ($value['DicLineaContacto']['id']==$medio) {
                        $arreglo .="". $value['DicLineaContacto']['linea_contacto'].", ";
                    }
                } 
            }
            $nombre="";
            foreach ($desarrollos as $value) {
                $nombre .=$value['Desarrollo']['nombre'].",";
            }
            $arreglo = substr($arreglo,0,-1);
            $nombre = substr($nombre,0,-1);
            $response=array(
                '0' => array(
                    'desarrollos'   => $nombre,
                    'medio' =>"<b>".$arreglo."<b>",
                  ),
            );
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
    function grafica_ventas_visitas_leads_desarrollos(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
        $this->loadModel('Venta');
        $this->Venta->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
        $desarrollos_id ="";
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $arreglo=array();
        $arreglo_leads_ventas_visitas=array();
        $i=0;
        $medios_id = '';
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            // $leads=$this->Cliente->find('all',array(
            //     'conditions'=>array(
            //             'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
            //             'Cliente.dic_linea_contacto_id <>'    => '',
            //             'Cliente.cuenta_id' => $cuenta_id,
            //             'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
            //             'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
            //             'Cliente.user_id <>'    => '',
            //             $cond_rangos,
            //       ),
            //       'fields' => array(
            //           'COUNT(Cliente.dic_linea_contacto_id) as lead',
            //           'Cliente.dic_linea_contacto_id'
            //       ),
            //       'group' =>'Cliente.dic_linea_contacto_id',
            //       'order'   => 'Cliente.dic_linea_contacto_id ASC',
            //       'contain' => false 
            //     )
            // );
            $leads=$this->Lead->find('all',array(
                'conditions'=>array(
                    'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                    'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                    $cond_rangos,
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
            $ventas = $this->Venta->query(
                "SELECT COUNT(*)AS venta, clientes.dic_linea_contacto_id
                FROM operaciones_inmuebles, clientes
                WHERE operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))
                AND operaciones_inmuebles.fecha >='$fi' 
                AND operaciones_inmuebles.fecha <='$ff'
                AND operaciones_inmuebles.cliente_id=clientes.id
                AND tipo_operacion=3
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
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
            foreach ($dic_linea_contacto as $dic) {
                foreach ($leads as $lead) {
                    if ($lead['Lead']['dic_linea_contacto_id']==$dic['DicLineaContacto']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        $arreglo[$i]['leads']=$lead[0]['lead'];
                        $arreglo[$i]['ventas']=0;        
                        $arreglo[$i]['visitas']=0;
                    }
                }
                foreach ($ventas as $venta) {
                    if ($dic['DicLineaContacto']['id']== $venta['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['leads']==0){
                            $arreglo[$i]['leads']=0;
                        }
                        $arreglo[$i]['ventas']=$venta[0]['venta'];
                    }    
                }
                foreach ($visitas as $visita) {
                    if ($dic['DicLineaContacto']['id']== $visita['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['leads']==0){
                            $arreglo[$i]['leads']=0;
                        }
                        if($arreglo[$i]['ventas']==0){
                            $arreglo[$i]['ventas']=0;
                        }
                        $arreglo[$i]['visitas']=$visita[0]['visita'];
                    }
                }
                $i++;
            }
            $i=0;
            foreach ($arreglo as $value) {
                $arreglo_leads_ventas_visitas[$i]['medio']=$value['medio'];
                $arreglo_leads_ventas_visitas[$i]['leads']= ( empty($value['leads']) ? 0  :  $value['leads'] );
                $arreglo_leads_ventas_visitas[$i]['ventas']= ( empty($value['ventas']) ? 0  :  $value['ventas'] );
                $arreglo_leads_ventas_visitas[$i]['visitas']=( empty($value['visitas']) ? 0  :  $value['visitas'] );
                $i++;
            }
        }
        if(empty($arreglo_leads_ventas_visitas)) {
            $arreglo_leads_ventas_visitas[$i]['medio']=0;
            $arreglo_leads_ventas_visitas[$i]['leads']=0;
            $arreglo_leads_ventas_visitas[$i]['ventas']=0;
            $arreglo_leads_ventas_visitas[$i]['visitas']=0;
            $i++;
        }
        echo json_encode( $arreglo_leads_ventas_visitas , true );
        $this->autoRender = false;
    }

    /***
     * 
     * 
     * 
     * 
    */
    function grafica_costo_inversion_desarrollos(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
        $desarrollos_id ="";
        $medios_id      = "";
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $arreglo=array();
        $arreglo_costo_inversion=array();
        $i=0;
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            // $leads=$this->Cliente->find('all',array(
            //     'conditions'=>array(
            //         'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
            //         'Cliente.dic_linea_contacto_id <>'    => '',
            //         'Cliente.cuenta_id' => $cuenta_id,
            //         'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
            //         'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
            //         'Cliente.user_id <>'    => '',
            //         $cond_rangos,
            //     ),
            //       'fields' => array(
            //           'COUNT(Cliente.dic_linea_contacto_id) as lead',
            //           'Cliente.dic_linea_contacto_id'
            //       ),
            //       'group' =>'Cliente.dic_linea_contacto_id',
            //       'order'   => 'Cliente.dic_linea_contacto_id ASC',
            //       'contain' => false 
            //     )
            // );
            $leads=$this->Lead->find('all',array(
                'conditions'=>array(
                    'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                    'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                    $cond_rangos,
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
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
                AND publicidads.dic_linea_contacto_id IN ($medios_id) 
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
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
            foreach ($dic_linea_contacto as $dic) {
                foreach ($leads as $lead) {
                    if ($lead['Lead']['dic_linea_contacto_id']==$dic['DicLineaContacto']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        $arreglo[$i]['leads']=$lead[0]['lead'];
                        $arreglo[$i]['inversion']=0;
                        
                    }
                }
                foreach ($inversion as $inv) {
                    if ($dic['DicLineaContacto']['id']== $inv['dic_linea_contactos']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['leads']==0){
                            $arreglo[$i]['leads']=0;
                        }
                        $arreglo[$i]['inversion']=$inv[0]['inversion'];
                    }
                }
                $i++;
            }
            $i=0;
            foreach ($arreglo as $value) {
                $arreglo_inversion_leads[$i]['medio']=$value['medio'];
                $arreglo_inversion_leads[$i]['leads']=$value['leads'];
                if ($value['leads']==0) {
                    $arreglo_inversion_leads[$i]['costoXleads']=( empty($value['inversion']) ? 0  :  $value['inversion'] );
                }
                else{
                    $arreglo_inversion_leads[$i]['costoXleads']=(($value['inversion'])/($value['leads']));

                }
                $arreglo_inversion_leads[$i]['inversion']=( empty($value['inversion']) ? 0  :  $value['inversion'] );
                $i++;
            }
        }
         
        if (empty($arreglo_inversion_leads)) {
            $arreglo_inversion_leads[$i]['medio']       = 'sin informacion';
            $arreglo_inversion_leads[$i]['leads']       = 0;
            $arreglo_inversion_leads[$i]['costoXleads'] = 0;
            $arreglo_inversion_leads[$i]['inversion']   = 0;
        }
        echo json_encode( $arreglo_inversion_leads , true );
        exit();
        $this->autoRender = false;
    }

    /**
	 * 
	 * 
	 * 
	 * 
	*/
	function costo_leads_ventas_visitas(){
		header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
		$this->loadModel('Venta');
        $this->Venta->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
		$desarrollos_id ="";
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $arreglo=array();
        $i=0;
        $medios_id = 0;
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            
            $ventas = $this->Venta->query(
                "SELECT COUNT(*)AS venta, clientes.dic_linea_contacto_id
                FROM operaciones_inmuebles, clientes
                WHERE operaciones_inmuebles.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))
                AND operaciones_inmuebles.fecha >='$fi' 
                AND operaciones_inmuebles.fecha <='$ff'
                AND operaciones_inmuebles.cliente_id=clientes.id
                AND tipo_operacion=3
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                GROUP BY clientes.dic_linea_contacto_id;"
            );
            $visitas= $this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
                ,clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                AND dic_linea_contactos.id IN ($medios_id)
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
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
                ,clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND events.tipo_tarea =0
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio <= '$ff'
                GROUP BY clientes.dic_linea_contacto_id;"
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
            foreach ($dic_linea_contacto as $dic) {
                foreach ($citas as $cita) {
                    if ($dic['DicLineaContacto']['id']== $cita['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if(empty($cita[0]['citas']) OR $cita[0]['citas']<0){
                            $arreglo[$i]['citas']=0;
                        }else{
                            $arreglo[$i]['citas']=$cita[0]['citas'];
                        }
                        $arreglo[$i]['ventas']=0;        
                        $arreglo[$i]['visitas']=0;

                    }
                }
                foreach ($ventas as $venta) {
                    if ($dic['DicLineaContacto']['id']== $venta['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['citas']==0){
                            $arreglo[$i]['citas']=0;
                        }
                        $arreglo[$i]['ventas']=$venta[0]['venta'];
                    }    
                }
                foreach ($visitas as $visita) {
                    if ($dic['DicLineaContacto']['id']== $visita['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['citas']==0){
                            $arreglo[$i]['citas']=0;
                        }
                        if($arreglo[$i]['ventas']==0){
                            $arreglo[$i]['ventas']=0;
                        }
                        $arreglo[$i]['visitas']=$visita[0]['visita'];
                    }
                }
              
                $i++;
            }
            $i=0;
            foreach ($arreglo as $value) {
                $arreglo_inversion_leads[$i]['medio']=$value['medio'];
                $arreglo_inversion_leads[$i]['citas']=$value['citas'];
                $arreglo_inversion_leads[$i]['visitas']=( empty($value['visitas']) ? 0  :  $value['visitas'] );
                $arreglo_inversion_leads[$i]['ventas']=$value['ventas'];
                
                $i++;
            }
        }
        echo json_encode( $arreglo_inversion_leads , true );
        exit();
        $this->autoRender = false;
	}
    
    /**
     * 
     * 
     *  
     *     
    */
    function tabla_clientes_mk(){
        header('Content-type: application/json; charset=utf-8'); 
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Cliente');
        $this->Lead->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $clientes_activos              = [];
        $clientes_inactivos_temporales = [];
        $clientes_inactivos            = [];
        $arreglo                       = [];
        $response                      = [];
        $fecha_ini                     = '';
        $fecha_fin                     = '';
        $i                             = 0;
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if($this->request->is('post')){
            // $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_leads = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                }else{
                    $cond_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
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
                WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
                AND publicidads.dic_linea_contacto_id IN ($medios_id) 
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
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
            $clientes_activos=$this->Cliente->find('all',array(
                'conditions'=>array(
                        'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
                        'Cliente.dic_linea_contacto_id <>'    => '',
                        'Cliente.status'      => 'Activo',
                        'Cliente.cuenta_id' => $cuenta_id,
                        'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
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
            $clientes_inactivos_temporales=$this->Cliente->find('all',array(
                'conditions'=>array(
                        'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
                        'Cliente.dic_linea_contacto_id <>'    => '',
                        'Cliente.status'      => 'Inactivo temporal',
                        'Cliente.cuenta_id' => $cuenta_id,
                        'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
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
            $clientes_inactivos=$this->Cliente->find('all',array(
                'conditions'=>array(
                        'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
                        'Cliente.dic_linea_contacto_id <>'    => '',
                        'Cliente.status'      => 'Inactivo',
                        'Cliente.cuenta_id' => $cuenta_id,
                        'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
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
            foreach ($dic_linea_contacto as $dic) {
                foreach ($clientes_activos as $cliente_activo) {
                    if ($cliente_activo['Cliente']['dic_linea_contacto_id']==$dic['DicLineaContacto']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        $arreglo[$i]['activo']=$cliente_activo[0]['lead'];
                        $arreglo[$i]['leads'] =0;
                        $arreglo[$i]['temporales']=0;
                        $arreglo[$i]['inactivos']=0;
                        $arreglo[$i]['inversion']=0;
                    }
                }
                foreach ($clientes_inactivos_temporales as $cliente_inactivo_temporale) {
                    if ($cliente_inactivo_temporale['Cliente']['dic_linea_contacto_id']==$dic['DicLineaContacto']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];

                        if ($arreglo[$i]['activo']==0) {
                            $arreglo[$i]['activo']=0;
                        }
                        $arreglo[$i]['temporales']=$cliente_inactivo_temporale[0]['lead'];

                    }
                }
                foreach ($clientes_inactivos as $cliente_inactivo) {
                    if ($cliente_inactivo['Cliente']['dic_linea_contacto_id']==$dic['DicLineaContacto']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if ($arreglo[$i]['activo']==0) {
                            $arreglo[$i]['activo']=0;
                        }
                        if ($arreglo[$i]['temporales']==0) {
                            $arreglo[$i]['temporales']=0;
                        }
                        $arreglo[$i]['inactivos']=$cliente_inactivo[0]['lead'];
                    }
                }
                foreach ($inversion as $inv) {
                    if ($dic['DicLineaContacto']['id']== $inv['dic_linea_contactos']['id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if ($arreglo[$i]['activo']==0) {
                            $arreglo[$i]['activo']=0;
                        }
                        if ($arreglo[$i]['temporales']==0) {
                            $arreglo[$i]['temporales']=0;
                        }
                        if ($arreglo[$i]['inactivos']==0) {
                            $arreglo[$i]['inactivos']=0;
                        }
                        $arreglo[$i]['inversion']=$inv[0]['inversion'];
                    }
                }
                foreach ($leads as $lead) {
                    if ($dic['DicLineaContacto']['id']== $lead['Lead']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if ($arreglo[$i]['activo']==0) {
                            $arreglo[$i]['activo']=0;
                        }
                        if ($arreglo[$i]['temporales']==0) {
                            $arreglo[$i]['temporales']=0;
                        }
                        if ($arreglo[$i]['inactivos']==0) {
                            $arreglo[$i]['inactivos']=0;
                        }
                        if ($arreglo[$i]['inversion']==0) {
                            $arreglo[$i]['inversion']=0;
                        }
                        $arreglo[$i]['leads']=$lead[0]['lead'];
                    }
                }
                // $arreglo[$i]['totales'] =$cliente_activo[0]['lead'] + $arreglo[$i]['inactivos'];
                
                $i++;
            }
            $i=0;
            foreach ($arreglo as $value) {
                $response[$i]['medio']= ( empty($value['medio']) ? 0  :  $value['medio'] );
                $response[$i]['activo']= ( empty($value['activo']) ? 0  :  $value['activo'] );
                $response[$i]['leads']= ( empty($value['leads']) ? 0  :  $value['leads'] );
                $response[$i]['temporales']= ( empty($value['temporales']) ? 0  :  $value['temporales'] );
                $response[$i]['inactivos']= ( empty($value['inactivos']) ? 0  :  $value['inactivos'] );
                if ( $response[$i]['leads'] == 0 ) {
                    $response[$i]['costXmedio']='$'.number_format( $value['inversion'], 2);
                    $response[$i]['totalCostXmedio'] += $value['inversion'];
                }else{
                    $response[$i]['costXmedio']='$'.number_format( ($value['inversion']/($response[$i]['leads'] )), 2);
                    $response[$i]['totalCostXmedio'] +=$value['inversion']/($response[$i]['leads'] );
                }
                $response[$i]['inversion']= '$'.number_format( ( empty($value['inversion']) ? 0  :  $value['inversion'] ), 2);
                $inversionTotal +=  ( empty($value['inversion']) ? 0  :  $value['inversion'] );
                $response[$i]['inversion_total']= '$'.number_format($inversionTotal, 2);
                // $total += ;
                $response[$i]['tootal_clientes']  =($response[$i]['activo'] + $response[$i]['temporales'] + $response[$i]['inactivos']);
                $i++;
            }
            //{0: {…}, Cliente: {…}} 
            // 0: {…}, dic_linea_contactos: {…}}
            // DicLineaContacto{id: '1706', linea_contacto: 'Facebook'}
        }
        if (empty($response)) {
            $response[$i]['medio']='0';
            $response[$i]['activo']= 0;
            $response[$i]['leads']= 0;
            $response[$i]['temporales']=0;
            $response[$i]['inactivos']=0;
            $response[$i]['costXmedio']=0;
            $response[$i]['totalCostXmedio']=0;
            $response[$i]['inversion']= 0;
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
    function grafica_leads_clientes_leadsDuplicados(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
        $this->loadModel('Lead');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
        $this->Lead->Behaviors->load('Containable');
        $cuenta_id                         = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $arreglo                           = array();
        $arreglo_leads_duplicados_clientes = array();
        $desarrollos_id="";
        $medios_id="";
        $i=0;
        if($this->request->is('post')){
            $cuenta_id= $this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos_clientes = array("Cliente.created LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_clientes = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
 
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
            $clientes=$this->Cliente->find('all',array(
             'conditions'=>array(
                     'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
                     'Cliente.dic_linea_contacto_id <>'    => '',
                     // 'Cliente.status'      => 'Inactivo',
                     'Cliente.cuenta_id' => $cuenta_id,
                     'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
                     'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
                     'Cliente.user_id <>'    => '',
                     $cond_rangos_clientes,
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
         //    $clientes = $this->Lead->find('all',
         //        array(
         //            'conditions' => array(
         //                'Lead.desarrollo_id IN ('.$desarrollos_id.')',
         //                'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
         //                'Lead.dic_linea_contacto_id <>'    => '',
         //                'Lead.tipo_lead '=> 1,
         //                $cond_rangos
         //            ),
         //            'fields' => array(
         //                'COUNT(Lead.dic_linea_contacto_id) as clientes',
         //                'Lead.dic_linea_contacto_id'
         //            ),
         //            'group' =>'Lead.dic_linea_contacto_id',
         //            'order'   => 'Lead.dic_linea_contacto_id ASC',
         //            'contain' => false 
         //        )
         //    );
            $leads=$this->Lead->find('all',array(
                'conditions'=>array(
                    'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                    'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                    $cond_rangos,
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
            $leads_duplicado = $this->Lead->find('all',
                array(
                    'conditions' => array(
                        'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                        'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                        'Lead.dic_linea_contacto_id <>'    => '',
                        'Lead.tipo_lead '=> 2,
                        $cond_rangos
                    ),
                    'fields' => array(
                        'COUNT(Lead.dic_linea_contacto_id) as lead',
                        'Lead.dic_linea_contacto_id'
                    ),
                    'group' =>'Lead.dic_linea_contacto_id',
                    'order'   => 'Lead.dic_linea_contacto_id ASC',
                    'contain' => false 
                )
            );
            foreach ($dic_linea_contacto as $dic) {
                foreach ($leads as $lead) {
                    if ($dic['DicLineaContacto']['id']==$lead['Lead']['dic_linea_contacto_id']) {
                        $arreglo_leads_duplicados_clientes[$i]['medio']=$dic['DicLineaContacto']['linea_contacto']; 
                        $arreglo_leads_duplicados_clientes[$i]['leads']=$lead[0]['lead']; 
                        $arreglo_leads_duplicados_clientes[$i]['clientes']=0;
                        $arreglo_leads_duplicados_clientes[$i]['leads_duplicados']=0;
                    }
                }
                foreach ($clientes as $cliente) {
                    if ($dic['DicLineaContacto']['id']==$cliente['Cliente']['dic_linea_contacto_id']) {
                        $arreglo_leads_duplicados_clientes[$i]['medio']=$dic['DicLineaContacto']['linea_contacto']; 
                        if ($arreglo_leads_duplicados_clientes[$i]['leads']==0) {
                            $arreglo_leads_duplicados_clientes[$i]['leads']=0;
                        }
                        $arreglo_leads_duplicados_clientes[$i]['clientes']=$cliente[0]['clientes']; 
                          
                    }
                }
                foreach ($leads_duplicado as $duplicado) {
                    if ($dic['DicLineaContacto']['id']==$duplicado['Lead']['dic_linea_contacto_id']) {
                        $arreglo_leads_duplicados_clientes[$i]['medio']=$dic['DicLineaContacto']['linea_contacto']; 
                        if ($arreglo_leads_duplicados_clientes[$i]['leads']==0) {
                            $arreglo_leads_duplicados_clientes[$i]['leads']=0;
                        }
                        if ($arreglo_leads_duplicados_clientes[$i]['clientes']==0) {
                            $arreglo_leads_duplicados_clientes[$i]['clientes']=0;
                        }
                        $arreglo_leads_duplicados_clientes[$i]['leads_duplicados']=$duplicado[0]['lead']; 
                          
                    }
                }
                $i++;
            }
            $i=0;
            // ( empty($value['leads_duplicados'] ) ? 0  : $value['leads_duplicados']  )
            foreach ($arreglo_leads_duplicados_clientes as $value) {
                $arreglo[$i]['medio']=$value['medio']; 
                $arreglo[$i]['leads']= ( empty($value['leads'] ) ? 0  : $value['leads']  ); 
                $arreglo[$i]['clientes']= ( empty($value['clientes'] ) ? 0  : $value['clientes']  );
                $arreglo[$i]['leads_duplicados']= ( empty($value['leads_duplicados'] ) ? 0  : $value['leads_duplicados']  );
                $i++;
            }
            
        }
        if (empty($arreglo)) {
            $arreglo[$i]['medio']='sin informacion'; 
            $arreglo[$i]['leads']= 0; 
            $arreglo[$i]['clientes']=0;
            $arreglo[$i]['leads_duplicados']=0;
 
        }
        echo json_encode( $arreglo , true );
        exit();
        $this->autoRender = false;   
    }
     /**
     * 
     * roberto
     * 
    */
    function tabla_clientes_leads_duplicados(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('DicLineaContacto'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
		$this->loadModel('Venta');
        $this->Venta->Behaviors->load('Containable');
        $this->Lead->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
		$desarrollos_id ="";
        $medios_id="";
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $arreglo=array();
        $clientes_json = [];
        $i=0;
        // $desarrollos_id='246';
        // $medios_id='1752, 1720, 1715, 1706, 1716, 1733, 1739, 1707, 1717, 1708, 1714, 1719, 1718, 1734';
        $count         = 0;
        $limpieza      = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "�");

        $date_current      = date('Y-m-d');
        $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
        $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
        $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:m:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:m:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                    $cond_leads = array("Lead.fecha LIKE '".$fi."%'");

                }else{
                    $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));

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
            foreach($this->request->data['medio_id'] as $medio){
                $medios_id = $medios_id.$medio.",";
            } 
            $medios_id = substr($medios_id,0,-1);
            $leads_duplicado = $this->Lead->find('all',
                array(
                    'conditions' => array(
                        'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                        'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                        'Lead.dic_linea_contacto_id <>'    => '',
                        'Lead.tipo_lead '=> 2,
                        $cond_leads
                    ),
                    'fields' => array(
                        'Lead.cliente_id'
                    ),
                    'group' =>'Lead.cliente_id',
                    'contain' => false 
                )
            );
            $id_clientes = "";
            foreach( $leads_duplicado as $id ){
                $id_clientes.= $id['Lead']['cliente_id'] .",";
            }
            $id_clientes = substr($id_clientes,0,-1);
            $clientesSearch = $this->Cliente->find('all',
                array(
                    'conditions' => array(
                        'Cliente.id IN ('.$id_clientes.')',
                        'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
                        'Cliente.dic_linea_contacto_id <>'    => '',
                        'Cliente.cuenta_id' => $cuenta_id,
                        'Cliente.dic_linea_contacto_id IN ('.$medios_id.')',
                        'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
                        'Cliente.user_id <>'    => '',
                        // $cond_rangos,
                    ),
                    'fields' => array(
                        'nombre',
                        'created',
                        'correo_electronico',
                        'telefono1',
                        'last_edit',
                        'status',
                        'etapa',
                        'id',                    
                    ),
                    'contain' => array(
                        'Desarrollo' => array(
                            'fields' => array(
                                'id',
                                'referencia',
                                'nombre'
                            )
                        ),
                        'DicLineaContacto' => array(
                            'fields' => 'linea_contacto'
                        ),
                        'User' => array(
                            'fields' => array(
                                'id',
                                'nombre_completo'
                            )
                        ),
                    )                    
                )
            );
            $count=0;
            foreach ($clientesSearch as $cliente) {
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
                    "<a href='".Router::url('/clientes/view/'.$cliente['Cliente']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $cliente['Cliente']['nombre']))."</a>",
                    rtrim(str_replace( $limpieza, "", $cliente['Desarrollo']['referencia'])).' '.rtrim(str_replace( $limpieza, "", $cliente['Desarrollo']['nombre'])),
                    rtrim(str_replace($limpieza, "", $cliente['DicLineaContacto']['linea_contacto'])),
                    rtrim(str_replace($limpieza, "", $cliente['Cliente']['correo_electronico'])),
                    rtrim(str_replace($limpieza, "", $cliente['Cliente']['telefono1'])),
                    date('Y-m-d', strtotime($cliente['Cliente']['created'])),
                    date('Y-m-d', strtotime($cliente['Cliente']['last_edit'])),
                    "<a href='".Router::url('/users/view/'.$cliente['User']['id'], true)."' target='Blank'>".rtrim(str_replace( $limpieza, "", $cliente['User']['nombre_completo']))."</a>",
                );
                $count++;
            }
        }
        // $fi='2022-01-01 00:00:00';
        // $ff='2022-11-11 23:59:59';
        // $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
        // $cond_leads = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
       
        echo json_encode( $clientes_json , true );
        exit();
        $this->autoRender = false;
    }

    /***
     * 
     *  
     * 
     * 
    */  
    function leads_duplicados(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Lead');
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->Lead->Behaviors->load('Containable');
        $response=array();
        $i=0;
        $duplicado=array();
        $desarrollo='';
        $j=0;
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

        
        $leads_duplicado=$this->Lead->find('all',array(
            'conditions'=>array(
                'Lead.desarrollo_id IN ('.$desarrollo.')',
                'Lead.dic_linea_contacto_id <>'    => '',
              ),
              'fields' => array(
                  'COUNT(Lead.cliente_id) as duplicado',
                  'Lead.cliente_id',
                  
              ),
              'group'   =>'Lead.cliente_id',
              'contain' => false 
            )
        );
        foreach ($leads_duplicado as $lead) {
            if ($lead[0]['duplicado']>1) {
                $duplicado[$i]['dupli']=$lead['Lead']['cliente_id'];
                $i++;
            }  
            else if ($lead[0]['duplicado']==1) {

                $normales[$j]['normal']= $lead['Lead']['cliente_id'];
                $j++;
            }   
            
        }
        $i=0;
        foreach ($duplicado as $value) {
            $leads_du[$i]=$this->Lead->find('first',array(
                'conditions'=>array(
                    'Lead.cliente_id IN ('.$value['dupli'].')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                ),
                'fields' => array(
                    'Lead.cliente_id',
                    'Lead.id',
                    'Lead.dic_linea_contacto_id',
                    'Lead.fecha',                    
                    'Lead.tipo_lead',                    
                ),
                'contain' => false 
                )
            );
            $i++;
        }
        $i=0;
        foreach ($leads_du as $value) {
        
            // $this->Lead->query(
            //     "UPDATE leads 
            //     SET leads.tipo_lead = 1
            //     WHERE leads.cliente_id = '.$value['Lead']['cliente_id']'.
            //     AND leads.dic_linea_contacto_id = '.$value['Lead']['dic_linea_contacto_id']'. 
            //     AND leads.fecha = '.$value['Lead']['fecha'].'
            //     "
            // ); 
            $this->request->data['Lead']['id']=$value['Lead']['id'];
            $this->request->data['Lead']['cliente_id']=$value['Lead']['cliente_id'];
            $this->request->data['Lead']['fecha']=$value['Lead']['fecha'];
            $this->request->data['Lead']['dic_linea_contacto_id']=$value['Lead']['dic_linea_contacto_id'];
            $this->request->data['Lead']['tipo_lead']=1;
            $this->Lead->save($this->request->data['Lead']);


            $i++;

        }
        // {"Lead":{"cliente_id":"45783","dic_linea_contacto_id":"1706","fecha":"2021-11-24 00:51:07","tipo_lead":"2"}
        $i=0;
        foreach ($normales as  $value) {
            $lead[$i]=$this->Lead->find('first',array(
                'conditions'=>array(
                    'Lead.cliente_id IN ('.$value['normal'].')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                ),
                'fields' => array(
                    'Lead.cliente_id',
                    'Lead.id',
                    'Lead.dic_linea_contacto_id',
                    'Lead.fecha',                    
                    'Lead.tipo_lead',                    
                ),
                'contain' => false 
                )
            );
            $i++;
        }
        foreach ($lead as $value) {
            $this->request->data['Lead']['id']=$value['Lead']['id'];
            $this->request->data['Lead']['cliente_id']=$value['Lead']['cliente_id'];
            $this->request->data['Lead']['fecha']=$value['Lead']['fecha'];
            $this->request->data['Lead']['dic_linea_contacto_id']=$value['Lead']['dic_linea_contacto_id'];
            $this->request->data['Lead']['tipo_lead']=1;
            $this->Lead->save($this->request->data['Lead']);
        }
        // "0":{"Lead":{"cliente_id":"45139","dic_linea_contacto_id":"1708","fecha":"2021-11-07 05:02:36","tipo_lead":"2"}
        echo json_encode( $leads_du , true );
        exit();
        $this->autoRender = false; 
    }    

    /**
     * Cremos el metodo para el reenvio de desarrollos al cliente,
     * Proceso para el reenvio:
     * 1.- Tomar las configuraciones de paramconfig y mailconfig.
     * 2.- Guardar en log_desarrollo.
     * 3.- Actualizamos el last_edit del cliente.
     * 4.- Enviamos los correos con los desarrollos seleccionados.
     * 5.- Creamos log_cliente
     * 21/dic/2022 AKA "SAAK"
    */
    public function resend_mail_desarrollo() {
        date_default_timezone_set('America/Chihuahua');
        $response = array(
            'flag' => false,
            'message' => 'Ha ocurrido un problema en el reenvío del desarrollo.'
        );

        if ($this->request->is('post')) {
            
            // Step 1
                $mailconfig  = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                $paramconfig = $this->Paramconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id'));
                $cliente     = $this->Cliente->read(null, $this->request->data['cliente_id'] );
                $usuario     = $this->User->read(null, $this->request->data['user_id']);
                $desarrollos = $this->Desarrollo->find('all',array('conditions'=>array("Desarrollo.id " =>  $this->request->data['desarrollo_id'])));
            // End Step 1
    
            // Step 2
                $this->request->data['LogDesarrollo']['desarrollo_id'] = $this->request->data['desarrollo_id'];
                $this->request->data['LogDesarrollo']['mensaje']       = "Reenvío de Desarrollo";
                $this->request->data['LogDesarrollo']['usuario_id']    = $this->Session->read('Auth.User.id');
                $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d H:i:s');
                $this->request->data['LogDesarrollo']['accion']        = 5;
                $this->LogDesarrollo->create();
                $this->LogDesarrollo->save($this->request->data);
            // End Step 2
    
            // Step 3
                $this->request->data['Cliente']['id']         = $this->request->data['cliente_id'];
                $this->request->data['Cliente']['last_edit']  = date('Y-m-d H:m:i');
                $this->Cliente->save($this->request->data);
            // End Step 3
    
            // Step 4
                $this->Email = new CakeEmail();
                $this->Email->config(array(
                    'host'      => $mailconfig['Mailconfig']['smtp'],
                    'port'      => $mailconfig['Mailconfig']['puerto'],
                    'username'  => $mailconfig['Mailconfig']['usuario'],
                    'password'  => $mailconfig['Mailconfig']['password'],
                    'transport' => 'Smtp'
                    )
                );
    
                if ($paramconfig['Paramconfig']['cc_a_c'] != ""){
                    $emails2 = explode( ",", $paramconfig['Paramconfig']['cc_a_c'] );
                    
                    $arreglo_emails2 = array();
    
                    if (sizeof($emails2) > 0){
                        foreach($emails2 as $email):
                            $arreglo_emails2[$email] = $email;
                        endforeach;
                    }else{
                        $arreglo_emails2[$paramconfig['Paramconfig']['cc_a_c']] = $paramconfig['Paramconfig']['cc_a_c'];
                    }
                    $this->Email->cc($arreglo_emails2);
                }
    
                $this->Email->from(array($usuario['User']['correo_electronico'] => $usuario['User']['nombre_completo']));
                $this->Email->to($cliente['Cliente']['correo_electronico']);
                $this->Email->subject($paramconfig['Paramconfig']['smessage_new_desarrollo']);
                $this->Email->emailFormat('html');
                $this->Email->viewVars(array('cliente' => $cliente, 'desarrollos'=>$desarrollos,'usuario'=>$usuario,'body_message'=> $paramconfig['Paramconfig']['bmessage_seg_cliente_desarrollo'], 'rds_sociales' => $this->Session->read('CuentaUsuario') ));
    
                $this->Email->template('emailaclientedesarrollos','layoutinmomail');
                $this->Email->send();
            // End step 4
    
            // Step 5
                $this->Agenda->create();
                $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']    = "Se reenvían desarrollos a cliente";
                $this->request->data['Agenda']['cliente_id'] = $this->request->data['cliente_id'];
                $this->Agenda->save($this->request->data);
                $this->LogCliente->create();
    
                $this->request->data['LogCliente']['id']         = uniqid();
                $this->request->data['LogCliente']['cliente_id'] = $this->request->data['cliente_id'];
                $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                $this->request->data['LogCliente']['mensaje']    = "Reenvío de mail";
                $this->request->data['LogCliente']['accion']     = 3;
                $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
                $this->LogCliente->save($this->request->data);
            // End Step 5
            
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha reenviado correctamente el desarrollo.', 'default', array(), 'm_success');

            $response = array(
                'flag' => true,
                'message' => 'Se ha reenviado correctamente el desarrollo.'
            );

        }

        echo json_encode( $response );
        exit();

        $this->autoRender = false;


    }

/**
   *09/01/2023 
   * aka rogueOne
   * es una api para la asigancion de los inmuebles antes de la cotizacion 
  */
  function inmueble_asig(){
    header('Content-type: application/json; charset=utf-8');
    $this->loadModel('DesarrolloInmueble');
    $this->Cliente->Behaviors->load('Containable');
    $this->Inmueble->Behaviors->load('Containable');
    $this->User->Behaviors->load('Containable');
    $this->DesarrolloInmueble->Behaviors->load('Containable');

    $cliente     = array();
    $response = array(
        'flag'    => false,
        'message' => 'El cliente ya tiene asignada la propiedad.'
      );
    $leads_exist = array();

    if($this->request->is('post')){

      if( !empty($this->request->data['cliente_id']) ){
        $cliente_id = $this->request->data['cliente_id'];
      }
      if( !empty($this->request->data['inmueble_id']) ){
        $inmueble_id = $this->request->data['inmueble_id'];
      }

      $cliente = $this->Cliente->find('all',array(
          'conditions' => array(
            'Cliente.id' => $cliente_id
          ),
          
        'fields' => array(
          'Cliente.id',
          'Cliente.nombre'
        ),
        'contain' => false 
      ));

      $leads_exist=$this->Lead->find('first',array(
        'conditions'=>array(
            'Lead.cliente_id '    => $cliente_id,
            'Lead.inmueble_id '   => $inmueble_id,
          ),
          'fields' => array(
              'Lead.cliente_id',  
          ),
          'contain' => false 
        )
      );
      $desarrollo_id = $this->DesarrolloInmueble->find('first',array(
        'conditions'=>array(
          'DesarrolloInmueble.inmueble_id ' => $inmueble_id,
        ),
        'fields' => array(
            'DesarrolloInmueble.desarrollo_id',  
        ),
        'contain' => false 
      ));

      if( !empty($this->request->data['email_user']) ){
        $email = $this->request->data['email_user'];
      }

      $user_id = $this->User->find('all',array(
        'conditions'=>array(
          'User.correo_electronico '    => $email,
        ),
        'fields' => array(
          'User.id',
        ),
        'contain' => false 
      ));

      if (empty($leads_exist)) {
        
        $this->LogInmueble->create();
        $this->request->data['LogInmueble']['mensaje']     = "Envío de propiedad a cliente: ".$cliente[0]['Cliente']['nombre'] ;
        $this->request->data['LogInmueble']['usuario_id']  = $user_id[0]['User']['id'];
        $this->request->data['LogInmueble']['fecha']       = date('Y-m-d H:i:s');
        $this->request->data['LogInmueble']['accion']      = 9;
        $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
        $this->LogInmueble->save($this->request->data);

        $this->Lead->create();
        $this->request->data['Lead']['id']            = null;
        $this->request->data['Lead']['cliente_id']    = $cliente[0]['Cliente']['id'];
        $this->request->data['Lead']['inmueble_id']   = $inmueble_id;
        $this->request->data['Lead']['status']        = 'Abierto';
        $this->request->data['Lead']['desarrollo_id'] = $desarrollo_id['DesarrolloInmueble']['desarrollo_id'];
        $this->request->data['Lead']['tipo_lead']     = '3';
        $this->request->data['Lead']['fecha']         = date('Y-m-d H:i:s');
        $this->Lead->save($this->request->data);

        //Registrar Seguimiento Rápido
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $user_id[0]['User']['id'];
        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']    = "Envío de propiedad ";
        $this->request->data['Agenda']['cliente_id'] = $cliente[0]['Cliente']['id'];
        $this->Agenda->save($this->request->data);

        
        $response = array(
          'flag'    => true,
          'message' => 'Se asigno correctamente la propiedad al cliente.'
        );

      }

    }
    echo json_encode( $response, true );
    exit();
    $this->autoRender = false;

  }

    function grafica_ventas_linea_contacto_user_view(){
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Venta');
        $this->loadModel('Lead');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->Lead->Behaviors->load('Containable');
        $this->Venta->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $and = [];
        $or  = [];
        if ($this->request->is('post')) {
            $cuenta_id= $this->request->data['cuenta_id'];
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty($this->request->data['rango_fechas']) ){
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.fecha_cambio_etapa LIKE '".$fi."%'");
                    // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
                    $cond_rangos_ventas = array("Venta.fecha LIKE '".$fi."%'");

                }else{
                    // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos = array("Cliente.fecha_cambio_etapa BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_ventas=array("Venta.fecha BETWEEN ? AND ?" => array($fi, $ff));
                }
            }
            // Condicion para el asesor id.
            if( !empty( $this->request->data['user_id'] ) ){
                $user_id=$this->request->data['user_id'];
                array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
            }
            // $condiciones = array(
            //     'AND' => $and,
            //     'OR'  => $or
            // );
            $leads=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.user_id' =>$user_id,
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    // 'Cliente.cuenta_id' => $cuenta_id,
                    // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
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
            
            // $leads=$this->Lead->find('all',array(
            //     'conditions'=>array(
            //         'Lead.cliente_id IN (SELECT id FROM clientes WHERE user_id IN ('.$user_id.'))',
            //         'Lead.dic_linea_contacto_id <>'    => '',
            //         $cond_rangos,
            //     ),
            //     'fields' => array(
            //         'COUNT(Lead.dic_linea_contacto_id) as lead',
            //         'Lead.dic_linea_contacto_id'
            //     ),
            //     'group' =>'Lead.dic_linea_contacto_id',
            //     'order'   => 'Lead.dic_linea_contacto_id ASC',
            //     'contain' => false 
            //     )
            // );
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.user_id=$user_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );  
            $ventas= $this->User->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS venta ,clientes.dic_linea_contacto_id
                FROM operaciones_inmuebles, clientes
                WHERE clientes.id = operaciones_inmuebles.cliente_id
                and clientes.user_id=$user_id
                and operaciones_inmuebles.tipo_operacion=3
                -- AND  operaciones_inmuebles.fecha >= '$fi' 
                -- AND  operaciones_inmuebles.fecha <= '$ff'
                GROUP BY clientes.dic_linea_contacto_id;"
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
            $arreglo_ventas=array();
            $i=0;
            foreach ($dic_linea_contacto as $value_dic) {
                foreach ($leads as  $value_lead) {
                    if ($value_dic['DicLineaContacto']['id'] == $value_lead['Cliente']['dic_linea_contacto_id']) {
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
                // [{"DicLineaContacto":{"id":"1706","linea_contacto":"Facebook"}
                //"0":{"lead":"1"},"Lead":{"dic_linea_contacto_id":"2"}
                //{"0":{"venta":"1"},"clientes":{"dic_linea_contacto_id":"4"}
                //{"Publicidad":{"inversion_prevista":"6500","dic_linea_contacto_id":"36"}
            }
            $i=0;
            $leads_ventas=array();
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
            $leads_ventas[$i]['medio']="medio";
            $leads_ventas[$i]['leads']=0;
            $leads_ventas[$i]['inversion']=0;
            $leads_ventas[$i]['ventas']=0;
        }
        // $fi='2022-01-01 00:00:00';
        // $ff='2022-11-11 23:59:59';
        // $user_id=626;
        // $cond_rangos = array('Lead.fecha BETWEEN ? AND ?'=> array($fi, $ff));
        
        echo json_encode( $leads_ventas, true );
        exit();
        $this->autoRender = false;
    }

    /***
     * 
     * 
     * 
    */
    function leads_ventas_inversion_vista_desarrollo(){
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Venta');
        $this->loadModel('Lead');
        $this->loadModel('Cliente');
        $this->Cliente->Behaviors->load('Containable');
        $this->Lead->Behaviors->load('Containable');
        $this->Venta->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $and = [];
        $or  = [];
        if ($this->request->is('post')) {
            $cuenta_id= $this->request->data['cuenta_id'];
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty($this->request->data['rango_fechas']) ){
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.last_edit LIKE '".$fi."%'");
                    // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
                    $cond_rangos_ventas = array("Venta.fecha LIKE '".$fi."%'");

                }else{
                    // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos = array("Cliente.last_edit BETWEEN ? AND ?" => array($fi, $ff));

                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_ventas=array("Venta.fecha BETWEEN ? AND ?" => array($fi, $ff));
                }
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
                array_push($and, array('Cliente.desarrollo_id' => $desarrollo_id ));

            }
              // Condicion para el asesor id.
            // if( !empty( $this->request->data['user_id'] ) ){
            //     array_push($and, array('Cliente.user_id' => $this->request->data['user_id'] ));
            // }
            $condiciones = array(
                'AND' => $and,
                'OR'  => $or
            );
            $leads=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.desarrollo_id' =>$desarrollo_id,
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    // 'Cliente.cuenta_id' => $cuenta_id,
                    // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
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
            // $leads=$this->Lead->find('all',array(
            //     'conditions'=>array(
            //         'Lead.desarrollo_id' =>$desarrollo_id,
            //         'Lead.dic_linea_contacto_id <>'    => '',
            //         $cond_rangos,
            //       ),
            //       'fields' => array(
            //           'COUNT(Lead.dic_linea_contacto_id) as lead',
            //           'Lead.dic_linea_contacto_id'
            //       ),
            //       'group'   =>'Lead.dic_linea_contacto_id',
            //       'order'   => 'Lead.dic_linea_contacto_id ASC',
            //       'contain' => false 
            //     )
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
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );    
            $ventas= $this->User->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS venta ,clientes.dic_linea_contacto_id
                FROM ventas, clientes
                WHERE ventas.inmueble_id in( select inmueble_id from desarrollo_inmuebles where desarrollo_id = '$desarrollo_id')
                and ventas.cuenta_id = $cuenta_id
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
                //   {"0":{"lead":"159"},"Lead":{"dic_linea_contacto_id":"1706"}
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
                $leads_ventas[$i]['leads']     = ( empty($value['leads']) ? 0 : $value['leads'] );
                $leads_ventas[$i]['inversion'] =( empty($value['inversion']) ? 0 : $value['inversion'] );
                $leads_ventas[$i]['ventas']    = ( empty($value['ventas']) ? 0 : $value['ventas'] );
                $i++;
            }
            
        }
        if (empty($leads_ventas)) {
            $leads_ventas[$i]['medio']="medio";
            $leads_ventas[$i]['leads']=0;
            $leads_ventas[$i]['inversion']=0;
            $leads_ventas[$i]['ventas']=0;
        }
        echo json_encode( $leads_ventas, true );
        exit();
        $this->autoRender = false;
    }
    /**
     * 
     * 
     * 
    */
    function leads_visitas_inversion_vista_desarrollo(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Publicidad');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Cliente');
        $this->loadModel('Event');
        $this->Event->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $this->Publicidad->Behaviors->load('Containable');
        $i=0;
        $arreglo_leads_visitas=array();
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if ($this->request->is('post')) {
            $cuenta_id= $this->request->data['cuenta_id'];
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Cliente.last_edit LIKE '".$fi."%'");
                    // $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio LIKE '".$fi."%'");
                    $cond_rangos_ventas = array("Event.fecha_inicio LIKE '".$fi."%'");

                }else{
                    // $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos = array("Cliente.last_edit BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_publicidad = array("Publicidad.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_rangos_event=array("Event.fecha_inicio BETWEEN ? AND ?" => array($fi, $ff));
                }
            }
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            $leads=array();
            $i=0;
            $aux=0;
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
            // $leads_clien=$this->Lead->find('all',array(
            //     'conditions'=>array(
            //         'Lead.desarrollo_id' =>$desarrollo_id,
            //         'Lead.dic_linea_contacto_id <>'    => '',
            //         $cond_rangos,
            //       ),
            //       'fields' => array(
            //           'COUNT(Lead.dic_linea_contacto_id) as lead',
            //           'Lead.dic_linea_contacto_id'
            //       ),
            //       'group' =>'Lead.dic_linea_contacto_id',
            //       'order'   => 'Lead.dic_linea_contacto_id ASC',
            //       'contain' => false 
            //     )
            // );
            $leads_clien=$this->Cliente->find('all',array(
                'conditions'=>array(
                    'Cliente.desarrollo_id' =>$desarrollo_id,
                    'Cliente.dic_linea_contacto_id <>'    => '',
                    'Cliente.cuenta_id' => $cuenta_id,
                    // 'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',        
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
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.id
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $events= $this->Event->query(
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
            foreach ($dic_linea_contacto as $value_dic) {
                foreach ($leads_clien as $lead) {
                    if ($value_dic['DicLineaContacto']['id'] == $lead['Cliente']['dic_linea_contacto_id']) {
                        $leads[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                        $leads[$i]['leads']=$lead[0]['lead'];
                        $leads[$i]['inversion']=0;
                        $leads[$i]['visita']=0;
                    }
                }  //   {"0":{"lead":"159"},"Lead":{"dic_linea_contacto_id":"1706"}
                foreach ($inversion as $inver) {
                    if ($value_dic['DicLineaContacto']['id']==$inver['dic_linea_contactos']['id']) {
                        $leads[$i]['medio']     = $value_dic['DicLineaContacto']['linea_contacto'];
                        $leads[$i]['inversion'] = $inver[0]['inversion'];
                        if ( $leads[$i]['leads'] == 0) {
                            $leads[$i]['leads'] = 0;
                        }
    
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
                // foreach ($events_inmuble as $value) {
                //     if ($value_dic['DicLineaContacto']['id']==$value['clientes']['dic_linea_contacto_id']) {
                //         $leads[$i]['medio']=$value_dic['DicLineaContacto']['linea_contacto'];
                //         if ( $leads[$i]['leads'] == 0) {
                //             $leads[$i]['leads'] = 0;
                //         }
                //         if (  $leads[$i]['inversion']==0) {
                //             $leads[$i]['inversion']=0;
                //         }
                       
                //         $leads[$i]['visita'] += $value[0]['visita'];
                //     }
                // }
                $i++;
            }
            $i=0;
            $arreglo_leads_visitas=array();
            foreach ($leads as  $value) {
                
                $arreglo_leads_visitas[$i]['medio']     = $value['medio'];
                $arreglo_leads_visitas[$i]['leads']     = ( empty($value['leads']) ? 0 : $value['leads'] );
                $arreglo_leads_visitas[$i]['inversion'] = ( empty($value['inversion']) ? 0 : $value['inversion'] );
                $arreglo_leads_visitas[$i]['visitas']   = ( empty($value['visita']) ? 0 : $value['visita'] );
                $i++;
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
    /***
     * 
     * rogue and  EMC 
    */
    function homodic(){
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

            foreach ($desarrollo_id as $value) {
                $clientes=$this->Cliente->find('all',array(
                'conditions'=>array(
                        'Cliente.desarrollo_id' => $value['Desarrollo']['id'],
                        'Cliente.dic_linea_contacto_id' => '43'
                    ),
                    'fields' => array(
                        'Cliente.id',
                        'Cliente.dic_linea_contacto_id',
                        'Cliente.desarrollo_id'
                ),
                'contain' => false
                ));
                foreach ($clientes as $cliente) {

                    $this->request->data['Cliente']['id']                    = $cliente['Cliente']['id'];
                    $this->request->data['Cliente']['dic_linea_contacto_id'] = $dic_linea_contacto_f[0]['DicLineaContacto']['id'];
                    $this->Cliente->save($this->request->data['Cliente']);
                }
            }

            foreach ($desarrollo_id as  $value) {
                $clientes=$this->Cliente->find('all',array(
                'conditions'=>array(
                        'Cliente.desarrollo_id' => $value['Desarrollo']['id'],
                        'Cliente.dic_linea_contacto_id' => '46'
                    ),
                    'fields' => array(
                        'Cliente.id',
                        'Cliente.dic_linea_contacto_id',
                        'Cliente.desarrollo_id'
                ),
                'contain' => false
                ));
                foreach ($clientes as $cliente) {
                        $this->request->data['Cliente']['id']                    = $cliente['Cliente']['id'];
                        $this->request->data['Cliente']['dic_linea_contacto_id'] = $dic_linea_contacto_i[0]['DicLineaContacto']['id'];
                        $this->Cliente->save($this->request->data['Cliente']);
                }
            }

            foreach($desarrollo_id as $lead):

                $leads=$this->Lead->find('all',array(
                    'conditions'=>array(
                            'Lead.desarrollo_id' => $lead['Desarrollo']['id'],
                            'Lead.dic_linea_contacto_id' => '43'
                        ),
                        'fields' => array(
                            'Lead.id',
                            'Lead.cliente_id',
                            'Lead.dic_linea_contacto_id',
                            'Lead.desarrollo_id'
                    ),
                    'contain' => false
                ));
                foreach ($leads as $value) {

                    $this->request->data['Lead']['id']                 = $value['Lead']['id'];
                    $this->request->data['Lead']['dic_linea_contacto_id'] = $dic_linea_contacto_f['DicLineaContacto']['id'];
                    $this->Lead->save($this->request->data['Lead']);
                }
            endforeach;

            foreach($desarrollo_id as $lead):

                $leads=$this->Lead->find('all',array(
                    'conditions'=>array(
                            'Lead.desarrollo_id' => $lead['Desarrollo']['id'],
                            'Lead.dic_linea_contacto_id' => '46'
                        ),
                        'fields' => array(
                            'Lead.id',
                            'Lead.dic_linea_contacto_id',
                            'Lead.desarrollo_id'
                    ),
                    'contain' => false
                ));
                foreach ($leads as  $value) {

                        $this->request->data['Lead']['id']                 = $value['Lead']['id'];
                        $this->request->data['Lead']['dic_linea_contacto_id'] = $dic_linea_contacto_i['DicLineaContacto']['id'];
                        $this->Lead->save($this->request->data['Lead']);
                }

            endforeach;
        
            foreach($desarrollo_id as $desarrollo):
                $leads=$this->Lead->find('all',array(
                    'conditions'=>array(
                            'Lead.desarrollo_id' => $desarrollo['Desarrollo']['id'],
                            'Lead.dic_linea_contacto_id =' => null,
                            'Lead.status !=' => 'Aprobado',
                            'Lead.status !=' => 'Cerrado'
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
                    $clientes_=$this->Cliente->find('all',array(
                        'conditions'=>array(
                                'Cliente.id' => $value['Lead']['cliente_id'],
                            ),
                            'fields' => array(
                                'Cliente.id',
                                'Cliente.dic_linea_contacto_id',
                                'Cliente.desarrollo_id'
                        ),
                        'contain' => false
                    ));
                    foreach ($clientes_ as $value_) {
                        if ($value['Lead']['status'] != 'Cerrado' && $value['Lead']['status'] != 'Aprobado' && $value['Lead']['dic_linea_contacto_id'] == null ) {
                            $this->request->data['Lead']['id']                 = $value['Lead']['id'];
                            $this->request->data['Lead']['cliente_id']                 = $value['Lead']['cliente_id'];
                            $this->request->data['Lead']['dic_linea_contacto_id'] = $value_['Cliente']['dic_linea_contacto_id'];
                            $this->Lead->save($this->request->data['Lead']);
                        }
                }
            }
            endforeach;
            
            $response = array(
                'Ok' => true,
                'mensaje' => 	'listo E=MC'
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



}
