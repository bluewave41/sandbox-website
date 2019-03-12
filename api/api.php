<?php
	include('../scripts/config.php');
	include('../scripts/utilities.php');
	include('../scripts/errors.php');
	
	$salt = '89fjk20jg9233';
	
	if(!isset($_POST['type'])) {
		sendMessage(getError(-10));
		return;
	}
	
	$type = $_POST['type'];
	
	if($type == 'generateKey') {
		session_start();
		if(!isset($_SESSION['username'])) {
			sendMessage(getError(-12));
			return;
		}
		$randomInt = random_int(100000000, 999999999);
		$key = sha1($salt.$randomInt.time());
		if(getNumberOfKeys($pdo) >= 5) {
			sendMessage(getError(-8));
		}
		else {
			$statement = $pdo->prepare("INSERT INTO apikeys(id, apikey) VALUES(?, ?)");
			$statement->execute([$_SESSION['id'], $key]); //TODO check for session exists
			sendMessage([1, $key]);
		}
		return;
	}
	else {
		if(!isset($_POST['apikey'])) {
			sendMessage(getError(-9));
			return;
		}
		$apikey = $_POST['apikey'];
		$sql = $pdo->prepare("SELECT apikey FROM apikeys WHERE apikey = ?");
		$sql->execute([$apikey]);
		if(!$sql->fetch()) {
			sendMessage(getError(-11));
			return;
		}
	}
	
	switch($type) {
		case "getUserList":
			$sql = $pdo->prepare("SELECT username FROM users");
			$sql->execute();
			echo json_encode($sql->fetchAll());
		break;
	}
	
	function getNumberOfKeys($pdo) {
		$statement = $pdo->prepare("SELECT COUNT(apikey) AS count FROM apikeys WHERE id = ?");
		$statement->execute([$_SESSION['id']]);
		return $statement->fetch()['count'];
	}
?>