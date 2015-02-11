<html>
<title>トラトラの無料セミナー情報</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?

	$para = @$_GET['p'];
	$show = @$_GET['show'];

?>

<style type="text/css">
<?
	if ($show == 'pc')	{
?>
body {
	background: white;
	margin: 15px auto 20px;
}
h1 {
	padding-left:15px;
	font-size:20pt;
	margin-left: 10%;
}
h3 {
	font-size:14pt;
	color: blue;
}
.event_semi	{
	background-color: orange;
	padding: 10px 10px 10px 10px;
	margin :  0px  3px 15px  10%;
	width  : 800px;
}
.normal	{
	width: 780px;
	font-size: 10pt;
	color: black;
	border-bottom: 1px dotted mediumblue;
}
.groupdiv	{
	padding-left:15px;
}
<?
	}else{

/*
body {
	background: white;
	margin: 15px auto 20px;
}
h1 {
	padding-left:5px;
	font-size:20pt;
}
h3 {
	font-size:14pt;
	color: blue;
}
.event_semi	{
	padding: 10px 10px 10px 3px;
	margin :  0px  3px 15px 3px;
	width  : 500px;
}
.normal	{
	margin: 10px 0 10px 10px;
	width: 500px;
	font-size: 10pt;
	color: black;
	border-bottom: 1px dotted mediumblue;
	background-color: orange;
}
.groupdiv	{
	padding-left:0px;
}
*/

?>
<?
	}
?>

</style>

<body>

