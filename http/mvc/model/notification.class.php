<?php

require_once('bdd.class.php');

class notification extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("notification.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "notification class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "notification class destroyed" . PHP_EOL;
		return ;
	}

	public function notifsaw($notif_id)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT `for_user` FROM `Notification` WHERE `id` = '" . $notif_id . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$ret = $res->fetchAll();
			$name = $ret[0]['for_user'];
			$sql = "UPDATE `Notification` SET `seen` = `seen` - 1 WHERE `id` = '" . $notif_id . "'";
			$sql2 = "UPDATE `Users` SET `notification` = `notification` - 1 WHERE `username` = '" . $name . "'";
			$db->exec($sql);
			$db->exec($sql2);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function isnotified($user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT `notification` FROM `Users` WHERE `username` = '" . $user . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				$ret = $res->fetchAll();
				return $ret[0]['notification'];
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}

	public function getnotifications($user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT `id`, `notification`, `not_date`, `seen` FROM `Notification` WHERE `for_user` = '" . $user . "'";
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
	}

	public function writemessage($message, $to, $from, $date)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "INSERT INTO Chat (id_1, id_2, from_id, message, msg_date) VALUES('"
				. $to . "', '" . $from . "', '" . $from . "', '" . addslashes($message) . "', '" . $date . "')";
			$db->exec($sql);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function getchat($user, $from_user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT id_1, id_2, from_id, msg_date, message FROM Chat WHERE (`id_1` = '"
				. $user . "' AND `id_2` = '" . $from_user . "') OR (`id_1` = '"
				. $from_user . "' AND `id_2` = '" . $user . "')";
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

	public function getuserinfo($from_user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT avatar, username FROM Users WHERE `username` = '" . $from_user . "'";
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

	public function getlinks($user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT followed FROM Links WHERE `follower` = '" . $user . "'";
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
	}
}
