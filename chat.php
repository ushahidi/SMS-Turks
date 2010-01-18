<?php
global $title;
require_once('db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php') ?>
	<?php include_once("sidebar.php"); ?>
	<div id="content">
		<IFRAME SRC="http://4636.ushahidi.com/chat" WIDTH="955" HEIGHT="555" STYLE="border:none"></IFRAME>
	</div>
<?php require_once('footer.php'); ?>
</body>
</html>