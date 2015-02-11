<?php
require_once '../../../include/header.php';
require_once '../../../include/links.php';

$links_obj = new Links();
$header_obj = new Header();


$header_obj->title_page='トロントワーホリがあなたを変える';
$header_obj->description_page='トロントのワーホリは刺激が満載！ 二つの言語が息づく街、トロント。雄大な自然、複雑な歴史、知り尽くしても飽きない情報をここで紹介。きっと、その先で新しいあなたに出会える。';
$header_obj->keywords_page ='トロント,ワーホリ,滞在,ビザ,海外';
$header_obj->fncFacebookMeta_function = true;
$header_obj->add_css_files='<link href="/wh/css/wh.css" rel="stylesheet" type="text/css" />';

$header_obj->fncMenuHead_imghtml='<img id="top-mainimg" src="../../../images/mainimg/CA-countrypage.png" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text='トロントワーホリがあなたを変える | 日本ワーキング・ホリデー協会';

$header_obj->display_header();

include('../../../calendar_module/mod_event_horizontal.php');

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>

	<div class="wh_box">
		<div class="wh_box1">
			<div class="wh_div"><a href="http://www.jawhm.or.jp/system.html" class="wh_menu"><img src="../../../images/label_big_01.jpg"><br/>ワーホリって何？</a></div>
			<div class="wh_div"><a href="../../tame.php" class="wh_menu"><img src="../../../images/label_big_02.jpg"><br/>ワーホリのタメになる話</a></div>
			<div class="wh_div"><a href="http://www.jawhm.or.jp/visa/v-can.html" class="wh_menu"><img src="../../../images/label_big_03.jpg"><br/>ワーホリビザの申請手順</a></div>
			<div class="wh_div"><a href="../../australia/" class="wh_menu"><img src="../../../images/label_big_04.jpg"><br/>オーストラリアのワーホリ</a></div>
		</div>
	</div>
	<div style="clear:both; height:10px;">&nbsp;</div>

	<div class="step_title">
		トロントでワーキングホリデー
	</div>
	  <p class="text01">初めての海外でも安全で安心のトロント。生きた英語と豊な自然を堪能できるトロントでのワーキングホリデー生活。</p>
	  <table class="tableofcontents">
	    <tr>
		  <th>目次</th>
		  <td>
		    <ul>
			  <li><a href="#st1-1">トロントワーホリの予備知識</a></li>
			  <li><a href="#st1-2">トロントワーホリあれこれ</a></li>
			  <li><a href="#st1-3">トロントワーホリの制度</a></li>
			  <li><a href="#st1-4">トロントワーホリ中の心配事</a></li>
		    </ul>
		  </td>
		</tr>
	  </table>


	<h2 id="st1-1" class="sec-title">トロントワーホリの予備知識</h2>
	<h3 class="h3-01">トロントのあゆみ</h3>
	<p class="text01">
		ヨーロッパ人が現在のトロントに移り住む以前は、原住民のヒューロン族が住んでいました。<br/>
		その後、１６世紀に入りフランス人のジャック・カルティエら探検隊がやってきて、交易をしていくうちにカナダはフランスの植民地「ヌーベル・フランス」として、以後２００年の間領有されることになりました。<br/>
		その後、植民地政策を推進するイギリスと対立するようになり七年戦争が勃発した結果、カナダはイギリスの植民地となりました。<br/>
		イギリスは当時の原住民ミシサガ族からオンタリオ湖北側、現在のトロント周辺を購入すると、開拓者を多く送り込みました。<br/>
		１７９３年、首都がこれまでのナイアガラ・オン・ザ・レイクからヨークの街に移ると、開発が進みこれがトロントの街へと変わっていきました。<br/>
	</p>

	<h3 class="h3-01">二つの公用語</h3>
	<p class="text01">
		フランスからイギリスへ植民地の権利が譲渡されてから、カナダ国内では英語とフランス語が公用語として使われてきました。<br/>
		歴史は古く、イギリスが領有してからは、イギリス人開拓者が多く住むオンタリオ湖南部の街アッパーカナダとフランス語を話す人々が住むロウアーカナダに分かれるねじれた状態がしばらく続きました。その後、時代が進み統一されたように思われましたが、ケベック分離主義を掲げるテロ活動が活発になり、一時期ケベック州は英語の使用を制限する事態にまで至り、現在でもカナダ国内でケベック州はフランス語を公用語とする唯一の州となっています。<br/>
	</p>

	<h3 class="h3-01">トロントの気候</h3>
	<p class="text01">
		カナダの位置を考えると、冬の寒さと豪雪を想像するのではないでしょうか。<br/>
		ですが、トロントでは意外にも同じ緯度の地域に比べて降雪は少なく北国の中でも住みやすいと言われております。<br/>
		季節もはっきりとしており、春には色とりどりの花が咲き、夏には３０度を超える日もありますが、日本よりも湿度が低いので過ごしやすくなっています。秋には紅葉が美しく、冬の到来は日本よりも早く、市内では雪国特有のスケートリンクが開設され、子供から大人まで楽しんでいます。
		日本との時差は１４時間で、日本に比べて高緯度に位置しています。<br/>
		それにより夏の日没の時間は遅く、２１時を過ぎてようやく日が沈み、そのことからトロントではサマータイムが導入されています。<br/>
		期間は３月８日から１１月１日となっています。<br/>
		サマータイムの間、長い昼間を利用して、ビーチや公園ではあちこちでイベントが行われたりします。<br/>
		日本では味わえない長い昼も、トロントワーホリの魅力になっています。<br/>
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'トロント';
	$number_to_display = '2';
	$start_display_from = ''; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st1-2" class="sec-title">トロントワーホリあれこれ</h2>
	<h3 class="h3-01">滞在中の生活費</h3>
	<p class="text01">
		滞在するにあたって、授業料から食費まで、海外生活が初めての人は特に気になると思われます。<br/>
		食費や交通費を諸々で考えてひと月の大体の目安は、カナダでは６～８万円ほどになります。<br/>
		月々の料金以外にも、滞在先ですぐに仕事につける保証がないので初期費用として９０万～２００万円は用意しておくと何かと困らないでしょう。<br/>
		<br/>
		カナダワーホリに必要な費用の、大まかな内容は下記のとおりです。<br/>
		・ビザの申請料<br/>
		・往復の航空券<br/>
		・海外保険<br/>
		・お小遣い<br/>
		・食費<br/>
		・授業料<br/>
		・家賃<br/>
		・交通費<br/>
		<br/>
		家賃は、バンクーバーに比べてトロントのほうが安く、相場としては４００ドルから６００ドルで、東京などに比べると中心街にしては安く住めるようになっています。ですが、安さを求めすぎると治安の悪い街を紹介されることもあるので、少々家賃が高くても安全を買うと思って居住先選びは慎重に行いましょう。<br/>
		物価は日本に比べて安く、特にコリアンタウンとチャイナタウンは豊富な食材を安く買えるので、和食の調味料も揃っているので日本食が恋しくなった時でも安心できます。<br/>
