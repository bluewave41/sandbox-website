<?php
	include('config.php');
	include('errors.php');
	include('utilities.php');
	
	$type = $_POST['type'];
	
	switch ($type) {
		case 'register':
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email    = $_POST['email'];
	
			if(doesAccountExist($pdo, $username)) {
				sendMessage(getError(-6));
				return;
			}
	
			if(validateAccount($pdo, $username, $password, $email)) {
				$password = hash('sha256', $password);
				$statement = $pdo->prepare("INSERT INTO users(username, password, email) VALUES(?, ?, ?)");
				$statement->execute([$username, $password, $email]);
	
				sendMessage([1, 'Account created successfully.']);
				break;
			}
		return;
		
		case 'login':
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			if(validateAccount($pdo, $username, $password, 'a')) {
				$password = hash('sha256', $password);
				$statement = $pdo->prepare("SELECT password FROM users WHERE username = ?");
				$statement->execute([$username]);
				$comparePassword = $statement->fetch()['password'];
			
				if($password === $comparePassword) {
					sendMessage([1, "Welcome ".$username]);
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['id'] = getID($pdo, $username);
					$_SESSION['admin'] = getAdmin($pdo, $username);
				}
				else {
					sendMessage(getError(-7));
				}
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
	
	function doesAccountExist($pdo, $username) {
		$statement = $pdo->prepare('SELECT username FROM users WHERE username = ?');
		$statement->execute([$username]);
		$user = $statement->fetch();
		return $user;
	}
	
	function validateAccount($pdo, $username, $password, $email) {
		$array = [];
		if(empty($username)) {
			sendMessage(getError(-1));
			return false;
		}
		if(empty($password)) {
			sendMessage(getError(-2));
			return false;
		}
		if(empty($email)) {
			sendMessage(getError(-3));
			return false;
		}
		if(!ctype_alnum($username)) {
			sendMessage(getError(-4));
			return false;
		}
		if(strlen($username) > 20) {
			sendMessage(getError(-5));
			return false;
		}
		return true;
	}
?>