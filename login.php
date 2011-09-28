<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();

	include_once $root_dir."include/mysql.php";
	
	//debug($root_dir, "root_dir");

	if (isset($_POST['user_login']) && isset($_POST['user_pass']))
	{
	
		$target_path = "keyfiles/";

		$target_path = $target_path.basename( $_FILES['keyfile']['name']);

		if (move_uploaded_file($_FILES['keyfile']['tmp_name'], $target_path))
		{
			echo "Файл авторизиции ".basename( $_FILES['keyfile']['name'])." был успешно загружен.";
		} else
		{
			echo "Попытка загрузки файла авторизиции завершилась неудачей.";
			debug("Попытка загрузки файла авторизиции завершилась неудачей.", "KeyFile upload FAILED");
			exit;
		}
		
		$user_login = $mysqli->real_escape_string($_POST['user_login']);
		$user_pass = $mysqli->real_escape_string($_POST['user_pass']);

		$result = $mysqli->query("SELECT id FROM users WHERE login='".$user_login."' AND md5_pass = '".md5(md5($user_pass).$salt)."'") or die($mysqli->error);
		
		if ($result->num_rows == 1)
		{
			//start
			//echo "Login success<br />";
			
			$row = $result->fetch_assoc();
			
			//echo "User_id = ".$row['id']."<br />";
			
			$_SESSION['user_id'] = $row['id'];
			//echo "[SESSION_START1]".$_SESSION['user_id']."[SESSION_END]";
			
			setcookie("user_pass", md5(md5($user_pass).$salt), time() + 3600);
			
			$query = "UPDATE users SET last_login = NOW() WHERE id = '".$row['id']."'";
			$result = $mysqli->query($query);
			
			if ($mysqli->error)
			{
				echo $mysqli->errorno." ".$mysqli->error."<br />";
				echo "<br />".$query."<br />";
				exit;
			}
			
			header('Location: /base.php');
		} else
		{
			echo "Несовпадение пары логин/пароль 2.<br />";
			include_once "forms/login_form.php";
		}
	} elseif (isset($_SESSION['user_id']))
	{
		$user_id = $mysqli->real_escape_string($_SESSION['user_id']);
		$result = $mysqli->query("SELECT login FROM users WHERE id='".$user_id."'") or die($mysqli->error);
		
		if ($result->num_rows == 1)
		{
			//start
			echo "Пользователь опознан.<br />введите ваш пароль.<br />";
			//echo "[SESSION_START2]".$_SESSION['user_id']."[SESSION_END]";
			$row = $result->fetch_assoc();
			$user_login = $row['login'];
			
			include_once "forms/login_form.php";
		} else
		{
			echo "Обнаружен неправомерный доступ. Администратору отправлено сообщение с данными о вашем компьютере.";
		}
	} else
	{
		include_once "forms/login_form.php";
	}
	
#	$result->free();
#	$mysqli->close();
?>
