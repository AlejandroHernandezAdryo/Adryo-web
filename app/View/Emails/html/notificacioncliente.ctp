      <div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">
      <p><?php 
                if ($this->Session->read('CuentaUsuario.Cuenta.logo')==""|| $this->Session->read('CuentaUsuario.Cuenta.logo')=="/img/"){
                    ?>
                <img src="http://bosinmobiliaria.com/beta/img/logo_inmosystem.png" width="20%">    
    <?php
                }else{
                    ?>
                <img src="http://bosinmobiliaria.com/beta/img/<?= $this->Session->read('CuentaUsuario.Cuenta.logo')?>" width="20%">
    <?php
                    
                }
                ?></p>
    <p> El usuario <?= $usuario['User']['nombre_completo']?> ha registrado los cambios del cliente: 
         <?php echo $cliente['Cliente']['nombre']." ".$cliente['Cliente']['apellido_paterno']." ".$cliente['Cliente']['apellido_materno']?></p>
  </div>
  <!-- /.login-box-body -->
</div>
      
   <footer style="text-align: center">
        
        <strong>Copyright &copy; <?php echo date("Y")?> <a href="#">Inmosystem</a>.</strong> Todos los derechos reservados.
      </footer> 
      



