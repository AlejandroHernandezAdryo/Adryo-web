<div class="agendas form">
<?php echo $this->Form->create('Agenda'); ?>
	<fieldset>
		<legend><?php echo __('Edit Agenda'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('lead_id');
		echo $this->Form->input('fecha');
		echo $this->Form->input('mensaje');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Agenda.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Agenda.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Agendas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Leads'), array('controller' => 'leads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lead'), array('controller' => 'leads', 'action' => 'add')); ?> </li>
	</ul>
</div>
