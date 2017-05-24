<?php
$titleDescription = Configure::read('siteTitle');

if ($title_for_layout != '') {
	$titleDescription .= ' | ';
}

if (!isset($subtitle_for_layout)) {
	$subtitle_for_layout = '';
}
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<meta http-equiv="expires" content="0" />
	<meta name="description" content="<?php echo __(''); ?>" />
	<meta name="language" content="EN" />
	<meta name="author" content="Rian Design" />
	<meta name="copyright" content="&copy;<?php echo date('Y') ?> <?php echo Configure::read('siteTitle'); ?>" />
	<meta name="robots" content="index, follow" />
	<meta name="revisit-after" content="7 days" />
	<meta name="reply-to" content="contato@riandesign.com.br" />
	<meta name="rating" content="general" />
	<meta name="keywords" content="" />
	
	<title>
		<?php
		echo $titleDescription;
		echo $subtitle_for_layout;
		echo $title_for_layout;
		?>
	</title>
    
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800" rel="stylesheet">
    
	<?php echo $this->Html->meta('icon'); ?>
    
    <!--[if lt IE 9]>
        <?php echo $this->Html->script('html5.js'); ?>
    <![endif]-->
    
    <!--[if (gt IE 8) | (IEMobile)]><!-->
        <?php echo $this->Html->css('unsemantic-grid-responsive'); ?>
    <!--<![endif]-->
    
    <!--[if (lt IE 9) & (!IEMobile)]>
		<?php
        echo $this->Html->css('ie');
        echo $this->Html->css('ie-styles');
        ?>
    <![endif]-->
    
    <?php
	echo $this->Html->css('default');
	echo $this->Html->css('styles');
	echo $this->Html->css('styles-menu-mobile');
	
	echo $this->Html->script('jquery-1.11.0.min.js');
	
	// Popup images plugin
	echo $this->Html->script('magnific-popup/jquery.magnific-popup.js');
	echo $this->Html->css('/js/magnific-popup/magnific-popup.css');
	
	echo $scripts_for_layout;
	?>    
</head>
<body>


<script>
$(document).ready(function(){
	
	// Mobile menu
	$('.menu-anchor').on('click touchstart', function(e){
		$('html').toggleClass('menu-active');
	  	e.preventDefault();
	});
	
})
</script>

<!-- Mobile menu -->
<div class="hide-on-desktop">
	<div class="menuMobile">
		<?php echo $this->Element('menu'); ?>
	</div>
</div>


<header>
	<div class="grid-container">
		<div class="grid-100">
			<div class="positionRelative">
				
				<!-- Mobile menu anchor -->
				<span class="menu-anchor"></span>
				
				<!-- Languages flags -->
				<div class="languageFlags">
					<ul>
						<li>
							<a href="<?php echo $this->Html->url(array('plugin' => false, 'controller' => 'pages', 'action' => 'home', 'language' => 'jp')); ?>" title="日本語 (Japanese)">
								<?php echo $this->Html->image('icon-language-jp@2x.jpg', array('alt' => '日本語')); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo $this->Html->url(array('plugin' => false, 'controller' => 'pages', 'action' => 'home', 'language' => 'en')); ?>" title="English">
								<?php echo $this->Html->image('icon-language-en@2x.jpg', array('alt' => 'English')); ?>
							</a>
						</li>
					</ul>
				</div>
				
				<!-- Prism logo -->
				<div class="logo">
					<div class="hide-on-mobile">
						<?php
						echo $this->Html->link(
							$this->Html->image('logo-prism-symbol@2x.png', array('alt' => 'Prism Library')),
							array('plugin' => false, 'controller' => 'pages', 'action' => 'home', 'language' => $current_language),
							array('escape' => false, 'title' => __('Go to Home'))
						);
						?>
					</div>
					<div class="hide-on-desktop">
						<?php
						echo $this->Html->link(
							$this->Html->image('logo-prism@2x.png', array('alt' => 'Prism Library')),
							array('plugin' => false, 'controller' => 'pages', 'action' => 'home', 'language' => $current_language),
							array('escape' => false, 'title' => __('Go to Home'))
						);
						?>
					</div>
				</div>
				
				<!-- Desktop nav -->
				<div class="menuDesktop hide-on-mobile">
					<?php echo $this->Element('menu'); ?>
				</div>
				
				<div class="clear"></div>
			</div>
		</div>
	</div>
