<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];

	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();

	session_start();

	$salt = "B*O&v6o&P6p";

	//require("include/functions.php");

	$db_host = "p:localhost";
	$db_user = "webmaster";
	$db_pass = "414045";
	$db_name = "spin_zp";
	
	if (!isset($mysqli))
	{
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	
		if ($mysqli->connect_error)
		{
			echo "Ошибка подключения: ".$mysqli->connect_error."\n";
			exit();
		}
	} else
	{
		debug("Соединение с базой данных установлено.");
	}

?>
