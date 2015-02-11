<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->fncFacebookMeta_function=true;

$header_obj->title_page='アメリカのワーキングホリデー（ワーホリ）';
$header_obj->description_page='アメリカは近代的な大都市と圧倒的な大自然、そして世界最高水準の教育機関を有する大国家です。
				残念ながら現在アメリカにはワーキングホリデー（ワーホリ）制度がなく、他国のように就労する為のビザも簡単に取得できません。
				アメリカにはワーキングホリデー（ワーホリ）制度に近いビザもなく、観光ビザや学生ビザも基本的に働くことはできません。アメリカのビザはワーキングホリデー（ワーホリ）ビザの様に何でもできるわけではないので、留学する場合は勉強をすることが中心となるでしょう。';
$header_obj->keywords_page ='アメリカ,ワーキングホリデー,ワーホリ,留学,ビザ,方法';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

if ($header_obj->computer_use() === false && $_SESSION['pc'] != 'on') {
	$header_obj->add_css_files = '<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" /><link href="/sp/accordion/sp.css" rel="stylesheet" type="text/css" />';
	$header_obj->add_js_files = '<script src="/sp/accordion/sp.js" type="text/javascript"></script>';
}

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../../images/mainimg/usa-countrypage.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'アメリカのワーキングホリデー（ワーホリ）';

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
			<div class="wh_div"><a href="../newzealand/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>ニュージーランドのワーホリ</a></div>
		</div>
	</div>
	<div style="clear:both; height:10px;">&nbsp;</div>

	<div class="step_title">
	アメリカのワーキングホリデー（ワーホリ）</div>
	  <p class="text01">アメリカは近代的な大都市と圧倒的な大自然、そして世界最高水準の教育機関を有する大国家です。</p>

	  <table class="tableofcontents">
	   	 <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1">アメリカってどんな国？</a></li>
			  <li><a href="#st2">アメリカにはワーキングホリデー（ワーホリ）がない！？</a></li>
			  <li><a href="#st3">ワーキングホリデー（ワーホリ）制度がないけど、アメリカ留学が人気の理由</a></li>
			  <li><a href="#st4">アメリカのビザについて</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>

	<h2 id="st1" class="sec-title">アメリカってどんな国？</h2>
	<p class="text01">
	アメリカ、正式名称アメリカ合衆国は全50州からなる連邦共和国です。アメリカ合衆国最大の特徴は各州が自治権を持って、一つひとつが国家のように存在していることでしょう。この為地域によって習慣や風習はもちろん、法律なども違ってきます。アメリカはその国土も非常に大きく、面積は日本の約23倍、世界第3位となっています。広大な大地に非常に多彩な気候や自然が広がっています。一つの場所や地域を訪れただけでアメリカという国を語ることはできないでしょう。</p>
	<p class="text01">
	また、アメリカは様々な面で世界的に強い影響力を持つ国です。アメリカは留学先として非常に高い人気を誇っています。その理由として、多くの分野で常に世界最先端の情報を発信している情報量の多さや、アメリカの広大な国土から選べる都市の多さ、そして世界トップレベルの教育水準を誇るアメリカの教育です。</p>

	<center><img src="../img/usamap.gif" alt="アメリカの地図"></center>

	<p class="text01">
	アメリカも元来移民から始まった国なので、現在アメリカの国籍を持つ人たちも多種多様です。イギリス系が多いと思われがちですが、実際はドイツ系やアイルランド系が最多数を占めています。アメリカの人種の多さは「人種のサラダボール」とも称され、「混ざり合ってはいないけれど、共存している」とされています。

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  ワーキングホリデー（ワーホリ）に関する無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<h2 id="st2" class="sec-title">アメリカにはワーキングホリデー（ワーホリ）がない！？</h2>
	<p class="text01">
	アメリカに留学する際気をつけなくてはならないのが、アメリカはワーキングホリデー（ワーホリ）協定国ではなく、ワーキングホリデー（ワーホリ）の制度がないということです。また、アメリカにはワーキングホリデー（ワーホリ）ビザの様に個人取得可能で就労することができるビザもないので、働く事を目的としてアメリカに渡航することは簡単ではありません。アメリカに留学する際は語学力向上を目的とした語学留学が進められている理由がここにあります。</p>
	<p class="text01">
	アメリカで個人取得することができる観光ビザや学生ビザは基本的にアメリカで働くこと目的としておらず、ワーキングホリデー（ワーホリ）ビザの様に自由に仕事を見つけ働くことができません。また、ビザ取得の手順も大使館での面接が義務付けられていたりするので、各国ワーキングホリデー（ワーホリ）ビザと比較して手順が複雑です。</p>
	<p class="text01">
	現在アメリカにワーキングホリデー（ワーホリ）制度がない理由として、アメリカには違法移民が多いことがあげられています。違法移民を含めて、移民の数を極力増やしたくないと考えている為、ワーキングホリデー（ワーホリ）制度の様な「簡単に申請出来て、働くことが出来る長期滞在が可能なビザ」を発行していないのだと考えられています。またアメリカはテロ事件以降、海外からの入国自体に厳しい姿勢をとっていて、ワーキングホリデー（ワーホリ）制度が開始されないことはもちろん、学生ビザや就労ビザの申請も厳しくなっています</p>
	<p class="text01">
	アメリカに住む外国人は移民局に住所を登録する義務があり、今後もワーキングホリデー（ワーホリ）のように「どこに住んでも自由」というようなビザを導入見込みはないかもしれません。</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  ワーキングホリデー（ワーホリ）に関する無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st3" class="sec-title">ワーキングホリデー（ワーホリ）制度がないけど、アメリカ留学が人気の理由</h2>
	<p class="text01">
	ワーキングホリデー（ワーホリ）制度のないアメリカですが、留学先の国として非常に人気があります。その理由として、アメリカには高等教育を受けられる大学や、地域の人向けに教育を提供しているコミュニティカレッジなど、年齢やバックグラウンドに関係なく教育が受けられるシステムが整っていることが挙げられます。</p>		
	<p class="text01">
	アメリカの教育制度は世界的に見ても最高水準であり、最先端の知識や技術を持っているからアメリカに留学したいと考える人も多いです。また学生ビザの期間はワーキングホリデー（ワーホリ）のように働くことが出来ませんが、将来アメリカの企業で働くといった目標を持ってアメリカへ留学する生徒も少なくありません。</p>
	<p class="text01">
	アメリカで語学や専門知識を習得した後、アメリカ以外の国にワーキングホリデー（ワーホリ）制度を使って働きに行く方も多いです。また、アメリカの学校は学べる教科が豊富にあり、日本や他のワーキングホリデー（ワーホリ）協定国にはないアメリカ独自の特殊な知識や資格なども身につけることができます。アメリカの学校では、一般的に実践ですぐに役立つ能力や知識を身につけることが重要視されているので、アメリカではより実践的に語学などが習得できる課外活動やインターンシップなどの制度が充実しています。</p>
	<p class="text01">
	これらのことから、アメリカへの留学をワーキングホリデー（ワーホリ）前のステップアップとして使われる方も多く、実際にアメリカでしっかりとした語学力と専門知識を身につけておけばその後アメリカ以外の国にワーキングホリデー（ワーホリ）制度を使って渡航しても問題なく仕事を探せるでしょう。</p>
	<p class="text01">
	またアメリカは古くから日本と関わりの深い国でもあります。その為日本人はアメリカをイメージしやすく、例えば「ニューヨーク」と言われると摩天楼がすぐ頭に浮かぶと思います。このように日本人がアメリカに対して親近感を持っているのも、アメリカ人気の要因でしょう。</p>
	<p class="text01">
	アメリカもう一つの魅力として、国土の広さと都市の多さがあります。アメリカほど行く場所によって文化が変わる国はないでしょう。</p>
	<p class="text01">
	その理由はアメリカが合衆国であるためで、州によって法律や生活習慣などが大きく違うことにあります。ニューヨークやロサンゼルスのような大型都市から、ハワイやテキサスのように大自然に囲まれた州など、ワーキングホリデー（ワーホリ）こそありませんがアメリカでは住む地域を変え、全く違う体験をしたい人もアメリカを選んでいます。</p>
	<p class="text01">
	多くの都市から留学先を選べるので、他国にワーキングホリデー（ワーホリ）で行く前にアメリカでその国や都市に近い環境の場所を選んで過ごすこともできます。例えばカナダにワーキングホリデー（ワーホリ）で渡航したい人は、比較的気候が近く距離も遠くないニューヨークに留学をして、後のワーキングホリデー（ワーホリ）に繋げるのも良いかもしれません。</p>
	<p class="text01">
	逆に他国にワーキングホリデー（ワーホリ）で行っている間に、アメリカを旅行する人も多いです。アメリカには近代的な観光地と数多くの世界遺産があり、ワーキングホリデー（ワーホリ）の短期間で回りきることは難しいですが、思い出作りにアメリカを訪れる人も多いです。</p>
	<p class="text01">
	またアメリカは様々なポップカルチャーの生みの親であることでも知られており、今まで多くの音楽や映画がアメリカで作られました。さらにアメリカは教育、医療、情報通信など様々な分野で常に世界をリードしてきた実績があり、アメリカへ留学することは、それらの様々なジャンルの最先端情報を手にすることが出来るということです。たとえワーキングホリデー（ワーホリ）制度がなくても、アメリカは日本人にとって魅力的な国なのでしょう。</p>
	<p class="text01">
	ワーキングホリデー（ワーホリ）制度のないアメリカへの留学が人気な理由は、このような要素が数多く存在するからです。ワーキングホリデー（ワーホリ）制度がなくても、アメリカは日本人にって身近な国なのかもしれません。</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  ワーキングホリデー（ワーホリ）に関する無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st4" class="sec-title">アメリカのビザについて</h2>
	<p class="text01">
	アメリカに渡航される人が使うビザは基本的に留学ビザ(F,M)と観光ビザ(B)です。注意して頂きたい点は、アメリカには現段階でワーキングホリデー（ワーホリ）制度がない点と、アメリカで個人取得できるビザは他国のビザやワーキングホリデー（ワーホリ）ビザと違い、アメリカでの就労が難しいという点です。また申請自体も手順が多く難しい為、ワーキングホリデー（ワーホリ）協定国のようにビザを簡単に申請することはできないでしょう。</p>
	<p class="text01">
	アメリカで個人取得が可能なビザ大きく分けて２通りです。</p>
	<p class="text01 block01">
	学生ビザ
	</p>
			<p class="text01">
			アメリカの学生ビザには留学生ビザ（F-1）と専門学生ビザ（M-1）があります。どちらも基本的に就学を目的としたビザなので、ワーキングホリデー（ワーホリ）のように働くことは出来ません。またビザを申請するにあたって、 I-20と呼ばれる入学許可書を取得する必要があります。</p>
			<p class="text01">
			これらのビザの滞在可能期間は、原則I-20に記載されている就学期間＋αとなっています。また留学中に長期にわたって米国を出国する場合、5ヵ月以内で有効なビザと学校の責任者によって署名されたI-20を所持していれば、再入国が可能です。</p>
			<p class="text01">
			ワーキングホリデー（ワーホリ）ビザと違って非常に限られた状況であれば働くことも可能ではありますが、ワーキングホリデー（ワーホリ）のように自由に働くことはできません。</p>
	<p class="text01 block01">
	観光ビザ
	</p>
			<p class="text01">
			観光ビザは通称「Bビザ」と呼ばれます。主に観光目的でアメリカに入国する人に発行されますが、アメリカの場合、90日以内の観光や知人訪問、商用で米国に滞在する場合、ビザ申請の必要がありません。</p>
			<p class="text01">
			このビザもワーキングホリデー（ワーホリ）協定国のビザとは違い、観光ビザで働くことはもちろん、学校に通うことなどもできません。また、Bビザで入国した旅行者に対する最大延長滞在期間は6ヶ月です。</p>
	<br/>
	<br/>
	<p class="text01">
	アメリカには自由に働くことのできるワーキングホリデー（ワーホリ）ビザがなく、観光ビザでは働けず、また学生ビザは条件を満たすことで部分的な就労はできますが、週20時間までしか働けない等、様々な制約がつきます。アメリカで働くためのビザとして短期就労ビザ(H)などがありますが、このビザもワーキングホリデー（ワーホリ）ビザとは違い不定期雇用に対しては発給されることがなく、アメリカの雇用主が具体的な求人を出していることが条件となっています。このためワーキングホリデー（ワーホリ）制度のないアメリカで働くことは、就職する企業が決まっている場合や学生ビザでの部分的な就労を除くと難しいでしょう。</p>
	<p class="text01">
	しかしアメリカで語学の経験を積み、アメリカ以外の国へワーキングホリデー（ワーホリ）に行くことができますし、他の国へワーキングホリデー（ワーホリ）で渡航している最中にアメリカへ旅行する人も多いです。ワーキングホリデー（ワーホリ）を考えている人にもアメリカ留学はお勧めです。</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  ワーキングホリデー（ワーホリ）に関する無料セミナー情報をもっと見る</a>
	</p>

	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="../canada/" class="wh_menu"><img src="../../images/label_big_01.jpg"><br/>カナダのワーホリ</a></div>
			<div class="wh_div"><a href="../australia/" class="wh_menu"><img src="../../images/label_big_02.jpg"><br/>オーストラリアのワーホリ</a></div>
			<div class="wh_div"><a href="../uk/" class="wh_menu"><img src="../../images/label_big_03.jpg"><br/>イギリスのワーホリ</a></div>
			<div class="wh_div"><a href="../newzealand/" class="wh_menu"><img src="../../images/label_big_04.jpg"><br/>ニュージーランドのワーホリ</a></div>
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