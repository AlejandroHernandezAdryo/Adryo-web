<?php
App::uses('AppController', 'Controller');
/**
 * GruposUsuarios Controller
 *
 * @property GruposUsuario $GruposUsuario
 * @property PaginatorComponent $Paginator
 */
class GruposUsuariosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
       
	public function index() {
        $this->loadModel('User');
        $cuenta_id = $this->Session->read('CuentaUsuario.Cuenta.id');
        $grupo = $this->GruposUsuario->find(
            'all',array(
                //'recursive'=>2,
                'conditions'=>array(
                    'GruposUsuario.cuenta_id'=>$cuenta_id
                    )
                )
            );

        $this->set('grupos',$grupo);
        
        $this->set('g',$this->User->find('list',array('order'=>'nombre_completo ASC','conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE group_id IN (6) AND status = 1 AND cuenta_id = $cuenta_id)"))));
        $this->set('i',$this->User->find('list',array('order'=>'nombre_completo ASC','conditions'=>array("User.id IN (SELECT user_id FROM cuentas_users WHERE group_id = 3 AND status = 1 AND cuenta_id = $cuenta_id)"))));

        $this->loadModel('Desarrollo');
        $this->set(
            'desarrollos',
            $this->Desarrollo->find(
                'list',
                array(
                    'conditions'=>array(
                        'OR' => array(
                            'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                            'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'),
                        ), 
                    ),
                )
            )
        );
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $this->loadModel('Desarrollo');
            if (!$this->GruposUsuario->exists($id)) {
                    throw new NotFoundException(__('Invalid grupos'));
            }
            $this->GruposUsuario->Behaviors->load('Containable');
            $grupo = $this->GruposUsuario->find(
                    'first', 
                    array(
                        'recursive'=>2,
                        'fields'=>array(
                            'id','nombre_grupo','descripcion'
                        ),
                        'contain'=>array(
                            'Administrador'=>array(
                                'fields'=>array(
                                    'nombre_completo','correo_electronico','foto','id'
                                ),
                            ),
                            'Usuarios'=>array(
                                'fields'=>array(
                                    'id','nombre_completo','foto','correo_electronico','status','created'
                                ),
                                'Cliente'=>array(
                                    'fields'=>array(
                                        'created','status','last_edit','status','nombre','correo_electronico','telefono1','temperatura'
                                    ),
                                    'conditions'=>array(
                                        'Cliente.status'=>'Activo'
                                    ),
                                    'Desarrollo'=>array(
                                        'fields'=>array(
                                            'nombre'
                                        )
                                    ),
                                    'Inmueble'=>array(
                                        'fields'=>array(
                                            'titulo'
                                        )
                                    ),
                                    'DicLineaContacto'=>array(
                                        'fields'=>array(
                                            'linea_contacto'
                                        )
                                    ),
                                    'DicTipoCliente'=>array(
                                        'fields'=>array(
                                            'tipo_cliente'
                                        )
                                    ),
                                    'DicEtapa'=>array(
                                        'fields'=>array(
                                            'etapa'
                                        )
                                    ),
                                ),
                            ),
                            'Desarrollo'=>array(
                                'fields'=>array(
                                    'nombre','id'
                                ),
                                'FotoDesarrollo'=>array(
                                    'limit'=>'1'
                                )
                            )
                        ),
                        'conditions'=>array(
                            'GruposUsuario.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
                            'GruposUsuario.id'=>$id
                        )
                    )
            );
            $this->set('grupo', $grupo);

            $user_custom = array();
            $data_clientes_atencion      = array('oportunos'=>0, 'tardios'=>0, 'no_atendidos'=>0, 'por_reasignar'=>0, 'inactivos_temp'=>0);
            $date_current                = date('Y-m-d');
            $date_oportunos              = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
            $date_tardios                = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
            $date_no_atendidos           = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

            $clientes_equipo = array();
            $i=0;
  
            foreach ($grupo['Usuarios'] as $user) {
                $users_custom[$user['id']]['id']                 = $user['id'];
                $users_custom[$user['id']]['nombre_completo']    = $user['nombre_completo'];
                $users_custom[$user['id']]['foto']               = $user['foto'];
                $users_custom[$user['id']]['correo_electronico'] = $user['correo_electronico'];
                $users_custom[$user['id']]['status']             = $user['status'];
            
                foreach ($user['Cliente'] as $clientes) {
                    // echo date('Y', strtotime($clientes['created']))."<br>";
                    if (date('Y', strtotime($clientes['created'])) == date('Y') && $clientes['status'] === 'Activo') {
                    if ($clientes['last_edit'] <= $date_current.' 23:59:59' && $clientes['last_edit'] >= $date_oportunos) {$data_clientes_atencion['oportunos']++;}
                    elseif($clientes['last_edit'] < $date_oportunos.' 23:59:59' && $clientes['last_edit'] >= $date_tardios.' 00:00:00'){$data_clientes_atencion['tardios']++;}
                    elseif($clientes['last_edit'] < $date_tardios.' 23:59:59' && $clientes['last_edit'] >= $date_no_atendidos.' 00:00:00'){$data_clientes_atencion['no_atendidos']++;}
                    elseif($clientes['last_edit'] < $date_no_atendidos.' 23:59:59' && $clientes['last_edit'] >= '0000-00-00 00:00:00'){$data_clientes_atencion['por_reasignar']++;}
                    else{$data_clientes_atencion['por_reasignar']++;}
                    }

                    $clientes_equipo[$i]=array(
                        'id'=>$clientes['id'],
                        'temperatura'=>$clientes['temperatura'],
                        'last_edit'=>$clientes['last_edit'],
                        'status'=>$clientes['status'],
                        'nombre'=>$clientes['nombre'],
                        'desarrollo'=>!empty($clientes['Desarrollo'])?$clientes['Desarrollo']['nombre']:"",
                        'inmueble'=>!empty($clientes['Inmueble'])?$clientes['Inmueble']['titulo']:"",
                        'correo_electronico'=>$clientes['correo_electronico'],
                        'telefono1'=>$clientes['telefono1'],
                        'linea_contacto'=>!empty($clientes['DicLineaContacto'])?$clientes['DicLineaContacto']['linea_contacto']:"",
                        'tipo_cliente'=>!empty($clientes['DicTipoCliente'])?$clientes['DicTipoCliente']['tipo_cliente']:"",
                        'etapa'=>!empty($clientes['DicEtapa'])?$clientes['DicEtapa']['etapa']:"",
                        'created'=>$clientes['created'],
                        'asesor'=>$user['nombre_completo'],
                        'asesor_id'=>$user['id'],

                    );
                    $i++;

                } // Fin del foreach de clientes.
                $users_custom[$user['id']]['oportunos']     = $data_clientes_atencion['oportunos'];
                $users_custom[$user['id']]['tardios']       = $data_clientes_atencion['tardios'];
                $users_custom[$user['id']]['no_atendidos']  = $data_clientes_atencion['no_atendidos']; 
                $users_custom[$user['id']]['por_reasignar'] = $data_clientes_atencion['por_reasignar'];
            
                $data_clientes_atencion['oportunos']     = 0;
                $data_clientes_atencion['tardios']       = 0;
                $data_clientes_atencion['no_atendidos']  = 0;
                $data_clientes_atencion['por_reasignar'] = 0;
                } // Fin del foreach de usuarios.
            
            // print_r($users_custom);
            $this->set('users_custom', $users_custom);
            $this->set('clientes_equipo', $clientes_equipo);

            $this->set('grupos',$this->GruposUsuario->find('list',array('conditions'=>array('GruposUsuario.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),"GruposUsuario.id != $id"))));
            $this->loadModel('Desarrollo');
            $this->Desarrollo->Behaviors->load('Containable');
            $this->set(
                'desarrollos',
                $this->Desarrollo->find(
                    'all',
                    array(
                        'fields'=>array(
                            'id','nombre'
                        ),
                        'contain'=>false,
                        'conditions'=>array(
                            'OR'=>array(
                                'Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
                                'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),
                            ),
                            'AND'=>array(
                                'Desarrollo.grupos_usuario_id IS NULL'
                            )
                            
                        ),
                        'order'=>'nombre ASC'
                    )
                )
            );
	}
        
        public function reasignar(){
            if ($this->request->is('post')) {
                $this->request->data['Desarrollo']['id'] = $this->request->data['GruposUsuario']['desarrollo_id'];
                $this->request->data['Desarrollo']['grupos_usuario_id'] = $this->request->data['GruposUsuario']['grupos_usuario_id'];
                $this->loadModel('Desarrollo');
                $this->Desarrollo->create();
                $this->Desarrollo->save($this->request->data);
                $this->Session->setFlash(__('El desarrollo ha sido reasignado exitosamente'),'default',array('class'=>'mensaje_exito'));
                return $this->redirect(array('action' => 'view',$this->request->data['GruposUsuario']['grupos_usuario_id']));
            }
        }
        
        
        
        public function asignar(){
            if ($this->request->is('post')) {
                $is_private = $this->request->data['GruposUsuario']['is_private'];
                $this->GruposUsuario->query("UPDATE desarrollos SET is_private = $is_private, grupos_usuario_id = ".$this->request->data['GruposUsuario']['grupo_id']." WHERE id =".$this->request->data['GruposUsuario']['desarrollo_id']);
                $this->Session->setFlash(__('El desarrollo ha sido asignado exitosamente'),'default',array('class'=>'mensaje_exito'));
                return $this->redirect(array('action' => 'view',$this->request->data['GruposUsuario']['grupo_id']));
            }
        }
        
        public function desasignar($id = null,$equipo_id = null) {
		$this->GruposUsuario->query("UPDATE desarrollos SET grupos_usuario_id = null WHERE id = $id");
                $this->Session->setFlash(__('El desarrollo ha sido eliminado del equipo exitosamente'),'default',array('class'=>'mensaje_exito'));
		return $this->redirect(array('action' => 'view',$equipo_id));
	}
        
        public function crear(){
            if ($this->request->is('post')) {
                echo var_dump($this->request->data['GruposUsuario']);
                $this->request->data['GruposUsuario']['cuenta_id']=$this->Session->read('CuentaUsuario.Cuenta.id');
                if (isset($this->request->data['GruposUsuario']['foto'])&&$this->request->data['GruposUsuario']['foto']['name']!=""){
                        $unitario = $this->request->data['GruposUsuario']['foto'];
                        $filename = getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/".$unitario['name'];
                        move_uploaded_file($unitario['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')."/".$unitario['name'];
                        $this->request->data['GruposUsuario']['imagen'] = $ruta;
                    }else{
                        $this->request->data['GruposUsuario']['imagen']="grupos_no_photo.png";
                    }
                $this->GruposUsuario->create();
                $this->GruposUsuario->save($this->request->data);
                $id = $this->GruposUsuario->getInsertID();
                foreach($this->request->data['GruposUsuario']['integrantes'] as $integrante):
                    $this->GruposUsuario->query("INSERT INTO grupos_usuarios_users VALUES(0,$integrante,$id)");
                endforeach;
                $this->Session->setFlash(__('El Equipo ha sido registrado exitosamente'),'default',array('class'=>'success'));
                return $this->redirect(array('action' => 'view','controller'=>'gruposUsuarios',$id));
            }
        }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->GruposUsuario->create();
			if ($this->GruposUsuario->save($this->request->data)) {
                            $this->GruposUsuario->query("UPDATE clientes SET last_edit = NOW() WHERE id = ".$this->request->data['GruposUsuario']['cliente_id']);
                                
                            if ($this->request->data['GruposUsuario']['asesoria']==1){
                                
                                $cliente = $this->Cliente->read(null,$this->request->data['GruposUsuario']['cliente_id']);
                                $usuario = $this->User->read(null, $this->request->data['GruposUsuario']['user_id']);
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
                                    $this->Email->template('asesoria','bosemail');
                                    $this->Email->from(array('sistema@bosinmobiliaria.com.mx'=>'GruposUsuario Sistema BOS'));
                                    if ($this->Session->read('Auth.User.group_id')==3){
                                        $this->Email->to(array(
                                            'desarrollos@boinmobiliaria.com.mx'=>'desarrollos@bosinmobiliaria.com.mx',
                                            'inmuebles@bosinmobiliaria.com.mx'=>'inmuebles@bosinmobiliaria.com.mx'
                                            ));
                                        $this->Email->subject('Asistencia requerida por parte del asesor');
                                    }else{
                                        $this->Email->to($cliente['User']['correo_electronico']);
                                        $this->Email->subject('Actualización de seguimiento de cliente');
                                    }
                                    
                                    $this->Email->viewVars(array('asesor'=>$usuario,'comentarios'=>$this->request->data['GruposUsuario']['mensaje'],'cliente' => $cliente,'fecha'=>date("d/M/Y H:i:s")));
                                    $this->Email->send();
                            }
                                    
                                $this->Session->setFlash('', 'default', array(), 'success');
								$this->Session->setFlash('El seguimiento rápido se ha guardado exitosamente.', 'default', array(), 'm_success');
				return $this->redirect(array('action' => 'view','controller'=>'clientes',$this->request->data['GruposUsuario']['cliente_id']));
			} else {
				$this->Session->setFlash(__('The grupos could not be saved. Please, try again.'));
			}
		}
		$users = $this->GruposUsuario->User->find('list');
		$leads = $this->GruposUsuario->Lead->find('list');
		$this->set(compact('users', 'leads'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->GruposUsuario->exists($id)) {
			throw new NotFoundException(__('Invalid grupos'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->GruposUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('The grupos has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The grupos could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('GruposUsuario.' . $this->GruposUsuario->primaryKey => $id));
			$this->request->data = $this->GruposUsuario->find('first', $options);
		}
		$users = $this->GruposUsuario->User->find('list');
		$leads = $this->GruposUsuario->Lead->find('list');
		$this->set(compact('users', 'leads'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->GruposUsuario->id = $id;
		if (!$this->GruposUsuario->exists()) {
			throw new NotFoundException(__('Invalid grupos'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->GruposUsuario->delete()) {
			$this->Session->setFlash(__('The grupos has been deleted.'));
		} else {
			$this->Session->setFlash(__('The grupos could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
