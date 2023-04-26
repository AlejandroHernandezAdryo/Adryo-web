<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-external-link-square"></i>
                    TRANSFERIR DESARROLLO A OTRA CUENTA
                </h4>
            </div>
        </div>
    </header>
    
    <script>
        function showForma(){
            if (document.getElementById('agree').checked){
                document.getElementById('titular').style.display="";
                document.getElementById('submit_titular').style.display="";
            }else{
                document.getElementById('titular').style.display="none";
                document.getElementById('submit_titular').style.display="none";
            }
        }
    </script>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-block">
                    <div class="card-block">
                        <p><h2 style="color:black">NOMBRE DE DESARROLLO: </h2><?= $desarrollo['Desarrollo']['nombre']?></p>
                        <p style="color:red"><i class="fa fa-warning fa-2x"></i>ATENCIÓN</p>
                        <p style="color:red">Esta sección es para que la titularidad del desarrollo <?= $desarrollo['Desarrollo']['nombre']?> sea transferida a otra cuenta. Ten en consideración lo siguiente:</p>
                        <ol style="color:red">
                            <li>Todo el desarrollo será transferido en su totalidad a la cuenta que tu desees y desaparecerá de tu inventario</li>
                            <li>Todo el inventario, al igual que el desarrollo, será transferido a la nueva cuenta </li>
                            <li>Todos los clientes que hayan sido cargados a tu base de datos, que hayan tenido su primer interés en este desarrollo, serán transferidos a la nueva cuenta, así como todo su seguimiento y no los podrás ver después de este movimiento.</li>
                            <li>Si la nueva cuenta quiere que tu continues como su comercializadora, y poder volver a ver el desarrollo en tu inventario, deberás solicitárselo, y ellos tendrán que asignarte como la empresa de corretaje exclusivo.</li>
                            <li>El seguimiento a tus clientes lo perderás, a menos que la nueva cuenta te autorice como comercializadora exclusiva</li>
                            <li>La nueva cuenta será la única que podrá modificar la existencia, la información del inventario, así como los datos generales del desarrollo.</li>
                            <li>Como comercializadora exclusiva, sólo podrás consultar y realizar transacciones de seguimiento, ventas y cambio de estatus en el desarrollo</li>
                            <li>**Este cambio es irreversible y no podrás solicitar que se vuelva a cargar el desarrollo en tu cuenta**</li>
                        </ol>
                        <?= $this->Form->create('Desarrollo')?>
                        <?= $this->Form->hidden('desarrollo_id',array('value'=>$desarrollo['Desarrollo']['id']))?>
                        <?= $this->Form->input('agree',array('id'=>'agree','onchange'=>'javascript:showForma()','type'=>'checkbox','label'=>'He leido y estoy de acuerdo con las consideraciones generales. Deseo cambiar de cuenta este desarrollo.'))?>
                        <div class="col-sm-12 col-lg-12" id="titular" style="display: none">
                            <?= $this->Form->input('cuenta_titular', array('div'=>false, 'label'=>'Id de seguridad de nueva cuenta titular', 'class'=>'form-control', 'required'=>true)) ?>
                        </div>
                        <div class="col-sm-12 col-lg-12" id="submit_titular" style="display: none">
                            <?= $this->Form->submit('Realizar transferencia de desarrollo',array('class'=>'btn btn-success')) ?>
                        </div>
                        <?= $this->Form->end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>