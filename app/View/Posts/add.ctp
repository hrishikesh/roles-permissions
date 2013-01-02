<?php
/**
 *@var $this View
 */
?>
<div class="posts form">
    <?php echo $this->Form->create('Post'); ?>
    <fieldset>
    <legend><?php echo __('Add Post'); ?></legend>
        <?php echo $this->Form->input('title');?>
        <?php echo $this->Form->input('body', array('rows' => '3'));?>
        <?php echo $this->Form->submit(__('Save Post'), array('class'=>'btn btn-primary'))?>
    </fieldset>
    <?php echo $this->Form->end();?>
</div>