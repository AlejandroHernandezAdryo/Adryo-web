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
                        Listado de Escrituraciónes ( <small id="tabla_escrituracion_periodo_tiempo"></small> )
                        <span style="float:right">
                            Total: <span id="tabla_escrituracion_total_escriturado"></span> - 
                            U <span id="contador_unidades_total_escriturada"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-striped table-hover table-sm mt-2">
                    <thead>
                        <tr>
                            <th>Tipo de operación</th>
                            <th>Inmueble</th>
                            <th>Cliente</th>
                            <th>Línea de contacto</th>
                            <th>Fecha de operación</th>
                            <th>Asesor</th>
                            <th>Precio de venta</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_escrituradas_by_ajax">

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

    function tablaEscrituradasDesarrollo( rangoFechas, cuentaId, desarrolloId ,asesorId ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "ventas", "action" => "tabla_escrituracion")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
        	    document.getElementById("tabla_escrituracion_periodo_tiempo").innerHTML =rangoFechas;
                $("#tabla_escrituradas_by_ajax").html("");
                var totalVenta = 0;
                var unidades = 0;
                for (let i in response){
                    unidades = unidades + 1;
                    var tr = `<tr>
                        <td>`+response[i].tipo+`</td>
                        <td>`+response[i].titulo+`</td>
                        <td>`+response[i].nombre+`</td>
                        <td>`+response[i].contacto+`</td>
                        <td>`+response[i].fecha+`</td>
                        <td>`+response[i].asesor+`</td>
                        <td>`+response[i].precio+`</td>
                        </tr>`;
                    $("#tabla_escrituradas_by_ajax").append(tr);
                    totalVenta=response[i].total;
                }

                document.getElementById("tabla_escrituracion_total_escriturado").innerHTML=totalVenta;
                document.getElementById("contador_unidades_total_escriturada").innerHTML=unidades;
            },
        });
    };

</script>