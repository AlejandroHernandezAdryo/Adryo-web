<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'ImageTool');
/**
 * Inmuebles Controller
 *
 * @property Inmueble $Inmueble
 * @property PaginatorComponent $Paginator
 */
class InmueblesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $helpers = array('GoogleMap');
	public $uses = array(
            'Inmueble','Desarrollo','DesarrolloInmueble','User','FotoInmueble',
            'Cliente','LogInmueble','DocumentosUser','Precio','DicTipoAnuncio',
            'DicUbicacionAnuncio','DicTipoPropiedad','Lead','DicLineaContacto',
            'CuentasUser', 'Venta', 'Event'
            );
        
        public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('detalle', 'get_inmuebles', 'get_inmueble_detalle');
	}

/**
 * index method
 *
 * @return void
 */
        public function index() {
            if ($this->request->is('post')){
                $cuenta = array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'));
                
                $precio_min = $this->request->data['Inmueble']['precio_min'];
                $precio_max = $this->request->data['Inmueble']['precio_max'];
                $hab_min = $this->request->data['Inmueble']['hab_min'];
                $hab_max = $this->request->data['Inmueble']['hab_max'];
                $banios_min = $this->request->data['Inmueble']['banios_min'];
                $banios_max = $this->request->data['Inmueble']['banios_max'];
                $terreno_min = $this->request->data['Inmueble']['terreno_min'];
                $terreno_max = $this->request->data['Inmueble']['terreno_max'];
                $construccion_min = $this->request->data['Inmueble']['construccion_min'];
                $construccion_max = $this->request->data['Inmueble']['construccion_max'];
                $est_min = $this->request->data['Inmueble']['est_min'];
                $est_max = $this->request->data['Inmueble']['est_max'];
                $status = $this->request->data['Inmueble']['estado'];
                $tipo = $this->request->data['Inmueble']['tipo_inmueble'];
                $operacion = $this->request->data['Inmueble']['operacion'];
                
                if ($tipo != "" || !empty($tipo)){
                    array_push($cuenta,array('Inmueble.dic_tipo_propiedad_id'=>$tipo));
                }
                
                if ($status != "" || !empty($status)){
                    array_push($cuenta,array('Inmueble.liberada'=>$status));
                }
                
                if ($operacion != "" || !empty($operacion)){
                    array_push($cuenta,array('Inmueble.venta_renta'=>$operacion));
                }
                
                if ($precio_min != "" || !empty($precio_min)){
                    if ($operacion != "" || !empty($operacion)){
                        if ($operacion == "Renta"){
                            array_push($cuenta,array('Inmueble.precio_2 >='=>$precio_min));
                        }
                        if ($operacion == "Venta" || $operacion == "Renta/Venta"){
                            array_push($cuenta,array('Inmueble.precio >='=>$precio_min));
                        }
                    }else{
                        array_push($cuenta,array('Inmueble.precio >='=>$precio_min));
                    }
                }
                
                if ($precio_max != "" || !empty($precio_max)){
                    if ($operacion != "" || !empty($operacion)){
                        if ($operacion == "Renta"){
                            array_push($cuenta,array('Inmueble.precio_2 <='=>$precio_min));
                        }
                        if ($operacion == "Venta" || $operacion == "Renta/Venta"){
                            array_push($cuenta,array('Inmueble.precio <='=>$precio_min));
                        }
                    }else{
                        array_push($cuenta,array('Inmueble.precio <='=>$precio_min));
                    }
                }
                
                if ($hab_min != "" || !empty($hab_min)){
                    array_push($cuenta,array('Inmueble.recamaras >='=>$hab_min));
                }
                
                if ($hab_max != "" || !empty($hab_max)){
                    array_push($cuenta,array('Inmueble.recamaras <='=>$hab_max));
                }
                
                if ($banios_min != "" || !empty($banios_min)){
                    array_push($cuenta,array('Inmueble.banos >='=>$hab_min));
                }
                
                if ($banios_max != "" || !empty($banios_max)){
                    array_push($cuenta,array('Inmueble.banos <='=>$banios_max));
                }
                
                if ($terreno_min != "" || !empty($terreno_min)){
                    array_push($cuenta,array('Inmueble.terreno >='=>$terreno_min));
                }
                
                if ($terreno_max != "" || !empty($terreno_max)){
                    array_push($cuenta,array('Inmueble.terreno <='=>$terreno_max));
                }
                
                if ($construccion_min != "" || !empty($construccion_min)){
                    array_push($cuenta,array('(Inmueble.construccion + Inmueble.construccion_no_habitable) >='=>$construccion_min));
                }
                
                if ($construccion_max != "" || !empty($construccion_max)){
                    array_push($cuenta,array('(Inmueble.construccion + Inmueble.construccion_no_habitable) <='=>$construccion_max));
                }
                
                if ($est_min != "" || !empty($est_min)){
                    array_push($cuenta,array('(Inmueble.estacionamiento_techado +  Inmueble.estacionamiento_descubierto) >='=>$est_min));
                }
                
                if ($est_max != "" || !empty($est_max)){
                    array_push($cuenta,array('(Inmueble.estacionamiento_techado +  Inmueble.estacionamiento_descubierto)  <='=>$est_max));
                }
                
//                $cond_precio = array();
//                if ($precio_min != "" || !empty($precio_min) || $precio_max != "" || !empty($precio_max)){
//                    if ($precio_min != ""){
//                        $cond_precio = array_push($cond_precio, array('Inmueble.precio >='=>$precio_min));
//                    }
//                    if ($precio_max != ""){
//                        $cond_precio = array_push($cond_precio, array('Inmueble.precio <='=>$precio_min));
//                    }
//                }
//                
//                $cond_hab = array();
//                if ($hab_min != "" || !empty($hab_min) || $hab_max != "" || !empty($hab_max)){
//                    if ($hab_min != ""){
//                        $cond_hab = array_push($cond_hab, array('Inmueble.recamaras >='=>$precio_min));
//                    }
//                    if ($hab_max != ""){
//                        $cond_hab = array_push($cond_hab, array('Inmueble.recamaras <='=>$precio_min));
//                    }
//                }
                $this->set('inmuebles', $this->Inmueble->find('all',array('conditions'=>$cuenta)));
                $this->set('tipos_inmuebles',$this->DicTipoPropiedad->find('list',array('conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                
            }else{
                if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
                else{
                    if ($this->Session->read('Permisos.Group.id')==3){
                        $this->set('inmuebles', $this->Inmueble->find('all',array('order'=>'Inmueble.id DESC','conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),'Inmueble.liberada'=>1, 'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'))));
                    }else{
                        $this->set('inmuebles', $this->Inmueble->find('all',array('order'=>'Inmueble.id DESC','conditions'=>array('Inmueble.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'))));
                        $this->set('tipos_inmuebles',$this->DicTipoPropiedad->find('list',array('conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                    }
                }
            }
	}
        
        public function cambio_precio() {
            if ($this->request->is('post')){
                $this->request->data['Precio']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                $this->request->data['Precio']['precio'] = $this->request->data['Inmueble']['precio'];
                $this->request->data['Precio']['fecha'] = date('Y-m-d');
                $this->request->data['Precio']['user_id'] = $this->Session->read('Auth.User.id');
                $this->Precio->create();
                $this->Precio->save($this->request->data);
                
                $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                $this->request->data['LogInmueble']['mensaje'] = "Modificación de Precio";
                $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                $this->request->data['LogInmueble']['fecha'] = date('Y-m-d H:i:s');
                $this->request->data['LogInmueble']['accion'] = 2;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);
                
                $this->Inmueble->save($this->request->data);
                
                return $this->redirect(array('action' => 'view','controller'=>'inmuebles',$this->request->data['Inmueble']['id']));
            }
	}
        
        public function index2() {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout= 'bos';
                if ($this->request->is('post')){
                    $variable = $this->request->data['Inmueble']['campo'];
                    if ($this->Session->read('Permisos.Group.id')==3){
                        $conditions = array(
                        'Inmueble.titulo LIKE "%'.$variable.'%"',
                        'Inmueble.liberada IN (1,2,3)',
                        ); 
                    }else{
                        $conditions = array(
                        'Inmueble.titulo LIKE "%'.$variable.'%"',
                        );
                    }
                    if (!empty($this->request->data['Inmueble']['tipos'])){
                        array_push($conditions, array('Inmueble.tipo_propiedad'=>$this->request->data['Inmueble']['tipos']));
                    }
                    if (!empty($this->request->data['Inmueble']['operacion'])){
                        array_push($conditions, array('Inmueble.venta_renta'=>$this->request->data['Inmueble']['operacion']));
                    }
                    if ($this->Session->read('Permisos.Group.id')==3){
                            array_push($conditions, array('Inmueble.liberada NOT IN (1,6)'));
                        }else{
                            if (!empty($this->request->data['Inmueble']['status1'])){
                                array_push($conditions, array('Inmueble.liberada'=>$this->request->data['Inmueble']['status1']-1));
                            }
                        }
                    if (!empty($this->request->data['Inmueble']['exclusiva1'])){
                        array_push($conditions, array('Inmueble.exclusiva'=>$this->request->data['Inmueble']['exclusiva1']));
                    }
                    $this->Paginator->settings=array('conditions'=>$conditions,'limit'=>0);
                    $this->set('inmuebles', $this->Paginator->paginate());
                    
                }else{
                    $this->Inmueble->recursive = 1;
                    if ($this->Session->read('Permisos.Group.id')==3){
                        $this->Paginator->settings=array('conditions'=>array('Inmueble.liberada IN (1,2,3)','Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'));
                    }else{
                        $this->Paginator->settings=array('conditions'=>array('Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'));
                    }
                    $this->set('inmuebles', $this->Paginator->paginate());
                    
                }
	}
        
        public function detail_client($id = null) {
                $this->layout='cliente';
		if (!$this->Inmueble->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo'));
		}
		$options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
		$this->set('inmueble', $this->Inmueble->find('first', $options));
                $estadisticas = $this->Inmueble->query("SELECT count(*),status FROM leads WHERE inmueble_id = $id GROUP BY status");
                $estad = array();
                foreach($estadisticas as $estadistica):
                    array_push($estad,array($estadistica['leads']['status']=>$estadistica[0]['count(*)']));
                endforeach;
                $this->set('estadisticas',$estad);
	}
        
        public function orden($id=null){
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
            if ($this->request->is('post')){
                $id = $this->request->data['Inmueble']['id'];
                $i = $this->request->data['Inmueble']['i'];
                 for ($j=1; $j<$i; $j++){
                     if ($this->request->data['Inmueble']['eliminar'.$j]==1){
                         $id_foto=$this->request->data['Inmueble']['id'.$j];
                         $this->Inmueble->query("DELETE FROM foto_inmuebles WHERE id = $id_foto");
                     }else{
                        $id_foto=$this->request->data['Inmueble']['id'.$j];
                        $descripcion=$this->request->data['Inmueble']['descripcion'.$j];
                        $orden=$this->request->data['Inmueble']['orden'.$j];
                        $this->Inmueble->query("UPDATE foto_inmuebles SET descripcion = '".$descripcion."', orden = $orden WHERE id = $id_foto");
                     }
                 }
                $this->Session->setFlash(__('Los cambios han sido guardados exitosamente'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'multimedia',$id));
                //echo var_dump($this->request->data['Inmueble']['foto_inmueble']);
            }else{
                $this->set('imagenes',$this->FotoInmueble->find('all',array('conditions'=>array('Inmueble.id'=>$id))));
                $this->set('id',$id);
            }
        }
        
        public function eliminar_foto($id=null, $id_inmueble = null){
            $this->FotoInmueble->id = $id;
		if (!$this->FotoInmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FotoInmueble->delete()) {
			$this->Session->setFlash(__('The inmueble has been deleted.'));
		} else {
			$this->Session->setFlash(__('The inmueble could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'anexos',$id_inmueble));
        }
        
        public function borrar_brochure($id=null){
            	$this->request->onlyAllow('post', 'delete');
                    $this->Inmueble->query("UPDATE inmuebles SET brochure = null WHERE id = $id");
		return $this->redirect(array('action' => 'anexos',$id));
        }
        
        public function multimedia($id=null){
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
            if ($this->request->is('post')){
                
                $id = $this->request->data['Inmueble']['id'];
                $i = $this->request->data['Inmueble']['i'];
                for ($j=1; $j<$i; $j++){
                    if ($this->request->data['Inmueble']['descripcion'.$j]!="" || $this->request->data['Inmueble']['orden'.$j]!=""){
                        $id_foto=$this->request->data['Inmueble']['id'.$j];
                        $descripcion=$this->request->data['Inmueble']['descripcion'.$j];
                        $orden=$this->request->data['Inmueble']['orden'.$j];
                        $this->Inmueble->query("UPDATE foto_inmuebles SET descripcion = '".$descripcion."', orden = $orden WHERE id = $id_foto");
                    }
                 
                }
                foreach($this->request->data['Inmueble']['foto_inmueble'] as $unitario):
                    if ($unitario['name']!=""){
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario['name'];
                        move_uploaded_file($unitario['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario['name'];
                        $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','',0)");
                    }
                endforeach;
                
                 
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'),'default',array('class'=>'mensaje_exito'));
                return $this->redirect(array('action' => 'view',$id));
                //echo var_dump($this->request->data['Inmueble']['foto_inmueble']);
            }else{
                $this->set('imagenes',$this->FotoInmueble->find('all',array('conditions'=>array('Inmueble.id'=>$id),'order'=>'FotoInmueble.orden ASC')));
                $this->set('id',$id);
            }
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */ 
        
    public function view_tipo($id = null,$desarrollo_id = null){
        $this->set('list_users', $this->User->find('list'));
        $this->set('list_clientes', $this->Cliente->find('list',array('conditions'=>array('Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->loadModel('FotoInmueble');

        // Consulta para localizar si se realizo alguna venta del inmueble
        $this->set('venta_inmueble', $this->Venta->find('first', array('conditions'=>array('Venta.inmueble_id'=>$id))));
        $options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
        $this->set('fotos_inmueble', $this->FotoInmueble->find('all', array('recursive'=>0, 'conditions'=>array('inmueble_id'=>$id))));
        $this->set('inmueble', $this->Inmueble->find('first', $options));
        // $this->set('usuarios',$this->User->find('all', array('recursive'=>0)));
        // Se cambio la consulta para que mostrara solo los usuarios de la cuenta con la que se hizo login, se puso en forma de listado(foreach) - SaaK 
        $usuarios = $this->CuentasUser->find('all', array('recursive'=>0,'conditions'=>array('CuentasUser.group_id <>'=>5,'CuentasUser.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $array_user = array();
        foreach ($usuarios as $usuario) {
            $array_user[$usuario['User']['id']] = $usuario['User']['nombre_completo'];
        };
        $this->set('usuarios', $array_user);
        
        $leads = $this->Lead->find('all',array('conditions'=>array('Lead.inmueble_id'=>$id)));
        $this->set('leads', $leads);
        
        // 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita - LogInmueble
        $this->set('mails',$this->LogInmueble->find('count',array('conditions'=>array('LogInmueble.inmueble_id'=>$id,'LogInmueble.accion'=>5))));
        $this->set('citas',$this->LogInmueble->find('count',array('conditions'=>array('LogInmueble.inmueble_id'=>$id,'LogInmueble.accion'=>6))));
        $this->set('visitas',$this->LogInmueble->find('count',array('conditions'=>array('LogInmueble.inmueble_id'=>$id,'LogInmueble.accion'=>7))));
        $this->set('interesados', count($leads));

        $this->set('contactos', $this->Cliente->query("SELECT dic_linea_contactos.linea_contacto, COUNT(*) as total
                                                        FROM clientes, dic_linea_contactos
                                                        WHERE clientes.id IN (SELECT leads.cliente_id FROM leads WHERE leads.inmueble_id = $id)
                                                        AND clientes.dic_linea_contacto_id = dic_linea_contactos.id
                                                        GROUP BY clientes.dic_linea_contacto_id;"));



        /* Condiciones para los eventos del inmueble */

        if ($this->Session->read('Permisos.Group.cown')){
            $condiciones = array(
                'recursive'=>1,
                'fields'=>array(
                    'Cliente.id','Cliente.nombre',
                    'Cliente.id','Cliente.interesado',
                    'Cliente.temperatura','Cliente.correo_electronico',
                    'Cliente.telefono1',
                    'Cliente.status','Cliente.created',
                    'Cliente.user_id','Cliente.dic_etapa_id',
                    'Cliente.dic_tipo_cliente_id',
                    'User.nombre_completo','DicEtapa.etapa',
                    'DicTipoCliente.tipo_cliente',
                ),
                'order'=>'Cliente.id DESC',
                'conditions'=>array(
                    'Cliente.user_id'   =>$this->Session->read('Auth.User.id'),
                    'Cliente.cuenta_id' =>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Cliente.status'=>array('Activo', 'Activo venta')
                    )
                );
        }else{
            $condiciones = array(
            
                'recursive'=>1,
                'fields'=>array(
                    'Cliente.id','Cliente.nombre',
                    'Cliente.id','Cliente.interesado',
                    'Cliente.temperatura','Cliente.correo_electronico',
                    'Cliente.telefono1',
                    'Cliente.status','Cliente.created',
                    'Cliente.user_id','Cliente.dic_etapa_id',
                    'Cliente.dic_tipo_cliente_id',
                    'User.nombre_completo','DicEtapa.etapa',
                    'DicTipoCliente.tipo_cliente',
                ),
                'order'=>'Cliente.id DESC',
                'conditions'=>array(
                    'Cliente.cuenta_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Cliente.status'=>array('Activo', 'Activo venta')
                    )
                );
        }


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
        $this->set('return', 3);
        $this->set('param_return', $id);

        $eventos = $this->Event->find('all',
        array(
            'recursive' => -0,
            'conditions' => array(
                'Event.status'      => 1,
                'Event.tipo_evento' => 1,
                'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Event.fecha_inicio >= CURDATE()',
                'Event.fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)',
                'Inmueble.id'       => $id,
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
        $data_eventos[$s]['url']                 = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."')";
        $data_eventos[$s]['fecha_inicio_format'] = date('d/M/Y \a \l\a\s H:i', strtotime($evento['Event']['fecha_inicio']));
        $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
        $data_eventos[$s]['status']              = $evento['Event']['status'];
        $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
        $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
        $data_eventos[$s]['id_evento']           = $evento['Event']['id'];

        
        }

        $this->set('eventos', $data_eventos);
        
        $this->set('clientes',$this->Cliente->find('list',$condiciones));
        $this->set('desarrollo_id',$desarrollo_id);
        $this->set('inmueble_id',$id);
        $this->set('desarrollo',$this->Desarrollo->read(null,$desarrollo_id));
    }
        
	public function view($id = null) {

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
        $this->set('return', 3);
        $this->set('param_return', $id);

        $eventos = $this->Event->find('all',
        array(
            'recursive' => -0,
            'conditions' => array(
                'Event.status'      => 1,
                'Event.tipo_evento' => 1,
                'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Event.fecha_inicio >= CURDATE()',
                'Event.fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)',
                'Inmueble.id'       => $id,
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
        $data_eventos[$s]['url']                 = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."')";
        $data_eventos[$s]['fecha_inicio_format'] = date('d/M/Y \a \l\a\s H:i', strtotime($evento['Event']['fecha_inicio']));
        $data_eventos[$s]['tipo_tarea']          = $evento['Event']['tipo_tarea'];
        $data_eventos[$s]['status']              = $evento['Event']['status'];
        $data_eventos[$s]['asesor']              = $evento['User']['nombre_completo'];
        $data_eventos[$s]['ubicacion']           = $nombre_ubicacion;
        $data_eventos[$s]['id_evento']           = $evento['Event']['id'];

        
        }

        $this->set('eventos', $data_eventos);
        
        
        $this->set('list_users', $this->User->find('list'));
        $this->set('list_clientes', $this->Cliente->find('list',array('conditions'=>array('Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        
        $this->set('id', $id);
        $this->set('venta_inmueble', $this->Venta->find('first', array('conditions'=>array('Venta.inmueble_id'=>$id))));
         if ($this->Session->read('Permisos.Group.id')==5){
            return $this->redirect(array('action' => 'mysession','controller'=>'users'));
        }
        $para = $this->Session->read('Auth.User.id');
        $this->Inmueble->query("UPDATE notificaciones SET leido = 1 WHERE link = '/inmuebles/view/$id' AND para = $para");
        $this->Session->write('notificaciones',$this->Inmueble->query("SELECT * FROM notificaciones WHERE leido = 0 AND para = ".$this->Session->read('Auth.User.id')));
        
        if (!$this->Inmueble->exists($id)) { throw new NotFoundException(__('Invalid inmueble'));}
        $options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
        $this->set('inmueble', $this->Inmueble->find('first', $options));
        // $this->set('usuarios',$this->User->find('list',array('conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id ='.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').")"))));
        $usuarios = $this->CuentasUser->find('all', array('recursive'=>0,'conditions'=>array('CuentasUser.group_id <>'=>5,'CuentasUser.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $array_user = array();
        foreach ($usuarios as $usuario) {
            $array_user[$usuario['User']['id']] = $usuario['User']['nombre_completo'];
        };
        $this->set('usuarios', $array_user);
        
        $leads = $this->Lead->find('all',array('conditions'=>array('Lead.inmueble_id'=>$id)));
        $this->set('leads', $leads);
        
        // 1 => Creación, 2 => Edición, 3 => Evento, 4 => Llamada, 5 => Email, 6 => Cita, 7=>Visita - LogInmueble
        $this->set('mails',$this->LogInmueble->find('count',array('conditions'=>array('LogInmueble.inmueble_id'=>$id,'LogInmueble.accion'=>5))));
        $this->set('citas',$this->LogInmueble->find('count',array('conditions'=>array('LogInmueble.inmueble_id'=>$id,'LogInmueble.accion'=>6))));
        $this->set('visitas',$this->LogInmueble->find('count',array('conditions'=>array('LogInmueble.inmueble_id'=>$id,'LogInmueble.accion'=>7))));
        $this->set('interesados', count($leads));

        $this->set('lineas_contactos',$this->DicLineaContacto->find('list',array('conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('contactos', $this->Cliente->query("SELECT 
                                                        dic_linea_contactos.linea_contacto, count(clientes.dic_linea_contacto_id) as total 
                                                    FROM dic_linea_contactos, clientes, leads 
                                                    WHERE leads.inmueble_id = $id AND leads.cliente_id = clientes.id AND clientes.dic_linea_contacto_id = dic_linea_contactos.id
                                                    GROUP BY dic_linea_contactos.linea_contacto"));

        /* Condiciones para los eventos del inmueble */
        if ($this->Session->read('Permisos.Group.cown')){
            $condiciones = array(
                'recursive'=>1,
                'fields'=>array(
                    'Cliente.id','Cliente.nombre',
                    'Cliente.id','Cliente.interesado',
                    'Cliente.temperatura','Cliente.correo_electronico',
                    'Cliente.telefono1',
                    'Cliente.status','Cliente.created',
                    'Cliente.user_id','Cliente.dic_etapa_id',
                    'Cliente.dic_tipo_cliente_id',
                    'User.nombre_completo','DicEtapa.etapa',
                    'DicTipoCliente.tipo_cliente',
                ),
                'order'=>'Cliente.nombre ASC',
                'conditions'=>array(
                    'Cliente.user_id'=>$this->Session->read('Auth.User.id'),
                    'Cliente.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Cliente.status'=>'Activo'
                    )
                );
        }else{
            $condiciones = array(
                'recursive'=>1,
                'fields'=>array(              
                    'Cliente.id','Cliente.nombre',
                    'Cliente.id','Cliente.interesado',
                    'Cliente.temperatura','Cliente.correo_electronico',
                    'Cliente.telefono1',
                    'Cliente.status','Cliente.created',
                    'Cliente.user_id','Cliente.dic_etapa_id',
                    'Cliente.dic_tipo_cliente_id',
                    'User.nombre_completo','DicEtapa.etapa',
                    'DicTipoCliente.tipo_cliente',
                ),
                'order'=>'Cliente.nombre ASC',
                'conditions'=>array(
                        'Cliente.cuenta_id' =>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                        'Cliente.status'    =>'Activo'
                    )
                );
        }
        $this->set('clientes',$this->Cliente->find('list',$condiciones));
        

        // $this->set('users',$this->Cliente->User->find('list',array('order'=>'User.nombre_completo ASC','conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE  cuentas_users.opcionador = 1 AND cuenta_id = '.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').')'))));


    }
        
        public function detalle($id = null, $id_agente = null){
                
                $this->layout = 'freebos';
		if (!$this->Inmueble->exists($id)) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->set('inmueble', $this->Inmueble->read(null, $id));
                $this->set('agente', $this->User->read(null, $id_agente));
        }
        
        public function imprimir($id = null, $id_agente = null){

            $inmueble = [];
            $agente = [];

            $inmueble = $this->Inmueble->read(null, $id);
            $agente = $this->User->read(null, $id_agente);

            $this->set('inmueble', $inmueble);
            $this->set('agente', $agente);

            $params = array(
                'download' => false,
                'name' => 'example.pdf',
                'paperOrientation' => 'portrait',
                'paperSize' => 'letter',
                
            );
            
            $this->set($params);
                
        }


        
        public function upload(){
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            $this->layout ='bos';
            if ($this->request->is('post')){
                $id = $this->request->data['Inmueble']['id'];
                foreach($this->request->data['Inmueble']['archivo'] as $unitario):
                    $filename = getcwd()."/files/inmuebles/".$id."/".$unitario['name'];
                    move_uploaded_file($unitario['tmp_name'],$filename);
                endforeach;
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'));
                return $this->redirect(array('action' => 'view',$id));    
            }
        }

/**
 * add method
 *
 * @return void
 */
        public function descripciones($id =null){
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
		if ($this->request->is('post')) {
                    $max = $this->request->data['Inmueble']['contador'];
                    for($i = 1; $i<$max; $i++){
                        $this->FotoInmueble->create();
                        $this->request->data['FotoInmueble']['id'] = $this->request->data['Inmueble']['id'.$i];
                        $this->request->data['FotoInmueble']['descripcion'] = $this->request->data['Inmueble']['descripcion'.$i];
                        $this->request->data['FotoInmueble']['orden'] = $this->request->data['Inmueble']['orden'.$i];
                        $this->FotoInmueble->save($this->request->data);
                    }
                    $this->Session->setFlash(__('Las fotgrafías han sido salvadas exitosamente.'));
                    return $this->redirect(array('action' => 'index'));
                }else{
                    $this->set('inmueble',$this->Inmueble->read(null, $id));
                }
        }    
        
	public function add_bak() {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		
		if ($this->request->is('post')) {  
                    
                        
//			
			//Cargar documentos
			
//			$contrato = $this->request->data['Inmueble']['contrato'];
//			$escrituras = $this->request->data['Inmueble']['escrituras'];
//			$ife = $this->request->data['Inmueble']['identificacion_oficial'];
//			$predial = $this->request->data['Inmueble']['predial'];
//			$luz = $this->request->data['Inmueble']['luz_agua'];
//			
//			$this->request->data['Inmueble']['contrato'] = "";
//			$this->request->data['Inmueble']['escrituras'] = "";
//			$this->request->data['Inmueble']['identificacion_oficial'] = "";
//			$this->request->data['Inmueble']['predial'] = "";
//			$this->request->data['Inmueble']['luz_agua'] = "";
				
			//Fin de carga de documentos
                        $this->request->data['Inmueble']['referencia']=$this->request->data['referencia'];
                        $this->request->data['Inmueble']['titulo']=$this->request->data['titulo'];
                        $this->request->data['Inmueble']['dic_tipo_propiedad_id']=$this->request->data['tipo_propiedad'];
                        $this->request->data['Inmueble']['fecha']=$this->request->data['fecha'];
                        $this->request->data['Inmueble']['due_date']=$this->request->data['due_date'];
                        $this->request->data['Inmueble']['exclusiva']=$this->request->data['exclusiva'];
                        $this->request->data['Inmueble']['venta_renta']=$this->request->data['venta'];
                        $this->request->data['Inmueble']['precio']=$this->request->data['precio'];
                        $this->request->data['Inmueble']['calle']=$this->request->data['calle'];
                        $this->request->data['Inmueble']['numero_exterior']=$this->request->data['numero_ext'];
                        $this->request->data['Inmueble']['construccion']=$this->request->data['construccion'];
                        $this->request->data['Inmueble']['recamaras']=$this->request->data['recamaras'];
                        $this->request->data['Inmueble']['banos']=$this->request->data['banios'];
                        $this->request->data['Inmueble']['colonia']=$this->request->data['colonia'];
                        $this->request->data['Inmueble']['delegacion']=$this->request->data['delegacion'];
                        $this->request->data['Inmueble']['ciudad']=$this->request->data['ciudad'];
                        $this->request->data['Inmueble']['cp']=$this->request->data['cp'];
                        $this->request->data['Inmueble']['estado_ubicacion']=$this->request->data['estado_ubicacion'];
                        $this->request->data['Inmueble']['nombre_cliente']=$this->request->data['nombre_cliente'];
                        $this->request->data['Inmueble']['apellido_paterno']=$this->request->data['apellido_paterno'];
                        $this->request->data['Inmueble']['telefono1']=$this->request->data['telefono1'];
                        $this->request->data['Inmueble']['correo_electronico']=$this->request->data['correo_electronico'];
                        $this->request->data['Inmueble']['terreno']=$this->request->data['terreno'];
                        
                        
                        $this->Inmueble->create();
			if ($this->Inmueble->save($this->request->data)) {
				$id = $this->Inmueble->getInsertID();
				
                                $this->request->data['LogInmueble']['inmueble_id'] = $id;
                                $this->request->data['LogInmueble']['mensaje'] = "Creación de Inmueble";
                                $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                                $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                                $this->request->data['LogInmueble']['accion'] = 1;
                                $this->LogInmueble->create();
                                $this->LogInmueble->save($this->request->data);
                                
                                $this->request->data['Precio']['inmueble_id'] = $id;
                                $this->request->data['Precio']['precio'] = $this->request->data['Inmueble']['precio'];
                                $this->request->data['Precio']['fecha'] = date('Y-m-d');
                                $this->request->data['Precio']['user_id'] = $this->Session->read('Auth.User.id');
                                $this->Precio->create();
                                $this->Precio->save($this->request->data);
                                
                                
				mkdir(getcwd()."/img/inmuebles/".$id,0777);
			
				foreach($this->request->data['Inmueble']['foto_inmueble'] as $unitario):
					$filename = getcwd()."/img/inmuebles/".$id."/".$unitario['name'];
					move_uploaded_file($unitario['tmp_name'],$filename);
					$ruta = "/img/inmuebles/".$id."/".$unitario['name'];
					$this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','','')");
				endforeach;
                                
                                
                                
                                foreach($this->request->data['Inmueble']['anexos'] as $unitario1):
                                        $filename = getcwd()."/img/inmuebles/".$id."/".$unitario1['name'];
                                        move_uploaded_file($unitario1['tmp_name'],$filename);
                                        $ruta = "/img/inmuebles/".$id."/".$unitario['name'];
                                        $this->request->data['DocumentosUser']['documento'] = $unitario1['name'];
                                        $this->request->data['DocumentosUser']['inmueble_id'] = $id;
                                        $this->request->data['DocumentosUser']['user_id'] = $this->Session->read('Auth.User.id');
                                        $this->request->data['DocumentosUser']['ruta'] = $ruta;
                                        $this->request->data['DocumentosUser']['asesor'] = 0;
                                        $this->request->data['DocumentosUser']['desarrollador'] = 0;
                                        $this->DocumentosUser->create();
                                        $this->DocumentosUser->save($this->request->data);
				endforeach;
				 
				$this->request->data['Inmueble']['liberada']=0;
				
				//mkdir(getcwd()."/files/inmuebles/".$id,0777);
                                //mkdir(getcwd()."/files/inmuebles/archivos/".$id,0777);
				
//				if ($contrato['name']!="" && $escrituras['name']!="" && $ife['name']!=""){
//					$this->request->data['Inmueble']['liberada']=1;
//				}
//				if ($contrato['name']!=""){
//					$filename1 = getcwd()."/files/inmuebles/".$id."/".$contrato['name'];
//					move_uploaded_file($contrato['tmp_name'],$filename1);
//					$ruta1 = "/files/inmuebles/".$id."/".$contrato['name'];
//					$this->request->data['Inmueble']['contrato'] = $ruta1;
//				}
//				if ($escrituras['name']!=""){
//					$filename2 = getcwd()."/files/inmuebles/".$id."/".$escrituras['name'];
//					move_uploaded_file($escrituras['tmp_name'],$filename2);
//					$ruta2 = "/files/inmuebles/".$id."/".$escrituras['name'];
//					$this->request->data['Inmueble']['escrituras'] = $ruta2;
//				}
//				if ($ife['name']!=""){
//					$filename3 = getcwd()."/files/inmuebles/".$id."/".$ife['name'];
//					move_uploaded_file($ife['tmp_name'],$filename3);
//					$ruta3 = "/files/inmuebles/".$id."/".$ife['name'];
//					$this->request->data['Inmueble']['identificacion_oficial'] = $ruta3;
//				}
//				if ($predial['name']!=""){
//					$filename4 = getcwd()."/files/inmuebles/".$id."/".$predial['name'];
//					move_uploaded_file($predial['tmp_name'],$filename4);
//					$ruta4 = "/files/inmuebles/".$id."/".$predial['name'];
//					$this->request->data['Inmueble']['predial'] = $ruta4;
//				}
//				if ($luz['name']!=""){
//					$filename5 = getcwd()."/files/inmuebles/".$id."/".$luz['name'];
//					move_uploaded_file($luz['tmp_name'],$filename5);
//					$ruta5 = "/files/inmuebles/".$id."/".$luz['name'];
//					$this->request->data['Inmueble']['luz_agua'] = $ruta5;
//				}
					$this->request->data['Inmueble']['id'] = $id;
					$this->Inmueble->save($this->request->data);
				
                                $de = 1;
                                $para = $this->User->find('all');
                                foreach ($para as $persona):
                                    $for = $persona['User']['id'];
                                    $this->Inmueble->query("INSERT INTO notificaciones VALUES(0,$de,$for,'Se ha agregado una nueva propiedad',0,'/inmuebles/view/".$id."')");
                                endforeach;
                                $this->Session->write('notificaciones',$this->Inmueble->query("SELECT * FROM notificaciones WHERE leido = 0 AND para = ".$this->Session->read('Auth.User.id')));
				
				
				$this->Session->setFlash(__('The inmueble has been saved.'));
				return $this->redirect(array('action' => 'index'));
				
			
			} else {
				$this->Session->setFlash(__('The inmueble could not be saved. Please, try again.'));
			}
			//echo var_dump($this->request->data);
		}
                $opcionadors = $this->User->find('list',array('conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE opcionador = 1 AND cuenta_id = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').")"),'order'=>'User.nombre_completo ASC'));
		$this->set(compact('opcionadors'));
                $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
	
	}
        
        public function add() {
            date_default_timezone_set('America/Mexico_City');
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		
		if ($this->request->is('post')) {  
                    
                        
//			
			//Cargar documentos
			
//			$contrato = $this->request->data['Inmueble']['contrato'];
//			$escrituras = $this->request->data['Inmueble']['escrituras'];
//			$ife = $this->request->data['Inmueble']['identificacion_oficial'];
//			$predial = $this->request->data['Inmueble']['predial'];
//			$luz = $this->request->data['Inmueble']['luz_agua'];
//			
//			$this->request->data['Inmueble']['contrato'] = "";
//			$this->request->data['Inmueble']['escrituras'] = "";
//			$this->request->data['Inmueble']['identificacion_oficial'] = "";
//			$this->request->data['Inmueble']['predial'] = "";
//			$this->request->data['Inmueble']['luz_agua'] = "";
				
			//Fin de carga de documentos
            $this->request->data['Inmueble']['referencia']             = $this->request->data['referencia'];
            $this->request->data['Inmueble']['titulo']                 = $this->request->data['titulo'];
            $this->request->data['Inmueble']['dic_tipo_propiedad_id']  = $this->request->data['tipo_propiedad'];
            $this->request->data['Inmueble']['fecha']                  = date('Y-m-d');
            $this->request->data['Inmueble']['fecha_inicio_exclusiva'] = date('Y-m-d', strtotime($this->request->data['Inmueble']['fecha_inicio_exclusiva']));
            $this->request->data['Inmueble']['due_date']               = date('Y-m-d', strtotime($this->request->data['Inmueble']['due_date']));
            $this->request->data['Inmueble']['exclusiva']              = $this->request->data['exclusiva'];
            $this->request->data['Inmueble']['venta_renta']            = $this->request->data['venta'];
            $this->request->data['Inmueble']['precio_base']            = $this->request->data['Inmueble']['precio'];
            $this->Inmueble->create();
			if ($this->Inmueble->save($this->request->data)) {
				$id = $this->Inmueble->getInsertID();
				
                $this->request->data['LogInmueble']['inmueble_id'] = $id;
                $this->request->data['LogInmueble']['mensaje'] = "Creación de Inmueble";
                $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                $this->request->data['LogInmueble']['accion'] = 1;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);
                
                $this->request->data['Precio']['inmueble_id'] = $id;
                $this->request->data['Precio']['precio'] = $this->request->data['Inmueble']['precio'];
                $this->request->data['Precio']['fecha'] = date('Y-m-d');
                $this->request->data['Precio']['user_id'] = $this->Session->read('Auth.User.id');
                $this->Precio->create();
                $this->Precio->save($this->request->data);
                                
                                
				mkdir(getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id,0777);
			
				$this->Session->setFlash(__('The inmueble has been saved.'));
				if ($this->request->data['Inmueble']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('controller'=>'inmuebles','action' => 'caracteristicas',$id));
                                }
				
			
			} else {
				$this->Session->setFlash(__('The inmueble could not be saved. Please, try again.'));
			}
			//echo var_dump($this->request->data);
		}
                $opcionadors = $this->User->find('list',array('conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE opcionador = 1 AND cuenta_id = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').")"),'order'=>'User.nombre_completo ASC'));
		$this->set(compact('opcionadors'));
                $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
	
	}
	
	public function add_unidades($id = null){
        date_default_timezone_set('America/Mexico_City');
        error_reporting(0);
        $desarrollo_id = $id; # Inicializacion de variable de desarrollo (Traida desde URL).

        //Definimos las variables para hacer el calculo
        $var1 = 0;
        $var2 = 0;

        if ($this->Session->read('Permisos.Group.id')==5){
            return $this->redirect(array('action' => 'mysession','controller'=>'users'));
        }
		//$this->layout= 'bos';
		if ($this->request->is('post')) {

            //Empezamos a hacer las condiciones para guardar el inmuebe_tipo
            if ($this->request->data['Inmueble']['cantidad'] > 0) {

                for ($i = 0; $i < $this->request->data['Inmueble']['cantidad']; $i++){
                    
                    $this->Inmueble->create();
                    $this->request->data['Inmueble']['precio_base'] = $this->request->data['Inmueble']['precio'];
                    $this->Inmueble->save($this->request->data);
                    $inmueble_id = $this->Inmueble->getInsertID();

                    $this->request->data['DesarrolloInmueble']['desarrollo_id'] = $desarrollo_id;
                    $this->request->data['DesarrolloInmueble']['inmueble_id']   = $inmueble_id;
                    $referencia = $this->request->data['Inmueble']['referencia'];
                    $this->DesarrolloInmueble->query("INSERT INTO desarrollo_inmuebles VALUES (0,$desarrollo_id,$inmueble_id,'".$referencia.$i."')");

                    // Guardar las imagenes que se suben
                    if ($i == 1) {
                        if ( $this->request->data['Inmueble']['foto_inmueble'][0]['name'] != '' ) {
                            foreach ($this->request->data['Inmueble']['foto_inmueble'] as $unitario) {
                                $nombre_unitario = $unitario['name'];
                                $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$unitario['name'];
                                move_uploaded_file($unitario['tmp_name'],$filename);
                                $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$unitario['name'];
                                $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$inmueble_id,'$ruta','',0,0)");
                            }
                        }
                    }else{
                        if ( $this->request->data['Inmueble']['foto_inmueble'][0]['name'] != '' ) {
                            
                            foreach ($this->request->data['Inmueble']['foto_inmueble'] as $unitario) {
                                $nombre_unitario = $unitario['name'];
                                $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$unitario['name'];
                                $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$inmueble_id,'$ruta','',0,0)");
                            }

                        }
                    }
                }                
            }else{
                $this->Inmueble->create();
                $this->Inmueble->save($this->request->data);
                $inmueble_id = $this->Inmueble->getInsertID();

                $this->request->data['Precio']['inmueble_id'] = $inmueble_id;
                $this->request->data['Precio']['precio']      = $this->request->data['Inmueble']['precio'];
                $this->request->data['Precio']['fecha']       = date('Y-m-d');
                $this->request->data['Precio']['user_id']     = $this->Session->read('Auth.User.id');
                $this->Precio->create();
                $this->Precio->save($this->request->data);

                $this->request->data['DesarrolloInmueble']['desarrollo_id'] = $desarrollo_id;
                $this->request->data['DesarrolloInmueble']['inmueble_id']   = $inmueble_id;
                $this->request->data['DesarrolloInmueble']['referencia']    = $this->request->data['Inmueble']['referencia'];
                $this->DesarrolloInmueble->save($this->request->data);

                if (!empty($this->request->data['Inmueble']['foto_inmueble'])){
                    foreach($this->request->data['Inmueble']['foto_inmueble'] as $unitario):
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$unitario['name'];
                        move_uploaded_file($unitario['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$unitario['name'];
                        $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','',0,1)");
                    endforeach;
                }
            }




            // dejamos lo que ya habia desarrollado César
            $this->loadModel('Desarrollo');
            $desarrollo = $this->Desarrollo->read(null,$desarrollo_id);
            $this->Desarrollo->create();



            // Estacionamientos
            // $esta   = is_numeric($this->request->data['Inmueble']['estacionamiento_techado']) + is_numeric($this->request->data['Inmueble']['estacionamiento_descubierto']);
            $var1 += $this->request->data['Inmueble']['estacionamiento_techado'];
            $var2 += $this->request->data['Inmueble']['estacionamiento_descubierto'];
            $esta = $var1 + $var2;
            
            $metros = $this->request->data['Inmueble']['construccion']+$this->request->data['Inmueble']['construccion_no_habitable'];
            $banios = $this->request->data['Inmueble']['banos'];
            $hab    = $this->request->data['Inmueble']['recamaras'];
            $precio = $this->request->data['Inmueble']['precio'];
            
            $this->set('desarrollo', $this->Desarrollo->read(null,$desarrollo_id));
            $this->request->data['Desarrollo']['id'] = $desarrollo_id;

            if ($metros <= $desarrollo['Desarrollo']['m2_low'] || $desarrollo['Desarrollo']['m2_low']==0){
                $this->request->data['Desarrollo']['m2_low'] = $metros;
            }else if($metros > $desarrollo['Desarrollo']['m2_top']|| $desarrollo['Desarrollo']['m2_top']==0){
                $this->request->data['Desarrollo']['m2_top'] = $metros;
            }
            
            if ($banios <= $desarrollo['Desarrollo']['banio_low'] || $desarrollo['Desarrollo']['banio_low']==0){
                $this->request->data['Desarrollo']['banio_low'] = $banios;
            }else if($banios > $desarrollo['Desarrollo']['banio_top']|| $desarrollo['Desarrollo']['banio_top']==0){
                $this->request->data['Desarrollo']['banio_top'] = $banios;
            }
            
            if ($esta <= $desarrollo['Desarrollo']['est_low'] || $desarrollo['Desarrollo']['est_low']==0){
                $this->request->data['Desarrollo']['est_low'] = $esta;
            }else if($banios > $desarrollo['Desarrollo']['est_top']|| $desarrollo['Desarrollo']['est_top']==0){
                $this->request->data['Desarrollo']['est_top'] = $esta;
            }
            
            if ($hab <= $desarrollo['Desarrollo']['rec_low'] || $desarrollo['Desarrollo']['rec_low']==0){
                $this->request->data['Desarrollo']['rec_low'] = $hab;
            }else if($banios > $desarrollo['Desarrollo']['rec_top']|| $desarrollo['Desarrollo']['rec_top']==0){
                $this->request->data['Desarrollo']['rec_top'] = $hab;
            }
            
            if ($precio <= $desarrollo['Desarrollo']['precio_low'] || $desarrollo['Desarrollo']['precio_low']==0){
                $this->request->data['Desarrollo']['precio_low'] = $precio;
            }else if($banios > $desarrollo['Desarrollo']['precio_top']|| $desarrollo['Desarrollo']['precio_top']==0){
                $this->request->data['Desarrollo']['precio_top'] = $precio;
            }
            
            $this->Desarrollo->save($this->request->data);

            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se han creado las unidades tipo exitosamente.', 'default', array(), 'm_success'); // Mensaje

            if ($this->request->data['Inmueble']['return'] == 2){
                return $this->redirect(array('action' => 'add_unidades', 'controller'=>'inmuebles', $this->request->data['Inmueble']['desarrollo_id']));
            }else{
                return $this->redirect(array('controller'=>'desarrollos','action' => 'view',$this->request->data['DesarrolloInmueble']['desarrollo_id']));
            }

		}else{
			$this->set('desarrollo', $this->Desarrollo->read(null,$id));
            $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
            $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
            $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
		}
		
	}
        
        public function edit_unidades($id = null,$id_desarrollo = null){
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout= 'bos';
		if ($this->request->is(array('post', 'put'))) {
            // var_dump($this->request->data['Inmueble']);
                    $desarrollo_id                                    = $this->request->data['Inmueble']['desarrollo_id'];
                    $fotos_all                                        = $this->request->data['Inmueble']['foto_inmueble'];
                    $this->request->data['Inmueble']['foto_inmueble'] = "";
                    
                    $desarrollo = $this->Desarrollo->find(
                            'first',array(
                                //'fields'=>array(
                                  //  'Desarrollo'
                                //),
                                'conditions'=>array(
                                    'Desarrollo.id'=>$desarrollo_id
                                )
                            ));
;                    
                    // Guardamos la informacion de las fotos
                    if (isset($this->request->data['fotos'])) {
                        foreach ($this->request->data['fotos'] as $fotos) {
                            // Localizar las que se tienen que eliminar
                            if (isset($fotos['eliminar'])) {
                                $this->FotoInmueble->delete($fotos['id']);
                            }else{
                                $this->request->data['FotoInmueble']['id']          = $fotos['id'];
                                $this->request->data['FotoInmueble']['descripcion'] = $fotos['descripcion'];
                                $this->request->data['FotoInmueble']['orden']       = $fotos['orden'];
                                $this->FotoInmueble->save($this->request->data);
                            }
                        }
                    }

                    if ($fotos_all[0]['name']!="") {
                    foreach ($fotos_all as $fot):
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$fot['name'];
                        move_uploaded_file($fot['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$desarrollo_id."/".$fot['name'];
                        $query = "INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','',0,1)";
                        $this->Inmueble->query($query);
//                            ImageTool::resize(array(
//                                'input'     => $filename,
//                                'output'    => $filename,
//                                'width'     => 800,
//                                'keepRatio' => true,
//                        ));                         
                    endforeach;
                    }
                    
                    // $this->request->data['Precio']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                    // $this->request->data['Precio']['precio']      = $this->request->data['Inmueble']['precio_inicial'];
                    // $this->request->data['Precio']['fecha']       = date('Y-m-d');
                    // $this->request->data['Precio']['user_id']     = $this->Session->read('Auth.User.id');
                    // $this->Precio->create();
                    // $this->Precio->save($this->request->data);

                        
                    $this->Inmueble->create();
                    $this->Inmueble->save($this->request->data);
                    if ($this->request->data['Inmueble']['cambio_precio']==1){
                        $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['LogInmueble']['mensaje'] = "Cambio de precio a: ".$this->request->data['Inmueble']['precio'];
                        $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                        $this->request->data['LogInmueble']['accion'] = 2;
                        $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                        $this->LogInmueble->create();
                        $this->LogInmueble->save($this->request->data);

                        $this->request->data['Precio']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                        $this->request->data['Precio']['precio']      = $this->request->data['Inmueble']['precio'];
                        $this->request->data['Precio']['fecha']       = date('Y-m-d');
                        $this->request->data['Precio']['user_id']     = $this->Session->read('Auth.User.id');
                        $this->Precio->create();
                        $this->Precio->save($this->request->data);
                    }else{
                        $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['LogInmueble']['mensaje'] = "Edición de información";
                        $this->request->data['LogInmueble']['accion'] = 2;
                        $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                        $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                        $this->LogInmueble->create();
                        $this->LogInmueble->save($this->request->data);
                    }
                    
                    // Step 1: Consultamos los precios de los inmuebles del desarrollo que esten liberados "SaaK" - 11/03/2019
                    // Se tienen que buscar también los máximos y mínimos de construcción, estacionamientos, habitaciones y baños.
                    $desarrollo_inmuebles = $this->DesarrolloInmueble->find('all', array(
                        'fields'     => array(
                            'Inmueble.precio'
                        ),
                        'conditions' => array(
                            'DesarrolloInmueble.desarrollo_id' => $desarrollo_id,
                            'Inmueble.liberada'                => 1
                        )
                    ));
                    $precios_liberados = array();
                    foreach ($desarrollo_inmuebles as $inmuebles) {
                        array_push($precios_liberados, $inmuebles['Inmueble']['precio']);
                    }

                    // Step 2: Guaramos los precios minimos y maximos de los inmuebles "SaaK" - 11/03/2019
                    //Se calculan los máximos y mínimos de construcción, estacionamientos, habitaciones y baños.
                    $this->request->data['Desarrollo']['id']         = $desarrollo_id;
                    //$this->request->data['Desarrollo']['precio_low'] = min($precios_liberados);
                    //$this->request->data['Desarrollo']['precio_top'] = max($precios_liberados);
                    $this->loadModel('Desarrollo');
                    $this->Desarrollo->create();
                    $this->Desarrollo->save($this->request->data);


                    switch ($this->request->data['Inmueble']['return']):
                        case (1):
                            return $this->redirect(array('action' => 'view_tipo', 'controller'=>'inmuebles', $this->request->data['Inmueble']['id'],$this->request->data['Inmueble']['desarrollo_id']));
                            break;
                        case (2):
                            return $this->redirect(array('action' => 'view', 'controller'=>'inmuebles', $this->request->data['Inmueble']['desarrollo_id']));
                            break;
                        case (3):
                            return $this->redirect(array('controller'=>'desarrollos','action' => 'view',$this->request->data['Inmueble']['desarrollo_id']));
                            break;

                        case (4):
                            return $this->redirect(array('controller'=>'inmuebles','action' => 'edit_unidades',$id, $id_desarrollo));
                            break;
                    endswitch;

		}
			$options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
                        $inmueble = $this->Inmueble->find('first', $options);
			$this->request->data = $inmueble;
                        $this->set('inmueble',$inmueble);
		
        $this->set('inmueble',$this->Inmueble->read(null,$id));
        $this->set('fotos_inmueble',$this->FotoInmueble->find('all',
            array(
                'conditions'   =>array(
                    'inmueble_id' => $id
                ),
                'recursive' => -1,
                'order' => array(
                  'orden' => 'ASC'
                )
            )
        ));
		$opcionadors = $this->User->find('list',array('conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE opcionador = 1 AND cuenta_id = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').")"),'order'=>'User.nombre_completo ASC'));
		$this->set(compact('opcionadors'));
        $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('desarrollo',$this->Desarrollo->read(null,$id_desarrollo));
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
        public function edit2(){
            if ($this->request->is(array('post', 'put'))) {
                echo var_dump($this->request->data['precio']);
            }
        }
        
	public function edit($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout= 'bos';
		if (!$this->Inmueble->exists($id)) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
                
                
		if ($this->request->is(array('post', 'put'))) {

            // Guardamos el precio inicial del inmueble
            // $this->request->data['Precio']['inmueble_id'] = $this->request->data['Inmueble']['id'];
            // $this->request->data['Precio']['precio']      = $this->request->data['Inmueble']['precio_inicial'];
            // $this->request->data['Precio']['fecha']       = date('Y-m-d');
            // $this->request->data['Precio']['user_id']     = $this->Session->read('Auth.User.id');
            // $this->Precio->create();
            // $this->Precio->save($this->request->data);

                    //echo var_dump($this->request->data[]]);
                    $this->request->data['Inmueble']['referencia']=$this->request->data['referencia'];
                    $this->request->data['Inmueble']['titulo']=$this->request->data['titulo'];
                    $this->request->data['Inmueble']['dic_tipo_propiedad_id']=$this->request->data['tipo_propiedad'];
                    $this->request->data['Inmueble']['fecha_inicio_exclusiva'] = date('Y-m-d', strtotime($this->request->data['Inmueble']['fecha_inicio_exclusiva']));
                    $this->request->data['Inmueble']['due_date'] = date('Y-m-d', strtotime($this->request->data['Inmueble']['due_date']));
                    $this->request->data['Inmueble']['exclusiva']=$this->request->data['exclusiva'];
                    $this->request->data['Inmueble']['venta_renta']=$this->request->data['venta'];
                    if ($this->Inmueble->save($this->request->data)) {
                                if ($this->request->data['Inmueble']['cambio_precio']==1){
                                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogInmueble']['mensaje'] = "Cambio de precio a: ".$this->request->data['Inmueble']['precio'];
                                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                                    $this->request->data['LogInmueble']['accion'] = 2;
                                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                                    $this->LogInmueble->create();
                                    $this->LogInmueble->save($this->request->data);
                                    
                                    $this->request->data['Precio']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                                    $this->request->data['Precio']['precio'] = $this->request->data['Inmueble']['precio'];
                                    $this->request->data['Precio']['fecha'] = date('Y-m-d');
                                    $this->request->data['Precio']['user_id'] = $this->Session->read('Auth.User.id');
                                    $this->Precio->create();
                                    $this->Precio->save($this->request->data);
                    
                                }else{
                                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogInmueble']['mensaje'] = "Edición de información";
                                    $this->request->data['LogInmueble']['accion'] = 2;
                                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                                    $this->LogInmueble->create();
                                    $this->LogInmueble->save($this->request->data);
                                }
                                
				$this->Session->setFlash(__('The inmueble has been saved.'));
                                if ($this->request->data['Inmueble']['return']==1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('action' => 'caracteristicas',$id));
                                }
			} else {
				$this->Session->setFlash(__('The inmueble could not be saved. Please, try again.'));
			}
                   //echo var_dump($this->request->data['Inmueble']);
		} else {
			$options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
                        $inmueble = $this->Inmueble->find('first', $options);
			$this->request->data = $inmueble;
                        $this->set('inmueble',$inmueble);
		}
                $this->set('inmueble',$this->Inmueble->read(null,$id));
		$opcionadors = $this->User->find('list',array('conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE opcionador = 1 AND cuenta_id = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').")"),'order'=>'User.nombre_completo ASC'));
		$this->set(compact('opcionadors'));
                $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
	}
        
        public function modificacion($desarrollo_id = null) {
            $this->loadModel('Desarrollo');
            if ($this->request->is(array('post', 'put'))) {
                
                // Step 1 Setear la información para guardar.
                $precios          = array();
                $estacionamientos = array();
                $habitaciones     = array();
                $banos_a          = array();
                $construccion_a   = array();
                $p1               = 0;
                $p2               = 0;

                


                // print_r($this->request->data['InmuebleTipo']);

                // Paso 2 hacer el recorrido del request data
                foreach ($this->request->data['InmuebleTipo'] as $propiedades) {
                    $construccionA     = 0;
                    $construccionB     = 0;
                    $habitacionA       = 0;
                    $baniosA           = 0;
                    $baniosB           = 0;
                    $estacionamientosA = 0;
                    $estacionamientosB = 0;
                    $nivelPropiedad = 0;
                    // Paso 3 detectamos cuales son las liberadas para guardar los minimos y máximos de los precios.
                    if ($propiedades['Inmueble']['liberada'] == 1) {

                        if ($propiedades['Inmueble']['precio'] > 0) {
                            array_push($precios, $propiedades['Inmueble']['precio']);
                        }

                        if ($propiedades['Inmueble']['precio_2'] > 0) {
                            array_push($precios, $propiedades['Inmueble']['precio_2']);
                        }
                        
                    }
                    
                    // Paso 4 agregamos al arreglo para despues calcular minimos y maximos.
                    if (isset($propiedades['Inmueble']['construccion']) && $propiedades['Inmueble']['construccion'] > 0) {
                        $construccionA = $propiedades['Inmueble']['construccion'];
                    }
                    if (isset($propiedades['Inmueble']['construccion_no_habitable']) && $propiedades['Inmueble']['construccion_no_habitable'] > 0) {
                        $construccionB = $propiedades['Inmueble']['construccion_no_habitable'];
                    }
                    if (isset($propiedades['Inmueble']['recamaras']) && $propiedades['Inmueble']['recamaras'] > 0) {
                        $habitacionA = $propiedades['Inmueble']['recamaras'];
                    }
                    if (isset($propiedades['Inmueble']['banos']) && $propiedades['Inmueble']['banos'] > 0) {
                        $baniosA = $propiedades['Inmueble']['banos'];
                    }
                    if (isset($propiedades['Inmueble']['medio_banos']) && $propiedades['Inmueble']['medio_banos'] > 0) {
                        $baniosB = $propiedades['Inmueble']['medio_banos'];
                    }
                    if (isset($propiedades['Inmueble']['estacionamiento_techado']) && $propiedades['Inmueble']['estacionamiento_techado'] > 0) {
                        $estacionamientosA = $propiedades['Inmueble']['estacionamiento_techado'];
                    }
                    if (isset($propiedades['Inmueble']['estacionamiento_descubierto']) && $propiedades['Inmueble']['estacionamiento_descubierto'] > 0) {
                        $estacionamientosB = $propiedades['Inmueble']['estacionamiento_descubierto'];
                    }
                    if (isset($propiedades['Inmueble']['nivel_propiedad']) && $propiedades['Inmueble']['nivel_propiedad'] > 0) {
                        $nivelPropiedad = $propiedades['Inmueble']['nivel_propiedad'];
                    }
                    


                    array_push($construccion_a, $construccionA + $construccionB);
                    array_push($habitaciones, $habitacionA);
                    array_push($banos_a, $baniosA + $baniosB);
                    array_push($estacionamientos, $estacionamientosA + $estacionamientosB);

                    // Paso 5 seteamos y guardamos la información en la base de datos.
                    $this->request->data['Inmueble']['id']                          = $propiedades['Inmueble']['id'];
                    $this->request->data['Inmueble']['referencia']                  = $propiedades['Inmueble']['referencia'];
                    $this->request->data['Inmueble']['titulo']                      = $propiedades['Inmueble']['titulo'];
                    $this->request->data['Inmueble']['precio']                      = $propiedades['Inmueble']['precio'];
                    $this->request->data['Inmueble']['precio_2']                    = $propiedades['Inmueble']['precio_2'];
                    $this->request->data['Inmueble']['construccion']                = $propiedades['Inmueble']['construccion'];
                    $this->request->data['Inmueble']['construccion_no_habitable']   = $propiedades['Inmueble']['construccion_no_habitable'];
                    $this->request->data['Inmueble']['nivel_propiedad']             = $propiedades['Inmueble']['nivel_propiedad'];
                    $this->request->data['Inmueble']['recamaras']                   = $propiedades['Inmueble']['recamaras'];
                    $this->request->data['Inmueble']['banos']                       = $propiedades['Inmueble']['banos'];
                    $this->request->data['Inmueble']['medio_banos']                 = $propiedades['Inmueble']['medio_banos'];
                    $this->request->data['Inmueble']['estacionamiento_techado']     = $propiedades['Inmueble']['estacionamiento_techado'];
                    $this->request->data['Inmueble']['estacionamiento_descubierto'] = $propiedades['Inmueble']['estacionamiento_descubierto'];
                    $this->request->data['Inmueble']['liberada']                    = $propiedades['Inmueble']['liberada'];
                    $this->Inmueble->save($this->request->data['Inmueble']);
                }

                // Seteamos los valores minimos y maximos para el desarrollo
                
                // Precios
                if (sizeof($precios) > 0 && in_array(max($precios), $precios, true)) {
                    $this->request->data['Desarrollo']['precio_top'] = max($precios);
                }

                if (sizeof($precios) > 0 && in_array(min($precios), $precios, true)) {
                    $this->request->data['Desarrollo']['precio_low'] = min($precios);
                }

                // Construcción
                //if (in_array(max($construccion_a), $construccion_a, true)) {
                    $this->request->data['Desarrollo']['m2_top'] = max($construccion_a);
                //}
                //if (in_array(min($construccion_a), $construccion_a, true)) {
                    $this->request->data['Desarrollo']['m2_low'] = min($construccion_a);
                //}

                // Estacionamientos
                if (sizeof($estacionamientos) > 0 && in_array(max($estacionamientos), $estacionamientos, true)) {
                    $this->request->data['Desarrollo']['est_top'] = max($estacionamientos);
                }
                if (sizeof($estacionamientos) > 0 && in_array(min($estacionamientos), $estacionamientos, true)) {
                    $this->request->data['Desarrollo']['est_low'] = min($estacionamientos);
                }

                // Habitaciones
                if (sizeof($habitaciones) > 0 && in_array(max($habitaciones), $habitaciones, true)) {
                    $this->request->data['Desarrollo']['rec_top'] = max($habitaciones);
                }
                if (sizeof($habitaciones) > 0 && in_array(min($habitaciones), $habitaciones, true)) {
                    $this->request->data['Desarrollo']['rec_low'] = min($habitaciones);
                }

                // Baños
                if (sizeof($banos_a) > 0 && in_array(max($banos_a), $banos_a, true)) {
                    $this->request->data['Desarrollo']['banio_top'] = max($banos_a);
                }
                if (sizeof($banos_a) > 0 && in_array(min($banos_a), $banos_a, true)) {
                    $this->request->data['Desarrollo']['banio_low'] = min($banos_a);
                }
                
                //echo var_dump($construccion_a);
                
                $this->request->data['Desarrollo']['id'] = $this->request->data['General']['desarrollo_id'];
                $this->Desarrollo->save($this->request->data);
                
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Los cambios han sido registrados exitosamente.', 'default', array(), 'm_success'); // Mensaje
                $this->redirect(array('action' => 'view','controller'=>'desarrollos',$this->request->data['General']['desarrollo_id']));

            }/*
            else{*/
                // $desarrollo = $this->Desarrollo->read(null,$desarrollo_id);
                $desarrollo = $this->Desarrollo->find('first', array(
                    'fields' => array('Desarrollo.id', 'Desarrollo.nombre'),
                    'conditions' => array('Desarrollo.id'=>$desarrollo_id),
                    'recursive' => -1
                ));

                $this->set('desarrollo',$desarrollo);
                $this->set('array_options_liberada',array('0'=>'Bloqueado',1=>'Liberada', 2=>'Reserva', 3=>'Contrato', 4=>'Escrituración', 5=>'Baja'));
                $this->set('tipos',$this->Inmueble->find('all',array('order'=>'Inmueble.referencia','conditions'=>array('Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')'))));
            /*}*/
       } 
	
        
        public function datos_cliente($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout= 'bos';
		if (!$this->Inmueble->exists($id)) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
                
                if ($this->request->is(array('post', 'put'))) {
                            $this->Inmueble->create();
                            $this->request->data['Inmueble']['nombre_cliente']=$this->request->data['nombre_cliente'];
                            $this->request->data['Inmueble']['telefono1']=$this->request->data['telefono1'];
                            $this->request->data['Inmueble']['correo_electronico']=$this->request->data['correo_electronico'];
                            
                            if ($this->Inmueble->save($this->request->data)) {
                                
                                $this->Session->setFlash(__('The inmueble has been saved.'));
				if ($this->request->data['Inmueble']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('controller'=>'inmuebles','action' => 'anexos',$id));
                                }
			} else {
                                debug($this->Inmueble->validationErrors);
				
			}
		} else {
			$options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
			$inmueble = $this->Inmueble->find('first', $options);
			$this->request->data = $inmueble;
                        $this->set('inmueble',$inmueble);
		}
		
	}
        
        public function ubicacion($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout= 'bos';
		if (!$this->Inmueble->exists($id)) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
                
                if ($this->request->is(array('post', 'put'))) {
                            $this->Inmueble->create();
                            $this->request->data['Inmueble']['calle']=$this->request->data['calle'];
                            $this->request->data['Inmueble']['numero_exterior']=$this->request->data['numero_ext'];
                            $this->request->data['Inmueble']['colonia']=$this->request->data['colonia'];
                            $this->request->data['Inmueble']['delegacion']=$this->request->data['delegacion'];
                            $this->request->data['Inmueble']['ciudad']=$this->request->data['ciudad'];
                            $this->request->data['Inmueble']['cp']=$this->request->data['cp'];
                            $this->request->data['Inmueble']['estado_ubicacion']=$this->request->data['estado_ubicacion'];
                            if ($this->Inmueble->save($this->request->data)) {
                                
                                $this->Session->setFlash(__('The inmueble has been saved.'));
				if ($this->request->data['Inmueble']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('controller'=>'inmuebles','action' => 'datos_cliente',$id));
                                }
			} else {
                                debug($this->Inmueble->validationErrors);
				
			}
		} else {
			$options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
                        $inmueble = $this->Inmueble->find('first', $options);
			$this->request->data = $inmueble;
                        $this->set('inmueble',$inmueble);
                        $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                        $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
                        
		}
		
	}
        
        public function caracteristicas($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout= 'bos';
		if (!$this->Inmueble->exists($id)) {
			throw new NotFoundException(__('Invalid inmueble'));
        }
        $this->set('total', 0);
                
                if ($this->request->is(array('post', 'put'))) {
                            $this->request->data['Inmueble']['construccion'] = $this->request->data['construccion'];
                            $this->request->data['Inmueble']['recamaras'] = $this->request->data['recamaras'];
                            $this->request->data['Inmueble']['banos'] = $this->request->data['banios'];
                            $this->Inmueble->create();
                            if ($this->Inmueble->save($this->request->data)) {
                                
                                $this->Session->setFlash(__('The inmueble has been saved.'));
				if ($this->request->data['Inmueble']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('controller'=>'inmuebles','action' => 'ubicacion',$id));
                                }
			} else {
                                debug($this->Inmueble->validationErrors);
				
			}
		} else {
			$options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
                        $inmueble = $this->Inmueble->find('first', $options);
                        $this->set('inmueble',$inmueble);
			$this->request->data = $inmueble;
                        
                        
		}
		
	}
        
//        public function anexos($id = null) {
//             if ($this->Session->read('Permisos.Group.id')==5){
//                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
//                }
//		if (!$this->Inmueble->exists($id)) {
//			throw new NotFoundException(__('Invalid inmueble'));
//		}
//                
//                if ($this->request->is(array('post', 'put'))) {
//                    $this->Inmueble->create();
//                        foreach($this->request->data['Inmueble']['foto_inmueble'] as $unitario):
//                            $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario['name'];
//                            move_uploaded_file($unitario['tmp_name'],$filename);
//                            $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario['name'];
//                            $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','',0)");
//                        endforeach;
//                        foreach($this->request->data['Inmueble']['anexos'] as $unitario1):
//                            $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario1['name'];
//                            move_uploaded_file($unitario1['tmp_name'],$filename);
//                            $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario1['name'];
//                            $this->request->data['DocumentosUser']['documento'] = $unitario1['name'];
//                            $this->request->data['DocumentosUser']['inmueble_id'] = $id;
//                            $this->request->data['DocumentosUser']['user_id'] = $this->Session->read('Auth.User.id');
//                            $this->request->data['DocumentosUser']['ruta'] = $ruta;
//                            $this->request->data['DocumentosUser']['asesor'] = 0;
//                            $this->request->data['DocumentosUser']['desarrollador'] = 0;
//                            $this->DocumentosUser->create();
//                            $this->DocumentosUser->save($this->request->data);
//                        endforeach;
//                        return $this->redirect(array('action' => 'view',$id));
//			
//		} else {
//                    $options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
//                    $inmueble = $this->Inmueble->find('first', $options);
//			$this->request->data = $inmueble;
//                        $this->set('inmueble',$inmueble);
//                    
//                        
//		}
//	}
        
        public function anexos($id = null) {
            if ($this->Session->read('Auth.User.group_id')==5){
                return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
		$inmueble = $this->Inmueble->read(null,$id);
    		if (!$this->Inmueble->exists($id)) {
    			throw new NotFoundException(__('Invalid inmuebles'));
    		}
		if ($this->request->is(array('post', 'put'))) {

                // print_r($this->request->data);
                
                $brochure = $this->request->data['Inmueble']['brochure'];
                if ($inmueble['Inmueble']['brochure']==""){
                    $this->request->data['Inmueble']['brochure']="";
                }else{
                    $this->request->data['Inmueble']['brochure']=$inmueble['Inmueble']['brochure'];
                }
                $this->Inmueble->save($this->request->data);

                // Eliminar fotografias y planos
                if (isset($this->request->data['fotografias'])) {
                    foreach ($this->request->data['fotografias'] as $fotografias) {
                        // Localizar las que se tienen que eliminar
                        if (isset($fotografias['eliminar'])) {
                            $this->FotoInmueble->delete($fotografias['id']);
                        }else{
                            $this->request->data['FotoInmueble']['id']          = $fotografias['id'];
                            $this->request->data['FotoInmueble']['descripcion'] = $fotografias['descripcion'];
                            $this->request->data['FotoInmueble']['orden']       = $fotografias['orden'];
                            $this->FotoInmueble->save($this->request->data);
                        }
                    }
                }
                
                /*for($i=1;$i<$this->request->data['Inmueble']['i'];$i++){
                    $this->request->data['FotoInmueble']['id']            = $this->request->data['Inmueble']['foto_id'.$i];
                    $this->request->data['FotoInmueble']['descripcion']   = $this->request->data['Inmueble']['descripcion'.$i];
                    $this->request->data['FotoInmueble']['orden']         = $this->request->data['Inmueble']['orden'.$i];
                    $this->FotoInmueble->save($this->request->data);
                }*/
                    
                    // Subir imagenes del desarrollo
                $id = $this->request->data['Inmueble']['id'];
                
                if ($this->request->data['Inmueble']['fotos'][0]['name']!="") {
                    foreach ($this->request->data['Inmueble']['fotos'] as $fotos) {
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$fotos['name'];
                        move_uploaded_file($fotos['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$fotos['name'];
                        $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','',0,1)");
                            
                            // Comentador por SaaK no funciona en php7
                            /*
                            ImageTool::resize(array(
                                'input' => $filename,
                                'output'=>$filename,
                                'width' => 800,
                                'keepRatio' => true,
                            ));*/
                    }
                }
            
                if ($this->request->data['Inmueble']['planos_comerciales'][0]['name']!="") {
                    foreach ($this->request->data['Inmueble']['planos_comerciales'] as $fotos) {
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$fotos['name'];
                        move_uploaded_file($fotos['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$fotos['name'];
                        $this->Inmueble->query("INSERT INTO foto_inmuebles VALUES (0,$id,'".$ruta."','',0,2)");
                            
                            // Comentador por SaaK no funciona en php7
                            /*
                            ImageTool::resize(array(
                                'input' => $filename,
                                'output'=>$filename,
                                'width' => 800,
                                'keepRatio' => true,
                            ));*/
                    }
                }
            
                
                
            //Subir Documentos
            if ($this->request->data['Inmueble']['planos'][0]['name']!="") {
                $user_id = $this->Session->read('Auth.User.id');
                foreach ($this->request->data['Inmueble']['planos'] as $documentos) {
                    $id_doc = uniqid();
                    $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$documentos['name'];
                    move_uploaded_file($documentos['tmp_name'],$filename);
                    $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$documentos['name'];
                    $nombre = $documentos['name'];
                    $this->Inmueble->query("INSERT INTO documentos_users VALUES ('$id_doc',$user_id,'$nombre','$ruta','','',1,1,$id)");
                }
            }
            //Subir Brochure
            if ($brochure["name"]) {
                $user_id = $this->Session->read('Auth.User.id');
                $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$brochure['name'];
                move_uploaded_file($brochure['tmp_name'],$filename);
                $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$brochure['name'];
                $this->Inmueble->query("UPDATE inmuebles SET brochure = '$ruta' WHERE id  = $id");
                
            }
            
            
            $this->set('imagenes',$this->FotoInmueble->find('all',array('conditions'=>array('Inmueble.id'=>$id),'order'=>array('FotoInmueble.orden'=>'ASC'))));

            $this->Session->setFlash(__('The desarrollo has been saved.'));
            if($this->request->data['Inmueble']['return']==1){
                return $this->redirect(array('controller'=>'inmuebles','action' => 'view',$id));
            }else{
                return $this->redirect(array('controller'=>'inmuebles','action' => 'anexos',$id));
            }
                    
//                    echo var_dump($this->request->data['Inmueble']);
			
		} else {
                    $options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
                    $inmueble = $this->Inmueble->find('first', $options);
                    $this->request->data = $inmueble;
                    $this->set('inmueble',$inmueble);
                    $this->set('imagenes',$this->FotoInmueble->find('all',array('conditions'=>array('Inmueble.id'=>$id),'order'=>array('FotoInmueble.orden'=>'ASC'))));
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
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Inmueble->delete()) {
			$this->Session->setFlash(__('The inmueble has been deleted.'));
		} else {
			$this->Session->setFlash(__('The inmueble could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function delete_depto($id = null,$id_desarrollo = null) {
             $this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Inmueble->delete()) {
			$this->Session->setFlash(__('The inmueble has been deleted.'));
		} else {
			$this->Session->setFlash(__('The inmueble could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'view','controller'=>'desarrollos',$id_desarrollo));
	}
        
        public function status($id = null, $status = null, $id_desarrollo = null) {
            //$this->layout= 'bos';
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		if($this->request->is('post')){
                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogInmueble']['mensaje'] = "Cambio de status";
                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                    $this->request->data['LogInmueble']['accion'] = 2;
                    $this->LogInmueble->create();
                    $this->LogInmueble->save($this->request->data);
                    $this->Inmueble->query("UPDATE inmuebles SET liberada = $status WHERE id = ".$this->request->data['Inmueble']['id']);
                    switch ($status){
                        case 0:
                            $this->Session->setFlash(__('El inmueble ha sido bloqueado'),'default',array('class'=>'success'));
                            break;
                        case 1:
                            $this->Session->setFlash(__('El inmueble ha sido liberado'),'default',array('class'=>'success'));
                            break;
                        case 2:
                            $this->Session->setFlash(__('El inmueble ha sido reservado'),'default',array('class'=>'success'));
                            break;
                        case 3:
                            $this->Session->setFlash(__('El inmueble ha sido cambiado a contratado'),'default',array('class'=>'success'));
                            break;
                        case 4:
                            $this->Session->setFlash(__('El inmueble ha sido escriturado'),'default',array('class'=>'success'));
                            break;
                    }
                    return $this->redirect(array('action' => 'index'));
                }
                else{
                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogInmueble']['mensaje'] = "Cambio a status: $status ";
                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d H:i:s');
                    $this->request->data['LogInmueble']['inmueble_id'] = $id;
                    $this->LogInmueble->create();
                    $this->LogInmueble->save($this->request->data);
                    $this->Inmueble->query("UPDATE inmuebles SET liberada = $status WHERE id = ".$id);
                    switch ($status){
                        case 0:
                            $this->Session->setFlash(__('El inmueble ha sido bloqueado'),'default',array('class'=>'success'));
                            break;
                        case 1:
                            $this->Session->setFlash(__('El inmueble ha sido liberado'),'default',array('class'=>'success'));
                            break;
                        case 2:
                            $this->Session->setFlash(__('El inmueble ha sido reservado'),'default',array('class'=>'success'));
                            break;
                        case 3:
                            $this->Session->setFlash(__('El inmueble ha sido cambiado a contratado'),'default',array('class'=>'success'));
                            break;
                        case 4:
                            $this->Session->setFlash(__('El inmueble ha sido escriturado'),'default',array('class'=>'success'));
                            break;
                    }


                    if (isset($id_desarrollo)){
                        // Step 1: Consultamos los precios de los inmuebles del desarrollo que esten liberados "SaaK" - 11/03/2019
                        $desarrollo_inmuebles = $this->DesarrolloInmueble->find('all', array(
                            'fields'     => array(
                                'Inmueble.precio'
                            ),
                            'conditions' => array(
                                'DesarrolloInmueble.desarrollo_id' => $id_desarrollo,
                                'Inmueble.liberada'                => 1
                            )
                        ));
                        $precios_liberados = array();
                        foreach ($desarrollo_inmuebles as $inmuebles) {
                            array_push($precios_liberados, $inmuebles['Inmueble']['precio']);
                        }

                        // Step 2: Guaramos los precios minimos y maximos de los inmuebles "SaaK" - 11/03/2019
                        $this->request->data['Desarrollo']['id']         = $id_desarrollo;
                        
                        if (sizeof($precios_liberados) > 0 && in_array(max($precios_liberados), $precios_liberados, true)) {
                            $this->request->data['Desarrollo']['precio_top'] = max($precios_liberados);
                        }
        
                        if (sizeof($precios_liberados) > 0 && in_array(min($precios_liberados), $precios_liberados, true)) {
                            $this->request->data['Desarrollo']['precio_low'] = min($precios_liberados);
                        }
                        
                        $this->loadModel('Desarrollo');
                        $this->Desarrollo->create();
                        $this->Desarrollo->save($this->request->data);
                        
                        return $this->redirect(array('action' => 'view','controller'=>'desarrollos',$id_desarrollo));
                    }else{
                        return $this->redirect(array('action' => 'index'));
                    }
                }
                /*$this->set('inmueble',$this->Inmueble->read(null,$id));
                $this->set('stat',$status);*/
                
			
		
		
	}
        
        public function status_detalle($id = null, $status = null) {
            //$this->layout= 'bos';
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		if($this->request->is('post')){
                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogInmueble']['mensaje'] = "Cambio a status: ".$this->request->data['Inmueble']['stat']." / ".$this->request->data['Inmueble']['mensaje'];
                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d');
                    $this->request->data['LogInmueble']['accion'] = 2;
                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Inmueble']['id'];
                    $this->LogInmueble->create();
                    $this->LogInmueble->save($this->request->data);
                    $this->Inmueble->query("UPDATE inmuebles SET liberada = $status WHERE id = ".$this->request->data['Inmueble']['id']);
                    switch ($status){
                        case 0:
                            $this->Session->setFlash(__('El inmueble ha sido bloqueado'),'default',array('class'=>'success'));
                            break;
                        case 1:
                            $this->Session->setFlash(__('El inmueble ha sido liberado'),'default',array('class'=>'success'));
                            break;
                        case 2:
                            $this->Session->setFlash(__('El inmueble ha sido reservado'),'default',array('class'=>'success'));
                            break;
                        case 3:
                            $this->Session->setFlash(__('El inmueble ha sido cambiado a contratado'),'default',array('class'=>'success'));
                            break;
                        case 4:
                            $this->Session->setFlash(__('El inmueble ha sido escriturado'),'default',array('class'=>'success'));
                            break;
                    }
                    return $this->redirect(array('action' => 'index'));
                }
                else{
                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogInmueble']['mensaje'] = "Cambio a status: $status ";
                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d H:i:s');
                    $this->request->data['LogInmueble']['inmueble_id'] = $id;
                    $this->request->data['LogInmueble']['accion'] = 2;
                    $this->LogInmueble->create();
                    $this->LogInmueble->save($this->request->data);
                    $this->Inmueble->query("UPDATE inmuebles SET liberada = $status WHERE id = ".$id);
                    switch ($status){
                        case 0:
                            $this->Session->setFlash(__('El inmueble ha sido bloqueado'),'default',array('class'=>'success'));
                            break;
                        case 1:
                            $this->Session->setFlash(__('El inmueble ha sido liberado'),'default',array('class'=>'success'));
                            break;
                        case 2:
                            $this->Session->setFlash(__('El inmueble ha sido reservado'),'default',array('class'=>'success'));
                            break;
                        case 3:
                            $this->Session->setFlash(__('El inmueble ha sido cambiado a contratado'),'default',array('class'=>'success'));
                            break;
                        case 4:
                            $this->Session->setFlash(__('El inmueble ha sido escriturado'),'default',array('class'=>'success'));
                            break;
                    }
                    return $this->redirect(array('action' => 'view',$id));
                }
                /*$this->set('inmueble',$this->Inmueble->read(null,$id));
                $this->set('stat',$status);*/
                
			
		
		
	}
        
        public function bloquear($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Inmueble->query("UPDATE inmuebles SET liberada = 0 WHERE id = ".$id);
		
			$this->Session->setFlash(__('El inueble ha sido bloqueado'),'default',array('class'=>'success'));
		
		return $this->redirect(array('action' => 'index'));
	}
        
        public function destacar($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Inmueble->query("UPDATE inmuebles SET destacado = 1 WHERE id = ".$id);
		
			$this->Session->setFlash(__('El inmueble ha quedado como destacado'),'default',array('class'=>'success'));
		
		return $this->redirect(array('action' => 'index'));
	}
        
        public function undestacar($id = null) {
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Inmueble->query("UPDATE inmuebles SET destacado = 0 WHERE id = ".$id);
		
			$this->Session->setFlash(__('El inmueble ya no está destacado'),'default',array('class'=>'success'));
		
		return $this->redirect(array('action' => 'index'));
	}
        
        public function solicitar_cambios($id = null){
            $this->Email = new CakeEmail();
            $this->Email->from(array('no_reply@bosinmobiliaria' => 'Solicitud da cambios o sugerencias en ficha de propiedad'));
            $this->Email->to('inmuebles@bosinmobiliaria.com.mx');
            $this->Email->subject('Solicitud de cambios o sugerencias de inmueble');
            $this->Email->emailFormat('html');
            $this->Email->send($this->request->data['Inmueble']['mensaje']."<br>"
                    . "Detalle de inmueble: <a href='http://bosinmobiliaria.com/sistema/inmuebles/view/".$id."'>Ver ficha</a>");
            $this->Session->setFlash(__('Los comentarios han sido enviados'),'default',array('class'=>'success'));
            return $this->redirect(array('action' => 'detail_client',$id));
        }
        
        public function archivos($id=null){
            $this->Session->write('clundef',$this->Cliente->find('count',array('conditions'=>array('Cliente.user_id IS NULL'))));
             if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
            if ($this->request->is('post')){
                //echo var_dump($this->request->data['Desarrollo']['foto_inmueble']);
                $id = $this->request->data['Inmueble']['inmueble_id'];
                $unitario = $this->request->data['Inmueble']['foto_inmueble'];
		$filename = getcwd()."/files/inmuebles/".$id."/".$unitario['name'];
                move_uploaded_file($unitario['tmp_name'],$filename);
		$ruta = "/files/desarrollos/".$id."/".$unitario['name'];
                $this->request->data['DocumentosUser']['documento'] = $this->request->data['Inmueble']['documento'];
                $this->request->data['DocumentosUser']['inmueble_id'] = $this->request->data['Inmueble']['inmueble_id'];
                $this->request->data['DocumentosUser']['user_id'] = $this->request->data['Inmueble']['user_id'];
                $this->request->data['DocumentosUser']['ruta'] = $ruta;
                $this->request->data['DocumentosUser']['asesor'] = 0;
                $this->request->data['DocumentosUser']['desarrollador'] = 0;
                $this->DocumentosUser->create();
                $this->DocumentosUser->save($this->request->data);
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'view',$id));
                //echo var_dump($this->request->data['Inmueble']['foto_inmueble']);
                
               
                
            }else{
                $this->set('id',$id);
            }
        }


    /*************************************
    *
    *   Agregar documentos del inmueble
    *
    *************************************/
    public function documentos($id = null){
        if (!$this->Inmueble->exists($id)) {
            throw new NotFoundException(__('Invalid inmueble'));
        }

        if ($this->Session->read('Permisos.Group.id')==5){
            return $this->redirect(array('action' => 'mysession','controller'=>'users'));
        }

        if ($this->request->is(array('post', 'put'))) {



            foreach($this->request->data['Desarrollo']['foto_desarrollo'] as $unitario1):
                $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario1['name'];
                move_uploaded_file($unitario1['tmp_name'],$filename);
                $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$id."/".$unitario1['name'];
                $this->request->data['DocumentosUser']['documento'] = $unitario1['name'];
                $this->request->data['DocumentosUser']['inmueble_id'] = $id;
                $this->request->data['DocumentosUser']['user_id'] = $this->Session->read('Auth.User.id');
                $this->request->data['DocumentosUser']['ruta'] = $ruta;
                $this->request->data['DocumentosUser']['asesor'] = 0;
                $this->request->data['DocumentosUser']['desarrollador'] = 0;
                $this->DocumentosUser->create();
                $this->DocumentosUser->save($this->request->data);
            endforeach;
            return $this->redirect(array('action' => 'documentos/'.$id));
            
        }else{
            $this->set('documentos', $this->DocumentosUser->find('all', array('conditions'=>array('DocumentosUser.inmueble_id'=>$id))));
            $this->set('id',$id);
        }
    }

    /*************************************
    *
    *   Eliminar documentos del inmueble
    *
    *************************************/
    public function eliminar_documento($id = null, $inmueble_id = null){
        $this->request->onlyAllow('post', 'delete');
        if ($this->DocumentosUser->delete($id)) {
            $this->Session->setFlash(__('The inmueble has been deleted.'));
            $this->redirect(array('action' => 'anexos',$inmueble_id));
        } else {
            $this->Session->setFlash(__('The inmueble could not be deleted. Please, try again.'));
            $this->redirect(array('action' => 'documentos/',$inmueble_id));
        }
    }
    
    public function log_inmueble($id_inmueble=null, $tipo =null){
            $this->set('log',$this->LogInmueble->find('all',array('order'=>'LogInmueble.id DESC','conditions'=>array('Inmueble.id'=>$id_inmueble,'LogInmueble.accion'=>$tipo))));
        }

    ///////////////////////////////////////
    // Funcion para recabar los datos del
    // ponchaut
    // ///////////////////////////////////
    public function ponchaut($inmobil_id = null, $id = null){
        $this->loadModel('DicTipoPropiedad');

        $this->set("layout", $inmobil_id);
        $options = array('conditions' => array('Inmueble.' . $this->Inmueble->primaryKey => $id));
        $this->set('inmueble', $this->Inmueble->find('first', $options));
        $this->set('tipo_propiedad', $this->DicTipoPropiedad->find('list'));
        // $venta = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
        $this->set('venta_renta', array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta'));
        $this->set('tipo_inmueble', array('Inmueble'=>'Inmueble','Desarrollo'=>'Desarrollo'));


    }

    /*******************************************************
    *       Autor: SaaK
    *   Metodo para eliminar los inmuebles en desarrollo
    *   *Este metodo se remplaza por update_inventario
    *   
    *******************************************************/
    public function delete_js(){
        if ($this->request->is('post')) {
            $var = explode(',', $this->request->data['Inmueble']['ids']);
            foreach ($var as $id) {
                    $this->Inmueble->query("DELETE FROM inmuebles WHERE id=$id");
            }
            // $this->redirect(array('controller'=>'desarrollos', 'action' => 'view',$this->request->data['Inmueble']['desarrollo_id']));
            $this->redirect('/desarrollos/view/'.$this->request->data['Inmueble']['desarrollo_id']);
        }
    }

    /*******************************************************
    *       Autor: SaaK
    *   Metodo hacer cambio de estatus o borrar
    *******************************************************/
    function update_inventario(){
        if ($this->request->is('post')) {
            //print_r($this->request->data);
            foreach ($this->request->data as $inmueble) {
                // Vaidamos si selecciono eliminar
                if (isset($inmueble['borrar'])) {
                    $this->Inmueble->delete($inmueble['inmueble_id']);
                }elseif (isset($inmueble['liberar'])) {
                    $this->request->data['Inmueble']['id']       = $inmueble['inmueble_id'];
                    $this->request->data['Inmueble']['liberada'] = 1;
                    $this->Inmueble->save($this->request->data);
                }
            }

            // Step 1: Consultamos los precios de los inmuebles del desarrollo que esten liberados "SaaK" - 11/03/2019
            $desarrollo_inmuebles = $this->DesarrolloInmueble->find('all', array(
                'fields'     => array(
                    'Inmueble.precio'
                ),
                'conditions' => array(
                    'DesarrolloInmueble.desarrollo_id' => $this->request->data['General']['desarrollo_id'],
                    'Inmueble.liberada'                => 1
                )
            ));
            $precios_liberados = array();
            foreach ($desarrollo_inmuebles as $inmuebles) {
                array_push($precios_liberados, $inmuebles['Inmueble']['precio']);
            }

            // Step 2: Guaramos los precios minimos y maximos de los inmuebles "SaaK" - 11/03/2019
            $this->request->data['Desarrollo']['id']         = $this->request->data['General']['desarrollo_id'];
    
            // Validaciones para maximos y minimos. "Saak" - 06/02/2020
            if (sizeof($precios_liberados) > 0 && in_array(max($precios_liberados), $precios_liberados, true)) {
                $this->request->data['Desarrollo']['precio_top'] = max($precios_liberados);
            }else {
                $this->request->data['Desarrollo']['precio_top'] = $precios_liberados;
            }
            if (sizeof($precios_liberados) > 0 && in_array(min($precios_liberados), $precios_liberados, true)) {
                $this->request->data['Desarrollo']['precio_low'] = min($precios_liberados);
            }else {
                $this->request->data['Desarrollo']['precio_low'] = $precios_liberados;
            }

            $this->loadModel('Desarrollo');
            $this->Desarrollo->create();
            $this->Desarrollo->save($this->request->data);

            $this->redirect(array('controller'=>'Desarrollos', 'action'=>'view', $this->request->data['General']['desarrollo_id']));
        }
    }


    /*******************************************************
    *       Autor: SaaK
    *   Metodo para duplicar una unidad
    *******************************************************/
    function clon_unidad_tipo($desarrollo_id = null){
        // $clon_id = $this->request->data['ClonInmueble']['id'];
        // $unidad_para_clonar = $this->Inmueble->find('first', $clon_id);

        // if ($this->request->is('post')) {
        //     for ($i = 0; $i < $this->request->data['ClonInmueble']['cantidad']; $i++){
                $this->Inmueble->create();
                    $this->request->data['Inmueble']['id']                    = 0;
                    $this->request->data['Inmueble']['dic_tipo_propiedad_id'] = 0;
                    $this->request->data['Inmueble']['titulo']                = 'Hola como estas';
                    $this->request->data['Inmueble']['exclusiva']             = 'Exclusiva';
                    $this->request->data['Inmueble']['venta_renta']           = 'Venta / Renta';
                    $this->request->data['Inmueble']['colonia']               = 'Es colonia';
                    $this->request->data['Inmueble']['delegacion']            = 'Es delegacion';
                    $this->request->data['Inmueble']['ciudad']                = 'Es ciudad';
                    $this->request->data['Inmueble']['cp']                    = 'Es cp';
                    $this->request->data['Inmueble']['estado_ubicacion']      = 'Es estado_ubicacion';
                    $this->request->data['Inmueble']['fecha']                 = date('d-m-Y');
                    $this->request->data['Inmueble']['nombre_cliente']        = 'Es nombre_cliente';
                    $this->request->data['Inmueble']['apellido_paterno']      = 'Es apellido_paterno';
                    $this->request->data['Inmueble']['telefono1']             = 'Es telefono1';
                    $this->request->data['Inmueble']['correo_electronico']    = 'Es correo_electronico';
                    $this->request->data['Inmueble']['calle']                 = 'Es calle';
                    $this->request->data['Inmueble']['numero_exterior']       = 'Es numero_exterior';
                $this->Inmueble->save($this->request->data);

                /*$inmueble_id = $this->Inmueble->getLastInsertID();
                echo "Este es el id ".$inmueble_id;*/
        //     }
        // }
    }


    public function edit_unidades_ind($inmueble_id = null){
        if ($this->Session->read('Permisos.Group.id')==5){
            return $this->redirect(array('action' => 'mysession','controller'=>'users'));
        }
        if ($this->request->is(array('post', 'put'))) {
            // print_r($this->request->data['Inmueble']);
            // echo count($fotos_all);
            $fotos_all                                        = $this->request->data['Inmueble']['foto_inmueble'];
            $this->request->data['Inmueble']['foto_inmueble'] = "";
            $this->request->data['Inmueble']['id']            = $inmueble_id;

            
            // Edición y Eliminacón de fotos.
            if (isset($this->request->data['fotos'])) {
                foreach ($this->request->data['fotos'] as $fotos) {
                    // Localizar las que se tienen que eliminar
                    if (isset($fotos['eliminar'])) {
                        $this->FotoInmueble->delete($fotos['id']);
                    }else{
                        $this->request->data['FotoInmueble']['id']          = $fotos['id'];
                        $this->request->data['FotoInmueble']['descripcion'] = $fotos['descripcion'];
                        $this->request->data['FotoInmueble']['orden']       = $fotos['orden'];
                        $this->FotoInmueble->save($this->request->data);
                    }
                }
            }

            // Alta de nuevas fotos
            if ($fotos_all[0]['name']!="") {
                foreach ($fotos_all as $fot){
                    $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$inmueble_id."/".$fot['name'];
                    move_uploaded_file($fot['tmp_name'],$filename);
                    $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/inmuebles/".$inmueble_id."/".$fot['name'];
                    $query = "INSERT INTO foto_inmuebles VALUES (0,$inmueble_id,'".$ruta."','',0,1)";
                    $this->Inmueble->query($query);
                }
            }

            $this->Inmueble->create();
            $this->Inmueble->save($this->request->data['Inmueble']);
            if ($this->request->data['Inmueble']['cambio_precio'] ==1 ){
                $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
                $this->request->data['LogInmueble']['mensaje']     = "Cambio de precio a: ".$this->request->data['Inmueble']['precio'];
                $this->request->data['LogInmueble']['fecha']       = date('Y-m-d');
                $this->request->data['LogInmueble']['accion']      = 2;
                $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);

                $this->request->data['Precio']['inmueble_id'] = $inmueble_id;
                $this->request->data['Precio']['precio']      = $this->request->data['Inmueble']['precio'];
                $this->request->data['Precio']['fecha']       = date('Y-m-d');
                $this->request->data['Precio']['user_id']     = $this->Session->read('Auth.User.id');
                $this->Precio->create();
                $this->Precio->save($this->request->data);
            }else{
                $this->request->data['LogInmueble']['usuario_id']  = $this->Session->read('Auth.User.id');
                $this->request->data['LogInmueble']['mensaje']     = "Edición de información";
                $this->request->data['LogInmueble']['accion']      = 2;
                $this->request->data['LogInmueble']['fecha']       = date('Y-m-d');
                $this->request->data['LogInmueble']['inmueble_id'] = $inmueble_id;
                $this->LogInmueble->create();
                $this->LogInmueble->save($this->request->data);
            }
            return $this->redirect(array('action' => 'view', 'controller'=>'inmuebles', $inmueble_id));
        }

        $inmueble            = $this->Inmueble->read(null,$inmueble_id);
        $this->request->data = $inmueble;
        $this->set('inmueble',$inmueble);
        $this->set('inmueble',$this->Inmueble->read(null,$inmueble_id));
        $this->set('fotos_inmueble',$this->FotoInmueble->find('all',
            array(
                'conditions'   =>array(
                    'inmueble_id' => $inmueble_id
                ),
                'recursive' => -1,
                'order' => array(
                  'orden' => 'ASC'
                )
            )
        ));
        $opcionadors = $this->User->find('list',array('conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE opcionador = 1 AND cuenta_id = ".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').")"),'order'=>'User.nombre_completo ASC'));
        $this->set(compact('opcionadors'));
        $this->set('tipo_anuncios',$this->DicTipoAnuncio->find('list',array('order'=>'DicTipoAnuncio.tipo_anuncio ASC','conditions'=>array('DicTipoAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('ubicacion_anuncios',$this->DicUbicacionAnuncio->find('list',array('order'=>'DicUbicacionAnuncio.ubicacion_anuncio ASC','conditions'=>array('DicUbicacionAnuncio.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('tipo_propiedad',$this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        
    }
    

    public function get_inmuebles( $cuenta_id = null ) {
        $this->Inmueble->Behaviors->load('Containable');
        header('Access-Control-Allow-Origin: *');
      	header("Access-Control-Allow-Methods: GET, OPTIONS");
        $this->layout = null;
        
        $inmuebles = $this->Inmueble->find('all',array(
                                    'conditions' => array(
                                        'cuenta_id' => $cuenta_id,
                                        'liberada' => 1,
                                        'Inmueble.id NOT IN (SELECT inmueble_id FROM desarrollo_inmuebles)'
                                    ),
                                    'contain' => array(
                                        'FotoInmueble' => array('limit'=>1)
                                    ),
                                    'recursive'=> -1,
                                    'fields' => array(
                                        'id',
                                        'titulo',
                                        'liberada',
                                        'construccion',
                                        'construccion_no_habitable',
                                        'recamaras',
                                        'banos',
                                        'estacionamiento_techado',
                                        'estacionamiento_descubierto',
                                        'colonia',
                                        'ciudad'
                                    )));
                                    
        $s = 0;
        foreach( $inmuebles as $inmueble ) {
            $resp[$s] = array(
                'id'                          => $inmueble['Inmueble']['id'],
                'titulo'                      => $inmueble['Inmueble']['titulo'],
                'liberada'                    => $inmueble['Inmueble']['liberada'],
                'construccion'                => $inmueble['Inmueble']['construccion'],
                'construccion_no_habitable'   => $inmueble['Inmueble']['construccion_no_habitable'],
                'recamaras'                   => $inmueble['Inmueble']['recamaras'],
                'banos'                       => $inmueble['Inmueble']['banos'],
                'estacionamiento_techado'     => $inmueble['Inmueble']['estacionamiento_techado'],
                'estacionamiento_descubierto' => $inmueble['Inmueble']['estacionamiento_descubierto'],
                'colonia'                     => $inmueble['Inmueble']['colonia'],
                'ciudad'                      => $inmueble['Inmueble']['ciudad'],
                'fotoInmueble'                => $inmueble['FotoInmueble'][0]['ruta']
            );
            $s++;
        }
                                        
        // print_r( $nuevaLista );
        echo json_encode( $resp, true);
        $this->autoRender = false; 
    }



    public function get_inmueble_detalle( $inmueble_id = null ) {
        $this->Inmueble->Behaviors->load('Containable');

        header('Access-Control-Allow-Origin: *');
      	header("Access-Control-Allow-Methods: GET, OPTIONS");
        $this->layout = null;

        $inmueble = $this->Inmueble->find('first',
            array(
                'conditions' => array(
                    'Inmueble.' . $this->Inmueble->primaryKey => $inmueble_id
                ),
                'contain' => array(
                    'FotoInmueble',
                    'TipoPropiedad',
                ),
            )
        );


        // Remover y remplazar la descripcion del desarrollo
        $inmueble['Inmueble']['comentarios_custom'] = strip_tags($inmueble['Inmueble']['comentarios']);
        $inmueble['Inmueble']['comentarios150']     = substr(strip_tags($inmueble['Inmueble']['comentarios']), 0, 150).'...';
        $inmueble['Inmueble']['count_fotos']        = count($inmueble['FotoInmueble']);
        $inmueble['Inmueble']['terreno']            = number_format($inmueble['Inmueble']['terreno']);
        $inmueble['Inmueble']['google_maps']        = explode(",", $inmueble['Inmueble']['google_maps']);
        $inmueble['Inmueble']['lat']                = floatval($inmueble['Inmueble']['google_maps']['0']);
        $inmueble['Inmueble']['lng']                = floatval($inmueble['Inmueble']['google_maps']['1']);
        $inmueble['Inmueble']['google_maps']        = implode(",", $inmueble['Inmueble']['google_maps']);

        // Customizacion de los precios
        $inmueble['Inmueble']['precio']           = '$'.number_format($inmueble['Inmueble']['precio'], 2);
        $inmueble['Inmueble']['precio_2']         = '$'.number_format($inmueble['Inmueble']['precio_2'], 2);
        $inmueble['Inmueble']['superficie_total'] = $inmueble['Inmueble']['construccion'] + $inmueble['Inmueble']['construccion_no_habitable'];

        // var_dump( $inmueble );
        echo json_encode( $inmueble, true);
        $this->autoRender = false;
    }
    
        
        
}
