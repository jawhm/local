<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>会員情報－写真アップロード</title>
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
</SCRIPT> 
</head>

<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kaiin_img_ksn2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_img_ksn1.php','kaiin_img_ksn2.php');

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
	$select_kaiin_no = $_POST['select_kaiin_no'];
	$select_kaiin_nm = $_POST['select_kaiin_nm'];
	$select_kaiin_nm_k = $_POST['select_kaiin_nm_k'];
	$select_kaiin_mixi = $_POST['select_kaiin_mixi'];

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
		print('<img src="./img_' . $lang_cd . '/btn_syashin_up_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');


		//写真ファイル
		$file_err_flg = 0;
		$file_type = $_FILES['upfile']['type'];
			
		//ファイルが選択されているか
	  	if( is_uploaded_file($_FILES["upfile"]["tmp_name"]) ) {
			//ファイルサイズ取得
			$filesize = filesize($_FILES["upfile"]["tmp_name"]);
			if($filesize <= 2000000){	// 2Mまで
				if( FALSE !== strPos($file_type, 'image/') ){
					//ファイルアップロード
					if( move_uploaded_file($_FILES["upfile"]["tmp_name"], "./" . $dir_kaiin_img . "/tmp/" . $_FILES["upfile"]["name"]) ) {
	    				//chmod("files/" . $_FILES["upfile"]["name"], 0644);
	    				chmod("files/" . $_FILES["upfile"]["name"], 0777);
						
						//アップロードしたファイルが jpeg であるかチェックする
						$tmp_upfile = './' . $dir_kaiin_img . '/tmp/' . $_FILES["upfile"]["name"];
						$imglist = getimagesize( $tmp_upfile );
						if( $imglist[2] != 2 ){
							//jpegではない
							$file_err_flg = 5;
						
							//接続を確立する
							$conn_id = ftp_connect($ftp_server);
							//ログイン
							$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
							//ファイルを削除する
							$tmp_upfile = './httpdocs/staff/' . $dir_kaiin_img . '/tmp/' . $_FILES["upfile"]["name"];
							ftp_delete($conn_id,$tmp_upfile);
							//接続終了
							ftp_close($conn_id);
						}
						
	  				}else{
	   					//アップロードに失敗
						$file_err_flg = 1;
	  				}
				}else{
					//画像ファイルではない
					$file_err_flg = 2;
				}
			}else{
				//ファイルサイズが大きい
				$file_err_flg = 3;
			}

		}else{
			//ファイルが選択されていない
			$file_err_flg = 4;
		}
				
		if( $file_err_flg == 0 ){
			//変更前ファイル名
			$old_file = $_FILES["upfile"]["name"];
			//変更後ファイル名
			$new_file = $select_kaiin_no . '.jpeg';

			// 接続を確立する
			$conn_id = ftp_connect($ftp_server);
		
			if( !$conn_id ){
				//接続確立に失敗
				$file_err_flg = 1;
			
			}else{
				// ユーザ名とパスワードでログインする
				$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
				if( !$login_result ){
					//ログインに失敗
					$file_err_flg = 1;
				
				}else{
					//既に会員写真があった場合は削除する
					$tmp_file_del = './httpdocs/staff/' . $dir_kaiin_img . '/' . $new_file;
					if( file_exists( $tmp_file_del ) ){
						//画像削除
						if( !ftp_delete($conn_id,$tmp_file_del) ){
							//旧写真の削除に失敗
							$file_err_flg = 1;
						}
					}
	
					//画像名を会員番号に変える
					$tmp_file_old = './httpdocs/staff/' . $dir_kaiin_img . '/tmp/' . $old_file;
					$tmp_file_new = './httpdocs/staff/' . $dir_kaiin_img . '/' . $new_file;
					
					if( !ftp_rename($conn_id, $tmp_file_old, $tmp_file_new) ){
						//名前変更に失敗
						$file_err_flg = 1;
					}
				}
			}

			ftp_close($conn_id);
		}

		if( $file_err_flg == 0 ){
			//アップロード成功

			//**ログ出力**
			$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '会員の写真をアップロードしました。お客様番号[' . $select_kaiin_no . ']';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

			
			//***画面編集****************************************************************************************************
					
			print('<center>');

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td align="left" width="950">');	//main

			//会員番号・会員名
			print('<table border="0">');
			print('<tr>');
			//会員番号
			print('<td width="150" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_okyakusamano.png" border="0"><br>');
			print('<font size="5" color="blue">' . $select_kaiin_no . '</font>');
			if( $select_kaiin_mixi != "" ){
				//メンバー
				print('<br><font size="2">(' . $select_kaiin_mixi . ')</font>');
			}else{
				//一般（無料メンバー）
				print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
			}
			print('</td>');
			//会員名
			print('<td width="480" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_shimei.png" border="0"><br>');
			if( $select_kaiin_nm_k != '' && $select_kaiin_nm_k != '　' ){
				print('&nbsp;&nbsp;<font size="2" color="blue">' . $select_kaiin_nm_k . '</font><br>');
			}
			print('&nbsp;&nbsp;<font size="5" color="blue">' . $select_kaiin_nm . '</font>');						
			print('</td>');
			print('</tr>');	
			print('</table>');

			print('</td>');	//main
			print('</tr>');	//main
			print('<tr>');	//main
			print('<td align="center">');	//main

			//「アップロードが完了しました。」
			print('<img src="./img_' . $lang_cd . '/title_file_up_ok.png" border="0"><br>');
			
			print('<table border="0">');	//sub1
			print('<tr>');	//sub1
			//会員写真
			print('<td align="center" valign="top" width="350">');	//sub1

			$kaiin_img = './' . $dir_kaiin_img . '/' . $select_kaiin_no . '.jpeg';	//会員顔写真
			if( file_exists($kaiin_img) ) {
				//写真が見つかった
				$imglist = getimagesize( $kaiin_img );
				$img_width = $imglist[0];
				$img_height = $imglist[1];
				$img_type = $imglist[2];
				$edit_size = $imglist[3];
				if( $img_width > 320 && $img_height > 320 ){
					if( $img_width > $img_height ){
						$edit_size = 'width="320"';
					}else{
						$edit_size = 'height="320"';
					}
				}else if( $img_width > 320 && $img_height <= 320 ){
					$edit_size = 'width="320"';
				}else if( $img_width <= 320 && $img_height > 320 ){
					$edit_size = 'height="320"';
				}
				
				//「アップロードした写真」
				print('<img src="./img_' . $lang_cd . '/title_upload_fhoto.png" border="0"><br>');
				$kaiin_img .= '?' . $now_time;	//キャッシュ画像を表示させないため
				print('<img src=' . $kaiin_img . ' ' . $edit_size . '>');
			
			}else{
				//写真が見つからない
				print('<img src="./img_' . $lang_cd . '/kaiin_img_nothing.png" border="0">');
			}
			
			print('</td>');	//sub1
			print('<td align="center" valign="top" width="350">');	//sub1

			//写真アップロード
			print('<table border="0">');
			print('<tr>');
			print('<form enctype="multipart/form-data" action="kaiin_img_ksn2.php" method="POST">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
			print('<input type="hidden" name="select_kaiin_nm_k" value="' . $select_kaiin_nm_k . '">');
			print('<input type="hidden" name="select_kaiin_mixi" value="' . $select_kaiin_mixi . '">');
			print('<td width="350" align="center">');
			//「やり直す場合はこちらから」
			print('<img src="./img_' . $lang_cd . '/title_yarinaoshi.png" border="0"><br>');
			print('</td>');
			print('</tr>');
			print('<td>');
			//「① 写真を選択してください。(img_' . $lang_cd . 'のみ)」
			print('<img src="./img_' . $lang_cd . '/title_file_select_1.png" border="0">');
			print('</td>');
			print('</tr>');
			print('<tr>');
			print('<td align="center">');
			print('<input name="upfile" type="file" />');
			print('</td>');
			print('</tr>');
			print('<tr>');
			print('<td align="center">');
			//「↓」
			print('<img src="./img_' . $lang_cd . '/yajirushi_down.png" border="0">');
			print('</td>');
			print('</tr>');
			print('<tr>');
			print('<td align="left">');
			//「② 写真選択後、下のボタンを押下する。」
			print('<img src="./img_' . $lang_cd . '/title_file_select_2.png" border="0">');
			print('</td>');
			print('</tr>');
			print('<tr>');
			print('<td align="center">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_syashin_up_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_syashin_up_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_syashin_up_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('</td>');	//sub1
			print('</tr>');	//sub1
			print('</table>');	//sub1
			
			print('</td>');		//main
			print('</tr>');		//main
			print('</table>');	//main
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">');
			print('&nbsp;');
			print('</td>');
			print('<form method="post" action="./kaiin_kkn1.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="serch_flg" value="1">');
			print('<input type="hidden" name="lock_kaijyo_flg" value="0">');
			print('<input type="hidden" name="syosai_flg" value="0">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
			print('<input type="hidden" name="select_kaiin_mail" value="">');
			print('<input type="hidden" name="select_kaiin_tel" value="">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
				
			print('</center>');
				
			print('<hr>');
			
		}else{
			//アップロード失敗
			
			if( $file_err_flg == 1 ){
				//技術的に失敗した場合のみログ出力
			
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '会員の写真アップロードに失敗しました。お客様番号[' . $select_kaiin_no . ']';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			}
			
			//***画面編集****************************************************************************************************
					
			print('<center>');

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td align="left" width="950">');	//main

			//会員番号・会員名
			print('<table border="0">');
			print('<tr>');
			//会員番号
			print('<td width="150" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_okyakusamano.png" border="0"><br>');
			print('<font size="5" color="blue">' . $select_kaiin_no . '</font>');
			if( $select_kaiin_mixi != "" ){
				//メンバー
				print('<br><font size="2">(' . $select_kaiin_mixi . ')</font>');
			}else{
				//一般（無料メンバー）
				print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
			}
			print('</td>');
			//会員名
			print('<td width="480" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_shimei.png" border="0"><br>');
			if( $select_kaiin_nm_k != '' && $select_kaiin_nm_k != '　' ){
				print('&nbsp;&nbsp;<font size="2" color="blue">' . $select_kaiin_nm_k . '</font><br>');
			}
			print('&nbsp;&nbsp;<font size="5" color="blue">' . $select_kaiin_nm . '</font>');						
			print('</td>');
			print('</tr>');	
			print('</table>');

			print('</td>');	//main
			print('</tr>');	//main
			print('<tr>');	//main
			print('<td align="center">');	//main


			if( $file_err_flg == 1 ){
				//「アップロードに失敗しました。」
				print('<img src="./img_' . $lang_cd . '/title_file_up_ng_1.png" border="0"><br>');
			}else if( $file_err_flg == 2 ){
				//「画像ファイルではありません。」
				print('<img src="./img_' . $lang_cd . '/title_file_up_ng_2.png" border="0"><br>');
			}else if( $file_err_flg == 3 ){
				//「ファイルサイズが大きすぎます。」
				print('<img src="./img_' . $lang_cd . '/title_file_up_ng_3.png" border="0"><br>');
			}else if( $file_err_flg == 4 ){
				//「ファイルが選択されていません。」
				print('<img src="./img_' . $lang_cd . '/title_file_up_ng_4.png" border="0"><br>');
			}else if( $file_err_flg == 5 ){
				//「img_' . $lang_cd . 'ファイルではありません。」
				print('<img src="./img_' . $lang_cd . '/title_file_up_ng_5.png" border="0"><br>');			
			}

			print('<table border="0">');	//sub1
			print('<tr>');	//sub1
			//会員写真
			print('<td align="center" valign="top" width="350">');	//sub1
			//「現在登録されている写真」
			print('<img src="./img_' . $lang_cd . '/title_now_fhoto.png" border="0"><br>');

			$kaiin_img = './' . $dir_kaiin_img . '/' . $select_kaiin_no . '.jpeg';	//会員顔写真
			if( file_exists($kaiin_img) ) {
				//写真が見つかった
				$imglist = getimagesize( $kaiin_img );
				$img_width = $imglist[0];
				$img_height = $imglist[1];
				$img_type = $imglist[2];
				$edit_size = $imglist[3];
				if( $img_width > 320 && $img_height > 320 ){
					if( $img_width > $img_height ){
						$edit_size = 'width="320"';
					}else{
						$edit_size = 'height="320"';
					}
				}else if( $img_width > 320 && $img_height <= 320 ){
					$edit_size = 'width="320"';
				}else if( $img_width <= 320 && $img_height > 320 ){
					$edit_size = 'height="320"';
				}
				
				$kaiin_img .= '?' . $now_time;	//キャッシュ画像を表示させないため
				print('<img src=' . $kaiin_img . ' ' . $edit_size . '>');
			
			}else{
				//写真が見つからない
				print('<img src="./img_' . $lang_cd . '/kaiin_img_nothing_320x240.png" border="0">');
			}
			
			print('</td>');	//sub1
			print('<td align="center" valign="top" width="350">');	//sub1

			if( $file_err_flg == 1 ){
				//技術的に失敗した場合は やりなおしできない。
				
				//「ご迷惑おかけしております」
				print('<img src="./img_' . $lang_cd . '/title_chousa.png" border="0">');
				
			}else{
				
				//写真アップロード
				print('<table border="0">');
				print('<tr>');
				print('<form enctype="multipart/form-data" action="kaiin_img_ksn2.php" method="POST">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
				print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
				print('<input type="hidden" name="select_kaiin_nm_k" value="' . $select_kaiin_nm_k . '">');
				print('<input type="hidden" name="select_kaiin_mixi" value="' . $select_kaiin_mixi . '">');
				print('<td width="350" align="center">');
				//「やり直す場合はこちらから」
				print('<img src="./img_' . $lang_cd . '/title_yarinaoshi.png" border="0"><br>');
				print('</td>');
				print('</tr>');
				print('<td>');
				//「① 写真を選択してください。(img_' . $lang_cd . 'のみ)」
				print('<img src="./img_' . $lang_cd . '/title_file_select_1.png" border="0">');
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center">');
				print('<input name="upfile" type="file" />');
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center">');
				//「↓」
				print('<img src="./img_' . $lang_cd . '/yajirushi_down.png" border="0">');
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="left">');
				//「② 写真選択後、下のボタンを押下する。」
				print('<img src="./img_' . $lang_cd . '/title_file_select_2.png" border="0">');
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_syashin_up_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_syashin_up_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_syashin_up_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
			
			}

			print('</td>');	//sub1
			print('</tr>');	//sub1
			print('</table>');	//sub1
			
			print('</td>');		//main
			print('</tr>');		//main
			print('</table>');	//main
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">');
			print('&nbsp;');
			print('</td>');
			print('<form method="post" action="./kaiin_kkn1.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="serch_flg" value="1">');
			print('<input type="hidden" name="lock_kaijyo_flg" value="0">');
			print('<input type="hidden" name="syosai_flg" value="0">');
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
			print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
			print('<input type="hidden" name="select_kaiin_mail" value="">');
			print('<input type="hidden" name="select_kaiin_tel" value="">');
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

	mysql_close( $link );

?>

</body>
</html>
