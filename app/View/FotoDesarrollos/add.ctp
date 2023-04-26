<div class="fotoDesarrollos form">
<?php echo $this->Form->create('FotoDesarrollo'); ?>
	<fieldset>
		<legend><?php echo __('Add Foto Desarrollo'); ?></legend>
	<?php
		echo $this->Form->input('desarrollo_id');
		echo $this->Form->input('ruta');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Foto Desarrollos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
	</ul>
</div>
