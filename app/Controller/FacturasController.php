<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class FacturasController extends AppController {
    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('RequestHandler');
    
    public $cuenta_id;
    public $status_factura;
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
        $this->status_factura = array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA');
    }

    public $uses = array(
        'Factura',
        'Desarrollo',
        'Proveedor',
        'Categoria',
        'User',
        'ValidacionCategoria',
        'Venta',
        'Aportacion',
        'Cliente',
        'Transaccion',
        'CuentasUser',
        'Banco',
        'CuentaBancariaDesarrollo',
        'DicFactura',
    );


    public function index(){
        $this->Factura->Behaviors->load('Containable');
        $tipo_gasto =array(
            'Factura'             => 'Factura',
            'Requisición de Pago' => 'Requisición de Pago',
            'Reembolso de Gasto'  => 'Reembolso de Gasto',
            'Pago de Servicios'   => 'Pago de Servicios',
            'Comisiones'          => 'Comisiones',
            'Impuestos'           => 'Impuestos',
        );

        // Permisos para visualizacion de facturas.
        if( $this->Session->read('Permisos.Group.facAll') == 1 ){
            $condiciones_factura = array(
                'AND' => array(
                    'Factura.cuenta_id'       => $this->cuenta_id,
                    'Factura.proveedor_id <>' => '',
                )
            );
        }else{
            $condiciones_factura = array(
                'AND' => array(
                    'Factura.cuenta_id'       => $this->cuenta_id,
                    'Factura.proveedor_id <>' => '',
                ),
                'OR' => array(
                    'Factura.id IN ( Select factura_id From validacion_facturas Where user_id = '.$this->Session->read('Auth.User.id').')',
                    'Factura.user_id' => $this->Session->read('Auth.User.id'),
                )
            );
        }


        $facturas = $this->Factura->find( 'all', 
            array(
                'recursive'=>2,
                'fields'=>array(
                    'referencia','id','cliente_id','proveedor_id','fecha_emision','created',
                    'fecha_pago','concepto','total','estado','folio','comentario','tipo_gasto','user_id', 'linea_captura'
                ),
                'contain'=>array(
                    'Validador'=>array(
                        'fields'=>array(
                            'nombre_completo','id'
                        )
                    ),
                    'Categoria'=>array(
                        'fields'=>array(
                            'nombre'
                        )
                    ),
                    'Desarrollo'=>array(
                        'fields'=>array(
                            'nombre'
                        )
                    ),
                    'Cargado'=>array(
                        'fields'=>array(
                            'nombre_completo'
                        )
                    ),
                    'Pagos' => array(
                        'fields' => array(
                            'monto',
                            'fecha'
                        ),
                        'order' => 'Pagos.fecha DESC'
                    ),
                    'ValidacionFactura' => array(
                        'fields' => array(
                            'user_id'
                        )
                    )
                ),
                'conditions' => $condiciones_factura,

                'order' => 'Factura.fecha_emision DESC',
                // 'limit' => 10
            )
        );

        $proveedores = $this->Proveedor->find('list', array('order' => array('nombre_comercial' => 'ASC'), 'conditions' => array('cuenta_id' => $this->cuenta_id)));

        $clientes    = $this->Cliente->find('list', $this->cuenta_id);
        $conditions = array('Categoria.cuenta_id'=>$this->cuenta_id,'Categoria.desarrollo_id'=>0);
        $categorias = $this->Categoria->find('list',array('conditions'=>$conditions));
        
        $desarrollos = $this->Desarrollo->find('list',
            array(
                'conditions' => array(
                    'OR' => array(
                        'Desarrollo.cuenta_id' => $this->Session->read('CuentaUsuario.Cuenta.id'),
                        'Desarrollo.comercializador_id' => $this->Session->read('CuentaUsuario.Cuenta.id')
                    ),
                    'AND' => array(
                        'visible' => 1
                    )
                ),
                'order' => array(
                    'nombre' => 'ASC'
                )
            )
        );
        
        $this->set(compact('facturas', 'tipo_gasto', 'categorias'));
        $this->set(compact('proveedores'));
        $this->set(compact('clientes'));
        $this->set(compact('desarrollos'));
        $this->set('status_factura', $this->status_factura);

    }

    public function por_autorizar(){
        $this->Factura->Behaviors->load('Containable');
        $facturas = $this->Factura->find(
            'all', 
            array(
                'fields'=>array(
                    'referencia','id','cliente_id','proveedor_id','fecha_emision',
                    'fecha_pago','concepto','total','estado','folio','created'
                ),
                'contain'=>array(
                    'Validador'=>array(
                        'fields'=>array(
                            'nombre_completo','id'
                        )
                    ),
                    'Cargado'=>array(
                        'fields'=>array(
                            'nombre_completo'
                        )
                    )
                ),
                'conditions'=>array(
                    'Factura.cuenta_id'=>$this->cuenta_id,
                    'Factura.proveedor_id <>'=>'',
                    'Factura.aut_pendiente'=>$this->Session->read('Auth.User.id'),
                    'Factura.estado IN (0,1,4)'
                ), 
                'order'=>'fecha_emision DESC'));
        $proveedores = $this->Proveedor->find('list', $this->cuenta_id);
        $clientes    = $this->Cliente->find('list', $this->cuenta_id);
        $conditions = array('Categoria.cuenta_id'=>$this->cuenta_id,'Categoria.desarrollo_id'=>0);
        //$conditions = array('Categoria.cuenta_id'=>$this->cuenta_id,'Categoria.id IN (SELECT categoria_id FROM validacion_categorias WHERE estado = 1 AND user_id = '.$this->Session->read('Auth.User.id').')');
        $categorias = $this->Categoria->find('list',array('conditions'=>$conditions));
        //$dic_facturas = $this->DicFactura->find('list',array('conditions'=>array('DicFactura.cuenta_id'=>$this->cuenta_id)));
        $desarrollos = $this->Desarrollo->find('list', array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'))));
        
        $this->set(compact('facturas'));
        $this->set(compact('proveedores'));
        $this->set(compact('clientes'));
        $this->set(compact('categorias'));
        //$this->set(compact('dic_facturas'));
        $this->set(compact('desarrollos'));
        $this->set('status_factura', $this->status_factura);
    }

    /***************************************************
    *
    *   Agregar nuevas cuentas
    *
    ***************************************************/
    public function add(){
        if ($this->request->is(array('post', 'put'))) {
            // Formatear fechas
            $this->request->data['Factura']['fecha_emision'] = date('Y-m-d', strtotime($this->request->data['Factura']['fecha_emision']));
            $this->request->data['Factura']['fecha_pago']    = ($this->request->data['Factura']['fecha_pago']!="" ? date('Y-m-d', strtotime($this->request->data['Factura']['fecha_pago'])):null);
            $this->request->data['Factura']['cuenta_id']     = $this->cuenta_id;
            $this->request->data['Factura']['estado']        = 0;
            $this->request->data['Factura']['linea_captura'] = $this->request->data['Factura']['linea_captura'];
            $this->request->data['Factura']['created']       = date('Y-m-d H:i:s');
            $this->request->data['Factura']['user_id']       = $this->Session->read('Auth.User.id');
            $this->request->data['Factura']['iva']           = $this->request->data['Factura']['subtotal']*($this->request->data['Factura']['iva']-1);
            // Guardar los datos para la factura
            $this->Factura->save($this->request->data);
            $factura_id = $this->Factura->getInsertID();
            // Validacion para la factura.
            if (isset($this->request->data['Factura']['categoria_id'])) {
                $validaciones = $this->ValidacionCategoria->find('all',
                array('conditions'=>
                    array('ValidacionCategoria.categoria_id'=>
                        $this->request->data['Factura']['categoria_id'])
                    )
                );
                if ($validaciones != ""){
                    $next_user = $validaciones[0]['ValidacionCategoria']['user_id'];
                    $this->Factura->query("UPDATE facturas SET aut_pendiente = $next_user WHERE id = $factura_id");
                }
                foreach ($validaciones as $validacion) {
                    if ($validacion['ValidacionCategoria']['monto_maximo'] <= $this->request->data['Factura']['total']){
                        $user_id = $validacion['ValidacionCategoria']['user_id'];
                        $orden   = $validacion['ValidacionCategoria']['orden'];
                        $estado  = $validacion['ValidacionCategoria']['estado'];

                        $this->request->data['ValidacionCategoria']['user_id'] = $user_id;
                        $this->request->data['ValidacionCategoria']['orden']   = $orden;
                        if($validacion['ValidacionCategoria']['estado'] == 1){
                            $this->Factura->query("INSERT INTO validacion_facturas VALUES(0,$user_id,NOW(),$factura_id,$orden,$estado)");
                        }else{
                            $this->Factura->query("INSERT INTO validacion_facturas VALUES(0,$user_id,null,$factura_id,$orden,$estado)");
                        }
                    }
                }
            }
            
            
            mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id,0777);

            // Agregar los documentos de la factura
            if (isset($this->request->data['Factura']['archivos'][0]['name'])) {
                foreach ($this->request->data['Factura']['archivos'] as $archivo) {
                    $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
                    move_uploaded_file($archivo['tmp_name'],$filename);
                    $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
                    $this->Factura->query("INSERT INTO docs_facturas VALUES (0,'".$ruta."',".$factura_id.",'".$archivo['name']."')");
                }
            }


            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se han cargado exitosamente la factura.', 'default', array(), 'm_success'); // Mensaje
            switch ($this->request->data['Factura']['ruta']) {
                case 1:
                    $ruta = array('action'=>'add');
                break;
                case 2:
                    $ruta = array('controller'=>'clientes', 'action'=>'view', $this->request->data['Factura']['cliente_id']);
                break;
                case 3:
                    $ruta = array('controller'=>'desarrollos', 'action'=>'view', $this->request->data['Factura']['desarrollo_id']);
                break;
                case 4:
                    $ruta = array('controller'=>'clientes', 'action'=>'view_tercero', $this->request->data['Factura']['cliente_id']);
                break;
                case 5:
                    $ruta = array('controller'=>'facturas', 'action'=>'index');
                break;
                case 6:
                    $ruta = array('controller'=>'aportacions', 'action'=>'index');
                break;
            }
            $this->redirect($ruta);
        }
        // Traemos los proveedores y los desarrollos de la cuenta.
        $proveedors = $this->Proveedor->find('list');
        $categorias = $this->Categoria->find('list');
        $desarrollos = $this->Desarrollo->find('list', array('conditions'=>array('OR'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.Cuenta.id')))));
        $this->set(compact('proveedors'));
        $this->set(compact('desarrollos'));
        $this->set(compact('categorias'));
    }

    public function edit($id = null){
        if ($this->request->is(array('post', 'put'))) {
            $factura_id = $this->request->data['Factura']['id'];
            // Formatear fechas
            $this->request->data['Factura']['fecha_emision'] = date('Y-m-d', strtotime($this->request->data['Factura']['fecha_emision']));
            $this->request->data['Factura']['fecha_pago']    = ($this->request->data['Factura']['fecha_pago']!="" ? date('Y-m-d', strtotime($this->request->data['Factura']['fecha_pago'])):null);
            $this->request->data['Factura']['cuenta_id']     = $this->cuenta_id;
            $this->request->data['Factura']['estado']        = 0;
            $this->request->data['Factura']['user_id']       = $this->Session->read('Auth.User.id');
            $this->request->data['Factura']['iva']           = $this->request->data['Factura']['subtotal']*($this->request->data['Factura']['iva']-1);
            // Guardar los datos para la factura
            $this->Factura->save($this->request->data);
            
            //Eliminar Validaciones
            $this->Factura->query("DELETE FROM validacion_facturas WHERE factura_id = $factura_id");
            // Validacion para la factura.
            if (isset($this->request->data['Factura']['categoria_id'])) {
                $validaciones = $this->ValidacionCategoria->find('all',
                array('conditions'=>
                    array('ValidacionCategoria.categoria_id'=>
                        $this->request->data['Factura']['categoria_id'])
                    )
                );
                if ($validaciones != ""){
                    $next_user = $validaciones[0]['ValidacionCategoria']['user_id'];
                    $this->Factura->query("UPDATE facturas SET aut_pendiente = $next_user WHERE id = $factura_id");
                }
                foreach ($validaciones as $validacion) {
                    if ($validacion['ValidacionCategoria']['monto_maximo'] <= $this->request->data['Factura']['total']){
                        $user_id = $validacion['ValidacionCategoria']['user_id'];
                        $orden   = $validacion['ValidacionCategoria']['orden'];
                        $estado  = $validacion['ValidacionCategoria']['estado'];

                        $this->request->data['ValidacionCategoria']['user_id'] = $user_id;
                        $this->request->data['ValidacionCategoria']['orden']   = $orden;
                        if($validacion['ValidacionCategoria']['estado'] == 1){
                            $this->Factura->query("INSERT INTO validacion_facturas VALUES(0,$user_id,NOW(),$factura_id,$orden,$estado)");
                        }else{
                            $this->Factura->query("INSERT INTO validacion_facturas VALUES(0,$user_id,null,$factura_id,$orden,$estado)");
                        }
                    }
                }
            }
            
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se han registrado los cambios exitosamente.', 'default', array(), 'm_success'); // Mensaje
            switch ($this->request->data['Factura']['ruta']) {
                case 1:
                    $ruta = array('action'=>'add');
                break;
                case 2:
                    $ruta = array('controller'=>'clientes', 'action'=>'view', $this->request->data['Factura']['cliente_id']);
                break;
                case 3:
                    $ruta = array('controller'=>'desarrollos', 'action'=>'view', $this->request->data['Factura']['desarrollo_id']);
                break;
                case 4:
                    $ruta = array('controller'=>'clientes', 'action'=>'view_tercero', $this->request->data['Factura']['cliente_id']);
                break;
                case 5:
                    $ruta = array('controller'=>'facturas', 'action'=>'index');
                break;
                case 6:
                    $ruta = array('controller'=>'aportacions', 'action'=>'index');
                break;
            }
            $this->redirect($ruta);
        }else{
            $factura = $this->Factura->read(null,$id);
            $this->set('factura',$factura);
        }
        // Traemos los proveedores y los desarrollos de la cuenta.
        $proveedores = $this->Proveedor->find('list');
        $categorias = $this->Categoria->find('list',array('conditions'=>array('Categoria.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'))));
        $desarrollos = $this->Desarrollo->find('list', array('conditions'=>array('OR'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id'),'Desarrollo.comercializador_id'=>$this->Session->read('CuentaUsuario.Cuenta.id')))));
        $this->set(compact('proveedores'));
        $this->set(compact('desarrollos'));
        $this->set(compact('categorias'));
    }

    /***************************************************************
    * Configuración de los persmisos de categoria para las facturas.
    *
    ***************************************************************/
    public function permisos_usuarios($categoria_id = null, $desarrollo_id = null){
        if ($this->request->is(array('post', 'put'))) {
            $this->ValidacionCategoria->query("DELETE FROM validacion_categorias WHERE categoria_id = $categoria_id");

            
            //Guardar Validaciones
            $j =1;
            for($i=0;$i<10 ;$i++){
                if ($this->request->data['ValidacionCategoria']['validador_user_id'.$i]!=0){
                    $this->request->data['ValidacionCategoria']['user_id']=$this->request->data['ValidacionCategoria']['validador_user_id'.$i];
                    $this->request->data['ValidacionCategoria']['orden']=$j;
                    $this->request->data['ValidacionCategoria']['monto_maximo']=$this->request->data['ValidacionCategoria']['monto_maximo'.$i];
                    $this->request->data['ValidacionCategoria']['estado']=2;
                    $this->ValidacionCategoria->create();
                    $this->ValidacionCategoria->save($this->request->data);
                    $j++;
                }
            }
            
            //Guardar validación de pago
            
            foreach ($this->request->data['ValidacionCategoria']['pago_user_id'] as  $pago):
                $this->request->data['ValidacionCategoria']['user_id']=$pago;
                $this->request->data['ValidacionCategoria']['orden']=$j;
                $this->request->data['ValidacionCategoria']['estado']=3;
                $this->request->data['ValidacionCategoria']['monto_maximo'] = 0;
                $this->ValidacionCategoria->create();
                $this->ValidacionCategoria->save($this->request->data);
            endforeach;
            
            $this->loadModel('Categoria');
            $desarrollos = ",";
            foreach ($this->request->data['ValidacionCategoria']['desarrollo_id'] as $desarrollo):
                $desarrollos = $desarrollos.$desarrollo.",";
            endforeach;
                $this->request->data['Categoria']['id'] = $this->request->data['ValidacionCategoria']['categoria_id'];
                $this->request->data['Categoria']['desarrollo_id'] = $desarrollos;
                $this->Categoria->save($this->request->data['Categoria']);
            
            return $this->redirect(array('controller'=>'facturas','action' => 'config_autorizacion'));
            
            
        }
        // Antes del post
        $usuarios = $this->User->find('list',array('order'=>array('User.nombre_completo ASC'),'conditions'=>array('User.status'=>1, 'User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->cuenta_id.')'), 'fields'=>array('id', 'nombre_completo', 'foto', 'correo_electronico', 'status'),'contain' => array('Cliente'=>array('fields'=>array('created', 'status', 'last_edit')))));
        $this->set(compact('usuarios'));
        $this->set('estados', array(1=>'Creación', 2=>'Revisión', 3=>'Pago'));
        $categoria = $this->Categoria->read(null,$categoria_id);
        $this->set(compact('categoria'));
        $this->set('desarrollo_id', $desarrollo_id);
        $this->loadModel('Desarrollo');
        $this->set('desarrollos',$this->Desarrollo->findListByCuentaIdOrComercializadorId($this->Session->read('CuentaUsuario.Cuenta.id'),$this->Session->read('CuentaUsuario.Cuenta.id')));
        $arreglo_pago = "";
        foreach($categoria['ValidacionPago'] as $pago){
            $arreglo_pago = $arreglo_pago.$pago['user_id'].",";
        }
        $this->set('pagos',$arreglo_pago);
    }
    
    /***************************************************************
    *Validación de pasos en las facturas.
    *
    Calendario
    Clientes 0
    Propiedades
    Desarrollos
    Asesores
    Equipos de Trabajo
    Finanzas0
    Ventas
    Configuración
    ***************************************************************/
    public function validar($id_validacion = null, $id_factura=null) {
        $dateTime = date('Y-m-d H:i:s');
        $this->Factura->query("UPDATE validacion_facturas SET validated = '".$dateTime."' WHERE id = $id_validacion");
        $this->Factura->Behaviors->load('Containable');
        $factura = $this->Factura->findFirstById($id_factura);
        $ultima_validacion = 0;
        for($i=1;$i<sizeof($factura['ValidacionFactura']);$i++){
            if ($factura['ValidacionFactura'][$i-1]['validated']!="" && $factura['ValidacionFactura'][$i]['validated']==""){
                $ultima_validacion = $factura['ValidacionFactura'][$i]['user_id'];
            }
        }
        if ($factura['Factura']['estado']==2){
            $this->Factura->query("UPDATE facturas SET aut_pendiente = 0 WHERE id = $id_factura");
        }else{
            $this->Factura->query("UPDATE facturas SET estado = 1, aut_pendiente = $ultima_validacion WHERE id = $id_factura");
        }
        $this->Session->write('facturas_por_autorizar',$this->Factura->find('count',array('conditions'=>array('Factura.aut_pendiente'=> $this->Session->read('Auth.User.id')))));
        $this->Session->setFlash('La factura ha sido validada exitosamente', 'default', array(), 'm_success');
        return $this->redirect(array('action' => 'pagos_factura','controller'=>'aportacions',$id_factura,2));
	}


    public function status(){
        if ($this->request->data['Factura']['estado']==5){
            $this->request->data['Factura']['aut_pendiente']=0;
        }
        $this->Factura->save($this->request->data);
        switch ($this->request->data['Factura']['redirect']) {
            case 0:
                $redirect = array('controller'=>'aportacions','action'=>'ver_plan_pagos',$this->request->data['Factura']['venta_id']);
                break;
            case 1:
                $redirect = array('controller'=>'aportacions','action'=>'pagos_factura',$this->request->data['Factura']['id'],2);
            break;
            default:
                $redirect = array('action'=>'index');
                break;
        }
        $this->redirect($redirect);
    }


    /***************************************************************
    *
    * Agregar facturas para clientes dependiendo de la venta realizada
    *
    ***************************************************************/
    public function add_factura_cliente($venta_id = null){
        $this->Venta->Behaviors->load('Containable');

        if ($this->request->is(array('post', 'put'))) {

            // print_r($this->request->data);
            $cliente_id  = $this->request->data['Factura']['cliente_id'];
            $inmueble_id = $this->request->data['Factura']['inmueble_id'];
            $this->request->data['Factura']['venta_id'] = $venta_id;
            $referencia = $this->request->data['Factura']['referencia'];

            // Apartados
            if ( !empty( $this->request->data['Factura']['apartado'] ) ) {
                
                $this->request->data['Factura']['fecha_emision'] = date('Y-m-d', strtotime($this->request->data['Factura']['fecha_apartado']));
                $this->request->data['Factura']['cuenta_id']     = $this->cuenta_id;
                $this->request->data['Factura']['estado']        = 0;
                $this->request->data['Factura']['cliente_id']    = $cliente_id;
                $this->request->data['Factura']['total']         = $this->request->data['Factura']['hidden_total_apartado'];
                $this->request->data['Factura']['referencia']    = 'Apartado de la propiedad '.$referencia;
                $this->request->data['Factura']['concepto']    = 'Apartado de la propiedad '.$referencia;
                $this->request->data['Factura']['inmueble_id']   = $inmueble_id;
                // Guardar los datos para la factura
                $this->Factura->create();
                $this->Factura->save($this->request->data);
                $apartado_id = $this->Factura->getInsertID();
                mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$apartado_id,0777);
//
//                // Agregar los documentos de la factura de apartados
//                if ($this->request->data['Factura']['doc_apartado'][0]['name'] != "") {
//                    foreach ($this->request->data['Factura']['doc_apartado'] as $archivo) {
//                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$apartado_id."/".$archivo['name'];
//                        move_uploaded_file($archivo['tmp_name'],$filename);
//                        $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$apartado_id."/".$archivo['name'];
//                        $this->Factura->query("INSERT INTO docs_facturas VALUES (0,'".$ruta."',".$apartado_id.")");
//                    }
//                }
            }


            // Contrato
            if ( !empty( $this->request->data['Factura']['contrato'] ) ) {

                $this->request->data['Factura']['fecha_emision'] = date('Y-m-d', strtotime($this->request->data['Factura']['fecha_contrato']));
                $this->request->data['Factura']['cuenta_id']     = $this->cuenta_id;
                $this->request->data['Factura']['estado']        = 0;
                $this->request->data['Factura']['cliente_id']    = $cliente_id;
                $this->request->data['Factura']['total']         = $this->request->data['Factura']['hidden_total_contrato'];
                $this->request->data['Factura']['referencia']    = 'Contrato de la propiedad '.$referencia;
                $this->request->data['Factura']['inmueble_id']   = $inmueble_id;
                // Guardar los datos para la factura
                $this->Factura->create();
                $this->Factura->save($this->request->data);
                $contrato_id = $this->Factura->getInsertID();
                mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$contrato_id,0777);
//
//                // Agregar los documentos de la factura de contratos
//                if ($this->request->data['Factura']['doc_contrato'][0]['name'] != "") {
//                    foreach ($this->request->data['Factura']['doc_contrato'] as $archivo) {
//                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$contrato_id."/".$archivo['name'];
//                        move_uploaded_file($archivo['tmp_name'],$filename);
//                        $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$contrato_id."/".$archivo['name'];
//                        $this->Factura->query("INSERT INTO docs_facturas VALUES (0,'".$ruta."',".$contrato_id.")");
//                    }
//                }
            }


            // Aportacion

            // Revisar cuantas mensualidades son para que se haga una factura por cada mensualidad del cliente.
            // mensualidades

            

                $referenciaAportacion = $this->request->data['Factura']['referencia'];
                
                for ($j = 0; $j<30;$j++){
                    if ($this->request->data['Factura']['activo'.$j]==1 && $this->request->data['Factura']['mensualidades'.$j] != "" && $this->request->data['Factura']['fecha_aportacion'.$j] != ""){
                        for ( $i=1; $i <= $this->request->data['Factura']['mensualidades'.$j]; $i++ ) { 

                            // Identificamos la primer factura para que despues de ella aumente la fecha de emisión a los 28 días posteriores.
                            if ( $i == 1 ) {
                                $fechaFacturacionBase = strtotime( $this->request->data['Factura']['fecha_aportacion'.$j] );
                            }else{
                                $mesAumentado = $i -1;
                                $fechaFacturacionBase = strtotime( $mesAumentado.' month', strtotime( $this->request->data['Factura']['fecha_aportacion'.$j]) );
                            }

                            $this->request->data['Factura']['fecha_emision'] = date( 'Y-m-d', $fechaFacturacionBase);
                            $this->request->data['Factura']['cuenta_id']     = $this->cuenta_id;
                            $this->request->data['Factura']['estado']        = 0;
                            $this->request->data['Factura']['cliente_id']    = $cliente_id;
                            $this->request->data['Factura']['total']         = $this->request->data['Factura']['aportacion'.$j];
                            $this->request->data['Factura']['referencia']    = 'Mensualidad numero '.$i.' de la propiedad '.$referencia;
                            $this->request->data['Factura']['inmueble_id']   = $inmueble_id;

                            // Guardar los datos de la factura
                            $this->Factura->create();
                            $this->Factura->save($this->request->data);
                        }

                        $aportacion_id = $this->Factura->getInsertID();
                        mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$aportacion_id,0777);
                    }
                }
//
//                // Agregar los documentos de la factura de aportacions
//                if ($this->request->data['Factura']['doc_aportacion'][0]['name'] != "") {
//                    foreach ($this->request->data['Factura']['doc_aportacion'] as $archivo) {
//                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$aportacion_id."/".$archivo['name'];
//                        move_uploaded_file($archivo['tmp_name'],$filename);
//                        $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$aportacion_id."/".$archivo['name'];
//                        $this->Factura->query("INSERT INTO docs_facturas VALUES (0,'".$ruta."',".$aportacion_id.")");
//                    }
//                }

            

            // Escrituracion
            if ( !empty( $this->request->data['Factura']['escrituracion'] ) ) {

                $this->request->data['Factura']['fecha_emision'] = date('Y-m-d', strtotime($this->request->data['Factura']['fecha_escrituracion']));
                $this->request->data['Factura']['cuenta_id']     = $this->cuenta_id;
                $this->request->data['Factura']['estado']        = 0;
                $this->request->data['Factura']['cliente_id']    = $cliente_id;
                $this->request->data['Factura']['total']         = $this->request->data['Factura']['hidden_total_escrituracion'];
                $this->request->data['Factura']['referencia']    = 'Escrituración de la propiedad '.$referencia;
                $this->request->data['Factura']['inmueble_id']   = $inmueble_id;
                // Guardar los datos para la factura
                $this->Factura->create();
                $this->Factura->save($this->request->data);
                $escrituracion_id = $this->Factura->getInsertID();
                mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$escrituracion_id,0777);
//
//                // Agregar los documentos de la factura de escrituracions
//                if ($this->request->data['Factura']['doc_escrituracion'][0]['name'] != "") {
//                    foreach ($this->request->data['Factura']['doc_escrituracion'] as $archivo) {
//                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$escrituracion_id."/".$archivo['name'];
//                        move_uploaded_file($archivo['tmp_name'],$filename);
//                        $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$escrituracion_id."/".$archivo['name'];
//                        $this->Factura->query("INSERT INTO docs_facturas VALUES (0,'".$ruta."',".$escrituracion_id.")");
//                    }
//                }
            }

            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se han cargado exitosamente las facturas correspondientes.', 'default', array(), 'm_success'); // Mensaje
            $this->redirect(array('action'=>'ver_plan_pagos','controller'=>'aportacions', $venta_id));

        }

        // Consultar los datos de venta para sacar el cliente.
        $this->set('venta', $this->Venta->find('first', array('conditions'=>array('Venta.id'=>$venta_id), 'contain'=>array('Inmueble'=>array('fields'=>array('id','titulo', 'referencia')), 'User', 'Cliente'=>array('fields'=>array('id', 'nombre', 'correo_electronico', 'telefono1', 'telefono2'))))));
        $this->set('opciones_tipo_monto', array(1=>'Monto Fijo',2=>'Porcentaje'));
    }

    public function view($factura_id = null){
        $this->CuentaBancariaDesarrollo->Behaviors->load('Containable');
        $this->Factura->Behaviors->load('Containable');
        $factura = $this->Factura->find('first', array('recursive'=>2,'conditions'=>array('Factura.id'=>$factura_id), 'contain'=>array('Proveedor', 'Desarrollo'=>array('fields'=>array('id', 'nombre', 'calle', 'numero_ext', 'colonia', 'delegacion', 'cp')), 'Cliente', 'ValidacionFactura', 'Documentos')));
        
        $users   = $this->User->find('list', array('conditions'=>array('User.id IN (SELECT user_id From cuentas_users WHERE cuentas_users.cuenta_id = '.$this->cuenta_id.')')));
        /*$cuentasB = $this->CuentaBancariaDesarrollo->find('all', array('recursive'=>0,'conditions'=>array('CuentaBancariaDesarrollo.desarrollo_id'=>$factura['Factura']['desarrollo_id']), 'contain'=>array('CuentasBancarias'=>array('fields'=>array('id', 'nombre_cuenta')))));*/

        // Búsqueda de los arvhivos relacionados con la factura.
        /*$docs_facturas = $this->Factura->find('first', array('conditions'=>array('Factura.id'=>$factura_id)));*/
        $pagos = $this->Transaccion->find('all', array('conditions'=>array('Transaccion.factura_id'=>$factura_id)));


        // Hacer la lista de las cuentas bancarias para este desarrollo.
        /*if (!empty($cuentasB)) {
            foreach ($cuentasB as $cuenta) {
                $ctabancaria[$cuenta['CuentasBancarias']['id']] = $cuenta['CuentasBancarias']['nombre_cuenta'];
            }
        }else{
            $ctabancaria = array();
        }*/
        $ctabancaria = $this->Banco->find('list', array('conditions'=>array('Banco.cuenta_id'=>$this->cuenta_id)));
        // print_r($cuentasB);
        $this->set(compact('factura'));
        $this->set(compact('pagos'));
        $this->set(compact('users'));
        $this->set(compact('ctabancaria'));
        $this->set('forma_pago', array('Efectivo'=>'Efectivo', 'TEF'=>'TEF', 'Cheque'=>'Cheque','Tarjeta Bancaria'=>'Tarjeta Bancaria'));
        $this->set('status_factura', $this->status_factura);
        $this->set('status_pago', $this->status_pago);
    }


    public function add_documento($factura_id = null){

        if ($this->request->data['Factura']['archivos'][0]['name'] != "") {
            foreach ($this->request->data['Factura']['archivos'] as $archivo) {
                $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
                move_uploaded_file($archivo['tmp_name'],$filename);
                $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
                $this->Factura->query("INSERT INTO docs_facturas VALUES (0,'".$ruta."',".$factura_id.",'".$archivo['name']."')");
            }
        }

//        switch ($this->request->data['Factura']['redirect']) {
//            case 0:
//                $redirect = array('action'=>'view', $factura_id);
//                break;
//            
//            default:
//                $redirect = array('controller'=>'aportacions', 'action'=>'view', $factura_id);
//                break;
//        }
        $redirect = array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura_id,2);
        $this->redirect($redirect);
              
        // $this->redirect(array('action'=>'view', $factura_id));
    }



    /*******************************************************************
    *
    *   Configuración de permisos para facturas.
    *
    *******************************************************************/


    public function config_tipo_factura( $categoria_id = null ){


        if ($this->request->is( array( 'post', 'put' ) ) ) {
            $this->request->data['ValidacionCategoria']['categoria_id'] = $categoria_id;
            $this->ValidacionCategoria->create();
            $this->ValidacionCategoria->save($this->request->data);

            return $this->redirect(array('action' => 'config_tipo_factura',$categoria_id));
        }


        // Variables para guardar los datos de validación por usuarios.
        $usuarios = $this->User->find('list',array('order'=>array('User.status DESC', 'User.nombre_completo ASC'),'conditions'=>array('User.id IN (SELECT user_id FROM cuentas_users WHERE cuenta_id = '.$this->cuenta_id.')'), 'fields'=>array('id', 'nombre_completo', 'foto', 'correo_electronico', 'status'),'contain' => array('Cliente'=>array('fields'=>array('created', 'status', 'last_edit')))));
        $categoria = $this->Categoria->read(null,$categoria_id);

        $this->set(compact('usuarios'));
        $this->set(compact('categoria'));
        $this->set('estados', array(1=>'Creación', 2=>'Revisión', 3=>'Pago'));
    }
    
    public function config_autorizacion(){
        $this->loadModel('Categoria');
        $this->loadModel('DicFactura');
        $this->set('categorias_facturas',$this->DicFactura->find('list',array('conditions'=>array('DicFactura.cuenta_id'=>$this->cuenta_id))));
        $this->set('categorias',$this->Categoria->find('all',array('conditions'=>array('Categoria.cuenta_id'=>$this->cuenta_id))));
        
    }
    
    function delete_archivo($id = null) {
        $this->loadModel('DocsFactura');
        $documento = $this->DocsFactura->read(null,$id);
        //echo var_dump();
        unlink(getcwd().$documento['DocsFactura']['url']);
        $this->Factura->query("DELETE FROM docs_facturas WHERE id = $id");
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('El archivo ha sido eliminado exitosamente.', 'default', array(), 'm_success');
        $redirect = array('controller'=>'aportacions', 'action'=>'pagos_factura', $documento['DocsFactura']['factura_id'],2);
        $this->redirect($redirect);
        
    }
    
    function delete_archivo_pagos($id = null, $factura_id = null) {
        $this->loadModel('DocsTransaccion');
        $documento = $this->DocsTransaccion->read(null,$id);
        //echo var_dump();
        unlink(getcwd().$documento['DocsTransaccion']['url']);
        $this->Factura->query("DELETE FROM docs_transaccions WHERE id = $id");
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash('El archivo ha sido eliminado exitosamente.', 'default', array(), 'm_success');
        $redirect = array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura_id,2);
        $this->redirect($redirect);
        
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash(__('Factura invalida', true), 'default' ,array('class'=>'m_success'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Factura->delete($id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('La factura ha sido eliminado exitosamente.', 'default', array(), 'm_success');
            $this->redirect(array('action'=>'index','controller'=>'facturas'));
        }
    }
    
    public function getValidaciones(){
        $this->loadModel('Categoria');
        $validaciones = array();
        if (isset($this->request['data']['desarrollo_id'])) {
            if (empty($this->request['data']['desarrollo_id'])){
                $condiciones = array('Categoria.cuenta_id'=>$this->cuenta_id,'Categoria.desarrollo_id'=>0);
                /*$condiciones = 
                        array('Categoria.cuenta_id'=>$this->cuenta_id,'Categoria.id IN (SELECT categoria_id FROM validacion_categorias WHERE estado = 1 AND user_id = '.$this->Session->read('Auth.User.id').')'
                    );*/
            }else{
                $condiciones = array(
                        'Categoria.desarrollo_id LIKE "%,'.$this->request['data']['desarrollo_id'].',%"'
                    );
            }
            $validaciones = $this->Categoria->find(
                'list',
                array(
                    'fields'=>array(
                        'Categoria.id','Categoria.nombre'
                    ),
                    'conditions'=>$condiciones,
                )
            );
        }
        header('Content-Type: application/json');
        echo json_encode($validaciones);
        exit();
    }

    public function getFolio(){
        //$this->request['data']['folio'] = '009';
        $validaciones = array();
        $validaciones['respuesta'] = 0;
        if (isset($this->request['data']['folio'])) {
            if (!empty($this->request['data']['folio'])){
                $existe=$this->Factura->find('count',array('conditions'=>array('Factura.folio'=>$this->request['data']['folio'])));
                if ($existe > 0){
                    $validaciones['respuesta'] = 1;
                }else{
                    $validaciones['respuesta'] = 0;
                }
            }else{
                $validaciones['respuesta'] = 0;
            }
        } 
        header('Content-Type: application/json');
        echo json_encode($validaciones);
        exit();    
        
    }

    public function facturasAll () {
        $this->Factura->Behaviors->load('Containable');
        $facturas = $this->Factura->find( 'all', 
            array(
                'recursive'=>2,
                'fields'=>array(
                    'referencia','id','cliente_id','proveedor_id','fecha_emision','created',
                    'fecha_pago','concepto','total','estado','folio','comentario','tipo_gasto','user_id'
                ),
                'contain'=>array(
                    'Validador'=>array(
                        'fields'=>array(
                            'nombre_completo','id'
                        )
                    ),
                    'Categoria'=>array(
                        'fields'=>array(
                            'nombre'
                        )
                    ),
                    'Desarrollo'=>array(
                        'fields'=>array(
                            'nombre'
                        )
                    ),
                    'Cargado'=>array(
                        'fields'=>array(
                            'nombre_completo'
                        )
                    ),
                    'Pagos' => array(
                        'fields' => array(
                            'monto',
                            'fecha'
                        ),
                        'order' => 'Pagos.fecha DESC'
                    )
                ),
                'conditions'=>array(
                    'Factura.cuenta_id'=>$this->cuenta_id,
                    'Factura.proveedor_id <>'=>''
                ), 
                'order'=>'Factura.fecha_emision DESC'
            )
        );
        echo "<pre>";
        print_r( $facturas );
        echo "</pre>";

        $this->autoRender = false; 
    }

    public function last_id(){
        $this->Factura->Behaviors->load('Containable');
        $last_id = $this->Factura->find('first', array('conditions' => array('Factura.cuenta_id' => $this->cuenta_id), 'order' => array('id' => 'DESC'), 'fields' => 'Factura.id', 'contain' => false));

        echo json_encode( intval($last_id['Factura']['id']) );
        $this->autoRender = false;

    }

    public function delete_master(){

        $factura_id = $this->request->data['facturaId'];

        $factura = $this->Factura->find('first', array('conditions' => array( 'Factura.id' => $factura_id )));
        $this->Factura->id = $factura_id;

		if ($this->Factura->delete()) {
            
            rmdir(getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id);
            $mensaje = "Se ha eliminado correctamente la factura.";
            
        }else{
            $mensaje = "Hubo algun problema al intentar eliminar la factura y su directorio.";
        }
        
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->Session->setFlash('', 'default', array(), 'success');

        $this->autoRender = false;
    }
    
}

?>