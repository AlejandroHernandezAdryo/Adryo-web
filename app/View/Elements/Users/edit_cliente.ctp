<section class="content-header">
          <h1>
           Usuarios
            <small>Ficha de Cliente</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Usuario</a></li>
            <li class="active">Crear nuevo Cliente</li>
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
                  <h3 class="box-title">Registro de Nuevo Cliente</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                        <?php
                            echo $this->Form->input('id');
                            echo $this->Form->input('nombre_completo', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'));
                            echo $this->Form->input('correo_electronico', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'));
                            echo $this->Form->input('telefono1', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'));
                            echo $this->Form->input('telefono2', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'));
                            echo $this->Form->input('password', array('div' => 'col-xs-4','class'=>'form-control','type'=>'password'));
                            echo $this->Form->input('group_id', array('div' => 'col-xs-4','class'=>'form-control','type'=>'hidden','value'=>5));
                            
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


