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
    array('inline'=>false)); 
?>
<style>
	.text-black{
		color: black;
	}
	.card:hover{
		box-shadow: none;
	}

	/* Media para no imprimir */
	@media print
	{    
	    .no-imprimir, .no-imprimir *
	    {
	        display: none !important;
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
<div class="outer">
    <div class="inner bg-light lter bg-container">
		<div class="row mt-3">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header" style="background-color: #2e3c54; color:white;">
						<div class="row">
							<div class="col-sm-12 col-lg-6">
								<h3 class="text-white">Reportes gerenciales</h3>
							</div>
							<div class="col-sm-12 col-lg-6 text-lg-right no-imprimir">
								<?= $this->Html->link('Eligir fechas para el reporte', '#myModal', array('data-toggle'=>'modal', 'class'=>'text-white')) ?>
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
									<?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?>
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
						<div class="row" id="StatusYTemp">
						<div class="col-sm-12">
							<div class="card mt-2">
							  <div class="card-header" style="background-color: #2e3c54; color:white;">
							    <i class="fa fa-users"></i> ESTATUS GENERAL DE MIS CLIENTES
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
		          <!-- <div class="col-sm-12 col-lg-5">
		            <div class="card mt-2">
		              <div class="card-header" style="background-color: #2e3c54; color:white;">
		                <div class="row">
		                  <div class="col-sm-12 col-lg-8">
		                    <i class="fa  fa-bar-chart-o"></i> TEMPERATURA DE CLIENTES
		                  </div>
		                  <div class="col-sm-12 col-lg-4 text-xs-right">
		                    Total: <?= $sum_temp; ?>
		                  </div>
		                </div>
		              </div>
		              <div class="card-block">
		                <?php if ($sum_temp == 0): ?>
		                  <div class="col-sm-12" style="min-height: 300px;"><span style="font-size: 1.2rem; color: #C6C6C6;" class="flex-center">Aun no hay clientes.</span></div>
		                <?php else: ?>
		                  <div id="grafica_clientes" style="width: 100%; min-height: 300px;"></div>
		                <?php endif; ?>
		                <div class="col-sm-12">
		                  <i>
		                    <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
		                  </i>
		                </div>
		              </div>
		            </div>
		          </div> -->
		        </div>
						<!-- ./row primeras dos graficas -->

				<!-- <div class="row" id="clientesAtencion">
		          <div class="col-sm-12">
		            <div class="card mt-1">
		              <div class="card-header" style="background-color: #2e3c54; color:white;">
		                <div class="row">
		                  <div class="col-sm-12 col-lg-8">
		                    <i class="fa fa-calendar"></i> ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
		                  </div>
		                  <div class="col-sm-12 col-lg-4 text-xs-right">
		                    Total: <?= $data_clientes_atencion['oportunos'] + $data_clientes_atencion['tardios'] + $data_clientes_atencion['no_atendidos'] + $data_clientes_atencion['por_reasignar'] ?>
		                  </div>
		                </div>
		              </div>
		              <div class="card-block">
		                <div id="grafica_atencion_clientes" style="width: 100%; height: 300px;"></div>
		                <div class="col-sm-12">
		                  <i>
		                    <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
		                  </i>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div> --> <!-- Tercer fila ./End row #clientesAtencion -->

		        <!-- <div class="row" id="metaVentasMes" style="display: none;">
		          <div class="col-sm-12">
		            <div class="card mt-2">
		              <div class="card-header" style="background-color: #2e3c54; color:white;">
		                <div class="row">
		                  <div class="col-sm-12">
		                    <i class="fa fa-calendar"></i> Meta de ventas
		                  </div>
		                </div>
		              </div>
		              <div class="card-block">
		                <div id="grafica_metas_ventas" style="width: 100%; min-height:300px;"></div>
		                <div class="col-sm-12">
		                  <i>
		                    <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
		                  </i>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div> --> <!-- Cuarta fila ./End row #metaVentasMes -->

		        <!-- <div class="row">
		          <div class="col-sm-12">
		            <div class="card mt-2">
		              <div class="card-header" style="background-color: #2e3c54; color:white;">
		                <div class="row">
		                  <div class="col-sm-12 col-lg-6">
		                    <i class="fa fa-calendar"></i> Metas vs Ventas por mes
		                  </div>
		                </div>
		              </div>
		              <div class="card-block">
		                <div id="metasventas" style="width: 100%; min-height: 300px;"></div>
		                <div class="col-sm-12">
		                  <i>
		                    <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
		                  </i>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div> -->

		        <!-- Grafica de origen de clientes -->
		        <!-- <div class="row">
		          <div class="col-sm-12">
		            <div class="card mt-2">
		              <div class="card-header" style="background-color: #2e3c54; color:white;">
		                <div class="row">
		                  <div class="col-sm-12 col-lg-6">
		                    origen de clientes / ventas
		                  </div>
		                  <div class="col-sm-12 col-lg-6 text-lg-right">
		                    <?= "Total clientes ".$countClientesOrigen ?>, 
		                    <?= "Total ventas ".$countVentasOrigen ?>
		                  </div>
		                </div>
		              </div>
		              <div class="card-block">
		                <div id="origen_cientes_ventas" style="width: 100%; min-height: 300px;"></div>
		                <div class="col-sm-12">
		                  <i>
		                    <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
		                  </i>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div> -->
		        <!-- Grafica de origen de clientes -->

		        <!-- Grafica de Historico de contactos -->
		        <!-- <div class="row">
		          <div class="col-sm-12">
		            <div class="card mt-2">
		              <div class="card-header" style="background-color: #2e3c54; color:white;">
		                <div class="row">
		                  <div class="col-sm-12 col-lg-6">
		                    Histórico contactos / Ventas / Gasto
		                  </div>
		                  <div class="col-sm-12 col-lg-6 text-lg-right">
		                    <?= 'Total contactos '.array_sum($arreglo_cm) ?>, 
		                    <?= 'Total ventas '.array_sum($arreglo_ventasm) ?>
		                  </div>
		                </div>
		              </div>
		              <div class="card-block">
		                <div id="historico_contactos_ventas_gasto" style="width: 100%; min-height: 300px;"></div>
		                <div class="col-sm-12">
		                  <i>
		                    <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
		                  </i>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div> -->
		        <!-- ./Grafica de Historico de contactos -->

					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<?php 
  echo $this->Html->script([
    'components',
    'custom',
    // Graficas de Google
    'https://www.gstatic.com/charts/loader.js',
    // 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0',

    // Calendario
    '/vendors/jquery.uniform/js/jquery.uniform.js',
		'/vendors/inputlimiter/js/jquery.inputlimiter.js',
		'/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
		'/vendors/jquery-tagsinput/js/jquery.tagsinput.js',
		'/vendors/validval/js/jquery.validVal.min.js',
		'/vendors/inputmask/js/jquery.inputmask.bundle.js',
		'/vendors/moment/js/moment.min.js',
		'/vendors/daterangepicker/js/daterangepicker.js',
		'/vendors/datepicker/js/bootstrap-datepicker.min.js',
		'/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
		'/vendors/bootstrap-switch/js/bootstrap-switch.min.js',
		'/vendors/autosize/js/jquery.autosize.min.js',
		'/vendors/jasny-bootstrap/js/jasny-bootstrap.min.js',
		'/vendors/jasny-bootstrap/js/inputmask.js',
		'/vendors/datetimepicker/js/DateTimePicker.min.js',
		'/vendors/j_timepicker/js/jquery.timepicker.min.js',
		'/vendors/clockpicker/js/jquery-clockpicker.min.js',

		'form.js',
		//'pages/datetime_piker.js',

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
	// google.charts.setOnLoadCallback(metas_ventas);                          // Metas de venta al mes
	google.charts.setOnLoadCallback(drawVentasMetas);                       // Metas vs Ventas
	google.charts.setOnLoadCallback(drawClientesLineasContacto);            // Origen clientes ventas mes
	google.charts.setOnLoadCallback(drawMeses);                             // Histórico de contactos/ventas/gastos/año

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
    chart.draw(view, options);
}

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
}

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
}

function drawVentasMetas(){
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Meta', 'Ventas', '% Cumplido'],
        <?php foreach ($ventas_grafica as $venta): ?>
            <?php
                if ($meta_mes != 0) {
                    $var1 = ($venta[0]['sum(precio_cerrado)']/$meta_mes)*100;
                }
            ?>
            <?php $maximo += $venta[0]['sum(precio_cerrado)']; ?>
            ['<?= $venta[0]['mes']?>', <?= $meta_mes?>, <?= $venta[0]['sum(precio_cerrado)']?>, <?= $var1 ?>],
        <?php endforeach;?>
     ]);

    var options = {
    // title : 'Metas Vs Ventas por mes',
    //             vAxis: {title: 'Monto $'},
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $meta_mes?>,
            title: 'Monto $',
         }, 
         {
            minValue: 0,
            maxValue: 100,
            title: '% de Meta complido',
         }
     ],
     hAxis: {title: 'Periodo'},
    series: {
        0: { // Meta
            type: "bars",
            targetAxisIndex: 0,
            color: "#BFFA77"
        },
        1: { // Real
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47"
        },
        2: {  // % de cumplimiento
            type: "line",
            targetAxisIndex: 1,
            color: "#ED7D31"
        },
    },   
    backgroundColor:'transparent',
    legend:{
      textStyle:{
          
          fontSize: 13
      }
    },
    titleTextStyle:{
        fontSize: 16
    },
};

    var chart = new google.visualization.ComboChart(document.getElementById('metasventas'));
    chart.draw(data, options);
}


