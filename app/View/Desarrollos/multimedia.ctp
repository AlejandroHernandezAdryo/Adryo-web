<?= $this->Html->css(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/css/jquery.tagsinput',
            '/vendors/daterangepicker/css/daterangepicker',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            
            '/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min',
            '/vendors/summernote/css/summernote',
            'custom',
            
            'pages/form_elements',
            
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/css/pages/form_validations',
            
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/datepicker/css/bootstrap-datepicker3',
            
            '/vendors/Buttons/css/buttons.min',
            'pages/buttons'
            
            
            
            ),
        array('inline'=>false))
        
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i> Administrar Imágenes</h4>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                        <?php echo $this->Form->create('Desarrollo', array('type'=>'file','class'=>'form-horizontal login_validator'));?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block m-t-20">
                                    <div id="rootwizard">
                                        <div class="card-block m-t-35">
                                            <div class="row">
                                                <h5 class="col-sm-12"><font color="black">Imágenes del Desarrollo</h5>
                                                <?php 
                                                    $i =1;
                                                    foreach ($imagenes as $imagen):
                                                ?>
                                                <div class="col-lg-3 m-t-20">
                                                <div class="col-xs-12">
                                                    <?php echo $this->Html->image($imagen['FotoDesarrollo']['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('descripcion'.$i, array('placeholder'=>'Descripción','value'=>$imagen['FotoDesarrollo']['descripcion'],'label'=>false,'style'=>'width:100%'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('orden'.$i, array('placeholder'=>'Orden','value'=>$imagen['FotoDesarrollo']['orden'],'label'=>false,'style'=>'width:100%'))?>
                                                    <?php echo $this->Form->input('id'.$i,array('type'=>'hidden','value'=>$imagen['FotoDesarrollo']['id']));?>
                                                </div>
                                                <style> .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                </style>
                                                <div class="col-xs-12">
                                                    
                                                    <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['FotoDesarrollo']['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>


                                                   <?= $this->Form->postLink(
                                                           '<i class="fa fa-trash fa-lg"></i> Eliminar', 
                                                           array(
                                                               'controller'=>'Desarrollos','action'=>'eliminar_foto',
                                                               $imagen['FotoDesarrollo']['id'],$imagen['FotoDesarrollo']['desarrollo_id']
                                                            ), 
                                                           array(
                                                               'inline'=>false,
                                                               'class'=>'btn btn-danger m-t-5',
                                                               'escape' => false, 'confirm'=> __('Desea eliminar esta imagen?')
                                                               )
                                                           ); ?>
                                                   
                                                </div>
                                                </div>
                                                <?php 
                                                    $i++;
                                                    endforeach;
                                                    echo $this->Form->input('i',array('type'=>'hidden','value'=>$i));
                                                ?>
                                            </div>
                                            <div class="row m-t-35">
                                                <h5 class="col-sm-12"><font color="black">Subir Imágenes</h5>
                                                <?php echo $this->Form->input('id',array('value'=>$id,'type'=>'hidden'))?>
                                                <div class="col-lg-12 m-t-35">
                                                    <h5><font color="black">Imágenes del inmueble</h5>
                                                        <input id="input-fa" name="data[Desarrollo][foto_desarrollo][]" type="file" multiple class="file-loading">
                                                    </div>
                                                    <?php //echo $this->Form->input('foto_inmueble.',array('type'=>'file','multiple','div' => 'col-md-6','class'=>'form-control','label'=>'Fotografias'));?>
<!--                                                <div class="col-lg-12 m-t-35">
                                                    <h5><font color="black">Archivos anexos</h5>
                                                    <input id="input-fa-2" name="data[Inmueble][anexos][]" type="file" multiple class="file-loading">
                                                </div> -->
                                                </div>
                                                <div class="form-actions form-group row">
                                                <div class="col-xl-12">
                                                    <?= $this->Form->button('Actualizar Galería', array('class'=>'btn btn-success m-t-15 col-sm-12', 'type'=>'submit')) ?>

                                                    <?= $this->Html->link('Regresar al desarrollo', 'view/'.$id, array('class'=>'btn btn-primary m-t-15 col-sm-12')) ?>

                                                </div>
                                                </div>
                                                
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?= $this->Form->end()?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Modal -->
        </div>

 
<?= $this->Html->script(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
          
            '/vendors/tinymce/js/tinymce.min',
            '/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min',
            '/vendors/summernote/js/summernote.min',
            
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
            
            //'pages/wizard',
            //'pages/form_editors',
            //'pages/form_elements',
            
           
           
            
        ),
        array('inline'=>false))
?>
<?= $this->fetch('postLink'); ?>
<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
    
    $("#input-fa").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png", "bmp", "tiff", "jpeg"],
        
        
    });
    
    $("#input-fa-2").fileinput({
        theme: "fa",
        
        
    });
    
});


<?php 
    $this->Html->scriptEnd();
?>
