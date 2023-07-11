<?php 
    $i = 1;
    $j = 1;

    $activo       = "width:50% !important;background-color:#BF9000; color:white; width:100%; border-radius:5px; text-align:center;";
    $inactivo     = "width:50% !important;background-color:#000000; color:white; border-radius:5px; text-align:center;";
    $activo_venta = "width:50% !important;background-color:#70AD47; color:white; border-radius:5px; text-align:center;";
    $neutral      = "width:50% !important;background-color:#7F6000; color:white; border-radius:5px; text-align:center;";
    $style        = ($cliente['Cliente']['status']=='Activo' ? $activo : ($cliente['Cliente']['status']=='Inactivo' ? $inactivo : ($cliente['Cliente']['status']=='Activo venta' ? $activo_venta : $neutral)));

    echo $this->Html->css(
        array(
            '/vendors/swiper/css/swiper.min',
            // 'pages/general_components',
            
            'jquery.fancybox',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fullcalendar/css/fullcalendar.min',
            'pages/timeline2',
            'pages/calendar_custom',
            'pages/profile',
            'pages/gallery',
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            'pages/flot_charts',
            
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/c3/css/c3.min',
            '/vendors/toastr/css/toastr.min',
            '/vendors/switchery/css/switchery.min',
            'pages/new_dashboard',
            
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',
            
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',


            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/chosen/css/chosen',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            'pages/wizards',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/radio_css/css/radiobox.min',
            'custom',
            'style_operaciones',
            'componentsadryo',
        ),
        array('inline'=>false)); 
