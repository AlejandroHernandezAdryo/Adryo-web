<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class CotizacionsController extends AppController {

    public $uses = array(
        'LogCliente', 'Agenda', 'Cliente', 'Cotizacion', 'Cuenta', 'Mailconfig', 'Inmueble', 'Desarrollo', 'DesarrolloInmueble', 'LogClientesEtapa'
    );

    public function beforeFilter() {
        $this->Auth->allow(array('cotizacion_view','print', 'me_gusta', 'add_cotizacion'));
    }

    /**
     * 
     * Este metodo crea una cotización nueva.
     * AKA SaaK.
     * 
     * 
     * Actualizaciones
     * 1.- La variable de descuento hacia algo extraño, recuerdo que no daba el calculo exacto
     * por lo tanto habia tomado la decisión de mandar oculto los decimales, pero vamos a ver 
     * como funciona asi.
     * 
    */
    public function add(){
        header('Content-type: application/json; charset=utf-8');
        $cotizacion             = "";
        $response               = [];
        $mensaje_complementario = "";
        
        if($this->request->is('post')){

            // Consultar y asignar el nombre del plan de pagos.
            $plan_pago_str = "Cotización Manual";
            if( $this->request->data['Cotizacion']['plan_pago'] != "" ){
                $this->loadModel('PlanesDesarrollo');
                $this->PlanesDesarrollo->Behaviors->load('Containable');
                $plan_pago = $this->PlanesDesarrollo->find(
                    'first',
                    array(
                        'conditions'=>array(
                            'PlanesDesarrollo.id'=>$this->request->data['Cotizacion']['plan_pago']
                        ),
                        'fields'=>array(
                            'alias'
                        ),
                        'containable'=>false
                    )
                );
                $plan_pago_str = $plan_pago['PlanesDesarrollo']['alias'];
            }

            // Recorrido de los extras del desarrollo.
            if( !empty( $this->request->data['Cotizacion']['extra0'] ) ){
                
                $this->loadModel('ExtrasDesarrollo');
                $extras = "";
                for($i=0 ; $i<10 ; $i++){
                    if ($this->request->data['Cotizacion']['active_row'.$i]==1 && $this->request->data['Cotizacion']['extra'.$i]!=""){
                        $extras =  $extras.$this->request->data['Cotizacion']['extra'.$i].",";
                    }
                }
                $extras_arr = $this->ExtrasDesarrollo->find(
                    'all',
                    array(
                        'conditions'=>array(
                            'ExtrasDesarrollo.id IN ('.substr($extras,0,-1).')'
                        )
                    )
                );
    
                $cotizacion .= "
                </br>
                <table class='presupuesto'>
                    <tr>
                        <th colspan='3' id='title-table-extras-complementos'>Extras o complementos</th>
                    </tr>
                    <tr class='titulo_bloque'>
                        <th>Adicional</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                    </tr>";
    
                $total_extras = 0;
                foreach ($extras_arr as $extra) {
                    $precio = 0;
                    for($i=0 ; $i<10 ; $i++){
                        if ($this->request->data['Cotizacion']['extra'.$i] == $extra['ExtrasDesarrollo']['id']){
                            $precio =  $this->request->data['Cotizacion']['precio_cotizado'.$i];
                            $total_extras += $precio;
                        }
                    }
                    $cotizacion = $cotizacion."<tr><td>".$extra['ExtrasDesarrollo']['nombre']."</td><td>".$extra['ExtrasDesarrollo']['descripcion']."</td><td>$".number_format($precio,2)."</td></tr>";
                }
                $cotizacion =  $cotizacion."<tr><th colspan='2'>Total de Extras:</th><th>$".number_format($total_extras,2)."</th></td></tdf></tr></table>";
            }

            $cotizacion .= "<div class='row' id='row-precio-final'>
                <div class='col-sm-12'>
                    <h1 class='text-sm-center text-black'>
                        <b>
                            precio de venta $ ".number_format($this->request->data['Cotizacion']['precio_de_venta'], 2)."
                        </b>
                    </h1>
                </div>
            </div>";

            $cotizacion .= "
                <br>
                <table class='presupuesto'>
                    <tr>
                        <th colspan='5' id='title-table-plan-pagos'>Plan de pagos</th>
                    </tr>
                    <tr class='titulo_bloque'>
                        <th>Etapa</th>
                        <th>Porcentaje</th>
                        <th>Monto a Pagar</th>
                        <th>Número de Pagos</th>
                        <th>Monto por Pago</th>
                    </tr>";

            $cotizacion =  $cotizacion."
                <tr>
                    <td colspan='2'>Apartado/reserva</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['apartado_q'], 2)."</td>
                    <td>1</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['apartado_q'], 2)."</td>
                </tr>";
            
            $cotizacion =  $cotizacion."
                <tr class='row_impar'>
                    <td>Firma de Contrato/enganche </td>
                    <td>".$this->request->data['Cotizacion']['contrato']."%</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['contratoado_q'], 2)."</td>
                    <td>1</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['contratoado_q'], 2)."</td>
                </tr>";
            
            $cotizacion =  $cotizacion."
                <tr>
                    <td>Financiamiento aplazado/diferido</td>
                    <td>".$this->request->data['Cotizacion']['financiamiento']."%</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['financiamiento_q'], 2)."</td>
                    <td>".$this->request->data['Cotizacion']['meses_diferido']."</td>
                    <td>".$this->request->data['Cotizacion']['monto_diferido_mensual_fake']."</td>
                </tr>";
            
            $cotizacion =  $cotizacion."
                <tr class='row_impar'>
                    <td>Escrituración</td>
                    <td>".$this->request->data['Cotizacion']['escrituracion']."%</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['escrituracion_q'], 2)."</td>
                    <td>1</td>
                    <td class='text-sm-left'>".'$'.number_format($this->request->data['Cotizacion']['escrituracion_q'], 2)."</td>
                </tr>";
            
            $cotizacion =  $cotizacion."
                <tr>
                    <th colspan='2'>Total:</th>
                    <th class='text-sm-left'>".$this->request->data['Cotizacion']['total_q']."</th>
                    </td>
                    </td>
                </tr>
            </table>";


            // Formatear fecha
            $this->request->data['Cotizacion']['vigencia']     = date('Y-m-d', strtotime( $this->request->data['Cotizacion']['vigencia'] ));
            $this->request->data['Cotizacion']['fecha']        = date('Y-m-d');
            $this->request->data['Cotizacion']['user_id']      = $this->Session->read('Auth.User.id');
            $this->request->data['Cotizacion']['precio']       = $this->request->data['Cotizacion']['precio_lista'];
            $this->request->data['Cotizacion']['precio_final'] = $this->request->data['Cotizacion']['precio_de_venta'];
            $this->request->data['Cotizacion']['forma_pago']   = $plan_pago_str;
            $this->request->data['Cotizacion']['folio']        = uniqid();
            $this->request->data['Cotizacion']['cotizacion']   = $cotizacion;
            $this->request->data['Cotizacion']['meses']        = $this->request->data['Cotizacion']['meses_diferido'];
            $this->request->data['Cotizacion']['apartado']     = $this->request->data['Cotizacion']['apartado_q'];
            
            // Se comenta esta linea porque hacia algo raro con el descuento, hay que estar monitoreando esta variable
            // $this->request->data['Cotizacion']['descuento']     = $this->request->data['Cotizacion']['descuento_hiden'];
            $this->request->data['Cotizacion']['descuento']     = $this->request->data['Cotizacion']['descuento'];

            $this->request->data['Cotizacion']['contrato']       = (empty($this->request->data['Cotizacion']['contrato_p']) ? $this->request->data['Cotizacion']['contrato'] : $this->request->data['Cotizacion']['contrato_p']);
            $this->request->data['Cotizacion']['financiamiento'] = (empty($this->request->data['Cotizacion']['financiamiento_p']) ? $this->request->data['Cotizacion']['financiamiento'] : $this->request->data['Cotizacion']['financiamiento_p']);
            $this->request->data['Cotizacion']['escrituracion']  = (empty($this->request->data['Cotizacion']['escrituracion_p']) ? $this->request->data['Cotizacion']['escrituracion'] : $this->request->data['Cotizacion']['escrituracion_p']);
            

            $this->LogCliente->create();
            $this->Cotizacion->save( $this->request->data );

            // Una ves que se guarda la cotizacion hacer el registro en el seguimiento rapido y envio de email.
            if($this->Cotizacion->save($this->request->data)){

                $cotizacion_id = $this->Cotizacion->getInsertId();
                $cliente = $this->Cliente->findFirstById($this->request->data['Cotizacion']['cliente_id']);
                
                if( !empty( $this->request->data['Cotizacion']['extra0'] ) ){
                    foreach ($extras_arr as $extra){
                        for($i=0 ; $i<10 ; $i++){
                            if ($this->request->data['Cotizacion']['extra'.$i] == $extra['ExtrasDesarrollo']['id']){
                                $this->Cotizacion->query("INSERT INTO cotizaciones_extras VALUES (0,$cotizacion_id,".$extra['ExtrasDesarrollo']['id'].",".$this->request->data['Cotizacion']['precio_cotizado'.$i].",'')");
                            }
                        }
                    }
                }
                
                // Validación del cliente que tenga correo.
                if( $cliente['Cliente']['correo_electronico'] != 'Sin correo' ){

                    // URL de la invitación.
                    $URL = Router::url(array("controller" => "cotizacions", "action" => "cotizacion_view"), true).'/'.$cotizacion_id;
                    
                    // Seteo de la variable asesor.
                    $asesor['User'] = array(
                        'foto'               => $this->Session->read('Auth.User.foto'),
                        'nombre_completo'    => $this->Session->read('Auth.User.nombre_completo'),
                        'correo_electronico' => $this->Session->read('Auth.User.correo_electronico'),
                        'telefono1'          => $this->Session->read('Auth.User.telefono1'),
                    );

                    // Seteo de la variable de inmueble.
                    $this->Inmueble->Behaviors->load('Containable');
                    $inmueble = $this->Inmueble->find('first', array('conditions' => array('Inmueble.id' => $this->request->data['Cotizacion']['inmueble_id']), 'fields' => 'Inmueble.referencia', 'contain' => false ));
                    $mailconfig = $this->Mailconfig->findFirstById( $this->Session->Read('CuentaUsuario.Cuenta.mailconfig_id'));

                    $desarrollo = $this->Desarrollo->find(
                        'first',
                        array(
                            'conditions'=>array(
                                'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$this->request->data['Cotizacion']['inmueble_id'].')'
                            ),
                            'fields' => 'Desarrollo.nombre',
                            'contain' =>  false
                        )
                    );

                    /* ---------------- Agregar validacion de envio de cotizacion --------------- */
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
                    $this->Email->template('cotizacion','layoutinmomail');
                    $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
                    $this->Email->to($cliente['Cliente']['correo_electronico']);
                    $this->Email->cc($this->Session->read('Auth.User.correo_electronico'));
                    $this->Email->subject('Nueva cotizacion');
                    $this->Email->viewVars( array('url' => $URL, 'cliente' => $cliente, 'usuario' => $asesor, 'inmueble' => $inmueble, 'desarrollo' => $desarrollo, 'rds_sociales' => $this->Session->read('CuentaUsuario') ) );

                    /**
                     * Quitamos que al momento de que mandamos a etapa 5 al cliente si se manda una cotización desde la etapa 3.
                     * Se da la posibilidad de que vallamos incluyendo a los clientes a un buen perfilamiento, hasta que no se
                     * tenga definido se volvera a activar esta opción, no perder el cambio, ya que por el momento se deja un 
                     * poco mas flexible - AKA SAAK ft Luis Basurto 17/Oct/2022
                    */
                    // Validacion de cambio de etapa.
                    // Si el cliente esta en etapa 3 puede pasar directamente a la etapa 5, si no es asi, no se mueve de etapa.
                    // $cliente_etapa_3 = $this->LogClientesEtapa->find('first', array(
                    //     'conditions' => array(
                    //         'LogClientesEtapa.cliente_id' => $this->request->data['Cotizacion']['cliente_id'],
                    //         'LogClientesEtapa.status'     => 'Activo',
                    //         'LogClientesEtapa.etapa'      => 3
                    //     )
                    // ));

                    // if( !empty( $cliente_etapa_3 ) ){
                        
                    //     // Cambio de etapa.
                    //     $etapas_cliente = $this->LogClientesEtapa->find('all', array(
                    //         'conditions' => array(
                    //             'LogClientesEtapa.cliente_id' => $this->request->data['Cotizacion']['cliente_id'],
                    //             'LogClientesEtapa.status'     => 'Activo'
                    //         )
                    //     ));
        
                    //     // Todas las etapas del cliente que hay pasan a ser inactivas.
                    //     foreach( $etapas_cliente as $etapa_cliente ){
                    //         $this->request->data['LogClientesEtapa']['id']        = $etapa_cliente['LogClientesEtapa']['id'];
                    //         $this->request->data['LogClientesEtapa']['status']       = 'Inactivo';
                    //         $this->LogClientesEtapa->save($this->request->data);
                    //     }
        
                    //     // Creamos el registro de la nueva etapa.
                    //     $this->LogClientesEtapa->create();
                    //     $this->request->data['LogClientesEtapa']['id']            = null;
                    //     $this->request->data['LogClientesEtapa']['cliente_id']    = $this->request->data['Cotizacion']['cliente_id'];
                    //     $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
                    //     $this->request->data['LogClientesEtapa']['etapa']         = 5;
                    //     $this->request->data['LogClientesEtapa']['desarrollo_id'] = 0;
                    //     $this->request->data['LogClientesEtapa']['inmuble_id']    = $this->request->data['Cotizacion']['inmueble_id'];
                    //     $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                    //     $this->request->data['LogClientesEtapa']['user_id']       = $this->Session->read('Auth.User.id');
                    //     $this->LogClientesEtapa->save($this->request->data);
    
    
                    //     // ACtualizacion del cliente en la tabla de clientes.
                    //     $this->Cliente->create();
                    //     $this->request->data['Cliente']['id']    = $this->request->data['Cotizacion']['cliente_id'];
                    //     $this->request->data['Cliente']['etapa'] = 5;
                    //     $this->Cliente->save($this->request->data);

                    //     $mensaje_complementario = ", generando el cambio a etapa 5";

                    // }

                    // Se genera y envia la cotización.
                    if( $this->Session->read('CuentaUsuario.Cuenta.scc') == 1 ){
                        
                        $this->Email->send();
                        $response['mensaje'] = 'Se ha creado y enviado correctamente la cotización.';
                        $this->request->data['Cotizacion']['id']      = $cotizacion_id;
                        $this->request->data['Cotizacion']['status'] = 2;
                        $this->Cotizacion->save( $this->request->data );

                        $mensaje_seguimiento = "Se crea y envía cotización del Depto ".$this->request->data['Cotizacion']['propiedad_label']." el ".date('d-m-Y')."".$mensaje_complementario;


                    }else{ // solo se genera la cotización

                        $response['mensaje'] = 'Se ha creado correctamente la cotización.';
                        $this->request->data['Cotizacion']['id']     = $cotizacion_id;
                        $this->request->data['Cotizacion']['status'] = 1;
                        $this->Cotizacion->save( $this->request->data );

                        $mensaje_seguimiento = "Se crea cotización del Depto ".$this->request->data['Cotizacion']['propiedad_label']." el ".date('d-m-Y')."".$mensaje_complementario;
                    }

                    // Debe guardar seguimiento rapido.
                    $this->Agenda->create();
                    $this->request->data['Agenda']['user_id']        = $this->Session->read('Auth.User.id');
                    $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
                    $this->request->data['Agenda']['mensaje']        = $mensaje_seguimiento;
                    $this->request->data['Agenda']['cliente_id']     = $this->request->data['Cotizacion']['cliente_id'];
                    $this->Agenda->save($this->request->data);

                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']         =  uniqid();
                    $this->request->data['LogCliente']['cliente_id'] = $this->request->data['Cotizacion']['cliente_id'];
                    $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
                    $this->request->data['LogCliente']['accion']     = 4;
                    $this->request->data['LogCliente']['mensaje']    = $mensaje_seguimiento;
                    $this->LogCliente->save($this->request->data);
                    // Cambiar el estatus al cliente
                    $this->request->data['Cliente']['id']        = $this->request->data['Cotizacion']['cliente_id'];;
                    $this->request->data['Cliente']['last_edit'] =date('Y-m-d H:i:s');
                    $this->Cliente->save($this->request->data);

                }



                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success'); // Mensaje

                // return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['Cotizacion']['cliente_id']));
            }


        }

        echo json_encode( $response, true );
        $this->autoRender = false;

    }
    

    public function view($id){
        $this->layout = 'print';
        $this->Cotizacion->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');

        $cotizacion = $this->Cotizacion->find(
            'first',
            array(
                'conditions'=>array(
                    'Cotizacion.id'=>$id
                ),
                'recursive'=>2
            )
        );
        
        $desarrollo = $this->Desarrollo->find(
            'first',
            array(
                'conditions'=>array(
                    'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$cotizacion['Inmueble']['id'].')'
                ),
                //'contain'=>false;
            )
        );
        $this->set('desarrollo',$desarrollo);
        $this->set('cotizacion',$cotizacion);
    }

    /* --------------- Visualizacion de impresion de la cotizacion -------------- */
    public function print($id){
        $this->layout = 'print';
        $this->Cotizacion->Behaviors->load('Containable');
        $cotizacion = $this->Cotizacion->find(
            'first',
            array(
                'conditions'=>array(
                    'Cotizacion.id'=>$id
                ),
                'recursive'=>2
            )
        );
        $this->set('cotizacion',$cotizacion);

        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $desarrollo = $this->Desarrollo->find(
            'first',
            array(
                'conditions'=>array(
                    'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$cotizacion['Inmueble']['id'].')'
                ),
                //'contain'=>false;
            )
        );
        $this->set('desarrollo',$desarrollo);
    }

    /* ------------------------ Borrado de la cotizacion ------------------------ */
    function delete($id = null, $cliente_id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Cotización invalida', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Cotizacion->delete($id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('La cotización ha sido eliminada exitosamente', 'default', array(), 'm_success'); // Mensaje
            return $this->redirect(array('action' => 'view','controller'=>'clientes',$cliente_id));
        }
    }

    /* ----------------- Visualizacion externa de la cotizacion ----------------- */
    function cotizacion_view( $id ){
        $this->layout = 'blank';

        $this->Cotizacion->Behaviors->load('Containable');
        $cotizacion = $this->Cotizacion->find(
            'first',
            array(
                'conditions'=>array(
                    'Cotizacion.id'=>$id
                ),
                'recursive'=>2
            )
        );
        $this->set('cotizacion',$cotizacion);

        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $desarrollo = $this->Desarrollo->find(
            'first',
            array(
                'conditions'=>array(
                    'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$cotizacion['Inmueble']['id'].')'
                ),
                //'contain'=>false;
            )
        );
        $this->set('desarrollo',$desarrollo);
        
    }

    function share_cotizacion_whatsapp( $cliente_id = null, $cotizacion_id = null, $accion = null ){
        $this->Cliente->Behaviors->load('Containable');
    
        $cliente = $this->Cliente->find('first', 
          array(
            'contain'	=> false,
            'conditions' 	=> array(
              'Cliente.id' => $cliente_id
            ),
            'fields' 	=> array(
              'Cliente.id',
              'Cliente.nombre',
              'Cliente.telefono1'
            )
          )
        );
        
        $mensaje = "Se ha enviado la cotización vía WhatsApp";
          
        $redirect = "https://wa.me/521".rtrim(str_replace(array("(", ")"," ", "-"), "", $cliente['Cliente']['telefono1']))."?text=Estimado(a)".$cliente['Cliente']['nombre']." agradecemos su interés en nuestros proyectos y nos permitimos mandar información respecto a esta cotización. https://adryo.com.mx/cotizacions/cotizacion_view/".$cotizacion_id." Le reiteramos que estamos a sus órdenes para cualquier duda a través de esta vía, correo electrónico o teléfono. Gracias";

        $mensaje_json = "Estimado(a) ".$cliente['Cliente']['nombre']." agradecemos su interés en nuestros proyectos y nos permitimos mandar información respecto a esta cotizacion, el cual consideramos puede ser de su interés. https://adryo.com.mx/cotizacions/cotizacion_view/".$cotizacion_id." Le reiteramos que estamos a sus órdenes para cualquier duda a través de esta vía, correo electrónico o teléfono. Gracias";

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

        $this->LogCliente->create();
        $this->request->data['LogCliente']['id']         = uniqid();
        $this->request->data['LogCliente']['cliente_id'] = $cliente['Cliente']['id'];
        $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
        $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
        $this->request->data['LogCliente']['accion']     = $accion;
        $this->request->data['LogCliente']['mensaje']    = $log_cliente_accions[$accion]['mensaje']." al cliente ".$cliente['Cliente']['nombre']." a las ".date('Y-m-d H:i:s');
        $this->LogCliente->save($this->request->data);


        //Registrar Seguimiento Rápido
        $this->Agenda->create();
        $this->request->data['Agenda']['user_id']    = $this->Session->read('Auth.User.id');
        $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
        $this->request->data['Agenda']['mensaje']    = $log_cliente_accions[$accion]['mensaje'];
        $this->request->data['Agenda']['cliente_id'] = $cliente['Cliente']['id'];
        $this->Agenda->save($this->request->data);

        $this->Cliente->query("UPDATE clientes SET last_edit = '".date('Y-m-d H:i:s')."' WHERE id = ".$cliente['Cliente']['id']."");

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('Se ha envíado el mensaje al whatsApp correctamente.', 'default', array(), 'm_success'); // Mensaje
        
        return $this->redirect( $redirect );
        
        
    
          
    }

    function me_gusta(){
        header('Content-type: application/json; charset=utf-8');

        $this->request->data['Cotizacion']['id']     = $this->request->data['cotizacion_id'];
        $this->request->data['Cotizacion']['status'] = 3;
        $this->Cotizacion->save($this->request->data);
        
        $response['mensaje'] = 'Se guarda correctamente la decición';
        $response['flag']    = true;

        echo json_encode( $response, true );
        $this->autoRender = false;
    }

    /* -------------------- Metodo para likear la cotizacion -------------------- */
    function validacion_asesor(){
        header('Content-type: application/json; charset=utf-8');

        $this->loadModel('DesarrolloInmueble');
        $this->loadModel('LogClientesEtapa');
        $this->loadModel('Cliente');
        $this->loadModel('Agenda');
        $this->Agenda->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable');
        $this->LogClientesEtapa->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $this->Cotizacion->Behaviors->load('Containable');

        $cliente_id= $this->request->data['cliente_id'];
        $cotizaciones = $this->Cotizacion->find('all', array(
            'conditions' => array('Cotizacion.cliente_id' => $this->request->data['cliente_id'])
        ));
        
        // Pasar todas las demas cotizaciones que tiene el cliente como no autorizadas.
        foreach( $cotizaciones as $cotizacion ){
            $this->request->data['Cotizacion']['id']            = $cotizacion['Cotizacion']['id'];
            $this->request->data['Cotizacion']['status_asesor'] = 2;
            $this->Cotizacion->save($this->request->data);
        }
        $search_inmueble= $this->Cotizacion->find('first', array(
            'conditions' => array(
                'Cotizacion.id' => $this->request->data['cotizacion_id']
            ),
            'fields' => array(
                'Cotizacion.cliente_id', 
                'Cotizacion.inmueble_id', 
                'Cotizacion.user_id', 
            ),
            'contain' => false
        ));
        $cliente=$this->Cliente->find('first',
            array(      
                'conditions'=>array(
                    'Cliente.id '=>$cliente_id,
                ),
                'fields'=>array(
                    'Cliente.etapa',
                    'Cliente.id',
                ),

                'contain'=>false
            )
        );
        // Separamos solo la que eligio y la ponemos como la elegida master.
        $this->request->data['Cotizacion']['id']            = $this->request->data['cotizacion_id'];
        $this->request->data['Cotizacion']['status_asesor'] = 1;
        if( $this->Cotizacion->save($this->request->data) ){
            
            // sleep(1);
            // se busca el inmueble y el desarrollo 
            $search=$this->DesarrolloInmueble->find('first',
                array(
                    'conditions'=>array(
                        'DesarrolloInmueble.inmueble_id'  => $search_inmueble['Cotizacion']['inmueble_id'],
                    ),
                    'fields' => array(
                        'DesarrolloInmueble.desarrollo_id', 
                    ),
                    'contain' => false
                    )
            );
            //es aqui donde se puede automatisar que se puede pasar a la etapa 5 
            // se valida que el cliente no esta en la etapa 5 para que no se baje de la etap en la que esta 
            if ( $cliente['Cliente']['etapa'] == 3 OR $cliente['Cliente']['etapa'] == 4 ) {

                $etapas_cliente = $this->LogClientesEtapa->find('all', array(
                    'conditions' => array(
                        'LogClientesEtapa.cliente_id' => $cliente_id,
                        // 'LogClientesEtapa.status'     => 'Activo'
                        )
                ));
                    
                    // Todas las etapas del cliente que hay pasan a ser inactivas.
                foreach( $etapas_cliente as $etapa_cliente ){
                    $this->request->data['LogClientesEtapa']['id']        = $etapa_cliente['LogClientesEtapa']['id'];
                    $this->request->data['LogClientesEtapa']['status']       = 'Inactivo';
                    $this->LogClientesEtapa->save($this->request->data);
                }

                $fecha= date('Y-m-d H:i:s');
                $this->request->data['Cliente']['id']          = $cliente_id;
                $this->request->data['Cliente']['last_edit']   = $fecha;
                // $this->request->data['Cliente']['inmueble_id'] = $search_inmueble['Cotizacion']['inmueble_id'];
                $this->request->data['Cliente']['etapa']       = 5;
                //rogueEtapaFecha
                $this->request->data['Cliente']['fecha_cambio_etapa'] = date('Y-m-d');
                $this->Cliente->save($this->request->data);

                //se agrega en la agenda el siguento de que se canbia de manera automatica a la etapa 5
                $this->request->data['Agenda']['user_id']    = $search_inmueble['Cotizacion']['user_id'];
                $this->request->data['Agenda']['fecha']      = date('Y-m-d H:i:s');
                $this->request->data['Agenda']['mensaje']    = "El cliente cambia automáticamente a etapa 5 por: Seleccionar una cotización raíz ".date("d/m/Y \a \l\a\s H:i");
                $this->request->data['Agenda']['cliente_id'] = $cliente_id;
                $this->Agenda->save($this->request->data);

                //agenda el cleinte pasa de manera auntomatica a etapa 5
                $this->LogClientesEtapa->create();
                $this->request->data['LogClientesEtapa']['id']            = null;
                $this->request->data['LogClientesEtapa']['cliente_id']    = $cliente_id;
                $this->request->data['LogClientesEtapa']['fecha']         = date('Y-m-d H:i:s');
                $this->request->data['LogClientesEtapa']['etapa']         = 5;
                $this->request->data['LogClientesEtapa']['desarrollo_id'] = $search['DesarrolloInmueble']['desarrollo_id'];
                $this->request->data['LogClientesEtapa']['inmuble_id']    =  $search_inmueble['Cotizacion']['inmueble_id'];
                $this->request->data['LogClientesEtapa']['status']        = 'Activo';
                $this->request->data['LogClientesEtapa']['user_id']       = $search_inmueble['Cotizacion']['user_id'];
                $this->LogClientesEtapa->save($this->request->data);
            }
            
            $response['mensaje'] = 'Se valido la cotización y se tomara a cuenta apartir de este momento para el proceso de apartado, venta y escrituración.';
            $response['data']    = $this->request->data;

        }

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');

        echo json_encode( $response, true );
        $this->autoRender = false;
}

    function data_operacions(){
        header('Content-type: application/json; charset=utf-8');
        $this->Cotizacion->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        // $this->request->data['cliente_id'] = 51285;

        // Buscamos la cotizacion del cliente, ya que este aturizada por el asesor.
        $cotizacion = $this->Cotizacion->find('first', array(
            'conditions' => array(
                'Cotizacion.cliente_id'    => $this->request->data['cliente_id'],
                'Cotizacion.status_asesor' => 1
            ),
            'fields'     => array(
                'id',
                'precio_final',
                'apartado',
                'financiamiento',
                'contrato',
                'meses',
                'inmueble_id'
            ),
        ));

        $desarrollo = $this->DesarrolloInmueble->find('first', array(
            'conditions' => array(
                'DesarrolloInmueble.inmueble_id'    => $cotizacion['Cotizacion']['inmueble_id'],
            ),
            'contain' => array(
                'Desarrollos' => array(
                    'fields' => array(
                        'Desarrollos.fecha_inicio_escrituracion'
                    )
                )
            )
        ));



        // if( $cotizacion['Cotizacion']['apartado'] > 100 ){
            $cotizacion['Cotizacion']['monto_apartado']       = $cotizacion['Cotizacion']['apartado'];
        // }else{
            // $cotizacion['Cotizacion']['monto_apartado']       = $cotizacion['Cotizacion']['precio_final']*($cotizacion['Cotizacion']['apartado']/100);
        // }

        $cotizacion['Cotizacion']['monto_venta']          = $cotizacion['Cotizacion']['precio_final'];
        
        if( $cotizacion['Cotizacion']['contrato'] > 100 ){
            $cotizacion['Cotizacion']['monto_contrato']       = $cotizacion['Cotizacion']['contrato'];
        }else{
            $cotizacion['Cotizacion']['monto_contrato']       = $cotizacion['Cotizacion']['precio_final']*($cotizacion['Cotizacion']['contrato']/100);
        }
        
        if( $cotizacion['Cotizacion']['financiamiento'] > 100 ){
            $cotizacion['Cotizacion']['monto_financiamiento'] = $cotizacion['Cotizacion']['financiamiento'];
        }else{
            $cotizacion['Cotizacion']['monto_financiamiento'] = $cotizacion['Cotizacion']['precio_final']*($cotizacion['Cotizacion']['financiamiento']/100);
        }

        // Validacion para evitar la division en 0
        if( !empty( $cotizacion['Cotizacion']['monto_financiamiento'] ) AND !empty($cotizacion['Cotizacion']['meses']) ){
            // $cotizacion['Cotizacion']['monto_mensual']        = round(is_numeric($cotizacion['Cotizacion']['monto_financiamiento']) / is_numeric($cotizacion['Cotizacion']['meses']), 2);


            $cotizacion['Cotizacion']['monto_mensual']        = round($cotizacion['Cotizacion']['monto_financiamiento'] / $cotizacion['Cotizacion']['meses'], 2);

            
        }else{
            $cotizacion['Cotizacion']['monto_mensual']        = 0;
        }

        // Traer la fecha de escrituracion del desarrollo.
        $desarrollo['Desarrollos']['fecha_inicio_escrituracion'] = date('d-m-Y', strtotime($desarrollo['Desarrollos']['fecha_inicio_escrituracion']));



        $response = array(
            'data'       => $this->request->data,
            'cotizacion' => $cotizacion,
            'desarrollo' => $desarrollo
        );


        echo json_encode( $response );
        exit();
        $this->autoRender = false;

    }

    /**
     * SaaK 07/06/2022
     * Metodo para enviar la cotizacion por email.
    */
    function share_cotizacion_email(){
        header('Content-type: application/json; charset=utf-8');

        $cotizacion_id = $this->request->data['cotizacion_id'];
        $inmueble_id   = $this->request->data['inmueble_id'];
        $cliente_id    = $this->request->data['cliente_id'];


        $cliente = $this->Cliente->findFirstById($cliente_id);
        $cotizacion = $this->Cotizacion->findFirstById($cotizacion_id);

        if( $cliente['Cliente']['correo_electronico'] != 'Sin correo' ){

            // URL de la invitación.
            $URL = Router::url(array("controller" => "cotizacions", "action" => "cotizacion_view"), true).'/'.$cotizacion_id;
            
            // Seteo de la variable asesor.
            $asesor['User'] = array(
                'foto'               => $this->Session->read('Auth.User.foto'),
                'nombre_completo'    => $this->Session->read('Auth.User.nombre_completo'),
                'correo_electronico' => $this->Session->read('Auth.User.correo_electronico'),
                'telefono1'          => $this->Session->read('Auth.User.telefono1'),
            );

            // Seteo de la variable de inmueble.
            $this->Inmueble->Behaviors->load('Containable');
            $inmueble = $this->Inmueble->find('first', array('conditions' => array('Inmueble.id' => $inmueble_id ), 'fields' => 'Inmueble.referencia', 'contain' => false ));
            $mailconfig = $this->Mailconfig->findFirstById( $this->Session->Read('CuentaUsuario.Cuenta.mailconfig_id'));

            // $desarrollo = $this->Desarrollo->find(
            //     'first',
            //     array(
            //         'conditions'=>array(
            //             'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$inmueble_id .')'
            //         ),
            //         'fields' => 'Desarrollo.nombre',
            //         'contain' =>  false
            //     )
            // );
            $desarrollo    = $this->Desarrollo->find('all', array('conditions'=>array( 'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$inmueble_id .')' ), 'containe' => false));

            /* ---------------- Agregar validacion de envio de cotizacion --------------- */
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
            $this->Email->template('cotizacion','layoutinmomail');
            $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
            $this->Email->to($cliente['Cliente']['correo_electronico']);
            $this->Email->subject('Nueva cotizacion');
            $this->Email->viewVars( array('url' => $URL, 'cliente' => $cliente, 'usuario' => $asesor, 'inmueble' => $inmueble, 'desarrollos' => $desarrollo, 'rds_sociales' => $this->Session->read('CuentaUsuario') ) );
            $this->Email->send();
            $response['mensaje'] = 'Se ha enviado correctamente la cotización.';

            // Se guarda el contador de que se mando el email
            $this->LogCliente->create();
            $this->request->data['LogCliente']['id']         =  uniqid();
            $this->request->data['LogCliente']['cliente_id'] = $cliente_id;
            $this->request->data['LogCliente']['user_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogCliente']['mensaje']    = "Envío de cotización vía email.";
            $this->request->data['LogCliente']['accion']     = 3;
            $this->request->data['LogCliente']['datetime']   = date('Y-m-d h:i:s');
            $this->LogCliente->save($this->request->data);

            // Se guarda el seguimiento rápido
            $this->Agenda->create();
            $this->request->data['Agenda']['user_id']        = $this->Session->read('Auth.User.id');
            $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
            $this->request->data['Agenda']['mensaje']        = "Se envía cotización del Depto ".$inmueble['Inmueble']['referencia']." el ".date('d-m-Y');
            $this->request->data['Agenda']['cliente_id']     = $cliente_id;
            $this->Agenda->save($this->request->data);

            if( $cotizacion['Cotizacion']['status'] <= 1 ){
                $this->request->data['Cotizacion']['id']      = $cotizacion_id;
                $this->request->data['Cotizacion']['status'] = 2;
                $this->Cotizacion->save( $this->request->data );
            }

        }else{
            $response['mensaje'] = 'No se pudo enviar la cotización por que el cliente no cuenta con email.';
        }

        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success'); // Mensaje

        echo json_encode( $response );
        exit();
        $this->autoRender = false;

    }


 
	/**
   	* API para generar cotizacion
	* EMC
	* Metodo POST para realizar cotizacion
  	*/

        function add_cotizacion() {

            header('Content-type: application/json; charset=utf-8');
            $cotizacion             = "";
            $resp               = [];
            $mensaje_complementario = "";

            if($this->request->is('post')){
                if( $this->request->data['plan_pago'] != null ){

                    /*  Consultar Plan de desarrollo por su nombre
                    *  	usando como parametro plan_pago
                    */
                        $this->loadModel('PlanesDesarrollo');
                        $this->PlanesDesarrollo->Behaviors->load('Containable');

                        $plan_pago = $this->PlanesDesarrollo->find(
                            'first',
                            array(
                                'conditions'=>array(
                                    'PlanesDesarrollo.alias'=>$this->request->data['plan_pago']
                                ),
                                'fields'=>array(
                                    'alias',
                                    'id'
                                ),
                                'containable'=>false
                            )
                        );

                    /* -------------------------------------------------------------------------- */

                    /* ----------------------------- Agregar Extras ----------------------------- */
                        if( !empty( $this->request->data['extra0'] ) ){

                            $this->loadModel('ExtrasDesarrollo');
                            $extras = "";
                            for($i=0 ; $i<10 ; $i++){
                                if ($this->request->data['active_row'.$i]==1 && $this->request->data['extra'.$i]!=""){
                                    $extras =  $extras.$this->request->data['extra'.$i].",";
                                }
                            }
                            $extras_arr = $this->ExtrasDesarrollo->find(
                                'all',
                                array(
                                    'conditions'=>array(
                                        'ExtrasDesarrollo.id IN ('.substr($extras,0,-1).')'
                                    )
                                )
                            );

                            $cotizacion .= "
                            </br>
                            <table class='presupuesto'>
                                <tr>
                                    <th colspan='3' id='title-table-extras-complementos'>Extras o complementos</th>
                                </tr>
                                <tr class='titulo_bloque'>
                                    <th>Adicional</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                </tr>";

                            $total_extras = 0;
                            foreach ($extras_arr as $extra) {
                                $precio = 0;
                                for($i=0 ; $i<10 ; $i++){
                                    if ($this->request->data['Cotizacion']['extra'.$i] == $extra['ExtrasDesarrollo']['id']){
                                        $precio =  $this->request->data['Cotizacion']['precio_cotizado'.$i];
                                        $total_extras += $precio;
                                    }
                                }
                                $cotizacion = $cotizacion."<tr><td>".$extra['ExtrasDesarrollo']['nombre']."</td><td>".$extra['ExtrasDesarrollo']['descripcion']."</td><td>$".number_format($precio,2)."</td></tr>";
                            }
                            $cotizacion =  $cotizacion."<tr><th colspan='2'>Total de Extras:</th><th>$".number_format($total_extras,2)."</th></td></tdf></tr></table>";
                        }
                    /* -------------------------------------------------------------------------- */

                    /* ---- Se crea la estructura (tabla) de la variable cotizacion con formato HTML ---- */

                        $cotizacion .= "<div class='row' id='row-precio-final'>
                                <div class='col-sm-12'>
                                    <h1 class='text-sm-center text-black'>
                                        <b>
                                            precio de venta $ ".number_format($this->request->data['precio'], 2)."
                                        </b>
                                    </h1>
                                </div>
                            </div>"
                        ;

                        $cotizacion .= "
                            <br>
                            <table class='presupuesto'>
                                <tr>
                                    <th colspan='5' id='title-table-plan-pagos'>Plan de pagos</th>
                                </tr>
                                <tr class='titulo_bloque'>
                                    <th>Etapa</th>
                                    <th>Porcentaje</th>
                                    <th>Monto a Pagar</th>
                                    <th>Número de Pagos</th>
                                    <th>Monto por Pago</th>
                                </tr>"
                        ;

                        $cotizacion =  $cotizacion."
                            <tr>
                                <td colspan='2'>Apartado/reserva</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['apartado'], 2)."</td>
                                <td>1</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['apartado'], 2)."</td>
                            </tr>"
                        ;

                        $cotizacion =  $cotizacion."
                            <tr class='row_impar'>
                                <td>Firma de Contrato/enganche </td>
                                <td>".$this->request->data['contrato']."%</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['contrato'], 2)."</td>
                                <td>1</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['contrato'], 2)."</td>
                            </tr>"
                        ;

                        $cotizacion =  $cotizacion."
                            <tr>
                                <td>Financiamiento aplazado/diferido</td>
                                <td>".$this->request->data['financiamiento']."%</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['financiamiento'], 2)."</td>
                                <td>".$this->request->data['meses_diferido']."</td>
                                <td>".$this->request->data['monto_diferido_mensual_fake']."</td>
                            </tr>"
                        ;

                        $cotizacion =  $cotizacion."
                            <tr class='row_impar'>
                                <td>Escrituración</td>
                                <td>".$this->request->data['escrituracion']."%</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['escrituracion'], 2)."</td>
                                <td>1</td>
                                <td class='text-sm-left'>".'$'.number_format($this->request->data['escrituracion'], 2)."</td>
                            </tr>"
                        ;

                        $cotizacion =  $cotizacion."
                            <tr>
                                <th colspan='2'>Total:</th>
                                <th class='text-sm-left'>".'$'.number_format($this->request->data['precio_final'], 2)."</th>
                                </td>
                                </td>
                            </tr>
                            </table>"
                        ;

                    /* -------------------------------------------------------------------------- */


                    /*  Request para guardar cotizacion
                    *   Obtenemos las información enviada, se procesa y se guarda en
                    *   tabla de cotizacion
                    */
                        $this->request->data['apartado']          	= $this->request->data['apartado'];
                        $this->request->data['cliente_id']        	= $this->request->data['cliente_id'];
                        $this->request->data['contrato']          	= (empty($this->request->data['contrato']) ? $this->request->data['contrato'] : $this->request->data['contrato']);
                        $this->request->data['cotizacion']   		= $cotizacion;
                        $this->request->data['descuento']         	= $this->request->data['descuento'];
                        $this->request->data['escrituracion']     	= (empty($this->request->data['escrituracion']) ? $this->request->data['escrituracion'] : $this->request->data['escrituracion']);
                        $this->request->data['fecha']             	= date('Y-m-d');
                        $this->request->data['financiamiento']    	= (empty($this->request->data['financiamiento']) ? $this->request->data['financiamiento'] : $this->request->data['financiamiento']);
                        $this->request->data['folio']             	= uniqid();
                        $this->request->data['forma_pago']       	= $plan_pago['PlanesDesarrollo']['alias'];
                        $this->request->data['inmueble_id']      	= $this->request->data['inmueble_id'];
                        $this->request->data['observaciones']     	= $this->request->data['observaciones'];
                        $this->request->data['precio']            	= $this->request->data['precio'];
                        $this->request->data['precio_extras']     	= $this->request->data['precio_extras'];
                        $this->request->data['precio_final']      	= $this->request->data['precio_final'];
                        $this->request->data['status']            	= $this->request->data['status'];
                        $this->request->data['status_asesor']     	= $this->request->data['status_asesor'];
                        $this->request->data['user_id']           	= $this->request->data['user_id'];
                        $this->request->data['vigencia']          	= date('Y-m-d', strtotime( $this->request->data['vigencia'] ));
                        $this->request->data['meses']             	= $this->request->data['meses'];
                    /* -------------------------------------------------------------------------- */

                    /*
                    *   Si se guarda la informacion de forma correcta procede a buscar el ultimo id en
                    *   Tabla cotizacion, para empezar el proceso de envio de correo con la informacion
                    *   Tambien se guarda el Log de los procesos correspondientes
                    */
                        if($this->Cotizacion->save($this->request->data)){

                            /* -------------------- se buscal el ultimo Id ingresado -------------------- */

                                $cotizacion_id = $this->Cotizacion->getInsertId();

                            /* -------------------------------------------------------------------------- */

                            /* ------ Se buscar la informacion del cliente por medio de cliente_id ------ */

                                $cliente = $this->Cliente->findFirstById($this->request->data['cliente_id']);

                            /* -------------------------------------------------------------------------- */

                            /* ---------------- Se guarda el Log de los extras agregados ---------------- */

                                if( !empty( $this->request->data['extra0'] ) ){
                                    foreach ($extras_arr as $extra){
                                        for($i=0 ; $i<10 ; $i++){
                                            if ($this->request->data['extra'.$i] == $extra['ExtrasDesarrollo']['id']){
                                                $this->Cotizacion->query("INSERT INTO cotizaciones_extras VALUES (0,$cotizacion_id,".$extra['ExtrasDesarrollo']['id'].",".$this->request->data['precio_cotizado'.$i].",'')");
                                            }
                                        }
                                    }
                                }

                            /* -------------------------------------------------------------------------- */

                            /* ---------------- Validación del cliente que tenga correo. ---------------- */

                                if( $cliente['Cliente']['correo_electronico'] != 'Sin correo' ){

                                    /* -------------------------- URL de la invitación. ------------------------- */

                                        $URL = Router::url(array("controller" => "cotizacions", "action" => "cotizacion_view"), true).'/'.$cotizacion_id;

                                    /* -------------------------------------------------------------------------- */

                                    /* ---------------------- Seteo de la variable asesor. ---------------------- */
                                        $this->loadModel('User');
                                        $this->User->Behaviors->load('Containable');

                                        $user = $this->User->find(
                                            'first',
                                            array(
                                                'conditions'=>array(
                                                    'User.id'=> $this->request->data['user_id']
                                                ),
                                                'fields'=>array(
                                                    'foto',
                                                    'nombre_completo',
                                                    'correo_electronico',
                                                    'telefono1'
                                                ),
                                                'containable'=>false
                                            )
                                        );
                                        $asesor = array(
                                            'foto'               => $user['User']['foto'],
                                            'nombre_completo'    =>	$user['User']['nombre_completo'],
                                            'correo_electronico' => $user['User']['correo_electronico'],
                                            'telefono1'          => $user['User']['telefono1'],
                                        );

                                    /* -------------------------------------------------------------------------- */

                                    /* -------------------- Seteo de la variable de inmueble. ------------------- */
                                        $this->loadModel('Inmueble');
                                        $this->Inmueble->Behaviors->load('Containable');

                                        $inmueble = $this->Inmueble->find(
                                            'first',
                                            array(
                                                'conditions' => array(
                                                    'Inmueble.id' => $this->request->data['inmueble_id']
                                                ),
                                                'fields' => array(
                                                    'Inmueble.referencia',
                                                    'Inmueble.titulo',
                                                    'Inmueble.id'
                                                ),
                                                'containable'=>false
                                            )
                                        );
                                        $depto = array(
                                            'id'    		=>	$inmueble['Inmueble']['id'],
                                            'nombre'               => $inmueble['Inmueble']['titulo'],
                                            'referencia'    		=>	$inmueble['Inmueble']['referencia'],

                                        );

                                    /* -------------------------------------------------------------------------- */

                                    /* --------------------- Seteo de la variable de cuenta. -------------------- */
                                        $this->loadModel('Cuenta');
                                        $this->Cuenta->Behaviors->load('Containable');

                                        $cuenta = $this->Cuenta->find(
                                            'first',
                                            array(
                                                'conditions' => array(
                                                    'Cuenta.id' => $this->request->data['cuenta_id']
                                                ),
                                                'fields' => array(
                                                    'Cuenta.mailconfig_id'
                                                ),
                                                'containable'=>false
                                            )
                                        );
                                        $mailconfig = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id']);
                                    /* -------------------------------------------------------------------------- */

                                    /* ---------------------- Seteo de DesarrolloInmueble. ---------------------- */
                                        $this->loadModel('DesarrolloInmueble');
                                        $this->DesarrolloInmueble->Behaviors->load('Containable');

                                        $desarrollo_id = $this->DesarrolloInmueble->find(
                                            'first',
                                            array(
                                                'conditions'=>array(
                                                    'DesarrolloInmueble.inmueble_id' => $this->request->data['inmueble_id']
                                                ),
                                                'fields' =>
                                                    'DesarrolloInmueble.desarrollo_id'
                                                ,
                                                'containable'=>false
                                            )

                                        );
                                        $d_id =  intval($desarrollo_id['DesarrolloInmueble']['desarrollo_id']);

                                        $desarrollo = $this->Desarrollo->find(
                                            'first',
                                            array(
                                                'conditions'=>array(
                                                    'Desarrollo.id' => $d_id
                                                ),
                                                'fields' => 'Desarrollo.nombre',
                                                'contain' =>  false
                                            )
                                        );

                                    /* -------------------------------------------------------------------------- */

                                    /* ---------------- Agregar validacion de envio de cotizacion ---------------
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
                                        $this->Email->template('cotizacion','layoutinmomail');
                                        $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
                                        $this->Email->to($cliente['Cliente']['correo_electronico']);
                                        $this->Email->cc($user['User']['correo_electronico']);
                                        $this->Email->subject('Nueva cotizacion');
                                        $this->Email->viewVars( array('url' => $URL, 'cliente' => $cliente, 'usuario' => $asesor, 'inmueble' => $inmueble, 'desarrollo' => $desarrollo, 'rds_sociales' => $this->Session->read('CuentaUsuario') ) );



                                    * -------------------- Se genera y envia la cotización. -------------------- *

                                        $this->Email->send();
                                        $response['mensaje'] = 'Se ha creado y enviado correctamente la cotización.';
                                        $this->request->data['Cotizacion']['id']      = $cotizacion_id;
                                        $this->request->data['Cotizacion']['status'] = 2;
                                        $this->Cotizacion->save( $this->request->data );

                                        $mensaje_seguimiento = "Se crea y envía cotización del Depto ".$inmueble['titulo']." el ".date('d-m-Y')."".$mensaje_complementario;

                                    * -------------------------------------------------------------------------- *

                                    * -------------------- Debe guardar seguimiento rapido. -------------------- *
                                        $this->Agenda->create();
                                        $this->request->data['Agenda']['user_id']        = $this->request->data['user_id'];
                                        $this->request->data['Agenda']['fecha']          = date('Y-m-d H:i:s');
                                        $this->request->data['Agenda']['mensaje']        = $mensaje_seguimiento;
                                        $this->request->data['Agenda']['cliente_id']     = $this->request->data['cliente_id'];
                                        $this->Agenda->save($this->request->data);

                                        $this->LogCliente->create();
                                        $this->request->data['LogCliente']['id']         =  uniqid();
                                        $this->request->data['LogCliente']['cliente_id'] = $this->request->data['cliente_id'];
                                        $this->request->data['LogCliente']['user_id']    = $this->request->data['user_id'];
                                        $this->request->data['LogCliente']['datetime']   = date('Y-m-d H:i:s');
                                        $this->request->data['LogCliente']['accion']     = 4;
                                        $this->request->data['LogCliente']['mensaje']    = $mensaje_seguimiento;
                                        $this->LogCliente->save($this->request->data);

                                    * -------------------------------------------------------------------------- */

                                    $resp = array(
                                        'Ok' => true,
                                        'cotizacion' => 'Se creo la cotización'
                                    );

                                }

                            /* -------------------------------------------------------------------------- */

                        }else {

                            $resp = array(
                                'Ok' => false,
                                'mensaje' => 'Hubo un error al generar la cotización intente nuevamente'
                            );
                        }

                    /* -------------------------------------------------------------------------- */

                }else{

                    $resp = array(
                        'Ok' => false,
                        'mensaje' => 'Hubo un error intente nuevamente'
                    );

                }
            }else{

                $resp = array(
                    'Ok' => false,
                    'mensaje' => 'Hubo un error intente nuevamente'
                );

            }

            echo json_encode($resp, true);
            $this->autoRender = false;

        }

    /* -------------------------------------------------------------------------- */



    
}

