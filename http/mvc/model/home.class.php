<?php

require_once('bdd.class.php');
require_once('mail.class.php');

class home extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("home.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "home class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "home class destroyed" . PHP_EOL;
		return ;
	}

	public function like($id_pic, $user, $date, $yes)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT username FROM Users INNER JOIN Pictures ON Users.id = Pictures.from_id WHERE Pictures.id = '" . $id_pic . "'";
			$res =$db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$for = $res->fetchAll();
			$for = $for[0]['username'];
			if ($yes === 1)
			{
				$sql = "INSERT INTO Likes (picture_id, liked_from, upload_date) VALUES('"
					. $id_pic . "', '" . $user . "', '" . $date . "')";
				$sql2 = "INSERT INTO `Notification` (for_user, notification, seen, not_date) VALUES('" . $for . "', '<a href=/index.php?page=home#" . $id_pic . ">" . $user . " liked your picture</a>', '0', '" . $date . "')";
				$sql3 = "UPDATE `Users` SET `notification` = `notification` + 1 WHERE `username` = '" . $for . "'";
			}
			else if ($yes === 2)
			{
				$sql = "DELETE FROM Likes WHERE `picture_id` = '" . $id_pic . "' AND `liked_from` = '"
					. $user . "'";
				$sql2 = "INSERT INTO `Notification` (for_user, notification, seen, not_date) VALUES('" . $for . "', '" . $user . " unliked your picture', '0', '" . $date . "')";
				$sql3 = "UPDATE `Users` SET `notification` = `notification` + 1 WHERE `username` = '" . $for . "'";
			}
			$db->exec($sql);
			$db->exec($sql2);
			$db->exec($sql3);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function isliked($id_pic, $user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT id FROM Likes WHERE `picture_id` = '" . $id_pic . "' AND `liked_from` = '"
				. $user . "'";
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

	public function writecomment($from_user, $picture_id, $comment, $date)
	{
		$bdd = new bdd;
		$mail = new mail;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT username, email, subscribed FROM Users INNER JOIN Pictures ON Users.id = Pictures.from_id WHERE Pictures.id = '" . $picture_id . "'";
			$res =$db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$for = $res->fetchAll();
			if ($for[0]['subscribed'])
				$mail->sendnotif($for[0]['email']);
			$for = $for[0]['username'];
			$sql = "SELECT id FROM Users WHERE `username` = '" . $from_user . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$ret = $res->fetchAll();
			$sql = "INSERT INTO Comments (img_id, from_id, comments, comment_date) VALUES('"
				. $picture_id . "', '" . $ret[0]['id'] . "', '" . addslashes($comment) . "', '" . $date . "')";
			$sql2 = "INSERT INTO `Notification` (for_user, notification, seen, not_date) VALUES('" . $for . "', '<a href=/index.php?page=home#" . $picture_id . ">" . $from_user . " commented your picture</a>', '0', '" . $date . "')";
			$sql3 = "UPDATE `Users` SET `notification` = `notification` + 1 WHERE `username` = '" . $for . "'";
			$db->exec($sql);
			$db->exec($sql2);
			$db->exec($sql3);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function getcomments($id)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT comments, comment_date, from_id FROM Comments WHERE `img_id` = '" . $id . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			return ($res->fetchAll());
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function getinfo($id)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT username, avatar FROM Users WHERE `id` = '" . $id . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			return ($res->fetchAll());
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	public function storyline($user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				if (!$user)
					$sql = "SELECT id, from_id, name, upload_date FROM Pictures";
				else
				{
					$sql = "SELECT id FROM Users WHERE `username` = '" . $user . "'";
					$res = $db->prepare($sql);
					$res->execute();
					$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
					$ret = $res->fetchAll();
					$id = $ret[0]['id'];
					$sql = "SELECT id, from_id, name, upload_date FROM Pictures WHERE `from_id` = '" . $id . "'";
				}
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				return ($res->fetchAll());
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}
}
