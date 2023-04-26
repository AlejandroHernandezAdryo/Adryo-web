<?= $this->Html->css(
        array(
            'pages/wizards',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox'
            
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
                <h4 class="nav_top_align"><i class="fa fa-building"></i>Editar Amenidades de desarrollo</h4>
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
                                <ul class="nav nav-pills">
                                    <li class="nav-item m-t-15">
                                        <?= $this->Html->link(
                                                '<span class="userprofile_tab1 tab_clr">1</span>Datos Generales',
                                                array(
                                                    'controller'=>'desarrollos',
                                                    'action'=>'edit_generales',
                                                    $desarrollo['Desarrollo']['id']
                                                ),
                                                array('class'=>'nav-link','escape'=>false)
                                            )
                                        ?>
                                            
                                    </li>

                                    <li class="nav-item m-t-15">
                                        <a class="nav-link active" href="#"
                                           data-toggle="tab" style="pointer-events: none"><span class="userprofile_tab1 tab_clr">2</span>Entorno, Amenidades y Servicios</a>
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
                                        <?php echo $this->Form->input('id')?>

                                    <div class="sub-card mt-3">
                                        <div class="card-header bg-blue-is">
                                            Lugares de Interés
                                        </div>

                                        <div class="card-block">

                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('cc_cercanos', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Centros comerciales cercanos
                                                </label>
                                            </div>

                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('cerca_playa', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Cerca de la playa
                                                </label>
                                            </div>

                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('escuelas', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Escuelas cercanas
                                                </label>
                                            </div>

                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('frente_parque', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Frente a parque
                                                </label>
                                            </div>

                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('frente_parque', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Frente a playa
                                                </label>
                                            </div>

                                            
                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('parque_cercano', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Parques cercanos
                                                </label>
                                            </div>

                                            <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                <label>
                                                    <?= $this->Form->input('plazas_comerciales', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                    Plazas comerciales
                                                </label>
                                            </div>

                                        </div>
                                        
                                        <div class="card-header bg-blue-is">
                                            Amenidades
                                        </div>

                                        <div class="card-block">
                                            
                                            <div class="col-sm-12 col-lg-3">
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('alberca_sin_techar', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Alberca descubierta
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('alberca_techada', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Alberca techada
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('sala_cine', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área de cine
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('juegos_infantiles', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área de juegos infantiles
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('fumadores', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área para fumadores
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('areas_verdes', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Áreas verdes
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('asador', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Asador
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('biblioteca', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Biblioteca
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('cafeteria', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cafetería
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('camastros', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Camastros
                                                    </label>
                                                </div>

                                            </div>

                                            <div class="col-sm-12 col-lg-3">
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('golf', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Campo de golf
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('paddle_tennis', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha de paddle
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('squash', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha de squash
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('tennis', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha de tennis
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('cancha_pickleball', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha pickleball
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('cancha_petanca', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha (petanca)
                                                    </label>
                                                </div>


                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('carril_nado', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Carril de nado
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('ciclopista', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Ciclopista
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('conserje', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Concierge
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('coworking', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Coworking
                                                    </label>
                                                </div>  
                                                
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('club_playa', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Club de playa
                                                    </label>
                                                </div>  

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('fire_pit', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Fire pit
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('gimnasio', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Gimnasio
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-lg-3">
                                                
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('helipuerto', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Helipuerto
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('jacuzzi', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Jacuzzi
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('living', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Living
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('lobby', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Lobby
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('ludoteca', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Ludoteca
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('boliche', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Mesa de boliche
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('pet_park', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Pet park
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('pista_jogging', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Pista de jogging
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('play_room', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Play room / Cuarto de juegos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('pool_bar', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Pool bar
                                                    </label>
                                                </div>



                                                

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('restaurante', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Restaurante
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-lg-3">
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('roof_garden_compartido', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Roof garden
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('salon_juegos', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Salón de juegos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('salon_usos_multiples', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Salón de usos múltiples
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('sauna', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sauna
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('sky_garden', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sky garden
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('simulador_golf', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Simulador golf
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('spa_vapor', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Spa / Vapor
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('vista_panoramica', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Vista panorámica
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('meditation_room', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Yoga / Meditation room
                                                    </label>
                                                </div>

                                                
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="card-header bg-blue-is">
                                            Servicios
                                        </div>

                                        <div class="card-block">
                                            <div class="col-sm-12 col-lg-3">
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('acceso_discapacitados', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Acceso de discapacitados
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('internet', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Acceso Internet / WiFi
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('tercera_edad', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Acceso para Tercera Edad
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('aire_acondicionado', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Aire Acondicionado
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('business_center', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Business Center
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('calefaccion', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Calefacción
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('cctv', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        CCTV
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('certificacion_led', array('type'=>'checkbox','onchange'=>'showCertificado()','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Certificación LEED
                                                        <?php
                                                            $show = "";
                                                            if ($desarrollo['Desarrollo']['certificacion_led']==0){
                                                                $show = 'display:none';
                                                            }
                                                            echo $this->Form->input('certificacion_led_opciones', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Selecciona una opcion', 'class'=>'form-control', 'div'=>false, 'type'=>'select', 'options'=>array(0=>'Seleccione una opción',1=>'Silver', 2=> 'Gold', 3=> 'Platinum')));
                                                        ?>
                                                    </label>
                                                </div> 
                                            </div>

                                            <div class="col-sm-12 col-lg-3">
                                                
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('cisterna', array('onchange'=>'showLitros()','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cisterna
                                                        <?php
                                                            $show = "";
                                                            if ($desarrollo['Desarrollo']['cisterna']==0){
                                                                $show = 'display:none';
                                                            }
                                                            echo $this->Form->input('m_cisterna', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Cantidad en Litros', 'class'=>'form-control', 'div'=>false,)) ?>
                                                        </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('conmutador', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Conmutador
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('edificio_inteligente', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Edificio Inteligente
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('edificio_leed', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Edificio LEED
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('elevadores', array('onchange'=>'showElevadores()','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Elevador
                                                        <?php
                                                        $show = "";
                                                            if ($desarrollo['Desarrollo']['elevadores']==0){
                                                                $show = 'display:none';
                                                            }
                                                        echo $this->Form->input('q_elevadores', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Número Elevadores', 'class'=>'form-control', 'div'=>false,)) ?>
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('estacionamiento_visitas', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Estacionamiento Visitas
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('gas_lp', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Gas LP
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-lg-3">

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('gas_natural', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Gas Natural
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('locales_comerciales', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Locales Comerciales
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('lavanderia', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Lavanderia
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('mezzanine', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Mezzanine
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('mascotas', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Permite Mascotas
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('planta_emergencia', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Planta de Emergencia
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('porton_electrico', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Portón Eléctrico
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('sistema_contra_incendios', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sistema Contra Incendios
                                                    </label>
                                                </div>
                                                
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('sistema_seguridad', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sistema de Seguridad
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-lg-3">
                                                
                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('valet_parking', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Valet Parking
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4">
                                                    <label>
                                                        <?= $this->Form->input('seguridad', array('label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Vigilancia / Seguridad
                                                    </label>
                                                </div>

                                            </div>
                                            
                                        </div>
                                            
                                        <?php
                                        echo $this->Form->hidden('return'); 
                                        ?>
                                    </div>

                                    <div class="row">         
                                       <div class="form-actions form-group row m-t-20">
                                            <div class="col-xl-6">
                                                <input type="submit" value="Guardar Información y salir" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=1">
                                            </div>
                                            
                                            <div class="col-xl-6">
                                                <input type="submit" value="Guardar Información e ir al siguiente paso" class="btn btn-success" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=2">
                                            </div>
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

function showLitros(){
    if (document.getElementById('DesarrolloCisterna').checked){
        document.getElementById('DesarrolloMCisterna').style.display='';
    }else{
      document.getElementById('DesarrolloMCisterna').style.display='none';
    }

}
function showElevadores(){
    if (document.getElementById('DesarrolloElevadores').checked){
        document.getElementById('DesarrolloQElevadores').style.display='';
    }else{
      document.getElementById('DesarrolloQElevadores').style.display='none';
    }

}

function showCertificado(){
    if (document.getElementById('DesarrolloCertificacionLed').checked){
        document.getElementById('DesarrolloCertificacionLedOpciones').style.display='';
    }else{
      document.getElementById('DesarrolloCertificacionLedOpciones').style.display='none';
    }

}

/*
if( $('#DesarrolloCisterna').prop('checked') == true ) {
    document.getElementById("DesarrolloMCisterna").style.display = "block";
}else{
    document.getElementById("DesarrolloMCisterna").style.display = "block";
}
*/
<?php 
    $this->Html->scriptEnd();
?>