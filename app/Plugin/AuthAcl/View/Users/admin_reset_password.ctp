<div class="account-container">
	<div class="content clearfix">
    	
    	<h1><?php echo __('Recuperar senha'); ?></h1>
        
        <?php if (count($errors) > 0){ ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error){ ?>
                <?php foreach($error as $er){ ?>
                    <strong><?php echo __('Erro!'); ?> </strong>
                    <?php echo h($er); ?>
                    <br />
                <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
        
        <?php echo $this->Form->create('User', array('action' => 'resetPassword/'.$code)); ?>
            <input type="hidden" name="data[User][code]" value="<?php echo h($code); ?>" />
            <div class="control-group">
                <label for="inputEmail" class="control-label"><?php echo __('Nova senha'); ?></label>
                <div class="controls">
                    <?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'placeholder'=>__('Nova senha'),'class' => 'span4')); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputPassword" class="control-label"><?php echo __('Confirme a senha'); ?></label>
                <div class="controls">
                    <?php echo $this->Form->password('user_confirm_password',array('div' => false,'label'=>false,'placeholder'=>__('Confirme a senha'),'class' => 'span4')); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit"><?php echo __('Enviar'); ?></button>
                </div>
            </div>

        <?php echo $this->Form->end(); ?>
	</div>
</div>