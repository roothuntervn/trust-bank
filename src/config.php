<?php
	
	require_once("secret.php");
	$db = new SQLite3('data.db');

	function get_data_by_username($username) {
	  global $db;
	  $stmt = $db->prepare("SELECT * FROM user WHERE username = :username");
	  $stmt->bindValue(':username', $username, SQLITE3_TEXT);
	  $result = $stmt->execute();
	  $data = $result->fetchArray();
	  return $data;
	}

	function get_data_by_username_password($username, $password) {
	  global $db;
	  $pw_hash = md5($password);
	  $stmt = $db->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
	  $stmt->bindValue(':username', $username, SQLITE3_TEXT);
	  $stmt->bindValue(':password', $pw_hash, SQLITE3_TEXT);
	  $result = $stmt->execute();
	  $data = $result->fetchArray();
	  return $data;
	}

	function get_multiusers($list_users) {
		global $db;
		foreach ($list_users as $user) {
			$data[$user] = get_data_by_username($user);
		}
		return $data;
	}

	function insert_user($username, $name, $password, $moneys) {
		global $db;
		$pw_hash = md5($password);
		$stmt = $db->prepare("INSERT INTO user VALUES(:username , :name , :password , :moneys)");
		$stmt->bindValue(':username', $username, SQLITE3_TEXT);
		$stmt->bindValue(':name', $name, SQLITE3_TEXT);
		$stmt->bindValue(':password', $pw_hash, SQLITE3_TEXT);
		$stmt->bindValue(':moneys', $moneys, SQLITE3_INTEGER);
		$result = $stmt->execute();
		return $result;
	}

	function update_data($data) {
		global $db;
		foreach ($data as $user) {
		    $stmt = $db->prepare("UPDATE user SET moneys = :moneys WHERE username = :username");
			$stmt->bindValue(':username', $user['username'], SQLITE3_TEXT);
			$stmt->bindValue(':moneys', $user['moneys'], SQLITE3_INTEGER);
			$stmt->execute();
		}
	}



?>