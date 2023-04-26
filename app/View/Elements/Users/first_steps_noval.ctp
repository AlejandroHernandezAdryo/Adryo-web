
<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <i class="fa fa-file-text-o"></i>
                                    Primeros Pasos
                                    <p><small>Bienvenido a Inmosystem. En este tutorial cargaremos la información inicial necesaria para configurar tu empresa.</small></p>
                                </div>
                               
                                <div class="card-block m-t-20">
                                    
                                    <!--<form id="UserFirstStepsForm" method="post" action="/bos2/users/first_steps" class="validate">-->
                                                <div id="rootwizard_no_val">
                                                    <ul class="nav nav-pills">
                                                        <li class="nav-item user1 m-t-15">
                                                            <a class="nav-link" href="#tab11" data-toggle="tab"><span
                                                                    class="userprofile_tab">1</span>Información Super Usuario</a>
                                                        </li>
                                                        <li class="nav-item user2 m-t-15">
                                                            <a class="nav-link profile_details" href="#tab21"
                                                               data-toggle="tab"><span class="profile_tab">2</span>Información de Cuenta</a>
                                                        </li>
                                                        <li class="nav-item finish_tab m-t-15">
                                                            <a class="nav-link " href="#tab31" data-toggle="tab"><span>3</span>Configuración Básica</a>
                                                        </li>
                                                    </ul>
                                                    <?= $this->Form->create('User',array('type'=>'file'))?>
                                                    <div class="tab-content m-t-20">
                                                        <div class="tab-pane" id="tab11">
                                                            <?= $this->Form->input('nombre_completo',array('value'=>$this->Session->read('Auth.User.nombre_completo'),'name'=>'nombre_completo','class'=>'form-control required','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('email',array('value'=>$this->Session->read('Auth.User.correo_electronico'),'name'=>'email','class'=>'form-control required','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('telefono1',array('name'=>'telefono1','div' => 'form-group form-group col-md-6','class'=>'form-control phone','label'=>'Teléfono 1','data-inputmask'=>'"mask": "(999) 999-9999 (ext 99999)"','data-mask'))?>
                                                            <?= $this->Form->input('telefono2',array('name'=>'telefono2','div' => 'form-group form-group col-md-6','class'=>'form-control phone','label'=>'Teléfono 2','data-inputmask'=>'"mask": "(999) 999-9999 (ext 99999)"','data-mask'))?>
                                                            <?= $this->Form->input('password',array('name'=>'password','class'=>'form-control required','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('password2',array('name'=>'password2','class'=>'form-control required','div'=>'col-md-6 form-group','type'=>'password'))?>
                                                            <div class="col-md-12">
                                                                <h5>Imagen del perfil</h5>
                                                                <?= $this->Form->file('profile_picture',array('class'=>'file-loading','accept'=>'image/*','class'=>'form-control required','div'=>'col-md-12 form-group'))?>
                                                            </div>                                                     
                                                            <ul class="pager wizard pager_a_cursor_pointer">
                                                                <li class="previous previous_btn2"><a>Previous</a></li>
                                                                <li class="next next_btn2"><a>Next</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="tab21">
                                                            <?= $this->Form->input('razon_social',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.razon_social'),'name'=>'razon_social','class'=>'form-control required','div'=>'col-md-12 form-group'))?>
                                                            <?= $this->Form->input('nombre_comercial',array('name'=>'nombre_comercial','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('rfc',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.rfc'),'name'=>'rfc','class'=>'form-control required','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('direccion_fiscal',array('value'=>$this->Session->read('CuentaUsuario.Cuenta.direccion_fiscal'),'name'=>'direccion_fiscal','class'=>'form-control required','div'=>'col-md-12 form-group'))?>
                                                            <?= $this->Form->input('telefono_empresa_1',array('name'=>'telefono_empresa_1','div' => 'form-group form-group col-md-6','class'=>'form-control phone','label'=>'Teléfono 1','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                                                            <?= $this->Form->input('telefono_empresa_2',array('name'=>'telefono_empresa_2','div' => 'form-group form-group col-md-6','class'=>'form-control phone','label'=>'Teléfono 2','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                                                            <?= $this->Form->input('pagina_web',array('name'=>'pagina_web','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('correo_contacto',array('name'=>'correo_contacto','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                            <div class="col-md-12">
                                                                <h5>Logo de empresa</h5>
                                                                <?= $this->Form->file('logo',array('class'=>'file-loading','accept'=>'image/*','class'=>'form-control required','div'=>'col-md-12 form-group'))?>
                                                            </div>                                                     
       
                                                            <ul class="pager wizard pager_a_cursor_pointer">
                                                                <li class="previous previous_btn2"><a>Previous</a></li>
                                                                <li class="next next_btn2"><a>Next</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="tab31">
                                                            <div class='row'>
                                                                <h5>Configuración para envío de correos</h5>
                                                                <?= $this->Form->input('smtp',array('class'=>'form-control','div'=>'col-md-4 form-group'))?>
                                                                <?= $this->Form->input('usuario_mail',array('class'=>'form-control','div'=>'col-md-3 form-group'))?>
                                                                <?= $this->Form->input('password_mail',array('class'=>'form-control','div'=>'col-md-3 form-group'))?>
                                                                <?= $this->Form->input('puerto_mail',array('class'=>'form-control','div'=>'col-md-2 form-group'))?>
                                                            </div>
                                                            <div class='row'>
                                                                <h5>Reglas de envío de correos</h5>
                                                                <h6>Correos de Registro de cliente</h6>
                                                                <?= $this->Form->input('mr',array('class'=>'form-control','div'=>'col-md-3 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar un correo al registrar un nuevo cliente?'))?>
                                                                <?= $this->Form->input('to_mr',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Correo de registro de cliente a:'))?>
                                                                <?= $this->Form->input('cc_mr',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Copia de correo de registro de cliente a:'))?>
                                                                <?= $this->Form->input('cco_mr',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Copia Oculta de correo de registro de cliente a:'))?>
                                                                <h6>Correos a clientes</h6>
                                                                <?= $this->Form->input('mep',array('class'=>'form-control','div'=>'col-md-3 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar correos al cliente?'))?>
                                                                <?= $this->Form->input('cc_mep',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Copia de correo a cliente a:'))?>
                                                                <?= $this->Form->input('cco_mep',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Copia Oculta de correo a cliente a:'))?>
                                                                <h6>Correos a Asesor</h6>
                                                                <?= $this->Form->input('ma',array('class'=>'form-control','div'=>'col-md-3 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar correos a asesores?'))?>
                                                                <?= $this->Form->input('cc_ma',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Copia de correo a asesores a:'))?>
                                                                <?= $this->Form->input('cco_ma',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Copia Oculta de correo a asesores a:'))?>
                                                            </div>
                                                            <div class='row'>
                                                                <h5>Reglas de límites para notificaciones de reportes</h5>
                                                                <?= $this->Form->input('sla_atrasados',array('class'=>'form-control','div'=>'col-md-3 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar un correo al registrar un nuevo cliente?'))?>
                                                                <?= $this->Form->input('sla_no_atendidos',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Enviar Correo de registro de cliente a:'))?>
                                                            </div>
                                                            <div class='row'>
                                                                <h5>Sistema de calificación de temperaturas de clientes</h5>
                                                                <h6>Para generar la temperatura del cliente, se considera un calificación de 0 a 100, en donde 0 es frío y 100 es caliente. Esto te ayudará para tomar decisiones de que tan probable es que se cierre una operación</h6>
                                                                <?= $this->Form->input('llamadas',array('class'=>'form-control','div'=>'col-md-3 form-group','label'=>'Puntos obtenidos por cada llamada (Default: 5pts)'))?>
                                                                <?= $this->Form->input('emails',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Puntos obtenidos por cada mail enviado (Default: 3pts)'))?>
                                                                <?= $this->Form->input('visitas',array('class'=>'form-control','div'=>'col-md-4 form-group','label'=>'Puntos obtenidos por cada visita a inmueble (Default: 20pts)'))?>
                                                            </div>
                                                            <ul class="pager wizard pager_a_cursor_pointer">
                                                                <li class="previous previous_btn2"><a>Previous</a></li>
                                                                <li class="next"><a><?php echo $this->Form->submit('Guardar Información',array('type'=>'submit','class'=>'btn btn-primary'))?></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?= $this->Form->end()?>
                                                </div>
                                                
                                           
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Modal -->
        </div>

 
<?= $this->Html->script(
        array(
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme'
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
    $("#UserFirstStepsForm_bak").bootstrapValidator({
        fields: {
            nombre_completo: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su nombre completo'
                    }
                },
                required: true,
                minlength: 3
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
            razon_social: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario la Razón Social de la empresa'
                    }
                }                
            },
            rfc: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el RFC de la empresa'
                    }
                },
                required: true,
                minlength: 12,
                maxlength: 13
            },
            direccion_fiscal: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario la dirección fiscal de la empresa'
                    }
                },
                
            },
            telefono_empresa_1: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario un número de teléfono'
                    }
                }
            },
            
        }
    });

    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function(tab, navigation, index) {
            var $validator = $('#UserFirstStepsForm_bak').data('bootstrapValidator').validate();
            if($validator.isValid()){
                // alert('fd');
                $(".userprofile_tab1").addClass("tab_clr");
                $(".userprofile_tab2").addClass("tab_clr");
            }
            return $validator.isValid();
        },
        'onPrevious': function(tab, navigation, index) {
            $(".userprofile_tab2").removeClass("tab_clr");
        },
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            var $rootwizard= $('#rootwizard');
            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $rootwizard.find('.pager .next').hide();
                $rootwizard.find('.pager .finish').show();
                $rootwizard.find('.pager .finish').removeClass('disabled');
            } else {
                $rootwizard.find('.pager .next').show();
                $rootwizard.find('.pager .finish').hide();
            }
            $('#rootwizard .finish').on("click",function() {
                var $validator = $('#UserFirstStepsForm_bak').data('bootstrapValidator').validate();
                if ($validator.isValid()) {
                    $('#myModal').modal('show');
                    return $validator.isValid();
                    $rootwizard.find("a[href='#tab1']").tab('show');
                    
                }
            });

        }});
        
    $('#rootwizard_no_val').bootstrapWizard({'tabClass': 'nav nav-pills'});
    
    $(".user2, .finish_tab, .next_btn1").on("click", function(){
        $(".userprofile_tab").addClass("tab_clr");
    });
    $(".user1, .previous_btn2").on("click", function(){
        $(".userprofile_tab").removeClass("tab_clr");
    });
    $(".finish_tab, .next_btn2").on("click", function(){
        $(".profile_tab").addClass("tab_clr");
    });
    $(".user2, .previous_btn3").on("click", function(){
        $(".profile_tab").removeClass("tab_clr");
    });
    $(".user1").on('click',function () {
        $(".user2 a span").removeClass("tab_clr");
    });
    $(".general_number").on('keyup',function () {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g,'')
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