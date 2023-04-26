
<div class="card">
    <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
        Indicadores de Seguimiento
    </div>
    <div class="card-block">
        <style>
            .text-info-indicator{
                font-size: 1.2rem;
                font-weight: 600;
            }
        </style>
        <div class="col-sm-12 col-md-3 mt-1">
            <div class="card bg-emails no-border card-indicator">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 icon-pad-left">
                            <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-info-indicator">
                                <?= number_format($mails,0) ?>
                                <p>Email(s)</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-sm-12 col-md-3 mt-1">
            <div class="card bg-llamadas no-border card-indicator">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 icon-pad-left">
                            <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-info-indicator">
                                <?= number_format($llamadas,0) ?>
                                <p>Llamada(s)</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-sm-12 col-md-3 mt-1">
            <div class="card bg-citas no-border card-indicator">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 icon-pad-left">
                            <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-home fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-info-indicator">
                                <?= number_format($citas,0) ?>
                                <p>Cita(s)</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-sm-12 col-md-3 mt-1">
            <div class="card bg-visitas no-border card-indicator">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 icon-pad-left">
                            <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-check-circle fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-info-indicator">
                                <?= number_format($visitas,0) ?>
                                <p>Visita(s)</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top: 37px;"><small><?= $periodo_tiempo ?></small></div>
    </div>
</div>
                    