</header>


<main>
	
	<?php
	if (!$this->params['plugin'] && $this->params['controller'] == 'pages' && $this->params['action'] == 'home') :
	?>
		<div class="welcomeCont">
			<div class="grid-container">
				<div class="grid-100 textAlignCenter">
					<?php echo $this->Html->image('logo-prism@2x.png', array('class' => 'logo hide-on-mobile', 'alt' => 'Prism Library')); ?>

					<div class="fontSize16 grey999 marginTop40 marginBottom40">
						<strong><?php echo __('Build easily applications in WPF, Windows 10 UWP and Xamarin Forms.'); ?></strong>
					</div>

					<div class="marginBottom60">
						<a href="https://github.com/PrismLibrary/Prism" class="linkBox linkBoxGitHub" target="_blank">
							<span><?php echo __('View on GitHub'); ?></span>
						</a>
						<a href="<?php echo $this->Html->url(array('action' => 'documentation')); ?>" class="linkBox linkBoxDocumentation">
							<span><?php echo __('Documentation'); ?></span>
						</a>
					</div>
				</div>
			</div>

			<div style="border-top:  1px solid #dedede; padding-top:  40px">
				<div class="grid-container">
					<div>
						<div class="grid-40 prefix-10">
							<?php echo __("<strong>Prism is a framework for building loosely coupled, maintainable, and testable XAML applications in WPF, Windows 10 UWP, and Xamarin Forms.</strong> Separate releases are available for each platform and those will be developed on independent timelines. Prism provides an implementation of a collection of design patterns that are helpful in writing well-structured and maintainable XAML applications, including MVVM, dependency injection, commands, EventAggregator, and others. Prism's core functionality is a shared code base in a Portable Class Library targeting these platforms."); ?>
						</div>

						<div class="grid-40 suffix-10">
							<br class="hide-on-desktop">
							<?php echo __("Those things that need to be platform specific are implemented in the respective libraries for the target platform. Prism also provides great integration of these patterns with the target platform. For example, Prism for UWP and Xamarin Forms allows you to use an abstraction for navigation that is unit testable, but that layers on top of the platform concepts and APIs for navigation so that you can fully leverage what the platform itself has to offer, but done in the MVVM way."); ?>
						</div>

						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
	<?php
	endif;
	?>

	<!-- Main content -->
	<div class="grid-container">        
		<?php
		echo $this->Session->flash();
		echo $content_for_layout;
		?>
	</div>
	
	
	<?php
	echo $this->Element('above_footer_content');
	?>
	
</main>


<!-- Footer -->
<footer>
	<div class="grid-container">
		<div class="grid-60">
			<div class="info">
				<?php echo $this->Html->image('logo-prism-grey@2x.png', array('class' => 'logo', 'alt' => __('Logo'))); ?>
				<Strong><?php echo __('Prism Library'); ?></Strong><br>
				<?php echo __('This project is part of the'); ?>
				<a href="http://www.dotnetfoundation.org/projects" target="_blank"><?php echo __('.NET Foundation'); ?></a>.
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="grid-40 RianDesign">
			<div class="hide-on-mobile">
				<a href="http://riandesign.com.br/en" target="_blank" title="Rian Design">
					<?php echo $this->Html->image('logo-rian-design@2x.png', array('alt' => 'Rian Design')); ?>
				</a>
			</div>
			<div class="hide-on-desktop">
				<a href="http://riandesign.com.br/en" target="_blank" title="Rian Design">
					Rian Design
				</a>
			</div>
		</div>
	</div>
</footer>


</body>
</html>