      <div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">
      <p><?php 
                        if ($this->Session->read('CuentaUsuario.Cuenta.logo')==""|| $this->Session->read('CuentaUsuario.Cuenta.logo')=="/img/"){
                            ?>
                        <img src="http://bosinmobiliaria.com/beta/img/logo_inmosystem.png" width="100%">    
          <?php
                        }else{
                            ?>
                        <img src="http://bosinmobiliaria.com/beta/img/<?= $this->Session->read('CuentaUsuario.Cuenta.logo')?>" width="100%">
          <?php
                            
                        }
                        ?></p>
    <p class="login-box-msg">Evento registrado por BOS Estrategia Inmobiliaria</p>
    <p style="text-align: center"></p>
    <p><b>Fecha y hora: </b><?= $fecha?></p>
    <p><b>Evento: </b><?= $evento?></p>
    <p><b>Asignado a: </b><?= $asesor['User']['nombre_completo']?></p>
    <?php if ($cliente!=""){?>
    <p><b>Cliente: </b><?= $cliente['Cliente']['nombre']." ".$cliente['Cliente']['apellido_paterno']." ".$cliente['Cliente']['apellido_materno']?></p>
    <?php 
        }
        if ($propiedad!=""){
    ?>
    <p><b>Propiedad: </b><?= $propiedad['Inmueble']['referencia']?></p>
        <?php } if ($desarrollo!=""){?>
    <p><b>Desarrollo: </b><?= $desarrollo['Desarrollo']['nombre']?></p>
    <?php } ?>
    <p><b>Comentarios:</b><?= $comentarios?></p>
  </div>
  <!-- /.login-box-body -->
</div>
      
   <footer style="text-align: center">
        
        <strong>Copyright &copy; <?php echo date("Y")?> <a href="http://bosinmobiliaria.com">Bos Inmobiliaria</a>.</strong> Todos los derechos reservados.
      </footer> 
      </div>
