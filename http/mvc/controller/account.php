<?php

if ($_SESSION['user'])
{
	if ($_POST['passwd'] && ($_POST['newusername'] || $_POST['newemail'] || $_POST['newpass']))
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/account.class.php');
		$account = new account;
		$newusername = NULL;
		$newemail = NULL;
		$newpass = NULL;
		$nope = 0;
		if ($_POST['newusername'] != '')
		{
			if (ctype_alnum($_POST['newusername']))
				$newusername = addslashes($_POST['newusername']);
			else
			{
				$nope = 1;
				echo "Username must be alphanumerical only";
			}
		}
		if ($_POST['newemail'] != '')
		{
			if (strstr($_POST['newemail'], '@') && strstr($_POST['newemail'], '.'))
				$newemail = addslashes($_POST['newemail']);
			else
			{
				$nope = 1;
				echo "Your email isn't valid.";
			}
		}
		if ($_POST['newpass'] != '')
		{
			if (strlen($_POST['newpass']) > 7)
				$newpass = hash('whirlpool', $_POST['newpass']);
			else
			{
				$nope = 1;
				echo "Your password must be at least 8 characters long";
			}
		}
		if ($account->check($_SESSION['user'], hash('whirlpool', $_POST['passwd'])) === 0)
			echo "Wrong password";
		else if ($nope === 0)
			$account->swap($_SESSION['user'], $newusername, $newemail, $newpass);
	}
	require_once("mvc/view/account.php");
}
else if ($_GET['login'] && $_POST['token'])
{
	if ($_POST['newusername'] || $_POST['newemail'] || $_POST['newpass'])
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/account.class.php');
		$account = new account;
		$newusername = NULL;
		$newemail = NULL;
		$newpass = NULL;
		if ($_POST['newusername'] != '')
			$newusername = $_POST['newusername'];
		if ($_POST['newemail'] != '')
			$newemail = $_POST['newemail'];
		if ($_POST['newpass'] != '')
			$newpass = hash('whirlpool', $_POST['newpass']);
		if ($account->checktoken($_GET['login'], $_POST['token']) === 0)
			echo "Bad token";
		else
			$account->swap($_GET['login'], $newusername, $newemail, $newpass);
	}
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/view/account.php");
}
else
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/view/login.php");

function	notified($user)
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/account.class.php');
	$account = new account;
	if ($account->notified($user) === 1)
		return "checked";
}

function	get_img($user)
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/account.class.php');
	$account = new account;
	if (!file_exists($account->getimg($user)[0]['avatar']))
		return "<img class='avatar' onclick='resetPicture(this)' title='Reset Picture' src='/public/img/img_avatar.png'>";
	else
		return "<img class='avatar' onclick='resetPicture(this)' title='Reset Picture' src='" . $account->getimg($user)[0]['avatar'] . "'>";
}
