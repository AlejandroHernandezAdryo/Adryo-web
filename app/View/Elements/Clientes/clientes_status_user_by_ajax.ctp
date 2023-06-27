<style>
		#graficas_clientes_status_asesores{
  		width: 100%;
  		height: 500px;
		}
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
		ESTATUS GENERAL DE CLIENTES POR ASESOR
        <span style="float:right">
            Total Activos: <span id="totalClientesActivos"></span>
            Total: <span id="totalClientes"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
    	<div class="row">
        	<div class="col-sm-12" >
        		<div id="graficas_clientes_status_asesores" ></div>
        	</div>
        	<div class="col-sm-12 m-t-35">
        		<small id="graficas_clientes_status_asesoresperiodo_tiempo"></small>
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
	function clientesStatusClientes( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        
		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "clientes_status_grupo")); ?>',
			cache: false,
			data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
			dataType: 'json',

			success: function ( response ) {
				let Total=0;
				let totalClientesActivos=0;
				let maxiActivos=0;
				let maxiTemporal=0;
				let maxiInactivo=0;
				let max=0;
				for (let i in response){
					response[i].activos  = parseInt(response[i].activos);
					response[i].temporal  = parseInt(response[i].temporal);
					response[i].Inactivo  = parseInt(response[i].Inactivo);
					Total += response[i].activos + response[i].temporal +  response[i].Inactivo;
					totalClientesActivos += response[i].activos ;
					if(maxiActivos < response[i].activos){
						maxiActivos = response[i].activos;
					}
					if(maxiTemporal < response[i].temporal){
						maxiTemporal = response[i].temporal;
					}
					if(maxiInactivo < response[i].Inactivo){
						maxiInactivo = response[i].Inactivo;
					}
        		}
				if (maxiActivos < maxiInactivo ) {
					max = maxiInactivo ;
				}
				document.getElementById("graficas_clientes_status_asesoresperiodo_tiempo").innerHTML =rangoFechas;
				document.getElementById("totalClientes").innerHTML =Total;
				document.getElementById("totalClientesActivos").innerHTML =totalClientesActivos;
				
				drawClienteGrupoStatus( response, Total, max );
			},
			error: function ( err ){
			console.log( err.responseText );
			}
		});
	}
   // Es el metodo de la grafica.
	function drawClienteGrupoStatus( response, Total, max ) {
    	am5.ready(function() {
		
			var root = am5.Root.new("graficas_clientes_status_asesores");

			root.setThemes([
				am5themes_Animated.new(root)
			]);

			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX: false,
				panY: false,
				wheelX: "panX",
				wheelY: "zoomX",
				layout: root.verticalLayout
			}));

			var legend = chart.children.push(am5.Legend.new(root, {
				centerX: am5.p50,
				x: am5.p50
			}))

			var data = response;

			var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
				categoryField: "user_name",
				renderer: am5xy.AxisRendererY.new(root, {
					inversed: true,
					cellStartLocation: 0.1,
					cellEndLocation: 0.9
				})
			}));

			yAxis.data.setAll(data);

			var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
				renderer: am5xy.AxisRendererX.new(root, {
					strokeOpacity: 0.1
				}),
				min: 0
			}));


			function createSeries(field, name) {
				var series = chart.series.push(am5xy.ColumnSeries.new(root, {
					name: name,
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: field,
					categoryYField: "user_name",
					sequencedInterpolation: true,
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "horizontal",
						labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
					})
			}));

			series.columns.template.setAll({
				height: am5.p100,
				strokeOpacity: 0
			});

			
			series.bullets.push(function() {
				return am5.Bullet.new(root, {
				locationX: 1,
				locationY: 0.5,
				sprite: am5.Label.new(root, {
					centerY: am5.p50,
					text: "{valueX}",
					populateText: true
				})
				});
			});

			series.bullets.push(function() {
				return am5.Bullet.new(root, {
				locationX: 1,
				locationY: 1,
				sprite: am5.Label.new(root, {
					centerX: am5.p100,
					centerY: am5.p50,
					// text: "{name}",
					// fill: am5.color(0xffffff),
					populateText: true
				})
				});
			});

			series.data.setAll(data);
			series.appear();

			return series;
			}

			createSeries("activos", "Activos");
			createSeries("temporal", "Temporales");
			createSeries("Inactivo", "Inactivos");

			var legend = chart.children.push(am5.Legend.new(root, {
			centerX: am5.p50,
			x: am5.p50
			}));

			legend.data.setAll(chart.series.values);

			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
			behavior: "zoomY"
			}));
			cursor.lineY.set("forceHidden", true);
			cursor.lineX.set("forceHidden", true);

			chart.appear(1000, 100);

		}); // end am5.ready()
  	}
</script>