<style>
    p{
        font-size: 0.75rem;
        font-weight: 500;
    }
</style>
<div class="col-sm-12 mt-2">
    <div class="card">
        <div class="card-header bg-blue-is">
            Indicadores
        </div>
        <div class="card-block" >
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-lg-2 col-sm-12 mt1">
                        <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 3, $cliente['Cliente']['id'])) ?>'>
                        <div class="card-block border-300 mt1" style="text-align: center;display: flex;flex-direction: column;align-items: center;border-radius:8px;">
                            <div style="border: 2px solid #ABEBE9;border-radius: 100px;width: 30px;padding: 2px;height: 30px;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-envelope" style="color:#ABEBE9"></i>
                            </div>
                            <div><?= $mails ?></div>
                            <div><p>Email(s)</p></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 mt1">
                        <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 4, $cliente['Cliente']['id'])) ?>'>
                        <div class="card-block border-300 mt1" style="text-align: center;display: flex;flex-direction: column;align-items: center;border-radius:8px;">
                            <div style="border: 2px solid #9BE7E5;border-radius: 100px;width: 30px;padding: 2px;height: 30px;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-phone" style="color:#9BE7E5;"></i>
                            </div>
                            <div><?= $llamadas ?></div>
                            <div><p>Llamada(s)</p></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 mt1">
                        <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 3, $cliente['Cliente']['id'])) ?>'>
                        <div class="card-block border-300 mt1" style="text-align: center;display: flex;flex-direction: column;align-items: center;border-radius:8px;">
                            <div style="border: 2px solid #c6c6c6;border-radius: 100px;width: 30px;padding: 2px;height: 30px;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-building" style="color:#c6c6c6;"></i>
                            </div>
                            <div><?= sizeof($cliente['Lead'])?></div>
                            <div><p>Propuesta(s)</p></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 mt1">
                        <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 5, $cliente['Cliente']['id'])) ?>'>
                        <div class="card-block border-300 mt1" style="text-align: center;display: flex;flex-direction: column;align-items: center;border-radius:8px;">
                            <div style="border: 2px solid #FBD89B;border-radius: 100px;width: 30px;padding: 2px;height: 30px;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-home" style="color:#FBD89B;"></i>
                            </div>
                            <div><?= $citas ?></div>
                            <div><p>Cita(s)</p></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 mt1">
                        <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 10, $cliente['Cliente']['id'])) ?>'>
                        <div class="card-block border-300 mt1" style="text-align: center;display: flex;flex-direction: column;align-items: center;border-radius:8px;">
                            <div style="border: 2px solid #79DFDD;border-radius: 100px;width: 30px;padding: 2px;height: 30px;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-map-marker" style="color:#79DFDD;"></i>
                            </div>
                            <div><?= $visitas ?></div>
                            <div><p>Visita(s)</p></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 mt1">
                        <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 3, $cliente['Cliente']['id'])) ?>'>
                        <div class="card-block border-300 mt1" style="text-align: center;display: flex;flex-direction: column;align-items: center;border-radius:8px;">
                            <div style="border: 2px solid #376D6C;border-radius: 100px;width: 30px;padding: 2px;height: 30px;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-share-alt" style="color:#376D6C;"></i>
                            </div>
                            <div><?= $whatsapp ?></div>
                            <div><p>Compartir</p></div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- <div class="mt-1">
                    <a href='<?= Router::url(array("controller" => "clientes", "action" => "log_clientes", 3, $cliente['Cliente']['id'])) ?>'>
                        <div class="card bg-emails no-border card-indicator">
                            <div class="card-block">
                                <div class="row">
                                    <div class="icon-pad-left">
                                        <span class="fa-stack fa-sm" style="font-size: 2.5rem;">
                                            <i class="fa fa-circle fa-stack-2x"></i>
                                            <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </div>
                                    <div>
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

                WhatsApp 
                
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
                </div> -->

            <!-- </div> -->
        </div>
    </div>
</div>
