<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-calendar"></i> Prueba de eventos</h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner lter bg-container">
            <div class="card mt-1">
                <div class="card-header bg-blue-is">
                    Prueba de vista de eventos desde otras paginas
                </div>  <!-- Fin de la cabecera de la tarjeta -->

                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                                echo $this->element('Events/eventos_proximos', $eventos);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>