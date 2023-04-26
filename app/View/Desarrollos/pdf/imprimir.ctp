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
                <td style="width:50%; text-align:center"><?= $desarrollo['Cuenta']['direccion']?></td>
                <td style="width:50%; text-align:center">
                    <?= ($desarrollo['Cuenta']['correo_contacto']!="" ? $desarrollo['Cuenta']['correo_contacto']."<br>" : "")?>
                    <?= ($desarrollo['Cuenta']['telefono_1']!="" ? $desarrollo['Cuenta']['telefono_1']."<br>" : "")?>
                    <?= ($desarrollo['Cuenta']['telefono_2']!="" ? $desarrollo['Cuenta']['telefono_2']."<br>" : "")?>
                    <?= ($desarrollo['Cuenta']['pagina_web']!="" ? $desarrollo['Cuenta']['pagina_web']."<br>" : "")?>
                </td>
            </tr>
        </table>
    </footer>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%"><img src="<?= $desarrollo['Cuenta']['logo']?>" style="height: 50px"></td>
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
            <td><?= $desarrollo['Desarrollo']['nombre']."/ REF:".$desarrollo['Desarrollo']['referencia']?></td>
            <td colspan="2" style="text-align:right"> 
                <?php 
                    echo "Precios a partir de: $".number_format($desarrollo['Desarrollo']['precio_low'],2);
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <img src="<?= $desarrollo['FotoDesarrollo'][0]['ruta']; ?>" style="width:300px" >
            </td>
            <td colspan="2" style="vertical-align:top">
                <table style="width:100%">
                <tr>
                    <td>
                        <img src="/img/m2.png" style="height: 30px">
                        <p><?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?></p>
                    </td>
                    <td>
                        <img src="/img/recamaras.png" style="height: 30px">
                        <p><?= $desarrollo['Desarrollo']['rec_low']?> - <?= $desarrollo['Desarrollo']['rec_top']?></p>
                    </td>
                    <td>
                        <img src="/img/banios.png" style="height: 30px">
                        <p><?= $desarrollo['Desarrollo']['banio_low']?> - <?= $desarrollo['Desarrollo']['banio_top']?></p>
                    </td>
                    <td>
                        <img src="/img/autos.png" style="height: 30px">
                        <p><?= $desarrollo['Desarrollo']['est_low']?> - <?= $desarrollo['Desarrollo']['est_top']?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table style="width:100%; color:black">
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Tipo de Desarrollo:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['tipo_desarrollo']=="&nbsp;"?"":$desarrollo['Desarrollo']['tipo_desarrollo'])?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Etapa:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['etapa_desarrollo']==""?"&nbsp;":$desarrollo['Desarrollo']['etapa_desarrollo'])?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Torres:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['torres']==""?"&nbsp;":$desarrollo['Desarrollo']['torres'])?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Unidades Totales:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['unidades_totales']==""?"&nbsp;":$desarrollo['Desarrollo']['unidades_totales'])?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Entrega:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['entrega']=="Inmediata"?"Inmediata":$desarrollo['Desarrollo']['fecha_entrega'])?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Departamento Muestra:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['departamento_muestra']==0?"No":"Si")?></b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%; vertical-align: top;">Horario Atención:</td>
                                <td style="text-align: left;width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['horario_contacto']==""?"&nbsp;":$desarrollo['Desarrollo']['horario_contacto'])?></b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="map"></div>
                                    <?php
                                if ($desarrollo['Desarrollo']['google_maps']!=""){
                                list($latitud, $longitud) = explode(",", $desarrollo['Desarrollo']['google_maps']);
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
                 <?php echo $desarrollo['Desarrollo']['descripcion'];?>
            </td>
        </tr>
        <tr style="background-color:#51818f; color:white">
            <td colspan="3">
              Lugares de Interés  
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php echo ($desarrollo['Desarrollo']['cc_cercanos']            == 1 ? '<div class="col-lg-4">Centros Comerciales Cercanos</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['escuelas']               == 1 ? '<div class="col-lg-4">Escuelas</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['frente_parque']          == 1 ? '<div class="col-lg-4">Frente a Parque</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['parque_cercano']         == 1 ? '<div class="col-lg-4">Parques Cercanos</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['plazas_comerciales']     == 1 ? '<div class="col-lg-4">Plazas Comerciales</div>' : "") ?>
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
                <?php echo ($desarrollo['Desarrollo']['alberca_sin_techar']         == 1 ? '<div class="col-lg-4">Alberca descubierta</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['alberca_techada']            == 1 ? '<div class="col-lg-4">Alberca Techada</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['sala_cine']                  == 1 ? '<div class="col-lg-4">Área de Cine</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['juegos_infantiles']          == 1 ? '<div class="col-lg-4">Área de Juegos Infantiles</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['fumadores']                  == 1 ? '<div class="col-lg-4">Área para fumadores</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['areas_verdes']               == 1 ? '<div class="col-lg-4">Áreas Verdes</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['asador']                     == 1 ? '<div class="col-lg-4">Asador</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['cafeteria']                  == 1 ? '<div class="col-lg-4">Cafetería</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['golf']                       == 1 ? '<div class="col-lg-4">Campo de Golf</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['paddle_tennis']              == 1 ? '<div class="col-lg-4">Cancha de Paddle</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['squash']                     == 1 ? '<div class="col-lg-4">Cancha de Squash</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['tennis']                     == 1 ? '<div class="col-lg-4">Cancha de Tennis</div>' : "") ?>


                <?php echo ($desarrollo['Desarrollo']['carril_nado']                == 1 ? '<div class="col-lg-4">Carril de Nado</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['fire_pit']                   == 1 ? '<div class="col-lg-4">Fire Pit</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['gimnasio']                   == 1 ? '<div class="col-lg-4">Gimnasio</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['jacuzzi']                    == 1 ? '<div class="col-lg-4">Jacuzzi</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['living']                     == 1 ? '<div class="col-lg-4">Living</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['lobby']                      == 1 ? '<div class="col-lg-4">Lobby</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['boliche']                    == 1 ? '<div class="col-lg-4">Mesa de Boliche</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['pista_jogging']              == 1 ? '<div class="col-lg-4">Pista de Jogging</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['play_room']                  == 1 ? '<div class="col-lg-4">Play Room / Cuarto de Juegos</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['restaurante']                == 1 ? '<div class="col-lg-4">Restaurante</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['roof_garden_compartido']     == 1 ? '<div class="col-lg-4">Roof Garden</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['salon_juegos']               == 1 ? '<div class="col-lg-4">Salón de Juegos</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['salon_usos_multiples']       == 1 ? '<div class="col-lg-4">Salón de usos múltiples</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['sauna']                      == 1 ? '<div class="col-lg-4">Sauna</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['spa_vapor']                  == 1 ? '<div class="col-lg-4">Spa</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['sky_garden']                 == 1 ? '<div class="col-lg-4">Sky Garden</div>' : "") ?>
            </td>
            <td colspan="2">
                <?php echo ($desarrollo['Desarrollo']['acceso_discapacitados']      == 1 ? '<div class="col-lg-4">Acceso de discapacitados</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['internet']                   == 1 ? '<div class="col-lg-4">Acceso Internet / WiFi</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['tercera_edad']               == 1 ? '<div class="col-lg-4">Acceso para Tercera Edad</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['aire_acondicionado']         == 1 ? '<div class="col-lg-4">Aire Acondicionado</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['business_center']            == 1 ? '<div class="col-lg-4">Business Center</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['calefaccion']                == 1 ? '<div class="col-lg-4">Calefacción</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['cctv']                       == 1 ? '<div class="col-lg-4">CCTV</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['conmutador']                 == 1 ? '<div class="col-lg-4">Conmutador</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['edificio_inteligente']       == 1 ? '<div class="col-lg-4">Edificio Inteligente</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['edificio_leed']              == 1 ? '<div class="col-lg-4">Edificio LEED</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['elevadores']                 == 1 ? '<div class="col-lg-4">Elevadores</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-4">Estacionamiento de visitas</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['gas_lp']                     == 1 ? '<div class="col-lg-4">Gas LP</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['gas_natural']                == 1 ? '<div class="col-lg-4">Gas Natural</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['lavanderia']                 == 1 ? '<div class="col-lg-4">Lavanderia</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['locales_comerciales']        == 1 ? '<div class="col-lg-4">Locales Comerciales</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['mascotas']                   == 1 ? '<div class="col-lg-4">Permite Mascotas</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['planta_emergencia']          == 1 ? '<div class="col-lg-4">Planta de Emergencia</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['porton_electrico']           == 1 ? '<div class="col-lg-4">Portón Eléctrico</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['sistema_contra_incendios']   == 1 ? '<div class="col-lg-4">Sistema Contra Incendios</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['sistema_seguridad']          == 1 ? '<div class="col-lg-4">Sistema de Seguridad</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['valet_parking']              == 1 ? '<div class="col-lg-4">Valet Parking</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['vapor']                      == 1 ? '<div class="col-lg-4">Vapor</div>' : "") ?>
                <?php echo ($desarrollo['Desarrollo']['seguridad']                  == 1 ? '<div class="col-lg-4">Vigilancia / Seguridad</div>' : "") ?>
            </td>
        </tr>
    </table>
</body>
