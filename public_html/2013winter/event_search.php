<?

// ini_set( "display_errors", "On");

require_once('jp-holiday.php');

	session_start();

	mb_language("Ja");
	mb_internal_encoding("utf8");


	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];

	// 状態確認
	if ($mem_id <> '')	{
		try {
			$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');
			$stt->bindValue(':id', $mem_id);
			$stt->execute();
			$mem_namae = '';
			$mem_furigana = '';
			$mem_tel = '';
			$mem_email = '';
			$mem_country = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$mem_email = $row['email'];
				$mem_namae = $row['namae'];
				$mem_furigana = $row['furigana'];
				$mem_tel = $row['tel'];
				$mem_country = $row['country'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

function calender_list()	{

	global $cal;
	global $cal_msg;

	$year = date('Y');
	$month = date('n');
	$day  = date('d');
	$day = $day - date('w');

	$yobi = array ('日','月','火','水','木','金','土');

	for($i=$day;$i<=$day + 150;$i++){
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		if (@$cal[date('Y-n-j', $print_today)] <> '')	{
			print '<div style="width:660px; font-size:12pt; margin: 5px 0 10px 0;" id="'.date('Ymd', $print_today).'">';
		//	$dt = date_create($year."-".$month."-".$i);
		//	if (date_jp_holiday_isHoliday($dt) || date("w", $print_today) == 0 )	{
		//		print '<div style="border-left:4px solid red; border-top:1px solid red; color:red; font-weight:bold; padding:5px 0 5px 10px;">';
		//	}else{
				print '<div style="border-left:4px solid red; border-top:1px solid red; padding:5px 0 5px 10px;">';
		//	}
			print date('n月j日 ('.$yobi[date('w', $print_today)].')', $print_today);
		//	if (date_jp_holiday_isHoliday($dt))	{
		//		print '['.$dt->jp_hol_name.']';
		//	}
			print '</div>';

			print '<table style="margin-left:14px; table-layout:fixed;">'.$cal_msg[date('Y-n-j', $print_today)].'</table>';
			print '</div>';
		}
	}

}

function calender_show($year, $month)	{

	$day = "1";
	$num = date("t", mktime(0,0,0,$month,$day,$year));

	print '<table border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" style="font-size: 12pt; color: #666666;" id="'.$year.$month.'" class="'.$year.$month.'">';
	print '<tr>';
	print '<td align="center" colspan="7" bgcolor="#EEEEEE" height="18" style="color: #666666;">'.$year.'年'.$month.'月</td></tr>';
	print '<tr>';
	print '<td align="center" width="40" height="18" bgcolor="#FF3300" style="color: #FFFFFF;">日</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">月</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">火</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">水</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">木</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">金</td>';
	print '<td align="center" width="40" bgcolor="#A6C0E1" style="color: #666666;">土</td>';
	print '</tr>';

	//カレンダーの日付を作る
	for($i=$day;$i<=$num;$i++){

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		//曜日は数値
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		if($i==1){
			//一日目の曜日を提示するまでを繰り返し
			print "<tr>";
			for($j=1;$j<=$w;$j++){
				print "<td></td>";
			}
			$data = calender_output($i,$w,$year,$month,$day);
			print "$data";
			if($w==6){
				print "</tr>";
			}
		}
		//一日目以降の場合
		else{
			if($w==0){
				print "<tr>";
			}
			$data = calender_output($i,$w,$year,$month,$day);
			print "$data";
			if($w==6){
				print "</tr>";
			}
		}
	}
	if($w!=6){
		print "</tr>";
	}
	print "</table>";

}

function calender_output($i,$w,$year,$month,$day){

	global $cal;

	$change = "";
	$link = '<a href="./event.php?act=new&year='.$year.'&month='.$month.'&day='.$i.'#'.$year.$month.'">'.$i.'</a>';

	if (@$cal[$year.'-'.$month.'-'.$i])	{
//		$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'">'.@$cal[$year.$month.$i].$i.'</a><br/>';
		$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'"><img src="images/sa01.jpg">'.$i.'</a><br/>';
	}else{
		$link = $i;
	}

    //PUBLIC HOLIDAYS
    //----------------
	require_once './mailsystem/calender_off.php';
    
    $public_holidays = publicholidays($year,$month,$i);
    if($public_holidays)
        $change = "on";
    //----------------

	if ($change == "on")	{
		$change = '<td nowrap align="center" height="18" bgcolor="#FFCC99" style="color: #666666;">'.$link.'</td>';
	}

	// 曜日判定
	if ($change == "")	{
		if($w==0){
			// 日曜日
			$change = '<td nowrap align="center" height="18" bgcolor="#FFCC99" style="color: #666666;">'.$link.'</td>';
		}
		elseif($w==6){
			// 土曜日
			$change = '<td nowrap align="center" height="18" bgcolor="#FFFFFF" style="color: #666666;">'.$link.'</td>';
		}
		else{
			$change = '<td nowrap align="center" height="18" bgcolor="#FFFFFF" style="color: #666666;">'.$link.'</td>';
		}
	}
	return $change;
}

?>


<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
	});
});
</script>

