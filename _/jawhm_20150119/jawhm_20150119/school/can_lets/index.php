<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='レッツ';
$header_obj->description_page='カナダ：レッツ。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
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
	  <?php echo $header_obj->breadcrumbs('school','school-can'); ?>
	  <div id="sitemapbox">

        <table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.letscanada.jp/" target="_blank">レッツ　（ＬＥＴＳ）</a>
		</td>
		<td class="kuni">
			<a href="../can.html"><img src="../../images/flag03.gif"><br/>Canada</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg"  alt="" style="float:left; padding-right:10px;" />
			<p>
			LETS カナダ校は2006 年に北米で初めて「小学校英語指導者認定協議会」（J-Shine）に認定
			された児童英語講師養成専門学校です。
			場所はカナダで一番のロケーション。ダウンタウンのど真ん中にあり、何かお買い物をする際
			も大変便利です。また最寄りの駅より徒歩３分と大変便利です。また日本人スタッフが常駐し
			ておりますので、日本語でお気軽にご相談できます。
			</p>
	  </div>

	  <h2 class="sec-title">学校の様子</h2>
	  <div id="sitemapbox">

		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</table>

	  </div>

	  <h2 class="sec-title">コースの種類が豊富なLETS には下記のようなコースがあります</h2>
	  <div id="sitemapbox">

    <div class="school-subtitle-redtext">
		１．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine）６週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>６週間のプログラムは小学校・児童英会話学校・ホームティーチングなど、どの現場でも「こども英語の先生」として活躍できる実践的な内容です。児童心理学・言語学の基礎等の講義系授業を始め、チャンツ・フォニックスなどの実践的なレッスンを通して、どのような現場にもすぐに対応できる先生を育成します。また、現地幼稚園・小学校での研修もプログラム内に含んであり、すぐに現場で活躍する事ができる先生を育成するコースです。</p>
	<br/>詳しくは→<a href="http://www.letscanada.jp/course/letscanadatecsol.htm#6" target="_blank">http://www.letscanada.jp/course/letscanadatecsol.htm#6</a><p>

    <div class="school-subtitle-redtext">
		２．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成 ４週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>民間の子供英会話教室で児童英語教師として教えたい人や、独立自営したい人のためのプログラムです。またこのコースには現地での幼稚園研修が含まれています。</p>
	<br/>詳しくは→<a href="http://www.letscanada.jp/course/letscanadatecsol.htm#0" target="_blank">http://www.letscanada.jp/course/letscanadatecsol.htm#0</a><p>

    <div class="school-subtitle-redtext">
		３．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine） 経験者用３週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>日本の児童英会話教室で一年以上働いた経験がある方対象のプログラム。児童英語コースの基礎的な内容を１週間と２週間のJ-shine カリキュラムを受講いたします。またコースには現地での研修が含まれます。</p>
	<br/>詳しくは→<a href="http://www.letscanada.jp/course/letscanadatecsol.htm#2" target="_blank">http://www.letscanada.jp/course/letscanadatecsol.htm#2</a><p>

    <div class="school-subtitle-redtext">
		４．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成（J-Shine） 現職教員向け２週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>現役の小学校教員を対象にしたプログラム。２週間で児童英語の指導方法が学べ、コース終了後には小学校英語指導者資格が取得できます。</p>
	<br/>詳しくは→<a href="http://www.letscanada.jp/course/letscanadatecsol.htm#1" target="_blank">http://www.letscanada.jp/course/letscanadatecsol.htm#1</a><p>

    <div class="school-subtitle-redtext">
		５．&nbsp;&nbsp;<span style="color:navy;">児童英語教師育成 ２週間コース</span>
	</div>
	<p>&nbsp;</p>
	<p>児童英語教師というのはどういった仕事なのかちょっとのぞいてみたい人のためのプログラムです。アルバイトやボランティアなどで英語を教えてみたい人対象。</p>
	<br/>詳しくは→<a href="http://www.letscanada.jp/course/letscanadatecsol.htm#20" target="_blank">http://www.letscanada.jp/course/letscanadatecsol.htm#20</a><p>

    <div class="school-subtitle-redtext">
		６．&nbsp;&nbsp;<span style="color:navy;">400点から始めるTOEIC</span>
	</div>
	<p>&nbsp;</p>
	<p>バイリンガル講師（日本人）が文法やリスニングのテクニックなどを、分かりやすく日本語で説明します。『今までTOEIC や英検を受けた事が無い』という方や『英語の勉強の仕方が分からない』という方でも安心して受講できるコースです。</p>
	<br/>詳しくは→<a href="http://www.letscanada.jp/course/letscanadatecsol.htm#18" target="_blank">http://www.letscanada.jp/course/letscanadatecsol.htm#18</a><p>

	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
