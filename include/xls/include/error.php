<?php

	/** Error reporting */

	// function debug
	
	function debug($debug){
		if ($debug) {
			error_reporting(E_ALL | E_STRICT | E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			
			if (ini_get('display_errors') != 1) {
				ini_set('display_errors', 1);
			}
			global $degub_flag;
			$degub_flag	=	true;
		} else {
			error_reporting(0);
			ini_set('display_errors', 0);
			global $degub_flag;
			$degub_flag	=	false;
		}
	}
?>
