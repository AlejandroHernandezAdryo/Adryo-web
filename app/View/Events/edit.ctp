<script>
    function show(){
        document.getElementById('forma').style.display='';
    }
    
</script>
    
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Calendario
        <small>Mis eventos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Calendario</li>
      </ol>
    </section>
    <section class="content" id="forma">
        <div class="row">
            <div class="col-md-12">
          
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Modificar evento</h3>
            </div>
            <div class="box-body">
              <!-- /btn-group -->
              <div class="input-group">
                   <?php 
                      echo $this->Form->create('Event');
                      echo $this->Form->input('id');
                      echo $this->Form->input('nombre_evento',array('type'=>'text','div' => 'col-xs-4','class'=>'form-control','placeholder'=>'Nombre Evento','label'=>false));
                      echo $this->Form->input('direccion',array('type'=>'text','div' => 'col-xs-4','class'=>'form-control','placeholder'=>'Dirección','label'=>false));
                      ?>
                      <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                          <?= $this->Form->input('horario', array('type'=>'text','class'=>'form-control pull-right','id'=>'reservationtime','label'=>false))?>
                  
                </div>
                      <?php
                      echo $this->Form->input('recordatorio_1',array('label'=>false,'div' => 'col-xs-4','class'=>'form-control','type'=>'select','empty'=>'Recordatorio 1','options'=>array(1=>'15 min antes',2=>'30 min antes',3 =>'1 hr antes',4=>'2 hr antes', 5=>'6 hr antes', 6 =>'12 hr antes', 7=>'1 día antes' , 8=>'2 días antes')));
                      echo $this->Form->input('recordatorio_2',array('label'=>false,'div' => 'col-xs-4','class'=>'form-control','type'=>'select','empty'=>'Recordatorio 2','options'=>array(1=>'15 min antes',2=>'30 min antes',3 =>'1 hr antes',4=>'2 hr antes', 5=>'6 hr antes', 6 =>'12 hr antes', 7=>'1 día antes' , 8=>'2 días antes')));
                      echo $this->Form->input('cliente_id',array('div' => 'col-xs-4','class'=>'form-control','placeholder'=>'Cliente','label'=>false,'empty'=>'Cliente'));
                      echo $this->Form->input('inmueble_id',array('div' => 'col-xs-4','class'=>'form-control','placeholder'=>'Propiedad','label'=>false,'empty'=>'Propiedad'));
                      echo $this->Form->input('desarrollo_id',array('div' => 'col-xs-4','class'=>'form-control','placeholder'=>'Desarrollo','label'=>false,'empty'=>'Desarrollo'));
                      echo $this->Form->input('to',array('div' => 'col-xs-4','class'=>'form-control','type'=>'select','options'=>$users,'label'=>false,'empty'=>'Actividad Propia'));
                      echo $this->Form->input('coordenadas',array('div' => 'col-xs-4','class'=>'form-control','placeholder'=>'Coordenadas de cita','label'=>false));
                      echo $this->Form->input('comentarios',array('div' => 'col-xs-4','class'=>'form-control','label'=>false));
                  ?>
                  <div class="input-group-btn">
                  <?= $this->Form->submit('Guardar Cambios',array('div' => 'col-xs-6','class'=>'btn btn-primary btn-flat'))?>
                  <?= $this->Form->end() ?>
                  <?= $this->Form->postLink('<i class="fa fa-trash"></i> Eliminar Evento', array('action' => 'delete', $event['Event']['id']), array('div' => 'col-xs-4','class'=>'btn btn-primary btn-flat','escape'=>false,'style'=>'background-color:#dd4b39'), __('Desea eliminar este evento de la agenda?', $event['Event']['id']));?>
       
                  
                </div>
                <!-- /btn-group -->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
            
        </div>
        
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
          
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