<h1 id="top">夢をかなえるトラトラの無料セミナー情報<img src="http://www.jawhm.or.jp/event/getlist/tora1.jpg"></h1>

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

	$evt_ymd   = array();
	$evt_title = array();
	$evt_desc  = array();
	$evt_img   = array();

	$evt_ymd   = array();
	$evt_title = array();
	$evt_desc  = array();
	$evt_img   = array();

	try {
		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, t_use, t_title1, t_desc1, t_stat FROM event_list WHERE t_use = 1 AND hiduke > "'.date("Y/m/d",strtotime("-1 day")).'"  ORDER BY hiduke, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

/*
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
*/

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
				if ($row['t_stat'] != 2)	{
					if ($show == 'pc')	{
						$tyo_lnk[]	= '<br/>【ご予約は、お電話：03-5909-3778、メール：tokyo@tora-tora.net までどうぞ】<br/>';
					}else{
						$tyo_lnk[] 	= '<br/><a href="tel:0359093778">電話で予約</a><br/><a href="mailto:tokyo@tora-tora.net?subject='.$year.substr('00'.$month,-2).substr('00'.$day,-2).'東京セミナー予約&body=お名前、お電話番号、ご質問などご入力ください">メールで予約</a><br/><hr/>';
					}
				}else{
					$tyo_lnk[]	= '';
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
				if ($row['t_stat'] != 2)	{
					if ($show == 'pc')	{
						$osa_lnk[]	= '<br/>【ご予約は、お電話：06-6346-3774、メール：osaka@tora-tora.net までどうぞ】<br/>';
					}else{
						$osa_lnk[] 	= '<br/><a href="tel:0663463774">電話で予約</a><br/><a href="mailto:osaka@tora-tora.net?subject='.$year.substr('00'.$month,-2).substr('00'.$day,-2).'大阪セミナー予約&body=お名前、お電話番号、ご質問などをご入力ください">メールで予約</a><br/><hr/>';
					}
				}else{
					$osa_lnk[]	= '';
				}
				$cal[$year.$month.$day] .= '/osaka';
			}

/*
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
*/

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

/*
	if (count($evt_title) > 0 && ( $para == 'event' || $para == ''))	{

		print_sc ('<div id="event_semi" class="event_semi">');
		print_sc ('<h3>【イベント情報】</h3>');
		print_sc ('<div style="margin:0 0 8px 10px;">');
		print_sc ('<table><tr><td>');
		$yy = date('Y');
		$mm = date('n');
		calender_show($yy,$mm,'event');
		print_sc ('</td><td width="10px">&nbsp;</td><td>');
		$mm++;
		if ($mm > 12)	{
			$mm = 1;
			$yy++;
		}
		calender_show($yy,$mm,'event');
		print_sc ('</td></tr></table></div>');

		print_sc ('<div style="padding-left:15px;">');
		for ($idx=0; $idx<count($evt_title); $idx++)	{
			print_sc ('<div style="width:500px; font-size:10pt; color:black; border-bottom:1px dotted mediumblue;" id="event'.$evt_ymd[$idx].'">');
			if ($evt_ymd[$idx] < date('Ymd'))	{
				print_sc ($evt_img[$idx].'<s>'.$evt_title[$idx].'</s>');
				print_sc ('<br/><div style="margin-left:20px;"><s>'.nl2br($evt_desc[$idx]).'</s></div></div>');
			}else{
				print_sc ($evt_img[$idx].$evt_title[$idx]);
				print_sc ('<br/><div style="margin-left:20px;">'.nl2br($evt_desc[$idx]).'</div></div>');
			}
		}
		print_sc ('</div>');
		print_sc ('</div>');
	}
*/

	if (count($tyo_title) > 0 && ( $para == 'tokyo' || $para == ''))	{
		print_sc ('<div id="tokyo_semi" class="event_semi">');
		print_sc ('<h3>【東京会場】</h3>');
		print_sc ('<div style="margin:0 0 8px 10px;">');
		print_sc ('<table><tr><td>');
		$yy = date('Y');
		$mm = date('n');
		calender_show($yy,$mm,'tokyo');
		print_sc ('</td><td width="10px">&nbsp;</td><td>');
		$mm++;
		if ($mm > 12)	{
			$mm = 1;
			$yy++;
		}
		calender_show($yy,$mm,'tokyo');
		print_sc ('</td></tr></table></div><hr/>');

		print_sc ('<div class="groupdiv">');
		for ($idx=0; $idx<count($tyo_title); $idx++)	{
			print_sc ('<div class="normal" id="tokyo'.$tyo_ymd[$idx].'">');
			if ($tyo_ymd[$idx] < date('Ymd'))	{
				print_sc ($tyo_img[$idx].'<s>'.$tyo_title[$idx].'</s>');
				print_sc ('<br/><div style="margin-left:20px;"><s>'.nl2br($tyo_desc[$idx]).'</s></div></div>');
			}else{
				print_sc ($tyo_img[$idx].$tyo_title[$idx]);
				print_sc ('<br/><div style="margin-left:20px;">'.nl2br($tyo_desc[$idx]).$tyo_lnk[$idx].'</div></div>');
			}
		}
		print_sc ('</div>');
		print_sc ('</div>');
	}

	if (count($osa_title) > 0 && ( $para == 'osaka' || $para == ''))	{
		print_sc ('<div id="osaka_semi" class="event_semi">');
		print_sc ('<h3>【大阪会場】</h3>');
		print_sc ('<div style="margin:0 0 8px 10px;">');
		print_sc ('<table><tr><td>');
		$yy = date('Y');
		$mm = date('n');
		calender_show($yy,$mm,'osaka');
		print_sc ('</td><td width="10px">&nbsp;</td><td>');
		$mm++;
		if ($mm > 12)	{
			$mm = 1;
			$yy++;
		}
		calender_show($yy,$mm,'osaka');
		print_sc ('</td></tr></table></div><hr/>');

		print_sc ('<div class="groupdiv">');
		for ($idx=0; $idx<count($osa_title); $idx++)	{
			print_sc ('<div class="normal" id="osaka'.$osa_ymd[$idx].'">');
			if ($osa_ymd[$idx] < date('Ymd'))	{
				print_sc ($osa_img[$idx].'<s>'.$osa_title[$idx].'</s>');
				print_sc ('<br/><div style="margin-left:20px;"><s>'.nl2br($osa_desc[$idx]).'</s></div></div>');
			}else{
				print_sc ($osa_img[$idx].$osa_title[$idx]);
				print_sc ('<br/><div style="margin-left:20px;">'.nl2br($osa_desc[$idx]).$osa_lnk[$idx].'</div></div>');
			}
		}
		print_sc ('</div>');
		print_sc ('</div>');
	}

/*
	if (count($fuk_title) > 0 && ( $para == 'fukuoka' || $para == ''))	{
		print_sc ('<div id="fukuoka_semi" class="event_semi">');
		print_sc ('<h3>【福岡会場】</h3>');
		print_sc ('<div style="margin:0 0 8px 10px;">');
		print_sc ('<table><tr><td>');
		$yy = date('Y');
		$mm = date('n');
		calender_show($yy,$mm,'fukuoka');
		print_sc ('</td><td width="10px">&nbsp;</td><td>');
		$mm++;
		if ($mm > 12)	{
			$mm = 1;
			$yy++;
		}
		calender_show($yy,$mm,'fukuoka');
		print_sc ('</td></tr></table></div>');

		print_sc ('<div style="padding-left:15px;">');
		for ($idx=0; $idx<count($fuk_title); $idx++)	{
			print_sc ('<div style="width:500px; font-size:10pt; color:black; border-bottom:1px dotted mediumblue;" id="fukuoka'.$fuk_ymd[$idx].'">');
			if ($fuk_ymd[$idx] < date('Ymd'))	{
				print_sc ($fuk_img[$idx].'<s>'.$fuk_title[$idx].'</s>');
				print_sc ('<br/><div style="margin-left:20px;"><s>'.nl2br($fuk_desc[$idx]).'</s></div></div>');
			}else{
				print_sc ($fuk_img[$idx].$fuk_title[$idx]);
				print_sc ('<br/><div style="margin-left:20px;">'.nl2br($fuk_desc[$idx]).'</div></div>');
			}
		}
		print_sc ('</div>');
		print_sc ('</div>');
	}
*/

//print $out_script;

?>


</body>
</html>
