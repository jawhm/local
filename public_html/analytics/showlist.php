<?php
try {
	$ini = parse_ini_file('../../bin/pdo_jawhm_bar.ini', FALSE);
	$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('SET CHARACTER SET utf8');
	$rs = $db->query('SHOW TABLES');
}  catch (PDOException $e) {
	die($e->getMessage());
}
?>
<html>
<head>
<title>データ・ダウンロード</title>
</head>
<body>
<h1 style="color:white;background-color:#525D76;font-size:22px;">
	データ・ダウンロード</h1>
<form method="POST" action="download.php">
<select name="table">
	<?php while($row = $rs->fetch(PDO::FETCH_NUM)){ ?>
		<option value="<?php print($row[0]); ?>">
			<?php print($row[0]); ?></option>
	<?php } ?>
</select>
<input type="submit" value="ダウンロード" />
<input type="reset"  value="取消" />
</form>
</body>
</html>
