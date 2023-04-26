<?php 
  echo $this->Html->css(
    array(
        // Calendario
      '/vendors/inputlimiter/css/jquery.inputlimiter',
      '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
      '/vendors/jquery-tagsinput/css/jquery.tagsinput',
      '/vendors/daterangepicker/css/daterangepicker',
      '/vendors/datepicker/css/bootstrap-datepicker.min',
      '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
      '/vendors/bootstrap-switch/css/bootstrap-switch.min',
      '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
      '/vendors/j_timepicker/css/jquery.timepicker',
      '/vendors/datetimepicker/css/DateTimePicker.min',
    ),
    array('inline'=>false,'media'=>'print')); 
?>
<style>
	.text-black{
		color: black;
	}
	.card:hover{
		box-shadow: none;
	}

	footer{
    	padding-top: 20px;
    	padding-bottom: 0px;
    	margin-bottom: 0px;
    }

	/* Media para no imprimir */
	@media print
	{    
		body {
		  background-image: none;
		  /*background-repeat: no-repeat;
		  background-size: cover !important;*/
		}
		.bg-container {
		    background-color: rgb(255, 255, 255);
		}
		.bg-inner {
		    background-color: rgb(255, 255, 255);
		}
	    .no-imprimir, .no-imprimir *
	    {
	        display: none !important;
	    }

	    @page{
		   margin: 15px;
		}
	}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('User'); ?>
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-calendar"></i>
                  Fechas para reportes
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
            	<div class="col-sm-12">
            		<?= $this->Form->input('rango_fechas', array('class'=>'form-control', 'placeholder'=>'dd/mm/yyyy - dd/mm/yyyy', 'div'=>'col-sm-12', 'label'=>'Rango de fechas', 'id'=>'date_range', 'required'=>true, 'autocomplete'=>'off')); ?>
            	</div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
              </button>
              <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-search"></i>
                    Buscar
              </button>
          </div>
          <?= $this->Form->end(); ?>
      </div>
  </div>
</div>
<div class="modal fade" id="modalViewPdf" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('Cliente', array('url'=>array('controller'=>'clientes', 'action'=>'pdf_clientes_status_general.pdf'))); ?>
          <div class="modal-header bg-blue-is">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:white">
              		<i class="fa fa-info"></i>
                  	Alerta
              </h4>
          </div>
          <div class="modal-body">
          	<?= $this->Form->hidden('activos', array('value'=>$data_clientes_status['activos'])); ?>
          	<?= $this->Form->hidden('inactivos_temp', array('value'=>$data_clientes_status['inactivos_temp'])); ?>
          	<?= $this->Form->hidden('inactivos_def', array('value'=>$data_clientes_status['inactivos_temp'])); ?>
          	<div class="row">
          		<div class="col-sm-12 text-sm-center">
          			Saldra de la pagina actual para ir al reporte en formato PDF
          		</div>
          	</div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
              </button>
              <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-send"></i>
                    Aceptar
              </button>
          </div>
          <?= $this->Form->end(); ?>
      </div>
  </div>
