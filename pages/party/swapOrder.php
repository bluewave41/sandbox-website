<?php
	include("../../scripts/Database.php");
	
	if(!isset($_POST['ids'])) {
		echo 'No pokemon to swap.';
		return;
	}
	
	$ids = $_POST['ids'];
	$id1 = $ids[0];
	$id2 = $ids[1]; //TODO: ensure these are valid
	
	$statement = $pdo->prepare("UPDATE pokemon AS p1 JOIN pokemon AS p2 ON
							  (p1.A_I = ? AND p2.A_I = ?) SET
							  p1.partyPosition = p2.partyPosition,
							  p2.partyPosition = p1.partyPosition;");
	$statement->execute([$id1, $id2]);
?>