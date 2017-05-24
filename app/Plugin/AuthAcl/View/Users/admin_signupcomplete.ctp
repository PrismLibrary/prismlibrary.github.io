<div class="account-container">
	<div class="content clearfix">
    	
        <h3>Obrigado!</h3> Voc&ecirc; foi registrado.
        
        <?php if (isset($general['Setting']) && (int)$general['Setting']['require_email_activation'] == 1){?>
            Um e-mail j&aacute; foi enviado para voc&ecirc; antes.<br />
            Por favor verique seu e-mail para ativar a sua conta.
        <?php } ?>
        
        <?php echo $this->Html->link(__('Entrar'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login')); ?>.
        
    </div> <!-- /content clearfix -->
</div> <!-- /account-container -->