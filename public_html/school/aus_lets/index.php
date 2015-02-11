<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='レッツ';
$header_obj->description_page='オーストラリア：レッツ。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_css_files='<link href="/school/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />';
$header_obj->add_js_files='<script src="/school/lib/jquery.js" type="text/javascript"></script>
<script src="/school/src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
$("a[rel*=facebox]").facebox({
loadingImage : "../src/loading.gif",
closeImage   : "../src/closelabel.png"
})
})
</script>';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'レッツ';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-aus'); ?>
	  <div id="sitemapbox">

		<table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.letsworld.jp/" target="_blank">レッツ　（ＬＥＴＳ）</a>
		</td>
		<td class="kuni">
			<a href="../aus.html"><img src="../../images/flag01.gif"><br/>Australia</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg" alt="" style="float:left; padding-right:10px;" />
			<p>いわずと知れた初J-Shine海外認定校！講師、コース、卒業生の質の高さには定評があります。場所はタウンホール駅から徒歩２分の所にあります。学校の回りには、人気のあるカップケーキ屋さんやカフェなどがあり、放課後や休み時間などに友達とカフェで一息なんてことも出来ます。日本人のスタッフが常駐しているので、英語でも日本語でも気軽に相談出来ます。学校内でWiFiも利用出来ます。</p>

	  </div>

	  <h2 class="sec-title">学校の様子</h2>
	  <div id="sitemapbox">


<p>学校スタッフによる現地情報いっぱいのブログも是非ご覧下さい。</p>
<p>　　　LETSブログ　→　<a href="http://www.letsworld.jp/jblog/" target="_blank">http://www.letsworld.jp/jblog/</a></p>
<p>　　　Twitter　→　LETSAUSTRALIA</p>
<p>　　　Facebook　→　Steponecollege Letsaustralia</p>


		<p>&nbsp;</p>
		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</table>

	  </div>

	  <h2 class="sec-title">コースの種類が豊富なLETSには下記のようなコースがあります</h2>
	  <div id="sitemapbox">

    <div class="school-subtitle-redtext">
		１．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine）　６週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>LETSで人気ナンバー１のJ-Shineコース、即戦力を育てる為のコースです。日本で小学校英語必修化を向かえる今必要な戦力を育成すべく、様々なティーチングスキル（チャンツ、絵本、歌、フォニックス、イマ―ジョン）などを身に付けます。マイクロという実践型ロールプレイングもコース中に行っていきます。６週間中に２箇所の小学校、幼稚園など現地研修にご参加いただきます。<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/j-shine6w.htm" target="_blank">http://www.letsworld.jp/course/j-shine6w.htm</a></p>

    <div class="school-subtitle-redtext">
		２．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine）　Flex（フレックス）コース</span>
	</div>
	<p>&nbsp;</p>
	<p>通常の６週間コースを自分なりに受講スタイルをコーディネートするプログラムです。アルバイトをしながら資格を取りたい！英語コースや大学などの専門コースを受講しながらカリキュラムを消化したい人にあったコース作りが可能です。６週間コースと同様に２箇所の小学校、幼稚園などの現地研修にご参加いただきます。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/j-shineFlex.htm" target="_blank">http://www.letsworld.jp/course/j-shineFlex.htm</a><p>

    <div class="school-subtitle-redtext">
		３．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine）　経験者用３週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>既に日本で児童英語教師として１年以上働いていたことがある方用のコース、児童英語教師としての基礎スキルをかいつまんで受講し、J-Shineのカリキュラムをみっちり勉強します。コース中には、現地小学校での研修があります。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/j-shine3w.htm" target="_blank">http://www.letsworld.jp/course/j-shine3w.htm</a></p>

    <div class="school-subtitle-redtext">
		４．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine）　現職教員向け２週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>現在現職教員として小学校で働いている方向けのコース、開講日も受講しやすいように日本の夏休み時期に設定してあります。２週間で自信をもって授業が出来るように児童英語教師のティーチングを勉強し練習していただきます。コース中には、現地小学校での研修があります。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/j-shine2w.htm" target="_blank">http://www.letsworld.jp/course/j-shine2w.htm</a></p>

    <div class="school-subtitle-redtext">
		５．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成　４週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>民間の児童英語教室で働くために必要な基礎スキルを身に付けます。コース中には、現地の幼稚園もしくはデイケアセンターでの研修があります。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/tecsol4w.htm" target="_blank">http://www.letsworld.jp/course/tecsol4w.htm</a></p>

    <div class="school-subtitle-redtext">
		６．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成　２週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>児童英語教師の仕事にちょっと興味がある。短期で留学したい。という方々にお勧めのプログラムです。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/tecsol2w.htm" target="_blank">http://www.letsworld.jp/course/tecsol2w.htm</a></p>

    <div class="school-subtitle-redtext">
		７．&nbsp;&nbsp;<span style="color:navy;">児童日本語教師育成　２週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>子供に日本語を教えられるようになりたい！オーストラリアの現地小学校で日本語教師アシスタントのボランティアをしたい！という方にお勧めのプログラムです。２週間のコース終了後には、オーストラリアの現地小学校で日本語を教える事が出来るようになるスキル（指導案、アクティビティなど）を勉強します。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/tlote.htm" target="_blank">http://www.letsworld.jp/course/tlote.htm</a></p>

    <div class="school-subtitle-redtext">
		８．&nbsp;&nbsp;<span style="color:navy;">LETS TALK</span>
	</div>
	<p>&nbsp;</p>
	<p>もっと英語を流暢に話せるようになりたい！という人の為に開発されたプログラムです。実生活に起こりうる内容や様々なトピックを通じ沢山の英語表現を学びます。先生は生徒が自分自身で分からないブロークンイングリッシュを直して正しく自然な英会話を教えてくれます。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/letsTalk.htm" target="_blank">http://www.letsworld.jp/course/letsTalk.htm</a></p>

    <div class="school-subtitle-redtext">
		９．&nbsp;&nbsp;<span style="color:navy;">Phonics（発音矯正）　２週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>英語圏の小学生が学校で教わる音声学を勉強します。英語の音の理論を勉強し正しい音の発声法を学びます。また日本語には無い２字子音や２字母音も勉強します。このフォニックスの理論を勉強することにより英単語の約７５％は読めるようになると言われています。練習次第ではネイティブの言ったことも書けるようになるかも？
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/phonics.htm" target="_blank">http://www.letsworld.jp/course/phonics.htm</a></p>

    <div class="school-subtitle-redtext">
		１０．&nbsp;&nbsp;<span style="color:navy;">ビジネス英語コース２週間</span>
	</div>
	<p>&nbsp;</p>
	<p>英語圏でのビジネスシーンに欠かせない英語（英会話、挨拶や手紙、文章などのマナー、エチケットなど）を学びます。もちろん仕事を探す際にもっとも必要となる英文の履歴書やカバーレターの書き方、面接や電話などの練習も行います。
	<br/>詳しくはこちら→<a href="http://www.letsworld.jp/course/businessEnglish.htm" target="_blank">http://www.letsworld.jp/course/businessEnglish.htm</a></p>

	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>しっかり英語とスキルを身に付けたい方のための留学費用がお得になるパッケージプログラム（<a href="http://www.letsworld.jp/course/packege.htm" target="_blank">http://www.letsworld.jp/course/packege.htm</a>）もあります。</p>

	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
