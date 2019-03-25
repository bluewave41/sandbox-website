<?php
	include('../scripts/Database.php');
	include('../scripts/utilities.php');
	include('../scripts/errors.php');
	
	$salt = '89fjk20jg9233';
	
	if(!isset($_POST['type'])) {
		http_response_code(422);
		echo json_encode(array("message" => "You didn't provide an endpoint."));
		return;
	}
	
	$type = $_POST['type'];
	
	if($type == 'generateKey') {
		session_start();
		if(!isset($_SESSION['username'])) {
			http_response_code(401);
			echo json_encode(array("message" => "You aren't logged in."));
			return;
		}
		$randomInt = random_int(100000000, 999999999);
		$key = sha1($salt.$randomInt.time());
		if(getNumberOfKeys($pdo) >= 5) {
			http_response_code(403);
			echo json_encode(array("message" => "You already have the maximum number of keys."));
			return;
		}
		else {
			$statement = $pdo->prepare("INSERT INTO apikeys(id, apikey) VALUES(?, ?)");
			$statement->execute([$_SESSION['id'], $key]); //user is guaranteed to be logged in
			echo json_encode(array("key" => "$key"));
		}
		return;
	}
	else {
		if(!isset($_POST['apikey'])) {
			http_response_code(403);
			echo json_encode(array("message" => "You didn't provide an API key."));
			return;
		}
		$apikey = $_POST['apikey'];
		$sql = $pdo->prepare("SELECT apikey FROM apikeys WHERE apikey = ?");
		$sql->execute([$apikey]);
		if(!$sql->fetch()) {
			http_response_code(403);
			echo json_encode(array("message" => "Your API key is invalid."));
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
		
		default:
			http_response_code(404);
			echo json_encode(array("message" => "That endpoint doesn't exist."));
		break;
	}
	
	/*Gets all information about a user from the database.
	  Requires admin permissions.
	  Needs apikey and username.
	  Returns false if username doesn't exists otherwise information as JSON.
	  
	  TODO: change this to an admin only page instead of relying on admin api key
	*/
	function getUserInfo($pdo) {
		if(!isset($_POST['username'])) {
			http_response_code(422);
			echo json_encode(array("message" => "You didn't provide a username."));
			return;
		}
		$sql = $pdo->prepare("SELECT admin FROM users RIGHT JOIN apikeys ON users.id = apikeys.id WHERE apikey = ?");
		$sql->execute([$_POST['apikey']]);
		$admin = $sql->fetch()['admin'];
		if($admin) {
			$sql = $pdo->prepare("SELECT * FROM users WHERE username = ?");
			$sql->execute([$_POST['username']]);
			echo json_encode($sql->fetch());
		}
		else {
			http_response_code(403);
			echo json_encode(array("message" => "This endpoint requires admin privileges."));
			return;
		}
	}
	
	/*Updates a users information in the database.
	  Requires admin permissions.
	  Needs apikey.
	*/
	function updateUserInfo($pdo) {
		if(!isset($_POST['username'])) {
			http_response_code(422);
			echo json_encode(array("message" => "You didn't provide a username."));
			return;
		}
		//TODO: check that user exists
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