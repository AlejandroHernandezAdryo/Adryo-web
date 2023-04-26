<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BOS Inmobiliaria</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
  	<!-- Theme style -->
    <?php echo $this->Html->css('http://bosinmobiliaria.com/sistema/css/AdminLTE.min.css'); ?>
    <?php echo $this->Html->css('http://bosinmobiliaria.com/sistema/css/bootstrap.min.css')?>
      <!-- iCheck -->
 
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
     
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body style="background-color: gainsboro">
      <?php echo $this->fetch('content'); ?>

      </body>
</html>
