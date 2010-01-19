<?php
	header('Content-Type: application/atom+xml; charset=UTF-8');
	if($_GET['key'] != 'yqNm7FHSwfdRb8nC2653') die('Key required');
?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>"; ?>
<?php
	require_once('db.php');
	
	function grab_reports($limit='0,50',$sincets='0',$uptots='1500000000',$only_phone=0,$category=array()) {
		$extra_query = '';
		if($only_phone == 1){
			$extra_query .= 'AND sms.number IS NOT NULL ';
		}
		if(count($category) > 0){
			$extra_query .= 'AND (1=2 ';
			foreach($category as $catid){
				$extra_query .= 'OR aid_type LIKE \'%'.$catid.'%\' ';
			}
			$extra_query .= ')';
		}
		$query = "SELECT person.id, person.firstname, person.lastname, person.fullname, person.city, person.department, person.status, person.address, person.lat, person.lon, person.created, person.updated, person.sms, person.ts, person.aid_type, person.notes, person.smsid, person.gender, person.numppl, person.actionable, sms.date_rec as date_rec, sms.number as phone, sms.message as message, senderid.senderid as phoneid FROM person LEFT JOIN sms ON sms.smsid = person.smsid LEFT JOIN senderid ON senderid.number = sms.number WHERE created >= ".mysql_escape_string($sincets)." AND created <= ".mysql_escape_string($uptots)." ".$extra_query." order by created desc limit ".mysql_escape_string($limit);
		$sth = mysql_query($query);
		return $sth;
	}
	
	$category = array('6B');
	if(isset($_GET['category'])) $category = explode(',',$_GET['category']);
	
	$limit = '0,50';
	if(isset($_GET['limit'])) $limit = $_GET['limit'];
	
	$sincets = '0';
	if(isset($_GET['sincets'])) $sincets = $_GET['sincets'];
	
	$uptots = '1500000000';
	if(isset($_GET['uptots'])) $uptots = $_GET['uptots'];
	
	$only_phone = 0;
	if(isset($_GET['only_phone'])) $only_phone = $_GET['only_phone'];
	
	$sth = grab_reports($limit,$sincets,$uptots,$only_phone,$category);
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
	
	$message = preg_replace("/[\x80-\xff]/", '?', $item['message']);
	$notes = preg_replace("/[\x80-\xff]/", '?', $item['notes']);
	$city = preg_replace("/[\x80-\xff]/", '?', $item['city']);
	$address = preg_replace("/[\x80-\xff]/", '?', $item['address']);
	$department = preg_replace("/[\x80-\xff]/", '?', $item['department']);
	$lastname = preg_replace("/[\x80-\xff]/", '?', $item['lastname']);
	$firstname = preg_replace("/[\x80-\xff]/", '?', $item['firstname']);
	$numppl = preg_replace("/[\x80-\xff]/", '?', $item['numppl']);

	echo '
	<entry>
		<id>http://4636.ushahidi.com/person.php?id='.$item['id'].'</id>
		<link href="http://4636.ushahidi.com/person.php?id='.$item['id'].'"/>
		<author><name>sms://'.$item['phone'].'</name></author>
		<updated>'.str_replace(' ','T',$item['ts']).'Z</updated>
		<title>'.$firstname.' '.$lastname.' at '.$item['lat'].','.$item['lon'].'</title>
		<sms><![CDATA['.$message.']]></sms>
		<smsrec>'.$item['date_rec'].'</smsrec>
		<phone>'.$item['phone'].'</phone>
		<phoneid>'.$item['phoneid'].'</phoneid>
		<category term="'.str_replace('-','',$item['aid_type']).'"/>
		<categorization>'.str_replace('-','',$item['aid_type']).'</categorization>
		<actionable>'.$item['actionable'].'</actionable>
		<firstname>'.$firstname.'</firstname>
		<lastname>'.$lastname.'</lastname>
		<gender>'.$item['gender'].'</gender>
		<numppl><![CDATA['.$numppl.']]></numppl>
		<status>'.$item['status'].'</status>
		<address>'.$address.'</address>
		<city>'.$city.'</city>
		<department>'.$department.'</department>
		<summary><![CDATA['.$item['phone'].': '.$message.' - '.$notes.']]></summary>
		<notes><![CDATA['.$notes.']]></notes>
		<georss:point>'.$item['lat'].' '.$item['lon'].'</georss:point>
	</entry>';
}
?>
</feed>









<pfif:pfif xmlns:pfif="http://zesty.ca/pfif/1.1"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://zesty.ca/pfif/1.1
                               http://zesty.ca/pfif/1.1/pfif-1.1.xsd">
                               




  <pfif:person>
    <pfif:person_record_id>salesforce.com/a0030000001TRYR</pfif:person_record_id>
    <pfif:entry_date>2005-09-03T09:21:12Z</pfif:entry_date>
    <pfif:author_name>Bill Mandil</pfif:author_name>
    <pfif:author_email>bmd67893@example.com</pfif:author_email>
    <pfif:author_phone>(555) 258-6902</pfif:author_phone>

    <pfif:source_name>salesforce.com</pfif:source_name>
    <pfif:source_date>2005-09-03T09:21:12Z</pfif:source_date>
    <pfif:source_url>http://www.salesforce.com/person/a0030000001TRYR</pfif:source_url>
    <pfif:first_name>KATHERINE</pfif:first_name>
    <pfif:last_name>DOE</pfif:last_name>
    <pfif:home_city>TUSCALOOSA</pfif:home_city>

    <pfif:home_state>AL</pfif:home_state>
    <pfif:home_neighborhood/>
    <pfif:home_street>COTTON LANE</pfif:home_street>
    <pfif:home_zip>94305</pfif:home_zip>
    <pfif:photo_url>http://flickr.com/photo/12345678.jpg</pfif:photo_url>
    <pfif:other>
description:
    Dark hair, in her late thirties.
    Also goes by the names "Kate" or "Katie".
salesforce.com/gender: female
salesforce.com/company: Generic Savings Bank
    </pfif:other>

    <pfif:note>
      <pfif:note_record_id>salesforce.com/00N30000000tO5N</pfif:note_record_id>
      <pfif:entry_date>2005-09-03T20:52:25Z</pfif:entry_date>
      <pfif:author_name>Jane Peters</pfif:author_name>
      <pfif:author_email>jp123@example.com</pfif:author_email>
      <pfif:author_phone>(555) 493-2342</pfif:author_phone>

      <pfif:source_date>2005-09-03T20:52:25Z</pfif:source_date>
      <pfif:found>true</pfif:found>
      <pfif:email_of_found_person>katie_doe@randomsite.biz</pfif:email_of_found_person>
      <pfif:phone_of_found_person>(555) 904-9095</pfif:phone_of_found_person>
      <pfif:last_known_location>on a cot somewhere, AstroDome, Houston TX</pfif:last_known_location>
      <pfif:text>

I spoke to Katie on the phone today at around noon EST.
She is tired and worried but otherwise okay.
      </pfif:text>
    </pfif:note>
  </pfif:person>
  
  
  
</pfif:pfif>



















