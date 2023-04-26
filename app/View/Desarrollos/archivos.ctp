<section class="content-header">
          <h1>
           Desarrollos
            <small>Archivos</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Desarrollos</a></li>
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
                <?php echo $this->Form->create('Desarrollo', array('type'=>'file','url'=>array('action'=>'archivos')))?>
                  <div class="box-body">
                   	<div class="row">
                                <?php echo $this->Form->input('desarrollo_id',array('value'=>$id,'type'=>'hidden'))?>
                                <?php echo $this->Form->input('user_id',array('value'=>$this->Session->read('Auth.User.id'),'type'=>'hidden'))?>
                                <?php echo $this->Form->input('documento',array('div' => 'col-xs-6','class'=>'form-control','label'=>'Nombre de Documento'))?>
                                <?php echo $this->Form->input('foto_inmueble',array('type'=>'file','div' => 'col-xs-6','class'=>'form-control','label'=>'Archivo'));?>
                                <?php echo "Visble para el asesor:".$this->Form->checkbox('asesor',array('label'=>'Pueden verlo los asesores'))?>
                                <?php echo "<br>Visble para el desarrollador:".$this->Form->checkbox('desarrollador',array('label'=>'Pueden verlo los desarrolladores'))?>
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
