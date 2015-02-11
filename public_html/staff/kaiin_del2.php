<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>会員情報－会員情報の削除（結果）</title>
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
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kaiin_del2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_del1.php');

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
	$select_kaiin_no = $_POST['select_kaiin_no'];	//会員番号
	
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
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');

		//ページ編集
		//固有引数の取得
		$kaiin_nm = $_POST['kaiin_nm'];					//会員名
		$kaiin_nm_k = $_POST['kaiin_nm_k'];				//会員名カナ
//		$kaiin_tel = $_POST['kaiin_tel'];				//会員電話番号
//		$kaiin_mail = $_POST['kaiin_mail'];				//会員メールアドレス

		$err_cnt = 0;
		$err_cd = 0;
		
		//予約数を確認する
		$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_ID = "' . sprintf("%07d",$select_kaiin_no) . '";';
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
				//予約があるので削除はできない
				$err_cd = 3;	//「入力された会員に予約情報が存在するため、削除できません。」
				$err_cnt++;
			}
		}
		

		//会員情報から会員メールアドレスを求める
		$query = 'select DECODE(KAIIN_NM,"' . $ANGpw . '"),DECODE(KAIIN_MAIL,"' . $ANGpw . '") from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_NO = ' . sprintf("%d",$select_kaiin_no) . ';';
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
			$log_naiyou = '会員情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
				
		}else{
			$row = mysql_fetch_array($result);
			$Mkaiin_kaiin_nm = $row[0];		//会員名
			$Mkaiin_kaiin_mail = $row[1];	//会員メールアドレス
				
		}


		if( $err_flg == 0 && $err_cnt == 0 ){
			//エラーなし
				
			//会員情報の削除(delete)
			$query = 'delete from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_NO = ' . sprintf("%d",$select_kaiin_no) . ';';
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
				$log_naiyou = '会員情報の削除に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
					
				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '会員情報を削除しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			
				//会員顔写真があれば削除する
				if( $err_flg == 0 ){
					//接続を確立する
//					$conn_id = ftp_connect($ftp_server);
//					if( $conn_id ){
//						//接続確立成功
//						// ユーザ名とパスワードでログインする
//						$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
//						if( $login_result ){
//							//ログイン成功
//							//既に会員写真があった場合は削除する
//							$filename = './' . $dir_kaiin_img . '/' . sprintf("%07d",$select_kaiin_no) . '.img_' . $lang_cd . '';
//							if( file_exists( $filename ) ){
//								//画像削除
//								ftp_delete($conn_id, $filename );
//							}
//						}
//					}
//					//接続を閉じる
//					ftp_close($conn_id);
				}
			}
		}


		if( $err_flg == 0 && $Mkaiin_kaiin_mail != "" ){
			//メールを送信する			
			
			//管理情報から略称を求める
			$Mkanri_meishou = '';
			$Mkanri_ryakushou = '';
			$Mkanri_hp_adr = '';
			$query = 'select MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
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
				$Mkanri_meishou = $row[0];			//名称
				$Mkanri_ryakushou = $row[1];		//略称
				$Mkanri_hp_adr = $row[2];			//ホームページアドレス
				$Mkanri_send_mail_adr = $row[3];	//送信メールアドレス
			}
			
			//削除完了メール送信
			//送信元
			$from_nm = $Mkanri_meishou;
			$from_mail = $Mkanri_send_mail_adr;
			//宛て先
			$to_nm = $kaiin_nm . ' 様';
			$to_mail = $Mkaiin_kaiin_mail;
		
			//タイトル
			if( $Mkanri_ryakushou != '' ){
				$subject = '(' . $Mkanri_ryakushou . ')';
			}else{
				$subject = '';	
			}
			$subject .= '一般会員を削除しました';
	
			// 本文
			$content = $kaiin_nm . " 様\n\n";
			$content .= $Mkanri_meishou . "です。\n";
			$content .= "当協会の一般会員登録から削除させて頂きましたので\n";
			$content .= "お知らせします。\n\n";
			$content .= "---------------\n";
			$content .= "▼会員内容(一部抜粋)\n";
			$content .= "---------------\n";
			$content .= "一般会員(無料)から削除しました。\n";
			$content .= "会員No: " . sprintf("%05d",$select_kaiin_no) . "\n";
			$content .= "お名前: " . $kaiin_nm . " 様\n\n";
			$content .= "◆このメールに覚えが無い場合◆\n";
			$content .= "他の方がメールアドレスを間違えた可能性があります。\n";
			$content .= "お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。\n";
			$content .= "---------------\n";
			$content .= $Mkanri_meishou . "\n";
			$content .= $Mkanri_hp_adr . "\n";
			$content .= "メール: " . $Mkanri_send_mail_adr . "\n";
			if( $Moffice_bikou != '' ){
				$content .=  $Moffice_bikou . "\n";
			}
			$content .= "---------------\n";
			   
			//メール送信
			mb_language("Ja");				//使用言語：Ja
			mb_internal_encoding("utf-8");	//文字コード：UTF-8
			$frname0 = mb_encode_mimeheader($from_nm);
			$toname0 = mb_encode_mimeheader($to_nm);
			$sdmail0 = "$toname0 <$to_mail>";
			$mailhead = "From:\"$frname0\" <$from_mail>\r\n";
			$result = mb_send_mail( $sdmail0, $subject, $content, $mailhead );
		
			$send_mail_flg = 1;

		}


		if( $err_flg == 0 ){
			//エラーなし
			
			//**ログ出力**
			$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '会員情報を削除しました。会員No[' . sprintf("%07d",$select_kaiin_no) . ']';	//内容
			$log_err_inf = '会員No[' . sprintf("%07d",$select_kaiin_no) . '] 氏名[' . $kaiin_nm . '] カナ[' . $kaiin_nm_k . ']';			//エラー情報
			require( './zs_log.php' );
			//************

			//ページ編集
			print('<center>');
				
			print('<table bgcolor="lightblue"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kaiin_kaiinksn.png" border="0">');
			print('</td></tr></table>');
					
			//「削除しました。」
			print('<img src="./img_' . $lang_cd . '/title_del_ok.png" border="0">');
			if( $send_mail_flg == 1 ){
				print('<br><font size="2" color="blue">（※お客様へメール送信しました。）</font><br>');
			}
	
			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td align="left">');	//main
			
			//会員番号・会員名
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0">&nbsp;&nbsp;<br>');
			print('<font size="6" color="lightgrey">' . sprintf("%05d",$select_kaiin_no) . '</font>&nbsp;&nbsp;');
			print('</td>');
			//会員名
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0">&nbsp;&nbsp;<br>');
			if( $kaiin_nm_k != '' ){
				print('<font size="2" color="lightgrey">' . $kaiin_nm_k . '</font><br>');
			}
			print('<font size="5" color="lightgrey">' . $kaiin_nm . '</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main
			
			//戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="815">&nbsp;</td>');
			print('<form method="post" action="kaiin_kkn0.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="serch_flg" value="1">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<hr>');
					
			print('</center>');
		
		
		}else if( $err_cnt > 0 ){
			//エラーがある場合
				
			print('<center>');
			
			//ページ編集
			print('<table bgcolor="lightblue"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kaiin_kaiinksn.png" border="0">');
			print('</td></tr></table>');
				
			//「エラーがあります。」
			print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0">');
			if( $err_cd == 3 ){
				print('<font color="red">※入力された会員に予約情報が存在するため、削除できません。</font><br>');
			}

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td align="left">');	//main
				
			//会員番号・会員名
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0">&nbsp;&nbsp;<br>');
			print('<font size="6" color="blue">' . sprintf("%05d",$select_kaiin_no) . '</font>&nbsp;&nbsp;');
			print('</td>');
			//会員名
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0">&nbsp;&nbsp;<br>');
			if( $kaiin_nm_k != '' ){
				print('<font size="2" color="blue">' . $kaiin_nm_k . '</font><br>');
			}
			print('<font size="5" color="blue">' . $kaiin_nm . '</font>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main

			//戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="815">&nbsp;</td>');
			print('<form method="post" action="kaiin_kkn1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="serch_flg" value="1">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
				
			print('<hr>');

			print('</center>');
		
		}
	}

	mysql_close( $link );
?>
</body>
</html>