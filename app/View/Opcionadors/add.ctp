<section class="content-header">
          <h1>
           Opcionadores
            <small>Ficha de opcionador</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Opcionadores</a></li>
            <li class="active">Crear nuevo opcionador</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <?php echo $this->Form->create('Opcionador')?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de Nuevo Opcionador</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                    	<?php echo $this->Form->input('nombre', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'))?>
                        <?php echo $this->Form->input('correo_electronico', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'))?>
                    	<?php echo $this->Form->input('telefono', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'))?>
                    	
                    </div>
                    
                    
              </div><!-- /.box -->
			<div class="box-footer">
                    <?php echo $this->Form->button('Registrar Opcionador',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
            </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>
