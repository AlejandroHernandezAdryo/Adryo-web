<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BOS Inmobiliaria</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
   <?php echo $this->Html->script('plugins/jQuery/jQuery-2.1.4.min') ?>

    
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('bootstrap.min'); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <?php echo $this->Html->css('plugins/daterangepicker/daterangepicker-bs3'); ?>
  	<!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.min'); ?>
      <!-- iCheck -->
  <?php echo $this->Html->css('plugins/iCheck/square/blue'); ?>
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <?php echo $this->Html->css('skins/_all-skins.min'); ?>
    <?php echo $this->Html->css('/plugins/select2/select2.min'); ?>
    <?php echo $this->Html->css('/plugins/datatables/dataTables.bootstrap'); ?>
    
     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    #map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 100%;
    height: 100%;
}
    
</style>

  </head>
  <body class="hold-transition skin-yellow-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><?php echo $this->Html->image('logo_mini.png',array('width'=>'70%'))?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" > <?php echo $this->Html->image('logo.png',array('width'=>'70%'))?> </span>
         
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  
                  <span class="hidden-xs"><?php echo $this->Session->read('Auth.User.nombre_completo')?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                  	
                    
                    <p>
                      <?php echo $this->Session->read('Auth.User.nombre_completo')?>
                      
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    <?php echo $this->Html->link('Cambiar contraseña', array('controller'=>'users','action'=>'cambiar_contrasena',$this->Session->read('Auth.User.id')),array('class'=>'btn btn-default btn-flat'))?>
                      
                    </div>
                    <div class="pull-right">
                      <?php echo $this->Html->link('Cerrar Sesión', array('controller'=>'users','action'=>'logout'),array('class'=>'btn btn-default btn-flat'))?>
                      
                    </div>
                  </li>
                </ul>
              </li>
              
              <!-- Control Sidebar Toggle Button -->
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            
            <div class="pull-left info">
              <p><?php echo $this->Session->read('Auth.User.nombre_completo')?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Disponible</a>
            </div>
          </div>
          <!-- search form -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENÚ PRINCIPAL</li>
            <li class="treeview">
              <?php echo $this->Html->link('<i class="fa fa-home"></i>Mis Propiedades',array('controller'=>'users','action'=>'mysession'),array('escape'=>false))?>
              </a>
              
            </li>
            <li class="treeview">
              <?php echo $this->Html->link('<i class="fa fa-paper-plane"></i>Mis Tickets',array('controller'=>'tickets','action'=>'index_cliente'),array('escape'=>false))?>
              </a>
              
            </li>
            </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        

        <!-- Main content -->
        <pre><?php //echo var_dump($this->Session->read('notificaciones'))?></pre> 
          <?php echo $this->Session->flash(); ?>
          <?php echo $this->fetch('content'); ?>
       
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <?php echo date("Y")?> <a href="http://aigelbs.com">Aigel</a>.</strong> Todos los derechos reservados.
      </footer>

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    
       
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->script('bootstrap.min')?>
    <!-- FastClick -->
    <?php echo $this->Html->script('plugins/fastclick/fastclick.min')?>
    <!-- AdminLTE App -->
    <?php echo $this->Html->script('app.min')?>
    <!-- AdminLTE for demo purposes -->
    <?php echo $this->Html->script('demo')?>
     <!-- FastClick -->
    <?php echo $this->Html->script('plugins/iCheck/icheck.min.js')?>
  </body>
  <script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</html>

