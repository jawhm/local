<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－予約種別</title>
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
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kanri_class_select.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_class_top.php',
					'kanri_class_trk0.php','kanri_class_trk1.php','kanri_class_trk2.php',
					'kanri_class_ksn0.php','kanri_class_ksn1.php','kanri_class_ksn2.php',
					'kanri_class_del1.php','kanri_class_del2.php');

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

	//固有引数の取得
	$select_office_cd = $_POST['select_office_cd'];	//選択したオフィスコード

	//表示用現在時刻を求める
	$DFymdHis = date( "Y-m-d H:i:s", time() );

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_shinkitrk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_henkou_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

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
		
		//クラスマスタの情報取得
		$Mclass_cnt = 0;
		$query = 'select OFFICE_CD,CLASS_CD,CLASS_NM,YUKOU_FLG,ST_DATE,ED_DATE,UPDATE_TIME,UPDATE_STAFF_CD ' .
				 'from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD ="' . $select_office_cd . '" order by YUKOU_FLG desc,CLASS_CD;';
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
			$log_naiyou = 'クラスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			while ($row = mysql_fetch_array($result)){
				$Mclass_office_cd[$Mclass_cnt] = $row[0];		//オフィスコード
				$Mclass_class_cd[$Mclass_cnt] = $row[1];		//クラスコード
				$Mclass_class_nm[$Mclass_cnt] = $row[2];		//クラス名
				$Mclass_yukou_flg[$Mclass_cnt] = $row[3];		//有効フラグ
				$Mclass_st_date[$Mclass_cnt] = $row[4];			//開始日
				$Mclass_ed_date[$Mclass_cnt] = $row[5];			//終了日
				$Mclass_update_time[$Mclass_cnt] = $row[6];		//更新日時
				$Mclass_update_staff_cd[$Mclass_cnt] = $row[7];	//更新スタッフコード
				$Mclass_cnt++;
			}
		}

		//登録オフィス数を求める（全期間・無効を含む）
		$trk_office_su = 0;
		$query = 'select count(*) from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '";';
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
			$trk_office_su = $row[0];
		}


		if( $err_flg == 0 ){
			
			print('<center>');
		
			//ページ編集
			print('<table bgcolor="pink"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kanri_class.png" border="0">');
			print('</td></tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			//戻るボタン
			if( $trk_office_su == 1 ){
				print('<form method="post" action="kanri_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}else{
				print('<form method="post" action="kanri_class_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<hr>');
			
			//登録フォーム
			print('現在の登録内容です。<br>');
		
			//新規登録フォーム
			$edit_flg = 0;
			print('<form name="form2" method="post" action="kanri_class_trk0.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_shinkitrk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_1.png\';" onClick="kurukuru()" border="0">');
			print('</form>');

			if( $Mclass_cnt > 0 ){
				print('<font size="2">（' . $DFymdHis . ' 時点）</font>');
				print('<table border="1">');
				//項目
				print('<tr bgcolor="powderblue">');
				print('<td width="80" align="center">&nbsp;</td>');
				print('<td width="80" align="center"><font size="2">予約種別<br>コード</font></td>');
				print('<td width="180" align="center">予約種別名</td>');
				print('<td width="180" align="center">期間<br><font size="2">（開始日～終了日）</font></td>');
				print('<td width="110" align="center">更新者</td>');
				print('</tr>');
			
				$i = 0;
				while($i < $Mclass_cnt ){
					//背景色設定
					if($Mclass_yukou_flg[$i] == 0 || $Mclass_ed_date[$i] < $now_yyyymmdd2 ){
						//無効 または 過去データ
						$bgfile = 'bg_lightgrey';
						
					}else if( $Mclass_st_date[$i] <= $now_yyyymmdd2 && $now_yyyymmdd2 <= $Mclass_ed_date[$i] ){
						//現在データ
						$bgfile = 'bg_mizu';
						
					}else{
						//未来データ
						$bgfile = 'bg_yellow';
						
					}

					//変更ボタン
					print('<tr>');
					print('<form id="form1" name="form1" method="post" action="kanri_class_ksn0.php">');
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="class_cd" value="' . $Mclass_class_cd[$i] . '">');
					print('<input type="hidden" name="class_nm" value="' . $Mclass_class_nm[$i] . '">');
					print('<input type="hidden" name="st_date" value="' . $Mclass_st_date[$i] . '">');
					print('<input type="hidden" name="ed_date" value="' . $Mclass_ed_date[$i] . '">');
					print('<input type="hidden" name="yukou_flg" value="' . $Mclass_yukou_flg[$i] . '">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_henkou_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_henkou_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_henkou_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					
					//予約種別コード（クラスコード）
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font color="blue"><b>' . $Mclass_class_cd[$i] . '</b></font>');
					if( $Mclass_yukou_flg[$i] == 0 ){
						print('<br><font color="red" size="1">【無効】</font>');
					}
					print('</td>');
					//予約種別名（クラス名）
					print('<td align="left" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">' . $Mclass_class_nm[$i] . '</td>');
					//期間
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png"><font size="2">' . substr($Mclass_st_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Mclass_st_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Mclass_st_date[$i],8,2)) . '日&nbsp;から<br>&nbsp;' . substr($Mclass_ed_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Mclass_ed_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Mclass_ed_date[$i],8,2)) . '日&nbsp;まで</font></td>');
					// 更新者・更新日時
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
					print( $Mclass_update_staff_cd[$i] );
					print('<br><font size="1">' . $Mclass_update_time[$i] . '</font></td>');
					print('</tr>');
						
					$i++;
				}
				print('</table>');
			}
			if( $Mclass_cnt == 0 ){
				print('<font color="blue">※登録データはありません。</font><br>');	
			}
						
			//戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			if( $trk_office_su == 1 ){
				print('<form method="post" action="kanri_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}else{
				print('<form method="post" action="kanri_class_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}
			print('<td align="right">');
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