<?php

	//start
	
	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	if (isset($_POST['user_id']))
	{
		$user_id = $mysqli->real_escape_string($_POST['user_id']);
		
		$fio_block = $mysqli->real_escape_string($_POST['fio_block']);
		
		if (isset($echo_env)) {
			echo "Error Complection";
		}
		
		$oklad_block = $mysqli->real_escape_string($_POST['oklad_block']);
		$stavka_block = $mysqli->real_escape_string($_POST['stavka_block']);
		$radio_block = $mysqli->real_escape_string($_POST['radio_block']);
		
		//ok
		$result_user_data = $mysqli->query("SELECT full_name, oklad, stavka, work_group FROM users WHERE id='".$user_id."'") or die($mysqli->error);
	
		if ($result->num_rows > 0)
		{
			$row_user_data = $result_user_data->fetch_assoc()) {
			echo "<script type=\"text/javascript\">";
			echo "\t set_user_data(\"fio_input\", ".$row_user_data['full_name'].");\r\n";
			echo "</script>";
		}
			}
		} else
		{
			//add user function
			echo "Хуйня случилась. Критичная.";
		}
	} else {
		echo "Ошибка входных параметров";
	}
?>
