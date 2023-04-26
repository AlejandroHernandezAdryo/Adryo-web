<section class="content-header">
          <h1>
           Usuarios
            <small>Agregar Propiedad</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Usuario</a></li>
            <li class="active">Agregar Propiedad</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <?php echo $this->Form->create('User')?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Asignación de nueva Propiedad</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                        <?php 
                            echo $this->Form->input('cliente_id',array('type'=>'hidden','value'=>$cliente['User']['id']));
                            echo $this->Form->input('inmueble_id',array('div' => 'col-xs-4','class'=>'form-control','empty'=>'Ningún Inmueble','label'=>'Asignar a inmueble'));
                            echo $this->Form->input('desarrollo_id',array('div' => 'col-xs-4','class'=>'form-control','empty'=>'Ningún Desarrollo','label'=>'Asignar a desarrollo'));
                        ?>
                    	
                    </div>
                    
                    
              </div><!-- /.box -->
			<div class="box-footer">
                    <?php echo $this->Form->button('Registrar Cliente',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
            </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>


