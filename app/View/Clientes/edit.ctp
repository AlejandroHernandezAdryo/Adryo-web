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
                <?= $this->Form->create('Cliente',array('class'=>'form-horizontal login_validator'));?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block m-t-20">
                                <div class="row">
                                <?= $this->Form->input('nombre',
                                    array(
                                        'value'    => $cliente['Cliente']['nombre'],
                                        'required' => false,
                                        'div'      => 'col-md-12',
                                        'class'    => 'form-control required',
                                        'type'     => 'text',
                                        'label'    => 'Nombre del cliente*',
                                        'required' => true
                                    )
                                )?>

                                <?= $this->Form->input('correo_electronico',
                                    array(
                                        'label' => 'Correo Electrónico',
                                        'div'   => 'col-md-4 m-t-20',
                                        'class' => 'form-control ',
                                        'type'  => 'text'
                                    )
                                )?>
                                        
                                <?= $this->Form->input('telefono1',
                                    array(
                                        'value'      => $cliente['Cliente']['telefono1'],
                                        'label'      => 'Teléfono 1',
                                        'div'        => 'col-md-4 m-t-20',
                                        'class'      => 'form-control phone',
                                        'type'       => 'tel',
                                        'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                                        'maxlength'  => 10

                                    )
                                )?>

                                <?= $this->Form->input('telefono2',
                                    array(
                                        'label'      => 'Teléfono 2',
                                        'div'        => 'col-md-4 m-t-20',
                                        'class'      => 'form-control phone',
                                        'type'       => 'text',
                                        'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                                        'maxlength'  => 10
                                    )
                                )?>
                                </div>
                                <div class="row">
                                    <?= $this->Form->input('telefono3',
                                        array(
                                            'label'      => 'Teléfono 3',
                                            'div'        => 'col-md-4 m-t-20',
                                            'class'      => 'form-control phone',
                                            'type'       => 'text',
                                            'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                                            'maxlength'  => 10
                                        )
                                    )?>

                                    <?= $this->Form->input('dic_tipo_cliente_id',
                                        array(
                                            'value'   => $cliente['Cliente']['dic_tipo_cliente_id'],
                                            'label'   => 'Tipo de cliente*',
                                            'div'     => 'col-md-4 m-t-20',
                                            'class'   => 'form-control chzn-select',
                                            'empty'   => 'Seleccionar tipo de cliente',
                                            'options' => $tipos_cliente
                                        )
                                    )?>

                                    <?= $this->Form->input('dic_linea_contacto_id',
                                        array(
                                            'value'   => $cliente['Cliente']['dic_linea_contacto_id'],
                                            'label'   => 'Forma de contacto*',
                                            'div'     => 'col-md-4 m-t-20',
                                            'class'   => 'form-control chzn-select',
                                            'empty'   => 'Seleccionar la forma de contacto',
                                            'options' => $linea_contactos
                                        )
                                    )?>
                                </div>
                                    
                                <div class="row mt-1">
                                    <div class="col-md-12">
                                        <?php $temp = array(1=>'Frio',2=>'Tibio',3=>'Caliente') ?>
                                        <?= $this->Form->hidden('status', array('value'=>$cliente['Cliente']['status'])); ?>
                                        <?= $this->Form->hidden('id', array('value'=>$cliente['Cliente']['id'])); ?>
                                        <?= $this->Form->hidden('etapa_comercial', array('value'=>'CRM')); ?>
                                        <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                        <?= $this->Form->button('Guardar Cambios del Cliente',array('type'=>'submit','class'=>'btn btn-success btn-block'))?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(
        array(
            
            'components',
            'custom', 
            
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

<script>

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
        }
    });

});

</script>