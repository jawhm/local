<?php
require_once '../../include/header.php';
require_once '../../include/links.php';

$links_obj = new Links();
$header_obj = new Header();


$header_obj->title_page='シンガポールで初めてのワーキングホリデー';
$header_obj->description_page='初めてのワーキングホリデーの地としてシンガポールを選ぶ人は多いです。理由は、トップビジネスの体験をすることができるからです。有意義なワーキングホリデーにするためにも、事前準備やシンガポールに対する知識を増やしておくことが大事です。';
$header_obj->keywords_page ='シンガポール,ワーキングホリデー,海外,ビザ,生活';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

if ($header_obj->computer_use() === false && $_SESSION['pc'] != 'on') {
	$header_obj->add_css_files = '<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" /><link href="/sp/accordion/sp.css" rel="stylesheet" type="text/css" />';
	$header_obj->add_js_files = '<script src="/sp/accordion/sp.js" type="text/javascript"></script>';
}

$header_obj->fncMenuHead_imghtml='<img id="top-mainimg" src="../../../images/mainimg/SNG-countrypage.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text='シンガポールでワーキングホリデー | 日本ワーキング・ホリデー協会';

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
		シンガポールでワーキングホリデー
	</div>
	  
	  <table class="tableofcontents">
	    <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1-1">シンガポールでのワーキングホリデー生活の楽しみ方</a></li>
			  <li><a href="#st1-2">シンガポールにワーキングホリデーに行く前の準備</a></li>
			  <li><a href="#st1-3">ワーキングホリデーでシンガポールが人気を集める理由</a></li>
			  <li><a href="#st1-4">シンガポールの魅力を紹介</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>



	<h2 id="st1-1" class="sec-title">シンガポールでのワーキングホリデー生活の楽しみ方</h2>
	<p class="text01">
		なぜシンガポールでワーホリ（ワーキングホリデー）なのか？<br/>
		<br/>
		シンガポールは小さな国で、時間をかけず国中どこへでも足を伸ばすことができます。<br/>
		ワーキングホリデー滞在期間中には、平日の勤務後には屋台やレストランで食事を楽しみ、休日には少し遠出をして、寺院や博物館巡り、また日帰り旅行なども楽しむことができます。<br/>
		６ヶ月間の滞在期間があれば、シンガポール全土に足を運ぶことも可能です。<br/>
		ここでは、シンガポール生活の楽しみ方や注意点について紹介します。<br/>
		<br/>
		ワーキングホリデーでシンガポールに行くという事は、シンガポールで暮すという事になりますが、暮す上で一番大切な事は、安全である事。<br/>
		最近の日本でも凶悪な犯罪が増えてきていると言われてはいますが、それでも世界的に見ればとても安全な国の１つです。<br/>
		シンガポールも日本に負けず劣らず、大変治安の良い国です。<br/>
		また、衛生面及び医療面においてもシンガポールは世界最高水準の国であると言えます。<br/>
		海外で水道水がそのまま飲める国は本当に少ないです。<br/>
		そして、シンガポールには日本語が通じる病院も多くありますので、万一の場合でも安心して治療を受けることができます。<br/>
		ワーキングホリデー生活を安心・安全に楽しむ事ができる国、それがシンガポールです。<br/>
	</p>

	<h3 class="h3-01">&#9312;移動手段について</h3>
	<p class="text01">
		シンガポールの交通機関は高度なシステムで整備されたバスや電車、国内のほとんどの場所は電車とバスで行くことができます。<br/>
		ほとんどの観光場所への交通も網羅しているので、街の様子を知るために利用してみるのもオススメです。<br/>
		近年、渋滞問題が深刻化していることもあり、車やタクシーでの移動は時間がかかってしまうおそれがあります。<br/>
	</p>

	<h3 class="h3-01">&#9313;食事について</h3>
	<p class="text01">
		シンガポールは自炊文化よりも外食文化が発達しているので、屋台やレストランで美味しいローカルフードを味わうことができます。<br/>
		特にシーフード料理や、新鮮な果実が使われたスイーツは絶品で、一度食べたらやみつきです。<br/>
		シンガポール料理だけでなく、インド、中国、マレー料理なども堪能することができ、味に飽きることはないです。<br/>
		物価は日本よりも安いので、低価格で食事を楽しむことができます。<br/>
		レストランでは、食事のなかにサービス税が含まれているため、基本的にはチップを払う必要はありません。<br/>
	</p>

	<h3 class="h3-01">&#9314;罰金制度について</h3>
	<p class="text01">
		罰金制度などルールが厳しいと、市民に監視されているようで居心地の悪さを感じてしまうかもしれません。<br/>
		しかし、シンガポール人はとてもフレンドリーな性格です。<br/>
		道に迷ってしまった時や、現地の人達と交流したいときは、積極的に声をかけてみましょう。<br/>
		きっと優しく接してくれると思います。<br/>
		現地の人と出会うのもワーキングホリデーの醍醐味です！<br/>
	</p>

	<h3 class="h3-01">&#9316;気候について</h3>
	<p class="text01">
		シンガポールは赤道直下の近くにある熱帯国です。<br/>
		滞在初日からアクティブに行動すると身体がバテてしまうかもしれません。<br/>
		身体が気候に慣れるまでは休憩をとりながら余裕を持って行動することをオススメします。<br/>
		<br/>
		シンガポールは何日滞在しても飽きることのない場所です。<br/>
		様々な魅力に触れながら、楽しんで生活することができると思います。<br/>
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'シンガポール';
	$number_to_display = '2';
	$start_display_from = ''; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<h2 id="st1-2" class="sec-title">シンガポールにワーキングホリデーに行く前の準備</h2>
	<p class="text01">
		2012年１１月末日までは、全ての四年制大学に在籍している人がシンガポールへのワーキングホリデービサを申請することができました。<br/>
		しかし、12月以降、ワーキングホリデー制度の基準が厳格化され、一定の条件をクリアしなければビザを取得できなくなってしまいました。<br/>
		シンガポールへワーキングホリデーに行く前の準備として、申請可能かどうか理解しておく必要があります。<br/>
		これから、その基準について紹介します。<br/>
	</p>

	<h3 class="h3-01">&#9312;学歴制限</h3>
	<p class="text01">
		シンガポールのワーキングホリデービザを取得するには、以下のいずれかの世界大学ランキングで200位以内の大学の学部に３ヶ月以上在学しているか卒業していなければなりません。<br/>
		<br/>
		■ Quacquarelli Symonds World University Rankings<br/>
		■ Shanghai Jiao Tong University’s Academic Ranking<br/>
		■ Times Higher Education World University Rankings<br/>
		<br/>
		上記のランキングで200位以内に入る日本の大学は、現時点では、東京大学・京都大学・大阪大学・名古屋大学・北海道大学・東北大学・東京工業大学・九州大学・筑波大学・早稲田大学・慶応大学の11大学のみです。<br/>
	</p>

	<h3 class="h3-01">&#9313;年齢制限</h3>
	<p class="text01">
		30歳までワーキングホリデーのビザ申請を行うことができる国があるなかで、シンガポールの場合、ビザの取得対象年齢は１８才以上２５才未満という基準に定められています。<br/>
		以前は30歳まで申請可能でしたが、年齢制限も2012年12月に変更されました。<br/>
	</p>

	<h3 class="h3-01">&#9314;滞在制限</h3>
	<p class="text01">
		シンガポールでの滞在期間は最長で６ヶ月と定められています。<br/>
		働く業種に関しては特に制限はありません。期間終了後の滞在延長は認められていません。<br/>
		正規就職先企業のスポンサードを得て人材開発省の一般就労パスを取得することで「長期正規就労」への切り替えが認められます。<br/>
		<br/>
		シンガポールへのワーキングホリデーのビザを申請するためには、様々な条件をクリアしていなければなりません。<br/>
		この点について、留意しておく必要があります。<br/>
		<br/>
		<br/>
		<br/>
		次に、渡航前の就労ビザ申請手続きについて紹介します。<br/>
	</p>
