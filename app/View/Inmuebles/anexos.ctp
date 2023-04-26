<?= $this->Html->css(
        array(

            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',


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
            '/vendors/datepicker/css/bootstrap-datepicker3'
            
            ),
        array('inline'=>false))
        
?>
<style>
    .text-black{color: black;}
</style>



<!-- Modales  -->
<div class="modal fade" id="small" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body">
                <b>Documentos para apoyar tu venta se entienden como:</b>
                <ul>
                    <li>Acta constitutiva.</li>
                    <li>Contrato de compra venta de terreno.</li>
                    <li>Permisos.</li>
                    <li>Contratos.</li>
                    <li>Poderes.</li>
                </ul>
                <i>Sólo se permiten archivos PDF, Word y Excel</i>
                <br>
                <hr>
                <b>Brochure Personalizado:</b>
                <p>
                    Si se sube un archivo, este será anexado en los correos electrónicos que se envíen al cliente.
                </p>
                <i>Sólo se permiten archivos PDF</i>
            </div>
            <div class="modal-footer">
                <button class="btn  btn-primary" data-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="small" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body">
                kasdkasd
            </div>
            <div class="modal-footer">
                <button class="btn  btn-primary" data-dismiss="alerta">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-building"></i> Subir Imágenes y Documentos del Inmueble</h4>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block m-t-20">
                                    <div id="rootwizard">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item m-t-15">
                                                <?= $this->Html->link(
                                                        '<span class="userprofile_tab1 tab_clr">1</span>Datos Generales</a>',
                                                        array(
                                                            'controller'=>'inmuebles',
                                                            'action'=>'edit',
                                                            $inmueble['Inmueble']['id']
                                                            ),
                                                        array(
                                                            'escape'=>false, 'class'=>'nav-link'
                                                            )
                                                        )?>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <?= $this->Html->link(
                                                        '<span class="userprofile_tab1 tab_clr">2</span>Características</a>',
                                                        array(
                                                            'controller'=>'inmuebles',
                                                            'action'=>'caracteristicas',
                                                            $inmueble['Inmueble']['id']
                                                            ),
                                                        array(
                                                            'escape'=>false, 'class'=>'nav-link'
                                                            )
                                                        )?>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link active" href="#" data-toggle="tab" style="pointer-events: none">
                                                    <span class="userprofile_tab2">3</span>Archivos Multimedia</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block m-t-35">
                                    <?php echo $this->Form->create('Inmueble', array('type'=>'file','url'=>array('controller'=>'Inmuebles', 'action'=>'anexos', $inmueble['Inmueble']['id']))); ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="text-black">Archivos e Imágenes cargados para el Inmueble</h4>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8" style="height: 400px; overflow-y: scroll; padding: 20px; border: 1px solid silver">
                                            <h4 class="col-sm-12"><font color="black">Imágenes del Inmueble</h4>
                                            <?php 
                                                $i =0;
                                                foreach ($imagenes as $imagen):
                                            ?>
                                            <div class="col-lg-6 m-t-20">
                                                <div class="col-xs-12">
                                                    <?php echo $this->Html->image($imagen['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['descripcion'],'label'=>false,'style'=>'width:100%; margin-top:5px;', 'name'=>'data[fotografias]['.$i.'][descripcion]', 'class'=>'form-control'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('orden', array('placeholder'=>'Orden','value'=>$imagen['orden'],'label'=>false,'style'=>'width:100%; margin-top:5px;', 'name'=>'data[fotografias]['.$i.'][orden]', 'class'=>'form-control'))?>
                                                    <?php echo $this->Form->input('foto_id',array('type'=>'hidden','value'=>$imagen['id'], 'name'=>'data[fotografias]['.$i.'][id]'));?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="checkbox" style="margin-top: 2px;">
                                                        <label>
                                                            <input type="checkbox" name="data[fotografias][<?= $i ?>][eliminar]">
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Eliminar
                                                        </label>
                                                    </div>
                                                </div>

                                                <style> 
                                                    .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                </style>
                                                <div class="col-xs-12">
                                                    <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>
                                                </div>
                                            </div>
                                            <?php 
                                                $i++;
                                                endforeach;
                                            ?>
                                            <h4 class="col-sm-12 m-t-35"><font color="black">Planos Comerciales</h4>
                                            <hr>
                                            <?php 

                                                foreach ($planos as $imagen):
                                            ?>
                                            <div class="col-lg-6 m-t-20">
                                                <div class="col-xs-12">
                                                    <?php echo $this->Html->image($imagen['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['descripcion'],'label'=>false,'style'=>'width:100%; margin-top:5px;','name'=>'data[fotografias]['.$i.'][descripcion]', 'class'=>'form-control'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('orden', array('placeholder'=>'Orden','value'=>$imagen['orden'],'label'=>false,'style'=>'width:100%; margin-top:5px;', 'name'=>'data[fotografias]['.$i.'][orden]', 'class'=>'form-control'))?>
                                                    <?php echo $this->Form->input('foto_id',array('type'=>'hidden','value'=>$imagen['id'],'name'=>'data[fotografias]['.$i.'][id]'));?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="checkbox" style="margin-top: 2px;">
                                                        <label>
                                                            <input type="checkbox" name="data[fotografias][<?= $i ?>][eliminar]">
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Eliminar
                                                        </label>
                                                    </div>
                                                </div>
                                                <style> .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                </style>
                                                <div class="col-xs-12">
                                                    <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>
                                                </div>
                                            </div>
                                            <?php 
                                                $i++;
                                                endforeach;
                                                echo $this->Form->input('i',array('type'=>'hidden','value'=>$i));
                                            ?>
                                        </div>
                                        <div class="row col-lg-4" style="height: 400px; overflow-y: scroll; padding: 20px; border-right: 1px solid silver;border-top: 1px solid silver; border-bottom: 1px solid silver">
                                            
                                            <h5 class="col-sm-12"><font color="black">Archivos Auxiliares Comerciales</h5>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th width="80%"><b>Documento</b></th>
                                                    <th width="10%"><b><i class="fa fa-download"></i></b></th>
                                                    <th width="10%"><b><i class="fa fa-trash fa-lg"></i></b></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                   <?php if($inmueble['Inmueble']['brochure']!=""){?>
                                                    <tr>
                                                        <td>Brochure Comercial</td>
                                                        <td>
                                                            <?= $this->Html->link('<i class="fa fa-download"></i>',$inmueble['Inmueble']['brochure'],array('escape'=>false))?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->postLink(
                                                           '<i class="fa fa-trash fa-lg"></i>', 
                                                           array(
                                                               'controller'=>'Inmuebles','action'=>'borrar_brochure',
                                                               $inmueble['Inmueble']['id']
                                                            ), 
                                                           array(
                                                               'inline'=>false,
                                                               'escape' => false, 'confirm'=> __('Desea eliminar este documento?')
                                                               )
                                                           ); ?>
                                                        </td>
                                                    </tr>
                                                   <?php }?>
                                                   <?php foreach ($inmueble['DocumentosUser'] as $documento):?>
                                                        <tr>
                                                            <td><?= $documento['documento']?></td>
                                                            <td><?= $this->Html->link(
                                                                    '<i class="fa fa-download"></i>',
                                                                    $documento['ruta'],
                                                                    array('escape'=>false)
                                                                )?>
                                                            </td>
                                                            <td>
                                                                <?= $this->Form->postLink(
                                                           '<i class="fa fa-trash fa-lg"></i>', 
                                                           array(
                                                               'controller'=>'Inmuebles','action'=>'eliminar_documento',
                                                               $documento['id'],$inmueble['Inmueble']['id']
                                                            ), 
                                                           array(
                                                               'inline'=>false,
                                                               'escape' => false, 'confirm'=> __('Desea eliminar este documento?')
                                                               )
                                                           ); ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row m-t-10">
                                    <?php 
                                        echo $this->Form->hidden('id', array('value'=>$inmueble['Inmueble']['id']));
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <?php 
                                                    echo $this->Form->input('youtube', array('label'=>'Video de Youtube','div' => 'col-lg-6','class'=>'form-control'));

                                                    echo $this->Form->input('matterport', array('label'=>'Tour Virtual Matterport','div' => 'col-lg-6','class'=>'form-control'));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" onmousedown="return false">
                                            <label>Subir Imágenes de Inmueble</label>
                                            <input id="input-fa" name="data[Inmueble][fotos][]" type="file" multiple class="file-loading">
                                        </div>
                                        <div class="col-sm-12" onmousedown="return false">
                                            <label>Subir Planos Comerciales</label>
                                            <input id="input-fa-multimedia" name="data[Inmueble][planos_comerciales][]" type="file" multiple class="file-loading">
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Documentos Necesarios para apoyar tu venta</label>
                                            <button class="btn btn-raised btn-secondary adv_cust_mod_btn" data-toggle="modal" data-target="#small" type="button" style="border: none !important;">
                                                    <i style="cursor: pointer;" class="fa fa-question-circle-o fa-lg"></i>
                                                </button>
                                            <input id="input-fa-planos" name="data[Inmueble][planos][]" type="file" multiple class="file-loading">
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Brochure Personalizado</label>
                                            <button class="btn btn-raised btn-secondary adv_cust_mod_btn" data-toggle="modal" data-target="#small" type="button" style="border: none !important;">
                                                    <i style="cursor: pointer;" class="fa fa-question-circle-o fa-lg"></i>
                                                </button>
                                            <input id="input-fa-brochure" name="data[Inmueble][brochure]" type="file" class="file-loading">
                                        </div>
                                    </div>
                                        <?php echo $this->Form->hidden('return'); ?>
                                        <div class="form-actions form-group row m-t-20">
                                            <div class="form-actions form-group row m-t-20">
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Guardar Información y salir" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('InmuebleReturn').value=1">
                                                </div>
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Guardar Información y Continuar Editando" class="btn btn-success" style="width:100%" onclick="javascript:document.getElementById('InmuebleReturn').value=2">
                                                </div>
                                                </div>
                                        </div>
                                        <?= $this->Form->end()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
 
<?= $this->Html->script(
        array(


            '/vendors/jquery.uniform/js/jquery.uniform',
            '/vendors/inputlimiter/js/jquery.inputlimiter',
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/js/jquery.tagsinput',
            '/vendors/validval/js/jquery.validVal.min',
            '/vendors/moment/js/moment.min',
            '/vendors/daterangepicker/js/daterangepicker',
            '/vendors/datepicker/js/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            '/vendors/autosize/js/jquery.autosize.min',
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/inputmask/js/inputmask.date.extensions',
            '/vendors/inputmask/js/inputmask.extensions',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',



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
    
    $("#input-fa-multimedia").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg","pdf"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
    });

    $("#input-fa-planos").fileinput({
        theme: "fa",
        allowedFileExtensions: ["pdf","docx","xlsx","doc","xls"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        showBrowse: true,
        uploadAsync: false,
    });
    
    $("#input-fa-brochure").fileinput({
        theme: "fa",
        allowedFileExtensions: ["pdf"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        showBrowse: true,
        uploadAsync: false,
    });
    
    Admire.formGeneral() ;
});
<?php 
    $this->Html->scriptEnd();
?>