そして、日本人にとって驚くのが高い消費税。カナダでは、国の税金５％、州の税金８％、合わせて１３％の消費税を払わなければいけません。１０％でも騒いでいる日本人にはちょっと気になる税金の高さ。<br/>
		しかし、高いだけあってトロントのあるオンタリオ州では健康保険で医療行為（目と歯以外）はほぼ無料。<br/>
		この保険、市民と移民は簡単に加入することが出来るので、６ヶ月以上滞在するワーホリの強い味方になっています。<br/>
		始めは慣れない土地と習慣に戸惑うこともあると思いますが、しっかりとした予備知識をつけて、楽しく過ごせるようにしたいですね。<br/>
	</p>

	<h3 class="h3-01">トロントの習慣</h3>
	<p class="text01">
		ワーホリに限らず、海外へいくと日本と違った習慣に驚くことがあります。<br/>
		特に、治安の問題は、日本の常識では考えられないことや、国柄の事情がある地域もあったりして戸惑うこともあるでしょう。<br/>
		ですが、トロントの街の治安は良好で非常に穏やかです。<br/>
		とくに強い警戒心を必要とするわけではありませんが、夜道の一人歩きを避ける、スリや強盗が多発しているエリアをを避けるなど、最低限の危機意識を持つようにしましょう。
