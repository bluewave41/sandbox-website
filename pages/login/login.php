<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/code.js"></script>
		<script src="login.js"></script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Login</h1>
				<?php
					if(isset($_SESSION['username'])) {
						header('location:../index/index.php');
						exit();
					}
				?>
				<div class="loader"></div>
				<div style="display: none" id="message" class="animate-bottom"></div>
				<form id="form">
					<input type="text" id="username" placeholder="username"></input>
					<input type="password" id="password" placeholder="password"></input>
					<button id="login">Login</button>
				</form>
			</div>
		</div>
	</body>
</html>