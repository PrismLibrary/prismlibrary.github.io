<?php $this->Paginator->options(array('url' => $passArg)); ?>

<div class="span12">
	<div class="widget action-table">
    	
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3><?php echo __('Usu&aacute;rios'); ?></h3>
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
                <?php if ($this->Acl->check('Users','admin_add','AuthAcl') == true){?>
                <div class="span12" style="text-align: right;">
                    <button class="btn btn-primary" type="button" onclick="showAddUserPage();">
                        <i class="icon-plus icon-white"></i>
                        <?php echo __('Usu&aacute;rio'); ?>
                    </button>
                </div>
                <?php }?>
            </div>
            
            <?php echo $this->Form->create('User', array('action' => 'index','class'=>' form-signin form-horizontal')); ?>
            
            <div class="row-fluid show-grid hidden-phone">
                <div class="span12">
                    <div class="input-append">
                        <?php echo $this->Form->input('filter',array('div' => false,'label'=>false,'placeholder'=>__('Procurar usu&aacute;rios'),'class'=>'input-xlarge', 'escape' => false)); ?>
                        <button class="btn" type="submit">
                            <?php echo __('Procurar'); ?>
                        </button>
                        <button class="btn" type="button" onclick="cancelSearch();">
                            <i class="icon-remove-sign"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <?php echo $this->Form->end(); ?>
            
            <div class="row-fluid show-grid">
                <div class="span12">
                    <table class="table table-bordered table-hover list table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $this->Paginator->sort('user_name',__('Nome')); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('user_email',__('E-mail')); ?>
                                </th>
                                <th>
                                    <?php echo __('Grupos'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('user_status',__('Situa&ccedil;&atilde;o'), array('escape' => false)); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('created',__('Criado em')); ?>
                                </th>
                                
                                <?php if ($this->Acl->check('Users','admin_view','AuthAcl') == true || $this->Acl->check('Users','admin_edit','AuthAcl') == true || $this->Acl->check('Users','admin_delete','AuthAcl') == true) { ?>
                                <th class="td-actions" style="width: 110px;">
                                    <?php echo __('A&ccedil;&otilde;es'); ?>
                                </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo h($user['User']['user_name']); ?>&nbsp;</td>
                                <td><?php echo h($user['User']['user_email']); ?>&nbsp;</td>
                                <td>
                                    <?php
                                    $groupNames = array();
                                    if (!empty($user['Group'])){
                                        foreach($user['Group'] as $group){
                                            $groupNames[] = $group['name'];
                                        }
                                    }
                                    echo implode(',',$groupNames);
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($this->Acl->check('Users','admin_changeStatus','AuthAcl') == true){?>
                                        <?php if ($auth_user['id'] != $user['User']['id']){?> 
                                            <a href="#" onclick="changeStatus(this,'<?php echo h($user['User']['id']); ?>',0); return false;" id="status_allowed_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 0){ ?> style="display: none;" <?php } ?>>
                                                <img src="<?php echo $this->webroot; ?>img/icons/allowed.png" /> 
                                            </a>
                                            <a href="#" onclick="changeStatus(this,'<?php echo h($user['User']['id']); ?>',1); return false;" id="status_denied_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 1){ ?> style="display: none;" <?php } ?>>
                                                <img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
                                            </a>
                                        <?php }else{ ?> 
                                            <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> 
                                        <?php } ?>
                                    <?php }else{ ?> 
                                        <a id="status_allowed_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 0){ ?> style="display: none;" <?php } ?>>
                                            <img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> 
                                        </a>
                                        <a id="status_denied_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 1){ ?> style="display: none;" <?php } ?>>
                                            <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" /> 
                                        </a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/y', strtotime($user['User']['created'])); ?>&nbsp;
                                </td>
                                <?php if ($this->Acl->check('Users','admin_view','AuthAcl') == true || $this->Acl->check('Users','admin_edit','AuthAcl') == true || $this->Acl->check('Users','admin_delete','AuthAcl') == true){?>
                                <td class="td-actions">
                                    <?php echo $this->Acl->link('<i class="btn-icon-only icon-eye-open"> </i>', array('action' => 'admin_view', $user['User']['id']),array('title' => __('Ver'), 'class'=>'btn btn-small', 'escape' => false)); ?>
									<?php echo $this->Acl->link('<i class="btn-icon-only icon-pencil"> </i>', array('action' => 'admin_edit', $user['User']['id']),array('title' => __('Editar'), 'class'=>'btn btn-small btn-success', 'escape' => false)); ?>
                                    <?php  if ($auth_user['id'] != $user['User']['id']){?>
                                        <?php echo $this->Acl->link('<i class="btn-icon-only icon-remove"> </i>', array('action' => 'admin_delete', $user['User']['id']),array('class'=>'btn btn-small btn-danger', 'onclick' =>"delUser('".h($user['User']['id'])."','".h($user['User']['user_email'])."');return false;", 'escape' => false)); ?>
                                    <?php } else { ?> 
                                        <?php if ($this->Acl->check('Users','admin_delete','AuthAcl') == true){?>
                                            <?php echo $this->Acl->link('<i class="btn-icon-only icon-remove"> </i>', array(),array('class'=>'btn btn-danger btn-small disabled','onclick'=>'return false;', 'title' => __('Voc&ecirc; n&atilde;o pode excluir'), 'escape' => false)); ?>
                                        <?php } ?> 
                                    <?php }?>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>
                        <?php
                        echo $this->Paginator->counter(array(
                            'format' => __('P&aacute;gina {:page} de {:pages}')
                        ));
                        /*echo $this->Paginator->counter(array(
                            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                        ));*/
                        ?>
                    </p>
        
                    <div class="pagination">
                        <ul>
                            <?php
                            echo $this->Paginator->prev('&larr; ' . __('anterior'), array('tag' => 'li','escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '','tag'=>'li'));
                            echo $this->Paginator->next(__('pr&oacute;xima') . ' &rarr;', array('tag' => 'li','escape' => false));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->

<script>
	function cancelSearch(){
		removeUserSearchCookie();
		window.location = '<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?>';
	}
	function delUser(user_id, email) {
	    $.sModal({
	        image: '<?php echo $this->webroot; ?>img/icons/error.png',
	        content: '<?php echo __('Tem certeza de que deseja excluir'); ?>  <b>' + email + '</b>?',
	        animate: 'fadeDown',
	        buttons: [{
	            text: ' <?php echo __('Excluir'); ?> ',
	            addClass: 'btn-danger',
	            click: function(id, data) {
	                $.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'delete')); ?>/' + user_id, {}, function(o) {
	                    $('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'index'));  ?>', function() {
	                        $.sModal('close', id);
	                        $('#tab_user_manager').find('a').each(function(){
	                    		$(this).click(function(){
	                    			removeUserSearchCookie();
	                    		});
	                    	});
	                    });
	                }, 'json');
	            }
	        }, {
	            text: ' <?php echo __('Cancelar'); ?> ',
	            click: function(id, data) {
	                $.sModal('close', id);
	            }
	        }]
	        });
	}
	function changeStatus(obj,user_id,status){
		$("#container table").mask("<?php echo __('Aguarde...') ?>");
		if (status == undefined){
			status = 0;
		}
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'changeStatus')); ?>',{data:{User:{id:user_id,user_status:status}}},function(o){
			if (status == 0){
				$('#status_allowed_'+user_id).hide();
				$('#status_denied_'+user_id).show();
			}else{
				$('#status_allowed_'+user_id).show();
				$('#status_denied_'+user_id).hide();
			}
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
				+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; alterou a situa&ccedil;&atilde;o do usu&aacute;rio'); ?>' + '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
			$("#container  table").unmask();
		},'json');
	}
	function showAddUserPage() {
		window.location = "<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'add')); ?>";
	}
	$(document).ready(function() {
		$('.pagination > ul > li').each(function() {
			if ($(this).children('a').length <= 0) {
				var tmp = $(this).html();
				if ($(this).hasClass('prev')) {
					$(this).addClass('disabled');
				} else if ($(this).hasClass('next')) {
					$(this).addClass('disabled');
				} else {
					$(this).addClass('active');
				}
				$(this).html($('<a></a>').append(tmp));
			}
		});
	});
</script>