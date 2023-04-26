<?php
    $total_espacio = $inmueble['Inmueble']['construccion'] + $inmueble['Inmueble']['construccion_no_habitable'];
    $exclusiva     = array('Exclusiva'=>'Exclusiva', 'Externo'=>'Externo','Sin Exclusiva'=>'Sin Exclusiva');
    $venta         = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
    $anuncio       = array('No'=>'No', 'Anuncio Chico'=>'Anuncio Chico','Gallardete'=>'Gallardete', 'Lona Chica'=>'Lona Chica', 'Lona Grande' =>'Lona Grande');
    $ubicacion     = array('Barda'=>'Barda','Caseta de Vigilacia'=>'Caseta de Vigilacia','Fachada'=>'Fachada', 'Otro'=>'Otro','Ventana'=>'Ventana');
    $disposicion   = array('Frente'=>'Frente','Medio'=>'Medio','Interior'=>'Interior');
    $orientacion   =  array('Norte'=>'Norte','Sur'=>'Sur','Este'=>'Este','Oeste'=>'Oeste','Sureste'=>'Sureste','Suroeste'=>'Suroeste','Noreste'=>'Noreste','Noroeste'=>'Noroeste');
    $estado        = array('Nuevo'=>'Nuevo','Excelente'=>'Excelente','Bueno'=>'Bueno','Regular'=>'Regular','Malo'=>'Malo','Remodelado'=>'Remodelado','Para Remodelar'=>'Para Remodelar');

echo $this->Html->css(
        array(
            // checked
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',

            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',

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
            
            
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox'
            
            ),
        array('inline'=>false))
        
?>
<style>
    .text-black{
        color: black;
    }
    .file-caption{
        height: 29px !important;
    }
