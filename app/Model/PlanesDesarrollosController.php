<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class PlanesDesarrollosController extends AppController {

/**
 * Components
 *
 * @var array
 */


public function beforeFilter() {
	parent::beforeFilter();

	$this->Auth->allow('esquema_pago');
}
/**
 * index method
 *
 * @return void
 */

    /* ----------------- Metodo para agregar plan del desarrollo ---------------- */
    public function add(){
        if($this->request->is('post')){
            $this->request->data['PlanesDesarrollo']['vigencia'] = date('Y-m-d',strtotime($this->request->data['PlanesDesarrollo']['vigencia']));
            if($this->PlanesDesarrollo->save($this->request->data)){
                $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
                $this->Session->setFlash('El plan de pagos ha sido agregado al desarrollo', 'default', array(), 'm_success'); // Mensaje
                return $this->redirect(array('action' => 'view','controller'=>'desarrollos',$this->request->data['PlanesDesarrollo']['desarrollo_id']));
            }
        }

    }

    /* ------------------------ Edición del plan de pagos ----------------------- */
    public function disable(){
                  $response  = [];
        $response['bandera'] = false;


        if($this->request->is('post')){


            if($this->PlanesDesarrollo->save($this->request->data)){
                $response['mensaje'] = "<br>Se ha deshabilitado el plan de pagos.";
                $response['bandera'] = true;
            }else{
                $response['mensaje'] = "<br>Ocurrio un problema al intentar deshabilitar el plan de pagos.";
                $response['bandera'] = true;
            }

            $this->Session->setFlash('', 'default', array(), 'success'); // Autorizacion para mensaje
            $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success'); // Mensaje


        }

        echo json_encode( $response );
        exit();
        $this->autoRender = false;

    }

    /**
     *
     * 17/05/2022 - Aka: SaaK
     * El habilitar el plan de pagos incluye que si la fehca de vigencia es anterior
     * al dia de hoy se debe preguntar la nueva fecha para habilitar el plan de pagos.
     *
    */
    public function edit(){
        $response = [];

        sleep(2);
        if($this->request->is('post')){

            $this->request->data['PlanesDesarrollo'] = $this->request->data['PlanesDesarrolloEdit'];

            // Validacion de fecha para formatearla
            if( !empty($this->request->data['PlanesDesarrollo']['vigencia']) ){
                $this->request->data['PlanesDesarrollo']['vigencia'] = date('Y-m-d', strtotime( $this->request->data['PlanesDesarrollo']['vigencia'] ));
            }else{
                unset($this->request->data['PlanesDesarrollo']['vigencia']);
            }

            if($this->PlanesDesarrollo->save($this->request->data['PlanesDesarrollo'])){
                $response['bandera'] = true;
                $response['mensaje'] = 'Se ha actualizado correctamente el plan de pagos.';
            }else{
                $response['bandera'] = false;
                $response['mensaje'] = 'Ocurrio un error, favor de intentarlo de nuevo, gracias.';
            }

        }

        $this->Session->setFlash('', 'default', array(), 'success');
        $this->Session->setFlash($response['mensaje'], 'default', array(), 'm_success');
        echo json_encode ( $response, true );

        $this->autoRender = false;

    }




    public function getPlanes() {
        header('Content-Type: application/json');

        if( $this->request->is('post') ){

            $inmueble_id = $this->request->data['inmueble_id'];
            $desarrollo_id = $this->PlanesDesarrollo->query("SELECT desarrollo_id FROM desarrollo_inmuebles WHERE inmueble_id = $inmueble_id");

            $planes_array=array();
            $planes_array['planes'] = $this->PlanesDesarrollo->findListByDesarrolloIdAndStatus($desarrollo_id[0]['desarrollo_inmuebles']['desarrollo_id'], 1);

            $this->loadModel('ExtrasDesarrollo');
            $planes_array['extras'] = $this->ExtrasDesarrollo->findListByDesarrolloIdAndStatus($desarrollo_id[0]['desarrollo_inmuebles']['desarrollo_id'],1);

        }

        echo json_encode($planes_array, true);
        exit();
        $this->autoRender = false;

	}

    public function getPlan() {
        header('Content-Type: application/json');

        if( $this->request->is('post') ){

            $plan_id = $this->request->data['plan_id'];
            $plan    = $this->PlanesDesarrollo->findFirstById($plan_id);

        }


        echo json_encode($plan, true);
        exit();
        $this->autoRender = false;
	}

    /* 
    * AKA Ernesto Mejia
    * Miércoles 4 de enero  del 2023
    * Api para consumir los esquemas de pago
    * Metodo POST
    * Parametro requerido desarrollo_id
    */
	public function esquema_pago() {
        header('Content-Type: application/json');
		$this->PlanesDesarrollo->Behaviors->load('Containable');
		$this->loadModel('DesarrolloInmueble');

        if( $this->request->is('post') ){

			if( !empty( $this->request->data['desarrollo_id'] ) ){
                $desarrollo_id = $this->request->data['desarrollo_id'];

				$planes = $this->PlanesDesarrollo->find('all', array(

					'conditions'=>array(
						'PlanesDesarrollo.desarrollo_id' => $desarrollo_id
					),
					'fields' => array(
						'PlanesDesarrollo.alias',
						'PlanesDesarrollo.descuento',
						'PlanesDesarrollo.apartado',
						'PlanesDesarrollo.contrato',
						'PlanesDesarrollo.financiamiento',
						'PlanesDesarrollo.escrituracion',
						'PlanesDesarrollo.vigencia',
						'PlanesDesarrollo.status'
					),

					'contain' => false
					)

				);
            }

			if(!empty( $this->request->data['inmueble_id'] ) ) {
				$inmueble_id = $this->request->data['inmueble_id'];

				$desarrollo = $this->DesarrolloInmueble->find('all', array(

					'conditions'=>array(
						'DesarrolloInmueble.inmueble_id' => $inmueble_id
					  ),
					  'fields' => array(
						  'DesarrolloInmueble.desarrollo_id'
					  ),

					  'contain' => false
					)

				);

				$planes = $this->PlanesDesarrollo->find('all', array(

					'conditions'=>array(
						'PlanesDesarrollo.desarrollo_id' => $desarrollo[0]['DesarrolloInmueble']['desarrollo_id']
					),
					'fields' => array(
						'PlanesDesarrollo.alias',
						'PlanesDesarrollo.descuento',
						'PlanesDesarrollo.apartado',
						'PlanesDesarrollo.contrato',
						'PlanesDesarrollo.financiamiento',
						'PlanesDesarrollo.escrituracion',
						'PlanesDesarrollo.vigencia',
						'PlanesDesarrollo.status'
					),

					'contain' => false
					)

				);
			}

        }

        echo json_encode($planes, true);
        exit();
        $this->autoRender = false;
	}
}