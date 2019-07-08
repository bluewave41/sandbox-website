<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<link rel="stylesheet" href="battle.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/attacks.js"></script>
		<script src="../../static/code.js"></script>
		<script src="battle.js"></script>
	</head>
	<body>
		<?php
			include("../../scripts/Database.php");
			include("../../scripts/Pokemon.php");
			include("../../scripts/WildPokemon.php");
			include('../../static/links.php');
			
			if(!isset($_SESSION['encountered'])) {
				header('Location: ../index/index.php');
			}
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Battle</h1>
				<?php
					//check for session
					$encounteredPokemon = $_SESSION['encountered'];
					$playerPokemon = Pokemon::get($pdo, $_SESSION['id']);
					$_SESSION['active'] = 1;
					$playerAttacks = $playerPokemon->attacks->attacks;
					$encounterAttacks = $encounteredPokemon->attacks->attacks;
					echo '<table><tr>';
					echo '<td>'.$playerPokemon->name.'</td>';
					echo '<td>'.$encounteredPokemon->name.'</td></tr>';
					echo '<td><img src="../../sprites/'.$playerPokemon->pokemonNo.'.png"/></td>';
					echo '<td><img src="../../sprites/'.$encounteredPokemon->pokemonNo.'.png"/></td></tr>';
					echo '<td class="hp">HP: <span id="playerHP">'.$playerPokemon->hp.'</span></td>';
					echo '<td class="hp">HP: <span id="encounterHP">'.$encounteredPokemon->currentHP.'</span></td></tr>';
					//attacks
					for($x=0;$x<4;$x++) {
						echo '<tr>';
						if(isset($playerAttacks[$x])) {
							echo "<td id='$x' class='attack'>".$playerAttacks[$x]->name.'</td>';
						}
						if(isset($encounterAttacks[$x])) {
							echo '<td class="center">'.$encounterAttacks[$x]->name.'</td>';
						}
						echo '</tr>';
					}
					echo '</table>';
					echo '<button id="catch">Poke Ball</button>';
				?>
				<div id="log"></div>
			</div>
		</div>
	</body>
</html>