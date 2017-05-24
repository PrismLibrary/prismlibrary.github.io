<div class="span12">      		
    <div class="widget">
    	
        <div class="widget-header">
            <i class="icon-plus"></i>
            <h3><?php echo __('Usu&aacute;rios: Cadastrar'); ?></h3>
        </div> <!-- /widget-header -->
		
        <div class="widget-content"> 
            <div class="row-fluid show-grid" id="tab_user_manager">
                <div class="span12">
                    <ul class="nav nav-tabs">
                        <?php if ($this->Acl->check('Users','admin_index','AuthAcl') == true){?>
                            <li class="active"><?php echo $this->Html->link(__('Gerenciar usu&aacute;rios'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index'), array('escape' => false)); ?></li>
                        <?php } ?>
                        <?php if ($this->Acl->check('Groups','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Grupos'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
                        <?php }?>
                        <?php if ($this->Acl->check('Permissions','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Permiss&otilde;es'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index'), array('escape' => false)); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row-fluid show-grid">
                <div class="span12">
                    <?php if (count($errors) > 0){ ?>
                    <div class="alert alert-error">
                        <button data-dismiss="alert" class="close" type="button">&times;</button>
                        <?php foreach($errors as $error){ ?>
                            <?php foreach($error as $er){ ?>
                                <strong><?php echo __('Erro!'); ?>
                                </strong>
                                <?php echo h($er); ?>
                                <br />
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    
                    <?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
                    
                    <div
                        class="control-group <?php if (array_key_exists('user_email', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('E-mail'); ?>
                            <span style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('user_email',array('div' => false,'label'=>false,'error'=>false)); ?>
                        </div>
                    </div>
                    <div
                        class="control-group <?php if (array_key_exists('user_password', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Senha'); ?>
                            <span style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'error'=>false)); ?>
                        </div>
                    </div>
                    <div
                        class="control-group <?php if (array_key_exists('user_confirm_password', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Confirme a senha'); ?>
                            <span style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->password('user_confirm_password',array('div' => false,'label'=>false,'error'=>false)); ?>
                        </div>
                    </div>
        
                    <div
                        class="control-group <?php if (array_key_exists('user_name', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Nome'); ?>
                            <span style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('user_name',array('div' => false,'label'=>false,'class' => 'input-xlarge','error'=>false)); ?>
                        </div>
                    </div>
        
                    <div class="control-group">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Grupos'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('Group',array('div' => false,'label'=>false,'empty' => ' ')); ?>
                        </div>
                    </div>
        
                    <div class="control-group">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Situa&ccedil;&atilde;o'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->checkbox('user_status',array('div' => false,'label'=>false)); ?>
                        </div>
                    </div>
        
                    <div class="form-actions">
                        <input
                            type="submit"
                            class="btn btn-primary"
                            value="<?php echo __('Salvar'); ?>" /> <input type="button"
                            class="btn" value="<?php echo __('Cancelar'); ?>"
                            onclick="cancel_add_user();" />
                    </div>
                    
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->

<script>
function cancel_add_user() {
	window.location = '<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?>';
}
</script>