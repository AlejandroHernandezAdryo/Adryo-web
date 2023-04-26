<style>
    
</style>
<div class="header">
    <h2 style="line-height: .5;">ESTADO DE CUENTA</h2>
    <p>Fecha: <?= date('d-M-Y')?></p>
</div>
<table style="width: 100%;">
  <thead><tr><td>
    <div class="header-space">&nbsp;</div>
  </td></tr></thead>
  <tbody><tr><td>
              <div class="m-t-60"> 
                <div style="width:50%; float: left">
                  <table>
                      <tbody style="background-color:rgb(233, 233, 233)">
                          <tr style="background-color:white">
                              <td colspan="2">
                                  <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'],array('height'=>'70px'))?>
                              </td>
                          </tr>
                          <tr style="background-color:silver">
                              <th colspan="2">DATOS GENERALES</th>
                          </tr>
                          <tr>
                              <td class="titulo">Desarrollo:</td>
                              <td><?= $desarrollo['Desarrollo']['nombre'] ?></td>
                          </tr>
                          <tr>
                              <td class="titulo">Cliente:</td>
                              <td><?= $venta['Cliente']['nombre']?></td>
                          </tr>
                          <tr>
                              <td class="titulo">Propiedad:</td>
                              <td><?= $venta['Inmueble']['referencia']?></td>
                          </tr>
                          <tr>
                              <td class="titulo">Fecha de Cierre:</td>
                              <td><?= $venta['Venta']['fecha']?></td>
                          </tr>
                          <tr>
                              <td class="titulo">Precio Cierre:</td>
                              <td>$<?= number_format($venta['Venta']['precio_cerrado'],2)?></td>
                          </tr>
                          <tr>
                              <td class="titulo">Asesor:</td>
                              <td><?= $venta['User']['nombre_completo']?></td>
                          </tr>
                      </tbody>
                  </table>
                </div>
                <div style="float: left; width:50%; height:200px; background-position:center center ;background-size:cover; background-image: url(/adryo/<?= $desarrollo['FotoDesarrollo'][0]['ruta']?>)">
                </div>
                
              </div>
              <div class="m-t-60" style="width:100%; float:left">
                  <table style="width:100%; border: solid 1px silver">
                            <thead>
                                <tr>
                                    <th colspan="4" style="background-color:silver">PROGRAMACIÓN DE PAGOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                <?php foreach ($venta['Facturas'] as $factura): ?>
                                    <tr style="border: solid 1px silver; background-color:#2e3c54; color:white">
                                        <th>Referencia</th>
                                        <th>Fecha programada de pago</th>
                                        <th>Total</th>
                                        <th>Estatus</th>
                                    </tr>
                                    <?php $estilo = ($i%2!=0?"background-color:rgb(231, 231, 231)":"background-color:white")?>
                                    <tr>
                                        <td><?= $factura['referencia']; ?></td>
                                        <td style="text-align:center"><?= date("d-m-Y", strtotime($factura['fecha_emision']))?></td>
                                        <td style="text-align:center"><?= '$ '.number_format($factura['total']) ?></td>
                                        <td style="text-align:center"><?= $status_factura[$factura['estado']] ?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="border: solid 1px silver; background-color:silver; color:white">LISTADO DE PAGOS</th>
                                    </tr>
                                    <tr>
                                        <th>Referencia de Pago</th>
                                        <th>Fecha de pago</th>
                                        <th>Forma de Pago</th>
                                        <th>Monto de Pago</th>
                                    </tr>
                                    <?php foreach($factura['Pagos'] as $pago):?>
                                        <tr>
                                            <td><?= $pago['referencia']; ?></td>
                                            <td style="text-align:center"><?= date("d-m-Y", strtotime($pago['fecha']))?></td>                                      
                                            <td style="text-align:center"><?= $pago['forma_pago'] ?></td>
                                            <td style="text-align:center"><?= '$ '.number_format($pago['monto']) ?></td>
                                        </tr>    
                                    <?php endforeach;?>
                                        
                                    </tr>
                                <?php $i++;?>
                                <?php endforeach ?>
                            </tbody>
                        </table> 
              </div>
             
  </td></tr></tbody>
  <tfoot><tr><td>
    <div class="footer-space">&nbsp;</div>
  </td></tr></tfoot>
</table>
<div class="footer">
    <table style="width:100%">
        <tr style="text-align: center; font-size: 9px">
            <td><?= $this->Html->image($this->Session->read('CuentaUsuario.Cuenta.logo'),array('height'=>'50px'))?></td>
            <td style="padding-left:1em;padding-right: 1em;"><p><?= $this->Session->read('CuentaUsuario.Cuenta.razon_social')?></p>
                <p><?= $this->Session->read('CuentaUsuario.Cuenta.direccion')?></p>
                <p><?= $this->Session->read('CuentaUsuario.Cuenta.telefono_1')?> | <?= $this->Session->read('CuentaUsuario.Cuenta.telefono_2')?> | <?= $this->Session->read('CuentaUsuario.Cuenta.pagina_web')?></p>
            </td>
            <td>
                <p>Powered By Adryo A.I.</p>
                <?= $this->Html->image('logo_color.png',array('height'=>'30px'))?>
            </td>
        </tr>
    </table>
</div>
