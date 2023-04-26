<div class="fotoDesarrollos view">
<h2><?php echo __('Foto Desarrollo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($fotoDesarrollo['FotoDesarrollo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Desarrollo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($fotoDesarrollo['Desarrollo']['id'], array('controller' => 'desarrollos', 'action' => 'view', $fotoDesarrollo['Desarrollo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ruta'); ?></dt>
		<dd>
			<?php echo h($fotoDesarrollo['FotoDesarrollo']['ruta']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Foto Desarrollo'), array('action' => 'edit', $fotoDesarrollo['FotoDesarrollo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Foto Desarrollo'), array('action' => 'delete', $fotoDesarrollo['FotoDesarrollo']['id']), null, __('Are you sure you want to delete # %s?', $fotoDesarrollo['FotoDesarrollo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Foto Desarrollos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Foto Desarrollo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
	</ul>
</div>
