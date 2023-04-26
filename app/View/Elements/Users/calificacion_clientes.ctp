
<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            'pages/general_components',
            
            ),
        array('inline'=>false))
        
?>
<script>
    function showPuntos(){
        if (document.getElementById('ParamconfigSeleccion').value==2){
            document.getElementById('puntos').style.display="none";
        }else{
            document.getElementById('puntos').style.display="";
        }
    }
    
</script>
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
                                        <i class="fa fa-users"></i>
                                        Seguimiento de clientes
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
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">3</span>Reglas de envío de correos',
                                                    array(
                                                        'controller'=>'users','action'=>'parametros_mail'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                            
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">4</span>Diccionarios',
                                                    array(
                                                        'controller'=>'users','action'=>'diccionarios'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link active" href="#"
                                               data-toggle="tab" style="pointer-events: none"><span>5</span>Parámetros Generales</a>
                                        </li>
                                    </ul>
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('Paramconfig',array('url'=>array('controller'=>'Paramconfigs','action'=>'parametros'),'class'=>'form-horizontal login_validator'))?>
                                            <h2> <font color="black">Configuración de temperatura de clientes</h2>
                                            <div class="form-group row">
                                                <div class="col-xl-3 text-xl-right">
                                                    <label for="smtp" class="form-control-label">Selección de método de calificación de cliente</label>
                                                    
                                                </div>
                                                <?= $this->Form->input('seleccion',array('onchange'=>'javascript:showPuntos()','empty'=>'Seleccionar una opción','label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(1=>'Automático',2=>'Manual')))?>
                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="El método automático tiene una ponderación por defecto para cada uno de los eventos asignados al cliente. Considera llamadas, emails y visitas. Por cada evento, se van aumentando los puntos al cliente y están en una escala del 0 al 100. Entre más cercano al 100, el cliente va aumentando la temperatura. En el modo manual, el usuario decide la temperatura del cliente">
                                                        <i class="fa fa-question-circle"></i>
                                                </button>
                                            </div>
                                            <div id="puntos" style="display:none">
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="puerto" class="form-control-label">Puntos por llamada hecha al cliente</label>
                                                    </div>
                                                    <?= $this->Form->input('llamadas',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','placeholder'=>'Default: 5 puntos por llamada'))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">Puntos por email enviado al cliente</label>
                                                    </div>
                                                    <?= $this->Form->input('emails',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','placeholder'=>'Default: 3 puntos por email enviado'))?>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">Puntos por visita hecha al/del cliente</label>
                                                    </div>
                                                    <?= $this->Form->input('visitas',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','placeholder'=>'Default: 10 puntos por visita realizada'))?>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="card-block">
                                            <h2> <font color="black">Configuración de seguimiento de clientes</h2>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="puerto" class="form-control-label">Dias sin atención para declarar al cliente como "Sin atención"</label>
                                                    </div>
                                                    <?= $this->Form->input('sla_atrasados',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','placeholder'=>'Default: 3 días'))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">Dias sin atención para declarar al cliente como "Abandonado"</label>
                                                    </div>
                                                    <?= $this->Form->input('sla_no_atendidos',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','placeholder'=>'Default: 5 días'))?>

                                                </div>
                                                
                                    </div>
                                    <div class="card-block">
                                            <h2> <font color="black">Notificaciones</h2>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="puerto" class="form-control-label">Días previos al vencimiento de una propiedad en Exclusiva</label>
                                                    </div>
                                                    <?= $this->Form->input('vencimiento_propiedades',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','placeholder'=>'Default: 15 días'))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">¿Notificar a asesores cuando se agregue una nueva propiedad?</label>
                                                    </div>
                                                    <?= $this->Form->input('nueva_propiedad',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">¿Notificar a asesores cuando se agregue un nuevo desarrollo?</label>
                                                    </div>
                                                    <?= $this->Form->input('nuevo_desarrollo',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">¿Notificar a asesores cambios en precio de las propiedades?</label>
                                                    </div>
                                                    <?= $this->Form->input('cambio_precios',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">¿Notificar a asesores de cambio de status del inmueble?</label>
                                                    </div>
                                                    <?= $this->Form->input('cambio_status',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-3 text-xl-right">
                                                        <label for="usuario" class="form-control-label">¿Notificar a opcionador cuando se registre un evento al inmueble?</label>
                                                    </div>
                                                    <?= $this->Form->input('evento_inmueble',array('label'=>false,'class'=>'form-control','div'=>'col-md-6','type'=>'select','options'=>array(0=>'No',1=>'Si')))?>
                                                </div>
                                                
                                            <div class="form-actions form-group row">
                                                <div class="col-xl-10">
                                                    
                                                    <input type="submit" value="Finalizar y continuar" class="btn btn-success" style="width:100%">
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

<script>
$(document).ready(function () {
    $('[data-toggle="popover"]').popover()
});
</script>