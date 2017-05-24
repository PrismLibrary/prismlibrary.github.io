<!doctype html>
<html>
<head>
	<title><?php echo Configure::read('siteTitulo') ?></title>
</head>

<body>

<div style="width: 550px;">
	
	<div style="text-align: center">
		<p><img src="http://<?php echo Configure::read('siteURL') ?>/img/email/logo.jpg" /></p>
	</div>
	
	<div style="border: 1px solid #ccc; padding: 0px 20px 20px 20px; margin-bottom: 20px;">
		<?php echo $content_for_layout; ?>
	</div>
	
	<div style="text-align: center; font-size: 11px;">
		<?php echo $this->Html->link(Configure::read('siteURL'), 'http://' . Configure::read('siteURL'), array('target' => '_blank')); ?>
	</div>
	
</div>

</body>
</html>