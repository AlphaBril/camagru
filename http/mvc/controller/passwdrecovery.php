<?php

if ($_POST['email'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/mail.class.php');
	$mail = new mail;
	if (strstr($_POST['email'], '@') && strstr($_POST['email'], '.'))
		$mail->sendreset(addslashes($_POST['email']));
	else
		echo "Your email isn't valid.";
}

if (!$_SESSION['user'])
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/passwdrecovery.php');
else
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/welcome.php');
