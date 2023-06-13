<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class CuentasController extends AppController {

    public $cuenta_id;
    public $components = array('Paginator');
    public $uses = array( 'DicEmbudoVenta', 'CuentasUser', 'Paramconfig', 'Mailconfig', 'Cuenta', 'User', 'CuentasUser', 'ConexionesExtern');
		
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('website','home','directorio', 'find_login', 'session_heartbeat', 'edit_password');
        $this->Session->write('CuentaUsuario',$this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$this->Session->read('Auth.User.id')))));

    }

    public function incon(){
        $this->layout = 'landing';
    }
    
    /* -------------------------------------------------------------------------- */
    /*                            Agregar nueva cuenta                            */
    /* -------------------------------------------------------------------------- */
    public function add(){
        
        if ($this->request->is('post')) {

            /**
             * 1.- Configuración de notificaciñon de correos.
             *  1.1.- Status de atención de clientes.
             * 2.- Configuración de servidor de correos de salida.
             * 3.- Creación de cuenta.
             * 4.- Creación de usuario super Admin.
             * 5.- Creación de cuentaUser.
             * 6.- Creación de carpetas de la cuenta.
             * 7.- Creación de diccionario de etapas.
             * 8.- Creación de diccionario de tipos de clientes.
             * 9.- Creación de diccionario de tipo de anuncios.
             * 10.- Creación de diccionario de tipo de propiedades.
             * 11.- Creación de diccionario de Lineas de contacto.
             * 12.- Envío de notificación de cuenta nueva.
             * 13.- Agregar en diccionario las 7 etapas para el embudo de ventas.
             * Fin del proceso.
            */

            /* ------------- 1.- Configuración de notificaciñon de correos. ------------- */
                /* ------------------ 1.1.- Status de atención de clientes. ----------------- */
            $this->request->data['Paramconfig']['mr']                       = 1;
            $this->request->data['Paramconfig']['to_mr']                    = $this->request->data['Cuenta']['correo_contacto'];
            $this->request->data['Paramconfig']['cc_mr']                    = $this->request->data['Cuenta']['correo_contacto'];
            $this->request->data['Paramconfig']['cco_mep']                  = $this->request->data['Cuenta']['correo_contacto'];
            $this->request->data['Paramconfig']['mep']                      = 1;
            $this->request->data['Paramconfig']['cc_mep']                   = 1;
            $this->request->data['Paramconfig']['ma']                       = 1;
            $this->request->data['Paramconfig']['sla_atrasados']            = 10;
            $this->request->data['Paramconfig']['sla_no_atendidos']         = 15;
            $this->request->data['Paramconfig']['vencimiento_propiedades']  = 30;
            $this->request->data['Paramconfig']['sla_oportuna']             = 5;
            $this->request->data['Paramconfig']['bmessage_new_client']      = "Gracias por su preferencia, en atención a su petición, le envío la información del desarrollo de su interés. Estoy a sus órdenes para cualquier duda o comentario.";
            $this->request->data['Paramconfig']['message_default_whatsapp'] = "Estimado(a) $nombre_cliente agradecemos su interés en nuestro proyecto, soy $nombre_asesor su asesor designado y me permito enviarle información del desarrollo. $URL Le reitero que estoy a sus órdenes para cualquier duda o comentario, gracias.";

            $this->Paramconfig->create();
            $this->Paramconfig->save($this->request->data);
            $idParamConfig = $this->Paramconfig->getInsertID();

            /* ----------- 2.- Configuración de servidor de correos de salida. ---------- */
            /* ----------------------------------------------------------------------------
            * No se definen las variables porque aun no se tienen en el primer contacto.
            * --------------------------------------------------------------------------- */
            $this->request->data['Mailconfig']['smtp']          = '';
            $this->request->data['Mailconfig']['usuario']       = $this->request->data['Cuenta']['correo_contacto'];
            $this->request->data['Mailconfig']['password']      = '';
            $this->request->data['Mailconfig']['puerto']        = '';
            $this->request->data['Mailconfig']['cuenta_correo'] = $this->request->data['Cuenta']['correo_contacto'];
            $this->Mailconfig->create();
            $this->Mailconfig->save($this->request->data);
            $idMailConfig = $this->Mailconfig->getInsertID();

            /* ------------------------- 3.- Creación de cuenta. ------------------------ */
            $this->request->data['Cuenta']['mailconfig_id']  = $idMailConfig;
            $this->request->data['Cuenta']['paramconfig_id'] = $idParamConfig;
            $this->request->data['Cuenta']['fecha_creacion'] = date('Y-m-d H:i:s');

            $this->Cuenta->save($this->request->data);
            $cuenta_id = $this->Cuenta->getInsertID();
            $this->cuenta_id = $cuenta_id;
            
            /* ------------------ 4.- Creación de usuario super Admin. ------------------ */
            $new_password = "Adryo.".date('Y');
            $this->request->data['User']['nombre_completo']    = "Superadministrador ".$this->request->data['Cuenta']['nombre_comercial'];
            $this->request->data['User']['foto']               = "user_no_photo.png";
            $this->request->data['User']['correo_electronico'] = $this->request->data['Cuenta']['correo_contacto'];
            $this->request->data['User']['password']           = $this->Auth->password($new_password);
            $this->request->data['User']['created']            = date('Y-m-d H:i:s');
            $this->User->create();
            $this->User->save($this->request->data);
            $user_id = $this->User->getInsertID();

            /* ----------------------- 5.- Creación de cuentaUser. ---------------------- */
            $this->request->data['CuentasUser']['cuenta_id']  = $cuenta_id;
            $this->request->data['CuentasUser']['user_id']    = $user_id;
            $this->request->data['CuentasUser']['group_id']   = 1;
            $this->request->data['CuentasUser']['activo']     = 1;
            $this->request->data['CuentasUser']['puesto']     = "Superadministrador";
            $this->request->data['CuentasUser']['opcionador'] = 1;
            $this->request->data['CuentasUser']['last_step']  = 1;
            $this->CuentasUser->create();
            $this->CuentasUser->save($this->request->data);

            /* ----------------- 6.- Creación de carpetas de la cuenta. ----------------- */
            mkdir(getcwd()."/files/cuentas/".$cuenta_id,0777);
            mkdir(getcwd()."/files/cuentas/".$cuenta_id."/desarrollos/",0777);
            mkdir(getcwd()."/files/cuentas/".$cuenta_id."/generales/",0777);
            mkdir(getcwd()."/files/cuentas/".$cuenta_id."/inmuebles/",0777);
            mkdir(getcwd()."/files/cuentas/".$cuenta_id."/users/",0777);
            mkdir(getcwd()."/files/cuentas/".$cuenta_id."/facturas/",0777);
            mkdir(getcwd()."/files/cuentas/".$cuenta_id."/aportaciones/",0777);
            
            /* ----------------- 7.- Creación de diccionario de etapas. ----------------- */
            // $this->loadModel('DicEtapa');
            // $etapas = array('Envío de 1er. correo automatizado','Primer contacto directo');
            // $this->request->data['DicEtapa']['cuenta_id'] = $cuenta_id;
            // foreach ($etapas as $etapa):
            //     $this->request->data['DicEtapa']['etapa'] = $etapa;
            //     $this->DicEtapa->create();
            //     $this->DicEtapa->save($this->request->data);
            // endforeach;
            
            // /* ------------ 8.- Creación de diccionario de tipos de clientes. ----------- */
            // $this->loadModel('DicTipoCliente');
            // $tipos = array('Final','Inversionista','Asesor Externo');
            // $this->request->data['DicTipoCliente']['cuenta_id'] = $cuenta_id;
            // foreach ($tipos as $tipo):
            //     $this->request->data['DicTipoCliente']['tipo_cliente'] = $tipo;
            //     $this->DicTipoCliente->create();
            //     $this->DicTipoCliente->save($this->request->data);
            // endforeach;
            
            // /* ------------ 9.- Creación de diccionario de tipo de anuncios. ------------ */
            // $this->loadModel('DicTipoAnuncio');
            // $anuncios = array('Brochure','Web','Redes Sociales','Campaña');
            // $this->request->data['DicTipoAnuncio']['cuenta_id'] = $cuenta_id;
            // foreach ($anuncios as $anuncio):
            //     $this->request->data['DicTipoAnuncio']['tipo_cliente'] = $anuncio;
            //     $this->DicTipoAnuncio->create();
            //     $this->DicTipoAnuncio->save($this->request->data);
            // endforeach;
            
            // /* ---------- 10.- Creación de diccionario de tipo de propiedades. ---------- */
            // $this->loadModel('DicTipoPropiedad');
            // $props = array('Casa','Departamento','Terreno','Oficina','Edificio','Bodega');
            // $this->request->data['DicTipoPropiedad']['cuenta_id'] = $cuenta_id;
            // foreach ($props as $prop):
            //     $this->request->data['DicTipoPropiedad']['tipo_propiedad'] = $prop;
            //     $this->DicTipoPropiedad->create();
            //     $this->DicTipoPropiedad->save($this->request->data);
            // endforeach;

            // /* ----------- 11.- Creación de diccionario de Lineas de contacto. ---------- */
            // $this->loadModel('DicLineaContactos');
            // $lineas = array('Sitio Web','Agente Comercial','Asesor','Redes Sociales','Evento','TV','Radio');
            // $this->request->data['DicLineaContactos']['cuenta_id'] = $cuenta_id;
            // foreach ($lineas as $linea):
            //     $this->request->data['DicLineaContactos']['linea_contacto'] = $linea;
            //     $this->DicLineaContactos->create();
            //     $this->DicLineaContactos->save($this->request->data);
            // endforeach;


            /* --------------- 12.- Envío de notificación de cuenta nueva. -------------- */
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
            $this->Email->template('bienvenida','layoutinmomail');

            $this->Email->viewVars(array('usuario'=>$this->request->data));
            $this->Email->from(array('notificaciones@adryo.com.mx'=>'Adryo'));
            $this->Email->to($this->request->data['Cuenta']['correo_contacto']);
            $this->Email->bcc(array('lbasurto@adryo.com.mx'=>'lbasurto@adryo.com.mx','eamezcua@adryo.com.mx'=>'eamezcua@adryo.com.mx','saak.hg.pv@gmail.com'=>'saak.hg.pv@gmail.com'));
            $this->Email->subject((isset($this->request->data['User']['subject']) ? $this->request->data['User']['subject'] : $this->request->data['Cuenta']['nombre_contacto'].": Bienvenido a Adryo"));
            $this->Email->send();

            /* --------------- 13.- Crear diccionario de embudo de ventas --------------- */
            $q_etapas       = 1;
            $etapas_default = array(
                1 => '1. INTERÉS PRELIMINAR',
                2 => '2. COMUNICACIÓN ABIERTA',
                3 => '3. PRECALIFICACIÓN',
                4 => '4. VISITA',
                5 => '5. ANÁLISIS DE OPCIONES',
                6 => '6. VALIDACIÓN DE RECURSOS',
                7 => '7. CIERRE'
            );
            
            foreach( $etapas_default as $etapas ){
                
                $this->request->data['DicEmbudoVenta']['nombre']    = $etapas;
                $this->request->data['DicEmbudoVenta']['orden']     = $q_etapas;
                $this->request->data['DicEmbudoVenta']['cuenta_id'] = $this->cuenta_id;
                $this->DicEmbudoVenta->create();
                $this->DicEmbudoVenta->save($this->request->data['DicEmbudoVenta']);

                $q_etapas ++;

            }

            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Se ha creado exitosamente la cuenta, hemos enviado un correo con indicaciones iniciales.', 'default', array(), 'm_success');
            $this->redirect(array('action' => 'add'));
            
        }

    }
    
    public function home($sufix = null){
        $this->loadModel('DicTipoPropiedad');
        $cuenta = $this->Cuenta->find('first',array('conditions'=>array('Cuenta.sufix_website'=>$sufix)));
        $this->set('cuenta',$cuenta);
        $this->set('tipo_propiedades',$this->DicTipoPropiedad->find('list',array('conditions'=>array('DicTipoPropiedad.cuenta_id'=>$cuenta['Cuenta']['id']))));
        $this->layout = "client_website_".$cuenta['Cuenta']['template_website'];
    }
    
    public function directorio ($sufix = null){
        $this->loadModel('DicTipoPropiedad');
        $this->loadModel('Inmueble');
        $cuenta = $this->Cuenta->find('first',array('conditions'=>array('Cuenta.sufix_website'=>$sufix)));
        $this->set('cuenta',$cuenta);
        $this->set('tipo_propiedades',$this->DicTipoPropiedad->find('list',array('conditions'=>array('DicTipoPropiedad.cuenta_id'=>$cuenta['Cuenta']['id']))));
        $this->layout = "directorio_website_".$cuenta['Cuenta']['template_website'];
        if ($this->request->is('post')){
            $tipo_propiedad = $this->request->data['Cuenta']['tipo_inmueble']; 
            $venta_renta = $this->request->data['Cuenta']['venta_renta'];
            $conditions = array(
                'Inmueble.cuenta_id'=>$cuenta['Cuenta']['id'],
                'Inmueble.liberada'=>1,
                'Inmueble.dic_tipo_propiedad_id' => $tipo_propiedad,
                'Inmueble.venta_renta'=>$venta_renta
            );
            $this->set('propiedades',$this->Inmueble->find('all',array('conditions'=>$conditions)));
        }else{
        $this->set('propiedades',$this->Inmueble->find('all',array('conditions'=>array('Inmueble.cuenta_id'=>$cuenta['Cuenta']['id'],'Inmueble.liberada'=>1))));
        }
        
    }
    
    public function edit(){
        $cuenta = $this->Cuenta->read(null,$this->Session->read('CuentaUsuario.Cuenta.id'));
        $this->set('cuenta', $cuenta);

        if ($this->request->is(array('post', 'put'))) {
            //Completar Información de Usuario
            if (isset($this->request->data['Cuenta']['logo']) && $this->request->data['Cuenta']['logo']['name']!=""){
                $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/generales/".$this->request->data['Cuenta']['logo']['name'];
                move_uploaded_file($this->request->data['Cuenta']['logo']['tmp_name'],$filename);
                $logo = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/generales/".$this->request->data['Cuenta']['logo']['name'];
                $this->request->data['Cuenta']['logo'] = $logo;
            }else{
                $this->request->data['Cuenta']['logo'] = $cuenta['Cuenta']['logo'];
            }
            // $this->Cuenta->create();
            $this->Cuenta->save($this->request->data);
            
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('La información inicial se ha cargado exitosamente.', 'default', array(), 'm_success');

            return $this->redirect(array('controller' => 'users','action'=>'parametrizacion'));
            //echo var_dump($this->request->data);
        }
    }
    
    /* ------------ Metodo para reestablecer la contraseña de usuario ------------ */
    public function edit_password(){
        /* --------- Se carga el layout que llevará la vista ------------ */
        $this->layout    = 'login';

        if ($this->request->is('post')) {

            /* ----- Consulta los datos de la cuenta ligados al correo ingresado en el formulario ----- */
            $userid_pass = $this->User->find('first', array('conditions' => array('correo_electronico'=>$this->request->data['Cuenta']['correo_electronico']), 'contain' => false));


            /* ------ Correo para el cuál se reestablecerá la contraseña de acceso y al cuál, será enviada una vez generada -------- */
            $user_email=$this->request->data['Cuenta']['correo_electronico'];

            /* ------ Generación de contraseña aleatoria -------- */
            $pass_reset= uniqid();

            /* -----Se verifica que el correo ingresado exista en la base de datos  --*/
            if (empty($userid_pass)) {
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash( "¡El correo no esta registrado! Vuelva a Intentarlo!" , 'default', array(), 'm_success');
            } else{

            /* ---- Se obtiene el nombre del usuario, para ocuparlo en el layout del correo a enviar  ----*/
                $user_name= $userid_pass['User']['nombre_completo'];


            /* ------- Establece la condición para modificar la contraseña ------- */
                $this->request->data['User']['id']= $userid_pass['User']['id'];

            /* ------- Modifica y Encripta la contraseña antes generada de manera aleatoria------- */
                $this->request->data['User']['password'] = $this->Auth->password($pass_reset);

            /* ----- Verifica que el proceso de modificacion de contraseña ----- */
                if ($this->User->save($this->request->data)) {

                /* ----- Obtiene los parametros de configuracion para el envio de correo----- */
                    $cuenta     = $this->Cuenta->findFirstById($userid_pass['Rol']['0']['cuentas_users']['cuenta_id']);
                    $mailconfig = $this->Mailconfig->findFirstById( $cuenta['Cuenta']['mailconfig_id']);

                    $this->Email = new CakeEmail();
                    $this->Email->config(array(

                        /*'host' => 'mail.bosinmobiliaria.com',
                        'port' => 587,
                        'username' => 'sistemabos@bosinmobiliaria.com',
                        'password' => 'Sistema.2018',
                        'transport' => 'Smtp'*/

                        'host'      => $mailconfig['Mailconfig']['smtp'],
                        'port'      => $mailconfig['Mailconfig']['puerto'],
                        'username'  => $mailconfig['Mailconfig']['usuario'],
                        'password'  => $mailconfig['Mailconfig']['password'],
                        'transport' => 'Smtp'
                        )
                    );

                  $this->Email->emailFormat('html');

                  /** Layout/vista que llevará el correo en HTML View/Emails/html **/
                  $this->Email->template('emailresetpass');
                  $this->Email->from(array('sube@adryo.com.mx'=>'ADRYO'));
                  $this->Email->to($user_email);
                  $this->Email->subject('Solicitud de Reestablecimiento de Contraseña');
                  $this->Email->viewVars(array('namePass'=>$user_name, 'pass'=>$pass_reset));
                  $this->Email->send();

                  $this->Session->setFlash('', 'default', array(), 'success');
                  $this->Session->setFlash( "¡Su contraseña se ha reestablecido Correctamente! <br> En breve recibirá un correo con su nueva contraseña!", 'default', array(), 'm_success');

                } else{
                    $this->Session->setFlash('', 'default', array(), 'success');
                    $this->Session->setFlash( "¡Ocurrio un error! Favor de contactar con el administrador", 'default', array(), 'm_success');
                }
                return $this->redirect(array('controller'=>'users','action'=>'login'));

            }

        }

    }

    public function view(){
        $this->loadModel('Paramconfig');
        $this->set('cuenta', $this->Cuenta->find('first', array( 'conditions' => array('Cuenta.id'=> $this->Session->read('CuentaUsuario.Cuenta.id')))));
        $this->set('parametros', $this->Paramconfig->find('first', array('conditions'=>array('Paramconfig.id'=>$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')))));

        // Consulta de la conexión con mappen
        $this->set('mappen', $this->ConexionesExtern->find('first', array(
            'conditions' => array(
                'ConexionesExtern.cuenta_id'      => $this->Session->read('CuentaUsuario.Cuenta.id'),
                'ConexionesExtern.nombre_externo' => 'Mappen'
            )
        )));

    }

    public function kpi_desarrollos(){
        if ($this->request->is('post')){
            $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
            $mes_pasado = date('Y-m-t', strtotime("last month"));
            $mes_actual = date('Y-m-01');
            $fin_kpi = date('Y-m-01',strtotime("+1 year"));
            for($i=0 ; $i<$this->request->data['Cuenta']['contador'];$i++){
                if ($this->request->data['Cuenta']['meta_v'.$i]!="" && $this->request->data['Cuenta']['meta_q'.$i]!=""){
                    $meta_v = $this->request->data['Cuenta']['meta_v'.$i];
                    $meta_q = $this->request->data['Cuenta']['meta_q'.$i];
                    $desarrollo_id = $this->request->data['Cuenta']['desarrollo_id'.$i];
                    //Actualizar Registro viejo
                    if ($this->request->data['Cuenta']['registro_id'.$i]!=""){
                        $registro_id = $this->request->data['Cuenta']['registro_id'.$i];
                        $this->Cuenta->query("UPDATE objetivos_ventas_desarrollos SET fin ='$mes_pasado' WHERE id = $registro_id");
                    }
                    //Crear registro para nuevo KPI
                    $query = "INSERT INTO objetivos_ventas_desarrollos VALUES(0,$cuenta_id,$desarrollo_id,$meta_v,'$mes_actual','$fin_kpi',$meta_q)";
                    $this->Cuenta->query($query);
                    //echo $query;

                }
            }
            $this->Session->setFlash(__('Los indicadores se han actualizado exitosamente'),'default',array('class'=>'mensaje_exito'));
            return $this->redirect(array('controller'=>'cuentas','action'=>'kpi_desarrollos'));
        }else{
            $this->loadModel('Desarrollo');
            $this->Desarrollo->Behaviors->load('Containable');
            $desarrollos = $this->Desarrollo->find(
                'all',
                array(
                    'fields'=>array('id','nombre'),
                    'contain'=>false,
                    'conditions'=>array(
                        'OR'=>array(
                            'Desarrollo.cuenta_id'=> $this->Session->read('CuentaUsuario.Cuenta.id'),
                            'Desarrollo.comercializador_id'=> $this->Session->read('CuentaUsuario.Cuenta.id'),
                        )
                    )
                )
            );
            $last_kpi = $this->Desarrollo->query("SELECT id, desarrollo_id, monto, unidades, fin FROM objetivos_ventas_desarrollos a WHERE fin IN (SELECT MAX(fin) FROM objetivos_ventas_desarrollos WHERE a.desarrollo_id = desarrollo_id);");
            $kpi_arreglo = array();
            foreach($last_kpi as $kpi):
                $kpi_arreglo[$kpi['a']['desarrollo_id']]['monto'] = $kpi['a']['monto'];
                $kpi_arreglo[$kpi['a']['desarrollo_id']]['unidades'] = $kpi['a']['unidades'];
                $kpi_arreglo[$kpi['a']['desarrollo_id']]['fin'] = $kpi['a']['fin'];
                $kpi_arreglo[$kpi['a']['desarrollo_id']]['registro_id'] = $kpi['a']['id'];
            endforeach;
            $this->set(compact('desarrollos'));
            $this->set(compact('kpi_arreglo'));
        }    
    }

    public function kpi_usuarios(){
        if($this->request->is('post')){
            $this->loadModel('CuentasUser');
            $contador = $this->request->data['Cuenta']['contador'];
            for($i=0;$i<$contador ; $i++){
                $registro = array(
                    'id'=>$this->request->data['Cuenta']['id'.$i],
                    'ventas_mensuales'=>$this->request->data['Cuenta']['ventas_mensuales'.$i],
                    'ventas_mensuales_q'=>$this->request->data['Cuenta']['ventas_mensuales_q'.$i],
                );
                $this->CuentasUser->create();
                $this->CuentasUser->save($registro);
            }
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash( 'Los indicadores han sido actualizados exitosamente.' , 'default', array(), 'm_success');
            return $this->redirect(array('controller'=>'cuentas','action'=>'kpi_usuarios'));
        }else{
            $this->loadModel('User');
            $this->User->Behaviors->load('Containable');
            $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
            $users = $this->User->find(
                'all',
                array(
                    'conditions'=>array(
                        "User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = $cuenta_id AND group_id IN (1,2,3,4))",
                        "User.status"=>1,
                    ),
                    // 'contain'=>array(
                    //     'GruposUsuario'
                    // ),
                    'fields'=>array(
                        'id','nombre_completo'
                    )
                )
            );
            $this->set('users',$users);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                       Metodo para eliminar la cuenta                       */
    /* -------------------------------------------------------------------------- */
    public function delete_cuenta( $cuenta_id = null ){
        $cuenta = $this->Cuenta->find('first', array('conditions' => array( 'Cuenta.id' => $cuenta_id )));

        $this->Cuenta->id = $cuenta_id;
		if ($this->Cuenta->delete()) {
            
            rmdir(getcwd()."/files/cuentas/".$cuenta_id);
            rmdir(getcwd()."/files/cuentas/".$cuenta_id."/desarrollos");
            rmdir(getcwd()."/files/cuentas/".$cuenta_id."/generales");
            rmdir(getcwd()."/files/cuentas/".$cuenta_id."/inmuebles");
            rmdir(getcwd()."/files/cuentas/".$cuenta_id."/users");
            rmdir(getcwd()."/files/cuentas/".$cuenta_id."/facturas");
            rmdir(getcwd()."/files/cuentas/".$cuenta_id."/aportaciones");

            echo "Se elimino correctamente";
        }

        echo '<pre>';
        print_r ( $cuenta );
        echo '</pre>';


        $this->autoRender = false;
    } 

    /* ----------- Este metodo es para ver la foto de perfil en login ----------- */
    public function find_login(){
        $this->loadModel('User');
        $this->User->Behaviors->load('Containable');

        $usuario = $this->User->find('first',
            array(
                'contain' => false,
                'fields' => 'foto',
                'conditions' => array(
                    'correo_electronico' => $this->request->data['email']
                )
            )
        );
        
        $response['data'] = $usuario;

        echo json_encode( $response );
        $this->autoRender = false;

    }

    /* ------------ Metodo para revisar la sesion activa del usuario ------------ */
    public function session_heartbeat(){
        header('Content-type: application/json; charset=utf-8');
        $response = array(
            'flag'    => true,
            'message' => 'La session sigue activa'
        );
        

        if( empty( $this->Session->read('Auth.User') ) ){
            // La variable esta vacia
            $response['flag']    = false;
            $response['message'] = 'Lo sentimos la session ha expirado favor de volver a ingresar';
        }

        echo json_encode( $response );
        exit();
        $this->autoRender = false;
    }

    /* -------------------- Notificación de nuevos clientes. -------------------- */
    /**
     * Este metodo notifica a los superadmins de nuevos clientes 
     * ingresados a la base de datos
    */ 
    public function new_customer_notification(){

        // Paso 1 Busqueda de clietnes creados en el dia anterior.

        // 1.-1 Busqueda por cuenta
        // 1.-2 Busqueda por fecha de creacion del dia anterior.
        $clientes = $this->Cliente->find('all',
            array(
                'conditions' => array(
                    'Cliente.cuenta_id' => $this->Session->read('Cuenta.id'),
                    'Cliente.created' 
                )
            )
        );


        // Paso 2 Condicion si se require mandar el correo a los superadmins
        // Paso 3 Envio de correo con todos los clientes nuevos ingresados el dia anterior


        // if ( $paramconfig['Paramconfig']['mr'] == 1 ){
        //     $this->Email = new CakeEmail();
        //     $this->Email->config(array(
        //             'host'      => $mailconfig['Mailconfig']['smtp'],
        //             'port'      => $mailconfig['Mailconfig']['puerto'],
        //             'username'  => $mailconfig['Mailconfig']['usuario'],
        //             'password'  => $mailconfig['Mailconfig']['password'],
        //             'transport' => 'Smtp'
        //             )
        //         );
        //     $this->Email->emailFormat('html');
        //     $this->Email->template('emailaacallcenter','layoutinmomail');
        //     $this->Email->from(array('notificaciones@adryo.com.mx'=>'Notificaciones Adryo'));
            
        //     if ( $paramconfig['Paramconfig']['nuevo_cliente'] != ""){
        //       $emails2 = explode( ",", $paramconfig['Paramconfig']['nuevo_cliente'] );
        //       $arreglo_emails2 = array();
        //       if (sizeof($emails2)>0){
        //           foreach($emails2 as $email):
        //               $arreglo_emails2[$email] = $email;
        //           endforeach;
        //       }else{
        //           $arreglo_emails2[$paramconfig['Paramconfig']['nuevo_cliente']] = $paramconfig['Paramconfig']['nuevo_cliente'];
        //       }
              
        //       $this->Email->to( $arreglo_emails2 );
        //       $subject = "Registro de un nuevo cliente en la base de datos";
        //       if ( sizeof( $propiedades ) > 0 && sizeof( $desarrollos ) < 1 ){
        //           $subject = "Registro de un nuevo cliente en la base de datos - ". $propiedades[0]['Inmueble']['titulo']." ".$propiedades[0]['Inmueble']['venta_renta'];
        //       }
        //       if( sizeof( $propiedades ) < 1 && sizeof( $desarrollos ) > 0 ){
        //           $subject = "Registro de un nuevo cliente en la base de datos - ". $desarrollos[0]['Desarrollo']['nombre'];
        //       }
        //       if( sizeof( $propiedades ) > 0 && sizeof( $desarrollos ) > 0 ){
        //           $subject = "Registro de un nuevo cliente en la base de datos - ". $propiedades[0]['Inmueble']['titulo']." ".$propiedades[0]['Inmueble']['venta_renta'] ." e Interesado en ".$desarrollos[0]['Desarrollo']['nombre'];
        //       }
        //       $this->Email->subject($subject);
        //       $this->Email->viewVars(array('cliente' => $cliente,'propiedades'=>$propiedades, 'desarrollos'=>$desarrollos,'usuario'=>$usuario));
        //       $this->Email->send();
        //     }
            
        // }
    }


    /**
     * Funcion para panel de control
     * Aka RogueOne
    */
    function control_panel(){
        $this->loadModel('Paramconfig');
        $this->loadModel('Group');
        $this->loadModel('Cuenta');
        $this->Group->Behaviors->load('Containable');
        $this->Paramconfig->Behaviors->load('Containable');
        $this->Cuenta->Behaviors->load('Containable');
        $this->set('cuenta', $this->Cuenta->find('first', array( 'conditions' => array('Cuenta.id'=> $this->Session->read('CuentaUsuario.Cuenta.id')))));
        $this->set('parametros', $this->Paramconfig->find('first', array('conditions'=>array('Paramconfig.id'=>$this->Session->read('CuentaUsuario.Cuenta.paramconfig_id')))));
        $permisos=$this->Group->find('first',array(
            'conditions'=>array('Group.id'=> 3),
            'fields' => array(
                'uvall' ,
                'uc' ,
                'ue' ,
                'ur' ,
                'ud' ,
                'gc' ,
                'ge' ,
                'gr' ,
                'gd' ,
                'ic' ,
                'ie' ,
                'ir' ,
                'idel' ,
                'dc' ,
                'de' ,
                'dr' ,
                'dlcall' ,
                'dlvl' ,
                'dd' ,
                'cc' ,
                'ce' ,
                'cca' ,
                'call' ,
                'cown' ,
                'rc' ,
                'cd' ,
                'oc' ,
                'oe' ,
                'or' ,
                'od' ,
                'idest' ,
                'ilib' ,
                'mc' ,
                'md' ,
                'vv' ,
                'cr' ,
                'ac' ,
                'ad' ,
                'ar' ,
                'ae' ,
                'facAll' ,
                'cbde' ,
                'cbdd' ,
                'cbdc' ,
                'dashGView' ,
                'dcc'
            )
        ));
        $i=0;
        foreach ($permisos['Group'] as $key => $value) {
            switch ( $key) {
                case 'uvall':
                    $response[$i]['nombre']='Ver Todos los  Usuarios';
                break;
                case 'uc':
                    $response[$i]['nombre']='Crear usuario';
                break;
                case 'ue':
                    $response[$i]['nombre']='Editar Usuario';
                break;
                case 'ur':
                    $response[$i]['nombre']='Reescritura del usuario';
                break;
                case 'ud':
                    $response[$i]['nombre']='Eliminar Usuario';
                break;
                case 'gc':
                    $response[$i]['nombre']='Crear Grupo';
                break;
                case 'ge':
                    $response[$i]['nombre']='Editar Grupos';
                break;
                case 'gr':
                    $response[$i]['nombre']='Reescritura del Grupo';
                break;
                case 'gd':
                    $response[$i]['nombre']='Eliminar Grupos';
                break;
                case 'ic':
                    $response[$i]['nombre']='Crear Inmueble';
                break;
                case 'ie':
                    $response[$i]['nombre']='Editar Inmueble';
                break;
                case 'ir':
                    $response[$i]['nombre']='Reescritura del  Inmueble';
                break;
                case 'idel':
                    $response[$i]['nombre']='Eliminar  Inmueble';
                break;
                case 'dc':
                    $response[$i]['nombre']='Crear Desarrollo';
                break;
                case 'de':
                    $response[$i]['nombre']='Editar Desarrollo';
                break;
                case 'dr':
                    $response[$i]['nombre']='Reescritura del Desarrollo';
                break;
                case 'dlcall':
                    $response[$i]['nombre']='Desarrollos Lista Clientes Todos';
                break;
                case 'dlvl':
                    $response[$i]['nombre']='Listado de Desarrollos Libres ';
                break;
                case 'dd':
                    $response[$i]['nombre']='Eliminar Desarrollo';
                break;
                case 'cc':
                    $response[$i]['nombre']='Crear Cliente';
                break;
                case 'ce':
                    $response[$i]['nombre']='Editar Cliente';
                break;
                case 'cca':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'call':
                    $response[$i]['nombre']='Todos los Clientes';
                break;
                case 'cown':
                    $response[$i]['nombre']='Clientes Con Nuestras Propiedades';
                break;
                case 'rc':
                    $response[$i]['nombre']=' Cliente';
                break;
                case 'cd':
                    $response[$i]['nombre']='Eliminar Cliente';
                break;
                case 'oc':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'oe':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'or':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'od':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'idest':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'ilib':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'mc':
                    $response[$i]['nombre']='Crear Mensaje';
                break;
                case 'md':
                    $response[$i]['nombre']='Eliminar Mensaje';
                break;
                case 'vv':
                    $response[$i]['nombre']='No se Sabe';
                break;
                case 'cr':
                    $response[$i]['nombre']='Reescritura Cliente';
                break;
                case 'ac':
                    $response[$i]['nombre']='Crear Agenda';
                break;
                case 'ad':
                    $response[$i]['nombre']='Eliminar Agenda';
                break;
                case 'ar':
                    $response[$i]['nombre']='Reescritura Agenda';
                break;
                case 'ae':
                    $response[$i]['nombre']='Editar Agenda';
                break;
                case 'facAll':
                    $response[$i]['nombre']='Todas las Facturas';
                break;
                case 'cbde':
                    $response[$i]['nombre']='Editar Cuentas Bancarias del Desarrollo';
                break;
                case 'cbdd':
                    $response[$i]['nombre']='Eliminar Cuentas Bancarias del Desarrollo';
                break;
                case 'cbdc':
                    $response[$i]['nombre']='Crear Cuentas Bancarias del Desarrollo';
                break;
                case 'dashGView':
                    $response[$i]['nombre']='Ver el dasarrollo';
                break;
                case 'dcc':
                    $response[$i]['nombre']='Eliminar cotizacion';
                break;

            }
            $response[$i]['nombre_base']=$key;
            if ($value == null) {
                $response[$i]['valor'] =false;
                
            }else {
                $response[$i]['valor'] =$value;
            }
            $i++;
        }
        $this->set(compact('response'));
    }

    /**
     * Funcion para listado de roles en panel de control
     * AKA RogueOne
    */
    public function lista_rol() {

        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Group');
        $this->Group->Behaviors->load('Containable');

        $cuenta_id = $this->request->data['cuenta_id'];

        if ($this->request->is('post') && $this->request->data['api_key'] != null  && $cuenta_id != null) {

            $roles = $this->Group->find('all', array(
                'conditions'=> array(
                    'OR' => array(
                        'Group.cuenta_id'=> $cuenta_id,
                        'Group.id' => array(1,2,3)
                    )
                ),
                'contain' => false,
                'order' => array(
                    'Group.nombre'=> 'ASC',
                )
            ));

            //response

                $response = array(
                    'Ok' => true,
                    'mensaje' => $roles
                );

            /* -------------------------------------------------------------------------- */


        } else {

            //response

                $response = array(
                    'Ok' => false,
                    'mensaje' => 'Hubo un error intente nuevamente'
                );

            /* -------------------------------------------------------------------------- */

        }

        echo json_encode( $response , true );
        exit();
        $this->autoRender = false;

    }

    /**
     * Funcion para visualizar los permisos
     * AKA RogueOne
    */
    public function view_permisos(){
        $this->loadModel('Paramconfig');
        $this->loadModel('Group');
        $this->Group->Behaviors->load('Containable');

        $respon   = [];
        $response = [];
        $i        = 0;

        if ($this->request->is('post')) {

            $permisos=$this->Group->find('first',array(
                'conditions'=>array('Group.id'=> 1),
                'fields'=> array(
                        'uvall' ,
                        'uc' ,
                        'ue' ,
                        'ur' ,
                        'ud' ,
                        'gc' ,
                        'ge' ,
                        'gr' ,
                        'gd' ,
                        'ic' ,
                        'ie' ,
                        'ir' ,
                        'idel' ,
                        'dc' ,
                        'de' ,
                        'dr' ,
                        'dlcall' ,
                        'dlvl' ,
                        'dd' ,
                        'cc' ,
                        'ce' ,
                        'cca' ,
                        'call' ,
                        'cown' ,
                        'rc' ,
                        'cd' ,
                        'oc' ,
                        'oe' ,
                        'or' ,
                        'od' ,
                        'idest' ,
                        'ilib' ,
                        'mc' ,
                        'md' ,
                        'vv' ,
                        'cr' ,
                        'ac' ,
                        'ad' ,
                        'ar' ,
                        'ae' ,
                        'facAll' ,
                        'cbde' ,
                        'cbdd' ,
                        'cbdc' ,
                        'dashGView' ,
                        'dcc',
                        'cun',
                        'vpl',
                        'vu',
                        'vgw',
                )
            ));

            foreach ($permisos['Group'] as $key => $value){
                
                switch( $key ){
                    // case 'uvall':
                    //     $response['Usuario'][$i]['key'] = $key;
                    //     $response['Usuario'][$i]['label'] = 'Ver Todos los  Usuarios';
                    // break;
                    // case 'gd':
                    //     $response['Grupo'][$i]['key'] = $key;
                    //     $response['Grupo'][$i]['label']='Eliminar Grupos';
                    // break;

                    case 'uvall':
                            $response['Usuario'][$i]['key']   = $key;
                            $response['Usuario'][$i]['label'] = 'Ver Todos los  Usuarios';
                    break;
                    case 'uc':
                            $response['Usuario'][$i]['key']   = $key;
                            $response['Usuario'][$i]['label'] = 'Crear usuario';
                    break;
                    case 'ue':
                            $response['Usuario'][$i]['key']   = $key;
                            $response['Usuario'][$i]['label'] = 'Editar Usuario';
                    break;
                    case 'ur':
                            $response['Usuario'][$i]['key']   = $key;
                            $response['Usuario'][$i]['label'] = 'Reescritura del usuario';
                    break;
                    case 'ud':
                            $response['Usuario'][$i]['key']   = $key;
                            $response['Usuario'][$i]['label'] = 'Eliminar Usuario';
                    break;
                    case 'gc':
                            $response['Grupo'][$i]['key']   = $key;
                            $response['Grupo'][$i]['label'] = 'Crear Grupo';
                    break;
                    case 'ge':
                            $response['Grupo'][$i]['key']   = $key;
                            $response['Grupo'][$i]['label'] = 'Editar Grupos';
                    break;
                    case 'gr':
                            $response['Grupo'][$i]['key']   = $key;
                            $response['Grupo'][$i]['label'] = 'Reescritura del Grupo';
                    break;
                    case 'gd':
                            $response['Grupo'][$i]['key']   = $key;
                            $response['Grupo'][$i]['label'] = 'Eliminar Grupos';
                    break;
                    case 'ic':
                            $response['Inmueble'][$i]['key']   = $key;
                            $response['Inmueble'][$i]['label'] = 'Crear Inmueble';
                    break;
                    case 'ie':
                            $response['Inmueble'][$i]['key']   = $key;
                            $response['Inmueble'][$i]['label'] = 'Editar Inmueble';
                    break;
                    case 'ir':
                            $response['Inmueble'][$i]['key']   = $key;
                            $response['Inmueble'][$i]['label'] = 'Reescritura del  Inmueble';
                    break;
                    case 'idel':
                            $response['Inmueble'][$i]['key']   = $key;
                            $response['Inmueble'][$i]['label'] = 'Eliminar  Inmueble';
                    break;
                    case 'dc':
                            $response['Desarrollo'][$i]['key']   = $key;
                            $response['Desarrollo'][$i]['label'] = 'Crear Desarrollo';
                    break;
                    case 'de':
                            $response['Desarrollo'][$i]['key']   = $key;
                            $response['Desarrollo'][$i]['label'] = 'Editar Desarrollo';
                    break;
                    case 'dr':
                            $response['Desarrollo'][$i]['key']   = $key;
                            $response['Desarrollo'][$i]['label'] = 'Reescritura del Desarrollo';
                    break;
                    case 'dlcall':
                            $response['Desarrollo'][$i]['key']   = $key;
                            $response['Desarrollo'][$i]['label'] = 'Desarrollos Lista Clientes Todos';
                    break;
                    case 'dlvl':
                            $response['Desarrollo'][$i]['key']   = $key;
                            $response['Desarrollo'][$i]['label'] = 'Listado de Desarrollos Libres ';
                    break;
                    case 'dd':
                            $response['Desarrollo'][$i]['key']   = $key;
                            $response['Desarrollo'][$i]['label'] = 'Eliminar Desarrollo';
                    break;
                    case 'cc':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Crear Cliente';
                    break;
                    case 'ce':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Editar Cliente';
                    break;
                    case 'cca':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'call':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Todos los Clientes';
                    break;
                    case 'cown':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Clientes Con Nuestras Propiedades';
                    break;
                    case 'rc':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']=' Cliente';
                    break;
                    case 'cd':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Eliminar Cliente';
                    break;
                    case 'oc':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'oe':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'or':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'od':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'idest':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'ilib':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'mc':
                            $response['Mensaje'][$i]['key']= $key;
                            $response['Mensaje'][$i]['label']='Crear Mensaje';
                    break;
                    case 'md':
                            $response['Mensaje'][$i]['key']= $key;
                            $response['Mensaje'][$i]['label']='Eliminar Mensaje';
                    break;
                    case 'vv':
                            $response[$i]['key']= $key;
                            $response[$i]['label']='No se Sabe';
                    break;
                    case 'cr':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Reescritura Cliente';
                    break;
                    case 'ac':
                            $response['Agenda'][$i]['key']= $key;
                            $response['Agenda'][$i]['label']='Crear Agenda';
                    break;
                    case 'ad':
                            $response['Agenda'][$i]['key']= $key;
                            $response['Agenda'][$i]['label']='Eliminar Agenda';
                    break;
                    case 'ar':
                            $response['Agenda'][$i]['key']= $key;
                            $response['Agenda'][$i]['label']='Reescritura Agenda';
                    break;
                    case 'ae':
                            $response['Agenda'][$i]['key']= $key;
                            $response['Agenda'][$i]['label']='Editar Agenda';
                    break;
                    case 'facAll':
                            $response['Finanzas'][$i]['key']= $key;
                            $response['Finanzas'][$i]['label']='Todas las Facturas';
                    break;
                    case 'cbde':
                            $response['Desarrollo'][$i]['key']= $key;
                            $response['Desarrollo'][$i]['label']='Editar Cuentas Bancarias del Desarrollo';
                    break;
                    case 'cbdd':
                            $response['Desarrollo'][$i]['key']= $key;
                            $response['Desarrollo'][$i]['label']='Eliminar Cuentas Bancarias del Desarrollo';
                    break;
                    case 'cbdc':
                            $response['Desarrollo'][$i]['key']= $key;
                            $response['Desarrollo'][$i]['label']='Crear Cuentas Bancarias del Desarrollo';
                    break;
                    case 'dashGView':
                            $response['Desarrollo'][$i]['key']= $key;
                            $response['Desarrollo'][$i]['label']='Ver el desarrollo';
                    break;
                    case 'dcc':
                            $response['Cliente'][$i]['key']= $key;
                            $response['Cliente'][$i]['label']='Eliminar cotizacion';
                    break;
                    case 'cun':
                        $response['Cliente'][$i]['key']= $key;
                        $response['Cliente'][$i]['label']='Cliente sin Asignar';
                    break;
                    case 'vpl':
                        $response['Cliente'][$i]['key']= $key;
                        $response['Cliente'][$i]['label']='Vista de embudo de ventas';
                    break;
                    case 'vu':
                        $response['Usuario'][$i]['key']= $key;
                        $response['Usuario'][$i]['label']='Vista de Usuarios';
                    break;
                    case 'vgw':
                        $response['Grupo'][$i]['key']= $key;
                        $response['Grupo'][$i]['label']='Vista de Grupos de usuarios Usuarios';
                    break;

                }
                $i++;

            }

            $respon = array(
                'Ok' => true,
                'mensaje' => $response
            );

        }

        echo json_encode( $respon , true );
        exit();
        $this->autoRender = false;

    }

    /***
     * function para agregar nuevo roll
     * AKA RogueOne 
     */
    function new_roll(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Group');
        $this->Group->Behaviors->load('Containable');
        $response=[];
        if ( $this->request->is('post')  ) {
    
                $cuenta_id=$this->request->data['Group']['cuenta_id'];
    
                    $name = $this->request->data['Group']['nombre'];
                    $rol_ya_axiste=$this->Group->find('first',array(
                        'conditions'=>array(
                            'Group.cuenta_id'=> $cuenta_id,
                            'Group.nombre LIKE'=> '%'.$name,
                        ),
                        'fields' => array(
                            'cuenta_id' ,
                        )
                    ));
    
                    if ($rol_ya_axiste != null) {
                        
                        $response = array(
                            'Ok' => false,
                            'mensaje' => 'El roll ya existe'
                        );
    
                    }else {
                        $this->Group->create();
                        $name = $this->request->data['Group']['nombre'];
                        $this->request->data['Group']['cuenta_id']   = $cuenta_id;
                        $this->request->data['Group']['descripcion'] = 'Nuevo roll ';
                        $this->Group->save($this->request->data['Group']);
                        $response = array(
                            'Ok' => true,
                            'mensaje' => 'Se ha creado un nuevo rol'
                        );
                    }
    
        }else {
    
          $response = array(
            'Ok' => false,
            'mensaje' => 'Hubo un error intente nuevamente'
          );
    
        }

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success');

        echo json_encode( $response, true );
        exit();
        $this->autoRender = false;
    }

    /**
     * Funcion para editar los roles
    */
    function edit_roll(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('Group');
        $this->Group->Behaviors->load('Containable');
        $response=[];
    
        if ( $this->request->is('post')  ) {
    
            $this->request->data['Group']['descripcion'] = 'Editar roll ';
            if( $this->Group->save($this->request->data['Group']) ){
                
                $response = array(
                    'Ok' => true,
                    'mensaje' => 'Se actualizo el Rol'
                );

            }
    
        }else {
    
            $response = array(
                'Ok' => false,
                'mensaje' => 'Hubo un error intente nuevamente'
            );
    
        }
        
        $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash( $response['mensaje'] , 'default', array(), 'm_success');

        echo json_encode( $response, true );
        exit();
        $this->autoRender = false;
    }

}

?>