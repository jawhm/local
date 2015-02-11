<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="robots" content="noindex,nofollow">
<title>初回パスワード登録</title>
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
	$gmn_id = 'pwd_res.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('menu.php','pwd_res.php');

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
	$staff_pw1 = $_POST['staff_pw1'];
	$staff_pw2 = $_POST['staff_pw2'];

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
				}
			}
		}
	}
	
	//エラー発生時
	if( $err_flg != 0 ){
		print('err![' . $err_flg . ']<br>');
		print('$lang_cd[' . $lang_cd . ']<br>');
		print('$office_cd[' . $office_cd . ']<br>');
		print('$staff_cd[' . $staff_cd . ']<br>');
		//エラー画面編集
//		require( './zs_errgmn.php' );

	//エラーなし
	}else{

		//引数チェック
		//パスワード（１）
		$err_staff_pw1 = 0;
		if( $staff_pw1 == '' ){
			//未入力エラー
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw1 = 1;
		}else if( strlen( $staff_pw1 ) != mb_strlen( $staff_pw1 ) ){
			//全角が含まれている
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw1 = 2;
		}else if( !preg_match('/^[a-z0-9]*$/i', $staff_pw1) ){
			//半角英数字以外がある
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw1 = 3;
		}else if( strlen( $staff_pw1 ) < 4 ){
			//４文字未満の場合
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw1 = 4;
		}

		//パスワード（２）
		$err_staff_pw2 = 0;
		if( $staff_pw2 == '' ){
			//未入力エラー
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw2 = 1;
		}else if( strlen( $staff_pw2 ) != mb_strlen( $staff_pw2 ) ){
			//全角が含まれている
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw2 = 2;
		}else if( !preg_match('/^[a-z0-9]*$/i', $staff_pw2) ){
			//半角英数字以外がある
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw2 = 3;
		}else if( strlen( $staff_pw2 ) < 4 ){
			//４文字未満の場合
			$err_flg = 4;	//固有引数エラーあり
			$err_staff_pw2 = 4;
		}

		//パスワードの一致確認
		if( $err_flg == 0 ){
			if ( $staff_pw1 != $staff_pw2 ){
				$err_flg = 4;
				$err_staff_pw1 = 5;
			}
		}
		
		//パスワードのセキュリティチェック
		if( $err_flg == 0 ){
			//パスワード禁止文字列（先頭４文字）
			$ng_word = array('0000','1111','2222','3333','4444','5555','6666','7777','8888','9999',
							 '1234','2345','3456','4567','5678','6789','7890','0987','9876','8765','7654','6543','5432','4321',
							 '1qaz','2wsx','3edc','4rfv','5tgb','6yhn','7ujm','zaq1','xsw2','cde3','vfr4','bgt5','nhy6','mju7',
							 '1QAZ','2WSX','3EDC','4RFV','5TGB','6YHN','7UJM','ZAQ1','XSW2','CDE3','VFR4','BGT5','NHY6','MJU7',
							 'aaaa','bbbb','cccc','dddd','eeee','ffff','gggg','hhhh','iiii','jjjj','kkkk','llll','mmmm',
							 'oooo','pppp','qqqq','rrrr','ssss','tttt','uuuu','vvvv','wwww','xxxx','yyyy','zzzz',
							 'AAAA','BBBB','CCCC','DDDD','EEEE','FFFF','GGGG','HHHH','IIII','JJJJ','KKKK','LLLL','MMMM',
							 'OOOO','PPPP','QQQQ','RRRR','SSSS','TTTT','UUUU','VVVV','WWWW','XXXX','YYYY','ZZZZ',
							 'abcd','Abcd','ABCD','zyxw','Zyxw','ZYXW',
							 'qwer','wert','erty','rtyu','tyui','yuio','uiop','poiu','oiuy','iuyt','uytr','ytre','trew','rewq',
							 'QWER','WERT','ERTY','RTYU','TYUI','YUIO','UIOP','POIU','OIUY','IUYT','UYTR','YTRE','TREW','REWQ',
							 'asdf','sdfg','dfgh','fghj','ghjk','hjkl','lkjh','kjhg','jhgf','hgfd','gfds','fdsa',
							 'ASDF','SDFG','DFGH','FGHJ','GHJK','HJKL','LKJH','KJHG','JHGF','HGFD','GFDS','FDSA',
							 'zxcv','xcvb','cvbn','vbnm','mnbv','nbvc','bvcx','vcxz',
							 'ZXCV','XCVB','CVBN','VBNM','MNBV','NBVC','BVCX','VCXZ',
							 'pass','Pass','PASS');
			$chk_str4 = substr($staff_pw1,0,4);	//先頭４文字
			if ( $staff_pw1 == $staff_cd ||	in_array($chk_str4 , $ng_word) ){
				//スタッフコードと同じ や 禁止文字列に含まれていたらＮＧとする
				$err_flg = 4;
				$err_staff_pw1 = 6;
				$err_staff_pw2 = 6;
			}
		}

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_login_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		
	
		if( $err_flg == 0 ){
			//エラーなし

			//スタッフマスタへのパスワード登録
			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
		
			$query = 'update M_STAFF set STAFF_PW = ENCODE("' . $staff_pw1 . '","' . $ANGpw . '"),UPDATE_TIME = "' . $now_time . '",UPDATE_STAFF_CD = "' . $staff_cd . '"' .
				 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php.php' );
	
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフマスタの更新に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
	
			}else{
				
				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '初回パスワード登録のためスタッフマスタを更新しました。[' . $office_cd . '-' . $staff_cd . ']';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			}

			//スタッフログイン情報の更新
			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
		
			$query = 'update D_STAFF_LOGIN set ERR_CNT = 0 ' .
					 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
	
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
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
				$log_naiyou = '初回パスワード登録のためスタッフログイン情報を更新しました。[' . $office_cd . '-' . $staff_cd . ']';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			}

			if( $err_flg == 0 ){
				//正常登録
				
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '初回パスワードを登録しました。オフィス[' . $office_cd . '] スタッフ[' . $staff_cd . ']';	//内容
				$log_err_inf = '';				//エラー情報
				require( './zs_log.php' );
				//************

				//オフィス名の取得
				$office_nm = '';
				require( './zs_office_nm.php' );

				//スタッフ名の取得
				$staff_nm = '';
				$zs_kanrisya_flg = 0;
				require( './zs_staff_nm.php' );

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
				//「パスワードが登録されました。」
				print('<img src="./img_' . $lang_cd . '/title_login_pwtrk_ok.png" border="0"><br><br>');
				
				print('<form name="form1" method="post" action="' . $sv_staff_adr . 'menu.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="staff_pw" value="' . $staff_pw1 . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" onClick="kurukuru()" border="0">');
				print('</form>');
				
				print('<br><br>');
				
				print('</center>');
				
				print('<hr>');
				
			}
		
		}else{
			//エラーあり
			
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
			
			//「エラーがあります」
			print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0"><br><br>');
			print('<form name="pass1" method="post" action="' . $sv_staff_adr . 'pwd_res.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
			
			print('<table border="0">');
			$tabindex++;
			//print('<tr><td bgcolor="#E0FFFF">登録するパスワードの入力をお願いします。<br>');
			print('<tr>');
			print('<td width="350" align="center" background="../img_' . $lang_cd . '/bg_pink_350x20.png">');
			print('<img src="./img_' . $lang_cd . '/title_pwinput1.png"><br>');
			print('<input type="password" name="staff_pw1" size="20" maxlength="20" tabindex="' . $tabindex . '" class="');
			if( $err_staff_pw1 == 0 ){
				print('normal');
			}else{
				print('err');
			}
			if( $err_staff_pw1 == 6 ){
				$staff_pw1 = '';
			}
			print('" style="font-size:20pt;ime-mode:disabled" value="' . $staff_pw1 . '" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $lang_cd == 'J' ){
				//日本語エラーメッセージ
				if( $err_staff_pw1 == 1 ){
					print('<br><font size="2" color="red">（パスワードが入力されていません）</font>');
				}else if( $err_staff_pw1 == 2 ){
					print('<br><font size="2" color="red">（全角文字は登録できません）</font>');
				}else if( $err_staff_pw1 == 3 ){
					print('<br><font size="2" color="red">（記号は登録できません）</font>');
				}else if( $err_staff_pw1 == 4 ){
					print('<br><font size="2" color="red">（４文字以上で登録してください）</font>');
				}else if( $err_staff_pw1 == 5 ){
					print('<br><font size="2" color="red">（確認用パスワードと一致しません）</font>');
				}else if( $err_staff_pw1 == 6 ){
					print('<br><font size="2" color="red">パスワードに適していません。<br>（違うパスワードを登録してください。）</font>');
				}
			}else if( $lang_cd == 'E' ){
				//英語エラーメッセージ
				if( $err_staff_pw1 == 1 ){
					print('<br><font size="2" color="red">(The password has not been entered.)</font>');
				}else if( $err_staff_pw1 == 2 ){
					print('<br><font size="2" color="red">(Double-byte characters can not be registered.)</font>');
				}else if( $err_staff_pw1 == 3 ){
					print('<br><font size="2" color="red">(Symbol characters can not be registered.)</font>');
				}else if( $err_staff_pw1 == 4 ){
					print('<br><font size="2" color="red">(Please register at least 4 characters long.)</font>');
				}else if( $err_staff_pw1 == 5 ){
					print('<br><font size="2" color="red">(Does not match the password for confirmation.)</font>');
				}else if( $err_staff_pw1 == 6 ){
					print('<br><font size="2" color="red">It is irrelevant as the password.<br>(Please register a different password.)</font>');
				}				
			}
			print('</td>');
			print('</tr>');
			$tabindex++;
			//print('<tr><td bgcolor="#FAFAD2">確認のため、再度入力してください。</font><br>');
			print('<tr>');
			print('<td width="350" align="center" background="../img_' . $lang_cd . '/bg_pink_350x20.png">');
			print('<img src="./img_' . $lang_cd . '/title_pwinput2.png"><br>');
			print('<input type="password" name="staff_pw2" size="20" maxlength="20" tabindex="' . $tabindex . '" class="');
			if( $err_staff_pw2 == 0 ){
				print('normal');
			}else{
				print('err');
			}
			if( $err_staff_pw2 == 6 ){
				$staff_pw2 = '';
			}
			print('" style="font-size:20pt;ime-mode:disabled" value="' . $staff_pw2 . '" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $lang_cd == 'J' ){
				//日本語エラーメッセージ
				if( $err_staff_pw2 == 1 ){
					print('<br><font size="2" color="red">（パスワードが入力されていません）</font>');
				}else if( $err_staff_pw2 == 2 ){
					print('<br><font size="2" color="red">（全角文字は登録できません）</font>');
				}else if( $err_staff_pw2 == 3 ){
					print('<br><font size="2" color="red">（記号は登録できません）</font>');
				}else if( $err_staff_pw2 == 4 ){
					print('<br><font size="2" color="red">（４文字以上で登録してください）</font>');
				}
			}else if( $lang_cd == 'E' ){
				//英語エラーメッセージ
				if( $err_staff_pw1 == 1 ){
					print('<br><font size="2" color="red">(The password has not been entered.)</font>');
				}else if( $err_staff_pw1 == 2 ){
					print('<br><font size="2" color="red">(Double-byte characters can not be registered.)</font>');
				}else if( $err_staff_pw1 == 3 ){
					print('<br><font size="2" color="red">(Symbol characters can not be registered.)</font>');
				}else if( $err_staff_pw1 == 4 ){
					print('<br><font size="2" color="red">(Please register at least 4 characters long.)</font>');
				}				
			}
				
			print('</td>');
			print('</tr>');
			print('</table>');
			print('<br>');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
			print('</form>');
			print('<br>');
						
			print('</center>');
				
			print('<hr>');

		}
	}
	
	mysql_close( $link );
?>
</body>
</html>