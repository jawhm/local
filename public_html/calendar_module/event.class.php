<?php

// エラー出力しない場合
ini_set( 'display_errors', 0 );

	/**
	 * Define MyClass
	 */
	class Event
	{

		//set variable		
		public $place = '';
		public $check_country = 0;
		public $japanese_city = '東京';
		
		public function __construct(){}
	
		public function __destruct(){}
		
		
		//------------------------------------
		// Function get data in database
		//------------------------------------
		public function getData($where,$country_name='',$display_nb='',$display_start='',$more_than_a_week_random=false,$title_name='',$absolute_cond='') 
		{

			date_default_timezone_set('Asia/Tokyo');
			
			//Get country number for url
			$this->countryNumber($country_name);
					
			//Prepare keywords for sql
			$this->country = $country_name;
			$this->setPlace($where);
			//Set Japanese name of the place
			$this->setPlace_inJapanese($this->place);
			
			if($this->place == 'sendai' || $this->place == 'toyama')
			{
				$keywords = ' (place=\''.$this->place.'\' OR place=\'tokyo\') ';
				
				if(!empty($country_name))
					$keywords .= ' AND (k_title1 like \'%'.$country_name.'%\' OR k_desc1 like \'%'.$country_name.'%\' OR k_desc2 like \'%'.$country_name.'%\' )';
			}
			else
			{
				if ($this->place == 'fukuoka')	{
					$keywords = ' ( place=\''.$this->place.'\' or k_title1 like \'%福岡%\' ) ';	
				}else{
					$keywords = ' place=\''.$this->place.'\'';	
				}
				
				if(!empty($country_name))
					$keywords .= ' AND (k_title1 like \'%'.$country_name.'%\' OR k_desc1 like \'%'.$country_name.'%\' OR k_desc2 like \'%'.$country_name.'%\' )';
			}

			if (!empty($title_name))	{
				$keywords .= ' AND (k_title1 like \'%'.$title_name.'%\')';
			}

			if (!empty($absolute_cond))	{
				$keywords .= ' or (k_title1 like \'%'.$absolute_cond.'%\')';
			}
			
			// Limit to display
			if(!empty($display_nb))
			{
				if(!empty($display_start))
					$limit = 'LIMIT '.$display_start.', '.$display_nb;
				else
					$limit = 'LIMIT '.$display_nb;
			}
			else
				$limit = '';
			
			// Pick Random data between today's week and next week osusume and new
//			if (!empty($absolute_cond))	{
//				$more_keywords ='';
//				$orderby = 'ORDER BY hiduke, starttime, id';
//			}else{
				if($more_than_a_week_random !== false)
				{
					if ($this->place == 'tokyo' || $this->place == 'osaka')	{
						$more_keywords =' AND (indicated_option = 1 OR indicated_option = 2 OR hiduke <= \''.date('Y-m-d', mktime(0, 0, 0, date('n'), (date('j')+14), date('Y'))).'\')';
					}else{
						$more_keywords =' AND (indicated_option = 1 OR indicated_option = 2 OR hiduke <= \''.date('Y-m-d', mktime(0, 0, 0, date('n'), (date('j')+60), date('Y'))).'\')';
					}
					$orderby = 'ORDER BY rand()';
				}
				else
				{
					$more_keywords ='';
					$orderby = 'ORDER BY hiduke, starttime, id';
				}
//			}

			$more_keywords .= ' AND ongoogle = 1 AND hiduke >= \''.date('Y-m-d', mktime(0, 0, 0, date('n'), (date('j')+1), date('Y'))).'\' ';

			//connexion database
			$path_file = '../bin/pdo_mail_list.ini';
			
			
			//search file location
			while(!file_exists($path_file))
			{
				$path_file='../'.$path_file;
			}

			$ini = parse_ini_file($path_file, FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			
			//slq query, 2 coming events, no fullybooked 
			$rs = $db->query('SELECT id, hiduke, year(hiduke) as event_year, month(hiduke) as month_event, day(hiduke) as day_event, date_format(starttime, \'%c月%e日\') as start, date_format(starttime, \'%k:%i\') as time, date_format(starttime, \'%a\') as dayoftheweek, group_color, broadcasting, indicated_option, short_description, seminar_name, country_code, place FROM event_list WHERE  k_use = 1 AND free=0 AND k_stat <> 2 AND booking < pax AND '.$keywords.' '.$more_keywords.' AND hiduke >= \''.date('Y-m-d').'\' GROUP BY hiduke '.$orderby.' '.$limit);
		
			$count_row = 0;
			
			while($row = $rs->fetch(PDO::FETCH_ASSOC))
			{
				$count_row++;
				
				//check if seminar exist for sendai and toyama
				if ($row['place'] == 'sendai' || $row['place'] == 'toyama' )
					$sendai_toyama_exist = 1;
				
				//default color
				if ($row['group_color'] == '')
					$row['group_color'] = 'grey';
								
				$result[$count_row] =array ( 
											'english_date'		=> $row['hiduke'],
											'start_date' 		=> $row['start'],		
											'start_time' 		=> $row['time'],		
											'start_dayoftheweek'=> $row['dayoftheweek'],		
											'seminar_name'		=> $row['seminar_name'],		
											'short_description' => $row['short_description'],		
											'indicated_option' 	=> $row['indicated_option'],	
											'broadcasting' 		=> $row['broadcasting'],		
											'group_color' 		=> $row['group_color'],
											'country_code' 		=> $row['country_code'],
											'year_nb' 			=> $row['event_year'],
											'month_nb' 			=> $row['month_event'],
											'day_nb' 			=> $row['day_event'],
											'seminar_place_jp' 	=> $this->setPlace_inJapanese($row['place']),
											'seminar_place' 	=> $row['place'],
											'id'				=> $row['id']
									)	;
			
			}
			//add exist number
			$result['sendai_toyama_exist'] = $sendai_toyama_exist;
			
			return $result;
		}
	
	
		//------------------------------------
		// Place to display 
		//------------------------------------
		private function countryNumber($country_name)
		{
			switch($country_name)
			{
				case 'オーストラリア':
							return $this->check_country = 2;
					break;
				case 'ニュージーランド':
						 	return $this->check_country = 3;
					break;
				case 'カナダ':
					 		return $this->check_country = 4;
					break;
				case 'イギリス':
						 	return $this->check_country = 5;
					break;
				case 'フランス':
						 	return $this->check_country = 6;
					break;
				case 'ドイツ':
						 	return $this->check_country = 7;
					break;
				case 'アイルランド':
					 		return $this->check_country = 7;
					break;
				case 'デンマーク':
					 		return $this->check_country = 7;
					break;
				case '台湾':
						 	return $this->check_country = 7;
					break;
				case '韓国':
					 		return $this->check_country = 7;
					break;
				case '香港':
						 	return $this->check_country = 7;
					break;
				default:
							return $this->check_country = 1;					
				
			}
		}

		
		
		//------------------------------------
		// Place to display 
		//------------------------------------
		private function setPlace_inJapanese($city)
		{
			switch($city)
			{
				case 'tokyo':
							return $this->japanese_city = '東京';
					break;
				case 'osaka':
						 	return $this->japanese_city = '大阪';
					break;
				case 'fukuoka':
					 		return $this->japanese_city = '福岡';
					break;
				case 'okinawa':
						 	return $this->japanese_city = '沖縄';
					break;
				case 'toyama':
						 	return $this->japanese_city = '富山';
					break;
				case 'nagoya':
						 	return $this->japanese_city = '名古屋';
					break;
				case 'sendai':
						 	return $this->japanese_city = '仙台'; 
					break;
				case 'event':
						 	return $this->japanese_city = 'イベント'; 
					break;
					
			}
		}

		//------------------------------------
		// Place to display 
		//------------------------------------
		private function setPlace($area)
		{
			switch($area)
			{
				case 'FUKUSHIA':
							return $this->place = 'tokyo';
					break;
				case 'TOCHIGI':
						 	return $this->place = 'tokyo';
					break;
				case 'GUNMA':
					 		return $this->place = 'tokyo';
					break;
				case 'SAITAMA':
						 	return $this->place = 'tokyo';
					break;
				case 'IBATAKI':
						 	return $this->place = 'tokyo';
					break;
				case 'YAMANASHI':
						 	return $this->place = 'tokyo';
					break;
				case 'TOKYO':
					 		return $this->place = 'tokyo';
					break;
				case 'CHIBA':
					 		return $this->place = 'tokyo';
					break;
				case 'KANAGAWA':
						 	return $this->place = 'tokyo';
					break;
				case 'NAGANO':
					 		return $this->place = 'tokyo';
					break;
				case 'SHIZUOKA':
						 	return $this->place = 'tokyo';
					break;
				case 'SHIGA':
							return $this->place = 'osaka';
					break;
				case 'KYOTO':
							return $this->place = 'osaka';
					break;
				case 'OSAKA':
							return $this->place = 'osaka';
					break;
				case 'NARA':
							return $this->place = 'osaka';
					break;
				case 'WAKAYAMA':
							return $this->place = 'osaka';
					break;
				case 'HYOGO':
							return $this->place = 'osaka';
					break;
				case 'OKAYAMA':
							return $this->place = 'osaka';
					break;
				case 'TOTTORI':
							return $this->place = 'osaka';
					break;
				case 'FUKUOKA':
							return $this->place = 'fukuoka';
					break;
				case 'OITA':
							return $this->place = 'fukuoka';
					break;
				case 'SAGA':
							return $this->place = 'fukuoka';
					break;
				case 'NAGASAKI':
							return $this->place = 'fukuoka';
					break;
				case 'KUMAMOTO':
						 	return $this->place = 'fukuoka';
					break;
				case 'MIYAZAKI':
						 	return $this->place = 'fukuoka';
					break;
				case 'KAGOSHIMA':
						 	return $this->place = 'fukuoka';
					break;
				case 'OKINAWA':
						 	return $this->place = 'okinawa';
					break;
				case 'MIYAGI':
					 		return $this->place = 'sendai';
					break;
				case 'NAGOYA':
							return $this->place = 'nagoya';
					break;
				case 'TOYAMA':
							return $this->place = 'nagoya';
					break;
				case 'ISHIKAWA':
							return $this->place = 'nagoya';
					break;
				case 'AICHI':
							return $this->place = 'nagoya';
					break;
				case 'GIFU':
							return $this->place = 'nagoya';
					break;
				case 'MIE':
							return $this->place = 'nagoya';
					break;
				case 'FUKUI':
							return $this->place = 'nagoya';
					break;
				default:
							return $this->place = 'tokyo';					
				
			}

		}
		
	}
?>