<?php
header('Access-Control-Allow-Origin:*');//全ドメイン許可する場合 
//---------------------------------------------------
//Function to secure form and url
//---------------------------------------------------
function secure($variable)
{
	$variable = htmlentities(trim($variable));
	$variable = stripslashes(stripslashes($variable));
	return $variable;
}

/*
//---------------------------------------------------
//Function to translate City name English to Japanese
//---------------------------------------------------
function translate_city ($cityname = 'tokyo')
{

	$array_cities = array(	'tokyo' 		=> '東京',
		'osaka' 		=> '大阪',
		'sendai'		=> '仙台',
		'toyama' 		=> '大阪',
		'fukuoka'		=> '福岡',
		'okinawa'		=> '沖縄',
		'toyama'		=> '富山',
		'nagoya'		=> '名古屋',
		'event'			=> 'イベント'
	);

	$japanese_cityname = $array_cities[$cityname];

	return $japanese_cityname;
}
*/

//---------------------------------------------------
//Connexion to database
//---------------------------------------------------
function connexion_database ()
{
	$ini = array();
	$parse_file_path = './bin/pdo_mail_list.ini';
	if (is_file($parse_file_path)) {
		$ini = parse_ini_file($parse_file_path, FALSE);
	}
	if (empty($ini)) {
		$parse_file_path = '../' . $parse_file_path;
		if (is_file($parse_file_path)) {
			$ini = parse_ini_file($parse_file_path, FALSE);
		}
	}
	if (empty($ini)) {
		$parse_file_path = '../' . $parse_file_path;
		if (is_file($parse_file_path)) {
			$ini = parse_ini_file($parse_file_path, FALSE);
		}
	}
	if (empty($ini)) {
		$parse_file_path = '../' . $parse_file_path;
		if (is_file($parse_file_path)) {
			$ini = parse_ini_file($parse_file_path, FALSE);
		}
	}
	if (empty($ini)) {
		die('Cannot fild ini files.');
	}
	//$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

	$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('SET CHARACTER SET utf8');

	return $db;

}

//------------------------------------------------------
// FUNCTION to display a calendar
//------------------------------------------------------

