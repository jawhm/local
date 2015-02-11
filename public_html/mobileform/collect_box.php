<?php

mb_language("Ja");
mb_internal_encoding("utf8");

	$list_param = array('IP', 'SID', 'N1', 'K1', 'FUKA','KAKUTEI', 'STORE', 'OKURL', 'RT', 'NAME1', 'NAME2', 'TEL', 'ADR1', 'ADR2', 'MAIL');
	
	if(isset($_POST['IP']))
	{	

		foreach($list_param as $param)
		{
			$$param = $_POST[$param];
			//echo $$param,'<br />';
		}
		echo 'OK<br />';
		echo $SID.'<br />';
		echo $K1.'<br />';
		echo 'r_code<br />';
		echo 'r_sequence<br />';
		echo $FUKA.'OK<br />';
		echo 'blank<br />';
	/*	
		echo 'NG ERROR<br />';
		echo $SID.'<br />';
		echo 'message<br />';
	*/
	}
?>
