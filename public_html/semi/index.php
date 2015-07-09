<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='日本ワーキング・ホリデー協会';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。';
$header_obj->keywords_page='オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';
$header_obj->add_js_files='<script type="text/javascript" src="/js/linkboxes.js"></script>
<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script type="text/javascript">
$(function () {
	$("#div_video").corner();
	fnc_get_title();
});
</script>';
$header_obj->add_style='<style>
body{
	color: #000000;
	background-color: #00004A;
	background-image: url(../images/body-bg2.jpg);
	background-repeat: repeat-x;
}
a:link{ color: white; }
a:visited{ color: white; }
</style>';

$header_obj->pcmobile_type=true;
$header_obj->no_standard_template=true;

$header_obj->display_header();
?>
	<div style="margin: 17px 0 0 50px;">
		<a href="../index.html"><img src="../images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a>
	</div>

<?
	ini_set( "display_errors", "On");
	mb_language("Ja");
	mb_internal_encoding("utf8");

	$user = '';
	$title = '';
	$vcheck = @$_GET['u'];
	$mdmail = @$_GET['m'];

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT vmail,itimes FROM semilist WHERE vcheck = "'.$vcheck.'"');
		$stt->execute();
		$idx = 0;
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			$vmail = $row['vmail'];
			$itimes = $row['itimes'];
		}
		if ($idx > 0)	{
			$user = $vmail;
			try {
				$sql = 'UPDATE semilist SET itimes = :itimes, udate = :udate WHERE vcheck = "'.$vcheck.'"';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':itimes', $itimes + 1);
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->execute();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	if ($user == '')	{
?>
	<div style="color:white; margin: 100px 0 100px 0; text-align:center;">
		<div style="font-size:14pt; font-weight:bold;">
			【　エラー　】<br/>
			ユーザ情報が確認できません。<br/>
			オンラインセミナー用の<a href="http://www.jawhm.or.jp/mail/pc.php">ユーザ登録</a>を行ってください。<br/>
		</div>
	</div>
<?
	}else{
?>
	<div id="div_video" style="margin: 40px 0 0 20px; text-align:center;">
		<div id="title" style="color:white; font-size:14pt; font-weight:bold; margin-bottom:10px;"></div>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="720" height="444" id="utv562968">
			<param name="flashvars" value="autoplay=false&amp;brand=embed&amp;cid=7765095&amp;locale=ja_JP&amp;v3=1"/>
			<param name="allowfullscreen" value="true"/>
			<param name="allowscriptaccess" value="always"/>
			<param name="movie" value="http://www.ustream.tv/flash/viewer.swf"/>
			<embed flashvars="autoplay=false&amp;brand=embed&amp;cid=7765095&amp;locale=ja_JP&amp;v3=1" width="720" height="444" allowfullscreen="true" allowscriptaccess="always" id="utv562968" name="utv_n_982430" src="http://www.ustream.tv/flash/viewer.swf" type="application/x-shockwave-flash" />
		</object>
	</div>
<?

		// 確認メールを送信
		$subject = "オンラインセミナーの参加者がいます。";
		$body  = '';
		$body .= chr(10);
		$body .= '以下のユーザが、オンラインセミナーの閲覧を開始しました。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= '登録アドレス：'.$user;
		$body .= chr(10);
		$body .= chr(10);
		$body .= '';
		$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<meminfo@jawhm.or.jp>";
		mb_send_mail('toiawase@jawhm.or.jp',$subject,$body,"From:".$from);

	}
?>

	<div style="height:20px;">&nbsp;</div>
	<p style="color:white; font-size:10pt; text-align:right; margin-right:20px; margin-top:20px;">
		Copyrihgt (C) JAPAN Association for Working Holiday Makers All right reserved.
	</p>

	<div id="msg" style="margin: 30px 0 0 20px; text-align:center; color:white; font-size:12pt; font-weight:bold;">
		こちらでは、当協会で行われているセミナーをライブ配信しております。<br/>
		セミナーの日程については、<a target="_blank" href="http://www.jawhm.or.jp/seminar.html">当協会ＨＰ</a>からご確認ください。<br/>
		なお、予告なくライブ配信を中止・中断する場合もございます。予めご了承ください。<br/>
	</div>

<script>
function fnc_get_title()	{
	$('#title').load("http://www.jawhm.or.jp/semi/semi_title.php");
	setTimeout('fnc_get_title();', 10000);
}
</script>

</body>
</html>
