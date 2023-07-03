<style>
    .card-600{
        height: 400px;
    }

</style>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align">Panel de control</h4> 
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <div class="col-lg-4 col-sm-12 mt-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    Roles
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <!-- tab 5 Roles -->
                            <div class="" id="roles">
                                <div class="row">
                                <?= $this->Form->create('Group', array('type'=>'file','class'=>'form-horizontal login_validator', 'id' => 'profiles'))?>
                                        <div class="col-sm-12 col-lg-12">
                                            <div>
                                                <div id="tablaRole"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                <?= $this->Form->hidden('status', array('value'=>1)); ?>
                                <?= $this->Form->end()?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-12 mt-1">
                        <div class="card mt-15">
                            <div class="card-header">
                                <span>
                                    Agregar nuevo rol
                                </span>
                            </div>
                            <?= $this->Form->create('Group', array('type'=>'file','class'=>'form-horizontal login_validator', 'id' => 'formRole'))?>
                            <div class="card-block">
                                <div style="display:flex;flex-direction:column;">
                                    <label for="data[Group][nombre]">Nombre del rol</label>
                                    <input class="form-control" type="text" name="data[Group][nombre]" required autocomplete="false">
                                </div>
                                <div class="row mt-1" id="permisos" > </div>
                                <div class="mt-2">
                                    <?= $this->Form->button('Agregar rol', array('class' => 'btn btn-primary float-right', 'id' => 'FormSubmitAddRol')); ?>
                                </div>
                            </div>
                            <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                            <?= $this->Form->end()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        let cuenta = '<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'); ?>';
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "cuentas", "action" => "lista_rol")); ?>",
            data: {api_key: 'adryo', cuenta_id: cuenta},
            dataType: "Json",
            success: function (response) {

                for (let i in response['mensaje']){
                     
                    if( response['mensaje'][i]['Group']['nombre'] == 'Gerente' || response['mensaje'][i]['Group']['nombre'] == 'Superadministrador' || response['mensaje'][i]['Group']['nombre'] == 'Asesor' ){
                        $("#tablaRole").append(`
                        <div class="col-sm-12 mt-1" style="border-bottom: 1px solid #cecece;">
                            <span>
                                `+response['mensaje'][i]['Group']['nombre']+`
                            </span>
                        </div>`
                        );
                    }else{

                        if( response['mensaje'][i]['Group']['status'] == 1 ){
                            $("#tablaRole").append(`
                                <div class="col-sm-12 mt-1" style="border-bottom: 1px solid #cecece;">
                                    <span>
                                        `+response['mensaje'][i]['Group']['nombre']+`
                                    </span>
                                    <span>
                                        <i class=" pointer fa fa-ban fa-lg float-right" style="padding-top:5px; margin-left:12px;" onclick = "update_status(`+response['mensaje'][i]['Group']['id'] +`, 0)"></i>
                                        <i class=" pointer fa fa-pencil fa-lg float-right" style="padding-top:5px;"></i>
                                    </span>
                                </div>`
                            );

                        }else{
                            $("#tablaRole").append(`
                                <div class="col-sm-12 mt-1" style="border-bottom: 1px solid #cecece;">
                                    <strike>
                                        `+response['mensaje'][i]['Group']['nombre']+`
                                    </strike>
                                    <span>
                                        <i class=" pointer fa fa-check fa-lg float-right" style="padding-top:5px;" onclick = "update_status(`+response['mensaje'][i]['Group']['id'] +`,1)" ></i>
                                    </span>
                                </div>`
                            );
                        }

                    }
                }
            },
            error: function ( response ) {
            }
        });

        // Listado de permisos
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "cuentas", "action" => "view_permisos")); ?>",
            data: {api_key: 'adryo'},
            dataType: "Json",
            success: function (respon) {
                
                // Permisos cliente
                $("#permisos").append(`
                    <div class="col-sm-6 mt-1">
                        <div class="card border-300 card-600">
                            <div class="card-header">
                                <p for="dashboard" style="margin:0;">
                                    Cliente
                                </p>
                            </div>
                            <div class="card-block" style="display:flex;align-items:baseline;">
                                <span id="permisos-cliente">
                                </span>
                            </div>
                        </div>
                    </div>
                `);
                for (let x in respon['mensaje']['Cliente']){
                    $("#permisos-cliente").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Cliente'][x]['key']+`]" >
                            `+respon['mensaje']['Cliente'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                // Permisos desarrollo
                $("#permisos").append(`
                <div class="col-sm-6 mt-1" >
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Desarrollo
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-desarrollo">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Desarrollo']){
                    $("#permisos-desarrollo").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Desarrollo'][x]['key']+`]" >
                            `+respon['mensaje']['Desarrollo'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }

                // Permisos grupo
                $("#permisos").append(`
                <div class="col-sm-6 mt-1">
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Grupo
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-Grupo">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Grupo']){
                    $("#permisos-Grupo").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Grupo'][x]['key']+`]" >
                            `+respon['mensaje']['Grupo'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                
                // Permisos agenda
                $("#permisos").append(`
                <div class="col-sm-6 mt-1">
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Agenda
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-agenda">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Agenda']){
                    $("#permisos-agenda").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Agenda'][x]['key']+`]" >
                            `+respon['mensaje']['Agenda'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                // Permisos usuario
                $("#permisos").append(`
                <div class="col-sm-6 mt-1">
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Usuarios
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-usuarios">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Usuario']){
                    $("#permisos-usuarios").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Usuario'][x]['key']+`]" >
                            `+respon['mensaje']['Usuario'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                // Permisos finanzas
                $("#permisos").append(`
                <div class="col-sm-6 mt-1">
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Finanzas
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-finanzas">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Finanzas']){
                    $("#permisos-finanzas").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Finanzas'][x]['key']+`]" >
                            `+respon['mensaje']['Finanzas'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                // Permisos mensaje
                $("#permisos").append(`
                <div class="col-sm-6 mt-1">
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Mensaje
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-mensaje">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Mensaje']){
                    $("#permisos-mensaje").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Mensaje'][x]['key']+`]" >
                            `+respon['mensaje']['Mensaje'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                // Permisos inmuebles
                $("#permisos").append(`
                <div class="col-sm-6 mt-1">
                    <div class="card border-300 card-600">
                        <div class="card-header">
                            <p for="dashboard" style="margin:0;">
                                Inmueble
                            </p>
                        </div>
                        <div class="card-block" style="display:flex;align-items:baseline;">
                            <span id="permisos-inmueble">
                            </span>
                        </div>
                    </div>
                </div>
                `
                );
                for (let x in respon['mensaje']['Inmueble']){
                    $("#permisos-inmueble").append(`
                    <div style="display:flex;align-items:baseline;">
                        <label for="dashboard" style="margin-left:16px;">
                            <input type="checkbox" value="1" name="data[Group][`+respon['mensaje']['Inmueble'][x]['key']+`]" >
                            `+respon['mensaje']['Inmueble'][x]['label']+`
                        </label>
                    </div>
                    `
                    );
                }
                    
            },
            error: function ( respon ) {
            },
        });

    });

    

    // Mandar submit para guardar nuevo rol
    $(document).on("submit", "#formRole", function (event) {
        event.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "cuentas", "action" => "new_roll")); ?>",
            data: new FormData(this),
            dataType: "Json",
            processData: false,
            contentType: false,
            success: function (response) {
                window.location.reload();
            },
            error: function ( response ) {
                $("#overlay").fadeOut();
            },

        })

    });

    // Funcion de deshabilitar el rol.
    function update_status( id, status ){

        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "cuentas", "action" => "edit_roll")); ?>",
            cache: false,
            data: {
                'Group': {
                    'id'    : id,
                    'status': status,
                }
            },
            dataType: "Json",
            success: function (response) {
                
                window.location.reload();

            },
            error: function ( response ) {
                $("#overlay").fadeOut();
            },

        })


    }

</script>