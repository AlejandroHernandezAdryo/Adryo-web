<?php
    $this->assign('title',$desarrollo['Desarrollo']['nombre']);
    echo $this->Html->meta('keywords','agente inmobiliario, trabajo inmobiliaria, oferta de propiedades, comercialización inmobiliaria, asesoria inmobiliaria, consultoría inmobiliaria, comercialización de imbuebles, oferta de inmuebles', array("inline" => false));
    $this->assign('author','<meta name="author" content="'.$desarrollo['Cuenta']['nombre_comercial'].'">');
    //Facebook META
    $this->assign('og:url','<meta property="og:url" content="'.Router::url('/', true).'cotizacions/cotizacion_view/'.$cotizacion['Cotizacion']['id'].'" />');
    $this->assign('og:image','<meta property="og:image" content="https://adryo.com.mx'.$desarrollo['FotoDesarrollo'][0]['ruta'].'"/>');
    $this->assign('og:image:width','1280px');
    $this->assign('og:image:height','1100px');
    $descripcion = $desarrollo['Desarrollo']['descripcion'];
    $this->assign('og:description',"<meta property='og:description' content='.$descripcion.'/>");
    $this->assign('og:title','<meta property="og:title" content="'.$desarrollo['Desarrollo']['nombre'].'"/>');
    $this->assign('og:type','<meta property="og:type" content="website"/>');
    //Google META
    $this->assign('google_name','<meta itemprop="name" content="'.$desarrollo['Cuenta']['nombre_comercial'].'">');
    $this->assign('google_description','<meta itemprop="description" content="'.$desarrollo['Desarrollo']['nombre'].'"/>');
    $this->assign('google_image','<meta itemprop="image" content="https://adryo.com.mx'.$desarrollo['FotoDesarrollo'][0]['ruta'].'"/>');

    echo $this->Html->css(
        array(
            'components',
            'pages/layouts',
            'custom',
            'cotizacion',
            'components_adryo',
        ),
        array('inline'=>false)
    );
?>

