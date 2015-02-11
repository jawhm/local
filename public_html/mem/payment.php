<?php	
	/******************************/
	/***      Cache  limiter  *****/
	
	session_cache_limiter('private_no_expire'); 
	@session_start();


	/******************************/
	/*    Payment by card         */
	/******************************/
			
	if(isset($_POST['form']) && $_POST['form']=='card' ):		
		$ok_url_payment 	= 'http://www.jawhm.or.jp/mem/payment.php';
		$wrong_url_payment	= 'http://www.jawhm.or.jp/mem/payment.php';

		//create array with list of parameter
		$list_param = array('IP', 'SID', 'N1', 'K1', 'FUKA','KAKUTEI', 'STORE', 'OKURL', 'RT', 'NAME1', 'NAME2', 'TEL', 'ADR1', 'ADR2', 'MAIL');

		//===================================
		//gather all information in an array
		//==================================

		foreach($list_param as $param)
		{
			$$param = $_POST[$param];
			$final_array[$param] = $$param;
		}
		
		//display debug array
		//echo debug_array($final_array);
		
		$url = 'https://www.digitalcheck.jp/settle/settle2/ubp25.dll';
	
		
		// POST SEND
		$final_array = http_build_query($final_array);
		$opts = array( 'http' => array(
										'method'  => 'POST',
										'header'  => 'Content-type: application/x-www-form-urlencoded;charset=Shift_JIS',
										//'header'  => 'Content-type: text/plain;charset=Shift_JIS',
										'content' => $final_array
										)
						);
		$context  = stream_context_create($opts);
		
		//get result
		$result = file_get_contents($url, false, $context);
		//echo $result;
		
		//make visible what's between each data -> %0D%0A
		$encode_result= urlencode($result);
		//echo '<p>'.$encode_result.'</p>';
		
		//treat result
		list($return_state) = split('%0D%0A', $encode_result);
		//echo '<p>$return_state= '.$return_state.'</p>';
				
		//check if correct
		if($return_state == 'OK') :
			//echo 'IN';
			list($card_process, $sid, $k1, $request_code, $resquest_sequence, $fuka, $blank) = split('%0D%0A', $encode_result);
			//echo $cb_process.' - '.$sid.' - '.$k1.' - '.$request_code.' - '.$resquest_sequence.' - '.$fuka.' - '.$blank;
			
			//create Session to keep data in case of error
			$_SESSION['request_code'] = $request_code; 
			$_SESSION['resquest_sequence'] = $resquest_sequence;
			
		elseif($return_state == 'PRERROR' || $return_state == 'ERROR' ):
			//echo 'OUT';
			echo $result;
		endif;
		
	endif;
	
	/******************************/
	/*    Payment by conbini      */
	/******************************/
	
	
	if(isset($_POST['form']) && $_POST['form']=='conv'):
	
		//create array with list of parameter
		$list_param = array('IP', 'SID', 'N1', 'K1', 'FUKA', 'STORE', 'TAX', 'NAME1', 'NAME2', 'TEL', 'ADR1', 'ADR2', 'MAIL');
		
		//===================================
		//gather all information in an array
		//==================================

		foreach($list_param as $param)
		{
			$$param = $_POST[$param];
			$final_array[$param] = mb_convert_encoding($$param, "SJIS", "UTF-8");
		}
		
		//Check if the user hase chosen a convenience store
		if(!empty($STORE)):
		
			//display debug array
			//echo debug_array($final_array);
			
			$url = 'https://www.digitalcheck.jp/settle/settle2/ubp3.dll';
		
			
			// POST SEND
			$final_array = http_build_query($final_array);
			$opts = array( 'http' => array(
											'method'  => 'POST',
											'header'  => 'Content-type: application/x-www-form-urlencoded;charset=Shift_JIS',
											//'header'  => 'Content-type: text/plain;charset=Shift_JIS',
											'content' => $final_array
											)
							);
			$context  = stream_context_create($opts);
			
			//get result
			$result = file_get_contents($url, false, $context);
			//echo $result;
					
			//make visible what's between each data ->%0D%0A
			$encode_result=  urlencode($result);
			//echo '<p>'.$encode_result.'</p>';
			
			//treat result
			list($return_state) = split('%0D%0A', $encode_result);
			//echo '<p>$return_state= '.$return_state.'</p>';
			
			//check if correct
			if($return_state == 'OK') :
				//echo 'IN';
				list($conbini_process, $sid, $k1, $payment_number, $date_of_use, $fuka, $url) = split('%0D%0A', $encode_result);
				//echo $conbini_process.' - '.$sid.' - '.$k1.' - '.$payment_number.' - '.$date_of_use.' - '.$fuka.' - '.urldecode($url);
							
			elseif($return_state == 'PRERROR' || $return_state == 'ERROR' ):
				//echo 'OUT';
				//echo $result;
			endif;
			
		else:
			$conbini_store = 'empty';

		endif;
			
	endif;	
	
	/************************/
	


	//from email
	if(isset($_GET['email']))
	{
		//for mobile
			$mobile_email = $_GET['email'];
			$mobile_userid = $_GET['userid'];
			
			//redirection for mobile
			$redirection='../mobileform/member_form.php?return=step4&id='.$mobile_userid.'&email='.$mobile_email;
			
			require 'memberscript.php';
	}
	else
	{
		require 'memberscript.php';
	}
?>