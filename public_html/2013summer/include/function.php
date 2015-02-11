<?php

	require_once '../mailsystem/calender_off.php';
	
	//---------------------------------------------------
	//Function to secure form and url 
	//---------------------------------------------------
	function secure($variable)
	{
		$variable = htmlentities(trim($variable));
		$variable = stripslashes(stripslashes($variable));
		return $variable;
	}


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
	
	
	//---------------------------------------------------
	//Connexion to database
	//---------------------------------------------------
	function connexion_database ()
	{
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		
		return $db;

	}
	
	//------------------------------------------------------
	// FUNCTION to display a calendar
	//------------------------------------------------------
	
	function calender_show($year, $month,$placename_in_japanese='東京', $place_name='tokyo', $keyword='place = tokyo', $checked_countryname = 1, $checked_know = 1, $navigation_used = 0, $selected_day = 0 )	
	{
		//check if we have passe the 20th of the actual month and display two half of two months
		//this is only working while the page is displayed for the fist time (without starting using navigation bar or)
		$limit_date = check_limit_days_to_display($year,$month,$navigation_used,$selected_day);


		if($limit_date['half_month'] && $limit_date['ending_date_mm'] != $limit_date['beginning_date_mm'])
		{
			if($limit_date['ending_date_yy'] == $limit_date['beginning_date_yy'])
				echo '<div id="place-date-seminar">'.$limit_date['beginning_date_yy'].'年'.$limit_date['beginning_date_mm'].'月'.'/'.$limit_date['ending_date_mm'].'月&nbsp;'.$placename_in_japanese.'会場'.'</div>';
			else					
				echo '<div id="place-date-seminar">'.$limit_date['beginning_date_yy'].'年'.$limit_date['beginning_date_mm'].'月'.'-'.$limit_date['ending_date_yy'].'年'.$limit_date['ending_date_mm'].'月&nbsp;'.$placename_in_japanese.'会場'.'</div>';
		}
		else
		{	
			if($navigation_used!=2) //show month name if 2
				echo '<div id="place-date-seminar">'.$limit_date['beginning_date_yy'].'年'.$limit_date['beginning_date_mm'].'月&nbsp;'.$placename_in_japanese.'会場'.'</div>';
			else
			{
				$class_for_fair =' class="'.$place_name.'"';
				
				echo '<div id="place-date-seminar" '.$class_for_fair.'>'.$placename_in_japanese.'会場<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('F',mktime(0,0,0,$limit_date['beginning_date_mm'],1)).'&nbsp;'.$limit_date['beginning_date_yy'].'&nbsp;</div>';
				
				//seminar counting
				$nb_seminar = count_number_of_seminar($year,$month,$keyword,$navigation_used);
			
				if ($nb_seminar == 0)	{
					print '<div style="margin:40px 0 40px 0; padding: 10px 0 10px 50px; border:3px red dotted; color:red; font-size:14pt; font-weight:bold;">該当するセミナーがありません。検索条件を変更してください。</div>';
				}else{
					print '<div style="font-size:12pt; margin-left:40px;">'.$nb_seminar.'件のセミナーがあります。</div>';
				}
				
			}
		}
		
		if($selected_day==0)
		{
			echo '<a name="calendar_start"></a>';
		}

		if($navigation_used!=2) //not display if the paremeter is 2 (use for example on the autumn fair page)
		{
			echo '<div id="month_navigation"><span id="previous_month">'.previous_month($month, $year, $place_name, $checked_countryname, $checked_know).'</span><span id="actual_month">'.actual_month($place_name, $checked_countryname, $checked_know).'</span><span id="next_month">'.next_month($month, $year, $place_name, $checked_countryname, $checked_know).'</span></div>';
		}
		//print '<table id="seminar-calendar" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" style="font-size: 12pt; color: #666666;" id="'.$year.$month.'" class="'.$year.$month.'">';
		
		print '<table id="seminar-calendar" '.$class_for_fair.' cellspacing="0">'
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
				print '<tr class="data_table">';
				
				for($j=1;$j<=$w;$j++)
				{
					print '<td class="not_actual_month"></td>';
				}
				
				$data = calender_output($i,$w,$year,$month,$day,$place_name,$keyword,$selected_day,$limit_date['date_limit_beginning'],$limit_date['half_month']);
				echo $data;
				if($w==6)
				{
					print "</tr>";
				}
			}
			//一日目以降の場合
			else
			{
				if($w==0)
				{
					print '<tr class="data_table">';
				}
				
				$data = calender_output($i,$w,$year,$month,$day,$place_name,$keyword,$selected_day,$limit_date['date_limit_beginning'],$limit_date['half_month']);
				echo $data;
				
				if($w==6)
				{
					print "</tr>";
				}
			}
		}
		//next month cells to make the calendar full
		if($w!=6)
		{
			for($k=1;$k<(7-$w);$k++)
			{
				print '<td class="not_actual_month"></td>';
			}
			print "</tr>";
		}
		print "</table>";
	
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
					
		$keyword = $where_place.' and k_desc1 like \'%夏のプチ留学フェア%\'';
		
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
	
	function calender_output($i,$w,$year,$month,$day,$place_name,$keyword,$selected_day=0,$date_limit_beginning=1,$half_month=false)
	{

		date_default_timezone_set('Asia/Tokyo');

		global $cal;
		
		
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
					$text_tooltip = $month."月".$i."日";
					
					if(mb_strlen($format_text) > 100)
				 	{
					     $text_tooltip .= "<div>".mb_substr($format_text ,0,100). "...</div>";
				    }
				    else
				         $text_tooltip .= "<div>".mb_substr($format_text ,0,100). "</div>";
				
				}
				else
				{
					$text_tooltip = $month."月".$i."日"
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
	function calender_list($year, $month, $place_name)	
	{
	
		global $cal;
		global $cal_msg;
				
		$yobi = array ('日','月','火','水','木','金','土');

		for($i=1;$i<=62;$i++) // 62 is to display two months results
		{
			$print_today = mktime(0, 0, 0, $month, $i, $year);
						
			if (@$cal[date('Y-n-j', $print_today)] <> '')	
			{
				print '<div class="day_information" id="'.$place_name.date('Ymd', $print_today).'">';
				print '<div class="btn_close_info"><input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();" /></div>';
				print '<div id="date_information">';
				print date('n月j日 ('.$yobi[date('w', $print_today)].')', $print_today);
				print '</div>';
	
				print '<table class="table_list" >'.$cal_msg[date('Y-n-j', $print_today)].'</table>';
				
				print '</div>';
				
			}
		}
	
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
		 
     	return '<a href="seminar.php?navigation=1&amp;month='.$month.'&amp;year='.$year.'&amp;place_name='.$place_name.'&amp;checked_countryname='.$checked_countryname.'&amp;checked_know='.$checked_know.'#calendar_start">'.$date.'</a>';
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
			
    	 return '<a href="seminar.php?navigation=1&amp;month='.$month.'&amp;year='.$year.'&amp;place_name='.$place_name.'&amp;checked_countryname='.$checked_countryname.'&amp;checked_know='.$checked_know.'#calendar_start">'.$date.'</a>';
     }

	//--------------------------------------------------------------------
	// FUNCTION to display previsous month
	//--------------------------------------------------------------------
     function actual_month($place_name, $checked_countryname, $checked_know)
	 {
		$year = date('Y');
		$month = date('n');
		$date = '-最新-'; 
			
    	 return '<a href="seminar.php?navigation=0&amp;month='.$month.'&amp;year='.$year.'&amp;place_name='.$place_name.'&amp;checked_countryname='.$checked_countryname.'&amp;checked_know='.$checked_know.'#calendar_start">'.$date.'</a>';
     }

	
	//--------------------------------------------------------------------
	// FUNCTION to get selected day's list (USED FOR AUTUNM/SPRING FAIR PAGE
	//--------------------------------------------------------------------
	function get_days_list ($place_name,$keyword,$letter_type='A')
	{
		// イベント読み込み
		global $cal;
		global $cal_msg;
		
		$cal = array();
		$cal_msg = array();
		
		$tyo_ymd   = array();
		$tyo_title = array();
		$tyo_desc  = array();
		$tyo_img   = array();
		$tyo_btn   = array();
		$tyo_id	   = array();
	
		try {
			// connect to database
			$db = connexion_database ();
			
			$number = 0; // set variable to 0
			
			//SQL QUERY
			$rs = $db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, group_color, broadcasting, indicated_option, country_code, short_description, seminar_name FROM event_list WHERE  k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, id');
			
			
			$cnt = 0;
			
			
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				
				$cnt++;
				$year	= $row['yy'];
				$month  = $row['mm'];
				$day	= $row['dd'];
				
	
				$start	= $row['start'].'～';
//				$start	= mb_ereg_replace('Mon', '月', $start);
//				$start	= mb_ereg_replace('Tue', '火', $start);
//				$start	= mb_ereg_replace('Wed', '水', $start);
//				$start	= mb_ereg_replace('Thu', '木', $start);
//				$start	= mb_ereg_replace('Fri', '金', $start);
//				$start	= mb_ereg_replace('Sat', '土', $start);
//				$start	= mb_ereg_replace('Sun', '日', $start);
				
				$title	= $start.' '.$row['k_title1'];
	
		
				//Check if flag exists, create a listing
				if ($row['country_code'] == '')
					$flag = '';
				else
					$flag = '<span class="flag_information" id="flag_'.strtolower($row['country_code']).'" ></span>';
					
				
				//Check if color exists
				if ($row['group_color'] == '')
					$color = 'grey';
				else
					$color = strtolower($row['group_color']);
	
					
				//Check if live or not
				if ($row['broadcasting'] != 0)
					$icon_live = '_broadcast';
				else
					$icon_live = '_no_broadcast';
					
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
					$indication = '_full';
					$bdcolor = ' border-left:2px dashed red;';
					$color = '';
					
				}
				else
					$bdcolor = 'border-left:0px;';
					
				$option_information = '<span class="icon_info'.$icon_live.'"></span><span class="icon_info'.$indication.'"></span>';
				
				
				
				// creating the line of the title for the listing
				//------------------------------------------------
				$title_line = '<div class="title_line">'.$flag.'<span class="title_style">'.$row['k_title1'].'</span>'.$option_information.'</div>';
	
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
				
				//Check first if we display the button or not, if the date is older then Today.
				if($row['hiduke'] >= date('Y-m-d') )
				{									
					if ($row['free'] == 1)
					{
						if ($mem_id == '')	
							$c_btn	= '[メンバー限定]';
						else
						{
							if ($row['k_stat'] == 2)	
								$c_btn	= '[満席]';
							else
							{
								if ($row['booking'] >= $row['pax'])	
									$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).$letter_type.']'.$title.'" uid="'.$row['id'].'">';
								else
									$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).$letter_type.']'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
					else
					{					
						if ($row['k_stat'] == 2) // check booking, display button	
							$c_btn	= '[満席]';
						else
						{
							if ($row['booking'] >= $row['pax'])	
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).$letter_type.']'.$title.'" uid="'.$row['id'].'">';
							else
								$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).$letter_type.']'.$title.'" uid="'.$row['id'].'">';
						}
					}
					
				}
				else
				{
					$c_btn = '';
				}
	
				$year	= $row['yy'];
				$month  = $row['mm'];
				$day	= $row['dd'];
	
				$tyo_title[]	= $title.$c_title;
				$tyo_desc[]	= $c_desc;
				$tyo_img[]	= $c_img;
				$tyo_btn[]	= $c_btn;
	
				if ($c_img <> '')	
				{
					$c_img = '<div class="c_img">'.$c_img.'</div>';
					$c_open = '<div class="open">セミナー詳細はココをClick!!</div>';
				}
				else
					$c_open = '<div class="open" id="open_only">セミナー詳細はココをClick!!</div>';
	
	
				$cal[$year.'-'.$month.'-'.$day] .= '<img src="../images/sa05.jpg">';
				$c_msg  = '<tr><td nowrap style="vertical-align:top;" colspan="3"><div class="square_color" style="background-color:'.$color.'; '.$bdcolor.'">&nbsp;</div><span class="starttime">'.$row['starttime'].'～ </span><a target="_blank" href="../event/map/?p='.$row['place'].'">'.translate_city($row['place']).'会場</a>';
				$c_msg .= $title_line.'</td></tr><tr><td colspan="4">';
				$c_msg .= '<div class="c_btn">'.$c_btn.'</div>'.$c_img.$c_open;
				$c_msg .= '<div class="det" style="border-color:'.$color.';">'.$c_title.nl2br($c_desc).'</div></td></tr>';
				$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;
	
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

?>