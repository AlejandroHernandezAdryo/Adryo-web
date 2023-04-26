<?php 
    $venta = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
    echo $this->Html->css(
        array(
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            '/vendors/datatables/css/colReorder.bootstrap.min',
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
            '/vendors/clockpicker/css/jquery-clockpicker',
            'css/pages/colorpicker_hack',
            'custom'
            //'pages/form_elements'
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Lista de propiedades
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                        <div class="card-block p-t-25">
                            
                        <!---Contadores Unidades-->

                        <div class="row encabezado-indicador">
                            <div class="col-sm-12 col-lg-6">
                                Total de Propiedades: <?= count($inmuebles); ?>
                            </div>
                        </div>

                        <div class="row mt-1 mb-1">
                        
                            <div class="col-sm-4 col-lg-2 text-center">
                                Bloqueado
                                <div class="number chips bg-status-desarrollo-bloqueado">
                                    <span id="bloqueado">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-2 text-center">
                                Libre
                                <div class="number chips bg-status-desarrollo-venta">
                                    <span id="libre">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-2 text-center">
                                Reservado
                                <div class="number chips bg-status-desarrollo-reservado">
                                    <span id="reserva">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-2 text-center">
                                Contrato
                                <div class="number chips bg-status-desarrollo-vendido">
                                    <span id="contrato">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-2 text-center">
                                Escriturado
                                <div class="number chips bg-status-desarrollo-escriturado">
                                    <span id="escrituracion">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-2 text-center">
                                Baja
                                <div class="number chips bg-status-desarrollo-baja">
                                    <span id="baja">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!---Contadores Unidades-->

                        <div class="pull-sm-right">
                            <div class="tools pull-sm-right"></div>
                        </div>

                        <div style="float:right">
                            <a  href="#" class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal">
                               <i class="fa fa-search fa-1x"></i>Búsqueda Avanzada
                            </a>
                        </div>

                            <div class="m-t-35">
                                <style>
                                        .status{
                                          border-radius: 5px;
                                          text-align: center; 
                                          -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
                                          -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
                                          box-shadow: 3px 1px 16px rgba(184,184,184,0.50)º;
                                        }
                                      </style>
                                <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                                    <thead>
                                    <tr>
                                        <th>Propiedades</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contbloqueados=0;
                                        $contventa=0;
                                        $contreservado=0;
                                        $contvendido=0;
                                        $contescriturado=0;
                                        $contbaja=0;
                                        foreach ($inmuebles as $inmueble):?>           
                                            <tr>
                                                <td>
                                                   <div class="col-lg-12 m-t-10" style="background-color: #2e3c54; color:white; padding: 5px;"><?php 
                                                                if ($inmueble['Inmueble']['premium']==1){
                                                                    echo $this->Html->link($inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>",array('action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                }else{
                                                                    echo $this->Html->link($inmueble['Inmueble']['titulo'],array('action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                }
                                                                ?>
                                                                    <?php if ($this->Session->read('Permisos.Group.ie')==1){?>
                                                                    <div style="color:white; float: right">
                                                                        <?php
                                                                            // 0=> Bloqueada, 1=> Libre, 2=> Reservado, 3=> Contrato, 4=> Escrituracion, 5=> Baja
                                                                            switch( $inmueble['Inmueble']['liberada'] ) {
                                                                                case 0:
                                                                                    // Libre
                                                                                    echo $this->Html->link('<i class="fa fa-check"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],1),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LIBERAR','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                case 1:
                                                                                    // Bloquear, Reservar, Baja
                                                                                    echo $this->Html->link('<i class="fa fa-lock"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],0),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BLOQUEAR','escape'=>false,'style'=>'color:white;margin-right:5px'));

                                                                                    echo $this->Html->link('<i class="fa fa-calendar"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],2),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'RESERVAR','escape'=>false,'style'=>'color:white;margin-right:5px'));

                                                                                    echo $this->Html->link('<i class="fa fa-times"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],5),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BAJA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                case 2:
                                                                                    // Vender, Libre
                                                                                    echo $this->Html->link('<i class="fa fa-check"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],1),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LIBERAR','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                case 3:
                                                                                    // Escrituracion
                                                                                    echo $this->Html->link('<i class="fa fa-certificate"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],4),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'ESCRITURACIÓN','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                case 5:
                                                                                    // Liberar
                                                                                    echo $this->Html->link('<i class="fa fa-check"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],1),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LIBERAR','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                default:
                                                                                break;
                                                                            }

                                                                        ?>
                                                                    </div>
                                                                    <?php }?>
                                                                </div>
                                                   
                                                    <?php 
                                                        $imagen = (isset($inmueble['FotoInmueble'][0]) ? $inmueble['FotoInmueble'][0]['ruta'] : "/img/no_photo_inmuebles.png");
                                                    ?>
                                                    <a href="/inmuebles/view/<?= $inmueble['Inmueble']['id']?>">
                                                        <div class="col-lg-2 m-t-10" style="height:150px;background-image: url('<?= Router::url('/',true).$imagen?>'); background-position:center center; background-repeat:no-repeat; background-size:cover ">
                                                            <?php if ($inmueble['Inmueble']['vendido']==1){?>
                                                                <span class="sale" style="/*! width: 500px; */background-color: green;color: white;padding: 5px;">$ Vendido</span>
                                                            <?php }?>
                                                        </div>
                                                    </a>
                                                         <div class="col-lg-9 m-t-10">
                                                             <div class="col-lg-2" >
                                                                 <b><?php echo $inmueble['TipoPropiedad']['tipo_propiedad']?></b><br>
                                                                 <b>
                                                                 <?php 
                                                                    switch ($inmueble['Inmueble']['venta_renta']){
                                                                        case("Venta"):
                                                                            echo "V:$".number_format($inmueble['Inmueble']['precio'],0)."<br>";
                                                                            break;
                                                                        case ("Renta"):
                                                                            echo "R:$".number_format($inmueble['Inmueble']['precio_2'],0)."<br>";
                                                                            break;
                                                                        default :
                                                                            echo "V:$".number_format($inmueble['Inmueble']['precio'],0)."<br>";
                                                                            echo "R:$".number_format($inmueble['Inmueble']['precio_2'],0)."<br>";
                                                                            break;
                                                                    }
                                                                 ?>
                                                                     </b>    
                                                                 <b><?php echo $inmueble['Inmueble']['exclusiva']?></b><br>
                                                                 <b><?php echo $inmueble['Inmueble']['venta_renta']?></b><br>
                                                                 <b>Colonia: <?= $inmueble['Inmueble']['colonia']?></b><br>
                                                                 <b>Terreno: <?= $inmueble['Inmueble']['terreno']?></b><br>
                                                             </div>
                                                             <div class="col-lg-5" style="text-align: right">
                                                                <div class="row">
                                                                <div class=" col-sm-3 col-md-3">
                                                                    <p><?= $this->Html->image('m2.png',array('width'=>'40%'))?></p>
                                                                    <p><?= intval($inmueble['Inmueble']['construccion'])+intval($inmueble['Inmueble']['construccion_no_habitable'])."m2"?></p>
                                                                </div>
                                                                <div class="col-sm-3 col-md-3">
                                                                    <p><?= $this->Html->image('recamaras.png',array('width'=>'40%'))?></p>
                                                                    <p><?= intval($inmueble['Inmueble']['recamaras'])?> Hab.</p>
                                                                </div>
                                                                <div class="col-sm-3 col-md-3">
                                                                    <p><?= $this->Html->image('banios.png',array('width'=>'40%'))?></p>
                                                                    <p><?= intval($inmueble['Inmueble']['banos'])+intval($inmueble['Inmueble']['medio_banos'])?> Baños</p>
                                                                </div>
                                                                <div class="col-sm-3 col-md-3">
                                                                    <p><?= $this->Html->image('autos.png',array('width'=>'40%'))?></p>
                                                                    <p><?= intval($inmueble['Inmueble']['estacionamiento_techado'])+intval($inmueble['Inmueble']['estacionamiento_descubierto'])?> Lugares</p>
                                                                </div>
                                                                </div>
                                                                
                                                             </div>
                                                             <div class="col-lg-2" style="text-align: right">
                                                                 <div class="row">
                                                                 <?php
                        switch ($inmueble['Inmueble']['liberada']){
                            case 0: //No liberada
                                echo "<div class='status' style='text-align: center; background-color: #FFFF00; color:#3D3D3D;'>BLOQUEADA</div>";
                                $contbloqueados++;
                                break;

                            case 1: // Libre
                                echo "<div class='status' style='text-align: center; background-color: rgb(0, 64 , 128); color:white'>LIBRE</div>";
                                $contventa++;
                                break;

                            case 2:
                                echo "<div class='status' style='text-align: center; background-color: #FFA500;'>RESERVADO</div>";
                                $contreservado++;
                                break;

                            case 3:
                                echo "<div class='status' style='text-align: center; background-color: RGB(116, 175, 76);  color: white;'>CONTRATO</div>";
                                $contvendido++;
                                break;

                            case 4:
                                echo "<div  class='status' style='text-align: center; background-color: #8B4513; color:white;'>ESCRITURACION</div>";
                                $contescriturado++;
                                break;

                            case 5:
                                echo "<div class='status' style='text-align: center; background-color: #000000; color:white'>BAJA</div>";
                                $contbaja++;
                                break;
                        }

                                                                                ?><br>
                                                                                COMPARTIR<br>
<!--                                                                                <a href="whatsapp://send?text=<<HERE GOES THE URL ENCODED TEXT YOU WANT TO SHARE>>" data-action="share/whatsapp/share">Share via Whatsapp</a>-->
                                                                                <div style="float:right">
                                                    <!-- 
                                                                                    Enlaces para compartir en Redes Sociales.
                                                                                    Facebook:
                                                                                    http://www.facebook.com/sharer.php?u= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI];
                                                                                -->
                                                                                <?php
                                                                                  $shared_inmueble = Router::url('/inmuebles/detalle/'.$inmueble['Inmueble']['id'],true);
                                                                                ?>
                                                                                <?= $this->Html->link(
                                                                                    '<i class="fa fa-facebook fa-lg"></i>',
                                                                                    'http://www.facebook.com/sharer.php?u='.$shared_inmueble,
                                                                                    array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                                                                )?>

                                                                                <?= $this->Html->link(
                                                                                    '<i class="fa fa-twitter fa-lg"></i>',
                                                                                    'https://twitter.com/intent/tweet?text='." Les comparto este increíble desarrollo vía @adryo_ai ".$shared_inmueble,
                                                                                    array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                                                                )?>

                                                                                <?= $this->Html->link(
                                                                                    '<i class="fa fa-linkedin fa-lg"></i>',
                                                                                    'https://www.linkedin.com/shareArticle?url='.$shared_inmueble,
                                                                                    array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                                                                )?>
                                                                                        </div>
                                                                                <br>
                                                                                <?php if ($inmueble['Inmueble']['due_date']==null || $inmueble['Inmueble']['due_date']=="" || $inmueble['Inmueble']['due_date']=="1969-12-31" || $inmueble['Inmueble']['due_date']=="0000-00-00"){?>
                                                                                    
                                                                                <?php }else{?>
                                                                                Vencimiento: <?php echo date('d/M/Y', strtotime($inmueble['Inmueble']['due_date']))?>
                                                                                <?php } ?>
                                                                 
                                                                 </div>
                                                                 </div>
                                                         </div>
                                                 
                                                </td>
                                            </tr>
                                            <?php endforeach;?>    
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-blue-is
                                ">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title text-white" id="myModalLabel1" style="color:black">
                                        <i class="fa fa-search"></i>
                                        Búsqueda Avanzada de Inmuebles
                                    </h4>
                                </div>
                                <?= $this->Form->create('Inmueble',array('url'=>array('action'=>'index')))?>
                                <div class="modal-body">

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="tipo_inmueble" class="form-control-label">Tipo</label>
                                        </div>
                                        <?= $this->Form->input('tipo_inmueble',array('class'=>'form-control','empty'=>'Todos los tipos','options'=>$tipos_inmuebles,'type'=>'select','div'=>'col-md-8 m-t-15','label'=>false,))?>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="operacion" class="form-control-label">Operación</label>
                                        </div>
                                        
                                        <?= $this->Form->input('operacion',array('class'=>'form-control','empty'=>'Todas las operaciones','options'=>$venta,'type'=>'select','div'=>'col-md-8 m-t-15','label'=>false,))?>
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="precio_minimo" class="form-control-label">Rango Precio</label>
                                        </div>
                                        <?= $this->Form->input('precio_min',array('class'=>'form-control','placeholder'=>'Precio Mínimo','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('precio_max',array('class'=>'form-control','placeholder'=>'Precio Máximo','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="habitaciones" class="form-control-label">Habitaciones</label>
                                        </div>
                                        <?= $this->Form->input('hab_min',array('class'=>'form-control','placeholder'=>'Habitaciones Mínimas','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('hab_max',array('class'=>'form-control','placeholder'=>'Habitaciones Máximas','div'=>'col-md-4 m-t-15','label'=>false,))?>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="baños" class="form-control-label">Baños</label>
                                        </div>
                                        <?= $this->Form->input('banios_min',array('class'=>'form-control','placeholder'=>'Baños Mínimos','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('banios_max',array('class'=>'form-control','placeholder'=>'Baños Máximos','div'=>'col-md-4 m-t-15','label'=>false,))?>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="terreno" class="form-control-label">Terreno</label>
                                        </div>
                                        <?= $this->Form->input('terreno_min',array('class'=>'form-control','placeholder'=>'Terreno Mínimo','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('terreno_max',array('class'=>'form-control','placeholder'=>'Terreno Máximo','div'=>'col-md-4 m-t-15','label'=>false,))?>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="construccion" class="form-control-label">Construcción</label>
                                        </div>
                                        <?= $this->Form->input('construccion_min',array('class'=>'form-control','placeholder'=>'Construcción Mínima','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('construccion_max',array('class'=>'form-control','placeholder'=>'Construcción Máxima','div'=>'col-md-4 m-t-15','label'=>false,))?>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xl-4 text-xl-left m-t-15">
                                            <label for="estacionamiento" class="form-control-label">Estacionamiento</label>
                                        </div>
                                        <?= $this->Form->input('est_min',array('class'=>'form-control','placeholder'=>'Estacionamiento Mínimo','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('est_max',array('class'=>'form-control','placeholder'=>'Estacionamiento Máximo','div'=>'col-md-4 m-t-15','label'=>false,))?>

                                    </div>

                                    <?php if( $this->Session->read('CuentaUsuario.CuentaUser.group_id') != 3 ): ?>
                                        <div class="row">

                                            
                                            
                                            <div class="col-xl-4 text-xl-left m-t-15">
                                                <label for="estado" class="form-control-label">Estado</label>
                                            </div>
                                            <?= $this->Form->input('estado',array('type'=>'select','options'=>array(0=> 'Bloqueada', 1=> 'Libre', 2=> 'Reservado', 3=> 'Contrato', 4=> 'Escrituracion', 5=> 'Baja'),'empty'=>'Todos los estatus','class'=>'form-control','div'=>'col-md-8 m-t-15','label'=>false,))?>

                                        </div>
                                    <?php else: ?>
                                        <?= $this->Form->hiden('estado',array('type'=>'select','options'=>array(0=> 'Bloqueada', 1=> 'Libre', 2=> 'Reservado', 3=> 'Contrato', 4=> 'Escrituracion', 5=> 'Baja'),'empty'=>'Todos los estatus','class'=>'form-control','div'=>'col-md-8 m-t-15','value'=>'1' ))?>
                                    <?php endif; ?>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                                        Cerrar
                                    </button>
                                    <button type="submit" class="btn btn-success float-xs-right" id="add-new-event" onclick="javascript:this.form.submit()">
                                        Realizar Búsqueda
                                    </button>
                                </div>

                                <?= $this->Form->end()?>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<?php 
    echo $this->Html->script([
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
        /*'/vendors/datatables/js/dataTables.colReorder.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/datatable',*/
//        'pages/advanced_tables'
    ], array('inline'=>false));
?>

<?php

$this->Html->scriptStart(array('inline' => false));

?>

'use strict';
$(document).ready(function () {

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    
    
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        return false;
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        return false;
    });
    
    $('[data-toggle="popover"]').popover()

});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                
                
                
            ]
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
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

<?php $this->Html->scriptEnd();

?>

<script>
document.getElementById("bloqueado").innerHTML    = <?= $contbloqueados ?>;
document.getElementById("libre").innerHTML        = <?= $contventa ?>;
document.getElementById("reserva").innerHTML  = <?= $contreservado ?>;
document.getElementById("contrato").innerHTML    = <?= $contvendido ?>;
document.getElementById("escrituracion").innerHTML        = <?= $contescriturado ?>;
document.getElementById("baja").innerHTML  = <?= $contbaja ?>;
</script>
