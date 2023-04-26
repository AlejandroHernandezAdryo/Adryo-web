<?= $this->Html->css(
        array(
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
            
            
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
            '/vendors/clockpicker/css/jquery-clockpicker',
            'css/pages/colorpicker_hack'
            //'pages/form_elements'
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Lista de clientes
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                        <div class="card-header bg-white">
                            <i class="fa fa-home"> </i> Clientes Registrados sin agente asignado
                        </div>
                        <div class="card-block">
                            <div class="m-t-35">
                                 <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                                    <thead>
                                    <tr>
                        <th><?php echo $this->Paginator->sort('nombre'); ?></th>
                        <th><?php echo "Corretaje/Desarrollos"; ?></th>
                      	<th><?php echo $this->Paginator->sort('correo_electronico'); ?></th>
                      	<th ><?php echo $this->Paginator->sort('telefono1'); ?></th>
                      	<th ><?php echo $this->Paginator->sort('tipo_cliente'); ?></th>
                      	<th ><?php echo $this->Paginator->sort('status'); ?></th>
                      	<th ><?php echo $this->Paginator->sort('etapa'); ?></th>
                        <th ><?php echo $this->Paginator->sort('created','Fecha de Creación'); ?></th>
                        <?php if ($this->Session->read('Auth.User.Group.ce')){?>
                      	<th ><?php echo "Asignar" ?></th>
                        <?php } ?>
                        <?php if ($this->Session->read('Auth.User.Group.cd')){?>
                      	<th ><?php echo "Eliminar" ?></th>
                        <?php } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $temp = array(1=>'Frio',2=>'Tibio',3=>'Caliente')?>
                                    <?php foreach ($clientes as $cliente):?>
                                    
                                    <tr>
                                        <td style="text-transform: uppercase"><?php echo $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'asignar',$cliente['Cliente']['id']))?></td>
                                        <td style="text-transform: uppercase">
                                            <?php
                                                $texto = "";
                                                if (isset($cliente['Lead'][0]['inmueble_id'])){
                                                    $texto = $texto."Corretaje ";
                                                }
                                                if (isset($cliente['Lead'][0]['desarrollo_id'])){    
                                                    $texto = $texto."Desarrollos ";
                                                }
                                                echo $texto;
                                            ?>
                                        </td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['correo_electronico']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['telefono1']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['DicTipoCliente']['tipo_cliente']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['status']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['DicEtapa']['etapa']?></td>
                    <td style="text-transform: uppercase"><?php echo date_format(date_create($cliente['Cliente']['created']),"d-M-Y")?></td>
                    <?php if ($this->Session->read('Auth.User.Group.ce')){?>
                    <td style="text-transform: uppercase"><?php echo $this->Html->link('<i class="fa fa-user"></i>', array('action'=>'asignar', $cliente['Cliente']['id']), array('escape'=>false,'target'=>'_blank'))?></td>
                    <?php } ?>
                    <?php if ($this->Session->read('Auth.User.Group.cd')){?>
                    <td style="text-transform: uppercase">
                    <?php echo $this->Form->postLink('<i class ="fa fa-trash"></i>', array('action' => 'delete', $cliente['Cliente']['id']), array('escape'=>false), __('Deseas eliminar al cliente?', $cliente['Cliente']['id'])); ?>
                    </td>
                    <?php } ?>
                                    </tr>
                                    <?php endforeach;?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        </div>
    </div>

</div>

<?php 
    echo $this->Html->script([
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
        /*'/vendors/datatables/js/dataTables.colReorder.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/datatable',*/
//        'pages/advanced_tables'
    ], array('inline'=>false));
?>
                        <?php

$this->Html->scriptStart(array('inline' => false));

?>

'use strict';
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
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'ClientList',
                class : 'excel',
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'ClientList',
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

<?php $this->Html->scriptEnd();

?>
