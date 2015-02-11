<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－クラス（削除）確認</title>
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
	$gmn_id = 'kanri_class_del1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_class_ksn0.php');

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
	
	//固有引数の取得
	$select_office_cd = $_POST['select_office_cd'];	//選択したオフィスコード

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
		print('<img src="./img_' . $lang_cd . '/btn_sakujyo_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_mukouka_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		//固有引数の取得
		$class_cd = $_POST['class_cd'];		//登録対象のクラスコード
		$class_nm = $_POST['class_nm'];		//登録対象のクラス名
		$yukou_flg = $_POST['yukou_flg'];	//有効フラグ　0：無効　1：有効
		$st_year = $_POST['st_year'];		//開始年
		$st_month = $_POST['st_month'];		//開始月
		$st_day = $_POST['st_day'];			//開始日
		$ed_year = $_POST['ed_year'];		//終了年
		$ed_month = $_POST['ed_month'];		//終了月
		$ed_day = $_POST['ed_day'];			//終了日
		
		$err_cnt = 0;	//エラー件数

		//予約利用されているかチェックする
		//本日以降の予約
		$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "' . $class_cd . '" and YMD >= "' . $now_yyyy . sprintf("%02d",$now_mm) . sprintf("%02d",$now_dd) . '";';
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

			$err_cnt = 9;

		}else{
			$row = mysql_fetch_array($result);
		
			if( $row[0] > 0 ){
				//データが既に存在する場合
				$err_cnt = 1;
			}else{
				//過去の予約
				$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "' . $class_cd . '" and YMD < "' . $now_yyyy . sprintf("%02d",$now_mm) . sprintf("%02d",$now_dd) . '";';
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
					
					$err_cnt = 9;

				}else{
					$row = mysql_fetch_array($result);
			
					if( $row[0] > 0 ){
						//データが既に存在する場合
						$err_cnt = 2;
					}
				}
			}
		}

		//オフィスマスタの取得
		$query = 'select OFFICE_NM,START_YOUBI from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
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
			$Moffice_office_nm = $row[0];	//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
		}



		if( $err_flg == 0 ){
			//エラーなし
			
			//予約が無い場合は削除、予約がある場合は無効化（更新）
			if( $err_cnt == 0 ){
				//予約が無い場合は削除
				
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_class.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_class_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="class_cd" value="' . $class_cd . '">');
				print('<input type="hidden" name="class_nm" value="' . $class_nm . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
				
				print('<font color="blue">※以下を削除します。よろしければ削除ボタンを押下してください。</font><br><font color="red" size="2">（まだ削除されていません。）</font><br>');

				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
			
				//予約種別コード（クラスコード）・予約種別名（クラス名）
				print('<table border="0">');
				print('<tr>');
				print('<td><b>予約種別コード(*)</b><br>');
				print('<font size="5" color="blue">' . $class_cd . '</font>&nbsp;&nbsp;<br>');
				print('<font size="2">(半角英数字:最大4桁)</font>&nbsp;&nbsp;');
				print('</td>');
				print('<td><b>予約種別名(*)</b><br>');
				print('<font size="5" color="blue">' . $class_nm . '</font>&nbsp;&nbsp;<br>');
				print('<font size="2">(全角・半角英数字)</font>&nbsp;&nbsp;');
				print('</td>');
				print('</tr>');
				print('</table>');

				//有効期間
				print('<b>有効期間(*)</b>・・・上記予約種別の有効期間<br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('開始日<br>');
				print('<font color="blue" size="5">&nbsp;<b>' . $st_year . '</b></font>');
				print('年');
				print('<font color="blue" size="5">&nbsp;<b>' . $st_month . '</b></font>');
				print('月');
				print('<font color="blue" size="5">&nbsp;<b>' . $st_day . '</b></font>');
				print('日 から');
				print('</td>');
				print('<td align="left">');
				print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
				print('<font color="blue" size="5">&nbsp;<b>' . $ed_year . '</b></font>');
				print('年');
				print('<font color="blue" size="5">&nbsp;<b>' . $ed_month . '</b></font>');
				print('月');
				print('<font color="blue" size="5">&nbsp;<b>' . $ed_day . '</b></font>');
				print('日 まで');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				print('</td>');
				print('</tr>');
				print('</table>');
	
				//有効無効／登録ボタン／戻るボタン
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">');
				print('<b>有効／無効(*)</b><br>');
				if( $yukou_flg == 1 ){
					print('<font color="blue" size="5"><b>有効</b></font>');
				}else{
					print('<font color="red" size="5"><b>無効</b></font>');
				}
				print('<br><font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
				print('</td>');
				print('<td align="right">');
				print('<form method="post" action="kanri_class_del2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="class_cd" value="' . $class_cd . '">');
				print('<input type="hidden" name="class_nm" value="' . $class_nm . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				print('<input type="hidden" name="delete_flg" value="1">');	//1:削除 2:無効化
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sakujyo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_class_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="class_cd" value="' . $class_cd . '">');
				print('<input type="hidden" name="class_nm" value="' . $class_nm . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
		
				print('</center>');
				
				print('<hr>');
				
		
			}else if( $err_cnt == 1 ){
				//今日以降に予約がある場合は削除不可
				
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_class.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_class_select.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
				
				print('<font color="red">※本日以降に予約データが存在するので削除できません。</font><br><br>');

				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
			
				//予約種別コード（クラスコード）・予約種別名（クラス名）
				print('<table border="0">');
				print('<tr>');
				print('<td><b>予約種別コード(*)</b><br>');
				print('<font size="5" color="blue">' . $class_cd . '</font>&nbsp;&nbsp;<br>');
				print('</td>');
				print('<td><b>予約種別名(*)</b><br>');
				print('<font size="5" color="gray">' . $class_nm . '</font>&nbsp;&nbsp;<br>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('</center>');
				
				print('<hr>');
				

			}else if( $err_cnt == 2 ){
				//過去に予約がある場合は削除できないが、無効化はOK
			
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_class.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_class_select.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
				
				print('<font color="red">※過去の予約データが存在するので削除はできませんが、無効化することができます。</font><br><br>');
				print('<font color="blue">※以下の予約種別を無効化しますか？</font><br><br>');

				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
			
				//予約種別コード（クラスコード）・予約種別名（クラス名）
				print('<table border="0">');
				print('<tr>');
				print('<td><b>予約種別コード(*)</b><br>');
				print('<font size="5" color="blue">' . $class_cd . '</font>&nbsp;&nbsp;<br>');
				print('</td>');
				print('<td><b>予約種別名(*)</b><br>');
				print('<font size="5" color="gray">' . $class_nm . '</font>&nbsp;&nbsp;<br>');
				print('</td>');
				print('</tr>');
				print('</table>');

				//有効期間
				print('<b>有効期間(*)</b>・・・上記予約種別の有効期間<br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('開始日<br>');
				print('<font color="blue" size="5">&nbsp;<b>' . $st_year . '</b></font>');
				print('年');
				print('<font color="blue" size="5">&nbsp;<b>' . $st_month . '</b></font>');
				print('月');
				print('<font color="blue" size="5">&nbsp;<b>' . $st_day . '</b></font>');
				print('日 から');
				print('</td>');
				print('<td align="left">');
				print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
				print('<font color="blue" size="5">&nbsp;<b>' . $ed_year . '</b></font>');
				print('年');
				print('<font color="blue" size="5">&nbsp;<b>' . $ed_month . '</b></font>');
				print('月');
				print('<font color="blue" size="5">&nbsp;<b>' . $ed_day . '</b></font>');
				print('日 まで');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				print('</td>');
				print('</tr>');
				print('</table>');
	
				//有効無効／登録ボタン／戻るボタン
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">');
				print('<b>有効／無効(*)</b><br>');
				if( $yukou_flg == 1 ){
					print('<font color="blue" size="5"><b>有効</b></font>');
				}else{
					print('<font color="red" size="5"><b>無効</b></font>');
				}
				print('<br><font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
				print('</td>');
				print('<td align="right">');
				print('<form method="post" action="kanri_class_del2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="class_cd" value="' . $class_cd . '">');
				print('<input type="hidden" name="class_nm" value="' . $class_nm . '">');
				print('<input type="hidden" name="yukou_flg" value="0">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				print('<input type="hidden" name="delete_flg" value="2">');	//1:削除 2:無効化
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mukouka_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mukouka_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mukouka_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_class_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="class_cd" value="' . $class_cd . '">');
				print('<input type="hidden" name="class_nm" value="' . $class_nm . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
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