function calender_show($cal, $year, $month,$placename_in_japanese='東京', $place_name='tokyo', $keyword='place = tokyo', $checked_countryname = 1, $checked_know = 1, $navigation_used = 0, $selected_day = 0, $calendar_title_active = 'active', $calendar_start_date = "", $calendar_end_date = "" )
{
	$ret = $class_for_fair = "";
	//check if we have passe the 20th of the actual month and display two half of two months
	//this is only working while the page is displayed for the fist time (without starting using navigation bar or)
	$limit_date = check_limit_days_to_display($year,$month,$navigation_used,$selected_day);

	if($limit_date['half_month'] && $limit_date['ending_date_mm'] != $limit_date['beginning_date_mm'])
	{
		if($limit_date['ending_date_yy'] == $limit_date['beginning_date_yy'])
			$ret .= ($calendar_title_active == 'active' || $calendar_title_active == 'on' || $calendar_title_active == 'true' || $calendar_title_active == 'yes') ? '<div id="place-date-seminar">'.$limit_date['beginning_date_yy'].'年'.$limit_date['beginning_date_mm'].'月'.'/'.$limit_date['ending_date_mm'].'月&nbsp;'.$placename_in_japanese.'会場'.'</div>' : '';
		else
			$ret .= ($calendar_title_active == 'active' || $calendar_title_active == 'on' || $calendar_title_active == 'true' || $calendar_title_active == 'yes') ? '<div id="place-date-seminar">'.$limit_date['beginning_date_yy'].'年'.$limit_date['beginning_date_mm'].'月'.'-'.$limit_date['ending_date_yy'].'年'.$limit_date['ending_date_mm'].'月&nbsp;'.$placename_in_japanese.'会場'.'</div>' : '';
	}
	else
	{
		if($navigation_used!=2) //show month name if 2
			$ret .= ($calendar_title_active == 'active' || $calendar_title_active == 'on' || $calendar_title_active == 'true' || $calendar_title_active == 'yes') ? '<div id="place-date-seminar">'.$limit_date['beginning_date_yy'].'年'.$limit_date['beginning_date_mm'].'月&nbsp;'.$placename_in_japanese.'会場'.'</div>' : '';
		else
		{
			$class_for_fair =' class="'.$place_name.'"';

			$ret .= ($calendar_title_active == 'active' || $calendar_title_active == 'on' || $calendar_title_active == 'true' || $calendar_title_active == 'yes') ? '<div id="place-date-seminar" '.$class_for_fair.'>'.$placename_in_japanese.'会場<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('F',mktime(0,0,0,$limit_date['beginning_date_mm'],1)).'&nbsp;'.$limit_date['beginning_date_yy'].'&nbsp;</div>' : '';

			//seminar counting
			$nb_seminar = count_number_of_seminar($year,$month,$keyword,$navigation_used);

			if ($nb_seminar == 0)	{
				$ret .= '<div style="margin:40px 0 40px 0; padding: 10px 0 10px 50px; border:3px red dotted; color:red; font-size:14pt; font-weight:bold;">該当するセミナーがありません。検索条件を変更してください。</div>';
			}else{
				$ret .= '<div style="font-size:12pt; margin-left:40px;">'.$nb_seminar.'件のセミナーがあります。</div>';
			}

		}
	}

	if($selected_day==0)
	{
		$ret .= '<a name="calendar_start"></a>';
	}

	if($navigation_used!=2) //not display if the paremeter is 2 (use for example on the autumn fair page)
	{
		$previous = $actual = $next = "";
		$start_ym = date("Ym", strtotime(empty($calendar_start_date) ? date('Y-m-d') : $calendar_start_date));
		$end_ym = date("Ym", strtotime(empty($calendar_end_date) ? date('Y-m-d') : $calendar_end_date));

		$prev_y = $year;
		$prev_m = $month - 1;
		if ($prev_m == 0) {
			$prev_y--;
			$prev_m = 12;
		}
		$link_prev_ym = $prev_y . sprintf("%02d", $prev_m);
		if (empty($calendar_start_date) or $start_ym <= $link_prev_ym) {
			$previous = '<span id="previous_month">'.previous_month($month, $year, $place_name, $checked_countryname, $checked_know).'</span>';
		}

		$now_ym = date('Ym');
		if ($start_ym <= $now_ym and $now_ym <= $end_ym) {
			$actual = '<span id="actual_month">'.actual_month($place_name, $checked_countryname, $checked_know).'</span>';
		}

		$next_y = $year;
		$next_m = $month + 1;
		if ($next_m == 13) {
			$next_y++;
			$next_m = 1;
		}
		$link_next_ym = $next_y . sprintf("%02d", $next_m);
		if (empty($calendar_end_date) or $link_next_ym <= $end_ym) {
			$next = '<span id="next_month">'.next_month($month, $year, $place_name, $checked_countryname, $checked_know).'</span>';
		}

		$ret .= '<div id="month_navigation">' . $previous . $actual . $next . '</div>';
	}

	$ret .= '<table id="seminar-calendar" '.$class_for_fair.' cellspacing="0" style="word-wrap: break-word;table-layout: fixed;">'
		.'<tr class="head_table">'
		.'<th>日</th>'
		.'<th>月</th>'
		.'<th>火</th>'
		.'<th>水</th>'
		.'<th>木</th>'
		.'<th>金</th>'
		.'<th>土</th>'
		. '</tr>'
		. '<tr class="empty_cell">'
		. '<td colspan="7"></td>'
		. '</tr>';

	//カレンダーの日付を作る
	//for($i=$day;$i<=$num;$i++)
	for($i=$limit_date['day'];$i<=$limit_date['last_day_to_search'];$i++)
	{

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);

		//曜日は数値 - day of the week (0 for sun - 6 for sat)
		$w = date("w", $print_today);


		//一日目の曜日を取得する
		if($i==$limit_date['day'])
		{
			//一日目の曜日を提示するまでを繰り返し
			$ret .= '<tr class="data_table">';

			for($j=1;$j<=$w;$j++)
			{
				$ret .= '<td class="not_actual_month"></td>';
			}

			$ret .= calender_output($cal, $i,$w,$year,$month,"",$place_name,$keyword,$selected_day,$limit_date['date_limit_beginning'],$limit_date['half_month']);

			if($w==6)
			{
				$ret .= "</tr>";
			}
		}
		//一日目以降の場合
		else
		{
			if($w==0)
			{
				$ret .= '<tr class="data_table">';
			}

			$ret .= calender_output($cal, $i,$w,$year,$month,"",$place_name,$keyword,$selected_day,$limit_date['date_limit_beginning'],$limit_date['half_month']);

			if($w==6)
			{
				$ret .= "</tr>";
			}
		}
	}
	//next month cells to make the calendar full
	if($w!=6)
	{
		for($k=1;$k<(7-$w);$k++)
		{
			$ret .= '<td class="not_actual_month"></td>';
		}
		$ret .= "</tr>";
	}
	$ret .= "</table>";

	return $ret;
}