<?

	// イベント読み込み
	$cal = array();

	$tyo_ymd   = array();
	$tyo_title = array();
	$tyo_desc  = array();
	$tyo_img   = array();
	$tyo_btn   = array();
	$tyo_id	   = array();

	$oka_ymd   = array();
	$oka_title = array();
	$oka_desc  = array();
	$oka_img   = array();
	$oka_btn   = array();
	$oka_id	   = array();

	$fuk_ymd   = array();
	$fuk_title = array();
	$fuk_desc  = array();
	$fuk_img   = array();
	$fuk_btn   = array();
	$fuk_id	   = array();

	$sen_ymd   = array();
	$sen_title = array();
	$sen_desc  = array();
	$sen_img   = array();
	$sen_btn   = array();
	$senid	   = array();

	try {
		$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
//		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat FROM event_list WHERE k_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');

		// パラメータ確認
		$where_place = ' ( 1=0';
		$where_country = ' ( 1=0';
		$where_know = ' ( 1=0';
		$nohit = true;

		foreach($_POST as $key => $val)	{
			if (mb_substr($key, 0, 5) == 'place')	{
				if ($val == 'all')	{
					$where_place = '';
				}else{
					$where_place .= ' or place = \''.$val.'\' ';
				}
				$nohit = false;
			}
			if (mb_substr($key, 0, 7) == 'country')	{
				if ($val == 'all')	{
					$where_country = '';
				}else{
					if ($val == 'other')	{
						$where_country .= ' or ( k_title1 not like  \'%オーストラリア%\' ';
						$where_country .= '  and k_title1 not like  \'%ニュージーランド%\' ';
						$where_country .= '  and k_title1 not like  \'%カナダ%\' ';
						$where_country .= '  and k_title1 not like  \'%イギリス%\' ';
			//			$where_country .= '  and k_title1 not like  \'%フランス%\' ';
						$where_country .= '  and k_title1 not like  \'%英語圏%\' ';
						$where_country .= '  and k_desc1 not like  \'%オーストラリア%\' ';
						$where_country .= '  and k_desc1 not like  \'%ニュージーランド%\' ';
						$where_country .= '  and k_desc1 not like  \'%カナダ%\' ';
						$where_country .= '  and k_desc1 not like  \'%イギリス%\' ';
			//			$where_country .= '  and k_desc1 not like  \'%フランス%\' ';
						$where_country .= '  and k_desc1 not like  \'%英語圏%\' ';
						$where_country .= '  and k_desc2 not like  \'%オーストラリア%\' ';
						$where_country .= '  and k_desc2 not like  \'%ニュージーランド%\' ';
						$where_country .= '  and k_desc2 not like  \'%カナダ%\' ';
						$where_country .= '  and k_desc2 not like  \'%イギリス%\' ';
			//			$where_country .= '  and k_desc2 not like  \'%フランス%\' ';
						$where_country .= '  and k_desc2 not like  \'%英語圏%\' ) ';
						$where_country .= '  or k_title1 like  \'%ヨーロッパ%\' ';
						$where_country .= '  or k_title2 like  \'%ヨーロッパ%\' ';
					}else{
						$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
						$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
						$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
					}
				}
			}
			if (mb_substr($key, 0, 4) == 'know')	{
				if ($val == 'all')	{
					$where_know = '';
				}else{
					$where_know .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_know .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
					if ($val == '現地生活ガイド')	{
						$where_know .= ' or k_title1 like \'%歩き方%\' ';
						$where_know .= ' or k_desc1 like \'%歩き方%\' ';
						$where_know .= ' or k_desc2 like \'%歩き方%\' ';
						$where_know .= ' or k_title1 like \'%安心生活%\' ';
						$where_know .= ' or k_desc1 like \'%安心生活%\' ';
						$where_know .= ' or k_desc2 like \'%安心生活%\' ';
					}
				}
			}
		}

		if ($nohit)	{
			$where_place = '';
			$where_country = '';
			$where_know = '';
		}

		$where_place .= ' ) ';
		$where_country .= ' ) ';
		$where_know .= ' ) ';

		$keyword  = '';
		if ($where_place <> ' ) ')	{
			$keyword .= ' and '.$where_place;
		}
		if ($where_country <> ' ) ')	{
			$keyword .= ' and '.$where_country;
		}
		if ($where_know <> ' ) ')	{
			$keyword .= ' and '.$where_know;
		}

		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE k_use = 1 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.' ORDER BY hiduke, starttime, id');
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

			if ($row['place'] == 'event')	{
				// イベント
				$tyo_id[] = $row['id'];
				$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title = '<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
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
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[イベントE]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[イベントE]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[イベントE]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[イベントE]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$tyo_title[]	= $title.$c_title;
				$tyo_desc[]	= $c_desc;
				$tyo_img[]	= $c_img;
				$tyo_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
				}

				$cal[$year.'-'.$month.'-'.$day] .= '<img src="images/sa05.jpg">';
				$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ <img src="images/sa05.jpg">イベント</td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
				$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
				$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
				$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
				$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;
			}

