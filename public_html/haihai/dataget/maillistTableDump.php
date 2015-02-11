<?php
    
    $ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
    $db = new PDO($ini['dsn'], $ini['user'], $ini['password']) or die('Could not connect to the server!!');
    
    $type = $_GET["type"];
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $db->query('SET CHARACTER SET utf8');
    $sql = " SELECT * FROM maillist ";
    if(!empty($type))
    {
        $sql .= " WHERE haihai = '$type'";
    }
    
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
    
    /*                    
    $con = mysql_connect('192.168.11.132', 'mail_list', 'r2d2c3po303pittst') or die('Could not connect to the server!');
    $db  = mysql_select_db('toratora_base') or die('Could not select a database.');
        
    $type = $_GET["type"];
    
    $sql = " SELECT * FROM maillist ";
    if(!empty($type))
    {
        $sql .= " WHERE haihai = '$type'";
    }
    
    $result = mysql_query($sql) or die('A error occured: ' . mysql_error());
        
    $jsonArray = array();
    $counter = 1;
    while($record = mssql_fetch_array($result)) {
        $jsonArray[$counter] = $record;
        $counter++;
    }
    $json = json_encode($jsonArray);
    
    echo $json;
    */
?>