?>
<style>
    .chip{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; font-size: 1.1em; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
    .flex-center{display: flex ; flex-direction: row ; flex-wrap: wrap ; justify-content: center ; align-items: center ; align-content: center ;}
    .mt-5{margin-top: 5px !important;}
    .modal-dialog-centered{margin-top: 15%;}
    .hidden{display: none;}
    .padding10{
        padding: 10px;
    }
    .danger_bg_dark{
        background: #EA423E;
        color: white;
    }
    .bg-warning{
        background: #ff9933;
        color: white;
    }

    textarea{
        overflow:hidden;
        display:block;
    }
    .text-center{
        text-align: center;
    }

</style>

<!-- The Modal -->
<div class="modal fade" id="modal112">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('Status', array('url'=>array('controller'=>'Clientes', 'action' => 'update_status', $cliente['Cliente']['id']))); ?>
      <div class="modal-content">
        <div class="modal-header" style="background: #2e3c54;">
          <h4 class="modal-title col-sm-10">Estatus del cliente</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        $status_cliente = array(
                                'Activo'            => 'Activo',
                                'Inactivo'          => 'Inactivo',
                                'Inactivo temporal' => 'Inactivo temporal'
                            );

                        /*if ($this->Session->read('Permisos.Group.ie')==1) {
                            array_push($status_cliente, array('Activo venta' => 'Activo venta'));
                        }*/
                        echo '<div class="row">'.$this->Form->input('status', array(
                            'div'   => 'col-sm-12',
                            'class' => 'form-control',
                            'label' => 'Estatus',
                            'type' => 'select',
                            'options' => $status_cliente,
                            'id' => 'select_status',
                            'onchange' => 'status_select_input();'
                        )).'</div>';

                        echo '<div class="row" id="row_motivo" style="display:none;" >'.$this->Form->input('motivo', array(
                            'div'   => 'col-sm-12',
                            'class' => 'form-control',
                            'label' => 'Motivo',
                            'type'  => 'select',
                            'options' => array(
                                'Solicitó contactarlo tiempo después'                          => 'Solicitó contactarlo tiempo después',
                                'Le interesa comprar /rentar pero va a postergar la decisión.' => 'Le interesa comprar /rentar pero va a postergar la decisión.',
                                'Debe consultar con sus familiares, define después.'           => 'Debe consultar con sus familiares, define después.',
                                'Sale de viaje, a su regreso pidió contactarlo.'               => 'Sale de viaje, a su regreso pidió contactarlo.',
                                'Otra'                                                         => 'Otra',
                            ),
                            'onchange' => 'otro_motivo();'
                        )).
                        '</div>';
                        
                         echo '<div class="row" id="row_motivo_2" style="display:none;" >'.$this->Form->input('motivo_2', array(
                            'div'   => 'col-sm-12',
                            'class' => 'form-control',
                            'label' => 'Motivo',
                            'type'  => 'select',
                            'options' => array(
                                'No responde correo ni teléfono'                               => 'No responde correo ni teléfono',
                                'No le interesa ninguna de las propiedades'                    => 'No le interesa ninguna de las propiedades',
                                'Compró / rentó en otro lugar'                                 => 'Compró / rentó en otro lugar',
                                'Declinó su interés de compra'                                 => 'Declinó su interés de compra',
                                'Cliente Molesto por falta de seguimiento'                     => 'Cliente Molesto por falta de seguimiento',
                                'Otra'                                                         => 'Otra',
                            ),
                            'onchange' => 'otro_motivo();'
                        )).
                        '</div>';

                        echo '<div class="row" id="row_Otromotivo" style="display:none;" >'.$this->Form->input('otro_motivo', array(
                            'div'       => 'col-sm-12',
                            'class'     => 'form-control',
                            'label'     => '¿Cúal?',
                            'type'      => 'textarea',
                            'maxlength' => '45',
                            'rows'      => '1',
                            'data-min-rows' => '1'
                        )).
                        '</div>';

                        echo '<div class="row" id="row_calendario" style="display:none;" >'.$this->Form->input('recordatorio', array(
                            'div'         => 'col-sm-12',
                            'class'       => 'form-control fecha',
                            'label'       => array(
                                'text'  => 'Elige una fecha si deseas que el sistema te recurde de este usuario',
                                'class' => 'padding10 bg-warning mt-1'
                            ),
                            'placeholder' => 'dd-mm-YYYY',
                            'autocomplete' => 'off'
                        )).
                        '</div>';

                        echo $this->Form->hidden('nombre_cliente', array('value'=>$cliente['Cliente']['nombre']));
                    ?>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
        <?= $this->Form->end(); ?>
      </div>
    </div>
</div>

<div class="modal fade" id="modal_new_factura" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('Factura', array('url'=>array('action'=>'add', 'controller'=>'facturas'))) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal5" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    Agregar nueva factura
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->hidden('cliente_id', array('value'=>$cliente['Cliente']['id'])) ?>
                <?= $this->Form->hidden('ruta', array('value'=>4)) ?>
                <?= $this->Form->hidden('total') ?>
                    <!-- <div Class="row Mt-1">
                        <?= $this->form->input('categoria_id', Array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'seleccione Una Opción', 'options'=>$categorias, 'label'=>'categoria De Factura')) ?>
                    </div> -->
                    <div class="row mt-1">
                        <?= $this->Form->input('referencia', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6')) ?>
                        <?= $this->Form->input('folio', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('fecha_emision', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text')) ?>
                        <?= $this->Form->input('fecha_pago', array('class'=>'form-control fecha', 'div'=>'col-sm-12 col-lg-6', 'type'=>'text')) ?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('concepto', array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'textarea', 'rows'=>'2', 'maxlength'=>'200')) ?>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-12 col-lg-4">
                            <?= $this->Form->input('subtotal', array('div'=>false, 'label'=>'Subtotal*', 'class'=>'form-control', 'required'=>true, 'onchange'=>'calTotal();')) ?>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <?= $this->Form->input('iva', array('div'=>false, 'label'=>'Iva*', 'class'=>'form-control', 'onchange'=>'calIva();', 'required'=>true)) ?>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <?= $this->Form->input('total_2', array('div'=>false, 'label'=>'Total*', 'class'=>'form-control', 'disabled'=>true)) ?>
                        </div>
                    </div>
                    <!-- <div class="row mt-1">
                        <?= $this->Form->input('pdf', array('div'=>'col-sm-12 col-lg-6', 'label'=>'pdf', 'class'=>'form-control')) ?>
                        <?= $this->Form->input('xml', array('div'=>'col-sm-12 col-lg-6', 'label'=>'Xml', 'class'=>'form-control')) ?>
                    </div> -->
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar factura
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-5 col-xs-12">
                <h4 class="nav_top_align">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    Cliente
                </h4>
                
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <b><?php echo $cliente['Cliente']['nombre']?></b>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <h2 style="color:#4fb7fe">Información General</h2>
                                    <table class="table table-striped table-bordered table-hover mt-1">
                                        <tbody>
                                            <tr>
                                                <td>Estatus de Cliente</td>
                                                <td style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: left;align-items: center;align-content: center;"><span style="<?= $style?>">
                                                    <?php echo $cliente['Cliente']['status']?></span>
                                                    <?php if ($this->Session->read('Permisos.Group.ce')==1): ?>
                                                        <?= $this->Html->link('<i class="fa fa-edit"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#modal112'))?>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Creado</td>
                                                <td><?php echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']))?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-phone"></i> Teléfono 1</td>
                                                <td><?php echo $cliente['Cliente']['telefono1']?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-envelope"></i> Email</td>
                                                <td><?php echo $cliente['Cliente']['correo_electronico']?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- ./col-sm-12 col-lg-6 sección información general -->
                                <div class="col-sm-12 col-lg-6">
                                    <h2 style="color:#4fb7fe">Seguimiento Rápido</h2>
                                    <div class="feed mt-1" style="overflow-y: scroll; height:200px !important">
                                        <ul>                                                            
                                            <?php foreach ($agendas as $agenda):?>
                                            <li>
                                                <span>
                                                    <?php echo $this->Html->image($agenda['User']['foto'], array('class'=>'img-circle img-bordered-sm','style'=>'width: 100%'))?>
                                                </span>
                                                <h5><font color="black"><?php echo $this->Html->link($agenda['User']['nombre_completo'],array('action'=>'view','controller'=>'users',$agenda['User']['id']))?></font></h5>
                                                <p>
                                                    <?php echo $agenda['Agenda']['mensaje']?>
                                                </p>
                                                <i><?php echo $agenda['Agenda']['fecha']?></i>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>      
                                </div>
                                <!-- ./col-sm-12 col-lg-6 sección seguimiento rápido -->
                            </div>
                        </div>
                        <!-- ./End .card-block -->
                    </div>
                </div>
            </div>
            <!-- ./End row uno -->
            <!-- Registro de facturas -->
            <div class="row mt-1 finanzas">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    Listado de facturas
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <?= $this->Html->link('Agregar nueva factura', '#',array('class'=>'btn btn-success text-white float-lg-right', 'data-toggle'=>'modal', 'data-target'=>'#modal_new_factura')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-sm" id="facturas">
                                        <thead style="background: #E3E3E3;">
                                            <tr>
                                                <th>Referencia</th>
                                                <th>Folio</th>
                                                <th>Concepto</th>
                                                <th>Fecha de emision</th>
                                                <th>Sub total</th>
                                                <th>Iva</th>
                                                <th>Total</th>
                                                <th>Estatus</th>
                                                <th>Pagar</th>
                                                <!-- <th>Ver detalle</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cliente['Facturas'] as $facturas): ?>
                                                <tr>
                                                    <td><?= $this->Html->link($facturas['referencia'], array('controller'=>'facturas', 'action'=>'view', $facturas['id']), array('style'=>'text-decoration: underline;')) ?></td>
                                                    <td><?= $facturas['folio'] ?></td>
                                                    <td><?= $facturas['concepto'] ?></td>
                                                    <td><?= $facturas['fecha_emision'] ?></td>
                                                    <td><?= '$'.number_format($facturas['subtotal']) ?></td>
                                                    <td><?= '$'.number_format($facturas['iva']) ?></td>
                                                    <td><?= '$'.number_format($facturas['total']) ?></td>
                                                    <td><?= $status_factura[$facturas['estado']] ?></td>
                                                    <td class="text-sm-center">
                                                        <?php if ($facturas['estado'] == 0 || $facturas['estado'] == 4): ?>
                                                            <?= $this->Html->link('<i class="fa fa-money fa-lg"></i>', array('controller'=>'aportacions', 'action'=>'pagos_factura', $facturas['id']), array('escape'=>false)); ?>
                                                        <?php endif ?>
                                                    </td>
                                                    <!-- <td><?= $this->Html->link('Ver más', array('controller'=>'facturas', 'action'=>'view', $facturas['id']), array('style'=>'text-decoration: underline;')) ?></td> -->
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
            <!-- Listado de facturas. -->
        </div>
    </div>
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',

        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/chosen/js/chosen.jquery',
    ], array('inline'=>false));
