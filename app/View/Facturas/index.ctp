
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
    .error{
        width: 100%;
        text-align: center;
        color: red;
    }
    .file-caption{
        height: 30px !important;
    }
    .label-danger{
        background-color: transparent !important;
        color: #ea423e !important;
    }
    .hide{ display: none; }

</style>


<!-- Modal delete -->
<div class="modal fade" id="modal_factura_delete_master">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black">
                        ¿ Esta seguro que desea ELIMINAR esta factura ?
                    </h3>
                </div>
            </div>

            <div class="modal-footer">
              <div class="row">
                  <div class="col-sm-12 col-lg-6">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <button type="button" class="btn btn-success float-right" onclick="submitFormFacturaDeleteMaster();">Aceptar</button>
                  </div>
                  <?= $this->Form->hidden('id', array('id' => 'FacturaId')) ?>
              </div>
            </div>

        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalNewFactura">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-blue-is">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel1">
                Agregar gasto
            </h4>

        </div>

        <?= $this->Form->create('Factura', array('type'=>'file','url'=>array('action'=>'add', 'controller'=>'facturas'))) ?>
        <div class="modal-body">
            <?= $this->Form->hidden('ruta', array('value'=>5)) ?>
            <?= $this->Form->hidden('total') ?>
            <div id="body-factura">
                
                <div class="row mt-1">
                        <div class="col-sm-12">
                            <label class="col-sm-12">
                                <span class="float-xs-right">
                                    <?php
                                        echo $this->Html->link('<i class="fa fa-plus"></i> Agregar proveedor',array('controller'=>'proveedors','action'=>'index'),array('escape'=>false, 'class'=>'btn btn-primary btn-sm'))
                                    ?>
                                </span>
                                <p style="color: #ea423e">
                                    <small>
                                        * Si NO se encuentra el proveedor deseado, favor de agregarlo dando clic al botón de "Agregar proveedor"
                                    </small>
                                </p>
        
                            </label>
                        </div>
                        
                        <?= $this->Form->input('proveedor_id', array('class'=>'form-control required chzn-select', 'div' => 'col-sm-12 col-lg-6', 'type'=>'select', 'empty'=>'Seleccione un proveedor', 'options'=>$proveedores, 'label'=> array( 'text' => 'Lista de proveedores', 'id' => 'FacturaProveedorIdLabel'), 'name'=>'data[Factura][proveedor_id]')) ?>


                        <?= $this->Form->input('tipo_gasto', array('class'=>'form-control required chzn-select', 'div'=>'col-sm-12 col-lg-6', 'type'=>'select', 'options'=>$tipo_gasto, 'label'=>array('text' => 'Tipo de Gasto', 'id' => 'FacturaTipoGastoLabel'), 'empty' => 'Seleccione una opción')) ?>
                </div>

                <div Class="row">
                    <?= $this->Form->input('desarrollo_id', array('id'=>'desarrollo','class'=>'form-control required chzn-select', 'div'=>'col-sm-12 col-lg-6 mt-1', 'type'=>'select', 'empty'=>'Ningún desarrollo', 'options'=>$desarrollos, 'label'=>array('text' => 'Desarrollo al que pertenece el gasto', 'id' => 'FacturaDesarrolloIdLabel'))) ?>
                    
                    <?= $this->Form->input('categoria_id', array('id'=>'categoria','class'=>'form-control required chzn-select', 'div'=>'col-sm-12 col-lg-6 mt-1', 'empty'=>'Seleccionar una categoría', 'options'=>$categorias, 'label'=>array('text' => 'Categoría del gasto', 'id' => 'FacturaCategoriaIdLabel'))) ?>
                </div>
                
                <div class="row mt-1">
                    <?= $this->Form->input('referencia', array('class'=>'form-control required', 'div'=>'col-sm-12 col-lg-6','label'=>array('text' => 'Referencia', 'id' => 'FacturaReferenciaLabel'))) ?>
                    
                    <?= $this->Form->input('folio', array('id'=>'folio','class'=>'form-control', 'div'=>array('class' => 'col-sm-12 col-lg-6', 'id' => 'divFolio'),'label'=>array('text' => 'Folio Fiscal', 'id' => 'FacturaFolioLabel'),'maxlength'=>50)) ?>
                    <div class="error" id="mensaje_error_div" style="display:none">Factura ya registrada</div>

                    <?= $this->Form->input('linea_captura', array('class'=>'form-control', 'div'=>array('class' => 'col-sm-12 col-lg-6 hide', 'id' => 'divLineaCaptura'),'label'=>array('text' => 'Linea de captura', 'id' => 'FacturaLineaCapturaLabel'),'maxlength'=>100)) ?>


                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('fecha_emision', array('class'=>'form-control required fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text', 'data-date-end-date'=>'0d', 'label' => array('text' => 'Fecha de emisión', 'id' => 'FacturaFechaEmisionLabel'))) ?>

                    <?= $this->Form->input('fecha_pago', array('class'=>'form-control required fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text', 'label' => array('text' => 'Fecha probable de pago', 'id' => 'FacturaFechaPagoLabel'))) ?>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('concepto', array('class'=>'form-control required', 'div'=>'col-sm-12', 'type'=>'textarea', 'rows'=>'2', 'maxlength'=>'200', 'label' => array('text' => 'Concepto', 'id' => 'FacturaConceptoLabel'))) ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-3">
                        <?= $this->Form->input('subtotal', array('div'=>false, 'label'=> array('text' => 'Subtotal', 'id' => 'FacturaSubtotalLabel'), 'class'=>'form-control required', )) ?>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <?php $iva = array('1'=>'0%','1.1'=>'10%','1.16'=>'16%') ?>
                        <?= $this->Form->input('iva', array('div'=>false, 'type'=>'select','options'=>$iva,'label'=>array('text' => 'Iva', 'id' => 'FacturaIvaLabel'), 'empty'=>'Seleccionar Tasa de IVA','class'=>'form-control required', 'onchange'=>'calIva();')) ?>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <?= $this->Form->input('retencion_iva', array('div'=>false, 'label'=>array('text' => 'Retención IVA', 'id' => 'FacturaRetencionIvaLabel'), 'onchange'=>'calRet();','class'=>'form-control required' )) ?>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <?= $this->Form->input('retencion_isr', array('div'=>false, 'label'=>array('text' => 'Retención ISR', 'id' => 'FacturaRetencionISRLabel'), 'onchange'=>'calRet();', 'class'=>'form-control required' )) ?>
                    </div>
                    <div class="col-sm-12 col-lg-12 mt-1">
                        <?= $this->Form->input('total_2', array('div'=>false, 'label'=>array('text' => 'Total a pagar', 'id' => 'FacturaTotal2Label'), 'class'=>'form-control required', 'disabled'=>true)) ?>
                    </div>
                </div>
                <div class="row">
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <label for="documento de pago" id="FacturaDocumentoPagoLabel">Documento(s) para gasto</label>
                        <input id="input-upLoadFiles" name="data[Factura][archivos][]" type="file" class="file-loading" multiple>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success float-xs-right" id="boton_submit">
                Agregar gasto
            </button>

            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                Cerrar
            </button>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-chevron-circle-right"></i>
                    Listado de gastos
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
                            <button class="btn btn-success btn-sm float-lg-right" data-toggle="modal" data-target="#modalNewFactura">
                                Agregar gasto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block p-t-25">
                        <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-35">
                            <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Folio / LC </th>
                                <th>Proveedor</th>
                                <th>Fecha de Carga</th>
                                <th>Cargado</th>
                                <th>Fecha de emisión</th>
                                <th>Fecha probable de pago</th>
                                <th>Fecha real de pago</th>
                                <th>Concepto</th>
                                <th>Desarrollo</th>
                                <th>Tipo de Gasto</th>
                                <th>Categoría</th>
                                <th>Total</th>
                                <th>Estatus</th>
                                <th>Pendiente de Validar</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($facturas as $factura): ?>
                                
                                    <?php $referencia = ($factura['Factura']['referencia']==""?"Sin Referencia":$factura['Factura']['referencia'])?>
                                    <tr>
                                        <td><?= $this->Html->link($referencia, array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 2), array('style'=>'text-decoration: underline')); ?></td>
                                        <td><?= $factura['Factura']['folio'].' '. $factura['Factura']['linea_captura'] ?></td>
                                        <td><?= (!empty($proveedores[$factura['Factura']['proveedor_id']]) ? $proveedores[$factura['Factura']['proveedor_id']] : $clientes[$factura['Factura']['cliente_id']]) ?></td>
                                        <td data-sort='<?= $factura['Factura']['created']?>'><?= $factura['Factura']['created']!=""?date("d/M/Y H:i:s",strtotime($factura['Factura']['created'])):"" ?></td>
                                        <td data-search='Cargada por: <?= $factura['Cargado']['nombre_completo']?>'><?= $factura['Cargado']['nombre_completo']?></td>
                                        <td data-sort='<?= $factura['Factura']['fecha_emision']?>'><?= date("d/M/Y",strtotime($factura['Factura']['fecha_emision'])) ?></td>
                                        <td data-sort='<?= $factura['Factura']['fecha_pago']?>'><?= date("d/M/Y",strtotime($factura['Factura']['fecha_pago'])) ?></td>
                                        <td data-sort='<?= ( !empty($factura['Pagos'][0]['fecha']) ? $factura['Pagos'][0]['fecha'] : 'Sin fecha') ?>'>
                                            <?php
                                                $tot_pago = 0;
                                                if( !empty($factura['Pagos'][0]['fecha']) ){
                                                    echo date("d/M/Y",strtotime($factura['Pagos'][0]['fecha']));
                                                }else{
                                                    echo 'Sin fecha';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if (strlen($factura['Factura']['concepto']) >= 45) {
                                                    echo rtrim(substr($factura['Factura']['concepto'], 0, 45)).'...';
                                                }else {
                                                    echo $factura['Factura']['concepto'];
                                                }
                                            ?>
                                        </td>
                                        <td><?= $factura['Desarrollo']['nombre']?></td>
                                        <td><?= $factura['Factura']['tipo_gasto']?></td>
                                        <td><?= $factura['Categoria']['nombre']?></td>
                                        <td class="text-xs-right"><?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                        <td><?= $this->Html->link($status_factura[$factura['Factura']['estado']],"#",array('data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>$factura['Factura']['comentario'])) ?></td>
                                        <td><?= $factura['Validador']['nombre_completo']?></td>
                                        <td style="text-align: center">
                                            <?php
                                                if ($factura['Factura']['estado']==5){
                                                    echo $this->Html->link('<i class="fa fa-edit"></i>',array('controller'=>'facturas','action'=>'edit',$factura['Factura']['id']),array('escape'=>false));
                                                } 
                                            ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?php
                                                if( $this->Session->read('Auth.User.id') == 82 || $this->Session->read('Auth.User.id') == 146 ){
                                                    
                                                    echo "<i class='fa fa-trash pointer' onclick='modalFacturaDeleteMaster(".$factura['Factura']['id'].")'></i>";

                                                } elseif ($factura['Factura']['estado']== 5 && ($this->Session->read('Auth.User.id')==$factura['Factura']['user_id'] || $this->Session->read('CuentaUsuario.CuentasUser.group_id')==1)){
                                                    
                                                    echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'facturas','action' => 'delete', $factura['Factura']['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar esta factura', $factura['Factura']['id'])));

                                                }
                                            ?>
                                        </td>
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

        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        '//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript',


        
    ], array('inline'=>true));
