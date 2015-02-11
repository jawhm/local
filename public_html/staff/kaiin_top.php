<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>会員情報　トップ</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<script type="text/javascript">
<!-- 
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
-->
</script>
<style type="text/css">
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kaiin_top.php';
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

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];
	$select_office_cd = $_POST['select_office_cd'];		//(未入力OK)

	if( $select_office_cd == "" ){
			//初期値設定（スタッフの所属するオフィスとする）
		$select_office_cd = $office_cd;
	}

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( './zs_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
				}else{
					//ログインチェック
					require( './zs_staff_loginchk.php' );	
					if ($LC_rtncd == 1){
						$err_flg = 9;
					}else{
						//ログイン時間更新
						require( './zs_staff_loginupd.php' );	
					}
				}
			}
		}
	}

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zs_errgmn.php' );

	//エラーなし
	}else{
	

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_kaiininfo_shinkikaiintrk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kaiininfo_kaiinsyoukai_2.png" width="0" height="0" style="visibility:hidden;">');
		

		//ページ編集
		print('<center>');
		
		print('<table border="0">');
		print('<tr>');
		print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kaiininfo_menu.png" border="0"></td>');
		print('</tr>');
		print('</table>');
		print('<table border="0">');
		print('<tr>');
		print('<td width="135" height="50" bgcolor="lightblue">');
		print('<form name="form1" method="post" action="kaiin_kkn0.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '" />');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kaiininfo_kaiinsyoukai_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kaiininfo_kaiinsyoukai_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kaiininfo_kaiinsyoukai_1.png\';" onClick="kurukuru()" border="0">');
		print('</form>');
		print('</td>');
		print('<td width="340" align="left" valign="top" background="./img_' . $lang_cd . '/bg_blue_340x50.png"><font size="2">お客様の情報を確認できます。</font></td>');
		
		//（ブランク）
		print('<td width="135">&nbsp;</td>');
		print('<td width="340">&nbsp;</td>');
		
		print('</tr>');
		print('</table>');
		
		print('<hr>');
		
		print('</center>');
		
		
	}

	mysql_close( $link );
?>
</body>
</html>