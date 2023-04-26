<?php
App::uses('AppController', 'Controller');
/**
 * Agendas Controller
 *
 * @property Agenda $Agenda
 * @property PaginatorComponent $Paginator
 */
class PublicidadsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
         public $uses = array('Publicidad','Event','User','Cliente','Inmueble','Desarrollo','LogCliente','LogInmueble','LogDesarrollo', 'Lead','Agenda');
         
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
             $this->Auth->allow('grafica_inversion_desarrollo', 'index');
        }

/**
 * index method
 *
 * @return void
 */
	public function index() {
            
            $eventos = $this->Event->find('all', array('conditions'=>array('or'=>array('recordatorio_1 LIKE "'.date('Y-m-d H:i').'%"','recordatorio_2 LIKE "'.date('Y-m-d H:i').'%"'))));
                
            //$eventos = $this->Event->find('all', array('conditions'=>array('Event.id'=>95)));
            $this->set('eventos',$eventos);
            foreach ($eventos as $evento):
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
                $this->Email->template('recordatorio','bosemail');
                $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
                $this->Email->to($evento['To']['correo_electronico']);
                $this->Email->subject('Recordatorio de Evento');
                $this->Email->viewVars(array('evento'=>$evento));
                $this->Email->send();
            endforeach;
	}
        
    public function enviar(){
        
        $eventos = $this->Event->find('all', array('conditions'=>array('recordatorio_1 LIKE "'.date('Y-m-d H:i').'%"')));
        //$eventos = $this->Event->find('all', array('conditions'=>array('Event.id'=>95)));
        foreach ($eventos as $evento):
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
            $this->Email->template('recordatorio','bosemail');
            $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'Agenda Sistema BOS'));
            $this->Email->to($evento['User']['correo_electronico']);
            $this->Email->subject('Recordatorio de Evento');
            $this->Email->viewVars(array('evento'=>$evento));
            $this->Email->send();
        endforeach;
        
    }


	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$options = array('conditions' => array('Agenda.' . $this->Agenda->primaryKey => $id));
		$this->set('agenda', $this->Agenda->find('first', $options));
	}

public function add_inmueble() {
    $mensaje = '';
    if ($this->request->is('post')) {
        $fecha_inicial = $this->request->data['Publicidad']['fecha_inicio'];
        for( $i = 0; $i < $this->request->data['Publicidad']['meses']; $i ++ ){
            $mas1mes = date("Y-m-d H:i:s",strtotime($fecha_inicial."+ ".$i." month"));
            $this->request->data['Publicidad']['inmueble_id']           = $this->request->data['Publicidad']['inmueble_id'];
            $this->request->data['Publicidad']['user_id']               = $this->Session->read('Auth.User.id');
            $this->request->data['Publicidad']['nombre']                = $this->request->data['Publicidad']['nombre'];
            $this->request->data['Publicidad']['objetivo']              = $this->request->data['Publicidad']['objetivo'];
            $this->request->data['Publicidad']['inversion_prevista']    = $this->request->data['Publicidad']['inversion_prevista'];
            $this->request->data['Publicidad']['dic_linea_contacto_id'] = $this->request->data['Publicidad']['dic_linea_contacto_id'];
            $this->request->data['Publicidad']['fecha_inicio']          = $mas1mes;
            $this->request->data['Publicidad']['cuenta_id']             = $this->Session->read('CuentaUsuario.Cuenta.id');
            $this->request->data['Publicidad']['status']                = 1;

            $this->Publicidad->create();
            if($this->Publicidad->save($this->request->data)){
                $mensaje = 'Se ha guardado correctamente la publicidad invertida.';
            }else {
                $mensaje = 'Hubo un error al intentar guardar la publicidad invertida <br> Código: ESI-C-001.';
            }
        }
    }

    $this->Session->setFlash('', 'default', array(), 'success');
    $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
    $this->redirect(array('controller'=>'inmuebles', 'action' => 'view', $this->request->data['Publicidad']['inmueble_id']));
    // $this->autoRender = false;
}

