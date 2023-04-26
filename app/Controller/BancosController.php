<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class BancosController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    public $uses = array(
        'Banco',
        'Desarrollo',
        'CuentaBancariaDesarrollo',
    );

    /***************************************************
    *
    *   Index de las cuentas bancarias.
    *
    ***************************************************/
    public function index(){
        $this->Banco->Behaviors->load('Containable');
        $this->set('desarrollos', $this->Desarrollo->find('list', array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('bancos', $this->Banco->find('all', array('conditions'=>array('Banco.status'=>1,'Banco.cuenta_id'=>$this->Session->read('CuentaUsuario.Cuenta.id')),'fields'=>array('Banco.*'), 'contain' => array('Desarrollo'=>array('fields'=>array('nombre'))))));
        $this->set('tipo_cuenta', array(1=>'Bancaria', 2=>'Caja chica', 3=>'Inversión'));
        $this->set('status', array(1=>'Abierta', 2=>'Bloqueada'));
        $this->loadModel('Transaccion');
        //calcular depósitos
        $depositos = array();
        $depositos_array = $this->Transaccion->find('all',array('fields'=>array('Transaccion.cuenta_bancaria_id','SUM(monto) as depositos','CuentaBancaria.created'),'group'=>'Transaccion.cuenta_bancaria_id','conditions'=>array('Transaccion.fecha >='.'CuentaBancaria.created','Transaccion.tipo_transaccion'=>1,'Transaccion.cuenta_bancaria_id IN (SELECT id FROM cuentas_bancarias WHERE cuenta_id ='.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').' )')));
        foreach($depositos_array as $deposito):
            $depositos[$deposito['Transaccion']['cuenta_bancaria_id']] = $deposito[0]['depositos'];
        endforeach;
        $this->set('depositos',$depositos);
        //Calcular retiros
        $retiros = array();
        $retiros_array = $this->Transaccion->find('all',array('fields'=>array('Transaccion.cuenta_bancaria_id','SUM(monto) as retiros'),'group'=>'Transaccion.cuenta_bancaria_id','conditions'=>array('Transaccion.fecha >='.'CuentaBancaria.created','Transaccion.tipo_transaccion'=>2,'Transaccion.cuenta_bancaria_id IN (SELECT id FROM cuentas_bancarias WHERE cuenta_id ='.$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id').' )')));
        foreach($retiros_array as $retiro):
            $retiros[$retiro['Transaccion']['cuenta_bancaria_id']] = $retiro[0]['retiros'];
        endforeach;
        $this->set('retiros',$retiros);
    }

    /***************************************************
    *
    *   Agregar nuevas cuentas
    *
    ***************************************************/
    public function add(){
        if ($this->request->is(array('post', 'put'))) {
//            echo var_dump($this->request->data['Banco']);
            $this->request->data['Banco']['cuenta_id']     = $this->Session->read('CuentaUsuario.Cuenta.id');
            $this->request->data['Banco']['saldo_inicial'] = str_replace(",", "", $this->request->data['Banco']['saldo_inicial']);
            $this->request->data['Banco']['created']=date("Y-m-d");
            $this->Banco->create();
            $this->Banco->save($this->request->data);

            // Guardar la relacion de cuenta con el desarrollo
            $last_banco = $this->Banco->getInsertID();
            
            
            // Condición para saber si hay algun desarrollo seleccionado en la lista.
            if (sizeof($this->request->data['Banco']['desarrollo_id'])>0) {
                $this->loadModel('CuentaBancariaDesarrollo');
                foreach ($this->request->data['Banco']['desarrollo_id'] as $desarrollo) {
                    $this->request->data['CuentaBancariaDesarrollo']['cuenta_bancaria_id'] = $last_banco;
                    $this->request->data['CuentaBancariaDesarrollo']['desarrollo_id']      = $desarrollo;
                    $this->CuentaBancariaDesarrollo->create();
                    $this->CuentaBancariaDesarrollo->save($this->request->data['CuentaBancariaDesarrollo']);
                }
            }
            
            $this->Session->setFlash('', 'default', array(), 'success');
            $this->Session->setFlash('Se ha guardado correctamente al proveedor.', 'default', array(), 'm_success');
            switch ($this->request->data['Banco']['redirect']) {
                case 1:
                    $ruta = array('action'=>'view', 'controller'=>'bancos', $last_banco);
                    break;
                case 2:
                    $ruta = array('action'=>'configuracion', 'controller'=>'desarrollos', $this->request->data['Banco']['desarrollo_id'][0]);
                    break;
            }
            $this->redirect($ruta);
        }
    }

    /***************************************************
    *
    *   Eliminar cuentas.
    *
    ***************************************************/
    public function delete() {
        $id = $this->request->data['CuentaDelete']['id'];
        if (!$id) {
            $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
            $this->Session->setFlash('Banco invalido.', 'default', array(), 'm_error'); // 
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Banco->delete($id)) {
            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha eliminado exitosamente al proveedor.', 'default', array(), 'm_success'); // 
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
        $this->Session->setFlash('No se ha podido eliminar el proveedor, intentelo nuevamente.', 'default', array(), 'm_error'); // 
        $this->redirect(array('action' => 'index'));
    }

    /***************************************************
    *
    *   Editar cuentas.
    *
    ***************************************************/
    public function edit($cuenta_bancaria_id = null){

        if (!$this->Banco->exists($cuenta_bancaria_id)) {
            throw new NotFoundException(__('Invalid Cuenta'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Banco']['id'] = $cuenta_bancaria_id;
            if ($this->Banco->save($this->request->data)) {
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('La cuenta se ha modificaco exitosamente.', 'default', array(), 'm_success'); // 
                $this->redirect(array('action' => 'view', $cuenta_bancaria_id));
            } else {
                $this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
                $this->Session->setFlash('No se ha podido modificar la cuenta, intentelo nuevamente.', 'default', array(), 'm_error'); // 
            }
        }else{
            /*$this->set('cuenta', $this->Banco->find('first', array('conditions'=>array('Banco.id'=>$cuenta_bancaria_id), 'recursive'=>-1)));
            $this->set('desarrollos', $this->Desarrollo->find('list', array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
            $this->set('bancos', $this->Banco->find('all', array('conditions'=>array('Banco.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
            $this->set('tipo_cuenta', array(1=>'Bancaria', 2=>'Caja chica', 3=>'Inversión'));
            $this->set('status', array(1=>'Abierta', 2=>'Bloqueada'));*/
            $this->redirect(array('action' => 'view', $cuenta_bancaria_id));
        }
    }



    public function view($cuenta_bancaria_id = null){
        $this->Banco->Behaviors->load('Containable');
        $cuentaB = $this->Banco->find('first', array('conditions'=>array('Banco.id'=>$cuenta_bancaria_id),'fields'=>array('Banco.*'), 'contain' => array('Transaccions','Desarrollo'=>array('fields'=>array('id','nombre')))));
        $this->set(compact('cuentaB'));
        $this->set('tipo_cuenta', array(1=>'Bancaria', 2=>'Caja chica', 3=>'Inversión'));
        $this->set('status', array(1=>'Abierta', 2=>'Bloqueada'));
        $this->set('tipos_transaccion', array(1 => 'Ingreso', 2 => 'Egreso', 3 => 'Transferencia Interna'));
        $this->set('desarrollos', $this->Desarrollo->find('list', array('conditions'=>array('Desarrollo.cuenta_id'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))));
        $this->set('tipo_cuenta', array(1=>'Bancaria', 2=>'Caja chica', 3=>'Inversión'));

        $this->loadModel('Transaccion');
        $depositos = $this->Transaccion->find('all',array('fields'=>array('SUM(monto)'),'conditions'=>array('Transaccion.fecha >='.'CuentaBancaria.created','Transaccion.tipo_transaccion'=>1,'Transaccion.cuenta_bancaria_id'=>$cuenta_bancaria_id)));
        $retiros = $this->Transaccion->find('all',array('fields'=>array('SUM(monto)'),'conditions'=>array('Transaccion.fecha >='.'CuentaBancaria.created','Transaccion.tipo_transaccion'=>2,'Transaccion.cuenta_bancaria_id'=>$cuenta_bancaria_id)));
        $this->set('deposito',$depositos);
        $this->set('retiros',$retiros);

    }


    public function status_update(){
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Banco']['id']     = $this->request->data['CuentaDelete']['id'];
            $this->request->data['Banco']['status'] = $this->request->data['CuentaDelete']['status'];

            if ($this->Banco->save($this->request->data)) {
                $this->Session->setFlash(__('La cuenta se ha modificado exitosamente', true), 'default' ,array('class'=>'mensaje_exito'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Proveedor could not be saved. Please, try again.'));
            }
        }
    }

    public function add_desarrollo($cuenta_bancaria_id = null){
        if ($this->request->is(array('post', 'put'))) {
            if (!empty($this->request->data['Banco']['desarrollo_id'])) {
                foreach ($this->request->data['Banco']['desarrollo_id'] as $desarrollo) {
                    $this->request->data['CuentaBancariaDesarrollo']['cuenta_bancaria_id'] = $cuenta_bancaria_id;
                    $this->request->data['CuentaBancariaDesarrollo']['desarrollo_id']      = $desarrollo;
                    $this->CuentaBancariaDesarrollo->create();
                    $this->CuentaBancariaDesarrollo->save($this->request->data);
                }
            }else{
                $this->Session->setFlash('', 'default', array(), 'error');
                $this->Session->setFlash('No se ha seleccionado al menos un desarrollo.', 'default', array(), 'm_error');
            }
            $this->redirect(array('action'=>'view', $cuenta_bancaria_id));
        }
    }
    
    public function desvincular($banco_id = null, $desarrollo_id = null){
        if ($this->request->is(array('post', 'put'))) {
            $this->Banco->query("DELETE FROM cuenta_bancaria_desarrollos WHERE cuenta_bancaria_id = $banco_id AND desarrollo_id = $desarrollo_id");
                $this->Session->setFlash(__('La cuenta se ha desvinculado del desarrollo exitosamente', true), 'default' ,array('class'=>'mensaje_exito'));
                return $this->redirect(array('action'=>'view', $banco_id));
            
        }
    }


}

?>