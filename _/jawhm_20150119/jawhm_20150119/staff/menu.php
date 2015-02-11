<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="robots" content="noindex,nofollow">
<title>スタッフメニュー</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<script type="text/javascript">
<!-- 
function disp2(url){
	window.open(url, "make_mail_url", "width=1050,height=800,scrollbars=yes,resizable=no,menubar=no,toolbar=no,location=no,directories=no,status=no");
}
function disp_1250x800(url){
	window.open(url, "mail_list_url_cs", "width=1250,height=800,scrollbars=yes,resizable=no,menubar=no,toolbar=no,location=no,directories=no,status=no");
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
	$gmn_id = 'menu.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('index_p.php','pwd_res.php');

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
	$office_cd = $_POST['office_cd'];	//未入力OK
	$staff_cd = $_POST['staff_cd'];
	$staff_pw = $_POST['staff_pw'];

	//固有引数
	$arg_p = $_POST['arg_p'];
	if( $arg_p == "ENTRY" || $arg_p == "ENTRY2" ){
		$client_no = $_POST['client_no'];
		$study_abroad_no = $_POST['study_abroad_no'];
	}else if( $arg_p == "MAIL" ){
		$mailno_ang_str = $_POST['mailno_ang_str'];
	}else if( $arg_p == "CS" ){
		$cs_no = $_POST['cs_no'];
	}else if( $arg_p == "MAKE" ){
		$mail_adr = $_POST['mail_adr'];
	}


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
			if ( $lang_cd == "" || $staff_cd == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( './zs_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
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
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_login_2.png" width="0" height="0" style="visibility:hidden;">');
		
	
		//スタッフマスタからパスワード、ログイン情報からエラーカウントを取得
		$query = 'select count(*) from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $staff_cd . '"' .
				 ' and ST_DATE <= "' . $now_yyyymmdd . '" and ED_DATE >= "' . $now_yyyymmdd . '" and YUKOU_FLG = 1;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;	//ＳＱＬエラー
			//エラーメッセージ表示
			require( './zs_errgmn.php' );

			//**ログ出力**
			$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
			$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';		//オフィスコード
			$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
			$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;		//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			
			//スタッフデータなし
			if( $row[0] == 0 ){
				//エラーメッセージ表示
				//print('<font color="red">スタッフコードが登録されていません。</font><br>');
				$err_flg = 5;
				

				//**ログ出力**
				$log_sbt = 'W';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
				$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';		//オフィスコード
				$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
				$log_naiyou = '未登録のスタッフコードが入力されました。cd[' . $staff_cd . ']';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

				//店舗メニュー編集
				print('<center>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="370" align="center" valign="middle">');
				print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
				print('</td>');
				print('<td width="265" align="left" valign="top">');
				//言語選択(Please select a language)
				print('<img src="./img_' . $lang_cd . '/lang_title.png" border="0"><br>');
				print('<table>');
				print('<tr>');
				print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="J">');
				print('<td>');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_j_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_j_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_j_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="E">');
				print('<td>');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_e_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_e_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_e_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="K">');
				print('<td>');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_k_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_k_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_k_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
		
				print('</td>');
				print('<td width="180" align="left">');
				print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
				print('</td>');
				print('<td width="135" align="center" valign="middle">');
				print('<img src="./img_' . $lang_cd . '/staffonly_mark.png" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');
				
				print('<br><br>');
				
				//エラーメッセージ表示
				print('<img src="./img_' . $lang_cd . '/title_login_err2.png" border="0"><br><br>');
				
				print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php?n=' . $staff_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</form>');
					
				print('</center>');
				
				print('<br><br>');
			
				print('<hr>');


			//スタッフデータあり
			}else{
				$query = 'select A.OFFICE_CD,DECODE(A.STAFF_PW,"' . $ANGpw . '"),A.OPE_AUTH,B.LOGIN_TIME,B.ERR_CNT from M_STAFF A,D_STAFF_LOGIN B' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '"' .
						 ' and A.STAFF_CD = "' . $staff_cd . '"' .
						 ' and A.ST_DATE <= "' . $now_yyyymmdd . '"' .
						 ' and A.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.YUKOU_FLG = 1 and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and A.STAFF_CD = B.STAFF_CD;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					//エラーメッセージ表示
					require( './zs_errgmn.php.php' );
			
					//**ログ出力**
					$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
					$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';		//オフィスコード
					$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
					$log_naiyou = 'スタッフマスタ・ログイン情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;		//エラー情報
					require( './zs_log.php' );
					//************

				}else{
					$row = mysql_fetch_array($result);
					$office_cd = $row[0];
					$DBtnt_pw = $row[1];
					$ope_auth = $row[2];
					$bf_login_time = $row[3];
					$err_cnt = $row[4];
					
					//初回利用か？
					if( $err_cnt == (-1) ){
						$err_flg = 9;
						
						//**ログ出力**
						$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = '初回パスワード入力画面を表示しました。';	//内容
						$log_err_inf = '';		//エラー情報
						require( './zs_log.php' );
						//************
						
						//オフィス名の取得
						$office_nm = '';
						require( './zs_office_nm.php' );

						//スタッフ名の取得
						$staff_nm = '';
						$zs_kanrisya_flg = 0;
						require( './zs_staff_nm.php' );

						//初回パスワード登録
						//画面編集
						print('<center>');
						
						print('<table border="0">');
						print('<tr>');
						print('<td width="370" align="center" valign="middle">');
						print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
						print('</td>');
						print('<td width="265" align="left" valign="top">');
						print('<table width="265" border="0">');
						print('<tr><td align="left"><img src="./img_' . $lang_cd . '/bar_officenm.png" border="0"></td></tr>');
						print('<tr><td><font size="2" color="blue">' . $office_nm . '</font></td></tr>');
						print('<tr><td align="left"><img src="./img_' . $lang_cd . '/bar_loginstaff.png" border="0"></td></tr>');
						print('<tr><td><font size="2" color="blue">' . $staff_nm . '</font></td></tr>');
						print('</table>');		
						print('</td>');
						print('<td width="180" align="left">');
						print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
						print('</td>');
						print('<form method="post" action="' . $sv_staff_adr . 'index_p.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<td width="135" align="center" valign="middle">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						print('</tr>');
						print('</table>');

						print('<hr>');
						
						print('<br>');
						//「初回利用のため、パスワードを登録します。」
						print('<img src="./img_' . $lang_cd . '/title_login_pwtrk.png" border="0"><br><br>');
						print('<form name="pass1" method="post" action="' . $sv_staff_adr . 'pwd_res.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');						
						print('<table border="0">');
						$tabindex++;
						//print('<tr><td bgcolor="#E0FFFF">登録するパスワードの入力をお願いします。<br>');
						print('<tr><td width="350" align="center" background="../img_' . $lang_cd . '/bg_pink_350x20.png"><img src="./img_' . $lang_cd . '/title_pwinput1.png"><br>');
						print('<input type="password" name="staff_pw1" size="20" maxlength="20" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"></td></tr>');
						$tabindex++;
						//print('<tr><td bgcolor="#FAFAD2">確認のため、再度入力してください。</font><br>');
						print('<tr><td width="350" align="center" background="../img_' . $lang_cd . '/bg_pink_350x20.png"><img src="./img_' . $lang_cd . '/title_pwinput2.png"><br>');
						print('<input type="password" name="staff_pw2" size="20" maxlength="20" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"></td></tr>');
						print('</table>');
						print('<br>');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
						print('</form>');
						print('<br>');
						
						print('</center>');
						
						print('<hr>');
					
					//エラー入力が９回以上
					}else if( $err_cnt >= 9 ){
						$err_flg = 6;
				
						//**ログ出力**
						$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = 'パスワードの誤入力が連続９回以上のため、ログイン拒否しました。';	//内容
						$log_err_inf = '';			//エラー情報
						require( './zs_log.php' );
						//************

						//オフィス名の取得
						$office_nm = '';
						require( './zs_office_nm.php' );

						//スタッフ名の取得
						$staff_nm = '';
						$zs_kanrisya_flg = 0;
						require( './zs_staff_nm.php' );

						//パスワード誤入力回数オーバー（ユーザーロック）
						//画面編集
						print('<center>');
						
						print('<table border="0">');
						print('<tr>');
						print('<td width="370" align="center" valign="middle">');
						print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
						print('</td>');
						print('<td width="265" align="left" valign="top">');
						print('<table width="265" border="0">');
						print('<tr><td align="left"><img src="./img_' . $lang_cd . '/bar_officenm.png" border="0"></td></tr>');
						print('<tr><td><font size="2" color="blue">' . $office_nm . '</font></td></tr>');
						print('<tr><td align="left"><img src="./img_' . $lang_cd . '/bar_loginstaff.png" border="0"></td></tr>');
						print('<tr><td><font size="2" color="blue">' . $staff_nm . '</font></td></tr>');
						print('</table>');		
						print('</td>');
						print('<td width="180" align="left">');
						print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
						print('</td>');
						print('<form method="post" action="' . $sv_staff_adr . 'index_p.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<td width="135" align="center" valign="middle">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						print('</tr>');
						print('</table>');
						
						print('<hr>');
							
						print('<br>');
						if( $lang_cd == 'J' ){
							//日本語
							print('<font color="red">パスワード誤入力のため、利用停止されています。</font><br>');
							print('<font color="red">（※店舗管理者へ連絡してください。）</font><br><br>');
							
						}else if( $lang_cd == 'E' ){
							//英語
							print('<font color="red">For mistyping password, you can not login to the site.</font><br>');
							print('<font color="red">(Please contact the server administrator.)</font><br><br>');
							
						}
						
						print('<form name="err7" method="post" action="' . $sv_staff_adr . 'index_p.php?n=' . $staff_cd . '">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" onClick="kurukuru()" border="0">');
						print('</form>');
							
						print('<br>');
						
						print('</center>');
						
						print('<hr>');


					//パスワードが異なる場合
					}else if( $DBtnt_pw != $staff_pw ){
						$err_flg = 7;

						//文字コード設定（insert/update時に必須）
						require( '../zz_mojicd.php' );
						
						//ログイン情報の更新
						$err_cnt++;
		    			$query = 'update D_STAFF_LOGIN  set ERR_CNT = ' . $err_cnt .
								 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
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
							$log_naiyou = 'スタッフログイン情報の更新に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************

						}else{

							//**トランザクション出力**
							$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'ログイン時にパスワード誤入力のため、ログイン情報のエラーカウントを＋１します';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************

							//**ログ出力**
							$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'パスワードが一致しません。エラー回数[' . $err_cnt . ']';	//内容
							$log_err_inf = '';			//エラー情報
							require( './zs_log.php' );
							//************

							//オフィス名の取得
							$office_nm = '';
							require( './zs_office_nm.php' );

							//スタッフ名の取得
							$staff_nm = '';
							$zs_kanrisya_flg = 0;
							require( './zs_staff_nm.php' );

							//パスワード間違い
							//画面編集
							print('<center>');
							
							print('<table border="0">');
							print('<tr>');
							print('<td width="370" align="center" valign="middle">');
							print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
							print('</td>');
							print('<td width="265" align="left" valign="top">');
							print('<table width="265" border="0">');
							print('&nbsp;');
							print('</table>');		
							print('</td>');
							print('<td width="180" align="left">');
							print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
							print('</td>');
							print('<form method="post" action="' . $sv_staff_adr . 'index_p.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<td width="135" align="center" valign="middle">');
							$tabindex++;
							print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
							print('</td>');
							print('</form>');
							print('</tr>');
							print('</table>');

							print('<hr>');
							
							print('<br>');
							//「パスワードが違います。」
							print('<img src="./img_' . $lang_cd . '/title_pw_err.png" border="0">');
							print('<br><br>');
							print('<form name="err7" method="post" action="' . $sv_staff_adr . 'index_p.php?n=' . $staff_cd . '">');
							$tabindex++;
							print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" onClick="kurukuru()" border="0">');
							print('</form>');
							
							print('<br>');
						
							print('</center>');
						
							print('<hr>');

						}
					
					//パスワード一致
					}else{
						
						//セッション開始
						session_name(JAWHM_Web_System);
						session_start();
						$_SESSION['office_cd'] = $office_cd;
						$_SESSION['staff_cd'] = $staff_cd;
						
						
						//文字コード設定（insert/update時に必須）
						require( '../zz_mojicd.php' );
						
						//ログイン情報の更新
		    			$query = 'update D_STAFF_LOGIN set LOGIN_FLG = 1 , LOGIN_TIME = "' . date("YmdHis") . '"' .
								 ', BF_LOGIN_TIME = "' . $bf_login_time . '",ERR_CNT = 0 ' .
								 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
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
							$log_naiyou = 'スタッフログイン情報の更新に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************

						}else{

							//**トランザクション出力**
							$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'スタッフログイン情報を更新しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************

						}
					}
				}
			}
		}
	}

	//ログイン正常
	if( $err_flg == 0 && $arg_p != "" ){
		//リンク先ありのログイン時
		if( $arg_p == "ENTRY" ){
		    header('Location: http://192.168.11.118/entry/entry_revision.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&op=' . $ope_auth . '&cn=' . $client_no . '&san=' . $study_abroad_no );
		}else if( $arg_p == "ENTRY2" ){
		    header('Location: http://192.168.11.118/entry/file_revision.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&op=' . $ope_auth . '&cn=' . $client_no . '&san=' . $study_abroad_no );
		}else if( $arg_p == "MAIL" ){
		    header('Location: http://192.168.11.118/mail/mail_disp.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&ms=' . $mailno_ang_str  );
		}else if( $arg_p == "CS" ){
		    header('Location: http://192.168.11.118/mail/mail_list2_list_cs_pre.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&c=' . $cs_no  );
		}else if( $arg_p == "MAKE" ){
		    header('Location: http://192.168.11.118/mail/make_mail_new0.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&adr=' . $mail_adr );
			
		}
		
	}else if( $err_flg == 0 ){
		
		//ユーザー情報の取得
		$user_ip = $_SERVER["REMOTE_ADDR"];
		$user_agent = $_SERVER["HTTP_USER_AGENT"];
		
		//ログインしたユーザー機種
		$user_machine = 'PC';
		if( strstr($user_agent,'iPad') ){
			$user_machine = 'iPad';
		}else if( strstr($user_agent,'Android') ){
			$user_machine = 'Android';
		}
		
		//**ログ出力**
		$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
		$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
		$log_office_cd = $office_cd;	//オフィスコード
		$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
		$log_naiyou = 'ログインしました。(' . $user_machine . ')';	//内容
		$log_err_inf = 'ip[' .  $user_ip . '] ag[' . $user_agent . ']';			//エラー情報
		require( './zs_log.php' );
		//************

		//メニューボタン表示
		require( './zs_menu_button.php' );
		
		//オフィス連絡事項情報　データ参照
		$query = 'select DECODE(RENRAKUJIKOU,"' . $ANGpw . '"),UPDATE_TIME,UPDATE_STAFF_CD' .
		         ' from D_OFFICE_RENRAKU where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$renrakujikou = '';		//連絡事項
			$update_time = '';		//更新日時
			$update_staff_cd = '';	//更新スタッフコード
		}else{
			$row = mysql_fetch_array($result);
			$renrakujikou = $row[0];
			$update_time = $row[1];
			$update_staff_cd = $row[2];
				
			$update_staff_nm = '';
			if( $update_staff_cd != '' ){
				$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd .
						 '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $update_staff_cd . '";';
				$result = mysql_query($query);
				if (!$result) {
					//参照失敗
					//なにもしない

				}else{
					$row = mysql_fetch_array($result);
					//データの格納
					$update_staff_nm = $row[0];		//更新スタッフ名
				}
			}
		}

		//ページ編集
		print('<center>');

		//仮置き
		print('<table border="0">');
		print('<tr>');
		
		//その他（田辺専用）
		print('<img src="./img_' . $lang_cd . '/btn_sonota_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<form name="form13" method="post" action="' . $sv_staff_adr . 'sonota_top.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
		print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sonota_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sonota_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sonota_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		
		if( $zs_kanrisya_flg == 1 ){
			//管理情報ボタン
			print('<img src="./img_' . $lang_cd . '/btn_kanriinfo_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<form name="form90" method="post" action="' . $sv_staff_adr . 'kanri_top.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
			print('<td width="135" align="center" valign="middle" bgcolor="pink">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kanriinfo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kanriinfo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kanriinfo_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			
//			if( $staff_cd == "zz_tanabe" ){
//				//移行用（田辺専用）		
//				print('<form name="form13" method="post" action="http://192.168.11.118/mail/mail_list_ikou.php" target="_mail">');
//				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
//				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
//				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
//				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
//				print('<input type="hidden" name="mail_pw" value="' . $mail_pw . '" />');
//				print('<input type="hidden" name="kkn_flg" value="0">');
//				print('<input type="hidden" name="cs_flg" value="0">');
//				print('<input type="hidden" name="keyword" value="">');
//				print('<input type="hidden" name="block_disp_flg" value="0">');
//				print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
//				$tabindex++;
//				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mail_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mail_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mail_1.png\';" border="0">');
//				print('</td>');
//				print('</form>');
//								
//			}
			
		}

		print('</tr>');
		print('</table>');			


		print('<table border="0">');
		print('<tr>');
		//「ログインしました。」
		print('<td width="500" align="left"><img src="./img_' . $lang_cd . '/title_login_mes.png" border="0"></td>');
		print('<td width="450" align="right" valign="top">（前回ログイン：&nbsp;' . $bf_login_time . '&nbsp;）</td>');
		print('</tr>');
		print('</table>');
		print('<br>');
		if( $update_time != ''){
			print('<table border="0">');
			print('<tr>');
			print('<td width="200" align="left"><img src="./img_' . $lang_cd . '/title_rnrjk.png" border="0"></td>');
			print('<td width="500" align="left"><font size="2">最終更新者：&nbsp;' . $update_staff_nm . '　（&nbsp;' . $update_time . '&nbsp;）</font></td>');
			print('</tr>');
			print('<tr>');
			print('<td align="left" colspan="2">');
			print('<blockquote><pre>' . $renrakujikou . '</pre></blockquote>');
			print('</td>');
			print('</tr>');
			print('</table>');
		}
		
		print('</center>');
		
	}
	
	mysql_close( $link );
?>
</body>
</html>