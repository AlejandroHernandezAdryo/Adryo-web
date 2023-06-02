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
    public $cuenta_id;
	public $uses = array('Desarrollo','Inmueble','User','FotoDesarrollo','DocumentosUser','Cliente','Lead','LogDesarrollo','DicLineaContacto', 'CuentaBancariaDesarrollo', 'Categoria', 'Proveedor', 'Venta', 'Diccionario', 'DesarrolloInmueble', 'CuentasUser');
        
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        
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
        $this->Auth->allow('get_desarrollo_app','detalle', 'get_desarrollos_detalle', 'get_desarrollos', 'get_images_desarrollo', 'get_planos', 'list_lead_propiedades', 'get_listado_desarrollos_user', 'get_planes_pago');
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
                                        
                                        // 'Desarrollo.id'=>$this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'),
                                        'Desarrollo.id' => $this->Session->read('Desarrollos')
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
                        if ( $this->Session->read('Permisos.Group.id') == 3 OR $this->Session->read('Permisos.Group.id') == 7 ){
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
                                                    ),
                                                    'Clusters'=>array(
                                                        'fields'=>array(
                                                            'nombre'
                                                        )
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
                                                    ),
                                                    'Clusters'=>array(
                                                        'fields'=>array(
                                                            'nombre'
                                                        )
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
                                                    ),
                                                    'Clusters'=>array(
                                                        'fields'=>array(
                                                            'nombre'
                                                        )
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
            $this->Desarrollo->Behaviors->load('Containable');

            $this->request->data['Desarrollo']['id']      = $id;
            $this->request->data['Desarrollo']['visible'] = $status;

            // Poner validacion para cuando se libera guarde la fecha inicio de comercialización.
            $desarrollo = $this->Desarrollo->find('first',
                array(
                    'contain'    => false,
                    'fields'     => array(
                        'fecha_liberacion',
                        'visible'
                    ),
                    'conditions' => array(
                        'Desarrollo.id' => $id
                    )
                )
            );

            if( $status == 1) {

                if( $desarrollo['Desarrollo']['fecha_liberacion'] == null ) {

                    $this->request->data['Desarrollo']['fecha_liberacion'] = date('Y-m-d H:m:i');

                }
            }

            $this->Desarrollo->save($this->request->data);

            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha cambiado correctamente de estatus.', 'default', array(), 'm_success'); // Mensaje

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
        $this->getMinMax($id);
    
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
                    'sistema_contra_incendios','sistema_seguridad','valet_parking','vapor','seguridad','google_maps','fecha_alta',
                    'm_cisterna','q_elevadores', 'pet_park', 'coworking', 'meditation_room', 'simulador_golf', 'cancha_pickleball', 'cancha_petanca', 'pool_bar','cerca_playa', 'biblioteca',
                    'ciclopista', 'conserje', 'helipuerto', 'ludoteca', 'vista_panoramica', 'certificacion_led' ,'certificacion_led_opciones', 'mezzanine'
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
                            'temperatura',
                            'last_edit',
                            'nombre',
                            'id',
                            'created',
                            'etapa',
                            'status',
                            'user_id',
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
                        ),
                        'DicLineaContacto' => array(
                            'fields' => array(
                                'linea_contacto'
                            )
                        )
                    ),
                    'Facturas'=>array(
                        'fields'=>array(
                            'folio','referencia','fecha_emision','concepto','subtotal','iva','total','estado','categoria_id',
                            'id'
                        )
                    ),
                    'Log' => array(
                        'fields' => array(
                            'Log.id',
                            'Log.accion',
                            'Log.usuario_id',
                            'Log.mensaje',
                            'Log.fecha',
                        ),
                        'User' => array(
                            'fields' => 'nombre_completo'
                        )
                    ),
                    'Publicidad'=>array(
                        'fields'=>array(
                            'fecha_inicio','nombre','objetivo','dic_linea_contacto_id','inversion_prevista', 'id'
                        )
                    ),
                    'ObjetivoAplicable'=>array(
                        'fields'=>array(
                            'monto'
                        )
                    ),'PlanesPago',
                    'Extras'
                    /*
                    'Cerrador'=>array(
                        'fields'=>array(
                            'nombre_completo'
                        )
                    ),*/
                ),
                'conditions'=>array(
                    'Desarrollo.id'=>$id
                )
            )
        );

        $this->set(compact('desarrollo'));
        $this->set('desarrollo_id',$id);

        //Contadores para Inventarios
        $contadores = $this->Desarrollo->query("SELECT COUNT(*) AS numero,liberada FROM inmuebles WHERE id IN (SELECT inmueble_id  FROM desarrollo_inmuebles WHERE desarrollo_id = $id) GROUP BY liberada");
        $contadores_arreglo = array();
        
        foreach ($contadores as $contador){
            $contadores_arreglo[$contador['inmuebles']['liberada']] = $contador[0]['numero'];
        }
        $this->set('contadores',$contadores_arreglo);

        // Primer cliente del desarrollo
        $cliente = $this->Cliente->find('first', array(
            'conditions' => array(
                'desarrollo_id' => $id
            ),
            'fields' => array(
                'Cliente.created'
            ),
            'contain' => false
        ));


        //Buscamos Eventos
        // $fecha_inicial       = date('Y').'01-01 00:00:00';
        $fecha_inicial       = $desarrollo['Desarrollo']['fecha_alta'];
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
        $data_eventos[$s]['url']                 = "javascript:viewEvent('".$tipo_tarea[$evento['Event']['tipo_tarea']].' '.$remitente.': '.$evento['Cliente']['nombre']."','".date('d-m-Y', strtotime($evento['Event']['fecha_inicio']))." ".date('H:i:s a', strtotime($evento['Event']['fecha_inicio']))."', '".$nombre_ubicacion."','".$evento['User']['nombre_completo']."','".$evento['Event']['tipo_tarea']."', '".$evento['Event']['status']."', '".$evento['User']['id']."','".$evento['Cliente']['id']."','".$url_ubicacion."','".$evento['Event']['id']."')";
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

        $fi = date('Y-m-d', strtotime($desarrollo['Desarrollo']['fecha_alta']));
        $ff  = date('Y-m-d');
        $mes_inicio = date('Y-m-01');
        $mes_final  = date('Y-m-t');
        $periodo_tiempo = 'INFORMACIÓN DEL '.date('d-m-Y', strtotime($fi)).' AL '.date('d-m-Y', strtotime($ff));
        $view_anio = true;
        $this->set(compact('periodo_tiempo', 'view_anio')); 
        
        $periodo_tiempo_mes =  $periodo_tiempo = 'INFORMACIÓN DEL '.date('01-m-Y', strtotime($fi)).' AL '.date('d-m-Y', strtotime($ff));
        $this->set(compact('periodo_tiempo_mes'));

        //Comienzan las gráficas del desarrollo
        /************************************************* Grafica de clientes con linea de contacto (Mes) ********************************************************************/
        $clientes_lineas_mes = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.desarrollo_id = $id AND user_id IS NOT NULL AND clientes.created >= '$mes_inicio' AND clientes.created <= '$mes_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
        $total_clientes_lineas_mes = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.desarrollo_id = $id AND user_id IS NOT NULL AND clientes.created >= '$mes_inicio' AND clientes.created <= '$mes_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
        $this->set(compact('clientes_lineas_mes'));
        $this->set(compact('total_clientes_lineas_mes'));

        /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
        $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.dic_linea_contacto_id = dic_linea_contactos.id AND clientes.desarrollo_id = $id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");
        $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.desarrollo_id = $id AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");
        $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id) GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
        $ventas_linea_contacto_arreglo = array();
        $i=0;

        //Para el acumulado de inversión
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                    $ventas_linea_contacto_arreglo[$i]['inversion'] = $inversion[0]['inversion'];    
                }
            endforeach;
            $i++;
        endforeach;

        $this->set(compact('clientes_lineas'));
        $this->set(compact('total_clientes_lineas'));
        $this->set(compact('venta_linea_contacto'));
        $this->set(compact('ventas_linea_contacto_arreglo'));

        /************************************************* Grafica de ventas vs metas mensuales (último año) *****************************************************************************/
            $f_inicial = strtotime($desarrollo['Desarrollo']['fecha_alta'])>strtotime("-1 year") ? date("Y-m-d",strtotime($desarrollo['Desarrollo']['fecha_alta'])) : date("Y-m-d",strtotime("-1 year"));
            $f_final = date('Y-m-d');
            $periodos = $this->getPeriodosArreglo($f_inicial,$f_final);
            $kpi_arreglo = array();
            foreach($periodos as $key=>$periodo){
            $monto = $this->User->query("SELECT SUM(monto),SUM(unidades) FROM objetivos_ventas_desarrollos WHERE fecha <= '".$key."-01' AND fin >= '".$key."-31' AND desarrollo_id = $id");
            $ventas = $this->User->query("SELECT COUNT(*),SUM(precio_cerrado) FROM ventas WHERE fecha >= '".$key."-01' AND fecha <= '".$key."-31' AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id)");
            $kpi_arreglo[$key]['periodo'] = $periodo;
            $kpi_arreglo[$key]['objetivo_monto'] = $monto[0][0]['SUM(monto)']==NULL ? 0 : $monto[0][0]['SUM(monto)'];
            $kpi_arreglo[$key]['objetivo_q'] = $monto[0][0]['SUM(unidades)']==NULL ? 0 : $monto[0][0]['SUM(unidades)'];
            $kpi_arreglo[$key]['ventas_q'] = $ventas[0][0]['COUNT(*)']==NULL ? 0 : $ventas[0][0]['COUNT(*)'];
            $kpi_arreglo[$key]['ventas_monto'] = $ventas[0][0]['SUM(precio_cerrado)']==NULL ? 0 : $ventas[0][0]['SUM(precio_cerrado)'];
            }

        $this->set('kpi_arreglo_anual',$kpi_arreglo);

        /************************************************* Grafica de ventas vs metas mensuales (histórico) *****************************************************************************/
        $f_inicial = date("Y-m-d",strtotime($desarrollo['Desarrollo']['fecha_alta']));
        $f_final = date('Y-m-d');
        $periodos = $this->getPeriodosArreglo($f_inicial,$f_final);
        $kpi_arreglo = array();
        foreach($periodos as $key=>$periodo){
        $monto = $this->User->query("SELECT SUM(monto),SUM(unidades) FROM objetivos_ventas_desarrollos WHERE fecha <= '".$key."-01' AND fin >= '".$key."-31' AND desarrollo_id = $id");
        $ventas = $this->User->query("SELECT COUNT(*),SUM(precio_cerrado) FROM ventas WHERE fecha >= '".$key."-01' AND fecha <= '".$key."-31' AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $id)");
        $kpi_arreglo[$key]['periodo'] = $periodo;
        $kpi_arreglo[$key]['objetivo_monto'] = $monto[0][0]['SUM(monto)']==NULL ? 0 : $monto[0][0]['SUM(monto)'];
        $kpi_arreglo[$key]['objetivo_q'] = $monto[0][0]['SUM(unidades)']==NULL ? 0 : $monto[0][0]['SUM(unidades)'];
        $kpi_arreglo[$key]['ventas_q'] = $ventas[0][0]['COUNT(*)']==NULL ? 0 : $ventas[0][0]['COUNT(*)'];
        $kpi_arreglo[$key]['ventas_monto'] = $ventas[0][0]['SUM(precio_cerrado)']==NULL ? 0 : $ventas[0][0]['SUM(precio_cerrado)'];
        }

        $this->set('kpi_arreglo',$kpi_arreglo);

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
        $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id = $id AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id AND publicidads.fecha_inicio >= '".date('Y-m-d 00:00:00', strtotime($fi))."' GROUP BY linea_contacto;";
        $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

        //echo $q_inversion_publicidad;
        
        $this->set(compact('inversion_publicidad'));

        /************************************************* Fechas para calcular los estatus de los clientes *************************************************************/
        $date_current      = date('Y-m-d H:i:s');
        $date_oportunos    = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
        $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
        $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

        $this->set(compact('date_current'));            
        $this->set(compact('date_oportunos'));
        $this->set(compact('date_tardios'));
        $this->set(compact('date_no_atendidos'));

        $inversion_meses = [];
        for($i = 1; $i <= 24; $i++ ){
            $inversion_meses[$i] = $i;
        }

        $this->set('inversion_meses', $inversion_meses);

        // Listado de bancos
        $this->set('bancos_de_mexico',$this->Diccionario->find('list',array(
            'conditions'=>array(
                'Diccionario.sub_directorio' => 'dic_list_bancos_mexico'
            ),
            'fields' => array('Diccionario.descripcion', 'Diccionario.descripcion'),
            'contain' => false,
        )));

        $this->set('status_plan_pagos', array(
            0 => array(
                'color' => 'bg-danger',
                'label' => 'Inactivo'
            ),
            1 => array(
                'color' => 'bg-success',
                'label' => 'Activo'
            )
        ));
        
    }
    
    /* -------------------------------------------------------------------------- */
    /*                    Metodo de ficha tecnica de desarrollo                   */
    /* -------------------------------------------------------------------------- */
    public function detalle($id = null,$id_agente = null) {
        $this->layout = 'blank';
        if (!$this->Desarrollo->exists($id)) {
            throw new NotFoundException(__('Invalid inmueble'));
        }
        
        $desarrollo   = $this->Desarrollo->read(null, $id);
        $agente       = $this->User->read(null, $id_agente);
        $rds_sociales = $this->CuentasUser->find('first',array('conditions'=>array('CuentasUser.user_id'=>$agente['User']['id'])));
        
        $this->set(compact('desarrollo', 'agente', 'rds_sociales'));
                    
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

    /* ----------------- Metodo para agregar nuevos desarrollos ----------------- */
    public function add() {

        if ($this->Session->read('Auth.User.group_id')==5){
            return $this->redirect(array('action' => 'mysession','controller'=>'users'));
        }
        
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
            //$this->request->data['Desarrollo']['ciudad']                 = $this->request->data['ciudad'];
            $this->request->data['Desarrollo']['cp']                     = $this->request->data['cp'];
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

                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('El desarrollo se ha cargado exitosamente.', 'default', array(), 'm_success'); // Mensaje

                if ($this->request->data['Desarrollo']['return'] == 1){
                    return $this->redirect(array('action' => 'view',$id));
                }else{
                    return $this->redirect(array('controller'=>'desarrollos','action' => 'amenidades',$id));
                }
                           
            } else {
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Hubo un problema, favor de intentarlo nuevamente, gracias.', 'default', array(), 'm_success'); // Mensaje
            }
        }

        // Variable para select de los estados.
        $this->set('estados_republica', $this->estados_republica );
    }
        
    /* --------------- Metodo para editar el paso 1 de desarrollos -------------- */
	public function edit_generales($id = null){
        
        if ($this->Session->read('Auth.User.group_id')==5){
            return $this->redirect(array('action' => 'mysession','controller'=>'users'));
        }

		if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Desarrollo']['nombre']          = $this->request->data['nombre'];
            $this->request->data['Desarrollo']['referencia']      = $this->request->data['referencia'];
            $this->request->data['Desarrollo']['tipo_inmuebles']  = $this->request->data['tipo_inmuebles'];
            $this->request->data['Desarrollo']['tipo_desarrollo'] = $this->request->data['tipo'];
            $this->request->data['Desarrollo']['calle']           = $this->request->data['calle'];
            $this->request->data['Desarrollo']['numero_ext']      = $this->request->data['numero_ext'];
            $this->request->data['Desarrollo']['colonia']         = $this->request->data['colonia'];
            $this->request->data['Desarrollo']['delegacion']      = $this->request->data['delegacion'];
            // $this->request->data['Desarrollo']['ciudad']                 = $this->request->data['ciudad'];
            $this->request->data['Desarrollo']['cp']                         = $this->request->data['cp'];
            $this->request->data['Desarrollo']['etapa_desarrollo']           = $this->request->data['etapa_desarrollo'];
            $this->request->data['Desarrollo']['meta_mensual']               = $this->request->data['meta_mensual'];
            $this->request->data['Desarrollo']['inicio_preventa']            = date('Y-m-d', strtotime($this->request->data['Desarrollo']['inicio_preventa']));
            $this->request->data['Desarrollo']['fecha_inicio_exclusiva']     = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_inicio_exclusiva']));
            $this->request->data['Desarrollo']['fecha_entrega']              = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_entrega']));
            $this->request->data['Desarrollo']['fecha_exclusiva']            = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_exclusiva']));
            $this->request->data['Desarrollo']['fecha_inicio_obra']          = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_inicio_obra']));
            $this->request->data['Desarrollo']['fecha_fin_obra']             = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_fin_obra']));
            $this->request->data['Desarrollo']['fecha_real_fin_obra']        = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_real_fin_obra']));
            $this->request->data['Desarrollo']['fecha_inicio_escrituracion'] = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_inicio_escrituracion']));
            $this->request->data['Desarrollo']['fecha_comercializacion']     = date('Y-m-d', strtotime($this->request->data['Desarrollo']['fecha_comercializacion']));
            
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
				
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Los cambios se han guardado exitosamente.', 'default', array(), 'm_success'); // Mensaje

            if ($this->request->data['Desarrollo']['return'] == 1){
                return $this->redirect(array('action' => 'view',$id));
            }else{
                return $this->redirect(array('controller'=>'desarrollos','action' => 'amenidades',$id));
            }
				
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
                'cerrador_id','departamento_muestra','fecha_inicio_obra','fecha_fin_obra','fecha_real_fin_obra','fecha_inicio_escrituracion', 'fecha_comercializacion', 'porcentaje_construccion'
            ),
            'contain'=>false,
            'conditions' => array(
                'Desarrollo.' . $this->Desarrollo->primaryKey => $id
            ),
        );
        $desarrollo = $this->Desarrollo->find('first', $options);
        $this->request->data = $desarrollo;
        $this->set('desarrollo', $desarrollo);

        $this->set('cerradores',$this->User->find('list',array('conditions'=>array('id IN (SELECT user_id FROM cuentas_users WHERE cerrador = 1 AND cuenta_id = '.$desarrollo['Desarrollo']['cuenta_id'].')'))));

        // Variable para select de los estados.
        $this->set('estados_republica', $this->estados_republica );
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

    /* ----------------- Edicion de datos de desarrollos paso 2 ----------------- */
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
        }else {
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

    /* ---------------- Funcion para agregar anexos al desarrollo --------------- */
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

            // Subir imagenes del desarrollo
            $id = $this->request->data['Desarrollo']['id'];
            if ($this->request->data['Desarrollo']['fotos'][0]['name']!="") {
                foreach ($this->request->data['Desarrollo']['fotos'] as $fotos) {
                    
                    $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                    move_uploaded_file($fotos['tmp_name'],$filename);
                    $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                    $this->Inmueble->query("INSERT INTO foto_desarrollos VALUES (0,$id,'".$ruta."','',0, '1')");
                }
            }
            
            if ($this->request->data['Desarrollo']['planos_comerciales'][0]['name']!="") {
                foreach ($this->request->data['Desarrollo']['planos_comerciales'] as $fotos) {
                    $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                    move_uploaded_file($fotos['tmp_name'],$filename);
                    $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/desarrollos/".$id."/".$fotos['name'];
                    $this->Inmueble->query("INSERT INTO foto_desarrollos VALUES (0,$id,'".$ruta."','',0, '2')");
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
                    
		} else {
            $options = array('conditions' => array('Desarrollo.' . $this->Desarrollo->primaryKey => $id));
            $desarrollo = $this->Desarrollo->find('first', $options);
            $this->request->data = $desarrollo;
            $this->set('desarrollo',$desarrollo);
            $this->set('imagenes',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id,'FotoDesarrollo.tipo_archivo'=>1),'order'=>array('FotoDesarrollo.tipo_archivo'=>'ASC', 'FotoDesarrollo.orden'=>'ASC'))));
            $this->set('planos',$this->FotoDesarrollo->find('all',array('conditions'=>array('Desarrollo.id'=>$id,'FotoDesarrollo.tipo_archivo'=>2),'order'=>array('FotoDesarrollo.tipo_archivo'=>'ASC', 'FotoDesarrollo.orden'=>'ASC'))));
		}
	}
        
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
        $date_current      = date('Y-m-d ');
        $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
        $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
        $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

        $interesados_acumulados = 0;
        $visitas_acumuladas     = 0;
        $citas_acumuladas       = 0;
        $mails_acumuladas       = 0;

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
        if ( $this->request->is(array('post', 'put')) ) {

            $cuenta_id    = $this->Session->read('CuentaUsuario.Cuenta.id');
            $date_current = date('Y-m-d');
            $lista_ventas = [];
            $asesor       = 0;
            $fecha_inicio = date('Y-01-01');
            $fecha_final  = date('Y-m-d');
            $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
            $periodo_reporte     = ucwords(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_inicio)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_final)))));
            //$periodo_reporte = date('d/M/Y',strtotime($fecha_inicio))." al ".date('d/M/Y',strtotime($fecha_final));

            $interesados_acumulados = 0;
            $visitas_acumuladas     = 0;
            $citas_acumuladas       = 0;
            $mails_acumuladas       = 0;

            $this->loadModel('Event');


            $rango         = $this->request->data['Desarrollo']['rango_fechas'];
            // Se agrega esta validación para armar el ID de Cluster en caso necesario

            $desarrollo_id = "";
            $this->set('seleccion_desarrollo',$this->request->data['Desarrollo']['desarrollo_id']);
            if (substr($this->request->data['Desarrollo']['desarrollo_id'],0,1)=="D"){//Solo seleccionan un desarrollo
                $desarrollo_id = substr($this->request->data['Desarrollo']['desarrollo_id'],1);
                $desarrollo    = $this->Desarrollo->read(null,$desarrollo_id);
                $this->set('desarrollo',$desarrollo);
            }else{
                $this->loadModel('Cluster');
                $this->Cluster->Behaviors->load('Containable');
                $cluster = $this->Cluster->find(
                    'first',
                    array(
                        'conditions'=>array(
                            'Cluster.id'=>substr($this->request->data['Desarrollo']['desarrollo_id'],1)
                        ),
                        'fields'=>array(
                            'id','nombre'
                        ),
                        'contain'=>array(
                            'Desarrollos'=>array(
                                'fields'=>array(
                                    'id','nombre'
                                )
                            )
                        )

                    )
                );
                $desarrollo_str = '';
                foreach($cluster['Desarrollos'] as $desarrollo):
                    $desarrollo_str =$desarrollo_str.$desarrollo['id'].",";
                endforeach;

                $desarrollo_id = substr($desarrollo_str,0,-1);
                $this->set('cluster',$cluster);
            }


            $fecha_ini     = substr($rango, 0,10).' 00:00:00';
            $fecha_fin     = substr($rango, -10).' 23:59:59';
            $fi            = date('Y-m-d',  strtotime($fecha_ini));
            $ff            = date('Y-m-d',  strtotime($fecha_fin));
            $periodo_reporte     = utf8_encode(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_ini)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_fin)))));
            //$periodo_reporte = date('d/M/Y',strtotime($fecha_ini))." al ".date('d/M/Y',strtotime($fecha_fin));
            $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_ini)).' AL '.date('d-m-Y', strtotime($fecha_fin));
            $fecha_final = $ff;

            $this->set('fi',$fi);
            $this->set('ff',$ff);

            //Variables para calculo de valor de desarrollo
            //$this->set('valor_desarrollo',$this->Desarrollo->query("SELECT SUM(precio) AS valor FROM inmuebles WHERE id IN(SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)"));

            //Variables para los eventos del desarrollo
            // $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id IN ('.$desarrollo_id.')','Cliente.created >='=>$fi,'Cliente.created <='=>$ff))));
            
            ///
            // $visitas_roberto=$this->User->query("SELECT COUNT(*) AS visitas 
            // FROM events, clientes, dic_linea_contactos 
            // WHERE events.cuenta_id = 7 
            // AND tipo_tarea = 1 
            // AND events.desarrollo_id IN (124) 
            // AND clientes.id = events.cliente_id 
            // AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  
            // AND dic_linea_contacto_id IS NOT NULL 
            // AND  events.fecha_inicio >= '2016-10-01 00:00:00' 
            // AND  events.fecha_inicio <= '2022-03-01 23:59:59'");
            // $this->set(compact('visitas_roberto'));
            //

            $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id IN ('.$desarrollo_id.')','Lead.fecha >='=>$fi,'Lead.fecha <='=>$ff,'Lead.dic_linea_contacto_id IS NOT NULL'))));
            $this->set('citas',$this->Event->find('count',array('conditions'=>array('OR'=>array("Event.desarrollo_id IN(".$desarrollo_id.")" , "Event.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN (".$desarrollo_id."))"),'Event.tipo_tarea'=> 0, 'DATE(Event.fecha_inicio) >=' => $fi, 'DATE(Event.fecha_inicio) <=' => $ff))));
            
            // KPI visitas
            $this->set('visitas',$this->Event->find('count',array('conditions'=>array('OR'=>array("Event.desarrollo_id IN(".$desarrollo_id.")", "Event.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN (".$desarrollo_id."))"),'Event.tipo_tarea'=> 1 ,'DATE(Event.fecha_inicio) >=' => $fi, 'DATE(Event.fecha_inicio) <=' => $ff))));

            $this->set('mails',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id IN ('.$desarrollo_id.')','LogDesarrollo.accion'=>5 ,'LogDesarrollo.fecha >='=>$fi, 'LogDesarrollo.fecha <='=>$ff))));
            $this->set('interesados_acumulados',$this->Lead->find('count',array('conditions'=>array('Lead.dic_linea_contacto_id IS NOT NULL','Lead.desarrollo_id IN ('.$desarrollo_id.')'))));
            $this->set('citas_acumuladas',$this->Event->find('count',array('conditions'=>array('OR'=>array("Event.desarrollo_id IN(".$desarrollo_id.")", "Event.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN (".$desarrollo_id."))"),'Event.tipo_tarea'=> 0,))));
            $this->set('visitas_acumuladas',$this->Event->find('count',array('conditions'=>array('OR'=>array("Event.desarrollo_id IN(".$desarrollo_id.")", "Event.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN (".$desarrollo_id."))"),'Event.tipo_tarea'=> 1,))));
            $this->set('mails_acumuladas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id IN ('.$desarrollo_id.')','LogDesarrollo.accion'=>5 ))));

            // Total de clientes
            $total_clientes_anuales = $this->User->query(
                "SELECT COUNT(*) as total_clientes_anuales
                FROM clientes 
                WHERE  desarrollo_id in ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL 
                AND created >= '$fi'
                AND created <= '$ff';"
            );
               // "SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL ) AND created >= '$fi' AND created <= '$ff'");
            // Clientes separados por estatus

            // Clientes separado por estatus.
            $clientes_anuales = $this->User->query(
                "SELECT COUNT(*) as total_clientes, clientes.`status` 
                FROM clientes 
                WHERE desarrollo_id IN ($desarrollo_id)
                AND dic_linea_contacto_id IS NOT NULL  
                AND created >= '$fi' 
                AND created <= '$ff'
                GROUP BY status;"
            );
                
            //"SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL ) AND created >= '$fi' AND created <= '$ff' GROUP BY status");


            /************************************************* Grafica de temperatura de clientes ********************************************************************/
            // Grafica de temperatura de clientes.
            $temperatura_clientes = $this->User->query(
                "SELECT count(*)as sumatorio ,etapa 
                FROM clientes 
                WHERE desarrollo_id IN ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL  
                AND created >= '".$fi."' 
                AND created <= '".$ff."' 
                AND status = 'Activo' 
                GROUP BY etapa;"
            );
                // "SELECT count(*)as sumatorio ,etapa 
                // FROM clientes 
                // WHERE  id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL ) 
                // AND created >= '".$fi."' 
                // AND created <= '".$ff."' 
                // AND status = 'Activo' 
                // GROUP BY etapa;");

            /************************************************* Grafica de Relación de Inactivación de Clientes ********************************************************************/
            //$temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' AND clientes.desarrollo_id = $desarrollo_id GROUP BY etapa;");

            //$inactivos_definitivos_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Inactivo' AND clientes.id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND DATE(fecha) >= '".$fi."' AND DATE(fecha) <=  '".$ff."' AND dic_linea_contacto_id IS NOT NULL)) AND mensaje LIKE '%pasa a estatus inactivo definitivo por motivo:%'");
            $inactivos_definitivos_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) )  AND created >= '$fi' AND created <= '$ff' AND status = 'Inactivo') AND mensaje LIKE '%pasa a estatus inactivo definitivo por motivo:%' GROUP BY cliente_id");
            $inactivos_distribucion = array();
            foreach ($inactivos_definitivos_raw as $inactivo):
                $razon = explode(':',$inactivo['agendas']['mensaje'])[1];
                $valor = isset($inactivos_distribucion[$razon]) ? $inactivos_distribucion[$razon] :0;
                $inactivos_distribucion[$razon] = $valor +1;
            endforeach;
            $this->set(compact('inactivos_distribucion'));

            $inactivos_temporales_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) )  AND created >= '$fi' AND created <= '$ff' AND status = 'Inactivo Temporal') AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo:%' GROUP BY cliente_id");

            //$inactivos_temporales_raw = $this->Desarrollo->query("SELECT * FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Inactivo Temporal' AND clientes.id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND DATE(fecha) >= '".$fi."' AND DATE(fecha) <=  '".$ff."' AND dic_linea_contacto_id IS NOT NULL)) AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo:%'");
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


            /************************************************* Grafica de atencion de clientes ********************************************************************/

            //Indicador de clientes con estatus Oportunos
            $clientes_oportunos = $this->User->query(
                "SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status 
                FROM clientes
                WHERE desarrollo_id IN ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL  
                AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) 
                AND status = 'Activo' 
                AND created >= '$fi' 
                AND created <= '$ff'"
            );
                // "SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status 
                // FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL )  
                // AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) 
                // AND status = 'Activo' 
                // AND created >= '$fi' 
                // AND created <= '$ff'");

            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query(
                "SELECT count(*) as sumatorio,'Tardía (De ".($this->Session->read('Parametros.Paramconfig.sla_oportuna') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status 
                FROM clientes
                WHERE desarrollo_id IN ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL   
                AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) 
                AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) 
                AND status = 'Activo' 
                AND created >= '$fi' 
                AND created <= '$ff'"
            );
                // "SELECT count(*) as sumatorio,'Tardía (De ".($this->Session->read('Parametros.Paramconfig.sla_oportuna') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status 
                // FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL )  
                // AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) 
                // AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) 
                // AND status = 'Activo' 
                // AND created >= '$fi' 
                // AND created <= '$ff'");

            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query(
                "SELECT count(*) as sumatorio,'No atentidos (De ".($this->Session->read('Parametros.Paramconfig.sla_atrasados') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status 
                FROM clientes
                WHERE desarrollo_id IN ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL 
                AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) 
                AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) 
                AND status = 'Activo' 
                AND created >= '$fi' 
                AND created <= '$ff'"
            );
                // "SELECT count(*) as sumatorio,'No atentidos (De ".($this->Session->read('Parametros.Paramconfig.sla_atrasados') + 1)." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status 
                // FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL) 
                // AND last_edit >= DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) 
                // AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) 
                // AND status = 'Activo' 
                // AND created >= '$fi' 
                // AND created <= '$ff'");

            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query(
                "SELECT count(*) as sumatorio,'Por Reasignar (+".($this->Session->read('Parametros.Paramconfig.sla_no_atendidos') + 1)." sin atención)' as status 
                FROM clientes
                WHERE desarrollo_id IN ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL   
                AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) 
                AND status = 'Activo' 
                AND created >= '$fi' 
                AND created <= '$ff'"
            );
                // "SELECT count(*) as sumatorio,'Por Reasignar (+".($this->Session->read('Parametros.Paramconfig.sla_no_atendidos') + 1)." sin atención)' as status 
                // FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL )  
                // AND last_edit < DATE_SUB('".date("Y-m-d")."',INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) 
                // AND status = 'Activo' 
                // AND created >= '$fi' 
                // AND created <= '$ff'");

            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query(
                "SELECT count(*) as sumatorio,'Sin Asignar' as status 
                FROM clientes
                WHERE desarrollo_id IN ($desarrollo_id) 
                AND dic_linea_contacto_id IS NOT NULL  
                AND status = 'Activo' 
                AND last_edit IS NULL 
                AND created >= '$fi' 
                AND created <= '$ff'"
            );
                // "SELECT count(*) as sumatorio,'Sin Asignar' as status 
                // FROM clientes WHERE id IN (SELECT cliente_id FROM leads WHERE desarrollo_id IN ($desarrollo_id) AND dic_linea_contacto_id IS NOT NULL )  
                // AND status = 'Activo' 
                // AND last_edit IS NULL 
                // AND created >= '$fi' 
                // AND created <= '$ff'");

            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            //roberto
            $clientes_lineas = $this->User->query(
                "SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal
                FROM leads, dic_linea_contactos 
                WHERE leads.cliente_id IN (SELECT id FROM clientes WHERE clientes.cuenta_id = $cuenta_id) 
                AND leads.desarrollo_id IN ($desarrollo_id) 
                AND leads.dic_linea_contacto_id IS NOT NULL 
                AND leads.fecha >= '$fi' AND leads.fecha <= '$ff' 
                AND leads.dic_linea_contacto_id = dic_linea_contactos.id 
                GROUP BY canal 
                ORDER BY dic_linea_contactos.linea_contacto;"
                );

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

            /************************************************* Grafica de ventas vs metas mensuales *****************************************************************************/
            $periodos = $this->getPeriodosArreglo($fi,$ff);
            $kpi_arreglo = array();
            foreach($periodos as $key=>$periodo){
                $monto = $this->User->query("SELECT SUM(monto),SUM(unidades) FROM objetivos_ventas_desarrollos WHERE fecha <= '".$key."-01' AND fin >= '".$key."-31' AND desarrollo_id = $desarrollo_id");
                $ventas = $this->User->query("SELECT COUNT(*),SUM(precio_cerrado) FROM ventas WHERE fecha >= '".$key."-01' AND fecha <= '".$key."-31' AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)");
                $kpi_arreglo[$key]['periodo'] = $periodo;
                $kpi_arreglo[$key]['objetivo_monto'] = $monto[0][0]['SUM(monto)']==NULL ? 0 : $monto[0][0]['SUM(monto)'];
                $kpi_arreglo[$key]['objetivo_q'] = $monto[0][0]['SUM(unidades)']==NULL ? 0 : $monto[0][0]['SUM(unidades)'];
                $kpi_arreglo[$key]['ventas_q'] = $ventas[0][0]['COUNT(*)']==NULL ? 0 : $ventas[0][0]['COUNT(*)'];
                $kpi_arreglo[$key]['ventas_monto'] = $ventas[0][0]['SUM(precio_cerrado)']==NULL ? 0 : $ventas[0][0]['SUM(precio_cerrado)'];
            }

            $this->set('kpi_arreglo',$kpi_arreglo);

            /************************************************* Grafica de ventas por unidades vs ventas por monto*****************************************************************/
            $meses_array = array();
            foreach($periodos as $key=>$periodo){
                $visitas_por_periodo = $this->Desarrollo->query("SELECT	COUNT(*) AS visitas FROM events WHERE  tipo_tarea = 1 AND events.desarrollo_id IN($desarrollo_id) AND fecha_inicio >= '".$key."-01' AND fecha_inicio <= '".$key."-31'");
                $meses_array[$key]['periodo'] = $periodo;
                $meses_array[$key]['venta_mes_q'] = $kpi_arreglo[$key]['ventas_q'];
                $meses_array[$key]['visitas'] = $visitas_por_periodo[0][0]['visitas']==NULL ? 0 : $visitas_por_periodo[0][0]['visitas'];
            }
            $this->set('ventas_vs_visitas',$meses_array);

            /************************************************* Grafica de visitas con linea de contacto (Acumulado) *****************************************************************/
            //$clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            //$total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $visitas_linea_contacto = $this->User->query(
                "SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal 
                FROM events, clientes, dic_linea_contactos 
                WHERE events.cuenta_id = $cuenta_id 
                AND tipo_tarea = 1 
                AND events.desarrollo_id IN ($desarrollo_id) 
                AND clientes.id = events.cliente_id 
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio <= '$ff' 
                GROUP BY canal 
                ORDER BY dic_linea_contactos.linea_contacto;"
                );

            $visitas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id IN($desarrollo_id) AND publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id)) AND
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
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id)) AND
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
            $this->Venta->Behaviors->load('Containable');
            $lista_ventas = $this->Venta->find(
                'all',
                array(
                    'order'=>'Venta.fecha ASC',
                    'fields'=>array(
                        'id','tipo_operacion','cliente_id','fecha','precio_cerrado','inmueble_id'
                    ),
                    'contain'=>array(
                        'Inmueble'=>array(
                            'fields'=>array(
                                'titulo','id'
                            )
                        ),
                        'Cliente'=>array(
                            'fields'=>array(
                                'nombre','id','dic_linea_contacto_id'
                            ),
                            'DicLineaContacto'=>array(
                                'fields'=>array(
                                    'id','linea_contacto'
                                )
                            )
                        )
                    ),
                    'recursive'=>2,
                    'conditions'=>array(
                        'Venta.fecha >=' => $fi,
                        'Venta.fecha <='=> $ff,
                        "Venta.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id))"
                    )
                )
            );

            /************************************************* Histórico en publicidad por medio*************************************************************/
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id IN($desarrollo_id) AND fecha_inicio <= '$ff' AND fecha_inicio >= '$fi' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

            //echo $q_inversion_publicidad;

            $this->set(compact('inversion_publicidad'));
            $this->set('periodo_tiempo_mes',$periodo_tiempo);

            $n_bloqueadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 0;");

            $n_liberadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 1;");

            $n_recervadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 2;");

            $n_contrato_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 3;");

            $n_escrituracion_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 4;");

            $n_baja_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 5;");


            $clientes_asignados = $this->Desarrollo->query("SELECT COUNT(*) AS n_clientes FROM clientes WHERE clientes.desarrollo_id IN ($desarrollo_id);");


            /************************************************* Grafica de Relación de Cancelación de Citas ********************************************************************/

            $cancelaciones_raw = $this->Desarrollo->query("SELECT motivo_cancelacion, COUNT(*) AS sumatoria FROM events WHERE  desarrollo_id IN ($desarrollo_id ) AND motivo_cancelacion IS NOT NULL  AND fecha_inicio >= '$fi' AND fecha_inicio <= '$ff'  GROUP BY motivo_cancelacion");

            $this->set(compact('cancelaciones_raw'));


            // Variables globales
            $this->set(compact('cuenta_id'));
            $this->set(compact('date_current'));
            $this->set(compact('lista_ventas'));
            $this->set(compact('fecha_inicio'));
            $this->set(compact('fecha_final'));
            $this->set(compact('periodo_tiempo'));

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

            //  Variables para los kpis
            //$this->set( compact('interesados_acumulados', 'visitas_acumuladas', 'citas_acumuladas', 'mails_acumuladas'));

        }

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

        $this->loadModel('Cluster');
        $this->set(
            'clusters',
            $this->Cluster->find(
                'list',
                array(
                    'conditions'=>array(
                        'Cluster.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                    )
                )
            )
        );

    }
   
    public function print_d1($fi = null, $ff=null, $seleccion_desarrollo = null){
            $this->layout = 'print';
            $cuenta_id    = $this->Session->read('CuentaUsuario.Cuenta.id');
            $date_current = date('Y-m-d');
            $lista_ventas = [];
            $asesor       = 0;
            $fecha_inicio = date('Y-01-01');
            $fecha_final  = date('Y-m-d');
            $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_inicio)).' AL '.date('d-m-Y', strtotime($fecha_final));
            $periodo_reporte     = ucwords(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_inicio)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_final)))));
            //$periodo_reporte = date('d/M/Y',strtotime($fecha_inicio))." al ".date('d/M/Y',strtotime($fecha_final));

            $interesados_acumulados = 0;
            $visitas_acumuladas     = 0;
            $citas_acumuladas       = 0;
            $mails_acumuladas       = 0;

            $this->loadModel('Event');

            $desarrollo_id = "";
            if (substr($seleccion_desarrollo,0,1)=="D"){//Solo seleccionan un desarrollo
                $desarrollo_id = substr($seleccion_desarrollo,1);
                $desarrollo    = $this->Desarrollo->read(null,$desarrollo_id);
                $this->set('desarrollo',$desarrollo);
            }else{
                $this->loadModel('Cluster');
                $this->Cluster->Behaviors->load('Containable');
                $cluster = $this->Cluster->find(
                    'first',
                    array(
                        'conditions'=>array(
                            'Cluster.id'=>substr($seleccion_desarrollo,1)
                        ),
                        'fields'=>array(
                            'id','nombre'
                        ),
                        'contain'=>array(
                            'Desarrollos'=>array(
                                'fields'=>array(
                                    'id','nombre'
                                )
                            )
                        )
                        
                    )
                );
                $desarrollo_str = '';
                foreach($cluster['Desarrollos'] as $desarrollo):
                    $desarrollo_str =$desarrollo_str.$desarrollo['id'].",";
                endforeach;

                $desarrollo_id = substr($desarrollo_str,0,-1);
                $this->set('cluster',$cluster);
            }

            
            $fecha_ini     = $fi.' 00:00:00';
            $fecha_fin     = $ff.' 23:59:59';
            $fi            = date('Y-m-d',  strtotime($fi));
            $ff            = date('Y-m-d',  strtotime($ff));
            $periodo_reporte     = utf8_encode(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_ini)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fecha_fin)))));
            //$periodo_reporte = date('d/M/Y',strtotime($fecha_ini))." al ".date('d/M/Y',strtotime($fecha_fin));
            $periodo_tiempo = 'INFORMACIÓN DE LOS CLIENTES DEL '.date('d-m-Y', strtotime($fecha_ini)).' AL '.date('d-m-Y', strtotime($fecha_fin));
            $fecha_final = $ff;

            //Variables para calculo de valor de desarrollo
            //$this->set('valor_desarrollo',$this->Desarrollo->query("SELECT SUM(precio) AS valor FROM inmuebles WHERE id IN(SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)"));            
            
            //Variables para los eventos del desarrollo
            $this->set('interesados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id IN ('.$desarrollo_id.')','Cliente.created >='=>$fi,'Cliente.created <='=>$ff))));
            $this->set('citas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id IN ('.$desarrollo_id.')','LogDesarrollo.accion'=>6,'LogDesarrollo.fecha >='=>$fi, 'LogDesarrollo.fecha <='=>$ff))));
            $this->set('mails',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id IN ('.$desarrollo_id.')','LogDesarrollo.accion'=>5 ,'LogDesarrollo.fecha >='=>$fi, 'LogDesarrollo.fecha <='=>$ff))));
            $this->set('visitas',$this->Event->find('count',array('conditions'=>array('Event.desarrollo_id IN ('.$desarrollo_id.')','Event.tipo_tarea'=> 1, 'Event.fecha_inicio >=' => $fi, 'Event.fecha_inicio <='=>$ff))));
            
            $this->set('interesados_acumulados',$this->Lead->find('count',array('conditions'=>array('Lead.desarrollo_id IN ('.$desarrollo_id.')'))));
            $this->set('citas_acumuladas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id IN ('.$desarrollo_id.')','LogDesarrollo.accion'=>6,))));
            $this->set('mails_acumuladas',$this->LogDesarrollo->find('count',array('conditions'=>array('LogDesarrollo.desarrollo_id IN ('.$desarrollo_id.')','LogDesarrollo.accion'=>5 ))));
            $this->set('visitas_acumuladas',$this->Event->find('count',array('conditions'=>array('Event.desarrollo_id IN ('.$desarrollo_id.')','Event.tipo_tarea'=> 1))));
            
            // Total de clientes
            $total_clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes_anuales FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id) ");
            // Clientes separados por estatus
            $clientes_anuales = $this->User->query("SELECT COUNT(*) as total_clientes, clientes.`status` FROM clientes WHERE cuenta_id = $cuenta_id AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id) GROUP BY status");

            /************************************************* Grafica de temperatura de clientes ********************************************************************/
            $temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' AND clientes.desarrollo_id IN ($desarrollo_id) GROUP BY etapa;");

            /************************************************* Grafica de Relación de Inactivación de Clientes ********************************************************************/
            //$temperatura_clientes = $this->User->query("SELECT count(*)as sumatorio ,etapa FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <= '".$ff."' AND status = 'Activo' AND clientes.desarrollo_id = $desarrollo_id GROUP BY etapa;");

            $op_uno = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No le interesa ninguna de las propiedades%'");

            $op_dos = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No responde correo ni tel%'");

            $op_tres = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: Compr%'");

            $op_cuatro = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: Declin%'");

            $op_cinco = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: Cliente Molesto por falta de seguimiento%'");

            $op_seis = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No tiene presupuesto%'");

            $op_siete = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT cliente_id FROM leads, clientes WHERE fecha >= '".$fi."' AND fecha <= '".$ff."' AND clientes.status = 'Inactivo' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus baja definitva por motivo: No solicit%'");
            
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

            // Se agregan las razones de inactivación temporal
            $op_uno_temporal = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo: Solicit%'");
            $op_dos_temporal = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo: Le interesa comprar%'");
            $op_tres_temporal = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo: Debe consultar con sus familiares%'");
            $op_cuatro_temporal = $this->Desarrollo->query("SELECT COUNT(*) FROM agendas WHERE cliente_id IN (SELECT id FROM clientes WHERE cuenta_id = ".$cuenta_id." AND created >= '".$fi."' AND created <=  '".$ff."' AND status = 'Inactivo temporal' AND clientes.desarrollo_id IN ($desarrollo_id)) AND mensaje LIKE '%pasa a estatus inactivo temporal por motivo: Sale de viaje, a su regreso%'");

            // $op_uno_temporal[0][0]['COUNT(*)'] = 1;
            // $op_dos_temporal[0][0]['COUNT(*)'] = 2;
            // $op_tres_temporal[0][0]['COUNT(*)'] = 3;
            // $op_cuatro_temporal[0][0]['COUNT(*)'] = 4;

            
            $inactivos_temporal_distribucion = array();
                $inactivos_temporal_distribucion[0] = array(
                    'label' => 'Solicitó contactarlo tiempo después',
                    'cantidad'=> $op_uno_temporal[0][0]['COUNT(*)']
                );
                $inactivos_temporal_distribucion[1] = array(
                    'label' => 'Le interesa comprar /rentar pero va a postergar la decisión.',
                    'cantidad'=> $op_dos_temporal[0][0]['COUNT(*)']
                );
                $inactivos_temporal_distribucion[2] = array(
                    'label' => 'Debe consultar con sus familiares, define después',
                    'cantidad'=> $op_tres_temporal[0][0]['COUNT(*)']
                );
                $inactivos_temporal_distribucion[3] = array(
                    'label' => 'Sale de viaje, a su regreso pidió contactarlo.',
                    'cantidad'=> $op_cuatro_temporal[0][0]['COUNT(*)']
                );
                
            $this->set(compact('inactivos_temporal_distribucion'));


            /************************************************* Grafica de atencion de clientes ********************************************************************/

            //Indicador de clientes con estatus Oportunos
            $clientes_oportunos = $this->User->query("SELECT count(*) as sumatorio,'Oportuna (De 1 a ".$this->Session->read('Parametros.Paramconfig.sla_oportuna').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id)");
                
            //Indicador de clientes con estatus Oportunos tardíos
            $clientes_tardia = $this->User->query("SELECT count(*) as sumatorio,'Tardía (De ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." a ".$this->Session->read('Parametros.Paramconfig.sla_atrasados').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_oportuna')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id)");
            
            //Indicador de clientes con estatus Seguimiento Atrasado
            $clientes_atrasados = $this->User->query("SELECT count(*) as sumatorio,'No Antenidos (De ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." a ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos').")' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit >= DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_atrasados')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id)");
            
            //Indicador de clientes con estatus Por Reasignar
            $clientes_reasignar = $this->User->query("SELECT count(*) as sumatorio,'Por Reasignar (+".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." sin atención)' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND last_edit < DATE_SUB(CURDATE(),INTERVAL ".$this->Session->read('Parametros.Paramconfig.sla_no_atendidos')." DAY) AND status = 'Activo' AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id)");
            
            //Indicador de clientes con estatus Sin Seguimiento
            $clientes_sin_seguimiento = $this->User->query("SELECT count(*) as sumatorio,'Sin asginar' as status FROM clientes WHERE cuenta_id = ".$cuenta_id." AND status = 'Activo' AND last_edit IS NULL AND created >= '$fi' AND created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id)");

            // Suma de los clientes de atencion
            $sum_clientes_atencion = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_atrasados[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + $clientes_sin_seguimiento[0][0]['sumatorio'];

            /************************************************* Grafica de clientes con linea de contacto ********************************************************************/
            $clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id AND clientes.desarrollo_id IN ($desarrollo_id) GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            $total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND clientes.created >= '$fi' AND clientes.created <= '$ff' AND clientes.desarrollo_id IN ($desarrollo_id) AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $venta_linea_contacto = $this->User->query("SELECT COUNT(ventas.precio_cerrado) AS ventas, dic_linea_contactos.linea_contacto AS canal FROM ventas, clientes, dic_linea_contactos WHERE ventas.cuenta_id = $cuenta_id AND clientes.id = ventas.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  ventas.fecha >= '$fi' AND  ventas.fecha <= '$ff' AND ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollo_id)) GROUP BY dic_linea_contactos.id ORDER BY dic_linea_contactos.linea_contacto;");
    
            $ventas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id IN ($desarrollo_id) AND publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
            if (isset($ventas_vs_metas[0][0]['objetivo_ventas'])){
                $kpi_inicial = $ventas_vs_metas[0][0]['objetivo_ventas'];
            }else{
                $kpi_query=$this->Desarrollo->query("SELECT unidades FROM objetivos_ventas_desarrollos WHERE desarrollo_id IN($desarrollo_id)");
                $kpi_inicial = $kpi_query[0]['objetivos_ventas_desarrollos']['unidades'];
            }
            
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

            if (isset($ventas_vs_metas_2[0][0]['objetivo_ventas'])){
                $kpi_inicial_2 = $ventas_vs_metas_2[0][0]['objetivo_ventas'];
            }else{
                $kpi_query=$this->Desarrollo->query("SELECT monto FROM objetivos_ventas_desarrollos WHERE desarrollo_id IN($desarrollo_id)");
                $kpi_inicial_2 = $kpi_query[0]['objetivos_ventas_desarrollos']['monto'];
            }

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

            // Variable para generar cada mes independiente de si hay ventas o no
            // $ventas_mensuales = array();
            // $mes_inicial = date("Y-m",strtotime('-1 year'));
            // for($i=0;$i<13;$i++){
            //     $ventas_mensuales[$i]['periodo_tiempo'] = $mes_inicial;
            //     for($j=0; $j<sizeof($ventas_vs_metas); $j++){
            //         if ($j>0){        
            //             if ($mes_inicial == $ventas_vs_metas[$j][0]['periodo']){
            //                 $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
            //                 $ventas_mensuales[$i]['ventas'] = $ventas_vs_metas[$j][0]['venta_mes'];
            //             }
            //             else if ($mes_inicial > $ventas_vs_metas[$j-1][0]['periodo'] && $mes_inicial < $ventas_vs_metas[$j][0]['periodo']){
            //                 $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j-1][0]['objetivo_ventas'];
            //                 $ventas_mensuales[$i]['ventas'] = 0;    
            //             }
            //             else if ($mes_inicial > $ventas_vs_metas[$j][0]['periodo']){
            //                 $ventas_mensuales[$i]['kpi']=$ventas_vs_metas[$j][0]['objetivo_ventas'];
            //                 $ventas_mensuales[$i]['ventas'] = 0;   
            //             }
            //         }
            //     }
            //     $mes_inicial = date("Y-m",strtotime($mes_inicial."+1 month"));            
            // }
            // $this->set(compact('ventas_mensuales'));

            /************************************************* Grafica de ventas por unidades vs ventas por monto*****************************************************************/
            //Esta gráfica es dependiente de la de arriba y no puede existir sola. A menos que se descomente la siguiente sección

            // $query = "SELECT 
            // COUNT(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
            // IFNULL((SELECT unidades FROM objetivos_ventas_desarrollos WHERE fecha < DATE(CONCAT(periodo,'-01')) AND fin > DATE(CONCAT(periodo,'-01')) AND desarrollo_id = $desarrollo_id),1) AS objetivo_ventas
            //     FROM 
            //         ventas
            //     WHERE 
            //         ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
            //         ventas.fecha <= '$ff' AND
            //         ventas.fecha >= '$fi'
            //     GROUP BY periodo
            //     ORDER BY periodo";
        
            // $ventas_vs_metas = $this->Desarrollo->query($query);
            // //Armar el arreglo para poder consultarlo con únicamente las ventas
            // $arreglo_ventas = array();
            // foreach($ventas_vs_metas as $venta):
            //     $arreglo_ventas[$venta[0]['periodo']]['objetivo_ventas']=$venta[0]['objetivo_ventas'];
            //     $arreglo_ventas[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
            // endforeach;
            // $kpi_inicial = $ventas_vs_metas[0][0]['objetivo_ventas'];
            // // Variables de ventas vs metas por mes.
            // //$this->set(compact('arreglo_ventas'));
            // //$this->set(compact('ventas_vs_metas'));

            // $intervalo_meses = abs(strtotime($fi)-strtotime($ff));
            // $meses = floor($intervalo_meses/60/60/24/30);
            // $this->set('meses',$meses);
            // $meses_array = array();
            // $primer_mes = date('m',strtotime($fi));
            // $primer_anio = date('Y',strtotime($fi));
            // for($i=0;$i<$meses; $i++){
            //     $periodo = $primer_anio."-".str_pad($primer_mes, 2, '0', STR_PAD_LEFT);
            //     $meses_array[$i][0]['objetivo_ventas'] = isset($arreglo_ventas[$periodo]['objetivo_ventas'])?$arreglo_ventas[$periodo]['objetivo_ventas']:$kpi_inicial;
            //     if(isset($arreglo_ventas[$periodo]['objetivo_ventas'])){
            //         $kpi_inicial = $arreglo_ventas[$periodo]['objetivo_ventas'];
            //     }
            //     $meses_array[$i][0]['periodo'] = $periodo;
            //     $meses_array[$i][0]['venta_mes'] = isset($arreglo_ventas[$periodo]['venta_mes'])?$arreglo_ventas[$periodo]['venta_mes']:0;
            //     $primer_mes++;
            //     if ($primer_mes == 13){
            //         $primer_mes = 1;
            //         $primer_anio ++;
            //     }
            // }
            // $this->set('ventas_vs_metas',$meses_array);

            // //SACAR EL OBJETIVO DE VENTAS EN MONTO

            // $query2 = "SELECT 
            // SUM(ventas.precio_cerrado) AS venta_mes, CONCAT(YEAR(ventas.fecha),'-',LPAD(MONTH(ventas.fecha),2,'0')) AS periodo,
            // IFNULL((SELECT monto FROM objetivos_ventas_desarrollos WHERE fecha < DATE(CONCAT(periodo,'-01')) AND fin > DATE(CONCAT(periodo,'-01')) AND desarrollo_id = $desarrollo_id),1) AS objetivo_ventas
            //     FROM 
            //         ventas
            //     WHERE 
            //         ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id) AND
            //         ventas.fecha <= '$ff' AND
            //         ventas.fecha >= '$fi'
            //     GROUP BY periodo
            //     ORDER BY periodo";
        
            // $ventas_vs_metas_2 = $this->Desarrollo->query($query2);
            // //Armar el arreglo para poder consultarlo con únicamente las ventas
            // $arreglo_ventas_2 = array();
            // foreach($ventas_vs_metas_2 as $venta):
            //     $arreglo_ventas_2[$venta[0]['periodo']]['objetivo_ventas']=$venta[0]['objetivo_ventas'];
            //     $arreglo_ventas_2[$venta[0]['periodo']]['venta_mes']=$venta[0]['venta_mes'];
            // endforeach;
            // $kpi_inicial_2 = $ventas_vs_metas_2[0][0]['objetivo_ventas'];
            // // Variables de ventas vs metas por mes.
            // //$this->set(compact('arreglo_ventas_2'));
            // //$this->set(compact('ventas_vs_metas'));

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
            

            /************************************************* Grafica de ventas por unidades vs ventas por monto*****************************************************************/

            $visitas_por_periodo = $this->Desarrollo->query("SELECT	COUNT(*) AS visitas, CONCAT(YEAR(events.fecha_inicio),'-',LPAD(MONTH(events.fecha_inicio),2,'0')) AS periodo FROM events WHERE  tipo_tarea = 1 AND events.desarrollo_id IN($desarrollo_id) AND events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY periodo;");
            $visitas_periodo = array();
            foreach($visitas_por_periodo as $periodo):
                $visitas_periodo[$periodo[0]['periodo']] = $periodo[0]['visitas'];
            endforeach;
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
                $meses_array[$i][0]['visitas'] = isset($visitas_periodo[$periodo])?$visitas_periodo[$periodo]:0;
                $primer_mes++;
                if ($primer_mes == 13){
                    $primer_mes = 1;
                    $primer_anio ++;
                }
            }
            $this->set('ventas_vs_visitas',$meses_array);

            /************************************************* Grafica de visitas con linea de contacto (Acumulado) *****************************************************************/
            //$clientes_lineas = $this->User->query("SELECT COUNT(*) AS registros, dic_linea_contactos.linea_contacto AS canal FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto; ");

            //$total_clientes_lineas = $this->User->query("SELECT COUNT(*) AS total_registros FROM clientes, dic_linea_contactos WHERE clientes.cuenta_id = $cuenta_id AND user_id IS NOT NULL AND clientes.created >= '$fecha_inicio' AND clientes.created <= '$fecha_final' AND clientes.dic_linea_contacto_id = dic_linea_contactos.id; ");

            $visitas_linea_contacto = $this->User->query("SELECT COUNT(*) AS visitas, dic_linea_contactos.linea_contacto AS canal FROM events, clientes, dic_linea_contactos WHERE events.cuenta_id = $cuenta_id AND tipo_tarea = 1 AND events.desarrollo_id IN ($desarrollo_id) AND clientes.id = events.cliente_id AND dic_linea_contactos.id = clientes.dic_linea_contacto_id  AND  events.fecha_inicio >= '$fi' AND  events.fecha_inicio <= '$ff' GROUP BY canal ORDER BY dic_linea_contactos.linea_contacto;");

            $visitas_linea_contacto_arreglo = array();
            $i=0;

            //Para el acumulado de inversión
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id IN($desarrollo_id) AND publicidads.fecha_inicio >= '$fi' AND  publicidads.fecha_inicio <= '$ff' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
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
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id)) AND
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
                        ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id)) AND
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
            $lista_ventas = $this->Venta->find('all',array('conditions'=>array("Venta.fecha >=" => $fi, "Venta.fecha <="=> $ff, "Venta.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN($desarrollo_id))")));

            /************************************************* Histórico en publicidad por medio*************************************************************/
            $q_inversion_publicidad = "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto FROM publicidads, dic_linea_contactos WHERE desarrollo_id IN($desarrollo_id) AND fecha_inicio <= '$ff' AND fecha_inicio >= '$fi' AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id GROUP BY linea_contacto;";
            $inversion_publicidad = $this->Desarrollo->query($q_inversion_publicidad);

            //echo $q_inversion_publicidad;
            
            $this->set(compact('inversion_publicidad'));
            $this->set('periodo_tiempo_mes',$periodo_tiempo);

            $n_bloqueadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 0;");

            $n_liberadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 1;");

            $n_recervadas_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 2;");

            $n_contrato_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 3;");

            $n_escrituracion_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 4;");

            $n_baja_precios = $this->Desarrollo->query("SELECT COUNT(inmuebles.id) AS n_inmuebles, SUM(inmuebles.precio) AS total_inmuebles FROM inmuebles WHERE inmuebles.id IN ( SELECT desarrollo_inmuebles.inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_inmuebles.desarrollo_id IN ($desarrollo_id)) AND inmuebles.liberada = 5;");

            
            $clientes_asignados = $this->Desarrollo->query("SELECT COUNT(*) AS n_clientes FROM clientes WHERE clientes.desarrollo_id IN ($desarrollo_id);");


            // Variables globales
            $this->set(compact('cuenta_id'));
            $this->set(compact('date_current'));
            $this->set(compact('lista_ventas'));
            $this->set(compact('fecha_inicio'));
            $this->set(compact('fecha_final'));
            $this->set(compact('periodo_tiempo'));
            
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

            //  Variables para los kpis
            //$this->set( compact('interesados_acumulados', 'visitas_acumuladas', 'citas_acumuladas', 'mails_acumuladas'));

        

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

        $this->loadModel('Cluster');
        $this->set(
            'clusters',
            $this->Cluster->find(
                'list',
                array(
                    'conditions'=>array(
                        'Cluster.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')
                    )
                )
            )
        );

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










	public function get_desarrollos( $cuenta_id = null, $user_id = null ){
        $this->Desarrollo->Behaviors->load('Containable');
        $this->User->Behaviors->load('Containable');

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
       $this->autoRender = false; 

   }



    public function get_desarrollos_detalle( $desarrollo_id = null ){
        $this->loadModel('OperacionesInmueble');
        $this->OperacionesInmueble->Behaviors->load('Containable');
        $this->Desarrollo->Behaviors->load('Containable');

        $limpieza            = array("'", ",", '"', "\n", " \t.", "\x0B", "\r", "\0", "&nbsp;");
        $this->layout = null;

        $estatus_monto_unidades = array(
            'bloqueada' => array(
                'unidades' => 0,
                'monto' => 0
            ),
            'liberada' => array(
                'unidades' => 0,
                'monto' => 0
            ),
            'reservada' => array(
                'unidades' => 0,
                'monto' => 0
            ),
            'contrato' => array(
                'unidades' => 0,
                'monto' => 0
            ),
            'operacion' => array(
                'unidades' => 0,
                'monto' => 0
            ),
            'escrituradas' => array(
                'unidades' => 0,
                'monto' => 0
            ),
            'baja' => array(
                'unidades' => 0,
                'monto' => 0
            )
        );

        $total_unidades = 0;
        
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
        $desarrollos= $this->OperacionesInmueble->find('all',
            array(
                'conditions' => array(
                    'OperacionesInmueble.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = '.$desarrollo_id.')',
                    'OperacionesInmueble.tipo_operacion' => 3,
                ),
                'fields' => array(
                    'precio_unidad',
                ),
                'contain' => false 
            )
        );
        $i=0;
            $unidades=0;
            foreach ($desarrollos as  $value) {
                $unidades++;
                $monto += $value['OperacionesInmueble']['precio_unidad'];
            }
            $ventasadryo[$i]['ventas_monto']=$monto;
            $ventasadryo[$i]['unidades']=$unidades;
        
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

        if( empty( $desarrollo['Desarrollo']['fecha_inicio_obra'] ) ){
            $desarrollo['Desarrollo']['fecha_inicio_obra'] = 'Sin fecha';
        }

        if( empty( $desarrollo['Desarrollo']['fecha_fin_obra'] ) ){
            $desarrollo['Desarrollo']['fecha_fin_obra'] = 'Sin fecha';
        }

        if( empty( $desarrollo['Desarrollo']['fecha_real_fin_obra'] ) ){
            $desarrollo['Desarrollo']['fecha_real_fin_obra'] = 'Sin fecha';
        }

        if( empty( $desarrollo['Desarrollo']['fecha_inicio_escrituracion'] ) ){
            $desarrollo['Desarrollo']['fecha_inicio_escrituracion'] = 'Sin fecha';
        }

        if( empty( $desarrollo['Desarrollo']['fecha_comercializacion'] ) ){
            $desarrollo['Desarrollo']['fecha_comercializacion'] = 'Sin fecha';
        }

        // sacar las unidades y los montos de las unidades dentro del desarrollo.
        foreach( $desarrollo['Propiedades'] as $inmueble ){
            switch( $inmueble['liberada'] ){
                case 0:
                    $estatus_monto_unidades['bloqueada']['unidades'] = $estatus_monto_unidades['bloqueada']['unidades'] + 1;
                    $estatus_monto_unidades['bloqueada']['monto']    = $estatus_monto_unidades['bloqueada']['monto'] + $inmueble['precio'];
                    break;
                case 1:
                    $estatus_monto_unidades['liberada']['unidades'] = $estatus_monto_unidades['liberada']['unidades'] + 1;
                    $estatus_monto_unidades['liberada']['monto']    = $estatus_monto_unidades['liberada']['monto'] + $inmueble['precio'];
                    break;
                case 2:
                    $estatus_monto_unidades['reservada']['unidades'] = $estatus_monto_unidades['reservada']['unidades'] + 1;
                    $estatus_monto_unidades['reservada']['monto']    = $estatus_monto_unidades['reservada']['monto'] + $inmueble['precio'];
                    break;
                case 3:
                    $estatus_monto_unidades['contrato']['unidades'] = $estatus_monto_unidades['contrato']['unidades'] + 1;
                    $estatus_monto_unidades['contrato']['monto']    = $estatus_monto_unidades['contrato']['monto'] + $inmueble['precio_venta'];
                    break;
                case 4:
                    $estatus_monto_unidades['escrituradas']['unidades'] = $estatus_monto_unidades['escrituradas']['unidades'] + 1;
                    $estatus_monto_unidades['escrituradas']['monto']    = $estatus_monto_unidades['escrituradas']['monto'] + $inmueble['precio_venta'];
                    break;
                case 4:
                    $estatus_monto_unidades['baja']['unidades'] = $estatus_monto_unidades['baja']['unidades'] + 1;
                    $estatus_monto_unidades['baja']['monto']    = $estatus_monto_unidades['baja']['monto'] + $inmueble['precio'];
                    break;
            }
        }
        $estatus_monto_unidades['operacion']['monto']=$monto;
        $estatus_monto_unidades['operacion']['unidades']=$unidades;
        $desarrollo['estatus_monto_unidades'] = $estatus_monto_unidades;
        


        echo json_encode( $desarrollo, true );
        // echo "<pre>";
        //     print_r( $desarrollo );
        // echo "</pre>";
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


    public function get_listado_desarrollos_user( $user_id = null ) {
        $this->Desarrollo->Behaviors->load('Containable');
        $this->User->Behaviors->load('Containable');
        
        $desarrollos = [];
        $s           = 0;
        
        // Buscaremos los desarrollos que tengan como cliente el usuario.
        $condiciones = array( "Desarrollo.id IN (Select clientes.desarrollo_id from clientes where clientes.user_id = ".$user_id.")" );

        $db_desarrollos = $this->Desarrollo->find('all',array(
            'conditions' => $condiciones,
            'contain' => false,
            'recursive'=> -1,
            'fields' => array(
                'nombre',
                'id'
            ),
            'order' => array(
                'Desarrollo.nombre'
            )
        ));

        foreach( $db_desarrollos as $desarrollo ) {
            
            $desarrollos[$s] = array(
                'id'     => $desarrollo['Desarrollo']['id'],
                'nombre' => $desarrollo['Desarrollo']['nombre']
            );
            $s++;

        }

        echo json_encode( $desarrollos, true );
        $this->autoRender = false;
    }

    public function meta_vs_ventas( $data = null ){
        $fechainicial = new DateTime('2020-01-15');
        $fechafinal = new DateTime('2020-02-15');


        $diferencia = $fechainicial->diff($fechafinal);
        // $meses = ( $diferencia->y * 12 ) + $diferencia->m;
        $meses = ( $diferencia->days / 29.66) ;
        // $meses = ( $diferencia );

        print_r( number_format($meses, 0) );

        $this->autoRender = false;

    }

    /* -------------------------------------------------------------------------- */
    /*        Listado de desarrollos para agregar como leads en el cliente        */
    /* -------------------------------------------------------------------------- */
    public function list_desarrollos_for_lead(){
        $this->Desarrollo->Behaviors->load('Containable');
        
        header('Content-type: application/json charset=utf-8');

        if( $this->Session->read('Permisos.Group.dlcall') == 1 ){
            $condicions_desarrollo = array(
              'OR' => array(
                'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Desarrollo.cuenta_id'          => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              ), 
              'AND' => array(
                'Desarrollo.is_private' => 0
              )
            );
          }else {
            $condicions_desarrollo = array(
              'OR' => array(
                'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                'Desarrollo.cuenta_id'          => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
              ), 
              'AND' => array(
                'Desarrollo.visible'    => 1,
                'Desarrollo.is_private' => 0
              )
            );
        }
        
        $list_desarrollos = $this->Desarrollo->find('list',array('conditions'=> $condicions_desarrollo, 'fields' => array('id', 'nombre'), 'order' => array('Desarrollo.nombre' => 'ASC') ));

        echo json_encode( $list_desarrollos );
        $this->autoRender = false;
    }


    public function addExtra(){
        if($this->request->is('post')){
            $this->loadModel('ExtrasDesarrollo');
            if($this->ExtrasDesarrollo->save($this->request->data)){
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                if (isset($this->request->data['ExtrasDesarrollo']['id'])){
                    $this->Session->setFlash('Se ha modificado la propiedad extra al desarrollo.', 'default', array(), 'm_success'); // Mensaje
                }else{
                    $this->Session->setFlash('Se ha agregado la propiedad extra al desarrollo.', 'default', array(), 'm_success'); // Mensaje
                }
                return $this->redirect(array('controller'=>'desarrollos','action' => 'view',$this->request->data['ExtrasDesarrollo']['desarrollo_id']));
            }
        }
    }

    public function getExtra(){
        $this->loadModel('ExtrasDesarrollo');
        $this->ExtrasDesarrollo->Behaviors->load('Containable');
        $extra = $this->ExtrasDesarrollo->find(
            'first',
            array(
                'conditions'=>array(
                    'ExtrasDesarrollo.id'=>$this->request->data['id_extra']
                ),
                'contain'=>false
            )
        );
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($extra, true);
        exit();
        $this->autoRender = false;
    }

    function deleteExtra($id = null, $desarrollo_id = null){
        $this->loadModel('ExtrasDesarrollo');
        if (!$id) {
            $this->Session->setFlash(__('Entrega invalida', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->ExtrasDesarrollo->delete($id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash(__('El Extra ha sido eliminado exitosamente', true), 'default', array('class' => 'm_success'));
            $this->redirect(array('action' => 'view', 'controller' => 'desarrollos', $desarrollo_id));
        }
    }

    public function clusters(){

    }

    public function getMinMax($id){

        $minprecio= 0;
        $maxprecio= 0;

        $minm2= 0;
        $maxm2= 0;

        $minrecamaras= 1;
        $maxrecamaras= 1;
        
        $minbanios= 1;
        $maxbanios= 1;
        
        $minestacionamiento= 1;
        $maxestacionamiento= 1;
        $maxmin = $this->Desarrollo->query("SELECT di.desarrollo_id,
                    max(i.precio) AS precio_top, min(i.precio) AS precio_low,
                    max(i.construccion) AS m2_top, min(i.construccion) AS m2_low,
                    max(i.recamaras) as rec_top, min(i.recamaras) as rec_low,
                    max(i.banos) AS banio_top, min(i.banos) as banio_low,
                    max(i.estacionamiento_techado) as est_top, min(i.estacionamiento_techado)as est_low
                    FROM desarrollo_inmuebles AS di
                    LEFT JOIN inmuebles AS i
                    ON di.inmueble_id=i.id
                    WHERE desarrollo_id=$id AND liberada=1"
        );

         if (!empty($maxmin['0']['0']['precio_top'])) {
            $minprecio= $maxmin['0']['0']['precio_low'];
            $maxprecio= $maxmin['0']['0']['precio_top'];
        }
        

        if (!empty($maxmin['0']['0']['m2_top'])) {
            $minm2= $maxmin['0']['0']['m2_low'];
            $maxm2= $maxmin['0']['0']['m2_top'];
        }
        

        if (!empty($maxmin['0']['0']['rec_top'])) {
            $minrecamaras= $maxmin['0']['0']['rec_low'];
            $maxrecamaras= $maxmin['0']['0']['rec_top'];
            
        }
        
        if (!empty($maxmin['0']['0']['banio_top'])) {
           $minbanios= $maxmin['0']['0']['banio_low'];
           $maxbanios= $maxmin['0']['0']['banio_top'];
            
        }

        if (!empty($maxmin['0']['0']['est_top'])) {
            $minestacionamiento= $maxmin['0']['0']['est_low'];
            $maxestacionamiento= $maxmin['0']['0']['est_top'];
           
        }
        $this->User->query("UPDATE desarrollos
                            SET precio_low = $minprecio, precio_top = $maxprecio,
                                m2_low = $minm2, m2_top = $maxm2,
                                rec_low = $minrecamaras, rec_top= $maxrecamaras,
                                banio_low = $minbanios, banio_top= $maxbanios,
                                est_low = $minestacionamiento, est_top= $maxestacionamiento
                            WHERE id = $id");
        //return $maxmin;
        // echo json_encode( $maxmin , true );
        // exit();
        // $this->autoRender = false;
    }

    public function get_inmueble_desarrollo_detalle( $inmueble_id = null ){
        
        $desarrollo = $this->DesarrolloInmueble->find('first',
            array(
                'conditions' => array(
                    'inmueble_id' => $inmueble_id
                )
            )
        );
        
        $response['fecha_format']  = date('d-m-Y', strtotime($desarrollo['Desarrollos']['fecha_inicio_escrituracion']));
        $response['fecha']         = date('Y-m-d', strtotime($desarrollo['Desarrollos']['fecha_inicio_escrituracion']));
        $response['fecha_current'] = date('Y-m-d');

        echo json_encode( $response, true );
        
        // print_r( $desarrollo['Desarrollos'] );
        $this->autoRender = false;

    }
   
    public function get_planes_pago( $id ){
        $this->Desarrollo->Behaviors->load('Containable');
        $this->getMinMax($id);
    
        $desarrollo = $this->Desarrollo->find(
            'first', 
            array(
                'fields'     => array( 'Desarrollo.id', 'Desarrollo.nombre'),
                'contain'    => array('PlanesPago'),
                'conditions' => array( 'Desarrollo.id' => $id )
            )
        );

        echo json_encode( $desarrollo['PlanesPago'] );
        exit();

        // echo "<pre>";
        // print_r( $desarrollo['PlanesPago'] );
        // echo "</pre>";

        $this->autoRender = false;

    }
    /**
    * esta funcion alimenta la grafica de ventas vs mentas por unidades 
    * lo hace atra vez de el id del desarrollo, fechas, cuante, 
    *AKA RogueOne
    *
    */
    function grafica_ventas_metas(){
        header('Content-type: application/json; charset=utf-8');
        $fecha_ini        = '';
        $fecha_fin        = '';
        $desarrollo_id    = 0;
        $kpi_arreglo      = array();
        $arreglo_completo = array();
        $arreglo_meta = array();
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        if ($this->request->is('post')) {
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            $periodos = $this->getPeriodosArreglo($fi,$ff);
            $kpi_arreglo = array();
            $i=0;
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
                foreach($periodos as $key=>$periodo){
                    $monto = $this->User->query(
                        "SELECT SUM(monto),SUM(unidades) 
                        FROM objetivos_ventas_desarrollos 
                        WHERE fecha <= '".$key."-01'  
                        AND desarrollo_id = $desarrollo_id"
                    );
                  
                    if ( $monto[0][0]['SUM(monto)']>0 || $monto[0][0]['SUM(unidades)']>0) {
                        $kpi_arreglo[$i]['periodo'] = $periodo;
                        $kpi_arreglo[$i]['objetivo_monto'] = $monto[0][0]['SUM(monto)']==NULL ? 0 : $monto[0][0]['SUM(monto)'];
                        $kpi_arreglo[$i]['objetivo_q'] = $monto[0][0]['SUM(unidades)']==NULL ? 0 : $monto[0][0]['SUM(unidades)'];
                       
                        $i++;
                    }
                    else{
                        if($kpi_arreglo[$i-1]['objetivo_monto'] !=0 ){
                            $kpi_arreglo[$i]['periodo'] = $periodo;
                            $kpi_arreglo[$i]['objetivo_monto'] = $kpi_arreglo[$i-1]['objetivo_monto'];
                            $kpi_arreglo[$i]['objetivo_q'] = $kpi_arreglo[$i-1]['objetivo_q'];
                            $i++;
                        }
                    }
        
                }
                $ventas=$this->User->query(
                    "SELECT  COUNT(*), SUM(precio_unidad), DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y') As fecha
                    FROM operaciones_inmuebles
                    WHERE fecha >= '$fi' 
                    AND fecha <= '$ff' 
                    AND tipo_operacion=3
                    AND dic_cancelacion_id is null 
                    AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y');
                    "
                );
            }
            if( !empty( $this->request->data['user_id'] ) ){
                $user_id=$this->request->data['user_id'] ;
                foreach($periodos as $key=>$periodo){
                    $monto = $this->User->query(
                      "SELECT ventas_mensuales AS 'SUM(monto)', ventas_mensuales_q AS 'SUM(unidades)' 
                      FROM cuentas_users 
                      WHERE user_id = $user_id"
                    );
                    // $kpi_arreglo[$i]['monto'] = $monto;
                    // $i++;
                    if ( $monto[0]['cuentas_users']['SUM(monto)']>0 || $monto[0]['cuentas_users']['SUM(unidades)']>0) {
                      $kpi_arreglo[$i]['periodo'] = $periodo;
                      $kpi_arreglo[$i]['objetivo_monto'] = $monto[0]['cuentas_users']['SUM(monto)']==NULL ? 0 : $monto[0]['cuentas_users']['SUM(monto)'];
                      $kpi_arreglo[$i]['objetivo_q'] = $monto[0]['cuentas_users']['SUM(unidades)']==NULL ? 0 : $monto[0]['cuentas_users']['SUM(unidades)'];
                      $i++;
                      
                    }else{
                        if($kpi_arreglo[$i-1]['objetivo_monto'] !=0 ){
                            $kpi_arreglo[$i]['periodo'] = $periodo;
                            $kpi_arreglo[$i]['objetivo_monto'] = $kpi_arreglo[$i-1]['objetivo_monto'];
                            $kpi_arreglo[$i]['objetivo_q'] = $kpi_arreglo[$i-1]['objetivo_q'];
                        }else{
                            $kpi_arreglo[$i]['periodo']        = $periodo;
                            $kpi_arreglo[$i]['objetivo_monto'] = $monto[0][0]['SUM(monto)'] == NULL ? 2: $monto[0][0]['SUM(monto)'];
                            $kpi_arreglo[$i]['objetivo_q']     = $monto[0][0]['SUM(unidades)']==NULL ? 2 : $monto[0][0]['SUM(unidades)'];
                            $i++;

                        }
                    }
                    //[{"cuentas_users":{"SUM(monto)":"11000000","SUM(unidades)":"1"}}]
                }
                $ventas=$this->User->query(
                  "SELECT  COUNT(*), SUM(precio_unidad), DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y') As fecha
                    FROM operaciones_inmuebles
                    WHERE fecha >= '$fi' 
                    AND fecha <= '$ff' 
                    AND tipo_operacion=3
                    AND dic_cancelacion_id is null 
                    AND user_id = $user_id
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y');
                    "
                ); 
            }
           
            $i=0;
            foreach ($periodos as $periodo) {
                foreach ($kpi_arreglo as $arreglo) {
                    if ($periodo == $arreglo['periodo']) {
                        $arreglo_completo[$i]['periodo']        = $arreglo['periodo'];
                        $arreglo_completo[$i]['objetivo_monto'] = $arreglo['objetivo_monto'];
                        $arreglo_completo[$i]['objetivo_q']     = $arreglo['objetivo_q'];
                        $arreglo_completo[$i]['ventas_q']       = 0;
                        $arreglo_completo[$i]['ventas_monto']   = 0;  
                    }
                }
                foreach ($ventas as $value) {
                    if ($value[0]['fecha'] ==$periodo) {
                        $arreglo_completo[$i]['periodo']        =$periodo;
                        // if ( $arreglo_completo[$i]['objetivo_q']== 0) {
                        //     $arreglo_completo[$i]['objetivo_q']     = 0 ;
                        // }
                        // if ( $arreglo_completo[$i]['objetivo_monto']== 0) {
                        //     $arreglo_completo[$i]['objetivo_monto']     = 0;
                        // }
                        $arreglo_completo[$i]['ventas_q'] =  $value[0]['COUNT(*)'];
                        $arreglo_completo[$i]['ventas_monto']   = $value[0]['SUM(precio_unidad)']; 
                    }
                }
                $i++;
            }

            $i=0;
            foreach ($arreglo_completo as $periodo){
                if($periodo['objetivo_q']==0){
                    $porciento_grafica = 0;
                } else{
                    $porciento_grafica=(($periodo['ventas_q']/$periodo['objetivo_q'])*100);
                }
                $arreglo_meta[$i]['periodo']        = $periodo['periodo'] ;
                $arreglo_meta[$i]['objetivo_monto'] = $periodo['objetivo_monto'] ;
                $arreglo_meta[$i]['objetivo_q']     = $periodo['objetivo_q'] ;
                $arreglo_meta[$i]['ventas_q']       = ( empty($periodo['ventas_q']) ? 0  :  $periodo['ventas_q'] );
                $arreglo_meta[$i]['ventas_monto']   = ( empty($periodo['ventas_monto']) ? 0  :  $periodo['ventas_monto'] ); 
                $arreglo_meta[$i]['cumplido']       = $porciento_grafica;
                $i++;
            }
        }
        // $fi='2022-11-01 00:00:00';
        // $ff='2022-12-31 23:59:59';
        // $desarrollo_id=237;
        // $periodos = $this->getPeriodosArreglo($fi,$ff);
        // $kpi_arreglo = array();
        // $arreglo_completo=array();
        // foreach($periodos as $key=>$periodo){
        //     $monto = $this->User->query(
        //         "SELECT SUM(monto),SUM(unidades) 
        //         FROM objetivos_ventas_desarrollos 
        //         WHERE fecha <= '".$key."-01' 
        //         AND fin >= '".$key."-31' 
        //         AND desarrollo_id = $desarrollo_id");
        //     // $ventas = $this->User->query(
        //     //     "SELECT COUNT(*),SUM(precio_cerrado) 
        //     //     FROM ventas 
        //     //     WHERE fecha >= '".$key."-01' 
        //     //     AND fecha <= '".$key."-31' 
        //     //     AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)"
        //     // );
        //     // if ( $monto[0][0]['SUM(monto)']>0 || $monto[0][0]['SUM(unidades)']>0 ) {
            
        //         $kpi_arreglo[$i]['periodo'] = $periodo;
        //         $kpi_arreglo[$i]['objetivo_monto'] = $monto[0][0]['SUM(monto)']==NULL ? 0 : $monto[0][0]['SUM(monto)'];
        //         $kpi_arreglo[$i]['objetivo_q'] = $monto[0][0]['SUM(unidades)']==NULL ? 0 : $monto[0][0]['SUM(unidades)'];
        //         // $kpi_arreglo[$i]['ventas_q'] = $ventas[0][0]['COUNT(*)']==NULL ? 0 : $ventas[0][0]['COUNT(*)'];
        //         // $kpi_arreglo[$i]['ventas_monto'] = $ventas[0][0]['SUM(precio_cerrado)']==NULL ? 0 : $ventas[0][0]['SUM(precio_cerrado)'];
        //         $i++;
        //     // }
        // }
        // $ventas=$this->User->query(
        //     "SELECT  COUNT(*), SUM(precio_unidad), DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y') As fecha
        //     FROM operaciones_inmuebles
        //     WHERE fecha >= '$fi' 
        //     AND fecha <= '$ff' 
        //     AND tipo_operacion=3
        //     AND dic_cancelacion_id is null 
        //     AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)
        //     GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y');
        //     "
        // );        
        // $i=0;
        // foreach ($kpi_arreglo as $arreglo) {
        //     $arreglo_completo[$i]['periodo']        = $arreglo['periodo'] ;
        //     $arreglo_completo[$i]['objetivo_monto'] = $arreglo['objetivo_monto'] ;
        //     $arreglo_completo[$i]['objetivo_q']     = $arreglo['objetivo_q'] ;
        //     // $arreglo_completo[$i]['ventas_q'] =  0;
        //     // $arreglo_completo[$i]['ventas_monto'] =0;   
        //     foreach ($ventas as $value) {
        //         if ($value[0]['fecha'] == $arreglo['periodo']) {
        //             // if ($arreglo_completo[$i]['objetivo_monto']==0) {
        //             //     $arreglo_completo[$i]['objetivo_monto']=0;
        //             // }
        //             // if ($arreglo_completo[$i]['objetivo_q']==0) {
        //             //     $arreglo_completo[$i]['objetivo_q']=0;
        //             // }
        //             $arreglo_completo[$i]['ventas_q'] =  $value[0]['COUNT(*)'];
        //             $arreglo_completo[$i]['ventas_monto']   = $value[0]['SUM(precio_unidad)']; 
        //         }
        //     }
        //     $i++;
        // }
        // $i=0;
        // foreach ($arreglo_completo as $periodo){
        //     if($periodo['objetivo_q']==0){
        //         $porciento_grafica = 0;
        //     } else{
        //         $porciento_grafica=(($periodo['ventas_q']/$periodo['objetivo_q'])*100);
        //     }
        //     $arreglo_meta[$i]['periodo']        = $periodo['periodo'] ;
        //     $arreglo_meta[$i]['objetivo_monto'] = $periodo['objetivo_monto'] ;
        //     $arreglo_meta[$i]['objetivo_q']     = $periodo['objetivo_q'] ;
        //     $arreglo_meta[$i]['ventas_q']       = ( empty($periodo['ventas_q'] ) ? 0  : $periodo['ventas_q']  );
        //     $arreglo_meta[$i]['ventas_monto']   = ( empty( $periodo['ventas_monto']) ? 0  :  $periodo['ventas_monto']);
        //     $arreglo_meta[$i]['cumplido']       = $porciento_grafica;
        //     $i++;
        // }

        // if (empty($arreglo_meta)) {
        //     $arreglo_meta[$i]['periodo']        = 0;
        //     $arreglo_meta[$i]['objetivo_monto'] = 0;
        //     $arreglo_meta[$i]['objetivo_q']     = 0;
        //     $arreglo_meta[$i]['ventas_q']       = 0;
        //     $arreglo_meta[$i]['ventas_monto']   = 0; 
        //     $arreglo_meta[$i]['cumplido']       = 0;
        // }
    
        echo json_encode( $arreglo_meta , true );
        exit();
        $this->autoRender = false; 
    }
    
    /***
    *esta funcione alimenta los datos de la grafica de ventas vs metas vendidas  
    *lo hace por id del dasarrollo, fechas,cuenta
    *  AKA RogueOne
    * 
    */
    function grafica_ventas_acomuladas(){
        header('Content-type: application/json; charset=utf-8');
        $fecha_ini     = '';
        $fecha_fin     = '';
        $cuenta_id     = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $desarrollo_id = 0;
        $arreglo       = array();
        if ($this->request->is('post')) {
            $fecha_ini     = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin     = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi            = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff            = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            $periodos      = $this->getPeriodosArreglo($fi,$ff);
            $i             = 0;
            $ventas=$this->User->query(
                "SELECT  COUNT(*) AS unidades, SUM(precio_unidad) AS monto, DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y') As fecha
                FROM operaciones_inmuebles
                WHERE fecha >= '$fi' 
                AND fecha <= '$ff' 
                AND tipo_operacion=3
                AND dic_cancelacion_id is null 
                AND inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id = $desarrollo_id)
                GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%m-%Y');
                "
            );
            foreach ($ventas as $value) {
                $arreglo[$i]['periodo']=$value[0]['fecha'];
                $arreglo[$i]['ventas_q']=$value[0]['unidades'];
                $arreglo[$i]['ventas_monto']=$value[0]['monto'];
                $i++;
            }
            
        }
        
        if (empty($arreglo)) {
            $arreglo[$i]['periodo']  = 0;
            $arreglo[$i]['ventas_q'] = 0;
            $arreglo[$i]['ventas_monto'] = 0;
        }    
        echo json_encode( $arreglo , true );
        exit();
        $this->autoRender = false; 
    }
    /**
    * esta funcion alimenta  la grafica de visitas y ventas echas por el desarollo
    * lo hace por los filtros de id del desarrollo, fechas, cuenta
    * AKA RogueOne
    *
    */
    function grafica_ventas_visitas_desarrollo(){
        header('Content-type: application/json; charset=utf-8');
        $fecha_ini     = '';
        $fecha_fin     = '';
        $desarrollo_id=0;
        $i=0;
        $cuenta_id=0;
        // $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $array_ventas_visitas = array();
        if ($this->request->is('post')) {
            $cuenta_id=$this->request->data['cuenta_id'] ;
        
            $fecha_ini     = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin     = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi            = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff            = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            // $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            $periodos      = $this->getPeriodosArreglo($fi,$ff);
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);

                $visitas = $this->Desarrollo->query(
                    "SELECT COUNT(*) AS visitas, events.fecha_inicio
                    FROM  events
                    WHERE  events.desarrollo_id =$desarrollo_id
                    AND  events.cuenta_id = $cuenta_id
                    AND events.tipo_tarea =1
                    AND events.fecha_inicio >= '$fi' 
                    AND events.fecha_inicio <= '$ff'
                    GROUP BY DATE_FORMAT(events.fecha_inicio,'%Y%m');"
                );
                $ventas= $this->Desarrollo->query(
                    "SELECT COUNT(*)AS ven , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND tipo_operacion=3
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
            }
            if( !empty( $this->request->data['user_id'] ) ){
                $user_id=$this->request->data['user_id'] ;
                $visitas = $this->Desarrollo->query(
                    "SELECT COUNT(*) AS visitas, events.fecha_inicio
                    FROM  events
                    WHERE  events.user_id =$user_id
                    AND events.tipo_tarea =1
                    AND events.fecha_inicio >= '$fi' 
                    AND events.fecha_inicio <= '$ff'
                    GROUP BY DATE_FORMAT(events.fecha_inicio,'%Y%m');"
                );
                $ventas= $this->Desarrollo->query(
                    "SELECT COUNT(*)AS ven , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
                    FROM operaciones_inmuebles 
                    WHERE operaciones_inmuebles.user_id =$user_id
                    AND operaciones_inmuebles.fecha >='$fi' 
                    AND operaciones_inmuebles.fecha <='$ff'
                    AND tipo_operacion=3
                    GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
                );
            }
            $ventas_visitas=array();
            $i=0;
            foreach($periodos as $key=>$periodo){
                foreach ($visitas as $visita) {
                    if ($key == substr($visita['events']['fecha_inicio'],0,7)) {
    
                        $ventas_visitas[$i]['visitas']=$visita[0]['visitas'];
                        $ventas_visitas[$i]['periodo']=substr($visita['events']['fecha_inicio'],0,7);
                        $ventas_visitas[$i]['ventas']=0;
                    }
                }
                foreach ($ventas as $venta) {
                    if ($key == $venta[0]['fecha']) {
                        $ventas_visitas[$i]['periodo']= $key; 
                        $ventas_visitas[$i]['ventas']=$venta[0]['ven']; 
                        if ($ventas_visitas[$i]['visitas']==0) {
                            $ventas_visitas[$i]['visitas']=0;
                        }
                    } 
                }
                $i++;
            }
            $i=0;
            $arreglo_ventas_visitas=array();
            foreach ($ventas_visitas as $value) {
                $arreglo_ventas_visitas[$i]['periodo']=$value['periodo'];
                $arreglo_ventas_visitas[$i]['visitas']=$value['visitas'];
                $arreglo_ventas_visitas[$i]['ventas']=$value['ventas'];
    
                $i++;
            }
        }   
        // $fi='2022-07-01 00:00:00';
        // $ff='2022-08-08 23:59:59';
        // $desarrollo_id=246;
        // $visitas = $this->Desarrollo->query(
        //     "SELECT COUNT(*) AS visitas, events.fecha_inicio
        //     FROM  events
        //     WHERE  events.desarrollo_id =$desarrollo_id
        //     AND  events.cuenta_id = $cuenta_id
        //     AND events.tipo_tarea =1
        //     AND events.fecha_inicio >= '$fi' 
        //     AND events.fecha_inicio <= '$ff'
        //     GROUP BY DATE_FORMAT(events.fecha_inicio,'%Y%m');"
        // );
        
        // $ventas= $this->Desarrollo->query(
        //     "SELECT COUNT(*)AS ven , DATE_FORMAT(operaciones_inmuebles.fecha,'%Y-%m') As fecha
        //     FROM operaciones_inmuebles 
        //     WHERE operaciones_inmuebles.inmueble_id IN (select inmueble_id from desarrollo_inmuebles where desarrollo_id = $desarrollo_id)
        //     AND operaciones_inmuebles.fecha >='$fi' 
        //     AND operaciones_inmuebles.fecha <='$ff'
        //     AND tipo_operacion=3
        //     GROUP BY DATE_FORMAT(operaciones_inmuebles.fecha,'%Y%m');"
        // );
        // $ventas_visitas=array();
        // $i=0;
        // $periodos = $this->getPeriodosArreglo($fi,$ff);
        // foreach($periodos as $key=>$periodo){
        //     foreach ($visitas as $visita) {
        //         if ($key == substr($visita['events']['fecha_inicio'],0,7)) {

        //             $ventas_visitas[$i]['visitas']=$visita[0]['visitas'];
        //             $ventas_visitas[$i]['periodo']=substr($visita['events']['fecha_inicio'],0,7);
        //             $ventas_visitas[$i]['ventas']=0;
        //         }
        //     }
        //     foreach ($ventas as $venta) {
        //         if ($key == $venta[0]['fecha']) {
        //             $ventas_visitas[$i]['periodo']= $venta[0]['fecha']; 
        //             $ventas_visitas[$i]['ventas']=$venta[0]['ven']; 
        //             if ($ventas_visitas[$i]['visitas']==0) {
        //                 $ventas_visitas[$i]['visitas']=0;
        //             }
        //         } 
        //     }
        //     $i++;
        // }
        // $i=0;
        // $arreglo_ventas_visitas=array();
        // foreach ($ventas_visitas as $value) {
        //     $arreglo_ventas_visitas[$i]['periodo']=$value['periodo'];
        //     $arreglo_ventas_visitas[$i]['visitas']=$value['visitas'];
        //     $arreglo_ventas_visitas[$i]['ventas']=$value['ventas'];

        //     $i++;
        // }
        //{"visitas":{"0":{"visitas":"5"},"events":{"fecha_inicio":"2022-02-07 17:22:52"}}}
        //{"0":{"ven":"3"},"operaciones_inmuebles":{"fecha":"2022-07-15"}}
        if (empty($arreglo_ventas_visitas)) {
            $arreglo_ventas_visitas[$i]['periodo']='0';
            $arreglo_ventas_visitas[$i]['visitas']=0;
            $arreglo_ventas_visitas[$i]['ventas']=0;
        }
        echo json_encode( $arreglo_ventas_visitas , true );
        exit();
        $this->autoRender = false;    
    }
     /**
    * 
    * 
    * 
    * 
    */
    function grafica_leads_desarrollos(){
        header('Content-type: application/json; charset=utf-8'); 
        $this->loadModel('Cliente');
        $this->loadModel('Lead');
        $this->Lead->Behaviors->load('Containable'); 
        $this->Cliente->Behaviors->load('Containable'); 
        $this->Desarrollo->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $desarrollos_id =""; 
        $medios_id      = "";
        $fecha_ini      = 0;
        $fecha_fin      = 0;
        $arreglo=array();
        $i=0;
        $leads=array();
        $cond_rangos = array("Cliente.created BETWEEN ? AND ?" => array($fi, $ff));
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        // $fi='2016-10-01 00:00:00';
        // $ff='2022-03-01 23:59:59';
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
            $desarrollos = $this->Desarrollo->find('all',
                array(
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
            $leads=$this->Lead->find('all',array(
                'conditions'=>array(
                    'Lead.desarrollo_id IN ('.$desarrollos_id.')',
                    'Lead.dic_linea_contacto_id <>'    => '',
                    'Lead.dic_linea_contacto_id IN ('.$medios_id.')',
                    $cond_rangos,
                  ), 
                  'fields' => array(
                    'COUNT(Lead.dic_linea_contacto_id) as lead',
                    'Lead.desarrollo_id'
                ),
                'group'   =>'Lead.desarrollo_id',
                'order'   => 'Lead.desarrollo_id ASC',
                'contain' => false 
                )
            );
            $inversion_por_desarrollo = $this->Desarrollo->query(
                "SELECT desarrollo_id, SUM(inversion_prevista) AS inversion 
                FROM publicidads
                WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
                AND publicidads.dic_linea_contacto_id IN ($medios_id) 
                AND publicidads.fecha_inicio<='$ff' 
                AND publicidads.fecha_inicio>='$fi' 
                GROUP BY publicidads.desarrollo_id"
            );
            foreach ($desarrollos as $desarrollo) {
                $arreglo[$i]['desarollo']=$desarrollo['Desarrollo']['nombre'];
                $arreglo[$i]['leads']=0;
                $arreglo[$i]['inversion']=0;
                foreach ($leads as $lead) {
                    if ($desarrollo['Desarrollo']['id']==$lead['Lead']['desarrollo_id']) {
                        $arreglo[$i]['leads']=$lead[0]['lead'];
                    }
                }
                foreach ($inversion_por_desarrollo as $inversion) {
                    if ($desarrollo['Desarrollo']['id']==$inversion['publicidads']['desarrollo_id']) {
                        $arreglo[$i]['inversion']=$inversion[0]['inversion'];
                    }
                }
                $i++;
            }
        }
        //$desarrollos_id = substr($desarrollos_id,0,-1);
        //$medios_id = substr($medios_id,0,-1);
        // $desarrollos = $this->Desarrollo->find('all',
        //     array(
        //         'conditions'=>array(
        //             'Desarrollo.id IN('.$desarrollos_id.')'
        //         ),
        //         'fields'=>array(
        //             'nombre',
        //             'id'
        //         ),
        //         'contain'=>false
        //     )
        // );
        // $leads=$this->Cliente->find('all',array(
        //     'conditions'=>array(
        //       'Cliente.desarrollo_id IN ('.$desarrollos_id.')',
        //       'Cliente.dic_linea_contacto_id <>'    => '',
        //       $cond_rangos,
        //       ),
        //       'fields' => array(
        //           'COUNT(Cliente.desarrollo_id) as lead',
        //           'Cliente.desarrollo_id'
        //       ),
        //       'group' =>'Cliente.desarrollo_id',
        //       'order'   => 'Cliente.desarrollo_id ASC',
        //       'contain' => false 
        //     )
        // ); 
        // $inversion_por_desarrollo = $this->Desarrollo->query(
        //     "SELECT desarrollo_id, SUM(inversion_prevista) AS inversion 
        //     FROM publicidads
        //     WHERE publicidads.desarrollo_id IN ($desarrollos_id) 
        //     AND publicidads.dic_linea_contacto_id IN ($medios_id) 
        //     AND publicidads.fecha_inicio<='$ff' 
        //     AND publicidads.fecha_inicio>='$fi' 
        //     GROUP BY publicidads.desarrollo_id"
        // );
        // foreach ($ as $key => $value) {
          
        // }
        //{"Desarrollo":{"nombre":"DUNYA","id":"92"}
        //{"0":{"lead":"1847"},"Cliente":{"desarrollo_id":"92"}
        //{"publicidads":{"desarrollo_id":"68"},"0":{"inversion":"48500"}
        // if (empty($arreglo)) {
        //     $arreglo[$i]['desarollo']='no hay';
        //     $arreglo[$i]['leads']=0;
        //     $arreglo[$i]['inversion']=0;
        // }
        $i=0;
        if(empty($arreglo)) {
            $arreglo[$i]['desarollo']='sin informacion';
            $arreglo[$i]['leads']=0;
            $arreglo[$i]['inversion']=0;     
        }
        echo json_encode( $arreglo , true );
        exit();
        $this->autoRender = false;
    }

    /**
     * 
     * 
     * 
     * 
    */
    function tabla_resumen_desarrollos(){
        header('Content-type: application/json; charset=utf-8'); 
        $this->loadModel('Cliente');
        $this->loadModel('Event');
        $this->loadModel('DicLineaContacto');
        $this->loadModel('Venta');
        $this->Venta->Behaviors->load('Containable');
        $this->Event->Behaviors->load('Containable');
        $this->Cliente->Behaviors->load('Containable'); 
        $this->Desarrollo->Behaviors->load('Containable');
        $this->DicLineaContacto->Behaviors->load('Containable');
        $desarrollos_id ="";
        $medios_id      = "";
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $arreglo=array();
        $arreglo_tabla_resumen_desarrollos=array();
        $response=array();
        $i=0;
        if($this->request->is('post')){
            if( !empty($this->request->data['rango_fechas']) ){
                $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
                $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
                $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
                $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
                if ($fi == $ff){
                    $cond_rangos = array("Lead.fecha LIKE '".$fi."%'");
                    $cond_venta = array("Venta.fecha LIKE '".$fi."%'");
                }else{
                    $cond_rangos = array("Lead.fecha BETWEEN ? AND ?" => array($fi, $ff));
                    $cond_venta = array("Venta.fecha BETWEEN ? AND ?"=> array($fi, $ff));

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
            //     'fields' => array(
            //         'COUNT(Cliente.dic_linea_contacto_id) as lead',
            //         'Cliente.dic_linea_contacto_id'
            //     ),
            //     'group' =>'Cliente.dic_linea_contacto_id',
            //     'order'   => 'Cliente.dic_linea_contacto_id ASC',
            //     'contain' => false 
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
            $visitas= $this->Event->query(
                "SELECT COUNT(clientes.dic_linea_contacto_id) AS visita
                ,clientes.dic_linea_contacto_id
                FROM events, clientes,  dic_linea_contactos
                WHERE events.desarrollo_id IN ($desarrollos_id) 
                and events.cuenta_id = $cuenta_id
                AND clientes.id =  events.cliente_id
                AND events.tipo_tarea =1
                AND dic_linea_contactos.id IN ($medios_id)
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                AND dic_linea_contactos.id = clientes.dic_linea_contacto_id 
                AND  events.fecha_inicio >= '$fi' 
                AND  events.fecha_inicio <= '$ff'
                GROUP BY clientes.dic_linea_contacto_id;"
            );
            $ventas = $this->Venta->query(
                "SELECT COUNT(*)AS venta, clientes.dic_linea_contacto_id
                FROM ventas, clientes
                WHERE ventas.inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))
                AND ventas.fecha >='$fi' 
                AND ventas.fecha <='$ff'
                AND ventas.cliente_id=clientes.id
                AND clientes.dic_linea_contacto_id IN ($medios_id) 
                GROUP BY clientes.dic_linea_contacto_id;"
            );
            foreach ($dic_linea_contacto as $dic) {
                foreach ($leads as $lead) {
                    if ( $dic['DicLineaContacto']['id']== $lead['Lead']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']= $dic['DicLineaContacto']['linea_contacto'];
                        $arreglo[$i]['leads']=$lead[0]['lead'];
                        $arreglo[$i]['inversion']=0;
                        $arreglo[$i]['citas']=0;
                        $arreglo[$i]['visitas']=0;
                        $arreglo[$i]['ventas']=0;
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
                foreach ($citas as $cita) {
                    if ($dic['DicLineaContacto']['id']== $cita['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['leads']==0){
                            $arreglo[$i]['leads']=0;
                        }
                        if($arreglo[$i]['inversion']==0){
                            $arreglo[$i]['inversion']=0;
                        }
                        if(empty($cita[0]['citas']) OR $cita[0]['citas']<0){
                            $arreglo[$i]['citas']=0;
                        }else{
                            $arreglo[$i]['citas']=$cita[0]['citas'];
                        }
                    }
                }
                foreach ($visitas as $visita) {
                    if ($dic['DicLineaContacto']['id']== $visita['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['leads']==0){
                            $arreglo[$i]['leads']=0;
                        }
                        if($arreglo[$i]['inversion']==0){
                            $arreglo[$i]['inversion']=0;
                        }
                        if($arreglo[$i]['citas']==0){
                            $arreglo[$i]['citas']=0;
                        }
                        $arreglo[$i]['visitas']=$visita[0]['visita'];
                    }
                }
                foreach ($ventas as $venta) {
                    if ($dic['DicLineaContacto']['id']== $venta['clientes']['dic_linea_contacto_id']) {
                        $arreglo[$i]['medio']=$dic['DicLineaContacto']['linea_contacto'];
                        if($arreglo[$i]['leads']==0){
                            $arreglo[$i]['leads']=0;
                        }
                        if($arreglo[$i]['inversion']==0){
                            $arreglo[$i]['inversion']=0;
                        }
                        if($arreglo[$i]['citas']==0){
                            $arreglo[$i]['citas']=0;
                        }
                        if($arreglo[$i]['visitas']==0){
                            $arreglo[$i]['visitas']=0;
                        }
                        $arreglo[$i]['ventas']=$venta[0]['venta'];
                    }
                }
                $i++;
            }
            $i=0;
            $inversionTotal=0;
            foreach ($arreglo as $value) {
                $arreglo_tabla_resumen_desarrollos[$i]['medio']     = $value['medio'];
                $arreglo_tabla_resumen_desarrollos[$i]['leads']     = $value['leads'];
                $arreglo_tabla_resumen_desarrollos[$i]['inversion'] = '$'.number_format($value['inversion'], 2);
                if ($value['leads']>0) {
                    $arreglo_tabla_resumen_desarrollos[$i]['costoXleads']='$'.number_format(($value['inversion']/$value['leads']), 2);
                }else{
                    $arreglo_tabla_resumen_desarrollos[$i]['costoXleads']='$'.number_format($value['inversion'], 2);
                }
                if ($value['citas']==null) {
                    $arreglo_tabla_resumen_desarrollos[$i]['citas'] =0;
                }else{
                    $arreglo_tabla_resumen_desarrollos[$i]['citas']          = $value['citas'];

                }
                if ($value['visitas']==null) {
                    $arreglo_tabla_resumen_desarrollos[$i]['visitas'] =0;
                }else{
                    $arreglo_tabla_resumen_desarrollos[$i]['visitas']          = $value['visitas'];

                }
                if ($value['ventas']==null) {
                    $arreglo_tabla_resumen_desarrollos[$i]['ventas'] =0;
                }else{
                    $arreglo_tabla_resumen_desarrollos[$i]['ventas']          = $value['ventas'];

                }   
                $inversionTotal += $value['inversion'];
                $arreglo_tabla_resumen_desarrollos[$i]['inversiontotal'] = '$'.number_format($inversionTotal, 2);
                
                //
                $response['data'][$i] =  array(
                    $value['medio'],
                    '$'.number_format($value['inversion'], 2),
                    $value['leads'],
                    $arreglo_tabla_resumen_desarrollos[$i]['costoXleads'],
                    $value['citas'],
                    $value['visitas'],
                    $value['ventas']
                );
                //
                $i++;
            }
        }
        echo json_encode( $arreglo_tabla_resumen_desarrollos , true );
        exit();
        $this->autoRender = false;
    }
    /**
     * 
     * esta es la api que consume el daserrollo lo hace por la cuenta t sirve parra mappen
     * 
    */
    function get_desarrollo_app(){
        header('Content-type: application/json; charset=utf-8');
        $this->loadModel('FotoDesarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->FotoDesarrollo->Behaviors->load('Containable');
        $this->DesarrolloInmueble->Behaviors->load('Containable');
        $this->layout = null;
        $response=[];
        $i=0;
        $cuenta_id='';
        $fachada=[];
        if ($this->request->is('post')) {
            $cuenta_id=$this->request->data['cuenta_id'];
            $desarrollos=$this->Desarrollo->find('all',array(
                'conditions'=>array(
                    'Desarrollo.cuenta_id'=>$cuenta_id,        
                ),
                'fields'=>array(
                    'nombre',
                    'etapa_desarrollo',
                    'm2_low',
                    'm2_top',
                    'rec_low',
                    'rec_top',
                    'banio_low',
                    'banio_top',
                    'est_low',
                    'est_top',
                    'precio_low',
                    'precio_top',
                    'id'
                ),
                'contain'=>false
            ));
            foreach ($desarrollos as $value) {
                $fachada=$this->FotoDesarrollo->find('first',array(
                    'conditions'=>array(
                        'FotoDesarrollo.desarrollo_id'=> $value['Desarrollo']['id'],        
                        'FotoDesarrollo.orden'=>1,        
                    ),
                    'fields'=>array(
                        'ruta',
                        'descripcion',
                        'orden',
                    ),
                    'contain'=>false
                ));
                $response[$i]['desarrollo']=$value['Desarrollo']['nombre'];
                $response[$i]['etapa_desarrollo']=$value['Desarrollo']['etapa_desarrollo'];
                $response[$i]['id']=$value['Desarrollo']['id'];
                $response[$i]['portada']=Router::url( $fachada['FotoDesarrollo']['ruta'],true);
                $response[$i]['metroscubicos']=$value['Desarrollo']['m2_low'].' - ' . $value['Desarrollo']['m2_top']. ' m2';
                $response[$i]['recamaras']=$value['Desarrollo']['rec_low'].' - ' . $value['Desarrollo']['rec_top'];
                $response[$i]['banios']=$value['Desarrollo']['banio_low'].' - ' . $value['Desarrollo']['banio_top'];
                $response[$i]['estacionamiento']=$value['Desarrollo']['est_low'].' - ' . $value['Desarrollo']['est_top'];
                $response[$i]['desde']='$'.number_format( $value['Desarrollo']['precio_low'], 2).' - ' .'$'.number_format( $value['Desarrollo']['precio_top'], 2);

                $i++;
            }
        }
        echo json_encode( $response  );
        exit();
        $this->autoRender = false;

    }
    /***
     * 
     * 
    */
    function get_index_app(){
        header('Content-type: application/json; charset=utf-8');
        // $this->loadModel(''); 
        $this->Desarrollo->Behaviors->load('Containable');
        $this->layout = null;
        $response=[];
        $and = [];
        $cuenta_id=0;
        $desarrollo_id=0;
        $i=0;
        $cond_atencion=array();
        if ($this->request->is('post')) {
            $cuenta_id=$this->request->data['cuenta_id'];
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = $this->request->data['desarrollo_id'];
                // array_push($and, array('Desarrollo.id' => $desarrollo_id ));
            }
            array_push($and, $cond_atencion);
            $desarrollos=$this->Desarrollo->find('all',array(
                'conditions'=>array(     
                    'Desarrollo.cuenta_id'=>$cuenta_id,  
                    'Desarrollo.id' => $desarrollo_id
                    // $cond_atencion      

                ),
                
                'contain'=>false
            ));
            foreach ($desarrollos as  $value) {
                $response[$i]['nombre']=$value['Desarrollo']['nombre'];
                $response[$i]['id']=$value['Desarrollo']['id'];

                $response[$i]['brochure']=Router::url($value['Desarrollo']['brochure'],true);
                $response[$i]['youtube']=$value['Desarrollo']['url_youtube'];
                $response[$i]['matterport']=$value['Desarrollo']['matterport'];
                $response[$i]['direccion']=( !empty ($value['Desarrollo']['calle']) ? '' .$value['Desarrollo']['calle'] : '' )
                    .( !empty ($value['Desarrollo']['numero_ext']) ? ' ' .$value['Desarrollo']['numero_ext'] : '' )
                    .( !empty ($value['Desarrollo']['numero_int']) ? ', ' .$value['Desarrollo']['numero_int'] : '' )
                    .( !empty ($value['Desarrollo']['colonia']) ? ', Col. '.'<span style="text-transform: none;">'.$value['Desarrollo']['colonia'].'</span>' : '' )
                    .( !empty ($value['Desarrollo']['ciudad']) ? ', '.'<span style="text-transform: none;">'.$value['Desarrollo']['ciudad'].'</span>' : '' )
                    .( !empty ($value['Desarrollo']['estado']) ? ', '.'<span style="text-transform: none;">'.$value['Desarrollo']['estado'].'</span>' : '' )
                    .( !empty ($value['Desarrollo']['cp']) ? ', CP: '.$value['Desarrollo']['cp'] : '' )
                ;
                $response[$i]['metroscubicos']=$value['Desarrollo']['m2_low'].' - ' . $value['Desarrollo']['m2_top']. ' m2';
                $response[$i]['recamaras']=$value['Desarrollo']['rec_low'].' - ' . $value['Desarrollo']['rec_top'];
                $response[$i]['banios']=$value['Desarrollo']['banio_low'].' - ' . $value['Desarrollo']['banio_top'];
                $response[$i]['estacionamiento']=$value['Desarrollo']['est_low'].' - ' . $value['Desarrollo']['est_top'];

                $response[$i]['desde']='$'.number_format( $value['Desarrollo']['precio_low'], 2).' - ' .'$'.number_format( $value['Desarrollo']['precio_top'], 2);

                $response[$i]['descripcion']=$value['Desarrollo']['descripcion'];
                $response[$i]['tipo_desarrollo']=$value['Desarrollo']['tipo_desarrollo'];
                $response[$i]['etapa_desarrollo']=$value['Desarrollo']['etapa_desarrollo'];
                $response[$i]['torres']=$value['Desarrollo']['torres'];
                $response[$i]['unidades_totales']=$value['Desarrollo']['unidades_totales'];
                $response[$i]['departamento_muestra']=$value['Desarrollo']['departamento_muestra'];
                $response[$i]['horario_contacto']=$value['Desarrollo']['horario_contacto'];
                $response[$i]['fecha_entrega']=$value['Desarrollo']['fecha_entrega'];
                $response[$i]['google_maps']=$value['Desarrollo']['google_maps'];
                $response[$i]['interes']= ($value['Desarrollo']['cc_cercanos']== 1 ? 'Centros comerciales cercanos' : "")
                    .($value['Desarrollo']['cerca_playa']            == 1 ? 'Cerca de la playa' : "")
                    .($value['Desarrollo']['escuelas']               == 1 ? 'Escuelas cercanas' : "")
                    .($value['Desarrollo']['frente_parque']          == 1 ? 'Frente a parque' : "")
                    .($value['Desarrollo']['parque_cercano']         == 1 ? 'Parques cercanos' : "")
                    .($value['Desarrollo']['plazas_comerciales']     == 1 ? 'Plazas comerciales' : "")
                ;
                $response[$i]['amenidades']=
                
                    ($value['Desarrollo']['alberca_sin_techar']         == 1 ? 'Alberca descubierta' : "")
                    .($value['Desarrollo']['alberca_techada']            == 1 ? 'Alberca techada' : "")
                    .($value['Desarrollo']['sala_cine']                  == 1 ? 'Área de cine' : "")
                    .($value['Desarrollo']['juegos_infantiles']          == 1 ? 'Área de juegos infantiles' : "")
                    .($value['Desarrollo']['fumadores']                  == 1 ? 'Área para fumadores' : "")
                    .($value['Desarrollo']['areas_verdes']               == 1 ? 'Áreas verdes' : "")
                    .($value['Desarrollo']['asador']                     == 1 ? 'Asador' : "")
                    
                .($value['Desarrollo']['biblioteca']                     == 1 ? 'Biblioteca' : "")

                    .($value['Desarrollo']['cafeteria']                  == 1 ? 'Cafetería' : "")
                    .($value['Desarrollo']['golf']                       == 1 ? 'Campo de golf' : "")
                    .($value['Desarrollo']['paddle_tennis']              == 1 ? 'Cancha de paddle' : "")
                    .($value['Desarrollo']['squash']                     == 1 ? 'Cancha de squash' : "")
                    .($value['Desarrollo']['tennis']                     == 1 ? 'Cancha de tennis' : "")
                    
                    .($value['Desarrollo']['cancha_petanca']             == 1 ? 'Cancha (petanca)' : "")
                    .($value['Desarrollo']['cancha_pickleball']          == 1 ? 'Cancha pickleball' : "")


                    .($value['Desarrollo']['carril_nado']                == 1 ? 'Carril de nado' : "")
                    
                    .($value['Desarrollo']['ciclopista']                 == 1 ? 'Ciclopista' : "")
                    .($value['Desarrollo']['conserje']                   == 1 ? 'Concierge' : "")
                    .($value['Desarrollo']['coworking']                  == 1 ? 'Coworking' : "")

                    .($value['Desarrollo']['fire_pit']                   == 1 ? 'Fire pit' : "")
                    .($value['Desarrollo']['gimnasio']                   == 1 ? 'Gimnasio' : "")
                    
                    .($value['Desarrollo']['helipuerto']                   == 1 ? 'Helipuerto' : "")

                    .($value['Desarrollo']['jacuzzi']                    == 1 ? 'Jacuzzi' : "")
                    .($value['Desarrollo']['living']                     == 1 ? 'Living' : "")
                    .($value['Desarrollo']['lobby']                      == 1 ? 'Lobby' : "")
                    
                    .($value['Desarrollo']['ludoteca']                      == 1 ? 'Ludoteca' : "")

                    .($value['Desarrollo']['boliche']                    == 1 ? 'Mesa de boliche' : "")
                    
                    .($value['Desarrollo']['pet_park']                    == 1 ? 'Pet park' : "")

                    .($value['Desarrollo']['pista_jogging']              == 1 ? 'Pista de jogging' : "")
                    .($value['Desarrollo']['play_room']                  == 1 ? 'Play room / Cuarto de juegos' : "")
                    .($value['Desarrollo']['pool_bar']                   == 1 ? 'Pool bar' : "")
                    .($value['Desarrollo']['restaurante']                == 1 ? 'Restaurante' : "")
                    .($value['Desarrollo']['roof_garden_compartido']     == 1 ? 'Roof garden' : "")
                    .($value['Desarrollo']['salon_juegos']               == 1 ? 'Salón de juegos' : "")
                    .($value['Desarrollo']['salon_usos_multiples']       == 1 ? 'Salón de usos múltiples' : "")
                    .($value['Desarrollo']['sauna']                      == 1 ? 'Sauna' : "")
                    .($value['Desarrollo']['spa_vapor']                  == 1 ? 'Spa / Vapor' : "")
                    .($value['Desarrollo']['vista_panoramica']           == 1 ? 'Vista panorámica' : "")
                    
                    .($value['Desarrollo']['meditation_room']           == 1 ? 'Yoga / Meditation room' : "")

                    .($value['Desarrollo']['sky_garden']                 == 1 ? 'Sky garden' : "")
                    .($value['Desarrollo']['simulador_golf']             == 1 ? 'Simulador golf' : "")

                ;
                $response[$i]['servicios']=
                            ($value['Desarrollo']['acceso_discapacitados']      == 1 ? 'Acceso de discapacitados' : "") 
                            .($value['Desarrollo']['internet']                   == 1 ? 'Acceso Internet / WiFi' : "") 
                            .($value['Desarrollo']['tercera_edad']               == 1 ? 'Acceso para Tercera Edad' : "") 
                            .($value['Desarrollo']['aire_acondicionado']         == 1 ? 'Aire Acondicionado' : "") 
                            .($value['Desarrollo']['business_center']            == 1 ? 'Business Center' : "") 
                            .($value['Desarrollo']['calefaccion']                == 1 ? 'Calefacción' : "") 
                            .($value['Desarrollo']['cctv']                       == 1 ? 'CCTV' : "") 
                            //  .$certificaciones_led = array(1=>'Silver', 2=> 'Gold', 3=> 'Platinum')
                            .($value['Desarrollo']['certificacion_led']          == 1 ? ' Certificación leed ' : "") 

                            .($value['Desarrollo']['cisterna']                   == 1 ? 'Cisterna' : "")
                            .($value['Desarrollo']['conmutador']                 == 1 ? 'Conmutador' : "")
                            .($value['Desarrollo']['edificio_inteligente']       == 1 ? 'Edificio Inteligente' : "")
                            .($value['Desarrollo']['edificio_leed']              == 1 ? 'Edificio LEED' : "")
                            .($value['Desarrollo']['elevadores']                 == 1 ? 'Elevadores' : "")
                            .($value['Desarrollo']['estacionamiento_visitas']    == 1 ? 'Estacionamiento de visitas' : "")
                            .($value['Desarrollo']['gas_lp']                     == 1 ? 'Gas LP' : "")
                            .($value['Desarrollo']['gas_natural']                == 1 ? 'Gas Natural' : "")
                            .($value['Desarrollo']['lavanderia']                 == 1 ? 'Lavanderia' : "")
                            
                            .($value['Desarrollo']['mezzanine']                 == 1 ? 'Mezzanine' : "")

                            .($value['Desarrollo']['locales_comerciales']        == 1 ? 'Locales Comerciales' : "")
                            .($value['Desarrollo']['mascotas']                   == 1 ? 'Permite Mascotas' : "")
                            .($value['Desarrollo']['planta_emergencia']          == 1 ? 'Planta de Emergencia' : "")
                            .($value['Desarrollo']['porton_electrico']           == 1 ? 'Portón Eléctrico' : "")
                            .($value['Desarrollo']['sistema_contra_incendios']   == 1 ? 'Sistema Contra Incendios' : "")
                            .($value['Desarrollo']['sistema_seguridad']          == 1 ? 'Sistema de Seguridad' : "")
                            .($value['Desarrollo']['valet_parking']              == 1 ? 'Valet Parking' : "")
                            .($value['Desarrollo']['vapor']                      == 1 ? 'Vapor' : "")
                            .($value['Desarrollo']['seguridad']                  == 1 ? 'Vigilancia / Seguridad' : "")

                ;
                // $response[$i]['']=$value['Desarrollo'][''];
                            

                $i++;
            }

        }
        
        // Router::url($value['Desarrollo']['brochure'],true);
        // $response[$i]['user_Photo'] = Router::url($user['User']['foto'],true);
        
        echo json_encode( $response  );
        exit();
        $this->autoRender = false;
    }
    /**
     * 
     * 
     * 
     * 
    */
    function metas_cuenta_desh(){
        header('Content-type: application/json; charset=utf-8');
        $fecha_ini        = '';
        $fecha_fin        = '';
        $desarrollo_id    = 0;
        $kpi_arreglo      = array();
        $arreglo_completo = array();
        $arreglo_meta = array();
        $i=0;
        if ($this->request->is('post')) {
            $cuenta_id= $this->request->data['cuenta_id'];
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            $periodos = $this->getPeriodosArreglo($fi,$ff);
            foreach($periodos as $key=>$periodo){
                $monto = $this->User->query(
                    "SELECT SUM(monto) as montos,SUM(unidades) as unidades
                    FROM objetivos_ventas_desarrollos 
                    WHERE fecha <= '".$key."-01' 
                    AND fin >= '".$key."-31' 
                    AND cuenta_id =  $cuenta_id");
              
                if ( $monto[0][0]['montos)']>0 || $monto[0][0]['unidades']>0) {
                    $kpi_arreglo[$i]['periodo'] = $periodo;
                    $kpi_arreglo[$i]['objetivo_monto'] = $monto[0][0]['montos']==NULL ? 0 : $monto[0][0]['montos'];
                    $kpi_arreglo[$i]['objetivo_q'] = $monto[0][0]['unidades']==NULL ? 0 : $monto[0][0]['unidades'];
                   
                }else{
                    if($kpi_arreglo[$i-1]['objetivo_monto'] !=0 ){
                        $kpi_arreglo[$i]['periodo'] = $periodo;
                        $kpi_arreglo[$i]['objetivo_monto'] = $kpi_arreglo[$i-1]['objetivo_monto'];
                        $kpi_arreglo[$i]['objetivo_q'] = $kpi_arreglo[$i-1]['objetivo_q'];
                    }
                }
                
                $i++;
            }
            $ventas = $this->User->query(
                "SELECT COUNT(*) as unidades,SUM(precio_cerrado) as monto , DATE_FORMAT(ventas.fecha,'%m-%Y') As fecha
                FROM ventas 
                WHERE fecha >= '$fi' 
                AND fecha <=  '$ff'
                AND cuenta_id = $cuenta_id
                GROUP BY DATE_FORMAT(ventas.fecha,'%m-%Y');
                "
            );        
            $i=0;
            foreach ($kpi_arreglo as $arreglo) {
                $arreglo_completo[$i]['periodo']        = $arreglo['periodo'] ;
                $arreglo_completo[$i]['objetivo_monto'] = $arreglo['objetivo_monto'] ;
                $arreglo_completo[$i]['objetivo_q']     = $arreglo['objetivo_q'] ;
                foreach ($ventas as $value) {
                    if ($value[0]['fecha'] == $arreglo['periodo']) {
                        if ($arreglo_completo[$i]['objetivo_monto']==0) {
                            $arreglo_completo[$i]['objetivo_monto']=0;
                        }
                        if ($arreglo_completo[$i]['objetivo_q']==0) {
                            $arreglo_completo[$i]['objetivo_q']=0;
                        }
                        $arreglo_completo[$i]['ventas_q'] =  $value[0]['unidades'];
                        $arreglo_completo[$i]['ventas_monto']   = $value[0]['monto']; 
                    }
                }
                $i++;
            }
            $i=0;
            foreach ($arreglo_completo as $periodo){
                if($periodo['objetivo_q']==0){
                    $porciento_grafica = 0;
                } else{
                    $porciento_grafica=(($periodo['ventas_q']/$periodo['objetivo_q'])*100);
                }
                if($periodo['ventas_monto']==0){
                    $porciento_grafica_monto = 0;
                } else{
                    $porciento_grafica_monto=(($periodo['ventas_monto']/$periodo['objetivo_monto'])*100);
                }
                $arreglo_meta[$i]['periodo']        = $periodo['periodo'] ;
                $arreglo_meta[$i]['objetivo_monto'] =   round($periodo['objetivo_monto'],2);
                $arreglo_meta[$i]['objetivo_q']     = $periodo['objetivo_q'] ;
                $arreglo_meta[$i]['ventas_q']       = ( empty($periodo['ventas_q'] ) ? 0  : $periodo['ventas_q']  );
                $arreglo_meta[$i]['ventas_monto']   = ( empty( $periodo['ventas_monto']) ? 0  :  round( $periodo['ventas_monto'],2));
                $arreglo_meta[$i]['cumplido']       =  round($porciento_grafica,2);
                $arreglo_meta[$i]['cumplido_monto']       =  round($porciento_grafica_monto,2);
                $i++;
            }
            
        }

        //
        // $fi='2021-09-01 00:00:00';
        // $ff='2022-10-24 23:59:59';
        // $periodos = $this->getPeriodosArreglo($fi,$ff);
        // foreach($periodos as $key=>$periodo){
        //     $monto = $this->User->query(
        //         "SELECT SUM(monto) as montos,SUM(unidades) as unidades
        //         FROM objetivos_ventas_desarrollos 
        //         WHERE fecha <= '".$key."-01' 
        //         AND fin >= '".$key."-31' 
        //         AND cuenta_id =  $cuenta_id");
          
        //     if ( $monto[0][0]['montos)']>0 || $monto[0][0]['unidades']>0) {
        //         $kpi_arreglo[$i]['periodo'] = $periodo;
        //         $kpi_arreglo[$i]['objetivo_monto'] = $monto[0][0]['montos']==NULL ? 0 : $monto[0][0]['montos'];
        //         $kpi_arreglo[$i]['objetivo_q'] = $monto[0][0]['unidades']==NULL ? 0 : $monto[0][0]['unidades'];
               
        //     }else{
        //         if($kpi_arreglo[$i-1]['objetivo_monto'] !=0 ){
        //             $kpi_arreglo[$i]['periodo'] = $periodo;
        //             $kpi_arreglo[$i]['objetivo_monto'] = $kpi_arreglo[$i-1]['objetivo_monto'];
        //             $kpi_arreglo[$i]['objetivo_q'] = $kpi_arreglo[$i-1]['objetivo_q'];
        //         }
        //     }
            
        //     $i++;
        // }
        // $ventas = $this->User->query(
        //     "SELECT COUNT(*) as unidades,SUM(precio_cerrado) as monto , DATE_FORMAT(ventas.fecha,'%m-%Y') As fecha
        //     FROM ventas 
        //     WHERE fecha >= '$fi' 
        //     AND fecha <=  '$ff'
        //     AND cuenta_id = $cuenta_id
        //     GROUP BY DATE_FORMAT(ventas.fecha,'%m-%Y');
        //     "
        // );        
        // $i=0;
        // foreach ($kpi_arreglo as $arreglo) {
        //     $arreglo_completo[$i]['periodo']        = $arreglo['periodo'] ;
        //     $arreglo_completo[$i]['objetivo_monto'] = $arreglo['objetivo_monto'] ;
        //     $arreglo_completo[$i]['objetivo_q']     = $arreglo['objetivo_q'] ;
        //     foreach ($ventas as $value) {
        //         if ($value[0]['fecha'] == $arreglo['periodo']) {
        //             if ($arreglo_completo[$i]['objetivo_monto']==0) {
        //                 $arreglo_completo[$i]['objetivo_monto']=0;
        //             }
        //             if ($arreglo_completo[$i]['objetivo_q']==0) {
        //                 $arreglo_completo[$i]['objetivo_q']=0;
        //             }
        //             $arreglo_completo[$i]['ventas_q'] =  $value[0]['unidades'];
        //             $arreglo_completo[$i]['ventas_monto']   = $value[0]['monto']; 
        //         }
        //     }
        //     $i++;
        // }
        // $i=0;
        // foreach ($arreglo_completo as $periodo){
        //     if($periodo['objetivo_q']==0){
        //         $porciento_grafica = 0;
        //     } else{
        //         $porciento_grafica=(($periodo['ventas_q']/$periodo['objetivo_q'])*100);
        //     }
        //     $arreglo_meta[$i]['periodo']        = $periodo['periodo'] ;
        //     $arreglo_meta[$i]['objetivo_monto'] = $periodo['objetivo_monto'] ;
        //     $arreglo_meta[$i]['objetivo_q']     = $periodo['objetivo_q'] ;
        //     $arreglo_meta[$i]['ventas_q']       = ( empty($periodo['ventas_q'] ) ? 0  : $periodo['ventas_q']  );
        //     $arreglo_meta[$i]['ventas_monto']   = ( empty( $periodo['ventas_monto']) ? 0  :  $periodo['ventas_monto']);
        //     $arreglo_meta[$i]['cumplido']       = $porciento_grafica;
        //     $i++;
        // }
        if (empty($arreglo_meta)) {
            $arreglo_meta[$i]['periodo']        = 0;
            $arreglo_meta[$i]['objetivo_monto'] = 0;
            $arreglo_meta[$i]['objetivo_q']     = 0;
            $arreglo_meta[$i]['ventas_q']       = 0;
            $arreglo_meta[$i]['ventas_monto']   = 0; 
            $arreglo_meta[$i]['cumplido']       = 0;
        }
    
        echo json_encode( $arreglo_meta , true );
        exit();
        $this->autoRender = false; 
    }
    
    public function inventario($id=null){
        $this->set(compact('id'));
        // $id_desarrollo = $id;
        // $this->set;
    }

    public function control_table($id=null){

    }

    public function validation($id=null){

    }

    public function add_tarea($id=null){

    }

    public function proceso_tabla($id=null){

    }

    public function inicio_proceso($id=null){

    }

    public function edit_proceso($id=null){

    }

}
