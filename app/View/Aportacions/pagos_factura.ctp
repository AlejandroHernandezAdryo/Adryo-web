<?php 
echo $this->Html->css(
    array(
       '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        'pages/tables',
        
        '/vendors/datatables/css/colReorder.bootstrap.min',
        
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        
        // Upload archiv
        '/vendors/fileinput/css/fileinput.min',
        'pages/form_elements',
                  
    ),
    array('inline'=>false))
?>
<style>
    .text-black{
        color: black;
    }
    .card:hover{
        box-shadow: none;
    }
    .kv-fileinput-caption{
        height: 29px;
    }
    .error{
        border: 1px solid red;
    }
</style>
<div class="modal fade" id="addDocument" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('Factura', array('type'=>'file','url'=>array('action'=>'add_documento', $factura['Factura']['id']))) ?>
            

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    Agregar documentos a factura - <?= $factura['Factura']['referencia'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <label for="documento de pago">Documento(s) para factura</label>
                        <input id="input-fa" name="data[Factura][archivos][]" type="file" class="file-loading" multiple required>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar documento
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pago" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('Transaccion', array('id'=>'form_add_pago','type'=>'file','url'=>array('action'=>'add_pago', 'controller'=>'aportacions', $factura['Factura']['id'], $tipo_transaccion))) ?>
            <?= $this->Form->hidden('factura_id',array('value'=>$factura['Factura']['id'])); ?>
            <?= $this->Form->hidden('pagado'); ?>
            <?= $this->Form->hidden('total',array('value'=>$factura['Factura']['total'])); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal5" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    Agregar pago a factura - <?= $factura['Factura']['referencia'] ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                        <?=  $this->Form->input('referencia',array('div' => 'col-sm-12 col-lg-6','class'=>'form-control','type'=>'text', 'label'=>'Referencia*', 'required'=>true, 'onchange'=>'validaPago()')); ?>
                        <?=  $this->Form->input('fecha',array('div' => 'col-sm-12 col-lg-6','class'=>'form-control fecha','type'=>'text', 'label'=>'Fecha*', 'required'=>true)); ?>
                    <div class="col-sm-12 col-lg-12">
                        <?=  $this->Form->input('monto',array('div' => false,'class'=>'form-control', 'label'=>'Monto*', 'required'=>true, 'span'=>'validaPago', 'type'=>'text', 'onchange'=>'validaPago()'));  ?>
                        <span style="color: red; display: none;" id="span-error">El monto no puede ser mayor al saldo de la factura</span>
                    </div>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('forma_pago',array('div' => 'col-sm-12 col-lg-6','class'=>'form-control','type'=>'select','empty'=>array(0=>'Seleccionar Forma de pago'),'options'=>$forma_pago, 'label'=>'Forma de pago*', 'required'=>true, 'onchange'=>'validaPago()')); ?>
                    
                    <?= $this->Form->input('cuenta_bancaria_id',array('div' => 'col-sm-12 col-lg-6','class'=>'form-control','type'=>'select','empty'=>array(0=>'Seleccionar Cuenta Bancaria'),'options'=>$ctabancaria, 'label'=>'Cuenta Bancaria*', 'onchange'=>'validaPago()'));?>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('comentarios',array('div' => 'col-sm-12','class'=>'form-control','type'=>'text')); ?> 
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <label for="documento de pago">Documento(s) de pago</label>
                        <input id="input-fa-2" name="data[Transaccion][archivos][]" type="file" class="file-loading" >
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-success pull-left" onclick="validaPagoSubmit()" id="btn-submit-pago">
                    Realizar pago
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

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
                echo $this->Form->hidden('redirect', array('value'=>1));
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
                    Información de factura
                </h4>
            </div>
            
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            
            <!-- Informacion de factura y proveedor -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            Factura - <?= $factura['Factura']['referencia']; ?> 
                        </div>
                        <div class="card-block">
                            <div class="row mt-2">
                                <div class="col-sm-12 col-lg-6">
                                    <h1 class="text-black"><i class="fa fa-globe fa-lg"></i> <?= $factura['Proveedor']['razon_social'].$factura['Cliente']['nombre'] ?></h1>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <span class="pull-right">Fecha: <?= date_format(date_create($factura['Factura']['fecha_emision']),"d-M-Y")?></span>
                                </div>
                                <div class="col-sm-12">
                                    <hr class="mt-2">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <?php if (!empty($factura['Proveedor']['id'])): ?>
                                    <div class="col-sm-12 col-lg-4">
                                        <section>
                                            <strong><?= $factura['Proveedor']['razon_social']?></strong><br>
                                            <?= $factura['Proveedor']['direccion']?><br>
                                            <?= $factura['Proveedor']['email']?><br>
                                            <?= $factura['Proveedor']['telefono_1']?><br>
                                            <?= $factura['Proveedor']['telefono_2']?><br>
                                        </section>
                                    </div>
                                <?php else: ?>
                                    <div class="col-sm-12 col-lg-4">
                                        <section>
                                            <strong><?= $factura['Cliente']['nombre']?></strong><br>
                                            <?= $factura['Cliente']['correo_electronico']?><br>
                                            <?= $factura['Cliente']['telefono1']?><br>
                                        </section>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($factura['Desarrollo']['id'])): ?>
                                    <!-- col-sm-12 col-lg-4 -->
                                    <div class="col-sm-12 col-lg-4">
                                        <section>
                                            <strong><?= $factura['Desarrollo']['nombre']?></strong><br>
                                            <p>
                                                <?= $factura['Desarrollo']['calle'].', N° Ext. '.$factura['Desarrollo']['numero_ext'].', '.$factura['Desarrollo']['colonia'].'<br>'.$factura['Desarrollo']['delegacion'].', CP '.$factura['Desarrollo']['cp'] ?>
                                            </p>
                                        </section>
                                    </div>
                                <?php endif ?>
                                <div class="<?= (empty($factura['Desarrollo']['id']) ? 'col-sm-12 push-lg-4 col-lg-4' : 'col-sm-12 col-lg-4') ?>">
                                    <b>Referencia Interna <?= $factura['Factura']['referencia']?></b><br>
                                    <b>Folio SAT <?= $factura['Factura']['folio']?></b><br>
                                    
                                    <b>Desarrollo <?= $factura['Desarrollo']['nombre']?></b><br>
                                    <b>Fecha de Creacion: </b><?= $factura['Factura']['created']==null?"-":date_format(date_create($factura['Factura']['created']),"d/M/Y H:i:s")?><br>
                                    
                                    <b>Fecha de Pago: </b><?= $factura['Factura']['fecha_pago']==null?"-":date_format(date_create($factura['Factura']['fecha_pago']),"d-M-Y")?><br>
                                    <b>Estado de factura: </b><?= $status_factura[$factura['Factura']['estado']]?><br>

                                    <b>Categoria: </b><?= $factura['Categoria']['nombre'];?><br>
                                    <b>Factura Cargada por: </b><?= $factura['Cargado']['nombre_completo']?>
                                    
                                </div>
                            </div>
                            <!-- ./row datos de factura y proveedor -->
                            
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <table class="table table-striped table-sm">
                                            <thead >
                                                <tr >
                                                    <th>Usuario</th>
                                                    <th>Acción</th>
                                                    <th>Status</th>
                                                    <th>Fecha de Validación</th>
                                                    <th style="text-align:center">Autorizar</th>
                                                    <th style="text-align:center">Rechazar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $pagar = 1?>
                                                <?php $resp_pago = 0?>
                                                <?php foreach($factura['ValidacionFactura'] as $validacion):?>
                                                <?php 
                                                    if ($validacion['validated'] == "" && $validacion['estado']==2 && $tipo_transaccion==2){
                                                        $pagar = 0;
                                                    }
                                                    if ($validacion['estado']==3 && $validacion['user_id']== $this->Session->read('Auth.User.id')){
                                                        $resp_pago = $this->Session->read('Auth.User.id');
                                                    }
                                                    $para_pago = 1;
                                                    if ($validacion['estado']!=3){
                                                ?>
                                                    <tr>
                                                      <td><?= $users[$validacion['user_id']]?></td>
                                                      <td><?= $status_pago[$validacion['estado']]?></td>
                                                      <td>
                                                          <?php 
                                                            $status = ($validacion['validated']==null?"En proceso":"Realizado");
                                                            echo $status;
                                                          ?>
                                                      </td>
                                                      <td><?= $validacion['validated']?></td>
                                                      <td style="text-align:center">
                                                          <?php
                                                          if ($validacion['estado'] !=3 && $validacion['validated'] == null){
                                                              $totalmente_validada = 0;
                                                              
                                                          }
                                                          if ($validacion['validated'] == null && $factura['Factura']['estado'] !=5 && $factura['Validador']['id']==$this->Session->read('Auth.User.id') && $validacion['user_id'] == $this->Session->read('Auth.User.id')){
                                                              $para_pago =0;
                                                              echo $this->Form->postLink('<i class="fa fa-check fa-lg"></i>', array('controller'=>'Facturas','action' => 'validar', $validacion['id'],$factura['Factura']['id']), array('style'=>'color:green','data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"Autorizar factura",'escape'=>false,'confirm' => __('Autorizar Factura?', $validacion['id'])));
                                                              $flag = 1;
                                                          }
                                                          ?>
                                                      </td>
                                                      <td style="text-align:center">
                                                            <?php if ($validacion['validated'] == null && $factura['Factura']['estado'] != 2 && $factura['Factura']['estado'] != 5 && $factura['Validador']['id']==$this->Session->read('Auth.User.id') && $validacion['user_id'] == $this->Session->read('Auth.User.id')): ?>
                                                                <a class="pointer" style="color:red" onclick="rechazarFac(<?= $factura['Factura']['id'] ?>)" data-toggle="tooltip" data-placement="top" title="Rechazar factura"><i class="fa fa-close fa-lg"></i></a>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    } 
                                                    endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- ./row tabla de validación de factura -->
                           

                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $factura['Factura']['concepto']?></td>
                                                <td><?= "$".number_format($factura['Factura']['subtotal'],2)?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- ./row tabla de descripción y subtotal -->
                            <?php if (isset($factura['Factura']['comentario'])): ?>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr style="background-color: #F34019; color: white;">
                                                    <th> <i class="fa fa-info"></i> Motivo de rechazo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $factura['Factura']['comentario']?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif ?>
                            
                            <!-- Tabla de comentario -->
                            <div class="row m-t-2">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                    <h2 class="text-black">Historial de pagos</h2>
                                    </div>
                                        
                                        <?php if ($para_pago && $resp_pago == $this->Session->read('Auth.User.id')): ?>
                                            
                                            <div class="col-lg-6">
                                                <button class="btn btn-success float-right btn-labeled" onclick="modal_pago();" id="btn-registro-pago">
                                                    Registrar pago
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    <div class="col-sm-12 mt-1">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Fecha real de pago</th>
                                                    <th>Referencia</th>
                                                    <th>Forma de Pago</th>
                                                    <th>Cuenta depósito</th>
                                                    <th>Monto Pagado</th>
                                                    <th>Anexo</th>
                                                    <th>Comentario</th>
                                                    <th>Eliminar Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $pagado = 0;
                                                    foreach ($pagos as $pago):
                                                ?>
                                                
                                                <tr>
                                                    
                                                    <td><?= date_format(date_create($pago['Transaccion']['fecha']),"d-M-Y")?></td>
                                                    <td><?= $pago['Transaccion']['referencia']?></td>
                                                    <td><?= $pago['Transaccion']['forma_pago']?></td>
                                                    <td><?= (!empty($ctabancaria[$pago['Transaccion']['cuenta_bancaria_id']]) ? $ctabancaria[$pago['Transaccion']['cuenta_bancaria_id']] : 'No existe la cta bancaria') ?></td>
                                                    <td><?= "$".number_format($pago['Transaccion']['monto'],2)?></td>
                                                    <td><?= (!empty($pago['DocumentosPago'][0]['url']) ? $this->Html->link('<i class="fa fa-download"></i>',$pago['DocumentosPago'][0]['url'],array('escape'=>false)) : '' ) ?></td>
                                                    <td><?= (!empty($pago['Transaccion']['comentarios']) ? $pago['Transaccion']['comentarios'] : '') ?></td>
                                                    <td><?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'transaccions','action' => 'delete', $pago['Transaccion']['id'],$factura['Factura']['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar este pago', $pago['Transaccion']['referencia']))); ?></td>
                                                </tr>
                                                <?php 
                                                    $pagado = $pagado + $pago['Transaccion']['monto'];
                                                    endforeach;
                                                ?>
                                                <tr>
                                                    <th colspan="4">TOTAL PAGADO</th>
                                                    <th>
                                                        <?= "$".number_format($pagado,2)?>
                                                        <input type="hidden" value="<?= $pagado ?>" id="set_input_pagado">
                                                    </th>
                                                    <th colspan="3"></th>
                                                </tr>
                                                <?php if ($factura['Factura']['total']-$pagado == 0){
                                                    $color = 'color: green';
                                                }else{$color = 'color: red';}?>
                                                <tr style="<?= $color ?>">
                                                    <th colspan="4">SALDO POR PAGAR</th>
                                                    <th>
                                                        <?= "$".number_format(($factura['Factura']['total']-$pagado),2)?>
                                                        <input type="hidden" value="<?= ($factura['Factura']['total']-$pagado) ?>" id="set_input_saldo_x_pagar">
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                <!-- ./col historial de pagos -->

                                <div class="col-sm-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h2 class="text-black">
                                                Fecha de pago
                                            </h2>
                                        </div>
                                        <div class="col-sm-12 mt-1">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td class="text-sm-right"><?= "$".number_format($factura['Factura']['subtotal'],2)?></td>
                                                </tr>
                                                <tr>
                                                    <th>IVA</th>
                                                    <td class="text-sm-right"><?= "$".number_format($factura['Factura']['iva'],2) ?></td>
                                                </tr>
                                                <?php if ($factura['Factura']['retencion_iva']!=null){?>
                                                <tr>
                                                    <th>Retención IVA</th>
                                                    <td class="text-sm-right"><?= "$".number_format($factura['Factura']['retencion_iva'],2) ?></td>
                                                </tr>
                                                <?php }?>
                                                <?php if ($factura['Factura']['retencion_isr']!=null){?>
                                                <tr>
                                                    <th>Retención ISR</th>
                                                    <td class="text-sm-right"><?= "$".number_format($factura['Factura']['retencion_isr'],2) ?></td>
                                                </tr>
                                                <?php }?>
                                                <tr>
                                                    <th>Total:</th>
                                                    <td class="text-sm-right"><?= "$".number_format($factura['Factura']['total'],2)?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./row Historial de pagos. -->

                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6">
                                                    <h3 class="text-black">
                                                        Documentos relacionados con la factura
                                                    </h3>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <button class="btn btn-success btn-sm float-lg-right"  data-toggle="modal" data-target="#addDocument" data-toggle="tooltip" data-placement="top" title="Agregar documento(s) a factura">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <hr class="mt-1">
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="table table-sm mt-2">
                                                <tbody>
                                                    <?php foreach ($factura['Documentos'] as $documento_factura): ?>
                                                        <tr>
                                                            <td><?php echo $documento_factura['nombre']?></td>
                                                            <td><?= $this->Html->link('<i class="fa fa-download"></i>', $documento_factura['url'], array('escape'=>false, 'target'=>'_blank')) ?></td>
                                                            <td><?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'facturas','action' => 'delete_archivo', $documento_factura['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar el archivo', $documento_factura['nombre']))); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($pagos as $pago): ?>
                                                        <?php foreach ($pago['DocumentosPago'] as $documento): ?>
                                                            <tr>
                                                                <td>Pago de factura ref-pago #<?= $documento['transaccions_id'] ?></td>
                                                                <td>
                                                                    <?= $this->Html->link('<i class="fa fa-download"></i>', $documento['url'], array('escape'=>false, 'target'=>'_blank')) ?>
                                                                </td>

                                                                <td><?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'facturas','action' => 'delete_archivo_pagos', $documento['id'], $factura['Factura']['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar el archivo'))); ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    <?php endforeach ?>
                                                </tbody>
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

        '/vendors/moment/js/moment.min',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';

