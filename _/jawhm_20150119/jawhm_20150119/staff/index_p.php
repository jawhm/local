<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<meta name="robots" content="noindex,nofollow">
<?php
	//セッション開始
	session_name(JAWHM_Web_System);
	session_start();

	//サーバー接続
	require( './zs_svconnect.php' );

	if( $SVkankyo == 9 ){
		print('<title>ワーキングホリデー協会　スタッフログイン（開発）</title>');
	}else{
		print('<title>ワーキングホリデー協会　スタッフログイン</title>');
	}
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<script type="text/javascript">
<!-- 
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
-->
</script>
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style>
</head>
<BODY bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'index_p.php';

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	//祝日情報
	require_once('../jp-holiday.php');

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************


	//引数の入力
	$staff_cd = htmlspecialchars($_GET['n'],ENT_QUOTES,'utf8');

	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];

	//アドレス部引数
	$arg_p = htmlspecialchars($_GET['p'],ENT_QUOTES,'shift_jis');
	if( $arg_p == "ENTRY" ){
		//エントリー画面へのリンクの場合
		$entry_arg_client_no = htmlspecialchars($_GET['cn'],ENT_QUOTES,'shift_jis');
		$entry_arg_study_abroad_no = htmlspecialchars($_GET['san'],ENT_QUOTES,'shift_jis');

	}else if( $arg_p == "ENTRY2" ){
		//エントリー画面へのリンクの場合
		$entry_arg_client_no = htmlspecialchars($_GET['cn'],ENT_QUOTES,'shift_jis');
		$entry_arg_study_abroad_no = htmlspecialchars($_GET['san'],ENT_QUOTES,'shift_jis');
	
	}else if( $arg_p == "MAIL" ){
		//メール表示画面へのリンクの場合
		$mailno_ang_str = htmlspecialchars($_GET['ms'],ENT_QUOTES,'shift_jis');

	}else if( $arg_p == "CS" ){
		//メール表示画面へのリンクの場合
		$cs_no = htmlspecialchars($_GET['c'],ENT_QUOTES,'shift_jis');

	}else if( $arg_p == "MAKE" ){
		//メール表示画面へのリンクの場合
		$mail_adr = htmlspecialchars($_GET['adr'],ENT_QUOTES,'shift_jis');
	
	}
		
	//引数入力チェック
	if ( $lang_cd == "" ){
		$lang_cd = 'J';		//J:日本語 を初期値とする
	}
	
	//メンテナンス期間チェック
	require( './zs_mntchk.php' );


	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/lang_j_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/lang_e_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/lang_k_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_login_2.png" width="0" height="0" style="visibility:hidden;">');



	if( ($arg_p == "ENTRY" || $arg_p == "ENTRY2") && $_SESSION['office_cd'] != "" && $_SESSION['staff_cd'] != "" ){
		
		$office_cd = $_SESSION['office_cd'];
		$staff_cd = $_SESSION['staff_cd'];
		
		//スタッフ情報を取得する
		$query = 'select A.OFFICE_CD,DECODE(A.STAFF_PW,"' . $ANGpw . '"),A.OPE_AUTH,B.LOGIN_TIME,B.ERR_CNT from M_STAFF A,D_STAFF_LOGIN B' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '"' .
						 ' and A.STAFF_CD = "' . $staff_cd . '"' .
						 ' and A.ST_DATE <= "' . $now_yyyymmdd . '"' .
						 ' and A.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.YUKOU_FLG = 1 and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and A.STAFF_CD = B.STAFF_CD;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php.php' );
			
			//**ログ出力**
			$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
			$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';		//オフィスコード
			$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
			$log_naiyou = 'スタッフマスタ・ログイン情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;		//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$office_cd = $row[0];
			$DBtnt_pw = $row[1];
			$ope_auth = $row[2];
			$bf_login_time = $row[3];
			$err_cnt = $row[4];
		
			if( $arg_p == "ENTRY" ){
			    header('Location: http://192.168.11.118/entry/entry_revision.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&op=' . $ope_auth . '&cn=' . $entry_arg_client_no . '&san=' . $entry_arg_study_abroad_no );
			
			}else if( $arg_p == "ENTRY2" ){
			    header('Location: http://192.168.11.118/entry/file_revision.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&op=' . $ope_auth . '&cn=' . $entry_arg_client_no . '&san=' . $entry_arg_study_abroad_no );
				
			}
		}

	}else if( $arg_p == "MAIL" && $_SESSION['office_cd'] != "" && $_SESSION['staff_cd'] != "" ){
		
		$office_cd = $_SESSION['office_cd'];
		$staff_cd = $_SESSION['staff_cd'];
		
		//スタッフ情報を取得する
		$query = 'select A.OFFICE_CD,DECODE(A.STAFF_PW,"' . $ANGpw . '"),A.OPE_AUTH,B.LOGIN_TIME,B.ERR_CNT from M_STAFF A,D_STAFF_LOGIN B' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '"' .
						 ' and A.STAFF_CD = "' . $staff_cd . '"' .
						 ' and A.ST_DATE <= "' . $now_yyyymmdd . '"' .
						 ' and A.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.YUKOU_FLG = 1 and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and A.STAFF_CD = B.STAFF_CD;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php.php' );
			
			//**ログ出力**
			$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
			$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';		//オフィスコード
			$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
			$log_naiyou = 'スタッフマスタ・ログイン情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;		//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$office_cd = $row[0];
			$DBtnt_pw = $row[1];
			$ope_auth = $row[2];
			$bf_login_time = $row[3];
			$err_cnt = $row[4];
		
		    header('Location: http://192.168.11.118/mail/mail_disp.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&ms=' . $mailno_ang_str  );
		
		}

	}else if( $arg_p == "CS" && $_SESSION['office_cd'] != "" && $_SESSION['staff_cd'] != "" ){
		
		$office_cd = $_SESSION['office_cd'];
		$staff_cd = $_SESSION['staff_cd'];
		
		//スタッフ情報を取得する
		$query = 'select A.OFFICE_CD,DECODE(A.STAFF_PW,"' . $ANGpw . '"),A.OPE_AUTH,B.LOGIN_TIME,B.ERR_CNT from M_STAFF A,D_STAFF_LOGIN B' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '"' .
						 ' and A.STAFF_CD = "' . $staff_cd . '"' .
						 ' and A.ST_DATE <= "' . $now_yyyymmdd . '"' .
						 ' and A.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.YUKOU_FLG = 1 and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and A.STAFF_CD = B.STAFF_CD;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php.php' );
			
			//**ログ出力**
			$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
			$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';		//オフィスコード
			$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
			$log_naiyou = 'スタッフマスタ・ログイン情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;		//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$office_cd = $row[0];
			$DBtnt_pw = $row[1];
			$ope_auth = $row[2];
			$bf_login_time = $row[3];
			$err_cnt = $row[4];
		
		    header('Location: http://192.168.11.118/mail/mail_list2_list_cs_pre.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&c=' . $cs_no  );
		
		}

	}else if( $arg_p == "MAKE" && $_SESSION['office_cd'] != "" && $_SESSION['staff_cd'] != "" ){
		
		$office_cd = $_SESSION['office_cd'];
		$staff_cd = $_SESSION['staff_cd'];
		
		//スタッフ情報を取得する
		$query = 'select A.OFFICE_CD,DECODE(A.STAFF_PW,"' . $ANGpw . '"),A.OPE_AUTH,B.LOGIN_TIME,B.ERR_CNT from M_STAFF A,D_STAFF_LOGIN B' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '"' .
						 ' and A.STAFF_CD = "' . $staff_cd . '"' .
						 ' and A.ST_DATE <= "' . $now_yyyymmdd . '"' .
						 ' and A.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.YUKOU_FLG = 1 and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and A.STAFF_CD = B.STAFF_CD;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php.php' );
			
			//**ログ出力**
			$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
			$log_kkstaff_kbn = 'S';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';		//オフィスコード
			$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
			$log_naiyou = 'スタッフマスタ・ログイン情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;		//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$office_cd = $row[0];
			$DBtnt_pw = $row[1];
			$ope_auth = $row[2];
			$bf_login_time = $row[3];
			$err_cnt = $row[4];
		
		    header('Location: http://192.168.11.118/mail/make_mail_new0.php?p=' . $gmn_id . '&l=' . $lang_cd . '&o=' . $office_cd . '&s=' . $staff_cd . '&adr=' . $mail_adr  );
		
		}

	}else if( $mntchk_flg == 0 || $mntchk_flg == 3 || $mntchk_flg == 4 ){
		//システム稼動中


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

		//画面編集
		print('<center>');
		print('<table border="0">');
		print('<tr>');
		print('<td width="370" align="center" valign="middle">');
		print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
		print('</td>');
		print('<td width="265" align="left" valign="top">');
		//言語選択(Please select a language)
		print('<img src="./img_' . $lang_cd . '/lang_title.png" border="0"><br>');
		print('<table>');
		print('<tr>');
		print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="J">');
		print('<td>');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_j_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_j_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_j_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="E">');
		print('<td>');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_e_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_e_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_e_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="K">');
		print('<td>');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_k_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_k_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_k_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
		
		print('</td>');
		print('<td width="180" align="left">');
		print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
		print('</td>');
		print('<td width="135" align="center" valign="middle">');
		print('<img src="./img_' . $lang_cd . '/staffonly_mark.png" border="0">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('<hr>');
		print('<br>');
		
		//メンテお知らせ
		if( $SVkankyo == 9 ){
			//開発環境のみ
			print('<table border="0">');
			print('<tr>');
			print('<td width="950" align="center" bgcolor="#FF0099">');
			print('<font color="white">開発環境（試験運用中です）</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
		}
		if( $mntchk_flg == 3 ){
			//当日か翌日にメンテナンスがある場合
			print('<table border="0">');
			print('<tr>');
			print('<td width="950" align="center" bgcolor="#FF0099">');
			print('<font color="white">次の期間はメンテナンスのため、ログインはできません。<br>' . $mntchk_display_time . '</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
		}
		if( $mntchk_flg == 4 ){
			//１時間以内にメンテナンスがある場合
			print('<table border="0">');
			print('<tr>');
			print('<td width="950" align="center" bgcolor="red">');
			print('<font color="white">まもなくメンテナンスのため、ログインできなくなります。<br>開始時刻になりますと、予約処理が中断される場合がありますのでご注意ください。<br>' . $mntchk_display_time . '</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
		}
		print('<br>');
		
		print('<form name="form1" method="post" action="' . $sv_staff_adr . 'menu.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="J">');	//現在は日本語のみ
		if( $arg_p == "ENTRY" ){
			print('<input type="hidden" name="arg_p" value="ENTRY">');
			print('<input type="hidden" name="client_no" value="' . $entry_arg_client_no . '">');
			print('<input type="hidden" name="study_abroad_no" value="' . $entry_arg_study_abroad_no . '">');
		}else if( $arg_p == "ENTRY2" ){
			print('<input type="hidden" name="arg_p" value="ENTRY2">');
			print('<input type="hidden" name="client_no" value="' . $entry_arg_client_no . '">');
			print('<input type="hidden" name="study_abroad_no" value="' . $entry_arg_study_abroad_no . '">');
		}else if( $arg_p == "MAIL" ){
			print('<input type="hidden" name="arg_p" value="MAIL">');
			print('<input type="hidden" name="mailno_ang_str" value="' . $mailno_ang_str . '">');
		}else if( $arg_p == "CS" ){
			print('<input type="hidden" name="arg_p" value="CS">');
			print('<input type="hidden" name="cs_no" value="' . $cs_no . '">');
		}else if( $arg_p == "MAKE" ){
			print('<input type="hidden" name="arg_p" value="MAKE">');
			print('<input type="hidden" name="mail_adr" value="' . $mail_adr . '">');
		}
		
		//print('※スタッフコードとパスワードを入力後、ログインしてください。<BR><BR>');
		print('<img src="./img_' . $lang_cd . '/title_login.png" border="0"><br><br>');
		print('<table border="1">');
		print('<tr height="50">');
		print('<td width="250" bgcolor="blue"><img src="./img_' . $lang_cd . '/staffcd.png" border="0"></td>');
		$tabindex++;
		if( $staff_cd == ""){
			print('<td width="250" bgcolor="lightgreen" align="left">');
			print('<input type="text" tabindex="' . $tabindex . '" name="staff_cd" style="ime-mode:disabled; font-size:24px;" size="20" maxlength="20" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onBlur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
		}else{
			print('<td width="250" bgcolor="lightgreen" align="left">');
			print('<input type="text" tabindex="' . $tabindex . '" name="staff_cd" style="ime-mode:disabled; font-size:24px;" size="20" maxlength="20" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onBlur="this.style.backgroundColor=\'#E0FFFF\'" value="' . $staff_cd . '">');
			print('</td>');
		}
		print('</tr>');
		print('<tr height="50">');
		print('<td width="250" bgcolor="blue"><img src="./img_' . $lang_cd . '/password.png" border="0"></td>');
		$tabindex++;
		print('<td width="250" bgcolor="lightgreen" align="left">');
		print('<input name="staff_pw" tabindex="' . $tabindex . '" type="password" style="ime-mode:disabled; font-size:24px;" size="20" maxlength="20" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onBlur="this.style.backgroundColor=\'#E0FFFF\'">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('<br>');
	
		//ログインボタン
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" onClick="kurukuru()" border="0">');
		print('</form>');
		
		print('</center>');
		print('<br>');
		print('<hr>');
	
	}else{
		//メンテナンス中
		
		
		//強制ログアウトする（ログイン画面以外）
		if( $gmn_id != 'index_p.php'){
		
			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );

			//ログイン情報の更新
			$query = 'update D_STAFF_LOGIN set LOGIN_FLG = 0 where KG_CD = "' . $DEF_kg_cd . '" and TENPO_CD = "' . $tenpo_cd . '" and STAFF_CD = "' . $staff_cd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php.php' );
			
				//**ログ出力**
				$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
				$log_kktnp_kbn = 'T';		//顧客店舗区分（ K:顧客サイト  T:店舗サイト ）
				$log_tenpo_cd = $tenpo_cd;	//店舗コード
				$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
				$log_naiyou = 'スタッフログイン情報のupdateに失敗しました。';	//内容
				$log_err_inf = $query;		//エラー情報
				require( '../zz_log.php' );
				//************
				
			}else{

				//**トランザクション出力**
				$log_sbt = 'T';				//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション）
				$log_kktnp_kbn = 'T';		//顧客店舗区分（ K:顧客サイト  T:店舗サイト ）
				$log_tenpo_cd = $tenpo_cd;	//店舗コード
				$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
				$log_naiyou = 'メンテナンスのため、強制ログアウトしました';	//内容
				$log_err_inf = $query;		//エラー情報
				require( '../zz_log.php' );
				//************


				//**ログ出力**
				$log_sbt = 'N';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
				$log_kktnp_kbn = 'T';		//顧客店舗区分（ K:顧客サイト  T:店舗サイト ）
				$log_tenpo_cd = $tenpo_cd;	//店舗コード
				$log_kaiin_no = $staff_cd;	//会員番号 または スタッフコード
				$log_naiyou = 'メンテナンスのため、強制ログアウトしました';	//内容
				$log_err_inf = '';			//エラー情報
				require( '../zz_log.php' );
				//************
				
			}
		}

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

		//画面編集
		print('<center>');
		print('<table border="0">');
		print('<tr>');
		print('<td width="370" align="center" valign="middle">');
		print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
		print('</td>');
		print('<td width="265" align="left" valign="top">');
		//言語選択(Please select a language)
		print('<img src="./img_' . $lang_cd . '/lang_title.png" border="0"><br>');
		print('<table>');
		print('<tr>');
		print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="J">');
		print('<td>');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_j_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_j_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_j_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="E">');
		print('<td>');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_e_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_e_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_e_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="K">');
		print('<td>');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/lang_k_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/lang_k_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/lang_k_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
		
		print('</td>');
		print('<td width="180" align="left">');
		print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
		print('</td>');
		print('<td width="135" align="center" valign="middle">');
		print('<img src="./img_' . $lang_cd . '/staffonly_mark.png" border="0">');
		print('</td>');
		print('</tr>');
		print('</table>');
		print('<hr>');
		print('</center>');
		
		//画面編集
		print('<center>');

		print('<br><br><br><br><br><img src="./img_' . $lang_cd . '/bar_mentenansuchu.png" border="0">');
		if( $mntchk_flg == 1 ){
			//強制メンテナンス
			print('<br><br>（再開時刻は 未定 です）<br>');
		}else{
			//計画メンテナンス
			$mntchk_ed_youbi = date("w", mktime(0, 0, 0, substr($mntchk_ed_time_d,5,2), substr($mntchk_ed_time_d,8,2), substr($mntchk_ed_time_d,0,4)));
			print('<br><br>（再開時刻は ' . substr($mntchk_ed_time_d,0,4) . '年&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,5,2)) . '月&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,8,2)) . '日(' . $week[$mntchk_ed_youbi] . ')&nbsp;');
			if( intval(substr($mntchk_ed_time_d,11,2)) <= 12 ){
				print('午前&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,11,2)) );
			}else{
				print('午後&nbsp;' . sprintf("%d",(intval(substr($mntchk_ed_time_d,11,2)) - 12)) );
			}
			print('時' . substr($mntchk_ed_time_d,14,2) . '分 を予定しています）<br>');
		}
		
		print('<br><br>');
		print('再開までしばらくお待ちください。');
		print('<br><br>');

		print('<form name="form_ok" method="post" action="index.php">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" onClick="kurukuru()" border="0">');
		print('</form>');

		print('</center>');
		
			
	}
	
?>

</body>
</html>