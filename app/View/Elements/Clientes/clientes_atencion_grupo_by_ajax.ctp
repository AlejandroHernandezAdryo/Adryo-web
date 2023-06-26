<style>
		#graficas_clientes_atencion_asesores{
  		width: 100%;
  		height: 500px;
		}
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
		ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
        <span style="float:right">
            Total: <span id="atenciontaltaclientes"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
    	<div class="row">
        	<div class="col-sm-12" >
        		<div id="graficas_clientes_atencion_asesores" ></div>
        	</div>
        	<div class="col-sm-12 m-t-35">
        		<small id="graficas_clientes_atencion_asesores_periodo_tiempo"></small>
        	</div>
    	</div>
    </div>
</div>


<?php
  echo $this->Html->script([
    'components',
    'custom',


	], array('inline'=>false));
?>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>

  // Se mandan a llamar los datos para la grafica
	function clientesAtencionClientes( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        
		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "clientes_atencion_grupo")); ?>',
			cache: false,
			data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
			dataType: 'json',

			success: function ( response ) {
				
				let Total=0;
				let maxioportunos=0;
				let maxitardios=0;
				let maxino_atendido=0;
				let maxino_reasignar=0;
				let max1=0;
				let max2=0;
				let maximo=0;
				for (let i in response){
					response[i].oportunos  = parseInt(response[i].oportunos);
					response[i].tardios  = parseInt(response[i].tardios);
					response[i].no_atendido  = parseInt(response[i].no_atendido);
					response[i].reasignar  = parseInt(response[i].reasignar);
					Total += response[i].oportunos + response[i].tardios +  response[i].no_atendido + response[i].reasignar ;
					if(maxioportunos < response[i].oportunos){
						maxioportunos = response[i].oportunos;
					}
					if(maxitardios < response[i].tardios){
						maxitardios = response[i].tardios;
					}
					if(maxino_atendido < response[i].no_atendido){
						maxino_atendido = response[i].no_atendido;
					}
					if(maxino_reasignar < response[i].reasignar){
						maxino_reasignar = response[i].reasignar;
					}
        		}
				if ( maxioportunos < maxitardios ) {
					max1 = maxitardios ;
				}
				if ( maxino_atendido < maxino_reasignar ) {
					max2 = maxino_reasignar ;
				}
				if ( max1 < max2 ) {
					maximo = max2 ;
				}else{
					maximo=max1
				}
				document.getElementById("graficas_clientes_atencion_asesores_periodo_tiempo").innerHTML =rangoFechas;
				document.getElementById("atenciontaltaclientes").innerHTML =Total;
				
				// console.log('caca');
				// console.log(response,  Total, max );
				// console.log('caca');
				
				drawClientesAtencionGrupoAsesores(response,  Total, maximo );
			},
			error: function ( err ){
			console.log( err.responseText );
			}
		});
	}
   // Es el metodo de la grafica.
	function drawClientesAtencionGrupoAsesores( response, Total, maximo ) {
    	am5.ready(function() {
			var root = am5.Root.new("graficas_clientes_atencion_asesores");

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

			var legend = chart.children.push(
			am5.Legend.new(root, {
				centerX: am5.p50,
				x: am5.p50
			})
			);

			var data = response;

			var xRenderer = am5xy.AxisRendererX.new(root, {
				cellStartLocation: 0.1,
				cellEndLocation: 0.9
			})

			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				categoryField: "user_name",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));

			xRenderer.grid.template.setAll({
				location: 1
			})
			
			xAxis.data.setAll(data);

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min:0,
				max         : (maximo)*1.1,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			// var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
			// 	renderer: am5xy.AxisRendererY.new(root, {
			// 		strokeOpacity: 0.1,
				
			// 	})
			// }));

			function makeSeries(name, fieldName) {
				var series = chart.series.push(am5xy.ColumnSeries.new(root, {
					name: name,
					xAxis: xAxis,
					yAxis: yAxis,
					valueYField: fieldName,
					categoryXField: "user_name",
					tooltip : am5.Tooltip.new(root, {
						labelText: "{categoryX}: Cantidad {valueY}"
				})
			}));

			series.columns.template.setAll({
				tooltipText: "{name}, {categoryX}:{valueY}",
				width: am5.percent(90),
				tooltipY: 0,
				strokeOpacity: 0
			});

			series.data.setAll(data);
			series.appear();
			series.bullets.push(function() {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.# a')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
				})
				});
			});

			legend.data.push(series);
			}

			makeSeries("Oportunos", "oportunos");
			makeSeries("Tardios", "tardios");
			makeSeries("No Atendido", "no_atendido");
			makeSeries("Reasignar", "reasignar");

			chart.appear(1000, 100);

			}); // end am5.ready()
  	}
</script>