function calender_show_limit($start_ymd, $end_ymd, $cal, $year, $month,$placename_in_japanese='東京', $place_name='tokyo', $keyword='place = tokyo', $checked_countryname = 1, $checked_know = 1, $navigation_used = 0, $selected_day = 0, $calendar_title_active = 'active', $calendar_start_date = "", $calendar_end_date = "" )
{
	$ret = $class_for_fair = "";
	//check if we have passe the 20th of the actual month and display two half of two months
	//this is only working while the page is displayed for the fist time (without starting using navigation bar or)
	$limit_date = check_limit_days_to_display($year,$month,$navigation_used,$selected_day);

	if($selected_day==0)
	{
		$ret .= '<a name="calendar_start"></a>';
	}

	$ret .= '<table id="seminar-calendar" '.$class_for_fair.' cellspacing="0" style="word-wrap: break-word;table-layout: fixed;">'
		.'<tr class="head_table">'
		.'<th>日</th>'
		.'<th>月</th>'
		.'<th>火</th>'
		.'<th>水</th>'
		.'<th>木</th>'
		.'<th>金</th>'
		.'<th>土</th>'
		. '</tr>'
		. '<tr class="empty_cell">'
		. '<td colspan="7"></td>'
		. '</tr>';

	//カレンダーの日付を作る
	//for($i=$day;$i<=$num;$i++)
//	for($i=$limit_date['day'];$i<=$limit_date['last_day_to_search'];$i++)
	$sa = (strtotime($end_ymd)-strtotime($start_ymd))/(3600*24);
	$year = date('Y', strtotime($start_ymd));
	$month = date('n', strtotime($start_ymd));
	$saisho = date('j', strtotime($start_ymd));
	$limit_date['half_month'] = true;

	$getsumatsu = 0;
	for($i=$saisho; $i<=$saisho+$sa; $i++)
	{
		// もし月と日の情報がなかったら、月を+1して、日を1にする
		$day = $i - $getsumatsu;
		if (checkdate($month, $day, $year) == false) {
			$getsumatsu += date('t', strtotime($year . '/' . $month . '/01'));
			$month++;
			$day = 1;
			if (checkdate($month, $day, $year) == false) {
				$year++;
				$month = 1;
			}
		}

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $day, $year);

		//曜日は数値 - day of the week (0 for sun - 6 for sat)
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		//if($i==$limit_date['day'])
		if($i==$saisho)
		{
			//一日目の曜日を提示するまでを繰り返し
			$ret .= '<tr class="data_table">';
			for($j=1;$j<=$w;$j++)
			{
				$ret .= '<td class="not_actual_month"></td>';
			}

			$ret .= calender_output($cal, $day,$w,$year,$month,"",$place_name,$keyword,$selected_day,$limit_date['date_limit_beginning'],$limit_date['half_month'],true);

			if($w==6)
			{
				$ret .= "</tr>";
			}
		}
		//一日目以降の場合
		else
		{
			if($w==0)
			{
				$ret .= '<tr class="data_table">';
			}

			$ret .= calender_output($cal, $day,$w,$year,$month,"",$place_name,$keyword,$selected_day,$limit_date['date_limit_beginning'],$limit_date['half_month'],true);

			if($w==6)
			{
				$ret .= "</tr>";
			}
		}
	}
	//next month cells to make the calendar full
	if($w!=6)
	{
		for($k=1;$k<(7-$w);$k++)
		{
			$ret .= '<td class="not_actual_month"></td>';
		}
		$ret .= "</tr>";
	}
	$ret .= "</table>";

	return $ret;
}

