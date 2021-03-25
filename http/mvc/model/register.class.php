<?php

require_once('bdd.class.php');
require_once('mail.class.php');

class register extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("register.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "register class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "register class destroyed" . PHP_EOL;
		return ;
	}

	public function check($username, $email)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT username, email FROM Users";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				foreach ($res->fetchAll() as $k)
				{
					if ($k['username'] === addslashes($username))
					{
						echo "Username already taken";
						return (0);
					}
					if ($k['email'] === addslashes($email))
					{
						echo "Email already taken";
						return (0);
					}
				}
				return (1);
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}

	public function validate($username, $token)
	{
		$bdd = new bdd;
		$mail = new mail;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT token FROM Users WHERE username = '" . $username . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				$ret = $res->fetchAll();
				if ($ret[0]['token'] === $token)
				{
					$sql = "UPDATE Users SET activated = activated + 1 WHERE username= '" . $username . "'";
					$db->exec($sql);
					echo "Succes ! you can now login";
				}
				else
					echo "Error";
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}

	public function register($username, $email, $passwd, $time)
	{
		$bdd = new bdd;
		$mail = new mail;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$token = md5(microtime(TRUE) * RAND(0, 100));
				$sql = "INSERT INTO Users (username, email, password, subscribed, activated, notification, publication, followers, followed, avatar, token, reg_date) VALUES('"
					. addslashes($username) . "', '" . addslashes($email) . "', '" . $passwd . "', 1, 0, 0, 0, 0, 0, 'public/img/img_avatar.png', '" . $token . "', '" . $time . "')";
				$db->exec($sql);
				$mail->activateaccount($email, $token, $username);
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}
}
