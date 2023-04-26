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
                        <h4 class="nav_top_align"><i class="fa fa-th"></i> Cargar Propiedad</h4>
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
                                                <a class="nav-link active" href="#" data-toggle="tab" style="pointer-events: none">
                                                    <span class="userprofile_tab2">1</span>Datos Generales</a>
                                                </li>
                                                
                                            <li class="nav-item m-t-15">
                                                <?= $this->Html->link(
                                                        '<span class="userprofile_tab1 tab_clr">2</span>Características</a>',
                                                        array(
                                                            'controller'=>'inmuebles',
                                                            'action'=>'caracteristicas',
                                                            $inmueble['Inmueble']['id']
                                                            ),
                                                        array(
                                                            'escape'=>false, 'class'=>'nav-link'
                                                            )
                                                        )?>
                                            </li>
                                            
                                            <li class="nav-item m-t-15">
                                                <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">3</span>Archivos Multimedia</a>',
                                                    array(
                                                        'controller'=>'inmuebles',
                                                        'action'=>'anexos',
                                                        $inmueble['Inmueble']['id']
                                                        ),
                                                    array(
                                                        'escape'=>false, 'class'=>'nav-link'
                                                        )
                                                )?>
                                            </li>
                                            
                                        </ul>
                                        <div class="card-block m-t-35">
                                            

                                            <div class="row">
                                                
                                                <h3><font color="black">Datos del propietario</font></h3>
                                                <hr>
                                                <?php echo $this->Form->input('nombre_cliente', array('name'=>'nombre_cliente','div' => 'form-group form-group col-md-12','class'=>'form-control','label'=>'Nombre Completo', 'required' => true))?>
                                                
                                                <?php echo $this->Form->input('telefono1', array('name'=>'telefono1','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Teléfono 1', 'type' => 'tel', 'maxlength' => 10, 'required' => true))?>
                                                
                                                <?php echo $this->Form->input('telefono2', array('div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Teléfono 2', 'type' => 'tel', 'maxlength' => 10))?>
                                                
                                                <?php echo $this->Form->input('correo_electronico', array('name'=>'correo_electronico','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Correo electrónico', 'type' => 'email', 'required' => true))?>
                                                
                                            </div>




                                        <div class="row mt-1">
                                            <h3><font color="black">Información General</font></h3>
                                            <hr>
                                                <?= $this->Form->input('id',array('value'=>$inmueble['Inmueble']['id']))?>
                                                <?php echo $this->Form->hidden('cuenta_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                <?php
                                                    $exclusiva = array('Exclusiva'=>'Exclusiva', 'Externo'=>'Externo','Sin Exclusiva'=>'Sin Exclusiva');
                                                    $venta = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
                                                ?>
                                                <?php
                                                    echo $this->Form->input('referencia', array('label'=>array('text'=>'Referencia*','style'=>'font-weight:bold'),'name'=>'referencia','class'=>'form-control required','div' => 'form-group col-xl-6','required'=>false));
                                                    
                                                    echo $this->Form->input('titulo', array('label'=>array('text'=>'Nombre de la Propiedad*','style'=>'font-weight:bold'),'name'=>'titulo','class'=>'form-control','div' => 'form-group col-xl-6'));
                                                    
                                                    echo $this->Form->input('dic_tipo_propiedad_id', array('label'=>array('text'=>'Tipo de Inmueble*','style'=>'font-weight:bold'),'name'=>'tipo_propiedad','div' => 'form-group col-xl-6','class'=>'form-control','type'=>'select','options'=>$tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad'));
                                                    
                                                    echo $this->Form->input('premium', array('class'=>'form-control','div' => 'form-group col-xl-6','type'=>'select','options'=>array('No','Si')));
                                                    
                                                    echo $this->Form->input('exclusiva', array('label'=>array('text'=>'Exclusiva*','style'=>'font-weight:bold'),'id'=>'exclusiva','onchange'=>'javascript:showExclusiva()','name'=>'exclusiva','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$exclusiva,'empty'=>'Selecciona exclusiva'));    
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
                                                        <?php $showExc = ($inmueble['Inmueble']['exclusiva']=="Exclusiva" ? "":"none")?>
                                                         <div class="col-xs-3" id="fecha_exclusiva" style="display:<?= $showExc?>">
                                                            <label for="DesarrolloFechaExclusividad">Fecha Inicio Exclusiva</label>
                                                            <?php echo $this->Form->input('fecha_inicio_exclusiva', array('value' => $inmueble['Inmueble']['fecha_inicio_exclusiva'],'type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%'))?>
                                                        </div>
                                                        <div class="col-xs-3" id="fecha_exclusiva2" style="display:<?= $showExc?>">
                                                            <label for="DesarrolloFechaExclusividad">Fecha Vencimiento Exclusiva</label>
                                                            <?php echo $this->Form->input('due_date', array('value' => $inmueble['Inmueble']['due_date'],'type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%'))?>
                                                        </div>
                                                    
                                            </div>
                                            <div class="row">

                                                    <?php 
                                                        
                                                        $showVenta = ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"? "":"none");

                                                        $showRenta = ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"? "":"none");

                                                        $showCompartir = ($inmueble['Inmueble']['compartir']==1 ? "":"none");
                                                        echo $this->Form->hidden('cambio_precio',array('value'=>0));

                                                    ?>
                                                    <?php echo $this->Form->input('venta_renta', array('label'=>array('text'=>'Tipo de Operación*','style'=>'font-weight:bold'),'onchange'=>'javascript:showPrecio()','name'=>'venta','id'=>'rv','div' => 'form-group col-xl-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta'));?>
                                                    
                                                    <div class="form-group col-md-3" style="display:<?= $showVenta?>" id="precio1">
                                                        <label for="InmueblePrecio">Precio Venta</label>
                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            
                                                            <input onchange="javascript:document.getElementById('InmuebleCambioPrecio').value=1" name="data[Inmueble][precio]" value = "<?= $inmueble['Inmueble']['precio']?>" class="form-control" id="currency" aria-label="Amount (rounded to the nearest dollar)" type="number" min=0>

                                                        </div>

                                                        <?= $this->Form->hidden('precio_inicial', array('value'=> $inmueble['Inmueble']['precio'])) ?>
                                                        
                                                    </div>

                                                    <div class="form-group col-md-3" style="display:<?= $showRenta?>" id="precio2">
                                                        <label for="InmueblePrecio2">Precio Renta</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            <input onchange="javascript:document.getElementById('InmuebleCambioPrecio').value=1" type="number" name="data[Inmueble][precio_2]" value = "<?= $inmueble['Inmueble']['precio_2']?>"class="form-control" id="currency" aria-label="Amount (rounded to the nearest dollar)" min=0>
                                                        </div>
                                                    </div>
                                        </div>
                                                <div class="row">
                                                        <div class="form-group col-md-3">
                                                        <label for="InmuebleComision">Comisión</label>
                                                        <div class="input-group">
                                                            
                                                            <input class="form-control" name="data[Inmueble][comision]" value = "<?= $inmueble['Inmueble']['comision']?>"type="number" id="comision" step=".01">
                                                            <span class="input-group-addon">%</span>
                                                            
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
                                                    <div class="form-group col-md-3" id="porcentaje" style="display:<?= $showCompartir?>">
                                                        <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                        <div class="input-group">
                                                            <input class="form-control" type="number"  id="percent"   value = "<?= $inmueble['Inmueble']['porcentaje_compartir']?>" name="data[Inmueble][porcentaje_compartir]" min="0" step=".01">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    
                                                    
                                        <?php    
                                            
                                            echo $this->Form->input('cita', array('div' => 'form-group col-md-6','class'=>'form-control','label'=>'Horario de Contacto', 'type' => 'text'));
                                            
                                            echo $this->Form->input('opcionador_id', array('empty'=>'Seleccionar Opcionador','div' => 'form-group col-md-6','class'=>'form-control','options'=>$opcionadors));
                                            
                                            echo $this->Form->hidden('return');

                                        ?>
                                                    <div class="col-sm-12">
                                                        Descripción de la propiedad
                                                        <small>Datos generales</small>
                                                        <textarea name="data[Inmueble][comentarios]" id="InmuebleComentarios" class="summernote_editor"
                                                            placeholder="Escribir descripción"><?= $inmueble['Inmueble']['comentarios']?></textarea>
                                                                
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12 mt-1">
                                                            <h3><font color="black">Ubicación del desarrollo</font></h3>
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="row col-sm-12 mt-1">
                                                        <?php echo $this->Form->input('calle', array('name'=>'calle','div' => 'col-lg-6 col-sm-12','class'=>'form-control','label'=>'Calle*', 'type' => 'text', 'required' => true))?>

                                                        <?php echo $this->Form->input('numero_exterior', array('name'=>'numero_ext','div' => 'form-group col-sm12 col-lg-6','class'=>'form-control','label'=>'Número Exterior*', 'type' => 'text', 'required' => true))?>
                                                    </div>

                                                    <div class="row col-sm-12">
                                                        
                                                        <?php echo $this->Form->input('colonia', array('name'=>'colonia','div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Colonia*', 'type' => 'text', 'required' => true))?>
                                                        
                                                        <?php echo $this->Form->input('delegacion', array('name'=>'delegacion','div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Delegación*', 'type' => 'text', 'required' => true))?>

                                                    </div>

                                                    <div class="row col-sm-12">
                                                        
                                                        <?php echo $this->Form->input('cp', array('name'=>'cp','div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Código Postal*', 'required' => true ))?>
                                                        
                                                        <?php echo $this->Form->input('ciudad', array('name'=>'ciudad','div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Ciudad*', 'type' => 'text', 'required' => true))?>

                                                    </div>

                                                    <div class="row col-sm-12">
                                                        
                                                        <?php echo $this->Form->input('estado_ubicacion', array('name'=>'estado_ubicacion','div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Estado', 'type'=>'select', 'options' => $estados))?>

                                                        <?php echo $this->Form->input('entre_calles', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Entre calles', 'type' => 'text'))?>

                                                    </div>

                                                    <div class="row col-sm-12">
                                                        
                                                        <?php echo $this->Form->input('google_maps', array('div' => 'form-group col-lg-6 col-sm-12','class'=>'form-control','label'=>'Coordenadas Google Maps'))?>
                                                        
                                                    </div>

                                                    
                                                </div>
                                                <div class="form-actions form-group row m-t-20">
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Guardar y salir" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('InmuebleReturn').value=1">
                                                </div>
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Continuar" class="btn btn-success" style="width:100%" onclick="javascript:document.getElementById('InmuebleReturn').value=2">
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

'use strict';
$(document).ready(function() {
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
    $('#InmuebleAddForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            referencia: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria una referencia.'
                    }
                }
            },
            titulo: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario un título.'
                    }
                }
            },
             tipo_propiedad: {
                validators: {
                    notEmpty: {
                        message: 'Seleccionar un tipo de propiedad'
                    }                  
                }
            },
            due_date: {
                validators: {
                    notEmpty: {
                        message: 'Favor de poner una fecha de vencimiento'
                    }
                  
                }
            },
            exclusiva: {
                validators: {
                    notEmpty: {
                        message: 'Selecciona si es Exclusiva'
                    }
                }
            },
            venta: {
                validators: {
                    notEmpty: {
                        message: 'Selecciona el tipo de operación'
                    }
                }                
            },
            precio: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario un precio para la propiedad'
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
            construccion: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario los metros que componen la construcción'
                    }
                }
            },
            recamaras: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el número de recámaras / habitaciones de la propiedad'
                    }
                }
            },
            banios: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el número de baños de la propiedad'
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
            estado_ubicacion: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el estado de la propiedad'
                    }
                }
            },
            nombre_cliente: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el nombre del cliente'
                    }
                }
            },
            apellido_paterno: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el apellido paterno'
                    }
                }
            },
            telefono1: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el teléfono del cliente'
                    }
                }
            },
            correo_electronico: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario el correo electrónico del cliente'
                    }
                }
            },
            terreno: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la medidad del terreno de la propiedad'
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
    $(".percent").inputmask("99.9");
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
    
    $('.summernote_editor').summernote({
        height:200,
        toolbar:[
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });
    
});


</script>
