<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($message === NULL){ ?>
	No messages in queue.
<?php }else{ ?>

<?php echo form::open(); ?>

Original Message: <?php echo $message[key($message)]['sms']; ?><br/>

Translation: <?php echo form::textarea('translation'); ?><br/>

<?php 
	
	echo form::hidden('id', key($message));
	echo form::hidden('form', 'update_translation');
	echo form::submit('submit', 'Send');

?>

<?php echo form::close(); ?>

<?php } ?>