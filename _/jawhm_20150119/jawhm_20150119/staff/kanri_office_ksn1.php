<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－オフィス（更新）確認</title>
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
	$gmn_id = 'kanri_office_ksn1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_office_ksn0.php','kanri_office_ksn1.php');

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
	$select_st_date = $_POST['select_st_date'];		//変更前の開始日
	$select_ed_date = $_POST['select_ed_date'];		//変更前の終了日
	$lock_flg = $_POST['lock_flg'];

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

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');

		//ページ編集
		//固有引数の取得
		//$select_office_cd = $_POST['select_office_cd'];	//登録対象のオフィスコード
		$select_office_nm = $_POST['select_office_nm'];	//登録対象のオフィス名
		$office_pw = $_POST['office_pw'];				//登録対象のオフィスパスワード
		$mail_adr = $_POST['mail_adr'];					//登録対象店舗のメールアドレス
		$tel = $_POST['tel'];							//登録対象店舗の電話番号
		$cancel_yk_jkn = $_POST['cancel_yk_jkn'];		//登録対象店舗のキャンセル有効時間（単位：時）
		$cancel_mk_kkn = $_POST['cancel_mk_kkn'];		//登録対象店舗のキャンセル無効期間（単位：日前）
		$start_youbi = $_POST['start_youbi'];			//開始曜日（ 0:日曜始まり　1:月曜始まり ）
		$time_disp_flg = $_POST['time_disp_flg'];		//時間表示フラグ（ 0:24H表示　1:12H表示 ）
		$bikou = $_POST['bikou'];						//登録対象店舗の備考
		$st_year = $_POST['st_year'];					//開始年
		$st_month = $_POST['st_month'];					//開始月
		$st_day = $_POST['st_day'];						//開始日
		$ed_year = $_POST['ed_year'];					//終了年
		$ed_month = $_POST['ed_month'];					//終了月
		$ed_day = $_POST['ed_day'];						//終了日
		$yukou_flg = $_POST['yukou_flg'];				//有効フラグ

		$err_cnt = 0;	//エラー件数

		//固有引数チェック
		//オフィスコード
		$err_select_office_cd = 0;
		$strcng_bf = $select_office_cd;
		require( '../zz_strdel.php' );	// ”と’を削除する
		$select_office_cd = $strcng_af;
		if( strlen( $select_office_cd ) == 0 ){
			$err_select_office_cd = 1;
			$err_cnt++;
		}
			
		//オフィス名
		$err_select_office_nm = 0;
		$strcng_bf = $select_office_nm;
		require( '../zz_strdel.php' );	// ”と’を削除する
		$select_office_nm = $strcng_af;
		if( strlen( $select_office_nm ) == 0 ){
			$err_select_office_nm = 1;
			$err_cnt++;
		}

		//オフィスパスワード
		$err_office_pw = 0;
		$strcng_bf = $office_pw;
		require( '../zz_strdel.php' );	// ”と’を削除する
		$office_pw = $strcng_af;
		if( strlen( $office_pw ) == 0 ){
			$err_office_pw = 1;
			$err_cnt++;
		}else if( strlen( $office_pw ) < 4 ){
			$err_office_pw = 2;
			$err_cnt++;
		}

		//メールアドレス
		$err_mail_adr = 0;
		$strcng_bf = $mail_adr;
		require( '../zz_strdel.php' );	// ”と’を削除する
		$mail_adr = $strcng_af;
		if( strlen( $mail_adr ) == 0 ){
			$err_mail_adr = 1;
			$err_cnt++;
		}

		//電話番号
		$err_tel = 0;
		$strcng_bf = $tel;
		require( '../zz_strdel.php' );	// ”と’を削除する
		$tel = $strcng_af;
		if( strlen( $tel ) == 0 ){
			$err_tel = 1;
			$err_cnt++;
		}

		//キャンセル有効時間
		$err_cancel_yk_jkn = 0;
		if( strlen( $cancel_yk_jkn ) == 0 ){
			$cancel_yk_jkn = 0;
		}else if( !is_numeric( $cancel_yk_jkn ) ){
			$err_cancel_yk_jkn = 1;
			$err_cnt++;
		}

		//キャンセル無効期間
		$err_cancel_mk_kkn = 0;
		if( strlen( $cancel_mk_kkn ) == 0 ){
			$cancel_mk_kkn = 0;
		}else if( !is_numeric( $cancel_mk_kkn ) ){
			$err_cancel_mk_kkn = 1;
			$err_cnt++;
		}

		//開始曜日
		$err_start_youbi = 0;
		if( strlen( $start_youbi ) == 0 ){
			$cancel_start_youbi = 0;
		}else if( !is_numeric( $start_youbi ) ){
			$err_start_youbi = 1;
			$err_cnt++;
		}

		//時間表示フラグ
		$err_time_disp_flg = 0;
		if( strlen( $time_disp_flg ) == 0 ){
			$time_disp_flg = 0;
		}else if( !is_numeric( $time_disp_flg ) ){
			$err_time_disp_flg = 1;
			$err_cnt++;
		}

		//備考
		$err_bikou = 0;
		$strcng_bf = $bikou;
		require( '../zz_strcng.php' );	// ”と’を削除する
		$bikou = $strcng_af;

		//日付チェック
		if( $st_year == '' && $st_month == '' && $st_day == '' ){
			//未入力時は本日日付をセットする
			$st_year = $now_yyyy;
			$st_month = $now_mm;
			$st_day = $now_dd;
		}
		
		$err_st_year = 0;
		if($st_year == ''){
			$err_st_year = 1;
			$err_cnt++;
		}else if(!ereg('[0-9]{4}',$st_year)){
			$err_st_year = 1;
			$err_cnt++;
		}else if( $st_year < 2011 ){
			$err_st_year = 1;
			$err_cnt++;
		}

		$err_st_month = 0;
		if($st_month == ''){
			$err_st_month = 1;
			$err_cnt++;
		}elseif(!ereg('[1-9]',$st_month) or $st_month < 1 or $st_month > 12){
			$err_st_month = 1;
			$err_cnt++;
		}

		$err_st_day = 0;
		if( $err_st_year == 0 && $err_st_month == 0 ){
			//該当年月の日数を求める
			$DFmaxdd = cal_days_in_month(CAL_GREGORIAN, $st_month , $st_year );
			if($st_day == ''){
				$err_st_day = 1;
				$err_cnt++;
			}elseif(!ereg('[1-9]',$st_day) or $st_day < 1 or $st_day > $DFmaxdd ){
				$err_st_day = 1;
				$err_cnt++;
			}
		}else{
			$err_st_day = 1;
		}
		
		//有効期間（終了年月日）
		if( $ed_year == '' && $ed_month == '' && $ed_day == '' ){
			//未入力時は最大日付をセットする
			$ed_year = 2037;
			$ed_month = 12;
			$ed_day = 31;
		}
		
		$err_ed_year = 0;
		if($ed_year == ''){
			$err_ed_year = 1;
			$err_cnt++;
		}else if(!ereg('[0-9]{4}',$ed_year)){
			$err_ed_year = 1;
			$err_cnt++;
		}else if( $ed_year < $now_yyyy ){
			$err_ed_year = 1;
			$err_cnt++;
		}
		
		$err_ed_month = 0;
		if($ed_month == ''){
			$err_ed_month = 1;
			$err_cnt++;
		}else if(!ereg('[1-9]',$ed_month) or $ed_month < 1 or $ed_month > 12){
			$err_ed_month = 1;
			$err_cnt++;
		}else if( $ed_year == $now_yyyy && $ed_month < $now_mm ){
			$err_ed_month = 1;
			$err_cnt++;
		}

		$err_ed_day = 0;
		if( $err_ed_year == 0 && $err_ed_month == 0 ){
			//該当年月の日数を求める
			$DFmaxdd = cal_days_in_month(CAL_GREGORIAN, $ed_month , $ed_year );
			if($ed_day == ''){
				$err_ed_day = 1;
				$err_cnt++;
			}else if(!ereg('[1-9]',$ed_day) or $ed_day < 1 or $ed_day > $DFmaxdd ){
				$err_ed_day = 1;
				$err_cnt++;
			}else if( $ed_year == $now_yyyy && $ed_month == $now_mm && $ed_day < $now_dd ){
				$err_ed_day = 1;
				$err_cnt++;
			}
		}else{
			$err_ed_day = 1;
			$err_cnt++;
		}
		
		//日付の逆転チェックと予約有無確認
		if( $err_cnt == 0 ){
			
			$old_st_date = substr($select_st_date,0,4) . substr($select_st_date,5,2) . substr($select_st_date,8,2);
			$old_ed_date = substr($select_ed_date,0,4) . substr($select_ed_date,5,2) . substr($select_ed_date,8,2);
			$new_st_date = $st_year . sprintf("%02d",$st_month) . sprintf("%02d",$st_day);
			$new_ed_date = $ed_year . sprintf("%02d",$ed_month) . sprintf("%02d",$ed_day);
			
			if( $new_st_date > $new_ed_date ){
				//開始日と終了日が逆転しているので開始日と終了日をエラーとする
				$err_st_year = 1;
				$err_st_month = 1;
				$err_st_day = 1;
				$err_ed_year = 1;
				$err_ed_month = 1;
				$err_ed_day = 1;
				$err_cnt++;
			
			}else{
				
				//変更前の適用期間から除外される期間に予約があるか確認する	
				if( $new_st_date > $old_st_date ){
					//適用開始日から除外される期間に予約があるか？				
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD >= "' . $old_st_date . '" and YMD < "' . $new_st_date . '";';
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
							//予約データがあるので開始日をエラーとする
							$err_st_year = 3;
							$err_st_month = 3;
							$err_st_day = 3;
							$err_cnt++;
						}
					}
				}
				
				if( $new_ed_date < $old_ed_date ){
					//適用終了日から除外される期間に予約があるか？				
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD <= "' . $old_ed_date . '" and YMD > "' . $new_ed_date . '";';
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
							//予約データがあるので終了日をエラーとする
							$err_ed_year = 3;
							$err_ed_month = 3;
							$err_ed_day = 3;
							$err_cnt++;
						}
					}
				}
			}
		}


		if( $err_flg == 0 ){
			
			//明細データにエラーがあるか？
			if( $err_cnt == 0 ){
				//エラーなし
				
				//ページ編集
				
				print('<center>');
				
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_office.png" border="0">');
				print('</td></tr></table>');

				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="center"><font color="blue">※以下の内容で更新します。よろしければ登録ボタンを押下してください。</font><br><font color="red" size="2">（まだ更新されていません。）</font></td>');
				print('<form method="post" action="kanri_class_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_office_nm" value="' . $select_office_nm . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="office_pw" value="' . $office_pw . '">');
				print('<input type="hidden" name="mail_adr" value="' . $mail_adr . '">');
				print('<input type="hidden" name="tel" value="' . $tel . '">');
				print('<input type="hidden" name="cancel_yk_jkn" value="' . $cancel_yk_jkn . '">');
				print('<input type="hidden" name="cancel_mk_kkn" value="' . $cancel_mk_kkn . '">');
				print('<input type="hidden" name="start_youbi" value="' . $start_youbi . '">');
				print('<input type="hidden" name="time_disp_flg" value="' . $time_disp_flg . '">');
				print('<input type="hidden" name="bikou" value="' . $bikou . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				
				//オフィスコード／オフィス名／オフィスパスワード
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<b>オフィスコード(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $select_office_cd . '&nbsp;&nbsp;</font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>オフィス名(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $select_office_nm . '&nbsp;&nbsp;</font>');
				print('</td>');
				print('<td valign="top">');
				print('<b>オフィスパスワード(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $office_pw . '&nbsp;&nbsp;</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				//受付メールアドレス／受付電話番号
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<b>受付メールアドレス(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $mail_adr . '&nbsp;&nbsp;</font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>受付電話番号(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $tel . '&nbsp;&nbsp;</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				//配信メールへ記載するオフィス情報（備考）
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('<font size="4"><b>配信メールへ記載するオフィス情報</b></font><br>');
				print('<div style="margin: 10px"><pre><font color="blue">');
				if( $bikou != '' ){
					print( $bikou );
				}else{
					print('（登録なし）');	
				}
				print('</font></pre></div>');
				print('</td>');
				print('</tr>');
				print('</table>');
		
				//キャンセル無効期間／キャンセル有効時間／開始曜日／時間表示フラグ
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<b>開始曜日(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				if( $start_youbi == 0 ){
					print('<font color="blue" size="5">日曜始まり</font>');
				}else if( $start_youbi == 1 ){
					print('<font color="blue" size="5">月曜始まり</font>');
				}else{
					print('<font color="red" size="5">（未定義）</font>');
				}
				print('&nbsp;&nbsp;');
				print('<br><font size="2">カレンダー表示の開始曜日</font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>時間表示(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				if( $time_disp_flg == 0 ){
					print('<font color="blue" size="5">24H表示</font>');
				}else if( $time_disp_flg == 1 ){
					print('<font color="blue" size="5">12H表示</font>');
				}else{
					print('<font color="red" size="5">（未定義）</font>');
				}
				print('&nbsp;&nbsp;');
				print('<br><font size="2">時刻の表示形式<br>(24H形式：23時59分)<br>(12H形式：午後11時59分)</font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>キャンセル無効期間(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $cancel_mk_kkn . '</font>');
				print('<font size="2">&nbsp;日前</font><br><font size="2">キャンセルできる期限日</font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>キャンセル有効時間(*)</b>&nbsp;&nbsp;&nbsp;<br>');
				print('<font color="blue" size="5">' . $cancel_yk_jkn . '</font>');
				print('<font size="2">&nbsp;時間以内</font><br><font size="2">キャンセル無効期間でも<br>キャンセル可能とする有効時間</font>');
				print('</td>');
				print('</tr>');		
				print('</table>');
				
				print('<br>');
	
				//有効期間
				print('<table border="0">');
				print('<tr>');
				print('<td width="950" align="left">');
				print('<b>有効期間(*)</b>・・・オフィスの営業期間');
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('開始日<br>');
				print('<font color="blue" size="5">' . $st_year . '</font>');
				print('年');
				print('<font color="blue" size="5">' . $st_month . '</font>');
				print('月');
				print('<font color="blue" size="5">' . $st_day . '</font>');
				print('日 から');
				print('</td>');
				print('<td align="left">');
				print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
				print('<font color="blue" size="5">' . $ed_year . '</font>');
				print('年');
				print('<font color="blue" size="5">' . $ed_month . '</font>');
				print('月');
				print('<font color="blue" size="5">' . $ed_day . '</font>');
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
				print('<form method="post" action="kanri_office_ksn2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_office_nm" value="' . $select_office_nm . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="office_pw" value="' . $office_pw . '">');
				print('<input type="hidden" name="mail_adr" value="' . $mail_adr . '">');
				print('<input type="hidden" name="tel" value="' . $tel . '">');
				print('<input type="hidden" name="cancel_yk_jkn" value="' . $cancel_yk_jkn . '">');
				print('<input type="hidden" name="cancel_mk_kkn" value="' . $cancel_mk_kkn . '">');
				print('<input type="hidden" name="start_youbi" value="' . $start_youbi . '">');
				print('<input type="hidden" name="time_disp_flg" value="' . $time_disp_flg . '">');
				print('<input type="hidden" name="bikou" value="' . $bikou . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_office_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_office_nm" value="' . $select_office_nm . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="office_pw" value="' . $office_pw . '">');
				print('<input type="hidden" name="mail_adr" value="' . $mail_adr . '">');
				print('<input type="hidden" name="tel" value="' . $tel . '">');
				print('<input type="hidden" name="cancel_yk_jkn" value="' . $cancel_yk_jkn . '">');
				print('<input type="hidden" name="cancel_mk_kkn" value="' . $cancel_mk_kkn . '">');
				print('<input type="hidden" name="start_youbi" value="' . $start_youbi . '">');
				print('<input type="hidden" name="time_disp_flg" value="' . $time_disp_flg . '">');
				print('<input type="hidden" name="bikou" value="' . $bikou . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');

				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('</center>');

				print('<hr>');

			}else if( $err_cnt > 0 ){
				//エラーがある場合
				
				//ページ編集
				
				print('<center>');
				
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_office.png" border="0">');
				print('</td></tr></table>');
	
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="center"><font color="red">※エラーがあります。（*印の項目は必須入力となります。)</font></td>');
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
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');

				//オフィスコード／オフィス名／オフィスパスワード
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<b>オフィスコード(*)</b><br>');
				$tabindex++;
				print('<input type="text" name="select_office_cd" maxlength="20" size="8" value="' . $select_office_cd . '" tabindex="' . $tabindex . '"  class="');
				if( $err_select_office_cd == 0 ){
					print('normal');
				}else{
					print('err');	
				}
				print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
				print('<font size="2">(半角英数字：最大20桁)</font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>オフィス名(*)</b><br>');
				$tabindex++;
				print('<input type="text" name="select_office_nm" maxlength="60" size="28" value="' . $select_office_nm . '" tabindex="' . $tabindex . '" class="');
				if( $err_select_office_nm == 0 ){
					print('normal');
				}else{
					print('err');	
				}
				print('" style="font-size:20pt;ime-mode:active" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
				print('<font size="2">(全角・半角英数字)</font>');
				print('</td>');
				print('<td valign="top">');
				print('<b>オフィスパスワード(*)</b><br>');
				$tabindex++;
				print('<input type="text" name="office_pw" maxlength="30" size="10" value="' . $office_pw . '" tabindex="' . $tabindex . '" class="');
				if( $err_office_pw == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
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
				print('<input type="text" name="mail_adr" maxlength="60" size="35" value="' . $mail_adr . '" tabindex="' . $tabindex . '" class="');
				if( $err_mail_adr == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
				print('<font size="2">(半角英数字)<br></font>');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<b>受付電話番号(*)</b><br>');
				$tabindex++;
				print('<input type="text" name="tel" maxlength="15" size="15" value="' . $tel . '" tabindex="' . $tabindex . '" class="');
				if( $err_tel == 0 ){
					print('normal');	
				}else{
					print('err');	
				}
				print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
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
				print('tabindex="' . $tabindex . '" class="');
				if( $err_bikou == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $bikou . '</textarea><font size="2">(全角・半角英数字)<br>&nbsp;</font>');
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
				if( $err_start_youbi != 0 ){
					print('<br><font size="2" color="red">選択エラー</font>');
				}
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
				if( $err_time_disp_flg != 0 ){
					print('<br><font size="2" color="red">選択エラー</font>');
				}
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
				print('<font size="2">日前</font>');
				if( $err_cancel_mk_kkn != 0 ){
					print('<br><font size="2" color="red">選択エラー</font>');
				}
				print('<br><font size="2">キャンセルできる期限日</font>');
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
				print('<font size="2">時間以内</font>');
				if( $err_cancel_yk_jkn != 0 ){
					print('<br><font size="2" color="red">選択エラー</font>');
				}
				print('<br><font size="2">キャンセル無効期間でも<br>キャンセル可能とする有効時間</font>');
				print('</td>');
				print('</tr>');		
				print('</table>');
				
				print('</td>');
				print('</tr>');
				print('</table>');
				
				
				print('<br>');
				
				print('<table>');
				print('<tr>');
				print('<td width="950" align="left">');
				
				//有効期間
				print('<b>有効期間(*)</b>・・・店舗の営業期間<br>');
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
				if( $err_st_year != 0 ){
					print('<br><font size="2" color="red">年エラー</font>');	
				}
				if( $err_st_month != 0 ){
					print('<br><font size="2" color="red">月エラー</font>');	
				}
				if( $err_st_day != 0 ){
					print('<br><font size="2" color="red">日エラー</font>');	
				}
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
				if( $err_ed_year != 0 ){
					print('<br><font size="2" color="red">年エラー</font>');	
				}
				if( $err_ed_month != 0 ){
					print('<br><font size="2" color="red">月エラー</font>');	
				}
				if( $err_ed_day != 0 ){
					print('<br><font size="2" color="red">日エラー</font>');	
				}
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
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_office_top.php">');
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
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');

				print('</td>');
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