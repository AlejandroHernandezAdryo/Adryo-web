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
        '<h3>London Eye</h3>' +
        '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>']
        
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
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <?php echo $this->Html->image('logo.png',array('width'=>'15%'))?>
            <small class="pull-right">Fecha: <?php echo date("d-M-y")?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
       <div class="row invoice-info">
       
       <?php foreach ($inmueble['FotoInmueble'] as $imagen):?>
      	<div class="col-sm-2 invoice-col">
          <?php echo $this->Html->image($imagen['ruta'],array('width'=>'100%'))?>
          
        </div>
        <?php endforeach;?>
        </div>
       
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <h3>Datos de propiedad</h3>
          <address>
            <strong><?php echo $inmueble['Inmueble']['referencia']?></strong><br>
            <?php echo $inmueble['Inmueble']['calle']." ".$inmueble['Inmueble']['numero_exterior']."-".$inmueble['Inmueble']['numero_interior']." ".$inmueble['Inmueble']['colonia']?><br>
            <?php echo $inmueble['Inmueble']['ciudad']." ".$inmueble['Inmueble']['estado_ubicacion']." CP: ".$inmueble['Inmueble']['cp']?><br>
            <b>Precio:</b> <?php echo " $".number_format($inmueble['Inmueble']['precio'],2)?><br>
            <b>Tipo de propiedad:</b> <?php echo $inmueble['Inmueble']['tipo_propiedad']?><br>
            <b>Renta / Venta</b> <?php echo $inmueble['Inmueble']['venta_renta']?><br>
            <b>Exclusiva:</b> <?php echo $inmueble['Inmueble']['exclusiva']?><br>
            <b>Comisión:</b> <?php echo $inmueble['Inmueble']['comision']?>%<br>
            <?php $liberada=array(0=>'No',1=>'Si')?>
            <b>Liberada:</b> <?php echo $liberada[$inmueble['Inmueble']['liberada']]?><br>
            <?php echo $inmueble['Inmueble']['google_maps']?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <h3>Datos Cliente</h3>
          <address>
            <strong><?php echo $inmueble['Inmueble']['nombre_cliente']." ".$inmueble['Inmueble']['apellido_paterno']." ".$inmueble['Inmueble']['apellido_materno']?></strong><br>
            <?php echo $inmueble['Inmueble']['direccion_cliente']?><br>
            <?php echo $inmueble['Inmueble']['telefono1']?><br>
            <?php echo $inmueble['Inmueble']['correo_electronico']?><br>
            <b>Tipo de cita:</b><?php echo $inmueble['Inmueble']['cita']?><br>
            <?php echo ($inmueble['Inmueble']['contrato']!="" ? $this->Html->link('Contrato de Exclusividad',$inmueble['Inmueble']['contrato'],array('escape'=>false)): "")?><br>
            <?php echo ($inmueble['Inmueble']['escrituras']!="" ?$this->Html->link('Copia de escrituras',$inmueble['Inmueble']['escrituras'])."<br>" : "")?>
            <?php echo ($inmueble['Inmueble']['identificacion_oficial']!="" ?$this->Html->link('Identificación oficial',$inmueble['Inmueble']['identificacion_oficial'])."<br>" : "")?>
            <?php echo ($inmueble['Inmueble']['predial']!="" ?$this->Html->link('Copia de pago de predial',$inmueble['Inmueble']['predial'])."<br>" : "")?>
            <?php echo ($inmueble['Inmueble']['luz_agua']!="" ?$this->Html->link('Recibo de luz y/o agua potable',$inmueble['Inmueble']['luz_agua'])."<br>" : "")?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <h3>Datos Opcionador</h3>
          <address>
          <b>Opcionador: </b> <?php echo $inmueble['Opcionador']['nombre']?><br>
          <b>Teléfono: </b> <?php echo $inmueble['Opcionador']['telefono']?><br>
          <b>E-mail: </b> <?php echo $inmueble['Opcionador']['correo_electronico']?><br>
          <b>Sitio web: </b> bosinmobiliaria.com<br>
         </address>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      
      <!-- Table row -->
      <div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Orden de imágenes</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	<div class="row">
                            
                            <table>
                                <tr>
                                    <th style="width:34%">Imagen</th>
                                    <th style="width:33%">Descripción</th>
                                    <th style="width:33%">Orden</th>
                                </tr>
                   	<?php 
                            echo $this->Form->create('Inmueble');
                            $contador = 1;
                            foreach ($inmueble['FotoInmueble'] as $foto):
                        ?>
                                <tr>
                                    <td style="width:34%"><?php echo $this->Html->image($foto['ruta'],array('width'=>'50%'))?></td>
                                    <td style="width:33%"><?php echo $this->Form->input('descripcion'.$contador,array('label'=>false,'type'=>'textarea'))?></td>
                                    <td style="width:33%"><?php echo $this->Form->input('orden'.$contador, array('label'=>false))?></td>
                                    <?php echo $this->Form->input('id'.$contador,array('type'=>'hidden','value'=>$foto['id']))?>
                                </tr>
                        <?php
                            $contador++;
                            endforeach;
                            echo $this->Form->input('contador',array('type'=>'hidden','value'=>$contador));
                        ?>
                            </table>
                         <?php echo $this->Form->button('Guardar Imágenes',array('type'=>'submit','class'=>'btn btn-primary'))?>
                  	</div>
                   	
                    
                
                  
                  
              </div><!-- /.box -->
      <!-- /.row -->

      
      
      <!-- /.row -->
      
    </section>
