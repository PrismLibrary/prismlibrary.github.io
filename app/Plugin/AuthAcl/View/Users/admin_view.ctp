<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="span12">
	<div class="widget action-table">
        
        <div class="widget-header">
            <i class="icon-eye-open"></i>
            <h3><?php echo __('Usu&aacute;rios: Ver'); ?></h3>
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
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('E-mail'); ?>
                            </label>
                            <div class="controls">
                                <?php echo h($user['User']['user_email']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('Senha'); ?>
                            </label>
                            <div class="controls">******</div>
                        </div>
        
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('Nome'); ?>
                            </label>
                            <div class="controls">
                                <?php echo h($user['User']['user_name']); ?>
                            </div>
                        </div>
        
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('Grupos'); ?>
                            </label>
                            <div class="controls">
                            <?php
                            $groupNames = array();
                            if (!empty($user['Group'])){
                                foreach($user['Group'] as $group){
                                    $groupNames[] = $group['name'];
                                }
                            }
                            echo implode(',',$groupNames);
                            ?>
                            </div>
                        </div>
        
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('Situa&ccedil;&atilde;o'); ?>
                            </label>
                            <div class="controls">
                                <?php if ((int) $user['User']['user_status'] == 0) { ?>
                                    <img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
                                <?php } else { ?>
                                    <img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
                                <?php } ?>
                            </div>
                        </div>
        
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('Criado'); ?>
                            </label>
                            <div class="controls">
                                <?php echo h($user['User']['created']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="inputEmail" class="control-label">
                                <?php echo __('Modificado'); ?>
                            </label>
                            <div class="controls">
                                <?php echo h($user['User']['modified']); ?>
                            </div>
                        </div>
        
                        <div class="form-actions">
                            <?php echo $this->Acl->link(__('Editar'), array('action' => 'admin_edit', $user['User']['id']),array('class'=>'btn  btn-primary')); ?>
                            <a class="btn " onclick="cancel_add_user();">
                                <?php echo __('Cancelar'); ?>
                            </a>
                        </div>
                    </form>
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