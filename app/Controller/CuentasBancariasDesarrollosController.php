<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class CuentasBancariasDesarrollosController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public $uses = array(
        'CuentasBancariasDesarrollo'
    );


    /* ---------- Listado de cuentas bancarias del desarrollo via JSon. --------- */
    public function list_ctas_desarrollo ( $desarrollo_id = null ){
        header('Content-type: application/json; charset=utf-8');
                  $i      = 0;
        $response['data'] = [];

        $cuentas_desarrollo = $this->CuentasBancariasDesarrollo->find('all',
            array(
                'conditions' => array(
                    'desarrollo_id' => $desarrollo_id ),
                'fields'     => array(
                    'id',
                    'tipo',
                    'nombre_cuenta',
                    'banco',
                    'numero_cuenta',
                    'spei',
                    'instrucciones' )
            )
        );

        foreach( $cuentas_desarrollo as $cuentas ){
            $response['data'][$i] =  array(
                $cuentas['CuentasBancariasDesarrollo']['tipo'],
                $cuentas['CuentasBancariasDesarrollo']['nombre_cuenta'],
                $cuentas['CuentasBancariasDesarrollo']['banco'],
                $cuentas['CuentasBancariasDesarrollo']['numero_cuenta'],
                $cuentas['CuentasBancariasDesarrollo']['spei'],
                $cuentas['CuentasBancariasDesarrollo']['instrucciones'],
                "<i class = 'pointer fa fa-edit' onclick='editCtaBanco(".$cuentas['CuentasBancariasDesarrollo']['id'].")'></i>",
                "<i class = 'pointer fa fa-trash' onclick='deleteCtaBanco(".$cuentas['CuentasBancariasDesarrollo']['id'].")'></i>",
            );
            $i++;
        }

        echo json_encode( $response );
        exit();
        $this->autoRender = false;
    }

    /* ---------- Metodo para eliminar una cta bancaria del desarrollo ---------- */
    public function delete_cta_desarrollo(){
        header('Content-type: application/json; charset=utf-8');

        $id = $this->request->data['CuentasBancariasDesarrolloDelete']['id'];
        $response                = [];
        
        $this->CuentasBancariasDesarrollo->id = $id;
        if (!$this->CuentasBancariasDesarrollo->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->CuentasBancariasDesarrollo->delete()) {

            $response['mensaje'] = 'La cuenta se ha eliminado correctamente.';
            $response['bandera'] = true;

        } else {

            $response[mensaje] = 'Ha ocurrido un problema al intentar eliminar la cuenta, favor de intentarlo nuevamente, gracias.';
            $response['bandera'] = false;

        }

        echo json_encode( $response );
        exit();

        $this->autoRender = false;

    }

    /* ------------- Agregar nueva cta bancaria del desarrollo JSon ------------- */
    public function add_cta_desarrollo(){
        header('Content-type: application/json; charset=utf-8');
        $response = [];

        if ($this->request->is('post')) {

            if( $this->CuentasBancariasDesarrollo->save($this->request->data) ){
                $response = array(
                    'bandera' => true,
                    'mensaje' => 'Se ha guardado correctamente la cuenta bancaria'
                );
            }else{
                $response = array(
                    'bandera' => false,
                    'mensaje' => 'Ocurrio un problema al intentar guardar la cuenta bancaria, favor de intentarlo nuevamente, gracias.'
                );
            }
            
        }

        echo json_encode( $response );
        exit();
        $this->autoRender = false;
    }

    /* --- Ver el detalle de la cuenta para poner los datos en el form de edit -- */
    public function view_detalle(){
        $response = [];

        if ($this->request->is('post')) {
            $cta_bancaria = $this->CuentasBancariasDesarrollo->findById( $this->request->data['cta_id'], array( 'contain' => false ) );

            $response = array(
                'data'    => $cta_bancaria,
                'bandera' => true
            );
        }

        echo json_encode( $response );
        $this->autoRender = false;

    }

    /* -------------- Edicion de la cuenta bancaria del desarrollo -------------- */
    public function edit_cta_desarrollo(){
        header('Content-type: application/json; charset=utf-8');
        $response = [];


        if ($this->request->is('post')) {
            

            $this->request->data['CuentasBancariasDesarrollo']['id']            = $this->request->data['CuentasBancariasDesarrolloEdit']['id'];
            $this->request->data['CuentasBancariasDesarrollo']['banco']         = $this->request->data['CuentasBancariasDesarrolloEdit']['banco'];
            $this->request->data['CuentasBancariasDesarrollo']['instrucciones'] = $this->request->data['CuentasBancariasDesarrolloEdit']['instrucciones'];
            $this->request->data['CuentasBancariasDesarrollo']['nombre_cuenta'] = $this->request->data['CuentasBancariasDesarrolloEdit']['nombre_cuenta'];
            $this->request->data['CuentasBancariasDesarrollo']['numero_cuenta'] = $this->request->data['CuentasBancariasDesarrolloEdit']['numero_cuenta'];
            $this->request->data['CuentasBancariasDesarrollo']['spei']          = $this->request->data['CuentasBancariasDesarrolloEdit']['spei'];
            $this->request->data['CuentasBancariasDesarrollo']['tipo']          = $this->request->data['CuentasBancariasDesarrolloEdit']['tipo'];

            if( $this->CuentasBancariasDesarrollo->save($this->request->data) ){
                $response = array(
                    'bandera' => true,
                    'mensaje' => 'Se ha guardado correctamente la cuenta bancaria'
                );
            }else{
                $response = array(
                    'bandera' => false,
                    'mensaje' => 'Ocurrio un problema al intentar guardar la cuenta bancaria, favor de intentarlo nuevamente, gracias.'
                );
            }

        }

        echo json_encode( $response );
        exit();
        $this->autoRender = false;

    }

}

?>