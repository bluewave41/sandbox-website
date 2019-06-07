<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<link rel="stylesheet" href="battle.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/code.js"></script>
		<script src="battle.js"></script>
		<script src="pokemonList.js"></script>
	</head>
	<body>
		<?php
			include("../../scripts/Database.php");
			include("../../scripts/Pokemon.php");
			include('../../static/links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Battle</h1>
				<?php
					//check for session
					$encounteredPokemon = $_SESSION['encountered'];
					$playerPokemon = Pokemon::get($pdo, $_SESSION['id']);
					$playerAttacks = $playerPokemon->attacks->attacks;
					echo '<table><tr>';
					echo '<td>'.$playerPokemon->name.'</td>';
					echo '<td>'.$encounteredPokemon->name.'</td></tr>';
					echo '<td><img src="../../sprites/'.$playerPokemon->pokemonID.'.png"/></td>';
					echo '<td><img src="../../sprites/'.$encounteredPokemon->pokemonID.'.png"/></td></tr>';
					echo '<td class="hp">HP: '.$playerPokemon->hp.'</td>';
					echo '<td class="hp">HP: <span id="encounterHP">'.$encounteredPokemon->hp.'</span></td></tr>';
					//attacks
					for($x=0;$x<4;$x++) {
						echo '<tr>';
						if(isset($playerAttacks[$x])) {
							echo "<td id='$x' class='attack'>".$playerAttacks[$x]->name.'</td>';
						}
						if(isset($encounteredPokemon->attacks[$x])) {
							echo '<td class="center">'.$encounteredPokemon->attacks[$x].'</td>';
						}
						echo '</tr>';
					}
					echo '</table>';
				?>
				<div id="log"></div>
			</div>
		</div>
	</body>
</html>