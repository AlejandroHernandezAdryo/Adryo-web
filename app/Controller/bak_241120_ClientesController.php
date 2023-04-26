<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController {

/**
 * Components
 *
 * @var array
 */

// Return para los eventos 0 => calendario, 1=> clientes/view, 2=> dashboard
// 0=> Cita, 1=> Visita, 2=> Llamada, 3=> Correo, 4=> Reactivacion - Events
// 1 => Creación, 2 => Edición, 3 => Mail, 4 => Llamada, 5 => Cita, 6 => Mensaje, 7 => Generación de Lead 8 => Borrado de venta, 9 => Reactivación, 10=>Visita, 11=>WhatsApp - LogCliente
// 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogInmueble
// 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita, 8=>Asignacion a cliente - LogDesarrollo

    public $components = array('Paginator');
    public $uses = array(
            'Cliente','Inmueble','Agenda','Lead','Opcionador','Desarrollo',
            'User','Contacto','Event','DicTipoCliente','DicEtapa',
            'DicLineaContacto','LogCliente','DicTipoPropiedad','LogDesarrollo','LogInmueble','Mailconfig',
            'Venta','Transaccion', 'Factura','MailConfig', 'Paramconfig', 'Cuenta'
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
            
            $this->Auth->allow(array('reactivar','get_clientes', 'get_clientes_detalle', 'get_log_cliente', 'get_lead_cliente_desarrollo', 'get_lead_cliente_inmueble','get_agenda_cliente', 'clientes_params', 'get_cliente_update', 'get_llamdas_cliente', 'get_add_cliente', 'get_options_props', 'get_status_update', 'get_cambio_temp','add_cliente','validar_linea_contacto', 'set_cambio_estado', 'set_add_whatsapp', 'get_pipeline', 'get_filtro_pipeline', 'filtro_pipeline'));
        }
/**
 * index method
 *
 * @return void
 */
    
        function cambio_temp(){
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
            $cuenta = '';
            $this->Cliente->Behaviors->load('Containable');

            // En el post
            if ($this->request->is('post')) {

                // Post para el desarrollador
                if ( $this->Session->read('Permisos.Group.id') == 5 ) {
                    $cuenta       = array('Desarrollo.id' => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),);
                }else {

                  $cuenta = array(
                    'OR' => array(
                      'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                      'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    ),
                  );

                }

                $all_clientes = array();
                if ($this->Session->read('Permisos.Group.call')!=1){
                    $all_clientes = array('Cliente.user_id'=>$this->Session->read('Auth.User.id'));
                }
                $nombre_cliente     = $this->request->data['Cliente']['nombre'];
                $correo_electronico = $this->request->data['Cliente']['correo_electronico'];
                $telefono           = $this->request->data['Cliente']['telefono'];

                $like_conditions = array();
                if ($nombre_cliente != "" || !empty($nombre_cliente)){
                  array_push($like_conditions,['Cliente.nombre LIKE "%'.$nombre_cliente.'%"']);
                }

                if ($correo_electronico != "" || !empty($correo_electronico)){
                  array_push($like_conditions,['Cliente.correo_electronico LIKE "%'.$correo_electronico.'%"']);
                }

                if ($telefono != "" || !empty($telefono)){
                  array_push($like_conditions,['Cliente.telefono1 LIKE "%'.$telefono.'%"','Cliente.telefono2 LIKE "%'.$telefono.'%"']);
                }

                $tipo_cliente   = $this->request->data['Cliente']['tipos_clientes'];
                $status         = $this->request->data['Cliente']['estatus_cliente'];
                $etapa          = $this->request->data['Cliente']['etapa_cliente'];
                $forma_contacto = $this->request->data['Cliente']['forma_contacto'];
                $asesor         = $this->request->data['Cliente']['asesor'];
                $rango          = $this->request->data['date_range'];
                $desarrollo_id  = $this->request->data['Cliente']['desarrollo_id'];
                $inmueble_id    = $this->request->data['Cliente']['inmueble_id'];
                $atencion       = $this->request->data['Cliente']['status_atencion'];


                
                $cond_tipo_cliente = "";
                if ($tipo_cliente != "" || !empty($tipo_cliente)){
                    $cond_tipo_cliente = array('Cliente.dic_tipo_cliente_id'=>$tipo_cliente);
                }
                
                $cond_status = "";
                if ($status != "" || !empty($status)){
                    $cond_status = array('Cliente.status'=>$status);
                }/*else{
                    $cond_status = array('Cliente.status'=>array('Activos','Inactivos', 'Inactivos temporales'));
                }*/
                
                
                $cond_etapa = "";
                if ($etapa != "" || !empty($etapa)){
                    $cond_etapa = array('Cliente.etapa'=>$etapa);
                }
                
                $cond_forma_contacto = "";
                if ($forma_contacto != "" || !empty($forma_contacto)){
                    $cond_forma_contacto = array('Cliente.dic_linea_contacto_id'=>$forma_contacto);
                }
                
                $cond_asesor = "";
                if ($asesor != "" || !empty($asesor)){
                    $cond_asesor = array('Cliente.user_id'=>$asesor);
                }else{
                    $cond_asesor = array('Cliente.user_id <>' =>'');
                }
                
                $cond_rangos = "";
                if ($rango != "" || !empty($rango)){
                    $fecha_ini = substr($rango, 0,10).' 00:00:00';
                    $fecha_fin = substr($rango, -10).' 23:59:59';
                    $fi = date('Y-m-d',  strtotime($fecha_ini));
                    $ff = date('Y-m-d',  strtotime($fecha_fin));
                    if ($fi==$ff){
                        $cond_rangos = array("Cliente.created LIKE '".$fi."%'");
                    }else{
                        $cond_rangos = array("Cliente.created BETWEEN ? AND ?"=>array($fi,$ff));
                    }
                    
                }

                $cond_desarrollo_id = '';
                if ($desarrollo_id != "" || !empty($desarrollo_id)){
                  $cond_desarrollo_id = array(
                    'OR' => array(
                      'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                      'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    ), 
                    'AND' => array(
                      'Desarrollo.is_private'=>0,
                      'Cliente.desarrollo_id' => $desarrollo_id
                    )
                  );

                  // $cond_desarrollo_id = array('Cliente.desarrollo_id' => $desarrollo_id);
                }

                $cond_inmueble_id = "";
                if ($inmueble_id != "" || !empty($inmueble_id)){
                    $cond_inmueble_id = array('Cliente.inmueble_id' => $inmueble_id);
                }
                // else {
                //   $cond_desarrollo_id = array(
                //     'OR' => array(
                //       'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                //       'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                //     ), 
                //     'AND' => array(
                //       'Desarrollo.is_private'=>0
                //     )
                //   );
                // }

                $cond_atencion = "";
                if ($atencion != "" || !empty($atencion)){
                  // Hacer case para los status de atención.

                  $date_current = date('Y-m-d');
                  $date_oportunos = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
                  $date_tardios = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
                  $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

                  switch($atencion){
                    case 0: // Oportuna
                      $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
                      //$cond_atencion = array('Cliente.last_edit <=' => $date_current.' 23:59:59', 'Cliente.last_edit >=' => $date_oportunos );
                    break;
                    case 1: //Tardía
                      $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY)","last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY)");
                      //$cond_atencion = array('Cliente.last_edit <' => $date_oportunos.' 23:59:59', 'Cliente.last_edit >=' => $date_tardios.' 00:00:00');
                    break;
                    case 2: //No Atendidos
                      $cond_atencion = array("Cliente.last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY)","Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY)");
                      //$cond_atencion = array('Cliente.last_edit <' => $date_tardios.' 00:00:00', 'Cliente.last_edit >=' => $date_no_atendidos.' 23:59:59');
                    break;
                    case 3://Por Reasignar
                      $cond_atencion = array("Cliente.last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY)");
                      //$cond_atencion = array('Cliente.last_edit <' => $date_no_atendidos.' 00:00:00', 'Cliente.last_edit >=' => '0000-00-00 00:00:00');
                    break;
                  }
                }
                


                $condiciones = array($cuenta,$all_clientes,$cond_rangos,$cond_tipo_cliente,$cond_status,$cond_etapa,$cond_forma_contacto,$cond_asesor, $cond_desarrollo_id, $cond_inmueble_id, $cond_atencion);
                $this->set('clientes',$this->Cliente->find('all', array('conditions'=> $condiciones)));

                $tipos_cliente = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                $etapas = $this->DicEtapa->find('list',array('order'=>'DicEtapa.etapa ASC','conditions'=>array('DicEtapa.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                $etapa_clientes = $this->DicEtapa->find('list',array('conditions' => array('cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')),'order' => array('etapa' => 'ASC')));

                $list_desarrollos = $this->Desarrollo->find('list', array(
                  'conditions' => array(

                    'OR' => array(
                      'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                      'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                    ), 
                    
                    'AND' => array(
                      'Desarrollo.is_private'=>0
                    )
                    
                    // ),
                    
                    // 'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    // 'Desarrollo.visible' => 1

                  ),
                  'order' => 'Desarrollo.nombre ASC'
                ));

                $list_inmuebles = $this->Inmueble->find('list', array(
                  'conditions' => array(
                    'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)',
                    'Inmueble.liberada' => 1
                  ),
                  'order' => 'Inmueble.titulo ASC'
                ));

                $this->set(compact('tipos_cliente'));
                $this->set(compact('linea_contactos'));
                $this->set(compact('etapas'));
                $this->set(compact('etapa_clientes'));
                // Muestra de todos los desarrollos e inmuebles existentes
                $this->set(compact('list_desarrollos'));
                $this->set(compact('list_inmuebles'));
                
                $this->set('users',$this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'))));

                $limpieza = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
                $this->set('limpieza', $limpieza);

                // Opciones de estatus de atencion a clientes.
                $this->set('status_atencion_options', array(0 => 'Oportuna', 1 => 'Tardia',2 => 'No Atendidos', 3 => 'Por reasignar'));


            }else{
                # Fuera del post

                // Si es desarrolladorsolo mostrara los clientes del desarrollo.
                // Si no es super admin o gerente solo muestra los de asesor.
                /* Condicion para los desarrolladores */
                if (!empty($this->Session->read('Desarrollador'))){
                    $clientes = $this->Cliente->find('all',
                        array(
                            'conditions' => array(
                                'Cliente.status'        => array('Activo', 'Inactivo temporal'),
                                'Cliente.user_id <>'    => '',
                                'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
                            ),
                            'recursive' => 0,
                            'fields'    => array(
                                'Cliente.id',
                                'Cliente.nombre',
                                'Cliente.temperatura',
                                'Cliente.correo_electronico',
                                'Cliente.telefono1',
                                'Cliente.comentarios',
                                'Cliente.status',
                                'Cliente.created',
                                'Cliente.last_edit',
                                'Cliente.etapa',
                                'User.id',
                                'User.nombre_completo',
                                'DicEtapa.etapa',
                                'DicLineaContacto.linea_contacto',
                                'DicTipoCliente.tipo_cliente',
                                'Inmueble.titulo',
                                'Desarrollo.nombre',
                            ),
                        )
                    );
                    $tipos_cliente   = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                    $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                    $users           = $this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));
                
                }elseif ($this->Session->read('Permisos.Group.cown')){
                    $condiciones = array(
                      'Cliente.status'    => array('Activo', 'Inactivo temporal'),
                      'Cliente.user_id'   => $this->Session->read('Auth.User.id'),
                      //'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    );
                    //Agregar condiciones solo para traer a los lead de venta ya con status de proceso de venta iniciado
                    if ($this->Session->read('CuentaUsuario.CuentasUser.cerrador')==1){
                      $condiciones = array("Cliente.id IN (SELECT cliente_id FROM leads WHERE transferido=1 AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN (SELECT id FROM desarrollos WHERE cerrador_id = ".$this->Session->read('Auth.User.id').")))");
                    }
                    $clientes = $this->Cliente->find('all',
                        array(
                            'conditions' => $condiciones,
                            'recursive' => 0,
                            'fields'    => array(
                              'Cliente.id',
                              'Cliente.nombre',
                              'Cliente.temperatura',
                              'Cliente.correo_electronico',
                              'Cliente.telefono1',
                              'Cliente.comentarios',
                              'Cliente.status',
                              'Cliente.created',
                              'Cliente.last_edit',
                              'Cliente.etapa',
                              'User.id',
                              'User.nombre_completo',
                              'DicEtapa.etapa',
                              'DicLineaContacto.linea_contacto',
                              'DicTipoCliente.tipo_cliente',
                              'Inmueble.titulo',
                              'Desarrollo.nombre',
                            ),
                        )
                    );
                    $tipos_cliente   = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                    $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                    $users           = $this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));

                    $list_desarrollos = $this->Desarrollo->find('list', array(
                    'conditions'=>array(
                          'OR' => array(
                              'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                              'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                              ), 
                          'AND' => array(
                              'Desarrollo.is_private'=>0
                              )

                          ),
                          'order' => array('Desarrollo.nombre ASC')
                    ));

                    $list_inmuebles = $this->Inmueble->find('list', array(
                      'conditions' => array(
                        'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                        'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)',
                        'Inmueble.liberada' => 1
                      ),
                      'order' => 'Inmueble.titulo ASC'
                    ));


                }else{
                    // Si es super admin o gerente, muestra todos los clientes.
                    $clientes = $this->Cliente->find('all',
                        array(
                            'conditions' => array(
                                'AND'=>array(
                                    'Cliente.status'        => array('Activo', 'Inactivo temporal'),
                                    'Cliente.user_id <>'    => ''
                                    ),
                                'OR'=>array(
                                    'Cliente.cuenta_id'     => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                                    'Cliente.id IN (SELECT id FROM clientes WHERE desarrollo_id IN(SELECT id FROM desarrollos WHERE comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."))",
                                    'Cliente.user_id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'
                                )
                            ),
                            // 'limit' => '100',
                            // 'recursive' => 1,
                            'contain' => array(
                              'User' => array( 'fields' => array('id', 'nombre_completo') ), 
                              'DicEtapa' => array('fields'=>array('etapa')), 
                              'DicLineaContacto' => array('fields'=> array('linea_contacto')),
                              'DicTipoCliente' => array('fields' => array('tipo_cliente')),
                              'Inmueble' => array('fields' => array('titulo')),
                              'Desarrollo' => array('fields' => array('nombre'))
                            ),
                            'fields'    => array(
                              'Cliente.id',
                              'Cliente.nombre',
                              'Cliente.temperatura',
                              'Cliente.correo_electronico',
                              'Cliente.telefono1',
                              'Cliente.comentarios',
                              'Cliente.status',
                              'Cliente.created',
                              'Cliente.last_edit',
                              'Cliente.etapa',
                              'User.id',
                              'User.nombre_completo',
                              'DicEtapa.etapa',
                              'DicLineaContacto.linea_contacto',
                              'DicTipoCliente.tipo_cliente',
                              'Inmueble.titulo',
                              'Desarrollo.nombre',
                            ),
                            'order' => 'Cliente.created DESC'
                        )
                    );
                    $tipos_cliente   = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                    $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
                    $users           = $this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));
                    
                    $list_desarrollos = $this->Desarrollo->find('list', array(
                      'conditions'=>array(
                        'OR' => array(
                            'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                            'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                            ), 
                        'AND' => array(
                            'Desarrollo.is_private'=>0
                            )

                        ),
                      'order' => 'Desarrollo.nombre ASC'
                    ));

                    $list_inmuebles = $this->Inmueble->find('list', array(
                      'conditions' => array(
                        'Inmueble.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                        'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
                      ),
                      'order' => 'Inmueble.titulo ASC'
                    ));


                }

                // Opciones de estatus de atencion a clientes.
                $this->set('status_atencion_options', array(0 => 'Oportuna', 1 => 'Tardia',2 => 'No atendido', 3 => 'Por reasignar'));

                // Diccionario de etapa de clientes de la cuenta.
                $etapa_clientes = $this->DicEtapa->find('list',array('conditions' => array('cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')),'order' => array('etapa' => 'ASC')));
                
                // Muestra de todos los desarrollos e inmuebles existentes
                $this->set(compact('list_desarrollos'));
                $this->set(compact('list_inmuebles'));

                // Seteo de variables dependiendo del usuario en sesion - AKA "SaaK" 15/02/2019
                $this->set(compact('tipos_cliente'));
                $this->set(compact('linea_contactos'));
                $this->set(compact('users'));
                $this->set('clientes', $clientes);
                $limpieza = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0");
                $this->set('limpieza', $limpieza);
                $this->set('etapa_clientes', $etapa_clientes);
                
            }

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

        

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 * Usado en Atenea V2
 */
    public function view($id = null) {
      $this->Event->Behaviors->load('Containable');
      $this->loadModel('LogCliente');
      $this->loadModel('Propiedades');

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

      //$cliente = $this->Cliente->read(null, $id);

      // Propiedades compradas
      $venta_inmueble = $this->Venta->find('all', array('conditions'=>array('Venta.cliente_id'=>$id)));
      $this->set('venta_inmueble', $venta_inmueble);
      
      // Hacer listado de los inmuebles
      $this->set('propiedades', $this->Inmueble->find('list', array('conditions'=>array(
          'Inmueble.id IN (SELECT inmueble_id FROM ventas WHERE ventas.cliente_id = '.$id.')'
      ))));

      // Categorias para la factura
      $this->set('categorias', array('Bancos'));
      $leads = $this->Lead->find('all',array('recursive'=>2,'conditions'=>array('Cliente.id'=>$id,'Lead.inmueble_id !='=>null)));
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
      
      $options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
      $this->set('cliente', $this->Cliente->find('first', $options));
      $this->set('agendas',$this->Agenda->find('all', array('order'=>'Agenda.id DESC','conditions'=>array('Agenda.cliente_id'=>$id))));
      $this->set('leads',$leads);
      // $this->set('sugeridas',$this->Inmueble->find('all',array(
      //     'limit'=>10,
      //     'conditions'=>$where,
      // )));
      $this->Lead->Behaviors->load('Containable');
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
            )
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
      $this->set('lista_inmuebles',$this->Inmueble->find('list',array('order'=>'Inmueble.titulo ASC','conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));


      // Listado de desarrollos para agregar como leads
      
      $this->set('lista_desarrollos',$this->Desarrollo->find('list',array('order'=>'Desarrollo.nombre ASC','conditions'=>array(
        'OR' => array(
          'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
          'Desarrollo.cuenta_id'          => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
        ), 
        'AND' => array(
          'Desarrollo.is_private' => 0
        )
      ))));
      
      $this->set('logs',$this->LogCliente->find('all',array('order'=>'LogCliente.id DESC','conditions'=>array('LogCliente.cliente_id'=>$id))));
      
      // Indicadores de emails, citas y visitas, llamadas, principalmente se toma del log de clietnes
      // $this->set('citas',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion'=> 5 ))));

      // Indicadores de seguimiento se tomara de los eventos.
      $this->set('citas',$this->Event->find('count',array('conditions'=>array('Event.cliente_id'=>$id,'Event.tipo_tarea'=> 0, 'Event.status' => 1 ))));
      $this->set('visitas',$this->Event->find('count',array('conditions'=>array('Event.cliente_id'=>$id,'Event.tipo_tarea'=> 1, 'Event.status' => 1 ))));
      $this->set('llamadas',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion' => 4, 'LogCliente.event_id IS NULL'))));
      $this->set('mails',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion' => 3, 'LogCliente.event_id IS NULL'))));
      
      $this->set('whatsapp',$this->LogCliente->find('count',array('conditions'=>array('LogCliente.cliente_id'=>$id,'LogCliente.accion' => 11, 'LogCliente.event_id IS NULL'))));



      
      $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
      $this->set('all_desarrollos',$this->Desarrollo->find('list',array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
      $list_facturas = $this->Factura->find('list', array('conditions'=>array('Factura.cliente_id'=>$id)));
      $this->set(compact('list_facturas'));
      $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));



      if ( $this->Session->read('Permisos.Group.call') == 1 ) { // SuperAdmin y Gerentes
            
        $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')');
        $condiciones_clientes    = array('Cliente.id' => $id);
      
      } elseif( !empty($this->Session->read('Desarrollador')) ){ // Desarrolladores.
        $condiciones_asesores    = array('User.status' => 1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')', 'User.id IN (SELECT user_id from clientes WHERE clientes.desarrollo_id = '.$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id').')');
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
        
        $data_eventos[$s]['url']          = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))."','".date('H', strtotime($evento['Event']['fecha_inicio']))."','".date('i', strtotime($evento['Event']['fecha_inicio']))."','".$evento['Event']['desarrollo_id']."','".$evento['Event']['inmueble_id']."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_1']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_1']))."','".date('d-m-Y', strtotime($evento['Event']['recordatorio_2']))." ".date('H:i:s', strtotime($evento['Event']['recordatorio_2']))."','".$evento['Event']['opt_recordatorio_1']."','".$evento['Event']['opt_recordatorio_2']."')";

        $data_eventos[$s]['fecha_inicio_format'] = date('d/m/Y \a \l\a\s H:i', strtotime($evento['Event']['fecha_inicio']));
        $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
        $data_eventos[$s]['status']              = $evento['Event']['status'];
        $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
        $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
        $data_eventos[$s]['id_evento']           = $evento['Event']['id'];

        
        }

        $this->set('eventos', $data_eventos);



      
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

    }
       
/**
 * add method
 *
 * @return void
 */
    public function add() {
        $this->loadModel('Mailconfig');
        $this->loadModel('Paramconfig');
        // $condiciones_cliente = array();
        $telefono            = 'Sin teléfono';
        $correo              = 'Sin correo';


        if ($this->request->is('post')) {

          $params_cliente = array(
            'nombre'              => $this->request->data['Cliente']['nombre'],
            'correo_electronico'  => $this->request->data['Cliente']['correo_electronico'],
            'telefono1'           => $this->request->data['Cliente']['telefono1'],
            'telefono2'           => $this->request->data['Cliente']['telefono2'],
            'telefono3'           => $this->request->data['Cliente']['telefono3'],
            'tipo_cliente'        => $this->request->data['Cliente']['dic_tipo_cliente_id'],
            'propiedades_interes' => $this->request->data['Cliente']['Propiedades'],
            'forma_contacto'      => $this->request->data['Cliente']['dic_linea_contacto_id'],
            'comentario'          => $this->request->data['Cliente']['comentarios'],
            'asesor_id'           => $this->request->data['Cliente']['user_id'],
          );
      
          $params_user = array(
            'user_id'   => $this->Session->read('Auth.User.id'),
            'cuenta_id' => $this->request->data['Cliente']['cuenta_id']
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
            $redirect = array('action'=> 'view', 'controller' => 'clientes', $save_client['cliente_id']);

          }

          $this->redirect( $redirect );

        }

        /* Antes del post */
        $users = $this->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.status'=>1,'User.id IN (SELECT user_id FROM cuentas_users WHERE 
           cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));

        $inmuebles = array();
        $conditions = array();
        $restrigidos = $this->Desarrollo->find('count',array('conditions'=>array('Desarrollo.id IN (SELECT desarrollo_id FROM desarrollos_users WHERE user_id = '.$this->Session->read('Auth.User.id').')')));
        
        if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==3 && $restrigidos > 0){
          $conditions =   'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollos_users WHERE user_id = '.$this->Session->read('Auth.User.id').')';
        }else{
          $conditions = array(
            'OR' => array(
              'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            ), 
            'AND' => array(
              'Desarrollo.is_private'=>0
            )

          );
          
          $this->Inmueble->Behaviors->load('Containable');
          $inmuebles = $this->Inmueble->find(
            'all',array(
              'fields'=>array(
                'id','titulo'
              ),
              'contain'=>false,
              'order'=>'Inmueble.titulo ASC',
              'conditions'=>array(
                'Inmueble.liberada'=>1,
                'Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)','Inmueble.liberada IN (1,2,3)'
              )
            )
          );
        }

        $this->Desarrollo->Behaviors->load('Containable'); 
        $desarrollos=$this->Desarrollo->find(
            'all',array(
                'fields'=>array(
                  'id','nombre'
                ),
                'contain'=>false,
                'order'      => 'Desarrollo.nombre ASC',
                'conditions' => $conditions
            )
        );

        

        // $descontinuados = $this->Inmueble->find('all',array('order'=>'Inmueble.titulo ASC','conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)','Inmueble.liberada'=>5)));
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
        break;
      }

      $this->Cliente->query("UPDATE clientes SET etapa = ".$linea_contacto['DicLineaContacto']['etapa_embudo']." WHERE id = $cliente_id");

      return null;
      $this->autoRender = false; 
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
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
                                
                                $propiedades = $this->Inmueble->find('all',array('conditions'=>array("Inmueble.id IN (SELECT leads.inmueble_id FROM leads WHERE cliente_id = $cliente_id)")));
                                $desarrollos = $this->Desarrollo->find('all',array('recursive'=>2,'conditions'=>array("Desarrollo.id IN (SELECT leads.desarrollo_id FROM leads WHERE cliente_id = $cliente_id)")));
                                
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
                                        $this->Email->subject('Propiedades que le puedan interesar');
                                        $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
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
                                    
