<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－営業時間（更新）確認</title>
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
	$gmn_id = 'kanri_eigyojkn_ksn1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_eigyojkn_ksn0.php','kanri_eigyojkn_ksn1.php');

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
	$select_st_date = $_POST['select_st_date'];		//開始日
	$select_ed_date = $_POST['select_ed_date'];		//終了日
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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_st_date == "" || $select_ed_date == "" ){
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
		$teikyu_0 = $_POST['teikyu_0'];					//定休日チェックボックス（日曜） 'on':チェックあり
		$tnp_st_time_0 = $_POST['tnp_st_time_0'];		//開店時刻（日曜）
		$tnp_ed_time_0 = $_POST['tnp_ed_time_0'];		//閉店時刻（日曜）
		$teikyu_1 = $_POST['teikyu_1'];					//定休日チェックボックス（月曜） 'on':チェックあり
		$tnp_st_time_1 = $_POST['tnp_st_time_1'];		//開店時刻（月曜）
		$tnp_ed_time_1 = $_POST['tnp_ed_time_1'];		//閉店時刻（月曜）
		$teikyu_2 = $_POST['teikyu_2'];					//定休日チェックボックス（火曜） 'on':チェックあり
		$tnp_st_time_2 = $_POST['tnp_st_time_2'];		//開店時刻（火曜）
		$tnp_ed_time_2 = $_POST['tnp_ed_time_2'];		//閉店時刻（火曜）
		$teikyu_3 = $_POST['teikyu_3'];					//定休日チェックボックス（水曜） 'on':チェックあり
		$tnp_st_time_3 = $_POST['tnp_st_time_3'];		//開店時刻（水曜）
		$tnp_ed_time_3 = $_POST['tnp_ed_time_3'];		//閉店時刻（水曜）
		$teikyu_4 = $_POST['teikyu_4'];					//定休日チェックボックス（木曜） 'on':チェックあり
		$tnp_st_time_4 = $_POST['tnp_st_time_4'];		//開店時刻（木曜）
		$tnp_ed_time_4 = $_POST['tnp_ed_time_4'];		//閉店時刻（木曜）
		$teikyu_5 = $_POST['teikyu_5'];					//定休日チェックボックス（金曜） 'on':チェックあり
		$tnp_st_time_5 = $_POST['tnp_st_time_5'];		//開店時刻（金曜）
		$tnp_ed_time_5 = $_POST['tnp_ed_time_5'];		//閉店時刻（金曜）
		$teikyu_6 = $_POST['teikyu_6'];					//定休日チェックボックス（土曜） 'on':チェックあり
		$tnp_st_time_6 = $_POST['tnp_st_time_6'];		//開店時刻（土曜）
		$tnp_ed_time_6 = $_POST['tnp_ed_time_6'];		//閉店時刻（土曜）
		$teikyu_7 = $_POST['teikyu_7'];					//定休日チェックボックス（土日祝の前日） 'on':チェックあり
		$tnp_st_time_7 = $_POST['tnp_st_time_7'];		//開店時刻（土日祝の前日）
		$tnp_ed_time_7 = $_POST['tnp_ed_time_7'];		//閉店時刻（土日祝の前日）
		$teikyu_8 = $_POST['teikyu_8'];					//定休日チェックボックス（祝日） 'on':チェックあり
		$tnp_st_time_8 = $_POST['tnp_st_time_8'];		//開店時刻（祝日）
		$tnp_ed_time_8 = $_POST['tnp_ed_time_8'];		//閉店時刻（祝日）
		$yukou_flg = $_POST['yukou_flg'];	//有効フラグ
		$st_year = $_POST['st_year'];		//開始年
		$st_month = $_POST['st_month'];		//開始月
		$st_day = $_POST['st_day'];			//開始日
		$ed_year = $_POST['ed_year'];		//終了年
		$ed_month = $_POST['ed_month'];		//終了月
		$ed_day = $_POST['ed_day'];			//終了日

		$err_cnt = 0;	//エラー件数

		//引数チェック
		if( $lock_flg == 0 ){
			//定休日フラグ・開店時刻・閉店時刻（日曜）
			$err_teikyu_0 = 0;
			$err_tnp_st_time_0 = 0;
			$err_tnp_ed_time_0 = 0;
			if( $teikyu_0 == 'on' ){
				if( $tnp_st_time_0 != '' || $tnp_ed_time_0 != '' ){
					$err_teikyu_0 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_0 ) == 0 ){
					$err_tnp_st_time_0 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_0 ) ){
					$div = intval($tnp_st_time_0 / 100);
					$mod = $tnp_st_time_0 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_0 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_0 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_0 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_0 ) == 0 ){
					$err_tnp_ed_time_0 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_0 ) ){
					$div = intval($tnp_ed_time_0 / 100);
					$mod = $tnp_ed_time_0 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_0 = $tnp_ed_time_0 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_0 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_0 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_0 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_0 == 0 && $err_tnp_ed_time_0 == 0 ){
					if( $tnp_st_time_0 >= $tnp_ed_time_0 ){
						$err_tnp_ed_time_0 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（月曜）
			$err_teikyu_1 = 0;
			$err_tnp_st_time_1 = 0;
			$err_tnp_ed_time_1 = 0;
			if( $teikyu_1 == 'on' ){
				if( $tnp_st_time_1 != '' || $tnp_ed_time_1 != '' ){
					$err_teikyu_1 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_1 ) == 0 ){
					$err_tnp_st_time_1 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_1 ) ){
					$div = intval($tnp_st_time_1 / 100);
					$mod = $tnp_st_time_1 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_1 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_1 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_1 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_1 ) == 0 ){
					$err_tnp_ed_time_1 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_1 ) ){
					$div = intval($tnp_ed_time_1 / 100);
					$mod = $tnp_ed_time_1 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_1 = $tnp_ed_time_1 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_1 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_1 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_1 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_1 == 0 && $err_tnp_ed_time_1 == 0 ){
					if( $tnp_st_time_1 >= $tnp_ed_time_1 ){
						$err_tnp_ed_time_1 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（火曜）
			$err_teikyu_2 = 0;
			$err_tnp_st_time_2 = 0;
			$err_tnp_ed_time_2 = 0;
			if( $teikyu_2 == 'on' ){
				if( $tnp_st_time_2 != '' || $tnp_ed_time_2 != '' ){
					$err_teikyu_2 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_2 ) == 0 ){
					$err_tnp_st_time_2 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_2 ) ){
					$div = intval($tnp_st_time_2 / 100);
					$mod = $tnp_st_time_2 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_2 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_2 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_2 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_2 ) == 0 ){
					$err_tnp_ed_time_2 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_2 ) ){
					$div = intval($tnp_ed_time_2 / 100);
					$mod = $tnp_ed_time_2 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_2 = $tnp_ed_time_2 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_2 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_2 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_2 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_2 == 0 && $err_tnp_ed_time_2 == 0 ){
					if( $tnp_st_time_2 >= $tnp_ed_time_2 ){
						$err_tnp_ed_time_2 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（水曜）
			$err_teikyu_3 = 0;
			$err_tnp_st_time_3 = 0;
			$err_tnp_ed_time_3 = 0;
			if( $teikyu_3 == 'on' ){
				if( $tnp_st_time_3 != '' || $tnp_ed_time_3 != '' ){
					$err_teikyu_3 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_3 ) == 0 ){
					$err_tnp_st_time_3 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_3 ) ){
					$div = intval($tnp_st_time_3 / 100);
					$mod = $tnp_st_time_3 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_3 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_3 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_3 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_3 ) == 0 ){
					$err_tnp_ed_time_3 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_3 ) ){
					$div = intval($tnp_ed_time_3 / 100);
					$mod = $tnp_ed_time_3 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_3 = $tnp_ed_time_3 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_3 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_3 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_3 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_3 == 0 && $err_tnp_ed_time_3 == 0 ){
					if( $tnp_st_time_3 >= $tnp_ed_time_3 ){
						$err_tnp_ed_time_3 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（木曜）
			$err_teikyu_4 = 0;
			$err_tnp_st_time_4 = 0;
			$err_tnp_ed_time_4 = 0;
			if( $teikyu_4 == 'on' ){
				if( $tnp_st_time_4 != '' || $tnp_ed_time_4 != '' ){
					$err_teikyu_4 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_4 ) == 0 ){
					$err_tnp_st_time_4 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_4 ) ){
					$div = intval($tnp_st_time_4 / 100);
					$mod = $tnp_st_time_4 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_4 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_4 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_4 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_4 ) == 0 ){
					$err_tnp_ed_time_4 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_4 ) ){
					$div = intval($tnp_ed_time_4 / 100);
					$mod = $tnp_ed_time_4 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_4 = $tnp_ed_time_4 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_4 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_4 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_4 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_4 == 0 && $err_tnp_ed_time_4 == 0 ){
					if( $tnp_st_time_4 >= $tnp_ed_time_4 ){
						$err_tnp_ed_time_4 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（金曜）
			$err_teikyu_5 = 0;
			$err_tnp_st_time_5 = 0;
			$err_tnp_ed_time_5 = 0;
			if( $teikyu_5 == 'on' ){
				if( $tnp_st_time_5 != '' || $tnp_ed_time_5 != '' ){
					$err_teikyu_5 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_5 ) == 0 ){
					$err_tnp_st_time_5 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_5 ) ){
					$div = intval($tnp_st_time_5 / 100);
					$mod = $tnp_st_time_5 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_5 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_5 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_5 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_5 ) == 0 ){
					$err_tnp_ed_time_5 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_5 ) ){
					$div = intval($tnp_ed_time_5 / 100);
					$mod = $tnp_ed_time_5 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_5 = $tnp_ed_time_5 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_5 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_5 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_5 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_5 == 0 && $err_tnp_ed_time_5 == 0 ){
					if( $tnp_st_time_5 >= $tnp_ed_time_5 ){
						$err_tnp_ed_time_5 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（土曜）
			$err_teikyu_6 = 0;
			$err_tnp_st_time_6 = 0;
			$err_tnp_ed_time_6 = 0;
			if( $teikyu_6 == 'on' ){
				if( $tnp_st_time_6 != '' || $tnp_ed_time_6 != '' ){
					$err_teikyu_6 = 1;
					$err_cnt++;
				}
			}else{
				//開店時刻
				if( strlen( $tnp_st_time_6 ) == 0 ){
					$err_tnp_st_time_6 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_st_time_6 ) ){
					$div = intval($tnp_st_time_6 / 100);
					$mod = $tnp_st_time_6 % 100;
					if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
						$err_tnp_st_time_6 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_st_time_6 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_st_time_6 = 1;
					$err_cnt++;
				}
				//閉店時刻
				if( strlen( $tnp_ed_time_6 ) == 0 ){
					$err_tnp_ed_time_6 = 1;
					$err_cnt++;
			
				}else if( is_numeric( $tnp_ed_time_6 ) ){
					$div = intval($tnp_ed_time_6 / 100);
					$mod = $tnp_ed_time_6 % 100;
					if( $div < 10 ){
						$div = $div + 24;	//１０時未満の入力は２４時間を加算する
						$tnp_ed_time_6 = $tnp_ed_time_6 + 2400;
					}
					if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
						$err_tnp_ed_time_6 = 1;
						$err_cnt++;
					}
					if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
						$err_tnp_ed_time_6 = 1;
						$err_cnt++;
					}
	
				}else{
					$err_tnp_ed_time_6 = 1;
					$err_cnt++;
				}
				//開店時間と閉店時間の比較チェック
				if( $err_tnp_st_time_6 == 0 && $err_tnp_ed_time_6 == 0 ){
					if( $tnp_st_time_6 >= $tnp_ed_time_6 ){
						$err_tnp_ed_time_6 = 1;
						$err_cnt++;
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（土日祝の前日）
			$err_teikyu_7 = 0;
			$err_tnp_st_time_7 = 0;
			$err_tnp_ed_time_7 = 0;
			if( $teikyu_7 == 'on' ){
				if( $tnp_st_time_7 != '' || $tnp_ed_time_7 != '' ){
					$err_teikyu_7 = 1;
					$err_cnt++;
				}
			}else{
				if( $tnp_st_time_7 != '' || $tnp_ed_time_7 != '' ){
					//開店時刻
					if( strlen( $tnp_st_time_7 ) == 0 ){
						$err_tnp_st_time_7 = 1;
						$err_cnt++;
			
					}else if( is_numeric( $tnp_st_time_7 ) ){
						$div = intval($tnp_st_time_7 / 100);
						$mod = $tnp_st_time_7 % 100;
						if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
							$err_tnp_st_time_7 = 1;
							$err_cnt++;
						}
						if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
							$err_tnp_st_time_7 = 1;
							$err_cnt++;
						}
	
					}else{
						$err_tnp_st_time_7 = 1;
						$err_cnt++;
					}
					//閉店時刻
					if( strlen( $tnp_ed_time_7 ) == 0 ){
						$err_tnp_ed_time_7 = 1;
						$err_cnt++;
				
					}else if( is_numeric( $tnp_ed_time_7 ) ){
						$div = intval($tnp_ed_time_7 / 100);
						$mod = $tnp_ed_time_7 % 100;
						if( $div < 10 ){
							$div = $div + 24;	//１０時未満の入力は２４時間を加算する
							$tnp_ed_time_7 = $tnp_ed_time_7 + 2400;
						}
						if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
							$err_tnp_ed_time_7 = 1;
							$err_cnt++;
						}
						if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
							$err_tnp_ed_time_7 = 1;
							$err_cnt++;
						}
	
					}else{
						$err_tnp_ed_time_7 = 1;
						$err_cnt++;
					}
					//開店時間と閉店時間の比較チェック
					if( $err_tnp_st_time_7 == 0 && $err_tnp_ed_time_7 == 0 ){
						if( $tnp_st_time_7 >= $tnp_ed_time_7 ){
							$err_tnp_ed_time_7 = 1;
							$err_cnt++;
						}
					}
				}
			}
	
			//定休日フラグ・開店時刻・閉店時刻（祝日）
			$err_teikyu_8 = 0;
			$err_tnp_st_time_8 = 0;
			$err_tnp_ed_time_8 = 0;
			if( $teikyu_8 == 'on' ){
				if( $tnp_st_time_8 != '' || $tnp_ed_time_8 != '' ){
					$err_teikyu_8 = 1;
					$err_cnt++;
				}
			}else{
				if( $tnp_st_time_8 != '' || $tnp_ed_time_8 != '' ){
					//開店時刻
					if( strlen( $tnp_st_time_8 ) == 0 ){
						$err_tnp_st_time_8 = 1;
						$err_cnt++;
				
					}else if( is_numeric( $tnp_st_time_8 ) ){
						$div = intval($tnp_st_time_8 / 100);
						$mod = $tnp_st_time_8 % 100;
						if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
							$err_tnp_st_time_8 = 1;
							$err_cnt++;
						}
						if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
							$err_tnp_st_time_8 = 1;
							$err_cnt++;
						}
	
					}else{
						$err_tnp_st_time_8 = 1;
						$err_cnt++;
					}
					//閉店時刻
					if( strlen( $tnp_ed_time_8 ) == 0 ){
						$err_tnp_ed_time_8 = 1;
						$err_cnt++;
				
					}else if( is_numeric( $tnp_ed_time_8 ) ){
						$div = intval($tnp_ed_time_8 / 100);
						$mod = $tnp_ed_time_8 % 100;
						if( $div < 10 ){
							$div = $div + 24;	//１０時未満の入力は２４時間を加算する
							$tnp_ed_time_8 = $tnp_ed_time_8 + 2400;
						}
						if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
							$err_tnp_ed_time_8 = 1;
							$err_cnt++;
						}
						if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
							$err_tnp_ed_time_8 = 1;
							$err_cnt++;
						}
		
					}else{
						$err_tnp_ed_time_8 = 1;
						$err_cnt++;
					}
					//開店時間と閉店時間の比較チェック
					if( $err_tnp_st_time_8 == 0 && $err_tnp_ed_time_8 == 0 ){
						if( $tnp_st_time_8 >= $tnp_ed_time_8 ){
							$err_tnp_ed_time_8 = 1;
							$err_cnt++;
						}
					}
				}
			}
		
		}else{
			$err_teikyu_0 = 0;
			$err_tnp_st_time_0 = 0;
			$err_tnp_ed_time_0 = 0;
			$err_teikyu_1 = 0;
			$err_tnp_st_time_1 = 0;
			$err_tnp_ed_time_1 = 0;
			$err_teikyu_2 = 0;
			$err_tnp_st_time_2 = 0;
			$err_tnp_ed_time_2 = 0;
			$err_teikyu_3 = 0;
			$err_tnp_st_time_3 = 0;
			$err_tnp_ed_time_3 = 0;
			$err_teikyu_4 = 0;
			$err_tnp_st_time_4 = 0;
			$err_tnp_ed_time_4 = 0;
			$err_teikyu_5 = 0;
			$err_tnp_st_time_5 = 0;
			$err_tnp_ed_time_5 = 0;
			$err_teikyu_6 = 0;
			$err_tnp_st_time_6 = 0;
			$err_tnp_ed_time_6 = 0;
			$err_teikyu_7 = 0;
			$err_tnp_st_time_7 = 0;
			$err_tnp_ed_time_7 = 0;
			$err_teikyu_8 = 0;
			$err_tnp_st_time_8 = 0;
			$err_tnp_ed_time_8 = 0;

		}
		
		//有効期間（開始年月日）
		if( $st_year == '' && $st_month == '' && $st_day == '' ){
			//未入力時は本日日付をセットする
			$st_year = $now_yyyy;
			$st_month = sprintf("%d",$now_mm);
			$st_day = sprintf("%d",$now_dd);
		}
		
		$err_st_year = 0;
		if($st_year == ''){
			$err_st_year = 1;
			$err_cnt++;
		}else if(!ereg('[0-9]{4}',$st_year)){
			$err_st_year = 1;
			$err_cnt++;
		}else if( $st_year < 2011 || $st_year >= 2038 ){
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
		}else if( $ed_year < $now_yyyy || $ed_year >= 2038 ){
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
		
		//有効期間の重複チェック
		if( $err_cnt == 0 ){
			//現在登録されている開始日・終了日を求める
			$query = 'select distinct(ST_DATE),ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and ST_DATE != "' . $select_st_date . '" order by ST_DATE;';
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
				$log_naiyou = '営業時間マスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				$trk_cnt = 0;
				while( $row = mysql_fetch_array($result)){
					$trk_st_date[$trk_cnt] = substr( $row[0],0,4) . substr( $row[0],5,2) . substr( $row[0],8,2);
					$trk_ed_date[$trk_cnt] = substr( $row[1],0,4) . substr( $row[1],5,2) . substr( $row[1],8,2);
					$trk_cnt++;					
				}
				
				//今回登録予定の有効期間を配列に含める
				$tmp_st_date = $st_year . sprintf("%02d",$st_month) . sprintf("%02d",$st_day);
				$tmp_ed_date = $ed_year . sprintf("%02d",$ed_month) . sprintf("%02d",$ed_day);

				$i = 0;
				while( $i < $trk_cnt ){
					//開始日が他の有効期間に含まれる
					if( $trk_st_date[$i] <= $tmp_st_date && $tmp_st_date <= $trk_ed_date[$i] ){
						$err_st_year = 2;
						$err_st_month = 2;
						$err_st_day = 2;
						$err_cnt++;
					}
					//終了日が他の有効期間に含まれる
					if( $trk_st_date[$i] <= $tmp_ed_date && $tmp_ed_date <= $trk_ed_date[$i] ){
						$err_ed_year = 2;
						$err_ed_month = 2;
						$err_ed_day = 2;
						$err_cnt++;
					}
					$i++;
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
			
			//明細データにエラーがあるか？
			if( $err_cnt == 0 ){
				//エラーなし
				
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_eigyojkn.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_eigyojkn_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="teikyu_0" value="' . $teikyu_0 . '">');
				print('<input type="hidden" name="tnp_st_time_0" value="' . $tnp_st_time_0 . '">');
				print('<input type="hidden" name="tnp_ed_time_0" value="' . $tnp_ed_time_0 . '">');
				print('<input type="hidden" name="teikyu_1" value="' . $teikyu_1 . '">');
				print('<input type="hidden" name="tnp_st_time_1" value="' . $tnp_st_time_1 . '">');
				print('<input type="hidden" name="tnp_ed_time_1" value="' . $tnp_ed_time_1 . '">');
				print('<input type="hidden" name="teikyu_2" value="' . $teikyu_2 . '">');
				print('<input type="hidden" name="tnp_st_time_2" value="' . $tnp_st_time_2 . '">');
				print('<input type="hidden" name="tnp_ed_time_2" value="' . $tnp_ed_time_2 . '">');
				print('<input type="hidden" name="teikyu_3" value="' . $teikyu_3 . '">');
				print('<input type="hidden" name="tnp_st_time_3" value="' . $tnp_st_time_3 . '">');
				print('<input type="hidden" name="tnp_ed_time_3" value="' . $tnp_ed_time_3 . '">');
				print('<input type="hidden" name="teikyu_4" value="' . $teikyu_4 . '">');
				print('<input type="hidden" name="tnp_st_time_4" value="' . $tnp_st_time_4 . '">');
				print('<input type="hidden" name="tnp_ed_time_4" value="' . $tnp_ed_time_4 . '">');
				print('<input type="hidden" name="teikyu_5" value="' . $teikyu_5 . '">');
				print('<input type="hidden" name="tnp_st_time_5" value="' . $tnp_st_time_5 . '">');
				print('<input type="hidden" name="tnp_ed_time_5" value="' . $tnp_ed_time_5 . '">');
				print('<input type="hidden" name="teikyu_6" value="' . $teikyu_6 . '">');
				print('<input type="hidden" name="tnp_st_time_6" value="' . $tnp_st_time_6 . '">');
				print('<input type="hidden" name="tnp_ed_time_6" value="' . $tnp_ed_time_6 . '">');
				print('<input type="hidden" name="teikyu_7" value="' . $teikyu_7 . '">');
				print('<input type="hidden" name="tnp_st_time_7" value="' . $tnp_st_time_7 . '">');
				print('<input type="hidden" name="tnp_ed_time_7" value="' . $tnp_ed_time_7 . '">');
				print('<input type="hidden" name="teikyu_8" value="' . $teikyu_8 . '">');
				print('<input type="hidden" name="tnp_st_time_8" value="' . $tnp_st_time_8 . '">');
				print('<input type="hidden" name="tnp_ed_time_8" value="' . $tnp_ed_time_8 . '">');
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
				
				print('<font color="blue">※以下の内容でよろしければ登録ボタンを押下してください。</font><br><font color="red" size="2">（まだ登録されていません。）</font><br>');
				
				//開店時刻・閉店時刻
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('<font size="4"><b>開始時刻・終了時刻(*)</b></font>・・・オフィス営業時間<br>');
				print('<font size="2">※９時００分の場合は&nbsp;<font color="red">900</font> 、１２時３０分の場合は&nbsp;<font color="red">1230</font>、２３時００分の場合は&nbsp;<font color="red">2300</font>&nbsp;と入力してください</font><br>');
				print('<font size="2">※定休日の場合はチェックを入れてください（ただし、実際の営業日・非営業日はカレンダーの設定で判断します）</font><br>');
				print('<font size="2">※「土日祝の前日」「祝日」に時間を入力しない場合は、各曜日の時間と同様と判断します</font><br>');
				
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td>');
				
				print('<table border="1">');
				print('<tr>');
				print('<td width="80" align="center" bgcolor="powderblue">曜日</td>');
				print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
				print('<td width="20" align="center" bgcolor="powderblue">～</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
				print('<td width="110" align="center" bgcolor="powderblue">曜日</td>');
				print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
				print('<td width="20" align="center" bgcolor="powderblue">～</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
				print('</tr>');
				//月曜・土曜
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">月曜</td>');
				if( $teikyu_1 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_1 / 100);
					$mod = $tnp_st_time_1 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					$div = intval($tnp_ed_time_1 / 100);
					$mod = $tnp_ed_time_1 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_110x20.png">土曜</td>');
				if( $teikyu_6 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_6 / 100);
					$mod = $tnp_st_time_6 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_20x20.png">～</td>');
					$div = intval($tnp_ed_time_6 / 100);
					$mod = $tnp_ed_time_6 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('</tr>');
				//火曜・日曜
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">火曜</td>');
				if( $teikyu_2 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_2 / 100);
					$mod = $tnp_st_time_2 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					$div = intval($tnp_ed_time_2 / 100);
					$mod = $tnp_ed_time_2 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_110x20.png">日曜</td>');
				if( $teikyu_0 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_0 / 100);
					$mod = $tnp_st_time_0 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_20x20.png">～</td>');
					$div = intval($tnp_ed_time_0 / 100);
					$mod = $tnp_ed_time_0 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('</tr>');
				//水曜・土日祝の前日
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">水曜</td>');
				if( $teikyu_3 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_3 / 100);
					$mod = $tnp_st_time_3 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					$div = intval($tnp_ed_time_3 / 100);
					$mod = $tnp_ed_time_3 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><font size="2">土日祝の前日</font></td>');
				if( $teikyu_7 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png">&nbsp;</td>');
				}else{
					if( $tnp_st_time_7 == '' && $tnp_ed_time_7 == '' ){
						print('<td align="center" colspan="4" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="blue">各曜日の時間と同様</font></td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_7 / 100);
						$mod = $tnp_st_time_7 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_20x20.png">～</td>');
						$div = intval($tnp_ed_time_7 / 100);
						$mod = $tnp_ed_time_7 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
				}
				print('</tr>');
				//木曜・祝日
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">木曜</td>');
				print('<input type="hidden" name="teikyu_4" value="' . $teikyu_4 . '">');
				print('<input type="hidden" name="tnp_st_time_4" value="' . $tnp_st_time_4 . '">');
				print('<input type="hidden" name="tnp_ed_time_4" value="' . $tnp_ed_time_4 . '">');
				if( $teikyu_4 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_4 / 100);
					$mod = $tnp_st_time_4 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					$div = intval($tnp_ed_time_4 / 100);
					$mod = $tnp_ed_time_4 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_110x20.png">祝日</td>');
				if( $teikyu_8 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png">&nbsp;</td>');
				}else{
					if( $tnp_st_time_8 == '' && $tnp_ed_time_8 == '' ){
						print('<td align="center" colspan="4" background="../img_' . $lang_cd . '/bg_mura_235x20.png"><font size="2" color="blue">各曜日の時間と同様</font></td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_8 / 100);
						$mod = $tnp_st_time_8 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_20x20.png">～</td>');
						$div = intval($tnp_ed_time_8 / 100);
						$mod = $tnp_ed_time_8 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
				}
				print('</tr>');
				//金曜
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">金曜</td>');
				if( $teikyu_5 == 'on' ){
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
					$div = intval($tnp_st_time_5 / 100);
					$mod = $tnp_st_time_5 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
					$div = intval($tnp_ed_time_5 / 100);
					$mod = $tnp_ed_time_5 % 100;
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
				}
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('</tr>');
				print('</table>');
				
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<br>');

				//有効期間
				print('<b>有効期間(*)</b>・・・上記営業時間の有効期間<br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('開始日<br>');
				print('<font color="blue" size="5"><b>' . $st_year . '</b></font>');
				print('年');
				print('<font color="blue" size="5"><b>' . $st_month . '</b></font>');
				print('月');
				print('<font color="blue" size="5"><b>' . $st_day . '</b></font>');
				print('日 から');
				print('</td>');
				print('<td align="left">');
				print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
				print('<font color="blue" size="5"><b>' . $ed_year . '</b></font>');
				print('年');
				print('<font color="blue" size="5"><b>' . $ed_month . '</b></font>');
				print('月');
				print('<font color="blue" size="5"><b>' . $ed_day . '</b></font>');
				print('日 まで');
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
				print('<form method="post" action="kanri_eigyojkn_ksn2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="teikyu_0" value="' . $teikyu_0 . '">');
				print('<input type="hidden" name="tnp_st_time_0" value="' . $tnp_st_time_0 . '">');
				print('<input type="hidden" name="tnp_ed_time_0" value="' . $tnp_ed_time_0 . '">');
				print('<input type="hidden" name="teikyu_1" value="' . $teikyu_1 . '">');
				print('<input type="hidden" name="tnp_st_time_1" value="' . $tnp_st_time_1 . '">');
				print('<input type="hidden" name="tnp_ed_time_1" value="' . $tnp_ed_time_1 . '">');
				print('<input type="hidden" name="teikyu_2" value="' . $teikyu_2 . '">');
				print('<input type="hidden" name="tnp_st_time_2" value="' . $tnp_st_time_2 . '">');
				print('<input type="hidden" name="tnp_ed_time_2" value="' . $tnp_ed_time_2 . '">');
				print('<input type="hidden" name="teikyu_3" value="' . $teikyu_3 . '">');
				print('<input type="hidden" name="tnp_st_time_3" value="' . $tnp_st_time_3 . '">');
				print('<input type="hidden" name="tnp_ed_time_3" value="' . $tnp_ed_time_3 . '">');
				print('<input type="hidden" name="teikyu_4" value="' . $teikyu_4 . '">');
				print('<input type="hidden" name="tnp_st_time_4" value="' . $tnp_st_time_4 . '">');
				print('<input type="hidden" name="tnp_ed_time_4" value="' . $tnp_ed_time_4 . '">');
				print('<input type="hidden" name="teikyu_5" value="' . $teikyu_5 . '">');
				print('<input type="hidden" name="tnp_st_time_5" value="' . $tnp_st_time_5 . '">');
				print('<input type="hidden" name="tnp_ed_time_5" value="' . $tnp_ed_time_5 . '">');
				print('<input type="hidden" name="teikyu_6" value="' . $teikyu_6 . '">');
				print('<input type="hidden" name="tnp_st_time_6" value="' . $tnp_st_time_6 . '">');
				print('<input type="hidden" name="tnp_ed_time_6" value="' . $tnp_ed_time_6 . '">');
				print('<input type="hidden" name="teikyu_7" value="' . $teikyu_7 . '">');
				print('<input type="hidden" name="tnp_st_time_7" value="' . $tnp_st_time_7 . '">');
				print('<input type="hidden" name="tnp_ed_time_7" value="' . $tnp_ed_time_7 . '">');
				print('<input type="hidden" name="teikyu_8" value="' . $teikyu_8 . '">');
				print('<input type="hidden" name="tnp_st_time_8" value="' . $tnp_st_time_8 . '">');
				print('<input type="hidden" name="tnp_ed_time_8" value="' . $tnp_ed_time_8 . '">');
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_eigyojkn_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="teikyu_0" value="' . $teikyu_0 . '">');
				print('<input type="hidden" name="tnp_st_time_0" value="' . $tnp_st_time_0 . '">');
				print('<input type="hidden" name="tnp_ed_time_0" value="' . $tnp_ed_time_0 . '">');
				print('<input type="hidden" name="teikyu_1" value="' . $teikyu_1 . '">');
				print('<input type="hidden" name="tnp_st_time_1" value="' . $tnp_st_time_1 . '">');
				print('<input type="hidden" name="tnp_ed_time_1" value="' . $tnp_ed_time_1 . '">');
				print('<input type="hidden" name="teikyu_2" value="' . $teikyu_2 . '">');
				print('<input type="hidden" name="tnp_st_time_2" value="' . $tnp_st_time_2 . '">');
				print('<input type="hidden" name="tnp_ed_time_2" value="' . $tnp_ed_time_2 . '">');
				print('<input type="hidden" name="teikyu_3" value="' . $teikyu_3 . '">');
				print('<input type="hidden" name="tnp_st_time_3" value="' . $tnp_st_time_3 . '">');
				print('<input type="hidden" name="tnp_ed_time_3" value="' . $tnp_ed_time_3 . '">');
				print('<input type="hidden" name="teikyu_4" value="' . $teikyu_4 . '">');
				print('<input type="hidden" name="tnp_st_time_4" value="' . $tnp_st_time_4 . '">');
				print('<input type="hidden" name="tnp_ed_time_4" value="' . $tnp_ed_time_4 . '">');
				print('<input type="hidden" name="teikyu_5" value="' . $teikyu_5 . '">');
				print('<input type="hidden" name="tnp_st_time_5" value="' . $tnp_st_time_5 . '">');
				print('<input type="hidden" name="tnp_ed_time_5" value="' . $tnp_ed_time_5 . '">');
				print('<input type="hidden" name="teikyu_6" value="' . $teikyu_6 . '">');
				print('<input type="hidden" name="tnp_st_time_6" value="' . $tnp_st_time_6 . '">');
				print('<input type="hidden" name="tnp_ed_time_6" value="' . $tnp_ed_time_6 . '">');
				print('<input type="hidden" name="teikyu_7" value="' . $teikyu_7 . '">');
				print('<input type="hidden" name="tnp_st_time_7" value="' . $tnp_st_time_7 . '">');
				print('<input type="hidden" name="tnp_ed_time_7" value="' . $tnp_ed_time_7 . '">');
				print('<input type="hidden" name="teikyu_8" value="' . $teikyu_8 . '">');
				print('<input type="hidden" name="tnp_st_time_8" value="' . $tnp_st_time_8 . '">');
				print('<input type="hidden" name="tnp_ed_time_8" value="' . $tnp_ed_time_8 . '">');
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

			}else if( $err_cnt > 0 ){
				//エラーがある場合
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_eigyojkn.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_eigyojkn_select.php">');
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
			
				print('<font color="red">※エラーがあります。</font><br>');
				
				print('<table border="0">');
				print('<tr>');
				print('<form name="form5" method="post" action="kanri_eigyojkn_ksn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<td align="left">');
				print('<font size="4"><b>開始時刻・終了時刻(*)</b></font>・・・オフィス営業時間<br>');
				print('<font size="2">※９時００分の場合は&nbsp;<font color="red">900</font> 、１２時３０分の場合は&nbsp;<font color="red">1230</font>、２３時００分の場合は&nbsp;<font color="red">2300</font>&nbsp;と入力してください</font><br>');
				print('<font size="2">※定休日の場合はチェックを入れてください（ただし、実際の営業日・非営業日はカレンダーの設定で判断します）</font><br>');
				print('<font size="2">※「土日祝の前日」「祝日」に時間を入力しない場合は、各曜日の時間と同様と判断します</font><br>');
				
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td>');
				
				print('<table border="1">');
				print('<tr>');
				print('<td width="80" align="center" bgcolor="powderblue">曜日</td>');
				print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
				print('<td width="20" align="center" bgcolor="powderblue">～</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
				print('<td width="110" align="center" bgcolor="powderblue">曜日</td>');
				print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
				print('<td width="20" align="center" bgcolor="powderblue">～</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
				print('</tr>');
				
				//月曜・土曜
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">月曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_1 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 1 ) . '" name="teikyu_1" ');
				if( $teikyu_1 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_1 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_1" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 2 ) . '" class="');
				if( $err_tnp_st_time_1 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_1 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_1 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_1" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 3 ) . '" class="');
				if( $err_tnp_ed_time_1 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_1 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_110x20.png">土曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_6 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_blue_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 16 ) . '" name="teikyu_6" ');
				if( $teikyu_6 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_6 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_blue_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_6" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 17 ) . '" class="');
				if( $err_tnp_st_time_6 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_6 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_6 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_blue_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_6" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 18 ) . '" class="');
				if( $err_tnp_ed_time_6 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_6 . '">');
				print('</td>');
				print('</tr>');
				//火曜・日曜
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">火曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_2 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 4 ) . '" name="teikyu_2" ');
				if( $teikyu_2 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_2 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_2" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 5 ) . '" class="');
				if( $err_tnp_st_time_2 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_2 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_2 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}

				print('><input type="text" name="tnp_ed_time_2" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 6 ) . '" class="');
				if( $err_tnp_ed_time_2 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_2 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_110x20.png">日曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_0 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_pink_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 19 ) . '" name="teikyu_0" ');
				if( $teikyu_0 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_0 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_0" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 20 ) . '" class="');
				if( $err_tnp_st_time_0 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_0 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_0 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_0" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 21 ) . '" class="');
				if( $err_tnp_ed_time_0 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_0 . '">');
				print('</td>');
				print('</tr>');
				//水曜・土日祝の前日
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">水曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_3 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 7 ) . '" name="teikyu_3" ');
				if( $teikyu_3 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_3 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_3" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 8 ) . '" class="');
				if( $err_tnp_st_time_3 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_3 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_3 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_3" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 9 ) . '" class="');
				if( $err_tnp_ed_time_3 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_3 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><font size="2">土日祝の前日</font></td>');
				print('<td align="center" ');
				if( $err_teikyu_7 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_kimidori_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 22 ) . '" name="teikyu_7" ');
				if( $teikyu_7 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_7 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_7" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 23 ) . '" class="');
				if( $err_tnp_st_time_7 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_7 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_7 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_7" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 24 ) . '" class="');
				if( $err_tnp_ed_time_7 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_7 . '">');
				print('</td>');
				print('</tr>');
				//木曜・祝日
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">木曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_4 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 10 ) . '" name="teikyu_4" ');
				if( $teikyu_4 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_4 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_4" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 11 ) . '" class="');
				if( $err_tnp_st_time_4 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_4 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_4 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_4" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 12 ) . '" class="');
				if( $err_tnp_ed_time_4 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_4 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_110x20.png">祝日</td>');
				print('<td align="center" ');
				if( $err_teikyu_8 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mura_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 25 ) . '" name="teikyu_8" ');
				if( $teikyu_8 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_8 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mura_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_8" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 26 ) . '" class="');
				if( $err_tnp_st_time_8 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_8 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_8 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mura_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_8" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 27 ) . '" class="');
				if( $err_tnp_ed_time_8 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_8 . '">');
				print('</td>');
				print('</tr>');
				//金曜
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">金曜</td>');
				print('<td align="center" ');
				if( $err_teikyu_5 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_55x20.png"');
				}
				print('"><input type="checkbox" tabindex="' . ($tabindex + 13 ) . '" name="teikyu_5" ');
				if( $teikyu_5 == 'on' ){
					print('checked');
				}
				if( $lock_flg == 1 ){
					print(' disabled');
				}
				print('></td>');
				print('<td align="center" ');
				if( $err_tnp_st_time_5 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_st_time_5" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 14 ) . '" class="');
				if( $err_tnp_st_time_5 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_st_time_5 . '">');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
				print('<td align="center" ');
				if( $err_tnp_ed_time_5 == 0 ){
					print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
				}else{
					print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
				}
				print('><input type="text" name="tnp_ed_time_5" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
				if( $lock_flg == 1 ){
					print(' readonly ');
				}
				print('tabindex="' . ($tabindex + 15 ) . '" class="');
				if( $err_tnp_ed_time_5 == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $tnp_ed_time_5 . '">');
				print('</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('<td bgcolor="#cccccc">&nbsp;</td>');
				print('</tr>');
				print('</table>');
				
				print('</td>');
				print('</tr>');
				print('</table>');
				
				$tabindex += 27;
				
				print('<br>');

				//有効期間
				print('<b>有効期間(*)</b>・・・上記営業時間の有効期間<br>');
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
				if( $err_st_year == 2 ){
					print('<br><font size="2" color="red">※期間重複あり</font>');
				}else if( $err_st_year == 3 ){
					print('<br><font size="2" color="red">※除外期間に予約あり</font>');
				}else{
					if( $err_st_year != 0 ){
						print('<br><font size="2" color="red">年エラー</font>');	
					}
					if( $err_st_month != 0 ){
						print('<br><font size="2" color="red">月エラー</font>');	
					}
					if( $err_st_day != 0 ){
						print('<br><font size="2" color="red">日エラー</font>');	
					}
				}
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
				if( $err_ed_year == 2 ){
					print('<br><font size="2" color="red">※期間重複あり</font>');
				}else if( $err_ed_year == 3 ){
					print('<br><font size="2" color="red">※除外期間に予約あり</font>');
				}else{
					if( $err_ed_year != 0 ){
						print('<br><font size="2" color="red">年エラー</font>');	
					}
					if( $err_ed_month != 0 ){
						print('<br><font size="2" color="red">月エラー</font>');	
					}
					if( $err_ed_day != 0 ){
						print('<br><font size="2" color="red">日エラー</font>');	
					}
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
				print('<form method="post" action="kanri_eigyojkn_select.php">');
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

				print('</center>');

				print('<hr>');

			}
		}
	}

	mysql_close( $link );
?>
</body>
</html>