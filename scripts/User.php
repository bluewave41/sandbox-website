<?php
	include('Bag.php');
	
	class User {
		
		private $pdo;
		private $errors = [];
		
		public $username;
		public $password;
		public $email;
			
		public function __construct($pdo, $username, $password, $email) {
			$this->pdo = $pdo;
			$this->username = $username;
			$this->password = $password;
			$this->email = $email;
		}
		
		public function errors() {
			return $this->errors;
		}
		
		public static function get($pdo, $username) {
			$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?");
			$statement->execute([$username]);
			if($statement->rowCount() === 0) {
				throw new Exception("Username wasn't found."); //handle error
			}
			$data = $statement->fetch();
			$user = new User($pdo, $data['username'], $data['password'], $data['email']);
			foreach($data as $key => $value) {
				$user->$key = $value;
			}
			return $user;
		}
		
		/*Can only be called on a user fetched with get*/
		public function getBag() {
			$this->bag = Bag::get($this->pdo, $this->id);
		}
		
		//username should be unique here but maybe use ID instead later?
		public function update() {
			$statement = $this->pdo->prepare("UPDATE users SET money = ? WHERE username = ?");
			$statement->execute([$this->money, $this->username]);
		}
		
		/*Error check this*/
		public function insert() {
			$this->money = 5000; //TEST
			$sql = $this->pdo->prepare("INSERT INTO users SET username=?, password=?, email=?, money=?");
			$sql->execute([$this->username, hash('sha256', $this->password), $this->email, $this->money]);
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