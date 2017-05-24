<div class="aboveFooter">
	<div class="grid-container">
		
		<div class="grid-45 suffix-5">
			<h2 class="white">
				<a href="https://visualstudiogallery.msdn.microsoft.com/e7b6bde2-ba59-43dd-9d14-58409940ffa0" target="_blank">
					<?php echo __('Prism Template Pack'); ?>
				</a>
			</h2>
			
			<a href="https://visualstudiogallery.msdn.microsoft.com/e7b6bde2-ba59-43dd-9d14-58409940ffa0" target="_blank">
				<?php echo $this->Html->image('screenshot-prism-template-pack@2x.jpg', array('class' => 'img-100 boxShadow', 'alt' => __('Prism Template Pack'))); ?>
			</a>
			
			<p class="marginTop20">
				<?php echo __('The Prism Template Pack is available on the <a href="https://visualstudiogallery.msdn.microsoft.com/e7b6bde2-ba59-43dd-9d14-58409940ffa0" target="_blank">Visual Studio Gallery</a>. To install, just go to Visual Studio -> Tools -> Extensions and Updates. Then search for Prism in the online gallery:'); ?>
			</p>
		</div>
		
		<div class="grid-45 suffix-5">
			<h2 class="white">
				<?php echo $this->Html->link(__('Learn'), array('plugin' => false, 'controller' => 'pages', 'action' => 'learn')); ?>
			</h2>
			
			<a href="<?php echo $this->Html->url(array('plugin' => false, 'controller' => 'pages', 'action' => 'learn')); ?>">
				<?php echo $this->Html->image('banner-pluralsight@2x.jpg', array('class' => 'img-100 boxShadow', 'alt' => __('Learn'))); ?>
			</a>
			
			<p class="marginTop20"><?php echo $this->Html->link(__('Watch videos and check out our Pluralsight courses.'), array('plugin' => false, 'controller' => 'pages', 'action' => 'learn')); ?></p>
		</div>
		
		<div class="clear"></div>
	</div>
</div>