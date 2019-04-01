<html>
	<head>
		<link rel="stylesheet" href="../../static/css.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="../../static/code.js"></script>
	</head>
	<body>
		<?php
			include('../../static/links.php');
		?>
		<div class="wrapper">
			<div class="container">
				<?php
					//session started in links.php
					if(isset($_SESSION['username']) && $_SESSION['username']) {
						echo '<h1>Welcome '.$_SESSION['username'].'</h1>';
					}
					else {
						echo '<h1>Welcome</h1>';
					}
				?>
			</div>
		</div>
	</body>
</html>