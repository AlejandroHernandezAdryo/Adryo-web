<?php
echo $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
                      
        ),
        array('inline'=>false));
?>
<style>
    .text-white{
        color: white;
    }
</style>
<!-- Modal para eliminar proveedor -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar nueva cuenta bancaria
              </h4>
            </div>
            <?= $this->Form->create('Banco',array('url'=>array('action'=>'add', 'controller'=>'bancos')))?>
            <?= $this->Form->hidden('redirect', array('value'=>2)) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Nombre de la cuenta*') ?>
                    </div>
                    <?= $this->Form->input('nombre_cuenta', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Tipo de la cuenta') ?>
                    </div>
                    <?= $this->Form->input('tipo', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'type'=>'select', 'options'=>$tipo_cuenta, 'empty'=>'Seleccione un tipo de cuenta')) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Nombre del Banco*') ?>
                    </div>
                    <?= $this->Form->input('nombre_banco', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'style'=>'text-transform: uppercase;')) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Numero de cuenta*') ?>
                    </div>
                    <?= $this->Form->input('numero_cuenta', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Clabe*') ?>
                    </div>
                    <?= $this->Form->input('clabe', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Titular') ?>
                    </div>
                    <?= $this->Form->input('titular', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Direccion*') ?>
                    </div>
                    <?= $this->Form->input('direccion', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('saldo inicial*') ?>
                    </div>
                    <?= $this->Form->input('saldo_inicial', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-4">
                        <?= $this->Form->label('Estatus*') ?>
                    </div>
                    <?= $this->Form->input('status', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'type'=>'select', 'options'=>$status, 'empty'=>'Seleccione una opción')) ?>
                </div>
                    <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollo']['id'], 'name'=>'data[Banco][desarrollo_id][0]')) ?>
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
<!-- Modal para agregar nueva categoria -->
<div class="modal fade" id="nueva_categoria">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar nueva categoria
              </h4>
            </div>
            <?= $this->Form->create('Categoria',array('url'=>array('action'=>'add', 'controller'=>'categorias')))?>
            <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollo']['id'])) ?>
            <?= $this->Form->hidden( 'redirectTo', array('value' => 1) ) ?>
            <div class="modal-body">
                <div class="row">
                    <?= $this->Form->input('nombre', array('class'=>'form-control', 'div'=>'col-sm-12','label'=>'Nombre categoria*', 'required'=>true)) ?>
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
                    <i class="fa fa-cogs"></i>
                    Configuración de finanzas <?= $this->Html->link($desarrollo['Desarrollo']['nombre'], array('action'=>'view', 'controller'=>'desarrollos', $desarrollo['Desarrollo']['id']), array('style'=>'color: white !important; text-decoration: underline;')) ?>
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    Cuentas bancarias
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <button class="btn btn-success float-right btn-labeled" data-toggle="modal" data-target="#myModal">
                                        Agregar nueva cuenta bancaria.
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 mt-1">
                                    <table class="table table-sm dataTablesL">
                                        <thead>
                                            <tr>
                                                <th>Tipo de Cta</th>
                                                <th>Desarrollo/inmeuble</th>
                                                <th>Nombre de Cta</th>
                                                <th>Cta relacionada</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuenta_ban_desarrollo as $cuenta): ?>
                                                <tr>
                                                    <td><?= $tipo_cuenta[$cuenta['CuentasBancarias']['tipo']] ?></td>
                                                    <td><?= $cuenta['Desarrollo']['nombre'] ?></td>
                                                    <td><?= $cuenta['CuentasBancarias']['nombre_cuenta'] ?></td>
                                                    <td><?= $cuenta['CuentasBancarias']['numero_cuenta'] ?></td>
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
            
            <!-- Asignación de categoria para facturas -->
            <div class="row mt-2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    Categorias para facturas
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <button class="btn btn-success float-right btn-labeled" data-toggle="modal" data-target="#nueva_categoria">
                                        Agregar nueva categoria.
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 mt-1">
                                    <table class="table table-sm dataTablesL">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Categoria</th>
                                                <th>Configurar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($desarrollo['Categoria'] as $categorias): ?>
                                                <tr>
                                                    <td><?= $categorias['id'] ?></td>
                                                    <td><?= $categorias['nombre'] ?></td>
                                                    <td>
                                                        <?= $this->Html->link('<i class="fa fa-cogs"></i>',array('controller'=>'facturas','action'=>'permisos_usuarios',$categorias['id'], $desarrollo['Desarrollo']['id']),array('escape'=>false)); ?>
                                                    </td>
                                                    <td><i class="fa fa-trash"></i></td>
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
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}
$(document).ready(function () {

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    
    
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        return false;
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        return false;
    });
    
    $('[data-toggle="popover"]').popover()

});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('.dataTablesL');
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