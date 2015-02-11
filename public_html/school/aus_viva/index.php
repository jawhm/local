<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='ビバ・カレッジ';
$header_obj->description_page='オーストラリア：ビバ・カレッジ。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
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
$header_obj->fncMenuHead_h1text = 'ビバ・カレッジ';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-aus'); ?>
	  <div id="sitemapbox">

        <table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.vivacollege.com/" target="_blank">ビバ・カレッジ<br/>（Viva College）</a>
		</td>
		<td class="kuni">
			<a href="../aus.html"><img src="../../images/flag01.gif"><br/>Australia</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg" alt="" style="float:left; padding-right:10px;" />
			<p>
		質の高い授業およびケアーの行き届い学校として知られているブリスベンにあるViva Collegeは1993
		年に留学生の為の英語コースを提供する学校としてスタートし、後にビジネスコースおよび英語教師訓
		練コースを設置しました。人気のコースは会話集中コースのSmart Talk、苦手なスキルを伸ばし全体
		的な英語レベルを向上させるFocus English、就職後に役立つビジネスコースです。中規模の学校だ
		から成せる、留学生それぞれが求めるサポートを提供しています。			</p>

		<div style="height:18px;">&nbsp;</div>
		<center>
			<a href="/school/voice/viva/"><img src="../voice/img/schoolvoice_off.gif" alt="留学・ワーホリ体験者の声"></a>
		</center>

	  </div>

	  <h2 class="sec-title">ビバ・カレッジ(Viva)の様子</h2>
	  <div id="sitemapbox">
		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td width="30px">&nbsp;</td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</table>

	  </div>


	  <h2 class="sec-title">Vivaのここが違う！</h2>
	  <div id="sitemapbox">

		<div class="school-subtitle">
			最高のロケーション
		</div>
		<p>&nbsp;</p>
		<p>
		Viva Collegeは交通機関へのアクセスにも非常に便利なブリスベンの中心にあるQueen Street Mallに位置しています。
		</p>

		<div class="school-subtitle">
			質の高い教育
		</div>
		<p>&nbsp;</p>
		<p>
		オーストラリアの質の高い教育を保証するNEAS およびACPET の加盟校です。
		カリキュラム、教材、学習環境、スタッフ、学生へ提供するサービス等にまで厳しい基準が設けられています。
		</p>

		<div class="school-subtitle">
			質の高い教師陣
		</div>
		<p>&nbsp;</p>
		<p>
		Viva Collegeは経験豊かな有資格の教師陣を採用しています。
		英語コースの教師陣は大学卒且つケンブリッジ大学によって認可された英語教授資格のCELTAもしく
		はDELTAを保持しています。またビジネスコース教師陣も経験豊かでオーストラリア政府認定の資格
		を保持しています。教師陣よりCatch-Upセッション(英語コース)やStudy Skillsセッション（ビジネスコー
		ス）のサポートセッションを学生に提供しています。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			徹底された英語オンリーポリシー 
		</div>
		<p>&nbsp;</p>
		<p>
		キャンパス内での徹底した英語オンリーポリシーを実施しています。このポリシーは留学に掛ける時間と費用を無駄にすることなく、効果的に英語を上達することを可能にします。
		</p>


		<div class="school-subtitle">
			充実したスタディーサポート
		</div>
		<p>&nbsp;</p>
		<p>
	Viva Collegeは学生に最大限の学習の機会を提供することに努めています。
<br /><br />

		1. 日中の英語コースを受講の学生は、無料にて夜間英語コースに参加することが可能です（条件あり）。<br />
		2. 放課後のStudy AssistanceおよびConversation Partnerでは経験豊富な教師によるライティングおよびスピーキングの更なる練習の機会を提供します。<br />
		3. 放課後そして帰宅後の自主学習をサポートする無料Online教材を提供しています。<br />
<br />
	授業で学んだ内容に加えて、更に役立つ教材、クイズ、週末のテスト等、数多く提供しています。オンラインにて学習した内容は記録され、進歩状況の確認、また担任教師よりフィードバックを得ることも可能です。

 	</p>



		<div class="school-subtitle">
			バランスの良い国籍Mix
		</div>
		<p>&nbsp;</p>
		<p>
		Viva Collegeには様々な国からの学生が在籍しており、異なる国の友人を作ることが可能です。その為、
		国籍バランスに偏りがでないよう努めています。
		</p>


		<div class="school-subtitle">
			人気コース
		</div>
		<p>&nbsp;</p>
		<p>
		• 苦手なスキルを伸ばし全体的な英語レベルを向上させるFocus English<br />
		• 会話集中コースのSmart Talk<br />
		• 就職後に役立つカスタマーサービスを含むビジネスコース<br />
<br />
		その他、試験対策コースのIELTSおよびケンブリッジ（FCE）、大学や専門学校で必要なプレゼン
		テーションやレポート作成のスキルを身に付ける進学準備コース、英語教師訓練コースも提供し
		ています。
		</p>

		<div class="school-subtitle">
			無料のサポートサービス
		</div>
		<p>&nbsp;</p>
		<p>
		Job Clubでは英文履歴書およびカバーレターの作成、インタビュースキルおよびアルバイトをする上で
		必要なTax File Numberの申請のお手伝いをしています。また、アクティビティクラブでは学生がブリス
		ベン生活を満喫できるように、様々なアクティビティを用意しています。
<br />
		また、Viva Plus Clubでは様々な短期コースを提供しています。特定のコース期間もしくはコースをお
		申し込みの学生に対し、無料にて短期コースを提供しています。（条件あり）また、全てのViva College
		の学生に対し無料のセミナーを提供し、個人指導の時間をも設けています。		</p>

		<div class="school-subtitle">
			キャンパス施設
		</div>
		<p>&nbsp;</p>
		<p>
		キャンパス内には広々としたエアコン完備の教室（23教室）、図書室、電子レンジ、冷蔵庫、自動販売
		機を含むランチルームを備えています。
		無料の高速ブロードバンドを使用した85台のコンピューターは、家族や友人と連絡を取る為に大いに
		役立つことでしょう。無料のWireless Internetアクセスも利用可能です。更にキャンパス内設置の電話
		は無料で市内通話（固定電話）ができます。		</p>

		<div class="school-subtitle">
			語学学校ブログ
		</div>
		<p>&nbsp;</p>
		<p>
		現地情報や学校情報が盛りだくさん！
		語学学校VIVA College　公式ブログは<font color=red><a href="http://www.jawhm.or.jp/blog/australia/viva/" title="語学学校VIVA　公式ブログ"><u>こちら</u></a></font>から


	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
