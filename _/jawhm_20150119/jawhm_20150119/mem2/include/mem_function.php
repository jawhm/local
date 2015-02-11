<?php
	
	function trimspace($str)	
	{
	$data = $str;
	$data = mb_ereg_replace(" ","",$data);
	$data = mb_ereg_replace("　","",$data);
	$data = mb_convert_kana($data, "AK");
	return $data;
	}

	//------------------------------------------------
	//Random number
	//------------------------------------------------
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

?>