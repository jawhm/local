<?

	session_start();

	list(,$para1, $para2, $para3, $para4, $para5) = explode('/', $_SERVER['PATH_INFO']);
	$c_base = $_SERVER['REQUEST_URI'];

	$c_footer = '
		<div data-role="footer" class="footer-docs" data-theme="a">
		<p>&copy; 2011- JAPAN Association for Working Holiday Makers.</p>
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
	<title>日本ワーキングホリデー協会</title> 
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
<script>
function fncyoyaku()	{

	// 入力チェック
	if (!jQuery('#namae').val())	{
		alert('お名前を入力してください。');
		jQuery('#namae').focus();
		return false;
	}
	if (!jQuery('#furigana').val())	{
		alert('フリガナを入力してください。');
		jQuery('#furigana').focus();
		return false;
	}
	if (!jQuery('#email').val())	{
		alert('メールアドレスを入力してください。');
		jQuery('#email').focus();
		return false;
	}
	if (!jQuery('#tel').val())	{
		alert('お電話番号を入力してください。');
		jQuery('#tel').focus();
		return false;
	}

	jQuery('#yoyakubtn').val('予約処理中...');
	jQuery('#yoyakubtn').button('disable');
	$senddata = $("#form_yoyaku").serialize();
	$.ajax({
		type: "POST",
		url: "http://www.jawhm.or.jp/yoyaku/yoyaku.php",
		data: $senddata,
		success: function(msg){
			alert(msg);
			location.href = '<? print $url_home; ?>';
		},
		error:function(){
			alert('通信エラーが発生しました。');
		}
	});

	return false;
}
</script>
<title>無料セミナーを探そう</title>
<body>

<?
	if ($para1 == '')	{
		// トップページを表示
?>

<div data-role="page" id="toppage">
	<div data-role="header" data-theme="a">
		<h1>無料セミナーを探そう</h1>
	</div>
	<div data-role="content">

		<div id="jqm-homeheader">
			<p>きっと見つかる　あなたにピッタリの無料セミナー</p>
		</div>
		<p class="intro">日本ワーキング・ホリデー協会が随時開催している無料セミナーに参加して、留学・ワーホリの色々な情報をGETしよう！！</p>
		<ul data-role="listview" data-inset="true" data-theme="b" data-dividertheme="b">
			<li data-role="list-divider">初めての方へ</li>
			<li><a href="/mem/mem/ana/first">日本ワーキングホリデー協会とは</a></li>
			<li><a href="/mem/mem/ana/wh">ワーキングホリデー制度について</a></li>
			<li><a href="/mem/mem/ana/mem">メンバー登録のお願い</a></li>
			<li><a target="_new" href="<? print $url_top; ?>">通常TOPページへ</a></li>
		</ul>
		<nav>
			<ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
				<li data-role="list-divider">興味のある国からセミナーを探す</li>
				<li><a href="/mem/mem/country/aus">オーストラリア</a></li>
				<li><a href="/mem/mem/country/nz">ニュージーランド</a></li>
				<li><a href="/mem/mem/country/can">カナダ</a></li>
				<li><a href="/mem/mem/country/uk">イギリス</a></li>
				<li><a href="/mem/mem/country/fra">フランス</a></li>
				<li><a href="/mem/mem/country/other">その他の国</a></li>

				<li data-role="list-divider">内容からセミナーを探す</li>
				<li><a href="/mem/mem/know/first">初心者セミナー</a></li>
				<li><a href="/mem/mem/know/foot">現地生活ガイド</a></li>
				<li><a href="/mem/mem/know/student">学生限定セミナー</a></li>
				<li><a href="/mem/mem/know/school">語学学校セミナー</a></li>
				<li><a href="/mem/mem/know/abili">資格の案内ミナー</a></li>

				<li data-role="list-divider">開催地からセミナーを探す</li>
				<li><a href="/mem/mem/place/tokyo">東京会場</a></li>
				<li><a href="/mem/mem/place/osaka">大阪会場</a></li>
				<li><a href="/mem/mem/place/sendai">仙台会場</a></li>
				<li><a href="/mem/mem/place/toyama">富山会場</a></li>
				<li><a href="/mem/mem/place/fukuoka">福岡会場</a></li>
				<li><a href="/mem/mem/place/okinawa">沖縄会場</a></li>
			</ul>
		</nav>
	</div>
	<? print $c_footer; ?>
</div>

<?
	}
	if ($para1 == 'id')	{
		// 予約ページを表示
?>
<div data-role="page" id="yoyaku<? print $para1; ?>">

	<div data-role="header" data-theme="a">
		<h1>セミナー予約フォーム</h1>
		<a href="<? print $url_home; ?>" data-icon="home" data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>

	<div data-role="content" data-theme="a">

		<h2>ご参加予定のセミナー</h2>

<?

	$formon = false;

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE id = '.$para2);
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$formon = true;

			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);
			$title	= $row['k_title1'];

			if ($row['free'] == 1)	{
				$formon = false;
				print '<a target="_blank" href="'.$url_top.'member" data-role="button" data-rel="back" data-theme="a">ご予約はこちらから</a>';
			}
			$c_desc = $row['k_desc1'];


			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
