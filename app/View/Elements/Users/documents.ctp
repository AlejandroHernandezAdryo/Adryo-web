<section class="content-header">
          <h1>
           Documentos
            <small>Mis documentos</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a  class="active" href="#">Documentos</a></li>
            
          </ol>
        </section>
        
        <section class="content">
		<div class="row">
            
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Mis documentos</h3>
                </div><!-- /.box-header -->
                <?php echo $this->Form->create('User',array('url'=>array('controller'=>'Users','action'=>'upload'),'type'=>'file'))?>
                <?php echo $this->Form->input('archivo.',array('type'=>'file','multiple')) ?>
                                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
                                <?php echo $this->Form->button('Subir Archivo',array('type'=>'submit')); ?>
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper"><table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                          
                  
                      <?php
                                        $dir = getcwd()."/files/users/".$this->Session->read('Auth.User.id')."/";
                                        $files1 = scandir($dir);
                                        $i = 0;
                                        
                                        foreach ($files1 as $imagen):
                                        if ($i >1){
                                   ?>
                                    <tr>
                                        <td>
                                            
                                            <?php
                                                
                                                
                                                    echo $this->Html->link($imagen,"/files/users/".$this->Session->read('Auth.User.id')."/".$imagen,array('target'=>'_blank')); 
                                                
                                            ?>
                                        </td>
                                    </tr>
                                   <?php
                                   
                                        }
                                        $i++;
                                        endforeach; 
                                        
                                   ?>
                  </table>
                 </div><!-- /.box-body -->
              </div><!-- /.box -->

              
              </div><!-- /.box -->
            </div>
              
          </div>   <!-- /.row -->
        </section>