//------------------------------------------------------
// FUNCTION returning the dates limiting the display for two halfs of the actual and following
//------------------------------------------------------
function check_limit_days_to_display($year,$month,$navigation_used,$selected_day=0)
{
	$day = "1";
	//number of days in the given month
	$num = date("t", mktime(0,0,0,$month,$day,$year));

	$date_limit_beginning = date('j');
	$date_limit_ending = $date_limit_beginning + 28; //used to be $num+28

	$today_number= date('j');

	if($navigation_used==0 || $selected_day!=0)
	{
		if($month == date('n') && $today_number>=$date_limit_beginning)
		{
			$half_month = true;

			$first_week_firstday = date('w', mktime(0, 0, 0, $month, $date_limit_beginning, $year));
			$last_week_lastday = date('w', mktime(0, 0, 0, $month, $date_limit_ending, $year));

			//get the number of the first day of the first week
			for($a=$first_week_firstday;$a>0;$a--)
			{
				$date_limit_beginning = $date_limit_beginning -1;
			}

			//get the number of the last day of the last week
			for($z=$last_week_lastday;$z<6;$z++)
			{
				$date_limit_ending = $date_limit_ending +1;
			}

			$beginning_date_yy = date('Y', mktime(0, 0, 0, $month, $date_limit_beginning, $year));
			$beginning_date_mm = date('n', mktime(0, 0, 0, $month, $date_limit_beginning, $year));
			$beginning_date_dd = date('j', mktime(0, 0, 0, $month, $date_limit_beginning, $year));

			$ending_date_yy = date('Y', mktime(0, 0, 0, $month, $date_limit_ending, $year));
			$ending_date_mm = date('n', mktime(0, 0, 0, $month, $date_limit_ending, $year));
			$ending_date_dd = date('j', mktime(0, 0, 0, $month, $date_limit_ending, $year));

			$day=$date_limit_beginning;
			$last_day_to_search = $date_limit_ending;
		}
		else
		{
			$half_month = false;

			$beginning_date_yy = $year;
			$beginning_date_mm = $month;
			$beginning_date_dd = 1;

			$ending_date_yy = $year;
			$ending_date_mm = $month;
			$ending_date_dd = 31;

			$last_day_to_search = $num;
		}


	}
	else
	{
		$half_month = false;

		$beginning_date_yy = $year;
		$beginning_date_mm = $month;
		$beginning_date_dd = 1;

		$ending_date_yy = $year;
		$ending_date_mm = $month;
		$ending_date_dd = 31;

		$last_day_to_search = $num;
	}

	$array_limits = array (
		'day'					=> $day,
		'last_day_to_search'	=> $last_day_to_search,
		'date_limit_beginning' 	=> $date_limit_beginning,
		'half_month'			=> $half_month,
		'beginning_date_yy' 	=> $beginning_date_yy,
		'beginning_date_mm'		=> $beginning_date_mm,
		'beginning_date_dd' 	=> $beginning_date_dd,
		'ending_date_yy' 		=> $ending_date_yy,
		'ending_date_mm' 		=> $ending_date_mm,
		'ending_date_dd' 		=> $ending_date_dd
	);

	return $array_limits;
}



