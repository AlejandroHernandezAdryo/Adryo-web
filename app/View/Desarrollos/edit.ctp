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
            
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/css/pages/form_validations',
            
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/datepicker/css/bootstrap-datepicker3'
            
            ),
        array('inline'=>false))
        
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-building"></i>Editar Desarrollo</h4>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                        <?php echo $this->Form->create('Desarrollo', array('class'=>'form-horizontal login_validator'));?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block m-t-20">
                                    <div id="rootwizard">
                                        <div class="card-block m-t-35">
                                            <h3><font color="black">Datos del desarrollo</h3>
                                            <div class="row">
                                                <?= $this->Form->input('id')?>
                                                <?php echo $this->Form->hidden('cuenta_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                <?php echo $this->Form->input('nombre', array('name'=>'nombre','div' => 'col-xs-12','class'=>'form-control','label'=>'Nombre de desarrollo'));
							echo $this->Form->input('tipo_desarrollo', array('empty'=>'Seleccionar tipo de desarrollo','name'=>'tipo','div' => 'col-xs-6','class'=>'form-control','label'=>'Tipo de desarrollo','type'=>'select','options'=>array('Horizontal'=>'Horizontal','Vertical'=>'Vertical')));
                                                        ?>
                                                        <div class="col-xs-6">
                                                            <label for="DesarrolloInicioPreventa">Inicio Preventa</label>
                                                        <?php echo $this->Form->input('inicio_preventa', array('type'=>'text','class'=>'form-control fecha','style'=>'width:100%','label'=>false))?>
                                                        </div>
                                                        <?php echo $this->Form->input('unidades_totales', array('div' => 'col-md-6','class'=>'form-control'));?>
                                                <?php echo $this->Form->input('torres', array('div' => 'col-xs-6','class'=>'form-control'));?>
                                                 <div class="col-md-6" id="comision">
                                                            <label for="InmueblePorcentajeCompartir">Comisión</label>
                                                            <div class="input-group">
                                                                <input class="form-control percent" type="text"  id="percent"   name="data[Desarrollo][comision]" data-mask="" >
                                                                <span class="input-group-addon">99.9%</span>
                                                            </div>
                                                        </div>
                                                <?php
                                                        echo $this->Form->input('departamento_muestra', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>array(1=>'Si',2=>'No')));
							
                                                        ?>
                                            <script>
                                                function validarEntrega(){
                                                    if(document.getElementById('entrega').value=="Dar Fecha"){
                                                        document.getElementById('fecha_entrega').style.display="";
                                                    }else{
                                                        document.getElementById('fecha_entrega').style.display="none";
                                                    }
                                                }
                                            </script>
                                            </div>
                                            <div class="row">
							<?php echo $this->Form->input('entrega', array('id'=>'entrega','onchange'=>'javascript:validarEntrega()','div' => 'col-xs-6','class'=>'form-control','type'=>'select','empty'=>'Seleccionar Entrega','options'=>array('Dar Fecha'=>'Dar Fecha','Inmediata'=>'Inmediata')));
							?>
                                            <div></div>
                            				<div class="col-xs-6" id="fecha_entrega" style="display:none">
                                                            <label for="DesarrolloFechaEntrega">Fecha Entrega</label>
                                                                    <?php echo $this->Form->input('fecha_entrega', array('type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%'))?>
                                                                    </div>
                                            </div>
                                            <div class="row">            
                                            <script>
                                                function validarCompartir(){
                                                    if(document.getElementById('compartir').value==1){
                                                        document.getElementById('porcentaje').style.display="";
                                                    }else{
                                                        document.getElementById('porcentaje').style.display="none";
                                                    }
                                                }
                                            </script>
                                                        <?php echo $this->Form->input('compartir', array('id'=>'compartir','onchange'=>'javascript:validarCompartir()','div' => 'col-md-6','class'=>'form-control','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Se puede compartir inmueble?'))?>
                                                        <div class="col-md-6" id="porcentaje" style="display:none">
                                                            <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                            <div class="input-group">
                                                                <input class="form-control percent" type="text"  id="percent"   name="data[Desarrollo][porcentaje_compartir]" data-mask="" >
                                                                <span class="input-group-addon">99.9%</span>
                                                            </div>
                                                        </div>
                                            
                                                        
                                                                                    
                                            </div>
                                            
                                                        <div class="row summer_note_display summer_note_btn">
                                                    <div class="col-xs-12">
                                                        <div class='card m-t-35'>
                                                            <div class='card-header bg-white '>
                                                                Descripción del desarrollo
                                                                <small>Datos generales</small>
                                                                <!-- tools box -->
                                                                <div class="float-xs-right box-tools"></div>
                                                                <!-- /. tools -->
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class='card-block pad m-t-25'>
                                                                
                                                                <textarea name="data[Desarrollo][descripcion]" id="DesarrolloDescripcion" class="textarea form_editors_textarea_wysihtml"
                                                                          placeholder="Escribir descripción">
                                                                              <?= $desarrollo['Desarrollo']['descripcion']?>
                                                                </textarea>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                        <div class="row m-t-35">
                                                            <h3><font color="black">Ubicación del desarrollo</h3>
                                                        <?php
							
							echo $this->Form->input('calle', array('name'=>'calle','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('numero_ext', array('name'=>'numero_ext','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('numero_int', array('div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('colonia', array('name'=>'colonia','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('delegacion', array('name'=>'delegacion','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('cp', array('name'=>'cp','div' => 'col-xs-6','class'=>'form-control','label'=>'Código Postal'));
							echo $this->Form->input('ciudad', array('name'=>'ciudad','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('estado', array('name'=>'estado','div' => 'col-xs-6','class'=>'form-control'));
							echo $this->Form->input('google_maps', array('div' => 'col-xs-6','class'=>'form-control','label'=>'Coordenadas Google Maps'));
                                                        ?>
                                                        </div>
                                            <div class="row m-t-35">
                                                <h3><font color="black">Amenidades</h3>
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
                                                
                                            </div>
                                                <div class="form-actions form-group row">
                                                <div class="col-xl-12">
                                                    
                                                    <input type="submit" value="Guardar Información" class="btn btn-success" style="width:100%">
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
            
            //'pages/wizard',
            //'pages/form_editors',
            //'pages/form_elements',
            
           
           
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
    
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
    $('#DesarrolloAddForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria una referencia del desarrollo'
                    }
                }
            },
            tipo: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar tipo de desarrollo'
                    }
                }
            },
            calle: {
                validators: {
                    notEmpty: {
                        message: 'Ingresa la calle del desarrollo'
                    }
                }
                
            },
            numero_ext: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el número exterior del desarrollo'
                    }
                }
            },
            colonia: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el la colonia del desarrollo'
                    }
                }
            },
            delegacion: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la delegación / municipio del desarrollo'
                    }
                }
            },
            ciudad: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la ciudad del desarrollo'
                    }
                }
            },
            cp: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el código postal del desarrollo'
                    }
                }
            },
            estado: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el estado del desarrollo'
                    }
                }
            }
        }
    });

    
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
    // End of chosen

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
    
    $("#input-fa-2").fileinput({
        theme: "fa",
        
        
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