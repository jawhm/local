<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>その他－連絡事項更新</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
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
	$gmn_id = 'sonota_ren_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('sonota_top.php','sonota_ren_trk.php');

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
	$select_office_cd = $_POST['select_office_cd'];

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
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');

		//オフィス連絡事項情報の読み込み
		$query = 'select DECODE(RENRAKUJIKOU,"' . $ANGpw . '"),UPDATE_TIME,UPDATE_STAFF_CD' .
		         ' from D_OFFICE_RENRAKU where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$renrakujikou = '';		//連絡事項
			$update_time = '';		//更新日時
			$update_staff_cd = '';	//更新スタッフコード

			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '連絡事項情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$renrakujikou = $row[0];
			$update_time = $row[1];
			$update_staff_cd = $row[2];

			$update_staff_nm = '';
			if( $update_staff_cd != '' ){
				$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' .
							$office_cd . '" and STAFF_CD = "' . $update_staff_cd . '";';
				$result = mysql_query($query);
				if (!$result) {
					//参照失敗
					//なにもしない

					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************

				}else{
					while( $row = mysql_fetch_array($result) ){
						//データの格納
						$update_staff_nm = $row[0];		//更新スタッフ名
					}
				}
			}
		}

		//画面編集
		
		print('<center>');

		//ページ編集
		print('<table border="0">');
		print('<tr>');
		print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_sonota_renrakujikouksn.png" border="0"></td>');
		print('</tr>');
		print('</table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm.png"><br><font size="5" color="blue">' . $office_nm . '</font></td>');
		print('<form method="post" action="sonota_top.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '" />');
		print('<td align="right">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');

		print('<hr>');

		print('<form method="post" action="sonota_ren_trk.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '" />');

		print('<table border="0">');
		print('<tr>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_rnrjk.png" border="0"></td>');
		print('<td align="right">');
		if( $update_time != '' ){
			print('<font size="2">（前回更新者：&nbsp;' . $update_staff_nm . '&nbsp;&nbsp;' . $update_time .'&nbsp;）</font>');
		}else{
			print('<font size="2" color="white">（未登録）</font>');
		}
		print('</td>');
		print('</tr>');
		print('<tr>');
		print('<td colspan="2">');
		//連絡事項
		print('<textarea name="renrakujikou" rows="20" cols="90" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $renrakujikou . '</textarea>');
		print('</td>');
		print('</tr>');
		print('</table>');
		
		print('<table border="0">');
		//登録ボタン
		print('<tr>');
		print('<td width="815" align="left">&nbsp;</td>');
		print('<td align="right">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
		print('</form>');
		print('</td>');
		print('</tr>');
		//戻るボタン
		print('<tr>');
		print('<td width="815" align="left">&nbsp;</td>');
		print('<form method="post" action="sonota_top.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '" />');
		print('<td align="right">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
		
		print('</center>');
		
		print('<hr>');
	
	}

	mysql_close( $link );
?>
</body>
</html>
