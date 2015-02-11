<?php

    $ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
    $db = new PDO($ini['dsn'], $ini['user'], $ini['password']) or die('Could not connect to the server!!');
    
    $type = $_GET["type"];
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    $sql = " SELECT * FROM event_list ";
    
    $stt = $db->prepare($sql);
    
    $stt->execute();
        
    $jsonArray = array();
    $counter = 1;
    while($row = $stt->fetch(PDO::FETCH_ASSOC)){
        $jsonArray[$counter] = $row;
        $counter++;
    }
    $json = json_encode($jsonArray);
    
    echo $json;
    
?>
