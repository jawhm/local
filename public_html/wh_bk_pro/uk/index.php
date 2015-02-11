<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->fncFacebookMeta_function=true;
$header_obj->title_page='イギリスのワーキングホリデー（ワーホリ）';
$header_obj->description_page='イギリスは伝統ある歴史と近代的な文化が混ざり合う国です。
				イギリスには世界最高峰の博物館や美術館、美しく歴史ある街並みがあり、
				留学生やワーキングホリデー（ワーホリ）での渡航先としてはもちろん、観光旅行の目的地としても非常に人気の高い国です。
				またイギリスは伝統文化や歴史だけでなくファッションや音楽などのエンターテイメントの都市としても有名で、
				ワーキングホリデー（ワーホリ）制度を使いイギリスで生活するだけでも常に最先端の文化に触れることができるでしょう。';
$header_obj->keywords_page ='イギリス,ワーキングホリデー,ワーホリ,留学,ビザ,方法';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

if ($header_obj->computer_use() === false && $_SESSION['pc'] != 'on') {
	$header_obj->add_css_files = '<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" /><link href="/sp/accordion/sp.css" rel="stylesheet" type="text/css" />';
	$header_obj->add_js_files = '<script src="/sp/accordion/sp.js" type="text/javascript"></script>';
}

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../../images/mainimg/GB-countrypage.png" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'イギリスのワーキングホリデー（ワーホリ）';

