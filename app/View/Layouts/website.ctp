<!DOCTYPE html>
<html dir="ltr">
<head>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118323513-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-118323513-1');
        </script>

    
	<script>
    var themeHasJQuery = !!window.jQuery;
</script>
<?= $this->Html->script('/assets/js/jquery')?>

<script>
    window._$ = jQuery.noConflict(themeHasJQuery);
</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->Html->css('/assets/css/bootstrap', array('media'=>'screen'));?>
    <?= $this->Html->script('/assets/js/bootstrap.min')?>
    <?php
        echo $this->Html->meta ( 'favicon.ico', '/img/favicon.png', array (
            'type' => 'icon' 
        ) );
    ?>

<!--[if lte IE 9]>
<link rel="stylesheet" href="./assets/css/layout.ie.css?1.0.766">
<script src="./assets/js/layout.ie.js?1.0.766"></script>
<![endif]-->
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<?= $this->Html->script('/assets/js/layout.core')?>
<?= $this->Html->script('/assets/js/CloudZoom')?>
	
    <title>Home Page</title>
        <?= $this->Html->css('/assets/css/style');?>
        <?= $this->Html->script('/assets/js/script')?>
    <meta charset="utf-8">
    
    
    
 <meta name="keywords" content="HTML, CSS, JavaScript">

    
 <style>a {
  transition: color 250ms linear;
}
</style>
    <script src="//code.jivosite.com/widget.js" data-jv-id="fzkZKRYkSv" async></script>
</head>
<body class=" bootstrap bd-body-1 
 bd-homepage bd-pagebackground-3  bd-margins">
    <header class=" bd-headerarea-1 bd-margins">
        
</header>
	
		<section class=" bd-section-4 bd-page-width bd-tagstyles " id="section4" data-section-title="Section with Header and Slider">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutbox-3 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <div class=" bd-socialicons-2">
    
        <a target="_blank" data-social-url data-path-to-root="." class=" bd-socialicon-19 bd-socialicon"
   href="//www.facebook.com/sharer.php?u=facebook.com">
    <span class="bd-icon"></span><span></span>
</a>
    
        <a target="_blank" data-social-url data-path-to-root="." class=" bd-socialicon-20 bd-socialicon"
   href="//twitter.com/share?url=twitter.com&amp;text=">
    <span class="bd-icon"></span><span></span>
</a>
    
        <a target="_blank" data-social-url data-path-to-root="." class=" bd-socialicon-21 bd-socialicon"
   href="//plus.google.com/share?url=google.com">
    <span class="bd-icon"></span><span></span>
</a>
    
    
        <a target="_blank" data-social-url data-path-to-root="." class=" bd-socialicon-23 bd-socialicon"
   href="//linkedin.com/shareArticle?title=&amp;mini=true&amp;url=">
    <span class="bd-icon"></span><span></span>
</a>
    
    
    
    
    
    
</div>
    </div>
</div>
	
		<div data-affix
     data-offset=""
     data-fix-at-screen="top"
     data-clip-at-control="top"
     
 data-enable-lg
     
 data-enable-md
     
 data-enable-sm
     
     class=" bd-affix-1 bd-no-margins bd-margins "><div class=" bd-layoutbox-13  bd-no-margins clearfix">
    <div class="bd-container-inner">
        
            <?= $this->Html->link(
                    $this->Html->image(
                            '/assets/images/a785755a075d7cbac4fdc12ca1258cca_Logoinmolargo.png',
                            array('class'=>'bd-imagestyles-8')
                            ),
                    'https://adryo.com.mx',
                    array('escape'=>false,'class'=>'bd-logo-2')
                    )
                ?>
    
	
		
    
    <nav class=" bd-hmenu-1" data-responsive-menu="true" data-responsive-levels="expand on click">
        
            <div class=" bd-responsivemenu-11 collapse-button">
    <div class="bd-container-inner">
        <div class="bd-menuitem-4 ">
            <a  data-toggle="collapse"
                data-target=".bd-hmenu-1 .collapse-button + .navbar-collapse"
                href="#" onclick="return false;">
                    <span>Menu</span>
            </a>
        </div>
    </div>
