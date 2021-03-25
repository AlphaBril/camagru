<?php

class bdd
{
	public static	$verbose = false;
	private			$_host = "db";
	private			$_user = "fldoucet";
	private			$_pass = "fldoucet";
	private			$_name = "db_camagru";


	public function doc()
	{
		return file_get_content("bdd.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "bdd class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "bdd class destroyed" . PHP_EOL;
		return ;
	}

	protected function _dbConnect()
	{
		try
		{
			$db = new PDO("mysql:host=" . $this->_host . ";dbname=" . $this->_name,
				$this->_user, $this->_pass,array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		}
		catch (PDOException $e)
		{
			echo "Connection failed : " . $e->getMessage() . PHP_EOL;
		}
	}
}
