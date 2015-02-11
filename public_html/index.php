<?php
	@session_start();

	require_once 'include/header.php';

	if(isset($_POST['pc']))
		 $_SESSION['pc'] = $_POST['pc'];
	
	function is_mobile () 
	{
		$useragents = array(
			'iPhone',         // Apple iPhone
			'iPod',           // Apple iPod touch
			'iPad',           // Apple iPad touch
			'Android',        // 1.5+ Android
			'dream',          // Pre 1.5 Android
			'CUPCAKE',        // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS',          // Palm Pre Experimental
			'incognito',      // Other iPhone browser
			'webmate'         // Other iPhone browser
		);
		
		$pattern = '/'.implode('|', $useragents).'/i';
		return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}

	$header_obj = new Header();
	if ($header_obj->computer_use() === false && $_SESSION['pc'] != 'on')
		include('m-index2.php') ;
	else
		include('index.html') ;

?>