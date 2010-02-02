<div id="side-bar">
	<a href="search_post.php"><div class="button">Homepage</div></a>
	
	<!--
	<br><br>
	<a href="add_record.php"><div class="button"><?php pmsg('Add Record'); ?></div></a>
	-->
	
	<?php/* if($message_queue_count != 0) { ?>
		<br><br>
		<a href="add_record.php?sms=1"><div class="button">Add SMS Record</div></a>
		<!--<div class="button" style="color:#AEAEAE">Add SMS Record</div>-->
	<?php }else{ ?>
		<br><br>
		<div class="button" style="color:#AEAEAE">Add SMS Record</div>
	<?php } */?>
	
	<br><br>
	<a href="http://wiki.ushahidi.com/doku.php?id=4636instructions"><div class="button">Instructions</div></a>
	
	<br><br>
	<a href="chat.php" target="_blank"><div class="button">Volunteer Chat</div></a>
	
<!--	<a href="#"><div class="button"><?php pmsg('Upload Images'); ?></div></a> -->
	<!--
	<br /><br />
	<div id="language-menu">
		<?php global $LANG; ?>
		<?php pmsg('Primary Language'); ?>
		<a href="/?lang=en_US" class="<?php if ($LANG == "en_US") print "selected"; ?>">English</a><br />
		<a href="/?lang=ht" class="<?php if ($LANG == "ht") print "selected"; ?>">Krey&ograve;l</a><br />
		<a href="/?lang=fr" class="<?php if ($LANG == "fr") print "selected"; ?>">Fran&ccedil;ais</a><br />
	</div>
	-->
	<br />
</div>
