<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－オフィス</title>
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
	$gmn_id = 'kanri_office_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_office_trk0.php','kanri_office_trk1.php','kanri_office_trk2.php',
					'kanri_office_ksn0.php','kanri_office_ksn1.php','kanri_office_ksn2.php','kanri_office_del2.php');

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
		print('<img src="./img_' . $lang_cd . '/btn_shinkitrk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_henkou_2.png" width="0" height="0" style="visibility:hidden;">');


		//オフィスマスタに登録されているデータを取得する
		$Moffice_cnt = 0;

		$query = 'select OFFICE_CD,OFFICE_NM,YUKOU_FLG,ST_DATE,ED_DATE,UPDATE_TIME,UPDATE_STAFF_CD ' .
				 'from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" order by ST_DATE,OFFICE_CD;';
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
			while ($row = mysql_fetch_array($result)){
				$Moffice_office_cd[$Moffice_cnt] = $row[0];			//オフィスコード
				$Moffice_office_nm[$Moffice_cnt] = $row[1];			//オフィス名
				$Moffice_yukou_flg[$Moffice_cnt] = $row[2];			//有効フラグ
				$Moffice_st_date[$Moffice_cnt] = $row[3];			//開始日
				$Moffice_ed_date[$Moffice_cnt] = $row[4];			//終了日
				$Moffice_update_time[$Moffice_cnt] = $row[5];		//更新日時
				$Moffice_update_staff_cd[$Moffice_cnt] = $row[6];	//更新スタッフコード
				$Moffice_cnt++;
			}
		}


		//ページ編集
		print('<center>');
		
		print('<table bgcolor="pink"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kanri_office.png" border="0">');
		print('</td></tr></table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="center"><font color="blue">※現在登録されているオフィスは <font size="6"><b>' . $Moffice_cnt . '</b></font> 件です。</b></font></td>');
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

		//新規登録フォーム
		print('<table border="0">');
		print('<tr>');
		print('<form name="form1" method="post" action="' . $sv_staff_adr . 'kanri_office_trk0.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<td width="740" align="center">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_shinkitrk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
			
		print('<table border="1">');
		//項目
		print('<tr>');
		print('<td width="80" background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png">&nbsp;</td>');
		print('<td width="300" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="2">オフィスコード／オフィス名</font></td>');
		print('<td width="180" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_180x20.png"><font size="2">開始日&nbsp;～&nbsp;終了日</font></td>');
		print('<td width="180" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_180x20.png"><font size="2">更新者／更新日時</font></td>');
		print('</tr>');
		
		$i = 0;
		while ($i < $Moffice_cnt ){
						
			//背景色の設定
			if( $Moffice_yukou_flg[$i] != 1 ){
				//無効の場合
				$bgfile80 = '../img_' . $lang_cd . '/bg_lightgrey_80x20.png';
				$bgfile180 = '../img_' . $lang_cd . '/bg_lightgrey_180x20.png';
				$bgfile300 = '../img_' . $lang_cd . '/bg_lightgrey_300x20.png';
			}else{
				$bgfile80 = '../img_' . $lang_cd . '/bg_blue_80x20.png';
				$bgfile180 = '../img_' . $lang_cd . '/bg_blue_180x20.png';
				$bgfile300 = '../img_' . $lang_cd . '/bg_blue_300x20.png';
			}
						
			print('<tr>');
			print('<form id="form1" name="form1" method="post" action="' . $sv_staff_adr . 'kanri_office_ksn0.php">');
			print('<td width="80" height="40" align="center" background="' . $bgfile80 . '">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $Moffice_office_cd[$i] . '">');
			print('<input type="hidden" name="select_st_date" value="' . $Moffice_st_date[$i] . '">');
			print('<input type="hidden" name="select_ed_date" value="' . $Moffice_ed_date[$i] . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_henkou_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_henkou_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_henkou_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			//店舗コード／店舗名
			print('<td align="left" background="' . $bgfile300 . '">&nbsp;' . $Moffice_office_cd[$i] );
			if( $Moffice_yukou_flg[$i] != 1 ){
				print('<font color="red" size="1">【無効】</font>');
			}
			print('<br><font size="4">&nbsp;' . $Moffice_office_nm[$i] . '</font></td>');
			
			//開始日／終了日
			print('<td align="center" background="' . $bgfile180 . '"><font size="2">' . substr($Moffice_st_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Moffice_st_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Moffice_st_date[$i],8,2)) . '日&nbsp;から<br>' . substr($Moffice_ed_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Moffice_ed_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Moffice_ed_date[$i],8,2)) . '日&nbsp;まで</font></td>');
			
			//更新者／更新日時
			print('<td align="center" background="' . $bgfile180 . '">');
			print( $Moffice_update_staff_cd[$i] . '<br><font size="1">' . $Moffice_update_time[$i] . '</font></td>');
			print('</tr>');
						
			$i++;	//行数カウント
		}
		print('</table>');
		
		print('<br><br>');
		
		print('</center>');
		
		print('<hr>');
	
	}

	mysql_close( $link );
?>
</body>
</html>