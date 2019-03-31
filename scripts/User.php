<?php
	class User {
		
		private $pdo;
		private $errors = [];
		
		public $username;
		public $password;
		public $email;
		
		public function __construct($pdo, $username, $password, $email, $id=-1) {
			$this->pdo = $pdo;
			$this->username = $username;
			$this->password = $password;
			$this->email = $email;
			$this->id = $id;
		}
		
		public function errors() {
			return $this->errors;
		}
		
		public static function get($pdo, $username) {
			$statement = $pdo->prepare("SELECT username, password FROM users WHERE username = ?");
			$statement->execute([$username]);
			$user = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			return new User($pdo, $user['username'], $user['password'], '');
		}
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO users SET username=?, password=?, email=?");
			$sql->execute([$this->username, hash('sha256', $this->password), $this->email]);
		}
		
		/*Move to database?*/
		private function checkIfExists() {
			$statement = $this->pdo->prepare("SELECT username FROM users WHERE username = ?");
			$statement->execute([$this->username]);
			$user = $statement->fetch();
			if($user) {
				array_push($this->errors, "Username already exists.");
			}
		}
		
		public function isValid() {
			$this->checkIfExists();
			$this->validateName();
			$this->validatePassword();
			$this->validateEmail();
			return count($this->errors) === 0;
		}
		
		private function validateName() {
			if(empty($this->username)) {
				array_push($this->errors, "Username cannot be empty.");
			}
			if(!ctype_alnum($this->username) && !empty($this->username)) {
				array_push($this->errors, "Username contains invalid characters.");
			}
			if(strlen($this->username) > 20) {
				array_push($this->errors, "Username must be less than 20 characters.");
			}
		}
		
		private function validatePassword() {
			if(empty($this->password)) {
				array_push($this->errors, "Password cannot be empty.");
			}
		}
		
		private function validateEmail() {
			if(empty($this->email)) {
				array_push($this->errors, "Email cannot be empty.");
			}
		}
	}