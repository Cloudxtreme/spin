<?php

	//start
	
	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	if (isset($_POST['event_name']) && isset($_POST['event_datein']) && isset($_POST['event_dateout']))
	{
		$event_name = $mysqli->real_escape_string($_POST['event_name']);
		
		$event_datein = $mysqli->real_escape_string($_POST['event_datein']);
		$event_dateout = $mysqli->real_escape_string($_POST['event_dateout']);
		//$radio_block = $mysqli->real_escape_string($_POST['radio_block']);
		
		//ok
		$sql_string = "SELECT id, name FROM events WHERE name='".$event_name."'";
		$result = $mysqli->query($sql_string) or die($mysqli->error);
		
		debug($sql_string);
	
		if ($result->num_rows > 0)
		{
			//start
			while ($row = $result->fetch_assoc()) {
				echo "Мероприятие с таким именем уже существует.";
			}
		} else
		{
			//add user function
			
			if (isset($_POST['update']) && ($_POST['update']))
			{
				//$query = "UPDATE events SET name='".$event_name."', work_group='".$radio_block."', oklad='".$oklad_block."', stavka='".$stavka_block."';";
				$query = ""; //Заглушка
				echo "Error 1";
			} else {
				$datein_elements  = explode(".", $event_datein);
				$event_datein = $datein_elements[2]."-".$datein_elements[1]."-".$datein_elements[0]." 00:00:01";
				
				$dateout_elements  = explode(".", $event_dateout);
				$event_dateout = $dateout_elements[2]."-".$dateout_elements[1]."-".$dateout_elements[0]." 23:59:59";
				
				$query = "INSERT INTO events (name, create_date, start_date, end_date, active, owner_id, comment) 
										VALUES ('".$event_name."', CURRENT_TIMESTAMP, '".$event_datein."', '".$event_dateout."', '1', '1', 'нету каммента')";
				//echo $query;
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
				echo "<span style=\"color: #0e831e; font-weight: bold;\">Новое мероприятие успешно добавлено</span>";
			}
		}
	} else {
		echo "Ошибка входных параметров";
	}
?>
