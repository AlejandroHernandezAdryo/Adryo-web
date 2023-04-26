<?= $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
                      
        ),
        array('inline'=>false))
?>
<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-users"></i>
                    Editar cuenta
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-block m-t-35">
                    <div class="card-block">
                        <div class="row">
                            <?= $this->Form->create('Banco'); ?>
                            <div class="row">
                                <?= $this->Form->input('nombre_cuenta', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-4', 'label'=>'Nombre De La Cuenta*', 'required'=>true, 'value'=>$cuenta['Banco']['nombre_cuenta'])) ?>
                                <?= $this->Form->input('tipo', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-4', 'type'=>'select', 'options'=>$tipo_cuenta, 'empty'=>'Seleccione una opción', 'label'=>'Tipo De La Cuenta', 'value'=>$cuenta['Banco']['tipo'])) ?>
                                <?= $this->Form->input('nombre_banco', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-4', 'label'=>'Nombre Del Banco*', 'required'=>true, 'value'=>$cuenta['Banco']['nombre_banco'])) ?>
                            </div>
                            <div class="row mt-1">
                                <?= $this->Form->input('numero_cuenta', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6', 'label'=>'Numero de la cuenta*', 'required'=>true, 'value'=>$cuenta['Banco']['numero_cuenta'])) ?>
                                <?= $this->Form->input('clabe', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6', 'label'=>'Clabe*', 'required'=>true, 'value'=>$cuenta['Banco']['clabe'])) ?>
                            </div>
                            <div class="row mt-1">
                                <?= $this->Form->input('titular', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-4', 'label'=>'Titular', 'value'=>$cuenta['Banco']['titular'])) ?>
                                <?= $this->Form->input('direccion', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-4', 'label'=>'Dirección', 'required'=>true, 'value'=>$cuenta['Banco']['direccion'])) ?>
                                <?= $this->Form->input('saldo_inicial', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-4', 'label'=>'Saldo inicial*', 'required'=>true, 'value'=>$cuenta['Banco']['saldo_inicial'])) ?>
                            </div>
                            <div class="row mt-1">
                                <?= $this->Form->input('status', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6', 'type'=>'select', 'options'=>$status, 'empty'=>'Seleccione una opción', 'label'=>'Estatus*', 'required'=>true, 'value'=>$cuenta['Banco']['status'])) ?>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-12">
                                    <?= $this->Form->submit('Guardar cambios', array('class'=>'btn btn-success btn-block'))?>
                                </div>
                            </div>
                        <?= $this->Form->end(); ?>
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