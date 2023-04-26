<style>
	#grafica_clientes_asignados_reasignados {
		width: 100%;
		height: 500px;
	}

</style>
<div class="modal fade" id="">
	<div class="modal-dialog modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">

			<div class="modal-header bg-blue-is">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle="tooltip"
					title="CERRAR">&times;</button>
				<h4 class="modal-title">&nbsp;&nbsp; Información de la grafica.</h4>
			</div> <!-- Modal Header -->

			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<p>
							<i class="fa fa-exclamation-triangle text-danger"></i>
							no hay datos jaja

						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header bg-blue-is cursor" data-toggle='modal'>
		CLIENTES ASIGNADOS VS REASIGNADOS
	</div>

	<div class="card-block" style="width: 100%;">
		<div class="row">
			<div class="col-sm-12">
				<div id="grafica_clientes_asignados_reasignados" class="grafica no"></div>
			</div>
			<div class="col-sm-12 m-t-35">
				<small id="grafica_clientes_asignados_reasignados_periodo_tiempo"></small>
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
	function graficaClientesAsignadosReasignados(rangoFechas, cuentaId, desarrolloId, asesorId) {

		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "clientes", "action" => "asiganacion_reasignacion")); ?>',
			cache: false,
			data: {
				rango_fechas: rangoFechas,
				cuenta_id: cuentaId,
				desarrollo_id: desarrolloId,
				user_id: asesorId
			},
			dataType: 'json',
			success: function (response) {

				document.getElementById("grafica_clientes_asignados_reasignados_periodo_tiempo").innerHTML = rangoFechas;
				var clientesTotal = 0;
				var tedieronTotal = 0;
				var tequitaronTotal = 0;
				var Total = 0;
				var maxClientes = 0;
				for (let i in response) {
					response[i].clientes = parseInt(response[i].clientes);
					response[i].tedieron = parseInt(response[i].tedieron);
					response[i].tequitaron = parseInt(response[i].tequitaron);
					response[i].totales = parseInt(response[i].totales);
					clientesTotal   += response[i].clientes;
					tedieronTotal   += response[i].tedieron;
					tequitaronTotal -= response[i].tequitaron;
					Total           += response[i].totales;
          if(maxClientes<response[i].clientes){
            maxClientes=response[i].clientes
          }
				}
				
				if (maxClientes == 0) {
					maxClientes = 5;
				}
        drawGraficaClientesAsignadosReasignados(response, clientesTotal, tedieronTotal, tequitaronTotal, Total, maxClientes);
			},
			error: function (err) {
				console.log(err.responseText);
			}
		});

	}
  function drawGraficaClientesAsignadosReasignados(response, clientesTotal, tedieronTotal, tequitaronTotal, Total, maxClientes){
    am5.ready(function() {

      // Create root element
      // https://www.amcharts.com/docs/v5/getting-started/#Root_element
      var root = am5.Root.new("grafica_clientes_asignados_reasignados");


      // Set themes
      // https://www.amcharts.com/docs/v5/concepts/themes/
      root.setThemes([
        am5themes_Animated.new(root)
      ]);


      // Create chart
      // https://www.amcharts.com/docs/v5/charts/xy-chart/
      var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: root.verticalLayout
      }));


      // Add legend
      // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
      var legend = chart.children.push(
        am5.Legend.new(root, {
          centerX: am5.p50,
          x: am5.p50
        })
      );
      // Create axes
      // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
      var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        categoryField: "periodo",
        renderer: am5xy.AxisRendererX.new(root, {
          cellStartLocation: 0.1,
          cellEndLocation: 0.9
        }),
        tooltip: am5.Tooltip.new(root, {})
      }));

      xAxis.data.setAll(response);

      var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
      }));


      // Add series
      // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
      function makeSeries(name, fieldName,cantidadTotal) {
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
          name: ` ${name}: ${cantidadTotal}`,
          xAxis: xAxis,
          yAxis: yAxis,
          valueYField: fieldName,
          categoryXField: "periodo",
          tooltip : am5.Tooltip.new(root, {
					  labelText: "{categoryX}: {name} {valueY}"
				  })
        }));

        series.columns.template.setAll({
          tooltipText: "{name}, {categoryX}:{valueY}",
          width: am5.percent(90),
          tooltipY: 0
        });

        series.data.setAll(response);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear();

        series.bullets.push(function () {
          return am5.Bullet.new(root, {
            locationY: 1,
            sprite: am5.Label.new(root, {
              text: "{valueY}",
              fill        : am5.color(0x000000),
              centerX: am5.p50,
            centerY: am5.p100,  
              populateText: true
            })
          });
        });
        legend.data.push(series);
      }
      // clientesTotal, tedieronTotal, tequitaronTotal, Total
      makeSeries("Asignados", "clientes",clientesTotal);
      makeSeries("Reasignados", "tedieron",tedieronTotal);
      makeSeries("Reasignados", "tequitaron",tequitaronTotal);
      makeSeries("Total ", "totales",Total);
      // Make stuff animate on load
      // https://www.amcharts.com/docs/v5/concepts/animations/
      chart.appear(1000, 100);

      }); // end am5.ready()
  }

</script>