<div class="modal fade" id="modal-desicion-cotizacion">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-center text-black">
                        Se registró el interés en la cotización
                    </p>
                </div>
            </div>
            <!-- Form delete cliente -->
            
            <div class="modal-footer">
              <div class="row">
                  <div class="col-sm-12">
                      <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                  </div>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="container outer">
    <div class="inner">
        
        <!-- Imagen desarrollo, nombre y referencia, plano. -->
        <div class="row">
            <div class="col-sm-12">
                <div class="text-sm-center">
                    <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'],array('class' => 'bg-img-cotizacion'))?>
                </div>
            </div>
            <div class="col-sm-12">
                <h2 class='pt-1 pb-1 title bg-blue-is text-sm-center'><?= $desarrollo['Desarrollo']['nombre'].' / '.$cotizacion['Inmueble']['referencia'] ?></h2>
            </div>
            <div class="col-sm-12" id='container-fondo-plano'>
                <p class='text-sm-center'>
                    <?= $this->Html->image($cotizacion['Inmueble']['FotoInmueble'][0]['ruta'], array('class' => 'img-fluid-cotizacion')) ?>
                </p>
            </div>
        </div>

        <!-- Informacion del presupuesto Titulo-->
        <div class="row">
            <div class="col-sm-12">
                <h2 class='pt-1 pb-1 title bg-blue-is text-sm-center'>presupuesto</h2>
            </div>
        </div>
        
        <!-- Tipo de venta y precio con dscto -->
        <div class="row mt-2">
            <div class="col-sm-12 col-lg-3 subtitulo">
                Tipo de venta:
            </div>
            <div class="col-sm-12 col-lg-3">
                <?= $desarrollo['Desarrollo']['etapa_desarrollo'] ?>
            </div>
            <div class="col-sm-12 col-lg-3 subtitulo">
                Precio con descuento:
            </div>
            <div class="col-sm-12 col-lg-3">

                    <?php
                        if( $cotizacion['Cotizacion']['descuento'] > 100 ){
                            echo '$'.number_format(($cotizacion['Cotizacion']['precio'] - $cotizacion['Cotizacion']['descuento']), 2);
                        }else{
                            // echo '$'.number_format( ($cotizacion['Cotizacion']['precio'] * $cotizacion['Cotizacion']['descuento'] / 100), 2 );
                            echo '$'.number_format( ($cotizacion['Cotizacion']['precio'] - ($cotizacion['Cotizacion']['precio'] * $cotizacion['Cotizacion']['descuento'] / 100)), 2 );
                        }
                    ?>
            </div>
        </div>

        <!-- Precio de lista y extras -->
        <div class="row">
            <div class="col-sm-12 col-lg-3 subtitulo">
                Precio de Lista:
            </div>
            <div class="col-sm-12 col-lg-3">
                $ <?= number_format($cotizacion['Cotizacion']['precio'], 2) ?>
            </div>

            <div class="col-sm-12 col-lg-3 subtitulo">
                Total de extras o complementos:
            </div>
            <div class="col-sm-12 col-lg-3">
                $ <?= number_format( $cotizacion['Cotizacion']['precio_extras'], 2 ) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-3 subtitulo">
                Plan de pago:
            </div>
            <div class="col-sm-12 col-lg-9">
                <?= $cotizacion['Cotizacion']['forma_pago'] ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-3 subtitulo">
                Descuento:
            </div>
            <div class="col-sm-12 col-lg-9">
                <?php
                    if( $cotizacion['Cotizacion']['descuento'] < 100 ){
                        echo number_format($cotizacion['Cotizacion']['descuento'], 2).'%' ;
                    }else{
                        echo number_format( ($cotizacion['Cotizacion']['descuento'] / $cotizacion['Cotizacion']['precio'] ) * 100, 2 ).'%';
                    }
                ?>

            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 col-lg-3 subtitulo">
                Total descuento:
            </div>
            <div class="col-sm-12 col-lg-9">
                <?php
                    if( $cotizacion['Cotizacion']['descuento'] > 100 ){
                        echo '$'.number_format($cotizacion['Cotizacion']['descuento'], 2) ;
                    }else{
                        // echo number_format( $cotizacion['Cotizacion']['descuento'], 2 ).'%';
                        echo '$'.number_format( ($cotizacion['Cotizacion']['descuento'] * $cotizacion['Cotizacion']['precio'] ) / 100, 2 );
                    }
                ?>
            </div>
        </div>

        <!-- Informacion del presupuesto Extras o complementos -->
        <div class="row presupuesto" id="plan-pagos">
            <div class="col-sm-12">
                <?= $cotizacion['Cotizacion']['cotizacion'] ?>
            </div>
        </div>

        <!-- Detalles de la propiedad e información del cliente. -->
        <div class="row mt-1">
            
            <!-- Detalles de la propiedad. -->
            <div class="col-sm-12 col-lg-6">
                
                <div class="row">
                    <div class="col-sm-12 text-sm-center">
                        <h2 class='pt-1 pb-1 title bg-blue-is'>Detalles de la propiedad</h2>
                    </div>
                </div>

                <!-- Informacion de la propiedad. -->
                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Tipo de la propiedad:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Inmueble']['TipoPropiedad']['tipo_propiedad'] ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Referencia de propiedad:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Inmueble']['referencia'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Area total:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= number_format( $cotizacion['Inmueble']['construccion'] + $cotizacion['Inmueble']['construccion_no_habitable'] ) ?> m<sup>2</sup>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Recámaras:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Inmueble']['recamaras'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Baños:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Inmueble']['banos'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Estacionamientos:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Inmueble']['estacionamiento_techado'] + $cotizacion['Inmueble']['estacionamiento_descubierto'] ?>
                    </div>
                </div>


            </div>

            <!-- Información del cliente -->
            <div class="col-sm-12 col-lg-6">
                
                <div class="row">
                    <div class="col-sm-12 text-sm-center">
                        <h2 class='pt-1 pb-1 title bg-blue-is'>datos del cliente</h2>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Nombre del cliente
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Cliente']['nombre'] ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Correo:
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Cliente']['correo_electronico'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 subtitulo">
                        Teléfono
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <?= $cotizacion['Cliente']['telefono1'] ?>
                    </div>
                </div>

            </div>

        </div>

        <!-- Medios de pago -->
        <div class="row">
            <div class="col-sm-12 mt-1">
                <h2 class='pt-1 pb-1 title bg-blue-is text-sm-center'>Medios de pago</h2>
            </div>

            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>TIPO DE CUENTA</th>
                                <th>TITULAR</th>
                                <th>BANCO</th>
                                <th>NÚMERO DE CUENTA</th>
                                <th>CUENTA CLABE</th>
                            </tr>
                        </thead>
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
            </div>
        </div>

        <!-- información de asesor y vigencia. -->
        <div class="row mt-1">
            
            <div class="col-sm-12 col-lg-6">
                
                <div class="row">
                    <div class="col-sm-12 text-sm-center">
                        <h2 class='pt-1 pb-1 title bg-blue-is'>Asesor</h2>
                    </div>
                </div>

                <!-- Informacion de asesor. -->
                <div class="row">
                    <div class="col-sm-12 col-lg-2 subtitulo mt-1">
                        <i class="fa fa-user fa-x4"></i>
                    </div>
                    <div class="col-sm-12 col-lg-10 mt-1">
                        <?= $cotizacion['Asesor']['nombre_completo'] ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-2 subtitulo mt-1">
                        <i class="fa fa-envelope fa-x4"></i>
                    </div>
                    <div class="col-sm-12 col-lg-10 mt-1">
                        <?= $cotizacion['Asesor']['correo_electronico'] ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 col-lg-2 subtitulo mt-1">
                        <i class="fa fa-phone fa-x4"></i>
                    </div>
                    <div class="col-sm-12 col-lg-10 mt-1">
                        <?= ( !empty($cotizacion['Asesor']['telefono1']) ? $cotizacion['Asesor']['telefono1'] : 'Sin teléfono' ) ?>
                    </div>
                </div>

                

            </div>

            <div class="col-sm-12 col-lg-6">
                
                <div class="row">
                    <div class="col-sm-12 text-sm-center">
                        <h2 class='pt-1 pb-1 title bg-blue-is'>vigencia</h2>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-sm-12 col-lg-8 subtitulo">
                        Fecha de cotización:
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <?= date('d-m-Y', strtotime($cotizacion['Cotizacion']['fecha'])) ?>
                    </div>

                    <div class="col-sm-12 mt-1 col-lg-8 subtitulo">
                        Cotización vigente hasta el día:
                    </div>
                    <div class="col-sm-12 mt-1 col-lg-4">
                        <?= date('d-m-Y', strtotime($cotizacion['Cotizacion']['vigencia'])) ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="row" id="row-observaciones">
            <div class="col-sm-12 mt-1">
                <h2 class='pt-1 pb-1 title bg-blue-is text-sm-center'>Observaciones</h2>
            </div>

            <div class="col-sm-12">
                <b>
                    <?= $cotizacion['Cotizacion']['observaciones'] ?>
                    <br>
                    * Esta cotización está sujeta a cambios de precios y condiciones sin previo aviso.
                    <br>
                    * No se incluyen gastos notariales ni de apertura de crédito.
                </b>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-sm-12 text-center">
                <?php if( $cotizacion['Cotizacion']['status'] == 1 OR  $cotizacion['Cotizacion']['status'] == 2 ): ?>
                    <a class='btn btn-success pointer' id="btn-me-gusta" style="background-color:#376D6C !important;">
                        <h3>
                            Me gusta esta cotización
                        </h3>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Pie de página -->
        <div class="row mt-2" id="footer">
            <div class="col-sm-12">
                <p class="text-sm-center pt-1 pb-1" style="color: white; background-color: #555555;">
                    POWERED BY <br>
                    <img src="<?= Router::url('/img/logo_inmosystem.png',true) ?>" style="border: 0px; width: 80px; margin: 0px; height: 30px; width: auto;"><br>
                    <span style="color:#FFFFFF"><small>Todos los derechos reservados <?= date('Y')?></small></span>
                </p>
            </div>
        </div>


    </div>
</div>

<?php 
    echo $this->Html->script([
        
        'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
        // Data tables
        'components',
        'custom',



    ], array('inline'=>true));
?>

<script>
    $("#btn-me-gusta").on('click', function (){

        // Traer el listado de los errores.
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "cotizacions", "action" => "me_gusta")); ?>',
            cache: false,
            type : "POST",
            data: { cotizacion_id: <?= $cotizacion['Cotizacion']['id'] ?>  },
            beforeSend: function () {
                // $("#modalSendCotizacion").modal("hide");
            },
            success: function ( response ) {

                $("#modal-desicion-cotizacion").modal("show");
                $("#btn-me-gusta").addClass('hiden');

                console.log( response );

            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });


    });
</script>