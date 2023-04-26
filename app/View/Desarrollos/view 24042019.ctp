<?php
    $count = 0;
    echo $this->Html->css(
        array(

            // checkbox
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',

            // Slider images
            
            'pages/widgets',
            
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            'pages/new_dashboard',
           
        ),
        array('inline'=>false)); 
?>
<style>
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


li {
    list-style-type: circle;
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
</style>
    

<!-- Modales -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title text-black">Galeria de Imagenes</h4>
      </div>
      <div class="modal-body">

        <div class="row">
            <?php foreach ($desarrollo['FotoDesarrollo'] as $pics): ?>
                <?php $count ++ ?>
                <div class="col-sm-12">
                    <?php echo $this->Html->image($pics['ruta'], array('class'=>'img-fluid', 'id'=>'galeria-'.$count, 'style'=>'display:none;')) ?>
                </div>
            <?php endforeach ?>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar &times;</button>
      </div>
    </div>
  </div>
</div>

<div id="archivos" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <?= $this->Form->create('Desarrollo',array('url'=>array('action'=>'send_attach')))?>
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title text-black">Enviar archivos a cliente</h4>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-xl-3 text-xl-left m-t-15">
                    <label for="cliente" class="form-control-label">Cliente relacionado</label>
            </div>
            <?= $this->Form->input('cliente_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin cliente asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$clientes_list))?>
            <table class="table">
                        <thead>
                        <tr>
                            <th width="80%"><b>Documento</b></th>
                            <th width="20%"><b>Seleccionar</b></th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                           <?php $i = 0 ?>
                           <?php foreach ($desarrollo['DocumentosUser'] as $documento):?>
                                <tr>
                                    <td><?= $documento['documento']?></td>
                                    <td>
                                        <?= $this->Form->input('seleccionar'.$i,array('type'=>'checkbox','label'=>false))?>
                                    </td>
                                    
                                </tr>
                             <?php $i++?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar &times;</button>
      </div>
    </div>
    <?= $this->Form->end(); ?>
  </div>
</div>

<div class="modal fade" id="fotos" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-picture"></i>
                    Fotografías del Desarrollo
                </h4>
            </div>
            <div class="modal-body">
            <?php 
                foreach ($desarrollo['FotoDesarrollo'] as $imagen):
            ?>
            <div class="col-lg-6 m-t-20">
                <div class="col-sm-12" style="height:200px;background-image: url('<?= Router::url('/',true).$imagen['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$imagen['ruta']; ?>')">
                </div>
                <div class="col-xs-12">
                    <?= $imagen['descripcion']?>
                </div>
            </div>
            <?php 
                endforeach;
            ?>    
            </div>
            <div class="row modal-footer">
                
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="planos" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-picture"></i>
                    Planos comerciales del Desarrollo
                </h4>
            </div>
            <div class="modal-body">
            <?php 
                foreach ($desarrollo['Planos'] as $imagen):
            ?>
            <div class="col-lg-6 m-t-20">
                <div class="col-sm-12" style="height:200px;background-image: url('<?= Router::url('/', true).$imagen['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$imagen['ruta']; ?>')">
                </div>
                <div class="col-xs-12">
                    <?= $imagen['descripcion']?>
                </div>
            </div>
            <?php 
                endforeach;
            ?>    
            </div>
            <div class="row modal-footer">
                
            </div>
            
        </div>
    </div>
</div>

<!-- Modal para duplicar una unidad tipo -->
<div class="modal fade" id="duplicar_tipo">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('ClonInmueble', array('url'=>array('controller'=>'Inmuebles', 'action' => 'clon_unidad_tipo', $desarrollo_id))); ?>
      <div class="modal-content">
        <div class="modal-header" style="background: #2e3c54;">
          <h4 class="modal-title col-sm-10">Duplicar unidad tipo</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <?php
                    echo $this->Form->hidden('id');
                    echo $this->Form->input('cantidad',
                        array(
                            'class' => 'form-control',
                            'div'   => 'col-sm-12',
                            'label' => 'Cantidad a replciar de unidad tipo*'
                        )
                    );
                ?>
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



<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-5 col-xs-12">
                <h4 class="nav_top_align">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Desarrollos
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card">
                <div class="card-header"  style="background-color: #2e3c54; color:white">
                    <?php  echo $desarrollo['Desarrollo']['nombre']." / ".$desarrollo['Desarrollo']['referencia']?>
                        <div style="float:right">
                            <?php if ($this->Session->read('Permisos.Group.id')==1 ||($desarrollo['EquipoTrabajo']['administrador_id']=="" && $this->Session->read('Permisos.Group.id')==2) ||$desarrollo['EquipoTrabajo']['administrador_id']==$this->Session->read('Auth.User.id')){
                                echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'edit_generales',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR DESARROLLO','escape'=>false,'style'=>'color:white'));
                            }
                            if ($desarrollo['Desarrollo']['brochure']!=""){
                                echo $this->Html->link('<i class="fa fa-file-pdf-o fa-2x"></i>',$desarrollo['Desarrollo']['brochure'],array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'VER BROCHURE','escape'=>false,'style'=>'color:white'));
                            }
                            echo $this->Html->link('<i class="fa fa-print fa-2x"></i>',array('action'=>'imprimir',$desarrollo['Desarrollo']['id'],$this->Session->read('Auth.User.id').".pdf"),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'IMPRIMIR FICHA TÉCNICA','escape'=>false,'style'=>'color:white'));
                            echo $this->Html->link('<i class="fa fa-home fa-2x"></i>',array('action'=>'detalle',$desarrollo['Desarrollo']['id'],$this->Session->read('Auth.User.id')),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'VER FICHA TÉCNICA PÚBLICA','escape'=>false,'style'=>'color:white'));
                            ?>
                        </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <pre>
                                <?php print_r($this->Session->read('Permisos')) ?>
                            </pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card" >
                                <div class="card-header">
                                    <?php echo $desarrollo['Desarrollo']['calle'] . " " . $desarrollo['Desarrollo']['numero_ext'] . " " . $desarrollo['Desarrollo']['numero_int'] . " " . $desarrollo['Desarrollo']['colonia']?>
                                    <?php echo $desarrollo['Desarrollo']['ciudad'] . " " . $desarrollo['Desarrollo']['estado'] . " CP: " . $desarrollo['Desarrollo']['cp']?>
                                    
                                    <div style="float:right">
                                        <!-- 
                                            Enlaces para compartir en Redes Sociales.
                                            Facebook:
                                            http://www.facebook.com/sharer.php?u= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI];
                                        -->
                                        <?php
                                          $shared_desarrollo = Router::url('/Desarrollos/detalle/'.$desarrollo['Desarrollo']['id'],true);
                                        ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-facebook fa-lg"></i>',
                                            'http://www.facebook.com/sharer.php?u='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales')
                                        )?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-twitter fa-lg"></i>',
                                            'https://twitter.com/intent/tweet?text='."Les comparto este increible desarrollo via InmoSystem. ".$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales')
                                        )?>
                                        

                                        <?= $this->Html->link(
                                            '<i class="fa fa-linkedin fa-lg"></i>',
                                            'https://www.linkedin.com/shareArticle?url='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales')
                                        )?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Direcciones -->

                    <div class="row" style="width:101%">
                        <style>
                            #img-principal{
                                display: block;
                                position: absolute;
                                height: 31.5vh;
                                width: auto;
                            }
                            .flex{
                                display: flex ;
                                flex-direction: column ;
                                flex-wrap: wrap ;
                                justify-content: center ;
                                align-items: center ;
                                align-content: space-between ;
                            }
                        </style>
                        <div class="col-lg-4 m-t-10">
                            <?php $foto = (sizeof($desarrollo['FotoDesarrollo'])?$desarrollo['FotoDesarrollo'][0]['ruta']:'/img/inmueble_no_photo.png')?>
                            <div class="col-sm-12" style="height:35vh;background-image: url('<?php echo Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?php echo Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta'] ?>');">
                            </div>
                        </div>
                        <div class="col-lg-5 m-t-10">
                            <div class="row m-t-20">
                                <div class="col-lg-12" style="text-align:left;">
                                    <h3><font color="black"><b>Características Generales</b></font></h3>
                                </div>

                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <?= $this->Html->image('m2.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?></p>
                                </div>
                                <div class="col-lg-3 col-xs-6"  style="text-align:center;">
                                    <?= $this->Html->image('recamaras.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['rec_low']?> - <?= $desarrollo['Desarrollo']['rec_top']?></p>
                                </div>
                                <div class="col-lg-3 col-xs-6"  style="text-align:center;">
                                    <?= $this->Html->image('banios.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['banio_low']?> - <?= $desarrollo['Desarrollo']['banio_top']?></p>
                                </div>
                                <div class="col-lg-3 col-xs-6" style="text-align:center;">
                                    <?= $this->Html->image('autos.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['est_low']?> - <?= $desarrollo['Desarrollo']['est_top']?></p>
                                </div>                                
                            </div>
                            <div class="row m-t-30">
                                <div class="col-lg-12" style="text-align:left;">
                                    <h3><font color="black"><b>GALERÍA MULTIMEDIA</b></font></h3>
                                </div>
                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <div class="col-sm-12">
                                        GALERÍA
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#fotos" id="target-modal">
                                        <?php $foto = (sizeof($desarrollo['FotoDesarrollo'])>0?$desarrollo['FotoDesarrollo'][0]['ruta']:'/img/inmueble_no_photo.png')?>
                                        <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; ">
                                        </div>
                                    </a>
                                    <div class="col-sm-12">
                                        <small><?= sizeof($desarrollo['FotoDesarrollo'])." Fotos"?></small>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <div class="col-sm-12">
                                        PLANOS
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#planos" id="target-modal">
                                        <div class="col-sm-12" style="height:60px;background-image: url('<?= (sizeof($desarrollo['Planos'])? Router::url('/',true).$desarrollo['Planos'][0]['ruta']:Router::url('/',true)."/img/no_photo_inmuebles.png"); ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" >
                                        </div>
                                    </a>
                                    <div class="col-sm-12">
                                        <small><?= sizeof($desarrollo['Planos'])." Planos"?></small>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <div class="col-sm-12">
                                        BROCHURE
                                    </div>
                                    <?php 
                                    $img_brochure="";
                                    if($desarrollo['Desarrollo']['brochure']!=""){
                                        $img_brochure='brochure.png';
                                    }else{
                                        $img_brochure='no_brochure.png';
                                    }
                                    ?>
                                    <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true); ?>/img/<?= $img_brochure; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?php echo ($desarrollo['Desarrollo']['brochure']==""?"#": Router::url($desarrollo['Desarrollo']['brochure'], true))?>')">
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <small><?= ($desarrollo['Desarrollo']['brochure']==""?"No":"1 Archivo")?></small>
                                    </div>
                                </div>
                                
                                <!-- Video de youtube -->
                                <?php if ($desarrollo['Desarrollo']['youtube'] != ''): ?>
                                    <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                        <div class="col-sm-12">
                                            YOUTUBE
                                        </div>
                                        <?php 
                                        $img_brochure="";
                                        if($desarrollo['Desarrollo']['youtube']!=""){
                                            $img_brochure='video.png';
                                        }else{
                                            $img_brochure='no_video.png';
                                        }
                                        ?>
                                        <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true); ?>/img/<?= $img_brochure; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?php echo ($desarrollo['Desarrollo']['youtube']==""?"#": $desarrollo['Desarrollo']['youtube'])?>')">
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <small><?= ($desarrollo['Desarrollo']['youtube']==""?"No":"1 Archivo")?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($desarrollo['Desarrollo']['matterport'] != ''): ?>
                                    <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                MATTERPORT
                                            </div>

                                            <div class="col-sm-12">
                                                <?= $this->Html->link($this->Html->image('/img/matterport_logo.png', array('class'=>'img-fluid')), $desarrollo['Desarrollo']['matterport'], array('escape'=> false, 'target'=>'_Blanck')) ?>
                                            </div>
                                            <div class="col-sm-12">
                                                <small><?= ($desarrollo['Desarrollo']['matterport']==""?"No":"1 Archivo")?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                        <div class="col-lg-3 m-t-10" style="text-align:left; background-color: #f5f5f5">
                            <div class="row m-t-10">
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Equipo: </td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "Sin equipo asignado" : $this->Html->link($desarrollo['EquipoTrabajo']['nombre_grupo'],array('controller'=>'GruposUsuarios','action'=>'view',$desarrollo['EquipoTrabajo']['id'])))?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Privado: </td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?></b></tr>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Tipo de Desarrollo:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['tipo_desarrollo']=="&nbsp;"?"":$desarrollo['Desarrollo']['tipo_desarrollo'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Etapa:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['etapa_desarrollo']==""?"&nbsp;":$desarrollo['Desarrollo']['etapa_desarrollo'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Torres:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['torres']==""?"&nbsp;":$desarrollo['Desarrollo']['torres'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Unidades Totales:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['unidades_totales']==""?"&nbsp;":$desarrollo['Desarrollo']['unidades_totales'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Disponibilidad:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= sizeof($desarrollo['Disponibles'])?>/<?= sizeof($desarrollo['Propiedades'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Entrega:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['entrega']=="Inmediata"?"Inmediata":date('d/M/Y', strtotime($desarrollo['Desarrollo']['fecha_entrega'])))?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Exclusividad:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?php 
                                        if ($desarrollo['Desarrollo']['exclusividad']=="No"){
                                          echo "No";  
                                        }else{
                                         echo date('d/M/Y', strtotime($desarrollo['Desarrollo']['fecha_inicio_exclusiva']))." al ".date('d/M/Y', strtotime($desarrollo['Desarrollo']['fecha_exclusiva']));
                                        }
                                        ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Comisión:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['comision']==""?"No / 0%":$desarrollo['Desarrollo']['comision']."%")?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Comparte:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['compartir']==""?"No / 0 %":"Si / ".$desarrollo['Desarrollo']['porcentaje_compartir']."%")?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Departamento Muestra:</td>
                                        <td>
                                            <?php
                                                $boolean = array (1=>"Si",2=>'No');
                                                echo $boolean[$desarrollo['Desarrollo']['departamento_muestra']];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Horario Atención:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['horario_contacto']==""?"&nbsp;":$desarrollo['Desarrollo']['horario_contacto'])?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./row imagenes y caracteristicas -->

                    <div class="row m-t-40">
                        <div class="col-sm-12">
                            <h3 class="text-black">Descripción del desarrollo</h3>
                            <hr>
                            <div class="col-sm-12">
                                <p>
                                    <?php echo $desarrollo['Desarrollo']['descripcion'];?> 
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- ./row Descripcion del Desarrollo -->


                    <div class="row m-t-40">
                        <div class="col-sm-12">
                            <h3 class="text-black">Entorno, Amenidades y Servicios</h3>
                            <hr>

                            <div class="col-sm-12">
                                <h4 class="text-black">- Lugares de interes</h4>
                                <?php echo ($desarrollo['Desarrollo']['cc_cercanos']            == 1 ? '<div class="col-lg-4">Centros Comerciales Cercanos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['escuelas']               == 1 ? '<div class="col-lg-4">Escuelas</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['frente_parque']          == 1 ? '<div class="col-lg-4">Frente a Parque</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['parque_cercano']         == 1 ? '<div class="col-lg-4">Parques Cercanos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['plazas_comerciales']     == 1 ? '<div class="col-lg-4">Plazas Comerciales</div>' : "") ?>
                            </div>

                            <div class="col-sm-12 m-t-20">
                                <h4 class="text-black">- Amenidades</h4>
                                <?php echo ($desarrollo['Desarrollo']['alberca_sin_techar']         == 1 ? '<div class="col-lg-4">Alberca descubierta</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['alberca_techada']            == 1 ? '<div class="col-lg-4">Alberca Techada</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sala_cine']                  == 1 ? '<div class="col-lg-4">Área de Cine</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['juegos_infantiles']          == 1 ? '<div class="col-lg-4">Área de Juegos Infantiles</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['fumadores']                  == 1 ? '<div class="col-lg-4">Área para fumadores</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['areas_verdes']               == 1 ? '<div class="col-lg-4">Áreas Verdes</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['asador']                     == 1 ? '<div class="col-lg-4">Asador</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cafeteria']                  == 1 ? '<div class="col-lg-4">Cafetería</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['golf']                       == 1 ? '<div class="col-lg-4">Campo de Golf</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['paddle_tennis']              == 1 ? '<div class="col-lg-4">Cancha de Paddle</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['squash']                     == 1 ? '<div class="col-lg-4">Cancha de Squash</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['tennis']                     == 1 ? '<div class="col-lg-4">Cancha de Tennis</div>' : "") ?>
                                

                                <?php echo ($desarrollo['Desarrollo']['carril_nado']                == 1 ? '<div class="col-lg-4">Carril de Nado</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['fire_pit']                   == 1 ? '<div class="col-lg-4">Fire Pit</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['gimnasio']                   == 1 ? '<div class="col-lg-4">Gimnasio</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['jacuzzi']                    == 1 ? '<div class="col-lg-4">Jacuzzi</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['living']                     == 1 ? '<div class="col-lg-4">Living</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['lobby']                      == 1 ? '<div class="col-lg-4">Lobby</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['boliche']                    == 1 ? '<div class="col-lg-4">Mesa de Boliche</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['pista_jogging']              == 1 ? '<div class="col-lg-4">Pista de Jogging</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['play_room']                  == 1 ? '<div class="col-lg-4">Play Room / Cuarto de Juegos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['restaurante']                == 1 ? '<div class="col-lg-4">Restaurante</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['roof_garden_compartido']     == 1 ? '<div class="col-lg-4">Roof Garden</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['salon_juegos']               == 1 ? '<div class="col-lg-4">Salón de Juegos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['salon_usos_multiples']       == 1 ? '<div class="col-lg-4">Salón de usos múltiples</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sauna']                      == 1 ? '<div class="col-lg-4">Sauna</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['spa_vapor']                  == 1 ? '<div class="col-lg-4">Spa</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sky_garden']                 == 1 ? '<div class="col-lg-4">Sky Garden</div>' : "") ?>
                            </div>
                            <div class="col-sm-12 m-t-20">
                                <h4 class="text-black">- SERVICIOS</h4>
                                <?php echo ($desarrollo['Desarrollo']['acceso_discapacitados']      == 1 ? '<div class="col-lg-4">Acceso de discapacitados</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['internet']                   == 1 ? '<div class="col-lg-4">Acceso Internet / WiFi</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['tercera_edad']               == 1 ? '<div class="col-lg-4">Acceso para Tercera Edad</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['aire_acondicionado']         == 1 ? '<div class="col-lg-4">Aire Acondicionado</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['business_center']            == 1 ? '<div class="col-lg-4">Business Center</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['calefaccion']                == 1 ? '<div class="col-lg-4">Calefacción</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cctv']                       == 1 ? '<div class="col-lg-4">CCTV</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna: '.$desarrollo['Desarrollo']['m_cisterna'].'l.</div>' : "")?>
                                <?php echo ($desarrollo['Desarrollo']['conmutador']                 == 1 ? '<div class="col-lg-4">Conmutador</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['edificio_inteligente']       == 1 ? '<div class="col-lg-4">Edificio Inteligente</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['edificio_leed']              == 1 ? '<div class="col-lg-4">Edificio LEED</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['elevadores']                 == 1 ? '<div class="col-lg-4">Elevadores: '.$desarrollo['Desarrollo']['q_elevadores'].'</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-4">Estacionamiento de visitas</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['gas_lp']                     == 1 ? '<div class="col-lg-4">Gas LP</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['gas_natural']                == 1 ? '<div class="col-lg-4">Gas Natural</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['lavanderia']                 == 1 ? '<div class="col-lg-4">Lavanderia</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['locales_comerciales']        == 1 ? '<div class="col-lg-4">Locales Comerciales</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['mascotas']                   == 1 ? '<div class="col-lg-4">Permite Mascotas</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['planta_emergencia']          == 1 ? '<div class="col-lg-4">Planta de Emergencia</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['porton_electrico']           == 1 ? '<div class="col-lg-4">Portón Eléctrico</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sistema_contra_incendios']   == 1 ? '<div class="col-lg-4">Sistema Contra Incendios</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sistema_seguridad']          == 1 ? '<div class="col-lg-4">Sistema de Seguridad</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['valet_parking']              == 1 ? '<div class="col-lg-4">Valet Parking</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['vapor']                      == 1 ? '<div class="col-lg-4">Vapor</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['seguridad']                  == 1 ? '<div class="col-lg-4">Vigilancia / Seguridad</div>' : "") ?>
                            </div>
                        </div>
                    </div>
                    <!-- ./row amenidades servicios -->
                </div>
            </div>
            <!-- /.card datos generales -->

            <div class="card m-t-10">
                <div class="card-header"  style="background-color: #2e3c54; color:white">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <h4>inventario</h4>
                        </div>
                        <?php if ($this->Session->read('Permisos.Group.id')==1 ||($desarrollo['EquipoTrabajo']['administrador_id']=="" && $this->Session->read('Permisos.Group.id')==2) ||$desarrollo['EquipoTrabajo']['administrador_id']==$this->Session->read('Auth.User.id')): ?>
                            <div class="col-sm-12 col-lg-6 text-lg-right">
                                <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Crear Unidad',array('controller'=>'inmuebles','action'=>'add_unidades',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-link btn-sm','style'=>'background-color: green; color:white'))?>
                                
                                <?= $this->Html->link('<i class="fa fa-edit fa-1x"></i>Modificación Masiva',array('controller'=>'inmuebles','action'=>'modificacion',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-link btn-sm','style'=>'background-color: green; color:white'))?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <style>
                    .chips{
                      border-radius: 5px;
                      text-align: center; 
                      -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
                      -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
                      box-shadow: 3px 1px 16px rgba(184,184,184,0.50)º;
                    }
                </style>
                <div class="card-block cards_section_margin">
                    <?= $this->Form->create('Inmueble', array('url'=>array('controller'=>'Inmuebles', 'action'=>'update_inventario'))); ?>
                        <!-- Table -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered table-hover table-sm" id="inventario">
                                    <thead>
                                        <tr>
                                            <th>Referencia</th>
                                            <th>Título</th>
                                            <th>Operación</th>
                                            <th>$</th>
                                            <th><?= $this->Html->image('m2.png',array('width'=>'20px'))?></th>
                                            <th><?= $this->Html->image('recamaras.png',array('width'=>'20px'))?></th>
                                            <th><?= $this->Html->image('banios.png',array('width'=>'20px'))?></th>
                                            <th><?= $this->Html->image('autos.png',array('width'=>'20px'))?></th>
                                            <th>Status</th>
                                            <!-- <th></th>
                                            <th></th> -->
                                            <!-- <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                <th><?= "Cambiar Estado" ?></th>
                                                <th>
                                                    <i class="fa fa-check" title="LIBERAR" data-placement="top" data-toggle="tooltip"></i>
                                                </th>
                                            <?php endif ?>
                                            <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                <th style="text-align:center"><i class="fa fa-trash fa-lg" title="ELIMINAR" data-placement="top" data-toggle="tooltip"></i></th>
                                            <?php endif ?> -->
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 0;
                                            foreach ($desarrollo['Propiedades'] as $tipo):
                                            $i++;
                                        ?>

                                            <?php if ($this->Session->read('Permisos.Group.id')!=3 || $this->Session->read('Permisos.Group.id')==3 && $tipo['liberada'] == 1): ?>
                                                <tr>
                                                    <td>
                                                        <span style="width: 200px; display: inline-block;">
                                                            <?php
                                                                if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                                                                    echo $tipo['referencia'];
                                                                }else{
                                                            
                                                                    if ($tipo['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3) {
                                                                        echo $this->Html->link($tipo['referencia'], array('action' => 'view_tipo', 'controller' => 'inmuebles', $tipo['id'],$desarrollo['Desarrollo']['id']));
                                                                    } else {
                                                                        echo $tipo['referencia'];
                                                                    }
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="width: 300px; display: inline-block;">
                                                            <?php
                                                                if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                                                                    echo $tipo['titulo'];
                                                                }else{
                                                            
                                                                    if ($tipo['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3) {
                                                                        echo $this->Html->link($tipo['titulo'], array('action' => 'view_tipo', 'controller' => 'inmuebles', $tipo['id'],$desarrollo['Desarrollo']['id']));
                                                                    } else {
                                                                        echo $tipo['titulo'];
                                                                    }
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo $tipo['venta_renta'] ?></td>
                                                    <td><?php
                                                        if ($tipo['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3)
                                                            echo "$" . number_format($tipo['precio'], 2);
                                                        ?>
                                                    </td>
                                                    <td><?php echo $tipo['construccion']+$tipo['construccion_no_habitable'] ?>m2</td>
                                                    <td><?php echo $tipo['recamaras'] ?></td>
                                                    <td><?php echo $tipo['banos'] ?> / <?php echo $tipo['medio_banos'] ?></td>
                                                    <td><?php echo $tipo['estacionamiento_techado'] + $tipo['estacionamiento_descubierto'] ?></td>
                                                    <td>
                                                        <small>
                                                            <?php
                                                                switch ($tipo['liberada']) {
                                                                case 0: //No liberada
                                                                    echo "<span class='chip' style='text-align: center; background-color: #ffff00; color:#000;'>BLOQUEADO</span>";
                                                                    break;

                                                                case 1: // Libre
                                                                    echo "<span class='chip' style='text-align: center; background-color: #48d1cc; color:white;'>LIBRE</span>";
                                                                    break;

                                                                case 2:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #ffd700'>RESERVA</span>";
                                                                    break;

                                                                case 3:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #3cb371; color: white;'>CONTRATO</span>";
                                                                    break;

                                                                case 4:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #8b4513; color: white;'>ESCRITURACION</span>";
                                                                    break;
                                                                case 5:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #BLACK'>BAJA</span>";
                                                                    break;
                                                                } 
                                                            ?>
                                                            
                                                        </small>
                                                    </td>
                                                        <!-- <td>
                                                    <?php if ($this->Session->read('Permisos.Group.ilib') == 1 && $tipo['liberada'] != 4): ?>
                                                            <?php
                                                            if ($tipo['liberada'] != 0) {
                                                                echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'inmuebles','action' => 'status', $tipo['id'],0,$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BORRADOR','escape'=>false,'style'=>'margin-right:5px'));
                                                            }
                                                            /*if ($tipo['liberada'] != 1) {
                                                                echo $this->Html->link('<i class="fa fa-check"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 1, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LIBRE','escape'=>false,'style'=>'margin-right:5px'));
                                                            }*/
                                                            if ($tipo['liberada'] != 2) {
                                                                echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 2, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'RESERVADO','escape'=>false,'style'=>'margin-right:5px'));
                                                            }
                                                            if ($tipo['liberada'] != 3) {
                                                                echo $this->Html->link('<i class="fa fa-file"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 3, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'CONTRATO','escape'=>false,'style'=>'margin-right:5px'));
                                                            }
                                                            if ($tipo['liberada'] != 4) {
                                                                echo $this->Html->link('<i class="fa fa-certificate"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 4, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'ESCRITURACIÓN','escape'=>false,'style'=>'margin-right:5px'));
                                                            }
                                                            if ($tipo['liberada'] != 5) {
                                                                echo $this->Html->link('<i class="fa fa-times"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 5, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BAJA','escape'=>false,'style'=>'margin-right:5px'));
                                                            }
                                                            ?>
                                                    <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($this->Session->read('Permisos.Group.ilib') == 1 && $tipo['liberada'] != 4): ?>
                                                                <?php if ($tipo['liberada'] != 1 && $tipo['liberada'] != 3): ?>
                                                                    <div class="checkbox" style="height: 10px;">
                                                                      <label style="height: 8px;">
                                                                        <input type="checkbox" style="height: 8px;" name="data[<?= $i ?>][liberar]">
                                                                        <span class="cr" style="height: 13px; width: 13px;"><i class="cr-icon fa fa-check"></i></span>
                                                                      </label>
                                                                    </div>
                                                                    <?= $this->Form->hidden('desarrollo_tipo', array('value'=>$tipo['id'], 'name'=>'data['.$i.'][inmueble_id]')) ?>
                                                                    <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo_id, 'name'=>'data[General][desarrollo_id]')) ?>

                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        </td>
                                                    <?php if ($this->Session->read('Permisos.Group.id')==1 || $desarrollo['EquipoTrabajo']['administrador_id']==$this->Session->read('Auth.User.id')):?>
                                                        <td class="text-center">
                                                            <?php if ($tipo['liberada'] < 1): ?>
                                                                <div class="checkbox" style="height: 10px;">
                                                                  <label style="height: 8px;">
                                                                    <input type="checkbox" style="height: 8px;" name="data[<?= $i ?>][borrar]">
                                                                    <span class="cr" style="height: 13px; width: 13px;"><i class="cr-icon fa fa-check"></i></span>
                                                                  </label>
                                                                </div>
                                                            <?php endif ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <i class="fa fa-copy" style="cursor: pointer;" onclick="modal_duplicado(<?= $tipo['id'] ?>);"></i>
                                                    </td> -->
                                                </tr>
                                            <?php endif ?>
                                            <?= $this->Form->hidden('desarrollo_tipo', array('value'=>$tipo['id'], 'name'=>'data['.$i.'][inmueble_id]')) ?>
                                            <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo_id, 'name'=>'data[General][desarrollo_id]')) ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->submit('Guardar cambios', array('class'=>'btn btn-success')); ?>
                            </div>
                        </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        
    <!-- ./card inventario -->
    <!-- Script para elminar -->
    <script>
        function modal_duplicado(id){
            // alert('Vamos a duplicar el id ' + id);
            $('#duplicar_tipo').modal();
            $('#ClonInmuebleId').val(id);
        }
    </script>

    <div class="row">
        <div class="col-lg-3">
            <div class="card m-t-10" style="height: 190px;">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Personas interesadas
                </div>
                <div class="card-block cards_section_margin">
                    <div class="row">
                        <a href="#interesados" style="color:black">
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
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card m-t-10" style="height: 190px;">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Citas
                </div>
                <div class="card-block cards_section_margin">
                    <div class="row">
                    
                        <?php 
                        if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                        ?>
                        <a href="#" style="color:black">
                        <?php }else{?>
                        <a href="/desarrollos/log_desarrollo/<?= $desarrollo['Desarrollo']['id']?>/6" style="color:black">
                        <?php }?>
                        <div class="col-lg-12">
                            <div class="widget_icon_bgclr icon_align bg-white section_border">
                                <div class="bg_icon bg_icon_info float-xs-left">
                                    <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                </div>
                                <div class="text-xs-right">
                                    <h3 class="kpi"><?= $visitas?></h3>
                                    <p>Citas</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
             </div>
        </div>
        <div class="col-lg-3">
            <div class="card m-t-10" style="height: 190px;">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Llamadas
                </div>
                <div class="card-block cards_section_margin">
                    <div class="row">
                    	<?php 
                        if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                        ?>
                        <a href="#" style="color:black">
                        <?php }else{?>
                        <a href="/desarrollos/log_desarrollo/<?= $desarrollo['Desarrollo']['id']?>/4" style="color:black">
                        <?php }?>
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
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3">
            <div class="card m-t-10" style="height: 190px;">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    E-mails
                </div>
                <div class="card-block cards_section_margin">
                    <div class="row">
                    	<?php 
                        if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                        ?>
                        <a href="#" style="color:black">
                        <?php }else{?>
                        <a href="/desarrollos/log_desarrollo/<?= $desarrollo['Desarrollo']['id']?>/5" style="color:black">
                        <?php }?>
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
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- /.row de actividades calendario -->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">

              // Load the Visualization API and the corechart package.
              google.charts.load('current', {'packages':['corechart']});
              
              // Set Callback Forma de contacto
              google.charts.setOnLoadCallback(drawFormasContacto);
//            // Set Callback Precios  
              
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
              
              
            </script>
    <div class="row">
        <div class="col-lg-12 m-t-10">
            <div class="card">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    <?php 
                        $suma=0;
                        foreach ($contactos as $contacto):
                            $suma+=$contacto[0]['total'];
                        endforeach;
                    ?>
                    Formas de contacto: Total: <?= $suma ?> contactos
                </div>
                <div class="card-block" style="overflow-y: scroll; height:350px !important">
                    <div class="col-lg-12">
                        <div class="demo-container">
                            <div id="grafica_contactos"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 m-t-10">
            <div class="card">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Ubicación del desarrollo
                </div>
                <?php
                    list($latitud, $longitud) = explode(",", $desarrollo['Desarrollo']['google_maps']);
                ?>
                <div class="card-block twitter_section" style="overflow-y: scroll; height:350px !important">
                    <div id="map"></div>
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
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="interesados">
        <div class="col-lg-12 m-t-10">
            <div class="card">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Lista de Posibles clientes
                </div>
                <div class="card-block m-t-10" >
                    <div class="col-lg-12 m-t-10">
                       <div class="pull-sm-right m-t-10">
                                                <div class="tools pull-sm-right"></div>
                                            </div>
                        <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                    <!--<th>Inmueble / Desarrollo Interesado</th>-->
                                    <th>Forma de Contacto</th>
                                    <th>Correo Electrónico</th>
                                    <th>Teléfono</th>
                                    <th>Status Cliente</th>
                                    <th>Etapa de Lead</th>
                                    <th>Fecha de Creación</th>
                                    <th>Comentarios</th>
                                    <th>Asesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($desarrollo['Interesados'] as $lead):?>
                                    <?php 
                                        if ($lead['user_id']==$this->Session->read('Auth.User.id') || $this->Session->read('Permisos.Group.call')==1){
                                        /*if ($lead['user_id'] != ''){*/
                                    ?>
                                            <tr>
                                                <?php 
                                                switch ($lead['temperatura']){
                                                    case 1:
                                                        $custom_temp['class'] = 'bg_frio';
                                                        $custom_temp['temp'] = 'F';
                                                        $custom_temp['temperatura'] = 'Frio';
                                                        break;
                                                    case 2:
                                                        $custom_temp['class'] = 'bg_tibio';
                                                        $custom_temp['temp'] = 'T';
                                                        $custom_temp['temperatura'] = 'Tibio';
                                                        break;
                                                    case 3:
                                                        $custom_temp['class'] = 'bg_caliente';
                                                        $custom_temp['temp'] = 'C';
                                                        $custom_temp['temperatura'] = 'Caliente';
                                                        break;
                                                }
                                                ?>
                                                <td>
                                                    <small><span class="chip <?= $custom_temp['class'] ?>"> <?= $custom_temp['temp'] ?> </span></small>
                                                    <span style="display: none;"><?= $custom_temp['temperatura'] ?></span>
                                                </td>
                                                <td><?= $this->Html->link($lead['nombre'],array('controller'=>'clientes','action'=>'view',$lead['id']))?></td>
                                                <td ><?php echo (isset($lineas_contactos[$lead['dic_linea_contacto_id']]) ? $lineas_contactos[$lead['dic_linea_contacto_id']] : "Desconocido")?></td>
                                                <td ><?php echo $lead['correo_electronico']?></td>
                                                <td ><?php echo $lead['telefono1']?></td>
                                                <td ><?php echo $lead['status']?></td>
                                                <td ><?php echo $lead['leads']['status']?></td>
                                                <td ><?php echo date_format(date_create($lead['created']),"d-M-Y")?></td>
                                                <td>
                                                    <?php
                                                        $comentario = $lead['comentarios'];
                                                    if (strlen($comentario) >= 30) {
                                                        $rest = substr($comentario, 0, 30);
                                                        $comentario = $rest." <ins>".$this->Html->link("Continuar leyendo...", array('action'=>'view', $lead['id']))."</ins>";
                                                    }
                                                    echo $comentario;
                                                    ?>
                                                </td>
                                                <td ><?php echo $usuarios[$lead['user_id']]?></td>
                                            </tr>
                                    <?php 
                                        /*}*/
                                            }
                                      
                                    ?>
                                <?php endforeach;?>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row listado de posibles clientes -->
    <div class="row">
        <div class="col-lg-4 m-t-10">
            <div class="card">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Documentos anexos.
                    <div style="float:right">
                        <?php echo $this->Html->link('<i class="fa fa-mail-forward fa-2x"></i>','#',array('data-target'=>"#archivos",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','title'=>'Reenviar Archivos','escape'=>false,'style'=>'color:white'));?>
                    </div>
                </div>
                <div class="card-block" style="overflow-y: scroll; height:330px !important">
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="80%"><b>Documento</b></th>
                            <th width="20%"><b>Descargar</b></th>
                            
                        </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($desarrollo['DocumentosUser'] as $documento):?>
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
        <div class="col-lg-4 m-t-10">
            <div class="card" >
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Eventos de Hoy
                </div>
                <div class="card-block" style="overflow-y: scroll; height:330px !important">
                    <?php foreach ($desarrollo['Evento'] as $evento):?>
                    <a href="#" class="list-group-item calendar-list">
                        <div class="tag tag-pill tag-primary float-xs-right"><?= date('H:i',  strtotime($evento['fecha_inicio']))?></div>
                        <?= $evento['nombre_evento']?>
                        <small><?= $usuarios[$evento['user_id']]?></small>
                    </a>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 m-t-10">
            <div class="card">
                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                    Últimas actividades
                </div>
                <div class="card-block twitter_section" style="overflow-y: scroll; height:330px !important">
                    <ul id="nt-example1">
                        <?php foreach ($desarrollo['Log'] as $log):?>
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
</div>
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
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',

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
    // ===============table inventario====================
    var inventario = function() {
        var table = $('#inventario');
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'InventarioDesarrollo',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'InventarioDesarrollo',
                },
            ],
            // order: false,
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }


    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'InventarioDesarrollo',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'InventarioDesarrollo',
                },
                
                
            ]
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
    
    var initTable2 = function() {
        var table = $('#sample_2');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'ClientesDesarrollo',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'ClientesDesarrollo',
                },
                
                
            ]
        });
        var tableWrapper = $('#sample_2_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
    
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
            initTable2();
            inventario();
        }
    };
    
    
}();
</script>