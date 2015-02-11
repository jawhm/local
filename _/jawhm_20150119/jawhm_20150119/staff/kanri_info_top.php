<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－管理情報</title>
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
	$gmn_id = 'kanri_info_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php');

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
	mb_internal_encoding("utf-8");

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


		//現在登録されているオフィス数を求める
		$query = 'select count(*) from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '";';
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
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			$row = mysql_fetch_array($result);
			$Moffice_cnt = $row[0];	//オフィス数
		
		}
		
		//管理情報の取得
		$err_cnt = 0;
		
		$query = 'select A.MEISHOU,A.RYAKUSHOU,DECODE(A.HP_ADR,"' . $ANGpw . '"),DECODE(A.SEND_MAIL_ADR,"' . $ANGpw . '"),';
		$query .= 'DECODE(A.TENSOU_MAIL_ADR,"' . $ANGpw . '"),A.DAIHYO_OFFICE_CD,';
		$query .= 'A.SYSTEM_KADO_FLG,A.UPDATE_TIME,A.UPDATE_STAFF_CD,';
		$query .= 'DECODE(A.UPDATE_CMT,"' . $ANGpw . '"),B.OFFICE_NM from M_KANRI_INFO A,M_OFFICE B ';
		$query .= 'where A.KG_CD = "' . $DEF_kg_cd . '" and A.KG_CD = B.KG_CD and A.DAIHYO_OFFICE_CD = B.OFFICE_CD order by A.IDX desc;';
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
			$log_naiyou = '管理情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$Minfo_meishou = $row[0];			//名称
			$Minfo_ryakushou = $row[1];			//略称
			$Minfo_hp_adr = $row[2];			//ホームページアドレス
			$Minfo_send_mail_adr = $row[3];		//送信メールアドレス
			$Minfo_tensou_mail_adr = $row[4];	//転送先メールアドレス
			$Minfo_office_cd = $row[5];			//代表オフィスコード
			$Minfo_kado_flg = $row[6];			//システム稼動フラグ　0:稼動中　1:強制停止中
			$Minfo_update_time = $row[7];		//更新日時
			$Minfo_update_staff_cd = $row[8];	//更新スタッフコード
			$Minfo_update_cmt = $row[9];		//更新コメント
			$Minfo_office_nm = $row[10];		//代表オフィス名

		}
		
		//ページ編集
		print('<center>');
		
		print('<table bgcolor="pink"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kanri_kanriinfo.png" border="0">');
		print('</td></tr></table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="center"><font color="blue">※以下の内容で登録されています。</font></td>');
		print('<form method="post" action="kanri_top.php">');
		print('<td align="right">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
		
		print('<table border="0">');
		print('<tr>');
		print('<td align="left">');
		
		//名称・略称
		print('<table border="0">');
		print('<tr>');
		//print('<td><b>名称</b></td>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_soshikimei.png"></td>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_ryakusyou.png"></td>');
		print('</tr>');
		print('<tr>');
		print('<td>');
		if( $Minfo_meishou != "" ){
			print('<font size="5" color="blue">' . $Minfo_meishou . '&nbsp;&nbsp;</font>');
		}else{
			print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
		}
		print('</td>');
		print('<td>');
		if( $Minfo_ryakushou != "" ){
			print('<font size="5" color="blue">' . $Minfo_ryakushou . '&nbsp;&nbsp;</font>');
		}else{
			print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
		}
		print('</td>');
		print('</tr>');
		print('</table>');
		
		//ホームページアドレス
		print('<table border="0">');
		print('<tr>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_homepageaddress.png"></td>');
		print('</tr>');
		print('<tr>');
		print('<td>');
		if( $Minfo_hp_adr != "" ){
			print('<font size="5" color="blue">' . $Minfo_hp_adr . '</font>');
		}else{
			print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
		}
		print('</td>');
		print('</tr>');
		print('</table>');

		//送信メールアドレス
		print('<table border="0">');
		print('<tr>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_sendmailaddress.png"></td>');
		print('</tr>');
		print('<tr>');
		print('<td>');
		if( $Minfo_send_mail_adr != "" ){
			print('<font size="5" color="blue">' . $Minfo_send_mail_adr . '</font>');
		}else{
			print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
		}
		print('</td>');
		print('</tr>');
		print('</table>');

		//転送先メールアドレス
		print('<table border="0">');
		print('<tr>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_tensoumailaddress.png"></td>');
		print('</tr>');
		print('<tr>');
		print('<td>');
		if( $Minfo_tensou_mail_adr != "" ){
			print('<font size="5" color="blue">' . $Minfo_tensou_mail_adr . '</font>');
		}else{
			print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
		}
		print('</td>');
		print('</tr>');
		print('</table>');

		//代表店舗コード
		print('<table border="0">');
		print('<tr>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_daihyouofficecd.png"></td>');
		print('<td align="left"><img src="./img_' . $lang_cd . '/title_trkofficesu.png"></td>');
		print('</tr>');
		print('<tr>');
		print('<td align="left" valign="top">');
		if( $Minfo_office_cd != "" ){
			print('<font size="5" color="blue">' . $Minfo_office_cd . '　' . $Minfo_office_nm . '&nbsp;&nbsp;</font>');
		}else{
			print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
		}
		print('</td>');
		print('<td align="right">' . $Moffice_cnt . '&nbsp;オフィス');
		print('</td>');
		print('</tr>');
		print('</table>');
		
		print('</td>');
		print('</tr>');
		print('</table>');
		
		//最終更新日時／戻るボタン
		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="left">');
		print('（最終更新日時：' . $Minfo_update_time . '　担当：');
		print( $Minfo_update_staff_cd );
		print('）');
		print('<pre>' . $Minfo_update_cmt . '</pre>');
		print('</td>');
		print('<form method="post" action="kanri_top.php">');
		print('<td align="right" valign="bottom">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
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
