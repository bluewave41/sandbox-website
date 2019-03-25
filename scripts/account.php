<?php
	include('Database.php');
	include('utilities.php');
	require('User.php');
	require('Pokemon.php');
	
	$type = $_POST['type'];
	
	switch ($type) {
		case 'register':
			$user = new User($pdo, $_POST['username'], $_POST['password'], $_POST['email'], $_POST['starter']);
			if($user->isValid()) {
				$user->insert();
				$ownerID = $pdo->lastInsertId();
				$pokemon = new Pokemon($pdo, $ownerID, $_POST['starter']);
				$pokemon->insert();
				sendMessage(["Account created successfully."]);
			}
			else {
				sendMessage($user->errors());
			}
		return;
		
		case 'login':
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$user = User::get($pdo, $username);
			if($user) {
				$hashed = hash('sha256', $password);
				if($hashed === $user->password) {
					sendMessage(["Welcome ".$username]);
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['id'] = getID($pdo, $username);
					$_SESSION['admin'] = getAdmin($pdo, $username);
				}
				else {
					sendMessage(["Username or password are incorrect."]);
				}
			}
			else {
				sendMessage(["Username wasn't found."]);
			}
			break;
		case 'logout':
			session_start();
			session_destroy();
		break;
	}
	
	/*Possibly condense this into getField*/
	function getID($pdo, $username) {
		$statement = $pdo->prepare("SELECT id FROM users WHERE username = ?");
		$statement->execute([$username]);
		$id = $statement->fetch()['id'];
		return $id;
	}
	
	/*Possibly condense this into getField*/
	function getAdmin($pdo, $username) {
		$statement = $pdo->prepare("SELECT admin FROM users WHERE username = ?");
		$statement->execute([$username]);
		$admin = $statement->fetch()['admin'];
		return $admin;
	}
?>