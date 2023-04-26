
<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            '/vendors/sweetalert/css/sweetalert2.min.css',
            'css/pages/sweet_alert'
            
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
                                    <?= $this->Form->create('User',array('type'=>'file','class'=>'validate'))?>
                                    <!--<form id="UserFirstStepsForm" method="post" action="/bos2/users/first_steps" class="validate">-->
                                                <div id="rootwizard">
                                                    <ul class="nav nav-pills">
                                                        <li class="nav-item m-t-15">
                                                            <a class="nav-link" href="#tab1" data-toggle="tab">
                                                                <span class="userprofile_tab1">1</span>Información de Super Usuario</a>
                                                        </li>
                                                        <li class="nav-item m-t-15">
                                                            <a class="nav-link" href="#tab2" data-toggle="tab">
                                                                <span class="userprofile_tab2">2</span>Información de Empresa</a>
                                                        </li>
                                                        <li class="nav-item m-t-15">
                                                            <a class="nav-link" href="#tab3"
                                                               data-toggle="tab"><span>3</span>Parámetros generales</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content m-t-20">
                                                        <div class="tab-pane" id="tab1">
                                                            <?= $this->Form->input('nombre_completo',array('name'=>'nombre_completo','class'=>'form-control required','div'=>'col-md-6 form-group','required'=>false))?>
                                                            <?= $this->Form->input('email',array('value'=>$this->Session->read('Auth.User.correo_electronico'),'name'=>'email','class'=>'form-control required','div'=>'col-md-6 form-group','required'=>false))?>
                                                            <?= $this->Form->input('telefono1',array('name'=>'telefono1','div' => 'form-group form-group col-md-6','class'=>'form-control phone required','label'=>'Teléfono 1','data-inputmask'=>'"mask": "(999) 999-9999 (ext 99999)"','data-mask','required'=>false))?>
                                                            <?= $this->Form->input('telefono2',array('name'=>'telefono2','div' => 'form-group form-group col-md-6','class'=>'form-control phone','label'=>'Teléfono 2','data-inputmask'=>'"mask": "(999) 999-9999 (ext 99999)"','data-mask','required'=>false))?>
                                                            <?= $this->Form->input('password',array('name'=>'password','class'=>'form-control required','div'=>'col-md-6 form-group','required'=>false))?>
                                                            <?= $this->Form->input('password2',array('name'=>'password2','class'=>'form-control required','div'=>'col-md-6 form-group','type'=>'password','required'=>false))?>
                                                            <div class="col-md-12">
                                                                <h5>Imagen del perfil</h5>
                                                                <?= $this->Form->file('profile_picture',array('class'=>'file-loading','accept'=>'image/*','class'=>'form-control required','div'=>'col-md-12 form-group'))?>
                                                            </div>                                                     
                                                            <ul class="pager wizard pager_a_cursor_pointer">
                                                                <li class="next">
                                                                    <a>Next <i class="fa fa-long-arrow-right"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="tab2">
                                                            <?= $this->Form->input('razon_social',array('name'=>'razon_social','class'=>'form-control required','div'=>'col-md-12 form-group','required'=>false))?>
                                                            <?= $this->Form->input('nombre_comercial',array('name'=>'nombre_comercial','class'=>'form-control required','div'=>'col-md-6 form-group','required'=>false))?>
                                                            <?= $this->Form->input('rfc',array('name'=>'rfc','class'=>'form-control required','div'=>'col-md-6 form-group','required'=>false))?>
                                                            <?= $this->Form->input('direccion_fiscal',array('name'=>'direccion_fiscal','class'=>'form-control required','div'=>'col-md-12 form-group','required'=>false))?>
                                                            <?= $this->Form->input('telefono_empresa_1',array('name'=>'telefono_empresa_1','div' => 'form-group form-group col-md-6','class'=>'form-control phone required','label'=>'Teléfono 1','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask','required'=>false))?>
                                                            <?= $this->Form->input('telefono_empresa_2',array('div' => 'form-group form-group col-md-6','class'=>'form-control phone','label'=>'Teléfono 2','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                                                            <?= $this->Form->input('pagina_web',array('name'=>'pagina_web','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                            <?= $this->Form->input('correo_contacto',array('name'=>'correo_contacto','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                            <div class="col-md-12">
                                                                <h5>Logo de empresa</h5>
                                                                <?= $this->Form->file('logo',array('class'=>'file-loading','accept'=>'image/*','class'=>'form-control required','div'=>'col-md-12 form-group'))?>
                                                            </div>                                                     
       
                                                            <ul class="pager wizard pager_a_cursor_pointer">
                                                                <li class="previous">
                                                                    <a><i class="fa fa-long-arrow-left"></i>
                                                                        Previous</a>
                                                                </li>
                                                                <li class="next">
                                                                    <a>Next <i class="fa fa-long-arrow-right"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="next finish" style="display:none;">
                                                                    <a>Finish</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="tab-pane" id="tab3">
                                                            <div class='row'>
                                                                <h5><font color="black"><b>Configuración para envío de correos</b></font></h5>
                                                                <?= $this->Form->input('smtp',array('label'=>'Servidor de correos salientes','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                                <?= $this->Form->input('usuario_mail',array('label'=>'Usuario de Servidor','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                                <?= $this->Form->input('password_mail',array('label'=>'Contraseña de Cuenta','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                                <?= $this->Form->input('puerto_mail',array('label'=>'Puerto de salida','class'=>'form-control','div'=>'col-md-6 form-group'))?>
                                                            </div>
                                                            <div class='row'>
                                                                <h5><font color="black"><b>Reglas de envío de correos</b></font></h5>
                                                                <h6><font color="black">Correos de Registro de cliente</font></h6>
                                                                <?= $this->Form->input('mr',array('class'=>'form-control','div'=>'col-md-6 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar un correo al registrar un nuevo cliente?'))?>
                                                                <?= $this->Form->input('to_mr',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Correo de registro de cliente a:'))?>
                                                                <?= $this->Form->input('cc_mr',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Copia de correo de registro de cliente a:'))?>
                                                                <?= $this->Form->input('cco_mr',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Copia Oculta de correo de registro de cliente a:'))?>
                                                                <h6><font color="black">Correos a clientes</font></h6>
                                                                <?= $this->Form->input('mep',array('class'=>'form-control','div'=>'col-md-6 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar correos al cliente?'))?>
                                                                <?= $this->Form->input('cc_mep',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Copia de correo a cliente a:'))?>
                                                                <?= $this->Form->input('cco_mep',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Copia Oculta de correo a cliente a:'))?>
                                                                <h6><font color="black">Correos a Asesor</font></h6>
                                                                <?= $this->Form->input('ma',array('class'=>'form-control','div'=>'col-md-6 form-group','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Deseas mandar correos a asesores?'))?>
                                                                <?= $this->Form->input('cc_ma',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Copia de correo a asesores a:'))?>
                                                                <?= $this->Form->input('cco_ma',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Enviar Copia Oculta de correo a asesores a:'))?>
                                                            </div>
                                                            <div class='row'>
                                                                <h5><font color="black"><b>Reglas de límites para notificaciones de reportes</b></font></h5>
                                                                <?= $this->Form->input('sla_atrasados',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Periodo de inactividad en el cliente para considerarlo como Cliente con atención Atrasada'))?>
                                                                <?= $this->Form->input('sla_no_atendidos',array('class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Periodo de inactividad en el cliente para considerarlo como Cliente sin seguimiento'))?>
                                                            </div>
                                                            <div class='row'>
                                                                <h5><font color="black"><b>Sistema de calificación de temperaturas de clientes</b></font></h5>
                                                                <h6><font color="black">Para generar la temperatura del cliente, se considera un calificación de 0 a 100, en donde 0 es frío y 100 es caliente. Esto te ayudará para tomar decisiones de que tan probable es que se cierre una operación</font></h6>
                                                                <?= $this->Form->input('automatico',array('type'=>'checkbox','class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Prefiero que el sistema calcule automáticamente la temperatura del cliente'))?>
                                                                <?= $this->Form->input('llamadas',array('value'=>'5','class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Puntos obtenidos por cada llamada (Default: 5pts)'))?>
                                                                <?= $this->Form->input('emails',array('value'=>'3','class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Puntos obtenidos por cada mail enviado (Default: 3pts)'))?>
                                                                <?= $this->Form->input('visitas',array('value'=>'20','class'=>'form-control','div'=>'col-md-6 form-group','label'=>'Puntos obtenidos por cada visita a inmueble (Default: 20pts)'))?>
                                                            </div>
                                                                                                            
       
                                                            <ul class="pager wizard pager_a_cursor_pointer">    
                                                                <li class="previous">
                                                                    <a><i class="fa fa-long-arrow-left"></i>
                                                                        Previous</a>
                                                                </li>
                                                                <li class="next">
                                                                    <a>Next <i class="fa fa-long-arrow-right"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="next finish" style="display:none;">
                                                                    <?= $this->Form->submit('Guardar Información',array('disabled'=>false,'class'=>'btn btn-primary'))?>
                                                                </li>
                                                            </ul>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="search_modal" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <form>
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="input-group search_bar_small">
                                <input type="text" class="form-control" placeholder="Search..." name="search">
                                <span class="input-group-btn">
        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
      </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

 
<?= $this->Html->script(
        array(
            '/vendors/sweetalert/js/sweetalert2.min',
            
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
            
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
    
    $('.examples .success').on('click', function () {
        swal({
            title: 'Good job!',
            text: 'You clicked the button!',
            type: 'success',
            confirmButtonColor: '#4fb7fe'
        }).done();
        return false;
    });
    
    $("#UserFirstStepsForm").bootstrapValidator({
        
    
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

    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function(tab, navigation, index) {
            var $validator = $('#UserFirstStepsForm').data('bootstrapValidator').validate();
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
                $rootwizard.find('.pager .finish .btn btn-primary').removeClass('disabled');
            } else {
                $rootwizard.find('.pager .next').show();
                $rootwizard.find('.pager .finish').hide();
            }
            $('#rootwizard .finish').on("click",function() {
                var $validator = $('#UserFirstStepsForm').data('bootstrapValidator').validate();
                if ($validator.isValid()) {
                    $('#myModal').modal('show');
                    return $validator.isValid();
                    $rootwizard.find("a[href='#tab1']").tab('show');
                    
                }
            });

        }});
    
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