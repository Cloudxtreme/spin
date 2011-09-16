<?php

	//start
	//Create Git Repo
	//Test commit
	
	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	if (isset($_POST['fio_block']) && isset($_POST['oklad_block']) && isset($_POST['stavka_block']) && isset($_POST['radio_block']))
	{
		$fio_block = $mysqli->real_escape_string($_POST['fio_block']);
		
		$oklad_block = $mysqli->real_escape_string($_POST['oklad_block']);
		$stavka_block = $mysqli->real_escape_string($_POST['stavka_block']);
		$radio_block = $mysqli->real_escape_string($_POST['radio_block']);
		
		//ok
		$result = $mysqli->query("SELECT id, full_name FROM users WHERE full_name='".$fio_block."'") or die($mysqli->error);
	
		if ($result->num_rows > 0)
		{
			//start
			while ($row = $result->fetch_assoc()) {
				echo "Пользователь с таким именем уже зарегистрирован.";
			}
		} else
		{
			//add user function
			
			if (isset($_POST['update']) && ($_POST['update']))
			{
				$query = "UPDATE users SET full_name='".$fio_block."', work_group='".$radio_block."', oklad='".$oklad_block."', stavka='".$stavka_block."';");
			} else {
				$query = "INSERT INTO users (full_name, work_group, create_date, oklad, stavka) 
										VALUES ('".$fio_block."', '".$radio_block."', CURRENT_TIMESTAMP, ".$oklad_block.", ".$stavka_block.")";
			}
			
			$result = $mysqli->query($query);
			if ($mysqli->error)
			{
				$critical_error = true;
				debug($mysqli->error, $mysqli->errno);
				debug($query);
				exit;
			} else
			{
				//echo "Новый пользователь успешно добавлен";
				echo "<span style=\"background-color: #90ee90;\">Новый пользователь успешно добавлен</span>";
			}
		}
	} else {
		echo "Ошибка входных параметров";
	}
?>
