<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング（カウンセラー選択）</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
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
	$gmn_id = 'kbtcounseling_trk_selectstaff.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	require( './zs_array_all.php' );

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
	$select_office_cd = $_POST['select_office_cd'];		//(未入力OK)
	$select_yyyy = $_POST['select_yyyy'];	//(未入力OK)
	$select_mm = $_POST['select_mm'];		//(未入力OK)
	$select_staff_cd = $_POST['select_staff_cd'];	//未入力可（カウンセラーを指定した場合のみ設定される）

	//日時変更用
	$select_yyk_no = $_POST['select_yyk_no'];		//(未入力OK)　日時変更時に変更対象となる予約番号が設定される
	if( $select_yyk_no != "" ){
		$select_yyk_kaiin_nm = $_POST['select_yyk_kaiin_nm'];
		$select_yyk_kaiin_nm_k = $_POST['select_yyk_kaiin_nm_k'];
		$select_yyk_kaiin_kbn = $_POST['select_yyk_kaiin_kbn'];
		$select_yyk_kaiin_id = $_POST['select_yyk_kaiin_id'];
		$select_yyk_kaiin_mixi = $_POST['select_yyk_kaiin_mixi'];
		$select_yyk_office_nm = $_POST['select_yyk_office_nm'];
		$select_yyk_ymd = $_POST['select_yyk_ymd'];
		$select_yyk_youbi = $_POST['select_yyk_youbi'];
		$select_yyk_eigyoubi_flg = $_POST['select_yyk_eigyoubi_flg'];
		$select_yyk_st_time = $_POST['select_yyk_st_time'];
		$select_yyk_ed_time = $_POST['select_yyk_ed_time'];
		$select_yyk_kyoumi = $_POST['select_yyk_kyoumi'];
		$select_yyk_jiki = $_POST['select_yyk_jiki'];
		$select_yyk_soudan = $_POST['select_yyk_soudan'];
		$select_yyk_staff_nm = $_POST['select_yyk_staff_nm'];

		if( $select_yyk_ymd != "" ){
			$select_yyk_ymd_yyyymmdd = substr($select_yyk_ymd,0,4) . substr($select_yyk_ymd,5,2) . substr($select_yyk_ymd,8,2);
		}
	}

	if( $select_office_cd == "" ){
			//初期値設定（スタッフの所属するオフィスとする）
		$select_office_cd = $office_cd;
	}
	if( $select_yyyy == "" ){
		$select_yyyy = $now_yyyy;
	}
	if( $select_mm == "" ){
		$select_mm = $now_mm;
	}	

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_yyyy == "" || $select_mm == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_cng_kaijyou_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_next_1.png" width="0" height="0" style="visibility:hidden;">');

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
			
			//「オフィス」を「会場」に置換する
			$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );			
			
		}

		//表示対象月の１日を求める
		$disp_st_date = $select_yyyy . sprintf("%02d",$select_mm) . '01';
		//表示対象月の翌月の末日を求める
		$tmp_yyyy = $select_yyyy;
		$tmp_mm = $select_mm + 1;
		if( $tmp_mm > 12 ){
			$tmp_yyyy++;
			$tmp_mm = 1;
		}
		$tmp_dd = cal_days_in_month(CAL_GREGORIAN, $tmp_mm , $tmp_yyyy );
		$disp_ed_date = $tmp_yyyy . sprintf("%02d",$tmp_mm) . sprintf("%02d",$tmp_dd);


		//個別カウンセラーを求める
		$Mstaff_cnt = 0;
		if( $err_flg == 0 ){
			$query = 'select STAFF_CD,DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '"),ST_DATE,ED_DATE from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and (CLASS_CD1 = "KBT" || CLASS_CD2 = "KBT" || CLASS_CD3 = "KBT" || CLASS_CD4 = "KBT" || CLASS_CD5 = "KBT" ) and YUKOU_FLG = 1 and !( ED_DATE < "' . $disp_st_date . '" && ST_DATE > "' . $disp_ed_date . '" ) order by ST_DATE,STAFF_CD;';
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
					$Mstaff_st_date[$Mstaff_cnt] = substr($row[3],0,4) . substr($row[3],5,2) . substr($row[3],8,2);		//開始日
					$Mstaff_ed_date[$Mstaff_cnt] = substr($row[4],0,4) . substr($row[4],5,2) . substr($row[4],8,2);		//終了日
					$Mstaff_cnt++;
				}
			}
		}



		
		if( $err_flg == 0 ){
			//画面編集
			print('<center>');
		
			//ページ編集
			print('<table><tr>');
			print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');


			if( $select_yyk_no == "" ){
				//新規予約時

				print('<table border="0">');
				print('<tr>');
//				if( $zs_kanrisya_flg == 1 ){
					//管理者（オフィス変更ボタン ＋ オフィス名表示）
					print('<form name="form1" method="post" action="kbtcounseling_trk_top.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '" />');
					print('<input type="hidden" name="select_yyyy" value="' . $select_yyyy . '">');
					print('<input type="hidden" name="select_mm" value="' . $select_mm . '">');
					print('<td width="140" align="center" valign="bottom">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cng_kaijyou_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cng_kaijyou_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cng_kaijyou_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('<td width="675" align="left"><img src="./img_' . $lang_cd . '/bar_kaijyou.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
					
//				}else{
//					//非管理者（オフィス名表示のみ）
//					print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_kaijyou.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
//				}
				//戻るボタンは無し
				print('<td width="135">&nbsp;</td>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
			
			}else{
				//予約日時変更時
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="135">&nbsp;</td>');
				print('<td width="680" align="center" valign="middle">');
				//「個別カウンセリング　日時変更　（現在の予約内容）」
				print('<img src="./img_' . $lang_cd . '/title_kbtcounseling_genzainaiyou.png" border="0"><br>');
				print('</td>');
				print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . substr($select_yyk_ymd,0,4) . sprintf("%02d",substr($select_yyk_ymd,5,2)) . sprintf("%02d",substr($select_yyk_ymd,8,2)) . '">');
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				//現在の予約内容を表示する
				//背景色
				if( $select_yyk_ymd > $now_yyyymmdd2 || ($select_yyk_ymd == $now_yyyymmdd2 && $select_yyk_st_time > ($now_hh * 100 + $now_ii) )){
					//未来
					$bgfile_1 = "mizu";
					$bgcolor_1 = "#d6fafa";
				}else{
					//過去
					$bgfile_1 = "lightgrey";
					$bgcolor_1 = "#d3d3d3";
				}
				
				if( $select_yyk_kaiin_kbn != "" && $select_yyk_kaiin_kbn == 0 ){
					//仮登録
					$bgcolor_2 = "#fffa6e";
					$bgfile_2 = "yellow";
				}else if( $select_yyk_kaiin_kbn == 1 ){
					//メンバー
					$bgcolor_2 = "#aefd9f";
					$bgfile_2 = "kimidori";
				}else if( $select_yyk_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					$bgcolor_2 = "#ffc0cb";
					$bgfile_2 = "pink";
				}
						
				//年月日表示
				if( $select_yyk_eigyoubi_flg == 1 || $select_yyk_eigyoubi_flg == 9 ){
					//祝日
					$fontcolor_2 = "red";
				}else if( $select_yyk_youbi == 0 ){
					//日曜
					$fontcolor_2 = "red";
				}else if( $select_yyk_youbi == 6 ){
					//土曜
					$fontcolor_2 = "blue";
				}else{
					//平日
					$fontcolor_2 = "black";
				}
			
				print('<table border="1">');
				//予約番号／会場
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="6" color="blue">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="4" color="blue">' . $select_yyk_office_nm . '</font></td>');
				print('</tr>');
				
				//日時
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				print('<td colspan="3" align="center" valign="middle" bgcolor="' . $bgcolor_1 . '"><font size="6" color="' . $fontcolor . '">' . substr($select_yyk_ymd,0,4) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;年&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($select_yyk_ymd,5,2)) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;月&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($select_yyk_ymd,8,2))  . '</font><font size="2" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_yyk_youbi] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' .  intval( $select_yyk_st_time / 100 ) . ':' . sprintf("%02d",( $select_yyk_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $select_yyk_ed_time / 100 ) . ':' . sprintf("%02d",( $select_yyk_ed_time % 100 )) . '</font></td>');
				print('</tr>');
				
				//お客様番号／氏名
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
				if( $select_yyk_kaiin_kbn != "" && $select_yyk_kaiin_kbn == 0 ){
					print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $select_yyk_staff_nm . ')</font>');	//仮登録
				}else if( $select_yyk_kaiin_kbn == 1 ){
					//メンバー
					print('<font size="5" color="blue">' . $select_yyk_kaiin_id . '</font><br>(' . $select_yyk_kaiin_mixi . ')');
				}else if( $select_yyk_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					print('<font size="5" color="blue">' . $select_yyk_kaiin_id . '</font><br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
				}else{
					print('<font size="4" color="red">エラー</font>');
				}
				print('</td>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
				if( $select_yyk_kaiin_kbn != "" && $select_yyk_kaiin_kbn == 0 ){
					print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $select_yyk_staff_nm . ')</font>');	//仮登録
				}else if( $select_yyk_kaiin_kbn == 1 || $select_yyk_kaiin_kbn == 9 ){
					print('<table border="0">');
					print('<tr>');
					print('<td align="left" valign="middle">');
					if( $select_yyk_kaiin_nm_k != "" ){
						print('<font size="2" color="blue">' . $select_yyk_kaiin_nm_k . '</font><br>');
					}
					print('<font size="4" color="blue">' . $select_yyk_kaiin_nm . '</font>');
					print('</td>');
					print('<td valign="bottom"><font size="2">様</font></td>');
					print('</tr>');
					print('</table>');
					
				}else{
					print('<font size="4" color="red">エラー</font>');
				}
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');
			
			}
			
			//「対象のカウンセラーを選択してください。」
			print('<img src="./img_' . $lang_cd . '/title_select_counselor.png" border="0"><br>');
			
			print('<table border="0">');
			print('<tr>');
			print('<form name="form1" method="post" action="kbtcounseling_trk_selectdate.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '" />');
			print('<input type="hidden" name="select_yyyy" value="' . $select_yyyy . '">');
			print('<input type="hidden" name="select_mm" value="' . $select_mm . '">');
			print('<td align="center" valign="middle">');
			$tabindex++;
			print('<select name="select_staff_cd" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
			print('<option value="" class="color2" ');
			if( $select_staff_cd == "" ){
				print(' selected');	
			}
			print('>全員表示</option>');
			$s = 0;
			while( $s < $Mstaff_cnt ){
				print('<option value="' . $Mstaff_staff_cd[$s] . '" class="color1" ');
				if( $select_staff_cd == $Mstaff_staff_cd[$s] ){
					print(' selected');	
				}
				print('>' . $Mstaff_open_staff_nm[$s] . '(' . $Mstaff_staff_nm[$s] . ')</option>');
				$s++;
			}
			print('</select>');
			print('</td>');
			print('<td align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_next_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_next_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_next_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
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