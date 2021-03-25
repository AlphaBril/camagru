<?php

if ($_POST['username'] && $_POST['email'] && $_POST['passwd'] && $_POST['passwd2'])
{
	if (ctype_alnum($_POST['username']))
	{
		if (strstr($_POST['email'], '@') && strstr($_POST['email'], '.'))
		{
			if ($_POST['passwd'] === $_POST['passwd2'])
			{
				if (strlen($_POST['passwd']) > 7)
				{
					require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/model/register.class.php');
					$reg = new register;
					if ($reg->check($_POST['username'], $_POST['email']) === 1)
					{
						$reg->register($_POST['username'], $_POST['email'], hash('whirlpool', $_POST['passwd']), date('Y-m-j h:i:s'));
						if (!file_exists("public/img/users/" . $_POST['username']))
							mkdir ("public/img/users/" . $_POST['username'], 0777, true);
						echo "Succesfully registered !";
						require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/login.php');
					}
				}
				else
					echo "Password must be at least 8 character long.";
			}
			else
				echo "Passwords doesn't match.";
		}
		else
			echo "Your email isn't valid.";
	}
	else
		echo "Username must be alphanumerical only";
}
if (!$_SESSION['user'])
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/register.php');
else
	header('Location: index.php');
