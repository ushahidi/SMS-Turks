<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo form::open(); ?>

Original Message: <?php echo $message[key($message)]['sms']; ?><br/>

Translation: <?php echo form::textarea('translation'); ?><br/>

<?php echo form::submit('submit', 'Send'); ?>

<?php echo form::close(); ?>