<div id="tabs">
	<a href="../index/index.php">Home</a>
	<?php
		session_start();
		if(isset($_SESSION['username']) && $_SESSION['username']) {
			echo '<a id="logout" href="#">Logout</a> ';
			echo '<a href="../api/api.php">API</a> ';
			echo '<a href="../party/party.php">Party</a> ';
			echo '<a href="../map/map.php">Map</a> ';
			if($_SESSION['admin']) {
				echo '<a href="../userlist/userList.php">User List</a> ';
			}
		}
		else {
			echo '<a href="../register/register.php">Create Account</a> ';
			echo '<a href="../login/login.php">Login</a> ';
		}
	?>
	<a href="chat.html">Chat</a>
</div>