<style>
    #ventasVisitas{
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
                ventas con visitas del desarrollo
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
		VENTAS VS VISITAS
		<!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="ventasVisitas"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="ventas_visitas_periodo_tiempo"></small>
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
  	function graficaVentasVisitasDesarrollo( rangoFechas, cuentaId, desarrolloId ,asesorId ){ 
		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "grafica_ventas_visitas_desarrollo")); ?>',
			cache: false,
			data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
			dataType: 'json',
			success: function ( response ) {
			var visitasTotal=0;
			var ventaTotal=0;
			var maxVisitas=0;
			var max=0;
			for (let i in response){
				response[i].ventas  = parseInt(response[i].ventas);
				response[i].visitas = parseInt(response[i].visitas);
				ventaTotal 	   += response[i].ventas;
				visitasTotal   += response[i].visitas;
				if(maxVisitas<response[i].visitas){
					maxVisitas=response[i].visitas;
				}
				if(max<response[i].ventas){
					max=response[i].ventas;
				}
			}
			if (maxVisitas==0) {
				maxVisitas=ventaTotal;
			}
			if (maxVisitas<max) {
				maxVisitas=max;
			}
			drawGraficaVentasVisitas(response, visitasTotal ,ventaTotal, maxVisitas );
			},
			error: function ( err ){
			console.log( err.responseText );
			}
		});
  	}
  	function drawGraficaVentasVisitas(response, visitasTotal ,ventaTotal, maxVisitas ) {
    	am5.ready(function () {
			var root = am5.Root.new("ventasVisitas");
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
			root.interfaceColors.set("grid", am5.color('#bababa'));
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
        		min: 0,
				max: (maxVisitas)*1.5,
				maxDeviation: 0.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			var data = response;
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `Visitas: ${visitasTotal} `,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "visitas",
  				categoryXField: "periodo",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
                    labelText: "{categoryX}:visitas {valueY}"
  				})
			}));
			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			
            
			series.set("fill", am5.color("<?= $this->Session->read('colores.Visita')?>")); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueY}",
						fill: root.interfaceColors.get("alternativeText"),
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			});

			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Ventas: ${ventaTotal} (unidades)`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "ventas",
				categoryXField        : "periodo",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
                    labelText: "{categoryX}: venta {valueY} (unidades)"
				})
			}));

			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			    
		
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 
			series1.bullets.push(function () {
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