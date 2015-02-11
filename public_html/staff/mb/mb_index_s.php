<?php print("<?xml version=\"1.0\" encoding=\"shift_jis\" ?>"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>MSGROOVE 店舗(S)</title>
</head>

<body>
<?php
	//引数の入力
	$mb_sbt = htmlspecialchars($_GET['m'],ENT_QUOTES,'shift_jis');
	$SN_str = htmlspecialchars($_GET['s'],ENT_QUOTES,'shift_jis');

	$gmn_nm = 'mb_index_s.php';

	//サーバー接続
	require( '../zz_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		//接続失敗
		print('MSGROOVE店舗<br>');
		print('<hr>');
		print('<font color="#FF0000">ｴﾗｰ</font><br>');
		print('ｻｰﾊﾞｰの接続に失敗しました');

	}else{
		
		if( $mb_sbt != 'S' ){
			
			$agent = $_SERVER['HTTP_USER_AGENT'];			
			if(!preg_match('/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i', $agent)){
			
				//画面チェックＮＧ
				print('MSGROOVE店舗<br>');
				print('<hr>');
				print('<font color="#FF0000">ｴﾗｰ</font><br>');
				print('お手数ですが再表示してください。<br><br>');
				print('<form name="form_err" id="form_err" method="post" action="../index.php">');
				print('<input type="submit" name="button" style="WIDTH: 95px; HEIGHT: 30px;" value="再表示" />');
				print('</form>');

			}else{
				$mb_sbt = 'S';
				//SoftBankの場合
				$i = strpos( $agent , 'SN' );
				$SN_str = '';
				if( $i != 0 ){
					$SN_str = substr( $agent , $i , 17 );
				}
			}
		}
		
//		if( $mb_sbt == 'S' ){
//			//SN番号が取得できているか
//			$syain_no = '';
//			$syain_pw = '';
//			$trk_flg = 1;	//初期値（1:SN登録する）
//			if( $SN_str != '' ){
//				$query = 'select count(*) from MST_SN where MB_SBT ="' . $mb_sbt . '" and SN_STR = "' . $SN_str . '";';
//				$result = mysql_query($query);
//				if (!$result) {
//					
//					//**ログ出力**
//					$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
//					$log_naiyou = 'ＳＮマスタのselectに失敗しました。';	//内容
//					$log_err_inf = $query;			//エラー情報
//					require( '../zz_log.php' );
//					//************
//					
//				}else{
//					$row = mysql_fetch_array($result);
//					if( $row[0] == 1 ){
//						$trk_flg = 2;	// 2:SN登録済み に変更する
//						//ＳＮ番号登録済みの場合
//						$query = 'select SYAIN_NO from MST_SN where MB_SBT ="' . $mb_sbt . '" and SN_STR = "' . $SN_str . '";';
//						$result = mysql_query($query);
//						if (!$result) {
//					
//							//**ログ出力**
//							$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
//							$log_naiyou = 'ＳＮマスタのselectに失敗しました。';	//内容
//							$log_err_inf = $query;			//エラー情報
//							require( '../zz_log.php' );
//							//************
//							
//						}else{
//							$row = mysql_fetch_array($result);
//							$syain_no = $row[0];	//社員番号
//							
//							$query = 'select DECODE(SYAIN_PW,"' . $ANGpw . '") from MST_SYAIN where SYAIN_NO =' . $syain_no . ';';
//							$result = mysql_query($query);
//							if (!$result) {
//								
//								//**ログ出力**
//								$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
//								$log_naiyou = '社員マスタのselectに失敗しました。';	//内容
//								$log_err_inf = $query;			//エラー情報
//								require( '../zz_log.php' );
//								//************
//								
//							}else{
//								$row = mysql_fetch_array($result);
//								$syain_pw = $row[0];	//社員PW
//							}
//						}
//					}
//				}
//			}
						
			//メニュー編集
			print('MSGROOVE店舗:ﾛｸﾞｲﾝ<br>');
			print('<hr>');
			print('<h6>（携帯電話でのご利用はできません。）</h6>');
			print('<hr>');

		}
	}
	mysql_close( $link );
?>

</body>
</html>
