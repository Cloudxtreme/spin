<?php
	require_once('include/error.php');
	require_once('include/config.php');
	debug(false);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Настройка опций формирования отчетов Аэроекспресс</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta name="description" content="Формирование отчета Аэроэкспресс" />
	<meta name="keywords" content="Формирование отчета Аэроэкспресс" />
	<meta name="robots" content="all" />
	<link rel="stylesheet" href="xls_style.css" type="text/css" media="screen" />
	<!-- <link rel="stylesheet" href="themes/base/jquery.ui.all.css"> -->
	<link rel="stylesheet" href="themes/base/jquery.ui.base.css" />
	<link rel="stylesheet" href="themes/base/jquery.ui.theme.css" />
	<script src="jquery-1.4.4.min.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.datepicker.js"></script>
	<script src="ui.datepicker-ru.js"></script>
	<script type="text/javascript">
		function check_input()
		{
			var e=window.document;
			
			if ( e.getElementById("in_date").value == '' )
			{
				alert( "Заполните поле 'Начальная дата'" );
				return false;
			} else
			if ( e.getElementById("out_date").value == '' )
			{
				alert( "Заполните поле 'Конечная дата'" );
				return false;
			}else 
			{
				return true;
			}
			return false;
		}
		
		function check_select()
		{
			var st = window.document.getElementById("standart");
			var stwr = window.document.getElementById("standart_wr");
			var sl = window.document.getElementById("select");
			var span = window.document.getElementById("span");
			var spanhidden = window.document.getElementById("span_hidden");
			
			if ( st.checked || stwr.checked )
			{
				span.style.display = "none";
				spanhidden.style.display = "block";
				sl.disabled = true;
				sl.style.display = "none";
			} else
			{
				span.style.display = "block";
				spanhidden.style.display = "none";
				sl.disabled = false;
				sl.style.display = "block";
			}
		}
		
		function dayselection()
		{
			var indate = window.document.getElementById("in_date");
			var outdate = window.document.getElementById("out_date");
			
			today = new Date();
			todaynew=new Date(today.getTime());
			nextmonth=new Date(today.getTime()+(86400000*30));
			
			if ( todaynew.getMonth() == 0 )
			{
				todaynewval = 12;
				indate.value = '01.' + todaynewval + '.' + today.getFullYear();
			} else
			{
				indate.value = '01.' + todaynew.getMonth() + '.' + today.getFullYear();
			}
			
			if ( nextmonth.getMonth() == 0 )
			{
				nextmonthval = 12;
				outdate.value = '01.' + nextmonthval + '.' + today.getFullYear();
			} else
			{
				outdate.value = '01.' + nextmonth.getMonth() + '.' + today.getFullYear();
			}
		}
		
		$(function() {
			$( "#in_date" ).datepicker();
			$( "#out_date" ).datepicker();
		});
		</script>
</head>

<body onload="dayselection()">

