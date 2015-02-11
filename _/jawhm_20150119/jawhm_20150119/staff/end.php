<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow" />
<title>ログアウト</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
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
<SCRIPT type="text/javascript" language="JavaScript"> 
<!--
function winclose(){
	//「閉じようとしています」を表示させないため（２行追加）
　　var w=window.open("","_top");
　　w.opener=window;

	window.close(); // サブウィンドウを閉じる
}
//ローディングくるくる
function kurukuru(){
	jQuery(function($){
		$.fixedActivity(true)
	});
//	jQuery(function($){
//		$.fixedActivity(false)
//	});
}
jQuery(function($){
	$.fixedActivity = function(show){
		var o = $.fixedActivity;
		var body = $('body'),win = $(window);

		//ローディング中画面を透過にさせるラッパー要素
		if(!o.pageWrapper){
			o.pageWrapper = body.wrapInner('<div/>').find('> div').eq(0);
		}

		//アイコン表示
		body.activity(show);

		//表示位置を画面中央に設定
		if(show){
			//IE8以下だとshape、モダンブラウザだとdivになる
			var icon = body.find('> *').eq(0);
			icon.css({
				margin :0,
				position:'fixed',
				top:(win.height() - icon.height()) / 2,
				left:(win.width() - icon.width()) / 2
			});
		}

		//画面透過の切り替え
		o.pageWrapper.css({opacity: show ? .3 : 1});
	}
});
// -->
</script>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'end.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	require( './zs_array_all.php' );
	
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

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];

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
		
		//セッションクローズ
		session_name(JAWHM_Web_System);
		session_start();
		$_SESSION = array();	//すべてのセッション変数を初期化
		session_destroy();		//セッションを破棄
		
		
		//文字コード設定（insert/update時に必須）
		require( '../zz_mojicd.php' );

		//ログイン情報の更新
		$query = 'update D_STAFF_LOGIN set LOGIN_FLG = 0 where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
print('chk!<br>');
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'スタッフログイン情報の更新に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{

			//**トランザクション出力**
			$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'ログアウトしました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

			//**ログ出力**
			$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'ログアウトしました。';	//内容
			$log_err_inf = '';			//エラー情報
			require( './zs_log.php' );
			//************

			//画面編集
			print('<center>');
				
			print('<table border="0">');
			print('<tr>');
			print('<td width="370" align="center" valign="middle">');
			print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
			print('</td>');
			print('<td width="265" align="left" valign="top">');
			print('&nbsp;');
			print('</td>');
			print('<td width="180" align="left">');
			print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
			print('</td>');
			print('<td width="135" align="center" valign="middle">');
			//閉じるボタン
			print('&nbsp;');
			//$tabindex++;
//			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_tojiru2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_tojiru2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_tojiru2_1.png\';" onClick=winclose() border="0">');
			
			//print('<input type="button" name="button" style="WIDTH: 100px; HEIGHT: 50px;" value="閉じる" onClick=winclose() />');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<hr>');
				
			print('<br>');
			//「ログアウトしました。」
			print('<img src="./img_' . $lang_cd . '/title_logout_mes.png" border="0"><br><br>');
				
			print('<form name="form1" method="post" action="' . $sv_https_adr . 'staff/index.php">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" onClick="kurukuru()" border="0">');
			print('</form>');
				
			print('<br><br>');
				
			print('</center>');
				
			print('<hr>');
		
		}
	}
  
	mysql_close( $link );
?>
</body>
</html>