<?php print("<?xml version=\"1.0\" encoding=\"shift_jis\" ?>"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>MSGROOVE 店舗(D)</title>
</head>

<body>
<?php
	//引数の入力
	$mb_sbt = htmlspecialchars($_GET['m'],ENT_QUOTES,'shift_jis');
	$SN_str = htmlspecialchars($_GET['s'],ENT_QUOTES,'shift_jis');
	
	$gmn_nm = 'mb_index_d.php';

	//サーバー接続
	require( '../../zz_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		//接続失敗
		print('MSGROOVE店舗<br>');
		print('<hr>');
		print('<font color="#FF0000">ｴﾗｰ</font><br>');
		print('ｻｰﾊﾞｰの接続に失敗しました');

	}else{
		
		if( $mb_sbt != 'D' ){
			
			$agent = $_SERVER['HTTP_USER_AGENT'];			
			if(!preg_match('/^DoCoMo/i', $agent)){
			
				//画面チェックＮＧ
				print('MSGROOVE店舗<br>');
				print('<hr />');
				print('<font color="#FF0000">ｴﾗｰ</font><br>');
				print('お手数ですが再表示してください。<br><br>');
				print('<form method="post" id="post" action="../index.php">');
				print('<input type="submit" name="button" style="WIDTH: 95px; HEIGHT: 30px;" value="再表示" />');
				print('</form>');

			}else{
				$mb_sbt = 'D';
			}
		}
		
		if( $mb_sbt == 'D' ){
			$syain_no = '';
			$syain_pw = '';
			$trk_flg = 0;
			$SN_str = '';

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
