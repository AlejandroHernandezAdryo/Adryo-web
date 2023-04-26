<section class="content-header">
          <h1>
           Usuarios
            <small>Lista de usuarios</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Usuarios</a></li>
            <li class="active">Lista de usuarios</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Usuarios del sistema</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper"><table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                      	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending"><?php echo $this->Paginator->sort('nombre_completo'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('puesto'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('correo_electronico'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending"><?php echo $this->Paginator->sort('telefono1', 'Teléfono'); ?></th>
                      	<?php if ($this->Session->read('Auth.User.Group.ue')==1){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Agregar Propiedad" ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Editar" ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Cambiar Contraseña" ?></th>
                        <?php }?>
                        <?php if ($this->Session->read('Auth.User.Group.ud')==1){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Eliminar" ?></th>
                        <?php }?>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Ver Perfil" ?></th>
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
                        <td style="text-align: center;"><?php echo $this->Html->link('<i class="fa fa-plus"></i>', array('action'=>'add_propiedad', $user['User']['id']), array('escape'=>false))?></td>
                        <td style="text-align: center;"><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'edit_cliente', $user['User']['id']), array('escape'=>false))?></td>
                        <td style="text-align: center;"><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'password', $user['User']['id']), array('escape'=>false))?></td>
                    <?php }?>
                    <?php if ($this->Session->read('Auth.User.Group.ud')==1){?>    
                    <td style="text-align: center;">
                        <?php
                            
                                echo "<b>".$this->Form->postLink('X', array('action' => 'delete', $user['User']['id']), array('escape'=>false), __('Desea eliminar este usuario?', $user['User']['id']))."</b>";
                            
                        ?>
                    </td>
                    <?php }?>
                    <td><?= $this->Html->link('<i class="fa fa-television"></i>',array('controller'=>'users','action'=>'mysession',$user['User']['id']),array('escape'=>false,'target'=>'_blank'))?></td>
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
