<?php 
    echo $this->Html->css(
        array(
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
                    <i class="fa fa-edit"></i>
                    Editar Factura
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-block">
                    <?= $this->Form->create('Factura', array('type'=>'file')) ?>
                    <?= $this->Form->hidden('total') ?>
                    <?= $this->Form->hidden('id',array('value'=>$factura['Factura']['id'])) ?>
                    <?= $this->Form->hidden('ruta',array('value'=>5)) ?>
            
                <div class="row mt-1">
                    <?= $this->Form->input('proveedor_id', array('class'=>'form-control', 'id'=>'proveedor_id','div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Seleccione un proveedor', 'options'=>$proveedores, 'label'=>'Lista de proveedores* '.$this->Html->link('<i class="fa fa-plus"></i>',array('controller'=>'proveedors','action'=>'index'),array('escape'=>false)), 'name'=>'data[Factura][proveedor_id]', 'required'=>true)) ?>
                </div>
                <div class="row mt-1">
                <?php 
                    $tipo_gasto =array(
                        'Factura'=>'Factura',
                        'Requisición de Pago'=>'Requisición de Pago',
                        'Reembolso de Gasto'=>'Reembolso de Gasto',
                        'Pago de Servicios'=>'Pago de Servicios',
                    );
                ?>
                <?= $this->Form->input('tipo_gasto', array('id'=>'tipo_gasto','class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'options'=>$tipo_gasto, 'label'=>'Tipo de Gasto*', 'required'=>true)) ?>
                </div>
                <div Class="row mt-1">
                    <?= $this->Form->input('desarrollo_id', array('id'=>'desarrollo','class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Ningun desarrollo', 'options'=>$desarrollos, 'label'=>'Desarrollo al que pertenece el gasto')) ?>
                </div>
                <div Class="row mt-1">
                    <?= $this->Form->input('categoria_id', array('id'=>'categoria','class'=>'form-control', 'div'=>'col-sm-12', 'empty'=>'Seleccionar una validación', 'options'=>$categorias, 'label'=>'Validación de Factura')) ?>
                </div>
                
                <div class="row mt-1">
                    <?= $this->Form->input('referencia', array('value'=>$factura['Factura']['referencia'],'class'=>'form-control', 'div'=>'col-sm-12 col-lg-6','label'=>'Serie y Folio')) ?>
                    <?= $this->Form->input('folio', array('value'=>$factura['Factura']['folio'],'id'=>'folio','class'=>'form-control', 'div'=>'col-sm-12 col-lg-6','label'=>'Folio Fiscal','maxlength'=>36)) ?>
                    <div class="error" id="mensaje_error_div" style="display:none">Factura ya registrada</div>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('fecha_emision', array('value'=>$factura['Factura']['fecha_emision'],'class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text', 'data-date-end-date'=>'0d')) ?>
                    <?= $this->Form->input('fecha_pago', array('value'=>$factura['Factura']['fecha_pago'],'class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text')) ?>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('concepto', array('value'=>$factura['Factura']['concepto'],'class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'textarea', 'rows'=>'2', 'maxlength'=>'200')) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-6">
                        <?= $this->Form->input('subtotal', array('value'=>$factura['Factura']['subtotal'],'div'=>false, 'label'=>'Subtotal*', 'class'=>'form-control', 'required'=>true, )) ?>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?php $iva = array('1'=>'0%','1.1'=>'10%','1.16'=>'16%') ?>
                        <?= $this->Form->input('iva', array('div'=>false, 'type'=>'select','options'=>$iva,'label'=>'IVA*', 'empty'=>'Seleccioar Tasa de IVA','class'=>'form-control', 'onchange'=>'calIva();', 'required'=>true)) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <?= $this->Form->input('retencion_iva', array('value'=>$factura['Factura']['retencion_iva'],'div'=>false, 'label'=>'Retención IVA', 'onchange'=>'calRet();','class'=>'form-control' )) ?>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $this->Form->input('retencion_isr', array('value'=>$factura['Factura']['retencion_isr'],'div'=>false, 'label'=>'Retención ISR', 'onchange'=>'calRet();', 'class'=>'form-control' )) ?>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <?= $this->Form->input('total_2', array('div'=>false, 'label'=>'Total a pagar*', 'class'=>'form-control', 'disabled'=>true)) ?>
                    </div>
                </div>
                <div class="row mt-2">
                        <div class="col-sm-12">
                            <?= $this->Form->submit('Realizar Cambios', array('class'=>'btn btn-success btn-block')) ?>
                        </div>
                    </div>
            </div>
        </div>
        
        <?= $this->Form->end() ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    echo $this->Html->script([
        'components',
        'custom',

        // Calendario
        '/vendors/moment/js/moment.min',
        '/vendors/datepicker/js/bootstrap-datepicker.min',

        // Chosen select
        // 'pages/form_elements',
        '/vendors/chosen/js/chosen.jquery',
        // 'form',

        
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
    

    $('#FacturaTotal').val(Math.round(parseFloat(sub) * parseFloat(iva)));
    $('#FacturaTotal2').val(Math.round(parseFloat(sub) * parseFloat(iva)));  
}

function calRet(){
    var sub = $('#FacturaSubtotal').val();
    var iva = $('#FacturaIva').val();
    var retIva = $('#FacturaRetencionIva').val();
    var retIsr = $('#FacturaRetencionIsr').val();

    $('#FacturaTotal').val(Math.round(parseFloat(sub) + parseFloat(iva) - parseFloat(retIva) - parseFloat(retIsr)));
    $('#FacturaTotal2').val(Math.round(parseFloat(sub) + parseFloat(iva)- parseFloat(retIva) - parseFloat(retIsr)));  
}

$(document).ready(function () {

    //Set Chosen
    $("#proveedor_id,#desarrollo,#categoria,#tipo_gasto").chosen();
    $("#proveedor_id").val(<?= $factura['Proveedor']['id']?>);
    $("#desarrollo").val(<?= $factura['Desarrollo']['id']?>);
    $("#categoria").val(<?= $factura['Categoria']['id']?>);
    $("#tipo_gasto").val('<?= $factura['Factura']['tipo_gasto']?>');
    $("#proveedor_id,#desarrollo,#categoria,#tipo_gasto").trigger("chosen:updated");
    
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

    $("#folio").on('change',function() {
        var folio = $(this).val();
        if (folio) {
            var dataString = 'folio='+ folio;
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "facturas", "action" => "getFolio")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    if (html.respuesta==1){
                        $("#mensaje_error_div").show();
                        $("#boton_submit").hide();   
                    }else{
                        $("#mensaje_error_div").hide();
                        $("#boton_submit").show();
                    }
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
    
    

    $('[data-toggle="popover"]').popover()

});

</script>