<div class="grid-100">
	<div class="highlightedCont slackCont">
		<a href="https://prismslack.herokuapp.com/" target="_blank">
			<?php echo $this->Html->image('logo-slack@2x.png', array('class' => 'imgInline logo', 'alt' => 'Logo Slack')); ?>
			<br class="hide-on-desktop">
			<?php echo __('Join our Slack Channel'); ?>
		</a>
	</div>
</div>

<div class="installSteps">
	<div class="grid-100">
		<h2><?php echo __('Getting Started'); ?></h2>
	</div>
	
	<div class="grid-33 mobile-marginBottom40">
		<div class="marginBottom20">
			<strong>
				<span class="labelBlue"><?php echo __('Step'); ?> 1</span>
				<?php echo __('Install the Template Pack'); ?>
			</strong>
		</div>
		
		<?php echo $this->Html->image('install-step-1.jpg', array('class' => 'img-100 borderGrey boxShadow', 'alt' => __('Install the Template Pack'))); ?>
	</div>
	
	<div class="grid-33 mobile-marginBottom40">
		<div class="marginBottom20">
			<strong>
				<span class="labelBlue"><?php echo __('Step'); ?> 2</span>
				<?php echo __('Create a project'); ?>
			</strong>
		</div>
		
		<?php echo $this->Html->image('install-step-2.jpg', array('class' => 'img-100 borderGrey boxShadow', 'alt' => __('Create a project'))); ?>
	</div>
	
	<div class="grid-33 mobile-marginBottom40">
		<div class="marginBottom20">
			<strong>
				<span class="labelBlue"><?php echo __('Step'); ?> 3</span>
				<?php echo __('Run the code'); ?>
			</strong>
		</div>
		
		<?php echo $this->Html->image('install-step-3.jpg', array('class' => 'img-100 borderGrey boxShadow', 'alt' => __('Run the code'))); ?>
	</div>
	
	<div class="clear"></div>
</div>