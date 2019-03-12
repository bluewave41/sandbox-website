<?php
	include('../scripts/config.php');
	include('../scripts/utilities.php');
	
	$salt = '89fjk20jg9233';
	
	$type = $_POST['type'];
	
	switch($type) {
		case "getUserList":
			$sql = $pdo->prepare("SELECT username FROM users");
			$sql->execute();
			echo json_encode($sql->fetchAll());
		break;
		
		case "generateKey":
			session_start();
			$randomInt = random_int(100000000, 999999999);
			$key = sha1($salt.$randomInt.time());
			$statement = $pdo->prepare("INSERT INTO apikeys(id, apikey) VALUES(?, ?)");
			$statement->execute([$_SESSION['id'], $key]);
			echo $key;
		break;
	}
	
	function getNumberOfKeys() {
		$statement = $pdo->prepare("SELECT apikey FROM apikeys WHERE id = ?'");
		$statement->execute([$_SESSION['id']]);
	}
?>