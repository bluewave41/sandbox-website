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
				<?php
					//session started in links.php
					include("scripts/Database.php");
					include("scripts/User.php");
					$user;
					if(isset($_GET['username'])) { //TODO: validate this
						try {
							$user = User::get($pdo, $_GET['username'])->id;
							echo "<h1>".$_GET['username'] . "'s Party</h1>";
						}
						catch(Exception $e) {
							echo "<h1>This username doesn't exist.</h1>";
						}
					}
					else if(isset($_SESSION['id']) && $_SESSION['id']) {
						$user = $_SESSION['id'];
						echo "<h1>Your Party</h1>";
					}
					else {
						echo "No party exists.";
						return;
					}
					$statement = $pdo->prepare("SELECT p.id, pokemonID, hp, name FROM pokemon AS p LEFT JOIN pokemonlookup AS pl ON p.pokemonID = pl.id WHERE p.id = ?");
					$statement->execute([$user]);
					$pokemonArray = $statement->fetchAll();
					echo "<table>";
					foreach($pokemonArray as $pokemon) {
						echo "<tr>";
						echo "<td><div>$pokemon[name]</div></td>";
						echo "<td><img src='sprites/$pokemon[pokemonID].png'/></td>";
						echo "<td><div>$pokemon[hp]</div></td>";
					}
					echo "</table>";
				?>
			</div>
		</div>
	</body>
</html>