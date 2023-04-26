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
            '/vendors/datepicker/css/bootstrap-datepicker3',

            // Css para tabla de datos pontchAut 

            ),
        array('inline'=>false))
        
?>
<?php $condicion = array('1'=>'Si', '0'=>'No'); ?>
<style>
    iframe{width: 100%; height: 100vh;}
    .ifrmae_inmueble {height: 100vh; overflow: scroll;}
</style>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-desktop"></i> Publicar inmueble en portal</h4>
            </div>
            
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="card">
              <div class="row">
                <div class="card-block m-t-20">
                    <!-- <pre>
                        <?php
                            print_r($inmueble);
                        ?>
                    </pre> -->
                    <?php if ($layout == 1): ?>
                    
                      <div class="col-lg-6 ifrmae_inmueble">
                            <div id="rootwizard">
                                <ul class="nav nav-pills">
                                    <li class="nav-item m-t-15">
                                    <a class="nav-link active" href="#tab1" data-toggle="tab" id="a1">
                                        <span class="userprofile_tab1">1</span>Elige que quieres publicar</a>
                                    </li>
                                    <li class="nav-item m-t-15">
                                        <a class="nav-link" href="#tab2" data-toggle="tab" style="pointer-events: none" id="a2">
                                            <span class="userprofile_tab2">2</span>Descripcion tu inmueble</a>
                                    </li>
                                    <li class="nav-item m-t-15">
                                        <a class="nav-link" href="#tab3" data-toggle="tab" style="pointer-events: none" id="a3">
                                            <span>3</span>Precio del Inmueble
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item m-t-15">
                                        <a class="nav-link" href="#tab4" data-toggle="tab" style="pointer-events: none" id="a4">
                                            <span>4</span>Confirma tu publicación
                                        </a>
                                    </li> -->
                                </ul>
                                <div class="tab-content m-t-40">
                                    <div class="tab-pane active" id="tab1">
                                        <table class="table">
                                            <tr>
                                                <td>Tipo propiedad</td>
                                                <td><span><?= $tipo_propiedad[$inmueble['Inmueble']['dic_tipo_propiedad_id']] ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>Venta/Renta</td>
                                                <td><span><?= $inmueble['Inmueble']['venta_renta'] ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>Venta/Renta</td>
                                                <td><span><?= $inmueble['Inmueble']['exclusiva'] ?></span></td>
                                            </tr>
                                        </table>
                                        <ul class="pager wizard pager_a_cursor_pointer">
                                            <li id="siguiente1"><a>Siguiente</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane m-t-40" id="tab2">
                                        <div class="row">
                                            <?php foreach ($inmueble['FotoInmueble'] as $fotos): ?>
                                                <div class="col-sm-12 col-xl-4 gallery-border">
                                                    <?= $this->Html->image($fotos['ruta'], array('class'=>'img-fluid')); ?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                        <div class="m-t-40">
                                            <!-- Ubicación del inmueble -->
                                            <h5 style="color: #000;">Ubicación de tu inmueble</h5>
                                            <table class="table">
                                                <tr>
                                                    <td>Estado</td>
                                                    <td><span><?= $inmueble['Inmueble']['estado_ubicacion'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Municipio</td>
                                                    <td><span><?= $inmueble['Inmueble']['delegacion'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Colonia</td>
                                                    <td><span><?= $inmueble['Inmueble']['colonia'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Calle</td>
                                                    <td><span><?= $inmueble['Inmueble']['calle'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Número exterior</td>
                                                    <td><span><?= $inmueble['Inmueble']['numero_exterior'] ?></span></td>
                                                </tr>
                                            </table>
                                            <!-- Datos de contacto -->
                                            <h5 style="color: #000;">Datos de contacto</h5>
                                            <table class="table">
                                                <tr>
                                                    <td>Teléfono</td>
                                                    <td><span><?= $inmueble['Inmueble']['telefono1'] ?></span></td>
                                                </tr>
                                            </table>
                                            <!-- Describe tu inmueble -->
                                            <h5 style="color: #000;">Describe tu inmueble</h5>
                                            <table class="table">
                                                <tr>
                                                    <td>Superficie de construcción</td>
                                                    <td><span><?= $inmueble['Inmueble']['construccion'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Recámaras</td>
                                                    <td><span><?= $inmueble['Inmueble']['recamaras'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Baños</td>
                                                    <td><span><?= $inmueble['Inmueble']['banos'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Estacionamientos</td>
                                                    <?php $estacionamiento_total =  $inmueble['Inmueble']['estacionamiento_techado'] + $inmueble['Inmueble']['estacionamiento_descubierto']?>
                                                    <td><span><?= $estacionamiento_total ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Horario de contacto</td>
                                                    <td><span></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Superficie de terreno</td>
                                                    <td><span><?= $inmueble['Inmueble']['terreno'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Bodegas</td>
                                                    <td><span><?= $inmueble['Inmueble']['bodega'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Pisos</td>
                                                    <td><span><?= $inmueble['Inmueble']['nivel_propiedad'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Departamentos por piso</td>
                                                    <td><span><?= $inmueble['Inmueble']['unidades_totales'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Piso (unidad)</td>
                                                    <td><span><?= $inmueble['Inmueble']['niveles_totales'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Disposición</td>
                                                    <td><span></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Orientación</td>
                                                    <td><span></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Antigüedad</td>
                                                    <td><span><?= $inmueble['Inmueble']['edad'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Cuota mensual de mantenimiento</td>
                                                    <td><span><?= $inmueble['Inmueble']['mantenimiento'] ?></span></td>
                                                </tr>
                                            </table>
                                            <!-- Describe tu inmueble -->
                                            <h5 style="color: #000;">Comodidades y amenities</h5>
                                            <table class="table">
                                                <tr>
                                                    <td>Acceso a internet</td>
                                                    <td><span><?= $condicion[0] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Aire acondicionado</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['aire_acondicionado']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Calefacción</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['calefaccion']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Chimenea</td>
                                                    <td><span>No definida</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Cisterna</td>
                                                    <?php if (!empty($inmueble['Inmueble']['cisterna'])) { $c = 1; }else{ $c = 0; } ?>
                                                    <td><span><?= $condicion[$c] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jacuzzi</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['jacuzzi']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Área de cine</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Área de juegos infantiles</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['area_juegos']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Ascensor</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['elevador']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Business center</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['salon_multiple']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Cancha de tenis</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['cancha_tenis']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Estacionamiento para visitantes</td>
                                                    <td><span>No definido</span></td>
                                                    <!-- <td><span><?= $condicion[$inmueble['Inmueble']['cancha_tenis']] ?></span></td> -->
                                                </tr>
                                                <tr>
                                                    <td>Gimnasio</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['gimnasio']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Laundry</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Asador</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['asador']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Alberca</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['alberca']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Salón de fiestas</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Salón de usos múltiples</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['salon_multiple']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Seguridad</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['sistema_seguridad']] ?></span></td>
                                                </tr>

                                            </table>

                                            <h5 style="color: #000;">Características adicionales</h5>
                                            <table class="table">
                                                <tr>
                                                    <td>Agua corriente</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Boiler</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Gas natural</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Línea telefónica</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Uso de suelo</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                            </table>

                                            <h5 style="color: #000;">Ambientes</h5>
                                            <table class="table">
                                                <tr>
                                                    <td>Balcón</td>
                                                    <?php if (!empty($inmueble['Inmueble']['balcon'])) { $b = 1; }else{ $b = 0; } ?>
                                                    <td><span><?= $condicion[$b] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Cocina</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['cocina_integral']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Sala comedor</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['desayunador_antecomedor']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Cuarto de servicio</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['cuarto_servicio']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Desayunador</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['desayunador_antecomedor']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Dormitorio en suite</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Estudio</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['estudio']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jardín</td>
                                                    <?php if (!empty($inmueble['Inmueble']['jardin_comun'])) { $j = 1; }else{ $j = 0; } ?>
                                                    <td><span><?= $condicion[$j] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Cuarto de lavado</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['closet_blancos']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Living</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Patio</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['patio_servicio']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Closets</td>
                                                    <?php if (!empty($inmueble['Inmueble']['closets'])) { $cl = 1; }else{ $cl = 0; } ?>
                                                    <td><span><?= $condicion[$cl] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Terraza</td>
                                                    <?php if (!empty($inmueble['Inmueble']['terraza'])) { $ta = 1; }else{ $ta = 0; } ?>
                                                    <td><span><?= $condicion[$ta] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Medio baño</td>
                                                    <td><span>No definido</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Vestidor</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['vestidores']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Playroom</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['salon_juegos']] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Roof garden</td>
                                                    <td><span><?= $condicion[$inmueble['Inmueble']['roof_garden']] ?></span></td>
                                                </tr>
                                            </table>
                                            <p>Titulo: <?= $inmueble['Inmueble']['titulo'] ?></p>
                                            <p>Descripción: <?= $inmueble['Inmueble']['comentarios'] ?></p>




                                            <ul class="pager wizard pager_a_cursor_pointer">
                                                <li id="anterior1"><a>Anterior</a></li>
                                                <li id="siguiente2"><a>Siguiente</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab3">
                                        <h3 style="color: #000;">Precio</h3>
                                        <p><?= $inmueble['Inmueble']['precio'] ?></p>
                                        <ul class="pager wizard pager_a_cursor_pointer">
                                            <li id="anterior2"><a>Anterior</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Iframe -->
                        <div class="col-sm-12 col-lg-6">
                            <iframe src="https://syi.metroscubicos.com/sell/sell?execution=e1s1" frameborder="0"></iframe>
                        </div>
                        <?php elseif($layout == 2): ?>
                            <div class="col-sm-12 col-lg-6 ifrmae_inmueble">
                                <h1 style="color: #000;">inmuebles24</h1>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <iframe src="http://www.inmuebles24.com/" frameborder="0"></iframe>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-12 col-lg-6 ifrmae_inmueble">
                                <h1 style="color: #000;">Lamudi</h1>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <iframe src="https://www.lamudi.com.mx/" frameborder="0"></iframe>
                            </div>
                        <?php endif; ?>




                </div>
            </div>
        </div>
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
    $('#siguiente1').on('click', function(){
        // alert('Funcion');
        $('#a1').removeClass('active');
        $('#tab1').removeClass('active');

        $('#a2').addClass('active');
        $('#tab2').addClass('active');
    });

    $('#anterior1').on('click', function(){
        // alert('Funcion');
        $('#a1').addClass('active');
        $('#tab1').addClass('active');

        $('#a2').removeClass('active');
        $('#tab2').removeClass('active');
    });


    $('#siguiente2').on('click', function(){
        // alert('Funcion');
        $('#a2').removeClass('active');
        $('#tab2').removeClass('active');

        $('#a3').addClass('active');
        $('#tab3').addClass('active');
    });

    $('#anterior2').on('click', function(){
        // alert('Funcion');
        $('#a2').addClass('active');
        $('#tab2').addClass('active');

        $('#a3').removeClass('active');
        $('#tab3').removeClass('active');
    });


});


<?php 
    $this->Html->scriptEnd();
?>