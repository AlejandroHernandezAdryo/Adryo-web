<div id="content" class="bg-container">
    <div class="outer">
        <div class="inner bg-container">
            <div class="row mt-5">
                <div class="col-sm-12">
                    <?= $this->Element('Desarrollos/ventas_vs_metas_anual') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    dataVentasVsMetasAnual('2021-11-01', '2021-11-16', 147);
</script>