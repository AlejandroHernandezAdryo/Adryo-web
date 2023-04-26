<div class="card card-sm">
    <div class="card-block">
        
        <div class="row">
            
            <div class="col-sm-12 col-lg-2">
                
            
                <i class="fa fa-home icon-card"></i>

            </div>

            <div class="col-sm-12 col-lg-10">
                <div class="row">
                    <div class="col-sm-12">
                        <p class='text-uppercase sub-title'>
                            Unidaes libres en corretaje
                        </p>
                    </div>
                    <div class="col-sm-12 data-card">
                        <p> <span id='kpi_corretaje_u'></span> - U </p>
                        <p> $ <span id='kpi_corretaje_sum'></span> </p>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>


<script>
    
    function kpi_corretaje( fechaInicial, fechaFinal ){

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "inmuebles", "action" => "kpi_corretaje")); ?>',
            cache: false,
            type: "POST",
            data: { fecha_inicial: fechaInicial, fecha_final: fechaFinal },
            dataType: 'json',
            success: function( response ) {
                $('#kpi_corretaje_u').html( response.q_propiedades );
                $('#kpi_corretaje_sum').html( response.sum_propiedades );
            }
        });
    }
</script>