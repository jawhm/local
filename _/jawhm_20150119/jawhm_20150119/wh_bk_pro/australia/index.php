<?php
require_once '../../include/header.php';
require_once '../../include/links.php';

$links_obj = new Links();
$header_obj = new Header();


$header_obj->title_page='オーストラリアでワーキングホリデー';
$header_obj->description_page='オーストラリアへワーキングホリデー（ワーホリ）や留学に行く方向けに準備・手続きの手順をご案内しています。その他様々な国でワーホリのビザの取得が可能で、最新のビザ取得方法や渡航情報などを発信しています。また、各種無料セミナーも開催しています。';
$header_obj->keywords_page ='オーストラリア,ワーキングホリデー,ワーホリ,留学,ビザ,方法';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

if ($header_obj->computer_use() === false && $_SESSION['pc'] != 'on') {
	$header_obj->add_css_files = '<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" /><link href="/sp/accordion/sp.css" rel="stylesheet" type="text/css" />';
	$header_obj->add_js_files = '<script src="/sp/accordion/sp.js" type="text/javascript"></script>';
}

$header_obj->fncMenuHead_imghtml='<img id="top-mainimg" src="../../../images/mainimg/AU-countrypage.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text='オーストラリアでワーキングホリデー | ワーホリについて';

$header_obj->display_header();

