<div class="card card-sm bg-blue-is">
    <div class="card-block">
        
        <div class="row">
            
            <div class="col-sm-12 col-lg-2">
                
                <i class="fa fa-building icon-card"></i>

            </div>

            <div class="col-sm-12 col-lg-10">
                <div class="row">
                    <div class="col-sm-12">
                        <p class='text-uppercase sub-title'>
                            Desarrollos libres
                        </p>
                    </div>
                    <div class="col-sm-12 card-data">
                        <p> Cantidad de Desarrollos <span class='text-sm-right' id='kpi_desarrollos_q'></span></p>
                        <p> Unidades de Desarrollo para venta <br>
                            <span class='text-sm-right' id='kpi_desarrollos_u'></span> / <span class='text-sm-right' id='kpi_desarrollos_t'></span>
                        </p>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>

<script>
    
    function kpi_desarrollos( fechaInicial, fechaFinal ){

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "kpi_desarrollos")); ?>',
            cache: false,
            type: "POST",
            data: { fecha_inicial: fechaInicial, fecha_final: fechaFinal },
            dataType: 'json',
            success: function( response ) {
                $('#kpi_desarrollos_q').html( response['q_desarrollo'] );
                $('#kpi_desarrollos_u').html( response['tot_inmuebles'] );
                $('#kpi_desarrollos_t').html( '$ ' + response['sum_precio_inmuebles'] );
            }
        });

    }
</script>
    
</script>