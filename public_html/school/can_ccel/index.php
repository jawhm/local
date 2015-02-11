<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ（CCEL）';
$header_obj->description_page='カナダ：キング・ジョージ・インターナショナル・カレッジ。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
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
$header_obj->fncMenuHead_h1text = 'カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-can'); ?>
	  <div id="sitemapbox">

        <table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.canada-english.com/" target="_blank">カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ　（Canadian College of English Language）</a>
		</td>
		<td class="kuni">
			<a href="../can.html"><img src="../../images/flag03.gif"><br/>Canada</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg" alt="" style="float:left; padding-right:10px;" />
			<p>
	・１９９１年創立以来２１年間、国際的な評価を得る伝統校 <br />
	・Languages Canada認定校、 Quality English認定校<br />
	・東日本大震災被災者救済ホーププロジェクト対象校  <br />
	・PCTIA（BC州専門学協会）認定校<br />
	・EQA（BC州教育クオリティ認定協会）認定校  <br />
	・学生数： ５００－６００名（語学、専門含む） <br />
	・アメリカに姉妹校(SCEL)あり。転校や「２カ国留学」も可能  <br />
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

	  <h2 class="sec-title">CCEL とは？</h2>
	  <div id="sitemapbox">

		<div class="school-subtitle">
			新キャンパス
		</div>
		<p>&nbsp;</p>
		<table width="100%">
		<tr>
		<td  style="background:url(ehlogo.png) no-repeat right bottom">
		<p>
		・最新設備の新校舎、ロブソン通り徒歩１分、バラード駅より徒歩２分の便利で治安の良いエリア <br />
		・学校運営本格的レストラン＆カフェバー「Ｅｈ！」、開放的な屋上パティオは最高のコミュニケーションの場<br />
		・日本人スタッフ在住<br />
		</p>
		</td>
		</tr>
		</table>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			豊かな国籍ミックス
		</div>
		<p>&nbsp;</p>
		<p>
		ヨーロッパ20％、中南米20％、中東＆アフリカ20％、アジア40％（2012年日本人率平均：13％）		</p>

		<p>&nbsp;</p>

		<div class="school-subtitle">
			課外活動
		</div>
		<p>&nbsp;</p>
		<p>
		放課後アクティビティと週末トリップ、学生サークル、会話クラブ、ボランティアの機会などもあり。
		</p>

		<p>&nbsp;</p>

		<div class="school-subtitle">
			アコモデーション
		</div>
		<p>&nbsp;</p>
		<p>
		・ホームステイ： 専任のホームステイ・コーディネーター、ランチは学校レストランで提供 <br />
		・学生寮（CCELの留学生専用、学校より徒歩10分）、朝食は学校レストランで提供<br />
		</p>

		<p>&nbsp;</p>


		<div class="school-subtitle">
			一般英語コース
		</div>
		<p>&nbsp;</p>
		<p>
		・１８時間、２４時間、３０時間から選べるコース、毎週月曜日スタート可 <br />
		・細かいレベル分け。クラスによってレベルを変えることも可能。 <br />
		・毎週行われるミニテスト, 毎月行われるレベルチェックテスト（ミシガン・テスト）と学習レポート<br /> 
		・ＳＭＲＴクラス－オーディオビジュアルを多用、ダイナミックで実践的な「使える英語」 <br />
		・豊富な午後の選択授業（カフェ・レストラン接客トレーニングクラス有り） <br />
		・申込者全員に渡航前準備オンラインプログラム（ＰＡＬ）を無料提供。留学前から英語力アップ！ <br />
		</p>

		<p>&nbsp;</p>


		<div class="school-subtitle">
			特別コース
		</div>
		<p>&nbsp;</p>
		<p>
		・ビジネス英語＋インターンシップ・パッケージ（有給・無給） <br />
		・ワーキングホリデー・プログラム（カフェ＆レストラントレーニングコースとインターン、レジュメ＆面接など） <br />
		・ＥＡＰ（アルバータ大学進学準備、その他にもＥｍｉｌｙ Ｃａｒ大学など複数のパスウェイあり） <br />
		・ＴＯＥＦＬ、ＩＥＬＴＳ、ケンブリッジ準コース <br />
		・TESOL Diplomaコース（現地小中学校で１ヶ月の実習含む） <br />
		・プライベートレッスン１時単位で受付可能） <br />
		・社会人向け、企業派遣プログラム（大手企業の研修実績多数）<br />
		</p>

		<p>&nbsp;</p>

		<div class="school-subtitle">
			専門資格取得プログラム（Canadian College）- 3ヶ月から2年のインターンシップパッケージも
		</div>
		<p>&nbsp;</p>
		<p>
		・ビジネス・マネージメント <br />
		・ホスピタリティ＆ホテルマネージメント（ＡＨ＆ＬＡ認定） <br />
		・国際貿易（ＦＩＴＴ認定） <br />
		・プロジェクトマネージメント <br />
		・ＩＴ (COMPTIA, MS Server, CISCO, RedHat) <br />
		・インターンシップ（Co-op）プログラム <br />
		・卒業後、カナダでの就労ビザ取得の可能性あり
		</p>

		<div class="school-subtitle">
			語学学校ブログ
		</div>
		<p>&nbsp;</p>
		<p>
		現地情報や学校情報が盛りだくさん！
		語学学校CCEL　公式ブログは<font color=red><a href="http://www.jawhm.or.jp/blog/canada/ccel/" title="語学学校CCEL　公式ブログ"><u>こちら</u></a></font>から

	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
