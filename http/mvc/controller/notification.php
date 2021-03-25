<?php

session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/notification.class.php");

if ($_POST['message'] && $_POST['to'] && $_SESSION['user'])
{
	$notif = new notification;
	$message = htmlentities($_POST['message']);
	$notif->writemessage($message, $_POST['to'], $_SESSION['user'], date('Y-m-j H:i:s'));
	$_POST['message'] = NULL;
	$_POST['to'] = NULL;
	unset($_POST['message']);
	unset($_POST['to']);
}

function	get_links($user)
{
	$notif = new notification;
	$links = $notif->getlinks($user);
	if (!$_SESSION['lastchat'])
		$_SESSION['lastchat'] = $links[0]['followed'];
	if (!$links)
	{
		$_SESSION['lastchat'] = NULL;
		unset($_SESSION['lastchat']);
	}
	if ($links)
	{
		foreach ($links as $k)
		{
			$infos = $notif->getuserinfo($k['followed']);
			if (!file_exists($infos[0]['avatar']))
				$infos[0]['avatar'] = 'public/img/img_avatar.png';
			if ($infos[0]['username'] === $_SESSION['lastchat'])
				echo "<div onclick=changeChat(this) style='background-color: green;' class='friends'>";
			else
				echo "<div onclick=changeChat(this) class='friends'>";
			echo "<a href='index.php?page=profile&user=" . $infos[0]['username'] . "'><img class='littleavatar' src='" . $infos[0]['avatar'] . "'></a>";
			echo "<b>" . $infos[0]['username'] . "</b>";
			echo "</div>";
		}
	}
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
	}
}

function	get_chat($user, $from_user)
{
	if ($from_user)
	{
		$notif = new notification;
		$chats = $notif->getchat($user, $from_user);
		foreach ($chats as $k)
		{
			if ($k['from_id'] === $user)
				echo "<div class='send'>";
			else
				echo "<div class='received'>";
			echo "<b>" . translate_date($k['msg_date']) . "</b>";
			echo "<p> " . $k['message'] . "</p>";
			echo "</div>";
		}
	}
	else
		echo "<h1>You need to follow someone first before sending them message</h1>";
}

function	get_notification($user)
{
	$notif = new notification;
	$notifs = $notif->getnotifications($user);
	if ($notifs)
	{
		$notifs = array_reverse($notifs);
		foreach ($notifs as $k)
		{
			if ($k['seen'] == 0)
				echo "<div onclick='Saw(this)' name='" . $k['id'] . "' style='background-color:lightblue;' class='notifications'>";
			else
				echo "<div class='notifications'>";
			echo "<div>" . translate_date($k['not_date']) . " ";
			echo " " . $k['notification'] . "</div>";
			echo "</div>";
		}
	}
}

if (!$_SESSION['user'])
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/login.php');
else
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/notification.php');
