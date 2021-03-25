<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/home.class.php");

if ($_POST['comment'] && $_POST['picture'] && $_SESSION['user'])
{
	$story = new home;
	$message = htmlentities($_POST['comment']);
	$story->writecomment($_SESSION['user'], $_POST['picture'], $message, date('Y-m-j H:i:s'));
	$_POST['comment'] = NULL;
	$_POST['picture'] = NULL;
	unset($_POST['comment']);
	unset($_POST['picture']);
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/view/home.php");

function get_storyline()
{
	$story = new home;
	if ($_GET['user'])
		$storyline = $story->storyline($_GET['user']);
	else
		$storyline = $story->storyline(NULL);
	if ($storyline)
		return array_reverse($storyline);
}

function get_info($k)
{
	$story = new home;
	$info = $story->getinfo($k['from_id']);
	if (!file_exists($info[0]['avatar']))
		$info[0]['avatar'] = 'public/img/img_avatar.png';
	echo "<a href='index.php?page=profile&user=" . $info[0]['username'] . "'><img class='littleavatar' src='" . $info[0]['avatar'] . "'></a>";
	echo "<b class='name'>" . $info[0]['username'] . "</b>";
}

function get_img($k)
{
	echo "<img class='storyimg' src='" . $k['name'] . "'>";
}

function translate_date($date)
{
	$actual = date('Y-m-d H:i:s');
	$date_array = explode(" ", $date);
	$actual_array = explode(" ", $actual);
	if ($date_array['0'] === $actual_array['0'])
	{
		$date_array = explode(":", $date_array['1']);
		$actual_array = explode(":", $actual_array['1']);
		if ($date_array['0'] === $actual_array['0'])
		{
			$calc = intval($actual_array['1']) - intval($date_array['1']);
			if ($calc === 1 || $calc === 0)
				return  "[one min ago]: ";
			else
				return "[" . $calc . " mins ago]: ";
		}
		else
		{
			$calc = intval($actual_array['0']) - intval($date_array['0']);
			if ($calc === 1)
				return "[one hour ago]: ";
			else
				return "[" . $calc . " hours ago]: ";
		}
	}
	else
	{
		$date_array = explode("-", $date_array['0']);
		$actual_array = explode("-", $actual_array['0']);
		if ($date_array['0'] === $actual_array['0'])
		{
			if ($date_array['1'] === $actual_array['1'])
			{
				$calc = intval($actual_array['2']) - intval($date_array['2']);
				if ($calc === 1)
					return "[one day ago]: ";
				else
					return "[" . $calc . " days ago]: ";
			}
			else
			{
				$calc = intval($actual_array['1']) - intval($date_array['1']);
				if ($calc === 1)
					return "[one month ago]: ";
				else
					return "[" . $calc . " months ago]: ";
			}
				
		}
		else
		{
			$calc = intval($actual_array['0']) - intval($date_array['0']);
			if ($calc === 1)
				return "[one year ago]: ";
			else
				return "[" . $calc . " years ago]: ";
		}
	}
}

function liked($img_id)
{
	$story = new home;
	$liked = $story->isliked($img_id, $_SESSION['user']);
	if ($liked)
		return 1;
	else
		return 0;
}

function get_comments($k)
{
	$story = new home;
	$comments = $story->getcomments($k['id']);
	foreach ($comments as $j)
	{
		$count++;
		if ($count >= 5)
			echo "<div class='storycomments' style='display: none;'>";
		else
			echo "<div class='storycomments'>";
			$info = $story->getinfo($j['from_id']);
			if (!file_exists($info[0]['avatar']))
				$info[0]['avatar'] = 'public/img/img_avatar.png';
			echo "<a href='index.php?page=profile&user=" . $info[0]['username'] . "'><img class='littleavatar' src='" . $info[0]['avatar'] . "'></a>";
			echo "<b class='comments'>" . $info[0]['username'] . "</b>";
			echo "<div class=comments>" . translate_date($j['comment_date']) . " ";
			echo " " . $j['comments'] . "</div>";
		echo "</div>";
	}
	if ($count >= 5)
		echo "<div class='storycomments'><button class='buttons' onclick='showEverything()'>Show More</button></div>";
}

