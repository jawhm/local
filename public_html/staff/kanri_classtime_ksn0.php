<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>管理画面－予約種別時間割（更新）</title>
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
	$gmn_id = 'kanri_classtime_ksn0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_classtime_select_2.php','kanri_classtime_ksn1.php','kanri_classtime_ksn2.php','kanri_classtime_del1.php');

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
	$select_class_cd = $_POST['select_class_cd'];	//選択したクラスコード
	$select_st_date = $_POST['select_st_date'];
	$select_ed_date = $_POST['select_ed_date'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_class_cd == "" || $select_st_date == "" || $select_ed_date == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_sakujyo_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		if( $prc_gmn == 'kanri_classtime_select_2.php' || $prc_gmn == 'kanri_classtime_del1.php'){
			//クラス時間割からデータを取得する
			$query = 'select JKN_KBN,ST_DATE,ED_DATE,ST_TIME,ED_TIME,YUKOU_FLG from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD ="' . $select_class_cd . '" and ST_DATE ="' . $select_st_date . '" order by TSUBAN;';
			
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
				$log_naiyou = 'クラス時間割の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
			
			}else{
				$Mclass_cnt = 0;
				while( $row = mysql_fetch_array($result)){
					if( in_array($row[0] , $jkn_kbn_array_2) ){	//常連フラグ	0:一般　1;常連
						$jyoren[$Mclass_cnt] = 1;
					}else{
						$jyoren[$Mclass_cnt] = 0;
					}
					$st_time[$Mclass_cnt] = sprintf("%04d",$row[3]);		//開始時刻
					$ed_time[$Mclass_cnt] = sprintf("%04d",$row[4]);		//終了時刻
					
					if( $mstudio_cnt == 0 ){
						$st_year = substr($row[1],0,4);		//開始年
						$st_month = substr($row[1],5,2);	//開始月
						$st_day = substr($row[1],8,2);		//開始日

						$ed_year = substr($row[2],0,4);		//終了年
						$ed_month = substr($row[2],5,2);	//終了月
						$ed_day = substr($row[2],8,2);		//終了日

						$yukou_flg = $row[5];	//有効フラグ　0：無効　1：有効
					}
					
					$Mclass_cnt++;
				}
				$i = $Mclass_cnt;
				while( $i < 48 ){
					//残りを初期値で設定する
					$jyoren[$i] = 0;
					$st_time[$i] = "";
					$ed_time[$i] = "";
					$i++;
				}
			}
		
		}else if( $prc_gmn == 'kanri_classtime_ksn1.php' ){
			$i = 0;
			while( $i < 48 ){
				$name = 'jyoren' . $i;
				$jyoren[$i] = $_POST[$name];
				$name = 'st_time' . $i;
				$st_time[$i] = $_POST[$name];
				$name = 'ed_time' . $i;
				$ed_time[$i] = $_POST[$name];
				$i++;
			}
			$yukou_flg = $_POST['yukou_flg'];	//有効フラグ
			$st_year = $_POST['st_year'];		//開始年
			$st_month = $_POST['st_month'];		//開始月
			$st_day = $_POST['st_day'];			//開始日
			$ed_year = $_POST['ed_year'];		//終了年
			$ed_month = $_POST['ed_month'];		//終了月
			$ed_day = $_POST['ed_day'];			//終了日
		}
		
		//適用期間に予約があるか確認。（予約ありの場合は時間は更新できない）
		$lock_flg = 0;	//ロックフラグ 0:ロックしない　1：常連フラグ・開始時刻・終了時刻はロックする

		$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD ="' . $select_class_cd . '" and YMD >= "' . $select_st_date . '" and YMD <= "' . $select_ed_date . '";';
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
				//予約データがあるの常連フラグ・開始時刻・終了時刻はロックする
				$lock_flg = 1;
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
				
		//クラスマスタの取得
		$select_class_nm = '';
		$query = 'select CLASS_NM from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "' . $select_class_cd . '"';
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
			$row = mysql_fetch_array($result);
			$select_class_nm = $row[0];	//クラス名
			
		}



		if( $err_flg == 0 ){
			
			print('<center>');
		
			//ページ編集
			print('<table bgcolor="pink"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kanri_classjknwr.png" border="0">');
			print('</td></tr></table>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			print('<form method="post" action="kanri_classtime_select_2.php">');
			print('<td align="right" rowspan="2">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_classnm.png"><br><font size="5" color="blue">' . $select_class_nm . '</font></td>');
			print('</tr>');			
			print('</table>');

			print('<hr>');
			
			print('<font color="blue">※時間を入力し、登録ボタンを押下してください。</font><br>');
			print('入力例：９時００分は 900 、１５時３０分は 1530 で入力してください。<br>');
			print('（メンバーのみ利用可能な時間割は会員にチェックしてください。）<br>');
			if( $lock_flg == 1 ){
				print('<font color="red">予約データが存在するため、時刻の追加・訂正および削除はできません。</font><br>');
			}

			print('<form name="form2" method="post" action="kanri_classtime_ksn1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
			print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
			print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
			print('<input type="hidden" name="lock_flg" value="' . $lock_flg . '">');

			print('<table border="1">');
			print('<tr bgcolor="powderblue">');
			print('<th width="40"><font size="2">通番</font></th>');
			print('<th width="40"><font size="2">会員</font></th>');
			print('<th width="80">開始時刻</th>');
			print('<th width="80">終了時刻</th>');
			print('<th width="40"><font size="2">通番</font></th>');
			print('<th width="40"><font size="2">会員</font></th>');
			print('<th width="80">開始時刻</th>');
			print('<th width="80">終了時刻</th>');
			print('<th width="40"><font size="2">通番</font></th>');
			print('<th width="40"><font size="2">会員</font></th>');
			print('<th width="80">開始時刻</th>');
			print('<th width="80">終了時刻</th></tr>');
			$i = 0;
			while( $i < 16 ){	//16x3
				print('<tr>');
				//通番（１列目）
				print('<td bgcolor="powderblue" align="center">' . ($i + 1) . '</td>');
				//常連（１列目）
				if( $lock_flg == 1 ){
					if( $jyoren[$i] == 1 ){
						$bgfile = 'bg_yellow';
					}else if( $st_time[$i] != "" ){
						$bgfile = 'bg_mizu';
					}else{
						$bgfile = 'bg_lightgrey';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_40x20.png">');
					print('<input type="hidden" name="jyoren' . $i . '" value="' . $jyoren[$i] . '"');
					if( $jyoren[$i] == 1 ){
						print('<font size="2" color="blue">会員</font>');
					}else{
						print('&nbsp;');	
					}
					print('</td>');
					
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_40x20.png">');
					print('<input type="checkbox" name="jyoren' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 1) . '"');
					if( $jyoren[$i] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
				}
				//開始時刻（１列目）
				if( $lock_flg == 1 ){
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="st_time' . $i . '" value="' . $st_time[$i] . '"');
					print('<font size="5" color="blue">' . $st_time[$i] . '</font>');
					print('</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
					print('<input type="text" name="st_time' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 2) . '" value="' . $st_time[$i] . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" >');
					print('</td>');
				}
				//終了時刻（１列目）
				if( $lock_flg == 1 ){
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="ed_time' . $i . '" value="' . $ed_time[$i] . '"');
					print('<font size="5" color="blue">' . $ed_time[$i] . '</font>');
					print('</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
					print('<input type="text" name="ed_time' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 3) . '" value="' . $ed_time[$i] . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" >');
					print('</td>');
				}
				
				//通番（２列目）
				print('<td bgcolor="powderblue" align="center">' . ($i + 17) . '</td>');
				//常連（２列目）
				if( $lock_flg == 1 ){
					if( $jyoren[($i + 16)] == 1 ){
						$bgfile = 'bg_yellow';
					}else if( $st_time[($i + 16)] != "" ){
						$bgfile = 'bg_mizu';
					}else{
						$bgfile = 'bg_lightgrey';
					}
					print('<td align="center"  background="../img_' . $lang_cd . '/' . $bgfile . '_40x20.png">');
					print('<input type="hidden" name="jyoren' . ($i + 16) . '" value="' . $jyoren[($i + 16)] . '"');
					if( $jyoren[($i + 16)] == 1 ){
						print('<font size="2" color="blue">会員</font>');
					}else{
						print('&nbsp;');	
					}
					print('</td>');
					
				}else{
					print('<td align="center"  background="../img_' . $lang_cd . '/bg_mizu_40x20.png">');
					print('<input type="checkbox" name="jyoren' . ($i + 16) . '" tabindex="' . ($tabindex + 48 + ($i * 3) +  1) . '"');
					if( $jyoren[($i + 16)] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
				}
				//開始時刻（２列目）
				if( $lock_flg == 1 ){
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="st_time' . ($i + 16) . '" value="' . $st_time[($i + 16)] . '"');
					print('<font size="5" color="blue">' . $st_time[($i + 16)] . '</font>');
					print('</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
					print('<input type="text" name="st_time' . ($i + 16) . '" value="' . $st_time[($i + 16)] . '" tabindex="' . ($tabindex + 48 + ($i * 3) + 2) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" >');
					print('</td>');
				}
				//終了時刻（２列目）
				if( $lock_flg == 1 ){
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="ed_time' . ($i + 16) . '" value="' . $ed_time[($i + 16)] . '"');
					print('<font size="5" color="blue">' . $ed_time[($i + 16)] . '</font>');
					print('</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
					print('<input type="text" name="ed_time' . ($i + 16) . '" value="' . $ed_time[($i + 16)] . '" tabindex="' . ($tabindex + 48 + ($i * 3) + 3) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" >');
					print('</td>');
				}
				
				//通番（３列目）
				print('<td bgcolor="powderblue" align="center">' . ($i + 33) . '</td>');
				//常連（３列目）
				if( $lock_flg == 1 ){
					if( $jyoren[($i + 32)] == 1 ){
						$bgfile = 'bg_yellow';
					}else if( $st_time[($i + 32)] != "" ){
						$bgfile = 'bg_mizu';
					}else{
						$bgfile = 'bg_lightgrey';
					}
					print('<td align="center"  background="../img_' . $lang_cd . '/' . $bgfile . '_40x20.png">');
					print('<input type="hidden" name="jyoren' . ($i + 32) . '" value="' . $jyoren[($i + 32)] . '"');
					if( $jyoren[($i + 32)] == 1 ){
						print('<font size="2" color="blue">会員</font>');
					}else{
						print('&nbsp;');	
					}
					print('</td>');
					
				}else{
					print('<td align="center"  background="../img_' . $lang_cd . '/bg_mizu_40x20.png">');
					print('<input type="checkbox" name="jyoren' . ($i + 32) . '" tabindex="' . ($tabindex + 96 + ($i * 3) +  1) . '"');
					if( $jyoren[($i + 32)] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
				}
				//開始時刻（３列目）
				if( $lock_flg == 1 ){
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="st_time' . ($i + 32) . '" value="' . $st_time[($i + 32)] . '"');
					print('<font size="5" color="blue">' . $st_time[($i + 32)] . '</font>');
					print('</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
					print('<input type="text" name="st_time' . ($i + 32) . '" value="' . $st_time[($i + 32)] . '" tabindex="' . ($tabindex + 96 + ($i * 3) + 2) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" >');
					print('</td>');
				}
				//終了時刻（３列目）
				if( $lock_flg == 1 ){
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<input type="hidden" name="ed_time' . ($i + 32) . '" value="' . $ed_time[($i + 32)] . '"');
					print('<font size="5" color="blue">' . $ed_time[($i + 32)] . '</font>');
					print('</td>');
				}else{
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
					print('<input type="text" name="ed_time' . ($i + 32) . '" value="' . $ed_time[($i + 32)] . '" tabindex="' . ($tabindex + 96 + ($i * 3) + 3) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" >');
					print('</td>');
				}
				
				print('</tr>');
				$i++;
			}
			print('</table>');

			if( $lock_flg == 0 ){
				$tabindex += (48*3);
			}
			
			print('<br>');

			//有効期間
			print('<b>有効期間(*)</b>・・・予約種別時間割の有効期間<br>');
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
			print('</td>');
			print('</tr>');
			print('</table>');

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
				if( $lock_flg == 1 ){
					print('<option value="1" class="color1" selected>有効</option>');
				}else{
					print('<option value="0" class="color2" >無効</option>');
					print('<option value="1" class="color1" selected>有効</option>');
				}
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
			print('<form method="post" action="kanri_classtime_select_2.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			if( $lock_flg == 0 ){
				//削除ボタン
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_classtime_del1.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sakujyo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
			}
			print('</table>');

			print('</center>');

			print('<hr>');

		}
	}

	mysql_close( $link );
?>
</body>
</html>