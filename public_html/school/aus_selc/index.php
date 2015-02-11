<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='シドニー・イングリッシュ・ランゲージ・センター';
$header_obj->description_page='オーストラリア：シドニー・イングリッシュ・ランゲージ・センター。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
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
$header_obj->fncMenuHead_h1text = 'シドニー・イングリッシュ・ランゲージ・センター';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-aus'); ?>
	  <div id="sitemapbox">

		<table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.selc.com.au" target="_blank">シドニー・イングリッシュ・ランゲージ・センター<br/>（Sydney English Language Centre）</a>
		</td>
		<td class="kuni">
			<a href="../aus.html"><img src="../../images/flag01.gif"><br/>Australia</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg" alt="" style="float:left; padding-right:10px;" />
			<p>
			セルクは1985年に創立したオーストラリアを代表する老舗の英語学校です。一般英語はもちろんのこと、多彩なコースと豊富なレベルをご用意しています。ワーホリの方向けには接客英語を勉強しながらコーヒー作りのプロを目指すバリスタコースがあります。何ヶ月も前から予約が一杯になる程の人気コースです！
			またセルクでは、個々の学生たちに勉強法や生活アドバイスなどといったきめ細かいサポートにも定評があります。
			</p>

		<div style="height:18px;">&nbsp;</div>
		<center>
			<a href="/school/voice/selc/"><img src="../voice/img/schoolvoice_off.gif" alt="留学・ワーホリ体験者の声"></a>
		</center>

	  </div>

	  <h2 class="sec-title">シドニー・イングリッシュ・ランゲージ・センター(SELC)の様子</h2>
	  <div id="sitemapbox">
		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td width="30px">&nbsp;</td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</table>

	  </div>


	  <h2 class="sec-title">SELCの「ココが違う。」</h2>
	  <div id="sitemapbox">

    	<div class="school-subtitle-redtext">
			History&nbsp;&nbsp;<span style="color:navy;">25年以上の伝統校</span>
		</div>
		<p>&nbsp;</p>
		<p>
		SELCは1985年創立の、オーストラリアで最も伝統と実績のある語学学校の一つとして知られています。政府認定校としてNEASに加盟し、優良な学校が加盟するEAにも所属しています。伝統校ならではの教育プログラムを求めて、世界30カ国以上の国々から留学生が集まります。これまで既に3万人以上の卒業生を輩出し、世界各国で活躍をしています。
		</p>

    	<div class="school-subtitle-redtext">
			Teachers&nbsp;&nbsp;<span style="color:navy;">実力派の講師陣</span>
		</div>
		<p>&nbsp;</p>
		<p>
		SELCは個性豊かで実力派の講師が揃っている学校として評価されています。英語講師としての資格保持者はもちろんのこと、IELTSやケンブリッジ検定の現役試験官が多数在籍しております。教授力だけではなく、アクティビティなどにも積極的に参加するフレンドリーで学生思いの講師が集まっているのも魅力です。
		</p>

    	<div class="school-subtitle-redtext">
			Courses&nbsp;&nbsp;<span style="color:navy;">多彩なコースと豊富なレベル</span>
		</div>
		<p>&nbsp;</p>
		<p>
		SELCではあらゆる環境を想定し、それぞれに応じたバラエティに富んだコースを取り揃えています。またレベルも非常に細かく設定されており、自分にぴったりのクラスで心地よく学習することができます。ほとんどのコースが同じ授業料体系で設定されているので、目的やレベルに応じてコース変更も可能です。
		</p>
		<p>&nbsp;</p>

		<p>　【SELCのコース】</p>
		<p>　　・一般英語コース</p>
		<p>　　・進学準備英語コース</p>
		<p>　　・IELTS準備コース</p>
		<p>　　・ケンブリッジ検定準備コース</p>
		<p>　　・ビジネス・コミュニケーション英語コース</p>
		<p>　　・カスタマー・サービス・コミュニケーション英語コース（バリスタ・トレーニング）</p>
		<p>　　・TESOLコース</p>

    	<div class="school-subtitle-redtext">
			Counseling&nbsp;&nbsp;<span style="color:navy;">万全なカウンセリング体制</span>
		</div>
		<p>&nbsp;</p>
		<p>
		英語学習やあらゆる面における学生の状況を把握するため、定期的に担任講師によって個別面談が行われます。担任以外にも、英語学習に関する教育カウンセラーや進学専門のガウンセラーなども在籍しており、的確なアドバイスができる体制が整っています。日本人カウンセラーも常駐しており、いざというときは日本語でも相談ができます。
		</p>

    	<div class="school-subtitle-redtext">
			Facilities&nbsp;&nbsp;<span style="color:navy;">世界トップクラスの設備</span>
		</div>
		<p>&nbsp;</p>
		<p>
		SELCでは世界でもあまり類をみない「実践型の英語教育」を行うためのさまざまな学習施設や設備を用意しています。実際のオフィスを再現したビジネス・イングリッシュ・センター、本格的なエスプレッソマシンがあるカフェ形式の教室、キッチン付きの教室などその設備は語学学校とは思えないほどです。
		</p>

    	<div class="school-subtitle-redtext">
			Location&nbsp;&nbsp;<span style="color:navy;">理想的なロケーション</span>
		</div>
		<p>&nbsp;</p>
		<p>
		シドニーはオペラハウスやハーバーブリッジがある街として知られています。SELCが位置するのは、シドニー中心地から電車で10分ほどのボンダイ・ジャンクションに学校があります。世界的にも美しいと言われるボンダイビーチの近くで、シドニーっ子に人気のあるエリアです。シドニーの都会と自然の広がるリゾートの両方を感じられるまさに絶好のロケーションにSELCはあります！
		</p>

	  </div>
	  <h2 class="sec-title">ワーキング・ホリデーでいらっしゃる皆さまへのプラン</h2>
	  <div id="sitemapbox">

		<p>SELCではこれまでたくさんのワーキング・ホリデーの学生の受入をしてきました。ワーキング・ホリデーの皆さまにご好評頂いているコースやプランをご紹介します。</p>


    	<div class="school-subtitle-redtext">
			バリスタ・トレーニングコース&nbsp;&nbsp;<span style="color:navy;">短期間で「接客のプロ」を目指すトレーニング</span>
		</div>
		<p>&nbsp;</p>
		<p>英語力に自信がない方でも受けられる、シドニーで初めてできた接客英語専門コースです。カフェやレストランなど接客業で使うコミュニケーション英語と、働く際に必要な知識と技術を習得します。接客に必要な英語も多くの実践的なレッスンを通して楽しく学べます。トレーニングでは、接客英語だけではなく、校内のカフェ施設にある本格的なコーヒーマシンを使用して各種のコーヒーの作り方をマスターします。トレーニングの終盤には、「バリスタ・サーティフィケート」「ラテアート・サーティフィケート」も取得し、オーストラリアでのアルバイト探しにも有効な資格取得ができます。</p>
		<p>地元の人も納得するおいしいコーヒーの入れ方を習得し、何よりも最高の接客ができる真のバリスタを育てるためのトレーニングです。</p>
		<p>修了生のコメントはこちらから → <a href="https://sites.google.com/a/selc.com.au/testimony_asami/" target="_blank">https://sites.google.com/a/selc.com.au/testimony_asami/</a></p>

    	<div class="school-subtitle-redtext">
			SELCワーホリパッケージプラン
		</div>
		<p>&nbsp;</p>
		<p>入学金と学費、教材費がセットになったお得なプラン！4週間から16週間まで4週刻みに料金設定がございます。長くお申し込みいただければいただくほど、よりお得に！
（バリスタトレーニング資格費用160ドルは別途申し受けます）
</p>


		<div class="school-subtitle">
			語学学校ブログ
		</div>
		<p>&nbsp;</p>
		<p>
		現地情報や学校情報が盛りだくさん！
		語学学校SELC　公式ブログは<font color=red><a href="http://www.jawhm.or.jp/blog/australia/selc/" title="語学学校SELC　公式ブログ"><u>こちら</u></a></font>から


	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