public function add_desarrollo() {
    $mensaje = '';
    if ($this->request->is('post')) {
        $fecha_inicial = $this->request->data['Publicidad']['fecha_inicio'];
        for( $i = 0; $i < $this->request->data['Publicidad']['meses']; $i ++ ){
            $mas1mes = date("Y-m-d H:i:s",strtotime($fecha_inicial."+ ".$i." month"));
            $this->request->data['Publicidad']['desarrollo_id']           = $this->request->data['Publicidad']['desarrollo_id'];
            $this->request->data['Publicidad']['user_id']               = $this->Session->read('Auth.User.id');
            // $this->request->data['Publicidad']['nombre']                = $this->request->data['Publicidad']['nombre'];
            // $this->request->data['Publicidad']['objetivo']              = $this->request->data['Publicidad']['objetivo'];
            $this->request->data['Publicidad']['inversion_prevista']    = $this->request->data['Publicidad']['inversion_prevista'];
            $this->request->data['Publicidad']['dic_linea_contacto_id'] = $this->request->data['Publicidad']['dic_linea_contacto_id'];
            $this->request->data['Publicidad']['fecha_inicio']          = $mas1mes;
            $this->request->data['Publicidad']['cuenta_id']             = $this->Session->read('CuentaUsuario.Cuenta.id');
            $this->request->data['Publicidad']['status']                = 1;

            $this->Publicidad->create();
            if($this->Publicidad->save($this->request->data)){
                $mensaje = 'Se ha guardado correctamente la publicidad invertida.';
            }else {
                $mensaje = 'Hubo un error al intentar guardar la publicidad invertida <br> Código: ESI-C-002.';
            }
        }
    }

    $this->Session->setFlash('', 'default', array(), 'success');
    $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
    $this->redirect(array('controller'=>'desarrollos', 'action' => 'view', $this->request->data['Publicidad']['desarrollo_id']));
    // $this->autoRender = false;
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
                        
                        $this->request->data['Event']['user_id']=$this->Session->read('Auth.User.id');
                        $this->request->data['Event']['recordatorio_1']= $recordatorio;
                        $this->request->data['Event']['recordatorio_2']= $recordatorio2;
			            $this->Event->create();
                        
                        if ($this->Event->save($this->request->data)) {
                                if($this->request->data['Event']['cliente_id']!=""){
                                    $this->LogCliente->create();
                                    $this->request->data['LogCliente']['id']=  uniqid();
                                    $this->request->data['LogCliente']['cliente_id']=$this->request->data['Event']['cliente_id'];
                                    $this->request->data['LogCliente']['user_id']=$this->Session->read('Auth.User.id');
                                    $this->request->data['LogCliente']['mensaje']="Evento de cliente modificado";
                                    $this->request->data['LogCliente']['accion']=$this->request->data['Event']['color'];
                                    $this->request->data['LogCliente']['datetime']=date('Y-m-d h:i:s');
                                    $this->LogCliente->save($this->request->data);
                                }
                                if($this->request->data['Event']['inmueble_id']!=""){
                                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                                    $this->request->data['LogInmueble']['mensaje'] = "Evento modificado";
                                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d H:i:s');
                                    $this->request->data['LogInmueble']['accion'] = $this->request->data['Event']['color'];
                                    $this->LogInmueble->create();
                                    $this->LogInmueble->save($this->request->data);
                                    
                                }
                                if($this->request->data['Event']['desarrollo_id']!=""){
                                    $this->request->data['LogDesarrollo']['desarrollo_id'] = $this->request->data['Event']['desarrollo_id'];
                                    $this->request->data['LogDesarrollo']['mensaje'] = "Evento modificado";
                                    $this->request->data['LogDesarrollo']['usuario_id'] = $this->Session->read('Auth.User.id');
                                    $this->request->data['LogDesarrollo']['fecha'] = date('Y-m-d');
                                    $this->request->data['LogDesarrollo']['accion'] = $this->request->data['Event']['color'];
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

	public function delete_inmueble( $id = null, $inmueble_id = null ) {

        $this->Publicidad->id = $id;
        if (!$this->Publicidad->exists()) {
            throw new NotFoundException(__('Invalid cliente'));
        }
        
        $this->request->onlyAllow('post', 'delete');

        if ($this->Publicidad->delete()) {
            
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Se ha eliminado correctamente la publicidad.', 'default', array(), 'm_success');
                        
        } else {
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('No se ha podido eliminar correctamente la publicidad.', 'default', array(), 'm_success');
        }

        $this->redirect( array( 'action' => 'view','controller'=>'inmuebles', $inmueble_id ) );
        
	}

    public function delete( $id = null, $desarrollo_id = null ) {

        $this->Publicidad->id = $id;
        if (!$this->Publicidad->exists()) {
            throw new NotFoundException(__('Invalid cliente'));
        }
        
        $this->request->onlyAllow('post', 'delete');

        if ($this->Publicidad->delete()) {
            
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Se ha eliminado correctamente la publicidad.', 'default', array(), 'm_success');
                        
        } else {
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('No se ha podido eliminar correctamente la publicidad.', 'default', array(), 'm_success');
        }

        $this->redirect( array( 'action' => 'view','controller'=>'desarrollos', $desarrollo_id) );
        
	}
        

    public function cerrar($id = null, $status = null){
        $this->Event->query("UPDATE events SET status = $status WHERE id = $id");
        return $this->redirect(array('action' => 'dashboard','controller'=>'users'));
    }

    public function reporte_m1(){
        
        if($this->request->is('post')){
            $this->loadModel('Cluster');
            $this->loadModel('Desarrollo');
            $this->loadModel('DicLineaContacto');
            $this->Cluster->Behaviors->load('Containable');
            $fi= date("Y-m-d",strtotime(substr($this->request->data['Desarrollo']['rango_fechas'],0,10)));
            $ff = date("Y-m-d",strtotime(substr($this->request->data['Desarrollo']['rango_fechas'],-10)));

            $this->set('fi',$fi);
            $this->set('ff',$ff);

            $periodo_reporte = ucwords(strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($fi)))).' al '.strftime("%d %B de %Y", strtotime(date("d-m-Y", strtotime($ff)))));
            $this->set('periodo_reporte',$periodo_reporte);
            $this->set('periodo_tiempo',$periodo_reporte);

            $desarrollos_id = "";
            $medios_id = "";
            foreach($this->request->data['Desarrollo']['desarrollos'] as $seleccion){
                if(substr($seleccion,0,1)=="D"){
                    $desarrollos_id = $desarrollos_id.substr($seleccion,1).",";
                }else{
                    $cluster = $this->Cluster->find(
                        'first',
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
            $this->set('desarrollos_id',$desarrollos_id);

            foreach($this->request->data['Desarrollo']['medios'] as $medio){
                $medios_id = $medios_id.$medio.",";
            }
            $medios_id = substr($medios_id,0,-1);
            $this->set('medios_id',$medios_id);

            $this->Desarrollo->Behaviors->load('Containable');
            $desarrollos = $this->Desarrollo->find(
                'all',
                array(
                    'conditions'=>array(
                        'Desarrollo.id IN('.$desarrollos_id.')'
                    ),
                    'fields'=>array(
                        'nombre','id'
                    ),
                    'contain'=>false
                )
            );
            $this->set(
                'desarrollos',
                $desarrollos
            );

            $this->DicLineaContacto->Behaviors->load('Containable');
            $medios = $this->DicLineaContacto->find(
                'all',
                array(
                    'conditions'=>array(
                        'DicLineaContacto.id IN('.$medios_id.')'
                    ),
                    'fields'=>array(
                        'linea_contacto','id'
                    ),
                    'contain'=>false
                )
            );
            $this->set('medios',$medios);

            $meses = $this->echoDate(strtotime($fi),strtotime($ff));
            $this->set('meses',$meses);

            /* Queries para sección de Tarjetas de indicadores*/
            $this->set('total_global',$this->Publicidad->query("SELECT SUM(inversion_prevista) AS inversion FROM publicidads WHERE desarrollo_id IN ($desarrollos_id) AND dic_linea_contacto_id IN ($medios_id)"));
            $this->set('ventas_global_monto',$this->Publicidad->query("SELECT SUM(precio_cerrado) AS ventas FROM ventas WHERE inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id)) AND cliente_id IN (SELECT id FROM clientes WHERE dic_linea_contacto_id IN ($medios_id))"));
            $this->set('total_leads_global',$this->Publicidad->query("SELECT COUNT(*) AS leads FROM leads WHERE desarrollo_id IN ($desarrollos_id) AND cliente_id AND leads.dic_linea_contacto_id IN ($medios_id) AND leads.dic_linea_contacto_id IS NOT NULL"));
            $this->set('ventas_global',$this->Publicidad->query("SELECT COUNT(*) AS ventas FROM ventas WHERE inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id)) AND cliente_id IN (SELECT id FROM clientes WHERE dic_linea_contacto_id IN ($medios_id))"));

            //$this->set('total_leads_pp',$this->Publicidad->query("SELECT COUNT(*) AS leads FROM leads WHERE desarrollo_id IN ($desarrollos_id) AND cliente_id IN (SELECT id FROM clientes WHERE DATE(created)<='".$ff."' AND DATE(created)>='".$fi."' AND dic_linea_contacto_id IN ($medios_id))"));
            $this->set('total_leads_pp',$this->Publicidad->query("SELECT COUNT(*) AS leads FROM leads WHERE desarrollo_id IN ($desarrollos_id) AND DATE(fecha)<='$ff' AND DATE(fecha)>='$fi' AND leads.dic_linea_contacto_id IN ($medios_id) AND leads.dic_linea_contacto_id IS NOT NULL"));
            $this->set('total_pp',$this->Publicidad->query("SELECT SUM(inversion_prevista) AS inversion FROM publicidads WHERE desarrollo_id IN ($desarrollos_id) AND dic_linea_contacto_id IN ($medios_id) AND DATE(fecha_inicio)<='".$ff."' AND DATE(fecha_inicio)>='".$fi."'"));
            $this->set('ventas_pp',$this->Publicidad->query("SELECT COUNT(*) AS ventas FROM ventas WHERE inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id)) AND DATE(fecha)<='$ff' AND DATE(fecha)>='$fi' AND cliente_id IN (SELECT id FROM clientes WHERE dic_linea_contacto_id IN ($medios_id))"));
            $this->set('ventas_pp_monto',$this->Publicidad->query("SELECT SUM(precio_cerrado) AS ventas FROM ventas WHERE inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id)) AND DATE(fecha)<='$ff' AND DATE(fecha)>='$fi' AND cliente_id IN (SELECT id FROM clientes WHERE dic_linea_contacto_id IN ($medios_id))"));

            /**Gráfica Total de Inversión en Publicidad VS Total de Leads Por Desarrollos Seleccionados (M1_1) **/
            $inversion_por_desarrollo = $this->Publicidad->query("SELECT desarrollo_id, SUM(inversion_prevista) AS inversion FROM publicidads WHERE desarrollo_id IN ($desarrollos_id) AND dic_linea_contacto_id IN ($medios_id) AND DATE(fecha_inicio)<='$ff' AND DATE(fecha_inicio)>='$fi' GROUP BY desarrollo_id");
            $i1 = array();
            foreach ($inversion_por_desarrollo as $registro){
                $i1[$registro['publicidads']['desarrollo_id']]=$registro[0]['inversion'];
            }
            //$this->set('inversion_por_desarrollo', $i1);

            //$total_leads_por_desarrollo = $this->Publicidad->query("SELECT desarrollo_id,COUNT(*) AS leads FROM leads WHERE desarrollo_id IN ($desarrollos_id) AND cliente_id IN (SELECT id FROM clientes WHERE DATE(created)<='$ff' AND DATE(created)>='$fi' AND dic_linea_contacto_id IN ($medios_id)) GROUP BY desarrollo_id");
            $total_leads_por_desarrollo = $this->Publicidad->query("SELECT desarrollo_id, COUNT(*) AS leads FROM leads WHERE DATE(fecha)<='$ff' AND DATE(fecha)>='$fi' AND dic_linea_contacto_id IN ($medios_id) AND desarrollo_id IN ($desarrollos_id) AND leads.dic_linea_contacto_id IS NOT NULL GROUP BY desarrollo_id");
            $i2 = array();
            
            foreach ($total_leads_por_desarrollo as $registro){
                $i2[$registro['leads']['desarrollo_id']]=$registro[0]['leads'];
            }
            //$this->set('total_leads_por_desarrollo',$total_leads_por_desarrollo);

                $arreglo_grafica_1 = array();
                foreach($desarrollos as $desarrollo){
                    $arreglo_grafica_1[$desarrollo['Desarrollo']['id']]=array(
                        'desarrollo' => $desarrollo['Desarrollo']['nombre'],
                        'inversion'  => isset($i1[$desarrollo['Desarrollo']['id']]) ? $i1[$desarrollo['Desarrollo']['id']]: 0,
                        'leads'      => isset($i2[$desarrollo['Desarrollo']['id']]) ? $i2[$desarrollo['Desarrollo']['id']] : 0,
                    );

                }
                $this->set('arreglo_grafica_m1_1',$arreglo_grafica_1);
            /** Fin de Grtáfica M1_1 */

            /**TOTAL DE LEADS VS VENTAS E INVERSIÓN POR MEDIO DE PROMOCIÓN (M1_2) **/
                $inversion_por_medio = $this->Publicidad->query("SELECT dic_linea_contacto_id, SUM(inversion_prevista) AS inversion FROM publicidads WHERE desarrollo_id IN ($desarrollos_id) AND dic_linea_contacto_id IN ($medios_id) AND DATE(fecha_inicio)<='$ff' AND DATE(fecha_inicio)>='$fi' GROUP BY dic_linea_contacto_id");
                //$this->set(compact('inversion_por_medio'));
                $i1 = array();
                foreach ($inversion_por_medio as $registro){
                    $i1[$registro['publicidads']['dic_linea_contacto_id']]=$registro[0]['inversion'];
                }

                $ventas_por_medio = $this->Publicidad->query("SELECT dic_linea_contacto_id, COUNT(*) AS ventas FROM clientes WHERE DATE(created)<='$ff' AND DATE(created)>='$fi' AND dic_linea_contacto_id IN ($medios_id) AND id IN (SELECT cliente_id FROM ventas WHERE inmueble_id IN (SELECT inmueble_id FROM desarrollo_inmuebles WHERE desarrollo_id IN ($desarrollos_id))) GROUP BY dic_linea_contacto_id");
                //$this->set(compact('ventas_por_medio'));
                $i2 = array();
                foreach ($ventas_por_medio as $registro){
                    $i2[$registro['clientes']['dic_linea_contacto_id']]=$registro[0]['ventas'];
                }

                $leads_por_medio = $this->Publicidad->query("SELECT dic_linea_contacto_id, COUNT(*) AS leads FROM leads WHERE DATE(fecha)<='$ff' AND DATE(fecha)>='$fi' AND dic_linea_contacto_id IN ($medios_id) AND desarrollo_id IN ($desarrollos_id) AND leads.dic_linea_contacto_id IS NOT NULL GROUP BY dic_linea_contacto_id");
                //$this->set(compact('leads_por_medio'));
                $i3 = array();
                foreach ($leads_por_medio as $registro){
                    $i3[$registro['leads']['dic_linea_contacto_id']]=$registro[0]['leads'];
                }

                $arreglo_grafica_2 = array();
                foreach($medios as $medio){
                    $arreglo_grafica_2[$medio['DicLineaContacto']['id']]=array(
                        'medio'=>$medio['DicLineaContacto']['linea_contacto'],
                        'inversion'=>isset($i1[$medio['DicLineaContacto']['id']]) ? $i1[$medio['DicLineaContacto']['id']]: 0,
                        'leads'=>isset($i3[$medio['DicLineaContacto']['id']]) ? $i3[$medio['DicLineaContacto']['id']] : 0,
                        'ventas'=>isset($i2[$medio['DicLineaContacto']['id']]) ? $i2[$medio['DicLineaContacto']['id']] : 0,
                    );

                }
                $this->set('arreglo_grafica_m1_2',$arreglo_grafica_2);               
            /** Fin de Grtáfica M1_2 */

            /**TOTAL DE LEADS VS VENTAS Y VISITAS POR MEDIO DE PROMOCIÓN (M1_3) **/
                //Utilizamos $i2 e $i3 de la gráfica anterior
                
                $i1 = array();
                $visitas_por_medio = $this->Publicidad->query("SELECT COUNT(*) AS visitas, clientes.dic_linea_contacto_id AS linea_contacto FROM events, clientes WHERE events.desarrollo_id IN ($desarrollos_id) AND DATE(events.fecha_inicio)<='$ff' AND DATE(events.fecha_inicio)>='$fi' AND clientes.id = events.cliente_id AND clientes.dic_linea_contacto_id IN ($medios_id) AND events.tipo_tarea = 1 GROUP BY linea_contacto");
                //$this->set(compact('visitas_por_medio'));
                foreach ($visitas_por_medio as $registro){
                    $i1[$registro['clientes']['linea_contacto']]=$registro[0]['visitas'];
                }

                $arreglo_grafica_3 = array();
                foreach($medios as $medio){
                    $arreglo_grafica_3[$medio['DicLineaContacto']['id']]=array(
                        'medio'=>$medio['DicLineaContacto']['linea_contacto'],
                        'visistas'=>isset($i1[$medio['DicLineaContacto']['id']]) ? $i1[$medio['DicLineaContacto']['id']]: 0,
                        'leads'=>isset($i3[$medio['DicLineaContacto']['id']]) ? $i3[$medio['DicLineaContacto']['id']] : 0,
                        'ventas'=>isset($i2[$medio['DicLineaContacto']['id']]) ? $i2[$medio['DicLineaContacto']['id']] : 0,
                    );

                }
                $this->set('arreglo_grafica_m1_3',$arreglo_grafica_3);

            /** Fin de Grtáfica M1_3 */

            /**COSTO POR LEAD VS TOTAL DE LEADS POR MEDIO DE PROMOCIÓN (M1_4) **/
                $i1 = array();
                foreach ($inversion_por_medio as $registro){
                    $i1[$registro['publicidads']['dic_linea_contacto_id']]=$registro[0]['inversion'];
                }

                $i2 = array();
                foreach ($leads_por_medio as $registro){
                    $i2[$registro['leads']['dic_linea_contacto_id']]=$registro[0]['leads'];
                }

                $arreglo_grafica_4 = array();
                foreach($medios as $medio){
                    $arreglo_grafica_4[$medio['DicLineaContacto']['id']]=array(
                        'leads'=>isset($i2[$medio['DicLineaContacto']['id']]) ? $i2[$medio['DicLineaContacto']['id']] : 0,
                        'cxlead'=>isset($i1[$medio['DicLineaContacto']['id']]) ? $i1[$medio['DicLineaContacto']['id']] / $i2[$medio['DicLineaContacto']['id']] : 0,
                        'medio' =>$medio['DicLineaContacto']['linea_contacto']
                    );

                }
                $this->set('arreglo_grafica_m1_4',$arreglo_grafica_4);
            /** Fin de Grtáfica M1_4 */

            /**COSTO UNITARIO POR LEAD VS VISITAS Y VENATAS POR MEDIO DE PROMOCIÓN (M1_5) **/
                //Usamos $i1 e $i2 para calcular el costo por lead
            
                $i3 = array();
                foreach ($visitas_por_medio as $registro){
                    $i3[$registro['clientes']['linea_contacto']]=$registro[0]['visitas'];
                }
                
                $i4 = array();
                foreach ($ventas_por_medio as $registro){
                    $i4[$registro['clientes']['dic_linea_contacto_id']]=$registro[0]['ventas'];
                }

                $arreglo_grafica_5 = array();
                foreach($medios as $medio){
                    $arreglo_grafica_5[$medio['DicLineaContacto']['id']]=array(
                        'ventas'  => isset($i4[$medio['DicLineaContacto']['id']]) ? $i4[$medio['DicLineaContacto']['id']] : 0,
                        'cxlead'  => isset($i1[$medio['DicLineaContacto']['id']]) ? $i1[$medio['DicLineaContacto']['id']] / $i2[$medio['DicLineaContacto']['id']] : 0,
                        'visitas' => isset($i3[$medio['DicLineaContacto']['id']]) ? $i3[$medio['DicLineaContacto']['id']]: 0,
                        'medio'   => $medio['DicLineaContacto']['linea_contacto']
                    );

                }
                $this->set('arreglo_grafica_m1_5',$arreglo_grafica_5);
            /** Fin de Grtáfica M1_5 */

            /**TOTAL DE LEADS VS COSTO POR LEAD E INVERSIÓN TOTAL POR MEDIO DE PROMOCIÓN (M1_6) **/
                $i1 = array();
                foreach ($inversion_por_medio as $registro){
                    $i1[$registro['publicidads']['dic_linea_contacto_id']]=$registro[0]['inversion'];
                }

                $i2 = array();
                foreach ($leads_por_medio as $registro){
                    $i2[$registro['leads']['dic_linea_contacto_id']]=$registro[0]['leads'];

                $arreglo_grafica_6 = array();
                foreach($medios as $medio){
                    $arreglo_grafica_6[$medio['DicLineaContacto']['id']]=array(
                        'leads'     => isset($i2[$medio['DicLineaContacto']['id']]) ? $i2[$medio['DicLineaContacto']['id']] : 0,
                        'cxlead'    => isset($i1[$medio['DicLineaContacto']['id']]) ? $i1[$medio['DicLineaContacto']['id']] / $i2[$medio['DicLineaContacto']['id']] : 0,
                        'inversion' => isset($i1[$medio['DicLineaContacto']['id']]) ? $i1[$medio['DicLineaContacto']['id']]: 0,
                        'medio'     => $medio['DicLineaContacto']['linea_contacto']
                    );

                }
                $this->set('arreglo_grafica_m1_6',$arreglo_grafica_6);
                }
            /** Fin de Grtáfica M1_6 */

            // Variable para la selección del campo de desarrollos.
            $this->set('desarrollos_seleccion', $this->request->data['Desarrollo']['desarrollos']);
            
        }

        $this->loadModel('Desarrollo');
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

        $this->loadModel('DicLineaContacto');
        $this->set(
            'list_medios',
            $this->DicLineaContacto->find(
                'list',
                array(
                    'conditions'=>array(
                        'DicLineaContacto.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id')
                    ),
                    'order'=>'DicLineaContacto.linea_contacto ASC'
                )
            )
        );
        
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

            $this->request->data['Event']['user_id']=$this->Session->read('Auth.User.id');
            $this->request->data['Event']['recordatorio_1']= $recordatorio;
            $this->request->data['Event']['recordatorio_2']= $recordatorio2;
            $this->Event->create();


            if ($this->Event->save($this->request->data)) {
                if($this->request->data['Event']['cliente_id']!=""){
                    $this->LogCliente->create();
                    $this->request->data['LogCliente']['id']=  uniqid();
                    $this->request->data['LogCliente']['cliente_id']=$this->request->data['Event']['cliente_id'];
                    $this->request->data['LogCliente']['user_id']=$this->Session->read('Auth.User.id');
                    $this->request->data['LogCliente']['mensaje']="Evento del cliente creado";
                    // $this->request->data['LogCliente']['accion']='1';
                    $this->request->data['LogCliente']['datetime']=date('Y-m-d h:i:s');
                    $this->LogCliente->save($this->request->data);
                }
                if($this->request->data['Event']['inmueble_id']!=""){
                    $this->request->data['LogInmueble']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                    $this->request->data['LogInmueble']['mensaje'] = "Evento asignado";
                    $this->request->data['LogInmueble']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogInmueble']['fecha'] = date('Y-m-d H:i:s');
                    $this->request->data['LogInmueble']['accion'] = $this->request->data['Event']['color'];
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

                    $this->request->data['Lead']['cliente_id'] = $this->request->data['Event']['cliente_id'];
                    $this->request->data['Lead']['inmueble_id'] = $this->request->data['Event']['inmueble_id'];
                    $this->request->data['Lead']['status'] = "Abierto";
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

    function echoDate( $start, $end ){

        $current = $start;
        $ret = array();

        while( $current<$end ){
            
            $next = @date('Y-M-01', $current) . "+1 month";
            $current = @strtotime($next);
            $ret[] = $current;
        }

        return array_reverse($ret);
    }

    function editPublicidad(){
        if($this->request->is('post')){
            $this->request->data['Publicidad']['fecha_inicio'] = date('Y-m-d',strtotime($this->request->data['Publicidad']['fecha_inicio']));
            if($this->Publicidad->save($this->request->data)){
                $this->Session->setFlash('', 'default', array(), 'success'); 
                $this->Session->setFlash('Se ha actualizado correctamente la publicidad invertida', 'default', array(), 'm_success');  
                return $this->redirect(array('action' => 'view','controller'=>'desarrollos',$this->request->data['Publicidad']['desarrollo_id']));
            }
        }
    }

    /**
     * 
     * 
     * 10/05/2022 - AKA (rogueOne).
     * Esta metodo hace la peticion para traer la informacion de la publicidad y edita esa misma publicidad 
     * Se tiene que agregar a la base de datos en la tabla de publicidad el campo de meses
    */
    function getPublicidad() {
        $this->Publicidad->Behaviors->load('Containable');

        header('Content-Type: application/json');
        $id =  $this->request->data['publicidad_id'];
        $publicidadData    = $this->Publicidad->find('first', array(
            'conditions' => array('Publicidad.id' => $id ),
            'fields' => array(
                'Publicidad.id',
                'Publicidad.dic_linea_contacto_id',
                'Publicidad.fecha_inicio',
                'Publicidad.inversion_prevista',
                'Publicidad.meses',
                'Publicidad.inversion_real',
            ),
            'contain' => false
        ));

        $publicidadData['Publicidad']['fecha_inicio'] = date('d-m-Y',strtotime($publicidadData['Publicidad']['fecha_inicio']));
        if(empty($publicidadData['Publicidad']['meses'])){
            $publicidadData['Publicidad']['meses'] = 1;
        }
        $publicidadData['Publicidad']['inversion_real'] = ($publicidadData['Publicidad']['inversion_prevista'])*($publicidadData['Publicidad']['meses']);
        
        echo json_encode($publicidadData, true);
        exit();
        $this->autoRender = false;
    }
    
    /**
    *esta funcion alimenta la grafica de inversiones por medio de publiicdad
    *del desarrollo, por los filtros de Id del desarrollo, fechas y cuenta
    * AKA RogueOne 
    * 
    */
    function grafica_inversion_desarrollo(){
        header('Content-type: application/json; charset=utf-8');    
        $desarrollo_id=0;
        $array_inversion=array();
        $cuenta_id= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $inversion=0;
        if ($this->request->is('post')) {
            $fecha_ini = substr($this->request->data['rango_fechas'], 0,10).' 00:00:00';
            $fecha_fin = substr($this->request->data['rango_fechas'], -10).' 23:59:59';
            $fi = date('Y-m-d H:i:s',  strtotime($fecha_ini));
            $ff = date('Y-m-d H:i:s',  strtotime($fecha_fin));
            if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = substr($this->request->data['desarrollo_id'], 1,3);
            }
            $inversion=$this->User->query(
                "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto 
                FROM publicidads, dic_linea_contactos
                WHERE publicidads.desarrollo_id=$desarrollo_id
                AND publicidads.fecha_inicio >= '$fi'
                AND  publicidads.fecha_inicio <= '$ff'
                AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
                GROUP BY linea_contacto;"
            );
            $array_inversion=array();
            $i=0;
            foreach ($inversion as $value) {
                $array_inversion[$i]['inversion']=$value[0]['inversion'];
                $array_inversion[$i]['medio']=$value['dic_linea_contactos']['linea_contacto'];
                $i++;
            }
        }
        // $fi='2016-10-01 00:00:00';
        // $ff='2022-03-01 23:59:59';
        // $desarrollo_id=246;
        // $inversion=$this->User->query(
        //     "SELECT SUM(inversion_prevista) as inversion, dic_linea_contactos.linea_contacto as linea_contacto 
        //     FROM publicidads, dic_linea_contactos
        //     WHERE publicidads.desarrollo_id=$desarrollo_id
        //     AND publicidads.fecha_inicio >= '$fi'
        //     AND  publicidads.fecha_inicio <= '$ff'
        //     AND dic_linea_contactos.id = publicidads.dic_linea_contacto_id 
        //     GROUP BY linea_contacto;"
        // );
        if (empty($array_inversion)) {
            $array_inversion[$i]['inversion']=0;
            $array_inversion[$i]['medio']="inversion 0";
        }
        echo json_encode( $array_inversion, true );
        exit();
        $this->autoRender = false;
    } 

}
?>
