<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->fncFacebookMeta_function=true;
$header_obj->title_page='ニュージーランドのワーキングホリデー（ワーホリ）';
$header_obj->description_page='ニュージーランドは観光地や避暑地としての人気が高く、観光だけでなくワーキングホリデー（ワーホリ）や留学先として人気の高い国です。
				集中して語学学習がしたい人もニュージーランドへワーキングホリデー（ワーホリ）を使って行かれます。ニュージーランドは元々イギリスの教育制度に基づいた教育を行っている為、ワーキングホリデー（ワーホリ）の期間中世界レベルの多種多様な教育を受けることができ、
				ニュージーランドの人々ともすぐになじむことが出来るのでワーキングホリデー（ワーホリ）ビザを使って英語上達をしたい人にとってニュージーランドは最適の場所と言っていいでしょう。';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

if ($header_obj->computer_use() === false && $_SESSION['pc'] != 'on') {
	$header_obj->add_css_files = '<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" /><link href="/sp/accordion/sp.css" rel="stylesheet" type="text/css" />';
	$header_obj->add_js_files = '<script src="/sp/accordion/sp.js" type="text/javascript"></script>';
}

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../../images/mainimg/NZ-countrypage.png" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'ニュージーランドのワーキングホリデー（ワーホリ）';

$header_obj->display_header();
include('calendar_module/mod_event_horizontal.php');
?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(''); ?>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="../canada/" class="wh_menu"><img src="../../images/label_big_01.jpg"><br/>カナダのワーホリ</a></div>
			<div class="wh_div"><a href="../australia/" class="wh_menu"><img src="../../images/label_big_02.jpg"><br/>オーストラリアのワーホリ</a></div>
			<div class="wh_div"><a href="../uk/" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>イギリスのワーホリ</a></div>
			<div class="wh_div"><a href="../america/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>アメリカのワーホリ</a></div>
		</div>
	</div>
	<div style="clear:both; height:10px;">&nbsp;</div>

	<div class="step_title">
	ニュージーランドのワーキングホリデー（ワーホリ）</div>
	  <p class="text01">ニュージーランドは観光地や避暑地としての人気が高く<br/>
			観光だけでなくワーキングホリデー（ワーホリ）や留学先として人気の高い国です。</p>

	  <table class="tableofcontents">
	   	 <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1">1　ニュージーランドってどんな国？</a></li>
			  <li><a href="#st2">2　大自然溢れるニュージーランド！</a></li>
			  <li><a href="#st3">3　どうしてニュージーランドでワーキングホリデー（ワーホリ）なの？</a></li>
			  <li><a href="#st4">4　ニュージーランドのワーキングホリデー（ワーホリ）ビザについて</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>

	<h2 id="st1" class="sec-title">ニュージーランドってどんな国？</h2>
	<p class="text01">
	ニュージーランドは観光地や避暑地としての人気が高く、観光だけでなくワーキングホリデー（ワーホリ）や留学先として人気の高い国です。</p>
	<p class="text01">
	ニュージーランドは小さな島国ですが、国内の至る場所でニュージーランドの大自然と触れ合うことができ、場所によって全く違った環境や生態系や体験をすることができるでしょう。
	またニュージーランドの国土は北島と南島を合わせても日本より国面積が小さく、１カ月もかからずニュージーランド1周旅行ができるのも特徴です。</p>
	<p class="text01">
	ニュージーランドには北島と南島があり、その間にはクック海峡があります。ニュージーランドの天候は一年を通して良好で、夏は涼しく、冬にも特別寒くなることがありません。こういった天候の良さも、ワーキングホリデー（ワーホリ）でニュージーランドに行く人が多い理由の一つでしょう。ニュージーランドは1年を通して温暖な気候であるのですが、北島・南島ともに多くのスキー場があり、世界中からワーキングホリデー（ワーホリ）などを使ってスキーヤーがニュージーランドに訪れます。南半球の地理的、気候的な条件も好まれ、世界各国のスキー連盟の冬季強化合宿地に選ばれている国です！
