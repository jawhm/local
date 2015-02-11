<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－オフィス（更新）</title>
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
	$gmn_id = 'kanri_office_ksn0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_office_top.php','kanri_office_ksn1.php','kanri_office_del1.php');

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
	
	$select_office_cd = $_POST['select_office_cd'];	//登録対象のオフィスコード
	$select_st_date = $_POST['select_st_date'];		//開始日
	$select_ed_date = $_POST['select_ed_date'];		//終了日
	
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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_st_date == "" ){
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

		//メニューボタン表示
		require( './zs_menu_button.php' );

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_sakujyo_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		//初期値セット
		if( $prc_gmn == 'kanri_office_top.php' || $prc_gmn == 'kanri_office_del1.php' ){

			// 店舗マスタの情報取得
			$query = 'select OFFICE_NM,DECODE(OFFICE_PW,"' . $ANGpw . '"),DECODE(MAIL_ADR,"' . $ANGpw . '"),DECODE(TEL,"' . $ANGpw . '"),CANCEL_YK_JKN,CANCEL_MK_KKN,START_YOUBI,TIME_DISP_FLG,DECODE(BIKOU,"' . $ANGpw . '"),YUKOU_FLG from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and ST_DATE = "' . $select_st_date . '";';
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
				$select_office_nm = $row[0];				//登録対象のオフィス名
				$office_pw = $row[1];						//登録対象のオフィスパスワード
				$mail_adr = $row[2];						//登録対象店舗のメールアドレス
				$tel = $row[3];								//登録対象店舗の電話番号
				$cancel_yk_jkn = $row[4];					//登録対象店舗のキャンセル有効時間（単位：時）
				$cancel_mk_kkn = $row[5];					//登録対象店舗のキャンセル無効期間（単位：日前）
				$start_youbi = $row[6];						//開始曜日（ 0:日曜始まり　1:月曜始まり ）
				$time_disp_flg = $row[7];					//時間表示フラグ（ 0:24H表示　1:12H表示 ）
				$bikou = $row[8];							//登録対象店舗の備考
				$yukou_flg = $row[9];						//有効フラグ
				$st_year = substr($select_st_date,0,4);		//開始年
				$st_month = substr($select_st_date,5,2);	//開始月
				$st_day = substr($select_st_date,8,2);		//開始日
				$ed_year = substr($select_ed_date,0,4);		//終了年
				$ed_month = substr($select_ed_date,5,2);	//終了月
				$ed_day = substr($select_ed_date,8,2);		//終了日
			}
		
		}else{
			$select_office_nm = $_POST['select_office_nm'];	//登録対象の店舗名
			$office_pw = $_POST['office_pw'];				//登録対象の店舗パスワード
			$mail_adr = $_POST['mail_adr'];					//登録対象店舗のメールアドレス
			$tel = $_POST['tel'];							//登録対象店舗の電話番号
			$bikou = $_POST['bikou'];						//登録対象店舗の備考
			$cancel_yk_jkn = $_POST['cancel_yk_jkn'];		//登録対象店舗のキャンセル有効時間（単位：時）
			$cancel_mk_kkn = $_POST['cancel_mk_kkn'];		//登録対象店舗のキャンセル無効期間（単位：日前）
			$start_youbi = $_POST['start_youbi'];			//開始曜日（ 0:日曜始まり　1:月曜始まり ）
			$time_disp_flg = $_POST['time_disp_flg'];		//時間表示フラグ（ 0:24H表示　1:12H表示 ）
			$st_year = $_POST['st_year'];					//開始年
			$st_month = $_POST['st_month'];					//開始月
			$st_day = $_POST['st_day'];						//開始日
			$ed_year = $_POST['ed_year'];					//終了年
			$ed_month = $_POST['ed_month'];					//終了月
			$ed_day = $_POST['ed_day'];						//終了日
			$yukou_flg = $_POST['yukou_flg'];				//有効フラグ
		}
		
		//適用期間に予約があるか確認。（予約ありの場合は予約日を含む期間短縮は更新できない）
		$lock_flg = 0;	//ロックフラグ 0:ロックしない　1：開店時刻・閉店時刻はロックする

		$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD >= "' . $select_st_date . '" and YMD <= "' . $select_ed_date . '";';
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
				//予約データがあるの開始時刻・終了時刻はロックする
				$lock_flg = 1;
			}
		}
		
		//代表店舗コードの場合、０件にはできない
		$daihyo_lock_flg = 0;	//代表ロックフラグ 0:ロックしない　1：削除はできない
		$query = 'select DAIHYO_OFFICE_CD from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
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
			if( $select_office_cd == $row[0] ){
				//代表店舗なので削除不可とする
				$daihyo_lock_flg = 1;
			}
		}

		if( $err_flg == 0 ){

			//ページ編集
			
			print('<center>');
			
			print('<table bgcolor="pink"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kanri_office.png" border="0">');
			print('</td></tr></table>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="center"><font color="blue">※更新後、登録ボタンを押下してください。（*印の項目は必須入力となります。)</font>');
			if( $lock_flg == 1 ){
				print('<br><font size="2" color="red">（有効期間内に予約データが存在するため、削除はできません。）</font>');
			}else if( $daihyo_lock_flg == 1 ){
				print('<br><font size="2" color="red">（代表オフィスのため、削除はできません。）</font>');
			}
			print('</td>');
			print('<form method="post" action="kanri_office_top.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
	
			print('<form method="post" action="kanri_office_ksn1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			//print('<input type="hidden" name="select_office_nm" value="' . $select_office_nm . '">');
			print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
			print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
			print('<input type="hidden" name="lock_flg" value="' . $lock_flg . '">');
			
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			
			//店舗コード／店舗名／店舗パスワード
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<b>オフィスコード(*)</b>&nbsp;&nbsp;&nbsp;<br>');
			print('<font color="blue" size="5"><b>' . $select_office_cd . '</b>&nbsp;&nbsp;</font>');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<b>オフィス名(*)</b><br>');
			$tabindex++;
			print('<input type="text" name="select_office_nm" maxlength="60" size="28" value="' . $select_office_nm . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(全角・半角英数字)</font>');
			print('</td>');
			print('<td valign="top">');
			print('<b>オフィスパスワード(*)</b><br>');
			$tabindex++;
			print('<input type="text" name="office_pw" maxlength="30" size="10" value="' . $office_pw . '" tabindex="' . $tabindex . '" class="normal"  style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(半角英数字：4文字以上)</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			//受付メールアドレス／受付電話番号
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<b>受付メールアドレス(*)</b><br>');
			$tabindex++;
			print('<input type="text" name="mail_adr" maxlength="60" size="35" value="' . $mail_adr . '" tabindex="' . $tabindex . '" class="normal"  style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(半角英数字)<br></font>');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<b>受付電話番号(*)</b><br>');
			$tabindex++;
			print('<input type="text" name="tel" maxlength="15" size="15" value="' . $tel . '" tabindex="' . $tabindex . '" class="normal"  style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
			print('<font size="2">(半角英数字)<br></font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			//配信メールへ記載するオフィス情報（備考）
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			print('<font size="4"><b>配信メールへ記載するオフィス情報</b></font><br>');
			$tabindex++;
			print('<textarea name="bikou" rows="6" cols="60" wrap="hard" ');
			print('tabindex="' . $tabindex . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $bikou . '</textarea><font size="2">(全角・半角英数字)<br>&nbsp;</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			//キャンセル無効期間／キャンセル有効時間／開始曜日／時間表示フラグ
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<b>開始曜日(*)</b><br>');
			$tabindex++;
			print('<select name="start_youbi" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			if( $start_youbi == 0 ){
				print('<option value="0" selected>日曜始まり</option>');
				print('<option value="1">月曜始まり</option>');
			}else{
				print('<option value="0">日曜始まり</option>');
				print('<option value="1" selected>月曜始まり</option>');
			}
			print('</select>&nbsp;&nbsp;');
			print('<br><font size="2">カレンダー表示の開始曜日</font>');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<b>時間表示(*)</b><br>');
			$tabindex++;
				print('<select name="time_disp_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			if( $time_disp_flg == 0 ){
				print('<option value="0" selected>24H表示</option>');
				print('<option value="1">12H表示</option>');
			}else{
				print('<option value="0">24H表示</option>');
				print('<option value="1" selected>12H表示</option>');
			}
			print('</select>&nbsp;&nbsp;');
			print('<br><font size="2">時刻の表示形式<br>(24H形式：23時59分)<br>(12H形式：午後11時59分)</font>');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<b>キャンセル無効期間(*)</b>&nbsp;&nbsp;<br>');
			$tabindex++;
			print('<select name="cancel_mk_kkn" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 0;
			while( $i < 32 ){
				print('<option value="' . $i . '" ');
				if( $i == $cancel_mk_kkn ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('<font size="2">日前</font><br><font size="2">キャンセルできる期限日</font>');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<b>キャンセル有効時間(*)</b><br>');
			$tabindex++;
			print('<select name="cancel_yk_jkn" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 0;
			while( $i < 25 ){
				print('<option value="' . $i . '" ');
				if( $i == $cancel_yk_jkn ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('<font size="2">時間以内</font><br><font size="2">キャンセル無効期間でも<br>キャンセル可能とする有効時間</font>');
			print('</td>');
			print('</tr>');		
			print('</table>');
			
			print('<br>');
			
			//有効期間
			print('<b>有効期間(*)</b>・・・オフィスの営業期間<br>');
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			print('開始日<br>');
			$tabindex++;
			print('<select name="st_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 2011;
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
			$i = 2011;
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
	
			//有効無効／登録ボタン／戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">');
			print('<b>有効／無効(*)</b><br>');
			$tabindex++;
			print('<select name="yukou_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex .'" >');
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
			//登録ボタン
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			
			//戻るボタン
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kanri_office_top.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');

			if( $lock_flg == 0 && $daihyo_lock_flg == 0 ){
				//削除ボタン
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_office_del1.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_office_nm" value="' . $select_office_nm . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sakujyo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
			}
			
			print('</table>');
			
			print('<hr>');
			
			print('</center>');

		}
	}

	mysql_close( $link );
?>
</body>
</html>                                   