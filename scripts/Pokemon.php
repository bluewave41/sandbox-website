<?php
	class Pokemon {
		
		private $pdo;
		private $errors = [];
		
		/*
			PDO: database object
			$ownerID: valid id column from users database otherwise -1 to indicate wild pokemon
			$id: numeric pokedex number of the pokemon
			$level: numeric value 1-100 for the pokemons level
			$hp: numeric value of the pokemons hp
			$position: position in the party (or box) of the pokemon, assumed to be first
		*/
		public function __construct($pdo, $ownerID, $id, $level, $hp, $position=1) {	
			$this->pdo = $pdo;
			$this->ownerID = $ownerID;
			$this->id = $id;
			$this->level = $level;
			$this->hp = $hp;
			$this->position = $position;
			$this->name = $this->getName();
			$this->getAttacks();
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
			if($this->ownerID == -1) { //this pokemon is wild so we should pull from available moves
				$this->attacks = array('Leer');
			}
			else {
				$statement = $this->pdo->prepare("SELECT name FROM pokemon AS p LEFT JOIN attacks AS a ON p.attack1 = a.id OR p.attack2 = a.id OR p.attack3 = a.id OR p.attack4 = a.id
											  WHERE p.id = ? AND p.partyPosition = ?");
				$statement->execute([$this->ownerID, $this->position]);
				$this->attacks = array_values($statement->fetchAll(PDO::FETCH_COLUMN, 0));
			}
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
		
		/*Send out first pokemon in the party if position isn't supplied*/
		public static function get($pdo, $id, $position=1) {
			$statement = $pdo->prepare("SELECT id, pokemonID, hp, level FROM pokemon WHERE id = ? AND partyPosition = ?");
			$statement->execute([$id, $position]);
			$pokemon = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			return new Pokemon($pdo, $pokemon['id'], $pokemon['pokemonID'], $pokemon['level'], $pokemon['hp'], $position);
		}
		
		public static function getPosition($pdo, $position) {
			$statement = $pdo->prepare("SELECT id, level, pokemonID, hp FROM pokemon WHERE partyPosition = ?");
			$statement->execute([$position]);
			$pokemon = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			return new Pokemon($pdo, $pokemon['id'], $pokemon['pokemonID'], $pokemon['level'], $pokemon['hp']);
		}
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO pokemon SET id=?, pokemonID=?, hp=?");
			$sql->execute([$this->ownerID, $this->id, $this->hp]);
		}
		
		public function serialize() {
			return array('ownerID' => $this->ownerID, 'id' => $this->id, 'level' => $this->level, 'hp' => $this->hp, 'name' => $this->name, 'attacks' => $this->attacks);
		}
		
		/*Move to database?*/
		private function checkIfExists() {}
		
		public function isValid() {}
	}