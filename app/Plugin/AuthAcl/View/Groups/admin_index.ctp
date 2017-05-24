<div class="span12">      		
    <div class="widget action-table">
    	
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3><?php echo __('Usu&aacute;rios: Grupos'); ?></h3>
        </div> <!-- /widget-header -->
        
        <div class="widget-content">
            
            <div class="row-fluid show-grid" id="tab_user_manager">
                <div class="span12">
                    <ul class="nav nav-tabs">
                        <?php if ($this->Acl->check('Users','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Gerenciar usu&aacute;rios'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index'), array('escape' => false)); ?></li>
                        <?php } ?>
                        <?php if ($this->Acl->check('Groups','admin_index','AuthAcl') == true){?>
                            <li class="active"><?php echo $this->Html->link(__('Grupos'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
                        <?php }?>
                        <?php if ($this->Acl->check('Permissions','admin_index','AuthAcl') == true){?>
                            <li><?php echo $this->Html->link(__('Permiss&otilde;es'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index'), array('escape' => false)); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            
            <div class="row-fluid show-grid">
                <?php if ($this->Acl->check('Groups','admin_add','AuthAcl') == true){?>
                <div class="span12" style="text-align: right;">
                    <button class="btn btn-primary" type="button" onclick='formGroup();'>
                        <i class="icon-plus icon-white"></i>
                        <?php echo __('Grupo'); ?>
                    </button>
                </div>
                <?php } ?>
            </div>
            
            <br />
            
            <div class="row-fluid show-grid">
                <div class="span12">
                    <table class="table table-bordered table-hover list table-condensed table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('Nome'); ?></th>
                                <th><?php echo __('Criado em'); ?></th>
                                <th><?php echo __('Modificado em'); ?></th>
                                <?php if ($this->Acl->check('Groups','admin_edit','AuthAcl') == true || $this->Acl->check('Groups','admin_delete','AuthAcl') == true){?>
                                <th class="td-actions" style="width: 110px;"><?php echo __('A&ccedil;&otilde;es'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach ($groups as $group): ?>
                            <tr>
                                <td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
                                <td><?php echo date('d/m/y', strtotime($group['Group']['created'])); ?>&nbsp;</td>
                                <td><?php echo date('d/m/y', strtotime($group['Group']['modified'])); ?>&nbsp;</td>
                                
                                <?php if ($this->Acl->check('Groups','admin_edit','AuthAcl') == true || $this->Acl->check('Groups','admin_delete','AuthAcl') == true){?>
                                    <td class="td-actions">
										<?php if ($this->Acl->check('Groups','admin_edit','AuthAcl') == true){?>
                                            <?php echo $this->Acl->link('<i class="btn-icon-only icon-pencil"> </i>', false, array('class'=>'btn btn-small btn-success', 'onclick' =>"formGroup('".h($group['Group']['id'])."','".h($group['Group']['name'])."');return false;", 'escape' => false, 'title' => __('Editar'))); ?>
                                        <?php }?> 
                                        <?php if ($this->Acl->check('Groups','admin_delete','AuthAcl') == true){?>
                                            <?php echo $this->Acl->link('<i class="btn-icon-only icon-remove"> </i>', false, array('class'=>'btn btn-small btn-danger', 'onclick' =>"delGroup('".h($group['Group']['id'])."','".h($group['Group']['name'])."');return false;", 'escape' => false, 'title' => __('Excluir'))); ?>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->

<script>
	function delGroup(group_id,name) {
		$.sModal({
			image : '<?php echo $this->webroot; ?>img/icons/error.png',
			content : '<?php echo __('Tem certeza de que deseja excluir'); ?> <b>'+name+'</b>?',
			animate : 'fadeDown',
			buttons : [ {
				text : ' <?php echo __('Excluir'); ?> ',
				addClass : 'btn-danger',
				click : function(id, data) {
					$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'groups','action' => 'delete')); ?>/'+group_id,{},function(o){
						$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?>', function() {
                			$.sModal('close',id);
                		});
                	},'json');
				}
			}, {
				text : ' <?php echo __('Cancelar'); ?> ',
				click : function(id, data) {
					$.sModal('close', id);
				}
			} ]
		});
	}
	
	function formGroup(group_id,name){
		if (group_id == undefined){ 
			group_id = null;
			var header = "<?php echo __('Adicionar grupo'); ?>";
		}else{
			var header = "<?php echo __('Editar grupo'); ?>";
		};
		var idField = '';
		if (name == undefined){ 
			name = '';
		}else{
			idField = '<input type="hidden" name="data[Group][id]" value="'+group_id+'" />';
		}
		
		var mId = $.sModal({
            header:header,
            animate:'fadeDown',
            content : '<div id="group_error"></div> <form style="margin:0"> Nome<span style="color:red;">*</span> &nbsp; <input type="text" class="input-xlarge" value="'+name+'"  name="data[Group][name]"/>'+idField+'<form>',
            buttons:[
                {
                    text:'&nbsp; <?php echo __('Ok'); ?> &nbsp;',
                    addClass:'btn-primary',
                    click:function(id){
                    	if (group_id == null){
	                    	$.post('<?php echo Router::url(array('admin' => true, 'plugin' => 'auth_acl','controller' => 'groups','action' => 'add')); ?>',$('#'+id).find('form').serialize(),function(o){
	                    		if (o.error == 0){
		                    		$('#container').load('<?php echo $this->webroot; ?>admin/auth_acl/groups', function() {
		                    			$.sModal('close',id);
		                    		});
	                    		}else{
	                    			var str_error = '<div class="alert alert-error">'+
	                    	              '<button data-dismiss="alert" class="close" type="button">×</button>'+
	                    	              '<strong><?php echo __('Erro!'); ?></strong> '+o.error_message+
	                    	            '</div>'
	                    			$('#group_error').html(str_error);
	                    		}
	                    	},'json');
                    	}else{
                    		$.post('<?php echo Router::url(array('admin' => true, 'plugin' => 'auth_acl','controller' => 'groups','action' => 'edit')); ?>/'+group_id,$('#'+id).find('form').serialize(),function(o){
                    			if (o.error == 0){
	                    			$('#container').load('<?php echo $this->webroot; ?>admin/auth_acl/groups', function() {
		                    			$.sModal('close',id);
		                    		});
                    			}else{
                        			var str_error = '<div class="alert alert-error">'+
                        	              '<button data-dismiss="alert" class="close" type="button">&times;</button>'+
                        	              '<strong><?php echo __('Erro!'); ?></strong> '+o.error_message+
                        	            '</div>'
                        			$('#group_error').html(str_error);
                        		}
	                    	},'json');
                    	}
                        
                    }
                },
                {
                    text:' <?php echo __('Cancelar'); ?> ',
                    click:function(id,data){
                        $.sModal('close',id);
                    }
                }
            ]
        });
		
		$('#'+mId).find('input[type="text"]').each(function(){
			$(this).keypress(function(event){
				 if ( event.which == 13 ) {
				 	event.preventDefault();
				 }
			});
		});
	}
</script>