</style>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i> Edicíón de inmueble independiente</h4>
            </div>
            
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row mt-1">
                <?php 
                    echo $this->Form->create('Inmueble', array('type'=>'file'));
                    echo $this->Form->hidden('exclusiva', array('value'=>'Exclusiva'));
                    echo $this->Form->date('fecha', array('type'=>'hidden','value'=>date('y-m-d'),'style'=>'width:100%'));
                    echo $this->Form->hidden('cambio_precio',array('value'=>0));
                ?>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block card_block_top_align">
                            <section>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">datos generales de la propiedad</h4>
                                    </div>
                                </div>
                            </section>
                            <section id="generales">
                                <div class="row mt-2">
                                    <?= $this->Form->input('referencia', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6')); ?>
                                    <?= $this->Form->input('titulo', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-6')); ?>
                                </div>
                                <div class="row">
                                    <?= $this->Form->input('dic_tipo_propiedad_id', array('label'=>'Tipo de Inmueble','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad')); ?>
                                    <?= $this->Form->input('venta_renta', array('onchange'=>'javascript:showPrecio()','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta','label'=>'Renta/Venta','id'=>'rv')); ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6" id="precio1">
                                        <label for="InmueblePrecio">Precio Venta</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" name="data[Inmueble][precio]"  onchange="javascript:document.getElementById('InmuebleCambioPrecio').value=1" value="<?= $inmueble['Inmueble']['precio']?>" class="form-control" id="currency" aria-label="Amount (rounded to the nearest dollar)">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6" style="display:none" id="precio2">
                                        <label for="InmueblePrecio2">Precio Renta</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" name="data[Inmueble][precio_2]" value="<?= $inmueble['Inmueble']['precio_2']?>"  onchange="javascript:document.getElementById('InmuebleCambioPrecio').value=1" class="form-control" id="currency" aria-label="Amount (rounded to the nearest dollar)">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('disposicion',array('options'=>$disposicion,'class'=>'form-control','div' => 'form-group col-md-4'));
                                        echo $this->Form->input('orientacion',array('options'=>$orientacion,'class'=>'form-control','div' => 'form-group col-md-4'));
                                        echo $this->Form->input('estado',array('options'=>$estado,'class'=>'form-control','div' => 'form-group col-md-4'));
                                    ?>
                                </div>
                            </section>
                            <section id="caracteristicas">
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            caracteristicas
                                        </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('construccion', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie habitable (m2)','onchange'=>'javascript:suma()'));
                                        echo $this->Form->input('construccion_no_habitable', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie No Habitable (m2)','onchange'=>'javascript:suma()'));
                                        echo $this->Form->input('total_espacio', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie Total (m2)','disabled'=>true,'id'=>'total', 'value'=>$total_espacio));
                                    ?>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('frente_fondo', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Frente (m2) x Fondo (m2)'));
                                        echo $this->Form->input('nivel_propiedad', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Si es depto en qué nivel se encuentra'));
                                        echo $this->Form->input('niveles_totales', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Niveles de la Propiedad'));
                                    ?>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('recamaras', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Recamaras (cuantas)'));
                                        echo $this->Form->input('banos', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Baños'));
                                        echo $this->Form->input('medio_banos', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Medios Baños'));
                                    ?>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('estacionamiento_techado', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estacionamientos Techados (cuantos)'));
                                        echo $this->Form->input('estacionamiento_descubierto', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estacionamientos Descubiertos (cuantos)'));
                                    ?>
                                </div>
                            </section>
                            <section id="amenidades">
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            Áreas y amenidades
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('area_lavado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Área de lavado
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('cantina_cava', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Cantina / Cava
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('chimenea', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Chimenea
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('cuarto_servicio', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Cuarto / Baño de Servicio
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('balcon', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Balcón / Terraza
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('vestidores', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Vestidores
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('jardin_privado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Jardín / Patio Privado
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('closets', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Closets
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('closet_blancos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Closets Blancos
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('cocina_integral', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Cocina Integral
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('area_juegos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Cuarto de Juegos
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('desayunador_antecomedor', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Desayunador / Antecomedor
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('estudio', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Estudio
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('gimnasio', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Gimnasio
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('jacuzzi', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Jacuzzi
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('roof_garden', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Roof Garden Privado
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('sala_tv', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Sala TV
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('sauna', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Sauna
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('vapor', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Vapor
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('spa', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Spa
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('tina_hidromasaje', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Tina de Hidromasaje
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <section id="servicios">
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            Servicios
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('internet', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Internet / WiFi
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('agua_corriente', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Agua Corriente
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('aire_acondicionado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Aire Acondicionado
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('amueblado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Amueblado
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('bodega', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Bodega
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('boiler', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Boiler / Calentador de agua
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('calefaccion', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Calefacción
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('cctv', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            CCTV
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('refrigerador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Refrigerador
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('interfon', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Interfón
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('lavavajillas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Lavavajillas
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('linea_telefonica', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Línea Telefónica
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('sistema_seguridad', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Sistema Seguridad
                                        </label>
                                    </div>
                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                        <label>
                                            <?= $this->Form->input('sistema_incendios', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            Sistema Contra Incendios
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <section id="descripcion">
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            descripción
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <textarea name="data[Inmueble][comentarios]" id="InmuebleComentarios" class="summernote_editor" placeholder="Escribir descripción">   <?= $inmueble['Inmueble']['comentarios']?>
                                        </textarea>
                                    </div>
                                </div>
                            </section>
                            <section id="direccion">
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            ubicación de la propiedad
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <?php
                                        echo $this->Form->input('calle', array('name'=>'calle','div' => 'col-sm-12 col-lg-6','class'=>'form-control','label'=>array('text'=>'Calle*','style'=>'font-weight:bold')));
                                        echo $this->Form->input('numero_ext', array('name'=>'numero_ext','div' => 'col-xs-6','class'=>'form-control','label'=>array('text'=>'Número Exterior*','style'=>'font-weight:bold')));
                                    ?>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('colonia', array('name'=>'colonia','div' => 'col-sm-12 col-lg-6','class'=>'form-control','label'=>array('text'=>'Colonia*','style'=>'font-weight:bold')));
                                        echo $this->Form->input('delegacion', array('name'=>'delegacion','div' => 'col-xs-6','class'=>'form-control','label'=>array('text'=>'Delegación*','style'=>'font-weight:bold')));
                                    ?>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('cp', array('name'=>'cp','div' => 'col-sm-12 col-lg-6','class'=>'form-control','label'=>array('text'=>'Código Postal*','style'=>'font-weight:bold')));
                                        echo $this->Form->input('ciudad', array('name'=>'ciudad','div' => 'col-xs-6','class'=>'form-control','label'=>array('text'=>'Ciudad*','style'=>'font-weight:bold')));
                                    ?>
                                </div>
                                <div class="row">
                                    <?php
                                        echo $this->Form->input('estado', array('name'=>'estado','div' => 'col-xs-6','class'=>'form-control','label'=>array('text'=>'Estado*','style'=>'font-weight:bold')));
                                        echo $this->Form->input('entre_calles', array('div' => 'col-xs-6','class'=>'form-control','label'=>'Entre Calles'));
                                        echo $this->Form->input('google_maps', array('div' => 'col-xs-6','class'=>'form-control','label'=>'Coordenadas Google Maps'));
                                    ?>
                                </div>
                            </section>
                            <section id="imagenes">
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            Imagenes
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-1" style="height: 400px; overflow-y: scroll; padding: 20px; border: 1px solid #E1E1E1">
                                    <?php $count = 0; foreach ($fotos_inmueble as $imagen): $count++;?>
                                        <div class="col-sm-3">
                                            <?php echo $this->Form->input('foto_id',array('type'=>'hidden','value'=>$imagen['FotoInmueble']['id'], 'name'=>'data[fotos]['.$count.'][id]'));?>
                                            <div class="col-xs-12">
                                                <?php echo $this->Html->image($imagen['FotoInmueble']['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                            </div>
                                            <div class="col-xs-12">
                                                <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['FotoInmueble']['descripcion'],'label'=>false,'style'=>'width:100%', 'name'=>'data[fotos]['.$count.'][descripcion]'))?>
                                            </div>
                                            <div class="col-xs-12">
                                                <?php echo $this->Form->input ('orden', array('placeholder'=>'Orden','value'=>$imagen['FotoInmueble']['orden'],'label'=>false,'style'=>'width:100%', 'name'=>'data[fotos]['.$count.'][orden]'))?>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="checkbox" style="margin-top: 2px;">
                                                    <label>
                                                        <input type="checkbox" name="data[fotos][<?= $count ?>][eliminar]">
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Eliminar
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <h4 class="text-black">
                                            Subir imagenes
                                        </h4>
                                    </div>
                                    <div class="col-lg-12">
                                        <input id="input-fa" name="data[Inmueble][foto_inmueble][]" type="file" multiple class="file-loading">
                                    </div>
                                </div>
                            </section>
                            <section id="submit">
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-lg-6">
                                        <?php
                                            echo $this->Form->submit('Guardar cambios', array('class'=>'btn btn-success btn-block'));
                                        ?>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <?= $this->Html->link('Salir sin guardar', array('action'=>'view', $this->request->data['Inmueble']['id']),array('class'=>'btn btn-primary btn-block')) ?>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
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
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            '/vendors/switchery/js/switchery.min',
            'pages/radio_checkbox',
            
           
           
            
        ),
        array('inline'=>false))
?>

<script>
'use strict';
function suma(){
    document.getElementById('total').value = parseFloat(document.getElementById('InmuebleConstruccion').value) + parseFloat(document.getElementById('InmuebleConstruccionNoHabitable').value)
}
function showPrecio(){
    if(document.getElementById('rv').value=="Venta / Renta"){
        document.getElementById('precio2').style.display="";
    }else if(document.getElementById('rv').value=="Venta"){
        document.getElementById('precio2').style.display="none";
        document.getElementById('precio1').style.display="";
    }else if(document.getElementById('rv').value=="Renta"){
        document.getElementById('precio1').style.display="none";
        document.getElementById('precio2').style.display="";
    }
}

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

</script>
