
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
                                        <i class="fa fa-file-building"></i>
                                        INFORMACIÓN DE CUENTA
                                        
                                    </div>
                                    <div id="rootwizard">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">1</span>Información de Super Usuario',
                                                    array(
                                                        'controller'=>'users','action'=>'informacion_personal'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                            
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link active" href="#tab2" data-toggle="tab">
                                                <span class="userprofile_tab2">2</span>Información de Empresa</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link" href="#"
                                               data-toggle="tab" style="pointer-events: none"><span>3</span>Configuración Avanzada</a>
                                        </li>
                                        
                                    </ul>
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('User',array('type'=>'file','class'=>'form-horizontal login_validator'))?>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Razón Social*</label>
                                                </div>
                                                <?= $this->Form->input('razon_social',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.razon_social'),'label'=>false,'name'=>'razon_social','class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="nombre_comercial" class="form-control-label">Marca*</label>
                                                </div>
                                                <?= $this->Form->input('nombre_comercial',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.nombre_comercial'),'label'=>false,'name'=>'nombre_comercial','class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="rfc" class="form-control-label">RFC*</label>
                                                </div>
                                                <?= $this->Form->input('rfc',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.rfc'),'label'=>false,'name'=>'rfc','class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="direccion_fiscal" class="form-control-label">Dirección Fiscal</label>
                                                </div>
                                                <?= $this->Form->input('direccion_fiscal',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.direccion'),'label'=>false,'name'=>'direccion_fiscal','class'=>'form-control','div'=>'col-md-6','required'=>false))?>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="password2" class="form-control-label">Teléfono 1</label>
                                                </div>
                                                <?= $this->Form->input('telefono_empresa_1',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.telefono_1'),'label'=>false,'name'=>'telefono_empresa_1','div' => 'col-md-6','class'=>'form-control phone','label'=>false,'data-inputmask'=>'"mask": "(999) 999-9999"','data-mask','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="telefono2" class="form-control-label">Teléfono 2</label>
                                                </div>
                                                <?= $this->Form->input('telefono_empresa_2',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.telefono_2'),'label'=>false,'name'=>'telefono_empresa_2','div' => 'col-md-6','class'=>'form-control phone','label'=>false,'data-inputmask'=>'"mask": "(999) 999-9999"','data-mask','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="paginaweb" class="form-control-label">Página Web</label>
                                                </div>
                                                <?= $this->Form->input('pagina_web',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.pagina_web'),'label'=>false,'name'=>'pagina_web','class'=>'form-control','div'=>'col-md-6'))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="conrreo_contacto" class="form-control-label">Correo de Contacto</label>
                                                </div>
                                                <?= $this->Form->input('correo_contacto',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.correo_contacto'),'name'=>'correo_contacto','label'=>false,'div' => 'col-md-6','class'=>'form-control','label'=>false,'required'=>false))?>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="profilePicture" class="form-control-label">Logo</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $this->Form->file('logo',array('class'=>'form-control file-loading','accept'=>'image/*'))?>
                                                </div>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-10">
                                                    
                                                    <input type="submit" value="Guardar Información de empresa e ir al siguiente paso" class="btn btn-success" style="width:100%">
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
    
    
    $('#UserInformacionEmpresaForm').bootstrapValidator({
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