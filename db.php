<?php

include_once("twitter/broadcast.php");
include_once("l10n.php");

define('RESULTS_PER_PAGE', 20);

/*
if ($_SERVER['HTTP_HOST'] != 'www.haitianquake.com') {
	ini_set('display_errors', 'on');
	error_reporting(E_ALL);
}
*/

date_default_timezone_set('America/New_York');

require_once('connect.php');
require_once('curl.php');

/*
$test_array = array(
	array('number'=>'1112223333','message'=>'Im looking for my parents in Pap. George Collins and Patty Collins. 46 Le Rue.'),
	array('number'=>'1112223333','message'=>'Sarthe. Samantha et Jean-Luc sont portées disparues. Adresse inconnue.'),
	array('number'=>'1112223333','message'=>'Nazon Nathan Clarke was working for the United Nations and lived at 29 Delmas.'),
	array('number'=>'1112223333','message'=>'22 Mais Gate. Looking for the Bowman family.'),
	array('number'=>'1112223333','message'=>'Avenida Mais Gate Pat Bell cannot be located.'),
	array('number'=>'1112223333','message'=>'Hospital Royal is out of supplies in Village Lamothe'),
);
$rand_key = array_rand($test_array);
add_sms($test_array[$rand_key]);
*/

if(isset($_GET['forcecomcel'])) collect_comcel_sms_data();
if(isset($_GET['forcedigicel'])) collect_sms_data();

function collect_sms_data(){
	$html = curl_req('http://66.54.117.38/comments/text2screen/helphaiti.asp');
	$chop1 = strrpos($html,'<td class="TableRow"></td>',26);
	$chop2 = stripos($html,'<h1></h1>');
	$data_string = substr($html,$chop1,($chop2-$chop1));
	$data_string = str_replace('<td class="TableRow"></td>','',$data_string);
	$data_string = str_replace('</table>','',$data_string);
	$data_string = trim($data_string);
	$data_string = str_replace('</td><td>','|',$data_string);
	$data_string = str_replace('</td><tr><td>','*****',$data_string);
	$data_string = str_replace('<tr><td>','',$data_string);
	$data_string = str_replace('</tr></td>','',$data_string);
	$big_array = explode('*****',$data_string);
	
	$result = mysql_query('SELECT date_rec FROM sms WHERE carrierid = 1 ORDER BY date_rec DESC LIMIT 1;');
	$time_test = mysql_result($result,0,'date_rec');
	
	foreach($big_array as $id => $string){
		//$holder = array();
		$holder = explode('|',$string);
		$time = strtotime(''.$holder[2].' '.$holder[3].'');
		if($time > $time_test){
			$message = str_replace('\0','',$holder[1]);
			$big_array[$id] = array(
				'number'=>$holder[0],
				'message'=>$message,
				'time'=>$time,
				'carrier_id'=>1
			);
			$status=0;
			
			if(stripos($message,' ') === false ||
				stripos($message,'Registre Port-au-Prince') !== false ||
				stripos($message,'Register Port-au-Prince') !== false ||
				stripos($message,'Registre Port_au_Prince') !== false ||
				stripos($message,'Register Port_au_Prince') !== false ||
				strlen($message) < 30){
				$status = 3;
			}else{
				$status = 0;
			}
			
			add_sms($big_array[$id],$status);
		}
		
	}
	return true;
}

function collect_comcel_sms_data(){

	$result = mysql_query('SELECT date_rec FROM sms WHERE carrierid = 2 ORDER BY date_rec DESC LIMIT 1;');
	$time_test = mysql_result($result,0,'date_rec');
	
	$rss = curl_req_comcel();
	$domxml = DOMDocument::loadXML($rss);
	$simplexml = simplexml_import_dom($domxml);
	foreach($simplexml->channel->item as $sms){
	
		$sms_array = array();
		
		$phone = (string)$sms->author;
		$phone = str_replace('smpp://','',$phone);
		$phone = str_replace('sms://','',$phone);
		$message = (string)$sms->title;
		$time = strtotime((string)$sms->pubDate);
		if($time > $time_test){
		
			$sms_array = array(
				'number'=>$phone,
				'message'=>$message,
				'time'=>$time,
				'carrier_id'=>2
			);
			
			$status=0;
			
			if(stripos($message,' ') === false ||
				stripos($message,'Registre Port-au-Prince') !== false ||
				stripos($message,'Register Port-au-Prince') !== false ||
				stripos($message,'Registre Port_au_Prince') !== false ||
				stripos($message,'Register Port_au_Prince') !== false ||
				strlen($message) < 30){
				$status = 3;
			}
			//if((time() - $time) > 21600) add_sms($sms_array,$status);
			add_sms($sms_array,$status);
		}
	}
	
}

