<style>
    #grafica_desarrollos_leads{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
    LEADS E INVERSIÓN EN PUBLICIDAD POR DESARROLLO(S) SELECCIONADO(S)
    </div>
    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_desarrollos_leads" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="desarrollos_leadsperiodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script>
    function graficaLeadsPorDesarrollo(rangoFechas, medioId,  desarrolloId, cuentaId  ){
      $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "grafica_leads_desarrollos")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
        dataType: 'json',
        success: function ( response ) {
          var maximaInversion = 0;
        	var InversionTotal  = 0;
        	var maximoLead      = 0;
        	var cantidadTotal   = 0;
          for (let i in response){
            response[i].leads     = parseInt(response[i].leads);
            response[i].inversion = parseInt(response[i].inversion);
            if(maximaInversion<response[i].inversion){
                maximaInversion = response[i].inversion;
            }
            if(maximoLead<response[i].leads){
              maximoLead = response[i].leads;
            }
      
            InversionTotal += response[i].inversion;
            cantidadTotal  += response[i].leads;
          }
        if(maximoLead==0){
				  maximoLead=10;
			  }
			  if (maximaInversion==0) {
				  maximaInversion=10;
			  }
        document.getElementById("desarrollos_leadsperiodo_tiempo").innerHTML =rangoFechas;
        drawGraficaLeadsPorDesarrollo( response, maximaInversion, maximoLead, InversionTotal, cantidadTotal );
      },
        error: function ( err ){
        console.log( err.responseText );
        }
		  });
    }
    function drawGraficaLeadsPorDesarrollo( response, maximaInversion, maximoLead, InversionTotal, cantidadTotal ){
      am5.ready(function () {
        var root = am5.Root.new("grafica_desarrollos_leads");
        root.setThemes([
          am5themes_Animated.new(root)
        ]);
        root.interfaceColors.set("grid", am5.color('#bababa'));
        root.numberFormatter.setAll({
          numberFormat: "#,###.00",
          numericFields: ["valueY"]
        });
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
          categoryField: "desarollo",
          renderer: xRenderer,
          tooltip: am5.Tooltip.new(root, {})
        }));
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
          maxDeviation: 0.3,
          min         : 0,
          max         :(maximoLead)*1.3,
          renderer    : am5xy.AxisRendererY.new(root, {})
        }));
        yAxis.children.unshift(
          am5.Label.new(root, {
            rotation: -90,
            text: "Leads",
            y: am5.p50,
            centerX: am5.p50
          })
        );
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
            text: "Costo X Leads e Inversión",
            y: am5.p50,
            centerX: am5.p50
          })
        );
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
          name                  : `Leads : ${cantidadTotal}`,
          xAxis                 : xAxis,
          yAxis                 : yAxis,
          valueYField           : "leads",
          categoryXField        : "desarollo",
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
        var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: `Inversión:$ ${InversionTotal}`,
            xAxis: xAxis,
            yAxis: paretoAxis,
            valueYField: "inversion",
            categoryXField: "desarollo",
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
        chart.set("cursor", am5xy.XYCursor.new(root, {}));
        var legend = chart.children.push(
          am5.Legend.new(root, {
            centerX: am5.p50,
            x      : am5.p50
          })
        );
        var data = response;
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