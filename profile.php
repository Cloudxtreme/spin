<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	//include $root_dir."include/check.php";
	
		//start
	echo "coming soon";
	echo "<br /><a href=\"/base.php\" alt=\"Назад\">Назад</a>";
	
?>
