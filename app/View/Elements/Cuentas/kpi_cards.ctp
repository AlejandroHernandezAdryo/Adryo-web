<style>
    h3{
        font-size: 20px !important;
    }
</style>
<div class="row mt-1">
	<div class="col-sm-12 col-lg-3">
				
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-home fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
                                    <h3 class="kpi"><?= $corretaje_libre_q ?> / <br>$<?= number_format($corretaje_libre_v[0][0]['libre_corretaje_v'],0)?></h3>
					<p>Corretaje Libre</p>
				</div>
			</div>
		</a>

	</div>
	<div class="col-sm-12 col-lg-3">
		
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border bg-citas">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-building fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
					<h3 class="kpi"><?= $desarrollos_libre_q ?></h3>
					<p>Desarrollos Libres para Comercializar</p>
				</div>
			</div>
		</a>

	</div>
	<div class="col-sm-12 col-lg-3">
		
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border bg-visitas">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-briefcase fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
					<h3 class="kpi"><?= $unidades_libre_q ?> / $<?= number_format($unidades_libre_v[0][0]['libre_corretaje_v'],0)?></h3>
					<p>Unidades para venta</p>
				</div>
			</div>
		</a>

	</div>
	<div class="col-sm-12 col-lg-3">
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border bg-emails">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-dollar fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
                                    <h3 class="kpi"><?= $unidades_monto_venta_anuales['0']['0']['total_ventas'] ?> /<br> $<?= number_format($unidades_monto_venta_anuales[0][0]['monto_venta'],0) ?></h3>
					<p>Ventas del periodo</p>
				</div>
			</div>
		</a>

	</div>
</div>