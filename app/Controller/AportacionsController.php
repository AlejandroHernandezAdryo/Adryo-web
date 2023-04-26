<?php
App::uses('AppController', 'Controller');
/**
 * Aportacions Controller
 *
 * @property Aportacion $Aportacion
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AportacionsController extends AppController {

	public $cuenta_id;
	public $status_factura;
	public $status_pago;
    public function beforeFilter() {
        parent::beforeFilter();
		$this->cuenta_id      = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
		$this->status_factura = array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA');
		$this->status_pago    = array(1=>'Creación',2=>'Revisión',3=>'Pago');
    }

	public $components = array('Paginator', 'Session');
    public $uses = array(
    	'Aportacion',
    	'Cliente',
    	'Transaccion',
    	'Factura',
    	'User',
    	'CuentasUser',
    	'Banco',
    	'CuentaBancariaDesarrollo',
    	'Proveedor',
    	'DicFactura',
    );

	public function index($view = null) {
        /*$aportaciones = $this->Aportacion->find('all', array('conditions'=>array('Aportacion.cuenta_id'=>$this->cuenta_id)));*/
        $this->Factura->Behaviors->load('Containable');
        $condiciones = array(
                            'Factura.cuenta_id'=>$this->cuenta_id, 
                            'Factura.cliente_id <>'=>''
                        );
        if (isset($view)){
            $tiempo = array('Factura.estado = 0','Factura.fecha_emision <= CURDATE() + INTERVAL 30 DAY');
            array_push($condiciones,$tiempo);
            $this->set('label',1);
        }
        $aportaciones = $this->Factura->find(
                'all', 
                array(
                    'fields'=>array(
                        'id','referencia','folio','cliente_id','fecha_emision',
                        'fecha_pago','concepto','estado','total','proveedor_id'
                    ),
                    'contain'=>array(
                        'Cliente'=>array(
                            'fields'=>array(
                                'nombre'
                            )
                        ),
                    ),
                    'conditions'=>$condiciones, 
                    'order'=>'fecha_emision DESC'
                    )
                );
        $this->set(compact('aportaciones'));

        $categorias = $this->DicFactura->find('list',array('conditions'=>array('DicFactura.cuenta_id'=>$this->cuenta_id)));
        
        $this->set(compact('categorias'));
        $this->set('status_factura', $this->status_factura);
	}

	public function pagos_factura($factura_id = null, $tipo_transaccion = null){
        $this->CuentaBancariaDesarrollo->Behaviors->load('Containable');
        $this->Factura->Behaviors->load('Containable');
        $factura = $this->Factura->find('first', array('recursive'=>2,'conditions'=>array('Factura.id'=>$factura_id), 'contain'=>array('Venta'=>array('fields'=>'inmueble_id'),'Proveedor', 'Cliente', 'ValidacionFactura', 'Documentos', 'Cargado','Categoria','Desarrollo','Validador'=>array('fields'=>array('id')))));
        
        $users   = $this->User->find('list', array('conditions'=>array('User.id IN (SELECT user_id From cuentas_users WHERE cuentas_users.cuenta_id = '.$this->cuenta_id.')')));
        /*$cuentasB = $this->CuentaBancariaDesarrollo->find('all', array('recursive'=>0,'conditions'=>array('CuentaBancariaDesarrollo.desarrollo_id'=>$factura['Factura']['desarrollo_id']), 'contain'=>array('CuentasBancarias'=>array('fields'=>array('id', 'nombre_cuenta')))));*/
        $pagos = $this->Transaccion->find('all', array('conditions'=>array('Transaccion.factura_id'=>$factura_id)));

        // Hacer la lista de las cuentas bancarias para este desarrollo.
        /*if (!empty($cuentasB)) {
            foreach ($cuentasB as $cuenta) {
                $ctabancaria[$cuenta['CuentasBancarias']['id']] = $cuenta['CuentasBancarias']['nombre_cuenta'];
            }
        }else{
            $ctabancaria = array();
        }*/
        // if ($tipo_transaccion==1){
        //     $ctabancaria = $this->Banco->find('list', array('conditions'=>array('Banco.id IN (SELECT cuenta_bancaria_id FROM cuenta_bancaria_desarrollos WHERE desarrollo_id IN (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$factura['Venta']['inmueble_id'].'))','Banco.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        // }else{
        //     $ctabancaria = $this->Banco->find('list', array('conditions'=>array('Banco.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        // }
        // print_r($cuentasB);
        $ctabancaria = $this->Banco->find('list', array('conditions'=>array('Banco.status'=>1,'Banco.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))));
        $this->set(compact('factura'));
        $this->set(compact('tipo_transaccion'));
        $this->set('pagar', 0);
        $this->set(compact('pagos'));
        $this->set(compact('users'));
        $this->set(compact('ctabancaria'));
        $this->set('forma_pago', array('Efectivo'=>'Efectivo', 'TEF'=>'TEF', 'Cheque'=>'Cheque','Tarjeta Bancaria'=>'Tarjeta Bancaria'));
        $this->set('status_factura', $this->status_factura);
        $this->set('status_pago', $this->status_pago);
	}

	public function add_pago($factura_id = null, $tipo_transaccion = null){
		$this->Transaccion->create();
        $this->request->data['Transaccion']['fecha'] = date("Y-m-d",strtotime($this->request->data['Transaccion']['fecha']));
        $this->request->data['Transaccion']['tipo_transaccion'] = $tipo_transaccion;
        $this->request->data['Transaccion']['cuenta_id']        = $this->cuenta_id;
        $this->request->data['Transaccion']['created']            = date('Y-m-d H:i:s');
        $this->request->data['Transaccion']['monto']            = str_replace(",", "", $this->request->data['Transaccion']['monto']);
		
		$factura_id = $this->request->data['Transaccion']['factura_id'];
		$saldo      = $this->request->data['Transaccion']['total']-($this->request->data['Transaccion']['pagado']+$this->request->data['Transaccion']['monto']);

		$this->Transaccion->save($this->request->data);
		$transaccion_id = $this->Transaccion->getInsertID();

		if ($this->request->data['Transaccion']['archivos'][0]['name'] != "") {
			foreach ($this->request->data['Transaccion']['archivos'] as $archivo) {
				$filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
		        move_uploaded_file($archivo['tmp_name'],$filename);
		        $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
		        $this->Transaccion->query("INSERT INTO docs_transaccions VALUES (0,'".$ruta."',".$transaccion_id.")");
			}
		}

        if ($saldo <= 0){
            $this->Transaccion->query("UPDATE facturas SET estado = 2 WHERE id = $factura_id");
        }else{
            $this->Transaccion->query("UPDATE facturas SET estado = 4 WHERE id = $factura_id");
        }
        
        $this->Transaccion->query("UPDATE validacion_facturas SET validated = '".date("Y-m-d H:i:s")."' WHERE factura_id = $factura_id AND estado = 3"); 
        
		// $this->Session->setFlash(__('El pago ha sido registrado exitosamente.'));
		return $this->redirect(array('action' => 'pagos_factura',$this->request->data['Transaccion']['factura_id'], $tipo_transaccion));

	}

	public function add_documento($factura_id = null){
		$transaccion_id = $this->request->data['Transaccion']['transaccion_id'];

		if ($this->request->data['Transaccion']['archivos'][0]['name'] != "") {
			foreach ($this->request->data['Transaccion']['archivos'] as $archivo) {
				$filename = getcwd()."/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
		        move_uploaded_file($archivo['tmp_name'],$filename);
		        $ruta = "/files/cuentas/".$this->cuenta_id."/facturas/".$factura_id."/".$archivo['name'];
		        $this->Transaccion->query("INSERT INTO docs_transaccions VALUES (0,'".$ruta."',".$transaccion_id.")");
			}
		}
		$this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
        $this->Session->setFlash('Se han cargado exitosamente los documentos al pago.', 'default', array(), 'm_success'); // Mensaje
		return $this->redirect(array('controller'=>'facturas', 'action' => 'view',$factura_id));
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
    
    public function ver_plan_pagos($venta_id = null) {
        $aportaciones = $this->Factura->find('all', array('conditions'=>array('Factura.venta_id'=>$venta_id), 'order'=>'fecha_emision DESC'));
        $this->set(compact('aportaciones'));
        $this->loadModel('Venta');
        $this->set('venta',$this->Venta->read(null,$venta_id));
        $this->set('status_factura',array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));
        $pagos = $this->Transaccion->find('all',array('fields'=>'SUM(monto)','conditions'=>array("Transaccion.factura_id IN (SELECT id FROM facturas WHERE venta_id = $venta_id)")));
        $this->set('pagos',$pagos);
    }
    
    public function estado_cuenta($venta_id = null) {
        $this->layout = 'a4';
        //$aportaciones = $this->Factura->find('all', array('conditions'=>array('Factura.venta_id'=>$venta_id), 'order'=>'fecha_emision ASC'));
        //$this->set(compact('aportaciones'));
        $this->loadModel('Venta');
        $this->Venta->Behaviors->load('Containable');
        $venta = $this->Venta->find(
            'first',
            array(
                'fields'=>array(
                    'id','fecha','precio_cerrado','inmueble_id'
                ),
                'recursive'=>2,
                'conditions'=>array('Venta.id'=>$venta_id),
                'contain'=>array(
                    'Facturas'=>array(
                        'fields'=>array(
                            'referencia','fecha_emision','total','estado'
                        ),
                        'Pagos'=>array(
                            'fields'=>array(
                                'referencia','fecha','forma_pago','monto'
                            )
                        )
                    ),
                    'Cliente'=>array(
                        'fields'=>array('nombre')
                    ),
                    'Inmueble'=>array(
                        'fields'=>array('referencia','id'),
                    ),
                    'User'=>array(
                        'fields'=>array('nombre_completo')
                    )
                )
            )
        );
        $this->set('venta',$venta);
        $this->set('status_factura',array(0 => 'POR PAGAR', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));
        $this->loadModel('Desarrollo');
        $this->Desarrollo->Behaviors->load('Containable');
        $this->set(
            'desarrollo',
            $this->Desarrollo->find(
                'first',
                array(
                    'fields'=>array(
                        'logotipo','nombre'
                    ),
                    'contain'=>array(
                        'FotoDesarrollo'=>array(
                            'limit'=>1,
                            'fields'=>array('ruta')
                        )
                    ),
                    'conditions'=>'Desarrollo.id = (SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = '.$venta['Venta']['inmueble_id'].')'
                    )
                )
            );
    }
        
}
