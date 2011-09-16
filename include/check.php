<?php

	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();

	include_once $root_dir."include/mysql.php";
	
	//debug($mysqli);
	
	function CheckUserLogin()
	{
		global $mysqli;
		global $root_dir;
		
		include_once $root_dir."include/mysql.php";
		
		if (isset($_SESSION['user_id']))
		{
			$user_id = $mysqli->real_escape_string($_SESSION['user_id']);
			$result = $mysqli->query("SELECT login FROM users WHERE id='".$user_id."'") or die($mysqli->error);
			
			if ($result->num_rows == 1)
			{
				//start
				//echo "Пользователь опознан.<br />введите ваш пароль.<br />";
				//echo "[SESSION_START2]".$_SESSION['user_id']."[SESSION_END]";
				$row = $result->fetch_assoc();
				$user_login = $row['login'];
				
				//include "forms/login_form.php";
				return 0;
			} else
			{
				//echo "Обнаружен неправомерный доступ. Администратору отправлено сообщение с данными о вашем компьютере.";
				return 2;
			}
		} else
		{
			include_once "forms/login_form.php";
			exit;
		}
	}

?>
