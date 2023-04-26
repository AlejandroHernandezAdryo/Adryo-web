<?php
App::uses('AppController', 'Controller');
/**
 * Diccionario de embudo de ventas Controller
 *
 * @property DicEmbudoVentas $DicEmbudoVentas
 * 
 */
class DicEmbudoVentasController extends AppController {

	public $cuenta_id;
	var $etapas_cliente = array( 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '' );

    public function beforeFilter() {
        parent::beforeFilter();
		$this->cuenta_id = $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');
    }

    public $uses = array( 'DicEmbudoVenta' );

	
	/* ---- Agregar nuevo registro en el diccionario, retorna a diccionarios ---- */
	public function add_diccionario(){
		$mensaje = '';
		if ($this->request->is('post')) {
			
			// Agregar el id de la cuenta en el registro nuevo.
			$this->request->data['DicEmbudoVenta']['cuenta_id'] = $this->cuenta_id;
			$this->DicEmbudoVenta->create();

			if ($this->DicEmbudoVenta->save($this->request->data)){
				$mensaje = 'El nombre de la etapa se ha guardado exitosamente.';
			}else{
				$mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
			}
			
			$this->Session->setFlash('', 'default', array(), 'success');
        	$this->Session->setFlash($mensaje, 'default', array(), 'm_success');
			$this->redirect(array('action' => 'diccionarios_config','controller'=>'users'));

		}

		$this->autoRender = false;
	}

	/* ------------ Edicion del embudo de ventas desde el diccionario ----------- */
	public function edit_diccionario(){
		$this->request->onlyAllow('post', 'delete');
        $diccionario_id = $this->request->data['DicEmbudoVenta']['id'];

        if ($this->DicEmbudoVenta->save($this->request->data)) {
            $mensaje = 'Se han guardado los cambios correctamente.';
        } else {
            $mensaje = 'No se han podido guardar los cambios, favor de intentarlo nuevamente, gracias.';
        }
        
        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($mensaje, 'default', array(), 'm_success');
        $this->redirect(array('controller' => 'users', 'action' => 'diccionarios_config'));
	}

	/* ------- Metodo para visualizar las etapas de los clientes via ajax ------- */
	public function view_etapas( $cuenta_id = null ){
		header('Content-type: application/json charset=utf-8');

		$etapa_1 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 1 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_2 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 2 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_3 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 3 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_4 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 4 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_5 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 5 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_6 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 6 ), 'contain' => false, 'fields' => array('nombre') ));
		$etapa_7 = $this->DicEmbudoVenta->find('first',array( 'conditions'=>array( 'DicEmbudoVenta.cuenta_id'  => $cuenta_id, 'orden' => 7 ), 'contain' => false, 'fields' => array('nombre') ));
		
		// Variables para el nombre de las etapas.
		$this->etapas_cliente[1] = ( !empty($etapa_1['DicEmbudoVenta']['nombre']) ? $etapa_1['DicEmbudoVenta']['nombre'] : '' );
		$this->etapas_cliente[2] = ( !empty($etapa_2['DicEmbudoVenta']['nombre']) ? $etapa_2['DicEmbudoVenta']['nombre'] : '' );
		$this->etapas_cliente[3] = ( !empty($etapa_3['DicEmbudoVenta']['nombre']) ? $etapa_3['DicEmbudoVenta']['nombre'] : '' );
		$this->etapas_cliente[4] = ( !empty($etapa_4['DicEmbudoVenta']['nombre']) ? $etapa_4['DicEmbudoVenta']['nombre'] : '' );
		$this->etapas_cliente[5] = ( !empty($etapa_5['DicEmbudoVenta']['nombre']) ? $etapa_5['DicEmbudoVenta']['nombre'] : '' );
		$this->etapas_cliente[6] = ( !empty($etapa_6['DicEmbudoVenta']['nombre']) ? $etapa_6['DicEmbudoVenta']['nombre'] : '' );
		$this->etapas_cliente[7] = ( !empty($etapa_7['DicEmbudoVenta']['nombre']) ? $etapa_7['DicEmbudoVenta']['nombre'] : '' );

		echo json_encode( $this->etapas_cliente, true );
		$this->autoRender = false;

	}


	

}
