<?php
session_start();

if(isset($_GET['letmein'])) $_SESSION['authenticated'] = $_GET['letmein'];
if(!isset($_SESSION['authenticated'])) $_SESSION['authenticated'] = 'wrongpw';

if($_SESSION['authenticated'] != 'PCY492My6U8arf') {
	echo 'Sorry, you need proper credentials to get in here.';
	die();
}

$host = 'localhost';
$user = 'ushahidi';
$pass = 'ScS79DsM4t5sFyN9';
$db = 'ushahidi';

mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());

$query = 'SELECT * FROM sms WHERE status = 0 ORDER BY date_rec DESC';
$result = mysql_query($query);
while($row = mysql_fetch_array( $result )) {
	echo '<a href="http://75.101.195.137/add_record.php?sms=1&sneaksms='.$row['smsid'].'">PARSE ME!</a> '.$row['number'].': '.$row['message'].'<br>
	';
}

?>

<?php require_once('footer.php'); ?>