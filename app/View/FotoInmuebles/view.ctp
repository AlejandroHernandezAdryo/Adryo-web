<div class="fotoInmuebles view">
<h2><?php echo __('Foto Inmueble'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($fotoInmueble['FotoInmueble']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inmueble'); ?></dt>
		<dd>
			<?php echo $this->Html->link($fotoInmueble['Inmueble']['id'], array('controller' => 'inmuebles', 'action' => 'view', $fotoInmueble['Inmueble']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ruta'); ?></dt>
		<dd>
			<?php echo h($fotoInmueble['FotoInmueble']['ruta']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Foto Inmueble'), array('action' => 'edit', $fotoInmueble['FotoInmueble']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Foto Inmueble'), array('action' => 'delete', $fotoInmueble['FotoInmueble']['id']), null, __('Are you sure you want to delete # %s?', $fotoInmueble['FotoInmueble']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Foto Inmuebles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Foto Inmueble'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inmuebles'), array('controller' => 'inmuebles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inmueble'), array('controller' => 'inmuebles', 'action' => 'add')); ?> </li>
	</ul>
</div>
