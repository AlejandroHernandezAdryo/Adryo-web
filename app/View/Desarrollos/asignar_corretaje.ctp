<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-briefcase"></i>
                    ASIGNAR EMPRESA DE COMERCIALIZACIÓN
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
                        <p style="color:orange">Esta sección es para seleccionar la empresa que comercializará el desarrollo <?= $desarrollo['Desarrollo']['nombre']?>. Ten en consideración lo siguiente:</p>
                        <ol>
                            <li>El desarrollo, así como su inventario, estatus y toda la información podrá ser consultada por la empresa de comercialización.</li>
                            <li>La empresa comercializadora no podrá modificar precios, existencias ni inventarios. </li>
                            <li>Todos los clientes que el comercializador agregue, interesados en este desarrollo, serán cargados en tu cuenta, y podrás darle seguiemiento.</li>
                            <li>Al hacer una modificación en el desarrollo, el cambio se actualizará de manera inmediata y la comercializadora podrá ver el cambio en ese momento</li>
                        </ol>
                        <?= $this->Form->create('Desarrollo')?>
                        <?= $this->Form->hidden('desarrollo_id',array('value'=>$desarrollo['Desarrollo']['id']))?>
                        <?= $this->Form->input('agree',array('id'=>'agree','onchange'=>'javascript:showForma()','type'=>'checkbox','label'=>'He leido y estoy de acuerdo con las consideraciones generales.'))?>
                        <div class="col-sm-12 col-lg-12" id="titular" style="display: none">
                            <?= $this->Form->input('cuenta_comercializadora', array('div'=>false, 'label'=>'Id de seguridad de nueva cuenta titular', 'class'=>'form-control', 'required'=>true)) ?>
                        </div>
                        <div class="col-sm-12 col-lg-12" id="submit_titular" style="display: none">
                            <?= $this->Form->submit('Asignar a empresa comercializadora',array('class'=>'btn btn-success')) ?>
                        </div>
                        <?= $this->Form->end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>