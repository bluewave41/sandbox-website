<?php
	class Pokemon {
		
		private $pdo;
		private $errors = [];
		
		public function __construct($pdo, $ownerID, $id) {	
			$this->pdo = $pdo;
			$this->ownerID = $ownerID;
			$this->id = $id;
			$this->hp = rand(1, 30);
		}
		
		public function errors() {
			return $this->errors;
		}
		
		private function validateStarter() {
			$starters = [1, 4, 7];
			if(empty($this->starter) || $this->starter == -1) {
				array_push($this->errors, "You must select a starter.");
			}
			else if(!in_array($this->starter, $starters)) {
				array_push($this->errors, "Invalid starter selected.");
			}
		}
		
		public static function get($pdo, $username) {}
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO pokemon SET id=?, pokemonID=?, hp=?");
			$sql->execute([$this->ownerID, $this->id, $this->hp]);
		}
		
		/*Move to database?*/
		private function checkIfExists() {}
		
		public function isValid() {}
	}