<?php print("<?xml version=\"1.0\" encoding=\"shift_jis\" ?>"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>MSGROOVE �X��(D)</title>
</head>

<body>
<?php
	//�����̓���
	$mb_sbt = htmlspecialchars($_GET['m'],ENT_QUOTES,'shift_jis');
	$SN_str = htmlspecialchars($_GET['s'],ENT_QUOTES,'shift_jis');
	
	$gmn_nm = 'mb_index_d.php';

	//�T�[�o�[�ڑ�
	require( '../../zz_svconnect.php' );
	
	//�ڑ�����
	if( $svconnect_rtncd == 1 ){
		//�ڑ����s
		print('MSGROOVE�X��<br>');
		print('<hr>');
		print('<font color="#FF0000">�װ</font><br>');
		print('���ް�̐ڑ��Ɏ��s���܂���');

	}else{
		
		if( $mb_sbt != 'D' ){
			
			$agent = $_SERVER['HTTP_USER_AGENT'];			
			if(!preg_match('/^DoCoMo/i', $agent)){
			
				//��ʃ`�F�b�N�m�f
				print('MSGROOVE�X��<br>');
				print('<hr />');
				print('<font color="#FF0000">�װ</font><br>');
				print('���萔�ł����ĕ\�����Ă��������B<br><br>');
				print('<form method="post" id="post" action="../index.php">');
				print('<input type="submit" name="button" style="WIDTH: 95px; HEIGHT: 30px;" value="�ĕ\��" />');
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

			//���j���[�ҏW
			print('MSGROOVE�X��:۸޲�<br>');
			print('<hr>');
			print('<h6>�i�g�ѓd�b�ł̂����p�͂ł��܂���B�j</h6>');
			print('<hr>');
		}
	}
	mysql_close( $link );

?>
</body>
</html>
