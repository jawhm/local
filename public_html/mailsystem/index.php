
<? include_once 'fnc_header.php'; ?>



<h1>メール一括送信</h1>

どのメーリングリストに送信しますか？<br/>&nbsp;<br/>

　　【トラトラ】<br/>
<!--
　　・　<a href="./put_tr.php">東京トラトラ</a><br/>
　　・　<a href="./put_or.php">大阪トラトラ</a><br/>
-->
&nbsp;<br/>
　　【ワーホリ協会】<br/>
　　・　<a href="./put_kt_ippan.php">協会（日本人）（協会メール会員）</a><br/>
　　・　<a href="./put_se.php">協会（日本人）（セミナー予約者）</a><br/>
　　・　<a href="./put_jw.php">協会（日本人）（メンバー）</a><br/>
　　・　<a href="./put_kt.php">協会（求職：外国人）</a><br/>

&nbsp;<br/>
&nbsp;<br/>
<hr/>
&nbsp;<br/>

メール送信待ち件数　：　

<?php

	ini_set( "display_errors", "On");

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT count(*) FROM mail_queue');
		$stt->execute();
		$idx = 0;
		while($row = $stt->fetch(PDO::FETCH_NUM)){
			print($row[0].'件<br/>');
		}
		$db = NULL;

	} catch (PDOException $e) {
		die($e->getMessage());
	}
?>





<? include_once 'fnc_footer.php'; ?>

