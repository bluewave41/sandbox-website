<?php
include('config.php');

$type = $_POST['type'];

switch ($type) {
    case 'register':
        $username = $_POST['username'];
        $password = $_POST['password'];
		$email    = $_POST['email'];

        if(doesAccountExist($pdo, $username)) {
			sendMessage(-6, 'Username already exists.');
            exit();
        }

        if(validateAccount($pdo, $username, $password, $email)) {
            $password = hash('sha256', $password);
            $statement = $pdo->prepare("INSERT INTO users(username, password, email) VALUES(?, ?, ?)");
            $statement->execute([$username, $password, $email]);

            sendMessage(1, 'Account created successfully.');
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
				sendMessage(1, 'Welcome '.$username);
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['id'] = getID($pdo, $username);
			}
			else {
				sendMessage(-7, 'Username or password are incorrect.');
			}
		}
		break;
    case 'logout':
        session_start();
        session_destroy();
    break;
}

function getID($pdo, $username) {
	$statement = $pdo->prepare("SELECT id FROM users WHERE username = ?");
	$statement->execute([$username]);
	$id = $statement->fetch()['id'];
	return $id;
}

function doesAccountExist($pdo, $username) {
    $statement = $pdo->prepare('SELECT username FROM users WHERE username = ?');
    $statement->execute([$username]);
    $user = $statement->fetch();
    return $user;
}

function validateAccount($pdo, $username, $password, $email) {
	$array = [];
    if (empty($username)) {
		sendMessage(-1, 'Username cannot be empty.');
        return false;
    }
    if (empty($password)) {
		sendMessage(-2, 'Password cannot be empty.');
        return false;
    }
	if (empty($email)) {
		sendMessage(-3, 'Email cannot be empty.');
        return false;
    }
    if (!ctype_alnum($username)) {
		sendMessage(-4, 'Username contains invalid characters.');
        return false;
    }
    if (strlen($username) > 20) {
		sendMessage(-5, 'Usernames must be less than 20 characters.');
        return false;
    }
    return true;
}

function sendMessage($code, $message) {
	$array = [];
	if($code < 0) {
		$array['error'] = $code;
	}
	else {
		$array['status'] = $code;
	}
	$array['message'] = $message;
	echo json_encode($array);
}