</div>
            <div class="navbar-collapse collapse">
            
            <div class=" bd-horizontalmenu-70 clearfix">
                <div class="bd-container-inner">
                    
                    <ul class=" bd-menu-63 nav nav-pills navbar-left">
                        <li class=" bd-menuitem-36 bd-submenu-icon-only bd-toplevel-item">
                            <a  href="#" >Módulos</a>
                            <div class="bd-menu-39-popup ">
                                <ul class=" bd-menu-39  bd-no-margins">
                                    <li class=" bd-menuitem-38 bd-sub-item bd-sub-item">
                                        <?= $this->Html->link('Cartera de Clientes','../modulos/cartera-clientes')?>
                                    </li>
                                    <li class=" bd-menuitem-38 bd-sub-item bd-sub-item">
                                        <?= $this->Html->link('Corretaje','../modulos/corretaje')?>
                                    </li>
                                    <li class=" bd-menuitem-38 bd-sub-item bd-sub-item">
                                        <?= $this->Html->link('Desarrollos','../modulos/desarrollos')?>
                                    </li>
                                    <li class=" bd-menuitem-38 bd-sub-item bd-sub-item">
                                        <?= $this->Html->link('Desarrolladores','../modulos/desarrolladores')?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class=" bd-menuitem-36 bd-toplevel-item">
                            <?= $this->Html->link('Nosotros','../nosotros')?>
                        </li>
                        <li class=" bd-menuitem-36 bd-toplevel-item">
                            <?= $this->Html->link('Solicita una Prueba','../solicita-prueba')?>
                        </li>
                        <li class=" bd-menuitem-36 bd-toplevel-item">
                            <?= $this->Html->link('Planes','../planes')?>
                        </li>
                        <li class=" bd-menuitem-36 bd-toplevel-item">
                            <?= $this->Html->link('Contacto','../contacto')?>
                        </li>
                        <li class=" bd-menuitem-36 bd-toplevel-item">
                            <?= $this->Html->link('Login','../login')?>
                        </li>
                    </ul>
                    
                </div>
            </div>
            
        
            </div>
    </nav>
    </div>
</div>
</div>
<?= $this->fetch('content')?>
<footer class=" bd-footerarea-1 bd-margins">
<!--        <section class=" bd-section-5 bd-page-width bd-tagstyles " id="section4" data-section-title="Two Thirds">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-10 bd-page-width  bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row 
 bd-row-flex 
 bd-row-align-middle">
                <div class=" bd-columnwrapper-27 
 col-sm-7">
    <div class="bd-layoutcolumn-27 bd-column" ><div class="bd-vertical-align-wrapper"><h1 class=" bd-textblock-77 bd-content-element">
    Quiero SOLICITAR una prueba
</h1>
	
		<p class=" bd-textblock-81 bd-content-element">
    Comience solicitando una prueba de nuestra plataforma completamente gratis. Inscríbase o reciba una llamada de nuestros ejecutivos,
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-29 
 col-sm-5">
    <div class="bd-layoutcolumn-29 bd-column" ><div class="bd-vertical-align-wrapper"><a 
 href="" class="bd-linkbutton-17 bd-no-margins  bd-button-13 bd-icon bd-icon-50 bd-own-margins bd-content-element"    >
    Solicitar una llamada
</a>
	
		<a 
 href="" class="bd-linkbutton-20 bd-no-margins  bd-button-25 bd-icon bd-icon-55 bd-own-margins bd-content-element"    >
    Registrarse
</a></div></div>
</div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>-->
	
		<section class=" bd-section-2 bd-page-width bd-tagstyles " id="section4" data-section-title="Footer Four Columns Dark">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-7 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row 
 bd-row-flex 
 bd-row-align-top">
                <div class=" bd-columnwrapper-12 
 col-md-3
 col-sm-6">
    <div class="bd-layoutcolumn-12 bd-column" ><div class="bd-vertical-align-wrapper"><h2 class=" bd-textblock-1 bd-no-margins bd-content-element">
    Adryo
