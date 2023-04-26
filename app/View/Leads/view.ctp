<div class="leads view">
<h2><?php echo __('Lead'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($lead['Lead']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cliente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lead['Cliente']['id'], array('controller' => 'clientes', 'action' => 'view', $lead['Cliente']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inmueble'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lead['Inmueble']['id'], array('controller' => 'inmuebles', 'action' => 'view', $lead['Inmueble']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($lead['Lead']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comentarios'); ?></dt>
		<dd>
			<?php echo h($lead['Lead']['comentarios']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Lead'), array('action' => 'edit', $lead['Lead']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Lead'), array('action' => 'delete', $lead['Lead']['id']), null, __('Are you sure you want to delete # %s?', $lead['Lead']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Leads'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lead'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inmuebles'), array('controller' => 'inmuebles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inmueble'), array('controller' => 'inmuebles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Agendas'), array('controller' => 'agendas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Agenda'), array('controller' => 'agendas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Agendas'); ?></h3>
	<?php if (!empty($lead['Agenda'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Lead Id'); ?></th>
		<th><?php echo __('Fecha'); ?></th>
		<th><?php echo __('Mensaje'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($lead['Agenda'] as $agenda): ?>
		<tr>
			<td><?php echo $agenda['id']; ?></td>
			<td><?php echo $agenda['user_id']; ?></td>
			<td><?php echo $agenda['lead_id']; ?></td>
			<td><?php echo $agenda['fecha']; ?></td>
			<td><?php echo $agenda['mensaje']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'agendas', 'action' => 'view', $agenda['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'agendas', 'action' => 'edit', $agenda['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'agendas', 'action' => 'delete', $agenda['id']), null, __('Are you sure you want to delete # %s?', $agenda['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Agenda'), array('controller' => 'agendas', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
