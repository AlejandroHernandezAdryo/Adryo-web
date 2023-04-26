<?= $this->Html->css(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/css/jquery.tagsinput',
            '/vendors/daterangepicker/css/daterangepicker',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            
            '/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min',
            '/vendors/summernote/css/summernote',
            'custom',
            
            'pages/form_elements',
        
            
            
            ),
        array('inline'=>false))
        
?>
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Subir Desarrollo</h4>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                        <?php echo $this->Form->create('Desarrollo', array('type'=>'file','class'=>'validate'));?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <i class="fa fa-file-text-o"></i>
                                    Subir Desarrollo
                                </div>
                                <div class="card-block m-t-20">
                                    <div id="rootwizard">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab01" data-toggle="tab"><span
                                                        class="userprofile_tab">1</span>Datos Generales</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab02" data-toggle="tab"><span
                                                        class="userprofile_tab">2</span>Amenidades</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab03" data-toggle="tab"><span>3</span>Fotos</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content m-t-20">
                                            <div class="tab-pane" id="tab01">
                                                <?php echo $this->Form->hidden('cuenta_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                <?php echo $this->Form->input('nombre', array('name'=>'nombre','div' => 'col-xs-12','class'=>'form-control','label'=>'Nombre de desarrollo'));
							echo $this->Form->input('tipo_desarrollo', array('div' => 'col-xs-6','class'=>'form-control','label'=>'Tipo de desarrollo','type'=>'select','options'=>array('Horizontal'=>'Horizontal','Vertical'=>'Vertical')));
							echo $this->Form->input('unidades_totales', array('div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('entrega', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>array('Dar Fecha'=>'Dar Fecha','Inmediata'=>'Inmediata')));
							
							?>
                            				<div class="col-xs-6">
                                                            <label for="DesarrolloFechaEntrega">Fecha Entrega</label>
                                                                    <?php echo $this->Form->date('fecha_entrega', array('class'=>'form-control','style'=>'width:100%'))?>
                                                                    </div>
                                                        <?php echo $this->Form->input('compartir', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Se puede compartir inmueble?'))?>
                                                        <div class="form-group col-md-6">
                                                        <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                        <div class="input-group">
                                                            <input class="form-control percent" type="text"  id="percent"   name="data[Desarrollo][porcentaje_compartir]" data-mask="" >
                                                            <span class="input-group-addon">99.9%</span>
                                                        </div>
                                                    </div>
                                                                                    <div class="col-xs-6">
                                                            <label for="DesarrolloInicioPreventa">Inicio Preventa</label>
                                                        <?php echo $this->Form->date('inicio_preventa', array('class'=>'form-control','style'=>'width:100%'))?>
                                                        </div>
                   			
                   			
							<?php
							echo $this->Form->input('torres', array('div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('departamento_muestra', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>array(1=>'Si',2=>'No')));
							echo $this->Form->input('calle', array('name'=>'calle','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('numero_ext', array('name'=>'numero_ext','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('numero_int', array('div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('colonia', array('name'=>'colonia','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('delegacion', array('name'=>'delegacion','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('cp', array('name'=>'cp','div' => 'col-xs-6','class'=>'form-control','label'=>'Código Postal'));
							echo $this->Form->input('ciudad', array('name'=>'ciudad','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('estado', array('name'=>'estado','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('google_maps', array('div' => 'col-xs-6','class'=>'form-control'));
                                                        
							
						?>
                                                <div class="row summer_note_display summer_note_btn">
                                                    <div class="col-xs-12">
                                                        <div class='card m-t-35'>
                                                            <div class='card-header bg-white '>
                                                                Descripción de la propiedad
                                                                <small>Datos generales</small>
                                                                <!-- tools box -->
                                                                <div class="float-xs-right box-tools"></div>
                                                                <!-- /. tools -->
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class='card-block pad m-t-25'>
                                                                <form>
                                                                <textarea name="data[Desarrollo][descripcion]" id="InmuebleComentarios" class="textarea form_editors_textarea_wysihtml"
                                                                          placeholder="Escribir descripción"></textarea>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                            <div class="tab-pane" id="tab02">
                                                <?php
                                                echo $this->Form->input('asador', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('alberca_techada', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('alberca_sin_techar', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('areas_verdes', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('business_center', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('cafeteria', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('carril_nado', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('cctv', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('elevadores', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('estacionamiento_visitas', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('fire_pit', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('gimnasio', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('interfon', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('internet', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('jacuzzi', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('juegos_infantiles', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('lobby', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('paddle_tennis', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('patio', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('pista_jogging', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('planta_emergencia', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('porton_electrico', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('roof_garden_compartido', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
                                                echo $this->Form->input('sala_cine', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
						echo $this->Form->input('salon_juegos', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
						echo $this->Form->input('salon_usos_multiples', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
						echo $this->Form->input('seguridad', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
						echo $this->Form->input('sistema_contra_incendios', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
						echo $this->Form->input('sky_garden', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
						echo $this->Form->input('spa_vapor', array('div' => 'col-xs-3','class'=>'checkbox icheck','type'=>'checkbox'));
							
						?>
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
                                            <div class="tab-pane" id="tab03">
                                                
                                                    <div class="col-lg-12 m-t-35">
                                                        <h5>Imágenes del inmueble</h5>
                                                        <input id="input-fa" name="data[Desarrollo][fotos][]" type="file" multiple class="file-loading">
                                                    </div>
                                                    <?php //echo $this->Form->input('foto_inmueble.',array('type'=>'file','multiple','div' => 'col-md-6','class'=>'form-control','label'=>'Fotografias'));?>
                                                 <ul class="pager wizard pager_a_cursor_pointer">
                                                    <li class="previous">
                                                        <a><i class="fa fa-long-arrow-left"></i>
                                                            Previous</a>
                                                    </li>
                                                    <li class="next">
                                                        <a>Next <i class="fa fa-long-arrow-right"></i>
                                                        </a>
                                                    </li>
                                                    
                                                    
                                                </ul>
                                                <?php echo $this->Form->submit('Terminar',array('type'=>'submit','class'=>'btn btn-primary'))?>
                                            </div>
                                        </div>
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
           'pages/layouts',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
          
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
            
//            'pages/wizard',
//            'pages/form_editors',
//            'pages/form_elements',
            
           
           
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
    $("#DesarrolloAddForm").bootstrapValidator({
        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria una referencia del inmueble'
                    }
                }
            },
            calle: {
                validators: {
                    notEmpty: {
                        message: 'Ingresa la calle del inmueble'
                    }
                }
                
            },
            numero_ext: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el número exterior de la propiedad'
                    }
                }
            },
            colonia: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el la colonia de la propiedad'
                    }
                }
            },
            delegacion: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la delegación / municipio de la propiedad'
                    }
                }
            },
            ciudad: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la ciudad de la propiedad'
                    }
                }
            },
            cp: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el código postal de la propiedad'
                    }
                }
            },
            estado: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el estado de la propiedad'
                    }
                }
            }
            
        }
    });

    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function(tab, navigation, index) {
            var $validator = $('#DesarrolloAddForm').data('bootstrapValidator').validate();
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
                var $validator = $('#DesarrolloAddForm').data('bootstrapValidator').validate();
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
    
    // Input mask
    $(".phone").inputmask();
    $("#product").inputmask("a*-999-a999");
    $(".percent").inputmask("99.9%");
    $(".date_mask").inputmask("yyyy-mm-dd");
    // End of input mask

    //tags input
    $('#tags').tagsInput();
    
    $("#input-fa").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png", "bmp", "tiff", "jpeg"],
        
        
    });
    
    Admire.formGeneral() ;
    
    $(".textarea").wysihtml5();
    $('.airmode').summernote({
        height: 300,
        airMode: true
    });

    // TinyMCE Full
    tinymce.init({
        selector: "#tinymce_full",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
    // Bootstrap
    $('#bootstrap-editor').wysihtml5({
        stylesheets: [
            'assets/lib/bootstrap-wysihtml5/stylesheets/bootstrap-wysihtml5wysiwyg-color.css'
        ]
    });

    $('.summernote_editor').summernote({
        height:200
    });
    $(".wysihtml5-toolbar li:nth-child(3) a,.wysihtml5-toolbar li:nth-child(4) a,.wysihtml5-toolbar li:nth-child(5) a,.wysihtml5-toolbar li:nth-child(6) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:first-child,.wysihtml5-toolbar .btn-group:eq(3) a:first-child").addClass("fa fa-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(2),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(2)").addClass("fa fa-th-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(3),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(3)").addClass("fa fa-align-left");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(4),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(4)").addClass("fa fa-align-right");
    $(".wysihtml5-toolbar li:nth-child(5) span").addClass("fa fa-share");
    $(".wysihtml5-toolbar li:nth-child(6) span").addClass("fa fa-picture-o");
    $("[data-wysihtml5-command='formatBlock'] span").css("position","relative").css("top","-5px").css("left","-5px");
    $(".note-toolbar button").removeClass('btn-default').addClass('btn-secondary');
    $(".wysihtml5-toolbar li:nth-child(2) a").removeClass('btn-default').addClass('btn-secondary');
    
});


<?php 
    $this->Html->scriptEnd();
?>