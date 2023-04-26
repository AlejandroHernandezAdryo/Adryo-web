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
                    INVERSIÓN POR MEDIO DE PROMOCIÓN VS CLIENTES Y SUS ESTATUS ( <small id="tabla_activos_inactivos_temporales_tiempo"></small>)
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-sm">
                    <tbody id="tabla_activos_inactivos_temporales_by_ajax">
                        <thead>
                            <tr>
                                <th>MEDIO</th>
                                <th>INVERSIÓN</th>
                                <th>CLIENTES</th>
                                <th>LEADS</th>
                                <th>COSTO X LEAD</th>
                                <th>ACTIVOS</th>
                                <th>TEMPORALES</th>
                                <th>DEFINITIVOS</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th><span id="totalInversionnversionCliente"></span></th>
                                <th><span id="totalClientes"></span></th>
                                <th><span id="totalLeadsMK"></span></th>
                                <th><span id="totalcostototalinver"></span></th>
                                <th><span id="totalActivos"></span></th>
                                <th><span id="totalTemporales"></span></th>
                                <th><span id="totalInactivos"></span></th>
                                
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

function tablaClientesActivosTemporalesDefinitivos( rangoFechas, medioId,  desarrolloId, cuentaId  ){

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "leads", "action" => "tabla_clientes_mk")); ?>',
        cache: false,
        data: {  rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId},
        dataType: 'json',
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
            document.getElementById("tabla_activos_inactivos_temporales_tiempo").innerHTML =rangoFechas;
                $("#tabla_activos_inactivos_temporales_by_ajax").html("");
                let totalInversion=0;
                let totalCliente=0;
                let totalLeads=0;
                let totalActivos=0;
                let totalTemporales=0;
                let totalcostototalinver=0;
                let totalInactivos=0;
                // meter console log para revisar que datos trae 
                // Revisar que información se trae y comprobar que coincida
                for (let i in response){
                    var tr = `<tr>
                        <td>`+response[i].medio+`</td>
                        <td>`+response[i].inversion+`</td>
                        <td>`+response[i].tootal_clientes+`</td>
                        <td>`+response[i].leads+`</td>
                        <td>`+response[i].costXmedio+`</td>
                        <td>`+response[i].activo+`</td>
                        <td>`+response[i].temporales+`</td>
                        <td>`+response[i].inactivos+`</td>
                        </tr>`;
                    $("#tabla_activos_inactivos_temporales_by_ajax").append(tr);
                    totalInversion    = response[i].inversion_total;
                    totalCliente     += response[i].tootal_clientes;
                    totalLeads       += parseInt(response[i].leads);
                    totalActivos     += parseInt(response[i].activo);
                    totalTemporales  += parseInt(response[i].temporales);
                    totalInactivos   += parseInt(response[i].inactivos);
                    totalcostototalinver  += parseFloat(response[i].totalCostXmedio);
                    //  parseInt(response[i].totalCostXmedio);
                }
                $("#totalcostototalinver").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(totalcostototalinver).toFixed(2)
    			)
    		);
                
		    document.getElementById("totalInversionnversionCliente").innerHTML = totalInversion;
		    document.getElementById("totalClientes").innerHTML                 = totalCliente;
		    document.getElementById("totalLeadsMK").innerHTML                    = totalLeads;
		    document.getElementById("totalActivos").innerHTML                  = totalActivos;
		    document.getElementById("totalTemporales").innerHTML               = totalTemporales;
		    document.getElementById("totalInactivos").innerHTML                = totalInactivos;
            
       },
    });
};

</script>