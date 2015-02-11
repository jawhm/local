<?php

function send_mail($type, $to, $from, $sender = "", $subject, $text, $bcc = "", $cc = "", $encoding = "UTF-8")
{

	$headers = '';

	if ($type == 0) {
		//JIS
		mb_language("Ja");

		$text  = mb_convert_encoding($text, "JIS", $encoding);
	} else {
		//UTF-8
		mb_language("uni");

		$headers = "Mime-Version: 1.0\n";
		$headers .= "Content-Type: text/plain;charset=UTF-8\n";
	}

	// JISにエンコード
	$subject  = "=?ISO-2022-JP?B?".base64_encode( mb_convert_encoding($subject, "JIS", $encoding) )."?=";

	if ($sender != ""){
		$sender  = "=?ISO-2022-JP?B?".base64_encode( mb_convert_encoding($sender, "JIS", $encoding) )."?=";
	}

	$opt1 = $headers;

	// From
	$opt1 .= "From: ";
	if ($sender != ""){
		$opt1 .= $sender."<";
	}
	$opt1 .= $from;
	if ($sender != ""){
		$opt1 .= ">";
	}
	$opt1 .= "\r\n";

	// Cc
	if($cc != "") {
		$opt1 .= "Cc: ".$cc."\r\n";
	}

	// Bcc
	if($bcc != "") {
		$opt1 .= "Bcc: ".$bcc."\r\n";
	}

	$opt2 = "-f$from";

	mail($to, $subject, $text, $opt1, $opt2);

	return 0;
}


/*
********************************************************************************
メール送信（管理者）
********************************************************************************
*/

mb_internal_encoding("UTF-8");

$inquiry_type_array = array(1=>"セミナー予約ができない", 2=>"セミナー内容について", 3=>"開催場所について", 4=>"その他セミナーに関して");

$body = sprintf("%s 様\n\n", $_POST['your_name']);
$body .= "日本ワーキング・ホリデー協会でございます。\n";
$body .= "この度は当協会セミナーについてお問い合わせをありがとうございます。\n\n";
$body .= "３営業日以内にご返答を差し上げますので、\n";
$body .= "今しばらくお待ちいただきますようお願いいたします。\n\n";

$body .= "－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－\n\n";
$body .= sprintf("■お問い合わせ内容 ： %s\n\n", $inquiry_type_array[$_POST['inquiry_type']]);
$body .= sprintf("■お問い合わせ詳細 ： \n%s\n\n", $_POST['inquiry_detail']);
$body .= sprintf("■お名前 ： %s\n\n", $_POST['your_name']);
$body .= sprintf("■メールアドレス ： %s\n\n", $_POST['your_email']);
$body .= "－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－\n\n";
$body .= "※このメールはサーバーより自動返信しております。\n\n";

$body .= "**************************************************************\n";
$body .= "一般社団法人　日本ワーキング・ホリデー協会\n\n";
$body .= "Mail : info@jawhm.or.jp\n";
$body .= "URL : http://www.jawhm.or.jp\n\n";
$body .= "〒160-0023\n";
$body .= "東京都新宿区西新宿1-3-3\n";
$body .= "品川ステーションビル新宿5階 507\n";
$body .= "TEL: 03-6304-5858 FAX: 03-6745-1562\n";
$body .= "**************************************************************\n";

$to = "toiawase@jawhm.or.jp";

$from = "toiawase@jawhm.or.jp";
$sender = "一般社団法人　日本ワーキング・ホリデー協会";
$subject = "【日本ワーキング・ホリデー協会】お問い合わせありがとうございます。";

send_mail(1, $to, $from, $sender, $subject, $body);


/*
********************************************************************************
メール送信（ユーザ）
********************************************************************************
*/

$body = sprintf("%s 様\n\n", $_POST['your_name']);
$body .= "日本ワーキング・ホリデー協会でございます。\n";
$body .= "この度は当協会セミナーについてお問い合わせをありがとうございます。\n\n";
$body .= "３営業日以内にご返答を差し上げますので、\n";
$body .= "今しばらくお待ちいただきますようお願いいたします。\n\n";

$body .= "－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－\n\n";
$body .= sprintf("■お問い合わせ内容 ： %s\n\n", $inquiry_type_array[$_POST['inquiry_type']]);
$body .= sprintf("■お問い合わせ詳細 ： \n%s\n\n", $_POST['inquiry_detail']);
$body .= sprintf("■お名前 ： %s\n\n", $_POST['your_name']);
$body .= sprintf("■メールアドレス ： %s\n\n", $_POST['your_email']);
$body .= "－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－\n\n";
$body .= "※このメールはサーバーより自動返信しております。\n\n";

$body .= "**************************************************************\n";
$body .= "一般社団法人　日本ワーキング・ホリデー協会\n\n";
$body .= "Mail : info@jawhm.or.jp\n";
$body .= "URL : http://www.jawhm.or.jp\n\n";
$body .= "〒160-0023\n";
$body .= "東京都新宿区西新宿1-3-3\n";
$body .= "品川ステーションビル新宿5階 507\n";
$body .= "TEL: 03-6304-5858 FAX: 03-6745-1562\n";
$body .= "**************************************************************\n";



$to = $_POST['your_email'];
$from = "toiawase@jawhm.or.jp";
$sender = "一般社団法人　日本ワーキング・ホリデー協会";
$subject = "【日本ワーキング・ホリデー協会】お問い合わせありがとうございます。";

send_mail(0, $to, $from, $sender, $subject, $body);



echo('送信しました。');


?>