//					$formon = false;
					$c_img   	= '[満席です。キャンセル待ちとなります。]';
				}else{
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$formon = false;
				$c_img   	= '[満席です]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
//					$formon = false;
					$c_img   	= '[満席です。キャンセル待ちとなります。]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}else{
						$c_img	= '';
					}
				}
			}

			print '<div data-role="content" data-collapsed="true" data-theme="a">';
			print '<div style="color:red; font-weight:bold;">'.$c_img.'</div>';

			print '<table>';
			print '<tr><td style="vertical-align:top;"><img src="/mem/images/tama_04.gif"></td><td style="vertical-align:top;">';
			switch($row['place'])	{
				case 'tokyo':
					$place = '東京';
					break;
				case 'osaka':
					$place = '大阪';
					break;
				case 'fukuoka':
					$place = '福岡';
					break;
				case 'sendai':
					$place = '仙台';
					break;
				case 'toyama':
					$place = '富山';
					break;
				case 'okinawa':
					$place = '沖縄';
					break;
			}
			print $place.'会場</td></tr>';
			print '<tr><td style="vertical-align:top;"><img src="/mem/images/tama_04.gif"></td><td style="vertical-align:top;">'.$start.'</td></tr>';
			print '<tr><td style="vertical-align:top;"><img src="/mem/images/tama_04.gif"></td><td style="vertical-align:top;">'.$title.'</td></tr>';
			print '</table>';

			print '</div>';
			print '<p style="color:red;">';
			print '最近、会場を間違えてご予約される方が増えております。<br/>';
			print 'セミナー内容、会場、日程等を十分ご確認の上、ご予約頂けますようお願い申し上げます。';
			print '</p>';

		}

	} catch (PDOException $e) {
		die($e->getMessage());
	}
?>
		<a href="/mem/mem/<? print @$_SESSION['para1'].'/'.@$_SESSION['para2'].'/'.@$_SESSION['para3']; ?>" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>

		<h3>セミナーのご予約に際し、以下の内容をご確認ください。</h3>
		<table>
		<tr><td style="vertical-align:top;"><img src="/mem/images/b-001.gif"></td><td>このフォームでは、仮予約の受付を行います。<br/>予約確認のメールをお送りしますので、メールの指示に従って予約を確定してください。<br/>ご予約が確定されない場合、２４時間で仮予約は自動的にキャンセルされセミナーにご参加頂けません。ご注意ください。</td></tr>
		<tr><td style="vertical-align:top;"><img src="/mem/images/b-002.gif"></td><td>携帯のメールアドレスをご使用の場合、info@jawhm.or.jp からのメール（ＰＣメール）が受信できるできる状態にしておいてください。</td></tr>
		<tr><td style="vertical-align:top;"><img src="/mem/images/b-003.gif"></td><td>Ｈｏｔｍａｉｌ、Ｙａｈｏｏメールなどをご利用の場合、予約確認のメールが遅れて到着する場合があります。時間をおいてから受信確認を行うようにしてください。</td></tr>
		<tr><td style="vertical-align:top;"><img src="/mem/images/b-004.gif"></td><td>予約確認メールが届かない場合、toiawase@jawhm.or.jp までご連絡ください。<br/>なお、迷惑フォルダ等に分類される場合もありますので、併せてご確認ください。</td></tr>
		</table>

