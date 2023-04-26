<section class="content-header">
          <h1>
           Propiedades
            <small>Mis Propiedades</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Mis Propiedades</a></li>
            
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <?php 
                if (isset($propiedades)){
                foreach ($propiedades as $propiedad):?>
            <div class="col-md-3">
            	<div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->Html->link(substr($propiedad['referencia'],0,15), array('controller'=>'inmuebles','action'=>'detail_client',$propiedad['id']),array('target'=>'_blank'))?></h3>

              
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block; text-align: center;">
              <?php echo $this->Html->link(
                      $this->Html->image(
                              $propiedad['FotoInmueble'][0]['ruta'],
                              array('style'=>'height: 150px; max-height: 150px;max-width: 100% !important;')),
                              array('controller'=>'inmuebles','action'=>'view',$propiedad['id']),array('escape'=>false,'target'=>'_blank'));?>
              
            </div>
            <!-- /.box-body -->
          </div>
            
            </div>
            <?php 
            	endforeach;
                }
            ?>
            <?php 
                if (isset($desarrollos)){
                foreach ($desarrollos as $desarrollo):?>
            <div class="col-md-3">
            	<div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h4 class="box-title"><?php echo $this->Html->link(substr($desarrollo['nombre'],0,15), array('controller'=>'desarrollos','action'=>'detail_client',$desarrollo['id']),array('target'=>'_blank'))?></h4>

              
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;text-align: center;">
              <?php echo $this->Html->image($desarrollo['FotoDesarrollo'][0]['ruta'],array('style'=>'height: 150px;  max-height: 150px;max-width: 100% !important;'))?>
              
            </div>
            <!-- /.box-body -->
          </div>
           
            </div>
            <?php 
            	endforeach;
                }
            ?>
            
            
        </div>
        
</section>
          