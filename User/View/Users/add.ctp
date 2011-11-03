<div class="users form">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Sign Up'); ?></legend>
        <?php echo $this->Form->input('first_name'); ?>
        <?php echo $this->Form->input('last_name'); ?>
        <?php echo $this->Form->input('email'); ?>
    </fieldset>
    <?php echo $this->Form->end(__('Sign Up'));?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Login'), array('action' => 'login')); ?></li>
    </ul>
</div>