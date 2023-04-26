<?php
    $total = 0;
    foreach($temperatura_clientes_reporte as $registro):
        $total+= $registro['1']+$registro['2']+$registro['3']+$registro['4']+$registro['5']+$registro['6']+$registro['7']+$registro['8'];
    endforeach;
?>
<div class="card">
    <div class="card-header bg-blue-is">
        ETAPAS DE CLIENTES ACTIVOS A LA FECHA <?= !empty($fecha_final) ? date('d/m/Y',  strtotime($fecha_final)) : "" ?>
        <span style="float:right">
            Total: <?= number_format($total,0)?>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%">
                    <tr>
                        <th>Asesor</th>
                        <th class="titulo estado1">Etapa 1</th>
                        <th class="titulo estado2">Etapa 2</th>
                        <th class="titulo estado3">Etapa 3</th>
                        <th class="titulo estado4">Etapa 4</th>
                        <th class="titulo estado5">Etapa 5</th>
                        <th class="titulo estado6">Etapa 6</th>
                        <th class="titulo estado7">Etapa 7</th>
                        <th class="titulo estado8">Etapa 8</th>
                        <th style="background-color: silver">Total</th>
                    </tr>
                    <?php
                        $impar = "background-color:#f0f0f0";
                        $total_e1 = 0;
                        $total_e2 = 0;
                        $total_e3 = 0;
                        $total_e4 = 0;
                        $total_e5 = 0;
                        $total_e6 = 0;
                        $total_e7 = 0;
                        $total_e8 = 0;
                        $i=0;
                        foreach($temperatura_clientes_reporte as $registro):
                            $i++;
                            $total_row = 0;
                            $total_row = $registro['1']+$registro['2']+$registro['3']+$registro['4']+$registro['5']+$registro['6']+$registro['7']+$registro['8'];
                    ?>
                            <tr style="<?= $i%2 == 0 ? $impar: "" ?>">
                                <td class="nombre"><?= $registro['nombre']?></td>
                                <td><?= $registro['1']; $total_e1+=$registro['1'];?></td>
                                <td><?= $registro['2']; $total_e2 += $registro['2'];?></td>
                                <td><?= $registro['3']; $total_e3 += $registro['3'];?></td>
                                <td><?= $registro['4']; $total_e4 += $registro['4'];?></td>
                                <td><?= $registro['5']; $total_e5 += $registro['5'];?></td>
                                <td><?= $registro['6']; $total_e6 += $registro['6'];?></td>
                                <td><?= $registro['7']; $total_e7 += $registro['7'];?></td>
                                <td><?= $registro['8']; $total_e8 += $registro['8'];?></td>
                                <td style="background-color: silver"><b><?= $total_row?></b></td>
                            </tr>
                    <?php endforeach;?>
                    <tr style="background-color: silver">
                        <th>Totales</th>
                        <th><?= $total_e1?></th>
                        <th><?= $total_e2?></th>
                        <th><?= $total_e3?></th>
                        <th><?= $total_e4?></th>
                        <th><?= $total_e5?></th>
                        <th><?= $total_e6?></th>
                        <th><?= $total_e7?></th>
                        <th><?= $total_e8?></th>
                        <th><?= $total?></th>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12 mt-2 periodo_tiempo" >
              <small><?= $periodo_tiempo ?></small>
            </div>
        </div>
    </div>
</div>
