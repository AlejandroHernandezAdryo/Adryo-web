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
                        CLIENTES POR MEDIO DE PROMOCIÓN VS CITAS, VISTAS Y VENTAS ( <small id="tabla_clientes_medio_ventas_visitas_periodo_tiempo"></small> )
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-striped table-hover table-sm mt-2">
                    <thead>
                        <tr>
                            <th>MEDIOS</th>
                            <th>TOTAL CLIENTES</th>
                            <th>CITAS</th>
                            <th>VISITAS</th>
                            <th>VENTAS</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <th><span id="Total_tabla_clientes_ventas_visitas"></span></th>
                        <th><span id="totalClientestabla"></span></th>
                        <th><span id="totalCitasTabla"></span></th>
                        <th><span id="totalVisitasTabla"></span></th>
                        <th><span id="totalVentasTabla"></span></th>
                        </tr>
                    </tfoot>
                    <tbody id="tabla_madio_medio_clientas_visitas_ventas_by_ajax">

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

    function tablaMedioClientesVisitasVentas( rangoFechas, cuentaId, desarrolloId ,asesorId ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "medios_clientes_ventas_ventas")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {

        	    document.getElementById("tabla_clientes_medio_ventas_visitas_periodo_tiempo").innerHTML =rangoFechas;
                $("#tabla_madio_medio_clientas_visitas_ventas_by_ajax").html("");
                let totalCliente = 0;
                let TotalCitas = 0;
                let TotalVisitas = 0;
                let TotalVentas = 0;

                for (let i in response){
                    // unidades = unidades + 1;
                    var tr = `<tr>
                        <td>`+response[i].medio+`</td>
                        <td>`+response[i].clientes+`</td>
                        <td>`+response[i].citas+`</td>
                        <td>`+response[i].visitas+`</td>
                        <td>`+response[i].ventas+`</td>
                        </tr>`;
                    
                    $("#tabla_madio_medio_clientas_visitas_ventas_by_ajax").append(tr);
                    totalCliente   += parseInt(response[i].clientes);
                    TotalCitas += parseInt(response[i].citas);
                    TotalVisitas += parseInt(response[i].visitas);
                    TotalVentas += parseInt(response[i].ventas);
                }

                document.getElementById("Total_tabla_clientes_ventas_visitas").innerHTML="TOTALES";
                document.getElementById("totalClientestabla").innerHTML=totalCliente;
                document.getElementById("totalCitasTabla").innerHTML=TotalCitas;
                document.getElementById("totalVisitasTabla").innerHTML=TotalVisitas;
                document.getElementById("totalVentasTabla").innerHTML=TotalVentas;
            },
        });
    };

</script>