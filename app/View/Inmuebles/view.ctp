<?php  $fecha_actual = date('d-m-Y'); ?>
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

            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/css/jquery.tagsinput',
            '/vendors/daterangepicker/css/daterangepicker',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
             '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
             '/vendors/bootstrap-switch/css/bootstrap-switch.min',
             '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/datetimepicker/css/DateTimePicker.min',
            '/vendors/j_timepicker/css/jquery.timepicker',
      'pages/colorpicker_hack',

        ),
        array('inline'=>false)); 
?>
<style>

    h4{
        color: #000;
    }

    .estado1{
        background-color: #ceeefd;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado2{
        background-color: #6bc7f2;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado3{
        background-color: #f4e6c5;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado4{
        background-color: #f0ce7e;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado5{
        background-color: #f08551;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado6{
        background-color: #ee5003;
        color: white;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado7{
        background-color: #3ed21f;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

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
    .disabled {
        background-color: transparent !important;
    }
</style>

<?= $this->element('Desarrollos/operaciones_inmueble'); ?>

<div class="modal fade" id="publicidad" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-line-chart"></i>
                    Registrar campaña
                </h4>
            </div>
            <?= $this->Form->create('Publicidad',array('url'=>array('action'=>'add_inmueble','controller'=>'publicidads')))?>
                <div class="modal-body">
                    
                    <div class="row form-group">
                        <?= $this->Form->input('dic_linea_contacto_id',
                            array(
                                'class'   => 'form-control chzn-select',
                                'label'   => 'Medio de promoción*',
                                'div'     => 'col-sm-12 col-lg-12',
                                'options' => $lineas_contactos,
                                'empty'   => 'Seleccione una opción'
                            )
                        ); ?>

                    </div>

                    <div class="row form-group">

                        <?= $this->Form->input('fecha_inicio',
                            array(
                                  'class'        => 'form-control fecha',
                                  'label'        => 'Fecha de inicio*',
                                  'div'          => 'col-sm-12 col-lg-6',
                                  'required'     => true,
                                  'autocomplete' => false,
                                  'type'         => 'text'
                            )
                        ); ?>
                        
                        <div class="col-sm-12 col-lg-6">
                            <label class="form-control-label">Inversión prevista*</label>
                            <div class="input-group">
                                <span class="input-group-addon"  style="background: transparent; border-right-style: none !important;">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <?= $this->Form->input('inversion_prevista', array('label' => false, 'div' => false, 'class'=> 'form-control','onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 'onkeyup' => 'totInversion()',)) ?>
                            </div>
                        </div>

                    </div>

                    <div class="row form-group">
                        
                        <?= $this->Form->input('meses',
                            array(
                                'class'    => 'form-control chzn-select',
                                'label'    => 'Meses activos de la publicidad*',
                                'div'      => 'col-sm-12 col-lg-6',
                                'options'  => $inversion_meses,
                                'onchange' => 'totInversion()',
                                'empty'    => 'Seleccione una opción'
                            )
                        ); ?>

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-control-label" id="LabelUserPassword">Total de inversión</label>
                            <div class="input-group">
                                <span class="input-group-addon"  style="background: transparent; border-right-style: none !important;">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <?= $this->Form->input('tot_inversion', array('label' => false, 'div' => false, 'class'=> 'form-control disabled', 'disabled' => true )) ?>
                            </div>
                        </div>
                    </div>
                            
                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right">
                        Registrar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <?= $this->Form->hidden('inmueble_id', array('value'=>$inmueble['Inmueble']['id'])); ?>
        <?= $this->Form->end()?>
    </div>
</div>

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
                echo $this->Form->hidden('inmueble_id', array('value'=>$inmueble['Inmueble']['id']));
                echo (!empty($desarrollo['Desarrollos']['id']) ? $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollos']['id'])) : '');
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
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">
                    <i class="fa fa-picture"></i>
                    Registrar venta de la propiedad
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Venta',array('url'=>array('action'=>'add','controller'=>'ventas')))?>
                <div class="row">
                    <div class="col-xl-4 text-xl-left">
                        <label for="lugar" class="form-control-label">Tipo de operación*</label>
                    </div>
                    <?php $venta = array('Renta'=>'Renta','Venta'=>'Venta');?>
                    <?php echo $this->Form->input('operacion', array('label'=>false,'div' => 'col-md-8','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Seleccionar Operación', 'onchange' => 'cambio_precio();', 'required' => true))?>
                    <?php echo $this->Form->hidden('inmueble_id',array('value'=>$inmueble['Inmueble']['id']))?>
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
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Precio de cierre*</label>
                    </div>
                    <?php $precio = $inmueble['Inmueble']['venta_renta']=="Venta"?$inmueble['Inmueble']['precio']:$inmueble['Inmueble']['precio_2']?>
                    <?= $this->Form->input('precio_cerrado',array('class'=>'form-control','placeholder'=>'Precio Cierre','div'=>'col-md-8 m-t-15','label'=>false, 'required' => true, 'min' => 0 ))?>
                </div>
                <div class="row">
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="estatus" class="form-control-label">Cambiar estado de propiedad*</label>
                    </div>
                    <?php
                        //$liberadas = array(2=>'Reservado',3=>'Contrato',4=>'Escrituración');
                        $liberadas = array(3=>'Contrato (Venta)', 4=>'Escrituración')
                    ?>
                    <?php echo $this->Form->input('liberada', array('label'=>false,'div' => 'col-md-8 m-t-20','class'=>'form-control','type'=>'select','options'=>$liberadas,'empty'=>'Cambiar etapa de proceso', 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-4 text-xl-left mt-1">
                        <label for="lugar" class="form-control-label">Cliente*</label>
                    </div>
                    <?php echo $this->Form->input('cliente_id', array('label'=>false,'div' => 'col-md-8','class'=>'form-control chzn-select','type'=>'select','options'=>$clientes_venta,'empty'=>'Seleccionar Cliente', 'required' => true))?>
                </div>
                <div class="row mt-1">
                    <div class="col-xl-4 text-xl-left">
                        <label for="lugar" class="form-control-label">Asesor que cierra la venta*</label>
                    </div>
                    <?php echo $this->Form->input('user_id', array('label'=>false,'div' => 'col-md-8','class'=>'form-control chzn-select','type'=>'select','options'=>$usuarios,'empty'=>'Seleccionar Asesor', 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-4 text-xl-left">
                        <label for="fecha_venta" class="form-control-label">Fecha de la venta*</label>
                    </div>
                    <?php echo $this->Form->input('fecha_venta', array('label'=>false,'div' => 'col-md-8','class'=>'form-control fecha_venta', 'placeholder'=>'dd-mm-yyyy', 'required' => true, 'autocomplete'=> 'off'))?>
                </div>
                <div class="row mt-1">

                    <?= $this->Form->input('retorno2', array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>array(1=>'Agregar factura inmediatamente', 2=>'Posponer la creación de la factura'), 'label'=>'Realización de factura'));?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success float-xs-right" id="add-new-event">
                    Registrar Venta
                </button>
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cerrar
                </button>
            </div>

            <?= $this->Form->hidden('retorno', array('value'=>2));?>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<!-- Modal para agregar eventos -->
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
                <?php foreach ($inmueble['FotoInmueble'] as $imagen):?>
                <div class="col-lg-6 m-t-20">
                    <div class="col-sm-12" style="height:200px;background-image: url('<?= Router::url('/', true).$imagen['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$imagen['ruta']; ?>')">
                    </div>
                    <div class="col-xs-12">
                        <?= $imagen['descripcion']?>
                    </div>
                </div>
                <?php endforeach; ?>
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
                <h4 class="nav_top_align text-white">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Inmuebles
                </h4>
            </div>
        </div>
    </header>

    <div class="outer">
        <div class="inner bg-container">
            
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

                                    if ($this->Session->read('Permisos.Group.ilib') == 1 && $tipo['liberada'] != 4):

                                            // 0=> Bloqueada, 1=> Libre, 2=> Reservado, 3=> Contrato, 4=> Escrituracion, 5=> Baja
                                            switch( $inmueble['Inmueble']['liberada']  ) {
                                                case 1:
                                                    echo "<i class='fa fa-calendar fa-lg pointer' onclick='showModalProcesoInmuebles(2, ".$inmueble['Inmueble']['id'].")' style = 'margin-right:5px' data-toggle ='tooltip' data-placement='top' title='Apartados / Reservados' ></i>";
                                                    
                                                break;
            
                                                case 2:
                                                    // Vende
                                                    echo "<i class='fa fa fa-dollar fa-lg pointer' onclick='showModalProcesoInmuebles(3, ".$inmueble['Inmueble']['id'].")' style = 'margin-right:5px' data-toggle ='tooltip' data-placement='top' title='Vendido / Contrato' ></i>";
            
                                                break;
            
                                                case 3:
                                                    // Escrituracion
                                                    echo "<i class='fa fa fa-key fa-lg pointer' onclick='showModalProcesoInmuebles(4, ".$inmueble['Inmueble']['id'].")' style = 'margin-right:5px' data-toggle ='tooltip' data-placement='top' title='Escriturado' ></i>";
            
                                                break;
                                            }
                                        
                                        
                                    endif;


                                    echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'add',$inmueble['Inmueble']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR PROPIEDAD','escape'=>false,'style'=>'color:white'));
                                    }

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
                            <div class="col-lg-4">
                                    <?php $foto = (isset($inmueble['FotoInmueble'][0])?$inmueble['FotoInmueble'][0]['ruta']:'/img/inmueble_no_photo.png')?>
                                    
                                    <div class="col-sm-12" style="height:35vh;background-image: url('<?= Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$foto; ?>')">
                                        <?php if ($inmueble['Inmueble']['vendido']==1){?>
                                            <span class="sale" style="/*! width: 500px; */background-color: green;color: white;padding: 5px;">$ Vendido</span>
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
                                                    <small><?= sizeof($inmueble['FotoInmueble'])." Fotos"?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                            <div class="col-sm-12">
                                                BROCHURE
                                            </div>
                                            <?php 
                                            $img_brochure="";
                                            if($inmueble['Inmueble']['brochure']!=""){
                                                $img_brochure='brochure.png';
                                            }else{
                                                $img_brochure='no_brochure.png';
                                            }
                                            ?>
                                            <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true).'/img/'.$img_brochure; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?php echo ($inmueble['Inmueble']['brochure']==""?"#": Router::url('/', true).$inmueble['Inmueble']['brochure'])?>')">
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <small><?= ($inmueble['Inmueble']['brochure']==""?"No":"1 Archivo")?></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                            <div class="col-sm-12">
                                                YOUTUBE
                                            </div>
                                            <?php 
                                            $img_brochure="";
                                            if($inmueble['Inmueble']['youtube']!=""){
                                                $img_brochure='video.png';
                                            }else{
                                                $img_brochure='no_video.png';
                                            }
                                            ?>
                                            <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true).'/img/'.$img_brochure; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?php echo ($inmueble['Inmueble']['youtube']==""?"#": $inmueble['Inmueble']['youtube'])?>')">
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <small><?= ($inmueble['Inmueble']['youtube']==""?"No":"Si")?></small>
                                            </div>
                                        </div>
                                        <?php if ($inmueble['Inmueble']['matterport'] != ''): ?>
                                            <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        MATTERPORT
                                                    </div>
    
                                                    <div class="col-sm-12">
                                                        <?= $this->Html->link($this->Html->image('/img/matterport_logo.png', array('class'=>'img-fluid')), $inmueble['Inmueble']['matterport'], array('escape'=> false, 'target'=>'_Blanck')) ?>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <small><?= ($inmueble['Inmueble']['matterport']==""?"No":"1 Archivo")?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
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
                                                        <td>Exclusividad:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?php
                                                                if ($inmueble['Inmueble']['exclusiva']!="Exclusiva"){
                                                                      echo "No";  
                                                                    }else{
                                                                        if ($inmueble['Inmueble']['due_date']==null || $inmueble['Inmueble']['due_date']=="" || $inmueble['Inmueble']['due_date']=="1969-12-31" || $inmueble['Inmueble']['due_date']=="0000-00-00"){
                                                                            echo "Sin fecha";
                                                                        }else{
                                                                            echo "Hasta: ".date('d/M/Y', strtotime($inmueble['Inmueble']['due_date']));
                                                                        }
                                                                    }
                                                            ?>
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
                                                        <td>Opcionador:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= ($inmueble['Opcionador']['nombre_completo']==""?"&nbsp;":$inmueble['Opcionador']['nombre_completo'])?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Horario Contacto:</td>
                                                        <td class="float-xs-right fw-600">
                                                            <?= ($inmueble['Inmueble']['cita']==""?"&nbsp;":$inmueble['Inmueble']['cita'])?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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

                                        <?php if (!isset($inmueble['DesarrolloP'][0])): ?>
                                            <li class="nav-item" style="list-style: none !important;">
                                                <a class="nav-link" href="#tab4" data-toggle="tab" aria-expanded="false">Datos de Propietario</a>
                                            </li>
                                        <?php endif ?>
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
                                            <p class="card-text">
                                                <div class="col-sm-12">
                                                    <h4 class="text-black"><b>Características</b></h4>
                                                    <?php if ($inmueble['Inmueble']['frente_fondo']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Frente x Fondo: ".$inmueble['Inmueble']['frente_fondo']?>
                                                        </div>
                                                    <?php }?>
                                                    <div class="col-lg-4">
                                                    <?php $suma=$inmueble['Inmueble']['construccion']+$inmueble['Inmueble']['construccion_no_habitable']?>
                                                    <?= "Superficie Total: ".$suma. " m<sup>2</sup>"?>
                                                        </div>
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
                                                    <div class="col-lg-4">
                                                    <?php $suma_metro=number_format($precio/$suma,2)?>
                                                    <?= "Costo por m<sup>2</sup>  :  $ ".$suma_metro?>
                                                        </div>
                                                    <?php if ($inmueble['Inmueble']['terreno']!=""){?>
                                                        <div class="col-lg-4">
                                                            <?= "Superficie de terreno: ".number_format($inmueble['Inmueble']['terreno'])."m<sup>2</sup>"?>
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
                                                            <?= "Nivel de la propiedad: ".$inmueble['Inmueble']['niveles_totales']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    if ($inmueble['Inmueble']['niveles_totales']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Niveles Totales: ".$inmueble['Inmueble']['nivel_propiedad']?>
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
                                                    if ($inmueble['Inmueble']['edad']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Edad en Años: ".$inmueble['Inmueble']['edad']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    if ($inmueble['Inmueble']['mantenimiento']!=""){
                                                    ?>
                                                        <div class="col-lg-4">
                                                            <?= "Mantenimiento: ".$inmueble['Inmueble']['mantenimiento']?>
                                                        </div>
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                </div>
                                                <div class="col-sm-12 m-t-20">
                                                    <h4 class="text-black"><b>Lugares de interes</b></h4>
                                                    <?php echo ($inmueble['Inmueble']['cc_cercanos']            == 1 ? '<div class="col-lg-4">Centros Comerciales Cercanos</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['escuelas']               == 1 ? '<div class="col-lg-4">Escuelas</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['frente_parque']          == 1 ? '<div class="col-lg-4">Frente a Parque</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['parque_cercano']         == 1 ? '<div class="col-lg-4">Parques Cercanos</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['plazas_comerciales']     == 1 ? '<div class="col-lg-4">Plazas Comerciales</div>' : "") ?>
                                                </div>

                                                <div class="col-sm-12 m-t-20">
                                                    <h4 class="text-black"><b>Amenidades</b></h4>
                                                    <?php echo ($inmueble['Inmueble']['alberca_sin_techar']         == 1 ? '<div class="col-lg-4">Alberca descubierta</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['alberca_techada']            == 1 ? '<div class="col-lg-4">Alberca Techada</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['sala_cine']                  == 1 ? '<div class="col-lg-4">Área de Cine</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['area_juegos']                == 1 ? '<div class="col-lg-4">Área de Juegos</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['juegos_infantiles']          == 1 ? '<div class="col-lg-4">Área de Juegos Infantiles</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['fumadores']                  == 1 ? '<div class="col-lg-4">Área para fumadores</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['areas_verdes']               == 1 ? '<div class="col-lg-4">Áreas Verdes</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['asador']                     == 1 ? '<div class="col-lg-4">Asador</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['business_center']            == 1 ? '<div class="col-lg-4">Business Center</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['cafeteria']                  == 1 ? '<div class="col-lg-4">Cafetería</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['golf']                       == 1 ? '<div class="col-lg-4">Campo de Golf</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['paddle_tennis']              == 1 ? '<div class="col-lg-4">Cancha de Paddle</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['squash']                     == 1 ? '<div class="col-lg-4">Cancha de Squash</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['cancha_tenis']               == 1 ? '<div class="col-lg-4">Cancha de Tennis</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['cantina_cava']               == 1 ? '<div class="col-lg-4">Cantina / Cava</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['carril_nado']                == 1 ? '<div class="col-lg-4">Carril de Nado</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['cocina_integral']            == 1 ? '<div class="col-lg-4">Cocina Integral</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['closet_blancos']             == 1 ? '<div class="col-lg-4">Closet de Blancos</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['coworking']                  == 1 ? '<div class="col-lg-4">Coworking</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['desayunador_antecomedor']    == 1 ? '<div class="col-lg-4">Desayunador / Antecomedor</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['fire_pit']                   == 1 ? '<div class="col-lg-4">Fire Pit</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['gimnasio']                   == 1 ? '<div class="col-lg-4">Gimnasio</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['jacuzzi']                    == 1 ? '<div class="col-lg-4">Jacuzzi</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['living']                     == 1 ? '<div class="col-lg-4">Living</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['lobby']                      == 1 ? '<div class="col-lg-4">Lobby</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['boliche']                    == 1 ? '<div class="col-lg-4">Mesa de Boliche</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['patio_servicio']             == 1 ? '<div class="col-lg-4">Patio de Servicio</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['pet_park']                  == 1 ? '<div class="col-lg-4">Pet Park</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['pista_jogging']              == 1 ? '<div class="col-lg-4">Pista de Jogging</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['play_room']                  == 1 ? '<div class="col-lg-4">Play Room / Cuarto de Juegos</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['restaurante']                == 1 ? '<div class="col-lg-4">Restaurante</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['roof_garden_compartido']     == 1 ? '<div class="col-lg-4">Roof Garden</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['sala_tv']                    == 1 ? '<div class="col-lg-4">Sala de TV</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['salon_juegos']               == 1 ? '<div class="col-lg-4">Salón de Juegos</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['salon_multiple']             == 1 ? '<div class="col-lg-4">Salón de usos múltiples</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['sauna']                      == 1 ? '<div class="col-lg-4">Sauna</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['spa']                        == 1 ? '<div class="col-lg-4">Spa</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['sky_garden']                 == 1 ? '<div class="col-lg-4">Sky Garden</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['tina_hidromasaje']           == 1 ? '<div class="col-lg-4">Tina de Hidromasaje</div>': "")?>
                                                    <?php echo ($inmueble['Inmueble']['vapor']                      == 1 ? '<div class="col-lg-4">Vapor</div>': "")?>

                                                    <?php echo ($inmueble['Inmueble']['meditation_room']           == 1 ? '<div class="col-lg-4">Yoga / meditation room</div>': "")?>

                                                    <?php echo ($inmueble['Inmueble']['simulador_golf']                      == 1 ? '<div class="col-lg-4">Simulador de golf</div>': "")?>
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
                                                    <?php echo ($inmueble['Inmueble']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna - '.$inmueble['Inmueble']['m_cisterna'].' Lts </div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['conmutador']                 == 1 ? '<div class="col-lg-4">Conmutador</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['interfon']                   == 1 ? '<div class="col-lg-4">Interfón</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['edificio_inteligente']       == 1 ? '<div class="col-lg-4">Edificio Inteligente</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['edificio_leed']              == 1 ? '<div class="col-lg-4">Edificio LEED</div>' : "") ?>
                                                    <?php echo ($inmueble['Inmueble']['elevador']                   == 1 ? '<div class="col-lg-4">Elevadores - '.$inmueble['Inmueble']['q_elevadores'].'</div>' : "") ?>
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
                                        
                                        <div class="tab-pane" id="tab4" aria-expanded="false">
                                            <p class="card-text">
                                            <div class="col-sm-12 col-lg-6">
                                                <p><b><font color="##4FB7FE">Nombre Cliente:</font></b> <?= $inmueble['Inmueble']['nombre_cliente']?></p>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                            <p><b><font color="##4FB7FE">Correo Electrónico:</font></b> <?= $inmueble['Inmueble']['correo_electronico']?></p>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                            <p><b><font color="##4FB7FE">Teléfono 1:</font></b> <?= $inmueble['Inmueble']['telefono1']?></p>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                            <p><b><font color="##4FB7FE">Teléfono 2:</font></b> <?= $inmueble['Inmueble']['telefono2']?></p>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                            <p><b><font color="##4FB7FE">Dirección:</font></b> <?= $inmueble['Inmueble']['direccion_cliente']?></p>
                                            </div>
                                            </p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!-- ./ End row caracteristicas -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./End row one -->
            
            <div class="row mt-2">
                <?php if ($inmueble['Inmueble']['vendido'] == 1): ?>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        Información de venta
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <a class="pointer text-white align-lg-right"><i class="fa fa-trash fa-lg" onclick="DeleteSale(<?= $inmueble['Venta'][0]['id']?>);"></i></a>
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
                                                    <td class="float-xs-right"><ins><?= $this->Html->link($inmueble['Venta'][0]['Cliente']['nombre'], array('controller'=>'clientes', 'action'=>'view', $inmueble['Venta'][0]['Cliente']['id'])) ?></ins></td>
                                                </tr>
                                                <tr>
                                                    <td>Nombre del aseso:r</td>
                                                    <td class="float-xs-right"><ins><?= $this->Html->link($inmueble['Venta'][0]['User']['nombre_completo'], array('controller'=>'users', 'action'=>'view', $inmueble['Venta'][0]['User']['id'])); ?></ins></td>
                                                </tr>
                                                <tr>
                                                    <td>Fecha de venta:</td>
                                                    <td class="float-xs-right"><?= date('d-m-Y',strtotime($inmueble['Venta'][0]['fecha'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Monto de la venta:</td>
                                                    <td class="float-xs-right">$ <?= number_format($inmueble['Venta'][0]['precio_cerrado']) ?></td>
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


            <?= $this->element('Events/eventos_cards'); ?>


            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header" style="background: #2e3c54; color: white;">
                            Formas de contacto: Total: <span id="totalContactos"></span> contactos
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

            <div class="row mt-2 finanzas">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    Inversión en Publicidad
                                    <div style="float:right">
                                        <?php echo $this->Html->link('Registro de inversión','#',array('data-target'=>"#publicidad",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','class'=>'btn btn-success btn-sm','escape'=>false));?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-sm" id="dataTableInversion">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Nombre de Campaña</th>
                                                <th>Objetivo</th>
                                                <th>Medio</th>
                                                <th>Monto Invertido</th>
                                                <?php if( $this->Session->read('Permisos.Group.id') == 1 ): ?>
                                                    <th><i class="fa fa-trash"></i></th>
                                                <?php endif;?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($inmueble['Publicidad'] as $publicidad): ?>
                                                <tr>
                                                    <td><?= date("m/Y",strtotime($publicidad['fecha_inicio'])) ?></td>
                                                    <td><?= $publicidad['nombre'] ?></td>
                                                    <td><?= $publicidad['objetivo'] ?></td>
                                                    <td><?= $lineas_contactos[$publicidad['dic_linea_contacto_id']] ?></td>
                                                    <td><?= "$".number_format($publicidad['inversion_prevista'],2) ?></td>
                                                    <?php if( $this->Session->read('Permisos.Group.id') == 1 ): ?>
                                                        <td><?= $this->Form->postlink( '<i class="fa fa-trash"></i>', array('controller' => 'publicidads', 'action' => 'delete_inmueble', $publicidad['id'], $inmueble['Inmueble']['id']), array( 'escape' => false) ); ?></td>
                                                    <?php endif;?>

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
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0&callback=initMap">
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
                                            <th>Etapa</th>
                                            <th>E.A</th>
                                            <th>Estauts cliente</th>
                                            <th>Nombre</th>
                                            <th>Correo eléctronico</th>
                                            <th>Teléfono</th>
                                            <th>Fecha creación</th>
                                            <th>Ultimo seg</th>
                                            <th>Asesor</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php foreach ($leads as $lead):?>
                                    <tr>
                                        <?php 
                                            switch($lead['Cliente']['etapa']){
                                                case(1):
                                                    $temp=1;
                                                    $class_temp = 'estado1';
                                                    $name_temp = 'Interés Preliminar';
                                                break;
                                                case(2):
                                                    $temp=2;
                                                    $class_temp = 'estado2';
                                                    $name_temp = 'Comunicación Abierta';
                                                break;
                                                case(3):
                                                    $temp=3;
                                                    $class_temp = 'estado3';
                                                    $name_temp = 'Precalificación';
                                                break;
                                                case(4):
                                                    $temp=4;
                                                    $class_temp = 'estado4';
                                                    $name_temp = 'Cita / Visita';
                                                break;
                                                case(5):
                                                    $temp=5;
                                                    $class_temp = 'estado5';
                                                    $name_temp = 'Consideración';
                                                break;
                                                case(6):
                                                    $temp=6;
                                                    $class_temp = 'estado6';
                                                    $name_temp = 'Validación de Recursos';
                                                break;
                                                case(7):
                                                    $temp=7;
                                                    $class_temp = 'estado7';
                                                    $name_temp = 'Cierre';
                                                break;
                                                default:
                                                    $temp=1;
                                                    $class_temp = 'estado1';
                                                    $name_temp = 'Interés Preliminar';
                                                break;
                                            }
                                            if ($lead['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $lead['Cliente']['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
                                            elseif($lead['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $lead['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
                                            elseif($lead['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $lead['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
                                            elseif($lead['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $lead['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
                                            else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}

                                        ?>
                                        <td>
                                            <small class="<?= $class_temp ?>"><?= $temp ?> <span style="display: none;"><?= $lead['Cliente']['etapa'] ?></span></small>
                                        </td>
                                        <td>
                                            <?= '<small class='."$class_at".'>'.$at.'</small> <span class='."text_hidden".'>'.$name_at.'</span>' ?>
                                        </td>
                                        <td>
                                            <?= $lead['Cliente']['status']; ?>
                                        </td>

                                        <td>
                                            <?= $this->Html->link($lead['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$lead['Cliente']['id']))?>
                                        </td>

                                        <td >
                                            <?php echo $lead['Cliente']['correo_electronico']?>
                                        </td>

                                        <td>
                                            <?php echo rtrim(str_replace(array("(", ")"," ", "-"), "", $lead['Cliente']['telefono1']))?>
                                        </td>
                                        <td>
                                            <?php echo date_format(date_create($lead['Cliente']['created']),"Y-m-d")?>
                                        </td>

                                        <td>
                                            <?php echo date_format(date_create($lead['Cliente']['last_edit']),"Y-m-d")?>
                                        </td>

                                        <td>
                                            <?php echo $lead['Cliente']['User']['nombre_completo'] ?>
                                        </td>
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
                                                    array('escape'=>false, 'target' => '_blanck')
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
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12">
                                    Próximos Eventos (15 días)

                                    <span class="float-xs-right">
                                        <small style="text-transform: uppercase;">
                                            <i class=" fa fa-home"></i> Cita
                                            <i class=" fa fa-check-circle"></i> Visita
                                        </small>
                                    </span>

                                </div>
                            </div>
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:400px !important">
                            <?= $this->element('Events/eventos_proximos'); ?>
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

        
        
        '/vendors/slimscroll/js/jquery.slimscroll.min',
        '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
        '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
        '/vendors/moment/js/moment.min',
        '/vendors/fullcalendar/js/fullcalendar.min',
        '/vendors/countUp.js/js/countUp.min',
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
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',

    ], array('inline'=>false));
?>
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawFormasContacto);
google.charts.setOnLoadCallback(drawPrecios);


function drawFormasContacto() {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Línea de Contacto');
    data.addColumn('number', 'Personas');
    data.addRows([
        <?php $sc = 0; ?>
        <?php foreach ($contactos as $contacto): ?>
            ['<?= $contacto['dic_linea_contactos']['linea_contacto']?>',<?= $contacto[0]['total'] ?>],
            <?php $sc += $contacto[0]['total']; ?>
        <?php endforeach;?>
    ]);

    var options = {
        'width':"100%",
        'height':300
    };

    var chart = new google.visualization.PieChart(document.getElementById('grafica_contactos'));
    chart.draw(data, options);
    document.getElementById("totalContactos").innerHTML = <?= $sc; ?>;
}
              
function drawPrecios() {
    var data = google.visualization.arrayToDataTable([
    ['Fecha', 'Precio'],
    <?php 
        if( isset ( $inmueble['Inmueble']['precio_base'] ) ){
            
            array_push($inmueble['Precio'], array('fecha'=>date('d-M-Y', strtotime($inmueble['Inmueble']['fecha']) ),'precio'=>$inmueble['Inmueble']['precio_base']));

        }

        sort($inmueble['Precio']);
        if( empty( !$inmueble['Precio'] ) ):
            foreach ($inmueble['Precio'] as $precio): ?>
                ['<?= date('d-M-Y', strtotime($precio['fecha']))?>',  <?= $precio['precio']?>],
            <?php endforeach; ?>
        <?php else: ?>
            ['',0],
        <?php endif; ?>
    ]);

    var options = {
    title: 'Cambio de precios',
    hAxis: {title: 'Fecha'},
    vAxis: {title: 'Precio'},
    lineWidth: 4,
    legend: 'none',
    'width':"100%",
    'height':300
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('grafica_precios'));

    chart.draw(data, options);

}


function cambio_precio(){
    if (document.getElementById("VentaOperacion").value == 'Venta'){
        document.getElementById("VentaPrecioCerrado").value = '<?= $inmueble['Inmueble']['precio'] ?>';
    }else{
        document.getElementById("VentaPrecioCerrado").value = '<?= $inmueble['Inmueble']['precio_2'] ?>';
    }
}


function DeleteSale(id){
    $("#moda_delete_sale").modal('show')
    document.getElementById("VentaId").value = id;
}


function totInversion(){
    let total = 0;

    total = $("#PublicidadInversionPrevista").val() * $("#PublicidadMeses").val();
    $("#PublicidadTotInversion").val(new Intl.NumberFormat().format(total));
}

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });

    $('.fecha_venta').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom",
        startDate: "<?= date("d-m-Y",strtotime($fecha_actual."- 1 year")) ?>"
    });
    
    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
  
});

var table2 = $('#dataTableInversion').DataTable({
        dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        orderCellsTop: true,
        autoWidth: true,
        columnDefs: [
            {targets: 0, width: '40px'},
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
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                class : 'excel',
                className: 'btn-secondary',
                charset: 'utf-8',
                bom: true
            },
            {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                className: 'btn-secondary',
            },
        ]
    });

</script>