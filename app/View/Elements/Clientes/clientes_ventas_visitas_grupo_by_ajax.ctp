<style>
    #clientes_ventas_visitas_grupo{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
        TOTAL DE CLIENTES VS VENTAS Y VISITAS
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12" >
                <div id="clientes_ventas_visitas_grupo" ></div>
            </div>
                <div class="col-sm-12 m-t-35">
                    <small id="clientes_ventas_visitas_grupo_periodo_tiempo"></small>
                </div>
        </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
  // Se mandan a llamar los datos para la grafica
    function ClienteVentasVisitasGrupoAsesor( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "clientes_ventas_visitas_grupo_asesores")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            // beforeSend: function () {
            //     $("#overlay").fadeIn();
            // },
            success: function ( response ) {
                console.log( response );
                // draw( response, ventaunidades, ventaMonto,maxima);
        },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
        

    }
   // Es el metodo de la grafica.  0: {venta_q: '1', asesor: 'Diego Murillo Barro', venta_v: '2410737'}
    function draw( response, ventaunidades, ventaMonto, maxima) {
		am5.ready(function() {
			var root = am5.Root.new("grafica_ventas_asesor");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var data = response
			var chart = root.container.children.push(
				am5xy.XYChart.new(root, {
					panX: false,
					panY: false,
					wheelY : "zoomY",
					wheelX: "none",
					
				})
			);

			// Create axes
			// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

			var yRenderer = am5xy.AxisRendererY.new(root, {});
			yRenderer.grid.template.set("visible", false);

			var yAxis = chart.yAxes.push(
				am5xy.CategoryAxis.new(root, {
					categoryField: "asesor",
					renderer: yRenderer,
				})
			);

			var xRenderer = am5xy.AxisRendererX.new(root, {});
			xRenderer.grid.template.set("strokeDasharray", [3]);

			var xAxis = chart.xAxes.push(
			am5xy.ValueAxis.new(root, {
				min: 0,
				max:(maxima)*1.5,
				renderer: xRenderer
			})
			);
			var series = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					name : `Ventas Unidades:${ventaunidades}`,
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "venta_q",
					categoryYField: "asesor",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{valueX} unidad(es)"
					})
				})
			);
			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 
			
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 1,
					sprite       : am5.Label.new(root, {
						text        : "{venta_q} ",
						fill        : am5.color(0x000000),
						centerX: 0,
            			centerY: am5.p100,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					name : `Ventas Monto:${ventaMonto} MDP`,
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "venta_v",
					categoryYField: "asesor",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "Monto:{valueXWorking.formatNumber('#.# a')}"
					})
				})
			);
			
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.monto')?>")); 
			
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 1,
					sprite	 : am5.Label.new(root, {
						text        : "{venta_v.formatNumber('#.# a')} ",
						fill        : am5.color(0x000000),
						centerX: 0,
        				centerY: am5.p100,
						populateText: true
					})
				});
			})
			var legend = chart.children.unshift(am5.Legend.new(root, {
				centerX: am5.p200,
				x: am5.p50,
				centerY: am5.p50,
				// centerX: am5.p50,
  				// x: am5.p50
			}));
			legend.data.setAll(chart.series.values);
			series.data.setAll(data);
			yAxis.data.setAll(data);
			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineX.set("visible", false);
			cursor.lineY.set("visible", false);
			series.appear();	
			series1.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
		}); // end am5.ready()
	}
</script>