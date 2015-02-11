<?php

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
		$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
			
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		
		return $db;
	}
	
	
	//---------------------------------------------------
	//Get list of event , return array
	//---------------------------------------------------
	function get_list($para='') 
	{
		// イベント読み込み
		$cal = array();
	
		$evt_ymd   = array();
		$evt_title = array();
		$evt_desc  = array();
		$evt_img   = array();
		$evt_btn   = array();
		$evt_id	   = array();
		$evt_date  = array();
		$evt_option= array();
		$evt_flag  = array();
		$evt_color = array();
		$$evt_bstyle = array();
		try {
			
			$db = connexion_database ('kouen');
			
			$db->query('SET CHARACTER SET utf8');
			$sql  = 'SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, group_color, country_code, broadcasting, indicated_option FROM event_list WHERE ';
			if ($para <> '')	{
				$sql .= ' k_desc2 like "%'.$para.'%" and ';
			}
			$sql .= 'k_use = 1 and hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) ORDER BY hiduke, starttime, id';
			$rs = $db->query($sql);
			$cnt = 0;
			
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$cnt++;
				$year	= $row['yy'];
				$month  = $row['mm'];
				$day	= $row['dd'];
	
				//set place
				$place = translate_city ($row['place']);
				$kaijo = $place.'会場';
				
				if($row['place'] == 'event')
					$kaijo = '会場はセミナー詳細でお確かめ下さい';
	
				// イベント
				$evt_id[] = $row['id'];
				$evt_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$start = $row['start'];
				$start	= mb_ereg_replace('Mon', '月', $start);
				$start	= mb_ereg_replace('Tue', '火', $start);
				$start	= mb_ereg_replace('Wed', '水', $start);
				$start	= mb_ereg_replace('Thu', '木', $start);
				$start	= mb_ereg_replace('Fri', '金', $start);
				$start	= mb_ereg_replace('Sat', '土', $start);
				$start	= mb_ereg_replace('Sun', '日', $start);
				$evt_date[] = $start.'&nbsp;～&nbsp;&nbsp;'.$kaijo;
				$evt_title[] = $row['k_title1'];
				$evt_desc[]  = $row['k_desc1'];
				
				if ($row['k_stat'] == 1)	
				{
					if ($row['booking'] >= $row['pax'])	
						$evt_img[]   	= '<img src="../images/semi_full.jpg">';
					else
						$evt_img[]   	= '<img src="../images/semi_now.jpg">';
				}
				elseif ($row['k_stat'] == 2)	
					$evt_img[]   	= '<img src="../images/semi_full.jpg">';
				else
				{
					if ($row['booking'] >= $row['pax'])	
						$evt_img[]   	= '<img src="../images/semi_full.jpg">';
					else
					{
						if ($row['booking'] >= $row['pax'] / 2)	
							$evt_img[]   	= '<img src="../images/semi_now.jpg">';
						else
							$evt_img[]	= '';
					}
				}
				
				//Check if flag exists, create a listing
				if ($row['country_code'] == '')
					$evt_flag[] = '';
				else
					$evt_flag[] = '<span class="flag_information" id="flag_'.strtolower($row['country_code']).'" ></span>';
					
				
				
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
					$borderstyle = 'dashed';
					$color = 'red';
					
					$evt_option[] = '<div class="title_line"><span class="icon_info'.$indication.'"></span></span></div>';			
				}
				else
				{
					$borderstyle = 'solid';
					
					$evt_option[] = '<div class="title_line"><span class="icon_info'.$icon_live.'"></span><span class="icon_info'.$indication.'"></span></div>';
				}
						
			
				$evt_color[] = $color;
				$evt_bstyle[]= $borderstyle;
				
				if ($row['free'] == 1)
					$evt_btn[]	= '<div style="padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定イベントです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a></div>';
				else
				{
					if ($row['k_stat'] == 2)
						$evt_btn[]	= '';
					else
					{
						if ($row['booking'] >= $row['pax'])
							$evt_btn[]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="['.$place.'K]'.$start.' '.$row['k_title1'].'" uid="'.$row['id'].'">';
						else
							$evt_btn[]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="['.$place.'K]'.$start.' '.$row['k_title1'].'" uid="'.$row['id'].'">';
					}
				}
				
				$cal[$year.$month.$day] .= '<img src="../images/sa04.jpg">';
					
			}
			
			$data = array();
			
			if($cnt == 0)
			{
				$data['nodata'] = '
				<div style="border: 2px dotted deepskyblue; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
                    現在、詳細な情報がありません。<br/>
                    準備ができ次第、こちらのページでご案内いたします。<br/>
                    お手数をおかけいたしますが、今しばらくお待ちください。<br/>
                    <a href="../event.html">すべての会場の情報を見る場合はこちら</a><br/>
				</div><br />';
				
			}
			else
			{
				$data['evt_ymd'] 	= $evt_ymd;
				$data['evt_title'] 	= $evt_title;
				$data['evt_desc'] 	= $evt_desc;
				$data['evt_img'] 	= $evt_img;
				$data['evt_btn'] 	= $evt_btn;
				$data['evt_id'] 	= $evt_id;
				$data['evt_date'] 	= $evt_date;
				$data['evt_option'] = $evt_option;
				$data['evt_flag']	= $evt_flag;
				$data['evt_color']	= $evt_color;
				$data['evt_bstyle']	= $evt_bstyle;
				$data['nodata']	    = '';
			}
			
			return $data;
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	//---------------------------------------------------
	//display list of event , get array
	//---------------------------------------------------
	function display_list($data)
	{
		for ($idx=0; $idx<count($data['evt_title']); $idx++)	
		{
			print '<div style="height:20px;" id="'.$data['evt_ymd'][$idx].'"></div>';
			print '<div style="width:620px; margin:7px 0 0 0; padding-left:15px; float:right; font-size:11pt; color:navy; border-left:2px '.$data['evt_bstyle'][$idx].' '.$data['evt_color'][$idx].'; border-bottom:1px '.$data['evt_bstyle'][$idx].' '.$data['evt_color'][$idx].';">';
			
			if ($data['evt_ymd'][$idx] < date('Ymd'))	
			{
				print '終了しました'.$data['evt_option'][$idx].' <s>'.$data['evt_title'][$idx].'</s>';
			}
			else
			{
				print $data['evt_btn'][$idx].'<span style="margin-left:50px;">'.$data['evt_flag'][$idx].$data['evt_date'][$idx].$data['evt_option'][$idx].'</span><div class="title_line" style="margin-left:105px;">'.$data['evt_title'][$idx].'</div>';
			}
			print '</div>';

			print '<div>';
			//print '<div class="open" style="font-size:9pt; font-weight:bold; clear:both; text-align:center; color: orange; cursor:pointer; margin: 6px 0 10px 10px;">セミナー詳細はココをClick!!</div>';
			print '<div class="det" style="margin:12px 0 10px 20px; float:right; padding: 5px 0 13px 12px; display:block; border-left:1px dotted '.$data['evt_color'][$idx].';">';
			print '<table><tr><td>'.$data['evt_img'][$idx].'</td>';
			print '<td><p>'.nl2br($data['evt_desc'][$idx]).'</p></td></tr></table>';
			print '</div>';
			print '<div style="clear:both;width:100%;"></div>';
			print '</div>';

		}
		
		//message if no data;
		print $data['nodata'];

	}
	
?>