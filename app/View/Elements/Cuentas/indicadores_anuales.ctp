<style>
    .tr-secondary-ia, #fa-icon-minus-ia{
        display: none;
    }
    .tr-secondary-ia td{
        padding-left: 7.2%;
    }
</style>
<table class="table table-sm" id="table-indicador-anual">
    <thead class="bg-blue-is">
        <tr>
            <th colspan="2">
                <h4 class="text-center" style="margin-top: 5px;">
                    Indicadores de desempeño de <?= $anio_actual; ?>
                </h4>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Meta de venta de <?= $anio_actual; ?>
            </td>
            <td class="text-sm-right">
                <?= '$ '.number_format($objetivo_venta_anual[0][0]['meta_venta_anual']) ?>
            </td>
        </tr>
        <tr class="tr-root">
            <td>
                <i class="fa fa-plus btn btn-sm" onclick="showMoreTrIa()" id="fa-icon-plus-minus"></i>
                <i class="fa fa-minus btn btn-sm" onclick="hideMoreTrIa()" id="fa-icon-minus-ia"></i>
                Total de clientes de <?= $anio_actual; ?>
            </td>
            <td class="text-sm-right">
                <?= number_format($total_clientes_anuales[0][0]['total_clientes_anuales']) ?>
            </td>
            

            <?php foreach( $clientes_anuales as $clientes ): ?>
                
                <tr class="pointer tr-secondary-ia" onclick="info_message(1)">
                    <td>Total de clientes <?= $clientes['clientes']['status'] ?></td>
                    <td class="text-sm-right"><?= number_format($clientes['0']['total_clientes']) ?></td>
                </tr>

            <?php endforeach ?>

            
        </tr>
        <tr>
            <td>Clientes compradores </td>
            <td class="text-sm-right"> <?= number_format($clientes_venta_anuales[0][0]['total_clientes']) ?> </td>
        </tr>
        <tr>
            <td>Unidades vendidas</td>
            <td class="text-sm-right"> <?= $unidades_monto_venta_anuales['0']['0']['total_ventas'] ?> U </td>
        </tr>
        <tr>
            <td>Total de ventas</td>
            <td class="text-sm-right"> $ <?= number_format($unidades_monto_venta_anuales['0']['0']['monto_venta']) ?> </td>
        </tr>
        <tr>
            <td>Promedio $ por unidad</td>
            <td class="text-sm-right"> <?= '$ 0' ?> </td>
        </tr>
        <tr>
            <td>% de cumplimiento meta <?= $anio_actual ?></td>
            <td></td>
        </tr>
    </tbody>
</table>
<script>
    function info_message( type_message ){
        switch (type_message) {
            case 1:
                alert('Activos');
            break;
            case 2:
                alert('Temporales');
            break;
            case 3:
                alert('Definitivos');
            break;
        }
    }

    function showMoreTrIa() {
        $(".tr-secondary-ia").show(300);
        $("#fa-icon-minus-ia").show(200);
        $("#fa-icon-plus-minus").hide();
    }

    function hideMoreTrIa() {
        $(".tr-secondary-ia").hide(300);
        $("#fa-icon-minus-ia").hide(200);
        $("#fa-icon-plus-minus").show();
    }
</script>