<?php
    $interesados = count($desarrollo['Interesados']);
    error_reporting(E_ERROR | E_PARSE);
    $count = 0;
    $data_status_prop = array('bloqueados'=>0, 'libres'=>0, 'reserva'=>0, 'contrato'=>0, 'escrituracion'=>0, 'baja'=>0);
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
           
            // Css Calendario
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',

            // Upload archiv
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',

            //Chosen
            '/vendors/chosen/css/chosen',
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

.kv-fileinput-caption{
    height: 29px;
}
</style>

<!-- Modales -->
<!-- Registro de campaña publicitaria -->
<div class="modal fade" id="publicidad" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-plus"></i>
                    Registrar campaña
                </h4>
            </div>
            <?= $this->Form->create('Publicidad',array('url'=>array('action'=>'add','controller'=>'publicidads')))?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="nombre_evento" class="form-control-label">Nombre*</label>
                    </div>
                    <?= $this->Form->input('nombre',array('class'=>'form-control','placeholder'=>'Nombre','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Objetivo</label>
                    </div>
                    <?= $this->Form->input('objetivo',array('type'=>'textarea','class'=>'form-control','placeholder'=>'Objetivo','div'=>'col-md-6 m-t-15','label'=>false,))?>
                </div>
                <div class="row">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="nombre_evento" class="form-control-label">Inversión</label>
                    </div>
                    <?= $this->Form->input('inversion_prevista',array('class'=>'form-control','placeholder'=>'Inversión','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    
                    <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="cliente" class="form-control-label">Medio</label>
                        </div>

                    <?= $this->Form->input('dic_linea_contacto_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Seleccionar medio','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$lineas_contactos))?>
                    
                    <div class="input-group">
                        <div class="col-lg-3 text-xl-left m-t-15">
                            <label for="Del" class="form-control-label">Fecha de campaña</label>
                        </div>
                        <?= $this->Form->input('fi',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    </div>
                    <?= $this->Form->hidden('return',array('value'=>2))?>
                    <?= $this->Form->hidden('desarrollo_id',array('value'=>$desarrollo['Desarrollo']['id']))?>
                    <?= $this->Form->hidden('cuenta_id',array('value'=>$desarrollo['Desarrollo']['cuenta_id']))?>
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
                    Registrar campaña
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

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
                        <?php 
                            if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']) {
                                
                                if ($this->Session->read('Permisos.Group.id')==1 ||($desarrollo['EquipoTrabajo']['administrador_id']=="" && $this->Session->read('Permisos.Group.id')==2) ||$desarrollo['EquipoTrabajo']['administrador_id']==$this->Session->read('Auth.User.id')){

                                    echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'edit_generales',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR DESARROLLO','escape'=>false,'style'=>'color:white'));

                                }elseif( $this->Session->read('Permisos.Group.id') == 5 ){

                                    echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>','#', array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR DESARROLLO','escape'=>false,'style'=>'color: #bababa; cursor:not-allowed !important;'));

                                }
                            } 
                            
                                echo $this->Html->link('<i class="fa fa-home fa-2x"></i>',array('action'=>'detalle',$desarrollo['Desarrollo']['id'],$this->Session->read('Auth.User.id')),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'VER FICHA TÉCNICA PÚBLICA','escape'=>false,'style'=>'color:white'));
                            
                                if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']) {
                                    
                                    if ($this->Session->read('Permisos.Group.id')==1){
                                        
                                        echo $this->Html->link('<i class="fa fa-briefcase fa-2x"></i>',array('action'=>'asignar_corretaje',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'ASIGNAR A EMPRESA DE COMERCIALIZACIÓN','escape'=>false,'style'=>'color:white'));
                                        
                                        echo $this->Html->link('<i class="fa fa-external-link-square fa-2x"></i>',array('action'=>'cambiar_titular',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'TRANSFERIR DESARROLLO A OTRA CUENTA','escape'=>false,'style'=>'color:white'));
                                    
                                    }elseif( $this->Session->read('Permisos.Group.id') == 5 ){

                                        echo $this->Html->link('<i class="fa fa-briefcase fa-2x"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'ASIGNAR A EMPRESA DE COMERCIALIZACIÓN','escape'=>false,'style'=>'color: #bababa; cursor:not-allowed !important;'));
                                        
                                        echo $this->Html->link('<i class="fa fa-external-link-square fa-2x"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'TRANSFERIR DESARROLLO A OTRA CUENTA','escape'=>false,'style'=>'color: #bababa; cursor:not-allowed !important;'));

                                    }
                                }
                            ?>
                        </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12 col-lg-9">
                            <div class="card" >
                                <div class="card-header">
                                    <?php echo $desarrollo['Desarrollo']['calle'] . " " . $desarrollo['Desarrollo']['numero_ext'] . " " . $desarrollo['Desarrollo']['numero_int'] . " " . $desarrollo['Desarrollo']['colonia']?>
                                    <?php echo $desarrollo['Desarrollo']['ciudad'] . " " . $desarrollo['Desarrollo']['estado'] . " CP: " . $desarrollo['Desarrollo']['cp']?>
                                    
                                    <div style="float:right">
                                        <?php
                                          $shared_desarrollo = Router::url('/Desarrollos/detalle/'.$desarrollo['Desarrollo']['id'],true);
                                        ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-facebook fa-lg"></i>',
                                            'http://www.facebook.com/sharer.php?u='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-twitter fa-lg"></i>',
                                            'https://twitter.com/intent/tweet?text='." Les comparto este increíble desarrollo vía @adryo_ai ".$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>
                                        

                                        <?= $this->Html->link(
                                            '<i class="fa fa-linkedin fa-lg"></i>',
                                            'https://www.linkedin.com/shareArticle?url='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Col logo desarrollo -->
                        <div class="col-sm-4 col-lg-3 flex-center">
                            <?php if (!empty($desarrollo['Desarrollo']['logotipo'])): ?>
                                <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'],array('class'=>'img-fluid', 'style'=>'max-width: 70%;'))?>
                            <?php else: ?>
                                <div class="text-center text-danger">
                                    <h4 class="text-danger">
                                        ¡Falta Logotipo del desarrollo!
                                    </h4>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /Direcciones -->

                    <div class="row" style="width:101%">
                        
                        <div class="col-lg-4 m-t-10">
                            <?php
                                // if( !isset( $desarrollo['FotoDesarrollo'] ) ) {
                                //     $foto = $desarrollo['FotoDesarrollo'][0]['ruta'];
                                // }else { 
                                //     $foto = '/img/inmueble_no_photo.png';
                                // }
                                $foto = ( isset($desarrollo['FotoDesarrollo'][0])?$desarrollo['FotoDesarrollo'][0]['ruta']:'/img/inmueble_no_photo.png') 
                            ?>

                            <div class="col-sm-12" style="height:35vh;background-image: url('<?php echo Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?php echo Router::url('/',true).$foto ?>');">
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
                                                <?= $this->Html->link($this->Html->image('/img/matterport_logo.png', array('class'=>'img-fluid')), $desarrollo['Desarrollo']['matterport'], array('escape'=> false, 'target'=>'blank')) ?>
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
                                    <?php if (!empty($desarrollo['Comercializador'])){?>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Comercializadora: </td>
                                        <td style="width:50%; vertical-align: top;"><b><?= $desarrollo['Comercializador']['nombre_comercial']?></b></td>
                                    </tr>
                                    <?php }?>
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
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Objetivo de Ventas:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= (!isset($desarrollo['ObjetivoAplicable'][0]['monto'])?"SIN OBJETIVO DEFINIDO":"$".number_format($desarrollo['ObjetivoAplicable'][0]['monto'],0))?></b></td>
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
                            <h4>inventario - Total de unidades <?= count($desarrollo['Propiedades']) ?></h4> 
                        </div>
                        <?php 
                            if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']) {
                                if ($this->Session->read('Permisos.Group.de')==1 ||($desarrollo['EquipoTrabajo']['administrador_id']=="" && $this->Session->read('Permisos.Group.id')==2) ||$desarrollo['EquipoTrabajo']['administrador_id']==$this->Session->read('Auth.User.id')): ?>
                            <div class="col-sm-12 col-lg-6 text-lg-right">
                                <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Crear Unidad',array('controller'=>'inmuebles','action'=>'add_unidades',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-link btn-sm','style'=>'background-color: green; color:white'))?>
                                
                                <?= $this->Html->link('<i class="fa fa-edit fa-1x"></i>Modificación Masiva',array('controller'=>'inmuebles','action'=>'modificacion',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-link btn-sm','style'=>'background-color: green; color:white'))?>
                            </div>
                        <?php 
                            endif;
                                }
                        ?>
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
                    .number{
                        display: block;
                        width: 100%;
                    }
                </style>
                <div class="card-block cards_section_margin">
                    <div class="row">
                        <div class="col-sm-4 col-lg-2 text-center">
                            Bloqueados
                            <div class="number">
                                <span class="chips" style="padding: 2px 5px 2px 5px; background: #FFFF00; color: #3D3D3D;" id="bloqueado">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Libres
                            <div class="number">
                                <span class="chips" style="padding: 2px 5px 2px 5px; background: rgb(0, 64 , 128); color: #FFF;" id="libre">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Reservados
                            <div class="number">
                                <span class="chips" style="padding: 2px 5px 2px 5px; background: #FFA500; color: #FFF;" id="reserva">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Contrato
                            <div class="number">
                                <span class="chips" style="padding: 2px 5px 2px 5px; background: RGB(116, 175, 76); color: #FFF;" id="contrato">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Escrituración
                            <div class="number">
                                <span class="chips" style="padding: 2px 5px 2px 5px; background: #8B4513; color: #FFF;" id="escrituracion">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Baja
                            <div class="number">
                                <span class="chips" style="padding: 2px 5px 2px 5px; background: #000000; color: #FFF;" id="baja">
                                </span>
                            </div>
                        </div>
                    </div>





                    <?= $this->Form->create('Inmueble', array('url'=>array('controller'=>'Inmuebles', 'action'=>'update_inventario'))); ?>
                        <!-- Table -->
                        <div class="row mt-2">
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
                                            <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                <th><?= "Cambiar Estado" ?></th>
                                                <th>
                                                    Liberar
                                                    <i class="fa fa-check" title="LIBERAR" data-placement="top" data-toggle="tooltip"></i>
                                                </th>
                                            <?php endif ?>
                                            <?php if ($this->Session->read('Permisos.Group.dd') == 1): ?>
                                                <th style="text-align:center">Eliminar<i class="fa fa-trash fa-lg" title="ELIMINAR" data-placement="top" data-toggle="tooltip"></i></th>
                                                <!-- <th></th> -->
                                            <?php endif ?>
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
                                                            
                                                                    if ($tipo['liberada'] != 0 || $this->Session->read('Permisos.Group.dr') == 1) {
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
                                                            
                                                                    if ($tipo['liberada'] != 0 || $this->Session->read('Permisos.Group.dr') == 1) {
                                                                        echo $this->Html->link($tipo['titulo'], array('action' => 'view_tipo', 'controller' => 'inmuebles', $tipo['id'],$desarrollo['Desarrollo']['id']));
                                                                    } else {
                                                                        echo $tipo['titulo'];
                                                                    }
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center"><?php echo $tipo['venta_renta'] ?></td>
                                                    <td>
                                                        <span style="width: 140px; display: inline-block;">
                                                        <?php
                                                            if ($tipo['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3){
                                                                // echo "$" . number_format($tipo['precio'], 2);
                                                                switch($tipo['venta_renta']) {
                                                                    case 'Venta / Renta':
                                                                        echo "V- $" . number_format($tipo['precio'], 2).'<br> R- '."$" . number_format($tipo['precio_2'], 2);
                                                                    break;
                                                                    case 'Venta':
                                                                        echo "V- $" . number_format($tipo['precio'], 2);
                                                                    break;
                                                                    case 'Renta':
                                                                        echo 'R- '."$" . number_format($tipo['precio_2'], 2);
                                                                    break;
                                                                }
                                                            }
                                                        ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span style="width: 75px; display: inline-block;">
                                                            <?php echo number_format($tipo['construccion'] + $tipo['construccion_no_habitable'], 2) ?> m2
                                                        </span>
                                                    </td>
                                                    <td class="text-center"><?php echo $tipo['recamaras'] ?></td>
                                                    <td class="text-center"><?php echo $tipo['banos'] ?> / <?php echo $tipo['medio_banos'] ?></td>
                                                    <td class="text-center"><?php echo $tipo['estacionamiento_techado'] + $tipo['estacionamiento_descubierto'] ?></td>
                                                    <td>
                                                        <small>
                                                            <?php
                                                                switch ($tipo['liberada']) {
                                                                case 0: //No liberada
                                                                    echo "<span class='chip' style='text-align: center; background-color: #FFFF00; color:#3D3D3D;'>BLOQUEADO</span>";
                                                                    $data_status_prop['bloqueados'] ++;
                                                                    break;

                                                                case 1: // Libre
                                                                    echo "<span class='chip' style='text-align: center; background-color: rgb(0, 64 , 128); color:white;'>LIBRE</span>";
                                                                    $data_status_prop['libres'] ++;
                                                                    break;

                                                                case 2:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #FFA500'>RESERVADO</span>";
                                                                    $data_status_prop['reserva'] ++;
                                                                    break;

                                                                case 3:
                                                                    echo "<span class='chip' style='text-align: center; background-color: RGB(116, 175, 76); color: white;'>CONTRATO</span>";
                                                                    $data_status_prop['contrato'] ++;
                                                                    break;

                                                                case 4:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #8B4513; color: white;'>ESCRITURACION</span>";
                                                                    $data_status_prop['escrituracion'] ++;
                                                                    break;
                                                                case 5:
                                                                    echo "<span class='chip' style='text-align: center; background-color: #000000'>BAJA</span>";
                                                                    $data_status_prop['baja'] ++;
                                                                    break;
                                                                } 
                                                            ?>
                                                            
                                                        </small>
                                                    </td>
                                                    <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                        <td>
                                                            <?php if ($this->Session->read('Permisos.Group.ilib') == 1 && $tipo['liberada'] != 4): ?>
                                                                <?php

                                                                    // 0=> Bloqueada, 1=> Libre, 2=> Reservado, 3=> Contrato, 4=> Escrituracion, 5=> Baja
                                                                    switch( $tipo['liberada']  ) {
                                                                        case 1:
                                                                            // Bloquear, Reservar, Baja
                                                                            echo $this->Html->link('<i class="fa fa-lock fa-lg"></i>', array('controller' => 'inmuebles','action' => 'status', $tipo['id'],0,$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BLOQUEAR','escape'=>false,'style'=>'margin-right:5px'));

                                                                            echo $this->Html->link('<i class="fa fa-calendar fa-lg"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 2, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'RESERVAR','escape'=>false,'style'=>'margin-right:5px'));
                                                                            
                                                                            echo $this->Html->link('<i class="fa fa-times fa-lg"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 5, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BAJA','escape'=>false,'style'=>'margin-right:5px'));
                                                                        break;
                                                                        case 3:
                                                                            // Escrituracion
                                                                            echo $this->Html->link('<i class="fa fa-certificate"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 4, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'ESCRITURACIÓN','escape'=>false,'style'=>'margin-right:5px'));
                                                                        break;
                                                                        default:
                                                                        break;
                                                                    }
                                                                
                                                                ?>
                                                        <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($this->Session->read('Permisos.Group.ilib') == 1): ?>
                                                                <?php if ($tipo['liberada'] == 2 or $tipo['liberada'] == 5 or $tipo['liberada'] == 0): ?>
                                                                <?php /* if ($tipo['liberada'] != 1 && $tipo['liberada'] != 3):*/ ?>
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
                                                    <?php endif ?>
                                                    <?php if ($this->Session->read('Permisos.Group.dd') == 1): ?>
                                                         <td>
                                                            <?php if ($tipo['liberada'] == 0 || $tipo['liberada'] == 5): ?>
                                                                <div class="checkbox" style="height: 10px;">
                                                                  <label style="height: 8px;">
                                                                    <input type="checkbox" style="height: 8px;" name="data[<?= $i ?>][borrar]">
                                                                    <span class="cr" style="height: 13px; width: 13px;"><i class="cr-icon fa fa-check"></i></span>
                                                                  </label>
                                                                </div>
                                                            <?php endif ?>
                                                        </td>
                                                    <?php endif ?>
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
                                <?php
                                    if ($this->Session->read('Permisos.Group.de') == 1 || $this->Session->read('Permisos.Group.dd') == 1) {
                                        echo $this->Form->submit('Guardar cambios', array('class'=>'btn btn-success'));
                                    }
                                ?>
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

    


    <!-- row de eventos de calendario  -->
        <?= $this->element('Events/eventos_cards'); ?>
    <!-- end row de eventos de calendario -->
    <?php if ($this->Session->read('Permisos.Group.id')!=3){?>
    
    <div class="row mt-1">
        <div class="col-sm-12">
            <?= $this->Element('Desarrollos/ventas_vs_metas_anual') ?>
        </div>
    </div>
    
    <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Desarrollos/ventas_vs_metas') ?>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_linea_contacto_mes') ?>
        </div>
      </div>
      
      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_linea_contacto') ?>
        </div>
      </div>
      
      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_linea_contacto_visitas') ?>
        </div>
      </div>
    
      <div class="row mt-1">
              <div class="col-sm-12">
                <?= $this->Element('Ventas/ventas_acumuladas_asesores') ?>
              </div>
            </div>
    
        <div class="row mt-1">
            <div class="col-sm-12">
            <?= $this->Element('Desarrollos/publicidad_historica') ?>
            </div>
        </div>
    <?php }?>
    <div class="row">
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
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0&callback=initMap">
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
                                                <td ><?php echo rtrim(str_replace(array("(", ")"," ", "-"), "", $lead['telefono1']))?></td>
                                                <td ><?php echo $lead['status']?></td>
                                                <td ><?php echo $lead['leads']['status']?></td>
                                                <td ><?php echo date_format(date_create($lead['created']),"Y-m-d")?></td>
                                                <td>
                                                    <?php
                                                        $comentario = $lead['comentarios'];
                                                        if (strlen($comentario) >= 30) {
                                                            $rest = substr($comentario, 0, 30);
                                                            $comentario = $rest." <ins>".$this->Html->link("Continuar leyendo...", array('controller'=>'clientes','action'=>'view', $lead['id']))."</ins>";
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
    <?php if ($this->Session->read('Permisos.Group.id')==1){?>
    <div class="row mt-2 finanzas">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            Listado de facturas
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm" id="dataTableFactura">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Referencia</th>
                                        <th>Fecha de emisión</th>
                                        <th>Concepto</th>
                                        <th>Subtotal</th>
                                        <th>Iva</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Categoria</th>
                                        <th>Pagar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($desarrollo['Facturas'] as $factura): ?>
                                        <tr>
                                            <td><?= $factura['folio'] ?></td>
                                            <td><?= $factura['referencia'] ?></td>
                                            <td><?= $factura['fecha_emision'] ?></td>
                                            <td><?= $factura['concepto'] ?></td>
                                            <td><?= '$'.number_format($factura['subtotal']) ?></td>
                                            <td><?= '$'.number_format($factura['iva']) ?></td>
                                            <td><?= '$'.number_format($factura['total']) ?></td>
                                            <td><?= $estados_factura[$factura['estado']] ?></td>
                                            <td><?= $categorias[$factura['categoria_id']] ?></td>
                                            <td class="text-sm-center">
                                                <?php if ($factura['estado'] == 0): ?>
                                                    <?= $this->Html->link('<i class="fa fa-dollar"></i>', array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['id']), array('escape'=>false)) ?>
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

    <!-- Listado de gastos en publicidad -->
    <div class="row mt-2 finanzas">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            Publicidad Invertida
                            <div style="float:right">
                                <?php echo $this->Html->link('<i class="fa fa-bullhorn fa-2x"></i>','#',array('data-target'=>"#publicidad",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','title'=>'REGISTRAR CAMPAÑA','escape'=>false,'style'=>'color:white'));?>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($desarrollo['Publicidad'] as $publicidad): ?>
                                        <tr>
                                            <td><?= date("M/Y",strtotime($publicidad['fecha_inicio'])) ?></td>
                                            <td><?= $publicidad['nombre'] ?></td>
                                            <td><?= $publicidad['objetivo'] ?></td>
                                            <td><?= $lineas_contactos[$publicidad['dic_linea_contacto_id']] ?></td>
                                            <td><?= "$".number_format($publicidad['inversion_prevista'],2) ?></td>
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

    <?php } ?>
    <!-- ./row listado de facturas del desarrollo -->
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
                    Próximos Eventos (15 días)

                    <span class="float-xs-right">
                    <small style="text-transform: uppercase;">
                        <i class=" fa fa-home"></i> Cita
                        <i class=" fa fa-check-circle"></i> Visita
                    </small>
                  </span>
                  
                </div>
                <div class="card-block" style="overflow-y: scroll; height:330px !important">
                    <?= $this->element('Events/eventos_proximos'); ?>
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

        // Files
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
    ], array('inline'=>true));
?>

<script>
'use strict';
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


$(document).ready(function () {

    $("#input-fa").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg","pdf"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
    });
    
    document.getElementById("bloqueado").innerHTML = <?= $data_status_prop['bloqueados'] ?>;
    document.getElementById("libre").innerHTML = <?= $data_status_prop['libres'] ?>;
    document.getElementById("reserva").innerHTML = <?= $data_status_prop['reserva'] ?>;
    document.getElementById("contrato").innerHTML = <?= $data_status_prop['contrato'] ?>;
    document.getElementById("escrituracion").innerHTML = <?= $data_status_prop['escrituracion'] ?>;
    document.getElementById("baja").innerHTML = <?= $data_status_prop['baja'] ?>;
    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
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
    // ===============table factura ====================
    var tableFactura = function() {
        var table = $('#dataTableFactura');
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            dom: 'Bflr<"table-responsive"t>ip',
            <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar como CSV',
                filename: 'Lista de posibles clientes',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'Lista de posibles clientes',
                },
                
                
            ]
            <?php else: ?>
                buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar como CSV',
                    filename: 'Lista de posibles clientes',
                    class : 'excel',
                    charset: 'utf-8',
                    bom: true,
                    enabled: false,

                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    filename: 'Lista de posibles clientes',
                    enabled: false,
                },
                
                
            ]
            <?php endif; ?>
            // order: false,
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    // ===============table inventario====================
    var inventario = function() {
        var table = $('#inventario');
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            dom: 'Bflr<"table-responsive"t>ip',
            <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar como CSV',
                filename: 'ClientList',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'ClientList',
                },
                
                
            ]
            <?php else: ?>
                buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar como CSV',
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
            <?php endif; ?>
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
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
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
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
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

    var initTable3 = function() {
        var table = $('#dataTableInversion');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'Inversion',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'Inversion',
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
            tableFactura();
            initTable3();
        }
    };
    
    
}();
</script>