<style>
    body{
        font-size: 9px;
        font-family: DejaVu Sans, sans-serif;
    }
    #map {
        height: 150px;
        width: 100%;
       }
       .no-print{display: none;}
    
    .col-lg-4 {
        width: 33.33333333%;
        
    }
    .col-lg-5 {
        width: 50%;
        position: relative;
        min-height: 1px;
        padding-left: 5px;
        padding-right: 5px;
        float: left;
    }
    footer { position: fixed; bottom: -20px; left: 0px; right: 0px; background-color: #bab9b9; height: 50px; }
    
</style>
<body>
    <footer>
        <table style="width:100%">
            <tr>
                <td style="width:50%; text-align:center"><?= $inmueble['Cuenta']['direccion']?></td>
                <td style="width:50%; text-align:center">
                    <?= ($inmueble['Cuenta']['correo_contacto']!="" ? $inmueble['Cuenta']['correo_contacto']."<br>" : "")?>
                    <?= ($inmueble['Cuenta']['telefono_1']!="" ? $inmueble['Cuenta']['telefono_1']."<br>" : "")?>
                    <?= ($inmueble['Cuenta']['telefono_2']!="" ? $inmueble['Cuenta']['telefono_2']."<br>" : "")?>
                    <?= ($inmueble['Cuenta']['pagina_web']!="" ? $inmueble['Cuenta']['pagina_web']."<br>" : "")?>
                </td>
            </tr>
        </table>
    </footer>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%"><img src="<?= $inmueble['Cuenta']['logo']?>" style="height: 50px"></td>
            <td style="text-align: right">
                <b><?= $agente['User']['nombre_completo']?></b>&nbsp;
                <br><?= $agente['User']['correo_electronico']?>
                <br><?= $agente['User']['telefono1']?>
                <?= ($agente['User']['telefono2']!=""?"<br>".$agente['User']['telefono2'] : "")?>
            </td>
            <td style="width: 10%">
                <img src="<?= $agente['User']['foto']?>" style="height: 50px">
            </td>
        </tr>
        <tr style="background-color:#51818f; color:white">
            <td><?= $inmueble['Inmueble']['titulo']."/ REF:".$inmueble['Inmueble']['referencia']?></td>
            <td colspan="2" style="text-align:right"> <?php 
                    if ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                        echo "Precio Venta: $".number_format($inmueble['Inmueble']['precio'],2)."<br>";
                    }
                    if ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
                        echo "Precio Renta: $".number_format($inmueble['Inmueble']['precio_2'],2);
                    }
                 ?>
            </td>
        </tr>
        <tr>
            <td>
                <img src="<?= $inmueble['FotoInmueble'][0]['ruta']; ?>" style="width:300px" >
            </td>
            <td colspan="2" style="vertical-align:top">
                <table style="width:100%">
                <tr>
                    <td>
                        <img src="/img/m2.png" style="height: 30px">
                        <p><b><?= $inmueble['Inmueble']['construccion']+$inmueble['Inmueble']['construccion_no_habitable']?>m<sup>2</sup></b></p>
                    </td>
                    <td>
                        <img src="/img/recamaras.png" style="height: 30px">
                        <p><b><?= $inmueble['Inmueble']['recamaras']?></b></p>
                    </td>
                    <td>
                        <img src="/img/banios.png" style="height: 30px">
                        <p><b><?= $inmueble['Inmueble']['banos']?><?= ($inmueble['Inmueble']['medio_banos']==0||$inmueble['Inmueble']['medio_banos']==""?"":" y ".$inmueble['Inmueble']['medio_banos']." medios baños")?></b></p>
                    </td>
                    <td>
                        <img src="/img/autos.png" style="height: 30px">
                        <p><b><?= $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="map"></div>
                                    <?php
                                if ($inmueble['Inmueble']['google_maps']!=""){
                                list($latitud, $longitud) = explode(",", $inmueble['Inmueble']['google_maps']);
                            ?>
                                    <script>
                                      function initMap() {
                                        var uluru = {lat: <?= $latitud?>, lng: <?= $longitud?>};
                                        var map = new google.maps.Map(document.getElementById('map'), {
                                          zoom: 16,
                                          center: uluru
                                        });
                                        var marker = new google.maps.Marker({
                                          position: uluru,
                                          map: map
                                        });
                                      }
                                    </script>
                                    
                                    <script async defer
                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOf3eYcnrP8hgEx5_914fUwMR1NCyQPfw&callback=initMap">
                                    </script>
                                     <?php }else{
                                         echo ("Sin coordenadas");
                                     }
                                     ?>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        <tr style="background-color:#51818f; color:white">
            <td colspan="3">
                Descripci&oacute;n
            </td>
        </tr>
        <tr>
            <td colspan="3">
                 <?php echo $inmueble['Inmueble']['comentarios'];?>
            </td>
        </tr>
        <tr style="background-color:#51818f; color:white">
            <td colspan="3">
                <?= utf8_decode("Detalle")?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php if ($inmueble['Inmueble']['frente_fondo']!=""){?>
                <div class="col-lg-4">
                    <?= "Frente x Fondo: ".$inmueble['Inmueble']['frente_fondo']?>
                </div>
            <?php }?>
            <?php if ($inmueble['Inmueble']['construccion']!=""){?>
                <div class="col-lg-4">
                    <?= "Superficie Habitable: ".$inmueble['Inmueble']['construccion']."m<sup>2</sup>"?>
                </div>
            <?php }?>
            <?php if ($inmueble['Inmueble']['construccion_no_habitable']!=""){?>
                <div class="col-lg-4">
                    <?= "Superficie No Habitable: ".$inmueble['Inmueble']['construccion_no_habitable']."m<sup>2</sup>"?>
                </div>
            <?php }?>
            <?php if ($inmueble['Inmueble']['banos']!=""){?>
                <div class="col-lg-4">
                    <?= "Baños Completos: ".$inmueble['Inmueble']['banos']?>
                </div>
            <?php }?>
            <?php if ($inmueble['Inmueble']['medio_banos']!=""){?>
                <div class="col-lg-4">
                    <?= "Medios Baños: ".$inmueble['Inmueble']['medio_banos']?>
                </div>
            <?php }?>
            <?php if ($inmueble['Inmueble']['estacionamiento_techado']!=""){?>
                <div class="col-lg-4">
                    <?= "Estacionamientos Techados: ".$inmueble['Inmueble']['estacionamiento_techado']?>
                </div>
            <?php }?>
            <?php if ($inmueble['Inmueble']['estacionamiento_descubierto']!=""){?>
                <div class="col-lg-4">
                    <?= "Estacionamientos Descubiertos: ".$inmueble['Inmueble']['estacionamiento_descubierto']?>
                </div>
            <?php }?>
            <?php 
            if ($inmueble['Inmueble']['nivel_propiedad']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Nivel de la propiedad: ".$inmueble['Inmueble']['nivel_propiedad']?>
                </div>
            <?php 
            }
            if ($inmueble['Inmueble']['niveles_totales']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Niveles Totales: ".$inmueble['Inmueble']['niveles_totales']?>
                </div>
            <?php 
            }
            if ($inmueble['Inmueble']['unidades_totales']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Unidades Totales: ".$inmueble['Inmueble']['unidades_totales']?>
                </div>
            <?php 
            }
            if ($inmueble['Inmueble']['disposicion']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Disposición: ".$inmueble['Inmueble']['disposicion']?>
                </div>
            <?php 
            }
            if ($inmueble['Inmueble']['orientacion']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Orientación: ".$inmueble['Inmueble']['orientacion']?>
                </div>
            <?php 
            }
            if ($inmueble['Inmueble']['edad']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Edad en Años: ".$inmueble['Inmueble']['edad']?>
                </div>
            <?php 
            }
            if ($inmueble['Inmueble']['mantenimiento']!=""){
            ?>
                <div class="col-lg-4">
                    <?= "Mantenimiento: ".$inmueble['Inmueble']['mantenimiento']?>
                </div>
            <?php 
            }
            ?>
            </td>
        </tr>
        <tr style="background-color:#51818f; color:white">
            <td colspan="3">
              Lugares de Interés  
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php echo ($inmueble['Inmueble']['cc_cercanos']            == 1 ? '<div class="col-lg-4">Centros Comerciales Cercanos</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['escuelas']               == 1 ? '<div class="col-lg-4">Escuelas</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['frente_parque']          == 1 ? '<div class="col-lg-4">Frente a Parque</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['parque_cercano']         == 1 ? '<div class="col-lg-4">Parques Cercanos</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['plazas_comerciales']     == 1 ? '<div class="col-lg-4">Plazas Comerciales</div>' : "") ?>
            </td>
        </tr>
        <tr style="background-color:#51818f; color:white">
            <td>
              Amenidades
            </td>
            <td colspan="2">
              Servicios  
            </td>
        </tr>
        <tr>
            <td>
              <?php echo ($inmueble['Inmueble']['alberca_sin_techar']         == 1 ? '<div class="col-lg-4">Alberca descubierta</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['alberca_techada']            == 1 ? '<div class="col-lg-4">Alberca Techada</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['sala_cine']                  == 1 ? '<div class="col-lg-4">Área de Cine</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['area_juegos']                == 1 ? '<div class="col-lg-4">Área de Juegos</div>': "")?>
                <?php echo ($inmueble['Inmueble']['juegos_infantiles']          == 1 ? '<div class="col-lg-4">Área de Juegos Infantiles</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['fumadores']                  == 1 ? '<div class="col-lg-4">Área para fumadores</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['areas_verdes']               == 1 ? '<div class="col-lg-4">Áreas Verdes</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['asador']                     == 1 ? '<div class="col-lg-4">Asador</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['business_center']            == 1 ? '<div class="col-lg-4">Business Center</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['cafeteria']                  == 1 ? '<div class="col-lg-4">Cafetería</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['golf']                       == 1 ? '<div class="col-lg-4">Campo de Golf</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['paddle_tennis']              == 1 ? '<div class="col-lg-4">Cancha de Paddle</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['squash']                     == 1 ? '<div class="col-lg-4">Cancha de Squash</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['cancha_tenis']               == 1 ? '<div class="col-lg-4">Cancha de Tennis</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['cantina_cava']               == 1 ? '<div class="col-lg-4">Cantina / Cava</div>': "")?>
                <?php echo ($inmueble['Inmueble']['carril_nado']                == 1 ? '<div class="col-lg-4">Carril de Nado</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['cocina_integral']            == 1 ? '<div class="col-lg-4">Cocina Integral</div>': "")?>
                <?php echo ($inmueble['Inmueble']['closet_blancos']             == 1 ? '<div class="col-lg-4">Closet de Blancos</div>': "")?>
                <?php echo ($inmueble['Inmueble']['desayunador_antecomedor']    == 1 ? '<div class="col-lg-4">Desayunador / Antecomedor</div>': "")?>
                <?php echo ($inmueble['Inmueble']['fire_pit']                   == 1 ? '<div class="col-lg-4">Fire Pit</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['gimnasio']                   == 1 ? '<div class="col-lg-4">Gimnasio</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['jacuzzi']                    == 1 ? '<div class="col-lg-4">Jacuzzi</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['living']                     == 1 ? '<div class="col-lg-4">Living</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['lobby']                      == 1 ? '<div class="col-lg-4">Lobby</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['boliche']                    == 1 ? '<div class="col-lg-4">Mesa de Boliche</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['patio_servicio']             == 1 ? '<div class="col-lg-4">Patio de Servicio</div>': "")?>
                <?php echo ($inmueble['Inmueble']['pista_jogging']              == 1 ? '<div class="col-lg-4">Pista de Jogging</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['play_room']                  == 1 ? '<div class="col-lg-4">Play Room / Cuarto de Juegos</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['restaurante']                == 1 ? '<div class="col-lg-4">Restaurante</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['roof_garden_compartido']     == 1 ? '<div class="col-lg-4">Roof Garden</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['sala_tv']                    == 1 ? '<div class="col-lg-4">Sala de TV</div>': "")?>
                <?php echo ($inmueble['Inmueble']['salon_juegos']               == 1 ? '<div class="col-lg-4">Salón de Juegos</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['salon_multiple']             == 1 ? '<div class="col-lg-4">Salón de usos múltiples</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['sauna']                      == 1 ? '<div class="col-lg-4">Sauna</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['spa']                        == 1 ? '<div class="col-lg-4">Spa</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['sky_garden']                 == 1 ? '<div class="col-lg-4">Sky Garden</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['tina_hidromasaje']           == 1 ? '<div class="col-lg-4">Tina de Hidromasaje</div>': "")?>
                <?php echo ($inmueble['Inmueble']['vapor']                      == 1 ? '<div class="col-lg-4">Vapor</div>': "")?>
            </td>
            <td colspan="2">
              <?php echo ($inmueble['Inmueble']['acceso_discapacitados']      == 1 ? '<div class="col-lg-4">Acceso de discapacitados</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['agua_corriente']             == 1 ? '<div class="col-lg-4">Agua Corriente</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['amueblado']                  == 1 ? '<div class="col-lg-4">Amueblado</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['internet']                   == 1 ? '<div class="col-lg-4">Acceso Internet / WiFi</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['tercera_edad']               == 1 ? '<div class="col-lg-4">Acceso para Tercera Edad</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['aire_acondicionado']         == 1 ? '<div class="col-lg-4">Aire Acondicionado</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['bodega']                     == 1 ? '<div class="col-lg-4">Bodega</div>': "")?>
                <?php echo ($inmueble['Inmueble']['boiler']                     == 1 ? '<div class="col-lg-4">Boiler / Calentador de Agua</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['calefaccion']                == 1 ? '<div class="col-lg-4">Calefacción</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['cctv']                       == 1 ? '<div class="col-lg-4">CCTV</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['conmutador']                 == 1 ? '<div class="col-lg-4">Conmutador</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['interfon']                   == 1 ? '<div class="col-lg-4">Interfón</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['edificio_inteligente']       == 1 ? '<div class="col-lg-4">Edificio Inteligente</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['edificio_leed']              == 1 ? '<div class="col-lg-4">Edificio LEED</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['elevador']                   == 1 ? '<div class="col-lg-4">Elevadores</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-4">Estacionamiento de visitas</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['gas_lp']                     == 1 ? '<div class="col-lg-4">Gas LP</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['gas_natural']                == 1 ? '<div class="col-lg-4">Gas Natural</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['lavavajillas']               == 1 ? '<div class="col-lg-4">Lavavajillas</div>': "")?>
                <?php echo ($inmueble['Inmueble']['lavanderia']                 == 1 ? '<div class="col-lg-4">Lavanderia</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['linea_telefonica']           == 1 ? '<div class="col-lg-4">Línea Telefónica</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['locales_comerciales']        == 1 ? '<div class="col-lg-4">Locales Comerciales</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['mascotas']                   == 1 ? '<div class="col-lg-4">Permite Mascotas</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['planta_emergencia']          == 1 ? '<div class="col-lg-4">Planta de Emergencia</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['porton_electrico']           == 1 ? '<div class="col-lg-4">Portón Eléctrico</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['refrigerador']               == 1 ? '<div class="col-lg-4">Refrigerador</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['sistema_incendios']          == 1 ? '<div class="col-lg-4">Sistema Contra Incendios</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['sistema_seguridad']          == 1 ? '<div class="col-lg-4">Sistema de Seguridad</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['valet_parking']              == 1 ? '<div class="col-lg-4">Valet Parking</div>' : "") ?>
                <?php echo ($inmueble['Inmueble']['vigilancia']                 == 1 ? '<div class="col-lg-4">Vigilancia / Seguridad</div>' : "") ?> 
            </td>
        </tr>
    </table>
</body>
