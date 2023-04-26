<style>
    #metas_ventas_dinero{
        width: 100%;
        height: 500px;
    }
		
</style>
<!-- Modal para la informacion de la grafica. -->
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
        META VS. VENTAS ($ MONTO EN MDP)
		<!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="metas_ventas_dinero" class="grafica no"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="ventas_vs_metas_dinero_periodo_tiempo"></small>
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
    function graficaVentasMetasDashDinero( rangoFechas, cuentaId, desarrolloId ,asesorId ){ 
          $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "metas_cuenta_desh")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
			// beforeSend: function () {
            // 	$("#overlay").fadeIn();
        	// },
            success: function ( response ) {
				var objetivo  = 0;
				var ventasmonto = 0;
				var cumplido  = 0;
				var maxObjetivo  = 0;
				var maxventaDash  = 0;
				for (let i in response){
					response[i].objetivo_monto = parseInt(response[i].objetivo_monto);
                	response[i].objetivo_q     = parseInt(response[i].objetivo_q);
                	response[i].ventas_q       = parseInt(response[i].ventas_q);
                	response[i].ventas_monto   = parseInt(response[i].ventas_monto);
                    response[i].objetivo_monto=((response[i].objetivo_monto)/1000000);
			        response[i].ventas_monto=((response[i].ventas_monto)/1000000);
					ventasmonto  += response[i].ventas_monto;
					objetivo     += response[i].objetivo_monto;
                    if(maxObjetivo<response[i].objetivo_monto){
                        maxObjetivo=response[i].objetivo_monto;
                    }
					if(maxventaDash<response[i].ventas_monto){
                        maxventaDash=response[i].ventas_monto;
                    }
                    
            	}
				if (maxventaDash>maxObjetivo) {
					maxObjetivo=maxventaDash;
					
				}
				if(objetivo==0){
					cumplido=0;
				}else{
					cumplido=((ventasmonto/objetivo)*100);
				}
                if (maxObjetivo==0) {
                    maxObjetivo=10;
                }
				cumplido = cumplido.toFixed(2);
				ventasmonto = ventasmonto.toFixed(2);
				document.getElementById("ventas_vs_metas_dinero_periodo_tiempo").innerHTML =rangoFechas;
                drawVentasMetasDashDinero(response,ventasmonto,objetivo,cumplido,maxObjetivo);
                // console.log(response);
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    }

    function drawVentasMetasDashDinero(response,ventasmonto,objetivo,cumplido,maxObjetivo){

		// Validacion de max monto de % de cumplimiento
		var maxCumplido = 0;

		for( let i in response ){
			if(maxCumplido<response[i].cumplido_monto){
				maxCumplido = response[i].cumplido_monto;
			}
		}

        am5.ready(function () {
			var root = am5.Root.new("metas_ventas_dinero");
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
				maxDeviation: 0,
				categoryField: "periodo",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0,
        		min: 0,
                max         : maxObjetivo * 1.2,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: " Meta / $ Monto (MDP )",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : maxCumplido * 1.2,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "% De cumplimiento",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			paretoAxis.set("numberFormat", "#");
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Metas Monto Objetivo: ${objetivo} (MDP)`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "objetivo_monto",
				categoryXField        : "periodo",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
                    labelText: "{categoryX}: Meta {valueY} (mon)"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color('#BCFB74')); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						// centerY: 0,
						// centerX: am5.p50,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `Venta Monto: ${ventasmonto} (monto)`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "ventas_monto",
  				categoryXField: "periodo",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
                    labelText: "{categoryX}: vendidas {valueY} (mon)"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color('#6FAD47')); 
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
			var series2 = chart.series.push(
				am5xy.LineSeries.new(root, {
					name               : `% De cumplimiento: ${cumplido}`,
					xAxis              : xAxis,
					yAxis              : paretoAxis,
					valueYField        : "cumplido_monto",
					categoryXField     : "periodo",
					tooltip            : am5.Tooltip.new(root, {
						pointerOrientation: "horizontal",
						labelText         :"% De cumplimiento: {valueY}%"
					})
				})
			);

			series2.strokes.template.setAll({
				strokeWidth  : 3,
				templateField: "strokeSettings"
			});
			series2.data.setAll(data);
			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					sprite      : am5.Circle.new(root, {
						strokeWidth: 3,
						stroke     : series2.get("stroke"),
						radius     : 5,
						fill       : root.interfaceColors.get("background")
					})
				});
			});
			chart.set("cursor", am5xy.XYCursor.new(root, {}));
			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite   : am5.Label.new(root, {
						text    : "{valueYWorking.formatNumber('#.')}",
						fill    : root.interfaceColors.get("alternativeText"),
						centerY : 0,
						centerX : am5.p50,
						fill    : am5.color(0x000000),
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