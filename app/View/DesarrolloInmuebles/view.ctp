<div class="desarrolloInmuebles view">
<h2><?php echo __('Desarrollo Inmueble'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($desarrolloInmueble['DesarrolloInmueble']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Desarrollo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($desarrolloInmueble['Desarrollo']['id'], array('controller' => 'desarrollos', 'action' => 'view', $desarrolloInmueble['Desarrollo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inmueble'); ?></dt>
		<dd>
			<?php echo $this->Html->link($desarrolloInmueble['Inmueble']['id'], array('controller' => 'inmuebles', 'action' => 'view', $desarrolloInmueble['Inmueble']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Desarrollo Inmueble'), array('action' => 'edit', $desarrolloInmueble['DesarrolloInmueble']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Desarrollo Inmueble'), array('action' => 'delete', $desarrolloInmueble['DesarrolloInmueble']['id']), null, __('Are you sure you want to delete # %s?', $desarrolloInmueble['DesarrolloInmueble']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Desarrollo Inmuebles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo Inmueble'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Desarrollos'), array('controller' => 'desarrollos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Desarrollo'), array('controller' => 'desarrollos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inmuebles'), array('controller' => 'inmuebles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inmueble'), array('controller' => 'inmuebles', 'action' => 'add')); ?> </li>
	</ul>
</div>
