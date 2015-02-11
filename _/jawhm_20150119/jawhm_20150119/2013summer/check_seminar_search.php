<?php

//ini_set( "display_errors", "On");

require_once('jp-holiday.php');
include ('include/check_function.php');
include ('include/where_condition.php');


	session_start();

	mb_language("Ja");
	mb_internal_encoding("utf8");
	
	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];
	
	//Get the selected place's name (tokyo,osaka...)
	//Display on the title of the calendar
	if(isset($_POST['place-name']))
		$place_name = $_POST['place-name'];
	elseif(isset($_GET['navigation']))
		$place_name = $_GET['place_name'];
	elseif($no_cookie == 0)
	{
		$cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));
		$place_name = $cookies['place_name'];
	}
	elseif(isset($num))
		$place_name = $selected_day_place;
	else
		$place_name = 'tokyo'; //selected at first
				
		
	// translate name in japanese
	$placename_in_japanese = translate_city($place_name);


	// 状態確認
	if ($mem_id <> '')	
	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
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
?>

<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
	});
});

</script>
<?php
	date_default_timezone_set('Asia/Tokyo');

	$where_country = ' ( 1=0';
	$where_know = ' ( 1=0';

	// イベント読み込み
	$cal = array();

	$tyo_ymd   = array();
	$tyo_title = array();
	$tyo_desc  = array();
	$tyo_img   = array();
	$tyo_btn   = array();
	$tyo_id	   = array();

	try {
		// connect to database
		$db = connexion_database ();
		
		// パラメータ確認
		$nohit = true;
		$number = 0; // set variable to 0
		
		//variable to manage the selected countryname varibale and the 'know' variable
		if(isset($_GET['checked_countryname']))
		{
			$checked_countryname = secure($_GET['checked_countryname']);
			$checked_know = secure($_GET['checked_know']);
		}
		else
		{
			$checked_countryname = $number;
			$checked_know = $number;
		}
		
		// FIRST ARRIVE ON PAGE, START BY TOKYO
		//-------------------------------------
		if ($nohit)	
		{
			$where_place = '(place = \'tokyo\' or k_desc2 like \'%tokyo%\') '; 
			$yy = date('Y');
			$mm = date('n');
		}
		
		
		// USE COOKIE WHILE SET
		//--------------------------------
		if($no_cookie == 0)
		{
			$cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));
			
			//Check for more event
			//use variable to search seminar
			if($cookies['place_name']=='fukuoka' || $cookies['place_name']=='okinawa')
				$where_place = '(place = \''.$cookies['place_name'].'\' or  k_title1 like \'%'.translate_city($cookies['place_name']).'%\' or k_desc2 like \'%'.$cookies['place_name'].'%\') ';
			else
				$where_place = '(place = \''.$cookies['place_name'].'\' or k_desc2 like \'%'.$cookies['place_name'].'%\' ) ';
			
			//$where_country .= where_country($cookies['checked_countryname']);
			
			//$where_know .= where_know($cookies['checked_know']);
			
			$yy = date('Y');
			$mm = date('n');
		}
		
		// USE ID/NUM DATE when we come from calendar module or banner id
		if(isset($num))
		{
			if($selected_day_place=='fukuoka' || $selected_day_place=='okinawa')
				$where_place = '(place = \''.$selected_day_place.'\' or  k_title1 like \'%'.translate_city($selected_day_place).'%\' or k_desc2 like \'%'.$selected_day_place.'%\' ) ';
			else
				$where_place = '(place = \''.$selected_day_place.'\' or k_desc2 like \'%'.$selected_day_place.'%\' ) ';

			$yy = $yyy;
			$mm = $mmm;
		}

		
		// USE POST DATA WHILE SENT
		//---------------------------------
		if(isset($_POST['place-name']))
		{
			//start using_navigation bar ?
			$navigation_used = $_POST['navigation_used'];
			//click on calendar module ?
			$selected_day = $_POST['selected_day'];
			
			foreach($_POST as $key => $val)	
			{
				$number ++;
				
				//manage country name selected by making a list
				if (!empty($_POST['country-'.$number]))
					$checked_countryname .= ','.$number;
				
				//manage 'know' variable selected by making a list
				if (!empty($_POST['know-'.$number]))
					$checked_know .= ','.$number;
	
				if (mb_substr($key, 0, 5) == 'place')	
				{
					if($val=='fukuoka' || $val=='okinawa')
						$where_place = '(place = \''.$val.'\' or  k_title1 like \'%'.translate_city($val).'%\' or k_desc2 like \'%'.$val.'%\' ) ';
					else
						$where_place = '(place = \''.$val.'\' or k_desc2 like \'%'.$val.'%\' ) ';
						
			
					$nohit = false;
				}
							
				if (mb_substr($key, 0, 7) == 'country')
					$where_country .= where_country($val);
				
				if (mb_substr($key, 0, 4) == 'know')	
					$where_know .= where_know($val);					
				
			}
			
			$yy = $_POST['year_date'];
			$mm = $_POST['month_date'];
		}
					
		// SET COOKIE WITH DATA SENT
		//--------------------------------------------------------------
		if($no_cookie == 1)
		{
			$array_cookie = array (	'place_name' 			=> $place_name,
									'checked_countryname' 	=> $checked_countryname,
									'checked_know'			=> $checked_know,
									'date'					=> date('Y-n-j')
							);	
				
				 
			$data_cookie = base64_encode(serialize($array_cookie));
			
			setcookie("seminar_choice", $data_cookie, time()+60*60*24*30); //set cookie for 30 jours
			
			$cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));			
			
		}
		elseif($no_cookie == 0)
		{
			$cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));
			$date_cookie = $cookies['date'];
			
			
			$number_of_days_forward = 30;
					
			$cookie_date_days_added = date('Y-n-j', mktime(0, 0, 0, date('n'), (date('j')+$number_of_days_forward), date('Y')));
			
			
			//if use cookie at first
			if(empty($_POST['place-name']) && empty($_GET['navigation']))
			{
				//keep the same data for cookie when use cookie to display
				$array_cookie = array (	'place_name' 			=>  $cookies['place_name'],
										'checked_countryname' 	=>  $cookies['checked_countryname'],
										'checked_know'			=>  $cookies['checked_know'],
										'date'					=>  $cookie_date_days_added
								);
								
				//set parameters to able to use navigation with cookie data
				$place_name = $cookies['place_name'];
				//$checked_countryname = $cookies['checked_countryname'];
				//$checked_know = $cookies['checked_know'];
			}
			else
			{
				//set new data for cookie
				$array_cookie = array (	'place_name' 			=> $place_name,
										'checked_countryname' 	=> $checked_countryname,
										'checked_know'			=> $checked_know,
										'date'					=> $cookie_date_days_added
								);
			}
			
			$data_cookie = base64_encode(serialize($array_cookie));
			
			setcookie("seminar_choice", $data_cookie, time()+3600*24*30); //set cookie for 30 jours
			
		}
			
		// USE GET DATA during month navigation, get the right variable
		//-----------------------------------------------------
		if(isset($_GET['navigation']))
		{
			$navigation = secure($_GET['navigation']);
			$navigation_month = secure($_GET['month']);
			$navigation_year = secure($_GET['year']);
			$place_name = secure($_GET['place_name']);

			//only use while clicking on an event of the calendar module
			$selected_day = secure($_GET['day']);
			
			//$navigation_keywords = secure($_GET['key']);

			$yy = $navigation_year;
			$mm = $navigation_month;
			
			
			// Create the keywords for the sql query //
			///////////////////////////////////////////
	
			if($place_name=='fukuoka' || $place_name=='okinawa')
				$where_place = '(place = \''.$place_name.'\' or  k_title1 like \'%'.translate_city($place_name).'%\' or k_desc2 like \'%'.$place_name.'%\' ) ';
			else
				$where_place = '(place = \''.$place_name.'\' or k_desc2 like \'%'.$place_name.'%\' ) ';
			
			$where_country .= where_country($checked_countryname);
			
			$where_know .=where_know($checked_know);		
		}
		
		$where_know .= ' ) ';
		$where_country .= ' ) ';
		
		
		//create keyword
		$keyword = '';

		if ($where_place != '')
			$keyword .= ' and '.$where_place;

		if ($where_country != ' ( 1=0 ) ')
			$keyword .= ' and '.$where_country;
		
		if ($where_know != ' ( 1=0 ) ')
			$keyword .= ' and '.$where_know;

		//SQL QUERY
		$rs = $db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, group_color, broadcasting, indicated_option, country_code, short_description, seminar_name FROM event_list WHERE ( k_use = 1 or preuse = 1 ) '.$keyword.' ORDER BY hiduke, starttime, id');
		
		
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
//			$start	= mb_ereg_replace('Mon', '月', $start);
//			$start	= mb_ereg_replace('Tue', '火', $start);
//			$start	= mb_ereg_replace('Wed', '水', $start);
//			$start	= mb_ereg_replace('Thu', '木', $start);
//			$start	= mb_ereg_replace('Fri', '金', $start);
//			$start	= mb_ereg_replace('Sat', '土', $start);
//			$start	= mb_ereg_replace('Sun', '日', $start);
			
			$title	= $start.'&nbsp;'.$row['k_title1'];

	
			//Check if flag exists, create a listing
			if ($row['country_code'] == '')
				$flag = '';
			else
				$flag = '<span class="flag_information flag_'.strtolower($row['country_code']).'" ></span>';
				
			
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
				//Remove images tag 
				$noimage_title = preg_replace("/<img[^>]+\>/i", "", $title);
				
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
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).'C]'.$noimage_title.'" uid="'.$row['id'].'">';
							else
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).'C]'.$noimage_title.'" uid="'.$row['id'].'">';
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
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).'C]'.$noimage_title.'" uid="'.$row['id'].'">';
						else
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" name="['.translate_city($row['place']).'C]'.$noimage_title.'" uid="'.$row['id'].'">';
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
				$c_open = '<div class="open open_only">セミナー詳細はココをClick!!</div>';

			//add class for selected day in the list
			if($row['id']==$num)
				$selected_day_in_list ='selected_day_in_list';
			else
				$selected_day_in_list ='';

			$cal[$year.'-'.$month.'-'.$day] .= '<img src="../images/sa05.jpg">';
			$c_msg  = '<tr class="'.$selected_day_in_list.'"><td nowrap style="vertical-align:top;" colspan="3"><div class="square_color" style="background-color:'.$color.'; '.$bdcolor.'">&nbsp;</div><span class="starttime">'.$row['starttime'].'～ </span>';
			
			if($row['place'] == 'event')
				$c_msg  .= translate_city($row['place']);
			else
				$c_msg  .= '<a target="_blank" href="../event/map/?p='.$row['place'].'">'.translate_city($row['place']).'会場</a>';
			
			$c_msg .= $title_line.'</td></tr><tr class="'.$selected_day_in_list.'"><td colspan="4">';
			$c_msg .= '<div class="c_btn">'.$c_btn.'</div>'.$c_img.$c_open;
			$c_msg .= '<div class="det" style="border-color:'.$color.';">'.$c_title.nl2br($c_desc).'</div></td></tr>';
			$cal_msg[$year.'-'.$month.'-'.$day] .= $c_msg;

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>

