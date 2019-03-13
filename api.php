<html>
	<head>
		<link rel="stylesheet" href="css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="code.js"></script>
	</head>
	<body>
		<?php
			include('links.php');
			if(!isset($_SESSION['username'])) {
				header('location:../testsite');
				exit();
			}
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Api</h1>
				<h2>All endpoints here require an apikey.</h2>
				</br>
				<h2>Get User List</h2>
				<h3>POST: http://127.0.0.1/testsite/api/api.php</h3>
				<h3>type: "getUserList"</h3>
				</br>
				
				<?php
					//session started in links, need to be logged in to view this page so admin will be set
					if($_SESSION['admin']) {
						echo "<h2>Get User Information</h2>
							  <h3>POST: http://127.0.0.1/testsite/api/api.php</h3>
							  <h3>type: 'getUserInfo'</h3>
							  <h3>username: 'root'</h3>
							  </br>";
					}
				?>
				
				<h1>Your keys</h1>
				<?php
					include('scripts/config.php');
					$statement = $pdo->prepare("SELECT apikey FROM apikeys WHERE id = ?");
					$statement->execute([$_SESSION['id']]);
					$keys = $statement->fetchAll();
					if(count($keys) == 0) {
						echo '<div id="keys">You have no keys.</div>';
					}
					else {
						echo '<div id="keys">';
						foreach($keys as $key) {
							echo '<div>'.$key['apikey'].'</div>';
						}
						echo '</div>';
					}
				?>
				<button id="generateKey">Generate key</button>
			</div>
		</div>
	</body>
</html>