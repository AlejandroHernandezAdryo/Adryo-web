<div class=" bd-stretchtobottom-2 bd-stretch-to-bottom" data-control-selector=".bd-content-12"><div class=" bd-content-12 ">
    
    <div class=" bd-htmlcontent-13 bd-margins" 
 data-page-id="page.18">
    <section class=" bd-section-27 bd-page-width bd-tagstyles " id="section4" data-section-title="Two Columns with Image Right">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-39 bd-page-width  bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row 
 bd-row-flex 
 bd-row-align-middle">
                <?php echo $this->Session->flash(); ?>
                <div class=" bd-columnwrapper-153 
 col-md-6
 col-sm-12">
    <div class="bd-layoutcolumn-153 bd-column" ><div class="bd-vertical-align-wrapper"><h1 class=" bd-textblock-202 bd-content-element">
    ¡Estás a unos pasos de profesionalizar tu negocio!
</h1>
	
		<div class=" bd-spacer-47 clearfix"></div>
	
		<p class=" bd-textblock-201 bd-content-element">
    Por tiempo limitado, Adryo te regala la oportunidad de probar a fondo nuestro sistema sin compromiso alguno.
</p>
<p class=" bd-textblock-201 bd-content-element">
    Envíanos tus datos y uno de nuestros ejecutivos se pondrá en contacto contigo para poderte generar una cuenta, con la cual podrás
    utilizar todos los módulos de Adryo.
</p>
<p class=" bd-textblock-201 bd-content-element">
    Adicional, contarás con soporte gratuito para cualquier duda que surja.
</p>
<p class=" bd-textblock-201 bd-content-element">
    ¡No te preocupes por nada! Nuestro equipo de soporte estará apoyándote en cualquier momento.
</p>
	
		<div class=" bd-spacer-46 clearfix"></div></div></div>
</div>
	
		<div class=" bd-columnwrapper-152 
 col-md-6
 col-sm-12">
                    <style>
                        .margin-forma{
                            margin-bottom: 20px;
                        }
                        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                            color: red;
                            opacity: 1; /* Firefox */
                        }

                        :-ms-input-placeholder { /* Internet Explorer 10-11 */
                            color: red;
                        }

                        ::-ms-input-placeholder { /* Microsoft Edge */
                            color: red;
                        }
                        .success{
                            background-color: #036903;
                            color: white;
                            padding: 5%;
                            width: 100%;
                            text-align: center;
                            font-size: 1.2em;
                        }
                    </style>
    <div class="bd-layoutcolumn-152 bd-column" ><div class="bd-vertical-align-wrapper">
            <h2 style="font-size: 1em">Favor de llenar los siguientes datos para solicitar una prueba.</h2>
            <?= $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'solicitar_prueba'))) ?>
            <?= $this->Form->input('nombre',array('div'=>'col-md-12 margin-forma','label'=>false,'placeholder'=>'Nombre'))?>
            <?= $this->Form->input('nombre_empresa',array('div'=>'col-md-12 m-t-35 margin-forma','label'=>false,'placeholder'=>'Nombre empresa'))?>
            <?= $this->Form->input('email',array('div'=>'col-md-6 margin-forma','label'=>false,'placeholder'=>'Correo Electrónico'))?>
            <?= $this->Form->input('telefono',array('div'=>'col-md-6 margin-forma','label'=>false,'placeholder'=>'Teléfono'))?>
            <?= $this->Form->input('horario_contacto',array('div'=>'col-md-6 margin-forma','label'=>false,'placeholder'=>'Horario preferido para contactarme'))?>
            <?= $this->Form->input('empleados',array('div'=>'col-md-6 m-t-35 margin-forma','label'=>false,'placeholder'=>'Número de empleados'))?>
            <?= $this->Form->input('giro',array('div'=>'col-md-12 margin-forma','label'=>false,'empty'=>'Seleccionar un tipo de negocio','type'=>'select','options'=>array('Inmobiliaria'=>'Inmobiliaria','Desarrolladora'=>'Desarrolladora','Desarrolladora e Inmobiliaria'=>'Desarrolladora e Inmobiliaria')))?>
            <?= $this->Form->end('Solicitar Prueba',array('style'=>'bd-linkbutton-20 bd-no-margins  bd-button-25 bd-icon bd-icon-55 bd-own-margins bd-content-element'))?>
</div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
	
</div>
</div></div>