<?
	if ($formon)	{
?>

	<br/>
	<form action="/mem/mem/book" method="post" id="form_yoyaku" data-ajax="false" onsubmit="return(fncyoyaku());">

		<span style="color:red;font-weight:bold;">●</span>印の項目は必ずご入力ください。

		<input type="hidden" name="セミナー番号" id="seminarno" value="<? print $para2; ?>" />
		<input type="hidden" name="セミナー名" id="seminarname" value="<? print '['.$place.'S]'.$start.' '.$title; ?>" />

		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>お名前</legend>
				<input type="text" name="お名前" id="namae" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>フリガナ</legend>
				<input type="text" name="フリガナ" id="furigana" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>メールアドレス</legend>
				<input type="text" name="メール" id="email" value="" /><br/>
				※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>当日連絡の付く電話番号</legend>
				<input type="text" name="電話番号" id="tel" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>興味のある国</legend>
				<input type="text" name="興味国" id="country" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>出発予定時期</legend>
				<input type="text" name="出発時期" id="jiki" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>同伴者有無</legend>
				<input type="checkbox" name="同伴者" id="dohan" class="custom" />
				<label for="dohan">同伴者あり</label>
				※同伴者ありの場合、２人分の席を確保致します。<br/>
				※３名以上でご参加の場合は、メールにてご連絡ください。
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>今後のご案内</legend>
				<input type="checkbox" name="メール会員" id="mailkaiin" class="custom" checked />
				<label for="mailkaiin">このメールアドレスをメール会員（無料）に登録する</label>
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>その他</legend>
				<input type="text" name="その他" id="sonota" value="" />
			</fieldset>
		</div>

		<input type="submit" data-role="button" data-rel="back" data-theme="c" id="yoyakubtn" value="予約する(無料)">

	</form>

<?	}	?>

		<br/>
		<a href="/mem/mem/<? print @$_SESSION['para1'].'/'.@$_SESSION['para2'].'/'.@$_SESSION['para3']; ?>" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>
		<br/>
	</div>
	<? print $c_footer; ?>
</div>


