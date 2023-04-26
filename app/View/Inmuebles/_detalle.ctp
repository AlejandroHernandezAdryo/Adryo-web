<?php
    $descripcion_sf = strip_tags($inmueble['Inmueble']['comentarios']);

    echo $this->Html->meta('description',$descripcion_sf, array("inline" => false));
    $this->assign('title',$inmueble['Inmueble']['titulo']);
    echo $this->Html->meta('keywords','agente inmobiliario, trabajo inmobiliaria, oferta de propiedades, comercialización inmobiliaria, asesoria inmobiliaria, consultoría inmobiliaria, comercialización de imbuebles, oferta de inmuebles', array("inline" => false));
    $this->assign('author','<meta name="author" content="'.$inmueble['Cuenta']['nombre_comercial'].'">');
    //Facebook META
    $this->assign('og:url','<meta property="og:url" content="'.Router::url('/', true).'inmuebles/detalle/'.$inmueble['Inmueble']['id'].'" />');
    $this->assign('og:image','<meta property="og:image" content="https://adryo.com.mx'.$inmueble['FotoInmueble'][0]['ruta'].'"/>');
    $this->assign('og:image:width','1280px');
    $this->assign('og:image:height','1100px');
    $this->assign('og:description','<meta property="og:description" content="'.$descripcion_sf.'"/>');
    $this->assign('og:title','<meta property="og:title" content="'.$inmueble['Inmueble']['titulo'].'"/>');
    $this->assign('og:type','<meta property="og:type" content="website"');
    //Google META
    $this->assign('google_name','<meta itemprop="name" content="'.$inmueble['Cuenta']['nombre_comercial'].'">');
    $this->assign('google_description','<meta itemprop="description" content="'.$descripcion_sf.'"');
    $this->assign('google_image','<meta itemprop="image" content="https://adryo.com.mx'.$inmueble['FotoInmueble'][0]['ruta'].'"/>');
?>
<style>
body {
  font-family: Verdana, sans-serif;
  margin: 0;
}

* {
  box-sizing: border-box;
}

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #000;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

</style>
<body class=" bootstrap bd-body-1 
 bd-homepage bd-pagebackground-3  bd-margins">
    
    <div id="myModal" class="modal">
    <span class="close cursor" onclick="closeModal()"><font style="color:white">&times;</font></span>
  <div class="modal-content">
   <?php 
    $i = 1;
    foreach($inmueble['FotoInmueble'] as $foto):?>  
    <div class="mySlides" style="height:90vh;text-align:center">
        
        <div class="numbertext">
          <b style="color:white; background: black;"><?= $foto['descripcion']?></b>
        </div>
        
        <img src="<?= Router::url('/', true).$foto['ruta']?>" style="height:80vh; width: auto;">
    </div>
    <?php endforeach;?>  
    
    <!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a> -->

    <a class="prev" onclick="plusSlides(-1)" style="background: #000;color: white;" >&#10094;</a>
    <a class="next" onclick="plusSlides(1)" style="background: #000;color: white;">&#10095;</a>

    <div class="caption-container">
        <p id="caption">
          
        </p>
    </div>
  </div>
</div>
    
    <div id="youtube" class="modal">
    <span class="close cursor" onclick="closeYoutube()"><font style="color:white">&times;</font></span>
  <div class="modal-content">
   
   <iframe width="958" height="539" src="https://www.youtube.com/embed/<?= explode("=",$inmueble['Inmueble']['youtube'])[1]?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
  </div>
</div>    

