<?php

if ($_GET['login'] && $_POST['token'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/register.class.php');
	$register = new register;
	$register->validate($_GET['login'], $_POST['token']);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/controller/login.php');
