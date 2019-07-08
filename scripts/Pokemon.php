<?php
	include('AttackList.php');
	
	/*Don't want to return private member variables for sleep*/
	function getVars($obj) {
		return get_object_vars($obj);
	}
	
	class Pokemon {
		private $pdo;
		private $errors = [];
		//hp, attack, defense, spatk, spdef, speed, exp
		protected $lookup = array(
			[null],
			['Bulbasaur', 45, 49, 49, 65, 65, 45, 64],
			[null],
			[null],
			['Charmander', 39, 52, 43, 60, 50, 65, 63],
			[null],
			[null],
			['Squirtle', 44, 48, 65, 50, 64, 43, 62],
			[null],
			[null],
			[null],
			[null],
			[null],
			[null],
			[null],
			[null],
			['Pidgey', 40, 45, 40, 35, 35, 56, 50]
		);
		
		/*
			PDO: database object
			$ownerID: valid id column from users database otherwise -1 to indicate wild pokemon
			$id: numeric pokedex number of the pokemon
			$level: numeric value 1-100 for the pokemons level
			$hp: numeric value of the pokemons hp
			$position: position in the party (or box) of the pokemon, assumed to be first
		*/
		public function __construct($pdo, $pokemonNo, $ownerID, $level, $partyPosition=1) {	
			$this->pdo = $pdo;
			$this->pokemonNo = $pokemonNo;
			$this->ownerID = $ownerID;
			$this->level = $level;
			$this->partyPosition = $partyPosition;
			$this->name = $this->lookup[$pokemonNo][0];
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
		
		private function calculateStats($stats=null) {
			if($stats) {
				$this->hp = $stats['hp'];
				$this->attackStat = $stats['attackStat'];
				$this->defenseStat = $stats['defenseStat'];
				$this->spAttackStat = $stats['spAttackStat'];
				$this->spDefenseStat =$stats['spDefenseStat'];
				$this->speedStat = $stats['speedStat'];
			}
			else {
				$tableEntry = $this->lookup[$this->pokemonNo];
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
		
		public function getAttack($index) {
			return $this->attacks->getAttackIndex($index);
		}
		
		public function getAttacks() {
			$statement = $this->pdo->prepare("SELECT attack1, attack2, attack3, attack4 FROM pokemon WHERE ownerID = ? AND partyPosition = ?");
			$statement->execute([$this->ownerID, $this->partyPosition]);
			$attacks = array_values($statement->fetchAll()[0]);
			$this->attacks = new AttackList($attacks);
		}
		
		public function getAttackNames() {
			$attacks = $this->attacks->attacks;
			return json_encode($attacks);
		}
		
		/*Send out first pokemon in the party if position isn't supplied*/
		public static function get($pdo, $ownerID, $partyPosition=1) {
			//store active in session?
			$statement = $pdo->prepare("SELECT * FROM pokemon WHERE ownerID = ? AND partyPosition = ?");
			$statement->execute([$ownerID, $partyPosition]);
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
			$pokemon = new Pokemon($pdo, $data['pokemonNo'], $data['ownerID'], $data['level'], $partyPosition);
			$pokemon->setIVs($ivs);
			$pokemon->calculateStats($data);
			$pokemon->exp = $data['exp'];
			return $pokemon;
		}
		
		
		public static function getPosition($pdo, $ownerID, $partyPosition) {
			$statement = $pdo->prepare("SELECT * FROM pokemon WHERE partyPosition = ? AND ownerID = ?");
			$statement->execute([$partyPosition, $ownerID]);
			$data = $statement->fetch();
			if($statement->rowCount() === 0) {
				return null;
			}
			$pokemon = new Pokemon($pdo, $data['pokemonNo'], $data['ownerID'], $data['level'], $partyPosition);
			$pokemon->exp = $data['exp'];
			return $pokemon;
		}
		
		/*Needs party position*/
		public function setHP($hp) {
			$statement = $this->pdo->prepare("UPDATE pokemon SET hp = ? WHERE ownerID = ?");
			$statement->execute([$hp, $this->ownerID]);
			$this->hp = $hp; //is this necessary?
		}
		
		/*Partypositions will be an array in the future, singular for now*/
		public function levelUp() {
			$statement = $this->pdo->prepare("UPDATE pokemon SET level = level+1 WHERE ownerID = ? AND partyPosition = ?");
			$statement->execute([$this->ownerID, $this->partyPosition]);
		}
		
		/*Doesn't work if multiple pokemon participate*/
		public function calculateExp($wildPokemonNo, $wildPokemonLevel) {
			$a = 1; //this is wrong
			$b = $this->lookup[$wildPokemonNo][7];
			$e = 1;
			$f = 1; //not going to bother with affection
			$L = $wildPokemonLevel;
			$p = 1;
			$s = 1; //this is wrong
			$t = 1;
			$v = 1;
			
			$exp = floor(($a*$t*$b*$e*$L*$p*$f*$v) / (7*$s));
			
			$statement = $this->pdo->prepare("UPDATE pokemon SET exp = exp+? WHERE ownerID = ? AND partyPosition = 1");
			$statement->execute([$exp, $this->ownerID]);
			$this->exp += $exp;
			return $exp;
		}
		
		public function shouldLevel($exp) {
			$requiredExp = pow($this->level+1, 3);
			if($exp >= $requiredExp) {
				$this->levelup();
				return true;
			}
			return false;
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