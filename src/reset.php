<?php
	
	session_start();
	require_once("config.php");

	$data = get_multiusers(array("bill_gate", "mark", "drx", $_SESSION["username"]));
	$data["bill_gate"]["moneys"] = 3566900000;
	$data["mark"]["moneys"] = 2908301000;
	$data["drx"]["moneys"] = 20499700;
	$data[$_SESSION["username"]]["moneys"] = 1000;
	update_data($data);
	header("Location: index.php");
	die();

?>