<style>
		#razonReasignados{
  		width: 100%;
  		height: 500px;
		}
</style>
<div class="modal fade" id="modal_info_clientes_estatus">
  <div class="modal-dialog modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
    
      <div class="modal-header bg-blue-is">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
          <h4 class="modal-title">&nbsp;&nbsp; Información de la grafica.</h4>
      </div> <!-- Modal Header -->

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <p>
              <i class="fa fa-exclamation-triangle text-danger"></i>
              Esta grafica esta enfocada a la tabla de clientes, 
              los filtros estan enfocados en la fecha de creación de los clientes
              y por desarrollo.

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
        MOTIVOS DE REASIGNACIÓN DE CLIENTES
    <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
        <span style="float:right">
            Total: <span id="totalclientesrazonReasignadosTemporales"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
        <div id="razonReasignados"></div>
       
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="razonReasignados_periodo_tiempo"></small>
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
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0',

  ], array('inline'=>false));
?>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>  
 // Se mandan a llamar los datos para la grafica
  function graficarazonReasignados( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "motivos_reasignaciones")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
        dataType: 'json',
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
          var Total    = 0;
			    for (let i in response){
            	response[i].cantidad  = parseInt(response[i].cantidad);
            	Total += response[i].cantidad;
        	}
        	document.getElementById("totalclientesrazonReasignadosTemporales").innerHTML =Total;

        	document.getElementById("razonReasignados_periodo_tiempo").innerHTML =rangoFechas;
          drawGraficarazonReasignados(response);
        },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
    
  }
   // Es el metodo de la grafica.
   function drawGraficarazonReasignados(response) {
    am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("razonReasignados");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(
  am5percent.PieChart.new(root, {
    endAngle: 270
  })
);

// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(
  am5percent.PieSeries.new(root, {
    valueField: "cantidad",
    categoryField: "motivo",
    endAngle: 270
  })
);

series.states.create("hidden", {
  endAngle: -90
});

// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
var data = response;
series.data.setAll(data);

series.appear(1000, 100);

});

  }
</script>