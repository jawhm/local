<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>テスト</title>
</head>
<body bgcolor="white">
<?php
				
	// ＣＲＭに転送
	$data = array(
		 'pwd' => '303pittST'
	);
	$url = 'https://toratoracrm.com/crm/test0613_2.php';
	$val = wbsRequest($url, $data);
	$ret = json_decode($val, true);
	
	$kekka = $ret['result'];
	$tehai_data = $ret['tehai_data'];

print('result[' . $kekka . ']<br>');

//	$tehai_data = mb_convert_encoding($tehai_data, "UTF-8","SJIS");



print('tehai_data[' . $tehai_data . ']<br>');




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
