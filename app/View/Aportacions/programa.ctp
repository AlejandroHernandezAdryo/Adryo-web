<section class="content-header">
          <h1>
           Aportaciones
            <small>Lista de Aportaciones</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Aportaciones</a></li>
            <li class="active">Lista de Aportaciones Programadas</li>
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Lista de Aportaciones Programadas</h3>
                  
              </span>
            </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper"><table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                      	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending"><?php echo $this->Paginator->sort('id'); ?></th>
                      	<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('cliente_id'); ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('fecha_aportacion'); ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('monto_aportacion'); ?></th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->Paginator->sort('aplicada'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $opciones = array('Transferencia Electrónica'=>'Transferencia Electrónica','Efectivo'=>'Efectivo','Cheque'=>'Cheque'); 
                        $tipo_transaccion = array (1=>'Aportación',2=>'Retiro');
                        $aplicada = array(0 => 'Programada',1=>'No Aplicada', 2=>'Aplicada');
                    ?>
                    <?php foreach ($aportacions as $aportacion):?>
                   
                    <tr>
                        <td><?php echo h($aportacion['Aportacion']['id']); ?>&nbsp;</td>
                        <td><?php echo h($aportacion['Cliente']['nombres']." ".$aportacion['Cliente']['apellido_paterno']." ".$aportacion['Cliente']['apellido_materno']); ?>&nbsp;</td>
                        <td><?php echo date_format(date_create($aportacion['Aportacion']['fecha_aportacion']),"d-M-Y") ?>&nbsp;</td>
                        <td><?php echo number_format($aportacion['Aportacion']['monto_aportacion'],2); ?>&nbsp;</td>
                        
                        <td><?php echo $aplicada[$aportacion['Aportacion']['aplicada']]; ?>&nbsp;</td>
                        
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




<
