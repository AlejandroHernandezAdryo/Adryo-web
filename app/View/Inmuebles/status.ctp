<section class="content-header">
          <h1>
           Propiedades
            <small>Cambiar Status</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Propiedades</a></li>
            <li class="active">Cambiar Status</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <?php echo $this->Form->create('Inmueble')?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= $inmueble['Inmueble']['titulo']?></h3>
                  <?php 
                                    $status = array (0=>'No Liberada', 1=>'Libre',2=>'Reservado',3=>'Contrato',4=>'Escrituración',5=>'Baja');
                                ?>
                  <p>Cambiar a status: <?= $status[$stat]?></p>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	<div class="row">
                                
                   		<?php echo $this->Form->input('id',array('value'=>$inmueble['Inmueble']['id']))?>
                                <?= $this->Form->hidden('stat',array('value'=>$status[$stat]))?>
                                <?php echo $this->Form->input('mensaje',array('div' => 'col-xs-12','class'=>'form-control','type'=>'textarea'))?>
                            
                            <div class="box-footer">
                    <?php echo $this->Form->button('Cambiar Status',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
                  </div>
                  </div><!-- /.box-body -->
                  </div>
                  
                
                <!-- form start -->
                
                  
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>
