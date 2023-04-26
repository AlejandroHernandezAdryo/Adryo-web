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
        ['<?php echo $desarrollo['Desarrollo']['nombre'] ?>', <?php echo $desarrollo['Desarrollo']['google_maps']?>]
        
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3><?= $desarrollo['Desarrollo']['nombre']?></h3>' +
        '<p><?= $desarrollo['Desarrollo']['calle']." ".$desarrollo['Desarrollo']['numero_ext']." ".$desarrollo['Desarrollo']['numero_int']." ".$desarrollo['Desarrollo']['colonia']?></p>' +        '</div>']
        
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
            <h1><?php echo $desarrollo['Desarrollo']['nombre']?></h1>
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

              <p>Clientes Interesados</p>
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

              <p>Clientes Potenciales</p>
            </div>
            <div class="icon">
              <i class="fa fa-thumbs-o-up"></i>
            </div>
            
          </div>
        </div>
        <?php 
           }
           
           
        ?>
          
          
        
        <?php endforeach;?>
        
        
        
      </div>
       <!-- START ACCORDION & CAROUSEL-->
      <div class="row">
        <div class="col-md-6">
          <div class="box box-solid">
            
            <!-- /.box-header -->
            <div class="box-body">
                <?= $this->Html->link('<i class="fa fa-plus"></i> Crear Ticket',array('controller'=>'Tickets','action'=>'add_desarrollo',$desarrollo['Desarrollo']['id']),array('escape'=>false))?>  
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-orange">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a class="titulo" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Ubicación
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                            <address>
                              <?php echo $desarrollo['Desarrollo']['calle']." ".$desarrollo['Desarrollo']['numero_ext']." ".$desarrollo['Desarrollo']['numero_int']." ".$desarrollo['Desarrollo']['colonia']?>
                              <?php echo $desarrollo['Desarrollo']['ciudad']." ".$desarrollo['Desarrollo']['estado']." CP: ".$desarrollo['Desarrollo']['cp']?><br>
                              <b>Tipo de desarrollo:</b> <?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?><br>
                              <b>Unidades Totales:</b> <?php echo $desarrollo['Desarrollo']['unidades_totales']?><br>
                              <b>Torres:</b> <?php echo $desarrollo['Desarrollo']['torres']?><br>
                              <b>Departamento Muestra:</b> <?php echo $desarrollo['Desarrollo']['departamento_muestra']?><br>
                            </address>
                    </div>
                  </div>
                </div>
                <div class="panel box box-orange">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a class="titulo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                       Información de entrega
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
                      <address>
                        <b>Disponibilidad:</b> <?php echo $desarrollo['Desarrollo']['disponibilidad']?><br>
                        <b>Fecha de entrega:</b> <?php echo $desarrollo['Desarrollo']['fecha_entrega']?><br>
                        <b>Inicio de preventa:</b> <?php echo $desarrollo['Desarrollo']['inicio_preventa']?><br>
                        <b>Unidades Totales:</b> <?php echo $desarrollo['Desarrollo']['unidades_totales']?><br>
                       </address>
                    </div>
                  </div>
                </div>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box box-solid">
            
             
            <?php 
                $size = sizeof($desarrollo['FotoDesarrollo']);
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
                        foreach ($desarrollo['FotoDesarrollo'] as $imagen):
                  ?>
                  <div class="<?= $class1 = ($j==0 ? 'item active' : 'item')?>">
                    <?php echo $this->Html->image($imagen['ruta'],array('alt'=>$imagen['descripcion']))?>  
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
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- END ACCORDION & CAROUSEL-->
      
      <!-- info row -->
       <div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Descripción</h3>
                </div>
      
      <div class="box-body">
                   	<div class="row">
                   		<?php echo $desarrollo['Desarrollo']['descripcion']?>
                   		
                   		
                   	</div>
                   
                  </div>
      <!-- /.row -->
	
		<div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Amenidades del desarrollo</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	<div class="row">
                   		<?php echo ($desarrollo['Desarrollo']['alberca_sin_techar']==1 ? '<div class="col-xs-3">Alberca descubierta</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['alberca_techada']==1 ? '<div class="col-xs-3">Alberca Techada</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['areas_verdes']==1 ? '<div class="col-xs-3">Áreas Verdes</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['asador']==1 ? '<div class="col-xs-3">Asador</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['business_center']==1 ? '<div class="col-xs-3">Business Center</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['cafeteria']==1 ? '<div class="col-xs-3">Cafetería</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['carril_nado']==1 ? '<div class="col-xs-3">Carril de Nado</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['cctv']==1 ? '<div class="col-xs-3">CCTV</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['elevadores']==1 ? '<div class="col-xs-3">Elevadores</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['estacionamiento_visitas']==1 ? '<div class="col-xs-3">Estacionamiento de visitas</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['fire_pit']==1 ? '<div class="col-xs-3">Gimnasio</div>': "")?>
                                <?php echo ($desarrollo['Desarrollo']['gimnasio']==1 ? '<div class="col-xs-3">Gimnasio</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['interfon']==1 ? '<div class="col-xs-3">Interfón</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['internet']==1 ? '<div class="col-xs-3">Internet</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['jacuzzi']==1 ? '<div class="col-xs-3">Jacuzzi</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['juegos_infantiles']==1 ? '<div class="col-xs-3">Juegos Infantiles</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['lobby']==1 ? '<div class="col-xs-3">Lobby</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['paddle_tennis']==1 ? '<div class="col-xs-3">Cancha de Paddle Tennis</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['pista_jogging']==1 ? '<div class="col-xs-3">Pista de Jogging</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['planta_emergencia']==1 ? '<div class="col-xs-3">Planta de emergencia</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['porton_electrico']==1 ? '<div class="col-xs-3">Porton Eléctrico</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['roof_garden_compartido']==1 ? '<div class="col-xs-3">Roof Garden Compartido</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['sala_cine']==1 ? '<div class="col-xs-3">Sala de Cine</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['salon_juegos']==1 ? '<div class="col-xs-3">Salón de Juegos</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['salon_usos_multiples']==1 ? '<div class="col-xs-3">Salón de usos múltiples</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['sistema_contra_incendios']==1 ? '<div class="col-xs-3">Sistema contra incendios</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['seguridad']==1 ? '<div class="col-xs-3">Seguridad</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['sky_garden']==1 ? '<div class="col-xs-3">Sky Garden</div>': "")?>
                   		<?php echo ($desarrollo['Desarrollo']['spa_vapor']==1 ? '<div class="col-xs-3">Spa / Vapor</div>': "")?>
                   		
                   	</div>
                   
                  </div>		
	
    
      <!-- Table row -->
      <div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Unidades Tipo</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                	<div class="row">
                		<div id="example2_wrapper" class="dataTables_wrapper">
                		<table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
	                    <thead>
	                      <tr role="row">
	                      	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">Referencia</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Título</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Tipo de propiedad</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Venta / Renta</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Precio</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Construcción</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Habitaciones</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Baños</th>
	                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Estacionamientos</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Estado</th>
                                
	                      	</tr>
	                    </thead>
	                    <tbody>
	                	<?php foreach ($tipos as $tipo):?>
	                	<tr>
	                   		<td><?php echo $tipo['Inmueble']['referencia']?></td>
	                   		<td><?php echo $tipo['Inmueble']['titulo']?></td>
	                   		<td><?php echo $tipo['Inmueble']['tipo_propiedad']?></td>
	                   		<td><?php echo $tipo['Inmueble']['venta_renta']?></td>
	                   		<td><?php
                                                
                                                    echo "$".number_format($tipo['Inmueble']['precio'],2);
                                                ?></td>
	                   		<td><?php echo $tipo['Inmueble']['construccion']?>m2</td>
	                   		<td><?php echo $tipo['Inmueble']['recamaras']?></td>
	                   		<td><?php echo $tipo['Inmueble']['banos']?></td>
	                   		<td><?php echo $tipo['Inmueble']['estacionamiento_techado']+$tipo['Inmueble']['estacionamiento_descubierto']?></td>
                                        <?php
                                        switch ($tipo['Inmueble']['liberada']){
                                            case 0: //No liberada
                                                echo "<td style='text-align: center; background-color: #fcee21'>BLOQUEADO</td>";
                                                break;

                                            case 1: // Libre
                                                echo "<td style='text-align: center; background-color: #39b54a'>LIBRE</td>";
                                                break;

                                            case 2:
                                                echo "<td style='text-align: center; background-color: #fbb03b'>RESERVA</td>";
                                                break;

                                            case 3:
                                                echo "<td style='text-align: center; background-color: #29abe2'>CONTRATO</td>";
                                                break;

                                            case 4:
                                                echo "<td style='text-align: center; background-color: #c1272d'>ESCRITURACION</td>";
                                                break;
                                        }

                                        ?>
                                            
	                   	</tr>
	                   	<?php endforeach;?>
	                   	</table>
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
	<div class="col-xs-9">
            <h2>Documentos Anexos</h2>
            <?= $this->Form->create('DocumentosUser', array('url'=>array('action'=>'enviar')))?>
            <table style="width: 100%">
                <tr>
                    <th>Nombre</th>
                    <th>Descargar</th>
                    <?php if ($this->Session->read('Auth.User.group_id')<3){ ?>
                    <th>Visible Asesor</th>
                    <th>Visible Desarrollador</th>
                    <th>Eliminar</th>
                    <?php } ?>
                </tr>
                <?php $opciones = array(0=>'No',1=>'Si')?>
                <?php foreach($desarrollo['DocumentosUser'] as $documento):?>
                <?php if ($documento['asesor']==1){ ?>
                
                    <tr>
                    <td><?= $documento['documento']?></td>
                    <td><?= $this->Html->link('<i class="fa fa-download"></i>',$documento['ruta'],array('escape'=>false))?></td>
                    <?php if ($this->Session->read('Auth.User.group_id')<3){ ?>
                    <td><?php $opciones[$documento['asesor']]?></td>
                    <td><?= $opciones[$documento['desarrollador']]?></td>
                    <td><?= $this->Form->postLink('<i class="fa fa-trash"></i>', array('action' => 'delete', 'controller'=>'DocumentosUsers',$documento['id']), array('escape'=>false), __('Desea eliminar este documento?', $documento['id'])); ?></td>
                    <?php } ?>
                </tr>
                <?php }
                
                    ?>
                <?php endforeach;?>
            </table>
            
        </div>   
        <!-- /.col -->
        
        <!-- /.col -->
        
        
      </div>
      
      
        <!-- /.col -->
          </section>