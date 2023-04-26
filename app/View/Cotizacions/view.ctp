<?php
    echo $this->Html->css(
        array(
            'css/pages/invoice',
        ),
        array('inline'=>false)
    );
    echo $this->Html->script(
        array(
            '/vendors/select2/js/select2',
            '/vendors/datatables/js/jquery.dataTables.min',
            '/vendors/datatables/js/dataTables.bootstrap.min',
            //'js/pages/advanced_tables',
            'pluginjs/dataTables.tableTools',
            '/vendors/datatables/js/dataTables.colReorder.min',
            '/vendors/datatables/js/dataTables.buttons.min',
            '/vendors/datatables/js/dataTables.responsive.min',
            '/vendors/datatables/js/dataTables.rowReorder.min',
            '/vendors/datatables/js/buttons.colVis.min',
            '/vendors/datatables/js/buttons.html5.min',
            '/vendors/datatables/js/buttons.bootstrap.min',
            '/vendors/datatables/js/buttons.print.min',
            '/vendors/datatables/js/dataTables.scroller.min',
        ),
        array('inline'=>false)
    );
?>
<style>
    .subtitulo {
        font-size: 12px;
        border-bottom: 2px solid silver;
        padding: 0px, 5px, 0px 5px;
    }

    .presupuesto{
        font-size:1.5em;
    }

    .titulo_bloque_2{
        background-color:606060;
        color:white;
        padding: 2px;
    }

    @media print{
        .col-lg-4{
            width:50%;
            float:left
        }

        td{
            text-align:left;
        }

        .row_impar{
            background-color:#b3b3b3;
        }
    
        .cuerpo{
            margin-top:20px;
        }
        .foto-cuerpo{
            margin-top:5px;
        }

        .body{
            font-size:20px;
        }
        .titulo_bloque_2{
            background-color:606060;
            color:white;
            font-size:1.5em;
        }   
        

    }
</style>

<!-- Logotipo y nombre del desarrollo -->
<div class="cuerpo">
    <table style="width: 100%;">
        <tr>
            <td style="text-align:center">
                <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'],array('style'=>'height: 70px; width: auto;'))?>
            </td>
        </tr>
        <tr style="background-color: #2e3c54;">
            <td style="text-align:center; color: white; padding: 6px; font-size: 12px; letter-spacing: 1px; font-weight: 600; text-transform: uppercase;">
                <?= $desarrollo['Desarrollo']['nombre'] ?>
            </td>
        </tr>
    </table>
</div>

<!-- Fotos del desarrollo -->
<div class="foto-cuerpo">
    <table style="width: 100%;">
        <tr>
            <td style="text-align:center;width:100%">
                <div style="background-image: url(<?= Router::url($cotizacion['Inmueble']['FotoInmueble'][0]['ruta'])?>);background-size: cover;height: 150px;width: 100%%;background-position: center;"></div>
            </td>
        </tr>
    </table>
</div>

<!-- Presupuesto y plan de pagos -->
<div>
    <table style="width: 100%;">
        <tr>
            <th colspan="2" style="text-align:center" class="subtitulo titulo_bloque">PRESUPUESTO Y PLAN DE PAGOS</th>
        </tr>
        <tr>
            <td><?= $cotizacion['Cotizacion']['cotizacion']?></td>
        </tr>
    </table>
</div>

<!-- forma de pago y precio final -->
<div style="padding:20px">
    <table style="width:100%;">
        <tr>
            <th style="text-align:center" class="subtitulo">
                <p><b>FORMA PAGO:</b><?= $cotizacion['Cotizacion']['forma_pago']?></p>
                <p><b>PRECIO FINAL:</b>$<?= number_format($cotizacion['Cotizacion']['precio'],0)?></p>
            </th>
        </tr>
    </table>
</div>