<div style="padding:10px 10px 10px 10px; border:1px dotted navy;">
				<p>
					【渡航前の就労ビザ申請手続き】<br/><br/>
				</p>
				<table style="font-size:10pt; margin-left:10px; margin-top:0px;">
					<tbody><tr>
						<td style="vertical-align:top;">１．</td>
						<td>
							<strong>ビザの申請方法</strong><br/>
							シンガポールのワーキングホリデーのビザ申請はオンラインのみから可能です。<br/>
							シンガポール人材開発省（MOM）から申請書をダウンロードして記入、必要書類を添付して送信します。<br/>
							必要書類は、英文での在学または卒業証明書か入学許可書、パスポートのコピーとなっています。<br/><br/>
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">２．</td>
						<td>
							<strong>IPA取得後から渡航前までの手続き</strong><br/>
							審査は約３週間程度かかり、通過者には就労ビザのIPA（In-Principle Approval for the WHP）が<br/>メールで送付されます。<br/>IPA取得後、必ず３ヶ月以内にシンガポールへ渡航しなければなりません。<br/>渡航の２週間前には、MOMオフィスでワークホリデー用就労許可書発行するためのオンライン予約を<br/>行う必要があります。<br/><br/>
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">３．</td>
						<td>
							<strong>渡航後の手続き</strong><br/>
							シンガポールに到着後、予約した期日にIPAと必要書類を持ってMOMオフィスに行く必要があります。<br/>
							そこで、就労許可書発行の申請を行います。必要書類は以下の通りです。<br/>
							<br/>
							・ワークホリデーパス申込書一式<br/>
							・パスポート・オンライン予約時の予約票<br/>
							・シンガポール入国時に記入した出入国カード（アライバルカード）<br/>
							・入国から6ヶ月後の出国を証明する交通機関のチケット（飛行機、船、鉄道など）<br/>
							・ワーホリビザ発行費用S$150（クレジットカード支払い（VISAかMasterCard）<br/>
							<br/>
							証明写真はMOMオフィスに併設している写真屋で撮影してください。<br/>
							料金はS$6です。ビザは目安として約4日後に発給されます。<br/>
							再度MOMオフィスにビザを受け取りにいき、全ての手続きが完了します。<br/>
							<br/>
							シンガポールでワーキングホリデーを行うためには、様々な制限と手続きを行わなければなりません。<br/>
							シンガポールへ行く準備として、何を行わなければならないのかしっかりと確認しておくことをオススメします！<br/>
						</td>
					</tr>
				</tbody></table>
			</div>
