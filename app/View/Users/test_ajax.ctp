<style>
	.card-content{
		padding: 30px;
	}
</style>
<div id="content" class="bg-container">
	<div class="outer">
		<div class="inner bg-light lter bg-container">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-content">

							<div class="row" style="display: none; background: green;" id="success">
								<div class="col-sm-12">
									Enviado
								</div>
							</div>

							<div class="row">
								<?php
									echo $this->Form->create();
										echo $this->Form->input('nombre', 
											array(
												'div'   => 'col-sm-12',
												'label' => 'Nombre',
												'class' => 'form-control'
											)
										);

										echo '<div class="col-sm-12">'.$this->Form->button('Enviar', array('type'=>'button', 'class'=>'btn btn-success mt-1', 'onclick'=>'check();')).'<div>';
									echo $this->Form->end();
								?>
							</div>

							<div class="row" id="enviado" style="display: none;">
								<div class="col-sm-12">
									Enviando...
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function check(){
		// $.ajax({
		// 	url: "test_ajax",
		// 	method: "POST",
		// 	data: {name: name, message:message},
		// 	success: function (data){
		// 		$('form').trigger('reset');
		// 		$('#success').fadeIn().html(data);
		// 		setTimeOut(function({
		// 			$('#success').fadeOut('slow');
		// 		}, 2000);
		// 	}
		// });
	}
</script>