<div style="width: auto; margin: auto; padding: 10px 0px; border: 3px double gray; text-align: center; margin-top: 40px; ">
	<form name="smps" method="post" action="#">
		<table id="work_variants" cellspacing="0" cellpadding="0" style="margin: auto;" border="1">
		<tr>
			<td>
				<strong><a href="/base.php?order=date" alt="Сортировка по дате">Дата</a></strong>
			</td>
			<td>
				<strong><a href="/base.php?order=event_id" alt="Сортировка по мероприятию">Мероприятие</a></strong>
			</td>
			<td>
				<strong><a href="/base.php?order=user_id" alt="Сортировка по пользователю">ФИО</a></strong>
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
				
			<?php
				
				$input_radio_blank		= "<input type=\"radio\" disabled=\"disabled\" /><input type=\"radio\" checked=\"checked\" disabled=\"disabled\" />";
				$input_radio_checked	= "<input type=\"radio\" checked=\"checked\" disabled=\"disabled\" /><input type=\"radio\" disabled=\"disabled\" />";
				$input_radio_one_blank	= "<input type=\"checkbox\" disabled=\"disabled\" />";
				$input_radio_one_checked	= "<input type=\"checkbox\" checked=\"checked\" disabled=\"disabled\" />";
			
				if (!isset($mysqli)) mysql_init();
				
				if (isset($_GET['order']))
				{
					$order_by = " ORDER BY '".$_GET['order']."'";
				} else
				{
					$order_by = "";
				}
				
				$sql = "SELECT * FROM works WHERE user_id='".$_SESSION['user_id']."'".$order_by;
				
				debug($sql, "Неведомая ебанная хрень!");
			
				$result = $mysqli->query($sql) or die($mysqli->error);
				
				//debug($sql." || ".$result->num_rows, "Запрос");
				
				if ($result->num_rows > 0)
				{
					//start
					debug("Данные успешно получены");
					debug($sql, "Неведомая ебанная хрень!");
					
					//TODO Сделать нормальный, НЕ КОСТЫЛЬНЫЙ вывод.
	
					while ($row = $result->fetch_assoc()) {
					
					?>
					
					<tr>
						<td><?php echo $row['date']; ?></td>
						<td>
							<?php
								$sql_event = "SELECT name FROM events WHERE id='".$row['event_id']."'";
			
								$result_event = $mysqli->query($sql_event) or die($mysqli->error);
								if ($result_event->num_rows > 0)
								{
									$row_event = $result_event->fetch_assoc();
									echo $row_event['name'];
								} else
								{
									echo "Нет данных";
									debug($sql_event, "Получение имени мероприятия");
								}
								$result_event->free();
							?>
						</td>
						<td>
							<?php
								$sql_name = "SELECT full_name FROM users WHERE id='".$row['user_id']."'";
			
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
						</td>
						<td>
							<?php
								if ($row['w_bigm']) echo $input_radio_blank;
								else echo $input_radio_checked;
							?>
						</td>
						<td>
							<?php
								if ($row['w_bigd']) echo $input_radio_blank;
								else echo $input_radio_checked;
							?>
						</td>
						<td>
						<?php
								if ($row['w_bigo']) echo $input_radio_blank;
								else echo $input_radio_checked;
							?>
						</td>
						<td>
							<?php if ($row['w_p']) echo $input_radio_one_checked; else echo $input_radio_one_blank;	?>
						</td>
						<td>
							<?php
								if ($row['w_pr']) echo $input_radio_one_checked; else echo $input_radio_one_blank;
								if ($row['w_shtraf']) echo $input_radio_one_checked; else echo $input_radio_one_blank;
							?>
						</td>
						<td>
							<?php if ($row['w_tr']) echo $input_radio_one_checked; else echo $input_radio_one_blank; ?>
						</td>
						<td>
							<?php
								echo "<input type=\"text\" disabled=\"disabled\" value=\"".$row['w_leb']."\" style=\"width: 28px;\" />";
								if ($row['w_leb_m']) echo $input_radio_one_checked; else echo $input_radio_one_blank;
								if ($row['w_leb_d']) echo $input_radio_one_checked; else echo $input_radio_one_blank;
							?>
						</td>
						<td>
							<?php
								
							?>
						</td>
						<td>
						<?php
							echo "<input type=\"text\" disabled=\"disabled\" value=\"".$row['work_grade']."\" style=\"width: 18px;\" />";
						?>
						</td>
						<td>
						<?php
							
							switch ($row['type_rashod']) {
								case 0:
									$type_rashod_echo = "хрень ";
									break;
								case 1:
									$type_rashod_echo = "еда ";
									break;
								case 2:
									$type_rashod_echo = "вода ";
									break;
								case 3:
									$type_rashod_echo = "такси ";
									break;
								case 4:
									$type_rashod_echo = "бензин ";
									break;
								case 5:
									$type_rashod_echo = "стр. матер. ";
									break;
								case 6:
									$type_rashod_echo = "расходник ";
									break;
								case 7:
									$type_rashod_echo = "разное ";
									break;
							}
							
							echo $type_rashod_echo."<input type=\"text\" disabled=\"disabled\" value=\"".$row['value_rashod']."\" style=\"width: 48px;\" />";
						?>
						</td>
					</tr>
					
						<?php
					}
					
					//print_r($result);
					$result->free();
	
					//$_SESSION['user_id'] = $row['id'];
					//echo "[SESSION_START1]".$_SESSION['user_id']."[SESSION_END]";
	
					//setcookie("user_pass", md5(md5($user_pass).$salt), time() + 3600);
	
					//$query = "UPDATE users SET last_login = NOW() WHERE id = '".$row['id']."'";
					//$result = $mysqli->query($query);
	
					if ($mysqli->error)
					{
						debug($mysqli->errorno." ".$mysqli->error);
						debug($query, "Запрос");
						exit;
					}
	
					//header('Location: /base.php');
				} else
				{
					debug("Нет данных");
				}
			
			?>
		</table>
	</form>
</div>
