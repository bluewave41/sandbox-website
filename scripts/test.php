<?php
	include('User.php');
	include('Database.php');
	$user = User::get($pdo, 'admin');
	print_r($user);
	$user->getBag();
	print_r($user);
?>