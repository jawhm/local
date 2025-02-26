<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－オフィス(新規登録)</title>
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
<body>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kanri_office_trk0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_office_top.php','kanri_office_trk1.php');

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
		
		//メニューボタン表示
		require( './zs_menu_button.php' );

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');

		//ページ編集
		//初期値セット
		$select_office_cd = '';	//登録対象のオフィスコード
		$select_office_nm = '';	//登録対象のオフィス名
		$office_pw = '';		//登録対象のオフィスパスワード
		$mail_adr = '';			//登録対象オフィスのメールアドレス
		$tel = '';				//登録対象オフィスの電話番号
		$cancel_yk_jkn = 0;		//登録対象オフィスのキャンセル有効時間（単位：時）
		$cancel_mk_kkn = 0;		//登録対象オフィスのキャンセル無効期間（単位：日前）
		$start_youbi = 0;		//開始曜日（ 0:日曜始まり　1:月曜始まり ）
		$time_disp_flg = 0;		//時間表示フラグ（ 0:24H表示　1:12H表示 ）
		$bikou = '';			//備考（営業開始時間などのテキスト情報）
		$yukou_flg = 1;			//有効フラグ　0：無効　1：有効
		$st_year = $now_yyyy;	//開始年
		$st_month = $now_mm;	//開始月
		$st_day = $now_dd;		//開始日
		$ed_year = 2037;		//終了年
		$ed_month = 12;			//終了月
		$ed_day = 31;			//終了日

		if( $prc_gmn == 'kanri_office_trk1.php' ){
			$select_office_cd = $_POST['select_office_cd'];	//登録対象のオフィスコード
			$select_office_nm = $_POST['select_office_nm'];	//登録対象のオフィス名
			$office_pw = $_POST['office_pw'];				//登録対象のオフィスパスワード
			$mail_adr = $_POST['mail_adr'];					//登録対象オフィスのメールアドレス
			$tel = $_POST['tel'];							//登録対象オフィスの電話番号
			$cancel_yk_jkn = $_POST['cancel_yk_jkn'];		//登録対象オフィスのキャンセル有効時間（単位：時）
			$cancel_mk_kkn = $_POST['cancel_mk_kkn'];		//登録対象オフィスのキャンセル無効期間（単位：日前）
			$start_youbi = $_POST['start_youbi'];			//開始曜日（ 0:日曜始まり　1:月曜始まり ）
			$time_disp_flg = $_POST['time_disp_flg'];		//時間表示フラグ（ 0:24H表示　1:12H表示 ）
			$bikou = $_POST['bikou'];						//備考（営業開始時間などのテキスト情報）
			$yukou_flg = $_POST['yukou_flg'];				//有効フラグ　0：無効　1：有効
			$st_year = $_POST['st_year'];					//開始年
			$st_month = $_POST['st_month'];					//開始月
			$st_day = $_POST['st_day'];						//開始日
			$ed_year = $_POST['ed_year'];					//終了年
			$ed_month = $_POST['ed_month'];					//終了月
			$ed_day = $_POST['ed_day'];						//終了日
		
		}


		//ページ編集
		
		print('<center>');
		
		print('<table bgcolor="pink"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kanri_office.png" border="0">');
		print('</td></tr></table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="center"><font color="blue">※オフィス情報を入力後、登録ボタンを押下して下さい。（*印の項目は必須入力となります。)</font></td>');
		print('<form method="post" action="kanri_office_top.php">');
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

		
		print('<form method="post" action="kanri_office_trk1.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		
		print('<table border="0">');
		print('<tr>');
		print('<td align="left">');
		
		//オフィスコード／オフィス名／オフィスパスワード
		print('<table border="0">');
		print('<tr>');
		print('<td align="left" valign="top">');
		print('<b>オフィスコード(*)</b><br>');
		$tabindex++;
		print('<input type="text" name="select_office_cd" maxlength="20" size="8" value="' . $select_office_cd . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
		print('<font size="2">(半角英数字：最大20桁)</font>');
		print('</td>');
		print('<td align="left" valign="top">');
		print('<b>オフィス名(*)</b><br>');
		$tabindex++;
		print('<input type="text" name="select_office_nm" maxlength="60" size="28" value="' . $select_office_nm . '" tabindex="' . $tabindex . '" class="normal" style="font-size:20pt;ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
		print('<font size="2">(全角・半角英数字)</font>');
		print('</td>');
		print('<td valign="top">');
		print('<b>オフィスパスワード(*)</b><br>');
		$tabindex++;
		print('<input type="text" name="office_pw" maxlength="30" size="10" value="' . $office_pw . '" tabindex="' . $tabindex . '" class="normal"  style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
		print('<font size="2">(半角英数字：4文字以上)</font>');
		print('</td>');
		print('</tr>');
		print('</table>');
		
		//受付メールアドレス／受付電話番号
		print('<table border="0">');
		print('<tr>');
		print('<td align="left" valign="top">');
		print('<b>受付メールアドレス(*)</b><br>');
		$tabindex++;
		print('<input type="text" name="mail_adr" maxlength="60" size="35" value="' . $mail_adr . '" tabindex="' . $tabindex . '" class="normal"  style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
		print('<font size="2">(半角英数字)<br></font>');
		print('</td>');
		print('<td align="left" valign="top">');
		print('<b>受付電話番号(*)</b><br>');
		$tabindex++;
		print('<input type="text" name="tel" maxlength="15" size="15" value="' . $tel . '" tabindex="' . $tabindex . '" class="normal"  style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">&nbsp;&nbsp;<br>');
		print('<font size="2">(半角英数字)<br></font>');
		print('</td>');
		print('</tr>');
		print('</table>');
		
		//配信メールへ記載するオフィス情報（備考）
		print('<table border="0">');
		print('<tr>');
		print('<td align="left">');
		print('<font size="4"><b>配信メールへ記載するオフィス情報</b></font><br>');
		$tabindex++;
		print('<textarea name="bikou" rows="6" cols="60" wrap="hard" ');
		print('tabindex="' . $tabindex . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $bikou . '</textarea><font size="2">(全角・半角英数字)<br>&nbsp;</font>');
		print('</td>');
		print('</tr>');
		print('</table>');
		
		//キャンセル無効期間／キャンセル有効時間／開始曜日／時間表示フラグ
		print('<table border="0">');
		print('<tr>');
		print('<td align="left" valign="top">');
		print('<b>開始曜日(*)</b><br>');
		$tabindex++;
		print('<select name="start_youbi" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
		if( $start_youbi == 0 ){
			print('<option value="0" selected>日曜始まり</option>');
			print('<option value="1">月曜始まり</option>');
		}else{
			print('<option value="0">日曜始まり</option>');
			print('<option value="1" selected>月曜始まり</option>');
		}
		print('</select>&nbsp;&nbsp;');
		print('<br><font size="2">カレンダー表示の開始曜日</font>');
		print('</td>');
		print('<td align="left" valign="top">');
		print('<b>時間表示(*)</b><br>');
		$tabindex++;
		print('<select name="time_disp_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
		if( $time_disp_flg == 0 ){
			print('<option value="0" selected>24H表示</option>');
			print('<option value="1">12H表示</option>');
		}else{
			print('<option value="0">24H表示</option>');
			print('<option value="1" selected>12H表示</option>');
		}
		print('</select>&nbsp;&nbsp;');
		print('<br><font size="2">時刻の表示形式<br>(24H形式：23時59分)<br>(12H形式：午後11時59分)</font>');
		print('</td>');
		print('<td align="left" valign="top">');
		print('<b>キャンセル無効期間(*)</b>&nbsp;&nbsp;<br>');
		$tabindex++;
		print('<select name="cancel_mk_kkn" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
		$i = 0;
		while( $i < 32 ){
			print('<option value="' . $i . '" ');
			if( $i == $cancel_mk_kkn ){
				print('selected');
			}
			print('>' . $i. '</option>');
		
			$i++;
		}
		print('</select>');
		print('<font size="2">日前</font><br><font size="2">キャンセルできる期限日</font>');
		print('</td>');
		print('<td align="left" valign="top">');
		print('<b>キャンセル有効時間(*)</b><br>');
		$tabindex++;
		print('<select name="cancel_yk_jkn" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
		$i = 0;
		while( $i < 25 ){
			print('<option value="' . $i . '" ');
			if( $i == $cancel_yk_jkn ){
				print('selected');
			}
			print('>' . $i. '</option>');
		
			$i++;
		}
		print('</select>');
		print('<font size="2">時間以内</font><br><font size="2">キャンセル無効期間でも<br>キャンセル可能とする有効時間</font>');
		print('</td>');
		print('</tr>');		
		print('</table>');
		
		print('</td>');
		print('</tr>');
		print('</table>');
				
		print('<br>');
		
		
		print('<table>');
		print('<tr>');
		print('<td width="950" align="left">');
		
		//有効期間
		print('<b>有効期間(*)</b>・・・オフィスの営業期間<br>');
		print('<table border="0">');
		print('<tr>');
		print('<td align="left">');
		print('開始日<br>');
		$tabindex++;
		print('<select name="st_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
		$i = 2011;
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
		$i = 2011;
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
		print('<font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると画面には表示されません。</font>');
		print('</td>');
		print('<td align="right">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('<tr>');
		print('<td width="815" align="left">&nbsp;</td>');
		print('<form method="post" action="kanri_office_top.php">');
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
		
		print('</td>');
		print('</tr>');
		print('</table>');

		print('</center>');

		print('<hr>');
	}

	mysql_close( $link );
?>
</body>
</html>