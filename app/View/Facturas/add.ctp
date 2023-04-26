<?php 
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

            // Calendario
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            'pages/colorpicker_hack',
                      
        ),
        array('inline'=>false)
    );
?>

<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-plus"></i>
                    Agregar nuevo gasto
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-block m-t-35">
                    <?= $this->Form->create('Factura') ?>
                    <?= $this->Form->hidden('ruta', array('value'=>1)) ?>
                    <div class="row mt-1">
                        <?= $this->Form->input('proveedor_id', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Proveedor*', 'class'=>'form-control chzn-select', 'empty'=>'Seleccione una opción', 'required'=>true, 'options'=>$proveedors)) ?>
                        <?= $this->Form->input('desarrollo_id', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Desarrollo', 'class'=>'form-control chzn-select', 'empty'=>'Sin desarrollo', 'options'=>$desarrollos)) ?>
                        <?= $this->Form->input('categoria_id', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Categoria', 'class'=>'form-control chzn-select', 'empty'=>'Seleccione una opción', 'options'=>$categorias)) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('folio', array('div'=>'col-sm-12 col-lg-6', 'label'=>'Folio', 'class'=>'form-control')) ?>
                        <?= $this->Form->input('referencia', array('div'=>'col-sm-12 col-lg-6', 'label'=>'Referencia*', 'class'=>'form-control', 'required'=>true)) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('fecha_emision', array('div'=>'col-sm-12 col-lg-6', 'label'=>'Fecha de emision*', 'class'=>'form-control fecha', 'type'=>'text', 'required'=>true)) ?>
                        <?= $this->Form->input('fecha_pago', array('div'=>'col-sm-12 col-lg-6', 'label'=>'Fecha de pago', 'class'=>'form-control fecha', 'type'=>'text')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('concepto', array('div'=>'col-sm-12 col-lg-12', 'label'=>'Concepto*', 'class'=>'form-control', 'type'=>'textarea', 'required'=>true)) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('subtotal', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Subtotal*', 'class'=>'form-control', 'required'=>true)) ?>
                        <?= $this->Form->input('iva', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Iva*', 'class'=>'form-control', 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>array(0=>'0%', 10=>'10%', 16=>'16%'), 'onchange'=>'calTotal();', 'required'=>true)) ?>
                        <?= $this->Form->input('total', array('div'=>'col-sm-12 col-lg-4', 'label'=>'Total*', 'class'=>'form-control', 'required'=>true)) ?>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <?= $this->Form->submit('Crear factura', array('class'=>'btn btn-success btn-block')) ?>
                        </div>
                    </div>
                    <?= $this->Form->end()?>
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

        // Calendario
        '/vendors/moment/js/moment.min',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
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

function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}
$(document).ready(function () {

    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });    
    
    
    $('[data-toggle="popover"]').popover()

});
</script>