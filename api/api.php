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
		
		case "getUserInfo":
			getUserInfo($pdo);
		break;
		
		case "updateUserInfo":
			updateUserInfo($pdo);
		break;
	}
	
	/*Gets all information about a user from the database.
	  Requires admin permissions.
	  Needs apikey and username.
	  Returns false if username doesn't exists otherwise information as JSON.
	*/
	function getUserInfo($pdo) {
		if(!isset($_POST['username'])) {
			sendMessage(getError(-14));
			return;
		}
		$sql = $pdo->prepare("SELECT admin FROM users RIGHT JOIN apikeys ON users.id = apikeys.id WHERE apikey = ?");
		$sql->execute([$_POST['apikey']]);
		$admin = $sql->fetch()['admin'];
		if($admin) {
			$sql = $pdo->prepare("SELECT * FROM users WHERE username = ?");
			$sql->execute([$_POST['username']]);
			sendMessage([1, $sql->fetch()]);
		}
		else {
			sendMessage(getError(-13));
		}
	}
	
	/*Updates a users information in the database.
	  Requires admin permissions.
	  Needs apikey.
	*/
	function updateUserInfo($pdo) {
		if(!isset($_POST['username'])) {
			sendMessage(getError(-14));
			return;
		}
		$sql = $pdo->prepare("UPDATE users SET username = ?, password = ?, email = ?, admin = ? WHERE id = ?");
		$sql->execute([$_POST['username'], $_POST['password'], $_POST['email'], $_POST['admin'], $_POST['id']]);
	}
	
	/*Returns the number of apikeys a user has registered.
	  Internal use only.
	*/
	function getNumberOfKeys($pdo) {
		$statement = $pdo->prepare("SELECT COUNT(apikey) AS count FROM apikeys WHERE id = ?");
		$statement->execute([$_SESSION['id']]);
		return $statement->fetch()['count'];
	}
?>