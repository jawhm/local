<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>店舗：会員情報－会員情報の削除（確認）</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
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
	$gmn_id = 'kaiin_del1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_kkn1.php');

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
	$select_kaiin_no = $_POST['select_kaiin_no'];	//会員番号
	
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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_kaiin_no == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_sakujyo_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');

		//ページ編集
		//固有引数の取得
		$kaiin_nm = $_POST['kaiin_nm'];					//会員名
		$kaiin_nm_k = $_POST['kaiin_nm_k'];				//会員名カナ

		$err_cnt = 0;
		$err_cd = 0;
		
		//予約数を確認する
		$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_ID = "' . sprintf("%07d",$select_kaiin_no) . '";';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
					
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			$row = mysql_fetch_array($result);
			if( $row[0] > 0 ){
				//予約があるので削除はできない
				$err_cd = 3;	//「入力された会員に予約情報が存在するため、削除できません。」
				$err_cnt++;
			}
		}


		if( $err_flg == 0 ){
			
			//明細データにエラーがあるか？
			if( $err_cnt == 0 ){
				//エラーなし
				
				print('<center>');
			
				//ページ編集
				print('<table bgcolor="lightblue"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kaiin_kaiinksn.png" border="0">');
				print('</td></tr></table>');
				
				//「以下のデータを削除します。よろしければ削除ボタンを押下してください。」
				print('<img src="./img_' . $lang_cd . '/title_del_kkn.png" border="0">');

				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td align="left">');	//main

				//会員番号・会員名
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0">&nbsp;&nbsp;<br>');
				print('<font size="2" color="blue">一般会員</font><font size="5" color="blue">&nbsp;' . sprintf("%05d",$select_kaiin_no) . '</font>');
				print('</td>');
				//会員名
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0">&nbsp;&nbsp;<br>');
				if( $kaiin_nm_k != '' ){
					print('<font size="2" color="blue">' . $kaiin_nm_k . '</font><br>');
				}
				print('<font size="5" color="blue">' . $kaiin_nm . '</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
								
				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
				
				//削除ボタン
				print('<table border="0">');
				print('<tr>');
				print('<td width="815">&nbsp;</td>');
				print('<form method="post" action="kaiin_del2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_nm_k" value="' . $kaiin_nm_k . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sakujyo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				//戻るボタン
				print('<table border="0">');
				print('<tr>');
				print('<td width="815">&nbsp;</td>');
				print('<form method="post" action="kaiin_kkn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="serch_flg" value="1">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				print('</center>');
				
				print('<hr>');


			}else if( $err_cnt > 0 ){
				//エラーがある場合
				
				print('<center>');
			
				//ページ編集
				print('<table bgcolor="lightblue"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kaiin_kaiinksn.png" border="0">');
				print('</td></tr></table>');
				
				//「エラーがあります。」
				print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0">');
				if( $err_cd == 3 ){
					print('<font color="red">※入力された会員に予約情報が存在するため、削除できません。</font><br>');
				}

				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td align="left">');	//main

				//会員番号・会員名
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0">&nbsp;&nbsp;<br>');
				print('<font size="6" color="blue">' . sprintf("%05d",$select_kaiin_no) . '</font>&nbsp;&nbsp;');
				print('</td>');
				//会員名
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0">&nbsp;&nbsp;<br>');
				if( $kaiin_nm_k != '' ){
					print('<font size="2" color="blue">' . $kaiin_nm_k . '</font><br>');
				}
				print('<font size="5" color="blue">' . $kaiin_nm . '</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
								
				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main

				print('<table border="0">');
				print('<tr>');
				print('<td width="815">&nbsp;</td>');
				print('<form method="post" action="kaiin_kkn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="serch_flg" value="1">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
				print('<td align="right">');
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				print('</center>');
				
				print('<hr>');

			}
		}
	}

	mysql_close( $link );
?>
</body>
</html>