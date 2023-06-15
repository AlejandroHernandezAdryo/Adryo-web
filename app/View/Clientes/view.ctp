<?php
    $validate_cotizacion = 0;
    $status_atencion = '';
    $date_current      = date('Y-m-d');
    $date_oportunos    = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios      = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

    if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) { $status_atencion = 'Oportuno'; $class_at = "chip_bg_oportuno"; }
    elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){ $status_atencion = 'Tardio'; $class_at = "chip_bg_tardio"; }
    elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){ $status_atencion = 'No atendido'; $class_at = "chip_bg_no_antendido"; }
    elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){ $status_atencion = 'Por reasignar'; $class_at = "chip_bg_reasignar"; }
    else{ $status_atencion = 'Por reasignar'; $class_at = "chip_bg_reasignar"; }

    $i = 1;
    $j = 1;

    $activo       = "width:50% !important;background-color:#BF9000;  width:100%; border-radius:5px; text-align:center; color: #FFF;";
    $inactivo     = "width:50% !important;background-color:#000000;  border-radius:5px; text-align:center; color: #FFF;";
    $activo_venta = "width:50% !important;background-color:#70AD47;  border-radius:5px; text-align:center;";
    $neutral      = "width:50% !important;background-color:#7F6000;  border-radius:5px; text-align:center; color:#FFF;";
    $style        = ($cliente['Cliente']['status']=='Activo' ? $activo : ($cliente['Cliente']['status']=='Inactivo' ? $inactivo : ($cliente['Cliente']['status']=='Activo venta' ? $activo_venta : $neutral)));

    echo $this->Html->css(
        array(
            'components',
            
            'jquery.fancybox',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fullcalendar/css/fullcalendar.min',
            'pages/timeline2',
            'pages/calendar_custom',
            'pages/gallery',
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            'pages/flot_charts',
            
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/c3/css/c3.min',
            '/vendors/toastr/css/toastr.min',
            '/vendors/switchery/css/switchery.min',
            'pages/new_dashboard',
            
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',
            
            
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',

            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/chosen/css/chosen',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            'pages/wizards',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/radio_css/css/radiobox.min',
            'custom',
            'style_operaciones',
            'components_adryo',
        ),
        array('inline'=>false)); 
?>
<style>

    .flex-container {
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-direction: normal;
        -moz-box-direction: normal;
        -webkit-box-orient: horizontal;
        -moz-box-orient: horizontal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-pack: start;
        -moz-box-pack: start;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        -webkit-align-content: flex-start;
        -ms-flex-line-pack: start;
        align-content: flex-start;
        -webkit-box-align: start;
        -moz-box-align: start;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start;
        }
    .flex-item{
        width: 12.5%;
    }
    .flex-item:nth-child(1) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(2) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(3) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(4) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(5) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(6) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(7) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
        }

    .flex-item:nth-child(8) {
        -webkit-box-ordinal-group: 1;
        -moz-box-ordinal-group: 1;
        -webkit-order: 0;
        -ms-flex-order: 0;
        order: 0;
        -webkit-box-flex: 0;
        -moz-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        -webkit-align-self: auto;
        -ms-flex-item-align: auto;
        align-self: auto;
    }

    /*
        Legacy Firefox implementation treats all flex containers
        as inline-block elements.
    */

    @-moz-document url-prefix() {
        .flex-container {
            width: 100%;
            -moz-box-sizing: border-box;
            }

        }

        .img-icon{
            width: 2.5rem;
            height: auto;
        }
        .subtitle{
            font-size: 1rem;
            color: #646464;
            font-weight: 600;
            text-transform: uppercase;
            height: 40px;
            overflow: hidden;
            height: 48px;
        }
        .input-opciones, .input-opciones:focus {
            position: absolute;
            display: block;
            border: none;
            width: 30%;
            left: 65%;
            background: transparent;
            cursor: pointer;
            font-size: 1.2rem;
            top: 0px;
        }

        .input-opciones option {
            background: white;
            border: none;
        }

        .input-opciones option:hover {
            background: #2e3c54 !important;
        }

        .color-black {
            color: #000;
        }
        #propiedades td, #desarrollos td{
            border-top: none !important;
        }
        #propiedades tr, #desarrollos tr{
            border-top: 1px solid #d1d1d1 !important;
        }
        .no-border{
            border: none;
        }
        .checkbox .cr, .radio .cr {
            float: none !important;
            background-color: #E8E8E8 !important;
            border: none !important;
        }
        .fa-check{
            color: #4B4B4B !important;
        }

        .label-for-check{
            position: absolute !important;
            margin-top: -2.2px;
        }

        .chip{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; font-size: 1.1em; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
        .flex-center{display: flex ; flex-direction: row ; flex-wrap: wrap ; justify-content: center ; align-items: center ; align-content: center ;}
        .mt-5{margin-top: 5px !important;}
        .modal-dialog-centered{margin-top: 15%;}
        .hidden{display: none;}
        .padding10{
            padding: 10px;
        }
        .danger_bg_dark{
            background: #EA423E;
            color: white;
        }
        .bg-warning{
            background: #ff9933;
            color: white;
        }

        textarea{
            overflow:hidden;
            display:block;
        }
        .text-center{
            text-align: center;
        }
        #seguimeinto-eliminar, #seguimeinto-edicion {
            display: none;
        }

        #propiedades_filter label input, #desarrollos_filter label input {
            width: 70% !important;
        }

        .tool_tip_all{
            overflow: -webkit-paged-x !important;
            height: auto !important;
        }
    
</style>

<!-- Modal compartir por redes sociales -->

<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="modal fade" id="modalSeguimeinto">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      
      <div class="modal-content">
        <div class="modal-header" style="background: #2e3c54;">
          
          <h4 class="modal-title col-sm-10" id="modal-seguimiento-titulo"></h4>
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div id="seguimeinto-eliminar">

            <?= $this->Form->create('agendaEliminar', array('url'=>array('controller'=>'agendas', 'action' => 'delete', $cliente['Cliente']['id']))); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="mensaje">¿ Desea eliminar este comentario de seguimeinto ?</label>
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <?= $this->Form->hidden('id_seguimiento') ?>
            <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Eliminar</button>
            </div>
            <?= $this->Form->end(); ?>

        </div>

        <div id="seguimeinto-edicion">

            <?= $this->Form->create('agendaEdicion', array('url'=>array('controller'=>'agendas', 'action' => 'edit', $cliente['Cliente']['id']))); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="mensaje">Mensaje</label>
                        <?= $this->Form->textarea('mensaje', array('class'=>'form-control textarea', 'maxlength'=>250)); ?>
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <?= $this->Form->hidden('id_seguimiento') ?>
            <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar mensaje</button>
            </div>
            <?= $this->Form->end(); ?>

        </div>

        

      </div>

    </div>
</div>
<!-- Modal para agregar llamadas -->
<div class="modal fade" id="addLlamada">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('Cliente', array('url'=>array('controller'=>'clientes', 'action' => 'registrar_llamada', $cliente['Cliente']['id']))); ?>
      <div class="modal-content">
        <div class="modal-header" style="background: #2e3c54;">
          <h4 class="modal-title col-sm-10">Registro de llamada</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <label for="mensaje">Mensaje <small class="text-light">(Máximo 250 caracteres.)</small></label>
                    <?= $this->Form->textarea('mensaje', array('class'=>'form-control textarea', 'maxlength'=>250)); ?>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Registrar</button>
        </div>
        <?= $this->Form->end(); ?>
      </div>
    </div>
</div>
<!-- Modal prospeccion -->
<?= $this->element('Clientes/edit_prospeccion'); ?>
<?= $this->element('Clientes/send_iframe'); ?>
<?= $this->element('Clientes/modal_send_cotizacion'); ?>
<?= $this->Element('Desarrollos/operaciones_inmueble') ?>
<?= $this->element('Clientes/cotizacion'); ?>
<?= $this->Element('Desarrollos/modal_cancelaciones_operaciones') ?>
<!-- Modal para enviar correo -->
<?= $this->element('Clientes/mail_compose'); ?>
<!-- Modal para cambio de estatus -->
<div class="modal fade" id="modal112">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('Status', array('url'=>array('controller'=>'Clientes', 'action' => 'update_status', $cliente['Cliente']['id']))); ?>
      <div class="modal-content">
        <div class="modal-header" style="background: #2e3c54;">
          <h4 class="modal-title col-sm-10">Estatus del cliente</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        $status_cliente = array(
                            'Activo'            => 'Activo',
                            'Inactivo'          => 'Inactivo definitivo',
                            'Inactivo temporal' => 'Inactivo temporal'
                        );

                        echo '<div class="row">'.$this->Form->input('status', array(
                            'div'   => 'col-sm-12',
                            'class' => 'form-control',
                            'label' => 'Estatus',
                            'type' => 'select',
                            'options' => $status_cliente,
                            'id' => 'select_status',
                            'onchange' => 'status_select_input();'
                        )).'</div>';

                        echo '<div class="row" id="row_motivo" style="display:none;" >'.$this->Form->input('motivo', array(
                            'div'   => 'col-sm-12',
                            'class' => 'form-control',
                            'label' => 'Motivo',
                            'type'  => 'select',
                            'empty' => 'seleccione una opción',
                            'options' => $motivos_inactivo_temporal,
                            'onchange' => 'otro_motivo();'
                        )).
                        '</div>';
                        
                         echo '<div class="row" id="row_motivo_2" style="display:none;" >'.$this->Form->input('motivo_2', array(
                            'div'   => 'col-sm-12',
                            'class' => 'form-control',
                            'label' => 'Motivo',
                            'type'  => 'select',
                            'empty' => 'seleccione una opción',
                            'options' => $motivos_inactivo_definitivo,
                            'onchange' => 'otro_motivo();'
                        )).
                        '</div>';

                        echo '<div class="row" id="row_calendario" style="display:none;" >'.$this->Form->input('recordatorio_reactivacion', array(
                            'div'         => 'col-sm-12',
                            'class'       => 'form-control fecha',
                            'label'       => array(
                                'text'  => 'Elige una fecha si deseas que el sistema te recuerde de este usuario',
                                'class' => 'padding10 bg-warning mt-1'
                            ),
                            'placeholder' => 'dd-mm-YYYY',
                            'autocomplete' => 'off'
                        )).
                        '</div>';

                        echo $this->Form->hidden('nombre_cliente', array('value'=>$cliente['Cliente']['nombre']));
                    ?>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success float-xs-right">Guardar</button>
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        </div>
        <?= $this->Form->end(); ?>
      </div>
    </div>
