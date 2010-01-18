<?php
session_start();
global $title;
require_once('db.php');
$title = msg('Add a Record');

/*
if(isset($_GET['sitepw'])) $_SESSION['sitepw'] = $_GET['sitepw'];
if(!isset($_SESSION['sitepw'])) $_SESSION['sitepw'] = 'wrongpw';

if($_SESSION['sitepw'] != 'volunteerforhaiti') {
	echo 'Sorry, you need proper credentials to access this form. <a href="http://4636.ushahidi.com">Go Back</a>.';
	die();
}
*/

if(!isset($_SESSION['wronglang'])) $_SESSION['wronglang'] = array();
if(isset($_GET['wronglang'])) {
	$skipid = (int)$_GET['wronglang'];
	$_SESSION['wronglang'][] = $skipid;
	set_sms_status($skipid,0);
}

// Making sure that the "data_entry" variable is in the URL to allow/disallow showing the data entry fields
$showDataEntryFields = false;
if(isset($_GET["data_entry"]) && $_GET["data_entry"] == 1)
	$showDataEntryFields = true;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php') ?>
	<?php include_once("sidebar.php"); ?>
	<div id="content">
			<?php
				if(isset($_GET['success'])){
					echo '<em>'.$_GET['success'].' entered into the database.</em>';
				}
				if(isset($_GET['junksuccess'])){
					echo '<em>SMS marked as not having enough information.</em>';
				}
			?>
			<form method="post" action="insert_post.php" enctype="multipart/form-data">
			<table>
				<?php 
				if(isset($_GET['sms'])){
				$grab_specific_sms = 0;
				if(isset($_GET['sneaksms'])) {
					$grab_specific_sms = $_GET['sneaksms'];
					?>
					<input type="hidden" id="sneaksms" name="sneaksms" value="<?php echo $_GET['sneaksms']; ?>" />
					<?php
				}
				$sms_message = get_available_sms($grab_specific_sms,$_SESSION['wronglang']);
				if($sms_message != false){
				?>
					<tr>
						<td colspan="2"><h3 style="color:#FF0000">You have 5 minutes to complete this form.<br/>
						Please <a href="http://wiki.ushahidi.com/doku.php?id=4636instructions">read the instructions</a> before you begin.</h3></td>
					</tr>
					<tr>
						<td colspan="2"><h3>What is this SMS trying to say?</h3></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo $sms_message['message']; ?><input type="hidden" id="fromsms" name="fromsms" value="<?php echo $sms_message['smsid']; ?>" />
							<br /><a href="insert_post.php?sms=1&junk=<?php echo $sms_message['smsid']; ?>">This SMS does not provide enough information.</a>
							<br /><a href="add_record.php?sms=1&wronglang=<?php echo $sms_message['smsid']; ?>">This SMS is in a language I don't understand.</a>
						</td>
					</tr>
				<?php 
				}else{
				?>
					<tr>
						<td colspan="2"><h3>The SMS queue is empty or there are no more messages in your language.</h3></td>
					</tr>
				<?php
				}
				}
				?>
				<tr>
					<td colspan="2"><h3>Enter information</h3></td>
				</tr>
				<tr>
					<td><label for="firstname">First Name</label></td>
					<td><input type="text" id="firstname" name="firstname" value="" /></td>
				</tr>
				<tr>
					<td><label for="lastname">Last Name</label></td>
					<td><input type="text" id="lastname" name="lastname" value="" /></td>
				</tr>
				<tr>
					<td><label for="gender_male">Gender</label></td>
					<td>
						<input type="radio" id="gender_male" name="gender" value="Male" />
						<label for="gender_male">Male</label>
						<input type="radio" id="gender_female" name="gender" value="Female" />
						<label for="gender_female">Female</label>
					</td>
				</tr>
				<tr>
					<td><label for="numppl"># of People</label></td>
					<td><input type="text" id="numppl" name="numppl" value="" /></td>
				</tr>
				<tr>
					<td><label for="status">Status</label></td>
					<td>
						<select id="status" name="status">
							<option></option>
							<option>Missing</option>
							<option>Survived</option>
							<option>Wounded</option>
							<option>Deceased</option>
							<option>Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="aid_type">Category/Aid Request</label></td>
					<td>
						<select id="aid_type" name="aid_type">
							<option></option>
							<option>1. Emergency</option>
							<option>--1a. Collapsed structure</option>
							<option>--1b. Fire</option>
							<option>--1c. People trapped</option>
							<option>--1d. Contaminated water supply</option>
							<option>--1e. Earthquake and aftershocks</option>
							<option>--1f. Medical Emergency</option>
							<option></option>
							<option>2. Threats</option>
							<option>--2a. Structures at risk</option>
							<option>--2b. Looting</option>
							<option></option>
							<option>3. Vital Lines</option>
							<option>--3a. Water shortage</option>
							<option>--3b. Road blocked</option>
							<option>--3c. Power Outage</option>
							<option></option>
							<option>4. Response</option>
							<option>--4a. Health services</option>
							<option>--4b. USAR Search and Rescue</option>
							<option>--4c. Shelter</option>
							<option>--4d. Food distribution</option>
							<option>--4e. Water sanitation and hygiene promotion</option>
							<option>--4f. Non food items</option>
							<option>--4g. Rubble removal</option>
							<option>--4h. Died bodies management</option>
							<option></option>
							<option>5. Other</option>
							<option></option>
							<option>6. Persons News</option>
							<option>--6a. Deaths</option>
							<option>--6b. Missing Persons</option>
							<option></option>
							<option>Asking to forward a message</option>
							<option></option>
						</select>
						<span style="color:#FF0000">&lt;--Very Important</span>
					</td>
				</tr>
				<!--
				<tr>
					<td><label for="actionable">Actionable</label></td>
					<td><input type="checkbox" id="actionable" name="actionable" value="1" /></td>
				</tr>
				-->
				
				
				<?php
					$google_api = 'ABQIAAAA20iipRVO9DuqFI34KrtxIRR3KpOuNhJ3d-RNRRAyj5nETMcuWhT-h0MEYQ-WjFwDJhpGFN1Ni0aifg';
					if(isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == '4636.ushahidi.com') $google_api = 'ABQIAAAA20iipRVO9DuqFI34KrtxIRTmID2xllfn5W0qE5PQdS01eExDARR7pDsyi3ZdvN65TogTeGOULc5rYw';
				?>
				<!-- google map api -->
				<script src="http://maps.google.com/maps?file=api&v=2.58&key=<?php echo $google_api; ?>" type="text/javascript"></script>
				
				<!-- pantopoint_js_ex.js -->
				<script src="getlatlon_js_ex.js"  language="JavaScript"type="text/javascript"></script>
				
				<!-- google map javascript -->
				<script language="JavaScript" type="text/javascript">
				<!--
				if (GBrowserIsCompatible()) {
				  var map = null;
				
				  // icon klick
				  var cicon = new GIcon();
				  cicon.image             = "/icon_pfeil_gruen.png";
				  cicon.shadow            = "/icon_pfeil_schatten.png";
				  cicon.iconSize          = new GSize(20, 20);
				  cicon.shadowSize        = new GSize(35, 20);
				  cicon.iconAnchor        = new GPoint(6, 20);
				  cicon.infoWindowAnchor  = new GPoint(5, 1);
				
				  // neue map initialisieren
				  function load() {
				    map = new GMap2(document.getElementById("map"));
				    map.addControl(new GLargeMapControl());
				    map.addControl(new GMapTypeControl());
				    //map.addControl(new GOverviewMapControl());
				    map.enableContinuousZoom();
				
				    // start position
				    map.setCenter(new GLatLng(18.5391667, -72.335), 10);
				
				    // markiere punkt in karte und zeige lat lon
				    GEvent.addListener(map, "click", function(overlay, cpoint){
				      //map.clearOverlays();
				        if (cpoint) {
				        map.panTo(cpoint);
				        lat = cpoint.lat();
				        lon = cpoint.lng();
				        document.getElementById('lat').value = lat;
				        document.getElementById('lon').value = lon;
				
				        // marker
				        var cmarker = new PdMarker(cpoint, cicon);
				        //cmarker.setHoverImage("img/icon_pfeil_grau.png");
				        //cmarker.setTooltip("<nobr><b>LAT</b> "+lat+"<br /><b>LON</b> "+lon+"</nobr>");
				        map.addOverlay(cmarker, cicon);
				        }
				    });
				  }
				
				  // map onload handler
				  if (window.attachEvent) {
				    window.attachEvent("onload", function() {
				      load();	// internet explorer
				    });
				  } else {
				    window.addEventListener("load", function() {
				      load(); // firefox und standard browser
				    }, false);
				  }
				}
				//-->
				</script>
				
				
				
				
				<tr>
					<td colspan="2">
						<!-- google map div -->
						<div id="map" style="width:550px; height:300px; border:1px solid #000000;"></div>
					</td>
				</tr>
				<tr style="background-color:#E2B1B1;">
					<td colspan="2">Without location information, we cannot act on this SMS. Please do your best to estimate where this message is asking us to respond.</td>
				</tr>
				<tr style="background-color:#E2B1B1;">
					<td><label for="lat">Latitude</label></td>
					<td><input type="text" id="lat" name="lat" value="" /> <span style="color:#FF0000">&lt;--Very Important</span></td>
				</tr>
				<tr style="background-color:#E2B1B1;">
					<td><label for="lon">Longitude</label></td>
					<td><input type="text" id="lon" name="lon" value="" /> <span style="color:#FF0000">&lt;--Very Important</span></td>
				</tr>
				<tr style="background-color:#E2B1B1;">
					<td><label for="address">Address</label></td>
					<td><input type="text" id="address" name="address" value="" /></td>
				</tr>
				<tr style="background-color:#E2B1B1;">
					<td><label for="city">City</label></td>
					<td><input type="text" id="city" name="city" value="" /></td>
				</tr>
				<tr style="background-color:#E2B1B1;">
					<td><label for="department">Department</label></td>
					<td>
						<select id="department" name="department">
							<option></option>
							<option>Artibonite</option>
							<option>Centre</option>
							<option>Grand'Anse</option>
							<option>Nippes</option>
							<option>Nord</option>
							<option>Nord-Est</option>
							<option>Nord-Ouest</option>
							<option>Ouest</option>
							<option>Sud-Est</option>
							<option>Sud</option>
						</select>
					</td>
				</tr>
				
				
				<tr><td colspan="2"><h3>Reporter Details</h3></tr>
				<tr>
					<td><label for="my_name">Name</label></td>
					<td><input type="text" id="my_name" name="my_name" value="" /></td>
				</tr>
				<tr>
					<td><label for="my_phone">Phone</label></td>
					<td><input type="text" id="my_phone" name="my_phone" value="<?php
						if(isset($sms_message)) echo $sms_message['number'];
					?>" /></td>
				</tr>
				
				<tr><td colspan="2"><h3>More Details</h3></tr>
				<tr>
					<td><label for="sms">Original SMS</label></td>
					<td><input type="text" id="sms" name="sms" value="<?php
						if(isset($sms_message)) echo htmlspecialchars($sms_message['message']);
					?>" style="width:400px;" /></td>
				</tr>
				<tr>
					<td><label for="notes">Translation and Notes</label></td>
					<td><textarea rows="8" cols="50" id="notes" name="notes"></textarea></td>
				</tr>
				
				<tr>
					<td colspan="2"><input type="submit" value="Submit" /></td>
				</tr>
				
			</table>
			</form>
	</div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>