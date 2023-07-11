<style>
    #grafica_ventas_asesor{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
     Ventas Por Asesor 
	 <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_ventas_asesor" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="venta_asesor_periodo_tiempo"></small>
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
  function graficaVentasAsesor( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "ventas", "action" => "grafica_ventas_asesores")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
        dataType: 'json',
		beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
            var ventaMonto    = 0;
            var ventaunidades = 0;
			var maxima=0;
			var maxi=0;
			for (let i in response){
				response[i].venta_q = parseInt(response[i].venta_q);
				response[i].venta_v = parseInt(response[i].venta_v);
				response[i].venta_v =((response[i].venta_v)/1000000);
				ventaunidades    += response[i].venta_q ;
				ventaMonto += response[i].venta_v;
				response[i].asesor = response[i].asesor.toUpperCase();
				if(maxima<response[i].venta_q){
					maxima=response[i].venta_q;
				}
				if(maxi<response[i].venta_v){
					maxi=response[i].venta_v;
				}
			}
			ventaMonto    = ventaMonto.toFixed(2);
			ventaunidades = ventaunidades;
			document.getElementById("venta_asesor_periodo_tiempo").innerHTML =rangoFechas;
			if(maxima==1){
				maxima=2;
			}
			if(maxima<maxi){
				maxima=maxi;
			}
        	drawGraficaVentasAsesor( response, ventaunidades, ventaMonto,maxima);
       },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
    

  }
   // Es el metodo de la grafica.  0: {venta_q: '1', asesor: 'Diego Murillo Barro', venta_v: '2410737'}
  function drawGraficaVentasAsesor( response, ventaunidades, ventaMonto, maxima) {; 
		am5.ready(function () {
			var root = am5.Root.new("grafica_ventas_asesor");
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
				categoryField: "asesor",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min         : 0,
				max			: (maxima)*1.1,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Ventas Monto y Unidades",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                renderer    : paretoAxisRenderer,
                min         : 0,
                max         : (maxima)*1.4,
                strictMinMax: true
			}));
			
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Venta : ${ventaunidades} (unidades)`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "venta_q",
				categoryXField        : "asesor",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.monto')?>")); 
			// series.set("fill", am5.color("<?= $this->Session->read('colores.Lead')?>")); 
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
  				name: `ventas : ${ventaMonto} MDP`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "venta_v",
  				categoryXField: "asesor",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
    				labelText: "[bold]{name}[/]: {valueY}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
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
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 

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