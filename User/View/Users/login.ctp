<?php echo $this->Session->flash('auth'); ?>
<div class="users form">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Login'); ?></legend>
        <?php echo $this->Form->input('email'); ?>
        <?php echo $this->Form->input('password'); ?>
    </fieldset>
    <?php echo $this->Form->end(__('Login'));?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Sign Up'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('Forgot Password'), array('action' => 'forgot')); ?></li>
    </ul>
</div>