</div>
<!-- Modal para crear cotización -->
<div class="modal fade" id="sendEmailCotizacion">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('CotizacionSend'); ?>
      <div class="modal-content">
        <div class="modal-header bg-blue-is">
          <h4 class="modal-title col-sm-10">Envío de cotización vía email </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            ¿ Desea mandar la cotización previamente validada ?
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" onclick='submitFormShareCotizacionEmail()'>Enviar</button>
        </div>
        <?= $this->Form->hidden('inmueble_id'); ?>
        <?= $this->Form->hidden('cliente_id'); ?>
        <?= $this->Form->hidden('cotizacion_id'); ?>
        <?= $this->Form->end(); ?>
      </div>
    </div>
</div>
<!-- Modal para busqueda vanzada de inmuebles -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header bg-blue-is">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-white" id="myModalLabel1" style="color:black">
                    <i class="fa fa-search"></i>
                    Búsqueda Avanzada de Inmuebles
                </h4>

            </div>

            <div class="modal-body">

                <?= $this->Form->create('Lead',array('url'=>array('controller'=>'leads','action'=>'add'),'class'=>'form-horizontal'))?>
                <?= $this->Form->hidden('cliente_id', array('value' => $cliente['Cliente']['id'])) ?>
                

                <div class="row">
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="tipo_inmueble" class="form-control-label">Tipo</label>
                    </div>
                    <?= $this->Form->input('tipo_inmueble',array('class'=>'form-control','empty'=>'Todos los tipos','options'=>$tipo_propiedad,'type'=>'select','div'=>'col-md-8 m-t-15','label'=>false,))?>
                </div>

                <div class="row">
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="operacion" class="form-control-label">Operación</label>
                    </div>
                    
                    <?= $this->Form->input('operacion',array('class'=>'form-control','empty'=>'Todas las operaciones','options'=>array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta'),'type'=>'select','div'=>'col-md-8 m-t-15','label'=>false,))?>
                </div>


                <div class="row">
                                        
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="precio_minimo" class="form-control-label">Rango Precio</label>
                    </div>
                    <?= $this->Form->input('precio_min',array('class'=>'form-control','placeholder'=>'Precio Mínimo','div'=>'col-md-4 m-t-15','label'=>false, 'type' => 'number'))?>
                    <?= $this->Form->input('precio_max',array('class'=>'form-control','placeholder'=>'Precio Máximo','div'=>'col-md-4 m-t-15','label'=>false, 'type' => 'number'))?>
                    
                </div>

                <div class="row">
                                        
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="habitaciones" class="form-control-label">Habitaciones</label>
                    </div>
                    <?= $this->Form->input('hab_min',array('class'=>'form-control','placeholder'=>'Habitaciones Mínimas','div'=>'col-md-4 m-t-15','label'=>false, 'type' => 'number'))?>
                    <?= $this->Form->input('hab_max',array('class'=>'form-control','placeholder'=>'Habitaciones Máximas','div'=>'col-md-4 m-t-15','label'=>false, 'type' => 'number'))?>

                </div>

                <div class="row">
                                        
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="baños" class="form-control-label">Baños</label>
                    </div>
                    <?= $this->Form->input('banios_min',array('class'=>'form-control','placeholder'=>'Baños Mínimos','div'=>'col-md-4 m-t-15','label'=>false, 'type' => 'number'))?>
                    <?= $this->Form->input('banios_max',array('class'=>'form-control','placeholder'=>'Baños Máximos','div'=>'col-md-4 m-t-15','label'=>false, 'type' => 'number'))?>

                </div>

                <div class="row">
                                        
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="terreno" class="form-control-label">Terreno</label>
                    </div>
                    <?= $this->Form->input('terreno_min',array('class'=>'form-control','placeholder'=>'Terreno Mínimo','div'=>'col-md-4 m-t-15','label'=>false,))?>
                    <?= $this->Form->input('terreno_max',array('class'=>'form-control','placeholder'=>'Terreno Máximo','div'=>'col-md-4 m-t-15','label'=>false,))?>

                </div>

                <div class="row">
                                        
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="construccion" class="form-control-label">Construcción</label>
                    </div>
                    <?= $this->Form->input('construccion_min',array('class'=>'form-control','placeholder'=>'Construcción Mínima','div'=>'col-md-4 m-t-15','label'=>false,))?>
                    <?= $this->Form->input('construccion_max',array('class'=>'form-control','placeholder'=>'Construcción Máxima','div'=>'col-md-4 m-t-15','label'=>false,))?>

                </div>

                <div class="row">
                                        
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="estacionamiento" class="form-control-label">Estacionamiento</label>
                    </div>
                    <?= $this->Form->input('est_min',array('class'=>'form-control','placeholder'=>'Estacionamiento Mínimo','div'=>'col-md-4 m-t-15','label'=>false,))?>
                    <?= $this->Form->input('est_max',array('class'=>'form-control','placeholder'=>'Estacionamiento Máximo','div'=>'col-md-4 m-t-15','label'=>false,))?>

                </div>

                <?php if( $this->Session->read('CuentaUsuario.CuentaUser.group_id') != 3 ): ?>
                    <div class="row">

                        
                        
                        <div class="col-xl-4 text-xl-left m-t-15">
                            <label for="estado" class="form-control-label">Estado</label>
                        </div>

                        <?= $this->Form->input('estado',array('type'=>'select','options'=> array(0=> 'Bloqueada', 1=> 'Libre', 2=> 'Reservado', 3=> 'Contrato', 4=> 'Escrituracion', 5=> 'Baja'),'empty'=>'Todos los estatus','class'=>'form-control','div'=>'col-md-8 m-t-15','label'=>false,))?>

                    </div>
                <?php else: ?>
                    <?= $this->Form->hiden('estado',array('type'=>'select','options'=> array(0=> 'Bloqueada', 1=> 'Libre', 2=> 'Reservado', 3=> 'Contrato', 4=> 'Escrituracion', 5=> 'Baja'),'empty'=>'Todos los estatus','class'=>'form-control','div'=>'col-md-8 m-t-15','value'=>'1' ))?>
                <?php endif; ?>


            </div>
            
            <div class="modal-footer">
                
                <button type="submit" class="btn btn-success float-xs-right" id="add-new-event">
                Realizar Búsqueda
                </button>

                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<!-- Modal para busqueda avanzada de desarrollos -->
<div class="modal fade" id="modalLeadDesarrollos" tabindex="-1" role="dialog" aria-hidden="true" >
    <?= $this->Form->create('Lead',array('url'=>array('controller'=>'leads','action'=>'add_desarrollo'),'class'=>'form-horizontal'))?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-building fa-lg"></i>
                    Buscar Desarrollo para Cliente
                </h4>
            </div>
            <div class="modal-body">
                <div class="row m-t-10">
                     <?php
                         echo $this->Form->input('desarrollo_id', array('div' => 'col-lg-12','class'=>'form-control chzn-select','label'=>'Desarrollos','type'=>'select'));
                     ?>
                    <?= $this->Form->hidden('all');?>
                    <?= $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']))?>
                    
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cancelar
                    <i class="fa fa-times"></i>
                </button>
                
                <button type="button" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="validacion()">
                    <i class="fa fa-send"></i>
                    Enviar desarrollo
                </button>

                <button type="submit" class="btn btn-primary pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()"  style="margin-left: 5px;">
                    <i class="fa fa-search"></i>
                    Buscar unidades
                </button>

            </div>

            <script>
                function validacion(){
                    $("#LeadAll").val(1);
                    $('#LeadAddDesarrolloForm').submit();
                }
            </script>
            
        </div>
    </div>
    <?= $this->Form->end()?>
</div>
<!-- Modal agregar factura -->
<div class="modal fade" id="modal_new_factura" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('Factura', array('url'=>array('action'=>'add', 'controller'=>'facturas'))) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal5" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    Agregar nueva factura
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->hidden('cliente_id', array('value'=>$cliente['Cliente']['id'])) ?>
                <?= $this->Form->hidden('ruta', array('value'=>2)) ?>
                <?= $this->Form->hidden('total') ?>
                    <div class="row mt-1">
                        <?= $this->Form->input('categoria_id', array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>$categorias, 'label'=>'Categoria de Factura')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('referencia', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6')) ?>
                        <?= $this->Form->input('folio', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('inmueble_id', array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>$propiedades, 'label'=>'Propiedad relacionada(Opcional)')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('fecha_emision', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text')) ?>
                        <?= $this->Form->input('fecha_pago', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('concepto', array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'textarea', 'rows'=>'2', 'maxlength'=>'200')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('subtotal', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Subtotal*', 'class'=>'form-control', 'required'=>true, 'onchange'=>'calTotal();')) ?>
                        <?= $this->Form->input('iva', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Iva*', 'class'=>'form-control', 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>array(0=>'0%', 10=>'10%', 16=>'16%'), 'onchange'=>'calTotal();', 'required'=>true)) ?>
                        <?= $this->Form->input('total_2', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Total*', 'class'=>'form-control', 'disabled'=>true)) ?>
                    </div>
                    <!-- <div class="row mt-1">
                        <?= $this->Form->input('pdf', array('div'=>'col-sm-12 col-lg-6', 'label'=>'pdf', 'class'=>'form-control')) ?>
                        <?= $this->Form->input('xml', array('div'=>'col-sm-12 col-lg-6', 'label'=>'Xml', 'class'=>'form-control')) ?>
                    </div> -->
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar factura
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<!-- Modal para agregar un nuevo pago a una factura -->
<div class="modal fade" id="modal_cash_factura" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('Factura', array('url'=>array('action'=>'add', 'controller'=>'facturas'))) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal5" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    Pagar nueva factura
                </h4>
            </div>
            <div class="modal-body">
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar factura
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<!-- Modal para cambio de asesor -->
<div class="modal fade" id="changeOfAdviser" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
        <?= $this->Form->create('Cliente',array('url'=>array('action'=>'reasignar','controller'=>'clientes'))); ?>
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-exchange fa-lg"></i>
                    Cambio de agente
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?= $this->Form->input('asesor_id_2',
                        array(
                            'div'     => 'col-sm-12 col-lg-5',
                            'class'   => 'form-control chzn-select',
                            'options' => $asesores,
                            'label'   => false,
                            'value'   => $cliente['User']['id'],
                            'disabled'
                        )
                    );?>

                    <span class='col-sm-12 col-lg-2 text-sm-center'> <i class='fa fa-arrow-right fa-x2'></i> </span>

                    <?= $this->Form->input('asesor_id',
                        array(
                            'div'     => 'col-sm-12 col-lg-5',
                            'class'   => 'form-control chzn-select',
                            'options' => $asesores,
                            'label'   => false,
                            'empty'   => 'Seleccione una opción',
                            'required',
                        )
                    );?>
                </div>
                <div class="row">
                    <?= $this->Form->input('motivo',
                        array(
                            'div'     => 'col-sm-12 mt-1',
                            'class'   => 'form-control chzn-select',
                            'options' => $motivos,
                            'label'   => 'Motivo*',
                            'empty'   => 'Seleccione una opción',
                            'required'
                        )
                    );?>
                </div>
            </div>
            
            <div class="modal-footer">
                <?= $this->Form->button('Guardar', array('type' => 'button', 'onclick' => 'submitClienteReasignarForm()', 'class' => 'btn btn-success float-xs-right')) ?>
            </div>
            
            <?= $this->Form->hidden('asesor_original', array('value' => $cliente['User']['id'])); ?>
            <?= $this->Form->hidden('cliente_id', array('value' => $cliente['Cliente']['id'])); ?>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<div class="modal fade" id="validacion_asesor" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    Validación de cotización
                </h4>
            </div>
            <?= $this->Form->create('ValidateCotizacion', array('id' => 'fValidateCotizacion'))?>
                <div class="modal-body" style="overflow-y: scroll;">
                    La siguiente cotización sera agregada para continuar con el proceso de venta.
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right">
                        Validar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>

        </div>
       
        <?= $this->Form->hidden('inmueble_id',array('id'=>'ValidacionCotizacionInmuebleId'))?>
        <?= $this->Form->hidden('cotizacion_id',array('id'=>'ValidacionCotizacionCotizacionId'));?>

        <?= $this->Form->end()?>
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-xs-12">

                <h4 class="nav_top_align">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Información de cliente
                
                    <span class="float-xs-right">
                        <?=
                            $this->Html->link('Editar cliente', array('action' => 'edit', $cliente['Cliente']['id']), array('escape' => false, 'class' => 'btn btn-success btn-sm'));
                        ?>
                    </span>
                </h4>
            
            </div>
        </div>
    </header>

    <div class="outer">
        <div class="inner bg-container">

        <!-- Fila 1 -->
        <div class="row">
            
            <!-- Informacion general -->
            <div class="col-sm-12 col-lg-6 mt-2">
                <div class="card">
                    <div class="card-header bg-blue-is">
                        Cliente: <?= $cliente['Cliente']['nombre']?>
                    </div>

                    <div class="card-block">
                        <div class="feed" style="overflow-y: scroll; height:630px !important">
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>Nivel de Interés</td>
                                        <td>
                                            <?php 
                                                $nivel = $cliente['Cliente']['nivel_interes_prospeccion']==""?0:$cliente['Cliente']['nivel_interes_prospeccion'];
                                                for($i=1;$i<4;$i++){
                                                    if ($nivel>=$i){
                                                        echo $this->Form->postLink('<i class="fa fa-star fa-lg" style="color:gold"></i>', array('controller'=>'clientes','action' => 'editNivelInteres', $cliente['Cliente']['id'],$i), array('escape'=>false, 'confirm'=>'¿Desea cambiar el nivel de interés de este cliente?', $cliente['Cliente']['id']));
                                                    }else{
                                                        echo $this->Form->postLink('<i class="fa fa-star fa-lg"></i>', array('controller'=>'clientes','action' => 'editNivelInteres', $cliente['Cliente']['id'],$i), array('escape'=>false, 'confirm'=>'¿Desea cambiar el nivel de interés de este cliente?', $cliente['Cliente']['id']));
                                                    }
                                                    
                                                }
                                                echo ( !empty( $cliente['Cliente']['nivel_interes_prospeccion'] ) ?  ' '.$interes[$cliente['Cliente']['nivel_interes_prospeccion']] : '')
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estatus de Cliente</td>
                                        <td 
                                            style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: left;align-items: center;align-content: center; border: none;">
                                                <span style="<?= $style ?>">
                                                    <?= $cliente['Cliente']['status'] ?>
                                                </span>

                                                <?php if ($this->Session->read('Permisos.Group.ce') == 1 && $cliente['Cliente']['status'] != 'Inactivo' ): ?>
                                                    <?= $this->Html->link('<i class="fa fa-edit"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#modal112'))?>
                                                <?php endif ?>

                                                <!-- Poner el boton si es que tiene los permisos para reactivar -->
                                                <?php if ($this->Session->read('Permisos.Group.cr') == 1 && $cliente['Cliente']['status'] == 'Inactivo' ): ?>
                                                    <?= $this->Html->link('<i class="fa fa-edit"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#modal112'))?>
                                                <?php endif ?>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Estatus de Atención
                                        </td>
                                        <td style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: left;align-items: center;align-content: center; border: none;">
                                            
                                            <span class="<?= $class_at ?>">
                                                <?= $status_atencion; ?>
                                            </span>

                                        </td>

                                    </tr>
                                    <!-- Status de atención al cliente -->
                                    <tr>
                                        <td>Creado</td>
                                        <td><?= date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']))?></td>
                                    </tr>
                                    <tr>
                                        <td>Asignación</td>
                                        <td><?php 
                                                if ($cliente['Cliente']['user_id']==""){
                                                    echo "NO ASIGNADO";
                                                }
                                                if ($cliente['Cliente']['user_id']!="" && $cliente['Cliente']['asignado']==null){
                                                    echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']));
                                                }
                                                if ($cliente['Cliente']['asignado']!=null)
                                                    echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['asignado']));
                                                ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Primer Seguimiento</td>
                                        <td><?php
                                                if ($cliente['Cliente']['first_edit']==null && $cliente['Cliente']['last_edit']==null){
                                                    echo "Cliente sin Seguimiento";
                                                }
                                                if ($cliente['Cliente']['first_edit']==null && $cliente['Cliente']['last_edit']!=null){
                                                    echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']));
                                                }
                                                if ($cliente['Cliente']['first_edit']!=null){
                                                    echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['first_edit']));
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Último Seguimiento</td>
                                        <td><?php
                                                if ($cliente['Cliente']['last_edit']==null){
                                                    echo "Cliente sin Seguimiento";
                                                }
                                                if ($cliente['Cliente']['last_edit']!=null){
                                                    echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['last_edit']));
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td> Teléfono 1</td>
                                        <td><?= $cliente['Cliente']['telefono1'] ?></td>
                                    </tr>
                                    
                                    <?php if( $cliente['Cliente']['telefono2'] != ''): ?>
                                        <tr>
                                            <td> Teléfono 2</td>
                                            <td><?= $cliente['Cliente']['telefono2']?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if( $cliente['Cliente']['telefono3'] != ''): ?>
                                        <tr>
                                            <td> Teléfono 3</td>
                                            <td><?= $cliente['Cliente']['telefono3']?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <td> Email</td>
                                        <td><?= $cliente['Cliente']['correo_electronico']?></td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de Cliente</td>
                                        <td><?= $cliente['DicTipoCliente']['tipo_cliente']?></td>
                                    </tr>
                                    <tr>
                                        <td>Forma de contacto</td>
                                        <td><?=  $cliente['DicLineaContacto']['linea_contacto']?></td>
                                    </tr>
                                    <tr>
                                        <td> Agente </td>
                                        <td>
                                            <?php
                                                if( $this->Session->read('Permisos.Group.call') == 1){
                                                    
                                                    echo $this->Html->link($cliente['User']['nombre_completo'], array('controller' => 'users', 'action' => 'view', $cliente['User']['id'] ), array('escape' => false));

                                                }else {
                                                    echo $cliente['User']['nombre_completo'];
                                                }

                                                if($this->Session->read('Permisos.Group.rc') == 1 ){
                                                    echo ' '.$this->Html->link('<i class="fa fa-exchange"></i>', '', array('escape' => false, 'data-toggle' => 'modal', 'data-target' => '#changeOfAdviser'));
                                                }
                                            ?>
                                            

                                        </td>
                                    </tr>
                                    
                                    <tr>
                                    
                                        <?php

                                            switch ($cliente['Cliente']['etapa']) {
                                                case 1:
                                                    $style = "bg-etapa1";
                                                    break;

                                                case 2:
                                                    $style = "bg-etapa2";
                                                    break;

                                                case 3:
                                                    $style = "bg-etapa3";
                                                    break;
                                                case 4:
                                                    $style = "bg-etapa4";
                                                    break;
                                                case 5:
                                                    $style = "bg-etapa5";
                                                    break;
                                                case 6:
                                                    $style = "bg-etapa6";
                                                    break;
                                                case 7:
                                                    $style = "bg-etapa7";
                                                    break;
                                            }
                                        ?>
                                        <td>Etapa</td>

                                        <td style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: left;align-items: center;align-content: center;">
                                                <span class="chip <?= $style ?>">
                                                    <?= $etapas_clientes[$cliente['Cliente']['etapa']]?>
                                                </span>
                                                <?php
                                                    switch( $cliente['Cliente']['etapa'] ){
                                                        case 1:
                                                            echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Aviso: Recuerda que este cambio es manual y deberá realizarse cuando el cliente responda vía correo, whatsapp o llamada e inicie una comunicación entre las partes.'));
                                                        break;
                                                        case 2:
                                                            echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Aviso: En el cambio de etapa manual el usuario asume la responsabilidad del cambio y debe registrar la razón del mismo.'));
                                                        break;
                                                        case 4:
                                                            echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Aviso: En el cambio de etapa manual el usuario asume la responsabilidad del cambio y debe registrar la razón del mismo.'));
                                                        break;
                                                        default:
                                                            
                                                        break;
                                                    }
                                                ?>

                                        </td>
                                    </tr>
                                    <?php if($cliente['Cliente']['etapa'] == 2):?>
                                        <tr>
                                            <td colspan=2>
                                                <h6 class="text-black" style="font-weight:bold;"> <i class="fa fa-warning"></i> El cambio a etapa 3 se puede realizar de manera automática al asignar una o más unidades  al cliente, o al registrar una cita con el cliente.</h6>
                                            </td>
                                        </tr>
                                    <?php elseif($cliente['Cliente']['etapa'] == 3):?>
                                        <tr>
                                            <td colspan=2>
                                                <h6 class="text-black" style="font-weight:bold;"> <i class="fa fa-warning"></i> Aviso: El cambio a etapa 4 o 5 se puede realizar de la siguiente forma: 1.-Automáticamente al validar una cita en visita. 2.-Automáticamente hasta la etapa 5 si se selecciona una cotización raíz.</h6>
                                            </td>
                                        </tr>
                                    <?php elseif($cliente['Cliente']['etapa'] == 4):?>
                                        <tr>
                                            <td colspan=2>
                                                <h6 class="text-black" style="font-weight:bold;"> <i class="fa fa-warning"></i> El cambio a etapa 5 se puede realizar de manera automática al seleccionar una cotización raíz.</h6>
                                            </td>
                                        </tr>
                                    <?php elseif($cliente['Cliente']['etapa'] == 5):?>
                                        <tr>
                                            <td colspan=2>
                                                <h6 class="text-black" style="font-weight:bold;"> <i class="fa fa-warning"></i> Aviso: El cambio a etapa 6 se puede realizar sólo de una forma: 1.-Automáticamente al registrar un apartado.</h6>
                                            </td>
                                        </tr>
                                    <?php elseif($cliente['Cliente']['etapa'] == 6):?>
                                        <tr>
                                            <td colspan=2>
                                                <h6 class="text-black" style="font-weight:bold;"> <i class="fa fa-warning"></i> Aviso: El cambio a etapa 6 se puede realizar únicamente de una forma: 1.- Automáticamente al registrar un apartado.</h6>
                                            </td>
                                        </tr>
                                    
                                    <?php endif;?>


                                    <tr>
                                        <td>Desarrollo/Propiedad de interes</td>
                                        <td><?= $cliente['Inmueble']['titulo'].''.$cliente['Desarrollo']['nombre'] ?></td>
                                    </tr>
                                                    
                                    <?php if($cliente['Cliente']['comentarios'] != '' ): ?>
                                        <tr>
                                            <td>
                                                Comentario de cambio de etapa.
                                            </td>
                                            <td>
                                                <?= $cliente['Cliente']['comentarios'] ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segumiento rapido y proximos eventos -->
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <!-- Swguimiento rapido -->
                    <div class="col-sm-12 mt-2">
                        <div class="card">
                            <div class="card-header bg-blue-is">
                                Seguimiento Rápido
                            </div>
                            <div class="card-block">
                                <div class="feed mt-1" style="overflow-y: scroll; height:379px !important">
                                    <ul>                                                            
                                        <?php foreach ($agendas as $agenda):?>
                                        <li>
                                            <span>
                                                <?= $this->Html->image($agenda['User']['foto'], array('class'=>'img-circle img-bordered-sm','style'=>'width: 100%'))?>
                                            </span>
                                            <h5>
                                                <font color="black">
                                                    <?php 
                                                        if (isset($asesores[$agenda['User']['id']])){
                                                            echo $this->Html->link($agenda['User']['nombre_completo'], array('controller'=>'Users', 'action'=>'view', $agenda['User']['id']));
                                                        }else{
                                                            echo $agenda['User']['nombre_completo'];
                                                        } 
                                                    ?>
                                                </font>
                                                
                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.ae') == 1 && $agenda['Agenda']['edicion'] == 1 && $this->Session->read('Permisos.Group.ad') == 1) {
                                                        
                                                        echo $this->Form->input('seleccion_opciones',
                                                            array(
                                                                'type'      =>'select',
                                                                'options'   => array(1=>'Eliminar', 2=> 'Editar' ),
                                                                'label'     => false,
                                                                'class'     => 'input-opciones',
                                                                'div'       => false,
                                                                'empty'     => 'Editar/Eliminar',
                                                                'id'        => 'seleccion-opcion-'.$agenda['Agenda']['id'],
                                                                'onchange'  => 'seleccion_opcion('.$agenda['Agenda']['id'].', "'.$agenda['Agenda']['mensaje'].'")'
                                                            )
                                                        );
                                                    }elseif( $this->Session->read('Permisos.Group.ae') >= 2 && $agenda['Agenda']['edicion'] == 1 ){
                                                        echo $this->Form->input('seleccion_opciones',
                                                            array(
                                                                'type'      =>'select',
                                                                'options'   => array(2=> 'Editar' ),
                                                                'label'     => false,
                                                                'class'     => 'input-opciones',
                                                                'div'       => false,
                                                                'empty'     => 'Editar',
                                                                'id'        => 'seleccion-opcion-'.$agenda['Agenda']['id'],
                                                                'onchange'  => 'seleccion_opcion('.$agenda['Agenda']['id'].', "'.$agenda['Agenda']['mensaje'].'")'
                                                            )
                                                        );
                                                    }
                                                ?>
                                            </h5>
                                            <p>
                                                <?= $agenda['Agenda']['mensaje']?>
                                            </p>
                                            <i>
                                                <?= $agenda['Agenda']['fecha'] ?>
                                            </i>

                                            <?php if( !empty( $agenda['Agenda']['fecha_edicion'] )): ?>
                                                <i>
                                                    Editado <?= date('Y-m-d H:m', strtotime($agenda['Agenda']['fecha_edicion'])) ?>
                                                </i>
                                            <?php endif; ?>


                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <!-- Proximos eventos -->
                    <div class="col-sm-12 mt-2">
                        <div class="card">
                            <div class="card-header bg-blue-is">
                                <div class="row">
                                    <div class="col-sm-6">
                                        Próximos Eventos (15 días)
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="float-xs-right" style="text-transform: uppercase;">
                                            <i class=" fa fa-home"></i> Cita
                                            <i class=" fa fa-phone"></i> Llamada
                                            <i class=" fa fa-envelope"></i> Correo
                                            <i class=" fa fa-check-circle"></i> Visita
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="feed" style="overflow-y: scroll; height:150px !important">
                                    <?= $this->element('Events/eventos_proximos'); ?>
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información del perfil -->
        <div class="row">
            <div class="col-sm-12 col-lg-12 mt-2">
                <div class="card">
                    <div class="card-header bg-blue-is">
                        Información del Perfil del cliente
                        <div style="float:right">
                            <?php if( $cliente['Cliente']['etapa'] >= 2 ): ?>
                                <?= $this->Html->link('Información de prospección','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'class' => 'btn btn-success btn-sm','data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 0)'))?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="flex-container">
                                
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 15%">
                                                        <?= $this->Html->image('adryo_iconos/Operacion.png', array('class' => 'img-icon')); ?>        
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= $cliente['Cliente']['operacion_prospeccion'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Propiedad.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= $cliente['Cliente']['tipo_propiedad_prospeccion']?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Rango-de-precios.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= number_format($cliente['Cliente']['precio_min_prospeccion'],1)?> - <?= number_format($cliente['Cliente']['precio_max_prospeccion'],1)?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Formas-de-pago.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= $cliente['Cliente']['forma_pago_prospeccion']?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Metraje.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= $cliente['Cliente']['metros_min_prospeccion']?> - <?= $cliente['Cliente']['metros_max_prospeccion']?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Habitaciones.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= ($cliente['Cliente']['hab_prospeccion'] == 5 ) ? '+5' : $cliente['Cliente']['hab_prospeccion'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Wc.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= ($cliente['Cliente']['banios_prospeccion'] == 5 ) ? '+5' : $cliente['Cliente']['banios_prospeccion'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex-item">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <?= $this->Html->image('adryo_iconos/Estacionamiento.png', array('class' => 'img-icon')); ?>
                                                    </td>
                                                    <td class="subtitle text-sm-center">
                                                        <?= ($cliente['Cliente']['estacionamientos_prospeccion'] == 5 ) ? '+5' : $cliente['Cliente']['estacionamientos_prospeccion'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    

                                </div>
                            </div>

                            <div class="col-sm-6">

                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%">
                                                <?= $this->Html->image('adryo_iconos/Ubicacion.png', array('class' => 'img-icon')); ?>
                                            </td>
                                            <td class="subtitle text-sm-center pointer" id="show_tip_1" data-placement='top' title='<?= $cliente['Cliente']['estado_prospeccion']?> / <?= $cliente['Cliente']['ciudad_prospeccion']?> / <?= $cliente['Cliente']['colonia_prospeccion']?> / <?= $cliente['Cliente']['zona_prospeccion']?>' data-toggle='tooltip'>
                                                <?= substr($cliente['Cliente']['estado_prospeccion'], 0, 50) ?> <small onclick="show_tool_tip(1)"> (mostrar mas...)</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                    
                            </div>

                            <div class="col-sm-6 col-lg-6 ">

                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%">
                                                <?= $this->Html->image('adryo_iconos/Amenidades.png', array('class' => 'img-icon')); ?>
                                            </td>
                                            <td class="subtitle text-sm-center pointer" id="show_tip_2" data-placement='top' title='<?= $cliente['Cliente']['amenidades_prospeccion'] ?>' data-toggle='tooltip'>
                                                <?= substr($cliente['Cliente']['amenidades_prospeccion'], 0, 50) ?> <small onclick="show_tool_tip(2,)"> (mostrar mas...)</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>                                        
        </div>

        <!-- Fila 2 -->
        <div class="row">
            
            <!-- indicadores de kpis clientes -->
            <?= $this->Element('Clientes/clientes_kpis') ?>
            <!-- Seguimiento rápido -->
            <div class="col-sm-12 col-lg-6 mt-2">
                <div class="card">
                    <div class="card-header bg-blue-is">
                        Seguimiento Rápido <small class ="text-light">(Máximo 250 caracteres.)</small>
                    </div>
                    <div class="card-block">
                        <div class="feed" style=" height:165px !important">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="user-block">
                                        <?= $this->Form->create('Agenda',array('url'=>array('controller'=>'Agendas','action'=>'add')))?>
                                        <?php 
                                            if ($this->Session->read('Permisos.Group.id')==3){

                                                if( $this->Session->read('Permisos.Group.id') == 5 ){
                                                    echo $this->Form->checkbox('asesoria', array('label' => 'Solicitar apoyo del gerente.','class' => 'disabled'));
                                                    
                                                }else {
                                                    
                                                    echo $this->Form->checkbox('asesoria')." Solicitar apoyo del gerente.";
                                                }
                                            }else{
                                                if( $this->Session->read('Permisos.Group.id') == 5 ){
                                                    echo $this->Form->checkbox('asesoria', array('label' => 'Notificar por mail a asesor.','class' => 'disabled'));
                                                }else {
                                                    echo $this->Form->checkbox('asesoria')." Notificar por mail a asesor.";

                                                }
                                            }

                                        ?>

                                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                                            <?= $this->Form->input('mensaje',array('class'=>'form-control input-sm disabled','placeholder'=>'Escribe un mensaje','label'=>false, 'rows'=>5, 'maxlength'=>250))?>
                                        <?php else: ?>
                                            <?= $this->Form->input('mensaje',array('class'=>'form-control input-sm','placeholder'=>'Escribe un mensaje','label'=>false, 'rows'=>5, 'maxlength'=>250))?>
                                        <?php endif; ?>



                                        <?= $this->Form->input('user_id',array('value'=>$this->Session->read('Auth.User.id'),'type'=>'hidden'))?>
                                        <?= $this->Form->input('lead_id',array('value'=>0,'type'=>'hidden'))?>
                                        <?= $this->Form->input('fecha',array('value'=>date("Y-m-d H:i:s"),'type'=>'hidden'))?>
                                        <?= $this->Form->input('cliente_id',array('value'=>$cliente['Cliente']['id'],'type'=>'hidden'))?>
                                        <?= $this->Form->hidden('edicion', array('value' => 1)) ?>
                                        
                                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                                            <?= $this->Form->button('Guardar mensaje',array('type'=>'button','class'=>'btn m-t-5 disabled'))?>
                                        <?php else: ?>
                                            <?= $this->Form->button('Guardar mensaje',array('type'=>'submit','class'=>'btn btn-primary m-t-5'))?>
                                        <?php endif; ?>

                                        <?= $this->Form->end()?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- eventos de seguimiento -->
            <div class="col-sm-12 col-lg-6 mt-2">
                <div class="card">
                    <div class="card-header bg-blue-is">
                        Registrar Eventos de Seguimiento
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-4">
                                <?php  if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                                    <a class="btn disabled m-t-5" ><i class="fa fa-calendar"></i> Registar Evento</a>

                                <?php else: ?>
                                    <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#addEvento"><i class="fa fa-calendar"></i> Registrar Evento</a>
                                <?php endif; ?>

                            </div>
                            <div class="col-lg-4">

                            <?php  if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                                <?= $this->Html->link('<i class="fa fa-phone"></i> Registrar llamada','#', array('escape'=>false, 'class'=>'btn disabled m-t-5'))?>

                            <?php else: ?>
                                <?= $this->Html->link('<i class="fa fa-phone"></i> Registrar llamada','#', array('escape'=>false, 'data-toggle'=>'modal', 'data-target'=>'#addLlamada', 'class'=>'btn btn-primary m-t-5'))?>

                            <?php endif; ?>

                                
                            </div>
                            
                            <div class="col-lg-4">
                                
                                <?php if( $cliente['Cliente']['correo_electronico'] != 'Sin correo'): ?>
                                    
                                    <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#modal_mail_compose"><i class="fa fa-envelope"></i> Envíar Mail</a>

                                <?php else: ?>
                                    <a  href="#" class="btn btn-primary m-t-5 disabled" disabled data-placement='top' title='Sin correo' data-toggle="tooltip"><i class="fa fa-envelope"></i> Envíar Mail</a>
                                <?php endif; ?>
                                
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Desarrollos e inmuebles -->
        <div class="row">
            <!-- desarrollos -->
            <div class="col-sm-12 col-lg-6 mt-2">
                <?= $this->Form->create('Lead',array('url'=>array('action'=>'enviar_desarrollos',  $cliente['Cliente']['id']))); ?>
                <?= $this->Form->hidden('user_id', array('value' => $cliente['Cliente']['user_id'])) ?>
                <?= $this->Form->hidden('cliente_id', array('value' => $cliente['Cliente']['id'])) ?>
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12">
                                    Desarrollos seleccionados
                                    <span class="float-right">
                                    <?php  if( $this-> Session->read('Permisos.Group.id') == 5 ): ?>
                                        <!-- <small class="float-xs-right" style="text-transform: uppercase;">
                                            <a  href="" class="f" data-toggle="modal" data-target="#modalSeguimeinto"><i class="fa fa-plus-circle text-white"></i></a>
                                        </small> -->
                                        <a><i class="fa fa-plus-circle" data-placement='top' title='Agregar otro desarrollo' data-toggle="tooltip" ></i> Agregar desarrollos</a>
                                    <?php else: ?>
                                        <a  href="#" class="btn btn-sm text-white" data-toggle="modal" id="btn-LeadDesarrollos"><i class="fa fa-plus-circle" data-placement='top' title='Agregar otro desarrollo' data-toggle="tooltip" ></i></a>
                                    <?php endif; ?> 
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:550px !important">
                            <table class="table" id="desarrollos">
                                <tbody>
                                    <?php foreach( $desarrollos as $desarrollo ): ?>
                                        <tr>
                                            <td style="box-sizing: border-box;">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <!-- imagen desarrollo e iconos -->
                                                        <div class="row">
                                                            <div class="col-sm-12 col-lg-3">
                                                                <div class="img-bg" style="position:relative;background-size: cover; background-image: URL('<?= (isset($desarrollo['Desarrollo']['FotoDesarrollo'][0]) ? Router::url($desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'], true) : "/img/no_photo_inmuebles.png") ?>') "></div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-9">
                                                                <p class="title">
                                                                    <?= $this->Html->link($desarrollo['Desarrollo']['nombre'], array('controller' => 'desarrollos', 'action' => 'view', $desarrollo['Desarrollo']['id'] ), array('class' => 'underline','color:black')); ?>
                                                                </p>
                                                                <p class="icons-card-lead">
                                                                    <span class="text-sm-center">
                                                                        <?= $this->Html->image('clientes_icons/terreno.png', array('class' => 'img-fluid')) ?>
                                                                        <?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?>
                                                                    </span>
                                                                    <span class="text-sm-center">
                                                                        <?= $this->Html->image('clientes_icons/recamaras.png', array('class' => 'img-fluid')) ?>
                                                                        <?= $desarrollo['Desarrollo']['rec_low']?>-<?= $desarrollo['Desarrollo']['rec_top']?>
                                                                    </span>
                                                                    <span class="text-sm-center">
                                                                        <?= $this->Html->image('clientes_icons/battrom.png', array('class' => 'img-fluid')) ?>
                                                                        <?= $desarrollo['Desarrollo']['banio_low']?>-<?= $desarrollo['Desarrollo']['banio_top']?>
                                                                    </span>
                                                                    <!-- <span class="text-sm-center">
                                                                        <?= $this->Html->image('clientes_icons/toilet.png', array('class' => 'img-fluid')) ?>
                                                                        <?= $desarrollo['Desarrollo']['medio_banos'] ?>
                                                                    </span> -->
                                                                    <span class="text-sm-center">
                                                                        <?= $this->Html->image('clientes_icons/estacionamientos.png', array('class' => 'img-fluid')) ?>
                                                                        <?= $desarrollo['Desarrollo']['est_low']?>-<?= $desarrollo['Desarrollo']['est_top']?>
                                                                    </span>
                                                                </p>
                                                                <!-- botones -->
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-lg-6 float-right">
                                                                        <button type="button" class="btn btn-secondary-o btn-block" onclick="modalShared( 
                                                                                    <?= $desarrollo['Desarrollo']['id']?> , 
                                                                                    <?= $this->Session->read('Auth.User.id') ?>, 
                                                                                    <?= $cliente['Cliente']['id'] ?>, 
                                                                                    '<?= substr($cliente['Cliente']['telefono1'], -10) ?>', 
                                                                                    '<?= $cliente['Cliente']['nombre'] ?>',
                                                                                    1,
                                                                                    '<?= $this->Session->read('Auth.User.nombre_completo') ?>', 
                                                                                    '<?= $cliente['Cliente']['correo_electronico']?>',
                                                                                    '<?= $desarrollo['Desarrollo']['nombre'] ?>', 
                                                                                    
                                                                            )">
                                                                            Compartir
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
            <!-- inmuebles -->
            <div class="col-sm-12 col-lg-6 mt-2">
                <?= $this->Form->create('Lead',array('url'=>array('action'=>'enviar', $cliente['Cliente']['id']))) ?>
                <?= $this->Form->hidden('user_id', array('value' => $cliente['Cliente']['user_id'])) ?>
                <?= $this->Form->hidden('cliente_id', array('value' => $cliente['Cliente']['id'])) ?>
                <div class="card">
                    <div class="card-header bg-blue-is">
                        <div class="row">
                            <div class="col-sm-12">
                                Inmuebles seleccionados
                                <span class="float-right">
                                    <?php  if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                                        <a href="#" class="btn disabled btn-sm"><i class="fa fa-plus-circle" data-placement='top' title='Agregar otra opción' data-toggle="tooltip" ></i> Agregar inmuebles</a>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-sm text-white" data-toggle="modal" data-target="#myModal3"><i class="fa fa-plus-circle" data-placement='top' title='Agregar otra opción' data-toggle="tooltip" ></i></a>
                                    <?php endif; ?>
                                    <?php if( $cliente['Cliente']['correo_electronico'] != "Sin correo" && !empty( $cliente['Cliente']['correo_electronico'] ) ): ?>
                                        <?php  if( $this-> Session->read('Permisos.Group.id') == 5 ): ?>
                                            <!-- <button class="btn disabled btn-sm" title="Reenviar Selección a cliente"><i class="fa  fa-mail-forward"></i>REENVIAR</button>                       -->
                                        <?php else: ?>
                                            <!-- <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Reenviar Selección a cliente"><i class="fa  fa-mail-forward"></i>REENVIAR</button> -->
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-block" style="overflow-y: scroll; height:550px !important;">
                        <table class="table" id="propiedades">
                            
                            <tbody>
                                <?php foreach ($leads as $inmueble): ?>
                                    <tr>
                                        <td style="box-sizing: border-box;">
                                            <div class="card">
                                                <div class="card-block">
                                                    
                                                    <div class="row">

                                                        <div class="col-sm-12 col-lg-3">
                                                            <div class="img-bg" style="position:relative;background-size: cover; background-image: URL('<?= (isset($inmueble['Inmueble']['FotoInmueble'][0]) ? Router::url($inmueble['Inmueble']['FotoInmueble'][0]['ruta'], true) : "/img/no_photo_inmuebles.png") ?>') ">
                                                                <!-- Bandera dependiendo estatus de inmueble. -->
                                                                <?php
                                                                    switch( $inmueble['Inmueble']['liberada']){
                                                                        case 1:
                                                                            echo '<span class="flag bg-libre">Libre</span>';
                                                                            break;
                                                                        case 2:
                                                                            echo '<span class="flag bg-apartado">Apartado</span>';
                                                                            break;
                                                                        case 3:
                                                                            echo '<span class="flag bg-vendido">Vendido</span>';
                                                                            break;
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Botones, iconos, referencia -->
                                                        <div class="col-sm-12 col-lg-9">

                                                            <!-- Referencia -->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <p class="title">
                                                                        <?= $this->Html->link($inmueble['Inmueble']['referencia'], array('controller' => 'inmuebles', 'action' => 'view_tipo', $inmueble['Inmueble']['id'] ), array('class' => 'underline')); ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Iconos -->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <p class="icons-card-lead">
                                                                        <span class="text-sm-center">
                                                                            <?= $this->Html->image('clientes_icons/terreno.png', array('class' => 'img-fluid')) ?>
                                                                            <?= $inmueble['Inmueble']['construccion'] + $inmueble['Inmueble']['construccion_no_habitable']?>
                                                                        </span>
                                                                        <span class="text-sm-center">
                                                                            <?= $this->Html->image('clientes_icons/recamaras.png', array('class' => 'img-fluid')) ?>
                                                                            <?= $inmueble['Inmueble']['recamaras']?>
                                                                        </span>
                                                                        <span class="text-sm-center">
                                                                            <?= $this->Html->image('clientes_icons/battrom.png', array('class' => 'img-fluid')) ?>
                                                                            <?= $inmueble['Inmueble']['banos'] ?>
                                                                        </span>
                                                                        <span class="text-sm-center">
                                                                            <?= $this->Html->image('clientes_icons/toilet.png', array('class' => 'img-fluid')) ?>
                                                                            <?= $inmueble['Inmueble']['medio_banos'] ?>
                                                                        </span>
                                                                        <span class="text-sm-center">
                                                                            <?= $this->Html->image('clientes_icons/estacionamientos.png', array('class' => 'img-fluid')) ?>
                                                                            <?= $inmueble['Inmueble']['estacionamiento_techado'] + $inmueble['Inmueble']['estacionamiento_descubierto']?>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Botones -->
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6 mt-1">
                                                                    <button type="button" class="btn btn-secondary-o btn-block" onclick="modalShared( 
                                                                            <?= $inmueble['Inmueble']['id']?> , 
                                                                            <?= $this->Session->read('Auth.User.id') ?>, 
                                                                            <?= $cliente['Cliente']['id'] ?>, 
                                                                            '<?= substr($cliente['Cliente']['telefono1'], -10) ?>', 
                                                                            '<?= $cliente['Cliente']['nombre'] ?>',
                                                                            2,
                                                                            '<?= $this->Session->read('Auth.User.nombre_completo') ?>',
                                                                            '<?= $cliente['Cliente']['correo_electronico']?>',
                                                                            '<?= $inmueble['Inmueble']['referencia']?>',
                                                                        )">
                                                                        Compartir
                                                                    </button>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 mt-1">
                                                                <?=
                                                                    ( ($inmueble['Inmueble']['liberada'] == 1) ? 
                                                                        $this->Html->link('Crear cotización', 'javascript:addCotizacion('.$inmueble['Inmueble']['id'].',"'.$inmueble['Inmueble']['referencia'].'",'.$inmueble['Inmueble']['precio'].', '.$cliente['Cliente']['id'].')',array( 'class' => 'btn btn-secondary-o btn-block', 'escape' => false )) 
                                                                            :
                                                                        $this->Html->link('Crear cotización', '#' ,array( 'class' => 'btn btn-secondary-o btn-block disabled', 'escape' => false, 'disabled' => true ))
                                                                    );
                                                                ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>

        <!-- Fila de Cotizaciones -->
        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-blue-is">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                Cotizaciones
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm" id="dataCotizaciones">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Acciónes</th>
                                            <th>Folio</th>
                                            <th>Forma de Pago</th>
                                            <th style="text-align:center">Propiedad</th>
                                            <th style="text-align:center">Fecha</th>
                                            <th style="text-align:center">Vigencia</th>
                                            <th style="text-align:center">Precio final</th>
                                            <th style="text-align:center">Imprimir</th>
                                            <th style="text-align:center">Compartir</th>
                                            <th style="text-align:center">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cliente['Cotizaciones'] as $cotizacion): ?>
                                            <tr>
                                                <td style="text-align:left">


                                                    <?php

                                                        switch($cotizacion['status']){
                                                            case 1: 
                                                                echo '
                                                                    <span class="bg-warning chip" title="Cotización Creada">
                                                                        <i class="fa fa-file-o fa-x3"></i>
                                                                    </span>
                                                                ';

                                                            break;
                                                            case 2: 
                                                                echo '
                                                                    <span class="bg-success chip" title="Cotización Validada y Enviada">
                                                                        <i class="fa fa-paper-plane-o fa-x3"></i>
                                                                    </span>
                                                                ';
                                                                echo '
                                                                    <span class="bg-primary chip" title="Cotización Pendiente VoBo del cliente">
                                                                        <i class="fa fa-clock-o fa-x3"></i>
                                                                    </span>
                                                                ';
                                                            break;

                                                            case 3: 
                                                                echo '
                                                                    <span class="bg-success chip" title="Cotización Validada y Enviada">
                                                                        <i class="fa fa-paper-plane-o fa-x3"></i>
                                                                    </span>
                                                                ';
                                                                echo '
                                                                    <span class="bg-primary chip" title="Cotiazción aceptada por el cliente">
                                                                        <i class="fa fa-thumbs-up fa-x3"></i>
                                                                    </span>
                                                                ';

                                                                switch($cotizacion['status_asesor']){
                                                                    case 0: 
                                                                        echo '<span class="pointer chip bg-light text-black" onclick="like_cotizacion('.$cotizacion['id'].', '.$cotizacion['inmueble_id'].')"><i class="fa fa-check"></i></span>';
                                                                    break;
                                                                    case 1: 
                                                                        echo '<span class="chip bg-success"><i class="fa fa-check"></i></span>';

                                                                        // Agregar recorrido para las operaciones del inmueble
                                                                        switch( $cotizacion['Inmueble']['liberada'] ){
                                                                            case 1:
                                                                                echo '<span class="pointer chip bg-light text-black ml-1"> <i class="text-black fa fa-calendar pointer" onclick="showModalProcesoInmuebles(2, '.$cotizacion['inmueble_id'].', '.$cliente["Cliente"]["id"].' )" data-toggle ="tooltip" data-placement="top" title="Apartados / Reservados" ></i> </span>';
                                                                            break;
                                                                            case 2:
                                                                                echo '<span class="pointer chip bg-light text-black ml-1"> <i class="text-black fa fa-dollar pointer" onclick="showModalProcesoInmuebles(3, '.$cotizacion['inmueble_id'].', '.$cliente["Cliente"]["id"].' )" data-toggle ="tooltip" data-placement="top" title="Vendido / Contrato" ></i> </span>';
                                                                            break;
                                                                            case 3:
                                                                            break;
                                                                        }
                                                                        

                                                                    break;
                                                                    default:
                                                                        echo '<span class="chip bg-danger"><i class="fa fa-close"></i></span>';
                                                                    break;
                                                                }
                                                                
                                                            break;
                                                        }

                                                    ?>

                                                </td>
                                                
                                                <td>
                                                    <?= $cotizacion['id'] ?>
                                                </td>
                                                <td><?= $this->Html->link($cotizacion['forma_pago'],array('action'=>'cotizacion_view','controller'=>'cotizacions',$cotizacion['id']), array('target' => '_BLANK') )?></td>
                                                <td><?= $this->Html->link($lista_inmuebles[$cotizacion['inmueble_id']],array('action'=>'view_tipo','controller'=>'inmuebles',$cotizacion['inmueble_id']), array('target' => '_BLANK') )?></td>
                                                <td style="text-align:center"><?= date("d/m/Y",strtotime($cotizacion['fecha']))?></td>
                                                <td style="text-align:center"><?= date("d/m/Y",strtotime($cotizacion['vigencia']))?></td>
                                                <td style="text-align:center"> $ <?= number_format( $cotizacion['precio_final'], 2 ) ?></td>
                                                <td style="text-align:center"><?= $this->Html->link("<i class='fa fa-print'></i>",array('action'=>'cotizacion_view','controller'=>'cotizacions',$cotizacion['id']),array('escape'=>false, 'target' => '_BLANK'))?></td>
                                                <td class='text-sm-center'>
                                                    <?php if( $cliente['Cliente']['telefono1'] != 'Sin teléfono' ): ?>
                                                        <span class="pointer" onclick="open_send_cotizacion('<?= $cliente['Cliente']['nombre'] ?>', <?= $cliente['Cliente']['id'] ?> ,<?= $cotizacion['id'] ?>, '<?= $lista_inmuebles[$cotizacion['inmueble_id']] ?>', <?= $cliente['Cliente']['telefono1'] ?> )">
                                                            <i class="fa fa-whatsapp fa-lg"></i>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="disabled">
                                                            <i class="fa fa-whatsapp fa-lg"></i>
                                                        </span>
                                                    <?php endif; ?>

                                                    <span class="pointer" onclick="open_send_cotizacion_email( <?= $cotizacion['id'] ?>, <?= $cotizacion['inmueble_id'] ?>, <?= $cliente['Cliente']['id']?> )">
                                                        <i class="fa fa-envelope-o fa-lg"></i>
                                                    </span>

                                                </td>
                                                <td style="text-align:center">
                                                    <?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'cotizacions','action' => 'delete', $cotizacion['id'], $cliente['Cliente']['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar esta cotización', $cotizacion['id']))); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- Operaciones de propiedades -->
        <div class="row">
            <div class="col-sm-12 mt-1">
                <?= $this->Element('Desarrollos/operaciones', array('operaciones' => $cliente['MisOperaciones'])) ?>
            </div>
        </div>
        
        <!-- Listado de facturas -->
        <div class="row mt-1 finanzas">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-blue-is">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                Listado de facturas
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm" id="facturas">
                                    <thead style="background: #E3E3E3;">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Referencia</th>
                                            <th>Concepto</th>
                                            <th>Fecha de emision</th>
                                            <th>Sub total</th>
                                            <th>Iva</th>
                                            <th>Total</th>
                                            <th>Estatus</th>
                                            <th>Pagar</th>
                                            <!-- <th>Ver detalle</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cliente['Facturas'] as $facturas): ?>
                                            <tr>
                                                <td><?= $facturas['folio'] ?></td>
                                                <td><?= $this->Html->link($facturas['referencia'], array('controller'=>'facturas', 'action'=>'view', $facturas['id']), array('style'=>'text-decoration: underline;')) ?></td>
                                                <td><?= $facturas['concepto'] ?></td>
                                                <td><?= $facturas['fecha_emision'] ?></td>
                                                <td><?= '$'.number_format($facturas['subtotal']) ?></td>
                                                <td><?= $facturas['iva'].'%' ?></td>
                                                <td><?= '$'.number_format($facturas['total']) ?></td>
                                                <td><?= $status_factura[$facturas['estado']] ?></td>
                                                <td class="text-sm-center">
                                                    <?php if ($facturas['estado'] == 0 || $facturas['estado'] == 4): ?>
                                                        <?= $this->Html->link('<i class="fa fa-money fa-lg"></i>', array('controller'=>'aportacions', 'action'=>'pagos_factura', $facturas['id']), array('escape'=>false)); ?>
                                                    <?php endif ?>
                                                </td>
                                                <!-- <td><?= $this->Html->link('Ver más', array('controller'=>'facturas', 'action'=>'view', $facturas['id']), array('style'=>'text-decoration: underline;')) ?></td> -->
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php 
    echo $this->Html->script([
        
        // Data tables
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/chosen/js/chosen.jquery',
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',

    ], array('inline'=>false));
?>
<script>

    'use strict';

    // Función para la seleccion de opciones del seguimiento rápido.
    function seleccion_opcion( id, mensaje ) {
        
        // Valor del campo seleccionado
        if( $("#seleccion-opcion-"+id).val() == 1 ) { // Mandamos a para Eliminar el seguimiento
            
            document.getElementById("modal-seguimiento-titulo").innerHTML = 'Borrado de seguimiento rápido';
            $("#seguimeinto-eliminar").css("display", "block");
            $("#seguimeinto-edicion").css("display", "none");
            $("#agendaEliminarIdSeguimiento").val(id);
            $("#modalSeguimeinto").modal('show');

        }else if( $("#seleccion-opcion-"+id).val() == 2 ) { // Mandamos para la edición del evento.

            document.getElementById("modal-seguimiento-titulo").innerHTML = 'Edición de seguimiento rápido <small class ="text-light">(Máximo 250 caracteres.)</small> ';
            $("#seguimeinto-eliminar").css("display", "none");
            $("#seguimeinto-edicion").css("display", "block");
            $("#agendaEdicionIdSeguimiento").val(id);
            $("#agendaEdicionMensaje").val(mensaje);
            
            $("#modalSeguimeinto").modal('show');
        }
    }

    function pago(id){
        $("#modal_pago_factura").modal('show');
    };

    function calTotal(){
        var sub = $('#FacturaSubtotal').val();
        var iva = $('#FacturaIva').val();
        $('#FacturaTotal').val(Math.round(sub*(1+'.'+iva)));
        $('#FacturaTotal2').val(Math.round(sub*(1+'.'+iva)));
    };

    function status_select_input(){
        var val1 = $('#select_status').val();
        
        if (val1 == 'Inactivo temporal') {
            $('#row_motivo_2').fadeOut();
            $('#row_motivo').fadeIn();
            $('#row_calendario').fadeIn();
            $('#StatusMotivo').prop('required',true);
            $('#StatusMotivo2').prop('required',false);
            $('#StatusRecordatorioReactivacion').prop('required', true );

            
        }else if(val1 == 'Inactivo') {
            $('#row_motivo').fadeOut();
            $('#row_calendario').fadeOut();
            $('#row_motivo_2').fadeIn();
            $('#StatusMotivo2').prop('required',true);
            $('#StatusMotivo').prop('required',false);
            $('#StatusRecordatorioReactivacion').prop('required', false );
            // alert('Hola como estas');
            
        }
        else {
            $('#row_motivo').fadeOut();
            $('#row_calendario').fadeOut();
        }
    };

    function otro_motivo(){
        var val1 = $('#StatusMotivo').val();
        if (val1 == 'Otra') {
            $('#row_Otromotivo').fadeIn();
        }else{
            $('#row_Otromotivo').fadeOut();
        }
    };

    function validar2(){
        if (document.getElementById('EventRecordatorio1').value!=""){
            document.getElementById('recordatorio2').style.display="";
        }else{
            document.getElementById('recordatorio2').style.display="none";
        }
    };

    function showEdit(){
        $("#form_temp").fadeIn();
    };

    function showEditEstatus(){
        $("#form_status_hiden").fadeIn();
    };

    function hideEditEstatus(){
        $("#btn_hide_status").fadeIn();
    };

    function validaCiudades(){
        var estado = document.getElementById('ClienteEstadoProspeccion').value;
        $('#ClienteCiudadProspeccion').empty().append('<option value="">Sin Información</option>');
        $('#ClienteColoniaProspeccion').empty().append('<option value="">Sin Información</option>');
        $('#ClienteCiudadProspeccion,#ClienteColoniaProspeccion').trigger("chosen:updated");
        if (estado) {
            var dataString = 'estado='+ estado;
            $.ajax({
                type: "POST",
                url: '<?= Router::url(array("controller" => "clientes", "action" => "getCiudades")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    $.each(html, function(key, value) {              
                        $('<option>').val('').text('select');
                        $('<option>').val(key).text(value).appendTo($("#ClienteCiudadProspeccion"));
                        $('#ClienteCiudadProspeccion').trigger("chosen:updated");
                    });
                } 
            });
        }
    }

    function validaMunicipios(){
        var estado = document.getElementById('ClienteEstadoProspeccion').value;
        var ciudad = document.getElementById('ClienteCiudadProspeccion').value;
        $('#ClienteColoniaProspeccion').empty().append('<option value="">Sin Información</option>');
        $('#ClienteColoniaProspeccion').trigger("chosen:updated");
        if (estado) {
            var dataString = 'estado='+ estado +"&ciudad="+ciudad;
            $.ajax({
                type: "POST",
                url: '<?= Router::url(array("controller" => "clientes", "action" => "getColonias")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    $.each(html, function(key, value) {              
                        $('<option>').val('').text('select');
                        $('<option>').val(key).text(value).appendTo($("#ClienteColoniaProspeccion"));
                        $('#ClienteColoniaProspeccion').trigger("chosen:updated");
                    });
                } 
            });
        }
    }

    function validaCiudades2(){
        editaForma(1);
        var estado = document.getElementById('ClienteEstadoProspeccion2').value;
        $('#ClienteCiudadProspeccion2').empty().append('<option value="">Sin Información</option>');
        $('#ClienteColoniaProspeccion2').empty().append('<option value="">Sin Información</option>');
        $('#ClienteCiudadProspeccion2,#ClienteColoniaProspeccion2').trigger("chosen:updated");
        if (estado) {
            var dataString = 'estado='+ estado;
            $.ajax({
                type: "POST",
                url: '<?= Router::url(array("controller" => "clientes", "action" => "getCiudades")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    $.each(html, function(key, value) {              
                        $('<option>').val('').text('select');
                        $('<option>').val(key).text(value).appendTo($("#ClienteCiudadProspeccion2"));
                        $('#ClienteCiudadProspeccion2').trigger("chosen:updated");
                    });
                } 
            });
        }
    }

    function validaMunicipios2(){
        editaForma(1);
        var estado = document.getElementById('ClienteEstadoProspeccion2').value;
        var ciudad = document.getElementById('ClienteCiudadProspeccion2').value;
        $('#ClienteColoniaProspeccion2').empty().append('<option value="">Sin Información</option>');
        $('#ClienteColoniaProspeccion2').trigger("chosen:updated");
        if (estado) {
            var dataString = 'estado='+ estado +"&ciudad="+ciudad;
            $.ajax({
                type: "POST",
                url: '<?= Router::url(array("controller" => "clientes", "action" => "getColonias")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    $.each(html, function(key, value) {              
                        $('<option>').val('').text('select');
                        $('<option>').val(key).text(value).appendTo($("#ClienteColoniaProspeccion2"));
                        $('#ClienteColoniaProspeccion2').trigger("chosen:updated");
                    });
                } 
            });
        }
    }

    function editaForma(cambia){
        document.getElementById('cambiaForma').value = cambia;
    }

    // Submit del modal de seguimiento rápido.
    $("#agendaEdicionEditForm").bind("submit",function( ev ){
        $("#modalSeguimeinto").modal("hide");
        $("#agendaEdicionEditForm").submit();
		ev.preventDefault();
	});

    $("#agendaEliminarDeleteForm").bind("submit",function( ev ){
        $("#modalSeguimeinto").modal("hide");
        $("#agendaEliminarDeleteForm").submit();
		ev.preventDefault();
	});

    var table1 = $('#compras').DataTable({
        dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        orderCellsTop: true,
        autoWidth: true,
        columnDefs: [
            {targets: 0, width: '40px'},
        ],
        language: {
            sSearch: "Buscador",
            lengthMenu: '_MENU_ registros por página',
            info: 'Mostrando _TOTAL_ registro(s)',
            infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
            emptyTable: "Sin información",
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            },
            infoEmpty:      "0 registros",
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                class : 'excel',
                className: 'btn-secondary',
                charset: 'utf-8',
                bom: true
            },
            {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                className: 'btn-secondary',
            },
        ]
    });

    // Duplicar el encabezado de la tabla Facturas para la busqueda por columna
    $('#facturas thead tr').clone(true).appendTo( '#facturas thead' );
        $('#facturas thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if (table2.column(i).search() !== this.value ) {
                    table2
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

    var table2 = $('#facturas').DataTable({
        dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        orderCellsTop: true,
        autoWidth: true,
        columnDefs: [
            {targets: 0, width: '40px'},
        ],
        language: {
            sSearch: "Buscador",
            lengthMenu: '_MENU_ registros por página',
            info: 'Mostrando _TOTAL_ registro(s)',
            infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
            emptyTable: "Sin información",
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            },
            infoEmpty:      "0 registros",
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                class : 'excel',
                className: 'btn-secondary',
                charset: 'utf-8',
                bom: true
            },
            {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                className: 'btn-secondary',
            },
        ]
    });

    var table3 = $('#desarrollos').DataTable({
        dom: "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        orderCellsTop: true,
        ordering: false,
        autoWidth: true,
        columnDefs: [
            {targets: 0, width: '40px'},
        ],
        language: {
            sSearch: "Buscador",
            lengthMenu: '_MENU_ registros por página',
            info: 'Mostrando _TOTAL_ registro(s)',
            infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
            emptyTable: "Sin información",
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            },
            infoEmpty:      "0 registros",
        },
        lengthMenu: [[3, 10, 25, 50, -1], [3, 10, 25, 50, "Todos"]],
    });

    var table3 = $('#propiedades').DataTable({
        dom: "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        orderCellsTop: true,
        ordering: false,
        autoWidth: true,
        columnDefs: [
            {targets: 0, width: '40px'},
        ],
        language: {
            sSearch: "Buscador",
            lengthMenu: '_MENU_ registros por página',
            info: 'Mostrando _TOTAL_ registro(s)',
            infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
            emptyTable: "Sin información",
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            },
            infoEmpty:      "0 registros",
        },
        lengthMenu: [[3, 10, 25, 50, -1], [3, 10, 25, 50, "Todos"]],
    });

    // Metodo para el cambio de agente comercial del cliente.
    function submitClienteReasignarForm(){
        let flag = true;

        // Validacion de formulario
        if($("#ClienteAsesorId").val() == '' ){
            flag = false;
            if( !document.body.contains(document.getElementById("errorAgente")) ) {
                $( "#ClienteAsesorId_chosen" ).after( $("<span id='errorAgente' class='mt-1' style='color: #EF6F60; display: inline-block;'>Favor de seleccionar una opción</span>"));
            }
        }else{
            flag = true;
            if( document.body.contains(document.getElementById("errorAgente")) ) {
                document.getElementById("errorAgente").remove();
            }
        }

        if($("#ClienteMotivo").val() == '' ){
            flag = false;
            if( !document.body.contains(document.getElementById("errorMotivo")) ) {
                $( "#ClienteMotivo_chosen" ).after( $("<span id='errorMotivo' class='mt-1' style='color: #EF6F60; display: inline-block;'>Favor de seleccionar una opción</span>"));
            }
        }else{
            flag = true;
            if( document.body.contains(document.getElementById("errorMotivo")) ) {
                document.getElementById("errorMotivo").remove();
            }
        }

        if( flag == true ){
            $('#changeOfAdviser').modal('hide');
            $('#ClienteReasignarForm').submit();
        }

    }

    function show_tool_tip(id){
        if( id == 1){
            $('#show_tip_'+id).html(' <?= $cliente['Cliente']['estado_prospeccion']?> / <?= $cliente['Cliente']['ciudad_prospeccion']?> / <?= $cliente['Cliente']['colonia_prospeccion']?> / <?= $cliente['Cliente']['zona_prospeccion']?> <small onclick="hide_tool_tip(1)">(Mostrar menos...)</samll>');
        }else if( id == 2){
            $('#show_tip_'+id).html('<?= $cliente['Cliente']['amenidades_prospeccion'] ?> <small onclick="hide_tool_tip(2)">(Mostrar menos...)</samll>');
        }
        $('#show_tip_'+id).addClass('tool_tip_all');
    }

    function hide_tool_tip( id ){
        if( id == 1){
            $('#show_tip_'+id).html('<?= substr($cliente['Cliente']['estado_prospeccion'], 0, 50) ?> <small onclick="show_tool_tip(1)">(Mostrar mas...)</samll>');
        }else if( id == 2){
            $('#show_tip_'+id).html('<?= substr($cliente['Cliente']['amenidades_prospeccion'], 0, 50) ?> <small onclick="show_tool_tip(2)">(Mostrar mas...)</samll>');
        }
        $('#show_tip_'+id).removeClass('tool_tip_all');
    }

    $("#btn-LeadDesarrollos").on('click', function(){
        $('#LeadDesarrolloId').empty().append('<option selected="selected" value="">Seleccione una opción</option>');

        $.ajax({
            type    : "POST",
            url     : '<?php echo Router::url(array("controller" => "desarrollos", "action" => "list_desarrollos_for_lead")); ?>',
            cache   : false,
            dataType: 'Json',
            success : function ( response ) {

                $.each(response, function(key, value) {              
                    $('<option>').val('').text('select');
                    $('<option>').val(key).text(value).appendTo($("#LeadDesarrolloId"));
                });

                $('.chzn-select').trigger('chosen:updated');
            },
        });
        
        $('#modalLeadDesarrollos').modal('show');
    });

    function like_cotizacion( idCotizacion, inmuebleId ){
        $("#validacion_asesor").modal("show");
        // $("#ValidacionCotizacionInmuebleId").val(inmuebleId);
        $("#ValidacionCotizacionCotizacionId").val(idCotizacion);

    }

    // Funcion para asignar las variables de la cotizacion y abrir el modal 
    function open_send_cotizacion_email( cotizacionId, inmuebleId, clienteId ){
        $("#sendEmailCotizacion").modal('show');
        
        $("#CotizacionSendCotizacionId").val(cotizacionId);
        $("#CotizacionSendInmuebleId").val(inmuebleId);
        $("#CotizacionSendClienteId").val(clienteId);

    }

    // Submit del modal de envio de cotizacion por email
    $(document).on("submit", "#fValidateCotizacion", function (event) {
        event.preventDefault();

        $.ajax({
            type    : "POST",
            url     : '<?php echo Router::url(array("controller" => "cotizacions", "action" => "validacion_asesor")); ?>',
            cache   : false,
            data    : { cotizacion_id: $('#ValidacionCotizacionCotizacionId').val(), cliente_id: <?= $cliente['Cliente']['id'] ?> },
            dataType: 'json',
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                
                location.reload();
                $("#overlay").fadeOut();

            },
            error: function ( response ) {
                console.log( response.responseText );
            }
        });


    });

    function submitFormShareCotizacionEmail(){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "cotizacions", "action" => "share_cotizacion_email")); ?>',
            cache: false,
            data       : { cotizacion_id: $('#CotizacionSendCotizacionId').val(), inmueble_id: $('#CotizacionSendInmuebleId').val(), cliente_id: $('#CotizacionSendClienteId').val() },
            dataType: 'json',
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                $("#sendEmailCotizacion").modal('hide');
                location.reload();
                $("#overlay").fadeOut();

            },
            error: function ( response ) {

                console.log( response );

            }
        });

    }

    function alertEtapa( message ){
        $("#modal_success").modal('show');
        $("#m_success").html( message );
    }

    

</script>