<script>
function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function openYoutube() {
  document.getElementById('youtube').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

function closeYoutube() {
  document.getElementById('youtube').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>
    
    <div class=" bd-content-13">
    
    <div class=" bd-htmlcontent-1 bd-margins" 
 data-page-id="page.0">
    <section class=" bd-section-7 bd-tagstyles" id="section7" data-section-title="Section">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-6 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row ">
                <div class=" bd-columnwrapper-16 
 col-lg-4
 col-sm-4">
    <div class="bd-layoutcolumn-16 bd-column" ><div class="bd-vertical-align-wrapper"><img class="bd-imagelink-1 bd-own-margins bd-imagestyles" src="<?= Router::url('/', true).$inmueble['Cuenta']['logo']?>" style="height: 100px;width: auto;"></div></div>
</div>
	<?php if ($agente['User']['nombre_completo']!=""){?>
		<div class=" bd-columnwrapper-18 
 col-lg-7
 col-sm-4
 col-xs-6">
    <div class="bd-layoutcolumn-18 bd-column" ><div class="bd-vertical-align-wrapper"><h2 class=" bd-textblock-2 bd-content-element">
    <b><?= $agente['User']['nombre_completo']?></b>&nbsp;
    <br><?= $agente['User']['correo_electronico']?>
    <br><?= $agente['User']['telefono1']?>
    <?= ($agente['User']['telefono2']!=""?"<br>".$agente['User']['telefono2'] : "")?>
</h2></div></div>
</div>
	
		<div class=" bd-columnwrapper-17 
 col-lg-1
 col-sm-4
 col-xs-6">
                    
    <div class="bd-layoutcolumn-17 bd-column" ><div class="bd-vertical-align-wrapper"><img class="bd-imagelink-12 bd-own-margins bd-imagestyles   "  src="<?= $agente['User']['foto']=="user_no_photo.png" || $agente['User']['foto']=="" ? "/img/user_no_photo.png" : Router::url('/', true).$agente['User']['foto']?>"></div></div>
</div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
	
		<section class=" bd-section-13 bd-tagstyles" id="section13" data-section-title="Section">
    <div class="bd-container-inner bd-margins clearfix">
        <div style="width:100%;height:75vh;background-image: url('<?= Router::url('/', true).$inmueble['FotoInmueble'][0]['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" >
            
        </div>
        
	
		<div class=" bd-layoutcontainer-8 bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row 
 bd-row-flex 
 bd-row-align-top">
                <div class=" bd-columnwrapper-25 
                     col-sm-9" style="margin-top:15px">
    <div class="bd-layoutcolumn-25 bd-column" ><div class="bd-vertical-align-wrapper"><p class=" bd-textblock-17 bd-content-element">
    <?= $inmueble['Inmueble']['titulo']."/ REF:".$inmueble['Inmueble']['referencia']?>
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-26 
 col-sm-3" style="margin-top:15px">
    <div class="bd-layoutcolumn-26 bd-column" ><div class="bd-vertical-align-wrapper"><p class=" bd-textblock-19 bd-content-element">
    <?php 
        if ($inmueble['Inmueble']['venta_renta']=="Venta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
            echo "Precio Venta: $".number_format($inmueble['Inmueble']['precio'],2)."<br>";
        }
        if ($inmueble['Inmueble']['venta_renta']=="Renta" || $inmueble['Inmueble']['venta_renta']=="Venta / Renta"){
            echo "Precio Renta: $".number_format($inmueble['Inmueble']['precio_2'],2);
        }
    ?>
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-62 
 col-sm-8">
                    <div class="bd-layoutcolumn-62 bd-column" ><div class="bd-vertical-align-wrapper" style="color: black;">
             <div class="col-sm-12">
            <h6 class="text-black"><b>Descripción</b></h6>
             <?php echo $inmueble['Inmueble']['comentarios'];?>  
        </div>
            <div class="col-sm-12">
            <h6 class="text-black"><b>Detalle</b></h6>
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
            <?php if ($inmueble['Inmueble']['terreno']!=""){?>
                <div class="col-lg-4">
                    <?= "Superficie de Terreno: ".number_format($inmueble['Inmueble']['terreno'])."m<sup>2</sup>"?>
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

        </div>
        <div class="col-sm-12 m-t-20">
            <h6 class="text-black"><b>Lugares de interes</b></h6>
            <?php echo ($inmueble['Inmueble']['cc_cercanos']            == 1 ? '<div class="col-lg-4">Centros Comerciales Cercanos</div>' : "") ?>
            <?php echo ($inmueble['Inmueble']['escuelas']               == 1 ? '<div class="col-lg-4">Escuelas</div>' : "") ?>
            <?php echo ($inmueble['Inmueble']['frente_parque']          == 1 ? '<div class="col-lg-4">Frente a Parque</div>' : "") ?>
            <?php echo ($inmueble['Inmueble']['parque_cercano']         == 1 ? '<div class="col-lg-4">Parques Cercanos</div>' : "") ?>
            <?php echo ($inmueble['Inmueble']['plazas_comerciales']     == 1 ? '<div class="col-lg-4">Plazas Comerciales</div>' : "") ?>
        </div>

        <div class="col-sm-12 m-t-20">
            <h6 class="text-black"><b>Amenidades</b></h6>
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
            <?php echo ($inmueble['Inmueble']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna - '.$inmueble['Inmueble']['m_cisterna'].' Lts </div>' : "") ?>
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
     </div>
        <div class="col-sm-12 m-t-20">
            <h6 class="text-black"><b>Servicios</b></h6>
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
        </div>
        
                                                
</div></div>
</div>
	
		<div class=" bd-columnwrapper-63 
 col-sm-4">
    <div class="bd-layoutcolumn-63 bd-column" ><div class="bd-vertical-align-wrapper"><div class="bd-googlemap-3 bd-own-margins bd-imagestyles ">
                
                <font color="black" style="font-size: 1.3em;">
                <div class="col-lg-3 col-xs-3 "style="text-align:center;">
                    <?= $this->Html->image('m2.png',array('width'=>'60%'))?>
                    <p><b><?= $inmueble['Inmueble']['construccion']+$inmueble['Inmueble']['construccion_no_habitable']?>m<sup>2</sup></b></p>
                </div>
                <div class="col-lg-3 col-xs-3"  style="text-align:center;">
                    <?= $this->Html->image('recamaras.png',array('width'=>'60%'))?>
                    <p><b><?= $inmueble['Inmueble']['recamaras']?></b></p>
                </div>
                <div class="col-lg-3 col-xs-3"  style="text-align:center;">
                    <?= $this->Html->image('banios.png',array('width'=>'60%'))?>
                    <p><b><?= $inmueble['Inmueble']['banos']?><?= ($inmueble['Inmueble']['medio_banos']==0||$inmueble['Inmueble']['medio_banos']==""?"":" y ".$inmueble['Inmueble']['medio_banos']." medios baños")?></b></p>
                </div>
                <div class="col-lg-3 col-xs-3" style="text-align:center;">
                    <?= $this->Html->image('autos.png',array('width'=>'60%'))?>
                    <p><b><?= $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?></b></p>
                </div>
                </font>
                <div class="col-sm-12" style="margin-top:20px; margin-bottom: 20px">
                    <div class="row ">
                        <div class=" bd-columnwrapper-35 col-lg-3 col-xs-3">
                            <h6 style="color:black;margin-left:10px; font-size: 12px"><b>Galería</b><?= " (".sizeof($inmueble['FotoInmueble']).")"?></h6>
                            <div class="bd-layoutcolumn-35 bd-column" >
                                <div class="bd-vertical-align-wrapper" onclick="openModal();currentSlide(1)" class="hover-shadow cursor" style="height:100px;background-image: url('<?= Router::url('/', true).$inmueble['FotoInmueble'][0]['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" >
                                </div>
                            </div>
                        </div>
                        <div class=" bd-columnwrapper-35 col-lg-3 col-xs-3">
                            <?php 
                                if($inmueble['Inmueble']['youtube']!=""){
                                    $link = "openYoutube()";
                            ?>
                            <h6 style="color:black;margin-left:10px;font-size: 12px"><b>Video</b></h6>
                            <div class="bd-layoutcolumn-35 bd-column" >
                                <div class="bd-vertical-align-wrapper" style="height:100px;background-image: url('/img/video.png'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?= $inmueble['Inmueble']['youtube'] ?>')">
                                </div>
                            </div>
                                <?php } ?>
                        </div>
                            <?php 
                                if($inmueble['Inmueble']['brochure']!=""){
                                    $link = $inmueble['Inmueble']['brochure'];
                                ?>
                            <div class=" bd-columnwrapper-35 col-lg-3 col-xs-3">
                                <h6 style="color:black;margin-left:10px;font-size: 12px"><b>Ver Brochure</b></h6>
                                <div class="bd-layoutcolumn-35 bd-column" >
                                    <div class="bd-vertical-align-wrapper" style="height:100px;background-image: url('<?= Router::url('/', true) ?>/img/brochure.png'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?= Router::url('/', true).$link?>')">
                                    </div>
                                </div>
                            </div>

                            <?php if ($inmueble['Inmueble']['matterport'] != ''): ?>
                              <div class=" bd-columnwrapper-35 col-lg-3 col-xs-3">
                                <h6 style="color:black;margin-left:10px;font-size: 12px"><b>Matterport</b></h6>
                                <div class="bd-layoutcolumn-35 bd-column" >
                                    <div class="bd-vertical-align-wrapper" style="height:100px; background-image: url('<?= Router::url('/', true) ?>/img/matterport_logo.png'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;"  onclick="window.open('<?= $inmueble['Inmueble']['matterport']?>')">
                                    </div>
                                </div>
                              </div>
                            <?php endif ?>



                                <?php }?>
                    </div>
                    <div class="row" style="margin-top:2%;margin-bottom:2%">       
                <div class="col-lg-12">
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
                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0&callback=initMap">
                                    </script>
                                     <?php }else{
                                         echo ("Sin coordenadas");
                                     }
                                     ?>
                </div>
                        </div>
    
</div></div></div>
</div>
                
                
               
            </div>
        </div>
    </div>
</div>
	
    </div>
</section>
        
</div>
</div>
        <div class=" bd-content-13">         
<section class=" bd-section-15 bd-page-width bd-tagstyles " id="section4" data-section-title="Three Columns" style="margin-top: 10%">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-22 bd-page-width  bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row 
 bd-row-flex 
 bd-row-align-top">
                <div class=" bd-columnwrapper-79 
 col-md-6">
    <div class="bd-layoutcolumn-79 bd-column" ><div class="bd-vertical-align-wrapper"><p class=" bd-textblock-35 bd-no-margins bd-content-element">
    <?= $inmueble['Cuenta']['direccion']?>
</p></div></div>
</div>
	
		<div class=" bd-columnwrapper-81 
 col-md-6">
    <div class="bd-layoutcolumn-81 bd-column" ><div class="bd-vertical-align-wrapper"><p class=" bd-textblock-37 bd-no-margins bd-content-element">
    <?= ($inmueble['Cuenta']['correo_contacto']!="" ? $inmueble['Cuenta']['correo_contacto']."<br>" : "")?>
    <?= ($inmueble['Cuenta']['telefono_1']!="" ? $inmueble['Cuenta']['telefono_1']."<br>" : "")?>
    <?= ($inmueble['Cuenta']['telefono_2']!="" ? $inmueble['Cuenta']['telefono_2']."<br>" : "")?>
    <?= ($inmueble['Cuenta']['pagina_web']!="" ? $inmueble['Cuenta']['pagina_web']."<br>" : "")?>
</p></div></div>
</div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
    </div>		
		
</body>