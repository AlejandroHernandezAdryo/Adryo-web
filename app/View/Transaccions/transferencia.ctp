<?php 
echo $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',

            // Calendario
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            'pages/colorpicker_hack',

            // Chozen select
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/fileinput/css/fileinput.min',

            // Upload archiv
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
                      
        ),
        array('inline'=>false))
?>
<style>
.btn-group{
    margin: 0px 2px 0px 2px;
}
.chosen-container {
    width: 100% !important;
    display: block;
    height: 30px;
}
.kv-fileinput-caption{
    height: 29px;
}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
    <?= $this->Form->create('Transaccion', array('url'=>array('action'=>'interna_transaccion', 'controller'=>'transaccions'), 'type'=>'file')) ?>
      <div class="modal-content">
        <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar transferencia interna
              </h4>
          </div>
        <div class="modal-body">
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Cuenta origen*') ?>
                    </div>
                    <?= $this->Form->input('cuenta_origen', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'type'=>'select', 'options'=>$cuentas)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Cuenta destino*') ?>
                    </div>
                    <?= $this->Form->input('cuenta_destino', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'type'=>'select', 'options'=>$cuentas)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Referencia*') ?>
                    </div>
                    <?= $this->Form->input('referencia', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Fecha*') ?>
                    </div>
                    <?= $this->Form->input('fecha', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'type'=>'text', 'placeholder'=>'dd-mm-YYYY')) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('monto*') ?>
                    </div>
                    <?= $this->Form->input('monto', array('class'=>'form-control number', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'min'=>'00.1', 'type'=>'text', 'step'=>'0.01')) ?>
                </div>
                
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
              </button>
              <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar
              </button>
          </div>
        <?= $this->Form->end() ?>
      </div>
  </div>
</div>

<div class="modal fade" id="manual-transfer" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
    <?= $this->Form->create('Transaccion', array('url'=>array('action'=>'manual_transaccion', 'controller'=>'transaccions'), 'type'=>'file')) ?>
    <?= $this->Form->hidden('redirect', array('value'=>1)) ?>
      <div class="modal-content">
        <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar transferencia manual
              </h4>
          </div>
        <div class="modal-body">
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Cuenta origen*') ?>
                    </div>
                    <?= $this->Form->input('nombre_banco', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'value'=>$banco['Banco']['nombre_cuenta'] ,'label'=>false,'disabled'=>'disabled')) ?>
                    <?= $this->Form->hidden('cuenta_bancaria_id', array('value'=>$banco['Banco']['id'])) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Tipo de transacción') ?>
                    </div>
                    <?= $this->Form->input('tipo_transaccion', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>$manual_transaccion)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Referencia*') ?>
                    </div>
                    <?= $this->Form->input('referencia', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Fecha*') ?>
                    </div>
                    <?= $this->Form->input('fecha', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'type'=>'text', 'placeholder'=>'dd-mm-YYYY')) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('monto*') ?>
                    </div>
                    <?= $this->Form->input('monto', array('class'=>'form-control number', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false,'type'=>'tel')) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <label for="documento de pago">Documento(s) de transferencia</label>
                        <input name="data[Transaccion][archivos][]" type="file" class="file-loading input-fa" accept=".pdf, .jpg, .png" multiple>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
              </button>
              <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar
              </button>
          </div>
        <?= $this->Form->end() ?>
      </div>
  </div>
</div>


<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-users"></i>
                    Transacciones<?= (isset($banco)? ":".$this->Html->link($banco['Banco']['nombre_cuenta'],array('controller'=>'bancos','action'=>'view',$banco['Banco']['id']),array('style'=>'color:white')) : "")?>
                </h4>
            </div>
            <div class="col-sm-12 col-lg-6">
                <button class="btn btn-success float-right btn-group" data-toggle="modal" data-target="#myModal">
                    Realizar Transferencia Interna
                </button>
                <button class="btn btn-primary float-right btn-group" data-toggle="modal" data-target="#manual-transfer">
                    Movimiento manual
                </button>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-block m-t-35">
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Referencia</th>
                                        <th>Depósito</th>
                                        <th>Retiro</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $saldo = $banco['Banco']['saldo_inicial']?>
                                    <?php foreach ($transaccions as $transaccion): ?>
                                        <tr>
                                            <td><?= date('Y-m-d', strtotime($transaccion['Transaccion']['fecha'])) ?></td>
                                            <td><?= $transaccion['Transaccion']['referencia'] ?></td>
                                            <?php
                                                switch($transaccion['Transaccion']['tipo_transaccion']):
                                                    case(1):
                                                        echo "<td>".'$ '.number_format($transaccion['Transaccion']['monto'])."</td><td></td>";
                                                        $saldo += $transaccion['Transaccion']['monto'];
                                                        break;
                                                    case(2):
                                                        echo "<td></td><td>".'$ '.number_format($transaccion['Transaccion']['monto'])."</td>";
                                                        $saldo -= $transaccion['Transaccion']['monto'];
                                                        break;
                                                endswitch;
                                            ?>
                                            <td class="text-xs-right"><?= '$ '.number_format($saldo) ?></td>
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

        // Chosen
        '/vendors/chosen/js/chosen.jquery',

        // Input de archivo
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',

    ], array('inline'=>false));
?>

<script>
    
'use strict';
$(document).ready(function () {

    // Input para el numero.
    $(".number").on({
          "focus": function(event) {
            $(event.target).select();
          },
          "keyup": function(event) {
            $(event.target).val(function(index, value) {
              return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{0})$/, '$1')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
          }
    });

    $('[data-toggle="popover"]').popover();

    $(".input-fa").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg","pdf"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
    });

    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
});

function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}

var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
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
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
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