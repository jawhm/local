<?php
	//*** ユーザーエージェントチェック ***
	// zm_uachk.php
	//
	//返却変数
	// $mobile_kbn	:A:Android(mb) B:Android(tab) I:iPhone J:iPad D:DoCoMo(mb) U:au(mb) S:Softbank(mb) W:WILLCOM M:Macintosh P:PC
	//
	// $SN_str      :SoftBank(mb)のシリアルナンバー(17桁) , au(mb)のシリアルナンバー(14桁）

	//エージェントを求め、接続端末を判別する
	$mobile_kbn = 'P';	//A:Android(mb) B:Android(tab) I:iPhone J:iPad D:DoCoMo(mb) U:au(mb) S:Softbank(mb) W:WILLCOM M:Macintosh P:PC
	$agent1 = $_SERVER['HTTP_USER_AGENT'];
	$agent2 = $_SERVER['HTTP_X_UP_SUBNO'];
	$ip_adr = $_SERVER["REMOTE_ADDR"];
	
	if( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android') ){
		//B:Android(tab)
		$mobile_kbn = "B";
		if( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile') ){
			//A:Android(mb)
			$mobile_kbn = "A";
		}
	}
	
	if( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone') ){
		//I:iPhone
		$mobile_kbn = "I";
	}

	if( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad') ){
		//J:iPad
		$mobile_kbn = "J";
	}
		
	if( preg_match("/^DoCoMo/i", $agent1) ){
		//D:DoCoMo(mb)
		$mobile_kbn = "D";
	}
	
	if( preg_match('/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i', $agent1) ){
		//S:Softbank(mb)
		$mobile_kbn = "S";
		$uachk_idx = strpos( $agent1 , 'SN' );
		$SN_str = '';
		if( $uachk_idx != 0 ){
			$SN_str = substr( $agent1 , $uachk_idx , 17 );
		}
	}

	if( preg_match("/^KDDI\-/i", $agent1) || preg_match("/UP\.Browser/i", $agent1) ){
		//U:au(mb)
		$mobile_kbn = "U";
		if( $agent2 != ''){
			$SN_str = substr( $agent2 , 0 , 14 );
		}
	}
	
	if( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Willcom') ){
		//W:WILLCOM
		$mobile_kbn = "W";
	}

	if( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Macintosh') ){
		//M:Macintosh
		$mobile_kbn = "M";
	}

	
	
?>