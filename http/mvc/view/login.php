<?php session_start(); $_SESSION['lastpage'] = $_GET['page'];?>
<div id="blackscreen" class="flex">
	<div id="login">
		<form class="forms" action="index.php?page=login" method="POST">
			<div id="headlogin">
				<img class="avatar" src="/public/img/img_avatar.png">
			</div>
			<div id="contentlogin">
				<b class="texts">Username</b>
				<input class="inputs" name="username" type="text" placeholder="Enter Username" required></input>
				<b class="texts">Password</b>
				<input class="inputs" name="passwd" type="password" placeholder="Enter Password" required></input>
			</div>
			<button class="buttons" type="submit">Login</button>
			<div class="flex-row" id="footlogin">
				<a class="texts" href="index.php?page=register"><b>Register</b></a>
				<a class="texts" href="index.php?page=passwdrecovery"><b>Reset my password</b></a>
			</div>
		</form>
	</div>
</div>
