<?= $this->Html->css(
        array(
            'jquery.fancybox',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fullcalendar/css/fullcalendar.min',
            'pages/timeline2',
            'pages/calendar_custom',
            'pages/profile',
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
            
            '/vendors/fancybox/css/jquery.fancybox',
            '/vendors/fancybox/css/jquery.fancybox-buttons',
            '/vendors/fancybox/css/jquery.fancybox-thumbs',
            '/vendors/imagehover/css/imagehover.min',
            'pages/gallery',

            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',

            // Chozen select
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/fileinput/css/fileinput.min',
            
            // Datatables
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/colReorder.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',

        ),
        array('inline'=>false)); 
?>
<style>
.panel_datos{
    display: block;
    padding-top: 2px;
}
.text-black{
    color: #000 !important;
}
.text-center{
    text-align: center;
}
.fw-600{
    font-weight: 600;
}
#table-especial > tbody > tr > td{
    height: auto !important;
    padding: 2px !important;
}
.chosen-container {
    width: 100% !important;
    display: block;
    height: 30px;
}
.align-lg-right{
    float: right;
}
</style>

<!-- Modal para eliminar venta -->
<div class="modal fade" id="moda_delete_sale">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-grey-black">
                        ¿ Esta seguro que desea ELIMINAR esta venta ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('Venta', array('url'=>array('controller'=>'Ventas', 'action'=>'delete_sale')));
                echo $this->Form->input('id');
                echo $this->Form->hidden('retorno', array('value'=>1));
                echo $this->Form->hidden('inmueble_id', array('value'=>$inmueble_id));
                echo $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo_id));
            ?>
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



