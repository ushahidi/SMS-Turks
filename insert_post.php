<?php

require_once('db.php');

if(isset($_GET['junk'])){
	set_sms_status($_GET['junk'],3);
	//echo 'Marked as insufficient. <a href="http://4636.ushahidi.com/add_record.php?sms=1">Continue</a>';
	header('Location: http://4636.ushahidi.com/add_record.php?sms=1&junksuccess=1');
}

$person_id = create_record($_POST);
if (!empty($_FILES) && !empty($_FILES['photo']['name'])) {
	handle_upload($person_id);
}

if(isset($_POST['sneaksms'])) header('Location: smsqueue.php');

$query_string = '?success='.$_POST['firstname'].'+'.$_POST['lastname'];
if(isset($_POST['fromsms'])) $query_string .= '&sms=1';
header('Location: add_record.php'.$query_string);

//header('Location: person.php?id=' . $person_id);