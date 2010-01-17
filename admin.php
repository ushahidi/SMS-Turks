<?php

require_once 'db.php';

if (isset($_GET['logout'])) {
	setcookie('has_admin', '', time() - 86400);
	header('Location: /admin.php');
	exit;
}

if (count($_POST)) {
	if ($_POST['name'] == 'admin' && md5($_POST['name'] . $_POST['pass'] . 'famegame') == 'af6340e00dec073a4887febe59856deb') {
		setcookie('has_admin', 'af6340e00dec073a4887febe59856deb');
		header('Location: /admin.php');
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Haitian Quake Person Database</title>
<link rel="stylesheet" href="/style.css" type="text/css" />
<?php include('header.php') ?>
<h2>Haitian Quake Admin</h2></div>
<div style="clear:both"></div>
	<div id="content">
		<?php if (has_admin()): ?>
			You are logged in as admin. <a href="/admin.php?logout=true">Click Here</a> to log out.
		<?php else: ?>
			<form method="post">
				<table>
					<tr>
						<td colspan="2"><h3>Login to manage HaitianQuake.com</h3></td>
					</tr>
					<tr>
						<td><label for="name">Name</label></td>
						<td><input type="text" id="name" name="name" value="" /></td>
					</tr>
					<tr>
						<td><label for="pass">Password</label></td>
						<td><input type="password" id="pass" name="pass" value="" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Login" /></td>
					</tr>
				</table>
			</form>
		<?php endif; ?>
	</div>
</div>
</body>
</html>