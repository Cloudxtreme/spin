<?php
	global $log_file;
	
	if (isset($result)) {
		//mssql_free_result($result);
	}
	
	mssql_close($ms_link);
	
	// require_once("footer.php");
	
	// создаем объект класса-писателя
	// include("PHPExcel/Writer/Excel5.php");
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	
	if (!$debug_flag) {
		// выводим заголовки
		$cur_date = date("H:i:s")."-".date("d.m.Y");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$cur_date.'.xls"');
		header('Cache-Control: max-age=0');
		// передаём браузеру файл таблицы с бланком
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	//fclose($log_file);
?>