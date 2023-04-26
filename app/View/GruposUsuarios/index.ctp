<?= $this->Html->css(
        array(
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            '/vendors/ihover/css/ihover.min',
            
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/chosen/css/chosen',
            'pages/form_elements'
            
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Equipos de Trabajo
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel1" style="color:black">
                            <i class="fa fa-plus"></i>
                            Crear Equipo de Trabajo
                        </h4>
                    </div>
                    <?= $this->Form->create('GruposUsuario',array('url'=>array('action'=>'crear'),'type'=>'file'))?>
                    <div class="modal-body">
                        <div class="row">
                            <?= $this->Form->input('nombre_grupo',array('class'=>'form-control','div'=>'col-md-12 m-t-15','label'=>'Nombre de Grupo',))?>
                            <?= $this->Form->input('descripcion',array('class'=>'form-control','placeholder'=>'Descripción de Equipo','div'=>'col-md-12 m-t-15','label'=>'Descripción del grupo',))?>
                            <?= $this->Form->input('administrador_id',array('class'=>'form-control chzn-select','type'=>'select','div'=>'col-md-12 m-t-15','options'=>$g,'label'=>'Coordinador',))?>
                            <?= $this->Form->input('integrantes',array('multiple'=>true,'class'=>'form-control chzn-select','type'=>'select','options'=>$i,'div'=>'col-md-12 m-t-15','label'=>'Integrantes',))?>
                            <?= $this->Form->input('desarrollos',array('multiple'=>true,'class'=>'form-control chzn-select','type'=>'select','options'=>$desarrollos,'div'=>'col-md-12 m-t-15','label'=>'Desarrollos en el grupo',))?>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 text-xl-left m-t-15">
                                <label for="Integrantes" class="form-control-label">Fotografía del Equipo </label>
                            </div>
                            <?= $this->Form->input('foto',array('class'=>'form-control','type'=>'file','div'=>'col-md-7 m-t-15','label'=>false,))?>
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
                            Crear Equipo
                        </button>
                    </div>
                    <?= $this->Form->end()?>
                </div>
            </div>
        </div>
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-white">
                    <i class="fa fa-users"> </i> Equipos
                    <div style="float:right">
                        <a  href="#" class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal" style="background-color:green; color:white">
                            <i class="fa fa-plus fa-1x"></i>Agregar Grupo
                        </a>
                    </div>
                </div>
                <div class="card-block">
                    <?php foreach ($grupos as $grupo):?>
                    <div class="col-lg-3 col-12 mayor_section">
                            <div class="bg-white p-d-10 section_border">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <?php 
                                                if ($grupo['GruposUsuario']['imagen']==null){
                                                    echo $this->Html->image('grupos_no_photo.png',array('class'=>'img-fluid rounded-circle mayor_img'));
                                                }else{
                                                    echo $this->Html->image($grupo['GruposUsuario']['imagen'],array('class'=>'img-fluid rounded-circle mayor_img'));
                                                }    
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center font_18">
                                    <?= $grupo['GruposUsuario']['nombre_grupo']?>
                                </div>
                                <div class="text-center">
                                    Administrador: <?= $grupo['Administrador']['nombre_completo']?>
                                </div>
                                <div class="m-t-5 text-center">
                                    <?= $grupo['GruposUsuario']['descripcion']?>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-xl-4 col-lg-6 col-4 text-center">
                                        <div class="text-primary font_18 bottom_5"><?= sizeof($grupo['Usuarios'])?></div>Miembros
                                        
                                    </div>
                                    <div class="col-xl-8 col-lg-6 col-8 text-center">
                                        <div class="text-center m-t-5">
                                    <?= $this->Html->link('<button class="btn btn-primary">Ver Grupo</button>',array('action'=>'view',$grupo['GruposUsuario']['id']),array('escape'=>false))?>
                                    
                                </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>

</div>


<?php 
    echo $this->Html->script([
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
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
        'pages/advanced_tables',
        '/vendors/chosen/js/chosen.jquery',
        
        'pages/layouts',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            
            '/vendors/validval/js/jquery.validVal.min',
            
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            'pages/form_elements',
            
            
            '/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min',
            
            
            '/vendors/jquery.uniform/js/jquery.uniform',
            '/vendors/inputlimiter/js/jquery.inputlimiter',
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/js/jquery.tagsinput',
            '/vendors/validval/js/jquery.validVal.min',
            '/vendors/moment/js/moment.min',
            '/vendors/daterangepicker/js/daterangepicker',
            '/vendors/datepicker/js/bootstrap-datepicker.min',
            '/vendors/datetimepicker/js/DateTimePicker.min',
            '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            '/vendors/autosize/js/jquery.autosize.min',
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/inputmask/js/inputmask.date.extensions',
            '/vendors/inputmask/js/inputmask.extensions',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            'form',
    ], array('inline'=>false));
?>
