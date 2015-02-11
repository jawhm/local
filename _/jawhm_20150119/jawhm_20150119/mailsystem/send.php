<?php
require_once 'myConfig.php';

$q = new Mail_Queue($dbo, $mo);
$q->sendMailsInQueue(10);

print ('mail sent at '.date('H:i:s'));

?>
