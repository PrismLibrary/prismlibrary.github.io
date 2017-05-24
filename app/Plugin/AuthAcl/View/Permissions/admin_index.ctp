<div class="span12">
	<div class="widget action-table">
    	
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3><?php echo __('Usu&aacute;rios: Permiss&otilde;es de grupos'); ?></h3>
        </div> <!-- /widget-header -->
        
        <div class="widget-content">
            <div class="row-fluid show-grid" id="tab_user_manager">
                <div class="span12">
                    <ul class="nav nav-tabs">
                        <?php if ($this->Acl->check('Users','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Gerenciar usu&aacute;rios'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index'), array('escape' => false)); ?></li>
                        <?php } ?>
                        <?php if ($this->Acl->check('Groups','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Grupos'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
                        <?php }?>
                        <?php if ($this->Acl->check('Permissions','admin_index','AuthAcl') == true){?>
                            <li class="active"><?php echo $this->Html->link(__('Permiss&otilde;es'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index'), array('escape' => false)); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php if ($this->Acl->check('Permissions','admin_syncAco','AuthAcl') == true){?>
            <div class="row-fluid show-grid">
                <div class="span12">
                    <button class="btn btn-success" type="button" onclick="syncAco(this);">
                        <i class="icon-refresh icon-white"></i>
                        <?php echo __('Sincronizar Acos'); ?>
                    </button>
                </div>
            </div>
            <?php } ?>
            
            <br />
            
            <div class="row-fluid show-grid" id="permission_tab">
                <ul class="nav nav-tabs">
                    <?php if ($this->Acl->check('Permissions','admin_index','AuthAcl') == true){?>
                        <li class="active"><?php echo $this->Html->link(__('Permiss&otilde;es de grupos'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index'), array('escape' => false)); ?></li>
                    <?php }?>
                    <?php if ($this->Acl->check('Permissions','admin_user','AuthAcl') == true){?>
                        <li><?php echo $this->Html->link(__('Permiss&otilde;es de usu&aacute;rios'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'user'), array('escape' => false)); ?></li>
                    <?php } ?>
                </ul>
            </div>
            
            <div class="row-fluid show-grid">
                <div class="span12">
                    <div style="overflow: auto;">
                        <table class="table table-bordered table-hover list table-condensed table-striped" style="width: auto;">
                            <thead>
                                <tr>
                                    <th><?php echo __('A&ccedil;&otilde;es / Grupos'); ?></th>
                                    <?php foreach($groups as $group){ ?>
                                        <th><?php echo h($group); ?></th>
                                    <?php }	?>
                                </tr>
                            </thead>
                            <tr>
                                <td><?php echo __('Todos'); ?></td>
                                <?php foreach($groups as $groupId => $group){ ?>
                                <td style="text-align: center;">
                                    <?php if ($this->Acl->check('Permissions','admin_allowAll','AuthAcl') == true || $this->Acl->check('Permissions','admin_denyAll','AuthAcl')){?>
                                        <?php if ($this->Acl->check('Permissions','admin_allowAll','AuthAcl') == true){ ?>
                                            <a href="#" onclick="allowAll('<?php echo $groupId; ?> '); return false;">
                                                <img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
                                            </a>
                                        <?php }else{ ?>
                                            <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
                                        <?php } ?>
                                        
                                        &nbsp;
                                        
                                        <?php if ($this->Acl->check('Permissions','admin_denyAll','AuthAcl') == true){ ?>
                                            <a href="#" onclick="denyAll('<?php echo $groupId; ?> '); return false;">
                                                <img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
                                            </a>
                                        <?php }else{ ?>
                                            <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> &nbsp;
                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
                                    <?php } ?>
                                </td>
                                <?php }	?>
                            </tr>
        
                            <?php foreach($acoController as $name => $controller){ ?>
                                <?php if (!empty($controller['children'])){ ?>
                                    <?php foreach($controller['children']  as $action){ ?>
                                        <?php if ($action['Aco']['alias'] == 'isAuthorized') continue; ?>
                                        <tr>
                                            <td><?php echo $name; ?>-><?php echo h($action['Aco']['alias']); ?></td>
                                            <?php foreach($groups as $groupId => $group){ ?>
                                                <td>
                                                <?php if ($this->Acl->check('Permissions','admin_allow','AuthAcl') == true || $this->Acl->check('Permissions','admin_deny','AuthAcl')){?>
                                                    <?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
                                                    <?php if ($this->Acl->check('Permissions','admin_deny','AuthAcl') == true){?>
                                                        <a href="#" onclick="deny(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
                                                            <img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
                                                        </a> 
                                                        <?php }else{ ?>
                                                            <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <?php if ($this->Acl->check('Permissions','admin_allow','AuthAcl') == true){?>
                                                            <a href="#" onclick="allow(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
                                                                <img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
                                                            </a> 
                                                        <?php }else{?>
                                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
                                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
                                                    <?php }else{ ?> 
                                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
                                                    <?php } ?>
                                                <?php } ?>
                                                </td>
                                            <?php }	?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            
                            <?php foreach($acoPlugin as $pluginName => $controllers){ ?>
                                <tr>
                                    <td colspan="<?php echo (count($groups)+1); ?>" style="background-color: #E6E6E6; color: #333333;">
                                        <strong>Plugin<?php echo $pluginName; ?></strong>
                                    </td>
                                </tr>
                                <?php if (!empty($controllers['children'])){ ?>
                                    <?php foreach($controllers['children'] as $name => $controller){ ?>
                                        <?php if ($controller['Aco']['alias'] == 'AccessDenied') continue; ?>
                                        <?php if (!empty($controller['children'])){ ?>
                                            <?php foreach($controller['children']  as $action){ ?>
                                                <?php if ($action['Aco']['alias'] == 'isAuthorized') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'login') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'logout') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'signup') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'activate') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'editAccount') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'resetPassword') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'signupcomplete') continue; ?>
                                                <?php if ($action['Aco']['alias'] == 'activecomplete') continue; ?>
                                                <tr>
                                                    <td><?php echo h($controller['Aco']['alias']); ?>-><?php echo h($action['Aco']['alias']); ?></td>
                                                    <?php foreach($groups as $groupId => $group){ ?>
                                                        <td style="text-align: center;"><?php if ($this->Acl->check('Permissions','admin_allow','AuthAcl') == true || $this->Acl->check('Permissions','admin_deny','AuthAcl')){?>
                                                        <?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
                                                        <?php if ($this->Acl->check('Permissions','admin_deny','AuthAcl') == true){?>
                                                            <a href="#" onclick="deny(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
                                                                <img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
                                                            </a>
                                                            <?php }else{ ?>
                                                                <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
                                                            <?php } ?>
                                                        <?php }else{ ?> 
                                                            <?php if ($this->Acl->check('Permissions','admin_allow','AuthAcl') == true){?>
                                                                <a href="#" onclick="allow(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
                                                                    <img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
                                                                </a>
                                                            <?php }else{ ?>
                                                                <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php } else{ ?>
                                                            <?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
                                                                <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
                                                            <?php }else{ ?>
                                                                <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </td>
                                                    <?php }	?>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->


<script>
function allow(obj, group_id, action_id) {
	$("#container  table").mask("<?php echo __('Aguarde...') ?>");
	var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
		+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
		+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou a permiss&atilde;o'); ?>'
		+ '</div>';
	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'allow')); ?>', {
		data : {
			groupId : group_id,
			actionId : action_id
		}
	}, function(o) {
		$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	}, 'json');
}

function allowAll(group_id){
	$("#container  table").mask("<?php echo __('Aguarde...') ?>");
	var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
		+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
		+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou a permiss&atilde;o'); ?>'
		+ '</div>';
	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'allowAll')); ?>', {
		data : {
			groupId : group_id,
		}
	}, function(o) {
		$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	}, 'json');
}

function deny(obj, group_id, action_id) {
	$("#container  table").mask("<?php echo __('Aguarde...') ?>");
	var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
		+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
		+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou a permiss&atilde;o'); ?>'
		+ '</div>';
	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'deny')); ?>', {
		data : {
			groupId : group_id,
			actionId : action_id
		}
	}, function(o) {
		$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	}, 'json');
}

function denyAll(group_id){
	$("#container  table").mask("<?php echo __('Aguarde...') ?>");
	var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
		+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
		+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou a permiss&atilde;o'); ?>'
		+ '</div>';
	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'denyAll')); ?>', {
		data : {
			groupId : group_id,
		}
	}, function(o) {
		$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	}, 'json');
}

function syncAco(obj) {
	$("#container  table").mask("<?php echo __('Aguarde...') ?>");
	var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
		+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
		+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; sincronizou o Acos'); ?>'
		+ '</div>';
	$(obj).attr('disabled','disabled');
	$(obj).html('<i class="icon-refresh icon-white icon-spin"></i> <?php echo __('Sincronizando Acos...'); ?>');
	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'syncAco')); ?>',{},function() {
		$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
		var alertSuccess = $(strAlertSuccess).appendTo(
				'body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	}, 'json');
}
$(document).ready(function(){
	$('#permission_tab').find('a').each(function() {
		$(this).click(function() {
			removeUserSearchCookie();
		});
	});
});
</script>