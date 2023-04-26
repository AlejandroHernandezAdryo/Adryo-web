<div class="desarrolloInmuebles form">
<?php echo $this->Form->create('DesarrolloInmueble'); ?>
	<fieldset>
		<legend><?php echo __('Add Desarrollo Inmueble'); ?></legend>
	<?php
		echo $this->Form->input('desarrollo_id');
		echo $this->Form->input('inmueble_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Desarrollo Inmuebles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inmuebles'), array('controller' => 'inmuebles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inmueble'), array('controller' => 'inmuebles', 'action' => 'add')); ?> </li>
	</ul>
</div>
