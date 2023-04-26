<style>
    #map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 100%;
    height: 100%;
}
    
</style>
<script >
    jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers
    var markers = [
        ['<?php echo $inmueble['Inmueble']['referencia'] ?>', <?php echo $inmueble['Inmueble']['google_maps']?>]
        
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3><?php echo $inmueble['Inmueble']['referencia'] ?></h3>' +
        '<p><?php echo $inmueble['Inmueble']['colonia'] ?></p>' +        '</div>']
        
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
    
}
</script>
        
	<section class="invoice">
        <?php 
        if ($this->Session->read('CuentaUsuario.Cuenta.logo')==""|| $this->Session->read('CuentaUsuario.Cuenta.logo')=="/img/"){
            echo $this->Html->image('logo_inmosystem.png',array('width'=>'40%'));
        }else{
            echo $this->Html->image($this->Session->read('CuentaUsuario.Cuenta.logo'),array('width'=>'40%'));
        }
        ?>
        
            <table>
                <tr>
                    <td style=" width: 40%"><?= $this->Html->image($inmueble['FotoInmueble'][0]['ruta'],array('width'=>'100%'))?></td>
                    <td style=" width: 60%; padding-left: 10%;">
                        <h3>Referencia: <?php echo $inmueble['Inmueble']['referencia']?></h3><br>
                        <h3>Datos de propiedad</h3><br>
                        <b>Ubicación:</b> <?php echo $inmueble['Inmueble']['calle']." ".$inmueble['Inmueble']['numero_exterior']."-".$inmueble['Inmueble']['numero_interior']." ".$inmueble['Inmueble']['colonia']?><br>
                        <b>Precio:</b> <?php echo " $".number_format($inmueble['Inmueble']['precio'],2)?><br>
                        <b>Precio 2:</b> <?php echo " $".number_format($inmueble['Inmueble']['precio_2'],2)?><br>
                        <b>Tipo de propiedad:</b> <?php echo $inmueble['TipoPropiedad']['tipo_propiedad']?><br>
                        <b>Renta / Venta</b> <?php echo $inmueble['Inmueble']['venta_renta']?><br>
                        <h3>Más Información:</h3>
                        <b>Asesor:</b>&nbsp;<?= $this->Session->read('Auth.User.nombre_completo')?><br>
                        <b>Teléfono:</b>&nbsp;<?= $this->Session->read('Auth.User.telefono1')?><br>
                        <b>E-mail:</b>&nbsp;<?= $this->Session->read('Auth.User.correo_electronico')?><br>
                        <b>Sitio web:&nbsp;</b> <?= $inmueble['Cuenta']['pagina_web'] ?><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-top: 5%;">
                        <div class="box-header with-border" style="background-color:#f39c12; color:white">
                                <h3 class="box-title">DESCRIPCIÓN</h3>
                              </div>
                        <?php echo $inmueble['Inmueble']['comentarios'];?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                              <th colspan="10" class="titulo">
                              <div class="box-header with-border" style="background-color:#f39c12; color:white">
                                <h3 class="box-title">Detalles de la propiedad</h3>
                              </div>
                              </th>
                               <?php $boolean = array(1=>'Si',2=>'No')?>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                              <td><b>Edad</b></td>
                              <td><?php echo $inmueble['Inmueble']['edad']?></td>
                              <td><b>Superficie de terreno (m2)</b></td>
                              <td><?php echo $inmueble['Inmueble']['terreno']?></td>
                              <td><b>Superficie construida (m2)</b></td>
                              <td><?php echo $inmueble['Inmueble']['construccion']?></td>
                              <td><b>Frente (m2) x Fondo (m2)</b></td>
                              <td><?php echo $inmueble['Inmueble']['frente_fondo']?></td>

                            </tr>

                            <tr>
                              <td><b>Si es depto en qué nivel se encuentra</b></td>
                              <td><?php echo $inmueble['Inmueble']['niveles_totales']?></td>
                              <td><b>Niveles de la Propiedad</b></td>
                              <td><?php echo $inmueble['Inmueble']['nivel_propiedad']?></td>
                              <td><b>Unidades Totales (Depto / Condominio)</b></td>
                              <td><?php echo $inmueble['Inmueble']['unidades_totales']?></td>
                              <td><b>Estado en que se entrega</b></td>
                              <td><?php echo $inmueble['Inmueble']['estado']?></td>
                            </tr>
                            <tr>
                              <td><b>Recamaras (cuantas)</b></td>
                              <td><?php echo $inmueble['Inmueble']['recamaras']?></td>
                              <td><b>Baños (cuantos)</b></td>
                              <td><?php echo $inmueble['Inmueble']['banos']?></td>
                              <td><b>Estacionamientos Techados (cuantos)</b></td>
                              <td><?php echo $inmueble['Inmueble']['estacionamiento_techado']?></td>
                              <td><b>Estacionamientos Descubiertos (cuantos)</b></td>
                              <td><?php echo $inmueble['Inmueble']['estacionamiento_descubierto']?></td>
                            </tr>
                            <tr>
                              <td><b>Cuarto / Baño de Servicio</b></td>
                              <td><?php echo $boolean[$inmueble['Inmueble']['cuarto_servicio']]?></td>
                              <td><b>Balcon/Terraza</b></td>
                              <td><?php echo $boolean[$inmueble['Inmueble']['balcon']]?></td>
                              <td><b>Vestidores</b></td>
                              <td><?php echo $inmueble['Inmueble']['vestidores']?></td>
                              <td><b>Jardín Privado (M2)</b></td>
                              <td><?php echo $inmueble['Inmueble']['jardin_privado']?></td>

                            </tr>
                            <tr>
                              <td><b>Jardin Común (M2)</b></td>
                              <td><?php echo $boolean[$inmueble['Inmueble']['cuarto_servicio']]?></td>
                              <td><b>Cisterna (litros)</b></td>
                              <td><?php echo $boolean[$inmueble['Inmueble']['balcon']]?></td>

                            </tr>
                            </tbody>
                          </table>
                    </td>
                </tr>
            </table>
     
      <br>
      
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <!-- Table row -->
      <div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Amenidades</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	<div class="row">
                   		<?php echo ($inmueble['Inmueble']['aire_acondicionado']==1 ? '<div class="col-xs-3"> Aire Acondicionado</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['alberca']==1 ? '<div class="col-xs-3"> Alberca</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['area_juegos']==1 ? '<div class="col-xs-3">Área de Juegos</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['areas_verdes']==1 ? '<div class="col-xs-3">Áreas verdes</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['asador']==1 ? '<div class="col-xs-3">Asador</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['bodega']==1 ? '<div class="col-xs-3">Bodega</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['calefaccion']==1 ? '<div class="col-xs-3">Calefacción</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['cancha_tenis']==1 ? '<div class="col-xs-3">Cancha de tenis</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['cantina_cava']==1 ? '<div class="col-xs-3">Cantina / Cava</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['closet_blancos']==1 ? '<div class="col-xs-3">Closet de Blancos</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['cocina_integral']==1 ? '<div class="col-xs-3">Cocina Integral</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['desayunador_antecomedor']==1 ? '<div class="col-xs-3">Desaryunador / Antecomedor</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['edificio_inteligente']==1 ? '<div class="col-xs-3">Edificio Inteligente</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['edificio_leed']==1 ? '<div class="col-xs-3">Edificio LEED</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['elevador']==1 ? '<div class="col-xs-3">Elevador</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['estudio']==1 ? '<div class="col-xs-3">Estudio</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['gimnasio']==1 ? '<div class="col-xs-3">Gimnasio</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['jacuzzi']==1 ? '<div class="col-xs-3">Jacuzzi</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['lavavajillas']==1 ? '<div class="col-xs-3">Lavavajillas</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['patio_servicio']==1 ? '<div class="col-xs-3">Patio de Servicio</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['pista_jogging']==1 ? '<div class="col-xs-3">Pista de Jogging</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['sala_tv']==1 ? '<div class="col-xs-3">Sala de TV</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['salon_juegos']==1 ? '<div class="col-xs-3">Salón de juegos</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['salon_multiple']==1 ? '<div class="col-xs-3">Salón de usos múltiples</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['sauna']==1 ? '<div class="col-xs-3">Sauna</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['sistema_seguridad']==1 ? '<div class="col-xs-3">Sistema de Seguridad</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['tina_hidromasaje']==1 ? '<div class="col-xs-3">Tina de Hidromasaje</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['valet_parking']==1 ? '<div class="col-xs-3">Valet Parking</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['vapor']==1 ? '<div class="col-xs-3">Vapor</div>': "")?>
                   		<?php echo ($inmueble['Inmueble']['vigilancia']==1 ? '<div class="col-xs-3">Vigilancia</div>': "")?>
                   		
                  	</div>
                   	
                    
                
                  
                  
              </div><!-- /.box -->
      <!-- /.row -->

      
      <div class="row">
        <!-- accepted payments column -->
        <!--Mapa de Google  -->
        <div class="col-xs-12">
          <p class="lead">Mapa:</p>
                <div id="map_wrapper">
                    <div id="map_canvas" class="mapping"></div>
                </div>
	     </div>
	     
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