/*function validaPago(){
    var saldo = $('#set_input_saldo_x_pagar').val();
    var monto = $('#TransaccionMonto').val();
    if (saldo < monto) {
        // console.log('No se puede pagar');
        $("#btn-submit-pago").prop("disabled", true);
    }else{
        // console.log('Adelante, paga');
        $("#btn-submit-pago").prop("disabled", false);
    }
}*/
function validaPago(){
    var saldo        = $('#set_input_saldo_x_pagar').val();
    var referencia   = $("#TransaccionReferencia").val();
    var monto        = $('#TransaccionMonto').val();
    var FormaPago    = $("#TransaccionFormaPago").val();
    var cntabancaria = $("#TransaccionCuentaBancariaId").val();
    var total        = 0;
    var flag         = true;

    if (referencia == '') {
        flag = false;
        $("#TransaccionReferencia").addClass('error');
    }else{
        $("#TransaccionReferencia").removeClass('error');
    }

    if (FormaPago == 0) {
        flag = false;
        $("#TransaccionFormaPago").addClass('error');
    }else{
        $("#TransaccionFormaPago").removeClass('error');
    }
    if (monto == '') {
        flag = false;
        $("#TransaccionMonto").addClass('error');
    }else{
        if (parseInt(saldo) < parseInt(monto)) {
        // if (saldo < monto) {
            flag = false;
            $("#TransaccionMonto").addClass('error');
            $("#span-error").css("display", "block");
        }else{
            $("#TransaccionMonto").removeClass('error');
            $("#span-error").css("display", "none");
        }
    }
    if (cntabancaria == 0) {
        flag = false;
        $("#TransaccionCuentaBancariaId").addClass('error');
    }else{
        $("#TransaccionCuentaBancariaId").removeClass('error');
    }
}

