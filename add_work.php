<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	//include $root_dir."include/check.php";

	//start
	
	if ((isset($_POST['action'])) && ($_POST['action'] == "write"))
	{
		if ((isset($_POST['event_id'])) && ($_POST['event_id'] != "")): $post_event_id = $mysqli->real_escape_string($_POST['event_id']); else: $post_event_id = "0"; endif;
		if ((isset($_POST['user_id'])) && ($_POST['user_id'] != "")): $post_user_id = $mysqli->real_escape_string($_POST['user_id']); else: $post_user_id = "0"; endif;
		if ((isset($_POST['w_m'])) && ($_POST['w_m'] != "")): $post_w_m = $mysqli->real_escape_string($_POST['w_m']); else: $post_w_m = "0"; endif;
		if ((isset($_POST['w_bigm'])) && ($_POST['w_bigm'] != "")): $post_w_bigm = $mysqli->real_escape_string($_POST['w_bigm']); else: $post_w_bigm = "0"; endif;
		if ((isset($_POST['w_d'])) && ($_POST['w_d'] != "")): $post_w_d = $mysqli->real_escape_string($_POST['w_d']); else: $post_w_d = "0"; endif;
		if ((isset($_POST['w_bigd'])) && ($_POST['w_bigd'] != "")): $post_w_bigd = $mysqli->real_escape_string($_POST['w_bigd']); else: $post_w_bigd = "0"; endif;
		if ((isset($_POST['w_o'])) && ($_POST['w_o'] != "")): $post_w_o = $mysqli->real_escape_string($_POST['w_o']); else: $post_w_o = "0"; endif;
		if ((isset($_POST['w_bigo'])) && ($_POST['w_bigo'] != "")): $post_w_bigo = $mysqli->real_escape_string($_POST['w_bigo']); else: $post_w_bigo = "0"; endif;
		if ((isset($_POST['w_p'])) && ($_POST['w_p'] != "")): $post_w_p = $mysqli->real_escape_string($_POST['w_p']); else: $post_w_p = "0"; endif;
		if ((isset($_POST['w_pr'])) && ($_POST['w_pr'] != "")): $post_w_pr = $mysqli->real_escape_string($_POST['w_pr']); else: $post_w_pr = "0"; endif;
		if ((isset($_POST['w_shtraf'])) && ($_POST['w_shtraf'] != "")): $post_w_shtraf = $mysqli->real_escape_string($_POST['w_shtraf']); else: $post_w_shtraf = "0"; endif;
		if ((isset($_POST['w_tr'])) && ($_POST['w_tr'] != "")): $post_w_tr = $mysqli->real_escape_string($_POST['w_tr']); else: $post_w_tr = "6"; endif;
		if ((isset($_POST['w_leb'])) && ($_POST['w_leb'] != "")): $post_w_leb = $mysqli->real_escape_string($_POST['w_leb']); else: $post_w_leb = "0"; endif;
		if ((isset($_POST['w_leb_m'])) && ($_POST['w_leb_m'] != "")): $post_w_leb = $mysqli->real_escape_string($_POST['w_leb_m']); else: $post_w_leb_m = "0"; endif;
		if ((isset($_POST['w_leb_d'])) && ($_POST['w_leb_d'] != "")): $post_w_leb_d = $mysqli->real_escape_string($_POST['w_leb_d']); else: $post_w_leb_d = "0"; endif;
		if ((isset($_POST['w_type_z'])) && ($_POST['w_type_z'] != "")): $post_w_type_z = $mysqli->real_escape_string($_POST['w_type_z']); else: $post_w_type_z = "0"; endif;
		if ((isset($_POST['w_type_s'])) && ($_POST['w_type_s'] != "")): $post_w_type_s = $mysqli->real_escape_string($_POST['w_type_s']); else: $post_w_type_s = "0"; endif;
		if ((isset($_POST['w_type_v'])) && ($_POST['w_type_v'] != "")): $post_w_type_v = $mysqli->real_escape_string($_POST['w_type_v']); else: $post_w_type_v = "0"; endif;
		if ((isset($_POST['w_type_g'])) && ($_POST['w_type_g'] != "")): $post_w_type_g = $mysqli->real_escape_string($_POST['w_type_g']); else: $post_w_type_g = "0"; endif;
		if ((isset($_POST['work_grade'])) && ($_POST['work_grade'] != "")): $post_work_grade = $mysqli->real_escape_string($_POST['work_grade']); else: $post_work_grade = "0"; endif;
		if ((isset($_POST['type_rashod'])) && ($_POST['type_rashod'] != "")): $post_type_rashod = $mysqli->real_escape_string($_POST['type_rashod']); else: $post_type_rashod = "0"; endif;
		if ((isset($_POST['value_rashod'])) && ($_POST['value_rashod'] != "")): $post_value_rashod = $mysqli->real_escape_string($_POST['value_rashod']); else: $post_value_rashod = "0"; endif;

		//if (isset($_POST['date'])): $post_date = $_POST['date'] else: $post_date = "0";
		
		$sql = "INSERT INTO works (
								date, event_id, user_id, w_m, w_bigm, w_d, w_bigd, w_o, w_bigo, w_p, w_pr,
								w_shtraf, w_tr, w_leb, w_leb_m, w_leb_d, w_type_z, w_type_s, w_type_v,
								w_type_g, work_grade, type_rashod, value_rashod) VALUES ("
		//.$_POST['date'].", " //TODO Исправить на калькуляци значения DATETIME из получаемых данных их разных контролов
		."NOW(), "				//TODO Пока что подставляется текущая дата
		.$post_event_id.", "
		.$post_user_id.", "
		.$post_w_m.", "
		
		.$post_w_bigm.", "
		.$post_w_d.", "
		.$post_w_bigd.", "
		.$post_w_o.", "
		
		.$post_w_bigo.", "
		.$post_w_p.", "
		.$post_w_pr.", "
		.$post_w_shtraf.", "
		
		.$post_w_tr.", "
		.$post_w_leb.", "
		.$post_w_leb_m.", "
		.$post_w_leb_d.", "
		
		.$post_w_type_z.", "
		.$post_w_type_s.", "
		.$post_w_type_v.", "
		.$post_w_type_g.", "
		
		.$post_work_grade.", "
		.$post_type_rashod.", "
		.$post_value_rashod.")";
		
		debug($sql);
		debug($post_w_m." | ".$post_w_bigm);
		
		$result = $mysqli->query($sql) or die($mysqli->error);
		
		echo "Данные добавлены успешно";
		if (!$mysqli->error) {
			debug("Данные добавлены успешно");
		} else {
			debug("ОШИБКА ДОБАВЛЕНИЯ!", "ОШИБКА");
		}
		//$mysqli->close();
	
		header('Location: forms/main_template.php');
	} else
	{
		header('Location: forms/main_template.php');
	}
?>
