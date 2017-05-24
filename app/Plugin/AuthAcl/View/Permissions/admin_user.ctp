<?php $this->Paginator->options(array('url' => $passArg)); ?>

<div class="span12">
	<div class="widget action-table">
    	
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3><?php echo __('Usu&aacute;rios: Permiss&otilde;es de usu&aacute;rios'); ?></h3>
        </div> <!-- /widget-header -->
        
        <div class="widget-content">
            <div class="row-fluid show-grid" id="tab_user_manager">
                <div class="span12">
                    <ul class="nav nav-tabs">
                        <?php if ($this->Acl->check('Users','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Gerenciar usu&aacute;rio'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index'), array('escape' => false)); ?></li>
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
            <div class="row-fluid show-grid">
                <div class="span12">
                    <button class="btn btn-success" type="button" onclick="syncAco(this);">
                        <i class="icon-refresh icon-white"></i>
                        <?php echo __('Sincronizar Acos'); ?>
                    </button>
                </div>
            </div>
            <br />
            <div class="row-fluid show-grid" id="permission_tab">
                <ul class="nav nav-tabs">
                    <?php if ($this->Acl->check('Permissions','admin_index','AuthAcl') == true){?>
                        <li><?php echo $this->Html->link(__('Permiss&otilde;es de grupos'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index'), array('escape' => false)); ?></li>
                    <?php }?>
                    <?php if ($this->Acl->check('Permissions','admin_user','AuthAcl') == true){?>
                        <li class="active"><?php echo $this->Html->link(__('Permiss&otilde;es de usu&aacute;rios'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'user'), array('escape' => false)); ?></li>
                    <?php } ?>
                </ul>
            </div>
        
            <?php echo $this->Form->create('Permission', array('action' => 'user','class'=>' form-signin form-horizontal')); ?>
            <div class="row-fluid show-grid">
                <div class="span12">
                    <div class="input-append">
                        <?php echo $this->Form->input('filter',array('div' => false,'label'=>false,'placeholder'=>__('Procurar usu&aacute;rios'),'class'=>'input-xlarge','escape' => false)); ?>
                        <button class="btn" type="submit">
                            <?php echo __('Procurar'); ?>
                        </button>
                        <button class="btn" type="button" onclick="cancelSearch();">
                            <i class="icon-remove-sign" style="height: 17px;"></i>
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
                                <th style="text-align: center; width: 30px;"><?php echo $this->Paginator->sort('id',__('ID')); ?></th>
                                <th style="text-align: center; width: 300px;"><?php echo $this->Paginator->sort('user_email',__('E-mail')); ?></th>
                                <th style="text-align: center;"><?php echo $this->Paginator->sort('user_name',__('Nome completo')); ?></th>
                                <th style="text-align: center; width: 150px;"><?php echo $this->Paginator->sort('created',__('Criado')); ?></th>
                                <?php if ($this->Acl->check('Permissions','admin_userPermission','AuthAcl') == true){?>
                                    <th style="text-align: center; width: 80px;"><?php echo __('A&ccedil;&otilde;es'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td style="text-align: center;"><?php echo h($user['User']['id']); ?>&nbsp;</td>
                                <td><?php echo h($user['User']['user_email']); ?>&nbsp;</td>
                                <td><?php echo h($user['User']['user_name']); ?>&nbsp;</td>
                                <td style="text-align: center;"><?php echo h($user['User']['created']); ?>&nbsp;</td>
                                <?php if ($this->Acl->check('Permissions','admin_userPermission','AuthAcl') == true){?>
                                    <td style="text-align: center;">
                                        <?php echo $this->Html->link(__('Permiss&otilde;es'), array('action' => 'userPermission', $user['User']['id']),array('class'=>'btn btn-mini btn-info', 'escape' => false)); ?>
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
                        /* echo $this->Paginator->counter(array(
                            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                        )); */
                        ?>
                    </p>
        
                    <div class="pagination">
                        <ul>
                            <?php echo $this->Paginator->prev('&larr; ' . __('anterior'),
                                    array('tag' => 'li','escape' => false)); echo
                                    $this->Paginator->numbers(array('separator' => '','tag'=>'li')); echo
                            $this->Paginator->next(__('pr&oacute;xima') . ' &rarr;', array('tag' => 'li','escape' => false)); ?>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->

<script>
function syncAco(obj) {
	$("#container  table").mask("<?php echo __('Aguarde...') ?>");
	var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:20px; top:20px; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">&times;</button>'
			+ '<strong><?php echo __('Successo!'); ?></strong> <?php echo __('Voc&ecirc; sincronizou o Acos'); ?>'
			+ '</div>';
	$(obj).attr('disabled','disabled');
	$(obj).html('<i class="icon-refresh icon-white icon-spin"></i> <?php echo __('Sincronizando Acos...'); ?>');
	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'syncAco')); ?>',{},function() {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'user')); ?>');
			var alertSuccess = $(strAlertSuccess).appendTo(
					'body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
}

function cancelSearch(){
	removeUserSearchCookie();
	window.location = '<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'user')); ?>';
}

$(document).ready(function() {
	
	$('#permission_tab').find('a').each(function() {
		$(this).click(function() {
			removeUserSearchCookie();
		});
	});
	
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