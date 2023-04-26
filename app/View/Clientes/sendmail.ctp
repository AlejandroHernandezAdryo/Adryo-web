<section class="content-header">
          <h1>
           Clientes
            <small>Mailing</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Clientes</a></li>
            <li class="active">Enviar mailing</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <?php echo $this->Form->create('Cliente')?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Crear Filtro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                        
                        <?php 
                            $viviendas = array();
                            foreach ($tipo_viviendas as $vivienda):
                                array_push($viviendas, $vivienda['Contacto']['tipo_vivienda']);
                            endforeach;
                        ?>
                        <?php echo $this->Form->input('tipo_vivienda', array('div' => 'col-xs-4','class'=>'form-control','type'=>'select','options'=>$viviendas,'multiple'=>'multiple'))?>
                        <?php 
                            $operaciones = array();
                            foreach ($tipo_operaciones as $operacion):
                                array_push($operaciones, $operacion['Contacto']['tipo_operacion']);
                            endforeach;
                        ?>
                        <?php echo $this->Form->input('tipo_operacion', array('div' => 'col-xs-4','class'=>'form-control','type'=>'select','options'=>$operaciones,'multiple'=>'multiple'))?>
                        <?php 
                            $zonas_a = array();
                            foreach ($zonas as $zona):
                                array_push($zonas_a, $zona['Contacto']['zona']);
                            endforeach;
                        ?>
                        <?php echo $this->Form->input('zona', array('div' => 'col-xs-4','class'=>'form-control','type'=>'select','options'=>$zonas_a,'multiple'=>'multiple'))?>
                        <?php echo $this->Form->input('bases', array('div' => 'col-xs-4','class'=>'form-control','type'=>'select','options'=>array('CRM','WEB'),'multiple'=>'multiple'))?>
                        <?php echo $this->Form->input('mensaje', array('div' => 'col-xs-4','class'=>'form-control','type'=>'textarea'))?>
                        <?php echo $this->Form->input('archivos',array('type'=>'file','multiple'=>'multiple','div' => 'col-xs-6','class'=>'form-control','label'=>'Archivos'));?>
                    </div>
                    
              </div><!-- /.box -->
			<div class="box-footer">
                    <?php echo $this->Form->button('Enviar correo',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
            </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>