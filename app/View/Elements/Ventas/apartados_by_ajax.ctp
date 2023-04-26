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
                        Listado de Apartados ( <small id="tabla_apartados_periodo_tiempo"></small> )
                        <span style="float:right">
                            Total: <span id="tabla_apartado_total"></span> - 
                            U <span id="contador_unidades_apartada_total"></span>
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
                            <th>Vigencia</th>
                            <th>Asesor</th>
                            <th>Reserva / apartado</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_apartados_by_ajax">

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

    function tablaApartadosDesarrollo( rangoFechas, cuentaId, desarrolloId ,asesorId ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "ventas", "action" => "tabla_apartados")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
        	    document.getElementById("tabla_apartados_periodo_tiempo").innerHTML =rangoFechas;
                $("#tabla_apartados_by_ajax").html("");
                let totalApartado = 0;
                let unidades = 0;
                for (let i in response){
                    unidades = unidades + 1;
                    var tr = `<tr>
                        <td>`+response[i].tipo+`</td>
                        <td>`+response[i].titulo+`</td>
                        <td>`+response[i].nombre+`</td>
                        <td>`+response[i].contacto+`</td>
                        <td>`+response[i].fecha+`</td>
                        <td>`+response[i].vigencia_operacion+`</td>
                        <td>`+response[i].asesor+`</td>
                        <td>`+response[i].precio+`</td>
                        </tr>`;
                    $("#tabla_apartados_by_ajax").append(tr);
                    totalApartado=response[i].total;
                }

                document.getElementById("tabla_apartado_total").innerHTML=totalApartado;
                document.getElementById("contador_unidades_apartada_total").innerHTML=unidades;

            },
        });
    };

</script>