?>

<script>
    
'use strict';

let facturaID = 0;
$.ajax({
    url: '<?= Router::url(array("controller" => "facturas", "action" => "last_id")); ?>',
    success: function ( response ) {
        facturaID = parseInt(response) + parseInt(1);
    }
});

function modalFacturaDeleteMaster( facturaId ){
    $("#modal_factura_delete_master").modal('show');
    $("#FacturaId").val(facturaId);
}

function submitFormFacturaDeleteMaster() {
    $.ajax({
        type: "POST",
        url: '<?= Router::url(array("controller" => "facturas", "action" => "delete_master")); ?>',
        cache: false,
        data: { facturaId: $("#FacturaId").val() },
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
            var n = 1;
            window.setInterval(function(){
                n--;
                if (n == 0) {
                    $("#overlay").fadeOut();
                    location.reload();
                }
            },1000);
        },
        error: function( jqXHR, status, error ) {
            $("#modal_success").modal('show');
            document.getElementById("m_success").innerHTML = 'Ocurrió un error al consultar los clientes con estos filtros.';
            $("#overlay").fadeOut();
        }
    });
}

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

    $('#FacturaTotal').val(Math.round(parseFloat(sub*iva) - parseFloat(retIva) - parseFloat(retIsr)));
    $('#FacturaTotal2').val(Math.round(parseFloat(sub*iva)- parseFloat(retIva) - parseFloat(retIsr)));  
}

