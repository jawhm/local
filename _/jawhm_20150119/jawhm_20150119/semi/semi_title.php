<?
	ini_set( "display_errors", "On");
	mb_language("Ja");
	mb_internal_encoding("utf8");

	$title = '';

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT title FROM semitxt');
		$stt->execute();
		$idx = 0;
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			$title = $row['title'];
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	print $title;

?>
