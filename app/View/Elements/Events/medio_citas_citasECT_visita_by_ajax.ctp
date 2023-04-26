<?php
    echo $this->Html->css(
        array(

            
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            'pages/new_dashboard',
           
        ),
        array('inline'=>false)); 
?>
<div class="row">
    <div class="col-sm-12 mt-1">
        <div class="card">
            <div class="card-header bg-blue-is">
                <div class="row">
                    <div class="col-sm-12">
                        ANÁLISIS DE CITAS (VIGENTES, VENCIDAS, CANCELADAS Y CONCRETADAS) Y VISITAS POR PASE POR MEDIO DE PROMOCIÓN ( <small id="medio_citas_citasETC_visitas_tiempo"></small>)
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-striped table-hover table-sm mt-2">
                    <tbody id="medio_citas_citasETC_visitas__by_ajax">
                        <thead>
                            <tr>
                                <th>MEDIO</th>
                                <th>CITAS VENCIDAS</th>
                                <th>CITAS VIGENTES</th>
                                <th>CITAS CANCELADAS</th>
                                <th>VISITAS X CITAS</th>
                                <th>CITAS TOTALES</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>

                                <th><span id=""></span></th>
                                <!-- <th><span id="totalMedioAbajo"></span></th> -->
                                <th><span id="totalCitasMedio"></span></th>
                                <th><span id="totalCitasVigentesMedio"></span></th>
                                <th><span id="totalCitasCanceladasMedio"></span></th>
                                <th><span id="totalVisitasMedio"></span></th>
                                <th><span id="totaCitasTotales"></span></th>
                                
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
    echo $this->Html->script([
        'components',
        'custom',
        // Datatables
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/simple_datatables',
        ], 
        array('inline'=>false)
    );
?>
<script>

function medioCitasCitasETCVisitas( rangoFechas, medioId,  desarrolloId, cuentaId ){

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "events", "action" => "medio_citas_visitas")); ?>',
        cache: false,
        data: {  rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId},
        dataType: 'json',
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
                $("#medio_citas_citasETC_visitas__by_ajax").html("");
                let totaCitasDesarrollo=0;
                let totaCitasmedio=0;
                let totalCitasVigentes=0;
                let totalCitasVencidas=0;
                let totalCitasCanceladas=0;
                let totaCitasTotales=0;
                let totalVisitas=0;
                for (let i in response){
                    totaCitasDesarrollo    = parseInt(response[i].citas)+ parseInt(response[i].citas_vigentes)+parseInt(response[i].citas_canceladas) + parseInt(response[i].visitas);
                    totaCitasTotales       += parseInt(response[i].citas)+ parseInt(response[i].citas_vigentes)+parseInt(response[i].citas_canceladas)+ parseInt(response[i].visitas);
                    totaCitasmedio         += parseInt(response[i].citas);
                    totalCitasVigentes     += parseInt(response[i].citas_vigentes);
                    totalCitasCanceladas   += parseInt(response[i].citas_canceladas);
                    totalVisitas           += parseInt(response[i].visitas);
                    var tr = `<tr>
                        <td>`+response[i].medio+`</td>
                        <td>`+response[i].citas+`</td>
                        <td>`+response[i].citas_vigentes+`</td>
                        <td>`+response[i].citas_canceladas+`</td>
                        <td>`+response[i].visitas+`</td>
                        <td>`+totaCitasDesarrollo +`</td>
                        </tr>`;
                    $("#medio_citas_citasETC_visitas__by_ajax").append(tr);
                    
                }
                
            document.getElementById("totalCitasMedio").innerHTML                     = totaCitasmedio;
            document.getElementById("totalCitasVigentesMedio").innerHTML             = totalCitasVigentes;
            document.getElementById("totalCitasCanceladasMedio").innerHTML           = totalCitasCanceladas;
            document.getElementById("totalVisitasMedio").innerHTML                   = totalVisitas;
            document.getElementById("totaCitasTotales").innerHTML                    = totaCitasTotales;
            document.getElementById("medio_citas_citasETC_visitas_tiempo").innerHTML = rangoFechas;   
            
        },
    });
};

</script>