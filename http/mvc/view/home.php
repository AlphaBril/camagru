<div class="flex" id="storyline">
	<?php
		$storyline = get_storyline();
		if ($storyline)
		{
			foreach ($storyline as $k)
			{
				if ($_GET['iframe'] === "on")
					echo "<div class='storyframe' id='" . $k['id'] . "'>";
				else
					echo "<div class='story' id='" . $k['id'] . "'>";
					echo "<div class='storyinfo'>";
						get_info($k);
					echo "</div>";
					echo "<div class='storyimg'>";
						get_img($k);
					echo "</div>";
					echo "<div class='storyinfo'>";
						if ($_SESSION['user'] && liked($k['id']))
							echo "<img name='" . $k['id'] . "' onclick='liked(this)' class='storyactionimg' src='public/img/liked.png'>";
						else if ($_SESSION['user'])
							echo "<img name='" . $k['id'] . "' onclick='liked(this)' class='storyactionimg' src='public/img/like.png'>";
						echo "<img class='storyactionimg' name='" . $k['id'] . "' onclick='copy(this)' src='public/img/share.png'>";
						echo "<input style='display:none;' type=text id=copy" . $k['id'] . ">";
						echo "<span style='display:none;' id=copyspan" . $k['id'] . ">Link copied to clipboard</span>";
					echo "</div>";
					echo "<div class='storycomment'>";
						get_comments($k);
					echo "</div>";
					if ($_SESSION['user'])
					{
						echo "<div>";
							echo "<form class='storyinfo' action='index.php?page=home' method='POST'>";
								echo "<input name='comment' class='inputs' type='text'>";
								echo "<button class='button' name='picture' type='submit' value='" . $k['id'] . "'>Send</button>";
							echo "</form>";
						echo "</div>";
					}
				echo"</div>";
			}
		}
	?>
</div>
<script type="text/javascript" src="public/js/home.js"></script>
