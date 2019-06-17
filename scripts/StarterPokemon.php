<?php
	include('Pokemon.php');
	
	class StarterPokemon extends Pokemon {
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
		public function __construct($pdo, $pokemonNo, $level, $partyPosition=1) {	
			$this->pdo = $pdo;
			$this->pokemonNo = $pokemonNo;
			$this->level = $level;
			$this->partyPosition = $partyPosition;
			$this->name = $this->lookup[$pokemonNo][0];
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
		
		private function validateStarter() {
			$starters = [1, 4, 7];
			if(empty($this->pokemonNo) || $this->pokemonNo == -1) {
				array_push($this->errors, "You must select a starter.");
			}
			else if(!in_array($this->pokemonNo, $starters)) {
				array_push($this->errors, "Invalid starter selected.");
			}
		}
		
		public function isValid() {
			$this->validateStarter();
			return count($this->errors) === 0;
		}
	}