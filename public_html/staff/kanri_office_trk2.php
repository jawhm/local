<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－オフィス(新規登録：結果)</title>
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
</head>
<body>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kanri_office_trk2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_office_trk1.php');

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


		//ページ編集
		//固有引数の取得
		$select_office_cd = $_POST['select_office_cd'];	//登録対象のオフィスコード
		$select_office_nm = $_POST['select_office_nm'];	//登録対象のオフィス名
		$office_pw = $_POST['office_pw'];				//登録対象のオフィスパスワード
		$mail_adr = $_POST['mail_adr'];					//登録対象オフィスのメールアドレス
		$tel = $_POST['tel'];							//登録対象オフィスの電話番号
		$cancel_yk_jkn = $_POST['cancel_yk_jkn'];		//登録対象オフィスのキャンセル有効時間（単位：時）
		$cancel_mk_kkn = $_POST['cancel_mk_kkn'];		//登録対象オフィスのキャンセル無効期間（単位：日前）
		$start_youbi = $_POST['start_youbi'];			//開始曜日（ 0:日曜始まり　1:月曜始まり ）
		$time_disp_flg = $_POST['time_disp_flg'];		//時間表示フラグ（ 0:24H表示　1:12H表示 ）
		$bikou = $_POST['bikou'];						//登録対象オフィスの備考
		$cancel_yk_jkn = $_POST['cancel_yk_jkn'];		//登録対象オフィスのキャンセル有効時間（単位：時）
		$st_year = $_POST['st_year'];					//開始年
		$st_month = $_POST['st_month'];					//開始月
		$st_day = $_POST['st_day'];						//開始日
		$ed_year = $_POST['ed_year'];					//終了年
		$ed_month = $_POST['ed_month'];					//終了月
		$ed_day = $_POST['ed_day'];						//終了日
		$yukou_flg = $_POST['yukou_flg'];				//有効フラグ
		
		//開始年月日
		$st_date = sprintf("%04d",$st_year) . '-' . sprintf("%02d",$st_month) . '-' . sprintf("%02d",$st_day);
		//終了年月日
		$ed_date = sprintf("%04d",$ed_year) . '-' . sprintf("%02d",$ed_month) . '-' . sprintf("%02d",$ed_day);
		
		//オフィスマスタの存在チェック
		$query = 'select count(*) from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and ST_DATE = "' . $st_date . '";';
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
		
			if( $row[0] > 0 ){
				//データが既に存在する場合
				//エラーメッセージ表示
				print('<font color="red">エラー：入力されたオフィスコード・開始日の情報は既に登録されています。オフィスコード[' . $select_office_cd . '] 開始日[' . $st_date . ']</font><br><br>');
				print('<hr>');

				//**ログ出力**
				$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'オフィスコードが既に登録されている。オフィスコード[' . $select_office_cd . '] 開始日[' . $st_date . ']';	//内容
				$log_err_inf = '';			//エラー情報
				require( './zs_log.php' );
				//************

				print('<form name="err3" method="post" action="' . $sv_staff_adr . 'kanri_office_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</form>');
				
			}else{
			
				//オフィスマスタの登録
				//文字コード設定（insert/update時に必須）
				require( '../zz_mojicd.php' );
				
				$query = 'insert into M_OFFICE values ("' . $DEF_kg_cd . '","' . $select_office_cd . '","' . $select_office_nm . '",ENCODE("' . $office_pw . '","' . $ANGpw . '"),ENCODE("' . $mail_adr . '","' . $ANGpw . '"),ENCODE("' . $tel . '","' . $ANGpw . '"),' . $cancel_yk_jkn . ',' . $cancel_mk_kkn . ',' . $start_youbi . ',' . $time_disp_flg . ',';
				if( $bikou == '' ){
					$query = $query . 'ENCODE(NULL,"' . $ANGpw . '"),';
				}else{
					$query = $query . 'ENCODE("' . $bikou . '","' . $ANGpw . '"),';
				}
				$query = $query . $yukou_flg . ',"' . $st_date . '","' . $ed_date . '","' . $now_time . '","' . $staff_cd . '");';
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
					$log_naiyou = 'オフィスマスタの登録に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************

				}
				
				if( $err_flg == 0 ){

					//**トランザクション出力**
					$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'オフィスマスタを登録しました。オフィス[' . $select_office_cd . '] 開始日[' . $st_date . ']';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************

					//**ログ出力**
					$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'オフィスマスタを登録しました。オフィス[' . $select_office_cd . '] 開始日[' . $st_date . ']';	//内容
					$log_err_inf = '';			//エラー情報
					require( './zs_log.php' );
					//************

					//ページ編集
					
					print('<center>');
					
					print('<table bgcolor="pink"><tr><td width="950">');
					print('<img src="./img_' . $lang_cd . '/bar_kanri_office.png" border="0">');
					print('</td></tr></table>');

					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="center"><font color="blue">※登録しました。</font></td>');
					print('<form method="post" action="kanri_office_top.php">');
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
		
					//配信メールへ記載する店舗情報（備考）
					print('<table border="0">');
					print('<tr>');
					print('<td align="left">');
					print('<font size="4"><b>配信メールへ記載する店舗情報</b></font><br>');
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
						print('<font color="blue" size="5">日曜始まり&nbsp;&nbsp;</font>');
					}else if( $start_youbi == 1 ){
						print('<font color="blue" size="5">月曜始まり&nbsp;&nbsp;</font>');
					}else{
						print('<font color="red" size="5">（未定義）&nbsp;&nbsp;</font>');
					}
					print('&nbsp;&nbsp;');
					print('<br><font size="2">カレンダー表示の開始曜日</font>');
					print('</td>');
					print('<td align="left" valign="top">');
					print('<b>時間表示(*)</b>&nbsp;&nbsp;&nbsp;<br>');
					if( $time_disp_flg == 0 ){
						print('<font color="blue" size="5">24H表示&nbsp;&nbsp;</font>');
					}else if( $time_disp_flg == 1 ){
						print('<font color="blue" size="5">12H表示&nbsp;&nbsp;</font>');
					}else{
						print('<font color="red" size="5">（未定義）&nbsp;&nbsp;</font>');
					}
					print('&nbsp;&nbsp;');
					print('<br><font size="2">時刻の表示形式<br>(24H形式：23時59分)<br>(12H形式：午後11時59分)</font>');
					print('</td>');
					print('<td align="left" valign="top">');
					print('<b>キャンセル無効期間(*)</b>&nbsp;&nbsp;&nbsp;<br>');
					print('<font color="blue" size="5">' . $cancel_mk_kkn . '</font>');
					print('<font size="2">&nbsp;日前</font><br><font size="2">キャンセルできる期限日&nbsp;&nbsp;</font>');
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
					print('<b>有効期間(*)</b>・・・店舗の営業期間');
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
					print('<form method="post" action="kanri_office_top.php">');
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
					
					print('</td>');
					print('</tr>');
					print('</table>');
					
					print('</center>');
		
					print('<hr>');
				}
			}
		}
	}

	mysql_close( $link );
?>
</body>
</html>