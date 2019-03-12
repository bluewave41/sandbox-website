<?php
	include('config.php');
	$statement = $pdo->prepare("SELECT username FROM users");
	$statement->execute();
	$result = $statement->fetchAll();
	echo json_encode($result);
?>