function validaPagoSubmit(){
    var saldo        = $('#set_input_saldo_x_pagar').val();
    var referencia   = $("#TransaccionReferencia").val();
    var monto        = $('#TransaccionMonto').val();
    var FormaPago    = $("#TransaccionFormaPago").val();
    var cntabancaria = $("#TransaccionCuentaBancariaId").val();
    var fecha        = $("#TransaccionFecha").val();
    var total        = 0;
    var flag         = true;

    if (referencia == '') {
        flag = false;
        $("#TransaccionReferencia").addClass('error');
    }else{
        $("#TransaccionReferencia").removeClass('error');
    }

    if (FormaPago == 0) {
        flag = false;
        $("#TransaccionFormaPago").addClass('error');
    }else{
        $("#TransaccionFormaPago").removeClass('error');
    }
    if (monto == '') {
        flag = false;
        $("#TransaccionMonto").addClass('error');
    }else{
        if (parseInt(saldo) < parseInt(monto)) {
        // if (saldo < monto) {
            flag = false;
            $("#TransaccionMonto").addClass('error');
            $("#span-error").css("display", "block");
        }else{
            $("#TransaccionMonto").removeClass('error');
            $("#span-error").css("display", "none");
        }
    }
    if (cntabancaria == 0) {
        flag = false;
        $("#TransaccionCuentaBancariaId").addClass('error');
    }else{
        $("#TransaccionCuentaBancariaId").removeClass('error');
    }

    if (fecha == 0) {
        flag = false;
        $("#TransaccionFecha").addClass('error');
    }else{
        $("#TransaccionFecha").removeClass('error');
    }

    if (flag == true) {
        $("#form_add_pago").submit();
    }

}

function modal_pago(){
    $("#modal_pago").modal('show');
    $('#TransaccionPagado').val($('#set_input_pagado').val());
}

function rechazarFac(id){
    $("#modal_status_factura").modal('show')
    document.getElementById("FacturaId").value = id;
    // console.log('rechazar factura con el id '+id);
}

$(document).ready(function () {

    // Input para el numero.
    $(".number").on({
          "focus": function(event) {
            $(event.target).select();
          },
          "keyup": function(event) {
            $(event.target).val(function(index, value) {
              return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{0})$/, '$1')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
          }
    });
    
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    }); 

    // Hacer validacion para el boton de pago
    if (<?= $factura['Factura']['total']-$pagado ?> == 0) {
        $('#btn-registro-pago').prop("disabled", true);
    }

    $('[data-toggle="popover"]').popover()

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    $("#input-fa").fileinput({
        theme: "fa",
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
    });
    $("#input-fa-2").fileinput({
        theme: "fa",
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
    });
});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('.dataTable-class');
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
        /*tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown*/
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