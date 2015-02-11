<?php
	//function footerdisplay
	function footer()
	{
		$footer='<div id="footer-jquerymobile-registration" data-role="footer" data-position="fixed">
				<h4>Copyright© JAPAN Association for Working Holiday Makers All right reserved.</h4>
				</div>';
		
		return $footer;
	}
	
	//function display array for debugging
	function debug_array($tab, $recursif=0)
	{
	   $buffer = '';
	   if (empty($recursif))
				$buffer .= '<div style="padding:10px 0; margin:10px 0; border:1px solid #000000; border-left:0; border-right:0;">';
	   foreach($tab as $cle => $val)
	   {
				$buffer .= '<div>|&mdash;&nbsp;<strong>'.$cle.'</strong>';
				if (!is_array($val))
						  $buffer .= ' = '.$val;
				else
				{
						  $buffer .= '<div style="padding-left:20px;">';
						  $buffer .= debug_array($val, 1);
				}
				$buffer .= '</div>';
	   }        
	   $buffer .= '</div>';
	   return $buffer;
	}
	
	function trimspace($str)	
	{
	$data = $str;
	$data = mb_ereg_replace(" ","",$data);
	$data = mb_ereg_replace("　","",$data);
	$data = mb_convert_kana($data, "AK");
	return $data;
	}


	//random number
	function getRandomString($nLengthRequired = 8)
	{
		$sCharList = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		mt_srand();
		$sRes = "";
		for($i = 0; $i < $nLengthRequired; $i++)
			$sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
		return $sRes;
	}

	//---------------------------------------------------
	//Connexion to database
	//---------------------------------------------------
	function connexion_database ()
	{
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		
		return $db;
	}


	//---------------------------------------------------
	//Function to secure form and url 
	//---------------------------------------------------
	function secure($variable)
	{
		$variable = htmlentities(trim($variable));
		$variable = stripslashes(stripslashes($variable));
		return $variable;
	}

?>