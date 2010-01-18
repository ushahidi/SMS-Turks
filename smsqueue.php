<?php
session_start();

if(isset($_POST['letmein'])) $_GET['letmein'] = $_POST['letmein'];
if(isset($_GET['letmein'])) $_SESSION['authenticated'] = $_GET['letmein'];
if(!isset($_SESSION['authenticated'])) $_SESSION['authenticated'] = 'wrongpw';

if($_SESSION['authenticated'] != 'PCY492My6U8arf') {
	echo 'Sorry, you need proper credentials to get in here.<br /><br />';
	echo '
	<form method="post" action="smsqueue.php?'.$_SERVER['QUERY_STRING'].'">
	<label for="letmein">Code:</label> <input type="text" id="letmein" name="letmein" value="" />
	<input type="submit" value="Submit" />
	</form>';
	die();
}

require_once('db.php');

if(isset($_GET['reintroduce'])){
	set_sms_status($_GET['reintroduce'],0);
}

if(isset($_GET['editpost']) && isset($_POST['lat']) && isset($_POST['lon']) && isset($_POST['aid_type']) && isset($_POST['private_notes']) && isset($_POST['id'])){
	$data = _prepare_data($_POST);
	mysql_query(sprintf(
	  "UPDATE person SET lat = %d, lon = %d, updated = %d, aid_type = '%s', private_notes = '%s', actionable = %d WHERE id = %d",
		$data['lat'], $data['lon'], time(), $data['aid_type'], $data['private_notes'], $data['actionable'], $data['id']
	));
}





if(!isset($_GET['edit'])){
	$title = 'SMS QUEUE';
	$status = '0';
	$link = 'http://4636.ushahidi.com/add_record.php?sms=1&sneaksms=';
	$link_text = 'PARSE';
	if(isset($_GET['insufficient'])){
		$title = 'MESSAGES MARKED INSUFFICIENT INFO';
		$status = '3';
		$link = 'http://4636.ushahidi.com/smsqueue.php?insufficient=1&reintroduce=';
		$link_text = 'REINTRODUCE';
	}
	
	echo '<h1>'.$title.'</h1>';
	
	$query = 'SELECT * FROM sms WHERE status = '.$status.' ORDER BY date_rec DESC';
	$result = mysql_query($query);
	while($row = mysql_fetch_array( $result )) {
		echo '<a href="'.$link.''.$row['smsid'].'">'.$link_text.'</a> '.$row['number'].': '.$row['message'].'<br>
		';
	}
}