?>
<script>

function pago(id){
    $("#modal_pago_factura").modal('show');
};

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

function status_select_input(){
    var val1 = $('#select_status').val();
    if (val1 == 'Inactivo temporal') {
        $('#row_motivo_2').fadeOut();
        $('#row_motivo').fadeIn();
        $('#row_calendario').fadeIn();
        
    }else if(val1 == 'Inactivo') {
        $('#row_motivo').fadeOut();
        $('#row_calendario').fadeOut();
        $('#row_motivo_2').fadeIn();
        
    }
    else {
        $('#row_motivo').fadeOut();
        $('#row_calendario').fadeOut();
    }
};

function otro_motivo(){
    var val1 = $('#StatusMotivo').val();
    if (val1 == 'Otra') {
        $('#row_Otromotivo').fadeIn();
    }else{
        $('#row_Otromotivo').fadeOut();
    }
};

function validar2(){
    if (document.getElementById('EventRecordatorio1').value!=""){
        document.getElementById('recordatorio2').style.display="";
    }else{
        document.getElementById('recordatorio2').style.display="none";
    }
};

function showEdit(){
    $("#form_temp").fadeIn();
};
function showEditEstatus(){
    $("#form_status_hiden").fadeIn();
};

function hideEditEstatus(){
    $("#btn_hide_status").fadeIn();
};

