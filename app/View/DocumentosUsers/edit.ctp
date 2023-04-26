<div class="documentosUsers form">
<?php echo $this->Form->create('DocumentosUser'); ?>
	<fieldset>
		<legend><?php echo __('Edit Documentos User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('documento');
		echo $this->Form->input('ruta');
		echo $this->Form->input('comentarios');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DocumentosUser.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DocumentosUser.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Documentos Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
