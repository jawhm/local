<html>
<title>セミナー情報</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
body {
	background: white;
	margin: 15px auto 20px;
}
#newsticker { 
	width: 440px;
	background: orange;
	padding: 10px 5px 10px 20px;
	font-family: Verdana,Arial,Sans-Serif;
	font-size: 12px;
	margin: 20px 0 0 0;
}
#newsticker .title {
	text-align: center;
	font-size: 16px;
	font-weight: bold;
	padding: 5px 0 10px 0;
	color: navy;
}
.newsticker-jcarousellite { width: 420px; }
.newsticker-jcarousellite ul li{ list-style:none; display:block; padding-bottom:1px; margin-bottom:5px; vertical-align:bottom; }
.newsticker-jcarousellite .thumbnail { float:left; width:95px; }
.newsticker-jcarousellite .info { float:right; width:320px; vertical-align:bottom; }
.newsticker-jcarousellite .info span.til1 { display: block; font-size:14px; color:#800000; border-bottom:1px dotted navy; }
.newsticker-jcarousellite .info span.desc { display: block; font-size:12px; color:#006400; }
</style>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.corner.js"></script>
<script type="text/javascript" src="jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="jcarousellite.js"></script>

<script type="text/javascript">
$(function () {
	$('#newsticker').corner();
	$(".newsticker-jcarousellite").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 3,
		auto:6000,
		speed:1500
	});
});
</script>


<body>

<div id="newsticker">
	<div class="title">
		<img src="http://www.jawhm.or.jp/event/getlist/img/te02.gif">
		<img src="http://www.jawhm.or.jp/event/getlist/img/te02.gif">
		&nbsp;夢をかなえるトラトラの無料セミナー情報&nbsp;
		<img src="http://www.jawhm.or.jp/event/getlist/img/te02.gif">
		<img src="http://www.jawhm.or.jp/event/getlist/img/te02.gif">
	</div>
	<div class="newsticker-jcarousellite">
		<ul>

<?

//ini_set( "display_errors", "On");

function print_sc($data)	{
	print $data;
}

	// イベント読み込み
	$cal = array();

	$tyo_ymd   = array();
	$tyo_title = array();
	$tyo_desc  = array();
	$tyo_img   = array();

	$osa_ymd   = array();
	$osa_title = array();
	$osa_desc  = array();
	$osa_img   = array();

	$fuk_ymd   = array();
	$fuk_title = array();
	$fuk_desc  = array();
	$fuk_img   = array();

	$sen_ymd   = array();
	$sen_title = array();
	$sen_desc  = array();
	$sen_img   = array();

	$evt_ymd   = array();
	$evt_title = array();
	$evt_desc  = array();
	$evt_img   = array();

	try {
		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, t_use, t_title1, t_desc1, t_stat FROM event_list WHERE t_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 day")).'"  ORDER BY hiduke, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			if ($row['place'] == 'event')	{
				// イベント
				$evt_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$evt_title[] = $row['t_title1'];
				$evt_desc[]  = $row['t_desc1'];
				if ($row['t_stat'] == 1)	{
					$evt_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';
				}elseif ($row['t_stat'] == 2)	{
					$evt_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';
				}else{
					$evt_img[]	= '';
				}
				$cal[$year.$month.$day] .= '/event';
			}

			if ($row['place'] == 'tokyo')	{
				// 東京
				$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$tyo_title[] = $row['t_title1'];
				$tyo_desc[]  = $row['t_desc1'];
				if ($row['t_stat'] == 1)	{
					$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';
				}elseif ($row['t_stat'] == 2)	{
					$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';
				}else{
					$tyo_img[]	= '';
				}
				$cal[$year.$month.$day] .= '/tokyo';
			}

			if ($row['place'] == 'osaka')	{
				// 大阪
				$osa_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$osa_title[] = $row['t_title1'];
				$osa_desc[]  = $row['t_desc1'];
				if ($row['t_stat'] == 1)	{
					$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';
				}elseif ($row['t_stat'] == 2)	{
					$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';
				}else{
					$osa_img[]	= '';
				}
				$cal[$year.$month.$day] .= '/osaka';
			}

			if ($row['place'] == 'fukuoka')	{
				// 福岡
				$fuk_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$fuk_title[] = $row['t_title1'];
				$fuk_desc[]  = $row['t_desc1'];
				if ($row['t_stat'] == 1)	{
					$fuk_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';
				}elseif ($row['t_stat'] == 2)	{
					$fuk_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';
				}else{
					$fuk_img[]	= '';
				}
				$cal[$year.$month.$day] .= '/fukuoka';
			}

			if ($row['place'] == 'sendai')	{
				// 仙台
				$sen_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$sen_title[] = $row['t_title1'];
				$sen_desc[]  = $row['t_desc1'];
				if ($row['t_stat'] == 1)	{
					$sen_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';
				}elseif ($row['t_stat'] == 2)	{
					$sen_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';
				}else{
					$sen_img[]	= '';
				}
				$cal[$year.$month.$day] .= '/sendai';
			}
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


	if (count($tyo_title) > 0)	{
		for ($idx=0; $idx<count($tyo_title); $idx++)	{
?>
			<li>
				<div class="thumbnail">
					<img src="images/yahoo_tokyo.jpg" width="80" height="80">
				</div>
				<div class="info">
					<span class="til1"><? print $tyo_img[$idx].$tyo_title[$idx]; ?></span>
					<span class="desc"><? print nl2br($tyo_desc[$idx]); ?></span>
				</div>
				<div class="clear"></div>
			</li>
<?
		}
	}

	if (count($osa_title) > 0)	{
		for ($idx=0; $idx<count($osa_title); $idx++)	{
?>
			<li>
				<div class="thumbnail">
					<img src="images/yahoo_osaka.jpg" width="80" height="80">
				</div>
				<div class="info">
					<span class="til1"><? print $osa_img[$idx].$osa_title[$idx]; ?></span>
					<span class="desc"><? print nl2br($osa_desc[$idx]); ?></span>
				</div>
				<div class="clear"></div>
			</li>
<?
		}
	}

	if (count($fuk_title) > 0)	{
		for ($idx=0; $idx<count($fuk_title); $idx++)	{
?>
			<li>
				<div class="thumbnail">
					<img src="images/yahoo_fukuoka.jpg" width="80" height="80">
				</div>
				<div class="info">
					<span class="til1"><? print $fuk_img[$idx].$fuk_title[$idx]; ?></span>
					<span class="desc"><? print nl2br($fuk_desc[$idx]); ?></span>
				</div>
				<div class="clear"></div>
			</li>
<?
		}
	}

	if (count($sen_title) > 0)	{
		for ($idx=0; $idx<count($sen_title); $idx++)	{
?>
			<li>
				<div class="thumbnail">
					<img src="images/yahoo_sendai.jpg" width="80" height="80">
				</div>
				<div class="info">
					<span class="til1"><? print $sen_img[$idx].$sen_title[$idx]; ?></span>
					<span class="desc"><? print nl2br($sen_desc[$idx]); ?></span>
				</div>
				<div class="clear"></div>
			</li>
<?
		}
	}

?>

		</ul>
	</div>
</div>


</body>
</html>
