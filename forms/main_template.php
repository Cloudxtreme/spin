<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");
	
	include_once $root_dir."include/mysql.php";
	if (!isset($mysqli)) mysql_init();
	
	include_once $root_dir."include/check.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Система учета зарплаты Спин Мьюзик Сервис</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="none" />
	<link rel="stylesheet" type="text/css" href="/css/spin.css" />
	<script type="text/javascript">
		var i = 1;
		
		function data_count_write()
		{
			while (i < 32)
			{
				if (i == 19)
				{
					document.write("\t\t\t<option value=\"" + i + "\" selected=\"selected\" />" + i + "</option>\r\n");
					i++;
				}
				document.write("\t\t\t<option value=\"" + i + "\" />" + i + "</option>\r\n");
				i++;
			}
		}
	</script>
</head>

<body>
<div style=" height: 20px;">
	<div style="float: left; width: 300px;">
		<strong>Вы вошли как: </strong>
		<a href="/profile.php" title="Посмотреть данные пользователя" style="color: blue; text-decoration: underline;">
			<?php
				$sql_name = "SELECT full_name FROM users WHERE id='".$_SESSION['user_id']."'";

				$result_name = $mysqli->query($sql_name) or die($mysqli->error);
				if ($result_name->num_rows > 0)
				{
					$row_name = $result_name->fetch_assoc();
					echo $row_name['full_name'];
				} else
				{
					echo "Нет данных";
					debug($sql_name, "Получение имени пользователя");
				}
				$result_name->free();
			?>
		</a>
	</div>
	<div style="float: right; text-align: right; width: 400px;">
		<a href="/base.php">Назад</a>
	</div>
</div>
<div style="width: auto; margin: auto; padding: 10px 0px; border: 3px double gray; text-align: center; margin-top: 40px; ">
	<form name="smps" method="post" action="/add_work.php">
		<table id="work_variants" cellspacing="0" cellpadding="0" style="margin: auto;" border="0">
		<tr>
			<td>
				<strong>Дата</strong>
			</td>
			<td>
				<strong>Мероприятие</strong>
			</td>
			<td>
				<strong>ФИО</strong>
			</td>
			<td>
				<strong>M</strong>  <strong>БM</strong>
			</td>
			<td>	
				<strong>Д</strong>  <strong>БД</strong>
			</td>
			<td>
				<strong>О</strong>  <strong>БО</strong>
			</td>
			<td>
				<strong>П</strong>
			</td>
			<td>
				<strong>Пр</strong>  <strong>Штр</strong>
			</td>
			<td>
				<strong>Тр</strong>
			</td>
			<td>
				<strong>Леб    М  Д</strong>
			</td>
			<td>
				<strong>З С В Г</strong>
			</td>
			<td>
				<strong>оценка<br />работы</strong>
			</td>
			<td>
				<strong>накл. расх.</strong>
			</td>
		</tr>
		<tr>
			<td>
				<select id="cal_d" name="day">
					<script type="text/javascript">
						data_count_write();
					</script>
				</select>
				<select name="month">
					<option value="1" />январь</option>
					<option value="2" />февраль</option>
					<option value="3" />март</option>
					<option value="4" />апрель</option>
					<option value="5" />май</option>
					<option value="6" />июнь</option>
					<option value="7" />июль</option>
					<option value="8" selected="selected" />август</option>
					<option value="9" />сентябрь</option>
					<option value="10" />окбяьбрь</option>
					<option value="11" />ноябрь</option>
					<option value="12" />декабрь</option>
				</select>
				<input id="save_btn" type="submit" value="+" />
				<input id="action_hidden" type="hidden" name="action" value="write" />
			</td>
			<td>
				<select name="event_id">
					<?php
						$sql_event_id = "SELECT name, id FROM events";
	
						$result_event_id = $mysqli->query($sql_event_id) or die($mysqli->error);
						if ($result_event_id->num_rows > 0)
						{
							while ($row_event_id = $result_event_id->fetch_assoc()) {
								echo "<option value=\"".$row_event_id['id']."\" />".$row_event_id['name']."</option>";
							}
						} else
						{
							echo "Нет данных";
							debug($sql_event_id, "Получение имени мероприятия");
						}
						$result_event_id->free();
					?>
					<input id="save_btn" type="submit" value="+" />
				</select>
			</td>
			<td>
				<select name="user_id">
					<?php
						$sql_name_id = "SELECT full_name, id FROM users";

						$result_name_id = $mysqli->query($sql_name_id) or die($mysqli->error);
						if ($result_name_id->num_rows > 0)
						{
							while ($row_name_id = $result_name_id->fetch_assoc()) {
								echo "<option value=\"".$row_name_id['id']."\" />".$row_name_id['full_name']."</option>";
							}
						} else
						{
							echo "Нет данных";
							debug($sql_name_id, "Получение имени пользователя");
						}
						$result_name_id->free();
					?>
					<input id="save_btn" type="submit" value="+" />
				</select>
			</td>
			<td>	
				<input class="work_type" type="checkbox" name="w_m" value="" />
				<input class="work_type" type="checkbox" name="w_bigm" value="" />
			</td>
			<td>
				<input class="work_type" type="checkbox" name="w_d" value="" />
				<input class="work_type" type="checkbox" name="w_bigd" value="" />
			</td>
			<td>
				<input class="work_type" type="checkbox" name="w_o" value="" />
				<input class="work_type" type="checkbox" name="w_bigo" value="" />
			</td>
			<td>
				<input class="work_type" type="checkbox" name="w_p" value="" />
			</td>
			<td>
				<input class="work_type" type="checkbox" name="w_pr" value="" />
				<input class="work_type" type="checkbox" name="w_shtraf" value="" />
			</td>
			<td>
				<input class="work_type" type="checkbox" name="w_tr" value="" />
			</td>
			<td>
				<input class="leb_count" type="text" name="w_leb" value="" style="width: 30px;" />
				<input class="leb_count" type="checkbox" name="w_leb_m" value="" />
				<input class="leb_count" type="checkbox" name="w_leb_d" value="" />
			</td>
			<td>
				<input class="work_type" type="radio" name="w_type_z" value="" />
				<input class="work_type" type="radio" name="w_type_s" value="" />
				<input class="work_type" type="radio" name="w_type_v" value="" />
				<input class="work_type" type="radio" name="w_type_g" value="" />
				
			</td>
			<td>
				<select name="work_grade">
					<option value="1" />1</option>
					<option value="2" />2</option>
					<option value="3" />3</option>
					<option value="4" />4</option>
					<option value="5" />5</option>
					<option value="6" />6</option>
					<option value="7" />7</option>
					<option value="8" />8</option>
					<option value="9" />9</option>
				</select>
			</td>
			<td>
				<select name="type_rashod">
					<option value="1" selected="selected" />еда</option>
					<option value="2" />вода</option>
					<option value="3" />такси</option>
					<option value="4" />бензин</option>
					<option value="5" />стр. матер.</option>
					<option value="6" />расходник</option>
					<option value="7" />разное</option>
				</select>
				<input class="work_type" type="text" name="value_rashod" value="" style="width: 50px;" />
			</td>
		</tr>
		<tr>
			<td colspan="12">
			</td>
			<td>
				<input id="save_btn" type="submit" value="Сохранить" />
			</td>
		</tr>
	</table>
	</form>
</div>
</body>

</html>