<?
	}else{

	if ($para1 == 'ana')	{
		// 情報ページ表示
?>
<?
		switch($para2)	{
			case 'first':
?>
<div data-role="page" data-content-theme="a" id="ana<? print $para2; ?>">
	<div data-role="header" data-theme="a">
		<h1>日本ワーキングホリデー協会とは</h1>
		<a href="<? print $url_home; ?>" data-icon="back" data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>
	<div data-role="content">
<h2>ご挨拶</h2>
<p>
ワーキング・ホリデー制度は日本の若者が協定国で1年間（国によって2年間）も働ける、生活できる、勉強できるという特別なビザです。 
このワーキング・ホリデービザを利用し海外に渡航する日本人が増え、来日する外国人も増えて両国間の相互理解、国際交流が盛んになるよう活動していております。
また昨今の日本人のコミュニケーション能力の低さ、海外へ行きたがらない若者たち、ひいては就職率の低下を改善するためにもワーキング・ホリデービザを利用してもらい
海外で英語能力、コミュニケーション能力、バイタリティー、国際知識、世界中への友達を作って帰って来てもらい将来の明るい日本を創造できる人材の育成にも力を入れていきます。<br/>
&nbsp;<br/>
一般社団法人日本ワーキング・ホリデー協会<br/>
　　理事長　池口洲<br/>
</p>

<h2>当協会の活動について</h2>
<p>
ワーキング・ホリデー制度をより多くの方に利用して海外での生活を体験して頂くため、当協会では無料セミナーを初めとした啓蒙活動を行っております。
留学やワーキングホリデーは、海外に出ることだけでなく、その期間に行った内容が求められる時代となっています。より楽しく有意義な海外生活を送るためのプラン作成（カウンセリング）と、それに必要な情報提供を行っております。<br/>
また、ワーキング・ホリデー制度は、各国との相互協定ですので、日本人が海外に行くばかりでなく、海外の方が日本に同様のビザを用いて来る事が可能です。
その際のお仕事紹介など海外の方へのサポートも行っております。
</p>


	</div>
</div>
<?
			break;
			case 'wh':
?>
<div data-role="page" data-content-theme="a" id="ana<? print $para2; ?>">
	<div data-role="header" data-theme="a">
		<h1>ワーキングホリデー制度について</h1>
		<a href="<? print $url_home; ?>" data-icon="back" data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>
	<div data-role="content">
<h2>ワーキングホリデーとは</h2>
<p>
ワーキングホリデーってなんとなく聞いたことはあったけど周りで行った人いないし、海外は怖そうだし・・・　行って意味があるのかな？　なんて声はよく聞きます。　ワーキングホリデーを知ったからには是非参加するべきです。　そしてちゃんと情報集めをすれば安全ということも理解できるし、人生の中で一番楽しいそして自分の価値観をも変えてしまう体験になるという期待に変わるでしょう。　
1980年12月に初めてオーストラリアと日本の間で始まったワーキングホリデー協定は2010年で30年を迎えました。30年前は飛行機代が給料の6カ月分かかったものが現在では3万円台からあったり、インターネットの普及で情報も多く得られるようになり渡航しやすくなりました。　ワーキングホリデーとは海外旅行とは違い長期滞在の許されるビザです。１８歳から３０歳の日本国民なら　日本とワーキングホリデー協定を結んだ外国に1～2年の滞在許可が下り、その間に就学、旅行、就労と生活することが許されているとても貴重な制度といえます。　通常観光は許されていても同時に働くことは許されず、また就学、留学時に働くこともあまり許されないことを考えると、現地にて語学の勉強をしながら働いたり、働きながら旅行をしたりということが出来るのはワーキングホリデービザだけです。（オーストラリア、ニュージーランドでは留学生も働くことが許されている。）　ただお金の為に働くのではなく海外の文化に溶け込むためにもこの働けるワーキングホリデービザというのはとても価値の高いものといえます。　　１８歳から３０歳での申請が可能ですのでこの１２年間のうちに１１カ国の国にすべて行きオーストラリアやイギリスは２年間滞在可能なので約１５年間海外でワーキングホリデーが出来る計画も立てられます。　面白いですねそうすると３３歳でワーキングホリデーをしていて　１８歳から３４歳手前まで海外生活ということになります。
３０年前にオーストラリアと始まったこのワーキングホリデー制度は５年後にニュージーランドと日本が始まり、その翌年にカナダも始まりました。若い人のイメージの強いワーキングホリデーですが、ワーキングホリデーで最初に行った方が当時２５歳で申請し２６歳でオーストラリアに滞在していたのであれば３０年を迎えた２０１０年には５６歳になっていらっしゃるかもしれません。　すでにのべ４０万人の日本人が参加しておりワーキングホリデー先輩の中には政治家やモデルさんや企業の社長さんもいらっしゃいます。
最近の傾向はやはりリーマンショックの後に変更が見られ、海外で働いてスキルを付ける為、TOEICで９００点取るため、児童英語教師をとるため、海外で起業する為にワーキングホリデービザを利用する方が増えているように思われます。　リーマンショック前までは海外で住んでみたかったというのが圧倒的に多かったように感じます。　またワーキングホリデー終了後も海外でそのまま学生ビザで延長滞在、シンガポールで就職するなど海外で活躍の場を求める方も多くなってきています。　そういう将来を見据えている方にお勧めな方法は最初学生ビザを取得し１年間で語学をのばし、語学が伸びた後にワーキングホリデービザで現地の人と同じ現場で同じように働き、海外での就職経験とスキルを身につけて日本や諸外国でチャレンジするという利用方法もあります。特に外資系や海外では経験があるかないかが勝負のわかれどころになります。ワーキングホリデーはそういう時に働けるビザという強みが生かして海外での就職経験を付けるのに最適なビザと言えます。　どうぞご相談ください。
</p>


	</div>
</div>
<?
			break;
			case 'mem':
?>
<div data-role="page" data-content-theme="a" id="ana<? print $para2; ?>">
	<div data-role="header" data-theme="a">
		<h1>メンバー登録のお願い</h1>
		<a href="<? print $url_home; ?>" data-icon="back" data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>
	<div data-role="content">

	<h2>メンバー登録はワーホリ成功の第一歩</h2>
	<p>
	ワーキングホリデーや留学に興味があるけれど、海外で何ができるのか？ 何をしなければいけないのか？ どんな準備や手続きが必要なのか？ どのくらい費用がかかるのか？ 渡航先で困ったときはどうすればよいのか？ 解らない事が多すぎて、もっと解らなくなってしまいます。
	そんな皆様を支援するために当協会では、ワーホリ成功のためのメンバーサポート制度をご用意しています。 当協会のメンバーになれば、個別相談をはじめビザ取得のお手伝い、出発前の準備、到着後のサポートまで、フルにサポートさせていただきます。<br/>
	</p>

<h2>メンバー登録で５つのメリット</h2>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
	<h3>個別相談（カウンセリング）の実施</h3>
	<p>
	■　帰国後に差がつく、実り多いワーホリのために<br/>
	ワーキングホリデーや留学の方法、滞在先での過ごし方などは人それぞれです。 そこで、実り多いワーホリ体験をするためには、計画と目標を明確にすることが、まず必要なことです。
	当協会では、カウンセリングを通じて、一人一人に最適なプラン作りを支援することが最も重要と考え、ワーキングホリデーや留学を成功させる為に、 カウンセリングは最も重要なサービスと考えておりますので、何度でもご自身で納得するまで相談してください。 
	</p>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
	<h3>特別セミナーへのご参加</h3>
	<p>
	当協会では、初めてワーキングホリデーに行かれる方向けの無料セミナーを実施しておりますが、 それ以外に看護師向けセミナー、大学進学セミナーなどの専門別のセミナーや、 現地での仕事や住まいの探し方など具体的な暮らし方に関するセミナー、 持っていくと便利なもののご案内や必要書類の確認をする、出発直前の方向けセミナーなど、より実践的なセミナーを実施しております。 
	</p>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
	<h3>ワーキングホリデービザ取得のお手伝い</h3>
	<p>
	ビザの申請には語学力が求められます。各国のワーキングホリデービザを取得する為に必要な書類のご案内や、その書き方などをご説明しております。 ワーキングホリデービザは、１国で１回しか取得することのできない貴重なビザですので、間違いの無いように手続きしましょう。 また、１国で１回しか取れない貴重なビザだからこそ、本当にワーキングホリデービザを利用して渡航するのが適切なのか などの説明・相談もしております。ワーキングホリデービザを有効活用できる方法をご相談ください。 
	</p>
	<p>
	（　ご注意　：　ビザ取得についてはサポートであり、代行申請ではありません。　）
	</p>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
	<h3>メンバー専用ページのご提供</h3>
	<p>
	メンバー専用ページから、特別セミナーのご予約を行うことができます。
	また、通常、東京・大阪で開催している各種セミナーをオンラインで見ることができます。
	</p>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
	<h3>その他、出発前・到着後、色々な事をお手伝いします</h3>
	<p>
	　・　格安航空券のご案内<br/>
	　・　宿泊先等のご案内と手配<br/>
	　・　各種学校のご案内と手配<br/>
	　・　ワーキングホリデー・留学仲間との情報交換会<br/>
	　・　外国人ワーキングホリデーとの交流会<br/>
	　・　帰国後のご相談<br/>
	　・　２カ国目のワーキングホリデービザ相談<br/>
	　・　現地オフィスによる現地情報・学校情報の提供<br/>
	　・　世界各地のサポートオフィスの利用<br/>
	</p>
	<p>
	［ご注意］<br/>
	渡航国によってはサポート対象外となる場合があります。
	詳しい内容については、お問い合わせください。
	</p>
</div>

	<a data-role="button" data-theme="b" target="_blank" href="<? print $url_top; ?>mem/register.php">メンバー登録はこちら</a>

	</div>
</div>
<?
			break;
		}		?>

<?
	}else{
		// 各ページを表示
?>

<div data-role="page" id="serpage<? print $para1.$para2.$para3; ?>">
	<div data-role="header" data-theme="a">
		<h1>無料セミナーを探そう</h1>
		<a href="<? print $url_home; ?>" data-icon="home" data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>
	<div data-role="content">

		<?
			if ($para1 == 'place')	{
				$para3 = $para2;
			}else{
				if ($para3 == '')	{
					$para3 = 'tokyo';
				}
		?>
				<p>会場選択</p>
			<nav>
				<ul data-role="controlgroup" data-type="horizontal" class="localnav">
					<li><a data-theme="a" style="font-size:14pt;" href="/mem/mem/<? print $para1.'/'.$para2; ?>/tokyo" data-role="button" data-transition="fade"<? if ($para3 == 'tokyo') { print ' class="ui-btn-active"'; } ?>>東京</a></li>
					<li><a data-theme="a" style="font-size:14pt;" href="/mem/mem/<? print $para1.'/'.$para2; ?>/osaka" data-role="button" data-transition="fade"<? if ($para3 == 'osaka') { print ' class="ui-btn-active"'; } ?>>大阪</a></li>
					<li><a data-theme="a" style="font-size:14pt;" href="/mem/mem/<? print $para1.'/'.$para2; ?>/sendai" data-role="button" data-transition="fade"<? if ($para3 == 'sendai') { print ' class="ui-btn-active"'; } ?>>仙台</a></li>
					<li><a data-theme="a" style="font-size:14pt;" href="/mem/mem/<? print $para1.'/'.$para2; ?>/toyama" data-role="button" data-transition="fade"<? if ($para3 == 'toyama') { print ' class="ui-btn-active"'; } ?>>富山</a></li>
					<li><a data-theme="a" style="font-size:14pt;" href="/mem/mem/<? print $para1.'/'.$para2; ?>/fukuoka" data-role="button" data-transition="fade"<? if ($para3 == 'fukuoka') { print ' class="ui-btn-active"'; } ?>>福岡</a></li>
					<li><a data-theme="a" style="font-size:14pt;" href="/mem/mem/<? print $para1.'/'.$para2; ?>/okinawa" data-role="button" data-transition="fade"<? if ($para3 == 'okinawa') { print ' class="ui-btn-active"'; } ?>>沖縄</a></li>
				</ul>
			</nav>
		<?	}	?>

		<?
			switch ($para1.$para2)	{
				case 'countryaus':
					print '<h2>オーストラリアのセミナー</h2>';
					break;
				case 'countrynz':
					print '<h2>ニュージーランドのセミナー</h2>';
					break;
				case 'countrycan':
					print '<h2>カナダのセミナー</h2>';
					break;
				case 'countryuk':
					print '<h2>イギリスのセミナー</h2>';
					break;
				case 'countryfra':
					print '<h2>フランスのセミナー</h2>';
					break;
				case 'countryother':
					print '<h2>その他の国のセミナー</h2>';
					break;
				case 'knowfirst':
					print '<h2>初心者セミナー</h2>';
					print '<p>初めてセミナーにご参加される場合にお勧めのセミナーです。</p>';
					break;
				case 'knowfoot':
					print '<h2>現地生活ガイド</h2>';
					print '<p>現地でのお仕事、お住まいの探し方、その注意点などを説明するセミナーです。</p>';
					break;
				case 'knowstudent':
					print '<h2>学生限定セミナー</h2>';
					print '<p>就職前の学生時代に海外を体感する事の重要性を説明するセミナーです。</p>';
					break;
				case 'knowschool':
					print '<h2>語学学校セミナー</h2>';
					print '<p>語学学校の必要性や、様々な特徴のある語学学校を紹介するセミナーです。</p>';
					break;
				case 'knowabili':
					print '<h2>資格の案内セミナー</h2>';
					print '<p>海外で取れる資格のご案内や、資格が取れる学校を紹介するセミナーです。</p>';
					break;
				case 'placetokyo':
					print '<h2>東京会場のセミナー</h2>';
					break;
				case 'placeosaka':
					print '<h2>大阪会場のセミナー</h2>';
					break;
				case 'placesendai':
					print '<h2>仙台会場のセミナー</h2>';
					break;
				case 'placetoyama':
					print '<h2>富山会場のセミナー</h2>';
					break;
				case 'placefukuoka':
					print '<h2>福岡会場のセミナー</h2>';
					break;
				case 'placeokinawa':
					print '<h2>沖縄会場のセミナー</h2>';
					break;


			}
		?>

			<br/>


<?

	// イベント読み込み
	$cal = array();

	$tyo_ymd   = array();
	$tyo_title = array();
	$tyo_desc  = array();
	$tyo_img   = array();
	$tyo_btn   = array();
	$tyo_id	   = array();

	$osa_ymd   = array();
	$osa_title = array();
	$osa_desc  = array();
	$osa_img   = array();
	$osa_btn   = array();
	$osa_id	   = array();

	$oka_ymd   = array();
	$oka_title = array();
	$oka_desc  = array();
	$oka_img   = array();
	$oka_btn   = array();
	$oka_id	   = array();

	$fuk_ymd   = array();
	$fuk_title = array();
	$fuk_desc  = array();
	$fuk_img   = array();
	$fuk_btn   = array();
	$fuk_id	   = array();

	$sen_ymd   = array();
	$sen_title = array();
	$sen_desc  = array();
	$sen_img   = array();
	$sen_btn   = array();
	$senid	   = array();

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
//		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat FROM event_list WHERE k_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');

		// パラメータ確認
		$where_place = '';
		$where_country = '';
		$where_know = '';

		if ($para1 == 'country')	{
			if ($para2 == 'other')	{
				$where_country .= ' ( k_title1 not like  \'%オーストラリア%\' ';
				$where_country .= '  and k_title1 not like  \'%ニュージーランド%\' ';
				$where_country .= '  and k_title1 not like  \'%カナダ%\' ';
				$where_country .= '  and k_title1 not like  \'%イギリス%\' ';
				$where_country .= '  and k_title1 not like  \'%フランス%\' ';
				$where_country .= '  and k_title1 not like  \'%英語圏%\' ';
				$where_country .= '  and k_desc1 not like  \'%オーストラリア%\' ';
				$where_country .= '  and k_desc1 not like  \'%ニュージーランド%\' ';
				$where_country .= '  and k_desc1 not like  \'%カナダ%\' ';
				$where_country .= '  and k_desc1 not like  \'%イギリス%\' ';
				$where_country .= '  and k_desc1 not like  \'%フランス%\' ';
				$where_country .= '  and k_desc1 not like  \'%英語圏%\' ';
				$where_country .= '  and k_desc2 not like  \'%オーストラリア%\' ';
				$where_country .= '  and k_desc2 not like  \'%ニュージーランド%\' ';
				$where_country .= '  and k_desc2 not like  \'%カナダ%\' ';
				$where_country .= '  and k_desc2 not like  \'%イギリス%\' ';
				$where_country .= '  and k_desc2 not like  \'%フランス%\' ';
				$where_country .= '  and k_desc2 not like  \'%英語圏%\' ) ';
			}else{
				switch ($para2)	{
					case 'aus':
						$val = 'オーストラリア';
						break;
					case 'nz':
						$val = 'ニュージーランド';
						break;
					case 'can':
						$val = 'カナダ';
						break;
					case 'uk':
						$val = 'イギリス';
						break;
					case 'fra':
						$val = 'フランス';
						break;
				}
				$where_country .= ' ( k_title1 like \'%'.$val.'%\' ';
				$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
				$where_country .= ' or k_desc2 like \'%'.$val.'%\' ) ';
			}
		}

		if ($para1 == 'know')	{
			switch ($para2)	{
				case 'first':
					$val = '初心者';
					break;
				case 'foot':
					$val = '現地生活ガイド';
					break;
				case 'student':
					$val = '学生限定';
					break;
				case 'school':
					$val = '語学学校';
					break;
				case 'abili':
					$val = '資格';
					break;
			}
			$where_country .= ' ( k_title1 like \'%'.$val.'%\' ';
			$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
			$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';

			if ($val == '現地生活ガイド')	{
				$where_country .= ' or k_title1 like \'%歩き方%\' ';
				$where_country .= ' or k_desc1 like \'%歩き方%\' ';
				$where_country .= ' or k_desc2 like \'%歩き方%\' ';
				$where_country .= ' or k_title1 like \'%安心生活%\' ';
				$where_country .= ' or k_desc1 like \'%安心生活%\' ';
				$where_country .= ' or k_desc2 like \'%安心生活%\' ';
			}
			$where_country .= ' ) ';


		}

		$where_place = ' ( place = \''.$para3.'\' ) ';


		$keyword  = '';
		if ($where_place <> '')	{
			$keyword .= ' and '.$where_place;
		}
		if ($where_country <> '')	{
			$keyword .= ' and '.$where_country;
		}
		if ($where_know <> '')	{
			$keyword .= ' and '.$where_know;
		}

		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE k_use = 1 and free = 0 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.' ORDER BY hiduke, starttime, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);
			
			$title	= $start.' '.$row['k_title1'];

			if ($row['place'] == 'tokyo')	{
				// 東京
				$tyo_id[] = $row['id'];
				$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title = '<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$tyo_title[]	= $title.$c_title;
				$tyo_desc[]	= $c_desc;
				$tyo_img[]	= $c_img;
				$tyo_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　東京会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}

			if ($row['place'] == 'osaka')	{
				// 大阪
				$osa_id[] = $row['id'];
				$osa_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$osa_title[]	= $title.$c_title;
				$osa_desc[]	= $c_desc;
				$osa_img[]	= $c_img;
				$osa_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　大阪会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}

			if ($row['place'] == 'fukuoka')	{
				// 福岡
				$fuk_id[] = $row['id'];
				$fuk_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[福岡]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[福岡]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[福岡]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[福岡]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$fuk_title[]	= $title.$c_title;
				$fuk_desc[]	= $c_desc;
				$fuk_img[]	= $c_img;
				$fuk_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　福岡会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}

			if ($row['place'] == 'sendai')	{
				// 仙台
				$sen_id[] = $row['id'];
				$sen_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$sen_title[]	= $title.$c_title;
				$sen_desc[]	= $c_desc;
				$sen_img[]	= $c_img;
				$sen_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　仙台会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}




			if ($row['place'] == 'sendai')	{
				// 仙台
				$sen_id[] = $row['id'];
				$sen_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[仙台]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$sen_title[]	= $title.$c_title;
				$sen_desc[]	= $c_desc;
				$sen_img[]	= $c_img;
				$sen_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　仙台会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}




			if ($row['place'] == 'toyama')	{
				// 富山
				$sen_id[] = $row['id'];
				$sen_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[富山]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[富山]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[富山]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[富山]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$sen_title[]	= $title.$c_title;
				$sen_desc[]	= $c_desc;
				$sen_img[]	= $c_img;
				$sen_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　富山会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}

			if ($row['place'] == 'okinawa')	{
				// 沖縄
				$oka_id[] = $row['id'];
				$oka_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_title	= $title.'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/new.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$c_title = '';
					}
				}else{
					$c_title = '';
				}
				$c_desc  = $row['k_desc1'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$c_btn	= '[メンバー限定]';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[沖縄]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}

				$oka_title[]	= $title.$c_title;
				$oka_desc[]	= $c_desc;
				$oka_img[]	= $c_img;
				$oka_btn[]	= $c_btn;

				if ($c_img <> '')	{
					$c_img = '<h3 style="color:red;">'.$c_img.'</h3>';
				}

				$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
				$c_msg  = '<li><a href="/mem/mem/id/'.$row['id'].'">';
				$c_msg .= $c_img;
				$c_msg .= '<h3>'.$row['starttime'].'～　沖縄会場</h3>';
				$c_msg .= '<h3>'.$row['k_title1'].'</h3>';
				$c_msg .= '<p style="margin-left:30px;">'.$c_title.nl2br($c_desc).'<br/></p>';
				$c_msg .= '</a></li>';

				$cal_msg[$year.$month.$day] .= $c_msg;
				$cal_cnt[$year.$month.$day]++;
			}

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


