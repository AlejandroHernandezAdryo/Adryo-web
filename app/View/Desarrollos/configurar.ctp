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
                            <i class="fa fa-building"></i>
                           Configurar Desarrollo: <?= $desarrollo['Desarrollo']['nombre']?>
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-block m-t-35">
                        <div class="card-block p-t-25">
                            <div class="pull-sm-right">
                                                <div class="tools pull-sm-right"></div>
                                            </div>
                            <div style="float:right">
                                <a  href="#" class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus fa-1x"></i>Cargar Categoria
                                        </a>    
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Categoria</th>
                                        <th>Configurar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($desarrollo['Categoria'] as $categoria):?>           
                                            <tr>
                                                <td><?php echo h($categoria['id']); ?>&nbsp;</td>
                                                <td><?php echo h($categoria['nombre']); ?>&nbsp;</td>
                                                <td><?php echo $this->Html->link('<i class="fa fa-cog"></i>', array('controller'=>'proyectos','action' => 'edit_permisos', $categoria['id']),array('escape'=>false)); ?></td>
                                                <td><?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', array('controller'=>'categorias','action' => 'delete', $categoria['id']), array('escape'=>false,'confirm' => __('Are you sure you want to delete # %s?', $categoria['id']))); ?></td>
                                            </tr>
                                            <?php endforeach;?>    
                                        </tbody>
                                </table>
                        </div>
                        </div>
                    </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel1" style="color:black">
                                        <i class="fa fa-search"></i>
                                        Crear Categoria
                                    </h4>
                                </div>
                                <?= $this->Form->create('Desarrollo')?>
                                <?= $this->Form->hidden('id',array('value'=>$desarrollo['Desarrollo']['id']))?>
                                <div class="modal-body">
                                    <div class="input-group">
                                        <div class="col-xl-3 text-xl-left m-t-15">
                                            <label for="nombre_cliente" class="form-control-label">Categoria</label>
                                        </div>
                                        <?= $this->Form->input('categoria',array('class'=>'form-control','placeholder'=>'Nombre Categoria','div'=>'col-md-9 m-t-15','label'=>false,))?>
                                        
                                        
                                        <!-- /btn-group -->
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                                        Cerrar
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                                        <i class="fa fa-search"></i>
                                        Crear Categoria
                                    </button>
                                </div>
                                <?= $this->Form->end()?>
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