<!-- Detalles de la propiedad y datos -->
<div>
    <table style="width: 100%;">
        <tr>
            <th colspan="2" style="text-align:center;border-right:5px solid white; padding: 0px, 50px, 0px, 5px;" class="titulo_bloque_2">DETALLES DE PROPIEDAD</th>
            <th colspan="2" style="text-align:center" class="titulo_bloque_2">DATOS DE CLIENTE</th>
        </tr>
        <tr>
            <td style="width:30%; text-align:left"><b>REFERENCIA DE PROPIEDAD</b></td>
            <td style="width:20%; text-align:left"><?= $cotizacion['Inmueble']['titulo']?></td>
            <td style="width:20%; text-align:left"><b>NOMBRE DE CLIENTE</b></td>
            <td style="width:30%; text-align:left"><?= $cotizacion['Cliente']['nombre']?></td>
        </tr>
        <tr>
            <td style="width:30%; text-align:left"><b>CONSTRUCCIÓN</b></td>
            <td style="width:20%; text-align:left">
                <?php $suma=$cotizacion['Inmueble']['construccion']+$cotizacion['Inmueble']['construccion_no_habitable']?>
                <?= $suma. " m<sup>2</sup>"?></td>
            <td style="width:20%; text-align:left"><b>CORREO</b></td>
            <td style="width:30%; text-align:left"><?= $cotizacion['Cliente']['correo_electronico'] ?></td>
        </tr>
        <tr>
            <td style="width:30%; text-align:left"><b>HABITACIONES</b></td>
            <td style="width:20%; text-align:left"><?= $cotizacion['Inmueble']['recamaras']?></td>
            <td style="width:20%; text-align:left"><b>TELÉFONO</b></td>
            <td style="width:30%; text-align:left"><?= $cotizacion['Cliente']['telefono1'] ?></td>
        </tr>
        <tr>
            <td style="width:30%; text-align:left"><b>BAÑOS</b></td>
            <td style="width:20%; text-align:left"><?= $cotizacion['Inmueble']['banos']?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="width:20%; text-align:left"><b>ESTACIONAMIENTOS</b></td>
            <td style="width:30%; text-align:left"><?= $cotizacion['Inmueble']['estacionamiento_techado']?></td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>

<!-- Formas de pago -->
<div style="margin-top:2em; border-top:2px solid silver">
    <table style="width: 100%;">
        <tr>
            <th colspan="5" style="text-align:center" class="titulo_bloque_2">MEDIOS DE PAGO</th>
        </tr>
        <tr>
            <th>FORMA DE PAGO</th>
            <th>TITULAR</th>
            <th>BANCO</th>
            <th>NÚMERO DE CUENTA</th>
            <th>SPEI</th>
        </tr>
        <?php if( empty( $desarrollo['CuentasBancarias'] ) ): ?>
            <tr>
                <td colspan="5" style="text-align: center; font-size: 14px; padding-top: 5px; color: #A7A7A7;">
                    Sin información.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach( $desarrollo['CuentasBancarias'] as $cuenta ): ?>
                <tr>
                    <td> <?= $cuenta['tipo'] ?> </td>
                    <td> <?= $cuenta['nombre_cuenta'] ?> </td>
                    <td> <?= $cuenta['banco'] ?> </td>
                    <td> <?= $cuenta['numero_cuenta'] ?> </td>
                    <td> <?= $cuenta['spei'] ?> </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

<!-- Asesor y vigencia -->
<div style="margin-top:2em; border-top:2px solid silver">
    <table style="width: 100%;">
        <tr>
            <th colspan="2" style="text-align:center;border-right:5px solid white;" class="titulo_bloque_2">ASESOR</th>
            <th colspan="2" style="text-align:center" class="titulo_bloque_2">VIGENCIA</th>
        </tr>
        <tr>
            <td style="width:50%; text-align:left" colspan='2'><i style="margin-right:1em" class="fa fa-user fa-2x"></i></b><?= $cotizacion['Asesor']['nombre_completo']?></td>
            <td style="width:20%; text-align:left"><b>FECHA DE COTIZACIÓN</b></td>
            <td style="width:30%; text-align:left"> <?= date("d/m/Y",strtotime($cotizacion['Cotizacion']['fecha']))?> </td>
        </tr>
        <tr>
            <td style="width:50%; text-align:left" colspan='2'> <i style="margin-right:1em" class="fa fa-envelope fa-2x"></i></b><?= $cotizacion['Asesor']['correo_electronico']?> </td>
            <td style="width:20%; text-align:left"><b>FECHAD E VIGENCIA</b></td>
            <td style="width:30%; text-align:left"><?= date("d/m/Y",strtotime($cotizacion['Cotizacion']['vigencia']))?></td>
        </tr>
        <tr>
            <td style="width:100%; text-align:left" colspan='4'><i style="margin-right:1em" class="fa fa-phone fa-2x"></i></b><?= $cotizacion['Asesor']['telefono1']?></td>
        </tr>
    </table>
</div>
