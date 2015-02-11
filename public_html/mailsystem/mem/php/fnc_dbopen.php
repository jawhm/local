<?php

	try {
		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$db->query('SET CHARACTER SET utf8');
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>
