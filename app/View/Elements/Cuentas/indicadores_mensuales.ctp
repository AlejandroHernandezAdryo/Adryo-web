<style>
    .tr-secondary-im, #fa-icon-minus-im{
        display: none;
    }
    .tr-secondary-im td{
        padding-left: 7.2%;
    }
</style>
<table class="table table-sm" id="table-indicador-mensual">
    <thead class="bg-blue-is">
        <tr>
            <th colspan="2">
                <h4 class="text-center" style="margin-top: 5px;">
                    Indicadores de desempeño <?= $mes_actual ?>
                </h4>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Última sesión
            </td>
            <td class="text-sm-right">
                <?= strftime("%d %B de %Y a las %I:%M:%S %p", strtotime(date("d-m-Y H:m:s", strtotime($user['User']['last_login'])))); ?>
            </td>
        </tr>
        <tr>
            <td>
                Objetivo de venta <?= $mes_actual ?>
            </td>
            <td class="text-sm-right">
                <?= '$ '.number_format($objetivo_venta_mensual[0]['objetivos_ventas_cuentas']['monto']) ?>
            </td>
        </tr>
        <tr class="tr-root">
            <td>
                <i class="fa fa-plus btn btn-sm" onclick="showMoreTrIm()" id="fa-icon-plus"></i>
                <i class="fa fa-minus btn btn-sm" onclick="hideMoreTrIm()" id="fa-icon-minus-im"></i>
                Total de clientes <?= $mes_actual ?>
            </td>
            <td class="text-sm-right">
                <?= number_format($total_clientes_mensuales[0][0]['total_clientes']) ?>
            </td>
            
            <?php foreach( $clientes_mensuales as $clientes ): ?>
                
                <tr class="pointer tr-secondary-im" onclick="info_message('<?= $clientes['clientes']['status'] ?>')">
                    <td>Total de clientes <?= $clientes['clientes']['status'] ?></td>
                    <td class="text-sm-right"><?= number_format($clientes['0']['total']) ?></td>
                </tr>

            <?php endforeach ?>
            
        </tr>
        <tr>
            <td>Unidades vendidas <?= $mes_actual ?></td>
            <td class="text-sm-right"> <?= $unidades_monto_venta_mensual['0']['0']['total_ventas'] ?> U </td>
        </tr>
        <tr>
            <td>Total de ventas <?= $mes_actual ?></td>
            <td class="text-sm-right">$ <?= number_format($unidades_monto_venta_mensual['0']['0']['monto_venta'], 2) ?></td>
        </tr>
        <tr>
            <td>Promedio $ por <?= $mes_actual ?></td>
            <td class="text-sm-right">$ 0</td>
        </tr>
        <tr>
            <td>% de cumplimiento meta <?= $mes_actual ?></td>
            <td class="text-sm-right">$ 0</td>
        </tr>
    </tbody>
</table>

<script>
    function info_message( type_message ){
        alert( type_message );
        // switch ( type_message ) {
        //     case 'Activo':
        //         alert('Activos');
        //     break;
        //     case 'Inactivo':
        //         alert('Definitivos');
        //     break;
        //     case 'Inactivo temporal':
        //         alert('Temporales');
        //     break;
        // }
    }

    function showMoreTrIm() {
        $(".tr-secondary-im").show(300);
        $("#fa-icon-minus-im").show(200);
        $("#fa-icon-plus").hide();
    }

    function hideMoreTrIm() {
        $(".tr-secondary-im").hide(300);
        $("#fa-icon-minus-im").hide(200);
        $("#fa-icon-plus").show();
    }
</script>