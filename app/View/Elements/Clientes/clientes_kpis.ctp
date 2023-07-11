<div class="col-sm-12 col-lg-6 mt-2">
    <div class="card">
        <div class="card-header bg-blue-is">
            Indicadores de Seguimiento de Cliente
        </div>
        <div class="card-block">
                
                <style>
                    .text-info-indicator{
                        font-size: 1.2rem;
                        font-weight: 600;
                    }
                </style>
                
                <div class="col-sm-12 col-lg-6 mt-1">
                    <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 3, $cliente['Cliente']['id'])) ?>'>
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
                                            <?= $mails ?>
                                            <p>Email(s)</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-sm-12 col-lg-6 mt-1">
                    <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 4, $cliente['Cliente']['id'])) ?>'>
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
                                            <?= $llamadas ?>
                                            <p>Llamada(s)</p>
                                        </span>
                                    </div>
                                </div>
                                

                            </div>
                        </div>
                    </a>
                </div>
                    

                <div class="col-sm-12 col-lg-6 mt-1">
                    <a href="#">
                        <div class="card bg-opciones no-border card-indicator">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-lg-6 icon-pad-left">
                                        <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                            <i class="fa fa-circle fa-stack-2x"></i>
                                            <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="text-info-indicator">
                                            <?= sizeof($cliente['Lead'])?>
                                            <p>Opcione(s)</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-lg-6 mt-1">
                    <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 5, $cliente['Cliente']['id'])) ?>'>
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
                                            <?= $citas ?>
                                            <p>Cita(s)</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-lg-6 mt-1">
                    <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 10, $cliente['Cliente']['id'])) ?>'>
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
                                            <?= $visitas ?>
                                            <p>Visita(s)</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- WhatsApp -->
                
                <div class="col-sm-12 col-lg-6 mt-1">
                    <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 11, $cliente['Cliente']['id'])) ?>'>
                        <div class="card bg-visitas no-border card-indicator">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-lg-6 icon-pad-left">
                                        <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                            <i class="fa fa-circle fa-stack-2x"></i>
                                            <i class="fa fa-whatsapp fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="text-info-indicator">
                                            <?= $whatsapp ?>
                                            <p>WhatsApp</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            <!-- </div> -->
        </div>
    </div>
</div>