function add_sms($data,$status=0){
	
	// Check if the message has been added before
	$query = sprintf("SELECT COUNT(*) as count FROM sms WHERE number = '%s' AND date_rec = '%s' LIMIT 1",mysql_escape_string($data['number']), mysql_escape_string($data['time']));
	$result = mysql_query($query);
	
	if(mysql_result($result,0,'count') == 0) {
		
		//Insert the message into the SMS database
		$query = sprintf("INSERT INTO sms (`number`, `message`, `date_rec`, `status`, `carrierid`) VALUES ('%s', '%s', '%s', %d, %s)",mysql_escape_string($data['number']), mysql_escape_string($data['message']), mysql_escape_string($data['time']), $status, $data['carrier_id']);
		mysql_query($query);
		
		// Create a unique id for the phone number in the senderid table
		$query = sprintf("SELECT COUNT(*) as count FROM senderid WHERE number = '%s' LIMIT 1",mysql_escape_string($data['number']));
		$result = mysql_query($query);
		if(mysql_result($result,0,'count') == 0) {
			$query = sprintf("INSERT INTO senderid (number) VALUES ('%s')",mysql_escape_string($data['number']));
			mysql_query($query);
		}
		
	}
	
}

function run_fake_cron($force=false){
	$rand = rand(1,50);
	if($rand == 1 || $force == 1) {

		//Clean editing queue
		mysql_query("UPDATE sms SET status = 0, ts = NOW() WHERE status = 1 AND ts < (CURRENT_TIMESTAMP - INTERVAL 10 MINUTE)");
		
		//Grab more messages
		//collect_sms_data();
	}
	if($rand == 2){
		//collect_comcel_sms_data();
	}
	return true;
}

function get_sms_queue_count(){
	$result = mysql_query('SELECT COUNT(*) as count FROM sms WHERE status=0;');
	return mysql_result($result,0,'count');
}

function set_sms_status($id,$status){	if($status != 0 && $status != 1 && $status != 2 && $status != 3) return false;
	mysql_query("UPDATE sms SET status = $status, ts = NOW() WHERE smsid = ".mysql_escape_string($id)." LIMIT 1");
	return true;
}

function get_available_sms($specific_id=0,$wronglang=array()){
	
	$add_to_query = '';
	foreach($wronglang as $skipid){
		$add_to_query .= 'AND smsid != '.mysql_escape_string($skipid).' ';
	}
	
	if($specific_id != 0){
		$result = mysql_query('SELECT smsid, number, message FROM sms WHERE status=0 AND smsid='.mysql_escape_string($specific_id).' ORDER BY date_rec ASC LIMIT 1;');
	}else{
		$result = mysql_query('SELECT smsid, number, message FROM sms WHERE status=0 '.$add_to_query.' ORDER BY date_rec ASC LIMIT 1;');
	}
	
	if(mysql_num_rows($result) > 0) {
		$message = mysql_result($result,0,'message');
		$number = mysql_result($result,0,'number');
		$id = mysql_result($result,0,'smsid');
		mysql_query("UPDATE sms SET status = 1, ts = NOW() WHERE smsid = $id LIMIT 1");
		return array('smsid'=>$id,'number'=>$number,'message'=>$message);
	}else{
		return false;
	}
}

