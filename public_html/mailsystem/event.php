<?
	include_once 'fnc_header.php';

//	ini_set( "display_errors", "On");

?>

<script language="JavaScript" type="text/JavaScript">
function copytext(arg){
    var obj=document.all && document.all(arg) || document.getElementById && document.getElementById(arg);
    if (obj.value) {
        var doc = document.body.createTextRange();
        doc.moveToElementText(obj);
        doc.execCommand("copy");
        alert('クリップボードにコピーしました。');
    } else {
        alert('コピーするデータがありません。');
    }
}

function fnc_check_new(obj)	{
	// 新規登録チェック
	if (obj.elements['title'].value == '')	{
		alert('イベント名を入力してください。');
		obj.elements['title'].focus();
		return false;
	}
	return true;
}
function fnc_show_div(div_name)	{
	// ブロック表示・非表示
	obj = document.getElementById(div_name)
	if (obj.style.display == 'none')	{
		obj.style.display = '';
	}else{
		obj.style.display = 'none';
	}
}
function fnc_check_del(id, ym)	{
	// 削除確認
	if (confirm('削除してよろしいですか？'))	{
		url = './event.php?act=del&id=' + id + '#' + ym;
		location.replace(url);
	}
	return true;
}
function fnc_icon()	{
	window.open('./icon.php', 'win_icon', 'width=500, height=600, menubar=no, toolbar=no, scrollbars=yes');
}
</script>


