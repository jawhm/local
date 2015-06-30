<?php
require_once 'seminar_db.php';

$seminar_id = $_POST["id"];

$smdb = new SeminarDb();
$event = $smdb->check_4beginer($seminar_id);

if($event["beginer"] == "1"){
    echo 1;
}else{
    echo 0;
}
?>

