<?php

	function russian_date() {
		$translation = array(
			"am" => "��",
			"pm" => "��",
			"AM" => "��",
			"PM" => "��",
			"Monday" => "�����������",
			"Mon" => "��",
			"Tuesday" => "�������",
			"Tue" => "��",
			"Wednesday" => "�����",
			"Wed" => "��",
			"Thursday" => "�������",
			"Thu" => "��",
			"Friday" => "�������",
			"Fri" => "��",
			"Saturday" => "�������",
			"Sat" => "��",
			"Sunday" => "�����������",
			"Sun" => "��",
			"January" => "������",
			"Jan" => "���",
			"February" => "�������",
			"Feb" => "���",
			"March" => "����",
			"Mar" => "���",
			"April" => "������",
			"Apr" => "���",
			"May" => "���",
			"May" => "���",
			"June" => "����",
			"Jun" => "����",
			"July" => "����",
			"Jul" => "����",
			"August" => "������",
			"Aug" => "���",
			"September" => "��������",
			"Sep" => "���",
			"October" => "�������",
			"Oct" => "���",
			"November" => "������",
			"Nov" => "���",
			"December" => "�������",
			"Dec" => "���",
			"st" => "��",
			"nd" => "��",
			"rd" => "�",
			"th" => "��",
		);
		
		if (func_num_args() > 1) {
			$timestamp = func_get_arg(1);
			return strtr(date(func_get_arg(0), $timestamp), $translation);
		} else {
			return strtr(date(func_get_arg(0)), $translation);
		};
	}	
	
	function russian_date_m() {
		$translation_m = array(
			"am" => "��",
			"pm" => "��",
			"AM" => "��",
			"PM" => "��",
			"Monday" => "�����������",
			"Mon" => "��",
			"Tuesday" => "�������",
			"Tue" => "��",
			"Wednesday" => "�����",
			"Wed" => "��",
			"Thursday" => "�������",
			"Thu" => "��",
			"Friday" => "�������",
			"Fri" => "��",
			"Saturday" => "�������",
			"Sat" => "��",
			"Sunday" => "�����������",
			"Sun" => "��",
			"January" => "������",
			"Jan" => "���",
			"February" => "�������",
			"Feb" => "���",
			"March" => "�����",
			"Mar" => "���",
			"April" => "������",
			"Apr" => "���",
			"May" => "���",
			"May" => "���",
			"June" => "����",
			"Jun" => "���",
			"July" => "����",
			"Jul" => "���",
			"August" => "�������",
			"Aug" => "���",
			"September" => "��������",
			"Sep" => "���",
			"October" => "�������",
			"Oct" => "���",
			"November" => "������",
			"Nov" => "���",
			"December" => "�������",
			"Dec" => "���",
			"st" => "��",
			"nd" => "��",
			"rd" => "�",
			"th" => "��",
		);
		
		if (func_num_args() > 1) {
			$timestamp = func_get_arg(1);
			return strtr(date(func_get_arg(0), $timestamp), $translation_m)." �.";
		} else {
			return strtr(date(func_get_arg(0)), $translation_m)." �.";
		};
	}
?>