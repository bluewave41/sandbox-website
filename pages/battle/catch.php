<?php
	include('../../scripts/WildPokemon.php');
	include('BattleState.php');
	
	session_start();
	
	$pokemon = $_SESSION['encountered'];
	
	if($pokemon->tryCatch()) {
		unset($_SESSION['encountered']);
		echo json_encode([BattleState::CATCHSUCCESS]);
	}
	else {
		echo json_encode([BattleState::CATCHFAILURE]);
	}