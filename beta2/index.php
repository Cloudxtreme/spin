<?php
	$root_dir = $_SERVER['DOCUMENT_ROOT'];
	
	//exit;
	
	include_once $root_dir."include/PhpConsole.php";
	PhpConsole::start();
	
	//debug($root_dir, "root_dir");

	include_once $root_dir."include/mysql.php";
	
	//include $root_dir."include/check.php";
	
	define("DEBUG", "true");
	
	//debug("Режим отладки включен");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Spin Music Service Distributed Control System And User Events</title>
	<meta name="description" content="Spin Music Grid System" />
	<meta name="keywords" content="Spin Music Grid System" />
	<meta name="robots" content="none" />
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/text.css" />
	<link rel="stylesheet" href="css/960.css" />
	<link rel="stylesheet" href="css/custom.css" />
	<?php if (DEBUG): echo "<link rel=\"stylesheet\" href=\"css/debug.css\" />\r\n"; endif; ?>
	<script type="text/JavaScript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script type="text/JavaScript" src="js/functions.js"></script>
	<script>
		$("#users_list").change(function () {
			ajax_add_peple();
		})
		.change();
	</script>
</head>

<body onload="update_user_list(); update_event_list();">
<span id="error_block" style="font-weight: bold; display: none;">Pasring Database error, 10045Er</span>

