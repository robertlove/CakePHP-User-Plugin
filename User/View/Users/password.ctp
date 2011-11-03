<div class="users form">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Reset Password'); ?></legend>
        <?php echo $this->Form->input('password'); ?>
        <?php echo $this->Form->input('confirm_password', array('type' => 'password')); ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Login'), array('action' => 'login')); ?></li>
    </ul>
</div>