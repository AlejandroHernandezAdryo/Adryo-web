<div class="fotoDesarrollos form">
<?php echo $this->Form->create('FotoDesarrollo'); ?>
	<fieldset>
		<legend><?php echo __('Edit Foto Desarrollo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('desarrollo_id');
		echo $this->Form->input('ruta');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('FotoDesarrollo.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('FotoDesarrollo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Foto Desarrollos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
	</ul>
</div>
