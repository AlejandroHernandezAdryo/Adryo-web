<?= $this->Html->css(
    array(
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        '/vendors/datatables/css/scroller.bootstrap.min',
        'pages/tables',
        '/vendors/select2/css/select2.min',
        
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/datepicker/css/bootstrap-datepicker.min',

        // Chozen select
        '/vendors/chosen/css/chosen',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/fileinput/css/fileinput.min',
        // Calendario
      '/vendors/inputlimiter/css/jquery.inputlimiter',
      '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
      '/vendors/jquery-tagsinput/css/jquery.tagsinput',
      '/vendors/daterangepicker/css/daterangepicker',
      '/vendors/datepicker/css/bootstrap-datepicker.min',
      '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
      '/vendors/bootstrap-switch/css/bootstrap-switch.min',
      '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
      '/vendors/j_timepicker/css/jquery.timepicker',
      '/vendors/datetimepicker/css/DateTimePicker.min',


                    
    ),
    array('inline'=>false))
?>
<style>
    textarea{
        overflow:hidden;
        display:block;
        min-height: 30px;
    }
    .chosen-container {
        width: 100% !important;
        display: block;
        height: 30px;
    }
</style>
<!-- Estatus factura (cancelación)  **Korner 02-05-2023** -->
<div class="modal fade" id="modal_status_factura">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center" style="color: black;">
                        ¿ Estas seguro de rechazar esta factura ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('Factura', array('url'=>array('controller'=>'facturas', 'action'=>'status')));
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('estado', array('value'=>5));
                echo $this->Form->hidden('redirect', array('value'=>0));
                echo $this->Form->hidden('venta_id', array('value'=>$venta['Venta']['id']));
            ?>
            <div class="row">
                <?= $this->Form->input('comentario', array('class'=>'form-control', 'div'=>'col-sm-12', 'required'=>true, 'label'=>'Motivo de Rechazo*', 'type'=>'textarea', 'rows' => '1', 'data-min-rows' => '1')); ?>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>
<!-- Editar factura  **Korner 02-05-2023** -->
<div class="modal fade" id="modal_edit_factura">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Resgistra el pago
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="" style="color: black;">
                            En caso de que el monto sea mayor a la mensualidad selecciona <b>otro monto</b> e ingresa la cantidad.
                        </h3>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="custom-control custom-radio col-sm-12 col-md-6">
                        <input type="radio" id="pago_mes_fijo" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="pago_mes_fijo">Monto mensual</label>
                        <br>
                        <p style="padding-left:8px;"><b>Texto</b></p>
                    </div>
                    <div class="custom-control custom-radio col-sm-12 col-md-6 float-right" style="margin-left:0 !important;">
                        <input type="radio" id="pago_monto_mayor" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="">Otro monto</label>
                        <br>
                        <input type="number" name="" for="pago_monto_mayor" id="" class="form-control" placeholder="$ Ingresa la cantidad">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-md-6">
                        <p style="margin:0;"><b>Comprobante de pago</b></p>
                        <p>Sólo archivos jpg, png y pdf. Tamaño máximo 5mb</p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="es" required>
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                    </div>
                </div>
                <!-- Form delete cliente -->
                <?php
                    echo $this->Form->create('Factura', array('url'=>array('controller'=>'facturas', 'action'=>'status')));
                    echo $this->Form->hidden('id');
                    echo $this->Form->hidden('estado', array('value'=>5));
                    echo $this->Form->hidden('redirect', array('value'=>0));
                    echo $this->Form->hidden('venta_id', array('value'=>$venta['Venta']['id']));
                ?>
                <!-- <div class="row">
                    <//?= $this->Form->input('comentario', array('class'=>'form-control', 'div'=>'col-sm-12', 'required'=>true, 'label'=>'Motivo de Rechazo*', 'type'=>'textarea', 'rows' => '1', 'data-min-rows' => '1')); ?>
                </div> -->
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Aceptar</button>
                        <button type="button" class="btn btn-primary-o float-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<!-- Subir factura  **Korner 02-05-2023** -->
