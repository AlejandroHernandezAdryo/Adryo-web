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
                        ANÁLISIS DE CITAS (VIGENTES, VENCIDAS, CANCELADAS Y CONCRETADAS) Y VISITAS POR PASE POR MEDIO DE PROMOCIÓN ( <small id="alisis_citas_visitasCancelacion_desarrollos_tiempo"></small>)
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-striped table-hover table-sm mt-2">
                    <tbody id="alisis_citas_visitas_cancelacion__by_ajax">
                        <thead>
                            <tr>
                                <th>DESARROLLO</th>
                                <th>TOTAL DE CITAS Y VISITAS</th>
                                <th>CITAS VIGENTES</th>
                                <th>CITAS VENCIDAS</th>
                                <th>CITAS CANCELADAS</th>
                                <th>CITA A VISITA</th>
                                <th>VISITAS(PASE/WALKING/SHOWROOM)</th>
                                <th>VISITAS TOTALES</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th><span id="totaCitasDesarrollo"></span></th>
                                <th><span id="totalCitasVigentes"></span></th>
                                <th><span id="totalCitasVencidas"></span></th>
                                <th><span id="totalCitasCanceladas"></span></th>
                                <th><span id="totalVisitas"></span></th>
                                <th><span id="totalVisitasPase"></span></th>
                                <th><span id="totalVisitasPaseJuntas"></span></th>
                                
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

    function tablanAlisisCitasVisitasCancelacion( rangoFechas, cuentaId, desarrolloId ,asesorId ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "events", "action" => "citas_visitas_cancalaciones")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                    $("#alisis_citas_visitas_cancelacion__by_ajax").html("");
                    let totaCitasDesarrollo=0;
                    let totalCitasVigentes=0;
                    let totalCitasVencidas=0;
                    let totalCitasCanceladas=0;
                    let totalVisitas=0;
                    let totalVisitasPase=0;
                    let totalVisitasPaseJuntas=0;
                    for (let i in response){
                        // totaCitasDesarrollo    += parseInt(response[i].citas_vigantes)+ parseInt(response[i].citas_vencidas)+parseInt(response[i].citas_canceladas) +parseInt(response[i].citas_canceladas);
                        totaCitasDesarrollo    += parseInt(response[i].citas_vigantes)+ parseInt(response[i].citas_vencidas)+parseInt(response[i].citas_canceladas) + parseInt(response[i].visitas);
                        totalCitasVigentes     += parseInt(response[i].citas_vigantes);
                        totalCitasVencidas     += parseInt(response[i].citas_vencidas);
                        totalCitasCanceladas   += parseInt(response[i].citas_canceladas);
                        totalVisitas           += parseInt(response[i].visitas);
                        totalVisitasPase       += parseInt(response[i].visitas_showRoom);
                        totalVisitasPaseJuntas += parseInt(response[i].visitas_showRoom)+parseInt(response[i].visitas);
                        var tr = `<tr>
                            <td>`+response[i].nombre+`</td>
                            <td>`+totaCitasDesarrollo +`</td>
                            <td>`+response[i].citas_vigantes+`</td>
                            <td>`+response[i].citas_vencidas+`</td>
                            <td>`+response[i].citas_canceladas+`</td>
                            <td>`+response[i].visitas+`</td>
                            <td>`+response[i].visitas_showRoom+`</td>
                            <td>`+totalVisitasPaseJuntas+`</td>
                            </tr>`;
                        $("#alisis_citas_visitas_cancelacion__by_ajax").append(tr);
                        
                    }
                document.getElementById("totaCitasDesarrollo").innerHTML = totaCitasDesarrollo;
                document.getElementById("totalCitasVigentes").innerHTML              = totalCitasVigentes;
                document.getElementById("totalCitasVencidas").innerHTML             = totalCitasVencidas;
                document.getElementById("totalCitasCanceladas").innerHTML           = totalCitasCanceladas;
                document.getElementById("totalVisitas").innerHTML            = totalVisitas;
                document.getElementById("totalVisitasPase").innerHTML            = totalVisitasPase;
                document.getElementById("totalVisitasPaseJuntas").innerHTML            = totalVisitasPaseJuntas;
                document.getElementById("alisis_citas_visitasCancelacion_desarrollos_tiempo").innerHTML =rangoFechas;

                // console.log(response);
               
                
            },
        });
    };

</script>