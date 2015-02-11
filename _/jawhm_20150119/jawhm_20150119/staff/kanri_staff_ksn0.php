<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－スタッフ（更新）</title>
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
<script type="text/javascript">
<!--
function disp(url){
	window.open(url, "window_name", "width=700,height=500,scrollbars=no,resizable=no,menubar=no,toolbar=no,location=no,directories=no,status=no");
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
	$gmn_id = 'kanri_staff_ksn0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_staff_select.php','kanri_staff_ksn1.php','kanri_staff_del1.php');

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
	$select_office_cd = $_POST['select_office_cd'];
	$stf_cd = $_POST['stf_cd'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $stf_cd == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_sakujyo_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_pwsyokika_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		
		//初期値セット
		//$stf_cd = $_POST['stf_cd'];		//スタッフコード（上位で取得済み）
		$stf_nm = $_POST['stf_nm'];			//スタッフ名
		$open_stf_nm = $_POST['open_stf_nm'];	//公開スタッフ名
		$stf_tel = $_POST['stf_tel'];		//電話番号
		$stf_mail = $_POST['stf_mail'];		//メールアドレス
		$ope_auth = $_POST['ope_auth'];		//業務権限
		$kanri_flg = $_POST['kanri_flg'];	//管理者フラグ
		$st_year = $_POST['st_year'];		//開始年
		$st_month = $_POST['st_month'];		//開始月
		$st_day = $_POST['st_day'];			//開始日
		$ed_year = $_POST['ed_year'];		//終了年
		$ed_month = $_POST['ed_month'];		//終了月
		$ed_day = $_POST['ed_day'];			//終了日
		$yukou_flg = $_POST['yukou_flg'];	//有効・無効フラグ
		
		if( $prc_gmn != "kanri_staff_ksn1.php" ){
			//スタッフマスタを読み込む
			$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '"),CLASS_CD1,CLASS_CD2,CLASS_CD3,CLASS_CD4,CLASS_CD5,OPE_AUTH,KANRISYA_FLG,YUKOU_FLG,ST_DATE,ED_DATE ' .
					 'from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			
			}else{
				$row = mysql_fetch_array($result);
				$stf_nm = $row[0];			//スタッフ名
				$open_stf_nm = $row[1];		//公開スタッフ名
				$class_cd1 = $row[2];		//クラスコード１
				$class_cd2 = $row[3];		//クラスコード２
				$class_cd3 = $row[4];		//クラスコード３
				$class_cd4 = $row[5];		//クラスコード４
				$class_cd5 = $row[6];		//クラスコード５
				$ope_auth = $row[7];		//業務権限
				$kanri_flg = $row[8];		//管理者フラグ
				$yukou_flg = $row[9];		//有効・無効フラグ
				$st_date = $row[10];			//開始年月日
				$st_year = substr( $st_date,0,4);					//開始年
				$st_month = sprintf("%d",substr( $st_date,5,2));	//開始月
				$st_day = sprintf("%d",substr( $st_date,8,2));		//開始日
				$ed_date = $row[11];		//終了年月日
				$ed_year = substr( $ed_date,0,4);					//終了年
				$ed_month = sprintf("%d",substr( $ed_date,5,2));	//終了月
				$ed_day = sprintf("%d",substr( $ed_date,8,2));		//終了日
			
			}
			
			//スタッフ連絡情報を読み込む
			$query = 'select DECODE(STAFF_TEL,"' . $ANGpw . '"),DECODE(STAFF_MAIL,"' . $ANGpw . '") from M_STAFF_RNR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' .	$select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
				$log_naiyou = 'スタッフ連絡情報の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
							
			}else{
				$row = mysql_fetch_array($result);
				$stf_tel = $row[0];
				$stf_mail = $row[1];
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
			$Moffice_office_nm = $row[0];		//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
		}

		//クラスマスタの取得
		$Mclass_cnt = 0;
		$query = 'select CLASS_CD,CLASS_NM from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 order by ST_DATE,CLASS_CD;';
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
			$log_naiyou = 'クラスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Mclass_class_cd[$Mclass_cnt] = $row[0];	//クラスコード
				$Mclass_class_nm[$Mclass_cnt] = $row[1];	//クラス名
				$Mclass_cnt++;
			}
		}

		
		if( $err_flg == 0 ){
			
			print('<center>');
			
			//ページ編集
			print('<table bgcolor="pink"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kanri_staff.png" border="0">');
			print('</td></tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			print('<form method="post" action="kanri_staff_select.php">');
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
			
			print('<font color="blue">※更新後、登録ボタンを押下してください。（*印の項目は必須入力となります。)</font><br>');
		
			print('<form method="post" action="kanri_staff_ksn1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="stf_cd" value="' . $stf_cd . '">');
			
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			
			//スタッフコード・スタッフ名・管理者フラグ
			print('<table border="0">');
			print('<tr>');
			print('<td valign="top"><b>スタッフコード(*)</b><br>');
			print('<font size="6" color="blue">' . $stf_cd . '</font>&nbsp;&nbsp;</font><br>');
			print('<font size="2" color="gray">(スタッフコードは変更できません)&nbsp;&nbsp;</font>');
			print('</td>');
			print('<td valign="top"><b>スタッフ名(*)</b><br>');
			$tabindex++;
			print('<input type="text" name="stf_nm" maxlength="40" size="25" tabindex="' . $tabindex . '" value="' . $stf_nm . '"style="font-size:20pt;ime-mode:active;" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(全角・半角英数字)&nbsp;&nbsp;</font>');
			print('</td>');
			print('<td valign="top"><b>管理者フラグ</b><br>');
			$tabindex++;
			print('<select name="kanri_flg" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt;">');
			if( $kanri_flg == 0 ){
				print('<option value="0" selected></option>');
				print('<option value="1" class="color2">管理者</option>');
			}else{
				print('<option value="0"></option>');
				print('<option value="1" class="color2" selected>管理者</option>');
			}
			print('</select>');
			print('<br><font size="2">&nbsp;</font>');
			print('</td>');
			
			print('</tr>');
			print('</table>');
			
			//公開スタッフ名
			print('<table border="0">');
			print('<tr>');
			print('<td><b>会員サイトに表示するスタッフ名</b><br>');
			$tabindex++;
			print('<input type="text" name="open_stf_nm" maxlength="40" size="25" tabindex="' . $tabindex . '" value="' . $open_stf_nm . '"style="font-size:20pt;ime-mode:active;" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(全角・半角英数字)&nbsp;&nbsp;</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			//電話番号
			print('<table border="0">');
			print('<tr>');
			print('<td align="left"><b>電話番号</b><br>');
			$tabindex++;
			print('<input type="text" name="stf_tel" maxlength="15" size="16" tabindex="' . $tabindex . '" value="' . $stf_tel . '"class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(半角英数字)&nbsp;&nbsp;</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			//メールアドレス
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top"><b>メールアドレス</b><br>');
			$tabindex++;
			print('<input type="text" name="stf_mail" maxlength="60" size="30" tabindex="' . $tabindex . '" value="' . $stf_mail . '"class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(半角英数字)&nbsp;&nbsp;</font>');
			print('</td>');
			print('</tr>');
			print('</table>');

			//予約種別１～５
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" colspan="5"><b>予約種別</b>･･･カウンセラー／講師の場合は担当する予約種別を選択して下さい。</td>');
			print('</tr>');
			
			print('<tr>');
			//予約種別（１）
			print('<td align="left">予約種別（１）<br>');
			$tabindex++;
			print('<select name="class_cd1" class="normal" tabindex="' . $tabindex . '" style="font-size:10pt">');
			if( $class_cd1 == '' ){
				print('<option value="" selected>&nbsp;</option>');
			}else{
				print('<option value="">&nbsp;</option>');
			}
			$i = 0;
			while( $i < $Mclass_cnt ){
				print('<option value="' . $Mclass_class_cd[$i] . '"');
				if( $Mclass_class_cd[$i] == $class_cd1 ){
					print(' selected>');
				}else{
					print('>');
				}
				print( $Mclass_class_cd[$i] . '&nbsp;' . $Mclass_class_nm[$i] . '</option>');
				
				$i++;
			}
			print('</select>');
			print('</td>');
			
			//予約種別（２）
			print('<td align="left">予約種別（２）<br>');
			$tabindex++;
			print('<select name="class_cd2" class="normal" tabindex="' . $tabindex . '" style="font-size:10pt">');
			if( $class_cd2 == '' ){
				print('<option value="" selected>&nbsp;</option>');
			}else{
				print('<option value="">&nbsp;</option>');
			}
			$i = 0;
			while( $i < $Mclass_cnt ){
				print('<option value="' . $Mclass_class_cd[$i] . '"');
				if( $Mclass_class_cd[$i] == $class_cd2 ){
					print(' selected>');
				}else{
					print('>');
				}
				print( $Mclass_class_cd[$i] . '&nbsp;' . $Mclass_class_nm[$i] . '</option>');
				
				$i++;
			}
			print('</select>');
			print('</td>');

			//予約種別（３）
			print('<td align="left">予約種別（３）<br>');
			$tabindex++;
			print('<select name="class_cd3" class="normal" tabindex="' . $tabindex . '" style="font-size:10pt">');
			if( $class_cd3 == '' ){
				print('<option value="" selected>&nbsp;</option>');
			}else{
				print('<option value="">&nbsp;</option>');
			}
			$i = 0;
			while( $i < $Mclass_cnt ){
				print('<option value="' . $Mclass_class_cd[$i] . '"');
				if( $Mclass_class_cd[$i] == $class_cd3 ){
					print(' selected>');
				}else{
					print('>');
				}
				print( $Mclass_class_cd[$i] . '&nbsp;' . $Mclass_class_nm[$i] . '</option>');
				
				$i++;
			}
			print('</select>');
			print('</td>');

			//予約種別（４）
			print('<td align="left">予約種別（４）<br>');
			$tabindex++;
			print('<select name="class_cd4" class="normal" tabindex="' . $tabindex . '" style="font-size:10pt">');
			if( $class_cd4 == '' ){
				print('<option value="" selected>&nbsp;</option>');
			}else{
				print('<option value="">&nbsp;</option>');
			}
			$i = 0;
			while( $i < $Mclass_cnt ){
				print('<option value="' . $Mclass_class_cd[$i] . '"');
				if( $Mclass_class_cd[$i] == $class_cd4 ){
					print(' selected>');
				}else{
					print('>');
				}
				print( $Mclass_class_cd[$i] . '&nbsp;' . $Mclass_class_nm[$i] . '</option>');
				
				$i++;
			}
			print('</select>');
			print('</td>');

			//予約種別（５）
			print('<td align="left">予約種別（５）<br>');
			$tabindex++;
			print('<select name="class_cd5" class="normal" tabindex="' . $tabindex . '" style="font-size:10pt">');
			if( $class_cd5 == '' ){
				print('<option value="" selected>&nbsp;</option>');
			}else{
				print('<option value="">&nbsp;</option>');
			}
			$i = 0;
			while( $i < $Mclass_cnt ){
				print('<option value="' . $Mclass_class_cd[$i] . '"');
				if( $Mclass_class_cd[$i] == $class_cd5 ){
					print(' selected>');
				}else{
					print('>');
				}
				print( $Mclass_class_cd[$i] . '&nbsp;' . $Mclass_class_nm[$i] . '</option>');
				
				$i++;
			}
			print('</select>');
			print('</td>');
			
			print('</tr>');
			print('</table>');

			//業務権限
			print('<table border="0">');
			print('<tr>');
			print('<td align="left"><b>業務権限</b><br>');
			$tabindex++;
			print('<input type="text" name="ope_auth" maxlength="3" size="3" tabindex="' . $tabindex . '" value="' . $ope_auth . '"class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(半角数字のみ)&nbsp;&nbsp;</font>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<br>');	//調整

			//有効期間
			print('<b>有効期間(*)</b>・・・上記スタッフの有効期間<br>');
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			print('開始日<br>');
			$tabindex++;
			print('<select name="st_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 2012;
			while( $i < 2038 ){
				print('<option value="' . $i . '" ');
				if( $i == $st_year ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('年');
			$tabindex++;
			print('<select name="st_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 13 ){
				print('<option value="' . $i . '" ');
				if( $i == $st_month ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('月');
			$tabindex++;
			print('<select name="st_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 32 ){
				print('<option value="' . $i . '" ');
				if( $i == $st_day ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
				print('</select>');
			print('日 から');
			print('</td>');
			print('<td align="left">');
			print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
			$tabindex++;
			print('<select name="ed_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 2012;
			while( $i < 2038 ){
				print('<option value="' . $i . '" ');
				if( $i == $ed_year ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('年');
			$tabindex++;
			print('<select name="ed_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 13 ){
				print('<option value="' . $i . '" ');
				if( $i == $ed_month ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('月');
			$tabindex++;
			print('<select name="ed_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 32 ){
				print('<option value="' . $i . '" ');
				if( $i == $ed_day ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
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
			$tabindex++;
			print('<select name="yukou_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
			if( $yukou_flg == 0 ){
				print('<option value="0" class="color2" selected>無効</option>');
				print('<option value="1" class="color1" >有効</option>');
			}else{
				print('<option value="0" class="color2" >無効</option>');
				print('<option value="1" class="color1" selected>有効</option>');
			}
			print('</select>');
			print('<font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
			print('</td>');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('<tr>');
			print('<td width="815" align="left">');
			print('<a href="kanri_staff_pwclear0.php?t=' . $office_cd . '&s=' . $staff_cd . '&st=' . $select_office_cd . '&ss=' . $stf_cd . '&l=' . $lang_cd . '" target="window_name" onClick="disp(\'kanri_staff_pwclear0.php?t=' . $office_cd . '&s=' . $staff_cd . '&st=' . $select_office_cd . '&ss=' . $stf_cd . '&l=' . $lang_cd . '\')">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_pwsyokika_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_pwsyokika_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_pwsyokika_1.png\';" onClick="kurukuru()" border="0">');
			print('</a>');
			print('</td>');
			print('<form method="post" action="kanri_staff_select.php">');
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
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kanri_staff_del1.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="stf_cd" value="' . $stf_cd . '">');
			print('<input type="hidden" name="stf_nm" value="' . $stf_nm . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sakujyo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('</center>');

			print('<hr>');
		}
	}

	mysql_close( $link );
?>
</body>
</html>
