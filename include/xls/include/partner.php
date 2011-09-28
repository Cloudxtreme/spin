<?php
	
	// echo "Site_Id = ".$Site_Id;
	// exit;

	$objPHPExcel = PHPExcel_IOFactory::load("ring_aero_report_partner.xls");
	$objPHPExcel->setActiveSheetIndex(0);
	$aSheet = $objPHPExcel->getActiveSheet();
	
	$objPHPExcel_Style = new PHPExcel_Style_Conditional();
	
	$cout_number = 0;

	while ($i < $count) {
		$_id				=	mssql_result($result, $i, "id");
		// $_DateRequest	=	mssql_result($result, $i, "_DateRequest");
		// $_Contact		=	mssql_result($result, $i, "_Contact");
		// $_Email			=	mssql_result($result, $i, "_Email");
		// Блок инициализации переменных баз данных
		$_FormPay			=	mssql_result($result, $i, "_FormPay");
		$_Summa				=	mssql_result($result, $i, "_Summa");
		$_PaidSumma			=	mssql_result($result, $i, "_PaidSumma");
		$Tkt_Number			=	mssql_result($result, $i, "Tkt_Number");
		$Tkt_Issue_Date		=	mssql_result($result, $i, "Tkt_Issue_Date");
		// $_GDS			=	mssql_result($result, $i, "_GDS");
		$_TarifSumma		=	mb_convert_encoding(mssql_result($result, $i, "_TarifSumma"), 'utf-8', 'windows-1251');
		$summ_count[]		=	$i;
		$summ_tickets[]		=	$_Summa;
		$summ_percent[]		=	GetPercent($_Summa);
		
		// Вычисление общего кол-ва билетов по их видам
		// if ($_TarifSumma = "АЭ:Обычный полн") {
		// echo $_TarifSumma.$eol;
				
		$i++;
		$s_final_count++;
		
		//$currRow++;
		
		if ((mb_convert_encoding($_FormPay, 'utf-8', 'windows-1251') == "Наличными в агентстве") || (mb_convert_encoding($_FormPay, 'utf-8', 'windows-1251') == "Наличными курьеру") || (mb_convert_encoding($_FormPay, 'utf-8', 'windows-1251') == "Безналичный расчет")) {
			$nal	=	true;
			$cout_number++;
			$currRow++;
		} else {
			$nal	=	false;
		}
		
		if (!$debug_flag) {
			if ($nal) {
				// Поехали писать строки билетов
				// Обычный полный
				$aSheet->setCellValue('A'.$currRow, mb_convert_encoding($cout_number, 'utf-8', 'utf-8'));	// Порядковый номер
				$aSheet->setCellValue('B'.$currRow, mb_convert_encoding(mb_convert_encoding(mb_convert_encoding($Tkt_Issue_Date, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'), 'utf-8', 'utf-8'));	// Дата продажи эл. билета
				$aSheet->setCellValue('C'.$currRow, mb_convert_encoding($Tkt_Number, 'utf-8', 'utf-8'));	// Номер  электр. билета Аероэкспресс
				$aSheet->setCellValue('D'.$currRow, mb_convert_encoding($_id, 'utf-8', 'utf-8'));	// Номер заказа
				// $aSheet->setCellvalue("");
				$aSheet->setCellValue('E'.$currRow, mb_convert_encoding($_TarifSumma, 'utf-8', 'utf-8'));	// Цена электр. билета, руб.
				//$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("1:".mb_convert_encoding($_FormPay, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));	// Количество проданных электр. билетов, шт.
				$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("1", 'utf-8', 'utf-8'));	// Количество проданных электр. билетов, шт.
				$aSheet->setCellValue('G'.$currRow, mb_convert_encoding($_TarifSumma, 'utf-8', 'utf-8'));	// Сумма проданных электр. билетов, руб.
				$aSheet->setCellValue('H'.$currRow, mb_convert_encoding(GetPercent($_TarifSumma), 'utf-8', 'utf-8'));	// Сумма вознаграждения Агента, руб.
				$aSheet->setCellValue('I'.$currRow, mb_convert_encoding(($_TarifSumma - GetPercent($_TarifSumma)), 'utf-8', 'utf-8'));	// Сумма к перечислению руб.
				//$currRow++;
				
				// $aSheet->setCellValue('A'.($currRow+1), mb_convert_encoding($i, 'utf-8', 'utf-8'));
				// $aSheet->setCellValue('A'.$currRow, mb_convert_encoding(array_sum($summ_tickets), 'utf-8', 'utf-8'));
				
				//$currRow++
				//$cout_number++;
			}
		}
	}
	
	$currRow++;
	
	$aSheet->setCellValue('I7', mb_convert_encoding(mb_convert_encoding($out_date_old, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
			
	$aSheet->setCellValue('A17', "Общая сумма денежных средств, полученная от реализации электронных билетов за ".mb_convert_encoding(GetCustomDate($out_date_old), 'utf-8', 'utf-8'));
	
	$style_main_grid = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
			),
			'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			),
		),
	);
	
	$aSheet->mergeCells('A'.$currRow.':E'.$currRow);
	$aSheet->mergeCells('A'.($currRow+1).':F'.($currRow+1));
	
	$style_bold_grid = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			),
		),
	);
	
	$aSheet->getStyle('A20:I'.($currRow-1))->applyFromArray($style_main_grid);
	$aSheet->getStyle('A'.$currRow.':I'.($currRow+1))->applyFromArray($style_bold_grid);
	
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("                ИТОГО:", 'utf-8', 'utf-8'));
	$aSheet->getStyle('A'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->getStyle('A'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('E'.$currRow, mb_convert_encoding("=SUM(E21:E".($currRow-1).")", 'utf-8', 'utf-8'));
	$aSheet->getStyle('E'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("=SUM(F21:F".($currRow-1).")", 'utf-8', 'utf-8'));
	$aSheet->getStyle('F'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('G'.$currRow, mb_convert_encoding("=SUM(G21:G".($currRow-1).")", 'utf-8', 'utf-8'));
	$aSheet->getStyle('G'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('H'.$currRow, mb_convert_encoding("=SUM(H21:H".($currRow-1).")", 'utf-8', 'utf-8'));
	$aSheet->getStyle('H'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('I'.$currRow, mb_convert_encoding("=SUM(I21:I".($currRow-1).")", 'utf-8', 'utf-8'));
	$aSheet->getStyle('I'.$currRow)->getFont()->setBold(true);
	$currRow++;
	
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("                В том числе НДС 18%", 'utf-8', 'utf-8'));
	$aSheet->getStyle('A'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->getStyle('A'.$currRow)->getFont()->setBold(true);
	// $aSheet->setCellValue('F'.$currRow, mb_convert_encoding("=F".($currRow-1)."*18/118", 'utf-8', 'utf-8'));
	// $aSheet->getStyle('F'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('G'.$currRow, mb_convert_encoding("=G".($currRow-1)."*18/118", 'utf-8', 'utf-8'));
	$aSheet->getStyle('G'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('H'.$currRow, mb_convert_encoding("=H".($currRow-1)."*18/118", 'utf-8', 'utf-8'));
	$aSheet->getStyle('H'.$currRow)->getFont()->setBold(true);
	$aSheet->setCellValue('I'.$currRow, mb_convert_encoding("=I".($currRow-1)."*18/118", 'utf-8', 'utf-8'));
	$aSheet->getStyle('I'.$currRow)->getFont()->setBold(true);
	
	// echo $currRow;
	// exit;
	
	$agent_summ		=	round($aSheet->getCell('E'.($currRow  - 1))->getCalculatedValue(), 2);
	$nds		=	round($aSheet->getCell('G'.$currRow)->getCalculatedValue(), 2);
	$agent_summ_str	=	CurrencyToText($aSheet->getCell('E'.($currRow  - 1))->getCalculatedValue(),  "RUR");
	
	$aSheet->setCellValue('A18', mb_convert_encoding("составила  ".$agent_summ." (".$agent_summ_str.") рублей 00 копеек,  в том числе НДС 18% - ".$nds." руб.", 'utf-8', 'utf-8'));
	
	// 2. Вознаграждение Субагента составило 60 (Шестьдесят) рублей, в том числе НДС 18% - 9,15 руб. (Девять 
	// =SUM(D20:D23)
	
	$agent_summ		=	round($aSheet->getCell('H'.($currRow-1))->getCalculatedValue(), 2);
	$agent_summ_nds	=	round($aSheet->getCell('H'.$currRow)->getCalculatedValue(), 2);
	$currRow = $currRow + 3;
	
	$aSheet->getStyle('A'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("2. Вознаграждение Субагента составило ".$agent_summ." (  ) рублей, в том числе НДС 18% - ".$agent_summ_nds." руб.", 'utf-8', 'utf-8'));
	$currRow = $currRow + 3;
	
	$aSheet->getStyle('A'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("3.Настоящий отчёт свидетельствует об оказании Субагентом услуг Агенту по Договору в полном объёме.", 'utf-8', 'utf-8'));	
	$currRow = $currRow + 3;
	
	mssql_free_result($result);
	
	$squery_name	=	"SELECT Partner_name, General_Name, Contract_Date, Contract_Number, General_Name_Short FROM AE_Users";
	$squery_name	.=	" WHERE Site_Id = ".$Site_Id;
	
	// echo $squery_name.$eol;
	// exit;
	
	$result_name	=	mssql_query($squery_name);
	$count			=	mssql_num_rows($result_name);
	// echo "START Count |".$count."| END";
	// exit;
	
	// $aSheet->setCellValue('A1',  mb_convert_encoding($squery, 'utf-8', 'utf-8'));
	if(!$result_name) exit ("Ошибка выполнения запроса");
	// echo $count;
	
	$i = 0;
	
	while ($i < $count) {
		$Partner_Name = mssql_result($result_name, 0, "Partner_name");
		$General_Name = mssql_result($result_name, 0, "General_Name");
		$Contract_Date = mssql_result($result_name, 0, "Contract_Date");
		$Contract_Number = mssql_result($result_name, 0, "Contract_Number");
		$General_Name_Short = mssql_result($result_name, 0, "General_Name_Short");
		
		// echo $Partner_name, $General_Name, $Contract_Date, $Contract_Number;
		// exit;
		$i++;
	}
	
	$aSheet->setCellValue('A9', mb_convert_encoding(mb_convert_encoding($Partner_Name, 'utf-8', 'windows-1251').", именуемое в дальнейшем «Субагент» в лице Генерального директора ".mb_convert_encoding($General_Name.",", 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	$aSheet->setCellValue('A10', mb_convert_encoding("действующего на основании Устава, в рамках Договора ".mb_convert_encoding($Contract_Number, 'utf-8', 'windows-1251')." – далее Договор),  заключенного", 'utf-8', 'utf-8'));
	// $aSheet->setCellValue('A11', mb_convert_encoding("заключенного с ".mb_convert_encoding($Contract_Date, 'utf-8', 'windows-1251')." именуемым в дальнейшем «Агент», в лице".mb_convert_encoding($General_Name, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	$aSheet->setCellValue('E4', mb_convert_encoding("По оказанным услугам за период ".$in_date." года по ".$out_date_old." года", 'utf-8', 'utf-8'));
	$aSheet->setCellValue('E5', mb_convert_encoding("к Договору №".$Contract_Number, 'utf-8', 'utf-8')." от ".mb_convert_encoding($Contract_Date, 'utf-8', 'windows-1251'));
	
	$aSheet->getStyle('B'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding("Генеральный директор                                                   Генеральный директор", 'utf-8', 'utf-8'));	
	$currRow++;
	
	$aSheet->getStyle('B'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding("ЗАО «РИНГ»                                                                   ".mb_convert_encoding($Partner_Name, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	
	$currRow++;
	
	$aSheet->getStyle('B'.$currRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding("______________В.Е.Шкурдалов                                      ________________".mb_convert_encoding($General_Name_Short, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));

	
	// ________________, именуемое в дальнейшем «Агент» в лице Генерального директора _______________
	
	mssql_free_result($result_name);
	
?>