<html>
	<head>
		<link rel="stylesheet" href="css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="code.js"></script>
		<script src="pokemonList.js"></script>
	</head>
	<body>
		<?php
			include("scripts/Database.php");
			include("scripts/Pokemon.php");
			include('links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Battle</h1>
				<?php
					//check for session
					$encounteredPokemon = $_SESSION['encountered'];
					$pokemonToUse = Pokemon::get($pdo, $_SESSION['id']);
					echo '<table><tr>';
					echo '<td>'.$pokemonToUse->name.'</td>';
					echo '<td>'.$encounteredPokemon['name'].'</td></tr>';
					echo '<td><img src="sprites/'.$pokemonToUse->id.'.png"/></td>';
					echo '<td><img src="sprites/'.$encounteredPokemon['id'].'.png"/></td></tr>';
					echo '<td class="hp">'.$pokemonToUse->hp.'</td>';
					echo '<td class="hp">'.$encounteredPokemon['hp'].'</td></tr>';
					
					//attacks
				?>
			</div>
		</div>
	</body>
</html>