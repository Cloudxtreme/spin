<?php

	$debug	=	true;

	require_once('FirePHPCore/FirePHP.class.php');
	$firephp = FirePHP::getInstance(true);
#	$firephp-> *
 
	require_once('FirePHPCore/fb.php');
#	FB:: *
 
	$firephp->setEnabled(false);  // or FB::
 
	FB::send(/* See fb() */);
	
	ob_start();
	
	// дамп любой переменной
	fb($debug);
	 
	// возможность вывода дополнительных системных сообщений
	FB::log( 'Log message' );
	FB::info( 'Info message' );
	FB::warn( 'Warn message' );
	FB::error( 'Error message' );
	
	ob_end_flush();
?>
