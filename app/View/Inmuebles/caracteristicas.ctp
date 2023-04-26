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
            
            
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox'
            
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
                        <?php echo $this->Form->create('Inmueble', array('class'=>'form-horizontal login_validator'));?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-block m-t-20">
                                    <div id="rootwizard">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item m-t-15">
                                                <?= $this->Html->link(
                                                        '<span class="userprofile_tab1 tab_clr">1</span>Datos Generales</a>',
                                                        array(
                                                            'controller'=>'inmuebles',
                                                            'action'=>'edit',
                                                            $inmueble['Inmueble']['id']
                                                            ),
                                                        array(
                                                            'escape'=>false, 'class'=>'nav-link'
                                                            )
                                                        )?>
                                            </li>
                                            <li class="nav-item m-t-15">
                                                <a class="nav-link active" href="#" data-toggle="tab" style="pointer-events: none">
                                                    <span class="userprofile_tab2">2</span>Características</a>
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
                                            
                                            <h3><font color="black">Características</font></h3>
                                                <?= $this->Form->input('id',array('value'=>$inmueble['Inmueble']['id']))?>
                                                <div class="row">
                <?php echo $this->Form->input('construccion', array('name'=>'construccion','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie Habitable (m2)', 'type' => 'number', 'min' => 0 ))?>

                <?php echo $this->Form->input('construccion_no_habitable', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie No Habitable (m2)', 'type' => 'number', 'min' => 0))?>

                <?php echo $this->Form->input('terreno', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Superficie de Terreno (m2)', 'type' => 'number', 'min' => 0))?>

                <?php echo $this->Form->input('frente_fondo', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Frente (m2) x Fondo (m2)', 'type' => 'number', 'min' => 0))?>

                <?php echo $this->Form->input('niveles_totales', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Si es depto en qué nivel se encuentra', 'type' => 'number', 'min' => 0))?>

                <?php echo $this->Form->input('nivel_propiedad', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Niveles de la Propiedad', 'type' => 'number', 'min' => 0))?>
                
                <?php echo $this->Form->input('unidades_totales', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Unidades Totales (Depto / Condominio)', 'type' => 'number', 'min' => 0))?>
                
                <?php echo $this->Form->input('recamaras', array('name'=>'recamaras','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Recámaras (¿Cuántas?)', 'type' => 'number', 'min' => 0))?>
                
                <?php echo $this->Form->input('banos', array('name'=>'banios','div' => 'form-group col-md-4','class'=>'form-control','label'=>'Baños (¿Cuántos?)', 'type' => 'number', 'min' => 0))?>
                
                <?php echo $this->Form->input('medio_banos', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Medios Baños', 'type' => 'number', 'min' => 0))?>
                
                <?php echo $this->Form->input('estacionamiento_techado', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estacionamientos Techados (¿Cuántos?)', 'type' => 'number', 'min' => 0))?>

                <?php echo $this->Form->input('estacionamiento_descubierto', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Estacionamientos Descubiertos (¿Cuántos?)', 'type' => 'number', 'min' => 0))?>

                </div>
                <div class="row">
                <?php
                
                    echo $this->Form->input('disposicion',array('options'=>$disposicion,'class'=>'form-control','div' => 'form-group col-md-4','label'=>'Disposición'));
                    echo $this->Form->input('orientacion',array('options'=>$orientacion,'class'=>'form-control','div' => 'form-group col-md-4','label'=>'Orientación'));
                    echo $this->Form->input('estado',array('options'=>$estado,'class'=>'form-control','div' => 'form-group col-md-4'));
                    
                ?>
            </div>
                                            <div class="row">
                                                <?php echo $this->Form->input('edad', array('div' => 'form-group col-md-4','class'=>'form-control','label'=>'Edad en años', 'type' => 'text'))?>
                                                
                                                
                                                <div class="form-group col-md-4">
                                                    <label for="InmuebleMantenimiento">Mantenimiento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">$</span>
                                                        
                                                        <?= $this->Form->input('mantenimiento', array('div'=>False, 'label'=>False, 'class'=>'form-control', 'arial-label'=>'Amount (rounded to the nearest dollar)', 'min' => 0)); ?>

                                                        <span class="input-group-addon">.00</span>
                                                    </div>
                                                </div>
                                                </div>
                                            <div class="row m-t-20">
                                                <div class="card-block">
                                                    <h3><font color="black">Lugares de interés</h3>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('cc_cercanos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Centros Comerciales Cercanos
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('escuelas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Escuelas
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('frente_parque', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Frente a Parque
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('parque_cercano', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Parques Cercanos
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('plazas_comerciales', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Plazas Comerciales
                                                        </label>
                                                    </div>
                                                </div>
                                                 <div class="card-block">
                                        
                                                    <h3><font color="black">Áreas y Amenidades</h3>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('alberca_sin_techar', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Alberca descubierta
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('golf', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Campo de Golf
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
                                                            <?= $this->Form->input('roof_garden_compartido', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Roof Garden
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('alberca_techada', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Alberca Techada
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('paddle_tennis', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Cancha de Paddle
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
                                                            <?= $this->Form->input('sala_tv', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Sala de TV
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('sala_cine', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Área de Cine
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('squash', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Cancha de Squash
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('living', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Living
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('salon_juegos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Salón de Juegos
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('area_juegos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Área de Juegos
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('cancha_tenis', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Cancha de Tenis
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('lobby', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Lobby
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('salon_multiple', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Salón de usos múltiples
                                                        </label>
                                                    </div><div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('juegos_infantiles', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Área de Juegos Infantiles
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
                                                            <?= $this->Form->input('boliche', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Mesa de Boliche
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
                                                            <?= $this->Form->input('fumadores', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Área para fumadores
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('carril_nado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Carril de Nado
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('patio_servicio', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Patio de Servicio
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
                                                            <?= $this->Form->input('areas_verdes', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Áreas Verdes
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
                                                            <?= $this->Form->input('pista_jogging', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Pista de Jogging
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('sky_garden', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Sky Garden
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('asador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Asador
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('closet_blancos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Closet de Blancos
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('play_room', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Play Room / Cuarto de Juegos
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('tina_hidromasaje', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Tina de Hidromasaje
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('business_center', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Business Center
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
                                                            <?= $this->Form->input('restaurante', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Restaurante
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
                                                            <?= $this->Form->input('cafeteria', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Cafetería
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('fire_pit', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Fire Pit
                                                        </label>
                                                    </div>
                                                </div>
                                            
                                                <div class="card-block">
                                                    <h3><font color="black">Servicios</h3>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('acceso_discapacitados', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Acceso de discapacitados
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
                                                            <?= $this->Form->input('interfon', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Interfón
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('planta_emergencia', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Planta de Emergencia
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
                                                            <?= $this->Form->input('cctv', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            CCTV
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('gas_lp', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Gas LP
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('porton_electrico', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Portón Eléctrico
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
                                                            <?= $this->Form->input('cisterna', array('onchange'=>'showLitros()','type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Cisterna
                                                            <?php
                                                                $show = "";
                                                                if ($inmueble['Inmueble']['cisterna']==0){
                                                                    $show = 'display:none';
                                                                }
                                                                echo $this->Form->input('m_cisterna', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Cantidad en Litros', 'class'=>'form-control', 'div'=>false,)) ?>
                                                        </label>
                                                    </div>
                                                    <script>
                                                        function showLitros(){
                                                            if (document.getElementById('InmuebleCisterna').checked){
                                                                document.getElementById('InmuebleMCisterna').style.display='';
                                                            }else{
                                                              document.getElementById('InmuebleMCisterna').style.display='none';
                                                            }
                                                        
                                                        }
                                                        function showElevadores(){
                                                            if (document.getElementById('InmuebleElevadores').checked){
                                                                document.getElementById('InmuebleQElevadores').style.display='';
                                                            }else{
                                                              document.getElementById('InmuebleQElevadores').style.display='none';
                                                            }
                                                        
                                                        }
                                                    </script>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('gas_natural', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Gas Natural
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('refrigerador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Refrigerador
                                                        </label>
                                                    </div><br><br><br><br><br><br>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('internet', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Acceso Internet / WiFi
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('conmutador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Conmutador
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
                                                            <?= $this->Form->input('sistema_incendios', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Sistema Contra Incendios
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('tercera_edad', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Acceso para Tercera Edad
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('edificio_inteligente', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Edificio Inteligente
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('lavanderia', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Lavanderia
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('sistema_seguridad', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Sistema de Seguridad
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
                                                            <?= $this->Form->input('edificio_leed', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Edificio LEED
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
                                                            <?= $this->Form->input('valet_parking', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Valet Parking
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
                                                            <?= $this->Form->input('elevador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Elevadores
                                                            <?php
                                                            $show = "";
                                                                if ($inmueble['Inmueble']['elevador']==0){
                                                                    $show = 'display:none';
                                                                }
                                                            echo $this->Form->input('q_elevadores', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Número Elevadores', 'class'=>'form-control', 'div'=>false,)) ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('locales_comerciales', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Locales Comerciales
                                                        </label>
                                                    </div>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('vigilancia', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Vigilancia / Seguridad
                                                        </label>
                                                    </div><br><br><br><br><br><br><br>
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('boiler', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Boiler / Calentador de Agua
                                                        </label>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                            
                                                        
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('estacionamiento_visitas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Estacionamiento de visitas
                                                        </label>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                        <label>
                                                            <?= $this->Form->input('mascotas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Permite Mascotas
                                                        </label>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                <?php echo $this->Form->hidden('return'); ?>
                                    </div>
                                                <div class="form-actions form-group row m-t-20">
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Guardar y salir" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('InmuebleReturn').value=1">
                                                </div>
                                                <div class="col-xl-6">
                                                    <input type="submit" value="Continuar" class="btn btn-primary" style="width:100%" onclick="javascript:document.getElementById('InmuebleReturn').value=2">
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
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {

    
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