</div>
<div id="content" class="bg-container">
<div class="outer">
    <div class="inner bg-light lter bg-container">
		<div class="row mt-3">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header" style="background-color: #2e3c54; color:white;">
						<div class="row">
							<div class="col-sm-12 col-lg-6">
								<h3 class="text-white">reporte de clientes</h3>
							</div>
							<div class="col-sm-12 col-lg-6 text-lg-right">
                                                             <?= $this->Html->link('<i class="fa  fa-print fa-2x"></i>',array('controller'=>'clientes','action'=>'reporte_c1'),array('escape'=>false, 'style'=>'color:white'))?>
								
							</div>
						</div>
					</div>
					<div class="card-block" style="padding-top: 10px;">
						<div class="row">
							<div class="col-sm-12 col-lg-3 mt-1">
								<img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>" alt="Logo cuenta" class="img-fluid">
							</div>
							<div class="col-sm-12 col-lg-6 mt-1">
								<h1 class="text-sm-center text-black">Reporte de Desempeño</h1>
								<p class="text-lg-center" style="font-size: 1rem;">
									<?= $this->Session->read('CuentaUsuario.Cuenta.razon_social') ?>
									<br>
									<?= $this->Session->read('CuentaUsuario.Cuenta.direccion') ?>
									<br>
									<?= $this->Session->read('CuentaUsuario.Cuenta.telefono_1') ?>
									<br>
									<?= $this->Html->link($this->Session->read('CuentaUsuario.Cuenta.pagina_web'), 'http://'.$this->Session->read('CuentaUsuario.Cuenta.pagina_web'), array('target'=>'_Blanck')) ?>
								</p>
							</div>
							<div class="col-sm-12 col-lg-3 mt-1">
								<p class="text-lg-right">
									Fecha
									<?= date('d/M/Y', strtotime($fecha_ini)).' al '.date('d/M/Y', strtotime($fecha_fin)) ?>
                                                                         <?= $this->Html->link('<i class="fa fa-calendar fa-lg"></i>', '#myModal', array('data-toggle'=>'modal', 'escape'=>false,'style'=>"color:green")) ?>
								</p>
							</div>
						</div>
						<!-- ./row hader  -->

						<div class="row mt-3">
							<div class="col-sm-12">
								<h3 class="text-black">
									Graficas de usuarios
								</h3>
								<hr class="mt-2">
							</div>
						</div>
						<div class="row" id="Status">
							<div class="col-sm-12">
								<div class="card mt-2">
								<div class="card-header" style="background-color: #2e3c54; color:white;">
									<i class="fa fa-users"></i> ESTATUS GENERAL DE CLIENTES
								</div>
								<div class="card-block">
									<div id="grafica_estatus_general_clientes" style="width: 100%; height: 300px;"></div>
									<div class="col-sm-12">
									<i>
										<small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
									</i>
									</div>
								</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header" style="background-color: #2e3c54; color:white;">
										<div class="row">
											<div class="col-sm-12 col-lg-6">
											<i class="ion-thermometer"></i> temperatura de clientes activos
											</div>
											<div class="col-sm-12 col-lg-6 text-lg-right">
												Total <?= $data_clientes_temp['frios']+$data_clientes_temp['tibios']+$data_clientes_temp['calientes'] ?>
											</div>
										</div>
									</div>
									<div class="card-block">
										<div id="grafica_clientes" style="width: 100%; min-height: 300px;"></div>
										<div class="col-sm-12">
											<i>
												<small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
											</i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header" style="background-color: #2e3c54; color:white;">
										<div class="row">
											<div class="col-sm-12 col-lg-8">
												<i class="fa fa-calendar"></i> ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
											</div>
											<div class="col-sm-12 col-lg-4 text-xs-right">
												Total: <?= $data_clientes_atencion['oportunos'] + $data_clientes_atencion['tardios'] + $data_clientes_atencion['no_atendidos'] + $data_clientes_atencion['por_reasignar']/* + $data_clientes_atencion['inactivos_temp']*/ ?>
											</div>
										</div>
									</div>
									<div class="card-block">
										<div id="grafica_atencion_clientes" style="width: 100%; min-height: 300px;"></div>
										<div class="col-sm-12">
											<i>
												<small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
											</i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-sm-12">
								<div class="card-header bg-blue-is">
									<div class="row">
									<div class="col-sm-12 col-lg-6">
										origen de clientes activos
									</div>
									<div class="col-sm-12 col-lg-6 text-lg-right">
										<?= "Total ".$countClientesOrigen ?>
									</div>
									</div>
								</div>
								<div class="card-block">
									<div id="origen_cientes_ventas" style="width: 100%; min-height: 300px;"></div>
									<div class="col-sm-12">
									<i>
										<small>INFORMACIÓN DE LOS CLIENTES DEL 01/01/<?= date('Y') ?> AL <?= date('d/m/Y') ?></small>
									</i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<footer>
			<div class="row mt-3">
				<div class="col-sm-12" style="background-color: #555555;">
					<p class="text-lg-center" style="color: white;">
						<br>
						POWERED BY <br><br>
						<img src="<?= Router::url('/img/logo_inmosystem.png',true) ?>" style="border: 0px; width: 80px; margin: 0px; height: 42px; width: auto;"><br> <br>
							<span style="color:#FFFFFF"><small>Todos los derechos reservados <?= date('Y')?></small></span>
					</p>
				</div>
			</div>
		</footer>
    </div>
