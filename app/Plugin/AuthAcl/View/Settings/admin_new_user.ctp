<div class="span12">
	<div class="widget action-table">
    	
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3><?php echo __('Configura&ccedil;&otilde;es: E-mail (novo usu&aacute;rio)'); ?></h3>
        </div> <!-- /widget-header -->
        
        <div class="widget-content">
            <div class="row-fluid show-grid" id="tab_user_manager">
                <div class="span12">
                    <ul class="nav nav-tabs">
                        <?php if ($this->Acl->check('Settings','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Geral'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'index')); ?></li>
                        <?php } ?>
                        <?php if ($this->Acl->check('Settings','admin_email','AuthAcl') == true){?>
                        <li class="dropdown active">
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
        
                    <div class="control-group">
                        <label for="email-activate-resend-subj" class="control-label">
                            <?php echo __('Enviar link'); ?>
                        </label>
                        <div class="controls">
                            <label> <?php echo $this->Form->input('send_link_subject',array('div' => false,'label'=>false,'class' => 'input-xlarge','placeholder'=>__('Assunto'))); ?>
                                <p class="help-inline">
                                    <?php echo __('Assunto'); ?>
                                </p>
                            </label>
                            <?php echo $this->Form->textarea('send_link_body',array('class' => 'input-xlarge','rows' => 10,'placeholder'=>__('Corpo da mensagem'))); ?>
                            <div class="help-inline">
                                <p><?php echo __('Corpo da mensagem'); ?></p><br />
                                <p><strong><?php echo __('Shortcodes:'); ?></strong></p>
                                <p><?php echo __('Site:'); ?> <code>{site_address}</code></p>
                                <p><?php echo __('Nome completo:'); ?> <code>{user_name}</code></p>
                                <p><?php echo __('E-mail:'); ?> <code>{user_email}</code></p>
                                <p><?php echo __('Link de ativa&ccedil;&atilde;o:'); ?> <code>{activation_link}</code></p>
                            </div>
                        </div>
                    </div>
        
        
                    <div class="control-group">
                        <label for="email-activate-subj" class="control-label">
                            <?php echo __('Ativado'); ?>
                        </label>
                        <div class="controls">
                            <label><?php echo $this->Form->input('activated_subject',array('div' => false,'label'=>false,'class' => 'input-xlarge','placeholder'=>__('Assunto'))); ?>
                                <p class="help-inline">
                                    <?php echo __('Assunto'); ?>
                                </p>
                            </label>
                            <?php echo $this->Form->textarea('activated_body',array('class' => 'input-xlarge','rows' => 11,'placeholder'=>__('Corpo da mensagem'))); ?>
                            <div class="help-inline">
                                <p><?php echo __('Corpo da mensagem'); ?></p><br />
                                <p><strong><?php echo __('Shortcodes:'); ?></strong></p>
                                <p><?php echo __('Site:'); ?> <code>{site_address}</code></p>
                                <p><?php echo __('Nome completo:'); ?> <code>{user_name}</code></p>
                                <p><?php echo __('E-mail:'); ?> <code>{user_email}</code></p>
                            </div>
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
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
			+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou as configura&ccedil;&otilde;es'); ?>'
			+ '</div>';
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	},'json');
}
</script>