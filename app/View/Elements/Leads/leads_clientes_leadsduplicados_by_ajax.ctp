<style>
    #grafica_leads_clientes_leadsDuplicados{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
        TOTAL DE LEADS, LEADS DUPLICADOS Y CLIENTES POR MEDIO DE PROMOCIÓN
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_leads_clientes_leadsDuplicados" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="leads_clientes_leadsDuplicados_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<?php
  echo $this->Html->script([
    'components',
    'custom',
    
    // Graficas de Google C:\xampp\htdocs\cake\cakephp\app\View\Elements\Leads\leads_clientes_leadsduplicados_by_ajax.ctp
    'https://www.gstatic.com/charts/loader.js',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0',

  ], array('inline'=>false));
?>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
    function graficaLeadsDuplicadosClientesPromocion(rangoFechas, medioId,  desarrolloId, cuentaId ){
        $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "leads", "action" => "grafica_leads_clientes_leadsDuplicados")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
        dataType: 'json',
        success: function ( response ) {
          var maximaDuplicado = 0;
        	var DuplicadoTotal  = 0;
        	var cantidadTotal   = 0;
        	var clientesTotales = 0;
        	var maximoLead      = 0;
          var maximoCLiente   =0;
          for (let i in response){      
            response[i].leads     = parseInt(response[i].leads);
            response[i].clientes = parseInt(response[i].clientes);
            response[i].leads_duplicados    = parseInt(response[i].leads_duplicados);

            if(maximaDuplicado<response[i].leads_duplicados){
                maximaDuplicado = response[i].leads_duplicados;
            }
            if(maximoLead<response[i].leads){
              maximoLead = response[i].leads;
            }
            if(maximoCLiente<response[i].clientes){
              maximoCLiente = response[i].clientes;
            }

            DuplicadoTotal  += response[i].leads_duplicados;
            cantidadTotal   += response[i].leads;
            clientesTotales += response[i].clientes;

          }
          document.getElementById("leads_clientes_leadsDuplicados_periodo_tiempo").innerHTML =rangoFechas;
          if(maximoLead==0){
            maximoLead=10;
          }
          if (maximaDuplicado==0) {
            maximaDuplicado=10;
          }
          if (maximoLead<maximoCLiente) {
            maximoLead=maximoCLiente;
          }
          drawGraficaLeadsDuplicadosClientesPromocion( response,maximaDuplicado,DuplicadoTotal,cantidadTotal,clientesTotales, maximoLead );

        },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
    }//0: {medio: 'Facebook', leads: '72', clientes: '63', leads_duplicados: 9}
    function drawGraficaLeadsDuplicadosClientesPromocion( response,maximaDuplicado,DuplicadoTotal,cantidadTotal,clientesTotales, maximoLead ) {
      am5.ready(function () {
        var root = am5.Root.new("grafica_leads_clientes_leadsDuplicados");
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
          min:0,
          max:(maximoLead)*1.2,
          renderer    : am5xy.AxisRendererY.new(root, {})
        }));
        yAxis.children.unshift(
          am5.Label.new(root, {
            rotation: -90,
            text: "Leads y Clientes",
            y: am5.p50,
            centerX: am5.p50
          })
        );
        var data               = response;
        var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
        var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer    : paretoAxisRenderer,
            min         : 0,
            max         : (maximaDuplicado)*1.2,
            strictMinMax: true
        }));
        paretoAxisRenderer.grid.template.set("forceHidden", true);
        paretoAxis.set("numberFormat", "#");
        paretoAxis.children.push(
          am5.Label.new(root, {
            rotation: -90,
            text: "Leads Duplicados",
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
        // series.set("fill", am5.color('#FFA500')); 
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
            name: `Clientes: ${clientesTotales}`,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "clientes",
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
			  series1.set("fill", am5.color("<?= $this->Session->read('colores.Cliente')?>")); 

        // series1.set("fill", am5.color('#FF6B0D')); 
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
            name               : `Leads Dulpicado: ${DuplicadoTotal}`,
            xAxis              : xAxis,
            yAxis              : paretoAxis,
            valueYField        : "leads_duplicados",
            categoryXField     : "medio",
            tooltip            : am5.Tooltip.new(root, {
              pointerOrientation: "horizontal",
              labelText         : "[bold]{name}[/]: {valueY}"
            })
          })
        );
        series2.strokes.template.setAll({
          stroke: am5.color('#FF6B0D'),
          strokeWidth  : 3,
          templateField: "strokeSettings"
        });
        // series2.fills.template.setAll({
        //   fill: am5.color(0xff621f),
        //   fillOpacity: 0.5,
        //   visible: true
        // });
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