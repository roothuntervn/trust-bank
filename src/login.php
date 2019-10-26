<?php

$message = "";
session_start();
require_once("config.php");

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['login'])) {
	$pw_hash = md5($_POST['password']);
	$stmt = $db->prepare("SELECT * FROM user WHERE username = :username");
	$stmt->bindValue(':username', $_POST['username'], SQLITE3_TEXT);
	$result = $stmt->execute();
	$row = $result->fetchArray(SQLITE3_ASSOC);
	if (!$row) {
		$result = insert_user($_POST['username'], $_POST['username'], $_POST['password'], 1000);
		if ($result) {
			$message = "Sign up sucessfully! Go to <a href='index.php'>Bank</a>";
			$_SESSION['username'] = $_POST['username'];
		} else {
			$message = "WTF";
		}

	} else {
		$result = get_data_by_username_password($_POST['username'], $_POST['password']);
		if (!$result) {
			$message = "Wrong password, please login again!";
		} else {
			$_SESSION['username'] = $_POST['username'];
			$message = "Login successfully! Go to <a href='index.php'>Bank</a>";
		}
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Trust-Bank</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
<div class="container">
	<h2>Trust-Bank Login</h2>
	<form acion="" method="post">
		<div class="form-group">
			<label for="Username">Username</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
		</div>
		<button type="submit" class="btn btn-primary" name="login" value="login">Submit</button>
	</form><br>
	<div class="alert alert-danger">
		<?= isset($message)? $message : "" ?>
	</div>
</div>

</div>
</body>
</html>