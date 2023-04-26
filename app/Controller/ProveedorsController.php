<?php
class ProveedorsController extends AppController {

	public $cuenta_id;
    public function beforeFilter() {
        parent::beforeFilter();
        $this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }

	public $uses = array(
        'Factura',
        'Desarrollo',
        'Proveedor',
        'Categoria',
        'User',
        'ValidacionCategoria'
    );
	
	
	
	function index() {
		$this->set('proveedores',$this->Proveedor->find('all', array('conditions'=>array('Proveedor.cuenta_id'=>$this->cuenta_id))));
	}
	
	function view($proveedor_id = null) {
		$proveedor = $this->Proveedor->read(null,$proveedor_id);
		$this->set(compact('proveedor'));
		$this->set('estados', array(1=>'Creación', 2=>'Revisión', 3=>'Pago'));
		$categorias = $this->Categoria->find('list');
        $this->set(compact('categorias'));
        $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL'));
	}

	function edit($id = null) {
	    if (!$this->Proveedor->exists($id)) {
	        throw new NotFoundException(__('Invalid Proveedor'));
	    }
	    if ($this->request->is(array('post', 'put'))) {
	        if ($this->Proveedor->save($this->request->data)) {
	            $this->Session->setFlash(__('El Proveedor Se guardo exitosamente', true), 'default' ,array('class'=>'mensaje_exito'));
	            return $this->redirect(array('action' => 'index','controller'=>'Proveedors'));
	        } else {
	            $this->Session->setFlash(__('The Proveedor could not be saved. Please, try again.'));
	        }
	    } else {
	        $options = array('conditions' => array('Proveedor.' . $this->Proveedor->primaryKey => $id));
	        $this->request->data = $this->Proveedor->find('first', $options);
	    }
	    /*$categorias = $this->Proveedor->Categoria->findListByTipoCategoria(6);
	    $this->set('categorias',$categorias);*/
	    $this->set('proveedor',$this->Proveedor->read(null,$id));
            $this->set('status_factura', array(0 => 'CARGADA', 1 => 'AUTORIZADA', 2 => 'PAGADA', 3 => 'ABANDONADA', 4=>'PAGO PARCIAL', 5=>'RECHAZADA'));
	}

	function delete() {
		$id = $this->request->data['ProveedorDelete']['id'];
		if (!$id) {
			$this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
        	$this->Session->setFlash('Proveedor invalido.', 'default', array(), 'm_error'); // 
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Proveedor->delete($id)) {
			$this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha eliminado exitosamente al proveedor.', 'default', array(), 'm_success'); // 
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('', 'default', array(), 'error'); // Autorizacion para mensaje
        $this->Session->setFlash('No se ha podido eliminar el proveedor, intentelo nuevamente.', 'default', array(), 'm_error'); // 
		$this->redirect(array('action' => 'index'));
	}

	public function add(){
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Proveedor']['cuenta_id'] = $this->cuenta_id;
			$this->Proveedor->create();
			$this->Proveedor->save($this->request->data);
			// mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/proveedores/".$proveedor_id,0777);
			// mkdir(getcwd()."/files/cuentas/".$this->Session->read('CuentaUsuario.Cuenta.id')."/proveedores/".$proveedor_id,0777);
			$proveedor_id = $this->Proveedor->getInsertID();
            mkdir(getcwd()."/files/cuentas/".$this->cuenta_id."/proveedores/".$proveedor_id,0777);

			// echo $proveedor_id;
			$this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash('Se ha guardado correctamente al proveedor.', 'default', array(), 'm_success'); // Mensaje
			$this->redirect(array('action' => 'index'));
		}
	}
}
?>