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
</head>
<body class=" bootstrap bd-body-1 
 bd-homepage bd-pagebackground-3  bd-margins">
    <header class=" bd-headerarea-1 bd-margins">
    </header>
<div data-affix
     data-offset=""
     data-fix-at-screen="top"
     data-clip-at-control="top" data-enable-lg
     
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
  
    </div>
</div>
</div>
<?= $this->fetch('content')?>
</body>
</html>

 

