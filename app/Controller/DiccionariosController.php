<?php
App::uses('AppController', 'Controller');
/**
 * Diccionario de embudo de ventas Controller
 *
 * @property DicEmbudoVentas $DicEmbudoVentas
 * 
 */
class DiccionariosController extends AppController {

	public $cuenta_id;
	public $documentos_operacion;

    public function beforeFilter() {
        parent::beforeFilter();
		$this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
		$this->documentos_operacion = array(
			'doc_apartado'      => 'Documento para Apartado / Reservados',
			'doc_venta'         => 'Documento para Vendido / Contrato',
			'doc_escrituracion' => 'Documento para Escrituración',
		);
    }

    public $uses = array( 'Diccionario' );

	
	/* ---- Agregar nuevo registro en el diccionario, retorna a diccionarios ---- */
	public function add_diccionario(){
		$mensaje = '';
		
		if ($this->request->is('post')) {
			
			// Agregar el id de la cuenta en el registro nuevo.
			$this->request->data['Diccionario']['cuenta_id'] = $this->cuenta_id;
			$this->Diccionario->create();

			if ($this->Diccionario->save($this->request->data)){
				$mensaje = 'El registro se ha guardado exitosamente.';
			}else{
				$mensaje = 'No se han podido guardar el registro, favor de intentarlo nuevamente, gracias.';
			}
			
			$this->Session->setFlash('', 'default', array(), 'success');
        	$this->Session->setFlash($mensaje, 'default', array(), 'm_success');
			$this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));

		}

		$this->autoRender = false;
	}

	/* ------------- Edicion de diccionarios, retorna a diccionarios ------------ */
	public function edit_diccionario(){
		$this->request->onlyAllow('post', 'delete');
        $diccionario_id = $this->request->data['Diccionario']['id'];

        if ($this->Diccionario->save($this->request->data)) {
            $mensaje = 'Se han guardado los cambios correctamente.';
        } else {
            $mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
        }
        
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->redirect(array('controller' => 'users', 'action' => 'diccionarios_config'));
	}

	public function delete ( $id = null ) {
        $this->Diccionario->id = $id;
		if (!$this->Diccionario->exists()) {
			throw new NotFoundException(__('Invalid proveedor'));
		}
		$this->request->onlyAllow('post', 'delete');
        if ($this->Diccionario->delete()) {
			$mensaje = 'Se ha eliminado correctamente el registro del diccionario.';
		} else {
			$mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
		}

		$this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->redirect(array('controller' => 'users', 'action' => 'diccionarios_config'));
    }

	/* ------------------- Listado de opciones, respuesta Json ------------------ */
	public function list_opciones(){
		
		$opciones = $this->Diccionario->find('list',array(
			'conditions' => array(
				'Diccionario.cuenta_id'      => $this->cuenta_id,
				'Diccionario.sub_directorio' => $this->request->data('subdirectorio')
				// 'Diccionario.sub_directorio' => 'dic_wa_error_send_cotizacion'
			),
			'fields'     => array( 'id', 'descripcion' ),
			'contain'    => false,
		));

		echo json_encode( $opciones );

		$this->autoRender = false;
	}

	function docs_inmuebles_apartado(){
		header('Content-type: application/json; charset=utf-8');
		$opciones = $this->Diccionario->find('list',array(
			'conditions' => array(
				'Diccionario.cuenta_id'      => $this->cuenta_id,
				'Diccionario.sub_directorio' => 'doc_apartado'
			),
			'fields'     => array( 'id','descripcion' , ),
			'contain'    => false,
		));

		echo json_encode( $opciones, true );
		exit();
		$this->autoRender = false;

	}

	function docs_inmuebles_venta(){
		header('Content-type: application/json; charset=utf-8');
		$opciones = $this->Diccionario->find('list',array(
			'conditions' => array(
				'Diccionario.cuenta_id'      => $this->cuenta_id,
				'Diccionario.sub_directorio' => 'doc_venta'
			),
			'fields'     => array( 'id','descripcion' , ),
			'contain'    => false,
		));

		echo json_encode( $opciones, true );
		exit();
		$this->autoRender = false;

	}

	function docs_inmuebles_escrituracion(){
		header('Content-type: application/json; charset=utf-8');
		$opciones = $this->Diccionario->find('list',array(
			'conditions' => array(
				'Diccionario.cuenta_id'      => $this->cuenta_id,
				'Diccionario.sub_directorio' => 'doc_escrituracion'
			),
			'fields'     => array( 'id','descripcion' , ),
			'contain'    => false,
		));

		echo json_encode( $opciones, true );
		exit();
		$this->autoRender = false;

	}

}
