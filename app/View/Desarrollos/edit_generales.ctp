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

<style>
    .card, .card-header {
        border-radius: 5px !important;
    }

    .card:hover {
        box-shadow: none !important;
    }

    .file-caption {
        height: 29px !important;
    }
    .fa-minus::before{
        content: 'minimizar' !important;
        text-transform: none !important;
    }
    .fa-maximus::before{
        content: 'expandir' !important;
        text-transform: none !important;
    }

</style>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-building"></i>Subir Desarrollo</h4>
            </div>
        </div>
    </header>
    
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <?php echo $this->Form->create('Desarrollo', array('class'=>'form-horizontal login_validator'));?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="card mt-2">
                                <div id="rootwizard">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item m-t-15">
                                        <a class="nav-link active" href="#tab1" data-toggle="tab">
                                            <span class="userprofile_tab1">1</span>Datos Generales</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">2</span>Entorno, Amenidades y Servicios',
                                                    array(
                                                        'controller'=>'desarrollos',
                                                        'action'=>'amenidades',
                                                        $desarrollo['Desarrollo']['id']
                                                    ),
                                                    array('class'=>'nav-link','escape'=>false)
                                                )
                                            ?>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">3</span> Multimedia y Documentos',
                                                    array(
                                                        'controller'=>'desarrollos',
                                                        'action'=>'anexos',
                                                        $desarrollo['Desarrollo']['id']
                                                    ),
                                                    array('class'=>'nav-link','escape'=>false)
                                                )
                                            ?>
                                        </li>
                                    </ul>
                                    <div class="card-block m-t-35">
                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                Datos Generales del Desarrollo
                                            </div>

                                            <div class="card-block">
                                                <div class="row">
                                                    <?php echo $this->Form->input('id') ?>
                                                    <?php echo $this->Form->hidden('cuenta_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?> 

                                                    <?php echo $this->Form->hidden('visible',array('name'=>'visible'))?>

                                                    <?php 
                                                        echo $this->Form->input('referencia', array('label'=>array('text'=>'Referencia*','style'=>'font-weight:bold'),'name'=>'referencia','div' => 'form-group col-lg-6','class'=>'form-control'));
                                                    ?>

                                                    <?php
                                                        echo $this->Form->input('nombre', array('label'=>array('text'=>'Nombre de Desarrollo*','style'=>'font-weight:bold'),'name'=>'nombre','div' => 'form-group col-lg-6','class'=>'form-control'));
            					
                                                        echo $this->Form->input('tipo_desarrollo', array('label'=>array('text'=>'Tipo de Desarrollo*','style'=>'font-weight:bold'),'empty'=>'Seleccionar tipo de desarrollo','name'=>'tipo','div' => 'form-group col-lg-6','class'=>'form-control','type'=>'select','options'=>array('Horizontal'=>'Horizontal','Vertical'=>'Vertical'), 'empty'=> 'Selecciona una opción'));

                                                        $tipo_inmuebles = array('Departamentos'=>'Departamentos','Casa Habitación'=>'Casa Habitación','Oficina'=>'Oficina','Mixto'=>'Mixto');
                                                        echo $this->Form->input('tipo_inmuebles', array('label'=>array('text'=>'Tipo de Inmueble / Unidad*','style'=>'font-weight:bold'),'empty'=>'Seleccionar el tipo de inmuebles / unidad','name'=>'tipo_inmuebles','div' => 'form-group col-lg-6','class'=>'form-control','type'=>'select','options'=>$tipo_inmuebles));
                                                        
                                                        echo $this->Form->input('meta_mensual', array('label'=>array('text'=>'Meta de venta mensual*','style'=>'font-weight:bold'),'name'=>'meta_mensual','div' => 'form-group col-lg-6','class'=>'form-control'));

                                                        $etapa_desarrollo = array('Preventa'=>'Preventa','Venta'=>'Venta','Preventa / Venta'=>'Preventa / Venta');
                                                        echo $this->Form->input('etapa_desarrollo', array('id'=>'etapa_desarrollo','onchange'=>'javascript:showPreventa()','label'=>array('text'=>'Etapa de Desarrollo*','style'=>'font-weight:bold'),'empty'=>'Seleccionar la etapa del Desarrollo','name'=>'etapa_desarrollo','div' => 'form-group col-lg-6','class'=>'form-control','type'=>'select','options'=>$etapa_desarrollo));
                                                    ?>
                                                    
                                                    <?php 
                                                        $entrega = ($desarrollo['Desarrollo']['etapa_desarrollo'] != 'Venta' ? "" : "none" ); ?>
                                                        
                                                        <div class="form-group col-xs-6" style="display:<?= $entrega?>" id="showPreventa">
                                                            <label for="DesarrolloInicioPreventa">Inicio Preventa</label>
                                                        <?php echo $this->Form->input('inicio_preventa', array('value'=>date('d-m-Y',  strtotime($desarrollo['Desarrollo']['inicio_preventa'])),'type'=>'text','class'=>'form-control fecha','style'=>'width:100%','label'=>false, 'autocomplete'=>'off'))
                                                        ?>
                                                        </div>

                                                        <script>
                                                            function showPreventa(){
                                                               if(document.getElementById('etapa_desarrollo').value!="Venta"){
                                                                    document.getElementById('showPreventa').style.display="";
                                                                }else{
                                                                    document.getElementById('showPreventa').style.display="none";
                                                                } 
                                                            }    
                                                                
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
                                                    <?php echo $this->Form->input('entrega', array('value'=>$desarrollo['Desarrollo']['entrega'],'id'=>'entrega','onchange'=>'javascript:validarEntrega()','div' => 'form-group col-xs-6','class'=>'form-control','type'=>'select','empty'=>'Seleccionar Entrega','options'=>array('Dar Fecha'=>'Dar Fecha','Inmediata'=>'Inmediata')));?>

                                                    <?php $entrega = ($desarrollo['Desarrollo']['entrega']=='Dar Fecha'?"":"none"); ?>

                            				        <div class="form-group col-xs-6" id="fecha_entrega" style="display:<?= $entrega?>">
                                                        <label for="DesarrolloFechaEntrega">Fecha Entrega</label>
                                                        <?php echo $this->Form->input('fecha_entrega', array('value'=>date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_entrega'])),'type'=>'text','label'=>false,'autocomplete'=>'off','class'=>'form-control fecha','style'=>'width:100%'))?>
                                                    </div>
                                                </div>
                                        
                                                <div class="row">
                                                    <?php echo $this->Form->input('fecha_inicio_obra', array('div' => 'form-group col-xs-6','value'=>$desarrollo['Desarrollo']['fecha_inicio_obra']=="" || $desarrollo['Desarrollo']['fecha_inicio_obra']=="1969-12-31" ? "" : date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_inicio_obra'])),'type'=>'text','label'=>'Fecha de Inicio de Obra','class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>

                                                    <?php echo $this->Form->input('fecha_fin_obra', array('div' => 'form-group col-xs-6','value'=>$desarrollo['Desarrollo']['fecha_fin_obra']=="" || $desarrollo['Desarrollo']['fecha_fin_obra']=="1969-12-31" ? "" : date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_fin_obra'])),'type'=>'text','label'=>'Fecha programada de Finalización de Obra','class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>
                                                </div>

                                                <div class="row">
                                                    <?php echo $this->Form->input('fecha_real_fin_obra', array('div' => 'form-group col-xs-6','value'=>$desarrollo['Desarrollo']['fecha_real_fin_obra']=="" || $desarrollo['Desarrollo']['fecha_real_fin_obra']=="1969-12-31" ? "" :  date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_real_fin_obra'])),'type'=>'text','label'=>'Fecha Real de Finalización de Obra','class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>
                                                    <?php echo $this->Form->input('fecha_inicio_escrituracion', array('div' => 'form-group col-xs-6','value'=>$desarrollo['Desarrollo']['fecha_inicio_escrituracion']=="" || $desarrollo['Desarrollo']['fecha_inicio_escrituracion']=="1969-12-31" ? "" : date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_inicio_escrituracion'])),'type'=>'text','label'=>'Fecha de Inicio de Escrituración','class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>
                                                </div>

                                                <div class="row">
                                                    <?php echo $this->Form->input('fecha_comercializacion', array('div' => 'form-group col-xs-6','value'=>$desarrollo['Desarrollo']['fecha_comercializacion']=="" || $desarrollo['Desarrollo']['fecha_comercializacion']=="1969-12-31" ? "" : date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_comercializacion'])),'type'=>'text','label'=>'Fecha de comercialización','class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>

                                                    <?php echo $this->Form->input('porcentaje_construccion', array('div' => 'form-group col-xs-6','value'=> $desarrollo['Desarrollo']['porcentaje_construccion'] ,'type'=>'text','label'=>'% De construcción','class'=>'form-control','style'=>'width:100%'))?>
                                                    
                                                </div>
                                        
                                                <div class="row">
                                                    <?php echo $this->Form->input('niveles_desarrollo', array('div' => 'form-group col-md-6','class'=>'form-control'));?>
                                                    <?php echo $this->Form->input('unidades_totales', array('div' => 'form-group col-md-6','class'=>'form-control'));?>
                                                    <?php echo $this->Form->input('torres', array('div' => 'form-group col-xs-6','class'=>'form-control'));?>
                                                    <?php echo $this->Form->input('disponibilidad', array('div' => 'form-group col-xs-6','class'=>'form-control'));?>
                                                </div>

                                                <div class="row">
                                                    <?php 
                                                        $exclusividad = array('Si'=>'Si','No'=>'No');
                                                        echo $this->Form->input('exclusividad', array('label'=>'Exclusiva','default'=>'No','id'=>'exclusividad','onchange'=>'javascript:showExclusiva()','div' => 'form-group col-xs-6','class'=>'form-control','type'=>'select','options'=>$exclusividad));
                                                    ?>
                                                    <script>
                                                        function showExclusiva(){
                                                            if(document.getElementById('exclusividad').value=="Si"){
                                                                document.getElementById('fecha_exclusiva').style.display="";
                                                                document.getElementById('fecha_vencimiento').style.display="";
                                                            }else{
                                                                document.getElementById('fecha_exclusiva').style.display="none";
                                                                document.getElementById('fecha_vencimiento').style.display="none";
                                                            }
                                                        }
                                                    </script>
                                                    <?php $entrega = ($desarrollo['Desarrollo']['exclusividad']=='Si'?"":"none"); ?>
                                                    <div>
                                                        <div class="form-group col-xs-3" id="fecha_exclusiva" style="display:<?= $entrega?>">
                                                            <label for="DesarrolloFechaExclusividad">Fecha Inicio Exclusiva</label>
                                                            <?php echo $this->Form->input('fecha_inicio_exclusiva', array('value'=>date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_inicio_exclusiva'])),'type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>
                                                        </div>
                                                        <div class="form-group col-xs-3" id="fecha_vencimiento" style="display:<?= $entrega?>">
                                                            <label for="DesarrolloFechaExclusividad">Fecha Vencimiento Exclusiva</label>
                                                            <?php echo $this->Form->input('fecha_exclusiva', array('value'=>date('d-m-Y',  strtotime($desarrollo['Desarrollo']['fecha_exclusiva'])),'type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%','autocomplete'=>'off'))?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6" id="comision">
                                                        <label for="InmueblePorcentajeCompartir">Comisión</label>
                                                        <div class="input-group">
                                                            <input value = "<?= $desarrollo['Desarrollo']['comision']?>" class="form-control" type="text"  name="data[Desarrollo][comision]" data-mask="" >
                                                            <span class="input-group-addon">%</span>
                                                        </div>
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

                                                    <?php echo $this->Form->input('compartir', array('id'=>'compartir','onchange'=>'javascript:validarCompartir()','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Se puede compartir inmueble?'))?>
                                                    <?php $entrega = ($desarrollo['Desarrollo']['compartir']=='1'?"":"none"); ?>
                                                    <div class="form-group col-md-6" id="porcentaje" style="display:<?= $entrega?>">
                                                        <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                        <div class="input-group">
                                                            <input value = "<?= $desarrollo['Desarrollo']['porcentaje_compartir']?>" class="form-control" type="text"   name="data[Desarrollo][porcentaje_compartir]" data-mask="" >
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <?php
                                                        echo $this->Form->input('departamento_muestra', array('div' => 'form-group col-xs-6','class'=>'form-control','type'=>'select','options'=>array(1=>'Si',2=>'No'), 'empty'=>'Seleciona una opción'));

        					                            echo $this->Form->input('horario_contacto', array('div' => 'form-group col-xs-6','class'=>'form-control'));
                                                    ?>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-xs-12">
                                                        <h3><font color="black">Descripción de Propiedad</h3>
                                                        <textarea name="data[Desarrollo][descripcion]" id="DesarrolloDescripcion" class="summernote_editor" placeholder="Escribir descripción"><?php echo $desarrollo['Desarrollo']['descripcion'] ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <div class="card-header bg-blue-is">
                                                Ubicación del desarrollo
                                            </div>

                                            <div class="card-block">
                                                <div class="row">
                                                    <?php

                                                        echo $this->Form->input('cp', array('name'=>'cp','div' => 'form-group col-xs-3','class'=>'form-control','label'=>array('text'=>'Código Postal*','style'=>'font-weight:bold'),'required' => true,'type' => 'text','maxlength' => '5','onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 'onkeyup'=>'find_cp()'));

                                                        echo $this->Form->input('estado', array('name'=>'estado','div' => 'form-group col-xs-3','class'=>'form-control chzn-select','label'=>array('text'=>'Estado*','style'=>'font-weight:bold'),'type'=>'select'));

                                                        echo $this->Form->input('delegacion', array('name'=>'delegacion','div' => 'form-group col-xs-3','class'=>'form-control chzn-select','label'=>array('text'=>'Delegación/Municipio*','style'=>'font-weight:bold'), 'type'=>'select'));

                                                        echo $this->Form->input('colonia', array('name'=>'colonia','div' => 'form-group col-xs-3','class'=>'form-control chzn-select','label'=>array('text'=>'Colonia*','style'=>'font-weight:bold'),'type'=>'select'));
                                                    ?>
                                                </div>

                                                <div class="row">
                                                    <?php
                                                        echo $this->Form->input('calle', array('name'=>'calle','div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>array('text'=>'Calle*','style'=>'font-weight:bold')));

                                                        echo $this->Form->input('numero_ext', array('name'=>'numero_ext','div' => 'form-group col-sm-12 col-lg-3','class'=>'form-control','label'=>array('text'=>'Número Exterior*','style'=>'font-weight:bold')));
                                                    ?>
                                                </div>

                                                <div class="row">
                                                <?php
                                                    echo $this->Form->input('entre_calles', array('div' => 'form-group col-xs-6','class'=>'form-control','label'=>'Entre Calles'));

                            						echo $this->Form->input('google_maps', array('div' => 'form-group col-xs-6','class'=>'form-control','label'=>'Coordenadas Google Maps'));
                                                    echo $this->Form->hidden('ciudad');
                                                    echo $this->Form->hidden('return');
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions form-group row m-t-20">
                                            <div class="form-group col-xl-6">
                                                <input type="submit" value="Guardar Información y salir" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=1">
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <input type="submit" value="Guardar Información e ir al siguiente paso" class="btn btn-success" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=2">
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
    </div>
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
            referencia: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria una referencia del desarrollo'
                    }
                }
            },
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria un nombre para el desarrollo'
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
            tipo_inmuebles: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar el tipo de inmuebles'
                    }
                }
            },
            etapa_desarrollo: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar la etapa en la que se encuentra el Desarrollo'
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
    $(".percent").inputmask("9.9%");
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
        height:200,
        toolbar:[
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
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

<script>

this.default_input_select('<?= empty($this->request->data['Desarrollo']['estado']) ? '' : $this->request->data['Desarrollo']['estado'] ?>', $("#DesarrolloEstado"));
this.default_input_select('<?= empty($this->request->data['Desarrollo']['colonia']) ? '' : $this->request->data['Desarrollo']['colonia'] ?>', $("#DesarrolloColonia"));
/*this.default_input_select('<?= empty($this->request->data['Desarrollo']['ciudad']) ? '' : $this->request->data['Desarrollo']['ciudad'] ?>', $("#DesarrolloCiudad"));*/
this.default_input_select('<?= empty($this->request->data['Desarrollo']['delegacion']) ? '' : $this->request->data['Desarrollo']['delegacion'] ?>', $("#DesarrolloDelegacion"));

function default_input_select( value, idInput ){
    $('<option>').val('').text('select');
    $('<option>').val(value).text(value).appendTo(idInput);
    $('.chzn-select').trigger('chosen:updated');
}

function find_cp() {

    /*var cpD=$("#DesarrolloCp").val();
    console.log(cpD);*/

    if( $("#DesarrolloCp").val().length >= 5 ){

        this.clear_select(document.getElementById("DesarrolloEstado"));
        //this.clear_select(document.getElementById("DesarrolloCiudad"));
        this.clear_select(document.getElementById("DesarrolloDelegacion"));
        this.clear_select(document.getElementById("DesarrolloColonia"));

        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_estados")); ?>', $("#DesarrolloEstado"), 'ECC-C-001');
        /*this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_ciudad")); ?>', $("#DesarrolloCiudad"), 'ECC-C-003');*/
        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_delegacion")); ?>', $("#DesarrolloDelegacion"), 'ECC-C-004');
        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_colonias")); ?>', $("#DesarrolloColonia"), 'CC-C-002');
        $("#DesarrolloCalle").focus();
    }
}

function send_ajax( url, idInput, codigoError){

    $.ajax({
        type: "POST",
        url,
        cache: false,
        data: { cp: $('#DesarrolloCp').val() },
        dataType: 'json',
        success: function ( response ) {
            $.each(response, function(key, value) {
                $('<option>').val('').text('select');
                $('<option>').val(key).text(value).appendTo(idInput);
                $('.chzn-select').trigger('chosen:updated');
            });
        },
        error: function ( response ) {
            $("#modal_success").modal('show');
            document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar buscar el CP <br>Código: '+codigoError;
        }
    });

}

function clear_select( id ){
    let length = id.options.length;
    for (i = length-1; i >= 0; i--) {
        id.options[i] = null;
    }
    $('.chzn-select').trigger('chosen:updated');
}

</script>