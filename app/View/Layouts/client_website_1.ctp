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
        
        <title><?= $cuenta['Cuenta']['nombre_comercial']?></title>
        
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
    <body class=" bootstrap bd-body-1 bd-homepage bd-pagebackground bd-margins">
        <header class=" bd-headerarea-1 bd-margins">
            <div data-affix data-offset="" data-fix-at-screen="top" data-clip-at-control="bottom" data-enable-lg data-enable-md data-enable-sm class=" bd-affix-2 bd-no-margins bd-margins ">
                <section class=" bd-section-4 bd-tagstyles  " id="section3" data-section-title="Top White with Three Containers">
                    <div class="bd-container-inner bd-margins clearfix">
                        <div class=" bd-layoutbox-3 bd-page-width  bd-no-margins clearfix">
                            <div class="bd-container-inner">
                                <div class=" bd-layoutbox-10 bd-no-margins bd-no-margins clearfix">
                                    <div class="bd-container-inner">
                                        <a href="">
                                            <?= $this->Html->image($cuenta['Cuenta']['logo_website'],array('class'=>'bd-imagestyles-8','style'=>'height: 80px;width: auto;'))?>
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
                                                                <?= $this->Html->link('Propiedades',array('action'=>'directorio',$cuenta['Cuenta']['sufix_website']))?>
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
	
        <section class=" bd-section-5 bd-page-width bd-tagstyles " id="section3" data-section-title="Page High Slider Header">
            <div class="bd-container-inner bd-margins clearfix">
                <div id="carousel-2" class="bd-slider-2 bd-background-width  bd-slider bd-no-margins  carousel slide bd-carousel-fade" >
                    <div class="bd-slides carousel-inner">
                        <div class=" bd-slide-2 bd-textureoverlay bd-textureoverlay-3 bd-slide item" style="background-image:url(/inmosystem<?= $this->fetch('img_1')?>)">
                            <div class="bd-container-inner">
                                <div class="bd-container-inner-wrapper">
                                    <div class=" bd-layoutbox-22 bd-no-margins clearfix">
                                        <div class="bd-container-inner">
                                            <div class=" bd-layoutbox-25 animated bd-animation-2 animated bd-animation-5 bd-no-margins clearfix" data-animation-name="fadeInDown,fadeOutUp" data-animation-event="slidein,slideout" data-animation-duration="900ms,700ms" data-animation-delay="0ms,0ms" data-animation-infinited="false,false">
                                                <div class="bd-container-inner">
                                                    <h2 class=" bd-textblock-6 bd-content-element">
                                                        <?= $this->fetch('titulo_1')?>
                                                    </h2>	
                                                    <h3 class=" bd-textblock-16 bd-content-element">
                                                       <?= $this->fetch('titulo_2')?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        /* <![CDATA[ */
                        if ('undefined' !== typeof initSlider) {
                            initSlider(
                                '.bd-slider-2',
                                {
                                    leftButtonSelector: 'bd-left-button',
                                    rightButtonSelector: 'bd-right-button',
                                    navigatorSelector: '.bd-carousel-1',
                                    indicatorsSelector: '.bd-indicators-2',
                                    carouselInterval: 3000,
                                    carouselPause: "hover",
                                    carouselWrap: true,
                                    carouselRideOnStart: true
                                }
                            );
                        }
                        /* ]]> */
                    </script>
                </div>
            </div>
        </section>
	
        <div class=" bd-stretchtobottom-1 bd-stretch-to-bottom" data-control-selector=".bd-contentlayout-1">
            <div class="bd-contentlayout-1 bd-page-width   bd-sheetstyles  bd-no-margins bd-margins" >
                <div class="bd-container-inner">
                    <div class="bd-flex-vertical bd-stretch-inner bd-no-margins">
                        <div class="bd-flex-horizontal bd-flex-wide bd-no-margins">
                            <div class="bd-flex-vertical bd-flex-wide bd-no-margins">
                                <div class=" bd-layoutitemsbox-1 bd-flex-wide bd-margins">
                                    <div class=" bd-content-13">
                                        <div class=" bd-htmlcontent-1 bd-margins" data-page-id="page.0">
                                            <section class=" bd-section-9 bd-tagstyles" id="section9" data-section-title="Section" style="background-image:url(/inmosystem<?= $this->fetch('img_2')?>)">
                                                <div class="bd-container-inner bd-margins clearfix">
                                                    <?= $this->Form->create('Cuenta',array('url'=>array('action'=>'propiedeades','controller'=>'cuentas'),'class'=>'bd-form-2'))?>    
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
                                                                                                    $venta = array('Renta'=>'Renta','Venta'=>'Venta','Venta / Renta' =>'Venta / Renta');
                                                                                                ?>
                                                                                                <?= $this->Form->input('venta_renta', array('type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta','label'=>false));?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=" bd-columnwrapper-14 col-sm-4">
                                                                                    <div class="bd-layoutcolumn-14 bd-column" >
                                                                                        <div class="bd-vertical-align-wrapper">
                                                                                            <div class=" bd-select-6 form-group">
                                                                                                <?= $this->Form->input('tipo_inmueble',array('empty'=>'Selecciona un tipo de inmueble','type'=>'select','class'=>'bd-form-input','options'=>$tipo_propiedades,'label'=>false))?>           
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=" bd-columnwrapper-106 col-sm-4">
                                                                                    <div class="bd-layoutcolumn-106 bd-column" >
                                                                                        <div class="bd-vertical-align-wrapper">
                                                                                            <?= $this->Form->end('Buscar',
                                                                                                    array('class'=>'bd-linkbutton-6  btn   btn-success  bd-own-margins bd-content-element','escape'=>false))
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
                                                    </form>
                                                </div>
                                            </section>
                                            
                                            <section id = "nosotros" class=" bd-section-11 bd-page-width bd-tagstyles bd-textureoverlay bd-textureoverlay-8 " id="section4" data-section-title="row with background image" style="background-image:url(/inmosystem<?= $this->fetch('img_3')?>)">
                                                <div class="bd-container-inner bd-margins clearfix">
                                                    <div class=" bd-layoutbox-32 bd-page-width  bd-no-margins bd-no-margins clearfix">
                                                        <div class="bd-container-inner">
                                                            <h1 class=" bd-textblock-38 bd-content-element">
                                                                ¿Quienes somos?
                                                            </h1>
                                                            <div class="bd-separator-4 bd-page-width bd-separator-center bd-separator-content-center clearfix" >
                                                                <div class="bd-container-inner">
                                                                    <div class="bd-separator-inner"></div>
                                                                </div>
                                                            </div>
                                                            <p class=" bd-textblock-43 bd-content-element">
                                                                <?= $this->fetch('somos')?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            
                                            <section class=" bd-section-12 bd-tagstyles bd-textureoverlay bd-textureoverlay-10" id="section3" data-section-title="Row Full Page Image Text Right" style="background-image:url(/inmosystem<?= $this->fetch('img_4')?>)">
                                                <div class="bd-container-inner bd-margins clearfix">
                                                    <div class=" bd-layoutbox-34 bd-no-margins bd-no-margins clearfix">
                                                        <div class="bd-container-inner">
                                                            <h2 class=" bd-textblock-46 bd-content-element">
                                                                <b>Vende</b>
                                                            </h2>
                                                            <h3 class=" bd-textblock-48 bd-content-element">
                                                                tu casa o departamento
                                                            </h3>
                                                            <p class=" bd-textblock-54 bd-content-element">
                                                                <?= $this->fetch('vende')?>
                                                            </p>
                                                            <a href="" class="bd-linkbutton-19  bd-button-20  bd-own-margins bd-content-element">
                                                                Contactar experto
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            
                                            <section class=" bd-section-15 bd-tagstyles bd-textureoverlay bd-textureoverlay-12" id="section3" data-section-title="Row Full Page Image Text Right" style="background-image:url(/inmosystem<?= $this->fetch('img_5')?>)">
                                                <div class="bd-container-inner bd-margins clearfix">
                                                    <div class=" bd-layoutbox-36 bd-no-margins bd-no-margins clearfix">
                                                        <div class="bd-container-inner">
                                                            <h2 class=" bd-textblock-72 bd-content-element">
                                                                <b>encuentra</b>
                                                            </h2>
                                                            <h3 class=" bd-textblock-71 bd-content-element">
                                                                la casa que quieres
                                                            </h3>
                                                            <p class=" bd-textblock-70 bd-content-element">
                                                                Visita nuestro catálogo de propiedades
                                                            </p>
                                                            <a href="" class="bd-linkbutton-21  bd-button-22  bd-own-margins bd-content-element">
                                                                ir a catálogo
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        
                                        </div>
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
                                                    <?= $cuenta['Cuenta']['texto_contacto']?>
                                                </p>
                                                <div class=" bd-spacer-3 clearfix"></div>
                                                <span class="bd-iconlink-3 bd-no-margins bd-own-margins bd-icon-57 bd-icon "></span>
                                                <p class=" bd-textblock-78 bd-content-element">
                                                    <?= $cuenta['Cuenta']['direccion']?>
                                                </p>
                                                <div class=" bd-spacer-10 clearfix"></div>
                                                <span class="bd-iconlink-8 bd-no-margins bd-own-margins bd-icon-64 bd-icon "></span>
                                                <p class=" bd-textblock-84 bd-content-element">
                                                    <?= $cuenta['Cuenta']['correo_contacto']?>
                                                </p>
                                                <div class=" bd-spacer-12 clearfix"></div>
                                                <span class="bd-iconlink-10 bd-no-margins bd-own-margins bd-icon-77 bd-icon "></span>
                                                <p class=" bd-textblock-122 bd-content-element">
                                                    <?= $cuenta['Cuenta']['telefono_1']?><br>
                                                    <?= $cuenta['Cuenta']['telefono_2']?>
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