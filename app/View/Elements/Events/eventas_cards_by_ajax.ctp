<div class="card">
    <div class="card-header bg-blue-is">
        Indicadores de desempeño del periodo (<small id="card_perio_periodo_tiempo"></small>)
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
									<p>Leads: <span id="leadsPerio"></span></p>
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
									<p>Cita(s)  <span id="citasPerio"></span></p>
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
									<p>Visita(s): <span id="vicitasPerio"></span> </p>
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
									<p>Correos: <span id="emailsPerio"></span></p>
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
    function cardsPeriodo( rangoFechas, cuentaId, desarrolloId ,asesorId ){  
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "events", "action" => "card_periodo")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
         		
					document.getElementById("leadsPerio").innerHTML =response[0].cantidad;
					document.getElementById("citasPerio").innerHTML =response[1].cantidad;
					document.getElementById("vicitasPerio").innerHTML =response[2].cantidad;
					document.getElementById("emailsPerio").innerHTML =response[3].cantidad;
				
				
        	    document.getElementById("card_perio_periodo_tiempo").innerHTML =rangoFechas;
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    }
</script>