//                                
//                                
//                                $this->Session->write('clundef',$this->Cliente->find('count',array('conditions'=>'Cliente.user_id = ""')));
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

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null, $ruta=null) {
        $this->Cliente->id = $id;
        if (!$this->Cliente->exists()) {
            throw new NotFoundException(__('Invalid cliente'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Cliente->delete()) {
                    $this->Cliente->query("DELETE FROM leads WHERE cliente_id = $id");
                    $this->Session->setFlash(__('El cliente ha sido eliminado exitosamente'),'default',array('class'=>'mensaje_exito'));
                    return $this->redirect(array('action' => 'index'));
                        
        } else {
            $this->Session->setFlash(__('The cliente could not be deleted. Please, try again.'),'default',array('class'=>'mensaje_error'));
        }
                if ($ruta == 2){
                    return $this->redirect(array('action' => 'sinasignar'));
                }
    }
        
        
        
        public function sinasignar() {
            $conditions_1 = array(
                'recursive'  => 1,
                'order'      => 'Cliente.id DESC',
                'conditions' => array(
                  'AND'=>array(
                    'Cliente.user_id IS NULL'
                  ),
                  'OR'=>array(
                    'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
                    "Cliente.desarrollo_id IN (SELECT id FROM desarrollos WHERE comercializador_id = ".$this->Session->read('CuentaUsuario.Cuenta.id').")"
                  ),
                )
            )
            ;

            $clientes = $this->Cliente->find('all', $conditions_1);
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
        
        public function send_correo(){
            if ($this->request->is(array('post', 'put'))) {
                $mailconfig = $this->Mailconfig->read(null,$this->Session->read('CuentaUsuario.Cuenta.mailconfig_id'));
                $cliente_id = $this->request->data['Cliente']['cliente_id'];
                $cliente = $this->Cliente->read(null,$cliente_id);
                $usuario = $this->User->read(null,$this->Session->read('Auth.User.id'));
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
                $this->Email->template('emailgeneral','layoutinmomail');
                $this->Email->from(array($this->Session->read('Auth.User.correo_electronico')=>$this->Session->read('Auth.User.nombre_completo')));
                $this->Email->to($cliente['Cliente']['correo_electronico']);
                if ($this->request->data['Cliente']['cc']!=""){
                    $this->Email->cc($this->request->data['Cliente']['cc']);
                }
                $this->Email->subject($this->request->data['Cliente']['asunto']);
                $this->Email->viewVars(array('contenido'=>$this->request->data['Cliente']['contenido'], 'cliente'=>$cliente, 'usuario'=>$usuario));
                $this->Email->send();

                $timestamp = date('Y-m-d H:i:s');

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

                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('Se ha enviado el correo al cliente.', 'default', array(), 'm_success'); // Mensaje
                return $this->redirect(array('action' => 'view',$cliente_id));
                
            }
            
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
                    $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus baja temporal por motivo: ".$this->request->data['Status']['motivo']." y pide recontacto el ".$this->request->data['Status']['recordatorio_reactivacion'];
                    $this->request->data['Cliente']['temperatura']    = 2;
                    break;
                
                case('Inactivo');
                        $motivo = $this->request->data['Status']['motivo_2'];
                    $leyenda = "Cliente ".$this->request->data['Status']['nombre_cliente']." pasa a estatus baja definitva por motivo: ".$motivo;
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


    /*--------------------------------------------------------------------------------
    *
    *   14-02-2019 -    Funcion para eliminar cliente - AKA "SaaK";
    *   24-08-2020 -    Se cambian los procesos, primero se eliminan los registros
    *   del cliente en las tablas en donde se guarda un seguimiento de el y al final
    *   se elimina el cliente.
    *
    --------------------------------------------------------------------------------*/
    public function delete_master(){
        $this->request->onlyAllow('post', 'delete');
        $cliente_id = $this->request->data['Cliente']['id'];
        $this->Cliente->id = $this->request->data['Cliente']['id'];

        if (!$this->Cliente->exists()) {
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('No se ha podido eliminar el clinete, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success');
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



    /*public function reporte_esp(){
        // Si es super admin o gerente, muestra todos los clientes.
        $clientes = $this->Cliente->find('all',
            array(
                'conditions' => array(
                    // 'Cliente.status'        => array('Activo', 'Inactivo temporal', 'Activo venta'),
                    'Cliente.cuenta_id'     => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Cliente.user_id <>'    => ''
                ),
                'recursive' => 1,
                'fields'    => array(
                    'Cliente.id',
                    'Cliente.nombre',
                    'Cliente.temperatura',
                    'Cliente.correo_electronico',
                    'Cliente.telefono1',
                    'Cliente.comentarios',
                    'Cliente.status',
                    'Cliente.created',
                    'Cliente.last_edit',
                    'User.id',
                    'User.nombre_completo',
                    'DicEtapa.etapa',
                    'DicLineaContacto.linea_contacto',
                    'DicTipoCliente.tipo_cliente',
                    'Inmueble.titulo',
                    'Desarrollo.nombre',
                    // 'Agenda.fecha',
                ),
                // 'order' => array('Agenda.fecha' => 'Desc')
            )
        );
        $tipos_cliente   = $this->DicTipoCliente->find('list',array('order'=>'DicTipoCliente.tipo_cliente ASC','conditions'=>array('DicTipoCliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $linea_contactos = $this->DicLineaContacto->find('list',array('order'=>'DicLineaContacto.linea_contacto ASC','conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $users           = $this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE  cuentas_users.opcionador = 1 AND cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));

        // Seteo de variables dependiendo del usuario en sesion - AKA "SaaK" 15/02/2019
        $this->set(compact('tipos_cliente'));
        $this->set(compact('linea_contactos'));
        $this->set(compact('users'));
        $this->set('clientes', $clientes);
    }*/

    /**********************************************************
    *
    * Listado de otros clienes.
    *
    **********************************************************/
    public function lista_terceros(){
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



    // Metodo para reportes gerenciales, basados en los reportes de dashboard.
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
        $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' GROUP BY status");

        // Grafica de temperatura de clientes.
        $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' GROUP BY etapa;");


        /************************************************* Grafica de atencion de clientes ********************************************************************/

        //Indicador de clientes con estatus Oportunos
        $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
            
        //Indicador de clientes con estatus Oportunos tardíos
        $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
        
        //Indicador de clientes con estatus Seguimiento Atrasado
        $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No atentidos (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
        
        //Indicador de clientes con estatus Por Reasignar
        $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff'");
        
        //Indicador de clientes con estatus Sin Seguimiento
        $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin Asignar' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fi' AND created <= '$ff'");

        // Suma de los clientes de atencion
        $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

        
        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
  
        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
  
        $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
        $ventas_linea_contacto_arreglo = array();
        $i=0;
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                  $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];    
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
        $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
        
        //Indicador de clientes con estatus Seguimiento Atrasado
        $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'Atrasados (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
        
        //Indicador de clientes con estatus Por Reasignar
        $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final'");
        
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
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                  $visitas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];    
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

    //**********************************************
    // Sección de metodos para la app
    // NOTA: En caso de agregar metodos adicionales
    // para la appa hacerlo de bajo de este comentario
    // para poder llevar un orden en el código.
    // 23/01/2020 AKA-SaaK.
    //**********************************************
  

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
              $leyenda = "Cliente ".$this->request->data['clienteNombre']." pasa a estatus baja temporal por motivo: ".$this->request->data['motivo']." y pide recontacto el ".$this->request->data['recordatorio'];
              $this->request->data['Cliente']['temperatura']    = 2;
              break;
          
          case('Inactivo');
              $leyenda = "Cliente ".$this->request->data['clienteNombre']." pasa a estatus baja definitva por motivo: ".$this->request->data['motivo'];
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
          'mensaje' => 'Se guardo correctamente la informacion.'
        );
      }else {
        $resp = array(
          'Ok' => false,
          'mensaje' => 'No se ha guardado la informacion, favor de intentarlo nuevamente.'
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
      'user_id'   => $user_id,
      'cuenta_id' => $cuenta_id
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

  
  function add_cliente( $params_cliente = null, $params_user = null ){

    $inmueble_interesado   = 0; // Varibale para guardar los id's inmuebles interesados.
    $desarrollo_interesado = 0; // Variable para guardar los id's de los desarrollos interesados
    $conditions_cliente    = [];
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
      if( !empty( $params_cliente['asesor_id'] ) ){ // Si existe una asignacion de asesor al cliente, se registra la fecha de asignacion y la fecha de ultima edición.
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
        
        // Registrar Seguimiento Rápido
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']        = $params_user['user_id'];
        $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']        = "Cliente creado por usuario ".$asesor['User']['nombre_completo'];
        $this->request->data['Agenda']['cliente_id']     = $cliente_id;
        $this->Agenda->save($this->request->data);

        // Paso 6 guardar en la tabla de inmuebles o desarrollos, dependiendo cual sea el id de la propiedad que se intereso.
        if (substr($params_cliente['propiedades_interes'], 0, 1) == "E" || substr($params_cliente['propiedades_interes'], 0, 1) == "P"){ // La propiedad de interes es un inmueble
            
            $inmueble_id = substr($params_cliente['propiedades_interes'], 1);
            $this->request->data['LogInmueble']['mensaje']     = "Envío de propiedad a cliente: ".$params_cliente['nombre'];
            $this->request->data['LogInmueble']['usuario_id']  = $params_cliente['nombre'];
            $this->request->data['LogInmueble']['fecha']       = date('Y-m-d');
            $this->request->data['LogInmueble']['accion']      = 5;
            $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
            $this->LogInmueble->create();
            $this->LogInmueble->save($this->request->data);
            $this->Lead->query("INSERT INTO leads VALUES(0,$cliente_id,$inmueble_id,'Abierto','',null,0)");
            $inmueble_interesado = $inmueble_id;
            

        }else{ // En caso de que la propiedad de interes sea un desarrollo
            
          $desarrollo_id                                         = substr($params_cliente['propiedades_interes'], 1);
          $this->request->data['LogDesarrollo']['mensaje']       = "Envío de desarrollo a cliente: ".$params_cliente['nombre'];
          $this->request->data['LogDesarrollo']['usuario_id']    = $params_cliente['nombre'];
          $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
          $this->request->data['LogDesarrollo']['accion']        = 5;
          $this->request->data['LogDesarrollo']['desarrollo_id'] = $desarrollo_id;
          $this->LogDesarrollo->create();
          $this->LogDesarrollo->save($this->request->data);
          $this->Lead->query("INSERT INTO leads VALUES(0,$cliente_id,null,'Abierto','',$desarrollo_id,0)");
          $desarrollo_interesado = $desarrollo_id;
          
        }

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
                
                // $this->Email->co(array($paramconfig['Paramconfig']['to_mr']));
                $this->Email->subject('Propiedades que le pueden interesar');
                $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
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
        if ( $paramconfig['Paramconfig']['mr'] == 1 ){
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
          $this->Email->template('emailaacallcenter','layoutinmomail');
          $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
          
          if ( $paramconfig['Paramconfig']['nuevo_cliente'] != ""){
            $emails2 = explode( ",", $paramconfig['Paramconfig']['nuevo_cliente'] );
            $arreglo_emails2 = array();
            if (sizeof($emails2)>0){
                foreach($emails2 as $email):
                    $arreglo_emails2[$email] = $email;
                endforeach;
            }else{
                $arreglo_emails2[$paramconfig['Paramconfig']['nuevo_cliente']] = $paramconfig['Paramconfig']['nuevo_cliente'];
            }
            
            $this->Email->to( $arreglo_emails2 );
            $subject = "Registro de un nuevo cliente en la base de datos";
            if ( sizeof( $propiedades ) > 0 && sizeof( $desarrollos ) < 1 ){
                $subject = "Registro de un nuevo cliente en la base de datos - ". $propiedades[0]['Inmueble']['titulo']." ".$propiedades[0]['Inmueble']['venta_renta'];
            }
            if( sizeof( $propiedades ) < 1 && sizeof( $desarrollos ) > 0 ){
                $subject = "Registro de un nuevo cliente en la base de datos - ". $desarrollos[0]['Desarrollo']['nombre'];
            }
            if( sizeof( $propiedades ) > 0 && sizeof( $desarrollos ) > 0 ){
                $subject = "Registro de un nuevo cliente en la base de datos - ". $propiedades[0]['Inmueble']['titulo']." ".$propiedades[0]['Inmueble']['venta_renta'] ." e Interesado en ".$desarrollos[0]['Desarrollo']['nombre'];
            }
            $this->Email->subject($subject);
            $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
            $this->Email->send();
          }
          
        }
        
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

  /****************************************
  * Actualizacion de cliente desde la app
  ****************************************/
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



  public function pipeline(){
    /* -------------------------------------------------------------------------- */
    /*                             Grupos de usuarios                             */
    /*  1 => Superadmin                                                           */
    /*  2 => Gerente                                                              */
    /*  3 => Asesor                                                               */
    /*  4 => Auxiliar                                                             */
    /*  5 => Cliente desarrollador                                                */
    /*  6 => Gerente Aux                                                          */
    /* -------------------------------------------------------------------------- */

    $this->Cliente->Behaviors->load('Containable');
    $conditions_e1 = array();
    $conditions_e2 = array();
    $conditions_e3 = array();
    $conditions_e4 = array();
    $conditions_e5 = array();
    $conditions_e6 = array();
    $conditions_e7 = array();

    // Agregar condicion para mostrar clientes de desarrolladores.
    // Alejandro Hernandez AKA SaaK
    if ( $this->Session->read('Permisos.Group.id') == 5 ) {

    }
    
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

    if($this->request->is('post')){

      if ( $this->request->data['Cliente']['asesor_id'] == "" && $this->request->data['Cliente']['desarrollo_id'] == "" && $this->request->data['Cliente']['nombre_cliente'] == "" ){

        $this->redirect(array('action' => 'pipeline'));  

      }else{
        
        $conditions_e1 = array('Cliente.status'        => array('Activo'),);
        $conditions_e2 = array('Cliente.status'        => array('Activo'),);
        $conditions_e3 = array('Cliente.status'        => array('Activo'),);
        $conditions_e4 = array('Cliente.status'        => array('Activo'),);
        $conditions_e5 = array('Cliente.status'        => array('Activo'),);
        $conditions_e6 = array('Cliente.status'        => array('Activo'),);
        $conditions_e7 = array('Cliente.status'        => array('Activo'),);

        
        if ( $this->request->data['Cliente']['asesor_id'] != "" ){

          array_push($conditions_e1,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
          array_push($conditions_e2,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
          array_push($conditions_e3,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
          array_push($conditions_e4,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
          array_push($conditions_e5,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
          array_push($conditions_e6,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);
          array_push($conditions_e7,['Cliente.user_id'=>$this->request->data['Cliente']['asesor_id']]);

        }else {
          
          array_push($conditions_e1,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e2,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e3,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e4,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e5,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e6,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e7,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);

        }

        if ( $this->request->data['Cliente']['desarrollo_id'] != "" ){

          array_push($conditions_e1,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);
          array_push($conditions_e2,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);
          array_push($conditions_e3,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);
          array_push($conditions_e4,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);
          array_push($conditions_e5,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);
          array_push($conditions_e6,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);
          array_push($conditions_e7,['Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id']]);

        }else {

          if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5) {
            
            array_push($conditions_e1,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
            array_push($conditions_e2,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
            array_push($conditions_e3,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
            array_push($conditions_e4,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
            array_push($conditions_e5,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
            array_push($conditions_e6,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
            array_push($conditions_e7,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);

          }else {

            array_push($conditions_e1,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
            array_push($conditions_e2,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
            array_push($conditions_e3,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
            array_push($conditions_e4,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
            array_push($conditions_e5,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
            array_push($conditions_e6,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
            array_push($conditions_e7,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);

          }


        }

        if ( $this->request->data['Cliente']['nombre_cliente'] != "" ){

          array_push($conditions_e1,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
          array_push($conditions_e2,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
          array_push($conditions_e3,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
          array_push($conditions_e4,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
          array_push($conditions_e5,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
          array_push($conditions_e6,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);
          array_push($conditions_e7,['Cliente.nombre LIKE "%'.$this->request->data['Cliente']['nombre_cliente'].'%"']);

        }else {

          array_push($conditions_e1,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e2,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e3,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e4,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e5,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e6,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);
          array_push($conditions_e7,['Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')]);

        }

        array_push($conditions_e1,['Cliente.etapa'=>1]);
        array_push($conditions_e2,['Cliente.etapa'=>2]);
        array_push($conditions_e3,['Cliente.etapa'=>3]);
        array_push($conditions_e4,['Cliente.etapa'=>4]);
        array_push($conditions_e5,['Cliente.etapa'=>5]);
        array_push($conditions_e6,['Cliente.etapa'=>6]);
        array_push($conditions_e7,['Cliente.etapa'=>7]);  
      }

    }else{

      switch($this->Session->read('CuentaUsuario.CuentasUser.group_id')):
        case(3):
          $conditions_e1 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 1
          );
          $conditions_e2 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 2
          );
          $conditions_e3 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 3
          );
          $conditions_e4 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 4
          );
          $conditions_e5 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 5
          );
          $conditions_e6 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 6
          );
          $conditions_e7 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id'    => $this->Session->read('Auth.User.id'),
            'Cliente.etapa' => 7
          );
        break;


        case(5):
          $conditions_e1 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 1
          );
          $conditions_e2 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 2
          );
          $conditions_e3 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 3
          );
          $conditions_e4 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 4
          );
          $conditions_e5 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 5
          );
          $conditions_e6 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 6
          );
          $conditions_e7 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
            'Cliente.etapa' => 7
          );

          $condicion_desarrollos = array(
            'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')
          );

        break;


        case(6):
          $conditions_e1 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>1
                ),
          );
          $conditions_e2 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>2
                ),
          );
          $conditions_e3 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>3
                ),
          );
          $conditions_e4 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>4
                ),
          );
          $conditions_e5 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>5
                ),
          );
          $conditions_e6 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>6
                ),
          );
          $conditions_e7 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$this->Session->read('Auth.User.id').'))',
                'Cliente.etapa'=>7
                ),
          );
        break;
        default:
          $conditions_e1 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.etapa'=>1
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );
          $conditions_e2 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.etapa'=>2
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );
          $conditions_e3 = array(
            'AND'=>array(
                'Cliente.status' => array('Activo'),
                'Cliente.etapa'  => 3
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );
          $conditions_e4 = array(
            'AND'=>array(
                'Cliente.status' => array('Activo'),
                'Cliente.etapa'  => 4
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );
          $conditions_e5 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.etapa'=>5
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );
          $conditions_e6 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.etapa'=>6
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );
          $conditions_e7 = array(
            'AND'=>array(
                'Cliente.status'        => array('Activo'),
                'Cliente.etapa'=>7
                ),
            'OR'=>array(
                'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')',
                'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            )
          );

          $condicion_desarrollos = array(
            'OR' => array(
              'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              'Desarrollo.cuenta_id'          => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
            ), 
            'AND' => array(
              'Desarrollo.is_private' => 0
            )
          );

        break;
      endswitch;
    }

    

    
    
    $this->set('clientes_e1',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e1,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
    $this->set('clientes_e2',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e2,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
    $this->set('clientes_e3',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e3,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
    $this->set('clientes_e4',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e4,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
    $this->set('clientes_e5',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e5,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
    $this->set('clientes_e6',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e6,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));
    $this->set('clientes_e7',$this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e7,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes,)));

    
    $users  = $this->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.status'=>1,'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')')));
    
    $this->set('users',$users);

    $desarrollos = $this->Desarrollo->find(
      'list',
      array(
          'conditions'=> $condicion_desarrollos,
          'order' => 'Desarrollo.nombre'
        )
    );

    $this->set('desarrollos',$desarrollos);
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

  public function add_whatsapp( $cliente_id = null, $propiedad_id = null, $accion = null ) {

    $data = array(
      'cliente_id'         => $cliente_id,
      'user_id'            => $this->Session->read('Auth.User.id'),
      'propiedad_id'       => $propiedad_id,
      'log_cliente_accion' => $accion,
      'fecha_creacion'     => date('Y-m-d H:i:s')
    );

    $save_log_cliente = $this->add_log_cliente( $data );

    
    if( $save_log_cliente['bandera'] == true ) {
      
      $this->Session->setFlash('', 'default', array(), 'success');
      $this->Session->setFlash('Se ha envíado el mensaje al whatsApp correctamente.', 'default', array(), 'm_success'); // Mensaje
      
      return $this->redirect( $save_log_cliente['redirect'] );
    }else{
      
      $this->Session->setFlash('', 'default', array(), 'success');
      $this->Session->setFlash('No se pudo guardar en el seguimiento del cliente, favor de intentarlo nuevamente. <br>Gracias.', 'default', array(), 'm_success');

      return $this->redirect(array('action' => $cliente_id));

    }

  }
  
  
  // Funcion para mandar un mensaje via whatsapp
  // public function add_whatsapp( $cliente_id = null, $desarrollo_id = null ) {
  public function add_log_cliente( $data = null ) {
    $this->Cliente->Behaviors->load('Containable');
    $this->Inmueble->Behaviors->load('Containable');
    $this->Desarrollo->Behaviors->load('Containable');

    $cliente = $this->Cliente->find('first', 
  		array(
  			'contain'	=> false,
  			'conditions' 	=> array(
  				'Cliente.id' => $data['cliente_id']
  			),
  			'fields' 	=> array(
  				'Cliente.id',
  				'Cliente.nombre',
  				'Cliente.telefono1'
  			)
  		)
  	);

    
    if (substr($data['propiedad_id'], 0, 1) == "E" || substr($data['propiedad_id'], 0, 1) == "P"){

      $inmueble = $this->Inmueble->find('first', 
        array(
          'contain'	=> false,
          'conditions' 	=> array(
            'Inmueble.id' => substr($data['propiedad_id'], 1)
          ),
          'fields' 	=> array(
            'Inmueble.titulo',
          )
        )
      );

      $mensaje = "Se ha enviado la propiedad ".$inmueble['Inmueble']['titulo']." vía WhatsApp";
      
      $redirect = "https://wa.me/521".rtrim(str_replace(array("(", ")"," ", "-"), "", $cliente['Cliente']['telefono1']))."?text=Hola ".$cliente['Cliente']['nombre']." envío esta propiedad que le puede interesar. https://adryo.com.mx/inmuebles/detalle/".substr($data['propiedad_id'], 1)."/".$data['user_id'];

      $mensaje_json = "Hola ".$cliente['Cliente']['nombre']." envío este desarrollo que le puede interesar. https://adryo.com.mx/inmuebles/detalle/".substr($data['propiedad_id'], 1)."/".$data['user_id'];

    }else {

      $desarrollo = $this->Desarrollo->find('first', 
        array(
          'contain'	=> false,
          'conditions' 	=> array(
            'Desarrollo.id' => substr($data['propiedad_id'], 1)
          ),
          'fields' 	=> array(
            'Desarrollo.nombre',
          )
        )
      );
      $mensaje = "Se ha enviado el desarrollo ".$desarrollo['Desarrollo']['nombre']." vía WhatsApp";
      
      $redirect = "https://wa.me/521".rtrim(str_replace(array("(", ")"," ", "-"), "", $cliente['Cliente']['telefono1']))."?text=Hola ".$cliente['Cliente']['nombre']." envío este desarrollo que le puede interesar. https://adryo.com.mx/desarrollos/detalle/".substr($data['propiedad_id'], 1)."/".$data['user_id'];

      $mensaje_json = "Hola ".$cliente['Cliente']['nombre']." envío este desarrollo que le puede interesar. https://adryo.com.mx/desarrollos/detalle/".substr($data['propiedad_id'], 1)."/".$data['user_id'];

    }

    $log_cliente_accions = array(
      1  => 'Creación',
      2  => 'Edición',
      3  => 'Mail',
      4  => 'Llamada',
      5  => 'Cita',
      6  => 'Mensaje',
      7  => 'Generación de Lead',
      8  => 'Borrado de venta',
      9  => 'Reactivación',
      10 => 'Visita',
      11 => array(
        'mensaje' => $mensaje
      )
    );
    
    ;
	
  	$this->LogCliente->create();
    $this->request->data['LogCliente']['id']         =  uniqid();
    $this->request->data['LogCliente']['cliente_id'] = $data['cliente_id'];
    $this->request->data['LogCliente']['user_id']    = $data['user_id'];
    $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
    $this->request->data['LogCliente']['accion']     = $data['log_cliente_accion'];
    $this->request->data['LogCliente']['mensaje']    = $log_cliente_accions[$data['log_cliente_accion']]['mensaje']." al cliente ".$cliente['Cliente']['nombre']." a las ".$data['fecha_creacion'];
    $this->LogCliente->save($this->request->data);


    //Registrar Seguimiento Rápido
    $this->Agenda->create();
    $this->request->data['Agenda']['user_id']    = $data['user_id'];
    $this->request->data['Agenda']['fecha']      = $data['fecha_creacion'];
    $this->request->data['Agenda']['mensaje']    = $log_cliente_accions[$data['log_cliente_accion']]['mensaje'];
    $this->request->data['Agenda']['cliente_id'] = $data['cliente_id'];
    $this->Agenda->save($this->request->data);

    $this->Cliente->query("UPDATE clientes SET last_edit = '".$data['fecha_creacion']."' WHERE id = ".$data['cliente_id']."");

    return $result = array(
      'bandera' => true,
      'mensaje' => 'Se han guardado correctamente los datos',
      'redirect' => $redirect,
      'mensaje_json' => $mensaje_json
    );

  }


  public function set_add_whatsapp( $cliente_id = null, $propiedad_id = null, $accion = null, $user_id = null ) {
    

    $data_lead = array(
      'cliente_id'         => $cliente_id,
      'user_id'            => $user_id,
      'propiedad_id'       => $propiedad_id,
      'log_cliente_accion' => $accion,
      'fecha_creacion'     => date('Y-m-d H:i:s')
    );

    $save_log_cliente = $this->add_log_cliente( $data_lead );

    if(  $save_log_cliente['bandera'] == true  ) {
      $resp = $save_log_cliente;
    }else{
      $resp = '';
    }

    echo json_encode($resp, true);
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


    switch($user['Rol'][0]['cuentas_users']['group_id']):
      case(3):
        $conditions_e1 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 1
        );
        $conditions_e2 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 2
        );
        $conditions_e3 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 3
        );
        $conditions_e4 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 4
        );
        $conditions_e5 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 5
        );
        $conditions_e6 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 6
        );
        $conditions_e7 = array(
          'Cliente.status'  => array('Activo'),
          'Cliente.user_id' => $user['User']['id'],
          'Cliente.etapa'   => 7
        );
      break;


      // case(5):
      //   $conditions_e1 = array(
      //     'Cliente.status'     => array('Activo'),
      //     'Cliente.user_id <>' => '',
      //     'Desarrollo.id'      => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa'      => 1
      //   );
      //   $conditions_e2 = array(
      //     'Cliente.status'        => array('Activo'),
      //     'Cliente.user_id <>'    => '',
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa' => 2
      //   );
      //   $conditions_e3 = array(
      //     'Cliente.status'        => array('Activo'),
      //     'Cliente.user_id <>'    => '',
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa' => 3
      //   );
      //   $conditions_e4 = array(
      //     'Cliente.status'        => array('Activo'),
      //     'Cliente.user_id <>'    => '',
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa' => 4
      //   );
      //   $conditions_e5 = array(
      //     'Cliente.status'        => array('Activo'),
      //     'Cliente.user_id <>'    => '',
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa' => 5
      //   );
      //   $conditions_e6 = array(
      //     'Cliente.status'        => array('Activo'),
      //     'Cliente.user_id <>'    => '',
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa' => 6
      //   );
      //   $conditions_e7 = array(
      //     'Cliente.status'        => array('Activo'),
      //     'Cliente.user_id <>'    => '',
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
      //     'Cliente.etapa' => 7
      //   );

      //   $condicion_desarrollos = array(
      //     'Desarrollo.id'         => $this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')
      //   );

      // break;


      case(6):
        $conditions_e1 = array(
          'AND'=>array(
              'Cliente.status' => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa' => 1
              ),
        );
        $conditions_e2 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa'=>2
              ),
        );
        $conditions_e3 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa'=>3
              ),
        );
        $conditions_e4 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa'=>4
              ),
        );
        $conditions_e5 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa'=>5
              ),
        );
        $conditions_e6 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa'=>6
              ),
        );
        $conditions_e7 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.user_id IN (SELECT user_id FROM grupos_usuarios_users WHERE grupos_usuario_id IN (SELECT id FROM grupos_usuarios WHERE administrador_id = '.$user['User']['id'].'))',
              'Cliente.etapa'=>7
              ),
        );
      break;
      default:
        $conditions_e1 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.etapa'=>1
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );
        $conditions_e2 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.etapa'=>2
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );
        $conditions_e3 = array(
          'AND'=>array(
              'Cliente.status' => array('Activo'),
              'Cliente.etapa'  => 3
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );
        $conditions_e4 = array(
          'AND'=>array(
              'Cliente.status' => array('Activo'),
              'Cliente.etapa'  => 4
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );
        $conditions_e5 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.etapa'=>5
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );
        $conditions_e6 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.etapa'=>6
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );
        $conditions_e7 = array(
          'AND'=>array(
              'Cliente.status'        => array('Activo'),
              'Cliente.etapa'=>7
              ),
          'OR'=>array(
              'Cliente.desarrollo_id IN (Select desarrollos.id from desarrollos WHERE desarrollos.comercializador_id = '.$user['Rol'][0]['cuenta_id'].')',
              'Cliente.cuenta_id'=>$user['Rol'][0]['cuenta_id'],
          )
        );

        $condicion_desarrollos = array(
          'OR' => array(
            'Desarrollo.comercializador_id' => $user['Rol'][0]['cuenta_id'],
            'Desarrollo.cuenta_id'          => $user['Rol'][0]['cuenta_id'],
          ), 
          'AND' => array(
            'Desarrollo.is_private' => 0
          )
        );

      break;
    endswitch;


    switch( $data['tipo_clientes'] ) {

      case( 1 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e1,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;
      case( 2 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e2,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;
      case( 3 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e3,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;
      case( 4 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e4,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;
      case( 5 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e5,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;
      case( 6 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e6,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;
      case( 7 ):
        $clientes = $this->Cliente->find('all',array('recursive'=>1,'conditions' => $conditions_e7,'contain'=>$contain_cliente,'order'=>'Cliente.id DESC','fields' => $fields_clientes, 'limit' => 50,));
      break;

    }

    $respuesta = array(
      'mensaje' => 'Estos son los resultados de su consulta',
      'datos'   => $clientes,
      'bandera' => true
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
          
          // array_push($conditions_e1,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
          // array_push($conditions_e2,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
          // array_push($conditions_e3,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
          // array_push($conditions_e4,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
          // array_push($conditions_e5,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
          // array_push($conditions_e6,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);
          // array_push($conditions_e7,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id')]);

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



  }  // Fin de la funcion get_filtro_pipeline
  

} // End class ClientesController
