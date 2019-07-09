<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<link rel="stylesheet" href="shop.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/code.js"></script>
		<script src="shop.js"></script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
			if(!isset($_SESSION['username'])) {
				header('location:../index/index.php');
				exit();
			}
		?>
		<div class="wrapper">
			<div class="container">
				<h1>Shop</h1>
				<?php
					include('../../scripts/Database.php');
					
					$statement = $pdo->prepare("SELECT name, cost FROM shopitems as s LEFT JOIN itemlist as i ON s.itemID = i.itemID");
					$statement->execute();
					$items = $statement->fetchAll();
					echo '<table>';
					foreach($items as $item) {
						$resourceName = str_replace(' ', '', $item['name']).'.png';
						$name = $item['name'];
						$cost = $item['cost'];
						echo "<tr><td><img src='../../sprites/items/$resourceName'/></td><td><span class='name'>$name</span></td><td><span>$cost</span></td>
							  <td><input id=$resourceName value=0 type='number'/><td></tr>";
					}
					echo '</table>';
				?>
				</br>
				<div><span>Total Cost: </span><span id="cost">0</span></div>
				<button>Purchase</button>
				<div id="response"></div>
			</div>
		</div>
	</body>
</html>