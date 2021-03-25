<?php

$DB_DSN = "mysql:host=db;port=3306;";
$DB_USER = "root";
$DB_PASSWORD = "root";

try
{
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = file_get_contents('./database.sql');
		$conn->exec($sql);
		echo "database created" . PHP_EOL;
}
catch (PDOException $e)
{
		echo $count . $e->getMessage();
}