function validateForm( validateCircle ){
    let flag = true;
    
    $("#FacturaProveedorIdLabel").html("Lista de proveedores*");
    $("#FacturaTipoGastoLabel").html("Tipo de Gasto*");
    $("#FacturaDesarrolloIdLabel").html("Desarrollo al que pertenece el gasto*");
    $("#FacturaCategoriaIdLabel").html("Categoría del gasto*");
    $("#FacturaReferenciaLabel").html("Referencia*");
    $("#FacturaFechaEmisionLabel").html("Fecha de emisión*");
    $("#FacturaFechaPagoLabel").html("Fecha probable de pago*");
    $("#FacturaConceptoLabel").html("Concepto*");
    $("#FacturaSubtotalLabel").html("Subtotal*");
    $("#FacturaTotal2Label").html("Total*");
    $("#FacturaDocumentoPagoLabel").html("Documento(s) de gasto*");

    switch( validateCircle ){
        case 1:
            if( $("#FacturaProveedorId").val() == '' ){
                flag = false;
                $("#FacturaProveedorIdLabel").addClass('label-danger');
            }else { $("#FacturaProveedorIdLabel").removeClass('label-danger'); }

            if( $("#FacturaTipoGasto").val() == '' ){
                flag = false;
                $("#FacturaTipoGastoLabel").addClass('label-danger');
                
                adingValidate($("#FacturaTipoGasto").val());

            }else { $("#FacturaTipoGastoLabel").removeClass('label-danger'); adingValidate($("#FacturaTipoGasto").val()); }

            if( $("#desarrollo").val() == '' ){
                flag = false;
                $("#FacturaDesarrolloIdLabel").addClass('label-danger');
            }else { $("#FacturaDesarrolloIdLabel").removeClass('label-danger'); }

            if( $("#categoria").val() == '' ){
                flag = false;
                $("#FacturaCategoriaIdLabel").addClass('label-danger');
            }else { $("#FacturaCategoriaIdLabel").removeClass('label-danger'); }

            if( $("#FacturaReferencia").val() == '' ){
                flag = false;
                $("#FacturaReferenciaLabel").addClass('label-danger');
            }else { $("#FacturaReferenciaLabel").removeClass('label-danger'); }

            if( $("#FacturaFechaEmision").val() == '' ){
                flag = false;
                $("#FacturaFechaEmisionLabel").addClass('label-danger');
            }else { $("#FacturaFechaEmisionLabel").removeClass('label-danger'); }

            if( $("#FacturaFechaPago").val() == '' ){
                flag = false;
                $("#FacturaFechaPagoLabel").addClass('label-danger');
            }else { $("#FacturaFechaPagoLabel").removeClass('label-danger'); }

            if( $("#FacturaConcepto").val() == '' ){
                flag = false;
                $("#FacturaConceptoLabel").addClass('label-danger');
            }else { $("#FacturaConceptoLabel").removeClass('label-danger'); }

            if( $("#FacturaSubtotal").val() == '' ){
                flag = false;
                $("#FacturaSubtotalLabel").addClass('label-danger');
            }else { $("#FacturaSubtotalLabel").removeClass('label-danger'); }

            if( $("#FacturaTotal2").val() == '' ){
                flag = false;
                $("#FacturaTotal2Label").addClass('label-danger');
            }else { $("#FacturaTotal2Label").removeClass('label-danger'); }

            if( $("#input-upLoadFiles").val() == '' ){
                flag = false;
                $("#FacturaDocumentoPagoLabel").addClass('label-danger');
            }else { $("#FacturaDocumentoPagoLabel").removeClass('label-danger'); }

        break;
    }

    return flag;
}

