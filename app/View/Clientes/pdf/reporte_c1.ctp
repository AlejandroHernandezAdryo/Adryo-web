<body>
<style>
    p {
        display: block;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
    }
    body {
        font-family: 'Poppins', sans-serif;
        color: #282828;
    }
    h1{
        font-size: 14px;
    }
</style>
<div style="padding:5%">
    <table>
        <tr>
            <td style=width:30%">
                <img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>" alt="Logo cuenta" style="width:120%">
                <p class="text-lg-center" style="font-size: 10px;">
                    <?= $this->Session->read('CuentaUsuario.Cuenta.razon_social') ?>
                    <br>
                    <?= $this->Session->read('CuentaUsuario.Cuenta.direccion') ?>
                    <br>
                    <?= $this->Session->read('CuentaUsuario.Cuenta.telefono_1') ?>
                    <br>
                    <?= $this->Html->link($this->Session->read('CuentaUsuario.Cuenta.pagina_web'), 'http://'.$this->Session->read('CuentaUsuario.Cuenta.pagina_web'), array('target'=>'_Blanck')) ?>
                </p>
            </td>
            <td style="width:40%; text-align: center">
                <h1>Reporte de Desempe&ntilde;o de Clientes</h1>
            </td>
            <td style="width:30%; text-align:right">
                <p class="text-lg-right" style="font-size: 10px;">
                    <b>Del
                    <?= date('d/M/Y', strtotime($fecha_ini)).' al '.date('d/M/Y', strtotime($fecha_fin)) ?></b>
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #2e3c54; color:white;text-align: center" colspan="3">
                <i class="fa fa-users"></i> ESTATUS GENERAL DE CLIENTES
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div id="grafica_estatus_general_clientes" style="width: 100%; height: 300px;"></div>
                <div class="col-sm-12">
                <i>
                    <small>INFORMACI&Oacute;N DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
                </i>
            </td>
        </tr>
    </table>
							
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
	
        google.charts.load('current', {'packages':['corechart']});

	google.charts.setOnLoadCallback(ClienteStatusGeneral);                  // Grafica de status de clientes
	

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
    var div_grafica_estatus_general_clientes =  document.getElementById("grafica_estatus_general_clientes");
    var chart = new google.visualization.ColumnChart(div_grafica_estatus_general_clientes);

    google.visualization.events.addListener(chart, 'ready', function () {
		div_grafica_estatus_general_clientes.innerHTML = '<img src="' + chart.getImageURI() + '">';
		
	});
    chart.draw(view, options);
}

});
</script>
</body>