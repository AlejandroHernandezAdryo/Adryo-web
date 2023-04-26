<?php
    $saldoOrigen = $cuentaB['Banco']['saldo_inicial'];
    $saldoOrigen = $saldoOrigen + $deposito[0][0]['SUM(monto)'];
    $saldoOrigen = $saldoOrigen - $retiros[0][0]['SUM(monto)'];

    echo $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',

            // Chozen select
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/fileinput/css/fileinput.min',

        ),
        array('inline'=>false))
?>
<style>
    .text-black{
        color: black;
    }
    .text-center{
        text-align: center;
    }
    .card:hover{
        box-shadow: none;
    }
    .table-mt{
        margin-top: 105rem;
    }
    .chosen-container {
        width: 100% !important;
        display: block;
        height: 30px;
    }
</style>

<div class="modal fade" id="newDesarrolloCta" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-home fa-lg"></i>
                  Agregar desarrollo(s) a cuenta bancaria
              </h4>
          </div>
          <?= $this->Form->create('Banco',array('url'=>array('action'=>'add_desarrollo', $cuentaB['Banco']['id'])))?>
          <?= $this->Form->hidden('redirect', array('value'=>1)) ?>
          <div class="modal-body">
            <div class="row mt-1">
                <?= $this->Form->input('desarrollo_id', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12', 'label'=>'Desarrollos relacionados*', 'type'=>'select', 'options'=>$desarrollos, 'empty'=>'Seleccione una opción', 'multiple'=>true)) ?>
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
          <?= $this->Form->end()?>
      </div>
  </div>
</div>

<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-users"></i>
                    Cuenta bancaria - <?= $cuentaB['Banco']['nombre_cuenta'] ?>
                </h4>
            </div>
            <div class="col-sm-12 col-lg-6">
                <span>
                    <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Regresar a listado', array('controller'=>'bancos', 'action'=>'index'), array('class'=>'text-white float-lg-right', 'escape'=>false)); ?>
                </span>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="height: 500px;" id="informacio_cta">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Información general de la cuenta bancaria.
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <a id="btn-show-input" class="pointer float-lg-right" style="text-decoration: underline;" onclick="editInfo();">EDITAR</a>
                                    <a id="btn-hidden-input" class="pointer float-lg-right input-hidden" style="text-decoration: underline; display: none;" onclick="cancelInfo();">CANCELAR</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-block m-t-35">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $this->Form->create('Banco', array('url'=>array('action'=>'edit', $cuentaB['Banco']['id']))); ?>
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Nombre de la cuenta:</td>
                                                    <td class="text-lg-right">
                                                        <span id="nombre_cuenta" class="label-show"><?= $cuentaB['Banco']['nombre_cuenta'] ?></span>
                                                        <?= $this->Form->input('nombre_cuenta', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'value'=>$cuentaB['Banco']['nombre_cuenta'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Nombre del banco:</td>
                                                    <td class="text-lg-right">
                                                        <span id="nombre_banco" class="label-show"><?= $cuentaB['Banco']['nombre_banco'] ?></span>
                                                        <?= $this->Form->input('nombre_banco', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'value'=>$cuentaB['Banco']['nombre_banco'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tipo de cuenta:</td>
                                                    <td class="text-lg-right">
                                                        <span id="tipo" class="label-show"><?= $tipo_cuenta[$cuentaB['Banco']['tipo']] ?></span>
                                                        <?= $this->Form->input('tipo', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'type'=>'select', 'options'=>$tipo_cuenta, 'empty'=>'Seleccione un tipo de cuenta', 'value'=>$cuentaB['Banco']['tipo'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Numero de cuenta:</td>
                                                    <td class="text-lg-right">
                                                        <span id="numero_cuenta" class="label-show"><?= $cuentaB['Banco']['numero_cuenta'] ?></span>
                                                        <?= $this->Form->input('numero_cuenta', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'value'=>$cuentaB['Banco']['numero_cuenta'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Clabe:</td>
                                                    <td class="text-lg-right">
                                                        <span id="clabe" class="label-show"><?= $cuentaB['Banco']['clabe'] ?></span>
                                                        <?= $this->Form->input('clabe', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'maxlength'=>30,'value'=>$cuentaB['Banco']['clabe'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Titular:</td>
                                                    <td class="text-lg-right">
                                                        <span id="titular" class="label-show"><?= $cuentaB['Banco']['titular'] ?></span>
                                                        <?= $this->Form->input('titular', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'value'=>$cuentaB['Banco']['titular'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dirección</td>
                                                    <td class="text-lg-right">
                                                        <span id="direccion" class="label-show">
                                                            <?= ($cuentaB['Banco']['direccion'] != '' ? $cuentaB['Banco']['direccion'] : '
                                                        "Sin dirección"') ?>
                                                        </span>
                                                        <?= $this->Form->input('direccion', array('class'=>'form-control form-control-sm', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'maxlength'=>200,'value'=>$cuentaB['Banco']['direccion'])) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Saldo inicial</td>
                                                    <td class="text-lg-right">
                                                        <span id="saldo_inicial" class="label-show"><?= '$'.number_format($cuentaB['Banco']['saldo_inicial'],2) ?></span>
                                                        <?= $this->Form->input('saldo_inicial', array('class'=>'form-control form-control-sm number', 'label'=>false, 'div'=>false, 'style'=>'display:none;', 'value'=>$cuentaB['Banco']['saldo_inicial'], 'disabled'=>true)) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Saldo actual</td>
                                                    <td class="text-lg-right">
                                                        <span id="saldo_actual" class="label-show">
                                                        
                                                        
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr id="tr-submit" style="display: none;">
                                                    <td colspan="2">
                                                        <button class="btn btn-success btn-block mt-1" type="submit">
                                                            Actualizar información
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->Form->end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta para desarrollos seleccionados -->
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Desarrollos seleccionados
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <button class="btn btn-success btn-sm float-lg-right" data-toggle="modal" data-target="#newDesarrolloCta" data-toggle='tooltip' data-placement='top' title='Agregar desarrollo(s) a cta'>
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12" style="height: 445px;">
                                    <table class="table table-sm mt-2" style="border:1px solid silver">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center">Desarrollo</th>
                                                <th style="text-align:center">Desvincular</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentaB['Desarrollo'] as $desarrollo): ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $this->Html->link($desarrollo['nombre'], array('action'=>'view', 'controller'=>'desarrollos', $desarrollo['id'])) ?></td>
                                                    <td style="text-align:center"><?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', array('controller'=>'bancos','action' => 'desvincular', $cuentaB['Banco']['id'],$desarrollo['id']), array('escape'=>false, 'confirm'=>__('Desea desvincular este desarrollo de la cuenta?', $desarrollo['nombre']))); ?></td>
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
            <!-- ./Fin row de informacion y desarrollos -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mt-2">
                        <div class="card-header bg-blue-is">
                            Lista de transacciones
                        </div>
                        <div class="card-block" style="margin-top: 5rem;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-sm" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>Referencia</th>
                                                <th>Fecha de transferencia</th>
                                                <th>Tipo de transacción</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentaB['Transaccions'] as $transferencia): ?>
                                                <tr>
                                                    <td><?= $transferencia['referencia'] ?></td>
                                                    <td><?= $transferencia['fecha'] ?></td>
                                                    <td><?= $tipos_transaccion[$transferencia['tipo_transaccion']] ?></td>
                                                    <td class="text-sm-right"><?= '$'.number_format($transferencia['monto']) ?></td>
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

        // Chossen
        '/vendors/chosen/js/chosen.jquery',
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function editInfo(){
    // mostramos el boton para cancelar la edicion
    $("#btn-hidden-input").css("display", "block");
    $("#btn-show-input").css("display", "none");

    // mostraremos los inputs
    $("#BancoNombreCuenta").css("display", "block");
    $("#nombre_cuenta").css("display", "none");

    $("#BancoNombreBanco").css("display", "block");
    $("#nombre_banco").css("display", "none");

    $("#BancoTipo").css("display", "block");
    $("#tipo").css("display", "none");

    $("#BancoNumeroCuenta").css("display", "block");
    $("#numero_cuenta").css("display", "none");

    $("#BancoClabe").css("display", "block");
    $("#clabe").css("display", "none");

    $("#BancoTitular").css("display", "block");
    $("#titular").css("display", "none");

    $("#BancoDireccion").css("display", "block");
    $("#direccion").css("display", "none");

    $("#BancoSaldoInicial").css("display", "block");
    $("#saldo_inicial").css("display", "none");

    $("#tr-submit").css("display", "block");

}

function cancelInfo(){
    // mostramos el boton para cancelar la edicion
    $("#btn-hidden-input").css("display", "none");
    $("#btn-show-input").css("display", "block");

    // mostraremos los inputs
    $("#BancoNombreCuenta").css("display", "none");
    $("#nombre_cuenta").css("display", "block");

    $("#BancoNombreBanco").css("display", "none");
    $("#nombre_banco").css("display", "block");

    $("#BancoTipo").css("display", "none");
    $("#tipo").css("display", "block");

    $("#BancoNumeroCuenta").css("display", "none");
    $("#numero_cuenta").css("display", "block");

    $("#BancoClabe").css("display", "none");
    $("#clabe").css("display", "block");

    $("#BancoTitular").css("display", "none");
    $("#titular").css("display", "block");

    $("#BancoDireccion").css("display", "none");
    $("#direccion").css("display", "block");

    $("#BancoSaldoInicial").css("display", "none");
    $("#saldo_inicial").css("display", "block");

    $("#tr-submit").css("display", "none");

}

function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}
$(document).ready(function () {
    document.getElementById("saldo_actual").innerHTML = "$<?= number_format($saldoOrigen,2) ?>";

    // format de numero para campo
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

    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    $('[data-toggle="popover"]').popover()

});
    
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
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
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