
<style>
.button_yoyaku	{
	background-color: navy;
	color: white;
	cursor: pointer;
	padding: 0 10px 0 10px;
	margin: 0 0 3px 0;
	font-weight: bold;
}
.button_submit	{
	background: url(images/button_submit.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_cancel	{
	background: url(images/button_cancel.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_next	{
	background: url(images/button_next.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.shibori	{
	font-size: 10pt;

}
.open	{
	font-size:9pt;
	font-weight:bold;
	color : orange;
	cursor:pointer;
	margin: 0 0 10px 0;
}
</style>

<?php

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');

		$cal = array();
		$tyo_ymd   = array();
		$tyo_title = array();
		$tyo_desc  = array();
		$tyo_img   = array();
		$tyo_btn   = array();
		$tyo_id	   = array();

		$keyword  = ' and free = \'0\' and ( k_title1 like \'%'.$keyword.'%\' or k_desc1 like \'%'.$keyword.'%\' ) ';
		$keyword .= ' and k_desc1 like \'%秋のワーホリ・留学フェア2013%\'';
		$keyword .= ' and hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) ';
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) <br/> %k:%i\') as start, date_format(starttime, \'%a\') as youbi, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, type FROM event_list WHERE k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, place, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);

			$youbi	= $row['youbi'];
			$youbi	= mb_ereg_replace('Mon', '月', $youbi);
			$youbi	= mb_ereg_replace('Tue', '火', $youbi);
			$youbi	= mb_ereg_replace('Wed', '水', $youbi);
			$youbi	= mb_ereg_replace('Thu', '木', $youbi);
			$youbi	= mb_ereg_replace('Fri', '金', $youbi);
			$youbi	= mb_ereg_replace('Sat', '土', $youbi);
			$youbi	= mb_ereg_replace('Sun', '日', $youbi);
			
			$place  = $row['place'];
			if ($place == 'tokyo')	$place = '<b>東京</b>';
			if ($place == 'osaka')	$place = '<b>大阪</b>';
			if ($place == 'fukuoka')	$place = '<b>福岡</b>';
			if ($place == 'nagoya')	$place = '<b>名古屋</b>';
			if ($place == 'okinawa')	$place = '<b>沖縄</b>';
			if ($place == 'event')		$place = '<b>イベント</b>';

			$title	= $start.' '.$row['k_title1'];

			$tyo_id[] = $row['id'];
			$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
			$c_title = '';
			$c_desc = $row['k_desc1'];
			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席です]';
				}else{
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$c_img   	= '[満席です]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}else{
						$c_img	= '';
					}
				}
			}
			if ($row['k_stat'] == 2)	{
				$c_btn	= '[満席]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
					$c_btn	= '<span class="button_yoyaku" onmouseover="this.style.backgroundColor=\'#0061D7\';" onmouseout="this.style.backgroundColor=\'navy\';" onclick="parent.fnc_yoyaku(this);" title="['.$place.'A]'.$title.'" uid="'.$row['id'].'">キャンセル待ち</span>';
				}else{
					$c_btn	= '<span class="button_yoyaku" onmouseover="this.style.backgroundColor=\'#0061D7\';" onmouseout="this.style.backgroundColor=\'navy\';" onclick="parent.fnc_yoyaku(this);" title="['.$place.'A]'.$title.'" uid="'.$row['id'].'">予約</span>';
				}
			}

			$tyo_title[]	= $title.$c_title;
			$tyo_desc[]	= $c_desc;
			$tyo_img[]	= $c_img;
			$tyo_btn[]	= $c_btn;

			if ($c_img <> '')	{
				$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
			}

			$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$start.' </td><td nowrap style="vertical-align:top;">'.$place.' '.$c_btn.'</td>';
			$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';

			if ($cnt == 1)	{
				echo '&nbsp;<br/>';
				echo '&nbsp;<br/>';
				echo '<Font Size="2">';
				echo '<span style="color:navy;"><b>セミナースケジュール　（ご予約時は会場にご注意ください）</b></span></font><br />';
				echo '<HR size="1" color="#cccccc" style="border-style:dotted">';
				echo '<table style="font-size:10pt;">';
			}

			echo $c_msg;

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	if ($cnt != 0)	{
		echo '</table>';
	}

?>
