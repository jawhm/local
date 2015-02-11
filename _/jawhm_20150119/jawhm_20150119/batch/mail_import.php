<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>メールバッチ処理</title>
</head>
<body bgcolor="white">
<?php
	
/********************************
* メール受信
********************************/

function mail_receive($user, $pwd)
{
    $host = "pop.jawhm.or.jp";
    $port = 110;

    // fsockopen:インターネット接続もしくは Unix ドメインソケット接続をオープンする
    $fp = fsockopen($host, $port);

    //****************************
    // ログイン処理
    //****************************

    // ファイルから１行取得する
    // fgets(resource型 ファイルポインタ{handle}, int型 長さ{length})
    $line = fgets($fp, 512);

    // ファイルをバイナリモードで書き込む
    // fputs(resource型 ファイルポインタ{handle}, String型 文字列{string}, int型 長さ{length})
    fputs($fp, "USER $user\r\n");	// USER名
    $line = fgets($fp, 512);		
    fputs($fp, "PASS $pwd\r\n");	// パスワード
    $line = fgets($fp, 512);

    // strpos:指定した文字列がある場所を探す 戻り値 文字列の開始位置false
    if( !strpos($line, "OK") )	// ログイン失敗？
    {
	// オープンされたファイルポインタをクローズする
        fclose($fp);
        return false;
    }

    // メールボックス内のデータを取得
    fputs($fp, "STAT\r\n");
    $line = fgets($fp, 512);

    // list:1つ以上の変数に配列のインデックスを割り当てる
    // explode 引数の文字列を指定した文字で区切る
    list($stat, $num, $size) = explode(' ', $line);

    if( 0+$num == 0 )	// データがない？
    {
        fclose($fp);
        return false;
    }

$num = 5;

    // それぞれ受信して、配列に納める 
    for($id=1;$id<=$num;$id++){
        fputs($fp, "RETR $id\r\n");
        $line = fgets($fp);

        $msg[$id] = "";
        while( !eregi("^\.\r?\n", $line) )
        {
            $line = fgets($fp, 512);
            $msg[$id] .= $line;
        }

	// 受信したメールをサーバから削除する
        //fputs($fp, "DELE $id\r\n");	
        //$line = fgets($fp, 512);
    }

    fputs($fp, "QUIT\r\n");
    fclose($fp);

    return $msg;
}

/******************************************
* メールのヘッダと本文を分ける
******************************************/

function mail_split_mime($data){
//print $data;
    // preg_split:指定した文字列を、正規表現で分割する
    $part = split("\r\n\r\n", $data, 2);
    // preg_replace:正規表現検索および置換を行う
    $part[1] = ereg_replace("\r\n[\t ]+", " ", $part[1]);
    return $part;
}

/******************
* ヘッダ部取得
******************/

function mail_getheader($msg){
    list($head, $body) = mail_split_mime($msg);

    return $head;
}

/**************
* 本文取得
**************/

