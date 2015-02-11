<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－スタッフ（パスワード初期化）</title>
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
function disableSubmit(form) {
	var elements = form.elements;
	for (var i = 0; i < elements.length; i++) {
		if (elements[i].type == 'submit') {
			elements[i].disabled = true;
		}
	}
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
	$gmn_id = 'kanri_staff_pwclear1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_staff_pwclear0.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];
	
	//固有引数の取得
	$select_office_cd = $_POST['select_office_cd'];
	$stf_cd = $_POST['stf_cd'];

	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}
		
	//引数入力チェック
	if ( $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $stf_cd == "" || $lang_cd == "" ){
		$err_flg = 3;
	}

	//ログインチェック
	require( './zs_staff_loginchk.php' );	
	if ($LC_rtncd == 1){
		$err_flg = 9;
	}
	
	//サーバー接続エラー
	if( $err_flg == 1 ){
		//エラー画面編集
		require( './zs_errgmn.php' );
		
	//引数エラー
	}else if( $err_flg == 3 ){
		//エラーメッセージ表示
		print('<font color="red">エラー：管理者へ連絡してください。</font><br>');

		print('<input type="button" name="button" style="WIDTH: 100px; HEIGHT: 50px;" value="閉じる" onClick=winclose() />');


	//タイムオーバー
	}else if( $err_flg == 9 ){
		//エラーメッセージ表示
		print('<font color="red">※一定時間を越えたため、表示できません。</font><br>');

		print('<input type="button" name="button" style="WIDTH: 100px; HEIGHT: 50px;" value="閉じる" onClick=winclose() />');

	//エラーなし
	}else{

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_tojiru2_2.png" width="0" height="0" style="visibility:hidden;">');


		//対象のスタッフを参照する
		$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") ' .
				 'from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
			$row = mysql_fetch_array($result);
			$stf_nm = $row[0];		//スタッフ名
		
		}
		
		//パスワードを初期化する
		if( $err_flg == 0 ){

			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
			
			//スタッフマスタ
			$query = 'update M_STAFF set STAFF_PW = ENCODE(NULL,"' . $ANGpw . '"),UPDATE_TIME = "' . $now_time . '",UPDATE_STAFF_CD = "' . $staff_cd . '" where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
				$log_naiyou = 'スタッフマスタの更新に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
			
			}else{
				
				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフマスタを更新しました。(PW初期化)';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}
			
			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
			
			//スタッフログイン情報
			$query = 'update D_STAFF_LOGIN set LOGIN_FLG = 0,ERR_CNT = (-1) where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
				$log_naiyou = 'スタッフログイン情報の更新に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
			
			}else{
				
				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフログイン情報を更新しました。(PW初期化)';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}
		}


		if( $err_flg  == 0 ){	

			//**ログ出力**
			$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'ログインパスワードを初期化しました。対象スタッフ[' . $stf_nm . ']';	//内容
			$log_err_inf = '';			//エラー情報
			require( './zs_log.php' );
			//************

			//ページ編集
			print('<center>');
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="370" align="left">');
			print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
			print('</td>');
			print('<td width="322" align="right">');
			//閉じるボタン
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_tojiru2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_tojiru2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_tojiru2_1.png\';" onClick=winclose() border="0">');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
			
			//「このスタッフのログインパスワードを初期化しました。」
			print('<img src="./img_' . $lang_cd . '/title_pwclear_ok.png" border="0"><br><br>');
			
			print('<font size="6" color="black">' . $stf_nm . '</font><br><br><br><br>');
			
			print('<hr>');
			
			print('</center>');
		}
	}

	mysql_close( $link );
?>
</body>
</html>