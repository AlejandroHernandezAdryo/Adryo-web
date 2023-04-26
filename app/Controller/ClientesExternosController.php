<?php
class ClientesExternosController extends AppController {

	public $cuenta_id;
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }

	public $uses = array(
        'ClientesExterno',
        'Factura',
        'Desarrollo',
        'Categoria',
        'User',
        'ValidacionCategoria'
    );
	
	
	
	function index() {
		$this->set('clientes',$this->ClientesExterno->findAllByCuentaId($this->cuenta_id));
	}
	
	function view($id = null) {
		$proveedor = $this->ClientesExterno->read(null,$id);
		$this->set(compact('cliente'));
		$this->set('estados', array(1=>'Creación', 2=>'Revisión', 3=>'Pago'));
		$categorias = $this->Categoria->find('list');
        $this->set(compact('categorias'));
        $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL'));
	}

	function edit($id = null) {
	    if (!$this->ClientesExterno->exists($id)) {
	        throw new NotFoundException(__('Invalid Proveedor'));
	    }
	    if ($this->request->is(array('post', 'put'))) {
	        if ($this->ClientesExterno->save($this->request->data)) {
	            $this->Session->setFlash(__('El Cliente Se guardó exitosamente', true), 'default' ,array('class'=>'mensaje_exito'));
	            return $this->redirect(array('action' => 'index','controller'=>'ClientesExternos'));
	        } else {
	            $this->Session->setFlash(__('The Proveedor could not be saved. Please, try again.'));
	        }
	    } else {
	        $options = array('conditions' => array('ClientesExterno.' . $this->ClientesExterno->primaryKey => $id));
	        $this->request->data = $this->ClientesExterno->find('first', $options);
	    }
	    /*$categorias = $this->Proveedor->Categoria->findListByTipoCategoria(6);
	    $this->set('categorias',$categorias);*/
	    $this->set('cliente',$this->ClientesExterno->read(null,$id));
            $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));
	}

	function delete() {
		$id = $this->request->data['ClientesExterno']['id'];
		if (!$id) {
			$this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
        	$this->Session->setFlash('CLiente invalido.', 'default', array(), 'm_error'); // 
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Proveedor->delete($id)) {
			$this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha eliminado exitosamente al cliente.', 'default', array(), 'm_success'); // 
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
        $this->Session->setFlash('No se ha podido eliminar el cliente, intentelo nuevamente.', 'default', array(), 'm_error'); // 
		$this->redirect(array('action' => 'index'));
	}

	public function add(){
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['ClientesExterno']['cuenta_id'] = $this->cuenta_id;
                $this->ClientesExterno->create();
                $this->ClientesExterno->save($this->request->data);
                // mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/proveedores/".$proveedor_id,0777);
                // mkdir(getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/proveedores/".$proveedor_id,0777);
                $cliente_id = $this->ClientesExterno->getInsertID();
                mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/clientes_externos/".$cliente_id,0777);
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('Se ha guardado correctamente al cliente.', 'default', array(), 'm_success'); // Mensaje
                $this->redirect(array('action' => 'index'));
		}
	}
        
        public function createFolders(){
            mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/clientes_externos",0777);
        }
}
?>