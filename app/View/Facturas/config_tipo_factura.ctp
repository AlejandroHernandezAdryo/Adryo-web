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
                      
        ),
        array('inline'=>false))
?>
<style>
    .chosen-container{
      width: 100% !important;
      top: -5px;
      /*height: 24px;*/
    }
    .chosen-single, .chosen-container{
      height: calc(2.5rem - 2px);
    }
</style>
<div class="modal fade" id="modal_nuevo_punto" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('ValidacionCategoria') ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal5" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    Agregar nuevo revisor
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?= $this->Form->input('user_id', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-6', 'label'=>'Usuario*', 'empty'=>'Seleccione una opción', 'options'=>$usuarios)); ?>
                    <?= $this->Form->input('estado', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6', 'label'=>'Estado*', 'empty'=>'Seleccione una opción', 'options'=>$estados, 'type'=>'select', 'onchange'=>'showmonto()')); ?>
                </div>
                <div class="row mt-1" id="input-monto-maximo" style='display:none'>
                    <?= $this->Form->input('monto_maximo', array('class'=>'form-control', 'div'=>'col-sm-12', 'label'=>'Monto máximo')); ?>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('orden', array('class'=>'form-control', 'div'=>'col-sm-12', 'label'=>'Orden*')); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar revisor
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
                    Configuración de permisos de categoria <?= $this->Html->link($categoria['Categoria']['nombre'], array('controller'=>'users', 'action'=>'diccionarios_config'), array('style'=>'color: white; text-decoration: underline;')) ?>
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $this->Html->link('Agregar nuevo punto', '#',array('class'=>'btn btn-success text-white float-lg-right', 'data-toggle'=>'modal', 'data-target'=>'#modal_nuevo_punto')) ?>
                        </div>
                    </div>
                </div>
                <div class="card-block mt-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm dataTablesAi">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Estado de factura</th>
                                        <th>A partir del moto</th>
                                        <th>Orden</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categoria['ValidacionCategoria'] as $validacion):?>
                                        <tr>
                                            <td><?php echo $usuarios[$validacion['user_id']]; ?></td>
                                            <td><?php echo $estados[$validacion['estado']]; ?></td>
                                            <td><?php echo "$".number_format($validacion['monto_maximo'],2); ?></td>
                                            <td><?php echo $validacion['orden']; ?></td>
                                            <td><i class="fa fa-trash"></i></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Tabla de puntos de revisión de facturas -->
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

        // Chosen
        '/vendors/chosen/js/chosen.jquery',
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function showmonto(){
    if (document.getElementById('ValidacionCategoriaEstado').value == 2){
       document.getElementById('input-monto-maximo').style.display='';
    }else{
        document.getElementById('input-monto-maximo').style.display='none';
    }
}

$(document).ready(function () {

    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();

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
        var table = $('.dataTablesAi');
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