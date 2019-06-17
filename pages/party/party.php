<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<link rel="stylesheet" href="party.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script src="../../static/code.js"></script>
		<script src="party.js"></script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<?php
					//session started in links.php
					include("../../scripts/Database.php");
					include("../../scripts/User.php");
					include("../../scripts/Party.php");
					$user;
					if(isset($_GET['username'])) { //TODO: validate this
						try {
							$user = User::get($pdo, $_GET['username'])->id;
							echo "<h1>".$_GET['username'] . "'s Party</h1>";
						}
						catch(\Exception $e) {
							echo "<h1>This username doesn't exist.</h1>";
							return;
						}
					}
					else if(isset($_SESSION['id']) && $_SESSION['id']) { //TODO: do we need both of these?
						$user = $_SESSION['id'];
						echo "<h1>Your Party</h1>";
					}
					else {
						echo "No party exists."; //TODO: better message her
						return;
					}
					$party = new Party($pdo, $user); //TODO: doesn't work on GET
					
					echo "<table>";
					foreach($party->values as $pokemon) {
						echo "<tr id=$pokemon[A_I]>";
						echo "<td><div>$pokemon[name]</div></td>";
						echo "<td><img src='../../sprites/$pokemon[pokemonNo].png'/></td>";
						echo "<td><div>$pokemon[hp]</div></td>";
					}
					echo "</table>";
					//$statement = $pdo->prepare("SELECT p.A_I, p.ownerID, pokemonNo, hp, name FROM pokemon AS p LEFT JOIN pokemonlookup AS pl ON p.pokemonNo = pl.id WHERE p.id = ?");
					
				?>
			</div>
		</div>
	</body>
</html>