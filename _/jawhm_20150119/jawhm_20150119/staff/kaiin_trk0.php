<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>会員情報－新規会員登録</title>
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
	$gmn_id = 'kaiin_trk0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_top.php','kaiin_trk1.php','kaiin_trk2.php');

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
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		
		
		//ページ編集
		//ページ編集
		//初期値セット
		$kaiin_nm1 = '';		//会員名（姓）
		$kaiin_nm2 = '';		//会員名（名）
		$kaiin_nm_k1 = '';		//会員名カナ（セイ）
		$kaiin_nm_k2 = '';		//会員名カナ（メイ）
		$input_kaiin_no = '';	//希望する会員番号
		$kaiin_tel = '';		//会員電話番号
		$kaiin_tel_keitai = '';	//会員携帯電話
		$kaiin_mail = '';		//会員メールアドレス
		$kaiin_pw = '';			//会員パスワード		
		$kaiin_kyoumi = '';		//会員興味のある国
		$kaiin_zip_cd = '';		//会員郵便番号
		$kaiin_adr1 = '';		//会員住所１
		$kaiin_adr2 = '';		//会員住所２
		$birth_year = '';		//会員生年月日（年）
		$birth_month = '';		//会員生年月日（月）
		$birth_day = '';		//会員生年月日（日）
		$kaiin_seibetsu = '';	//会員性別
		$kaiin_syokugyo_kbn = '';	//会員職業区分
		$kaiin_sc_nm = '';		//会員学校名・会社名
		$kikkake = '';			//きっかけ
		$kaiin_bikou = '';		//会員備考
		if( $prc_gmn == 'kaiin_trk1.php' || $prc_gmn == 'kaiin_trk2.php' ){
			$kaiin_nm1 = $_POST['kaiin_nm1'];			//会員名（姓）
			$kaiin_nm2 = $_POST['kaiin_nm2'];			//会員名（名）
			$kaiin_nm_k1 = $_POST['kaiin_nm_k1'];		//会員名カナ（セイ）
			$kaiin_nm_k2 = $_POST['kaiin_nm_k2'];		//会員名カナ（メイ）
			$input_kaiin_no = $_POST['input_kaiin_no'];	//希望する会員番号
			$kaiin_tel = $_POST['kaiin_tel'];			//会員電話番号
			$kaiin_tel_keitai = $_POST['kaiin_tel_keitai'];	//会員携帯電話
			$kaiin_mail = $_POST['kaiin_mail'];			//会員メールアドレス
			$kaiin_pw = $_POST['kaiin_pw'];				//会員パスワード
			$kaiin_kyoumi = $_POST['kaiin_kyoumi'];		//会員興味のある国
			$kaiin_zip_cd = $_POST['kaiin_zip_cd'];		//会員郵便番号
			$kaiin_adr1 = $_POST['kaiin_adr1'];			//会員住所１
			$kaiin_adr2 = $_POST['kaiin_adr2'];			//会員住所２
			$birth_year = $_POST['birth_year'];			//会員生年月日（年）
			$birth_month = $_POST['birth_month'];		//会員生年月日（月）
			$birth_day = $_POST['birth_day'];			//会員生年月日（日）
			$kaiin_seibetsu = $_POST['kaiin_seibetsu'];	//会員性別
			$kaiin_syokugyo_kbn = $_POST['kaiin_syokugyo_kbn'];	//会員職業区分
			$kaiin_sc_nm = $_POST['kaiin_sc_nm'];		//会員学校名・会社名
			$kikkake = $_POST['kikkake'];				//きっかけ
			$kaiin_bikou = $_POST['kaiin_bikou'];		//会員備考
		}


		//現在の会員番号最大値を求める
		$max_kaiin_no = '';
		$query = 'select MAX_KAIIN_NO from M_KAIIN_NO where KG_CD = "' . $DEF_kg_cd . '";';
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
			$log_naiyou = '会員番号の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$max_kaiin_no = $row[0] + 1;
			if( $max_kaiin_no > 9999999 ){
				$max_kaiin_no = 1;
			}
			$tmp_flg = 0;
			while( $tmp_flg == 0 && $err_flg == 0 ){
				$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_NO = ' . $max_kaiin_no . ';';
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
					$log_naiyou = '会員番号の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
	
				}else{
					$row = mysql_fetch_array($result);
					if( $row[0] == 0 ){
						$tmp_flg = 1;
					}else{
						$max_kaiin_no++;
					}
				}
			}
		}

		if( $err_flg == 0 ){
			//エラーなし
			
			print('<center>');
		
			//ページ編集
			print('<table bgcolor="lightblue"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kaiininfo_shinkikaiintrk.png" border="0">');
			print('</td></tr></table>');
			
			//「会員情報を入力後、登録ボタンを押下してください。」
			print('<img src="./img_' . $lang_cd . '/title_kaiinnyuuryoku_go_trk.png" border="0"><br>');

			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');

			print('<form method="post" action="kaiin_trk1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
		
			print('<table border="0">');
			print('<tr>');
			//会員名
			print('<td width="450" align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0"><br>');
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<font size="2">(姓)</font><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_nm1" maxlength="20" size="9" value="' . $kaiin_nm1 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<font size="2">(名)</font><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_nm2" maxlength="20" size="9" value="' . $kaiin_nm2 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('</tr>');
			print('</table>');
			print('</td>');
			//希望する会員番号
//			print('<td width="300" align="left" valign="top">');
//			print('<img src="./img_' . $lang_cd . '/title_kibou_kaiinno.png" border="0"><br>');
//			$tabindex++;
//			print('<input type="text" name="input_kaiin_no" maxlength="5" size="5" value="' . $input_kaiin_no . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt;  text-align: right; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br><font size="2" color="#aaaaaa">未入力時：' . sprintf('%05d',$max_kaiin_no) . ' 予定</font></td>');
			print('</tr>');
			print('<tr>');
			//会員カナ
			print('<td width="450" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinnm_k.png" border="0"><br>');
			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<font size="2">(セイ)</font><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_nm_k1" maxlength="20" size="9" value="' . $kaiin_nm_k1 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('<td align="left" valign="top">');
			print('<font size="2">(メイ)</font><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_nm_k2" maxlength="20" size="9" value="' . $kaiin_nm_k2 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('</tr>');
			print('</table>');
			print('</td>');
			//会員パスワード
//			print('<td width="300" valign="top">');
//			print('<img src="./img_' . $lang_cd . '/title_kaiinpw.png" border="0"><br>');
//			$tabindex++;
//			print('<input type="text" name="kaiin_pw" maxlength="30" size="16" value="' . $kaiin_pw . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
//			print('<font size="2">(半角英数字：4文字以上)</font>');
//			print('</td>');
			print('</tr>');
			print('</table>');
		
			print('<table border="0">');
			print('<tr>');
			//会員電話番号
			print('<td width="300" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiintel.png" border="0"><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_tel" maxlength="15" size="16" value="' . $kaiin_tel . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
			print('<font size="2">(半角英数字)<br></font>');
			print('</td>');
			//会員メールアドレス
			print('<td width="450" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinmail.png" border="0"><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_mail" maxlength="60" size="30" value="' . $kaiin_mail . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
			print('<font size="2">(半角英数字)<br></font>');
			print('</td>');
			print('</tr>');
			print('</table>');
	
			print('<table border="0">');
			print('<tr>');
			//会員携帯電話
			print('<td width="300" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kaiinkeitaitel.png" border="0"><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_tel_keitai" maxlength="15" size="16" value="' . $kaiin_tel_keitai . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
			print('<font size="2">(半角英数字)<br></font>');
			print('</td>');
			//興味のある国
			print('<td width="450" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_kyoumi" maxlength="60" size="30" value="' . $kaiin_kyoumi . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:active" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
			
			print('<table border="0">');
			print('<tr>');
			//郵便番号
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_yubinbangou.png" border="0"><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_zip_cd" maxlength="8" size="10" value="' . $kaiin_zip_cd . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
			print('</td>');
			print('<td width="100">&nbsp;</td>');	//（調整空白）
			//性別
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_seibetsu.png" border="0"><br>');
			$tabindex++;
			print('<select name="kaiin_seibetsu" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
			if( $kaiin_seibetsu == 0 ){
				print('<option value="0" class="color0" selected>&nbsp;</option>');
				print('<option value="1" class="color1">男性</option>');
				print('<option value="2" class="color2">女性</option>');
			}else if( $kaiin_seibetsu == 1 ){
				print('<option value="0" class="color0">&nbsp;</option>');
				print('<option value="1" class="color1" selected>男性</option>');
				print('<option value="2" class="color2">女性</option>');
			}else{
				print('<option value="0" class="color0">&nbsp;</option>');
				print('<option value="1" class="color1">男性</option>');
				print('<option value="2" class="color2" selected>女性</option>');
			}
			print('</select>');
			print('</td>');
			//生年月日
			print('<td align="left" valign="bottom">');
			print('<img src="./img_' . $lang_cd . '/title_seinengappi.png" border="0"><br>');
			$tabindex++;
			print('<select name="birth_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			print('<option value="">&nbsp;</option>');
			$i = $now_yyyy;
			while( $i > ($now_yyyy - 100) ){
				print('<option value="' . $i . '" ');
				if( $i == $birth_year ){
					print('selected');
				}
				print('>' . $i. '</option>');
				$i--;
			}
			print('</select>');
			print('年');
			$tabindex++;
			print('<select name="birth_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			print('<option value="">&nbsp;</option>');
			$i = 1;
			while( $i < 13 ){
				print('<option value="' . $i . '" ');
				if( $i == $birth_month ){
					print('selected');
				}
				print('>' . $i. '</option>');
				
				$i++;
			}
			print('</select>');
			print('月');
			$tabindex++;
			print('<select name="birth_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			print('<option value="">&nbsp;</option>');
			$i = 1;
			while( $i < 32 ){
				print('<option value="' . $i . '" ');
				if( $i == $birth_day ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('日');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<table border="0">');
			print('<tr>');
			//住所１
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_adr.png" border="0"><br>');
			print('&nbsp;&nbsp;<font size="2">（住所１）都道府県名・市区町村(例：</font><font color="blue" size="2">' . $ex_adr1 . '</font><font size="2">&nbsp;)</font><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_adr1" maxlength="80" size="50" value="' . $kaiin_adr1 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('<br>&nbsp;&nbsp;<font size="2">（住所２）丁目/番地・マンション名・部屋番号(例：</font><font color="blue" size="2">' . $ex_adr2 . '</font><font size="2">&nbsp;)</font><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_adr2" maxlength="80" size="50" value="' . $kaiin_adr2 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('<table border="0">');
			print('<tr>');
			//職業区分
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_syokugyokbn.png" border="0"><br>');
			$tabindex++;
			print('<select name="kaiin_syokugyo_kbn" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
			//--(初期値)
			print('<option value="" class="color0" ');
			if( $kaiin_syokugyo_kbn == '' ){
				print('selected');
			}
			print('>&nbsp;</option>');
			//-- 小・中学生
			print('<option value="A" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'A' ){
				print('selected');
			}
			print('>小・中学生</option>');
			//-- 高校生・受験生
			print('<option value="B" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'B' ){
				print('selected');
			}
			print('>高校生・受験生</option>');
			//-- 専門学校・大学生
			print('<option value="C" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'C' ){
				print('selected');
			}
			print('>専門学校・大学生</option>');
			//-- 大学院・研究生
			print('<option value="D" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'D' ){
				print('selected');
			}
			print('>大学院・研究生</option>');
			//-- 会社員
			print('<option value="E" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'E' ){
				print('selected');
			}
			print('>会社員</option>');
			//-- 公務員
			print('<option value="F" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'F' ){
				print('selected');
			}
			print('>公務員</option>');
			//-- 自営業
			print('<option value="G" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'G' ){
				print('selected');
			}
			print('>自営業</option>');
			//-- フリーランス・自由業
			print('<option value="H" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'H' ){
				print('selected');
			}
			print('>フリーランス・自由業</option>');
			//-- 会社経営・役員
			print('<option value="I" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'I' ){
				print('selected');
			}
			print('>会社経営・役員</option>');
			//-- 団体職員
			print('<option value="J" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'J' ){
				print('selected');
			}
			print('>団体職員</option>');
			//-- 主婦
			print('<option value="K" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'K' ){
				print('selected');
			}
			print('>主婦</option>');
			//-- フリーター
			print('<option value="L" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'L' ){
				print('selected');
			}
			print('>フリーター</option>');
			//-- 家事手伝い
			print('<option value="M" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'M' ){
				print('selected');
			}
			print('>家事手伝い</option>');
			//-- 無職
			print('<option value="N" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'N' ){
				print('selected');
			}
			print('>無職</option>');
			//-- その他
			print('<option value="Z" class="color0" ');
			if( $kaiin_syokugyo_kbn == 'Z' ){
				print('selected');
			}
			print('>その他</option>');
			print('</select>');
			print('</td>');
			//学校名・会社名
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_sc_nm.png" border="0"><br>');
			$tabindex++;
			print('<input type="text" name="kaiin_sc_nm" maxlength="80" size="32" value="' . $kaiin_sc_nm . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<table border="0">');
			print('<tr>');
			//きっかけ
			print('<td align="left" valign="top">');
			print('<img src="./img_' . $lang_cd . '/title_kikkake.png" border="0"><br>');
			$tabindex++;
			print('<select name="kikkake" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
			//--(初期値)
			print('<option value="" class="color0" ');
			if( $kikkake == '' ){
				print('selected');
			}
			print('>&nbsp;</option>');
			//-- インターネット
			print('<option value="A" class="color0" ');
			if( $kikkake == 'A' ){
				print('selected');
			}
			print('>インターネット</option>');
			//-- 看板
			print('<option value="B" class="color0" ');
			if( $kikkake == 'B' ){
				print('selected');
			}
			print('>看板</option>');
			//-- 学校
			print('<option value="C" class="color0" ');
			if( $kikkake == 'C' ){
				print('selected');
			}
			print('>学校</option>');
			//-- 知人の紹介
			print('<option value="D" class="color0" ');
			if( $kikkake == 'D' ){
				print('selected');
			}
			print('>知人の紹介</option>');
			//-- その他
			print('<option value="Z" class="color0" ');
			if( $kikkake == 'Z' ){
				print('selected');
			}
			print('>その他</option>');
			print('</select>');
			print('</td>');
			
			print('</tr>');
			print('</table>');


			//備考
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">');
			print('<img src="./img_' . $lang_cd . '/title_bikou.png" border="0"><br>');
			$tabindex++;
			print('<textarea name="kaiin_bikou" rows="4" cols="60" style="ime-mode:active;" tabindex="' . $tabindex . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $kaiin_bikou . '</textarea>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('</td>');
			print('</tr>');
			print('</table>');
			
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kaiin_top.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
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
