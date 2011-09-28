<?php

	// установка текущей временной зоны
	// хз для чего, но без этого сыпятся варнинги
	//date_default_timezone_set('GMT+3');
	
	debug(false);
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once($root.'/ringaero/xls/Classes/PHPExcel.php');
	require_once($root.'/ringaero/xls/Classes/PHPExcel/IOFactory.php');
	
	// установка начального и конечного значения интервала времени для выборки по билетам
	if (isset($_GET['in_date'])) {
		$in_date	=	$_GET['in_date'];
	} else {
		// $in_date	=	date("Y.m.d"); // тут высыпает варнинг по поводу даты и хз чего ещё
		$in_date	=	'01.11.2010'; // тут высыпает варнинг по поводу даты и хз чего ещё
	}
	
	if (isset($_GET['out_date'])) {
		$out_date	=	$_GET['out_date'];
		$out_date_old	=	$_GET['out_date'];
		list($day, $month, $year) = explode(".", $out_date);
		$out_date	=	date("d.m.Y", mktime(0,0,0,$month, $day, $year)+86400);
	} else {
		$out_date_old	=	date("d.m.Y"); // тут высыпает варнинг по поводу даты и хз чего ещё
		list($day, $month, $year) = explode(date("d.m.Y"), ".");
		$out_date	=	date("d.m.Y", mktime(0,0,0,$month, $day, $year)+86400);
	}
	
	// echo $in_date.$eol;
	// echo $out_date.$eol;
	// exit;
	
	// require_once("header.php");
	
	if (isset($_GET['report_type'])) {
		$report_type	=	$_GET['report_type'];
	} else {
		$report_type	=	"standart";
	}
	
	if (isset($_GET["id"])) {
		if ($_GET['id'] == 'all') {
			$addstr	=	"";
		} else {
			$Site_Id = $_GET["id"];
			$addstr	=	" AND V.Site_id = $Site_Id";
		}
	} else {
		echo " | NOT NOT NOT NOT EXIST | ";
		exit;
		$addstr	=	"";
	}
	
	function GetCustomDate($custom_date) {
		// echo "CUSTOM |".$custom_date."| /CUSTOM";
		$custom_date	=	list($day, $month, $year) = explode(".", $custom_date);
		switch ($month) {
			case 01:
				$custom_date = "Январь";
				break;
			case 02:
				$custom_date = "Февраль";
				break;
			case 03:
				$custom_date = "Март";
				break;
			case 04:
				$custom_date = "Апрель";
				break;
			case 05:
				$custom_date = "Май";
				break;
			case 06:
				$custom_date = "Июнь";
				break;
			case 07:
				$custom_date = "Июль";
				break;
			case 08:
				$custom_date = "Август";
				break;
			case 09:
				$custom_date = "Сентябрь";
				break;
			case 10:
				$custom_date = "Октябрь";
				break;
			case 11:
				$custom_date = "Ноябрь";
				break;
			case 12:
				$custom_date = "Декабрь";
				break;
		}
		return	$custom_date." ".$year." года";
	}
	
	$ms_link = mssql_connect($ms_server, $ms_user, $ms_pass) or die($eol."Не могу создать соединение.");
	mssql_select_db($ms_db) or die("Не могу выбрать базу.");
	
	if (($report_type === "partner") || ($report_type === "partner_1a")) {
		//global $log_file;
		//fputs($log_file, '$report_type = '.$report_type);
		//echo "report_type = ". $report_type.$eol;
		
		$squery_stavka	=	"SELECT Comission FROM AE_Users WHERE Site_ID = $Site_Id";
		
		//echo $squery_stavka.$eol;
	
		$result_stavka	=	mssql_query($squery_stavka);
		$count_stavka	=	mssql_num_rows($result_stavka);
		
		$i	=	0;
		
		if(!$result_stavka) exit ("Ошибка выполнения запроса");
		
		global $stavka;
		
		while ($i < $count_stavka) {
			$Sel_Comission = mssql_result($result_stavka, $i, "Comission");
			
			$stavka	= $Sel_Comission;
			//echo $stavka."\t\r\n";
			
			$i++;
		}
		
		mssql_free_result($result_stavka);
	}
	
	// Вычсиление процента ставки
	function GetPercent($percent) {
		global $stavka;
		$percent	= (($percent + $percent - $percent) * $stavka / 100);
		return $percent;
	}
?>