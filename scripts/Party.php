<?php
	class Party extends Collection {
			
		public function __construct($pdo, $id) {
			parent::__construct($pdo, $id, 'pokemon');
		}
		
		public function errors() {
			return $this->errors;
		}
		
		/*
			Overloaded Collection::get
			ONLY RUN ON SESSION DATA. NEVER SEND ID BY PARAMETER
		*/
		public function get($pdo, $id, $tableName) {
			$statement = $pdo->prepare("SELECT * FROM pokemon AS p LEFT JOIN pokemonLookup AS pl ON p.pokemonNo = pl.pokemonNo WHERE p.ownerID = ? AND partyPosition < 6 ORDER BY partyPosition ASC");
			$statement->execute([$id]);
			if($statement->rowCount() === 0) {
				return null;
			}
			$data = $statement->fetchAll();
			foreach($data as $item) {
				$this->addValue($item);
			}
		}
		
		//username should be unique here but maybe use ID instead later?
		public function update() {
			$statement = $this->pdo->prepare("UPDATE users SET money = ? WHERE username = ?");
			$statement->execute([$this->money, $this->username]);
		}
		
		/*Error check this*/
		public function insert() {
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
	}