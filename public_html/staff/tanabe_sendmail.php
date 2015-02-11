<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>テストメール送信</title>
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
	$gmn_id = 'tanabe_sendmail.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array($gmn_id);

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

	//引数の入力
	$prc_gmn = $gmn_id;
	$lang_cd = 'J';
	$office_cd = 'tokyo';
	$staff_cd = 'zz_tanabe';

	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//画面ＩＤのチェック
		if( !in_array($prc_gmn , $ok_gmn) ){
			$err_flg = 2;
		}else{
			//引数入力チェック
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" ){
				$err_flg = 3;
			}
		}
	}

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zs_errgmn.php' );

	//エラーなし
	}else{
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');


		//メール送信
		$send_mail_flg = 0;
				
		//登録完了メール送信
		//送信元
		$from_nm = 'ワーキングホリデー協会';
		$from_mail = 'mailsystem_alldata@jawhm.or.jp';
		//宛て先
		$to_nm = 'テストユーザー 様';
		$to_mail = 'tanabe@axd.co.jp';

		$sv_bcc_mailadr = "";
	
		//タイトル
		$subject = '(JAWHM)テストメールです';
	
		// 本文
		$content = "テストユーザー 様\n\n";
		$content .= "日本ワーキングホリデー協会です。\n\n";
		$content .= "本メールはテストメールです。削除していただいて結構です。\n";
				   
		//メール送信
		mb_language("Ja");				//使用言語：Ja
		mb_internal_encoding("utf-8");	//文字コード：UTF-8
		$frname0 = mb_encode_mimeheader($from_nm);
		$toname0 = mb_encode_mimeheader($to_nm);
		$sdmail0 = "$toname0 <$to_mail>";
		$mailhead = "From:\"$frname0\" <$from_mail>\n";
		if( $sv_bcc_mailadr != "" ){
			$mailhead .= "Bcc: $sv_bcc_mailadr";
		}
		$result = mb_send_mail( $sdmail0, $subject, $content, $mailhead );
	
		$send_mail_flg = 1;

		//画面編集
		print('<font color="blue">メール送信しました。(' . date( "Y-m-d H:i:s", time() ). ')<br>');
		
		

	}

	mysql_close( $link );


?>
</body>
</html>