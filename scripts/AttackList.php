<?php
	include ('Attack.php');
	
	class AttackList {
		//id, name, power, accuracy, physical = false special = true
		protected $attackLookup = array(
			[1, 'Tackle', 60, 100, false]
		);
		
		public function __construct($attacks) {
			$this->attacks = [];
			$this->getAttacks($attacks);
		}
		
		public function addAttack(Attack $attack) {
			array_push($this->attacks, $attack);
		}
		
		public function getAttack($id) {
			return $attackLookup[$id];
		}
		
		public function getAttacks($pokemonAttacks) {
			foreach($pokemonAttacks as $attack) {
				foreach($this->attackLookup as $column) {
					if($column[0] == $attack) {
						array_push($this->attacks, new Attack($column[1], $column[2], $column[3], $column[4]));
					}
				}
			}
			//if(count($this->attacks) != count($pokemonAttacks)) {
			//	echo 'lul bad things';
			//}
		}
	}