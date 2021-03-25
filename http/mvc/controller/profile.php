<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/profile.class.php');

if (!file_exists('public/img/users/' . $_GET['user']))
	$_GET['user'] = $_SESSION['user'];

function get_profile_info($user)
{
	$profiled = new profile;
	$profileinfo = $profiled->getuserinfo($user);
	if (!file_exists($profileinfo[0]['avatar']))
		$profileinfo[0]['avatar'] = 'public/img/img_avatar.png';
	echo "<div><img id='avatar' src='" . $profileinfo[0]['avatar'] . "'></div>";
	echo "<div class='profileinfotext'><b>" . $_GET['user'] . "</b></div>";
	echo "<div class='profileinfotext'><b>" . $profileinfo[0]['publication'] . "</b><p class='pitp'>Publication</p></div>";
	echo "<div class='profileinfotext'><b>" . $profileinfo[0]['followers'] . "</b><p class='pitp'>Followers</p></div>";
	echo "<div class='profileinfotext'><b>" . $profileinfo[0]['followed'] . "</b><p class='pitp'>Followed</p></div>";
}

function is_followed($user)
{
	$profiled = new profile;
	if ($profiled->isfollowed($user, $_SESSION['user']) === 1)
		return 1;
	else
		return 0;
}

function get_profile_pictures($user)
{
	$profiled = new profile;
	$profilepics = $profiled->getuserpictures($user);
	if ($profilepics)
	{
		foreach ($profilepics as $k)
		{
			if ($_SESSION['user'] === $user)
				echo "<div class='profilepics'><img class='imgprofilepics' onclick='modalImg(this)' src='" . $k['name'] . "'><button value='" . $k['name'] . "' onclick='delPic(this)' class='del'>&#10008</button></div>";
			else
				echo "<div class='profilepics'><img class='imgprofilepics' onclick='modalImg(this)' src='" . $k['name'] . "'></div>";
		}
	}
}

if (!$_SESSION['user'])
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/login.php');
else
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/profile.php');

