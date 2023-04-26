
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
<script>
    function displayClientes(){
        if (document.getElementById('UserMep').value==0){
            document.getElementById('mails_clientes').style.display="none";
        }else{
            document.getElementById('mails_clientes').style.display="";
        }
    }
    
    function displayRegistro(){
        if (document.getElementById('UserMr').value==0){
            document.getElementById('registro_clientes').style.display="none";
        }else{
            document.getElementById('registro_clientes').style.display="";
        }
    }
    
    function showDetalle(){
        if (String(document.getElementById('UserCuentaCorreo').value).includes("gmail.com") ||
            String(document.getElementById('UserCuentaCorreo').value).includes("hotmail.com") ||
            String(document.getElementById('UserCuentaCorreo').value).includes("yahoo.com") ||
            String(document.getElementById('UserCuentaCorreo').value).includes("outlook.com")
            )
        {
            document.getElementById('detalle').style.display="none";
        }else{
            document.getElementById('detalle').style.display="";
        }
    }

</script>
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Bienvenido a Adryo</h4> 
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
                                        Parámetros de mail
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
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">2</span>Información de Empresa',
                                                    array(
                                                        'controller'=>'users','action'=>'informacion_empresa'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                            
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link active" href="#tab3"
                                               data-toggle="tab "><span>3</span>Configuración Avanzada</a>
                                        </li>
                                    </ul>
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('User',array('class'=>'form-horizontal login_validator'))?>
                                        
                                            <h2> <font color="black">Configuración de cuenta de mail</h2>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="smtp" class="form-control-label">Correo electrónico</label>
                                                </div>
                                                <?= $this->Form->input('cuenta_correo',array('value'=>$parametros_mail['Mailconfig']['cuenta_correo'],'label'=>false,'class'=>'form-control','div'=>'col-md-6','onchange'=>'javascript:showDetalle()'))?>
                                            </div>
                                            <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="password_mail" class="form-control-label">Password Mail</label>
                                                    </div>
                                                    <?= $this->Form->input('password_mail',array('value'=>$parametros_mail['Mailconfig']['password'],'type'=>'password','label'=>false,'class'=>'form-control','div'=>'col-md-6'))?>
                                                </div>
                                            <div id="detalle" style="display: none">
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="smtp" class="form-control-label">Servidor de correo saliente</label>
                                                    </div>
                                                    <?= $this->Form->input('smtp',array('value'=>$parametros_mail['Mailconfig']['smtp'],'label'=>false,'class'=>'form-control','div'=>'col-md-6'))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="puerto" class="form-control-label">Puerto SMTP</label>
                                                    </div>
                                                    <?= $this->Form->input('puerto_mail',array('value'=>$parametros_mail['Mailconfig']['puerto'],'label'=>false,'class'=>'form-control','div'=>'col-md-6'))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">Usuario</label>
                                                    </div>
                                                    <?= $this->Form->input('usuario_mail',array('value'=>$parametros_mail['Mailconfig']['usuario'],'label'=>false,'class'=>'form-control','div'=>'col-md-6'))?>

                                                </div>
                                            </div>
                                            <h2> <font color="black">Envío de mails a clientes</h2>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="mr" class="form-control-label">Habilitar envío de mails a clientes</label>
                                                </div>
                                                <?= $this->Form->input('mep',array('value'=>$parametros_generales['Paramconfig']['mep'],'onchange'=>'javascript:displayClientes()','label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                            </div>
                                            <?php if ($parametros_generales['Paramconfig']['mep'] == 1){ ?>
                                                <div id="mails_clientes">
                                            <?php }else{ ?>
                                                <div id="mails_clientes" style="display:none">
                                            <?php }?>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="mr" class="form-control-label">Enviar copia de mail a usuario</label>
                                                </div>
                                                <?= $this->Form->input('cc_mep',array('value'=>$parametros_generales['Paramconfig']['cc_mep'],'label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="to_mr" class="form-control-label">Enviar copia de mail a cliente a (Separar por coma (,)):</label>
                                                </div>
                                                <?= $this->Form->input('cco_mep',array('value'=>$parametros_generales['Paramconfig']['cco_mep'],'class'=>'form-control','div'=>'col-md-6','label'=>false))?>
                                            </div>
                                            </div>
                                            <h2> <font color="black">Envío de mail de registro de cliente</h2>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="mr" class="form-control-label">Notificar por mail un registro de nuevo cliente</label>
                                                </div>
                                                <?= $this->Form->input('mr',array('value'=>$parametros_generales['Paramconfig']['mr'],'onchange'=>'javascript:displayRegistro()','label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                            </div>
                                            <?php if ($parametros_generales['Paramconfig']['mr'] == 1){ ?>
                                                <div id="registro_clientes">
                                            <?php }else{ ?>
                                                <div id="registro_clientes" style="display:none">
                                            <?php }?>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="cc_mr" class="form-control-label">Enviar mail de registro a:</label>
                                                    </div>
                                                    <?= $this->Form->input('cc_mr',array('value'=>$parametros_generales['Paramconfig']['cc_mr'],'label'=>false,'class'=>'form-control','div'=>'col-md-6'))?>
                                                </div>
                                            </div>
                                            <h2> <font color="black">Envío de mails internos</h2>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="mr" class="form-control-label">Habilitar envío de mails internos</label>
                                                </div>
                                                <?= $this->Form->input('ma',array('value'=>$parametros_generales['Paramconfig']['ma'],'label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-10">
                                                    
                                                    <input type="submit" value="Guardar Información de configuración de mails e ir al siguiente paso" class="btn btn-success" style="width:100%">
                                                </div>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-10">
                                                    <?= $this->Html->link('Omitir Paso y guardar avance acutal',array('controller'=>'users','action'=>'diccionarios'),array('style'=>'color:red; float:right'))?>                                                    
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