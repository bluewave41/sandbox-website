<?php
	include('../../scripts/Database.php');
	include('../../scripts/User.php');
	session_start();
	
	//if(!isset($_POST['items'])) {
	//	echo json_encode(["You don't have any items selected."]);
	//}
	
	$items = $_POST['items'];
	$costs = getItemCosts($pdo);
	$user = User::get($pdo, $_SESSION['username']);
	$total = 0;
	
	for($x=0;$x<count($items);$x++) {
		$total += $costs[$x] * $items[$x];
	}
	
	if($total > $user->money) {
		echo json_encode("You can't afford this!");
		return;
	}
	else {
		$user->money -= $total;
		$user->getBag();
		
		$user->update();
		echo json_encode("Purchase successful!");
	}
	
	function getItemCosts($pdo) { //figure out scoping here
		$statement = $pdo->prepare("SELECT cost FROM shopitems");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
	}
?>