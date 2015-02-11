<?

//	ini_set( "display_errors", "On");

	session_start();

	$c_footer = '
		<div data-role="footer" class="footer-docs" data-theme="a">
		<p>&copy; 2011- JAPAN Association for Working Holiday Makers.</p>
		</div>
	';

	$url_home = 'http://www.jawhm.or.jp/mailsystem/shukketsu/index.php';
	$url_top  = 'http://www.jawhm.or.jp/';


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
	<title>ワーホリ協会</title> 
	<link rel="stylesheet" href="http://www.jawhm.or.jp/mem/css/jquery.mobile-1.1.0.min.css" />
	<link rel="stylesheet" href="http://www.jawhm.or.jp/mem/css/themes/jawhm.min.css" />
	<script src="http://www.jawhm.or.jp/mem/js/jquery-1.7.2.min.js"></script>
	<script src="http://www.jawhm.or.jp/mem/js/jquery.mobile-1.1.0.min.js"></script>
</head>
<style>
.localnav {
	margin:0 0 20px 0;
	overflow:hidden;
}
.localnav li {
	float:left;
}
.localnav .ui-btn-inner { 
	padding: .6em 10px; 
	font-size:90%; 
}
</style>
<title>ワーホリ協会</title>
<body>

<div data-role="page" id="yoyaku<? print $para1; ?>">

	<div data-role="header" data-theme="a">
		<h1>セミナー予約状況</h1>
		<a href="<? print $url_home; ?>" data-icon="home" data-direction="reverse" class="ui-btn-right jqm-home">Back</a>
	</div>

	<div data-role="content" data-theme="a">

<?

	$id = $_GET['id'];
	$ord = $_GET['ord'];
	if ($ord == '')	{
		$ord = 'insdate';
	}

	$type = $_POST['type'];

	$tantou = $_POST['tantou'];
	$chukei = $_POST['chukei'];

	if ($type == 'go')	{
		// 担当者更新
		try {
			$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql = 'UPDATE event_list SET title = "'.$tantou.'" ,memo = "'.$chukei.'" WHERE id = '.$id;
			$stt = $db->prepare($sql);
			$stt->execute();

		} catch (PDOException $e) {
			print $e->getMessage();
		}

		// 出席更新処理
		$tgtid = '';
		foreach($_POST as $key => $val)	{
			if (substr($key,0,2) == 'cm' && $val == 'on')	{
				$tgtid[] = str_replace("cm","",$key);
			}
		}
		if ($tgtid)	{
			try {

				$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');

				for ($idx=0; $idx<count($tgtid); $idx++)	{
					print '更新: '.$tgtid[$idx].'<br/>';

					$stt = $db->prepare('SELECT id, seminarid, seminarname, customid, tel, email FROM entrylist WHERE id = '.$tgtid[$idx].' ORDER BY id');
					$stt->execute();
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$cur_seminarid = $row['seminarid'];
						$cur_seminarname = $row['seminarname'];
						$cur_customid = $row['customid'];
						$cur_tel = $row['tel'];
						$cur_email = $row['email'];
					}

					$stt = $db->prepare('SELECT id, crmid FROM event_list WHERE id = '.$cur_seminarid.' ORDER BY id');
					$stt->execute();
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$cur_crmid = $row['crmid'];
					}

					// 予約状態変更
					$sql = 'UPDATE entrylist SET stat = "2", wait = "0" WHERE id = '.$tgtid[$idx];
					$stt = $db->prepare($sql);
					$stt->execute();

					// ＣＲＭに転送
					$data = array(
							 'pwd' => '303pittST'
							,'act' => 'shusseki'
							,'edit_seminarid' => $cur_seminarid
							,'edit_seminarname' => $cur_seminarname
							,'edit_customid' => $cur_customid
							,'edit_crmid' => $cur_crmid
							,'edit_tel' => $cur_tel
							,'edit_email' => $cur_email
						);
					$url = 'https://toratoracrm.com/crm/';
					$val = wbsRequest($url, $data);
					$ret = json_decode($val, true);
				}

				// カレンダー変更
//				GC_Edit($cur_seminarid);

			} catch (PDOException $e) {
				print $e->getMessage();
			}
		}
	}


	try {
		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$sql = 'SELECT id, namae, furigana, tel, email, kyomi, jiki, sonota, ninzu, stat, wait FROM entrylist WHERE seminarid = '.$id.' and ( stat <> 5 and stat <> 6 ) order by ';
		if ( $ord == 'insdate')	{
			$sql .= ' insdate ';
		}else{
			$sql .= ' furigana ';
		}
		$rs = $db->query($sql);
		$cnt = 0;

		$listlist = '';
		$listlist2 = '';

?>

	<table><tr>
		<td><h2>予約者一覧　　</h2></td>
		<td>
			<ul data-role="controlgroup" data-type="horizontal" class="localnav">
				<li><a data-theme="a" style="font-size:12pt;" href="./event.php?id=<? print $id; ?>&ord=insdate" data-role="button" data-transition="fade"<? if ($ord == 'insdate') { print ' class="ui-btn-active"'; } ?>>　登録日順　</a></li>
				<li><a data-theme="a" style="font-size:12pt;" href="./event.php?id=<? print $id; ?>&ord=yomi" data-role="button" data-transition="fade"<? if ($ord == 'yomi') { print ' class="ui-btn-active"'; } ?>>　フリガナ順　</a></li>
			</ul>
		</td>
		<td>　　<? print date('H:i:s'); ?>現在</td>
	</tr></table>

<form method="post" action="event.php?id=<? print $id; ?>&ord=<? print $ord; ?>">

	<input type="hidden" name="type" value="go">





	<fieldset class="ui-grid-a">
		<div class="ui-block-a">
			<input type="submit" data-role="button" value="登録">
		</div>
		<div class="ui-block-c">
			<a href="#" onclick="$.mobile.changePage('event.php?id=<? print $id; ?>&ord=<? print $ord; ?>', { reloadPage : true, transition: 'flip'} ); " data-role="button">　リセット（再表示）　</a>
		</div>
	</fieldset>

<?
		print '<div data-role="content" data-theme="a">';
		print '<table border="1">';

		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;

			$stat = '不明';
			switch($row['stat'])	{
				case '0':
					$stat = '仮予約';	break;
				case '1':
					$stat = '予約';		break;
				case '2':
					$stat = '出席';		break;
				case '5':
					$stat = '自動CXL';	break;
				case '6':
					$stat = 'CXL';		break;
			}
			if ($row['wait'] == '1')	{
				$stat .= 'CXL待ち';
			}

			if ($row['stat'] == '2')	{
				print '<tr style="background: #00FFFF;">';
			}else{
				print '<tr>';
			}
			print '<td rowspan="2">'.$cnt.'</td>';
			print '<td>'.$stat.' ('.$row['ninzu'].')</td>';
			print '<td>'.$row['namae'].' 様</td>';
			print '<td>'.$row['furigana'].'</td>';
			print '<td rowspan="2">';
			if ($row['stat'] == '2')	{
				print '参加登録済み';
			}else{
				print '<select name="cm'.$row['id'].'" id="flip-a'.$row['id'].'" data-role="slider">';
				print '<option value="off">まだ</option>';
				print '<option value="on">来た</option>';
				print '</select>';
			}
			print '</td>';

			print '</tr>';
			if ($row['stat'] == '2')	{
				print '<tr style="background: #00FFFF;">';
			}else{
				print '<tr>';
			}
			print '<td colspan="3">'.$row['kyomi'].' ';
			if ($row['jiki'] <> '')	{
				print '( '.$row['jiki'].' )';
			}
			print '<br/>'.$row['sonota'].'</td>';
			print '</tr>';

		}

		print '</table>';
		print '</div>';

	} catch (PDOException $e) {
		die($e->getMessage());
	}

	$formon = false;
	try {
		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, waitting FROM event_list WHERE id = '.$id);
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$formon = true;

			$cnt++;
			$tantou	= $row['title'];
			$chukei	= $row['memo'];

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
			$title	= $row['k_title1'];

			if ($row['free'] == 1)	{
				$formon = false;
				print '<a target="_blank" href="'.$url_top.'member" data-role="button" data-rel="back" data-theme="a">ご予約はこちらから</a>';
			}
			$c_desc = $row['k_desc1'];

			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
//					$formon = false;
					$c_img   	= '[満席]';
				}else{
					$c_img   	= '[残わずか]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$formon = false;
				$c_img   	= '[満席]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
//					$formon = false;
					$c_img   	= '[満席]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残わずか]';
					}else{
						$c_img	= '';
					}
				}
			}

			print '&nbsp;<br/>';
			print '<div data-role="content" data-collapsed="true" data-theme="a">';
			print '<div style="color:red; font-weight:bold;">'.$c_img.'</div>';

			print '<table>';
			print '<tr><td style="vertical-align:top;"><img src="/mem/images/tama_04.gif"></td><td style="vertical-align:top;">';
			switch($row['place'])	{
				case 'tokyo':
					$place = '東京';
					break;
				case 'osaka':
					$place = '大阪';
					break;
				case 'fukuoka':
					$place = '福岡';
					break;
				case 'sendai':
					$place = '仙台';
					break;
				case 'toyama':
					$place = '富山';
					break;
				case 'okinawa':
					$place = '沖縄';
					break;
			}
