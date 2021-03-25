<?php

session_start();

if ($_SESSION['user'] && $_SESSION['lastchat'] && $_POST['changechat'])
	$_SESSION['lastchat'] = $_POST['changechat'];

if ($_SESSION['user'] && ($_POST['follow'] || $_POST['unfollow']))
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/profile.class.php");
	$profile = new profile;
	if ($_POST['follow'])
		$profile->subscribe($_SESSION['user'], $_POST['follow'], 1, date('Y-m-j H:i:s'));
	else if ($_POST['unfollow'])
		$profile->subscribe($_SESSION['user'], $_POST['unfollow'], 2, date('Y-m-j H:i:s'));
}

if ($_SESSION['user'] && $_POST['changenotify'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/account.class.php");
	$account = new account;
	$account->changenotify($_POST['changenotify']);
}

if ($_SESSION['user'] && ($_POST['liked'] || $_POST['like']))
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/home.class.php");
	$home = new home;
	if ($_POST['liked'])
		$home->like($_POST['liked'], $_SESSION['user'], date('Y-m-j H:i:s'), 2);
	else if ($_POST['like'])
		$home->like($_POST['like'], $_SESSION['user'], date('Y-m-j H:i:s'), 1);
}

if ($_SESSION['user'] && $_POST['notifsaw'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/notification.class.php");
	$notif = new notification;
	$notif->notifsaw($_POST['notifsaw']);
}

if ($_SESSION['user'] && $_POST['delpic'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/profile.class.php");
	$profile = new profile;
	$profile->deletepicture($_POST['delpic']);
	unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $_POST['delpic']);
}

if ($_SESSION['user'] && $_POST['changepp'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/profile.class.php");
	$profile = new profile;
	$profile->changepp($_SESSION['user'], $_POST['changepp']);
}

function imagecopymerge_alpha($dst_im, $src_im)
{
	$dst_x = 0;
	$dst_y = 0;
	$src_x = 0;
	$src_y = 0;
	$src_w = imagesx ($src_im);
	$src_h = imagesy ($src_im);
	$pct = 100;
	$cut = imagecreatetruecolor($src_w, $src_h);
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

if ($_SESSION['user'] && $_POST['img'] && $_POST['filter'])
{
	$name = 1;
	while (file_exists($_SERVER['DOCUMENT_ROOT'] . "/public/img/users/" . $_SESSION['user'] . "/" . $name . ".png"))
		$name++;
	$imgData = str_replace(' ', '+', $_POST['img']);
	$imgData = substr($imgData, strpos($imgData, ",") + 1);
	$imgData = base64_decode($imgData);
	$filterData = str_replace(' ', '+', $_POST['filter']);
	$filterData = substr($filterData, strpos($filterData, ",") + 1);
	$filterData = base64_decode($filterData);
	$path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/users/" . $_SESSION['user'] . "/";
	file_put_contents($path . $name . ".png", $imgData);
	file_put_contents($path . "filter.png", $filterData);
	$dst = imagecreatefrompng($path . $name . ".png");
	$src = imagecreatefrompng($path . "filter.png");
	imagecopymerge_alpha($dst, $src);
	imagepng($dst, $path . $name . ".png");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/mvc/model/camera.class.php");
	$camera = new camera;
	$camera->addimg($_SESSION['user'], date('Y-m-j h:i:s'), "/public/img/users/" . $_SESSION['user'] . "/" . $name . ".png");
}
