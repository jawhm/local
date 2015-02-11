
<? 

mb_language("Ja");
mb_internal_encoding("utf8");


//include_once 'fnc_header.php';

?>


<style>
.list:link	{ color : white }
.list:visited	{ color : white }
.list:hover	{ color : white }
.list:active	{ color : white }
</style>


<h1>花見めーる</h1>

<?php

	ini_set( "display_errors", "On");

	$mode = @$_POST['mode'];
	if ($mode == '') { $mode = @$_GET['mode']; }
	$title = @$_POST['title'];

	if ($mode == 'upd')	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql = 'UPDATE imakoko SET title = :title';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':title', $title);
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

?>
<h2>更新完了 <? echo date('G:i:s'); ?></h2>
<?
	}

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT title FROM imakoko');
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

?>
<form action="./edit.php" method="post">
<table border="1">
	<tr>
		<td>花見メール<br/>（自動改行なし、タグ有効）</td>
		<td>
			<textarea name="title" rows=10 cols=50><? print $title; ?></textarea>
		</td>
	</tr>
</table>
<input type="hidden" name="mode" value="upd">
<input type="submit" value="更新">
</form>

<?
//include_once 'fnc_footer.php';
?>
