<?php
	include('../../scripts/Database.php');
	include('../../scripts/Pokemon.php');
	include('../../scripts/WildPokemon.php');
	
	include('BattleState.php');
	
	session_start();
	
	if(!isset($_POST['attack'])) {
		echo json_encode("No attack found.");
		return;
	}
	
	$attackIndex = $_POST['attack'];
	
	$encounter = $_SESSION['encountered'];
	$pokemon = Pokemon::get($pdo, $_SESSION['id'], $_SESSION['active']);
	
	$attack = $pokemon->getAttack($attackIndex);
	$enemyAttack = $encounter->getRandomAttack();
	
	$playerDamage = $attack->calculateDamage($pokemon, $encounter);
	$enemyDamage = $enemyAttack->calculateDamage($encounter, $pokemon);
	
	$same = false;
	
	if($pokemon->speedStat == $encounter->speedStat) {
		$same = random_int(1, 2);
	}
	
	if($same == 1 || $pokemon->speedStat > $encounter->speedStat) { //player is faster
		$encounter->currentHP -= $playerDamage;
		if($encounter->currentHP <= 0) {
			$exp = $pokemon->calculateExp($encounter->pokemonNo, $encounter->level);
			if($pokemon->shouldLevel($pokemon->exp)) {
				echo json_encode([BattleState::WON, $exp, $pokemon->level+1]);
			}
			else {
				echo json_encode([BattleState::WON, $exp]);
			}
			unset($_SESSION['encountered']);
		}
		else {
			$pokemon->setHP($pokemon->hp - $enemyDamage);
			if($pokemon->hp <= 0) {
				$pokemon->hp = 0;
				echo json_encode([BattleState::PLAYERFAINTED, $enemyAttack->id, $enemyDamage]); //player fainted
			}
			else {
				echo json_encode([true, $playerDamage, $enemyAttack->id, $enemyDamage]);
			}
		}
	}
	else if($same == 2 || $encounter->speedStat > $pokemon->speedStat) {
		$pokemon->setHP($pokemon->hp - $enemyDamage);
		if($pokemon->hp <= 0) {
			$pokemon->hp = 0;
			echo json_encode([BattleState::PLAYERFAINTED, $enemyAttack->id, $enemyDamage]);
		}
		else {
			$encounter->currentHP -= $playerDamage;
			if($encounter->currentHP <= 0) {
				$exp = $pokemon->calculateExp($encounter->pokemonNo, $encounter->level);
				if($pokemon->shouldLevel($pokemon->exp)) {
					echo json_encode([BattleState::WON, $exp, $pokemon->level+1]);
				}
				else {
					echo json_encode([BattleState::WON, $exp]);
				}
				unset($_SESSION['encountered']);
			}
			else {
				echo json_encode([false, $playerDamage, $enemyAttack->id, $enemyDamage]);
			}
		}
	}
?>