<br/><br/>
	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'シンガポール';
	$number_to_display = '2';
	$start_display_from = '2'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st1-3" class="sec-title">ワーキングホリデーでシンガポールが人気を集める理由</h2>
	<p class="text01">
		シンガポールは民族文化と近代文化が織り交ざった東南アジアの国です。<br/>
		６３の小さな島が集まって一つの国が構成されていますが、国の全体面積は東京都と同じほどしかありません。<br/>
		最も面積の広いシンガポール島でも、西端から東端まで車で移動するのに1時間ほどしかかかりません。<br/>
		そんなシンガポールですが、近年、ワーキングホリデー先として注目を集めています。
	</p>
	<h3 class="h3-01">アジアビジネスの中心地</h3>
	<p class="text01">
		シンガポールは近年、東南アジアの中心に位置する地理的条件や整ったインフラ、法律など様々な理由からアジアビジネスのハブとして諸外国から注目されています。シンガポールに拠点を置く外国企業の数は約7,000社。<br/>
		世界銀行と世銀グループの国際金融公社（IFC）が世界183ヵ国・地域を対象にビジネスのしやすさを調査した年次報告「ビジネス環境の現状」では、４年連続で１位を維持した実績も持っています。<br/>
		世界でもトップレベルのビジネスを体験することができるということから、ワーキングホリデー先として人気が高まっています。<br/>
	</p>

	<h3 class="h3-01">多民族共生社会</h3>
	<p class="text01">
		ビジネスの発展が目覚ましいシンガポールには、外国企業だけでなく中国、マレーシア、インドなどアジア諸国から多様な人びとが集まってきます。
		その結果、華人系、マレー系、インド系を始めとした多様な人種が混在し、小さな国のなかに約５３１万の人びとが密集して生活しています。
		多民族、多言語、多文化が、一つの国のなかで共存しているということも、シンガポールの特徴の一つです。<br/>
		ビジネス面ばかりが注目されがちですが、シンガポールで生活することで、民族文化や歴史についても学ぶことができます。<br/>
		このことからも、近年、ワーキングホリデーや留学先として人気が高まっています。<br/>
	</p>

	<h3 class="h3-01">リゾート地としても注目</h3>
	<p class="text01">
		シンガポールは、赤道直下に位置し、１年を通して高温多湿の過ごしやすい気候に恵まれています。<br/>
		このことから、近年はリゾート地として注目され始め、観光産業開発も進められています。<br/>
		シンガポールの美しい国土は「ガーデン・シティ」と呼ばれ、世界で4番目に外国人旅行者が多く訪れるほど人気の場所となっています。
		カジノ、ユニバーサル・スタジオ・シンガポール、世界最大の水族館「Marine Life Park」などが相次いでオープンし、エンターテイメント業界を賑わせています。都心を穏やかに流れるシンガポール川をクルーズしながらマーライオン像を眺めたり、シンガポール動物園でナイトサファリを楽しんだり、ワーキングホリデーや留学の合間にゆっくりと観光を楽しむことができるオススメの場所です！<br/>
	</p>

	<h2 id="st1-4" class="sec-title">シンガポールの魅力を紹介</h2>
	<p class="text01">
		シンガポールと言えばマーライオン。それ以外は…「う～ん、よくわからない」という人も多いのではないでしょうか。<br/>
		ワーキングホリデー先として充実した生活を送ることができるのか、少し疑問を抱いていませんか？不安になる必要はありません。<br/>
		シンガポールにはたくさんの魅力がつまっています。これから、シンガポールの魅力について紹介していきます。<br/>
	</p>

	<h3 class="h3-01">&#9312;観光地としてのシンガポール</h3>
	<p class="text01">
		シンガポールにはマーライオン像だけなく、魅力的な観光スポットがたくさんあります。<br/>
		これから、その一部を紹介していきます。<br/>
	</p>

