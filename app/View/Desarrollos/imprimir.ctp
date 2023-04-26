<table style="width:100%">
    <tr>
        <td style="width:30%"><?= $this->Html->image($desarrollo['Cuenta']['logo'],array('style'=>'height:50px'))?></td>
        <td style="width:50%;text-align: right; padding-right: 20px">
            <b><?= $agente['User']['nombre_completo']?></b>&nbsp;
            <br><?= $agente['User']['correo_electronico']?>
            <br><?= $agente['User']['telefono1']?>
            <?= ($agente['User']['telefono2']!=""?"<br>".$agente['User']['telefono2'] : "")?>
        </td>
        <td style="width:20%;text-align: left"><img src="/inmosystem/<?= $agente['User']['foto']?>" style="height: 50px"></td>
    </tr>
    <tr>
        <td>
            <div style="width:100%;height:75vh;background-image: url('/inmosystem/<?= $desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" >
        </div>
            <p class=" bd-textblock-17 bd-content-element">
    <?= $desarrollo['Desarrollo']['nombre']."/ REF:".$desarrollo['Desarrollo']['referencia']?>
</p>
<?php 
            echo "Precios a partir de: $".number_format($desarrollo['Desarrollo']['precio_low'],2);
        
    ?>
        </td>
        <td>
            
        </td>
    </tr>
</table>