<?

//ini_set( "display_errors", "On");

function calender_show($year, $month)	{

	$day = "1";
	$num = date("t", mktime(0,0,0,$month,$day,$year));

	print '<table border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" style="font-size: 12pt; color: #666666;" id="'.$year.$month.'" class="'.$year.$month.'">';
	print '<tr>';
	print '<td align="center" colspan="7" bgcolor="#EEEEEE" height="18" style="color: #666666;">'.$year.'年'.$month.'月</td></tr>';
	print '<tr>';
	print '<td align="center" width="40" height="18" bgcolor="#FF3300" style="color: #FFFFFF;">日</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">月</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">火</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">水</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">木</td>';
	print '<td align="center" width="40" bgcolor="#C7D8ED" style="color: #666666;">金</td>';
	print '<td align="center" width="40" bgcolor="#A6C0E1" style="color: #666666;">土</td>';
	print '</tr>';

	//カレンダーの日付を作る
	for($i=1;$i<=$num;$i++){

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		//曜日は数値
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		if($i==1){
			//一日目の曜日を提示するまでを繰り返し
			print "<tr>";
			for($j=1;$j<=$w;$j++){
				print "<td></td>";
			}
			$data = calender_output($i,$w,$year,$month,$day);
			print "$data";
			if($w==6){
				print "</tr>";
			}
		}
		//一日目以降の場合
		else{
			if($w==0){
				print "<tr>";
			}
			$data = calender_output($i,$w,$year,$month,$day);
			print "$data";
			if($w==6){
				print "</tr>";
			}
		}
	}
	if($w!=6){
		print "</tr>";
	}
	print "</table>";

}

function calender_output($i,$w,$year,$month,$day){

	global $cal;

	$change = "";
	$link = '<a href="../event.php?act=new&year='.$year.'&month='.$month.'&day='.$i.'#'.$year.$month.'">'.$i.'</a>';

	if (@$cal[$year.$month.$i])	{
		$link = '<a href="#'.$year.substr('00'.$month,-2).substr('00'.$i,-2).'">'.@$cal[$year.$month.$i].$i.'</a><br/>';
	}else{
		$link = $i;
	}

	include './mailsystem/calender_off.php';

	if ($change == "on")	{
		$change = '<td align="center" height="18" bgcolor="#FFCC99" style="color: #666666;">'.$link.'</td>';
	}

	// 曜日判定
	if ($change == "")	{
		if($w==0){
			// 日曜日
			$change = '<td align="center" height="18" bgcolor="#FFCC99" style="color: #666666;">'.$link.'</td>';
		}
		elseif($w==6){
			// 土曜日
			$change = '<td align="center" height="18" bgcolor="#FFFFFF" style="color: #666666;">'.$link.'</td>';
		}
		else{
			$change = '<td align="center" height="18" bgcolor="#FFFFFF" style="color: #666666;">'.$link.'</td>';
		}
	}
	return $change;
}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>イベントカレンダー | 日本ワーキング・ホリデー協会</title>

<meta name="keywords" content="オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館" />

<meta name="description" content="イベントカレンダー：オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。" />

