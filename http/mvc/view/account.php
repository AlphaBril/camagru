<div id="blackscreen" class="flex">
	<div id="login">
		<form class="forms" action="index.php?page=account<?php echo "&login=" . $_GET['login']; ?>" method="POST">
			<div id="headlogin">
				<?php echo get_img($_SESSION['user']); ?>
				<b><?php echo $_SESSION['user']; ?></b>
			</div>
			<div id="contentlogin">
				<div class='account'>
					<b class="texts">Change username</b>
					<label class='switch'>
						<input onclick='showname()' type='checkbox'>
						<span class='slider round'></span>
					</label>
				</div>
				<input style='display:none;' id='name' class="inputs" name="newusername" type="text" placeholder="Enter new username"></input>
				<div class='account'>
					<b class="texts">Change email</b>
					<label class='switch'>
						<input onclick='showemail()' type='checkbox'>
						<span class='slider round'></span>
					</label>
				</div>
				<input style='display:none;' id='email' class="inputs" name="newemail" type="text" placeholder="Enter new email"></input>
				<div class='account'>
					<b class="texts">Change password</b>
					<label class='switch'>
						<input onclick='showpass()' type='checkbox'>
						<span class='slider round'></span>
					</label>
				</div>
				<input style='display:none' id='pass' class="inputs" name="newpass" type="password" placeholder="Enter new password"></input>
				<div class='account'>
					<b class="texts">Notify me by mail</b>
					<label class='switch'>
					<input onclick='changeNotify(this)' type='checkbox' <?php echo notified($_SESSION['user']); ?>>
						<span class='slider round'></span>
					</label>
				</div>
					<?php if (!$_POST['token']) {echo "<input class='inputs' name='passwd' type='password' placeholder='Enter actual password' required></input>";} ?>
			</div>
			<button class="buttons" name='token' value='<?php echo $_POST['token']; ?>' type="submit">Change</button>
		</form>
	</div>
</div>
<script type='text/javascript' src='public/js/account.js'></script>
