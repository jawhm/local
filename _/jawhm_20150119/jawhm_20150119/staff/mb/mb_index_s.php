<?php print("<?xml version=\"1.0\" encoding=\"shift_jis\" ?>"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>MSGROOVE �X��(S)</title>
</head>

<body>
<?php
	//�����̓���
	$mb_sbt = htmlspecialchars($_GET['m'],ENT_QUOTES,'shift_jis');
	$SN_str = htmlspecialchars($_GET['s'],ENT_QUOTES,'shift_jis');

	$gmn_nm = 'mb_index_s.php';

	//�T�[�o�[�ڑ�
	require( '../zz_svconnect.php' );
	
	//�ڑ�����
	if( $svconnect_rtncd == 1 ){
		//�ڑ����s
		print('MSGROOVE�X��<br>');
		print('<hr>');
		print('<font color="#FF0000">�װ</font><br>');
		print('���ް�̐ڑ��Ɏ��s���܂���');

	}else{
		
		if( $mb_sbt != 'S' ){
			
			$agent = $_SERVER['HTTP_USER_AGENT'];			
			if(!preg_match('/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i', $agent)){
			
				//��ʃ`�F�b�N�m�f
				print('MSGROOVE�X��<br>');
				print('<hr>');
				print('<font color="#FF0000">�װ</font><br>');
				print('���萔�ł����ĕ\�����Ă��������B<br><br>');
				print('<form name="form_err" id="form_err" method="post" action="../index.php">');
				print('<input type="submit" name="button" style="WIDTH: 95px; HEIGHT: 30px;" value="�ĕ\��" />');
				print('</form>');

			}else{
				$mb_sbt = 'S';
				//SoftBank�̏ꍇ
				$i = strpos( $agent , 'SN' );
				$SN_str = '';
				if( $i != 0 ){
					$SN_str = substr( $agent , $i , 17 );
				}
			}
		}
		
//		if( $mb_sbt == 'S' ){
//			//SN�ԍ����擾�ł��Ă��邩
//			$syain_no = '';
//			$syain_pw = '';
//			$trk_flg = 1;	//�����l�i1:SN�o�^����j
//			if( $SN_str != '' ){
//				$query = 'select count(*) from MST_SN where MB_SBT ="' . $mb_sbt . '" and SN_STR = "' . $SN_str . '";';
//				$result = mysql_query($query);
//				if (!$result) {
//					
//					//**���O�o��**
//					$log_sbt = 'E';				//���O���    �i N:�ʏ탍�O  W:�x��  E:�G���[ �j
//					$log_naiyou = '�r�m�}�X�^��select�Ɏ��s���܂����B';	//���e
//					$log_err_inf = $query;			//�G���[���
//					require( '../zz_log.php' );
//					//************
//					
//				}else{
//					$row = mysql_fetch_array($result);
//					if( $row[0] == 1 ){
//						$trk_flg = 2;	// 2:SN�o�^�ς� �ɕύX����
//						//�r�m�ԍ��o�^�ς݂̏ꍇ
//						$query = 'select SYAIN_NO from MST_SN where MB_SBT ="' . $mb_sbt . '" and SN_STR = "' . $SN_str . '";';
//						$result = mysql_query($query);
//						if (!$result) {
//					
//							//**���O�o��**
//							$log_sbt = 'E';				//���O���    �i N:�ʏ탍�O  W:�x��  E:�G���[ �j
//							$log_naiyou = '�r�m�}�X�^��select�Ɏ��s���܂����B';	//���e
//							$log_err_inf = $query;			//�G���[���
//							require( '../zz_log.php' );
//							//************
//							
//						}else{
//							$row = mysql_fetch_array($result);
//							$syain_no = $row[0];	//�Ј��ԍ�
//							
//							$query = 'select DECODE(SYAIN_PW,"' . $ANGpw . '") from MST_SYAIN where SYAIN_NO =' . $syain_no . ';';
//							$result = mysql_query($query);
//							if (!$result) {
//								
//								//**���O�o��**
//								$log_sbt = 'E';				//���O���    �i N:�ʏ탍�O  W:�x��  E:�G���[ �j
//								$log_naiyou = '�Ј��}�X�^��select�Ɏ��s���܂����B';	//���e
//								$log_err_inf = $query;			//�G���[���
//								require( '../zz_log.php' );
//								//************
//								
//							}else{
//								$row = mysql_fetch_array($result);
//								$syain_pw = $row[0];	//�Ј�PW
//							}
//						}
//					}
//				}
//			}
						
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