<div id="wrapper">

	<div id="header">
	</div><!-- #header-->

	<div id="middle">

		<div id="container">
			<div id="content">
				<div align="center">
				<table>
					<tr>
						<td>
							<div id="gray" style="padding: 20px; margin: 20px;">
								<form action="index.php" method="get" onsubmit="javascript:return check_input() ">
									<table>
										<tr>
											<td colspan="2" style="height: 20px;">
												<span style="margin: 10px 0px; color: #999; ">Введите необходимые параметры выборки</span>
											</td> 
										</tr>
										<tr>
											<td style="text-align: left;">
												<span>Начальная дата:</span><br />
												<input id="in_date" type="text" name="in_date" value="" tabindex="1" style="width: 142px;" />
											</td>
											<td style="text-align: left;">
												<span>Конечная дата:</span><br />
												<input id="out_date" type="text" name="out_date" tabindex="2" style="width: 142px;" />
											</td>
										</tr>
										<tr>
											<td style="text-align: left;">
												<span id="span">ID / Сайт партнёра:</span>
												<!-- <span id="span_hidden" style="display: block;">&nbsp;</span> -->
											</td>
											<td>
												<select name="id" id="select" style="width: 146px; ">
												<?php

													$ms_link = mssql_connect($ms_server, $ms_user, $ms_pass) or die("Не могу создать соединение.");
													mssql_select_db($ms_db) or die("Не могу выбрать базу.");													
													
													// if (($_COOKIE['UserID'] != 'sbaero1') & ($_COOKIE['UserID'] != 'sbring6') & ($_COOKIE['UserID'] != 'sbring_su'))
													if ($_COOKIE['UserID'] != 'sbring_su')
													{
														$adm_access = false;

														$squery_id	=	"SELECT SID FROM GID_SID WHERE GID = (SELECT uid FROM sysusers WHERE name = '".$_COOKIE['UserID']."') ORDER BY SID";
													
														$result_id	=	mssql_query($squery_id);
														$count_id	=	mssql_num_rows($result_id);
														
														// echo $count_id;
														// exit;
													
														$i	=	0;
													
														if(!$result_id) exit ("Ошибка выполнения запроса");
													
														while ($i < $count_id) {
															$Usr_Site_ID = mssql_result($result_id, $i, "SID");
															
															echo "<option value=\"".$Usr_Site_ID."\">".$Usr_Site_ID."</option>";
														
															$i++;
														}
														
														mssql_free_result($result_id);
													} else
													{
														$adm_access = true;
														echo "<option selected=\"selected\" value=\"all\">Все</option>";
														
														$squery_adm	=	"SELECT Partner_name, Site_ID FROM AE_Users";
														
														$result_adm	=	mssql_query($squery_adm);
														$count_adm	=	mssql_num_rows($result_adm);
														
														$i	=	0;
														
														if(!$result_adm) exit ("Ошибка выполнения запроса");
														
															while ($i < $count_adm) {
															$Sel_Partner_name = mssql_result($result_adm, $i, "Partner_name");
															$Sel_Site_ID = mssql_result($result_adm, $i, "Site_ID");
															
															echo "<option value=\"".$Sel_Site_ID."\">".$Sel_Partner_name."</option>";
															
															$i++;
														}
														
														mssql_free_result($result_adm);
													}
													
													// echo $squery.$eol;
													// exit;

													mssql_close($ms_link);

												?>
												</select>
											</td>
										</tr>
										<?php
											// if (($_COOKIE['UserID'] != 'sbring_su') || ($_COOKIE['UserID'] != 'sbaero1')) 
											if (!$adm_access)
											{ ?>
												<tr>
													<td colspan="2" style="text-align: left;">
														<input class="radio" id="partner" type="hidden" name="report_type" value="partner" onclick="check_select()" />
													</td>
												</tr> <?php 
											} else 
											{ ?>
												<tr>
													<td colspan="2" style="text-align: left;">
														<input class="radio" id="standart" type="radio" checked="checked" name="report_type" value="standart" />
														<label for="standart">В АэроЭкспресс, полный</label>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: left;">
														<input class="radio" id="standart_wr" type="radio" name="report_type" value="standart_wr" />
														<label for="standart_wr">В АэроЭкспресс, без перечисления</label>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: left;">
														<input class="radio" id="partner" type="radio" name="report_type" value="partner" onclick="check_select()" />
														<label for="partner">Отчет субагента (Приложение №1)</label>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: left;">
														<input class="radio" id="partner_1a" type="radio" name="report_type" value="partner_1a" onclick="check_select()" />
														<label for="partner_1a">Отчет субагента (Приложение №1а)</label>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="text-align: left;">
														<input class="radio" id="partner_all" type="radio" name="report_type" value="partner_all" onclick="check_select()" />
														<label for="partner_1a">Отчет субагента (Приложение №3)</label>
													</td>
												</tr> 
												<?php 
											} ?>
										<tr>
											<td colspan="2" style="text-align: right;">
												<input type="submit" value="Сформировать" style="font-size: 12px; width: 120px;" />
											</td>
										</tr>
									</table>
								</form>
							</div>
						</td>
					</tr>
				</table>
				</div>
			</div><!-- #content-->
		</div><!-- #container-->

		<div class="sidebar sl">
		</div><!-- .sidebar.sl -->
		
		<div class="sidebar sr">
		</div><!-- .sidebar.sr -->

	</div><!-- #middle-->

</div><!-- #wrapper -->

<div id="footer">
<p>
	<a href="http://validator.w3.org/check?uri=referer">
		<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" />
	</a>
	
	<a href="http://jigsaw.w3.org/css-validator/check/referer">
		<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Правильный CSS!" />
	</a>
</p>
</div><!-- #footer -->

</body>
</html>
