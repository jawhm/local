<html>

<head>

<title>無料セミナー | 日本ワーキング・ホリデー協会</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<META HTTP-EQUIV="Cache-control" CONTENT="no-store">

<META HTTP-EQUIV="Cache-control" CONTENT="no-cache">

<META HTTP-EQUIV="Expires" CONTENT="Mon, 1 Jan 1990 01:01:01 GMT">

<meta name="viewport" content="width=device-width" />

</head>



<?

	$para = @$_GET['p'];

	$show = @$_GET['show'];

?>



<body bgcolor="#FFFFFF" text="#333333"link="#0000CD" vlink="#5C82FF" alink="#FFFFFF">



<p align="center"><img src="http://i.jawhm.or.jp/img/top.jpg" width="240" height="77"></p>

<a name="top"></a>



<a href="#tokyosemi">東京会場のセミナー>></a><br/>

<a href="#osakasemi">大阪会場のセミナー>></a><br/>

&nbsp;<br/>



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



	$tyo_id	   = array();

	$tyo_ymd   = array();

	$tyo_title = array();

	$tyo_desc  = array();

	$tyo_img   = array();



	$osa_id	   = array();

	$osa_ymd   = array();

	$osa_title = array();

	$osa_desc  = array();

	$osa_img   = array();



	try {

		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$db->query('SET CHARACTER SET utf8');

		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, pax, booking FROM event_list WHERE k_use = 0 and free = 0 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');

		$cnt = 0;

		while($row = $rs->fetch(PDO::FETCH_ASSOC)){

			$cnt++;

			$year	= $row['yy'];

			$month  = $row['mm'];

			$day	= $row['dd'];

			$seminarid = $row['id'];



			if ($row['place'] == 'tokyo')	{

				// 東京

				$tyo_id[] = $row['id'];

				$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);

				$tyo_title[] = $row['k_title1'];

				$tyo_desc[]  = $row['k_desc1'];

				if ($row['k_stat'] == 1)	{

					if ($row['booking'] >= $row['pax'])	{

						$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';

					}else{

						$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';

					}

				}elseif ($row['k_stat'] == 2)	{

					$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';

				}else{

					if ($row['booking'] >= $row['pax'])	{

						$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';

					}else{

						if ($row['booking'] >= $row['pax'] / 2)	{

							$tyo_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';

						}else{

							$tyo_img[]	= '';

						}

					}

				}

				if ($row['k_stat'] == 2)	{

					$tyo_lnk[]	= '';

				}else{

					if ($row['booking'] >= $row['pax'])	{

						$tyo_lnk[] 	= '<br/><a href="mailto:yoyaku@jawhm.or.jp?subject='.$seminarid.'&body=このまま空メールを送信してください。タイトルは変更しないでください。">メールでキャンセル待ち</a><br/>';

					}else{

						$tyo_lnk[] 	= '<br/><a href="mailto:yoyaku@jawhm.or.jp?subject='.$seminarid.'&body=このまま空メールを送信してください。タイトルは変更しないでください。">メールで予約</a><br/>';

					}

				}

				$cal[$year.$month.$day] .= '/tokyo';

			}



			if ($row['place'] == 'osaka')	{

				// 大阪

				$osa_id[] = $row['id'];

				$osa_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);

				$osa_title[] = $row['k_title1'];

				$osa_desc[]  = $row['k_desc1'];

				if ($row['k_stat'] == 1)	{

					if ($row['booking'] >= $row['pax'])	{

						$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';

					}else{

						$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';

					}

				}elseif ($row['k_stat'] == 2)	{

					$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';

				}else{

					if ($row['booking'] >= $row['pax'])	{

						$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon408.gif">【満席です】<br/>';

					}else{

						if ($row['booking'] >= $row['pax'] / 2)	{

							$osa_img[]   	= '<img src="http://www.jawhm.or.jp/event/getlist/img/aicon407.gif">【残席わずかです】<br/>';

						}else{

							$osa_img[]	= '';

						}

					}

				}

				if ($row['k_stat'] == 2)	{

					$osa_lnk[]	= '';

				}else{

					if ($row['booking'] >= $row['pax'])	{

						$osa_lnk[] 	= '<br/><a href="mailto:yoyaku@jawhm.or.jp?subject='.$seminarid.'&body=このまま空メールを送信してください。タイトルは変更しないでください。">メールでキャンセル待ち</a><br/>';

					}else{

						$osa_lnk[] 	= '<br/><a href="mailto:yoyaku@jawhm.or.jp?subject='.$seminarid.'&body=このまま空メールを送信してください。タイトルは変更しないでください。">メールで予約</a><br/>';

					}

				}

				$cal[$year.$month.$day] .= '/osaka';

			}



		}

	} catch (PDOException $e) {

		die($e->getMessage());

	}



	if (count($tyo_title) > 0 && ( $para == 'tokyo' || $para == ''))	{

		print_sc ('<a name="tokyosemi"></a><div id="tokyo_semi" class="event_semi">');

		print_sc ('<h3>【東京会場】</h3>');

/*

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

*/



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

			print_sc ('<a href="#tokyosemi">東京セミナーの先頭へ戻る>></a><hr/>');

		}

		print_sc ('</div>');

		print_sc ('</div>');

	}



	if (count($osa_title) > 0 && ( $para == 'osaka' || $para == ''))	{

		print_sc ('<a name="osakasemi"></a><div id="osaka_semi" class="event_semi">');

		print_sc ('<h3>【大阪会場】</h3>');

/*

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

*/



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

			print_sc ('<a href="#osakasemi">大阪セミナーの先頭へ戻る>></a><hr/>');

		}

		print_sc ('</div>');

		print_sc ('</div>');

	}



?>



&nbsp;<br/>

<a href="#tokyosemi">東京会場のセミナー>></a><br/>

<a href="#osakasemi">大阪会場のセミナー>></a><br/>

&nbsp;<br/>



<p align="left">

<hr color="#D5D5D5">

<font size="2">◆ <a href="http://i.jawhm.or.jp/index.html">トップページに戻る</a></font>

</p>

<p align="center"><img src="http://i.jawhm.or.jp/img/footer.jpg" width="240" height="25" align="middle"></p>



</body>

</html>

