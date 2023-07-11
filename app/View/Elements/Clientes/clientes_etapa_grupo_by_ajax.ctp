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
                        Listado de Ventas ( <small id="tabla_clientes_etapa_periodo_tiempo"></small> )
                        <span style="float:right">
                            Total: <span id="clienteTotales"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table table-striped table-hover table-sm mt-2">
                    <thead>
                        <tr>
                            <th>asesores</th>
                            <th>etapa 1</th>
                            <th>etapa 2</th>
                            <th>etapa 3</th>
                            <th>etapa 4</th>
                            <th>etapa 5</th>
                            <th>etapa 6</th>
                            <th>etapa 7</th>
                            <th>total</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_clientes_etapa_by_ajax">

                    </tbody>
                    <tfoot>
                            <tr>
                                <th></th>
                                <th><span id="totalClientesetapa1"></span></th>
                                <th><span id="totalClientesetapa2"></span></th>
                                <th><span id="totalClientesetapa3"></span></th>
                                <th><span id="totalClientesetapa4"></span></th>
                                <th><span id="totalClientesetapa5"></span></th>
                                <th><span id="totalClientesetapa6"></span></th>
                                <th><span id="totalClientesetapa7"></span></th>
                                <th><span id="totalClientesetapaTotales"></span></th>
                                
                            </tr>
                        </tfoot>
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

    function tablaEtapaGrupoAsesor( rangoFechas, cuentaId, desarrolloId ,asesorId ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "cliente_etapa_grupo")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
                let Total=0;
                let TotalEtapa1=0;
                let TotalEtapa2=0;
                let TotalEtapa3=0;
                let TotalEtapa4=0;
                let TotalEtapa5=0;
                let TotalEtapa6=0;
                let TotalEtapa7=0;
                
                $("#tabla_clientes_etapa_by_ajax").html("");
                for (let i in response){
                    let totalasesor=0;
                    response[i].etapa1  = parseInt(response[i].etapa1);
					response[i].etapa2  = parseInt(response[i].etapa2);
					response[i].etapa3  = parseInt(response[i].etapa3);
					response[i].etapa4  = parseInt(response[i].etapa4);
					response[i].etapa5  = parseInt(response[i].etapa5);
					response[i].etapa6  = parseInt(response[i].etapa6);
					response[i].etapa7  = parseInt(response[i].etapa7);
                    totalasesor=response[i].etapa1 + response[i].etapa2 +  response[i].etapa3 + response[i].etapa4 + response[i].etapa5 + response[i].etapa6 + response[i].etapa7 ;
                    TotalEtapa1 += response[i].etapa1 
                    TotalEtapa2 += response[i].etapa2 
                    TotalEtapa3 += response[i].etapa3 
                    TotalEtapa4 += response[i].etapa4 
                    TotalEtapa5 += response[i].etapa5 
                    TotalEtapa6 += response[i].etapa6 
                    TotalEtapa7 += response[i].etapa7 
                    var tr = `<tr>
                        <td>`+response[i].asesor+`</td>
                        <td>`+response[i].etapa1+`</td>
                        <td>`+response[i].etapa2+`</td>
                        <td>`+response[i].etapa3+`</td>
                        <td>`+response[i].etapa4+`</td>
                        <td>`+response[i].etapa5+`</td>
                        <td>`+response[i].etapa6+`</td>
                        <td>`+response[i].etapa7+`</td>
                        <td>`+totalasesor+`</td>
                 
                        </tr>`;
                    $("#tabla_clientes_etapa_by_ajax").append(tr);
                   
					Total += response[i].etapa1 + response[i].etapa2 +  response[i].etapa3 + response[i].etapa4 + response[i].etapa5 + response[i].etapa6 + response[i].etapa7 ;
                }
        	    document.getElementById("totalClientesetapa1").innerHTML =TotalEtapa1;
        	    document.getElementById("totalClientesetapa2").innerHTML =TotalEtapa2;
        	    document.getElementById("totalClientesetapa3").innerHTML =TotalEtapa3;
        	    document.getElementById("totalClientesetapa4").innerHTML =TotalEtapa4;
        	    document.getElementById("totalClientesetapa5").innerHTML =TotalEtapa5;
        	    document.getElementById("totalClientesetapa6").innerHTML =TotalEtapa6;
        	    document.getElementById("totalClientesetapa7").innerHTML =TotalEtapa7;

        	    document.getElementById("totalClientesetapaTotales").innerHTML =Total;
        	    document.getElementById("clienteTotales").innerHTML =Total;
        	    document.getElementById("tabla_clientes_etapa_periodo_tiempo").innerHTML =rangoFechas;
                // document.getElementById("tabla_ventas_total_venta").innerHTML=totalVenta;
                // document.getElementById("contador_unidades_total").innerHTML=unidades;
            },
        });
    };

</script>