if(isset($_GET['edit'])){
	$title = 'EDIT QUEUE';
	$status = '2';
	$link = 'http://4636.ushahidi.com/smsqueue.php?edit=1&editform=';
	$link_text = 'Edit';
	
	echo '<h1>'.$title.'</h1>';
	
	if(isset($_GET['editform'])){
		$query = "SELECT person.id, person.firstname, person.lastname, person.fullname, person.city, person.department, person.status, person.address, person.lat, person.lon, person.sms, person.created, person.updated, person.ts, person.aid_type, person.notes, person.smsid, person.gender, person.numppl, person.actionable, person.private_notes, sms.date_rec as date_rec, sms.number as phone, senderid.senderid as phoneid FROM person LEFT JOIN sms ON sms.smsid = person.smsid LEFT JOIN senderid ON senderid.number = sms.number WHERE person.id = ".mysql_escape_string($_GET['editform'])." LIMIT 1";
		$result = mysql_query($query);
		$sms = mysql_result($result,0,'sms');
		$aid_type = mysql_result($result,0,'aid_type');
		$notes = mysql_result($result,0,'notes');
		$private_notes = mysql_result($result,0,'private_notes');
		$id = mysql_result($result,0,'id');
		$lat = mysql_result($result,0,'lat');
		$lon = mysql_result($result,0,'lon');
		
		$checked = '';
		if(mysql_result($result,0,'actionable') == 1) $checked = 'checked';
		?>
		<form method="POST" action="smsqueue.php?edit=1&editpost=1">
			<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
			<table border="1" cellpadding="4" style="border:none">
				<tr>
					<td>Original SMS:</td>
					<td><em><?php echo $sms; ?></em></td>
				</tr>
				<tr>
					<td nowrap>Translator Notes:</td>
					<td><em><?php echo $notes; ?></em></td>
				</tr>
				<tr>
					<td>Lat,Lon:</td>
					<td><em><input type="text" id="lat" name="lat" value="<?php echo $lat; ?>" style="width:50px;" /> , <input type="text" id="lon" name="lon" value="<?php echo $lon; ?>" style="width:50px;" /></em></td>
				</tr>
				<tr>
					<td nowrap>Category/Aid Request:</td>
					<td>
						<select id="aid_type" name="aid_type">
							<option></option>
							<option <?php echo ($aid_type == '1. Emergency') ? 'selected="selected"' : ''; ?>>1. Emergency</option>
							<option <?php echo ($aid_type == '--1a. Collapsed structure') ? 'selected="selected"' : ''; ?>>--1a. Collapsed structure</option>
							<option <?php echo ($aid_type == '--1b. Fire') ? 'selected="selected"' : ''; ?>>--1b. Fire</option>
							<option <?php echo ($aid_type == '--1c. People trapped') ? 'selected="selected"' : ''; ?>>--1c. People trapped</option>
							<option <?php echo ($aid_type == '--1d. Contaminated water supply') ? 'selected="selected"' : ''; ?>>--1d. Contaminated water supply</option>
							<option <?php echo ($aid_type == '--1e. Earthquake and aftershocks') ? 'selected="selected"' : ''; ?>>--1e. Earthquake and aftershocks</option>
							<option <?php echo ($aid_type == '--1f. Medical Emergency') ? 'selected="selected"' : ''; ?>>--1f. Medical Emergency</option>
							<option></option>
							<option <?php echo ($aid_type == '2. Threats') ? 'selected="selected"' : ''; ?>>2. Threats</option>
							<option <?php echo ($aid_type == '--2a. Structures at risk') ? 'selected="selected"' : ''; ?>>--2a. Structures at risk</option>
							<option <?php echo ($aid_type == '--2b. Looting') ? 'selected="selected"' : ''; ?>>--2b. Looting</option>
							<option></option>
							<option <?php echo ($aid_type == '3. Vital Lines') ? 'selected="selected"' : ''; ?>>3. Vital Lines</option>
							<option <?php echo ($aid_type == '--3a. Water shortage') ? 'selected="selected"' : ''; ?>>--3a. Water shortage</option>
							<option <?php echo ($aid_type == '--3b. Road blocked') ? 'selected="selected"' : ''; ?>>--3b. Road blocked</option>
							<option <?php echo ($aid_type == '--3c. Power Outage') ? 'selected="selected"' : ''; ?>>--3c. Power Outage</option>
							<option></option>
							<option <?php echo ($aid_type == '4. Response') ? 'selected="selected"' : ''; ?>>4. Response</option>
							<option <?php echo ($aid_type == '--4a. Health services') ? 'selected="selected"' : ''; ?>>--4a. Health services</option>
							<option <?php echo ($aid_type == '--4b. USAR Search and Rescue') ? 'selected="selected"' : ''; ?>>--4b. USAR Search and Rescue</option>
							<option <?php echo ($aid_type == '--4c. Shelter') ? 'selected="selected"' : ''; ?>>--4c. Shelter</option>
							<option <?php echo ($aid_type == '--4d. Food distribution') ? 'selected="selected"' : ''; ?>>--4d. Food distribution</option>
							<option <?php echo ($aid_type == '--4e. Water sanitation and hygiene promotion') ? 'selected="selected"' : ''; ?>>--4e. Water sanitation and hygiene promotion</option>
							<option <?php echo ($aid_type == '--4f. Non food items') ? 'selected="selected"' : ''; ?>>--4f. Non food items</option>
							<option <?php echo ($aid_type == '--4g. Rubble removal') ? 'selected="selected"' : ''; ?>>--4g. Rubble removal</option>
							<option <?php echo ($aid_type == '--4h. Died bodies management') ? 'selected="selected"' : ''; ?>>--4h. Died bodies management</option>
							<option></option>
							<option <?php echo ($aid_type == '5. Other') ? 'selected="selected"' : ''; ?>>5. Other</option>
							<option></option>
							<option <?php echo ($aid_type == '6. Persons News') ? 'selected="selected"' : ''; ?>>6. Persons News</option>
							<option <?php echo ($aid_type == '--6a. Deaths') ? 'selected="selected"' : ''; ?>>--6a. Deaths</option>
							<option <?php echo ($aid_type == '--6b. Missing Persons') ? 'selected="selected"' : ''; ?>>--6b. Missing Persons</option>
							<option></option>
							<option <?php echo ($aid_type == 'Asking to forward a message') ? 'selected="selected"' : ''; ?>>Asking to forward a message</option>
							<option></option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="actionable">Actionable:</label></td>
					<td><input type="checkbox" id="actionable" name="actionable" value="1" <?php echo $checked; ?> /></td>
				</tr>
				<tr>
					<td><label for="actionable">Private Notes:</label></td>
					<td><textarea rows="4" cols="50" name="private_notes"><?php echo $private_notes; ?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td style="border:none"><input type="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>
		<hr />
		<?php
	}
	
	?>
	<style type="text/css">
	td{
	 margin:1px;
	 border: 1px dashed grey;
	}
	</style>
	<?php
	
	$query = "SELECT person.id, person.firstname, person.lastname, person.fullname, person.city, person.department, person.status, person.address, person.lat, person.lon, person.sms, person.created, person.updated, person.ts, person.aid_type, person.notes, person.private_notes, person.smsid, person.gender, person.numppl, person.actionable, sms.date_rec as date_rec, sms.number as number, senderid.senderid as phoneid FROM person LEFT JOIN sms ON sms.smsid = person.smsid LEFT JOIN senderid ON senderid.number = sms.number ORDER BY date_rec DESC";
	echo '<table cellpadding="0" cellspacing="0">
		<tr>
			<th style="padding:8px;">Edit</th>
			<th style="background-color:#D8D8D8;padding:8px;">SMS Received</th>
			<th style="padding:8px;">Phone</th>
			<th style="background-color:#D8D8D8;padding:8px;">Notes</th>
		</tr>';
	$result = mysql_query($query);
	while($row = mysql_fetch_array( $result )) {
		$style = '';
		if($row['actionable'] == 1) $style = 'background-color:#F2B2B7;';
		echo '
			<tr style="'.$style.'">
				<td style="padding:8px;"><a href="'.$link.''.$row['id'].'">'.$link_text.'</a></td>
				<td style="background-color:#D8D8D8;padding:8px;" nowrap>'.date("n/j h:i:s A",$row['date_rec']).'</td>
				<td style="padding:8px;">'.$row['number'].'</td>
				<td style="background-color:#D8D8D8;padding:8px;">
					<div><strong>Translator Notes:</strong> '.$row['notes'].'</div>';
					if($row['private_notes'] != '') echo '<div style="background-color:#BEFFBD"><strong>Private Notes:</strong> '.$row['private_notes'].'</div>';
				echo '</td>
			</tr>
		';
	}
	echo '<table>';
}


?>

<?php require_once('footer.php'); ?>