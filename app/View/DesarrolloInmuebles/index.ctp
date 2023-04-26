<div class="desarrolloInmuebles index">
	<h2><?php echo __('Desarrollo Inmuebles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('desarrollo_id'); ?></th>
			<th><?php echo $this->Paginator->sort('inmueble_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($desarrolloInmuebles as $desarrolloInmueble): ?>
	<tr>
		<td><?php echo h($desarrolloInmueble['DesarrolloInmueble']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($desarrolloInmueble['Desarrollo']['id'], array('controller' => 'desarrollos', 'action' => 'view', $desarrolloInmueble['Desarrollo']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($desarrolloInmueble['Inmueble']['id'], array('controller' => 'inmuebles', 'action' => 'view', $desarrolloInmueble['Inmueble']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $desarrolloInmueble['DesarrolloInmueble']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $desarrolloInmueble['DesarrolloInmueble']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $desarrolloInmueble['DesarrolloInmueble']['id']), null, __('Are you sure you want to delete # %s?', $desarrolloInmueble['DesarrolloInmueble']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Desarrollo Inmueble'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inmuebles'), array('controller' => 'inmuebles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inmueble'), array('controller' => 'inmuebles', 'action' => 'add')); ?> </li>
	</ul>
</div>