include('../../calendar_module/mod_event_horizontal.php');

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="http://www.jawhm.or.jp/system.html" class="wh_menu"><img src="../../images/label_big_01.jpg"><br/>ワーホリって何？</a></div>
			<div class="wh_div"><a href="../tame.php" class="wh_menu"><img src="../../images/label_big_02.jpg"><br/>ワーホリのタメになる話</a></div>
			<div class="wh_div"><a href="http://www.jawhm.or.jp/visa/v-aus.html" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>ワーホリビザの申請手順</a></div>
			<div class="wh_div"><a href="../canada/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>カナダのワーホリ</a></div>
		</div>
	</div>
	<div style="clear:both; height:10px;">&nbsp;</div>

	<div class="step_title">
		オーストラリアでワーキングホリデー
	</div>
	  <p class="text01">初めての海外でも安全で安心のオーストラリア。生きた英語と豊な自然を堪能できるオーストラリアでのワーキングホリデー生活。</p>
	  <table class="tableofcontents">
	    <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1-1">なぜオーストラリアでワーホリ（ワーキングホリデー）なのか？</a></li>
			  <li><a href="#st1-2">オーストラリアの英語と国民性</a></li>
			  <li><a href="#st1-3">オーストラリア・ワーキングホリデーの楽しみ方</a></li>
			  <li><a href="#st1-4">オーストラリア・ワーキングホリデービザの特長</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>



	<h2 id="st1-1" class="sec-title">なぜオーストラリアでワーホリ（ワーキングホリデー）なのか？</h2>
	<p class="text01">
	オーストラリアと言って、みなさんは何を思い浮かべますか？コアラ、カンガルー、エアーズロック、グレートバリアリーフ...<br/>
	広大な大地に広がる、とても美しい自然。世界中でもオーストラリアでしか出会えない動植物。そして、世界遺産として１７カ所もの登録がある大自然がいっぱいのオーストラリア。<br/>
	ワーキングホリデーの魅力は、滞在期間中、自由な行動がとれること。仕事をするのもいいし、語学や資格の勉強をするのもいい。そして、短期の観光旅行では味わえない異文化交流とゆったりとした観光が出来ること。<br/>
	オーストラリアは古くから多様な移民を受け入れ、それら様々な文化が融合した独自の文化を作り上げてきた国でもあります。単一民族である、われわれ日本人にとって多くの異文化と触れ合うことは、これからますます国際化が進む時代を生き抜く為に、とても貴重な経験になるはずです。<br/>
	</p>
	<p class="text01">
	ワーキングホリデーでオーストラリアに行くという事は、オーストラリアで暮すという事になりますが、暮す上で一番大切な事は、安全である事。
	最近の日本でも凶悪な犯罪が増えてきていると言われてはいますが、それでも世界的に見ればとても安全な国の１つです。オーストラリアも日本に負けず劣らず、大変治安の良い国です。
	また、衛生面及び医療面においてもオーストラリアは世界最高水準の国であると言えます。海外で水道水がそのまま飲める国は本当に少ないです。そして、オーストラリアには日本語が通じる病院も多くありますので、万一の場合でも安心して治療を受けることができます。<br/>
	ワーキングホリデー生活を安心・安全に楽しむ事ができる国、それがオーストラリアです。<br/>
	</p>
	<center><img src="../img/ausmap.gif" alt="オーストラリアの地図"></center>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'オーストラリア';
	$number_to_display = '2';
	$start_display_from = ''; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<h2 id="st1-2" class="sec-title">オーストラリアの英語と国民性</h2>
	<p class="text01">
	ワーキングホリデーでオーストラリアに行く目的の１つに、語学の習得があります。いまどき英語の１つも喋れないとやっていけないよ。と言われ始めて何年経つでしょうか？人・物・金が世界中を簡単に移動できる現代において、より一層の国際化は否めません。
	そこで必要なのが英語になるかと思いますが、言語を学ぶ事はその国の文化を学ぶ事でもあります。もともとオーストラリアはイギリスの植民地でした。そこでオーストラリアでは、英語が母国語として使用されています。
	しかし、イギリスやアメリカに比べてオーストラリアの英語は解りやすいとも言われます。それは、オーストラリアが多民族国家であることがその要因でしょう。オーストラリアでは、言葉の違う民族同士が、より確実・簡単にコミュニケーションを図るために解りやすい英語が使われるようになった。
	言い換えると、もともと英語が母国語ではない方も多く暮らしている国、オーストラリア。言語・語学習得の苦労も分かち合え、つたない語学力であっても、それを受け入れ理解してくれる文化がオーストラリアにはあります。これは、オーストラリアで英語を勉強し上達させる上で、大変重要な要素です。
	</p>
	<p class="text01">
	また、オーストラリアは古くから移民を受け入れてきたという歴史もあり、オーストラリア国民にとっても、他の国の人々と暮らし、仕事や勉強をするという事は、まったく違和感のない事です。
	そしてオーストラリア政府は、外国語教育として日本語・インドネシア語・韓国語・中国語などのアジア諸国の言語を重視しています。特に日本語教育に力を入れており日本語が話せるオーストラリア人も多くいます。
	もし日本語が話せなかったとしても、オーストラリア人にとって日本は大変興味のある国であり、親日家も大変多いです。これが、オーストラリアの国民性です。
	</p>
	<p class="text01">
	ここでオーストラリアの噂話について１つ触れておきましょう。それは「オーストラリアの英語はなまっている」という話です。<br/>
	このような話を皆さんは聞いたことがあると思いますが、本当の所はどうなんでしょうか...<br/>
	簡単に言ってしまえば、オーストラリアの英語は、なまってます。但し、正確にはオーストラリアの人々は、なまったような言い回しを、オーストラリア国民の個性としてしている。という所でしょうか。<br/>
	日本語でも地方や年代によっては、強いなまりがあり、日本人でも聞き取れなかったり、解らなかったする事があると思います。また、通常の言い回しは同じでも、イントネーションが多少違ったり、語尾が異なったりします。
	これは、日本でもオーストラリアでも同じ事です。
	英語も日本語も言語である為、時代と共に変わっていくものです。テレビのアナウンサーが使う言葉。若者が好んで使う言葉。その地域の文化に基づいた言葉。
	これは、世界中どこでもあることです。なまった英語を勉強するなんて絶対に嫌だ！！オーストラリアで英語勉強なんて嫌だ！！と思って、イギリスやアメリカに行ったからといっても、その場所・場所での言い回し。つまりは、何らかしらの「なまり」があるものです。
	なまりは、オーストラリアだけのものでは無いという事です。
	</p>
	<p class="text01">
	これから世界中の多くの人が、より一層英語を話すようになり、英語でのコミュニケーションを行う時代が来るでしょう。<br/>
	そうすると、英語が母国語でない人が話す英語が世界中に多くなります。言葉は人と人との意思伝達の手段です。いくら綺麗な英語が話せたとしても、相手に通じなければ意味がありません。アメリカ人だけ、イギリス人にだけ、オーストラリア人にだけしか通じない英語を学んでも、これからは意味が無いのです。
	多民族国家であるオーストラリアで、いろいろな人の英語に多く触れる。オーストラリア人の英語を勉強することも必要ですが、これが、これからの英語の勉強法と言えるでしょう。
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'オーストラリア';
	$number_to_display = '2';
	$start_display_from = '2'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st1-3" class="sec-title">ワーキングホリデーの楽しみ方</h2>
	<p class="text01">
	ワーキングホリデーの魅力として、滞在期間中、自由な行動をとることが出来ます。<br/>
	通常、日本人が海外に行く場合、ビザ（査証）を取得する必要があります。ハワイ(※１)や韓国に旅行に行く場合、ビザ申請を明確に行い取得する事は無いと思いますが、これは渡航が短期間であり、その目的が観光など限定された行為の場合には、ビザの申請・取得を免除するという協定が既に存在するからです。<br/>
	</p>
	<p class="text01">
	外国人（オーストラリア人以外）がオーストラリアに行く場合、オーストラリアへの渡航目的及び期間を明確にして、必要なビザ（査証）(※２)の取得が必要です。<br/>
	つまり、観光目的でオーストラリアに入国する場合は観光ビザ、語学留学など勉強を目的でオーストラリアに入国する場合は学生ビザ、仕事を目的でオーストラリアに入国する場合は就労ビザを申請し取得する必要があります。ワーキングホリデーもこれらオーストラリアのビザの種類の１つになります。<br/>
	しかし、ワーキングホリデービザの場合、滞在期間は１２ヶ月(※３)以内と規定されているものの、その目的は自由。つまりはオーストラリア国内で、観光も勉強も仕事も自由(※４)に行うことが出来ます。<br/>
	そんな事か...　と思われる方もいるかもしれませんが、ワーキングホリデービザような自由な行動がとれるビザは、大変珍しく、大変貴重なものなのです。オーストラリアに感謝です。
	</p>
	<p class="text01">
	逆に、ワーキングホリデービザは自由であるが故に、せっかくのオーストラリア生活を満喫できず、大切なワーキングホリデービザを有効的に活用できない方が居る事も事実です。１８歳から３０歳までの方のみ、しかも一生に一回(※５)のこのチャンスを皆さんは是非活用して有意義なワーキングホリデー生活をオーストラリアで送ってください。<br/>
	ワーキング（仕事）とホリデー（休暇・交流）でワーキングホリデーです。仕事（ワーキング）も遊び（ホリデー）もめいいっぱい楽しんでください。
	</p>
	<p class="text01">
	ここで１つのワーキングホリデー生活１年間のプランを紹介します。（オーストラリア版）<br/>
	</p>
	<table class="nittei">
		<tr>
			<td class="nittei_span">
				<p>滞在期間</p> １～３ヶ月目
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					まずは英語を勉強する！！
				</div>
				<div class="nittei_setumei">
					語学力が心配な場合は、初めに語学学校で英語の勉強する事をおススメします。<br/>
					日常生活にも言葉は必要ですが、これからの１２ヶ月のワーキングホリデー滞在を有効的に暮す為には、オーストラリアの方との交流が不可欠です。
					また、仕事をする場合、円滑なコミュニケーションがとれなければ面接すら通れません。
					仕事（ワーキング）も交流（ホリデー）もしないのであれば、ワーキングホリデーをする意味が無くなってしまいます。<br/>
					そして、語学学校に行くメリットとして友達が沢山出来る点も忘れてはいけません。
					オーストラリアに限らず海外はコネ社会です。
					これからの仕事探しや、家探しなど、遊び以外の場面でも人とのコネクションは大変重要です。<br/>
					色々な特色をもった語学学校がオーストラリアには沢山あり、それらの中から自分に合った学校を選ぶのはとても難しいと思います。
					まずは、<a href="http://www.jawhm.or.jp/seminar.html">無料セミナー</a>にご参加頂き、様々な情報収取を行ってください。<br/>
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				<p>滞在期間</p> ４～６ヶ月目
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					ワーキングホリデーだから、仕事でもしてみるか！！
				</div>
				<div class="nittei_setumei">
					滞在資金を現地で稼ぐことができるのもワーキングホリデーの魅力の１つです。
					この頃になれば、オーストラリアの生活にも十分慣れ、新しい事にチャレンジする余裕も、ある程度の英語力も付くはずです。
					ぜひ、頑張ってオーストラリア人と一緒の職場での仕事を探してみてください。
					医者・弁護士など資格が必要となる職業以外であれば、基本的にどんな仕事でもできます。<br/>
					英語が心配な場合は、日本人観光客をお客さんとする旅行会社や土産物屋で働くのも１つの手です。オーストラリアで日本語が話せるということは、外国語が話せるという事ですから。
					オーストラリア人よりも能力が高いと見られます。（もちろん、英語が話せた上で話ですが..）<br/>
					仕事探しの方法や、履歴書の書き方などをご案内する<a href="http://www.jawhm.or.jp/seminar.html">無料セミナー</a>を開催しております。是非ご参加ください。<br/>
					繰り返しになりますが、海外で仕事ができるビザは大変貴重です。ワーキングホリデーの魅力を生かし、ワーキングしてみましょう。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				<p>滞在期間</p> ７～９ヶ月目
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					セカンドワーキングホリデービザの取得を目指して！！
				</div>
				<div class="nittei_setumei">
					オーストラリアのワーキングホリデービザの魅力として、セカンドワーキングホリデーという制度があり、このセカンドワーキングホリデービザを取ると最大２４カ月も、オーストラリアに滞在することが出来るようになります。<br/>
					このセカンドワーキングホリデービザの申請にあたり「最低３ヶ月の間、政府指定地域で季節労働に従事した証明を提出できること」という条件があります。
					なんだか難しい表現ですが、オーストラリアのちょっとした田舎に行って、イチゴとかスイカとかの収穫のお手伝いをしてください。という事です。<br/>
					ほとんどが肉体労働なので女性はちょっときついかもしれませんが、収穫した農作物の仕分けや箱詰めという比較的楽な作業もあります。また、給料が歩合制であることが多いので男性であれば、その後のワーキングホリデー資金をかなり稼ぐことも可能です。
					セカンドワーキングホリデービザについてご説明する<a href="http://www.jawhm.or.jp/seminar.html">無料セミナー</a>もありますので、詳しいお話しをぜひ聞いてください。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				<p>滞在期間</p> １０～１２ヶ月目
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					気楽にオーストラリアを満喫！！
				</div>
				<div class="nittei_setumei">
					英語も上達したし、その英語でオーストラリア人と一緒に仕事もできた。そんな自分に、ワーキングホリデー生活の最後にご褒美をあげましょう。そう。ホリデー（休暇）ですね。
					オーストラリアは日本の約６倍の大きさがあり、シドニー、メルボルン、アデレード、ケアンズ、パースを初め魅力的な都市や雄大な大自然が多くあります。
					グレートバリアリーフでスキューバダイビングのライセンスを取るのもいいでしょう。地球の「へそ」と呼ばれるエアーズロックを見るのもいいでしょう。
					サーフィンやアートなど、新しい趣味を始めるのも面白いです。オーストラリアは見所満載です。<br/>
					ラウンドと言って、オーストラリア全土を１周しながら旅行をする方もいます。行く先々で色々な人に触れ合い、たまには大騒ぎして楽しむ。オーストラリアに暮す人だけではなく、
					各国からワーキングホリデービザを利用してオーストラリアに来ている人に出会うチャンスもたくさんあります。オーストラリアに居ながら、世界中の人と友達になれるかもしれませんね。
				</div>
			</td>
		</tr>
	</table>

	<p class="text01">
	これは、あくまでもワーキングホリデー生活のプランの１つです。先にも述べたとおり、ワーキングホリデーでは自由な滞在を楽しむ事ができます。この通りにワーキングホリデー生活を送る必要はありません。オーストラリアでのワーキングホリデー滞在期間中の出来事は、絶対に一生の思い出、また良い経験になります。
	帰国してから友達に自慢できるホリデー体験、ワーキングホリデー生活をぜひとも送ってください。そして、自分の将来のキャリアアップとなるワーキング経験をオーストラリアでたくさんしてください。<br/>
	英語だけじゃない、仕事（ワーキング）だけじゃない、遊び（ホリデー）だけでもない、あなただけのオーストラリア・ワーキングホリデーを楽しんでください。
	</p>

	<p class="text01">
	</p>
	<p class="text10p-tyu">※１　2009年1月12日から米国に査証免除者として渡航する場合、ＥＳＴＡへの登録が義務化されました。</p>
	<p class="text10p-tyu">※２　オーストラリアに渡航する場合、必ずビザの申請・取得が必要です。短期の観光目的の場合はＥＴＡＳが利用可能です。</p>
	<p class="text10p-tyu">※３　オーストラリアの場合、一定の条件をクリアした方の場合、セカンドワーキングホリデービザの取得が可能で、その場合最大２４カ月の滞在が可能となります。</p>
	<p class="text10p-tyu">※４　オーストラリア・ワーキングホリデービザでの仕事及び勉強は、１雇用主のもとでの就労が最大６ケ月、就学又はトレーニングが最大４カ月となります。</p>
	<p class="text10p-tyu">※５　ワーキングホリデービザの発給は、１カ国に対し１回のみです。</p>

	<p style="color:red;text-align:center;margin-top:8px;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'オーストラリア';
	$number_to_display = '2';
	$start_display_from = '4'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<h2 id="st1-4" class="sec-title">オーストラリア・ワーキングホリデービザの特長</h2>
	<p class="text01">
	オーストラリアのワーキングホリデービザは、日本人であればインターネットで申請をすることができます。<br/>
	通常、ワーキングホリデービザの申請から４８時間以内に手続きは完了し(※６)、早い場合は、２～３時間でワーキングホリデービザが下りた(※７)という方もいます。つまり、朝起きた時に、あぁ、オーストラリアに行こう！！と思い立ち、ワーキングホリデービザを申請し、その日の夜の飛行機でオーストラリアに旅立つ事も、運が良ければできてしまうのです。(※８)
	オーストラリア行きの飛行機は夜便ですから、次の日から、オーストラリアワーキングホリデーライフの始まりです。<br/>
	</p>
	<p class="text01">
	オーストラリア政府は、日本人以外にも、アメリカ・カナダ・デンマーク・フランス・ドイツ・香港・イタリヤ・韓国・台湾・イギリス・インドネシア・マレーシア・タイなどなど、多くの国の方をワーキングホリデーとして受け入れています。<br/>
	オーストラリアは大変ワーキングホリデーに積極的な国です。つまり、オーストラリアにワーキングホリデーで行くと、世界中の人々と出会い友達になる事ができるのです。<br/>
	オーストラリアでのワーキングホリデーを満喫した後、オーストラリアで出会った人を訪ねて各国を廻ってから日本に帰国する方もいます。<br/>
	</p>
	<p class="text01">
	また、通常ワーキングホリデービザでの滞在は最大１２ヶ月となりますが、セカンドワーキングホリデーを取得することにより最大２４カ月間の間、オーストラリアに滞在することが可能です。
	</p>
	<p class="text01">
	この様に、比較的簡単に、しかも長期間滞在できるオーストラリアのワーキングホリデービザですが、まだまだご案内した内容がたくさんあります。
	また、ワーキングホリデーを始め、各種ビザの申請方法や必要書類など、変更される場合があります。ぜひ、<a href="http://www.jawhm.or.jp/seminar.html">無料セミナー</a>にご参加頂き、正確で最新のオーストラリア・ワーキングホリデー情報を入手してください。<br/>
	なお、<a href="http://www.jawhm.or.jp/visa/v-aus.html">オーストラリア・ワーキングホリデービザの申請方法などの詳細</a>はこちらからご確認頂く事もできます。<br/>
	日本ワーキングホリデー協会では、<a href="http://www.jawhm.or.jp/mem/">ワーキングホリデービザ申請のお手伝い</a>や、<a href="http://www.jawhm.or.jp/mem/">ワーキングホリデー生活のプランニングご相談（カウンセリング）</a>を行っております。ぜひご活用ください。<br/>
	<p class="text10p-tyu">※６　健康診断の必要性など、追加の手続きが必要となった場合は、ワーキングホリデービザの申請に最長で４週間かかります。</p>
	<p class="text10p-tyu">※７　ワーキングホリデービザ申請・発給に係る手続きはオーストラリア当局の基に行われます。全ての方が同じ条件で手続き処理が行われる訳ではありません。オーストラリアのワーキングホリデービザの申請は、十分な余裕を持って行ってください。</p>
	<p class="text10p-tyu">※８　あくまでも可能性の話であり、一生に一回しか利用できないオーストラリア・ワーキングホリデーという制度を有効的に利用する為には、十分な情報収集とプランニングが必要です。</p>
	</p>

	<p style="color:red;text-align:center;margin-top:8px;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'オーストラリア';
	$number_to_display = '2';
	$start_display_from = '6'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="http://www.jawhm.or.jp/system.html" class="wh_menu"><img src="../../images/label_big_01.jpg"><br/>ワーホリって何？</a></div>
			<div class="wh_div"><a href="../tame.php" class="wh_menu"><img src="../../images/label_big_02.jpg"><br/>ワーホリのタメになる話</a></div>
			<div class="wh_div"><a href="http://www.jawhm.or.jp/visa/v-aus.html" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>ワーホリビザの申請手順</a></div>
			<div class="wh_div"><a href="../canada/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>カナダのワーホリ</a></div>
		</div>
	</div>

	<div style="clear:both; height:10px;">&nbsp;</div>

	  <div class="advbox03">
<?php
	// 111
  define('MAX_PATH', '/var/www/html/ad');
  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
    if (!isset($phpAds_context)) {
      $phpAds_context = array();
    }
    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
    $phpAds_raw = view_local('', 86, 0, 0, '', '', '0', $phpAds_context, '');
  }
  echo $phpAds_raw['html'];
?>
	  </div>

<?php $links_obj->display_links(); ?>

	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>