<?

	$act	= @$_GET['act'];
	if ($act == '')	{
		$act = @$_POST['act'];
	}
	$year	= @$_GET['year'];
	$month	= @$_GET['month'];
	$day	= @$_GET['day'];

	for ($idx=1; $idx<=12; $idx++)	{
		$evt[$idx] = '';
	}

	$print_today = mktime(0, 0, 0, $month, $day, $year);
	$w = date("w", $print_today);
	$wee = array('日','月','火','水','木','金','土');
	$w = $wee[$w];

	if ($act == 'new')	{
		// 新規登録（画面）
		$evt[$month] .= "
<form action=\"./event.php#".$year.$month."\" method=\"post\" onsubmit=\"return(fnc_check_new(this));\">
<table style=\"background-color:navy; color:white; font-weight:bold;\">
	<tr>
		<td>【新規登録】</td><td> $year 年 $month 月 $day 日  ( $w )</td>
	</tr>
	<tr>
		<td>イベント名</td>
		<td>
			<input type=\"text\" size=\"80\" name=\"title\" id=\"title\" value=\"\">
		</td>
	</tr>
	<tr>
		<td>開催地</td>
		<td>
			<input type=radio name=\"place\" value=\"tokyo\" checked>東京
			<input type=radio name=\"place\" value=\"osaka\">大阪
			<input type=radio name=\"place\" value=\"nagoya\">名古屋
			<input type=radio name=\"place\" value=\"fukuoka\">福岡
			<input type=radio name=\"place\" value=\"sendai\">仙台
			<input type=radio name=\"place\" value=\"okinawa\">沖縄
			<input type=radio name=\"place\" value=\"event\">その他イベント
		</td>
	</tr>
	<tr>
		<td>メモ</td>
		<td>
			<textarea name=\"memo\" cols=\"80\" rows=\"3\"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan=2 style=\"text-align:right;\">
			<input type=\"reset\">　<input type=\"submit\" value=\"　登録　\">
		</td>
	</tr>
</table>
<input type=\"hidden\" name=\"act\" value=\"new1\">
<input type=\"hidden\" name=\"year\" value=\"".$year."\">
<input type=\"hidden\" name=\"month\" value=\"".$month."\">
<input type=\"hidden\" name=\"day\" value=\"".$day."\">
</form>
";
	}

	if ($act == 'new1')	{
		// 新規登録（登録処理）
		$title	= @$_POST['title'];
		$place	= @$_POST['place'];
		$memo	= @$_POST['memo'];
		$year	= @$_POST['year'];
		$month	= @$_POST['month'];
		$day	= @$_POST['day'];

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql  = 'INSERT INTO event_list( hiduke,  title,  memo,  place,  k_title1,  k_title2,  k_desc1,  k_desc2,  t_title1,  t_title2,  t_desc1,  t_desc2)';
			$sql .=                 'VALUES(:hiduke, :title, :memo, :place, :k_title1, :k_title2, :k_desc1, :k_desc2, :t_title1, :t_title2, :t_desc1, :t_desc2)';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':hiduke', $year."/".$month."/".$day);
			$stt2->bindValue(':title', $title);
			$stt2->bindValue(':memo', $memo);
			$stt2->bindValue(':place', $place);
			$stt2->bindValue(':k_title1', $title);
			$stt2->bindValue(':k_title2', '');
			$stt2->bindValue(':k_desc1', $memo);
			$stt2->bindValue(':k_desc2', '');
			$stt2->bindValue(':t_title1', $title);
			$stt2->bindValue(':t_title2', $title);
			$stt2->bindValue(':t_desc1', $memo);
			$stt2->bindValue(':t_desc2', '');
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	if ($act == 'upd')	{
		// 更新処理
		$id	= @$_POST['id'];

		$title	= @$_POST['title'];
		$place	= @$_POST['place'];
		$memo	= @$_POST['memo'];
		$year	= @$_POST['year'];
		$month	= @$_POST['month'];
		$day	= @$_POST['day'];

		$t_use		= @$_POST['t_use'];
		if ($t_use == 'on')	{
			$t_use = '1';
		}else{
			$t_use = '0';
		}
		$t_title1	= @$_POST['t_title1'];
		$t_title2	= @$_POST['t_title2'];
		$t_desc1	= @$_POST['t_desc1'];
		$t_stat		= @$_POST['t_stat'];

		$k_use		= @$_POST['k_use'];
		if ($k_use == 'on')	{
			$k_use = '1';
		}else{
			$k_use = '0';
		}
		$k_title1	= @$_POST['k_title1'];
		$k_desc1	= @$_POST['k_desc1'];
		$k_stat		= @$_POST['k_stat'];

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql  = 'UPDATE event_list SET ';
			$sql .= ' title = :title ';
			$sql .= ',memo = :memo ';
			$sql .= ',place = :place ';
			$sql .= ',k_use = :k_use ';
			$sql .= ',k_title1 = :k_title1 ';
			$sql .= ',k_desc1 = :k_desc1 ';
			$sql .= ',k_stat = :k_stat ';
			$sql .= ',t_use = :t_use ';
			$sql .= ',t_title1 = :t_title1 ';
			$sql .= ',t_title2 = :t_title2 ';
			$sql .= ',t_desc1 = :t_desc1 ';
			$sql .= ',t_stat = :t_stat ';
			$sql .= ' WHERE id = :id ';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':id', $id);
			$stt2->bindValue(':title', $title);
			$stt2->bindValue(':memo', $memo);
			$stt2->bindValue(':place', $place);
			$stt2->bindValue(':k_use', $k_use);
			$stt2->bindValue(':k_title1', $k_title1);
			$stt2->bindValue(':k_desc1', $k_desc1);
			$stt2->bindValue(':k_stat', $k_stat);
			$stt2->bindValue(':t_use', $t_use);
			$stt2->bindValue(':t_title1', $t_title1);
			$stt2->bindValue(':t_title2', $t_title2);
			$stt2->bindValue(':t_desc1', $t_desc1);
			$stt2->bindValue(':t_stat', $t_stat);
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	if ($act == 'del')	{
		// 削除処理
		$id	= @$_GET['id'];

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql  = 'DELETE FROM event_list WHERE id = :id ';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':id', $id);
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	// 読み込み
	$cal = array();

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, t_use, t_title1, t_title2, t_desc1, t_stat FROM event_list where hiduke >= "2012-12-01" ORDER BY hiduke, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$chk['tokyo']	= '';
			$chk['osaka']	= '';
			$chk['nagoya']	= '';
			$chk['fukuoka']	= '';
			$chk['sendai']	= '';
			$chk['okinawa']	= '';
			$chk['event']	= '';
			$chk[$row['place']] = 'checked';

			if ($row['place'] == 'tokyo')	{ $place_show = '東京';	}
			if ($row['place'] == 'osaka')	{ $place_show = '大阪';	}
			if ($row['place'] == 'nagoya')	{ $place_show = '名古屋';	}
			if ($row['place'] == 'fukuoka')	{ $place_show = '福岡';	}
			if ($row['place'] == 'sendai')	{ $place_show = '仙台';	}
			if ($row['place'] == 'okinawa')	{ $place_show = '沖縄';	}
			if ($row['place'] == 'event')	{ $place_show = 'イベント';	}

			$k_chk['0'] = '';
			$k_chk['1'] = '';
			$k_chk['2'] = '';
			$k_chk[$row['k_stat']] = 'checked';
			$t_chk['0'] = '';
			$t_chk['1'] = '';
			$t_chk['2'] = '';
			$t_chk[$row['t_stat']] = 'checked';

			if ($row['k_use'] == '1')	{
				$k_use = 'checked';
				$cal['K'.$year.$month.$day] .= mb_substr($row['place'],0,1);
			}else{
				$k_use = '';
			}
			if ($row['t_use'] == '1')	{
				$t_use = 'checked';
				$cal['T'.$year.$month.$day] .= mb_substr($row['place'],0,1);
			}else{
				$t_use = '';
			}

			$print_today = mktime(0, 0, 0, $month, $day, $year);
			$w = date("w", $print_today);
			$wee = array('日','月','火','水','木','金','土');
			$w = $wee[$w];


			$evt[$month] .= "
