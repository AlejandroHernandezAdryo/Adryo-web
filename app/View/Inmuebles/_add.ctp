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
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Cargar Propiedad</h4>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                        <?php echo $this->Form->create('Inmueble', array('type'=>'file','class'=>'form-horizontal login_validator'));?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block m-t-20">
                                    <div id="rootwizard">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item m-t-15">
                                            <a class="nav-link active" href="#tab1" data-toggle="tab">
                                                <span class="userprofile_tab1">1</span>Datos Generales</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#" data-toggle="tab" style="pointer-events: none">
                                                    <span class="userprofile_tab2">2</span>Características</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#"
                                                   data-toggle="tab" style="pointer-events: none"><span>3</span>Archivos Multimedia</a>
                                            </li>
                                        </ul>
                                        <div class="card-block m-t-35">


                                            <div class="row">
                                                
                                                <h3><font color="black">Datos del propietario</font></h3>
                                                <hr>
                                                <?php echo $this->Form->input('nombre_cliente', array('div' => 'form-group form-group col-md-12','class'=>'form-control','label'=>array('text' => 'Nombre Completo*', 'class' => 'required'), 'required' => true, 'type' => 'text'))?>
                                                
                                                <?php echo $this->Form->input('telefono1', array('div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Teléfono 1', 'type' => 'tel', 'maxlength' => 10))?>
                                                
                                                <?php echo $this->Form->input('telefono2', array('div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Teléfono 2', 'type' => 'tel', 'maxlength' => 10))?>
                                                
                                                <?php echo $this->Form->input('correo_electronico', array('div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Correo electrónico', 'type' => 'email'))?>
                                                
                                            </div>

                                            <div class="row mt-1">
                                                <h3><font color="black">Información General</font></h3>
                                                <hr>
                                                <?php echo $this->Form->hidden('cuenta_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                <?php
                                                    $exclusiva = array('Exclusiva'=>'Exclusiva', 'Externo'=>'Externo','Sin Exclusiva'=>'Sin Exclusiva');
                                                    $venta = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
                                                    
                                                
                                                ?>
                                                    <?php
                                                    echo $this->Form->input('referencia', array('label'=>array('text'=>'Referencia*','style'=>'font-weight:bold'),'class'=>'form-control required','div' => 'form-group col-xl-6','required'=>false));
                                                    echo $this->Form->input('titulo', array('label'=>array('text'=>'Nombre de la Propiedad*','style'=>'font-weight:bold'),'class'=>'form-control','div' => 'form-group col-xl-6'));
                                                    echo $this->Form->input('dic_tipo_propiedad_id', array('label'=>array('text'=>'Tipo de Inmueble*','style'=>'font-weight:bold'),'div' => 'form-group col-xl-6','class'=>'form-control','type'=>'select','options'=>$tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad'));
                                                    
                                                    echo $this->Form->input('premium', array('class'=>'form-control','div' => 'form-group col-xl-6','type'=>'select','options'=>array('No','Si')));
                                                    
                                                    echo $this->Form->input('exclusiva', array('label'=>array('text'=>'Exclusiva*','style'=>'font-weight:bold'),'id'=>'exclusiva','onchange'=>'javascript:showExclusiva()','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$exclusiva,'empty'=>'Selecciona exclusiva'));    
                                                    ?>
                                                    
                                                    <script>
                                                            function showExclusiva(){
                                                                if(document.getElementById('exclusiva').value=="Exclusiva"){
                                                                    document.getElementById('fecha_exclusiva').style.display="";
                                                                    document.getElementById('fecha_exclusiva2').style.display="";
                                                                }else{
                                                                    document.getElementById('fecha_exclusiva').style.display="none";
                                                                    document.getElementById('fecha_exclusiva2').style.display="none";
                                                                }
                                                            }
                                                        </script>
                                                        
                                                         <div class="col-xs-3" id="fecha_exclusiva" style="display:none">
                                                            <label for="DesarrolloFechaExclusividad">Fecha Inicio Exclusiva</label>
                                                            <?php echo $this->Form->input('fecha_inicio_exclusiva', array('type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%', 'autocomplete'=>'off'))?>
                                                        </div>
                                                        <div class="col-xs-3" id="fecha_exclusiva2" style="display:none">
                                                            <label for="DesarrolloFechaExclusividad">Fecha Vencimiento Exclusiva</label>
                                                            <?php echo $this->Form->input('due_date', array('type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%', 'autocomplete'=>'off'))?>
                                                        </div>
                                                    
                                            </div>
                                            <div class="row">
                                                    <?php echo $this->Form->input('venta_renta', array('label'=>array('text'=>'Tipo de Operación*','style'=>'font-weight:bold'),'onchange'=>'showPrecio()','id'=>'rv','div' => 'form-group col-xl-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta'));?>
                                                    <div class="form-group col-md-3" id="precio1">
                                                        <label for="InmueblePrecio">Precio Venta</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            
                                                            <input type="number" name="data[Inmueble][precio]" class="form-control" min="0">

                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3" style="display:none" id="precio2">
                                                        <label for="InmueblePrecio2">Precio Renta</label>
                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            <input type="number" name="data[Inmueble][precio_2]" class="form-control" min="0">
                                                        </div>

                                                    </div>
                                        </div>
                                                <div class="row">
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="InmuebleComision">Comisión</label>
                                                        <div class="input-group">
                                                            <input class="form-control percent" name="data[Inmueble][comision]" type="number" id="comision" min="0" step=".01">
                                                            
                                                        </div>
                                                    </div>

                                                    <?php 
                                                        echo $this->Form->input('compartir', array('onchange'=>'javascript:showPorcentaje()','div' => 'form-group col-md-3','class'=>'form-control','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Se puede compartir inmueble?'));
                                                    ?>
                                                    <script>
                                                        function showPorcentaje(){
                                                           if (document.getElementById('InmuebleCompartir').value === "1"){
                                                            document.getElementById('porcentaje').style.display="";
                                                        }else{
                                                            document.getElementById('porcentaje').style.display="none";
                                                        } 
                                                        }
                                                    </script>
                                                    <div class="form-group col-md-3" id="porcentaje" style="display:none">
                                                        <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                        <div class="input-group">
                                                            <input class="form-control percent" type="number"  id="percent"   name="data[Inmueble][porcentaje_compartir]" min="0" step=".01">
                                                            
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    
                                                    
                                                <?php    
                                                    echo $this->Form->input('cita', array('div' => 'form-group col-md-6','class'=>'form-control','label'=>'Horario de Contacto', 'type' => 'text'));

                                                    echo $this->Form->input('opcionador_id', array('empty'=>'Seleccionar Opcionador','div' => 'form-group col-md-6','class'=>'form-control','options'=>$opcionadors));

                                                ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='summer_note_display summer_note_btn'>
                                                            Descripción de la propiedad
                                                            <small>Datos generales</small>
                                                            <textarea name="data[Inmueble][comentarios]" id="InmuebleComentarios" class="summernote_editor" placeholder="Escribir descripción"></textarea>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-sm-12 mt-3">
                                                        <h3><font color="black">Ubicación del desarrollo</font></h3>
                                                        <hr>
                                                    </div>
                                                </div>
                                                


                                                <div class="row col-sm-12 mt-1">
                                                    <?php echo $this->Form->input('calle', array('div' => 'col-lg-6 col-sm-12','class'=>'form-control','label'=>'Calle*', 'type' => 'text', 'required' => true))?>

                                                    <?php echo $this->Form->input('numero_exterior', array('div' => 'form-group col-sm12 col-lg-6','class'=>'form-control','label'=>'Número Exterior*', 'type' => 'text', 'required' => true))?>
                                                </div>

                                                <div class="row col-sm-12">
                                                    
                                                    <?php echo $this->Form->input('colonia', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Colonia*', 'type' => 'text', 'required' => true))?>
                                                    
                                                    <?php echo $this->Form->input('delegacion', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Delegación*', 'type' => 'text', 'required' => true))?>

                                                </div>

                                                <div class="row col-sm-12">
                                                    
                                                    <?php echo $this->Form->input('cp', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Código Postal*', 'required' => true ))?>
                                                    
                                                    <?php echo $this->Form->input('ciudad', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Ciudad*', 'type' => 'text', 'required' => true))?>

                                                </div>

                                                <div class="row col-sm-12">
                                                    
                                                    <?php echo $this->Form->input('estado_ubicacion', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Estado', 'type'=>'select', 'options' => $estados))?>

                                                    <?php echo $this->Form->input('entre_calles', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Entre calles', 'type' => 'text'))?>

                                                </div>

                                                <div class="row col-sm-12">
                                                    
                                                    <?php echo $this->Form->input('google_maps', array('div' => 'form-group col-lg-6 col-sm-12','class'=>'form-control','label'=>'Coordenadas Google Maps', 'type' => 'text'))?>
                                                    
                                                </div>


                                                <div class="form-actions form-group row">
                                                <div class="col-sm-12 col-lg-6 mt-2">
                                                    <input type="submit" value="Guardar y salir" class="btn btn-warning btn-block">
                                                </div>
                                                <div class="col-sm-12 col-lg-6 mt-2">
                                                    <input type="submit" value="Continuar" class="btn btn-success btn-block">
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

            'components',
            'custom',

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

<script>


function showPrecio(){
    if(document.getElementById('rv').value=="Venta"){
        document.getElementById('precio2').style.display="none";
        document.getElementById('precio1').style.display="";
    }else if(document.getElementById('rv').value=="Renta"){
        document.getElementById('precio1').style.display="none";
        document.getElementById('precio2').style.display="";
    }else {
        document.getElementById('precio1').style.display="block";
        document.getElementById('precio2').style.display="block";
    }
}



    $( "#InmuebleAddForm" ).submit(function( event ) {
        
        console.log('Estamos haciendo submit');
        // $.ajax({
        //     type: "POST",
        //     url: '<?php echo Router::url(array("controller" => "inmuebles", "action" => "save")); ?>',
        //     cache: false,
        //     data : $('#InmuebleAddForm').serialize(),
        //     success: function ( response ) {
        //         console.log( response );
        //     }
        // });
        
        event.preventDefault();
    });

'use strict';
$(document).ready(function() {


// Inicialización de fecha "SaaK"
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });


    
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
    // End of chosen

    // Input mask
    $(".phone").inputmask();
    $("#product").inputmask("a*-999-a999");
    $(".date_mask").inputmask("yyyy-mm-dd");

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



</script>