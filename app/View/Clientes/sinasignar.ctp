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
                            <i class="fa fa-users"></i>
                            Lista de clientes sin asignar
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                        <div class="card-block m-t-35">
                            <div class="card-block p-t-25">
                                <div class="">
                                            <div class="pull-sm-right">
                                                <div class="tools pull-sm-right"></div>
                                            </div>
                                    
                                        </div>
                                <div style="float:right">
                                <a  href="#" class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-search fa-1x"></i>Búsqueda Avanzada
                                        </a>    
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="table_Usersin" class="m-t-35">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Inmueble / Desarrollo Interesado</th>
                                        <th>Correo Electrónico</th>
                                        <th>Teléfono</th>
                                        <th>Tipo de Cliente</th>
                                        <th>Estatus</th>
                                        <th>Etapa</th>
                                        <th>Fecha de Creación</th>
                                        <th>Eliminar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $temp = array(1=>'Frio',2=>'Tibio',3=>'Caliente')?>
                                    <?php foreach ($clientes as $cliente):?>

                                    <tr>
                                    <td ><?php echo $this->Html->link($cliente['Cliente']['nombre'], array('action'=>'asignar', $cliente['Cliente']['id']))?></td>
                                    <td>
                                        
                                    <?php
                                        echo $cliente['Inmueble']['titulo']."".$cliente['Desarrollo']['nombre'];
//                                    ?>
                                    </td>
                                    <td ><?php echo $cliente['Cliente']['correo_electronico']?></td>
                                    <td ><?php echo substr($cliente['Cliente']['telefono1'], -10) ?></td>
                                    <td ><?php echo $cliente['DicTipoCliente']['tipo_cliente']?></td>
                                    <td ><?php echo $cliente['Cliente']['status']?></td>
                                    <td ><?php echo $cliente['DicEtapa']['etapa']?></td>
                                    <td ><?php echo date_format(date_create($cliente['Cliente']['created']),"Y-m-d")?></td>
                                    <td><?php echo $this->Form->postLink('<i class="fa fa-trash fa-lg"></i>', array('controller' => 'clientes', 'action' => 'delete', $cliente['Cliente']['id'],2), array('escape' => false,'style'=>'color:red'), __('Desea eliminar este cliente?', $cliente['Cliente']['id'],2)); ?></td>
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

        $('#table_Usersin thead tr').clone(true).appendTo( '#table_Usersin thead' );
        $('#table_Usersin thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if (tableCs.column(i).search() !== this.value ) {
                    tableCs
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

    var tableCs = $('#table_Usersin').DataTable({
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
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    filename: 'ClientList',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                    filename: 'ClientList',
                },
            ]
    });
    
    
    
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

<?php $this->Html->scriptEnd();

?>
