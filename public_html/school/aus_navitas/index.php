<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='ナビタス・イングリッシュ';
$header_obj->description_page='オーストラリア：ナビタス・イングリッシュ。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

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
$header_obj->add_style='<style>
.bl	{
	color : blue;
	font-size : 10pt;
	font-weight: bold;
}
</style>
';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'ナビタス・イングリッシュ';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-aus'); ?>
	  <div id="sitemapbox">

		<table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.navitasenglish.com/" target="_blank">ナビタス・イングリッシュ<br/>（Navitas English）</a>
		</td>
		<td class="kuni">
			<a href="../aus.html"><img src="../../images/flag01.gif"><br/>Australia</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg" alt="" style="float:left; padding-right:10px;" />
			<p>
			Navitas Englishは、1981年創立のオーストラリアで最も歴史ある英語学校です。オーストラリアの主要都市にキャンパスがあり、転校も可能です。また国籍バランス、豊富な英語コース、講師の高い質、進学提携校数の多さ、学生サポートにも定評があります。放課後・週末には楽しいアクティビティも提供していて、勉強面でも生活面でも、生徒一人一人しっかりとケアをします。
			</p>
	  </div>

	  <h2 class="sec-title">ナビタス・イングリッシュの様子</h2>
	  <div id="sitemapbox">
		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td width="30px">&nbsp;</td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</table>

	  </div>

	  <h2 class="sec-title">Navitas Englishを選ぶ理由は</h2>
	  <div id="sitemapbox">

		<div class="school-subtitle">
			創立1981年の伝統校
		</div>
		<p>&nbsp;</p>
		<p>
		Navitas Englishは、1981年に創立した<span class="bl">今年31年</span>を迎えるオーストラリアの私立英語学校の中で、最も歴史ある英語学校です。浮き沈みがある語学学校業界の中で、31年間という長い年月において、常にオーストラリアで業界のリーダー的存在として、沢山の留学生そして留学会社から支持を得ていることは、その質の高さの証明です。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			選べるロケーション
		</div>
		<p>&nbsp;</p>
		<p>
		シドニーに3つのキャンパス、他にブリスベン、パース、ダーウィン、そしてメルボルンの姉妹校（Hawthorn Melbourne）を入れると<span class="bl">合計5都市7キャンパス</span>。メルボルンを除く全都市で同じカリキュラム・教材・システムを導入し転校も可能です。1都市以上で勉強したい人には最適です。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			無料片道航空券・エアーリンク
		</div>
		<p>&nbsp;</p>
		<p>
		合計20週間以上お申込の方は、メルボルンを含む他都市のキャンパスへ転校の際、学校が<span class="bl">片道航空券を無料手配</span>する嬉しいエアーリンク（Airlink）サービスがあります（利用は1回のみ）。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			講師の高い質
		</div>
		<p>&nbsp;</p>
		<p>
		Navitas Englishでは<span class="bl">英語教師トレーニング専門機関「Australian TESOL Training Centre（ATTC）」を併設</span>し、常に講師指導、英語教育の研究を行ってます。講師の採用条件は、大学卒業＋ケンブリッジCELTAまたは同等以上の資格を保持。採用後も、定期的なトレーニングの実施や校長またはシニア講師による授業審査、Student Evaluation（学生評価表）を行うことにより、講師は常に緊張感とモチベーションを保ち、質の高さを継続します。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			国籍バランスの良さ＆英語オンリーポリシー
		</div>
		<p>&nbsp;</p>
		<p>
		他校に比べて比較的ヨーロッパそして南米からの学生が多く、日本を含めたアジア、中東など<span class="bl">約50カ国以上</span>の留学生が在籍し、国際色豊かな環境の中で、英語を習得できます。校内では英語上達を早める為に、全キャンパスでて「<span class="bl">English Only Policy</span>」（母国語禁止）も徹底してます。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			豊富な英語コース
		</div>
		<p>&nbsp;</p>
		<p>
		英語コースの<span class="bl">種類が豊富</span>で、一般英語をはじめ、ビジネス英語、進学英語、ケンブリッジ試験準備、IELTS試験やTOEIC試験対策、英語教師養成（TESOL）など、希望に合う英語コースを選ぶことがっできます。現地でコース変更も可能です（一般英語以外は英語力条件有り）。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			コミュニケーションに重点をおく一般英語コース
		</div>
		<p>&nbsp;</p>
		<p>
		Navitas Englishの一般英語は、「読む・書く・話す・聞く・文法・語彙・発音・会話」など全ての項目を網羅し、それに加えて教科書だけでない実用的な“<span class="bl">使える英語</span>”を組み合わせたオリジナルのコースです。各講師は独自のオリジナル性を出して、レッスンを理解し易く、楽しくそして身につく授業を心がけます。またグループワークやペアワークの教授法を導入し、学生同士の英語を使っての<span class="bl">コミュニケーション能力も高めていく指導</span>をします。
		</p>
		<p>
		授業以外にも、毎日1時間「My Study」という、学生が自分のペースで弱点克服ができる勉強法も提供しています。「<span class="bl">My Study</span>」には、会話クラブ・Study Room（文法、語彙）・リスニング・My study サイトを使ってのオンライン学習等があります。各「My study」の教室には講師がいて、学生からの質問やアドバイスの相談に対応します。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			オーストラリアで1番を誇るダイレクトエントリー提携校数
		</div>
		<p>&nbsp;</p>
		<p>
		進学英語(Academic English)コースの規定レベルを修了すると、IELTSやTOEFLのテスト免除で、提携しているオーストラリアの有名大学やTAFE、専門カレッジへ進学することが可能です。現在<span class="bl">ダイレクトエントリーの提携校の数は50校</span>を超えて、オーストラリアで最も提携校が多い英語学校で、当校の進学英語コースの質の高さを証明しています。
		</p>
		<p>&nbsp;</p>

		<div class="school-subtitle">
			現地でのアルバイト探しをサポート・「MyJob」
		</div>
		<p>&nbsp;</p>
		<p>
		Navitas Englishでは、オーストラリアでアルバイトを探す学生のサポートをする「<span class="bl">MyJob</span>」サービスがあります（観光ビザを除く）。これは12ヶ月のメンバーシップで、オンライン上でアルバイトを探すことができ、仕事探しに役立つ様々なサポート（履歴書・カバーレター作成や面接のアドバス等）を受けられます。また期間は12ヶ月なので、コースが終了した後も継続して利用可能。「<span class="bl">MyJob</span>」メンバーシップ費用はA$250（1年間）で、ワーキングホリデー2年目申請の為のピッキング等のファームのアルバイトも斡旋します。またダーウィン校では10週間以上英語コースに申込んだ場合（観光ビザは除く）、現地でのアルバイト（職種は選べません）を保証します。特にワーキングホリデーの方にはお薦めです。
		</p>
		<p>&nbsp;</p>

        <div class="school-subtitle">
			充実した学生サポート
		</div>
		<p>&nbsp;</p>
		<p>
		各キャンパスにStudent Services Officerというスタッフが常勤し、放課後や週末のアクティビティを通じて、クラス以外でも英語を使いながら様々な国の学生と交流ができる場を提供したり、Homestayや民間寮などの宿泊手配やシェア探し、旅行計画などの相談にも応じ、学生の生活面も<span class="bl">しっかりサポート</span>します。
		</p>
		<p>&nbsp;</p>


		<div class="school-subtitle">
			語学学校ブログ
		</div>
		<p>&nbsp;</p>
		<p>
		現地情報や学校情報が盛りだくさん！
		語学学校Navitas English　公式ブログは<font color=red><a href="http://www.jawhm.or.jp/blog/australia/navitas/" title="語学学校Navitas　公式ブログ"><u>こちら</u></a></font>から

	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
