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

    $this->set('etapas', $this->etapas_cliente);


    $this->Cliente->Behaviors->load('Containable');
    $conditions_e1 = array();
    $conditions_e2 = array();
    $conditions_e3 = array();
    $conditions_e4 = array();
    $conditions_e5 = array();
    $conditions_e6 = array();
    $conditions_e7 = array();
    $condicion_desarrollos = array();

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
          'nombre','id'
        ),
      ),
      'Lead'=>array(
        'conditions'=>array(
          'Lead.status'=>'Aprobado'
        ),
        'Desarrollo'=>array(
          'fields'=>array('nombre','id')
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

          array_push($conditions_e1,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          array_push($conditions_e2,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          array_push($conditions_e3,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          array_push($conditions_e4,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          array_push($conditions_e5,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          array_push($conditions_e6,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          array_push($conditions_e7,array('OR'=>array('Cliente.desarrollo_id'=>$this->request->data['Cliente']['desarrollo_id'],'Cliente.id IN (SELECT cliente_id FROM leads WHERE leads.status = "Aprobado" AND desarrollo_id = '.$this->request->data['Cliente']['desarrollo_id'].')')));
          
          $this->set('desarrollo_id',$this->request->data['Cliente']['desarrollo_id']);

          if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5) {
            
            $condicion_desarrollos = array(
              'Desarrollo.id'         => $this->Session->read('Desarrollos')
            );
            
          }


        }else {
          
          if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5) {
            
            $condicion_desarrollos = array(
              'Desarrollo.id'         => $this->Session->read('Desarrollos')
            );
            
            array_push($conditions_e1,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
            array_push($conditions_e2,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
            array_push($conditions_e3,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
            array_push($conditions_e4,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
            array_push($conditions_e5,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
            array_push($conditions_e6,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);
            array_push($conditions_e7,['Cliente.desarrollo_id'=>$this->Session->read('Desarrollos')]);

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
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 1
          );
          $conditions_e2 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 2
          );
          $conditions_e3 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 3
          );
          $conditions_e4 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 4
          );
          $conditions_e5 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 5
          );
          $conditions_e6 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 6
          );
          $conditions_e7 = array(
            'Cliente.status'        => array('Activo'),
            'Cliente.user_id <>'    => '',
            'Desarrollo.id'         => $this->Session->read('Desarrollos'),
            'Cliente.etapa' => 7
          );

          $condicion_desarrollos = array(
            'Desarrollo.id'         => $this->Session->read('Desarrollos')
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

    $tipo_propiedad = $this->DicTipoPropiedad->find('list',array('order'=>'DicTipoPropiedad.tipo_propiedad ASC','conditions'=>array('DicTipoPropiedad.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));

    $propiedades_text = array();
    foreach($tipo_propiedad as $tipo):
        $propiedades_text[$tipo] = $tipo;
    endforeach;

    // Variables para prospeccion
    $this->set( array('opciones_venta' => $this->opciones_venta, 'opciones_formas_pago' => $this->opciones_formas_pago, 'opciones_minimos' => $this->opciones_minimos, 'opciones_amenidades'=> $this->opciones_amenidades, 'propiedades_text' => $propiedades_text) );
    
  }