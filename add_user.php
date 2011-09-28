<?php

	require_once "include/mysql.php";
	require_once "include/check.php";
	
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

	if (isset($_POST['user_login']) && isset($_POST['user_pass']) && isset($_POST['user_re_pass']) && isset($_POST['full_name']) && isset($_POST['access']))
	{
		$user_login = $mysqli->real_escape_string($_POST['user_login']);
		
		$user_pass = $mysqli->real_escape_string($_POST['user_pass']);
		$user_re_pass = $mysqli->real_escape_string($_POST['user_re_pass']);
		$full_name = $mysqli->real_escape_string($_POST['full_name']);
		$access = $mysqli->real_escape_string($_POST['access']);
		$tax_proc = $mysqli->real_escape_string($_POST['tax_proc']);
		$tax_value = $mysqli->real_escape_string($_POST['tax_value']);
		
		if ($user_pass == $user_re_pass)
		{
			//ok
			$result = $mysqli->query("SELECT id, full_name FROM users WHERE login='".$user_login."'") or die($mysqli->error);
		
			if ($result->num_rows > 0)
			{
				//start
				$row = $result->fetch_assoc();
				echo "Пользователь с таким логином уже зарегистрирован под именем <strong>".$row['full_name']."</strong><br /><a href=\"add_user.php\">назад</a>";
			} else
			{
				//add user function

				
				$query = "INSERT INTO users (login, md5_pass, full_name, access, work_group, create_date, oklad, tax_value) 
										VALUES ('".$user_login."', '".md5(md5($user_pass).$salt)."', '".$full_name."', '".$access."', 'Пользователи', CURRENT_TIMESTAMP, ', ".$oklad.", ".$tax_proc.",".$tax_value."')";		
				
				$result = $mysqli->query($query);
				if ($mysqli->error)
				{
					echo $mysqli->error." ".$mysqli->errorno."<br />";
					echo "<br />".$query."<br />";
					exit;
				} else
				{
					echo "Новый пользователь успешно добавлен";
				}
				
				echo "<br /><a href=\"add_user.php\">назад</a>";
			}
		} else
		{
			echo "Пароли не совпадают.<br /><a href=\"add_user.php\">назад</a>";
			exit;
		}
	} else
	{
		?>
		
		<form action="add_user.php" method="post">
			<table>
				<tr>
					<td>Логин:<input type="text" name="user_login" /></td>
					<td>Пароль:<input type="password" name="user_pass" /></td>
					<td>Повтор пароля:<input type="password" name="user_re_pass" /></td>
					<td>Полное имя:<input type="text" name="full_name" /></td>
					<td>Доступ:<input type="text" name="access" /></td>
					<td>Ставка:<input type="text" name="tax_proc" /></td>
					<td>Оклад:<input type="text" name="tax_value" /></td>
				</tr>
				<tr>
					<td colspan="6"></td>
					<td><input type="submit" value="Добавить" /></td>
				</tr>
			</table>
		</form>
		
		<?php
	}
	
	$mysqli->close();
?>