<table class="normal-event">
		<tbody><tr>
			<th>アリーナ地区</th>
			<td>
		<p>&nbsp;</p>
			シンガポール観光を楽しむなら、カジノや大型ショッピングセンター、高級ホテルが建ち並ぶマリーナ地区は外せません。<br/>
			世界最大の観覧車「シンガポール・フライヤー」、幸運をもたらす噴水「ファウンテン・オブ・ウェルス」など注目スポットが集まっています。<br/>
		<p>&nbsp;</p>
			</td>
		</tr>
	</tbody></table>

<table class="normal-event">
		<tbody><tr>
			<th>オーチャード・ロード</th>
			<td>
		<p>&nbsp;</p>
			買い物を楽しむなら「オーチャード・ロード」がオススメです。<br/>
			シンガポールを横断する東西約2キロに渡るショッピングストリートで、高級ブランド店やデパート、ショッピングセンターが立ち並んでいます。<br/>
			ここで買えないものはないというほど、充実した施設が取り揃えられています。<br/>
		<p>&nbsp;</p>
			</td>
		</tr>
	</tbody></table>

<table class="normal-event">
		<tbody><tr>
			<th>セントーサ島</th>
			<td>
		<p>&nbsp;</p>
			シンガポール中心地から約20分の場所にあるリゾート&レジャー・アイランド。<br/>
			３７メートルのマーライオンを見ることができる「マーライオンタワー」、ピンクイルカを見学できる「アンダー・ウォーター・ワールド」など、大人も子どもも一日中楽しむことができます。<br/>
		<p>&nbsp;</p>
			</td>
		</tr>
	</tbody></table>
	<p class="text01">
		この他にも、夜の動物園で100種類以上の動物を見ることができる「ナイトサファリ」や、オリジナルのアトラクションが揃っている「ユニバーサル・スタジオ・シンガポール」など、充実の観光名所が用意されています。ワーキングホリデーでの滞在中も、飽きずに過ごすことができます。<br/>
	</p>

	<h3 class="h3-01">&#9313;シンガポールの食を楽しむ</h3>
	<p class="text01">
		シンガポールは様々な民族が共存する多民族国家です。<br/>
		様々な国のグルメを堪能できることもシンガポールの魅力の一つです。<br/>
		屋台やレストランでも食事を楽しむことはできますが、ここではいくつかの民俗文化や食事を楽しむことができるスポットを紹介します<br/>
	</p>

<table class="normal-event">
		<tbody><tr>
			<th>アラブストリート</th>
			<td>
		<p>&nbsp;</p>
			イスラム教のモスクなどが立ち並ぶストリートです。<br/>
			アラビアングッツを購入したり、アラビア料理を楽しむことができます。<br/>
		<p>&nbsp;</p>
			</td>
		</tr>
	</tbody></table>

<table class="normal-event">
		<tbody><tr>
			<th>チャイナタウン</th>
			<td>
		<p>&nbsp;</p>
			中国の屋台や寺院が並ぶエリアです。<br/>
			活気あふれる雰囲気のなかで中国料理を堪能できます。<br/>
			国内料理だけではなく様々な国の料理を楽しむことができるシンガポール。<br/>
			ワーキングホリデーでの滞在中に食事に困ることがないことは、魅力の一つです。<br/>
			<br/>
			観光や食事に焦点を当ててシンガポールの魅力について紹介してきましたが、他にも歴史やアートも楽しむことができます。<br/>
			シンガポールは世界中で1、2を争うくらい、たくさんの魅力が溢れています。<br/>
			ワーキングホリデー先として選ぶにはオススメの場所です。<br/>
			興味のある方は、当協会のセミナーに参加してより具体的なお話をお聞きになることをお勧め致します。<br/>
			気軽にお問い合わせくださいませ。<br/>
		<p>&nbsp;</p>
			</td>
		</tr>
	</tbody></table>

	<p style="color:red;text-align:center;margin-top:8px;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'シンガポール';
	$number_to_display = '2';
	$start_display_from = '4'; //empty is begining
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