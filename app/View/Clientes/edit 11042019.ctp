<?= $this->Html->css(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/css/pages/form_validations',
            
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i> Editar Cliente</h4>
                
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <?php echo $this->Form->create('Cliente',array('class'=>'form-horizontal login_validator'));?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block m-t-20">
                             <div class="row">
                            <?php echo $this->Form->create('Cliente')?>
                            <?php echo $this->Form->input('nombre', array('value'=>$cliente['Cliente']['nombre'],'required'=>false,'name'=>'nombre','div' => 'col-md-12','class'=>'form-control required','type'=>'text', 'label'=>'Nombre del cliente*', 'required'=>true))?>
                            <?php echo $this->Form->input('correo_electronico', array('label'=>'Correo Electrónico','div' => 'col-md-4 m-t-20','class'=>'form-control ','type'=>'text'))?>
                            <?php echo $this->Form->input('telefono1', array('value'=>$cliente['Cliente']['telefono1'],'label'=>'Teléfono 1','name'=>'telefono_1','div' => 'col-md-4 m-t-20','class'=>'form-control phone','type'=>'text','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                            <?php echo $this->Form->input('telefono2', array('label'=>'Teléfono 2','div' => 'col-md-4 m-t-20','class'=>'form-control phone','type'=>'text','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                            </div>
                            <div class="row">
                            <?php //if ($this->Session->read('Auth.User.Group.id')!=4) { ?>
                                <?php echo $this->Form->input('telefono3', array('label'=>'Teléfono 3','div' => 'col-md-4 m-t-20','class'=>'form-control phone','type'=>'text','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                                <?php echo $this->Form->input('dic_tipo_cliente_id', array('value'=>$cliente['Cliente']['dic_tipo_cliente_id'],'name'=>'tipo_cliente','label'=>'Tipo de cliente*','div' => 'col-md-4 m-t-20','class'=>'form-control','type'=>'select','empty'=>'Seleccionar tipo de cliente','options'=>$tipos_cliente))?>
                                <?php echo $this->Form->input('dic_etapa_id', array('value'=>$cliente['Cliente']['dic_etapa_id'],'name'=>'etapa_cliente','label'=>'Etapa del cliente*','div' => 'col-md-4 m-t-20','class'=>'form-control','type'=>'select','options'=>$etapas,'empty'=>'Seleccionar Etapa'))?>
                            </div>
                            <div class="row">
                                <?php echo $this->Form->input('status', array('type'=>'hidden','value'=>'Activo'))?>
                                
                            <?php //}?>
                        </div>
                            <div class="row">
                            <?php echo $this->Form->input('dic_linea_contacto_id', array( 'value'=>$cliente['Cliente']['dic_linea_contacto_id'],'name'=>'forma_contacto','label'=>'Forma de contacto*','div' => 'col-md-4 m-t-20','class'=>'form-control','type'=>'select', 'empty'=>'Seleccionar la forma de contacto' ,'options'=>$linea_contactos))?>
                            <?php 
                                if ($this->Session->read('Auth.User.Group.id')!=3){
                                    echo $this->Form->input('user_id', array('label'=>'Agente Comercial','div' => 'col-md-4 m-t-20','class'=>'form-control','empty'=>'SIN AGENTE ASIGNADO'));
                                }else{
                                    echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
                                }
                            ?>
                            <?php $temp = array(1=>'Frio',2=>'Tibio',3=>'Caliente') ?>

                            <?php echo $this->Form->input('temperatura', array( 'value'=>$cliente['Cliente']['temperatura'],'label'=>'Temperatura','div' => 'col-md-4 m-t-20','class'=>'form-control','type'=>'select', 'empty'=>'Seleccionar la temperatura del cliente' ,'options'=>$temp))?>
                            

                            <?php echo $this->Form->input('comentarios', array('label'=>'Comentarios','div' => 'col-md-12 m-t-20','class'=>'form-control', 'maxlength'=>'150'))?>
                            
                            <?php echo $this->Form->input('etapa_comercial', array('type'=>'hidden','value'=>'CRM'))?>
                            <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                </div>
                            
                            <div class="row mt-1">
                                <div class="col-md-12">
                                    <?php echo $this->Form->button('Guardar Cambios del Cliente',array('type'=>'submit','class'=>'btn btn-success btn-block'))?>
                                </div>
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
            
            //'/vendors/chosen/js/chosen.jquery',
            
            'pages/layouts',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            
            '/vendors/validval/js/jquery.validVal.min',
            
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            'form',
            'pages/form_elements',
            
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
            
            
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {

    $('#ClienteAddForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Insertar el nombre del cliente'
                    }
                }
            },
            telefono_1: {
                validators: {
                    notEmpty: {
                        message: 'Insertar el número de teléfono del cliente'
                    }
                }
            },
            tipo_cliente: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar un tipo de cliente'
                    }
                }
            },
            etapa_cliente: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar en que etapa se encuentra el cliente'
                    }
                }
            },
            forma_contacto: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar la forma de contacto del cliente'
                    }
                }
            },
        }
    });

    // Input mask
    $(".phone").inputmask();
    // End of input mask

});


<?php 
    $this->Html->scriptEnd();
?>

