<?php
	header('Content-Type: application/atom+xml; charset=UTF-8');
	if($_GET['key'] != 'yqNm7FHSwfdRb8nC2653') die('Key required');
?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; ?>
<?php
	require_once('db.php');
	
	function grab_reports($limit='0,50',$sincets='0',$uptots='9999999999',$only_phone=0) {
		$extra_query = '';
		if($only_phone == 1){
			$extra_query .= 'AND sms.number IS NOT NULL ';
		}
		$query = "SELECT person.id, person.firstname, person.lastname, person.fullname, person.city, person.department, person.status, person.address, person.lat, person.lon, person.sms, person.created, person.updated, person.ts, person.aid_type, person.notes, person.smsid, sms.date_rec as date_rec, sms.number as phone FROM person LEFT JOIN sms ON sms.smsid = person.smsid WHERE created >= ".mysql_escape_string($sincets)." AND created <= ".mysql_escape_string($uptots)." ".$extra_query." order by created desc limit ".mysql_escape_string($limit);
		$sth = mysql_query($query);
		return $sth;
	}
	
	$limit = '0,50';
	if(isset($_GET['limit'])) $limit = $_GET['limit'];
	
	$sincets = 0;
	if(isset($_GET['sincets'])) $sincets = $_GET['sincets'];
	
	$uptots = 0;
	if(isset($_GET['uptots'])) $uptots = $_GET['uptots'];
	
	$only_phone = 0;
	if(isset($_GET['only_phone'])) $only_phone = $_GET['only_phone'];
	
	$sth = grab_reports($limit,$sincets,$uptots,$only_phone);
	$rows = array();
	
	$highest_updated_date = 0;
	while($r = mysql_fetch_assoc($sth)) {
    	$rows[] = $r;
    	if($r['ts'] > $highest_updated_date) $highest_updated_date = $r['ts'];
	}
?>

<feed xmlns="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss">
	<id>"http://4636.ushahidi.com"</id>
   <title>4636.ushahidi.com</title>
   <subtitle>The official database of reports to the 4636 short code in Haiti.</subtitle>
   <link href="http://4636.ushahidi.com"/>
   <author>
      <name>sms://4636</name>
   </author>
   <updated><?php echo str_replace(' ','T',$highest_updated_date).'Z'; ?></updated>
<?php
foreach ($rows as $item) {
	
	$sms = preg_replace("/[\x80-\xff]/", '?', $item['sms']);
	$notes = preg_replace("/[\x80-\xff]/", '?', $item['notes']);
	$city = preg_replace("/[\x80-\xff]/", '?', $item['city']);
	$address = preg_replace("/[\x80-\xff]/", '?', $item['address']);
	$department = preg_replace("/[\x80-\xff]/", '?', $item['department']);
	$lastname = preg_replace("/[\x80-\xff]/", '?', $item['lastname']);
	$firstname = preg_replace("/[\x80-\xff]/", '?', $item['firstname']);

	echo '
	<entry>
		<id>http://4636.ushahidi.com/person.php?id='.$item['id'].'</id>
		<link href="http://4636.ushahidi.com/person.php?id='.$item['id'].'"/>
		<author><name>sms://'.$item['phone'].'</name></author>
		<updated>'.str_replace(' ','T',$item['ts']).'Z</updated>
		<title>'.$firstname.' '.$lastname.' at '.$item['lat'].','.$item['lon'].'</title>
		<sms><![CDATA['.$sms.']]></sms>
		<smsrec>'.$item['date_rec'].'</smsrec>
		<phone>'.$item['phone'].'</phone>
		<category term="'.str_replace('-','',$item['aid_type']).'"/>
		<categorization>'.str_replace('-','',$item['aid_type']).'</categorization>
		<firstname>'.$firstname.'</firstname>
		<lastname>'.$lastname.'</lastname>
		<status>'.$item['status'].'</status>
		<address>'.$address.'</address>
		<city>'.$city.'</city>
		<department>'.$department.'</department>
		<summary><![CDATA['.$item['phone'].': '.$sms.' - '.$notes.']]></summary>
		<notes><![CDATA['.$notes.']]></notes>
		<georss:point>'.$item['lat'].' '.$item['lon'].'</georss:point>
	</entry>';
}
?>
</feed>
