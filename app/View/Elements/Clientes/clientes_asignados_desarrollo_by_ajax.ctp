<style>
	#grafica_clientes_asignados_desarrollo {
		width: 100%;
		height: 500px;
	}

</style>

<div class="card">
	<div class="card-header bg-blue-is cursor">
		CLIENTES ASIGNADOS POR DESARROLLO O PROPIEDAD
		<span style="float:right">
			Total: <span id="totalClientesAsignadosDesarrollo"></span>
		</span>
	</div>

	<div class="card-block" style="width: 100%;">
		<div class="row">
			<div class="col-sm-12">
				<div id="grafica_clientes_asignados_desarrollo" class="grafica"></div>
			</div>
			<div class="col-sm-12 m-t-35">
				<small id="grafica_clientes_asignados_desarrollo_periodo_tiempo"></small>
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
	function graficaClientesAsignadosDesarrollo(rangoFechas, cuentaId, desarrolloId, asesorId) {
		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "clientes", "action" => "asignacion_clientes_asesor_desarrollo")); ?>',
			cache: false,
			data: {
				rango_fechas: rangoFechas,
				cuenta_id: cuentaId,
				desarrollo_id: desarrolloId,
				user_id: asesorId
			},
			dataType: 'json',
			success: function (response) {
				var Total = 0;
				for (let i in response) {
					response[i].asignados = parseInt(response[i].asignados);
					Total += response[i].asignados;
				}
				document.getElementById("totalClientesAsignadosDesarrollo").innerHTML = Total;
				if (Total == 0) {
					Total = 5;
				}
				document.getElementById("grafica_clientes_asignados_desarrollo_periodo_tiempo").innerHTML = rangoFechas;
				drawGraficaClientesAsignadosDesarrollo(response, Total);


			},
			error: function (err) {
				console.log(err.responseText);
			}
		});
	}
	// Es el metodo de la grafica.
	function drawGraficaClientesAsignadosDesarrollo(response, Total) {
		am5.ready(function () {
			//maybeDisposeRoot("grafica_etapa_clientes");
			var root = am5.Root.new("grafica_clientes_asignados_desarrollo");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			root.interfaceColors.set("grid", am5.color('#bababa'));
			var data = response
			var chart = root.container.children.push(
				am5xy.XYChart.new(root, {
					panX: false,
					panY: false,
					wheelX: "none",
					wheelY: "none",

				})
			);

			// Create axes
			// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

			var yRenderer = am5xy.AxisRendererY.new(root, {});
			yRenderer.grid.template.set("visible", false);

			var yAxis = chart.yAxes.push(
				am5xy.CategoryAxis.new(root, {
					categoryField: "desarrollos",
					renderer: yRenderer,
					//paddingRight:40
				})
			);

			var xRenderer = am5xy.AxisRendererX.new(root, {});
			xRenderer.grid.template.set("strokeDasharray", [3]);

			var xAxis = chart.xAxes.push(
				am5xy.ValueAxis.new(root, {
					min: 0,
					max: (Total) * 1.1,
					renderer: xRenderer
				})
			);

			var series = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "asignados",
					categoryYField: "desarrollos",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{categoryY}: Cantidad {valueX}"
					})
				})
			);


			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			chart.get("colors").set("colors", [
				am5.color(0x6b8abf),
			]);
			series.columns.template.adapters.add("fill", function (fill, target) {
				return chart.get("colors").getIndex(series.columns.indexOf(target));
			});

			series.columns.template.adapters.add("stroke", function (stroke, target) {
				return chart.get("colors").getIndex(series.columns.indexOf(target));
			});

			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{asignados} ",
						fill: am5.color(0x000000),
						centerY: am5.p100,
						populateText: true
					})
				});
			})
			series.data.setAll(data);
			yAxis.data.setAll(data);

			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineX.set("visible", false);
			cursor.lineY.set("visible", false);
			series.appear();
			chart.appear(1000, 100);

		}); // end am5.ready()
	}

</script>
