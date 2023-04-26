<?php
    $descripcion_sf = strip_tags($inmueble['Inmueble']['comentarios']);

    echo $this->Html->meta('description',$descripcion_sf, array("inline" => false));
    $this->assign('title',$inmueble['Inmueble']['titulo']);
    echo $this->Html->meta('keywords','agente inmobiliario, trabajo inmobiliaria, oferta de propiedades, comercialización inmobiliaria, asesoria inmobiliaria, consultoría inmobiliaria, comercialización de imbuebles, oferta de inmuebles', array("inline" => false));
    $this->assign('author','<meta name="author" content="'.$inmueble['Cuenta']['nombre_comercial'].'">');
    //Facebook META
    $this->assign('og:url','<meta property="og:url" content="'.Router::url('/', true).'inmuebles/detalle/'.$inmueble['Inmueble']['id'].'" />');
    $this->assign('og:image','<meta property="og:image" content="https://adryo.com.mx'.$inmueble['FotoInmueble'][0]['ruta'].'"/>');
    $this->assign('og:image:width','1280px');
    $this->assign('og:image:height','1100px');
    $this->assign('og:description','<meta property="og:description" content="'.$descripcion_sf.'"/>');
    $this->assign('og:title','<meta property="og:title" content="'.$inmueble['Inmueble']['titulo'].'"/>');
    $this->assign('og:type','<meta property="og:type" content="website"');
    //Google META
    $this->assign('google_name','<meta itemprop="name" content="'.$inmueble['Cuenta']['nombre_comercial'].'">');
    $this->assign('google_description','<meta itemprop="description" content="'.$descripcion_sf.'"');
    $this->assign('google_image','<meta itemprop="image" content="https://adryo.com.mx'.$inmueble['FotoInmueble'][0]['ruta'].'"/>');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ficha técnica de propiedades</title>
    <link rel="stylesheet" href="../css/ficha_tecnica_copy.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<style>
    h3{
    font-weight: bold;
    font-size: 40px;
    line-height: 48px;
    margin-bottom: 24px !important;
    }
    h5{
        font-weight: 700;
        font-size: 18px;
        line-height: 28px;
    }
    p{
        font-weight: 500;
        font-size: 16px;
        line-height: 28px;
    }
    /* .iconos{
        display: flex;
        justify-content: flex-end !important;
        align-items: center;
        height: 50px;
    }
    /* .iconos button{
        height: fit-content;
        margin-left: 30px;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        border-radius: 4px;
        color: #f1f3f5;
        background-color: #212529;
        text-decoration: none;
    } */
    /* .iconos a:hover{
        background-color: none;
    } */
    .img-thumbnail{
        width: 110px;
        padding: 4px 2px;
        margin: 0 2px;
        border: 0.5px solid black;
    }
    .container{
        margin: 20px 0 0 0;
    }
    .main-image{
        margin: 10px;
    }
    .nav-item .nav-link{
        color: #212529;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
    }
    .nav-item .nav-link:hover{
        color: #212529;
        text-decoration: underline;
    }
    .detail{
        display: inline-flex;
        align-items: center;
        justify-content: space-evenly; 
        height: 40px;
        margin-right: 30px;
    }
    .detail span{
        margin: 0 3px;
    }
    .material-symbols-outlined{
        margin: 0;
    }
    .descrip{
        display: flex;
    }
    .info{
        padding: 9px;
    }
    .input-group{
        width: 100%;
    }
    .tabcontent {
        display: none;
        padding: 6px 12px;
    }
    .tabcontent {
        animation: fadeEffect 1s; /* Fading effect takes 1 second */
    }
    .social-item{
    height: 100%;
    padding: 10px;
    }
    .icon-social{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Go from zero to full opacity */
    @keyframes fadeEffect {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    @media screen and(max-width: 450px) {
        .rounded-end{
            border-radius: 0 0 4px 4px !important;
        }
        /* .iconos{
            display: flex;
            justify-content: center !important;
            align-items: center;
        }  */
    } 
</style>
<body>

    <!-- The Modal -->
    <div class="modal" id="modalSharedSocialMediaInmueble">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <!-- Modal Header -->
                <div class="modal-header border-bottom-0">
                    <h4 class="modal-title">Compartir</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            <a href="https://www.facebook.com/share.php?u=<?=Router::url('', true)?>&title=Ficha tecnica" target="_blank">
                                <?= $this->Html->image('fb_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4')); ?>
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="https://twitter.com/intent/tweet?text=Les comparto este increíble desarrollo vía @adryo_ai <?=Router::url('', true)?>" target="_blank">
                                <?= $this->Html->image('tw_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4')); ?>
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="https://api.whatsapp.com/send/?text=<?=Router::url('', true)?>&type=custom_url&app_absent=0" target="_blank">
                                <?= $this->Html->image('wa_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4')); ?>
                            </a>
                        </div>
                        <div class="col text-center">
                            <a href="https://www.linkedin.com/shareArticle?url=<?=Router::url('', true)?>" target="_blank">
                                <?= $this->Html->image('in_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4')); ?>
                            </a>
                        </div>
                    </div>
                    <div class="row d-none" id = "rowSuccessCopyClipboard">
                        <div class="col-sm-12">
                            <p class = "text-center">Vínculo copiado al portapapeles</p>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer border-top-0">
                    <div class="input-group mb-3">
                        <input type             = "text"
                                class            = "form-control"
                                aria-label       = "Recipient's username"
                                aria-describedby = "button-addon2"
                                value            = '<?= Router::url('', true) ?>'
                                id               = "btnCopyLink"
                                readonly>
                        <button class   = "btn btn-outline-secondary bg-light text-black"
                                type    = "button"
                                onclick = "btnCopyClipboard()"
                                id      = "button-addon2">
                                    Copiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-sm  p-3">
        <!-- imagen de inicio -->
        <div class="container-sm container">
            <span>
              
                <img src="<?= Router::url('/', true).$inmueble['Cuenta']['logo']?>" class="rounded mx-auto d-block img-fluid" alt="..." style="width: 350px; height: auto;">
          
            </span>
        </div>
        <!-- pestañas -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="galery-tab" data-bs-toggle="tab" data-bs-target="#galery-tab-pane" type="button" role="tab" aria-controls="galery-tab-pane" aria-selected="true">Galería</button>
            </li>
            <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="blueprint-tab" data-bs-toggle="tab" data-bs-target="#blueprint-tab-pane" type="button" role="tab" aria-controls="blueprint-tab-pane" aria-selected="false">Planos</button>
            </li> -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="brochure-tab" data-bs-toggle="tab" data-bs-target="#brochure-tab-pane" type="button" role="tab" aria-controls="brochure-tab-pane" aria-selected="false">Brochure</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-tab-pane" type="button" role="tab" aria-controls="video-tab-pane" aria-selected="false">Video</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="virtual-tab" data-bs-toggle="tab" data-bs-target="#virtual-tab-pane" type="button" role="tab" aria-controls="virtual-tab-pane" aria-selected="false">Recorrido Virtual</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="galery-tab-pane" role="tabpanel" aria-labelledby="galery-tab" tabindex="0">
                <div>
                    <div class="main-image">
                   
                        <img src="<?= Router::url('/', true).$inmueble['FotoInmueble'][0]['ruta']; ?>" class="img-fluid mx-auto d-block" id="img-main">
                  
                    </div>
                    <div class="container-sm carusel d-flex overflow-scroll">
                        <?php  foreach($inmueble['FotoInmueble'] as $dato):?>
                            <?= $this->Html->image($dato['ruta'], array('class' => 'img-thumbnail pointer', 'onclick' => 'srcChange("'.Router::url($dato['ruta']).'")')); ?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="blueprint-tab-pane" role="tabpanel" aria-labelledby="blueprint-tab" tabindex="0">
                <div>
                    <div class="main-image">
                        <!-- <img src="https://beta.adryo.com.mx/files/cuentas/179/generales/logo_cuenta.jpeg" class="img-fluid mx-auto d-block" alt="..."> -->
                    </div>
                    <div class="container-sm carusel d-flex overflow-scroll">
                      
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="brochure-tab-pane" role="tabpanel" aria-labelledby="brochure-tab" tabindex="0">
                
                <?php if( empty( $inmueble['Inmueble']['brochure'] ) ): ?>
                    
                    <div style="background: URL(<?= Router::url($inmueble['FotoInmueble'][0]['ruta'], true); ?>);
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: top center;">
                        <?= $this->Html->image('no_brochure.png', array('class' => 'img-fluid')); ?>
                    </div>
                <?php else: ?>
                    <div>
                        <embed src="<?= Router::url($inmueble['Inmueble']['brochure'], true) ?>" type="" style="width: 100%; height: 400px;">
                    </div>
                <?php endif; ?>

            </div>
            <div class="tab-pane fade" id="video-tab-pane" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
                <div>
                    <?php if( empty( $inmueble['Inmueble']['youtube'] ) ): ?>
                        
                        <div style="background: URL(<?= Router::url($inmueble['FotoInmueble'][0]['ruta'], true); ?>);
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: top center;">
                            <?= $this->Html->image('no_video.png', array('class' => 'img-fluid')); ?>
                        </div>
                    
                    <?php else: ?>
                        <div id="info" style="background: URL(<?= Router::url($inmueble['FotoInmueble'][0]['ruta'], true); ?>);
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            background-position: top center;">
                            <a href="<?= $inmueble['Inmueble']['youtube'] ?>" target="_blank">
                                <?= $this->Html->image('banner_video.png', array('class' => 'banner_video img-fluid')); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane fade" id="virtual-tab-pane" role="tabpanel" aria-labelledby="virtual-tab" tabindex="0">
                <div>

                    <?php if( empty( $inmueble['Inmueble']['matterport'] ) ): ?>
                        
                        <div style="background: URL(<?= Router::url($inmueble['FotoInmueble'][0]['ruta'], true); ?>);
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: top center;">
                            <?= $this->Html->image('sin_recorrido.png', array('class' => 'img-fluid')); ?>
                        </div>
                    
                    <?php else: ?>
                        <div id="info" style="background: URL(<?= Router::url($inmueble['FotoInmueble'][0]['ruta'], true); ?>);
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            background-position: top center;">
                            <a href="<?= $inmueble['Inmueble']['matterport'] ?>" target="_blank">
                                <?= $this->Html->image('ver_recorrido.png', array('class' => 'banner_video img-fluid')); ?>
                            </a>
                        </div>
                    <?php endif; ?>


                </div>
            </div>
        </div>
        <!-- información -->
        <div class="container-sm container" >
            <div class="row mx-auto">
                <div class="col">
                    <div>
                        <h3>

                        <?php 
                            if ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                echo "Precio Venta: $".number_format($inmueble['Inmueble']['precio'],2)."<br>";
                            }
                            if ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                                echo "Precio Renta: $".number_format($inmueble['Inmueble']['precio_2'],2);
                            }
                        ?>
                        </h3>
                    </div>
                    <div>
                        <h5>
                            <b>
                                <h4> <?=utf8_decode($inmueble['Inmueble']['venta_renta']) ?></h4>
                            </b>
                        </h5>
                        <p>
                            <?php echo $inmueble['Inmueble']['calle']." ".$inmueble['Inmueble']['numero_exterior']."-".$inmueble['Inmueble']['numero_interior']." ".$inmueble['Inmueble']['colonia']?>
                            <?php echo $inmueble['Inmueble']['ciudad']." ".$inmueble['Inmueble']['estado_ubicacion']." CP: ".$inmueble['Inmueble']['cp']?>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-sm d-flex justify-content-center align-items-center iconos-left" style="margin-bottom: 10px;">
                            <a href="" class=" mx-1  d-flex align-items-center" style="position: relative;color: #212529;text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalSharedSocialMediaInmueble">
                                <span class="material-symbols-outlined mx-1 " style="color: #212529;" data-bs-toggle="modal" data-bs-target="#modalSharedSocialMediaInmueble">
                                    share
                                </span>
                                Compartir
                            </a>
                        </div>
                        <!-- <div class="col-sm d-flex justify-content-center iconos-right">
                            <button type="button" class="btn btn-primary btn-dark btn-lg">Solicitar visita</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!--  información iconográfica-->
        <div class="container-sm container" >
            <div class="row mx-auto">
                <div class="col">
                    <div>
                        <h4><?= $inmueble['Inmueble']['titulo'] ?></h4>
                    </div>
                    <div class="detalle">
                        <hr>
                        <div class="detail">
                            <span class="material-symbols-outlined">
                                open_with
                            </span>
                            <span>
                                <?= $inmueble['Inmueble']['construccion']+$inmueble['Inmueble']['construccion_no_habitable']?>  m2
                            </span>
                        </div>
                        <div class="detail ms-sm-5">
                            <span class="material-symbols-outlined ">
                                bed
                            </span>
                            <span>

                                <?= $inmueble['Inmueble']['recamaras']?>

                            </span>
                        </div>
                        <div class="detail">
                            <span class="material-symbols-outlined">
                                bathtub
                            </span>
                            <span>
                                <?= $inmueble['Inmueble']['banos']?><?= ($inmueble['Inmueble']['medio_banos']==0||$inmueble['Inmueble']['medio_banos']==""?"":" y ".$inmueble['Inmueble']['medio_banos']." medios baños")?>
                            </span>
                        </div>
                        <div class="detail">
                            <span class="material-symbols-outlined">
                                directions_car
                            </span>
                            <span>
                                <?= $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?>
                            </span>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- descripción (texto, formulario y mapa) -->
        <div class="container-sm container" >
            <div class="descrip row">
                <div class="info col-sm-8">
                    <h5>
                        <b>
                            Descripción
                        </b>
                    </h5>
                    <p>
                        <?= $inmueble['Inmueble']['comentarios'] ?>
                    </p>
                  
                </div>
                <div class="aside col-sm-4">
                <div id="map">
                        <?php
                        $mapa=array();
                                if ($inmueble['Inmueble']['google_maps']!=""){
                                list($latitud, $longitud) = explode(",", $inmueble['Inmueble']['google_maps']);
                            ?>
                        <script>
                        function initMap() {

                            var uluru = {
                                lat: <?= $latitud?>,
                                lng: <?= $longitud?>
                            };
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 16,
                                center: uluru
                            });
                            var marker = new google.maps.Marker({
                                position: uluru,
                                map: map
                            });
                        }
                        </script>

                        <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0&callback=initMap"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">

                        </script>
                        <?php }else{
                                         echo ("Sin coordenadas de Inmueble");
                                     }
                                     ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- cards -->
        <div class="container-sm container" >
            <div class="row">
                <!-- Lugares de interes -->
                <div class="col-sm-4" style="margin-bottom: 10px;">
                    <div class=" p-3 bg-light rounded-2 border" style="height: 100%;">
                        <h5><b>LUGARES DE INTERÉS</b></h5>
                        <p>
                        <?php echo ($inmueble['Inmueble']['cc_cercanos']            == 1 ? '<div class="col-lg-12">Centros Comerciales Cercanos</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['escuelas']               == 1 ? '<div class="col-lg-12">Escuelas</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['frente_parque']          == 1 ? '<div class="col-lg-12">Frente a Parque</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['parque_cercano']         == 1 ? '<div class="col-lg-12">Parques Cercanos</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['plazas_comerciales']     == 1 ? '<div class="col-lg-12">Plazas Comerciales</div>' : "") ?>

                        </p>
                    </div>
                </div>

                <!-- Amenidades -->
                <div class="col-sm-4" style="margin-bottom: 10px;">
                    <div class=" p-3 bg-light rounded-2 border" style="height: 100%;">
                        <h5><b>AMENIDADES</b></h5>
                       <p>
                       <?php echo ($inmueble['Inmueble']['alberca_sin_techar']         == 1 ? '<div class="col-lg-12">Alberca descubierta</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['alberca_techada']            == 1 ? '<div class="col-lg-12">Alberca Techada</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['sala_cine']                  == 1 ? '<div class="col-lg-12">Área de Cine</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['area_juegos']                == 1 ? '<div class="col-lg-12">Área de Juegos</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['juegos_infantiles']          == 1 ? '<div class="col-lg-12">Área de Juegos Infantiles</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['fumadores']                  == 1 ? '<div class="col-lg-12">Área para fumadores</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['areas_verdes']               == 1 ? '<div class="col-lg-12">Áreas Verdes</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['asador']                     == 1 ? '<div class="col-lg-12">Asador</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['business_center']            == 1 ? '<div class="col-lg-12">Business Center</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['cafeteria']                  == 1 ? '<div class="col-lg-12">Cafetería</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['golf']                       == 1 ? '<div class="col-lg-12">Campo de Golf</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['paddle_tennis']              == 1 ? '<div class="col-lg-12">Cancha de Paddle</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['squash']                     == 1 ? '<div class="col-lg-12">Cancha de Squash</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['cancha_tenis']               == 1 ? '<div class="col-lg-12">Cancha de Tennis</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['cantina_cava']               == 1 ? '<div class="col-lg-12">Cantina / Cava</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['cisterna']                   == 1 ? '<div class="col-lg-12">Cisterna - '.$inmueble['Inmueble']['m_cisterna'].' Lts </div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['carril_nado']                == 1 ? '<div class="col-lg-12">Carril de Nado</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['cocina_integral']            == 1 ? '<div class="col-lg-12">Cocina Integral</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['closet_blancos']             == 1 ? '<div class="col-lg-12">Closet de Blancos</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['desayunador_antecomedor']    == 1 ? '<div class="col-lg-12">Desayunador / Antecomedor</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['fire_pit']                   == 1 ? '<div class="col-lg-12">Fire Pit</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['gimnasio']                   == 1 ? '<div class="col-lg-12">Gimnasio</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['jacuzzi']                    == 1 ? '<div class="col-lg-12">Jacuzzi</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['living']                     == 1 ? '<div class="col-lg-12">Living</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['lobby']                      == 1 ? '<div class="col-lg-12">Lobby</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['boliche']                    == 1 ? '<div class="col-lg-12">Mesa de Boliche</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['patio_servicio']             == 1 ? '<div class="col-lg-12">Patio de Servicio</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['pista_jogging']              == 1 ? '<div class="col-lg-12">Pista de Jogging</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['play_room']                  == 1 ? '<div class="col-lg-12">Play Room / Cuarto de Juegos</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['restaurante']                == 1 ? '<div class="col-lg-12">Restaurante</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['roof_garden_compartido']     == 1 ? '<div class="col-lg-12">Roof Garden</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['sala_tv']                    == 1 ? '<div class="col-lg-12">Sala de TV</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['salon_juegos']               == 1 ? '<div class="col-lg-12">Salón de Juegos</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['salon_multiple']             == 1 ? '<div class="col-lg-12">Salón de usos múltiples</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['sauna']                      == 1 ? '<div class="col-lg-12">Sauna</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['spa']                        == 1 ? '<div class="col-lg-12">Spa</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['sky_garden']                 == 1 ? '<div class="col-lg-12">Sky Garden</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['tina_hidromasaje']           == 1 ? '<div class="col-lg-12">Tina de Hidromasaje</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['vapor']                      == 1 ? '<div class="col-lg-12">Vapor</div>': "")?>
                       </p>
                    </div>
                </div>

                <!-- Servicios -->
                <div class="col-sm-4" style="margin-bottom: 10px;">
                    <div class=" p-3 bg-light rounded-2 border" style="height: 100%;">
                        <h5><b>SERVICIOS</b></h5>
                       
                        <p>
                        <?php echo ($inmueble['Inmueble']['acceso_discapacitados']      == 1 ? '<div class="col-lg-12">Acceso de discapacitados</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['agua_corriente']             == 1 ? '<div class="col-lg-12">Agua Corriente</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['amueblado']                  == 1 ? '<div class="col-lg-12">Amueblado</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['internet']                   == 1 ? '<div class="col-lg-12">Acceso Internet / WiFi</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['tercera_edad']               == 1 ? '<div class="col-lg-12">Acceso para Tercera Edad</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['aire_acondicionado']         == 1 ? '<div class="col-lg-12">Aire Acondicionado</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['bodega']                     == 1 ? '<div class="col-lg-12">Bodega</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['boiler']                     == 1 ? '<div class="col-lg-12">Boiler / Calentador de Agua</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['calefaccion']                == 1 ? '<div class="col-lg-12">Calefacción</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['cctv']                       == 1 ? '<div class="col-lg-12">CCTV</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['cisterna']                   == 1 ? '<div class="col-lg-12">Cisterna</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['conmutador']                 == 1 ? '<div class="col-lg-12">Conmutador</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['interfon']                   == 1 ? '<div class="col-lg-12">Interfón</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['edificio_inteligente']       == 1 ? '<div class="col-lg-12">Edificio Inteligente</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['edificio_leed']              == 1 ? '<div class="col-lg-12">Edificio LEED</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['elevador']                   == 1 ? '<div class="col-lg-12">Elevadores</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-12">Estacionamiento de visitas</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['gas_lp']                     == 1 ? '<div class="col-lg-12">Gas LP</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['gas_natural']                == 1 ? '<div class="col-lg-12">Gas Natural</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['lavavajillas']               == 1 ? '<div class="col-lg-12">Lavavajillas</div>': "")?>
                        <?php echo ($inmueble['Inmueble']['lavanderia']                 == 1 ? '<div class="col-lg-12">Lavanderia</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['linea_telefonica']           == 1 ? '<div class="col-lg-12">Línea Telefónica</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['locales_comerciales']        == 1 ? '<div class="col-lg-12">Locales Comerciales</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['mascotas']                   == 1 ? '<div class="col-lg-12">Permite Mascotas</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['planta_emergencia']          == 1 ? '<div class="col-lg-12">Planta de Emergencia</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['porton_electrico']           == 1 ? '<div class="col-lg-12">Portón Eléctrico</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['refrigerador']               == 1 ? '<div class="col-lg-12">Refrigerador</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['sistema_incendios']          == 1 ? '<div class="col-lg-12">Sistema Contra Incendios</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['sistema_seguridad']          == 1 ? '<div class="col-lg-12">Sistema de Seguridad</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['valet_parking']              == 1 ? '<div class="col-lg-12">Valet Parking</div>' : "") ?>
                        <?php echo ($inmueble['Inmueble']['vigilancia']                 == 1 ? '<div class="col-lg-12">Vigilancia / Seguridad</div>' : "") ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <!-- tarjeta -->
        <div class="container-sm container">
            <div class="card mb-3 bg-dark">
                <div class="row g-0">
                    <div class="col-md-3 p-4 d-block d-flex justify-content-center align-items-center">
                        <?= $this->Html->image($agente['User']['foto'], array('class' => 'img-fluid rounded-2')); ?>
                    </div>
                    <div class="col-md-8 p-4 d-flex">
                        <div
                            class="col-md-1 p-3 rounded-2 bg-light d-flex flex-column align-items-center justify-content-between">
                            <div>
                                <span class="material-symbols-outlined">
                                    person
                                </span>
                            </div>
                            <br>
                            <span class="material-symbols-outlined">
                                call
                            </span>
                            <span class="material-symbols-outlined">
                                language
                            </span>
                            <span class="material-symbols-outlined">
                                mail
                            </span>
                        </div>
                        <div class="col-md-7 d-flex flex-column justify-content-between">
                            <div class="card-body" style="color:#f1f3f5;">
                                <div>
                                    <h5 class="card-title"><b> <?= $agente['User']['nombre_completo']?></b></h5>
                                    <p class="card-text">
                                        <?= ( empty($rds_sociales['CuentasUser']['puesto']) ? ' ' : $rds_sociales['CuentasUser']['puesto'] ) ?>
                                    </p>
                                </div>
                                <br>
                                <br>
                                <p class="card-text">
                                    <?= ( empty($agente['User']['telefono1']) ? 'Sin teléfono' : $agente['User']['telefono1'] ) ?>
                                </p>
                                <p class="card-text pt-3">
                                    <?= ( empty($rds_sociales['Cuenta']['pagina_web']) ? 'N/A' :  $rds_sociales['Cuenta']['pagina_web']) ?>
                                </p>
                                <p class="card-text pt-3">
                                    <?= ( empty($agente['User']['correo_electronico']) ? 'Sin correo' : $agente['User']['correo_electronico']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 rounded-2 bg-light social" style="color: #495057;">
                        <div class="text-center social-item row">
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_facebook']) ? $desarrollo['Desarrollo']['url_facebook'] : $rds_sociales['Cuenta']['url_facebook'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/facebook.png" alt=" ">
                                </a>
                            </div>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_twitter']) ? $desarrollo['Desarrollo']['url_twitter'] : $rds_sociales['Cuenta']['url_twitter'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/twitter.png" alt="">
                                </a>
                            </div>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_instagram']) ? $desarrollo['Desarrollo']['url_instagram'] : $rds_sociales['Cuenta']['url_instagram'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/instagram.png" alt="">
                                </a>
                            </div>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_youtube']) ? $desarrollo['Desarrollo']['url_youtube'] : $rds_sociales['Cuenta']['url_youtube'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/youtube.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- footer -->
        <div class="container-sm bg-dark p-4">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-center text-center">
                    <small style="color: #f1f3f5;">
                        Powered by:
                    </small>
                    <img src="https://adryo.com.mx/assets/icons/adryo_blanco.png" style="height: 22px ;border-radius:  6px; margin-left: 5px;">

                </div>
                <div class="col-md-6 d-flex justify-content-center">
                    <small class="card-title d-flex ali" style="color: #f1f3f5;">Todos los derechos reservados <?= date('Y') ?></small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="../js/ficha_tecnica.js"></script>

    <script>
        function openTab(evt, openTab) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(openTab).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementById("defaultOpen").click();

        function srcChange( newURL ){
            document.getElementById("img-main").src = newURL;
        }

        function srcChangeFlat( newURL ){
            document.getElementById("img-flat").src = newURL;
        }

    </script>
</body>
</html>
