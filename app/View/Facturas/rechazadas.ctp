<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
            
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
                      
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
                echo $this->Form->hidden('status', array('value'=>5));
                echo $this->Form->hidden('redirect', array('value'=>0));
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
                    <i class="fa fa-times"></i>
                    Mis Facturas Rechazadas
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12">
                            Facturas Rechazadas
                        </div>
                    </div>
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block p-t-25">
                        <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-35">
                            <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Folio</th>
                                <th>Proveedor</th>
                                <th>Fecha de emision</th>
                                <th>Fecha de pago</th>
                                <th>Concepto</th>
                                <th>Total</th>
                                <th>Estatus</th>
                                <th>Pendiente de Validar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($facturas as $factura): ?>
                                    <tr>
                                        <td><?= $this->Html->link($factura['Factura']['referencia'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 2), array('style'=>'text-decoration: underline')); ?></td>
                                        <td><?= $factura['Factura']['folio'] ?></td>
                                        <td><?= (!empty($proveedores[$factura['Factura']['proveedor_id']]) ? $proveedores[$factura['Factura']['proveedor_id']] : $clientes[$factura['Factura']['cliente_id']]) ?></td>
                                        <td><?= $factura['Factura']['fecha_emision'] ?></td>
                                        <td><?= $factura['Factura']['fecha_pago'] ?></td>
                                        <td>
                                            <?php
                                                if (strlen($factura['Factura']['concepto']) >= 45) {
                                                    echo rtrim(substr($factura['Factura']['concepto'], 0, 45)).'...';
                                                }else {
                                                    echo $factura['Factura']['concepto'];
                                                }
                                            ?>
                                        </td>
                                        <td class="text-xs-right"><?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                        <td><?= $status_factura[$factura['Factura']['estado']] ?></td>
                                        <td><?= $factura['Validador']['nombre_completo']?></td>
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
        
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',


        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function calTotal(){
    var sub = $('#FacturaSubtotal').val();
    $('#FacturaIva').val(Math.round(sub * .16));

    var iva = $('#FacturaIva').val();
    $('#FacturaTotal').val(Math.round(parseFloat(sub) + parseFloat(iva)));
    $('#FacturaTotal2').val(Math.round(parseFloat(sub) + parseFloat(iva)));
};

function calIva(){
    var sub = $('#FacturaSubtotal').val();
    var iva = $('#FacturaIva').val();

    $('#FacturaTotal').val(Math.round(parseFloat(sub) + parseFloat(iva)));
    $('#FacturaTotal2').val(Math.round(parseFloat(sub) + parseFloat(iva)));  
}

function calRet(){
    var sub = $('#FacturaSubtotal').val();
    var iva = $('#FacturaIva').val();
    var retIva = $('#FacturaRetencionIva').val();
    var retIsr = $('#FacturaRetencionIsr').val();

    $('#FacturaTotal').val(Math.round(parseFloat(sub) + parseFloat(iva) - parseFloat(retIva) - parseFloat(retIsr)));
    $('#FacturaTotal2').val(Math.round(parseFloat(sub) + parseFloat(iva)- parseFloat(retIva) - parseFloat(retIsr)));  
}

function rechazarFac(id){
    $("#modal_status_factura").modal('show')
    document.getElementById("FacturaId").value = id;
    // console.log('rechazar factura con el id '+id);
}
$(document).ready(function () {
    
    $("#desarrollo").on('change',function() {
        var desarrollo_id = $(this).val();
        //$("#categoria").find('option').remove();
        $("#categoria").empty();
        if (desarrollo_id) {
            var dataString = 'desarrollo_id='+ desarrollo_id;
            var newOption = $('<option value="1">test</option>');
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "facturas", "action" => "getValidaciones")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    $.each(html, function(key, value) {              
                            $('<option>').val('').text('select');
                            $('<option>').val(key).text(value).appendTo($("#categoria"));
                    });
                      
                      $('#categoria').trigger("chosen:updated");
                } 
            });
        }
    });

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });

    $('.fechaNoFutura').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom",
        maxDate:0,
    });
    
    $("#input-fa").fileinput({
        theme: "fa",
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
    });

    $('textarea').each(function () {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

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