function mail_getbody($msg, $tmpflg){
    list($head, $body) = mail_split_mime($msg);

    // 本文が始まる箇所を取得
    if(stripos($body, "Content-transfer-encoding")){
	$num = stripos($body, "Content-transfer-encoding")+33;
	$no = strrpos($body, "Content-Type");
	$cal = $no - $num;
	$body = substr($body, $num, strlen($body));
	$no = strrpos($body, "--");
	$body = substr($body, 0, $no);
    }else if(stripos($body, "iso-2022-jp")){
	$num = strpos($body, "iso-2022-jp")+11;

	// お試し
	$no = strrpos($body, "--0-");
	$cal = $no - $num;
	$body = substr($body, $num, $cal);
	// **ここまで**

	//$body = substr($body, $num, strlen($body));
    }

    if(substr_count($body, "=1B") > 20){
	$body = "面倒くさいデコード方式です。";
	return $body;
    }
    // デコード方式をあわせる(仮)
    if(substr_count($body, "\$B") > substr_count($body, "=")){
	$body = mb_convert_encoding($body, "UTF-8", "JIS");
    }else if(substr_count($body, "\$B") == 0){
	return base64_decode($body);
    }else{
	$body = base64_decode($body);
    }

    return $body;
}
/*
//print mb_convert_encoding($body, "UTF-8", "JIS");
    $cnt = strrpos($head, "To:");
    $head2 = substr($head, 0, $cnt);

    if(strpos($head2, "yahoo")){
	$num = strrpos($body, "iso-2022-jp")+11;
	$no  = strrpos($body, "\n--");
	$cal = $no - $num;
	
//	$body = substr($body, $num, $cal);

//return base64_decode($body);
	return mb_convert_encoding($body, "UTF-8", "JIS");
    }else if($tmpflg == 1){

	$ary = array();
	$j = 0;
	// Content-transfer-encoding ～ --Boundary を取得するループ処理を入れる
	$strcnt = substr_count($body, "Content-transfer-encoding");
	
	for($i=0; $i<$strcnt; $i++){
	    $num = stripos($body, "Content-transfer-encoding")+32;
	    $body = substr($body, $num, strlen($body));
	    $no  = strpos($body, "--Boundary");
	    $chk = substr($body, 0, $no);
	    $chk = substr(ltrim($chk), 1, strlen($chk));

	    if(strpos($chk, "\$B") == 0){
		$ary[$j] = substr($body, 0, $no);
		$j++;
	    }
	}
	$num = strpos($body, "Content-Transfer-Encoding")+32;
	$no  = strrpos($body, "(B")+2;
	$cal = $no - $num;
	$body = substr($body, $num, $cal);

$bodyary = array();
$bodyary = explode(' ', $ary[0]);
//print_r($bodyary);
	return mb_convert_encoding($body, "UTF-8", "JIS");
    }else{
	if(strpos($body, "\$B") > 0){
print "03";
	    return mb_convert_encoding($body, "UTF-8", "JIS");
	}else{
print "04";
	    return $body;
	}
    }
}


/************************************************
* ヘッダから各種情報を取得する
************************************************/

function mail_get_headeritem($itemname, $head){
    if( ereg("$itemname:[ \t]*([^\r\n]+)", $head, $regs) ){
print_r($regs);
        return  $regs[1];
    }
    return false;
}

/***********************
* 送信者アドレス取得
***********************/
function mail_get_sender($head){
    $cnt = strrpos($head, "To:");
    $head2 = substr($head, 0, $cnt);

    if(strpos($head2, "yahoo")){
	$num = strrpos($head, "From");
	$no  = strrpos($head, "Reply-To")-5;
	$cal = $no - $num;
	return substr($head, $num+5, 100);
    }else if(strpos($head, "google")){
	return mb_decode_mimeheader(mail_get_headeritem("From", $head));
    }else{
	return mail_get_headeritem("From", $head);
    }
}

/***********************
* 宛先アドレス取得
***********************/

function mail_get_destination($head){
    return mail_get_headeritem("To", $head);
}

/***********************
* 送信日付取得
***********************/

function mail_get_date($head){
    $cnt1 = substr_count($head, "Date");
    $cnt2 = substr_count($head, "date");
    $cnt  = $cnt1 + $cnt2;
//    $head2 = substr($head, 0, $cnt);

    if($cnt > 1){
	$num = strrpos($head, "Date:");
	return substr($head, $num+6, 26);
    }else{
	return mail_get_headeritem("Date", $head);
    }
}

/***************************
* 添付ファイルの有無の確認
***************************/

function mail_get_appended($head){
    $append = mail_get_headeritem("Content-Type", $head);
    $append = substr($append, 0, 10);

    if($append == "text/plain" || $append == "text/html"){
	$append = "添付ファイルなし";
    }else{
	$append = "添付ファイルあり";
    }
    return $append;
}
/***************
* 件名取得
****************/

