<div class="grid-100">
    <h1>
        <?php echo $name; ?>
    </h1>
</div>

<div class="grid-100">
    <p>
        <strong><?php echo __d('cake', 'Error'); ?>: </strong>
        <?php printf(
            __d('cake', 'The requested address %s was not found on this server.'),
            "<strong>'{$url}'</strong>"
        ); ?>
    </p>
    
    <?php
    if (Configure::read('debug') > 0 ) {
        echo $this->element('exception_stack_trace');
    }
    ?>
</div>