<form action=\"./event.php#id".$row['id']."\" method=\"post\" onsubmit=\"return(fnc_check_new(this));\" id=\"id".$row['id']."\">
<table style=\"background-color:aquamarine; color:navy; font-weight:bold; display:none;\" place=\"".$row['place']."\">
	<tr>
		<td style=\"border:2px solid green; text-align:center;\">".$place_show."</td>
		<td style=\"border:2px solid green; padding-left:5px;\">".$year."年 ".$month."月 ".$day."日 (".$w.")</td>
	</tr>
	<tr>
		<td>イベント名</td>
		<td>
			<input type=\"text\" size=\"80\" name=\"title\" id=\"title\" value=\"".$row['title']."\">
		</td>
	</tr>
	<tr>
		<td>開催地</td>
		<td>
			<input type=radio name=\"place\" value=\"tokyo\" ".$chk['tokyo'].">東京
			<input type=radio name=\"place\" value=\"osaka\" ".$chk['osaka'].">大阪
			<input type=radio name=\"place\" value=\"nagoya\" ".$chk['nagoya'].">名古屋
			<input type=radio name=\"place\" value=\"fukuoka\" ".$chk['fukuoka'].">福岡
			<input type=radio name=\"place\" value=\"sendai\" ".$chk['sendai'].">仙台
			<input type=radio name=\"place\" value=\"okinawa\" ".$chk['okinawa'].">沖縄
			<input type=radio name=\"place\" value=\"event\" ".$chk['event'].">その他イベント
		</td>
	</tr>
	<tr>
		<td>メモ<br/><input type=button value=\"アイコン\" onclick=\"fnc_icon();\"></td>
		<td>
			<textarea name=\"memo\" cols=\"80\" rows=\"3\">".$row['memo']."</textarea>
		</td>
	</tr>
	<tr>
		<td rowspan=\"2\">掲載内容</td>
		<td>
			<table style=\"background-color:orange;\"><tr><td style=\"width:170px;\">
				<input type=\"checkbox\" name=\"t_use\" ".$t_use.">トラトラ掲載
			</td><td style=\"width:220px;\">
				<input type=\"radio\" name=\"t_stat\" value=\"0\" ".$t_chk['0'].">通常
				<input type=\"radio\" name=\"t_stat\" value=\"1\" ".$t_chk['1'].">少なめ
				<input type=\"radio\" name=\"t_stat\" value=\"2\" ".$t_chk['2'].">満席
			</td><td>
				<input type=\"button\" value=\"詳細\" onclick=\"fnc_show_div('div_t_".$cnt."');\">
			</td></tr>
			<tr>
				<td colspan=\"3\">
					<div id=\"div_t_".$cnt."\" style=\"display:none; border:1px solid;navy;\">
						<table>
							<tr>
								<td>イベント名</td>
								<td nowrap>
									<textarea cols=100 rows=2 name=\"t_title1\">".$row['t_title1']."</textarea>
								</td>
							</tr>
							<tr>
								<td nowrap>掲載表記</td>
								<td>
									<textarea cols=100 rows=5 name=\"t_desc1\">".$row['t_desc1']."</textarea>
								</td>
							</tr>
							<tr>
								<td>まとめ名</td>
								<td nowrap>
									<textarea cols=100 rows=1 name=\"t_title2\">".$row['t_title2']."</textarea>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table style=\"background-color:darkblue; color:white;\"><tr><td style=\"width:170px;\">
				<input type=\"checkbox\" name=\"k_use\" ".$k_use.">協会掲載
			</td><td style=\"width:220px;\">
				<input type=\"radio\" name=\"k_stat\" value=\"0\" ".$k_chk['0'].">通常
				<input type=\"radio\" name=\"k_stat\" value=\"1\" ".$k_chk['1'].">少なめ
				<input type=\"radio\" name=\"k_stat\" value=\"2\" ".$k_chk['2'].">満席
			</td><td>
				<input type=\"button\" value=\"詳細\" onclick=\"fnc_show_div('div_k_".$cnt."');\">
			</td></tr>
			<tr>
				<td colspan=\"3\">
					<div id=\"div_k_".$cnt."\" style=\"display:none; border:1px solid white;\">
						<table style=\"color:white;\">
							<tr>
								<td nowrap>イベント名</td>
								<td>
									<textarea cols=100 rows=2 name=\"k_title1\">".$row['k_title1']."</textarea>
								</td>
							</tr>
							<tr>
								<td nowrap>掲載表記</td>
								<td>
									<textarea cols=100 rows=5 name=\"k_desc1\">".$row['k_desc1']."</textarea>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<input type=\"button\" value=\"削除\" onclick=\"fnc_check_del('".$row['id']."','".$year.$month."');\">
		</td>
		<td style=\"text-align:right;\">
			<input type=\"reset\">　<input type=\"submit\" value=\"　更新　\">
		</td>
	</tr>
