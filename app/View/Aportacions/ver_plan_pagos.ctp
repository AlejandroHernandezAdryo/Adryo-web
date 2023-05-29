<?= $this->Html->css(
    array(
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        '/vendors/datatables/css/scroller.bootstrap.min',
        'pages/tables',
        '/vendors/select2/css/select2.min',
        
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/datepicker/css/bootstrap-datepicker.min',

        // Chozen select
        '/vendors/chosen/css/chosen',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/fileinput/css/fileinput.min',
        // Calendario
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
<!-- Estatus factura (cancelación)  **Korner 02-05-2023** -->
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
                echo $this->Form->hidden('estado', array('value'=>5));
                echo $this->Form->hidden('redirect', array('value'=>0));
                echo $this->Form->hidden('venta_id', array('value'=>$venta['Venta']['id']));
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
<!-- Editar factura  **Korner 02-05-2023** -->
<div class="modal fade" id="modal_edit_factura">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Resgistra el pago
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="" style="color: black;">
                            En caso de que el monto sea mayor a la mensualidad selecciona <b>otro monto</b> e ingresa la cantidad.
                        </h3>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="custom-control custom-radio col-sm-12 col-md-6">
                        <input type="radio" id="pago_mes_fijo" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="pago_mes_fijo">Monto mensual</label>
                        <br>
                        <p style="padding-left:8px;"><b>Texto</b></p>
                    </div>
                    <div class="custom-control custom-radio col-sm-12 col-md-6 float-right" style="margin-left:0 !important;">
                        <input type="radio" id="pago_monto_mayor" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="">Otro monto</label>
                        <br>
                        <input type="number" name="" for="pago_monto_mayor" id="" class="form-control" placeholder="$ Ingresa la cantidad">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-md-6">
                        <p style="margin:0;"><b>Comprobante de pago</b></p>
                        <p>Sólo archivos jpg, png y pdf. Tamaño máximo 5mb</p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="es" required>
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                    </div>
                </div>
                <!-- Form delete cliente -->
                <?php
                    echo $this->Form->create('Factura', array('url'=>array('controller'=>'facturas', 'action'=>'status')));
                    echo $this->Form->hidden('id');
                    echo $this->Form->hidden('estado', array('value'=>5));
                    echo $this->Form->hidden('redirect', array('value'=>0));
                    echo $this->Form->hidden('venta_id', array('value'=>$venta['Venta']['id']));
                ?>
                <!-- <div class="row">
                    <//?= $this->Form->input('comentario', array('class'=>'form-control', 'div'=>'col-sm-12', 'required'=>true, 'label'=>'Motivo de Rechazo*', 'type'=>'textarea', 'rows' => '1', 'data-min-rows' => '1')); ?>
                </div> -->
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Aceptar</button>
                        <button type="button" class="btn btn-primary-o float-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<!-- Subir factura  **Korner 02-05-2023** -->
<div class="modal fade" id="modal_upload_factura">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Resgistra el pago
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="" style="color: black;">
                            En caso de que el monto sea mayor a la mensualidad selecciona <b>otro monto</b> e ingresa la cantidad.
                        </h3>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="custom-control custom-radio col-sm-12 col-md-6">
                        <input type="radio" id="pago_mes_fijo" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label"  for="pago_mes_fijo">Monto mensual</label>
                        <br>
                        <p style="padding-left:8px;" id='apagar_monto'></p>
                        <p style="padding-left:8px;" hidden><span id='id_pago'></span></p>
                    </div>
                    <div class="custom-control custom-radio col-sm-12 col-md-6 float-right" style="margin-left:0 !important;">
                        <input type="radio" id="pago_monto_mayor"  name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="">Otro monto</label>
                        <br>
                        <input type="number" name="" for="pago_monto_mayor"  value="" id="pago_mas" class="form-control" placeholder="$ Ingresa la cantidad">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12 col-md-6">
                        <p style="margin:0;"><b>Comprobante de pago</b></p>
                        <p>Sólo archivos jpg, png y pdf. Tamaño máximo 5mb</p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input"  lang="es" required>
                            <!-- 
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label> -->
                             
                                <input type="file" name="" id="pagoImagen" accept="image/*, .pdf" required="required"> 
                        </div>
                    </div>
                </div>
                <!-- Form delete cliente -->
                <!-- <?php
                    //echo $this->Form->create('LogPago', array('url'=>array('controller'=>'LogPago', 'action'=>'pago_mes_cliente_')));
                    //echo $this->Form->hidden('id');
                ?> -->
                <!-- <div class="row">
                    <//?= $this->Form->input('comentario', array('class'=>'form-control', 'div'=>'col-sm-12', 'required'=>true, 'label'=>'Motivo de Rechazo*', 'type'=>'textarea', 'rows' => '1', 'data-min-rows' => '1')); ?>
                </div> -->
                <div class="row mt-1">
                    <div class="col-sm-12">

                        <button type="button" class="btn btn-primary float-right" onclick="subir()" style="margin-left:8px;">Aceptar</button>
                        <button type="button" class="btn btn-primary-o float-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <!-- <i class="fa fa-calendar"></i>-->
                    Historial y plan de pagos  
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <!-- Información de cliente ** Korner 01-05-1990** -->
            <div class="card mt-1">
                <div class="card-header bg-blue-is">
                    <b><?= $venta['Cliente']['nombre']?></b>
                    <div style="float:right">
                        <?= $this->Html->link('Estado de cuenta',array('action'=>'estado_cuenta',$venta['Venta']['id'],),array('escape'=>false,'class'=>'btn btn-primary','data-toggle'=>'tooltip','data-placement'=>'top'))?>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <b>Propiedad:</b>
                            <br> 
                            <span id=propiedad_referencia>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <b>Fecha de cierre:</b>
                            <br>
                            <span id='fecha_operacion'>
                                
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <b>Asesor cerro venta:</b>
                            <br> 
                            <span id='user_venta'>
                            
                            </span>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-12 col-lg-2">
                            <b>Apartado:</b>
                            <br> 
                            <span id=apertado>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Escrituración:</b>
                            <br> 
                            <span id='escrituracion'>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Contrato:</b>
                            <br> 
                            <span id='contrato'>
                               
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Mensualidad:</b>
                            <br> 
                            <span id='mensualidad'>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Precio de venta:</b>
                            <br> 
                            <span id ='precio_cierre'>
                               
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <b>Saldo:</b>
                            <br> 
                            <span id='totalpagado'>
                                
                            </span>
                        </div>
                    </div>
                    <!-- <div class="col-sm-12 col-lg-12">
                        <div class="col-sm-12 col-lg-4">
                            <b>Propiedad:</b>
                            <br> 
                            <span>
                            <?= $venta['Venta']['tipo_operacion'].": ".$venta['Inmueble']['referencia']?>
                            </span>
                        </div>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Nombre de Cliente:</td>
                                    <td class="text-lg-left">
                                        <?= $venta['Cliente']['nombre']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Inmueble Comprado:</td>
                                    <td class="text-lg-left">
                                        <?= $venta['Inmueble']['referencia']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Precio Cerrado:</td>
                                    <td class="text-lg-left">
                                        <?= "$".number_format($venta['Venta']['precio_cerrado'],2)?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Saldo:</td>
                                    <td class="text-lg-left">
                                        <?= "$".number_format($venta['Venta']['precio_cerrado']-$pagos[0][0]['SUM(monto)'],2)?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fecha de cierre de venta:</td>
                                    <td class="text-lg-left">
                                        <?= date("d/M/Y",strtotime($venta['Venta']['fecha']))?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Asesor que cierra la venta:</td>
                                    <td class="text-lg-left">
                                        <?= $venta['User']['nombre_completo']?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>   
                    </div> -->
                </div>
            </div>
            <!-- Historial y plan de pagos ** Korner 01-05-1990** -->
            <!-- <div class="card mt-1">
                <div class="card-header bg-blue-is">
                    Plan de pagos
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-40">
                                    <thead>
                                        <tr>
                                            <th>Referencia</th>
                                            <th>Fecha de pago</th>
                                            <th>Total</th>
                                            <th>Estatus</th>
                                            <th>Rechazar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <//?php foreach ($aportaciones as $factura): ?>
                                            <tr>
                                                <td><//?= $this->Html->link($factura['Factura']['referencia'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 1), array('style'=>'text-decoration: underline')); ?></td>
                                                <td><//?= $factura['Factura']['fecha_emision'] ?></td>
                                                <td class="text-xs-right"><//?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                                <td><//?= $status_factura[$factura['Factura']['estado']] ?></td>
                                                <td class="text-sm-center">
                                                    <//?php if ($factura['Factura']['estado'] != 2 && $factura['Factura']['estado'] != 5): ?>
                                                        <a class="pointer" onclick="rechazarFac(<//?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Rechazar factura"><i class="fa fa-close"></i></a>
                                                    <//?php endif ?>
                                                </td>
                                            </tr>
                                        <//?php endforeach ?>
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row mt-1">
                <div class="col-sm-12 ">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#plan_pagos" data-toggle="tab" onclick="">Plan de pagos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#historial_pagos" data-toggle="tab" onclick="">Historial de pagos</a>
                        </li>
                    </ul>
                    <div class="card">
                        <div id="rootwizard_no_val">
                            <div class="tab-content">
                                <!-- tab plan de pagos -->
                                <div class="tab-pane active" id="plan_pagos">
                                    <div class="row m-t-20">
                                        <div class="col-sm-12">
                                            <div class="card-block">
                                                <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-40">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Referencia</th>
                                                            <th>Fecha de pago</th>
                                                            <th>Número de pago</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($aportaciones as $factura): ?>
                                                            <tr>
                                                                <td class="text-sm-center">
                                                                    <?php if ($factura['Factura']['estado'] != 2 && $factura['Factura']['estado'] != 5): ?>
                                                                        <a class="pointer" onclick="rechazarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Rechazar factura"><i class="fa fa-close"></i></a>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td><?= $this->Html->link($factura['Factura']['referencia'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 1), array('style'=>'text-decoration: underline')); ?></td>
                                                                <td><?= $factura['Factura']['fecha_emision'] ?></td>
                                                                <td>
                                                                    <?php for ($count = 1; $count < 100; $count++): ?>
                                                                    <?php endfor ;?>
                                                                </td>
                                                                <td class=""><?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tab historial de pagos -->
                                <div class="tab-pane" id="historial_pagos">
                                    <div class="row">
                                        <!-- Estatus de seguimiento **Korner 24-04-2023** -->
                                        <div class="col-sm-12">
                                            <div class="card-block">
                                                <table class="table table-striped table-hover table-sm w-100" id="sample_2" class="m-t-40">
                                                    <!-- <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Referencia </th>
                                                            <th>Fecha de pago</th>
                                                            <th>Número de pago</th>
                                                            <th>Total</th>
                                                            <th>Fecha de registro</th>
                                                            <th>Estatus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php  $i = 1; ?>
                                                        <?php foreach ($aportaciones as $factura): ?>
                                                            <tr>
                                                                <td class="text-sm-center">
                                                                    <?php if ($factura['Factura']['estado'] != 2 && $factura['Factura']['estado'] != 5): ?>
                                                                        <a class="pointer" onclick="rechazarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Ver comprobante"><i class="fa fa-eye"></i></a>
                                                                        <a class="pointer" onclick="editarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Editar" style="margin-left:8px;"><i class="fa fa-pencil"></i></a>
                                                                    <?php else :?>
                                                                        <a class="disabled" onclick="rechazarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-eye"></i></a>
                                                                        <a class="pointer" onclick="uploadFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Editar" style="margin-left:8px;"><i class="fa fa-upload"></i></a>
                                                                    <?php endif ;?>
                                                                </td>
                                                                <td><?= $this->Html->link($factura['Factura']['referencia'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 1), array('style'=>'text-decoration: underline')); ?></td>
                                                                <td><?= $factura['Factura']['fecha_emision'] ?></td>
                                                                <td>
                                                                    <?php  echo$i++; ?>
                                                                <td><?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                                                <td>
                                                                    Texto
                                                                </td>
                                                                <td><?= $status_factura[$factura['Factura']['estado']] ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody> -->
                                                </table>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="outer m-t-15">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-blue-is">
                    Plan de pagos
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-40">
                                    <thead>
                                        <tr>
                                            <th>Referencia</th>
                                            <th>Fecha de pago</th>
                                            <th>Total</th>
                                            <th>Estatus</th>
                                            <th>Rechazar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($aportaciones as $factura): ?>
                                            <tr>
                                                <td><?= $this->Html->link($factura['Factura']['referencia'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['Factura']['id'], 1), array('style'=>'text-decoration: underline')); ?></td>
                                                <td><?= $factura['Factura']['fecha_emision'] ?></td>
                                                <td class="text-xs-right"><?= '$ '.number_format($factura['Factura']['total']) ?></td>
                                                <td><?= $status_factura[$factura['Factura']['estado']] ?></td>
                                                <td class="text-sm-center">
                                                    <?php if ($factura['Factura']['estado'] != 2 && $factura['Factura']['estado'] != 5): ?>
                                                        <a class="pointer" onclick="rechazarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Rechazar factura"><i class="fa fa-close"></i></a>
                                                    <?php endif ?>
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
    </div> -->
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',
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
    ], array('inline'=>false));
