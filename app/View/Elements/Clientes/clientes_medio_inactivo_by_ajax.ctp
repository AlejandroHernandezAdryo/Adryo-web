<div class="row">
    <div class="col-sm-12 mt-1">
        <div class="card">
            <div class="card-header bg-blue-is">
                <div class="row">
                    <div class="col-sm-12">
                        CLIENTES POR MEDIOS DE PROMOCIÓN VS ESTATUS DE LOS CLIENTES ( <small id="tabla_clientes_inactivos_medio_periodo_tiempo"></small> )
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-striped table-hover table-sm mt-2">
                    <thead>
                        <tr>
                            <th>MEDIOS</th>
                            <th>TOTAL CLIENTES</th>
                            <th>CLIENTES ACTIVOS</th>
                            <th>CLIENTES INACTIVOS TEMPORALES</th>
                            <th>CLIENTES INACTIVOS DEFINITIVOS</th>
                        </tr>
                    </thead>
                    <tfoot>
                            <tr>
                                <th><span></span></th>
                                <th><span id="totalClientes"></span></th>
                                <th><span id="ClientesActivos"></span></th>
                                <th><span id="ClientesTemporales"></span></th>
                                <th><span id="ClientesInactivos"></span></th>
                            </tr>
                        </tfoot>
                    <tbody id="tabla_clientes_inactivos_madio_by_ajax">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    function tablaClientesInactivosMedio( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "medios_clientes_definitivos")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
        	    document.getElementById("tabla_clientes_inactivos_medio_periodo_tiempo").innerHTML =rangoFechas;
                $("#tabla_clientes_inactivos_madio_by_ajax").html("");
                let totalCliente = 0;
                let ClienteActivos = 0;
                let ClienteTemporales = 0;
                let TotalInactivos = 0;
                for (let i in response){
                    // unidades = unidades + 1;
                    var tr = `<tr>
                        <td>`+response[i].medio+`</td>
                        <td>`+response[i].total+`</td>
                        <td>`+response[i].activos+`</td>
                        <td>`+response[i].temporal+`</td>
                        <td>`+response[i].inactivo+`</td>
                        </tr>`;
                    $("#tabla_clientes_inactivos_madio_by_ajax").append(tr);
                    totalCliente   += parseInt(response[i].total);
                    ClienteActivos   += parseInt(response[i].activos);
                    ClienteTemporales   += parseInt(response[i].temporal);
                    TotalInactivos += parseInt(response[i].inactivo);
                }

                document.getElementById("totalClientes").innerHTML=totalCliente;
                document.getElementById("ClientesActivos").innerHTML=ClienteActivos;
                document.getElementById("ClientesTemporales").innerHTML=ClienteTemporales;
                document.getElementById("ClientesInactivos").innerHTML=TotalInactivos;
            },
        });
    };

</script>