</div>
</div>
<?php 
  echo $this->Html->script([
    'components',
    'custom',
    // Graficas de Google
    'https://www.gstatic.com/charts/loader.js',

    // Calendario
    '/vendors/jquery.uniform/js/jquery.uniform',
	'/vendors/inputlimiter/js/jquery.inputlimiter',
	'/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
	'/vendors/jquery-tagsinput/js/jquery.tagsinput',
	'/vendors/validval/js/jquery.validVal.min',
	'/vendors/inputmask/js/jquery.inputmask.bundle',
	'/vendors/moment/js/moment.min',
	'/vendors/daterangepicker/js/daterangepicker',
	'/vendors/datepicker/js/bootstrap-datepicker.min',
	'/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
	'/vendors/bootstrap-switch/js/bootstrap-switch.min',
	'/vendors/autosize/js/jquery.autosize.min',
	'/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
	'/vendors/jasny-bootstrap/js/inputmask',
	'/vendors/datetimepicker/js/DateTimePicker.min',
	'/vendors/j_timepicker/js/jquery.timepicker.min',
	'/vendors/clockpicker/js/jquery-clockpicker.min',

	'form',

  ], array('inline'=>false));
?>
<script>
// Funciones JS

$(document).ready(function () {
	$('#date_range').daterangepicker({
        orientation:"bottom",
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        return false;
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        return false;
    });

	google.charts.load('current', {'packages':['corechart']});

	google.charts.setOnLoadCallback(ClienteStatusGeneral);                  // Grafica de status de clientes
	google.charts.setOnLoadCallback(drawClientes);                          // Temperatura de clientes
	google.charts.setOnLoadCallback(atencionClientes);                      // Estado de los clientes
	google.charts.setOnLoadCallback(drawClientesLineasContacto);            // Origen clientes ventas mes


	// Grafica de status de clientes
function ClienteStatusGeneral(){
  var data = google.visualization.arrayToDataTable([
      ["Estado", "Cantidad", { role: "style" } ],
      ["ACTIVO", <?= $data_clientes_status['activos'] ?>, "#BF9000"],
      ["INACTIVO TEMPORAL", <?= $data_clientes_status['inactivos_temp'] ?>, "#7F6000"],
      // ["ACTIVO VENTA", <?= $data_clientes_status['ventas'] ?>, "#70AD47"],
      ["INACTIVO DEFINITIVO", <?= $data_clientes_status['inactivos_def'] ?>, "#000000"],
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);

    var options = {
      // title: "Estatus de atención a clientes",
      height: 300,
      titleTextStyle:{
      color:'#616161',
      fontSize: 14,
      textAlign: 'center',
      },
      backgroundColor:'transparent',
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      hAxis: {
          textStyle:{color: '#616161'}
      },
      vAxis: {
          textStyle:{color: '#616161'}
      }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("grafica_estatus_general_clientes"));

    google.visualization.events.addListener(chart, 'ready', function () {
		grafica_estatus_general_clientes.innerHTML = '<img src="' + chart.getImageURI() + '">';
		console.log(grafica_estatus_general_clientes.innerHTML);
	});
    chart.draw(view, options);
}

// Grafica para temperatura de clientes SaaK 03/09/2019 01:28:57 p. m.
function drawClientes(){
  var data = google.visualization.arrayToDataTable([
    ["Temperatura", "Cantidad"],
    ["Fríos", <?= $data_clientes_temp['frios']?>],
    ["Tibios", <?= $data_clientes_temp['tibios']?>],
    ["Calientes", <?= $data_clientes_temp['calientes']?>],
  ]);

  var options = {
    // height: 300,
    backgroundColor:'transparent',
    legend: {
      textStyle:{
        color   :'#000',
        fontSize: 14,
      }
    },
    pieStartAngle: 135,
    titleTextStyle:{
      color    :'#FFFFFF',
      fontSize : 14,
      textAlign: 'center',
    },
    bar: {groupWidth: "95%"},
    slices: {
      0: { color: '#5B9BD5' },
      1: { color: '#FFC000' },
      2: { color: '#C00000' },
    },
    hAxis: {
      textStyle:{color: '#FFFFFF'}
    },
    vAxis: {
      textStyle:{color: '#FFFFFF'}
    },
  };

  var chart = new google.visualization.PieChart(document.getElementById('grafica_clientes'));
  chart.draw(data, options);
  google.visualization.events.addListener(chart, 'select', selectTem);

  function selectTem(){
    var selection = chart.getSelection();
    // console.log(selection[0].row);

    if (selection[0].row == 0) {
      console.log('Seleccionaste los Frios');
    }
    if (selection[0].row == 1) {
      console.log('Seleccionaste los Tibios');
    }
    if (selection[0].row == 2) {
      console.log('Seleccionaste los Calientes');
    }
  }
}

// Atención de clientes
function atencionClientes(){
  var data = google.visualization.arrayToDataTable([
      ["Estado", "Cantidad", { role: "style" } ],
      ["Oportuna (Día 1 al <?= $this->Session->read('Parametros.Paramconfig.sla_oportuna')?>)", <?= $data_clientes_atencion['oportunos']?>, "#1F4E79"],
      ["Tardía (Día <?= $this->Session->read('Parametros.Paramconfig.sla_oportuna')+1?> al <?= $this->Session->read('Parametros.Paramconfig.sla_atrasados')?>)", <?= $data_clientes_atencion['tardios']?>, "#7030A0"],
      ["No Atendidos (Día <?= $this->Session->read('Parametros.Paramconfig.sla_atrasados')+1?> al <?= $this->Session->read('Parametros.Paramconfig.sla_no_atendidos')?>)", <?= $data_clientes_atencion['no_atendidos']?>, "#DA19CA"],
      ["Por Reasignar (+<?= $this->Session->read('Parametros.Paramconfig.sla_no_atendidos')?> días)", <?= $data_clientes_atencion['por_reasignar']?>, "#7F7F7F"],
      // ["Clientes inactivo temporal", <?= $data_clientes_atencion['inactivos_temp'] ?>, "#B58800"],
  ]);

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
     { calc: "stringify",
       sourceColumn: 1,
       type: "string",
       role: "annotation" },
     2]);

  var options = {
      title: "",
      height: 300,
      titleTextStyle:{
      fontSize: 12
  },
      backgroundColor:'transparent',
      bar: {groupWidth: "100%"},
      legend: { position: "none" },
  };
  var chart = new google.visualization.ColumnChart(document.getElementById("grafica_atencion_clientes"));
  chart.draw(view, options);
  google.visualization.events.addListener(chart, 'select', selectAtn);

  function selectAtn(){
    var selection = chart.getSelection();
    // console.log(selection[0].row);

    /*for (var i = 0; i < selection.length; i++) {
      var item = selection[i];
      console.log(item);
    }*/
    if (selection[0].row == 0) {
      console.log('Seleccionaste los Oportunos');
    }
    if (selection[0].row == 1) {
      console.log('Seleccionaste los Tardios');
    }
    if (selection[0].row == 2) {
      console.log('Seleccionaste los No atendidos');
    }
    if (selection[0].row == 3) {
      console.log('Seleccionaste los Por Reasignar');
    }
  }

}


// Origen de clientes
// Grafica de origen de clientes.
function drawClientesLineasContacto(){
  var data = google.visualization.arrayToDataTable([
      ['Forma de Contacto', 'Contactos'],
      <?php if (!empty($arregloCV)): ?>
        <?php foreach ($arregloCV as $CVOrigen): ?>
          ['<?= $CVOrigen['LineaContacto']['nombre_linea'] ?>', <?= $CVOrigen['LineaContacto']['count(clientes)'] ?>],
        <?php endforeach ?>
      <?php else: ?>
        ['',0,0,0]
      <?php endif; ?>
   ]);

 var options = {
   vAxes: 
   [
       
       {
           title: 'Contactos',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }, 
       {
           minValue: 0,
           maxValue: 11000,
           title: 'Inversión',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }
   ],
   hAxis: {title: 'Linea de contacto',textStyle:{color: '#616161'},titleTextStyle:{color: '#616161'},},
   height: 300,
   series: {
          0: {
              //Objetivo
              type: "bars",
              targetAxisIndex: 0,
              color: "orange"
          },
          1: {
              //Real
              type: "bars",
              targetAxisIndex: 0,
              color: "#70AD47"
          },
          2: { 
            //% de cumplimiento
              type: "line",
              targetAxisIndex: 1,
              color: "#12f7ff"
          },
      },   
   backgroundColor:'transparent',
   legend:{
        textStyle:{
            color:'#616161',
            fontSize: 13
        }
    },
  titleTextStyle:{
      color:'#616161',
      fontSize: 16
    },
   
 };

 var chart = new google.visualization.ComboChart(document.getElementById('origen_cientes_ventas'));
 chart.draw(data, options);

}


});
</script>