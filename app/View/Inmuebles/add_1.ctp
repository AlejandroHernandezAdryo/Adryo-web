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
            
            ),
        array('inline'=>false))
        
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Subir Propiedad</h4>
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
                                                <a class="nav-link" href="#tab1" data-toggle="tab">
                                                    <span class="userprofile_tab1">1</span>Datos Generales</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab2" data-toggle="tab">
                                                    <span class="userprofile_tab2">2</span>Datos del Cliente</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab3" data-toggle="tab">
                                                    <span class="userprofile_tab2">3</span>Ubicación del Inmueble</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab4" data-toggle="tab">
                                                    <span class="userprofile_tab2">4</span>Características</a>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link" href="#tab5" data-toggle="tab">
                                                    <span class="userprofile_tab2">5</span>Anexos</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content m-t-20">
                                            <div class="tab-pane" id="tab1">
                                                <?php echo $this->Form->hidden('cuenta_id',array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                <?php
                                                    $exclusiva = array('Exclusiva'=>'Exclusiva', 'Externo'=>'Externo','Sin Exclusiva'=>'Sin Exclusiva');
                                                    $venta = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
                                                    $anuncio = array('No'=>'No', 'Anuncio Chico'=>'Anuncio Chico','Gallardete'=>'Gallardete', 'Lona Chica'=>'Lona Chica', 'Lona Grande' =>'Lona Grande');
                                                    $ubicacion = array('Barda'=>'Barda','Caseta de Vigilacia'=>'Caseta de Vigilacia','Fachada'=>'Fachada', 'Otro'=>'Otro','Ventana'=>'Ventana');
                                                
                                                ?>
                                                <?php
                                                    echo $this->Form->input('referencia', array('name'=>'referencia','class'=>'form-control','div' => 'form-group col-md-6'));
                                                    echo $this->Form->input('titulo', array('name'=>'titulo','class'=>'form-control','div' => 'form-group col-md-6'));
                                                    echo $this->Form->input('premium', array('class'=>'form-control','div' => 'form-group col-md-6','type'=>'select','options'=>array('No','Si')));
                                                    echo $this->Form->input('dic_tipo_propiedad_id', array('label'=>'Tipo de Propiedad','name'=>'tipo_propiedad','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad'));
                                                ?>
                                                <div class="form-group col-md-6">
                                                    <label for="InmuebleFecha">Fecha</label>
                                                    <?php echo $this->Form->date('fecha', array('name'=>'fecha','class'=>'form-control date_mask','style'=>'width:100%'))?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="InmuebleDueDate">Fecha de vencimiento</label>
                                                    <?php echo $this->Form->date('due_date', array('name'=>'due_date','class'=>'form-control date_mask','style'=>'width:100%'))?>
                                                </div>
                                                <?php 
                                                    echo $this->Form->input('exclusiva', array('name'=>'exclusiva','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$exclusiva,'empty'=>'Selecciona exclusiva'));    
                                                    echo $this->Form->input('venta_renta', array('name'=>'venta','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta','label'=>'Renta/Venta'));
                                                    echo $this->Form->input('compartir', array('div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Se puede compartir inmueble?'));
                                                    ?>
                                                    <div class="form-group col-md-6">
                                                        <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                        <div class="input-group">
                                                            <input class="form-control percent" type="text"  id="percent"   name="data[Inmueble][porcentaje_compartir]" data-mask="" >
                                                            <span class="input-group-addon">99.9%</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="InmuebleComision">Comisión</label>
                                                        <div class="input-group">
                                                            <input class="form-control percent" name="data[Inmueble][comision]" type="text" id="comision"   data-mask="" >
                                                            <span class="input-group-addon">99.9%</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="InmueblePrecio">Precio</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            <input type="text" name="precio" class="form-control" id="currency" aria-label="Amount (rounded to the nearest dollar)">
                                                            <span class="input-group-addon">.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="InmueblePrecio2">Precio 2</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            <input type="text" name="data[Inmueble][precio_2]" class="form-control" aria-label="Amount (rounded to the nearest dollar)">
                                                            <span class="input-group-addon">.00</span>
                                                        </div>
                                                    </div>
                                                    
                                                <?php    
                                                echo $this->Form->input('cita', array('div' => 'form-group col-md-6','class'=>'form-control'));
                                                    echo $this->Form->input('opcionador_id', array('empty'=>'Seleccionar Opcionador','div' => 'form-group col-md-6','class'=>'form-control','options'=>$opcionadors));
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
                                                                <textarea name="data[Inmueble][comentarios]" id="InmuebleComentarios" class="textarea form_editors_textarea_wysihtml"
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
                                            <div class="tab-pane" id="tab2">
                                                <?php echo $this->Form->input('nombre_cliente', array('name'=>'nombre_cliente','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Nombres'))?>
                                                <?php echo $this->Form->input('apellido_paterno', array('name'=>'apellido_paterno','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Apellido Paterno'))?>
                                                <?php echo $this->Form->input('apellido_materno', array('div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Apellido Materno'))?>
                                                <?php //echo $this->Form->input('direccion_cliente', array('div' => 'col-md-12','class'=>'form-control','label'=>'Domicilio completo'))?>
                                                <?php echo $this->Form->input('telefono1', array('name'=>'telefono1','div' => 'form-group form-group col-md-4','class'=>'form-control phone','label'=>'Teléfono 1','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                                                <?php echo $this->Form->input('telefono2', array('div' => 'form-group form-group col-md-4','class'=>'form-control phone','label'=>'Teléfono 2','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'))?>
                                                <?php echo $this->Form->input('correo_electronico', array('name'=>'correo_electronico','div' => 'form-group form-group col-md-4','class'=>'form-control','label'=>'Correo electrónico'))?>
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
                                                <?php echo $this->Form->input('calle', array('name'=>'calle','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Calle'))?>
                                                <?php echo $this->Form->input('numero_exterior', array('name'=>'numero_ext','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Número Exterior'))?>
                                                <?php echo $this->Form->input('numero_interior', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Número Interior'))?>
                                                <?php echo $this->Form->input('colonia', array('name'=>'colonia','div' => 'form-group col-md-3','class'=>'form-control','label'=>'Colonia'))?>
                                                <?php echo $this->Form->input('delegacion', array('name'=>'delegacion','div' => 'form-group col-md-3','class'=>'form-control','label'=>'Delegación o Municipio'))?>
                                                <?php echo $this->Form->input('ciudad', array('name'=>'ciudad','div' => 'form-group col-md-3','class'=>'form-control','label'=>'Ciudad'))?>
                                                <?php echo $this->Form->input('cp', array('name'=>'cp','div' => 'form-group col-md-3','class'=>'form-control','label'=>'Código Postal'))?>
                                                <?php echo $this->Form->input('estado_ubicacion', array('name'=>'estado_ubicacion','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estado'))?>
                                                <?php echo $this->Form->input('google_maps', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Coordenadas Google Maps'))?>
                                                <?php echo $this->Form->input('entre_calles', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Entre calles'))?>
                                                <?php echo $this->Form->input('dic_tipo_anuncio_id', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Tipo de anuncio', 'type'=>'select', 'options'=>$tipo_anuncios))?>
                                                <?php echo $this->Form->input('dic_ubicacion_anuncio_id', array('div' => 'form-group col-md-4','class'=>'form-control','empty'=>'No','label'=>'Ubicación Anuncio','type'=>'select', 'options'=>$ubicacion_anuncios))?>
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
                                            <div class="tab-pane" id="tab4">
                                                <div class="row"> 
                                                <h4>Características</h4>
                                                
                                                <div class="form-group col-md-4">
                                                    <label for="InmuebleMantenimiento">Mantenimiento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">$</span>
                                                        <input type="text" class="form-control" aria-label="Amount (rounded to the nearest dollar)">
                                                        <span class="input-group-addon">.00</span>
                                                    </div>
                                                </div>
                                                <?php echo $this->Form->input('edad', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Edad en años'))?>
                                                <?php echo $this->Form->input('terreno', array('name'=>'terreno','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie de Terreno (m2)'))?>
                                                <?php echo $this->Form->input('construccion', array('name'=>'construccion','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie Construida (m2)'))?>
                                                <?php echo $this->Form->input('frente_fondo', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Frente (m2) x Fondo (m2)'))?>
                                                <?php echo $this->Form->input('niveles_totales', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Si es depto en qué nivel se encuentra'))?>
                                                <?php echo $this->Form->input('nivel_propiedad', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Niveles de la Propiedad'))?>
                                                <?php echo $this->Form->input('unidades_totales', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Unidades Totales (Depto / Condominio)'))?>
                                                <?php echo $this->Form->input('estado', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estado en que se entrega'))?>
                                                <?php echo $this->Form->input('recamaras', array('name'=>'recamaras','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Recamaras (cuantas)'))?>
                                                <?php echo $this->Form->input('banos', array('name'=>'banios','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Baños (cuantos)'))?>
                                                <?php echo $this->Form->input('estacionamiento_techado', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estacionamientos Techados (cuantos)'))?>
                                                <?php echo $this->Form->input('estacionamiento_descubierto', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estacionamientos Descubiertos (cuantos)'))?>
                                                <?php $boolean = array(1=>'Si',2=>'No')?>
                                                <?php echo $this->Form->input('cuarto_servicio', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Cuarto / Baño de Servicio','type'=>'select','options'=>$boolean))?>
                                                <?php echo $this->Form->input('balcon', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Balcon/Terraza','type'=>'select','options'=>$boolean))?>
                                                <?php echo $this->Form->input('vestidores', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Vestidores'))?>
                                                <?php echo $this->Form->input('jardin_privado', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Jardín Privado (M2)'))?>
                                                <?php echo $this->Form->input('jardin_comun', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Jardin Común (M2)'))?>
                                                <?php echo $this->Form->input('cisterna', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Cisterna (litros)'))?>
                                                </div>
                                                <div class="row" style="margin-top: 5%">
                                                <h4>Amenidades</h4>
                                                <?php echo $this->Form->input('aire_acondicionado', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('alberca', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('area_juegos', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('areas_verdes', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('asador', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('bodega', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('calefaccion', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('cancha_tenis', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('cantina_cava', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('closet_blancos', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('cocina_integral', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('desayunador_antecomedor', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('edificio_inteligente', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('edificio_leed', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('elevador', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('estudio', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('gimnasio', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('jacuzzi', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('lavavajillas', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('patio_servicio', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('pista_jogging', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('roof_garden', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('sala_tv', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('salon_juegos', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('salon_multiple', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('sauna', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('sistema_seguridad', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('tina_hidromasaje', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('valet_parking', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('vapor', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                <?php echo $this->Form->input('vigilancia', array('div' => 'form-group col-md-3','class'=>'checkbox icheck','type'=>'checkbox'))?>
                                                </div>
                                                <div class="row" style="margin-top: 5%">
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
                                            </div>
                                            <div class="tab-pane" id="tab5">
                                                    <div class="col-lg-12 m-t-35">
                                                        <h5>Imágenes del inmueble</h5>
                                                        <input id="input-fa" name="data[Inmueble][foto_inmueble][]" type="file" multiple class="file-loading">
                                                    </div>
                                                    <?php //echo $this->Form->input('foto_inmueble.',array('type'=>'file','multiple','div' => 'col-md-6','class'=>'form-control','label'=>'Fotografias'));?>
                                                <div class="col-lg-12 m-t-35">
                                                    <h5>Archivos anexos</h5>
                                                    <input id="input-fa-2" name="data[Inmueble][anexos][]" type="file" multiple class="file-loading">
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
    $("#InmuebleAddForm").bootstrapValidator({
        fields: {
            referencia: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria una referencia del inmueble'
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
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Favor de poner una fecha de publicación'
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

    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function(tab, navigation, index) {
            var $validator = $('#InmuebleAddForm').data('bootstrapValidator').validate();
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
                var $validator = $('#InmuebleAddForm').data('bootstrapValidator').validate();
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