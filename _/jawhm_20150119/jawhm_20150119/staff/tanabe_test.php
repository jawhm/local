<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>田辺テスト</title>
<style type="text/css">
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
option.color0 {
	color:#696969;
}
option.color1 {
	color:#0000ff;
}
option.color2 {
	color:#ff0000;
}
</style>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'tanabe_test.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_trk0.php','kaiin_trk1.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	//祝日情報
	require_once('../jp-holiday.php');

	if( $now_youbi == 0 || $dt->is_jp_holiday == true ){
		//日曜・祝日
		$zs_youbi_color = 'red';
	}else if( $now_youbi == 6 ){
		//土曜
		$zs_youbi_color = 'blue';
	}else{
		//平日
		$zs_youbi_color = 'black';
	}

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zs_errgmn.php' );

	//エラーなし
	}else{
print('START[' . date( "Y-m-d H:i:s", time() ) . ']<br>');
		//正規メンバーの「電話番号」重複チェック
		// ＣＲＭに転送
		$data = array(
			 'pwd' => '303pittST'
			,'chk_mail' => 'test'
		);
				
		$url = 'http://192.168.11.101/crm/tanabe_chk_mail.php';
		$val = wbsRequest($url, $data);
		$ret = json_decode($val, true);
		if ($ret['result'] == 'OK')	{
print('<font color="blue">OK<br></font>');
		}else{
print('<font color="red">NG<br></font>');
		}

			
			
//		$i = 0;
//		while( $i < 100 ){
//			$tmp_data = $ret[$i];
//print('[' . $i . '] ' . $tmp_data . '<br>');
//			
//			$i++;
//		}
	}

	mysql_close( $link );

print('END[' . date( "Y-m-d H:i:s", time() ) . ']<br>');

	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}
	
?>
</body>
</html>
