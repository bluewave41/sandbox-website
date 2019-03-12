<html>
	<head>
		<link rel="stylesheet" href="css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="code.js"></script>
		<script>
			$(document).ready(function() {
				createTable();
			});
		</script>
	</head>
	<body>
		<?php
			include('links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<h1>User List</h1>
				<table id="userList">

				</table>
			</div>
		</div>
	</body>
</html>