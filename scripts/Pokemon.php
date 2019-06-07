<?php
	include('AttackList.php');
	
	/*Don't want to return private member variables for sleep*/
	function getVars($obj) {
		return get_object_vars($obj);
	}
	
	class Pokemon {
		
		private $pdo;
		private $errors = [];
		protected $lookup = array(
			[null],
			['Bulbasaur', 45, 49, 49, 65, 65, 45],
			[null],
			[null],
			['Charmander', 39, 52, 43, 60, 50, 65],
			[null],
			[null],
			['Squirtle', 44, 48, 65, 50, 64, 43],
			[null],
			[null],
			[null],
			[null],
			[null],
			[null],
			[null],
			[null],
			['Pidgey', 40, 45, 40, 35, 35, 56]
		);
		
		/*
			PDO: database object
			$ownerID: valid id column from users database otherwise -1 to indicate wild pokemon
			$id: numeric pokedex number of the pokemon
			$level: numeric value 1-100 for the pokemons level
			$hp: numeric value of the pokemons hp
			$position: position in the party (or box) of the pokemon, assumed to be first
		*/
		public function __construct($pdo, $pokemonID, $id, $level, $hp, $partyPosition=1) {	
			$this->pdo = $pdo;
			$this->pokemonID = $pokemonID;
			$this->id = $id;
			$this->level = $level;
			$this->hp = $hp;
			$this->partyPosition = $partyPosition;
			$this->name = $this->lookup[$pokemonID][0];
			$this->getAttacks();
		}
		
		public function errors() {
			return $this->errors;
		}
		
		public function generateIVs() {
			$this->hpIV = random_int(0, 31);
			$this->attackIV = random_int(0, 31);
			$this->defenseIV = random_int(0, 31);
			$this->spAttackIV = random_int(0, 31);
			$this->spDefenseIV = random_int(0, 31);
			$this->speedIV = random_int(0, 31);
			$this->calculateStats(); //only time we generate IV's stats won't be set
		}
		
		public function calculateStats($stats=null) {
			if($stats) {
				$this->hp = $stats['hp'];
				$this->attackStat = $stats['attackStat'];
				$this->defenseStat = $stats['defenseStat'];
				$this->spAttackStat = $stats['spAttackStat'];
				$this->spDefenseStat =$stats['spDefenseStat'];
				$this->speedStat = $stats['speedStat'];
			}
			else {
				$tableEntry = $this->lookup[$this->pokemonID];
				$this->hp = floor(((2*$tableEntry[1]+$this->hpIV)*$this->level/100)+$this->level+10);
				$this->attackStat = floor(((2*$tableEntry[2]+$this->hpIV)*$this->level/100)+5);
				$this->defenseStat = floor(((2*$tableEntry[3]+$this->hpIV)*$this->level/100)+5);
				$this->spAttackStat = floor(((2*$tableEntry[4]+$this->hpIV)*$this->level/100)+5);
				$this->spDefenseStat = floor(((2*$tableEntry[5]+$this->hpIV)*$this->level/100)+5);
				$this->speedStat = floor(((2*$tableEntry[6]+$this->hpIV)*$this->level/100)+5);
			}
		}
		
		public function setIVs($ivs) {
			$this->hpIV = $ivs[0];
			$this->attackIV = $ivs[1];
			$this->defenseIV = $ivs[2];
			$this->spAttackIV = $ivs[3];
			$this->spDefenseIV = $ivs[4];
			$this->speedIV = $ivs[5];
		}
		
		public function getAttacks() {
			if($this->id == -1) { //this pokemon is wild so we should pull from available moves
				$this->attacks = array('Leer');
			}
			else {
				$statement = $this->pdo->prepare("SELECT attack1, attack2, attack3, attack4 FROM pokemon WHERE id = ? AND partyPosition = ?");
				$statement->execute([$this->id, $this->partyPosition]);
				$attacks = array_values($statement->fetchAll()[0]);
				$this->attacks = new AttackList($attacks);
			}
		}
		
		private function validateStarter() {
			$starters = [1, 4, 7];
			if(empty($this->pokemonID) || $this->pokemonID == -1) {
				array_push($this->errors, "You must select a starter.");
			}
			else if(!in_array($this->pokemonID, $starters)) {
				array_push($this->errors, "Invalid starter selected.");
			}
		}
		
		public function isValid() {
			$this->validateStarter();
			return count($this->errors) === 0;
		}
		
		/*Send out first pokemon in the party if position isn't supplied*/
		public static function get($pdo, $id, $partyPosition=1) {
			//store active in session?
			$statement = $pdo->prepare("SELECT * FROM pokemon WHERE id = ? AND partyPosition = ?");
			$statement->execute([$id, $partyPosition]);
			$data = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			$ivs = [
				$data['hpIV'],
				$data['attackIV'],
				$data['defenseIV'],
				$data['spAttackIV'],
				$data['spDefenseIV'],
				$data['speedIV']				
			];
			$pokemon = new Pokemon($pdo, $data['pokemonID'], $data['id'], $data['level'], $data['hp'], $partyPosition);
			$pokemon->setIVs($ivs);
			$pokemon->calculateStats($data);
			return $pokemon;
		}
		
		public static function getPosition($pdo, $partyPosition) {
			$statement = $pdo->prepare("SELECT id, level, pokemonID, hp FROM pokemon WHERE partyPosition = ?");
			$statement->execute([$partyPosition]);
			$pokemon = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			return new Pokemon($pdo, $pokemon['id'], $pokemon['pokemonID'], $pokemon['level'], $pokemon['hp']);
		}
		
		/*Error check this*/
		public function insert() {
			$remove = ['attacks', 'name', 'pdo', 'errors', 'lookup'];
			$this->generateIVs(); //can't do this here when catching wild pokemon
			$pokemon = get_object_vars($this);
			foreach($remove as $value) {
				unset($pokemon[$value]);
			}
			$sql = $this->pdo->prepare("INSERT INTO pokemon(".join(array_keys($pokemon), ',').") VALUES ('".join($pokemon, "','")."')"); //is this safe??
			$sql->execute();
		}
		
		public function __sleep() {
			return array_keys(getVars($this));
		}
	}