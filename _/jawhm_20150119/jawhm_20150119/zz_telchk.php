<?php
	//電話番号のチェック
	
	$telchk_rtncd = 0;
	$telchk_length = mb_strlen( $telchk_bf );
	if( $telchk_length == 0 ){
		//未入力エラー
		$telchk_rtncd = 1;
		
	}else{
		$telchk_idx = 0;
		$telchk_af = '';
		while( $telchk_idx < $telchk_length ){
			if( is_numeric( mb_substr( $telchk_bf , $telchk_idx , 1 ) ) ){
				$telchk_af .= mb_substr( $telchk_bf , $telchk_idx , 1 );
			}
			$telchk_idx++;
		}
		//数字が１０桁（固定電話）か１１桁（携帯電話）でチェックする
		if( strlen($telchk_af) == 10 ){
			//固定電話と判断
			if( substr($telchk_af,0,3) == '050' || substr($telchk_af,0,3) == '060' || substr($telchk_af,0,3) == '070' || substr($telchk_af,0,3) == '080' || substr($telchk_af,0,3) == '090' ){
				//携帯電話なのに１０桁しかないのでエラー
				$telchk_rtncd = 2;
			}
		}else if( strlen($telchk_af) == 11 ){
			//携帯電話と判断
			if( substr($telchk_af,0,3) != '050' && substr($telchk_af,0,3) != '060' && substr($telchk_af,0,3) != '070' && substr($telchk_af,0,3) != '080' && substr($telchk_af,0,3) != '090' ){
				//携帯電話なのに[050][060][070][080][090]で始まらないのでエラー
				$telchk_rtncd = 3;
			}
		}else{
			//10桁・11桁以外なのでエラー
			$telchk_rtncd = 4;
		}
	}
?>