<div class="container_12">
	<form id="edit_from" method="post" action="edit.php">
		<h2>
			Spin Music Service Distributed Control System And User Events
		</h2>
	
		<div class="grid_3">
			<select id="users_list" name="one_list" style="width: 200px;" onChange="ajax_add_peple();">
			  <option value="0" onChange="ajax_add_peple();">Новый пользователь</option>
			</select>
		</div>
		<!-- end .grid_3 -->
	
		<div class="grid_2">
			<input id="add_new_user" type="button" value="Добавить" style="width: 70px;" onclick="ajax_add_peple();" />
			<input id="add_new_user_hide" type="button" class="hide" value="Скрыть" style="width: 70px;" onclick="ajax_add_peple();" />
		
		</div>
		<!-- end .grid_2 -->
	
		<div class="grid_4">
			<select id="event_list" name="event" style="width: 300px;" onChange="update_event_list();">
				<option value="0" onChange="update_event_list();">Новое меропприятие</option>
			</select>
		</div>
		<!-- end .grid_7 -->
		
		<div class="grid_2">
			<input id="add_new_event" type="button" value="Добавить" style="width: 70px;" onclick="ajax_add_event();" />
			<input id="add_new_event_hide" type="button" class="hide" value="Скрыть" style="width: 70px;" onclick="ajax_add_event();" />
		
		</div>
		<div class="clear"></div>
	
		<!-- Новая строка грида -->
	
		<div id="fio_block" class="grid_3 hide">
			<span style="text-weight: bold;">ФИО</span><br />
			<input id="fio_input" class="worked_input" type="text" value="" style="width: 160px;"/>
		</div>
		<!-- end .grid_3 -->
	
		<div id="oklad_block" class="grid_1 hide">
			<span style="text-weight: bold;">Оклад</span><br />
			<input id="oklad_input" class="worked_input" type="text" name="oklad" value="" style="width: 40px;"/>
		</div>
		<!-- end .grid_1 -->
	
		<div id="stavka_block" class="grid_1 hide">
			<span style="text-weight: bold;">Ставка</span><br />
			<input id="stavka_input" class="worked_input" type="text" name="stavka" value="" style="width: 40px;"/>
		</div>
		<!-- end .grid_1 -->
	
		<div id="radio_block" class="grid_2 hide">
			<span style="text-weight: bold;">&nbsp;&nbsp;З&nbsp;&nbsp;&nbsp;&nbsp;С&nbsp;&nbsp;&nbsp;&nbsp;В&nbsp;&nbsp;&nbsp;&nbsp;Г</span><br />
			<input id="radio_z" type="radio" name="zsvg" value="z" checked="checked">
			<input id="radio_s" type="radio" name="zsvg" value="s">
			<input id="radio_v" type="radio" name="zsvg" value="v">
			<input id="radio_g" type="radio" name="zsvg" value="g">
		</div>
		<!-- end .grid_3 -->
	
		<div id="button_block" class="grid_2 hide">
			<span style="text-weight: bold;"></span><br />
			<input type="button" value="O.K." style="width: 100px;"  onclick="edit_add(); " />
		</div>
		<!-- end .grid_2 -->
		
		<div id="return_code" class="grid_3 hide">
			<img src="/beta2/img/ajax_load.gif" />
		</div>
		<!-- end .grid_3 -->
		<div class="clear"></div>
	
		<!-- Новая строка грида -->

		<div id="event_name_block" class="grid_3 hide">
			<span style="text-weight: bold;">Название мероприятия</span><br />
			<input type="text" id="event_name" style="width: 200px;" />
		</div>
		<!-- end .grid_3 -->
		
		<div id="event_datein_block" class="grid_2 hide">
			<span style="text-weight: bold;">Дата начала</span><br />
			<input type="text" id="event_datein" style="width: 130px;" />
		</div>
		<!-- end .grid_2 -->
		
		<div id="event_dateout_block" class="grid_2 hide">
			<span style="text-weight: bold;">Дата окончания</span><br />
			<input type="text" id="event_dateout" style="width: 130px;" />
		</div>
		<!-- end .grid_2 -->

		<div id="event_add_users_block" class="grid_2 hide">
			<span style="text-weight: bold;">Сотрудники</span><br />
			<select id="event_users_list" name="event_users_list" multiple="true" size="9" onChange="update_event_user_list();">
				
			</select>
		</div>
		<!-- end .grid_2 -->
		
		<div id="event_add_users_button_block" class="grid_2 hide">
			<span style="text-weight: bold;"></span><br />
			<input type="button" value="O.K." style="width: 100px;"  onclick="edit_add_users_to_event(); " />
		</div>
		<!-- end .grid_2 -->
		
		

		<div class="clear"></div>

		<!-- Новая строка грида -->

		<div class="grid_3">
		<p>
		220
		</p>
		</div>
		<!-- end .grid_3 -->
		<div class="grid_9">
		<p>
		700
		</p>
		</div>
		<!-- end .grid_9 -->
		<div class="clear"></div>
		<div class="grid_4">
		<p>
		300
		</p>
		</div>
		<!-- end .grid_4 -->
		<div class="grid_8">
		<p>
		620
		</p>
		</div>
		<!-- end .grid_8 -->
		<div class="clear"></div>
		<div class="grid_5">
		<p>
		380
		</p>
		</div>
		<!-- end .grid_5 -->
		<div class="grid_7">
		<p>
		540
		</p>
		</div>
		<!-- end .grid_7 -->
		<div class="clear"></div>
		<div class="grid_6">
		<p>
		460
		</p>
		</div>
		<!-- end .grid_6 -->
		<div class="grid_6">
		<p>
		460
		</p>
		</div>
		<!-- end .grid_6 -->
		<div class="clear"></div>
		
		<!-- Новая строка грида -->

		<div class="grid_6 push_6">
		<div class="grid_1 alpha">
		<p>
		60
		</p>
		</div>
		<!-- end .grid_1.alpha -->
		<div class="grid_5 omega">
		<p>
		380
		</p>
		</div>
		<!-- end .grid_5.omega -->
		<div class="clear"></div>
		<div class="grid_3 alpha">
		<p>
		220
		</p>
		</div>
		<!-- end .grid_3.alpha -->
		<div class="grid_3 omega">
		<p>
		220
		</p>
		</div>
		<!-- end .grid_3.omega -->
		</div>
		<!-- end .grid_6.push_6 -->
		<div class="grid_6 pull_6">
		<div class="grid_3 alpha">
		<p>
		220
		</p>
		</div>
		<!-- end .grid_3.alpha -->
		<div class="grid_3 omega">
		<p>
		220
		</p>
		</div>
		<!-- end .grid_3.omega -->
		<div class="clear"></div>
		
		<!-- Новая строка грида -->
		
		<div class="grid_1 alpha">
		<p>
		60
		</p>
		</div>
		<!-- end .grid_1.alpha -->
		<div class="grid_5 omega">
		<p>
		380
		</p>
		</div>
		<!-- end .grid_5.omega -->
		</div>
		<!-- end .grid_6.pull_6 -->
	</form>
</div>
<!-- end .container_12 -->

</body>
</html>
