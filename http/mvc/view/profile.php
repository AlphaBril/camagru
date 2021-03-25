<div class="flex" id='whole'>
	<div id="profile">
		<?php
			echo "<div id='profileinfo'>";
				get_profile_info($_GET['user']);
			echo "</div>";
			if ($_SESSION['user'] == $_GET['user'])
			{
				echo "<form action='index.php' method='GET'>";
					echo "<button name='page' value='account' class='buttons'>Change your profile</button>";
				echo "</form>";
			}
			else if (is_followed($_GET['user']) == 1)
				echo "<button name='" . $_GET['user'] . "' onclick=subscribe(this) class='buttons'>Press to unfollow</button>";
			else
				echo "<button name='" . $_GET['user'] . "' onclick=subscribe(this) class='buttons'>Press to follow</button>";
			echo "<div id='profilepictures'>";
				get_profile_pictures($_GET['user']);
			echo "</div>";
		?>
	</div>
	<div id='myModal' class='modal'>
		<img id='modalimg' onclick='closeModal()'>
		<button onclick='changeprofilepic()' class='button'>Set as new profile picture</button>
	</div>
</div>
<script type="text/javascript" src="public/js/profile.js"></script>