function adingValidate( tipoGasto ){
    let flag = true;

    if( $("#FacturaTipoGasto").val() == '' ){
        flag = false;
        $("#FacturaTipoGastoLabel").addClass('label-danger');
        
        if(  tipoGasto == 'Impuestos' || tipoGasto == 'Pago de Servicios' ){
            
            $('#divLineaCaptura').fadeIn('fast');
            $("#FacturaLineaCapturaLabel").html("Linea de captura*");
            $("#FacturaLineaCapturaLabel").addClass("label-danger");
            $("#FacturaLineaCaptura").addClass("required");

            if( $("#FacturaLineaCaptura").val() == '' ){
                flag = false;
                $("#FacturaLineaCapturaLabel").addClass("label-danger");
            }else { $("#FacturaLineaCapturaLabel").removeClass('label-danger'); }

            $('#divFolio').fadeOut('fast');
            $("#folio").removeClass("required");

        }else if( tipoGasto == 'Factura' ) {

            $('#divLineaCaptura').fadeOut('fast');
            $("#FacturaLineaCapturaLabel").html("Linea de captura");
            $("#FacturaLineaCapturaLabel").removeClass("label-danger");
            $("#FacturaLineaCaptura").removeClass("required");

            $('#divFolio').fadeIn('fast');
            $("#FacturaFolioLabel").html("Folio Fiscal*");
            $("#FacturaFolioLabel").addClass("label-danger");
            $("#folio").addClass("required");

            if( $("#folio").val() == '' ){
                flag = false;
                $("#FacturaFolioLabel").addClass('label-danger');
            }else { $("#FacturaFolioLabel").removeClass('label-danger'); }


        }else {
            $('#divFolio').fadeOut('fast');
            $("#folio").removeClass("required");
            $("#FacturaFolioLabel").html("Folio Fiscal");
            $("#FacturaFolioLabel").removeClass("label-danger");
            
            $('#divLineaCaptura').fadeOut('fast');
            $("#FacturaLineaCapturaLabel").html("Linea de captura");
            $("#FacturaLineaCapturaLabel").removeClass("label-danger");
            $("#FacturaLineaCaptura").removeClass("required");

        }

    }else { 
        $("#FacturaTipoGastoLabel").removeClass('label-danger');
        if(  tipoGasto == 'Impuestos' || tipoGasto == 'Pago de Servicios' ){
            
            $('#divLineaCaptura').fadeIn('fast');
            $("#FacturaLineaCapturaLabel").html("Linea de captura*");
            $("#FacturaLineaCapturaLabel").addClass("label-danger");
            $("#FacturaLineaCaptura").addClass("required");

            if( $("#FacturaLineaCaptura").val() == '' ){
                flag = false;
                $("#FacturaLineaCapturaLabel").addClass("label-danger");
            }else { $("#FacturaLineaCapturaLabel").removeClass('label-danger'); }

            $('#divFolio').fadeOut('fast');
            $("#folio").removeClass("required");

        }else if( tipoGasto == 'Factura' ) {

            $('#divLineaCaptura').fadeOut('fast');
            $("#FacturaLineaCapturaLabel").html("Linea de captura");
            $("#FacturaLineaCapturaLabel").removeClass("label-danger");
            $("#FacturaLineaCaptura").removeClass("required");

            $('#divFolio').fadeIn('fast');
            $("#FacturaFolioLabel").html("Folio Fiscal*");
            $("#FacturaFolioLabel").addClass("label-danger");
            $("#folio").addClass("required");

            if( $("#folio").val() == '' ){
                flag = false;
                $("#FacturaFolioLabel").addClass('label-danger');
            }else { $("#FacturaFolioLabel").removeClass('label-danger'); }

        }else {
            $('#divFolio').fadeOut('fast');
            $("#folio").removeClass("required");
            $("#FacturaFolioLabel").html("Folio Fiscal");
            $("#FacturaFolioLabel").removeClass("label-danger");
            
            $('#divLineaCaptura').fadeOut('fast');
            $("#FacturaLineaCapturaLabel").html("Linea de captura");
            $("#FacturaLineaCapturaLabel").removeClass("label-danger");
            $("#FacturaLineaCaptura").removeClass("required");

        }
    }

    return flag;

}

