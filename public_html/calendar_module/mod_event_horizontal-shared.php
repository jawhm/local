<?php
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
		
		setcookie("geolocation", base64_encode($region), time()+60*30); //set cookie for 30 minutes
	}
	else
	{
		$region = base64_decode($_COOKIE["geolocation"]);
		//unset($_COOKIE["geolocation"]); 
	}

	//Load the class
	$cal_data = new Event;
	
	//get parameter data from url
	$country_to_display = isset($_GET['country']) ? $_GET['country'] : '';//optional
	$number_to_display  = isset($_GET['number']) ? $_GET['number'] : 2; //optional
	$region_to_display  = isset($_GET['place']) ? $_GET['place'] : $region; //optional
	$start_display_from = isset($_GET['from']) ? $_GET['from'] : ''; //optional

	//Get result => send param 'place' and 'country' and 'nb to display' and 'display start from' eg: 'OSAKA','オーストラリア', 2 (country is set EMPTY by default),''(empty allow to see from the beginning. This parametre is useful while using the module several times on the same page
	$list_event = $cal_data->getData($region_to_display,$country_to_display,$number_to_display,$start_display_from);
	
?>
<html>
<head>
<link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']);?>/css/cal_module.css" />

<!--[if lte IE 8 ]>
    <link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']);?>/css/cal_module_ie.css" />
<![endif]-->
</head>
<body>
<?php
//check if we have data an display, 
//the first data of the array being a variable to check the city, we display array bigger than 1
if(count($list_event)>1)
{
?>
	<div class="main_module_content">
	<?php 
        // loop information: -1 is to not show the row "EXIST"of TOYAMA/SENDAI in the list 
        //use of the variable $start_display_from to avoid having same id Issues while showing several calendars on the same page
        if($start_display_from == '')
            $start_display_from = 0;
        for ($i=(0+$start_display_from); $i<(count($list_event)-1+$start_display_from);$i++)
        {
            $j = $i+1- $start_display_from; //to start from 1
            
            //check number type
            if($j%2) 
                $type_nb = 'odd'; 
            else 
                $type_nb = 'even';
            
            $url = 'http://www.jawhm.or.jp/seminar/seminar.php?num='.$list_event[$j]['id'].'#calendar_start';


            ?>
            <!--[if lte IE 8 ]>
            <style type="text/css">
                /* Color change css */
                #event<?php echo $i;?> .date_time {
                    background-color: <?php echo $list_event[$j]['group_color']; ?>;
                    border:2px solid <?php echo $list_event[$j]['group_color']; ?>;
                }
                
                #event<?php echo $i;?>:hover div.date_time {
                    border:2px solid <?php echo $list_event[$j]['group_color']; ?>;
                    background-color:white;
                }
                
                /* Color change css for IE */
                div.eventhover#event<?php echo $i;?> div.date_time {
                    border:2px solid <?php echo $list_event[$j]['group_color']; ?>;
                    background-color:white;
                    color:#5F5F5F;
                }
                
            </style>
            <![endif]-->
            
            <script type="text/javascript">
                var sheet = document.createElement('style')
                sheet.innerHTML = "#event<?php echo $i;?> .date_time {background-color: <?php echo $list_event[$j]['group_color']; ?>;border:2px solid <?php echo $list_event[$j]['group_color']; ?>;}#event<?php echo $i;?>:hover div.date_time {border:2px solid <?php echo $list_event[$j]['group_color']; ?>;background-color:white;}div.eventhover#event<?php echo $i;?> div.date_time {border:2px solid <?php echo $list_event[$j]['group_color']; ?>;background-color:white;color:#5F5F5F;}";
                document.body.appendChild(sheet);		
            </script>

            
            <!--[if lte IE 8 ]>
                <div class="event"  id="event<?php echo $i; ?>" <?php if($type_nb == 'odd') echo 'style="margin-right:0px;"'; ?> onmouseover="this.className='eventhover';" onmouseout="this.className='event';" onClick="window.open('<?php echo $url ?>','_self');">
            <![endif]-->

            <!--[if (gte IE 9) | !(IE) ]><!-->
            <div class="event" id="event<?php echo $i; ?>" <?php if($type_nb == 'odd') echo 'style="margin-right:0px;"'; ?> onClick="window.open('<?php echo $url ?>','_top');">
            <!--<![endif]-->
            
                <div class="date_time"><?php echo $list_event[$j]['start_date'].'<br />'.$list_event[$j]['start_time'].'<br />'.$list_event[$j]['start_dayoftheweek'];  ?></div>
                <div class="event_info">
                    <span class="title_event"><?php echo '['.$list_event[$j]['seminar_place_jp'].']&nbsp;&nbsp;'. $list_event[$j]['seminar_name']; ?></span>
                    <span class="description_event"><?php echo $list_event[$j]['short_description']; ?></span>
                </div>
                
                <?php //display icon if necessary
                    if($list_event[$j]['indicated_option'] == 1)
                        echo ' <div class="icon_osusume"> </div>';
                        
                    elseif($list_event[$j]['indicated_option'] == 2)
                        echo ' <div class="icon_new"> </div>';
                        
                    elseif($list_event[$j]['broadcasting'] == 1)
                        echo ' <div class="icon_broadcast"> </div>';
                ?>
           </div>
    <?php
        }
        
        ?>            
   </div>
<?php
}//end if content exist  ?>
</body>
</html>



