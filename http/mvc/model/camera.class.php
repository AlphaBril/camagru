<?php

require_once('bdd.class.php');

class camera extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("camera.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "camera class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "camera class destroyed" . PHP_EOL;
		return ;
	}

	public function addimg($user, $date, $name)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		try
		{
			$sql = "SELECT id FROM Users WHERE username='" . $user . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$user_id = $res->fetchAll();
			$user_id = $user_id[0]['id'];
			$sql = "INSERT INTO Pictures (from_id, name, upload_date) VALUES ('" . $user_id . "', '" . $name . "', '" . $date . "')";
			$sql2 = "UPDATE `Users` SET `publication` = `publication` + 1 WHERE `username` = '" . $user . "'";
			$db->exec($sql);
			$db->exec($sql2);
		}
		catch (PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}
}
