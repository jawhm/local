<?php

	list(,$para1,$para2,$para3,$para4,$para5,$para6,$para7,$para8,$para9,$para10) = explode('/', $_SERVER['PATH_INFO']);

	if ($para1 <> '' && $para2 == '')	{
		// セミナーＩＤによるリンク
		header("Location: /seminar/seminar.php?num=$para1&douji=1&go=1");
		exit;
	}

	// セミナー検索
	header("Location: /seminar/seminar.php?navigation=1&month=$para1&year=$para2&place_name=$para3&checked_countryname=$para4&checked_know=$para5&go=1");

?>