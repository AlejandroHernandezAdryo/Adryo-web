<style>
    #grafica_medio_cliente_inactivo{
        width: 100%;
        height: 500px;
    }		
</style>
<div class="card">
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
        LEADS POR MEDIOS DE PROMOCIÓN VS CLIENTES INACTIVOS DEFINITIVOS
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_medio_cliente_inactivo" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="grafica_medio_cliente_inactivo_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
  function graficaMedioClienteInactivo( rangoFechas, medioId, desarrolloId, cuentaId,asesorId ){
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "clientes", "action" => "medios_cliente_indefinidos_mk")); ?>',
      cache: false,
      data: { rango_fechas:rangoFechas, medio_id:medioId,  desarrollo_id:desarrolloId, cuenta_id:cuentaId, user_id:asesorId },
      dataType: 'json',
      success: function ( response ) {
        let max           = 0;
        let totalInactivo = 0;
        let totalClientes = 0;
        let maxCliente    = 0;
        let maxinactivo   = 0;
        for (let i in response){
            response[i].clientes  = parseInt(response[i].clientes);
            response[i].inactivos = parseInt(response[i].inactivos);
            if ( maxCliente < response[i].clientes ) {
                maxCliente = response[i].clientes;
            }
            if ( maxinactivo < response[i].inactivos ) {
                maxinactivo = response[i].inactivos;
            }
            totalClientes +=  response[i].clientes;
            totalInactivo +=  response[i].inactivos;
        }
        max=maxCliente;
        if (max<maxinactivo) {
            max=maxinactivo;
        }
        drawGraficaMedioClienteInactivo( response, max, totalClientes, totalInactivo );
      },
    });
  }
  function drawGraficaMedioClienteInactivo(response, max, totalClientes, totalInactivo){
    am5.ready(function () {
			var root = am5.Root.new("grafica_medio_cliente_inactivo");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			root.interfaceColors.set("grid", am5.color('#bababa'));
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX      : true,
				panY      : true,
				wheelY    : "zoomX",
				wheelX    : "panX",
				pinchZoomX:  true
			}));
			var cursor      = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineY.set("visible", false);
			var xRenderer   = am5xy.AxisRendererX.new(root, {
				minGridDistance: 30
			});
			xRenderer.labels.template.setAll({
				rotation    : -90,
				centerY     : am5.p50,
				centerX     : am5.p100,
				paddingRight: 15
			});
			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				maxDeviation: 0.3,
				categoryField: "medio",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min         : 0,
				max			: (max)*1.1,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Leads / Inactivos",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Leads  : ${totalClientes}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "clientes",
				categoryXField        : "medio",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Cliente')?>")); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `Inactivos: ${totalInactivo}`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "inactivos",
  				categoryXField: "medio",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
    				labelText: "[bold]{name}[/]: {valueY}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.InactivoDefinitivo')?>")); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#.')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			});
			var legend = chart.children.push(
				am5.Legend.new(root, {
					centerX: am5.p50,
					x      : am5.p50
				})
			);
			legend.data.setAll(chart.series.values);
			chart.appear(1000, 100);
			series.appear();	
			series1.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
		});
  }

</script>