<?php

	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");
	
	include_once $root_dir."include/mysql.php";
	if (!isset($mysqli)) mysql_init();
	
	include_once $root_dir."include/check.php";
	
	if (CheckUserLogin() == 2)
	{
		echo "Обнаружен неправомерный доступ. Администратору отправлено сообщение с данными о вашем компьютере.";
		exit;
	} elseif (CheckUserLogin() == 1)
	{
		// несуществует $_SESSION['user_id']
		echo "Обнаружен неправомерный доступ. Администратору отправлено сообщение с данными о вашем компьютере.";
		exit;
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Система учета зарплаты Спин Мьюзик Сервис</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="none" />
	<link rel="stylesheet" type="text/css" href="css/spin.css" />
	<link rel="stylesheet" href="themes/base/jquery.ui.base.css" />
	<link rel="stylesheet" href="themes/base/jquery.ui.theme.css" />
	<script src="js/jquery-1.6.1.min.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript">		
		$(function() {
			$( "#in_date" ).datepicker();
			$( "#out_date" ).datepicker();
		});
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
					//debug($sql_name, "Получение имени пользователя");
				}
				$result_name->free();
			?>
		</a><br />
		<a href="/calc.php" alt="Расчитать ЗП" style="text-align: right;">Расчитать ЗП</a>
		<?php //TODO Изменить период расчета на 1 (одну) неделю ?>
	</div>
	<div style="float: right; width: 400px;">
		<strong>Показать данные по дате: </strong><input id="out_date" type="text" value="" /><input id="" type="button" value="Обновить" /><br />
		<a href="/add_work.php">Добавить данные</a>
	</div>
</div>

<?php

	include_once "forms/base_template.php";
	
?>

</body>

</html>
