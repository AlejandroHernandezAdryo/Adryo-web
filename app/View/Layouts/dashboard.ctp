<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BOS Inmobiliaria</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('bootstrap.min'); ?>
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
    <?php echo $this->Html->css('skins/_all-skins.min'); ?>
    
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
                  <?php echo $this->Html->image($this->Session->read('Auth.User.foto'),array('class'=>'user-image'))?>
                  <span class="hidden-xs"><?php echo $this->Session->read('Auth.User.nombre_completo')?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                  	<?php echo $this->Html->image($this->Session->read('Auth.User.foto'),array('class'=>'img-circle'))?>
                    
                    <p>
                      <?php echo $this->Session->read('Auth.User.nombre_completo')?>
                      <small>Miembro desde nov. 2015</small>
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
            <div class="pull-left image">
              <?php echo $this->Html->image($this->Session->read('Auth.User.foto'),array('class'=>'img-circle'))?>
            </div>
            <div class="pull-left info">
              <p><?php echo $this->Session->read('Auth.User.nombre_completo')?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Disponible</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENÚ PRINCIPAL</li>
            
                <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span>Tablero</span>',array('controller'=>'users','action'=>'dashboard'),array('escape'=>false))?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span class="link-title menu_hide">Tablero Agente</span>',array('controller'=>'users','action'=>'dashboard_agente'),array('escape'=>false))?></li>
            <li class="treeview">
              <a href="#">
               <i class="fa fa-calendar"></i><span>Calendario</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span>Ver calendario</span>',array('controller'=>'users','action'=>'calendar'),array('escape'=>false))?></li>
              </ul>
            </li> 
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
              
            </li>
            -->
            <li class="treeview">
              <a href="#">
               <i class="fa fa-home"></i><span>Propiedades</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if ($this->Session->read('Auth.User.Group.ic')==1){?>
                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Propiedad</span>',array('controller'=>'inmuebles','action'=>'add'),array('escape'=>false))?></li>
                <?php }?>
                <?php if ($this->Session->read('Auth.User.Group.ir')==1){?>
              <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Propiedades',array('controller'=>'inmuebles','action'=>'index'),array('escape'=>false))?></li>
                <?php } ?>
              </ul>
            </li>
            
            <li class="treeview">
              <a href="#">
               <i class="fa fa-building"></i><span>Desarrollos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if ($this->Session->read('Auth.User.Group.dc')==1){?>
                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Desarrollo</span>',array('controller'=>'desarrollos','action'=>'add'),array('escape'=>false))?></li>
                <?php } ?>
                <?php if ($this->Session->read('Auth.User.Group.dr')==1){?>
              <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Desarrollos',array('controller'=>'desarrollos','action'=>'index'),array('escape'=>false))?></li>
                <?php } ?>
              </ul>
            </li>
            
            <li class="treeview">
              <a href="#">
               <?php if ($this->Session->read('Auth.User.group_id')!=3){?>
               <i class="fa fa-user"></i><span>Clientes: <?= $this->Session->read('clundef')?></span>
               <?php 
                    }else{
               ?>
               <i class="fa fa-user"></i><span>Clientes</span>
                    <?php }?>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if ($this->Session->read('Auth.User.Group.cc')==1){?>
                <li><?php echo $this->Html->link('<i class="fa fa-user-plus"></i><span>Agregar Cliente</span>',array('controller'=>'clientes','action'=>'add'),array('escape'=>false))?></li>
                <?php } ?>
                <?php if ($this->Session->read('Auth.User.Group.call')==1 || $this->Session->read('Auth.User.Group.cown')){?>
              <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Clientes',array('controller'=>'clientes','action'=>'index'),array('escape'=>false))?></li>
                <?php } ?>
                <?php if ($this->Session->read('Auth.User.Group.id')!=3){?>
                <li><?php echo $this->Html->link('<i class="fa fa-home"></i><span>Sin Asignar Corretaje</span>',array('controller'=>'clientes','action'=>'sinasignar',1),array('escape'=>false))?></li>
                <li><?php echo $this->Html->link('<i class="fa fa-building"></i><span>Sin Asignar Desarrollos</span>',array('controller'=>'clientes','action'=>'sinasignar',2),array('escape'=>false))?></li>
                
                <?php } ?>
              </ul>
            </li>
            <?php if ($this->Session->read('Auth.User.Group.uc')==1){?>
            <li class="treeview">
              <a href="#">
               <i class="fa fa-users"></i><span>Usuarios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                
                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Usuario</span>',array('controller'=>'users','action'=>'add'),array('escape'=>false))?></li>
                <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Usuarios',array('controller'=>'users','action'=>'index'),array('escape'=>false))?></li>
                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Cliente/Desarrollador</span>',array('controller'=>'users','action'=>'add_cliente'),array('escape'=>false))?></li>
                <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Clientes/Desarrolladores',array('controller'=>'users','action'=>'list_clientes'),array('escape'=>false))?></li>
              </ul>
            </li>
            <?php } ?>
           
	  
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
    </div>
      
     

    
       
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->script('plugins/jQuery/jQuery-2.1.4.min')?>
    <?php echo $this->Html->script('bootstrap.min')?>
    <?php echo $this->Html->script('plugins/chartjs/Chart.min')?>
    <!-- FastClick -->
    <?php echo $this->Html->script('plugins/fastclick/fastclick.min')?>
    <!-- AdminLTE App -->
    <?php echo $this->Html->script('app.min')?>
    <!-- AdminLTE for demo purposes -->
    <?php echo $this->Html->script('demo')?>
     <!-- FastClick -->
    <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#leads").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    
    var pieChartCanvasC = $("#clientes").get(0).getContext("2d");
    var pieChartC = new Chart(pieChartCanvasC);
    
    var pieChartCanvasI = $("#inmuebles").get(0).getContext("2d");
    var pieChartI = new Chart(pieChartCanvasI);
    
    var pieChartCanvasL = $("#liberadas").get(0).getContext("2d");
    var pieChartL = new Chart(pieChartCanvasL);
    
    var PieData_Leads = [
      {
        value: <?= $cerrados?>,
        color: "#f56954",
        highlight: "#f56954",
        label: "Cerrados"
      },
      {
        value: <?= $aprobados?>,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "Aprobados"
      },
      {
        value: <?= $abiertos?>,
        color: "#f39c12",
        highlight: "#f39c12",
        label: "Abiertos"
      },
      
    ];

    var tiposClientes = [
       <?php
            $i = 0;
            $colores = array('#f56954','#00a65a','#f39c12','silver','purple','blue');
            foreach($clientes as $cliente):
       ?>
            {
                value: <?= $cliente[0]['count(status)']?>,
                color: "<?= $colores[$i]?>",
                highlight: "<?= $colores[$i]?>",
                label: "<?= $cliente['clientes']['status']?>"
            },         
       <?php
            $i++;
            endforeach;
       ?>
    ];
    
    var inmuebles = [
       <?php
            $i = 0;
            $colores = array('#f56954','#00a65a','#f39c12','silver','purple','blue','yellow','red');
            foreach($inmuebles as $inmueble):
       ?>
            {
                value: <?= $inmueble[0]['COUNT(tipo_propiedad)']?>,
                color: "<?= $colores[$i]?>",
                highlight: "<?= $colores[$i]?>",
                label: "<?= $inmueble['inmuebles']['tipo_propiedad']?>"
            },         
       <?php
            $i++;
            endforeach;
       ?>
    ];
    
    var liberadas = [
       <?php
            
            $colores = array(0=>'#fcee21',1=>'#39b54a',2=>'#fbb03b',3=>'#29abe2',4=>'#c1272d',5=>'#c1272d');
            $libe = array (0=>'No Liberada', 1=>'Libre',2=>'Reservado',3=>'Contrato',4=>'Escrituración',5=>'Baja');
            foreach($liberadas as $liberada):
                $liberada_label = $libe[$liberada['inmuebles']['liberada']];
       ?>
            {
                value: <?= $liberada[0]['COUNT(liberada)']?>,
                color: "<?= $colores[$liberada['inmuebles']['liberada']]?>",
                highlight: "<?= $colores[$liberada['inmuebles']['liberada']]?>",
                label: "<?= $liberada_label?>"
            },         
       <?php
            $i++;
            endforeach;
       ?>
    ];
    
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData_Leads, pieOptions);
    pieChartC.Doughnut(tiposClientes, pieOptions);
    pieChartI.Doughnut(inmuebles, pieOptions);
    pieChartL.Doughnut(liberadas, pieOptions);

    //-------------
    //- BAR CHART -
    //-------------
    

    
  });
</script>
  </body>
  
 </html>
