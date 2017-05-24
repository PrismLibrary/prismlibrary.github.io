<div class="grid-100">
    <h1>
        <?php echo $name; ?>
    </h1>
</div>

<div class="grid-100">
	<p>
        <strong><?php echo __d('cake', 'Error'); ?>: </strong>
        <?php echo __d('cake', 'An Internal Error Has Occurred.'); ?>
    </p>
    
    <?php
    if (Configure::read('debug') > 0 ) {
        echo $this->element('exception_stack_trace');
    }
    ?>
</div>