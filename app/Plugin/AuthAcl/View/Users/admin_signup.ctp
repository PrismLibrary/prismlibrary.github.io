<div class="account-container">
	<div class="content clearfix">
    	
    	<h1><?php echo __('Criar uma conta'); ?></h1>
        
        <?php if (!empty($errors)){ ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error){  ?>
                <div>
                    <strong><?php echo __('Erro!'); ?> </strong>
                    <?php echo h(implode('<br />', $error)); ?>
                </div>
            <?php } ?>
        </div>   
        <?php } ?>
        
        <?php echo $this->Form->create('User', array('action' => 'signup','class'=>'form-signin')); ?>
        <div class="control-group">
            <label class="control-label"><?php echo __('Nome'); ?></label>
            <div class="controls">
                <?php echo $this->Form->input('user_name',array('div' => false,'label'=>false,'placeholder'=>__('Nome'),'error'=>false,'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label"><?php echo __('E-mail'); ?> </label>
                <div class="controls">
                <?php echo $this->Form->input('user_email',array('div' => false,'label'=>false,'placeholder'=>__('E-mail'),'error'=>false,'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label"><?php echo __('Senha'); ?></label>
                <div class="controls">
                <?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'placeholder'=>__('Senha'),'error'=>false,'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label"><?php echo __('Confirme a senha'); ?></label>
                <div class="controls">
                <?php echo $this->Form->password('user_confirm_password',array('div' => false,'label'=>false,'placeholder'=>__('Confirme a senha'),'error'=>false,'class' => 'span4')); ?>
            </div>
        </div>

        <?php if (isset($general['Setting']) && (int)$general['Setting']['enable_recaptcha'] == 1){?>
            <div class="control-group">
                <label class="control-label">ReCaptcha</label>
                <div class="controls">
                    <?php echo $this->Form->hidden('recaptcha',array('value'=>'1')); ?>
                    
                    <script type="text/javascript">
                    var RecaptchaOptions = {
                        theme : 'white'
                    };
                    </script> 
                    
                    <?php 
                    $publickey = $general['Setting']['recaptcha_public_key'];
                    echo recaptcha_get_html($publickey, null);
                    ?>
                </div>
            </div>
        <?php }?>
        
        <button type="submit" class="btn btn-large btn-primary">
            <?php echo __('Criar minha conta'); ?>
        </button>
        
        <div style="padding-top:20px;">
            <label>
                <?php echo $this->Html->link(__('Tem uma conta? Clique para entrar.'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login')); ?>
            </label>
        </div>
        
        <?php echo $this->Form->end(); ?>
	</div>
</div>