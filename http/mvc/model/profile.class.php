<?php

require_once('bdd.class.php');

class profile extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("profile.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "profile class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "profile class destroyed" . PHP_EOL;
		return ;
	}

	public function changepp($user, $newpp)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "UPDATE `Users` SET `avatar` = '" . $newpp . "' WHERE `username` = '" . $user . "'";
			$db->exec($sql);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function isfollowed($followed, $follower)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT follower FROM Links WHERE `followed` = '" . $followed . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			foreach($res->fetchAll() as $k)
				if ($k['follower'] === $follower)
					return 1;
			return 0;
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function subscribe($user, $follow, $yes, $date)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			if ($yes === 1)
			{
				$sql = "INSERT INTO `Links` (followed, follower) VALUES('" . $follow . "', '" . $user . "')";
				$sql2 = "UPDATE `Users` SET `followers` = `followers` + 1 WHERE `username` = '" . $follow . "'";
				$sql3 = "UPDATE `Users` SET `followed` = `followed` + 1 WHERE `username` = '" . $user . "'";
				$sql4 = "INSERT INTO `Notification` (for_user, notification, seen, not_date) VALUES('" . $follow . "', '" . $user . " follow you', '0', '" . $date . "')";
				$sql5 = "UPDATE `Users` SET `notification` = `notification` + 1 WHERE `username` = '" . $follow . "'";
			}
			else if ($yes === 2)
			{
				$sql = "DELETE FROM `Links` WHERE `followed` = '" . $follow . "' AND `follower` = '" . $user . "'";
				$sql2 = "UPDATE `Users` SET `followers` = `followers` - 1 WHERE `username` = '" . $follow . "'";
				$sql3 = "UPDATE `Users` SET `followed` = `followed` - 1 WHERE `username` = '" . $user . "'";
				$sql4 = "INSERT INTO `Notification` (for_user, notification, seen, not_date) VALUES('" . $follow . "', '" . $user . " dont follow you anymore', '0', '" . $date . "')";
				$sql5 = "UPDATE `Users` SET `notification` = `notification` + 1 WHERE `username` = '" . $follow . "'";
			}
			$db->exec($sql);
			$db->exec($sql2);
			$db->exec($sql3);
			$db->exec($sql4);
			$db->exec($sql5);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function getuserpictures($from_user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT id FROM Users WHERE `username` = '" . $from_user . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				$id = $res->fetchAll();

				$sql = "SELECT name FROM Pictures WHERE `from_id` = '" . $id[0]['id'] . "' ORDER BY `upload_date` DESC";
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

	public function deletepicture($picture)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT username FROM Users INNER JOIN Pictures ON Users.id = Pictures.from_id WHERE Pictures.name = '" . $picture . "'";
			$res =$db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$for = $res->fetchAll();
			$for = $for[0]['username'];
			$sql = "DELETE FROM Pictures WHERE `name` = '" . $picture . "'";
			$sql2 = "UPDATE `Users` SET `publication` = `publication` - 1 WHERE `username` = '" . $for . "'";
			$db->exec($sql);
			$db->exec($sql2);
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
		if ($db)
		{
			try
			{
				$sql = "SELECT avatar, publication, followers, followed FROM Users WHERE `username` = '" . $from_user . "'";
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
