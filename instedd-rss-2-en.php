<?php
	if($_GET['key'] != 'yqNm7FHSwfdRb8nC2653') die('Key required');

	require_once('db.php');
	
	function grab_reports($etag='') {
		$query = "select * from sms s, person p ";
		$query .= "where s.smsid = p.smsid ";
		if ($etag) {
  		$query .= "and p.updated > $etag ";
		}
		$query .= "order by p.updated ";
		$query .= "limit 1000";
		$sth = mysql_query($query);
		return $sth;
	}
	
	$etag = $_SERVER['HTTP_IF_NONE_MATCH'];
	if (!$etag) {
  	$etag = $_SERVER['HTTP_ETAG'];
	}
	
	$sth = grab_reports($etag);
	$rows = array();
	
	while($r = mysql_fetch_assoc($sth)) {
    $rows[] = $r;
	}
	
	if (count($rows) > 0) {
  	header('ETag: ' . $rows[count($rows) - 1]['updated']);
	} else {
  	header('HTTP/1.1 304 Not Modified');
  	die();
	}

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss">
   <title>4636.ushahidi.com</title>
   <subtitle>The official database of reports to the 4636 short code in Haiti.</subtitle>
   <link href="http://4636.ushahidi.com"/>
   <author>
      <name>sms://4636 <?= $etag ?></name>
   </author>
<?php
foreach ($rows as $item) { 
  $title = htmlspecialchars($item['notes']);
  for($i = 0; $i < 0x20; $i++) {
    $title = str_replace(chr($i), ' ', $title);
  }
  
  $number = $item['number'];
  if (strlen($number) > 0 && $number[0] == '+') {
    $number = substr($number, 1);
  }
  
  echo '
	<entry>
	  <id>'.$item['smsid'].'</id>
	  <updated>'.str_replace(' ','T',$item['ts']).'Z</updated>
	  <author><email>sms://'.$number.'</email></author>
	  <title><![CDATA['.$title.']]></title>';
  if ($item['lat'] && $item['lon']) {
    echo '<georss:point>' . $item['lat']  . ' ' . $item['lon'] . '</georss:point>';
  }
  if ($item['aid_type']) {
    echo '<category term="'.str_replace('-','',$item['aid_type']).'"/>';
  }
	echo '</entry>';
}
?>
</feed>