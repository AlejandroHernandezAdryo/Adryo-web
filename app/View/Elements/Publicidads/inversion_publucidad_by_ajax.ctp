<style>
    #grafica_inversion_publicidad{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is">
    INVERSIÓN HISTÓRICA EN PUBLICIDAD
    <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
        <span style="float:right">
            Inversion Total <span id='InversionTotal'></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_inversion_publicidad" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="inversio_periodo_tiempo"></small>
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
  function graficaInversionPublicidad( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "publicidads", "action" => "grafica_inversion_desarrollo")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
        dataType: 'json',
        success: function ( response ) {
          var InversionTotal=0;
          var maxInversion=0;
          for (let i in response){
            response[i].inversion = parseInt(response[i].inversion);
			      InversionTotal += response[i].inversion;
            if ( InversionTotal == 0) {
              response[i].inversion=0;
            }
            if(maxInversion<response[i].inversion){
              maxInversion=response[i].inversion;
            }
          }
          
          // document.getElementById("InversionTotal").innerHTML = InversionTotal;
          $("#InversionTotal").html( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( InversionTotal ) );

        	document.getElementById("inversio_periodo_tiempo").innerHTML =rangoFechas;
          drawGraficaInversionPublicidad( response,InversionTotal,maxInversion );

        },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
    

  }
  
  // Es el metodo de la grafica. 0: {inversion: '6000', medio: 'Facebook'}
  function drawGraficaInversionPublicidad( response ,InversionTotal, maxInversion) {
    am5.ready(function () {
			var root = am5.Root.new("grafica_inversion_publicidad");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
      root.interfaceColors.set("grid", am5.color('#bababa'));
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX: true,
				panY: true,
				wheelX: "panX",
				wheelY: "zoomX",
				pinchZoomX: true
			}));
			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineY.set("visible", false);
			var xRenderer = am5xy.AxisRendererX.new(root, {
				minGridDistance: 30
			});
			xRenderer.labels.template.setAll({
				rotation: -90,
				centerY: am5.p50,
				centerX: am5.p100,
				paddingRight: 15
			});

			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				maxDeviation: 0.3,
				categoryField: "medio",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				min: 0,
				max: (maxInversion)*1.5,
				maxDeviation: 0.3,
				renderer: am5xy.AxisRendererY.new(root, {})
			}));
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name:`Inversion :$ ${InversionTotal}`,
				xAxis: xAxis,
				yAxis: yAxis,
				valueYField: 'inversion',
				sequencedInterpolation: true,
				categoryXField:	'medio' ,
				tooltip: am5.Tooltip.new(root, {
					labelText: "{categoryX}:inversion ${valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
      
      series.set("fill", am5.color("<?= $this->Session->read('colores.Inversion')?>"));
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

      var data = 0;

      if( response ){
        data = response;
      }
      
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series.appear(1000);
			chart.appear(1000, 100);
		});   
  }
</script>