<div id="tabs">
	<div style="color: black; text-align: center">July 8 2019 version</div>
	<a href="../index/index.php">Home</a>
	<?php
		session_start();
		if(isset($_SESSION['username']) && $_SESSION['username']) {
			echo '<a id="logout" href="#">Logout</a> ';
			echo '<a href="../api/api.php">API</a> ';
			echo '<a href="../party/party.php">Party</a> ';
			echo '<a href="../map/map.php">Map</a> ';
			echo '<a href="../bag/bag.php">Bag</a> ';
			echo '<a href="../shop/shop.php">Shop</a> ';
			if($_SESSION['admin']) {
				echo '<a href="../userlist/userList.php">User List</a> ';
				//echo '<a href="../userlist/userList.php">User List</a> ';
			}
		}
		else {
			echo '<a href="../register/register.php">Create Account</a> ';
			echo '<a href="../login/login.php">Login</a> ';
		}
	?>
	<!--<a href="chat.html">Chat</a>-->
</div>