<?php
require_once('ip2locationlite.class.php');

	if(isset($_POST['ipaddress']) && !empty($_POST['ipaddress']))
	{
		$ipaddress = $_POST['ipaddress'];
		$title = "<strong>Location details for => <em>".$ipaddress."</em></strong><br />\n";	
	}
	else
	{
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$title = "<strong>Your location details</strong><br />\n";	
	}
 
	//Load the class
	$ipLite = new ip2location_lite;
	$ipLite->setKey('04ba8ecc1a53f099cdbb3859d8290d9a9dced56a68f4db46e3231397d1dfa5e6');
	 
	//Get errors and locations
	$locations = $ipLite->getCity($ipaddress);
	$errors = $ipLite->getError();
	 
	//Getting the result
	echo "<p>\n";
	echo $title;
	if (!empty($locations) && is_array($locations)) 
	{
	  foreach ($locations as $field => $val) 
	  {
		echo $field . ' : ' . $val . "<br />\n";
	  }
	}
	echo "</p>\n";
	 
	//Show errors
	echo "<p>\n";
	echo "<strong>Errors</strong><br />\n";
	if (!empty($errors) && is_array($errors)) {
	  foreach ($errors as $error) {
		echo var_dump($error) . "<br /><br />\n";
	  }
	} else {
	  echo "No errors" . "<br />\n";
	}
	echo "</p>\n";

/*
//Set geolocation cookie
if(!$_COOKIE["geolocation"]){
  $ipLite = new ip2location_lite;
  $ipLite->setKey('<your_api_key>');
 
  $visitorGeolocation = $ipLite->getCountry($_SERVER['REMOTE_ADDR']);
  if ($visitorGeolocation['statusCode'] == 'OK') {
    $data = base64_encode(serialize($visitorGeolocation));
    setcookie("geolocation", $data, time()+3600*24*7); //set cookie for 1 week
  }
}else{
  $visitorGeolocation = unserialize(base64_decode($_COOKIE["geolocation"]));
}
 
var_dump($visitorGeolocation);
*/
?>
<html>
<head></head>
<body>

<p><strong>Research</strong></p>
<form action="ip.php" method="post">

	<input type="text" name="ipaddress" /><input type="submit" name="ok" value="GO" />
</form>

</body>
</html>
