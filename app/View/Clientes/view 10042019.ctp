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
                                'Inactivo'          => 'Inactivo definitivo',
                                'Inactivo temporal' => 'Inactivo temporal'
                            );

                        if ($this->Session->read('Permisos.Group.ie')==1) {
                            array_push($status_cliente, array('Activo venta' => 'Activo venta'));
                        }
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
                                /*'Otra'                                                         => 'Otra',*/
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
                                /*'Otra'                                                         => 'Otra',*/
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
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-home fa-2x"></i>
                    Buscar Propiedad para Cliente
                </h4>
            </div>
            <div class="modal-body">
               <div class="row">       
            <?php echo $this->Form->create('Lead',array('url'=>array('controller'=>'leads','action'=>'add'),'class'=>'form-horizontal'))?>
            <?php 
                      
                      $venta = array('Venta'=>'Venta','Renta'=>'Renta','Venta / Renta' =>'Venta / Renta');
             ?>
             <?php echo $this->Form->input('tipo_propiedad', array('div' => 'col-lg-6','class'=>'form-control','type'=>'select','options'=>  $tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad'))?>
             <?php echo $this->Form->input('venta_renta', array('div' => 'col-lg-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta','label'=>'Renta/Venta'))?>
             <?php echo $this->Form->input('colonia', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Colonia'))?>
             <?php echo $this->Form->input('delegacion', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Delegación o Municipio'))?>
             <?php echo $this->Form->input('ciudad', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Ciudad'))?>
             <?php echo $this->Form->input('estado_ubicacion', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Estado'))?>
             <?php echo $this->Form->input('precio_min', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Precio Min','type'=>'text'))?>
             <?php echo $this->Form->input('precio_max', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Precio Max','type'=>'text'))?>
             <?php echo $this->Form->input('edad_min', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Edad Min'))?>
             <?php echo $this->Form->input('edad_max', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Edad Max'))?>
             <?php echo $this->Form->input('construccion_min', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Construcción min'))?>
             <?php echo $this->Form->input('construccion_max', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Construcción max'))?>
             <?php echo $this->Form->input('terreno', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Terreno mínimo'))?>
             <?php echo $this->Form->input('recamaras', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Recamaras (cuantas)'))?>
             <?php echo $this->Form->input('banos', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Baños (cuantos)'))?>
             <?php echo $this->Form->input('estacionamiento_descubierto', array('div' => 'col-lg-4','class'=>'form-control','label'=>'Estacionamientos'))?>
             
            </div>
                <div class="row m-t-10">
                    <div class="col-lg-12">
                     <?php echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']))?>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-plus"></i>
                    Buscar Propiedades
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true" >
    <?php echo $this->Form->create('Lead',array('url'=>array('controller'=>'leads','action'=>'add_desarrollo'),'class'=>'form-horizontal'))?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-building fa-2x"></i>
                    Buscar Desarrollo para Cliente
                </h4>
            </div>
            <div class="modal-body">
                <div class="row m-t-10">
                     <?php
                         echo $this->Form->input('desarrollo_id', array('div' => 'col-lg-12','class'=>'form-control chzn-select','label'=>'Desarrollos','type'=>'select','options'=>$lista_desarrollos));
                     ?>
                     <div class="checkbox radio_Checkbox_size4 col-lg-12 m-t-10">
                                    <label>
                                        <?= $this->Form->input('all', array('label'=>false,'div'=>false,'default'=>'unchecked','type'=>'checkbox'));?>
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                        Envíar Información completa de Desarrollo 
                                    </label>
                                </div>
                     <?php echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']))?>
                    
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-plus"></i>
                    Buscar Desarrollo
                </button>
            </div>
            
        </div>
    </div>
    <?= $this->Form->end()?>
</div>
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-envelope fa-2x"></i>
                    Enviar correo a cliente
                </h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('Cliente',array('url'=>array('controller'=>'clientes','action'=>'send_correo'),'class'=>'form-horizontal'))?>
                <?= $this->Form->input('cliente_id',array('type'=>'hidden','value'=>$cliente['Cliente']['id']))?>
                <div class="row m-t-10">
                     <?php echo $this->Form->input('para',array('value'=>$cliente['Cliente']['correo_electronico'],'class'=>'form-control','div'=>'col-md-12 m-t-15','label'=>'Para','disabled'))?>
                     <?php echo $this->Form->input('cc',array('class'=>'form-control','div'=>'col-md-12 m-t-15','label'=>'CC'))?>
                     <?php echo $this->Form->input('asunto',array('class'=>'form-control','div'=>'col-md-12 m-t-15','label'=>'Asunto'))?>
                    <?php echo $this->Form->input('contenido',array('class'=>'form-control','div'=>'col-md-12 m-t-15','label'=>'Mensaje','type'=>'textarea'))?>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-envelope"></i>
                    Enviar Correo
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-plus"></i>
                    Agregar nuevo evento
                </h4>
            </div>
            <?= $this->Form->create('Event',array('url'=>array('action'=>'add','controller'=>'events')))?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="nombre_evento" class="form-control-label">Nuevo Evento*</label>
                    </div>
                    <?= $this->Form->input('nombre_evento',array('class'=>'form-control','placeholder'=>'Nuevo Evento','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Lugar</label>
                    </div>
                    <?= $this->Form->input('direccion',array('class'=>'form-control','placeholder'=>'Lugar','div'=>'col-md-6 m-t-15','label'=>false,))?>
                    <?php 
                        $colores = array(4=>'Llamada',3=>'Mail',5=>'Cita');
                    ?>
                    <?= $this->Form->input('color',array('empty'=>'Tipo de evento','class'=>'form-control','type'=>'select','options'=>$colores,'div'=>'col-md-3 m-t-15','label'=>false,))?>
                    <div class="input-group">
                    <div class="col-lg-3 text-xl-left m-t-15">
                        <label for="Del" class="form-control-label">Del</label>
                    </div>
                    <?php
                        $hours=array();
                        for($i=0;$i<24;$i++){
                          $hours[$i]=  str_pad($i,2,'0',STR_PAD_LEFT);
                        }

                        $ms=array();
                        for($i=0;$i<60;$i++){
                          $ms[$i]=str_pad($i,2,'0',STR_PAD_LEFT);
}
                    ?>
                    <?= $this->Form->input('fi',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,'autocomplete'=>'off'))?>
                    <?= $this->Form->input('hi',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$hours))?>
                    <div class="col-lg-1 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">:</label>
                    </div>
                    <?= $this->Form->input('mi',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$ms))?>
                    </div>
                    <div class="input-group">
                    <div class="col-lg-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Al</label>
                    </div>
                    <?= $this->Form->input('ff',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,'autocomplete'=>'off'))?>
                    <?= $this->Form->input('hf',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$hours))?>
                    <div class="col-lg-1 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">:</label>
                    </div>
                    <?= $this->Form->input('mf',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$ms))?>
                    </div>
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="recordatorio" class="form-control-label">Recordatorio 1</label>
                    </div>
                    <?php $recordatorios = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes')?>
                    <?= $this->Form->input('recordatorio_1',array('onchange'=>'javascript:validar2()','type'=>'select','class'=>'form-control','empty'=>'Sin recordatorio','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$recordatorios))?>
                    <script>
                        function validar2(){
                            if (document.getElementById('EventRecordatorio1').value!=""){
                                document.getElementById('recordatorio2').style.display="";
                            }else{
                                document.getElementById('recordatorio2').style.display="none";
                            }
                        }
                    </script>
                    <div id="recordatorio2" style="display:none">
                        <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="recordatorio" class="form-control-label">Recordatorio 2</label>
                        </div>
                        <?= $this->Form->input('recordatorio_2',array('type'=>'select','class'=>'form-control','empty'=>'Sin recordatorio','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$recordatorios))?>
                    </div>
                    <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="cliente" class="form-control-label">Cliente relacionado</label>
                        </div>

                    <?= $this->Form->input('nombre_cliente',array('class'=>'form-control','div'=>'col-md-9 m-t-15','label'=>false, 'value'=>$cliente['Cliente']['nombre'], 'disabled'))?>
                    
                    <?= $this->Form->input('cliente_id',array('value'=>$cliente['Cliente']['id'], 'type'=>'hidden'))?>
                    
                    <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="desarrollo" class="form-control-label">Desarrollo</label>
                    </div>
                    <?= $this->Form->input('desarrollo_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin desarrollo asignado','style'=>'width:100%','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$lista_desarrollos))?>
                    
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="Inmueble" class="form-control-label">Propiedad</label>
                    </div>
                    <?= $this->Form->input('inmueble_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin inmueble asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$lista_inmuebles))?>
                    <?= $this->Form->hidden('return',array('value'=>1))?>
                    <!-- /btn-group -->
                </div>
                <!-- /input-group -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-plus"></i>
                    Crear Evento
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<script>
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
</script>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-5 col-xs-12">
                <h4 class="nav_top_align">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Clientes
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
                                <div class="col-sm-12 col-lg-6" style="text-align: right;">
                                    <?= $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'edit',$cliente['Cliente']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR CLIENTE','style'=>'color:white','escape'=>false))?>
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
                                                    <?= $this->Html->link('<i class="fa fa-edit"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#modal112'))?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Creado</td>
                                                <td><?php echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']))?></td>
                                            </tr>
                                            <tr>
                                                <td>Asignación</td>
                                                <td><?php 
                                                        if ($cliente['Cliente']['user_id']==""){
                                                            echo "NO ASIGNADO";
                                                        }
                                                        if ($cliente['Cliente']['user_id']!="" && $cliente['Cliente']['asignado']==null){
                                                            echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']));
                                                        }
                                                        if ($cliente['Cliente']['asignado']!=null)
                                                            echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['asignado']));
                                                        ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Primer Seguimiento</td>
                                                <td><?php
                                                        if ($cliente['Cliente']['first_edit']==null && $cliente['Cliente']['last_edit']==null){
                                                            echo "Cliente sin Seguimiento";
                                                        }
                                                        if ($cliente['Cliente']['first_edit']==null && $cliente['Cliente']['last_edit']!=null){
                                                            echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['created']));
                                                        }
                                                        if ($cliente['Cliente']['first_edit']!=null){
                                                            echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['first_edit']));
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Último Seguimiento</td>
                                                <td><?php
                                                        if ($cliente['Cliente']['last_edit']==null){
                                                            echo "Cliente sin Seguimiento";
                                                        }
                                                        if ($cliente['Cliente']['last_edit']!=null){
                                                            echo date('d/M/Y H:i:s',strtotime($cliente['Cliente']['last_edit']));
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-phone"></i> Teléfono 1</td>
                                                <td><?php echo $cliente['Cliente']['telefono1']?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-phone"></i> Teléfono 2</td>
                                                <td><?php echo $cliente['Cliente']['telefono2']?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-phone"></i> Teléfono 3</td>
                                                <td><?php echo $cliente['Cliente']['telefono3']?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-envelope"></i> Email</td>
                                                <td><?php echo $cliente['Cliente']['correo_electronico']?></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo de Cliente</td>
                                                <td><?php echo $cliente['DicTipoCliente']['tipo_cliente']?></td>
                                            </tr>
                                            <tr>
                                                <td>Etapa</td>
                                                <td><?php echo $cliente['DicEtapa']['etapa']?></td>
                                            </tr>
                                            <tr>
                                                <td>Forma de contacto</td>
                                                <td><?php echo  $cliente['DicLineaContacto']['linea_contacto']?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user"></i> Agente</td>
                                                <td><ins><?php echo $this->Html->link($cliente['User']['nombre_completo'], array('controller'=>'Users', 'action'=>'view', $cliente['User']['id']))?></ins></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                    $temp = array(
                                                        '1' => 'Frio',
                                                        '2' => 'Tibio',
                                                        '3' => 'Caliente',
                                                        '4' => 'Venta'
                                                    );

                                                ?>
                                                <?php

                                                    switch ($cliente['Cliente']['temperatura']) {
                                                        case 1:
                                                            $style = "width:50% !important;background-color:#5B9BD5; color:white; width:100%; border-radius:5px; text-align:center;";
                                                            break;

                                                        case 2:
                                                            $style = "width:50% !important;background-color:#FFC000; color:white; width:100%; border-radius:5px; text-align:center;";
                                                            break;

                                                        case 3:
                                                            $style = "width:50% !important;background-color: #C00000; color:white; width:100%; border-radius:5px; text-align:center;";
                                                            break;
                                                        case 4:
                                                            $style = "width:50% !important;background-color: #70AD47; color:white; width:100%; border-radius:5px; text-align:center;";
                                                            break;
                                                    }
                                                ?>
                                                <td>Temperatura</td>
                                                
                                                <td style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: left;align-items: center;align-content: center;">
                                                        <span style="<?= $style?>">
                                                            <?php echo $temp[$cliente['Cliente']['temperatura']]?>
                                                        </span>
                                                        <?= $this->Html->link('<i class="fa fa-edit"></i>','javascript:showEdit()',array('escape'=>false,'style'=>'margin-left: 5px;',))?> 
                                                        
                                                        <div style="display: none;" id="form_temp" class="col-sm-12">
                                                            <?php 
                                                                echo $this->Form->create('Cliente',array('url'=>array('action'=>'cambio_temp','controller'=>'clientes')));
                                                                echo $this->Form->input('temperatura',  array('label'=>false,'type'=>'select','options'=>$temp,'default'=>$cliente['Cliente']['temperatura'], 'class'=>'form-control form-control-sm'));
                                                                echo $this->Form->hidden('id',array('label'=>false,'value'=>$cliente['Cliente']['id']));
                                                                echo $this->Form->input('Guardar',array('label'=>false,'type'=>'submit', 'class'=>'btn btn-primary mt-5 btn-sm'));
                                                                echo $this->Form->end();
                                                            ?>
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Comentarios</td>
                                                <td><?php echo $cliente['Cliente']['comentarios']?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- ./col-sm-12 col-lg-6 sección información general -->
                                <div class="col-sm-12 col-lg-6">
                                    <h2 style="color:#4fb7fe">Seguimiento Rápido</h2>
                                    <div class="feed mt-1"style="overflow-y: scroll; height:600px !important">
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

            <div class="row">
                <div class="col-sm-12 col-lg-6 mt-2">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Indicadores de Seguimiento de Cliente
                        </div>
                        <div class="card-block">
                            <div class="row" style="padding:1%">
                                <div class="col-lg-6">
                                    <!-- <a href="/clientes/log_clientes/<?= $cliente['Cliente']['id']?>/3" style="color:white"> -->
                                    <a href="<?= Router::url('/clientes/log_clientes/'.$cliente['Cliente']['id']."/3",true) ?>" style="color:white">
                                    <div class="bg-success top_cards">
                                            <div class="row icon_margin_left">
                                                <div class="col-lg-2 icon_padd_left">
                                                    <div class="float-xs-left">
                                                        <span class="fa-stack fa-sm">
                                                            <i class="fa fa-circle fa-stack-2x"></i>
                                                            <i class="fa fa-envelope fa-stack-1x fa-inverse text-success visit_icon"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 icon_padd_right">
                                                    <div class="float-xs-right cards_content">
                                                        <span class="number_val" id="visitors_count"><?= $mails?></span>
                                                        <br/>
                                                        <span class="card_description">Emails
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6" >
                                    <a href="/clientes/log_clientes/<?= $cliente['Cliente']['id']?>/4" style="color:white">
                                    <div class="bg-info top_cards">
                                             <div class="row icon_margin_left">
                                                 <div class="col-lg-5 icon_padd_left">
                                                     <div class="float-xs-left">
                                                         <span class="fa-stack fa-sm">
                                                             <i class="fa fa-circle fa-stack-2x"></i>
                                                             <i class="fa fa-phone fa-stack-1x fa-inverse text-info visit_icon"></i>
                                                         </span>
                                                     </div>
                                                 </div>
                                                 <div class="col-lg-7 icon_padd_right">
                                                     <div class="float-xs-right cards_content">
                                                         <span class="number_val" id="visitors_count"><?= $llamadas?></span>
                                                         <br/>
                                                         <span class="card_description">Llamadas</span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row" style="padding:1%">
                                <div class="col-lg-6">
                                    <a href="/clientes/log_clientes/<?= $cliente['Cliente']['id']?>/5" style="color:white">
                                    <div class="bg-warning top_cards">
                                             <div class="row icon_margin_left">
                                                 <div class="col-lg-5 icon_padd_left">
                                                     <div class="float-xs-left">
                                                         <span class="fa-stack fa-sm">
                                                             <i class="fa fa-circle fa-stack-2x"></i>
                                                             <i class="fa fa-location-arrow fa-stack-1x fa-inverse text-warning revenue_icon"></i>
                                                         </span>
                                                     </div>
                                                 </div>
                                                 <div class="col-lg-7 icon_padd_right">
                                                     <div class="float-xs-right cards_content">
                                                         <span class="number_val" id="revenue_count"><?= $visitas?></span>
                                                         <br/>
                                                         <span class="card_description">Citas</span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="#leads_ventas" style="color:white">
                                    <div class="bg-mint top_cards">
                                            <div class="row icon_margin_left">
                                                <div class="col-lg-5 icon_padd_left">
                                                    <div class="float-xs-left">
                                                        <span class="fa-stack fa-sm">
                                                            <i class="fa fa-circle fa-stack-2x"></i>
                                                            <i class="fa fa-home  fa-stack-1x fa-inverse text-mint sub"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 icon_padd_right">
                                                    <div class="float-xs-right cards_content">
                                                        
                                                        <span class="number_val" id="subscribers_count"><?= sizeof($cliente['Lead'])?></span>
                                                        <br/>
                                                        <span class="card_description">Opciones</span>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./End col-sm-12 col-lg-6 Indicadores de seguimiento rápido -->

                <div class="col-sm-12 col-lg-6 mt-2">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Seguimiento Rápido
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="user-block">
                                        <?php echo $this->Form->create('Agenda',array('url'=>array('controller'=>'Agendas','action'=>'add')))?>
                                        <?php 
                                            if ($this->Session->read('Permisos.Group.id')==3){
                                                echo $this->Form->checkbox('asesoria')." Solicitar apoyo del gerente.";
                                            }else{
                                                echo $this->Form->checkbox('asesoria')." Notificar por mail a asesor.";
                                            }

                                        ?>
                                        <?php echo $this->Form->input('mensaje',array('class'=>'form-control input-sm','placeholder'=>'Escribe un mensaje','label'=>false, 'rows'=>5))?>

                                        <?php echo $this->Form->input('user_id',array('value'=>$this->Session->read('Auth.User.id'),'type'=>'hidden'))?>
                                        <?php echo $this->Form->input('lead_id',array('value'=>0,'type'=>'hidden'))?>
                                        <?php echo $this->Form->input('fecha',array('value'=>date("Y-m-d H:i:s"),'type'=>'hidden'))?>
                                        <?php echo $this->Form->input('cliente_id',array('value'=>$cliente['Cliente']['id'],'type'=>'hidden'))?>
                                        <?php echo $this->Form->button('Guardar mensaje',array('type'=>'submit','class'=>'btn btn-primary m-t-5'))?>
                                        <?php echo $this->Form->end()?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card m-t-20">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Registrar Eventos de Seguimiento
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-4">
                                    <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#myModal2"><i class="fa fa-calendar"></i> Programar Evento</a>
                                </div>
                                <div class="col-lg-4">
                                    <?php echo $this->Form->postLink(
                                            '<i class="fa fa-phone"></i> Registrar llamada', 
                                            array(
                                                'action' => 'registrar_llamada', 
                                                $cliente['Cliente']['id']
                                            ), 
                                            array('escape'=>false,'class'=>'btn btn-primary m-t-5'), 
                                            __('Registrar llamada a esta hora?', $cliente['Cliente']['id'])
                                            ); 
                                    ?>
                                </div>
                                <?php if ($cliente['Cliente']['correo_electronico']!=""){?>
                                <div class="col-lg-4">
                                    <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal5" data-target="#myModal5"><i class="fa fa-envelope"></i> Envíar Mail</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./End col-sm-12 fin del seguimiento rápido y registro de seguimiento -->
            </div>
            <!-- ./End row dos -->

            <div class="row">
                <div class="col-sm-12 col-lg-6 mt-2">
                    <?php echo $this->Form->create('Lead',array('url'=>array('action'=>'enviar')))?>
                    <div class="card">
                        <div class="card-header"  style="background-color: #2e3c54; color:white;">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    Inmuebles Seleccionados
                                </div>
                                <div class="col-sm-12 col-lg-6" style="text-align: right;">
                                    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal3"><i class="fa fa-plus" data-placement='top' title='Buscar Otra opción para cliente' data-toggle="tooltip" ></i>
                                             </a>
                                         <?php if ($cliente['Cliente']['correo_electronico']!=""){?>
                                        <?php echo $this->Form->button('<i class="fa  fa-mail-forward"></i>',array('type'=>'submit','class'=>'btn btn-primary','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Reenviar Selección a cliente',));?>
                                         <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="propiedades" class="table display nowrap" style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th>Propiedades</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach ($leads as $inmueble):
                                                $claseB= ($inmueble['Lead']['status'] == "Abierto" ? "hsl(39, 100%, 50%)" : ($inmueble['Lead']['status'] == "Cerrado" ? "hsl(19, 100%, 50%)" : "rgba(126, 204, 0, 0.79)"));
                                                $imagen = (isset($inmueble['Inmueble']['FotoInmueble'][0]) ? $inmueble['Inmueble']['FotoInmueble'][0]['ruta'] : "/img/no_photo_inmuebles.png");
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-12" style="background: <?= $claseB ?>; color: white; width: 95%; display: block;">
                                                                <?php
                                                                    echo $this->Form->checkbox('seleccionar'.$i);
                                                                    echo $this->Form->hidden('inmueble_id'.$i,array('value'=>$inmueble['Inmueble']['id']));
                                                                    if ($inmueble['Inmueble']['premium']==1){
                                                                        echo $this->Html->link($inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>",array('controller'=>'inmuebles','action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                    }else{
                                                                        echo $this->Html->link($inmueble['Inmueble']['titulo'],array('controller'=>'inmuebles','action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                    }

                                                                    echo "<span class='float-xs-right'>";
                                                                    switch ($inmueble['Lead']['status']):
                                                                        case("Abierto"):
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Cerrado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                        break;
                                                                        case("Cerrado"):
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            echo $this->Html->link('<i class="fa fa-tag"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Abierto",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'REABRIR INTERÉS','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                        break;
                                                                        case("Aprobado"):
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Cerrado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                        break;
                                                                    endswitch;
                                                                    echo "</span>";
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- ./End row header - Titulo e iconos de like y dislike -->
                                                        <div class="row">
                                                            <div class="col-lg-3" style="height:90px;background-image: url('<?= Router::url('/',true).$imagen?>'); background-position:center center; background-repeat:no-repeat; background-size:cover "></div>
                                                            <div class="col-md-3">
                                                                <div class="row">
                                                                    <div class=" col-sm-6 col-md-3">
                                                                    <?= $this->Html->image('m2.png',array('width'=>'40%'))?>
                                                                    </div>
                                                                    <div class=" col-sm-6 col-md-3">
                                                                        <?= floatVal($inmueble['Inmueble']['construccion'])."m2"?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-3">
                                                                        <?= $this->Html->image('recamaras.png',array('width'=>'40%'))?>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-3">
                                                                        <?= intVal($inmueble['Inmueble']['recamaras'])?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-3">
                                                                    <?= $this->Html->image('banios.png',array('width'=>'40%'))?>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-3">
                                                                        <?= intVal($inmueble['Inmueble']['banos'])?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-3">
                                                                        <?= $this->Html->image('autos.png',array('width'=>'40%'))?>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-3">
                                                                        <?= intVal($inmueble['Inmueble']['estacionamiento_techado'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <b><?php echo $tipo_propiedad[$inmueble['Inmueble']['dic_tipo_propiedad_id']]?></b><br>
                                                                <?php if($inmueble['Inmueble']['venta_renta']=="Venta") {?>
                                                                <b><?php echo "$".number_format($inmueble['Inmueble']['precio'],2)?></b><br>
                                                                <?php }else if($inmueble['Inmueble']['venta_renta']=="Renta"){?>
                                                                <b><?php echo "$".number_format($inmueble['Inmueble']['precio_2'],2)?></b><br>
                                                                <?php }else if($inmueble['Inmueble']['venta_renta']=="Venta / Renta"){?>
                                                                <b><?php echo "$".number_format($inmueble['Inmueble']['precio'],2)." / "."$".number_format($inmueble['Inmueble']['precio_2'],2)?></b><br>
                                                                 <?php }?>
                                                                <b><?php echo $inmueble['Inmueble']['exclusiva']?></b><br>
                                                                <b><?php echo $inmueble['Inmueble']['venta_renta']?></b><br>
                                                                <b>Colonia: <?= $inmueble['Inmueble']['colonia']?></b><br>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        echo $this->Form->hidden('contador',array('value'=>$i));
                        echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']));
                        echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('Auth.User.id')));
                        echo $this->Form->end();
                    ?>
                </div>
                <!-- ./Fin primer tarjeta de inmuebles -->
                <div class="col-sm-12 col-lg-6 mt-2">
                    <?php
                        echo $this->Form->create('Lead',array('url'=>array('action'=>'enviar_desarrollos')));
                    ?>
                    <div class="card">
                        <div class="card-header"  style="background-color: #2e3c54; color:white;">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    Desarrollos Seleccionados
                                </div>
                                <div class="col-sm-12 col-lg-6" style="text-align: right;">
                                    <a  href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal4"><i class="fa fa-plus" data-placement='top' title='Buscar Otro Desarrollo para cliente' data-toggle="tooltip" ></i></a>
                                     <?php
                                        if ($cliente['Cliente']['correo_electronico']!=""){
                                            echo $this->Form->button('<i class="fa  fa-mail-forward"></i>',array('type'=>'submit','class'=>'btn btn-primary','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Reenviar Selección a cliente'));
                                         }
                                     ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="desarrollos" class="table display nowrap" style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th>Desarrollos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($desarrollos as $desarrollo):
                                                $claseB= ($desarrollo['Lead']['status']=="Abierto" ? "hsl(39, 100%, 50%)" : ($desarrollo['Lead']['status']=="Cerrado" ? "hsl(19, 100%, 50%)" : "rgba(126, 204, 0, 0.79)"));
                                                $imagen = (isset($desarrollo['Desarrollo']['FotoDesarrollo'][0]) ? $desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'] : "/img/no_photo_inmuebles.png");
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-12" style="background: <?= $claseB ?>; color: white; width: 95%; display: block;">
                                                                <?php
                                                                    echo $this->Form->checkbox('seleccionar'.$j);
                                                                    echo $this->Form->hidden('desarrollo_id'.$j,array('value'=>$desarrollo['Desarrollo']['id']));
                                                                    echo $this->Html->link($desarrollo['Desarrollo']['nombre'],array('action'=>'view','controller'=>'desarrollos',$desarrollo['Desarrollo']['id']),array('escape'=>false,'style'=>'color:white'));

                                                                    echo "<span class='float-xs-right'>";
                                                                    switch ($desarrollo['Lead']['status']):
                                                                        case("Abierto"):
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Cerrado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                        break;
                                                                        case("Cerrado"):
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            echo $this->Html->link('<i class="fa fa-tag"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Abierto",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'REABRIR INTERÉS','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                        break;
                                                                        case("Aprobado"):
                                                                            echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Cerrado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                            //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                        break;
                                                                    endswitch;
                                                                    echo "</span>";
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- ./End row header titulo y botones de like y dislike -->

                                                        <div class="row">
                                                            <div class="col-lg-3" style="height:90px;background-image: url('<?= Router::url('/',true).$imagen?>'); background-position:center center; background-repeat:no-repeat; background-size:cover "></div>
                                                            <div class="col-lg-3" >
                                                                <div class="row">
                                                                   <div class="col-sm-6 col-md-3">
                                                                    <?= $this->Html->image('m2.png',array('width'=>'40%'))?> 
                                                                   </div>
                                                                   <div class="col-sm-6 col-md-3">
                                                                    <?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?>
                                                                   </div>
                                                                   <div class="col-sm-6 col-md-3">
                                                                       <?= $this->Html->image('autos.png',array('width'=>'40%'))?>
                                                                   </div>
                                                                   <div class="col-sm-6 col-md-3">
                                                                       <?= $desarrollo['Desarrollo']['est_low']?>-<?= $desarrollo['Desarrollo']['est_top']?>
                                                                   </div>
                                                                   <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('banios.png',array('width'=>'40%'))?>
                                                                   </div>
                                                                   <div class="col-sm-6 col-md-3">
                                                                     <?= $desarrollo['Desarrollo']['banio_low']?>-<?= $desarrollo['Desarrollo']['banio_top']?>
                                                                   </div>
                                                                   <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('recamaras.png',array('width'=>'40%'))?>
                                                                    </div>
                                                                   <div class="col-sm-6 col-md-3"> 
                                                                    <?= $desarrollo['Desarrollo']['rec_low']?>-<?= $desarrollo['Desarrollo']['rec_top']?>
                                                                   </div>
                                                               </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <b>Tipo de Desarrollo: </b><?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?><br>
                                                                <b>Torres: </b><?php echo $desarrollo['Desarrollo']['torres']?><br>
                                                                <b>Unidades Totales: </b><?php echo $desarrollo['Desarrollo']['unidades_totales']?><br>
                                                                <b>Entrega: </b><?php echo date('d/M/Y',  strtotime($desarrollo['Desarrollo']['fecha_entrega']))?><br>
                                                                <b>Colonia: </b><?= $desarrollo['Desarrollo']['colonia']?><br>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            <?php  $j++; endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        echo $this->Form->hidden('contador',array('value'=>$i));
                        echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']));
                        echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('Auth.User.id')));
                        echo $this->Form->end();
                    ?>
                </div>
                <!-- ./Fin segunda tarjeta de desarrollos -->
            </div>
            <!-- ./End row tres -->
            <!-- <?php if (sizeof($venta_inmueble) > 0): ?>
                
            <?php endif ?> -->
            <div class="row">
                <div class="col-sm-12 mt-2">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Propiedades Compradas
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-sm" id="compras">
                                        <thead style="background: #E3E3E3;">
                                            <tr>
                                                <td class="text-center">Tipo operación</td>
                                                <td class="text-center">Asesor</td>
                                                <td class="text-center">Fecha de la venta</td>
                                                <td class="text-center">Monto de cierre</td>
                                                <td class="text-center">Propiedad</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($venta_inmueble as $propiedad):
                                                if($propiedad['Venta']['tipo_operacion'] == 'Venta'){$op = 'V'; $class_op = 'bg_venta'; $name_op = 'Venta';}
                                                else{$op = 'R'; $class_op = 'bg_renta'; $name_op = 'Renta';}
                                            ?>
                                                <tr>
                                                    <td><small><span class="<?= $class_op ?>"><?= $op ?></span></small><span class="text_hidden"><?= $name_op ?></span></td>
                                                    <td>
                                                        <ins>
                                                            <?= $this->Html->link($propiedad['User']['nombre_completo'], array('controller'=>'users', 'action'=>'view', $propiedad['User']['id'])) ?>
                                                        </ins>
                                                    </td>
                                                    <td><?= date('d-m-Y H:m:s', strtotime($propiedad['Venta']['fecha'])) ?></td>
                                                    <td class="text-xl-right">$ <?= number_format($propiedad['Venta']['precio_cerrado']) ?></td>
                                                    <td>
                                                        <?= $this->Html->link($propiedad['Inmueble']['titulo'], array('controller'=>'inmuebles', 'action'=>'view', $propiedad['Inmueble']['id'])) ?>
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
            <!-- ./End row cuatro -->

            <div class="row">
                <div class="col-sm-12 mt-2">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            PROPIEDADES SUGERIDAS
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="feed"style="overflow-y: scroll; height:200px !important">
                                        <?= $this->Form->create('Lead',array('url'=>array('action'=>'asignar')))?>
                                            <table id="example" class="table display nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Propiedades</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']));
                                                        echo $this->Form->hidden('status',array('value'=>"Abierto"));
                                                        $i=1;
                                                        if (isset($sugeridas)){
                                                            foreach ($sugeridas as $inmueble):
                                                    ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php
                                                                            echo $this->Form->input('seleccionar'.$i,array('div'=>'col-sm-offset-2 col-sm-6','type'=>'checkbox','class'=>'checkbox','label'=>false));
                                                                            echo $this->Form->hidden('inmueble_id'.$i,array('value'=>$inmueble['Inmueble']['id']));
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-2"style="border-right: 1px solid black;">
                                                                                <?php 
                                                                                    if (isset($inmueble['FotoInmueble'][0]['ruta'])){
                                                                                        echo $this->Html->image($inmueble['FotoInmueble'][0]['ruta'],array('width'=>'100%','alt'=>$inmueble['FotoInmueble'][0]['descripcion']));
                                                                                        //echo $this->Html->link($this->Html->image($inmueble['FotoInmueble'][0]['ruta'],array('width'=>'100%','alt'=>$inmueble['FotoInmueble'][0]['descripcion'])),$inmueble['FotoInmueble'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                                                    }else{
                                                                                        echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%'));
                                                                                    }
                                                                                    ?>
                                                                             </div>
                                                                             <div class="col-lg-10">
                                                                                 <div style="background-color: #2e3c54; color:white"><?php 
                                                                                    if ($inmueble['Inmueble']['premium']==1){
                                                                                        echo $inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>";
                                                                                        //echo $this->Html->link($inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>",array('action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                                    }else{
                                                                                        echo $inmueble['Inmueble']['titulo'];
                                                                                        //echo $this->Html->link($inmueble['Inmueble']['titulo'],array('action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                             </div>
                                                                             <div class="col-lg-12">
                                                                                <div class="row">
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##FB7FE">REFERENCIA</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $inmueble['Inmueble']['referencia']?>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">TERRENO</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $inmueble['Inmueble']['terreno']?> m2
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">ESTADO</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                    <?php
                                                                                        switch ($inmueble['Inmueble']['liberada']){
                                                                                            case 0: //No liberada
                                                                                                echo "<div style='text-align: center; background-color: #fcee21'>NO LIBERADA</div>";
                                                                                                break;

                                                                                            case 1: // Libre
                                                                                                echo "<div style='text-align: center; background-color: #39b54a; color:white' class='chip'>LIBRE</div>";
                                                                                                break;

                                                                                            case 2:
                                                                                                echo "<div style='text-align: center; background-color: #fbb03b; color:white' class='chip'>RESERVA</div>";
                                                                                                break;

                                                                                            case 3:
                                                                                                echo "<div style='text-align: center; background-color: #29abe2' class='chip'>CONTRATO</div>";
                                                                                                break;

                                                                                            case 4:
                                                                                                echo "<div style='text-align: center; background-color: #c1272d' class='chip'>ESCRITURACION</div>";
                                                                                                break;
                                                                                            case 5:
                                                                                                echo "<div style='text-align: center; background-color: #c1272d; color:white' class='chip'>BAJA</div>";
                                                                                                break;
                                                                                        }
                                                                                    ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-2" style="text-align:lef">
                                                                                <font color="##4FB7FE">PRECIO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo "$".number_format($inmueble['Inmueble']['precio'])?>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">CONSTRUCCIÓN</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['construccion']?> m2
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">VENCIMIENTO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo date('d/M/Y',  strtotime($inmueble['Inmueble']['due_date']))?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-2" style="text-align:lef">
                                                                                <font color="##4FB7FE">PRECIO 2</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo "$".number_format($inmueble['Inmueble']['precio_2'])?>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">HABITACIONES</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['recamaras']?>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">CITA</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['cita']?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-2" style="text-align:lef">
                                                                                <font color="##4FB7FE">OPERACIÓN</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php $inmueble['Inmueble']['venta_renta']?>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">BAÑOS</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['banos']?>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">EXCLUSIVA</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['exclusiva']?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-2" style="text-align:lef">
                                                                                <font color="##4FB7FE">FECHA INGRESO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php $inmueble['Inmueble']['fecha']?>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <font color="##4FB7FE">ESTACION.</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?>
                                                                            </div>
s                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                    <?php
                                                            $i++;
                                                            endforeach;
                                                            echo $this->Form->hidden('contador',array('value'=>$i));
                                                        }elseif(isset($desarrollos)){ #Fin del if isset sugeridas
                                                            foreach ($desarrollos as $desarrollo) {
                                                                
                                                    ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php
                                                                            echo $this->Form->input('seleccionar'.$i,array('div'=>'col-sm-offset-2 col-sm-6','type'=>'checkbox','class'=>'checkbox','label'=>'Seleccionar'));
                                                                            echo $this->Form->hidden('desarrollo_id'.$i,array('value'=>$desarrollo['Desarrollo']['id']));
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-lg-2"style="border-right: 1px solid black;">
                                                                                <?php 
                                                                                    if (isset($desarrollo['FotoDesarrollo'][0]['ruta'])){
                                                                                            echo $this->Html->image($desarrollo['FotoDesarrollo'][0]['ruta'],array('width'=>'100%','alt'=>$desarrollo['FotoDesarrollo'][0]['descripcion']));
                                                                                            //echo $this->Html->link($this->Html->image($desarrollo['FotoDesarrollo'][0]['ruta'],array('width'=>'100%','alt'=>$desarrollo['FotoDesarrollo'][0]['descripcion'])),$desarrollo['FotoDesarrollo'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                                                    }else{
                                                                                            echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%'));
                                                                                    }
                                                                                ?>
                                                                             </div>
                                                                             <div class="col-lg-9">
                                                                                 <div style="background-color: #2e3c54; color:white">
                                                                                    <?php 
                                                                                        echo $desarrollo['Desarrollo']['nombre'];
                                                                                        //echo $this->Html->link($desarrollo['Desarrollo']['nombre'],array('controller'=>'desarrollos','action'=>'view',$desarrollo['Desarrollo']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                                    ?>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">DISPONIBILIDAD</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['disponibilidad']?>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">TIPO DE DESARROLLO</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">FECHA DE ENTREGA</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['fecha_entrega']?>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">UNIDADES TOTALES</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['unidades_totales']?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-2" style="text-align:lef">
                                                                                        <font color="##4FB7FE">INICIO DE PREVENTA</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['inicio_preventa']?>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">TORRES</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['torres']?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-2" style="text-align:lef">
                                                                                        <font color="##4FB7FE">UNIDADES TOTALES</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php $desarrollo['Desarrollo']['unidades_totales']?>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <font color="##4FB7FE">DEPARTAMENTOS MUESTRA</font>
                                                                                    </div>
                                                                                    <div class="col-lg-2" style="text-align:left">
                                                                                        <?php echo $desarrollo['Desarrollo']['torres']?>
                                                                                    </div>
                                                                                </div>
                                                                             </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                    <?php
                                                                $i++;
                                                            }; #End foreach
                                                            echo $this->Form->hidden('contador',array('value'=>$i));
                                                        }; #End elseif
                                                    ?>
                                                </tbody>
                                            </table>
                                        <?= $this->Form->end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row cinco -->

        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('[data-toggle="popover"]').popover()
});
</script>
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
function showEdit(){
    $("#form_temp").fadeIn();
}
function showEditEstatus(){
    $("#form_status_hiden").fadeIn();
}

function hideEditEstatus(){
    $("#btn_hide_status").fadeIn();
}

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