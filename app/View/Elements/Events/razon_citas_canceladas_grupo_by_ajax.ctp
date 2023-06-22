<style>
    #cliente_motivo_cancelacion_cita_grupo{
        width: 100%;
        height: 500px;
    }
</style>
<div class="card">
    <div class="card-header bg-blue-is cursor">
            RAZONES DE CITAS CANCELADAS DEL PERIODO 
        <span style="float:right">
            Total: <span id="citasCanceladasT"></span>
        </span> 
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="cliente_motivo_cancelacion_cita_grupo"></div>
         
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="cliente_motivo_cancelacion_cita_grupo_periodo_tiempo"></small>
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
    function graficaMotivoCancelacionCitaGrupo( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "events", "action" => "citas_cancelacion_grupo")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
                console.log(response);
            //   draw( response );
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    }
    // Es el metodo de la grafica.
    function drawClienteMotiviCancelacion( response ) {
        am5.ready(function () {
			var root = am5.Root.new("cliente_motivo_cancelacion_cita");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5percent.PieChart.new(root, {
				layout     : root.verticalLayout,
				innerRadius: am5.percent(50)
			}));
			var series = chart.series.push(am5percent.PieSeries.new(root, {
				name           : "Cancelacion de citas",
				valueField     : "cantidad",
				categoryField  : "motivo",
				legendLabelText: "[{fill}]{category}[/]",
				legendValueText: "[bold {fill}]{value}[/]",
				
			}));
			series.slices.template.set('tooltipText', '{category}: {value}');
			series.labels.template.set('text', '{category}: {value}');
			series.labels.template.set("visible", false);
			series.ticks.template.set("visible", false);
			
			series.labels.template.setAll({
				textType: "circular",
				centerX : 0,
				centerY : 0
			});
			var data = response;
			series.data.setAll(data);
			var legend = chart.children.push(am5.Legend.new(root, {
				centerX     : am5.percent(50),
				x           : am5.percent(50),
				marginTop   : 15,
				marginBottom: 15,
			}));
			legend.data.setAll(series.dataItems);
			series.appear(1000, 100);

		}); 
    }
</script>