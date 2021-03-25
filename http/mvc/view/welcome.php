<div class="flex">
	<h1 id="title_home">
		<?php
			if ($_SESSION['user'])
				echo "Welcome back " . $_SESSION['user'] . " !";
			else
				echo "Welcome to camagru !";
		?>
	</h1>
	<div id="display">
		<div style="display: block" id='display1'>
			<img class="display_img" src="/public/img/website.png">
			<b class="hometxt">Camagru is a sharing picture website</b>
		</div>
		<div style="display: none" id='display2'>
			<img class="display_img" src="/public/img/upload.jpg">
			<b class="hometxt">Shoot and upload your most incredible moments !</b>
		</div>
		<div style="display: none" id='display3'>
			<img class="display_img" src="/public/img/partage.jpg">
			<b class="hometxt">Share them with your followers in the entire world &#128521</b>
		</div>
	</div>
	<form id="actionhome" action="index.php" method="GET">
		<button class="buttons" name="page" value="home" type="submit" id="launch"><b id="hometext">Begin your journey</b></button>
	</form>
</div>
<script type="text/javascript" src="/public/js/welcome.js"></script>