<div class="modal fade" id="modal_upload_factura">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Resgistra el pago
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="" style="color: black;">
                            En caso de que el monto sea mayor a la mensualidad selecciona <b>otro monto</b> e ingresa la cantidad.
                        </h3>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="custom-control custom-radio col-sm-12 col-md-6">
                        <input type="radio" id="pago_mes_fijo" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label"  for="pago_mes_fijo">Monto mensual</label>
                        <br>
                        <p style="padding-left:8px;" id='apagar_monto'></p>
                        <p style="padding-left:8px;" hidden><span id='id_pago'></span></p>
                    </div>
                    <div class="custom-control custom-radio col-sm-12 col-md-6 float-right" style="margin-left:0 !important;">
                        <input type="radio" id="pago_monto_mayor"  name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="">Otro monto</label>
                        <br>
                        <input type="number" name="" for="pago_monto_mayor"  value="" id="pago_mas" class="form-control" placeholder="$ Ingresa la cantidad">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-md-6">
                        <p style="margin:0;"><b>Comprobante de pago</b></p>
                        <p>Sólo archivos jpg, png y pdf. Tamaño máximo 5mb</p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input"  lang="es" required>
                            <!-- 
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label> -->
                             
                                <input type="file" name="" id="pagoImagen" accept="image/*, .pdf" required="required"> 
                        </div>
                    </div>
                </div>
                <!-- Form delete cliente -->
                <!-- <?php
                    //echo $this->Form->create('LogPago', array('url'=>array('controller'=>'LogPago', 'action'=>'pago_mes_cliente_')));
                    //echo $this->Form->hidden('id');
                ?> -->
                <!-- <div class="row">
                    <//?= $this->Form->input('comentario', array('class'=>'form-control', 'div'=>'col-sm-12', 'required'=>true, 'label'=>'Motivo de Rechazo*', 'type'=>'textarea', 'rows' => '1', 'data-min-rows' => '1')); ?>
                </div> -->
                <div class="row mt-1">
                    <div class="col-sm-12">

                        <button type="button" class="btn btn-primary float-right" onclick="subir()" style="margin-left:8px;">Aceptar</button>
                        <button type="button" class="btn btn-primary-o float-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <!-- <i class="fa fa-calendar"></i>-->
                    Historial y plan de pagos  
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <!-- Información de cliente ** Korner 01-05-1990** -->
            <div class="card mt-1">
                <div class="card-header bg-blue-is">
                    <b><?= $venta['Cliente']['nombre']?></b>
                    <div style="float:right">
                        <?= $this->Html->link('Estado de cuenta',array('action'=>'estado_cuenta',$venta['Venta']['id'],),array('escape'=>false,'class'=>'btn btn-primary','data-toggle'=>'tooltip','data-placement'=>'top'))?>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <b>Propiedad:</b>
                            <br> 
                            <span>
                            <?= $venta['Venta']['tipo_operacion'].": ".$venta['Inmueble']['referencia']?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <b>Fecha de cierre:</b>
                            <br> 
                            <span>
                                <?= date("d/M/Y",strtotime($venta['Venta']['fecha']))?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <b>Asesor cerro venta:</b>
                            <br> 
                            <span>
                            <?= $venta['User']['nombre_completo']?>
                            </span>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-12 col-lg-2">
                            <b>Apartado:</b>
                            <br> 
                            <span>
                                texto
                            <?= $venta['User']['nombre_completo']?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Escrituración:</b>
                            <br> 
                            <span>
                                texto
                            <?= $venta['User']['nombre_completo']?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Contrato:</b>
                            <br> 
                            <span>
                                texto
                                <?= $venta['User']['nombre_completo']?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Mensualidad:</b>
                            <br> 
                            <span>
                                texto
                                <?= $venta['User']['nombre_completo']?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Precio de venta:</b>
                            <br> 
                            <span>
                                <?= "$".number_format($venta['Venta']['precio_cerrado'],2)?>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Saldo:</b>
                            <br> 
                            <span>
                                <?= "$".number_format($venta['Venta']['precio_cerrado']-$pagos[0][0]['SUM(monto)'],2)?>
                            </span>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="row mt-1">
                <div class="col-sm-12 ">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#plan_pagos" data-toggle="tab" onclick="">Plan de pagos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#historial_pagos" data-toggle="tab" onclick="">Historial de pagos</a>
                        </li>
                    </ul>
                    <div class="card">
                        <div id="rootwizard_no_val">
                            <div class="tab-content">
                                <!-- tab plan de pagos -->
                                <div class="tab-pane active" id="plan_pagos">
                                    <div class="row m-t-20">
                                        <div class="col-sm-12">
                                            <div class="card-block">
                                                <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-40">
                                
                                                </table>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tab historial de pagos -->
                                <div class="tab-pane" id="historial_pagos">
                                    <div class="row">
                                        <!-- Estatus de seguimiento **rogue 24-04-2023** -->
                                        <div class="col-sm-12">
                                            <div class="card-block">
                                                <table class="table table-striped table-hover table-sm w-100" id="sample_2" class="m-t-40">
                                                    
                                                </table>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        'components',
        'custom',
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min'
    ], array('inline'=>false));
?>

<script>
    
'use strict';

function editarFac(){
    $("#modal_edit_factura").modal('show')
    document.getElementById("FacturaId").value = id;
}
function uploadFac(){
    $("#modal_upload_factura").modal('show')
    document.getElementById("FacturaId").value = id;
}

function rechazarFac(id){
    $("#modal_status_factura").modal('show')
    document.getElementById("FacturaId").value = id;
    // console.log('rechazar factura con el id '+id);
}
$(document).ready(function () {

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    
    $('[data-toggle="popover"]').popover()

});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[ 4, "desc" ]],
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-download"></i> Descargar',
                filename: 'Proveedores',
                class : 'excel',
                className: 'mt-2 btn btn-secondary-o'
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'Proveedores',
                className: 'mt-2 ml-1 btn btn-secondary-o'
                },
                
                
            ]
        });
        
    }
    var initTable2 = function() {
        var table = $('#sample_2');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[ 4, "desc" ]],
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-download"></i> Descargar',
                filename: 'Proveedores',
                class : 'excel',
                className: 'mt-2 btn btn-secondary-o'
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'Proveedores',
                className: 'mt-2 ml-1 btn btn-secondary-o'
                },
                
                
            ]
        });
        
    }
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
            initTable2();
        }
    };

}();

$(document).ready(function () {
        let cliente_id = '<?= $venta['Cliente']['id'] ?>'
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "LogPagos", "action" => "view_datos_cliente")); ?>",
            data: {api_key: 'adryo', cliente_id, },
            dataType: "Json",
            success: function (res) {
                console.log(res);
            },
            error: function ( response ) {
                console.log('arroja error');
                console.log(response.responseText);
            }
        });

    });
</script>