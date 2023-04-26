<!DOCTYPE html>
<html dir="ltr">
    <head>
        <script>
            var themeHasJQuery = !!window.jQuery;
        </script>
        <script type="text/javascript" src="/inmosystem/websites/1/assets/js/jquery.js?1.0.673"></script>
        <script>
            window._$ = jQuery.noConflict(themeHasJQuery);
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/inmosystem/websites/1/assets/css/bootstrap.css?1.0.673" media="screen" />
        <script type="text/javascript" src="/inmosystem/websites/1/assets/js/bootstrap.min.js?1.0.673"></script>
        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/inmosystem/websites/1/assets/css/layout.ie.css?1.0.673">
        <script src="/inmosystem/websites/1/assets/js/layout.ie.js?1.0.673"></script>
        <![endif]-->
        <link class="" href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic&subset=latin' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="/inmosystem/websites/1/assets/js/layout.core.js"></script>
        <script src="/inmosystem/websites/1/assets/js/CloudZoom.js?1.0.673"></script>

        <title><?= $cuenta['Cuenta']['nombre_comercial'] ?></title>

        <link rel="stylesheet" href="/inmosystem/websites/1/assets/css/style.css?1.0.673">
        <script src="/inmosystem/websites/1/assets/js/script.js?1.0.673"></script>
        <meta charset="utf-8">

        <meta name="keywords" content="HTML, CSS, JavaScript">


        <style>
            a {
                transition: color 250ms linear;
            }
        </style>
    </head>
    <body class=" bootstrap bd-body-7  bd-pagebackground bd-margins">
        <header class=" bd-headerarea-1 bd-margins">
            <div data-affix data-offset="" data-fix-at-screen="top" data-clip-at-control="bottom" data-enable-lg data-enable-md data-enable-sm class=" bd-affix-2 bd-no-margins bd-margins ">
                <section class=" bd-section-4 bd-tagstyles  " id="section3" data-section-title="Top White with Three Containers">
                    <div class="bd-container-inner bd-margins clearfix">
                        <div class=" bd-layoutbox-3 bd-page-width  bd-no-margins clearfix">
                            <div class="bd-container-inner">
                                <div class=" bd-layoutbox-10 bd-no-margins bd-no-margins clearfix">
                                    <div class="bd-container-inner">
                                        <a href="">
                                            <?= $this->Html->image($cuenta['Cuenta']['logo'], array('class' => 'bd-imagestyles-8', 'style' => 'height: 80px;width: auto;')) ?>
                                        </a>
                                    </div>
                                </div>
                                <div class=" bd-layoutbox-13 bd-no-margins bd-no-margins clearfix">
                                    <div class="bd-container-inner">
                                        <nav class=" bd-hmenu-1" data-responsive-menu="true" data-responsive-levels="expand on click">
                                            <div class=" bd-responsivemenu-11 collapse-button">
                                                <div class="bd-container-inner">
                                                    <div class="bd-menuitem-4 ">
                                                        <a  data-toggle="collapse" data-target=".bd-hmenu-1 .collapse-button + .navbar-collapse" href="#" onclick="return false;">
                                                            <span>Menu</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="navbar-collapse collapse">
                                                <div class=" bd-horizontalmenu-92 clearfix">
                                                    <div class="bd-container-inner">
                                                        <ul class=" bd-menu-84 nav nav-pills navbar-left">
                                                            <li class="bd-menuitem-56 bd-toplevel-item">
                                                                <a href="/inmosystem/websites/1/inicio.html" >Inicio</a>
                                                            </li>
                                                            <li class=" bd-menuitem-56 bd-toplevel-item">                                
                                                                <a  href="#nosotros" >Nosotros</a>
                                                            </li>
                                                            <li class=" bd-menuitem-56 bd-toplevel-item">
                                                                <?= $this->Html->link('Propiedades', array('action' => 'directorio', $cuenta['Cuenta']['sufix_website'])) ?>
                                                            </li>
                                                            <li class=" bd-menuitem-56 bd-toplevel-item">
                                                                <a  href="#contacto" >Contacto</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </header>


        <div class=" bd-stretchtobottom-2 bd-stretch-to-bottom" data-control-selector=".bd-content-12"><div class=" bd-content-12 ">

                <div class=" bd-htmlcontent-2 bd-margins" 
                     data-page-id="page.15">
                    <section class=" bd-section-8 bd-tagstyles" id="section9" data-section-title="Section">
                        <div class="bd-container-inner bd-margins clearfix">
                            <?= $this->Form->create('Cuenta', array('url' => array('action' => 'directorio', 'controller' => 'cuentas',$cuenta['Cuenta']['sufix_website']), 'class' => 'bd-form-2')) ?>    
                            <div class="bd-container-inner">
                                <div class="container-fluid">
                                    <div class=" bd-layoutcontainer-6 bd-columns bd-no-margins">
                                        <div class="bd-container-inner">
                                            <div class="container-fluid">
                                                <div class="row ">
                                                    <div class=" bd-columnwrapper-6 col-sm-12">
                                                        <div class="bd-layoutcolumn-6 bd-column" >
                                                            <div class="bd-vertical-align-wrapper">
                                                                <h1 class=" bd-textblock-13 bd-content-element">
                                                                    Encuentra tu propiedad
                                                                </h1>
                                                            </div>
                                                        </div>
                                                    </div>          
                                                    <div class=" bd-columnwrapper-104 col-sm-4">
                                                        <div class="bd-layoutcolumn-104 bd-column">
                                                            <div class="bd-vertical-align-wrapper">
                                                                <div class=" bd-select-2 form-group">
                                                                    <?php
                                                                    $venta = array('Renta' => 'Renta', 'Venta' => 'Venta', 'Venta / Renta' => 'Venta / Renta');
                                                                    ?>
                                                                    <?= $this->Form->input('venta_renta', array('type' => 'select', 'options' => $venta, 'empty' => 'Selecciona si es renta o venta', 'label' => false)); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" bd-columnwrapper-14 col-sm-4">
                                                        <div class="bd-layoutcolumn-14 bd-column" >
                                                            <div class="bd-vertical-align-wrapper">
                                                                <div class=" bd-select-6 form-group">
                                                                    <?= $this->Form->input('tipo_inmueble', array('empty' => 'Selecciona un tipo de inmueble', 'type' => 'select', 'class' => 'bd-form-input', 'options' => $tipo_propiedades, 'label' => false)) ?>           
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" bd-columnwrapper-106 col-sm-4">
                                                        <div class="bd-layoutcolumn-106 bd-column" >
                                                            <div class="bd-vertical-align-wrapper">
                                                                <?=
                                                                $this->Form->end('Buscar', array('class' => 'bd-linkbutton-6  btn   btn-success  bd-own-margins bd-content-element', 'escape' => false))
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </section>

                    
                    <div class="bd-containereffect-3 container-effect container ">
                        <div class=" bd-layoutcontainer-14  bd-columns bd-no-margins">
                            <div class="bd-container-inner">
                                <div class="container-fluid">
                                    <div class="row ">
                                        <?php foreach ($propiedades as $propiedad):?>
                                        
                                        <div class=" bd-columnwrapper-47 col-sm-3">
                                            <div class="bd-layoutcolumn-47 bd-column" >
                                                <div class="bd-vertical-align-wrapper">
                                                    <a href="http://localhost/inmosystem/inmuebles/detalle/<?= $propiedad['Inmueble']['id']?>">
                                                    <?php 
                                                        if (sizeof($propiedad['FotoInmueble'])<1){
                                                            echo $this->Html->image('no_photo_inmuebles.png',array('class'=>'bd-imagelink-8 bd-own-margins bd-imagestyles'));
                                                        }else{
                                                            echo $this->Html->image($propiedad['FotoInmueble'][0]['ruta'],array('class'=>'bd-imagelink-8 bd-own-margins bd-imagestyles','style'=>'height:154px'));
                                                        }
                                                    ?>
                                                    </a>
                                                    <div class=" bd-layoutcontainer-17 bd-columns bd-no-margins">
                                                        <div class="bd-container-inner">
                                                            <div class="container-fluid">
                                                                <div class="row ">
                                                                    <div class=" bd-columnwrapper-65 col-sm-6">
                                                                        <div class="bd-layoutcolumn-65 bd-column" >
                                                                            <div class="bd-vertical-align-wrapper">
                                                                                <p class=" bd-textblock-51 bd-content-element">
                                                                                    <?= "$".  number_format($propiedad['Inmueble']['precio'],2)?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class=" bd-columnwrapper-70 col-sm-6">
                                                                        <div class="bd-layoutcolumn-70 bd-column" >
                                                                            <div class="bd-vertical-align-wrapper">
                                                                                <p class=" bd-textblock-50 bd-content-element">
                                                                                    <?= $propiedad['TipoPropiedad']['tipo_propiedad']?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class=" bd-columnwrapper-71 col-lg-12 col-sm-12">
                                                                        <div class="bd-layoutcolumn-71 bd-column" >
                                                                            <div class="bd-vertical-align-wrapper">
                                                                                <p class=" bd-textblock-52 bd-content-element">
                                                                                    <?= $propiedad['Inmueble']['titulo']?>
                                                                                </p>
                                                                                <p class=" bd-textblock-53 bd-content-element">
                                                                                    <?= $propiedad['Inmueble']['venta_renta'] ?>
                                                                                </p>
                                                                                <div class="row ">
                                                                                    <div class=" col-sm-6 col-md-3">
                                                                                        <?= $this->Html->image('m2.png',array('width'=>'50%'))?>
                                                                                    </div>
                                                                                    <div class=" col-sm-6 col-md-3">
                                                                                        <?= $propiedad['Inmueble']['construccion']."m2"?>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <?= $this->Html->image('autos.png',array('width'=>'50%'))?>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <?= $propiedad['Inmueble']['estacionamiento_techado']?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row ">
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <?= $this->Html->image('banios.png',array('width'=>'50%'))?>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <?= $propiedad['Inmueble']['banos']?>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <?= $this->Html->image('recamaras.png',array('width'=>'50%'))?>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <?= $propiedad['Inmueble']['recamaras']?>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach;?>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class=" bd-footerarea-1 bd-margins">
            <section class=" bd-section-2 bd-page-width bd-tagstyles bd-textureoverlay bd-textureoverlay-14 " id="contacto" data-section-title="Map Two Columns">
                <div class="bd-container-inner bd-margins clearfix">
                    <div class="bd-containereffect-6 container-effect container "><div class=" bd-layoutcontainer-9  bd-columns bd-no-margins">
                            <div class="bd-container-inner">
                                <div class="container-fluid">
                                    <div class="row bd-row-flex bd-row-align-middle">
                                        <div class=" bd-columnwrapper-13 col-sm-6">
                                            <div class="bd-layoutcolumn-13 bd-column" >
                                                <div class="bd-vertical-align-wrapper">
                                                    <h1 class=" bd-textblock-28 bd-content-element">Contacto</h1>
                                                    <p class=" bd-textblock-76 bd-content-element">
                                                        <?= $cuenta['Cuenta']['texto_contacto'] ?>
                                                    </p>
                                                    <div class=" bd-spacer-3 clearfix"></div>
                                                    <span class="bd-iconlink-3 bd-no-margins bd-own-margins bd-icon-57 bd-icon "></span>
                                                    <p class=" bd-textblock-78 bd-content-element">
                                                        <?= $cuenta['Cuenta']['direccion'] ?>
                                                    </p>
                                                    <div class=" bd-spacer-10 clearfix"></div>
                                                    <span class="bd-iconlink-8 bd-no-margins bd-own-margins bd-icon-64 bd-icon "></span>
                                                    <p class=" bd-textblock-84 bd-content-element">
                                                        <?= $cuenta['Cuenta']['correo_contacto'] ?>
                                                    </p>
                                                    <div class=" bd-spacer-12 clearfix"></div>
                                                    <span class="bd-iconlink-10 bd-no-margins bd-own-margins bd-icon-77 bd-icon "></span>
                                                    <p class=" bd-textblock-122 bd-content-element">
                                                        <?= $cuenta['Cuenta']['telefono_1'] ?><br>
                                                        <?= $cuenta['Cuenta']['telefono_2'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" bd-columnwrapper-23 col-sm-6">
                                            <div class="bd-layoutcolumn-23 bd-column" ><div class="bd-vertical-align-wrapper">
                                                    <div class="bd-googlemap-4 bd-own-margins bd-imagestyles-14 ">
                                                        <div class="embed-responsive" style="height: 100%; width: 100%;">
                                                            <iframe class="embed-responsive-item" src="//maps.google.com/maps?output=embed&q=Bos Estrategia Inmobiliaria&z=16&t=m&hl=English"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" bd-columnwrapper-28 col-sm-12">
                                            <div class="bd-layoutcolumn-28 bd-column" >
                                                <div class="bd-vertical-align-wrapper">
                                                    <img class="bd-imagelink-49 bd-own-margins bd-imagestyles   "  src="/inmosystem/websites/1/assets/images/900f1b108dcdd325ade8a27362b31968_logo_blanco.png">
                                                    <p class=" bd-textblock-134 bd-content-element">Página creada por Inmosystem | Todos los derechos reservados | 2018</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </footer>
    </body>
</html>