?>

<script>
        
    'use strict';
    $(document).ready(function () {
        $('.fecha').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation:"bottom"
        });

        TableAdvanced.init();
        $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
        
        $('[data-toggle="popover"]').popover()
        let cliente_id = 58104;
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "LogPagos", "action" => "view_datos_cliente")); ?>",
            data: {api_key: 'api_key', cliente_id:cliente_id },
            dataType: 'json',
            success: function (response) {
                for (let i in response.respuesta) {
                    
                    document.getElementById("propiedad_referencia").innerHTML =response.respuesta[i].cliente.referencia;
                    document.getElementById("fecha_operacion").innerHTML =response.respuesta[i].cliente.fecha;
                    document.getElementById("user_venta").innerHTML =response.respuesta[i].cliente.user_nombre;
                    document.getElementById("apertado").innerHTML =response.respuesta[i].cliente.apartado;
                    document.getElementById("escrituracion").innerHTML =response.respuesta[i].cliente.escrituracion;
                    document.getElementById("contrato").innerHTML =response.respuesta[i].cliente.contrato;
                    document.getElementById("mensualidad").innerHTML =response.respuesta[i].cliente.mensualidad;
                    document.getElementById("precio_cierre").innerHTML =response.respuesta[i].cliente.precio_cierre;
                    document.getElementById("totalpagado").innerHTML =response.respuesta[i].cliente.totalpagado;
				}
            },
            error: function ( response ) {
                console.log('arroja error');
                console.log(response.responseText);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "LogPagos", "action" => "pagos_log")); ?>",
            data: {api_key: 'api_key', cliente_id:cliente_id },
            dataType: 'json',
            success: function (response) {
                $('#sample_2').dataTable( {
                    destroy: true,
                    data : response,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: 'Bflr<"table-responsive"t>ip',
                    columnDefs: [
                        {
                            targets: [ 3 ],
                            visible: false,
                            searchable: false
                        },
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
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                            filename: 'ClientList',
                            class : 'excel',
                            charset: 'utf-8',
                            bom: true,
                            // enabled: false,
        
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa  fa-print"></i> Imprimir',
                            filename: 'ClientList',
                        },
                    ]
                });
            }
        });

    });



    function editarFac(id) {
        $("#modal_edit_factura").modal('show')
        document.getElementById("FacturaId").value = id;
       
    }
    function uploadFac(id){
        let id_pago = id;
        $("#modal_upload_factura").modal('show')
        // document.getElementById("FacturaId").value = id;
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "LogPagos", "action" => "view_pago")); ?>",
            data: {api_key: 'api_key', id_pago:id_pago },
            dataType: "Json",
            success: function (response) {
                console.log(response);
                for (let i in response) {
                    document.getElementById("apagar_monto").innerHTML =response[i].pago_programado;
                    // document.getElementById("pago_mes_fijo").innerHTML =response[i].pago_programado;
                    document.getElementById("id_pago").innerHTML =response[i].id;
                    // pago_mes_fijo
                }
                // apagar_monto
            }
        });
        // console.log( id );
    }
    /**
     * 
     * 
    */
    function subir(){
        let pago=$("#apagar_monto").text();
        let id_pago=$("#id_pago").text();
        let pagoMas=$("#pago_mas").val()
        let Image=$("#pagoImagen").val();
        let remplazar = Image.replace(/_/g, " ");
        // valorCampo = $("#ProcesoInmueblesApartadoTipoDocumento").val();
        // remplazar = valorCampo.replace(/_/g, " ");
        // pagoImagen
        // console.log(remplazar);
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "LogPagos", "action" => "pago_mes_cliente_")); ?>",
            data: { id_pago: id_pago, pago:pago, Image:Image , pagoMas:pagoMas},
            dataType: "Json",
            success: function (response) {
                console.log(response);
            }
        });
    }

    function viewfac(id){
        $("#modal_status_factura").modal('show')
        document.getElementById("FacturaId").value = id;
        // console.log('rechazar factura con el id '+id);
    }
    var TableAdvanced = function() {
        // ===============table 1====================
        var initTable2 = function() {
            var table = $('#sample_2');
            table.DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: [ 3 ],
                        visible: false,
                        searchable: false
                    },
                ],
                language: {
                    sSearch: "Buscador",
                    lengthMenu: '_MENU_ registros por página',
                    info: 'Mostrando _TOTAL_ registro(s)',
                    infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                    emptyTable: "Sin información.",
                    paginate: {
                        previous: 'Anterior',
                        next: 'Siguiente'
                    },
                },
                columns: [

                    { title: "ver" },
                    { title: "Comprobante" },
                    { title: "Referencia" },
                    { title: "Fecha programada de Pago" },
                    { title: "Número de pago" },
                    { title: "Total" },
                    { title: "Fecha programada de Pago" },
                    { title: "Estatus" },
                    { title: "Fecha de registro de pago" },
                ],
                dom: 'Bflr<"table-responsive"t>ip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                        filename: 'ClientList',
                        class : 'excel',
                        charset: 'utf-8',
                        bom: true,
                        enabled: false,

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa  fa-print"></i> Imprimir',
                        filename: 'ClientList',
                        enabled: false,
                    },
                ]
            });
            var tableWrapper = $('#sample_2_wrapper');
            tableWrapper.find('.dataTables_length select').select2();
        }
        
        return {
            //main function to initiate the module
            init: function() {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable2();
                
            }
        };
    }();
    
</script>