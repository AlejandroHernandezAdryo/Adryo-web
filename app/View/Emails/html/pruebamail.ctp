<table style="padding: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
    <tbody>
        <tr>
            <td>
                <p><b>Atencion a <?php echo $cliente['Cliente']['nombre']." ".$cliente['Cliente']['apellido_paterno']." ".$cliente['Cliente']['apellido_materno']?></b><p>  
                <p>Agradecemos de antemano su preferencia por BOS Inmobiliaria. Siempre buscamos las mejores opciones para usted.</p>
                <p>Con base a los requerimentos proporcinados le mando un listado de propiedades que podrían interesarle.</p>
                <p>Para cualquier información adicional o solictud de cita, favor de ponerse en contacto conmigo para brindale la atención y seguimiento adecuado.</p>
            </td>
        </tr>
        <?php 
        if (isset($propiedades)){    
            if($propiedades!=""){
                foreach ($propiedades as $propiedad):
        ?>
        <tr>
            <td style="border: 1px solid #ccc" width="309">
                
                    <img alt="<?= $propiedad['Inmueble']['referencia']?>"src="http://bosinmobiliaria.com/beta<?php echo $foto = (isset($propiedad['FotoInmueble'][0]['ruta']) ?$propiedad['FotoInmueble'][0]['ruta'] : "/img/no_photo.jpg")?>" style="width: 307px; height: 200px" title="foto" width="307" height="200">
                
            </td>
            <td width="291" valign="top" bgcolor="#f8f8f8">
                <p style="padding: 8px; margin: 0; font-size: 16px; color: #00418c; font-weight: bold"><?= $propiedad['Inmueble']['titulo']?></p>
                <p style="padding: 8px 10px; margin: 0"><strong><?php echo "$".number_format($propiedad['Inmueble']['precio'],2)?></strong>.<br>Ubicado en <strong><?= $propiedad['Inmueble']['colonia'].", ".$propiedad['Inmueble']['ciudad']?></strong>.
                <br><br>
                <p><strong>Habitaciones: </strong><?= $propiedad['Inmueble']['recamaras']?>|<strong>Baños: </strong><?= $propiedad['Inmueble']['banos']?>|<strong>Construccion: </strong><?= $propiedad['Inmueble']['construccion']?></p>
                <br><br>
                <a style="float: left; margin: 10px; background-image: url(http://bosinmobiliaria.ip-zone.com/ccm/templates/consultoria/images/boton1.jpg); background-repeat: no-repeat; padding: 7px 14px; text-align: center; color: #FFFFFF; text-decoration: none; background-color: #00418c; margin-top: -16px; font-weight: bold" href="http://bosinmobiliaria.com/sistema/inmuebles/detalle/<?php echo $propiedad['Inmueble']['id']."/".$usuario['User']['id']?>" onclick="return false" rel="noreferrer">Ver +</a>
            </td>
        </tr>
        <tr height="10">
        </tr>
        <?php
                endforeach;
            }
        }
        ?>
        <?php 
        if (isset($desarrollos)){    
            if($desarrollos!=""){
                foreach ($desarrollos as $desarrollo):
        ?>
        <tr>
            <td style="border: 1px solid #ccc" width="309">
                
                    <img alt="<?= $desarrollo['Desarrollo']['nombre']?>"src="http://bosinmobiliaria.com/beta<?php echo $desarrollo['FotoDesarrollo'][0]['ruta']?>" style="width: 307px; height: 200px" title="foto" width="307" height="200">
                
            </td>
            <td width="291" valign="top" bgcolor="#f8f8f8">
                <p style="padding: 8px; margin: 0; font-size: 16px; color: #00418c; font-weight: bold"><?= $desarrollo['Desarrollo']['nombre']?></p>
                <p style="padding: 8px 10px; margin: 0">Desarrollo Ubicado en <strong><?= $desarrollo['Desarrollo']['colonia'].", ".$desarrollo['Desarrollo']['ciudad']?></strong>.
                <a style="float: left; margin: 10px; background-image: url(http://bosinmobiliaria.ip-zone.com/ccm/templates/consultoria/images/boton1.jpg); background-repeat: no-repeat; padding: 7px 14px; text-align: center; color: #FFFFFF; text-decoration: none; background-color: #00418c; margin-top: -16px; font-weight: bold" href="http://bosinmobiliaria.com/desarrollos/view/<?php echo $desarrollo['Desarrollo']['id']."/".$usuario['User']['id']?>" onclick="return false" rel="noreferrer">Ver +</a>
            </td>
        </tr>
        <tr height="10">
        </tr>
        <?php
                endforeach;
            }
        }
        ?>
        <tr>
            <td>
                <p>Para cualquier información adicional, favor de ponerse en contacto conmigo y agradecería me permitiera darle seguimiento a su solicitud.</p>
    <div width="20%" style="float: right;margin-bottom: 2%">
        <table>
            <tr>
                <td colspan="2" style="background-color: #f39c12; color:white; text-align: center"><b>Información de Agente</b></td>
            </tr>
            <tr>
                <td><img src="http://bosinmobiliaria.com/beta/img/<?php echo $usuario['User']['foto']?>" width="100px" style="max-height: 80px"></td>
                <td>
                    <p><b><?php echo $usuario['User']['nombre_completo']?></b></p>
                    <p><?php echo $usuario['User']['telefono1']?></p>
                    <?php if ($usuario['User']['telefono2']!=''){?>
                    <p><?php echo $usuario['User']['telefono2']?></p>
                    <?php }?>
                    <p><?php echo $usuario['User']['correo_electronico']?></p>
                </td>
            </tr>
        </table>
    </div>
            </td>
        </tr>
    </tbody>
</table>
