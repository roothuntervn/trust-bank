<?php
	session_start();
	require_once("config.php");
	
    if (!isset($_SESSION['username'])) {
    	header("Location: login.php");
    	exit();
    }

	if (isset($_POST['fromAcc']) && isset($_POST['toAcc']) && isset($_POST['money']) && isset($_POST['auth'])) {
		$fromAcc = $_POST['fromAcc'];
		$toAcc = $_POST['toAcc'];
		$money = $_POST['money'];
		$auth = $_POST['auth'];
		$data = get_multiusers(array("bill_gate", "mark", "drx", $_SESSION['username']));

		if (array_key_exists($fromAcc, $data) && array_key_exists($toAcc, $data) && $data[$fromAcc]["moneys"] >= $money && is_numeric($money) && $money > 0 && $auth == 1) {
			$_SESSION['message'] = "Transfer $money $ from account $fromAcc to account $toAcc successfully!";

			$data[$fromAcc]["moneys"] -= $money;
			$data[$toAcc]["moneys"] += $money;

			update_data($data);

			if ($data[$_SESSION["username"]]["moneys"] > $data["drx"]["moneys"] && $data[$_SESSION["username"]]["moneys"] > $data["bill_gate"]["moneys"] && $data[$_SESSION["username"]]["moneys"] > $data["mark"]["moneys"])
				$_SESSION['message'] = $flag;
		} else {
			$_SESSION['message'] = "Transfer fail!";
		}
	}
?>