<?php
	include_once('Pokemon.php');
	include_once('User.php');
	
	class WildPokemon extends Pokemon {
		
		private $pdo;
		private $errors = [];
		/*stats, catch rate*/
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
			['Pidgey', 40, 45, 40, 35, 35, 56, 255]
		);
		
		/*
			PDO: database object
			$ownerID: valid id column from users database otherwise -1 to indicate wild pokemon
			$id: numeric pokedex number of the pokemon
			$level: numeric value 1-100 for the pokemons level
			$hp: numeric value of the pokemons hp
			$position: position in the party (or box) of the pokemon, assumed to be first
		*/
		public function __construct($pdo, $pokemonNo, $id, $level, $partyPosition=1) {	
			$this->pdo = $pdo;
			$this->pokemonNo = $pokemonNo;
			$this->id = $id;
			$this->level = $level;
			$this->partyPosition = $partyPosition;
			$this->name = $this->lookup[$pokemonNo][0];
			$this->catchRate = $this->lookup[$pokemonNo][7];
			$this->getAttacks();
			$this->generateIVs();
			$this->calculateStats();
		}
		
		private function calculateStats() {
			$tableEntry = $this->lookup[$this->pokemonNo];
			$this->maxHP = floor(((2*$tableEntry[1]+$this->hpIV)*$this->level/100)+$this->level+10);
			$this->currentHP = $this->maxHP;
			$this->attackStat = floor(((2*$tableEntry[2]+$this->hpIV)*$this->level/100)+5);
			$this->defenseStat = floor(((2*$tableEntry[3]+$this->hpIV)*$this->level/100)+5);
			$this->spAttackStat = floor(((2*$tableEntry[4]+$this->hpIV)*$this->level/100)+5);
			$this->spDefenseStat = floor(((2*$tableEntry[5]+$this->hpIV)*$this->level/100)+5);
			$this->speedStat = floor(((2*$tableEntry[6]+$this->hpIV)*$this->level/100)+5);
		}
		
		public function getAttacks() {
			$attacks = [2];
			$this->attacks = new AttackList($attacks);
		}
		
		public function getRandomAttack() {
			return $this->attacks->getRandomAttack();
		}
		
		public function tryCatch() {
			for($x=0;$x<4;$x++) {
				if(!$this->shakeCheck(1)) {
					return false;
				}
			}
			$this->insert();
			return true;
		}
		
		private function shakeCheck($ballBonus=1) {
			$a = (3 * $this->maxHP - 2 * $this->currentHP) * $this->catchRate * $ballBonus / (3 * $this->maxHP);
			if($a >= 255) {
				return true;
			}
			$rand = random_int(0, 65535);
			$b = 1048560 / floor(floor(sqrt(floor(sqrt(floor(16711680/$a))))));
			if($rand >= $b) {
				return false;
			}
			return true;
		}
		
		/*Do we need this if Pokemon has it?*/
		public function insert() {
			$owner = User::getFromID($this->pdo, $_SESSION['id']);
			$pos = $owner->getNewSlot();
			$this->ownerID = $_SESSION['id'];
			$this->partyPosition = $pos;
			$this->hp = $this->currentHP;
			$remove = ['attacks', 'name', 'pdo', 'errors', 'lookup', 'currentHP', 'maxHP', 'catchRate', 'id'];
			$pokemon = get_object_vars($this);
			foreach($remove as $value) {
				unset($pokemon[$value]);
			}
			$pokemon['exp'] = pow($pokemon['level'], 3);
			$sql = $this->pdo->prepare("INSERT INTO pokemon(".join(array_keys($pokemon), ',').") VALUES ('".join($pokemon, "','")."')"); //is this safe??
			$sql->execute();
		}
		
		public function __sleep() {
			return array_keys(getVars($this));
		}
		
		public function __wakeup() {
			include('Database.php');
			$this->pdo = $pdo;
		}
	}