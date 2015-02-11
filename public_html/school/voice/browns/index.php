<?php
require_once '../../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='ブラウンズ・イングリッシュ・ランゲージ・スクール';
$header_obj->description_page='オーストラリアの学校。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="/school/voice/jquery.flip.min.js"></script>
<script type="text/javascript" src="/school/voice/script.js"></script>';
$header_obj->add_css_files='<link rel="stylesheet" type="text/css" href="/school/voice/styles.css" />';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../../images/mainimg/school-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '留学・ワーホリ経験者からの声（ｉｈ）';
$header_obj->fncFacebookMeta_function=true;

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-voice'); ?>

	  <h2 class="sec-title">ブラウンズ・イングリッシュ・ランゲージ・スクール　からの声</h2>
	  <div id="sitemapbox">

    <div class="school-subtitle">
		卒業生　Ｋさん（ゴールドコーストキャンパス　フルタイム2 ヶ月）
	</div>
	<p>&nbsp;</p>

<p class="text01">
私がBROWNSを選んだ理由は無料のアクティビティが毎日あって大変充実してい
ることと、先生方の生徒に対する面倒見が良いとエージェントから聞いたからでし
た。実際通ってみると本当にその通りで、先生方は分からないことや困ったことが
あればすぐに対応してくれました。校舎もとてもモダンでオシャレですし、英語オン
リーポリシーが徹底されている事から、「もっと英語を話したい！」という意欲が増し
ました。
<br/>
帰国してからはこの経験を生かし、さらに英語を勉強したいと思います。
</p>


    <div class="school-subtitle">
		卒業生　Ｎさん（ブリスベンキャンパス　フルタイム　3 ヶ月）
	</div>
	<p>&nbsp;</p>

<p class="text01">
BROWNSの特徴は何と言っても個性豊かなスタッフに尽きると思います。初日は
緊張と不安でいっぱいでしたが、２日目には友達と笑いながら授業を受けてい
ました。それは、やはり陽気でフレンドリーなスタッフが溶け込みやすい雰囲気
をつくってくれているから。BROWNSを選んで正解だったと言えるのはスタッフ
のおかげ。残念ながら僕はコースを修了してしまいましたが、できればもっと長
くいたかったです!!
</p>


	<p>&nbsp;</p>

<center>
<img src="./p1.jpg">
<img src="./p2.jpg">
<img src="./p3.jpg">
</center>


<p class="text01">
&nbsp;<br/>
<a href="/school/aus_browns/">ブラウンズ・イングリッシュ・ランゲージ・スクールの情報はこちらから</a>
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