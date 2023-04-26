<div class="agendas view">
<h2><?php echo __('Agenda'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($agenda['Agenda']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($agenda['User']['id'], array('controller' => 'users', 'action' => 'view', $agenda['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lead'); ?></dt>
		<dd>
			<?php echo $this->Html->link($agenda['Lead']['id'], array('controller' => 'leads', 'action' => 'view', $agenda['Lead']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($agenda['Agenda']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mensaje'); ?></dt>
		<dd>
			<?php echo h($agenda['Agenda']['mensaje']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Agenda'), array('action' => 'edit', $agenda['Agenda']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Agenda'), array('action' => 'delete', $agenda['Agenda']['id']), null, __('Are you sure you want to delete # %s?', $agenda['Agenda']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Agendas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Agenda'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Leads'), array('controller' => 'leads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lead'), array('controller' => 'leads', 'action' => 'add')); ?> </li>
	</ul>
</div>