function create_record($data) {
	$data = _prepare_data($data);
	
	if(!isset($data['firstname'])) $data['firstname'] = '';
	if(!isset($data['lastname'])) $data['lastname'] = '';
	if(!isset($data['fullname'])) $data['fullname'] = '';
	if(!isset($data['age'])) $data['age'] = '';
	if(!isset($data['gender'])) $data['gender'] = '';
	if(!isset($data['city'])) $data['city'] = '';
	if(!isset($data['department'])) $data['department'] = '';
	if(!isset($data['status'])) $data['status'] = '';
	if(!isset($data['current_location'])) $data['current_location'] = '';
	if(!isset($data['address'])) $data['address'] = '';
	if(!isset($data['lat'])) $data['lat'] = '';
	if(!isset($data['lon'])) $data['lon'] = '';
	if(!isset($data['current_contact_information'])) $data['current_contact_information'] = '';
	if(!isset($data['aid_type'])) $data['aid_type'] = '';
	if(!isset($data['notes'])) $data['notes'] = '';
	if(!isset($data['url_link_back'])) $data['url_link_back'] = '';
	if(!isset($data['data_entry_initials'])) $data['data_entry_initials'] = '';
	if(!isset($data['source'])) $data['source'] = '';
	if(!isset($data['fromsms'])) $data['fromsms'] = '';
	if(!isset($data['notes'])) $data['notes'] = '';
	if(!isset($data['addtonotes'])) $data['addtonotes'] = '';
	if(!isset($data['sms'])) $data['sms'] = '';
	if(!isset($data['actionable'])) $data['actionable'] = '';
	
	
	if($data['notes'] == "" && $data['aid_type'] == "" && $data['lon'] == "" && $data['lat'] == "" && $data['address'] == ""
		&& $data['department'] == "" && $data['city'] == "" && $data['fullname'] == " " && $data['sms'] == "" && $data['actionable'] == "") {
		return 0;
	}
	
	if($data['addtonotes'] != '') $data['notes'] .= ' --- Additional Notes: '.$data['addtonotes'];
	
	
	$query = sprintf(
	  "INSERT INTO person (firstname, lastname, fullname, age, gender, city, department,
				status, current_location, address, lat, lon, current_contact_information, 
				url_link_back, source, data_entry_initials, created, updated, aid_type, notes, sms, smsid, actionable)
				VALUES ('%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %d, '%s', '%s', '%s', %d, %d)",
		$data['firstname'], $data['lastname'], $data['fullname'], $data['age'], $data['gender'], $data['city'], $data['department'],
		$data['status'], $data['current_location'], $data['address'], $data['lat'], $data['lon'], $data['current_contact_information'], $data['url_link_back'],
		$data['source'], $data['data_entry_initials'], time(), time(), $data['aid_type'], $data['notes'], $data['sms'], $data['fromsms'], $data['actionable']
	);
	mysql_query($query);
	$id = mysql_insert_id();
	broadcast_raw($data,$id);
	if (!empty($data['my_name'])) {
		handle_searcher($id, $data);
	}
	if(isset($data['fromsms'])){
		mysql_query("UPDATE sms SET status = 2, ts = NOW() WHERE smsid = ".mysql_escape_string($data['fromsms'])." LIMIT 1");
	}
	return $id;
}

function add_comment($id, $data) {
	$data['comment'] = strip_tags($data['comment'], '<a><img>');
	$data['name'] = strip_tags($data['name']);
	$data = array_map('mysql_real_escape_string', $data);
	mysql_query(sprintf(
		"INSERT INTO person_comments (person_id, name, comment, created) VALUES(%d, '%s', '%s', %d)",
		mysql_real_escape_string($_GET['id']), $data['name'], $data['comment'], time()
	));
}

function get_comments($id) {
	$return = array();
	$res = mysql_query(sprintf(
		"SELECT * FROM person_comments WHERE person_id = %d", mysql_real_escape_string($id)
	));
	while ($row = mysql_fetch_assoc($res)) {
		$return[] = array_map('stripslashes', $row);
	}
	return $return;
}

function get_photos($id) {
	$return = array();
	$res = mysql_query(sprintf(
		"SELECT * FROM person_photos WHERE person_id = %d", mysql_real_escape_string($id)
	));
	while ($row = mysql_fetch_assoc($res)) {
		$return[] = array_map('stripslashes', $row);
	}
	return $return;
}

function handle_searcher($id, $data) {
	mysql_query(sprintf(
		"INSERT INTO searcher (email, name, relationship, phone, person_id) VALUES ('%s', '%s', '%s', '%s', %d)",
		$data['my_email'], $data['my_name'], $data['my_relationship'], $data['my_phone'], $id
	));
}

function load_record($id) {
	$res = mysql_query(sprintf("SELECT * FROM person WHERE id = %d", mysql_real_escape_string($id)));
	$data = mysql_fetch_assoc($res);
	if (empty($data)) return array();
	return array_map('stripslashes', $data);
}

