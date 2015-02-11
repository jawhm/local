<?php	
	/******************************/
	/***      Cache  limiter  *****/
	
//	session_cache_limiter('private_no_expire'); 
	session_cache_limiter('nochashe'); 
	@session_start();

echo 'Start Card<br />';

		$url = 'https://digitalcheck.jp/settle/settle2/ubp25.dll';

echo 'Request to : '.$url.'<br />';

		// POST SEND
		$final_array = http_build_query($final_array);
		$opts = array( 'http' => array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded;charset=Shift_JIS',
			//'header'  => 'Content-type: text/plain;charset=Shift_JIS',
//			'content' => $final_array
			)
		);
		$context  = stream_context_create($opts);

		//get result
		$result = file_get_contents($url, false, $context);
echo '<hr/>';
		echo $result;
echo '<hr/>';
		
		//make visible what's between each data -> %0D%0A
		$encode_result= urlencode($result);
echo '<hr/>';
		echo '<p>'.$encode_result.'</p>';
echo '<hr/>';


echo 'Start Conv<br />';

		$url = 'https://digitalcheck.jp/settle/settle2/ubp3.dll';
echo 'Request to : '.$url.'<br />';

		// POST SEND
		$final_array = http_build_query($final_array);
		$opts = array( 'http' => array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded;charset=Shift_JIS',
			//'header'  => 'Content-type: text/plain;charset=Shift_JIS',
//			'content' => $final_array
			)
		);

		$context  = stream_context_create($opts);
		
		//get result
		$result = file_get_contents($url, false, $context);
echo '<hr/>';
		echo $result;
echo '<hr/>';
				
		//make visible what's between each data ->%0D%0A
		$encode_result=  urlencode($result);
echo '<hr/>';
		echo '<p>'.$encode_result.'</p>';
echo '<hr/>';

echo 'END<br />';

?>