<?php
	$nb_seminar = count_number_of_seminar($yy,$mm,$keyword,$navigation_used);

	if ($cnt == 0 || $nb_seminar == 0)	{
		print '<div style="margin:40px 0 40px 0; padding: 10px 0 10px 50px; border:3px red dotted; color:red; font-size:14pt; font-weight:bold;">該当するセミナーがありません。検索条件を変更してください。</div>';
	}else{
		print '<div style="font-size:12pt; margin-left:40px;">'.$nb_seminar.'件のセミナーがあります。</div>';
	}


?>
<!--
<center>
<table>
	<tr>
	<td style="vertical-align:top;">-->
<?php
	//Display calendar
	calender_show($yy,$mm,$placename_in_japanese, $place_name, $keyword, $checked_countryname, $checked_know, $navigation_used, $selected_day);
	

?>
	<!--</td>
	<td width="10px">&nbsp;</td>
	<td style="vertical-align:top;">
<?php
	/*
	//Next calendar
	
	$mm++;
	if ($mm > 12)	{
		$mm = 1;
		$yy++;
	}
	calender_show($yy,$mm);
	
	*/

?>
	</td>
	</tr>
</table>-->
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
<div class="orange-solid">
	<p>【カレンダー上のアイコンの意味】<br/><br/></p>
	<span style="margin-left:50px;"><img src="../css/images/au.png" alt="Australian Flag" />&nbsp;<img src="../css/images/ca.png" alt="Canadian Flag" />&nbsp;<img src="../css/images/uk.png" alt="Union Jack" />&nbsp;&nbsp;各国向けのセミナーです</span>
	<span style="margin-left:100px;"><img src="../css/images/wd.png" alt="World" />&nbsp;&nbsp;英語圏の国セミナーです</span>
	<span style="margin-left:100px;"><img src="../css/images/full.png" alt="fullybooked" />&nbsp;&nbsp;予約が満席のセミナーです</span><br/><br/>
	<span style="margin-left:50px;"><img src="../css/images/camera.png" alt="camera" />&nbsp;&nbsp;中継対象セミナー（メンバー登録された方がオンラインでご覧いただけます）</span>
	<span style="margin-left:180px;"><img src="../css/images/hoshi.png" alt="osusume" />&nbsp;&nbsp;おススメのセミナーです</span><br/><br/>
</div>
<span style="font-size:11pt;">
	<a href="../event.html">その他のイベントはこちらからどうぞ</a>
</span>

<!--</center>-->

<div class="navy-dotted">
無料セミナーのご予約は、各セミナー日程に表示された「予約」ボタンをご利用ください。<br/>
各セミナーへのご質問は toiawase@jawhm.or.jp　にメールをお願いいたします。<br/>
なお、当日のセミナーのご予約は、03-6304-5858までご連絡ください。<br/>
</div>

<?php	
		echo '<div id="list_calendar_display">';
		
			calender_list($yy,$mm,$place_name);
			
		echo '</div>';
		
?>