<?php
$result = mysql_query("SELECT count(id) FROM person") or die(mysql_error());
$query_data = mysql_fetch_row($result);
$count = $query_data[0];
$count = number_format($count);
$message_queue_count = get_sms_queue_count();
/*
if(isset($_GET('forcecron']))){
	run_fake_cron(1);
}else{
	run_fake_cron();
}*/
run_fake_cron();
?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="util.js"></script>
<title>4636.ushahidi.com - <?php pmsg('index_page_title'); if(isset($title)) print " | ".$title; ?></title>
<link rel="stylesheet" href="/style.css" type="text/css" />
</head>
<body>
<div id="wrapper">
    <div id="header">
		<div style="float: right;">
			<form method="get" action="search_post.php">
				<table><tr><td><img src="search.jpg" alt="" /></td><td><input type="text" id="search" name="name" onblur="replaceInput(this);" onfocus="clearInput(this);" value="Search" /></td><td colspan="2"><input type="submit" id="search-button" value="Search" /></td></tr></table>
			</form>
		</div>
		<h2><a href="/">4636.USHAHIDI.COM</a></h2>
		<div style="float: left;">
			Records: <a href="search_post.php"><?php print $count; ?></a> | Messages in queue: <a href="add_record.php?sms=1"><?php echo $message_queue_count; ?></a>
		</div>
	</div>
	<div style="clear:both"></div>