<html>
<title>イベントリスト</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
body {
	background: white;
	margin: 15px auto 20px;
}
h1 {
	padding-left:14px;
	font-size:20pt;
}
h3 {
	font-size:14pt;
	color: blue;
}
.scrolltoanchor	{
	font-weight: bold;
	text-align: center;
	width: 100px;
	height: 26px;
	padding: 5px 10px 5px 10px;
	background-color: darkblue;
	color: white;
	text-decoration: none;
}
.event_semi	{
	padding:  0px 10px 10px 10px;
	margin :  0px  3px 15px  3px;
	width  : 660px;
}
#nav-dock {
	margin-left: 10px;
}


</style>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.corner.js"></script>
<script type="text/javascript" src="jquery.scrollTo-min.js"></script>
<script type="text/javascript">
$(function() {


	$('#tokyo_semi').corner();
	$('#osaka_semi').corner();
	$('#fukuoka_semi').corner();
	$('#sendai_semi').corner();

	$('#tokyo_btn').corner();
	$('#osaka_btn').corner();
	$('#fukuoka_btn').corner();
	$('#sendai_btn').corner();

});
</script>


<body>

<?

//ini_set( "display_errors", "On");

//$out_script = "var view_rewrite = document.getElementById('showevents');";

function print_sc($data)	{
//	global $out_script;
//	$out_script .= "view_rewrite.innerHTML='".str_replace("'", "\'", $data)."';";
	print $data;
}


function calender_show($year, $month, $place)	{

	$day = "1";
	$num = date("t", mktime(0,0,0,$month,$day,$year));

	print_sc ('<table border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" style="font-size: 9pt; color: #666666;" id="'.$year.$month.'" class="'.$year.$month.'">');
	print_sc ('<tr>');
	print_sc ('<td align="center" colspan="7" bgcolor="#EEEEEE" height="18" style="color: #666666;">'.$year.'年'.$month.'月</td></tr>');
	print_sc ('<tr>');
	print_sc ('<td align="center" width="24" height="18" bgcolor="#33FFCC" style="color: darkbrown ;">日</td>');
	print_sc ('<td align="center" width="24" bgcolor="#33FFCC" style="color: black;">月</td>');
	print_sc ('<td align="center" width="24" bgcolor="#33FFCC" style="color: black;">火</td>');
	print_sc ('<td align="center" width="24" bgcolor="#33FFCC" style="color: black;">水</td>');
	print_sc ('<td align="center" width="24" bgcolor="#33FFCC" style="color: black;">木</td>');
	print_sc ('<td align="center" width="24" bgcolor="#33FFCC" style="color: black;">金</td>');
	print_sc ('<td align="center" width="24" bgcolor="#33FFCC" style="color: navy;">土</td>');
	print_sc ('</tr>');

	//カレンダーの日付を作る
	for($i=1;$i<=$num;$i++){

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		//曜日は数値
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		if($i==1){
			//一日目の曜日を提示するまでを繰り返し
			print_sc ("<tr>");
			for($j=1;$j<=$w;$j++){
				print_sc ("<td></td>");
			}
			$data = calender_output($i,$w,$year,$month,$day,$place);
			print_sc ($data);
			if($w==6){
				print_sc ("</tr>");
			}
		}
		//一日目以降の場合
		else{
			if($w==0){
				print_sc ("<tr>");
			}
			$data = calender_output($i,$w,$year,$month,$day,$place);
			print_sc ($data);
			if($w==6){
				print_sc ("</tr>");
			}
		}
	}
	if($w!=6){
		print_sc ("</tr>");
	}
	print_sc ("</table>");

}