function calender_list()	{

	global $cal;
	global $cal_msg;
	global $cal_cnt;

	$year = date('Y');
	$month = date('n');
	$day  = date('d');
	$day = $day - date('w');

	$yobi = array ('日','月','火','水','木','金','土');

	for($i=$day;$i<=$day + 150;$i++){
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		if (@$cal[date('Ynj', $print_today)] <> '')	{
			print '<ul data-role="listview" data-theme="a" data-content-theme="c">';
			print '<li data-role="list-divider">'.date('n月j日 ('.$yobi[date('w', $print_today)].')', $print_today).'<span class="ui-li-count">'.$cal_cnt[date('Ynj', $print_today)].'</span></li>';
			print ''.$cal_msg[date('Ynj', $print_today)].'';
			print '</ul>';
		}
	}

}

?>

<?
	if ($cnt == 0)	{
		print '<p>該当するセミナーがありません。検索条件を変更してください。</p>';
	}else{
		print '<p>'.$cnt.'件のセミナーがあります。</p>';
	}
	print '<br/>';

	calender_list();

?>

			<br/>
			<p>
				セミナーに参加されるほとんどの方が、お一人でのご参加です。<br/>
				どうぞ、お気軽にご予約の上、ご参加ください。<br/>
			</p>

	</div>
	<? print $c_footer; ?>
</div>

<?
		}
	}
?>

</body>
</html>
