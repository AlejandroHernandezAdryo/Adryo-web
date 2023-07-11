<?= $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',

            // Chozen select
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/fileinput/css/fileinput.min',

            // Calendario
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            'pages/colorpicker_hack',
                      
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

<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-calendar"></i>
                    Plan de pagos para venta
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-blue-is">
                  <?= $venta['Venta']['tipo_operacion'].": ".$venta['Inmueble']['referencia']?>
                    <div style="float:right">
                        <?= $this->Html->link('<i class="fa fa-file-o fa-lg"></i>',array('action'=>'estado_cuenta',$venta['Venta']['id']),array('escape'=>false,'style'=>'color:white','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Ver Estado de Cuenta'))?>
                    </div>
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                             <table class="table table-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td>Nombre de Cliente:</td>
                                                                <td class="text-lg-left">
                                                                    <?= $venta['Cliente']['nombre']?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Inmueble Comprado:</td>
                                                                <td class="text-lg-left">
                                                                    <?= $venta['Inmueble']['referencia']?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Precio Cerrado:</td>
                                                                <td class="text-lg-left">
                                                                    <?= "$".number_format($venta['Venta']['precio_cerrado'],2)?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Saldo:</td>
                                                                <td class="text-lg-left">
                                                                    <?= "$".number_format($venta['Venta']['precio_cerrado']-$pagos[0][0]['SUM(monto)'],2)?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Fecha de cierre de venta:</td>
                                                                <td class="text-lg-left">
                                                                    <?= date("d/M/Y",strtotime($venta['Venta']['fecha']))?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Asesor que cierra la venta:</td>
                                                                <td class="text-lg-left">
                                                                   <?= $venta['User']['nombre_completo']?>
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
</div>
    <div class="outer m-t-15">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-blue-is">
                  Plan de pagos
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                             <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-40">
                            <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Fecha de pago</th>
                                <th>Total</th>
                                <th>Estatus</th>
                                <th>Rechazar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($aportaciones as $factura): ?>
                                    <tr>
                                        <td><?= $this->Html->link($factura['Factura']['referencia'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 1), array('style'=>'text-decoration: underline')); ?></td>
                                        <td><?= $factura['Factura']['fecha_emision'] ?></td>
                                        <td class="text-xs-right"><?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                        <td><?= $status_factura[$factura['Factura']['estado']] ?></td>
                                        <td class="text-sm-center">
                                            <?php if ($factura['Factura']['estado'] != 2 && $factura['Factura']['estado'] != 5): ?>
                                                <a class="pointer" onclick="rechazarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Rechazar factura"><i class="fa fa-close"></i></a>
                                            <?php endif ?>
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
</div>
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',
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

        // Calendario
        '/vendors/moment/js/moment.min',
        '/vendors/datepicker/js/bootstrap-datepicker.min',

        // Chosen select
        // 'pages/form_elements',
        '/vendors/chosen/js/chosen.jquery',
        // 'form',


        
    ], array('inline'=>false));
?>

<script>
    
'use strict';

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
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'Proveedores',
                class : 'excel',
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'Proveedores',
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
            
        }
    };
}();
</script>