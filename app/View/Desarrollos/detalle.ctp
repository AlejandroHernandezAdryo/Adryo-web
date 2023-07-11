<?php
    $bolean_depto_muestra = array( 1=> 'Si', 2=> 'No');
    $descripcion_sf = strip_tags($desarrollo['Desarrollo']['descripcion']);
    echo $this->Html->meta('description',$descripcion_sf, array("inline" => false));
    $this->assign('title',$desarrollo['Desarrollo']['nombre']);
    echo $this->Html->meta('keywords','agente inmobiliario, trabajo inmobiliaria, oferta de propiedades, comercialización inmobiliaria, asesoria inmobiliaria, consultoría inmobiliaria, comercialización de imbuebles, oferta de inmuebles', array("inline" => false));
    $this->assign('author','<meta name="author" content="'.$desarrollo['Cuenta']['nombre_comercial'].'">');
    //Facebook META
    $this->assign('og:url','<meta property="og:url" content="'.Router::url('/', true).'desarrollos/detalle/'.$desarrollo['Desarrollo']['id'].'" />');
    $this->assign('og:image','<meta property="og:image" content="https://adryo.com.mx'.$desarrollo['FotoDesarrollo'][0]['ruta'].'"/>');
    $this->assign('og:image:width','1280px');
    $this->assign('og:image:height','1100px');
    $descripcion = $desarrollo['Desarrollo']['descripcion'];
    $this->assign('og:description',"<meta property='og:description' content='.$descripcion_sf.'/>");
    $this->assign('og:title','<meta property="og:title" content="'.$desarrollo['Desarrollo']['nombre'].'"/>');
    $this->assign('og:type','<meta property="og:type" content="website"/>');
    //Google META
    $this->assign('google_name','<meta itemprop="name" content="'.$desarrollo['Cuenta']['nombre_comercial'].'">');
    $this->assign('google_description','<meta itemprop="description" content="'.$desarrollo['Desarrollo']['nombre'].'"/>');
    $this->assign('google_image','<meta itemprop="image" content="https://adryo.com.mx'.$desarrollo['FotoDesarrollo'][0]['ruta'].'"/>');

    // Ruta generica
    $ruta = Router::url(true);

    list($latitud, $longitud) = explode(",", $desarrollo['Desarrollo']['google_maps']);
    echo $this->Html->css(
        array(
            // 'components',
            'pages/layouts',
            'custom',
            'ficha_tecnica_copy',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css',
            'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200',
            'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200'
        ),
        array('inline'=>false)); 
