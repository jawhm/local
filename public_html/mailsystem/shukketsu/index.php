<?

	session_start();

	list(,$para1, $para2, $para3, $para4, $para5) = explode('/', $_SERVER['PATH_INFO']);
	$c_base = $_SERVER['REQUEST_URI'];

	$c_footer = '
		<div data-role="footer" class="footer-docs" data-theme="a">
		<p>&copy; 2011-2012 JAPAN Association for Working Holiday Makers.</p>
		</div>
	';

	$url_home = 'http://www.jawhm.or.jp/mem/mem';
	$url_top  = 'http://www.jawhm.or.jp/';

	if ($para1 <> 'id')	{
		$_SESSION['para1'] = $para1;
		$_SESSION['para2'] = $para2;
		$_SESSION['para3'] = $para3;
		$_SESSION['para4'] = $para4;
		$_SESSION['para5'] = $para5;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
	<title>ワーホリ協会</title> 
	<link rel="stylesheet" href="http://www.jawhm.or.jp/mem/css/jquery.mobile-1.1.0.min.css" />
	<link rel="stylesheet" href="http://www.jawhm.or.jp/mem/css/themes/jawhm.min.css" />
	<script src="http://www.jawhm.or.jp/mem/js/jquery-1.7.2.min.js"></script>
	<script src="http://www.jawhm.or.jp/mem/js/jquery.mobile-1.1.0.min.js"></script>
</head>
<style>
.localnav {
	margin:0 0 20px 0;
	overflow:hidden;
}
.localnav li {
	float:left;
}
.localnav .ui-btn-inner { 
	padding: .6em 10px; 
	font-size:90%; 
}
</style>
<title>ワーホリ協会</title>
<body>

<div data-role="page" id="toppage">
	<div data-role="header" data-theme="a">
		<h1>ワーホリ協会</h1>
	</div>
	<div data-role="content">

		<ul data-role="listview" data-inset="true" data-theme="b" data-dividertheme="b">
			<li data-role="list-divider">セミナー予約一覧</li>
			<li><a href="./tokyo.php">東京</a></li>
			<li><a href="./osaka.php">大阪</a></li>
			<li><a href="./nagoya.php">名古屋</a></li>
			<li><a href="./fukuoka.php">福岡</a></li>
			<li><a href="./okinawa.php">沖縄</a></li>
			<li><a target="_blank" href="<? print $url_top; ?>">通常TOPページへ</a></li>
		</ul>
	</div>
</div>


</body>
</html>
