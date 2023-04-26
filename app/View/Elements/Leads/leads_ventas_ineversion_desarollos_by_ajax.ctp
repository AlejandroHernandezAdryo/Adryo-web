<style>
    #grafica_leads_ventas_inversion{
        width: 100%;
        height: 500px;
    }
		
</style>
<div class="modal fade" id="">
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
                leads de los desarrollos seleccionados e inversión
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header bg-blue-is cursor" data-target='#' data-toggle='modal'>
	LEADS, INVERSIÓN EN PUBLICIDAD Y VENTAS POR MEDIO DE PROMOCIÓN  <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="grafica_leads_ventas_inversion"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="leads_ventas_inversion_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
  function gradicaLeadsVentasInversionDesarrollos(rangoFechas, medioId,  desarrolloId, cuentaId  ){
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "leads", "action" => "grafica_ventas_leads_desarrollos")); ?>',
      cache: false,
      data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
      dataType: 'json',
      success: function ( response ) {
        var maximaInversion = 0;
        var InversionTotal  = 0;
        var cantidadTotal   = 0;
        var ventaTotal      = 0;
        var maximoLead      = 0;
        var count           = 0;
          for (let i in response){
                  
            response[i].leads     = parseInt(response[i].leads);
                  response[i].inversion = parseInt(response[i].inversion);
                  response[i].ventas    = parseInt(response[i].ventas);

            if(maximaInversion<response[i].inversion){
                maximaInversion = response[i].inversion;
            }
            if(maximoLead<response[i].leads){
              maximoLead = response[i].leads;
            }

            InversionTotal += response[i].inversion;
            cantidadTotal  += response[i].leads;
            ventaTotal     += response[i].ventas;

          }
        document.getElementById("leads_ventas_inversion_periodo_tiempo").innerHTML =rangoFechas;
        if(maximoLead==0){
          maximoLead=10;
        }
        if (maximaInversion==0) {
          maximaInversion=10;
        }

        drawGradicaLeadsVentasInversionDesarrollos( response,maximaInversion,InversionTotal,cantidadTotal,ventaTotal, maximoLead);
      },
			error: function ( err ){
        console.log( err.responseText );
			}
    });
  }
  function drawGradicaLeadsVentasInversionDesarrollos( response,maximaInversion,InversionTotal,cantidadTotal,ventaTotal, maximoLead ) {
    am5.ready(function () {
			var root = am5.Root.new("grafica_leads_ventas_inversion");
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
        		min   		: 0,
				max         : (maximoLead)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Leads e Inversión",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaInversion)*1.2,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat", "#");
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "Ventas",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Leads : ${cantidadTotal}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "leads",
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
			series.set("fill", am5.color("<?= $this->Session->read('colores.Lead')?>")); 
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
			
			//
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
				name: `Inversión:$  ${InversionTotal}`,
				xAxis: xAxis,
				yAxis: paretoAxis,
				valueYField: "inversion",
					categoryXField: "medio",
					sequencedInterpolation: true,
				tooltip: am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]:{valueY}"
				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Inversion')?>")); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#,###')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			});
			//
			var series2 = chart.series.push(am5xy.ColumnSeries.new(root, {
  			name: `Ventas: ${ventaTotal}`,
  			xAxis: xAxis,
  			yAxis: yAxis,
  			valueYField: "ventas",
				categoryXField: "medio",
				sequencedInterpolation: true,
  			tooltip: am5.Tooltip.new(root, {
    			labelText: "[bold]{name}[/]:{valueY}"
  			})
			}));
			series2.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series2.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 
			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#,###')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			});
      		
			chart.set("cursor", am5xy.XYCursor.new(root, {}));
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
			series2.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
      series2.data.setAll(data);
	  });
  }
</script>