$("#boton_submit").on('click',function() {

    let flag = true;
    
    if( validateForm(1) == false ){
        flag = false;
    }

    if( adingValidate($("#FacturaTipoGasto").val()) == false ){
        flag = false;
    }

    console.log( "Validacion de validateForm " + validateForm(1) );
    console.log( "Validacion de adingValidate " + adingValidate($("#FacturaTipoGasto").val()) );

    if( flag == true ){
        $("#FacturaAddForm").submit();
    }
});

function refAuto( definicion ) {
    var xtraeDef  = definicion.substr(0,3);
    var result    = '';

    result = facturaID + '-' + xtraeDef;
    return result.toUpperCase();

}


$(".required").on("change keyup paste", function(){
    validateForm(1);
    adingValidate($("#FacturaTipoGasto").val());
});


$(document).ready(function () {

    $("#FacturaTipoGasto").on('change',function() {
        // 'Factura', 'Requisición de Pago', 'Reembolso de Gasto', 'Pago de Servicios', 'Comisiones', 'Impuestos',
        let FacturaTipoGasto = $(this).val();
        let referencia       = refAuto( FacturaTipoGasto );

        switch ( FacturaTipoGasto ){
            case 'Requisición de Pago':
            case 'Reembolso de Gasto':
            case 'Pago de Servicios':
            case 'Comisiones':
            case 'Impuestos':
                // $('#folio').prop( 'disabled', true );
                $('#FacturaReferencia').val(referencia);
            break;
        }        
    });

    
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
                            $('<option>').val(key).text(value.replace(/[->]/g, ' ')).appendTo($("#categoria"));
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
    
    $("#input-upLoadFiles").fileinput({
        theme: "fa",
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        content: "Subir archivo",
        browseLabel: "Buscar",
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
    
    
    $('[data-toggle="popover"]').popover()

});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[ 3, "desc" ]],
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'excel',
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
        var tableWrapper = $('#sample_1_wrapper');
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