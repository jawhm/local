<?php

ini_set( "display_errors", "On");


// Thanks to BraveNewCode's WPtouch iPhone Theme for the UA list.
// (http://wordpress.org/extend/plugins/wptouch/)
function is_mobile () {
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


	if (is_mobile())	{
		header("Location: /seminar/ser");
	}else{
		header("Location: /seminar/seminar");
	}

	exit;

?>