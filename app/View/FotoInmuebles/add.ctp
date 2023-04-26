<div class="fotoInmuebles form">
<?php echo $this->Form->create('FotoInmueble'); ?>
	<fieldset>
		<legend><?php echo __('Add Foto Inmueble'); ?></legend>
	<?php
		echo $this->Form->input('inmueble_id');
		echo $this->Form->input('ruta');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Foto Inmuebles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Inmuebles'), array('controller' => 'inmuebles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inmueble'), array('controller' => 'inmuebles', 'action' => 'add')); ?> </li>
	</ul>
</div>