?>
<style>
    .img-main{
        width: auto;
        height: 300px;
    }
    .pointer{
        cursor: pointer;
    }

    .img-thumbnail {
        width: 110px;
        height: 130px;
        padding: 4px 2px;
        margin: 0 2px;
        border: 0.5px solid black;
    }
    .main-image {
        margin: 10px;
    }

    .nav-item .nav-link {
        color: #212529;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
    }

    .nav-item .nav-link:hover {
        color: #212529;
        text-decoration: underline;
    }

    .detail {
        display: inline-flex;
        align-items: center;
        justify-content: space-evenly;
        height: 40px;
        margin-right: 30px;
    }

    .detail span {
        margin: 0 3px;
    }

    .material-symbols-outlined {
        margin: 0;
    }

    .descrip {
        display: flex;
    }

    .info {
        padding: 9px;
    }

    .input-group {
        width: 100%;
    }

    .tabcontent {
        display: none;
        padding: 6px 12px;
    }

    .tabcontent {
        animation: fadeEffect 1s;
        /* Fading effect takes 1 second */
    }

    .social-item {
        height: 100%;
        padding: 10px;
    }

    .icon-social {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Go from zero to full opacity */
    @keyframes fadeEffect {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @media screen and(max-width: 450px) {
        .rounded-end {
            border-radius: 0 0 4px 4px !important;
        }

        /* .iconos{
                display: flex;
                justify-content: center !important;
                align-items: center;
            }  */
    }

    @media (max-width: 576px) {
        .img-main{
            width: 100%;
            height: auto;
        }
    }
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }

</style>


<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <!-- Modal Header -->
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title">Compartir</h4>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
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

<div class="container outer">
    <div class="inner">
        
        <!-- Logotipo de encabezado -->
        <div class="row">
            <div class="col-sm-12">
                <span>
                    <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'], array('class' => 'rounded mx-auto d-block', 'style' => 'width: 350px; height: auto;')); ?>
                </span>
            </div>
        </div>

        <!-- Pestañas de navegacion -->
        <div class="row">
            <div class="col-sm-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="galery-tab" data-bs-toggle="tab" data-bs-target="#galery-tab-pane"
                            type="button" role="tab" aria-controls="galery-tab-pane" aria-selected="true">Galería</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="blueprint-tab" data-bs-toggle="tab" data-bs-target="#blueprint-tab-pane"
                            type="button" role="tab" aria-controls="blueprint-tab-pane" aria-selected="false">Planos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="brochure-tab" data-bs-toggle="tab" data-bs-target="#brochure-tab-pane"
                            type="button" role="tab" aria-controls="brochure-tab-pane" aria-selected="false">Brochure</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-tab-pane"
                            type="button" role="tab" aria-controls="video-tab-pane" aria-selected="false">Video</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="virtual-tab" data-bs-toggle="tab" data-bs-target="#virtual-tab-pane"
                            type="button" role="tab" aria-controls="virtual-tab-pane" aria-selected="false">Recorrido
                            Virtual</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="row">
            <div class="col-sm-12">

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="galery-tab-pane" role="tabpanel" aria-labelledby="galery-tab" tabindex="0">
                    
                        <div>
                            <div class="main-image">
                                <?= $this->Html->image($desarrollo['FotoDesarrollo'][0]['ruta'], array('class' => 'img-main mx-auto d-block img-fluid', 'id' => 'img-main')); ?>
                            </div>

                            <div class="container-sm carusel d-flex overflow-scroll">
                                <?php  foreach($desarrollo['FotoDesarrollo'] as $foto):?>
                                    <!-- <div class="img-thumbnail pointer" style="background: URL(<?= Router::url($foto['ruta'], true); ?>);
                                                    background-repeat: no-repeat;
                                                    background-size: cover;
                                                    background-position: top center;" onclick="srcChange('<?= Router::url($foto['ruta']) ?>')">
                                    </div> -->
                                    <?= $this->Html->image($foto['ruta'], array('class' => 'img-thumbnail pointer', 'onclick' => 'srcChange("'.Router::url($foto['ruta']).'")')); ?>
                                <?php endforeach;?>
                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="blueprint-tab-pane" role="tabpanel" aria-labelledby="blueprint-tab" tabindex="0">
                        <div>
                            <div class="main-image">
                                <?= $this->Html->image($desarrollo['Planos'][0]['ruta'], array('class' => 'img-main mx-auto d-block img-fluid', 'id' => 'img-flat')); ?>
                            </div>
                            <div class="container-sm carusel d-flex overflow-scroll">

                                
                                <?php foreach($desarrollo['Planos'] as $plano):?>
                                    
                                    <!-- <div class="img-thumbnail pointer" style="background: URL(<?= Router::url($plano['ruta'], true); ?>);
                                        background-repeat: no-repeat;
                                        background-size: cover;
                                        background-position: top center;" onclick="srcChangeFlat('<?= Router::url($plano['ruta']) ?>')">
                                    </div> -->

                                    <?= $this->Html->image($plano['ruta'], array('class' => 'img-thumbnail pointer', 'onclick' => 'srcChangeFlat("'.Router::url($plano['ruta']).'")')); ?>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="brochure-tab-pane" role="tabpanel" aria-labelledby="brochure-tab" tabindex="0">

                        <?php if( empty( $desarrollo['Desarrollo']['brochure'] ) ): ?>
                                
                                <div style="background: URL(<?= Router::url($desarrollo['FotoDesarrollo'][0]['ruta'], true); ?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                                    <?= $this->Html->image('no_brochure.png', array('class' => 'img-fluid')); ?>
                                </div>
                            
                            <?php else: ?>
                                <!-- <embed src="" type="" style="width: 100%; height: 400px;"> -->
                                <!-- <embed src="https://betaadryo.com.mx/pdf/Alt_Zap.pdf" type="application/pdf" style="width: 100%; height: 400px;overflow:scroll;"> -->
                                <div id="example1"></div>
                            <?php endif; ?>

                    </div>

                    <div class="tab-pane fade" id="video-tab-pane" role="tabpanel" aria-labelledby="video-tab" tabindex="0">

                            <?php if( empty( $desarrollo['Desarrollo']['youtube'] ) ): ?>
                                
                                <div style="background: URL(<?= Router::url($desarrollo['FotoDesarrollo'][0]['ruta'], true); ?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                                    <?= $this->Html->image('sin_video.png', array('class' => 'img-fluid')); ?>
                                </div>
                            
                            <?php else: ?>
                                <div id="info" style="background: URL(<?= Router::url($desarrollo['FotoDesarrollo'][0]['ruta'], true); ?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                                    <a href="<?= $desarrollo['Desarrollo']['youtube'] ?>" target="_blank">
                                        <?= $this->Html->image('banner_video.png', array('class' => 'banner_video img-fluid')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                    </div>

                    <div class="tab-pane fade" id="virtual-tab-pane" role="tabpanel" aria-labelledby="virtual-tab" tabindex="0">
                        <div>

                            <?php if( empty( $desarrollo['Desarrollo']['matterport'] ) ): ?>
                                
                                <div style="background: URL(<?= Router::url($desarrollo['FotoDesarrollo'][0]['ruta'], true); ?>);
                                        background-repeat: no-repeat;
                                        background-size: cover;
                                        background-position: top center;">
                                    <?= $this->Html->image('sin_recorrido.png', array('class' => 'img-fluid')); ?>
                                </div>
                            
                            <?php else: ?>
                                <div id="info" style="background: URL(<?= Router::url($desarrollo['FotoDesarrollo'][0]['ruta'], true); ?>);
                                                    background-repeat: no-repeat;
                                                    background-size: cover;
                                                    background-position: top center;">
                                    <a href="<?= $desarrollo['Desarrollo']['matterport'] ?>" target="_blank">
                                        <?= $this->Html->image('ver_recorrido.png', array('class' => 'banner_video img-fluid')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>


                        </div>
                    </div>

                </div>



            </div>
        </div>

        <!-- información -->
        <div class="row">
            <div class="col mt-5">
                <div>
                    <h3>
                        <?= "Desde : $".number_format($desarrollo['Desarrollo']['precio_low'],2); ?>
                    </h3>
                </div>
                <div>
                    <h5><b>ETAPA: <?= $desarrollo['Desarrollo']['etapa_desarrollo']?></b></h5>
                    <p>
                        <?=
                            ( !empty ($desarrollo['Desarrollo']['calle']) ? '' .$desarrollo['Desarrollo']['calle'] : '' )
                            .( !empty ($desarrollo['Desarrollo']['numero_ext']) ? ' ' .$desarrollo['Desarrollo']['numero_ext'] : '' )
                            .( !empty ($desarrollo['Desarrollo']['numero_int']) ? ', ' .$desarrollo['Desarrollo']['numero_int'] : '' )
                            .( !empty ($desarrollo['Desarrollo']['colonia']) ? ', Col. '.'<span style="text-transform: none;">'.$desarrollo['Desarrollo']['colonia'].'</span>' : '' )
                            .( !empty ($desarrollo['Desarrollo']['ciudad']) ? ', '.'<span style="text-transform: none;">'.$desarrollo['Desarrollo']['ciudad'].'</span>' : '' )
                            .( !empty ($desarrollo['Desarrollo']['estado']) ? ', '.'<span style="text-transform: none;">'.$desarrollo['Desarrollo']['estado'].'</span>' : '' )
                            .( !empty ($desarrollo['Desarrollo']['cp']) ? ', CP: '.$desarrollo['Desarrollo']['cp'] : '' )
                        ?>

                    </p>
                </div>
            </div>
            <div class="col mt-5">
                <div class="row">
                    <div class="col-sm d-flex justify-content-center align-items-center iconos-left"
                        style="margin-bottom: 10px;">
                        <a href="" class=" mx-1  d-flex align-items-center"
                            style="position: relative;color: #212529;text-decoration: none;" data-bs-toggle="modal"
                            data-bs-target="#myModal">
                            <span class="material-symbols-outlined mx-1 " style="color: #212529;"
                                data-bs-toggle="modal" data-bs-target="#myModal">
                                share
                            </span>
                            Compartir
                        </a>
                    </div>
                    <div class="col-sm d-flex justify-content-center iconos-right">
                        <!-- <button type="button" class="btn btn-primary btn-dark btn-lg">Solicitar visita</button> -->
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!--  información iconográfica-->
        <div class="row mx-auto">
            <div class="col">
                <div>
                    <h4>
                        <?= $desarrollo['Desarrollo']['nombre']?>
                    </h4>
                </div>
                <div class="detalle">
                    <hr>
                    <div class="detail">
                        <span class="material-symbols-outlined">
                            open_with
                        </span>
                        <span>
                            <?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?> m2
                        </span>
                    </div>
                    <div class="detail ms-sm-5">
                        <span class="material-symbols-outlined ">
                            bed
                        </span>
                        <span>
                            <?= $desarrollo['Desarrollo']['rec_low']?> - <?= $desarrollo['Desarrollo']['rec_top']?> Recámaras
                        </span>
                    </div>
                    <div class="detail">
                        <span class="material-symbols-outlined">
                            bathtub
                        </span>
                        <span>
                            <?= $desarrollo['Desarrollo']['banio_low']?> - <?= $desarrollo['Desarrollo']['banio_top']?> Baños
                        </span>
                    </div>
                    <div class="detail">
                        <span class="material-symbols-outlined">
                            directions_car
                        </span>
                        <span>
                            <?= $desarrollo['Desarrollo']['est_low']?> - <?= $desarrollo['Desarrollo']['est_top']?> Estacionamiento
                        </span>
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <!-- descripción (texto, formulario y mapa) -->
        <div class="descrip row">
            <div class="info col-sm-8 mt-5">
                <h5>
                    <b>
                        Descripción
                    </b>
                </h5>
                <p>
                    <?= $desarrollo['Desarrollo']['descripcion'] ;?>
                </p>
                <div class="p-3 border rounded-2 bg-light">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="basic-url" class="form-label"><strong>Tipo de desarrollo</strong></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url"
                                    readonly
                                    aria-describedby="basic-addon3"
                                    value="<?=($desarrollo['Desarrollo']['tipo_desarrollo'] )?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="basic-url" class="form-label"><strong>Etapa</strong></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url"
                                        readonly
                                    aria-describedby="basic-addon3"
                                    value=" <?=($desarrollo['Desarrollo']['etapa_desarrollo'] )?>">
                            </div>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <label for="basic-url" class="form-label"><strong>Torres</strong></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url"
                                        readonly
                                    aria-describedby="basic-addon3"
                                    value="<?=($desarrollo['Desarrollo']['torres'] )?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="basic-url" class="form-label"><strong>Unidades totales</strong></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url"
                                        readonly
                                    aria-describedby="basic-addon3"
                                    value="<?=($desarrollo['Desarrollo']['unidades_totales'] )?>">
                            </div>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <label for="basic-url" class="form-label"><strong>Departamento muestra</strong></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url"
                                        readonly
                                    aria-describedby="basic-addon3"
                                    value="<?=($desarrollo['Desarrollo']['departamento_muestra'] )?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="basic-url" class="form-label"><strong>Horario de atención</strong></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url"
                                        readonly
                                    aria-describedby="basic-addon3"
                                    value="<?=($desarrollo['Desarrollo']['horario_contacto'] )?>">
                            </div>
                        </div>
                        <hr>
                        <label for="basic-url" class="form-label"><strong>Fecha de entrega</strong></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="basic-url"
                                readonly aria-describedby="basic-addon3"
                                value="<?=( empty($desarrollo['Desarrollo']['fecha_entrega']) ? 'Inmediata' : $desarrollo['Desarrollo']['fecha_entrega'] )?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="aside col-sm-4 mt-5">
                <div id="map"></div>
            </div>
        </div>

        <!-- cards -->
        <div class="row">
            <div class="col-sm-4 mt-5" style="margin-bottom: 10px;">
                <div class=" p-3 bg-light rounded-2 border" style="height: 100%;">
                    <h5><b>LUGARES DE INTERÉS</b></h5>
                    <p>
                        <?php echo ($desarrollo['Desarrollo']['cc_cercanos']            == 1 ? '<div class="col-lg-12">Centros comerciales cercanos</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['cerca_playa']            == 1 ? '<div class="col-lg-12">Cerca de la playa</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['escuelas']               == 1 ? '<div class="col-lg-12">Escuelas cercanas</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['frente_parque']          == 1 ? '<div class="col-lg-12">Frente a parque</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['frente_playa']          == 1 ? '<div class="col-lg-12">Frente a playa</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['parque_cercano']         == 1 ? '<div class="col-lg-12">Parques cercanos</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['plazas_comerciales']     == 1 ? '<div class="col-lg-12">Plazas comerciales</div>' : "") ?>
                    </p>

                </div>
            </div>
            <div class="col-sm-4 mt-5" style="margin-bottom: 10px;">
                <div class=" p-3 bg-light rounded-2 border" style="height: 100%;">
                    <h5><b>AMENIDADES</b></h5>
                    <p>
                        <?php echo ($desarrollo['Desarrollo']['alberca_sin_techar']         == 1 ? '<div class="col-lg-12">Alberca descubierta</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['alberca_techada']            == 1 ? '<div class="col-lg-12">Alberca techada</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['sala_cine']                  == 1 ? '<div class="col-lg-12">Área de cine</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['juegos_infantiles']          == 1 ? '<div class="col-lg-12">Área de juegos infantiles</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['fumadores']                  == 1 ? '<div class="col-lg-12">Área para fumadores</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['areas_verdes']               == 1 ? '<div class="col-lg-12">Áreas verdes</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['asador']                     == 1 ? '<div class="col-lg-12">Asador</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['biblioteca']                     == 1 ? '<div class="col-lg-12">Biblioteca</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['cafeteria']                  == 1 ? '<div class="col-lg-12">Cafetería</div>' : "") ?>
                        
                        <?php echo ($desarrollo['Desarrollo']['camastros']                       == 1 ? '<div class="col-lg-12">Camastros</div>' : "") ?>

                        <?php echo ($desarrollo['Desarrollo']['golf']                       == 1 ? '<div class="col-lg-12">Campo de golf</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['paddle_tennis']              == 1 ? '<div class="col-lg-12">Cancha de paddle</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['squash']                     == 1 ? '<div class="col-lg-12">Cancha de squash</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['tennis']                     == 1 ? '<div class="col-lg-12">Cancha de tennis</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['cancha_petanca']             == 1 ? '<div class="col-lg-12">Cancha (petanca)</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['cancha_pickleball']          == 1 ? '<div class="col-lg-12">Cancha pickleball</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['carril_nado']                == 1 ? '<div class="col-lg-12">Carril de nado</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['ciclopista']                 == 1 ? '<div class="col-lg-12">Ciclopista</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['conserje']                   == 1 ? '<div class="col-lg-12">Concierge</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['coworking']                  == 1 ? '<div class="col-lg-12">Coworking</div>' : "") ?>
                        
                        <?php echo ($desarrollo['Desarrollo']['club_playa']                  == 1 ? '<div class="col-lg-12">Club de playa</div>' : "") ?>

                        <?php echo ($desarrollo['Desarrollo']['fire_pit']                   == 1 ? '<div class="col-lg-12">Fire pit</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['gimnasio']                   == 1 ? '<div class="col-lg-12">Gimnasio</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['helipuerto']                   == 1 ? '<div class="col-lg-12">Helipuerto</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['jacuzzi']                    == 1 ? '<div class="col-lg-12">Jacuzzi</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['living']                     == 1 ? '<div class="col-lg-12">Living</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['lobby']                      == 1 ? '<div class="col-lg-12">Lobby</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['ludoteca']                      == 1 ? '<div class="col-lg-12">Ludoteca</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['boliche']                    == 1 ? '<div class="col-lg-12">Mesa de boliche</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['pet_park']                    == 1 ? '<div class="col-lg-12">Pet park</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['pista_jogging']              == 1 ? '<div class="col-lg-12">Pista de jogging</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['play_room']                  == 1 ? '<div class="col-lg-12">Play room / Cuarto de juegos</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['pool_bar']                   == 1 ? '<div class="col-lg-12">Pool bar</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['restaurante']                == 1 ? '<div class="col-lg-12">Restaurante</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['roof_garden_compartido']     == 1 ? '<div class="col-lg-12">Roof garden</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['salon_juegos']               == 1 ? '<div class="col-lg-12">Salón de juegos</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['salon_usos_multiples']       == 1 ? '<div class="col-lg-12">Salón de usos múltiples</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['sauna']                      == 1 ? '<div class="col-lg-12">Sauna</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['spa_vapor']                  == 1 ? '<div class="col-lg-12">Spa / Vapor</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['vista_panoramica']           == 1 ? '<div class="col-lg-12">Vista panorámica</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['meditation_room']           == 1 ? '<div class="col-lg-12">Yoga / Meditation room</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['sky_garden']                 == 1 ? '<div class="col-lg-12">Sky garden</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['simulador_golf']             == 1 ? '<div class="col-lg-12">Simulador golf</div>' : "") ?>

                    </p>
                </div>
            </div>
            <div class="col-sm-4 mt-5" style="margin-bottom: 10px;">
                <div class=" p-3 bg-light rounded-2 border" style="height: 100%;">
                    <h5><b>SERVICIOS</b></h5>
                    <p>
                        <?php echo ($desarrollo['Desarrollo']['acceso_discapacitados']      == 1 ? '<div class="col-lg-12">Acceso de discapacitados</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['internet']                   == 1 ? '<div class="col-lg-12">Acceso Internet / WiFi</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['tercera_edad']               == 1 ? '<div class="col-lg-12">Acceso para Tercera Edad</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['aire_acondicionado']         == 1 ? '<div class="col-lg-12">Aire Acondicionado</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['business_center']            == 1 ? '<div class="col-lg-12">Business Center</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['calefaccion']                == 1 ? '<div class="col-lg-12">Calefacción</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['cctv']                       == 1 ? '<div class="col-lg-12">CCTV</div>' : "") ?>
                        <?php $certificaciones_led = array(1=>'Silver', 2=> 'Gold', 3=> 'Platinum'); ?>
                        <?php echo ($desarrollo['Desarrollo']['certificacion_led']                       == 1 ? '<div class="col-lg-12"> Certificación leed '.$certificaciones_led[$desarrollo['Desarrollo']['certificacion_led_opciones']].' </div>' : "") ?>


                        <?php echo ($desarrollo['Desarrollo']['cisterna']                   == 1 ? '<div class="col-lg-12">Cisterna</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['conmutador']                 == 1 ? '<div class="col-lg-12">Conmutador</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['edificio_inteligente']       == 1 ? '<div class="col-lg-12">Edificio Inteligente</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['edificio_leed']              == 1 ? '<div class="col-lg-12">Edificio LEED</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['elevadores']                 == 1 ? '<div class="col-lg-12">Elevadores</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-12">Estacionamiento de visitas</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['gas_lp']                     == 1 ? '<div class="col-lg-12">Gas LP</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['gas_natural']                == 1 ? '<div class="col-lg-12">Gas Natural</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['lavanderia']                 == 1 ? '<div class="col-lg-12">Lavanderia</div>' : "") ?>
                        
                        <?php echo ($desarrollo['Desarrollo']['mezzanine']                 == 1 ? '<div class="col-lg-12">Mezzanine</div>' : "") ?>

                        <?php echo ($desarrollo['Desarrollo']['locales_comerciales']        == 1 ? '<div class="col-lg-12">Locales Comerciales</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['mascotas']                   == 1 ? '<div class="col-lg-12">Permite Mascotas</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['planta_emergencia']          == 1 ? '<div class="col-lg-12">Planta de Emergencia</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['porton_electrico']           == 1 ? '<div class="col-lg-12">Portón Eléctrico</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['sistema_contra_incendios']   == 1 ? '<div class="col-lg-12">Sistema Contra Incendios</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['sistema_seguridad']          == 1 ? '<div class="col-lg-12">Sistema de Seguridad</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['valet_parking']              == 1 ? '<div class="col-lg-12">Valet Parking</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['vapor']                      == 1 ? '<div class="col-lg-12">Vapor</div>' : "") ?>
                        <?php echo ($desarrollo['Desarrollo']['seguridad']                  == 1 ? '<div class="col-lg-12">Vigilancia / Seguridad</div>' : "") ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- tarjeta -->
        <div class="card mb-3 bg-dark mt-5">
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
                        
                        <?php if( !empty($desarrollo['Desarrollo']['url_facebook']) AND !empty($rds_sociales['Cuenta']['url_facebook']) ): ?>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_facebook']) ? $desarrollo['Desarrollo']['url_facebook'] : $rds_sociales['Cuenta']['url_facebook'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/facebook.png" alt=" ">
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if( !empty($desarrollo['Desarrollo']['url_twitter']) AND !empty($rds_sociales['Cuenta']['url_twitter']) ): ?>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_twitter']) ? $desarrollo['Desarrollo']['url_twitter'] : $rds_sociales['Cuenta']['url_twitter'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/twitter.png" alt="">
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if( !empty($desarrollo['Desarrollo']['url_instagram']) AND !empty($rds_sociales['Cuenta']['url_instagram']) ): ?>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_instagram']) ? $desarrollo['Desarrollo']['url_instagram'] : $rds_sociales['Cuenta']['url_instagram'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/instagram.png" alt="">
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if( !empty($desarrollo['Desarrollo']['url_youtube']) AND !empty($rds_sociales['Cuenta']['url_youtube']) ): ?>
                            <div class="icon-social col">
                                <a href="<?= ( !empty($desarrollo['Desarrollo']['url_youtube']) ? $desarrollo['Desarrollo']['url_youtube'] : $rds_sociales['Cuenta']['url_youtube'] ) ?>" target="_blank">
                                    <img src="https://adryo.com.mx/assets/icons/youtube.png" alt="">
                                </a>
                            </div>
                        <?php endif; ?>

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
</div>

<?= $this->Html->script([
    'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0&callback=initMap'
    ], array('inline'=>false));
?>

<script>
    'use strict';
    // Funcion para copiar enlace
    function btnCopyClipboard() {

        var element = document.getElementById("rowSuccessCopyClipboard");
        element.classList.remove("d-none");

        var copyText = document.getElementById("btnCopyLink").value;
        navigator.clipboard.writeText(copyText).then(() => {

            window.setInterval(function(){

                element.classList.add("d-none");

            },2000);

        });
    }

    function initMap() {
        var uluru = {lat: <?= $latitud?>, lng: <?= $longitud?>};
        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: uluru
        });
        var marker = new google.maps.Marker({
        position: uluru,
        map: map
        });
    }

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
    // document.getElementById("defaultOpen").click();

    function srcChange( newURL ){
        document.getElementById("img-main").src = newURL;
    }

    function srcChangeFlat( newURL ){
        document.getElementById("img-flat").src = newURL;
    }


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.12/pdfobject.min.js"></script>
<script>PDFObject.embed("https://adryo.com.mx/<?= $desarrollo['Desarrollo']['brochure'] ?>", "#example1");</script>