function mail_get_subject($head){
$subject = mail_get_headeritem("Subject", $head);

print "<br><br>".$head."<br><br>";


//print $subject."<br>";
/*
    $cnt = strrpos($head, "To:");
    $head2 = substr($head, 0, $cnt);


    $head = substr($head, stripos($head, "subject"), strlen($head));

    /************************************************
    * subjectにiso-2022-jpが2つ以上あった場合の処理
    ************************************************/
/*
    $count = substr_count($head, "=?iso");
    $COUNT = substr_count($head, "=?ISO");

    if($count > 1 || $COUNT > 1){
	$start = strpos($head, "=?");
	$end = strrpos($head, "?=");
	$head = substr($head, $start, $end);

	/***************************************************
	* 件名の最後に余計なものがくっついていた場合の処理
	***************************************************/
/*
	$to = strpos($head, "To");
	$from = strpos($head, "From");
	$date = strpos($head, "Date");
	$refernces = strpos($head, "References");
	$thread = strpos($head, "Thread");
	$content = strpos($head, "Content-");

	if(strpos($head, "To")){
	    $head = substr($head, 0, $to);
	}
	if(strpos($head, "From")){
	    $head = substr($head, 0, $from);
	}
	if(strpos($head, "Date")){
	    $head = substr($head, 0, $date);
	}
	if(strpos($head, "References")){
	    $head = substr($head, 0, $refernces);
	}
	if(strpos($head, "Thread")){
	    $head = substr($head, 0, $thread);
	}
	if(strpos($head, "Content-")){
	    $head = substr($head, 0, $content);
	}

	return mb_decode_mimeheader($head);
    }

    /**********************************
    * ヘッダにyahooがあった場合の処理
    **********************************/
/*
    if(strpos($head2, "yahoo")){
	$num = strrpos($head, "Subject");
	$no  = strrpos($head, "To")-9;
	$cal = $no - $num;
	$subject = substr($head, $num+9, $cal);
    }else{
	$subject = mail_get_headeritem("Subject", $head);
    }

    $subject = mb_decode_mimeheader($subject);

    return $subject;
}
/*
    *******************************************
    * 参考にしたサイトにあったサンプルだが、  *
    * 上の記述が問題なく動いているので        *
　　* 残してはおくが使わない方向で。          *
    *******************************************
*/

    $pat = "(.*)=\?iso-2022-jp\?B\?([^\?]+)\?=(.*)";
    while( eregi($pat,$subject,$regs) ){
//print_r($regs);
//print("<br><br><br>");
        $subject = $regs[1].$regs[2].$regs[3];
    }
/*
    $pat = "(.*)=\?iso-2022-jp\?Q\?([^\?]+)\?=(.*)";
    while( eregi($pat,$subject,$regs) ){
        $subject = $regs[1].quoted_
	printable_decode($regs[2]).$regs[3];
    }

    $pat = "(.*)=\?UTF-8\?B\?(.*)";
    while( eregi($pat,$subject,$regs) ){
        $subject = mb_decode_mimeheader($subject);
    }
*/
$subject = mb_decode_mimeheader($subject);
    return $subject;

}

/*************************
* エンコード方式の取得
*************************/

function mail_get_content($head){
    return mail_get_headeritem("Content-Transfer-Encoding", $head);
}

/*****************************
* マルチパートごとに分ける
*****************************/

function mail_split_body($msg)
{
    list($head, $body) = mail_split_mime($msg);
//print $head;

    if( eregi("\nContent-type:.*multipart/",$head) ){
        eregi('boundary="([^"]+)"', $head, $regs);
        $body = str_replace($regs[1], urlencode($regs[1]), $body);
        $parts = split("\r\n--".urlencode($regs[1])."-?-?", $body);
    }else{
        $parts[0] = $msg;
    }

    return $parts;
}

/******************************
* 添付ファイル名の表示
******************************/

function nameprint($multipart, $tmpflg){
    $j = 0;
    $cnt = count($multipart)-2;
    $filename = array();
    $attach = array();

    if($tmpflg == 1){
	for($i=1; $i<=$cnt; $i++){
	  // ファイル形式取得
	  $num = strpos($multipart[$i], "name");
	  $no  = strpos($multipart[$i], "Content-Type");
	  $cal = $num - $no;
	  $attach[$j] = substr($multipart[$i], $no, $cal);

	  // ファイル名取得
	  $length = strlen($multipart[$i]);
	  $filename[$j] = substr($multipart[$i], $num, $length);
	  $number  = strpos($filename[$j], "Content");
	  $filename[$j] = substr($filename[$j], 0, $number);
	  eregi("(.*)\"(.*)\"", $filename[$j], $tmp);
	  $filename[$j] = $tmp[2];
	  $j = $j + 1;
	}
    }

    return $filename;

}

/*********************************
* 添付ファイルを配列に入れる
*********************************/

function appendedfile($multipart){
//    print_r($multipart);
    $j = 0;
    $file = Array();
    $cnt = count($multipart) - 2;
    if($cnt < 0){
	$cnt = 0;
    }

    for($i=1; $i<=$cnt; $i++){
	if(strpos($multipart[$i], "file0")){
	  $num = strpos($multipart[$i], "file0")+5;
	}else if(strpos($multipart[$i], "file".$i)){
	  $num = strpos($multipart[$i], "file".$i)+5;

	// jpg判定(?)
	}else if(strpos($multipart[$i], "/9j/")){
	  $num = strpos($multipart[$i], "/9j/");

	// gif判定(?)
	}else if(strpos($multipart[$i], "R0lGODlh")){
	  $num = strpos($multipart[$i], "R0lGODlh");
	}
	$no  = strlen($multipart[$i]);
	$file[$j] = substr($multipart[$i], $num, $no);
	$j++;
    }

    return $file;
}

