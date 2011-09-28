		<form action="login.php" enctype="multipart/form-data" method="post">
			<table>
				<tr>
					<td>Логин:</td>
					<td><input type="text" name="user_login" <?php if (isset($user_login)) { echo "value=\"".$user_login."\""; } ?> /></td>
				</tr>
				<tr>
					<td>Пароль:</td>
					<td><input type="password" name="user_pass" /></td>
				</tr>
				<tr>
					<td>Файл авторизиции:</td>
					<td><input type="file" name="keyfile" size="40"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Войти" /></td>
				</tr>
			</table>
		</form>
