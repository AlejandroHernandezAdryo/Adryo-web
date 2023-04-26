<section class="content-header">
          <h1>
           Tickets
            <small>Lista de Tickets</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Tickets</a></li>
            <li class="active">Lista de Tickets</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tickets generados</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper"><table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                      	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending"><?php echo $this->Paginator->sort('id'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('fecha'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('desarrollo_id'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending"><?php echo $this->Paginator->sort('inmueble_id'); ?></th>
                      	<?php if ($this->Session->read('Auth.User.Group.ue')==1){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Editar" ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Cambiar Contraseña" ?></th>
                        <?php }?>
                        <?php if ($this->Session->read('Auth.User.Group.ud')==1){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Eliminar" ?></th>
                        <?php }?>
                        
                      	</tr>
                    </thead>
                    <tbody>
                   
                    <?php foreach ($users as $user):?>
                   
                    <tr>
                    <td><?php echo strtoupper($user['User']['nombre_completo'])?></td>
                    <td><?php echo strtoupper($user['User']['puesto'])?></td>
                    <td><?php echo strtoupper($user['User']['correo_electronico'])?></td>
                    <td><?php echo strtoupper($user['User']['telefono1'])?></td>
                    <?php if ($this->Session->read('Auth.User.Group.ue')==1){?>
                        <td style="text-align: center;"><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'edit', $user['User']['id']), array('escape'=>false))?></td>
                        <td style="text-align: center;"><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'password', $user['User']['id']), array('escape'=>false))?></td>
                    <?php }?>
                    <?php if ($this->Session->read('Auth.User.Group.ud')==1){?>    
                    <td style="text-align: center;">
                        <?php
                            
                                echo "<b>".$this->Form->postLink('X', array('action' => 'delete', $user['User']['id']), array('escape'=>false), __('Desea eliminar este usuario?', $user['User']['id']))."</b>";
                            
                        ?>
                    </td>
                    <?php }?>
                    </tr>
                    <?php endforeach;?>
                   </tbody>
                  </table>
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                  		<?php
							echo $this->Paginator->counter(array(
							'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
							));
						?>	
	
                  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                  <?php
						echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
						echo $this->Paginator->numbers(array('separator' => ''));
						echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
                  </div></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              
              </div><!-- /.box -->
            </div>
              
          </div>   <!-- /.row -->
        </section>
