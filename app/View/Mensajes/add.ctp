<section class="content-header">
          <h1>
           Mensajes
            <small>Crear Mensaje</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Mensajes</a></li>
            <li class="active">Crear nuevo mensaje</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <?php echo $this->Form->create('Mensaje')?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registro de Nuevo Mensaje</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                        <?php 
                            
                            echo $this->Form->input('inmueble_id', array('div' => 'col-xs-3','class'=>'form-control','empty'=>'Seleccionar Propiedad'));
                            echo $this->Form->input('desarrollo_id', array('div' => 'col-xs-3','class'=>'form-control','empty'=>'Seleccionar Desarrollo'));
                            
                        ?>
                            <div class="col-xs-3">
                                <label for="InmuebleFecha">Fecha de vigencia de anuncio</label>
                                <?php echo $this->Form->date('expiration_date', array('class'=>'form-control','style'=>'width:100%'))?>
                            </div>
                        <?php
                            echo $this->Form->input('mensaje', array('div' => 'col-xs-12','class'=>'form-control','type'=>'textarea'));
                            echo $this->Form->hidden('created_by',array('value'=>$this->Session->read('Auth.User.id')));
                        ?>
                    	
                    </div>
                    
                    
              </div><!-- /.box -->
			<div class="box-footer">
                    <?php echo $this->Form->button('Registrar Mensaje',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
            </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>
