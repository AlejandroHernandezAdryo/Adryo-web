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
  <!-- fullCalendar 2.2.5-->
      
    <?php echo $this->Html->css('plugins/daterangepicker/daterangepicker-bs3'); ?>
    <?php echo $this->Html->css('plugins/iCheck/all'); ?>
    <?php echo $this->Html->css('plugins/timepicker/bootstrap-timepicker.min'); ?>
    <?php echo $this->Html->css('plugins/select2/select2.min'); ?>
    <?php echo $this->Html->css('plugins/fullcalendar/fullcalendar.min'); ?>
    <?php echo $this->Html->css('plugins/fullcalendar/fullcalendar.print',array('media'=>'print')); ?>
  
  
  <!-- Theme style -->
  <?php echo $this->Html->css('AdminLTE.min'); ?>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <?php echo $this->Html->css('skins/_all-skins.min'); ?>
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
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
              
            </li>
            -->
            <li class="treeview">
              <a href="#">
               <i class="fa fa-calendar"></i><span>Calendario</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span>Ver calendario</span>',array('controller'=>'users','action'=>'calendar'),array('escape'=>false))?></li>
              </ul>
            </li> 
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
                <?php } ?>
                <?php if ($this->Session->read('Auth.User.Group.ur')==1){?>
              <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Usuarios',array('controller'=>'users','action'=>'index'),array('escape'=>false))?></li>
                
              </ul>
            </li>
            <?php } ?>
          <!--  
	  <li class="treeview">
          <a href="mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><?php echo $this->Html->link('Buzón de entrada',array('controller'=>'users','action'=>'mailbox'))?></li>
            <li><a href="compose.html">Compose</a></li>
            <li><a href="read-mail.html">Read</a></li>
          </ul>
        </li>
          -->
          </ul>
          <?php if (isset($usuarios)){?>
          <div style="width:100%; padding: 40px;">
          <table style="width: 100%">
              
              <tr>
                  <td style="font-size:.8em;">Actividad Propia</td>
                  <td style="background-color: <?= $this->Session->read('Auth.User.color')?>">&nbsp;&nbsp;&nbsp;</td>
              </tr>
              <tr>
                  <td style="font-size:.8em;">Gerentes</td>
                  <td style="background-color: #006837">&nbsp;&nbsp;&nbsp;</td>
              </tr>
              <tr>
                  <td style="font-size:.8em;">Asesores</td>
                  <td style="background-color: #0071bc">&nbsp;&nbsp;&nbsp;</td>
              </tr>
              <tr>
                  <td style="font-size:.8em;">Auxiliares</td>
                  <td style="background-color: #eab303">&nbsp;&nbsp;&nbsp;</td>
              </tr>
              
          </table>
          </div>
          <?php }?>
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

      
   <?php 
   $colores = array(
       ''
   );
   ?>
   <?php echo $this->Html->script('plugins/jQuery/jQuery-2.1.4.min')?>
<!-- Bootstrap 3.3.5 -->
<?php echo $this->Html->script('bootstrap.min')?>
<?php echo $this->Html->script('plugins/select2/select2.full.min')?>
<?php echo $this->Html->script('plugins/input-mask/jquery.inputmask')?>
<?php echo $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions')?>
<?php echo $this->Html->script('plugins/input-mask/jquery.inputmask.extensions')?>
<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js')?>
<?php echo $this->Html->script('plugins/daterangepicker/daterangepicker')?>
<?php echo $this->Html->script('plugins/timepicker/bootstrap-timepicker.min')?>
<?php echo $this->Html->script('plugins/iCheck/icheck.min')?>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<?php echo $this->Html->script('plugins/slimScroll/jquery.slimscroll.min')?>

<!-- FastClick -->
<?php echo $this->Html->script('plugins/fastclick/fastclick.min')?>
<!-- AdminLTE App -->
<?php echo $this->Html->script('app.min')?>
<!-- AdminLTE for demo purposes -->
<?php echo $this->Html->script('demo')?>
<!-- fullCalendar 2.2.5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<?php echo $this->Html->script('plugins/fullcalendar/fullcalendar.min')?>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día'
      },
      //Random default events
      events: [
        
     <?php 
        foreach ($eventos as $evento):
            $diaI = date('d',  strtotime($evento['Event']['fecha_inicio']));
            $mesI = date('m',  strtotime($evento['Event']['fecha_inicio']));
            $anoI = date('Y',  strtotime($evento['Event']['fecha_inicio']));
            $horaI =date('H',  strtotime($evento['Event']['fecha_inicio']));
            $minI = date('i',  strtotime($evento['Event']['fecha_inicio']));
        
            $diaF = date('d',  strtotime($evento['Event']['fecha_fin']));
            $mesF = date('m',  strtotime($evento['Event']['fecha_fin']));
            $anoF = date('Y',  strtotime($evento['Event']['fecha_fin']));
            $horaF = date('H',  strtotime($evento['Event']['fecha_fin']));
            $minF = date('i',  strtotime($evento['Event']['fecha_fin']));
            
            //$color = ($evento['Event']['to']==$this->Session->read('Auth.User.id')?"red":$colores[$evento['Event']['to']]);
            //$color = "green"; 
            echo "{"
            . "title: '".$evento['Event']['nombre_evento']." / ".$evento['Event']['comentarios']."', "
            . "start: new Date($anoI,$mesI-1,$diaI,$horaI,$minI),"
            . "end: new Date($anoF,$mesF-1,$diaF,$horaF,$minF),"
            . "backgroundColor: '".$evento['To']['color']."'," //red
            . "url: '/sistema/events/edit/".$evento['Event']['id']."'," //red    
            . "borderColor: '".$evento['To']['color']."',"
            ."},";
        endforeach;
     ?>
        
      ],
      editable: true,
      droppable: false, // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
  </body>
  
</html>

