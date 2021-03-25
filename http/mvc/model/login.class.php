<?php

require_once('bdd.class.php');

class login extends bdd
{
	public static	$verbose = false;

	public function doc()
	{
		return file_get_content("login.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "login class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "login class destroyed" . PHP_EOL;
		return ;
	}

	public function check($username, $passwd)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			try
			{
				$sql = "SELECT `password`, `activated` FROM Users WHERE `username` = '" . addslashes($username) . "'";
				$res = $db->prepare($sql);
				$res->execute();
				$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
				foreach ($res->fetchAll() as $k)
				{
					if ($k['password'] === $passwd)
					{
						if ($k['activated'])
							return (1);
						else
						{
							echo 'Check your email to activate your account';
							return (0);
						}
					}
					else
					{
						echo 'Wrong username or password';
						return (0);
					}
				}
				echo 'Wrong username or password';
				return (0);
			}
			catch (PDOException $e)
			{
				echo $sql . "<br>" . $e->getMessage();
			}
		}
	}
}