</table>
<input type=\"hidden\" name=\"act\" value=\"upd\">
<input type=\"hidden\" name=\"year\" value=\"".$year."\">
<input type=\"hidden\" name=\"month\" value=\"".$month."\">
<input type=\"hidden\" name=\"day\" value=\"".$day."\">
<input type=\"hidden\" name=\"id\" value=\"".$row['id']."\">
</form>
";
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>


<h1 class="top">イベント登録</h1>

表示確認：　<a href="http://ameblo.jp/toratora-jp/" target="_blank">トラトラ（アメブロ）</a>　　<a href="http://yahoo.tora-tora.net" target="_blank">トラトラ（資料請求）</a>　　　<a href="http://www.jawhm.or.jp/event.html" target="_blank">協会（イベント）</a><br/>


<div style="margin-bottom:4px;">
カレンダー：
	<input type="checkbox" onclick="fnc_show(this);" id="chk1" idx="1"><a href="#20131" onclick="$obj=document.getElementById('chk1');$obj.checked=true;fnc_show($obj);">１月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk2" idx="2"><a href="#20132" onclick="$obj=document.getElementById('chk2');$obj.checked=true;fnc_show($obj);">２月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk3" idx="3"><a href="#20133" onclick="$obj=document.getElementById('chk3');$obj.checked=true;fnc_show($obj);">３月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk4" idx="4"><a href="#20134" onclick="$obj=document.getElementById('chk4');$obj.checked=true;fnc_show($obj);">４月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk5" idx="5"><a href="#20135" onclick="$obj=document.getElementById('chk5');$obj.checked=true;fnc_show($obj);">５月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk6" idx="6"><a href="#20136" onclick="$obj=document.getElementById('chk6');$obj.checked=true;fnc_show($obj);">６月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk7" idx="7"><a href="#20137" onclick="$obj=document.getElementById('chk7');$obj.checked=true;fnc_show($obj);">７月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk8" idx="8"><a href="#20138" onclick="$obj=document.getElementById('chk8');$obj.checked=true;fnc_show($obj);">８月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk9" idx="9"><a href="#20139" onclick="$obj=document.getElementById('chk9');$obj.checked=true;fnc_show($obj);">９月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk10" idx="10"><a href="#201310" onclick="$obj=document.getElementById('chk10');$obj.checked=true;fnc_show($obj);">１０月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk11" idx="11"><a href="#201311" onclick="$obj=document.getElementById('chk11');$obj.checked=true;fnc_show($obj);">１１月</a>　
	<input type="checkbox" onclick="fnc_show(this);" id="chk12" idx="12"><a href="#201212" onclick="$obj=document.getElementById('chk12');$obj.checked=true;fnc_show($obj);">１２月</a>