なお、日本でも喫煙に対して敏感になっていますが、カナダではより厳しく街では喫煙エリアを探すのに一苦労することも。ホテルなどほぼすべての建物が完全分煙されているので、万が一室内での喫煙が発覚した場合には臭いを消すためのクリーニング代を請求されたりします。もしタバコを吸うのであれば、人のいないところを探すか車の中でそっと吸うくらいにしか喫煙者の居場所はありません。吸いたくてもなかなか吸えないので、禁煙したい人にはいい機会になるかもしれません。
<br/>
	</p>

	<h2 id="st1-3" class="sec-title">トロントワーホリの制度</h2>
	<h3 class="h3-01">ワーホリの目的</h3>
	<p class="text01">
		ワーキングホリデー制度とは、お互いの国の若者が、他国の文化や生活様式を理解することを目的とした制度です。滞在期間は最長で１年間、休暇を過ごしながらその間の滞在費を働いて賄えるように整備されています。<br/>
働きながら語学を磨きたい、世界を見てみたい、観光してみたい、といった個人の目的は様々で、滞在期間中の行動は自分に決められるので、マイペースで楽しめます。
日本とカナダの間では１９８６年にこの協定が結ばれ、２０１３年にはワーホリ渡航者の数が発給数の定員である６、５００人に到達しました。年々、各国との交流を深めるためにこの制度を利用する方が増えており、語学留学や長期の観光を計画されている方には、最適の制度になっています。<br/>
	</p>

	<h3 class="h3-01">ビザ発行について</h3>
	<p class="text01">
		世界中で発行されているビザは数多くありますが、個人取得が可能なビザは実はそんなに多くありません。<br/>
		その中でもワーキングホリデービザは、個人取得が可能でフルタイムの就労が可能な唯一のビザです。<br/>
		ワーホリの申請手続きは、滞在先の各国大使館または領事館にワーキングホリデー査証を申請する必要があります。<br/>
		トロントであれば、在日カナダ大使館からワーホリの就労許可証を発行されるようになります。<br/>
		発給条件は主に<br/>
		<br/>
		１．対象とする国・地域に住む国民・住民であること。<br/>
		２．年齢が１８歳以上３１歳未満であること。<br/>
		３．一定期間、滞在先で休暇を過ごす意思があること。<br/>
		４．子どもと同伴でないこと。<br/>
		５．往復の移動費を所持していること。<br/>
		６．健康であること。<br/>
		７．これまでにこの制度を利用したことがないこと。<br/>
		<br/>
		となっています。<br/>
		観光、就労を目的としたビザで、カナダの場合は半年の就学も可能です。<br/>
		年齢制限が設けられているのは、ワーホリの目的が”青年”に国際的な視野を養ってもらうためにあるからです。<br/>

	</p>

	<h3 class="h3-01">タックスリターンって？</h3>
	<p class="text01">
		ワーホリ中に働いていた場合、タックスリターンという制度を申請すればお金が戻ってくることがあります。<br/>
		これは、働いた分の給料から税金が天引きされており、払いすぎた税金が返ってくる制度です。<br/>
		日本では年末調整を会社で行うことがほとんどですが、カナダでは個人で申請する必要があります。<br/>
		滞在中の所得は低いことが多いのでそういった場合、課税額がかからないことが多く払いすぎた分が戻ってくるのです。<br/>
		これをインカム・タックス・リターンといいます。帰国後、就職活動をする際の費用に充てられるので大変便利な制度です。<br/>
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'トロント';
	$number_to_display = '2';
	$start_display_from = '2'; //empty is begining
	display_horizontal_calendar($country_to_display,$number_to_display,$start_display_from);
