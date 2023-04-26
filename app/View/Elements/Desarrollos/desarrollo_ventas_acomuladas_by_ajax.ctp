<style>
    #metas_ventas_acomuladas_desarrollo{
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
              Esta grafica esta enfocada a la tabla de objetivos de ventas, 
              los filtros estan enfocados en la fecha de creación de los objetivos
              y por desarrollo.

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
    <div class="card-header bg-blue-is cursor" data-toggle='modal'>
      VENTAS EN UNIDADES Y MONTO EN MDP 
	  <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="metas_ventas_acomuladas_desarrollo" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="metas_ventas_acomuladas_periodo_tiempo"></small>
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
  function graficaVentasAcomuladasDesarrollo( rangoFechas, cuentaId, desarrolloId ,asesorId ){ 
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "grafica_ventas_acomuladas")); ?>',
      cache: false,
      data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
      dataType: 'json',
      success: function ( response ) {
        var ventasTotalMonto = 0;
        var ventaTotal       = 0;
		var maxAcomulado     = 0;
		var max=0;
        for (let i in response){
          	response[i].objetivo_monto  = parseInt(response[i].objetivo_monto);
          	response[i].objetivo_q = parseInt(response[i].objetivo_q);
          	response[i].ventas_q    = parseInt(response[i].ventas_q);
          	response[i].ventas_monto    = parseInt(response[i].ventas_monto);
			response[i].ventas_monto=((response[i].ventas_monto)/1000000);
		  	ventasTotalMonto += response[i].ventas_monto ;
        	ventaTotal       +=	response[i].ventas_q;
			if(maxAcomulado<response[i].ventas_monto){
				maxAcomulado=response[i].ventas_monto;
			}
			if(max<response[i].ventas_q){
				max=response[i].ventas_q;
			}
        }
		if (max>maxAcomulado) {
			maxAcomulado=max;
		}
		ventasTotalMonto = ventasTotalMonto.toFixed(2)
		document.getElementById("metas_ventas_acomuladas_periodo_tiempo").innerHTML =rangoFechas;
        drawVentasAcomuladasDesarrollo(response,ventasTotalMonto,ventaTotal,maxAcomulado);

      },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
  }
  function drawVentasAcomuladasDesarrollo(response,ventasTotalMonto,ventaTotal, maxAcomulado){
      	am5.ready(function () {
			var root = am5.Root.new("metas_ventas_acomuladas_desarrollo");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			//
			root.numberFormatter.setAll({
				numberFormat: "#a",

				// Group only into M (millions), and B (billions)
				bigNumberPrefixes: [
					{ number: 1e6, suffix: "MDP" },
					{ number: 1e9, suffix: "B" }
				],

				// Do not use small number prefixes at all
				smallNumberPrefixes: []
			});
			root.interfaceColors.set("grid", am5.color('#bababa'));
			//
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
				categoryField: "periodo",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min: 0,
				max: (maxAcomulado)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Ventas en unidades y Monto en MDP",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data = response;
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `ventas: ${ventaTotal} (unidades)`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "ventas_q",
				categoryXField        : "periodo",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
                    labelText: "{categoryX}: venta {valueY} (unidades)"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : " {valueY}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `ventas monto:$ ${ventasTotalMonto} MDP`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "ventas_monto",
  				categoryXField: "periodo",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
                    labelText: "{categoryX}:Monto {valueYWorking.formatNumber('#.# a')}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.monto')?>")); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#.# a')}",
						fill: root.interfaceColors.get("alternativeText"),
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