function log_update($id, $col, $old, $new) {
	mysql_query(sprintf(
		"INSERT INTO person_update (person_id, field, old_version, new_version, created) VALUES (%d, '%s', '%s', '%s', %d)", 
		$id, column_titles($col), mysql_real_escape_string($old), mysql_real_escape_string($new), time()
	));
}

function get_updates($id) {
	$return = array();
	$res = mysql_query(sprintf(
		"SELECT * FROM person_update WHERE person_id = %d", mysql_real_escape_string($id)
	));
	while ($row = mysql_fetch_assoc($res)) {
		$return[] = array_map('stripslashes', $row);
	}
	return $return;
}

function get_searcher($id) {
	$return = array();
	$res = mysql_query(sprintf(
		"SELECT * FROM searcher WHERE person_id = %d", mysql_real_escape_string($id)
	));
	while ($row = mysql_fetch_assoc($res)) {
		$return[] = array_map('stripslashes', $row);
	}
	return $return;
}

function column_titles($key) {
	$titles = array(
		'firstname' => 'First Name',
		'lastname' => 'Last Name',
		'current_contact_information' => 'Current Contact Information',
		'current_location' => 'Current Location',
	);
	if (isset($titles[$key])) {
		return $titles[$key];
	}
	return ucfirst($key);
}

function update_record($id, $data) {
	$old = load_record($id);
	$omit = array('lat', 'lon', 'fullname', 'id', 'updated', 'created', 'ts');
	foreach ($old as $k=>$v) {
		if (in_array($k, $omit)) continue;
		if (@$data[$k] != $v) {
			@log_update($id, $k, $v, $data[$k]);
		}
	}
	$data = _prepare_data($data);
	if(!isset($data['firstname'])) $data['firstname'] = '';
	if(!isset($data['lastname'])) $data['lastname'] = '';
	if(!isset($data['fullname'])) $data['fullname'] = '';
	if(!isset($data['age'])) $data['age'] = '';
	if(!isset($data['gender'])) $data['gender'] = '';
	if(!isset($data['city'])) $data['city'] = '';
	if(!isset($data['department'])) $data['department'] = '';
	if(!isset($data['status'])) $data['status'] = '';
	if(!isset($data['current_location'])) $data['current_location'] = '';
	if(!isset($data['address'])) $data['address'] = '';
	if(!isset($data['lat'])) $data['lat'] = '';
	if(!isset($data['lon'])) $data['lon'] = '';
	if(!isset($data['current_contact_information'])) $data['current_contact_information'] = '';
	if(!isset($data['aid_type'])) $data['aid_type'] = '';
	if(!isset($data['notes'])) $data['notes'] = '';
	if(!isset($data['url_link_back'])) $data['url_link_back'] = '';
	if(!isset($data['fromsms'])) $data['fromsms'] = '';

	mysql_query(sprintf(
	  "UPDATE person SET firstname = '%s', lastname = '%s', fullname = '%s', age = %d, gender = '%s', city = '%s', department = '%s',
			status = '%s', current_location = '%s', address = '%s', lat = %d, lon = %d, current_contact_information = '%s', 
			updated = %d, aid_type = '%s', notes = '%s'
			WHERE id = %d",
		$data['firstname'], $data['lastname'], $data['fullname'], $data['age'], $data['gender'], $data['city'], $data['department'],
		$data['status'], $data['current_location'], $data['address'], $data['lat'], $data['lon'], $data['current_contact_information'],
		time(), mysql_real_escape_string($id), $data['aid_type'], $data['notes']
	));
	broadcast_raw($data,$id);
	if (!empty($data['my_phone'])) {
		handle_searcher($id, $data);
	}
}

function all_people() {
	$count = mysql_result(mysql_query("SELECT count(*) from person"), 0);
	$res = mysql_query(sprintf("SELECT * FROM person order by created desc LIMIT %d, %d", $_GET['page'] * RESULTS_PER_PAGE, RESULTS_PER_PAGE));
	return array($count, $res);
}

