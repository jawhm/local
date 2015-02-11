<?php
mb_language("Ja");
mb_internal_encoding("utf8");

require_once('event.class.php');
require_once('ip2locationlite.class.php');


	
	//Set geolocation cookie
	if(!$_COOKIE["geolocation"])
	{
		//Load the class
		$ipLite = new ip2location_lite;
		$ipLite->setKey('04ba8ecc1a53f099cdbb3859d8290d9a9dced56a68f4db46e3231397d1dfa5e6');
		
		$visitorGeolocation = $ipLite->getCity($_SERVER['REMOTE_ADDR']); // test for osaka 125.2.111.125 or $_SERVER['REMOTE_ADDR'] (SENDAI 202.211.5.240 TOYAMA 202.95.177.129)
		
		// if no error
		if ($visitorGeolocation['statusCode'] == 'OK') 
		{
		//if value exist
		if($visitorGeolocation['regionName'] != '-')
		{
			$region = $visitorGeolocation['regionName'];
		}
		else
			$region = 'TOKYO';
		
		}
		else
			$region = 'TOKYO';
		
		setcookie("geolocation", base64_encode($region), time()+60*30); //set cookie for 30minutes
	}
	else
	{
		$region = base64_decode($_COOKIE["geolocation"]);
		//unset($_COOKIE["geolocation"]); 
	}

	//Load the class
	$event_data = new Event;
	
	//get parameter data from url
	$country_to_display = isset($_GET['country']) ? $_GET['country'] : '';//optional
	$number_to_display  = isset($_GET['number']) ? $_GET['number'] : 3; //optional
	$region_to_display  = isset($_GET['place']) ? $_GET['place'] : $region; //optional
	$start_display_from = isset($_GET['from']) ? $_GET['from'] : ''; //optional
	
	//Get result => send param 'place' and 'country' and 'nb to display' and 'nb to start from' and 'set random or not(for 2 weeks data)' eg: 'OSAKA','アメリカ', 2 (country is set EMPTY by default), Empty by default, false by default
	$list_data = $event_data->getData($region_to_display,$country_to_display,$number_to_display,$start_display_from, true);	

?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']);?>/css/cal_module.css" />

<!--[if lte IE 8 ]>
    <link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']);?>/css/cal_module_ie.css" />
