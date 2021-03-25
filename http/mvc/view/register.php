<?php session_start(); $_SESSION['lastpage'] = $_GET['page'];?>
<div id="blackscreen" class="flex">
	<div id="login">
		<form class="forms" action="index.php?page=register" method="POST">
			<div id="headlogin">
				<img class="avatar" src="/public/img/img_avatar.png">
			</div>
			<div id="contentlogin">
				<b class="texts">Username</b>
				<input class="inputs" name="username" type="text" value="<?php echo $_POST['username']; ?>" placeholder="Enter Username" required></input>
				<b class="texts">Email</b>
				<input class="inputs" name="email" type="text" value="<?php echo $_POST['email']; ?>" placeholder="Enter Email" required></input>
				<b class="texts">Password</b>
				<input class="inputs" name="passwd" type="password" value="<?php echo $_POST['passwd']; ?>" placeholder="Enter Password" required></input>
				<b class="texts">Confirm Password</b>
				<input class="inputs" name="passwd2" type="password" value="<?php echo $_POST['passwd2']; ?>" placeholder="Confirm Password" required></input>
			</div>
			<button class="buttons" type="submit">Register</button>
			<div id="footlogin">
				<a class="texts" href="index.php?page=profile"><b>Login</b></a>
			</div>
		</form>
	</div>
</div>