<div class="modal fade" id="venta" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-picture"></i>
                    Registrar venta de la propiedad
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Venta',array('url'=>array('action'=>'add','controller'=>'ventas')))?>
                <div class="row">
                    <div class="col-xl-3 text-xl-left">
                        <label for="lugar" class="form-control-label">Tipo de operación*</label>
                    </div>
                    <?php $venta = array('Renta'=>'Renta','Venta'=>'Venta');?>
                    <?php echo $this->Form->input('operacion', array('label'=>false,'div' => 'col-md-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Seleccionar Operación', 'onchange' => 'cambio_precio();', 'required' => true))?>
                    <?php echo $this->Form->hidden('inmueble_id',array('value'=>$inmueble['Inmueble']['id']))?>
                    <?php echo $this->Form->hidden('desarrollo_id',array('value'=>$desarrollo_id))?>
                </div>
                <script>
                    function cambio_precio(){
                        if (document.getElementById("VentaOperacion").value == 'Venta'){
                            document.getElementById("VentaPrecioCerrado").value = '<?= $inmueble['Inmueble']['precio'] ?>';
                        }else{
                            document.getElementById("VentaPrecioCerrado").value = '<?= $inmueble['Inmueble']['precio_2'] ?>';
                        }
                    }
                </script>
                <div class="row">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Precio de cierre*</label>
                    </div>
                    <?php $precio = $inmueble['Inmueble']['venta_renta']=="Venta"?$inmueble['Inmueble']['precio']:$inmueble['Inmueble']['precio_2']?>
                    <?= $this->Form->input('precio_cerrado',array('value'=>$precio,'class'=>'form-control','placeholder'=>'Precio Cierre','div'=>'col-md-6 m-t-15','label'=>false, 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="estatus" class="form-control-label">Cambiar estado de propiedad*</label>
                    </div>
                    <?php
                        //$liberadas = array(2=>'Reservado',3=>'Contrato',4=>'Escrituración');
                        $liberadas = array(3=>'Contrato (Venta)')
                    ?>
                    <?php echo $this->Form->input('liberada', array('label'=>false,'div' => 'col-md-6 m-t-20','class'=>'form-control','type'=>'select','options'=>$liberadas,'empty'=>'Cambiar etapa de proceso', 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-3 text-xl-left mt-1">
                        <label for="lugar" class="form-control-label">Cliente*</label>
                    </div>
                    <?php echo $this->Form->input('cliente_id', array('label'=>false,'div' => 'col-md-6','class'=>'form-control chzn-select','type'=>'select','options'=>$clientes,'empty'=>'Seleccionar Cliente', 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-3 text-xl-left">
                        <label for="lugar" class="form-control-label">Asesor que cierra la venta*</label>
                    </div>
                    <?php echo $this->Form->input('user_id', array('label'=>false,'div' => 'col-md-6','class'=>'form-control chzn-select','type'=>'select','options'=>$usuarios,'empty'=>'Seleccionar Asesor', 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-3 text-xl-left">
                        <label for="fecha_venta" class="form-control-label">Fecha de la venta*</label>
                    </div>
                    <?php echo $this->Form->input('fecha_venta', array('label'=>false,'div' => 'col-md-6','class'=>'form-control fecha', 'placeholder'=>'dd-mm-yyyy', 'required' => true))?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event">
                    <i class="fa fa-plus"></i>
                    Registrar Venta
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<!-- Modal para agregar eventos -->
<?php 
    $bool = array(0=>'No',1=>'Si');
?>
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
            <?= $this->Form->create('Event',array('url'=>array('action'=>'add_check_lead','controller'=>'events')))?>
            <div class="modal-body">
                <div class="input-group">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="nombre_evento" class="form-control-label">Nuevo Evento*</label>
                    </div>
                    <?= $this->Form->input('nombre_evento',array('class'=>'form-control','placeholder'=>'Nuevo Evento','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Lugar</label>
                    </div>
                    <?= $this->Form->input('direccion',array('class'=>'form-control','placeholder'=>'Lugar','div'=>'col-md-6 m-t-15','label'=>false,))?>
                    <?php 
                        $colores = array(4=>'Llamada',3=>'Mail',5=>'Visita');
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
                    <?= $this->Form->input('fi',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
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
                    <?= $this->Form->input('ff',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
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

                    <?= $this->Form->input('cliente_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin cliente asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$clientes))?>
                    

                    <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="Inmueble" class="form-control-label">Propiedad</label>
                        </div>
                    <?= $this->Form->input('inmueble_id', array('value'=>$inmueble['Inmueble']['id'], 'type'=>'hidden')) ?>

                    <?= $this->Form->input('titulo_inmueble', array('type'=>'text','class'=>'form-control chzn-select','div'=>'col-md-9 m-t-15','label'=>false,'value'=>$inmueble['Inmueble']['titulo']))?>
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

<div class="modal fade" id="fotos" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-picture"></i>
                    Fotografías del inmueble
                </h4>
            </div>
            <div class="modal-body">
            <?php 
                foreach ($fotos_inmueble as $imagen):
            ?>
            <div class="col-lg-6 m-t-20">
                <div class="col-sm-12" style="height:200px;background-image: url('<?= Router::url('/', true).$imagen['FotoInmueble']['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;"  onclick="window.open('<?= Router::url('/',true).$imagen['FotoInmueble']['ruta']; ?>')">
                </div>
                <div class="col-xs-12">
                    <?= $imagen['FotoInmueble']['descripcion']?>
                </div>
            </div>
            <?php 
                endforeach;
            ?>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
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
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Propiedad Tipo
                </h4>
            </div>
        </div>
    </header>

    <div class="outer">
        <div class="inner bg-container">
            <!-- <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <pre>
                                <?php
                                    print_r($venta_inmueble);
                                ?>
                            </pre>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white"><?php 
                            if ($inmueble['Inmueble']['premium']==1){
                                echo $inmueble['Inmueble']['titulo']." / ".$inmueble['Inmueble']['referencia']."<i class='fa fa-certificate'></i>";
                            }else{
                                echo $inmueble['Inmueble']['titulo']." / ".$inmueble['Inmueble']['referencia'];
                            }
                            ?>
                            <div style="float:right">
                                <?php if ($this->Session->read('Permisos.Group.ie')==1){

                                    if ($inmueble['Inmueble']['vendido'] != 1) {
                                        echo $this->Html->link('<i class="fa fa-money fa-2x"></i>','#',array('data-target'=>"#venta",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','title'=>'REGISTRAR VENTA','escape'=>false,'style'=>'color:white'));
                                    }

                                    echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'edit_unidades',$inmueble['Inmueble']['id'],$desarrollo_id),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR PROPIEDAD','escape'=>false,'style'=>'color:white'));
                                }
                                echo $this->Html->link('<i class="fa fa-print fa-2x"></i>',array('action'=>'imprimir',$inmueble['Inmueble']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'IMPRIMIR PROPIEDAD','escape'=>false,'style'=>'color:white'));
                                echo $this->Html->link('<i class="fa fa-home fa-2x"></i>',array('action'=>'detalle',$inmueble['Inmueble']['id'],$this->Session->read('Auth.User.id')),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'VER FICHA TÉCNICA','escape'=>false,'style'=>'color:white'));
                                ?>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-header">
                                        <?php echo $inmueble['Inmueble']['calle']." ".$inmueble['Inmueble']['numero_exterior']."-".$inmueble['Inmueble']['numero_interior']." ".$inmueble['Inmueble']['colonia']?>
                                        <?php echo $inmueble['Inmueble']['ciudad']." ".$inmueble['Inmueble']['estado_ubicacion']." CP: ".$inmueble['Inmueble']['cp']?>
                                        <div style="float:right">
                                                    <!-- 
                                            Enlaces para compartir en Redes Sociales.
                                            Facebook:
                                            http://www.facebook.com/sharer.php?u= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI];
                                        -->
                                            <?php
                                              $shared_inmueble = Router::url('/Inmuebles/detalle/'.$inmueble['Inmueble']['id'],true);
                                            ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-facebook fa-lg"></i>',
                                                'http://www.facebook.com/sharer.php?u='.$shared_inmueble,
                                                array('escape'=>false, 'class'=>'rdsociales')
                                            )?>

                                            <?= $this->Html->link(
                                                '<i class="fa fa-twitter fa-lg"></i>',
                                                '#',
                                                array('escape'=>false, 'class'=>'rdsociales')
                                            )?>
                                            
                                            <?= $this->Html->link(
                                                '<i class="fa fa-google-plus fa-lg"></i>',
                                                'https://plus.google.com/u/0/share?url='.$shared_inmueble,
                                                array('escape'=>false, 'class'=>'rdsociales')
                                            )?>

                                            <?= $this->Html->link(
                                                '<i class="fa fa-linkedin fa-lg"></i>',
                                                'https://www.linkedin.com/shareArticle?url='.$shared_inmueble,
                                                array('escape'=>false, 'class'=>'rdsociales')
                                            )?>
                                        </div>
                                    </div>
                                    <!-- div card-header  -->
                                </div>
                            </div>
                            <!-- End row card-header -->

                            <div class="row mt-1">
                                <div class="col-sm-12 col-lg-4">
                                    <?php $foto = (isset($fotos_inmueble[0]['FotoInmueble'])?$fotos_inmueble[0]['FotoInmueble']['ruta']:'/img/inmueble_no_photo.png')?>
                                    <div class="col-sm-12" style="height:35vh;background-image: url('<?= Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$fotos_inmueble[0]['FotoInmueble']['ruta']; ?>')">
                                        <?php if ($inmueble['Inmueble']['vendido']==1){?>
                                            <span class="sale" style="/*! width: 500px; */background-color: green; color: white;padding: 5px;">$ Vendido</span>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-12" style="text-align:center;">
                                            <h3><font color="black">Características Generales</font></h3>
                                        </div>
                                        <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                            <?= $this->Html->image('m2.png',array('width'=>'70%'))?>
                                            <p><?= $inmueble['Inmueble']['construccion']+$inmueble['Inmueble']['construccion_no_habitable']?></p>
                                        </div>
                                        <div class="col-lg-3 col-xs-6"  style="text-align:center;">
                                            <?= $this->Html->image('recamaras.png',array('width'=>'70%'))?>
                                            <p><?= $inmueble['Inmueble']['recamaras']?></p>
                                        </div>
                                        <div class="col-lg-3 col-xs-6"  style="text-align:center;">
                                            <?= $this->Html->image('banios.png',array('width'=>'70%'))?>
                                            <p><?= $inmueble['Inmueble']['banos']?><?= ($inmueble['Inmueble']['medio_banos']==0||$inmueble['Inmueble']['medio_banos']==""?"":" y ".$inmueble['Inmueble']['medio_banos']." medios baños")?></p>
                                        </div>
                                        <div class="col-lg-3 col-xs-6" style="text-align:center;">
                                            <?= $this->Html->image('autos.png',array('width'=>'70%'))?>
                                            <p><?= $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12" style="text-align:center;">
                                            <h3><font color="black">GALERÍA MULTIMEDIA</font></h3>
                                        </div>
                                        <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                            <div class="row">
                                                <div class="col-sm-12"> GALERÍA </div>
                                                <a href="#" data-toggle="modal" data-target="#fotos" id="target-modal">
                                                    <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true).$foto ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover;" >
                                                    </div>
                                                </a>
                                                <div class="col-sm-12">
                                                    <small><?= sizeof($fotos_inmueble)." Fotos"?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-3" style="background: #f5f5f5;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-sm" id="table-especial">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                                if ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                                                    echo "Precio Venta:";
                                                                }
                                                                if ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                                                    echo "</br>Precio Renta:";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="float-xs-right fw-600">
                                                            <?php 
                                                                if ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                                                    echo "$".number_format($inmueble['Inmueble']['precio'],2);
                                                                }
                                                                if ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                                                    echo "</br> $".number_format($inmueble['Inmueble']['precio_2'],2);
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Renta / Venta:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= $inmueble['Inmueble']['venta_renta']?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tipo de Propiedad:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= $inmueble['TipoPropiedad']['tipo_propiedad']?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estado:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= ($inmueble['Inmueble']['estado']==""?"&nbsp;":$inmueble['Inmueble']['estado'])?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Comisión:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= ($inmueble['Inmueble']['comision']==""?"No / 0%":$inmueble['Inmueble']['comision']."%")?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Comparte:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= ($inmueble['Inmueble']['compartir']==""?"No / 0 %":"Si / ".$inmueble['Inmueble']['compartir']."%")?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Horario de Atención</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= ($desarrollo['Desarrollo']['horario_contacto']==""?"&nbsp;":$desarrollo['Desarrollo']['horario_contacto'])?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- <div class="col-xs-7 col-lg-7" style="line-height: 12px;">
                                            <?php 
                                                if ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                                    echo "<p>Precio Venta:</p>";
                                                }
                                                if ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                                    echo "<p>Precio Renta:</p>";
                                                }
                                            ?>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!-- End row caracteristicas generales. -->

                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <ul class="nav nav-tabs card-header-tabs float-xs-left">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#tab1" data-toggle="tab" aria-expanded="true">Descripción General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#tab2" data-toggle="tab" aria-expanded="false">Características, Amenidades y Servicios</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12">
                                    <div class="tab-content text-justify">
                                        <div class="tab-pane active" id="tab1" aria-expanded="true">
                                            <p class="card-text mt-3">
                                                <?php echo $inmueble['Inmueble']['comentarios'];?>    
                                            </p>
                                        </div>
                                        <div class="tab-pane" id="tab2" aria-expanded="false">
                                            <p class="card-text mt-3">
                                                <div class="col-sm-12">
                                                    <h4 class="text-black"><b>Características</b></h4>
                                                    <?php if ($inmueble['Inmueble']['frente_fondo']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Frente x Fondo: ".$inmueble['Inmueble']['frente_fondo']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if ($inmueble['Inmueble']['construccion']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Superficie Habitable: ".$inmueble['Inmueble']['construccion']."m<sup>2</sup>"?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if ($inmueble['Inmueble']['construccion_no_habitable']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Superficie No Habitable: ".$inmueble['Inmueble']['construccion_no_habitable']."m<sup>2</sup>"?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if ($inmueble['Inmueble']['banos']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Baños Completos: ".$inmueble['Inmueble']['banos']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if ($inmueble['Inmueble']['medio_banos']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Medios Baños: ".$inmueble['Inmueble']['medio_banos']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if ($inmueble['Inmueble']['estacionamiento_techado']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Estacionamientos Techados: ".$inmueble['Inmueble']['estacionamiento_techado']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if ($inmueble['Inmueble']['estacionamiento_descubierto']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Estacionamientos Descubiertos: ".$inmueble['Inmueble']['estacionamiento_descubierto']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php 
                                                    if ($inmueble['Inmueble']['nivel_propiedad']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Nivel de la propiedad: ".$inmueble['Inmueble']['nivel_propiedad']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    if ($inmueble['Inmueble']['niveles_totales']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Niveles Totales: ".$inmueble['Inmueble']['niveles_totales']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    if ($inmueble['Inmueble']['unidades_totales']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Unidades Totales: ".$inmueble['Inmueble']['unidades_totales']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    if ($inmueble['Inmueble']['disposicion']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Disposición: ".$inmueble['Inmueble']['disposicion']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    if ($inmueble['Inmueble']['orientacion']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Orientación: ".$inmueble['Inmueble']['orientacion']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                </div>
                                                <div class="col-sm-12 m-t-20">
                                                    <h4 class ="text-black"><b>Amenidades</b></h4>
                                                        <?php echo ($inmueble['Inmueble']['alberca_sin_techar']      == 1 ? '<div class="col-lg-4">Alberca descubierta</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['alberca_techada']         == 1 ? '<div class="col-lg-4">Alberca Techada</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['sala_cine']               == 1 ? '<div class="col-lg-4">Área de Cine</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['area_juegos']             == 1 ? '<div class="col-lg-3">Área de Juegos</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['juegos_infantiles']       == 1 ? '<div class="col-lg-4">Área de Juegos Infantiles</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['area_lavado']             == 1 ? '<div class="col-lg-4">Área de lavado</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['fumadores']               == 1 ? '<div class="col-lg-4">Área para fumadores</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['areas_verdes']            == 1 ? '<div class="col-lg-4">Áreas Verdes</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['asador']                  == 1 ? '<div class="col-lg-4">Asador</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['balcon']                  == 1 ? '<div class="col-lg-4">Balcón / Terraza</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['business_center']         == 1 ? '<div class="col-lg-4">Business Center</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['cafeteria']               == 1 ? '<div class="col-lg-4">Cafetería</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['golf']                    == 1 ? '<div class="col-lg-4">Campo de Golf</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['paddle_tennis']           == 1 ? '<div class="col-lg-4">Cancha de Paddle</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['squash']                  == 1 ? '<div class="col-lg-4">Cancha de Squash</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['cancha_tenis']            == 1 ? '<div class="col-lg-4">Cancha de Tennis</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['cantina_cava']            == 1 ? '<div class="col-xs-3">Cantina / Cava</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['carril_nado']             == 1 ? '<div class="col-lg-4">Carril de Nado</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['chimenea']                == 1 ? '<div class="col-lg-4">Chimenea</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['cocina_integral']         == 1 ? '<div class="col-lg-4">Cocina Integral</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['closets']                 == 1 ? '<div class="col-lg-4">Closets</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['closet_blancos']          == 1 ? '<div class="col-lg-4">Closet de Blancos</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['cuarto_servicio']         == 1 ? '<div class="col-lg-4">Cuarto / Baño de Servicio</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['estudio']                 == 1 ? '<div class="col-lg-4">Estudio</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['desayunador_antecomedor'] == 1 ? '<div class="col-lg-4">Desayunador / Antecomedor</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['fire_pit']                == 1 ? '<div class="col-lg-4">Fire Pit</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['gimnasio']                == 1 ? '<div class="col-lg-4">Gimnasio</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['jardin_privado']          == 1 ? '<div class="col-lg-4">Jardín / Patio Privado</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['jacuzzi']                 == 1 ? '<div class="col-lg-4">Jacuzzi</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['living']                  == 1 ? '<div class="col-lg-4">Living</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['lobby']                   == 1 ? '<div class="col-lg-4">Lobby</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['boliche']                 == 1 ? '<div class="col-lg-4">Mesa de Boliche</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['patio_servicio']          == 1 ? '<div class="col-lg-4">Patio de Servicio</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['pista_jogging']           == 1 ? '<div class="col-lg-4">Pista de Jogging</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['play_room']               == 1 ? '<div class="col-lg-4">Play Room / Cuarto de Juegos</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['restaurante']             == 1 ? '<div class="col-lg-4">Restaurante</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['roof_garden_compartido']  == 1 ? '<div class="col-lg-4">Roof Garden</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['sala_tv']                 == 1 ? '<div class="col-lg-4">Sala de TV</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['salon_juegos']            == 1 ? '<div class="col-lg-4">Salón de Juegos</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['salon_multiple']          == 1 ? '<div class="col-lg-4">Salón de usos múltiples</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['sauna']                   == 1 ? '<div class="col-lg-4">Sauna</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['spa']                     == 1 ? '<div class="col-lg-4">Spa</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['sky_garden']              == 1 ? '<div class="col-lg-4">Sky Garden</div>' : "") ?>
                                                        <?php echo ($inmueble['Inmueble']['tina_hidromasaje']        == 1 ? '<div class="col-lg-4">Tina de Hidromasaje</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['vapor']                   == 1 ? '<div class="col-lg-4">Vapor</div>': "")?>
                                                        <?php echo ($inmueble['Inmueble']['vestidores']              == 1 ? '<div class="col-lg-4">Vestidores</div>': "")?>
                                                    </div>
                                                <div class="col-sm-12 m-t-20">
                                                    <h4 class="text-black"><b>SERVICIOS</b></h4>
                                                    <?php echo ($inmueble['Inmueble']['acceso_discapacitados']      == 1 ? '<div class="col-lg-4">Acceso de discapacitados</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['agua_corriente']             == 1 ? '<div class="col-lg-4">Agua Corriente</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['amueblado']                  == 1 ? '<div class="col-lg-4">Amueblado</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['internet']                   == 1 ? '<div class="col-lg-4">Acceso Internet / WiFi</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['tercera_edad']               == 1 ? '<div class="col-lg-4">Acceso para Tercera Edad</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['aire_acondicionado']         == 1 ? '<div class="col-lg-4">Aire Acondicionado</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['bodega']                     == 1 ? '<div class="col-lg-4">Bodega</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['boiler']                     == 1 ? '<div class="col-lg-4">Boiler / Calentador de Agua</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['calefaccion']                == 1 ? '<div class="col-lg-4">Calefacción</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['cctv']                       == 1 ? '<div class="col-lg-4">CCTV</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['conmutador']                 == 1 ? '<div class="col-lg-4">Conmutador</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['interfon']                   == 1 ? '<div class="col-lg-4">Interfón</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['edificio_inteligente']       == 1 ? '<div class="col-lg-4">Edificio Inteligente</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['edificio_leed']              == 1 ? '<div class="col-lg-4">Edificio LEED</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['elevador']                   == 1 ? '<div class="col-lg-4">Elevadores</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-4">Estacionamiento de visitas</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['gas_lp']                     == 1 ? '<div class="col-lg-4">Gas LP</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['gas_natural']                == 1 ? '<div class="col-lg-4">Gas Natural</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['lavavajillas']               == 1 ? '<div class="col-lg-4">Lavavajillas</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['lavanderia']                 == 1 ? '<div class="col-lg-4">Lavanderia</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['linea_telefonica']           == 1 ? '<div class="col-lg-4">Línea Telefónica</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['locales_comerciales']        == 1 ? '<div class="col-lg-4">Locales Comerciales</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['mascotas']                   == 1 ? '<div class="col-lg-4">Permite Mascotas</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['planta_emergencia']          == 1 ? '<div class="col-lg-4">Planta de Emergencia</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['porton_electrico']           == 1 ? '<div class="col-lg-4">Portón Eléctrico</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['refrigerador']               == 1 ? '<div class="col-lg-4">Refrigerador</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['sistema_incendios']          == 1 ? '<div class="col-lg-4">Sistema Contra Incendios</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['sistema_seguridad']          == 1 ? '<div class="col-lg-4">Sistema de Seguridad</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['valet_parking']              == 1 ? '<div class="col-lg-4">Valet Parking</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['vigilancia']                 == 1 ? '<div class="col-lg-4">Vigilancia / Seguridad</div>' : "") ?>
                                                </div>
                                            </p>
                                        </div>
                                        <!-- /Segundo panel -->
                                    </div>
                                </div>
                            </div>
                            <!-- ./ End row caracteristicas -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row one -->
            
            <?php
                $class_card = 'col-sm-12';
                if ($inmueble['Inmueble']['vendido'] == 1) {
                    $class_card = 'col-sm-12 col-lg-6';
                }
            ?>
            <div class="row mt-2">
                <div class="<?= $class_card ?>">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Agregar Evento
                        </div>
                        <div class="card-block">
                            <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus"></i> Agregar Evento
                                     </a>
                        </div>
                    </div>
                </div>
                <?php if ($inmueble['Inmueble']['vendido'] == 1): ?>
                    <div class="<?= $class_card ?>">
                        <div class="card">
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        Informaciónde venta
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <a class="pointer text-white align-lg-right"><i class="fa fa-trash fa-lg" onclick="DeleteSale(<?= $venta_inmueble['Venta']['id']?>);"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Nombre del cliente:</td>
                                                    <td class="float-xs-right"><ins><?= $this->Html->link($venta_inmueble['Cliente']['nombre'], array('controller'=>'clientes', 'action'=>'view', $venta_inmueble['Cliente']['id'])) ?></ins></td>
                                                </tr>
                                                <tr>
                                                    <td>Nombre del aseso:r</td>
                                                    <td class="float-xs-right"><ins><?= $this->Html->link($venta_inmueble['User']['nombre_completo'], array('controller'=>'users', 'action'=>'view', $venta_inmueble['User']['id'])); ?></ins></td>
                                                </tr>
                                                <tr>
                                                    <td>Fecha de venta:</td>
                                                    <td class="float-xs-right"><?= date('d-m-Y',strtotime($venta_inmueble['Venta']['fecha'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Monto de la venta:</td>
                                                    <td class="float-xs-right">$ <?= number_format($venta_inmueble['Venta']['precio_cerrado']) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <!-- ./End row two -->

            <div class="row mt-2">
                <div class="col-sm-12 col-lg-3">
                    <div class="card">
                        <div class="card-header"  style="background-color: #2e3c54; color:white">
                            Personas Interesadas
                        </div>
                        <div class="card-block cards_section_margin">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget_icon_bgclr icon_align bg-white section_border">
                                        <div class="bg_icon bg_icon_info float-xs-left">
                                            <i class="fa fa-heart-o text-info" aria-hidden="true"></i>
                                        </div>
                                        <div class="text-xs-right">
                                            <h3 class="kpi"><?= $interesados?></h3>
                                            <p>Interesados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Personas Interesadas
                        </div>
                        <div class="card-block cards_section_margin">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget_icon_bgclr icon_align bg-white section_border">
                                        <div class="bg_icon bg_icon_info float-xs-left">
                                            <i class="fa fa-heart-o text-info" aria-hidden="true"></i>
                                        </div>
                                        <div class="text-xs-right">
                                            <h3 class="kpi"><?= $interesados?></h3>
                                            <p>Interesados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Llamadas
                        </div>
                        <div class="card-block cards_section_margin">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget_icon_bgclr icon_align bg-white section_border">
                                        <div class="bg_icon bg_icon_info float-xs-left">
                                            <i class="fa fa-phone text-info" aria-hidden="true"></i>
                                        </div>
                                        <div class="text-xs-right">
                                            <h3 class="kpi"><?= $llamadas?></h3>
                                            <p>Llamadas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            E-mails
                        </div>
                        <div class="card-block cards_section_margin">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget_icon_bgclr icon_align bg-white section_border">
                                        <div class="bg_icon bg_icon_info float-xs-left">
                                            <i class="fa fa-envelope text-info" aria-hidden="true"></i>
                                        </div>
                                        <div class="text-xs-right">
                                            <h3 class="kpi"><?= $emails?></h3>
                                            <p>E-mails Enviados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row three -->

            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header" style="background: #2e3c54; color: white;">
                            Formas de contacto: Total: <?= sizeof($contactos) ?> contactos
                        </div>
                        <div class="card-block">
                            <div class="col-lg-12">
                                <div class="demo-container">
                                    <div id="grafica_contactos"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Cambio en precios
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:340px !important">
                                <div class="col-lg-12">
                                <div id="grafica_precios"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row four -->
            <div class="row mt-2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Ubicación del inmueble
                        </div>
                        <div class="card-block twitter_section" style="overflow-y: scroll; height:340px !important">
                            <div id="map"></div>
                                <?php
                            if ($inmueble['Inmueble']['google_maps']!=""){
                            list($latitud, $longitud) = explode(",", $inmueble['Inmueble']['google_maps']);
                        ?>
                                <script>
                                  function initMap() {
                                    var uluru = {lat: <?= $latitud?>, lng: <?= $longitud?>};
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                      zoom: 16,
                                      center: uluru
                                    });
                                    var marker = new google.maps.Marker({
                                      position: uluru,
                                      map: map
                                    });
                                  }
                                </script>
                                
                                <script async defer
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOf3eYcnrP8hgEx5_914fUwMR1NCyQPfw&callback=initMap">
                                </script> 
                                 <?php }else{
                                     echo ("Sin coordenadas");
                                 }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row five -->
            
            <div class="row mt-2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Lista de Posibles clientes
                        </div>
                        <div class="card-block" >
                            <div class="col-lg-12">
                                <table id="example1" class="table">
                                    <thead>
                                        <tr>
                                            <th>Temp</th>
                                            <th>Nombre</th>
                                            <th>Correo Electrónico</th>
                                            <th>Teléfono</th>
                                            <th>Estatus Cliente</th>
                                            <th>Etapa de Lead</th>
                                            <th>Fecha de Creación</th>
                                            <th>Asesor</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php foreach ($leads as $lead):?>
                                    <tr>
                                        <?php 
                                            switch ($lead['Cliente']['temperatura']){
                                                case 1:
                                                    $temp = 'F'; $class_temp = 'bg_frio'; $name_temp = 'Frio';;
                                                    break;
                                                case 2:
                                                    $temp ='T'; $class_temp = 'bg_tibio'; $name_temp = 'Tibio';
                                                    break;
                                                case 3:
                                                    $temp ='C'; $class_temp = 'bg_caliente'; $name_temp = 'Caliente';
                                                    break;
                                                case 4:
                                                    $temp ='V'; $class_temp = 'bg_venta'; $name_temp = 'Venta';
                                                    break;
                                                default:
                                                    echo "<td>&nbsp;</td>";
                                                    break;
                                            }
                                        ?>
                                        <td>
                                            <small class="<?= $class_temp ?>"><?= $temp ?> <span style="display: none;"><?= $name_temp ?></span></small>
                                        </td>
                                        <td><?= $this->Html->link($lead['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$lead['Cliente']['id']))?></td>
                                        <td ><?php echo $lead['Cliente']['correo_electronico']?></td>
                                        <td ><?php echo $lead['Cliente']['telefono1']?></td>
                                        <td ><?php echo $lead['Cliente']['status']?></td>
                                        <td ><?php echo $lead['Lead']['status']?></td>
                                        <td ><?php echo date_format(date_create($lead['Cliente']['created']),"d-M-Y")?></td>
                                        <td ><?php echo $usuarios[$lead['Cliente']['user_id']]?></td>
                                    </tr>
                                        <?php endforeach;?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row six -->

            <div class="row mt-2">
                <div class="col-lg-4 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Archivos Anexos
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:400px !important">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="80%"><b>Archivo</b></th>
                                    <th width="20%"><b>Descargar</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                   <?php foreach ($inmueble['DocumentosUser'] as $documento):?>
                                        <tr>
                                            <td><?= $documento['documento']?></td>
                                            <td><?= $this->Html->link(
                                                    '<i class="fa fa-download"></i>',
                                                    $documento['ruta'],
                                                    array('escape'=>false)
                                                    )?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Eventos de Hoy
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:400px !important">
                            <?php foreach ($inmueble['Evento'] as $evento):?>
                            <a href="#" class="list-group-item calendar-list">
                                <div class="tag tag-pill tag-primary float-xs-right"><?= date('H:i',  strtotime($evento['fecha_inicio']))?></div>
                                <?= $evento['nombre_evento']?>
                                <small><?= $usuarios[$evento['user_id']]?></small>
                            </a>
                            <?php endforeach;?>
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            actividades
                        </div>
                        <div class="card-block twitter_section" style="overflow-y: scroll; height:400px !important">
                            <ul id="nt-example1">
                               <?php foreach ($inmueble['Log'] as $log):?>
                                <li>
                                    <div class="row">
                                        <div class="col-xs-2 col-lg-3 col-xl-2">
                                            <?php
                                                $imagen = "";
                                                switch ($log['accion']){
                                                    case (1):
                                                        $imagen = "<i class='fa fa-plus fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (2) :
                                                        $imagen = "<i class='fa fa-pencil fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (3) :
                                                        $imagen = "<i class='fa fa-calendar fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (4) :
                                                        $imagen = "<i class='fa fa-phone fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (5) :
                                                        $imagen = "<i class='fa fa-envelope fa-2x' style='color:green'></i>";
                                                        break;
                                                    default :
                                                        $imagen = "<i class='fa fa-dot-circle-o fa-2x' style='color:green'></i>";
                                                        break;
                                                }
                                            ?>
                                            <?= $imagen;?>
                                            
                                        </div>
                                        <div class="col-xs-10 col-lg-9 col-xl-10">
                                            <span class="name"><?= $usuarios[$log['usuario_id']]?></span> <span
                                                class="time"><?= $log['fecha']?></span>
                                            <br>
                                            <span class="msg"><?= $log['mensaje']?></span>
                                            
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <?php endforeach;?>
                            </ul>
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

        'https://www.gstatic.com/charts/loader.js',

        // 'vendors/swiper/js/swiper.min',
        
        
        '/vendors/slimscroll/js/jquery.slimscroll.min',
        '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
        '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
        '/vendors/moment/js/moment.min',
        '/vendors/fullcalendar/js/fullcalendar.min',
        '/vendors/countUp.js/js/countUp.min',
        '/vendors/swiper/js/swiper.min',
        // '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
        
        '/vendors/flotchart/js/jquery.flot',
        '/vendors/flotchart/js/jquery.flot.resize',
        '/vendors/flotchart/js/jquery.flot.stack',
        '/vendors/flotchart/js/jquery.flot.time',
        '/vendors/flotspline/js/jquery.flot.spline.min',
        '/vendors/flotchart/js/jquery.flot.categories',
        '/vendors/flotchart/js/jquery.flot.pie',
        // '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
        
        '/vendors/raphael/js/raphael-min',
        '/vendors/d3/js/d3.min',
        '/vendors/c3/js/c3.min',
        '/vendors/toastr/js/toastr.min',
        '/vendors/switchery/js/switchery.min',
        '/vendors/jquery_newsTicker/js/newsTicker',
        '/vendors/countUp.js/js/countUp.min',
        
        '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
        '/vendors/moment/js/moment.min',
        '/vendors/fullcalendar/js/fullcalendar.min',
        
        '/vendors/holderjs/js/holder',
        '/vendors/fancybox/js/jquery.fancybox.pack',
        '/vendors/fancybox/js/jquery.fancybox-buttons',
        '/vendors/fancybox/js/jquery.fancybox-thumbs',
        '/vendors/fancybox/js/jquery.fancybox-media',
        'pages/gallery',
        '/vendors/datepicker/js/bootstrap-datepicker.min',

        // Chozen select
        // 'pages/form_elements',
        '/vendors/chosen/js/chosen.jquery',
        // 'form',

        // Datatables
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
        'pages/simple_datatables',

    ], array('inline'=>false));
?>
<script>
// Load the Visualization API and the corechart package.
              google.charts.load('current', {'packages':['corechart']});
              
              // Set Callback Forma de contacto
              google.charts.setOnLoadCallback(drawFormasContacto);
//            // Set Callback Precios  
              google.charts.setOnLoadCallback(drawPrecios);


              // Callback that creates and populates a data table,
              // instantiates the pie chart, passes in the data and
              // draws it.
              function drawFormasContacto() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Línea de Contacto');
                data.addColumn('number', 'Personas');
                data.addRows([
                  <?php foreach ($contactos as $contacto):?>
                    ['<?= $contacto['dic_linea_contactos']['linea_contacto']?>',<?= $contacto[0]['total']?>],
                  <?php endforeach;?>
                ]);

                // Set chart options
                var options = {'width':"100%",
                               'height':300};

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('grafica_contactos'));
                chart.draw(data, options);
              }
              
            function drawPrecios() {
                var data = google.visualization.arrayToDataTable([
                ['Fecha', 'Precio'],
                <?php 
                    if (sizeof($inmueble['Precio'])>0){
                        foreach ($inmueble['Precio'] as $precio): ?>
                            ['<?= date('d-M-Y', strtotime($precio['fecha']))?>',  <?= $precio['precio']?>],
                        <?php 
                        endforeach;
                    }else{
                        ?>
                        ['<?=date('d-m-Y', strtotime($inmueble['Inmueble']['fecha']))?>',<?=$inmueble['Inmueble']['precio']?>]
                    <?php }
                  ?>  
              ]);

              var options = {
                title: 'Cambio de precios',
                hAxis: {title: 'Fecha'},
                vAxis: {title: 'Precio'},
                legend: 'none',
                'width':"100%",
                'height':300
              };

              var chart = new google.visualization.ScatterChart(document.getElementById('grafica_precios'));

              chart.draw(data, options);

            }


function DeleteSale(id){
    $("#moda_delete_sale").modal('show')
    document.getElementById("VentaId").value = id;
}

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
  
});
</script>