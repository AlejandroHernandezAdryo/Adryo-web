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
            '/vendors/datepicker/css/bootstrap-datepicker3'
            
            ),
        array('inline'=>false))
        
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Subir Propiedad</h4>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                        <?php echo $this->Form->create('Inmueble', array('class'=>'form-horizontal login_validator'));?>
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
                                                <?= $this->Html->link(
                                                        '<span class="userprofile_tab1 tab_clr">3</span>Ubicación de Inmueble</a>',
                                                        array(
                                                            'controller'=>'inmuebles',
                                                            'action'=>'ubicacion',
                                                            $inmueble['Inmueble']['id']
                                                            ),
                                                        array(
                                                            'escape'=>false, 'class'=>'nav-link'
                                                            )
                                                        )?>
                                            </li> 
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link active" href="#" data-toggle="tab" style="pointer-events: none">
                                                    <span class="userprofile_tab2">4</span>Datos de Propietario</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <?= $this->Html->link(
                                                        '<span class="userprofile_tab1">5</span>Multimedia</a>',
                                                        array(
                                                            'controller'=>'inmuebles',
                                                            'action'=>'anexos',
                                                            $inmueble['Inmueble']['id']
                                                            ),
                                                        array(
                                                            'escape'=>false, 'class'=>'nav-link'
                                                            )
                                                        )?>
                                            </li>
                                        </ul>
                                        <div class="card-block m-t-35">
                                            <h3><font color="black">Datos del propietario</font></h3>
                                            <div class="row">
                                                <?php echo $this->Form->input('id') ?>
                                                
                                                <?php echo $this->Form->input('nombre_cliente', array('name'=>'nombre_cliente','div' => 'form-group form-group col-md-12','class'=>'form-control','label'=>'Nombre Completo', 'required' => true))?>
                                                
                                                <?php echo $this->Form->input('telefono1', array('name'=>'telefono1','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Teléfono 1', 'type' => 'tel', 'maxlength' => 10, 'required' => true))?>
                                                
                                                <?php echo $this->Form->input('telefono2', array('div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Teléfono 2', 'type' => 'tel', 'maxlength' => 10))?>
                                                
                                                <?php echo $this->Form->input('correo_electronico', array('name'=>'correo_electronico','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Correo electrónico', 'type' => 'email', 'required' => true))?>
                                                
                                                <?php echo $this->Form->hidden('return'); ?>
                                            </div>
                                                <div class="form-actions form-group row m-t-20">
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Guardar Información y salir" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=1">
                                                </div>
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Guardar Información e ir al siguiente paso" class="btn btn-success" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=2">
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

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {

    
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
    // End of chosen

    // Input mask
    $(".phone").inputmask();
    $("#product").inputmask("a*-999-a999");
    $(".percent").inputmask("99.9%");
    $(".date_mask").inputmask("yyyy-mm-dd");
    // End of input mask

    //tags input
    $('#tags').tagsInput();
    
    $("#input-fa").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png", "bmp", "tiff", "jpeg"],
        
        
    });
    
    $("#input-fa-2").fileinput({
        theme: "fa",
        
        
    });

    Admire.formGeneral() ;
    
    $(".textarea").wysihtml5();
    $('.airmode').summernote({
        height: 300,
        airMode: true
    });

    // TinyMCE Full
    tinymce.init({
        selector: "#tinymce_full",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
    // Bootstrap
    $('#bootstrap-editor').wysihtml5({
        stylesheets: [
            'assets/lib/bootstrap-wysihtml5/stylesheets/bootstrap-wysihtml5wysiwyg-color.css'
        ]
    });

    $('.summernote_editor').summernote({
        height:200
    });
    $(".wysihtml5-toolbar li:nth-child(3) a,.wysihtml5-toolbar li:nth-child(4) a,.wysihtml5-toolbar li:nth-child(5) a,.wysihtml5-toolbar li:nth-child(6) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:first-child,.wysihtml5-toolbar .btn-group:eq(3) a:first-child").addClass("fa fa-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(2),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(2)").addClass("fa fa-th-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(3),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(3)").addClass("fa fa-align-left");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(4),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(4)").addClass("fa fa-align-right");
    $(".wysihtml5-toolbar li:nth-child(5) span").addClass("fa fa-share");
    $(".wysihtml5-toolbar li:nth-child(6) span").addClass("fa fa-picture-o");
    $("[data-wysihtml5-command='formatBlock'] span").css("position","relative").css("top","-5px").css("left","-5px");
    $(".note-toolbar button").removeClass('btn-default').addClass('btn-secondary');
    $(".wysihtml5-toolbar li:nth-child(2) a").removeClass('btn-default').addClass('btn-secondary');
    
});


<?php 
    $this->Html->scriptEnd();
?>