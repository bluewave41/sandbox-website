<?php
	include('config.php');
	$statement = $pdo->prepare("SELECT * FROM users");
	$statement->execute();
	$result = $statement->fetchAll();
	echo json_encode($result);
?>