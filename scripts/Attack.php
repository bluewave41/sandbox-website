<?php
	class Attack {
		public function __construct($id, $name, $power, $accuracy, $special) {
			$this->id = $id;
			$this->name = $name;
			$this->power = $power;
			$this->accuracy = $accuracy;
			$this->special = $special;
		}
		
		public function calculateDamage($playerPokemon, $otherPokemon) {
			$p1 = 2*$playerPokemon->level/5+2; //2xlevel/5 + 2
			$p1 *= $this->power; //times power
			if($this->special) {
				$p1 *= ($playerPokemon->spAttackStat/$otherPokemon->spDefenseStat);
			}
			else {
				$p1 *= ($playerPokemon->attackStat/$otherPokemon->defenseStat);
			}
			$p1 /= 50;
			$p1 += 2;
			$rand = random_int(85, 100)/100;
			return floor($p1 * $rand);
			//$modifier = 1; //implement later
		}
	}