</div>
<div style="margin-bottom:4px;">
開催地：
	<input type="checkbox" onclick="fnc_place(this);" id="place_tokyo" idx="tokyo">東京　
	<input type="checkbox" onclick="fnc_place(this);" id="place_osaka" idx="osaka">大阪　
	<input type="checkbox" onclick="fnc_place(this);" id="place_nagoya" idx="nagoya">名古屋　
	<input type="checkbox" onclick="fnc_place(this);" id="place_fukuoka" idx="fukuoka">福岡　
	<input type="checkbox" onclick="fnc_place(this);" id="place_sendai" idx="sendai">仙台　
	<input type="checkbox" onclick="fnc_place(this);" id="place_okinawa" idx="okinawa">沖縄　
	<input type="checkbox" onclick="fnc_place(this);" id="place_event" idx="event">イベント
</div>

<table>
	<? for ($idx=12; $idx<=12; $idx++)	{	?>
	<tr id="cal_<? print $idx; ?>" style="display:none;">
		<td style="vertical-align:top;"><? calender_show(2012,$idx); ?><a href="#top">ＴＯＰへ</a></td>
		<td style="vertical-align:top;border:1px solid pink;"><? print $evt[$idx]; ?></td>
	</tr>
	<? } ?>
	<? for ($idx=1; $idx<=11; $idx++)	{	?>
	<tr id="cal_<? print $idx; ?>" style="display:none;">
		<td style="vertical-align:top;"><? calender_show(2013,$idx); ?><a href="#top">ＴＯＰへ</a></td>
		<td style="vertical-align:top;border:1px solid pink;"><? print $evt[$idx]; ?></td>
	</tr>
	<? } ?>
</table>

<hr>

<div style="height:20px;">&nbsp;</div>

