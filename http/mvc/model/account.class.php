<?php

require_once('bdd.class.php');

class account extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("account.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "account class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "account class destroyed" . PHP_EOL;
		return ;
	}

	public function changenotify($notif)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			if ($notif == 2)
				$sql = "UPDATE Users SET subscribed = '0' WHERE username = '" . $_SESSION['user'] . "'";
			else
				$sql = "UPDATE Users SET subscribed = '1' WHERE username = '" . $_SESSION['user'] . "'";
			$db->exec($sql);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function notified($user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT subscribed FROM Users WHERE username = '" . $user . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				$ret = $res->fetchAll();
				if ($ret[0]['subscribed'])
					return (1);
				else
					return (0);
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}

	public function swap($user, $newusername, $newemail, $newpass)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			if ($newusername)
			{
				$sql = "SELECT `username` FROM Users WHERE `username` = '" . $newusername . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				if ($res->fetchAll())
					echo "Username already exist.";
				else
				{
					$sql = "UPDATE `Users` SET `username` = '" . $newusername . "' WHERE `username` = '" . $user . "'";
					$db->exec($sql);
					$_SESSION['user'] = $newusername;
					echo "Username changed !";
				}
			}
			if ($newemail)
			{
				$sql = "UPDATE `Users` SET `email` = '" . $newemail . "' WHERE `username` = '" . $user . "'";
				$db->exec($sql);
				echo "Email changed !";
			}
			if ($newpass)
			{
				$sql = "UPDATE `Users` SET `password` = '" . $newpass . "' WHERE `username` = '" . $user . "'";
				$db->exec($sql);
				echo "Password changed !";
			}
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function getimg($username)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT `avatar` FROM Users WHERE `username` = '" . $username . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				return $res->fetchAll();
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
		else
			return NULL;
	}

	public function checktoken($username, $token)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT `token` FROM Users WHERE `username` = '" . $username . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			foreach ($res->fetchAll() as $k)
			{
				if ($k['token'] === $token)
				{
					$sql = "UPDATE Users SET token = '' WHERE `username` = '" . $username . "'";
					$db->exec($sql);
					return (1);
				}
				else
					return (0);
			}
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function check($username, $passwd)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT `password` FROM Users WHERE `username` = '" . $username . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			foreach ($res->fetchAll() as $k)
			{
				if ($k['password'] === $passwd)
					return (1);
				else
					return (0);
			}
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}
