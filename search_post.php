<?php
session_start();
require_once('db.php');

if (empty($_GET['page'])) $_GET['page'] = 0;
if (empty($_GET['name'])) $_GET['name'] = '';
if (empty($_GET['city'])) $_GET['city'] = '';

if (empty($_REQUEST['name']) && empty($_REQUEST['city'])) list($count, $results) = all_people();
else list($count, $results) = search_person($_REQUEST);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php') ?>
	<?php include_once("sidebar.php"); ?>
	<div id="content">
		<p>Texting emergency needs and location information to 4636 on Digicel allows anyone in Haiti to report issues, receive alerts and useful information and most importantly to get their emergency information to relief organizations on the ground in Haiti. These services are operated by a collaborating group of organizations including Ushahidi, InSTEDD, Thomson Reuters Foundation, Sahana and the US Dept of State and provide a channel for many response and information activities on the ground.</p>
		<p>Some of these reports are being aggregated on the website <a href="http://haiti.ushahidi.com/reports/submit/">http://haiti.ushahidi.com/reports/submit/</a>.</p>
		<iframe src="http://haiticrisis.appspot.com/?small=yes" width=350 height=300 frameborder=0 style="border: dashed 2px #77c"></iframe>

		
		<?php
		/*
		<p><?php pmsg('search_intro'); ?></p>
		<?php if (!$results) { ?>
		<?php pmsg('search_nothing_found'); ?>
		<?php } else { ?>
		<p>
			<?php $count = preg_replace("/\,/","",$count); ?>
				<?php pmsg('Showing Results'); ?> <?php print ($_GET['page'] * RESULTS_PER_PAGE) + 1; ?> <?php pmsg('to'); ?> <?php if(isset($_GET['page']))$p=$_GET['page']; else $p=0; print min($count, ($p * RESULTS_PER_PAGE) + RESULTS_PER_PAGE); ?> <?php pmsg('of'); ?> <?php print $count; ?>
		</p>
		
		
			<p id="pager">
				<?php if($count >= RESULTS_PER_PAGE){ ?>
				
					<?php if ($_GET['page'] > 0 ){ ?>
						<a href="/search_post.php?page=<?php print $_GET['page'] - 1; ?>&city=<?php print $_GET['city']; ?>&name=<?php print $_GET['name'];?>">&laquo;Previous</a>
					<?php } ?>
					&nbsp;
					<?php if ($_GET['page'] * RESULTS_PER_PAGE < $count - RESULTS_PER_PAGE){ ?>
						<a href="/search_post.php?page=<?php print $_GET['page'] + 1; ?>&city=<?php print $_GET['city']; ?>&name=<?php print $_GET['name'];?>">Next &raquo;</a>
					<?php } ?>
				<?php } ?>
			</p>
			
			
			
		<table class="data-table">
			<thead>
				<th>*</th>
				<th>Full Name</th>
				<th>Address</th>
				<th>City</th>
				<th>Department</th>
				<th>Lat/Lon</th>
				<th>Status</th>
				<th>SMS</th>
				<th>Categorization</th>
				<th>Notes</th>
			</thead>
			<tbody>
			<?php
				$row_count = -1;
				while ($row = mysql_fetch_assoc($results)) {
					$row_count++;
					$row = array_map('stripslashes', $row);
					$row_class = ($row_count % 2) ? 'odd' : 'even';
			?>
			<tr class="<?php echo $row_class; ?>">
				<td><?php //if($_SESSION['authenticated'] == 'PCY492My6U8arf') { ?><a href="/person.php?id=<?php echo $row['id']; ?>">Edit</a><?php }
				?></td>
				<td><?php echo $row['fullname'];?></td>
				<td><?php echo $row['address'];?></td>
				<td><?php echo $row['city'];?></td>
				<td><?php echo $row['department'];?></td>
				<td><?php echo $row['lat'].','.$row['lon']; ?></td>
				<td><?php echo $row['status'];?></td>
				<td><?php echo $row['sms'];?></td>
				<td><?php echo $row['aid_type'];?></td>
				<td><?php echo $row['notes'];?></td>
			</tr>
			<?php } ?>
			<tr><td colspan="5">
			<p id="pager">
			<?php $count = preg_replace("/\,/","",$count); ?>
				<?php if($count >= RESULTS_PER_PAGE){ ?>
				
					<?php if ($_GET['page'] > 0 ){ ?>
						<a href="/search_post.php?page=<?php print $_GET['page'] - 1; ?>&city=<?php print $_GET['city']; ?>&name=<?php print $_GET['name'];?>">&laquo;Previous</a>
					<?php } ?>
					&nbsp;
					<?php if ($_GET['page'] * RESULTS_PER_PAGE < $count - RESULTS_PER_PAGE){ ?>
						<a href="/search_post.php?page=<?php print $_GET['page'] + 1; ?>&city=<?php print $_GET['city']; ?>&name=<?php print $_GET['name'];?>">Next &raquo;</a>
					<?php } ?>
				<?php } ?>
			</p>
			</td></tr>
			</tbody>
		</table>
		<?php } ?>
		<?php */ ?>
	</div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>