//------------------------------------------------------
// FUNCTION to display a calendar DATA
//------------------------------------------------------
function count_number_of_seminar($year,$month,$keyword,$navigation_used=0)
{


	$limit_date = check_limit_days_to_display($year,$month,$navigation_used);

	//check the digit of month and day to allow a research in the database
	if($limit_date['beginning_date_mm'] < 10)
		$new_format_beginning_month= '0'.$limit_date['beginning_date_mm'];
	else
		$new_format_beginning_month= $limit_date['beginning_date_mm'];

	if($limit_date['beginning_date_dd'] < 10)
		$new_format_beginning_day= '0'.$limit_date['beginning_date_dd'];
	else
		$new_format_beginning_day= $limit_date['beginning_date_dd'];

	if($limit_date['ending_date_mm'] < 10)
		$new_format_ending_month= '0'.$limit_date['ending_date_mm'];
	else
		$new_format_ending_month= $limit_date['ending_date_mm'];

	if($limit_date['ending_date_dd'] < 10)
		$new_format_ending_day= '0'.$limit_date['ending_date_dd'];
	else
		$new_format_ending_day= $limit_date['ending_date_dd'];



	//connect to database
	$db = connexion_database ();
	$rs = $db->query('SELECT count(*) as number FROM event_list WHERE  hiduke <= \''.$limit_date['ending_date_yy'].'-'.$new_format_ending_month.'-'.$new_format_ending_day.'\' and hiduke >= \''.$limit_date['beginning_date_yy'].'-'.$new_format_beginning_month.'-'.$new_format_beginning_day.'\' and  k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, id');

	$row = $rs->fetch(PDO::FETCH_ASSOC);
	$countnumber=$row['number'];
	return $countnumber;
}

//------------------------------------------------------
// FUNCTION to display a calendar DATA
//------------------------------------------------------

