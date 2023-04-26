<div class="fotoDesarrollos index">
	<h2><?php echo __('Foto Desarrollos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('desarrollo_id'); ?></th>
			<th><?php echo $this->Paginator->sort('ruta'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($fotoDesarrollos as $fotoDesarrollo): ?>
	<tr>
		<td><?php echo h($fotoDesarrollo['FotoDesarrollo']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($fotoDesarrollo['Desarrollo']['id'], array('controller' => 'desarrollos', 'action' => 'view', $fotoDesarrollo['Desarrollo']['id'])); ?>
		</td>
		<td><?php echo h($fotoDesarrollo['FotoDesarrollo']['ruta']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $fotoDesarrollo['FotoDesarrollo']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $fotoDesarrollo['FotoDesarrollo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $fotoDesarrollo['FotoDesarrollo']['id']), null, __('Are you sure you want to delete # %s?', $fotoDesarrollo['FotoDesarrollo']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Foto Desarrollo'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
	</ul>
</div>
