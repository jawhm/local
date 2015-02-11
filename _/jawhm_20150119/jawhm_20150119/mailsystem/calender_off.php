<?php
//search the day of the week and add one day in case of the sunday
function check_day_of_the_week($year,$month,$i)
{
	$day = date('w', mktime(0, 0, 0, $month, $i, $year));
	
	if($day == 0)
	{
		if($month == 5 && $i == 3) //may 3days off
			$i = $i+3;
		elseif($month == 5 && $i == 4) //may 3days off
			$i = $i+2;
		else
			$i = $i+1;
	}
	
	$date_off = $year.'-'.$month.'-'.$i;
	
	return $date_off;
}

//search the day of a given monday of the month
function specific_monday_of_the_month($number,$year,$month)
{
	$monday = 0;
	
	for($i=1;$i<=30;$i++)
	{
		$day = date('w', mktime(0, 0, 0, $month, $i, $year));
		
		if($day == 1)
		{
			$monday++;
			
			if($monday == $number)
			{
				$second_monday = $i;
			}
		}

	}
	
	$date_off = $year.'-'.$month.'-'.$second_monday;
	
	return $date_off;
}

//Vernal Equinox 春分の日 around march 20th
function vernal_equinox($year)
{
	
	$equinox_days = array(  '2012' => 20,
							'2013' => 20,
							'2014' => 21,
							'2015' => 21,
							'2016' => 20,
							'2017' => 20,
							'2018' => 21,
							'2019' => 21,
							'2020' => 20,
							'2021' => 20,
							'2022' => 21,
							'2023' => 21,
							'2024' => 20,
							'2025' => 20,
							'2026' => 20,
							'2027' => 21,
							'2028' => 20,
							'2029' => 20,
							'2030' => 20	
					);
	
	$date_off = check_day_of_the_week($year,3,$equinox_days[$year]);
	
	return $date_off;
}

//Autumnal Equinox 春分の日 around september 23rd
function autumnal_equinox($year,$day_check = true)
{
	
	$equinox_days = array(  '2012' => 22,
							'2013' => 23,
							'2014' => 23,
							'2015' => 23,
							'2016' => 22,
							'2017' => 23,
							'2018' => 23,
							'2019' => 23,
							'2020' => 22,
							'2021' => 23,
							'2022' => 23,
							'2023' => 23,
							'2024' => 22,
							'2025' => 23,
							'2026' => 23,
							'2027' => 23,
							'2028' => 22,
							'2029' => 23,
							'2030' => 23	
					);
	
	if($day_check)
		$date_off = check_day_of_the_week($year,9,$equinox_days[$year]);
	else
		$date_off = $year.'-9-'.$equinox_days[$year];
	
	return $date_off;
}

//---------------------------------------------------
//public holidays
//---------------------------------------------------
function publicholidays ($year,$month,$i)
{
	$public_holidays = array();

	$public_holidays = array(	check_day_of_the_week($year, 1, 1), // 元日
						specific_monday_of_the_month(2,$year,1), // 成人の日
						check_day_of_the_week($year, 2, 11), // 建国記念の日
						vernal_equinox($year), //　春分の日
						check_day_of_the_week($year, 4, 29), // 昭和の日
						check_day_of_the_week($year, 5, 3), // 憲法記念日
						check_day_of_the_week($year, 5, 4), // みどりの日
						check_day_of_the_week($year, 5, 5), // こどもの日
						specific_monday_of_the_month(3,$year,7), // 海の日
						specific_monday_of_the_month(3,$year,9), // 敬老の日
						autumnal_equinox($year), //　春分の日
						specific_monday_of_the_month(2,$year,10), // 体育の日
						check_day_of_the_week($year, 11, 3), // 文化の日
						check_day_of_the_week($year, 11, 23), // 勤労感謝の日
						check_day_of_the_week($year, 12, 23) // 天皇誕生日
					);

	//extra day off? if two days off are separate by working day in september
	$sept_3rd_monday = $public_holidays[9];
	list($sept_3rd_monday_year,$sept_3rd_monday_month,$sept_3rd_monday_day) = explode('-', $sept_3rd_monday);
	 
	$autumnal_equinox = autumnal_equinox($year, false);
	list($autumnal_equinox_year,$autumnal_equinox_month,$autumnal_equinox_day) = explode('-', $autumnal_equinox);
	
	$autumnal_equinox_day_of_the_week = date('w', mktime(0, 0, 0, $autumnal_equinox_month, $autumnal_equinox_day, $autumnal_equinox_year));
	
	
	if(($autumnal_equinox_day - $sept_3rd_monday_day) == 2 && $autumnal_equinox_day_of_the_week > 0 && $autumnal_equinox_day_of_the_week < 6)
	{
		$public_holidays[15] = $year.'-'.$autumnal_equinox_month.'-'.($autumnal_equinox_day-1);
	
	}
	
	//echo '<pre>';print_r($public_holidays);echo '</pre>';
	
	//set days off on calendar output
	if(in_array($year.'-'.$month.'-'.$i, $public_holidays))
		return true; 	
	else
		return false;	
}