/********************************
* 添付ファイル(画像)のデコード
********************************/

function imgdecode($tmp, $name){
    $cnt = count($tmp);
    $file = array();
//print_r($tmp);
    for($i=0; $i<$cnt; $i++){
	$file[$i] = base64_decode($tmp[$i]);

	$fp = fopen($name[$i], "w");
	fwrite($fp, $file[$i]);
	fclose($fp);
	if(strpos($name[$i], "jpg") || strpos($name[$i], "jpeg") || strpos($name[$i], "png") ||
		strpos($name[$i], "gif") || strpos($name[$i], "bmp")){
	  //print "<img src='./".$name[$i]."' width='128' height='128'>";
	}
    }
}

/*
    $num = strpos($img[1], "/9j/");
    $no  = strlen($img[1]);
    $cal = $no - $num;
    $file = substr($img[1], $num, $cal);
//header("Content-type: image/jpeg");
$file = base64_decode($file);

$fp = fopen($name, "w");
fwrite($fp, $file);
fclose($fp);
*/

/*********************************
* 添付ファイルの数をカウント
*********************************/

function filecount($msg){
    list($head, $body) = mail_split_mime($msg);
    // おそらくメジャーな添付ファイル形式
    $count = substr_count($body, 'application/');
    $count = $count + substr_count($body, 'audio/');
    $count = $count + substr_count($body, 'image/');
    $count = $count + substr_count($body, 'message/');
    $count = $count + substr_count($body, 'multipart/');
    $count = $count + substr_count($body, 'video/');
//    $count = $count + substr_count($body, 'text/');

    // おそらくマイナーな添付ファイル形式
    $count = $count + substr_count($body, 'chemical/');
    $count = $count + substr_count($body, 'i-world/');
    $count = $count + substr_count($body, 'x-conference/');
    $count = $count + substr_count($body, 'x-world');

    return $count;

}

/*********************
* Date形式の変換
**********************/

function dateconvert($date){
    $ary = array();
    $ary = explode(' ', $date);

    // 年月日に分ける
    $day = $ary[1];
    $month = $ary[2];
    $year = $ary[3];

    // 時分秒に分ける
    $time = explode(":", $ary[4]);
    $hour = $time[0];
    $minuts = $time[1];
    $second = $time[2];

    // 月の表示を数字にする
    switch( $month ){
	case "Jan":
	  $month = "01";
	  break;
	case "Feb":
	  $month = "02";
	  break;
	case "Mar":
	  $month = "03";
	  break;
	case "Apr":
	  $month = "04";
	  break;
	case "May":
	  $month = "05";
	  break;
	case "Jun":
	  $month = "06";
	  break;
	case "Jul":
	  $month = "07";
	  break;
	case "Aug":
	  $month = "08";
	  break;
	case "Sep":
	  $month = "09";
	  break;
	case "Oct":
	  $month = "10";
	  break;
	case "Nov":
	  $month = "11";
	  break;
	case "Dec":
	  $month = "12";
	  break;
	default:
	  echo 'エラー：異常なデータです。';
    }

    // $dayが1桁の場合2桁にする
    if($day < 10){
	$day = "0".$day;
    }

    $date = $year."/".$month."/".$day." ".$hour.":".$minuts.":".$second;

    return $date;
}

/*******************************
* multipartのデコード
*******************************/

function decode($multipart){
    $num = strpos($multipart, "charset=");
    $decode = substr($multipart, $num, 30);
//print $decode;
}