'use strict';
$(document).ready(function () {

/*$('textarea').each(function () {
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
}).on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});*/

$(".chzn-select").chosen({allow_single_deselect: true});

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
    $('#compras').DataTable( {
        dom: 'Bflr<"table-responsive"t>ip'
    });
    $('#facturas').DataTable( {
        dom: 'Bflr<"table-responsive"t>ip'
    });
    $('#pagos').DataTable( {
        dom: 'Bflr<"table-responsive"t>ip'
    });

    $('#propiedades').DataTable( {
        "scrollY": 500,
        "scrollX": true,
        initComplete: function () {
            $('.dataTables_filter input[type="search"]').css({ 'width': '140px', 'display': 'inline-block' });
        }
    });
    
    $('#desarrollos').DataTable( {
        "scrollY": 500,
        "scrollX": true,
        initComplete: function () {
            $('.dataTables_filter input[type="search"]').css({ 'width': '140px', 'display': 'inline-block' });
        }
    });

    $('#example').DataTable( {
        "scrollY": 500,
        "scrollX": true,
        initComplete: function () {
            $('.dataTables_filter input[type="search"]').css({ 'width': '140px', 'display': 'inline-block' });
        }
    });
    
    //End of Scroll - horizontal and Vertical Scroll Table

    // advanced Table

    
    // End of advanced Table
    
    
});

</script>