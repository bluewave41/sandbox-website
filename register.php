<html>
	<head>
		<link rel="stylesheet" href="css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="code.js"></script>
	</head>
	<body>
		<?php
			include('links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Create Account</h1>
				<div class="loader"></div>
				<div style="display: none" id="message" class="animate-bottom"></div>
				<form id="form">
					<input type="text" id="username" placeholder="username"></input>
					<input type="password" id="password" placeholder="password"></input>
					<input type="text" id="email" placeholder="email"></input>
					<button id="register">Register</button>
				</form>
			</div>
		</div>
	</body>
</html>