<div class="span12">
	<div class="widget action-table">
    	
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3><?php echo __('Configura&ccedil;&otilde;es: Geral'); ?></h3>
        </div> <!-- /widget-header -->
        
        <div class="widget-content">
            <div class="row-fluid show-grid" id="tab_user_manager">
                <div class="span12">
                    <ul class="nav nav-tabs">
                        <?php if ($this->Acl->check('Settings','admin_index','AuthAcl') == true){?>
                            <li class="active"><?php echo $this->Html->link(__('Geral'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'index')); ?></li>
                        <?php } ?>
                        <?php if ($this->Acl->check('Settings','admin_email','AuthAcl') == true){?>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"	class="dropdown-toggle"><?php echo __('Modelo do e-mail'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo $this->Html->link(__('Novo usu&aacute;rio'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'email/new_user'), array('escape' => false)); ?></li>
                                <li><?php echo $this->Html->link(__('Redefinir senha'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'email/reset_password')); ?></li>
                            </ul></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="row-fluid show-grid">
                <div class="span12">
                    <?php echo $this->Form->create('Setting',array('action' => 'save','class'=>'form-horizontal')); ?>
                    <?php echo $this->Form->hidden('setting_key'); ?>
                    
                    <legend>
                        <?php echo __('Op&ccedil;&otilde;es gerais'); ?>
                    </legend>
                    <div class="control-group">
                        <label class="control-label" for="SettingEmailAddress">
                            <?php echo __('E-mail do administrador'); ?>
                            <span style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('email_address',array('div' => false,'label'=>false,'placeholder'=>__('E-mail'),'class' => 'input-xlarge')); ?>
                        </div>
                    </div>
        
                    <div class="control-group">
                        <label class="control-label" for="SettingDefaultGroup">
                            <?php echo __('Grupo padr&atilde;o'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->select('default_group', $groups);?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">&nbsp;</label>
                        <div class="controls">
                            <label class="checkbox" for="SettingDisableRegistration">
                                <?php echo $this->Form->checkbox('disable_registration',array('div' => false,'label'=>false)); ?>
                                <?php echo __('Desabilitar inscri&ccedil;&otilde;es'); ?>
                            </label>
                            <label class="checkbox" for="SettingDisableResetPassword">
                                <?php echo $this->Form->checkbox('disable_reset_password',array('div' => false,'label'=>false)); ?>
                                <?php echo __('Desabilitar redefini&ccedil;&atilde;o de senha'); ?>
                            </label>
                            <label class="checkbox" for="SettingRequireEmailActivation">
                                <?php echo $this->Form->checkbox('require_email_activation',array('div' => false,'label'=>false)); ?>
                                <?php echo __('Exigir e-mail de ativa&ccedil;&atilde;o para usu&aacute;rios novos'); ?>
                            </label>
                        </div>
                    </div>
                    <legend>
                        <?php echo __('Op&ccedil;&otilde;es de ReCaptcha'); ?>
                    </legend>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">&nbsp;</label>
                        <div class="controls">
                            <label class="checkbox" for="SettingEnableRecaptcha" style="width: 90px;">
                                <?php echo $this->Form->checkbox('enable_recaptcha',array('div' => false,'label'=>false)); ?>
                                <?php echo __('Permitir'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="SettingRecaptchaPublicKey">
                            <?php echo __('Chave p&uacute;blica'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('recaptcha_public_key',array('div' => false,'label'=>false,'placeholder'=>__('Chave p&uacute;blica'),'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="recaptcha_private_key">
                            <?php echo __('Chave privada'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('recaptcha_private_key',array('div' => false,'label'=>false,'placeholder'=>__('Chave privada'),'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    
                    <?php if ($this->Acl->check('Settings','admin_save','AuthAcl') == true){?>
                    <div class="form-actions">
                        <button type="button" class="btn btn-info" onclick="save_setting();">
                            <?php echo __('Salvar'); ?>
                        </button>
                    </div>
                    <?php } ?>
                    
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->

<script type="text/javascript">
function save_setting(){
	$.post($('#SettingSaveForm').attr('action'),$('#SettingSaveForm').serialize(),function(o){
		if (o.error == 0){
			$('#SettingEmailAddress').parent().parent().removeClass('error');
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
				+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou as configura&ccedil;&otilde;es'); ?>'
				+ '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}else if (o.error == 1){
			$('#SettingEmailAddress').parent().parent().addClass('error');
			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:20px; top:20px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
				+ '<strong><?php echo __('Erro!'); ?></strong> '+o.error_message
				+ '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}
	},'json');
}
</script>