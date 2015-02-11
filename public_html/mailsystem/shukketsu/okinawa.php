<?

	session_start();

	list(,$para1, $para2, $para3, $para4, $para5) = explode('/', $_SERVER['PATH_INFO']);
	$c_base = $_SERVER['REQUEST_URI'];

	$c_footer = '
		<div data-role="footer" class="footer-docs" data-theme="a">
		<p>&copy; 2011-2012 JAPAN Association for Working Holiday Makers.</p>
		</div>
	';

	$url_home = 'http://www.jawhm.or.jp/mailsystem/shukketsu/index.php';
	$url_top  = 'http://www.jawhm.or.jp/';

	if ($para1 <> 'id')	{
		$_SESSION['para1'] = $para1;
		$_SESSION['para2'] = $para2;
		$_SESSION['para3'] = $para3;
		$_SESSION['para4'] = $para4;
		$_SESSION['para5'] = $para5;
	}

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

<div data-role="page" id="toppage">
	<div data-role="header" data-theme="a">
		<h1>ワーホリ協会</h1>
		<a href="<? print $url_home; ?>" data-icon="home" data-direction="reverse" class="ui-btn-right jqm-home">Back</a>
	</div>
	<div data-role="content">

		<nav>
			<ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
				<li data-role="list-divider">沖縄セミナー状況</li>




<?

	// イベント読み込み
	$cal = array();

	$fuk_ymd   = array();
	$fuk_title = array();
	$fuk_desc  = array();
	$fuk_img   = array();
	$fuk_btn   = array();
	$fuk_id	   = array();

	try {
		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');

		// パラメータ確認
		$keyword  = ' and ( place = \'okinawa\' ';
		$keyword .= ' or k_title1 like \'%沖縄%\' ';
		$keyword .= ' or k_title2 like \'%沖縄%\' ';
		$keyword .= ' or k_desc2 like \'%沖縄%\' ';
		$keyword .= ' ) ';

		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, waitting FROM event_list WHERE k_use = 1 AND hiduke = DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.' ORDER BY hiduke, starttime, id');
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
			
			$title	= $start.' '.$row['k_title1'];

			// 沖縄
			$fuk_id[] = $row['id'];
			$fuk_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
			if ($row['free'] == 1)	{
				if ($mem_id == '')	{
					$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
				}else{
					$c_title = '';
				}
			}else{
				$c_title = '';
			}
			$c_desc  = $row['k_desc1'];
			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席]';
				}else{
					$c_img   	= '[残わずか]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$c_img   	= '[満席]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残わずか]';
					}else{
						$c_img	= '';
					}
				}
			}
			if ($row['free'] == 1)	{
				if ($mem_id == '')	{
					$c_btn	= '[メンバー限定]';
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}
			}else{
				if ($row['k_stat'] == 2)	{
					$c_btn	= '[満席]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
					}else{
						$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
					}
				}
			}

			$fuk_title[]	= $title.$c_title;
			$fuk_desc[]	= $c_desc;
			$fuk_img[]	= $c_img;
			$fuk_btn[]	= $c_btn;

			if ($c_img <> '')	{
				$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
			}

			$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
			$c_msg  = '<li><a href="./event.php?id='.$row['id'].'">';
			$c_msg .= $c_img.'';
			$c_msg .= '<h3>'.$month.'月'.$day.'日　'.$row['starttime'].'～　沖縄会場　　'.'予約状況：'.$row['booking'].' ( '.$row['waitting'].' ) '.$row['pax'].'</h3>';
			$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
			$c_msg .= '<p style="margin-left:30px;">'.nl2br(strip_tags($c_title.$c_desc)).'<br/></p>';
			$c_msg .= '</a></li>';

			$cal_msg[$year.$month.$day] .= $c_msg;
			$cal_cnt[$year.$month.$day]++;

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


function calender_list()	{

	global $cal;
	global $cal_msg;
	global $cal_cnt;

	$year = date('Y');
	$month = date('n');
	$day  = date('d');
	$day = $day - date('w');

	$yobi = array ('日','月','火','水','木','金','土');

	for($i=$day;$i<=$day + 150;$i++){
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		if (@$cal[date('Ynj', $print_today)] <> '')	{
			print ''.$cal_msg[date('Ynj', $print_today)].'';
		}
	}

}
	calender_list();
?>

	</div>
	<? print $c_footer; ?>
</div>


</body>
</html>
