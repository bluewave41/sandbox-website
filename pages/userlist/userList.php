<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="adminCode.js"></script>
		<script src="userList.js"></script>
		<script>
			$(document).ready(function() {
				createTable();
			});
		</script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
			if(!isset($_SESSION['username']) || !$_SESSION['admin']) {
				header('location:../testsite'); //doesn't work
				exit();
			}
		?>
		<div class="wrapper">
			<div class="container">
				<h1>User List</h1>
				<h2>Click a name to manage a user.</h2>
		</div>
		<div id="content">
			<table id="userList"></table>
		</div>
	</body>
</html>