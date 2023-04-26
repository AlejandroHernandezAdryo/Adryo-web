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

            // Upload archiv
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
                      
        ),
        array('inline'=>false)
    );
?>
<style>
.kv-fileinput-caption{
    height: 29px;
}
</style>
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block mt-3">
                            <div class="row">
                                <div class="col-sm-12 col-lg-4">
                                    <section>
                                        <p>
                                            <?= $venta['Cliente']['nombre'] ?>
                                            <br>
                                            <?= $venta['Cliente']['correo_electronico'] ?>
                                            <br>
                                            <?= $venta['Cliente']['telefono1'] ?>
                                        </p>
                                    </section>
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <section>
                                        <p>
                                            <?= $venta['Inmueble']['referencia'] ?>
                                            <br>
                                            <?= $venta['Inmueble']['titulo'] ?>
                                        </p>
                                    </section>
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <section class="float-lg-right">
                                        <p>
                                            Precio de cierre: <?= number_format($venta['Venta']['precio_cerrado'], 2) ?>
                                        </p>
                                    </section>
                                </div>
                            </div>
                            <!-- Información cliente, Inmueble, Venta -->
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $this->Form->create('Factura', array('type'=>'file')); ?>
                                    <?= $this->Form->hidden('precio', array('value'=>$venta['Venta']['precio_cerrado'])); ?>
                                    <?= $this->Form->hidden('cliente_id', array('value'=>$venta['Cliente']['id'])); ?>
                                    <?= $this->Form->hidden('referencia', array('value'=>$venta['Inmueble']['titulo'])); ?>
                                    <?= $this->Form->hidden('inmueble_id', array('value'=>$venta['Inmueble']['id'])); ?>
                                        <div class="row">
                                            <?= $this->Form->input('cliente_id_view', array('class'=>'form-control', 'label'=>'Cliente', 'value'=>$venta['Cliente']['nombre'], 'div'=>'col-sm-12', 'type'=>'text', 'disabled'=>true)); ?>
                                        </div>
                                        <div class="row mt-1">
                                            <?= $this->Form->input('apartado', array('label'=>'Monto de Apartado','class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'onchange'=>'calculo();', 'value'=>0, 'type'=>'number', 'min'=>0.0, 'step'=>0.01)); ?>
                                            <?= $this->Form->input('tipo_monto', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'type'=>'select'/*, 'empty'=>array('0'=>'Selecciona una opción')*/, 'options'=>$opciones_tipo_monto, 'onchange'=>'calculo();')); ?>
                                            <?= $this->Form->input('fecha_apartado', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-3')); ?>
                                            <?= $this->Form->input('total_apartado', array('class'=>'form-control ', 'div'=>'col-sm-12 col-lg-3', 'disabled'=>true, 'style'=>'text-align: right;', 'value'=>0, 'type'=>'number', 'min'=>0.0)); ?>
                                            <?= $this->Form->hidden('hidden_total_apartado'); ?>
                                            
                                        </div>
                                        <div class="row mt-1">
                                            <?= $this->Form->input('contrato', array('label'=>'Monto de Contrato','class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'onchange'=>'calculo();', 'value'=>0, 'type'=>'number', 'min'=>0.0,'step'=>0.01)); ?>
                                            <?= $this->Form->input('tipo_monto_2', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'type'=>'select'/*, 'empty'=>array('0'=>'Selecciona una opción')*/, 'options'=>$opciones_tipo_monto, 'label'=>'Tipo de monto', 'onchange'=>'calculo();')); ?>
                                            <?= $this->Form->input('fecha_contrato', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-3')); ?>
                                            <?= $this->Form->input('total_contrato', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'disabled'=>true, 'style'=>'text-align: right;', 'value'=>0, 'type'=>'number', 'min'=>0.0)); ?>
                                            <?= $this->Form->hidden('hidden_total_contrato'); ?>
                                            
                                        </div>
                                        <?php 
                                            $estilo = "";
                                            $activo = 1;
                                            for ($i=0; $i<30; $i++){
                                                if ($i>0){
                                                    $estilo = "display:none";
                                                    $activo = 0;
                                                } 
                                        ?>
                                                <div class="row mt-1" id ="fila<?=$i?>" style="<?= $estilo?>">
                                                    <?= $this->Form->input('aportacion'.$i, array('label'=>'Monto de Mensualidad','class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'onchange'=>'calculo();', 'value'=>0, 'type'=>'number', 'min'=>0.0, 'step'=>0.01)); ?>
                                                    <?= $this->Form->input('mensualidades'.$i, array('label'=>'Número de Mensualidades','class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'onchange'=>'calculo();','type'=>'number','min'=>0.0, 'max'=>30)); ?>
                                                    <?= $this->Form->input('fecha_aportacion'.$i, array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-3','label'=>'Fecha de primera mensualidad')); ?>
                                                    <?= $this->Form->input('total_aportacion'.$i, array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'disabled'=>true, 'style'=>'text-align: right;', 'value'=>0, 'type'=>'number', 'min'=>0.0, 'label'=>$this->Html->link('Total por Mensualidades <i class="fa fa-plus"></i>',"javascript:showNext(".($i+1).")",array('escape'=>false)))); ?>
                                                    <?= $this->Form->hidden('hidden_total_aportacion'.$i); ?>
                                                    <?= $this->Form->hidden('activo'.$i,array('value'=>$activo,'id'=>'activo'.$i)); ?>
                                                </div>
                                            <?php }?>
                                        <div class="row mt-1">
                                            <?= $this->Form->input('escrituracion', array('label'=>'Monto de Escrituración','class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'onchange'=>'calculo();', 'value'=>0, 'type'=>'number', 'min'=>0.0, 'step'=>0.01)); ?>
                                            <?= $this->Form->input('tipo_escrituracion', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'type'=>'select'/*, 'empty'=>array('0'=>'Selecciona una opción')*/, 'options'=>$opciones_tipo_monto, 'onchange'=>'calculo();')); ?>
                                            <?= $this->Form->input('fecha_escrituracion', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-3')); ?>
                                            <?= $this->Form->input('total_escrituracion', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-3', 'disabled'=>true, 'style'=>'text-align: right;', 'value'=>0, 'type'=>'number', 'min'=>0.0)); ?>
                                            <?= $this->Form->hidden('hidden_total_escrituracion'); ?>
                                            
                                        </div>
                                        <div class="row mt-1">
                                            <?= $this->Form->input('gran_total', array('label'=>'Total Aportado','class'=>'form-control', 'div'=>'push-lg-9 col-sm-12 col-lg-3', 'disabled'=>true, 'style'=>'text-align: right;', 'value'=>0)); ?>
                                            
                                        </div>
                                        <div class="row mt-1">
                                            <?= $this->Form->input('por_aportar', array('label'=>'Restante','class'=>'form-control', 'div'=>'push-lg-9 col-sm-12 col-lg-3', 'disabled'=>true, 'style'=>'text-align: right;', 'value'=>0)); ?>
                                        </div>
                                        <div class="row mt-1" id="div_submit" style="display:none">
                                            <div class="col-sm-12">
                                                <?= $this->Form->submit('Guardar facturas', array('class'=>'btn btn-success btn-block'));  ?>
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

        // Files
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';

function showNext(row){
    document.getElementById("fila"+row).style.display="";
    document.getElementById("activo"+row).value=1;
}

function calculo_1(){
    //alert (document.getElementById('activo0').value);
    var aportado = 0;
    var total_mensualidades = 0;
    for (var i=0;i<1;i++){
        if ($("#activo"+i).val()==="1"){
            //alert(document.getElementById('activo0').value);
            //document.getElementById('FacturaTotalAportacion'+i).value = 123;
            $("#FacturaTotalAportacion"+i).val($("#FacturaAportacion"+i).val()*$("#FacturaMensualidades"+i).val());
            aportado = parseFloat(aportado) + parseFloat($("#FacturaTotalAportacion"+i).val($("#FacturaAportacion"+i).val()*$("#FacturaMensualidades"+i).val()));
            $("#FacturaHiddenTotalAportacion"+i).val($("#FacturaAportacion"+i).val()*$("#FacturaMensualidades"+i).val());
            total_mensualidades = parseFloat($("#FacturaHiddenTotalAportacion0"+i).val());
        }
    }
}

function calculo(){
    var total = parseFloat(<?= $venta['Venta']['precio_cerrado']?>);
    var aportado = 0;
    if ($("#FacturaTipoMonto").val() == 2) {
        $("#FacturaTotalApartado").val(($("#FacturaApartado").val()/100)*$("#FacturaPrecio").val());
        $("#FacturaHiddenTotalApartado").val(($("#FacturaApartado").val()/100)*$("#FacturaPrecio").val());
        aportado = parseFloat(aportado) + parseFloat($("#FacturaHiddenTotalApartado").val(($("#FacturaApartado").val()/100)*$("#FacturaPrecio").val()));
    }else{
        $("#FacturaTotalApartado").val($("#FacturaApartado").val());
        $("#FacturaHiddenTotalApartado").val($("#FacturaApartado").val());
        aportado = parseFloat(aportado) + parseFloat($("#FacturaHiddenTotalApartado").val($("#FacturaApartado").val()));
    }
    if ($("#FacturaTipoMonto2").val() == 2) {
        $("#FacturaTotalContrato").val(($("#FacturaContrato").val()/100)*$("#FacturaPrecio").val());
        $("#FacturaHiddenTotalContrato").val(($("#FacturaContrato").val()/100)*$("#FacturaPrecio").val());
        aportado = parseFloat(aportado) + parseFloat($("#FacturaHiddenTotalContrato").val(($("#FacturaContrato").val()/100)*$("#FacturaPrecio").val()));
    }else{
        $("#FacturaTotalContrato").val($("#FacturaContrato").val());
        $("#FacturaHiddenTotalContrato").val($("#FacturaContrato").val());
        aportado = parseFloat(aportado) + parseFloat($("#FacturaHiddenTotalContrato").val($("#FacturaContrato").val()));
    }
    
    var total_mensualidades = 0;
    for (var i=0;i<30;i++){
        if ($("#activo"+i).val()==="1"){
            //alert(document.getElementById('activo0').value);
            //document.getElementById('FacturaTotalAportacion'+i).value = 123;
            $("#FacturaTotalAportacion"+i).val($("#FacturaAportacion"+i).val()*$("#FacturaMensualidades"+i).val());
            aportado = parseFloat(aportado) + parseFloat($("#FacturaTotalAportacion"+i).val($("#FacturaAportacion"+i).val()*$("#FacturaMensualidades"+i).val()));
            $("#FacturaHiddenTotalAportacion"+i).val($("#FacturaAportacion"+i).val()*$("#FacturaMensualidades"+i).val());
            total_mensualidades = total_mensualidades + parseFloat($("#FacturaHiddenTotalAportacion"+i).val());
        }
    }
    
    
    
    if ($("#FacturaTipoEscrituracion").val() == 2) {
        $("#FacturaTotalEscrituracion").val(($("#FacturaEscrituracion").val()/100)*$("#FacturaPrecio").val());
        $("#FacturaHiddenTotalEscrituracion").val(($("#FacturaEscrituracion").val()/100)*$("#FacturaPrecio").val());
    }else{
        $("#FacturaTotalEscrituracion").val($("#FacturaEscrituracion").val());
        $("#FacturaHiddenTotalEscrituracion").val($("#FacturaEscrituracion").val());
    }
    var suma = (parseFloat($("#FacturaTotalApartado").val()) + parseFloat($("#FacturaTotalContrato").val()) + parseFloat(total_mensualidades) + parseFloat($("#FacturaTotalEscrituracion").val()));
    $("#FacturaGranTotal").val(suma);
    var por_aportar = total - suma;
//    $("#FacturaEscrituracion").val(por_aportar);
//    $("#FacturaTotalEscrituracion").val($("#FacturaEscrituracion").val());
//    $("#FacturaHiddenTotalEscrituracion").val($("#FacturaEscrituracion").val());
    $("#FacturaPorAportar").val(por_aportar);
    if (por_aportar === 0){
        document.getElementById('div_submit').style.display="";
    }else{
        document.getElementById('div_submit').style.display="none";
    }
        
}
function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}
$(document).ready(function () {
    
    
    $(".input-fa").fileinput({
        // showCaption: false,
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg","pdf"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        showPreview: false,
    });

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