function calender_output($cal, $i,$w,$year,$month,$day,$place_name,$keyword,$selected_day=0,$date_limit_beginning=1,$half_month=false,$all_white=false)
{
	date_default_timezone_set('Asia/Tokyo');

	//check if this is the entire actual month (Past the 20th, we show half a month)
	if($half_month)
	{
		if ($month == date('n') && $i >= $date_limit_beginning)
		{
			$new_i = date('j',mktime(0, 0, 0, $month, $i, $year));
			$new_month = date('n', mktime(0, 0, 0, $month, $i, $year));
			$new_year = date('Y',  mktime(0, 0, 0, $month, $i, $year));


			$i= $new_i;
			$month=$new_month;
			$year=$new_year;
		}
	}


	//check the digit of $i to allow a research in the database
	if($i < 10)
		$new_format_i= '0'.$i;
	else
		$new_format_i= $i;

	//check the digit of $month  to allow a research in the database
	if($month < 10)
		$new_format_month= '0'.$month;
	else
		$new_format_month= $month;

	//connect to database
	$db = connexion_database ();
	$rs = $db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, group_color, broadcasting, indicated_option, country_code, short_description, seminar_name FROM event_list WHERE  hiduke = \''.$year.'-'.$new_format_month.'-'.$new_format_i.'\' and  k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, id');

	$change = "";

	//$link = '<a href="./event.php?act=new&year='.$year.'&month='.$month.'&day='.$i.'#'.$year.$month.'">'.$i.'</a>';

	//if (@$cal[$year.$month.$i])
	//{
	//		$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'">'.@$cal[$year.$month.$i].$i.'</a><br/>';
	//$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'">'.$i.'</a><br/>';
	$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'">'.$i.'</a><br/>';
	//$link = '<a href="?date_calendar='.$year.'-'.substr('00'.$month,-2).'-'.substr('00'.$i,-2).'">'.$i.'</a><br/>';
	//}
	//else

	//PUBLIC HOLIDAYS
	//----------------
	$public_holidays = publicholidays($year,$month,$i);
	if($public_holidays)
		$change = "on";

	$new_id = "";
	//check if a day has been selected from the calendar module
	if($i == $selected_day)
	{
		//are we displaying two half of month ?
		if($half_month)
		{
			// only display differently the day of the actual month
			if($month == date('n'))
			{
				$link = '<span class="chosen_day-following_month">'.$month.'/'.$i.'</span><a name="calendar_start"></a>';
				$new_id = 'id="selected_day"';
			}
			else
			{
				$new_class = 'class ="following_month"';
				$display_result = $month.'/'.$i;

				if ($w == "6")
				{
					// Saturday
					$link = '<span class="date_saturday">'.$display_result.'</span>';
				}
				else
				{
					if ($change == "on" || $w == "0")
					{
						// Sunday or Public-Holiday
						$link = '<span class="date_sunday">'.$display_result.'</span>';

					}
					else
					{
						// Monday to Friday
						$link = '<span class="date_number">'.$display_result.'</span>';
					}
				}
			}

		}
		else
		{
			$link = '<span class="chosen_day">'.$i.'</span><a name="calendar_start"></a>';
			$new_id = 'id="selected_day"';
		}

	}
	else
	{
		//are we displaying two half of month ?
		if($half_month)
		{
			if($all_white)	{
				$new_class = 'class ="actual_month-following_month"';
				$display_result = $month.'/'.$i;
			}else{
				//following month
				if($month>date('n'))
				{
					$new_class = 'class ="following_month"';
					$display_result = $month.'/'.$i;
				}
				else
				{
					$new_class = 'class ="actual_month-following_month"';
					$display_result = $month.'/'.$i;
				}
			}
		}
		else
			$display_result = $i;

		if ($w == "6")
		{
			// Saturday
			$link = '<span class="date_saturday">'.$display_result.'</span>';
		}
		else
		{
			if ($change == "on" || $w == "0")
			{
				// Sunday or Public-Holiday
				$link = '<span class="date_sunday">'.$display_result.'</span>';

			}
			else
			{
				// Monday to Friday
				$link = '<span class="date_number">'.$display_result.'</span>';
			}
		}
	}


	$change = "";

	// NOTE: the old code used to have several 'if' condition => if($w==0) / elseif($w==6) / else
	// However the same result was used for all of them. So from now on, only the result is displayed

	//$change = '<td>';
	$change = '<td '.$new_class.' '.$new_id.' onclick="$.blockUI({ message: $(\'#'.$place_name.$year.substr('00'.$month,-2).substr('00'.$i,-2).'\'),
		css: { 	left: ($(window).width()-800)/2 +\'px\', 
				overflow: \'auto\',
				cursor:\'default\',
				width: \'auto\',
				height: \'auto\'
		}});$(\'.blockMsg\').css(\'max-height\', 90 +\'%\');$(\'.blockMsg\').css(\'min-height\',200 +\'px\');$(\'.blockMsg\').css(\'max-width\',800+\'px\');$(\'.blockMsg\').css(\'top\', ($(window).height()-$(\'.blockMsg\').height())/2 +\'px\');">';


	$change .= $link;

	$list_flag = '';
	$number_flag = 0;
	$array_flay = array();
	$listing_data = "";

	// dispay details in the cell
	while($row = $rs->fetch(PDO::FETCH_ASSOC))
	{

		//Check if color exists
		if ($row['group_color'] == '')
		{
			$color = 'grey';
			$fontcolor = 'black';
			$backgroundcolor = 'white';
			$title_color = 'white';
			$title_bg_color = $color;
		}
		else
		{
			$color = strtolower($row['group_color']);
			$fontcolor = 'white';
			$backgroundcolor = strtolower($row['group_color']);
			$title_color = 'white';
			$title_bg_color = $color;

		}

		//Check if flag exists, create a listing
		if ($row['country_code'] == '')
			$flag = '';

		else
		{
			$flag = strtolower($row['country_code']);


			//check if the flag is already displayed, if not let's diplay it
			if (in_array($flag, $array_flay))
			{
				//echo 'Got'.$flag;
			}
			else
				$list_flag .= '<span class="flag_'.$flag.'"></span>';


			//gather all flag already displayed in an array
			$array_flay[$number_flag] = $flag;

		}


		//Check if seminar name exists
		if ($row['seminar_name'] == '')
			$seminar_name = 'no name';
		else
			$seminar_name = $row['seminar_name'];

		//Check if short description exists
		if ($row['short_description'] == '')
			$decription = '';
		else
			$decription = $row['short_description'];

		//Check if live or not
		if ($row['broadcasting'] != 0)
		{
			$icon_live = 'broadcast';
			$display_icone = $icon_live;
		}
		else
			$icon_live = 'no_broadcast';

		//Check the option statut
		switch ($row['indicated_option'])
		{
			case 0:
				$indication ='';

				break;
			case 1:
				$indication = '_osusume';
				break;
			case 2:
				$indication = '_shinchyaku';
				break;
		}

		//if full
		if($row['k_stat'] == 2 || $row['booking'] >= $row['pax'] || $row['hiduke'] < date('Y-m-d'))
		{
			$fullybooked = 'fullybooked';
			$style_name = "style=\"\"";
			$style_description = "style=\"\"";
			$indication = '_full';
			$title_color = 'white';
			$color = 'red';

			if($row['hiduke'] < date('Y-m-d'))
				$seminar_booked = '';
			else
				$seminar_booked = '満席&nbsp;&nbsp;&nbsp;';

			$border_style = 'DASHED';
			$title_bg_color = '';

		}
		else
		{
			$seminar_booked = '';
			$fullybooked = $indication;
			$style_name = "style=\" color:".$fontcolor."; background-color:".$backgroundcolor.";\"";
			$style_description = "style=\" color:".$color.";\"";
			$border_style = 'SOLID';

		}


		$option = '<div class="option'.$indication.'"></div>';


		//format text to display it
		//-------------------------
		//Remove all tags (without IMG-TAG)
		$notags_text = strip_tags($row['k_desc1']);

		//Remove images tag that cause error
		$noimage_text = preg_replace("/<img[^>]+\>/i", "", $notags_text);

		//Remove all return to lines
		$format_text = preg_replace('/(\r\n|\n|\r)/', '', $noimage_text);

		//information during rollover tooltip
		if ($flag == '' && $icon_live == 'no_broadcast' && $indication == '')
		{
			$text_tooltip = $month."月".$i."日 " . $row['starttime'] . '〜 ';

			if(mb_strlen($format_text) > 200)
			{
				$text_tooltip .= "<div>".mb_substr($format_text ,0,100). "...</div>";
			}
			else
				$text_tooltip .= "<div>".mb_substr($format_text ,0,100). "</div>";

		}
		else
		{
			$text_tooltip = $month."月".$i."日 " . $row['starttime'] . '〜 '
				."<div id=\'tooltip\'><span class=\'tooltip_flag_".$flag."\'></span><span class=\'tooltip_".$icon_live."\'></span><span class=\'tooltip_option".$indication."\'></span></div>";

			if(mb_strlen($format_text) > 100)
			{
				$text_tooltip .= "<div>".mb_substr($format_text ,0,100)."...</div>";
			}
			else
				$text_tooltip .= "<div>".mb_substr($format_text ,0,100). "</div>";
		}

		//display or not div with icones
		if ($indication == '' && $icon_live =='no_broadcast' )
			$listing_data .= "";
		else
			$listing_data .= "<div>".$option."</div>";


		$listing_data .= "<div class=\"description_seminar ".$fullybooked."\" ".$style_description.">".$decription."</div>"
			. "<div class=\"name_seminar ".$fullybooked."\" ".$style_name." onmouseover=\"Tip('".$text_tooltip."', BGCOLOR, 'WHITE', TITLE, '".$seminar_booked.$seminar_name."', TITLEBGCOLOR, '".$title_bg_color."', TITLEFONTCOLOR, '".$title_color."', BORDERCOLOR, '".$color."', BORDERSTYLE, '".$border_style."', PADDING, 9, WIDTH, -300)\" onmouseout=\"UnTip()\">".$seminar_name."</div>";


		$number_flag++;


	}

	//$change .= "<div id=\"list_flag\">".$list_flag.$listing_data."</div></td>";

	//display or not broadcast icone?
	if ($display_icone == 'broadcast')
		$icon_live = $display_icone;

	$change .= "<span class=\"".$icon_live."\"></span><span class=\"list_flag\">".$list_flag."</span>".$listing_data."</td>";

	return $change;
}

