<section class="content-header">
          <h1>
           Aportación
            <small>Ficha de Aportación</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Aportaciones y Retiros</a></li>
            <li class="active">Registrar Aportación</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Registrar Aportación</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
                  <div class="box-body">
                   	
                    <div class="row">
                        
                        <?php echo $this->Form->create('Aportacion'); ?>
                    	<?php
                                echo $this->Form->input('cliente_id',array('div' => 'col-xs-4','class'=>'form-control','empty'=>'Seleccionar Cliente'));
                                echo $this->Form->input('fecha_aportacion',array('div' => 'col-xs-4','class'=>'form-control','type'=>'hidden','value'=>date("Y-m-d H:i:s")));
                                echo $this->Form->input('monto_aportacion',array('div' => 'col-xs-4','class'=>'form-control','type'=>'money'));
                                echo $this->Form->input('cuenta_id',array('div' => 'col-xs-4','class'=>'form-control','empty'=>'Seleccionar Cuenta','label'=>'Cuenta destino'));
                                echo $this->Form->input('aplicada',array('div' => 'col-xs-4','class'=>'form-control','type'=>'hidden','value'=>2));
                                echo $this->Form->input('tipo_transaccion',array('div' => 'col-xs-4','class'=>'form-control','type'=>'hidden','value'=>2));
                                echo $this->Form->input('referencia',array('div' => 'col-xs-4','class'=>'form-control','type'=>'text'));
                                $opciones = array('Transferencia Electrónica'=>'Transferencia Electrónica','Efectivo'=>'Efectivo','Cheque'=>'Cheque');
                                echo $this->Form->input('forma_aportacion',array('div' => 'col-xs-4','class'=>'form-control','empty'=>'Seleccionar Forma de Aportación','type'=>'select','options'=>$opciones));
                        ?>
                    </div>
                    
              </div><!-- /.box -->
			<div class="box-footer">
                    <?php echo $this->Form->button('Registrar Aportación',array('type'=>'submit','class'=>'btn btn-primary'))?>
                	<?php echo $this->Form->end()?>    
            </div>
              

              

              
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>

<div class="aportacions form">
<?php echo $this->Form->create('Aportacion'); ?>
	<fieldset>
		<legend><?php echo __('Add Aportacion'); ?></legend>
	<?php
		echo $this->Form->input('cliente_id');
		echo $this->Form->input('fecha_aportacion');
		echo $this->Form->input('monto_aportacion');
		echo $this->Form->input('cuenta_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Aportacions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cuentas'), array('controller' => 'cuentas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cuenta'), array('controller' => 'cuentas', 'action' => 'add')); ?> </li>
	</ul>
</div>

