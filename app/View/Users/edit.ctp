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
                        <h4 class="nav_top_align"><i class="fa fa-th"></i> Información de Usuario</h4> 
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
                                        Editar Información de Usuario
                                        
                                    </div>
                                    <div id="rootwizard">
                                    <div class="card-block m-t-35">
                                        <div class="row">
                                            <div class="col-sm-12 col-xl-4 flex-center">
                                                <?= $this->Html->image($usuario_foto,array('style'=>'width: auto;height: 250px;','class'=>'admin_img_width','alt'=>'Fotografía Usuario'))?>
                                            </div>
                                            <div class="col-sm-12 col-xl-8">
                                                <?= $this->Form->create('User',array('type'=>'file','class'=>'form-horizontal login_validator'))?>
                                                    <?php
                                                        echo $this->Form->input('id');
                                                        echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')));
                                                    ?>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Nombre Completo*</label>
                                                        </div>
                                                        <?= $this->Form->input('nombre_completo',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>true))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">E-mail*</label>
                                                        </div>
                                                        <?= $this->Form->input('correo_electronico',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>true))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Teléfono 1</label>
                                                        </div>
                                                        <?= $this->Form->input('telefono1',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>false))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Opcionador</label>
                                                        </div>
                                                        <?= $this->Form->input('opcionador',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','type'=>'select','options'=>array(0=>'No',1=>'Si'),'default'=>$cuentas_users['CuentasUser']['opcionador']))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Tipo usuario*</label>
                                                        </div>
                                                        <?= $this->Form->hidden('cuentas_user_id',array('value'=>$cuentas_users['CuentasUser']['id']))?>
                                                        <?= $this->Form->hidden('return',array('value'=>1))?>
                                                        <?= $this->Form->input('group_id',array('value'=>$cuentas_users['CuentasUser']['group_id'],'label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>true))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Puesto</label>
                                                        </div>
                                                        <?= $this->Form->input('puesto',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>false,'value'=>$cuentas_users['CuentasUser']['puesto']))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Unidad de Ventas</label>
                                                        </div>
                                                        <?php $unidad = array(1=>'Monto')?>
                                                        <?= $this->Form->input('unidad_venta',array('value'=>$cuentas_users['CuentasUser']['unidad_venta'],'empty'=>'Seleccionar Unidad de medición','label'=>false,'type'=>'select','options'=>$unidad, 'class'=>'form-control', 'div'=>'col-sm-8'))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Objetivo de Ventas</label>
                                                        </div>
                                                        <?= $this->Form->input('ventas_mensuales',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>false,'value'=>$cuentas_users['CuentasUser']['ventas_mensuales']))?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            <label for="razon_social" class="form-control-label">Acceso a módulo de finanzas</label>
                                                        </div>
                                                        <?= $this->Form->input('finanzas',array('label'=>false,'class'=>'form-control required','div'=>'col-sm-8','required'=>false,'options'=>array(0=>'No',1=>'Si'),'type'=>'select','value'=>$cuentas_users['CuentasUser']['finanzas'], 'required' => true))?>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-xl-4">
                                                            Foto de perfil
                                                        </div>
                                                        <div class="col-xl-8">
                                                            <?= $this->Form->file('foto',array('id'=>'UserFoto','accept'=>'image/*'))?>
                                                        </div>
                                                    </div>
                                                                                 
                                                    <div class="form-actions form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="submit" value="Guardar Cambios" class="btn btn-success btn-block">
                                                        </div>
                                                    </div>
                                                    <?= $this->Form->end()?>
                                            </div>
                                        </div>
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
        removeLabel: "Eliminar",
        showUpload: false


    });
    
    
    
    
});


<?php 
    $this->Html->scriptEnd();
?>