<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	//include $root_dir."include/check.php";
	
	if (isset($_GET['act']))
	{
		//start bla bla TODO Что то Надо тут написать
		//Была какая то мысль, но бессонные краасноглазые ночи анигилировали ее
		//Видимо я хотел сделать итерацию внешнего обращения, но забыл к чему и зачем
	}
	
	if (isset($_SESSION['user_id']) && isset($_COOKIE['user_pass']))
	{
		$user_id = $mysqli->real_escape_string($_SESSION['user_id']);
		$user_pass = $mysqli->real_escape_string($_COOKIE['user_pass']);
		
		$result = $mysqli->query("SELECT id, md5_pass FROM users WHERE id='".$user_id."' AND md5_pass = '".$user_pass."'") or die($mysqli->error);
		
		if ($result->num_rows == 1)
		{
			//start
			//echo "Login success";
			$row = $result->fetch_assoc();
			$_SESSION['user_id'] = $user_id;
			setcookie("user_pass", $user_pass, time() + 3600);
			
			header('Location: /base.php');
		} else
		{
			echo "Несовпадение пары логин/пароль 1.<br />";
			include_once $root_dir."forms/login_form.php";
			exit;
		}
	} else
	{
		header('Location: /login.php');
	}
	
#	$result->free();
#	$mysqli->close();
?>