<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="../index.html" type="text/html" title="ホームページ(最初のページ)" />
<link rel="Index" href="../index3.html" type="text/html" title="索引ページ" />
<link rel="Contents" href="../content.html" type="text/html" title="目次ページ" />
<link rel="Search" href="../search.html" type="text/html" title="検索できるページ" />
<link rel="Glossary" href="../glossar.html" type="text/html" title="用語解説ページ" />
<link rel="Help" href="file://///Landisk-a14f96/smithsonian/80.ワーキングホリデー協会/Info/help.html" type="text/html" title="ヘルプページ" />
<link rel="First" href="sample01.html" type="text/html" title="最初の文書へ " />
<link rel="Prev" href="sample02.html" type="text/html" title="前の文書へ" />
<link rel="Next" href="sample04.html" type="text/html" title="次の文書へ" />
<link rel="Last" href="sample05.html" type="text/html" title="最後の文書へ" />
<link rel="Up" href="../index2.html" type="text/html" title="一つ上の階層へ" />
<link rel="Copyright" href="../copyrig.html" type="text/html" title="著作権についてのページへ" />
<link rel="Author" href="mailto:info@jawhm.or.jp " title="E-mail address" />
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<link href="../css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="../css/contents.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-easing.js"></script>
<script type="text/javascript" src="../js/scroll.js"></script>
<script type="text/javascript" src="../js/jquery.corner.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20563699-1']);
  _gaq.push(['_setDomainName', '.jawhm.or.jp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
function simple_tooltip(target_items, name){
 $(target_items).each(function(i){
        $("body").append("<div class='"+name+"' id='"+name+i+"'><p>"+$(this).attr('title')+"</p></div>");
        var my_tooltip = $("#"+name+i);
        if($(this).attr("title") != "" && $(this).attr("title") != "undefined" ){
        $(this).removeAttr("title").mouseover(function(){
                    my_tooltip.css({opacity:0.9, display:"none"}).fadeIn(400);
        }).mousemove(function(kmouse){
                var border_top = $(window).scrollTop();
                var border_right = $(window).width();
                var left_pos;
                var top_pos;
                var offset = 10;
                if(border_right - (offset *2) >= my_tooltip.width() + kmouse.pageX){
                    left_pos = kmouse.pageX+offset;
                    } else{
                    left_pos = border_right-my_tooltip.width()-offset;
                    }
                if(border_top + (offset *2)>= kmouse.pageY - my_tooltip.height()){
                    top_pos = border_top +offset;
                    } else{
                    top_pos = kmouse.pageY-my_tooltip.height()-offset;
                    }
                my_tooltip.css({left:left_pos, top:top_pos});
        }).mouseout(function(){
                my_tooltip.css({left:"-9999px"});
        });
        }
    });
}
$(function () {
	$('#semi_memo').corner();
	simple_tooltip("a","tooltip");
});
</script>
</head>
<style>
div.tooltip {
	width: 320px;
	position: absolute;
	left: -9999px;
	background: #EEE;
	padding: 4px;
	border: 1px solid #AAA;
}
div.tooltip p{
	color: white;
	background: navy;
	padding: 10px 15px;
}
</style>

<body>
<div id="header">
    <h1><a href="../index.html"><img src="../images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
	<div id="utility-nav">
	<ul>
	  <li class="u-nav01"><a href="../japanese">日本語</a></li>
	  <li class="u-nav02"><a href="../english">英語</a></li>
	  <li class="u-nav03"><a href="../mobile">携帯</a></li>
	</ul>
	</div>
  <img id="top-mainimg" src="../images/top-mainimg.jpg" alt="" width="970" height="170" />  </div>
  <div id="contentsbox"><img id="bgtop" src="../images/contents-bgtop.gif" alt="" />
  <div id="contents">
    <div id="global-nav">
	  <div class="g-n-sec01">
	  <ul id="memberlogin">
	    	<li class="ml01"><a href="/memsite">メンバーログイン</a></li>
		<li class="ml02"><a href="/mem">メンバー登録はこちら</a></li>
	  </ul>
	  </div>
	  <div class="g-n-sec02">
	  <ul id="g-n-main01">
	    <li class="gnm01"><a href="../system.html">ワーキング・ホリデー制度について</a></li>
		<li class="gnm02"><a href="../start.html">はじめてのワーキング・ホリデー</a></li>
		<li class="gnm03"><a href="../visa/visa_top.html">ワーキング・ホリデー協定国</a></li>
	        <li class="gnm23"><a href="../seminar.html">無料セミナー</a></li>
		<li class="gnm04"><a href="../event.html">イベントカレンダー</a></li>
		<li class="gnm05"><a href="../recruit/index.html">求人・求職情報サイト</a></li>
		<li class="gnm06"><a href="../return.html">帰国者の方へ</a></li>
		<li class="gnm07"><a href="../qa.html">Ｑ＆Ａ</a></li>
		<li class="gnm08"><a href="../info.html">お役立ち情報</a></li>
		<li class="gnm09"><a href="../trans.html">翻訳サービス</a></li>
		<li class="gnm10"><a href="../gogaku-spec.html">語学講座</a></li>
	    <li class="gnm11"><a href="../school.html">語学学校</a></li>
		<li class="gnm12"><a href="../support.html">サポート機関</a></li>
		<li class="gnm13"><a href="../service.html">サービス</a></li>
		<li class="gnm14"><a href="../company.html">企業会員一覧</a></li>
	    <li class="gnm15"><a href="../attention.html">外国人ワーキングホリデー青年</a></li>
	  </ul>
	  <ul id="g-n-main02">
	    <li class="gnm16"><a href="../about.html">ワーキング・ホリデー協会について</a></li>
	        <li class="gnm24"><a href="../volunteer.html">ボランティア・インターン募集</a></li>
		<li class="gnm17"><a href="../access.html">アクセス</a></li>
		<li class="gnm18"><a href="../mem-com.html">企業会員について</a></li>
		<li class="gnm19"><a href="../adv.html">広告掲載のご案内</a></li>
		<li class="gnm20"><a href="../privacy.html">個人情報の取り扱い</a></li>
		<li class="gnm21"><a href="../about.html#deal">特定商取引に関する表記</a></li>
		<li class="gnm22"><a href="../sitemap.html">サイトマップ</a></li>
	  </ul>
	  </div>
	</div>
	<div id="maincontent">
	  <p id="topicpath"><a href="../index.html">トップ</a>　> イベントカレンダー </p>

<?
	// イベント読み込み
	$cal = array();

	$evt_ymd   = array();
	$evt_title = array();
	$evt_desc  = array();
	$evt_img   = array();

	$jp = array('北海道','青森','秋田','岩手','山形','宮城','石川','富山','新潟','福島','長崎','佐賀','福岡','山口','島根','鳥取','兵庫','京都','滋賀','福井','長野','群馬','栃木','茨城','熊本','大分','広島','岡山','奈良','岐阜','山梨','埼玉','千葉','鹿児島','宮崎','和歌山','三重','愛知','静岡','神奈川','愛媛','香川','高知','徳島','沖縄','東京','大阪');
	$en = array('hokkaidou','aomori','akita','iwate','yamagata','miyagi','ishikawa','toyama','niigata','fukushima','nagasaki','saga','fukuoka','yamaguchi','shimane','tottori','hyogo','kyoto','shiga','fukui','nagano','gunma','tochigi','ibaraki','kumamoto','ooita','hiroshima','okayama','nara','gifu','yamanashi','saitama','chiba','kagoshima','miyazaki','wakayama','mie','aichi','shizuoka','kanagawa','ehime','kagawa','kouchi','tokushima','okinawa','tokyo','osaka');

	for ($idx=0; $idx<count($en); $idx++)	{
		$title[$en[$idx]] = $jp[$idx].'で予定されているセミナーがありません。<br/>私の街でもセミナーを開催して！！<br/>などの、ご要望もお受けしております。<br/>是非、ご連絡ください。';
		$bg[$en[$idx]] = '#f5e577';
		$jump[$en[$idx]] = '';
	}

	$bg['tokyo'] = '#ff88bb';
	$title['tokyo'] = '東京では通常のセミナーを開催しております。';

	$bg['osaka'] = '#ff88bb';
	$title['osaka'] = '大阪では通常のセミナーを開催しております。';

	$bg['fukuoka'] = '#ff88bb';
	$title['fukuoka'] = '福岡では通常のセミナーを開催しております。';

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat FROM event_list WHERE k_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			if ($row['place'] == 'event')	{
				// イベント
				$evt_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$evt_title[] = $row['k_title1'];
				$evt_desc[]  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					$evt_img[]   	= '<img src="../images/semi_now.jpg">';
				}elseif ($row['k_stat'] == 2)	{
					$evt_img[]   	= '<img src="../images/semi_full.jpg">';
				}else{
					$evt_img[]	= '';
				}
				$cal[$year.$month.$day] .= '<img src="../images/sa04.jpg">';

				for ($idx=0; $idx<count($jp); $idx++)	{
					if ($jp[$idx] == $row['memo'])	{
						$bg[$en[$idx]] = '#ff88bb';
						$title[$en[$idx]] = nl2br(strip_tags($row['k_title1']).'<br/>&nbsp;<br/>'.strip_tags($row['k_desc1']));
						$jump[$en[$idx]] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
					}
				}
			}
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>

	<h2 class="sec-title">メンバー登録</h2>
	<div style="padding-left:30px;">
		<p>
			日本ワーキング・ホリデー協会では、従来、東京・大阪・福岡・仙台で行っておりました無料セミナーを、<br/>
			４月２３日沖縄会場からスタートし、全国各地で行う事となりました。
		</p>
		&nbsp;<br/>

    <div class="tooltip">  
    <p>aタグのタイトル内のテキストがここに反映されます。</p>  
    </div>

<!-- 全国マップ -->
<table cellspacing="0" cellpadding="6" style="margin-left:50px;">
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0" style="font-size:14px;line-height:140%;">
				<tr valign="top">
					<td>
						<div id="semi_memo" style="font-size:9pt; width:210px; height:90px; background-color:peachpuff; padding: 15px 10px 5px 10px;">
							都道府県にカーソルを合わせてください。<br/>
							セミナーの詳細が表示されます。<br/>
							私の街でもセミナーを開催して！！<br/>
							などの、ご要望もお受けしております。<br/>
						</div>
					</td>
					<td align="right">
						<table cellspacing="1" cellpadding="0">
							<tr height="40" style="font-size:10px;text-align:center;">
								<td></td>
								<td bgcolor="<? print $bg['hokkaidou']; ?>" width="50">
									<a href="../#" title="<? print $title['hokkaidou']; ?>">北海道</a>
								</td>
							</tr>
							<tr>
								<td height="10"></td>
							</tr>
						</table>
						<table cellspacing="1" cellpadding="0" style="font-size:10px;text-align:center;margin-bottom:-1;">
							<tr height="25">
								<td></td><td></td><td></td><td width="30"></td>
								<td bgcolor="<? print $bg['aomori']; ?>" width="30">
									<a href="../#" title="<? print $title['aomori']; ?>">青森</a>
								</td>
								<td width="20"></td>
							</tr>
							<tr height="40">
								<td></td><td></td><td width="30"></td>
								<td bgcolor="<? print $bg['akita']; ?>" width="30">
									<a href="../#" title="<? print $title['akita']; ?>">秋田</a>
								</td>
								<td bgcolor="<? print $bg['iwate']; ?>">
									<a href="../#" title="<? print $title['iwate']; ?>">岩手</a>
								</td>
							</tr>
							<tr height="35">
								<td></td><td></td><td></td>
								<td bgcolor="<? print $bg['yamagata']; ?>" width="30">
									<a href="../#" title="<? print $title['yamagata']; ?>">山形</a>
								</td>
								<td bgcolor="<? print $bg['miyagi']; ?>">
									<a href="../#" title="<? print $title['miyagi']; ?>">宮城</a>
								</td>
							</tr>
							<tr height="25">
								<td bgcolor="<? print $bg['ishikawa']; ?>" width="30">
									<a href="../#" title="<? print $title['ishikawa']; ?>">石川</a>
								</td>
								<td bgcolor="<? print $bg['toyama']; ?>" width="30">
									<a href="../#" title="<? print $title['toyama']; ?>">富山</a>
								</td>
								<td bgcolor="<? print $bg['niigata']; ?>" width="60" colspan="2">
									<a href="../#" title="<? print $title['niigata']; ?>">新潟</a>
								</td>
								<td bgcolor="<? print $bg['fukushima']; ?>" width="30">
									<a href="../#" title="<? print $title['fukushima']; ?>">福島</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table cellspacing="1" cellpadding="0" style="font-size:10px;text-align:center;border-style:none;">
				<tr height="25">
					<td bgcolor="<? print $bg['nagasaki']; ?>" width="26">
						<a href="../#" title="<? print $title['nagasaki']; ?>">長崎</a>
					</td>
					<td bgcolor="<? print $bg['saga']; ?>" width="26">
						<a href="../#" title="<? print $title['saga']; ?>">佐賀</a>
					</td>
					<td bgcolor="<? print $bg['fukuoka']; ?>" width="26">
						<a href="../seminar.html#fukuoka-semi" title="<? print $title['fukuoka']; ?>">福岡</a>
					</td>
					<td width="10"></td>
					<td bgcolor="<? print $bg['yamaguchi']; ?>" width="26" rowspan="2">
						<a href="../#" title="<? print $title['yamaguchi']; ?>">山口</a>
					</td>
					<td bgcolor="<? print $bg['shimane']; ?>" width="26">
						<a href="../#" title="<? print $title['shimane']; ?>">島根</a>
					</td>
					<td bgcolor="<? print $bg['tottori']; ?>" width="26">
						<a href="../#" title="<? print $title['tottori']; ?>">鳥取</a>
					</td>
					<td bgcolor="<? print $bg['hyogo']; ?>" width="26" rowspan="2">
						<a href="../#" title="<? print $title['hyogo']; ?>">兵庫</a>
					</td>
					<td bgcolor="<? print $bg['kyoto']; ?>" width="30">
						<a href="../#" title="<? print $title['kyoto']; ?>">京都</a>
					</td>
					<td bgcolor="<? print $bg['shiga']; ?>" width="26">
						<a href="../#" title="<? print $title['shiga']; ?>">滋賀</a>
					</td>
					<td bgcolor="<? print $bg['fukui']; ?>" width="30">
						<a href="../#" title="<? print $title['fukui']; ?>">福井</a>
					</td>
					<td bgcolor="<? print $bg['nagano']; ?>" width="30" rowspan="2">
						<a href="../#" title="<? print $title['nagano']; ?>">長野</a>
					</td>
					<td bgcolor="<? print $bg['gunma']; ?>" width="30">
						<a href="../#" title="<? print $title['gunma']; ?>">群馬</a>
					</td>
					<td bgcolor="<? print $bg['tochigi']; ?>" width="30">
						<a href="../#" title="<? print $title['tochigi']; ?>">栃木</a>
					</td>
					<td bgcolor="<? print $bg['ibaraki']; ?>" width="30">
						<a href="../#" title="<? print $title['ibaraki']; ?>">茨城</a>
					</td>
					<td width="20"></td>
				</tr>
				<tr height="25">
					<td></td>
					<td bgcolor="<? print $bg['kumamoto']; ?>">
						<a href="../#" title="<? print $title['kumamoto']; ?>">熊本</a>
					</td>
					<td bgcolor="<? print $bg['ooita']; ?>">
						<a href="../#" title="<? print $title['ooita']; ?>">大分</a>
					</td>
					<td></td>
					<td bgcolor="<? print $bg['hiroshima']; ?>">
						<a href="../#" title="<? print $title['hiroshima']; ?>">広島</a>
					</td>
					<td bgcolor="<? print $bg['okayama']; ?>">
						<a href="../#" title="<? print $title['okayama']; ?>">岡山</a>
					</td>
					<td bgcolor="<? print $bg['osaka']; ?>">
						<a href="../seminar.html#osaka-semi" title="<? print $title['osaka']; ?>">大阪</a>
					</td>
					<td bgcolor="<? print $bg['nara']; ?>">
						<a href="../#" title="<? print $title['nara']; ?>">奈良</a>
					</td>
					<td bgcolor="<? print $bg['gifu']; ?>">
						<a href="../#" title="<? print $title['gifu']; ?>">岐阜</a>
					</td>
					<td bgcolor="<? print $bg['yamanashi']; ?>">
						<a href="../#" title="<? print $title['yamanashi']; ?>">山梨</a>
					</td>
					<td bgcolor="<? print $bg['saitama']; ?>">
						<a href="../#" title="<? print $title['saitama']; ?>">埼玉</a>
					</td>
					<td bgcolor="<? print $bg['chiba']; ?>">
						<a href="../#" title="<? print $title['chiba']; ?>">千葉</a>
					</td>
				</tr>
				<tr height="24">
					<td></td>
					<td bgcolor="<? print $bg['kagoshima']; ?>">
						<a href="../#" title="<? print $title['kagoshima']; ?>">鹿児島</a>
					</td>
					<td bgcolor="<? print $bg['miyagi']; ?>">
						<a href="../#" title="<? print $title['miyazaki']; ?>">宮崎</a>
					</td>
					<td></td><td></td><td></td><td></td><td></td>
					<td bgcolor="<? print $bg['wakayama']; ?>">
						<a href="../#" title="<? print $title['wakayama']; ?>">和歌山</a>
					</td>
					<td bgcolor="<? print $bg['mie']; ?>">
						<a href="../#" title="<? print $title['mie']; ?>">三重</a>
					</td>
					<td bgcolor="<? print $bg['aichi']; ?>">
						<a href="../#" title="<? print $title['aichi']; ?>">愛知</a>
					</td>
					<td bgcolor="<? print $bg['shizuoka']; ?>">
						<a href="../#" title="<? print $title['shizuoka']; ?>">静岡</a>
					</td>
					<td bgcolor="<? print $bg['kanagawa']; ?>">
						<a href="../#" title="<? print $title['kanagawa']; ?>">神奈川</a>
					</td>
					<td bgcolor="<? print $bg['tokyo']; ?>">
						<a href="../seminar.html#tokyo-semi" title="<? print $title['tokyo']; ?>">東京</a>
					</td>
				</tr>
				<tr height="20">
					<td></td><td></td><td></td><td></td><td></td>
					<td bgcolor="<? print $bg['ehime']; ?>">
						<a href="../#" title="<? print $title['ehime']; ?>">愛媛</a>
					</td>
					<td bgcolor="<? print $bg['kagawa']; ?>">
						<a href="../#" title="<? print $title['kagawa']; ?>">香川</a>
					</td>
					</tr><tr height="20">
					<td bgcolor="<? print $bg['okinawa']; ?>">
						<a href="../#<? print $jump['okinawa']; ?>" title="<? print $title['okinawa']; ?>">沖縄</a>
					</td>
					<td></td><td></td><td></td><td></td>
					<td bgcolor="<? print $bg['kouchi']; ?>">
						<a href="../#" title="<? print $title['kouchi']; ?>">高知</a>
					</td>
					<td bgcolor="<? print $bg['tokushima']; ?>">
						<a href="../#" title="<? print $title['tokushima']; ?>">徳島</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

	<div style="border: 2px dotted navy; margin: 20px 0 10px 0; padding: 5px 10px 5px 15px; font-size:12pt;">
		全国セミナーには、どなたでもご参加できます。（無料です。）<br/>
	</div>
	<div style="border: 2px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 15px; font-size:10pt;">
		ご予約の際は「お名前」「当日連絡のつく電話番号」を明記の上、toiawase@jawhm.or.jp までご連絡下さい。<br/>
		お問い合わせも、こちらのメールアドレスまでお願いします。<br/>
	</div>

		&nbsp;<br/>
		<p>なお、全国セミナーでは、次のような内容のお話をします</p>
		<p>　・　ワーキングホリデーのビザの取得方法</p>
		<p>　・　ワーキングホリデービザで出来ること</p>
		<p>　・　ワーキングホリデーに必要なもの</p>
		<p>　・　各国の特徴</p>
		<p>　・　ワーキングホリデー最近の傾向</p>
		<p>　・　ワーキングホリデーに興味はあるけど何から始めていいのか分からない方</p>
		<p>　・　各セミナーには質疑応答時間もありますので</p>
		<p>　・　遠慮されずに積極的に質問してくださいね。</p>
		<p>　・　現地でのアルバイトやシェアハウスの見つけ方等</p>
		&nbsp;<br/>
		<p>その他、なんでもご質問にお答え致します</p>
		<p>お友達も御誘いのうえご参加くださいませ</p>
	</div>

	  <h2 class="sec-title">イベントカレンダー</h2>

<table>
	<tr>
	<td>
<?
	$yy = date('Y');
	$mm = date('n');
	calender_show($yy,$mm);
?>
	</td>
	<td width="10px">&nbsp;</td>
	<td>
<?
	$mm++;
	if ($mm > 12)	{
		$mm = 1;
		$yy++;
	}
	calender_show($yy,$mm);

?>
	</td>
	</tr>
</table>
&nbsp;<br/>


<span style="font-size:12pt;">
<a href="../#event"><img src="../images/arrow0302.gif"> イベント</a>　　
<a href="../seminar.html"><img src="../images/arrow0313.gif"> 無料セミナー</a>　　
</span>


	<h2 class="sec-title" id="event">イベントのご案内</h2>
	<div style="padding-left:30px;">
		<p>日本ワーキング・ホリデー協会では、これから出発される方・帰国された方、また、ワーキングホリデービザで来日されている外国の方を交えての交流会など、さまざまなイベントを行っております。</p>
		<p>各種イベントへのご参加・ご質問は　toiawase@jawhm.or.jp　までメールでお問い合わせください。</p>
	</div>
	<div style="padding-left:30px;">
<?
		if (count($evt_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、予定されているイベントはありません。<br/>
			</div>
<?
		}else{
			for ($idx=0; $idx<count($evt_title); $idx++)	{
				print '<div style="height:20px;" id="'.$evt_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($evt_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$evt_title[$idx].'</s>';
				}else{
					print $evt_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$evt_img[$idx].'</td>';
				print '<td><p>'.nl2br($evt_desc[$idx]).'</p></td></tr></table>';
			}
		}
?>
	</div>


	<div style="height:30px;">&nbsp;</div>



<div style="height:30px;">&nbsp;</div>
<div style="text-align:center;">
	<img src="../images/flag01.gif">
	<img src="../images/flag02.gif">
	<img src="../images/flag03.gif">
	<img src="../images/flag04.gif">
	<img src="../images/flag05.gif">
	<img src="../images/flag06.gif">
	<img src="../images/flag07.gif">
	<img src="../images/flag08.gif">
	<img src="../images/flag09.gif">
	<img src="../images/flag10.gif">
	<img src="../images/mflag11.gif" width="40" height="26">
</div>

	<div style="height:50px;">&nbsp;</div>

	</div>


	</div>
  </div>
  </div>
  <div id="footer">
    <div id="footer-box">
	<img src="../images/foot-co.gif" alt="" />
	</div>
  </div>
</body>
</html>

