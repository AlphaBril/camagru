<div class='notifcontent'>
	<?php
		echo "<div id='select'>";
			echo "<button onclick='swapFollow(this)' class=buttons id=friendbutton>Friends</button>";
			echo "<button onclick='swapChat(this)' style='background-color:lightblue;' class=buttons id=chatbutton>Chat</button>";
			echo "<button onclick='swapNotif(this)' class=buttons id=notifbutton>Notifications</button>";
		echo "</div>";
		echo "<div id='friend'>";
			get_links($_SESSION['user']);
		echo "</div>";
		echo "<div id='bigchat'>";
			echo "<div id='chat'>";
				get_chat($_SESSION['user'], $_SESSION['lastchat']);
			echo "</div>";
			echo "<form class='sendmessage' action='index.php?page=notification' method='POST'>";
				echo "<input name='message' class='inputs' type='text'>";
				echo "<button class='button' name='to' value='" . $_SESSION['lastchat'] . "' type='submit'>Send</button>";
			echo "</form>";
		echo "</div>";
		echo "<div id='notification'>";
			get_notification($_SESSION['user']);
		echo "</div>";
	?>
</div>
<script type="text/javascript" src="public/js/notification.js"></script>