function calender_output($i,$w,$year,$month,$day,$place){

	global $cal;

	$change = "";
	$link = '<a href="./event.php?act=new&year='.$year.'&month='.$month.'&day='.$i.'#'.$year.$month.'">'.$i.'</a>';

	if (strpos(@$cal[$year.$month.$i],$place) > 0)	{
		$link = '<a href="#'.$place.$year.substr('00'.$month,-2).substr('00'.$i,-2).'"><b>'.$i.'</b></a><br/>';
	}else{
		$link = $i;
	}

    //PUBLIC HOLIDAYS
    //----------------
	require_once '../../mailsystem/calender_off.php';
    
    $public_holidays = publicholidays($year,$month,$i);
    if($public_holidays)
        $change = "on";
    //----------------

	if ($change == "on")	{
		$change = '<td align="center" height="18" bgcolor="#FFCC99" style="color: #666666;">'.$link.'</td>';
	}

	// 曜日判定
	if ($change == "")	{
		if($w==0){
			// 日曜日
			$change = '<td align="center" height="18" bgcolor="#FFCC99" style="color: #666666;">'.$link.'</td>';
		}
		elseif($w==6){
			// 土曜日
			$change = '<td align="center" height="18" bgcolor="#FFFFFF" style="color: #666666;">'.$link.'</td>';
		}
		else{
			$change = '<td align="center" height="18" bgcolor="#FFFFFF" style="color: #666666;">'.$link.'</td>';
		}
	}
	return $change;
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
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, t_use, t_title1, t_title2, t_desc1, t_stat FROM event_list WHERE t_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-300 day")).'"  ORDER BY t_title2, hiduke, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			if ($row['place'] == 'tokyo')	{
				// 東京
				$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$tyo_title[] = $row['t_title1'];
				if ($row['t_title2'] == '')	{
					$tyo_title2[] = 'タイトルなし';
				}else{
					$tyo_title2[] = $row['t_title2'];
				}
				$tyo_desc[]  = $row['t_desc1'];
				if ($row['t_stat'] == 1)	{
					$tyo_img[]   	= '【残わずか】';
				}elseif ($row['t_stat'] == 2)	{
					$tyo_img[]   	= '【満席】';
				}else{
					$tyo_img[]	= '';
				}
				$cal[$year.$month.$day] .= '/tokyo';
			}
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


	if (count($tyo_title) > 0)	{
		print_sc ('<table style="margin-top:-20px;"><tr><td>');
		print_sc ('<div id="tokyo_semi" class="event_semi">');
		print_sc ('<center><h1 id="top"><img src="./toralogo.jpg" width="63" height="41">トラトラジャパン　無料セミナー情報<img src="./tora1.jpg"></h1></center>');
		print_sc ('<div style="padding-left:15px;"><div>');
		$save = '';
		for ($idx=0; $idx<count($tyo_title); $idx++)	{
			if ($save != $tyo_title2[$idx])	{
				print_sc ('</div>');
				print_sc ('<div style="width:500px; font-size:9pt; color:black; border-bottom:1px dotted mediumblue;" id="tokyo'.$tyo_ymd[$idx].'">');
				print_sc ($tyo_title2[$idx].'<br/>');
			}
			print_sc ('<div style="margin-left:20px;">'.$tyo_img[$idx].nl2br($tyo_title[$idx]).'</div>');
			$save = $tyo_title2[$idx];
		}
		print_sc ('</div>');
		print_sc ('</div>');

		print_sc ('</td><td width="80px">&nbsp;</td><td>');






		print_sc ('<div id="tokyo_semi" class="event_semi">');
		print_sc ('<center><h1 id="top">夢をかなえるトラトラの無料セミナー情報<img src="./tora1.jpg"></h1></center>');
		print_sc ('<div style="padding-left:15px;"><div>');
		$save = '';
		for ($idx=0; $idx<count($tyo_title); $idx++)	{
			if ($save != $tyo_title2[$idx])	{
				print_sc ('</div>');
				print_sc ('<div style="width:500px; font-size:10pt; color:black; border-bottom:1px dotted mediumblue;" id="tokyo'.$tyo_ymd[$idx].'">');
				print_sc ($tyo_title2[$idx].'<br/>');
			}
			print_sc ('<div style="margin-left:20px;">'.$tyo_img[$idx].nl2br($tyo_title[$idx]).'</div>');
			$save = $tyo_title2[$idx];
		}
		print_sc ('</div>');
		print_sc ('</div>');

		print_sc ('</td></tr></table>');
	}


//print $out_script;

?>



</body>
</html>