function drawClientesLineasContacto(){
  var data = google.visualization.arrayToDataTable([
      ['Forma de Contacto', 'Contactos','Ventas', 'Inversion'],
      <?php if (!empty($arregloCV)): ?>
        <?php foreach ($arregloCV as $CVOrigen): ?>
          ['<?= $CVOrigen['LineaContacto']['nombre_linea'] ?>', <?= $CVOrigen['LineaContacto']['count(clientes)'] ?>, <?= $CVOrigen['LineaContacto']['count(ventas)'] ?>, 0],
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

// Grafica de Histórico de contactos/ventas/gastos año en curso
function drawMeses(){
  var data = google.visualization.arrayToDataTable([
      ['Mes', 'Contactos','Ventas','Inversión'],
      <?php if(!empty($meses)): ?>
        <?php foreach ($meses as $mes):?>
            ['<?= $mes?>',<?= $arreglo_cm[$mes]?>,<?= isset($arreglo_ventasm[$mes]) ? $arreglo_ventasm[$mes] : 0?>,<?= isset($arreglo_inversionm[$mes]) ? $arreglo_inversionm[$mes] : 0?>],
        <?php endforeach;?>
      <?php else:; ?>
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
   hAxis: {title: 'Periodo',textStyle:{color: '#616161'},titleTextStyle:{color: '#616161'}},
   height: 300,
   series: {
          0: { //Objetivo
              type: "bars",
              targetAxisIndex: 0,
              color: "orange"
          },
          1: { //Real
              type: "bars",
              targetAxisIndex: 0,
              color: "#70AD47"
          },
          2: {  //% de cumplimiento
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

 var chart = new google.visualization.ComboChart(document.getElementById('historico_contactos_ventas_gasto'));
 chart.draw(data, options);

}


});
</script>