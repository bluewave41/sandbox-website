<?php
	class Pokemon {
		
		private $pdo;
		private $errors = [];
		
		public function __construct($pdo, $ownerID, $id, $level, $hp) {	
			$this->pdo = $pdo;
			$this->ownerID = $ownerID;
			$this->id = $id;
			$this->level = $level;
			$this->hp = $hp;
			$this->name = $this->getName();
		}
		
		public function errors() {
			return $this->errors;
		}
		
		private function getName() {
			$statement = $this->pdo->prepare("SELECT name FROM pokemonLookup WHERE id = ?");
			$statement->execute([$this->id]);
			return $statement->fetch()['name'];
		}
		
		public function getAttacks() {
			$statement = $this->pdo->prepare("SELECT * FROM pokemon AS p LEFT JOIN attacks AS a ON p.attack1 = a.id OR p.attack2 = a.id OR p.attack3 = a.id OR p.attack4 = a.id");
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
		
		public static function get($pdo, $id) {
			$statement = $pdo->prepare("SELECT id, pokemonID, hp FROM pokemon WHERE id = ?");
			$statement->execute([$id]);
			$pokemon = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			return new Pokemon($pdo, $pokemon['id'], $pokemon['pokemonID'], 5, 30);
		}
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO pokemon SET id=?, pokemonID=?, hp=?");
			$sql->execute([$this->ownerID, $this->id, $this->hp]);
		}
		
		public function serialize() {
			return array('ownerID' => $this->ownerID, 'id' => $this->id, 'level' => $this->level, 'hp' => $this->hp, 'name' => $this->name);
		}
		
		/*Move to database?*/
		private function checkIfExists() {}
		
		public function isValid() {}
	}