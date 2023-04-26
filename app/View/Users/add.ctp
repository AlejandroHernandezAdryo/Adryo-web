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
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Información de Usuario</h4> 
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
                                        Registrar Usuario
                                        
                                    </div>
                                    <div id="rootwizard">
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('User',array('type'=>'file','class'=>'form-horizontal login_validator'))?>
                                            <?php 
                                                echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')));
                                            ?>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Nombre Completo</label>
                                                </div>
                                                <?= $this->Form->input('nombre_completo',array('label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Correo Electrónico</label>
                                                </div>
                                                <?= $this->Form->input('correo_electronico',array('label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="password" class="form-control-label">Contraseña</label>
                                                </div>
                                                <?= $this->Form->input('password',array('type'=>'password','label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Teléfono 1</label>
                                                </div>
                                                <?= $this->Form->input('telefono1',array('label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Teléfono 2</label>
                                                </div>
                                                <?= $this->Form->input('telefono2',array('label'=>false, 'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Puesto</label>
                                                </div>
                                                <?= $this->Form->input('puesto',array('label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Opcionador</label>
                                                </div>
                                                <?= $this->Form->input('opcionador',array('label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false,'type'=>'select','options'=>array('No','Si')))?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="razon_social" class="form-control-label">Grupo</label>
                                                </div>
                                                <?= $this->Form->input('group_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.group_id'),'label'=>false,'class'=>'form-control required','div'=>'col-md-6','required'=>false))?>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-2 text-xl-right">
                                                    <label for="profilePicture" class="form-control-label">Foto de Perfil</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $this->Form->file('foto',array('class'=>'form-control file-loading','accept'=>'image/*'))?>
                                                </div>
                                            </div>
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-10">
                                                    
                                                    <input type="submit" value="Guardar Información" class="btn btn-success" style="width:100%">
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
    $("#UserFoto").fileinput({
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