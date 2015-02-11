<?php
require_once '../../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='インターナショナル・ランゲージ・アカデミー・オブ・カナダ（ＩＬＡＣ）';
$header_obj->description_page='オーストラリアの学校。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="/school/voice/jquery.flip.min.js"></script>
<script type="text/javascript" src="/school/voice/script.js"></script>';
$header_obj->add_css_files='<link rel="stylesheet" type="text/css" href="/school/voice/styles.css" />';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../../images/mainimg/school-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '留学・ワーホリ経験者からの声（ＩＬＡＣ）';
$header_obj->fncFacebookMeta_function=true;

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-voice'); ?>

	  <h2 class="sec-title">インターナショナル・ランゲージ・アカデミー・オブ・カナダ　からの声</h2>
	  <div id="sitemapbox">

    <div class="school-subtitle">
		卒業生からの声
	</div>
	<p>&nbsp;</p>

<p class="text01">

</p>


<p class="text01">
「すみません、外国の方からハローと言われました。」<br/>
留学する3ヶ月ほど前、海外のお客様から電話がかかってきたとき、全く聞き取れなかった私の対応です。英語で話しかけられてパニックに陥ったことを覚えています。
</p>

<p class="text01">
ところが、急きょ仕事で英語が必要になり、ILACバンクーバー校に留学することが決まりました。ILACを選んだ理由は、カリキュラムがしっかりしていること、ビジネス英会話も学べるということ、そして日本人が少ないということでした。初めはすごく不安でした。ハローしか聞き取れなかったのに、大丈夫かなあと。
</p>

<p class="text01">
入学初日に仲良くなったのは台湾人とブラジル人でした。お互いに片言の英語でのやり取りだったので、もどかしさもあるものの、海外に来たんだなあということをひしひしと感じました。<br/>
初めての授業は英文法でした。やっている内容は簡単でしたが、先生の説明が全て英語のため、全くついていけませんでした。それでも2ヶ月ほどするとだいたい先生の説明も分かるようになり、冗談を聞いて笑えるようになっていきました。
</p>

<p class="text01">
半年間の留学生活でおよそ10人近い先生のもとで学びましたが、みなさんとてもフレンドリーで親切に教えていただきました。また、日本人スタッフの方もいてくださったので、心が折れそうになるとよくカウンセリング（という名目で雑談）していただきました。<br/>
<img class="format-voice" src="./p1.jpg">
</p>

<p class="text01">
帰国してからは海外のお客様と毎日のように話していますが、ILACでいろんな国の先生や友人と会話をしていたため、いまでは物おじすることなく会話することが出来ています。<br/>
特に役に立っていると思うのが、会話の始め方やちょっとした相槌の打ち方です。これは間近で先生をずっと見てきて、そのタイミングや呼吸を体験したからこそ出来るものだと感じます。<br/>
また、各国からの留学生との出会いも大きな財産の一つです。昨年、東日本大震災の後、海外の多くの友人から温かいメッセージをもらいました。<br/>
</p>

<p class="text01">
私の場合、たった半年の留学でしたが、非常に有意義でした。もちろん、金銭的な理由や家族の都合で難しい方もいらっしゃるでしょうが、成長する良いきっかけになります。<br/>
最後に、授業初日に先生がおっしゃっていた言葉で締めさせていただきます。<br/>
</p>

<p class="text01">
Don’t be afraid! Just enjoy speaking English!
</p>

<p class="text01">
&nbsp;<br/>
この卒業生が通った、<a href="/school/can_ilac/">インターナショナル・ランゲージ・アカデミー・オブ・カナダの情報はこちらから</a>
</p>

	<div style="height:50px;">&nbsp;</div>

	</div>




















<?php
	include '../voice.php';
?>

	  <div class="top-move">
	    <p><a href="#header">▲ページのＴＯＰへ</a></p>
	  </div>
	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>