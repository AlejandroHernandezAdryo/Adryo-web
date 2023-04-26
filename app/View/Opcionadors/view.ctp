<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($opcionador['Opcionador']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($opcionador['Opcionador']['nombre']); ?>
			&nbsp;
		</dd>
		<dd>
			<?php echo h($opcionador['Opcionador']['correo_electronico']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono'); ?></dt>
		<dd>
			<?php echo h($opcionador['Opcionador']['telefono']); ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
