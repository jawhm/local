<?php
	//declare our assets 
	$name = stripcslashes($_POST['name']);
	$emailAddr = stripcslashes($_POST['email']);
	$comment = stripcslashes($_POST['message']);
	$subject = stripcslashes($_POST['subject']);	
	$contactMessage =  "
Message:
$comment 

Name: $name
E-mail: $emailAddr

Sending IP:$_SERVER[REMOTE_ADDR]
Sending Script: $_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";

$contactMessage .= chr(10);
$contactMessage .= chr(10);
$contactMessage .= '------------------------------';
$contactMessage .= chr(10);
foreach($_SERVER as $post_name => $post_value){
	$contactMessage .= chr(10);
	$contactMessage .= $post_name." : ".$post_value;
}

		//send the email 
		mail('toiawase@jawhm.or.jp', $subject, $contactMessage);
		echo('success'); //return success callback
?>