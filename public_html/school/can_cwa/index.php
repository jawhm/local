<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='ケンブリッジ・ウエスタン・アカデミー';
$header_obj->description_page='カナダ：ケンブリッジ・ウェスタン・アカデミー。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
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
$header_obj->fncMenuHead_h1text = 'ケンブリッジ・ウエスタン・アカデミー';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-can'); ?>
	  <div id="sitemapbox">

        <table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.cambridgecollege.com.au/" target="_blank">ケンブリッジ・ウエスタン・アカデミー　（Cambridge Western Academy）</a>
		</td>
		<td class="kuni">
			<a href="../can.html"><img src="../../images/flag03.gif"><br/>Canada</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.gif" width="270" alt="" style="float:left; padding-right:10px;" />
			<p>
			　ケンブリッジ ウェスタン アカデミー（CWA）は、オーストラリアで15年の歴史を持つCambridge International Collegeが開校した学校です。オーストラリアでは一番大きな語学学校として知られ、メルボルン・アデレード・パースの３都市に11キャンパス、イギリスではバーミングハムにキャンパスを持ち、専門コースと英語コースを合わせ、現在約５,000名の学生が通っています。この実績と経験を活かして、2010年6月にはバンクーバーに新しいキャンパスをオープンしました。 CWAはバンクーバーのダウンタウン、リチャードストリートとウェストヘイスティングストリートの角に位置しています。ウォーターフロント駅から徒歩1分、ショッピング街やレストランまで徒歩圏内にあり、どのエリアからも通学しやすい便利な場所にあります。また、きめ細やかなカウンセリング生徒全員に目を行き届かせ、仕事探し、大学への進学相談、留学生活でのサポートなどを行っている日本人カウンセラーが常駐しています。
			</p>
	  </div>

	  <h2 class="sec-title">ケンブリッジ・ウエスタン・アカデミー（CWA）の様子</h2>
	  <div id="sitemapbox">

		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</tr>
		<tr align="center">

		<td colspan="2"><b><p>▼バリスタに興味がある方はこちらをクリック▼</b></p>
		<a href="p13_lrg.jpg" rel="facebox"><img src="p13_sml.jpg"></a></td>
		</tr>

		</table>

	  </div>

	  <h2 class="sec-title">CWAのここが違う！</h2>
	  <div id="sitemapbox">

    <div class="school-subtitle">
		１．エネルギーのCWAマネージメント
	</div>
	<p>&nbsp;</p>
	<p>
		学長、マネージャー、オペレーションマネージャーなど、全体的に若く経験のあるチームで開校したCWAは、新しい目線で生徒たちがこんな環境で学びたいというニーズに合う学校つくりをしています。同時にCWAが提供できるクオリティーの高さは、生徒からの毎月寄せられる詳しいFEEDBACK、講師陣同士のクラス見学や定期的に学長によって行われるクラス参観などを通して高い質を保っています。
	</p>

    <div class="school-subtitle">
		２．J.E.E.P. インターンシップ・職種経験プログラム
	</div>
	<p>&nbsp;</p>
	<p>
	バンクーバーは世界でも最も住みやすい都市の１つだと評価されております。自然と都会が一体となった町で、海や山を眺めながら勉強や仕事をする事ができます。ケンブリッジウェスタンアカデミー（CWA）では英語を学び、バンクーバーで働く経験が得られるプログラムを開講しています。カナダでのビジネスルールやマナーを学んだ後、学校で学んだ英語を実際使えるフィールドをCWAが提供致します。
	</p>

    <div class="school-subtitle">
		３．CWA 日記
	</div>
	<p>&nbsp;</p>
	<p>
		入学時に当校のロゴが入った日記が渡され、毎日の課題として日記を付け、先生に提出します。文法、表現方法を習得し、ライティングスキルを上達させる目的の他、生徒と講師のコミュニケーションを図るツールとしても使われます。
	</p>

    <div class="school-subtitle">
		４．小人数制
	</div>
	<p>&nbsp;</p>
	<p>
		生徒全員が授業中に気軽に質問、発言ができ、講師が生徒一人一人に目が届くクラス体制を作るため、クラス人数は現在平均8名、最大1４名までの小人数制になっております。
	</p>

    <div class="school-subtitle">
		５．CWA　Activity
	</div>
	<p>&nbsp;</p>
	<p>
		CWAには専任のアクティビティーコーディネーターがいます。コーディネーターが企画するアクティビティーを毎日開催しており、世界各国から来ている学生間の交流を促し、またカナダでの生活を更に充実させるための役割を担っています。会話クラブなど英語コミュニケーション力を磨けるものから、スポーツや観光まで、自然に英語が身に付くように設計されています。
	</p>

	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
