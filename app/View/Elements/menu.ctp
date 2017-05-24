<menu>
	<ul>
		<li>
			<?php echo $this->Html->link(__('Home'), array('plugin' => false, 'controller' => 'pages', 'action' => 'home', 'language' => $current_language), array('escape' => false)); ?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Documentation'), array('plugin' => false, 'controller' => 'pages', 'action' => 'documentation', 'language' => $current_language)); ?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Learn'), array('plugin' => false, 'controller' => 'pages', 'action' => 'learn', 'language' => $current_language)); ?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Discuss'), array('plugin' => false, 'controller' => 'pages', 'action' => 'discuss', 'language' => $current_language)); ?>
		</li>
	</ul>
</menu>