<?

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
	for($i=1;$i<=$num;$i++){

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

	$link .= '<br/>';
	if (@$cal['T'.$year.$month.$i])	{
		$link .= 'T:'.@$cal['T'.$year.$month.$i].'<br/>';
	}
	if (@$cal['K'.$year.$month.$i])	{
		$link .= 'K:'.@$cal['K'.$year.$month.$i].'<br/>';
	}

    //PUBLIC HOLIDAYS
    //----------------
	require_once 'calender_off.php';
    
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


include_once 'fnc_footer.php';

?>


<script>
function fnc_show($obj)	{
	$idx = $obj.getAttribute('idx');
	if ($obj.checked)	{
		document.getElementById('cal_' + $idx).style.display = '';
		WriteCookie ('CAL' + $idx, 'true', 365);
	}else{
		document.getElementById('cal_' + $idx).style.display = 'none';
		WriteCookie ('CAL' + $idx, 'false', 365);
	}
}
function fnc_place($obj)	{
	$idx = $obj.getAttribute('idx');
	if ($obj.checked)	{
		WriteCookie ($idx, 'true', 365);
		fnc_place_show($idx, '');
	}else{
		WriteCookie ($idx, 'false', 365);
		fnc_place_show($idx, 'none');
	}
}
function fnc_place_show($label, $disp)	{
	$obj = document.getElementsByTagName('table');
	for ($idx = 0; $idx<$obj.length; $idx++)	{
		if ($obj[$idx].getAttribute('place') == $label)	{
			$obj[$idx].style.display = $disp;
		}
	}
}
/* Cookie への書き出し
     引数 key　 : データキー （半角英数 _ のみ）
     引数 value : データの値（日本語可）
     引数 days  : データを保持する日数（ 0 の時は有効期限は省略）*/
function WriteCookie(key, value, days) {
     var str = key + "=" + escape(value) + ";";         // 書き出す値１ : key=value
     if (days != 0) {                                                 /* 日数 0 の時は省略 */
          var dt = new Date();                                   // 現在の日時
          dt.setDate(dt.getDate() + days);                   // days日後の日時
          str += "expires=" + dt.toGMTString() + ";"; // 書き出す値２ : 有効期限
     }
     document.cookie = str;                                   // Cookie に書き出し
}
/* Cookie の読み込み
     引数 key : 求める値のキー
     戻り値　 : 値（ない時は空文字""）*/
function ReadCookie(key) {
     var sCookie = document.cookie;    // Cookie文字列
     var aData = sCookie.split(";");       // ";"で区切って"キー=値"の配列にする
     var oExp = new RegExp(" ", "g");   // すべての半角スペースを表す正規表現
     key = key.replace(oExp, "");          // 引数keyから半角スペースを除去

     var i = 0;
     while (aData[i]) {                           /* 語句ごとの処理 : マッチする要素を探す */
          var aWord = aData[i].split("=");                         // さらに"="で区切る
          aWord[0] = aWord[0].replace(oExp, "");              // 半角スペース除去
          if (key == aWord[0]) return unescape(aWord[1]); // マッチしたら値を返す
          if (++i >= aData.length) break;                          // 要素数を超えたら抜ける
     }
     return "";                                   // 見つからない時は空文字を返す
}


// 初期表示
for ($idx=1; $idx<=12; $idx++)	{
	if (ReadCookie('CAL' + $idx) == 'true')	{
		document.getElementById('chk' + $idx).checked = true;
		fnc_show(document.getElementById('chk' + $idx));
	}else{
		document.getElementById('chk' + $idx).checked = false;
	}
}
if (ReadCookie('tokyo') == 'true')	{
	$obj = document.getElementById('place_tokyo');
	$obj.checked = true;
	fnc_place($obj);
}
if (ReadCookie('osaka') == 'true')	{
	$obj = document.getElementById('place_osaka');
	$obj.checked = true;
	fnc_place($obj);
}
if (ReadCookie('nagoya') == 'true')	{
	$obj = document.getElementById('place_nagoya');
	$obj.checked = true;
	fnc_place($obj);
}
if (ReadCookie('fukuoka') == 'true')	{
	$obj = document.getElementById('place_fukuoka');
	$obj.checked = true;
	fnc_place($obj);
}
if (ReadCookie('sendai') == 'true')	{
	$obj = document.getElementById('place_sendai');
	$obj.checked = true;
	fnc_place($obj);
}
if (ReadCookie('okinawa') == 'true')	{
	$obj = document.getElementById('place_okinawa');
	$obj.checked = true;
	fnc_place($obj);
}
if (ReadCookie('event') == 'true')	{
	$obj = document.getElementById('place_event');
	$obj.checked = true;
	fnc_place($obj);
}
</script>

