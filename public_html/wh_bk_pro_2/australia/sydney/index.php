<?php
require_once '../../../include/header.php';
require_once '../../../include/links.php';

$links_obj = new Links();
$header_obj = new Header();


$header_obj->title_page='シドニーでワーキングホリデー';
$header_obj->description_page='オーストラリアの都市・シドニーへワーホリ（ワーキングホリデー）に行く方に向けて、ビザの取得と準備、ワーホリでの注意点、現地の特徴、語学学校・仕事の選び方、帰国後の就職など、必要な情報を掲載しています。';
$header_obj->keywords_page ='シドニー,ワーホリ,オーストラリア,情報,英語';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

$header_obj->fncMenuHead_imghtml='<img id="top-mainimg" src="../../../../images/mainimg/AU-countrypage.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text='シドニーでワーキングホリデー | ワーホリについて';

$header_obj->display_header();

include('../../../calendar_module/mod_event_horizontal.php');

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="http://www.jawhm.or.jp/system.html" class="wh_menu"><img src="../../../images/label_big_01.jpg"><br/>ワーホリって何？</a></div>
			<div class="wh_div"><a href="../../tame.php" class="wh_menu"><img src="../../../images/label_big_02.jpg"><br/>ワーホリのタメになる話</a></div>
			<div class="wh_div"><a href="http://www.jawhm.or.jp/visa/v-aus.html" class="wh_menu"><img src="../../../images/label_big_03.jpg"><br/>ワーホリビザの申請手順</a></div>
			<div class="wh_div"><a href="../../canada/" class="wh_menu"><img src="../../../images/label_big_04.jpg"><br/>カナダのワーホリ</a></div>
		</div>
	</div>
	<div style="clear:both; height:10px;">&nbsp;</div>

	<div class="step_title">
		シドニーでワーキングホリデー
	</div>
	  <table class="tableofcontents">
	    <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1-1">ワーホリでシドニーが人気を集める理由</a></li>
			  <li><a href="#st1-2">シドニーの魅力を紹介！</a></li>
			  <li><a href="#st1-3">シドニーにワーホリに行く前の準備</a></li>
			  <li><a href="#st1-4">シドニーでのワーホリ生活の楽しみ方</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>



	<h2 id="st1-1" class="sec-title">ワーホリでシドニーが人気を集める理由</h2>	<h3 class="h3-01">シドニーはどんな都市？</h3>
	<p class="text01">		日本全体のワーホリ利用者の実に半分以上が、オーストラリアを目的地に選んでいます。<br/>
		そのオーストラリアで特に人気がある都市がシドニーです。<br/>
		シドニーの気候は一年を通して安定しており、朝と夜の温度差と日差しが強いことに気を付ければ、快適に暮らせるでしょう。<br/>
		また、シドニーの治安はよく、オーストラリア全体でも生活しやすい都市といえます。<br/>
		大都市のシドニーでは、ワーホリ向けの仕事が多く見つかります。仕事探しには、日本語サポートセンターで情報を得るのがいいでしょう。<br/>
		そこでは、学校や旅行の相談を無料で受け付けおり、ビザや保険など、ワーホリに必要なことを幅広く取り揃えています。<br/>
		ただ、ワーホリでは、同じ雇用主の元で働けるのは６ヶ月まで、と定められているので注意が必要です。<br/>
	</p>
	<h3 class="h3-01">語学留学体験</h3>	<p class="text01">		英語を勉強する為に、オーストラリアへワーホリに行く方も多いと思います。<br/>		シドニーで英語を学ぶ魅力は、授業以外でのアクティビティーが多いから英語を使う機会が自然と増えることでしょう。<br/>		大自然に触れ合うイベントや、地元でのスポーツ等に参加することが可能で、授業で覚えた内容をすぐに使う事が出来き、英語の上達も早くなります。<br/>		日本以外からの留学生もおり、彼らとの意思疎通にも、もちろん英語が必要です。<br/>		シドニーの特徴であるアクティビティーの多さを利用して、ご自身の勉強に役立てて下さい。<br/>	</p>
	<h3 class="h3-01">シドニーを観光してみよう</h3>
	<p class="text01">
		観光都市としても、シドニーはとても魅力に溢れた都市です。<br/>
		シドニー市内には人気の観光名所が数多く点在していて、オーストラリアの大自然と触れ合うこともできます。<br/>
		ザ・ロックス地区やハーバー・ブリッジ、オペラハウスなどの名所では、年間を通して多数のイベントが開催されます。<br/>
		景観の美しいシドニー・ハーバー国立公園では、海水浴やハイキングに参加可能です。<br/>
		公園内には多くの野生動物が生息しており、希少な生き物と触れ合うことも出来ます。<br/>
	</p>

	<h3 class="h3-01">シドニー周辺を回る</h3>
	<p class="text01">
		シドニーからそんなに遠くない場所にも、有名な都市・観光地がたくさんあります。<br/>
		国会議事堂や国立図書館、国立美術館などがある首都のキャンベラ。<br/>
		中央市場や石造りの街、南半球最大の祭典でも有名なアデレード。<br/>
		文化の中心都市メルボルンなど、シドニー周辺には一日では観光し尽くせない魅力的な都市が多くあります。<br/>
		<br/>
		シドニーだけでも観光場所は多いですが、周辺都市を加えると簡単には回りきれないほどです。<br/>
		治安がよく気候が安定していること、仕事がみつかりやすいこと、シドニーでのアクティビティーが多いこと、周辺にも観光地が多いこと等々…。のワーホリの渡航先として、シドニーはとても魅力的な都市です。<br/>
		自分の勉強や仕事にも打ち込められ、プライベートも充実させられる。<br/>
		これだけの条件が揃っているシドニーに、ぜひワーホリで訪れてください！<br/>
	</p>

	<center><img src="../../img/ausmap.gif" alt="シドニーの地図"></center>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'シドニー';
	$number_to_display = '2';
	$start_display_from = ''; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<h2 id="st1-2" class="sec-title">シドニーの魅力を紹介！</h2>
	<h3 class="h3-01">シドニーの基本情報</h3>	<p class="text01">		南半球にあるオーストラリアは、日本とほぼ変わらない経度にありますが、季節が逆になっています。<br/>		ニュー・サウス・ウェールズ州に属するシドニーの時間帯は、日本時間＋１時間です（サマータイム中は２時間）。<br/>		<br/>		シドニーの気候は年間を通じて安定しており、過ごしやすい都市です。<br/>		朝と昼の気温差と、強い紫外線には気を付けてください。<br/>		シドニーの治安は安定していますが、やはり日本とは違う国です。<br/>		落ち着いている雰囲気に気を許してしまいがちになりますが、油断はしないようにしましょう。<br/>	</p>
	<h3 class="h3-01">シドニーは見どころ満載！</h3>	<p class="text01">		シドニーでもっとも有名な観光場所は、オペラハウスでしょう。<br/>		オーストラリア全体のシンボルでもあるオペラハウスでは、コンサートやオペラ、演劇など、いろいろなパフォーマンスがこの場所で催されています。<br/>		また、オペラハウスそのものの見学も可能です。世界最高峰の劇場でのパフォーマンスを体感して下さい。<br/>		<br/>		ロックス地区も有名な観光場所です。<br/>		ロックスは、オーストラリアへの最初の入植者たちが足を踏み入れた場所です。<br/>		当時の街がそのまま残されているので、オーストラリアの歴史をたどってみるのもいいかもしれませんね。<br/>		<br/>		シドニー・ハーバー国立公園は、オーストラリアの代表的な自然公園です。<br/>		ここにはオーストラリアの大自然が残っており、雄大なシドニー・ハーバーを眺めながらのウォーキングや、美しい海での海水浴の他、湾内の島を巡って楽しむこともできます。<br/>		また、貴重な動物と触れ合えることも大きな魅力です。<br/>		ボンダイビーチ、マリンビーチ、ク―ジービーチ、パームビーチの各ビーチも、シドニーの有名な観光地です。美しい砂浜や夕焼けを楽しんでください。<br/>	<br/>	そして、オーストラリアらしい観光といえば、ホエールウォッチングでしょう。<br/>	６月から１０月ごろまでの期間限定ではありますが、高確率でクジラに遭遇できます。<br/>	シドニー発の船に乗り、目の前でクジラが飛び跳ねる姿をご覧になってください。<br/>	</p>
	<h3 class="h3-01">シドニーでのスポーツ体験</h3>
	<p class="text01">
		シドニーでは、テニスやゴルフといったスポーツが盛んです。<br/>
		テニス場やゴルフ場が多く、予約をすれば誰でも気軽に楽しめます。<br/>
		自然が豊かなシドニーでは、マリンスポーツも盛んです。サーフィン、スキューバダイビング、釣りなどが目的で訪れる方も多いです。<br/>
		シドニーではスポーツ関連のイベントがいくつも行われていますが、最大のものはシドニー・マラソンです。<br/>
		毎年９月に開催されるシドニー・マラソンでは、４種類のマラソンが行われています。<br/>
		もちろん一般の参加も可能で、美しい街を走り抜けるフルマラソンは、地元でも大きなイベントになっています。<br/>
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'シドニー';
	$number_to_display = '2';
	$start_display_from = '2'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st1-3" class="sec-title">シドニーにワーホリに行く前の準備</h2>
	<p class="text01">		ここでは、日本でやっておくべき下準備について考えていくことにしましょう。<br/>	</p>
	<h3 class="h3-01">まずはビザの申請・取得</h3>
	<p class="text01">
		オーストラリアは世界中からワーホリを受け入れている「ワーホリ大国」です。<br/>
		パスポートを用意し、オーストラリア大使館のHPを参照にして、ワーホリビザを申請しましょう。<br/>
		<br/>
		オーストラリアにはセカンドワーキングホリデーがあり、ワーホリの期限を1年間延長することが可能です。<br/>
		オーストラリアで二度目のワーホリを申請するには、政府指定の場所で一定期間以上期間以上働く必要があります。<br/>
		<br/>
		書類を提出する以外にオンラインでの申請も可能ですが、ビザ申請には複雑なステップもある為、ビザを申請する前に必ず協会にご連絡ください。
		<a href="../../../visa/v-aus.html">⇒オーストラリアビザ情報ページへのリンク</a><br/>
	</p>

	<h3 class="h3-01">航空券の取得</h3>
	<p class="text01">
		航空券は往復、片道どちらを取得しても大丈夫です。<br/>
		休暇時期を避け、早めに予約をすることで、チケットを比較的安く入手することもできるでしょう。<br/>
		また、現地に何時に着くのかも事前に確認しておきましょう。日本との時差は＋１時間（サマータイムでは２時間）ですが、夜の到着は何かと面倒です。<br/>
		万が一のトラブルに備えて、日中に到着する便がオススメです。<br/>
	</p>

	<h3 class="h3-01">オージーイングリッシュを学ぼう！</h3>
	<p class="text01">
		英語は世界の多くの国で話されていますが、その国や地方独自の英語も存在します。<br/>
		オーストラリアの「オージーイングリッシュ」はその代表例といえるでしょう。<br/>
		語学学校での授業を終えたあとは、ぜひ現地の言葉に触れてみてください。<br/>
		その土地の風土や歴史あってこそ、独自の言葉は生まれます。<br/>
		シドニーで行われる多数のアクティビティーを体験し、オーストラリアでしか聞けない英語を学んでみてください。<br/>
	</p>

	<h3 class="h3-01">現地の学校について</h3>
	<p class="text01">
		ワーホリで通うことになる語学学校では、どの学校でも実力に応じたクラスに振り分けられます。<br/>
		語学学校での学習には、現地の生活で使われている英語をその場で勉強し使用できるという大きな魅力があります。<br/>
		一週間あたりの費用は、平均で約３００ドル程度。<br/>
		ワーホリでの渡航の場合、オーストラリアの学校に通えるのは、４ヶ月までと決まっています。<br/>
		この機会を無駄にせず、学校で実力をつけ、現地での就労に備えましょう。<br/>
	</p>

	<h3 class="h3-01">ワーホリ最大の魅力・現地での就労</h3>
	<p class="text01">
		一般的に、ワーホリでの滞在中の仕事を探す方法は、日本人向けの情報を得ることが一番です。<br/>
		ワーホリ大国であるのオーストラリアの大都市・シドニーでは、ワーホリ用の仕事を見つけるのは難しくありません。<br/>
		ただ、２度目のワーホリ申請を出すためには、農業、漁業、林業など、政府指定の第一次産業に88日以上従事する必要があります。<br/>
		広大な大地を誇るオーストラリアでの大規模な農作業は、ワーホリならではの体験といえるでしょう。<br/>
	</p>

	<h2 id="st1-4" class="sec-title">シドニーでのワーホリ生活の楽しみ方</h2>

	<p class="text01">
		シドニーでのワーホリ生活を充実させるためには、何を心がければいいのでしょうか。<br/>
	</p>

	<h3 class="h3-01">地元開催のイベントに参加しよう</h3>
	<p class="text01">
		シドニーは大きな都市なので、有名なイベントがいくつも開催されます。<br/>
		１月に開かれるシドニー・フェスティバルは、オーストラリア最大の文化および芸術のイベントです。<br/>
		開催期間中はシドニー中でいろいろなイベントが行われ、のべ約１００万人もの人が訪れます。<br/>
		３月にはハンダ・オペラ・オン・シドニー・ハーバーがあります。特設水上ステージを舞台として行われる、豪華なオペラ公演です。<br/>
		５月に行われるビビッド・シドニーも、非常に有名なイベントです。シドニーの豪華施設がライトアップされ、街中が光に包まれます。<br/>
		湾全体が彩られるのは、このイベントならではのものです。<br/>
		そして、９月にはシドニー・マラソンが控えています。自分の予定と合わせて、プライベートも充実させてください。<br/>
	</p>

	<h3 class="h3-01">ワーホリでの就労</h3>
	<p class="text01">
		現地で働き、日本では得られない経験を積むことは、ワーホリの大きな魅力です。<br/>
		アルバイト感覚の仕事が多いですが、一般的な企業に勤めることも可能です。<br/>
		日本企業の現地法人に日英両方の履歴書を送って応募することもできますし、現地の企業に就職することも不可能ではありません。<br/>
		現地の人と積極的に交流を深め、人づてに仕事を探す手段もあります。<br/>
		ただ、いずれの仕事に就くのであっても、高い英語力がある人が優遇されます。<br/>
	</p>

	<h3 class="h3-01">季節労働から２度目のオージーワーホリへ</h3>
	<p class="text01">
		政府が指定した一次産業の現場で８８日以上働くことで、オーストラリアの２回目のワーホリ申請を出すことが出来るようになります。<br/>
		このような肉体労働は比較的賃金が高いため、集中的に働いて旅行の資金する人もいます。<br/>
		季節労働を申請する場合は、就労場所や気候条件、ご自身の体力を事前に考慮する必要があります。<br/>
		労働時のトラブルや勘違いを避けるためにも、公式HPを参照にしましょう。<br/>
	</p>

	<h3 class="h3-01">多国籍文化との交流をすすめよう！</h3>
	<p class="text01">
		ワーホリ大国オーストラリアには、さまざまな国の人がやってきます。<br/>
		大都市のシドニーにはチャイナタウンがあり、日本を含めた他国の祭典が行われます。<br/>
		それらのイベントを手始めに、他国の方と積極的に交流してみましょう。<br/>
		ワーホリという同じ立場でシドニーにいて、話す言葉も同じ英語です。<br/>
		それらのイベントを通して、オーストラリア以外の国の人と触れ合うことはワーホリの醍醐味といえるでしょう。<br/>
	</p>

	<h3 class="h3-01">しっかりとした準備があってこその充実したワーホリ生活</h3>
	<p class="text01">
		海外生活にトラブルはつきものです。<br/>
		語学の問題でも日常生活でも、思ってもないことが起きてしまうことがあります。<br/>
		それを自分で解決するのが勉強ですが、事前の準備をしっかり行うことが解決への近道になります。<br/>
		ワーキングホリデー協会では、様々な無料セミナーを用意しています。<br/>
		初心者セミナーから始まり、語学学校の選び方、懇談形式のカウンセリングもあり、ワーホリ体験談を聞くことも出来ます。<br/>
		また、ワーキングホリデー協会では、メンバー登録も行っています。<br/>
		登録すれば、協会と密に連絡がとれ、個別カウンセリングや特別セミナーへの参加など、様々なサポートを受けることが出来ます。<br/>
		ワーキングホリデー協会の充実したサポートを受け、目標の実現に動き出してください！<br/>
	</p>
	<p style="color:red;text-align:center;margin-top:8px;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'シドニー';
	$number_to_display = '2';
	$start_display_from = '6'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="http://www.jawhm.or.jp/system.html" class="wh_menu"><img src="../../../images/label_big_01.jpg"><br/>ワーホリって何？</a></div>
			<div class="wh_div"><a href="../../tame.php" class="wh_menu"><img src="../../../images/label_big_02.jpg"><br/>ワーホリのタメになる話</a></div>
			<div class="wh_div"><a href="http://www.jawhm.or.jp/visa/v-aus.html" class="wh_menu"><img src="../../../images/label_big_03.jpg"><br/>ワーホリビザの申請手順</a></div>
			<div class="wh_div"><a href="../../canada/" class="wh_menu"><img src="../../../images/label_big_04.jpg"><br/>カナダのワーホリ</a></div>
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