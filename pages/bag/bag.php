<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="shop.js"></script>
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

					if(isset($_SESSION['id'])) {
						$statement = $pdo->prepare("SELECT name, count FROM bag as b LEFT JOIN itemlist as i on b.itemID = i.itemID WHERE b.id = ?");
						$statement->execute([$_SESSION['id']]);
						$items = $statement->fetchAll();
						foreach($items as $item) {
							echo '<div>'.$item['name'].': '.$item['count'].'</div>';
						}
					}
				?>
			</div>
		</div>
	</body>
</html>