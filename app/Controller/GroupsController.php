<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Group','Cliente');
	
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
        }
	
	public function index() {
			$this->Group->recursive = 1;
			$this->set('grupos', $this->Paginator->paginate());
		
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('El grupo ha sido creado exitosamente'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El grupo no pudo registrarse. Intentalo de nuevo'));
			}
		}
	}
	
	public function edit($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('El grupo ha sido actualizado'),'default',array('class'=>'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El grupo no pudo guardarse exitosamente'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
		
	}
	
}

?>