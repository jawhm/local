<?php

try {
	$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
	$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('SET CHARACTER SET utf8');

	$rs = $db->query('SELECT id FROM event_list where k_use = 1 and hiduke > current_date()');

	$ids = array();
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		$ids[] = $row['id'];
	}

	$filename = 'sitemap_' . date('YmdHis') . '.xml';
	// $filepath = $_SERVER['DOCUMENT_ROOT'] . '/' . $filename;
	$filepath = '/tmp/' . $filename;
	foreach ($ids as $one) {
		if (empty($one)) continue;
		$xml = '
<url>
  <loc>http://www.jawhm.or.jp/s/go/' . $one . '</loc>
  <priority>0.5</priority>
</url>';
		file_put_contents($filepath, $xml, FILE_APPEND);
	}

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $filename . '"');
	header('Content-Length: '.filesize($filepath));
	readfile($filepath);

	/*
	$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE k_use = 1 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) ORDER BY hiduke, starttime, id');
	$cnt = 0;
	while($row = $rs->fetch(PDO::FETCH_ASSOC)){
		$cnt++;
		$year	= $row['yy'];
		$month  = $row['mm'];
		$day	= $row['dd'];

		if ($row['place'] == 'event' || $row['place'] == 'sendai' || $row['place'] == 'okinawa')	{
			// イベント
			$evt_id[] = $row['id'];
			$evt_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
			$evt_title[] = $row['k_title1'];
			$evt_desc[]  = $row['k_desc1'];
			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
					$evt_img[]   	= '<img src="./images/semi_full.jpg">';
				}else{
					$evt_img[]   	= '<img src="./images/semi_now.jpg">';
				}
			}elseif ($row['k_stat'] == 2)	{
				$evt_img[]   	= '<img src="./images/semi_full.jpg">';
			}else{
				if ($row['booking'] >= $row['pax'])	{
					$evt_img[]   	= '<img src="./images/semi_full.jpg">';
				}else{
					if ($row['booking'] >= $row['pax'] / 2)	{
						$evt_img[]   	= '<img src="./images/semi_now.jpg">';
					}else{
						$evt_img[]	= '';
					}
				}
			}
			if ($row['free'] == 1)	{
				$evt_btn[]	= '<div style="padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定イベントです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a></div>';
			}else{
				if ($row['k_stat'] == 2)	{
					$evt_btn[]	= '';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$evt_btn[]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[イベント]'.$row['k_title1'].'" uid="'.$row['id'].'">';
					}else{
						$evt_btn[]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[イベント]'.$row['k_title1'].'" uid="'.$row['id'].'">';
					}
				}
			}
			$cal[$year.$month.$day] .= '<img src="images/sa04.jpg">';
		}
	}
*/
} catch (PDOException $e) {
	die($e->getMessage());
}
