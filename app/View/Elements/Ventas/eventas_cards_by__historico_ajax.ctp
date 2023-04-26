<div class="card">
    <div class="card-header bg-blue-is">
        Indicadores de desempeño historico (<small id="card_historico_periodo_tiempo"></small>)
    </div>
    <div class="card-block" style="width: 100%; height: 280px;">
    	<div class="row">
        	<div class="col-sm-12">
				<div class="row mt-1">
					<div class="col-sm-12 col-lg-6">
						<a href="#">
							<div class="widget_icon_bgclr icon_align bg-white section_border mt-1">
								<div class="float-xs-left">
									<span class="fa-stack fa-3x text-white">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-users fa-stack-1x fa-inverse text-black visit_icon"></i>
									</span>
								</div>
								<div class="text-xs-right text-black">
									<h3 class="kpi"></h3>
									<p>Lead's: <span id="leadsHistorico"></span></p>
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-12 col-lg-6">
		
						<a href="#">
							<div class="widget_icon_bgclr icon_align bg-white section_border bg-citas mt-1">
								<div class="float-xs-left">
									<span class="fa-stack fa-3x text-white">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-home fa-stack-1x fa-inverse text-black visit_icon"></i>
									</span>
								</div>
								<div class="text-xs-right text-black">
									<h3 class="kpi"><?= $citas ?></h3>
									<p>Cita(s)  <span id="citasHistorico"></span></p>
								</div>
							</div>
						</a>

					</div>
					<div class="col-sm-12 col-lg-6">
				
						<a href="#">
							<div class="widget_icon_bgclr icon_align bg-white section_border bg-visitas mt-1">
								<div class="float-xs-left">
									<span class="fa-stack fa-3x text-white">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-check-circle fa-stack-1x fa-inverse text-black visit_icon"></i>
									</span>
								</div>
								<div class="text-xs-right text-black">
									<h3 class="kpi"><?= $visitas ?></h3>
									<p>Visita(s): <span id="vicitasHistorico"></span> </p>
								</div>
							</div>
						</a>

					</div>
					<div class="col-sm-12 col-lg-6">
						<a href="#">
							<div class="widget_icon_bgclr icon_align bg-white section_border bg-emails mt-1">
								<div class="float-xs-left">
									<span class="fa-stack fa-3x text-white">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-envelope fa-stack-1x fa-inverse text-black visit_icon"></i>
									</span>
								</div>
								<div class="text-xs-right text-black">
									<h3 class="kpi"><?= $mails ?></h3>
									<p>Email's: <span id="emailsHistorico"></span></p>
								</div>
							</div>
						</a>

					</div>
				</div>
			</div>
    	</div>
	</div>      
</div>
<script>
    function cardHistorico( rangoFechas, cuentaId, desarrolloId ,asesorId ){  
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "events", "action" => "card_historico")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
                document.getElementById("leadsHistorico").innerHTML =response[0].cantidad;
				document.getElementById("citasHistorico").innerHTML =response[1].cantidad;
				document.getElementById("vicitasHistorico").innerHTML =response[2].cantidad;
				document.getElementById("emailsHistorico").innerHTML =response[3].cantidad;
        	    document.getElementById("card_historico_periodo_tiempo").innerHTML =response[4].cantidad;
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    }
</script>