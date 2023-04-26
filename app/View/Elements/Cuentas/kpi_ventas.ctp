<div class="card card-sm bg-green-dollar">
    <div class="card-block">
        
        <div class="row">
            
            <div class="col-sm-12 col-lg-2">
                
            
                <i class="fa fa-dollar icon-card"></i>

            </div>

            <div class="col-sm-12 col-lg-10">
                <div class="row">
                    <div class="col-sm-12">
                        <p class='text-uppercase sub-title'>
                            Total de Ventas
                        </p>
                    </div>
                    <div class="col-sm-12 card-data">
                        <p>
                            Unidades vendidas 
                        </p>
                        <p>
                            <span id="kpi-ventas-unidades"></span> / <span id="kpi-ventas-monto"></span>
                        </p>
                        
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>

<script>

function kpi_ventas( fechaInicial, fechaFinal ){

    $.ajax({
        url: '<?php echo Router::url(array("controller" => "ventas", "action" => "kpi_ventas")); ?>',
        cache: false,
        type: "POST",
        data: { fecha_inicial: fechaInicial, fecha_final: fechaFinal },
        dataType: 'json',
        success: function( response ) {
            $('#kpi-ventas-unidades').html( response['q_ventas'] );
            $('#kpi-ventas-monto').html( '$ ' + response['sum_ventas'] );
        }
    });

}
    
</script>