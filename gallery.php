<?php
global $title;
require_once('db.php');
$local_dev = true;

function get_gallery($pageLimit = 9,$page = 1)
{
	global $lastpage;
	global $photoCount;
	$gallery = array();
	$query = mysql_query("SELECT count(id) FROM person_photos photo") or die(mysql_error());
	$query_data = mysql_fetch_row($query);
	$photoCount = $query_data[0];
	$lastpage = ceil($photoCount/$pageLimit);
	$limit = 'LIMIT ' .($page - 1) * $pageLimit .',' .$pageLimit;
	$query = mysql_query("SELECT photo.*,person.fullname,person.gender,person.age,person.city FROM person_photos photo JOIN person person on person.id = photo.person_id ORDER BY created DESC $limit") or die(mysql_error());

	while ($row = mysql_fetch_assoc($query))
	{
		$gallery[] = array_map('stripslashes', $row);
	}
	return $gallery;
}

if (isset($_GET['p']))
{
	global $lastpage;
	$page = $_GET['p'];
	$pages = array();
	$title = msg('Photos');
	$pageLimit = 9;
	$gallery = get_gallery($pageLimit,$page);
	
	if ($page > 1)
		$previousPage = $page - 1;
	else
		$previousPage = 1;
	if ($page < $lastpage)
		$nextPage = $page + 1;
	else
		$nextPage = $lastpage;
		
	for($p=$page-3; $p<$page+4; $p++)
		if(($p>0) && ($p<$lastpage+1))
			$pages[] = $p;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php') ?>
	<?php include_once("sidebar.php"); ?>
	<div id="content">
		<div id="photo-list" style="width:660px">
			<div class="gallery-navigation">
				<?php if($page>1): ?>
					<a style="float: left; margin-left: 10px;" href="<?php echo "/gallery.php?p=".$previousPage; ?>">Previous</a>&nbsp&nbsp&nbsp
				<?php endif; ?>
				Showing results <?php $fromPhoto=(($page - 1) * $pageLimit)+1; $toPhoto=(($page - 1) * $pageLimit)+$pageLimit; echo $fromPhoto." to ".$toPhoto; ?> of <?php echo $photoCount; ?> people with photos
				<?php if($page<$lastpage): ?>
					<a style="float: right; margin-right: 10px;" href="<?php echo "/gallery.php?p=".$nextPage; ?>">Next</a>
				<?php endif; ?>
			</div>
			<div style="width: 640px; margin: 0 auto;">
			<?php
			foreach($gallery as $image)
			{
				//print_r($image);
				$url = $image["url"];
				$pid = $image["person_id"];
				$name = $image["fullname"];
				if(isset($image["fullname"]))
					$name = $image["fullname"];
				else
					$name = "Unknown Name";
				if(isset($image["age"]) && ($image["age"]) > 0)
					$age = ", ".$image["age"];
				else
					$age = "";
				if(isset($image["city"]))
					$city = $image["city"];
				else
					$city = "";
				$url = jit_resize('/' . $url, 'preview');
				echo "
				<a class=\"photo\" href=\"/person.php?id=$pid\"><div class=\"gallery\">
					<img src=\"$url\" alt=\"\" /><br />
					<div>$name<strong>$age</strong><br /><em>$city</em></div>
				</div></a>\n";
			}
			?>
			<br style="clear: both;" />
			</div>
			<div class="gallery-navigation">
				<?php if($page>1): ?>
					<a style="float: left; margin-left: 10px;" href="<?php echo "/gallery.php?p=".$previousPage; ?>">Previous</a>&nbsp&nbsp&nbsp
				<?php endif; ?>
				Jump to page: [<?php foreach($pages as $p){echo "<a href='http://dev.haitianquake.com/gallery.php?p=".$p."'>"; if($p==$page){echo "<b>".$p."</b>";}else{echo $p;} echo "</a> ";}?>]
				<?php if($page<$lastpage): ?>
					<a style="float: right; margin-right: 10px;" href="<?php echo "/gallery.php?p=".$nextPage; ?>">Next</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
}
?>