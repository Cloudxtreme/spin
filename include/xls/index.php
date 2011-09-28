<?php
	
	require_once('include/error.php');
	require_once('include/config.php');
	require_once('include/init.php');
	require_once('include/inttostr.php');
	require_once('include/functions.php');
	
	// Грёбанный, сука тормозной, но единственно блядь работающий запрос
	// НЕ ТРОГАТЬ!!!
	// ВООБЩЕ НИКОГДА НЕ ТРОГАТЬ!!!
	$squery	=	"SET NOCOUNT ON ";
	
	$squery	.=	"SELECT V.*, T.Request_Id, T._TarifSumma, T.Tkt_Issue_Date, T.Tkt_Number FROM VitaRequest V";
	$squery	.=	" LEFT JOIN VitaTickets T";
	$squery	.=	" ON (T.Request_Id = V.Id)";
	$squery	.=	" WHERE V._GDS = 'A'";
	$squery	.=	" AND T.Request_Id = V.Id";
	$squery	.=	" AND V._Refusal = 'N'";
	$squery	.=	" AND V._PaymentStatus = 1";	// В ДАЛЬНЕЙШЕМ ЗАМЕНИТЬ НА V._PaidSumma
	$squery	.=	" AND V._Summa > 0";	// В ДАЛЬНЕЙШЕМ ЗАМЕНИТЬ НА V._PaidSumma
	$squery	.=	" AND V._PaidSumma > 0";
	$squery	.=	" AND T.Tkt_Issue_Date > 0";
	$squery	.=	" AND V._DateRequest >= CONVERT(DATETIME, '".$in_date."', 104)";
	$squery	.=	" AND V._DateRequest <= CONVERT(DATETIME, '".$out_date."', 104)";
	$squery	.=	$addstr;
	$squery	.=	" ORDER BY V._DateRequest";
	
	$squery	.=	" SET NOCOUNT OFF";
	
	//echo $squery.$eol;
	//exit;
	
	$result	=	mssql_query($squery);
	$count	=	mssql_num_rows($result);
	
	//print_r($result);
	//exit;
	
	// $aSheet->setCellValue('A1',  mb_convert_encoding($squery, 'utf-8', 'utf-8'));
	
	if(!$result) exit ("Ошибка выполнения запроса");
	$count = mssql_num_rows($result);
	
	// echo $count;
	// exit;	
	
	// ВТОРОЙ ВАРИАНТ ВЫВОДА----------------------------------------------------------------	
	if ($count == 0) {
		echo "<div style=\"width: 100%; text-align: center;\"><br /><br /><br /><br /><br /><span style=\"font-weight: bold; color: red;\">Нет данных</span><br />";
		echo "<span style=\"font-weight: bold;\">Возвращение на страницу выборки</span></div>";
		echo '<script type="text/javascript">setTimeout("history.back();", 1000);</script>';
		exit;
	} elseif ($count > 0) {
		$i = 0;
		
		if ($report_type == "standart") {
			require_once('include/standart.php');
		} elseif ($report_type == "partner") {
			require_once('include/partner.php');
		} elseif ($report_type == "partner_1a") {
			require_once('include/partner_1a.php');
		} elseif ($report_type == "partner_all") {
			require_once('include/partner_all.php');
		} elseif ($report_type == "standart_wr") {
			require_once('include/standart_wr.php');
		} else {
			require_once('include/standart.php');
		}
		
	} else {
		exit("<p>Неверный формат ответа</p>");
	}
	
	require_once('include/footer.php');
?>
