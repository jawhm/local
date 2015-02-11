<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－スタッフ</title>
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
	$gmn_id = 'kanri_staff_select.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_staff_top.php',
					'kanri_staff_trk0.php','kanri_staff_trk1.php','kanri_staff_trk2.php',
					'kanri_staff_ksn0.php','kanri_staff_ksn1.php','kanri_staff_ksn2.php',
					'kanri_staff_del2.php');

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
	$select_office_cd = $_POST['select_office_cd'];

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

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_shinkitrk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_henkou_2.png" width="0" height="0" style="visibility:hidden;">');


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
			$Moffice_office_nm = $row[0];		//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
		}


		//スタッフマスタの情報取得
		$Mstaff_cnt = 0;
		$query = 'select STAFF_CD,DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '"),' .
				 'CLASS_CD1,CLASS_CD2,CLASS_CD3,CLASS_CD4,CLASS_CD5,OPE_AUTH,KANRISYA_FLG,YUKOU_FLG,ST_DATE,ED_DATE,UPDATE_TIME,UPDATE_STAFF_CD from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD != "axdkanri" order by YUKOU_FLG desc,ST_DATE,STAFF_CD;';
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
			$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Mstaff_staff_cd[$Mstaff_cnt] = $row[0];		//スタッフコード
				$Mstaff_staff_nm[$Mstaff_cnt] = $row[1];		//スタッフ名
				$Mstaff_open_staff_nm[$Mstaff_cnt] = $row[2];	//公開スタッフ名
				$Mstaff_class_cd1[$Mstaff_cnt] = $row[3];		//クラスコード１
				$Mstaff_class_cd2[$Mstaff_cnt] = $row[4];		//クラスコード２
				$Mstaff_class_cd3[$Mstaff_cnt] = $row[5];		//クラスコード３
				$Mstaff_class_cd4[$Mstaff_cnt] = $row[6];		//クラスコード４
				$Mstaff_class_cd5[$Mstaff_cnt] = $row[7];		//クラスコード５
				$Mstaff_ope_auth[$Mstaff_cnt] = $row[8];		//業務権限
				$Mstaff_kanrisya_flg[$Mstaff_cnt] = $row[9];	//管理者フラグ
				$Mstaff_yukou_flg[$Mstaff_cnt] = $row[10];		//有効フラグ
				$Mstaff_st_date[$Mstaff_cnt] = $row[11];			//開始日
				$Mstaff_ed_date[$Mstaff_cnt] = $row[12];			//終了日
				$Mstaff_update_time[$Mstaff_cnt] = $row[13];		//更新日時
				$Mstaff_update_staff_cd[$Mstaff_cnt] = $row[14];	//更新スタッフコード
				$Mstaff_cnt++;
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
			print('<img src="./img_' . $lang_cd . '/bar_kanri_staff.png" border="0">');
			print('</td></tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			if( $trk_office_su == 1 ){
				print('<form method="post" action="kanri_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}else{
				print('<form method="post" action="kanri_staff_top.php">');
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
			
			//新規登録ボタン
			print('<form name="form2" method="post" action="kanri_staff_trk0.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_shinkitrk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_1.png\';" onClick="kurukuru()" border="0">');
			print('</form>');
			
			if( $Mstaff_cnt > 0 ){
				print('<font size="2">（' . $DFymdHis . ' 時点）</font>');
			
				print('<table border="1">');
				//項目
				print('<tr bgcolor="powderblue">');
				print('<td width="80" align="center">&nbsp;</td>');
				print('<td width="180" align="center"><font size="2">スタッフコード／<br>スタッフ名</font></td>');
				print('<td width="55" align="center"><font size="2">予約種別</font><br>(1)</td>');
				print('<td width="55" align="center"><font size="2">予約種別</font><br>(2)</td>');
				print('<td width="55" align="center"><font size="2">予約種別</font><br>(3)</td>');
				print('<td width="55" align="center"><font size="2">予約種別</font><br>(4)</td>');
				print('<td width="55" align="center"><font size="2">予約種別</font><br>(5)</td>');
				print('<td width="55" align="center"><font size="2">業務権限</td>');
				print('<td width="180" align="center"><font size="2">有効期間<br>（開始日～終了日）</font></td>');
				print('<td width="110" align="center">更新者</td>');
				print('</tr>');
			
				$i = 0;
				while($i < $Mstaff_cnt ){
					//背景色設定
					if($Mstaff_yukou_flg[$i] == 0 || $Mstaff_ed_date[$i] < $now_yyyymmdd2 ){
						//無効 または 過去データ
						$bgfile = 'bg_lightgrey';
					}else if( $Mstaff_st_date[$i] <= $now_yyyymmdd2 && $now_yyyymmdd2 <= $Mstaff_ed_date[$i] ){
						//現在データ
						$bgfile = 'bg_mizu';
					}else{
						//未来データ
						$bgfile = 'bg_yellow';
					}
					
					print('<tr>');
					//変更ボタン
					print('<form name="form3' . sprintf("%02d",$i) . '" method="post" action="kanri_staff_ksn0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="stf_cd" value="' . $Mstaff_staff_cd[$i] . '">');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_henkou_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_henkou_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_henkou_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');

					//スタッフコード／スタッフ名
					print('<td align="left" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
					print('<font color="blue" size="5"><b>' . $Mstaff_staff_cd[$i] . '</font><br>' . $Mstaff_staff_nm[$i] . '</b>');
					if( $Mstaff_open_staff_nm[$i] != "" ){
						print('<br><font size="2" color="gray">(' . $Mstaff_open_staff_nm[$i] . ')</font>');
					}
					if( $Mstaff_kanrisya_flg[$i] == 1 ){
						print('<br><font size="1" color="red">【管理者】</font>');
					}
					if( $Mstaff_yukou_flg[$i] == 0 ){
						print('<br><font size="1" color="red">【無効】</font>');
					}
					print('</td>');

					//予約種別１
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
					if( $Mstaff_class_cd1[$i] != '' ){
						print( $Mstaff_class_cd1[$i] );
					}else{
						print('－');
					}
					print('</td>');

					//予約種別２
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
					if( $Mstaff_class_cd2[$i] != '' ){
						print( $Mstaff_class_cd2[$i] );
					}else{
						print('－');
					}
					print('</td>');

					//予約種別３
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
					if( $Mstaff_class_cd3[$i] != '' ){
						print( $Mstaff_class_cd3[$i] );
					}else{
						print('－');
					}
					print('</td>');

					//予約種別４
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
					if( $Mstaff_class_cd4[$i] != '' ){
						print( $Mstaff_class_cd4[$i] );
					}else{
						print('－');
					}
					print('</td>');

					//予約種別５
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
					if( $Mstaff_class_cd5[$i] != '' ){
						print( $Mstaff_class_cd5[$i] );
					}else{
						print('－');
					}
					print('</td>');

					//業務権限
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
					if( $Mstaff_ope_auth[$i] != '' ){
						print( sprintf("%03d",$Mstaff_ope_auth[$i]) );
					}else{
						print('－');
					}
					print('</td>');

					//開始日／終了日
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png"><font size="2">' . substr($Mstaff_st_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Mstaff_st_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Mstaff_st_date[$i],8,2)) . '日&nbsp;から<br>' . substr($Mstaff_ed_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Mstaff_ed_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Mstaff_ed_date[$i],8,2)) . '日&nbsp;まで</font>');
					print('</td>');
					
					// 更新者／更新日時
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
					print( $Mstaff_update_staff_cd[$i] );
					print('<br><font size="1">' . $Mstaff_update_time[$i] . '</font>');
					print('</td>');
					
					print('</tr>');
					
					$i++;
				}
				print('</table>');
			
			}else{
				print('<br><br>※登録スタッフ&nbsp;は&nbsp;ありません。<br><br><br>');
				
			}
			
			print('</center>');

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
				print('<form method="post" action="kanri_staff_top.php">');
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
		}
	}

	mysql_close( $link );
?>
</body>
</html>