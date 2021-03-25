<?php session_start(); $_SESSION['lastpage'] = $_GET['page'];?>
<div id="blackscreen" class="flex">
	<div id="login">
		<form class="forms" action="index.php?page=passwdrecovery" method="POST">
			<div id="headlogin">
				<img style="width:40%;max-width:10vw;" src="/public/img/meca.png">
			</div>
			<div id="contentlogin">
				<p class="texts">Please enter your email, we will send you a link to recover your password</p>
				<input class="inputs" name="email" type="text" placeholder="Enter your email" required></input>
			</div>
			<button class="buttons" type="submit">Reset</button>
			<div class="flex-row" id="footlogin">
				<a href="index.php?page=register"><b>Register</b></a>
				<a href="index.php?page=login"><b>Login</b></a>
			</div>
		</form>
	</div>
</div>
