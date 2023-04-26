<style>
    #apartados_cancelaciones_vigentes{
        width: 100%;
        height: 500px;
    }
</style>
<div class="card">
    <div class="card-header bg-blue-is cursor" data-target='#' data-toggle='modal'>
		ESTATUS DE APARTADOS ( TOTALES, VIGENTES, CANCELADOS ) Y VENTAS <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="apartados_cancelaciones_vigentes"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="apartados_cancelaciones_vigentes_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
    function gradicaApartados_ventas_cancelaciones(rangoFechas, cuentaId, desarrolloId ,asesorId ){
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "ventas_apartados_cancelaciones")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
                let maximoVenta       = 0;
                let maximoApertado    = 0;
                let maximoCancelacion = 0;
                let totalVentas       = 0;
                let totalApertado     = 0;
                let totalCancelacion  = 0;
                let max               = 0;
                let totalApertadoViejente               = 0;
                for (let i in response){  
                    response[i].cancelaciones   = parseInt(response[i].cancelaciones);
                    response[i].ventas          = parseInt(response[i].ventas);
                    response[i].apartado        = parseInt(response[i].apartado);
                    response[i].apartodvijentes = parseInt(response[i].apartodvijentes);
                    if ( maximoVenta < response[i].ventas ) {
                        maximoVenta = response[i].ventas
                    }
                    if( maximoApertado < response[i].apartado ){
                        maximoApertado = response[i].apartado;
                    }
                    if ( maximoCancelacion < response[i].cancelaciones ) {
                        maximoApertado = response[i].cancelaciones;
                    }
                    totalVentas           += response[i].ventas;
                    totalApertado         += response[i].apartado;
                    totalCancelacion      += response[i].cancelaciones; 
                    totalApertadoViejente += response[i].apartodvijentes;
                }
                max= maximoVenta;
                if (maximoVenta<maximoApertado) {
                    max=maximoApertado;
                }
				if (max==0) {
					max=totalApertadoViejente;
				}
                drawgradicaApartados_ventas_cancelaciones(response,totalVentas, totalApertado, totalCancelacion, max, totalApertadoViejente);
            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });
    }
    function drawgradicaApartados_ventas_cancelaciones(response,totalVentas, totalApertado, totalCancelacion, max,totalApertadoViejente){
        am5.ready(function() {
			var root = am5.Root.new("apartados_cancelaciones_vigentes");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var data = response;
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
					categoryField: "periodo",
					renderer: yRenderer,
				})
			);

			var xRenderer = am5xy.AxisRendererX.new(root, {});
			xRenderer.grid.template.set("strokeDasharray", [3]);

			var xAxis = chart.xAxes.push(
                am5xy.ValueAxis.new(root, {
                    min: 0,
                    max:(max)*1.5,
                    renderer: xRenderer
                })
			);
			var series = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					name : `Apartados totales y vigentes:${totalApertado} `,
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "apartado",
					categoryYField: "periodo",
					
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{valueX} apartado(s)"
					})
				})
			);

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			

			series.set("fill", am5.color("<?= $this->Session->read('colores.Embudo.etapa6')?>")); 
			
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 1,
					sprite       : am5.Label.new(root, {
						text        : "{apartado}",
						fill        : am5.color(0x000000),
						centerX: 0,
            			centerY: am5.p100,
						populateText: true
					})
				});
			})

			var series1 = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					name : `Ventas Unidades:${totalVentas}`,
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "ventas",
					categoryYField: "periodo",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{valueX} unidad(es)"
					})
				})
			);
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Embudo.etapa7')?>")); 
			
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 1,
					sprite	 : am5.Label.new(root, {
						text        : "{ventas}",
						fill        : am5.color(0x000000),
						centerX: 0,
        				centerY: am5.p100,
						populateText: true
					})
				});
			})

            var series2 = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					name : `Cancelaciones:${totalCancelacion} `,
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "cancelaciones",
					categoryYField: "periodo",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{valueX} Cancelaciones"
					})
				})
			);


			series2.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series2.set("fill", am5.color("<?= $this->Session->read('colores.Cancelacion')?>")); 
			
			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 1,
					sprite	 : am5.Label.new(root, {
						text        : "{cancelaciones}",
						fill        : am5.color(0x000000),
						centerX: 0,
        				centerY: am5.p100,
						populateText: true
					})
				});
			})
			// //}}
			// var series3 = chart.series.push(
			// 	am5xy.ColumnSeries.new(root, {
			// 		name : `apartodo vigentes:${totalApertadoViejente} `,
			// 		xAxis: xAxis,
			// 		yAxis: yAxis,
			// 		valueXField: "apartodvijentes",
			// 		categoryYField: "periodo",
			// 		tooltip: am5.Tooltip.new(root, {
			// 			pointerOrientation: "vertical",
			// 			labelText: "{valueX} unidad(es)"
			// 		})
			// 	})
			// );
			// series3.columns.template.setAll({
			// 	cornerRadiusTL: 5,
			// 	cornerRadiusTR: 5
			// });
			// series3.set("fill", am5.color("<?= $this->Session->read('colores.Embudo.etapa6')?>")); 
			// series3.bullets.push(function () {
			// 	return am5.Bullet.new(root, {
			// 		locationX: 1,
      		// 		locationY: 1,
			// 		sprite	 : am5.Label.new(root, {
			// 			text        : "{apartodo vigentes}",
			// 			fill        : am5.color(0x000000),
			// 			centerX: 0,
        	// 			centerY: am5.p100,
			// 			populateText: true
			// 		})
			// 	});
			// })

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
			series2.appear();
			// series3.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
			series2.data.setAll(data);
			// series3.data.setAll(data);
		});
    }
</script>