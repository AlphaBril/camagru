<div id=header>
	<div class=menu>
		<a href="index.php?page=home">
			<img class="imgmenu" src="/public/img/home.png">
		</a>
	</div>
	<div class=menu>
		<a href="index.php?page=search">
			<img class="imgmenu" src="/public/img/search.png">
		</a>
	</div>
	<div class=menu>
		<a href="index.php?page=camera">
			<img class="imgmenu" src="/public/img/camera.png">
		</a>
	</div>
	<div class=menu>
		<a href="index.php?page=notification">
			<img class="imgmenu" src="/public/img/notification.png">
			<?php
				if ($_SESSION['user'])
				{
					require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/notification.class.php");
					$notif = new notification;
					if ($notif->isnotified($_SESSION['user']))
						echo "<div id=notified></div>";
				}
			?>
		</a>
	</div>
	<div class=menu>
	<?php echo "<a href='index.php?page=profile&user=" . $_SESSION['user'] . "'>"; ?>
			<img class="imgmenu" src="/public/img/profile.png">
		</a>
	</div>
	<?php
		if ($_SESSION['user'])
		{
			echo "<div class=menu>";
				echo "<a href='/mvc/controller/logout.php'>";
					echo "<img class='imgmenu' src='/public/img/logout.png'>";
				echo "</a>";
			echo "</div>";
		}
	?>
</div>
