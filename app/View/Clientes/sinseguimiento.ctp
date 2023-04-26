<section class="content-header">
          <h1>
           Clientes
            <small>Lista de clientes Sin Seguimiento</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Clientes</a></li>
            <li class="active">Lista de clientes sin seguimiento</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista de clientes sin seguimiento</h3>
                  
              </span>
            </div>
          
                </div>
                  <!-- /.box-header -->
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper"><table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                      	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending"><?php echo $this->Paginator->sort('nombre'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('apellido_paterno'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending"><?php echo $this->Paginator->sort('apellido_materno'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending"><?php echo $this->Paginator->sort('correo_electronico'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('telefono1'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('tipo_cliente'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('status'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('etapa'); ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('created','Fecha de Creación'); ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->Paginator->sort('user_id','Asesor'); ?></th>
                        <?php if ($this->Session->read('Auth.User.Group.ce')){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Editar" ?></th>
                        <?php } ?>
                        <?php if ($this->Session->read('Auth.User.Group.cd')){?>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo "Eliminar" ?></th>
                        <?php } ?>
                      	</tr>
                    </thead>
                    <tbody>
                   
                    <?php foreach ($clientes as $cliente):?>
                   
                    <tr>
                        <td style="text-transform: uppercase"><?php echo $this->Html->link($cliente['Cliente']['nombre'], array('action'=>'view', $cliente['Cliente']['id']))?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['apellido_paterno']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['apellido_materno']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['correo_electronico']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['telefono1']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['tipo_cliente']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['status']?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['Cliente']['etapa']?></td>
                    <td style="text-transform: uppercase"><?php echo date_format(date_create($cliente['Cliente']['created']),"d-M-Y")?></td>
                    <td style="text-transform: uppercase"><?php echo $cliente['User']['nombre_completo']?></td>
                    <?php if ($this->Session->read('Auth.User.Group.ce')){?>
                    <td style="text-transform: uppercase"><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'edit', $cliente['Cliente']['id']), array('escape'=>false))?></td>
                    <?php } ?>
                    <?php if ($this->Session->read('Auth.User.Group.cd')){?>
                    <td>
                    <?php echo $this->Form->postLink('<i class ="fa fa-trash"></i>', array('action' => 'delete', $cliente['Cliente']['id']), array('escape'=>false), __('Deseas eliminar al cliente?', $cliente['Cliente']['id'])); ?>
                    </td>
                    <?php } ?>
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

