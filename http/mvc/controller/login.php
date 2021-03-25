<?php

session_start();

if ($_POST['username'] && $_POST['passwd'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/login.class.php');
	$log = new login;
	$res = $log->check($_POST['username'], hash('whirlpool', $_POST['passwd']));
	if ($res === 1)
		$_SESSION['user'] = $_POST['username'];
}
if (!$_SESSION['user'])
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/login.php');
else
	echo '<meta http-equiv=refresh content=0;index.php?page=home>';