//-----------------------------------------------------------------
// FUNCTION to display the list of seminar of the "chosen calendar"
//----------------------------------------------------------------
function calender_list($cal, $cal_msg, $year, $month, $place_name)
{
	$ret = "";
	$yobi = array ('日','月','火','水','木','金','土');

	for($i=1;$i<=90;$i++) // 62 is to display two months results
	{
		$print_today = mktime(0, 0, 0, $month, $i, $year);

		if (@$cal[date('Y-n-j', $print_today)] <> '')
		{
			$ret .= '<div class="day_information" id="'.$place_name.date('Ymd', $print_today).'">';
			$ret .= '<div class="btn_close_info"><input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();" /></div>';
			$ret .= '<div id="date_information">';
			$ret .= date('n月j日 ('.$yobi[date('w', $print_today)].')', $print_today);
			$ret .= '</div>';

			$ret .= '<table class="table_list" >'.$cal_msg[date('Y-n-j', $print_today)].'</table>';

			$ret .= '</div>';

		}
	}
	return $ret;
}


//--------------------------------------------------------------------
// FUNCTION to display next month
//--------------------------------------------------------------------
function next_month($month, $year, $place_name, $checked_countryname, $checked_know)
{
	//add one more month
	$month++;

	//Check if we are over decembre, then add one more year
	if($month == 13)
	{
		$year++;
		$month=1;

		$date = $year.'年'.$month.'月&gt;&gt;';
	}
	else
		$date = $month.'月&gt;&gt;';
        //suspicious
	return '<a href="'.$_SERVER['HTTP_REFERER'].'?navigation=1&amp;month='.$month.'&amp;year='.$year.'&amp;place_name='.$place_name.'&amp;checked_countryname='.$checked_countryname.'&amp;checked_know='.$checked_know.'#calendar_start">'.$date.'</a>';
}


