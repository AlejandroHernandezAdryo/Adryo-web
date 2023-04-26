<div class="documentosUsers view">
<h2><?php echo __('Documentos User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($documentosUser['DocumentosUser']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentosUser['User']['id'], array('controller' => 'users', 'action' => 'view', $documentosUser['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Documento'); ?></dt>
		<dd>
			<?php echo h($documentosUser['DocumentosUser']['documento']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ruta'); ?></dt>
		<dd>
			<?php echo h($documentosUser['DocumentosUser']['ruta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comentarios'); ?></dt>
		<dd>
			<?php echo h($documentosUser['DocumentosUser']['comentarios']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Documentos User'), array('action' => 'edit', $documentosUser['DocumentosUser']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Documentos User'), array('action' => 'delete', $documentosUser['DocumentosUser']['id']), null, __('Are you sure you want to delete # %s?', $documentosUser['DocumentosUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documentos User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
