<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/search.class.php');

$search = new search;
$searchlist = $search->getlist();
$search_list = json_encode($searchlist);

function get_result()
{
	if ($_POST['input_search'])
	{
		$search = new search;
		$list = $search->getuser($_POST['input_search']);
		if ($list)
		{
			if (!file_exists($list[0]['avatar']))
				$list[0]['avatar'] = 'public/img/img_avatar.png';
			echo "<div class='usersearch'>";
				echo "<a href='index.php?page=profile&user=" . $list[0]['username'] . "'><img class='littleavatarsearch' src='" . $list[0]['avatar'] . "'></a>";
				echo "<div class='profileinfotext'><b>" . $list[0]['username'] . "</b></div>";
				echo "<div class='profileinfotext'><b>" . $list[0]['publication'] . "</b><p class='pitp'>Publication</p></div>";
				echo "<div class='profileinfotext'><b>" . $list[0]['followers'] . "</b><p class='pitp'>Followers</p></div>";
				echo "<div class='profileinfotext'><b>" . $list[0]['followed'] . "</b><p class='pitp'>Followed</p></div>";
			echo "</div>";
		}
		else
			echo "<b>User not found</b>";
	}
}

function get_suggestion()
{
	$search = new search;
	$searchlist = $search->getlist();
	if ($searchlist)
	{
		for ($i = 0; $i < 5; $i++)
		{
			$infos = $search->getuser($searchlist[$i]['username']);
			if ($infos)
			{
				if (!file_exists($infos[0]['avatar']))
					$infos[0]['avatar'] = 'public/img/img_avatar.png';
				echo "<div class='suggestions'>";
					echo "<a href='index.php?page=profile&user=" . $infos[0]['username'] . "'><img class='littleavatar' src='" . $infos[0]['avatar'] . "'></a>";
					echo "<b>" . $infos[0]['username']. "</b>";
					echo "<div class='other'>";
						echo "<b>" . $infos[0]['followers'] . "</b>";
						echo "<p class='pitp'>Followers</p>";
					echo "</div>";
				echo "</div>";
			}
		}
	}
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/search.php');