?>
	<p style="text-align:right; color:green; margin-right:20px;">
	<a href="/seminar/seminar"><img src="../../../images/canausseminar.gif" title="ワーキングホリデー＆留学無料セミナー毎日開催中！"/></a>
	<a href="/seminar/seminar">＞＞＞  無料セミナー情報をもっと見る</a>
	</p>
	<div class="top-move"><p><a href="#header">▲ページのＴＯＰへ</a></p></div>


	<h2 id="st1-4" class="sec-title">トロントワーホリ中の心配事</h2>
	<h3 class="h3-01">滞在中の仕事</h3>
	<p class="text01">
		ワーホリ中の就労は、滞在期間が決められているので、働ける職場も限定されています。<br/>
		中でも人気の仕事は、日本食のレストラン、免税店、ツアーガイドなど、日本語と滞在先の語学力が使える仕事が多くなっています。<br/>
		職場探しのポイントですが、地方の田舎よりも、都市部の方が働き口が多いので、慣れるまでの間は都市部で働き、地方へ出るのは語学力に自信がついてからの方が無難です。<br/>
		語学を一緒に学びたい方は、仕事同様、都市部の方が語学学校もたくさんあるので便利だと言えます。<br/>
		そして、仕事探しで一番大切なことは積極的に応募することです。<br/>
		迷っているよりもとにかく興味があり、じぶんが頑張れそうな職場に飛び込んでみる。勢いが大切になってきます。<br/>
		海外では、履歴書の代わりに自由に自分をアピールするためのレジュメというものが存在するところもあります。
		一部の大手チェーン店では、レジュメが用意されていることもあるので、ひと目で雇用主の興味を引くような内容に工夫して応募しましょう。<br/>
		仕事を選ぶうえで、旅費を安くしたい方には、日本料理のレストランがおすすめです。<br/>
		同じ事情で日本人滞在者も集まるし、そのうえ食費をまかないで浮かせることも出来るので、生活費が心細い方にはうってつけです。<br/>
	</p>

	<h3 class="h3-01">うまく話せるか</h3>
	<p class="text01">
		自分の言葉が現地の人にちゃんと通じるか、というのが心配になると思われますが、まずはコミュニケーションをしようという気持ちが大切。
		喋らなければいけない状況に追い込まれるので、覚えるのが日本にいるときに比べれば断然早くなります。<br/>
		ですが、かんたんな日常会話程度の英語なら話せないと、仕事を探すときにも、仕事場での意思の疎通にも困るので滞在前からの準備も必要になります。
せっかくワーホリしているのだから現地の友だちも作りたい、と思われるのであれば、やはり何事も積極的に環境に溶け込むように心がけているといいでしょう。
仕事探しも友達作りも要点は一つ、あなたがどれだけ積極的に行動できるか、です。<br/>
		長い人生の中でも、短くて貴重な時間になると思うので、悔いが残らないようにしたいですね。<br/>
		少しでも心配を減らしたい方のために日本ワーキングホリデー協会では、トロントワーホリをより詳しく知るためのイベントも行っています。
		積極的に参加してみてください！！<br/>
	</p>

	<p style="color:red;text-align:center;">
	▼▼▼まずは無料セミナーへ！ワーキングホリデー＆留学の無料セミナーはこちら！▼▼▼
	</p>
<?php 
	//settings for the calendar module display
	$country_to_display = 'トロント';
	$number_to_display = '2';
	$start_display_from = '4'; //empty is begining
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
			<div class="wh_div"><a href="http://www.jawhm.or.jp/visa/v-can.html" class="wh_menu"><img src="../../../images/label_big_03.jpg"><br/>ワーホリビザの申請手順</a></div>
			<div class="wh_div"><a href="../../australia/" class="wh_menu"><img src="../../../images/label_big_04.jpg"><br/>オーストラリアのワーホリ</a></div>
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