<![endif]-->
</head>
<body>
    <div id="vertical_module">
    
        <div id="title_module">
            <div id="left_title_module">
                <?php //display onnly "free seminar" if toyama or sendai exist
                    if($list_data['sendai_toyama_exist'] == 1)
                        echo '無料セミナー';
                    else
                    {
                        if($event_data->place == 'sendai' || $event_data->place == 'toyama')
                            echo '東京の無料セミナー';
                        else
                            echo $event_data->japanese_city.'の無料セミナー';
                    }
                    ?>
            </div>
        </div>
        
        <div id="content_vertical_module">
			<?php 
                
            //Ordering by date 
            function sort_data_by_date(array $original_array, $english_date) 
            {
                $result = array();
                   
                $values = array();
                
                foreach ($original_array as $id => $value)
                {
                    $values[$id] = isset($value[$english_date]) ? $value[$english_date] : '';
                }
                   
                asort($values);
                   
                $i=0;
                foreach ($values as $key => $value)
                {
                    
                    $result[$i] = $original_array[$key];
                    $i++;
                }
                   
                return $result;
            }
    
            $sorted_list_data = sort_data_by_date($list_data, 'english_date');
            
            // loop information: -1 is to not show the row of TOYAMA/SENDAI EXIST in the list 
            for ($i=0; $i<(count($sorted_list_data)-1);$i++)
            {
                $j = $i+1; //to start from 1					
                
                //Cut a part of seminar name if too long
                if(mb_strlen($sorted_list_data[$j]['seminar_name']) > 10)
                {
                     $text = mb_substr($sorted_list_data[$j]['seminar_name'],0,10) . "...";
                }
                else
                    $text = $sorted_list_data[$j]['seminar_name'];
                    
                    
                $url = 'http://www.jawhm.or.jp/seminar/seminar.php?num='.$sorted_list_data[$j]['id'].'#calendar_start';
            ?>
                <!--[if lte IE 8 ]>
                <style type="text/css">						
                    div.event_verticalhover#event_vertical<?php echo $j;?> div.vertical_title_event{
                        color:<?php echo $sorted_list_data[$j]['group_color']; ?>;
                        text-decoration:underline;
                    }
                    
                    div.event_verticalhover#event_vertical<?php echo $j;?> {
                            background:#FFF5F0;
                     }
                </style>
                <![endif]-->
                
                <script type="text/javascript">
                    var sheet = document.createElement('style')
                    sheet.innerHTML = "div.event_verticalhover#event_vertical<?php echo $j;?> div.vertical_title_event{color:<?php echo $sorted_list_data[$j]['group_color']; ?>;text-decoration:underline;}div.event_verticalhover#event_vertical<?php echo $j;?> {background:#FFF5F0;}";
                    document.body.appendChild(sheet);		
                </script>
        
                <div class="event_vertical"  id="event_vertical<?php echo $j; ?>" onMouseOver="this.className='event_verticalhover'; this.style.cursor='pointer';" onMouseOut="this.className='event_vertical';" onClick="window.open('<?php echo $url ?>','_top');">
            
                    <div class="date">
                        <div class="month" style="color:<?php echo $sorted_list_data[$j]['group_color']; ?>;" ><?php echo $sorted_list_data[$j]['month_nb'].'月';?></div>
                        <div class="day" style="background-color:<?php echo $sorted_list_data[$j]['group_color']; ?>;" ><?php echo $sorted_list_data[$j]['day_nb']; ?></div>
                    </div>
                
                    <div class="event_info_vertical">                            
                        <span class="time_event">
                            <?php
                                echo '<strong>'.$sorted_list_data[$j]['start_time'].'~&nbsp;&nbsp;</strong>';
                                
                                //display city name if toyama and sendai exist
                                if($sorted_list_data['sendai_toyama_exist'] == 1)
                                    echo '['.$sorted_list_data[$j]['seminar_place_jp'].']';
                                ?>
                        </span>
                        <div class="module_flag_<?php echo $sorted_list_data[$j]['country_code']; ?>"></div>
                        <div class="vertical_title_event"><?php echo $text; ?></div>
                    </div>
                
                    <?php //display icon if necessary
                        if($sorted_list_data[$j]['indicated_option'] == 1)
                            echo ' <div class="vertical_icon_osusume"> </div>';
                            
                        elseif($sorted_list_data[$j]['indicated_option'] == 2)
                            echo ' <div class="vertical_icon_new"> </div>';
                            
                        elseif($sorted_list_data[$j]['broadcasting'] == 1)
                            echo ' <div class="vertical_icon_broadcast"> </div>';
                    ?>
               </div>
               <?php //display separator while not. last information: -1 is to not show the row of TOYAMA/SENDAI EXIST in the list
                if($j!=(count($sorted_list_data)-1))
                    echo '<div class="separator"></div>';
                    ?>
            <?php
            } ?>
        
            <div id="more">
            <?php
                if($list_data['sendai_toyama_exist'] == 1)
                    $placename = $event_data->place;
                else
                {
                    if($event_data->place == 'sendai' || $event_data->place == 'toyama')
                        $placename = 'tokyo';
                    else
                        $placename = $event_data->place;
                }
                
                $url_more = 'http://www.jawhm.or.jp/seminar/seminar.php?navigation=1&month='.date('n').'&year='.date('Y').'&place_name='.$placename.'&checked_countryname='.$event_data->check_country.'&checked_know=0#calendar_start';
                
                echo '<a href="'.$url_more.'" target="_top" >もっと見る</a>';
            
                ?>
            </div>
        </div>            
    </div>
</body>
</html>