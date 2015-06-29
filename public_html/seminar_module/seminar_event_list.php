<?php

function event_calendar_show($calendar, $year, $month)	{

	$ret = "";
	$day = "1";
	$num = date("t", mktime(0,0,0,$month,$day,$year));

	$ret .= '<table border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" style="font-size: 12pt; color: #666666;" id="'.$year.$month.'" class="'.$year.$month.'">';
	$ret .= '<tr>';
	$ret .= '<td align="center" colspan="7" bgcolor="#EEEEEE" height="18" style="color: #666666;">'.$year.'年'.$month.'月</td></tr>';
	$ret .= '<tr>';
	$ret .= '<td align="center" width="40" height="18" bgcolor="#FF3300" style="color: #FFFFFF;">日</td>';
	$ret .= '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">月</td>';
	$ret .= '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">火</td>';
	$ret .= '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">水</td>';
	$ret .= '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">木</td>';
	$ret .= '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">金</td>';
	$ret .= '<td align="center" width="40" bgcolor="#A6C0E1" style="color: #666666;">土</td>';
	$ret .= '</tr>';

	//カレンダーの日付を作る
	for($i=$day;$i<=$num;$i++){

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		//曜日は数値
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		if($i==1){
			//一日目の曜日を提示するまでを繰り返し
			$ret .= "<tr>";
			for($j=1;$j<=$w;$j++){
				$ret .= "<td></td>";
			}
			$ret .= event_calendar_output($calendar, $i,$w,$year,$month,$day);
			if($w==6){
				$ret .= "</tr>";
			}
		}
		//一日目以降の場合
		else{
			if($w==0){
				$ret .= "<tr>";
			}
			$ret .= event_calendar_output($calendar, $i,$w,$year,$month,$day);
			if($w==6){
				$ret .= "</tr>";
			}
		}
	}
	if($w!=6){
		$ret .= "</tr>";
	}
	$ret .= "</table>";

	return $ret;
}

function event_calendar_output($cal, $i,$w,$year,$month,$day){

	$change = "";
	$link = $i;

	if (@$cal[$year.'-'.$month.'-'.$i])	{
//		$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'">'.@$cal[$year.$month.$i].$i.'</a><br/>';
		$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'"><img src="/images/sa01.jpg">'.$i.'</a><br/>';
	}

	//PUBLIC HOLIDAYS
	//----------------
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


function event_calender_list($cal, $cal_msg, $config = array(), $target_seminar_id = "", $isPc = true)	{

	$ret = "";
	$yobi = array ('日','月','火','水','木','金','土');
	$backcolor    = @$config['list']['backcolor'];
	$forecolor    = @$config['list']['forecolor'];
	$window_width = @$config['list']['window_width'];

	if (empty($backcolor)) $backcolor = "#FFA500";
	if (empty($forecolor)) $forecolor = "white";
	if (empty($window_width)) $window_width = "660px";

	$isView = false;
	foreach ($cal as $cal_k => $cal_v) {
		$print_today = strtotime($cal_k);
		$cal_data = @$cal_msg[date('Y-n-j', $print_today)];
		$tr_arr = explode('<tr>', $cal_data);
		array_shift($tr_arr); // 最初のtr分削除
		$cal_output = "";

		if (empty($target_seminar_id)) {
			$cal_output .= '<tr>' . implode('<tr>', $tr_arr);
		} else {
			if ($isPc) {
				for ($i = 0; $i < count($tr_arr); $i = $i + 2) {
					if (strpos($tr_arr[$i], 'uid="' . $target_seminar_id . '"') !== false || strpos($tr_arr[$i + 1], 'uid="' . $target_seminar_id . '"') !== false) {
						$cal_output .= '<tr>' . $tr_arr[$i] . '<tr>' . $tr_arr[$i + 1];
					}
				}
			} else {
				for ($i = 0; $i < count($tr_arr); $i = $i + 3) {
					if (strpos($tr_arr[$i], 'uid="' . $target_seminar_id . '"') !== false || strpos($tr_arr[$i + 1], 'uid="' . $target_seminar_id . '"') !== false || strpos($tr_arr[$i + 2], 'uid="' . $target_seminar_id . '"') !== false) {
						$cal_output .= '<tr>' . $tr_arr[$i] . '<tr>' . $tr_arr[$i + 1] . '<tr>' . $tr_arr[$i + 2];
					}
				}
			}
		}

		if (!empty($cal_output)) $isView = true;

		$tmp_str = "";
		$tmp_str .= '<div style="font-size: 13px; text-align: left; width: ' . $window_width . ';" id="'.date('Ymd', $print_today).'">';
		$tmp_str .= '<div style="padding: 2px; margin: 10px; background-color: ' . $backcolor . '; color: ' . $forecolor . '; font-weight: bold; text-align: center;" class="seminar_date">';
		$tmp_str .= date('Y年 n月 j日 ('.$yobi[date('w', $print_today)].')', $print_today);
		$tmp_str .= '</div>';
		$tmp_str .= '<table class="seminar_table" style="margin: 0 14px; width: 90%;" >'.$cal_output.'</table>';
		$tmp_str .= '</div>';

		if (empty($target_seminar_id)) {
			$ret .= $tmp_str;
		} elseif (strpos($tmp_str, 'uid="' . $target_seminar_id . '"') !== false) {
			$ret .= $tmp_str;
		}
	}

	return array($ret, $isView);
}
