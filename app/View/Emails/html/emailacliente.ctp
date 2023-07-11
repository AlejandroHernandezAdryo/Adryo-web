<!DOCTYPE html>
<html lang="en" xmlns="http://adryo.com.mx" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
    <!--[if mso]>
  <style>
    table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
  </style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {
      font-family: Arial, sans-serif;
    }
    .img-asesor {
        border-radius: 100% !important;
        background-size: contain;
        max-width: 110px !important;
        max-height: 110px !important;
        height: 100%;
        border-image: 100%;
        -webkit-border-radius: 100%;
        -moz-border-image: 100%;
        -o-border-image: round;
        border-image-slice: 100%;
	}
	.cont-img-asesor {
        display: flex;
        align-items: center;
        -webkit-align-items: center;
        -moz-box-orient: horizontal;
        -o-object-fit: cover;
        object-fit: cover;
    }
    .asesor-data p{
        color: #fff;
    }
	td a{
		color:#fff !important;
	}
	a:link {
		text-decoration: none;
	}
    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #555555;
        text-decoration: none !important;
        font-weight: bold;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
  </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#fff;">
  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#fff;">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
      <tr>
        <td align="center" style="padding:0;">
                  <!--[if mso]>
          <table role="presentation" align="center" style="width:600px;">
          <tr>
          <td>
          <![endif]-->
          <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
            <tr>
                <td style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                    <a href="#" style="text-decoration:none;">
                        <img src="https://adryo.com.mx/<?= $this->Session->read('CuentaUsuario.Cuenta.logo') ?>" width="165"  style="width:165px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;">
                    </a>
                </td>
            </tr>
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <br>
                <span style="color:#212529">
                    <b>
                        Hola <?php echo $cliente['Cliente']['nombre']?>:
                    </b>
                    </span>
                    <br>
                    &nbsp;
                    <div style="text-align: justify;"><?php echo $body_message; ?>
                    </div>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;font-size:24px;line-height:28px;font-weight:bold;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
                  <!-- Tabla de propiedades -->
                  <?php if (isset($propiedades)): ?>
                  <?php foreach ($propiedades as $propiedad):?>
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock">
                      <tbody class="mcnTextBlockOuter">
                          <tr>
                              <td valign="top" class="mcnTextBlockInner">
                                  <div class="mcnTextContent" style="">
                                      <div style="border: 1px solid #E2E2E2; height: 100%;width:350px; border-radius: 8px;margin: 0 auto;margin-bottom: 32px; "
                                          id="card-center">
                                          <p style="text-align: center">
                                              <img data-file-id="2730789" height="261"
                                                  src="<?= Router::url($propiedad['FotoInmueble'][0]['ruta'], true) ?>"
                                                  style="border: 0px  ; width: 180px; height: 180px; margin: 0px;"
                                                  width="180">
                                          </p>
                                          <p style="text-align: center">
                                              <?php echo $propiedad['Inmueble']['referencia']?>
                                          </p>
                                          <p style="text-align: center">
                                              <a href="<?= Router::url('/inmuebles/detalle/'.$propiedad['Inmueble']['id'].'/'.$usuario['User']['id'], true) ?>"
                                                  style="
                                                                  width: 154px;
                                                                  display: inline-block;
                                                                  background: #376D6C;
                                                                  border: 1px solid #376D6C;
                                                                  border-radius: 8px;
                                                                  text-decoration: none;
                                                                  color: #FFFFFF;
                                                                  padding-top: 5px;
                                                                  padding-bottom: 5px;
                                                                  text-align:center;
                                                                  font-size:14px;
                                                                  ">
                                                  Ver propiedad
                                              </a>
                                          </p>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                  <?php endforeach; ?>
                  <?php endif ?>
                  <!-- Tabla de desarrollos -->
                  <?php if (isset($desarrollos)): ?>
                  <?php foreach ($desarrollos as $desarrollo):?>
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock">
                      <tbody class="mcnTextBlockOuter">
                          <tr>
                              <td valign="top" class="mcnTextBlockInner">
                                  <div class="mcnTextContent" style="">
                                      <div style="border: 1px solid #E2E2E2; height: 100%; border-radius: 8px;margin: 0 auto;margin-bottom: 32px;"
                                          id="card-center">
                                          <p style="text-align: center">
                                              <img data-file-id="2730789" height="261"
                                                  src="<?= Router::url($desarrollo['FotoDesarrollo'][0]['ruta'], true) ?>"
                                                  style="border: 0px  ; width: 180px; height: 180px; margin: 0px;"
                                                  width="180">
                                          </p>
                                          <p style="text-align: center">
                                              <?php echo $desarrollo['Desarrollo']['nombre']?>
                                          </p>
                                          <p style="text-align: center">
                                              <a href="<?= Router::url('/desarrollos/detalle/'.$desarrollo['Desarrollo']['id'].'/'.$usuario['User']['id'], true) ?>"
                                                  style="
                                                                  width: 154px;
                                                                  display: inline-block;
                                                                  background: #376D6C;
                                                                  border: 1px solid #376D6C;
                                                                  border-radius: 8px;
                                                                  text-decoration: none;
                                                                  color: #FFFFFF;
                                                                  padding-top: 5px;
                                                                  padding-bottom: 5px;
                                                                  text-align:center;
                                                                  font-size:14px;
                                                                  ">
                                                  Ver desarrollo
                                              </a>
                                          </p>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                  <?php endforeach; ?>
                  <?php endif; ?>
              </td>
            </tr>
            <!-- firma -->
            <tr>
              <td>
                <table style="height: 200px; border: 0; width:100%;  margin-top: 33px;background-color:#444; ">
                  <tbody>
                    <tr class="firma">
                      <td style="padding: 16px;">
                        <table style="height: 80%">
                          <tbody>
                            <!-- Datos de contacto -->
                            <tr>
                              <!-- Logo -->
                              <td id="photo-asesor">
                                <div class="cont-img-asesor">
                                  <img class="img-asesor" src="https://adryo.com.mx/<?= $usuario['User']['foto'] ?>" width="115" height="115" alt="" style="border-radius:100%;">
                                </div>
                              </td>
                              <td id="datos-asesor">
                                <table style="height: 100%;width:100%;">
                                  <tbody>
                                    <tr>
                                      <td style="padding-right: 16px;">
                                        <p>
                                          <img alt="Asesor" src="https://adryo.com.mx/img/person.png" class="email_icon">
                                        </p>
                                      </td>
                                      <td>
                                        <div
                                          style="font-family: 'Montserrat', sans-serif; font-style: normal;font-weight: 600; line-height: auto;  font-size: 16px; color:#fff;">
                                          <?= ( empty( $usuario['User']['nombre_completo'] ) ? 'Sin nombre' : $usuario['User']['nombre_completo'] ) ?>
                                        </div>
                                        <div
                                          style="font-family: 'Montserrat', sans-serif; font-style: normal;font-weight: 400; line-height: auto; font-size: 14px;color:#fff;">
                                          Asesor
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <img alt="Teléfono" src="https://adryo.com.mx/img/phone.png" class="email_icon">
                                      </td>
                                      <td
                                        style="font-family: 'Montserrat', sans-serif; font-style: normal;font-weight: 400; line-height: 24px;  font-size: 12px;color:#fff;">
                                        <?= ( empty( $usuario['User']['telefono1'] ) ? 'Sin teléfono' : $usuario['User']['telefono1'] ) ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <img alt="Sitio web" src="https://adryo.com.mx/img/website.png" class="email_icon">
                                      </td>
                                      <td class="link"
                                        style="font-family: 'Montserrat', sans-serif; font-style: normal;font-weight: 400; line-height: 24px;  font-size: 12px;color:#fff;">
                                        <?= ($this->Session->read('CuentaUsuario.Cuenta.pagina_web') != '' ? $this->Session->read('CuentaUsuario.Cuenta.pagina_web') : 'N/A' ) ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td><img alt="E-mail" src="https://adryo.com.mx/img/mail.png" class="email_icon">
                                      </td>
                                      <td class="link"
                                        style="font-family: 'Montserrat', sans-serif; font-style: normal;font-weight: 400; line-height: 24px;  font-size: 12px;color:#fff;">
                                        <?= (empty( $usuario['User']['correo_electronico'])? 'Sin correo eléctronico': $usuario['User']['correo_electronico'])?>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>  
              </td>
            </tr> 
            <!-- footer -->
            <tr>
              <td style="text-align:center;font-size:12px;color:#cccccc;">
                <table style="width:100%;">
                  <tbody>
                    <tr>
                      <td>
                        <div class="" style="background-color:#000;">
                          <p class="text-lg-center" style="color: white;">
                            <br>
                            POWERED BY
                            <br>
                            <img src="https://adryo.com.mx/img/logo_inmosystem.png"
                                style="border: 0px; margin: 0px; height: 24px; width: auto;"><br>
                            <span style="color:#FFFFFF"><small>Todos los derechos reservados <?= date('Y')?></small></span>
                          </p>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </table>
          
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
