<section class="content-header">
          <h1>
           Tickets
            <small>Agregar Ticket</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Tickets</a></li>
            <li class="active">Crear nuevo Ticket</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <?php echo $this->Form->create('Ticket')?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Ticket para desarrollo <?= $desarrollo['Desarrollo']['nombre']?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                        <?php 
                            echo $this->Form->input('mensaje', array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'));
                            echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
                            echo $this->Form->input('desarrollo_id',array('type'=>'hidden','value'=>$desarrollo['Desarrollo']['id']));
                            echo $this->Form->input('fecha',array('type'=>'hidden','value'=>date('Y-m-d')));
                        ?>
                    	
                    </div>
                    
                    
              </div><!-- /.box -->
			<div class="box-footer">
                    <?php echo $this->Form->button('Registrar Usuario',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
            </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>

