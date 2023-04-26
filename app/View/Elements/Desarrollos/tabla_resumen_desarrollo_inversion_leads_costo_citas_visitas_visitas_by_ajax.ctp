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
                    RESUMEN DE INVERSIÓN POR MEDIO DE PROMOCIÓN VS LEADS,CITAS,VISITAS Y VENTAS ( <small id="tabla_resumen_desarrollos_tiempo"></small>)
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-sm">
                    <tbody id="tabla_resumen_desarrollos_by_ajax">
                        <thead>
                            <tr>
                                <th>MEDIO</th>
                                <th>INVERSIÓN</th>
                                <th>LEADS</th>
                                <th>COSTO X LEAD</th>
                                <th>CITAS</th>
                                <th>VISITAS</th>
                                <th>VENTAS</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th><span id="totalInversionnversion"></span></th>
                                <th><span id="totalLead"></span></th>
                                <th><span id="totalcostototalinvercitasvisitas"></span></th>
                                <th><span id="totalCitas"></span></th>
                                <th><span id="totalVisitas"></span></th>
                                <th><span id="totalVentas"></span></th>
                                
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

function tablaResumenDesarrollos( rangoFechas, medioId,  desarrolloId, cuentaId  ){

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "tabla_resumen_desarrollos")); ?>',
        cache: false,
        data: {  rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId},
        dataType: 'json',
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
            document.getElementById("tabla_resumen_desarrollos_tiempo").innerHTML =rangoFechas;
                $("#tabla_resumen_desarrollos_by_ajax").html("");
                let totalInversion=0;
                let totalLeads=0;
                let totalCitas=0;
                let totalVisitas=0;
                let totalVentas=0;
                let totalcostototalinver=0
                console.log(response);
                for (let i in response){
                    var tr = `<tr>
                        <td>`+response[i].medio+`</td>
                        <td>`+response[i].inversion+`</td>
                        <td>`+response[i].leads+`</td>
                        <td>`+response[i].costoXleads+`</td>
                        <td>`+response[i].citas+`</td>
                        <td>`+response[i].visitas+`</td>
                        <td>`+response[i].ventas+`</td>
                        </tr>`;
                    $("#tabla_resumen_desarrollos_by_ajax").append(tr);
                    totalInversion = response[i].inversiontotal;
                    totalLeads     += parseInt(response[i].leads);
                    totalCitas     += parseInt(response[i].citas);
                    totalVisitas   += parseInt(response[i].visitas);
                    totalVentas    += parseInt(response[i].ventas);
                    totalcostototalinver  += parseFloat(response[i].totalCostXmedio);
                }
                $("#totalcostototalinvercitasvisitas").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(totalcostototalinver).toFixed(2)
    			)
    		);
		    document.getElementById("totalInversionnversion").innerHTML = totalInversion;
		    document.getElementById("totalLead").innerHTML              = totalLeads;
		    // document.getElementById("totalcostototalinver").innerHTML   = totalcostototalinver;
		    document.getElementById("totalCitas").innerHTML             = totalCitas;
		    document.getElementById("totalVisitas").innerHTML           = totalVisitas;
		    document.getElementById("totalVentas").innerHTML            = totalVentas;
       },
    });
};

</script>