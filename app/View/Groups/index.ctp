<div class="abs-layout-wrapper">
	<div class="abs-content-layout">
    	<div class="abs-content-layout-row">
        	<div class="abs-layout-cell abs-sidebar1">
	        	<div class="abs-vmenublock clearfix">
	        		<div class="abs-vmenublockheader">
	            		<h3 class="t">Usuarios</h3>
	        		</div>
	        		<div class="abs-vmenublockcontent">
						<ul class="abs-vmenu">
							<li><?php echo $this->Html->link('<i class="fa fa-plus-circle"> Agregar Usuario </i>', array('controller'=>'users','action'=>'add'),array('escape' => false))?></li>
						</ul>
	                </div>
	           	</div>
	           	
	           	<div class="abs-vmenublock clearfix">
	        		<div class="abs-vmenublockheader">
	            		<h3 class="t">Grupos de usuarios</h3>
	        		</div>
	        		<div class="abs-vmenublockcontent">
						<ul class="abs-vmenu">
							<li><?php echo $this->Html->link('<i class="fa fa-plus-circle"> Agregar Grupo </i>', array('controller'=>'groups','action'=>'add'),array('escape' => false))?></li>
							<li><?php echo $this->Html->link('<i class="fa fa-list-alt"> Listar Grupos </i>',  array('controller'=>'groups','action'=>'index'),array('escape' => false))?></li>
						</ul>
	                </div>
	           	</div>
	           	
	           	<div class="abs-vmenublock clearfix">
	        		<div class="abs-vmenublockheader">
	            		<h3 class="t">Tipo de eventos</h3>
	        		</div>
	        		<div class="abs-vmenublockcontent">
						<ul class="abs-vmenu">
							<li><?php echo $this->Html->link('<i class="fa fa-plus-circle"> Agregar Tipo </i>', "/full_calendar/event_types/add",array('escape' => false))?></li>
							<li><?php echo $this->Html->link('<i class="fa fa-list-alt"> Listar Tipos </i>', "/full_calendar/event_types",array('escape' => false))?></li>
						</ul>
	                </div>
	           	</div>
	      	</div>
			<div class="abs-layout-cell abs-content">
				<article class="abs-post abs-article">
                	<div class="abs-postcontent abs-postcontent-0 clearfix">
						<div class="abs-content-layout layout-item-3">
						    <div class="abs-content-layout-row">
							    <div class="abs-layout-cell layout-item-2" style="width: 100%" >
									<h2><?php echo __('Grupos'); ?></h2>
									<p><?php echo $this->Html->link('<i class="fa fa-plus-circle fa-lg"></i> Crear Grupo',array('controller'=>'groups','action'=>'add'),array('escape'=>false))?>
									
									<table cellpadding="0" cellspacing="0">
									<tr>
											<th><?php echo $this->Paginator->sort('nombre'); ?></th>
											<th><?php echo $this->Paginator->sort('descripcion'); ?></th>
											<th><?php echo __('Editar'); ?></th>
											
									</tr>
									<?php foreach ($grupos as $grupo): ?>
									<tr>
										<td><?php echo h($grupo['Group']['nombre']); ?>&nbsp;</td>
										<td><?php echo h($grupo['Group']['descripcion']);?>&nbsp;</td>
										<td style="text-align:center"><?php echo $this->Html->link('<i class="fa fa-edit fa-lg"></i>',array('controller'=>'groups','action'=>'edit',$grupo['Group']['id']),array('escape'=>false))?></td>
										
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
						    </div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</div>
