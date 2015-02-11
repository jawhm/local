<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>管理画面－カレンダー</title>
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
	$gmn_id = 'kanri_calendar_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_calendar_top.php','kanri_calendar_list.php',
					'kanri_calendar_trk0.php','kanri_calendar_trk2.php');

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
	mb_internal_encoding("utf-8");

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

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_hyouji_2.png" width="0" height="0" style="visibility:hidden;">');


		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		print('<center>');
		
		//ページ編集
		print('<table bgcolor="pink"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kanri_calender.png" border="0">');
		print('</td></tr></table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="center"><font color="blue">※カレンダーを設定するオフィスを指定してください。</font></td>');
		print('<form method="post" action="kanri_top.php">');
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
		
		//オフィスマスタの取得
		$Moffice_cnt = 0;
		$query = 'select OFFICE_CD,OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and YUKOU_FLG = 1 order by ST_DATE;';
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
			while( $row = mysql_fetch_array($result) ){
				$Moffice_office_cd[$Moffice_cnt] = $row[0];	//オフィスコード
				$Moffice_office_nm[$Moffice_cnt] = $row[1];	//オフィス名
				$Moffice_cnt++;
			}
		}
				
		
		if( $err_flg == 0 ){
			//登録フォーム
			
			print('<form name="form1" method="post" action="kanri_calendar_list.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			
			print('<table  border="0">');
			print('<tr><td width="250" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"></td>');
			print('<td width="130" valign="bottom" rowspan="2" >');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_hyouji_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_hyouji_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_hyouji_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			print('<select name="select_office_cd" style="font-size:20px;" class="normal">');
			$i = 0;
			while( $i < $Moffice_cnt ){
				print('<option value="' . $Moffice_office_cd[$i] . '">' . $Moffice_office_cd[$i] . '：' . $Moffice_office_nm[$i] . '&nbsp;&nbsp;&nbsp;</option>');
				$i++;
			}
			print('</select></td>');
			print('</tr></table>');
			print('</form>');
			
		}
		
		print('</center>');
		
		print('<hr>');

	}

	mysql_close( $link );
?>
</body>
</html>