function search_person($data) {
	if (!$data['name'] && !$data['city']) return;
	$data = array_map('mysql_real_escape_string', $data);
	
	if (isset($data['name']) && isset($data['city'])) {
		$name = strtolower(trim($data['name']));
		$count = mysql_result(mysql_query(sprintf(
		  "SELECT count(*) FROM person WHERE LOWER(city) LIKE '%%%s%%' AND (LOWER(fullname) LIKE '%%%s%%' 
		  		OR LOWER(firstname) LIKE '%%%s%%' OR LOWER(lastname) LIKE '%%%s%%')",
			strtolower(trim($data['city'])), $name, $name, $name
		)), 0);
		$result = mysql_query(sprintf(
		  "SELECT * FROM person WHERE LOWER(city) LIKE '%%%s%%' AND (LOWER(fullname) LIKE '%%%s%%' 
		  		OR LOWER(firstname) LIKE '%%%s%%' OR LOWER(lastname) LIKE '%%%s%%') ORDER BY lastname, firstname LIMIT %d, %d",
			strtolower(trim($data['city'])), $name, $name, $name, $_GET['page'] * RESULTS_PER_PAGE, RESULTS_PER_PAGE
		));
	}
	elseif (isset($data['name'])) {
		$name = strtolower(trim($data['name']));
		$count = mysql_result(mysql_query(sprintf(
		  "SELECT count(*) FROM person WHERE LOWER(fullname) LIKE '%%%s%%' 
		  		OR LOWER(firstname) LIKE '%%%s%%' OR LOWER(lastname) LIKE '%%%s%%'",
			$name, $name, $name
		)), 0);
		$result = mysql_query(sprintf(
		  "SELECT * FROM person WHERE LOWER(fullname) LIKE '%%%s%%' 
		  		OR LOWER(firstname) LIKE '%%%s%%' OR LOWER(lastname) LIKE '%%%s%%'",
			$name, $name, $name
		));
	}
	else {
		$count = mysql_result(mysql_query(sprintf(
		  "SELECT count(*) FROM person WHERE LOWER(city) LIKE '%%%s%%'",
			strtolower(trim($data['city']))
		)), 0);
		$result = mysql_query(sprintf(
		  "SELECT * FROM person WHERE LOWER(city) LIKE '%%%s%%'",
			strtolower(trim($data['city']))
		));
	}
	
	return array($count, $result);
}

function jit_resize($path, $command) {
  $path_parts = explode("/", $path);
  $filename = array_pop($path_parts);
  array_push($path_parts, $command);
  array_push($path_parts, $filename);
  return implode("/", $path_parts);
}

function handle_upload($id) {
	// Configuration - Your Options
	$allowed_filetypes = array('.jpg', '.gif', '.png'); // These will be the types of file that will pass the validation.
	$max_filesize = 2097152; // 2mb
	$upload_path = 'photos/'; // The place the files will be uploaded to (currently a 'files' directory).

	$filename = $_FILES['photo']['name'];
	$ext = substr($filename, strrpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
	$ext = strtolower($ext);

	if(!in_array($ext,$allowed_filetypes))
		die('That extension is not allowed. Please use your browser back button to return to the form.');
	if(filesize($_FILES['photo']['tmp_name']) > $max_filesize)
		die('The file you attempted to upload is too large.');
	if(!is_writable($upload_path))
		die('The file directory is not writeable. Please use your browser back button to return to the form.');

	// Upload the file to your specified path.
	if(move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path . $id . '_' . $filename)) {
		mysql_query(sprintf(
			"INSERT INTO person_photos (person_id, url, created) VALUES(%d, '%s', %d)",
			$id, mysql_real_escape_string($upload_path . $id . '_' . $filename), time()
		));
		return;
	}
	die('The file upload failed for some unknown reason. Please use your browser back button to return to the form.');
}

function delete_people($data) {
	mysql_query(sprintf("DELETE FROM person WHERE id in (%s)", implode(',', $data['person'])));
}

function last_ten_created() {
	$sth = mysql_query("SELECT firstname,lastname,city,id,status,department,created,lat,lon,sms,ts FROM person order by created desc limit 10");
	return $sth;
}

function _prepare_data($data) {
	$data['fullname'] = $data['firstname'] . ' ' . $data['lastname'];
	//$data['lat'] = $data['lon'] = 0; // for now
	$data = array_map('mysql_real_escape_string', $data); // sanitize
	return $data;
}

function has_admin() {
	return (isset($_COOKIE['has_admin']) && $_COOKIE['has_admin'] == 'af6340e00dec073a4887febe59856deb');
}