</p>

	<center><img src="../img/nzmap.gif" alt="ニュージーランドの地図"></center>
	<p class="text01">
	ワーキングホリデー（ワーホリ）制度を使って映画ロードオブザリングやラストサムライの撮影の舞台にもなったニュージーランドの太古の自然を見て回ったり、国鳥キーウィなどニュージーランドにしかいない珍しい生き物触れ合ったり、ニュージーランドにワーキングホリデー（ワーホリ）を使って渡航して、多彩なアウトドア・アクティビティを楽しむことが出来ます。</p>


	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st2" class="sec-title">大自然溢れる国、ニュージーランド！</h2>
	<p class="text01">
	ニュージーランドは北島と南島で大きく環境が違うことも特徴的です。ニュージーランドの北島はオークランドなどの都市が集中している都市地域で、ワーキングホリデー（ワーホリ）の期間中に通える語学学校などが多く点在しています。逆にニュージーランドの南島は自然の多くがそのまま残されていて、中央には「南半球のアルプス山脈」と呼ばれるニュージーランドの観光名所もあります。。</p>
	<p class="text01">
	北島にはニュージーランドの首都であるウェリントンや、北の大都市オークランドなど都市や政府機関が集中していて、ワーキングホリデー（ワーホリ）の渡航者に人気の地域となっています。オークランドははニュージーランド最大の都会でありながら周辺に変化に富む自然環境を持っているのが特徴的な街で、ゆったりとしたニュージーランド特有の環境で過ごすことが出来る為、観光やワーキングホリデー（ワーホリ）での渡航先としてニュージーランドでも人気の都市です。また北島には温泉地として有名なロトルア、タウポ、ワイトモ鍾乳洞などもあり、南島ほど険しくはないのですが、火山活動の活発な山脈が存在しています。</p>
	<p class="text01">
	南島の特徴的な都市はクライストチャーチで、ニュージーランドでもその緑溢れる街並みから“イングランド以外で最もイングランドらしい街”とも呼ばれており、ワーキングホリデー（ワーホリ）で渡航先として選ぶ方も多いです。南島にはニュージーランドが誇る大自然と様々なアクティビティがあり、島の中央には「南半球のアルプス山脈」とも呼ばれる南アルプス山脈がそびえています。その中でもニュージーランド有数のウィンタースポーツ街クィーンズタウンには、日本とニュージーランドで季節が逆になることを利用して、夏休みの期間だけニュージーランドにスノーボード旅行へ行く人も多いようです。またニュージーランドで有名なフィヨルドもここで見ることができ、ワーキングホリデー（ワーホリ）の期間中に観光に行く人が多いです。</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st3" class="sec-title">どうしてニュージーランドでワーキングホリデー（ワーホリ）なの？</h2>
	<p class="text01">
	ニュージーランドがワーキングホリデー（ワーホリ）や留学先として人気の理由は多くありますが、そのひとつにニュージーランドのアクティビティの多さが挙げられます。ニュージーランドの気候は年間通して温暖で過ごしやすく、ニュージーランドには数々の世界遺産と世界有数の大自然が体験できる数多くのアクティビティがあるので、ワーキングホリデー（ワーホリ）などでニュージーランドを訪れた人の多くがこの大自然を満喫されます。</p>
	<p class="text01">
	また、ニュージーランドに住む人たちは非常に温厚な性格で、国風からからニュージーランド国籍以外の人に対しでもやさしく接してくれます。なのでワーキングホリデー（ワーホリ）ビザなどを使って初めて海外に渡航される人でも、ニュージーランドで問題なく生活できるのではないでしょうか。ニュージーランドの人々にすぐ馴染むことができるのでワーキングホリデー（ワーホリ）ビザを使って英語上達をしたい人にとって最適の場所と言っていいでしょう。ニュージーランドのゆったりとした環境で働きながら学ぶことができます。</p>
	<p class="text01">
	勉強面でも、ニュージーランドの語学学習はイギリスの教育制度に基づいた教育を行っている為非常に高い水準で多種多様な教育を受けることができ、ニュージーランドで勉強する人は学ぶことに対する意識が高いのでしっかりと勉強することができます。</p>


	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>


	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st4" class="sec-title">ニュージーランドのワーキングホリデー（ワーホリ）ビザについて</h2>
	<p class="text01">
	ニュージーランドのワーキングホリデー（ワーホリ）ビザは、日本国籍を持つ18才から30才の独身者または、子供を同伴しない既婚者で、ニュージーランドに1年までの長期滞在を希望される方を対象に発行されます。</p>

	<p class="text01">
	ここでニュージーランドビザ申請までの流れを解説します。<br/>
	</p>
	<table class="nittei">
		<tr>
			<td class="nittei_span">
				ステップ１
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					まずはニュージーランド　ワーキングホリデー（ワーホリ）ビザの要項を確認する！！
				</div>
				<div class="nittei_setumei">
					ワーキングホリデー（ワーホリ）ビザを申請する時、しっかりと申請要項を確認することが非常に大切です！
					どんなにワーキングホリデー（ワーホリ）行きたくて完璧に準備をしていても、申請資格を満たしていなければワーキングホリデー（ワーホリ）ビザを申請することが出来ません。<br/>
					ニュージーランド大使館HPへ行き、しっかりとワーキングホリデー（ワーホリ）ビザ申請要項と申請資格を確認しましょう。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				ステップ２
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					申請に必要な物を準備！
				</div>
				<div class="nittei_setumei">
					ニュージーランドのワーキングホリデー（ワーホリ）ビザの申請に必要な物は<br/>
					<b>・有効なパスポート（残存期間が15ヶ月以上）<br/>
					・クレジットカード<br/>
					・Eメールアドレス<br/>
					・運転免許証等の身分証明書</b><br/>
					上記の4点です。<br/>
					特にパスポートの有効期限などは見落としがちなので、必ずチェックするようにしましょう。<br/>
					また、Eメールアドレスも携帯電話のものではなく、パソコンのメールアドレスが必要となります。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				ステップ３
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					ビザ申請！
				</div>
				<div class="nittei_setumei">
					必要な物が全て揃ったら、ニュージーランド移民局HPからワーキングホリデー（ワーホリ）ビザの申請を行います。申請する際は、ホームページ上にユーザー名とパスワードを設定してマイページを作成する必要があります。申請の詳細な手引きはNZ大使館のHPで確認して下さい。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				ステップ４
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					ニュージーランド移民局での審査
				</div>
				<div class="nittei_setumei">
					申請の手続きが完了すると、ニュージーランド移民局からメールが届きます。このメールに掲載されているリンク先から所定用紙をダウンロードし、健康診断の検査結果を記入し、ニュージーランド移民局へ郵送します。<br/>
					この健康診断では、指定された病院で結核の審査を受けて頂く必要があります。
				</div>
			</td>
		</tr>
		<tr>
			<td class="nittei_span">
				ステップ５
			</td>
			<td class="nittei_naiyou">
				<div class="nittei_title">
					ビザ発給！
				</div>
				<div class="nittei_setumei">
					すべての審査が終わると、移民局からワーキングホリデー（ワーホリ）ビザ発給のメールが届きます！ここまできたらあと少し！届いたメールの「ELECTRONIC VISA」をプリントアウトし、ニュージーランドに入国する際にパスポートと一緒に提示しましょう！
				</div>
			</td>
		</tr>
	</table>

	<p class="text01">
	多くの国ではワーキングホリデー（ワーホリ）の期間中、同一雇用主の元で一定期間しか働くことが出来ません。しかしニュージーランドのワーキングホリデー（ワーホリ）制度では、同じ雇用主の元で1年間働けることができます。ワーキングホリデー（ワーホリ）の期間中に実際に働ける仕事場は都会のオークランドなどの都市部に集中している傾向がありますが、ワイン畑など農業の仕事が盛んなのでニュージーランドのどの都市に行っても仕事探しには苦労しないでしょう。</p>
	<p class="text01">
	ニュージーランドにもオーストラリアのようにワーキングホリデー（ワーホリ）ビザを延長できる制度があり、農場の仕事に3カ月携わることでワーキングホリデー（ワーホリ）でニュージーランドに滞在出来る期間を3ヶ月延長できるようになりました。</p>
	<p class="text01">
	ニュージーランドのワーキングホリデー（ワーホリ）ビザは、オンラインで申請して頂けます。ニュージーランドのワーキングホリデー（ワーホリ）ビザ申請時に必要なものは、有効なパスポート（期間１年６ヶ月以上）、クレジットカード、E-mailアドレス、運転免許証や健康保険証などの証明書です。また、ニュージーランドのワーキングホリデー（ワーホリ）ビザ申請の特徴として、指定病院での結核検査を受けて頂く必要があります。なのでニュージーランドのワーキングホリデー（ワーホリ）ビザを申請する際は、ある程度余裕を持って行動を始めるとよいでしょう。</p>

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
			<div class="wh_div"><a href="../uk/" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>ニュージーランドのワーホリ</a></div>
			<div class="wh_div"><a href="../usa/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>アメリカのワーホリ</a></div>
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