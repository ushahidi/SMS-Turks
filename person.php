<?php
header('Location:search_post.php');
require_once 'db.php';

// this is a person.
if (count($_POST) != 0) {
	if (isset($_POST['action']) && $_POST['action'] == 'comment') {
		add_comment($_GET['id'], $_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'photo') {
		handle_upload($_GET['id']);
	}
	else {
		update_record($_GET['id'], $_POST);
	}
}

if (!isset($_GET['id'])) {
	header('Location: /');
	exit;
}

$person = load_record($_GET['id']);
if (empty($person)) {
	header('Location: /');
	exit;
}
$updates = get_updates($_GET['id']);
$comments = get_comments($_GET['id']);
$photos = get_photos($_GET['id']);
$searcher = get_searcher($_GET['id']);

$title = $person['fullname'];
//$title = msg('People');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php') ?>
	<?php include_once("sidebar.php"); ?>
	<div id="content">
		<em><?php pmsg('Last Updated at '); ?><?php echo date('g:ia, F jS', $person['updated']); ?></em>
		<h3><?php pmsg('Enter information'); ?></h3>
		<form method="post">
			<table>
				<tr>
					<td><label for="firstname"><?php pmsg('First Name'); ?></label></td>
					<td><input type="text" id="firstname" name="firstname" value="<?php echo $person['firstname']; ?>" /></td>
				</tr>
				<tr>
					<td><label for="lastname"><?php pmsg('Last Name'); ?></label></td>
					<td><input type="text" id="lastname" name="lastname" value="<?php echo $person['lastname']; ?>" /></td>
				</tr>
				
				<tr>
					<td><label for="lat"><?php pmsg('Latitude'); ?></label></td>
					<td><input type="text" id="lat" name="lat" value="<?php echo $person['lat']; ?>" /></td>
				</tr>
				<tr>
					<td><label for="lon"><?php pmsg('Longitude'); ?></label></td>
					<td><input type="text" id="lon" name="lon" value="<?php echo $person['lon']; ?>" /></td>
				</tr>
				
				<tr>
					<td><label for="status"><?php pmsg('Status'); ?></label></td>
					<td>
						<select id="status" name="status">
							<option></option>
							<option <?php echo ($person['status'] == 'Missing') ? 'selected="selected"' : ''; ?>><?php pmsg('Missing'); ?></option>
							<option <?php echo ($person['status'] == 'Survived') ? 'selected="selected"' : ''; ?>><?php pmsg('Survived'); ?></option>
							<option <?php echo ($person['status'] == 'Wounded') ? 'selected="selected"' : ''; ?>><?php pmsg('Wounded'); ?></option>
							<option <?php echo ($person['status'] == 'Deceased') ? 'selected="selected"' : ''; ?>><?php pmsg('Deceased'); ?></option>
							<option <?php echo ($person['status'] == 'Other') ? 'selected="selected"' : ''; ?>><?php pmsg('Other'); ?></option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label for="aid_type">Aid Type</label></td>
					<td>
						<select id="aid_type" name="aid_type">
							<option></option>
							<option <?php echo ($person['aid_type'] == '1. Emergency') ? 'selected="selected"' : ''; ?>>1. Emergency</option>
							<option <?php echo ($person['aid_type'] == '--1a. Collapsed structure') ? 'selected="selected"' : ''; ?>>--1a. Collapsed structure</option>
							<option <?php echo ($person['aid_type'] == '--1b. Fire') ? 'selected="selected"' : ''; ?>>--1b. Fire</option>
							<option <?php echo ($person['aid_type'] == '--1c. People trapped') ? 'selected="selected"' : ''; ?>>--1c. People trapped</option>
							<option <?php echo ($person['aid_type'] == '--1d. Contaminated water supply') ? 'selected="selected"' : ''; ?>>--1d. Contaminated water supply</option>
							<option <?php echo ($person['aid_type'] == '--1e. Earthquake and aftershocks') ? 'selected="selected"' : ''; ?>>--1e. Earthquake and aftershocks</option>
							<option <?php echo ($person['aid_type'] == '--1f. Medical Emergency') ? 'selected="selected"' : ''; ?>>--1f. Medical Emergency</option>
							<option></option>
							<option <?php echo ($person['aid_type'] == '2. Threats') ? 'selected="selected"' : ''; ?>>2. Threats</option>
							<option <?php echo ($person['aid_type'] == '--2a. Structures at risk') ? 'selected="selected"' : ''; ?>>--2a. Structures at risk</option>
							<option <?php echo ($person['aid_type'] == '--2b. Looting') ? 'selected="selected"' : ''; ?>>--2b. Looting</option>
							<option></option>
							<option <?php echo ($person['aid_type'] == '3. Vital Lines') ? 'selected="selected"' : ''; ?>>3. Vital Lines</option>
							<option <?php echo ($person['aid_type'] == '--3a. Water shortage') ? 'selected="selected"' : ''; ?>>--3a. Water shortage</option>
							<option <?php echo ($person['aid_type'] == '--3b. Road blocked') ? 'selected="selected"' : ''; ?>>--3b. Road blocked</option>
							<option <?php echo ($person['aid_type'] == '--3c. Power Outage') ? 'selected="selected"' : ''; ?>>--3c. Power Outage</option>
							<option></option>
							<option <?php echo ($person['aid_type'] == '4. Response') ? 'selected="selected"' : ''; ?>>4. Response</option>
							<option <?php echo ($person['aid_type'] == '--4a. Health services') ? 'selected="selected"' : ''; ?>>--4a. Health services</option>
							<option <?php echo ($person['aid_type'] == '--4b. USAR Search and Rescue') ? 'selected="selected"' : ''; ?>>--4b. USAR Search and Rescue</option>
							<option <?php echo ($person['aid_type'] == '--4c. Shelter') ? 'selected="selected"' : ''; ?>>--4c. Shelter</option>
							<option <?php echo ($person['aid_type'] == '--4d. Food distribution') ? 'selected="selected"' : ''; ?>>--4d. Food distribution</option>
							<option <?php echo ($person['aid_type'] == '--4e. Water sanitation and hygiene promotion') ? 'selected="selected"' : ''; ?>>--4e. Water sanitation and hygiene promotion</option>
							<option <?php echo ($person['aid_type'] == '--4f. Non food items') ? 'selected="selected"' : ''; ?>>--4f. Non food items</option>
							<option <?php echo ($person['aid_type'] == '--4g. Rubble removal') ? 'selected="selected"' : ''; ?>>--4g. Rubble removal</option>
							<option <?php echo ($person['aid_type'] == '--4h. Died bodies management') ? 'selected="selected"' : ''; ?>>--4h. Died bodies management</option>
							<option></option>
							<option <?php echo ($person['aid_type'] == '5. Other') ? 'selected="selected"' : ''; ?>>5. Other</option>
							<option></option>
							<option <?php echo ($person['aid_type'] == '6. Persons News') ? 'selected="selected"' : ''; ?>>6. Persons News</option>
							<option <?php echo ($person['aid_type'] == '--6a. Deaths') ? 'selected="selected"' : ''; ?>>--6a. Deaths</option>
							<option <?php echo ($person['aid_type'] == '--6b. Missing Persons') ? 'selected="selected"' : ''; ?>>--6b. Missing Persons</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label for="address"><?php pmsg('Address'); ?></label></td>
					<td><input type="text" id="address" name="address" value="<?php echo $person['address']; ?>" /></td>
				</tr>
				<tr>
					<td><label for="city"><?php pmsg('City'); ?></label></td>
					<td><input type="text" id="city" name="city" value="<?php echo $person['city']; ?>" /></td>
				</tr>
				<tr>
					<td><label for="department"><?php pmsg('Department'); ?></label></td>
					<td>
						<select id="department" name="department">
							<option></option>
							<option <?php echo ($person['department'] == 'Artibonite') ? 'selected="selected"' : ''; ?>>Artibonite</option>
							<option <?php echo ($person['department'] == 'Centre') ? 'selected="selected"' : ''; ?>>Centre</option>
							<option <?php echo ($person['department'] == "Grand'Anse") ? 'selected="selected"' : ''; ?>>Grand'Anse</option>
							<option <?php echo ($person['department'] == 'Nippes') ? 'selected="selected"' : ''; ?>>Nippes</option>
							<option <?php echo ($person['department'] == 'Nord') ? 'selected="selected"' : ''; ?>>Nord</option>
							<option <?php echo ($person['department'] == 'Nord-Est') ? 'selected="selected"' : ''; ?>>Nord-Est</option>
							<option <?php echo ($person['department'] == 'Nord-Ouest') ? 'selected="selected"' : ''; ?>>Nord-Ouest</option>
							<option <?php echo ($person['department'] == 'Ouest') ? 'selected="selected"' : ''; ?>>Ouest</option>
							<option <?php echo ($person['department'] == 'Sud-Est') ? 'selected="selected"' : ''; ?>>Sud-Est</option>
							<option <?php echo ($person['department'] == 'Sud') ? 'selected="selected"' : ''; ?>>Sud</option>
						</select>
					</td>
				</tr>
				
				<tr><td colspan="2"><h3>Reporter Details</h3></tr>
				<tr>
					<td><label for="my_name"><?php pmsg('Name'); ?></label></td>
					<td><input type="text" id="my_name" name="my_name" value="" /></td>
				</tr>
				<tr>
					<td><label for="my_phone"><?php pmsg('Phone'); ?></label></td>
					<td><input type="text" id="my_phone" name="my_phone" value="" /></td>
				</tr>
				
				<tr><td colspan="2"><h3>More Details</h3></tr>
				<tr>
					<td><label for="sms">Original SMS</label></td>
					<td><input type="text" id="sms" name="sms" value="<?php echo $person['sms']; ?>" /></td>
				</tr>
				<tr>
					<td><label for="notes">Notes</label></td>
					<td><textarea rows="8" cols="50" id="notes" name="notes"><?php echo $person['notes']; ?></textarea></td>
				</tr>
				
				
				<tr>
					<td colspan="2"><input type="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>
		
		<div id="comments">
		<?php if (!empty($comments)): ?>
			<h3><?php pmsg('Notes'); ?></h3>
			<?php foreach($comments as $c): ?>
				<h4>By <?php print $c['name']; ?> at <?php echo date('m/d/y g:ia', $c['created']); ?></h4>
				<p class="comment">
					<?php print $c['comment']; ?>
				</p>
			<?php endforeach; ?>
			<?php endif; ?>
			<h3><?php pmsg('Add A Note'); ?></h3>
			<form method="post" id="comment-form">
				<input type="hidden" name="action" value="comment" />
				<p><?php pmsg('Your Name:'); ?> <input type="text" name="name" value="" /></p>
				<p><?php pmsg('Note:'); ?><br />
				<textarea rows="8" cols="50" name="comment"></textarea></p>
				<input type="submit" value="Send Comment" />
			
			</form>
			</div>

		<?php if (!empty($updates)): ?>
			<h3><?php pmsg('Changes Made'); ?></h3>
			<table class="data-table">
				<thead>
					<th><?php pmsg('Change'); ?></th>
					<th><?php pmsg('Old Version'); ?></th>
					<th><?php pmsg('New Version'); ?></th>
					<th><?php pmsg('Time'); ?></th>
				</thead>
				<tbody>
					<?php $count = -1; foreach($updates as $u): $count++; ?>
						 <?php $row_class = ($count % 2) ? 'odd' : 'even'; ?>
						<tr class="<?php echo $row_class; ?>"><td><?php echo $u['field']; ?></td><td><?php echo $u['old_version']; ?></td><td><?php echo $u['new_version']; ?></td><td><?php echo date('m/d/y g:ia', $u['created']); ?></td></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</div>
</body>
</html>