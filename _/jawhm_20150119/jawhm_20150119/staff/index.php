<?php
$agent1 = $_SERVER['HTTP_USER_AGENT'];
$agent2 = $_SERVER['HTTP_X_UP_SUBNO'];

//サーバー接続
require( './zs_svconnect.php' );

if(preg_match("/^DoCoMo/i", $agent1)){
	//DoCoMoの場合
    header('Location: ' . $sv_staff_adr . 'mb/mb_index_d.php?m=D');

}elseif(preg_match('/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i', $agent1)){
	//SoftBankの場合
	$i = strpos( $agent1 , 'SN' );
	$SN_str = '';
	if( $i != 0 ){
		$SN_str = substr( $agent1 , $i , 17 );
	}
    header('Location: ' . $sv_staff_adr . 'mb/mb_index_s.php?m=S&s=' . $SN_str );

}elseif(preg_match("/^KDDI\-/i", $agent1) || preg_match("/UP\.Browser/i", $agent1)){
	
	if( $agent2 != ''){
		$SN_str = substr( $agent2 , 0 , 14 );
	}
	
	//auの場合
    header('Location: ' . $sv_staff_adr . 'mb/mb_index_a.php?m=A&s=' . $SN_str );

}else{
	//PCの場合
	header('Location: ' . $sv_staff_adr . 'index_p.php');

}
?>