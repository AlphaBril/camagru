<?php

require_once('bdd.class.php');

class search extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("search.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "search class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "search class destroyed" . PHP_EOL;
		return ;
	}

	public function getuser($user)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT username, avatar, publication, followers, followed FROM Users WHERE `username` = '" . addslashes($user) . "'";
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

	public function getlist()
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT `username` FROM Users ORDER BY `followers` DESC";
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