//			print $place.'会場</td></tr>';
			print '予約件数 : '.$row['booking'].'　CXL待ち : '.$row['waitting'].'　定員 : '.$row['pax'].'</td></tr>';
			print '<tr><td style="vertical-align:top;"><img src="/mem/images/tama_04.gif"></td><td style="vertical-align:top;">'.$start.'</td></tr>';
			print '<tr><td style="vertical-align:top;"><img src="/mem/images/tama_04.gif"></td><td style="vertical-align:top;">'.$title.'</td></tr>';
			print '</table>';
			print '</div>';

		}

	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>

<table>
<tr><td>
<div data-role="fieldcontain">
	<label for="tantou">セミナー担当者</label>
	<input type="text" name="tantou" id="tantou" value="<?php print $tantou; ?>"  />
</div>
</td>
<td>
<input type="checkbox" name="chukei" id="chukei" class="custom" <?php if($chukei == 'on') { print 'checked'; } ?> />
<label for="chukei">中継</label>
</td>
</tr>
</table>

	<fieldset class="ui-grid-a">
		<div class="ui-block-a">
			<input type="submit" data-role="button" value="登録">
		</div>
		<div class="ui-block-c">
			<a href="#" onclick="$.mobile.changePage('event.php?id=<? print $id; ?>&ord=<? print $ord; ?>', { reloadPage : true, transition: 'flip'} ); " data-role="button">　リセット（再表示）　</a>
		</div>
	</fieldset>

	</form>

	</div>
	<? print $c_footer; ?>
</div>


</body>
</html>
<?

function wbsRequest($url, $params)
{
	$data = http_build_query($params);
	$content = file_get_contents($url.'?'.$data);
	return $content;
}


?>
