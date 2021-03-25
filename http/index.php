<?php session_start();?>
<html>
	<head>
		<title> Camagru </title>
		<base target="_parent">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="data:;base64,iVBORw0KGgo=">
		<link rel="stylesheet" href="/public/css/camagru.css">
		<link rel="stylesheet" href="/public/css/view/home.css">
		<link rel="stylesheet" href="/public/css/view/welcome.css">
		<link rel="stylesheet" href="/public/css/view/login.css">
		<link rel="stylesheet" href="/public/css/view/camera.css">
		<link rel="stylesheet" href="/public/css/view/search.css">
		<link rel="stylesheet" href="/public/css/view/notification.css">
		<link rel="stylesheet" href="/public/css/view/profile.css">
		<link rel="stylesheet" href="/public/css/view/about.css">
	</head>
	<body>
		<?php 
			if ($_GET['iframe'] !== "on" )
				include 'mvc/view/header.php';
			if ($_GET['iframe'] === "on")
				echo "<div id=contentframe>";
			else
				echo "<div id=content>";
			if (!empty($_GET['page']) && is_file('mvc/controller/'.$_GET['page'].'.php'))
				include 'mvc/controller/'.$_GET['page'].'.php';
			else
				include 'mvc/controller/welcome.php';
			?>
		</div>
		<?php
			if ($_GET['iframe'] !== "on")
				include 'mvc/view/footer.php';
		?>
	</body>
</html>
