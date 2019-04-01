<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<link rel="stylesheet" href="register.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/code.js"></script>
		<script src="register.js"></script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
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
					<div>
						<span><img class="starter" id="1" src="../../sprites/1.png"/></span>
						<span><img class="starter" id="4" src="../../sprites/4.png"/></span>
						<span><img class="starter" id="7" src="../../sprites/7.png"/></span>
					</div>
					<button id="register">Register</button>
				</form>
			</div>
		</div>
	</body>
</html>