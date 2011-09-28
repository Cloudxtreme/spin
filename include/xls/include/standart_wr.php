<?php
	
	$objPHPExcel = PHPExcel_IOFactory::load("ring_aero_report_standart_wr.xls");
	$objPHPExcel->setActiveSheetIndex(0);
	$aSheet = $objPHPExcel->getActiveSheet();

	while ($i < $count) {
		$_id = mssql_result($result, $i, "id");
		$_DateRequest = mssql_result($result, $i, "_DateRequest");
		$_Contact = mssql_result($result, $i, "_Contact");
		$_Email = mssql_result($result, $i, "_Email");
		$_Phone = mssql_result($result, $i, "_Phone");
		$_Summa = mssql_result($result, $i, "_Summa");
		$_PaidSumma = mssql_result($result, $i, "_PaidSumma");
		$_GDS = mssql_result($result, $i, "_GDS");
		$_TarifSumma = mb_convert_encoding(mssql_result($result, $i, "_TarifSumma"), 'utf-8', 'windows-1251');
		$summ_count[] = $i;
		$summ_tickets[] = $_Summa;
		$summ_percent[] = GetPercent($_Summa);	// Сейчас берется значение $stavka = 10; из config.php
		
		// Вычисление общего кол-ва билетов по их видам
		// if ($_TarifSumma == "АЭ:Обычный полн") {
		// echo $_TarifSumma.$eol;
		
		if (($_TarifSumma == $s_ticket) || $_TarifSumma == $s_ticket_new) {
			$s_final_count++;
		}			
		
		if (($_TarifSumma == $b_ticket) || ($_TarifSumma == $b_ticket_new)) {
			$b_final_count++;
		}		
		
		if (($_TarifSumma == $sc_ticket) || ($_TarifSumma == $sc_ticket_new)) {
			$sc_final_count++;
		}	
		
		if (($_TarifSumma == $bc_ticket) || ($_TarifSumma == $bc_ticket_new)) {
			$bc_final_count++;
		}			
					
		// $aSheet->insertNewRowBefore($currRow, 1);
		// $Output();
		// $ChangeColorLine();
				
		$i++;
	}
	
	// Поехали писать строки билетов
	// Обычный полный
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("1", 'utf-8', 'utf-8'));
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding($in_date."-".$out_date_old, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('C'.$currRow, mb_convert_encoding($s_ticket_new, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('D'.$currRow, mb_convert_encoding($s_final_count, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('E'.$currRow, mb_convert_encoding("=C".$currRow."*D".$currRow, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("=E".$currRow."*10/100", 'utf-8', 'utf-8'));
	// $aSheet->setCellValue('G'.$currRow, mb_convert_encoding("=E".$currRow."-F".$currRow, 'utf-8', 'utf-8'));
	$currRow++;
	
	// Бизнес полный
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("2", 'utf-8', 'utf-8'));
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding($in_date."-".$out_date_old, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('C'.$currRow, mb_convert_encoding($b_ticket_new, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('D'.$currRow, mb_convert_encoding($b_final_count, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('E'.$currRow, mb_convert_encoding("=C".$currRow."*D".$currRow, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("=E".$currRow."*10/100", 'utf-8', 'utf-8'));
	// $aSheet->setCellValue('G'.$currRow, mb_convert_encoding("=E".$currRow."-F".$currRow, 'utf-8', 'utf-8'));
	$currRow++;
	
	// Детский полный
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("3", 'utf-8', 'utf-8'));
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding($in_date."-".$out_date_old, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('C'.$currRow, mb_convert_encoding($sc_ticket_new, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('D'.$currRow, mb_convert_encoding($sc_final_count, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('E'.$currRow, mb_convert_encoding("=C".$currRow."*D".$currRow, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("=E".$currRow."*10/100", 'utf-8', 'utf-8'));
	// $aSheet->setCellValue('G'.$currRow, mb_convert_encoding("=E".$currRow."-F".$currRow, 'utf-8', 'utf-8'));
	$currRow++;

	// Детский Бизнес
	$aSheet->setCellValue('A'.$currRow, mb_convert_encoding("4", 'utf-8', 'utf-8'));
	$aSheet->setCellValue('B'.$currRow, mb_convert_encoding($in_date."-".$out_date_old, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('C'.$currRow, mb_convert_encoding($bc_ticket_new, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('D'.$currRow, mb_convert_encoding($bc_final_count, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('E'.$currRow, mb_convert_encoding("=C".$currRow."*D".$currRow, 'utf-8', 'utf-8'));
	$aSheet->setCellValue('F'.$currRow, mb_convert_encoding("=E".$currRow."*10/100", 'utf-8', 'utf-8'));
	// $aSheet->setCellValue('G'.$currRow, mb_convert_encoding("=E".$currRow."-F".$currRow, 'utf-8', 'utf-8'));
	
	// $aSheet->setCellValue('G7', mb_convert_encoding(mb_convert_encoding(russian_date_m("d F Y"), 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	$aSheet->setCellValue('G7', mb_convert_encoding(mb_convert_encoding($out_date_old, 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	
	// $aSheet->setCellValue('A16', "Общая сумма денежных средств, полученная от реализации электронных билетов за ".mb_convert_encoding(mb_convert_encoding(russian_date("F Y"), 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	// echo "START |".$out_date."||".GetCustomDate($out_date_old)."| STOP";
	// exit;
	
	$aSheet->setCellValue('A16', "Общая сумма денежных средств, полученная от реализации электронных билетов за ".mb_convert_encoding(GetCustomDate($out_date_old), 'utf-8', 'utf-8'));
	
	// $aSheet->setCellValue('A16', "Общая сумма денежных средств, полученная от реализации электронных билетов за ".mb_convert_encoding(mb_convert_encoding(($out_date+1), 'utf-8', 'windows-1251'), 'utf-8', 'utf-8'));
	
	$summ		=	round($aSheet->getCell('E24')->getCalculatedValue(), 2);
	$summ_str	=	CurrencyToText($aSheet->getCell('E20')->getCalculatedValue(),  "RUR");
	
	$nds = round($aSheet->getCell('E25')->getCalculatedValue(), 2);
	$aSheet->setCellValue('A17', mb_convert_encoding("составила  ".$summ." (".$summ_str.") рублей 00 копеек,  в том числе НДС 18% - ".$nds." руб.", 'utf-8', 'utf-8'));
	
	$agent_summ = round($aSheet->getCell('F24')->getCalculatedValue(), 2);
	$agent_summ_nds = round($aSheet->getCell('F25')->getCalculatedValue(), 2);
	$aSheet->setCellValue('A28', mb_convert_encoding("2. Вознаграждение Агента составило ".$agent_summ." (  ) рублей, в том числе НДС 18% - ".$agent_summ_nds." руб.", 'utf-8', 'utf-8'));
	
	$aSheet->setCellValue('D4', mb_convert_encoding("По оказанным услугам за период ".$in_date." года по ".$out_date_old." года", 'utf-8', 'utf-8'));
	
	// $aSheet->setCellValue('A'.($currRow+1), mb_convert_encoding($i, 'utf-8', 'utf-8'));
	// $aSheet->setCellValue('A'.$currRow, mb_convert_encoding(array_sum($summ_tickets), 'utf-8', 'utf-8'));

?>