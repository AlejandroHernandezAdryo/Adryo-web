
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

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Bienvenido a Inmosystem</h4> 
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                            
                            <div class="col-xl-12">
                                <div class="card m-t-35">
                                    <div class="card-header bg-white">
                                        <i class="fa fa-file-text-o"></i>
                                        Primeros Pasos
                                        <p><small>Bienvenido a Inmosystem. En este tutorial cargaremos la información inicial necesaria para configurar tu empresa.</small></p>
                                    </div>
                                    <div id="rootwizard">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link active" href="#tab1" data-toggle="tab">
                                                <span class="userprofile_tab1">1</span>Información de Super Usuario</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link" href="#" data-toggle="tab" style="pointer-events: none">
                                                <span class="userprofile_tab2">2</span>Información de Empresa</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link" href="#"
                                               data-toggle="tab" style="pointer-events: none"><span>3</span>Reglas de envío de correos</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link" href="#"
                                               data-toggle="tab" style="pointer-events: none"><span>4</span>Diccionarios</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link" href="#"
                                               data-toggle="tab" style="pointer-events: none"><span>5</span>Calificación de clientes</a>
                                        </li>
                                    </ul>
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('User',array('type'=>'file','class'=>'form-horizontal login_validator'))?>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right ">
                                                    <label for="nombre_completo" class="form-control-label">Nombre Completo*</label>
                                                </div>
                                                <?= $this->Form->input('nombre_completo',array('value'=>$this->Session->read('Auth.User.nombre_completo'),'label'=>false,'name'=>'nombre_completo','class'=>'form-control required','div'=>'col-md-6 ','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="email" class="form-control-label">Email*</label>
                                                </div>
                                                <?= $this->Form->input('email',array('label'=>false,'value'=>$this->Session->read('Auth.User.correo_electronico'),'name'=>'email','class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="telefono1" class="form-control-label">Teléfono 1*</label>
                                                </div>
                                                <?= $this->Form->input('telefono1',array('value'=>$this->Session->read('Auth.User.telefono1'),'label'=>false,'name'=>'telefono1','div' => 'col-md-6','class'=>'form-control phone required','label'=>false,'data-inputmask'=>'"mask": "(999) 999-9999 (ext 99999)"','data-mask','required'=>false))?>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="telefono2" class="form-control-label">Teléfono 2</label>
                                                </div>
                                                <?= $this->Form->input('telefono2',array('value'=>$this->Session->read('Auth.User.telefono2'),'label'=>false,'name'=>'telefono2','div' => 'col-md-6','class'=>'form-control phone','label'=>false,'data-inputmask'=>'"mask": "(999) 999-9999 (ext 99999)"','data-mask','required'=>false))?>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="password" class="form-control-label">Nueva Contraseña</label>
                                                </div>
                                                <?= $this->Form->input('password',array('label'=>false,'name'=>'password','class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="password2" class="form-control-label">Confirmar Nueva Contraseña</label>
                                                </div>
                                                <?= $this->Form->input('password2',array('label'=>false,'type'=>'password','name'=>'password','class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="profilePicture" class="form-control-label">Imagen de perfil</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $this->Form->file('profile_picture',array('class'=>'form-control file-loading','accept'=>'image/*'))?>
                                                </div>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-10">
                                                    
                                                    <input type="submit" value="Guardar Información e ir al siguiente paso" class="btn btn-success" style="width:100%">
                                                </div>
                                            </div>
                                            <?= $this->Form->end()?>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        
                        
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
    
    
    $('#UserInformacionPersonalForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            nombre_completo: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su nombre completo'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria una cuenta de correo'
                    },
                    regexp: {
                        regexp: /^\S+@\S{1,}\.\S{1,}$/,
                        message: 'No es una cuenta de correo válida'
                    }
                }
            },
            telefono1: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario un número de teléfono'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario una contraseña'
                    }
                }
            },
            password2: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario confirmar tu contraseña y debe ser idéntica al campo anterior'
                    },
                    identical: {
                        field: 'password'
                    }
                }
            },
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
                    }
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
    $("#UserProfilePicture").fileinput({
        theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Escoger Foto",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"


    });
    $("#UserLogo").fileinput({
        theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Escoger Foto",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"


    });
    
    
    
    
});


<?php 
    $this->Html->scriptEnd();
?>