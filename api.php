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
				<h2>Get User List</h2>
				<h3>POST: http://127.0.0.1/testsite/api/api.php</h3>
				<h3>type: "getUserList"</h3>
				</br>
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
						foreach($keys as $key) {
							echo '<div>'.$key['apikey'].'</div>';
						}
					}
				?>
				<button id="generateKey">Generate key</button>
			</div>
		</div>
	</body>
</html>