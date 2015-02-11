<?php
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$_POST['table'].'.txt');
try {
	$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
	$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('SET CHARACTER SET utf8');
	$rs = $db->query('SELECT * FROM `'.str_replace('`', '``', $_POST['table']).'`');
	for($i=0; $i < $rs->columnCount(); $i++){
		$data = $rs->getColumnMeta($i);
		print($data['name']."\t");
	}
	print("\n");
	while($row = $rs->fetch(PDO::FETCH_NUM)){
		for($i=0; $i < $rs->columnCount(); $i++){
			print(mb_convert_encoding($row[$i], 'SJIS', 'UTF-8')."\t");
		}
		print("\n");
	}
	$db = NULL;
}  catch (PDOException $e) {
	die($e->getMessage());
}
