<?php

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

		if ((@$_SESSION['para2'] == 'fukuoka' || @$_SESSION['para3'] == 'fukuoka' ) && $cityname == 'event')	{
			$japanese_cityname = '福岡特別';
		}
		return $japanese_cityname;
	}
	
	
	//-----------------------------------------------------------------
	// FUNCTION to display the list of seminar of the "chosen calendar"
	//----------------------------------------------------------------
	function calendar_list($lastdate_display='empty')	
	{
		global $cal;
		global $cal_msg;
		global $cal_cnt;
		global $cal_iconlist;
		global $cal_flaglist;
		global $cnt;
		global $just_one;
		
		global $cal_msg_selected;

		$year = date('Y');
		$month = date('n');
		$day  = date('d');
		$day = $day - date('w');
		
		$start = 0; //beginning of the display
	
		$yobi = array ('日','月','火','水','木','金','土');
	
		$adding_days = 150;
		
		for($i=$day;$i<=$day + $adding_days;$i++)
		{	
			$print_today = mktime(0, 0, 0, $month, $i, $year);
			if (@$cal[date('Ynj', $print_today)] <> '')	
			{
				//create icon list for title-date
				$display_icon = '';
				
				if($just_one === false)
				{
					if(in_array('broadcast', $cal_iconlist[date('Ynj', $print_today)]))
						$display_icon .= '<span class="broadcast"></span>';
						
					if(in_array('osusume', $cal_iconlist[date('Ynj', $print_today)]))
						$display_icon .= '<span class="osusume"></span>';
	
					if(in_array('shinchyaku', $cal_iconlist[date('Ynj', $print_today)]))
						$display_icon .= '<span class="shinchyaku"></span>';
						
					//create flag list for title-date cal_flaglist
					$display_flag = '';
						
					if(in_array('wd', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class=" flag wd"></span>';
					
					if(in_array('eu', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class=" flag eu"></span>';
					
					if(in_array('au', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class=" flag au"></span>';
						
					if(in_array('nz', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class="flag nz"></span>';
	
					if(in_array('uk', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class="flag uk"></span>';
						
					if(in_array('fr', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class="flag fr"></span>';
						
					if(in_array('dk', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class="flag dk"></span>';
						
					if(in_array('de', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class="flag de"></span>';
						
					if(in_array('ca', $cal_flaglist[date('Ynj', $print_today)]))
						$display_flag .= '<span class="flag ca"></span>';
				}
				
				//set class selected day Title-date
				if ( date('Ynj', $print_today) == $_SESSION['para3'].$_SESSION['para4'].$_SESSION['para5'] && $just_one === false)
					$class_selected_title_date = ' selected-title-date';
				else
					$class_selected_title_date = '';
				
				//Display at the top the selected day
				if($lastdate_display == 'empty' && !empty($_SESSION['para6']) && $start == 0  && $just_one === false)
				{
					$print_selected = mktime(0, 0, 0, $_SESSION['para4'], $_SESSION['para5'], $_SESSION['para3']);
					
					print ''.$cal_msg_selected[date('Ynj', $print_selected)].'';
					
					print '<div class="separate-date-bloc"></div>';
					
				}
				
				//display the title-date only if the date are different while loading more data
				if (date('Ynj', $print_today) != $lastdate_display || $lastdate_display == 'empty')
				{
					//check if this is the first data to display
					if(($start == 1 && $lastdate_display == 'empty') || $lastdate_display != 'empty')
					{
						print '<div class="separate-date-bloc"></div>';
					}
					$start = 1;
					
					if($_SESSION['para1'] != 'kouen')
						$titledate_title = 'title="'.$cnt.'"';
					else
						$titledate_title = '';

					print '<h3 class="title-date'.$class_selected_title_date.'" '.$titledate_title.'>'.$display_flag.date('n月j日 ('.$yobi[date('w', $print_today)].')', $print_today).'&nbsp;&nbsp;'.$display_icon;
					if ($just_one === false)
					print '<span class="seminar-count">'.$cal_cnt[date('Ynj', $print_today)].'</span>';
					
					print'</h3>';
				}
				
				print ''.$cal_msg[date('Ynj', $print_today)].'';
			}

		}
		
		if($lastdate_display == 'empty' &&  $cnt > 0)
			print '<div class="separate-date-bloc"></div>';

	
	}
	
	//------------------------------------------------------
	// FUNCTION to count number of seminar
	//------------------------------------------------------
	function count_number_of_seminar($keyword,$date='',$free=0)
	{	
	
		if($date != '')
			$keyword_date = ' AND hiduke = \''.$date.'\'';
		else
			$keyword_date = $date;
			 
		//connect to database
		$db = connexion_database ();

		if($_SESSION['para1'] != 'kouen')
			$rs = $db->query('SELECT count(*) as number FROM event_list WHERE k_use = 1 and free = '.$free.' '.$keyword_date.' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.'');
		else
			$rs = $db->query('SELECT count(*) as number FROM event_list WHERE k_use = 1 and k_desc2 like \'%'.$_SESSION['para2'].'%\' '.$keyword_date.' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY)');
		
		
		$row = $rs->fetch(PDO::FETCH_ASSOC);
		$countnumber=$row['number'];
		return $countnumber;
	}
	
	//------------------------------------------------------
	// FUNCTION get list of flag
	//------------------------------------------------------
	function flag_list_of_the_day($keyword,$date='',$free=0)
	{	
	
		if($date != '')
			$keyword_date = ' AND hiduke = \''.$date.'\'';
		else
			$keyword_date = $date;
			 
		//connect to database
		$db = connexion_database ();
		
		if($_SESSION['para1'] != 'kouen')
			$rs = $db->query('SELECT country_code FROM event_list WHERE k_use = 1 and free = '.$free.' '.$keyword_date.' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.'');		
		else
			$rs = $db->query('SELECT country_code FROM event_list WHERE k_use = 1 and k_desc2 like \'%'.$_SESSION['para2'].'%\' '.$keyword_date.' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY)');

		
		
		$i=0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC))
		{
			$flag_array[$i]=$row['country_code'];
			$i++;
		}
		return $flag_array;
	}

	//------------------------------------------------------
	// FUNCTION get list of icon
	//------------------------------------------------------
	function icon_list_of_the_day($keyword,$date='',$free=0)
	{	
		if($date != '')
			$keyword_date = ' AND hiduke = \''.$date.'\'';
		else
			$keyword_date = $date;
			
		//connect to database
		$db = connexion_database ();

		if($_SESSION['para1'] != 'kouen')
			$rs = $db->query('SELECT indicated_option, broadcasting FROM event_list WHERE k_use = 1 and free = '.$free.' '.$keyword_date.' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY)'.$keyword.'');
		else
			$rs = $db->query('SELECT indicated_option, broadcasting FROM event_list WHERE k_use = 1 and k_desc2 like \'%'.$_SESSION['para2'].'%\' '.$keyword_date.' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY)');

		
		$i=0;
					
		while($row = $rs->fetch(PDO::FETCH_ASSOC))
		{
			//Check the option statut 
		if($row['indicated_option'] == 1)
			{
				$icon_array[$i]='osusume';
			}
			elseif($row['indicated_option'] == 2)
			{
				$icon_array[$i]='shinchyaku';
			}
			else
				$icon_array[$i]='none';
			
			//Check if live or not
			if ($row['broadcasting'] == 1)
			{
				$i++;
				$icon_array[$i]='broadcast';
			}
		
			$i++;
		}
		return $icon_array;
		
	}
?>