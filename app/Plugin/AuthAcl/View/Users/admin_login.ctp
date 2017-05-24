<div class="account-container" style="margin-top: 60px;">
	<div class="content clearfix">
		
        <h1><?php echo __('Acesso restrito'); ?></h1>
        
        <?php if (!empty($error)) {?>
            <div class="alert alert-error"><?php echo $error;?></div>
        <?php } ?>
        
		<?php echo $this->Form->create('User', array('action' => 'login','class'=>'form-signin')); ?>
        	
			<div class="login-fields">
				<p><?php echo __('Por favor, informe seus dados.') ?></p>
				
				<div class="field">
					<label for="UserUserEmail">E-mail:</label>
                    <?php echo $this->Form->input('user_email',array('div' => false,'label'=>false, 'placeholder'=>__('E-mail'),'class'=>'login username-field')); ?>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="UserUserPassword">Password:</label>
                    <?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'placeholder'=>__('Senha'),'class'=>'login password-field')); ?>
				</div> <!-- /password -->
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				<span class="login-checkbox">
                    <?php echo $this->Form->checkbox('remember_me',array('id' => 'remember_me', 'div' => false,'label'=>false)); ?>
                    <label class="field login-checkbox" for="remember_me">
                        <?php echo __('Manter-me logado'); ?>
                    </label>
				</span>			
				<button class="button btn btn-inverse btn-large" name="submit" type="submit"><?php echo __('Entrar'); ?></button>
			</div> <!-- .actions -->
		</form>
	</div> <!-- /content -->
</div> <!-- /account-container -->

<div class="login-extra">
	<?php if (isset($general['Setting']) && (int)$general['Setting']['disable_reset_password'] == 0) { ?>
        <label>
            <a href="#" onclick='resetPassword(); return false;'>
                <?php echo __('N&atilde;o consegue acessar sua conta?'); ?>
            </a>
        </label>
        <?php }?>
        <?php if (isset($general['Setting']) && (int)$general['Setting']['disable_registration'] == 0){?>
        <label>
            <?php echo $this->Html->link(__('Criar nova conta'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'signup')); ?>
        </label>
    <?php } ?>
</div> <!-- /login-extra -->

<script>
<?php if (isset($general['Setting']) && (int)$general['Setting']['disable_reset_password'] == 0) { ?>
	
	function resetPassword() {
		var step = 1;
		var mId = $.sModal({
			header:'<?php echo __('Redefinir senha'); ?>',
			width:450,
			form:[
				{label:'<?php echo __('E-mail'); ?>',type:'text',name:'user_email',attr:{'placeholder':'E-mail',style:'width:300px;'}}
				  ],
			animate: 'fadeDown',
			buttons: [{
				text: ' <?php echo __('Enviar'); ?> ',
				addClass: 'btn-primary',
				click: function(id, data) {
					if (step == 1){
						var btnSubmit = $('#'+id).children('.modal-footer').children('a');
						btnSubmit.attr({disabled:'disabled'});
						btnSubmit.text('<?php echo __('Carregando...'); ?>');
						$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'resetPassword')); ?>',{data:{User:{user_email:$('#'+id).find('#user_email').val()}}},function(o){
							if (o.send_link == 1){
								btnSubmit.attr({disabled:false});
								btnSubmit.text('<?php echo __('Enviado'); ?>');
								$('#'+id).children('.modal-body').children('div').html('<div class="alert alert-success" style="padding:8px;"><?php echo __('Enviamos um e-mail com instru&ccedil;&otilde;es sobre como redefinir sua senha. Por favor, verifique seu e-mail.'); ?></div>');
								step =2;
							}else{
								btnSubmit.attr({disabled:false});
								btnSubmit.text(' <?php echo __('Enviar'); ?> ');
								step =1;
								$('#'+id).find('.alert-error').remove();
								$('#'+id).children('.modal-body').children('div').prepend('<div class="alert alert-error" style="padding:8px;"><?php echo __('<strong>Erro</strong>! Por favor, informe um endere&ccedil;o de e-mail correto.'); ?></div>');
							}
						},'json');
					}else if (step == 2){
						$.sModal('close', id);
					}
				}
			}]
			});
		$('#'+mId).find('input[type="text"]').each(function(){
			$(this).keypress(function(event){
				 if ( event.which == 13 ) {
					event.preventDefault();
				 }
			});
		});
	}
	
<?php } ?>

$(document).ready(function(){
	$('#authMessage').each(function(){
		var errors = $('<div class="alert alert-error" style="margin-bottom:0px;"></div>').html($(this).html());
		$('#container').children('.container').prepend(errors);
	});

	$('#flashMessage').each(function(){
		var errors = $('<div class="alert alert-success" style="margin-bottom:0px;"></div>').html($(this).html());
		$('#container').children('.container').prepend(errors);
	});
});
</script>