</h2>
	
		<div class=" bd-spacer-3 clearfix"></div>
	
		<p class=" bd-textblock-8 bd-content-element">
    La mejor plataforma en línea para le gestión de negocios inmobiliarios, corretaje y contstrucción.&nbsp;<br><br><br><?= date("Y")?> Todos los derechos Reservados<br>Inmosystec S.A. de C.V.
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-17 
 col-md-3
 col-sm-6">
    <div class="bd-layoutcolumn-17 bd-column" ><div class="bd-vertical-align-wrapper"><h2 class=" bd-textblock-18 bd-no-margins bd-content-element">
    Módulos
</h2>
	
		<div class=" bd-spacer-8 clearfix"></div>
	
		<p class=" bd-textblock-6 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Cartera de Clientes','../modulos/cartera-clientes')?>
    
</p>
	
		<div class="bd-separator-4  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-22 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Corretaje','../modulos/corretaje')?>
    
</p>
	
		<div class="bd-separator-2  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-32 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Desarrollos','../modulos/desarrollos')?>
    
</p>
	
		<div class="bd-separator-6  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-41 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Desarrolladores','../modulos/desarrolladores')?>
    
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-21 
 col-md-3
 col-sm-6">
    <div class="bd-layoutcolumn-21 bd-column" ><div class="bd-vertical-align-wrapper"><h2 class=" bd-textblock-49 bd-no-margins bd-content-element">
    otras
</h2>
	
		<div class=" bd-spacer-12 clearfix"></div>
	
		<p class=" bd-textblock-51 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Nosotros','../nosotros')?>
    
</p>
<div class="bd-separator-10  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>

	
		<p class=" bd-textblock-55 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Planes','../planes')?>
    
</p>
	
<!--		<div class="bd-separator-8  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-9 bd-no-margins bd-content-element">
    <a href="#">Planes</a>
</p>
	
		<div class="bd-separator-7  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-53 bd-no-margins bd-content-element">
    <a href="#">Aviso de Privacidad</a>
</p>-->
	
		<div class="bd-separator-10  bd-separator-center bd-separator-content-center clearfix" >
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-55 bd-no-margins bd-content-element">
                    <?= $this->Html->link('Contacto','../contacto')?>
    
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-25 
 col-md-3
 col-sm-6">
    <div class="bd-layoutcolumn-25 bd-column" ><div class="bd-vertical-align-wrapper"><h2 class=" bd-textblock-59 bd-no-margins bd-content-element">
    Contacto
</h2>
	
		<div class=" bd-spacer-15 clearfix"></div>
	
		<div class=" bd-layoutbox-10 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <span class="bd-iconlink-2 bd-own-margins bd-icon-37 bd-icon "></span>
	
		<p class=" bd-textblock-61 bd-no-margins bd-content-element">
    Carretera Picacho Ajusco 130 Piso 1 Of. 102, Jardines en la Montaña, CDMX
</p>
    </div>
</div>
	
		<div class=" bd-spacer-17 clearfix"></div>
	
		<div class=" bd-layoutbox-15 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <span class="bd-iconlink-5 bd-own-margins bd-icon-44 bd-icon "></span>
	
		<p class=" bd-textblock-65 bd-no-margins bd-content-element">
    +52 (55) 6283 0329
</p>
    </div>
</div>
	
		<div class=" bd-spacer-19 clearfix"></div>
	
		<div class=" bd-layoutbox-20 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <span class="bd-iconlink-7 bd-own-margins bd-icon-46 bd-icon "></span>
	
		<p class=" bd-textblock-69 bd-no-margins bd-content-element">
    contacto@adryo.com.mx<br>adryo.com.mx
</p>
    </div>
</div></div></div>
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

 
