<div class="span12">      		
    <div class="widget">
    	
        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3><?php echo __('Editar conta') ?></h3>
        </div> <!-- /widget-header -->
        
        <div class="widget-content">
        	
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
                    
                    <div class="control-group <?php if (array_key_exists('user_email', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('E-mail'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('user_email',array('div' => false,'label'=>false,'error'=>false,'readonly'=>'readonly')); ?>
                        </div>
                    </div>
                    
                    <div class="control-group <?php if (array_key_exists('user_password', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Senha'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'error'=>false)); ?>
                        </div>
                    </div>
                    
                    <div class="control-group <?php if (array_key_exists('user_confirm_password', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Confirme a senha'); ?>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->password('user_confirm_password',array('div' => false,'label'=>false,'error'=>false)); ?>
                        </div>
                    </div>
        
                    <div class="control-group <?php if (array_key_exists('user_name', $errors)){ echo 'error'; } ?>">
                        <label for="inputEmail" class="control-label">
                            <?php echo __('Nome'); ?>
                            <span style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('user_name',array('div' => false,'label'=>false,'class' => 'input-xlarge','error'=>false)); ?>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="<?php echo __('Salvar'); ?>" />
                    </div>
                    
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div> <!-- /span12 -->