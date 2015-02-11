<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>メールリスト登録（2012-11-28用）</title>
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
	$gmn_id = 'maillist_trk.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	//$ok_gmn = array('kanri_office_trk1.php');

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

	print('<font size="1" color="gray">処理開始しました。(' . date("Y-m-d H:i:s",time() ). ')</font><BR>');
	print('<hr>');
	flush();
	ob_flush();
	

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = "J";
	$office_cd = "tokyo";
	$staff_cd = "axdtanabe";
	
	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zs_errgmn.php' );

	//エラーなし
	}else{
		
		$read_cnt = 0;
		$write_cnt = 0;

		//Z_DATAの存在チェック
		$query = 'select count(*) from Z_DATA;';
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
			$log_naiyou = 'Z_DATAの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
print('Z_DATAは [' . $row[0] . ']件です。<br>');
print('<hr>');
flush();
ob_flush();

			if( $row[0] > 0 ){
				//Z_DATA全件取得
				$query = 'select ID,MAIL_ADR,NM,K_NO,KYOTEN_CD,URL from Z_DATA order by ID;';
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
					$log_naiyou = 'Z_DATAの参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
		
				}else{
					while( $row = mysql_fetch_array($result) ){
						$read_cnt++;
						
						if( ($read_cnt % 1000) == 0 ){
							print('<font size="1" color="gray">*** ' . $read_cnt . '件目処理中***</font><BR>');
							flush();
							ob_flush();
						}
						
						$id = $row[0];			//ID
						$mail_adr = $row[1];	//メールアドレス
						$nm = $row[2];			//名前
						$k_no = $row[3];		//お客様番号
						$kyoten_cd = $row[4];	//拠点コード
						$url = $row[5];			//ＵＲＬ
						
						if( $kyoten_cd == "" || $mail_adr == "" ){
							
							//**ログ出力**
							$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = 'tokyo';	//オフィスコード
							$log_kaiin_no = 'axdtanabe';		//会員番号 または スタッフコード
							$log_naiyou = 'キー項目が未設定<br>ID[' . $id . '] 拠点[' . $kyoten_cd . '] メアド[' . $mail_adr . ']';	//内容
							$log_err_inf = '';			//エラー情報
							require( './zs_log.php' );
							//************
									
							print('<font color="red">キー項目が未設定</font>  ID[' . $id . '] 拠点[' . $kyoten_cd . '] メアド[' . $mail_adr . ']<br>');
							flush();
							ob_flush();
							
							continue;	
						}
						
						$pos = strpos($nm,"?");
						if( $pos !== false ){
							print('<font color="green">名前を直してください</font>  ID[' . $id . '] 名前[' . $nm . ']<br>');
							flush();
							ob_flush();
						}
						
						
						
						if(	$url != "" ){
							$pos = strpos($url,"?u=");
							if( $pos !== false ){
								$pos += 3;
								$find_flg = 0;
								$edit_url = "";
								while( $find_flg == 0 && $pos <= strlen($url) ){
									$tmp_char = substr($url,$pos,1);
									if( $tmp_char == "&" ){
										$find_flg = 1;
									}else{
										$edit_url .= $tmp_char;
										$pos++;
									}
								}
								if( $find_flg == 1 ){
									$url = $edit_url;
								}else{
									//**ログ出力**
									$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = 'tokyo';	//オフィスコード
									$log_kaiin_no = 'axdtanabe';		//会員番号 または スタッフコード
									$log_naiyou = 'URLで[&]が見つからない<br>ID[' . sprintf("%05d",$id) . '] URL[' . $url . ']';	//内容
									$log_err_inf = '';			//エラー情報
									require( './zs_log.php' );
									//************
									
									print('URLで[&]が見つからない。ID[' . sprintf("%05d",$id) . '] URL[' . $url . ']<br>');
									flush();
									ob_flush();
									
									$url = "";
								}
							}else{
								//**ログ出力**
								$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = 'tokyo';	//オフィスコード
								$log_kaiin_no = 'axdtanabe';		//会員番号 または スタッフコード
								$log_naiyou = 'URLで[?u=]が見つからない<br>ID[' . sprintf("%05d",$id) . '] URL[' . $url . ']';	//内容
								$log_err_inf = '';			//エラー情報
								require( './zs_log.php' );
								//************
								
								print('URLで[?u=]が見つからない。ID[' . sprintf("%05d",$id) . '] URL[' . $url . ']<br>');
								flush();
								ob_flush();
								
								$url = "";
							}
						}
						
						//memlist へ登録する
						//文字コード設定（insert/update時に必須）
						require( '../zz_mojicd.php' );
						
						$query2 = 'insert into maillist_test values(';
						$query2 .= '"' . $kyoten_cd . '",';	//拠点コード
						$query2 .= '"' . $mail_adr . '",';	//メールアドレス
						$query2 .= '"' . $nm . '",';		//名前1
						$query2 .= '"",';					//名前2
						$query2 .= '"2012/01/01",';			//cdate
						$query2 .= '"2012/01/01",';			//udate
						$query2 .= '"1",';					//vsend
						$query2 .= '"登録",';				//vstat
						$query2 .= '"' . $url . '",';		//vcheck
						$query2 .= '"' . $k_no . '",';		//vid
						$query2 .= '0);';		//vid
						
						$result2 = mysql_query($query2);
						if (!$result2) {
				
							//**ログ出力**
							$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = '重複キーが発生しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
							
							print('キー重複  ID[' . sprintf("%05d",$id) . '] 拠点[' . $kyoten_cd . '] メアド[' . $mail_adr . ']<br>');
							flush();
							ob_flush();
							
						}else{
							$write_cnt++;
						
						}
					}
				}
			}
		}
	}

	mysql_close( $link );

	print('<hr>');
	print('入力件数[' . sprintf("%05d",$read_cnt) . ']件 出力件数[' . sprintf("%05d",$write_cnt) . ']件<BR>');
	print('<hr>');
	print('<font size="1" color="gray">処理終了しました。(' . date("Y-m-d H:i:s",time() ). ')</font><BR>');
	flush();
	ob_flush();

?>
</body>
</html>