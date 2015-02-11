<?php
if(isset($_POST['isoCode']))
{
	require_once ('class-country.php');
	
	$country = new Country($_POST['isoCode']);
	

	$cities = array();

	$i=1;

	foreach ($_POST['cities'] as $value) {
	 	
	 	
	 	$city =  $country->weather($value, true);

		$cities[$i] = array(
				'icon' => $city->icon,
				'temperature' => $city->temperature->now,
				'nameJP' => $city->population->nameJP,
				'name' => $city->name,
				'date' => $city->date,
				'description' => $city->description,
				'population' => $city->population->number,
				'offset' => $city->offset[0]	
				);
		$i++;
	} 

	 echo json_encode($cities);
}
?>
