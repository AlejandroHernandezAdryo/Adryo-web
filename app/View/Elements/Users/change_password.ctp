
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
                        <h4 class="nav_top_align"><i class="fa fa-user"></i>Mi cuenta</h4> 
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
                                        Cambio de Password
                                        
                                    </div>
                                    
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('User',array('class'=>'form-horizontal login_validator'))?>
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
                                                <div class="col-xl-10">
                                                    
                                                    <input type="submit" value="Cambiar Password" class="btn btn-success" style="width:100%">
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
    
    
    $('#UserChangePasswordForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            
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
            
        }
    });

    
    
});


<?php 
    $this->Html->scriptEnd();
?>