/*

			if ($row['place'] == 'fukuoka')	{
				// 福岡
				$fuk_id[] = $row['id'];
				$fuk_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
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
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[福岡E]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[福岡E]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[福岡E]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[福岡E]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$fuk_title[]	= $title.$c_title;
				$fuk_desc[]	= $c_desc;
				$fuk_img[]	= $c_img;
				$fuk_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
				}

				$cal[$year.'-'.$month.'-'.$day] .= '<img src="images/sa03.jpg">';
				$cal[$year.'-'.$month.'-'.$day] .= '<img src="images/sa05.jpg">';
				$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ <img src="images/sa03.jpg"><a target="_blank" href="/event/map/?p=fukuoka">福岡会場</a></td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
				$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
				$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
				$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
				$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;
			}
*/

			if ($row['place'] == 'sendai')	{
				// 仙台
				$sen_id[] = $row['id'];
				$sen_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
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
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[仙台E]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[仙台E]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[仙台E]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[仙台E]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$sen_title[]	= $title.$c_title;
				$sen_desc[]	= $c_desc;
				$sen_img[]	= $c_img;
				$sen_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
				}

				$cal[$year.'-'.$month.'-'.$day] .= '<img src="images/sa02.jpg">';
				$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ <img src="images/sa02.jpg">仙台会場</td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
				$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
				$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
				$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
				$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;
			}











			if ($row['place'] == 'toyama')	{
				// 富山
				$sen_id[] = $row['id'];
				$sen_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
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
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[富山E]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[富山E]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[富山E]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[富山E]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$sen_title[]	= $title.$c_title;
				$sen_desc[]	= $c_desc;
				$sen_img[]	= $c_img;
				$sen_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
				}

				$cal[$year.'-'.$month.'-'.$day] .= '<img src="images/sa02.jpg">';
				$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ <img src="images/sa02.jpg">富山会場</td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
				$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
				$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
				$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
				$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;
			}







/*

			if ($row['place'] == 'okinawa')	{
				// 沖縄
				$oka_id[] = $row['id'];
				$oka_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
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
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[沖縄E]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[沖縄E]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[沖縄E]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[沖縄E]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$oka_title[]	= $title.$c_title;
				$oka_desc[]	= $c_desc;
				$oka_img[]	= $c_img;
				$oka_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
				}

				$cal[$year.'-'.$month.'-'.$day] .= '<img src="images/sa02.jpg">';
				$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ <img src="images/sa02.jpg"><a target="_blank" href="/event/map/?p=okinawa">沖縄会場</a></td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
				$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
				$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
				$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
				$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;
			}

*/

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>

<?
	if ($cnt == 0)	{
		print '<div style="margin:40px 0 40px 0; padding: 10px 0 10px 50px; border:3px red dotted; color:red; font-size:14pt; font-weight:bold;">該当するセミナーがありません。検索条件を変更してください。</div>';
	}else{
		print '<div style="font-size:12pt; margin-left:40px;">'.$cnt.'件のセミナーがあります。</div>';
	}
?>

<center>
<table>
	<tr>
	<td style="vertical-align:top;">
<?
	$yy = date('Y');
	$mm = date('n');
	calender_show($yy,$mm);
?>
	</td>
	<td width="10px">&nbsp;</td>
	<td style="vertical-align:top;">
<?
	$mm++;
	if ($mm > 12)	{
		$mm = 1;
		$yy++;
	}
	calender_show($yy,$mm);

?>
	</td>
	</tr>
</table>
&nbsp;<br/>

<!--
<table style="font-size:12pt; width:560px;">
	<tr>
		<td width="160"><img src="images/arrow0313.gif"> 東京セミナー</td>
		<td width="160"><img src="images/arrow0303.gif"> 大阪セミナー</td>
		<td width="160"><img src="images/arrow0306.gif"> 仙台セミナー</td>
		<td width="160"><img src="images/arrow0306.gif"> 富山セミナー</td>
	</tr>
	<tr>
		<td><img src="images/arrow0307.gif"> 福岡セミナー</td>
		<td><img src="images/arrow0306.gif"> 沖縄セミナー</td>
		<td colspan="2"><a href="event.html"><img src="images/arrow0302.gif"> その他のイベント</a></td>
	</tr>
</table>
-->

<span style="font-size:11pt;">
	<a href="/seminar/seminar">東京・大阪・名古屋・福岡・沖縄での無料セミナーはこちらからどうぞ</a>
</span>

</center>

<div style="border: 2px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
無料セミナーのご予約は、各セミナー日程に表示された「予約」ボタンをご利用ください。<br/>
各セミナーへのご質問は toiawase@jawhm.or.jp　にメールをお願いいたします。<br/>
なお、当日のセミナーのご予約は、03-6304-5858までご連絡ください。<br/>
</div>


<div style="width:620; float:clear;">
<?
	calender_list();
?>
</div>


