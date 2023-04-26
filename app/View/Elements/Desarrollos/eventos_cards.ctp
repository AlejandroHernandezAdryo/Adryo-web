<div class="card">
    <div class="card-header bg-blue-is">
        KPIs <small><?= $periodo_tiempo ?></small>
    </div>

    <div class="card-block" style="width: 100%; height: 330px;">
      <div class="row">
        <div class="col-sm-12">
		<div class="row mt-1">
	<div class="col-sm-12 col-lg-6">
				
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-users fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
					<h3 class="kpi"><?= $interesados ?></h3>
					<p>Lead's</p>
				</div>
			</div>
		</a>

	</div>
	<div class="col-sm-12 col-lg-6">
		
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border bg-citas">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-home fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
					<h3 class="kpi"><?= $citas ?></h3>
					<p>Cita(s)</p>
				</div>
			</div>
		</a>

	</div>
	<div class="col-sm-12 col-lg-6">
		
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border bg-visitas">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-check-circle fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
					<h3 class="kpi"><?= $visitas ?></h3>
					<p>Visita(s)</p>
				</div>
			</div>
		</a>

	</div>
	<div class="col-sm-12 col-lg-6">
		<a href="#">
			<div class="widget_icon_bgclr icon_align bg-white section_border bg-emails">
				<div class="float-xs-left">
					<span class="fa-stack fa-3x text-white">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-envelope fa-stack-1x fa-inverse text-black visit_icon"></i>
					</span>
				</div>
				<div class="text-xs-right text-black">
					<h3 class="kpi"><?= $mails ?></h3>
					<p>Email's</p>
				</div>
			</div>
		</a>

	</div>
</div>
        </div>
      </div>
    </div>
</div>