$header_obj->display_header();
include('calendar_module/mod_event_horizontal.php');
?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(''); ?>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="../canada/" class="wh_menu"><img src="../../images/label_big_01.jpg"><br/>カナダのワーホリ</a></div>
			<div class="wh_div"><a href="../australia/" class="wh_menu"><img src="../../images/label_big_02.jpg"><br/>オーストラリアのワーホリ</a></div>
			<div class="wh_div"><a href="../newzealand/" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>ニュージーランドのワーホリ</a></div>
			<div class="wh_div"><a href="../america/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>アメリカのワーホリ</a></div>
		</div>
	</div>
	<div style="clear:both; height:10px;">&nbsp;</div>

	<div class="step_title">
	イギリスのワーキングホリデー（ワーホリ）</div>
	  <p class="text01">イギリスは伝統ある歴史と近代的な文化が混ざり合う国です。<br/>
	イギリスには世界最高峰の博物館や美術館、美しく歴史ある街並みがあり<br/>
	留学生やワーキングホリデー（ワーホリ）での渡航先としてはもちろん、観光旅行の目的地としても非常に人気の高い国です。</p>

	  <table class="tableofcontents">
	   	 <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1">イギリスってどんな国？</a></li>
			  <li><a href="#st2">イギリス都市紹介！</a></li>
			  <li><a href="#st3">イギリスのワーキングホリデー（ワーホリ）制度【YMS】について</a></li>
			  <li><a href="#st4">イギリスのワーキングホリデー（ワーホリ）抽選に落ちちゃった・・・これからどうしよう？</a></li>
			  <li><a href="/wh/uk/london/">ロンドンのワーホリ（ワーキングホリデー）</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>

	<h2 id="st1" class="sec-title">イギリスってどんな国？</h2>
	<p class="text01">
	イギリスは伝統ある歴史と近代的な文化が混ざり合う国です。イギリスは正式名称グレートブリテン及び北アイルランド連合王国と呼ばれ、英語ではUnited Kingdom of Great Britain and Northern Irelandとなります。</p>
	<p class="text01">
	正式名称グレートブリテン及び北アイルランド連合王国と呼ばれるように、イギリスは「イングランド、スコットランド、ウェールズ、北アイルランド」の4つの国からなる連合国です。イギリスは連合国であるため、国や地域によって異なる特徴を持ちます。また「イギリス人」は名称として正しくなく、イングランド(東部)出身の人には「イングリッシュ」(English)、ウェールズ(西部)出身の人には「ウェルシュ」(Welsh)、スコットランド出身(北部)の人には「スコティッシュ」(Scottish)、(北部)アイルランド出身の人には「アイリッシュ」(Irish)と、呼び方が異なるので、イギリスでは呼び方に注意が必要です！</P>

	<center><img src="../img/ukmap.gif" alt="イギリスの地図"></center>

	<p class="text01">
	イギリスには世界最高峰の博物館や美術館、美しく歴史ある街並みがあり、留学生やワーキングホリデー（ワーホリ）での渡航先としてはもちろん、観光旅行の目的地としても非常に人気の高い国です。またイギリスは伝統文化や歴史だけでなくファッションや音楽などのエンターテイメントの都市としても有名で、ワーキングホリデー（ワーホリ）制度を使ってイギリスで生活するだけでも常に最先端の文化に触れることができるでしょう。</p>
	<p class="text01">
	<a href="/wh/uk/london/">ロンドンのワーホリ（ワーキングホリデー）はこちら</a>
	</p>
	<p class="text01">
	イギリス特徴として、交通機関が発達していることが挙げられます。バスや鉄道、飛行機やフェリーなどを使いイギリスやヨーロッパの主要都市を簡単に行き来できるので、留学中やワーキングホリデー（ワーホリ）での渡航中に色々な場所をイギリスだけではなくヨーロッパを全部楽しみたい人におススメです。</p>
	<p class="text01" style="color:red;">
	※2014年度イギリスYMSに関する情報は、<a href="http://www.jawhm.or.jp/visa/v-uk.html">こちら</a>をご参照ください。</p>

	<p style="color:red;text-align:center;">
	▼▼▼2014年度イギリスYMSに関しての情報は、無料セミナーで細かく解説しています！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st2" class="sec-title">イギリス都市紹介！</h2>
	<p class="text01 block01">
	イングランド
		</p>
		<p class="text01">
		イングランドはグレートブリテン島の南東に位置する国で、その領土は島の三分の二を占めます。ワーキングホリデー（ワーホリ）はもちろん、単純な旅行先としてもイギリスの中で人気の高い地域です。イングラントと言えば長い歴史と伝統ある美しい街並みを連想する人が多いと思いますが、イギリスの中でも特に美しい自然が残されていることも特筆すべき点です。</p>
		<p class="text01">
		テムズ川やティーズ川などに代表される美しい河川や、スコーフェル山などがあるカンブリア山地には大小様々な湖が連なる湖水地方あり、ワーキングホリデー（ワーホリ）渡航者にお勧めのスポットです。また、この地域はピーターラビットの舞台としても有名です。</p>
		<p class="text01">
		イングランドの首都はロンドンです。(<a href="/wh/uk/london/">ロンドンのワーホリ（ワーキングホリデー）はこちら</a>)世界で最も栄えている都市のひとつに挙げられるほどで、ワーキングホリデー（ワーホリ）の人気の高い都市です。他にもエンターテイメントの街ブライトンなどはイギリスにワーキングホリデー（ワーホリ）ビザで留学する人に人気の都市となっています。またイギリスでしっかりと勉強をしたい人には、伝統ある大学都市ケンブリッジとオックスフォードなどが人気で、ワーキングホリデー（ワーホリ）ビザではなく学生ビザでイギリスで留学した後、大学に進学する人も多いです。どの都市にもイギリスを代表する観光名所があり、語学学校もその都市に点在しているので、ワーキングホリデー（ワーホリ）中に勉強・仕事・観光と全てを体験することが出来る。</p>
		<p class="text01">
		また、ワーキングホリデー（ワーホリ）の期間中、イギリスの美しい自然を体感したい人はボーンマスやヘイスティングなどの海岸都市がおすすめ。イギリスでも有数のシーサイドリゾート地であり、観光地ならではの仕事を探すこともできるので、ワーキングホリデー（ワーホリ）の期間中イギリスで楽しみながら働くこともできるでしょう。</p>
	<p class="text01 block01">
	スコットランド
	</p>
		<p class="text01">
		スコットランドは1707年にイギリス（グレートブリテン王国）が成立するまでは、独立したスコットランド王国でした。この様な経緯からか、公用語は英語とスコットランド語となっており、英語にも独特なイントネーションがあります。</p>
		<p class="text01">
		スコットランドで有名な物と言えば、イギリス内でも珍しいバグパイプや民族衣装のキルトなどでしょう。また、ネッシーで有名なネス湖もスコットランドにあり、ワーキングホリデー（ワーホリ）の期間で行ける名所として人気です。</p>
		<p class="text01">
		スコットランドの首都はエディンバラ。ここは毎年8月に世界最大の芸術祭開催されるイギリス国内でも随一の文学都市です。都市部の多くがユネスコの世界遺産に登録されているなど、ワーキングホリデー（ワーホリ）の期間中に訪ねるイギリスの観光地としても人気の高い都市です。</p>
	<p class="text01 block01">
	北アイルランド
	</p>
		<p class="text01">
		北アイルランドはイギリスにおいても特殊な国です。南北アイルランドは、従来一つの同じ国でした。しかし1920年に成立したアイルランド統治法によってアイルランドは南北に分割され、それぞれ別の国となりました。そのため北アイルランドはアイルランド島に位置していながらイギリスの国土となっています。</p>
		<p class="text01">
		このような歴史的経緯から、北アイルランドではイギリスとアイルランドの双方に由来する文化をみることができます。なのでワーキングホリデー（ワーホリ）の期間中に様々な体験をすることができます。北アイルランドに住む人の多くはケルト系やアイルランド人が占め、第一公用語はアイルランド語で第二公用語が英語になっています。</p>
		<p class="text01">
		アイルランドにも世界遺産に登録されているジャイアンツ・コーズウェーやコーズウェー海岸を始めとする観光地が多く点在しています。イギリス国内でも決して人口の多い国ではないのですが、様々なジャンルで世界的な文化人、アーティストを輩出しています。</p>
	<p class="text01 block01">
	ウェールズ
	</p>
		<p class="text01">
		ウェールズは赤いドラゴンの国旗が特徴的な、グレートブリテン島の南西に位置する国です。イギリスの国旗がイングランド・スコットランド・北アイルランドの三つの国旗を複合させたデザインであることは有名ですが、ウェールズの国旗がここに含まれないのはウェールズがスコットランドや北アイルランドとは異なり、1536年からすでにイングランドと統合されていたからであるとされています。</p>
		<p class="text01">
		ウェールズはイギリスの中でも国全体が山岳地域となっており、国土のほとんどが山地になっています。そのため18世紀の産業革命時には、この山地から多くの石炭をはじめとする鉱物が採掘され、イギリスをはじめとする産業革命に大きく献上しました。またその際鉱物を運ぶための鉄道も発達し、役割を終えた今でも多くの鉄道が観光目的の保存鉄道となってイギリス内の人気スポットとなっています。</p>
		<p class="text01">
		もしイギリスにワーキングホリデー（ワーホリ）を使って渡航中、ウェールズに行くことがあれば是非行っていただきたい場所があります。それは世界で最も長い地名の「ランヴァイル・プルグウィンギル・ゴゲリフウィルンドロブル・ランティシリオゴゴゴホ（Llanfairpwllgwyngyllgogerychwyrndrobwllllantysiliogogogoch）」です。イギリス国内でも有名なスポットになっているので是非チェックしてみて下さい。</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st3" class="sec-title">イギリスのワーキングホリデー（ワーホリ）制度（YMS）について</h2>
	<p class="text01">
	イギリスのワーキングホリデー（ワーホリ）ビザは他国と異なるので、イギリスへワーキングホリデー（ワーホリ）で渡航しようと考えている人は注意が必要です。</p>
	<p class="text01">
	イギリスのワーキングホリデー（ワーホリ）ビザはYouth Mobility Schemeと呼ばれ、他国のワーキングホリデー（ワーホリ）ビザと違い抽選で選ばれた人だけがビザ申請を行えます。2012年までイギリスのワーキングホリデー（ワーホリ）YMSビザ申請の権利は、早い者勝ちで決めていました。その為非常に多くの方々が受付日に一斉応募をしてしまい、イギリスのワーキングホリデー（ワーホリ）ビザシステムがダウンしてしまうなどの問題も発生していました。</p>
	<p class="text01">
	その後ワーキングホリデー（ワーホリ）のシステムが見直され、2012年から受付期間内にイギリスビザセンターへ応募した人の中から抽選で1000名にイギリスのワーキングホリデー（ワーホリ）ビザ申請の権利が与えられるようになりました。それでもイギリスはワーキングホリデー（ワーホリ）の渡航先として人気が高く、イギリスで大きなイベントなどがある年などではワーキングホリデー（ワーホリ）の抽選倍率が変動する傾向にあります。</p>
	<p class="text01">
	しかし、イギリスのワーキングホリデー（ワーホリ）ビザは自由度が高いことでも有名です。多くの国ではワーキングホリデー（ワーホリ）の期間が1年間なのに対し、イギリスのワーキングホリデー（ワーホリ）は2年間の滞在期間があります。</p>
	<p class="text01">
	またイギリスのワーキングホリデー（ワーホリ）ビザは同じ雇用主の元で働き続けることができるなど、イギリスのワーキングホリデー（ワーホリ）独自のシステムがあるのもイギリスが高い人気を誇る理由です。
	<p class="text01">
	イギリスのワーキングホリデー（ワーホリ）であるYMSに応募する際の３つの注意点を挙げてみましょう。
	<table class="nittei">
		<tr>
			<td class="nittei_span">
				<p>注意点</p>その１
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					まずはイギリスのワーキングホリデー（ワーホリ）YMS申請の要項を確認する！！
				</div>
				<div class="nittei_setumei">
					ワーキングホリデー（ワーホリ）ビザを申請する時、しっかりと申請要項を確認することが非常に大切です！
					どんなにワーキングホリデー（ワーホリ）行きたくて完璧に準備をしていても、申請資格を満たしていなければワーキングホリデー（ワーホリ）ビザを申請することが出来ません。<br/>
					イギリス大使館HPへ行き、しっかりとワーキングホリデー（ワーホリ）ビザ申請要項と申請資格を確認しましょう。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				<p>注意点</p>その２
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					いざイギリスのワーキングホリデー（ワーホリ）YMSビザに応募！
				</div>
				<div class="nittei_setumei">
					イギリスのワーキングホリデー（ワーホリ）YMSビザは抽選制ですが、応募しないことには何も始まりません！抽選は毎年1月の初めに行われているので、興味がある人は先ず応募してみましょう！<br/>
					応募の際に必要な情報は<br/>
					<b>・名前<br/>
					・生年月日<br/>
					・パスポート番号<br/>
					・申請手続きを行う国<br/>
					・電話番号・携帯電話番号</b><br/>
					上記の5点です。<br/>
					上記の情報をUK Border AgencyにEメールで送り、もし抽選に選ばれればイギリスのUK Border Agencyからワーキングホリデー（ワーホリ）ビザの申請可能通知、予約方法の詳細及びビザ申請に必要な書類に関するEメールが送られてきます。<br/>
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				<p>注意点</p>その３
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					応募する時は悪徳業者にご注意！
				</div>
				<div class="nittei_setumei">
					注意して頂きたいのはイギリスのワーキングホリデー（ワーホリ）YMSビザの抽選時期が近付くと、毎年イギリスのワーキングホリデー（ワーホリ）に関する憶測や非公式な情報が多く飛び交います。もちろんこれらの情報をチェックして早めにイギリスのワーキングホリデー（ワーホリ）YMSと取る為の行動を始めるのは大事ですが、不確定な情報に振り回されてしまっていは意味がありません。焦らず、あまり情報に流されすぎないように準備を進めましょう。<br/>
					また、「業者に手数料を払うとイギリスワーキングホリデー（ワーホリ）YMSビザが取れやすくなる」といったことを謳う業者もでてきています。しかしイギリスのワーキングホリデー（ワーホリ）YMSビザは完全なランダム抽選であり、<b>手数料を払ったからといってもビザ取得において特別扱いされることは絶対にありえません。</b>また、イギリスワーキングホリデー（ワーホリ）ビザ取得発表の前にビザ取得が確定することも絶対にありません。イギリスのワーキングホリデー（ワーホリ）YMSビザを申請する際は注意をして下さい。<br/>
					もしイギリスのワーキングホリデー（ワーホリ）ビザに関する質問などがありましたら、一度ご連絡下さい。
				</div>
			</td>
		</tr>
	</table>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st4" class="sec-title">イギリスのワーキングホリデー（ワーホリ）抽選に落ちちゃった・・・これからどうしよう？</h2>
	<p class="text01">
	毎年イギリスのワーキングホリデー（ワーホリ）ビザの抽選は、イギリス自体の人気の高さとワーキングホリデー（ワーホリ）ビザ自体の自由度の高さが合いなって、非常には高倍率となっています。残念ながらこの抽選に関してはどうすることもできず、どれだけイギリスにワーキングホリデー（ワーホリ）に行きたくても抽選に漏れてしまう場合もあります。</p>
	<p class="text01">
	なので、イギリスのワーキングホリデー（ワーホリ）YMSビザ申請を考えている人は、抽選に漏れてしまった場合も考えて行動をすると良いかもしれません。</p>
	<p class="text01">
	ここでは残念ながらイギリスのワーキングホリデー（ワーホリ）YMS抽選に漏れてしまった場合の、次のステップをいくつか挙げてみます。</p>
		<p class="text01 block01">
		来年のイギリスのワーキングホリデー（ワーホリ）YMS抽選を目指す！
		</p>
			<p class="text01">
			イギリスのワーキングホリデー（ワーホリ）YMSの抽選は毎年行われていて、応募すること自体は何度でも行うことが出来ます。なので、今回がダメだったとしても来年、来年がダメでも再来年と、繰り返しチャレンジすることが可能です。</p>
		<p class="text01 block01">
		一度イギリスのワーキングホリデー（ワーホリ）YMSビザではなく、観光ビザなどを使いイギリスを視察する！
		</p>
			<p class="text01">
			ギリスのワーキングホリデー（ワーホリ）YMSビザが取れなかったからといって、イギリスに行けなくなってしまう訳ではありません。観光ビザなどを使って一度イギリスへ行ってみて、イギリスが本当に自分に合っているか確認してみることも重要でしょう。</p>
		<p class="text01 block01">
		学生ビザを使ってイギリスへ留学する
			</p>
			<p class="text01">
			ワーキングホリデー（ワーホリ）YMSビザ以外にもイギリスで長期滞在する方法として、学生ビザがあげられます。学生ビザではイギリスで働くことこそできませんが、イギリスの学校は世界基準でレベルが高く、特に語学力に関しては最高水準の授業が受けられるのでしっかりとした英語を学ぶことが出来ます。なにより、イギリスの雰囲気を直接体験することができ、イギリスのワーキングホリデー（ワーホリ）YMSの為の準備期間としては最適です。</p>
		<p class="text01 block01">
		イギリス以外の場所へワーキングホリデー（ワーホリ）に行く
		</p>
			<p class="text01">
			イギリスに比べれば、他のワーキングホリデー（ワーホリ）協定国のビザは取りやすい傾向にあります。海外へ行き語学を習得したいのであれば、イギリス以外の国へ渡航することも正しい判断でしょう。また、国や地域によってはイギリスに近い街並みを残す場所もあり、そういった場所へいってみるのも良いかもしれません。</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="../canada/" class="wh_menu"><img src="../../images/label_big_01.jpg"><br/>カナダのワーホリ</a></div>
			<div class="wh_div"><a href="../australia/" class="wh_menu"><img src="../../images/label_big_02.jpg"><br/>オーストラリアのワーホリ</a></div>
			<div class="wh_div"><a href="../newzealand/" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>ニュージーランドのワーホリ</a></div>
			<div class="wh_div"><a href="../america/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>アメリカのワーホリ</a></div>
		</div>
	</div>

<? include('./step/memline.php'); ?>
	<div class="step_box">

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
	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>