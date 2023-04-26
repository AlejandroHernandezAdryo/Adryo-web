<section class="content-header">
          <h1>
           Propiedades
            <small>Archivos</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Propiedades</a></li>
            <li class="active">Archivos</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                  <div class="box-header with-border" style="background-color:#f39c12; color:white">
                  <h3 class="box-title">Subir Archivo</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->Form->create('Inmueble', array('type'=>'file','url'=>array('action'=>'archivos')))?>
                  <div class="box-body">
                   	<div class="row">
                                <?php echo $this->Form->input('inmueble_id',array('value'=>$id,'type'=>'hidden'))?>
                                <?php echo $this->Form->input('user_id',array('value'=>$this->Session->read('Auth.User.id'),'type'=>'hidden'))?>
                                <?php echo $this->Form->input('documento',array('div' => 'col-xs-6','class'=>'form-control','label'=>'Nombre de Documento'))?>
                                <?php echo $this->Form->input('foto_inmueble',array('type'=>'file','div' => 'col-xs-6','class'=>'form-control','label'=>'Archivo'));?>
                                
                            <br>
                   	</div>
                   	
                 </div>
			<div class="box-footer">
                    <?php echo $this->Form->button('Subir Archivo',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
                  </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>
