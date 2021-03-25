<?php

if ($_POST['email'] && $_POST['subject'] && $_POST['message'])
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/mail.class.php');
	$mail = new mail;
	if (strstr($_POST['email'], '@') && strstr($_POST['email'], '.'))
	{
		if (ctype_alnum($_POST['subject']))
			$mail->sendsupport(addslashes($_POST['email']), $_POST['subject'], addslashes($_POST['message']));
		else
			echo "Subject isn't alpha numerical";
	}
	else
		echo "Your email isn't valid";

}

require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/support.php');