//--------------------------------------------------------------------
// FUNCTION to display previsous month
//--------------------------------------------------------------------
function previous_month($month, $year, $place_name, $checked_countryname, $checked_know)
{
	//subtract one month
	$month--;

	//Check if we are before january, then subtracta year
	if($month==0)
	{
		$year--;
		$month=12;
		$date = '&lt;&lt;'.$year.'年'.$month.'月';
	}
	else
		$date = '&lt;&lt;'.$month.'月';

	return '<a href="'.$_SERVER['HTTP_REFERER'].'?navigation=1&amp;month='.$month.'&amp;year='.$year.'&amp;place_name='.$place_name.'&amp;checked_countryname='.$checked_countryname.'&amp;checked_know='.$checked_know.'#calendar_start">'.$date.'</a>';
}

//--------------------------------------------------------------------
// FUNCTION to display previsous month
//--------------------------------------------------------------------
function actual_month($place_name, $checked_countryname, $checked_know)
{
	$year = date('Y');
	$month = date('n');
	$date = '-最新-';

	return '<a href="?navigation=0&amp;month='.$month.'&amp;year='.$year.'&amp;place_name='.$place_name.'&amp;checked_countryname='.$checked_countryname.'&amp;checked_know='.$checked_know.'#calendar_start">'.$date.'</a>';
}

