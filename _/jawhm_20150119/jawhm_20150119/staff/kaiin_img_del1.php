<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>会員情報－写真削除</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
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
</SCRIPT> 
</head>

<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kaiin_img_del1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_img_ksn1.php');

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
	$select_kaiin_no = $_POST['select_kaiin_no'];
	$select_kaiin_nm = $_POST['select_kaiin_nm'];
	$select_kaiin_nm_k = $_POST['select_kaiin_nm_k'];
	$select_kaiin_mixi = $_POST['select_kaiin_mixi'];

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
		print('<img src="./img_' . $lang_cd . '/btn_fhoto_del_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_syashin_up_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		
		
		if( $err_flg == 0 ){
			
			//***画面編集****************************************************************************************************
					
			print('<center>');

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td align="left" width="950">');	//main

			//会員番号・会員名
			print('<table border="0">');
			print('<tr>');
			//会員番号
			print('<td width="150" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_okyakusamano.png" border="0"><br>');
			print('<font size="5" color="blue">' . $select_kaiin_no . '</font>');
			if( $select_kaiin_mixi != "" ){
				//メンバー
				print('<br><font size="2">(' . $select_kaiin_mixi . ')</font>');
			}else{
				//一般（無料メンバー）
				print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
			}
			print('</td>');
			//会員名
			print('<td width="480" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_shimei.png" border="0"><br>');
			if( $select_kaiin_nm_k != '' && $select_kaiin_nm_k != '　' ){
				print('&nbsp;&nbsp;<font size="2" color="blue">' . $select_kaiin_nm_k . '</font><br>');
			}
			print('&nbsp;&nbsp;<font size="5" color="blue">' . $select_kaiin_nm . '</font>');						
			print('</td>');
			print('</tr>');	
			print('</table>');

			print('</td>');	//main
			print('</tr>');	//main
			print('<tr>');	//main
			print('<td align="center">');	//main

			//「写真を削除しますがよろしいですか？」
			print('<img src="./img_' . $lang_cd . '/title_fhoto_del_kkn.png" border="0"><br>');

			print('<table border="0">');	//sub1
			print('<tr>');	//sub1
			//会員写真
			print('<td align="center" valign="top" width="350">');	//sub1
			//「現在登録されている写真」
			print('<img src="./img_' . $lang_cd . '/title_now_fhoto.png" border="0"><br>');

			$kaiin_img = './' . $dir_kaiin_img . '/' . $select_kaiin_no . '.jpeg';	//会員顔写真
			if( file_exists($kaiin_img) ) {
				//写真が見つかった
				$imglist = getimagesize( $kaiin_img );
				$img_width = $imglist[0];
				$img_height = $imglist[1];
				$img_type = $imglist[2];
				$edit_size = $imglist[3];
				if( $img_width > 320 && $img_height > 320 ){
					if( $img_width > $img_height ){
						$edit_size = 'width="320"';
					}else{
						$edit_size = 'height="320"';
					}
				}else if( $img_width > 320 && $img_height <= 320 ){
					$edit_size = 'width="320"';
				}else if( $img_width <= 320 && $img_height > 320 ){
					$edit_size = 'height="320"';
				}
				
				$kaiin_img .= '?' . $now_time;	//キャッシュ画像を表示させないため
				print('<img src=' . $kaiin_img . ' ' . $edit_size . '>');
			
			}else{
				//写真が見つからない
				print('<img src="./img_' . $lang_cd . '/kaiin_img_nothing_320x240.png" border="0">');
			}
			
			print('</td>');	//sub1
			print('<td align="center" valign="middle" width="210">');	//sub1

			//写真削除ボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="60" align="center" valign="middle">');
			//「→」
			print('<img src="./img_' . $lang_cd . '/yajirushi_right.png" border="0">');
			print('</td>');
			print('<form enctype="multipart/form-data" action="kaiin_img_del2.php" method="POST">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
			print('<input type="hidden" name="select_kaiin_nm_k" value="' . $select_kaiin_nm_k . '">');
			print('<input type="hidden" name="select_kaiin_mixi" value="' . $select_kaiin_mixi . '">');
			print('<td width="150" align="left" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_fhoto_del_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_fhoto_del_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_fhoto_del_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('</td>');	//sub1
			print('</tr>');	//sub1
			print('</table>');	//sub1

			print('</td>');		//main
			print('</tr>');		//main
			print('</table>');	//main

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">');
			print('&nbsp;');
			print('</td>');
			print('<form method="post" action="./kaiin_kkn1.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="serch_flg" value="1">');
			print('<input type="hidden" name="lock_kaijyo_flg" value="0">');
			print('<input type="hidden" name="syosai_flg" value="0">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
			print('<input type="hidden" name="select_kaiin_mail" value="">');
			print('<input type="hidden" name="select_kaiin_tel" value="">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
				
			print('</center>');
				
			print('<hr>');


		}else{
			//エラーあり
			
			//処理なし
			
		}
	}

	mysql_close( $link );

?>

</body>
</html>
