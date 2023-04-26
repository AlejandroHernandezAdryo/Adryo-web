<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Impresión de inmueble</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
   
  	<!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.min'); ?>
      <!-- iCheck -->
 
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
     
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
                    * {
                    margin:0;
                    padding:0;
            }

            body {
                    background:#f2f2f2;
            }

            .main {
                    width:90%;
                    max-width:1000px;
                    margin:20px auto;
            }

            .slides {
                    width:100%;
            }

            .slides img {
                    width:100%;
            }

            .slidesjs-pagination {
                    background:#424242;
                    list-style:none;
                    overflow:hidden;
            }

            .slidesjs-pagination li {
                    float:left;
            }

            .slidesjs-pagination li a {
                    display:block;
                    padding:10px 20px;
                    color:#fff;
                    text-decoration:none;
            }

            .slidesjs-pagination li a:hover {
                    background:#000;
            }

            .slides .active {
                    background:#000;
            }

            .slidesjs-navigation{
                    background:#000;
                    color:#fff;
                    text-decoration:none;
                    display:inline-block;
                    padding:13.5px 20px;
                    float:right;
            }
            
            .carousel-inner > .item > img,
            .carousel-inner > .item > a > img {
                width: 60%;
                margin: auto;
            }
        
    </style>
  </head>
  <body onload="window.print();" class="hold-transition skin-blue sidebar-mini">
    
     
      
      <!-- Left side column. contains the logo and sidebar -->
      

      <!-- Content Wrapper. Contains page content -->
     <?php echo $this->fetch('content'); ?>
     

      <!-- Control Sidebar -->
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
   

    <!-- jQuery 2.1.4 -->
    
       
    <!-- Bootstrap 3.3.5 -->
    
     
     
  </body>
  
</html>