/***********************************
* DBに接続してメール番号を取得する
***********************************/
/*
function getMailNo(){
    //サーバー情報
    $SIXCOREsvr = 'localhost';
    $SIXCOREusr = 'root';
    $SIXCOREpw = '303pittst';
    $SIXCOREdb = 'mail_data';

    // サーバー接続
    $link = mysql_connect( $SIXCOREsvr, $SIXCOREusr, $SIXCOREpw );
    // 接続確認
    if (!$link) {
	$svconnect_rtncd = 1;	//リターンコード「１」異常
	print('<font color="red">MySQL接続失敗</font>');
    }else{
    	$db_selected = mysql_select_db( $SIXCOREdb , $link );
	$svconnect_rtncd = 0;	//リターンコード「０」正常
	print('<font color="blue">MySQL接続成功</font><br><br>');
	

/*
	//メール番号への登録
	$query = 'insert into D_MAIL_NO values (' . 0 . ',"' . $now_time . '");';
	$result = mysql_query($query);
		
	print('登録日時[' . $now_time . ']<br>');
		
    }
}

/**************************************
* DBに登録する(現状では本文、添付以外)
**************************************/
/*
function registData(){

}
*/
/****************************
* 設定や処理
****************************/
//***共通情報***********
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'mail_import.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
//	$ok_gmn = array('mail_import.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから***

	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		//**ログ出力**
		//ログ種別（ N:通常ログ  W:警告  E:エラー T:トランザクション ）
		$log_sbt = 'E';
		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
		$log_kkstaff_kbn = 'S';
		//オフィスコード
		$log_office_cd = 'tokyo';
		//会員番号 または スタッフコード
		$log_kaiin_no = 'system';
		//内容
		$log_naiyou = 'サーバー接続に失敗しました。';
		//エラー情報
		$log_err_inf = '';
		require( './zs_log.php' );
		//************
	}else{
		//エラーなし
$user = "mailsystem_alldata@jawhm.or.jp"; //$_POST["user"];
$pwd  = "Fz85ACWjUpev";//$_POST["pwd"];

$msg = mail_receive($user,$pwd);
//print_r($msg);

if(count($msg) == 1){
  if($msg == ""){
    $cnt = 0;
  }else{
    $cnt = count($msg);
  }
}else{
  $cnt = count($msg);
}

print $cnt."件のメールを受信しました\n";

if($cnt > 0){
	print "<table border='1'>";
	print "<tr><th>送信者</th><th>宛先</th><th>日時</th>";
	print "<th>件名</th><th>添付ファイルの有無</th><th>本文</th><th>保存</th></tr>";

	for($i=1; $i<=$cnt; $i++){
	    $head = mail_getheader($msg[$i]);
	    $multipart = mail_split_body($msg[$i]);

	    // 送信者アドレス
	    $send = mail_get_sender($head);

	    //「送信先に表示する値を設定」しているアドレスを表示
	    if(eregi("(.*)\<(.*)\>", $send) != ""){
		eregi("(.*)\<(.*)\>", $send, $tmp);
		$send = $tmp[2];
	    }
//getMailNo();
//print $multipart[2];
	    // 宛先アドレス
	    $destination = mail_get_destination($head);
	    // 送信日付
	    $date = mail_get_date($head);
	    // 日付形式の変換
	    $date = dateconvert($date);
	    // 件名
	    $subject = mail_get_subject($head);
	    // エンコード方式
	    $content = mail_get_content($head);
	    // 添付ファイルの有無
	    $appended = mail_get_appended($head);
	    // 添付ファイル数をカウント
	    $filecnt = filecount($msg[$i]);

	    if($appended == "添付ファイルあり"){
		$tmpflg = 1;
	    }else{
		$tmpflg = 0;
	    }

/*	    
	    if(stripos($multipart[0], "multi-part")){
		$body = decode($multipart[1]);
		$body = $multipart[1];
	    }else{
*/
		// 本文取得
		$body = mail_getbody($multipart[1], $tmpflg);
//	    }

	    $count = strpos($send, "@");
	    $address = substr($send, $count, strlen($send));

	    print "<tr>";
	    print "<td>".$send."</td>";
	    print "<td>".$destination."</td>";
	    print "<td>".$date."</td>";
	    print "<td>".$subject."</td>";
	    print "<td>".$appended."</td>";

	    if($filecnt < 10){
		// 添付ファイル名取得(配列)
		$name = nameprint($multipart, $tmpflg);
		// 添付ファイル取得(配列)
		$file = appendedfile($multipart);
		imgdecode($file, $name);
		print "<td>".$body."</td>";
	    }else{
		print "<td>エラー：添付ファイルの数が10個を超えています。</td>";
	    }
	if($appended == "添付ファイルあり"){
	    print "<td>";
	    print "<form method='post' action='download.php'>";
	    print "<input type='hidden' name='filename' value='".$name."'>";
	    print "<input type='submit' value='DL'>";
	    print "</form>";
	    print "</td>";
	}else{
	    print "<td align='center'>-</td>";
	}
	    print "</tr>";
	}

	print "</table>";

}



	
	
	
	
	
	}

	mysql_close( $link );
?>
</body>
</html>
