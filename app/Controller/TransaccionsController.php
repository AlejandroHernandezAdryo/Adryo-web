<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class TransaccionsController extends AppController {
    
    public $cuenta_id;
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }
    public $uses = array(
        'Transaccion',
        'Banco'
    );

    /***************************************************
    *
    *   Index de las Cuentas bancarias.
    *
    ***************************************************/
    public function transferencia($banco_id = null){
        if (isset($banco_id)){
            $this->set('transaccions', $this->Transaccion->find('all', array('order'=>array('Transaccion.fecha ASC'),'conditions'=>array('Transaccion.cuenta_bancaria_id'=>$banco_id,'Transaccion.cuenta_id'=>$this->cuenta_id))));
            $this->loadModel('Banco');
            $this->set('banco',$this->Banco->read(null,$banco_id));
        }else{
            $this->set('transaccions', $this->Transaccion->find('all', array('order'=>'Transaccion.fecha DESC','conditions'=>array('Transaccion.cuenta_id'=>$this->cuenta_id))));
            
        }
        $this->set('cuentas', $this->Banco->find('list', array('conditions'=>array('Banco.status'=>1, 'Banco.cuenta_id'=>$this->cuenta_id))));
        $this->set('tipos_transaccion', array(1 => 'Depósito', 2 => 'Retiro'));
        $this->set('manual_transaccion', array(1 => 'Depósito', 2 => 'Retiro'));
    }


    public function interna_transaccion(){
        $altaOrigenSaldo = 0;
        $bajaOrigenSaldo = 0;
        $saldoOrigen     = 0;
        if ($this->request->is('post', 'put')) {
            
            // Revisar los saldos de las cuentas.
            $data_cta_origen = $this->Banco->find('first', array('conditions'=>array('Banco.id'=>$this->request->data['Transaccion']['cuenta_origen'])));
            // Saldo inicial de la cuenta de origen
            $saldoOrigen = $data_cta_origen['Banco']['saldo_inicial'];

            // Recorremos las consultas de bajas y altas.
            foreach ($data_cta_origen['Transaccions'] as $origenTransaccion) {
                switch ($origenTransaccion['tipo_transaccion']) {
                    case 1: // Alta de saldo
                        $saldoOrigen = $saldoOrigen + $origenTransaccion['monto'];
                        break;
                    case 2: // Baja de saldo
                        $saldoOrigen = $saldoOrigen - $origenTransaccion['monto'];
                        break;
                }
            }
            
            if ($saldoOrigen >= str_replace(",", "", $this->request->data['Transaccion']['monto'])) {
                // BAJA DE SALDO DE CUENTA ORIGEN
                $this->request->data['Transaccion']['cuenta_bancaria_id'] = $this->request->data['Transaccion']['cuenta_origen'];
                $this->request->data['Transaccion']['monto']              = str_replace(",", "", $this->request->data['Transaccion']['monto']);
                $this->request->data['Transaccion']['fecha']              = date('Y-m-d', strtotime($this->request->data['Transaccion']['fecha']));
                $this->request->data['Transaccion']['cuenta_id']          = $this->cuenta_id;
                $this->request->data['Transaccion']['tipo_transaccion']   = 2;
                $this->Transaccion->create();
                $this->Transaccion->save($this->request->data);
                
                // Documentos para la transferencia cuenta de origen
                $transaccionOrigen_id = $this->Transaccion->getInsertID();
                if ($this->request->data['Transaccion']['archivos_origen'][0]['name'] != "") {
                    foreach ($this->request->data['Transaccion']['archivos_origen'] as $archivo) {
                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                        move_uploaded_file($archivo['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                        $this->Transaccion->query("INSERT INTO docs_transaccions VALUES (0,'".$ruta."',".$transaccionOrigen_id.")");
                    }
                }
                
                //SUBIR SALDO A CUENTA DESTINO
                $this->request->data['Transaccion']['monto']              = str_replace(",", "", $this->request->data['Transaccion']['monto']);
                $this->request->data['Transaccion']['tipo_transaccion']   = 1;
                $this->request->data['Transaccion']['cuenta_bancaria_id'] = $this->request->data['Transaccion']['cuenta_destino'];
                $this->Transaccion->create();
                $this->Transaccion->save($this->request->data);

                // Documentos para la transferencia cuenta de origen
                $transaccionDestino_id = $this->Transaccion->getInsertID();
                if ($this->request->data['Transaccion']['archivos_destino'][0]['name'] != "") {
                    foreach ($this->request->data['Transaccion']['archivos_destino'] as $archivo) {
                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                        move_uploaded_file($archivo['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                        $this->Transaccion->query("INSERT INTO docs_transaccions VALUES (0,'".$ruta."',".$transaccionDestino_id.")");
                    }
                }
            }else{
                $this->Session->setFlash('', 'default', array(), 'error');
                $this->Session->setFlash('No se puede realizar la transacción, el saldo de la cuenta de origen es insuficiente.', 'default', array(), 'm_error');
            }
            $this->redirect('transferencia',$this->request->data['Transaccion']['cuenta_bancaria_id']);
        }
    }

    public function manual_transaccion(){
        if ($this->request->is('post', 'put')) {

            // Revisar los saldos de las cuentas.
            $data_cta_origen = $this->Banco->find('first', array('conditions'=>array('Banco.id'=>$this->request->data['Transaccion']['cuenta_bancaria_id'])));
            // Saldo inicial de la cuenta de origen
            $saldoOrigen = $data_cta_origen['Banco']['saldo_inicial'];

            // Recorremos las consultas de bajas y altas.
            foreach ($data_cta_origen['Transaccions'] as $origenTransaccion) {
                switch ($origenTransaccion['tipo_transaccion']) {
                    case 1: // Alta de saldo
                        $saldoOrigen = $saldoOrigen + $origenTransaccion['monto'];
                        break;
                    case 2: // Baja de saldo
                        $saldoOrigen = $saldoOrigen - $origenTransaccion['monto'];
                        break;
                }
            }

            if ($this->request->data['Transaccion']['tipo_transaccion'] == 2) {
                if ($saldoOrigen >= str_replace(",", "", $this->request->data['Transaccion']['monto'])) {
                    $this->request->data['Transaccion']['monto']     = str_replace(",", "", $this->request->data['Transaccion']['monto']);
                    $this->request->data['Transaccion']['fecha']     = date('Y-m-d', strtotime($this->request->data['Transaccion']['fecha']));
                    $this->request->data['Transaccion']['cuenta_id'] = $this->cuenta_id;
                    $this->Transaccion->create();
                    $this->Transaccion->save($this->request->data);

                    // Documentos para la transferencia
                    $transaccion_id = $this->Transaccion->getInsertID();
                    if ($this->request->data['Transaccion']['archivos'][0]['name'] != "") {
                        foreach ($this->request->data['Transaccion']['archivos'] as $archivo) {
                            $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                            move_uploaded_file($archivo['tmp_name'],$filename);
                            $ruta = "/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                            $this->Transaccion->query("INSERT INTO docs_transaccions VALUES (0,'".$ruta."',".$transaccion_id.")");
                        }
                    }
                }else{
                    $this->Session->setFlash('', 'default', array(), 'error');
                    $this->Session->setFlash('No se puede realizar la transacción, el saldo de la cuenta es insuficiente.', 'default', array(), 'm_error');
                }
            }else{
                $this->request->data['Transaccion']['monto']     = str_replace(",", "", $this->request->data['Transaccion']['monto']);
                $this->request->data['Transaccion']['fecha']     = date('Y-m-d', strtotime($this->request->data['Transaccion']['fecha']));
                $this->request->data['Transaccion']['cuenta_id'] = $this->cuenta_id;
                $this->Transaccion->create();
                $this->Transaccion->save($this->request->data);

                // Documentos para la transferencia
                $transaccion_id = $this->Transaccion->getInsertID();
                if ($this->request->data['Transaccion']['archivos'][0]['name'] != "") {
                    foreach ($this->request->data['Transaccion']['archivos'] as $archivo) {
                        $filename = getcwd()."/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                        move_uploaded_file($archivo['tmp_name'],$filename);
                        $ruta = "/files/cuentas/".$this->cuenta_id."/aportaciones/".$archivo['name'];
                        $this->Transaccion->query("INSERT INTO docs_transaccions VALUES (0,'".$ruta."',".$transaccion_id.")");
                    }
                }
            }

            switch ($this->request->data['Transaccion']['redirect']) {
                case 1:
                 $this->redirect(array('action'=>'transferencia',$this->request->data['Transaccion']['cuenta_bancaria_id']));
                break;
            }
            //$this->redirect($redirec);
        }
    }
    
    function delete($id = null, $factura_id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Transaccion invalido', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Transaccion->delete($id)) {
            $this->Session->setFlash(__('El pago ha sido eliminado exitosamente', true), 'default' ,array('class'=>'mensaje_exito'));
            $this->redirect(array('action'=>'pagos_factura','controller'=>'aportacions',$factura_id));
        }
    }

}

?>