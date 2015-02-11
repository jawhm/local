<?php
require_once '../../../include/header.php';
require_once '../../../include/links.php';

$links_obj = new Links();
$header_obj = new Header();


$header_obj->title_page='パースのワーホリ（ワーキングホリデー）';
$header_obj->description_page='オーストラリアは、雄大な自然に囲まれて英語が学べるとあって、ワーホリ（ワーキングホリデー）希望者に人気のある国です。オーストラリアの都市であるパースは、湿気が少なく暖かく過ごしやすい土地で、初めて海外生活を送る人にもおすすめの環境です。';
$header_obj->keywords_page ='オーストラリア,パース,英語,ワーホリ,ビザ';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

$header_obj->fncMenuHead_imghtml='<img id="top-mainimg" src="../../../../images/mainimg/AU-countrypage.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text='パースのワーホリ（ワーキングホリデー） | 日本ワーキング・ホリデー協会';

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
		パースでワーキングホリデー
	</div>
	  <table class="tableofcontents">
	    <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1-1">ワーホリでパース（オーストラリア）を選ぶ理由</a></li>
			  <li><a href="#st1-2">パースってどんなところ？</a></li>
			  <li><a href="#st1-3">パース（オーストラリア）にワーホリに行く前の準備</a></li>
			  <li><a href="#st1-4">パースでどんなワーホリ生活が送れるの？</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>



	<h2 id="st1-1" class="sec-title">ワーホリでパース（オーストラリア）を選ぶ理由</h2>	<h3 class="h3-01">パースはどんな都市？</h3>
	<p class="text01">		ワーホリ協定国の中でも、オーストラリアは、海外生活を経験したことがない人にとって、とても魅力的な都市です。<br/>
		湿気が少なく、暖かい過ごしやすい気候。<br/>
		温厚な現地の人。<br/>
		移民が多く、人種差別が少ない環境。
		海外の中でも、比較的、治安が良いとされていること。<br/>
		そして、英語圏内だということ。<br/>
		こういったことが理由で、オーストラリアを選ぶ人が多いです。<br/>
		オーストラリアには、シドニーやメルボルンという、日本人にとって耳馴染みのいいよく知られた土地があるにも関わらず、その中でもパースを選ぶ人は、何が理由なのでしょうか？<br/>
	</p><div style="padding:10px 10px 10px 10px; border:1px dotted navy;">				<table style="font-size:10pt; margin-left:10px; margin-top:0px;">					<tbody><tr>						<td style="vertical-align:top;">１．</td>						<td>							<strong>環境が素晴らしい</strong><br/>							まず、世界で一番美しい街と言われていることが、日本人の興味を誘うと思います。<br/>							海に囲まれている日本では、水が周りにない生活は馴染みがありませんが、<br/>							パースなら、街の中心に川が流れていますし、水と自然に囲まれた都市ですから、馴染み深いですよね。<br/><br/>						</td>					</tr>					<tr>						<td style="vertical-align:top;">２．</td>						<td>							<strong>世界中の人と友だちになれる可能性</strong><br/>							オーストラリアは、ワーホリに対して大変寛容な国で、日本以外からも多くの国の人を受け入れています。<br/>							アメリカやカナダなど英語圏の人から、香港、韓国、台湾などアジアの人、フランスやイタリアなどヨーロッパの人もいます。<br/>							つまり、全世界の人と友だちになれる可能性があるというわけです。<br/>							こんな経験ができる国、他にあるでしょうか？<br/>							特にパースは、オーストラリアの他の都市と比べて狭い都市ですので、その分、知り合い作りも簡単にできますよ。<br/><br/>						</td>					</tr>					<tr>						<td style="vertical-align:top;">３．</td>						<td>							<strong>特徴的なビザ</strong><br/>							オーストラリアのビザには、嬉しいポイントがいくつかあります。<br/>							まず、日本国籍を持つ人であればオンラインで申し込むことができ、個人差はあるものの早ければ48時間以内にビザの申請が完了します。ワーホリビザを使う事で入国日から１年間の滞在が可能ですが、オーストラリアには「セカンドワーホリ」という制度があり、特定の条件を満たすことで１年間の期限を２年間に延長することも可能です。オーストラリアでのワーホリを望む多くの人がこのセカンドワーホリの資格を取得することを目標としています。しかし条件を満たすためには、政府指定の場所で特定期間就労する必要があるので、事前に自分で調べておきましょう。事前に計画をしっかり立てて、後悔のない時間にしてくださいね。<br/>						</td>					</tr>				</tbody></table>			</div>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'パース';
	$number_to_display = '2';
	$start_display_from = ''; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<h2 id="st1-2" class="sec-title">パースってどんなところ？</h2>	<p class="text01">		パースという都市名を聞いて、すぐに思い浮かぶ人は少ないと思います。<br/>		オーストラリアの都市というと、シドニーやメルボルンが有名ですよね。パースは西オーストラリアにある都市です。<br/>		人口は約9000人。「世界で一番美しい」「世界で一番住みやすい」と評されることもある素晴らしい都市です。<br/>		有名なコクチョウの原産でも有名なスワン川は有名です。<br/>		海と間違うほどの広い綺麗な川です。インド洋に面した地域には美しい砂浜が広がっていて、観光客も非常に多く訪れています。<br/>	</p>	<p class="text01">		街の外観は、さすが「美しい」と言われるだけあって、アパートメントや建造物、どれもセンスがいいものです。<br/>		公園がたくさんあり、自然が多いです。<br/>		中でもキングスパークは世界最大の面積を誇る公園で、日中は世代を問わず大勢の人で賑わい、夜は観光スポットとしても人気です。		基本的には天気がよく、夏でも湿気がないので、日本のように肌がベタついて過ごしにくいということはありません。<br/>	</p>	<p class="text01">		しかし、日差しは強く、紫外線は日本の7倍とも言われており、肌や髪の毛を傷める原因になりそうです。<br/>
		湿気がないために、昼間と夜の気温差は激しいので、ワーホリに行く際には注意が必要になります。<br/>
		日本と比べると乾燥が激しいので、実際に生活してみるとびっくりしてしまうかもしれませんね。<br/>
	</p>
	<p class="text01">
		オーストラリアは、海外からの移住者が多い国として知られていますが、最近のパースには、イギリスからの移住者が多く、最近ではイギリス生まれの移住者が20％を越しています。<br/>
		ヨーロッパ系の人種が多いのかと思いきや、アジアに近い地域のため、アジア系の人種も非常に多い都市です。<br/>
	</p>
	<p class="text01">
		安全な日本で生活していると心配になる治安のことですが、世界中から住みたいと言われるほどの都市ですから、普通に注意していれば、事件に巻き込まれることはありません。むしろ、色々な国の人がいるために、あらゆる国の文化を知るいい機会です。<br/>
		ワーホリで、海外で色々な経験がしたい！自分の知らない世界が知りたい！という人にはオススメの場所ですよ。<br/>
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'パース';
	$number_to_display = '2';
	$start_display_from = '2'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);            
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st1-3" class="sec-title">パース（オーストラリア）にワーホリに行く前の準備</h2>
	<p class="text01">		ここでは、日本でやっておくべき下準備について考えていくことにしましょう。<br/>	</p>
	<h3 class="h3-01">英語の勉強</h3>
	<p class="text01">
		何の準備をしていなくても、英語の勉強は必須です。<br/>
		何の下準備もしていかず、ワーホリに行って英語が喋れるようになると思ったら大間違いです！<br/>
		オーストラリアの空港に辿り着いた時、滞在先に行く交通機関の中、スーパーで食料品を買う時、行った初日から、英会話は必要になります。
		簡単な挨拶や、日常生活の中で必要と思われるような会話は、日本にいるうちにチェックしておきましょう。<br/>
	</p>
	<p class="text01">
		オーストラリアに語学学習に行く人は、英語の訛りを不安視している人が多いです。<br/>
		これは英語力がない状態だからこその不安と言えるかもしれません。<br/>
		ネイティブでもない限り、出身地域の訛りが出るのは仕方のないこと。<br/>
		まずは物怖じせずに話せるようになること、外国人とコミュニケーションを取れるようになることが一番ですので、訛りについては気にせず、英語を話せる環境に身を置けるということをポジティブに考えて欲しいと思います。<br/>
	</p>

	<h3 class="h3-01">滞在先・語学学校選び</h3>
	<p class="text01">
		パースに行って、最初にどの地域に滞在するのか、どの語学学校で英語を学ぶのかは決めていきましょう。<br/>
		最初は語学学校に入り、英語の基礎を積み重ねてから、外に出た方が、心配事も少なくなりますし、現地の人とのコミュニケーションもはかどります。<br/>
	</p>

	<p class="text01">
		パース（オーストラリア）の語学学校は、直接話法という方法で英語を教えてくれます。<br/>
		オーストラリアには、年間に何人も外国人が訪れるため、先生たちも慣れたもので、質の高い英語教育を行ってくれると有名です。<br/>
	</p>

	<h3 class="h3-01">荷造りは慎重に</h3>
	<p class="text01">
		パースの物価の高さは世界トップレベル。<br/>
		日本で買えるものはできるだけ持って行って、余計な出費は防ぎたいものです。<br/>
		海外旅行に行くときによく言われる、「必要なものがあったら、向こうで買えばいい」という考えは捨てましょう。<br/>
		「日本で買っておけばもっと安く済んだのに」と思うものばかりなのです。<br/>
	</p>
	<p class="text01">
		日差しの強いパースですから、日焼け止めは必須。<br/>
		夏に行くのなら、半袖Tシャツはかさ張らず持って行けるので何枚か持って行きましょう。<br/>
		昼夜の寒暖差が激しいため、羽織ものは必須ですよ。<br/>
	</p>

	<h3 class="h3-01">資金・ビザ・保険のこと</h3>
	<p class="text01">
		面倒なことは後回しにしがちですが、無事にオーストラリアに入国して、ワーホリ期間を充実したものにするためにも、お金、ビザ、保険のことは忘れることはできません。語学学校に払うお金や、住む場所に納める家賃、病気になった時や事故に遭った時に助けてくれる保険への加入は何よりも重要です。<br/>
	</p>



	<h2 id="st1-4" class="sec-title">パースでどんなワーホリ生活が送れるの？</h2>

	<p class="text01">
		では、オーストラリアへのワーホリ申請に許可が出て、どんな風な生活を送ることができるのか紹介しますね。<br/>
		パースはとても暖かい地域で、そういった地域の特徴なのか人もとても優しいです。<br/>
		広大な自然に囲まれた場所で、温厚な人たちに囲まれながら英語を学び、生活ができるよい環境です。<br/>
		オーストラリアのワーホリビザは、どんな目的でもOKだとされています。<br/>
		例えば、観光目的でもOK、仕事をしてもOK、本当にただの休暇（遊び）でもOK、勉強目的でもOK。何でもOKなのです。<br/>
		このように自由な行動が取れるビザは大変珍しく、これを有効活用しない手はありません！<br/>
	</p>

	<h3 class="h3-01">仕事をする</h3>
	<p class="text01">
		せっかく、海外で生活をするのなら、少しは自分でお金を稼いでみたいもの。<br/>
		英語の勉強にも繋がりますし、是非、パースで仕事を探しましょう。<br/>
	</p>
	<p class="text01">
		オーストラリアならではの仕事と言えば、ファームでの仕事！農場の仕事です。<br/>
		オーストラリアの農場経営者は、ワーホリで来る外国人を重要な労働者だと認識していますので、雇ってもらえる確率が高いです。<br/>
		ファームでの仕事は、人から紹介してもらうことが多いので、語学学校などで人脈作りをしておくと、役に立ちますよ。<br/>
		ファームの他にも色々な仕事があります。<br/>
	</p>
	<p class="text01">
		カフェや日本食レストラン、ツアーガイド、免税店のスタッフなど。<br/>
		日本語が話せるというあなたならではの強みを活かして仕事を探して下さい！<br/>
		英語力がついたら、英語を使ってする仕事に応募してみてもいいでしょう。<br/>
		求人に応募する前には、履歴書と面接の準備が必要です。<br/>
		メールで履歴書を送ってくれと言われる場合も多いので、早めにデータとして準備しておくに越したことはありません。<br/>
	</p>

	<h3 class="h3-01">勉強をする</h3>
	<p class="text01">
		オーストラリアのパースに行く目的は英語力を付けること！<br/>
		日本に帰ってからも英語を使った仕事ができたらいいな！そう思ってワーホリを利用する人も多いでしょう。<br/>
		そんな人は、語学学校で英語を勉強しましょう。学校によって、授業の内容もバラバラです。<br/>
	</p>
	<p class="text01">
		IELTS、TOEFLの試験対策をしてくれる学校もありますし、進学するための英語の授業がカリキュラムにあるところもあります。<br/>
		生徒の人種も日本人が多いところもあれば、少ないところもあり、午前のみ、午後のみという学校もあるので、自分の目的や生活スタイルに合わせて学校選びができます。ワーホリの後、実際に大学や大学院に進学したという人もいるんですよ！<br/>
	</p>

	<h3 class="h3-01">観光をする・遊ぶ</h3>
	<p class="text01">
		オーストラリアには、パースの他にも魅力的な地がたくさんあります。<br/>
		せっかく来たんだから滞在中にシドニーやメルボルン、ケアンズなどで有名どころを抑えておきたい！と思いますよね。<br/>
		海も綺麗ですからスキューバダイビングをするもよし、世界第二位の一枚岩・エアーズロックだって見たいですよね！<br/>
		コアラを抱っこしたり、カンガルーを見たい！とも思いますね。<br/>
	</p>
	<p class="text01">
		仕事をしてお金を貯めれば、全部可能です！<br/>
		ここでしかできない経験をして、日本に帰った時に一回りも二回りも大きな人間になって帰りましょう。<br/>
	</p>

	<h3 class="h3-01">事前準備をしっかり行い、充実したワーホリ生活を送りましょう！</h3>
	<p class="text01">
		ここまで読んでいただいて、パースの概要を理解されたと思います。<br/>
		ただ、暮らしやすい街とはいえ、パースは海外の都市。<br/>
		事前情報をしっかり入れることで、無用なトラブルを避けるようにしましょう。<br/>
	</p>
	<p class="text01">
		ワーキングホリデー協会では、志望者の国別、また目的に合ったセミナーを開催しています。<br/>
		まずは無料の初心者セミナーに参加し、ご自分の疑問を解決しましょう。<br/>
		セミナーでは、より深い情報を提供しています。<br/>
	</p>
	<p class="text01">
		また、ワーキングホリデー協会では、メンバー登録を行っています。<br/>
		登録された方には、個別カウンセリングや特別セミナーへの参加、出発前後のケアまで、幅広くサポートします。<br/>
		無料セミナーやメンバー登録を利用して、ご自身の夢の実現に踏み出してください！<br/>
	</p>
	<p style="color:red;text-align:center;margin-top:8px;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'パース';
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