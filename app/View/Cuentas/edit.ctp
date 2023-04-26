
<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            ),
        array('inline'=>false))
        
?>
<style>
    .file-caption-name {
        display: inline-block;
        overflow: hidden;
        height: auto;
        word-break: break-all;
    }
    .flex-center{
        display: flex ;
        flex-direction: row ;
        flex-wrap: wrap ;
        justify-content: center ;
        align-items: center ;
        align-content: center ;
    }
</style>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align">Configuración</h4> 
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-t-15">
                        <div class="card-header bg-blue-is"  style="background-color: #2e3c54; color:white">
                            Editar información
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div id="rootwizard_no_val">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <!-- <a class="nav-link active" href="#info_emp" data-toggle="tab" onclick="link_dinamico(1)">Información de la empresa</a> -->
                                                <?= $this->HTML->link('Parámetro de seguimiento',array('action'=>'edit','controller'=>'cuentas'),array('class'=>'nav-link active')) ?>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link" href="#param_general" data-toggle="tab" onclick="link_dinamico(2)">Parámetro de seguimiento</a> -->
                                                <?= $this->HTML->link('Parámetro de seguimiento',array('action'=>'parametrizacion','controller'=>'users'),array('class'=>'nav-link')) ?>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link" href="#config_av" data-toggle="tab" onclick="link_dinamico(3)">Configuración de correo</a> -->
                                                <?= $this->HTML->link('Configuración de correo',array('action'=>'parametros_mail_config','controller'=>'users'),array('class'=>'nav-link')) ?>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#conexion" data-toggle="tab" onclick="link_dinamico(4)">Conexiones externas</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content m-t-20">
                                            <?= $this->Form->create('Cuenta', array('type'=>'file'))?>
                                            <div class="tab-pane active" id="info_emp">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Razon social*'); ?>
                                                            </div>
                                                            <?= $this->Form->input('razon_social',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['razon_social'],
                                                                    'required' => True
                                                                )
                                                            ) ?>
                                                        </div>
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Nombre comercial*'); ?>
                                                            </div>
                                                            <?= $this->Form->input('nombre_comercial',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['nombre_comercial'],
                                                                    'required' => True
                                                                )
                                                            ) ?>
                                                        </div>
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('RFC*'); ?>
                                                            </div>
                                                            <?= $this->Form->input('rfc',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['rfc'],
                                                                    'required' => True
                                                                )
                                                            ) ?>
                                                        </div>
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Direccón fiscal*'); ?>
                                                            </div>
                                                            <?= $this->Form->input('direccion',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'type'     => 'textarea',
                                                                    'value'    => $cuenta['Cuenta']['direccion'],
                                                                    'required' => True
                                                                )
                                                            ) ?>
                                                        </div>
                                                        <style>
                                                            .q{height: }
                                                        </style>
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Teléfono 1*'); ?>
                                                            </div>
                                                            <?= $this->Form->input('telefono_1',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['telefono_1'],
                                                                    'required' => True
                                                                )
                                                            ) ?>
                                                        </div>
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Teléfono 2'); ?>
                                                            </div>
                                                            <?= $this->Form->input('telefono_2',
                                                                array(
                                                                    'label' => False,
                                                                    'div'   => 'col-sm-12 col-lg-8',
                                                                    'class' => 'form-control',
                                                                    'value' => $cuenta['Cuenta']['telefono_2']
                                                                )
                                                            ) ?>
                                                        </div>
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Pagina web'); ?>
                                                            </div>
                                                            <?= $this->Form->input('pagina_web',
                                                                array(
                                                                    'label' => False,
                                                                    'div'   => 'col-sm-12 col-lg-8',
                                                                    'class' => 'form-control',
                                                                    'value' => $cuenta['Cuenta']['pagina_web']
                                                                )
                                                            ) ?>
                                                        </div>
                                                        
                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Correo de Contacto*'); ?>
                                                            </div>
                                                            <?= $this->Form->input('correo_contacto',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['correo_contacto'],
                                                                    'required' => True
                                                                )
                                                            ) ?>
                                                        </div>

                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Url de Facebook'); ?>
                                                            </div>
                                                            <?= $this->Form->input('url_facebook',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['url_facebook'],
                                                                )
                                                            ) ?>
                                                        </div>

                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Url de Twitter'); ?>
                                                            </div>
                                                            <?= $this->Form->input('url_twitter',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['url_twitter'],
                                                                )
                                                            ) ?>
                                                        </div>

                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Url de Instagram'); ?>
                                                            </div>
                                                            <?= $this->Form->input('url_instagram',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['url_instagram'],
                                                                )
                                                            ) ?>
                                                        </div>

                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Url de Youtube'); ?>
                                                            </div>
                                                            <?= $this->Form->input('url_youtube',
                                                                array(
                                                                    'label'    => False,
                                                                    'div'      => 'col-sm-12 col-lg-8',
                                                                    'class'    => 'form-control',
                                                                    'value'    => $cuenta['Cuenta']['url_youtube'],
                                                                )
                                                            ) ?>
                                                        </div>

                                                        <div class="row mt-1">
                                                            <div class="col-sm-12 col-lg-4 pl-3">
                                                                <?= $this->Form->label('Logo*'); ?>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-8">
                                                                <?= $this->Form->file('logo',
                                                                    array(
                                                                        'class'  => 'file-loading',
                                                                        'accept' => 'image/*'
                                                                    )
                                                                ) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end. col-sm-12 #form-edit-data -->
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-sm-12" style="width:fit-content;">
                                                        <?= $this->Form->submit('Guardar y continuar al siguiente paso', array('class'=>'btn btn-success btn-block','style'=>'font-size:14px;')); ?>
                                                    </div>
                                                </div>
                                                <?= $this->Form->end(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end .rootwizard_no_val -->
                                </div>
                            </div>
                        </div>
                        <!-- end.card-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
<?= $this->Html->script(
        array(
            '/vendors/jquery-validation-engine/js/jquery.validationEngine',
            '/vendors/jquery-validation-engine/js/jquery.validationEngine-en',
            '/vendors/jquery-validation/js/jquery.validate',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/moment/js/moment.min',
            'js/form',
            
            '/vendors/sweetalert/js/sweetalert2.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
    
    
    $('#CuentaInformacionEmpresaForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            razon_social: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la razón social'
                    }
                }
            },
            nombre_comercial: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su nombre comercial'
                    }
                }
            },
            rfc: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su RFC'
                    },
                }
            },
            direccion_fiscal: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su dirección fiscal'
                    }
                }
            },
            telefono_empresa_1: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su número telefónico'
                    }
                }
            },
        }
    });

    
    $(".phone").inputmask();
    
    $("#CuentaLogo").fileinput({
         theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Escoger Foto",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar",
        showUpload: false


    });
    
    
    
    
});


<?php 
    $this->Html->scriptEnd();
?>