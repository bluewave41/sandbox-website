<div id="tabs">
	<a href="index.php">Home</a>
	<?php
		session_start();
		if(isset($_SESSION['username']) && $_SESSION['username']) {
			echo '<a id="logout" href="#">Logout</a>';
			echo '<a href="api.php">API</a>';
		}
		else {
			echo '<a href="register.php">Create Account</a> ';
			echo '<a href="login.php">Login</a>';
		}
	?>
	<a href="chat.html">Chat</a>
</div>