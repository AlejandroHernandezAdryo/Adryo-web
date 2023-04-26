<section class="content-header">
          <h1>
           Opcionadores
            <small>Lista de opcionadores</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Opcionadores</a></li>
            <li class="active">Lista de opcionadores</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista de opcionadores</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper"><table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                      	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending"><?php echo $this->Paginator->sort('id'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('nombre'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending"><?php echo $this->Paginator->sort('correo_electronico'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('telefono'); ?></th>
                      	<?php if ($this->Session->read('Auth.User.Group.oe')){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Editar" ?></th>
                        <?php } ?>
                        <?php if ($this->Session->read('Auth.User.Group.od')){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Eliminar" ?></th>
                        <?php } ?>
                      	</tr>
                    </thead>
                    <tbody>
                   
                    <?php foreach ($opcionadors as $opcionador): ?>
                   
                    <tr>
                    <td><?php echo $opcionador['Opcionador']['id']?></td>
                    <td><?php echo $opcionador['Opcionador']['nombre']?></td>
                    <td><?php echo $opcionador['Opcionador']['correo_electronico']?></td>
                    <td><?php echo $opcionador['Opcionador']['telefono']?></td>
                    <?php if ($this->Session->read('Auth.User.Group.oe')){?>
                    <td><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'edit', $opcionador['Opcionador']['id']), array('escape'=>false))?></td>
                    <?php } ?>
                    <?php if ($this->Session->read('Auth.User.Group.od')==1){?>
                        <td style="text-align: center;"><?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', array('action' => 'delete', $opcionador['Opcionador']['id']), array('escape'=>false), __('Desea eliminar este opcionador?', $opcionador['Opcionador']['id'])); ?></td>
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
