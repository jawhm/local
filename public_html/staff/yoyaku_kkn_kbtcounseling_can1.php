<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング予約一覧　キャンセル</title>
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
	$gmn_id = 'yoyaku_kkn_kbtcounseling_can1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('yoyaku_kkn_kbtcounseling_kkn.php');

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
	$select_ymd = $_POST['select_ymd'];
	$select_yyk_no = $_POST['select_yyk_no'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_ymd == "" || $select_yyk_no == "" ){
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
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_cancel_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );


		//予約内容を読み込む
		$zz_yykinfo_yyk_no = $select_yyk_no;
		require( '../zz_yykinfo.php' );
		if( $zz_yykinfo_rtncd == 1 ){
			$err_flg = 4;
			
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
			$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
			require( './zs_log.php' );
			//************

		}else if( $zz_yykinfo_rtncd == 8 ){
			//予約が無い
			$err_flg = 5;

		}
		

		if( $err_flg == 0 ){
			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_yykkkn_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="135" align="left">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kbtcounseling_syosai.png" border="0"></td>');
			//戻るボタン
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
	
			//「キャンセルしてもよろしいですか？」
			print('<img src="./img_' . $lang_cd . '/title_cancel_kkn.png" border="0"><br>');
			
			//年月日表示
			if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_eigyoubi_flg == 9 ){
				//祝日
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 0 ){
				//日曜
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 6 ){
				//土曜
				$fontcolor = "blue";
			}else{
				//平日
				$fontcolor = "black";
			}
			
			
			//背景色
			if( $zz_yykinfo_ymd > $now_yyyymmdd2 || ($zz_yykinfo_ymd == $now_yyyymmdd2 && $zz_yykinfo_st_time > ($now_hh * 100 + $now_ii) )){
				//未来
				$bgfile_1 = "mizu";
				$bgcolor_1 = "#d6fafa";
			}else{
				//過去
				$bgfile_1 = "lightgrey";
				$bgcolor_1 = "#d3d3d3";
			}
			
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				//仮登録
				$bgfile_2 = "yellow";
				$bgcolor_2 = "#fffa6e";
			}else if( $zz_yykinfo_kaiin_kbn == 1 ){
				//メンバー
				$bgfile_2 = "kimidori";
				$bgcolor_2 = "#aefd9f";
			}else if( $zz_yykinfo_kaiin_kbn == 9 ){
				//非メンバー（一般）
				$bgfile_2 = "pink";
				$bgcolor_2 = "#ffc0cb";
			}
			
			print('<table border="1">');
			//予約番号／ステータス
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="6" color="blue">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_status.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png">');
			if( $zz_yykinfo_status == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_status == 0 ){
				print('<font size="4" color="blue">本人登録</font>');
			}else if( $zz_yykinfo_status == 1 ){
				print('<font size="4" color="blue">スタッフ受付</font><font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');
			}else if( $zz_yykinfo_status == 2 ){
				print('<font size="4" color="red">非来店</font>');
			}else if( $zz_yykinfo_status == 3 ){
				print('<font size="4" color="blue">来店</font>');
			}else if( $zz_yykinfo_status == 8 ){
				print('<font size="4" color="blue">本人キャンセル</font>');
			}else if( $zz_yykinfo_status == 9 ){
				print('<font size="4" color="blue">スタッフキャンセル</font>');
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('</tr>');
			
			//日時
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
			print('<td colspan="3" align="center" valign="middle" bgcolor="' . $bgcolor_1 . '"><font size="6" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;年&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;月&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2))  . '</font><font size="2" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' .  intval( $zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_ed_time % 100 )) . '</font></td>');
			print('</tr>');

			//会場／カウンセラー
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="4" color="blue">' . $zz_yykinfo_office_nm . '</font></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png">');
			if( $zz_yykinfo_staff_nm == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else{
				print('<font size="4" color="blue">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_staff_nm . ')</font>');
			}
			print('</td>');
			print('</tr>');
			
			//お客様番号／氏名
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				print('<font size="5" color="blue">' . $zz_yykinfo_kaiin_id . '</font>');
				if( $zz_yykinfo_kaiin_kbn == 1 ){
					//メンバー
					print('<br><font size="2">(' . $zz_yykinfo_kaiin_mixi . ')</font>');
				}else if( $zz_yykinfo_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
				}
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="middle">');
				if( $zz_yykinfo_kaiin_nm_k != "" &&  $zz_yykinfo_kaiin_nm_k != "　" ){
					print('<font size="2" color="blue">' . $zz_yykinfo_kaiin_nm_k . '</font><br>');
				}
				print('<font size="4" color="blue">' . $zz_yykinfo_kaiin_nm . '</font>');
				print('</td>');
				print('<td valign="bottom"><font size="2">様</font></td>');
				print('</tr>');
				print('</table>');
				
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('</tr>');

			//興味のある国／出発予定時期
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
//			if( $zz_yykinfo_kyoumi != "" ){
//				print('<font color="blue">' . $zz_yykinfo_kyoumi . '</font>');
//			}else{
//				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
//			if( $zz_yykinfo_jiki != "" ){
//				print('<font color="blue">' . $zz_yykinfo_jiki . '</font>');
//			}else{
//				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('</tr>');

			//相談内容
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
			print('<td colspan="3" align="left" valign="middle" bgcolor="' . $bgcolor_2 . '">');
			if( $zz_yykinfo_soudan != "" ){
				print('<font color="blue"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
			}else{
				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}
			print('</td>');
			print('</tr>');
			
			//前日メール／当日メール
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_znjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_znz_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_znz_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_znz_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_tjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_tjt_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_tjt_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_tjt_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('</tr>');
			
			//予約日時／キャンセル可能期限
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yyktime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">' . $zz_yykinfo_yyk_time . '</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_canceltime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">' . $zz_yykinfo_cancel_time . '</td>');
			print('</tr>');

			print('</table>');


			print('<table border="0">');
			print('<tr>');
			print('<td width="670">&nbsp;</td>');
			//キャンセル
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_can2.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="150" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cancel_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cancel_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cancel_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<hr>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
	
			print('</center>');
				
			print('<hr>');
		
		
		}else if( $err_flg == 5 ){
			//既に予約キャンセルされている
			
			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_yykkkn_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="135" align="left">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kbtcounseling_syosai.png" border="0"></td>');
			//戻るボタン
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . substr($zz_yykinfo_ymd,0,4) . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
			
			print('<br>');
			
			//「この予約はキャンセル済みです。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_delzumi.png" border="0"><br>');

			print('<table border="1">');
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="6" color="gray">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('</tr>');
			print('</table>');
			
			print('<br><br><br><br><br><br><br><br>');
			
			print('<hr>');
			
			print('</center>');
			
		}
	}

	mysql_close( $link );

	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>
</body>
</html>