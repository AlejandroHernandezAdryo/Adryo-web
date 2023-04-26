<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'ImageTool');
/**
 * Desarrollos Controller
 *
 * @property Desarrollo $Desarrollo
 * @property PaginatorComponent $Paginator
 */
class DesarrollosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Desarrollo','Inmueble','User','FotoDesarrollo','DocumentosUser','Cliente','Lead','LogDesarrollo','DicLineaContacto', 'CuentaBancariaDesarrollo', 'Categoria', 'Proveedor', 'Venta');
        
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
            $this->Auth->allow('detalle', 'get_desarrollos_detalle', 'get_desarrollos', 'get_images_desarrollo', 'get_planos', 'list_lead_propiedades');
        }

/**
 * index method
 *
 * @return void
 */
	public function index() {
                $this->loadModel('GruposUsuario');
                // Poner condicion para que el desarrollo solo se vea para el desarrollador.
                if (!empty($this->Session->read('Desarrollador'))) {
                    $grupos = $this->GruposUsuario->find('all',array('conditions'=>array('OR'=>array('GruposUsuario.administrador_id'=>$this->Session->read('Auth.User.id'),'GruposUsuario.id IN (SELECT grupos_usuario_id FROM grupos_usuarios_users WHERE user_id = '.$this->Session->read('Auth.User.id').')'))));
                    $this->set('grupos',$grupos);
                    $this->set(
                    'desarrollos',
                        $this->Desarrollo->find(
                                'all',
                                array(
                                    'conditions'=>array(
                                        
                                        'Desarrollo.id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
                                        /*'Desarrollo.id'=>96,*/
                                    ),
                                    'recursive' => 1
                                )
                            )
                        );
                }else{

                    $grupos = $this->GruposUsuario->find('all',array('conditions'=>array('OR'=>array('GruposUsuario.administrador_id'=>$this->Session->read('Auth.User.id'),'GruposUsuario.id IN (SELECT grupos_usuario_id FROM grupos_usuarios_users WHERE user_id = '.$this->Session->read('Auth.User.id').')'))));
                    $condiciones = array('Desarrollo.is_private'=>0);
                    $ids="";
                    if (sizeof($grupos)>0){
                        foreach ($grupos as $grupo):
                            $ids += $grupo['GruposUsuario']['id'].","; 
                        endforeach;
                        array_push($condiciones, array('Desarrollo.grupos_usuario_id IN('. substr($ids, -1).')'));
                    }
                    if ($this->Session->read('Auth.User.group_id')==5){
                        return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                    }else{
                        if ($this->Session->read('Permisos.Group.id')==3){
                            $this->Desarrollo->Behaviors->load('Containable');
                            $conditions = array();
                            $restrigidos = $this->Desarrollo->find('count',array('conditions'=>array('Desarrollo.id IN (SELECT desarrollo_id FROM desarrollos_users WHERE user_id = '.$this->Session->read('Auth.User.id').')')));
                                if ($restrigidos > 0){
                                    $conditions =   'Desarrollo.id IN (SELECT desarrollo_id FROM desarrollos_users WHERE user_id = '.$this->Session->read('Auth.User.id').')';
                                }else{
                                    $conditions = array(
                                        'OR'=>array(
                                            'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                                            'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                                            
                                        ),
                                        'AND' => array(
                                            'Desarrollo.visible'=>1,
                                            'Desarrollo.is_private'=>0
                                        )
                                    );
                                }
                            $this->set(
                                    'desarrollos',
                                    $this->Desarrollo->find(
                                            'all',
                                            array(
                                                'fields'=>array(
                                                    'nombre','id','visible','tipo_desarrollo','torres','unidades_totales','fecha_entrega',
                                                    'colonia','m2_low','m2_top','rec_top','rec_low','banio_low','banio_top','est_top','est_low',
                                                    'is_private','entrega'
                                                ),
                                                'contain'=>array(
                                                    'EquipoTrabajo'=>array(
                                                        'fields'=>array(
                                                            'nombre_grupo'
                                                        )
                                                    ),
                                                    'Comercializador'=>array(
                                                        'fields'=>'nombre_comercial'
                                                    ),
                                                    'FotoDesarrollo'=>array(
                                                        'fields'=>'ruta'
                                                    ),
                                                    'Disponibles'=>array(
                                                        'fields'=>'id'
                                                    ),
                                                    'Propiedades'=>array(
                                                        'fields'=>'id'
                                                    )
                                                ),
                                                'conditions'=>$conditions
                                            )
                                        )
                                    );
                        }else if ($this->Session->read('Permisos.Group.id')<3 || $this->Session->read('Permisos.Group.id')>3){
                            $this->Desarrollo->Behaviors->load('Containable');
                            $this->set(
                                    'desarrollos',
                                    $this->Desarrollo->find(
                                            'all',
                                            array(
                                                'fields'=>array(
                                                    'nombre','id','visible','tipo_desarrollo','torres','unidades_totales','fecha_entrega',
                                                    'colonia','m2_low','m2_top','rec_top','rec_low','banio_low','banio_top','est_top','est_low',
                                                    'is_private','entrega'
                                                ),
                                                'contain'=>array(
                                                    'EquipoTrabajo'=>array(
                                                        'fields'=>array(
                                                            'nombre_grupo'
                                                        )
                                                    ),
                                                    'Comercializador'=>array(
                                                        'fields'=>'nombre_comercial'
                                                    ),
                                                    'FotoDesarrollo'=>array(
                                                        'fields'=>'ruta'
                                                    ),
                                                    'Disponibles'=>array(
                                                        'fields'=>'id'
                                                    ),
                                                    'Propiedades'=>array(
                                                        'fields'=>'id'
                                                    )
                                                ),
                                                'conditions'=>array(
                                                    'OR' => array(
                                                        'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                                                        'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                                                        ), 
                                                    'AND' => array(
                                                        'Desarrollo.is_private'=>0
                                                        )
                                                    
                                                    ),
                                                )
                                            )
                                    );
                        }else{
                            $this->Desarrollo->Behaviors->load('Containable');
                            $this->set(
                                    'desarrollos',
                                    $this->Desarrollo->find(
                                            'all',
                                            array(
                                                'fields'=>array(
                                                    'nombre','id','visible','tipo_desarrollo','torres','unidades_totales','fecha_entrega',
                                                    'colonia','m2_low','m2_top','rec_top','rec_low','banio_low','banio_top','est_top','est_low',
                                                    'is_private','entrega'
                                                ),
                                                'contain'=>array(
                                                    'EquipoTrabajo'=>array(
                                                        'fields'=>array(
                                                            'nombre_grupo'
                                                        )
                                                    ),
                                                    'Comercializador'=>array(
                                                        'fields'=>'nombre_comercial'
                                                    ),
                                                    'FotoDesarrollo'=>array(
                                                        'fields'=>'ruta'
                                                    ),
                                                    'Disponibles'=>array(
                                                        'fields'=>'id'
                                                    ),
                                                    'Propiedades'=>array(
                                                        'fields'=>'id'
                                                    )
                                                ),
                                                'conditions'=>array(
                                                    'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                                                    ),
//                                                'OR'=>array(
//                                                    'Desarrollo.id'=>76
//                                                    )
                                                )
                                            )
                                    );
                        }
                        $this->set('grupos',$grupos);
                        
                    }
                }
		
                
	}
        
        public function activar($id = null, $status = null){
            $this->Desarrollo->query("UPDATE desarrollos SET visible = $status WHERE id = $id");
            return $this->redirect(array('action' => 'index'));
        }
        
        public function status($id = null, $status = null){
            $this->Desarrollo->query("UPDATE desarrollos SET visible = $status WHERE id = ".$id);
            return $this->redirect(array('action' => 'index'));
        }
        
        public function status_2($id = null, $status = null, $id_desarrollo = null) {
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Inmueble->id = $id;
		if (!$this->Inmueble->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
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
			
		
		return $this->redirect(array('action' => 'view', $id_desarrollo));
	}
        
        public function detail_client($id = null) {
            
                $this->layout='cliente';
		if (!$this->Desarrollo->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo'));
		}
		$options = array('conditions' => array('Desarrollo.' . $this->Desarrollo->primaryKey => $id));
		$this->set('desarrollo', $this->Desarrollo->find('first', $options));
                $this->set('tipos',$this->Inmueble->find('all',array('order'=>'Inmueble.referencia','conditions'=>array('Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$id.')'))));
                $estadisticas = $this->Desarrollo->query("SELECT count(*),status FROM leads WHERE desarrollo_id = $id GROUP BY status");
                $estad = array();
                foreach($estadisticas as $estadistica):
                    array_push($estad,array($estadistica['leads']['status']=>$estadistica[0]['count(*)']));
                endforeach;
                $this->set('estadisticas',$estad);
	}
        
        public function orden($id=null){
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
            if ($this->request->is('post')){
                //echo var_dump($this->request->data['Desarrollo']['foto_inmueble']);
                $id = $this->request->data['Desarrollo']['id'];
                    
                 $i = $this->request->data['Desarrollo']['i'];
                 for ($j=1; $j<$i; $j++){
                     if ($this->request->data['Desarrollo']['eliminar'.$j]==1){
                         $id_foto=$this->request->data['Desarrollo']['id'.$j];
                         $this->Inmueble->query("DELETE FROM foto_desarrollos WHERE id = $id_foto");
                     }else{
                        $id_foto=$this->request->data['Desarrollo']['id'.$j];
                        $descripcion=$this->request->data['Desarrollo']['descripcion'.$j];
                        $orden=$this->request->data['Desarrollo']['orden'.$j];
                        $this->Inmueble->query("UPDATE foto_desarrollos SET descripcion = '".$descripcion."', orden = $orden WHERE id = $id_foto");
                     }
                 }
                $this->Session->setFlash(__('Se han ordenado exitosamente las fotografias'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'multimedia',$id));
                //echo var_dump($this->request->data['Inmueble']['foto_inmueble']);
               
                
            }else{
                $this->set('imagenes',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id),'order'=>'FotoDesarrollo.orden ASC')));
                $this->set('id',$id);
            }
        }
        
        public function multimedia($id=null){
            
            if ($this->Session->read('Permisos.Group.id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
            if ($this->request->is('post')){
                
                $id = $this->request->data['Desarrollo']['id'];
                $i = $this->request->data['Desarrollo']['i'];
                for ($j=1; $j<$i; $j++){
                    if ($this->request->data['Desarrollo']['descripcion'.$j]!="" || $this->request->data['Desarrollo']['orden'.$j]!=""){
                        $id_foto=$this->request->data['Desarrollo']['id'.$j];
                        $descripcion=$this->request->data['Desarrollo']['descripcion'.$j];
                        $orden=$this->request->data['Desarrollo']['orden'.$j];
                        $this->Inmueble->query("UPDATE foto_desarrollos SET descripcion = '".$descripcion."', orden = $orden WHERE id = $id_foto");
                    }
                 
                }
                foreach($this->request->data['Desarrollo']['foto_desarrollo'] as $unitario):
                    if ($unitario['name']!=""){
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$unitario['name'];
                        move_uploaded_file($unitario['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$unitario['name'];
                        $this->Inmueble->query("INSERT INTO foto_desarrollos VALUES (0,$id,'".$ruta."','',0)");
                    }
                endforeach;
                
                 
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'),'default',array('class'=>'mensaje_exito'));
                return $this->redirect(array('action' => 'multimedia',$id));
                //echo var_dump($this->request->data['Inmueble']['foto_inmueble']);
            }else{
                $this->set('imagenes',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id),'order'=>'FotoDesarrollo.orden ASC')));
                $this->set('id',$id);
            }
            
            
        }
        
        public function eliminar_documento($id_documento = null,$id_desarrollo =null){
            $this->loadModel('DocumentosUser');
            $this->DocumentosUser->id = $id_documento;
            $this->request->onlyAllow('post', 'delete');
		$this->DocumentosUser->delete();
		return $this->redirect(array('action' => 'anexos',$id_desarrollo));
        }

        public function eliminar_foto($id=null, $id_desarrollo = null){
            $this->FotoDesarrollo->id = $id;
		if (!$this->FotoDesarrollo->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FotoDesarrollo->delete()) {
			$this->Session->setFlash(__('The inmueble has been deleted.'));
		} else {
			$this->Session->setFlash(__('The inmueble could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'anexos',$id_desarrollo));
        }
        
        public function archivos($id=null){
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            //$this->layout= 'bos';
            if ($this->request->is('post')){
                //echo var_dump($this->request->data['Desarrollo']['foto_inmueble']);
                $id = $this->request->data['Desarrollo']['desarrollo_id'];
                $unitario = $this->request->data['Desarrollo']['foto_inmueble'];
		$filename = getcwd()."/files/desarrollos/".$id."/".$unitario['name'];
                move_uploaded_file($unitario['tmp_name'],$filename);
		$ruta = "/files/desarrollos/".$id."/".$unitario['name'];
                $this->request->data['DocumentosUser']['documento'] = $this->request->data['Desarrollo']['documento'];
                $this->request->data['DocumentosUser']['desarrollo_id'] = $this->request->data['Desarrollo']['desarrollo_id'];
                $this->request->data['DocumentosUser']['user_id'] = $this->request->data['Desarrollo']['user_id'];
                $this->request->data['DocumentosUser']['ruta'] = $ruta;
                $this->request->data['DocumentosUser']['asesor'] = $this->request->data['Desarrollo']['asesor'];
                $this->request->data['DocumentosUser']['desarrollador'] = $this->request->data['Desarrollo']['desarrollador'];
                $this->DocumentosUser->create();
                $this->DocumentosUser->save($this->request->data);
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'view',$id));
                //echo var_dump($this->request->data['Inmueble']['foto_inmueble']);
                
               
                
            }else{
                $this->set('id',$id);
            }
        }
        
        public function upload(){
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
            if ($this->request->is('post')){
                $id = $this->request->data['Desarrollo']['id'];
                foreach($this->request->data['Desarrollo']['archivo'] as $unitario):
                    $filename = getcwd()."/files/desarrollos/".$id."/".$unitario['name'];
                    move_uploaded_file($unitario['tmp_name'],$filename);
                endforeach;
                $this->Session->setFlash(__('Los archivos se han cargado exitosamente'));
                return $this->redirect(array('action' => 'view',$id));    
            }
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
        
        public function imprimir($id=null,$user_id = null){
            $this->set('agente',$this->User->read(null,$user_id));
            $this->set('desarrollo',$this->Desarrollo->read(null,$id));
            $params = array(
                'download' => false,
                'name' => 'example.pdf',
                'paperOrientation' => 'portrait',
                'paperSize' => 'letter',
                
            );
        }
        
        public function view($id = null) {
        
            $this->Desarrollo->Behaviors->load('Containable');
            $desarrollo = $this->Desarrollo->find(
                'first', 
                array(
                    'fields'=>array(
                        'id','nombre','referencia','cuenta_id','calle','numero_ext','numero_int','fecha_exclusiva',
                        'colonia','cp','estado','ciudad','logotipo','m2_low','m2_top','rec_low',
                        'rec_top','banio_low','banio_top','est_low','est_top','brochure','youtube',
                        'matterport','is_private','tipo_desarrollo','etapa_desarrollo','torres','unidades_totales',
                        'entrega','fecha_entrega','exclusividad','fecha_inicio_exclusiva','comision',
                        'compartir','porcentaje_compartir','departamento_muestra','horario_contacto',
                        'descripcion','cc_cercanos','escuelas','frente_parque','parque_cercano','plazas_comerciales',
                        'alberca_sin_techar','alberca_techada','sala_cine','juegos_infantiles','fumadores','areas_verdes',
                        'asador','cafeteria','golf','paddle_tennis','squash','tennis','carril_nado',
                        'fire_pit','gimnasio','jacuzzi','living','lobby','boliche','pista_jogging','play_room','restaurante',
                        'roof_garden_compartido','salon_juegos','salon_usos_multiples','sauna','spa_vapor','sky_garden',
                        'acceso_discapacitados','internet','tercera_edad','aire_acondicionado','business_center','calefaccion',
                        'cctv','cisterna','conmutador','edificio_inteligente','edificio_leed','elevadores','estacionamiento_visitas',
                        'gas_lp','gas_natural','lavanderia','locales_comerciales','mascotas','planta_emergencia','porton_electrico',
                        'sistema_contra_incendios','sistema_seguridad','valet_parking','vapor','seguridad','google_maps','fecha_alta','m_cisterna','q_elevadores'
                    ),
                    'contain'=>array(
                        'FotoDesarrollo'=>array(
                            'fields'=>array(
                                'ruta','descripcion'
                            )
                        ),
                        'DocumentosUser'=>array(
                            'fields'=>array(
                                'documento','ruta'
                            )
                        ),
                        'Planos'=>array(
                            'fields'=>array(
                                'descripcion','ruta'
                            )
                        ),
                        'EquipoTrabajo'=>array(
                            'fields'=>array(
                                'administrador_id','nombre_grupo','id',
                            )
                        ),
                        'Comercializador'=>array(
                            'fields'=>array(
                                'nombre_comercial'
                            )
                        ),
                        'Disponibles'=>array(
                            'fields'=>array(
                                'id'
                            )
                        ),
                        'Propiedades'=>array(
                            'fields'=>array(
                                'referencia','liberada','id','titulo','venta_renta',
                                'precio','precio_2','construccion','construccion_no_habitable','recamaras',
                                'banos','medio_banos','estacionamiento_techado','estacionamiento_descubierto',
    
                            )
                        ),
                        'Interesados'=>array(
                            'fields'=>array(
                                'user_id','temperatura','nombre','id','dic_linea_contacto_id','correo_electronico',
                                'telefono1','status','created','comentarios'
                            )
                        ),
                        'Facturas'=>array(
                            'fields'=>array(
                                'folio','referencia','fecha_emision','concepto','subtotal','iva','total','estado','categoria_id',
                                'id'
                            )
                        ),
                        'Log'=>array(
                            'fields'=>array(
                                'accion','usuario_id','fecha','mensaje'
                            )
                        ),
                        'Publicidad'=>array(
                            'fields'=>array(
                                'fecha_inicio','nombre','objetivo','dic_linea_contacto_id','inversion_prevista'
                            )
                        ),
                        'ObjetivoAplicable'=>array(
                            'fields'=>array(
                                'monto'
                            )
                        ),
                        'Cerrador'=>array(
                            'fields'=>array(
                                'nombre_completo'
                            )
                        ),
                    ),
                    'conditions'=>array(
                        'Desarrollo.id'=>$id
                    )
                )
            );
            $this->set(compact('desarrollo'));
            $this->set('desarrollo_id',$id);
    
            //Buscamos Eventos
    
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
            $this->set('return', 4);
            $this->set('param_return', $id);
    
            $this->loadModel('Event');
            $this->Event->Behaviors->load('Containable');
            $eventos = $this->Event->find('all',
            array(
                'fields'=>array(
                    'tipo_tarea','status','fecha_inicio','id'
                ),
                'contain'=>array(
                    'Cliente'=>array(
                        'fields'=>'nombre','id'
                    ),
                    'User'=>array(
                        'fields'=>array(
                            'id','nombre_completo'
                        )
                    ),
                ),
                'conditions' => array(
                    'Event.status'      => 1,
                    'Event.tipo_evento' => 1,
                    'Event.cuenta_id'   => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                    'Event.fecha_inicio >= CURDATE()',
                    'Event.fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)',
                    'Event.desarrollo_id' => $id
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
            $nombre_ubicacion = strtoupper($desarrollo['Desarrollo']['nombre']);
            $url_ubicacion    = '../desarrollos/view/'.$desarrollo['Desarrollo']['id'];
    
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
    
            //Cargamos todas las variables adicionales
            $this->set('usuarios',$this->User->find('list',array('conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->Session->read('CuentaUsuario.Cuenta.id').')'))));
            $this->set('proveedores', $this->Proveedor->find('list',array('conditions'=>array('Proveedor.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id')))));
            $this->set('lineas_contactos',$this->DicLineaContacto->find('list',array('conditions'=>array('DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
            $this->set('mails',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id'=>$id,'LogDesarrollo.accion'=>5))));
            $this->set('citas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id'=>$id,'LogDesarrollo.accion'=>6))));
            $this->set('visitas',$this->Event->find('count',array('conditions'=>array("Event.desarrollo_id" =>$id,'Event.tipo_tarea'=> 1))));
            $this->set('contactos_count', $this->Cliente->find('count', array('conditions'=>array('Cliente.desarrollo_id'=>$id, 'Cliente.user_id <>'=>''), 'recursive'=>-1, 'fields'=>array('Cliente.dic_linea_contacto_id'))));
            $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id'=>$id))));
    
            $fi = $desarrollo['Desarrollo']['fecha_alta'];
            $ff  = date('Y-m-d');
            $mes_inicio = date('Y-m-01');
            $mes_final  = date('Y-m-t');
            $periodo_tiempo = 'INFORMACIÓN DEL '.date('d-m-Y', strtotime($fi)).' AL '.date('d-m-Y', strtotime($ff));
            $this->set(compact('periodo_tiempo')); 
            
            $periodo_tiempo_mes =  $periodo_tiempo = 'INFORMACIÓN DEL '.date('01-m-Y', strtotime($fi)).' AL '.date('d-m-Y', strtotime($ff));
            $this->set(compact('periodo_tiempo_mes'));
    
            //Comienzan las gráficas del desarrollo
            /************************************************* Grafica de clientes con linea de contacto (Mes) ********************************************************************/
            $clientes_lineas_mes = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.desarrollo_id = $id AND user_id IS NOT NULL AND clientes.created >= '$mes_inicio' AND clientes.created <= '$mes_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
            $total_clientes_lineas_mes = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.desarrollo_id = $id AND user_id IS NOT NULL AND clientes.created >= '$mes_inicio' AND clientes.created <= '$mes_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
            $this->set(compact('clientes_lineas_mes'));
            $this->set(compact('total_clientes_lineas_mes'));
    
            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id AND clientes.desarrollo_id = $id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.desarrollo_id = $id AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' AND ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id) GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
            $ventas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
    
            $this->set(compact('clientes_lineas'));
            $this->set(compact('total_clientes_lineas'));
            $this->set(compact('venta_linea_contacto'));
            $this->set(compact('ventas_linea_contacto_arreglo'));
    
            /************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
            $query = "SELECT 
            COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
            IFNULL((SELECT unidades FROM objetivos_ventas_desarrollos WHERE fecha < periodo AND fin > periodo AND desarrollo_id = $id),1) AS objetivo_ventas
                FROM 
                    ventas
                WHERE 
                    ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id) 
                GROUP BY periodo
                ORDER BY periodo";
                
            $ventas_vs_metas = $this->Desarrollo->query($query);
    
            // Variables de ventas vs metas por mes.
            $this->set(compact('ventas_vs_metas'));
    
            // Variable para generar cada mes independiente de si hay ventas o no
            $ventas_mensuales = array();
            $mes_inicial = date("Y-m",strtotime('-1 year'));
            for($i=0;$i<13;$i++){
                $ventas_mensuales[$i]['periodo_tiempo'] = $mes_inicial;
                for($j=0; $j<sizeof($ventas_vs_metas); $j++){
                    if ($j>0){        
                        if ($mes_inicial == $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = $ventas_vs_metas[$j][0]['venta_mes'];
                        }
                        else if ($mes_inicial > $ventas_vs_metas[$j-1][0]['periodo'] && $mes_inicial < $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j-1][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = 0;    
                        }
                        else if ($mes_inicial > $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = 0;   
                        }
                    }
                }
                $mes_inicial = date("Y-m",strtotime($mes_inicial."+1 month"));            
            }
            $this->set(compact('ventas_mensuales'));
    
            /************************************************* Grafica de visitas con linea de contacto (Acumulado) *****************************************************************/
                //$clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
    
                //$total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
    
                $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE tipo_tarea = 1 AND events.desarrollo_id = $id AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

                //Para el acumulado de inversión
                $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
                $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);
    
    
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
                
                $this->set(compact('visitas_linea_contacto_arreglo'));
    
                /************************************************* Ventas por Asesor Acumulados ********************************************************************/
                $q_ventas_asesor = $this->Desarrollo->query(
                        "SELECT 
                            COUNT(ventas.precio_cerrado) AS ventas_q, users.nombre_completo AS asesor
                         FROM 
                            ventas,clientes,users 
                         WHERE  
                            fecha >= '".$fi."' AND
                            fecha <= '".$ff."' AND 
                            ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id) AND
                            ventas.cliente_id = clientes.id AND
                            clientes.user_id = users.id
                        GROUP BY asesor;"
                        );
                
                $v_ventas_asesor = $this->Desarrollo->query(
                        "SELECT 
                            SUM(ventas.precio_cerrado) AS ventas_v, users.nombre_completo AS asesor
                         FROM 
                            ventas,clientes,users 
                         WHERE  
                            fecha >= '".$fi."' AND
                            fecha <= '".$ff."' AND 
                            ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id) AND
                            ventas.cliente_id = clientes.id AND
                            clientes.user_id = users.id
                        GROUP BY asesor;"
                        );
                
                $ventas_asesores_arreglo = array();
                $i=0;
                foreach($q_ventas_asesor as $q_venta):
                    $ventas_asesores_arreglo[$i]['venta_q'] = $q_venta[0]['ventas_q'];
                    $ventas_asesores_arreglo[$i]['asesor'] = $q_venta['users']['asesor'];
                    $ventas_asesores_arreglo[$i]['venta_v'] = 0;
                    foreach($v_ventas_asesor as $venta):
                        if ($venta['users']['asesor']==$q_venta['users']['asesor']){
                            $ventas_asesores_arreglo[$i]['venta_v'] = $venta[0]['ventas_v'];
                        }
                    endforeach;
                    $i++;
                endforeach;
    
                $this->set(compact(array('q_ventas_asesor','v_ventas_asesor','ventas_asesores_arreglo')));
    
                /************************************************* Histórico en publicidad por medio*************************************************************/
                $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
                $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);
    
                //echo $q_inversion_publicidad;
                
                $this->set(compact('inversion_publicidad'));
            
            
        }
                
public function detalle($id = null,$id_agente = null) {
    $this->layout = 'freebos';
	if (!$this->Desarrollo->exists($id)) {
		throw new NotFoundException(__('Invalid inmueble'));
	}
    
	$this->set('desarrollo', $this->Desarrollo->read(null, $id));
    $this->set('agente', $this->User->read(null, $id_agente));
    $this->set('disponibles',$this->Desarrollo->query("SELECT COUNT(*) as disponibles FROM inmuebles WHERE liberada = 1 AND id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id)"));
    $this->set('fotos',$this->FotoDesarrollo->find('all',array('conditions'=>array('FotoDesarrollo.desarrollo_id'=>$id,'FotoDesarrollo.tipo_archivo'=>1))));
    $this->set('planos',$this->FotoDesarrollo->find('all',array('conditions'=>array('FotoDesarrollo.desarrollo_id'=>$id,'FotoDesarrollo.tipo_archivo'=>2))));
    $this->set('tipos',$this->Inmueble->find('all',array('order'=>'Inmueble.referencia','conditions'=>array('Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$id.')'))));
    
    //                $params = array(
    //                    'download' => false,
    //                    'name' => "propiedad".$id,
    //                    'paperOrientation' => 'portrait',
    //                    'paperSize' => 'letter'
    //                );
    //                $this->set($params);
                
}

/**
 * add method
 *
 * @return void
 */
        
	public function add_bak() {
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout='bos';
		if ($this->request->is('post')) {
			$this->Desarrollo->create();
			
                        $this->request->data['Desarrollo']['nombre']= $this->request->data['nombre'];
                        $this->request->data['Desarrollo']['calle']= $this->request->data['calle'];
                        $this->request->data['Desarrollo']['numero_ext']= $this->request->data['numero_ext'];
                        $this->request->data['Desarrollo']['colonia']= $this->request->data['colonia'];
                        $this->request->data['Desarrollo']['delegacion']= $this->request->data['delegacion'];
                        $this->request->data['Desarrollo']['ciudad']= $this->request->data['ciudad'];
                        $this->request->data['Desarrollo']['cp']= $this->request->data['cp'];
                        $this->request->data['Desarrollo']['estado']= $this->request->data['estado'];
                        $this->request->data['Desarrollo']['fecha_alta']=date('Y-m-d');
			if ($this->Desarrollo->save($this->request->data)) {
				$id = $this->Desarrollo->getInsertID();
                                
                                $this->request->data['LogDesarrollo']['desarrollo_id'] = $id;
                                $this->request->data['LogDesarrollo']['mensaje'] = "Creación de Desarrollo";
                                $this->request->data['LogDesarrollo']['usuario_id'] = $this->Session->read('Auth.User.id');
                                $this->request->data['LogDesarrollo']['fecha'] = date('Y-m-d');
                                $this->request->data['LogDesarrollo']['accion'] = 1;
                                $this->LogDesarrollo->create();
                                $this->LogDesarrollo->save($this->request->data);
				
				
                                mkdir(getcwd()."/img/desarrollos/".$id,0777);
                                mkdir(getcwd()."/files/desarrollos/".$id,0777);
			
				foreach($this->request->data['Desarrollo']['fotos'] as $unitario):
					$filename = getcwd()."/img/desarrollos/".$id."/".$unitario['name'];
					move_uploaded_file($unitario['tmp_name'],$filename);
                                        $ruta = "/img/desarrollos/".$id."/".$unitario['name'];
					$this->Inmueble->query("INSERT INTO foto_desarrollos VALUES (0,$id,'".$ruta."','',0)");
                                        
                                        // Comentador por SaaK, no funciona en php7
                                        /*
                                        ImageTool::resize(array(
                                            'input' => $filename,
                                            'output'=>$filename,
                                            'width' => 800,
                                            'keepRatio' => true,
                                            
                                        )); */
                                        
                                        
				endforeach;
                                
                                $de = 1;
                                $para = $this->User->find('all');
                                foreach ($para as $persona):
                                    $for = $persona['User']['id'];
                                    $this->Inmueble->query("INSERT INTO notificaciones VALUES(0,$de,$for,'Se ha agregado un nuevo desarrollo',0,'/desarrollos/view/".$id."')");
                                endforeach;
                                
                                
                                $this->Session->write('notificaciones',$this->Inmueble->query("SELECT * FROM notificaciones WHERE leido = 0 AND para = ".$this->Session->read('Auth.User.id')));
				$this->Session->setFlash(__('The desarrollo has been saved.'));
				return $this->redirect(array('controller'=>'inmuebles','action' => 'add_unidades',$id));
                               
			} else {
				$this->Session->setFlash(__('The desarrollo could not be saved. Please, try again.'));
			}
			//echo var_dump($this->request->data['Desarrollo']['foto_desarrollo']);
		}
	}
        
        public function add() {
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout='bos';
		if ($this->request->is('post')) {
			$this->Desarrollo->create();
                $this->request->data['Desarrollo']['nombre']                 = $this->request->data['nombre'];
                $this->request->data['Desarrollo']['referencia']             = $this->request->data['referencia'];
                $this->request->data['Desarrollo']['tipo_inmuebles']         = $this->request->data['tipo_inmuebles'];
                $this->request->data['Desarrollo']['tipo_desarrollo']        = $this->request->data['tipo'];
                $this->request->data['Desarrollo']['etapa_desarrollo']       = $this->request->data['etapa_desarrollo'];
                $this->request->data['Desarrollo']['calle']                  = $this->request->data['calle'];
                $this->request->data['Desarrollo']['numero_ext']             = $this->request->data['numero_ext'];
                $this->request->data['Desarrollo']['colonia']                = $this->request->data['colonia'];
                $this->request->data['Desarrollo']['delegacion']             = $this->request->data['delegacion'];
                $this->request->data['Desarrollo']['ciudad']                 = $this->request->data['ciudad'];
                $this->request->data['Desarrollo']['cp']                     = $this->request->data['cp'];
                $this->request->data['Desarrollo']['estado']                 = $this->request->data['estado'];
                $this->request->data['Desarrollo']['fecha_alta']             = date('Y-m-d');
                $this->request->data['Desarrollo']['inicio_preventa']        = date('Y-m-d', strtotime($this->request->data['Desarrollo']['inicio_preventa']));
                $this->request->data['Desarrollo']['fecha_entrega']          = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_entrega']));
                $this->request->data['Desarrollo']['fecha_inicio_exclusiva'] = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_inicio_exclusiva']));
                $this->request->data['Desarrollo']['fecha_exclusiva']        = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_exclusiva']));
                $this->request->data['Desarrollo']['visible']                = 0;
                $this->request->data['Desarrollo']['is_private']             = 0;
                $this->request->data['Desarrollo']['meta_mensual']           = $this->request->data['meta_mensual'];
			if ($this->Desarrollo->save($this->request->data)) {
                                
				$id = $this->Desarrollo->getInsertID();
                                mkdir(getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id,0777);
                                
                                $this->request->data['LogDesarrollo']['desarrollo_id'] = $id;
                                $this->request->data['LogDesarrollo']['mensaje'] = "Creación de Desarrollo";
                                $this->request->data['LogDesarrollo']['usuario_id'] = $this->Session->read('Auth.User.id');
                                $this->request->data['LogDesarrollo']['fecha'] = date('Y-m-d');
                                $this->request->data['LogDesarrollo']['accion'] = 1;
                                $this->LogDesarrollo->create();
                                $this->LogDesarrollo->save($this->request->data);
				
				
                                
			
				
                                $this->Session->setFlash(__('The desarrollo has been saved.'));
                                if ($this->request->data['Desarrollo']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('controller'=>'desarrollos','action' => 'amenidades',$id));
                                }
				
                               
			} else {
				$this->Session->setFlash(__('The desarrollo could not be saved. Please, try again.'));
			}
			//echo var_dump($this->request->data['Desarrollo']['foto_desarrollo']);
		}
	}
        
        
	public function edit_generales($id = null){
            if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout='bos';
		if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Desarrollo']['nombre']                 = $this->request->data['nombre'];
            $this->request->data['Desarrollo']['referencia']             = $this->request->data['referencia'];
            $this->request->data['Desarrollo']['tipo_inmuebles']         = $this->request->data['tipo_inmuebles'];
            $this->request->data['Desarrollo']['tipo_desarrollo']        = $this->request->data['tipo'];
            $this->request->data['Desarrollo']['calle']                  = $this->request->data['calle'];
            $this->request->data['Desarrollo']['numero_ext']             = $this->request->data['numero_ext'];
            $this->request->data['Desarrollo']['colonia']                = $this->request->data['colonia'];
            $this->request->data['Desarrollo']['delegacion']             = $this->request->data['delegacion'];
            $this->request->data['Desarrollo']['ciudad']                 = $this->request->data['ciudad'];
            $this->request->data['Desarrollo']['cp']                     = $this->request->data['cp'];
            $this->request->data['Desarrollo']['estado']                 = $this->request->data['estado'];
            $this->request->data['Desarrollo']['etapa_desarrollo']       = $this->request->data['etapa_desarrollo'];
            $this->request->data['Desarrollo']['meta_mensual']           = $this->request->data['meta_mensual'];
            $this->request->data['Desarrollo']['inicio_preventa']        = date('Y-m-d', strtotime($this->request->data['Desarrollo']['inicio_preventa']));
            $this->request->data['Desarrollo']['fecha_inicio_exclusiva'] = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_inicio_exclusiva']));
            $this->request->data['Desarrollo']['fecha_entrega']          = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_entrega']));
            $this->request->data['Desarrollo']['fecha_exclusiva']        = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_exclusiva']));
			$this->Desarrollo->create();
            $this->Desarrollo->save($this->request->data);
			$id = $this->request->data['Desarrollo']['id'];
                            
            $this->request->data['LogDesarrollo']['desarrollo_id'] = $id;
            $this->request->data['LogDesarrollo']['mensaje']       = "Modificación de Desarrollo";
            $this->request->data['LogDesarrollo']['usuario_id']    = $this->Session->read('Auth.User.id');
            $this->request->data['LogDesarrollo']['fecha']         = date('Y-m-d');
            $this->request->data['LogDesarrollo']['accion']        = 2;
            $this->LogDesarrollo->create();
            $this->LogDesarrollo->save($this->request->data);
				
				$this->Session->setFlash(__('The desarrollo has been saved.'));
                                if ($this->request->data['Desarrollo']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('controller'=>'desarrollos','action' => 'amenidades',$id));
                                }
				
			//echo var_dump($this->request->data['Desarrollo']['foto_desarrollo']);
		}
        $this->Desarrollo->Behaviors->load('Containable');
        $options = array(
            'fields'=>array(
                'id','etapa_desarrollo','inicio_preventa','entrega','fecha_entrega',
                'exclusividad','fecha_inicio_exclusiva','fecha_exclusiva','comision',
                'compartir','porcentaje_compartir','descripcion','cuenta_id','referencia',
                'nombre','tipo_desarrollo','tipo_inmuebles','meta_mensual','etapa_desarrollo',
                'niveles_desarrollo','unidades_totales','torres','disponibilidad','departamento_muestra',
                'horario_contacto','calle','numero_ext','colonia','delegacion','cp','ciudad','estado','entre_calles','google_maps',
                'cerrador_id','departamento_muestra'
            ),
            'contain'=>false,
            'conditions' => array(
                'Desarrollo.' . $this->Desarrollo->primaryKey => $id
            ),
        );
        $desarrollo = $this->Desarrollo->find('first', $options);
        $this->request->data = $desarrollo;
        $this->set('desarrollo', $desarrollo);

        $this->loadModel('User');
            $this->set('cerradores',$this->User->find('list',array('conditions'=>array('id IN (SELECT user_id FROM cuentas_users WHERE cerrador = 1 AND cuenta_id = '.$desarrollo['Desarrollo']['cuenta_id'].')'))));
        }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		//$this->layout='bos';
		if (!$this->Desarrollo->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo'));
		}
		if ($this->request->is(array('post', 'put'))) {
                        $this->request->data['Desarrollo']['nombre']= $this->request->data['nombre'];
                        $this->request->data['Desarrollo']['calle']= $this->request->data['calle'];
                        $this->request->data['Desarrollo']['numero_ext']= $this->request->data['numero_ext'];
                        $this->request->data['Desarrollo']['colonia']= $this->request->data['colonia'];
                        $this->request->data['Desarrollo']['delegacion']= $this->request->data['delegacion'];
                        $this->request->data['Desarrollo']['ciudad']= $this->request->data['ciudad'];
                        $this->request->data['Desarrollo']['cp']= $this->request->data['cp'];
                        $this->request->data['Desarrollo']['estado']= $this->request->data['estado'];
                        $this->request->data['Desarrollo']['fecha_alta']=date('Y-m-d');
                        $this->request->data['Desarrollo']['inicio_preventa'] = date('Y-m-d', strtotime($this->request->data['Desarrollo']['inicio_preventa']));
                        $this->request->data['Desarrollo']['fecha_entrega'] = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_entrega']));
			if ($this->Desarrollo->save($this->request->data)) {
                                
				$this->Session->setFlash(__('The inmueble has been saved.'));
				return $this->redirect(array('action' => 'view',$id));
				
			} else {
				$this->Session->setFlash(__('The desarrollo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Desarrollo.' . $this->Desarrollo->primaryKey => $id));
			$desarrollo = $this->Desarrollo->find('first', $options);
                        $this->request->data = $desarrollo;
                        $this->set('desarrollo', $desarrollo);
		}
	}
        
        public function amenidades($id = null) {
                if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		if (!$this->Desarrollo->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo'));
		}
		if ($this->request->is(array('post', 'put'))) {
                        if ($this->Desarrollo->save($this->request->data)) {
                                
				$this->Session->setFlash(__('The inmueble has been saved.'));
                                if ($this->request->data['Desarrollo']['return'] == 1){
                                    return $this->redirect(array('action' => 'view',$id));
                                }else{
                                    return $this->redirect(array('action' => 'anexos',$id));
                                }
				
				
			} else {
				$this->Session->setFlash(__('The desarrollo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Desarrollo.' . $this->Desarrollo->primaryKey => $id));
			$desarrollo = $this->Desarrollo->find('first', $options);
                        $this->request->data = $desarrollo;
                        $this->set('desarrollo',$desarrollo);        
		}
	}
        public function edit_amenidades($id = null) {
                if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		if (!$this->Desarrollo->exists($id)) {
			throw new NotFoundException(__('Invalid desarrollo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Desarrollo->save($this->request->data)) {
                                
				$this->Session->setFlash(__('The inmueble has been saved.'));
				return $this->redirect(array('action' => 'anexos',$id));
				
			} else {
				$this->Session->setFlash(__('The desarrollo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Desarrollo.' . $this->Desarrollo->primaryKey => $id));
			$this->request->data = $this->Desarrollo->find('first', $options);
		}
	}
        
        public function anexos($id = null) {
            if ($this->Session->read('Auth.User.group_id')==5){
                return $this->redirect(array('action' => 'mysession','controller'=>'users'));
            }
		$desarrollo = $this->Desarrollo->read(null,$id);
    		if (!$this->Desarrollo->exists($id)) {
    			throw new NotFoundException(__('Invalid desarrollo'));
    		}
		if ($this->request->is(array('post', 'put'))) {
                    $brochure = $this->request->data['Desarrollo']['brochure'];
                    if ($desarrollo['Desarrollo']['brochure']==""){
                        $this->request->data['Desarrollo']['brochure']="";
                    }else{
                        $this->request->data['Desarrollo']['brochure']=$desarrollo['Desarrollo']['brochure'];
                    }
                    $this->Desarrollo->save($this->request->data);

                    if (isset($this->request->data['fotos'])) {
                        foreach ($this->request->data['fotos'] as $fotos) {
                            // Localizar las que se tienen que eliminar
                            if (isset($fotos['eliminar'])) {
                                $this->FotoDesarrollo->delete($fotos['id']);
                            }else{
                                $this->request->data['FotoDesarrollo']['id']          = $fotos['id'];
                                $this->request->data['FotoDesarrollo']['descripcion'] = $fotos['descripcion'];
                                $this->request->data['FotoDesarrollo']['orden']       = $fotos['orden'];
                                $this->FotoDesarrollo->save($this->request->data);
                            }
                        }
                    }

                    // Planos
                    if (isset($this->request->data['fotos2'])) {
                        foreach ($this->request->data['fotos2'] as $fotos2) {
                            // Localizar las que se tienen que eliminar
                            if (isset($fotos2['eliminar'])) {
                                $this->FotoDesarrollo->delete($fotos2['id']);
                            }else{
                                $this->request->data['FotoDesarrollo']['id']          = $fotos2['id'];
                                $this->request->data['FotoDesarrollo']['descripcion'] = $fotos2['descripcion'];
                                $this->request->data['FotoDesarrollo']['orden']       = $fotos2['orden'];
                                $this->FotoDesarrollo->save($this->request->data);
                            }
                        }
                    }
                    
                    /*for($i=1;$i<$this->request->data['Desarrollo']['i'];$i++){
                        $this->request->data['FotoDesarrollo']['id']            = $this->request->data['Desarrollo']['foto_id'.$i];
                        $this->request->data['FotoDesarrollo']['descripcion']   = $this->request->data['Desarrollo']['descripcion'.$i];
                        $this->request->data['FotoDesarrollo']['orden']         = $this->request->data['Desarrollo']['orden'.$i];
                        $this->FotoDesarrollo->save($this->request->data);
                    }*/
                    
                    // Subir imagenes del desarrollo
                $id = $this->request->data['Desarrollo']['id'];
                if ($this->request->data['Desarrollo']['fotos'][0]['name']!="") {
                    foreach ($this->request->data['Desarrollo']['fotos'] as $fotos) {
                        
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                        move_uploaded_file($fotos['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                        $this->Inmueble->query("INSERT INTO foto_desarrollos VALUES (0,$id,'".$ruta."','',0, '1')");
//                            ImageTool::resize(array(
//                                'input' => $filename,
//                                'output'=>$filename,
//                                'width' => 800,
//                                'keepRatio' => true,
//                        ));                         
                    }
                }
                
                if ($this->request->data['Desarrollo']['planos_comerciales'][0]['name']!="") {
                    foreach ($this->request->data['Desarrollo']['planos_comerciales'] as $fotos) {
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                        move_uploaded_file($fotos['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                        $this->Inmueble->query("INSERT INTO foto_desarrollos VALUES (0,$id,'".$ruta."','',0, '2')");
//                            ImageTool::resize(array(
//                                'input' => $filename,
//                                'output'=>$filename,
//                                'width' => 800,
//                                'keepRatio' => true
//                        )); 
                    }
                }

            //Subir Documentos
            if ($this->request->data['Desarrollo']['planos'][0]['name']!="") {
                $user_id = $this->Session->read('Auth.User.id');
                foreach ($this->request->data['Desarrollo']['planos'] as $documentos) {
                    $id_registro = uniqid();
                    $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$documentos['name'];
                    move_uploaded_file($documentos['tmp_name'],$filename);
                    $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$documentos['name'];
                    $nombre = $documentos['name'];
                    $this->Inmueble->query("INSERT INTO documentos_users VALUES ('$id_registro',$user_id,'$nombre','$ruta','',$id,1,1,0)");
                }
            }
            //Subir Brochure
            if ($brochure["name"]) {
                $user_id = $this->Session->read('Auth.User.id');
                $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$brochure['name'];
                move_uploaded_file($brochure['tmp_name'],$filename);
                $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$brochure['name'];
                $this->Inmueble->query("UPDATE desarrollos SET brochure = '$ruta' WHERE id  = $id");
                
            }

            //Subir Brochure
            //print_r($this->request->data['Desarrollo']['logo']);
            if ($this->request->data['Desarrollo']['logo']['name'] != "") {
                $user_id = $this->Session->read('Auth.User.id');
                $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$this->request->data['Desarrollo']['logo']['name'];
                move_uploaded_file($this->request->data['Desarrollo']['logo']['tmp_name'],$filename);
                $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$this->request->data['Desarrollo']['logo']['name'];
                $this->Inmueble->query("UPDATE desarrollos SET logotipo = '$ruta' WHERE id  = $id");
                
            }
            
            
            $this->set('imagenes',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id),'order'=>array('FotoDesarrollo.tipo_archivo'=>'ASC', 'FotoDesarrollo.orden'=>'ASC'))));

            $this->Session->setFlash(__('The desarrollo has been saved.'));
            if($this->request->data['Desarrollo']['return']==1){
                return $this->redirect(array('controller'=>'desarrollos','action' => 'view',$id));
            }else{
                return $this->redirect(array('controller'=>'desarrollos','action' => 'anexos',$id));
            }
                    
//                    echo var_dump($this->request->data['Desarrollo']);
			
		} else {
                    $options = array('conditions' => array('Desarrollo.' . $this->Desarrollo->primaryKey => $id));
                    $desarrollo = $this->Desarrollo->find('first', $options);
                    $this->request->data = $desarrollo;
                    $this->set('desarrollo',$desarrollo);
                    $this->set('imagenes',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id,'FotoDesarrollo.tipo_archivo'=>1),'order'=>array('FotoDesarrollo.tipo_archivo'=>'ASC', 'FotoDesarrollo.orden'=>'ASC'))));
                    $this->set('planos',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id,'FotoDesarrollo.tipo_archivo'=>2),'order'=>array('FotoDesarrollo.tipo_archivo'=>'ASC', 'FotoDesarrollo.orden'=>'ASC'))));
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
		$this->Desarrollo->id = $id;
		if (!$this->Desarrollo->exists()) {
			throw new NotFoundException(__('Invalid desarrollo'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Desarrollo->delete()) {
			$this->Session->setFlash(__('The desarrollo has been deleted.'));
		} else {
			$this->Session->setFlash(__('The desarrollo could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function destacar($id = null) {
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Desarrollo->id = $id;
		if (!$this->Desarrollo->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Desarrollo->query("UPDATE desarrollos SET destacado = 1 WHERE id = ".$id);
		
			$this->Session->setFlash(__('El desarrollo ha quedado como destacado'),'default',array('class'=>'success'));
		
		return $this->redirect(array('action' => 'index'));
	}
        
        public function visible($id = null, $status=null) {
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Desarrollo->id = $id;
		if (!$this->Desarrollo->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Desarrollo->query("UPDATE desarrollos SET visible = $status WHERE id = ".$id);
		
			$this->Session->setFlash(__('El desarrollo ha cambiado de estado'),'default',array('class'=>'success'));
		
		return $this->redirect(array('action' => 'index'));
	}
        
        public function undestacar($id = null) {
            
             if ($this->Session->read('Auth.User.group_id')==5){
                    return $this->redirect(array('action' => 'mysession','controller'=>'users'));
                }
		$this->Desarrollo->id = $id;
		if (!$this->Desarrollo->exists()) {
			throw new NotFoundException(__('Invalid inmueble'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Desarrollo->query("UPDATE desarrollos SET destacado = 0 WHERE id = ".$id);
		
			$this->Session->setFlash(__('El Desarrollo ya no está destacado'),'default',array('class'=>'success'));
		
		return $this->redirect(array('action' => 'index'));
	}
        
        public function solicitar_cambios($id = null){
            
            $this->Email = new CakeEmail();
            $this->Email->from(array('no_reply@bosinmobiliaria' => 'Solicitud da cambios o sugerencias en ficha de desarrollo'));
            $this->Email->to('desarrollos@bosinmobiliaria.com.mx');
            $this->Email->subject('Solicitud de cambios o sugerencias de desarrollo');
            $this->Email->emailFormat('html');
            $this->Email->send($this->request->data['Desarrollo']['mensaje']."<br>"
                    . "Detalle de inmueble: <a href='http://bosinmobiliaria.com/sistema/desarrollos/view/".$id."'>Ver ficha</a>");
            $this->Session->setFlash(__('Los comentarios han sido enviados'),'default',array('class'=>'success'));
            return $this->redirect(array('action' => 'detail_client',$id));
        }
        
        /*
         * Comienzan los procesos de NH
         */
        
        public function configurar($id = null) {
            $this->loadModel('Categoria');
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['Categoria']['desarrollo_id'] = $this->request->data['Desarrollo']['id'];
                $this->request->data['Categoria']['nombre'] = $this->request->data['Desarrollo']['categoria'];
                $this->Categoria->create();
                $this->Categoria->save($this->request->data);
                $this->Session->setFlash(__('La cateogría ha sido registrada exitosamente.'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'configurar',$this->request->data['Desarrollo']['id']));
            }else{
                $this->set('desarrollo',$this->Desarrollo->read(null,$id));
            }
	}


    /*************************************
    *
    *   Agregar documentos del desarrollo
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


    public function update_gallery($desarrollo_id = null){
        if ($this->request->is(array('post', 'put'))) {
            foreach ($this->request->data['Desarrollo']['fotos'] as $foto) {
                $this->request->data['FotoDesarrollo']['id']            = $foto['id'];
                $this->request->data['FotoDesarrollo']['descripcion']   = $foto['descripcion'];
                $this->request->data['FotoDesarrollo']['orden']         = $foto['orden'];
                $this->request->data['FotoDesarrollo']['tipo_archivo']  = $foto['tipo_archivo'];
                $this->FotoDesarrollo->save($this->request->data);
            }
            $this->Session->setFlash(__('The desarrollo has been saved.'));
            return $this->redirect(array('action' => 'anexos',$desarrollo_id));
                

        }
    }
    
    public function log_desarrollo($id_desarrollo=null, $tipo =null){
            $this->set('log',$this->LogDesarrollo->find('all',array('order'=>'LogDesarrollo.id DESC','conditions'=>array('Desarrollo.id'=>$id_desarrollo,'LogDesarrollo.accion'=>$tipo))));
        }

    public function visitas($id=null){
        $this->loadModel('Event');
        $this->set('desarrollo',$this->Desarrollo->read(null,$id));
        $this->set('visitas',$this->Event->find('all',array('conditions'=>array('OR'=>array('Event.color'=>5,'Event.nombre_evento LIKE "cita%"'),'Event.desarrollo_id'=>$id))));
        }    
       
    public function borrar_brochure($id=null){
        $this->request->onlyAllow('post', 'delete');
        $this->Inmueble->query("UPDATE desarrollos SET brochure = null WHERE id = $id");
        return $this->redirect(array('action' => 'anexos',$id));
    }

    /******************************************
    *
    * Configuración del modulo de finanzas en
    * el desarrollo
    ******************************************/
    public function configuracion($desarrollo_id = null){
        $this->CuentaBancariaDesarrollo->Behaviors->load('Containable');
        $desarrollo = $this->Desarrollo->find('first', array('conditions'=>array('Desarrollo.id'=>$desarrollo_id)));
        $cuenta_ban_desarrollo = $this->CuentaBancariaDesarrollo->find('all', array('fields'=>array('Desarrollo.id','Desarrollo.nombre','Inmueble.id', 'Inmueble.titulo', 'CuentasBancarias.*'), 'conditions'=>array('Desarrollo.id'=>$desarrollo_id)));

        $this->set('tipo_cuenta', array(1=>'Bancaria', 2=>'Caja chica', 3=>'Inversión'));
        $this->set('status', array(1=>'Abierta', 2=>'Bloqueada'));
        $this->set(compact('desarrollo'));
        $this->set(compact('cuenta_ban_desarrollo'));
    }
    
    public function reporte_d1_() {
        $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
        $date_current      = date('Y-m-d');
        $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
        $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
        $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));
        if ($this->request->is(array('post', 'put'))) {
            $this->set('desarrollos_list',$this->Desarrollo->find('list',array('order'=>'Desarrollo.nombre ASC')));
            $this->set('desarrollo',$this->Desarrollo->findAllById($this->request->data['Desarrollo']['id']));
        }else{
            $desarrollo = $this->Desarrollo->read(null,76);
            $month     = date('Y-m');
            $aux       = date('Y-m-d', strtotime("{$month} + 1 month"));
            $fecha_ini = '01-01-'.date('Y');
            $fecha_fin = date('d-m-Y', strtotime("{$aux} - 1 day"));
            $this->set(compact('fecha_ini'));
            $this->set(compact('fecha_fin'));
            
            $disponibles_pesos = 0;
            $apartadas_pesos = 0;
            $vendidas_pesos = 0;
            
            foreach($desarrollo['Disponibles'] as $disponible):
                $disponibles_pesos += $disponible['precio'];
            endforeach;
            
            foreach($desarrollo['Apartadas'] as $apartada):
                $apartadas_pesos += $apartada['precio'];
            endforeach;
            
            foreach($desarrollo['Vendidas'] as $vendida):
                $vendidas_pesos += $vendida['precio'];
            endforeach;
            
            $this->loadModel('Cliente');
            $row_clientes_activos =  $this->Cliente->find('all',array('conditions'=>array('Cliente.created <='=>date('Y-m-d', strtotime($fecha_fin)),'Cliente.created >='=>date('Y-m-d', strtotime($fecha_ini)), 'Cliente.desarrollo_id'=>76)));
            $this->set('clientes',$row_clientes_activos);
            $data_clientes_temp     = array('frios'=>0, 'tibios'=>0, 'calientes'=>0, 'ventas'=>0);
            $data_clientes_status   = array('activos'=>0, 'inactivos_temp'=>0, 'ventas'=>0, 'inactivos_def'=>0);
            $data_clientes_atencion = array('oportunos'=>0, 'tardios'=>0, 'no_atendidos'=>0, 'por_reasignar'=>0, 'inactivos_temp'=>0);
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
            
            $this->set('disponibles_pesos',$disponibles_pesos);
            $this->set('apartadas_pesos',$apartadas_pesos);
            $this->set('vendidas_pesos',$vendidas_pesos);
            $this->set('desarrollo',$desarrollo);
            $this->set('desarrollos_list',$this->Desarrollo->find('list',array('conditions'=>array('Desarrollo.cuenta_id'=>$cuenta_id),'order'=>'Desarrollo.nombre ASC')));
        }
        
    }
    
    
    // Reporte de desarrollos.
    public function reporte_d1(){
        setlocale(LC_TIME, "spanish");
        $cuenta_id    = $this->Session->read('CuentaUsuario.Cuenta.id');
        $date_current = date('Y-m-d');
        $lista_ventas = [];
        $asesor       = 0;
        $fecha_inicio = date('Y-01-01');
        $fecha_final  = date('Y-m-d');
        $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
        $periodo_reporte     = utf8_encode(strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_inicio)))).' al '.strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_final)))));

        $this->loadModel('Event');

        if ( $this->request->is(array('post', 'put')) ) {
            
            $rango         = $this->request->data['Desarrollo']['rango_fechas'];
            $desarrollo_id = $this->request->data['Desarrollo']['id'];
            $desarrollo    = $this->Desarrollo->read(null,$desarrollo_id);
            $fecha_ini     = substr($rango, 0,10).' 00:00:00';
            $fecha_fin     = substr($rango, -10).' 23:59:59';
            $fi            = date('Y-m-d',  strtotime($fecha_ini));
            $ff            = date('Y-m-d',  strtotime($fecha_fin));
            $periodo_reporte     = utf8_encode(strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_ini)))).' al '.strftime("%A %d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_fin)))));
            $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_ini)).' AL '.date('d-m-Y', strtotime($fecha_fin));

            //Variables para los eventos del desarrollo
            $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id'=>$desarrollo_id,'Cliente.created >='=>$fi,'Cliente.created <='=>$ff))));
            $this->set('citas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id'=>$desarrollo_id,'LogDesarrollo.accion'=>6,'LogDesarrollo.fecha >='=>$fi, 'LogDesarrollo.fecha <='=>$ff))));
            $this->set('mails',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id'=>$desarrollo_id,'LogDesarrollo.accion'=>5 ,'LogDesarrollo.fecha >='=>$fi, 'LogDesarrollo.fecha <='=>$ff))));
            $this->set('visitas',$this->Event->find('count',array('conditions'=>array("Event.desarrollo_id" =>$desarrollo_id,'Event.tipo_tarea'=> 1, 'Event.fecha_inicio >=' => $fi, 'Event.fecha_inicio <='=>$ff))));
            
            // Total de clientes
            $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id ");
            // Clientes separados por estatus
            $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id GROUP BY status");

            /************************************************* Grafica de temperatura de clientes ********************************************************************/
            $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' AND clientes.desarrollo_id = $desarrollo_id GROUP BY etapa;");

            /************************************************* Grafica de atencion de clientes ********************************************************************/

            //Indicador de clientes con estatus Oportunos
            $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id");
                
            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id");
            
            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No Antenidos (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id");
            
            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id");
            
            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin asginar' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id");

            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id AND clientes.desarrollo_id = $desarrollo_id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.desarrollo_id = $desarrollo_id AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' AND ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
            $ventas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $desarrollo_id AND publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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

            /************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
            $query = "SELECT 
            COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
            IFNULL((SELECT unidades FROM objetivos_ventas_desarrollos WHERE fecha < periodo AND fin > periodo AND desarrollo_id = $desarrollo_id),1) AS objetivo_ventas
                FROM 
                    ventas
                WHERE 
                    ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
                    ventas.fecha <= '$ff' AND
                    ventas.fecha >= '$fi'
                GROUP BY periodo
                ORDER BY periodo";
        
            $ventas_vs_metas = $this->Desarrollo->query($query);

            // Variables de ventas vs metas por mes.
            $this->set(compact('ventas_vs_metas'));

            // Variable para generar cada mes independiente de si hay ventas o no
            $ventas_mensuales = array();
            $mes_inicial = date("Y-m",strtotime('-1 year'));
            for($i=0;$i<13;$i++){
                $ventas_mensuales[$i]['periodo_tiempo'] = $mes_inicial;
                for($j=0; $j<sizeof($ventas_vs_metas); $j++){
                    if ($j>0){        
                        if ($mes_inicial == $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = $ventas_vs_metas[$j][0]['venta_mes'];
                        }
                        else if ($mes_inicial > $ventas_vs_metas[$j-1][0]['periodo'] && $mes_inicial < $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j-1][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = 0;    
                        }
                        else if ($mes_inicial > $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = 0;   
                        }
                    }
                }
                $mes_inicial = date("Y-m",strtotime($mes_inicial."+1 month"));            
            }
            $this->set(compact('ventas_mensuales'));

            /************************************************* Grafica de visitas con linea de contacto (Acumulado) *****************************************************************/
            //$clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            //$total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND events.desarrollo_id = $desarrollo_id AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

            $visitas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $desarrollo_id AND publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

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
            

            /************************************************* Ventas por Asesor Acumulados ********************************************************************/
            $q_ventas_asesor = $this->Desarrollo->query(
                    "SELECT 
                        COUNT(ventas.precio_cerrado) AS ventas_q, users.nombre_completo AS asesor
                     FROM 
                        ventas,clientes,users 
                     WHERE  
                        fecha >= '".$fi."' AND
                        fecha <= '".$ff."' AND 
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
                        ventas.cliente_id = clientes.id AND
                        clientes.user_id = users.id
                    GROUP BY asesor;"
                    );
            
            $v_ventas_asesor = $this->Desarrollo->query(
                    "SELECT 
                        SUM(ventas.precio_cerrado) AS ventas_v, users.nombre_completo AS asesor
                     FROM 
                        ventas,clientes,users 
                     WHERE  
                        fecha >= '".$fi."' AND
                        fecha <= '".$ff."' AND 
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
                        ventas.cliente_id = clientes.id AND
                        clientes.user_id = users.id
                    GROUP BY asesor;"
                    );
            
            $ventas_asesores_arreglo = array();
            $i=0;
            foreach($q_ventas_asesor as $q_venta):
                $ventas_asesores_arreglo[$i]['venta_q'] = $q_venta[0]['ventas_q'];
                $ventas_asesores_arreglo[$i]['asesor'] = $q_venta['users']['asesor'];
                $ventas_asesores_arreglo[$i]['venta_v'] = 0;
                foreach($v_ventas_asesor as $venta):
                    if ($venta['users']['asesor']==$q_venta['users']['asesor']){
                        $ventas_asesores_arreglo[$i]['venta_v'] = $venta[0]['ventas_v'];
                    }
                endforeach;
                $i++;
            endforeach;
            
            /************************************************* Listado de ventas ********************************************************************/
            $lista_ventas = $this->Venta->find('all',array('conditions'=>array("Venta.fecha >=" => $fi, "Venta.fecha <="=> $ff, "Venta.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)")));

            /************************************************* Histórico en publicidad por medio*************************************************************/
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $desarrollo_id AND fecha_inicio <= '$ff' AND fecha_inicio >= '$fi' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

            //echo $q_inversion_publicidad;
            
            $this->set(compact('inversion_publicidad'));
            $this->set('periodo_tiempo_mes',$periodo_tiempo);

        }else{

            $desarrollo =  $this->Desarrollo->find('first',array('conditions'=>array('Desarrollo.cuenta_id'=>$cuenta_id),'order'=>'Desarrollo.nombre ASC'));
            $desarrollo_id = $desarrollo['Desarrollo']['id'];
            
            //Variables para los eventos del desarrollo
            $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id'=>$desarrollo_id,'Cliente.created >='=>$fecha_inicio,'Cliente.created <='=>$fecha_final))));
            $this->set('citas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id'=>$desarrollo_id,'LogDesarrollo.accion'=>6,'LogDesarrollo.fecha >='=>$fecha_inicio, 'LogDesarrollo.fecha <='=>$fecha_final))));
            $this->set('mails',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id'=>$desarrollo_id,'LogDesarrollo.accion'=>5 ,'LogDesarrollo.fecha >='=>$fecha_inicio, 'LogDesarrollo.fecha <='=>$fecha_final))));
            $this->set('visitas',$this->Event->find('count',array('conditions'=>array("Event.desarrollo_id" =>$desarrollo_id,'Event.tipo_tarea'=> 1, 'Event.fecha_inicio >=' => $fecha_inicio, 'Event.fecha_inicio <='=>$fecha_final))));


            // Total de clientes
            $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id ");
            // Clientes separados por estatus
            $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id GROUP BY status");

            /************************************************* Grafica de temperatura de clientes ********************************************************************/
            $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fecha_inicio."' AND created <= '".$fecha_final."' AND status = 'Activo' AND clientes.desarrollo_id = $desarrollo_id GROUP BY etapa;");

            /************************************************* Grafica de atencion de clientes ********************************************************************/

            //Indicador de clientes con estatus Oportunos
            $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id");
                
            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id");
            
            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'Atrasados (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id");
            
            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id");
            
            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin seguimiento' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fecha_inicio' AND created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id");

            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];



            /************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
            $query = "SELECT 
            COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
            IFNULL((SELECT unidades FROM objetivos_ventas_desarrollos WHERE fecha < periodo AND fin > periodo AND desarrollo_id = $desarrollo_id),1) AS objetivo_ventas
                FROM 
                    ventas
                WHERE 
                    ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
                    ventas.fecha <= '$fecha_final' AND
                    ventas.fecha >= '$fecha_inicio'
                GROUP BY periodo
                ORDER BY periodo";
        
            $ventas_vs_metas = $this->Desarrollo->query($query);

            // Variables de ventas vs metas por mes.
            $this->set(compact('ventas_vs_metas'));

            // Variable para generar cada mes independiente de si hay ventas o no
            $ventas_mensuales = array();
            $mes_inicial = date("Y-m",strtotime('-1 year'));
            for($i=0;$i<13;$i++){
                $ventas_mensuales[$i]['periodo_tiempo'] = $mes_inicial;
                for($j=0; $j<sizeof($ventas_vs_metas); $j++){
                    if ($j>0){        
                        if ($mes_inicial == $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = $ventas_vs_metas[$j][0]['venta_mes'];
                        }
                        else if ($mes_inicial > $ventas_vs_metas[$j-1][0]['periodo'] && $mes_inicial < $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j-1][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = 0;    
                        }
                        else if ($mes_inicial > $ventas_vs_metas[$j][0]['periodo']){
                            $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
                            $ventas_mensuales[$i]['ventas'] = 0;   
                        }
                    }
                }
                $mes_inicial = date("Y-m",strtotime($mes_inicial."+1 month"));            
            }
            $this->set(compact('ventas_mensuales'));

            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id AND clientes.desarrollo_id = $desarrollo_id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.desarrollo_id = $desarrollo_id AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fecha_inicio' AND  ventas.fecha <= '$fecha_final' AND ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
            $ventas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $desarrollo_id AND publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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


            $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND events.desarrollo_id = $desarrollo_id AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fecha_inicio' AND  events.fecha_inicio <= '$fecha_final' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

            $visitas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $desarrollo_id AND publicidads.fecha_inicio >= '$fecha_inicio' AND  publicidads.fecha_inicio <= '$fecha_final' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

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
            

            /************************************************* Ventas por Asesor Acumulados ********************************************************************/
            $q_ventas_asesor = $this->Desarrollo->query(
                    "SELECT 
                        COUNT(ventas.precio_cerrado) AS ventas_q, users.nombre_completo AS asesor
                     FROM 
                        ventas,clientes,users 
                     WHERE  
                        fecha >= '".$fecha_inicio."' AND
                        fecha <= '".$fecha_final."' AND 
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
                        ventas.cliente_id = clientes.id AND
                        clientes.user_id = users.id
                    GROUP BY asesor;"
                    );
            
            $v_ventas_asesor = $this->Desarrollo->query(
                    "SELECT 
                        SUM(ventas.precio_cerrado) AS ventas_v, users.nombre_completo AS asesor
                     FROM 
                        ventas,clientes,users 
                     WHERE  
                        fecha >= '".$fecha_inicio."' AND
                        fecha <= '".$fecha_final."' AND 
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
                        ventas.cliente_id = clientes.id AND
                        clientes.user_id = users.id
                    GROUP BY asesor;"
                    );
            
            $ventas_asesores_arreglo = array();
            $i=0;
            foreach($q_ventas_asesor as $q_venta):
                $ventas_asesores_arreglo[$i]['venta_q'] = $q_venta[0]['ventas_q'];
                $ventas_asesores_arreglo[$i]['asesor'] = $q_venta['users']['asesor'];
                $ventas_asesores_arreglo[$i]['venta_v'] = 0;
                foreach($v_ventas_asesor as $venta):
                    if ($venta['users']['asesor']==$q_venta['users']['asesor']){
                        $ventas_asesores_arreglo[$i]['venta_v'] = $venta[0]['ventas_v'];
                    }
                endforeach;
                $i++;
            endforeach;
            
            /************************************************* Listado de ventas ********************************************************************/
            $lista_ventas = $this->Venta->find('all',array('conditions'=>array("Venta.fecha >=" => $fecha_inicio, "Venta.fecha <="=> $fecha_final, "Venta.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)")));



            /************************************************* Histórico en publicidad por medio*************************************************************/
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $desarrollo_id AND fecha_inicio <= '$fecha_final' AND fecha_inicio >= '$fecha_inicio' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

            //echo $q_inversion_publicidad;
            
            $this->set(compact('inversion_publicidad'));
            $this->set('periodo_tiempo_mes',$periodo_tiempo);

        }

        $n_bloqueadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id = $desarrollo_id) AND inmuebles.liberada = 0;");

        $n_liberadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id = $desarrollo_id) AND inmuebles.liberada = 1;");

        $n_recervadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id = $desarrollo_id) AND inmuebles.liberada = 2;");

        $n_contrato_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id = $desarrollo_id) AND inmuebles.liberada = 3;");

        $n_escrituracion_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id = $desarrollo_id) AND inmuebles.liberada = 4;");

        $n_baja_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id = $desarrollo_id) AND inmuebles.liberada = 5;");

        
        $clientes_asignados = $this->Desarrollo->query("SELECT COUNT(*) AS n_clientes FROM clientes WHERE clientes.desarrollo_id = $desarrollo_id;");


        // Variables globales
        $this->set(compact('cuenta_id'));
        $this->set(compact('desarrollo'));
        $this->set(compact('date_current'));
        $this->set(compact('lista_ventas'));
        $this->set(compact('fecha_inicio'));
        $this->set(compact('fecha_final'));
        $this->set(compact('periodo_tiempo'));
        
        $this->set(
            'desarrollos_list',
            $this->Desarrollo->find(
                'list',
                array(
                    'conditions'=>array(
                        'OR' => array(
                            'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                            'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                        ), 
                    ),
                    'order'=>'Desarrollo.nombre ASC'
                )
            )
        );
        $this->set('clientes', $total_clientes_anuales);
        $this->set(compact('periodo_reporte'));

        $this->set(compact('n_bloqueadas_precios'));
        $this->set(compact('n_liberadas_precios'));
        $this->set(compact('n_recervadas_precios'));
        $this->set(compact('n_contrato_precios'));
        $this->set(compact('n_escrituracion_precios'));
        $this->set(compact('n_baja_precios'));

        $this->set(compact('clientes_asignados'));


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
        
        //Variable de Ventas Acumulada por Asesor
        $this->set(compact('ventas_asesores_arreglo'));
        
         //Variable para el número de visitas por linea de contacto
         $this->set(compact('visitas_linea_contacto_arreglo'));

        
    }

    function cambiar_titular($id = null){
        if($this->request->is('post')){
            $nuevo_id = $this->request->data['Desarrollo']['cuenta_titular'];
            $this->loadModel('Cuenta');
            $cuenta = $this->Cuenta->findFirstByUniqueId($nuevo_id);
            $desarrollo_id = $this->request->data['Desarrollo']['desarrollo_id'];
            $this->Desarrollo->query("UPDATE desarrollos SET cuenta_id = ".$cuenta['Cuenta']['id']." WHERE id = $desarrollo_id");
            $this->Desarrollo->query("UPDATE clientes SET cuenta_id = ".$cuenta['Cuenta']['id']." WHERE desarrollo_id = $desarrollo_id");
            $this->Desarrollo->query("UPDATE inmuebles SET cuenta_id = ".$cuenta['Cuenta']['id']." WHERE id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)");
            //Mover archivos a la nueva carpeta
            
            $old_path = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/desarrollos/".$desarrollo_id;
            $new_path = getcwd()."/files/cuentas/".$cuenta['Cuenta']['id']."/desarrollos/".$desarrollo_id;
            mkdir($new_path,0777);
            rename($old_path,$new_path);
            $this->Desarrollo->query("UPDATE foto_desarrollos SET ruta = REPLACE (ruta,'/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/','/files/cuentas/".$cuenta['Cuenta']['id']."/') WHERE desarrollo_id = $desarrollo_id");
            $this->Desarrollo->query("UPDATE foto_inmuebles SET ruta = REPLACE (ruta,'/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/','/files/cuentas/".$cuenta['Cuenta']['id']."/') WHERE inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)");
            $this->Desarrollo->query("UPDATE documentos_users SET ruta = REPLACE (ruta,'/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/','/files/cuentas/".$cuenta['Cuenta']['id']."/') WHERE desarrollo_id = $desarrollo_id");
            
            return $this->redirect(array('action' => 'index'));
        }else{
            $desarrollo = $this->Desarrollo->read(null,$id);
            $this->set('desarrollo',$desarrollo);
        }
    }
    
    function asignar_corretaje($id=null){
        if ($this->request->is('post')){
            $nuevo_id = $this->request->data['Desarrollo']['cuenta_comercializadora'];
            $this->loadModel('Cuenta');
            $cuenta = $this->Cuenta->findFirstByUniqueId($nuevo_id);
            $desarrollo_id = $this->request->data['Desarrollo']['desarrollo_id'];
            $this->Desarrollo->query("UPDATE desarrollos SET comercializador_id = ".$cuenta['Cuenta']['id']." WHERE id = $desarrollo_id");
            return $this->redirect(array('action' => 'index'));
            
        }else{
            $desarrollo = $this->Desarrollo->read(null,$id);
            $this->set('desarrollo',$desarrollo);
        }
    }













	public function get_desarrollos( $cuenta_id = null, $user_id = null ){
        $this->Desarrollo->Behaviors->load('Containable');
        $this->User->Behaviors->load('Containable');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        $this->layout = null;

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
        $condiciones = array(
            'OR'=>array(
                'cuenta_id' => $cuenta_id,
                'comercializador_id' => $cuenta_id,
            ),
            
        );

      }else{
        $condiciones = array(
            'AND'=>array(
                'visible'   => 1,
            ),
            'OR'=>array(
                'cuenta_id' => $cuenta_id,
                'comercializador_id' => $cuenta_id,
            ),
            
        );
      }

        $desarrollo = [];

        $db_desarrollos = $this->Desarrollo->find('all',array(
            'conditions' => $condiciones,
            'contain' => array(
                'FotoDesarrollo' => array('limit'=>1)
            ),
            'recursive'=> -1,
            'fields' => array(
                'nombre',
                'm2_low',
                'm2_top',
                'rec_low',
                'rec_top',
                'banio_low',
                'banio_top',
                'est_low',
                'est_top',
                'visible',
                'id'
            ),
            'order' => array(
                'Desarrollo.nombre'
            )
    ));

       for($a=0; $a < count($db_desarrollos); $a++  ){
           
           switch ($db_desarrollos[$a]['Desarrollo']['visible']) {
               case 0:
                   $visible = 'No liberado';
                   $color   = '#FFFF00';
                   break;
               case 1:
                   $visible = 'En venta';
                   $color   = 'rgb(0, 64 , 128)';
                   break;
               case 2:
                   $visible = 'Vendido';
                   $color   = '#c90b0b';
                   break;
           }

           $desarrollo[$a] = array(
               "id"             => $db_desarrollos[$a]['Desarrollo']['id'],
               "nombre"         => $db_desarrollos[$a]['Desarrollo']['nombre'],
               "m2_top"         => $db_desarrollos[$a]['Desarrollo']['m2_top'],
               "m2_low"         => $db_desarrollos[$a]['Desarrollo']['m2_low'],
               "rec_top"        => $db_desarrollos[$a]['Desarrollo']['rec_top'],
               "rec_low"        => $db_desarrollos[$a]['Desarrollo']['rec_low'],
               "banio_top"      => $db_desarrollos[$a]['Desarrollo']['banio_top'],
               "banio_low"      => $db_desarrollos[$a]['Desarrollo']['banio_low'],
               "est_top"        => $db_desarrollos[$a]['Desarrollo']['est_top'],
               "est_low"        => $db_desarrollos[$a]['Desarrollo']['est_low'],
               "visible"        => $visible,
               "bg_visible"     => $color,
               'foto'           => ( isset($db_desarrollos[$a]['FotoDesarrollo'][0]['ruta']) ? $db_desarrollos[$a]['FotoDesarrollo'][0]['ruta'] : '' )
           );
       };

       echo json_encode($desarrollo, true);
    // print_r( $db_desarrollos );
       $this->autoRender = false; 

   }



   public function get_desarrollos_detalle( $desarrollo_id = null ){
    $this->Desarrollo->Behaviors->load('Containable');
    $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "&nbsp;");

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");

    $this->layout = null;
    
    $desarrollo = $this->Desarrollo->find('first',
                    array(
                        'conditions' => array(
                            'Desarrollo.' . $this->Desarrollo->primaryKey => $desarrollo_id
                        ),
                        'contain' => array(
                            'FotoDesarrollo',
                            'FotoDesarrolloQ',
                            'Planos',
                            'PlanosQ',
                            'Disponibles',
                            'Propiedades'
                        ),
                    )
                );
    

    // Remover y remplazar la descripcion del desarrollo
    // Limpiar la descripcion del desarrollo.
    
    $desarrollo['Desarrollo']['descripcion_custom'] = strip_tags(str_replace($limpieza, "", $desarrollo['Desarrollo']['descripcion']));
    //$desarrollo['Desarrollo']['descripcion150'] = substr(strip_tags($desarrollo['Desarrollo']['descripcion']), 0, 150).'...';
    $desarrollo['Desarrollo']['descripcion150'] = strip_tags($desarrollo['Desarrollo']['descripcion']);




    // Añadir el conteo de las propiedades disponibles y las totales
    $desarrollo['Desarrollo']['count_disponibles'] = count( $desarrollo['Disponibles']);
    $desarrollo['Desarrollo']['count_propiedades'] = count( $desarrollo['Propiedades']);

    // Formateo de los precios
    $desarrollo['Desarrollo']['precio_top'] = number_format($desarrollo['Desarrollo']['precio_top'], 2);
    $desarrollo['Desarrollo']['precio_low'] = number_format($desarrollo['Desarrollo']['precio_low'], 2);

    // Coordenadas
    $desarrollo['Desarrollo']['google_maps']        = explode(",", $desarrollo['Desarrollo']['google_maps']);
    $desarrollo['Desarrollo']['lat']                = floatval($desarrollo['Desarrollo']['google_maps']['0']);
    $desarrollo['Desarrollo']['lng']                = floatval($desarrollo['Desarrollo']['google_maps']['1']);
    $desarrollo['Desarrollo']['google_maps']        = implode(",", $desarrollo['Desarrollo']['google_maps']);

    echo json_encode( $desarrollo, true );
    // print_r( $desarrollo );
    $this->autoRender = false; 
    
}


    public function get_images_desarrollo( $desarrollo_id = null ){
        $this->Desarrollo->Behaviors->load('Containable');
        $s = 0;
        header('Access-Control-Allow-Origin: *');
      	header("Access-Control-Allow-Methods: GET, OPTIONS");
        $this->layout = null;

        $desarrollo = $this->Desarrollo->find('first',
            array(
                'conditions' => array(
                    'Desarrollo.id'           => $desarrollo_id,
                ),
                'fields' => array(
                    'Desarrollo.id'
                ),
                'contain' => array(
                    'FotoDesarrollo'
                ),
            )
        );

        foreach( $desarrollo['FotoDesarrollo'] as $foto ){
            $data_foto[$s]['FotoDesarrollo'] = array(
                'ruta'        => $foto['ruta'],
                'descripcion' => $foto['descripcion'],
                'orden'       => $foto['orden']
            );
            $s ++;
        }

        echo json_encode( $data_foto, true );
        $this->autoRender = false;

    }

    public function get_planos( $desarrollo_id = null ){
        $this->Desarrollo->Behaviors->load('Containable');
        $s = 0;
        header('Access-Control-Allow-Origin: *');
      	header("Access-Control-Allow-Methods: GET, OPTIONS");
        $this->layout = null;

        $desarrollo = $this->Desarrollo->find('first',
            array(
                'conditions' => array(
                    'Desarrollo.id'           => $desarrollo_id,
                ),
                'fields' => array(
                    'Desarrollo.id'
                ),
                'contain' => array(
                    'Planos'
                ),
            )
        );

        foreach( $desarrollo['Planos'] as $foto ){
            $data_foto[$s]['Planos'] = array(
                'ruta'        => $foto['ruta'],
                'descripcion' => $foto['descripcion'],
                'orden'       => $foto['orden']
            );
            $s ++;
        }

        echo json_encode( $data_foto, true );
        $this->autoRender = false;

    }

    public function list_lead_propiedades( $cuenta_id = null, $user_id = null, $desarrollo_id = null ) {
        $this->Inmueble->Behaviors->load('Containable');
        $this->User->Behaviors->load('Containable');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        $this->layout = null;

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


        if ( $user['Rol'][0]['cuentas_users']['group_id'] == 1 OR $user['Rol'][0]['cuentas_users']['group_id'] == 2 ) {
            
            $condiciones = array( "Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)");

        }else{
            
            $condiciones = array(
                    "Inmueble.liberada" => 1,
                    "Inmueble.id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)"
            );
                    
        }

        $inmuebles = $this->Inmueble->find('all',array(
            'conditions' => $condiciones,
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
                'fotoInmueble'                => ( isset($inmueble['FotoInmueble'][0]['ruta']) ? $inmueble['FotoInmueble'][0]['ruta'] : '/img/no_photo_inmuebles.png' )
            );
            $s++;
        }


        // print_r( $resp );
        echo json_encode( $resp, true);
        $this->autoRender = false;

    }

}
