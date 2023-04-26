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
        '<p><?php echo $inmueble['Inmueble']['calle']." ".$inmueble['Inmueble']['numero_exterior']."-".$inmueble['Inmueble']['numero_interior']." ".$inmueble['Inmueble']['colonia']?></p>' +        '</div>']
        
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
      <div class="row">
        <?php 
        $abiertos = 0;
        $aprobados = 0;
        $cerrados = 0;
        foreach($estadisticas as $estadistica):
           if (isset($estadistica['Abierto'])){
           $abiertos = $estadistica['Abierto'];
        ?>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $abiertos?></h3>

              <p>Clientes evaluando inmueble</p>
            </div>
            <div class="icon">
                <i class="fa fa-binoculars"></i>
            </div>
            
          </div>
        </div>
        <?php 
           }
           if (isset($estadistica['Aprobado'])){
           $aprobados = $estadistica['Aprobado'];
        ?>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $aprobados?></h3>

              <p>Clientes Interesados</p>
            </div>
            <div class="icon">
              <i class="fa fa-thumbs-o-up"></i>
            </div>
            
          </div>
        </div>
        <?php 
           }
           if ($aprobados >0 && $abiertos > 0){
           
        ?>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <?php $class = (($aprobados/$abiertos)<.5 ?"bg-red":(($aprobados/$abiertos)>.5 && ($aprobados/$abiertos)<.7 ? "bg-yellow":"bg-green"))?>
          <div class="small-box <?= $class?>">
            <div class="inner">
                <h3><?= (number_format(($aprobados/$abiertos),4)*100)."%"?></h3>

              <p>Deseabilidad</p>
            </div>
            <div class="icon">
              <i class="fa fa-pie-chart"></i>
            </div>
            
          </div>
        </div>
        <?php 
           }
           if (isset($estadistica['Cerrado'])){
           $cerrados = $estadistica['Cerrado'];
        ?>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
                <h3><?= $cerrados?></h3>

              <p>Clientes no interesados</p>
            </div>
            <div class="icon">
              <i class="fa fa-thumbs-o-down"></i>
            </div>
            
          </div>
        </div>
        <?php 
          }
        ?>
        
        <?php endforeach;?>
          
        
        
      </div>
      <!-- info row -->
      <div class="row">
        <div class="col-md-6">
          <div class="box box-solid">
            
            <!-- /.box-header -->
            <div class="box-body">
                
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-orange">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a class="titulo" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Información del inmueble
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
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
                            <b>Liberada:</b> <?php echo !isset($liberada[$inmueble['Inmueble']['liberada']])? "No Aplica":$liberada[$inmueble['Inmueble']['liberada']]?><br>
                            <b>¿Se puede compartir?:</b> <?php echo $liberada[$inmueble['Inmueble']['compartir']]?><br>
                            <b>Porcentaje a compartir:</b> <?php echo $inmueble['Inmueble']['porcentaje_compartir']?><br>
                          </address>
                    </div>
                  </div>
                </div>
                <?php 
                    if ($inmueble['Opcionador']['id'] == $this->Session->read('Auth.User.id') || $this->Session->read('Auth.User.group_id')!= 3){
                ?>
                <div class="panel box box-orange">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a class="titulo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                       Datos del Cliente
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
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
                  </div>
               </div>
               <?php
                    }
               ?>
                <div class="panel box box-orange">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a class="titulo" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                       Datos del Opcionador
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="box-body">
                      <address>
                        <b>Opcionador: </b> <?php echo $inmueble['Opcionador']['nombre_completo']?><br>
                        <b>Teléfono: </b> <?php echo $inmueble['Opcionador']['telefono1']?><br>
                        <b>E-mail: </b> <?php echo $inmueble['Opcionador']['correo_electronico']?><br>
                        <b>Sitio web: </b> bosinmobiliaria.com<br>
                       </address>
          
                    </div>
                  </div>
                    
                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div> </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box box-solid">
            
             
            <?php 
                $size = sizeof($inmueble['FotoInmueble']);
                //echo var_dump($desarrollo['FotoDesarrollo']);
                //echo "Tamaño arreglo: ".$size;
            ?>
            <!-- /.box-header -->
            <div class="box-body">
                
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <?php for($i=0; $i<$size;$i++){ ?>
                  <li data-target="#carousel-example-generic" data-slide-to="<?= $i?>" class="<?= $class = ($i==0 ? 'active' : '')?>"></li>
                  <?php } ?>
                </ol>
                <div class="carousel-inner">
                  <?php 
                        $j = 0;
                        foreach ($inmueble['FotoInmueble'] as $imagen):
                  ?>
                  <div class="<?= $class1 = ($j==0 ? 'item active' : 'item')?>">
                    <?php echo $this->Html->link($this->Html->image($imagen['ruta'],array('alt'=>$imagen['descripcion'])),$imagen['ruta'],array('escape'=>false,'target'=>'_blank'))?>  
                    <div class="carousel-caption">
                      <?= $imagen['descripcion']?>
                    </div>
                  </div>
                    <?php $j++; endforeach;?>
                    
                    
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
                Imágenes cargadas: <?= sizeof($inmueble['FotoInmueble'])?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div> 
       
      
      <!-- /.row -->
      <div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Comentarios</h3>
                </div><!-- /.box-header -->
                  <div class="box-body">
                   	<div class="row">
                   		<?php echo $inmueble['Inmueble']['comentarios'];?>
                   	</div>
                   	</div>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th colspan="10" class="titulo">Detalles de la propiedad</th>
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
                   		<?php echo ($inmueble['Inmueble']['desayunador_antecomedor']==1 ? '<div class="col-xs-3">Desayunador / Antecomedor</div>': "")?>
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
      <div class="box-body">
      <div class="row">
        <!-- accepted payments column -->
        <!--Mapa de Google  -->
        <div class="col-xs-12">
          <p class="lead">Solicitar Cambios o sugerencias a gerencia</p>
                <?= $this->Form->create('Inmueble', array('url'=>array('action'=>'solicitar_cambios', $inmueble['Inmueble']['id'])))?>
                <?= $this->Form->input('titulo', array('div' => 'col-xs-12','class'=>'form-control','label'=>'Titulo','type'=>'text'))?>
                <?= $this->Form->input('mensaje', array('div' => 'col-xs-12','class'=>'form-control','label'=>'Mensaje','type'=>'textarea'))?>
                
	<div class="box-footer">
                    <?php echo $this->Form->button('Enviar mensaje',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
                  </div>     
        </div>
        
      </div>
	     
        <!-- /.col -->
        
        <!-- /.col -->
        
      </div>
      <!-- /.row -->
      
    </section>
