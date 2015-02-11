<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>会員情報－会員の確認</title>
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
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kaiin_kkn0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_top.php','kaiin_kkn0.php','kaiin_kkn1.php','kaiin_del2.php');

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

		//ページ編集
		//初期値セット
		$select_kaiin_no = '';		//会員番号
		$select_kaiin_nm = '';		//会員名
		$select_kaiin_mail = '';	//会員メールアドレス
		$select_kaiin_tel = '';		//会員電話番号

		if( $prc_gmn == 'kaiin_kkn1.php' || $prc_gmn == 'kaiin_del2.php' ){
			$serch_flg = $_POST['serch_flg'];					//検索フラグ　1:会員番号,2:会員名,3:会員メールアドレス,4:会員電話番号
			$select_kaiin_no = $_POST['select_kaiin_no'];		//会員番号
			$select_kaiin_nm = $_POST['select_kaiin_nm'];		//会員名
			$select_kaiin_mail = $_POST['select_kaiin_mail'];	//会員メールアドレス
			$select_kaiin_tel = $_POST['select_kaiin_tel'];		//会員電話番号
		}

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns1_kaiinno_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns2_kaiinnm_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns3_mail_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns4_kaiintel_2.png" width="0" height="0" style="visibility:hidden;">');

		print('<center>');
		
		//ページ編集
		print('<table bgcolor="lightblue"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kaiinsyoukai.png" border="0">');
		print('</td></tr></table>');

		//「予約するメンバー（会員）の検索条件を入力し、検索します」
		print('<img src="./img_' . $lang_cd . '/title_member_serch.png" border="0">');

		print('<table border="0">');
		print('<tr>');
		print('<td width="750" align="left">');

		//会員番号のテーブル
		print('<table border="0">');
		print('<tr>');
		print('<form method="post" action="kaiin_kkn1.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
		print('<input type="hidden" name="serch_flg" value="1">');
		print('<td align="left" valign="top">');
		print('<img src="./img_' . $lang_cd . '/title_kns1_kaiinno.png" border="0"><br>');
		print('<table boeder="0">');
		print('<tr>');
		print('<td align="left" valign="bottom">');
		$tabindex++;
		print('<input type="text" name="select_kaiin_no" maxlength="10" size="10" value="' . $select_kaiin_no . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; text-align: right; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
		print('</td>');
		print('<td align="left" valign="middle">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns1_kaiinno_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns1_kaiinno_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns1_kaiinno_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
			
		//会員名のテーブル
		print('<table border="0">');
		print('<tr>');
		print('<form method="post" action="kaiin_kkn1.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
		print('<input type="hidden" name="serch_flg" value="2">');
		print('<td align="left">');
		print('<img src="./img_' . $lang_cd . '/title_kns2_kaiinnm.png" border="0"><br>');
		print('<table boeder="0">');
		print('<tr>');
		print('<td align="left" valign="bottom">');
		$tabindex++;
		print('<input type="text" name="select_kaiin_nm" maxlength="40" size="16" value="' . $select_kaiin_nm . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
		print('</td>');
		print('<td align="left" valign="middle">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns2_kaiinnm_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns2_kaiinnm_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns2_kaiinnm_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
			
		//メールアドレスのテーブル
		print('<table border="0">');
		print('<tr>');
		print('<form method="post" action="kaiin_kkn1.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
		print('<input type="hidden" name="serch_flg" value="3">');
		print('<td align="left">');
		print('<img src="./img_' . $lang_cd . '/title_kns3_mail.png" border="0"><br>');
		print('<table boeder="0">');
		print('<tr>');
		print('<td align="left" valign="bottom">');
		$tabindex++;
		print('<input type="text" name="select_kaiin_mail" maxlength="40" size="30" value="' . $select_kaiin_mail . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
		print('</td>');
		print('<td align="left" valign="middle">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns3_mail_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns3_mail_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns3_mail_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
	
		//電話番号のテーブル
		print('<table border="0">');
		print('<tr>');
		print('<form method="post" action="kaiin_kkn1.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
		print('<input type="hidden" name="serch_flg" value="4">');
		print('<td align="left">');
		print('<img src="./img_' . $lang_cd . '/title_kns4_kaiintel.png" border="0"><br>');
		print('<table boeder="0">');
		print('<tr>');
		print('<td align="left" valign="bottom">');
		$tabindex++;
		print('<input type="text" name="select_kaiin_tel" maxlength="15" size="15" value="' . $select_kaiin_tel . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
		print('</td>');
		print('<td align="left" valign="middle">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns4_kaiintel_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns4_kaiintel_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns4_kaiintel_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');

		print('</td>');
		print('</tr>');
		print('</table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="left">&nbsp;</td>');
		print('<form method="post" action="kaiin_top.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
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
