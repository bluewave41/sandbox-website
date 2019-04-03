<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/code.js"></script>
		<script src="map.js"></script>
		<script src="../../pokemonList.js"></script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Map</h1>
				<?php
					$file = explode(" ", file_get_contents("../../maps/route101/file.txt"));
					$width = array_shift($file);
					$height = array_shift($file);
					for($x=0;$x<count($file);$x++) {
						if($x !== 0 && $x % $width == 0) {
							echo '<br>';
						}
						echo '<img class="tile" src="../../maps/route101/'.$file[$x].'.png"/>';
					}
				?>
				<div id="message"></div>
			</div>
		</div>
	</body>
</html>